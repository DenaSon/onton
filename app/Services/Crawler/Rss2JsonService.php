<?php

namespace App\Services\Crawler;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Rss2JsonService
{
    protected string $baseUrl;

    protected ?string $apiKey;

    protected int $timeout;

    protected int $cacheTtl;

    public function __construct()
    {
        $this->baseUrl = config('services.rss2json.base_url');
        $this->apiKey = config('services.rss2json.api_key');
        $this->timeout = (int)config('services.rss2json.timeout', 5);
        $this->cacheTtl = (int)config('services.rss2json.cache_ttl', 300);
    }

    /**
     * Fetch and normalize feed items from rss2json API.
     *
     * @param array $options [order_by, order_dir, count]
     * @return array{feed: array|null, items: array<int, array>}
     */
    public function fetch(string $rssUrl, array $options = []): array
    {
        if (trim($rssUrl) === '') {
            throw new InvalidArgumentException('RSS URL is required.');
        }

        // flag
        $cacheEnabled = config('services.rss2json.cache_enabled');

        if (!$cacheEnabled) {
            return $this->requestAndNormalize($rssUrl, $options);
        }

        $cacheKey = $this->cacheKey($rssUrl, $options);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($rssUrl, $options) {
            return $this->requestAndNormalize($rssUrl, $options);
        });
    }

    protected function requestAndNormalize(string $rssUrl, array $options = []): array
    {
        $query = array_filter([
            'rss_url' => $rssUrl,
            'api_key' => $this->apiKey,
            'order_by' => $options['order_by'] ?? null, // pubDate | author | title
            'order_dir' => $options['order_dir'] ?? null, // asc | desc
            'count' => $options['count'] ?? null, // default 10
        ], static fn($value) => !is_null($value));

        try {
            $response = Http::timeout($this->timeout)
                ->acceptJson()
                ->get($this->baseUrl, $query);

            if (!$response->ok()) {
                Log::warning('rss2json HTTP error', [
                    'url' => $rssUrl,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return ['feed' => null, 'items' => []];
            }

            $data = $response->json();

            if (!isset($data['status']) || $data['status'] !== 'ok') {
                Log::warning('rss2json non-ok status', [
                    'url' => $rssUrl,
                    'status' => $data['status'] ?? null,
                    'error' => $data['message'] ?? null,
                ]);

                return ['feed' => null, 'items' => []];
            }

            return $this->normalize($data);
        } catch (\Throwable $e) {
            Log::error('rss2json request failed', [
                'url' => $rssUrl,
                'error' => $e->getMessage(),
            ]);

            return ['feed' => null, 'items' => []];
        }
    }

    /**
     * Normalize API response to internal structure.
     */
    protected function normalize(array $data): array
    {
        $feed = $data['feed'] ?? [];

        $feedMeta = [
            'title' => $feed['title'] ?? null,
            'url' => $feed['url'] ?? null,
            'description' => $feed['description'] ?? null,
        ];

        $items = collect($data['items'] ?? [])->map(function (array $item) {
            return [
                'guid' => $item['guid'] ?? null,
                'title' => $item['title'] ?? null,
                'author' => $item['author'] ?? null,
                'link' => $item['link'] ?? null,
                'pub_date' => $item['pubDate'] ?? null,
                'content' => $item['content'] ?? ($item['description'] ?? null),
                'thumbnail' => $item['thumbnail'] ?? null,
                'categories' => $item['categories'] ?? [],
            ];
        })->all();

        return [
            'feed' => $feedMeta,
            'items' => $items,
        ];
    }

    protected function cacheKey(string $rssUrl, array $options): string
    {
        ksort($options);

        return 'rss2json:' . md5($rssUrl . '|' . json_encode($options));
    }
}

<?php

namespace App\Services\AI;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected ?string $orgId;
    protected ?string $projectId;

    public function __construct()
    {
        $this->apiKey    = config('services.openai.key');
        $this->baseUrl   = 'https://api.openai.com/v1';
        $this->orgId     = config('services.openai.organization');
        $this->projectId = config('services.openai.project');
    }

    protected function headers(): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ];

        if ($this->orgId) {
            $headers['OpenAI-Organization'] = $this->orgId;
        }

        if ($this->projectId) {
            $headers['OpenAI-Project'] = $this->projectId;
        }

        return $headers;
    }

    /**
     * @throws ConnectionException
     */
    public function chat(array $messages, string $model = 'gpt-3.5-turbo', float $temperature = 0.6, int $maxTokens = 250): string
    {
        $response = Http::withHeaders($this->headers())
            ->timeout(60)
            ->retry(2,100)
            ->post("{$this->baseUrl}/chat/completions", [
            'model'       => $model,
            'messages'    => $messages,
            'temperature' => $temperature,
            'max_tokens'  => $maxTokens,
        ]);

        if ($response->failed()) {
            throw new \Exception("OpenAI API Error: " . $response->body());
        }

        return $response->json('choices.0.message.content');
    }

    public function listModels(): array
    {
        $response = Http::withHeaders($this->headers())->get("{$this->baseUrl}/models");

        if ($response->failed()) {
            throw new \Exception("Model list error: " . $response->body());
        }

        return $response->json()['data'];
    }
}

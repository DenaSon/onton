<?php

namespace App\Livewire\UserDashboard\Feed\Components;

use App\Services\Crawler\Rss2JsonService;
use Livewire\Attributes\On;
use Livewire\Component;
use Log;
use Mary\Traits\Toast;

class Medium extends Component
{
    use Toast;

    public bool $open = false;

    public ?string $mediumUrl = null;

    public array $items = [];

    public bool $loading = false;

    public ?string $error = null;

    public ?int $activeIndex = null;

    #[On('openMediumModal')]
    public function openMediumModal(string $mediumUrl): void
    {

        $this->resetErrorBag();
        $this->resetValidation();

        $this->error = null;
        $this->items = [];
        $this->activeIndex = null;

        $this->mediumUrl = $mediumUrl;
        $this->open = true;

        $this->loadMedium();
    }

    protected function loadMedium(): void
    {
        if (!$this->mediumUrl) {
            $this->items = [];
            $this->error = 'Medium feed URL not found.';

            return;
        }

        try {
            $this->loading = true;

            /** @var Rss2JsonService $rss */
            $rss = app(Rss2JsonService::class);

            $result = $rss->fetch($this->mediumUrl, [
                'order_by' => 'pubDate',
                'order_dir' => 'desc',
                'count' => 10,
            ]);
            $this->items = $result['items'] ?? [];
            $this->activeIndex = !empty($this->items) ? 0 : null;

            if (empty($this->items)) {
                $this->error = 'No Medium posts found for this VC.';
            }
        } catch (\Throwable $e) {
            Log::warning('Medium RSS load failed', [
                'medium_url' => $this->mediumUrl,
                'error' => $e->getMessage(),
            ]);

            $this->items = [];
            $this->activeIndex = null;
            $this->error = 'Failed to load Medium posts.';
            $this->error('Could not load Medium feed.', 'Error');
        } finally {
            $this->loading = false;
        }
    }

    public function close(): void
    {
        $this->open = false;
        $this->activeIndex = null;
    }

    public function selectPost(int $index): void
    {
        if (isset($this->items[$index])) {
            $this->activeIndex = $index;
        }
    }

    public function getActiveItemProperty(): ?array
    {
        if ($this->activeIndex !== null && isset($this->items[$this->activeIndex])) {
            return $this->items[$this->activeIndex];
        }

        return $this->items[0] ?? null;
    }

    public function render()
    {
        return view('livewire.user-dashboard.feed.components.medium');
    }
}

<?php

namespace App\Jobs;


use App\Services\Crawler\MailCrawler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class CrawlEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Job started');
        try {
            $crawler = app(MailCrawler::class)
                ->crawl('default', 'INBOX', function ($query) {
                    return $query->unseen()
                        ->since(Carbon::now()->subDays(1))
                        ->limit(1)
                        ->softFail();
                });

            \Log::info('Crawl done');

            $crawler->markAsRead()
                ->parse()
                ->saveAttachments();

            \Log::info('All done');
        } catch (\Throwable $e) {
            \Log::error('Job error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }
    }

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(10);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('CrawlEmailsJob failed', [
            'message' => $exception->getMessage(),
        ]);
    }

}

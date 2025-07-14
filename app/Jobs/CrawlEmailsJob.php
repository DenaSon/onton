<?php

namespace App\Jobs;


use App\Models\Whitelist;
use App\Services\Crawler\MailCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class CrawlEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function viaQueue(): string
    {
        return 'crawler';
    }


    public $tries = 5;
    public $backoff = [30, 60, 120];

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    protected function getWhitelistedEmails(): array
    {
        return Cache::remember('whitelist:emails', now()->addHours(8), function () {
            return Whitelist::whereNotNull('email')
                ->pluck('email')
                ->map(fn($email) => strtolower(trim($email)))
                ->unique()
                ->toArray();
        });
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {





        \Log::info('[CrawlEmailsJob] {MISSION_START} >>> ByblosCrawlerBot Has Entered The Target Zone.Crawling Initiated');
        try {
            $whiteListEmails = $this->getWhitelistedEmails();

            if (empty($whiteListEmails)) {
                \Log::warning('Whitelist emails is empty | Job Cancelled !');
                return;
            }



            $limit = 15;
            $lookbackHours = 100;

            $crawler = app(MailCrawlerService::class)
                ->crawl('default', 'INBOX', function ($query) use ($limit, $lookbackHours) {
                    return $query->unseen()
                        ->since(Carbon::now()->subHours($lookbackHours))
                        ->limit($limit)
                        ->softFail();
                });

           if ($crawler->folderIsEmpty())
           {

               return;
           }


            \Log::info('[CrawlEmailsJob] loaded: ' . count($whiteListEmails) . ' emails loaded from whitelist emails');

            $emails = $crawler->markAsRead()
                ->parse()
                ->filterByWhitelistFrom($whiteListEmails)
                ->saveAttachments()
                ->get();


            if (count($emails) > 0) {
                StoreNewsletterJob::dispatch($emails)->onQueue('storenewsletter');
                \Log::info('[CrawlEmailsJob] Dispatching StoreNewsletterJob with ' . count($emails) . ' emails.');
                \Log::notice('[CrawlEmailsJob] {MISSION_COMPLETE} >>> Operation Crawl complete. Emails delivered. Next Mission Start.');
            } else {
                \Log::notice("[CrawlEmailsJob] No emails after filtering. Dispatch skipped.");
                \Log::notice('[CrawlEmailsJob] Mission done — nothing to dispatch. [END]');
            }


        } catch (\Throwable $e) {
            \Log::error('Job error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->fail($e);
        }
    }

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(10);
    }

    public function failed(Throwable $exception): void
    {
        Log::critical('[CrawlEmailsJob] Failed permanently!', [
            'exception' => $exception->getMessage(),
        ]);

        \App\Models\User::notifyAdminsByRoleId(1, new \App\Notifications\UserSystemNotification(
            subject: 'Email Crawling Failed',
            title: 'Crawler Failure Alert',
            message: 'The email crawling job failed permanently due to an error: ' . $exception->getMessage(),
            actionUrl: url('core/log-viewer'),
            actionText: 'View Logs',
            footerText: 'This is an automated system alert from Byblos Crawler Bot.'
        ));
    }


}

<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Vc;
use App\Models\Whitelist;
use App\Notifications\UserSystemNotification;
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

    public $tries = 9;
    public $backoff = [30, 60, 120];

    public function viaQueue(): string
    {
        return 'crawler';
    }

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

    protected function crawlFolder(string $folder, array $whitelist, int $limit, int $lookbackHours): array
    {
        return app(MailCrawlerService::class)
            ->crawl('default', $folder, function ($query) use ($limit, $lookbackHours) {
                return $query->unseen()
                    ->since(Carbon::now()->subHours($lookbackHours))
                    ->limit($limit)
                    ->softFail();
            })
            ->markAsRead()
            ->parse()
            ->filterByWhitelistFrom($whitelist)
            ->saveAttachments()
            ->get();
    }

    public function handle(): void
    {
        Log::info('[CrawlEmailsJob] {MISSION_START} >>> ByblosCrawlerBot has entered the target zone. Crawling initiated.');


        if (Vc::count() === 0) {
            Log::warning('[CrawlEmailsJob] No VC entries found. Job cancelled before crawling.');
            return;
        }

        $vcWithWhitelistExists = Vc::whereHas('whitelists')->exists();

        if (! $vcWithWhitelistExists) {
            Log::warning('[CrawlEmailsJob] No VC with whitelist entries found. Job cancelled.');
            return;
        }


        try {
            $whiteListEmails = $this->getWhitelistedEmails();

            if (empty($whiteListEmails)) {
                Log::warning('[CrawlEmailsJob] Whitelist is empty. Job cancelled.');
                return;
            }

            $limit = 100;
            $lookbackHours = 1000;

            // Crawl inbox and spam folders separately
            $inboxEmails = $this->crawlFolder('INBOX', $whiteListEmails, $limit, $lookbackHours);
            $spamEmails = $this->crawlFolder('Spam', $whiteListEmails, $limit, $lookbackHours);

            // Merge results
            $emails = array_merge($inboxEmails, $spamEmails);

            Log::info('[CrawlEmailsJob] Loaded ' . count($whiteListEmails) . ' whitelisted emails.');

            if (count($emails) > 0) {
                StoreNewsletterJob::dispatch($emails)->delay(now()->addSeconds(8))->onQueue('storenewsletter');
                Log::info('[CrawlEmailsJob] Dispatching StoreNewsletterJob with ' . count($emails) . ' emails.');
                Log::notice('[CrawlEmailsJob] {MISSION_COMPLETE} >>> Operation Crawl complete. Emails delivered. Next Mission Start.');
            } else {
                Log::notice('[CrawlEmailsJob] No emails after filtering. Dispatch skipped.');
                Log::notice('[CrawlEmailsJob] Mission done — nothing to dispatch. [END]');
            }

        } catch (Throwable $e) {
            Log::error('[CrawlEmailsJob] Error: ' . $e->getMessage(), [
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

//        User::notifyAdminsByRoleId(1, new UserSystemNotification(
//            subject: 'Email Crawling Failed',
//            title: 'Crawler Failure Alert',
//            message: 'The email crawling job failed permanently due to an error: ' . $exception->getMessage(),
//            actionUrl: url('core/log-viewer'),
//            actionText: 'View Logs',
//            footerText: 'This is an automated system alert from Byblos Crawler Bot.'
//        ));
    }
}

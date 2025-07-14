<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class DispatchNewsletterForwardingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        Log::info('[NewsletterDispatchJob] Starting newsletter dispatch process...');
        $now = Carbon::now();

        try {

            User::with(['notificationSetting', 'followedVCs'])
                ->where('is_suspended', 0)
                ->whereNotNull('email_verified_at')
                ->whereHas('notificationSetting', function ($query) use ($now) {
                    $query->where(function ($q) use ($now) {
                        $q->where('frequency', 'daily')
                            ->where(function ($q2) use ($now) {
                                $q2->whereNull('last_sent_at')
                                    ->orWhere('last_sent_at', '<=', $now->copy()->subDay());
                            })
                            ->orWhere(function ($q3) use ($now) {
                                $q3->where('frequency', 'weekly')
                                    ->where(function ($q4) use ($now) {
                                        $q4->whereNull('last_sent_at')
                                            ->orWhere('last_sent_at', '<=', $now->copy()->subWeek());
                                    });
                            });
                    });
                })
                ->subscribedOrOnTrial()
                ->chunkById(100, function ($usersChunk) {
                    foreach ($usersChunk as $index => $user) {
                        try {
                            Log::info("[NewsletterDispatchJob] Ready user :  #{$user->id} ({$user->email}).");

                            SendNewsletterToUserJob::dispatch($user)
                                ->delay(now()->addSeconds($index * 5))
                                ->onQueue('send-newsletters');
                            Log::info("[NewsletterDispatchJob] Dispatched newsletter sending for user #{$user->id} ({$user->email}).");
                        } catch (\Throwable $e) {
                            Log::error("[NewsletterDispatchJob] Failed to dispatch job for user #{$user->id}: {$e->getMessage()}", [
                                'exception' => $e,
                            ]);
                        }
                    }
                });

            Log::info('[NewsletterDispatchJob] Completed newsletter dispatch process.');
        } catch (\Throwable $e) {
            Log::error('[NewsletterDispatchJob] Unexpected error during dispatch process: ' . $e->getMessage(), [
                'exception' => $e,
            ]);


        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('[NewsletterDispatchJob] Job failed permanently! Exception: ' . $exception->getMessage(), [
            'trace' => $exception->getTraceAsString(),
        ]);

        \App\Models\User::notifyAdminsByRoleId(1, new \App\Notifications\UserSystemNotification(
            subject: 'Newsletter Dispatch Failed',
            title: 'Critical: Newsletter Dispatch Job Failed',
            message: 'The automated newsletter dispatch job failed permanently. Please review the logs and take action. Exception: ' . $exception->getMessage(),
            actionUrl: url('core/log-viewer'),
            actionText: 'Check Logs',
            footerText: 'System notification'
        ));
    }

}

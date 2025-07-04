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
                ->chunkById(100, function ($usersChunk) {
                    foreach ($usersChunk as $user) {
                        try {
                            SendNewsletterToUserJob::dispatch($user)->onQueue('send-newsletters');
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

}

<?php

namespace App\Jobs;

use App\Mail\ForwardNewsletterMailable;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewsletterToUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function handle(): void
    {
        Log::warning('[SendNewsletterToUser] Start');

        try {
            $user = $this->user;

            $setting = $user->notificationSetting;

            if (!$setting) {
                logger()->warning("[SendNewsletterToUserJob] User #{$user->id} has no notification setting.");
                return;
            }

            $lastSentAt = $setting->last_sent_at ?? $user->created_at->copy()->subDays(7);
            $followedVcs = $user->followedVCs()->pluck('vcs.id');

            $newsletters = Newsletter::whereIn('vc_id', $followedVcs)
                ->where('received_at', '>', $lastSentAt)
                ->whereNotIn('id', function ($query) use ($user) {
                    $query->select('newsletter_id')
                        ->from('newsletter_user_sends')
                        ->where('user_id', $user->id);
                })
                ->get();

            if ($newsletters->isEmpty()) {
                logger()->info("[SendNewsletterToUserJob] No new newsletters for user #{$user->id}");
                return;
            }

            foreach ($newsletters as $index => $newsletter) {
                try {

                    Mail::to($user->email)
                        ->queue(
                            (new ForwardNewsletterMailable($newsletter))
                                ->delay(now()->addSeconds($index * 15))
                                ->onQueue('emails_sender')
                        );

                    $user->sentNewsletters()->attach($newsletter->id, [
                        'sent_at' => now(),
                    ]);
                } catch (\Throwable $e) {
                    logger()->error("Failed to send newsletter #{$newsletter->id} to user #{$user->id}: {$e->getMessage()}");
                }
            }


            $lastSentAt = $newsletters->whereNotNull('sent_at')->max('sent_at');

            if ($lastSentAt) {
                $setting->update([
                    'last_sent_at' => $lastSentAt,
                ]);

                logger()->info("[SendNewsletterToUserJob] Updated last_sent_at for user #{$user->id} to {$lastSentAt}.");
            } else {
                logger()->warning("[SendNewsletterToUserJob] No valid sent_at found in newsletters for user #{$user->id}, last_sent_at not updated.");
            }


        } catch (\Throwable $e) {
            logger()->error("[SendNewsletterToUserJob] Exception for user #{$this->user->id}: {$e->getMessage()}", [
                'exception' => $e
            ]);
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical("[SendNewsletterToUserJob] Failed permanently for user #{$this->user->id}: {$exception->getMessage()}");

        \App\Models\User::notifyAdminsByRoleId(1, new \App\Notifications\UserSystemNotification(
            subject: 'Newsletter Sending Failed',
            title: "Newsletter Failed for {$this->user->email}",
            message: "The system failed to send newsletters to user #{$this->user->id}. Exception: {$exception->getMessage()}",
            actionUrl: url('core/log-viewer'),
            actionText: 'Check Logs',
            footerText: 'Automated notification from newsletter dispatch system.'
        ));
    }

}

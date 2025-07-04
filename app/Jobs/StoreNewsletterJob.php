<?php

namespace App\Jobs;

use App\Models\Newsletter;
use App\Models\Whitelist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;


class StoreNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function viaQueue()
    {
        return 'storenewsletter';
    }



    protected array $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }


    public function handle(): void
    {

        if (empty($this->emails)) {
            \Log::alert('[StoreNewsletterJob] received empty emails array. Job cancelled.');
            return;
        }


        \Log::info('[StoreNewsletterJob] Started processing ' . count($this->emails) . ' emails.');
        $savedCount = 0;
        foreach ($this->emails as $email) {

            try {


                $uid = $email['__raw']->getUid();

                $from = strtolower($email['from'] ?? $email['__raw']['header']['from'] ?? '');
                Log::info('Processing Email From: ' . $from);

                $whitelist = Whitelist::with('vc')->where('email', $from)->first();

                if (!$whitelist || !$whitelist->vc) {
                    Log::warning('Whitelist not found for email: ' . $from);
                    continue;
                }

                $vc = $whitelist->vc;

                $subject = $email['subject'] ?? '';
                $decodedSubject = iconv_mime_decode($subject, ICONV_MIME_DECODE_CONTINUE_ON_ERROR, 'UTF-8') ?: $subject;


                $bodyPlain = $email['text'] ?? '';
                $bodyHtml = $email['html'] ?? '';
                $bodyHash = sha1($bodyPlain ?: $bodyHtml);
                $date = now();

                if (Newsletter::where('vc_id', $vc->id)->where('hash', $bodyHash)->exists()) {
                    Log::alert("Duplicate newsletter skipped for VC: {$vc->name}");
                    continue;
                }

                \Log::info('[StoreNewsletterJob] Processing email UID: ' . $uid . ' From: ' . $from);


                $data = [
                    'vc_id' => $vc->id,
                    'subject' => $decodedSubject ?? '(No subject)',
                    'from_email' => $from,
                    'to_email' => null,
                    'body_plain' => $bodyPlain,
                    'body_html' => $bodyHtml,
                    'sent_at' => now(),
                    'received_at' => $date,
                    'message_id' => $uid,
                    'hash' => $bodyHash,
                ];

                Newsletter::create($data);
                $savedCount++;

                \Log::info('[StoreNewsletterJob] Newsletter saved successfully for VC: ' . $vc->name);


            } catch (Throwable $e) {
                \Log::error('[StoreNewsletterJob] Failed processing email UID: ' . ($uid ?? 'unknown') . ' - ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);

                continue;
            }


        }

        if ($savedCount === 0) {
            \Log::warning('[StoreNewsletterJob] Done — All emails skipped — no newsletters were stored. [END]');
        } else {
            \Log::notice("[StoreNewsletterJob] {BYBLOS_BOT_MISSION_COMPLETE} >>> payload transferred. {$savedCount} newsletters delivered to ByblosRadar.[END]");

        }


    }

}

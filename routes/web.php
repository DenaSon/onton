<?php

use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Actions\Logout;
use App\Livewire\AdminDashboard\Documents\DocIndex;
use App\Livewire\Home\Index;
use App\Models\Newsletter;
use App\Models\Whitelist;
use App\Services\Crawler\MailCrawlerService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Webklex\IMAP\Facades\Client;


Route::get('/', Index::class)->name('home');

Route::prefix('core')
    ->as('core.')
    ->middleware(['web', 'auth', 'verified', RoleMiddleware::class . ':admin'])
    ->group(function () {
        Route::get('/', \App\Livewire\AdminDashboard\Index::class)->name('index');

        Route::get('/users', \App\Livewire\AdminDashboard\Users\UserIndex::class)->name('users.index');
        Route::get('log-viewer', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('log-viewer.index');

        Route::get('/vc-firms/create', \App\Livewire\AdminDashboard\VcFirms\VcForm::class)->name('vc-firms.create');
        Route::get('/vc-firms/', \App\Livewire\AdminDashboard\VcFirms\VcsIndex::class)->name('vc-firms.index');
        Route::get('/documents', DocIndex::class)->name('docs.index');
        Route::get('/logs/activity', \App\Livewire\AdminDashboard\Logs\ActivityLog::class)->name('activity-logs');
        Route::get('/analysis/overview', \App\Livewire\AdminDashboard\Analytics\Overview\AnalysisIndex::class)->name('analysis.overview');


    });


Route::prefix('panel')
    ->as('panel.')
    ->middleware(['web', 'auth', 'verified', RoleMiddleware::class . ':admin,user'])
    ->group(function () {
        Route::get('/', \App\Livewire\UserDashboard\Index::class)->name('index');

    });


Route::get('logout', Logout::class);


Route::get('test', function () {
    try {
        $client = Client::account('default');
        $client->connect();

        if (!$client->isConnected()) {
            return response('Cannot connect to IMAP server', 500);
        }

        $client->checkConnection();

        $folder = $client->getFolderByName('INBOX');

        $query = $folder->query()
            ->fetchOrderDesc()
            ->softFail()
            ->unseen()
            ->since(Carbon::now()->subDay(5))
            ->limit(1);

        $messages = $query->get();
        $errors = $query->errors();

        $output = [];

        foreach ($messages as $message) {
            $output[] = [
                'subject' => $message->getSubject(),
                'from' => $message->getFrom()[0]->mail ?? 'Unknown',
                'date' => $message->getDate() ?? 'Unknown',
                'body' => $message->getTextBody(),
            ];
        }

        return response()->json([
            'status' => 'success',
            'emails' => $output,
            'errors' => collect($errors)->map(fn($e) => $e->getMessage())->all(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 480);
    }
});

Route::get('crawl', function () {


    \Log::info('Job started');
    try {

        $emails = app(MailCrawlerService::class)
            ->crawl('default', 'INBOX', function ($query) {
                return $query->unseen()
                    ->since(Carbon::now()->subDays(1))
                    ->limit(1)
                    ->softFail();
            })
            ->parse()
            ->get();




        foreach ($emails as $email) {
            try {


                $uid = $email['__raw']->getUid();

                $from = strtolower($email['from'] ?? $email['__raw']['header']['from'] ?? '');
                Log::info('Processing Email From: ' . $from);

                $whitelist = Whitelist::with('vc')->where('email', $from)->first();

                if (!$whitelist || !$whitelist->vc) {
                    Log::warning('Whitelist not found for email: ' . $from);
                    return;
                }

                $vc = $whitelist->vc;

                $bodyPlain = $email['text'] ?? '';
                $bodyHtml = $email['html'] ?? '';
                $bodyHash = sha1($bodyPlain ?: $bodyHtml);
                $date = isset($email['date']) && $email['date'] instanceof \Carbon\Carbon
                    ? $email['date']->toDateTimeString()
                    : now()->toDateTimeString();


                if (Newsletter::where('vc_id', $vc->id)->where('hash', $bodyHash)->exists()) {
                    Log::info("Duplicate newsletter skipped for VC: {$vc->name}");
                    return;
                }

                $data = [
                    'vc_id' => $vc->id,
                    'subject' => $email['subject'] ?? '(No subject)',
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
                Log::info('Email Saved Successfully In Newsletters for VC: ' . $vc->name);

            } catch (\Throwable $e) {
                Log::error('ProcessNewsletterJob failed: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);

            }


        }


    } catch (\Throwable $e) {
        \Log::error(' error: ' . $e->getMessage() . '/n' . $e->getLine());

    }


});




Route::get('show',function (){

    $newsletter = Newsletter::find(1);

    return $newsletter->body_html ?? '';

});






















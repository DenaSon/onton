<?php

use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Actions\Logout;
use App\Livewire\AdminDashboard\Crawler\NewsletterIndex;
use App\Livewire\AdminDashboard\Documents\DocIndex;
use App\Livewire\Home\Index;
use App\Livewire\UserDashboard\Setting\DeliverySetting;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;


Route::get('/home', Index::class)->name('home');

Route::get('/', \App\Livewire\UserDashboard\Feed\FeedIndex::class)->name('feed.index');
Route::get('/vc/directory', \App\Livewire\UserDashboard\Vc\VcDirectory::class)->name('vc.directory');
Route::get('/vc/{slug}/{vcid}', \App\Livewire\UserDashboard\Vc\DedicatePage::class)->name('vc.dedicate');

Route::prefix('core')
    ->as('core.')
    ->middleware(['web', 'auth', 'verified', RoleMiddleware::class . ':admin'])
    ->group(function () {

        Route::get('/', \App\Livewire\AdminDashboard\Index::class)->name('index');

        Route::get('/users', \App\Livewire\AdminDashboard\Users\UserIndex::class)->name('users.index');
        Route::get('log-viewer', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('log-viewer.index');

        Route::get('/vc/create', \App\Livewire\AdminDashboard\VcFirms\VcForm::class)->name('vc-firms.create');
        Route::get('/vc/{vc}/edit', \App\Livewire\AdminDashboard\VcFirms\VcForm::class)->name('vc-firms.edit');

        Route::get('/vc/', \App\Livewire\AdminDashboard\VcFirms\VcsIndex::class)->name('vc-firms.index');
        Route::get('/documents', DocIndex::class)->name('docs.index');
        Route::get('/logs/activity', \App\Livewire\AdminDashboard\Logs\ActivityLog::class)->name('activity-logs');
        Route::get('/analysis/overview', \App\Livewire\AdminDashboard\Analytics\Overview\AnalysisIndex::class)->name('analysis.overview');
        Route::get('crawler/newsletters', NewsletterIndex::class)->name('newsletters.index');
        Route::get('crawler/newsletter-{newsletter}', \App\Livewire\AdminDashboard\Crawler\NewsletterShowDetails::class)->name('newsletter.show');

        Route::get('crawler/whitelists', \App\Livewire\AdminDashboard\Crawler\WhitelistIndex::class)->name('whitelist-index');


        //Render newsletters
        Route::get('crawler/newsletters/{id}/html', function ($id) {
            $newsletter = \App\Models\Newsletter::findOrFail($id);
            return response($newsletter->body_html)->header('Content-Type', 'text/html');
        })->name('newsletter.html');


    });


Route::prefix('panel')
    ->as('panel.')
    ->middleware(['web', 'auth', 'verified', RoleMiddleware::class . ':admin,user'])
    ->group(function () {
        Route::get('/', \App\Livewire\UserDashboard\Index::class)->name('index');

        Route::get('/profile', \App\Livewire\UserDashboard\Profile\EditProfile::class)->name('profile.edit');

        Route::get('/setting/delivery', DeliverySetting::class)->name('setting.delivery');


        Route::get('/payment/success', \App\Livewire\UserDashboard\Payment\SuccessPayment::class)->name('payment.success');
        Route::get('/payment/failed', \App\Livewire\UserDashboard\Payment\FailedPayment::class)->name('payment.failed');
        Route::get('/payment/subscription', \App\Livewire\UserDashboard\Payment\SubscriptionManagement::class)->name('payment.management');

        Route::get('/help', \App\Livewire\UserDashboard\Documents\DocIndex::class)->name('help.index');

        Route::get('newsletters/{id}/html', [\App\Http\Controllers\User\NewsletterHtmlController::class, 'show'])
            ->name('newsletterView.html');

    });

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);

Route::get('logout', Logout::class);


Route::get('/rss', function () {
    $rss = app(\App\Services\Crawler\Rss2JsonService::class);
    return $rss->fetch('https://medium.com/feed/@ekin.tuna');
});


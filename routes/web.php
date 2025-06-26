<?php

use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Actions\Logout;
use App\Livewire\AdminDashboard\Crawler\NewsletterIndex;
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
        Route::get('crawler/newsletters', NewsletterIndex::class)->name('newsletters.index');
        Route::get('crawler/newsletter-{newsletter}', \App\Livewire\AdminDashboard\Crawler\NewsletterShowDetails::class)->name('newsletter.show');


    });


Route::prefix('panel')
    ->as('panel.')
    ->middleware(['web', 'auth', 'verified', RoleMiddleware::class . ':admin,user'])
    ->group(function () {
        Route::get('/', \App\Livewire\UserDashboard\Index::class)->name('index');

    });


Route::get('logout', Logout::class);




























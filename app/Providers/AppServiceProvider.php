<?php

namespace App\Providers;

use App\Models\Cashier\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! App::environment('local')) {
            URL::forceScheme('https');
        }

        Cashier::useSubscriptionModel(Subscription::class);
        Cashier::useCustomerModel(User::class);

        Schema::defaultStringLength(125);

        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('admin');
        });

    }
}

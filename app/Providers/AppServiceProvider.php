<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Contact;
use App\Observers\UserObserver;
use App\Observers\ContactObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(120);

        User::observe(UserObserver::class);
        Contact::observe(ContactObserver::class);
    }
}

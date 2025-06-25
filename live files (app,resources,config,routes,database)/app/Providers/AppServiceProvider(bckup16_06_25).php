<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\MailSentListener;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */ protected $listen = [
        MessageSent::class => [
            MailSentListener::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LoginSuccessful'
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogOutListener'
        ],
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Share variables with all views except the root route (/)
        
    }



    
}

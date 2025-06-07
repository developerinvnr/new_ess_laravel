<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckSessionTimeout;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then:function(){
            Route::middleware('web')
            ->prefix('manage')
            ->group(base_path('routes/backend.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CheckSessionTimeout::class);
        
        $middleware->append(PreventBackHistory::class); 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();



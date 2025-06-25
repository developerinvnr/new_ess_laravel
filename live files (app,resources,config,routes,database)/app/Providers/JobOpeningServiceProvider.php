<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class JobOpeningServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Fetch and cache job openings on boot
        $jobs = Cache::get('job_openings', function () {
            $response = Http::get('https://hrrec.vnress.in/get_job_opening');
            return $response->json()['regular_job'] ?? [];
        });

        Cache::put('job_openings', $jobs);
    }
}


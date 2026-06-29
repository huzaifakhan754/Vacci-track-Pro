<?php

namespace App\Providers;

use App\Models\ParentRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer(['layouts.apex', 'partials.apex.sidebar', 'partials.apex.header'], function ($view) {
            $pendingRequestsCount = 0;

            if (auth()->check() && auth()->user()->hasRole('admin')) {
                $pendingRequestsCount = ParentRequest::where('status', 'pending')->count();
            }

            $view->with('pendingRequestsCount', $pendingRequestsCount);
        });
    }
}

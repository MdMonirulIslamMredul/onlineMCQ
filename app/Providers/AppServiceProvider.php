<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('company_settings')) {
                // Fetch company info from the database
                $company_info = DB::table('company_settings')->first();

                // Share the company info with all views
                View::share('company_info', $company_info);
            }
        } catch (\Throwable $e) {
            // Ignore errors if database is not yet migrated or reachable
        }
    }
}

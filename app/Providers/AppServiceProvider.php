<?php

namespace App\Providers;

use Inertia\Inertia;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        Inertia::share('flash', function () {
            return [
                'success' => Session::get('success'),
                'error' => Session::get('error'),
            ];
        });

        Inertia::share('appVersion', function () {
            return env('APP_VERSION', 'Not Specified');
        });



        Inertia::share('autorization', function () {
            return Auth::check()
                ? RolePermission::where('ROLE_ID', Auth::user()->ROLE_ID)->first()->toArray()
                : null;
        });

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    View::share('segments', build_segments());
	    View::composer(['auth.layouts.app', 'auth.interior.home'], function ($view) {
		    $plugins = DB::table('cms_plugins')->orderBy('display')->get();
		    $view->with('plugins', $plugins);
	    });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

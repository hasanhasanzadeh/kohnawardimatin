<?php

namespace App\Providers;

use App\Http\Middleware\LangLocale;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use RealRashid\SweetAlert\SweetAlertServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        // Get the AliasLoader instance
        $loader = AliasLoader::getInstance();

        // Add your aliases

        $loader->alias('LangLocale',  LangLocale::class);
        $loader->alias('Alert', SweetAlertServiceProvider::class);
    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        //
    }
}

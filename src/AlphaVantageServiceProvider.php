<?php

namespace Andreger\AlphaVantage;

use Illuminate\Support\ServiceProvider;

class AlphaVantageServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('stock', function() {
            return new Stock();
        });
    }
}

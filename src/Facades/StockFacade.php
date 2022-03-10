<?php

namespace Asgedev\AlphaVantage\Facades;

use Illuminate\Support\Facades\Facade;

class StockFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'stock';
    }
}

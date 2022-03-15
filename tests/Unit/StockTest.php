<?php

namespace Unit;

use Andreger\AlphaVantage\Stock;

use Andreger\AlphaVantage\Tests\TestCase;
use function PHPUnit\Framework\assertStringContainsString;

class StockTest extends TestCase
{
    /** @test */
    public function intraday()
    {
        $interval = 15;
        $stock = new Stock();
        $stock->symbol('ibm')
            ->intraday($interval);

        assertStringContainsString('TIME_SERIES_INTRADAY', $stock->getUrl());
        assertStringContainsString("interval={$interval}min", $stock->getUrl());
        assertStringContainsString('adjusted=false', $stock->getUrl());
    }

    /** @test */
    public function intradayAdjusted()
    {
        $interval = 60;
        $stock = new Stock();
        $stock->symbol('ibm')
            ->intradayAdjusted($interval);

        assertStringContainsString('TIME_SERIES_INTRADAY', $stock->getUrl());
        assertStringContainsString("interval={$interval}min", $stock->getUrl());
        assertStringContainsString('adjusted=true', $stock->getUrl());
    }

    /** @test */
    public function daily()
    {
        $stock = new Stock();
        $stock->symbol('ibm')
            ->daily();

        assertStringContainsString('TIME_SERIES_DAILY', $stock->getUrl());
    }

    /** @test */
    public function weekly()
    {
        $stock = new Stock();
        $stock->symbol('ibm')
            ->weekly();

        assertStringContainsString('TIME_SERIES_WEEKLY', $stock->getUrl());
    }

    /** @test */
    public function weeklyAdjusted()
    {
        $stock = new Stock();
        $stock->symbol('ibm')
            ->weeklyAdjusted();

        assertStringContainsString('TIME_SERIES_WEEKLY_ADJUSTED', $stock->getUrl());
    }

    /** @test */
    public function monthly()
    {
        $stock = new Stock();
        $stock->symbol('ibm')
            ->monthly();

        assertStringContainsString('TIME_SERIES_MONTHLY', $stock->getUrl());
    }

    /** @test */
    public function monthlyAdjusted()
    {
        $stock = new Stock();
        $stock->symbol('ibm')
            ->monthlyAdjusted();

        assertStringContainsString('TIME_SERIES_MONTHLY_ADJUSTED', $stock->getUrl());
    }
}

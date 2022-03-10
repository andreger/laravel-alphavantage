<?php

namespace Asgedev\AlphaVantage;

use GuzzleHttp\Client;

class AlphaVantage
{
    private const BASE_URL = 'https://www.alphavantage.co/query?';

    private $params;

    /**
     * AlphaVantage constructor.
     */
    public function __construct()
    {
        $this->params['apikey'] = env('ALPHAVANTAGE_APP_KEY');
    }

    /**
     * Set time series to intraday
     *
     * @param int $minuteInterval Supported values: 1, 5, 15, 30 and 60
     * @return $this
     */
    public function intraday(int $minuteInterval = 60)
    {
        $this->params['function'] = 'TIME_SERIES_INTRADAY';
        $this->params['interval'] = $minuteInterval . 'min';
        $this->params['adjusted'] = false;
        return $this;
    }

    /**
     * Set time series to intraday adjusted
     *
     * @param int $minuteInterval Supported values: 1, 5, 15, 30 and 60
     * @return $this
     */
    public function intradayAdjusted(int $minuteInterval = 60)
    {
        $this->params['function'] = 'TIME_SERIES_INTRADAY';
        $this->params['interval'] = $minuteInterval . 'min';
        $this->params['adjusted'] = true;
        return $this;
    }

    /**
     * Set time series to daily
     *
     * @return $this
     */
    public function daily()
    {
        $this->params['function'] = 'TIME_SERIES_DAILY';
        return $this;
    }

    /**
     * Set time series to monthly
     *
     * @return $this
     */
    public function monthly()
    {
        $this->params['function'] = 'TIME_SERIES_MONTHLY';
        return $this;
    }

    /**
     * Set time series to monthly adjusted
     *
     * @return $this
     */
    public function monthlyAdjusted()
    {
        $this->params['function'] = 'TIME_SERIES_MONTHLY_ADJUSTED';
        return $this;
    }

    /**
     * Set time series to weekly
     *
     * @return $this
     */
    public function weekly()
    {
        $this->params['function'] = 'TIME_SERIES_WEEKLY';
        return $this;
    }

    /**
     * Set time series to weekly adjusted
     *
     * @return $this
     */
    public function weeklyAdjusted()
    {
        $this->params['function'] = 'TIME_SERIES_WEEKLY_ADJUSTED';
        return $this;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     * @return $this
     */
    public function symbol(string $symbol)
    {
        $this->params['symbol'] = $symbol;
        return $this;
    }

    /**
     * Set output size to full
     *
     * @return $this
     */
    public function full()
    {
        $this->params['outputsize'] = 'full';
        return $this;
    }

    /**
     * Get API call response
     *
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getResponse()
    {
        $qs = [];
        foreach ($this->params as $key => $value) {
            $qs[] = $key . '=' . $value;
        }

        $url = self::BASE_URL . implode('&', $qs);

        $client = new Client();
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            return $response->getBody()->getContents();
        }

        return null;
    }



}

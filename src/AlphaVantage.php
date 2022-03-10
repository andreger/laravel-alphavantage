<?php

namespace Asgedev\AlphaVantage;

use GuzzleHttp\Client;

class AlphaVantage
{
    private const BASE_URL = 'https://www.alphavantage.co/query?';

    private $params;

    public function __construct()
    {
        $this->params['apikey'] = env('ALPHAVANTAGE_APP_KEY');
    }

    public function daily()
    {
        $this->params['function'] = 'TIME_SERIES_DAILY';
        return $this;
    }

    public function symbol(string $symbol)
    {
        $this->params['symbol'] = $symbol;
        return $this;
    }

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

<?php

namespace Andreger\AlphaVantage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AlphaVantage
{
    private const BASE_URL = 'https://www.alphavantage.co/query?';

    protected $params;

    /**
     * AlphaVantage constructor.
     */
    public function __construct()
    {
        $this->params['apikey'] = env('ALPHAVANTAGE_APP_KEY');
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
     * Get API call response
     * @return string
     */
    protected function getResponse(): object
    {
        try {
            $client = new Client();
            $response = $client->get($this->getUrl());

            $content = json_decode($response->getBody()->getContents());
            $error = $content->{'Error Message'} ?? null;
            if ($error) {
                throw new \RuntimeException('Error accessing server data:' . $error);
            }

            return $content;

        } catch (GuzzleException $e) {
            throw new \RuntimeException('Error accessing server data: ' . $e->getMessage());
        }
    }

    /**
     * Get API call URL
     */
    public function getUrl()
    {
        $qs = [];
        foreach ($this->params as $key => $value) {
            $qs[] = $key . '=' . $value;
        }

        return self::BASE_URL . implode('&', $qs);
    }
}

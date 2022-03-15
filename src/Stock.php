<?php

namespace Andreger\AlphaVantage;

class Stock extends AlphaVantage
{
    /**
     * Set time series to intraday
     *
     * @param int $minuteInterval Supported values: 1, 5, 15, 30 and 60
     * @return $this
     */
    public function intraday(int $minuteInterval = 60, bool $adjusted = false)
    {
        $this->params['function'] = 'TIME_SERIES_INTRADAY';
        $this->params['interval'] = $minuteInterval . 'min';
        $this->params['adjusted'] = $adjusted ? 'true' : 'false';
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
        return $this->intraday($minuteInterval, true);
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
     * Get time series quotes
     *
     * @return array|null
     */
    public function get(): ?array
    {
        $response = $this->getResponse();

        if ($property = $this->getTimeSerieProperty($response)) {

            $result = [];
            foreach ($response->$property as $index => $item) {
                $result[$index] = $this->renameProperties($item);
            }

            return $result;
        }

        return null;
    }

    /**
     * Get the quote
     *
     * @return object|null
     */
    public function quote(): ?object
    {
        $this->params['function'] = 'GLOBAL_QUOTE';

        $response = $this->getResponse();

        if ($response) {
            return $this->renameProperties($response->{'Global Quote'});
        }

        return null;
    }

    /**
     * Search for a symbol
     *
     * @param string $keywords
     * @return array
     */
    public function search(string $keywords): array
    {
        $this->params['function'] = 'SYMBOL_SEARCH';
        $this->params['keywords'] = $keywords;

        $response = $this->getResponse();

        $result = [];
        if ($response) {
            foreach ($response->bestMatches as $item) {
                $result[] = $this->renameProperties($item);
            }
        }

        return $result;
    }

    /**
     * Get the name of the time serie property
     *
     * @param object|null $object
     * @return string|null
     */
    private function getTimeSerieProperty(?object $object): ?string
    {
        $vars = get_object_vars($object);

        foreach ($vars as $key => $var) {
            if (str_contains($key, 'Time Serie')) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Remove numbers from properties names
     *
     * @param object|null $input
     * @return object|null
     */
    private function renameProperties(?object $input): ?object
    {
        if ($input) {
            $output = [];
            $properties = get_object_vars($input);
            foreach ($properties as $key => $value) {
                $keyArray = explode(" ", $key);
                $output[$keyArray[1]] = $value;
            }

            return (object)$output;
        }
        return null;
    }

}

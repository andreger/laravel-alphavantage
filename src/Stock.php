<?php

namespace Asgedev\AlphaVantage;

class Stock extends AlphaVantage
{
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

    public function quote()
    {
        $this->params['function'] = 'GLOBAL_QUOTE';

        $response = $this->getResponse();

        if ($response) {
            return $this->renameProperties($response->{'Global Quote'});
        }

        return null;
    }


    public function search(string $keywords)
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

    private function getData(?object $items): ?array
    {
        $data = [];

        if ($items) {
            foreach ($items as $date => $item) {
                $data[$date] = [
                    'datetime' => $date,
                    'open' => $item->{'1. open'},
                    'high' => $item->{'2. high'},
                    'low' => $item->{'3. low'},
                    'close' => $item->{'4. close'},
                    'volume' => $item->{'5. volume'} ?? null,
                ];
            }

            return $data;
        }

        return null;
    }
}

<?php

namespace Asgedev\AlphaVantage;

class Stock extends AlphaVantage
{
    public function get(): ?array
    {
        $response = $this->getResponse();

        if ($response) {
            $response = json_decode($response);
            $vars = get_object_vars($response);
            $property = null;

            foreach ($vars as $key => $var) {
                if (str_contains($key, 'Time Serie')) {
                    $property = $key;
                    break;
                }
            }

            if ($property) {
                return $this->getData($response->$property);
            }
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

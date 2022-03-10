<?php


namespace Asgedev\AlphaVantage;


class Stock extends AlphaVantage
{
    public function get()
    {
        $response = $this->getResponse();

        if ($response) {
            $response = json_decode($response);

            if (isset($response->{'Time Series (Daily)'})) {
                return $this->getData($response->{'Time Series (Daily)'});
            }

        }
    }

    private function getData($items)
    {
        $data = [];

        foreach ($items as $date => $item) {
            $data[$date] = [
                'date' => $date,
                'open' => $item->{'1. open'},
                'high' => $item->{'2. high'},
                'low' => $item->{'3. low'},
                'close' => $item->{'4. close'},
                'volume' => $item->{'5. volume'},
            ];
        }

        return $data;
    }
}

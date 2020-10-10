<?php


class Service_ExchangeRate
{
    /**
     * get news from man page
     */
    public function getRate(): array
    {
        $url = 'https://www.cbr-xml-daily.ru/daily_json.js';

        $request = Request::factory($url);
        $response = $request->execute();

        $rate = json_decode($response, true)['Valute'];

        return $rate;
    }
}

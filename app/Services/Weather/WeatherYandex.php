<?php

namespace App\Weather\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Log;

class WeatherYandex implements Weather
{

    /**
     * @var array [latitude, longitude]
     */
    private $position;

    /**
     * @var string url api
     */
    private $url = "https://api.weather.yandex.ru/v1/forecast?";

    /**
     * @param string $city city name
     * @return void
     */
    public function setPosition(string $city)
    {
        $listCity       = config("cities");
        $this->position = $listCity[$city]["coordinates"];
    }

    /**
     * @return int temperature
     */
    public function getTemperature()
    {
        $client = new Client();
        try {
            $result = $client->get($this->url, [
                'headers' => [
                    'Accept'           => 'application/json',
                    'X-Yandex-API-Key' => config('yandex.key'),
                ],
                'query'   => [
                    'lat'  => $this->position[0],
                    'lon'  => $this->position[1],
                    'lang' => "ru_RU",
                ]
            ])->getBody()->getContents();
            if (($decoded = json_decode($result, true)) === false) {
                Log::error('Invalid json format');
            }
            $temp = $decoded['fact']['temp'];
            return $temp;
        } catch (RequestException $e) {
            Log::error('Error - ' . Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                Log::error('Error api weather yandex - ' . Psr7\str($e->getResponse()));
            }
        }
    }
}


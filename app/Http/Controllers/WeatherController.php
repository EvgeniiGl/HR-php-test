<?php

namespace App\Http\Controllers;

use App\Weather\Services\WeatherYandex;

class WeatherController extends Controller
{
    private $weatherService;

    public function __construct(WeatherYandex $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $this->weatherService->setPosition('brynsk');
        $temperature = $this->weatherService->getTemperature();
        return view('weather/index', ['temperature' => $temperature]);
    }
}

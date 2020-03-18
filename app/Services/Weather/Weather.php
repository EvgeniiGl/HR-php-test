<?php

namespace App\Weather\Services;

interface Weather
{
    /**
     * @param string $city city name
     * @return void
     */
    public function setPosition(string $city);

    /**
     * @return int temperature
     */
    public function getTemperature();
}

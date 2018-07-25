<?php

namespace App\Api;

class WeatherResult
{
  private $data;

  public function __construct($rawWeatherData)
  {
    $this->data = $rawWeatherData;
  }

  public function getTemp()
  {
    return $this->data->main->temp;
  }

  public function getHum()
  {
    return $this->data->main->humidity;
  }

  public function getDesc()
  {
    return $this->data->weather[0]->description;
  }

  public function getImage()
  {
    return '<img src="'. $this->getImageLink() . '" width="50">';
  }

  public function getImageLink()
  {
    return 'http://openweathermap.org/img/w/' . $this->data->weather[0]->icon . '.png';
  }
}

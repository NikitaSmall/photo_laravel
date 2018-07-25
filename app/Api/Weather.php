<?php

namespace App\Api;

class Weather
{
  private $baseURL = 'https://api.openweathermap.org/data/2.5';
  private $apiKey;

  private $city;
  private $units;
  private $format;
  private $endpoint;

  private $defaultFormat = 'json';
  private $defaultUnits = 'metric';

  protected function __construct($endpoint, $cityName = null, $units = null, $format = null)
  {
    $this->apiKey = env('OPENWEATHER_API_KEY');

    $this->city = $cityName;
    $this->units = $units;
    $this->format = $format;
    $this->endpoint = $endpoint;

    $this->requestURL = $this->baseURL . $endpoint . '?appid=' . $this->apiKey;
  }

  public function city($cityName)
  {
    return new self($this->endpoint, $cityName, $this->units, $this->format);
  }

  public function units($unitsName)
  {
    return new self($this->endpoint, $this->city, $unitsName, $this->format);
  }

  public function get()
  {
    $requestURL = $this->buildURL();
    $result = $this->sendRequest($requestURL);

    return $this->parseResult($result);
  }

  public function parseResult($result)
  {
    if ($this->isXMLdataRequest())
    {
      return $this->parseXML($result);
    }

    return new WeatherResult($this->parseJSON($result));
  }

  protected function parseJSON($result)
  {
    return json_decode($result);
  }

  protected function buildURL()
  {
    $requestURL = $this->requestURL;

    if ($this->city != null) {
      $requestURL .= '&q=' . $this->city;
    } else {
      throw new \Exception("No city was passed!", 1);
    }

    $requestURL .= '&units=' . (($this->units) ? $this->units : $this->defaultUnits);

    if ($this->isXMLdataRequest()) {
      $requestURL .= '&mode=xml';
    }

    return $requestURL;
  }

  protected function isXMLdataRequest()
  {
    return ($this->format == 'xml') || (($this->defaultFormat == 'xml') && (!$this->format));
  }

  protected function sendRequest($requestURL)
  {
    return file_get_contents($requestURL);
  }

  public static function current()
  {
    return new self('/weather');
  }

  public static function forecast()
  {
    return new self('/forecast');
  }
}

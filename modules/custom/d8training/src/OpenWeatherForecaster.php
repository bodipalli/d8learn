<?php

namespace Drupal\d8training;
use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Serialization\Json;

/**
 * Class OpenWeatherForecaster.
 *
 * @package Drupal\d8training
 */
class OpenWeatherForecaster implements OpenWeatherForecasterInterface {

  private $config;
  private $http_client;

  /**
   * Constructor.
   */

  public function __construct( ConfigFactory $config, Client $http_client) {

	  $this->config = $config; 
	  $this->http_client = $http_client; 
  }


 

  public function fetchWeatherData($city_name) {

  	// http://api.openweathermap.org/data/2.5/forecast/city?id=524901&APPID=2ae6e13f8875b87d47454e897e6da198
      
    $appid = "2ae6e13f8875b87d47454e897e6da198"; 

  	$url = "http://api.openweathermap.org/data/2.5/forecast/city";
  	
  	$queryparam = "?q=" . $city_name . "&APPID=" . $appid;
    
    $url = $url.$queryparam;

    //$url = "http://api.openweathermap.org/data/2.5/forecast/city?id=524901&APPID=2ae6e13f8875b87d47454e897e6da198";
  	
  	$client = new \GuzzleHttp\Client();

	$res = $client->request('GET', 	$url);
	$data = $res->getBody()->getContents();
	$return_data = Json::decode($data);

    return $return_data;
    
  }

}

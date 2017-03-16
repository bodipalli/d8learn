<?php

namespace Drupal\d8training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8training\OpenWeatherForecaster;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;



/**
 * Provides a 'WeatherBlock' block 
 *
 * @Block(
 *  id = "weather_block",
 *  admin_label = @Translation("Weather block"),
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface
{
	
   private $Weather;
   public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherForecaster $Weather){
  	 parent::__construct($configuration, $plugin_id, $plugin_definition);	
  	 $this->Weather = $Weather;


  }

 public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		
	  return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('d8training.openweatherforecaster')
	 );
  }

	
	public function defaultConfiguration() {

		return array ( 'city_name'=>$this->t('Please Enter Your City Name') );

	}

	public function blockForm($form, FormStateInterface $form_state) {
	    
	   
	  $form['city_name'] = array(
	    '#type' => 'textfield',
	    '#default_value'=> $this->configuration['city_name'],
	    '#title' => t('City Name'),
	    '#required' => TRUE,
	  );  
    
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

 public function build() {
	 
	$city_name = $this->configuration['city_name'];
   //$data =  $this->Weather->fetchWeatherData($city_name);
  //return $data;
	 return array (
	    '#theme'=>'weather_widget',
	    //'#weather_data'=> $data,
	    '#weather_data'=> 'im here',
	    '#attached'=>  array('library'=>'d8training/weather_widget' )
	    
	   );
  }

  public function blockSubmit($form, FormStateInterface $form_state){
  	$this->configuration['city_name'] = $form_state->getValue('city_name');
  }

}



 



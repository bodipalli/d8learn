<?php

namespace Drupal\d8training\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
* 
*/
class EventManager implements EventSubscriberInterface 
{	
	public static function getSubscribedEvents(){
    $events[KernelEvents::RESPONSE][] = array('addEvents');
    return $events;
    
	}
	public function addEvents(FilterResponseEvent  $filterRsevent){

		$response = $filterRsevent->getRespone();
    $response->headers->add(['Acces-Control-Allow-Origin'] => '*');

  }
}
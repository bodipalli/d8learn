<?php

namespace Drupal\d8training\Controller;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;


class Querychecker implements AccessInterface {
  
  public function access(Request $request) {
    $query = $request->getQueryString();
    if ( $query ) 
      return AccessResult::allowed()->cachePerPermissions();
	  
    else return AccessResult::forbidden();
  }
}
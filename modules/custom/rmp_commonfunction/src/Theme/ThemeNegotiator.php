<?php

namespace Drupal\rmp_commonfunction\Theme;
 
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
 

class ThemeNegotiator implements ThemeNegotiatorInterface {
 

  public function applies(RouteMatchInterface $route_match) {
	return true;
  }
 

  public function determineActiveTheme(RouteMatchInterface $route_match) {
	  $route = $route_match->getRouteObject();
	  $path = $route->getPath();
	  $path_list = array('/admin/structure/pursuit/add',
                    	 '/admin/structure/pursuit/{pursuit}/edit',
						 '/admin/structure/pursuit/{pursuit}',
						 '/admin/people/create',
						 '/user/{user}/edit',
						 '/user/{user}',
						 '/admin/structure/project/{project}/edit',
						 '/admin/structure/project/{project}');
						 
	  if(in_array($path, $path_list)){
		  return 'business';
	  }
	  
  }
  
  
}

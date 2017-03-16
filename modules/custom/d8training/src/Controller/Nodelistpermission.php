<?php
namespace Drupal\d8training\Controller;

use \Drupal\node\Entity\NodeType;

class Nodelistpermission{
	public function getPermissions(){
    $types = NodeType::loadMultiple();
    $permissions = [];
    //dsm($types) ;
    foreach ($types as $type) {
      # code...
      $name = $type->get('name');
      $permissions['d8 train permissions'] =  array( 'title'=>$name, 'description'=>$name); 
		}
    return $permissions;
	}	
}
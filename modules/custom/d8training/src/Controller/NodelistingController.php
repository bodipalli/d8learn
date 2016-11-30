<?php
namespace Drupal\d8training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Database\Driver\mysql\Connection;


class NodelistingController extends ControllerBase {
   
   private $database; 

   public function __construct(Connection $database){
    
      $this->database = $database;

  }

 public static function create(ContainerInterface $container) {
///$container->get('logger.dblog'),
   
return new static($container->get('database')
	       
	);
   }

  public function contenttabone() { 
    
    $recs = $this->database->select('node', 'n')
         ->fields('n', array())
         ->execute()->fetchAssoc();	  
//   $header = array(
//    array('data'=> 'NId', 'field'=>'n.nid'),
//    array('data'=> 'Title', 'field'=>'n.title'),
//    );
// "#theme"=>'table',
//   "#rows"=>$recs,
//   "#header"=>$headers,
//  );	

    return array (
	    '#theme'=>'item_list',
	    '#items'=> $recs,
	   );
  }

   public function contenttabtwo() { 
	  
	  return array (
	    '#theme'=>'item_list',
	    '#items'=> array(58,59),
	   );

	  }

 public function contentshowtwo($arg) { 
  
  return array (
    '#theme'=>'item_list',
    '#items'=> array('Hello '.$arg.' How are you?',4),
   );

  }


 public function contentshowthree( NodeInterface $node) { 
  
	$node->setTitle('Hey Braham !!');

  return array (
    '#theme'=>'item_list',
    '#items'=> array($node->getTitle(),5),
   );
   // $options = array($node->getTitle() );
   //  return new JsonResponse($options);

//$response = new Response();
//$response->setContent(json_encode(array('hello' => 'world', 'goodbye' => 'world')));
//$response->headers->set('Content-Type', 'application/json');
//return $response;

  }


}

<?php

namespace Drupal\rmp_resource_mapping_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use \Symfony\Component\HttpFoundation\Response;

/**
 * Class BackendTask.
 *
 * @package Drupal\rmp_resource_mapping_form\Controller
 */
class BackendTask extends ControllerBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Updatedata.
   *
   * @return string
   *   Return Hello string.
   */
  public function updatedata($tagging_id) {	
	
	$tagging = entity_load('tagging' , $tagging_id);
    $tagging->set("active", 0);		
    $tagging->save();
    $tagging = $tagging->id();	

	$build[] = array(
      '#type' => 'markup',
      '#markup' => $tagging_id,
    );
    return new Response(render($tagging_id));
	
	
  }

}

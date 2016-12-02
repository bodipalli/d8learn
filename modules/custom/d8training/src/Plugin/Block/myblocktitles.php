<?php

namespace Drupal\d8training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

use Drupal\user\Plugin\views\argument_default;


/**
 * Provides a 'myblocktitles' block.
 *
 * @Block(
 *  id = "myblocktitles",
 *  admin_label = @Translation("Myblocktitles"),
 * )
 */
class myblocktitles extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  private $curuser;
  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        Connection $database
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }



  /**
   * {@inheritdoc}
   */
  public function build() {

   // $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
   // $email = $curuser->getEmail();

$email = \Drupal::currentUser()->getEmail();



    $header = array(
        // The header gives the table the information it needs in order to make
        // the query calls for ordering. TableSort uses the field information
        // to know what database column to sort by.
          array('data' => t('title'), 'field' => 'n.title'),
          
      );

    // SELECT `nid`, `vid`, `type`, `langcode`, `title`, `uid`, `status`, `created`, `changed` FROM `node_field_data` ORDER BY `node_field_data`.`created` ASC 

      // Using the TableSort Extender is what tells  the query object that we
      // are sorting.
      $query = $this->database->select('node_field_data', 'n')
          ->extend('Drupal\Core\Database\Query\TableSortExtender');
      //$query->fields('n', array('n.nid', 'n.title', 'n.uid'));
      $query->fields('n', array( 'nid', 'title',  'type'));

      // Don't forget to tell the query object how to find the header information.
      $result = $query
          ->orderBy('n.created', 'DESC')
         ->range(0, 3)
          //->orderByHeader($header)
          ->execute();

      $rows = array();
      foreach ($result as $row) {
        // Normally we would add some nice formatting to our rows
        // but for our purpose we are simply going to add our row
        // to the array.
        $rows[] = array('data' => (array)$row);

        $cache_tags[] = $row->type.':'.$row->nid; 
      }

      $cache_tags[]= 'node_list';
      //$cache_tags[]= array('user_contexts'>'user');


      // Build the table for the nice output.
      $build = array(
          '#markup' => '<p>' . t('My Blocktitles.') . $email.'</p>',
      );
      $build['tablesort_table'] = array(
          '#theme' => 'table',
          '#cache'=> array('tags'=>$cache_tags), 
          '#context'=> array('user'),
          '#rows' => $rows,
      );

      return $build;



  //  $build = [];
    //$build['myblocktitles']['#markup'] = 'Implement myblocktitles.';
    

    //return $build;
  }

}





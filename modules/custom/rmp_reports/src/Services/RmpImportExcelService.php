<?php

namespace Drupal\rmp_reports\Services;
use Drupal\Core\Database\Driver\mysql\Connection;
require_once 'Excel_Reader.php';

/**
 * Class RmpImportExcelService.
 *
 * @package Drupal\rmp_reports
 */
class RmpImportExcelService {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Constructor.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * Read Excel.
   */
  public function spreadsheetExcelReader($file_name_with_extention) {
    $data = new Spreadsheet_Excel_Reader($file_name_with_extention);
    return $data;
  }
  
  public function getTaxnomytermid($vocabularyname, $termText ){
   
   if ($vocabularyname &&  $termText){
      //get the resource_status taxonomy terms
      $terms = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadTree($vocabularyname, 0, NULL, FALSE);
      foreach ($terms as $term) {
        if ( $term->name == $termText ) {
         return $term->tid;
        }
      }
    }
    return '';  
  }

}

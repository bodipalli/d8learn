<?php

namespace Drupal\rmp_reports\Services;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Class RmpResourceUtilizationService.
 *
 * @package Drupal\rmp_reports
 */
class RmpResourceUtilizationService {

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
   * Lead Transaction Report Listing.
   *
   */
  public function resourceUtilizationPracticeViewReportList($fresher_status = '') {
    //get the practice taxonomy terms
    $practice_terms = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadTree('practice', $parent = 0, $max_depth = NULL, $load_entities = FALSE);
    foreach ($practice_terms as $term) {
      $practice[$term->tid] = $term->name;
    }
    $resource_status_terms = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadTree('resource_status', $parent = 0, $max_depth = NULL, $load_entities = FALSE);
    foreach ($resource_status_terms as $term) {
      $practice[$term->tid] = $term->name;
    }

    $header = [
      ['data' => 'Practice']
    ];
    $rows = [];
    foreach ($resource_status_terms as $term) {
      $header[] = ['data'=> $term->name];
    }
    $header[] = ['data'=> 'Grand Total'];
    $header[] = ['data'=> 'Utilization %'];    
    $i = 0; $j = 0;
    $sums = '';
    $avg = '';
    $avgs = [];          
    $totals = [];
    foreach ($practice_terms as $term) {
      $practice_term_id = $term->tid;
      $rows[$i] = ['data'=> [$term->tid => $term->name]];
      $avg = 0;
      foreach ($resource_status_terms as $status_terms) {
        $resource_status_term_id = $status_terms->tid;
        //Get resource count
        $count = $this->getResourceCountByPracticeAndStatus($practice_term_id, $resource_status_term_id, $fresher_status);
        $rows[$i]['data'][$status_terms->name] = !empty($count)? $count: '';
        $sums[$j][$status_terms->name] = $count;
        $totals[$status_terms->name] = '';
        $avg += $count;
      }
      $avgs[] = $avg;
      $rows[$i]['data']['GrandTotal'] =  !empty($avg)? $avg : '';
      if (!empty($rows[$i]['data']['Billing']) && !empty($rows[$i]['data']['GrandTotal'])) {
        $avg_util_data = round(($rows[$i]['data']['Billing'] / $rows[$i]['data']['GrandTotal']) * 100, 2);
        $utilization_color = '';
        if ($avg_util_data > 80) {
          $utilization_color = 'utilization-green';
        }
        else if ($avg_util_data < 80) {
          $utilization_color = 'utilization-red';
        }
        $rows[$i]['data']['Utilization'] = array('data' => $avg_util_data . ' %', 'class' => array($utilization_color));
      }
      else {
        $rows[$i]['data']['Utilization'] = '';
      }
      $i++;
      $j++;
    }
    //Build Last row total logic
    foreach ($sums as $sum) {
      foreach ($sum as $key => $tol) {
        if (isset($sum[$key])) {
          $totals[$key] += $sum[$key];
        }        
      }
    }
    //Build Last row logic for table
    $row_data = $rows;
    foreach ($row_data as $row) {
      $data = $row['data'];
      foreach ($data as $key => $value) {
        if (is_numeric($key)) {
          $rows[$i]['data']['Practice'] = 'Grand total';
        }
        else if ($key != 'GrandTotal' && $key != 'Utilization'){
          $rows[$i]['data'][$key] = !empty($totals[$key])? $totals[$key] : '';
        }
      }
    }
    $rows[$i]['data']['GrandTotal'] = !empty($avgs)? array_sum($avgs) : '';
    if (!empty($rows[$i]['data']['Billing']) && !empty($rows[$i]['data']['GrandTotal'])) {
      $avg_util_data = round(($rows[$i]['data']['Billing'] / $rows[$i]['data']['GrandTotal']) * 100, 2);        
      $utilization_color = '';
        if ($avg_util_data > 80) {
          $utilization_color = 'utilization-green';
        }
        else if ($avg_util_data < 80) {
          $utilization_color = 'utilization-red';
        }
        $rows[$i]['data']['Utilization'] = array('data' => $avg_util_data . ' %', 'class' => array($utilization_color));
    }
    else {
      $rows[$i]['data']['Utilization'] = '';
    }
    //Create Table
    $form['resource_table'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => 'No Record found.',
    ];
    return $form;
  }
  
  /**
   * Get Resource Count By Practice And Status.
   *
   */
  public function getResourceCountByPracticeAndStatus($practice_term_id = '', $resource_status_term_id = '', $fresher_status = '') {
    $count = '';
    if (!empty($practice_term_id)) {
      //Get all existing resources
      /* $query = \Drupal::entityQuery('user');
      $query->condition('status', 1);
      $query->condition('field_practice', $practice_term_id);
      
      if (!empty($resource_status_term_id)) {        
        $query->condition('field_current_status', $resource_status_term_id);
      }
      if (!empty($fresher_status)) {
        $query->condition('field_fresher', $fresher_status);
      }
      //Execute QUERY
      $resources = $query->execute();
      if (!empty($resources)) {
        $count = count($resources);
      } */
      $values['status'] = 1;
      $values['field_practice'] = $practice_term_id;
      if (!empty($resource_status_term_id)) {
        $values['field_current_status'] = $resource_status_term_id;
      }
      if (!empty($fresher_status)) {
        $values['field_fresher'] = $fresher_status;
      }

      //Load all users
      $users = \Drupal::entityTypeManager()->getStorage('user')->loadByProperties($values);
      $count = 0;
      foreach($users as $user) {
        $user_roles_data = $user->getRoles();
        if (count($user_roles_data) == 1 && in_array('administrator' , $user_roles_data)) {
          //FIXME
        }
        $count++;
      }
    }

    return $count;
  }
}

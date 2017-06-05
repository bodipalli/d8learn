<?php

namespace Drupal\rmp_reports;
use Drupal\rmp_reports\Services\RmpImportExcelService;


/**
 * Class RmpCreateUserFromExcel.
 *
 * @package Drupal\rmp_reports
 */
class RmpCreateUserFromExcel {

  public static function userCreate($data, &$context){
    $message = 'Creating User...';
    $results = array();
    $row = 0;
    for($i = 0; $i < count($data->sheets); $i++) // Loop to get all sheets in a file.
    { 
      if(count($data->sheets[$i]['cells']) > 0) // checking sheet not empty
      {
        for($j = 1; $j <= count($data->sheets[$i]['cells']); $j++) // loop used to get each row of the sheet
        {
          for($k = 1; $k <= count($data->sheets[$i]['cells'][$j]); $k++) // This loop is created to get data in a table format.
          {
            $results[$row][] = $data->sheets[$i]['cells'][$j][$k];
          }
          $row++;
        }
      }
    }
     
    
    // $results have all data.
    $context['message'] = $message;
    //$context['results'] = $results;
    /**
     * //Written by Prabhakar. Start
     */
    unset($results[0]);
    foreach($results as $eachrec ) {
         
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $user = \Drupal\user\Entity\User::create();
     
      $mail = $eachrec[2];
      
      // Mandatory.
      $user->setPassword('Test@123');
      $user->setEmail($mail);
      $user->setUsername($mail);
      $user->set('field_emp_id', $eachrec[0]);
      
      $emp_fullname = explode(",", $eachrec[1]);
      $user->set('field_first_name', $emp_fullname[0]);      
      $user->set('field_last_name', $emp_fullname[1]);
      //$user->set('field_last_name', $emp_fullname[1]);
      //$user->set('field_last_name', $emp_fullname[1]);
      //$user->set('field_last_name', $emp_fullname[1]);
      
      
      $user->set('preferred_admin_langcode', $language);     
      // Optional.
      $user->set('init', 'email');
      $user->set('langcode', $language);
      $user->set('preferred_langcode', $language);
      $user->set('preferred_admin_langcode', $language);
           
      $field_primary_skill_termid = \Drupal::service('rmp_reports.import_excel')->getTaxnomytermid('primary_skills', $eachrec[12]);
      $user->set('field_primary_skill', $field_primary_skill_termid );
      
      $field_current_status_termid = \Drupal::service('rmp_reports.import_excel')->getTaxnomytermid('resource_status', $eachrec[22]);
      $user->set('field_current_status', $field_current_status_termid );
      
      $field_practice_termid = \Drupal::service('rmp_reports.import_excel')->getTaxnomytermid('practice', $eachrec[10]);
      $user->set('field_practice', $field_practice_termid );
      
      //$field_location_termid = \Drupal::service('rmp_reports.import_excel')->getTaxnomytermid('practice', $eachrec[10]);
      //$user->set('field_location', $field_location_termid );
      
       //$field_delivery_region_termid = \Drupal::service('rmp_reports.import_excel')->getTaxnomytermid('practice', $eachrec[10]);
      //$user->set('field_location', $field_delivery_region_termid );
      
      // field_grade field_delivery_bu   
       
       
      $hire_date = str_replace('/', '-', $eachrec[8]);   
      $user->set('field_date_of_joining', $hire_date );
      $user->addRole('employee');
      $user->activate();
      // Save user account.
      if ( $eachrec[0] ) {
        $user->save();
      }
    }
    
    /**
     * Written by Prabhakar. End//
     */
   
  }

  function userCreateFinishedCallback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One post processed.', '@count posts processed.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }
  
 /* public static function getTaxnomytermid($vocabularyname, $termText ){
   
   if ($vocabularyname &&  $termText){
      //get the resource_status taxonomy terms
      $terms = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadTree($vocabularyname, 0, NULL, FALSE);
      foreach ($terms as $term) {
        if ( $term->name == $termText ) {
          return $termid = $term->tid;
        }
      }
    }
    return '';  
  } */ 
 
}
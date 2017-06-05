<?php

namespace Drupal\rmp_resource_import\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ResourceimportController.
 *
 * @package Drupal\rmp_resource_import\Controller
 */
class ResourceimportController extends ControllerBase {
  /**
   * Resourceimporter.
   *
   * @return string
   *   Return Hello string.
   */
  public function resourceimporter() {
    
    if ( user_load_by_mail($mail) {
      
    }
    else {
      
      $userNamefromImport = 'pbodipal'; 
      $userEmailfromImport = 'prabha@gmail.com';
      $pass = 'Test@123';

      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      // $user = \Drupal\user\Entity\User::create();
      $user = new \Drupal\user\Entity\User;

      // Mandatory.
      $user->setPassword($pass);
      // $user->enforceIsNew();
      $user->setEmail($userEmailfromImport);
      $user->setUsername($userNamefromImport);
      $user->set("field_emp_id", '75038');

      // Optional.
      $user->set('init', 'email');
      $user->set('langcode', $language);
      $user->set('preferred_langcode', $language);
      $user->set('preferred_admin_langcode', $language);
      //$user->set('setting_name', 'setting_value');
      //$user->addRole('rid');
      $user->activate();

      // Save user account.
      $result = $user->save();
       
    }
    
    
    
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: resourceimporter')
    ];
  }

}

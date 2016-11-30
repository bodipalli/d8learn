<?php 

namespace Drupal\d8training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Database\Driver\mysql\Connection;

use Drupal\d8training\FormManager;


class SimpleForm extends FormBase  {

   /*private $database; 
   
   public function __construct(Connection $database){
        $this->database = $database;
   }
 
  public static function create(ContainerInterface $container) {
     return new static($container->get('database'));
  }

  */
  private $form_mgr; 

   public function __construct(FormManager $form_mgr){
        $this->form_mgr = $form_mgr;
   }
 
  public static function create(ContainerInterface $container) {
     return new static($container->get('d8training.form_manager'));
  }



   
  /**
   * {@inheritdoc}
   */
   public function getFormId() {
     return 'my_first_form_id';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
   
   $duplicates = $this->form_mgr->fetchData();
  
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#default_value'=>$duplicates['first_name'],
      '#title' => t('first_name'),
      '#required' => TRUE,
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#default_value'=>$duplicates['last_name'],
      '#title' => t('last_name'),
    );
    
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

   public function submitForm(array &$form, FormStateInterface $form_state) {
    
  /*table : my_from
SELECT `first_name`, `last_name` FROM `my_from` WHERE 1
     */
$data = array(
      'first_name' => $form_state->getValue('first_name'),
      'last_name' => $form_state->getValue('last_name'),
    );

$this->form_mgr->addData( 'my_from', $data );

/*
  
  $result = $this->database->insert('my_from') 
      ->fields ( array(
      'first_name' => $form_state->getValue('first_name'),
      'last_name' => $form_state->getValue('last_name'),
    ))->execute();
*/


  }


   public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate video URL.
    /*if (!UrlHelper::isValid($form_state->getValue('video'), TRUE)) {
      $form_state->setErrorByName('video', $this->t("The video url '%url' is invalid.", array('%url' => $form_state->getValue('video'))));
    }*/
  }




 }// end class



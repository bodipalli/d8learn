<?php 


namespace Drupal\d8training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Database\Driver\mysql\Connection;

/**
* 
*/
class Cogfigform extends FormBase 
{
	
	/*function __construct(argument)
	{
		# code...
	}
*/

  public function getFormId() {
     return 'amazing_forms_contribute_form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {

  }

 public function submitForm(array &$form, FormStateInterface $form_state) {

 }


}

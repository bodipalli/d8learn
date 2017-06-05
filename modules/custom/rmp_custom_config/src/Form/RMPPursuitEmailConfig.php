<?php

namespace Drupal\rmp_custom_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RMPPursuitEmailConfig.
 *
 * @package Drupal\rmp_custom_config\Form
 */
class RMPPursuitEmailConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'rmp_custom_config.rmppursuitemailconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rmp_pursuit_email_config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('rmp_custom_config.rmppursuitemailconfig');

    $form['pursuit_emails_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Pursuit Email Settings'),
      '#open' => TRUE,
    ];
    $form['pursuit_emails_settings']['pursuit_emails_to'] = [
      '#type' => 'textfield',
      '#title' => $this->t('To Email'),
      '#description' => $this->t('Enter To email.'),
      '#maxlength' => 256,
      '#size' => 256,
      '#default_value' => $config->get('pursuit_emails_to'),
    ];      
    $form['pursuit_emails_settings']['pursuit_emails_cc'] = [
      '#type' => 'textarea',
      '#title' => $this->t('CC Email'),
      '#description' => $this->t('Enter multiple emails with comma seperated. Ex. abc@capgemini.com, xyz@capgemini.com'),
    ];
    $form['pursuit_emails_settings']['pursuit_emails_subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subject'),
      '#description' => $this->t('Enter Subject.'),
      '#maxlength' => 256,
      '#size' => 256,
      '#default_value' => $config->get('pursuit_emails_subject'),
    ];
    $form['pursuit_emails_settings']['pursuit_emails_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#description' => $this->t('Enter Body.'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $emailTo = $form_state->getValue ( 'pursuit_emails_to' );
    $emailCc = $form_state->getValue('pursuit_emails_cc');
    $pat = "/^[_a-zA-Z0-9-+]+(\.[_a-zA-Z0-9-+]+)*@[a-zA-Z0-9-]";
    $pat .= "+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/";
		if (!preg_match($pat, $emailTo)) {
	  $form_state->setErrorByName ( $emailTo, t('This email is not correct'));
		}
    else{
      return TRUE;
    }
    //if (!preg_match($pat, $emailCc)) {
	   // $form_state->setErrorByName ( $emailCc, t('These emails are not acceptable'));
		//}
    //else{
      //return TRUE;
    //}
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('rmp_custom_config.rmppursuitemailconfig')
      ->set('pursuit_emails_to', $form_state->getValue('pursuit_emails_to'))
      ->set('pursuit_emails_cc', $form_state->getValue('pursuit_emails_cc'))
      ->set('pursuit_emails_subject', $form_state->getValue('pursuit_emails_subject'))
      ->set('pursuit_emails_body', $form_state->getValue('pursuit_emails_body'))
      ->save();
  }
}

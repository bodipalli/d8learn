<?php

namespace Drupal\facebook_posts\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FbsettingsForm.
 *
 * @package Drupal\facebook_posts\Form
 */
class FbsettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'facebook_posts.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fbsettings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('facebook_posts.settings');
    $form['fb_app_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('APP ID'),
      '#description' => $this->t('Facebook APP ID'),
      '#maxlength' => 50,
      '#size' => 50,
      '#default_value' => $config->get('fb_app_id'),
    ];
    $form['fb_app_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('APP SECRET'),
      '#description' => $this->t('Facebook APP SECRET'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('fb_app_secret'),
    ];
    $form['fb_page_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PAGE ID'),
      '#description' => $this->t('Facebook PAGE ID'),
      '#maxlength' => 50,
      '#size' => 50,
      '#default_value' => $config->get('fb_page_id'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('facebook_posts.settings')
      ->set('fb_app_id', $form_state->getValue('fb_app_id'))
      ->set('fb_app_secret', $form_state->getValue('fb_app_secret'))
      ->set('fb_page_id', $form_state->getValue('fb_page_id'))
      ->save();
  }

}

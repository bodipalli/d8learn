<?php

namespace Drupal\instagram\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Class InstagramSettingsForm.
 *
 * @package Drupal\instagram\Form
 */
class InstagramSettingsForm extends ConfigFormBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  public function __construct(
    ConfigFactoryInterface $config_factory,
      Connection $database
    ) {
    parent::__construct($config_factory);
        $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
            $container->get('database')
    );
  }


  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'instagram.instagramsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'instagram_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('instagram.instagramsettings');
    $form['insta_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#description' => $this->t('Instagram API Key'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('insta_api_key'),
    ];
    $form['insta_api_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Secret'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('insta_api_secret'),
    ];
    $form['insta_api_callback'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Callback'),
      '#description' => $this->t('Instagram API call back URL'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('insta_api_callback'),
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

    $this->config('instagram.instagramsettings')
      ->set('insta_api_key', $form_state->getValue('insta_api_key'))
      ->set('insta_api_secret', $form_state->getValue('insta_api_secret'))
      ->set('insta_api_callback', $form_state->getValue('insta_api_callback'))
      ->save();
  }

}

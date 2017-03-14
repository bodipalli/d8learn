<?php

namespace Drupal\d8training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;

/**
 * Provides a 'googlebook' block.
 *
 * @Block(
 *  id = "googlebook",
 *  admin_label = @Translation("Google Book"),
 * )
 */
class googlebook extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['isbn'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('Isbn value for the book'),
      '#default_value' => isset($this->configuration['isbn']) ? $this->configuration['isbn'] : '',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['isbn'] = $form_state->getValue('isbn');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['googlebook_isbn']['#markup'] = '<p>' . $this->configuration['isbn'] . '</p>';
    //$client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
    //$fetcher = new Fetcher($client);
    //$book = $fetcher->forISBN('9780142181119');
    //$book = $fetcher->forISBN( $this->configuration['isbn']);
    //$build['googlebook_isbn']['#title'] = $this->configuration['isbn']->title;;
    //$this->configuration['isbn']->subtitle;
    // title subtitle
    return $build;
  }
}

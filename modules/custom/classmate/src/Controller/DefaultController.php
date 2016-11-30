<?php

namespace Drupal\classmate\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\classmate\Controller
 */
class DefaultController extends ControllerBase {
  /**
   * Showme_hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function showme_hello($name) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: showme_hello with parameter(s): $name'),
    ];
  }
  /**
   * Showmehello.
   *
   * @return string
   *   Return Hello string.
   */
  public function showmehello() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: showmehello')
    ];
  }

}

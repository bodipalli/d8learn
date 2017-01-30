<?php

namespace Drupal\signoraware\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class Lunchpack.
 *
 * @package Drupal\signoraware\Controller
 */
class Lunchpack extends ControllerBase {
  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display')
    ];
  }

}

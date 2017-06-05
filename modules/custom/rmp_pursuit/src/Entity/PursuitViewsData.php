<?php

namespace Drupal\rmp_pursuit\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Pursuit entities.
 */
class PursuitViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}

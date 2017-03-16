<?php

namespace Drupal\d8training\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'latestblocktitles' block.
 *
 * @Block(
 *  id = "latestblocktitles",
 *  admin_label = @Translation("Latest block titles"),
 * )
 */
class latestblocktitles extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['latestblocktitles']['#markup'] = 'Implement latestblocktitles.';
    return $build;
  }

}

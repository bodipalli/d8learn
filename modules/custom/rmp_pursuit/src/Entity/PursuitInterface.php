<?php

namespace Drupal\rmp_pursuit\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Pursuit entities.
 *
 * @ingroup rmp_pursuit
 */
interface PursuitInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Pursuit name.
   *
   * @return string
   *   Name of the Pursuit.
   */
  public function getName();

  /**
   * Sets the Pursuit name.
   *
   * @param string $name
   *   The Pursuit name.
   *
   * @return \Drupal\rmp_pursuit\Entity\PursuitInterface
   *   The called Pursuit entity.
   */
  public function setName($name);

  /**
   * Gets the Pursuit creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Pursuit.
   */
  public function getCreatedTime();

  /**
   * Sets the Pursuit creation timestamp.
   *
   * @param int $timestamp
   *   The Pursuit creation timestamp.
   *
   * @return \Drupal\rmp_pursuit\Entity\PursuitInterface
   *   The called Pursuit entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Pursuit published status indicator.
   *
   * Unpublished Pursuit are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Pursuit is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Pursuit.
   *
   * @param bool $published
   *   TRUE to set this Pursuit to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\rmp_pursuit\Entity\PursuitInterface
   *   The called Pursuit entity.
   */
  public function setPublished($published);

}

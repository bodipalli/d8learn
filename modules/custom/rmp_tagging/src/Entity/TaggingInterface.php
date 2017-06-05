<?php

namespace Drupal\rmp_tagging\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Tagging entities.
 *
 * @ingroup rmp_tagging
 */
interface TaggingInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Tagging name.
   *
   * @return string
   *   Name of the Tagging.
   */
  public function getName();

  /**
   * Sets the Tagging name.
   *
   * @param string $name
   *   The Tagging name.
   *
   * @return \Drupal\rmp_tagging\Entity\TaggingInterface
   *   The called Tagging entity.
   */
  public function setName($name);

  /**
   * Gets the Tagging creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Tagging.
   */
  public function getCreatedTime();

  /**
   * Sets the Tagging creation timestamp.
   *
   * @param int $timestamp
   *   The Tagging creation timestamp.
   *
   * @return \Drupal\rmp_tagging\Entity\TaggingInterface
   *   The called Tagging entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Tagging published status indicator.
   *
   * Unpublished Tagging are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Tagging is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Tagging.
   *
   * @param bool $published
   *   TRUE to set this Tagging to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\rmp_tagging\Entity\TaggingInterface
   *   The called Tagging entity.
   */
  public function setPublished($published);

}

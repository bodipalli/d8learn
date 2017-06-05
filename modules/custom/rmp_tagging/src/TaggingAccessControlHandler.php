<?php

namespace Drupal\rmp_tagging;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Tagging entity.
 *
 * @see \Drupal\rmp_tagging\Entity\Tagging.
 */
class TaggingAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\rmp_tagging\Entity\TaggingInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished tagging entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published tagging entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit tagging entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete tagging entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add tagging entities');
  }

}

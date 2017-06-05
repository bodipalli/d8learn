<?php

namespace Drupal\rmp_pursuit;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Pursuit entity.
 *
 * @see \Drupal\rmp_pursuit\Entity\Pursuit.
 */
class PursuitAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\rmp_pursuit\Entity\PursuitInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished pursuit entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published pursuit entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit pursuit entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete pursuit entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add pursuit entities');
  }

}

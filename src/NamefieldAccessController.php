<?php

namespace Drupal\custom_display_name;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines an access controller for the name field entity.
 *
 * @ingroup custom_display_name
 */
class NamefieldAccessController extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  public function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    if ($operation == 'view') {
      return TRUE;
    }
    return parent::checkAccess($entity, $operation, $account);
  }

}

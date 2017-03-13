<?php

namespace Drupal\custom_display_name\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Class NamefieldListBuilder.
 *
 * @package Drupal\custom_display_name\Controller
 *
 * @ingroup custom_display_name
 */
class NamefieldListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Label');
    $header['field_id'] = $this->t('Field Id');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    $row['field_id'] = $entity->field_id;
    return $row + parent::buildRow($entity);
  }

}

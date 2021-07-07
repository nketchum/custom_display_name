<?php

namespace Drupal\custom_display_name\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class NamefieldDeleteForm.
 *
 * @package Drupal\custom_display_name\Form
 *
 * @ingroup custom_display_name
 */
class NamefieldDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete display name field %label?', array(
      '%label' => $this->entity->label(),
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete display name field');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.namefield.list');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entity->delete();
    \Drupal\Core\Messenger\MessengerInterface::addMessage($this->t('Display name field %label was deleted.', array(
      '%label' => $this->entity->label(),
    )));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}

<?php

namespace Drupal\custom_display_name\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class NamefieldFormBase.
 *
 * @package Drupal\custom_display_name\Form
 *
 * @ingroup custom_display_name
 */
class NamefieldFormBase extends EntityForm {

  protected $entityQueryFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityStorageInterface $query_factory) {
    $this->entityQueryFactory = $query_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity.query'));
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $namefield = $this->entity;

    // Build the form.
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $namefield->label(),
      '#required' => TRUE,
    );
    $form['id'] = array(
      '#type' => 'machine_name',
      '#title' => $this->t('Machine name'),
      '#default_value' => $namefield->id(),
      '#machine_name' => array(
        'exists' => array($this, 'exists'),
        'replace_pattern' => '([^a-z0-9_]+)|(^custom$)',
        'error' => 'The machine-readable name must be unique, and can only contain lowercase letters, numbers, and underscores. Additionally, it can not be the reserved word "custom".',
      ),
      '#disabled' => !$namefield->isNew(),
    );

    // Get defined text fields from the user entity.
    $field_ids = [];
    $fields = $this->entityManager
      ->getStorage('field_storage_config')
      ->loadByProperties(array(
        'entity_type' => 'user',
        'deleted' => FALSE,
        'status' => 1,
      ));
    foreach($fields as $field) {
      if ($field_id = $field->get('field_name')) {
        $field_ids[$field_id] = $field_id;
      }
    }

    $form['field_id'] = array(
      '#type' => 'select',
      '#title' => $this->t('Field Id'),
      '#options' => $field_ids,
      '#default_value' => $namefield->field_id,
      '#required' => TRUE,
    );

    // Add a weight select (-9 to 9)
    $weights = [];
    for ($weight = -9; $weight <= 9; $weight++) {
      $weights[$weight] = "$weight";
    }

    $form['weight'] = array(
      '#type' => 'select',
      '#title' => $this->t('Weight'),
      '#options' => $weights,
      '#default_value' => $namefield->weight ? $namefield->weight : 0,
      '#required' => TRUE,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function exists($entity_id, array $element, FormStateInterface $form_state) {
    $query = $this->entityQueryFactory->get('namefield');
    $result = $query->condition('id', $element['#field_prefix'] . $entity_id)->execute();
    return (bool) $result;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Save');
    return $actions;
  }

  /**
   * {@inheritdoc}
   */
  public function validate(array $form, FormStateInterface $form_state) {
    parent::validate($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $namefield = $this->getEntity();

    $status = $namefield->save();
    $url = \Drupal\Core\Entity\EntityInterface::toUrl($namefield);
    $edit_link = Link::fromTextAndUrl($this->t('Edit'), $url)->toString();

    if ($status == SAVED_UPDATED) {
      \Drupal\Core\Messenger\MessengerInterface::addMessage($this->t('Display name field %label has been updated.', array('%label' => $namefield->label())));
      $this->logger('contact')->notice('Display name field %label has been updated.', ['%label' => $namefield->label(), 'link' => $edit_link]);
    } else {
      \Drupal\Core\Messenger\MessengerInterface::addMessage($this->t('Display name field %label has been added.', array('%label' => $namefield->label())));
      $this->logger('contact')->notice('Display name field %label has been added.', ['%label' => $namefield->label(), 'link' => $edit_link]);
    }

    $form_state->setRedirect('entity.namefield.list');
  }

}

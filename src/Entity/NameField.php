<?php

namespace Drupal\custom_display_name\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the name field entity.
 *
 * @ingroup custom_display_name
 *
 * @ConfigEntityType(
 *   id = "namefield",
 *   label = @Translation("Namefield"),
 *   admin_permission = "administer users",
 *   handlers = {
 *     "access" = "Drupal\custom_display_name\NameFieldAccessController",
 *     "list_builder" = "Drupal\custom_display_name\Controller\NameFieldListBuilder",
 *     "form" = {
 *       "add" = "Drupal\custom_display_name\Form\NameFieldAddForm",
 *       "edit" = "Drupal\custom_display_name\Form\NameFieldEditForm",
 *       "delete" = "Drupal\custom_display_name\Form\NameFieldDeleteForm"
 *     }
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/people/display_name/manage/{namefield}",
 *     "delete-form" = "/admin/config/people/display_name/manage/{namefield}/delete"
 *   }
 * )
 */
class Namefield extends ConfigEntityBase {

  public $id;

  public $uuid;

  public $label;

  public $field_id;

  public $weight;

}

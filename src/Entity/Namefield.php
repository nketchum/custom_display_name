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
 *     "access" = "Drupal\custom_display_name\NamefieldAccessController",
 *     "list_builder" = "Drupal\custom_display_name\Controller\NamefieldListBuilder",
 *     "form" = {
 *       "add" = "Drupal\custom_display_name\Form\NamefieldAddForm",
 *       "edit" = "Drupal\custom_display_name\Form\NamefieldEditForm",
 *       "delete" = "Drupal\custom_display_name\Form\NamefieldDeleteForm"
 *     }
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
  *   revision_metadata_keys = {
 *     "revision_user" = "revision_user",
 *     "revision_created" = "revision_created",
 *     "revision_log_message" = "revision_log",
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

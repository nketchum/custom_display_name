<?php

/**
 * @file
 * Contains \Drupal\custom_display_name\Routing\RouteSubscriber.
 */

namespace Drupal\custom_display_name\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('entity.user.canonical')) {
        $route->setDefault('_title_callback', '\Drupal\custom_display_name\Controller\UserController::userTitle');
    }
  }
}

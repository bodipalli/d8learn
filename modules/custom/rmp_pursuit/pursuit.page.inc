<?php

/**
 * @file
 * Contains pursuit.page.inc.
 *
 * Page callback for Pursuit entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Pursuit templates.
 *
 * Default template: pursuit.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_pursuit(array &$variables) {
  // Fetch Pursuit Entity Object.
  $pursuit = $variables['elements']['#pursuit'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

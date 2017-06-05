<?php

/**
 * @file
 * Contains tagging.page.inc.
 *
 * Page callback for Tagging entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Tagging templates.
 *
 * Default template: tagging.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_tagging(array &$variables) {
  // Fetch Tagging Entity Object.
  $tagging = $variables['elements']['#tagging'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

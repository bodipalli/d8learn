<?php

namespace Drupal\classmate\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the classmate module.
 */
class DefaultControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "classmate DefaultController's controller functionality",
      'description' => 'Test Unit for module classmate and controller DefaultController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests classmate functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module classmate.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}

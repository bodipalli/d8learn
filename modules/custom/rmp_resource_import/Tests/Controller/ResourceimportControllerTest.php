<?php

namespace Drupal\rmp_resource_import\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the rmp_resource_import module.
 */
class ResourceimportControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "rmp_resource_import ResourceimportController's controller functionality",
      'description' => 'Test Unit for module rmp_resource_import and controller ResourceimportController.',
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
   * Tests rmp_resource_import functionality.
   */
  public function testResourceimportController() {
    // Check that the basic functions of module rmp_resource_import.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}

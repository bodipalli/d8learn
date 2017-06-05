<?php

namespace Drupal\rmp_reports\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\rmp_reports\Services\RmpResourceUtilizationService;

/**
 * Provides a 'RmpUtilizationPracticeViewBlock' block.
 *
 * @Block(
 *  id = "practice_view_block",
 *  admin_label = @Translation("Rmp utilization practice view block"),
 * )
 */
class RmpUtilizationPracticeViewBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Drupal\rmp_reports\Services\RmpResourceUtilizationService definition.
   *
   * @var \Drupal\rmp_reports\Services\RmpResourceUtilizationService
   */
  protected $rmpReportsResourceUtilizationService;
  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        Connection $database,
        RmpResourceUtilizationService $rmp_reports_resource_utilization_service
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
    $this->rmpReportsResourceUtilizationService = $rmp_reports_resource_utilization_service;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
      $container->get('rmp_reports.resource_utilization_service')
    );
  }  

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = [];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
  
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#cache' => [
      'max-age' => 0,
     ],
    ];
    $resp = $this->rmpReportsResourceUtilizationService->resourceUtilizationPracticeViewReportList();

    if (!empty($resp)) {
      $build['practice_view_block']['#markup'] = render($resp);
    }
    else {
      $build['practice_view_block']['#markup'] = 'No data';
    }

    return $build;
  }

}

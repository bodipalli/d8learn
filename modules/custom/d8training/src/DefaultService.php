<?php

namespace Drupal\d8training;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Config\ConfigManager;

/**
 * Class DefaultService.
 *
 * @package Drupal\d8training
 */
class DefaultService implements DefaultServiceInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Drupal\Core\Logger\LoggerChannelFactory definition.
   *
   * @var Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $logger_factory;

  /**
   * Drupal\Core\Config\ConfigManager definition.
   *
   * @var Drupal\Core\Config\ConfigManager
   */
  protected $config_manager;
  /**
   * Constructor.
   */
  public function __construct(Connection $database, LoggerChannelFactory $logger_factory, ConfigManager $config_manager) {
    $this->database = $database;
    $this->logger_factory = $logger_factory;
    $this->config_manager = $config_manager;
  }

}

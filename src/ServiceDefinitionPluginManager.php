<?php
/**
 * @file
 * Contains Drupal\services\ServiceDefinitionPluginManager.
 */

namespace Drupal\services;

use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;


class ServiceDefinitionPluginManager extends \Drupal\Core\Plugin\DefaultPluginManager {
  /**
   * Constructs a new PasswordConstraintPluginManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/ServiceDefinition', $namespaces, $module_handler, 'Drupal\services\ServiceDefinitionInterface', 'Drupal\services\Annotation\ServiceDefinition');
    $this->alterInfo('service_definition_info');
    $this->setCacheBackend($cache_backend, 'service_definition');
  }

}
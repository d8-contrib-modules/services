<?php

/**
 * @file
 * Contains Drupal\services\Entity\ServiceAPI.
 */

namespace Drupal\services\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\services\ServiceAPIInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines the Service Endpoint entity.
 *
 * @ConfigEntityType(
 *   id = "service_endpoint",
 *   label = @Translation("Service Endpoint"),
 *   handlers = {
 *     "list_builder" = "Drupal\services\Controller\ServiceAPIListBuilder",
 *     "form" = {
 *       "add" = "Drupal\services\Form\ServiceAPIForm",
 *       "edit" = "Drupal\services\Form\ServiceAPIForm",
 *       "delete" = "Drupal\services\Form\ServiceAPIDeleteForm"
 *     }
 *   },
 *   config_prefix = "service_endpoint",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/service_endpoint/{service_endpoint}",
 *     "edit-form" = "/admin/structure/service_endpoint/{service_endpoint}/edit",
 *     "delete-form" = "/admin/structure/service_endpoint/{service_endpoint}/delete",
 *     "collection" = "/admin/structure/service_endpoint"
 *   }
 * )
 */
class ServiceAPI extends ConfigEntityBase implements ServiceAPIInterface {
  /**
   * The Service Endpoint ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Service Endpoint label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Service Endpoint endpoint.
   *
   * @var string
   */
  protected $endpoint;

  /**
   * The Service Provider for the api.
   *
   * @var string
   */
  protected $service_provider;

  /**
   * {@inheritdoc}
   */
  public function getEndpoint() {
    return $this->endpoint;
  }

  /**
   * {@inheritdoc}
   */
  public function getServiceProvider() {
    return $this->service_provider;
  }

  /**
   * {@inheritdoc}
   */
  public function processRequest(Request $request) {
    if ($this->getServiceProvider()) {
      $plugin_service = \Drupal::getContainer()->get('plugin.manager.services.service_definition');
      /** @var $instance \Drupal\services\ServiceAPIInterface */
      $instance = $plugin_service->createInstance($this->getServiceProvider());
      return $instance->processRequest($request);
    }
    return NULL;
  }
}

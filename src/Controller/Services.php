<?php

/**
 * @file
 * Contains Drupal\services\Controller\Services.
 */

namespace Drupal\services\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Services.
 *
 * @package Drupal\services\Controller
 */
class Services extends ControllerBase {
  /**
   * Processing the API request.
   */
  public function processRequest(Request $request, RouteMatchInterface $route_match) {
    /** @var $service_endpoint \Drupal\services\ServiceAPIInterface */
    $service_endpoint = \Drupal::getContainer()->get('service_manager')->getServiceByEndpoint($request->getPathInfo());
    return new Response($service_endpoint->processRequest($request));
  }
}

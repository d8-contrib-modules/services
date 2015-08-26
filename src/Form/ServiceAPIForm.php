<?php

/**
 * @file
 * Contains Drupal\services\Form\ServiceAPIForm.
 */

namespace Drupal\services\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ServiceAPIForm.
 *
 * @package Drupal\services\Form
 */
class ServiceAPIForm extends EntityForm {

  /**
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $manager;

  public static function create(ContainerInterface $container) {
    return new static($container->get('plugin.manager.services.service_definition'));
  }

  function __construct(PluginManagerInterface $manager) {
    $this->manager = $manager;
  }
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var $service_endpoint \Drupal\services\Entity\ServiceAPI */
    $service_endpoint = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $service_endpoint->label(),
      '#description' => $this->t("Label for the Service Endpoint."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $service_endpoint->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\services\Entity\ServiceAPI::load',
      ),
      '#disabled' => !$service_endpoint->isNew(),
    );

    $form['endpoint'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Endpoint'),
      '#maxlength' => 255,
      '#default_value' => $service_endpoint->getEndpoint(),
      '#description' => $this->t("URL endpoint."),
      '#required' => TRUE,
    );

    $opts = [];

    foreach ($this->manager->getDefinitions() as $plugin_id => $definition) {
      $opts[$plugin_id] = (string) $definition['title'];
    }

    $form['service_provider'] = array(
      '#type' => 'select',
      '#options' => $opts,
      '#title' => $this->t('Service Provider'),
      '#required' => TRUE,
      '#default_value' => $service_endpoint->getServiceProvider(),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $service_endpoint = $this->entity;
    $status = $service_endpoint->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label Service Endpoint.', array(
        '%label' => $service_endpoint->label(),
      )));
    }
    else {
      drupal_set_message($this->t('The %label Service Endpoint was not saved.', array(
        '%label' => $service_endpoint->label(),
      )));
    }
    $form_state->setRedirectUrl($service_endpoint->urlInfo('collection'));
  }

}

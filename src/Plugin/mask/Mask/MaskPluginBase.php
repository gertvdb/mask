<?php

namespace Drupal\mask\Plugin\Mask\Mask;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\mask\Factory\MaskFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for Mask plugins.
 */
abstract class MaskPluginBase extends PluginBase implements MaskPluginInterface , ContainerFactoryPluginInterface {

  /**
   * The mask factory.
   *
   * @var \Drupal\mask\Factory\MaskFactory
   */
  protected $maskFactory;

  /**
   * Constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $pluginId
   *   The plugin id for the plugin instance.
   * @param mixed $pluginDefinition
   *   The plugin implementation definition.
   * @param \Drupal\mask\Factory\MaskFactory $maskFactory
   *   The mask factory.
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, MaskFactory $maskFactory) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->maskFactory = $maskFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {

    /** @var MaskFactory $maskFactory */
    $maskFactory = $container->get('mask.mask_factory');

    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $maskFactory
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->getPluginDefinition()['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function getMask() {
    return $this->getPluginDefinition()['mask'];
  }

  /**
   * {@inheritdoc}
   */
  public function toMask() {
    return $this->maskFactory->createMask($this->getMask());
  }

}

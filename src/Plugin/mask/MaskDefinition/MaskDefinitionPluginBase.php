<?php

namespace Drupal\mask\Plugin\Mask\MaskDefinition;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\mask\Factory\MaskDefinitionFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for Mask definition plugins.
 */
abstract class MaskDefinitionPluginBase extends PluginBase implements MaskDefinitionPluginInterface , ContainerFactoryPluginInterface {

  /**
   * The mask definition factory.
   *
   * @var \Drupal\mask\Factory\MaskDefinitionFactory
   */
  protected $maskDefinitionFactory;

  /**
   * Constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $pluginId
   *   The plugin id for the plugin instance.
   * @param mixed $pluginDefinition
   *   The plugin implementation definition.
   * @param \Drupal\mask\Factory\MaskDefinitionFactory $maskDefinitionFactory
   *   The country factory.
   */
  public function __construct(array $configuration, $pluginId, $pluginDefinition, MaskDefinitionFactory $maskDefinitionFactory) {
    parent::__construct($configuration, $pluginId, $pluginDefinition);
    $this->maskDefinitionFactory = $maskDefinitionFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {

    /** @var MaskDefinitionFactory $maskDefinitionFactory */
    $maskDefinitionFactory = $container->get('mask.mask_definition_factory');

    return new static(
      $configuration,
      $pluginId,
      $pluginDefinition,
      $maskDefinitionFactory
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
  public function getCharacter() {
    return $this->getPluginDefinition()['character'];
  }

  /**
   * {@inheritdoc}
   */
  public function getPattern() {
    return $this->getPluginDefinition()['pattern'];
  }

  /**
   * {@inheritdoc}
   */
  public function toMaskDefinition() {
    return $this->maskDefinitionFactory->createMaskDefinition($this->getCharacter(), $this->getPattern());
  }

}

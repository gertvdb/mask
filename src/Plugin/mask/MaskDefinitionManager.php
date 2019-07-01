<?php

namespace Drupal\mask\Plugin\Mask;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Mask definition plugin manager.
 */
class MaskDefinitionManager extends DefaultPluginManager implements MaskDefinitionManagerInterface {

  /**
   * Constructs a new MaskDefinitionManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cacheBackend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cacheBackend, ModuleHandlerInterface $moduleHandler) {
    parent::__construct('Plugin/mask/MaskDefinition', $namespaces, $moduleHandler, 'Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface', 'Drupal\mask\Annotation\MaskDefinition');

    $this->alterInfo('mask_mask_definition_info');
    $this->setCacheBackend($cacheBackend, 'mask_mask_definition_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinitions() {
    $characterList = [];

    // Get definitions.
    $definitions = parent::getDefinitions();

    if (!empty($definitions)) {
      foreach ($definitions as $definition) {

        // Guard against invalid alpha2 codes.
        $this->guardAgainstInvalidCharacter($definition['character']);
        $this->guardAgainstDuplicateCharacter($definition['character'], $characterList);

        $characterList[] = $definition['character'];
      }
    }

    return $definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function createInstanceByCharacter($character) {
    $countryDefinitions = $this->getDefinitions();
    foreach ($countryDefinitions as $pluginId => $pluginConfig) {
      try {

        /** @var \Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface $maskDefInstance */
        $maskDefInstance = $this->createInstance($pluginId, $pluginConfig);

        if ($maskDefInstance->getCharacter() === $character) {
          return $maskDefInstance;
        }
      }
      catch (\Exception $exception) {
        // Return NULL on exception.
      }

    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstInvalidCharacter($character) {
    if (!is_string($character) || strlen($character) !== 1) {
      throw new \LogicException(sprintf(
        'Expected $character to be a single character, got : "%s"',
        $character
      ));
    }

    if (preg_match("/[A-Za-z0-9*]+/", $character) == FALSE) {
      throw new \LogicException(sprintf(
        'Expected $character to be an alphanumeric character, got : "%s"',
        $character
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  private function guardAgainstDuplicateCharacter($character, $characterList) {
    if (in_array($character, $characterList)) {
      throw new \LogicException(sprintf(
        'Expected $character to be unique, got duplicate for: "%s". If you want to override an existing plugin use hook_mask_mask_definition_info_alter although it is probably better to provide a new plugin.',
        $character
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getMaskDefinition($character) {
    /** @var \Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface $maskDefInstance */
    $maskDefInstance = $this->createInstanceByCharacter($character);
    return $maskDefInstance ? $maskDefInstance->toMaskDefinition() : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getMaskDefinitions() {
    $countries = [];
    $maskDefinitions = $this->getDefinitions();
    foreach ($maskDefinitions as $pluginId => $pluginConfig) {
      try {

        /** @var \Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface $maskDefInstance */
        $maskDefInstance = $this->createInstance($pluginId, $pluginConfig);

        /** @var \Drupal\mask\MaskDefinitionInterface $country */
        $country = $maskDefInstance->toMaskDefinition();

        $countries[] = $country;
      }
      catch (\Exception $exception) {
        // Return empty array on exception.
      }

    }

    return $countries;
  }

}

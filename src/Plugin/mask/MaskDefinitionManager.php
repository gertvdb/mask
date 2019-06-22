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
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/mask/MaskDefinition', $namespaces, $module_handler, 'Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface', 'Drupal\mask\Annotation\MaskDefinition');

    $this->alterInfo('mask_mask_definition_info');
    $this->setCacheBackend($cache_backend, 'mask_mask_definition_plugins');
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

        /** @var \Drupal\mask\Plugin\Mask\MaskDefinitionInterface $maskDefinitionInstance */
        $maskDefinitionInstance = $this->createInstance($pluginId, $pluginConfig);

        if ($maskDefinitionInstance->getCharacter() === $character) {
          return $maskDefinitionInstance;
        }
      } catch (\Exception $exception) {}
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

    if(preg_match("/[A-Za-z0-9*]+/", $character) == FALSE){
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
        'Expected $character to be unique, got duplicate for: "%s". If you want to override an existing plugin use hook_mask_mask_definition_info_alter.',
        $character
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getMaskDefinition($character) {
    /** @var \Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface $maskDefinitionInstance */
    $maskDefinitionInstance = $this->createInstanceByCharacter($character);
    return $maskDefinitionInstance ? $maskDefinitionInstance->toMaskDefinition() : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getMaskDefinitions() {
    $countries = [];
    $maskDefinitions = $this->getDefinitions();
    foreach ($maskDefinitions as $pluginId => $pluginConfig) {
      try {

        /** @var \Drupal\mask\Plugin\Mask\MaskDefinition\MaskDefinitionPluginInterface $maskDefinitionInstance */
        $maskDefinitionInstance = $this->createInstance($pluginId, $pluginConfig);

        /** @var \Drupal\mask\MaskDefinitionInterface $country */
        $country = $maskDefinitionInstance->toMaskDefinition();

        $countries[] = $country;
      } catch (\Exception $exception) {
        kint($exception);
      }
    }

    return $countries;
  }

}

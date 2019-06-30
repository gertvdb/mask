<?php

namespace Drupal\mask\Plugin\Mask;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Mask plugin manager.
 */
class MaskManager extends DefaultPluginManager implements MaskManagerInterface {

  /**
   * Constructs a new MaskManager object.
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
    parent::__construct('Plugin/mask/Mask', $namespaces, $moduleHandler, 'Drupal\mask\Plugin\Mask\Mask\MaskPluginInterface', 'Drupal\mask\Annotation\Mask');

    $this->alterInfo('mask_definition_info');
    $this->setCacheBackend($cacheBackend, 'mask_definition_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getMask($pluginId, array $configuration = []) {
    try {
      /** @var \Drupal\mask\Plugin\Mask\Mask\MaskPluginInterface $maskDefInstance */
      $maskDefInstance = $this->createInstance($pluginId, $configuration);
      return $maskDefInstance ? $maskDefInstance->toMask() : NULL;
    }
    catch (\Exception $exception) {
      return NULL;
    }

  }

  /**
   * {@inheritdoc}
   */
  public function getMasks() {
    $masks = [];
    $masksItems = $this->getDefinitions();
    foreach ($masksItems as $pluginId => $pluginConfig) {
      try {

        /** @var \Drupal\mask\Plugin\Mask\Mask\MaskPluginInterface $maskInstance */
        $maskInstance = $this->createInstance($pluginId, $pluginConfig);

        /** @var \Drupal\mask\MaskInterface $mask */
        $mask = $maskInstance->toMask();

        $masks[] = $mask;
      }
      catch (\Exception $exception) {
        // Return empty array on exception.
      }

    }

    return $masks;
  }

  /**
   * {@inheritdoc}
   */
  public function createInstanceByMask($mask) {
    $maskDefinitions = $this->getDefinitions();
    foreach ($maskDefinitions as $pluginId => $pluginConfig) {

      try {
        /** @var \Drupal\mask\Plugin\Mask\Mask\MaskPluginInterface $maskInstance */
        $maskInstance = $this->createInstance($pluginId, $pluginConfig);

      }
      catch (\Exception $exception) {
        continue;
      }

      if ($maskInstance->getMask() === $mask) {
        return $maskInstance;
      }

    }

    return NULL;
  }

}

<?php

namespace Drupal\mask\Plugin\Mask;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the MaskManagerInterface.
 */
interface MaskManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface {

  /**
   * Create an instance by mask.
   *
   * @param string $mask
   *   The mask.
   *
   * @return \Drupal\mask\Plugin\Mask\Mask\MaskPluginInterface
   *   The mask plugin.
   */
  public function createInstanceByMask($mask);

  /**
   * Get a mask plugin.
   *
   * @param string $pluginId
   *   The plugin id.
   * @param array $configuration
   *   The plugin configuration.
   *
   * @return \Drupal\mask\Mask|null
   *   The mask object or null.
   */
  public function getMask($pluginId, array $configuration = []);

  /**
   * Get all masks.
   *
   * @return \Drupal\mask\Mask[]
   *   A array of mask objects.
   */
  public function getMasks();

}

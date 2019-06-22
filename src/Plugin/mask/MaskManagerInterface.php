<?php

namespace Drupal\mask\Plugin\Mask;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the MaskManagerInterface.
 */
interface MaskManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface {

}

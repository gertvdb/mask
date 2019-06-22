<?php

namespace Drupal\mask\Plugin\Mask;

use Drupal\Component\Plugin\Discovery\CachedDiscoveryInterface;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Provides the MaskDefinitionManagerInterface.
 */
interface MaskDefinitionManagerInterface extends PluginManagerInterface, CachedDiscoveryInterface, CacheableDependencyInterface {

  /**
   * Create an instance by character code.
   *
   * @param string $character
   *   The character code.
   *
   * @return \Drupal\mask\Plugin\Mask\MaskDefinitionInterface|null
   *   A plugin instance.
   */
  public function createInstanceByCharacter($character);

  /**
   * Create list of all continents.
   *
   * @return \Drupal\iso3166\ContinentInterface[]
   *   An array of continent objects.
   */
  public function getMaskDefinitions();

  /**
   * Get mask definition by character code.
   *
   * @param string $character
   *   The character code.
   *
   * @return \Drupal\mask\MaskDefinitionInterface|null
   *   A mask definition object.
   */
  public function getMaskDefinition($character);

}

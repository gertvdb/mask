<?php

namespace Drupal\mask;

/**
 * Defines an interface for Mask plugins.
 */
interface MaskInterface {

  /**
   * Get the definitions for the mask.
   *
   * @return \Drupal\mask\MaskDefinitionInterface[]
   *   A list of mask definitions.
   */
  public function getDefinitions();

  /**
   * The mask to apply.
   *
   * @return string
   *   The mask to apply.
   */
  public function getMask();

}

<?php

namespace Drupal\mask;

/**
 * Defines an interface for Mask definitions.
 */
interface MaskDefinitionInterface {

  /**
   * Getter for character code
   *
   * @return string
   */
  public function getCharacter();

  /**
   * Getter for pattern
   *
   * @return string
   */
  public function getPattern();

}

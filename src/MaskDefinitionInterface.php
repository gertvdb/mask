<?php

namespace Drupal\mask;

/**
 * Defines an interface for Mask definitions.
 */
interface MaskDefinitionInterface {

  /**
   * Getter for character code.
   *
   * @return string
   *   The replacement character.
   */
  public function getCharacter();

  /**
   * Getter for pattern.
   *
   * @return string
   *   The pattern to apply to the character.
   */
  public function getPattern();

}

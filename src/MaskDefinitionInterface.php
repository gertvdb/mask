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
   * Getter for pattern php
   *
   * @return string
   */
  public function getPatternPhp();

  /**
   * Getter for pattern js
   *
   * @return string
   */
  public function getPatternJs();

}

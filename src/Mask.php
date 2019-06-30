<?php

namespace Drupal\mask;

/**
 * Class Mask.
 *
 * @package Drupal\mask
 */
class Mask implements MaskInterface {

  /**
   * The mask definitions.
   *
   * @var array|\Drupal\mask\MaskDefinition[]
   */
  protected $definitions;

  /**
   * The mask.
   *
   * @var string
   */
  protected $mask;

  /**
   * Mask constructor.
   *
   * @param string $mask
   *   The mask.
   * @param \Drupal\mask\MaskDefinition[] $definitions
   *   The mask definitions.
   */
  public function __construct($mask, array $definitions) {
    $this->mask = $mask;
    $this->definitions = $definitions;
  }

  /**
   * Get the definitions for the mask.
   *
   * @return \Drupal\mask\MaskDefinitionInterface[]
   *   A list of mask definitions.
   */
  public function getDefinitions() {
    return $this->definitions;
  }

  /**
   * The mask to apply.
   *
   * @return string
   *   The mask to apply.
   */
  public function getMask() {
    return $this->mask;
  }

}

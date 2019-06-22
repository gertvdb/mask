<?php

namespace Drupal\mask;

/**
 * Class Mask
 *
 * @package Drupal\mask
 */
class Mask implements MaskInterface {

  /**
   * {inheritdoc}
   */
  protected $definitions;

  /**
   * {inheritdoc}
   */
  protected $mask;

  /**
   * Mask constructor.
   *
   * @param $mask
   * @param \Drupal\mask\MaskDefinition[] $definitions
   */
  public function __construct($mask, array $definitions) {
    $this->mask = $mask;
    $this->definitions = $definitions;
  }

  /**
   * Getter for Definitions
   *
   * @return \Drupal\mask\MaskDefinition[]
   */
  public function getDefinitions() {
    return $this->definitions;
  }

  /**
   * Getter for Mask
   *
   * @return string
   */
  public function getMask() {
    return $this->mask;
  }


}

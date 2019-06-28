<?php

namespace Drupal\mask;

/**
 * Class MaskDefinition
 *
 * @package Drupal\mask
 */
class MaskDefinition implements MaskDefinitionInterface {

  /**
   * {inheritdoc}
   */
  protected $character;


  /**
   * {inheritdoc}
   */
  protected $pattern;

  /**
   * MaskDefinition constructor.
   *
   * @param $character
   * @param $pattern
   */
  public function __construct($character, $pattern) {
    $this->character = $character;
    $this->pattern = $pattern;
  }

  /**
   * {inheritdoc}
   */
  public function getCharacter() {
    return $this->character;
  }

  /**
   * {inheritdoc}
   */
  public function getPattern() {
    return $this->pattern;
  }

}

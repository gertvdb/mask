<?php

namespace Drupal\mask;

/**
 * Class MaskDefinition.
 *
 * @package Drupal\mask
 */
class MaskDefinition implements MaskDefinitionInterface {

  /**
   * The character.
   *
   * @var string
   */
  protected $character;

  /**
   * The replacement pattern.
   *
   * @var string
   */
  protected $pattern;

  /**
   * MaskDefinition constructor.
   *
   * @param string $character
   *   The character.
   * @param string $pattern
   *   The replacement pattern.
   */
  public function __construct($character, $pattern) {
    $this->character = $character;
    $this->pattern = $pattern;
  }

  /**
   * Getter for character code.
   *
   * @return string
   *   The replacement character.
   */
  public function getCharacter() {
    return $this->character;
  }

  /**
   * Getter for pattern.
   *
   * @return string
   *   The pattern to apply to the character.
   */
  public function getPattern() {
    return $this->pattern;
  }

}

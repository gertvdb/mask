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
  protected $patternJs;

  /**
   * {inheritdoc}
   */
  protected $patternPhp;

  /**
   * MaskDefinition constructor.
   *
   * @param $character
   * @param $patternJs
   * @param $patternPhp
   */
  public function __construct($character, $patternJs, $patternPhp) {
    $this->character = $character;
    $this->patternJs = $patternJs;
    $this->patternPhp = $patternPhp;
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
  public function getPatternPhp() {
    return $this->patternPhp;
  }

  /**
   * {inheritdoc}
   */
  public function getPatternJs() {
    return $this->patternJs;
  }

}

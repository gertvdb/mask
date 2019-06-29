<?php

namespace Drupal\mask;

/**
 * Class Mask
 *
 * @package Drupal\mask
 */
class MaskedValue implements MaskedValueInterface {

  /**
   * @var string The masked value
   */
  protected $value;

  /**
   * @var string The unmasked value
   */
  protected $unmaskedValue;

  /**
   * @var \Drupal\mask\MaskInterface The applied mask
   */
  protected $mask;

  /**
   * Masked value.
   *
   * @param string $value
   *   The masked value.
   * @param string $unmaskedValue
   *   The unmasked value.
   * @param \Drupal\mask\MaskInterface $mask
   *   The applied mask.
   */
  public function __construct($value, $unmaskedValue, $mask) {
    $this->value = $value;
    $this->unmaskedValue = $unmaskedValue;
    $this->mask = $mask;
  }

  /**
   * {inheritdoc}
   */
  public function getUnmaskedValue() {
    return $this->unmaskedValue;
  }

  /**
   * {inheritdoc}
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * {inheritdoc}
   */
  public function getMask() {
    return $this->mask;
  }

}

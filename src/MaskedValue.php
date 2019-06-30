<?php

namespace Drupal\mask;

/**
 * Class Mask.
 *
 * @package Drupal\mask
 */
class MaskedValue implements MaskedValueInterface {

  /**
   * The masked value.
   *
   * @var string
   */
  protected $value;

  /**
   * The unmasked value.
   *
   * @var string
   */
  protected $unmaskedValue;

  /**
   * The applied mask.
   *
   * @var \Drupal\mask\MaskInterface
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
  public function __construct($value, $unmaskedValue, MaskInterface $mask) {
    $this->value = $value;
    $this->unmaskedValue = $unmaskedValue;
    $this->mask = $mask;
  }

  /**
   * Get the unmasked value.
   *
   * @return string
   *   The value without the mask applied.
   */
  public function getUnmaskedValue() {
    return $this->unmaskedValue;
  }

  /**
   * The masked value.
   *
   * @return string
   *   The value with the mask applied.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * The mask.
   *
   * @return \Drupal\mask\MaskInterface
   *   The mask.
   */
  public function getMask() {
    return $this->mask;
  }

}

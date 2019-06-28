<?php

namespace Drupal\mask;

/**
 * Class Mask
 *
 * @package Drupal\mask
 */
class MaskedValue implements MaskedValueInterface {

  /**
   * {inheritdoc}
   */
  protected $value;

  /**
   * {inheritdoc}
   */
  protected $unmaskedValue;

  /**
   * {inheritdoc}
   */
  protected $mask;

  /**
   * Masked value.
   *
   * @param string $value
   * @param string $unmaskedValue
   * @param \Drupal\mask\MaskInterface $mask
   */
  public function __construct($value, $unmaskedValue, $mask) {
    $this->value = $value;
    $this->unmaskedValue = $unmaskedValue;
    $this->mask = $mask;
  }

  /**
   * Get the unmasked value.
   *
   * @return string
   */
  public function getUnmaskedValue() {
    return $this->unmaskedValue;
  }

  /**
   * Get the masked value.
   *
   * @return string
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Get the mask.
   *
   * @return \Drupal\mask\MaskInterface
   */
  public function getMask() {
    return $this->mask;
  }

}

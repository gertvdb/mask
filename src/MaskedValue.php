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
  protected $maskedValue;

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
   * @param string $maskedValue
   *   The masked value.
   * @param string $unmaskedValue
   *   The unmasked value.
   * @param \Drupal\mask\MaskInterface $mask
   *   The applied mask.
   */
  public function __construct($maskedValue, $unmaskedValue, MaskInterface $mask) {
    $this->maskedValue = $maskedValue;
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
  public function getMaskedValue() {
    return $this->maskedValue;
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

  /**
   * {@inheritdoc}
   */
  public function toArray() {
    return [
      'masked_value' => $this->getMaskedValue(),
      'unmasked_value' => $this->getUnmaskedValue(),
      'mask' => $this->getMask()->getMask(),
    ];
  }

}

<?php

namespace Drupal\mask;

/**
 * Defines an interface for a Masked Value.
 */
interface MaskedValueInterface {

  /**
   * Get the unmasked value.
   *
   * @return string
   *   The value without the mask applied.
   */
  public function getUnmaskedValue();

  /**
   * The masked value.
   *
   * @return string
   *   The value with the mask applied.
   */
  public function getValue();

  /**
   * The mask.
   *
   * @return \Drupal\mask\MaskInterface
   *   The mask.
   */
  public function getMask();

}

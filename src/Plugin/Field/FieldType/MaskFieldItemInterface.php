<?php

namespace Drupal\mask\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemInterface;

/**
 * Interface MaskFieldItemInterface.
 *
 * @package Drupal\mask\Plugin\Field\FieldType
 */
interface MaskFieldItemInterface extends FieldItemInterface {

  /**
   * Get a masked value object.
   *
   * @return \Drupal\mask\MaskedValueInterface|null
   *   The mask object.
   */
  public function toMaskedValue();

}

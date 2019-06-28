<?php

namespace Drupal\mask\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemInterface;

/**
 * Interface MaskFieldItemInterface.
 *
 * @package Drupal\iso3166\Plugin\Field\FieldType
 */
interface MaskFieldItemInterface extends FieldItemInterface {

  /**
   * Get a mask object.
   *
   * @return \Drupal\mask\MaskInterface|null
   *   The mask object.
   */
  public function toMask();

}

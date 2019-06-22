<?php

namespace Drupal\mask\Plugin\Mask\Mask;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Mask plugins.
 */
interface MaskPluginInterface extends PluginInspectionInterface {

  /**
   * The mask definition label.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The mask definition label.
   */
  public function getLabel();

  /**
   * The mask.
   *
   * @return string
   *   The masks.
   */
  public function getMask();

  /**
   * The mask object.
   *
   * @return \Drupal\mask\MaskInterface
   *   A mask object.
   */
  public function toMask();

}

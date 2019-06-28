<?php

namespace Drupal\mask\Plugin\Mask\MaskDefinition;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Mask definition plugins.
 */
interface MaskDefinitionPluginInterface extends PluginInspectionInterface {

  /**
   * The mask definition label.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   The mask definition label.
   */
  public function getLabel();

  /**
   * The character code.
   *
   * @return string
   *   The character code.
   */
  public function getCharacter();

  /**
   * The Js pattern.
   *
   * @return string
   *   The Js pattern.
   */
  public function getPattern();

  /**
   * The mask definition object.
   *
   * @return \Drupal\mask\MaskDefinitionInterface
   *   A mask definition object.
   */
  public function toMaskDefinition();

}

<?php

namespace Drupal\mask\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Mask definition item annotation object.
 *
 * @see \Drupal\mask\Plugin\Mask\MaskDefinitionManager
 * @see plugin_api
 *
 * @Annotation
 */
class MaskDefinition extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The character ID.
   *
   * @var string
   */
  public $character;

  /**
   * The preg match for php.
   *
   * @var string
   */
  public $patternPhp;

  /**
   * The preg match for js.
   *
   * @var string
   */
  public $patternJs;

}

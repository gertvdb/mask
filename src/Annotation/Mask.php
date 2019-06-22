<?php

namespace Drupal\mask\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Mask annotation object.
 *
 * @see \Drupal\mask\Plugin\Mask\MaskManager
 * @see plugin_api
 *
 * @Annotation
 */
class Mask extends Plugin {

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
  public $mask;

}

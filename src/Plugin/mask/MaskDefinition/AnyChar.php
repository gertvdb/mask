<?php

namespace Drupal\mask\Plugin\mask\MaskDefinition;

use Drupal\Core\Annotation\Translation;
use Drupal\mask\Annotation\MaskDefinition;

/**
 * Provides a mask definition.
 *
 * @MaskDefinition(
 *   id = "any_char",
 *   label = @Translation("Any Char"),
 *   character = "*",
 *   pattern = "[A-Za-z0-9]"
 * )
 */
class AnyChar extends MaskDefinitionPluginBase {}

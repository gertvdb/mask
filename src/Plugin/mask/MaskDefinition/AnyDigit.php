<?php

namespace Drupal\mask\Plugin\mask\MaskDefinition;

use Drupal\Core\Annotation\Translation;
use Drupal\mask\Annotation\MaskDefinition;

/**
 * Provides a mask definition.
 *
 * @MaskDefinition(
 *   id = "any_digit",
 *   label = @Translation("Any Digit"),
 *   character = "0",
 *   pattern = "[0-9]"
 * )
 */
class AnyDigit extends MaskDefinitionPluginBase {}

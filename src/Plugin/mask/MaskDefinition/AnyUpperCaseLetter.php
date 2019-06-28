<?php

namespace Drupal\mask\Plugin\mask\MaskDefinition;

use Drupal\Core\Annotation\Translation;
use Drupal\mask\Annotation\MaskDefinition;

/**
 * Provides a mask definition.
 *
 * @MaskDefinition(
 *   id = "any_uppercase_letter",
 *   label = @Translation("Any Uppercase Letter"),
 *   character = "Z",
 *   pattern = "[A-Z]"
 * )
 */
class AnyUpperCaseLetter extends MaskDefinitionPluginBase {}

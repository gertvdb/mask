<?php

namespace Drupal\mask\Plugin\mask\MaskDefinition;

use Drupal\Core\Annotation\Translation;
use Drupal\mask\Annotation\MaskDefinition;

/**
 * Provides a mask definition.
 *
 * @MaskDefinition(
 *   id = "any_lowercase_letter",
 *   label = @Translation("Any Lowercase Letter"),
 *   character = "z",
 *   pattern = "[a-z]"
 * )
 */
class AnyLowerCaseLetter extends MaskDefinitionPluginBase {}

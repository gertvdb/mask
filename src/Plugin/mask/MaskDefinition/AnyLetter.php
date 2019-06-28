<?php

namespace Drupal\mask\Plugin\mask\MaskDefinition;

use Drupal\Core\Annotation\Translation;
use Drupal\mask\Annotation\MaskDefinition;

/**
 * Provides a mask definition.
 *
 * @MaskDefinition(
 *   id = "any_letter",
 *   label = @Translation("Any Letter"),
 *   character = "a",
 *   pattern = "[A-Za-z]"
 * )
 */
class AnyLetter extends MaskDefinitionPluginBase {}

<?php

namespace Drupal\mask\Factory;

use Drupal\mask\MaskDefinition;

/**
 * Defines an factory for creating a mask definition.
 */
class MaskDefinitionFactory {

  /**
   * {@inheritdoc}
   */
  public function createMaskDefinition($character, $pattern) {
    return new MaskDefinition(
      $character,
      $pattern
    );
  }

}

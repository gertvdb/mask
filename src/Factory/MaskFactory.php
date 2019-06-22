<?php

namespace Drupal\mask\Factory;

use Drupal\mask\Mask;
use Drupal\mask\Plugin\Mask\MaskDefinitionManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an factory for creating a mask definition.
 */
class MaskFactory {

  /**
   * The continent plugin manager.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskDefinitionManager
   */
  protected $maskDefinitionManager;

  /**
   * Mask factory
   *
   * @var \Drupal\mask\Plugin\Mask\MaskDefinitionManager $maskDefinitionManager
   *   The mask definition manager.
   */
  public function __construct(MaskDefinitionManager $maskDefinitionManager) {
    $this->maskDefinitionManager = $maskDefinitionManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    /** @var MaskDefinitionManager $maskDefinitionManager */
    $maskDefinitionManager = $container->get('plugin.manager.mask_definition');

    return new static(
      $maskDefinitionManager
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createMask($mask) {
    return new Mask(
      $mask,
      $this->maskDefinitionManager->getMaskDefinitions()
    );
  }

}

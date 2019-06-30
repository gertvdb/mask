<?php

namespace Drupal\mask\Factory;

use Drupal\mask\Mask;
use Drupal\mask\Plugin\Mask\MaskDefinitionManagerInterface;
use Drupal\mask\Plugin\Mask\MaskManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an factory for creating a mask definition.
 */
class MaskFactory {

  /**
   * The mask plugin manager.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManager
   */
  protected $maskManager;

  /**
   * The mask definition plugin manager.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskDefinitionManager
   */
  protected $maskDefManager;

  /**
   * Mask factory.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManagerInterface $maskManager
   *   The mask definition manager.
   * @var \Drupal\mask\Plugin\Mask\MaskDefinitionManagerInterface $maskDefManager
   *   The mask definition manager.
   */
  public function __construct(MaskManagerInterface $maskManager, MaskDefinitionManagerInterface $maskDefManager) {
    $this->maskManager = $maskManager;
    $this->maskDefManager = $maskDefManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /** @var \Drupal\mask\Plugin\Mask\MaskManagerInterface $maskManager */
    $maskManager = $container->get('plugin.manager.mask');

    /** @var \Drupal\mask\Plugin\Mask\MaskDefinitionManagerInterface $maskDefManager */
    $maskDefManager = $container->get('plugin.manager.mask_definition');

    return new static(
      $maskManager,
      $maskDefManager
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createMask($mask) {
    return new Mask(
      $mask,
      $this->maskDefManager->getMaskDefinitions()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createFromPlugin($pluginId) {
    $mask = $this->maskManager->getMask($pluginId);
    return new Mask(
      $mask->getMask(),
      $this->maskDefManager->getMaskDefinitions()
    );
  }

}

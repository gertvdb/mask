<?php

namespace Drupal\mask\Factory;

use Drupal\mask\Mask;
use Drupal\mask\Plugin\Mask\MaskDefinitionManager;
use Drupal\mask\Plugin\Mask\MaskManager;
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
  protected $maskDefinitionManager;

  /**
   * Mask factory
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManager $maskManager
   *   The mask definition manager.
   * @var \Drupal\mask\Plugin\Mask\MaskDefinitionManager $maskDefinitionManager
   *   The mask definition manager.
   */
  public function __construct(MaskManager $maskManager, MaskDefinitionManager $maskDefinitionManager) {
    $this->maskManager = $maskManager;
    $this->maskDefinitionManager = $maskDefinitionManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /** @var MaskManager $maskManager */
    $maskManager = $container->get('plugin.manager.mask');

    /** @var MaskDefinitionManager $maskDefinitionManager */
    $maskDefinitionManager = $container->get('plugin.manager.mask_definition');

    return new static(
      $maskManager,
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

  /**
   * {@inheritdoc}
   */
  public function createFromPlugin($pluginId) {
    $mask = $this->maskManager->getMask($pluginId);
    return new Mask(
      $mask->getMask(),
      $this->maskDefinitionManager->getMaskDefinitions()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createFromFormElement($element) {

    $element['alpha2'];
    $element['masked'];
    $element['unmasked'];

    $mask = $this->maskManager->getMask($pluginId);
    return new Mask(
      $mask->getMask(),
      $this->maskDefinitionManager->getMaskDefinitions()
    );
  }

}

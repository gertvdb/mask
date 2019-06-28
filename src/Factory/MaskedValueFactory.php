<?php

namespace Drupal\mask\Factory;

use Drupal\mask\MaskedValue;
use Drupal\mask\Plugin\Mask\MaskManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an factory for creating a masked value.
 */
class MaskedValueFactory {

  /**
   * The mask plugin manager.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManager
   */
  protected $maskManager;

  /**
   * Mask factory
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManager $maskManager
   *   The mask definition manager.
   */
  public function __construct(MaskManager $maskManager) {
    $this->maskManager = $maskManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /** @var MaskManager $maskManager */
    $maskManager = $container->get('plugin.manager.mask');

    return new static(
      $maskManager
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createMaskedValue($masked, $unmasked, $mask) {
    $maskInstance = $this->maskManager->createInstanceByMask($mask);

    return new MaskedValue(
      $masked,
      $unmasked,
      $maskInstance->toMask()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function createMaskedValueFromArray($array) {
    return $this->createMaskedValue($array['masked'], $array['unmasked'], $array['mask']);
  }

}

<?php

namespace Drupal\mask\Factory;

use Drupal\mask\MaskedValue;
use Drupal\mask\MaskInterface;
use Drupal\mask\Plugin\Mask\MaskManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines an factory for creating a masked value.
 */
class MaskedValueFactory {

  /**
   * The mask plugin manager.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManagerInterface
   */
  protected $maskManager;

  /**
   * Mask factory.
   *
   * @var \Drupal\mask\Plugin\Mask\MaskManagerInterface $maskManager
   *   The mask definition manager.
   */
  public function __construct(MaskManagerInterface $maskManager) {
    $this->maskManager = $maskManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /** @var \Drupal\mask\Plugin\Mask\MaskManagerInterface $maskManager */
    $maskManager = $container->get('plugin.manager.mask');

    return new static(
      $maskManager
    );
  }

  /**
   * Create a masked value.
   *
   * @param string $masked
   *   The masked value.
   * @param string $unmasked
   *   The unmasked value.
   * @param \Drupal\mask\MaskInterface $mask
   *   The mask applied.
   *
   * @return \Drupal\mask\MaskedValue
   *   The masked value object.
   *
   * @throws \Exception
   */
  public function createMaskedValue($masked, $unmasked, MaskInterface $mask) {

    try {
      $maskInstance = $this->maskManager->createInstanceByMask($mask->getMask());
    }
    catch (\Exception $exception) {
      throw new \Exception('Provided mask not found');
    }

    if (!$maskInstance) {
      throw new \Exception('Provided mask not found');
    }

    return new MaskedValue(
      $masked,
      $unmasked,
      $maskInstance->toMask()
    );
  }

  /**
   * Create a masked value from array.
   *
   * @param array $array
   *   The keyed array.
   *
   * @return \Drupal\mask\MaskedValue
   *   The masked value object.
   */
  public function createMaskedValueFromArray(array $array) {
    return $this->createMaskedValue($array['masked'], $array['unmasked'], $array['mask']);
  }

}

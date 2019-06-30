<?php

namespace Drupal\mask;

use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedDataInterface;
use Drupal\Core\TypedData\TypedData;
use Drupal\mask\Plugin\Field\FieldType\MaskFieldItemInterface;

/**
 * A computed masked value.
 *
 * Required settings (below the definition's 'settings' key) are:
 *  - countryCode: The country code.
 *  - countryCode: The country code.
 *  - countryCode: The country code.
 */
class MaskComputedMaskedValue extends TypedData {

  /**
   * Cached computed masked value.
   *
   * @var \Drupal\mask\MaskedValueInterface|null
   */
  protected $maskedValue = NULL;

  /**
   * {@inheritdoc}
   */
  public function __construct(DataDefinitionInterface $definition, $name = NULL, TypedDataInterface $parent = NULL) {
    parent::__construct($definition, $name, $parent);

    if (!$this->getParent() instanceof MaskFieldItemInterface) {
      throw new \InvalidArgumentException("The mask computer will only work on an implementation of the MaskFieldItemInterface");
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    if ($this->maskedValue !== NULL) {
      return $this->maskedValue;
    }

    /** @var \Drupal\mask\Plugin\Field\FieldType\MaskFieldItemInterface $maskFieldItem */
    $maskFieldItem = $this->getParent();
    return $maskFieldItem->toMask();
  }

  /**
   * {@inheritdoc}
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function setValue($value, $notify = TRUE) {
    $this->maskedValue = $value;
    // Notify the parent of any changes.
    if (isset($this->parent)) {
      $this->parent->onChange($this->name);
    }
  }

}

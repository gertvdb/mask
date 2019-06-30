<?php

namespace Drupal\mask\Plugin\Field\FieldWidget;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Default widget for mask.
 *
 * @FieldWidget(
 *   id = "mask_default",
 *   label = @Translation("Mask widget"),
 *   field_types = {
 *     "mask"
 *   }
 * )
 */
class MaskFieldWidget extends WidgetBase {

  /**
   * Get the masked value factory.
   *
   * Since at this point Dependency Injection is not provided for
   * Typed Data (https://www.drupal.org/project/drupal/issues/2914419),
   * we use the Drupal service container in a seperate function so this can be
   * reworked later on when issue is resolved.
   *
   * @return \Drupal\mask\Factory\MaskedValueFactory
   *   The masked value factory.
   */
  protected function getMaskedValueFactory() {
    return \Drupal::service('mask.masked_value_factory');
  }

  /**
   * Get the mask factory.
   *
   * Since at this point Dependency Injection is not provided for
   * Typed Data (https://www.drupal.org/project/drupal/issues/2914419),
   * we use the Drupal service container in a seperate function so this can be
   * reworked later on when issue is resolved.
   *
   * @return \Drupal\mask\Factory\MaskFactory
   *   The mask factory.
   */
  protected function getMaskFactory() {
    return \Drupal::service('mask.mask_factory');
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $formState) {

    /** @var \Drupal\mask\Plugin\Field\FieldType\MaskFieldItemInterface $item */
    $item = $items[$delta];

    /** @var \Drupal\mask\MaskedValueInterface|null $value */
    $value = $item->toMaskedValue();

    // Get settings.
    $fieldDefinitions = $item->getFieldDefinition();
    $provider = $fieldDefinitions->getSetting('provider');

    $element['value'] = [
      '#title' => $this->t('Mask'),
      '#type' => 'mask_by_plugin',
      '#plugin_id' => $provider,
      '#default_value' => $value ? $value->getMaskedValue() : FALSE,
      '#settings' => [],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $formState) {
    $newValues = [];

    foreach ($values as $delta => $value) {
      $mask = $this->getMaskFactory()->createMask($value['value']['mask']);
      $maskedValue = $this->getMaskedValueFactory()->createMaskedValue($value['value']['masked'], $value['value']['unmasked'], $mask);
      if ($maskedValue) {
        $newValues[$delta] = $maskedValue->toArray();
      }
    }

    return $newValues;
  }

}

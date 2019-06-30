<?php

namespace Drupal\iso3166\Plugin\Field\FieldWidget;

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
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $formState) {

    // @TODO : Finish field.
    $element['value'] = [
      '#title' => $this->t('Mask'),
      '#type' => 'textfield',
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $formState) {
    $newValues = [];
    foreach ($values as $delta => $value) {
      $newValues[$delta] = $value;
    }
    return $newValues;
  }

}

<?php

namespace Drupal\mask\Plugin\Field\FieldFormatter;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Default formatter for mask.
 *
 * @FieldFormatter(
 *   id = "mask_default",
 *   label = @Translation("Mask formatter"),
 *   field_types = {
 *     "mask"
 *   }
 * )
 */
class MaskFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    /* @var \Drupal\mask\Plugin\Field\FieldType\MaskFieldItemInterface $item */
    foreach ($items as $delta => $item) {
      $mask = $item->toMaskedValue();
      if ($mask) {

        $elements[$delta] = [
          '#markup' => $mask->getMaskedValue(),
        ];
      }
    }

    return $elements;
  }

}

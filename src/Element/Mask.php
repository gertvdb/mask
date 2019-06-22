<?php

namespace Drupal\mask\Element;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\FormElement as FormElementBase;
use Drupal\Core\Render\Annotation\FormElement;
use Drupal\Core\Render\Element\CompositeFormElementTrait;

/**
 * Provides a masked form input element.
 *
 * Properties:
 * -
 *
 * Example usage:
 * @code
 * $form['mask'] = array(
 *   '#type' => 'mask',
 *   '#title' => $this->t('Mask'),
 * );
 * @end
 *
 * @FormElement("mask")
 */
class Mask extends FormElementBase {

  use CompositeFormElementTrait;

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#process' => [
        [$class, 'processMask'],
      ],
      '#pre_render' => [
        [$class, 'preRenderCompositeFormElement'],
      ],
      '#theme_wrappers' => ['mask'],
      '#mask' => FALSE,
      '#settings' => [],
    ];
  }

  /**
   * Generate a unique identifier.
   *
   * @return string
   */
  private static function generateUniqueIdentifier() {
    $uuidService = \Drupal::service('uuid');
    return $uuidService->generate();
  }

  /**
   * Process Mask element.
   *
   * @param $element
   *
   * @return mixed
   */
  public static function processMask($element) {
    $element['#tree'] = TRUE;

    // Prepare element for JS functionality.
    $uuid = self::generateUniqueIdentifier();
    $element['#attributes']['data-uuid'] = $uuid;
    $element['#attributes']['data-class'] = 'js--mask';

    /** @var \Drupal\mask\Mask $mask */
    $mask = $element['#mask'];
    $settings = $element['#settings'];
    if (!$mask instanceof \Drupal\mask\Mask) {
      return $element;
    }

    // Apply all mask definitions.
    $definitions = [];
    /** @var \Drupal\mask\MaskDefinition $definition */
    foreach($mask->getDefinitions() as $definition) {
      $definitions[(string) $definition->getCharacter()] = $definition->getPatternJs();
    };

    $settings['definitions'] = $definitions;
    $settings['mask'] = $mask->getMask();

    $element['#attached']['library'][] = 'mask/mask';
    $element['#attached']['drupalSettings']['maskSettings'][$uuid] = Json::encode($settings);

    $element['masked_value'] = [
      '#type' => 'textfield',
      '#theme' => 'input__mask',
      '#attributes' => [
        'data-class' => ['js--mask--masked'],
      ],
    ];

    Element::setAttributes( $element['masked_value'], ['id', 'name', 'value', 'size', 'placeholder']);

    $element['value'] = [
      '#type' => 'hidden',
      '#attributes' => [
        'data-class' => ['js--mask--clean'],
      ],
    ];

    return $element;
  }

}

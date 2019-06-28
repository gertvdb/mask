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
  protected static function generateUniqueIdentifier() {
    $uuidService = \Drupal::service('uuid');
    return $uuidService->generate();
  }

  /**
   * Get the mask to apply.
   *
   * @param array $element
   *
   * @return \Drupal\mask\Mask|null
   */
  protected static function getMask(array $element) {

    // Make sure a mask is set.
    $mask = $element['#mask'];
    if ($mask instanceof \Drupal\mask\Mask) {
      return $mask;
    }

    return NULL;
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
    $mask = self::getMask($element);
    if (!$mask) {
      return $element;
    }

    $element['#attributes']['data-uuid'] = $uuid;
    $element['#attributes']['data-class'] = 'js--mask';


    // Apply all mask definitions.
    $definitions = [];
    /** @var \Drupal\mask\MaskDefinition $definition */
    foreach($mask->getDefinitions() as $definition) {
      $definitions[(string) $definition->getCharacter()] = $definition->getPattern();
    };

    $settings['definitions'] = $definitions;
    $settings['mask'] = $mask->getMask();

    $element['#attached']['library'][] = 'mask/mask';
    $element['#attached']['drupalSettings']['maskSettings'][$uuid] = Json::encode($settings);

    $element['masked'] = [
      '#type' => 'textfield',
      '#theme' => 'input__mask',
      '#attributes' => [
        'data-class' => ['js--mask--masked'],
      ],
    ];

    Element::setAttributes( $element['masked'], ['id', 'name', 'value', 'size', 'placeholder']);

    $element['unmasked'] = [
      '#type' => 'hidden',
      '#attributes' => [
        'data-class' => ['js--mask--unmasked'],
      ],
    ];

    $element['mask'] = [
      '#type' => 'hidden',
      '#value' => $mask->getMask(),
    ];

    return $element;
  }

}

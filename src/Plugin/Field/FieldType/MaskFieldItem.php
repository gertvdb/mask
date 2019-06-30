<?php

namespace Drupal\mask\Plugin\Field\FieldType;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldType;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\mask\MaskedValueInterface;

/**
 * Plugin implementation of the 'mask' field type.
 *
 * @FieldType(
 *   id = "mask",
 *   label = @Translation("Mask"),
 *   description = @Translation("Create and store masked field."),
 *   default_widget = "mask_default",
 *   default_formatter = "mask_default",
 * )
 */
class MaskFieldItem extends FieldItemBase implements MaskFieldItemInterface {

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
   * Get the country manager.
   *
   * Since at this point Dependency Injection is not provided for
   * Typed Data (https://www.drupal.org/project/drupal/issues/2914419),
   * we use the Drupal service container in a seperate function so this can be
   * reworked later on when issue is resolved.
   *
   * @return \Drupal\mask\Plugin\Mask\MaskManagerInterface
   *   The mask manager.
   */
  protected function getMaskManager() {
    return \Drupal::service('plugin.manager.mask');
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'provider' => '',
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $formState, $hasData) {
    $element = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'storage-settings',
      ],
    ];

    $providerSettings = $this->getSetting('provider');
    $providerFormState = $formState->getValue(['settings', 'provider']);
    $provider = $providerFormState ?: $providerSettings;

    $providerOptions = [];
    $collectionManager = $this->getMaskManager();
    $definitions = $collectionManager->getDefinitions();
    foreach ($definitions as $pluginId => $pluginConfig) {
      /* @var \Drupal\mask\Plugin\Mask\Mask\MaskPluginInterface $collection */
      $collection = $collectionManager->createInstance($pluginId, $pluginConfig);
      $providerOptions[$pluginId] = $collection->getLabel();
    }

    $element['provider'] = [
      '#type' => 'select',
      '#title' => $this->t('Provider'),
      '#description' => $this->t('Select the cmask provider to use for the field.'),
      '#required' => TRUE,
      '#multiple' => FALSE,
      '#options' => $providerOptions,
      '#disabled' => $hasData ? 'disabled' : FALSE,
      '#field_name' => $this->getFieldDefinition()->getName(),
      '#default_value' => $provider,
      '#submit' => [$this, 'submitCallback'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $fieldDefinition) {
    $properties['value'] = DataDefinition::create('any')
      ->setLabel(t('Computed Masked Value'))
      ->setDescription(t('The computed masked value object.'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\mask\MaskComputedMaskedValue');

    $properties['masked_value'] = DataDefinition::create('string')
      ->setLabel(t('The masked value'))
      ->setRequired(TRUE);

    $properties['unmasked_value'] = DataDefinition::create('string')
      ->setLabel(t('The unmasked value'))
      ->setRequired(TRUE);

    $properties['mask'] = DataDefinition::create('string')
      ->setLabel(t('The mask applied'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $fieldDefinition) {
    return [
      'columns' => [
        'masked_value' => [
          'description' => 'Stores the masked value',
          'type' => 'varchar',
          'length' => 225,
          'not null' => FALSE,
        ],
        'unmasked_value' => [
          'description' => 'Stores the unmasked value',
          'type' => 'varchar',
          'length' => 225,
          'not null' => FALSE,
        ],
        'mask' => [
          'description' => 'Stores the mask applied',
          'type' => 'varchar',
          'length' => 225,
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ($this->toMaskedValue()) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function onChange($propertyName, $notify = TRUE) {
    // Enforce that the computed masked value is recalculated.
    if (in_array($propertyName, ['masked_value', 'unmasked_value', 'mask'])) {
      $this->set('value', NULL);
    }
    parent::onChange($propertyName, $notify);
  }

  /**
   * {@inheritdoc}
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function setValue($value, $notify = TRUE) {
    // Allow callers to pass a CountryInterface object
    // as the field item value.
    if ($value instanceof MaskedValueInterface) {
      /** @var \Drupal\mask\MaskedValueInterface $value */
      $value = $value->toArray();
    }

    parent::setValue($value, $notify);
  }

  /**
   * Get masked value object.
   *
   * @return \Drupal\mask\MaskedValue|\Drupal\mask\MaskedValueInterface|null
   *   A masked value or NULL
   */
  public function toMaskedValue() {

    $maskedValue = NULL;

    try {
      $maskFactory = $this->getMaskFactory();
      $mask = $maskFactory->createMask($this->get('mask')->getValue());
      $maskedValue = $this->getMaskedValueFactory()->createMaskedValue(
        $this->get('masked_value')->getValue(),
        $this->get('unmasked_value')->getValue(),
        $mask
      );

    }
    catch (\Exception $exception) {
      // Return null on exception.
    }

    return $maskedValue;
  }

}

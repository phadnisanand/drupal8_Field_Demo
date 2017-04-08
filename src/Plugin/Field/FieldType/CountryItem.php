<?php
/**
 * @file
 * Contains \Drupal\country\Plugin\field\field_type\CountryItem.
 */

namespace Drupal\country\Plugin\Field\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Plugin implementation of the 'country' field type.
 *
 * @FieldType(
 *   id = "country",
 *   label = @Translation("Country"),
 *   description = @Translation("Stores the ISO-2 name of a country."),
 *   category = @Translation("Custom"),
 *   default_widget = "country_default",
 *   default_formatter = "country_default"
 * )
 */
class CountryItem extends FieldItemBase {

  const COUNTRY_ISO2_MAXLENGTH = 2;

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Country'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'value' => array(
          'type' => 'char',
          'length' => static::COUNTRY_ISO2_MAXLENGTH,
          'not null' => FALSE,
        ),
      ),
      'indexes' => array(
        'value' => array('value'),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();
    $constraints[] = $constraint_manager->create('ComplexData', array(
      'value' => array(
        'Length' => array(
          'max' => static::COUNTRY_ISO2_MAXLENGTH,
          'maxMessage' => t('%name: the country iso-2 code may not be longer than @max characters.', array('%name' => $this->getFieldDefinition()->getLabel(), '@max' => static::COUNTRY_ISO2_MAXLENGTH)),
        )
      ),
    ));
    return $constraints;
  }
}
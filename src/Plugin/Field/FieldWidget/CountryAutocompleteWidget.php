<?php
namespace Drupal\country\Plugin\Field\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'country_autocomplete' widget.
 *
 * @FieldWidget(
 *   id = "country_autocomplete",
 *   label = @Translation("Country autocomplete widget"),
 *   field_types = {
 *     "country"
 *   }
 * )
 */
class CountryAutocompleteWidget extends WidgetBase {

    public static function defaultSettings() 
	{
		return array(
		  'size' => '60',
		  'autocomplete_route_name' => 'country.autocomplete',
		  'placeholder' => '',
	 	) + parent::defaultSettings();
   }

	public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) 
	{
		$countries = \Drupal::service('country_manager')->getList();
		$element['value'] = $element + array(
			'#type' => 'select',
			'#options' => $countries,
			'#empty_value' => '',
			'#default_value' => (isset($items[$delta]->value) && isset($countries[$items[$delta]->value])) ? $items[$delta]->value : NULL,
			'#description' => t('Select a country'),
		  );
		return $element;
	}

}
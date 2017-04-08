<?php
/**
 * @file
 * Contains \Drupal\country\Controller\CountryAutocompleteController.
 */

namespace Drupal\country\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Unicode;
use Drupal;

/**
 * Returns autocomplete responses for countries.
 */
class CountryAutocompleteController {

  /**
   * Returns response for the country name autocompletion.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object containing the search string.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing the autocomplete suggestions for countries.
   */
  public function autocomplete(Request $request) {
    $matches = array();
    $string = $request->query->get('q');
    if ($string) {
      $countries = \Drupal::service('country_manager')->getList();
      foreach ($countries as $iso2 => $country) {
        if (strpos(Unicode::strtolower($country), Unicode::strtolower($string)) !== FALSE) {
          $matches[] = array('value' => $country, 'label' => $country);
        }
      }
    }
    return new JsonResponse($matches);
  }
}
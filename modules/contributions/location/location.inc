<?php
// $Id: location.inc,v 1.36 2006/06/15 12:30:06 ankur Exp $

define('LOCATION_PATH', drupal_get_path('module', 'location'));

/**
 * @file
 * An implementation of a universal API for location manipulation.  Provides functions for
 * postal_code proximity searching, deep-linking into online mapping services.  Currently,
 * some options are configured through an interface provided by location.module.
 */

include_once LOCATION_PATH.'/earth.inc';
_location_include_configured();

/**
 * Get a deep-link to a mapping service such as Yahoo! Maps or MapPoint given an location.  The
 * call is delegated based on the 'country' value in the $location parameter.
 *
 * @param $location
 *   An associative array where
 *      'street'       => A string representing the street location
 *      'additional'   => A string for any additional portion of the street location
 *      'city'         => A string for the city name
 *      'province'     => The standard postal abbreviation for the province
 *      'country'      => The two-letter ISO code for the country of the location (REQUIRED)
 *      'postal_code'  => The international postal code for the location
 *
 * @return
 *   A link to a map provided by a third-party.  The idea is to encode the appropriate
 *   parameters as HTTP GET variables to the URL.
 */
function location_map_link($location = array(), $link_text = 'See map: ') {
  if (!isset($location['country']) && $location['country'] != 'xx') {
    return '';
  }

  $default_func = 'location_map_link_'. $location['country'] .'_default_providers';
  $providers_func = 'location_map_link_'. $location['country'] .'_providers';
  $providers = function_exists($providers_func) ? $providers_func() : array();
  $selected_providers = variable_get('location_map_link_'. $location['country'], function_exists($default_func) ? $default_func() : array());

  $links = array();
  foreach ($selected_providers as $mapper) {
    $link_func = 'location_map_link_'. $location['country'] .'_'. $mapper;
    if (function_exists($link_func)) {
      if ($link = $link_func($location)) {
        $links[] = '<a href="'. $link .'">'. $providers[$mapper]['name'] .'</a>';
      }
    }
  }
  if (count($links)) {
    return t($link_text) . implode($links, ", ");
  }
  else {
    return NULL;
  }
}


function location_get_postalcode_data($location = array()) {
  $location['country'] = isset($location['country']) ? trim($location['country']) : NULL;
  $location['postal_code'] = isset($location['postal_code']) ? trim($location['postal_code']) : NULL;
  if (is_null($location['postal_code']) || is_null($location['country']) || empty($location['country']) || empty($location['postal_code']) || $location['postal_code'] == 'xx') {
    return NULL;   
  }
  $country_specific_function = 'location_get_postalcode_data_'. $location['country'];
  if (function_exists($country_specific_function)) {
    return $country_specific_function($location);
  }
  else {
    return NULL;
  }
}

function _location_is_empty($location = array()) {
  $fields = array('street', 'additional', 'city', 'province', 'postal_code', 'country');
  foreach ($fields as $field) {
    if (isset($location[$field]) && strlen(trim($location[$field]))) {
      return FALSE;
    }
  }
  return TRUE;
}

/**
 * Generates HTML for the passed location.
 *
 * @param $location
 *   An associative array where
 *      'street'       => A string representing the street location
 *      'additional'   => A string for any additional portion of the street location
 *      'city'         => A string for the city name
 *      'province'     => The standard postal abbreviation for the province
 *      'country'      => The two-letter ISO code for the country of the location (REQUIRED)
 *      'postal_code'  => The international postal code for the location
 *
 * @param $hide
 *   An linear array where the values are the location fields to suppress in the themed display.
 *
 * @return
 *   An HTML string with special tags for locations.
 */
function theme_location($location = array(), $hide = array()) {
  if (_location_nothing_to_show($location, $hide)) {
    return '';
  }
  $output = '';
  $country_specific_function = 'theme_location_'. (isset($location['country']) ? $location['country'] : '');
  if (function_exists($country_specific_function)) {
    $output .= $country_specific_function($location);
  }
  elseif (count($location)) {
    $output .= "\n";
    $output .= '<dl class="location">'."\n";
    if (!empty($location['name']) && !in_array('name', $hide)) {
       $output .= '<dd>'. $location['name'] .'</dd>';
    }

    if (!empty($location['street']) && !in_array('street', $hide)) {
      $output .= '<dd>'. $location['street'] .'</dd>';
    }
    
    if (!empty($location['additional']) && !in_array('street', $hide)) {
      $output .= '<dd>' . $location['additional'] . '</dd>';
    }
    
    if ((!empty($location['city']) && !in_array('city', $hide)) || 
        (!empty($location['province']) && !in_array('province', $hide)) || 
        (!empty($location['postal_code']) && !in_array('postal_code', $hide))) {
      $output .= '<dd>';
      
      $city_province_postal = array();
      if (!empty($location['city']) && !in_array('city', $hide)) {
        $city_province_postal[] = $location['city'];
      }
      
      if (!empty($location['province']) && !in_array('province', $hide)) {
        $city_province_postal[] = $location['province'];
      }

      if (!empty($location['postal_code']) && !in_array('postal_code', $hide)) {
        $city_province_postal[] = $location['postal_code'];
      }
      
      $output .= implode(', ', $city_province_postal);
      
      $output .= '</dd>';
    }
    
    if (!empty($location['country']) && !in_array('country', $hide)) {
      $countries = _location_get_iso3166_list();
      $output .= '<dd>'. $countries[$location['country']] . '</dd>';
    }
    
    $output .= '</dl>';
  }

  $output .= location_map_link($location);

  return $output;
}

function _location_nothing_to_show($location = array(), $hide = array()) {
  foreach (array('street', 'city', 'province', 'postal_code', 'country') as $field) {
    if (isset($location[$field]) && strlen(trim($location[$field])) && !in_array($field, $hide)) {
      return FALSE;
    }
  }
  return TRUE;
}

/**
 * Given two points in lat/lon form, returns the distance between them.
 *
 * @param $latlonA
 *   An associative array where 
 *      'lon' => is a floating point of the longitude coordinate for the point given by latlonA
 *      'lat' => is a floating point of the latitude coordinate for the point given by latlonB
 *
 * @param $latlonB
 *      Another point formatted like $latlonB
 *
 * @param $distance_unit
 *      A string that is either 'km' or 'mile'.
 *      If neither 'km' or 'mile' is passed, the parameter is forced to 'km'
 *
 * @return
 *    NULL if sense can't be made of the parameters.
 *    An associative array where
 *      'scalar' => Is the distance between the two lat/lon parameter points 
 *      'distance_unit' => Is the unit of distance being represented by 'scalar'.
 *                         This will be 'km' unless 'mile' is passed for the $distance_unit param
 */
function location_distance_between($latlonA = array(), $latlonB = array(), $distance_unit = 'km') {
  if (!isset($latlonA['lon']) || !isset($latlonA['lat']) || !isset($latlonB['lon']) || !isset($latlonB['lat'])) {
    return NULL;
  }
  
  if ($distance_unit != 'km' && $distance_unit != 'mile') {
    return NULL;
  }
  
  // $conversion_factor = number to divide by to convert meters to $distance_unit
  // At this point, $distance_unit == 'km' or 'mile' and nothing else
  //$conversion_factor = ($distance_unit == 'km') ? 1000.0 : 1609.347;
  
  $meters = earth_distance($latlonA['lon'], $latlonA['lat'], $latlonB['lon'], $latlonB['lat']);
  return array('scalar' => round($meters/(($distance_unit == 'km') ? 1000.0 : 1609.347), 1), 'distance_unit' => $distance_unit);
}


/**
 * Generates a Drupal HTML form for collecting locationes.
 *
 * @param $fields
 *   An array of values where each value is one of 'street', 'city', 'province', 'postal_code', or 'country'.
 *   The presence of values in this array determines which fields will be served in the location form generated
 *   by a call to this function.  If this array is empty, all fields are generated.
 *
 * @param $prefilled_values
 *   An associative array where
 *     -> Each key is one of the location fields: 'street', 'additional', 'city', 'province', 'postal_code', 'country'
 *     -> Each value is a prefilled value for the given field.                                       ..... ))
 *
 * @param $required_fields
 *   An array of values that are required.  Each string can be one of 'street', 'city', 'postal_code', 'province', or 'country'.
 *   The presence of values in this array determines which fields will be marked as 'required'.  Validation (i.e., making sure
 *   a required value is actually filled in is the responsibility of the caller)   
 *
 * @param $suppressed_values
 *   An array of values that are to be automatically filled and hidden from user view.  These will be indicated in this
 *   associative array with the following possibilities for keys:
 *     'province' => The standard province value as defined keyed by the country specific file (e.g., for US states, its the
 *                   capitalized two letter abbreviation.
 *     'country' => The lower-case two letter ISO code for the country being assumed.
 *
 * @param $description
 *   A text description of specifically what location is being collected by the form to be served.
 *
 * @param $form_name
 *   An additional parameter to help prevent HTML input name collisions.  If the caller is using this
 *   function to generate more than 1 location form on a page, then the generated name for each HTML input's 
 *   "name" attribute will go by the value supplied for $form_name.  This parameter is defaulted to 'location' 
 *   For example, if $form_name == 'xyz' and there is a 'street' field in the form to be served, 
 *   the "name" attribute for the HTML <input> will be "edit[xyz][street]"
 *
 * @param $function
 *   A string that tells location_form() which location API function will be using the location submitted via the
 *   generated form.  For example, if $function == 'latlon_rough', then the returned location_form (if it includes
 *   a country field) will only generate a list of countries in the HTML select for which function location_latlon_rough()
 *   is supported.  To figure out which countries these are, we check to see which of the configured countries have existing 
 *   functions to support the call.  In this case, we would check to see if there existed a function called "location_latlon_rough_us()"
 *   before listing the United States in the HTML SELECT for the generated location form.  $function is defaulted to NULL.
 *   If $function is NULL, the HTML SELECT that is generated will list all countries.
 * 
 * @return
 *   An location form based on the parameters specified.  If the $fields array is empty, then the
 *   function returns a form in which all possible fields are served as optional form items.
 *
 *
 * EXAMPLES:
 *
 *    -> The following call returns a form that only contains fields for a postal_code and country where
 *       the postal_code is required:
 *            ---  
 *            $form = location_form(array('postal_code', 'country'), array(), array('postal_code', 'country'), 'Permanent location')
 *            ---
 *       The form returned by this call is generated with calls to Drupal's 'form_' functions:
 *
 *            $form  = form_textfield('Postal Code', 'location][postal_code', '', 64, 64, NULL, NULL, TRUE);
 *       -------------------------------------------------------------------------------------------------
 *    -> The following call returns a form that contains fields for a street, province, and postal_code,
 *       but the street, city, and province fields are optional while postal_code is required:
 *            ---
 *            $form = location_form(array('street', 'city', 'province', 'postal_code'), array(), array('postal_code'));
 *            ---
 *    -> The form returned by this call is generated with the following calls to Drupal's 'form_' functions:
 *
 *            $form  = form_textfield('Street', 'location][street', '', 64, 64);
 *            $form .= form_textfield('Additional', 'location][additional', '', 64, 64);
 *            // The 'Additional' field is always and only generated when 'street' is specified as one of the fields.
 *            // The 'Additional' field is always optional whether or not 'Street' is required.
 *            $form .= form_textfield('City', 'location][city', '', 64, 64);
 *            $form .= _location_province_select_options(); // defined below
 *            $form .= form_textfield('Postal Code', 'location][postal_code', '', 64, 64, NULL, NULL, TRUE);
 *        ------------------------------------------------------------------------------------------------
 *    For the following examples, assume we have the following two locationes:
 *       (1) $locationA = ('street' => '2010 Broadway St', 'city' => 'Redwood City', 'province' => 'CA', 'postal_code' => '94063', 'country' => 'us');
 *       (2) $locationB = ('street' => '2010 Broadway St', 'city' => 'Redwood City', 'province' => 'us-CA', 'postal_code' => '94063', 'country' => 'us');
 *     -> The following calls return the exact same form that contains fields for a street, province, postal_code, where prefilled
 *        values are submitted to the form.
 *
 *            $form = location_form(array('street', 'city', 'province', 'postal_code', 'country'), $locationB, array('street', 'city', 'province', 'postal_code', 'country'), '', 'home_location');
 *
 *            $form = location_form(array('street', 'city', 'province', 'postal_code', 'country'), location_api2form($locationA), array('street', 'city', 'province', 'postal_code', 'country'), '', 'home_location');
 *
 *     -> The form returned by these call is ultimately generated with the following calls to Drupal's 'form_' functions:
 *
 *            $form  = textfield('Street', 'home_location][street', '2010 Broadway St.', 64, 64, NULL, NULL, TRUE);
 *            $form .= textfield('Additional', 'home_location][additional', 'Attn: Ankur Rishi', 64, 64, NULL, NULL, TRUE);
 *            $form .= textfield('City', 'home_location][city', 'Redwood City', 64, 64, NULL, NULL, TRUE);
 *            $form .= _location_province_select_options(TRUE, 'us-CA', 'home_location');
 *            $form .= textfield('Postal Code', 'home_location][postal_code', '94063', 64, 64, NULL, NULL, TRUE);
 *            $form .= _location_country_select_options(TRUE, 'us', 'home_location');
 *
 *        Note that in both cases, the first and third argument can take the same array since all the fields are being required.
 */
function location_form($fields = array(), $prefilled_values = array(), $required_fields = array(), $suppressed_values = array(), $description = '', $form_name = 'location', $function = NULL) {
  if (count($fields) == 0) {
    $fields = array('name', 'street', 'city', 'province', 'postal_code', 'country');
  }

  $form = array();
  $form['description'] = array(
      '#type' => 'markup',
      '#value' => $description
      );

  if (in_array('name', $fields)) {
    $form['name'] = array(
        '#prefix' => '<div class="container-inline">',
        '#suffix' => "</div>\n",
        '#type' => 'textfield',
        '#title' => t('Location name'),
        '#default_value' => isset($prefilled_values['name']) ? $prefilled_values['name'] : '',
        '#size' => 64,
        '#maxlength' => 64,
        '#description' => t('e.g. a place of business, venue, meeting point'),
        '#attributes' => NULL,
        '#required' => in_array('name', $required_fields)
        );
  }
  if (in_array('street', $fields)) {
    $form['street'] = array(
        '#prefix' => '<div class="container-inline">',
        '#suffix' => "</div>\n",
        '#type' => 'textfield',
        '#title' => t('Street'),
        '#default_value' => isset($prefilled_values['street']) ? $prefilled_values['street'] : '',
        '#size' => 64,
        '#maxlength' => 64,
        '#required' => in_array('street', $required_fields)
        );
    $form['additional'] = array(
        '#prefix' => '<div class="container-inline">',
        '#suffix' => "</div>\n",
        '#type' => 'textfield',
        '#title' => t('Additional'),
        '#default_value' => isset($prefilled_values['additional']) ? $prefilled_values['additional'] : '',
        '#size' => 64,
        '#maxlength' => 64
        );
  }
  if (in_array('city', $fields)) {
    $form['city'] = array(
        '#prefix' => '<div class="container-inline">',
        '#suffix' => "</div>\n",
        '#type' => 'textfield',
        '#title' => t('City'),
        '#default_value' => isset($prefilled_values['city']) ? $prefilled_values['city'] : '',
        '#size' => 64,
        '#maxlength' => 64,
        '#description' => NULL,
        '#attributes' => NULL,
        '#required' => in_array('city', $required_fields)
        );
  }
  if (in_array('province', $fields)) {
    if (in_array('province', array_keys($suppressed_values))) {
      $form['province'] = array(
          '#type' => 'hidden',
          '#value' => $suppressed_values['province']
          );
    }
    else {
      $form['province'] = _location_province_select_options(isset($prefilled_values['province']) ? $prefilled_values['province'] : '', in_array('province', $required_fields), in_array('country', array_keys($suppressed_values)) ? $suppressed_values['country'] : NULL);
      $form['province']['#prefix'] = '<div class="container-inline">';
      $form['province']['#suffix'] = "</div>\n";
    }
  }
  if (in_array('postal_code', $fields)) {
    $form['postal_code'] = array(
        '#prefix' => '<div class="container-inline">',
        '#suffix' => "</div>\n",
        '#type' => 'textfield',
        '#title' => t('Postal code'),
        '#default_value' => isset($prefilled_values['postal_code']) ? $prefilled_values['postal_code'] : '',
        '#size' => 16,
        '#maxlength' => 16,
        '#required' => in_array('postal_code', $required_fields)
        );
  }
  if (in_array('country', $fields)) {
    if (in_array('country', array_keys($suppressed_values))) {
      $form['country'] = array(
          '#type' => 'hidden',
          '#value' => $suppressed_values['country']
          );
    }
    else {
      $form['country'] = _location_country_select_options(isset($prefilled_values['country']) ? $prefilled_values['country'] : '', in_array('country', $required_fields), $function);
      $form['country']['#prefix'] = '<div class="container-inline">';
      $form['country']['#suffix'] = "</div>\n";
    }
  }
  
  return $form;
}

function location_latlon_form($description = '', $prefilled_values = array()) {
  $form = array();

  $usegmap = (function_exists('gmap_set_location') && variable_get('location_usegmap', FALSE));

  if ($usegmap) {
    $form['map'] = array();  //reserve spot at top of form for map
  }
  
  $form['latitude'] = array(
      '#prefix' => '<div class="container-inline">',
      '#type' => 'textfield',
      '#title' => t('Latitude'),
      '#default_value' => isset($prefilled_values['latitude']) ? $prefilled_values['latitude'] : '',
      '#size' => 64,
      '#maxlength' => 64
      );
  $form['longitude'] = array(
      '#type' => 'textfield',
      '#title' => t('Longitude'),
      '#default_value' => isset($prefilled_values['longitude']) ? $prefilled_values['longitude'] : '',
      '#size' => 64,
      '#maxlength' => 64,
      '#description' => $description,
      '#suffix' => '</div>'
      );
      
  if ($usegmap) {
    $map_macro = variable_get('gmap_user_map', '[gmap|id=usermap|center=0,30|zoom=16|width=100%|height=400px]');
    $form['map']['gmap']['#value'] = gmap_set_location($map_macro, $form['longitude'], $form['latitude']);
  }
  
  return $form;
}

/**
 * @param $location
 *   An associative array that has been submitted by an HTML form generated by location_form().
 *
 * @return
 *   An associative array in which the submitted values are modified to pass to the location API
 *   as the $location parameter (excepting location_form()).
 *
 *   This means changing the province field to remove the country code and dash.
 *   For example: California is served by the key 'us-CA' in the location form and this is what is passed when it is
 *                submitted through a form generated by location_form().
 *
 *                This is changed to 'CA' in the returned array.
 */
function location_form2api($location = array()) {
  // The user may have selected a state/province, but did not specify a country
  if (isset($location['province']) && strlen($location['province']) && $location['province'] != 'xx') {
    if (!isset($location['country']) || (isset($location['country']) && !strlen($location['country']))) {
      $location['country'] = substr($location['province'], 0, 2);
    }
  }

  $translated = array();
  $location = is_array($location) ? $location : array();
  foreach ($location as $key => $value) {
    $value = trim($value);
    if ($key == 'province') {
      if (strlen($value) && $value != 'xx') {
        // chop off the 2-letter code and the '-' from the front of the value
        $value = substr($value, 3);
      }
    }
    $translated[$key] = $value;
  }
  return $translated;
}

/**
 * Inverse of location_form2api()
 *
 * @param $location
 *   An associative array that can be passed as the $location parameter to the location API.
 *
 * @return
 *   An associative array with the same values modified so that the array can be passed as the
 *   $prefilled_values parameter to location_api2form()
 *
 *   Meant to take the standard location array format used by the public API (minus the form generating functions) and convert them
 *   into values that can be used by location_form() to fill in the prefilled values.
 */
function location_api2form($location = array()) {
  $translated = array();
  foreach ($location as $key => $value) {
    if ($key == 'province') {
      if (strlen($value) && isset($location['country']) && strlen($location['country']) && $location['province'] != 'xx' && $location['country'] != 'xx') {
        $translated['province'] = $location['country'] .'-'. $value;
      }
    }
    else {
      $translated[$key] = $value;
    }
  }
  return $translated;
}

/**
 * This function generates a form for doing proximity searches within a certain distance
 * of a specified point.  
 *
 * Depending on the context within which this function is called, the search-point can either
 * be user-supplied via the location form that is passed (if one is available) or done within 
 * a search-point extracted from a contact table or some other location source specified by 
 * the programmer calling this function.
 *
 * @param $prefilled_values
 *   An associative array for prefilled values for the proximity search parameters, where 
 *     'distance' => is the prefilled int value to be selected for the distance scalar
 *     'distance_unit' => is 'km' or 'mile'
 * 
 * @param $suppressed_values
 *   An associative array for values you wish to force the selection of rather than pre-fill as a default.
 *   The value will be passed as a hidden form input.  The passed values will be taken in as an associative
 *   array where 
 *     'distance' => a preselected positive integer for the distance
 *     'distance_unit' => a preselected unit for the distance, one of either 'km' or 'mile'
 *
 * @return
 *   An HTML form (generated by Drupal form functions) that lets users specify proximity search parameters that include distance,
 *   the unit of distance, and a search-point if the optional $location_form parameter is passed.  If one is not passed,
 *   the caller of this function will be assumed to already have one.  
 *
 */
function location_proximity_form($prefilled_values = array(), $suppressed_values = array(), $form_name = 'location') {
  $form[] = array(
      '#prefix' => '<div class="container-inline">',
      '#type' => 'markup',
      '#value' => t('Search within ')
      );
  if (in_array('distance', array_keys($suppressed_values))) {
    $form['distance'] = array(
        '#type' => 'hidden',
        '#value' => $suppressed_values['distance']
        );
  }
  else {
    $form['distance'] = array(
        '#prefix' => t('Search within '),
        '#type' => 'select',
        '#title' => '',
        '#default_value' => (isset($prefilled_values['distance']) ? $prefilled_values['distance'] : 25),
        '#options' => array(5 => 5, 10 => 10, 25 => 25, 50 => 50, 100 => 100, 250 => 250),
        '#description' => ''
        );
  }
  
  if (in_array('distance_unit', array_keys($suppressed_values))) {
    $form['distance_unit'] = array(
        '#type' => 'hidden',
        '#value' => $suppressed_values['distance_unit'],
        '#suffix' => (($suppressed_values['distance_unit'] == 'mile') ? t(' miles') : t(' km')) . t(' of:')
        );
  }
  else {
    $form['distance_unit'] = array(
        '#type' => 'select',
        '#title' => '',
        '#default_value' => (isset($prefilled_values['distance_unit']) ? $prefilled_values['distance_unit'] : 'mile'),
        '#options' => array('mile' => 'miles', 'km' => 'km'),
        '#suffix' => t(' of:')
        );
  }
  
  $form[] = array(
      '#type' => 'markup',
      '#value' => t(' of:'),
      '#suffix' => '</div>'
      );
  return $form;
}

/**
 * A helper function that tells you whether all the fields of an location are full (excluding the 'additional' field.
 *
 * @param $location
 *   An associative array where
 *     -> The keys are the different field names of an location: 'street', 'additional', 'city', 'province', 'postal_code', and 'country'
 *
 * @return
 *   TRUE if there is a non-empty (trimmed) string for the following keys' values: 'street', 'city', 'province', 'postal_code', 'country'.
 *   FALSE otherwise.
 */
function _location_is_full($location = array()) {
  if (!isset($location['street']) && trim($location['street']) != '') {
    return FALSE;
  }
  
  if (!isset($location['city']) && trim($location['city']) != '') {
    return FALSE;
  }
  
  if (!isset($location['province']) && trim($location['province']) != '') {
    return FALSE;
  }
  
  if (!isset($location['postal_code']) && trim($location['postal_code']) != '') {
    return FALSE;
  }
  
  if (!isset($location['country']) && trim($location['country']) != '') {
    return FALSE;
  }
  
  return TRUE;
}


/**
 * Takes two locationes and tries to return a deep-link to driving directions. 
 *
 * Parameters:
 * @param $locationA
 *   An associative array that represents an location where
 *      'street'       => the street portions of the location
 *      'additional'   => additional street portion of the location
 *      'city'         => the city name
 *      'province'     => the province, state, or territory
 *      'country'      => lower-cased two-letter ISO code (REQUIRED)
 *      'postal_code'  => the postal code
 * 
 * @param $locationB
 *   An associative array that represents an location in the same way that
 *   parameter $locationA does.
 *
 * @param $link_text
 *   The text of the HTML link that is to be generated.
 *
 * @return 
 *   A deep-link to driving directions on Yahoo! or some other mapping service, if enough fields are filled in the parameters.
 *   A deep-link to a form for driving directions with information pre-filled if not enough, but some fields are filled in the parameters.
 *   The empty string if no information is provided (or if so little information is provided that there is no function to which to delegate
 *   the call.
 *
 *   We dispatch the call to a country-specific function.  The country-specific function, in this case,
 *   will be the one reflected by the country parameter of the first function.  We require that
 *   both locationes supplied have a country field at the minimum.  
 *
 *   The country-specific functions will ultimately decide, with the parameters given, whether to
 *   to link to a form for driving directions is provided, where this form will be
 *   pre-populated with whatever values were available or whether to link directly to the driving
 *   directions themselves if enough fields are filled for each location.
 */
function location_driving_directions_link($locationA = array(), $locationB = array(), $link_text = 'Get directions') {
  if (!isset($locationA['country']) || !isset($locationB['country'])) {
    return '';
  }
  
  // For now, return empty string if starting-point and destinations are in different countries
  //if ($locationA['country'] != $locationB['country']) {
  //  return '';
  //}
  // Lines above commented out because I want to let the country-specific function of the departure point decide
  // what it will do with driving destination locationes from other countries.  As an example, Yahoo! Maps supports driving 
  // direction queries for locationes between the U.S. and Canada. 
  
  $driving_direction_function = 'location_driving_directions_link_'. $locationA['country'];
  if (function_exists($driving_direction_function)) {
    $http_link = $driving_direction_function($locationA, $locationB);
    if (strlen($http_link)) {
      return '<a href="'. $http_link .'">'. $link_text .'</a>';
    }
    else {
      return '';
    }
  }
  
  return '';
}

/**
 * Takes an location and a distance and returns an array of all postal-codes (from all countries that are supported)
 * within the specified distance of the specified location.
 *
 * @param $location 
 *   An associative array where
 *     'street'       => the street location
 *     'additional'   => extra street location or building name or hall or something like that.\
 *     'city'         => a city name
 *     'province'     => province code as defined by the country specific include file
 *     'country'      => lower-cased two-letter ISO 3166 code (REQUIRED)
 *     'postal_code'  => the postal_code
 *
 * @param $distance
 *   The number portion of the distance; it is forced to an integer ceiling
 * 
 * @param $distance_unit 
 *   The unit of distance being used for the distance being submitted.
 *   Valid arguments for $distance_unit are 'mile' and 'km'.  If something other than one of
 *   these unit types is submitted for this argument, it is forced to 'km'.
 *
 * @return 
 *   An array where 
 *     -> the keys are a postive integer ranking of the search result's closeness to the parameter $postal_code
 *        with 1 being assigned to the nearest postal code
 *     -> the values are an associative array where 
 *          'postal_code'   => A postal code that fell within the search-radius given by $distance and $distance_unit.
 *          'country'       => The two-letter ISO code for the home-country of this particular postal_code search result.
 *          'city'          => The city to which this postal code belongs.
 *          'province'      => The province to which this postal code belongs.
 *          'lon'           => The longitude coordinate of the approximate center of the area covered by 'postal_code'
 *          'lat'           => The latitude coordinate of the approximate center of the area covered by 'postal_code'
 *          'distance'      => The number of 'km's or 'mile's that are between the approximate center of the area of 
 *                             the $postal_code parameter and that of the 'postal_code' in this subarray
 *          'distance_unit' => The unit of distance specified by 'scalar'
 */
function location_nearby_postalcodes_bylocation($location, $distance, $distance_unit = 'km') {
  // DEBUG: commented code is for testing/debugging purposes
  //$start_time = microtime();

  $latlon = location_latlon_rough($location);
  
  // If we could not get lat/lon coordinates for the given location, return an empty search result set.
  if (!isset($latlon['lat']) || !isset($latlon['lon'])) {
    return array();
  }
  
  // If the distance parameters did not make sense, return an empty search result set.
  if (!($distance_float = _location_convert_distance_to_meters($distance, $distance_unit))) {
    return array();
  }

  $search_results = _location_nearby_postalcodes($latlon['lon'], $latlon['lat'], $distance_float);

  //DEBUG: commented code is for testing/debugging
  //$format_start_time = microtime();
  
  _location_format_search_result_distances($search_results, $distance_unit);
  
  //$format_end_time = microtime();
  //print 'Time for FORMATTING to complete: '. _location_time_difference($format_end_time, $format_start_time) ."<br/>\n";
  
  // DEBUG: commented code is for testing/debugging purposes
  //$end_time = microtime();
  //print 'Time for this search to complete: '. _location_time_difference($end_time, $start_time) ."<br/>\n";
  
  return $search_results;
}

/**
 * Takes a latitude, longitude, and a distance, and returns all postal_codes within 
 *
 * @param $lon
 *   A floating point of the longitude coordinate of the search point
 * 
 * @param $lat
 *   A floating point of the latitude coordinate of the search point
 *
 * @param $distance 
 *   The number portion of the distance; it is forced to an integer ceiling 
 *
 * @param $distance_unit
 *   The unit of distance being used for the distance being submitted.
 *   Valid arguments for $distance_unit are 'mile' and 'km'.  If something other than one of
 *   these unit types is submitted for this argument, it is forced to 'km'.
 *
 * @return 
 *   An array where 
 *     -> the keys are a contatenation of the country's ISO code and the postal code.  For example, if 
 *        one of the search results is for postal code "94803" in the United States, the key is then "us94803"
 *     -> the values are an associative array where 
 *          'postal_code'   => A postal code that fell within the search-radius given by $distance and $distance_unit.
 *          'country'       => The two-letter ISO code for the home-country of this particular postal_code search result.
 *          'lon'           => The longitude coordinate of the approximate center of the area covered by 'postal_code'
 *          'lat'           => The latitude coordinate of the approximate center of the area covered by 'postal_code'
 *          'distance'      => The number of 'km's or 'mile's that are between the approximate center of the area of the 
 *                             $postal_code parameter and that of the 'postal_code' in this array
 *          'distance_unit' => The unit of distance specified by 'distance'
 */
function location_nearby_postalcodes_bylatlon($lon, $lat, $distance, $distance_unit = 'km') {
  // DEBUG: commented code is for testing/debugging purposes
  //$start_time = microtime();

  // If the given $lon/$lat don't make sense, return an empty search result set.
  if (!is_numeric($lon) || !is_numeric($lat)) {
    return array();
  }
  
  // If the distance parameters did not make sense, return an empty search result set.
  $distance_float = _location_convert_distance_to_meters($distance, $distance_unit);
  if (is_null($distance_float)) {
    return array();
  }
  
  $search_results = _location_nearby_postalcodes($lon, $lat, $distance_float);
  _location_format_search_result_distances($search_results, $distance_unit);
  
  // DEBUG: commented code is for testing/debugging purposes
  //$end_time = microtime();
  //print 'Time for this search to complete: '. _location_time_difference($end_time, $start_time)."<br/>\n";

  return $search_results;
}

// Helper function for testing purposes
function _location_time_difference($end_time, $start_time) {
  $end_times = explode(" ", $end_time);
  $start_times = explode(" ", $start_time);
  $time = (($end_times[1] - $start_times[1]) + ($end_times[0] - $start_times[0])) * 1000;
  return $time . ' milliseconds';
}


/**
 * @param $distance
 *   A number in either miles or km. 
 *
 * @param $distance_unit 
 *   Either 'km' or 'mile'
 *
 * @return 
 *   A floating point number where the number in meters after the initially passed scalar has been ceil()'d
 *   This is done after the $distance_unit parmeter is forced to be 'km' or 'mile'
 */
function _location_convert_distance_to_meters($distance, $distance_unit = 'km') {
  if (!is_numeric($distance)) {
    return NULL;
  }
  
  // Force an integer version of distance, just in case anyone wants to add a caching mechanism
  // for postal code proximity searches.
  
  if (is_float($distance)) {
    $distance = intval(ceil($distance));
  }
  
  if ($distance < 1) {
    return NULL;
  }
  
  if ($distance_unit != 'km' && $distance_unit != 'mile') {
    $distance_unit = 'km';
  }
  
  // Convert distance to meters
  //$distance_float = floatval($distance) * (($distance_unit == 'km') ? 1000.0 : 1609.347);
  //return round($distance_float, 2);
  $retval = round(floatval($distance) * (($distance_unit == 'km') ? 1000.0 : 1609.347), 2);
  return $retval;
}


/**
 * Takes an location and returns a "rough" latitude/longitude pair based on the postal code
 * data available for the given country.
 *
 * @param $location
 *   An associative array $location where
 *     'street'       => the street portion of the location
 *     'additional' => additional street portion of the location
 *     'province'     => the province, state, or territory
 *     'country'      => lower-cased two-letter ISO code (REQUIRED)
 *     'postal_code'  => international postal code (REQUIRED)
 *
 * @return
 *   NULL if data cannont be found.
 *   Otherwise, an associative array where
 *     'lat' => is a floating point of the latitude coordinate of this location
 *     'lon' => is a floating point of the longitude coordinate of this location
 */
function location_latlon_rough($location = array()) {
  if (!isset($location['country']) || !isset($location['postal_code'])) {
    return NULL;
  }
  
  $latlon_function = 'location_latlon_rough_'. $location['country'];
  if (function_exists($latlon_function)) {
    return $latlon_function($location);
  }
  else {
    return NULL;
  }
}
 

 
/**
 * This is the main logic-level function for performing proximity postal-code searches.
 * It calls a number of helper functions for finding postal_code results in each country,
 * narrowing down results, formatting the returned array, and sorting the returned array.
 * Finally, it implements a caching mechanism that will return a subset (proper or not)
 * of a previous search's results on the same search-point.
 *
 * @param $lon
 *   A floating point of the longitude coordinate about which the search is being executed 
 *
 * @param $lat
 *   A floating point of the latitude coordinate about which the search is being executed
 *
 * @param $distance 
 *   A floating point of the distance in meters; it is forced to an integer ceiling, but
 *   kept as a float
 *
 * @return
 *   An array where 
 *     -> the keys are a concatenation of the lower-case two-letter ISO country code and the postal code
 *        For example, 94063 in the United States would be 'us94063'
 *     -> the values are an associative array where 
 *          'postal_code' => A postal code that fell within the search-radius given by $distance and $distance_unit.
 *          'country'     => The two-letter ISO code for the home-country of this particular postal_code search result.
 *          'lon'         => The longitude coordinate of the approximate center of the area covered by 'postal_code'
 *          'lat'         => The latitude coordinate of the approximate center of the area covered by 'postal_code'
 *          'distance'    => The floating point distance of the approximate center of this 'postal_code' from the
 *                           parameter lat/lon point in meters
 *
 */
function _location_nearby_postalcodes($lon, $lat, $distance) {
  $search_results = _location_search_results_from_cache($lon, $lat, $distance);
  
  // If there were usable cached search_results then return those and go no further... awwwww yeah.
  if (count($search_results)) {
    return $search_results;
  }
  //------------------------------------------------------------------------------------------
  // Pulling from the cache takes place right here.
  // The cache id ("cid", to be inserted into the cache table) will be a concatenation of
  //   -> "location_prox_search:".
  //   -> round($lon, 3) . ':'.
  //   -> round($lat, 3) . ":".
  //   -> $distance
  // The value of the cached item will be a serialize($result_array)
  //
  // The cache will be cleared of proximity searches when there is a change in countries that have
  // been configured into the system.  
  //------------------------------------------------------------------------------------------
  
  $search_results = array();
    
  $latrange = earth_latitude_range($lon, $lat, $distance);
  $lonrange = earth_longitude_range($lon, $lat, $distance);  

  //$query_start_time = microtime();
  
  $result = db_query('SELECT zip, city, state, country, '. earth_distance_sql($lon, $lat) .' as distance  FROM {zipcodes} WHERE latitude > %f AND latitude < %f AND longitude > %f AND longitude < %f AND '. earth_distance_sql($lon, $lat) .' < %f ORDER by distance', $latrange[0], $latrange[1], $lonrange[0], $lonrange[1], $distance);
  
  while ($result_row = db_fetch_object($result)) {
    $search_results[$result_row->country . $result_row->zip] = array('city' => $result_row->city, 'province' => $result_row->state, 'distance' => $result_row->distance);
  }
  
  //DEBUG: commented code for testing/debugging purposes
  //$query_end_time = microtime();
  
  //print 'TOTAL TIME FOR _location_nearby_postalcodes() '. _location_time_difference($query_end_time, $query_start_time) ."<br/>\n";
  //--------------------------------------------------------------------------------------------
  // This is the spot where search results are cached
  
  cache_set('location_prox_search:'. round($lon, 3) .':'. round($lat, 3) .':'. $distance, serialize($search_results));
  
  // DEBUG: commented code is for testing/debugging purposes
  //print 'POSTAL CODE SEARCH CACHING: Wrote new search results to cache'."<br/>\n";
  //--------------------------------------------------------------------------------------------
  return $search_results;
}

/**
 * Helper function: this function is intended ONLY for use by _location_nearby_postalcodes().
 * It checks the cache for search-results on a given point and returns the appropriate subset
 * if one exists.
 * 
 * @param $lon
 *   A floating point of the longitude coordinate of the search point
 *
 * @param $lat 
 *   A floating point of the latitude coordinate of the search point
 *
 * @param $distance
 *   A floating point of the number of meters of the search radius
 *
 * @return
 *   An array of previous search results.
 *   If a previous search result on the same point was for the same search-radius, that result is returned.
 *   If a previous search result on the same point was for a longer search-radius, a subset of that result is returned.
 *   If a previous search result on the same point was for a shorter search-radius, the cached search-result is thrown out
 *   and an empty array is returned.
 *   If no previous search-result on the same point is in the cache, an empty array.
 */
function _location_search_results_from_cache($lon, $lat, $distance) {
  $cache_id_prefix = 'location_prox_search:'. round($lon, 3) .':'. round($lat, 3) .':';
  
  $result = db_query("SELECT cid FROM {cache} WHERE cid LIKE '%s%%'", $cache_id_prefix);
  
  if ($result_row = db_fetch_object($result)) {
    // A previous search has been done on the same search point, possibily with the an equal or different
    // search radius.
    $cached_key_fields = explode(':', $result_row->cid);
    $previous_search_radius = $cached_key_fields[3];
    
    // If the search-radius is less than or equal to the previous search-radius, then just use
    // the appropriate subset of the previous search result.
    // This is very convenient since previous search results are sorted in ascending order
    // by their distance from the search point.    
    if ($distance <= $previous_search_radius) {

      $cached_search_results = cache_get($result_row->cid);
      $cached_search_results = unserialize($cached_search_results->data);
      // If the cached-search had the exact same search-radius, just return the entire search result's
      // array from before,
      // otherwise, go through the distance-sorted search results and pick them out until the distances 
      // of each search result start being something greater than the current search-radius
      if ($distance == $previous_search_radius) {
        // DEBUG: commented code is for testing/debugging purposes
        //print 'POSTAL CODE SEARCH CACHING: Returning EXACT SAME of search results from before'."<br/>\n";
        return $cached_search_results;
      }
      else {
        $current_search_results = array();
        foreach ($cached_search_results as $key => $cached_result) {
          if ($cached_result['distance'] <= $distance) {
            $current_search_results[$key] = $cached_result;
          }
          else {
            break;
          }
        }
        // DEBUG: commented code is for testing/debugging purposes
        //print 'POSTAL CODE SEARCH CACHING: Returning SUBSET of a previous search\'s results'."<br/>\n";
        return $current_search_results;
      }
    }
    else {
      // If the previous search-radius on the same point is smaller than the current search-radius,
      // then delete the previous search from the cache to make way in the cache for the results of
      // the current, more comprehensive search being done on the same point, but on a larger radius.
      // Return an empty array to let the calling function know that it will have to do a new search.
      
      // DEBUG: commented code is for testing/debugging purposes
      //print 'POSTAL CODE SEARCH CACHING: Throwing out old search on a point because new search uses larger search-radius'."<br/>\n";
      cache_clear_all($result_row->cid);
      return array();
    }
    
  }
  else {
    // This else-clause ties back to the first if-clause in this function.
    // It executes if no search has been done on this point.
    // If the {cache} table did not contain any useful cache id's, return the empty array.
    // This will let the calling function know that it has to do an original search.
    return array();
  }
}

/**
 * Helper function: This function EXPECTS an array that has been returned by
 *                  _location_sort_proximity_search_results()
 *
 * @param $results_array
 *   An array of proximity search results where 
 *      -> the keys are integer rankings starting from 1 for the closest postal_code search result
 *      -> the values are associative arrays where
 *           'postal_code' => is the postal code of the search result
 *           'country'     => is the two-letter ISO of the country
 *           'lon'         => is the longitude coordinate of approximate center of the postal code
 *           'lat'         => is the latitude coordinate of the approximate center of the postal code
 *           'distance'    => is the distance of the approximate center of the result-postal_code from the
 *                            approximate center of the postal_code about which the search was executed.
 *                            This distance is in meters.
 *
 * @param $distance_unit
 *   A string abbreviation of a unit of distance.  This must be either 'mile' or 'km'.  If the argument is
 *   neither, it is forced to take the value of 'km'
 *
 * @return
 *   Returns nothing.
 *   Modifies parameter $results_array so that 'distance' (mentioned above) now points to a string representation 
 *   of distance that goes to 1 decimal place, AFTER it has been converted
 *   from the original meters to the distance unit specified by $distance_unit.
 *   Also adds a key 'distance_unit' => 'mile' or 'km' which reflects the $distance_unit parameter.
 *    
 */
function _location_format_search_result_distances(&$results_array, $distance_unit = 'km') {
  if ($distance_unit != 'km' && $distance_unit != 'mile') {
    $distance_unit = 'km';
  }
  
  // $conversion_factor = number to divide by to convert meters to $distance_unit
  // At this point, $distance_unit == 'km' or 'mile' and nothing else
  $conversion_factor = ($distance_unit == 'km') ? 1000.0 : 1609.347;
  
  foreach ($results_array as $index => $single_result) {
    $results_array[$index]['distance'] = round($single_result['distance']/$conversion_factor, 1);
  }
}

/**
 * Currently, this is not a priority until there is an implementable use for exact longitude, 
 * latitude coordinates for an location.  The idea is that this call will eventually retrieve
 * information through a web-service.  Whereas location_latlon_rough() returns an approximate
 * lat/lon pair based strictly on the postal code where this lat/lon pair is pulled from a
 * database table, this function is intended to send the entire location to a web-service and 
 * to retrieve exact lat/lon coordinates.
 *
 * @param $location
 *   An array where  
 *     -> the key values are 'street', 'additional', 'province', 'country', 'postal_code'
 *     -> the values are:
 *         'street'         => the string representing the street location (REQUIRED)
 *         'additional'     => the string representing the additional street location portion in the location form
 *         'city'           => the city name (REQUIRED)
 *         'province'       => the province code defined in the country-specific include file
 *         'country'        => the lower-case of the two-letter ISO code (REQUIRED)
 *         'postal_code'    => the postal-code (REQUIRED)
 *
 * @return
 *   NULL if the delegated-to function that does the actual look-up does not exist.
 *   If the appropriate function exists, then this function returns an associative array where
 *      'lon' => A floating point number for the longitude coordinate of the parameter location
 *      'lat' => A floating point number for the latitude coordinate of the parameter location
 */
function location_latlon_exact($location = array()) {
  if (isset($location['country']) && trim($location['country']) != '') {
    $exact_latlon_function = 'location_latlon_exact_'. trim($location['country']);
    if (function_exists($exact_latlon_function)) {
      return $exact_latlon_function($location);
    }
    else {
      return NULL;
    }
  }
  return NULL;
}

/**
 * @param $location
 *   An array where  
 *     -> the key values are 'street', 'additional', 'province', 'country', 'postal_code'
 *     -> the values are:
 *         'street'         => the string representing the street location
 *         'additional'     => the string representing the additional street location portion in the location form
 *         'city'           => the city name
 *         'province'       => the province code defined in the country-specific include file
 *         'country'        => the lower-case of the two-letter ISO code
 *         'postal_code'    => the postal-code
 *         'lat'            => a floating-point of the latitude coordinate of this location if one is available
 *         'lon'            => a floating-point of the longitude coordinate of this location if one is available
 *
 * @return
 *   A string of HTML META tags to be include in the HTML head of an HTML page that geocodes
 *   as specifically as possible given the completeness of the parameter $location.  To be used
 *   to register location-specific content to search engines that crawl the site.
 */
function location_geocode_meta_tags($location = array()) {
  $output = "\n";
  if (isset($location['lat']) && isset($location['lon'])) {
    $output .= '<meta name=\'ICBM\' content="'. $location['lat'] .', '. $location['lon'] .'" />'."\n";
    $output .= '<meta name="geo.position" content="'. $location['lat'] .';'. $location['lon'] .'" />'."\n";
  }
  if (isset($location['country'])) {
    $output .= '<meta name="geo.region" content="' . strtoupper($location['country']);
    if (isset($location['province'])) {
      $output .= '-'. $location['province'];
    }
    $output .= '" />'."\n";
  }
  if (isset($location['city'])) {
    $output .= '<meta name="geo.placename" content="'. $location['city'] .'" />'."\n";
  }
  return $output;
}

/**
 * Returns an associative array of countries currently recognized by the
 * site admin's configuration where:
 *   -> the keys represent the two-letter ISO code and
 *   -> the values represent the English name of the country.
 *
 * The array is sorted by the values.
 *
 * Please note the difference between "supported" countries and "configured"
 * countries: A country being "supported" means that there is an include file 
 * to support the country while "configured" implies that the site admin has 
 * configured the site to actually use that country's include file. 
 */
function location_configured_countries() {
  $configured_countries = variable_get('location_configured_countries', array('us' => 1)); // <integer index> => <ISO code>
  $configured_countries = is_array($configured_countries) ? $configured_countries : array(); 
  $supported_countries = _location_supported_countries(); // <ISO code> => <English name>
  $configured_countries_associative = array();
  foreach ($configured_countries as $country_code) {
    if (array_key_exists($country_code, $supported_countries)) {
      $configured_countries_associative[$country_code] = $supported_countries[$country_code];
    }
  }
  asort($configured_countries_associative);
  return $configured_countries_associative;
}


/**
 * Returns an associative array of countries currently supported
 * by the location system where
 *   -> the keys represent the two-letter ISO code and
 *   -> the values represent the English name of the country.
 * The array is sorted the index (i.e., by the short English name of the country).
 *
 * Please note the different between "supported" countries and "configured"
 * countries: A country being "supported" means that there is an include file 
 * to support the country while "configure" implies that the site admin has 
 * configured the site to actually use that country. 
 */
function _location_supported_countries() {
  // '<ISO two-letter code>' => '<English name for country>'
  $iso_list = _location_get_iso3166_list();
  $iso_keys = array_keys($iso_list);
  $supported_countries = array();
  if (is_dir(LOCATION_PATH.'/supported') && $handle = opendir(LOCATION_PATH.'/supported')) {
    $matches = array();
    while ($file = readdir($handle)) {
      if (ereg('location.([a-z]{2}).inc', $file, $matches) && is_file(LOCATION_PATH.'/supported/'. $file)) {
        if (in_array($matches[1], $iso_keys)) {
          $supported_countries[] = $matches[1];
          $matches = array();
        }
      }
    }
  }
  
  $supported_countries = array_flip($supported_countries);
  // In the foreach, here, $index is just an integer that we want to 
  // replace with the name of the country, where the key pointing to it
  // is the two-letter ISO code for the country
  foreach ($supported_countries as $code => $index) {
    $supported_countries[$code] = $iso_list[$code];
  }
  array_multisort($supported_countries);;
  // Return an array where key = <ISO code for country> and values = <English name for country>
  return $supported_countries;
}

/**
 * Given a pre-selected value, whether or not the form-item is required, and an optional form name,
 * generates an HTML select for selecting a country in an location form.
 *
 * @param $value
 *   A pre-selected value for this field.
 *
 * @param $required
 *   A boolean for whether this field is required or not.
 *
 * @param $form_name
 *   The HTML "name" attribute assigned to the generated form element.  Defaults to 'location' if none is specified
 *
 * @return
 *   A form_select where the labels are the English names of the countries and the corresponding value 
 *   attributes for the options are the two-letter ISO code for the countries.
 *   If 'location' is passed as the $form_name, then the HTML "name" attribute for the generated form element
 *   will be "edit[location][country]".
 */
function _location_country_select_options($value = '', $required = FALSE, $function = NULL) {
  if ($function) {
    $function = ($function == 'nearby_postalcodes_bylocation' || $function == 'nearby_postalcodes_bylatlon') ? 'latlon_rough' : $function;
    $countrycodes = array();
    foreach (location_configured_countries() as $code => $full_name) {
      if (function_exists('location_'. $function .'_'. $code)) {
        $countrycodes[$code] = $full_name;
      }
    }
    $countrycodes = array_merge(array('' => ''), $countrycodes);
  }
  else {
    $countrycodes = array_merge(array('' => '', 'xx' => 'NOT LISTED'), _location_get_iso3166_list());
  }
  return array(
      '#type' => 'select',
      '#title' => t('Country'),
      '#default_value' => $value,
      '#options' => $countrycodes,
      '#description' => NULL,
      '#extra' => 0,
      '#multiple' => FALSE,
      '#required' => $required
      );
}

/**
 * The array that is returned is a complete list of state/provinces
 * that belong to the countries enabled by the site's location system.
 *
 * @param $value 
 *   A preselected value for the HTML select form item that is returned.
 *
 * @param $required
 *   A boolean for whether or not the field should be required.
 *
 * @param $country
 *   If you wish to only serve a state/province selection for a particular country while leaving out
 *   state/provinces by all other countries, pass the lower case of the country's two-letter ISO 3166
 *   code in this parameter.  If you wish to serve a province selection from all countries, pass NULL
 *   for this parameter.
 *
 * @param $form_name
 *   A non-spaced string for the generated HTML form item's "name" attribute.  If 'location' is passed,
 *   the generated HTML input field's name will be "edit[location][province]".
 *
 * @return
 *   An associative array where
 *     -> the keys are a contatenation of the countrycode and a three 
 *        digit positive integer unique to each province within a 
 *        country's provinces
 *     -> the values are the full name of the province
 *
 */
function _location_province_select_options($value = '', $required = FALSE, $country = NULL) {
  $options_list = array();
  $options_list[''] = '';
  $options_list['xx'] = t('NOT LISTED');
  if (count($countrycodes) == 1 || $country) {
    if (!$country) {
      $countrycodes = location_configured_countries();
      $countrycodes = array_keys($countrycodes);
      $country = $countrycodes[0];
    }
    $province_listing_function = 'location_province_list_'. $country;
    // Trying to return options in case of only 1 country is configured into system or if $country != null
    if (function_exists($province_listing_function)) {
      $province_list = $province_listing_function();
      if (count($province_list)) {
        $options_list[$country .'000'] = '[ ----- '. t('MAKE A SELECTION') .' ----- ]';
        foreach ($province_list as $province_code => $province_name) {
          $options_list[$country . '-' . $province_code] = $province_name;
        }
      }
    }
  }
  else {
    $countrycodes = location_configured_countries();
    $countrycodes = array_flip($countrycodes);
    foreach ($countrycodes as $country_name => $country_code) {
      // Load country specifice code .inc file if it exists.
      // For example, if country_code for U.S. == 'us', load location.us.inc
      $include_file = LOCATION_PATH.'/supported/location.'. $country_code .'.inc';
      $province_listing_function = 'location_province_list_'. $country_code;
      if (function_exists($province_listing_function)) {
        $province_list = $province_listing_function();
        if (count($province_list)) {
          $options_list[$country_code .'-000'] = '[ ----- '. strtoupper($country_name) .' ----- ]';
          foreach ($province_list as $province_code => $province_name) {
            $options_list[$country_code .'-'. $province_code] = $province_name;
          }
        }
      }
    }
  }
  return array(
      '#type' => 'select',
      '#title' => t('State/Province'),
      '#default_value' => $value,
      '#options' => $options_list,
      '#extra' => 0,
      '#multiple' => FALSE,
      '#required' => $required
      );
}

/**
 * This function simply loads the include file for each country whose
 * locationes are configured to be recognized by the location system.
 */
function _location_include_configured() {
  $configured_country_codes = array_keys(location_configured_countries());
  foreach ($configured_country_codes as $country_code) {
    $filename = LOCATION_PATH.'/supported/location.'. $country_code .'.inc';
    if (file_exists($filename)) {
      include_once($filename);
    }
  }
}

// The following is an array of all countrycode => country-name pairs as layed out in
// ISO 3166-1 alpha-2
function _location_get_iso3166_list() {
  return array('ad' => 'Andorra',
               'ac' => 'Ascension Island',
               'ae' => 'United Arab Emirates',
               'af' => 'Afghanistan',
               'ag' => 'Antigua and Barbuda',
               'ai' => 'Anguilla',
               'al' => 'Albania',
               'am' => 'Armenia',
               'an' => 'Netherlands Antilles',
               'ao' => 'Angola',
               'aq' => 'Antarctica',
               'ar' => 'Argentina',
               'as' => 'American Samoa',
               'at' => 'Austria',
               'au' => 'Australia',
               'aw' => 'Aruba',
               'ax' => 'Aland Islands',
               'az' => 'Azerbaijan',
               'ba' => 'Bosnia and Herzegovina',
               'bb' => 'Barbados',
               'bd' => 'Bangladesh',
               'be' => 'Belgium',
               'bf' => 'Burkina Faso',
               'bg' => 'Bulgaria',
               'bh' => 'Bahrain',
               'bi' => 'Burundi',
               'bj' => 'Benin',
               'bm' => 'Bermuda',
               'bn' => 'Brunei Darussalam',
               'bo' => 'Bolivia',
               'br' => 'Brazil',
               'bs' => 'Bahamas',
               'bt' => 'Bhutan',
               'bv' => 'Bouvet Island',
               'bw' => 'Botswana',
               'by' => 'Belarus',
               'bz' => 'Belize',
               'ca' => 'Canada',
               'cc' => 'Cocos (Keeling) Islands',
               'cd' => 'Democratic Republic of the Congo (formerly Zaire)',
               'cf' => 'Central African Republic',
               'cg' => 'Congo (Republic of the Congo)',
               'ch' => 'Switzerland (Confoederatio Helvetica)',
               'ci' => 'Cote d\'Ivoire (Ivory Coast)',
               'ck' => 'Cook Islands',
               'cl' => 'Chile',
               'cm' => 'Cameroon',
               'cn' => 'China',
               'co' => 'Colombia',
               'cr' => 'Costa Rica',
               'cs' => 'Serbia and Montenegro',
               'cu' => 'Cuba',
               'cv' => 'Cape Verde',
               'cx' => 'Christmas Island',
               'cy' => 'Cyprus',
               'cz' => 'Czech Republic',
               'de' => 'Germany (Deutschland)',
               'dj' => 'Djibouti',
               'dk' => 'Denmark',
               'dm' => 'Dominica',
               'do' => 'Dominican Republic',
               'dz' => 'Algeria',
               'ec' => 'Ecuador',
               'ee' => 'Estonia',
               'eg' => 'Egypt',
               'eh' => 'Western Sahara (formerly Spanish Sahara)',
               'er' => 'Eritrea',
               'es' => 'Spain (Espana)',
               'et' => 'Ethiopia',
               'fi' => 'Finland',
               'fj' => 'Fiji',
               'fk' => 'Falkland Islands',
               'fm' => 'Federated States of Micronesia',
               'fo' => 'Faroe Islands',
               'fr' => 'France',
               'ga' => 'Gabon',
               //'gb' => 'United Kingdom',
               'gd' => 'Grenada',
               'ge' => 'Georgia',
               'gf' => 'French Guiana',
               'gh' => 'Ghana',
               'gi' => 'Gibraltar',
               'gl' => 'Greenland',
               'gm' => 'Gambia',
               'gn' => 'Guinea',
               'gp' => 'Guadeloupe',
               'gq' => 'Equatorial Guinea',
               'gr' => 'Greece',
               'gs' => 'South Georgia and the South Sandwich Islands',
               'gt' => 'Guatemala',
               'gu' => 'Guam',
               'gw' => 'Guinea-Bissau',
               'gy' => 'Guyana',
               'hk' => 'Hong Kong',
               'hm' => 'Heard Island and McDonald Islands',
               'hn' => 'Honduras',
               'hr' => 'Croatia (Hrvatska)',
               'ht' => 'Haiti',
               'hu' => 'Hungary',
               'id' => 'Indonesia',
               'ie' => 'Ireland',
               'il' => 'Israel',
               'in' => 'India',
               'io' => 'British Indian Ocean Territory (including Diego Garcia)',
               'iq' => 'Iraq',
               'ir' => 'Iran',
               'is' => 'Iceland',
               'it' => 'Italy',
               'jm' => 'Jamaica',
               'jo' => 'Jordan',
               'jp' => 'Japan',
               'ke' => 'Kenya',
               'kg' => 'Kyrgyzstan',
               'kh' => 'Cambodia',
               'ki' => 'Kiribati',
               'km' => 'Comoros',
               'kn' => 'Saint Kitts and Nevis',
               'kp' => 'North Korea',
               'kr' => 'South Korea',
               'kw' => 'Kuwait',
               'ky' => 'Cayman Islands',
               'kz' => 'Kazakhstan',
               'la' => 'Laos',
               'lb' => 'Lebanon',
               'lc' => 'Saint Lucia',
               'li' => 'Liechtenstein',
               'lk' => 'Sri Lanka',
               'lr' => 'Liberia',
               'ls' => 'Lesotho',
               'lt' => 'Lithuania',
               'lu' => 'Luxembourg',
               'lv' => 'Latvia',
               'ly' => 'Libya',
               'ma' => 'Morocco',
               'mc' => 'Monaco',
               'md' => 'Moldova',
               'mg' => 'Madagascar',
               'mh' => 'Marshall Islands',
               'mk' => 'Former Yugoslav Republic of Macedonia',
               'ml' => 'Mali',
               'mm' => 'Myanmar (Burma)',
               'mn' => 'Mongolia',
               'mo' => 'Macao (Macau)',
               'mp' => 'Northern Mariana Islands',
               'mq' => 'Martinique',
               'mr' => 'Mauritania',
               'ms' => 'Montserrat',
               'mt' => 'Malta',
               'mu' => 'Mauritius',
               'mv' => 'Maldives',
               'mw' => 'Malawi',
               'mx' => 'Mexico',
               'my' => 'Malaysia',
               'mz' => 'Mozambique',
               'na' => 'Namibia',
               'nc' => 'New Caledonia',
               'ne' => 'Niger',
               'nf' => 'Norfolk Island',
               'ng' => 'Nigeria',
               'ni' => 'Nicaragua',
               'nl' => 'Netherlands',
               'no' => 'Norway',
               'np' => 'Nepal',
               'nr' => 'Nauru',
               'nu' => 'Niue',
               'nz' => 'New Zealand',
               'om' => 'Oman',
               'pa' => 'Panama',
               'pe' => 'Peru',
               'pf' => 'French Polynesia',
               'pg' => 'Papua New Guinea',
               'ph' => 'Philippines',
               'pk' => 'Pakistan',
               'pl' => 'Poland',
               'pm' => 'Saint-Pierre and Miquelon',
               'pn' => 'Pitcairn Islands',
               'pr' => 'Puerto Rico',
               'ps' => 'Palestinian Territories (West Bank and Gaza Strip)',
               'pt' => 'Portugal',
               'pw' => 'Palau',
               'py' => 'Paraguay',
               'qa' => 'Qatar',
               're' => 'Reunion',
               'ro' => 'Romania',
               'ru' => 'Russia',
               'rw' => 'Rwanda',
               'sa' => 'Saudi Arabia',
               'sb' => 'Solomon Islands',
               'sc' => 'Seychelles',
               'sd' => 'Sudan',
               'se' => 'Sweden',
               'sg' => 'Singapore',
               'sh' => 'Saint Helena',
               'si' => 'Slovenia',
               'sj' => 'Svalbard and Jan Mayen Islands',
               'sk' => 'Slovakia',
               'sl' => 'Sierra Leone',
               'sm' => 'San Marino',
               'sn' => 'Senegal',
               'so' => 'Somalia',
               'sr' => 'Suriname',
               'st' => 'Sao Tome and Principe',
               'sv' => 'El Salvador',
               'sw' => 'Sweden',
               'sy' => 'Syria',
               'sz' => 'Swaziland',
               'tc' => 'Turks and Caicos Islands',
               'td' => 'Chad (Tchad)',
               'tf' => 'French Southern Territories',
               'tg' => 'Togo',
               'th' => 'Thailand',
               'tj' => 'Tajikistan',
               'tk' => 'Tokelau',
               'tl' => 'Timor-Leste (East Timor)',
               'tm' => 'Turkmenistan',
               'tn' => 'Tunisia',
               'to' => 'Tonga',
               'tr' => 'Turkey',
               'tt' => 'Trinidad and Tobago',
               'tv' => 'Tuvalu',
               'tw' => 'Taiwan',
               'tz' => 'Tanzania',
               'ua' => 'Ukraine',
               'ug' => 'Uganda',
               'uk' => 'United Kingdom',
               'um' => 'United States Minor Outlying Islands',
               'us' => 'United States',
               'uy' => 'Uruguay',
               'uz' => 'Uzbekistan',
               'va' => 'Vatican City',
               'vc' => 'Saint Vincent and the Grenadines',
               've' => 'Venezuela',
               'vg' => 'British Virgin Islands',
               'vi' => 'U.S. Virgin Islands',
               'vn' => 'Vietnam',
               'vu' => 'Vanuatu',
               'wf' => 'Wallis and Futuna',
               'ws' => 'Samoa',
               'ye' => 'Yemen',
               'yt' => 'Mayotte',
               'za' => 'South Africa',
               'zm' => 'Zambia',
               'zw' => 'Zimbabwe'
              );
}

 
?>

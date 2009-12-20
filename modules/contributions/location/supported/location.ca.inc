<?php
// $Id: location.ca.inc,v 1.4 2006/03/08 06:53:38 dww Exp $


function location_map_link_ca_yahoo($location = array()) {
  $get_query = '?';
  if (isset($location['street'])) {
    $get_query .= 'addr='. urlencode($location['street']) .'&amp;';
  }
  if ($location['province'] != '' || $location['city'] != '' || $location['postal_code'] != '') {
    $get_query .= 'csz='. _location_ca_yahoo_csz_get_field($location) .'&amp;';
  }
  $get_query .= 'country='. urlencode($location['country']);
  return ('http://ca.maps.yahoo.com/maps_result'. $get_query);
}

function location_map_link_ca_google($location = array()) {
  $query_params = array();
  
  foreach (array('street', 'city', 'province', 'postal_code', 'country') as $field) {
    if (isset($location[$field])) {
      $query_params[] = $location[$field];
    }
  }
  
  if (count($query_params)) {
    return ('http://maps.google.ca?q='. urlencode(implode(", ", $query_params)));
  }
  else {
    return NULL;
  }
}

function location_map_link_ca_mapquest($location = array()) {
  if (isset($location['street'])) {
    $get_query .= 'address='. urlencode($location['street']) .'&amp;';
  }
  
  if (isset($location['city'])) {
    $get_query .= 'city='. urlencode($location['city']) .'&amp;';
  }
  
  if (isset($location['province'])) {
    $get_query .= 'state='. urlencode($location['province']) .'&amp;';
  }
  
  if (isset($location['postal_code'])) {
    $get_query .= 'zipcode='. urlencode($location['postal_code']);
  }
  
  if (strlen($get_query)) {
    return 'http://www.mapquest.com/maps/map.adp?searchtype=address&amp;country=CA&amp;'. $get_query;
  }
  else {
    return NULL;
  }
}

function location_map_link_ca_providers() {
  return array('google' => array('name' => 'Google Maps', 'url' => 'http://maps.google.ca', 'tos' => 'http://www.google.ca/help/terms_local.html'),
               'yahoo' => array('name' => 'Yahoo! Maps', 'url' => 'http://ca.maps.yahoo.com' , 'tos' => 'http://help.yahoo.com/help/ca/maps/maps-25.html'),
               'mapquest' => array('name' => 'MapQuest', 'url' => 'http://www.mapquest.com', 'tos' => 'http://www.mapquest.com/features/main.adp?page=legal')
              );
}


function location_map_link_ca_default_providers() {
  return array('google');
}

/**
 * Parameters:
 *   -> $locationA is an associative array that represents a full location where
 *        'street'       => the street portions of the location
 *        'supplemental' => additional street portion of the location
 *        'province'     => the province, state, or territory
 *        'country'      => lower-cased two-letter ISO code (REQUIRED)
 *   -> $locationB is associative array that represents a full location in the same way that
 *       parameter $locationB does.
 *
 * Returns: a link to driving directions
 *
 * For now, assume site-admin wants American driving directions linked to Yahoo! Driving Directions.
 * Maybe later, we can add some kind of country-specific settings page that allows the site-admin to
 * decide which site to link to for driving directions.
 */
function location_driving_directions_link_ca($locationA, $locationB) {
  return _location_driving_directions_link_ca_yahoo($locationA, $locationB);
}


/**
 * Parameters:
 *    Function that is called by location_driving_directions_link_ca() under assumption that it
 *    is the chosen function
 *
 * Returns:
 *    a URL with HTTP GET variables
 *    Depending on how full the locationes are, the URL will either point to the driving directions
 *    on Yahoo! or, if only partial locationes are provided, a URL that points to the *form* for
 *    Yahoo! driving directions where the form is filled with whatever fields have been provided
 *    for the partial location(es).  
 */
function _location_driving_directions_link_ca_yahoo($locationA, $locationB) {
  if (trim($locationB['country']) != 'ca' && trim($locationB['country']) != 'us') {
    return '';
  }
  
  // These are the fields that need to be in each location if we are to provide a direct
  // link to yahoo directions.  If all of these fields don't have values, then we generate
  // a link to the *form* for Yahoo! driving directions rather than directly to the driving
  // directions themselves.
   
  
  foreach ($locationA as $field => $value) {
    $locationA[$field] = trim($value);
  }
  
  foreach ($locationB as $field => $value) {
    $locationB[$field] = trim($value);
  }
  
  if (_location_ca_enough_fields_for_yahoo($locationA) && _location_ca_enough_fields_for_yahoo($locationB)) {
    $yahoo_maps_path = 'dd_result';
  }
  else {
    $yahoo_maps_path = 'dd';
  }
  
  $get_query  = '?';
  
  $get_query .= 'addr='. urlencode($locationA['street']) .'&amp;';
  $get_query .= 'csz=' . _location_ca_yahoo_csz_get_field($locationA) .'&amp;';
  $get_query .= 'country='. urlencode($locationA['country']) .'&amp;';
  
  $get_query .= 'taddr='. urlencode($locationB['street']) .'&amp;';
  $get_query .= 'tcsz=' . _location_ca_yahoo_csz_get_field($locationB) .'&amp;';
  $get_query .= 'tcountry='. urlencode($locationB['country']);
  
  $get_query .= '&amp;getrte='. urlencode('Get Directions');
  
  return ('http://ca.maps.yahoo.com/'. $yahoo_maps_path . $get_query);
}

function _location_ca_enough_fields_for_yahoo($location) {
  // These are the fields that need to be in each location if we are to provide a direct
  // link to yahoo directions.  If all of these fields don't have values, then we generate
  // a link to the *form* for Yahoo! driving directions rather than directly to the driving
  // directions themselves.
  if (strlen($location['street']) && strlen($location['city']) && strlen($location['province'])) {
    return TRUE;
  }
  
  if (strlen($location['street']) && strlen($location['postal_code'])) {
    return TRUE;
  }
  
  if (strlen($location['street']) && strlen($location['city']) && strlen($location['province'])) {
    return TRUE;
  }
  
  return FALSE;
}


// Don't mess with this function unless you understand its logic.  It has to do with
// the question of "to comma or not to comma?"
function _location_ca_yahoo_csz_get_field($location) {
  // For some reasons, to the end of pinpointing a location, Yahoo! Maps and Driving Directions
  // do better a better job with retrieving info based strictly on a Canadian city/province
  // than on a Canadian postal code.
  if ($location['country'] = 'ca') {
    if (strlen($location['city']) && strlen($location['province'])) {
      return urlencode($location['city'] .', '. $location['province']);
    }
    
    if (strlen($location['postal_code'])) {
      return urlencode($location['postal_code']);
    }
  }
  else {
    if (strlen($location['postal_code'])) {
      return urlencode($location['postal_code']);
    }
  
    if (strlen($location['city']) && strlen($location['province'])) {
      return urlencode($location['city'] .', '. $location['province']);
    }
  }
  
  if (strlen($location['city']) || strlen($location['state'])) {
    if (strlen($location['city'])) {
      return urlencode($location['city']);
    }
    else {
      return urlencode($location['state']);
    }
  }
  return '';
}


function location_province_list_ca() {
  return array('AB' => 'Alberta',
               'BC' => 'British Columbia',
               'MB' => 'Manitoba',
               'NB' => 'New Brunswick',
               'NL' => 'Newfoundland and Labrador',
               'NS' => 'Nova Scotia',
               'ON' => 'Ontario',
               'PE' => 'Prince Edward Island',
               'QC' => 'Quebec',
               'SK' => 'Saskatchewan',
               'NT' => 'Northwest Territories',
               'NU' => 'Nunavut',
               'YT' => 'Yukon Territory');
}





function location_province_list_numeric_ca() {
  return array('001' => 'Alberta',
               '002' => 'British Columbia',
               '003' => 'Manitoba',
               '004' => 'New Brunswick',
               '005' => 'Newfoundland and Labrador',
               '006' => 'Nova Scotia',
               '007' => 'Ontario',
               '008' => 'Prince Edward Island',
               '009' => 'Quebec',
               '010' => 'Saskatchewan',
               '011' => 'Northwest Territories',
               '012' => 'Nunavut',
               '013' => 'Yukon Territory');
}

?>

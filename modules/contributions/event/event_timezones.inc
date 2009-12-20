<?php
// $Id: event_timezones.inc,v 1.4.2.3 2006/05/22 13:35:07 killes Exp $
/**
 * Check if time is in Daylight Savings Time
 * 
 * @param
 *   $region a drupal dst region code, corresponding to those from event_get_dst_regions()
 * @param
 *   $timestamp a GMT timestamp
 * @return
 *   0 or 1
 */
function event_is_dst($region, $timestamp) {

  $year = date('Y', $timestamp);
  $dst = event_get_dst_regions();

  // Information on Daylight Saving time was obtained from http://webexhibits.org/daylightsaving/g.html
  switch ($region) {
    case 0:
      return 0;
    case 1: // Egypt
      // start of DST (last Friday in April)
      $dststart = strtotime("-1 week friday GMT", strtotime("1 may $year GMT"));
      // end of DST (last Thursday in September)
      $dstend = strtotime("-1 week thursday GMT", strtotime("1 october $year GMT"));
      break;
    case 2: // Namibia
      // start of DST (first Sunday in September)
      $dststart = strtotime("1 week sunday GMT", strtotime("1 september $year GMT"));
      // end of DST (first Sunday April)
      $dstend = strtotime("1 week sunday GMT", strtotime("1 april $year GMT"));
      break;
    case 3: // Former USSR
      // start of DST (last Sunday in March)
      $dststart = strtotime("-1 week sunday GMT", strtotime("1 april $year GMT"));
      // end of DST (last Sunday October)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT"));
      break;
    case 4: // Iraq, Syria
      // start of DST (April 1st)
      $dststart = strtotime("1 april $year GMT");
      // end of DST (October 1st)
      $dstend = strtotime("1 october $year GMT");
      break;
    case 5: // Israel
      // start of DST (April 1st)
      $dststart = strtotime("1 april $year GMT");
      // end of DST (Saturday between Rosh Hashana (Oct. 4-5) and Yom Kippur (Oct. 13))
      // these values are good for 2005/2006 only, hopefully a good gregorian <-> jewish conversion script can be implemented
      $dstend = strtotime("-1 saturday $year GMT", strtotime("13 october $year GMT"));
      break;
    case 6: // Lebanon, Kirgizstan
      // start of DST (Last Sunday in March)
      $dststart = strtotime("-1 week sunday GMT", strtotime("1 april $year GMT"));
      // end of DST (Last Sunday in October)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT"));
      break;
    case 7: // Palestine
      // start of DST (First Friday on or after April 15th)
      $dststart = strtotime("next friday GMT", strtotime("14 april $year GMT"));
      // end of DST (First Friday on or after October 15th)
      $dstend = strtotime("next friday GMT", strtotime("14 october $year GMT"));
      break;
    case 8: // Iran
      // start of DST (the first day of Farvardin (March 21))
      $dststart = strtotime("21 march $year GMT");
      // end of DST (the first day of Mehr (September 23))
      $dstend = strtotime("23 september $year GMT");
      break;
    case 9: // South Australia
      // start of DST  (last Sunday in October)
      $dststart = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT"));
      // end of DST (last Sunday in March)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 april $year GMT"));
      break;
    case 10: // Australia, Tasmania
      // start of DST  (first Sunday in October)
      $dststart = strtotime("1 week sunday GMT", strtotime("1 october $year GMT"));
      // end of DST (last Sunday in March)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 april $year GMT"));
      break;
    case 11: // New Zealand
      // start of DST  (first Sunday in October)
      $dststart = strtotime("1 week sunday GMT", strtotime("1 october $year GMT"));
      // end of DST (third Sunday in March)
      $dstend = strtotime("3 week sunday GMT", strtotime("1 march $year GMT"));
      break;
    case 12: // Tonga
      // start of DST (first Sunday in November)
      $dststart = strtotime("1 week sunday GMT",  strtotime("1 november $year GMT"));
      // end of DST (last Sunday in January)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 february $year GMT"));
      break;
    case 13: // EU and other European countries
      // start of DST (last Sunday in March 1 am GMT)
      $dststart = strtotime("-1 week sunday GMT", strtotime("1 april $year GMT")) + 3600;
      // end of DST in Europe (last Sunday in October 1 am GMT)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT")) + 3600;
      break;
    case 14: // Russian Federation
      // start of DST (last Sunday in March 2 am local time)
      $dststart = strtotime("-1 week sunday GMT", strtotime("1 april $year GMT")) + 7200;
      // end of DST (last Sunday in October 2 am local time)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT")) + 7200;
      break;
    case 15: // Northern America (where applicable)
      // start of DST  (where applicable) (first Sunday in April 2 am local time)
      $dststart = strtotime("1 week sunday GMT", strtotime("1 april $year GMT")) + 7200;
      // end of DST (where applicable) (last Sunday in October 2 am local time)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT")) + 7200;
      break;
    case 16: // Cuba
      // start of DST  (April 1st)
      $dststart = strtotime("1 april $year GMT");
      // end of DST (last Sunday in October)
      $dstend = strtotime("-1 week sunday GMT", strtotime("1 november $year GMT"));
      break;
    case 17: // Brazil
      // start of DST  (first Sunday in November)
      $dststart = strtotime("1 week sunday GMT", strtotime("1 november $year GMT"));
      // end of DST (third Sunday in February)
      $dstend = strtotime("3 week sunday GMT", strtotime("1 february $year GMT"));
      break;
    case 18: // Chile
      // start of DST  (Second Saturday of October - at midnight)
      $dststart = strtotime("2 week saturday GMT", strtotime("1 october $year GMT"));
      // end of DST (Second Saturday of March - at midnight)
      $dstend = strtotime("2 week sunday GMT", strtotime("1 march $year GMT"));
      break;
    case 19: // Falklands
      // start of DST  (First Sunday on or after 8 September)
      $dststart = strtotime("next sunday GMT", strtotime("7 september $year GMT"));
      // end of DST (First Sunday on or after 6 April)
      $dstend = strtotime("next sunday GMT", strtotime("5 april $year GMT"));
      break;
    case 20: // Paraguay
      // start of DST  (first Sunday in September)
      $dststart = strtotime("1 week sunday GMT", strtotime("1 september $year GMT"));
      // end of DST (first Sunday in April)
      $dstend = strtotime("1 week sunday GMT", strtotime("1 april $year GMT"));
      break;
  }

  return ($dststart <= $timestamp && $timestamp <= $dstend);
}

function event_get_dst_regions() {
  static $regions;

  if(!is_array($regions)) {
     $regions = array(0 => t('None'),
                      1 => t('Egypt'),
                      2 => t('Namibia'),
                      3 => t('Asia - Former USSR'),
                      4 => t('Iraq, Syria'),
                      5 => t('Israel'),
                      6 => t('Lebanon, Kirgizstan'),
                      7 => t('Palestine'),
                      8 => t('Iran'),
                      9 => t('South Australia'),
                      10 => t('Australia, Tasmania'),
                      11 => t('New Zealand'),
                      12 => t('Tonga'),
                      13 => t('EU and other European countries'),
                      14 => t('Russian Federation'),
                      15 => t('North America'),
                      16 => t('Cuba'),
                      17 => t('Brazil'),
                      18 => t('Chile'),
                      19 => t('Falklands'),
                      20 => t('Paraguay')
                     );
  }
  return $regions;
}

function event_zonelist() {
  static $zones;

  if(!is_array($zones)) {
    $tz_array = event_get_timezones();
    $zones = array();
    foreach ($tz_array as $key => $zone) {
      $zones[$key] = $zone['timezone'];
    }
  }

  return $zones;
}

function event_get_offset($zid, $timestamp) {
  $zones = event_get_timezones();
  $zone = $zones[$zid];

  if($zone['dst_region']) {
    // zone is a region which obeys dst, return correct offset
    return (event_is_dst($zone['dst_region'], $timestamp) ? $zone['offset_dst'] : $zone['offset']);
  }
  else {
    // no dst offset for this region
    return $zone['offset'];
  }
}

function event_timezone_map($offset) {
  static $map;

  if(!is_array($map)) {
    $map = array('-43200' => '305',
                 '-39600' => '304',
                 '-36000' => '303',
                 '-34200' => '486',
                 '-32400' => '313',
                 '-28800' => '312',
                 '-25200' => '311',
                 '-21600' => '310',
                 '-18000' => '309',
                 '-14400' => '308',
                 '-12600' => '143',
                 '-10800' => '307',
                 '-7200' => '306',
                 '-3600' => '302',
                 '0' => '487',
                 '3600' => '314',
                 '7200' => '320',
                 '10800' => '321',
                 '12600' => '235',
                 '14400' => '322',
                 '18000' => '323',
                 '19800' => '185',
                 '20700' => '207',
                 '21600' => '324',
                 '23400' => '387',
                 '25200' => '325',
                 '28800' => '326',
                 '32400' => '327',
                 '34200' => '270',
                 '36000' => '315',
                 '37800' => '267',
                 '39600' => '316',
                 '41400' => '438',
                 '43200' => '317',
                 '45900' => '417',
                 '46800' => '318',
                 '50400' => '319');
  }

  return $map[$offset];
}

function event_get_timezones() {
  static $zones;
  if(!is_array($zones)) {
     $zones = array(1 => array('timezone' => t('Africa/Addis_Ababa'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    2 => array('timezone' => t('Africa/Algiers'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    3 => array('timezone' => t('Africa/Asmera'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    4 => array('timezone' => t('Africa/Bangui'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    5 => array('timezone' => t('Africa/Blantyre'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    6 => array('timezone' => t('Africa/Brazzaville'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    7 => array('timezone' => t('Africa/Bujumbura'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    8 => array('timezone' => t('Africa/Cairo'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '1'),
                    9 => array('timezone' => t('Africa/Ceuta'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '1'),
                    10 => array('timezone' => t('Africa/Dar_es_Salaam'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    11 => array('timezone' => t('Africa/Djibouti'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    12 => array('timezone' => t('Africa/Douala'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    13 => array('timezone' => t('Africa/Gaborone'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    14 => array('timezone' => t('Africa/Harare'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    15 => array('timezone' => t('Africa/Johannesburg'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    16 => array('timezone' => t('Africa/Kampala'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    17 => array('timezone' => t('Africa/Khartoum'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    18 => array('timezone' => t('Africa/Kigali'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    19 => array('timezone' => t('Africa/Kinshasa'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    20 => array('timezone' => t('Africa/Lagos'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    21 => array('timezone' => t('Africa/Libreville'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    22 => array('timezone' => t('Africa/Luanda'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    23 => array('timezone' => t('Africa/Lubumbashi'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    24 => array('timezone' => t('Africa/Lusaka'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    25 => array('timezone' => t('Africa/Malabo'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    26 => array('timezone' => t('Africa/Maputo'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    27 => array('timezone' => t('Africa/Maseru'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    28 => array('timezone' => t('Africa/Mbabane'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    29 => array('timezone' => t('Africa/Mogadishu'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    30 => array('timezone' => t('Africa/Nairobi'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    31 => array('timezone' => t('Africa/Ndjamena'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    32 => array('timezone' => t('Africa/Niamey'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    33 => array('timezone' => t('Africa/Porto-Novo'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    34 => array('timezone' => t('Africa/Tripoli'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    35 => array('timezone' => t('Africa/Tunis'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    36 => array('timezone' => t('Africa/Windhoek'), 'offset' => '+7200', 'offset_dst' => '+3600', 'dst_region' => '2'),
                    37 => array('timezone' => t('America/Adak'), 'offset' => '-36000', 'offset_dst' => '-32400', 'dst_region' => '15'),
                    38 => array('timezone' => t('America/Anchorage'), 'offset' => '-32400', 'offset_dst' => '-28800', 'dst_region' => '15'),
                    39 => array('timezone' => t('America/Anguilla'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    40 => array('timezone' => t('America/Antigua'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    41 => array('timezone' => t('America/Araguaina'), 'offset' => '-7200', 'offset_dst' => '-10800', 'dst_region' => '17'),
                    42 => array('timezone' => t('America/Aruba'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    43 => array('timezone' => t('America/Asuncion'), 'offset' => '-10800', 'offset_dst' => '-14400', 'dst_region' => '20'),
                    44 => array('timezone' => t('America/Atka'), 'offset' => '-36000', 'offset_dst' => '-32400', 'dst_region' => '15'),
                    45 => array('timezone' => t('America/Barbados'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    46 => array('timezone' => t('America/Belem'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    47 => array('timezone' => t('America/Belize'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    48 => array('timezone' => t('America/Boa_Vista'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    49 => array('timezone' => t('America/Bogota'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    50 => array('timezone' => t('America/Boise'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    51 => array('timezone' => t('America/Buenos_Aires'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    52 => array('timezone' => t('America/Cambridge_Bay'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    53 => array('timezone' => t('America/Cancun'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    54 => array('timezone' => t('America/Caracas'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    55 => array('timezone' => t('America/Catamarca'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    56 => array('timezone' => t('America/Cayenne'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    57 => array('timezone' => t('America/Cayman'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    58 => array('timezone' => t('America/Chicago'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    59 => array('timezone' => t('America/Chihuahua'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    60 => array('timezone' => t('America/Cordoba'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    61 => array('timezone' => t('America/Costa_Rica'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    62 => array('timezone' => t('America/Cuiaba'), 'offset' => '-10800', 'offset_dst' => '-14400', 'dst_region' => '17'),
                    63 => array('timezone' => t('America/Curacao'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    64 => array('timezone' => t('America/Dawson'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    65 => array('timezone' => t('America/Dawson_Creek'), 'offset' => '-25200', 'offset_dst' => '-25200', 'dst_region' => '0'),
                    66 => array('timezone' => t('America/Denver'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    67 => array('timezone' => t('America/Detroit'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    68 => array('timezone' => t('America/Dominica'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    69 => array('timezone' => t('America/Edmonton'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    70 => array('timezone' => t('America/Eirunepe'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    71 => array('timezone' => t('America/El_Salvador'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    72 => array('timezone' => t('America/Ensenada'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    73 => array('timezone' => t('America/Fort_Wayne'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    74 => array('timezone' => t('America/Fortaleza'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    75 => array('timezone' => t('America/Glace_Bay'), 'offset' => '-14400', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    76 => array('timezone' => t('America/Godthab'), 'offset' => '-10800', 'offset_dst' => '-7200', 'dst_region' => '15'),
                    77 => array('timezone' => t('America/Goose_Bay'), 'offset' => '-14400', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    78 => array('timezone' => t('America/Grand_Turk'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '16'),
                    79 => array('timezone' => t('America/Grenada'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    80 => array('timezone' => t('America/Guadeloupe'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    81 => array('timezone' => t('America/Guatemala'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    82 => array('timezone' => t('America/Guayaquil'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    83 => array('timezone' => t('America/Guyana'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    84 => array('timezone' => t('America/Halifax'), 'offset' => '-14400', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    85 => array('timezone' => t('America/Havana'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '16'),
                    86 => array('timezone' => t('America/Hermosillo'), 'offset' => '-25200', 'offset_dst' => '-25200', 'dst_region' => '0'),
                    87 => array('timezone' => t('America/Indiana/Indianapolis'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    88 => array('timezone' => t('America/Indiana/Knox'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    89 => array('timezone' => t('America/Indiana/Marengo'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    90 => array('timezone' => t('America/Indiana/Vevay'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    91 => array('timezone' => t('America/Indianapolis'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    92 => array('timezone' => t('America/Inuvik'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    93 => array('timezone' => t('America/Iqaluit'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    94 => array('timezone' => t('America/Jamaica'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    95 => array('timezone' => t('America/Jujuy'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    96 => array('timezone' => t('America/Juneau'), 'offset' => '-32400', 'offset_dst' => '-28800', 'dst_region' => '15'),
                    97 => array('timezone' => t('America/Kentucky/Louisville'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    98 => array('timezone' => t('America/Kentucky/Monticello'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    99 => array('timezone' => t('America/Knox_IN'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    100 => array('timezone' => t('America/La_Paz'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    101 => array('timezone' => t('America/Lima'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    102 => array('timezone' => t('America/Los_Angeles'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    103 => array('timezone' => t('America/Louisville'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    104 => array('timezone' => t('America/Maceio'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    105 => array('timezone' => t('America/Managua'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    106 => array('timezone' => t('America/Manaus'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    107 => array('timezone' => t('America/Martinique'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    108 => array('timezone' => t('America/Mazatlan'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    109 => array('timezone' => t('America/Mendoza'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    110 => array('timezone' => t('America/Menominee'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    111 => array('timezone' => t('America/Merida'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    112 => array('timezone' => t('America/Mexico_City'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    113 => array('timezone' => t('America/Miquelon'), 'offset' => '-10800', 'offset_dst' => '-7200', 'dst_region' => '15'),
                    114 => array('timezone' => t('America/Monterrey'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    115 => array('timezone' => t('America/Montevideo'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    116 => array('timezone' => t('America/Montreal'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    117 => array('timezone' => t('America/Montserrat'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    118 => array('timezone' => t('America/Nassau'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    119 => array('timezone' => t('America/New_York'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    120 => array('timezone' => t('America/Nipigon'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    121 => array('timezone' => t('America/Nome'), 'offset' => '-32400', 'offset_dst' => '-28800', 'dst_region' => '15'),
                    122 => array('timezone' => t('America/Noronha'), 'offset' => '-7200', 'offset_dst' => '-7200', 'dst_region' => '0'),
                    123 => array('timezone' => t('America/Panama'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    124 => array('timezone' => t('America/Pangnirtung'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    125 => array('timezone' => t('America/Paramaribo'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    126 => array('timezone' => t('America/Phoenix'), 'offset' => '-25200', 'offset_dst' => '-25200', 'dst_region' => '0'),
                    127 => array('timezone' => t('America/Port-au-Prince'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    128 => array('timezone' => t('America/Port_of_Spain'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    129 => array('timezone' => t('America/Porto_Acre'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    130 => array('timezone' => t('America/Porto_Velho'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    131 => array('timezone' => t('America/Puerto_Rico'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    132 => array('timezone' => t('America/Rainy_River'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    133 => array('timezone' => t('America/Rankin_Inlet'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    134 => array('timezone' => t('America/Recife'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    135 => array('timezone' => t('America/Regina'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    136 => array('timezone' => t('America/Rio_Branco'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    137 => array('timezone' => t('America/Rosario'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    138 => array('timezone' => t('America/Santiago'), 'offset' => '-10800', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    139 => array('timezone' => t('America/Santo_Domingo'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    140 => array('timezone' => t('America/Sao_Paulo'), 'offset' => '-7200', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    141 => array('timezone' => t('America/Scoresbysund'), 'offset' => '-3600', 'offset_dst' => '+0', 'dst_region' => '15'),
                    142 => array('timezone' => t('America/Shiprock'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    143 => array('timezone' => t('America/St_Johns'), 'offset' => '-12600', 'offset_dst' => '-9000', 'dst_region' => '15'),
                    144 => array('timezone' => t('America/St_Kitts'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    145 => array('timezone' => t('America/St_Lucia'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    146 => array('timezone' => t('America/St_Thomas'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    147 => array('timezone' => t('America/St_Vincent'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    148 => array('timezone' => t('America/Swift_Current'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    149 => array('timezone' => t('America/Tegucigalpa'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    150 => array('timezone' => t('America/Thule'), 'offset' => '-14400', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    151 => array('timezone' => t('America/Thunder_Bay'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    152 => array('timezone' => t('America/Tijuana'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    153 => array('timezone' => t('America/Tortola'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    154 => array('timezone' => t('America/Vancouver'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    155 => array('timezone' => t('America/Virgin'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    156 => array('timezone' => t('America/Whitehorse'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    157 => array('timezone' => t('America/Winnipeg'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    158 => array('timezone' => t('America/Yakutat'), 'offset' => '-32400', 'offset_dst' => '-28800', 'dst_region' => '15'),
                    159 => array('timezone' => t('America/Yellowknife'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    160 => array('timezone' => t('Antarctica/Casey'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    161 => array('timezone' => t('Antarctica/Davis'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    162 => array('timezone' => t('Antarctica/DumontDUrville'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    163 => array('timezone' => t('Antarctica/Mawson'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    164 => array('timezone' => t('Antarctica/McMurdo'), 'offset' => '+46800', 'offset_dst' => '+43200', 'dst_region' => '11'),
                    165 => array('timezone' => t('Antarctica/Palmer'), 'offset' => '-10800', 'offset_dst' => '-14400', 'dst_region' => '18'),
                    166 => array('timezone' => t('Antarctica/South_Pole'), 'offset' => '+46800', 'offset_dst' => '+43200', 'dst_region' => '11'),
                    167 => array('timezone' => t('Antarctica/Syowa'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    168 => array('timezone' => t('Antarctica/Vostok'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    169 => array('timezone' => t('Arctic/Longyearbyen'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '14'),
                    170 => array('timezone' => t('Asia/Aden'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    171 => array('timezone' => t('Asia/Almaty'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    172 => array('timezone' => t('Asia/Amman'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '8'),
                    173 => array('timezone' => t('Asia/Anadyr'), 'offset' => '+43200', 'offset_dst' => '+46800', 'dst_region' => '3'),
                    174 => array('timezone' => t('Asia/Aqtau'), 'offset' => '+14400', 'offset_dst' => '+18000', 'dst_region' => '3'),
                    175 => array('timezone' => t('Asia/Aqtobe'), 'offset' => '+18000', 'offset_dst' => '+21600', 'dst_region' => '3'),
                    176 => array('timezone' => t('Asia/Ashgabat'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    177 => array('timezone' => t('Asia/Ashkhabad'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    178 => array('timezone' => t('Asia/Baghdad'), 'offset' => '+10800', 'offset_dst' => '+14400', 'dst_region' => '4'),
                    179 => array('timezone' => t('Asia/Bahrain'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    180 => array('timezone' => t('Asia/Baku'), 'offset' => '+14400', 'offset_dst' => '+18000', 'dst_region' => '3'),
                    181 => array('timezone' => t('Asia/Bangkok'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    182 => array('timezone' => t('Asia/Beirut'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '6'),
                    183 => array('timezone' => t('Asia/Bishkek'), 'offset' => '+18000', 'offset_dst' => '+21600', 'dst_region' => '6'),
                    184 => array('timezone' => t('Asia/Brunei'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    185 => array('timezone' => t('Asia/Calcutta'), 'offset' => '+19800', 'offset_dst' => '+19800', 'dst_region' => '0'),
                    186 => array('timezone' => t('Asia/Chungking'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    187 => array('timezone' => t('Asia/Colombo'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    188 => array('timezone' => t('Asia/Dacca'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    189 => array('timezone' => t('Asia/Damascus'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '4'),
                    190 => array('timezone' => t('Asia/Dhaka'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    191 => array('timezone' => t('Asia/Dili'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    192 => array('timezone' => t('Asia/Dubai'), 'offset' => '+14400', 'offset_dst' => '+14400', 'dst_region' => '0'),
                    193 => array('timezone' => t('Asia/Dushanbe'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    194 => array('timezone' => t('Asia/Gaza'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '7'),
                    195 => array('timezone' => t('Asia/Harbin'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    196 => array('timezone' => t('Asia/Hong_Kong'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    197 => array('timezone' => t('Asia/Hovd'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    198 => array('timezone' => t('Asia/Irkutsk'), 'offset' => '+28800', 'offset_dst' => '+32400', 'dst_region' => '3'),
                    199 => array('timezone' => t('Asia/Istanbul'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '3'),
                    200 => array('timezone' => t('Asia/Jakarta'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    201 => array('timezone' => t('Asia/Jayapura'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    202 => array('timezone' => t('Asia/Jerusalem'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '5'),
                    203 => array('timezone' => t('Asia/Kabul'), 'offset' => '+16200', 'offset_dst' => '+16200', 'dst_region' => '0'),
                    204 => array('timezone' => t('Asia/Kamchatka'), 'offset' => '+43200', 'offset_dst' => '+46800', 'dst_region' => '3'),
                    205 => array('timezone' => t('Asia/Karachi'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    206 => array('timezone' => t('Asia/Kashgar'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    207 => array('timezone' => t('Asia/Katmandu'), 'offset' => '+20700', 'offset_dst' => '+20700', 'dst_region' => '0'),
                    208 => array('timezone' => t('Asia/Krasnoyarsk'), 'offset' => '+25200', 'offset_dst' => '+28800', 'dst_region' => '3'),
                    209 => array('timezone' => t('Asia/Kuala_Lumpur'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    210 => array('timezone' => t('Asia/Kuching'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    211 => array('timezone' => t('Asia/Kuwait'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    212 => array('timezone' => t('Asia/Macao'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    213 => array('timezone' => t('Asia/Magadan'), 'offset' => '+39600', 'offset_dst' => '+43200', 'dst_region' => '3'),
                    214 => array('timezone' => t('Asia/Manila'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    215 => array('timezone' => t('Asia/Muscat'), 'offset' => '+14400', 'offset_dst' => '+14400', 'dst_region' => '0'),
                    216 => array('timezone' => t('Asia/Nicosia'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '3'),
                    217 => array('timezone' => t('Asia/Novosibirsk'), 'offset' => '+21600', 'offset_dst' => '+25200', 'dst_region' => '3'),
                    218 => array('timezone' => t('Asia/Omsk'), 'offset' => '+21600', 'offset_dst' => '+25200', 'dst_region' => '3'),
                    219 => array('timezone' => t('Asia/Phnom_Penh'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    220 => array('timezone' => t('Asia/Pyongyang'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    221 => array('timezone' => t('Asia/Qatar'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    222 => array('timezone' => t('Asia/Rangoon'), 'offset' => '+23400', 'offset_dst' => '+23400', 'dst_region' => '0'),
                    223 => array('timezone' => t('Asia/Riyadh'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    224 => array('timezone' => t('Asia/Riyadh87'), 'offset' => '+15000', 'offset_dst' => '+15000', 'dst_region' => '0'),
                    225 => array('timezone' => t('Asia/Riyadh88'), 'offset' => '+15000', 'offset_dst' => '+15000', 'dst_region' => '0'),
                    226 => array('timezone' => t('Asia/Riyadh89'), 'offset' => '+15000', 'offset_dst' => '+15000', 'dst_region' => '0'),
                    227 => array('timezone' => t('Asia/Saigon'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    228 => array('timezone' => t('Asia/Samarkand'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    229 => array('timezone' => t('Asia/Seoul'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    230 => array('timezone' => t('Asia/Shanghai'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    231 => array('timezone' => t('Asia/Singapore'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    232 => array('timezone' => t('Asia/Taipei'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    233 => array('timezone' => t('Asia/Tashkent'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    234 => array('timezone' => t('Asia/Tbilisi'), 'offset' => '+14400', 'offset_dst' => '+18000', 'dst_region' => '3'),
                    235 => array('timezone' => t('Asia/Tehran'), 'offset' => '+12600', 'offset_dst' => '+16200', 'dst_region' => '8'),
                    236 => array('timezone' => t('Asia/Tel_Aviv'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '5'),
                    237 => array('timezone' => t('Asia/Thimbu'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    238 => array('timezone' => t('Asia/Thimphu'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    239 => array('timezone' => t('Asia/Tokyo'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    240 => array('timezone' => t('Asia/Ujung_Pandang'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    241 => array('timezone' => t('Asia/Ulaanbaatar'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    242 => array('timezone' => t('Asia/Ulan_Bator'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    243 => array('timezone' => t('Asia/Urumqi'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    244 => array('timezone' => t('Asia/Vientiane'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    245 => array('timezone' => t('Asia/Vladivostok'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '3'),
                    246 => array('timezone' => t('Asia/Yakutsk'), 'offset' => '+32400', 'offset_dst' => '+36000', 'dst_region' => '3'),
                    247 => array('timezone' => t('Asia/Yekaterinburg'), 'offset' => '+18000', 'offset_dst' => '+21600', 'dst_region' => '3'),
                    248 => array('timezone' => t('Asia/Yerevan'), 'offset' => '+14400', 'offset_dst' => '+18000', 'dst_region' => '3'),
                    249 => array('timezone' => t('Atlantic/Azores'), 'offset' => '-3600', 'offset_dst' => '+0', 'dst_region' => '13'),
                    250 => array('timezone' => t('Atlantic/Bermuda'), 'offset' => '-14400', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    251 => array('timezone' => t('Atlantic/Canary'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '15'),
                    252 => array('timezone' => t('Atlantic/Cape_Verde'), 'offset' => '-3600', 'offset_dst' => '-3600', 'dst_region' => '0'),
                    253 => array('timezone' => t('Atlantic/Faeroe'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    254 => array('timezone' => t('Atlantic/Jan_Mayen'), 'offset' => '-3600', 'offset_dst' => '-3600', 'dst_region' => '0'),
                    255 => array('timezone' => t('Atlantic/Madeira'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    256 => array('timezone' => t('Atlantic/South_Georgia'), 'offset' => '-7200', 'offset_dst' => '-7200', 'dst_region' => '0'),
                    257 => array('timezone' => t('Atlantic/Stanley'), 'offset' => '-10800', 'offset_dst' => '-14400', 'dst_region' => '19'),
                    258 => array('timezone' => t('Australia/ACT'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '9'),
                    259 => array('timezone' => t('Australia/Adelaide'), 'offset' => '+37800', 'offset_dst' => '+34200', 'dst_region' => '9'),
                    260 => array('timezone' => t('Australia/Brisbane'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    261 => array('timezone' => t('Australia/Broken_Hill'), 'offset' => '+37800', 'offset_dst' => '+34200', 'dst_region' => '9'),
                    262 => array('timezone' => t('Australia/Canberra'), 'offset' => '+39600', 'offset_dst' => '+36000', 'dst_region' => '9'),
                    263 => array('timezone' => t('Australia/Darwin'), 'offset' => '+34200', 'offset_dst' => '+34200', 'dst_region' => '0'),
                    264 => array('timezone' => t('Australia/Hobart'), 'offset' => '+39600', 'offset_dst' => '+36000', 'dst_region' => '10'),
                    265 => array('timezone' => t('Australia/LHI'), 'offset' => '+39600', 'offset_dst' => '+37800', 'dst_region' => '9'),
                    266 => array('timezone' => t('Australia/Lindeman'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    267 => array('timezone' => t('Australia/Lord_Howe'), 'offset' => '+39600', 'offset_dst' => '+37800', 'dst_region' => '9'),
                    268 => array('timezone' => t('Australia/Melbourne'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '10'),
                    269 => array('timezone' => t('Australia/NSW'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '9'),
                    270 => array('timezone' => t('Australia/North'), 'offset' => '+34200', 'offset_dst' => '+34200', 'dst_region' => '0'),
                    271 => array('timezone' => t('Australia/Perth'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    272 => array('timezone' => t('Australia/Queensland'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    273 => array('timezone' => t('Australia/South'), 'offset' => '+37800', 'offset_dst' => '+34200', 'dst_region' => '9'),
                    274 => array('timezone' => t('Australia/Sydney'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '10'),
                    275 => array('timezone' => t('Australia/Tasmania'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '9'),
                    276 => array('timezone' => t('Australia/Victoria'), 'offset' => '+36000', 'offset_dst' => '+39600', 'dst_region' => '9'),
                    277 => array('timezone' => t('Australia/West'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    278 => array('timezone' => t('Australia/Yancowinna'), 'offset' => '+37800', 'offset_dst' => '+34200', 'dst_region' => '10'),
                    279 => array('timezone' => t('Brazil/Acre'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    280 => array('timezone' => t('Brazil/DeNoronha'), 'offset' => '-7200', 'offset_dst' => '-7200', 'dst_region' => '0'),
                    281 => array('timezone' => t('Brazil/East'), 'offset' => '-7200', 'offset_dst' => '-10800', 'dst_region' => '17'),
                    282 => array('timezone' => t('Brazil/West'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    285 => array('timezone' => t('Canada/Atlantic'), 'offset' => '-14400', 'offset_dst' => '-10800', 'dst_region' => '15'),
                    286 => array('timezone' => t('Canada/Central'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    287 => array('timezone' => t('Canada/East-Saskatchewan'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    288 => array('timezone' => t('Canada/Eastern'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    289 => array('timezone' => t('Canada/Mountain'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    290 => array('timezone' => t('Canada/Newfoundland'), 'offset' => '-12600', 'offset_dst' => '-9000', 'dst_region' => '15'),
                    291 => array('timezone' => t('Canada/Pacific'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    292 => array('timezone' => t('Canada/Saskatchewan'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    293 => array('timezone' => t('Canada/Yukon'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    294 => array('timezone' => t('Chile/Continental'), 'offset' => '-10800', 'offset_dst' => '-14400', 'dst_region' => '18'),
                    295 => array('timezone' => t('Chile/EasterIsland'), 'offset' => '-18000', 'offset_dst' => '-21600', 'dst_region' => '18'),
                    296 => array('timezone' => t('Cuba'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '16'),
                    298 => array('timezone' => t('EST'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    300 => array('timezone' => t('Egypt'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '1'),
                    301 => array('timezone' => t('Eire'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    302 => array('timezone' => t('Etc/GMT-1'), 'offset' => '-3600', 'offset_dst' => '-3600', 'dst_region' => '0'),
                    303 => array('timezone' => t('Etc/GMT-10'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    304 => array('timezone' => t('Etc/GMT-11'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    305 => array('timezone' => t('Etc/GMT-12'), 'offset' => '-43200', 'offset_dst' => '-43200', 'dst_region' => '0'),
                    306 => array('timezone' => t('Etc/GMT-2'), 'offset' => '-7200', 'offset_dst' => '-7200', 'dst_region' => '0'),
                    307 => array('timezone' => t('Etc/GMT-3'), 'offset' => '-10800', 'offset_dst' => '-10800', 'dst_region' => '0'),
                    308 => array('timezone' => t('Etc/GMT-4'), 'offset' => '-14400', 'offset_dst' => '-14400', 'dst_region' => '0'),
                    309 => array('timezone' => t('Etc/GMT-5'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    310 => array('timezone' => t('Etc/GMT-6'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    311 => array('timezone' => t('Etc/GMT-7'), 'offset' => '-25200', 'offset_dst' => '-25200', 'dst_region' => '0'),
                    312 => array('timezone' => t('Etc/GMT-8'), 'offset' => '-28800', 'offset_dst' => '-28800', 'dst_region' => '0'),
                    313 => array('timezone' => t('Etc/GMT-9'), 'offset' => '-32400', 'offset_dst' => '-32400', 'dst_region' => '0'),
                    487 => array('timezone' => t('Etc/GMT'), 'offset' => '+0', 'offset_dst' => '+0', 'dst_region' => '0'),
                    314 => array('timezone' => t('Etc/GMT+1'), 'offset' => '+3600', 'offset_dst' => '+3600', 'dst_region' => '0'),
                    315 => array('timezone' => t('Etc/GMT+10'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    316 => array('timezone' => t('Etc/GMT+11'), 'offset' => '+39600', 'offset_dst' => '+39600', 'dst_region' => '0'),
                    317 => array('timezone' => t('Etc/GMT+12'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    318 => array('timezone' => t('Etc/GMT+13'), 'offset' => '+46800', 'offset_dst' => '+46800', 'dst_region' => '0'),
                    319 => array('timezone' => t('Etc/GMT+14'), 'offset' => '+50400', 'offset_dst' => '+50400', 'dst_region' => '0'),
                    320 => array('timezone' => t('Etc/GMT+2'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    321 => array('timezone' => t('Etc/GMT+3'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    322 => array('timezone' => t('Etc/GMT+4'), 'offset' => '+14400', 'offset_dst' => '+14400', 'dst_region' => '0'),
                    323 => array('timezone' => t('Etc/GMT+5'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    324 => array('timezone' => t('Etc/GMT+6'), 'offset' => '+21600', 'offset_dst' => '+21600', 'dst_region' => '0'),
                    325 => array('timezone' => t('Etc/GMT+7'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    326 => array('timezone' => t('Etc/GMT+8'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    327 => array('timezone' => t('Etc/GMT+9'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    328 => array('timezone' => t('Europe/Amsterdam'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    329 => array('timezone' => t('Europe/Andorra'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    330 => array('timezone' => t('Europe/Athens'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    331 => array('timezone' => t('Europe/Belfast'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    332 => array('timezone' => t('Europe/Belgrade'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    333 => array('timezone' => t('Europe/Berlin'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    334 => array('timezone' => t('Europe/Bratislava'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    335 => array('timezone' => t('Europe/Brussels'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    336 => array('timezone' => t('Europe/Bucharest'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    337 => array('timezone' => t('Europe/Budapest'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    338 => array('timezone' => t('Europe/Chisinau'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    339 => array('timezone' => t('Europe/Copenhagen'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    340 => array('timezone' => t('Europe/Dublin'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    341 => array('timezone' => t('Europe/Gibraltar'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    342 => array('timezone' => t('Europe/Helsinki'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    343 => array('timezone' => t('Europe/Istanbul'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    344 => array('timezone' => t('Europe/Kaliningrad'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    345 => array('timezone' => t('Europe/Kiev'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    346 => array('timezone' => t('Europe/Lisbon'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    347 => array('timezone' => t('Europe/Ljubljana'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    348 => array('timezone' => t('Europe/London'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    349 => array('timezone' => t('Europe/Luxembourg'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    350 => array('timezone' => t('Europe/Madrid'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    351 => array('timezone' => t('Europe/Malta'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    352 => array('timezone' => t('Europe/Minsk'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    353 => array('timezone' => t('Europe/Monaco'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    354 => array('timezone' => t('Europe/Moscow'), 'offset' => '+10800', 'offset_dst' => '+14400', 'dst_region' => '14'),
                    355 => array('timezone' => t('Europe/Nicosia'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    356 => array('timezone' => t('Europe/Oslo'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    357 => array('timezone' => t('Europe/Paris'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    358 => array('timezone' => t('Europe/Prague'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    359 => array('timezone' => t('Europe/Riga'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    360 => array('timezone' => t('Europe/Rome'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    361 => array('timezone' => t('Europe/Samara'), 'offset' => '+14400', 'offset_dst' => '+18000', 'dst_region' => '13'),
                    362 => array('timezone' => t('Europe/San_Marino'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    363 => array('timezone' => t('Europe/Sarajevo'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    364 => array('timezone' => t('Europe/Simferopol'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    365 => array('timezone' => t('Europe/Skopje'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    366 => array('timezone' => t('Europe/Sofia'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    367 => array('timezone' => t('Europe/Stockholm'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    368 => array('timezone' => t('Europe/Tallinn'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    369 => array('timezone' => t('Europe/Tirane'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    370 => array('timezone' => t('Europe/Tiraspol'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    371 => array('timezone' => t('Europe/Uzhgorod'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    372 => array('timezone' => t('Europe/Vaduz'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    373 => array('timezone' => t('Europe/Vatican'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    374 => array('timezone' => t('Europe/Vienna'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    375 => array('timezone' => t('Europe/Vilnius'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    376 => array('timezone' => t('Europe/Warsaw'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    377 => array('timezone' => t('Europe/Zagreb'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    378 => array('timezone' => t('Europe/Zaporozhye'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    379 => array('timezone' => t('Europe/Zurich'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    380 => array('timezone' => t('GB'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    381 => array('timezone' => t('GB-Eire'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    383 => array('timezone' => t('Hongkong'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    384 => array('timezone' => t('Indian/Antananarivo'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    385 => array('timezone' => t('Indian/Chagos'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    386 => array('timezone' => t('Indian/Christmas'), 'offset' => '+25200', 'offset_dst' => '+25200', 'dst_region' => '0'),
                    387 => array('timezone' => t('Indian/Cocos'), 'offset' => '+23400', 'offset_dst' => '+23400', 'dst_region' => '0'),
                    388 => array('timezone' => t('Indian/Comoro'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    389 => array('timezone' => t('Indian/Kerguelen'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    390 => array('timezone' => t('Indian/Mahe'), 'offset' => '+14400', 'offset_dst' => '+14400', 'dst_region' => '0'),
                    391 => array('timezone' => t('Indian/Maldives'), 'offset' => '+18000', 'offset_dst' => '+18000', 'dst_region' => '0'),
                    392 => array('timezone' => t('Indian/Mauritius'), 'offset' => '+14400', 'offset_dst' => '+14400', 'dst_region' => '0'),
                    393 => array('timezone' => t('Indian/Mayotte'), 'offset' => '+10800', 'offset_dst' => '+10800', 'dst_region' => '0'),
                    394 => array('timezone' => t('Indian/Reunion'), 'offset' => '+14400', 'offset_dst' => '+14400', 'dst_region' => '0'),
                    395 => array('timezone' => t('Iran'), 'offset' => '+12600', 'offset_dst' => '+16200', 'dst_region' => '8'),
                    396 => array('timezone' => t('Israel'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '5'),
                    397 => array('timezone' => t('Jamaica'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    398 => array('timezone' => t('Japan'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    399 => array('timezone' => t('Kwajalein'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    400 => array('timezone' => t('Libya'), 'offset' => '+7200', 'offset_dst' => '+7200', 'dst_region' => '0'),
                    404 => array('timezone' => t('Mexico/BajaNorte'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    405 => array('timezone' => t('Mexico/BajaSur'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    406 => array('timezone' => t('Mexico/General'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    407 => array('timezone' => t('Mideast/Riyadh87'), 'offset' => '+15000', 'offset_dst' => '+15000', 'dst_region' => '0'),
                    408 => array('timezone' => t('Mideast/Riyadh88'), 'offset' => '+15000', 'offset_dst' => '+15000', 'dst_region' => '0'),
                    409 => array('timezone' => t('Mideast/Riyadh89'), 'offset' => '+15000', 'offset_dst' => '+15000', 'dst_region' => '0'),
                    410 => array('timezone' => t('NZ'), 'offset' => '+46800', 'offset_dst' => '+43200', 'dst_region' => '11'),
                    412 => array('timezone' => t('Navajo'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    415 => array('timezone' => t('Pacific/Apia'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    416 => array('timezone' => t('Pacific/Auckland'), 'offset' => '+46800', 'offset_dst' => '+43200', 'dst_region' => '15'),
                    417 => array('timezone' => t('Pacific/Chatham'), 'offset' => '+49500', 'offset_dst' => '+45900', 'dst_region' => '15'),
                    418 => array('timezone' => t('Pacific/Easter'), 'offset' => '-18000', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    419 => array('timezone' => t('Pacific/Efate'), 'offset' => '+39600', 'offset_dst' => '+39600', 'dst_region' => '0'),
                    420 => array('timezone' => t('Pacific/Enderbury'), 'offset' => '+46800', 'offset_dst' => '+46800', 'dst_region' => '0'),
                    421 => array('timezone' => t('Pacific/Fakaofo'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    422 => array('timezone' => t('Pacific/Fiji'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    423 => array('timezone' => t('Pacific/Funafuti'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    424 => array('timezone' => t('Pacific/Galapagos'), 'offset' => '-21600', 'offset_dst' => '-21600', 'dst_region' => '0'),
                    425 => array('timezone' => t('Pacific/Gambier'), 'offset' => '-32400', 'offset_dst' => '-32400', 'dst_region' => '0'),
                    426 => array('timezone' => t('Pacific/Guadalcanal'), 'offset' => '+39600', 'offset_dst' => '+39600', 'dst_region' => '0'),
                    427 => array('timezone' => t('Pacific/Guam'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    428 => array('timezone' => t('Pacific/Honolulu'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    429 => array('timezone' => t('Pacific/Johnston'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    430 => array('timezone' => t('Pacific/Kiritimati'), 'offset' => '+50400', 'offset_dst' => '+50400', 'dst_region' => '0'),
                    431 => array('timezone' => t('Pacific/Kosrae'), 'offset' => '+39600', 'offset_dst' => '+39600', 'dst_region' => '0'),
                    432 => array('timezone' => t('Pacific/Kwajalein'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    433 => array('timezone' => t('Pacific/Majuro'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    434 => array('timezone' => t('Pacific/Marquesas'), 'offset' => '-34200', 'offset_dst' => '-34200', 'dst_region' => '0'),
                    435 => array('timezone' => t('Pacific/Midway'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    436 => array('timezone' => t('Pacific/Nauru'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    437 => array('timezone' => t('Pacific/Niue'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    438 => array('timezone' => t('Pacific/Norfolk'), 'offset' => '+41400', 'offset_dst' => '+41400', 'dst_region' => '0'),
                    439 => array('timezone' => t('Pacific/Noumea'), 'offset' => '+39600', 'offset_dst' => '+39600', 'dst_region' => '0'),
                    440 => array('timezone' => t('Pacific/Pago_Pago'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    441 => array('timezone' => t('Pacific/Palau'), 'offset' => '+32400', 'offset_dst' => '+32400', 'dst_region' => '0'),
                    442 => array('timezone' => t('Pacific/Pitcairn'), 'offset' => '-28800', 'offset_dst' => '-28800', 'dst_region' => '0'),
                    443 => array('timezone' => t('Pacific/Ponape'), 'offset' => '+39600', 'offset_dst' => '+39600', 'dst_region' => '0'),
                    444 => array('timezone' => t('Pacific/Port_Moresby'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    445 => array('timezone' => t('Pacific/Rarotonga'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    446 => array('timezone' => t('Pacific/Saipan'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    447 => array('timezone' => t('Pacific/Samoa'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    448 => array('timezone' => t('Pacific/Tahiti'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    449 => array('timezone' => t('Pacific/Tarawa'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    450 => array('timezone' => t('Pacific/Tongatapu'), 'offset' => '+46800', 'offset_dst' => '+46800', 'dst_region' => '0'),
                    451 => array('timezone' => t('Pacific/Truk'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    452 => array('timezone' => t('Pacific/Wake'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    453 => array('timezone' => t('Pacific/Wallis'), 'offset' => '+43200', 'offset_dst' => '+43200', 'dst_region' => '0'),
                    454 => array('timezone' => t('Pacific/Yap'), 'offset' => '+36000', 'offset_dst' => '+36000', 'dst_region' => '0'),
                    455 => array('timezone' => t('Poland'), 'offset' => '+3600', 'offset_dst' => '+7200', 'dst_region' => '13'),
                    456 => array('timezone' => t('Portugal'), 'offset' => '+0', 'offset_dst' => '+3600', 'dst_region' => '13'),
                    459 => array('timezone' => t('Singapore'), 'offset' => '+28800', 'offset_dst' => '+28800', 'dst_region' => '0'),
                    473 => array('timezone' => t('Turkey'), 'offset' => '+7200', 'offset_dst' => '+10800', 'dst_region' => '13'),
                    474 => array('timezone' => t('US/Alaska'), 'offset' => '-32400', 'offset_dst' => '-28800', 'dst_region' => '15'),
                    475 => array('timezone' => t('US/Aleutian'), 'offset' => '-36000', 'offset_dst' => '-32400', 'dst_region' => '15'),
                    476 => array('timezone' => t('US/Arizona'), 'offset' => '-25200', 'offset_dst' => '-25200', 'dst_region' => '0'),
                    477 => array('timezone' => t('US/Central'), 'offset' => '-21600', 'offset_dst' => '-18000', 'dst_region' => '15'),
                    478 => array('timezone' => t('US/East-Indiana'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    479 => array('timezone' => t('US/Eastern'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    480 => array('timezone' => t('US/Hawaii'), 'offset' => '-36000', 'offset_dst' => '-36000', 'dst_region' => '0'),
                    481 => array('timezone' => t('US/Indiana-Starke'), 'offset' => '-18000', 'offset_dst' => '-18000', 'dst_region' => '0'),
                    482 => array('timezone' => t('US/Michigan'), 'offset' => '-18000', 'offset_dst' => '-14400', 'dst_region' => '15'),
                    483 => array('timezone' => t('US/Mountain'), 'offset' => '-25200', 'offset_dst' => '-21600', 'dst_region' => '15'),
                    484 => array('timezone' => t('US/Pacific'), 'offset' => '-28800', 'offset_dst' => '-25200', 'dst_region' => '15'),
                    485 => array('timezone' => t('US/Samoa'), 'offset' => '-39600', 'offset_dst' => '-39600', 'dst_region' => '0'),
                    486 => array('timezone' => t('Pacific/French Polynesia-Marquesas Islands'), 'offset' => '-34200', 'offset_dst' => '-34200', 'dst_region' => '0')
                  );
  }
  return $zones;
}
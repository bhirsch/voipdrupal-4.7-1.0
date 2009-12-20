<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 1.1                                                |
+--------------------------------------------------------------------+
| Copyright (c) 2005 Social Source Foundation                        |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the Affero General Public License Version 1,    |
| March 2002.                                                        |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the Affero General Public License for more details.            |
|                                                                    |
| You should have received a copy of the Affero General Public       |
| License along with this program; if not, contact the Social Source |
| Foundation at info[AT]socialsourcefoundation[DOT]org.  If you have |
| questions about the Affero General Public License or the licensing |
| of CiviCRM, see the Social Source Foundation CiviCRM license FAQ   |
| at http://www.openngo.org/faqs/licensing.html                       |
+--------------------------------------------------------------------+
*/
/**
*
* @package CRM
* @author Donald A. Lobo <lobo@yahoo.com>
* @copyright Donald A. Lobo 01/15/2005
* $Id$
*
*/
$GLOBALS['_CRM_CORE_DAO_ADDRESS']['_tableName'] =  'civicrm_address';
$GLOBALS['_CRM_CORE_DAO_ADDRESS']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_ADDRESS']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
require_once 'CRM/Core/DAO/StateProvince.php';
require_once 'CRM/Core/DAO/Country.php';
class CRM_Core_DAO_Address extends CRM_Core_DAO {
    /**
    * static instance to hold the table name
    *
    * @var string
    * @static
    */
    
    /**
    * static instance to hold the field values
    *
    * @var array
    * @static
    */
    
    /**
    * static instance to hold the FK relationships
    *
    * @var string
    * @static
    */
    
    /**
    * static instance to hold the values that can
    * be imported / apu
    *
    * @var array
    * @static
    */
    
    /**
    * static instance to hold the values that can
    * be exported / apu
    *
    * @var array
    * @static
    */
    
    /**
    * Unique Address ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Location does this address belong to.
    *
    * @var int unsigned
    */
    var $location_id;
    /**
    * Concatenation of all routable street address components (prefix, street number, street name, suffix, unit number OR P.O. Box). Apps should be able to determine physical location with this data (for mapping, mail delivery, etc.).
    *
    * @var string
    */
    var $street_address;
    /**
    * Numeric portion of address number on the street, e.g. For 112A Main St, the street_number = 112.
    *
    * @var int
    */
    var $street_number;
    /**
    * Non-numeric portion of address number on the street, e.g. For 112A Main St, the street_number_suffix = A
    *
    * @var string
    */
    var $street_number_suffix;
    /**
    * Directional prefix, e.g. SE Main St, SE is the prefix.
    *
    * @var string
    */
    var $street_number_predirectional;
    /**
    * Actual street name, excluding St, Dr, Rd, Ave, e.g. For 112 Main St, the street_name = Main.
    *
    * @var string
    */
    var $street_name;
    /**
    * St, Rd, Dr, etc.
    *
    * @var string
    */
    var $street_type;
    /**
    * Directional prefix, e.g. Main St S, S is the suffix.
    *
    * @var string
    */
    var $street_number_postdirectional;
    /**
    * Secondary unit designator, e.g. Apt 3 or Unit # 14, or Bldg 1200
    *
    * @var string
    */
    var $street_unit;
    /**
    * Supplemental Address Information, Line 1
    *
    * @var string
    */
    var $supplemental_address_1;
    /**
    * Supplemental Address Information, Line 2
    *
    * @var string
    */
    var $supplemental_address_2;
    /**
    * Supplemental Address Information, Line 3
    *
    * @var string
    */
    var $supplemental_address_3;
    /**
    * City, Town or Village Name.
    *
    * @var string
    */
    var $city;
    /**
    * Which County does this address belong to.
    *
    * @var int unsigned
    */
    var $county_id;
    /**
    * Which State_Province does this address belong to.
    *
    * @var int unsigned
    */
    var $state_province_id;
    /**
    * Store both US (zip5) AND international postal codes. App is responsible for country/region appropriate validation.
    *
    * @var string
    */
    var $postal_code;
    /**
    * Store the suffix, like the +4 part in the USPS system.
    *
    * @var string
    */
    var $postal_code_suffix;
    /**
    * USPS Bulk mailing code.
    *
    * @var string
    */
    var $usps_adc;
    /**
    * Which Country does this address belong to.
    *
    * @var int unsigned
    */
    var $country_id;
    /**
    * Which Geo_Coord does this address belong to.
    *
    * @var int unsigned
    */
    var $geo_coord_id;
    /**
    * Latitude or UTM (Universal Transverse Mercator Grid) Northing.
    *
    * @var float
    */
    var $geo_code_1;
    /**
    * Longitude or UTM (Universal Transverse Mercator Grid) Easting.
    *
    * @var float
    */
    var $geo_code_2;
    /**
    * Timezone expressed as a UTC offset - e.g. United States CST would be written as "UTC-6".
    *
    * @var string
    */
    var $timezone;
    /**
    * Optional misc info (e.g. delivery instructions) for this address.
    *
    * @var string
    */
    var $note;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_address
    */
    function CRM_Core_DAO_Address() 
    {
        parent::CRM_Core_DAO();
    }
    /**
    * return foreign links
    *
    * @access public
    * @return array
    */
    function &links() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_links'] = array(
                'location_id'=>'civicrm_location:id',
                'county_id'=>'civicrm_county:id',
                'state_province_id'=>'civicrm_state_province:id',
                'country_id'=>'civicrm_country:id',
                'geo_coord_id'=>'civicrm_geo_coord:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'location_id'=>array(
                    'name'=>'location_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'street_address'=>array(
                    'name'=>'street_address',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Address') ,
                    'maxlength'=>96,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_address.street_address',
                    'headerPattern'=>'/(street|address)/i',
                    'dataPattern'=>'/^(\d{1,5}( [0-9A-Za-z]+)+)$|^(P\.?O\.\? Box \d{1,5})$/i',
                    'export'=>true,
                ) ,
                'street_number'=>array(
                    'name'=>'street_number',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Street Number') ,
                ) ,
                'street_number_suffix'=>array(
                    'name'=>'street_number_suffix',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Number Suffix') ,
                    'maxlength'=>8,
                    'size'=>CRM_UTILS_TYPE_EIGHT,
                ) ,
                'street_number_predirectional'=>array(
                    'name'=>'street_number_predirectional',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Number Predirectional') ,
                    'maxlength'=>8,
                    'size'=>CRM_UTILS_TYPE_EIGHT,
                ) ,
                'street_name'=>array(
                    'name'=>'street_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'street_type'=>array(
                    'name'=>'street_type',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Type') ,
                    'maxlength'=>8,
                    'size'=>CRM_UTILS_TYPE_EIGHT,
                ) ,
                'street_number_postdirectional'=>array(
                    'name'=>'street_number_postdirectional',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Number Postdirectional') ,
                    'maxlength'=>8,
                    'size'=>CRM_UTILS_TYPE_EIGHT,
                ) ,
                'street_unit'=>array(
                    'name'=>'street_unit',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Street Unit') ,
                    'maxlength'=>16,
                    'size'=>CRM_UTILS_TYPE_TWELVE,
                ) ,
                'supplemental_address_1'=>array(
                    'name'=>'supplemental_address_1',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Supplemental Address 1') ,
                    'maxlength'=>96,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_address.supplemental_address_1',
                    'headerPattern'=>'/(supplemental(\s)?)?address(\s\d+)?/i',
                    'dataPattern'=>'/unit|ap(ar)?t(ment)?\s(\d|\w)+/i',
                    'export'=>true,
                ) ,
                'supplemental_address_2'=>array(
                    'name'=>'supplemental_address_2',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Supplemental Address 2') ,
                    'maxlength'=>96,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_address.supplemental_address_2',
                    'headerPattern'=>'/(supplemental(\s)?)?address(\s\d+)?/i',
                    'dataPattern'=>'/unit|ap(ar)?t(ment)?\s(\d|\w)+/i',
                    'export'=>true,
                ) ,
                'supplemental_address_3'=>array(
                    'name'=>'supplemental_address_3',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Supplemental Address 3') ,
                    'maxlength'=>96,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'city'=>array(
                    'name'=>'city',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('City') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_address.city',
                    'headerPattern'=>'/city/i',
                    'dataPattern'=>'/^[A-Za-z]+(\.?)(\s?[A-Za-z]+){0,2}$/',
                    'export'=>true,
                ) ,
                'county_id'=>array(
                    'name'=>'county_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'state_province_id'=>array(
                    'name'=>'state_province_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'postal_code'=>array(
                    'name'=>'postal_code',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Postal Code') ,
                    'maxlength'=>12,
                    'size'=>CRM_UTILS_TYPE_TWELVE,
                    'import'=>true,
                    'where'=>'civicrm_address.postal_code',
                    'headerPattern'=>'/postal|zip/i',
                    'dataPattern'=>'/\d?\d{4}(-\d{4})?/',
                    'export'=>true,
                ) ,
                'postal_code_suffix'=>array(
                    'name'=>'postal_code_suffix',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Postal Code Suffix') ,
                    'maxlength'=>12,
                    'size'=>CRM_UTILS_TYPE_TWELVE,
                    'import'=>true,
                    'where'=>'civicrm_address.postal_code_suffix',
                    'headerPattern'=>'/postal_code/i',
                    'dataPattern'=>'/\d?\d{4}(-\d{4})?/',
                    'export'=>true,
                ) ,
                'usps_adc'=>array(
                    'name'=>'usps_adc',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Usps Adc') ,
                    'maxlength'=>32,
                    'size'=>CRM_UTILS_TYPE_MEDIUM,
                ) ,
                'country_id'=>array(
                    'name'=>'country_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'geo_coord_id'=>array(
                    'name'=>'geo_coord_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'geo_code_1'=>array(
                    'name'=>'geo_code_1',
                    'type'=>CRM_UTILS_TYPE_T_FLOAT,
                    'title'=>ts('Geo Code 1') ,
                    'import'=>true,
                    'where'=>'civicrm_address.geo_code_1',
                    'headerPattern'=>'/geo/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'geo_code_2'=>array(
                    'name'=>'geo_code_2',
                    'type'=>CRM_UTILS_TYPE_T_FLOAT,
                    'title'=>ts('Geo Code 2') ,
                    'import'=>true,
                    'where'=>'civicrm_address.geo_code_2',
                    'headerPattern'=>'/geo/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'timezone'=>array(
                    'name'=>'timezone',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Timezone') ,
                    'maxlength'=>8,
                    'size'=>CRM_UTILS_TYPE_EIGHT,
                ) ,
                'note'=>array(
                    'name'=>'note',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Note') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'] = array();
            $fields = &CRM_Core_DAO_Address::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import']['address'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'][$name] = &$fields[$name];
                    }
                }
            }
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'] = array_merge($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'], CRM_Core_DAO_StateProvince::import(true));
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'] = array_merge($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'], CRM_Core_DAO_Country::import(true));
        }
        return $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'] = array();
            $fields = &CRM_Core_DAO_Address::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export']['address'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'][$name] = &$fields[$name];
                    }
                }
            }
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'] = array_merge($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'], CRM_Core_DAO_StateProvince::export(true));
            $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'] = array_merge($GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'], CRM_Core_DAO_Country::export(true));
        }
        return $GLOBALS['_CRM_CORE_DAO_ADDRESS']['_export'];
    }
}
?>
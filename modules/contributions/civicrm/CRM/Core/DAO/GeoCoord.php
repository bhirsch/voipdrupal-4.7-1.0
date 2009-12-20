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
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_tableName'] =  'civicrm_geo_coord';
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['enums'] =  array(
            'coord_type',
            'coord_units',
        );
$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_GeoCoord extends CRM_Core_DAO {
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
    * Geo Coord ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Projected or unprojected coordinates - projected coordinates (e.g. UTM) may be treated as cartesian by some modules.
    *
    * @var enum('LatLong', 'Projected')
    */
    var $coord_type;
    /**
    * If the coord_type is LATLONG, indicate the unit of angular measure: Degree|Grad|Radian. If the coord_type is Projected, indicate unit of distance measure: Foot|Meter.
    *
    * @var enum('Degree', 'Grad', 'Radian', 'Foot', 'Meter')
    */
    var $coord_units;
    /**
    * Coordinate sys description in Open GIS Consortium WKT (well known text) format - see http://www.opengeospatial.org/docs/01-009.pdf this is provided for the convenience of the user or third party modules.
    *
    * @var text
    */
    var $coord_ogc_wkt_string;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_geo_coord
    */
    function CRM_Core_DAO_GeoCoord() 
    {
        parent::CRM_Core_DAO();
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'coord_type'=>array(
                    'name'=>'coord_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Coord Type') ,
                ) ,
                'coord_units'=>array(
                    'name'=>'coord_units',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Coord Units') ,
                ) ,
                'coord_ogc_wkt_string'=>array(
                    'name'=>'coord_ogc_wkt_string',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Coord Ogc Wkt String') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_import'] = array();
            $fields = &CRM_Core_DAO_GeoCoord::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_import']['geo_coord'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_export'] = array();
            $fields = &CRM_Core_DAO_GeoCoord::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_export']['geo_coord'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_geo_coord table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['enums'];
    }
    /**
    * returns a ts()-translated enum value for display purposes
    *
    * @param string $field  the enum field in question
    * @param string $value  the enum value up for translation
    *
    * @return string  the display value of the enum
    */
     function tsEnum($field, $value) 
    {
        
        if (!$GLOBALS['_CRM_CORE_DAO_GEOCOORD']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['translations'] = array(
                'coord_type'=>array(
                    'LatLong'=>ts('LatLong') ,
                    'Projected'=>ts('Projected') ,
                ) ,
                'coord_units'=>array(
                    'Degree'=>ts('Degree') ,
                    'Grad'=>ts('Grad') ,
                    'Radian'=>ts('Radian') ,
                    'Foot'=>ts('Foot') ,
                    'Meter'=>ts('Meter') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_GEOCOORD']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_geo_coord
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_GeoCoord::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_GeoCoord::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
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
$GLOBALS['_CRM_CORE_DAO_PHONE']['_tableName'] =  'civicrm_phone';
$GLOBALS['_CRM_CORE_DAO_PHONE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONE']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONE']['enums'] =  array(
            'phone_type',
        );
$GLOBALS['_CRM_CORE_DAO_PHONE']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Phone extends CRM_Core_DAO {
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
    * Unique Phone ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Location does this phone belong to.
    *
    * @var int unsigned
    */
    var $location_id;
    /**
    * Complete phone number.
    *
    * @var string
    */
    var $phone;
    /**
    * What type of telecom device is this.
    *
    * @var enum('Phone', 'Mobile', 'Fax', 'Pager')
    */
    var $phone_type;
    /**
    * Is this the primary phone for this contact and location.
    *
    * @var boolean
    */
    var $is_primary;
    /**
    * Which Mobile Provider does this phone belong to.
    *
    * @var int unsigned
    */
    var $mobile_provider_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_phone
    */
    function CRM_Core_DAO_Phone() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_PHONE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONE']['_links'] = array(
                'location_id'=>'civicrm_location:id',
                'mobile_provider_id'=>'civicrm_mobile_provider:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_PHONE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONE']['_fields'] = array(
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
                'phone'=>array(
                    'name'=>'phone',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Phone') ,
                    'maxlength'=>32,
                    'size'=>CRM_UTILS_TYPE_MEDIUM,
                    'import'=>true,
                    'where'=>'civicrm_phone.phone',
                    'headerPattern'=>'/phone/i',
                    'dataPattern'=>'/^[\d\(\)\-\.\s]+$/',
                    'export'=>true,
                ) ,
                'phone_type'=>array(
                    'name'=>'phone_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Phone Type') ,
                ) ,
                'is_primary'=>array(
                    'name'=>'is_primary',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'mobile_provider_id'=>array(
                    'name'=>'mobile_provider_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_PHONE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONE']['_import'] = array();
            $fields = &CRM_Core_DAO_Phone::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_PHONE']['_import']['phone'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_PHONE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_PHONE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONE']['_export'] = array();
            $fields = &CRM_Core_DAO_Phone::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_PHONE']['_export']['phone'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_PHONE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_phone table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_PHONE']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_PHONE']['translations'] = array(
                'phone_type'=>array(
                    'Phone'=>ts('Phone') ,
                    'Mobile'=>ts('Mobile') ,
                    'Fax'=>ts('Fax') ,
                    'Pager'=>ts('Pager') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONE']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_phone
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_Phone::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_Phone::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
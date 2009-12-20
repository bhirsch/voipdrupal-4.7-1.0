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
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['_tableName'] =  'civicrm_validation';
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['enums'] =  array(
            'type',
        );
$GLOBALS['_CRM_CORE_DAO_VALIDATION']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Validation extends CRM_Core_DAO {
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
    * Unique Validation ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this contact
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * List of rule built-in rule types. custom types may be added to ENUM via directory scan.
    *
    * @var enum('Email', 'Money', 'URL', 'Phone', 'Positive Integer', 'Variable Name', 'Range', 'Regular Expression Match', 'Regular Expression No Match')
    */
    var $type;
    /**
    * optional value(s) passed to validation function, e.g. a regular expression, min and max for Range, operator + number for Comparison type, etc.
    *
    * @var string
    */
    var $parameters;
    /**
    * custom validation function name. Class methods should be invoked using php syntax array(CLASS_NAME, FN_NAME)
    *
    * @var string
    */
    var $function_name;
    /**
    * Rule Description.
    *
    * @var string
    */
    var $description;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_validation
    */
    function CRM_Core_DAO_Validation() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_VALIDATION']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_VALIDATION']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'domain_id'=>array(
                    'name'=>'domain_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'type'=>array(
                    'name'=>'type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Type') ,
                ) ,
                'parameters'=>array(
                    'name'=>'parameters',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Parameters') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'function_name'=>array(
                    'name'=>'function_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Function Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_VALIDATION']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_import'] = array();
            $fields = &CRM_Core_DAO_Validation::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_import']['validation'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_VALIDATION']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_export'] = array();
            $fields = &CRM_Core_DAO_Validation::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_export']['validation'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_validation table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_VALIDATION']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_VALIDATION']['translations'] = array(
                'type'=>array(
                    'Email'=>ts('Email') ,
                    'Money'=>ts('Money') ,
                    'URL'=>ts('URL') ,
                    'Phone'=>ts('Phone') ,
                    'Positive Integer'=>ts('Positive Integer') ,
                    'Variable Name'=>ts('Variable Name') ,
                    'Range'=>ts('Range') ,
                    'Regular Expression Match'=>ts('Regular Expression Match') ,
                    'Regular Expression No Match'=>ts('Regular Expression No Match') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_VALIDATION']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_validation
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_Validation::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_Validation::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
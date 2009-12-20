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
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_tableName'] =  'civicrm_mailing_bounce_type';
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_fields'] =  null;
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_links'] =  null;
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_import'] =  null;
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_export'] =  null;
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['enums'] =  array(
            'name',
        );
$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Mailing_DAO_BounceType extends CRM_Core_DAO {
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
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Type of bounce
    *
    * @var enum('AOL', 'Away', 'DNS', 'Host', 'Inactive', 'Invalid', 'Loop', 'Quota', 'Relay', 'Spam', 'Syntax', 'Unknown')
    */
    var $name;
    /**
    * A description of this bounce type
    *
    * @var string
    */
    var $description;
    /**
    * Number of bounces of this type required before the email address is put on bounce hold
    *
    * @var int unsigned
    */
    var $hold_threshold;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mailing_bounce_type
    */
    function CRM_Mailing_DAO_BounceType() 
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
        if (!($GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_fields'])) {
            $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Name') ,
                    'required'=>true,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'hold_threshold'=>array(
                    'name'=>'hold_threshold',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Hold Threshold') ,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_import'])) {
            $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_import'] = array();
            $fields = &CRM_Mailing_DAO_BounceType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_import']['mailing_bounce_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_export'])) {
            $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_export'] = array();
            $fields = &CRM_Mailing_DAO_BounceType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_export']['mailing_bounce_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_mailing_bounce_type table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['enums'];
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
        
        if (!$GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['translations']) {
            $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['translations'] = array(
                'name'=>array(
                    'AOL'=>ts('AOL') ,
                    'Away'=>ts('Away') ,
                    'DNS'=>ts('DNS') ,
                    'Host'=>ts('Host') ,
                    'Inactive'=>ts('Inactive') ,
                    'Invalid'=>ts('Invalid') ,
                    'Loop'=>ts('Loop') ,
                    'Quota'=>ts('Quota') ,
                    'Relay'=>ts('Relay') ,
                    'Spam'=>ts('Spam') ,
                    'Syntax'=>ts('Syntax') ,
                    'Unknown'=>ts('Unknown') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_BOUNCETYPE']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_mailing_bounce_type
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Mailing_DAO_BounceType::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Mailing_DAO_BounceType::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
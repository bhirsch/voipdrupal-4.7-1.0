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
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_tableName'] =  'civicrm_mailing_component';
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_fields'] =  null;
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_links'] =  null;
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_import'] =  null;
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_export'] =  null;
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['enums'] =  array(
            'component_type',
        );
$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Mailing_DAO_Component extends CRM_Core_DAO {
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
    * Which Domain owns this component
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * The name of this component
    *
    * @var string
    */
    var $name;
    /**
    * Type of Component.
    *
    * @var enum('Header', 'Footer', 'Subscribe', 'Welcome', 'Unsubscribe', 'OptOut', 'Reply')
    */
    var $component_type;
    /**
    *
    * @var string
    */
    var $subject;
    /**
    * Body of the component in html format.
    *
    * @var text
    */
    var $body_html;
    /**
    * Body of the component in text format.
    *
    * @var text
    */
    var $body_text;
    /**
    * Is this the default component for this component_type?
    *
    * @var boolean
    */
    var $is_default;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mailing_component
    */
    function CRM_Mailing_DAO_Component() 
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
        if (!($GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_links'])) {
            $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_fields'])) {
            $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_fields'] = array(
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
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Component Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'component_type'=>array(
                    'name'=>'component_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Component Type') ,
                ) ,
                'subject'=>array(
                    'name'=>'subject',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Subject') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'body_html'=>array(
                    'name'=>'body_html',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Body Html') ,
                    'rows'=>8,
                    'cols'=>80,
                ) ,
                'body_text'=>array(
                    'name'=>'body_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Body Text') ,
                    'rows'=>8,
                    'cols'=>80,
                ) ,
                'is_default'=>array(
                    'name'=>'is_default',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_import'])) {
            $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_import'] = array();
            $fields = &CRM_Mailing_DAO_Component::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_import']['mailing_component'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_export'])) {
            $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_export'] = array();
            $fields = &CRM_Mailing_DAO_Component::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_export']['mailing_component'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_mailing_component table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['enums'];
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
        
        if (!$GLOBALS['_CRM_MAILING_DAO_COMPONENT']['translations']) {
            $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['translations'] = array(
                'component_type'=>array(
                    'Header'=>ts('Header') ,
                    'Footer'=>ts('Footer') ,
                    'Subscribe'=>ts('Subscribe') ,
                    'Welcome'=>ts('Welcome') ,
                    'Unsubscribe'=>ts('Unsubscribe') ,
                    'OptOut'=>ts('OptOut') ,
                    'Reply'=>ts('Reply') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_COMPONENT']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_mailing_component
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Mailing_DAO_Component::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Mailing_DAO_Component::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
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
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_tableName'] =  'civicrm_custom_group';
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['enums'] =  array(
            'extends',
            'style',
        );
$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_CustomGroup extends CRM_Core_DAO {
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
    * Unique Custom Group ID
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
    * Variable name/programmatic handle for this group.
    *
    * @var string
    */
    var $name;
    /**
    * Friendly Name.
    *
    * @var string
    */
    var $title;
    /**
    * Type of object this group extends (can add other options later e.g. contact_address, etc.).
    *
    * @var enum('Contact', 'Individual', 'Household', 'Organization', 'Location', 'Address', 'Contribution', 'Activity', 'Phonecall', 'Meeting', 'Group')
    */
    var $extends;
    /**
    * Visual relationship between this form and its parent.
    *
    * @var enum('Tab', 'Inline')
    */
    var $style;
    /**
    * Will this group be in collapsed or expanded mode on initial display ?
    *
    * @var int unsigned
    */
    var $collapse_display;
    /**
    * Description and/or help text to display before fields in form.
    *
    * @var text
    */
    var $help_pre;
    /**
    * Description and/or help text to display after fields in form.
    *
    * @var text
    */
    var $help_post;
    /**
    * Controls display order when multiple extended property groups are setup for the same class.
    *
    * @var int
    */
    var $weight;
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
    * @return civicrm_custom_group
    */
    function CRM_Core_DAO_CustomGroup() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_fields'] = array(
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
                    'title'=>ts('Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'title'=>array(
                    'name'=>'title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Title') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'extends'=>array(
                    'name'=>'extends',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Extends') ,
                ) ,
                'style'=>array(
                    'name'=>'style',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Style') ,
                ) ,
                'collapse_display'=>array(
                    'name'=>'collapse_display',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Collapse Display') ,
                ) ,
                'help_pre'=>array(
                    'name'=>'help_pre',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Pre') ,
                    'rows'=>4,
                    'cols'=>80,
                ) ,
                'help_post'=>array(
                    'name'=>'help_post',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Post') ,
                    'rows'=>4,
                    'cols'=>80,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_import'] = array();
            $fields = &CRM_Core_DAO_CustomGroup::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_import']['custom_group'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_export'] = array();
            $fields = &CRM_Core_DAO_CustomGroup::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_export']['custom_group'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_custom_group table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['translations'] = array(
                'extends'=>array(
                    'Contact'=>ts('Contact') ,
                    'Individual'=>ts('Individual') ,
                    'Household'=>ts('Household') ,
                    'Organization'=>ts('Organization') ,
                    'Location'=>ts('Location') ,
                    'Address'=>ts('Address') ,
                    'Contribution'=>ts('Contribution') ,
                    'Activity'=>ts('Activity') ,
                    'Phonecall'=>ts('Phonecall') ,
                    'Meeting'=>ts('Meeting') ,
                    'Group'=>ts('Group') ,
                ) ,
                'style'=>array(
                    'Tab'=>ts('Tab') ,
                    'Inline'=>ts('Inline') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMGROUP']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_custom_group
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_CustomGroup::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_CustomGroup::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
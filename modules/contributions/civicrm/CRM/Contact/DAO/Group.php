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
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['_tableName'] =  'civicrm_group';
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['_export'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['enums'] =  array(
            'visibility',
        );
$GLOBALS['_CRM_CONTACT_DAO_GROUP']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_Group extends CRM_Core_DAO {
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
    * Group ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this group
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Internal name of Group.
    *
    * @var string
    */
    var $name;
    /**
    * Name of Group.
    *
    * @var string
    */
    var $title;
    /**
    * Optional verbose description of the group.
    *
    * @var string
    */
    var $description;
    /**
    * Module or process which created this group.
    *
    * @var string
    */
    var $source;
    /**
    * FK to saved search table.
    *
    * @var int unsigned
    */
    var $saved_search_id;
    /**
    * Is this entry active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * In what context(s) is this field visible.
    *
    * @var enum('User and User Admin Only', 'Public User Pages', 'Public User Pages and Listings')
    */
    var $visibility;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_group
    */
    function CRM_Contact_DAO_Group() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUP']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'saved_search_id'=>'civicrm_saved_search:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUP']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_fields'] = array(
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
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'source'=>array(
                    'name'=>'source',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Source') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'saved_search_id'=>array(
                    'name'=>'saved_search_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'visibility'=>array(
                    'name'=>'visibility',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Visibility') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUP']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_import'] = array();
            $fields = &CRM_Contact_DAO_Group::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_import']['group'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUP']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_export'] = array();
            $fields = &CRM_Contact_DAO_Group::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_export']['group'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_group table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTACT_DAO_GROUP']['translations']) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUP']['translations'] = array(
                'visibility'=>array(
                    'User and User Admin Only'=>ts('User and User Admin Only') ,
                    'Public User Pages'=>ts('Public User Pages') ,
                    'Public User Pages and Listings'=>ts('Public User Pages and Listings') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUP']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_group
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contact_DAO_Group::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contact_DAO_Group::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
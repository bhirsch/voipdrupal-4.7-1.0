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
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_tableName'] =  'civicrm_group_contact';
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_export'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['enums'] =  array(
            'status',
        );
$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_GroupContact extends CRM_Core_DAO {
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
    * primary key
    *
    * @var int unsigned
    */
    var $id;
    /**
    * FK to civicrm_group
    *
    * @var int unsigned
    */
    var $group_id;
    /**
    * FK to civicrm_contact
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * status of contact relative to membership in group
    *
    * @var enum('Added', 'Removed', 'Pending')
    */
    var $status;
    /**
    * Optional location to associate with this membership
    *
    * @var int unsigned
    */
    var $location_id;
    /**
    * Optional email to associate with this membership
    *
    * @var int unsigned
    */
    var $email_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_group_contact
    */
    function CRM_Contact_DAO_GroupContact() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_links'] = array(
                'group_id'=>'civicrm_group:id',
                'contact_id'=>'civicrm_contact:id',
                'location_id'=>'civicrm_location:id',
                'email_id'=>'civicrm_email:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'group_id'=>array(
                    'name'=>'group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'status'=>array(
                    'name'=>'status',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Status') ,
                ) ,
                'location_id'=>array(
                    'name'=>'location_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'email_id'=>array(
                    'name'=>'email_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_import'] = array();
            $fields = &CRM_Contact_DAO_GroupContact::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_import']['group_contact'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_export'] = array();
            $fields = &CRM_Contact_DAO_GroupContact::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_export']['group_contact'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_group_contact table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['translations']) {
            $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['translations'] = array(
                'status'=>array(
                    'Added'=>ts('Added') ,
                    'Removed'=>ts('Removed') ,
                    'Pending'=>ts('Pending') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_GROUPCONTACT']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_group_contact
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contact_DAO_GroupContact::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contact_DAO_GroupContact::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
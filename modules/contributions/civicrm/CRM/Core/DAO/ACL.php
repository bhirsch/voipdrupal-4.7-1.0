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
$GLOBALS['_CRM_CORE_DAO_ACL']['_tableName'] =  'civicrm_acl';
$GLOBALS['_CRM_CORE_DAO_ACL']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACL']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACL']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACL']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACL']['enums'] =  array(
            'operation',
        );
$GLOBALS['_CRM_CORE_DAO_ACL']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_ACL extends CRM_Core_DAO {
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
    * Unique table ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Is this ACL entry Allow  (0) or Deny (1) ?
    *
    * @var boolean
    */
    var $deny;
    /**
    * Table of the object possessing this ACL entry (Contact, Group, or ACL Group)
    *
    * @var string
    */
    var $entity_table;
    /**
    * ID of the object possessing this ACL
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * What operation does this ACL entry control?
    *
    * @var enum('View', 'Edit', 'Create', 'Delete', 'Grant', 'Revoke')
    */
    var $operation;
    /**
    * The table of the object controlled by this ACL entry
    *
    * @var string
    */
    var $object_table;
    /**
    * The ID of the object controlled by this ACL entry
    *
    * @var int unsigned
    */
    var $object_id;
    /**
    * If this is a grant/revoke entry, what table are we granting?
    *
    * @var string
    */
    var $acl_table;
    /**
    * ID of the ACL or ACL group being granted/revoked
    *
    * @var int unsigned
    */
    var $acl_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_acl
    */
    function CRM_Core_DAO_ACL() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_ACL']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_ACL']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'deny'=>array(
                    'name'=>'deny',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Deny') ,
                    'required'=>true,
                ) ,
                'entity_table'=>array(
                    'name'=>'entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_id'=>array(
                    'name'=>'entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'operation'=>array(
                    'name'=>'operation',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Operation') ,
                    'required'=>true,
                ) ,
                'object_table'=>array(
                    'name'=>'object_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Object Table') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'object_id'=>array(
                    'name'=>'object_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'acl_table'=>array(
                    'name'=>'acl_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Acl Table') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'acl_id'=>array(
                    'name'=>'acl_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ACL']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_ACL']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACL']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_ACL']['_import'] = array();
            $fields = &CRM_Core_DAO_ACL::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ACL']['_import']['acl'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ACL']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ACL']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACL']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_ACL']['_export'] = array();
            $fields = &CRM_Core_DAO_ACL::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ACL']['_export']['acl'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ACL']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ACL']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_acl table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_ACL']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_ACL']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_ACL']['translations'] = array(
                'operation'=>array(
                    'View'=>ts('View') ,
                    'Edit'=>ts('Edit') ,
                    'Create'=>ts('Create') ,
                    'Delete'=>ts('Delete') ,
                    'Grant'=>ts('Grant') ,
                    'Revoke'=>ts('Revoke') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ACL']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_acl
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_ACL::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_ACL::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
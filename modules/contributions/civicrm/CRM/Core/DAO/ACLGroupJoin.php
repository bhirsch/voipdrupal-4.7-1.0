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
$GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_tableName'] =  'civicrm_acl_group_join';
$GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_ACLGroupJoin extends CRM_Core_DAO {
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
    * Foreign Key to ACL Group
    *
    * @var int unsigned
    */
    var $acl_group_id;
    /**
    * Table of the object joined to the ACL Group (Contact or Group)
    *
    * @var string
    */
    var $entity_table;
    /**
    * ID of the group/contact object being joined
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_acl_group_join
    */
    function CRM_Core_DAO_ACLGroupJoin() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_links'] = array(
                'acl_group_id'=>'civicrm_acl_group:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'acl_group_id'=>array(
                    'name'=>'acl_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
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
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_import'] = array();
            $fields = &CRM_Core_DAO_ACLGroupJoin::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_import']['acl_group_join'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_export'] = array();
            $fields = &CRM_Core_DAO_ACLGroupJoin::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_export']['acl_group_join'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ACLGROUPJOIN']['_export'];
    }
}
?>
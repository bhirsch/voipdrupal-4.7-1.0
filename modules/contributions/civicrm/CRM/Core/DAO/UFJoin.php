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
$GLOBALS['_CRM_CORE_DAO_UFJOIN']['_tableName'] =  'civicrm_uf_join';
$GLOBALS['_CRM_CORE_DAO_UFJOIN']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFJOIN']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFJOIN']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFJOIN']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_UFJoin extends CRM_Core_DAO {
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
    * Is this join currently active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * Module which owns this uf_join instance, e.g. User Registration, CiviDonate, etc.
    *
    * @var string
    */
    var $module;
    /**
    * Name of table where item being referenced is stored. Modules which only need a single collection of uf_join instances may choose not to populate entity_table and entity_id.
    *
    * @var string
    */
    var $entity_table;
    /**
    * Foreign key to the referenced item.
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * Controls display order when multiple user framework groups are setup for concurrent display.
    *
    * @var int
    */
    var $weight;
    /**
    * Which form does this field belong to.
    *
    * @var int unsigned
    */
    var $uf_group_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_uf_join
    */
    function CRM_Core_DAO_UFJoin() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_UFJOIN']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_links'] = array(
                'uf_group_id'=>'civicrm_uf_group:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFJOIN']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'module'=>array(
                    'name'=>'module',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Module') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_table'=>array(
                    'name'=>'entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Entity Table') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_id'=>array(
                    'name'=>'entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
                'uf_group_id'=>array(
                    'name'=>'uf_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFJOIN']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_import'] = array();
            $fields = &CRM_Core_DAO_UFJoin::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_import']['uf_join'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFJOIN']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_export'] = array();
            $fields = &CRM_Core_DAO_UFJoin::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_export']['uf_join'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFJOIN']['_export'];
    }
}
?>
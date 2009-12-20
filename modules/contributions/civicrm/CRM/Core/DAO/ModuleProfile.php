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
$GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_tableName'] =  'civicrm_module_profile';
$GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_ModuleProfile extends CRM_Core_DAO {
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
    * Unique ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this module profile entry.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Module Name.
    *
    * @var string
    */
    var $module;
    /**
    * physical tablename for entity being extended by this data, e.g. civicrm_contact
    *
    * @var string
    */
    var $entity_table;
    /**
    * FK to record in the entity table specified by entity_table column.
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * Which form does this field belong to.
    *
    * @var int unsigned
    */
    var $uf_group_id;
    /**
    * each internal or external module uses this to order multiple profiles associated with an entity_id
    *
    * @var int
    */
    var $weight;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_module_profile
    */
    function CRM_Core_DAO_ModuleProfile() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'uf_group_id'=>'civicrm_uf_group:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_fields'] = array(
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
                'module'=>array(
                    'name'=>'module',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Module') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
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
                    'required'=>true,
                ) ,
                'uf_group_id'=>array(
                    'name'=>'uf_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_import'] = array();
            $fields = &CRM_Core_DAO_ModuleProfile::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_import']['module_profile'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_export'] = array();
            $fields = &CRM_Core_DAO_ModuleProfile::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_export']['module_profile'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_MODULEPROFILE']['_export'];
    }
}
?>
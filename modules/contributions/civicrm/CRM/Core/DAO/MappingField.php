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
$GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_tableName'] =  'civicrm_mapping_field';
$GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_MappingField extends CRM_Core_DAO {
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
    * Mapping Field ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Mapping to which this field belongs
    *
    * @var int unsigned
    */
    var $mapping_id;
    /**
    * Mapping field key
    *
    * @var string
    */
    var $name;
    /**
    * Contact Type in mapping
    *
    * @var string
    */
    var $contact_type;
    /**
    * Column number for mapping set
    *
    * @var int unsigned
    */
    var $column_number;
    /**
    * Location type of this mapping, if required
    *
    * @var int unsigned
    */
    var $location_type_id;
    /**
    * Phone type, if required
    *
    * @var string
    */
    var $phone_type;
    /**
    * Relationship type, if required
    *
    * @var int unsigned
    */
    var $relationship_type_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mapping_field
    */
    function CRM_Core_DAO_MappingField() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_links'] = array(
                'mapping_id'=>'civicrm_mapping:id',
                'location_type_id'=>'civicrm_location_type:id',
                'relationship_type_id'=>'civicrm_relationship_type:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'mapping_id'=>array(
                    'name'=>'mapping_id',
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
                'contact_type'=>array(
                    'name'=>'contact_type',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Contact Type') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'column_number'=>array(
                    'name'=>'column_number',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Column Number') ,
                    'required'=>true,
                ) ,
                'location_type_id'=>array(
                    'name'=>'location_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'phone_type'=>array(
                    'name'=>'phone_type',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Phone Type') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'relationship_type_id'=>array(
                    'name'=>'relationship_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_import'] = array();
            $fields = &CRM_Core_DAO_MappingField::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_import']['mapping_field'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_export'] = array();
            $fields = &CRM_Core_DAO_MappingField::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_export']['mapping_field'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_MAPPINGFIELD']['_export'];
    }
}
?>
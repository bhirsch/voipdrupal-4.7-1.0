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
$GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_tableName'] =  'civicrm_custom_value';
$GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_CustomValue extends CRM_Core_DAO {
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
    * Foreign key to civicrm_ext_property.
    *
    * @var int unsigned
    */
    var $custom_field_id;
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
    * stores data for ext property data_type = integer. This col supports signed integers.
    *
    * @var int
    */
    var $int_data;
    /**
    * stores data for ext property data_type = float.
    *
    * @var float
    */
    var $float_data;
    /**
    * stores data for ext property data_type = money.
    *
    * @var float
    */
    var $decimal_data;
    /**
    * data for ext property data_type = text.
    *
    * @var string
    */
    var $char_data;
    /**
    * data for ext property data_type = date.
    *
    * @var date
    */
    var $date_data;
    /**
    * data for ext property data_type = memo.
    *
    * @var text
    */
    var $memo_data;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_custom_value
    */
    function CRM_Core_DAO_CustomValue() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_links'] = array(
                'custom_field_id'=>'civicrm_custom_field:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'custom_field_id'=>array(
                    'name'=>'custom_field_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
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
                'int_data'=>array(
                    'name'=>'int_data',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Int Data') ,
                ) ,
                'float_data'=>array(
                    'name'=>'float_data',
                    'type'=>CRM_UTILS_TYPE_T_FLOAT,
                    'title'=>ts('Float Data') ,
                ) ,
                'decimal_data'=>array(
                    'name'=>'decimal_data',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Decimal Data') ,
                ) ,
                'char_data'=>array(
                    'name'=>'char_data',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Char Data') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'date_data'=>array(
                    'name'=>'date_data',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Date Data') ,
                ) ,
                'memo_data'=>array(
                    'name'=>'memo_data',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Memo Data') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_import'] = array();
            $fields = &CRM_Core_DAO_CustomValue::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_import']['custom_value'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_export'] = array();
            $fields = &CRM_Core_DAO_CustomValue::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_export']['custom_value'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMVALUE']['_export'];
    }
}
?>
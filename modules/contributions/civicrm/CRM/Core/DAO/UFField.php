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
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['_tableName'] =  'civicrm_uf_field';
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['enums'] =  array(
            'visibility',
        );
$GLOBALS['_CRM_CORE_DAO_UFFIELD']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_UFField extends CRM_Core_DAO {
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
    * Which form does this field belong to.
    *
    * @var int unsigned
    */
    var $uf_group_id;
    /**
    * Name for CiviCRM field which is being exposed for sharing.
    *
    * @var string
    */
    var $field_name;
    /**
    * Is this field currently shareable? If false, hide the field for all sharing contexts.
    *
    * @var boolean
    */
    var $is_active;
    /**
    * the field is view only and not editable in user forms.
    *
    * @var boolean
    */
    var $is_view;
    /**
    * Is this field required when included in a user or registration form?
    *
    * @var boolean
    */
    var $is_required;
    /**
    * Controls field display order when user framework fields are displayed in registration and account editing forms.
    *
    * @var int
    */
    var $weight;
    /**
    * Description and/or help text to display after this field.
    *
    * @var text
    */
    var $help_post;
    /**
    * In what context(s) is this field visible.
    *
    * @var enum('User and User Admin Only', 'Public User Pages', 'Public User Pages and Listings')
    */
    var $visibility;
    /**
    * Is this field included as a column in the selector table?
    *
    * @var boolean
    */
    var $in_selector;
    /**
    * Is this field included search form of profile?
    *
    * @var boolean
    */
    var $is_searchable;
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
    * To save label for fields.
    *
    * @var string
    */
    var $label;
    /**
    * This field saves field type (ie individual,household.. field etc).
    *
    * @var string
    */
    var $field_type;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_uf_field
    */
    function CRM_Core_DAO_UFField() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_UFFIELD']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_links'] = array(
                'uf_group_id'=>'civicrm_uf_group:id',
                'location_type_id'=>'civicrm_location_type:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFFIELD']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'uf_group_id'=>array(
                    'name'=>'uf_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'field_name'=>array(
                    'name'=>'field_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Field Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_view'=>array(
                    'name'=>'is_view',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_required'=>array(
                    'name'=>'is_required',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
                'help_post'=>array(
                    'name'=>'help_post',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Post') ,
                ) ,
                'visibility'=>array(
                    'name'=>'visibility',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Visibility') ,
                ) ,
                'in_selector'=>array(
                    'name'=>'in_selector',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('In Selector') ,
                ) ,
                'is_searchable'=>array(
                    'name'=>'is_searchable',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
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
                'label'=>array(
                    'name'=>'label',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Label') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'field_type'=>array(
                    'name'=>'field_type',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Field Type') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFFIELD']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_import'] = array();
            $fields = &CRM_Core_DAO_UFField::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_import']['uf_field'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFFIELD']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_export'] = array();
            $fields = &CRM_Core_DAO_UFField::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_export']['uf_field'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_uf_field table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_UFFIELD']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_UFFIELD']['translations'] = array(
                'visibility'=>array(
                    'User and User Admin Only'=>ts('User and User Admin Only') ,
                    'Public User Pages'=>ts('Public User Pages') ,
                    'Public User Pages and Listings'=>ts('Public User Pages and Listings') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFFIELD']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_uf_field
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_UFField::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_UFField::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
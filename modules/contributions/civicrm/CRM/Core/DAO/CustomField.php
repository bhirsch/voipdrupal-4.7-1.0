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
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_tableName'] =  'civicrm_custom_field';
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['enums'] =  array(
            'data_type',
            'html_type',
        );
$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_CustomField extends CRM_Core_DAO {
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
    * Unique Custom Field ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * FK to civicrm_custom_group.
    *
    * @var int unsigned
    */
    var $custom_group_id;
    /**
    * Variable name/programmatic handle for this property.
    *
    * @var string
    */
    var $name;
    /**
    * Text for form field label (also friendly name for administering this custom property).
    *
    * @var string
    */
    var $label;
    /**
    * Controls location of data storage in extended_data table.
    *
    * @var enum('String', 'Int', 'Float', 'Money', 'Memo', 'Date', 'Boolean', 'StateProvince', 'Country')
    */
    var $data_type;
    /**
    * HTML types plus several built-in extended types.
    *
    * @var enum('Text', 'TextArea', 'Select', 'Multi-Select', 'Radio', 'CheckBox', 'Select Date', 'Select State/Province', 'Select Country')
    */
    var $html_type;
    /**
    * Use form_options.is_default for field_types which use options.
    *
    * @var string
    */
    var $default_value;
    /**
    * Is a value required for this property.
    *
    * @var boolean
    */
    var $is_required;
    /**
    * Is this property searchable.
    *
    * @var boolean
    */
    var $is_searchable;
    /**
    * Is this property range searchable.
    *
    * @var boolean
    */
    var $is_search_range;
    /**
    * Controls field display order within an extended property group.
    *
    * @var int
    */
    var $weight;
    /**
    * FK to civicrm_validation. Will be used for custom validation functions.
    *
    * @var int unsigned
    */
    var $validation_id;
    /**
    * Description and/or help text to display before this field.
    *
    * @var text
    */
    var $help_pre;
    /**
    * Description and/or help text to display after this field.
    *
    * @var text
    */
    var $help_post;
    /**
    * Optional format instructions for specific field types, like date types.
    *
    * @var string
    */
    var $mask;
    /**
    * Store collection of type-appropriate attributes, e.g. textarea  needs rows/cols attributes
    *
    * @var string
    */
    var $attributes;
    /**
    * Optional scripting attributes for field.
    *
    * @var string
    */
    var $javascript;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * number of options per line for checkbox and radio
    *
    * @var int unsigned
    */
    var $options_per_line;
    /**
    * Date may be up to start_date_years years prior to tcurrent date
    *
    * @var int unsigned
    */
    var $start_date_years;
    /**
    * Date may be up to end_date_years years after to tcurrent date
    *
    * @var int unsigned
    */
    var $end_date_years;
    /**
    * which date part included in display
    *
    * @var string
    */
    var $date_parts;
    /**
    *  Number of columns in Note Field
    *
    * @var int unsigned
    */
    var $note_columns;
    /**
    *  Number of rows in Note Field
    *
    * @var int unsigned
    */
    var $note_rows;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_custom_field
    */
    function CRM_Core_DAO_CustomField() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_links'] = array(
                'custom_group_id'=>'civicrm_custom_group:id',
                'validation_id'=>'civicrm_validation:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'custom_group_id'=>array(
                    'name'=>'custom_group_id',
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
                'label'=>array(
                    'name'=>'label',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Label') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'data_type'=>array(
                    'name'=>'data_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Data Type') ,
                ) ,
                'html_type'=>array(
                    'name'=>'html_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Html Type') ,
                ) ,
                'default_value'=>array(
                    'name'=>'default_value',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Default Value') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'is_required'=>array(
                    'name'=>'is_required',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_searchable'=>array(
                    'name'=>'is_searchable',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_search_range'=>array(
                    'name'=>'is_search_range',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
                'validation_id'=>array(
                    'name'=>'validation_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'help_pre'=>array(
                    'name'=>'help_pre',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Pre') ,
                ) ,
                'help_post'=>array(
                    'name'=>'help_post',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Post') ,
                ) ,
                'mask'=>array(
                    'name'=>'mask',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Mask') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'attributes'=>array(
                    'name'=>'attributes',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Attributes') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'javascript'=>array(
                    'name'=>'javascript',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Javascript') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'options_per_line'=>array(
                    'name'=>'options_per_line',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Options Per Line') ,
                ) ,
                'start_date_years'=>array(
                    'name'=>'start_date_years',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Start Date Years') ,
                ) ,
                'end_date_years'=>array(
                    'name'=>'end_date_years',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('End Date Years') ,
                ) ,
                'date_parts'=>array(
                    'name'=>'date_parts',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Date Parts') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'note_columns'=>array(
                    'name'=>'note_columns',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Note Columns') ,
                ) ,
                'note_rows'=>array(
                    'name'=>'note_rows',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Note Rows') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_import'] = array();
            $fields = &CRM_Core_DAO_CustomField::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_import']['custom_field'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_export'] = array();
            $fields = &CRM_Core_DAO_CustomField::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_export']['custom_field'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_custom_field table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['translations'] = array(
                'data_type'=>array(
                    'String'=>ts('String') ,
                    'Int'=>ts('Int') ,
                    'Float'=>ts('Float') ,
                    'Money'=>ts('Money') ,
                    'Memo'=>ts('Memo') ,
                    'Date'=>ts('Date') ,
                    'Boolean'=>ts('Boolean') ,
                    'StateProvince'=>ts('StateProvince') ,
                    'Country'=>ts('Country') ,
                ) ,
                'html_type'=>array(
                    'Text'=>ts('Text') ,
                    'TextArea'=>ts('TextArea') ,
                    'Select'=>ts('Select') ,
                    'Multi-Select'=>ts('Multi-Select') ,
                    'Radio'=>ts('Radio') ,
                    'CheckBox'=>ts('CheckBox') ,
                    'Select Date'=>ts('Select Date') ,
                    'Select State/Province'=>ts('Select State/Province') ,
                    'Select Country'=>ts('Select Country') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_CUSTOMFIELD']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_custom_field
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_CustomField::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_CustomField::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
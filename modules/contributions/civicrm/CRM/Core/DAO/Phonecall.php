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
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['_tableName'] =  'civicrm_phonecall';
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['enums'] =  array(
            'status',
        );
$GLOBALS['_CRM_CORE_DAO_PHONECALL']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Phonecall extends CRM_Core_DAO {
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
    * Unique Phone call ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Contact ID of person making the call. This will generally an authenticated user.
    *
    * @var int unsigned
    */
    var $source_contact_id;
    /**
    * Name of table where item being referenced is stored.
    *
    * @var string
    */
    var $target_entity_table;
    /**
    * Foreign key to the referenced item.
    *
    * @var int unsigned
    */
    var $target_entity_id;
    /**
    * Short description of the subject of this call.
    *
    * @var string
    */
    var $subject;
    /**
    * Date and time phonecall is scheduled to be made.
    *
    * @var datetime
    */
    var $scheduled_date_time;
    /**
    * Planned or actual duration of call - hours.
    *
    * @var int unsigned
    */
    var $duration_hours;
    /**
    * Planned or actual duration of call - minutes.
    *
    * @var int unsigned
    */
    var $duration_minutes;
    /**
    * Phone ID of the number called (optional - used if an existing phone number is selected).
    *
    * @var int unsigned
    */
    var $phone_id;
    /**
    * Phone number in case the number does not exist in the civicrm_phone table.
    *
    * @var string
    */
    var $phone_number;
    /**
    * Details about the call.
    *
    * @var text
    */
    var $details;
    /**
    * What is the status of this phone call? Completed calls result in activity history entry.
    *
    * @var enum('Scheduled', 'Left Message', 'Unreachable', 'Completed')
    */
    var $status;
    /**
    * Parent phone call ID (if this is a follow-up item). This is not currently implemented
    *
    * @var int unsigned
    */
    var $parent_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_phonecall
    */
    function CRM_Core_DAO_Phonecall() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_PHONECALL']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_links'] = array(
                'source_contact_id'=>'civicrm_contact:id',
                'phone_id'=>'civicrm_phone:id',
                'parent_id'=>'civicrm_phonecall:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_PHONECALL']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'source_contact_id'=>array(
                    'name'=>'source_contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'target_entity_table'=>array(
                    'name'=>'target_entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Target Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'target_entity_id'=>array(
                    'name'=>'target_entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'subject'=>array(
                    'name'=>'subject',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Subject') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'scheduled_date_time'=>array(
                    'name'=>'scheduled_date_time',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Scheduled Date Time') ,
                ) ,
                'duration_hours'=>array(
                    'name'=>'duration_hours',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Duration Hours') ,
                ) ,
                'duration_minutes'=>array(
                    'name'=>'duration_minutes',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Duration Minutes') ,
                ) ,
                'phone_id'=>array(
                    'name'=>'phone_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'phone_number'=>array(
                    'name'=>'phone_number',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Phone Number') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'details'=>array(
                    'name'=>'details',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Details') ,
                ) ,
                'status'=>array(
                    'name'=>'status',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Status') ,
                ) ,
                'parent_id'=>array(
                    'name'=>'parent_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_PHONECALL']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_import'] = array();
            $fields = &CRM_Core_DAO_Phonecall::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_import']['phonecall'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_PHONECALL']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_export'] = array();
            $fields = &CRM_Core_DAO_Phonecall::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_export']['phonecall'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_phonecall table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_PHONECALL']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_PHONECALL']['translations'] = array(
                'status'=>array(
                    'Scheduled'=>ts('Scheduled') ,
                    'Left Message'=>ts('Left Message') ,
                    'Unreachable'=>ts('Unreachable') ,
                    'Completed'=>ts('Completed') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_PHONECALL']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_phonecall
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_Phonecall::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_Phonecall::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
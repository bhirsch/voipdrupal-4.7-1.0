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
$GLOBALS['_CRM_CORE_DAO_MEETING']['_tableName'] =  'civicrm_meeting';
$GLOBALS['_CRM_CORE_DAO_MEETING']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_MEETING']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_MEETING']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_MEETING']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_MEETING']['enums'] =  array(
            'status',
        );
$GLOBALS['_CRM_CORE_DAO_MEETING']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Meeting extends CRM_Core_DAO {
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
    * Unique Meeting ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Contact ID of person scheduling or logging this meeting. This will generally an authenticated user.
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
    * The subject/purpose of this meeting.
    *
    * @var string
    */
    var $subject;
    /**
    * Date and time meeting is scheduled to occur.
    *
    * @var datetime
    */
    var $scheduled_date_time;
    /**
    * Planned or actual duration of meeting - hours.
    *
    * @var int unsigned
    */
    var $duration_hours;
    /**
    * Planned or actual duration of meeting - minutes.
    *
    * @var int unsigned
    */
    var $duration_minutes;
    /**
    * Where will the meeting be held ?
    *
    * @var string
    */
    var $location;
    /**
    * Details about the meeting (agenda, notes, etc).
    *
    * @var text
    */
    var $details;
    /**
    * What is the status of this meeting? Completed meeting status results in activity history entry.
    *
    * @var enum('Scheduled', 'Completed')
    */
    var $status;
    /**
    * Parent meeting ID (if this is a follow-up item). This is not currently implemented
    *
    * @var int unsigned
    */
    var $parent_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_meeting
    */
    function CRM_Core_DAO_Meeting() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_MEETING']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_MEETING']['_links'] = array(
                'source_contact_id'=>'civicrm_contact:id',
                'parent_id'=>'civicrm_meeting:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MEETING']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_MEETING']['_fields'] = array(
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
                'location'=>array(
                    'name'=>'location',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Location') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
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
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MEETING']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_MEETING']['_import'] = array();
            $fields = &CRM_Core_DAO_Meeting::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_MEETING']['_import']['meeting'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_MEETING']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_MEETING']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_MEETING']['_export'] = array();
            $fields = &CRM_Core_DAO_Meeting::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_MEETING']['_export']['meeting'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_MEETING']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_meeting table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['enums'];
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
        
        if (!$GLOBALS['_CRM_CORE_DAO_MEETING']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_MEETING']['translations'] = array(
                'status'=>array(
                    'Scheduled'=>ts('Scheduled') ,
                    'Completed'=>ts('Completed') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_MEETING']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_meeting
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_Meeting::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_Meeting::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
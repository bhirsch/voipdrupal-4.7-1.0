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
$GLOBALS['_CRM_MAILING_DAO_JOB']['_tableName'] =  'civicrm_mailing_job';
$GLOBALS['_CRM_MAILING_DAO_JOB']['_fields'] =  null;
$GLOBALS['_CRM_MAILING_DAO_JOB']['_links'] =  null;
$GLOBALS['_CRM_MAILING_DAO_JOB']['_import'] =  null;
$GLOBALS['_CRM_MAILING_DAO_JOB']['_export'] =  null;
$GLOBALS['_CRM_MAILING_DAO_JOB']['enums'] =  array(
            'status',
        );
$GLOBALS['_CRM_MAILING_DAO_JOB']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Mailing_DAO_Job extends CRM_Core_DAO {
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
    *
    * @var int unsigned
    */
    var $id;
    /**
    * The ID of the mailing this Job will send.
    *
    * @var int unsigned
    */
    var $mailing_id;
    /**
    * date on which this job was scheduled.
    *
    * @var datetime
    */
    var $scheduled_date;
    /**
    * date on which this job was started.
    *
    * @var datetime
    */
    var $start_date;
    /**
    * date on which this job ended.
    *
    * @var datetime
    */
    var $end_date;
    /**
    * The state of this job
    *
    * @var enum('Scheduled', 'Running', 'Complete', 'Paused', 'Canceled')
    */
    var $status;
    /**
    * Is this job a retry?
    *
    * @var boolean
    */
    var $is_retry;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mailing_job
    */
    function CRM_Mailing_DAO_Job() 
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
        if (!($GLOBALS['_CRM_MAILING_DAO_JOB']['_links'])) {
            $GLOBALS['_CRM_MAILING_DAO_JOB']['_links'] = array(
                'mailing_id'=>'civicrm_mailing:id',
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_JOB']['_fields'])) {
            $GLOBALS['_CRM_MAILING_DAO_JOB']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'mailing_id'=>array(
                    'name'=>'mailing_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'scheduled_date'=>array(
                    'name'=>'scheduled_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Scheduled Date') ,
                ) ,
                'start_date'=>array(
                    'name'=>'start_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Start Date') ,
                ) ,
                'end_date'=>array(
                    'name'=>'end_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('End Date') ,
                ) ,
                'status'=>array(
                    'name'=>'status',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Status') ,
                ) ,
                'is_retry'=>array(
                    'name'=>'is_retry',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_JOB']['_import'])) {
            $GLOBALS['_CRM_MAILING_DAO_JOB']['_import'] = array();
            $fields = &CRM_Mailing_DAO_Job::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_JOB']['_import']['mailing_job'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_JOB']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_JOB']['_export'])) {
            $GLOBALS['_CRM_MAILING_DAO_JOB']['_export'] = array();
            $fields = &CRM_Mailing_DAO_Job::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_JOB']['_export']['mailing_job'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_JOB']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_mailing_job table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['enums'];
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
        
        if (!$GLOBALS['_CRM_MAILING_DAO_JOB']['translations']) {
            $GLOBALS['_CRM_MAILING_DAO_JOB']['translations'] = array(
                'status'=>array(
                    'Scheduled'=>ts('Scheduled') ,
                    'Running'=>ts('Running') ,
                    'Complete'=>ts('Complete') ,
                    'Paused'=>ts('Paused') ,
                    'Canceled'=>ts('Canceled') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_JOB']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_mailing_job
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Mailing_DAO_Job::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Mailing_DAO_Job::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
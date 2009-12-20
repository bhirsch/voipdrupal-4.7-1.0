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
$GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_tableName'] =  'civicrm_activity_history';
$GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_ActivityHistory extends CRM_Core_DAO {
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
    * table record id
    *
    * @var int unsigned
    */
    var $id;
    /**
    * physical tablename for entity being tagged, e.g. civicrm_contact
    *
    * @var string
    */
    var $entity_table;
    /**
    * FK to entity table specified in entity_table column
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * sortable label for this activity assigned be registering module or user (e.g. Phone Call)
    *
    * @var string
    */
    var $activity_type;
    /**
    * Display name of module which registered this activity
    *
    * @var string
    */
    var $module;
    /**
    * Function to call which will return URL for viewing details
    *
    * @var string
    */
    var $callback;
    /**
    * FK to details item - passed to callback
    *
    * @var int unsigned
    */
    var $activity_id;
    /**
    * brief description of activity for summary display - as populated by registering module
    *
    * @var string
    */
    var $activity_summary;
    /**
    * when did this activity occur
    *
    * @var datetime
    */
    var $activity_date;
    /**
    * OPTIONAL FK to civicrm_relationship.id. Which relationship (of this contact) potentially triggered this activity, i.e. he donated because he was a Board Member of Org X / Employee of Org Y
    *
    * @var int unsigned
    */
    var $relationship_id;
    /**
    * OPTIONAL FK to civicrm_group.id. Was this part of a group communication that triggered this activity?
    *
    * @var int unsigned
    */
    var $group_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_activity_history
    */
    function CRM_Core_DAO_ActivityHistory() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_links'] = array(
                'relationship_id'=>'civicrm_relationship:id',
                'group_id'=>'civicrm_group:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
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
                    'title'=>ts('Contact ID (match to contact)') ,
                    'required'=>true,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.entity_id',
                    'headerPattern'=>'/contact(.?id)?/i',
                    'dataPattern'=>'/^\d+$/',
                    'export'=>true,
                ) ,
                'activity_type'=>array(
                    'name'=>'activity_type',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Activity Type') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.activity_type',
                    'headerPattern'=>'/activity type/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'module'=>array(
                    'name'=>'module',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Module') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.module',
                    'headerPattern'=>'/module/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'callback'=>array(
                    'name'=>'callback',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Callback Method') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.callback',
                    'headerPattern'=>'/callback|method/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'activity_id'=>array(
                    'name'=>'activity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Activity ID') ,
                    'required'=>true,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.activity_id',
                    'headerPattern'=>'/actvity(.?id)?/i',
                    'dataPattern'=>'/^\d+$/',
                    'export'=>true,
                ) ,
                'activity_summary'=>array(
                    'name'=>'activity_summary',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Activity Summary') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.activity_summary',
                    'headerPattern'=>'/activity summary/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'activity_date'=>array(
                    'name'=>'activity_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Activity Date') ,
                    'import'=>true,
                    'where'=>'civicrm_activity_history.activity_date',
                    'headerPattern'=>'/activity date/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'relationship_id'=>array(
                    'name'=>'relationship_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'group_id'=>array(
                    'name'=>'group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_import'] = array();
            $fields = &CRM_Core_DAO_ActivityHistory::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_import']['activity_history'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_export'] = array();
            $fields = &CRM_Core_DAO_ActivityHistory::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_export']['activity_history'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ACTIVITYHISTORY']['_export'];
    }
}
?>
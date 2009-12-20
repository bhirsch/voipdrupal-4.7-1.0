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
$GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_tableName'] =  'civicrm_mailing_event_subscribe';
$GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_fields'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_links'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_import'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Mailing_Event_DAO_Subscribe extends CRM_Core_DAO {
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
    * FK to Group
    *
    * @var int unsigned
    */
    var $group_id;
    /**
    * FK to Contact
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * Security hash
    *
    * @var string
    */
    var $hash;
    /**
    * When this subscription event occurred.
    *
    * @var datetime
    */
    var $time_stamp;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mailing_event_subscribe
    */
    function CRM_Mailing_Event_DAO_Subscribe() 
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
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_links'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_links'] = array(
                'group_id'=>'civicrm_group:id',
                'contact_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_fields'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'group_id'=>array(
                    'name'=>'group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'hash'=>array(
                    'name'=>'hash',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Hash') ,
                    'required'=>true,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'time_stamp'=>array(
                    'name'=>'time_stamp',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Time Stamp') ,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_import'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_import'] = array();
            $fields = &CRM_Mailing_Event_DAO_Subscribe::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_import']['mailing_event_subscribe'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_export'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_export'] = array();
            $fields = &CRM_Mailing_Event_DAO_Subscribe::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_export']['mailing_event_subscribe'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_SUBSCRIBE']['_export'];
    }
}
?>
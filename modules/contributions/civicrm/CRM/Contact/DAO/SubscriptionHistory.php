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
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_tableName'] =  'civicrm_subscription_history';
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_export'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['enums'] =  array(
            'method',
            'status',
        );
$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_SubscriptionHistory extends CRM_Core_DAO {
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
    * Internal Id
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Contact Id
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * Group Id
    *
    * @var int unsigned
    */
    var $group_id;
    /**
    * Date of the (un)subscription
    *
    * @var datetime
    */
    var $date;
    /**
    * How the (un)subscription was triggered
    *
    * @var enum('Admin', 'Email', 'Web', 'API')
    */
    var $method;
    /**
    * The state of the contact within the group
    *
    * @var enum('Added', 'Removed', 'Pending')
    */
    var $status;
    /**
    * IP address or other tracking info
    *
    * @var string
    */
    var $tracking;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_subscription_history
    */
    function CRM_Contact_DAO_SubscriptionHistory() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
                'group_id'=>'civicrm_group:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'group_id'=>array(
                    'name'=>'group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'date'=>array(
                    'name'=>'date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Date') ,
                    'required'=>true,
                ) ,
                'method'=>array(
                    'name'=>'method',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Method') ,
                ) ,
                'status'=>array(
                    'name'=>'status',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Status') ,
                ) ,
                'tracking'=>array(
                    'name'=>'tracking',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Tracking') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_import'] = array();
            $fields = &CRM_Contact_DAO_SubscriptionHistory::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_import']['subscription_history'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_export'] = array();
            $fields = &CRM_Contact_DAO_SubscriptionHistory::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_export']['subscription_history'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_subscription_history table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['translations']) {
            $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['translations'] = array(
                'method'=>array(
                    'Admin'=>ts('Admin') ,
                    'Email'=>ts('Email') ,
                    'Web'=>ts('Web') ,
                    'API'=>ts('API') ,
                ) ,
                'status'=>array(
                    'Added'=>ts('Added') ,
                    'Removed'=>ts('Removed') ,
                    'Pending'=>ts('Pending') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_SUBSCRIPTIONHISTORY']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_subscription_history
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contact_DAO_SubscriptionHistory::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contact_DAO_SubscriptionHistory::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
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
$GLOBALS['_CRM_CORE_DAO_EMAIL']['_tableName'] =  'civicrm_email';
$GLOBALS['_CRM_CORE_DAO_EMAIL']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_EMAIL']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_EMAIL']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_EMAIL']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Email extends CRM_Core_DAO {
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
    * Unique Email ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Location does this email belong to.
    *
    * @var int unsigned
    */
    var $location_id;
    /**
    * Email address
    *
    * @var string
    */
    var $email;
    /**
    * Is this the primary email for this contact and location.
    *
    * @var boolean
    */
    var $is_primary;
    /**
    * Is this address on bounce hold?
    *
    * @var boolean
    */
    var $on_hold;
    /**
    * When the address went on bounce hold
    *
    * @var datetime
    */
    var $hold_date;
    /**
    * When the address bounce status was last reset
    *
    * @var datetime
    */
    var $reset_date;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_email
    */
    function CRM_Core_DAO_Email() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_EMAIL']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_EMAIL']['_links'] = array(
                'location_id'=>'civicrm_location:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_EMAIL']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_EMAIL']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_EMAIL']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'location_id'=>array(
                    'name'=>'location_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'email'=>array(
                    'name'=>'email',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Email') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_email.email',
                    'headerPattern'=>'/e.?mail/i',
                    'dataPattern'=>'/^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/',
                    'export'=>true,
                    'rule'=>'email',
                ) ,
                'is_primary'=>array(
                    'name'=>'is_primary',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'on_hold'=>array(
                    'name'=>'on_hold',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('On Hold') ,
                    'required'=>true,
                ) ,
                'hold_date'=>array(
                    'name'=>'hold_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Hold Date') ,
                ) ,
                'reset_date'=>array(
                    'name'=>'reset_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Reset Date') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_EMAIL']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_EMAIL']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_EMAIL']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_EMAIL']['_import'] = array();
            $fields = &CRM_Core_DAO_Email::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_EMAIL']['_import']['email'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_EMAIL']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_EMAIL']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_EMAIL']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_EMAIL']['_export'] = array();
            $fields = &CRM_Core_DAO_Email::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_EMAIL']['_export']['email'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_EMAIL']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_EMAIL']['_export'];
    }
}
?>
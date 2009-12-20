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
$GLOBALS['_CRM_CORE_DAO_DOMAIN']['_tableName'] =  'civicrm_domain';
$GLOBALS['_CRM_CORE_DAO_DOMAIN']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_DOMAIN']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_DOMAIN']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_DOMAIN']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Domain extends CRM_Core_DAO {
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
    * Domain ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Name of Domain / Organization
    *
    * @var string
    */
    var $name;
    /**
    * Description of Domain.
    *
    * @var string
    */
    var $description;
    /**
    * Name of the person responsible for this domain
    *
    * @var string
    */
    var $contact_name;
    /**
    * The domain from which outgoing email for this domain will appear to originate
    *
    * @var string
    */
    var $email_domain;
    /**
    * The domain from which outgoing email for this domain will appear to originate
    *
    * @var string
    */
    var $email_return_path;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_domain
    */
    function CRM_Core_DAO_Domain() 
    {
        parent::CRM_Core_DAO();
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_DOMAIN']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
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
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'contact_name'=>array(
                    'name'=>'contact_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Contact Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'email_domain'=>array(
                    'name'=>'email_domain',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Email Domain') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'email_return_path'=>array(
                    'name'=>'email_return_path',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Email Return Path') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_DOMAIN']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_import'] = array();
            $fields = &CRM_Core_DAO_Domain::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_import']['domain'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_DOMAIN']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_export'] = array();
            $fields = &CRM_Core_DAO_Domain::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_export']['domain'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_DOMAIN']['_export'];
    }
}
?>
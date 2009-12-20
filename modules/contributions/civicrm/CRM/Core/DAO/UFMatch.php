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
$GLOBALS['_CRM_CORE_DAO_UFMATCH']['_tableName'] =  'civicrm_uf_match';
$GLOBALS['_CRM_CORE_DAO_UFMATCH']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFMATCH']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFMATCH']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFMATCH']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_UFMatch extends CRM_Core_DAO {
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
    * System generated ID.
    *
    * @var int unsigned
    */
    var $id;
    /**
    * UF ID
    *
    * @var int unsigned
    */
    var $uf_id;
    /**
    * FK to Contact ID
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * Which Domain owns this contact (cached here for ease of use reasons)
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Email address
    *
    * @var string
    */
    var $email;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_uf_match
    */
    function CRM_Core_DAO_UFMatch() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_UFMATCH']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFMATCH']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'uf_id'=>array(
                    'name'=>'uf_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'domain_id'=>array(
                    'name'=>'domain_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'email'=>array(
                    'name'=>'email',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Email') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'rule'=>'email',
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFMATCH']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_import'] = array();
            $fields = &CRM_Core_DAO_UFMatch::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_import']['uf_match'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFMATCH']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_export'] = array();
            $fields = &CRM_Core_DAO_UFMatch::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_export']['uf_match'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFMATCH']['_export'];
    }
}
?>
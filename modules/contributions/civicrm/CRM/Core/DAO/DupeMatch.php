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
$GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_tableName'] =  'civicrm_dupe_match';
$GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_DupeMatch extends CRM_Core_DAO {
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
    * Unique DupeMatch ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this contact
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Name Of Entity Table
    *
    * @var string
    */
    var $entity_table;
    /**
    * String that can Contains valid civicrm core or custom field name,parenthesis,,AND,OR
    *
    * @var string
    */
    var $rule;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_dupe_match
    */
    function CRM_Core_DAO_DupeMatch() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'domain_id'=>array(
                    'name'=>'domain_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'entity_table'=>array(
                    'name'=>'entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'rule'=>array(
                    'name'=>'rule',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Rule') ,
                    'required'=>true,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_import'] = array();
            $fields = &CRM_Core_DAO_DupeMatch::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_import']['dupe_match'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_export'] = array();
            $fields = &CRM_Core_DAO_DupeMatch::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_export']['dupe_match'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_DUPEMATCH']['_export'];
    }
}
?>
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
$GLOBALS['_CRM_CORE_DAO_COUNTY']['_tableName'] =  'civicrm_county';
$GLOBALS['_CRM_CORE_DAO_COUNTY']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_COUNTY']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_COUNTY']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_COUNTY']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_County extends CRM_Core_DAO {
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
    * County ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Name of County
    *
    * @var string
    */
    var $name;
    /**
    * 2-4 Character Abbreviation of County
    *
    * @var string
    */
    var $abbreviation;
    /**
    * ID of State / Province that County belongs
    *
    * @var int unsigned
    */
    var $state_province_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_county
    */
    function CRM_Core_DAO_County() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTY']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTY']['_links'] = array(
                'state_province_id'=>'civicrm_state_province:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTY']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTY']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTY']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Country') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'abbreviation'=>array(
                    'name'=>'abbreviation',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Country Abbreviation') ,
                    'maxlength'=>4,
                    'size'=>CRM_UTILS_TYPE_FOUR,
                ) ,
                'state_province_id'=>array(
                    'name'=>'state_province_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTY']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_COUNTY']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTY']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTY']['_import'] = array();
            $fields = &CRM_Core_DAO_County::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_COUNTY']['_import']['county'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_COUNTY']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTY']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTY']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTY']['_export'] = array();
            $fields = &CRM_Core_DAO_County::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_COUNTY']['_export']['county'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_COUNTY']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTY']['_export'];
    }
}
?>
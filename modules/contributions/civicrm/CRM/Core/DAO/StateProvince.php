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
$GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_tableName'] =  'civicrm_state_province';
$GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_StateProvince extends CRM_Core_DAO {
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
    * State / Province ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Name of State / Province
    *
    * @var string
    */
    var $name;
    /**
    * 2-4 Character Abbreviation of State / Province
    *
    * @var string
    */
    var $abbreviation;
    /**
    * ID of Country that State / Province belong
    *
    * @var int unsigned
    */
    var $country_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_state_province
    */
    function CRM_Core_DAO_StateProvince() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_links'] = array(
                'country_id'=>'civicrm_country:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('State') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_state_province.name',
                    'headerPattern'=>'/state|prov(ince)?/i',
                    'dataPattern'=>'/[A-Z]{2}/',
                    'export'=>true,
                ) ,
                'abbreviation'=>array(
                    'name'=>'abbreviation',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('State Abbreviation') ,
                    'maxlength'=>4,
                    'size'=>CRM_UTILS_TYPE_FOUR,
                ) ,
                'country_id'=>array(
                    'name'=>'country_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_import'] = array();
            $fields = &CRM_Core_DAO_StateProvince::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_import']['state_province'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_export'] = array();
            $fields = &CRM_Core_DAO_StateProvince::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_export']['state_province'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_STATEPROVINCE']['_export'];
    }
}
?>
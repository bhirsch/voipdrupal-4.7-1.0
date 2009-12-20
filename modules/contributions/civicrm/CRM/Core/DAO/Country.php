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
$GLOBALS['_CRM_CORE_DAO_COUNTRY']['_tableName'] =  'civicrm_country';
$GLOBALS['_CRM_CORE_DAO_COUNTRY']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_COUNTRY']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_COUNTRY']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_COUNTRY']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Country extends CRM_Core_DAO {
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
    * Country Id
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Country Name
    *
    * @var string
    */
    var $name;
    /**
    * ISO Code
    *
    * @var string
    */
    var $iso_code;
    /**
    * National prefix to be used when dialing TO this country.
    *
    * @var string
    */
    var $country_code;
    /**
    * International direct dialing prefix from within the country TO another country
    *
    * @var string
    */
    var $idd_prefix;
    /**
    * Access prefix to call within a country to a different area
    *
    * @var string
    */
    var $ndd_prefix;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_country
    */
    function CRM_Core_DAO_Country() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTRY']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_fields'] = array(
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
                    'import'=>true,
                    'where'=>'civicrm_country.name',
                    'headerPattern'=>'/country/i',
                    'dataPattern'=>'/^[A-Z][a-z]+\.?(\s+[A-Z][a-z]+){0,3}$/',
                    'export'=>true,
                ) ,
                'iso_code'=>array(
                    'name'=>'iso_code',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Iso Code') ,
                    'maxlength'=>2,
                    'size'=>CRM_UTILS_TYPE_TWO,
                ) ,
                'country_code'=>array(
                    'name'=>'country_code',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Country Code') ,
                    'maxlength'=>4,
                    'size'=>CRM_UTILS_TYPE_FOUR,
                ) ,
                'idd_prefix'=>array(
                    'name'=>'idd_prefix',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Idd Prefix') ,
                    'maxlength'=>4,
                    'size'=>CRM_UTILS_TYPE_FOUR,
                ) ,
                'ndd_prefix'=>array(
                    'name'=>'ndd_prefix',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Ndd Prefix') ,
                    'maxlength'=>4,
                    'size'=>CRM_UTILS_TYPE_FOUR,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTRY']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_import'] = array();
            $fields = &CRM_Core_DAO_Country::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_import']['country'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_COUNTRY']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_export'] = array();
            $fields = &CRM_Core_DAO_Country::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_export']['country'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_COUNTRY']['_export'];
    }
}
?>
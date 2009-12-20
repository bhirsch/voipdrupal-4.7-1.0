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
$GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_tableName'] =  'civicrm_household';
$GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_Household extends CRM_Core_DAO {
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
    * Unique Household ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * FK to Contact ID
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * Household Name.
    *
    * @var string
    */
    var $household_name;
    /**
    * Optional FK to Primary Contact for this household.
    *
    * @var int unsigned
    */
    var $primary_contact_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_household
    */
    function CRM_Contact_DAO_Household() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
                'primary_contact_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_fields'] = array(
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
                'household_name'=>array(
                    'name'=>'household_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Household Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_household.household_name',
                    'headerPattern'=>'/^household|(h(ousehold\s)?name)$/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
                'primary_contact_id'=>array(
                    'name'=>'primary_contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_import'] = array();
            $fields = &CRM_Contact_DAO_Household::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_import']['household'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_export'] = array();
            $fields = &CRM_Contact_DAO_Household::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_export']['household'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_HOUSEHOLD']['_export'];
    }
}
?>
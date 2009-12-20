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
$GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_tableName'] =  'civicrm_organization';
$GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_Organization extends CRM_Core_DAO {
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
    * Unique Organization ID
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
    * Organization Name.
    *
    * @var string
    */
    var $organization_name;
    /**
    * Legal Name.
    *
    * @var string
    */
    var $legal_name;
    /**
    * Standard Industry Classification Code.
    *
    * @var string
    */
    var $sic_code;
    /**
    * Optional FK to Primary Contact for this organization.
    *
    * @var int unsigned
    */
    var $primary_contact_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_organization
    */
    function CRM_Contact_DAO_Organization() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
                'primary_contact_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_fields'] = array(
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
                'organization_name'=>array(
                    'name'=>'organization_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Organization Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_organization.organization_name',
                    'headerPattern'=>'/^organization|(o(rganization\s)?name)$/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
                'legal_name'=>array(
                    'name'=>'legal_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Legal Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_organization.legal_name',
                    'headerPattern'=>'/^legal|(l(egal\s)?name)$/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'sic_code'=>array(
                    'name'=>'sic_code',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Sic Code') ,
                    'maxlength'=>8,
                    'size'=>CRM_UTILS_TYPE_EIGHT,
                    'import'=>true,
                    'where'=>'civicrm_organization.sic_code',
                    'headerPattern'=>'/^sic|(s(ic\s)?code)$/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'primary_contact_id'=>array(
                    'name'=>'primary_contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_import'] = array();
            $fields = &CRM_Contact_DAO_Organization::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_import']['organization'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_export'] = array();
            $fields = &CRM_Contact_DAO_Organization::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_export']['organization'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_ORGANIZATION']['_export'];
    }
}
?>
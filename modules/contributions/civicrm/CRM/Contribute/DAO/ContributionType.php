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
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_tableName'] =  'civicrm_contribution_type';
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_ContributionType extends CRM_Core_DAO {
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
    * Contribution Type ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this contribution type.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Contribution Type Name.
    *
    * @var string
    */
    var $name;
    /**
    * Optional value for mapping contributions to accounting system codes for each type/category of contribution.
    *
    * @var string
    */
    var $accounting_code;
    /**
    * Contribution Type Description.
    *
    * @var string
    */
    var $description;
    /**
    * Is this contribution type tax-deductible? If true, contributions of this type may be fully OR partially deductible - non-deductible amount is stored in the Contribution record.
    *
    * @var boolean
    */
    var $is_deductible;
    /**
    * Is this a predefined system object?
    *
    * @var boolean
    */
    var $is_reserved;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_contribution_type
    */
    function CRM_Contribute_DAO_ContributionType() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_fields'] = array(
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
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Contribution Type') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_contribution_type.name',
                    'headerPattern'=>'/(contrib(ution)?)?type/i',
                    'dataPattern'=>'/donation|member|campaign/i',
                    'export'=>true,
                ) ,
                'accounting_code'=>array(
                    'name'=>'accounting_code',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Accounting Code') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'export'=>true,
                    'where'=>'civicrm_contribution_type.accounting_code',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'is_deductible'=>array(
                    'name'=>'is_deductible',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_reserved'=>array(
                    'name'=>'is_reserved',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_import'] = array();
            $fields = &CRM_Contribute_DAO_ContributionType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_import']['contribution_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_export'] = array();
            $fields = &CRM_Contribute_DAO_ContributionType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_export']['contribution_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONTYPE']['_export'];
    }
}
?>
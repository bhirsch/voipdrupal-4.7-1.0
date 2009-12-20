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
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_tableName'] =  'civicrm_contribution_product';
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_ContributionProduct extends CRM_Core_DAO {
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
    *
    * @var int unsigned
    */
    var $id;
    /**
    *
    * @var int unsigned
    */
    var $product_id;
    /**
    *
    * @var int unsigned
    */
    var $contribution_id;
    /**
    * Option value selected if applicable - e.g. color, size etc.
    *
    * @var string
    */
    var $product_option;
    /**
    *
    * @var int
    */
    var $quantity;
    /**
    * Optional. Can be used to record the date this product was fulfilled or shipped.
    *
    * @var date
    */
    var $fulfilled_date;
    /**
    * Actual start date for a time-delimited premium (subscription, service or membership)
    *
    * @var date
    */
    var $start_date;
    /**
    * Actual end date for a time-delimited premium (subscription, service or membership)
    *
    * @var date
    */
    var $end_date;
    /**
    *
    * @var text
    */
    var $comment;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_contribution_product
    */
    function CRM_Contribute_DAO_ContributionProduct() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_links'] = array(
                'contribution_id'=>'civicrm_contribution:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'product_id'=>array(
                    'name'=>'product_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.product_id',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'contribution_id'=>array(
                    'name'=>'contribution_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.contribution_id',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'product_option'=>array(
                    'name'=>'product_option',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Product Option') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.product_option',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'quantity'=>array(
                    'name'=>'quantity',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Quantity') ,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.quantity',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'fulfilled_date'=>array(
                    'name'=>'fulfilled_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Fulfilled Date') ,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.fulfilled_date',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'start_date'=>array(
                    'name'=>'start_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Start Date') ,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.start_date',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'end_date'=>array(
                    'name'=>'end_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('End Date') ,
                    'export'=>true,
                    'where'=>'civicrm_contribution_product.end_date',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'comment'=>array(
                    'name'=>'comment',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Comment') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_import'] = array();
            $fields = &CRM_Contribute_DAO_ContributionProduct::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_import']['contribution_product'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_export'] = array();
            $fields = &CRM_Contribute_DAO_ContributionProduct::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_export']['contribution_product'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPRODUCT']['_export'];
    }
}
?>
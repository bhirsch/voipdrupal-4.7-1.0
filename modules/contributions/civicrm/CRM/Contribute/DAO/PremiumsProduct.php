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
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_tableName'] =  'civicrm_premiums_product';
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_PremiumsProduct extends CRM_Core_DAO {
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
    * Contribution ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Foreign key to premiums settings record.
    *
    * @var int unsigned
    */
    var $premiums_id;
    /**
    * Foreign key to each product object.
    *
    * @var int unsigned
    */
    var $product_id;
    /**
    *
    * @var int unsigned
    */
    var $sort_position;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_premiums_product
    */
    function CRM_Contribute_DAO_PremiumsProduct() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_links'] = array(
                'premiums_id'=>'civicrm_premiums:id',
                'product_id'=>'civicrm_product:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'premiums_id'=>array(
                    'name'=>'premiums_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'product_id'=>array(
                    'name'=>'product_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'sort_position'=>array(
                    'name'=>'sort_position',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Sort Position') ,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_import'] = array();
            $fields = &CRM_Contribute_DAO_PremiumsProduct::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_import']['premiums_product'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_export'] = array();
            $fields = &CRM_Contribute_DAO_PremiumsProduct::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_export']['premiums_product'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUMSPRODUCT']['_export'];
    }
}
?>
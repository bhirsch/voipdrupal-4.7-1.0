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
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_tableName'] =  'civicrm_product';
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_export'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['enums'] =  array(
            'period_type',
            'duration_unit',
            'frequency_unit',
        );
$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_Product extends CRM_Core_DAO {
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
    * Which Domain owns this product class.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Required product/premium name
    *
    * @var string
    */
    var $name;
    /**
    * Optional description of the product/premium.
    *
    * @var text
    */
    var $description;
    /**
    * Optional product sku or code.
    *
    * @var string
    */
    var $sku;
    /**
    * Store comma-delimited list of color, size, etc. options for the product.
    *
    * @var text
    */
    var $options;
    /**
    * Full or relative URL to uploaded image - fullsize.
    *
    * @var string
    */
    var $image;
    /**
    * Full or relative URL to image thumbnail.
    *
    * @var string
    */
    var $thumbnail;
    /**
    * Sell price or market value for premiums. For tax-deductible contributions, this will be stored as non_deductible_amount in the contribution record.
    *
    * @var float
    */
    var $price;
    /**
    * Minimum contribution required to be eligible to select this premium.
    *
    * @var float
    */
    var $min_contribution;
    /**
    * Actual cost of this product. Useful to determine net return from sale or using this as an incentive.
    *
    * @var float
    */
    var $cost;
    /**
    * Disabling premium removes it from the premiums_premium join table below.
    *
    * @var boolean
    */
    var $is_active;
    /**
    * Rolling means we set start/end based on current day, fixed means we set start/end for current year or month
    (e.g. 1 year + fixed -> we would set start/end for 1/1/06 thru 12/31/06 for any premium chosen in 2006)
    *
    * @var enum('rolling', 'fixed')
    */
    var $period_type;
    /**
    * Month and day (MMDD) that fixed period type subscription or membership starts.
    *
    * @var int
    */
    var $fixed_period_start_day;
    /**
    *
    * @var enum('day', 'month', 'week', 'year')
    */
    var $duration_unit;
    /**
    * Number of units for total duration of subscription, service, membership (e.g. 12 Months).
    *
    * @var int
    */
    var $duration_interval;
    /**
    * Frequency unit and interval allow option to store actual delivery frequency for a subscription or service.
    *
    * @var enum('day', 'month', 'week', 'year')
    */
    var $frequency_unit;
    /**
    * Number of units for delivery frequency of subscription, service, membership (e.g. every 3 Months).
    *
    * @var int
    */
    var $frequency_interval;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_product
    */
    function CRM_Contribute_DAO_Product() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_fields'] = array(
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
                    'title'=>ts('Product Name') ,
                    'required'=>true,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'export'=>true,
                    'where'=>'civicrm_product.name',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Description') ,
                ) ,
                'sku'=>array(
                    'name'=>'sku',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('SKU') ,
                    'maxlength'=>50,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'export'=>true,
                    'where'=>'civicrm_product.sku',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'options'=>array(
                    'name'=>'options',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Options') ,
                ) ,
                'image'=>array(
                    'name'=>'image',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Image') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'thumbnail'=>array(
                    'name'=>'thumbnail',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Thumbnail') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'price'=>array(
                    'name'=>'price',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Price') ,
                ) ,
                'min_contribution'=>array(
                    'name'=>'min_contribution',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Minimum Contribution') ,
                ) ,
                'cost'=>array(
                    'name'=>'cost',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Cost') ,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Active') ,
                    'required'=>true,
                ) ,
                'period_type'=>array(
                    'name'=>'period_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Period Type') ,
                ) ,
                'fixed_period_start_day'=>array(
                    'name'=>'fixed_period_start_day',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Fixed Period Start Day') ,
                ) ,
                'duration_unit'=>array(
                    'name'=>'duration_unit',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Duration Unit') ,
                ) ,
                'duration_interval'=>array(
                    'name'=>'duration_interval',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Duration Interval') ,
                ) ,
                'frequency_unit'=>array(
                    'name'=>'frequency_unit',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Frequency Unit') ,
                ) ,
                'frequency_interval'=>array(
                    'name'=>'frequency_interval',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Frequency Interval') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_import'] = array();
            $fields = &CRM_Contribute_DAO_Product::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_import']['product'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_export'] = array();
            $fields = &CRM_Contribute_DAO_Product::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_export']['product'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_product table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['enums'];
    }
    /**
    * returns a ts()-translated enum value for display purposes
    *
    * @param string $field  the enum field in question
    * @param string $value  the enum value up for translation
    *
    * @return string  the display value of the enum
    */
     function tsEnum($field, $value) 
    {
        
        if (!$GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['translations']) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['translations'] = array(
                'period_type'=>array(
                    'rolling'=>ts('rolling') ,
                    'fixed'=>ts('fixed') ,
                ) ,
                'duration_unit'=>array(
                    'day'=>ts('day') ,
                    'month'=>ts('month') ,
                    'week'=>ts('week') ,
                    'year'=>ts('year') ,
                ) ,
                'frequency_unit'=>array(
                    'day'=>ts('day') ,
                    'month'=>ts('month') ,
                    'week'=>ts('week') ,
                    'year'=>ts('year') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PRODUCT']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_product
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contribute_DAO_Product::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contribute_DAO_Product::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
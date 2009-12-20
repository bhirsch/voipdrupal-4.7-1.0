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
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_tableName'] =  'civicrm_financial_trxn';
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_export'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['enums'] =  array(
            'trxn_type',
        );
$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_FinancialTrxn extends CRM_Core_DAO {
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
    * Gift ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this gift class.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * physical tablename for entity being extended by this data, e.g. civicrm_contact
    *
    * @var string
    */
    var $entity_table;
    /**
    * FK to record in the entity table specified by entity_table column.
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    *
    * @var datetime
    */
    var $trxn_date;
    /**
    *
    * @var enum('Debit', 'Credit')
    */
    var $trxn_type;
    /**
    * amount of transaction
    *
    * @var float
    */
    var $total_amount;
    /**
    * actual processor fee if known - may be 0.
    *
    * @var float
    */
    var $fee_amount;
    /**
    * actual funds transfer amount. total less fees. if processor does not report actual fee during transaction, this is set to total_amount.
    *
    * @var float
    */
    var $net_amount;
    /**
    * 3 character string, value derived from payment processor config setting.
    *
    * @var string
    */
    var $currency;
    /**
    * derived from Processor setting in civicrm.settings.php.
    *
    * @var string
    */
    var $payment_processor;
    /**
    * unique processor transaction id, bank id + trans id,... depending on payment_method
    *
    * @var string
    */
    var $trxn_id;
    /**
    * processor result code
    *
    * @var string
    */
    var $trxn_result_code;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_financial_trxn
    */
    function CRM_Contribute_DAO_FinancialTrxn() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_fields'] = array(
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
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_id'=>array(
                    'name'=>'entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'trxn_date'=>array(
                    'name'=>'trxn_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Trxn Date') ,
                    'required'=>true,
                ) ,
                'trxn_type'=>array(
                    'name'=>'trxn_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Trxn Type') ,
                    'required'=>true,
                ) ,
                'total_amount'=>array(
                    'name'=>'total_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Total Amount') ,
                    'required'=>true,
                ) ,
                'fee_amount'=>array(
                    'name'=>'fee_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Fee Amount') ,
                ) ,
                'net_amount'=>array(
                    'name'=>'net_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Net Amount') ,
                ) ,
                'currency'=>array(
                    'name'=>'currency',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Currency') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_financial_trxn.currency',
                    'headerPattern'=>'/cur(rency)?/i',
                    'dataPattern'=>'/^[A-Z]{3}$/',
                    'export'=>true,
                ) ,
                'payment_processor'=>array(
                    'name'=>'payment_processor',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Payment Processor') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'trxn_id'=>array(
                    'name'=>'trxn_id',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'required'=>true,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'trxn_result_code'=>array(
                    'name'=>'trxn_result_code',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Trxn Result Code') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_import'] = array();
            $fields = &CRM_Contribute_DAO_FinancialTrxn::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_import']['financial_trxn'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_export'] = array();
            $fields = &CRM_Contribute_DAO_FinancialTrxn::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_export']['financial_trxn'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_financial_trxn table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['translations']) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['translations'] = array(
                'trxn_type'=>array(
                    'Debit'=>ts('Debit') ,
                    'Credit'=>ts('Credit') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_FINANCIALTRXN']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_financial_trxn
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contribute_DAO_FinancialTrxn::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contribute_DAO_FinancialTrxn::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
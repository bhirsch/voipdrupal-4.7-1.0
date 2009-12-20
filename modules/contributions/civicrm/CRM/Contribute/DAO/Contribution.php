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
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_tableName'] =  'civicrm_contribution';
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
require_once 'CRM/Contribute/DAO/ContributionType.php';
require_once 'CRM/Contribute/DAO/PaymentInstrument.php';
class CRM_Contribute_DAO_Contribution extends CRM_Core_DAO {
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
    * Which Domain owns this contribution class.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * FK to Contact ID
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * FK to Solicitor ID
    *
    * @var int unsigned
    */
    var $solicitor_id;
    /**
    * FK to Contribution Type
    *
    * @var int unsigned
    */
    var $contribution_type_id;
    /**
    * FK to Payment Instrument
    *
    * @var int unsigned
    */
    var $payment_instrument_id;
    /**
    * when was gift received
    *
    * @var datetime
    */
    var $receive_date;
    /**
    * Portion of total amount which is NOT tax deductible. Equal to total_amount for non-deductible contribution types.
    *
    * @var float
    */
    var $non_deductible_amount;
    /**
    * Total amount of this contribution. Use market value for non-monetary gifts.
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
    * unique transaction id. may be processor id, bank id + trans id, or account number + check number... depending on payment_method
    *
    * @var string
    */
    var $trxn_id;
    /**
    * unique invoice id, system generated or passed in
    *
    * @var string
    */
    var $invoice_id;
    /**
    * 3 character string, value derived from payment processor config setting.
    *
    * @var string
    */
    var $currency;
    /**
    * when was gift cancelled
    *
    * @var datetime
    */
    var $cancel_date;
    /**
    *
    * @var text
    */
    var $cancel_reason;
    /**
    * when (if) receipt was sent. populated automatically for online donations w/ automatic receipting
    *
    * @var datetime
    */
    var $receipt_date;
    /**
    * when (if) was donor thanked
    *
    * @var datetime
    */
    var $thankyou_date;
    /**
    * Origin of this Contribution.
    *
    * @var string
    */
    var $source;
    /**
    * Note and/or Comment.
    *
    * @var text
    */
    var $note;
    /**
    * Conditional foreign key to civicrm_contribution_recur id. Each contribution made in connection with a recurring contribution carries a foreign key to the recurring contribution record. This assumes we can track these processor initiated events.
    *
    * @var int unsigned
    */
    var $recur_contribution_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_contribution
    */
    function CRM_Contribute_DAO_Contribution() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'contact_id'=>'civicrm_contact:id',
                'solicitor_id'=>'civicrm_contact:id',
                'contribution_type_id'=>'civicrm_contribution_type:id',
                'payment_instrument_id'=>'civicrm_payment_instrument:id',
                'recur_contribution_id'=>'civicrm_contribution_recur:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_fields'] = array(
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
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Contact ID (match to contact)') ,
                    'required'=>true,
                    'import'=>true,
                    'where'=>'civicrm_contribution.contact_id',
                    'headerPattern'=>'/contact(.?id)?/i',
                    'dataPattern'=>'/^\d+$/',
                    'export'=>true,
                ) ,
                'solicitor_id'=>array(
                    'name'=>'solicitor_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Solicitor ID') ,
                ) ,
                'contribution_type_id'=>array(
                    'name'=>'contribution_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'payment_instrument_id'=>array(
                    'name'=>'payment_instrument_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'receive_date'=>array(
                    'name'=>'receive_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Receive Date') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.receive_date',
                    'headerPattern'=>'/receive(.?date)?/i',
                    'dataPattern'=>'/^\d{4}-?\d{2}-?\d{2} ?(\d{2}:?\d{2}:?(\d{2})?)?$/',
                    'export'=>true,
                ) ,
                'non_deductible_amount'=>array(
                    'name'=>'non_deductible_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Non-deductible Amount') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.non_deductible_amount',
                    'headerPattern'=>'/non?.?deduct/i',
                    'dataPattern'=>'/^\d+(\.\d{2})?$/',
                    'export'=>true,
                ) ,
                'total_amount'=>array(
                    'name'=>'total_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Total Amount') ,
                    'required'=>true,
                    'import'=>true,
                    'where'=>'civicrm_contribution.total_amount',
                    'headerPattern'=>'/total(.?am(ou)?nt)?/i',
                    'dataPattern'=>'/^\d+(\.\d{2})?$/',
                    'export'=>true,
                ) ,
                'fee_amount'=>array(
                    'name'=>'fee_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Fee Amount') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.fee_amount',
                    'headerPattern'=>'/fee(.?am(ou)?nt)?/i',
                    'dataPattern'=>'/^\d+(\.\d{2})?$/',
                    'export'=>true,
                ) ,
                'net_amount'=>array(
                    'name'=>'net_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Net Amount') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.net_amount',
                    'headerPattern'=>'/net(.?am(ou)?nt)?/i',
                    'dataPattern'=>'/^\d+(\.\d{2})?$/',
                    'export'=>true,
                ) ,
                'trxn_id'=>array(
                    'name'=>'trxn_id',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Transaction ID') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_contribution.trxn_id',
                    'headerPattern'=>'/tr(ansactio|x)n(.?id)?/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'invoice_id'=>array(
                    'name'=>'invoice_id',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Invoice ID') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_contribution.invoice_id',
                    'headerPattern'=>'/invoice(.?id)?/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'currency'=>array(
                    'name'=>'currency',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Currency') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_contribution.currency',
                    'headerPattern'=>'/cur(rency)?/i',
                    'dataPattern'=>'/^[A-Z]{3}$/i',
                    'export'=>true,
                ) ,
                'cancel_date'=>array(
                    'name'=>'cancel_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Cancel Date') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.cancel_date',
                    'headerPattern'=>'/cancel(.?date)?/i',
                    'dataPattern'=>'/^\d{4}-?\d{2}-?\d{2} ?(\d{2}:?\d{2}:?(\d{2})?)?$/',
                    'export'=>true,
                ) ,
                'cancel_reason'=>array(
                    'name'=>'cancel_reason',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Cancel Reason') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.cancel_reason',
                    'headerPattern'=>'/(cancel.?)?reason/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'receipt_date'=>array(
                    'name'=>'receipt_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Receipt Date') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.receipt_date',
                    'headerPattern'=>'/receipt(.?date)?/i',
                    'dataPattern'=>'/^\d{4}-?\d{2}-?\d{2} ?(\d{2}:?\d{2}:?(\d{2})?)?$/',
                    'export'=>true,
                ) ,
                'thankyou_date'=>array(
                    'name'=>'thankyou_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Thank-you Date') ,
                    'import'=>true,
                    'where'=>'civicrm_contribution.thankyou_date',
                    'headerPattern'=>'/thank(s|(.?you))?(.?date)?/i',
                    'dataPattern'=>'/^\d{4}-?\d{2}-?\d{2} ?(\d{2}:?\d{2}:?(\d{2})?)?$/',
                    'export'=>true,
                ) ,
                'source'=>array(
                    'name'=>'source',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Contribution Source') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_contribution.source',
                    'headerPattern'=>'/source/i',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'note'=>array(
                    'name'=>'note',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Note') ,
                    'rows'=>4,
                    'cols'=>80,
                    'import'=>true,
                    'where'=>'civicrm_contribution.note',
                    'headerPattern'=>'/Note|Comment/i',
                    'dataPattern'=>'//',
                    'export'=>true,
                ) ,
                'recur_contribution_id'=>array(
                    'name'=>'recur_contribution_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'] = array();
            $fields = &CRM_Contribute_DAO_Contribution::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import']['contribution'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'][$name] = &$fields[$name];
                    }
                }
            }
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'] = array_merge($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'], CRM_Contribute_DAO_ContributionType::import(true));
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'] = array_merge($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'], CRM_Contribute_DAO_PaymentInstrument::import(true));
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'] = array();
            $fields = &CRM_Contribute_DAO_Contribution::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export']['contribution'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'][$name] = &$fields[$name];
                    }
                }
            }
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'] = array_merge($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'], CRM_Contribute_DAO_ContributionType::export(true));
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'] = array_merge($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'], CRM_Contribute_DAO_PaymentInstrument::export(true));
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTION']['_export'];
    }
}
?>
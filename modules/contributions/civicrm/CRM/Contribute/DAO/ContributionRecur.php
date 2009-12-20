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
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_tableName'] =  'civicrm_contribution_recur';
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_export'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['enums'] =  array(
            'frequency_unit',
        );
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_ContributionRecur extends CRM_Core_DAO {
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
    * Contribution Recur ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Foreign key to civicrm_contact.id .
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * Amount to be contributed or charged each recurrence.
    *
    * @var float
    */
    var $amount;
    /**
    * Time units for recurrence of payment.
    *
    * @var enum('day', 'week', 'month', 'year')
    */
    var $frequency_unit;
    /**
    * Number of time units for recurrence of payment.
    *
    * @var int unsigned
    */
    var $frequency_interval;
    /**
    * Total number of payments to be made. Set this to 0 if this is an open-ended commitment i.e. no set end date.
    *
    * @var int unsigned
    */
    var $installments;
    /**
    * The date the first scheduled recurring contribution occurs.
    *
    * @var date
    */
    var $start_date;
    /**
    * When this recurring contribution record was created.
    *
    * @var date
    */
    var $create_date;
    /**
    * Last updated date for this record.
    *
    * @var date
    */
    var $modified_date;
    /**
    * Date this recurring contribution was cancelled by contributor- if we can get access to it ??
    *
    * @var date
    */
    var $cancel_date;
    /**
    * Set to false by contributor cancellation or greater than max permitted failures - if we know about that.
    *
    * @var tinyint
    */
    var $is_active;
    /**
    * Day in the period when the payment should be charged e.g. 1st of month, 15th etc.
    *
    * @var int unsigned
    */
    var $cycle_day;
    /**
    * At Groundspring this was used by the cron job which triggered payments. If we\'re not doing that but we know about payments, it might still be useful to store for display to org andor contributors.
    *
    * @var date
    */
    var $next_sched_contribution;
    /**
    * Number of failed charge attempts since last success. Business rule could be set to deactivate on more than x failures.
    *
    * @var int unsigned
    */
    var $failure_count;
    /**
    * At Groundspring we set a business rule to retry failed payments every 7 days - and stored the next scheduled attempt date there.
    *
    * @var date
    */
    var $failure_retry_date;
    /**
    * Possibly needed to store a unique identifier for this recurring payment order - if this is available from the processor??
    *
    * @var string
    */
    var $processor_id;
    /**
    * Some systems allow contributor to set a number of installments - but then auto-renew the subscription or commitment if they do not cancel.
    *
    * @var tinyint
    */
    var $auto_renew;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_contribution_recur
    */
    function CRM_Contribute_DAO_ContributionRecur() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_fields'] = array(
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
                'amount'=>array(
                    'name'=>'amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Amount') ,
                    'required'=>true,
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
                    'required'=>true,
                ) ,
                'installments'=>array(
                    'name'=>'installments',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Installments') ,
                ) ,
                'start_date'=>array(
                    'name'=>'start_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Start Date') ,
                    'required'=>true,
                ) ,
                'create_date'=>array(
                    'name'=>'create_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Create Date') ,
                    'required'=>true,
                ) ,
                'modified_date'=>array(
                    'name'=>'modified_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Modified Date') ,
                    'required'=>true,
                ) ,
                'cancel_date'=>array(
                    'name'=>'cancel_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Cancel Date') ,
                    'required'=>true,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_TINYINT,
                    'required'=>true,
                ) ,
                'cycle_day'=>array(
                    'name'=>'cycle_day',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Cycle Day') ,
                    'required'=>true,
                ) ,
                'next_sched_contribution'=>array(
                    'name'=>'next_sched_contribution',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Next Sched Contribution') ,
                    'required'=>true,
                ) ,
                'failure_count'=>array(
                    'name'=>'failure_count',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Failure Count') ,
                ) ,
                'failure_retry_date'=>array(
                    'name'=>'failure_retry_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Failure Retry Date') ,
                ) ,
                'processor_id'=>array(
                    'name'=>'processor_id',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'auto_renew'=>array(
                    'name'=>'auto_renew',
                    'type'=>CRM_UTILS_TYPE_T_TINYINT,
                    'title'=>ts('Auto Renew') ,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_import'] = array();
            $fields = &CRM_Contribute_DAO_ContributionRecur::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_import']['contribution_recur'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_export'] = array();
            $fields = &CRM_Contribute_DAO_ContributionRecur::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_export']['contribution_recur'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_contribution_recur table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['translations']) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['translations'] = array(
                'frequency_unit'=>array(
                    'day'=>ts('day') ,
                    'week'=>ts('week') ,
                    'month'=>ts('month') ,
                    'year'=>ts('year') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONRECUR']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_contribution_recur
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contribute_DAO_ContributionRecur::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contribute_DAO_ContributionRecur::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
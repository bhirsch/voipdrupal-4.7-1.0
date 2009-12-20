<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 1.4                                                |
 +--------------------------------------------------------------------+
 | Copyright (c) 2005 Donald A. Lobo                                  |
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
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_CONTRIBUTE_BAO_PAYMENTINSTRUMENT']['_defaultPaymentInstrument'] =  null;

require_once 'CRM/Contribute/DAO/PaymentInstrument.php';

class CRM_Contribute_BAO_PaymentInstrument extends CRM_Contribute_DAO_PaymentInstrument 
{

    /**
     * static holder for the default LT
     */
    
    

    /**
     * class constructor
     */
    function CRM_Contribute_BAO_PaymentInstrument( ) 
    {
        parent::CRM_Contribute_DAO_PaymentInstrument( );
    }
    
    /**
     * Takes a bunch of params that are needed to match certain criteria and
     * retrieves the relevant objects. Typically the valid params are only
     * contact_id. We'll tweak this function to be more full featured over a period
     * of time. This is the inverse function of create. It also stores all the retrieved
     * values in the default array
     *
     * @param array $params   (reference ) an assoc array of name/value pairs
     * @param array $defaults (reference ) an assoc array to hold the flattened values
     *
     * @return object CRM_Core_BAO_PaymentInstrument object
     * @access public
     * @static
     */
     function retrieve( &$params, &$defaults ) 
    {
        $paymentInstrument =& new CRM_Contribute_DAO_PaymentInstrument( );
        $paymentInstrument->copyValues( $params );
        if ( $paymentInstrument->find( true ) ) {
            CRM_Core_DAO::storeValues( $paymentInstrument, $defaults );
            return $paymentInstrument;
        }
        return null;
    }

    /**
     * update the is_active flag in the db
     *
     * @param int      $id        id of the database record
     * @param boolean  $is_active value we want to set the is_active field
     *
     * @return Object             DAO object on sucess, null otherwise
     * @static
     */
     function setIsActive( $id, $is_active ) 
    {
        return CRM_Core_DAO::setFieldValue( 'CRM_Contribute_DAO_PaymentInstrument', $id, 'is_active', $is_active );
    }


    /**
     * retrieve the default PaymentInstrument
     *
     * @return object           The default PaymentInstrument object on success,
     *                          null otherwise
     * @static
     * @access public
     */
     function &getDefault() 
    {
        if ($GLOBALS['_CRM_CONTRIBUTE_BAO_PAYMENTINSTRUMENT']['_defaultPaymentInstrument'] == null) {
            $params = array('is_default' => 1);
            $defaults = array();
            $GLOBALS['_CRM_CONTRIBUTE_BAO_PAYMENTINSTRUMENT']['_defaultPaymentInstrument'] = CRM_Contribute_BAO_PaymentInstrument::retrieve($params, $defaults);
        }
        return $GLOBALS['_CRM_CONTRIBUTE_BAO_PAYMENTINSTRUMENT']['_defaultPaymentInstrument'];
    }

    /**
     * function to add the PaymentInstrument
     *
     * @param array $params reference array contains the values submitted by the form
     * @param array $ids    reference array contains the id
     * 
     * @access public
     * @static 
     * @return object
     */
     function add(&$params, &$ids) 
    {
        
        $params['is_active'] =  CRM_Utils_Array::value( 'is_active', $params, false );
        $params['is_default'] =  CRM_Utils_Array::value( 'is_default', $params, false );
        
        // action is taken depending upon the mode
        $paymentInstrument               =& new CRM_Contribute_DAO_PaymentInstrument( );
        $paymentInstrument->domain_id    = CRM_Core_Config::domainID( );
        
        $paymentInstrument->copyValues( $params );;
        
        if ($params['is_default']) {
            $unsetDefault =& new CRM_Contribute_DAO();
            $query = 'UPDATE civicrm_payment_instrument SET is_default = 0';
            $unsetDefault->query($query);
        }
        
        $paymentInstrument->id = CRM_Utils_Array::value( 'paymentInstrument', $ids );
        $paymentInstrument->save( );
        return $paymentInstrument;
    }
    
    /**
     * Function to delete PaymentInstrument 
     * 
     * @param int $paymentInstrumentId
     * @static
     */
    
     function del($paymentInstrumentId) 
    {
        //check dependencies
        
        //delete from PaymentInstrument table
        require_once 'CRM/Contribute/DAO/Contribution.php';
        $paymentInstrument =& new CRM_Contribute_DAO_PaymentInstrument( );
        $paymentInstrument->id = $paymentInstrumentId;
        $paymentInstrument->delete();

    }

}

?>

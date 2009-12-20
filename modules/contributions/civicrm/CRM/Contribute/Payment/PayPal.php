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
 | at http://www.openngo.org/faqs/licensing.html                      | 
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

define( 'CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET','iso-8859-1');
$GLOBALS['_CRM_CONTRIBUTE_PAYMENT_PAYPAL']['_singleton'] =  null;

require_once 'CRM/Contribute/Payment.php';

class CRM_Contribute_Payment_PayPal extends CRM_Contribute_Payment {
    
           
    
    /** 
     * We only need one instance of this object. So we use the singleton 
     * pattern and cache the instance in this variable 
     * 
     * @var object 
     * @static 
     */ 
     

    /** 
     * Constructor 
     * 
     * @param string $mode the mode of operation: live or test
     *
     * @return void 
     */ 
    function CRM_Contribute_Payment_PayPal( $mode ) {
        require_once 'Services/PayPal.php';
        require_once 'Services/PayPal/Profile/Handler/File.php';
        require_once 'Services/PayPal/Profile/API.php';

        $config =& CRM_Core_Config::singleton( );
        $this->_handler =& ProfileHandler_File::getInstance( array(
                                                                   'path' => $config->paymentCertPath[$mode],
                                                                   'charset' => CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET,
                                                                   )
                                                             );
        
        if ( Services_PayPal::isError( $handler ) ) {
            return CRM_Contribute_Payment_PayPal::error( $handler );
        }

        $this->_profile =& APIProfile::getInstance( $config->paymentKey[$mode], $this->_handler );

        if ( Services_PayPal::isError( $this->_profile ) ) {
            return CRM_Contribute_Payment_PayPal::error( $this->_profile );
        }

        $this->_profile->setAPIPassword( $config->paymentPassword[$mode] );

        $this->_caller =& Services_PayPal::getCallerServices( $this->_profile );

        if ( Services_PayPal::isError( $this->_caller ) ) {
            $ret = CRM_Contribute_Payment_PayPal::error( $this->_caller );
            $this->_caller = null;
            return $ret;
        }
    }

    /** 
     * singleton function used to manage this object 
     * 
     * @param string $mode the mode of operation: live or test
     * 
     * @return object 
     * @static 
     * 
     */ 
     function &singleton( $mode ) {
        if ($GLOBALS['_CRM_CONTRIBUTE_PAYMENT_PAYPAL']['_singleton'] === null ) { 
            $GLOBALS['_CRM_CONTRIBUTE_PAYMENT_PAYPAL']['_singleton'] =& new CRM_Contribute_Payment_Paypal( $mode );
        } 
        return $GLOBALS['_CRM_CONTRIBUTE_PAYMENT_PAYPAL']['_singleton']; 
    } 

    /**
     * express checkout code. Check PayPal documentation for more information
     * @param  array $params assoc array of input parameters for this transaction 
     * 
     * @return array the result in an nice formatted array (or an error object) 
     * @public
     */
    function setExpressCheckOut( &$params ) {
        if ( ! $this->_caller ) {
            return CRM_Contribute_Payment_PayPal::error( );
        }

        $orderTotal =& Services_PayPal::getType( 'BasicAmountType' );

        if ( Services_PayPal::isError( $orderTotal ) ) {
            return CRM_Contribute_Payment_PayPal::error( $orderTotal );
        }

        $orderTotal->setattr('currencyID', $params['currencyID'] );
        $orderTotal->setval( $params['amount'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $setExpressCheckoutRequestDetails =& Services_PayPal::getType( 'SetExpressCheckoutRequestDetailsType' );

        if ( Services_PayPal::isError( $setExpressCheckoutRequestDetails ) ) {
            return CRM_Contribute_Payment_PayPal::error( $setExpressCheckoutRequestDetails );
        }

        $setExpressCheckoutRequestDetails->setCancelURL ( $params['cancelURL'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $setExpressCheckoutRequestDetails->setReturnURL ( $params['returnURL'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $setExpressCheckoutRequestDetails->setInvoiceID ( $params['invoiceID'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $setExpressCheckoutRequestDetails->setOrderTotal( $orderTotal );
        $setExpressCheckout =& Services_PayPal::getType ( 'SetExpressCheckoutRequestType' );

        if ( Services_PayPal::isError( $setExpressCheckout ) ) {
            return CRM_Contribute_Payment_PayPal::error( $setExpressCheckout );
        }

        $setExpressCheckout->setSetExpressCheckoutRequestDetails( $setExpressCheckoutRequestDetails );

        $result = $this->_caller->SetExpressCheckout( $setExpressCheckout );

        if (Services_PayPal::isError( $result  ) ) { 
            return CRM_Contribute_Payment_PayPal::error( $result );
        }

        $result =& CRM_Contribute_Payment_PayPal::checkResult( $result );
        if ( is_a( $result, 'CRM_Core_Error' ) ) {
            return $result;
        }

        /* Success, extract the token and return it */
        return $result->getToken( );
    }

    /**
     * get details from paypal. Check PayPal documentation for more information
     *
     * @param  string $token the key associated with this transaction
     * 
     * @return array the result in an nice formatted array (or an error object) 
     * @public
     */
    function getExpressCheckoutDetails( $token ) {
        if ( ! $this->_caller ) {
            return CRM_Contribute_Payment_PayPal::error( );
        }

        $getExpressCheckoutDetails =& Services_PayPal::getType('GetExpressCheckoutDetailsRequestType');

        if ( Services_PayPal::isError( $getExpressCheckoutDetails ) ) {
            return CRM_Contribute_Payment_PayPal::error( $getExpressCheckoutDetails );
        }

        $getExpressCheckoutDetails->setToken( $token, CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);

        $result = $this->_caller->GetExpressCheckoutDetails( $getExpressCheckoutDetails );

        if ( Services_PayPal::isError( $result ) ) { 
            return CRM_Contribute_Payment_PayPal::error( $result );
        }

        /* Success */
        $detail                =& $result->getGetExpressCheckoutDetailsResponseDetails( );

        $params                 =  array( );
        $params['token']        =  $result->Token;
        
        $payer                  =& $detail->getPayerInfo ( );
        $params['payer'       ] =  $payer->Payer;
        $params['payer_id'    ] =  $payer->PayerID;
        $params['payer_status'] =  $payer->PayerStatus;
        
        $name                  =& $payer->getPayerName  ( );
        $params['first_name' ] =  $name->getFirstName   ( );
        $params['middle_name'] =  $name->getMiddleName  ( );
        $params['last_name'  ] =  $name->getLastName    ( );
        
        $address                  =& $payer->getAddress    ( );
        $params['street_address'] =  $address->getStreet1  ( );
        $params['supplemental_address_1'] = $address->getStreet2( );
        $params['city']        =  $address->getCityName ( );
        $params['state_province'] = $address->getStateOrProvince( );
        $params['postal_code'] = $address->getPostalCode( );
        $params['country']     =  $address->getCountry  ( );
        
        return $params;
    }

    /**
     * do the express checkout at paypal. Check PayPal documentation for more information
     *
     * @param  string $token the key associated with this transaction
     * 
     * @return array the result in an nice formatted array (or an error object) 
     * @public
     */
    function doExpressCheckout( &$params ) {
        if ( ! $this->_caller ) {
            return CRM_Contribute_Payment_PayPal::error( );
        }

        $orderTotal =& Services_PayPal::getType( 'BasicAmountType' ); 
 
        if ( Services_PayPal::isError( $orderTotal ) ) { 
            return CRM_Contribute_Payment_PayPal::error( $orderTotal ); 
        } 
 
        $orderTotal->setattr('currencyID', $params['currencyID'] ); 
        $orderTotal->setval( $params['amount'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET); 
        $paymentDetails =& Services_PayPal::getType( 'SetExpressCheckoutRequestDetailsType' ); 
        
        if ( Services_PayPal::isError( $paymentDetails ) ) {
            return CRM_Contribute_Payment_PayPal::error( $paymentDetails );
        }

        $paymentDetails->setOrderTotal( $orderTotal );
        $paymentDetails->setInvoiceID( $params['invoiceID'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doExpressCheckoutPaymentRequestDetails =& Services_PayPal::getType( 'DoExpressCheckoutPaymentRequestDetailsType' );

        if ( Services_PayPal::isError( $doExpressCheckoutPaymentRequestDetails ) ) {
            return CRM_Contribute_Payment_PayPal::error( $doExpressCheckoutPaymentRequestDetails );
        }

        $doExpressCheckoutPaymentRequestDetails->setPaymentDetails( $paymentDetails );
        $doExpressCheckoutPaymentRequestDetails->setPayerID       ( $params['payer_id']      , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doExpressCheckoutPaymentRequestDetails->setToken         ( $params['token']         , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doExpressCheckoutPaymentRequestDetails->setPaymentAction ( $params['payment_action'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doExpressCheckoutPayment =& Services_PayPal::getType( 'DoExpressCheckoutPaymentRequestType' );

        if ( Services_PayPal::isError( $doExpressCheckoutPayment ) ) {
            return CRM_Contribute_Payment_PayPal::error( $doExpressCheckoutPayment );
        }

        $doExpressCheckoutPayment->setDoExpressCheckoutPaymentRequestDetails( $doExpressCheckoutPaymentRequestDetails );

        $result = $this->_caller->DoExpressCheckoutPayment( $doExpressCheckoutPayment );

        if ( Services_PayPal::isError( $result ) ) { 
            return CRM_Contribute_Payment_PayPal::error( $result );
        }

        $result =& CRM_Contribute_Payment_PayPal::checkResult( $result ); 
        if ( is_a( $result, 'CRM_Core_Error' ) ) { 
            return $result; 
        } 

        /* Success */
        $details     =& $result->getDoExpressCheckoutPaymentResponseDetails( );
        
        $paymentInfo =& $details->getPaymentInfo( );
        
        $params['trxn_id']        = $paymentInfo->TransactionID;
        $params['gross_amount'  ] = CRM_Contribute_Payment_PayPal::getAmount( $paymentInfo->GrossAmount );
        $params['fee_amount'    ] = CRM_Contribute_Payment_PayPal::getAmount( $paymentInfo->FeeAmount    );
        $params['net_amount'    ] = CRM_Contribute_Payment_PayPal::getAmount( $paymentInfo->SettleAmount );
        if ( $params['net_amount'] == 0 && $params['fee_amount'] != 0 ) {
            $params['net_amount'] = $params['gross_amount'] - $params['fee_amount'];
        }
        $params['payment_status'] = $paymentInfo->PaymentStatus;
        $params['pending_reason'] = $paymentInfo->PendingReason;
        
        return $params;
    }

    /**
     * extract the value from the paypal amount structure
     *
     * @param Object $amount the paypal amount type
     *
     * @return string the amount value
     * @public
     */
    function getAmount( &$amount ) {
        return $amount->_value;
    }

    /**
     * This function collects all the information from a web/api form and invokes
     * the relevant payment processor specific functions to perform the transaction
     *
     * @param  array $params assoc array of input parameters for this transaction
     *
     * @return array the result in an nice formatted array (or an error object)
     * @public
     */
    function doDirectPayment( &$params ) {
        if ( ! $this->_caller ) {
            return CRM_Contribute_Payment_PayPal::error( );
        }

        $orderTotal =& Services_PayPal::getType( 'BasicAmountType' );  
  
        if ( Services_PayPal::isError( $orderTotal ) ) {  
            return CRM_Contribute_Payment_PayPal::error( $orderTotal );  
        }  
  
        $orderTotal->setattr( 'currencyID', $params['currencyID'] );  
        $orderTotal->setval( $params['amount'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);  

        $payerName =& Services_PayPal::getType( 'PersonNameType' );

        if ( Services_PayPal::isError( $payerName ) ) {
            return CRM_Contribute_Payment_PayPal::error( $payerName );
        }

        $payerName->setLastName  ( $params['last_name'  ], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $payerName->setMiddleName( $params['middle_name'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $payerName->setFirstName ( $params['first_name' ], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $address =& Services_PayPal::getType('AddressType');

        if (Services_PayPal::isError($address)) {
            return CRM_Contribute_Payment_PayPal::error( $address );
        }

        $address->setStreet1        ( $params['street_address'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $address->setCityName       ( $params['city']          , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $address->setStateOrProvince( $params['state_province'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $address->setPostalCode     ( $params['postal_code']   , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $address->setCountry        ( $params['country']       , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $cardOwner =& Services_PayPal::getType( 'PayerInfoType' );

        if ( Services_PayPal::isError( $cardOwner ) ) {
            return CRM_Contribute_Payment_PayPal::error( $cardOwner );
        }

        $cardOwner->setPayer( $params['email'] );
        $cardOwner->setAddress( $address );
        $cardOwner->setPayerCountry( $params['country'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $cardOwner->setPayerName( $payerName );
        $creditCard =& Services_PayPal::getType( 'CreditCardDetailsType' );

        if ( Services_PayPal::isError( $creditCard ) ) {
            return CRM_Contribute_Payment_PayPal::error( $creditCard );
        }

        $creditCard->setCardOwner( $cardOwner );
        $creditCard->setCVV2            ( $params['cvv2']              , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $creditCard->setExpYear         ( $params['year' ]             , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $creditCard->setExpMonth        ( $params['month']             , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $creditCard->setCreditCardNumber( $params['credit_card_number'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $creditCard->setCreditCardType  ( $params['credit_card_type']  , CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doDirectPaymentRequestDetails =& Services_PayPal::getType( 'DoDirectPaymentRequestDetailsType' );

        $paymentDetails =& Services_PayPal::getType( 'PaymentDetailsType' );

        if ( Services_PayPal::isError( $paymentDetails ) ) {
            return CRM_Contribute_Payment_PayPal::error( $paymentDetails );
        }

        $paymentDetails->setOrderTotal($orderTotal);
        $paymentDetails->setInvoiceID( $params['invoiceID'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);

        $shipToAddress = $address;
        $shipToAddress->setName( $params['first_name' ] . ' ' . $params['last_name'] );
        $paymentDetails->setShipToAddress( $shipToAddress );

        if ( Services_PayPal::isError( $doDirectPaymentRequestDetails ) ) {
            return CRM_Contribute_Payment_PayPal::error( $doDirectPaymentRequestDetails );
        }

        $doDirectPaymentRequestDetails->setCreditCard    ( $creditCard     );
        $doDirectPaymentRequestDetails->setPaymentDetails( $paymentDetails );
        $doDirectPaymentRequestDetails->setIPAddress     ( $params['ip_address'    ], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doDirectPaymentRequestDetails->setPaymentAction ( $params['payment_action'], CRM_CONTRIBUTE_PAYMENT_PAYPAL_CHARSET);
        $doDirectPayment =& Services_PayPal::getType( 'DoDirectPaymentRequestType' );

        if ( Services_PayPal::isError( $doDirectPayment ) ) {
            return CRM_Contribute_Payment_PayPal::error( $doDirectPayment );
        }

        $doDirectPayment->setDoDirectPaymentRequestDetails( $doDirectPaymentRequestDetails );

        $result = $this->_caller->DoDirectPayment( $doDirectPayment );

        if ( Services_PayPal::isError( $result ) ) { 
            return CRM_Contribute_Payment_PayPal::error( $result );
        }

        /* Check for application errors */
        $result =& CRM_Contribute_Payment_PayPal::checkResult( $result );
        if ( is_a( $result, 'CRM_Core_Error' ) ) {  
            return $result;  
        }

        /* Success */
        $params['trxn_id']        = $result->TransactionID;
        $params['gross_amount'  ] = CRM_Contribute_Payment_PayPal::getAmount( $result->Amount );
        return $params;
    }

    /**
     * helper function to check the result and construct an error packet 
     * if needed
     *
     * @param Object an object returned by the paypal SDK
     *
     * @return Object the same object if not an error, else a CRM_Core_Error object
     * @public
     */
    function &checkResult( &$result ) {
        $errors = $result->getErrors( );
        if ( empty( $errors ) ) {
            return $result;
        }

        $e =& CRM_Core_Error::singleton( );
        if ( is_a( $errors, 'ErrorType' ) ) {
                $e->push( $errors->getErrorCode( ), 
                          0, null, 
                          $errors->getShortMessage( ) . ' ' . $errors->getLongMessage( ) ); 
        } else {
            foreach ( $errors as $error ) { 
                $e->push( $error->getErrorCode( ), 
                          0, null, 
                          $error->getShortMessage( ) . ' ' . $error->getLongMessage( ) ); 
            } 
        }
        return $e;
    }

    /**
     * create a CiviCRM error object and return
     *
     * @param Object a PEAR_Error object
     *
     * @return Object a CiviCRM Error object
     * @public
     */
    function &error( $error = null ) {
        $e =& CRM_Core_Error::singleton( );
        if ( $error ) {
            $e->push( $error->getCode( ),
                      0, null,
                      $error->getMessage( ) );
        } else {
            $e->push( 9001, 0, null, "Unknown System Error." );
        }
        return $e;
    }

    /** 
     * This function checks to see if we have the right config values 
     * 
     * @param  string $mode the mode we are operating in (live or test) 
     * 
     * @return string the error message if any 
     * @public 
     */ 
    function checkConfig( $mode ) {
        $config =& CRM_Core_Config::singleton( );

        $error = array( );

        if ( empty( $config->paymentCertPath[$mode] ) ) {
            if ( $mode == 'live' ) {
                $error[] = ts( '%1 is not set in the config file.', array(1 => 'CIVICRM_CONTRIBUTE_PAYMENT_CERT_PATH') );
            } else {
                $error[] = ts( '%1 is not set in the config file.', array(1 => 'CIVICRM_CONTRIBUTE_PAYMENT_TEST_CERT_PATH') );
            }
        }
        
        if ( empty( $config->paymentKey[$mode] ) ) {
            if ( $mode == 'live' ) {
                $error[] = ts( '%1 is not set in the config file.', array(1 => 'CIVICRM_CONTRIBUTE_PAYMENT_KEY') ); 
            } else {
                $error[] = ts( '%1 is not set in the config file.', array(1 => 'CIVICRM_CONTRIBUTE_PAYMENT_TEST_KEY') ); 
            }
        }
        
        if ( empty( $config->paymentPassword[$mode] ) ) {
            if ( $mode == 'live' ) {
                $error[] = ts( '%1 is not set in the config file.', array(1 => 'CIVICRM_CONTRIBUTE_PAYMENT_PASSWORD') );
            } else {
                $error[] = ts( '%1 is not set in the config file.', array(1 => 'CIVICRM_CONTRIBUTE_PAYMENT_TEST_PASSWORD') );
            }
        }

        if ( ! empty( $error ) ) {
            return implode( ' ', $error );
        } else {
            return null;
        }
    }

}

?>

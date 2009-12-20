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
 * Config handles all the run time configuration changes that the system needs to deal with.
 * Typically we'll have different values for a user's sandbox, a qa sandbox and a production area.
 * The default values in general, should reflect production values (minimizes chances of screwing up)
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


require_once 'CRM/Core/Config.php';

class CRM_Contribute_Config {

    /**
     * Name of the payment processor
     *
     * @var string
     */
    var $paymentProcessor = null;

    /** 
     * Name of the payment class that implement
     * the payment processor directive
     * 
     * @var string 
     */ 
    var $paymentClass = null;

    /**
     * Type of billing mode
     *
     * 1 - billing information collected
     * 2 - button displayed, billing information on processor side
     * 3 - both
     * @var int
     */
    var $paymentBillingMode = null;

    /**
     * Where are the payment processor secret files stored
     *
     * @var string
     */
    var $paymentCertPath = array( );

    /** 
     * What is the payment file key
     * 
     * @var string                
     */ 
    var $paymentKey = array( );

    /** 
     * What is the payment password
     * 
     * @var string                
     */ 
    var $paymentPassword = array( );

    /** 
     * What is the payment response email address
     * 
     * @var string                
     */ 
    var $paymentResponseEmail = null;

    /** 
        * URL to payment processor submit button for "express" processors / button mode
        * 
        * @var string                
        */ 
    var $paymentProcessorButton = null;
    
    /**
     * Function to add additional config paramters to the core Config class
     * if CiviContribute is enabled
     *
     * Note that this config class prevent code bloat in the Core Config class,
     * however we declare all the variables assigned here, more for documentation
     * than anything else, at some point, we'll figure out how to extend a class
     * and properties dynamically in PHP (like Ruby)
     *
     * @param CRM_Core_Config (reference ) the system config object
     *
     * @return void
     * @static
     * @access public
     */
     function add( &$config ) {

        $config->paymentProcessor       = null;
        $config->paymentClass           = null;
        $config->paymentBillingMode     = null;
        $config->paymentCertPath        = null;
        $config->paymentKey             = null;
        $config->paymentPassword        = null;
        $config->paymentProcessorButton = "https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif";
        $config->paymentPayPalExpressUrl = "www.paypal.com";
        $config->paymentPayPalExpressTestUrl = "www.sandbox.paypal.com";

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_PROCESSOR' ) ) {
            require_once 'CRM/Contribute/Payment.php';
            $config->paymentProcessor = CIVICRM_CONTRIBUTE_PAYMENT_PROCESSOR;
            switch ( $config->paymentProcessor ) {
            case 'PayPal':
                $config->paymentClass = 'CRM_Contribute_Payment_PayPal';
                $config->paymentExpressButton = CIVICRM_CONTRIBUTE_PAYMENT_EXPRESS_BUTTON;
                $config->paymentPayPalExpressUrl = CIVICRM_CONTRIBUTE_PAYMENT_PAYPAL_EXPRESS_URL;
                $config->paymentPayPalExpressTestUrl = CIVICRM_CONTRIBUTE_PAYMENT_PAYPAL_EXPRESS_TEST_URL;
                $config->paymentBillingMode =
                    CRM_CONTRIBUTE_PAYMENT_BILLING_MODE_FORM |
                    CRM_CONTRIBUTE_PAYMENT_BILLING_MODE_BUTTON;
                break;

            case 'PayPal_Express':
                $config->paymentClass = 'CRM_Contribute_Payment_PayPal';
                $config->paymentBillingMode = CRM_CONTRIBUTE_PAYMENT_BILLING_MODE_BUTTON;
                $config->paymentExpressButton = CIVICRM_CONTRIBUTE_PAYMENT_EXPRESS_BUTTON;
                $config->paymentPayPalExpressUrl = CIVICRM_CONTRIBUTE_PAYMENT_PAYPAL_EXPRESS_URL;
                $config->paymentPayPalExpressTestUrl = CIVICRM_CONTRIBUTE_PAYMENT_PAYPAL_EXPRESS_TEST_URL;
                break;

            case 'Moneris':
                $config->paymentClass = 'CRM_Contribute_Payment_Moneris';
                $config->paymentBillingMode = CRM_CONTRIBUTE_PAYMENT_BILLING_MODE_FORM;
                break;
            }
        }

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_CERT_PATH' ) ) {
            $config->paymentCertPath['live'] = CRM_Core_Config::addTrailingSlash( CIVICRM_CONTRIBUTE_PAYMENT_CERT_PATH );
        }

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_TEST_CERT_PATH' ) ) {
            $config->paymentCertPath['test'] = CRM_Core_Config::addTrailingSlash( CIVICRM_CONTRIBUTE_PAYMENT_TEST_CERT_PATH );
        }

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_KEY' ) ) {
            $config->paymentKey['live'] = CIVICRM_CONTRIBUTE_PAYMENT_KEY;
        }

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_TEST_KEY' ) ) {
            $config->paymentKey['test'] = CIVICRM_CONTRIBUTE_PAYMENT_TEST_KEY;
        }

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_PASSWORD' ) ) {
            $config->paymentPassword['live'] = CIVICRM_CONTRIBUTE_PAYMENT_PASSWORD;
        }

        if ( defined( 'CIVICRM_CONTRIBUTE_PAYMENT_TEST_PASSWORD' ) ) {
            $config->paymentPassword['test'] = CIVICRM_CONTRIBUTE_PAYMENT_TEST_PASSWORD;
        }

    }

    /**
     * verify that the needed parameters have been set of SMS to work
     *
     * @param CRM_Core_Config (reference ) the system config object
     *
     * @return boolean
     * @static
     * @access public
     */
     function check( &$config ) {
        $requiredParameters = array( 'smsUsername', 'smsPassword', 'smsAPIID', 'smsAPIServer' );
        return CRM_Core_Config::check( $config, $requiredParameters );
    }

}



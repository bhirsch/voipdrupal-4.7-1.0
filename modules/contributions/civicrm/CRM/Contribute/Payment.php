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
 
define( 'CRM_CONTRIBUTE_PAYMENT_BILLING_MODE_FORM',1);
define( 'CRM_CONTRIBUTE_PAYMENT_BILLING_MODE_BUTTON',2);
$GLOBALS['_CRM_CONTRIBUTE_PAYMENT']['_singleton'] =  null;

 class CRM_Contribute_Payment {
    /**
     * how are we getting billing information?
     *
     * FORM   - we collect it on the same page
     * BUTTON - the processor collects it and sends it back to us via some protocol
     */
    
            
          

    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     *
     * @var object
     * @static
     */
    

    /**  
     * singleton function used to manage this object  
     *  
     * @param string $mode the mode of operation: live or test
     *  
     * @return object  
     * @static  
     *  
     */  
     function &singleton( $mode = 'test' ) {
        if ($GLOBALS['_CRM_CONTRIBUTE_PAYMENT']['_singleton'] === null ) {
            $config   =& CRM_Core_Config::singleton( );
            
            $classPath = str_replace( '_', '/', $config->paymentClass ) . '.php';
            require_once($classPath);
            $GLOBALS['_CRM_CONTRIBUTE_PAYMENT']['_singleton'] = eval( 'return ' . $config->paymentClass . '::singleton( $mode );' );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_PAYMENT']['_singleton'];
    }

    /**
     * This function collects all the information from a web/api form and invokes
     * the relevant payment processor specific functions to perform the transaction
     *
     * @param  array $params assoc array of input parameters for this transaction
     *
     * @return array the result in an nice formatted array (or an error object)
     * @abstract
     */
    // abstract function doDirectPayment( &$params );

    /**
     * This function checks to see if we have the right config values
     *
     * @param  string $mode the mode we are operating in (live or test)
     *
     * @return string the error message if any
     * @public
     */
    // abstract function checkConfig( $mode );

}

?>
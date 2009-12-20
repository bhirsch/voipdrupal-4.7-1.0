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

/**
 * This class holds all the Pseudo constants that are specific to Mass mailing. This avoids
 * polluting the core class and isolates the mass mailer class
 */
$GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['contributionType'] = null;
$GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['paymentInstrument'] = null;
$GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['creditCard'] = null;

class CRM_Contribute_PseudoConstant extends CRM_Core_PseudoConstant {

    /**
     * contribution types
     * @var array
     * @static
     */
    

    /**
     * payment instruments
     *
     * @var array
     * @static
     */
    

    /**
     * credit card
     *
     * @var array
     * @static
     */
    

    /**
     * Get all the contribution types
     *
     * @access public
     * @return array - array reference of all contribution types if any
     * @static
     */
      function &contributionType($id = null)
    {
        if ( ! $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['contributionType'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['contributionType'],
                                               'CRM_Contribute_DAO_ContributionType' );
        }
        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['contributionType'])) {
                return $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['contributionType'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['contributionType'];
    }

    /**
     * Get all the payment instruments
     *
     * @access public
     * @return array - array reference of all payment instruments if any
     * @static
     */
      function &paymentInstrument($id = null)
    {
        if ( ! $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['paymentInstrument'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['paymentInstrument'],
                                               'CRM_Contribute_DAO_PaymentInstrument' );
        }
        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['paymentInstrument'])) {
                return $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['paymentInstrument'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['paymentInstrument'];
    }

    /**
     * Get all the valid accepted credit cards
     *               
     * @access public 
     * @return array - array reference of all payment instruments if any 
     * @static 
     */                  
      function &creditCard( ) {
        if ( ! $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['creditCard'] ) { 
            $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['creditCard'] = array( );

            require_once 'CRM/Contribute/DAO/AcceptCreditCard.php';
            $dao =& new CRM_Contribute_DAO_AcceptCreditCard( );
            $dao->is_active = 1;
            $dao->orderBy( 'id' );
            $dao->find( );
            while ( $dao->fetch( ) ) {
                $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['creditCard'][$dao->name] = $dao->title;
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_PSEUDOCONSTANT']['creditCard'];
    }


    /**
     * Get all premiums 
     *               
     * @access public 
     * @return array - array of all Premiums if any 
     * @static 
     */  
      function products( $pageID = null ) {
        $products = array();
        require_once 'CRM/Contribute/DAO/Product.php';
        $dao = & new CRM_Contribute_DAO_Product();
        $dao->domain_id  = CRM_Core_Config::domainID( );
        $dao->is_active = 1;
        $dao->orderBy( 'id' );
        $dao->find( );
        
        while ( $dao->fetch( ) ) {
            $products[$dao->id] = $dao->name;
        }
        if ( $pageID ) {
            require_once 'CRM/Contribute/DAO/Premium.php';
            $dao =& new CRM_Contribute_DAO_Premium();
            $dao->entity_table = 'civicrm_contribution_page';
            $dao->entity_id = $pageID; 
            $dao->find(true);
            $premiumID = $dao->id;
            
            $productID = array();  
            
            require_once 'CRM/Contribute/DAO/PremiumsProduct.php';
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->premiums_id = $premiumID;
            $dao->find();
            while ($dao->fetch()) {
                $productID[$dao->product_id] = $dao->product_id;
            }
           
            $tempProduct = array();
            foreach( $products as $key => $value ) {
                if ( ! array_key_exists( $key , $productID ) ) {
                    $tempProduct[$key] = $value;
                }
            }
            
            return $tempProduct;
        }

        return $products;        
    }
    
}

?>

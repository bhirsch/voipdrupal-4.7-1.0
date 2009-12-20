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


require_once 'CRM/Contribute/DAO/Premium.php';

class CRM_Contribute_BAO_Premium extends CRM_Contribute_DAO_Premium 
{

   
    /**
     * class constructor
     */
    function CRM_Contribute_BAO_Premium( ) 
    {
        parent::CRM_Contribute_DAO_Premium( );
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
     * @return object CRM_Contribute_BAO_ManagePremium object
     * @access public
     * @static
     */
     function retrieve( &$params, &$defaults ) 
    {
        $premium =& new CRM_Contribute_DAO_Product( );
        $premium->copyValues( $params );
        if ( $premium->find( true ) ) {
            CRM_Core_DAO::storeValues( $premium, $defaults );
            return $premium;
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
        return CRM_Core_DAO::setFieldValue( 'CRM_Contribute_DAO_Premium', $id, 'premiums_active ', $is_active );
    }

    /**
     * Function to delete contribution Types 
     * 
     * @param int $contributionTypeId
     * @static
     */
    
     function del($premiumID) 
    {
        //check dependencies
        
        //delete from contribution Type table
        require_once 'CRM/Contribute/DAO/Premium.php';
        $premium =& new CRM_Contribute_DAO_Premium( );
        $premium->id = $premiumID;
        $premium->delete();
    }

    /**
     * Function to build Premium Block im Contribution Pages 
     * 
     * @param int $pageId 
     * @static
     */

    function buildPremiumBlock( $form , $pageID , $formItems = false ,$selectedProductID = null ,$selectedOption = null ) {
        
        require_once 'CRM/Contribute/DAO/Premium.php';
        $dao =& new CRM_Contribute_DAO_Premium();
        $dao->entity_table = 'civicrm_contribution_page';
        $dao->domain_id  = CRM_Core_Config::domainID( );
        $dao->entity_id = $pageID; 
        $dao->premiums_active = 1;
        
        if ( $dao->find(true) ) {
            $premiumID = $dao->id;
            $premiumBlock = array();
            CRM_Core_DAO::storeValues($dao, $premiumBlock );
            
            require_once 'CRM/Contribute/DAO/PremiumsProduct.php';
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->premiums_id = $premiumID;
            $dao->orderBy('sort_position');
            $dao->find();
            
            $products = array();
            $radio    = array();
            while ($dao->fetch()) {
                require_once 'CRM/Contribute/DAO/Product.php';
                $productDAO =& new CRM_Contribute_DAO_Product();
                $productDAO->domain_id  = CRM_Core_Config::domainID( );
                $productDAO->id = $dao->product_id;
                $productDAO->is_active = 1;
                if ($productDAO->find(true) ) {
                    if( $selectedProductID != null ) {
                        if(  $selectedProductID == $productDAO->id  ) {
                            if ( $selectedOption ) {
                                $productDAO->options = ts('Selected Option') . ': ' . $selectedOption;
                            } else {
                                $productDAO->options = null;
                            }
                            CRM_Core_DAO::storeValues( $productDAO, $products[$productDAO->id]);
                            
                        }
                    } else {
                        CRM_Core_DAO::storeValues( $productDAO, $products[$productDAO->id]);
                    }
                }
                $radio[$productDAO->id] = $form->createElement('radio',null, null, null, $productDAO->id , null);
                $options = $temp = array();
                $temp = explode(',' , $productDAO->options );
                foreach ($temp as $value) {
                    $options[trim($value)] = trim($value);
                }
                if ( $temp[0] != '' ) {
                    $form->addElement('select', 'options_'.$productDAO->id , null, $options, array( 'onchange' => "return selectPremium(this);" ));
                }
                  
            }
            if ( count($products) ) {
                $form->assign( 'showRadio',$formItems );
                if ( $formItems ) {
                    $radio[''] = $form->createElement('radio',null,null,ts('No thank you'),'no_thanks', null);
                    $form->addGroup($radio,'selectProduct',null);
                }
                $form->assign( 'showSelectOptions',$formItems );
                $form->assign( 'products' , $products );
                $form->assign( 'premiumBlock' , $premiumBlock );
            }
        }
    }

    /**
     * Function to build Premium B im Contribution Pages 
     * 
     * @param int $pageId 
     * @static
     */
    
    function buildPremiumPreviewBlock( $form , $productID , $premiumProductID = null ) {
        
        require_once 'CRM/Contribute/DAO/Product.php';
        if ( $premiumProductID ) {
            require_once 'CRM/Contribute/DAO/PremiumsProduct.php';
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->id = $premiumProductID;
            $dao->domain_id  = CRM_Core_Config::domainID( );
            $dao->find(true);
            $productID = $dao->product_id;
        }
        $productDAO =& new CRM_Contribute_DAO_Product();
        $productDAO->id = $productID;
        $productDAO->domain_id  = CRM_Core_Config::domainID( );
        $productDAO->is_active = 1;
        if ($productDAO->find(true) ) {
            CRM_Core_DAO::storeValues( $productDAO, $products[$productDAO->id]);
        }
        
        $radio[$productDAO->id] = $form->createElement('radio',null, null, null, $productDAO->id , null);
        $options = $temp = array();
        $temp = explode(',' , $productDAO->options );
        foreach ($temp as $value) {
            $options[$value] = $value;
        }
        if ( $temp[0] != '' ) {
            $form->add('select', 'options_'.$productDAO->id , null , $options);
        }
        
        
        $form->addGroup($radio,'selectProduct',null);
        
        $form->assign( 'showRadio',true );
        $form->assign( 'showSelectOptions',true );
        $form->assign( 'products' , $products );
        $form->assign( 'preview' , true);
    }
}
?>

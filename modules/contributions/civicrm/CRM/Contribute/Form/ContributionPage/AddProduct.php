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

$GLOBALS['_CRM_CONTRIBUTE_FORM_CONTRIBUTIONPAGE_ADDPRODUCT']['_products'] = null;
$GLOBALS['_CRM_CONTRIBUTE_FORM_CONTRIBUTIONPAGE_ADDPRODUCT']['_pid'] = null;

require_once 'CRM/Contribute/Form/ContributionPage.php';
require_once 'CRM/Contribute/PseudoConstant.php';

/**
 * form to process actions fo adding product to contribution page                            
 */
class CRM_Contribute_Form_ContributionPage_AddProduct extends CRM_Contribute_Form_ContributionPage {

    
    
    
    

    /**
     * Function to pre  process the form
     *
     * @access public
     * @return None
     */
     function preProcess() 
    {
        parent::preProcess();
      
        $this->_products = CRM_Contribute_PseudoConstant::products($this->_id);
        $this->_pid      = CRM_Utils_Request::retrieve('pid', $this, false, 0);

        if ( $this->_pid  ) {
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->id = $this->_pid;
            $dao->find(true);
            $temp = CRM_Contribute_PseudoConstant::products();
            $this->_products[$dao->product_id] = $temp[$dao->product_id];
        }
        
        //$this->_products = array_merge(array('' => '-- Select Product --') , $this->_products );
    }


    /**
     * This function sets the default values for the form. Note that in edit/view mode
     * the default values are retrieved from the database
     *
     * @access public
     * @return void
     */
    function setDefaultValues()
    {
        $defaults = array();

        if ( $this->_pid ) {
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->id = $this->_pid;
            $dao->find(true);
            $defaults['product_id']    = $dao->product_id;
            $defaults['sort_position'] = $dao->sort_position;
        }
        if( ! $defaults['sort_position']) {
            $pageID    = CRM_Utils_Request::retrieve('id', $this, false, 0);
            require_once 'CRM/Contribute/DAO/Premium.php';
            $dao =& new CRM_Contribute_DAO_Premium();
            $dao->entity_table = 'civicrm_contribution_page';
            $dao->entity_id = $pageID; 
            $dao->find(true);
            $premiumID = $dao->id;
                        
            $sql = 'SELECT max( `sort_position` ) as max_weight FROM `civicrm_premiums_product` WHERE `premiums_id` ='.$premiumID;
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->query( $sql );
            $dao->fetch();
            $defaults['sort_position'] = $dao->max_weight + 1 ;
        }
        return $defaults;
    }

    /**
     * Function to actually build the form
     *
     * @return void
     * @access public
     */
     function buildQuickForm()
    {
       
        
        if ( $this->_action & CRM_CORE_ACTION_DELETE ) {
            $session =& CRM_Core_Session::singleton();
            $url = CRM_Utils_System::url('/civicrm/admin/contribute', 'reset=1&action=update&id='.$this->_id.'&subPage=Premium'); 
            $session->pushUserContext( $url );
            if (CRM_Utils_Request::retrieve('confirmed', $form, '', '', 'GET') ) {
                require_once 'CRM/Contribute/DAO/PremiumsProduct.php';
                $dao =& new CRM_Contribute_DAO_PremiumsProduct();
                $dao->id = $this->_pid;
                $dao->delete();
                CRM_Core_Session::setStatus( ts('Selected Premium Product has been removed from this Contribution Page.') );
                CRM_Utils_System::redirect($url);
            } 
          

            $this->addButtons(array(
                                    array ( 'type'      => 'next',
                                            'name'      => ts('Delete'),
                                            'spacing'   => '&nbsp;&nbsp;&nbsp;&nbsp;',
                                            'isDefault' => true   ),
                                    array ( 'type'      => 'cancel',
                                            'name'      => ts('Cancel') ),
                                    )
                              );
            return;
            
        }
        
        if ( $this->_action & CRM_CORE_ACTION_PREVIEW ) {
            require_once 'CRM/Contribute/BAO/Premium.php';
            CRM_Contribute_BAO_Premium::buildPremiumPreviewBlock( $this, null ,$this->_pid );
            $this->addButtons(array(
                                    array ('type'      => 'next',
                                           'name'      => ts('Done With Preview'),
                                           'isDefault' => true),
                                    )
                              );
            
            return;
        }
        
        $session =& CRM_Core_Session::singleton();
        $url = CRM_Utils_System::url('/civicrm/admin/contribute', 'reset=1&action=update&id='.$this->_id.'&subPage=Premium'); 
        $session->pushUserContext( $url );

        $this->addElement('select', 'product_id', ts('Select the Product') . ' ', $this->_products );
        $this->addRule('product_id', ts('Select the Product') . ' ', 'required' );
        $this->addElement('text','sort_position', ts('Weight'),CRM_Core_DAO::getAttribute('CRM_Contribute_DAO_PremiumsProduct', 'sort_position') );
             
        $this->addRule('sort_position',ts('Please enter integer value for weight') , 'integer');
        $session =& CRM_Core_Session::singleton();
        $single = $session->get('singleForm');
        $session->pushUserContext( CRM_Utils_System::url('civicrm/admin/contribute', 'action=update&reset=1&id=' . $this->_id .'&subPage=Premium') );
      
        if ( $single ) {
            $this->addButtons(array(
                                    array ( 'type'      => 'next',
                                            'name'      => ts('Save'),
                                            'spacing'   => '&nbsp;&nbsp;&nbsp;&nbsp;',
                                            'isDefault' => true   ),
                                    array ( 'type'      => 'cancel',
                                            'name'      => ts('Cancel') ),
                                    )
                              );
        } else {
            parent::buildQuickForm( );
        }
    }

    /**
     * Process the form
     *
     * @return void
     * @access public
     */
     function postProcess()
    {
        // get the submitted form values.
        $params    = $this->controller->exportValues( $this->_name );
        $pageID    = CRM_Utils_Request::retrieve('id', $this, false, 0);
        
        if($this->_action & CRM_CORE_ACTION_PREVIEW) {
            $session =& CRM_Core_Session::singleton();
            $url = CRM_Utils_System::url('/civicrm/admin/contribute', 'reset=1&action=update&id='.$this->_id.'&subPage=Premium');
            $single = $session->get('singleForm');
            CRM_Utils_System::redirect($url);
            return;
        }
        
        if($this->_action & CRM_CORE_ACTION_DELETE) {
            $session =& CRM_Core_Session::singleton();
            $url = CRM_Utils_System::url('/civicrm/admin/contribute', 'reset=1&action=update&id='.$this->_id.'&subPage=Premium');
            require_once 'CRM/Contribute/DAO/PremiumsProduct.php';
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->id = $this->_pid;
            $dao->delete();
            CRM_Core_Session::setStatus( ts('Selected Premium Product has been removed from this Contribution Page.') );
            CRM_Utils_System::redirect($url);
        } else { 
            $session =& CRM_Core_Session::singleton();
            $url = CRM_Utils_System::url('/civicrm/admin/contribute', 'reset=1&action=update&id='.$this->_id.'&subPage=Premium');
            if ( $this->_pid ) {
                $params['id'] =  $this->_pid;
            }
            require_once 'CRM/Contribute/DAO/Premium.php';
            $dao =& new CRM_Contribute_DAO_Premium();
            $dao->entity_table = 'civicrm_contribution_page';
            $dao->entity_id = $pageID; 
            $dao->find(true);
            $premiumID = $dao->id;
            $params['premiums_id'] = $premiumID;
            

            require_once 'CRM/Contribute/DAO/PremiumsProduct.php';
            $dao =& new CRM_Contribute_DAO_PremiumsProduct();
            $dao->copyValues($params);
            $dao->save();
            CRM_Utils_System::redirect($url);
        }
        
    }
    
    /** 
     * Return a descriptive name for the page, used in wizard header 
     * 
     * @return string 
     * @access public 
     */ 
     function getTitle( ) {
        return ts( 'Add Premium to Contribution Page' );
    }
}
?>

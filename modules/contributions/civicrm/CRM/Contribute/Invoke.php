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
 * Given an argument list, invoke the appropriate CRM function
 * Serves as a wrapper between the UserFrameWork and Core CRM
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


class CRM_Contribute_Invoke {

     function admin( &$args ) {
        if ( $args[1] !== 'admin' && $args[2] !== 'contribute' ) {
            return;
        }

        $view = null;

        switch ( CRM_Utils_Array::value( 3, $args, '' ) ) {

        case 'contributionType':
            require_once 'CRM/Contribute/Page/ContributionType.php';
            $view =& new CRM_Contribute_Page_ContributionType(ts('Contribution Types'));
            break;
            
        case 'paymentInstrument':
            require_once 'CRM/Contribute/Page/PaymentInstrument.php';
            $view =& new CRM_Contribute_Page_PaymentInstrument(ts('Payment Instruments'));
            break;
            
        case 'acceptCreditCard':
            require_once 'CRM/Contribute/Page/AcceptCreditCard.php';
            $view =& new CRM_Contribute_Page_AcceptCreditCard(ts('Accept Credit Cards'));
            break;

        case 'managePremiums':
            require_once 'CRM/Contribute/Page/ManagePremiums.php';
            $view =& new CRM_Contribute_Page_ManagePremiums(ts('Manage Premiums'));
            break;
            
        case 'createPPD':
            $session =& CRM_Core_Session::singleton( );
            $session->pushUserContext( CRM_Utils_System::url( 'civicrm/admin', 'reset=1' ) );
            $wrapper =& new CRM_Utils_Wrapper( ); 
            return $wrapper->run( 'CRM_Contribute_Form_CreatePPD', ts( 'Create PPD' ), null );
            break;
            
        default:
            require_once 'CRM/Contribute/Page/ContributionPage.php'; 
            $view =& new CRM_Contribute_Page_ContributionPage(ts('Contribution Page'));  
            break;
        }

        if ( $view ) {
            return $view->run( );
        }

        return CRM_Utils_System::redirect( CRM_Utils_System::url( 'civicrm' ) );
    }

    /*
     * This function contains the actions for contribute arguments  
     *  
     * @param $args array this array contains the arguments of the url  
     *  
     * @static  
     * @access public  
     */  
     function main( &$args ) {  
        if ( $args[1] !== 'contribute' ) {  
            return;  
        }  

        $session =& CRM_Core_Session::singleton( );
        $config  =& CRM_Core_Config::singleton ( );

        if ( $args[2] == 'transact' ) { 
            if ( $config->enableSSL     &&
                 CRM_Core_Invoke::onlySSL( $args ) ) {
                if ( !isset($_SERVER['HTTPS'] ) ) {
                    CRM_Utils_System::redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
                } else {
                    CRM_Utils_System::mapConfigToSSL( );
                }
            }

            require_once 'CRM/Contribute/Controller/Contribution.php'; 
            $controller =& new CRM_Contribute_Controller_Contribution($title, $mode); 
            return $controller->run(); 
        } elseif ($args[2] == 'search') {
            require_once 'CRM/Contribute/Controller/Search.php'; 
            $controller =& new CRM_Contribute_Controller_Search($title, $mode); 
            $url = 'civicrm/contribute/search';
            $session->pushUserContext(CRM_Utils_System::url($url, 'force=1')); 
            $controller->set( 'context', 'search' );
            return $controller->run();
        } elseif ($args[2] == 'import') {
            require_once 'CRM/Contribute/Import/Controller.php';
            $controller =& new CRM_Contribute_Import_Controller(ts('Import Contributions'));
            return $controller->run();
        } else if ( $args[2] == 'add' ) {
            $session =& CRM_Core_Session::singleton( );  
            $session->pushUserContext( CRM_Utils_System::url('civicrm/contribute', 'action=browse&reset=1' ) ); 

            require_once 'CRM/Contribute/Controller/ContributionPage.php'; 
            $controller =& new CRM_Contribute_Controller_ContributionPage( ); 
            return $controller->run( ); 
        } else if ( $args[2] == 'contribution' ) {
            require_once 'CRM/Contribute/Page/Contribution.php';
            $page =& new CRM_Contribute_Page_Contribution( );
            return $page->run( );
        } else {
            require_once 'CRM/Contribute/Page/DashBoard.php';
            $view =& new CRM_Contribute_Page_DashBoard( ts('DashBoard') );
            return $view->run( );
        }
    }

}

?>
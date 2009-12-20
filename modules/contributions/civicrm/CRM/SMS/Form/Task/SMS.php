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


require_once 'CRM/Contact/Form/Task.php';

require_once 'CRM/Utils/Menu.php';
require_once 'CRM/Core/BAO/CustomGroup.php';
require_once 'CRM/Contact/BAO/Contact.php';

/**
 * This class provides the functionality to sms a group of
 * contacts. 
 */
class CRM_SMS_Form_Task_SMS extends CRM_Contact_Form_Task {

    /**
     * Are we operating in "single mode", i.e. sending sms to one
     * specific contact?
     *
     * @var boolean
     */
    var $_single = false;

    /**
     * build all the data structures needed to build the form
     *
     * @return void
     * @access public
     */
    function preProcess( ) {
        $cid = CRM_Utils_Request::retrieve( 'cid', $this, false );

        if ( $cid ) {
            // not sure why this is needed :(
            // also add the cid params to the Menu array
            CRM_Utils_Menu::addParam( 'cid', $cid );
            
            // create menus ..
            $startWeight = CRM_Utils_Menu::getMaxWeight('civicrm/contact/view');
            $startWeight++;
            CRM_Core_BAO_CustomGroup::addMenuTabs(CRM_Contact_BAO_Contact::getContactType($cid), 'civicrm/contact/view/cd', $startWeight);

            $this->_contactIds = array( $cid );
            $this->_single     = true;
            $smsNumbers        = CRM_Contact_BAO_Contact::allPhones( $cid, 'Mobile' );
            $this->_emails     = array( );
            $toName = CRM_Contact_BAO_Contact::displayName( $cid );
            foreach ( $smsNumbers as $number => $item ) {
                $this->_smsNumbers[$number] = '"' . $toName . '" <' . $number . '> ' . $item['locationType'];
                if ( $item['is_primary'] ) {
                    $this->_smsNumbers[$number] .= ' ' . ts('(preferred)');
                }
                $this->_smsNumbers[$number] = htmlspecialchars( $this->_emails[$email] );
            }
        } else {
            parent::preProcess( );
        }
        $this->assign( 'single', $this->_single );
    }
    
    /**
     * Build the form
     *
     * @access public
     * @return void
     */
     function buildQuickForm()
    {
        if ( ! $this->_single ) {
            $toArray = array();
            foreach ( $this->_contactIds as $contactId ) {
                list($toDisplayName, $toSMS) = CRM_Contact_BAO_Contact::getPhoneDetails($contactId, 'Mobile');
                if ( ! empty( $toSMS ) ) {
                    $toArray[] = "\"$toDisplayName\" <$toSMS>";
                }
            }
            $this->assign('to', implode(', ', $toArray));
        } else {
            $to =& $this->add( 'select', 'to', ts('To'), $this->_smsNumbers, true );
            if ( count( $this->_smsNumbers ) <= 1 ) {
                foreach ( $this->_smsNumbers as $number => $dontCare ) {
                    $defaults = array( 'to' => $number );
                    $this->setDefaults( $defaults );
                }
                $to->freeze( );
            }
        }

        $session =& CRM_Core_Session::singleton( );
        $userID  =  $session->get( 'userID' );
        list( $fromDisplayName, $fromSMS ) = CRM_Contact_BAO_Contact::getPhoneDetails( $userID, 'Mobile' );
        if ( ! $fromSMS ) {
            CRM_Utils_System::statusBounce( ts('Your user record does not have a valid SMS number' ));
        }
        $from = '"' . $fromDisplayName . '"' . "<$fromSMS>";
        $this->assign( 'from', $from );
        
        $this->add( 'textarea', 'message', ts('Message'), CRM_Core_DAO::getAttribute( 'CRM_SMS_DAO_History', 'message' ), true );

        if ( $this->_single ) {
            // also fix the user context stack
            $session->replaceUserContext( CRM_Utils_System::url('civicrm/contact/view/activity',
                                                                '&show=1&action=browse&cid=' . $this->_contactIds[0] ) );
            $this->addDefaultButtons( ts('Send SMS'), 'next', 'cancel' );
        } else {
            $this->addDefaultButtons( ts('Send SMS') );
        }
    }

    /**
     * process the form after the input has been submitted and validated
     *
     * @access public
     * @return None
     */
     function postProcess() {
        $smsNumber = null;
        if ( $this->_single ) {
            $smsNumber = $this->controller->exportValue( 'SMS', 'to' );
        }
        $message = $this->controller->exportValue( 'SMS', 'message' );

        require_once 'CRM/SMS/BAO/History.php';
        list( $total, $sent, $notSent ) = CRM_SMS_BAO_History::send( $this->_contactIds, $message, $smsNumber );

        $status = array(
                        '',
                        ts('Total Selected Contact(s): %1', array(1 => $total))
                        );
        if ( $sent ) {
            $status[] = ts('SMS sent to contact(s): %1', array(1 => $sent));
        }
        if ( $notSent ) {
            $status[] = ts('SMS not sent to contact(s): %1', array(1 => $notSent));
        }
        CRM_Core_Session::setStatus( $status );
        
    }//end of function


}

?>

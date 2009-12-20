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


require_once 'CRM/SMS/DAO/History.php';
require_once 'CRM/SMS/Protocol.php';

/**
 * BAO object for crm_email_history table
 */
class CRM_SMS_BAO_History extends CRM_SMS_DAO_History {

    /**
     * send the message to all the contacts and also insert a
     * contact activity in each contacts record
     *
     * @param array  $contactIds   the array of contact ids to send the email
     * @param string $message      the message contents
     * @param string $smsNumber    use this 'number' instead of the default primary sms number
     *
     * @return array             (total, added, notAdded) count of emails sent
     * @access public
     * @static
     */
     function send( &$contactIds, &$message, $smsNumber ) {
        $session =& CRM_Core_Session::singleton( );
        $userID  =  $session->get( 'userID' );
        list( $fromDisplayName, $fromSMSNumber ) = CRM_Contact_BAO_Contact::getPhoneDetails( $userID, 'Mobile' );
        if ( ! $fromSMSNumber ) {
            return array( count($contactIds), 0, count($contactIds) );
        }

        $message = trim( $message );

        // create the meta level record first
        $history             =& new CRM_SMS_DAO_History( );
        $history->message    = $message;
        $history->contact_id = $userID;
        $history->sent_date  = date( 'Ymd' );
        $history->save( );

        $sent = $notSent = 0;
        require_once 'CRM/SMS/Protocol.php';
        foreach ( $contactIds as $contactId ) {
            if ( CRM_SMS_BAO_History::sendMessage( $fromSMSNumber, $contactId, $message, $smsNumber, $history->id ) ) {
                $sent++;
            } else {
                $notSent++;
            }
        }

        return array( count($contactIds), $sent, $notSent );
    }

    /**
     * send the message to a specific contact
     *
     * @param string $from       the name and sms of the sender
     * @param int    $toID       the contact id of the recipient       
     * @param string $message    the message contents
     * @param string $smsNumber  use this 'number' instead of the default primary sms number
     * @param int    $activityID the activity ID that tracks the message
     *
     * @return array             (total, added, notAdded) count of emails sent
     * @access public
     * @static
     */
     function sendMessage( $from, $toID, &$message, $smsNumber, $activityID ) {
        list( $toDisplayName  , $toSMS   ) = CRM_Contact_BAO_Contact::getPhoneDetails( $toID, 'Mobile' );
        if ( $toSMS ) {
            $to = trim( $toSMS );
        }

        // make sure sms number is non-empty
        if ( empty( $to ) ) {
            return false;
        }

        $params = array( );
        $params['From'] = $from;
        $params['To'  ] = $to;
        $params['Body'] = $message;
        $params['id'  ] = substr( md5(uniqid(rand(), true)), 0, 31 );
        $params['Type'] = "SMS_TEXT";

        $aggregator =& CRM_SMS_Protocol::singleton( );
        if ( ! $aggregator->sendMessage( $params ) ) {
            return false;
        }
        
        // we need to insert an activity history record here
        $params = array('entity_table'     => 'civicrm_contact',
                        'entity_id'        => $toID,
                        'activity_type'    => ts('SMS Sent'),
                        'module'           => 'CiviCRM',
                        'callback'         => 'CRM_SMS_BAO_History::details',
                        'activity_id'      => $activityID,
                        'activity_summary' => ts('To: %1; Message: %2', array(1 => "$toDisplayName <$toSMS>", 2 => $message)),
                        'activity_date'    => date('YmdHis')
                        );
        
        if ( is_a( crm_create_activity_history($params), CRM_Core_Error ) ) {
            return false;
        }
        return true;
    }


    /**
     * compose the url to show details of this specific email
     *
     * @param int $id
     */
     function details( $id )
    {
        return CRM_Utils_System::url('civicrm/contact/view/activity', "activity_id=4&details=1&action=view&id=$id");
    }

    /**
     * delete all records for this contact id
     *
     * @param int $id
     */
      function deleteContact($id)
    {
        $dao =& new CRM_SMS_DAO_History();
        $dao->contact_id = $id;
        $dao->delete();
    }
}

?>

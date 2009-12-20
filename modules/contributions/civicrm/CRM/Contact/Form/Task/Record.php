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

/**
 * This class provides the functionality to delete a group of
 * contacts. This class provides functionality for the actual
 * addition of contacts to groups.
 */
class CRM_Contact_Form_Task_Record extends CRM_Contact_Form_Task {

    /** 
     * The id of the logged in user, used when add / edit  
     * 
     * @var int 
     */ 
    var $_userID;

    /** 
     * The display name of the logged in user
     * 
     * @var string
     */ 
    var $_displayName;

    /** 
     * The list of valid activity types
     * 
     * @var array
     */ 
    var $_activityType;

    /**
     * Build the form
     *
     * @access public
     * @return void
     */
    function buildQuickForm( ) {
        $session =& CRM_Core_Session::singleton( ); 
        $this->_userID  =  $session->get( 'userID' ); 
        list( $this->_displayName, $email ) = CRM_Contact_BAO_Contact::getEmailDetails( $this->_userID ); 
        if ( ! $this->_userID || ! $this->_displayName ) { 
            CRM_Utils_System::statusBounce( ts('Your user record does not have a valid user ID' )); 
        }
        $this->assign( 'displayName', $this->_displayName );

        // add select for tag
        $this->_activityType =
            array( ''   => ' - select activity - ' ) + 
            CRM_Core_PseudoConstant::ActivityType( false, null );
        unset( $this->_activityType[3] );
        $this->add('select', 'activity_type_id', ts('Activity Type'),
                   $this->_activityType,
                   true);

        $this->add('text', 'subject', ts('Subject') , CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_Activity', 'subject' ), true ); 
 
        $this->add('date', 'scheduled_date_time', ts('Date and Time'), CRM_Core_SelectValues::date('datetime'), true); 
        $this->addRule('scheduled_date_time', ts('Select a valid date.'), 'qfDate'); 
         
        $this->add('select','duration_hours',ts('Duration'),CRM_Core_SelectValues::getHours()); 
        $this->add('select','duration_minutes', null,CRM_Core_SelectValues::getMinutes()); 
 
        $this->add('text', 'location', ts('Location'), CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_Activity', 'location' ) ); 
         
        $this->add('textarea', 'details', ts('Details'), CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_Activity', 'details' ) ); 
         
        $this->add('select','status',ts('Status'), CRM_Core_SelectValues::activityStatus(), true); 

        $this->addDefaultButtons( ts('Record Activity for Contacts') );
    }

    /**
     * process the form after the input has been submitted and validated
     *
     * @access public
     * @return None
     */
     function postProcess() {
        $params = $this->controller->exportValues( $this->_name );

        $dateTime = CRM_Utils_Date::format($dateTime); 
 
        // store the date with proper format 
        $params['scheduled_date_time']= CRM_Utils_Date::format( $params['scheduled_date_time'] );
 
        // store the contact id and current drupal user id 
        $params['source_contact_id'] = $this->_userID; 
        $params['target_entity_table'] = 'civicrm_contact'; 
        $ids = array( );

        if ( $params['status'] == 'Completed' ) {
            $completedParams = array( 'entity_table'     => 'civicrm_contact', 
                                      'activity_type'    => $this->_activityType[$params['activity_type_id']], 
                                      'module'           => 'CiviCRM', 
                                      'activity_summary' => $params['subject'],
                                      'activity_date'    => $params['scheduled_date_time'],
                                      );
            switch ( $params['activity_type_id'] ) {
            case 1:
                $completedParams['callback'] = 'CRM_Activity_Form_Meeting::showMeetingDetails';
                break;

            case 2:
                $completedParams['callback'] = 'CRM_Activity_Form_Phonecall::showCallDetails';
                break;

            default:
                $completedParams['callback'] = 'CRM_Activity_Form_OtherActivity::showOtherActivityDetails';
                break;
            }

            
        }

            
        list( $total, $added, $notAdded ) = array( count( $this->_contactIds ), 0, 0 );

        require_once 'CRM/Core/BAO/Meeting.php';
        require_once 'CRM/Core/BAO/Phonecall.php';
        require_once 'CRM/Core/BAO/OtherActivity.php';

        foreach ( $this->_contactIds as $contactId ) {
            $params['target_entity_id'] = $contactId; 
            $activity = null;
            switch ( $params['activity_type_id'] ) {
            case 1:
                $activity = CRM_Core_BAO_Meeting::add( $params, $ids );
                break;

            case 2:
                $activity = CRM_Core_BAO_Phonecall::add( $params, $ids );
                break;

            default:
                if ( $params['activity_type_id'] > 3 ) {
                    $activity = CRM_Core_BAO_OtherActivity::add( $params, $ids );
                }
                break;
            }

            if ( $activity ) {
                $added++;
                if ( $activity->status == 'Completed' ) {
                    $completedParams['entity_id'] = $contactId;
                    $completedParams['activity_id'] = $activity->id;
                    if ( is_a( crm_create_activity_history($completedParams), 'CRM_Core_Error' ) ) {
                        $added--;
                    }
                }
            } else {
                $notAdded++;
            }
        }

        $status = array(
                        'Activity: ' . $this->_activityType[$params['activity_type_id']],
                        'Subject: ' . $params['subject'],
                        'Total Selected Contact(s): '  . $total,
                        'Recorded for Contact(s): '  . $added
                        );
        CRM_Core_Session::setStatus( $status );
    }//end of function


}

?>

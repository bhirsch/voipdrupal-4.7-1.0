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


require_once 'CRM/Core/StateMachine.php';
require_once 'CRM/Core/Action.php';
require_once 'CRM/Contact/Task.php';

class CRM_Contact_StateMachine_Search extends CRM_Core_StateMachine {

    /**
     * The task that the wizard is currently processing
     *
     * @var string
     * @protected
     */
    var $_task;

    /**
     * class constructor
     */
    function CRM_Contact_StateMachine_Search( $controller, $action = CRM_CORE_ACTION_NONE ) {
        parent::CRM_Core_StateMachine( $controller, $action );

        $this->_pages = array( );
        if ( $action == CRM_CORE_ACTION_ADVANCED ) {
            $this->_pages[] = 'CRM_Contact_Form_Search_Advanced';
            list( $task, $result ) = $this->taskName( $controller, 'Advanced' );
        } else {
            $this->_pages[] = 'CRM_Contact_Form_Search';
            list( $task, $result ) = $this->taskName( $controller, 'Search' );
        }
        $this->_task    = $task;
        if ( is_array( $task ) ) {
            foreach ( $task as $t ) {
                $this->_pages[] = $t;
            }
        } else {
            $this->_pages[] = $task;
        }

        if ( $result ) {
            $this->_pages[] = 'CRM_Contact_Form_Task_Result';
        }

        $this->addSequentialPages( $this->_pages, $action );
    }

    /**
     * Determine the form name based on the action. This allows us
     * to avoid using  conditional state machine, much more efficient
     * and simpler
     *
     * @param CRM_Core_Controller $controller the controller object
     *
     * @return string the name of the form that will handle the task
     * @access protected
     */
    function taskName( $controller, $formName = 'Search' ) {
        // total hack, check POST vars and then session to determine stuff
        // fix value if print button is pressed
        if ( CRM_Utils_Array::value( '_qf_' . $formName . '_next_print', $_POST ) ) {
            $value = CRM_CONTACT_TASK_PRINT_CONTACTS;
        } else {
            $value = CRM_Utils_Array::value( 'task', $_POST );
        }
        if ( ! isset( $value ) ) {
            $value = $this->_controller->get( 'task' );
        }
        $this->_controller->set( 'task', $value );

        $result = false;
        switch ( $value ) {
        case  CRM_CONTACT_TASK_GROUP_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_AddToGroup';
            $result = true;
            break;

        case  CRM_CONTACT_TASK_REMOVE_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_RemoveFromGroup';
            $result = true;
            break;

        case CRM_CONTACT_TASK_DELETE_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_Delete';
            break;

        case CRM_CONTACT_TASK_SAVE_SEARCH:
            $task   = 'CRM_Contact_Form_Task_SaveSearch';
            $result = true;
            break;

        case CRM_CONTACT_TASK_SAVE_SEARCH_UPDATE:
            $task   = 'CRM_Contact_Form_Task_SaveSearch_Update';
            $result = true;
            break;

        case CRM_CONTACT_TASK_TAG_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_AddToTag';
            $result = true;
            break;

        case CRM_CONTACT_TASK_EMAIL_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_Email';
            $result = true;
            break;
        
        case CRM_CONTACT_TASK_SMS_CONTACTS:
            $task   = 'CRM_SMS_Form_Task_SMS';
            $result = true;
            break;
        
        case CRM_CONTACT_TASK_HOUSEHOLD_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_AddToHousehold';
            $result = true;
            break;

        case CRM_CONTACT_TASK_ORGANIZATION_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_AddToOrganization';
            $result = true;
            break;

        case CRM_CONTACT_TASK_RECORD_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_Record';
            $result = true;
            break;

        case CRM_CONTACT_TASK_MAP_CONTACTS:
            $task   = 'CRM_Contact_Form_Task_Map';
            break;

        case CRM_CONTACT_TASK_EXPORT_CONTACTS:
            $task = array( 'CRM_Contact_Form_Task_Export_Select',
                           'CRM_Contact_Form_Task_Export_Map' );
            break;

        case CRM_CONTACT_TASK_REMOVE_TAGS:
            $task   = 'CRM_Contact_Form_Task_RemoveFromTag';
            $result = true;
            break;

        default: // the print task is the default and catch=all task
            $task = 'CRM_Contact_Form_Task_Print';
            break;

        }

        return array( $task, $result );
    }

    /**
     * return the form name of the task
     *
     * @return string
     * @access public
     */
    function getTaskFormName( ) {
        return CRM_Utils_String::getClassName( $this->_task );
    }

}

?>
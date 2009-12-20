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
 * class to represent the actions that can be performed on a group of contacts
 * used by the search forms
 *
 */
define( 'CRM_CONTACT_TASK_GROUP_CONTACTS',1);
define( 'CRM_CONTACT_TASK_REMOVE_CONTACTS',2);
define( 'CRM_CONTACT_TASK_TAG_CONTACTS',4);
define( 'CRM_CONTACT_TASK_DELETE_CONTACTS',8);
define( 'CRM_CONTACT_TASK_SAVE_SEARCH',16);
define( 'CRM_CONTACT_TASK_SAVE_SEARCH_UPDATE',32);
define( 'CRM_CONTACT_TASK_PRINT_CONTACTS',64);
define( 'CRM_CONTACT_TASK_EMAIL_CONTACTS',128);
define( 'CRM_CONTACT_TASK_HOUSEHOLD_CONTACTS',512);
define( 'CRM_CONTACT_TASK_ORGANIZATION_CONTACTS',1024);
define( 'CRM_CONTACT_TASK_MAP_CONTACTS',2048);
define( 'CRM_CONTACT_TASK_EXPORT_CONTACTS',4096);
define( 'CRM_CONTACT_TASK_RECORD_CONTACTS',8192);
define( 'CRM_CONTACT_TASK_SMS_CONTACTS',16384);
define( 'CRM_CONTACT_TASK_REMOVE_TAGS',32768);
$GLOBALS['_CRM_CONTACT_TASK']['_tasks'] =  null;
$GLOBALS['_CRM_CONTACT_TASK']['_optionalTasks'] =  null;

class CRM_Contact_Task {
    
                     
                    
                       
                    
                       
                
                    
                   
               
           
                    
                 
                 
                   
                    

    /**
     * the task array
     *
     * @var array
     * @static
     */
    

    /**
     * the optional task array
     *
     * @var array
     * @static
     */
    

    /**
     * These tasks are the core set of tasks that the user can perform
     * on a contact / group of contacts
     *
     * @return array the set of tasks for a group of contacts
     * @static
     * @access public
     */
     function &tasks()
    {
        if (!($GLOBALS['_CRM_CONTACT_TASK']['_tasks'])) {
            $GLOBALS['_CRM_CONTACT_TASK']['_tasks'] = array(
                                  1     => ts( 'Add Contacts to a Group'       ),
                                  2     => ts( 'Remove Contacts from a Group'  ),
                                  4     => ts( 'Tag Contacts (assign tags)'    ),
                                  32768 => ts( 'Untag Contacts (remove tags)'  ),  
                                  4096  => ts( 'Export Contacts'               ),
                                  128   => ts( 'Send Email to Contacts'        ),
                                  16384 => ts( 'Send SMS to Contacts'          ),
                                  8     => ts( 'Delete Contacts'               ),
                                  512   => ts( 'Add Contacts to Household'     ),
                                  1024  => ts( 'Add Contacts to Organization'  ),
                                  8192  => ts( 'Record Activity for Contacts'  ),
                                  2048  => ts( 'Map Contacts'                  ),
                                  16    => ts( 'New Smart Group'               ),
                                  );
            $config =& CRM_Core_Config::singleton( );

            if ( ! isset( $config->smtpServer ) ||
                 $config->smtpServer == '' ||
                 $config->smtpServer == 'YOUR SMTP SERVER' ) {
                unset( $GLOBALS['_CRM_CONTACT_TASK']['_tasks'][128] );
            }

            if ( ! in_array( 'CiviSMS', $config->enableComponents ) ) {
                unset( $GLOBALS['_CRM_CONTACT_TASK']['_tasks'][16384] );
            }
        }
        return $GLOBALS['_CRM_CONTACT_TASK']['_tasks'];
    }

    /**
     * show tasks selectively based on the permission level
     * of the user
     *
     * @param int $permission
     *
     * @return array set of tasks that are valid for the user
     * @access public
     */
     function &permissionedTasks( $permission ) {
        if ( $permission == CRM_CORE_PERMISSION_EDIT ) {
            return CRM_Contact_Task::tasks( );
        } else {
            $tasks = array( 
                           4096 => ts( 'Export Contacts'               ),
                           2048 => ts( 'Map Contacts using Google Maps')
                           );
            return $tasks;
        }
    }

    /**
     * These tasks get added based on the context the user is in
     *
     * @return array the set of optional tasks for a group of contacts
     * @static
     * @access public
     */
     function &optionalTasks()
    {
        if (!($GLOBALS['_CRM_CONTACT_TASK']['_optionalTasks'])) {
            $GLOBALS['_CRM_CONTACT_TASK']['_optionalTasks'] = array(
                32 => ts('Update Smart Group')
            );
        }
        return $GLOBALS['_CRM_CONTACT_TASK']['_optionalTasks'];
    }

}

?>

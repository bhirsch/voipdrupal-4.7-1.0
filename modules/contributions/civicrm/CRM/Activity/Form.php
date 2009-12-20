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
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


require_once 'CRM/Core/Form.php';

/**
 * This class generates form components
 * 
 */
class CRM_Activity_Form extends CRM_Core_Form
{
    /**
     * The id of the object being edited / created
     *
     * @var int
     */
    var $_id;

    /**
     * The contact id, used when add / edit 
     *
     * @var int
     */
    var $_contactId;

    /**
     * The id of the logged in user, used when add / edit 
     *
     * @var int
     */
    var $_userId;

    /**
     *  Boolean variable to show followup if it is set to true
     *
     */
    var $_status;

    /**
     *  Boolean variable set for differentiating between log and schedule
     *
     */
    var $_log;

    /**
     * this variable to store parent id for the follow up activity
     *
     */
    var $_pid;

    function preProcess( ) 
    {
        $session =& CRM_Core_Session::singleton( );
        $this->_userId = $session->get( 'userID' );

        $page =& new CRM_Contact_Page_View();
        
        $this->_pid  = $this->get( 'pid' );
        $this->_log  = $this->get( 'log' );
        $this->assign( 'log', $this->_log);
                
        $this->_contactId = $this->get('contactId');
        if ($this->_action != CRM_CORE_ACTION_ADD) {
            $this->_id = $this->get('id');
        }
        $this->_status = CRM_Utils_Request::retrieve( 'status', $this, false );
    }

    /**
     * This function sets the default values for the form. For edit/view mode
     * the default values are retrieved from the database
     * 
     * @access public
     * @return None
     */
    function setDefaultValues( ) 
    {
        $defaults = array( );
        $params   = array( );

        if ( isset( $this->_id ) ) {
            $params = array( 'id' => $this->_id );
            require_once(str_replace('_', DIRECTORY_SEPARATOR, $this->_BAOName) . ".php");
            eval( $this->_BAOName . '::retrieve( $params, $defaults );' );

            $sourceName = CRM_Contact_BAO_Contact::displayName($defaults['source_contact_id']);
            $targetName = CRM_Contact_BAO_Contact::displayName($defaults['target_entity_id']);

            $this->assign('sourceName', $sourceName);
            $this->assign('targetName', $targetName);
        }

        if ($this->_action == CRM_CORE_ACTION_DELETE) {
            $this->assign( 'delName', $defaults['subject'] );
        }
       
        if ($this->_log) { 
            $defaults['status'] = 'Completed';
        }

        // set the default date if we are creating a new meeting/call or 
        // marking one as complete

        if ( $this->_log || ! isset( $this->_id ) ) {
            // rounding of minutes
            $min = (int ) ( date("i") / 15 ) * 15;
            $defaults['scheduled_date_time'] = array( 'Y' => date('Y'),
                                                      'M' => date('m'),
                                                      'd' => date('d'),
                                                      'h' => date('h'),
                                                      'i' => $min,
                                                      'A' => date('A') );
        }
        
        if ($this->_action & ( CRM_CORE_ACTION_VIEW | CRM_CORE_ACTION_BROWSE ) ) {
            $inactiveNeeded = true;
            $viewMode = true;
        } else {
            $viewMode = false;
            $inactiveNeeded = false;
        }

        if( isset($this->_groupTree) ) {
            CRM_Core_BAO_CustomGroup::setDefaults( $this->_groupTree, $defaults, $viewMode, $inactiveNeeded );
        }
        return $defaults;

       
    }

    /**
     * Function to actually build the form
     *
     * @return None
     * @access public
     */
     function buildQuickForm( ) 
    {
        if ($this->_action == CRM_CORE_ACTION_VIEW) { 
            $this->freeze();
        }

        if ($this->_status || ($this->_action == CRM_CORE_ACTION_VIEW)) { 
            if ($this->_status) {
                $this->assign('status', $this->_status);
                $this->assign('pid'   , $this->_id);
                $this->assign('history'   , 1);
            } else {
                $this->assign('history'   , 0);
            }
            $this->addButtons( array(
                                     array ( 'type'      => 'cancel',
                                             'name'      => ts('Done') ),
                                     )
                               );

        } else {
            $this->addButtons( array(
                                     array ( 'type'      => 'next',
                                             'name'      => ts('Save'),
                                             'isDefault' => true   ),
                                     array ( 'type'      => 'cancel',
                                             'name'      => ts('Cancel') ),
                                     )
                               );
        }


        if($this->_action & CRM_CORE_ACTION_DELETE) {
            $this->addButtons(array(
                                    array ('type'      => 'next',
                                           'name'      => ts('Delete'),
                                           'isDefault' => true),
                                    array ('type'      => 'cancel',
                                           'name'      => ts('Cancel')),
                                    )
                              );
        }
    }
}

?>
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


require_once 'CRM/Contact/Page/View.php';

/**
 * Main page for viewing history of activities.
 *
 */

class CRM_Contact_Page_View_Activity extends CRM_Contact_Page_View {

    /**
     * Browse all activities for a particular contact
     *
     * @param boolean $history - true if we want to browse activity history, false otherwise.
     * @return none
     *
     * @access public
     */
    function browse( $history )
    {
        $this->assign( 'totalCountOpenActivity',
                       CRM_Contact_BAO_Contact::getNumOpenActivity( $this->_contactId ) );
        $this->assign( 'totalCountActivity',
                       CRM_Core_BAO_History::getNumHistory( $this->_contactId,
                                                            'Activity' ) );
        require_once 'CRM/Core/Selector/Controller.php';
        if ( $history ) {
  
            $this->assign('history', true);

            // create the selector, controller and run - store results in session
           
            $output   =  CRM_CORE_SELECTOR_CONTROLLER_SESSION;
            require_once 'CRM/History/Selector/Activity.php';
            $selector =& new CRM_History_Selector_Activity( $this->_contactId, $this->_permission );
            $sortID   =  null;
            if ( $this->get( CRM_UTILS_SORT_SORT_ID  ) ) {
                $sortID = CRM_Utils_Sort::sortIDValue( $this->get( CRM_UTILS_SORT_SORT_ID  ),
                                                       $this->get( CRM_UTILS_SORT_SORT_DIRECTION ) );
            }
            $controller =& new CRM_Core_Selector_Controller($selector, $this->get(CRM_UTILS_PAGER_PAGE_ID),
                                                            $sortID, CRM_CORE_ACTION_VIEW, $this, $output);
            $controller->setEmbedded(true);
            $controller->run();
            $controller->moveFromSessionToTemplate( );
        } else {
            $this->assign('history', false);
            
            // create the selector, controller and run - store results in session
            $output = CRM_CORE_SELECTOR_CONTROLLER_SESSION;
            require_once 'CRM/Contact/Selector/Activity.php';
            $selector   =& new CRM_Contact_Selector_Activity($this->_contactId, $this->_permission );
            $sortID     = null;
            if ( $this->get( CRM_UTILS_SORT_SORT_ID  ) ) {
                $sortID = CRM_Utils_Sort::sortIDValue( $this->get( CRM_UTILS_SORT_SORT_ID  ),
                                                       $this->get( CRM_UTILS_SORT_SORT_DIRECTION ) );
            }
            $controller =& new CRM_Core_Selector_Controller($selector, $this->get(CRM_UTILS_PAGER_PAGE_ID),
                                                            $sortID, CRM_CORE_ACTION_VIEW, $this, $output);
            $controller->setEmbedded(true);
            $controller->run();
            $controller->moveFromSessionToTemplate( );
        }
    }

    /**
     * Heart of the viewing process. The runner gets all the meta data for
     * the contact and calls the appropriate type of page to view.
     *
     * @return void
     * @access public
     *
     */
    function preProcess()
    {
        parent::preProcess();

        // we need to retrieve privacy preferences
        // to (un)display the 'Send an Email' link
        $params   = array( );
        $defaults = array( );
        $ids      = array( );
        $params['id'] = $params['contact_id'] = $this->_contactId;
        CRM_Contact_BAO_Contact::retrieve($params, $defaults, $ids);
        CRM_Contact_BAO_Contact::resolveDefaults($defaults);
        $this->assign($defaults);
    }

    /**
     * perform actions and display for activities.
     *
     * @return none
     *
     * @access public
     */
    function run( )
    {
        $this->preProcess( );

        // get selector type ? open or closed activities ?
        $history = CRM_Utils_Request::retrieve('history', $this );

        if ( $this->_action & CRM_CORE_ACTION_DELETE ) {
            $url     = 'civicrm/contact/view/activity';

            $session =& CRM_Core_Session::singleton();
            $session->pushUserContext( CRM_Utils_System::url($url, 'action=browse&history=1&show=1' ) );

            $controller =& new CRM_Core_Controller_Simple('CRM_History_Form_Activity',
                                                          ts('Delete Activity History'),
                                                          $this->_action );
            $controller->set('id', $this->_id);
            $controller->setEmbedded( true );
            $controller->process( );
            $controller->run( );
        }

        $this->browse( $history );
        
        return parent::run( );
    }
}
?>

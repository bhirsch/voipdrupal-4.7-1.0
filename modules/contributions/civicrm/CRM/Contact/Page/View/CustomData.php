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
 * Page for displaying custom data
 *
 */
class CRM_Contact_Page_View_CustomData extends CRM_Contact_Page_View {
    /**
     * the id of the object being viewed (note/relationship etc)
     *
     * @int
     * @access protected
     */
    var $_groupId;

    /**
     * class constructor
     *
     * @return CRM_Contact_Page_View_CustomData
     */
     function CRM_Contact_Page_View_CustomData( )
    {
        parent::CRM_Contact_Page_View();
    }


    /**
     * add a few specific things to view contact
     *
     * @return void 
     * @access public 
     * 
     */ 
    function preProcess( ) 
    { 
        parent::preProcess( );

        $this->_groupId = CRM_Utils_Request::retrieve( 'gid', $this, true ); 
        $this->assign( 'groupId', $this->_groupId );
    }

    /**
     * Run the page.
     *
     * This method is called after the page is created. It checks for the  
     * type of action and executes that action. 
     *
     * @access public
     * @param object $page - the view page which created this one 
     * @return none
     * @static
     *
     */
    function run( )
    {
        $this->preProcess( );

        // get permission detail view or edit
        $permUser = CRM_Core_Permission::getPermission();
        
        $editCustomData = ( CRM_CORE_PERMISSION_VIEW == $permUser ) ? 0 : 1;

        $this->assign('editCustomData', $editCustomData);

        $controller =& new CRM_Core_Controller_Simple('CRM_Contact_Form_CustomData', ts('Custom Data'), $this->_action);
        $controller->setEmbedded(true);

        // set the userContext stack
        $doneURL = 'civicrm/contact/view/cd';
        $session =& CRM_Core_Session::singleton();
        $session->pushUserContext( CRM_Utils_System::url( $doneURL, 'action=browse&gid=' . $this->_groupId ), false );

        $controller->set('tableId'   , $this->_contactId );
        $controller->set('groupId'   , $this->_groupId);
        $controller->set('entityType', CRM_Contact_BAO_Contact::getContactType( $this->_contactId ) );
        $controller->process();
        $controller->run();

        return parent::run();
    }
}
?>

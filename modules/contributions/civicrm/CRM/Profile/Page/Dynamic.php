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
 | at http://www.openngo.org/faqs/licensing.html                      |
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


require_once 'CRM/Core/Page.php';

/**
 * Create a page for displaying CiviCRM Profile Fields.
 *
 * Heart of this class is the run method which checks
 * for action type and then displays the appropriate
 * page.
 *
 */
class CRM_Profile_Page_Dynamic extends CRM_Core_Page {
    
    /**
     * The contact id of the person we are viewing
     *
     * @var int
     * @access protected
     */
    var $_id;

    /**
     * the profile group are are interested in
     * 
     * @var int 
     * @access protected 
     */ 
    var $_gid;

    /**
     * class constructor
     *
     * @param int $id  the contact id
     * @param int $gid the group id
     *
     * @return void
     * @access public
     */
    function CRM_Profile_Page_Dynamic( $id, $gid ) {
        $this->_id    = $id;
        $this->_gid   = $gid;
    }

    /**
     * Get the action links for this page.
     *
     * @return array $_actionLinks
     *
     */
    function &actionLinks()
    {
        return null;
    }
    
    /**
     * Run the page.
     *
     * This method is called after the page is created. It checks for the  
     * type of action and executes that action. 
     *
     * @return void
     * @access public
     *
     */
    function run()
    {
        $template =& CRM_Core_Smarty::singleton( ); 
        if ( $this->_id && $this->_gid ) {
            require_once 'CRM/Core/BAO/UFGroup.php';

            $values = array( );
            $fields = CRM_Core_BAO_UFGroup::getFields( $this->_gid, false, CRM_CORE_ACTION_VIEW );

            // make sure we dont expose all fields based on permission
            $admin = false; 
            $session  =& CRM_Core_Session::singleton( ); 
            if ( CRM_Utils_System::checkPermission( 'administer users' ) || 
                 $this->_id == $session->get( 'userID' ) ) { 
                $admin = true; 
            }

            if ( ! $admin ) {
                foreach ( $fields as $name => $field ) {
                    // make sure that there is enough permission to expose this field 
                    if ( $field['visibility'] == 'User and User Admin Only' ) {
                        unset( $fields[$name] );
                    }
                }
            }
            CRM_Core_BAO_UFGroup::getValues( $this->_id, $fields, $values );

            $template->assign_by_ref( 'row', $values );
        }

        return trim( $template->fetch( 'CRM/Profile/Page/Dynamic.tpl' ) ); 
    }
}

?>

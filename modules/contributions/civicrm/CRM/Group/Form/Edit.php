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


require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/BAO/CustomGroup.php';
/**
 * This class is to build the form for adding Group
 */
class CRM_Group_Form_Edit extends CRM_Core_Form {

    /**
     * the group id, used when editing a group
     *
     * @var int
     */
    var $_id;
 
    /**
     * The title of the group being deleted
     *
     * @var string
     */
    var $_title;

    /**
     * Store the tree of custom data and fields
     *
     * @var array
     */
    var $_groupTree;

    /**
     * set up variables to build the form
     *
     * @return void
     * @acess protected
     */
    function preProcess( ) {
        $this->_id    = $this->get( 'id' );

        if ($this->_action == CRM_CORE_ACTION_DELETE) {    
            if ( isset($this->_id) ) {
                $params   = array( 'id' => $this->_id );
                CRM_Contact_BAO_Group::retrieve( $params, $defaults );
                
                $this->_title = $defaults['title'];
                $this->assign( 'name' , $this->_title );
                $this->assign( 'count', CRM_Contact_BAO_Group::memberCount( $this->_id ) );
                CRM_Utils_System::setTitle( ts('Confirm Group Delete') );
            }
        } else {
            if ( isset($this->_id) ) {
                $params   = array( 'id' => $this->_id );
                CRM_Contact_BAO_Group::retrieve( $params, $defaults );
                $groupValues = array( 'id'              => $this->_id,
                                      'title'           => $defaults['title'],
                                      'saved_search_id' => $defaults['saved_search_id']);
                $this->assign_by_ref( 'group', $groupValues );
                CRM_Utils_System::setTitle( ts('Group Settings: %1', array( 1 => $defaults['title'])));
            }
        }
    }
    
    /*
     * This function sets the default values for the form. LocationType that in edit/view mode
     * the default values are retrieved from the database
     *
     * @access public
     * @return None
     */
    function setDefaultValues( ) {
        $defaults = array( );
        $params   = array( );

        if ( isset( $this->_id ) ) {
            $params = array( 'id' => $this->_id );
            CRM_Contact_BAO_Group::retrieve( $params, $defaults );
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
     function buildQuickForm( ) {
        
        if ($this->_action == CRM_CORE_ACTION_DELETE) {
            $this->addButtons( array(
                                     array ( 'type'      => 'next',
                                             'name'      => ts('Delete Group'),
                                             'isDefault' => true   ),
                                     array ( 'type'       => 'cancel',
                                             'name'      => ts('Cancel') ),
                                     )
                               );
            
        } else {

            $this->applyFilter('__ALL__', 'trim');
            $this->add('text', 'title'       , ts('Name:') . ' ' ,
                       CRM_Core_DAO::getAttribute( 'CRM_Contact_DAO_Group', 'title' ) );
            $this->addRule( 'title', ts('Group name is required.'), 'required' );
            $this->addRule( 'title', ts('Name already exists in Database.'),
                            'objectExists', array( 'CRM_Contact_DAO_Group', $this->_id, 'title' ) );
            
            $this->add('text', 'description', ts('Description:') . ' ', 
                       CRM_Core_DAO::getAttribute( 'CRM_Contact_DAO_Group', 'description' ) );
            $this->add( 'select', 'visibility', ts('Visibility'        ), CRM_Core_SelectValues::ufVisibility( ), true ); 
            
            $this->addButtons( array(
                                     array ( 'type'      => 'next',
                                             'name'      => ( $this->_action == CRM_CORE_ACTION_ADD ) ? ts('Continue') : ts('Save'),
                                             'isDefault' => true   ),
                                     array ( 'type'       => 'cancel',
                                             'name'      => ts('Cancel') ),
                                     )
                               );

            $this->_groupTree =& CRM_Core_BAO_CustomGroup::getTree('Group',$this->_id,0);
            CRM_Core_BAO_CustomGroup::buildQuickForm( $this, $this->_groupTree, 'showBlocks1', 'hideBlocks1' );
        }
    }
    /**
     * Process the form when submitted
     *
     * @return void
     * @access public
     */
     function postProcess( ) {
        
        if ($this->_action & CRM_CORE_ACTION_DELETE ) {
            CRM_Contact_BAO_Group::discard( $this->_id );
            CRM_Core_Session::setStatus( ts('The Group "%1" has been deleted.', array(1 => $this->_title)) );        
        } else {
            // store the submitted values in an array
            $params = $this->exportValues();

            $params['domain_id'] = CRM_Core_Config::domainID( );
            $params['is_active'] = 1;
            
            if ($this->_action & CRM_CORE_ACTION_UPDATE ) {
                $params['id'] = $this->_id;
            }
            
            $group =& CRM_Contact_BAO_Group::create( $params );

            
            // do the updates/inserts
            CRM_Core_BAO_CustomGroup::postProcess( $this->_groupTree, $params );            
            CRM_Core_BAO_CustomGroup::updateCustomData($this->_groupTree,'Group',$group->id); 

            CRM_Core_Session::setStatus( ts('The Group "%1" has been saved.', array(1 => $group->title)) );        
            
            /*
             * Add context to the session, in case we are adding members to the group
             */
            if ($this->_action & CRM_CORE_ACTION_ADD ) {
                $this->set( 'context', 'amtg' );
                $this->set( 'amtgID' , $group->id );
                
                $session =& CRM_Core_Session::singleton( );
                $session->pushUserContext( CRM_Utils_System::url( 'civicrm/group/search', 'reset=1&force=1&context=smog&gid=' . $group->id ) );
            }
        }
    }

}

?>

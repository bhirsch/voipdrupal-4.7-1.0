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
 * Main page for viewing contact.
 *
 */
class CRM_Contact_Page_View_Basic extends CRM_Contact_Page_View {

    /** 
     * Heart of the viewing process. The runner gets all the meta data for 
     * the contact and calls the appropriate type of page to view. 
     * 
     * @return void 
     * @access public 
     * 
     */ 
    function preProcess( ) {
        parent::preProcess( );
        //Custom Groups Inline
        $entityType = CRM_Contact_BAO_Contact::getContactType($this->_contactId);
        $groupTree =& CRM_Core_BAO_CustomGroup::getTree($entityType, $this->_contactId);
        CRM_Core_BAO_CustomGroup::buildViewHTML( $this, $groupTree );
    }

    /**
     * Heart of the viewing process. The runner gets all the meta data for
     * the contact and calls the appropriate type of page to view.
     *
     * @return void
     * @access public
     *
     */
    function run( )
    {
        $this->preProcess( );

        if ( $this->_action & CRM_CORE_ACTION_UPDATE ) {
            $this->edit( );
        } else {
            $this->view( );
        }

        return parent::run( );
    }

    /**
     * Edit name and address of a contact
     *
     * @return void
     * @access public
     */
    function edit( ) {
        // set the userContext stack
        $session =& CRM_Core_Session::singleton();
        $url = CRM_Utils_System::url('civicrm/contact/view/basic', 'action=browse&cid=' . $this->_contactId );
        $session->pushUserContext( $url );
        
        $controller =& new CRM_Core_Controller_Simple( 'CRM_Contact_Form_Edit', ts('Contact Page'), CRM_CORE_ACTION_UPDATE );
        $controller->setEmbedded( true );
        $controller->process( );
        return $controller->run( );
    }

    /**
     * View summary details of a contact
     *
     * @return void
     * @access public
     */
    function view( ) {
        $params   = array( );
        $defaults = array( );
        $ids      = array( );

        $params['id'] = $params['contact_id'] = $this->_contactId;
        $contact = CRM_Contact_BAO_Contact::retrieve( $params, $defaults, $ids );

        CRM_Contact_BAO_Contact::resolveDefaults( $defaults );

        if (CRM_Utils_Array::value( 'gender_id',  $defaults )) {
            $gender =CRM_Core_PseudoConstant::gender();
            $defaults['gender_display'] =  $gender[CRM_Utils_Array::value( 'gender_id',  $defaults )];
        }

        // get the list of all the categories
        $tag =& CRM_Core_PseudoConstant::tag();
        // get categories for the contact id
        require_once 'CRM/Core/BAO/EntityTag.php';
        $entityTag =& CRM_Core_BAO_EntityTag::getTag('civicrm_contact', $this->_contactId);

        if ( $entityTag ) {
            $categories = array( );
            foreach ( $entityTag as $key ) {
                $categories[] = $tag[$key];
            }
            $defaults['contactTag'] = implode( ', ', $categories );
        }
        
        $defaults['privacy_values'] = CRM_Core_SelectValues::privacy();
        $this->assign( $defaults );
        $this->setShowHide( $defaults );        

        // get the contributions, new style of doing stuff
        // do the below only if the person has access to contributions
        $config =& CRM_Core_Config::singleton( );
        if ( CRM_Utils_System::accessCiviContribute( ) ) {
            $this->assign( 'accessContribution', true );
            $controller =& new CRM_Core_Controller_Simple( 'CRM_Contribute_Form_Search', ts('Contributions'), $this->_action );  
            $controller->setEmbedded( true );                           
            $controller->reset( );  
            $controller->set( 'limit', 3 ); 
            $controller->set( 'force', 1 );
            $controller->set( 'cid'  , $this->_contactId );
            $controller->set( 'context', 'basic' ); 
            $controller->process( );  
            $controller->run( );
        } else {
            $this->assign( 'accessContribution', false );
        }

        //add link to CMS user
        if ( $uid = CRM_Core_BAO_UFMatch::getUFId( $this->_contactId ) ) {
            if ($config->userFramework == 'Drupal') {
                $url = CRM_Utils_System::url( 'user/' . $uid );
            } else {
                //$url = CRM_Utils_System::url( 'option=com_users&task=editA&hidemainmenu=1&id=' . $uid );
                $url = $config->userFrameworkBaseURL . 'index2.php?option=com_users&task=editA&hidemainmenu=1&id=' . $uid;
            }
            $this->assign( 'url', $url );
        }
    }


    /**
     * Show hide blocks based on default values.
     *
     * @param array (reference) $defaults
     * @return void
     * @access public
     */
    function setShowHide( &$defaults ) {
        require_once 'CRM/Core/ShowHideBlocks.php';

        $showHide =& new CRM_Core_ShowHideBlocks( array( 'commPrefs'           => 1,
                                                         'notes[show]'          => 1,
                                                         'relationships[show]'  => 1,
                                                         'groups[show]'         => 1,
                                                         'openActivities[show]' => 1,
                                                         'activityHx[show]'     => 1 ),
                                                  array( 'notes'                => 1,
                                                         'commPrefs[show]'      => 1,
                                                         'relationships'        => 1,
                                                         'groups'               => 1,
                                                         'openActivities'       => 1,
                                                         'activityHx'           => 1 ) );

        $config =& CRM_Core_Config::singleton( ); 
        if ( CRM_Utils_System::accessCiviContribute( ) ) {
            $showHide->addShow( 'contributions[show]' ); 
            $showHide->addHide( 'contributions' ); 
        }

        if ( $defaults['contact_type'] == 'Individual' ) {
            // is there any demographics data?
            if ( CRM_Utils_Array::value( 'gender_id'     , $defaults ) ||
                 CRM_Utils_Array::value( 'is_deceased', $defaults ) ||
                 CRM_Utils_Array::value( 'birth_date' , $defaults ) ) {
                $showHide->addShow( 'demographics' );
                $showHide->addHide( 'demographics[show]' );
            } else {
                $showHide->addShow( 'demographics[show]' );
                $showHide->addHide( 'demographics' );
            }
        }

        if ( array_key_exists( 'location', $defaults ) ) {
            $numLocations = count( $defaults['location'] );
            if ( $numLocations > 0 ) {
                $showHide->addShow( 'location[1]' );
                $showHide->addHide( 'location[1][show]' );
            }
            for ( $i = 1; $i < $numLocations; $i++ ) {
                $locationIndex = $i + 1;
                $showHide->addShow( "location[$locationIndex][show]" );
                $showHide->addHide( "location[$locationIndex]" );
            }
        }
        
        $showHide->addToTemplate( );
    }

}

?>

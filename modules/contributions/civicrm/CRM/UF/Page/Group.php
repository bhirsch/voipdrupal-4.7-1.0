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

$GLOBALS['_CRM_UF_PAGE_GROUP']['_actionLinks'] =  null;

require_once 'CRM/Core/Page.php';

/**
 * Create a page for displaying UF Groups.
 *
 * Heart of this class is the run method which checks
 * for action type and then displays the appropriate
 * page.
 *
 */
class CRM_UF_Page_Group extends CRM_Core_Page 
{
    
    /**
     * The action links that we need to display for the browse screen
     *
     * @var array
     */
    

    /**
     * Get the action links for this page.
     *
     * @param
     * @return array $_actionLinks
     *
     */
    function &actionLinks()
    {
        // check if variable _actionsLinks is populated
        if ( ! $GLOBALS['_CRM_UF_PAGE_GROUP']['_actionLinks'] ) {
            // helper variable for nicer formatting
            $disableExtra = ts('Are you sure you want to disable this CiviCRM Profile group?');
            $GLOBALS['_CRM_UF_PAGE_GROUP']['_actionLinks'] = array(
                                        CRM_CORE_ACTION_BROWSE  => array(
                                                                          'name'  => ts('View and Edit Fields'),
                                                                          'url'   => 'civicrm/admin/uf/group/field',
                                                                          'qs'    => 'reset=1&action=browse&gid=%%id%%',
                                                                          'title' => ts('List CiviCRM Profile Group Fields'),
                                                                          ),
                                        CRM_CORE_ACTION_UPDATE  => array(
                                                                          'name'  => ts('Settings'),
                                                                          'url'   => 'civicrm/admin/uf/group',
                                                                          'qs'    => 'action=update&id=%%id%%',
                                                                          'title' => ts('Edit CiviCRM Profile Group') 
                                                                          ),
                                        CRM_CORE_ACTION_PREVIEW => array(
                                                                          'name'  => ts('Preview'),
                                                                          'url'   => 'civicrm/admin/uf/group',
                                                                          'qs'    => 'action=preview&id=%%id%%&field=0',
                                                                          'title' => ts('Edit CiviCRM Profile Group') 
                                                                          ),
                                        CRM_CORE_ACTION_DISABLE => array(
                                                                          'name'  => ts('Disable'),
                                                                          'url'   => 'civicrm/admin/uf/group',
                                                                          'qs'    => 'action=disable&id=%%id%%',
                                                                          'title' => ts('Disable CiviCRM Profile Group'),
                                                                          'extra' => 'onclick = "return confirm(\'' . $disableExtra . '\');"',
                                                                          ),
                                        CRM_CORE_ACTION_ENABLE  => array(
                                                                          'name'  => ts('Enable'),
                                                                          'url'   => 'civicrm/admin/uf/group',
                                                                          'qs'    => 'action=enable&id=%%id%%',
                                                                          'title' => ts('Enable CiviCRM Profile Group'),
                                                                          ),
                                        CRM_CORE_ACTION_DELETE  => array(
                                                                          'name'  => ts('Delete'),
                                                                          'url'   => 'civicrm/admin/uf/group',
                                                                          'qs'    => 'action=delete&id=%%id%%',
                                                                          'title' => ts('Delete CiviCRM Profile Group'),
                                                                          ),
                                        CRM_CORE_ACTION_PROFILE  => array(
                                                                          'name'  => ts('Standalone Form'),
                                                                          'url'   => 'civicrm/admin/uf/group',
                                                                          'qs'    => 'action=profile&gid=%%id%%',
                                                                          'title' => ts('Standalone Form for Profile Group'),
                                                                          ),

                                        );
        }
        return $GLOBALS['_CRM_UF_PAGE_GROUP']['_actionLinks'];
    }

    /**
     * Run the page.
     *
     * This method is called after the page is created. It checks for the  
     * type of action and executes that action.
     * Finally it calls the parent's run method.
     *
     * @param
     * @return void
     * @access public
     */
    function run()
    {
        // get the requested action
        $action = CRM_Utils_Request::retrieve('action', $this, false, 'browse'); // default to 'browse'
        
        // assign vars to templates
        $this->assign('action', $action);
        $id = CRM_Utils_Request::retrieve('id', $this, false, 0);
        
        // what action to take ?
        if ($action & (CRM_CORE_ACTION_UPDATE | CRM_CORE_ACTION_ADD | CRM_CORE_ACTION_DELETE)) {
            $this->edit($id, $action) ;
        } else {
            // if action is enable or disable to the needful.
            if ($action & CRM_CORE_ACTION_DISABLE) {
                CRM_Core_BAO_UFGroup::setIsActive($id, 0);
            } else if ($action & CRM_CORE_ACTION_ENABLE) {
                CRM_Core_BAO_UFGroup::setIsActive($id, 1);
            } else if ( $action & CRM_CORE_ACTION_PROFILE ) { 
                $this->profile( ); 
            } else if ( $action & CRM_CORE_ACTION_PREVIEW ) { 
                $this->preview( $id ); 
            } 

            // finally browse the uf groups
            $this->browse();
        }
        // parent run 
        parent::run();
    }
    
    /**
     * This function is for profile mode (standalone html form ) for uf group
     *
     * @return void
     * @access public
     */
    function profile( ) 
    {
        $gid = CRM_Utils_Request::retrieve('gid', $this, false, 0, 'GET');

        $controller =& new CRM_Core_Controller_Simple( 'CRM_Profile_Form_Edit', ts('Create'), CRM_CORE_ACTION_ADD ); 
        $controller->reset( );
        $controller->process( ); 
        $controller->set('gid', $gid);
        $controller->setEmbedded( true ); 
        $controller->run( ); 
        $template =& CRM_Core_Smarty::singleton( ); 
        $template->assign( 'tplFile', 'CRM/Profile/Form/Edit.tpl' );
        $profile  =  trim( $template->fetch( 'CRM/form.tpl' ) ); 
        // not sure how to circumvent our own navigation system to generate the right form url
        $profile = str_replace( 'civicrm/admin/uf/group', 'civicrm/profile/edit&amp;gid='.$gid.'&amp;reset=1', $profile );
        $this->assign( 'profile', htmlentities( $profile ) );
        //get the title of uf group
        if ($gid) {
            $title = CRM_Core_BAO_UFGroup::getTitle($gid);
        } else {
            $title = 'Profile Form';
        }
        
        $this->assign( 'title', $title);
        $this->assign( 'action' , CRM_CORE_ACTION_PROFILE );

        $this->assign( 'isForm' , 0 );
    }

    /**
     * edit uf group
     *
     * @param int $id uf group id
     * @param string $action the action to be invoked
     * @return void
     * @access public
     */
    function edit($id, $action)
    {
        // create a simple controller for editing uf data
        $controller =& new CRM_Core_Controller_Simple('CRM_UF_Form_Group', ts('CiviCRM Profile Group'), $action);

        // set the userContext stack
        $session =& CRM_Core_Session::singleton();
        $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/uf/group/', 'action=browse'));
        $controller->set('id', $id);
        $controller->setEmbedded(true);
        $controller->process();
        $controller->run();
    }


    /**
     * Browse all uf data groups.
     *
     * @param
     * @return void
     * @access public
     * @static
     */
    function browse($action=null)
    {
        
        $ufGroup     = array( );
        $allUFGroups = array( );
        require_once 'CRM/Core/BAO/UFGroup.php';
        $allUFGroups = CRM_Core_BAO_UFGroup::getModuleUFGroup( );
        if (empty($allUFGroups)) {
            return;
        }
        
        foreach ($allUFGroups as $id => $value) {
            $ufGroup[$id] = array();
            $ufGroup[$id]['id'       ] = $id;
            $ufGroup[$id]['title'    ] = $value['title'];
            $ufGroup[$id]['weight'   ] = $value['weight'];
            $ufGroup[$id]['is_active'] = $value['is_active'];

            // form all action links
            $action = array_sum(array_keys($this->actionLinks()));
            
            // update enable/disable links depending on uf_group properties.
            if ($value['is_active']) {
                $action -= CRM_CORE_ACTION_ENABLE;
            } else {
                $action -= CRM_CORE_ACTION_DISABLE;
            }
            
            $ufGroup[$id]['action'] = CRM_Core_Action::formLink(CRM_UF_Page_Group::actionLinks(), $action, 
                                                                 array('id' => $id));
            //get the "Used For" from uf_join
            $ufGroup[$id]['module'] = implode( ', ', CRM_Core_BAO_UFGroup::getUFJoinRecord( $id, true ));
        }
        $this->assign('rows', $ufGroup);
    }


    /**
     * this function is for preview mode for uf group
     *
     * @param int $id uf group id
     * @return void
     * @access public
     */
    function preview( $id ) 
    {
      $controller =& new CRM_Core_Controller_Simple('CRM_UF_Form_Preview', ts('CiviCRM Profile Group Preview'),null);   
      $session =& CRM_Core_Session::singleton();
      $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/uf/group/', 'action=browse'));
      $controller->set('id', $id);
      $controller->setEmbedded(true);
      $controller->process();
      $controller->run();
    }
}
?>
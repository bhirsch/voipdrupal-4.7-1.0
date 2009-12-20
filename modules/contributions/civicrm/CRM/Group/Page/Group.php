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

$GLOBALS['_CRM_GROUP_PAGE_GROUP']['_links'] =  null;
$GLOBALS['_CRM_GROUP_PAGE_GROUP']['_savedSearchLinks'] =  null;

require_once 'CRM/Core/Page/Basic.php';

class CRM_Group_Page_Group extends CRM_Core_Page_Basic 
{
    /**
     * The action links that we need to display for the browse screen
     *
     * @var array
     */
    
    
    /**
     * The action links that we need to display for saved search items
     *
     * @var array
     */
    
    
    function getBAOName( ) 
    {
        return 'CRM_Contact_BAO_Group';
    }

    /**
     * Function to define action links
     *
     * @return array self::$_links array of action links
     * @access public
     */
    function &links()
    {
        $disableExtra = ts('Are you sure you want to disable this Group?');
        
        if (!($GLOBALS['_CRM_GROUP_PAGE_GROUP']['_links'])) {
            $GLOBALS['_CRM_GROUP_PAGE_GROUP']['_links'] = array(
                                  CRM_CORE_ACTION_VIEW => array(
                                                                 'name'  => ts('Members'),
                                                                 'url'   => 'civicrm/group/search',
                                                                 'qs'    => 'reset=1&force=1&context=smog&gid=%%id%%',
                                                                 'title' => ts('Group Members')
                                                                 ),
                                  CRM_CORE_ACTION_UPDATE => array(
                                                                   'name'  => ts('Settings'),
                                                                   'url'   => 'civicrm/group',
                                                                   'qs'    => 'reset=1&action=update&id=%%id%%',
                                                                   'title' => ts('Edit Group')
                                                                   ),
                                  CRM_CORE_ACTION_DISABLE => array( 
                                                                    'name'  => ts('Disable'),
                                                                    'url'   => 'civicrm/group',
                                                                    'qs'    => 'reset=1&action=disable&id=%%id%%',
                                                                    'extra' => 'onclick = "return confirm(\''. $disableExtra . '\');"',
                                                                    'title' => ts('Disable Group') 
                                                                    ),
                                  CRM_CORE_ACTION_ENABLE  => array( 
                                                                    'name'  => ts('Enable'),
                                                                    'url'   => 'civicrm/group',
                                                                    'qs'    => 'reset=1&action=enable&id=%%id%%',
                                                                    'title' => ts( 'Enable Group' ) 
                                                                    ),
                                  CRM_CORE_ACTION_DELETE => array(
                                                                   'name'  => ts('Delete'),
                                                                   'url'   => 'civicrm/group',
                                                                   'qs'    => 'reset=1&action=delete&id=%%id%%',
                                                                   'title' => ts('Delete Group')
                                                                   )
                                  
                                  );
        }
        return $GLOBALS['_CRM_GROUP_PAGE_GROUP']['_links'];
    }
    
    /**
     * Function to define action links for saved search
     *
     * @return array self::$_savedSearchLinks array of action links
     * @access public
     */
    function &savedSearchLinks( ) 
    {
        if ( ! $GLOBALS['_CRM_GROUP_PAGE_GROUP']['_savedSearchLinks'] ) {
            $deleteExtra = ts('Do you really want to remove this Smart Group?');
            $GLOBALS['_CRM_GROUP_PAGE_GROUP']['_savedSearchLinks'] =
                array(
                      CRM_CORE_ACTION_VIEW   => array(
                                                       'name'  => ts('Show Group Members'),
                                                       'url'   => 'civicrm/contact/search/advanced',
                                                       'qs'    => 'reset=1&force=1&ssID=%%ssid%%',
                                                       'title' => ts('Search')
                                                       ),
                      CRM_CORE_ACTION_UPDATE => array(
                                                       'name'  => ts('Edit'),
                                                       'url'   => 'civicrm/group',
                                                       'qs'    => 'reset=1&action=update&id=%%id%%',
                                                       'title' => ts('Edit Group')
                                                       ),
                      CRM_CORE_ACTION_DELETE => array(
                                                       'name'  => ts('Delete'),
                                                       'url'   => 'civicrm/contact/search/saved',
                                                       'qs'    => 'action=delete&id=%%ssid%%',
                                                       'extra' => 'onclick="return confirm(\'' . $deleteExtra . '\');"',
                                                       ),
                      );
        }
        return $GLOBALS['_CRM_GROUP_PAGE_GROUP']['_savedSearchLinks'];
    }

    /**
     * return class name of edit form
     *
     * @return string
     * @access public
     */
    function editForm( ) 
    {
        return 'CRM_Group_Form_Edit';
    }
    
    /**
     * return name of edit form
     *
     * @return string
     * @access public
     */
    function editName( ) 
    {
        return 'Edit Group';
    }

    /**
     * return class name of delete form
     *
     * @return string
     * @access public
     */
    function deleteForm( ) 
    {
        return 'CRM_Group_Form_Delete';
    }
    
    /**
     * return name of delete form
     *
     * @return string
     * @access public
     */
    function deleteName( ) 
    {
        return 'Delete Group';
    }
    
    /**
     * return user context uri to return to
     *
     * @return string
     * @access public
     */
    function userContext( $mode = null ) 
    {
        return 'civicrm/group';
    }
    
    /**
     * return user context uri params
     *
     * @return string
     * @access public
     */
    function userContextParams( $mode = null ) 
    {
        return 'reset=1&action=browse';
    }

    /**
     * make sure that the user has permission to access this group
     *
     * @param int $id   the id of the object
     * @param int $name the name or title of the object
     *
     * @return string   the permission that the user has (or null)
     * @access public
     */
    function checkPermission( $id, $title ) 
    {
        return CRM_Contact_BAO_Group::checkPermission( $id, $title );
    }
    
    /**
     * We need to do slightly different things for groups vs saved search groups, hence we
     * reimplement browse from Page_Basic
     * @param int $action
     *
     * @return void
     * @access public
     */
    function browse($action = null) 
    {
        $config =& CRM_Core_Config::singleton( );
        $values =  array( );
        
        $object =& new CRM_Contact_BAO_Group( );
        $object->domain_id = $config->domainID( );
        $object->orderBy ( 'title asc' );
        $object->find();
        
        $groupPermission = CRM_Utils_System::checkPermission( 'edit groups' ) ? CRM_CORE_PERMISSION_EDIT : CRM_CORE_PERMISSION_VIEW;
        $this->assign( 'groupPermission', $groupPermission );
        
        while ($object->fetch()) {
            $permission = $this->checkPermission( $object->id, $object->title );
            if ( $permission ) {
                $values[$object->id] = array( );
                CRM_Core_DAO::storeValues( $object, $values[$object->id]);
                if ( $object->saved_search_id ) {
                    $values[$object->id]['title'] = $values[$object->id]['title'] . ' (' . ts('Smart Group') . ')';
                    $links =& $this->links( );
                } else {
                    $links =& $this->links( );
                }
                if ( $action == null ) {
                    $action = array_sum(array_keys($links));
                }
                $action = $action & CRM_Core_Action::mask( $groupPermission );
                $newAction = $action;
                if ( array_key_exists( 'is_active', $object ) ) {
                    if ( $object->is_active ) {
                        $newAction -= CRM_CORE_ACTION_ENABLE;
                    } else {
                        $newAction -= CRM_CORE_ACTION_VIEW;
                        $newAction -= CRM_CORE_ACTION_DISABLE;
                    }
                }
                
                // make sure we only allow those actions that the user is permissioned for
                $newAction = $newAction & CRM_Core_Action::mask( $permission );
                
                $values[$object->id]['visibility'] = CRM_Contact_DAO_Group::tsEnum('visibility', $values[$object->id]['visibility']);
                $values[$object->id]['action'] = CRM_Core_Action::formLink( $links,
                                                                            $newAction,
                                                                            array( 'id'   => $object->id,
                                                                                   'ssid' => $object->saved_search_id ) );
            }
        }
        
        $this->assign( 'rows', $values );
    }           
    
}

?>

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

$GLOBALS['_CRM_CONTACT_PAGE_SAVEDSEARCH']['_links'] =  null;

require_once 'CRM/Core/Page.php';
require_once 'CRM/Contact/DAO/SavedSearch.php';

/**
 * Main page for viewing all Saved searches.
 *
 */
class CRM_Contact_Page_SavedSearch extends CRM_Core_Page {

    /**
     * The action links that we need to display for the browse screen
     *
     * @var array
     * @static
     */
    


    /**
     * delete a saved search.
     *
     * @param int $id - id of saved search
     * @return void
     *
     */
    function delete($id)
    {
        // first delete the group associated with this saved search
        $group =& new CRM_Contact_DAO_Group( );
        $group->saved_search_id =  $id;
        if ( $group->find( true ) ) {
            CRM_Contact_BAO_Group::discard( $group->id );
        }
        
        $savedSearch =& new CRM_Contact_DAO_SavedSearch();
        $savedSearch->id = $id;
        $savedSearch->is_active = 0;
        $savedSearch->save();
        return;
    }



    /**
     * Browse all saved searches.
     *
     * @return content of the parents run method
     *
     */
    function browse()
    {
        $rows = array();

        $savedSearch =& new CRM_Contact_DAO_SavedSearch();
        $savedSearch->is_active = 1;
        $savedSearch->selectAdd();
        $savedSearch->selectAdd('id, form_values');
        $savedSearch->find();
        $properties = array('id', 'name', 'description');
        while ($savedSearch->fetch()) {
            // get name and description from group object
            $group =& new CRM_Contact_DAO_Group( );
            $group->saved_search_id =  $savedSearch->id;
            if ( $group->find( true ) ) {
                $permission = CRM_Group_Page_Group::checkPermission( $group->id, $group->title );
                if ( $permission ) {
                    $row = array();
                    
                    $row['name']        = $group->title;
                    $row['description'] = $group->description;

                    $row['id']           =  $savedSearch->id;
                    $formValues          =  unserialize($savedSearch->form_values);
                    $query               =& new CRM_Contact_BAO_Query( $formValues );
                    $row['query_detail'] =  $query->qill( );

                    $action = array_sum( array_keys( CRM_Contact_Page_SavedSearch::links() ) );
                    $action = $action & CRM_Core_Action::mask( $permission );
                    $row['action']       = CRM_Core_Action::formLink( CRM_Contact_Page_SavedSearch::links(), $action, array( 'id' => $row['id'] ) );
                    
                    $rows[] = $row;
                }
            }
        }

        $this->assign('rows', $rows);
        return parent::run();
    }


    /**
     * run this page (figure out the action needed and perform it).
     *
     * @return void
     */
    function run() {
        $action = CRM_Utils_Request::retrieve( 'action', $this, false, 'browse' );

        $this->assign( 'action', $action );

        if ( $action & CRM_CORE_ACTION_DELETE ) {
            $id  = CRM_Utils_Request::retrieve( 'id', $this, true );
            $this->delete($id );
        } 
        $this->browse( );
    }


    /**
     * Get action Links
     *
     * @return array (reference) of action links
     * @static
     */
     function &links()
    {

        if (!($GLOBALS['_CRM_CONTACT_PAGE_SAVEDSEARCH']['_links'])) {

            $deleteExtra = ts('Do you really want to remove this Smart Group?');

            $GLOBALS['_CRM_CONTACT_PAGE_SAVEDSEARCH']['_links'] = array(
                                  CRM_CORE_ACTION_VIEW   => array(
                                                                   'name'  => ts('Search'),
                                                                   'url'   => 'civicrm/contact/search/advanced',
                                                                   'qs'    => 'reset=1&force=1&ssID=%%id%%',
                                                                   'title' => ts('Search')
                                                                  ),
                                  CRM_CORE_ACTION_DELETE => array(
                                                                   'name'  => ts('Delete'),
                                                                   'url'   => 'civicrm/contact/search/saved',
                                                                   'qs'    => 'action=delete&id=%%id%%',
                                                                   'extra' => 'onclick="return confirm(\'' . $deleteExtra . '\');"',
                                                                  ),
                                 );
        }
        return $GLOBALS['_CRM_CONTACT_PAGE_SAVEDSEARCH']['_links'];
    }

}

?>

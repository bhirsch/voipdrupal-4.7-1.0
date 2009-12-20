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
 *
 */
$GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewAdminUser'] =  false;
$GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editAdminUser'] =  false;
$GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermission'] =  false;
$GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermission'] =  false;
$GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] = null;
$GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] = null;

class CRM_Core_Permission_Drupal {
    /**
     * is this user someone with access for the entire system
     *
     * @var boolean
     */
    
    

    /**
     * am in in view permission or edit permission?
     * @var boolean
     */
    
    

    /**
     * the current set of permissioned groups for the user
     *
     * @var array
     */
    
    

    /**
     * Get all groups from database, filtered by permissions
     * for this user
     *
     * @access public
     * @static
     *
     * @return array - array reference of all groups.
     *
     */
      function &group( ) {
        if ( ! isset( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] ) ) {
            $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] = $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] = array( );

            $groups =& CRM_Core_PseudoConstant::allGroup( );

            if ( CRM_Utils_System::checkPermission( 'edit all contacts' ) ) {
                // this is the most powerful permission, so we return
                // immediately rather than dilute it further
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editAdminUser']          = $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewAdminUser']  = true;
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermission']         = $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermission'] = true;
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] = $groups;
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] = $groups;
                return $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'];
            } else if ( CRM_Utils_System::checkPermission( 'view all contacts' ) ) {
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewAdminUser']          = true;
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermission']         = true;
                $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] = $groups;
            }

            foreach ( $groups as $id => $title ) {
                if ( CRM_Utils_System::checkPermission( CRM_CORE_PERMISSION_EDIT_GROUPS . $title ) ) {
                    $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'][$id] = $title;
                    $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'][$id] = $title;
                    $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermission']      = true;
                } else if ( CRM_Utils_System::checkPermission( CRM_CORE_PERMISSION_VIEW_GROUPS . $title ) ) {
                    $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'][$id] = $title;
                    $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermission']      = true;
                } 
            }
        }

        return $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'];
    }

    /**
     * Get group clause for this user
     *
     * @param int $type the type of permission needed
     * @param  array $tables (reference ) add the tables that are needed for the select clause
     * @param  array $whereTables (reference ) add the tables that are needed for the where clause
     *
     * @return string the group where clause for this user
     * @access public
     */
      function groupClause( $type, &$tables, &$whereTables ) {
        if (! isset( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] ) ) {
            CRM_Core_Permission_Drupal::group( );
        }

        if ( $type == CRM_CORE_PERMISSION_EDIT ) {
            if ( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editAdminUser'] ) {
                $clause = ' ( 1 ) ';
            } else if ( empty( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] ) ) {
                $clause = ' ( 0 ) ';
            } else {
                $clauses = array( );
                $groups = implode( ', ', $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] );
                $clauses[] = ' ( civicrm_group_contact.group_id IN ( ' . implode( ', ', array_keys( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] ) ) .
                    " ) AND civicrm_group_contact.status = 'Added' ) ";
                $tables['civicrm_group_contact'] = 1;
                $whereTables['civicrm_group_contact'] = 1;
                
                // foreach group that is potentially a saved search, add the saved search clause
                foreach ( array_keys( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermissionedGroups'] ) as $id ) {
                    $group     =& new CRM_Contact_DAO_Group( );
                    $group->id = $id;
                    if ( $group->find( true ) && $group->saved_search_id ) {
                        require_once 'CRM/Contact/BAO/SavedSearch.php';
                        $clauses[] = CRM_Contact_BAO_SavedSearch::whereClause( $group->saved_search_id, $tables, $whereTables );
                    }
                }
                $clause = ' ( ' . implode( ' OR ', $clauses ) . ' ) ';
            }
        } else {
            if ( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewAdminUser'] ) {
                $clause = ' ( 1 ) ';
            } else if ( empty( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] ) ) {
                $clause = ' ( 0 ) ';
            } else {
                $clauses = array( );
                $groups = implode( ', ', $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] );
                $clauses[] = ' ( civicrm_group_contact.group_id IN (' . implode( ', ', array_keys( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] ) ) .
                    " ) AND civicrm_group_contact.status = 'Added' ) ";
                $tables['civicrm_group_contact'] = 1;
                $whereTables['civicrm_group_contact'] = 1;

                // foreach group that is potentially a saved search, add the saved search clause
                foreach ( array_keys( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermissionedGroups'] ) as $id ) {
                    $group     =& new CRM_Contact_DAO_Group( );
                    $group->id = $id;
                    if ( $group->find( true ) && $group->saved_search_id ) {
                        require_once 'CRM/Contact/BAO/SavedSearch.php';
                        $whereTables = array( );
                        $clauses[] = CRM_Contact_BAO_SavedSearch::whereClause( $group->saved_search_id, $tables, $whereTables );
                    }
                }

                $clause = ' ( ' . implode( ' OR ', $clauses ) . ' ) ';
            }
        }
        return $clause;
    }

    /**
     * get the current permission of this user
     *
     * @return string the permission of the user (edit or view or null)
     */
      function getPermission( ) {
        CRM_Core_Permission_Drupal::group( );

        if ( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_editPermission'] ) {
            return CRM_CORE_PERMISSION_EDIT;
        } else if ( $GLOBALS['_CRM_CORE_PERMISSION_DRUPAL']['_viewPermission'] ) {
            return CRM_CORE_PERMISSION_VIEW;
        }
        return null;
    }
    
    /**
     * Get the permissioned where clause for the user
     *
     * @param int $type the type of permission needed
     * @param  array $tables (reference ) add the tables that are needed for the select clause
     * @param  array $whereTables (reference ) add the tables that are needed for the where clause
     *
     * @return string the group where clause for this user
     * @access public
     */
      function whereClause( $type, &$tables, &$whereTables ) {
        CRM_Core_Permission_Drupal::group( );

        return CRM_Core_Permission_Drupal::groupClause( $type, $tables, $whereTables );
    }


}

?>

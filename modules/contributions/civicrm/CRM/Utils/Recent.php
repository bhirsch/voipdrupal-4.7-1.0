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
define( 'CRM_UTILS_RECENT_MAX_ITEMS',5);
define( 'CRM_UTILS_RECENT_STORE_NAME','CRM_Utils_Recent');
$GLOBALS['_CRM_UTILS_RECENT']['_recent'] =  null;

class CRM_Utils_Recent {
    
    /**
     * max number of items in queue
     *
     * @int
     */
    
           
          

    /**
     * The list of recently viewed items
     *
     * @var array
     * @static
     */
    

    /**
     * initialize this class and set the static variables
     *
     * @return void
     * @access public
     * @static
     */
     function initialize( ) {
        if ( ! $GLOBALS['_CRM_UTILS_RECENT']['_recent'] ) {
            $session =& CRM_Core_Session::singleton( );
            $GLOBALS['_CRM_UTILS_RECENT']['_recent'] = $session->get( CRM_UTILS_RECENT_STORE_NAME);
            if ( ! $GLOBALS['_CRM_UTILS_RECENT']['_recent'] ) {
                $GLOBALS['_CRM_UTILS_RECENT']['_recent'] = array( );
            }
        }
    }

    /**
     * return the recently viewed array
     *
     * @return array the recently viewed array
     * @access public
     * @static
     */
     function &get( ) {
        CRM_Utils_Recent::initialize( );
        return $GLOBALS['_CRM_UTILS_RECENT']['_recent'];
    }

    /**
     * add an item to the recent stack
     *
     * @param string $title  the title to display
     * @param string $url    the link for the above title
     * @param string $icon   a link to a graphical image
     * @param string $id     contact id
     *
     * @return void
     * @access public
     * @static
     */
     function add( $title, $url, $icon, $id ) {
        CRM_Utils_Recent::initialize( );

        $session =& CRM_Core_Session::singleton( );

        // make sure item is not already present in list
        for ( $i = 0; $i < count( $GLOBALS['_CRM_UTILS_RECENT']['_recent'] ); $i++ ) {
            if ( $GLOBALS['_CRM_UTILS_RECENT']['_recent'][$i]['url' ] == $url ) {
                // delete item from array
                array_splice( $GLOBALS['_CRM_UTILS_RECENT']['_recent'], $i, 1 );
                break;
            }
        }
        
        array_unshift( $GLOBALS['_CRM_UTILS_RECENT']['_recent'],
                       array( 'title' => $title, 
                              'url'   => $url,
                              'icon'  => $icon,
                              'id'  => $id ) );
        if ( count( $GLOBALS['_CRM_UTILS_RECENT']['_recent'] ) > CRM_UTILS_RECENT_MAX_ITEMS) {
            array_pop( $GLOBALS['_CRM_UTILS_RECENT']['_recent'] );
        }

        $session->set( CRM_UTILS_RECENT_STORE_NAME, $GLOBALS['_CRM_UTILS_RECENT']['_recent'] );
    }

    /**
     * delete an item from the recent stack
     *
     * @param string $id  contact id that had to be removed
     *
     * @return void
     * @access public
     * @static
     */
     function del( $id ) {
        CRM_Utils_Recent::initialize( );

        $tempRecent = $GLOBALS['_CRM_UTILS_RECENT']['_recent'];
        
        $GLOBALS['_CRM_UTILS_RECENT']['_recent'] = '';
        
        // make sure item is not already present in list
        for ( $i = 0; $i < count( $tempRecent ); $i++ ) {
            if ( $tempRecent[$i]['id' ] != $id ) {
                $GLOBALS['_CRM_UTILS_RECENT']['_recent'][] = $tempRecent[$i];
            }
        }
        
        $session =& CRM_Core_Session::singleton( );
        $session->set( CRM_UTILS_RECENT_STORE_NAME, $GLOBALS['_CRM_UTILS_RECENT']['_recent'] );
    }

}

?>

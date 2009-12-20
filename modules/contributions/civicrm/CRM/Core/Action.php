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
 * The core concept of the system is an action performed on an object. Typically this will be a "data model" object 
 * as specified in the API specs. We attempt to keep the number and type of actions consistent 
 * and similar across all objects (thus providing both reuse and standards)
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_CORE_ACTION_NONE',0);
define( 'CRM_CORE_ACTION_ADD',1);
define( 'CRM_CORE_ACTION_UPDATE',2);
define( 'CRM_CORE_ACTION_VIEW',4);
define( 'CRM_CORE_ACTION_DELETE',8);
define( 'CRM_CORE_ACTION_BROWSE',16);
define( 'CRM_CORE_ACTION_ENABLE',32);
define( 'CRM_CORE_ACTION_DISABLE',64);
define( 'CRM_CORE_ACTION_EXPORT',128);
define( 'CRM_CORE_ACTION_BASIC',256);
define( 'CRM_CORE_ACTION_ADVANCED',512);
define( 'CRM_CORE_ACTION_PREVIEW',1024);
define( 'CRM_CORE_ACTION_FOLLOWUP',2048);
define( 'CRM_CORE_ACTION_MAP',4096);
define( 'CRM_CORE_ACTION_PROFILE',8192);
define( 'CRM_CORE_ACTION_MAX_ACTION',16383);
$GLOBALS['_CRM_CORE_ACTION']['_names'] =  array(
                           'add'           => CRM_CORE_ACTION_ADD,
                           'update'        => CRM_CORE_ACTION_UPDATE,
                           'view'          => CRM_CORE_ACTION_VIEW  ,
                           'delete'        => CRM_CORE_ACTION_DELETE,
                           'browse'        => CRM_CORE_ACTION_BROWSE,
                           'enable'        => CRM_CORE_ACTION_ENABLE,
                           'disable'       => CRM_CORE_ACTION_DISABLE,
                           'export'        => CRM_CORE_ACTION_EXPORT,
                           'preview'       => CRM_CORE_ACTION_PREVIEW,
                           'map'           => CRM_CORE_ACTION_MAP,
                           'profile'       => CRM_CORE_ACTION_PROFILE,
                           );
$GLOBALS['_CRM_CORE_ACTION']['_description'] = null;

require_once 'CRM/Utils/Array.php';

class CRM_Core_Action {

    /**
     * Different possible actions are defined here. Keep in sync with the
     * constant from CRM_Core_Form for various modes.
     *
     * @var const
     *
     * @access public
     */
    
                        
                         
                      
                        
                      
                     
                     
                    
                    
                     
                  
                  
                 
                      
                  
                 
  
    /**
     * map the action names to the relevant constant. We perform
     * bit manipulation operations so we can perform multiple
     * actions on the same object if needed
     *
     * @var array  _names  tupe of variable name to action constant
     *
     * @access private
     * @static
     *
     */
    

    /**
     * the flipped version of the names array, initialized when used
     * 
     * @var array
     * @static
     */
    

    /**
     *
     * called by the request object to translate a string into a mask
     *
     * @param string $action the action to be resolved
     *
     * @return int the action mask corresponding to the input string
     * @access public
     * @static
     *
     */
     function resolve( $str ) {
        $action = 0;
        if ( $str ) {
            $items = explode( '|', $str );
            $action = CRM_Core_Action::map( $items );
        }
        return $action;
    }

    /**
     * Given a string or an array of strings, determine the bitmask
     * for this set of actions
     *
     * @param mixed either a single string or an array of strings
     *
     * @return int the action mask corresponding to the input args
     * @access public
     * @static
     *
     */
     function map( $item ) {
        $mask = 0;

        if ( is_array( $item ) ) {
            foreach ( $item as $it ) {
                $mask |= CRM_Core_Action::mapItem( $it );
            }
            return $mask;
        } else {
            return CRM_Core_Action::mapItem( $item );
        }
    }

    /**
     * Given a string determine the bitmask for this specific string
     *
     * @param string the input action to process
     *
     * @return int the action mask corresponding to the input string
     * @access public
     * @static
     *
     */
     function mapItem( $item ) {
        $mask = CRM_Utils_Array::value( trim( $item ), $GLOBALS['_CRM_CORE_ACTION']['_names'] );
        return $mask ? $mask : 0;
    }

    /**
     *
     * Given an action mask, find the corresponding description
     *
     * @param int the action mask
     *
     * @return string the corresponding action description
     * @access public
     * @static
     *
     */
     function description( $mask ) {
        if ( ! isset( $GLOBALS['_CRM_CORE_ACTION']['_description'] ) ) {
            $GLOBALS['_CRM_CORE_ACTION']['_description'] = array_flip( $GLOBALS['_CRM_CORE_ACTION']['_names'] );
        }
        
        return CRM_Utils_Array::value( $mask, $GLOBALS['_CRM_CORE_ACTION']['_description'], 'NO DESCRIPTION SET' );
    }

    /**
     * given a set of links and a mask, return the html action string for
     * the links associated with the mask
     *
     * @param array $links  the set of link items
     * @param int   $mask   the mask to be used. a null mask means all items
     * @param array $values the array of values for parameter substitution in the link items
     *
     * @return string       the html string
     * @access public
     * @static
     */
     function formLink( &$links, $mask, $values ) {
        $url = array( );
        foreach ( $links as $m => $link ) {
            if ( ! $mask || ( $mask & $m ) ) {
                $extra = CRM_Utils_Array::value( 'extra', $link, '' );
                $url[] = sprintf('<a href="%s" ' . $extra . '>%s</a>',
                                 CRM_Utils_System::url( $link['url'],
                                                        CRM_Core_Action::replace( $link['qs'], $values ) ),
                                 $link['name'] );
            }
        }
        $result = '';
        CRM_Utils_String::append( $result, '&nbsp;|&nbsp;', $url );
        return $result;
    }

    /**
     * given a string and an array of values, substitute the real values
     * in the placeholder in the str in the CiviCRM format
     *
     * @param string $str    the string to be replaced
     * @param array  $values the array of values for parameter substitution in the str
     *
     * @return string        the substituted string
     * @access public
     * @static
     */
     function &replace( &$str, &$values ) {
        foreach ( $values as $n => $v ) {
            $str = str_replace( "%%$n%%", $v, $str );
        }
        return $str;
    }

    /**
     * get the mask for a permission (view, edit or null)
     *
     * @param string the permission
     *
     * @return int   the mask for the above permission
     * @static
     * @access public
     */
     function mask( $permission ) {
        if ( $permission == CRM_CORE_PERMISSION_VIEW ) {
            return CRM_CORE_ACTION_VIEW| CRM_CORE_ACTION_EXPORT| CRM_CORE_ACTION_BASIC| CRM_CORE_ACTION_ADVANCED| CRM_CORE_ACTION_BROWSE| CRM_CORE_ACTION_MAP;
        } else if ( $permission == CRM_CORE_PERMISSION_EDIT ) {
            return CRM_CORE_ACTION_MAX_ACTION;  // make sure we make this 2^(n+1) -1 if we add more actions;
        } else {
            return null;
        }
    }

}

?>
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
 * A simple base class for objects that need to implement the selector api
 * interface. This class provides common functionality with regard to actions
 * and display names
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


class CRM_Core_Selector_Base {
    /**
     * the sort order which is computed from the columnHeaders
     *
     * @var array
     */
    var $_order;

    /**
     * The permission mask for this selector
     *
     * @var string
     */
    var $_permission = null;

    /**
     * This function gets the attribute for the action that
     * it matches.
     *
     * @param string  match      the action to match against
     * @param string  attribute  the attribute to return ( name, link, title )
     *
     * @return string            the attribute that matches the action if any
     *
     * @access public
     *
     */
    function getActionAttribute( $match, $attribute = 'name' ) {
        $links =& $this->links();

        // does not work for php4 .. pls revert when done with php4
        //foreach ( $link as $action => &$item ) {
        foreach ( $link as $action => $item ) {
            if ( $match & $action ) {
                return $item[$attribute];
            }
        }
        return null;
    }

    /**
     * This is a static virtual function returning reference on links array. Each 
     * inherited class must redefine this function
     *
     * links is an array of associative arrays. Each element of the array
     * has at least 3 fields
     *
     * name    : the name of the link
     * url     : the URI to be used for this link
     * qs      : the parameters to the above url along with any dynamic substitutions
     * title   : A more descriptive name, typically used in breadcrumbs / navigation
     */
     function &links() {
        return null;
    }

    /**
     * compose the template file name from the class name
     *
     * @param string $action the action being performed
     *
     * @return string template file name
     * @access public
     */
    function getTemplateFileName($action = null)
    {
        return (str_replace('_', DIRECTORY_SEPARATOR, CRM_Utils_System::getClassName($this)) . ".tpl");
    }

    /**
     * getter for the sorting direction for the fields which will be displayed on the form.
     *
     * @param string action the action being performed
     *
     * @return array the elements that can be sorted along with their properties
     * @access public
     */
    function &getSortOrder( $action ) {
        $columnHeaders =& $this->getColumnHeaders( null );

        if ( ! isset( $this->_order ) ) {
            $this->_order = array( );
            $start  = 2;
            $firstElementNotFound = true;
            if ( ! empty( $columnHeaders ) ) {
                foreach ($columnHeaders as $k => $header) {
                    $header =& $columnHeaders[$k];
                    if (array_key_exists( 'sort', $header)) {
                        if ( $firstElementNotFound && $header['direction'] != CRM_UTILS_SORT_DONTCARE ) {
                            $this->_order[1] =& $header;
                            $firstElementNotFound = false;
                        } else {
                            $this->_order[$start++] =& $header;
                        }
                    }
                    unset($header);
                }
            }
            if ( $firstElementNotFound ) {
                // CRM_Core_Error::fatal( "Could not find a valid sort directional element" );
            }
        }
        return $this->_order;
    }

    /**
     * setter for permission
     *
     * @var string
     * @access public
     */
     function setPermission( $permission ) {
        $this->_permission = $permission;
    }

    /**
     * get the display text in plain language for the search 
     * to display on the results page
     *
     * @return string
     * @access public
     */
     function getQill( ) {
        return null;
    }

}

?>
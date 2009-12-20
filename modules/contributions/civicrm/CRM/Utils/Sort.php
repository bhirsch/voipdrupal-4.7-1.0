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
 * Base class to provide generic sort functionality. Note that some ideas
 * have been borrowed from the drupal tablesort.inc code. Also note that
 * since the Pager and Sort class are similar, do match the function names
 * if introducing additional functionality
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


define( 'CRM_UTILS_SORT_ASCENDING',1);
define( 'CRM_UTILS_SORT_DESCENDING',2);
define( 'CRM_UTILS_SORT_DONTCARE',4);
define( 'CRM_UTILS_SORT_SORT_ID','crmSID');
define( 'CRM_UTILS_SORT_SORT_DIRECTION','crmSortDirection');
define( 'CRM_UTILS_SORT_SORT_ORDER','crmSortOrder');

class CRM_Utils_Sort {

    /**
     * constants to determine what direction each variable
     * is to be sorted
     *
     * @var int
     */
    
           
          
            

        /**
         * the name for the sort GET/POST param
         *
         * @var string
         */
                 
          
              

    /**
     * name of the sort function. Used to isolate session variables
     * @var string
     */
    var $_name;

    /**
     * array of variables that influence the query
     *
     * @var array
     */
    var $_vars;

    /**
     * the newly formulated base url to be used as links
     * for various table elements
     *
     * @var string
     */
    var $_link;

    /**
     * what's the name of the sort variable in a REQUEST
     *
     * @var string
     */
    var $_urlVar;

    /**
     * What variable are we currently sorting on
     *
     * @var string
     */
    var $_currentSortID;

    /**
     * What direction are we sorting on
     *
     * @var string
     */
    var $_currentSortDirection;


    /**
     * The output generated for the current form
     *
     * @var array
     */
    var $_response;

    /**
     * The constructor takes an assoc array
     * key names of variable (which should be the same as the column name)
     * value: ascending or descending
     *
     * @param mixed  $vars             - assoc array as described above
     * @param string $defaultSortOrder - order to sort 
     *
     * @return void
     * @access public
     */
    function CRM_Utils_Sort( &$vars, $defaultSortOrder = null ) {
        $this->_vars      = array( );
        $this->_response  = array();

        foreach ( $vars as $weight => $value ) {
            $this->_vars[$weight] = array(
                                          'name'      => $value['sort'],
                                          'direction' => $value['direction'],
                                          'title'     => $value['name'],
                                          );
        }
    
        $this->_currentSortID        = 1;
        $this->_currentSortDirection = $this->_vars[$this->_currentSortID]['direction'];
        $this->_urlVar               = CRM_UTILS_SORT_SORT_ID;
        $this->_link                 = CRM_Utils_System::makeUrl( $this->_urlVar );

        $this->initialize( $defaultSortOrder );
    }

    /**
     * Function returns the string for the order by clause
     *
     * @return string the order by clause
     * @access public
     */
    function orderBy( ) {
        if ( ! CRM_Utils_Array::value( $this->_currentSortID, $this->_vars ) ) {
            return '';
        }

        if ( $this->_vars[$this->_currentSortID]['direction'] == CRM_UTILS_SORT_ASCENDING|| 
             $this->_vars[$this->_currentSortID]['direction'] == CRM_UTILS_SORT_DONTCARE) {
            return $this->_vars[$this->_currentSortID]['name'] . ' asc';
        } else {
            return $this->_vars[$this->_currentSortID]['name'] . ' desc';
        }
    }

    /**
     * create the sortID string to be used in the GET param
     *
     * @param int $index the field index
     * @param int $dir   the direction of the sort
     *
     * @return string  the string to append to the url
     * @static
     * @access public
     */
     function sortIDValue( $index, $dir ) {
        return ( $dir == CRM_UTILS_SORT_DESCENDING) ? $index . '_d' : $index . '_u';
    }

    /**
     * init the sort ID values in the object 
     *
     * @param string $defaultSortOrder the sort order to use by default
     *
     * @return returns null if $url- (sort url) is not found 
     * @access public
     */
    function initSortID( $defaultSortOrder ) {
        $url = CRM_Utils_Array::value( CRM_UTILS_SORT_SORT_ID, $_GET, $defaultSortOrder );

        if ( empty( $url ) ) {
            return;
        }

        list( $current, $direction ) = explode( '_', $url );
        
        // if current is wierd and does not exist in the vars array, skip
        if ( ! array_key_exists( $current, $this->_vars ) ) {
            return;
        }

        if ( $direction == 'u' ) {
            $direction = CRM_UTILS_SORT_ASCENDING;
        } else if  ( $direction == 'd' ) {
            $direction = CRM_UTILS_SORT_DESCENDING;
        } else {
            $direction = CRM_UTILS_SORT_DONTCARE;
        }

        $this->_currentSortID               = $current;
        $this->_currentSortDirection        = $direction;
        $this->_vars[$current]['direction'] = $direction;
    }

    /**
     * init the object
     *
     * @param string $defaultSortOrder the sort order to use by default
     *
     * @return void
     * @access public
     */
    function initialize( $defaultSortOrder ) {
        $this->initSortID( $defaultSortOrder );

        $this->_response = array( );

        $current = $this->_currentSortID;
        foreach ( $this->_vars as $index => $item ) {
            $name = $item['name'];
            $this->_response[$name] = array();

            $newDirection = ( $item['direction'] == CRM_UTILS_SORT_ASCENDING) ? CRM_UTILS_SORT_DESCENDING: CRM_UTILS_SORT_ASCENDING;

            if ( $current == $index ) {
                if ( $item['direction'] == CRM_UTILS_SORT_ASCENDING) {
                    $class = 'sort-ascending';
                } else {
                    $class = 'sort-descending';
                }
            } else {
                $class     = 'sort-none';
            }

            $this->_response[$name]['link'] = '<a href="' . $this->_link . $this->sortIDValue( $index, $newDirection ) . '" class="' . $class . '">' . $item['title'] . '</a>';
        }
    }

    /**
     * getter for currentSortID
     *
     * @return int returns of the current sort id
     * @acccess public
     */
    function getCurrentSortID( ) {
        return $this->_currentSortID;
    }

    /**
     * getter for currentSortDirection
     *
     * @return int returns of the current sort direction
     * @acccess public
     */
    function getCurrentSortDirection( ) {
        return $this->_currentSortDirection;
    }
}

?>
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
 * This class is a generic class to be used when we want to display
 * a list of rows along with a set of associated actions
 *
 * Centralizing this code enables us to write a generic lister and enables
 * us to automate the export process. To use this class, the object has to
 * implement the Selector/Api.interface.php class
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_CORE_SELECTOR_CONTROLLER_SESSION',1);
define( 'CRM_CORE_SELECTOR_CONTROLLER_TEMPLATE',2);
define( 'CRM_CORE_SELECTOR_CONTROLLER_TRANSFER',4);
define( 'CRM_CORE_SELECTOR_CONTROLLER_EXPORT',8);
define( 'CRM_CORE_SELECTOR_CONTROLLER_SCREEN',16);
$GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template'] = null;
$GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_properties'] =  array( 'columnHeaders', 'rows', 'rowsEmpty' );

require_once 'CRM/Utils/Pager.php';
require_once 'CRM/Utils/PagerAToZ.php';
require_once 'CRM/Utils/Sort.php';
require_once 'CRM/Core/Report/Excel.php';

class CRM_Core_Selector_Controller {

    /**
     * constants to determine if we should store
     * the output in the session or template
     * @var int
     */
    
            
           
            // move the values from the session to the template
             
             

    /**
     * a CRM Object that implements CRM_Core_Selector_API
     * @var object
     */
    var $_object;
    
    /*
     * the CRM_Utils_Sort object
     * @var object
     */
    var $_sort;

    /*
     * the current column to sort on
     * @var int
     */
    var $_sortID;

    /*
     * the sortOrder array
     * @var array
     */
    var $_sortOrder;

    /*
     * the CRM_Utils_Pager object
     * @var object
     */
    var $_pager;

    /*
     * the pageID
     * @var int
     */
    var $_pageID;
    
    /*
     * offset
     * @var int
     */
    var $_pagerOffset;

    /**
     * number of rows to return
     * @var int
     */
    var $_pagerRowCount;

    /**
     * total number of rows
     * @var int
     */
    var $_total;

    /* the objectAction for the WebObject */
    var $_action;

    /**
     * This caches the content for the display system
     *
     * @var string
     */
    var $_content;

    /**
     * Is this object being embedded in another object. If
     * so the display routine needs to not do any work. (The
     * parent object takes care of the display)
     *
     * @var boolean
     */
    var $_embedded = false;

    /**
     * Are we in print mode? if so we need to modify the display
     * functionality to do a minimal display :)
     *
     * @var boolean
     */
    var $_print = false;

    /**
     * The storage object (typically a form or a page)
     *
     * @var Object
     */
    var $_store;

    /**
     * Output target, session, template or both?
     *
     * @var int
     */
    var $_output;

    /**
     * cache the smarty template for efficiency reasons
     *
     * @var CRM_Core_Smarty
     */
    

    /**
     * Array of properties that the controller dumps into the output object
     *
     * @var array
     * @static
     */
    


    /**
     * Class constructor
     *
     * @param CRM_Core_Selector_API $object  an object that implements the selector API
     * @param int               $pageID  default pageID
     * @param int               $sortID  default sortID
     * @param int               $action  the actions to potentially support
     * @param CRM_Core_Page|CRM_Core_Form $store   place in session to store some values
     * @param int               $output  what do we so with the output, session/template//both
     *
     * @return Object
     * @access public
     */
    function CRM_Core_Selector_Controller($object, $pageID, $sortID, $action, $store = null, $output = CRM_CORE_SELECTOR_CONTROLLER_TEMPLATE)
    {
  
        $this->_object = $object;
        $this->_pageID = $pageID ? $pageID : 1;
        $this->_sortID = $sortID ? $sortID : null;
        $this->_action = $action;
        $this->_store  = $store;
        $this->_output = $output;

        // fix sortID
        if ( $this->_sortID && strpos( $this->_sortID, '_' ) === false ) {
            $this->_sortID .= '_u';
        }

        $params = array(
                        'pageID'  => $this->_pageID
                        );

        // let the constructor initialize this, should happen only once
        if ( ! isset( $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template'] ) ) {
            $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template'] =& CRM_Core_Smarty::singleton( );
        }

        $this->_sortOrder =& $this->_object->getSortOrder($action);
        $this->_sort      =& new CRM_Utils_Sort( $this->_sortOrder, $this->_sortID );

        /*
         * if we are in transfer mode, do not goto database, use the 
         * session values instead
         */
        if ( $output == CRM_CORE_SELECTOR_CONTROLLER_TRANSFER) {
            $params['total'] = $this->_store->get( 'rowCount' );
        } else {
            $params['total'] = $this->_object->getTotalCount($action);
        }

        $this->_total = $params['total'];
        $this->_object->getPagerParams($action, $params);

        /*
         * Set the default values of RowsPerPage
         */
        $storeRowCount = $store->get( CRM_UTILS_PAGER_PAGE_ROWCOUNT );
        if ( $storeRowCount ) {
            $params['rowCount'] = $storeRowCount;
        } else if ( ! isset( $params['rowCount'] ) ) {
            $params['rowCount'] = CRM_UTILS_PAGER_ROWCOUNT;
        }

        $this->_pager =& new CRM_Utils_Pager( $params );
        list($this->_pagerOffset, $this->_pagerRowCount) = $this->_pager->getOffsetAndRowCount();

    }

    /**
     * have the GET vars changed, i.e. pageId or sortId that forces us to recompute the search values
     *
     * @param int $reset are we being reset
     *
     * @return boolean   if the GET params are different from the session params
     * @access public
     */
    function hasChanged($reset)
    {
        /**
         * if we are in reset state, i.e the store is cleaned out, we return false
         * we also return if we dont have a record of the sort id or page id
         */
        if ( $reset || $this->_store->get( CRM_UTILS_PAGER_PAGE_ID ) == null || $this->_store->get( CRM_UTILS_SORT_SORT_ID ) == null ) {
            return false;
        }

        if ( $this->_store->get( CRM_UTILS_PAGER_PAGE_ID       ) != $this->_pager->getCurrentPageID       ( ) ||
             $this->_store->get( CRM_UTILS_SORT_SORT_ID        ) != $this->_sort->getCurrentSortID        ( ) || 
             $this->_store->get( CRM_UTILS_SORT_SORT_DIRECTION ) != $this->_sort->getCurrentSortDirection ( ) ) {
            return true;
        }
        return false;
    }

    /**
     * Heart of the Controller. This is where all the action takes place
     *
     *   - The rows are fetched and stored depending on the type of output needed
     *
     *   - For export/printing all rows are selected.
     *
     *   - for displaying on screen paging parameters are used to display the
     *     required rows.
     *
     *   - also depending on output type of session or template rows are appropriately stored in session
     *     or template variables are updated.
     *
     *
     * @return void
     *
     */
    function run( )
    {

        // get the column headers
        $columnHeaders =& $this->_object->getColumnHeaders( $this->_action, $this->_output );

        // we need to get the rows if we are exporting or printing them
        if ($this->_output == CRM_CORE_SELECTOR_CONTROLLER_EXPORT|| $this->_output == CRM_CORE_SELECTOR_CONTROLLER_SCREEN) {
            // get rows (without paging criteria)
            $rows          =& $this->_object->getRows( $this->_action,
                                                       0, 0,
                                                       $this->_sort,
                                                       $this->_output );
            if ( $this->_output == CRM_CORE_SELECTOR_CONTROLLER_EXPORT) {
                // export the rows.
                CRM_Core_Report_Excel::writeCSVFile( $this->_object->getExportFileName( ),
                                                     $columnHeaders,
                                                     $rows );
                exit(1);
            } else {
                // assign to template and display them.
                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'rows'         , $rows          );
            }
        } else {
            // output requires paging/sorting capability
            // get rows with paging criteria
            $rows          =& $this->_object->getRows( $this->_action,
                                                       $this->_pagerOffset,
                                                       $this->_pagerRowCount,
                                                       $this->_sort,
                                                       $this->_output );
            $rowsEmpty = count( $rows ) ? false : true;
            $qill      = $this->getQill( );

            // if we need to store in session, lets update session
            if ($this->_output & CRM_CORE_SELECTOR_CONTROLLER_SESSION) {
                $this->_store->set( 'columnHeaders', $columnHeaders );
                $this->_store->set( 'rows'         , $rows          );
                $this->_store->set( 'rowCount'     , $this->_total  );
                $this->_store->set( 'rowsEmpty'    , $rowsEmpty     );
                $this->_store->set( 'qill'         , $qill          );
            } else {
                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'pager'  , $this->_pager   );
                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'sort'   , $this->_sort    );

                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'columnHeaders', $columnHeaders );
                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'rows'         , $rows          );
                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign       ( 'rowsEmpty'    , $rowsEmpty     );
                $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign       ( 'qill'         , $qill          );
            }

            // always store the current pageID and sortID
            $this->_store->set( CRM_UTILS_PAGER_PAGE_ID      , $this->_pager->getCurrentPageID       ( ) );
            $this->_store->set( CRM_UTILS_SORT_SORT_ID       , $this->_sort->getCurrentSortID        ( ) );
            $this->_store->set( CRM_UTILS_SORT_SORT_DIRECTION, $this->_sort->getCurrentSortDirection ( ) );
            $this->_store->set( CRM_UTILS_SORT_SORT_ORDER    , $this->_sort->orderBy                 ( ) );
            $this->_store->set( CRM_UTILS_PAGER_PAGE_ROWCOUNT, $this->_pager->_perPage                   );

        }
    }

    /**
     * default function for qill, if needed to be implemented, we 
     * expect the subclass to do it
     *
     * @return string the status message
     * @access public
     */
     function getQill( ) {
        return $this->_object->getQill( );
    }

    /**
     * getter for pager 
     *
     * @return object CRM_Utils_Pager
     * @access public
     */
    function getPager()
    {
        return $this->_pager;
    }

    /**
     * getter for sort 
     *
     * @return object CRM_Utils_Sort
     * @access public
     */
    function getSort()
    {
        return $this->_sort;
    }
    
    /**
     * Move the variables from the session to the template
     *
     * @return void
     * @access public
     */
    function moveFromSessionToTemplate()
    {
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'pager'  , $this->_pager   );

        $rows = $this->_store->get( 'rows' );
        if ( $rows ) {
            $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign( 'aToZ'  ,
                                      $this->_store->get( 'AToZBar' ) );
        }
        
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign_by_ref( 'sort'  , $this->_sort    );
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign( 'columnHeaders', $this->_store->get( 'columnHeaders' ) );
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign( 'rows'         , $rows                                 );
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign( 'rowsEmpty'    , $this->_store->get( 'rowsEmpty' )     );
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign( 'qill'         , $this->_store->get( 'qill' )          );

        if ( $this->_embedded ) {
            return;
        }
            
        $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->assign( 'tplFile', $this->_object->getTemplateFileName() );
        if ( $this->_print ) {
            $content = $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->fetch( 'CRM/print.tpl' );
        } else {
            $content = $GLOBALS['_CRM_CORE_SELECTOR_CONTROLLER']['_template']->fetch( 'CRM/index.tpl' );
        }
        echo CRM_Utils_System::theme( 'page', $content, null, $this->_print );

    }


    /**
     * setter for embedded 
     *
     * @param boolean $embedded
     *
     * @return void
     * @access public
     */
    function setEmbedded( $embedded  )
    {
        $this->_embedded = $embedded;
    }

    /**
     * getter for embedded 
     *
     * @return boolean return the embedded value
     * @access public
     */
    function getEmbedded( )
    {
        return $this->_embedded;
    }
    
    /**
     * setter for print 
     *
     * @param boolean $print
     *
     * @return void
     * @access public
     */
    function setPrint( $print  )
    {
        $this->_print = $print;
    }

    /**
     * getter for print 
     *
     * @return boolean return the print value
     * @access public
     */
    function getPrint( )
    {
        return $this->_print;
    }

}

?>

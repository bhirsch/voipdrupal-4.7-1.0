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
 | at http://www.openngo.org/faqs/licensing.html                      |
 +--------------------------------------------------------------------+
*/

/**
 *
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id: Selector.php 3854 2005-11-23 13:28:15Z kurund $
 *
 */

$GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_columnHeaders'] = null;
$GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_properties'] =  array( 'contact_id', 'contribution_id',
                                 'contact_type',
                                 'sort_name',
                                 'total_amount',
                                 'contribution_type',
                                 'source',
                                 'receive_date',
                                 'thankyou_date',
                                 'cancel_date',
                                 'name'
                                 );

require_once 'CRM/Core/Selector/Base.php';
require_once 'CRM/Core/Selector/API.php';

require_once 'CRM/Utils/Pager.php';
require_once 'CRM/Utils/Sort.php';

require_once 'CRM/Contact/BAO/Query.php';

/**
 * This class is used to retrieve and display a range of
 * contacts that match the given criteria (specifically for
 * results of advanced search options.
 *
 */
class CRM_Contribute_Selector_Search extends CRM_Core_Selector_Base {
    /**
     * This defines two actions- View and Edit.
     *
     * @var array
     * @static
     */
    

    /**
     * we use desc to remind us what that column is, name is used in the tpl
     *
     * @var array
     * @static
     */
    

    /**
     * Properties of contact we're interested in displaying
     * @var array
     * @static
     */
    

    /** 
     * are we restricting ourselves to a single contact 
     * 
     * @access protected   
     * @var boolean   
     */   
    var $_single = false;

    /**  
     * are we restricting ourselves to a single contact  
     *  
     * @access protected    
     * @var boolean    
     */    
    var $_limit = null;

    /**
     * what context are we being invoked from
     *   
     * @access protected     
     * @var string
     */     
    var $_context = null;

    /**
     * formValues is the array returned by exportValues called on
     * the HTML_QuickForm_Controller for that page.
     *
     * @var array
     * @access protected
     */
    var $_formValues;

    /**
     * represent the type of selector
     *
     * @var int
     * @access protected
     */
    var $_action;

    /** 
     * The additional clause that we restrict the search with 
     * 
     * @var string 
     */ 
    var $_contributionClause = null;

    /** 
     * The query object
     * 
     * @var string 
     */ 
    var $_query;

    /**
     * Class constructor
     *
     * @param array $formValues array of parameters for query
     * @param int   $action - action of search basic or advanced.
     * @param string   $contributionClause if the caller wants to further restrict the search (used in contributions)
     * @param boolean $single are we dealing only with one contact?
     * @param int     $limit  how many contributions do we want returned
     *
     * @return CRM_Contact_Selector
     * @access public
     */
    function CRM_Contribute_Selector_Search(&$formValues,
                         $action = CRM_CORE_ACTION_NONE,
                         $contributionClause = null,
                         $single = false,
                         $limit = null,
                         $context = 'search' ) 
    {
        // submitted form values
        $this->_formValues =& $formValues;

        $this->_single  = $single;
        $this->_limit   = $limit;
        $this->_context = $context;

        $this->_contributionClause = $contributionClause;

        // type of selector
        $this->_action = $action;

        $this->_query =& new CRM_Contact_BAO_Query( $this->_formValues, null, null, false, false,
                                                    CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE );

    }//end of constructor


    /**
     * This method returns the links that are given for each search row.
     * currently the links added for each row are 
     * 
     * - View
     * - Edit
     *
     * @return array
     * @access public
     *
     */
     function &links()
    {

        if (!($GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_links'] = array(
                                  CRM_CORE_ACTION_VIEW   => array(
                                                                   'name'     => ts('View'),
                                                                   'url'      => 'civicrm/contact/view/contribution',
                                                                   'qs'       => 'reset=1&id=%%id%%&cid=%%cid%%&action=view&context=%%cxt%%',
                                                                   'title'    => ts('View Contribution'),
                                                                  ),
                                  CRM_CORE_ACTION_UPDATE => array(
                                                                   'name'     => ts('Edit'),
                                                                   'url'      => 'civicrm/contact/view/contribution',
                                                                   'qs'       => 'reset=1&action=update&id=%%id%%&cid=%%cid%%&context=%%cxt%%',
                                                                   'title'    => ts('Edit Contribution'),
                                                                  ),
                                  CRM_CORE_ACTION_DELETE => array(
                                                                   'name'     => ts('Delete'),
                                                                   'url'      => 'civicrm/contact/view/contribution',
                                                                   'qs'       => 'reset=1&action=delete&id=%%id%%&cid=%%cid%%&context=%%cxt%%',
                                                                   'title'    => ts('Delete Contribution'),
                                                                  ),
                                  );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_links'];
    } //end of function


    /**
     * getter for array of the parameters required for creating pager.
     *
     * @param 
     * @access public
     */
    function getPagerParams($action, &$params) 
    {
        $params['status']       = ts('Contribution') . ' %%StatusMessage%%';
        $params['csvString']    = null;
        if ( $this->_limit ) {
            $params['rowCount']     = $this->_limit;
        } else {
            $params['rowCount']     = CRM_UTILS_PAGER_ROWCOUNT;
        }

        $params['buttonTop']    = 'PagerTopButton';
        $params['buttonBottom'] = 'PagerBottomButton';
    }//end of function

    /**
     * Returns total number of rows for the query.
     *
     * @param 
     * @return int Total number of rows 
     * @access public
     */
    function getTotalCount($action)
    {
        return $this->_query->searchQuery( 0, 0, null,
                                           true, false, 
                                           false, false, 
                                           false, 
                                           $this->_contributionClause );
    }


    /**
     * returns all the rows in the given offset and rowCount
     *
     * @param enum   $action   the action being performed
     * @param int    $offset   the row number to start from
     * @param int    $rowCount the number of rows to return
     * @param string $sort     the sql string that describes the sort order
     * @param enum   $output   what should the result set include (web/email/csv)
     *
     * @return int   the total number of rows for this action
     */
    function &getRows($action, $offset, $rowCount, $sort, $output = null) {
        $result = $this->_query->searchQuery( $offset, $rowCount, $sort,
                                              false, false, 
                                              false, false, 
                                              false, 
                                              $this->_contributionClause );

        // process the result of the query
        $rows = array( );

        // check is the user has view/edit contribution permission
        $permission = CRM_CORE_PERMISSION_VIEW;
        if ( CRM_Utils_System::checkPermission( 'edit contributions' ) ) {
            $permission = CRM_CORE_PERMISSION_EDIT;
        }
        
        $mask = CRM_Core_Action::mask( $permission );
        While ($result->fetch()) {
            $row = array();
            // the columns we are interested in
            foreach ($GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_properties'] as $property) {
                $row[$property] = $result->$property;
            }

            $row['checkbox'] = CRM_CORE_FORM_CB_PREFIX . $result->contribution_id;
            $row['action']   = CRM_Core_Action::formLink( CRM_Contribute_Selector_Search::links(), $mask,
                                                          array( 'id'  => $result->contribution_id,
                                                                 'cid' => $result->contact_id,
                                                                 'cxt' => $this->_context ) );
            $config =& CRM_Core_Config::singleton( );
            $contact_type    = '<img src="' . $config->resourceBase . 'i/contact_';
            switch ($result->contact_type) {
            case 'Individual' :
                $contact_type .= 'ind.gif" alt="' . ts('Individual') . '" />';
                break;
            case 'Household' :
                $contact_type .= 'house.png" alt="' . ts('Household') . '" height="16" width="16" />';
                break;
            case 'Organization' :
                $contact_type .= 'org.gif" alt="' . ts('Organization') . '" height="16" width="18" />';
                break;
            }
            $row['contact_type'] = $contact_type;

            $rows[] = $row;
        }
        return $rows;
    }
    
    
    /**
     * Given the current formValues, gets the query in local
     * language
     *
     * @param  array(reference)   $formValues   submitted formValues
     *
     * @return array              $qill         which contains an array of strings
     * @access public
     */
  
    // the current internationalisation is bad, but should more or less work
    // for most of "European" languages
     function getQILL( )
    {
        return $this->_query->qill( );
    }

    /** 
     * returns the column headers as an array of tuples: 
     * (name, sortName (key to the sort array)) 
     * 
     * @param string $action the action being performed 
     * @param enum   $output what should the result set include (web/email/csv) 
     * 
     * @return array the column headers that need to be displayed 
     * @access public 
     */ 
     function &getColumnHeaders( $action = null, $output = null ) 
    {
        if ( ! isset( $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_columnHeaders'] ) )
        {
            $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_columnHeaders'] = array(
                                          array(
                                                'name'      => ts('Amount'),
                                                'sort'      => 'total_amount',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array('name'      => ts('Type'),
                                                'sort'      => 'contribution_type_id',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Source'),
                                                'sort'      => 'source',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Received'),
                                                'sort'      => 'receive_date',
                                                'direction' => CRM_UTILS_SORT_DESCENDING,
                                                ),
                                          array(
                                                'name'      => ts('Thank-you Sent'),
                                                'sort'      => 'thankyou_date',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Cancelled'),
                                                'sort'      => 'cancel_date',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Premium'),
                                                'sort'      => 'name',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array('desc' => ts('Actions') ),
                                          );

            if ( ! $this->_single ) {
                $pre = array( 
                             array('desc' => ts('Contact Type') ), 
                             array( 
                                   'name'      => ts('Name'), 
                                   'sort'      => 'sort_name', 
                                   'direction' => CRM_UTILS_SORT_DONTCARE, 
                                   )
                             );
                $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_columnHeaders'] = array_merge( $pre, $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_columnHeaders'] );
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_SELECTOR_SEARCH']['_columnHeaders'];
    }
    
    function &getQuery( ) {
        return $this->_query;
    }

    /** 
     * name of export file. 
     * 
     * @param string $output type of output 
     * @return string name of the file 
     */ 
    function getExportFileName( $output = 'csv') { 
        return ts('CiviCRM Contribution Search'); 
    }

}//end of class

?>

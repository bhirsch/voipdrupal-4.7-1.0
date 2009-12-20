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
 * $Id: Selector.php 5388 2006-05-15 17:09:05Z lobo $
 *
 */

$GLOBALS['_CRM_CONTACT_SELECTOR']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_SELECTOR']['_columnHeaders'] = null;
$GLOBALS['_CRM_CONTACT_SELECTOR']['_properties'] =  array('contact_id', 'contact_type', 'sort_name', 'street_address',
                                'city', 'state_province', 'postal_code', 'country',
                                'geo_code_1', 'geo_code_2',
                                'email', 'phone', 'status' );

require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/Selector/Base.php';
require_once 'CRM/Core/Selector/API.php';

require_once 'CRM/Utils/Pager.php';
require_once 'CRM/Utils/Sort.php';

require_once 'CRM/Contact/BAO/Contact.php';
require_once 'CRM/Contact/BAO/Query.php';

/**
 * This class is used to retrieve and display a range of
 * contacts that match the given criteria (specifically for
 * results of advanced search options.
 *
 */
class CRM_Contact_Selector extends CRM_Core_Selector_Base {
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
     * This caches the content for the display system.
     *
     * @var string
     * @access protected
     */
    var $_contact;

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

    var $_query;

    /**
     * Class constructor
     *
     * @param array $formValues array of parameters for query
     * @param int   $action - action of search basic or advanced.
     *
     * @return CRM_Contact_Selector
     * @access public
     */
    function CRM_Contact_Selector(&$formValues, $action = CRM_CORE_ACTION_NONE) 
    {
        //object of BAO_Contact_Individual for fetching the records from db
        $this->_contact =& new CRM_Contact_BAO_Contact();

        // submitted form values
        $this->_formValues =& $formValues;

        // type of selector
        $this->_action = $action;

        $this->_query =& new CRM_Contact_BAO_Query( $this->_formValues );
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

        if (!($GLOBALS['_CRM_CONTACT_SELECTOR']['_links'])) {
            $GLOBALS['_CRM_CONTACT_SELECTOR']['_links'] = array(
                                  CRM_CORE_ACTION_VIEW   => array(
                                                                   'name'     => ts('View'),
                                                                   'url'      => 'civicrm/contact/view',
                                                                   'qs'       => 'reset=1&cid=%%id%%',
                                                                   'title'    => ts('View Contact Details'),
                                                                  ),
                                  CRM_CORE_ACTION_UPDATE => array(
                                                                   'name'     => ts('Edit'),
                                                                   'url'      => 'civicrm/contact/view',
                                                                   'qs'       => 'reset=1&action=update&cid=%%id%%',
                                                                   'title'    => ts('Edit Contact Details'),
                                                                  ),
                                  );

            $config = CRM_Core_Config::singleton( );
            if ( $config->mapAPIKey && $config->mapProvider) {
                $GLOBALS['_CRM_CONTACT_SELECTOR']['_links'][CRM_CORE_ACTION_MAP] = array(
                                                            'name'     => ts('Map'),
                                                            'url'      => 'civicrm/contact/search/map',
                                                            'qs'       => 'reset=1&cid=%%id%%',
                                                            'title'    => ts('Map Contact'),
                                                            );
            }
        }
        return $GLOBALS['_CRM_CONTACT_SELECTOR']['_links'];
    } //end of function


    /**
     * getter for array of the parameters required for creating pager.
     *
     * @param 
     * @access public
     */
    function getPagerParams($action, &$params) 
    {
        $params['status']       = ts('Contact %%StatusMessage%%');
        $params['csvString']    = null;
        $params['rowCount']     = CRM_UTILS_PAGER_ROWCOUNT;

        $params['buttonTop']    = 'PagerTopButton';
        $params['buttonBottom'] = 'PagerBottomButton';
    }//end of function


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
    function &getColumnHeaders($action = null, $output = null) 
    {
        if ( $output == CRM_CORE_SELECTOR_CONTROLLER_EXPORT || $output == CRM_CORE_SELECTOR_CONTROLLER_SCREEN ) {
            $csvHeaders = array( ts('Contact Id'), ts('Contact Type') );
            foreach ( CRM_Contact_Selector::_getColumnHeaders() as $column ) {
                if ( array_key_exists( 'name', $column ) ) {
                    $csvHeaders[] = $column['name'];
                }
            }
            return $csvHeaders;
        } else {
            return CRM_Contact_Selector::_getColumnHeaders();
        }
    }


    /**
     * Returns total number of rows for the query.
     *
     * @param 
     * @return int Total number of rows 
     * @access public
     */
    function getTotalCount($action)
    {
        return $this->_query->searchQuery( 0, 0, null, true );
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
        $config =& CRM_Core_Config::singleton( );

        if ( ( $output == CRM_CORE_SELECTOR_CONTROLLER_EXPORT || $output == CRM_CORE_SELECTOR_CONTROLLER_SCREEN ) &&
             $this->_formValues['radio_ts'] == 'ts_sel' ) {
            $includeContactIds = true;
        } else {
            $includeContactIds = false;
        }

        // note the formvalues were given by CRM_Contact_Form_Search to us 
        // and contain the search criteria (parameters)
        // note that the default action is basic
        $result = $this->_query->searchQuery($offset, $rowCount, $sort,
                                             false, $includeContactIds );

        // process the result of the query
        $rows = array( );

        $mask = CRM_Core_Action::mask( CRM_Core_Permission::getPermission( ) );

        $mapMask = $mask & 4095; // mask value to hide map link if there are not lat/long
        
        $gc = CRM_Core_SelectValues::groupContactStatus();

        /* Dirty session hack to get at the context */
        $session =& CRM_Core_Session::singleton();
        $context = $session->get('context', 'CRM_Contact_Controller_Search');

        // CRM_Core_Error::debug( 'p', self::$_properties );

        while ($result->fetch()) {
            $row = array();

            // the columns we are interested in
            foreach ($GLOBALS['_CRM_CONTACT_SELECTOR']['_properties'] as $property) {
                if ( $property == 'status' ) {
                    continue;
                }
                $row[$property] = $result->$property;
            }

            if (!empty ($result->postal_code_suffix)) {
                $row['postal_code'] .= "-" . $result->postal_code_suffix;
            }
            
            
            if ($output != CRM_CORE_SELECTOR_CONTROLLER_EXPORT ||
                $context == 'smog') {
                if (empty($result->status)) {
                    $row['status'] = ts('Smart');
                } else {
                    $row['status'] = $gc[$result->status];
                }
            }
            
            if ( $output != CRM_CORE_SELECTOR_CONTROLLER_EXPORT && $output != CRM_CORE_SELECTOR_CONTROLLER_SCREEN ) {
                $row['checkbox'] = CRM_CORE_FORM_CB_PREFIX . $result->contact_id;

                if ( is_numeric( CRM_Utils_Array::value( 'geo_code_1', $row ) ) ) {
                    $row['action']   = CRM_Core_Action::formLink( CRM_Contact_Selector::links(), $mask, array( 'id' => $result->contact_id ) );
                } else {
                    $row['action']   = CRM_Core_Action::formLink( CRM_Contact_Selector::links(), $mapMask, array( 'id' => $result->contact_id ) );
                }
                
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
            }

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
     * name of export file.
     *
     * @param string $output type of output
     * @return string name of the file
     */
    function getExportFileName( $output = 'csv') {
        return ts('CiviCRM Contact Search');
    }

    /**
     * get colunmn headers for search selector
     *
     *
     * @return array $_columnHeaders
     * @access private
     */
      function &_getColumnHeaders() 
    {
        if ( ! isset( $GLOBALS['_CRM_CONTACT_SELECTOR']['_columnHeaders'] ) )
        {
            $GLOBALS['_CRM_CONTACT_SELECTOR']['_columnHeaders'] = array(
                                          array('desc' => ts('Contact Type') ),
                                          array(
                                                'name'      => ts('Name'),
                                                'sort'      => 'sort_name',
                                                'direction' => CRM_UTILS_SORT_ASCENDING,
                                                ),
                                          array('name' => ts('Address') ),
                                          array(
                                                'name'      => ts('City'),
                                                'sort'      => 'city',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('State'),
                                                'sort'      => 'state_province',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Postal'),
                                                'sort'      => 'postal_code',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Country'),
                                                'sort'      => 'country',
                                              'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array(
                                                'name'      => ts('Email'),
                                                'sort'      => 'email',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array('name' => ts('Phone') ),
                                          array('desc' => ts('Actions') ),
                                          );
        }
        return $GLOBALS['_CRM_CONTACT_SELECTOR']['_columnHeaders'];
    }
    
    function &getQuery( ) {
        return $this->_query;
    }

}//end of class

?>

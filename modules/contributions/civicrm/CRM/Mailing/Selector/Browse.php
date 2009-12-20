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
 * @copyright Donald A. Lobo 01/15/2005
 * $Id: Selector.php 2609 2005-08-17 00:16:37Z lobo $
 *
 */

$GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_links'] =  null;
$GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_columnHeaders'] = null;
$GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['actionLinks'] =  null;

require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/Selector/Base.php';
require_once 'CRM/Core/Selector/API.php';

require_once 'CRM/Utils/Pager.php';
require_once 'CRM/Utils/Sort.php';

require_once 'CRM/Contact/BAO/Contact.php';


/**
 * This class is used to browse past mailings.
 */
class CRM_Mailing_Selector_Browse   extends CRM_Core_Selector_Base 
                                    {
    /**
     * array of supported links, currenly null
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
     * Class constructor
     *
     * @param
     *
     * @return CRM_Contact_Selector_Profile
     * @access public
     */
    function CRM_Mailing_Selector_Browse( )
    {
    }//end of constructor


    /**
     * This method returns the links that are given for each search row.
     *
     * @return array
     * @access public
     *
     */
     function &links()
    {
        return $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_links'];
    } //end of function


    /**
     * getter for array of the parameters required for creating pager.
     *
     * @param 
     * @access public
     */
    function getPagerParams($action, &$params) 
    {
        $params['csvString']    = null;
        $params['rowCount']     = CRM_UTILS_PAGER_ROWCOUNT;
        $params['status']       = ts('Mailings %%StatusMessage%%');
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
        require_once 'CRM/Mailing/BAO/Mailing.php';
        require_once 'CRM/Mailing/BAO/Job.php';
        $mailing = CRM_Mailing_BAO_Mailing::getTableName();
        $job = CRM_Mailing_BAO_Job::getTableName();
        if ( ! isset( $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_columnHeaders'] ) ) {
            $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_columnHeaders'] = array( 
                array(
                    'name'  => ts('Mailing Name'),
                ), 
                array(
                    'name' => ts('Status'),
                ), 
                array(
                    'name' => ts('Scheduled Date'),
                ), 
                array(
                    'name' => ts('Start Date'),
                ), 
                array(
                    'name' => ts('Completed Date'),
                ), 
            );
            if ($output != CRM_CORE_SELECTOR_CONTROLLER_EXPORT) {
                $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_columnHeaders'][] = array('name' => ts('Action'));
            }
        }
        return $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['_columnHeaders'];
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
        $mailing =& new CRM_Mailing_BAO_Mailing();
        
        return $mailing->getCount();
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
        
        
        if (empty($GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['actionLinks'])) {
            $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['actionLinks'] = array(
                CRM_CORE_ACTION_VIEW => array(
                    'name'  => ts('Report'),
                    'url'   => 'civicrm/mailing/report',
                    'qs'    => 'mid=%%mid%%',
                    'title' => ts('View Mailing Report')
                )
            );
        }
        $actionMask = CRM_CORE_ACTION_VIEW;

        
        $mailing =& new CRM_Mailing_BAO_Mailing();
        $rows =& $mailing->getRows($offset, $rowCount, $sort);

        if ($output != CRM_CORE_SELECTOR_CONTROLLER_EXPORT) {
            foreach ($rows as $key => $row) {
                $rows[$key]['action'] = 
                    CRM_Core_Action::formLink(  $GLOBALS['_CRM_MAILING_SELECTOR_BROWSE']['actionLinks'],
                                                $actionMask,
                                                array('mid' => $row['id']));
                unset($rows[$key]['id']);
                // if the scheduled date is 0, replace it with an empty string
                if ($rows[$key]['scheduled_iso'] == '0000-00-00 00:00:00') {
                    $rows[$key]['scheduled'] = '';
                }
                unset($rows[$key]['scheduled_iso']);
            }
        }

        return $rows;
        
    }

    /**
     * name of export file.
     *
     * @param string $output type of output
     * @return string name of the file
     */
    function getExportFileName( $output = 'csv') {
        return ts('CiviMail Mailings');
    }
    
}//end of class

?>

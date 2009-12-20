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
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id: Selector.php 1204 2005-05-27 19:32:55Z lobo $
 *
 */

$GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_actionLinks'] = null;
$GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_columnHeaders'] = null;

require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/Selector/Base.php';
require_once 'CRM/Core/Selector/API.php';

require_once 'CRM/Utils/Pager.php';
require_once 'CRM/Utils/Sort.php';

require_once 'CRM/Contact/BAO/Contact.php';


/**
 * This class is used to retrieve and display history.
 *
 */
class CRM_History_Selector_Activity extends CRM_Core_Selector_Base {
    /**
     * This defines two actions - Details and Delete.
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
    //static $_properties = array('activity_type', 'activity_summary', 'activity_date');

    /**
     * entityId - entity id of entity whose history are displayed
     *
     * @var int
     * @access protected
     */
    var $_entityId;

    /**
     * history object for the selector
     *
     * @var int
     * @access protected
     */
    var $_history;

    /**
     * Class constructor
     *
     * @param int $contactId  - contact whose history we want to display
     * @param int $permission - the permission we have for this contact 
     *
     * @return CRM_History_Selector
     * @access public
     */
    function CRM_History_Selector_Activity($entityId, $permission) 
    {
        $this->_entityId   = $entityId;
        $this->_permission = $permission;
    }


    /**
     * This method returns the action links that are given for each search row.
     * currently the action links added for each row are 
     * 
     * - Details
     * - Delete
     *
     *
     * @return array
     * @access public
     *
     */
     function &actionLinks() 
    {
        $deleteExtra = ts('Are you sure you want to delete this Activity History record?');
        if (!isset($GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_actionLinks'])) {
            $GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_actionLinks'] = array(
                                        CRM_CORE_ACTION_VIEW   => array(
                                                                         'name'     => ts('Details'),
                                                                         'url'      => 'civicrm/history/activity/detail',
                                                                         'qs'       => 'id=%%id%%&activity_id=%%activity_id%%&cid=%%cid%%',
                                                                         'title'    => ts('View Activity Details'),
                                                                         ),
                                        CRM_CORE_ACTION_DELETE => array(
                                                                         'name'     => ts('Delete'),
                                                                         'url'      => 'civicrm/contact/view/activity',
                                                                         'qs'       => 'show=1&action=delete&id=%%id%%&cid=%%cid%%',
                                                                         'extra' => 'onclick = "if (confirm(\'' . $deleteExtra . '\')) this.href+=\'&amp;confirmed=1\'; else return false;"',
                                                                         'title'    => ts('Delete Activity History'),
                                                                         ),
                                        );
        }
        return $GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_actionLinks'];
    }


    /**
     * getter for array of the parameters required for creating pager.
     *
     * @param 
     * @access public
     */
    function getPagerParams($action, &$params) 
    {
        $params['status']       = ts('History %%StatusMessage%%');
        $params['csvString']    = null;
        $params['rowCount']     = CRM_UTILS_PAGER_ROWCOUNT;

        $params['buttonTop']    = 'PagerTopButton';
        $params['buttonBottom'] = 'PagerBottomButton';
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
    function &getColumnHeaders($action = null, $output = null) 
    {
        if ($output==CRM_CORE_SELECTOR_CONTROLLER_EXPORT || $output==CRM_CORE_SELECTOR_CONTROLLER_SCREEN) {
            $csvHeaders = array( ts('Activity Type'), ts('Description'), ts('Activity Date'));
            foreach (CRM_History_Selector_Activity::_getColumnHeaders() as $column ) {
                if (array_key_exists( 'name', $column ) ) {
                    $csvHeaders[] = $column['name'];
                }
            }
            return $csvHeaders;
        } else {
            return CRM_History_Selector_Activity::_getColumnHeaders();
        }
    }


    /**
     * Returns total number of rows for the query.
     *
     * @param string $action - action being performed
     * @return int Total number of rows 
     * @access public
     */
    function getTotalCount($action)
    {
        return CRM_Core_BAO_History::getNumHistory($this->_entityId, 'Activity');
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
        $params = array('entity_table' => 'civicrm_contact', 'entity_id' => $this->_entityId);
        $rows =& CRM_Core_BAO_History::getHistory($params, $offset, $rowCount, $sort, 'Activity');

        $links =& CRM_History_Selector_Activity::actionLinks();
        $mask  =  array_sum(array_keys($links)) & CRM_Core_Action::mask( $this->_permission );
        foreach ($rows as $k => $row) {
            $row =& $rows[$k];
            if ($output != CRM_CORE_SELECTOR_CONTROLLER_EXPORT && $output != CRM_CORE_SELECTOR_CONTROLLER_SCREEN) {
                // check if callback exists
                if ($row['callback']) {
                    $row['action'] = CRM_Core_Action::formLink($links,
                                                               $mask,
                                                               array( 'id' => $k,
                                                                      'activity_id'=>$row['activity_id'],
                                                                      'cid' => $this->_entityId ) );                    
                } else {
                    $actionLinks = $links;
                    unset($actionLinks[CRM_CORE_ACTION_VIEW]);
                    //$row['action'] = CRM_Core_Action::formLink($actionLinks, $mask, array('id'=>$k));
                    $row['action'] = CRM_Core_Action::formLink($actionLinks, $mask, array('id'=>$k,'cid' => $this->_entityId));
                }
            }
            unset($row);
        }
        return $rows;
    }
    
    /**
     * name of export file.
     *
     * @param string $output type of output
     * @return string name of the file
     */
    function getExportFileName($output = 'csv')
    {
        return ts('CiviCRM Activity History');
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
        if (!isset($GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_columnHeaders'])) {
            $GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_columnHeaders'] = array(
                                          array(
                                                'name'      => ts('Activity Type'),
                                                'sort'      => 'activity_type',
                                                'direction' => CRM_UTILS_SORT_DONTCARE,
                                                ),
                                          array('name' => ts('Description')),
                                          array(
                                                'name'      => ts('Activity Date'),
                                                'sort'      => 'activity_date',
                                                'direction' => CRM_UTILS_SORT_DESCENDING,
                                                ),
                                          array('desc' => ts('Actions')),
                                          );
        }
        return $GLOBALS['_CRM_HISTORY_SELECTOR_ACTIVITY']['_columnHeaders'];
    }
}
?>

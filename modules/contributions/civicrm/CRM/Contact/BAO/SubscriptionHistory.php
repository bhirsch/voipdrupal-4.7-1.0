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


require_once 'CRM/Contact/DAO/SubscriptionHistory.php';

/**
 * BAO object for crm_email table
 */
class CRM_Contact_BAO_SubscriptionHistory extends CRM_Contact_DAO_SubscriptionHistory {

    function CRM_Contact_BAO_SubscriptionHistory() {
        parent::CRM_Contact_DAO_SubscriptionHistory();
    }
    
    /**
     * Create a new subscription history record
     *
     * @param array $params     Values for the new history record
     * @return object $history  The new history object
     * @access public
     * @static
     */
      function &create(&$params) {
        $history =& new CRM_Contact_BAO_SubscriptionHistory();
        $history->date = date('Ymd');
        $history->copyValues($params);
        $history->save();
        return $history;
    }

    /**
     * Erase a contact's subscription history records
     *
     * @param int $id       The contact id
     * @return none
     * @access public
     * @static
     */
      function deleteContact($id) {
        $history =& new CRM_Contact_BAO_SubscriptionHistory();
        $history->contact_id = $id;
        $history->delete();
    }
}

?>

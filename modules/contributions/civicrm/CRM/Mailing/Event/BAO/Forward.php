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


require_once 'CRM/Mailing/Event/DAO/Forward.php';

class CRM_Mailing_Event_BAO_Forward extends CRM_Mailing_Event_DAO_Forward {

    /**
     * class constructor
     */
    function CRM_Mailing_Event_BAO_Forward( ) {
        parent::CRM_Mailing_Event_DAO_Forward( );
    }


    /**
     * Create a new forward event, create a new contact if necessary
     */
     function &forward($job_id, $queue_id, $hash, $forward_email) {
        $q =& CRM_Mailing_Event_BAO_Queue::verify($job_id, $queue_id, $hash);
        if (! $q) {
            return null;
        }

        /* Find the email address/contact, if it exists */
        $contact    =   CRM_Contact_BAO_Contact::getTableName();
        $location   =   CRM_Core_BAO_Location::getTableName();
        $email      =   CRM_Core_BAO_Email::getTableName();
        $queueTable =   CRM_Mailing_Event_BAO_Queue::getTableName();
        $job        =   CRM_Mailing_BAO_Job::getTableName();
        $mailing    =   CRM_Mailing_BAO_Mailing::getTableName();
        $forward    =   CRM_Mailing_Event_BAO_Forward::getTableName();
       
        $domain     =& CRM_Mailing_Event_BAO_Queue::getDomain($queue_id);
       
        $dao =& new CRM_Core_Dao();
        $dao->query("
                SELECT      $contact.id as contact_id,
                            $email.id as email_id,
                            $contact.do_not_email as do_not_email,
                            $queueTable.id as queue_id
                FROM        $email, $job as temp_job
                INNER JOIN  $location
                        ON  $email.location_id = $location.id
                INNER JOIN  $contact
                        ON  $location.entity_table = '$contact'
                        AND $location.entity_id = $contact.id
                LEFT JOIN   $queueTable
                        ON  $email.id = $queueTable.email_id
                LEFT JOIN   $job
                        ON  $queueTable.job_id = $job.id
                        AND temp_job.mailing_id = $job.mailing_id
                WHERE       temp_job.id = $job_id
                    AND     $email.email = '" .
                    CRM_Utils_Type::escape($forward_email, 'String') . "'");

        $dao->fetch();
        
        CRM_Core_DAO::transaction('BEGIN');
        
        if (isset($dao->queue_id) || $dao->do_not_email == 1) {
            /* We already sent this mailing to $forward_email, or we should
             * never email this contact.  Give up. */

            return false;
        } elseif (empty($dao->contact_id)) {
            /* No contact found, we'll have to create a new one */
            $contact_params = array('email' => $forward_email);
            $contact =& crm_create_contact($contact_params);
            if (is_a($contact, 'CRM_Core_Error')) {
                return false;
            }
            /* This is an ugly hack, but the API doesn't really support
             * overriding the domain ID any other way */
            $contact->domain_id = $domain->id;
            $contact->save();
            $contact_id = $contact->id;
            $email_id = $contact->location[1]->email[1]->id;
        } else {
            $contact_id = $dao->contact_id;
            $email_id = $dao->email_id;
        }

        /* Create a new queue event */
        $queue_params = array(
            'email_id' => $email_id,
            'contact_id' => $contact_id,
            'job_id' => $job_id,
        );
        $queue =& CRM_Mailing_Event_BAO_Queue::create($queue_params);
        
        $forward =& new CRM_Mailing_Event_BAO_Forward();
        $forward->time_stamp = date('YmdHis');
        $forward->event_queue_id = $queue_id;
        $forward->dest_queue_id = $queue->id;
        $forward->save();
    
        $dao->reset();
        $dao->query("   SELECT  $job.mailing_id as mailing_id 
                        FROM    $job
                        WHERE   $job.id = " . 
                        CRM_Utils_Type::escape($job_id, 'Integer'));
        $dao->fetch();
        $mailing_obj =& new CRM_Mailing_BAO_Mailing();
        $mailing_obj->id = $dao->mailing_id;
        $mailing_obj->find(true);

        $config =& CRM_Core_Config::singleton();
        $mailer =& $config->getMailer();

        $recipient = null;
        $message =& $mailing_obj->compose($job_id, $queue->id, $queue->hash,
            $queue->contact_id, $forward_email, $recipient);

        $body = $message->get();
        $headers = $message->headers();

        PEAR::setErrorHandling( PEAR_ERROR_CALLBACK,
                                array('CRM_Mailing_BAO_Mailing', 'catchSMTP'));
        $result = $mailer->send($recipient, $headers, $body);
        CRM_Core_Error::setCallback();

        $params = array('event_queue_id' => $queue->id,
                        'job_id'        => $job_id,
                        'hash'          => $queue->hash);
        if (is_a($result, PEAR_Error)) {
            /* Register the bounce event */
            $params = array_merge($params,
                CRM_Mailing_BAO_BouncePattern::match($result->getMessage()));
            CRM_Mailing_Event_BAO_Bounce::create($params);
        } else {
            /* Register the delivery event */
            CRM_Mailing_Event_BAO_Delivered::create($params);
        }

        CRM_Core_DAO::transaction('COMMIT');        
        return true;
    }

    /**
     * Get row count for the event selector
     *
     * @param int $mailing_id       ID of the mailing
     * @param int $job_id           Optional ID of a job to filter on
     * @param boolean $is_distinct  Group by queue ID?
     * @return int                  Number of rows in result set
     * @access public
     * @static
     */
      function getTotalCount($mailing_id, $job_id = null,
                                            $is_distinct = false) {
        $dao =& new CRM_Core_DAO();
        
        $forward    = CRM_Mailing_Event_BAO_Forward::getTableName();
        $queue      = CRM_Mailing_Event_BAO_Queue::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();

        $query = "
            SELECT      COUNT($forward.id) as forward
            FROM        $forward
            INNER JOIN  $queue
                    ON  $forward.event_queue_id = $queue.id
            INNER JOIN  $job
                    ON  $queue.job_id = $job.id
            INNER JOIN  $mailing
                    ON  $job.mailing_id = $mailing.id
            WHERE       $mailing.id = " 
            . CRM_Utils_Type::escape($mailing_id, 'Integer');

        if (!empty($job_id)) {
            $query  .= " AND $job.id = " 
                    . CRM_Utils_Type::escape($job_id, 'Integer');
        }
        
        if ($is_distinct) {
            $query .= " GROUP BY $queue.id ";
        }

        $dao->fetch();
        return $dao->forward;
    }



    /**
     * Get rows for the event browser
     *
     * @param int $mailing_id       ID of the mailing
     * @param int $job_id           optional ID of the job
     * @param boolean $is_distinct  Group by queue id?
     * @param int $offset           Offset
     * @param int $rowCount         Number of rows
     * @param array $sort           sort array
     * @return array                Result set
     * @access public
     * @static
     */
      function &getRows($mailing_id, $job_id = null, 
        $is_distinct = false, $offset = null, $rowCount = null, $sort = null) {
        
        $dao =& new CRM_Core_Dao();
        
        $forward    = CRM_Mailing_Event_BAO_Forward::getTableName();
        $queue      = CRM_Mailing_Event_BAO_Queue::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();
        $contact    = CRM_Contact_BAO_Contact::getTableName();
        $email      = CRM_Core_BAO_Email::getTableName();

        $query =    "
            SELECT      $contact.display_name as from_name,
                        $contact.id as from_id,
                        $email.email as from_email,
                        dest_contact.id as dest_id,
                        dest_email.email as dest_email,
                        $forward.time_stamp as date
            FROM        $contact
            INNER JOIN  $queue
                    ON  $queue.contact_id = $contact.id
            INNER JOIN  $email
                    ON  $queue.email_id = $email.id
            INNER JOIN  $forward
                    ON  $forward.event_queue_id = $queue.id
            INNER JOIN  $queue as dest_queue
                    ON  $forward.dest_queue_id = dest_queue.id
            INNER JOIN  $contact as dest_contact
                    ON  dest_queue.contact_id = dest_contact.id
            INNER JOIN  $email as dest_email
                    ON  dest_queue.email_id = dest_email.id
            INNER JOIN  $job
                    ON  $queue.job_id = $job.id
            INNER JOIN  $mailing
                    ON  $job.mailing_id = $mailing.id
            WHERE       $mailing.id = " 
            . CRM_Utils_Type::escape($mailing_id, 'Integer');
    
        if (!empty($job_id)) {
            $query .= " AND $job.id = " 
                    . CRM_Utils_Type::escape($job_id, 'Integer');
        }

        if ($is_distinct) {
            $query .= " GROUP BY $queue.id ";
        }

        $query .= " ORDER BY $contact.sort_name, $forward.time_stamp ";

        if ($offset) {
            $query .= ' LIMIT ' 
                    . CRM_Utils_Type::escape($offset, 'Integer') . ', ' 
                    . CRM_Utils_Type::escape($rowCount, 'Integer');
        }

        $dao->query($query);
        
        $results = array();

        while ($dao->fetch()) {
            $from_url = CRM_Utils_System::url('civicrm/contact/view',
                                "reset=1&cid={$dao->from_id}");
            $dest_url = CRM_Utils_System::url('civicrm/contact/view',
                                "reset=1&cid={$dao->dest_id}");
            $results[] = array(
                'from_name'      => "<a href=\"$from_url\">{$dao->from_name}</a>",
                'from_email'     => $dao->from_email,
                'dest_email'      => "<a href=\"$dest_url\">{$dao->dest_email}</a>",
                'date'      => CRM_Utils_Date::customFormat($dao->date)
            );
        }
        return $results;
    }



    
}

?>

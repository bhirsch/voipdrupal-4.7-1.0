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



require_once 'Mail/mime.php';

require_once 'CRM/Mailing/Event/DAO/Unsubscribe.php';
require_once 'CRM/Mailing/BAO/Job.php'; 
require_once 'CRM/Mailing/BAO/Mailing.php';
require_once 'CRM/Mailing/DAO/Group.php';
require_once 'CRM/Contact/BAO/Group.php';
require_once 'CRM/Contact/BAO/GroupContact.php';

class CRM_Mailing_Event_BAO_Unsubscribe extends CRM_Mailing_Event_DAO_Unsubscribe {

    /**
     * class constructor
     */
    function CRM_Mailing_Event_BAO_Unsubscribe( ) {
        parent::CRM_Mailing_Event_DAO_Unsubscribe( );
    }

    /**
     * Unsubscribe a contact from the domain
     *
     * @param int $job_id       The job ID
     * @param int $queue_id     The Queue Event ID of the recipient
     * @param string $hash      The hash
     * @return boolean          Was the contact succesfully unsubscribed?
     * @access public
     * @static
     */
      function unsub_from_domain($job_id, $queue_id, $hash) {
        $q =& CRM_Mailing_Event_BAO_Queue::verify($job_id, $queue_id, $hash);
        if (! $q) {
            return false;
        }
        CRM_Core_DAO::transaction('BEGIN');
        $contact =& new CRM_Contact_BAO_Contact();
        $contact->id = $q->contact_id;
        $contact->is_opt_out = true;
        $contact->save();
        
        $ue =& new CRM_Mailing_Event_BAO_Unsubscribe();
        $ue->event_queue_id = $queue_id;
        $ue->org_unsubscribe = 1;
        $ue->time_stamp = date('YmdHis');
        $ue->save();

        $shParams = array(
            'contact_id'    => $q->contact_id,
            'group_id'      => null,
            'status'        => 'Removed',
            'method'        => 'Email',
            'tracking'      => $ue->id
        );
        CRM_Contact_BAO_SubscriptionHistory::create($shParams);
        
        CRM_Core_DAO::transaction('COMMIT');
        
        return true;
    }

    /**
     * Unsubscribe a contact from all groups that received this mailing
     *
     * @param int $job_id       The job ID
     * @param int $queue_id     The Queue Event ID of the recipient
     * @param string $hash      The hash
     * @return array|null $groups    Array of all groups from which the contact was removed, or null if the queue event could not be found.
     * @access public
     * @static
     */
      function &unsub_from_mailing($job_id, $queue_id, $hash) {
        /* First make sure there's a matching queue event */
        $q =& CRM_Mailing_Event_BAO_Queue::verify($job_id, $queue_id, $hash);
        if (! $q) {
            return null;
        }
        
        $contact_id = $q->contact_id;
        
        CRM_Core_DAO::transaction('BEGIN');

        $do =& new CRM_Core_DAO();
        $mg         = CRM_Mailing_DAO_Group::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $group      = CRM_Contact_BAO_Group::getTableName();
        $gc         = CRM_Contact_BAO_GroupContact::getTableName();
        
        $do->query("
            SELECT      $mg.entity_table as entity_table,
                        $mg.entity_id as entity_id
            FROM        $mg
            INNER JOIN  $job
                ON      $job.mailing_id = $mg.mailing_id
            WHERE       $job.id = " 
                . CRM_Utils_Type::escape($job_id, 'Integer') . "
                AND     $mg.group_type = 'Include'");
        
        /* Make a list of groups and a list of prior mailings that received 
         * this mailing */
         
        $groups = array();
        $mailings = array();

        while ($do->fetch()) {
            if ($do->entity_table == $group) {
                $groups[$do->entity_id] = true;
            } else if ($do->entity_table == $mailing) {
                $mailings[] = $do->entity_id;
            }
        }

        /* As long as we have prior mailings, find their groups and add to the
         * list */
        while (! empty($mailings)) {
            $do->query("
                SELECT      $mg.entity_table as entity_table,
                            $mg.entity_id as entity_id
                FROM        $mg
                WHERE       $mg.mailing_id IN (".implode(', ', $mailings).")
                    AND     $mg.group_type = 'Include'");
            
            $mailings = array();
            
            while ($do->fetch()) {
                if ($do->entity_table == $group) {
                    $groups[$do->entity_id] = true;
                } else if ($do->entity_table == $mailing) {
                    $mailings[] = $do->entity_id;
                }
            }
        }

        /* Now we have a complete list of recipient groups.  Filter out all
         * those except smart groups and those that the contact belongs to */
        $do->query("
            SELECT      $group.id as group_id,
                        $group.name as name
            FROM        $group
            LEFT JOIN   $gc
                ON      $gc.group_id = $group.id
            WHERE       $group.id IN (".implode(', ', array_keys($groups)).")
                AND     ($group.saved_search_id is not null
                            OR  ($gc.contact_id = $contact_id
                                AND $gc.status = 'Added')
                        )");
                        
        $groups = array();
        
        while ($do->fetch()) {
            $groups[$do->group_id] = $do->name;
        }

        $contacts = array($contact_id);

        foreach ($groups as $group_id => $group_name) {
            list($total, $removed, $notremoved) = 
                CRM_Contact_BAO_GroupContact::removeContactsFromGroup(
                    $contacts, $group_id, 'Email', $queue_id);
            if ($notremoved) {
                unset($groups[$group_id]);
            }
        }
        
        $ue =& new CRM_Mailing_Event_BAO_Unsubscribe();
        $ue->event_queue_id = $queue_id;
        $ue->org_unsubscribe = 0;
        $ue->time_stamp = date('YmdHis');
        $ue->save();
        
        CRM_Core_DAO::transaction('COMMIT');
        return $groups;
    }

    /**
     * Send a reponse email informing the contact of the groups from which he
     * has been unsubscribed.
     *
     * @param string $queue_id      The queue event ID
     * @param array $groups         List of group IDs
     * @param bool $is_domain       Is this domain-level?
     * @param int $job              The job ID
     * @return void
     * @access public
     * @static
     */
      function send_unsub_response($queue_id, $groups, $is_domain = false, $job) {
        $config =& CRM_Core_Config::singleton();
        $domain =& CRM_Mailing_Event_BAO_Queue::getDomain($queue_id);

        $jobTable = CRM_Mailing_BAO_Job::getTableName();
        $mailingTable = CRM_Mailing_DAO_Mailing::getTableName();
        $contacts = CRM_Contact_DAO_Contact::getTableName();
        $email = CRM_Core_DAO_Email::getTableName();
        $queue = CRM_Mailing_Event_BAO_Queue::getTableName();
        
        $dao =& new CRM_Mailing_DAO_Mailing();
        $dao->query("   SELECT * FROM $mailingTable 
                        INNER JOIN $jobTable ON
                            $jobTable.mailing_id = $mailingTable.id 
                        WHERE $jobTable.id = $job");
        $dao->fetch();
        $component =& new CRM_Mailing_BAO_Component();
        
        if ($is_domain) {
            $component->id = $dao->optout_id;
        } else {
            $component->id = $dao->unsubscribe_id;
        }
        $component->find(true);
        
        $html = $component->body_html;
        $text = $component->body_text;

        $eq =& new CRM_Core_DAO();
        $eq->query(
        "SELECT     $contacts.preferred_mail_format as format,
                    $contacts.id as contact_id,
                    $email.email as email,
                    $queue.hash as hash
        FROM        $contacts
        INNER JOIN  $queue ON $queue.contact_id = $contacts.id
        INNER JOIN  $email ON $queue.email_id = $email.id
        WHERE       $queue.id = " 
                    . CRM_Utils_Type::escape($queue_id, 'Integer'));
        $eq->fetch();
        
        $message =& new Mail_Mime("\n");
        require_once 'CRM/Utils/Token.php';
        if ($eq->format == 'HTML' || $eq->format == 'Both') {
            $html = 
                CRM_Utils_Token::replaceDomainTokens($html, $domain, true);
            $html = 
                CRM_Utils_Token::replaceUnsubscribeTokens($html, $domain, $groups, true, $eq->contact_id, $eq->hash);
            $message->setHTMLBody($html);
        }
        if (!$html || $eq->format == 'Text' || $eq->format == 'Both') {
            $text = 
                CRM_Utils_Token::replaceDomainTokens($text, $domain, false);
            $text = 
                CRM_Utils_Token::replaceUnsubscribeTokens($text, $domain, $groups, false, $eq->contact_id, $eq->hash);
            $message->setTxtBody($text);
        }
        $headers = array(
            'Subject'       => $component->subject,
            'From'          => ts('"%1 Administrator" <%2>',
                array(  1 => $domain->name, 
                        2 => "do-not-reply@{$domain->email_domain}")),
            'To'            => $eq->email,
            'Reply-To'      => "do-not-reply@{$domain->email_domain}",
            'Return-Path'   => "do-not-reply@{$domain->email_domain}"
        );

        $b = $message->get();
        $h = $message->headers($headers);
        $mailer =& $config->getMailer();

        PEAR::setErrorHandling( PEAR_ERROR_CALLBACK,
                                array('CRM_Mailing_BAO_Mailing', 'catchSMTP'));
        $mailer->send($eq->email, $h, $b);
        CRM_Core_Error::setCallback();
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
        
        $unsub      = CRM_Mailing_Event_BAO_Unsubscribe::getTableName();
        $queue      = CRM_Mailing_Event_BAO_Queue::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();

        $query = "
            SELECT      COUNT($unsub.id) as unsubs
            FROM        $unsub
            INNER JOIN  $queue
                    ON  $unsub.event_queue_id = $queue.id
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
        return $dao->unsub;
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
        
        $unsub      = CRM_Mailing_Event_BAO_Unsubscribe::getTableName();
        $queue      = CRM_Mailing_Event_BAO_Queue::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();
        $contact    = CRM_Contact_BAO_Contact::getTableName();
        $email      = CRM_Core_BAO_Email::getTableName();

        $query =    "
            SELECT      $contact.display_name as display_name,
                        $contact.id as contact_id,
                        $email.email as email,
                        $unsub.time_stamp as date,
                        $unsub.org_unsubscribe as org_unsubscribe
            FROM        $contact
            INNER JOIN  $queue
                    ON  $queue.contact_id = $contact.id
            INNER JOIN  $email
                    ON  $queue.email_id = $email.id
            INNER JOIN  $unsub
                    ON  $unsub.event_queue_id = $queue.id
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

        $query .= " ORDER BY $contact.sort_name, $unsub.time_stamp ";

        if ($offset) {
            $query .= ' LIMIT ' 
                    . CRM_Utils_Type::escape($offset, 'Integer') . ', ' 
                    . CRM_Utils_Type::escape($rowCount, 'Integer');
        }

        $dao->query($query);
        
        $results = array();

        while ($dao->fetch()) {
            $url = CRM_Utils_System::url('civicrm/contact/view',
                                "reset=1&cid={$dao->contact_id}");
            $results[] = array(
                'name'      => "<a href=\"$url\">{$dao->display_name}</a>",
                'email'     => $dao->email,
                'org'       => $dao->org_unsubscribe ? ts('Yes') : ts('No'),
                'date'      => CRM_Utils_Date::customFormat($dao->date)
            );
        }
        return $results;
    }

}

?>

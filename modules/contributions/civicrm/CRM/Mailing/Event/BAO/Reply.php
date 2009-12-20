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

require_once 'CRM/Mailing/Event/DAO/Reply.php';

require_once 'CRM/Mailing/BAO/Job.php'; 
require_once 'CRM/Mailing/BAO/Mailing.php';

class CRM_Mailing_Event_BAO_Reply extends CRM_Mailing_Event_DAO_Reply {

    /**
     * class constructor
     */
    function CRM_Mailing_Event_BAO_Reply( ) {
        parent::CRM_Mailing_Event_DAO_Reply( );
    }

    /**
     * Register a reply event. 
     *
     * @param int $job_id       The job ID of the reply
     * @param int $queue_id     The queue event id
     * @param string $hash      The hash
     * @return object|null      The mailing object, or null on failure
     * @access public
     * @static
     */
      function &reply($job_id, $queue_id, $hash, $replyto = null) {
        /* First make sure there's a matching queue event */
        $q =& CRM_Mailing_Event_BAO_Queue::verify($job_id, $queue_id, $hash);

        if (! $q) {
            return null;
        }

        $mailing =& new CRM_Mailing_BAO_Mailing();
        $mailings = CRM_Mailing_BAO_Mailing::getTableName();
        $jobs = CRM_Mailing_BAO_Job::getTableName();
        $mailing->query(
            "SELECT * FROM  $mailings 
            INNER JOIN      $jobs 
                ON          $jobs.mailing_id = $mailings.id
            WHERE           $jobs.id = {$q->job_id}");
        $mailing->fetch();
        if ($mailing->auto_responder) {
            CRM_Mailing_Event_BAO_Reply::autoRespond($mailing, $queue_id, $replyto);
        }

        $re =& new CRM_Mailing_Event_BAO_Reply();
        $re->event_queue_id = $queue_id;
        $re->time_stamp = date('YmdHis');
        $re->save();

        if (! $mailing->forward_replies || empty($mailing->replyto_email)) {
            return null;
        }
        
        return $mailing;
    }

    /**
     * Forward a mailing reply 
     *
     * @param int $queue_id     Queue event ID of the sender
     * @param string $mailing   The mailing object
     * @param string $body      Body of the message
     * @param string $replyto   Reply-to of the incoming message
     * @return void
     * @access public
     * @static
     */
      function send($queue_id, &$mailing, &$body, $replyto) {
        $config =& CRM_Core_Config::singleton();
        $mailer =& $config->getMailer();
        $domain =& CRM_Mailing_Event_BAO_Queue::getDomain($queue_id);
        
        $emails = CRM_Core_BAO_Email::getTableName();
        $eq = CRM_Mailing_Event_BAO_Queue::getTableName();
        $contacts = CRM_Contact_BAO_Contact::getTableName();
        
        $dao =& new CRM_Core_DAO();
        $dao->query("SELECT     $contacts.display_name as display_name,
                                $emails.email as email
                    FROM        $eq
                    INNER JOIN  $contacts
                            ON  $eq.contact_id = $contacts.id
                    INNER JOIN  $emails
                            ON  $eq.email_id = $emails.id
                    WHERE       $eq.id = " 
                                . CRM_Utils_Type::escape($queue_id, 'Integer'));
        $dao->fetch();
        
        
        if (empty($dao->display_name)) {
            $from = $dao->email;
        } else {
            $from = "\"{$dao->display_name}\" <{$dao->email}>";
        }
        
        $message =& new Mail_Mime("\n");
        $headers = array(
            'Subject'       => "Re: {$mailing->subject}",
            'To'            => $mailing->replyto_email,
            'From'          => $from,
            'Reply-To'      => empty($replyto) ? $dao->email : $replyto,
            'Return-Path'   => "do-not-reply@{$domain->email_domain}",
        );
        $message->setTxtBody($body);
        $b = $message->get();
        $h = $message->headers($headers);
        PEAR::setErrorHandling( PEAR_ERROR_CALLBACK,
                        array('CRM_Mailing_BAO_Mailing', 'catchSMTP'));
        $mailer->send($mailing->replyto_email, $h, $b);
        CRM_Core_Error::setCallback();
    }

    /**
     * Send an automated response
     *
     * @param object $mailing       The mailing object
     * @param int $queue_id         The queue ID
     * @param string $replyto       Optional reply-to from the reply
     * @return void
     * @access private
     * @static
     */
      function autoRespond(&$mailing, $queue_id, $replyto) {
        $config =& CRM_Core_Config::singleton();

        $contacts   = CRM_Contact_DAO_Contact::getTableName();
        $email      = CRM_Core_DAO_Email::getTableName();
        $queue      = CRM_Mailing_Event_DAO_Queue::getTableName();
        
        $eq =& new CRM_Core_DAO();
        $eq->query(
        "SELECT     $contacts.preferred_mail_format as format,
                    $email.email as email
        FROM        $contacts
        INNER JOIN  $queue ON $queue.contact_id = $contacts.id
        INNER JOIN  $email ON $queue.email_id = $email.id
        WHERE       $queue.id = " 
                            . CRM_Utils_Type::escape($queue_id, 'Integer'));
        $eq->fetch();

        $to = empty($replyto) ? $eq->email : $replyto;
        
        $component =& new CRM_Mailing_BAO_Component();
        $component->id = $mailing->reply_id;
        $component->find(true);

        $message =& new Mail_Mime("\n");

        require_once 'CRM/Core/BAO/Domain.php';        
        $domain =& CRM_Core_BAO_Domain::getDomainById($mailing->domain_id);

        $headers = array(
            'Subject'   => $component->subject,
            'To'        => $to,
            'From'      => ts('"%1 Administrator" <%2>',
                        array(  1 => $domain->name,
                                2 => "do-not-reply@{$domain->email_domain}")),
            'Reply-To'  => "do-not-reply@{$domain->email_domain}",
            'Return-Path' => "do-not-reply@{$domain->email_domain}"
        );

        /* TODO: do we need reply tokens? */
        if ($eq->format == 'HTML' ||  $eq->format == 'Both') {
            $html = $component->body_html;
            require_once 'CRM/Utils/Token.php';
            $html = CRM_Utils_Token::replaceDomainTokens($html, $domain, true);
            $message->setHTMLBody($html);
        }
        if (!$html || $eq->format == 'Text' ||  $eq->format == 'Both') {
            $text = $component->body_text;
            require_once 'CRM/Utils/Token.php';
            $text = CRM_Utils_Token::replaceDomainTokens($text, $domain, false);
            $message->setTxtBody($text);
        }
        
        $b = $message->get();
        $h = $message->headers($headers);
        
        $mailer =& $config->getMailer();
        PEAR::setErrorHandling( PEAR_ERROR_CALLBACK,
                        array('CRM_Mailing_BAO_Mailing', 'catchSMTP'));
        $mailer->send($to, $h, $b);
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
        
        $reply      = CRM_Mailing_Event_BAO_Reply::getTableName();
        $queue      = CRM_Mailing_Event_BAO_Queue::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();

        $query = "
            SELECT      COUNT($reply.id) as reply
            FROM        $reply
            INNER JOIN  $queue
                    ON  $reply.event_queue_id = $queue.id
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
        return $dao->reply;
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
        
        $reply      = CRM_Mailing_Event_BAO_Reply::getTableName();
        $queue      = CRM_Mailing_Event_BAO_Queue::getTableName();
        $mailing    = CRM_Mailing_BAO_Mailing::getTableName();
        $job        = CRM_Mailing_BAO_Job::getTableName();
        $contact    = CRM_Contact_BAO_Contact::getTableName();
        $email      = CRM_Core_BAO_Email::getTableName();

        $query =    "
            SELECT      $contact.display_name as display_name,
                        $contact.id as contact_id,
                        $email.email as email,
                        $reply.time_stamp as date
            FROM        $contact
            INNER JOIN  $queue
                    ON  $queue.contact_id = $contact.id
            INNER JOIN  $email
                    ON  $queue.email_id = $email.id
            INNER JOIN  $reply
                    ON  $reply.event_queue_id = $queue.id
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

        $query .= " ORDER BY $contact.sort_name, $reply.time_stamp ";

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
                'date'      => CRM_Utils_Date::customFormat($dao->date)
            );
        }
        return $results;
    }






}

?>

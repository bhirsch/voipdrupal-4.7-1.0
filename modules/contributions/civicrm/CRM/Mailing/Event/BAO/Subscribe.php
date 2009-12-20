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


require_once 'api/crm.php';
require_once 'Mail/mime.php';
require_once 'CRM/Utils/Verp.php';

require_once 'CRM/Mailing/Event/DAO/Subscribe.php';

class CRM_Mailing_Event_BAO_Subscribe extends CRM_Mailing_Event_DAO_Subscribe {

    /**
     * class constructor
     */
    function CRM_Mailing_Event_BAO_Subscribe( ) {
        parent::CRM_Mailing_Event_DAO_Subscribe( );
    }

    /**
     * Register a subscription event.  Create a new contact if one does not
     * already exist.
     *
     * @param int $domain_id        The domain id of the new subscription
     * @param int $group_id         The group id to subscribe to
     * @param string $email         The email address of the (new) contact
     * @return int|null $se_id      The id of the subscription event, null on failure
     * @access public
     * @static
     */
      function &subscribe($domain_id, $group_id, $email) {
        /* First, find out if the contact already exists */        
        $params = array('email' => $email, 'domain_id' => $domain_id);
        require_once 'CRM/Core/BAO/UFGroup.php';
        $contact_id = CRM_Core_BAO_UFGroup::findContact($params);
        
        CRM_Core_DAO::transaction('BEGIN');
        if (is_a($contact_id, CRM_Core_Error)) {
            require_once 'CRM/Core/BAO/LocationType.php';
            /* If the contact does not exist, create one. */
            $formatted = array('contact_type' => 'Individual');
            $value = array('email' => $email, 'location_type' =>
                           CRM_Core_BAO_LocationType::getDefaultID());
            _crm_add_formatted_param($value, $formatted);
            $contact =& crm_create_contact_formatted($formatted,
                                                     CRM_IMPORT_PARSER_DUPLICATE_SKIP);

            if (is_a($contact, CRM_Core_Error)) {
                return null;
            }
            $contact_id = $contact->id;
        }

        require_once 'CRM/Core/BAO/Email.php';
        require_once 'CRM/Core/BAO/Location.php';
        require_once 'CRM/Contact/BAO/Contact.php';

        /* Get the primary email id from the contact to use as a hash input */
        $dao =& new CRM_Core_DAO();
        $emailTable = CRM_Core_BAO_Email::getTableName();
        $locTable   = CRM_Core_BAO_Location::getTableName();
        $contactTable = CRM_Contact_BAO_Contact::getTableName();
        $dao->query("SELECT $emailTable.id as email_id
                    FROM $emailTable
                    INNER JOIN $locTable
                        ON  $emailTable.location_id = $locTable.id
                    WHERE   $emailTable.is_primary = 1
                    AND     $locTable.is_primary = 1
                    AND     $locTable.entity_table = '$contactTable'
                    AND     $locTable.entity_id = " 
                            . CRM_Utils_Type::escape($contact_id, 'Integer'));
        $dao->fetch();

        $se =& new CRM_Mailing_Event_BAO_Subscribe();
        $se->group_id = $group_id;
        $se->contact_id = $contact_id;
        $se->time_stamp = date('YmdHis');
        $se->hash = sha1("{$group_id}:{$contact_id}:{$dao->email_id}");
        $se->save();

        $contacts = array($contact_id);
        require_once 'CRM/Contact/BAO/GroupContact.php'; 
        CRM_Contact_BAO_GroupContact::addContactsToGroup($contacts, $group_id,
                                                         'Email', 'Pending', $se->id);
            
        CRM_Core_DAO::transaction('COMMIT');
        return $se;
    }

    /**
     * Verify the hash of a subscription event
     * 
     * @param int $contact_id       ID of the contact
     * @param int $subscribe_id     ID of the subscription event
     * @param string $hash          Hash to verify
     *
     * @return object|null          The subscribe event object, or null on failure
     * @access public
     * @static
     */
      function &verify($contact_id, $subscribe_id, $hash) {
        $se =& new CRM_Mailing_Event_BAO_Subscribe();
        $se->contact_id = $contact_id;
        $se->id = $subscribe_id;
        $se->hash = $hash;
        if ($se->find(true)) {
            return $se;
        }
        return null;
    }

    /**
     * Ask a contact for subscription confirmation (opt-in)
     *
     * @param string $email         The email address
     * @return void
     * @access public
     */
     function send_confirm_request($email) {
        $config =& CRM_Core_Config::singleton();
        require_once 'CRM/Core/BAO/Domain.php';
        $domain =& CRM_Core_BAO_Domain::getCurrentDomain();
        
        require_once 'CRM/Utils/Verp.php';
        $confirm = CRM_Utils_Verp::encode( implode( $config->verpSeparator,
                                                    array( 'confirm',
                                                           $this->contact_id,
                                                           $this->id,
                                                           $this->hash )
                                                    ) . "@{$domain->email_domain}",
                                           $email);
        
        require_once 'CRM/Contact/BAO/Group.php';
        $group =& new CRM_Contact_BAO_Group();
        $group->id = $this->group_id;
        $group->find(true);
        
        require_once 'CRM/Mailing/BAO/Component.php';
        $component =& new CRM_Mailing_BAO_Component();
        $component->domain_id = $domain->id;
        $component->is_default = 1;
        $component->is_active = 1;
        $component->component_type = 'Subscribe';

        $component->find(true);

        $headers = array(
            'Subject'   => $component->subject,
            'From'      => ts('"%1 Administrator" <do-not-reply@%2>', 
                            array(1 => $domain->name, 
                            2 => $domain->email_domain)),
            'To'        => $email,
            'Reply-To'  => $confirm,
            'Return-Path'   => "do-not-reply@{$domain->email_domain}"
        );
        
        $html = $component->body_html;
        require_once 'CRM/Utils/Token.php';
        $html = CRM_Utils_Token::replaceDomainTokens($html, $domain, true);
        $html = CRM_Utils_Token::replaceSubscribeTokens($html, 
                                                        $group->name, true);
        $text = $component->body_text;
        $text = CRM_Utils_Token::replaceDomainTokens($text, $domain, false);
        $text = CRM_Utils_Token::replaceSubscribeTokens($text, 
                                                        $group->name, false);

        $message =& new Mail_Mime("\n");
        $message->setHTMLBody($html);
        $message->setTxtBody($text);
        $b = $message->get();
        $h = $message->headers($headers);
        $mailer =& $config->getMailer();
        
        PEAR::setErrorHandling(PEAR_ERROR_CALLBACK,
                                array('CRM_Mailing_BAO_Mailing', 'catchSMTP'));
        $mailer->send($email, $h, $b);
        CRM_Core_Error::setCallback();
    }

    /**
     * Delete subscription records for a contact
     * 
     * @param int $contactId        ID of the contact being deleted
     * @return none
     * @access public
     * @static
     */
      function deleteContact( $contactId ) {
        $dao =& new CRM_Mailing_Event_DAO_Subscribe();
        $dao->contact_id = $contactId;
        $dao->find();

        require_once 'CRM/Mailing/Event/DAO/Confirm.php';
        $object =& new CRM_Mailing_Event_DAO_Confirm();

        while ($dao->fetch()) {
            $object->reset();
            $object->event_subscribe_id = $dao->id;
            $object->delete();
        }

        $dao->reset();
        $dao->contact_id = $contactId;
        $dao->delete();
    }

    /**
     * Get the domain object given a subscribe event
     * 
     * @param int $subscribe_id     ID of the subscribe event
     * @return object $domain       The domain owning the event
     * @access public
     * @static
     */
      function &getDomain($subscribe_id) {
        $dao =& new  CRM_Core_Dao();

        $subscribe  = CRM_Mailing_Event_BAO_Subscribe::getTableName();

        require_once 'CRM/Contact/BAO/Group.php';
        $group      = CRM_Contact_BAO_Group::getTableName();
        
        $dao->query("SELECT     $group.domain_id as domain_id
                        FROM    $group
                    INNER JOIN  $subscribe
                            ON  $subscribe.group_id = $group.id
                        WHERE   $subscribe.id = " .
                        CRM_Utils_Type::escape($subscribe_id, 'Integer'));
        $dao->fetch();
        if (empty($dao->domain_id)) {
            return null;
        }

        require_once 'CRM/Core/BAO/Domain.php';
        return CRM_Core_BAO_Domain::getDomainById($dao->domain_id);
    }
}

?>

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
 * Class to abstract token replacement 
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */
 
$GLOBALS['_CRM_UTILS_TOKEN']['_requiredTokens'] =  null;
$GLOBALS['_CRM_UTILS_TOKEN']['_tokens'] =  array(
        'action'        => array( 
                            'donate', 
                            'forward', 
                            'optOut', 
                            'reply', 
                            'unsubscribe'
                        ),
        'contact'       => null,  // populate this dynamically
        'domain'        => array( 
                            'name', 
                            'phone', 
                            'address', 
                            'email'
                        ),
        'subscribe'     => array(
                            'group'
                        ),
        'unsubscribe'   => array(
                            'group'
                        ),
        'welcome'       => array(
                            'group'
                        ),
    );

class CRM_Utils_Token {
    
    

    

    
    /**
     * Check a string (mailing body) for required tokens.
     *
     * @param string $str           The message
     * @return true|array           true if all required tokens are found,
     *                              else an array of the missing tokens
     * @access public
     * @static
     */
      function &requiredTokens(&$str) {
        if ($GLOBALS['_CRM_UTILS_TOKEN']['_requiredTokens'] == null) {
            $GLOBALS['_CRM_UTILS_TOKEN']['_requiredTokens'] = array(    
                'domain.address'    => ts("Your organization's postal address"),
                'action.optOut'     => ts("Link to allow contacts to opt out of your organization"), 
                'action.unsubscribe'    => ts("Link to allow contacts to unsubscribe from target groups of this mailing."),
            );
        }

        $missing = array();
        foreach ($GLOBALS['_CRM_UTILS_TOKEN']['_requiredTokens'] as $token => $description) {
            if (! preg_match('/[^\{]'.preg_quote('{' . $token . '}').'/', $str)) {
                $missing[$token] = $description;
            }
        }

        if (empty($missing)) {
            return true;
        }
        return $missing;
    }
    
    /**
     * Wrapper for token matching
     *
     * @param string $type      The token type (domain,mailing,contact,action)
     * @param string $var       The token variable
     * @param string $str       The string to search
     * @return boolean          Was there a match
     * @access public
     * @static
     */
      function token_match($type, $var, &$str) {
        $token  = preg_quote('{' . "$type.$var") 
                . '(\|.+?)?' . preg_quote('}');
        return preg_match("/[^\{]$token/", $str);
    }

    /**
     * Wrapper for token replacing
     *
     * @param string $type      The token type
     * @param string $var       The token variable
     * @param string $value     The value to substitute for the token
     * @param string (reference) $str       The string to replace in
     * @return string           The processed string
     * @access public
     * @static
     */
      function &token_replace($type, $var, $value, &$str) {
        $token  = preg_quote('{' . "$type.$var") 
                . '(\|([^\}]+?))?' . preg_quote('}');
        if (! $value) {
            $value = '$3';
        }
        $str = preg_replace("/([^\{])?$token/", "\${1}$value", $str);
        return $str;
    }
    
    /**
     * Replace all the domain-level tokens in $str
     *
     * @param string $str       The string with tokens to be replaced
     * @param object $domain    The domain BAO
     * @param boolean $html     Replace tokens with HTML or plain text
     * @return string           The processed string
     * @access public
     * @static
     */
      function &replaceDomainTokens($str, &$domain, $html = false)
    {
        require_once 'CRM/Utils/Address.php';
        $loc =& $domain->getLocationValues();
        if (CRM_Utils_Token::token_match('domain', 'address', $str)) {
            $value = null;
            /* Construct the address token */
            if ( CRM_Utils_Array::value( 'address', $loc ) ) {
                $value = CRM_Utils_Address::format($loc['address']);
                if ($html) $value = str_replace("\n", '<br />', $value);
            }
            CRM_Utils_Token::token_replace('domain', 'address', $value, $str);
        }
        
        if (CRM_Utils_Token::token_match('domain', 'name', $str)) {
            CRM_Utils_Token::token_replace('domain', 'name', $domain->name, $str);
        }
        
        /* Construct the phone and email tokens */
        foreach (array('phone', 'email') as $key) {
            if (CRM_Utils_Token::token_match('domain', $key, $str)) {
                $value = null;
                if ( CRM_Utils_Array::value( $key, $loc ) ) {
                    foreach ($loc[$key] as $index => $entity) {
                        if ($entity->is_primary) {
                            $value = $entity->$key;
                            break;
                        }
                    }
                }
                CRM_Utils_Token::token_replace('domain', $key, $value, $str);
            }
        }
        return $str;
    }

    /**
     * Replace all mailing tokens in $str
     *
     * @param string $str       The string with tokens to be replaced
     * @param object $mailing   The mailing BAO, or null for validation
     * @param boolean $html     Replace tokens with HTML or plain text
     * @return string           The processed sstring
     * @access public
     * @static
     */
       function &replaceMailingTokens($str, &$mailing, $html = false) {
        if (CRM_Utils_Token::token_match('mailing', 'name', $str)) {
            CRM_Utils_Token::token_replace('mailing', 'name', 
            $mailing ? $mailing->name : 'Mailing Name', $str);
        }
        if (CRM_Utils_Token::token_match('mailing', 'group', $str)) {
            $groups = $mailing  ? $mailing->getGroupNames() 
                                : array('Mailing Groups');
            $value = implode(', ', $groups);
            CRM_Utils_Token::token_replace('mailing', 'group', $value, $str);
        }
        return $str;
     }

    /**
     * Replace all action tokens in $str
     *
     * @param string $str       The string with tokens to be replaced
     * @param array $addresses  Assoc. array of VERP event addresses
     * @param array $urls       Assoc. array of action URLs
     * @param boolean $html     Replace tokens with HTML or plain text
     * @return string           The processed string
     * @access public
     * @static
     */
      function &replaceActionTokens($str, &$addresses, &$urls, $html = false) {
        foreach ($GLOBALS['_CRM_UTILS_TOKEN']['_tokens']['action'] as $token) {
            if (! CRM_Utils_Token::token_match('action', $token, $str)) {
                continue;
            }

            /* If the token is an email action, use it.  Otherwise, find the
             * appropriate URL */
            if (($value = CRM_Utils_Array::value($token, $addresses)) == null) {
                if (($value = CRM_Utils_Array::value($token, $urls)) == null)
                {
                    continue;
                } 
            } else {
                if ($html) {
                    $value = "mailto:$value";
                }
            }
            CRM_Utils_Token::token_replace('action', $token, $value, $str);
        }
        return $str;
    }


    /**
     * Replace all the contact-level tokens in $str with information from
     * $contact.
     *
     * @param string $str       The string with tokens to be replaced
     * @param array $contact    Associative array of contact properties
     * @param boolean $html     Replace tokens with HTML or plain text
     * @return string           The processed string
     * @access public
     * @static
     */
      function &replaceContactTokens($str, &$contact, $html = false) {
        if ($GLOBALS['_CRM_UTILS_TOKEN']['_tokens']['contact'] == null) {
            /* This should come from UF */
            $GLOBALS['_CRM_UTILS_TOKEN']['_tokens']['contact'] =& 
                array_keys(CRM_Contact_BAO_Contact::importableFields())
                + array('display_name');
        }
        
        $cv =& CRM_Core_BAO_CustomValue::getContactValues($contact['id']);
        foreach ($GLOBALS['_CRM_UTILS_TOKEN']['_tokens']['contact'] as $token) {
            if ($token == '') {
                continue;
            }
            /* If the string doesn't contain this token, skip it. */
            if (! CRM_Utils_Token::token_match('contact', $token, $str)) {
                continue;
            }

            /* Construct value from $token and $contact */
            $value = null;
            
            if ($cfID = CRM_Core_BAO_CustomField::getKeyID($token)) {
                foreach ($cv as $customValue) {
                    if ($customValue->custom_field_id == $cfID) {
                        $value = $customValue->getValue();
                        break;
                    }
                }
            } else {
                $value = CRM_Contact_BAO_Contact::retrieveValue(
                            $contact, $token);
            }
            
            CRM_Utils_Token::token_replace('contact', $token, $value, $str);
        }

        return $str;
    }

    /**
     * Replace unsubscribe tokens
     *
     * @param string $str           the string with tokens to be replaced
     * @param object $domain        The domain BAO
     * @param array $groups         The groups (if any) being unsubscribed
     * @param boolean $html         Replace tokens with html or plain text
     * @param int $contact_id       The contact ID
     * @param string hash           The security hash of the unsub event
     * @return string               The processed string
     * @access public
     * @static
     */
      function &replaceUnsubscribeTokens($str, &$domain, &$groups, $html,
                                                     $contact_id, $hash) 
    {
        if (CRM_Utils_Token::token_match('unsubscribe', 'group', $str)) {
            if (! empty($groups)) {
                $config =& CRM_Core_Config::singleton();
                $base = CRM_Utils_System::baseURL();
                
                if ($html) {
                    $value = '<ul>';
                    foreach ($groups as $gid => $name) {
                        $verpAddress = implode( $config->verpSeparator,
                                                array( 'subscribe',
                                                       $domain->id,
                                                       $gid ) ) . "@{$domain->email_domain}";
                        $value .= "<li>$name (<a href=\"mailto:$verpAddress\">" . ts("re-subscribe") . "</a>)</li>\n";
                    }
                    $value .= '</ul>';
                } else {
                    $value = "\n";
                    foreach ($groups as $gid => $name) {
                        $verpAddress = implode( $config->verpSeparator, 
                                                array( 'subscribe',
                                                       $domain->id,
                                                       $gid ) ) . "@{$domain->email_domain}";
                        $value .= "\t* $name " . ts("(re-subscribe: %1)", array( 1 => "$verpAddress")) . "\n";
                    }
                    $value .= "\n";
                }
                CRM_Utils_Token::token_replace('unsubscribe', 'group', $value, $str);
            }
        }
        return $str;
    }

    /**
     * Replace subscription-confirmation-request tokens
     * 
     * @param string $str           The string with tokens to be replaced
     * @param string $group         The name of the group being subscribed
     * @param boolean $html         Replace tokens with html or plain text
     * @return string               The processed string
     * @access public
     * @static
     */
      function &replaceSubscribeTokens($str, $group, $html) {
        if (CRM_Utils_Token::token_match('subscribe', 'group', $str)) {
            CRM_Utils_Token::token_replace('subscribe', 'group', $group, $str);
        }
        return $str;
    }


    /**
     * Replace welcome/confirmation tokens
     * 
     * @param string $str           The string with tokens to be replaced
     * @param string $group         The name of the group being subscribed
     * @param boolean $html         Replace tokens with html or plain text
     * @return string               The processed string
     * @access public
     * @static
     */
      function &replaceWelcomeTokens($str, $group, $html) {
        if (CRM_Utils_Token::token_match('welcome', 'group', $str)) {
            CRM_Utils_Token::token_replace('welcome', 'group', $group, $str);
        }
        return $str;
    }




    /**
     * Find unprocessed tokens (call this last)
     *
     * @param string $str       The string to search
     * @return array            Array of tokens that weren't replaced
     * @access public
     * @static
     */
      function &unmatchedTokens(&$str) {
        preg_match_all('/[^\{]\{(\w+\.?\w+)\}/', $str, $match);
        return $match[1];
    }
}

?>

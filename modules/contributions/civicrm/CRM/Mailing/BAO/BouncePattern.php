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

$GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'] =  null;

require_once 'CRM/Mailing/DAO/BouncePattern.php';

class CRM_Mailing_BAO_BouncePattern extends CRM_Mailing_DAO_BouncePattern {

    /**
     * Pseudo-constant pattern array
     */
    

    /**
     * class constructor
     */
    function CRM_Mailing_BAO_BouncePattern( ) {
        parent::CRM_Mailing_DAO_BouncePattern( );
    }

    /**
     * Build the static pattern array
     *
     * @return void
     * @access public
     * @static
     */
      function buildPatterns() {
        $GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'] = array();
        $bp =& new CRM_Mailing_BAO_BouncePattern();
        $bp->find();
        
        while ($bp->fetch()) {
            if (! is_array($GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'][$bp->bounce_type_id])) {
                $GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'][$bp->bounce_type_id] = array();
            }
            $GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'][$bp->bounce_type_id][] = $bp->pattern;
        }

        foreach ($GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'] as $type => $patterns) {
            if (count($patterns) == 1) {
                $GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'][$type] = '{(' . $patterns[0] . ')}im';
            } else {
                $GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'][$type]
                    = '{(' . implode(')|(', $patterns) . ')}im';
            }
        }
    }

    /**
     * Try to match the string to a bounce type.
     *
     * @param string $message       The message to be matched
     * @return array                Tuple (bounce_type, bounce_reason)
     * @access public
     * @static
     */
      function &match(&$message) {
        if ($GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'] == null) {
            CRM_Mailing_BAO_BouncePattern::buildPatterns();
        }
        foreach ($GLOBALS['_CRM_MAILING_BAO_BOUNCEPATTERN']['_patterns'] as $type => $re) {
            if (preg_match($re, $message, $matches)) {
                return  array(
                            'bounce_type_id' => $type,
                            'bounce_reason' => $matches[0]
                        );
            }
        }
        
        return  array( 
                    'bounce_type_id' => null, 
                    'bounce_reason' => null 
                );
    }

}

?>

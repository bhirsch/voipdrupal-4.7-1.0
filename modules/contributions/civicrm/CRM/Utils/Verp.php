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
 * Class to handle encoding and decoding Variable Enveleope Return Path (VERP)
 * headers.
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_UTILS_VERP']['encodeMap'] =  array(
        '+' =>  '2B',
        '@' =>  '40',
        ':' =>  '3A',
        '%' =>  '25',
        '!' =>  '21',
        '-' =>  '2D',
        '[' =>  '5B',
        ']' =>  '5D'
    );
$GLOBALS['_CRM_UTILS_VERP']['decodeMap'] =  array(
        '40'    =>  '@',
        '3A'    =>  ':',
        '25'    =>  '%',
        '21'    =>  '!',
        '2D'    =>  '-',
        '5B'    =>  '[',
        '5D'    =>  ']',
        '2B'    =>  '+'
    );

class CRM_Utils_Verp {
    /* Mapping of reserved characters to hex codes */
    
    
    /* Mapping of hex codes to reserved characters */
    

    /**
     * Encode the sender's address with the VERPed recipient.
     *
     * @param string $sender    The address of the sender
     * @param string $recipient The address of the recipient
     * @return string           The VERP encoded address
     * @access public
     * @static
     */
      function encode($sender, $recipient) {
        preg_match('/(.+)\@([^\@]+)$/', $sender, $match);
        $slocal     = $match[1];
        $sdomain    = $match[2];

        preg_match('/(.+)\@([^\@]+)$/', $recipient, $match);
        $rlocal     = $match[1];
        $rdomain    = $match[2];
        
        foreach ($GLOBALS['_CRM_UTILS_VERP']['encodeMap'] as $char => $code) {
            $rlocal     = preg_replace('/'.preg_quote($char).'/i', "+$code", $rlocal);
            $rdomain    = preg_replace('/'.preg_quote($char).'/i', "+$code", $rdomain);
        }

        return "$slocal-$rlocal=$rdomain@$sdomain";
    }
    
    /**
     * Decode the address and return the sender and recipient as an array
     *
     * @param string $address   The address to be decoded
     * @return array            The tuple ($sender, $recipient)
     * @access public
     * @static
     */
      function &verpdecode($address) {
        preg_match('/^(.+)-([^=]+)=([^\@]+)\@(.+)/', $address, $match);

        $slocal     = $match[1];
        $rlocal     = $match[2];
        $rdomain    = $match[3];
        $sdomain    = $match[4];

        foreach ($GLOBALS['_CRM_UTILS_VERP']['decodeMap'] as $code => $char) {
            $rlocal     = preg_replace("/+$code/i", $char, $rlocal);
            $rdomain    = preg_replace("/+$code/i", $char, $rdomain);
        }

        return array( "$slocal@$sdomain", "$rlocal@$rdomain");
    }
}

?>

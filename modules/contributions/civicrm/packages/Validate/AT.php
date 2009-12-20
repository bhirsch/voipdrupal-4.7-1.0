<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 Michael Wallner <mike@iworks.at>                  |
// +----------------------------------------------------------------------+
//
// $Id: AT.php,v 1.6 2004/02/03 23:34:53 neufeind Exp $

/**
* Requires Validate
*/
require_once('Validate.php');

/**
* Validate_AT
*
* @author       Michael Wallner <mike@php.net>
* @package      Validate
* @category     PHP
*
* @version      $Revision: 1.6 $
* @access       public
*/
class Validate_AT
{
    /**
    * Validate postcode ("Postleitzahl")
    *
    * @static
    * @access   public
    * @param    string  postcode to validate
    * @param    bool    optional; strong checks (e.g. against a list of postcodes)
    * @return   bool    true if postcode is ok, false otherwise
    */
    function postcode($postcode, $strong=false)
    {
        if ($strong) {
            static $postcodes;
    
            if (!isset($postcodes)) {
                $file = '/opt/local/lib/php/data/Validate/AT_postcodes.txt';
                $postcodes = array_map('trim', file($file));
            }
    
            return in_array((int) $postcode, $postcodes);
        } else {
            return (ereg('^[0-9]{4}$', $postcode));
        }
    }

    /**
    * Validate SSN
    *
    * "Sozialversicherungsnummer"
    *
    * @static
    * @access   public
    * @param    string  $svn
    * @return   bool
    */
    function ssn($svn)
    {
        $matched = preg_match(
            '/^(\d{3})(\d)\D*(\d{2})\D*(\d{2})\D*(\d{2})$/',
            $svn,
            $matches
        );

        if (!$matched) {
            return false;
        }

        list(, $num, $chk, $d, $m, $y) = $matches;

        if (!Validate::date("$d-$m-$y", array('format' => '%d-%m-%y'))) {
            return false;
        }

        $str = (string) $num . $chk . $d . $m . $y;
        $len = strlen($str);
        $fkt = '3790584216';
        $sum = 0;

        for ($i = 0; $i < $len; $i++) {
            $sum += $str{$i} * $fkt{$i};
        }

        $sum = $sum % 11;
        if ($sum == 10) {
            $sum = 0;
        }

        return ($sum == $chk);
    }
}
?>
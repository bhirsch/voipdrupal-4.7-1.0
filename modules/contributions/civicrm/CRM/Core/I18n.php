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

$GLOBALS['_CRM_CORE_I18N']['_singleton'] =  null;
$GLOBALS['_CRM_CORE_I18N']['locale'] = null;

require_once 'PHPgettext/streams.php';
require_once 'PHPgettext/gettext.php';

/**
 * This is CiviCRM's internationalisation mechanism based on smarty_gettext
 *
 * @package CRM
 * @author Piotr Szotkowski <shot@caltha.pl>
 * @author Michal Mach <mover@artnet.org>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

require_once 'CRM/Core/Config.php';

class CRM_Core_I18n
{

    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     *
     * @var object
     * @static
     */
    

    /**
     * class constructor
     *
     * @access private
     */
    function CRM_Core_I18n()
    {
        // we use PHP-gettext only if the locale's set and it's not en_US
        $config =& CRM_Core_Config::singleton();
        if ($config->lcMessages != '' and $config->lcMessages != 'en_US') {
            $streamer = new FileReader( $config->gettextResourceDir . $config->lcMessages . '/LC_MESSAGES/civicrm.mo' );
            $this->_phpgettext = new gettext_reader($streamer);
        }
    
// commented out, as we're not using PHP's gettext support, but PHP-gettext instead
//      if (function_exists('gettext')) {
//          $config =& CRM_Core_Config::singleton();
//          setlocale(LC_MESSAGES, $config->lcMessages);
//          bindtextdomain($config->gettextDomain, $config->gettextResourceDir);
//          bind_textdomain_codeset($config->gettextDomain, $config->gettextCodeset);
//          textdomain($config->gettextDomain);
//      }
    }

    /**
     * Replace arguments in a string with their values. Arguments are represented by % followed by their number.
     *
     * @param   string Source string
     * @param   mixed  Arguments, can be passed in an array or through single variables.
     * @return  string Modified string
     */
    function strarg($str)
    {
        $tr = array();
        $p = 0;
        for ($i = 1; $i < func_num_args(); $i++) {
            $arg = func_get_arg($i);
            if (is_array($arg)) {
                foreach ($arg as $aarg) {
                    $tr['%'.++$p] = $aarg;
                }
            } else {
                $tr['%'.++$p] = $arg;
            }
        }
        return strtr($str, $tr);
    }

    /**
     * Smarty block function, provides gettext support for smarty.
     *
     * The block content is the text that should be translated.
     *
     * Any parameter that is sent to the function will be represented as %n in the translation text,
     * where n is 1 for the first parameter. The following parameters are reserved:
     *   - escape - sets escape mode:
     *       - 'html' for HTML escaping, this is the default.
     *       - 'js' for javascript escaping.
     *       - 'no'/'off'/0 - turns off escaping
     *   - plural - The plural version of the text (2nd parameter of ngettext())
     *   - count - The item count for plural mode (3rd parameter of ngettext())
     */
    function crm_translate($text, $params)
    {
        // $text = stripslashes($text);

        // set escape mode
        if (isset($params['escape'])) {
            $escape = $params['escape'];
            unset($params['escape']);
        }

        // set plural version
        if (isset($params['plural'])) {
            $plural = $params['plural'];
            unset($params['plural']);

            // set count
            if (isset($params['count'])) {
                $count = $params['count'];
            }
        }

        // bind to config for LC_MESSAGES setting
        $config =& CRM_Core_Config::singleton();

        // use plural if required parameters are set
        if (isset($count) && isset($plural)) {

// commented out, as we're not using PHP's gettext support, but PHP-gettext instead
//          // if there's gettext support, use it
//          if (function_exists('ngettext')) {
//              $text = ngettext($text, $plural, $count);

            // if the locale's set and it's not en_US
            if ($config->lcMessages != '' and $config->lcMessages != 'en_US') {
                $text = $this->_phpgettext->ngettext($text, $plural, $count);

//          // if there's no gettext support, we have to do ngettext work by hand
            // if the locale's empty or en_US, we do ngettext work by hand
            // if $count == 1 then $text = $text, else $text = $plural
            } else {
                if ($count != 1) {
                    $text = $plural;
                }
            }

            // expand %count in translated string to $count
            $text = strtr($text, array('%count' => $count));

        // use normal gettext() if present, otherwise $text = $text
        } else {

// commented out, as we're not using PHP's gettext support, but PHP-gettext instead
//          if (function_exists('gettext')) {
//              $text = gettext($text);
//          }

            if ($config->lcMessages != '' and $config->lcMessages != 'en_US') {
                $text = $this->_phpgettext->translate($text);
            }
        
        }

        // run strarg if there are parameters
        if (count($params)) {
            $text = $this->strarg($text, $params);
        }

        // FIXME escaped until escaping issue is sorted out
        // if (!isset($escape) || $escape == 'html') { // html escape, default
        //     $text = nl2br(htmlspecialchars($text));
        // } elseif (isset($escape) && ($escape == 'javascript' || $escape == 'js')) { // javascript escape
        //     $text = str_replace('\'','\\\'',stripslashes($text));
        // }

        //return '⎰' . $text . '⎱';
        return $text;
    }

    /**
     * translates a string to the current locale
     *
     * @param $string string  this string should be translated
     * @return        string  the translated string
     */
    function translate($string)
    {
        return ( $this->_phpgettext ) ?
            $this->_phpgettext->translate($string) : $string;
    }

    /**
     * Localizes (destructively) array values
     *
     * @param $array array  this array's values should be localized
     * @return void
     */
    function localizeArray(&$array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = $this->_phpgettext->translate($value);
        }
    }

    /**
     * Static instance provider.
     *
     * Method providing static instance of SmartTemplate, as
     * in Singleton pattern.
     */
     function &singleton()
    {
        if (!isset($GLOBALS['_CRM_CORE_I18N']['_singleton'])) {
            $GLOBALS['_CRM_CORE_I18N']['_singleton'] =& new CRM_Core_I18n();
        }
        return $GLOBALS['_CRM_CORE_I18N']['_singleton'];
    }

    /**
     * set the LC_TIME locale if it's not set already
     *
     * @return string  the final LC_TIME that got set
     *
     * @static
     * @access public
     */
     function setLcTime()
    {
        
        if (!isset($GLOBALS['_CRM_CORE_I18N']['locale'])) {

            // with the config being set up to, e.g., pl_PL: try pl_PL.UTF-8 at first,
            // if it's not present try pl_PL, finally - fall back to C
            $config =& CRM_Core_Config::singleton();
            $GLOBALS['_CRM_CORE_I18N']['locale'] = setlocale(LC_TIME, $config->lcMessages . '.UTF-8', $config->lcMessages, 'C');
        }
        return $GLOBALS['_CRM_CORE_I18N']['locale'];
    }

}

// function defined in global scope so it will be available everywhere
function ts($text, $params = array())
{
    $i18n =& CRM_Core_I18n::singleton();
    return $i18n->crm_translate($text, $params);
}

?>

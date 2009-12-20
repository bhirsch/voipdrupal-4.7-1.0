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

/**
 * Soap specific stuff goes here
 */
$GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['uf'] =  null;
$GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['ufClass'] =  null;

class CRM_Utils_System_Soap {

    /** 
     * UF container variables
     */
    
    

    /**
     * sets the title of the page
     *
     * @param string $title title  for page
     *
     * @return void
     * @access public
     */
    function setTitle( $title ) {
        return;
    }

    /**
     * given a permission string, check for access requirements
     *
     * @param string $str the permission to check
     *
     * @return boolean true if yes, else false
     * @static
     * @access public
     */
     function checkPermission( $str ) {
        return true;
    }

    /**
     * Append an additional breadcrumb tag to the existing breadcrumb
     *
     * @param string $bc the new breadcrumb to be appended
     *
     * @return void
     * @access public
     * @static
     */
     function appendBreadCrumb( $bc ) {
        return;
    }

    /**
     * Generate an internal CiviCRM URL
     *
     * @param $path     string   The path being linked to, such as "civicrm/add"
     * @param $query    string   A query string to append to the link.
     * @param $absolute boolean  Whether to force the output to be an absolute link (beginning with http:).
     *                           Useful for links that will be displayed outside the site, such as in an
     *                           RSS feed.
     * @param $fragment string   A fragment identifier (named anchor) to append to the link.
     *
     * @return string            an HTML string containing a link to the given path.
     * @access public
     *
     */
    function url($path = null, $query = null, $absolute = true, $fragment = null ) {
        if (isset($GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['ufClass'])) {
            eval('$url = ' . $GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['ufClass'] . '::url($path, $query, $absolute, $fragment);');
            return $url;
        } else {
            return null;
        }
    }

    /**
     * figure out the post url for the form
     *
     * @param the default action if one is pre-specified
     *
     * @return string the url to post the form
     * @access public
     */
    function postURL( $action ) {
        return null;
    }

    /**
     * Function to set the email address of the user
     *
     * @param object $user handle to the user object
     *
     * @return void
     * @access public
     */
    function setEmail( &$user ) {
    }

    
    /**
     * Authenticate a user against the real UF
     *
     * @param string $name      Login name
     * @param string $pass      Login password
     * @return array            Result array
     * @access public
     * @static
     */
     function &authenticate($name, $pass) {
        if (isset($GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['ufClass'])) {
            eval('$result =& ' . $GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['ufClass'] . '::authenticate($name, $pass);');
            return $result;
        } else {
            return null;
        }
    }

    
    /**
     * Swap the current UF for soap
     *
     * @access public
     * @static
     */
      function swapUF() {
        $config =& CRM_Core_Config::singleton();
        
        $GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['uf']       = $config->userFramework;
        $config->userFramework = 'Soap';
        
        $GLOBALS['_CRM_UTILS_SYSTEM_SOAP']['ufClass']  = $config->userFrameworkClass;
        $config->userFrameworkClass = 'CRM_Utils_System_Soap';
    }
}

?>

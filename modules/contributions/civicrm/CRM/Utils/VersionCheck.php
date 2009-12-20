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
 * Class to check for updated versions of CiviCRM
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_UTILS_VERSIONCHECK_LATEST_VERSION_AT','http://downloads.openngo.org/civicrm/latest-version.txt');
define( 'CRM_UTILS_VERSIONCHECK_CHECK_TIMEOUT',5);
define( 'CRM_UTILS_VERSIONCHECK_LOCALFILE_NAME','civicrm-version.txt');
define( 'CRM_UTILS_VERSIONCHECK_CACHEFILE_NAME','latest-version-cache.txt');
define( 'CRM_UTILS_VERSIONCHECK_CACHEFILE_EXPIRE',86400);
$GLOBALS['_CRM_UTILS_VERSIONCHECK']['_singleton'] =  null;

require_once 'CRM/Core/Config.php';

class CRM_Utils_VersionCheck
{

    
          
                                        // timeout for when the connection or the server is slow
                   // relative to $civicrm_root
              // relative to $config->uploadDir
                                 // cachefile expiry time (in seconds)

    /**
     * We only need one instance of this object, so we use the
     * singleton pattern and cache the instance in this variable
     *
     * @var object
     * @static
     */
    

    /**
     * The version of the current (local) installation
     *
     * @var string
     */
    var $localVersion = null;

    /**
     * The latest version of CiviCRM
     *
     * @var string
     */
    var $latestVersion = null;

    /**
     * Class constructor
     *
     * @access private
     */
    function CRM_Utils_VersionCheck()
    {
        global $civicrm_root;
        $config =& CRM_Core_Config::singleton();

        $localfile = $civicrm_root . DIRECTORY_SEPARATOR . CRM_UTILS_VERSIONCHECK_LOCALFILE_NAME;
        $cachefile = $config->uploadDir . CRM_UTILS_VERSIONCHECK_CACHEFILE_NAME;

        if ($config->versionCheck and file_exists($localfile)) {

            $localParts         = explode(' ', trim(file_get_contents($localfile)));
            $this->localVersion = $localParts[0];
            $expiryTime         = time() - CRM_UTILS_VERSIONCHECK_CACHEFILE_EXPIRE;

            // if there's a cachefile and it's not stale use it to
            // read the latestVersion, else read it from the Internet
            if (file_exists($cachefile) and (filemtime($cachefile) > $expiryTime)) {
                $this->latestVersion = file_get_contents($cachefile);
            } else {
                // we have to set the error handling to a dummy function, otherwise
                // if the URL is not working (e.g., due to our server being down)
                // the users would be presented with an unsuppressable warning
                ini_set('default_socket_timeout', CRM_UTILS_VERSIONCHECK_CHECK_TIMEOUT);
                set_error_handler(array('CRM_Utils_VersionCheck', 'downloadError'));
                $this->latestVersion = file_get_contents(CRM_UTILS_VERSIONCHECK_LATEST_VERSION_AT);
                ini_restore('default_socket_timeout');
                restore_error_handler();

                if (!$this->latestVersion) {
                    return;
                }

                $fp = fopen($cachefile, 'w');
                fwrite($fp, $this->latestVersion);
                fclose($fp);
            }
        }
    }

    /**
     * Static instance provider
     *
     * Method providing static instance of CRM_Utils_VersionCheck,
     * as in Singleton pattern
     *
     * @return CRM_Utils_VersionCheck
     */
     function &singleton()
    {
        if (!isset($GLOBALS['_CRM_UTILS_VERSIONCHECK']['_singleton'])) {
            $GLOBALS['_CRM_UTILS_VERSIONCHECK']['_singleton'] =& new CRM_Utils_VersionCheck();
        }
        return $GLOBALS['_CRM_UTILS_VERSIONCHECK']['_singleton'];
    }

    /**
     * Get the latest version number if it's newer than the local one
     *
     * @return string|null  returns the newer version's number or null if the versions are equal
     */
    function newerVersion()
    {
        $local  = explode('.', $this->localVersion);
        $latest = explode('.', $this->latestVersion);
        // compare by version part; this allows us to use trunk.$rev
        // for trunk versions ('trunk' is greater than '1')
        // we only do major / minor version comparison, so stick to 2
        for ($i = 0; $i < 2; $i++) {
            if ($local[$i] > $latest[$i]) {
                return null;
            } elseif ($local[$i] < $latest[$i]) {
                return $this->latestVersion;
            }
        }
        return null;
    }

    /**
     * A dummy function required for suppressing download errors
     */
    function downloadError($errorNumber, $errorString)
    {
        return;
    }

}

?>

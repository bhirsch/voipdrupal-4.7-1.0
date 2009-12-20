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
 * Config handles all the run time configuration changes that the system needs to deal with.
 * Typically we'll have different values for a user's sandbox, a qa sandbox and a production area.
 * The default values in general, should reflect production values (minimizes chances of screwing up)
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_CORE_CONFIG']['_domainID'] =  1;
$GLOBALS['_CRM_CORE_CONFIG']['_log'] =  null;
$GLOBALS['_CRM_CORE_CONFIG']['_mail'] =  null;
$GLOBALS['_CRM_CORE_CONFIG']['_singleton'] =  null;

require_once 'Log.php';
require_once 'Mail.php';

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/System.php';
require_once 'CRM/Utils/Recent.php';
require_once 'CRM/Utils/Rule.php';
require_once 'CRM/Utils/File.php';
require_once 'CRM/Contact/DAO/Factory.php';
require_once 'CRM/Core/Session.php';

class CRM_Core_Config {

    /**
     * the dsn of the database connection
     * @var string
     */
    var $dsn;

    /** 
     * the debug level for civicrm
     * @var int 
     */ 
    var $debug             = 0; 

    /**
     * the debug level for DB_DataObject
     * @var int
     */
    var $daoDebug		  = 0;

    /**
     * the directory where Smarty and plugins are installed
     * @var string
     */
    var $smartyDir           = '/opt/local/lib/php/Smarty/';
    var $pluginsDir          = '/opt/local/lib/php/Smarty/plugins/';

    /**
     * the root directory of our template tree
     * @var string
     */
    var $templateDir		  = './templates';

    /**
     * The root directory where Smarty should store
     * compiled files
     * @var string
     */
    var $templateCompileDir  = './templates_c';

    /**
     * The root url of our application. Used when we don't
     * know where to redirect the application flow
     * @var string
     */
    var $mainMenu            = 'http://localhost/drupal/';

    /**
     * The resourceBase of our application. Used when we want to compose
     * url's for things like js/images/css
     * @var string
     */
    var $resourceBase        = "http://localhost/drupal/crm/";

    /**
     * the factory class used to instantiate our DB objects
     * @var string
     */
    var $DAOFactoryClass	  = 'CRM_Contact_DAO_Factory';

    /**
     * The directory to store uploaded files
     */
    var $uploadDir         = './upload/';
    
    /**
     * The directory to store uploaded image files
     */
    var $imageUploadDir   ='./persist/contribute/';
    
    /**
     * The url that we can use to display the uploaded images
     */
    var $imageUploadURL   = null;
    
    /**
     * Are we generating clean url's and using mod_rewrite
     * @var string
     */
    var $cleanURL = false;

    /**
     * List of country codes limiting the country list.
     * @var string
     */
    var $countryLimit = array();

    /**
     * List of country codes limiting the province list.
     * @var string
     */
    var $provinceLimit = array( 'US' );

    /**
     * ISO code of default country for contact.
     * @var int
     */
    var $defaultContactCountry = 'US';

    /**
     * ISO code of default currency.
     * @var int
     */
    var $defaultCurrency = 'USD';

    /**
     * Locale for the application to run with.
     * @var string
     */
    var $lcMessages = 'en_US';

    /**
     * The format of the address fields.
     * @var string
     */
    var $addressFormat = "{street_address}\n{supplemental_address_1}\n{supplemental_address_2}\n{city}{, }{state_province}{ }{postal_code}\n{country}";


    /**
     * The sequence of the address fields.
     * @var string
     */
    var $addressSequence = array('street_address', 'supplemental_address_1', 'supplemental_address_2', 'city', 'state_province', 'postal_code', 'country');

    /**
     * String format for date+time
     * @var string
     */
    var $dateformatDatetime = '%B %E%f, %Y %l:%M %P';

    /**
     * String format for a full date (one with day, month and year)
     * @var string
     */
    var $dateformatFull = '%B %E%f, %Y';

    /**
     * String format for a partial date (one with month and year)
     * @var string
     */
    var $dateformatPartial = '%B %Y';

    /**
     * String format for a year-only date
     * @var string
     */
    var $dateformatYear = '%Y';

    /**
     * String format for date QuickForm drop-downs
     * @var string
     */
    var $dateformatQfDate = '%b %d %Y';

    /**
     * String format for date and time QuickForm drop-downs
     * @var string
     */
    var $dateformatQfDatetime = '%b %d %Y, %I : %M %P';

    /**
     * String format for monetary values
     * @var string
     */
    var $moneyformat = '%c %a';

    /**
     * Format for monetary amounts
     * @var string
     */
    var $lcMonetary = 'en_US';

    /**
     * Default encoding of strings returned by gettext
     * @var string
     */
    var $gettextCodeset = 'utf-8';


    /**
     * Default name for gettext domain.
     * @var string
     */
    var $gettextDomain = 'civicrm';

    /**
     * Default location of gettext resource files.
     */
    var $gettextResourceDir = './l10n/';

    /**
     * Default smtp server and port
     */
    var $smtpServer         = null;
    var $smtpPort           = 25;
    var $smtpAuth           = false;
    var $smtpUsername       = null;
    var $smtpPassword       = null;

    /**
     * Default user framework
     */
    var $userFramework               = 'Drupal';
    var $userFrameworkVersion        = 4.6;
    var $userFrameworkClass          = 'CRM_Utils_System_Drupal';
    var $userHookClass               = 'CRM_Utils_Hook_Drupal';
    var $userPermissionClass         = 'CRM_Core_Permission_Drupal';
    var $userFrameworkURLVar         = 'q';
    var $userFrameworkDSN            = null;
    var $userFrameworkUsersTableName = 'users';
    var $userFrameworkBaseURL        = null;
    var $userFrameworkResourceURL    = null;
    var $userFrameworkFrontend       = false;

    /**
     * The default mysql version that we are using
     */
    var $mysqlVersion = 4.1;

    /**
     * Mysql path
     */
    var $mysqlPath = '/usr/bin/';

    /**
     * the handle for import file size 
     * @var int
     */
    var $maxImportFileSize = 1048576;

    /**
     * Map Provider 
     *
     * @var boolean
     */
    var $mapProvider = null;

    /**
     * Map API Key 
     *
     * @var boolean
     */
    var $mapAPIKey = null;
    
    /**
     * How should we get geo code information if google map support needed
     *
     * @var boolean
     */
    var $geocodeMethod    = '';

    /**
     * Whether CiviCRM should check for newer versions
     *
     * @var boolean
     */
    var $versionCheck = false;

    /**
     * How long should we wait before checking for new outgoing mailings?
     *
     * @var int
     */
    var $mailerPeriod    = 180;

    /**
     * What should be the verp separator we use
     *
     * @var char
     */
    var $verpSeparator = '.';

    /**
     * Array of enabled add-on components (e.g. CiviContribute, CiviMail...)
     *
     * @var array
     */
    var $enableComponents = array();

    /**
     * Should payments be accepted only via SSL?
     *
     * @var boolean
     */
    var $enableSSL = false;

    /**
     * the domainID for this instance. 
     *
     * @var int
     */
    

    /**
     * The handle to the log that we are using
     * @var object
     */
    

    /**
     * the handle on the mail handler that we are using
     * @var object
     */
    

    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     * @var object
     * @static
     */
    


    /**
     * singleton function used to manage this object
     *
     * @param string the key in which to record session / log information
     *
     * @return object
     * @static
     *
     */
     function &singleton($key = 'crm') {
        if ($GLOBALS['_CRM_CORE_CONFIG']['_singleton'] === null ) {
            $GLOBALS['_CRM_CORE_CONFIG']['_singleton'] =& new CRM_Core_Config($key);
        }
        return $GLOBALS['_CRM_CORE_CONFIG']['_singleton'];
    }

    /**
     * The constructor. Basically redefines the class variables if
     * it finds a constant definition for that class variable
     *
     * @return object
     * @access private
     */
    function CRM_Core_Config() {
        require_once 'CRM/Core/Session.php';
        $session =& CRM_Core_Session::singleton( );
        if ( defined( 'CIVICRM_DOMAIN_ID' ) ) {
            $GLOBALS['_CRM_CORE_CONFIG']['_domainID'] = CIVICRM_DOMAIN_ID;
        } else {
            $GLOBALS['_CRM_CORE_CONFIG']['_domainID'] = 1;
        }
        $session->set( 'domainID', $GLOBALS['_CRM_CORE_CONFIG']['_domainID'] );

        // we figure this out early, since some config parameters are loaded
        // based on what components are enabled
        if ( defined( 'ENABLE_COMPONENTS' ) ) {
            $this->enableComponents = explode(',', ENABLE_COMPONENTS);
            for ( $i=0; $i < count($this->enableComponents); $i++) {
                $this->enableComponents[$i] = trim($this->enableComponents[$i]);
            }
        }
        
        if (defined('CIVICRM_DSN')) {
            $this->dsn = CIVICRM_DSN;
        }

        if (defined('UF_DSN')) {
            $this->ufDSN = UF_DSN;
        }

        if (defined('UF_USERTABLENAME')) {
            $this->ufUserTableName = UF_USERTABLENAME;
        }

        if (defined('CIVICRM_DEBUG') ) {
            $this->debug = CIVICRM_DEBUG;
        }

        if (defined('CIVICRM_DAO_DEBUG') ) {
            $this->daoDebug = CIVICRM_DAO_DEBUG;
        }

        if (defined('CIVICRM_DAO_FACTORY_CLASS') ) {
            $this->DAOFactoryClass = CIVICRM_DAO_FACTORY_CLASS;
        }

        if (defined('CIVICRM_SMARTYDIR')) {
            $this->smartyDir = CIVICRM_SMARTYDIR;
        }

        if (defined('CIVICRM_PLUGINSDIR')) {
            $this->pluginsDir = CIVICRM_PLUGINSDIR;
        }

        if (defined('CIVICRM_TEMPLATEDIR')) {
            $this->templateDir = CIVICRM_TEMPLATEDIR;
        }

        if (defined('CIVICRM_TEMPLATE_COMPILEDIR')) {
            $this->templateCompileDir = CIVICRM_TEMPLATE_COMPILEDIR;

            // make sure this directory exists
            CRM_Utils_File::createDir( $this->templateCompileDir );
        }

        if ( defined( 'CIVICRM_RESOURCEBASE' ) ) {
            $this->resourceBase = CRM_Core_Config::addTrailingSlash( CIVICRM_RESOURCEBASE, '/' );
        }

        if ( defined( 'CIVICRM_UPLOADDIR' ) ) {
            $this->uploadDir = CRM_Core_Config::addTrailingSlash( CIVICRM_UPLOADDIR );

            CRM_Utils_File::createDir( $this->uploadDir );
        }

        if ( defined( 'CIVICRM_IMAGE_UPLOADDIR' ) ) {
            $this->imageUploadDir = CRM_Core_Config::addTrailingSlash( CIVICRM_IMAGE_UPLOADDIR );

            CRM_Utils_File::createDir( $this->imageUploadDir );
        }

        if ( defined( 'CIVICRM_IMAGE_UPLOADURL' ) ) {
            $this->imageUploadURL = CRM_Core_Config::addTrailingSlash( CIVICRM_IMAGE_UPLOADURL, '/' );
        }

        if ( defined( 'CIVICRM_CLEANURL' ) ) {
            $this->cleanURL = CIVICRM_CLEANURL;
        }

        if ( defined( 'CIVICRM_COUNTRY_LIMIT' ) ) {
            $isoCodes = preg_split('/[^a-zA-Z]/', CIVICRM_COUNTRY_LIMIT);
            $this->countryLimit = array_filter($isoCodes);
        }
        
        if ( defined( 'CIVICRM_PROVINCE_LIMIT' ) ) {
            $isoCodes = preg_split('/[^a-zA-Z]/', CIVICRM_PROVINCE_LIMIT);
            $provinceLimitList = array_filter($isoCodes);
            if ( !empty($provinceLimitList)) {
                $this->provinceLimit = array_filter($isoCodes);
            }
        } 
        
        // Note: we can't change the ISO code to country_id
        // here, as we can't access the database yet...
        if ( defined( 'CIVICRM_DEFAULT_CONTACT_COUNTRY' ) ) {
            $this->defaultContactCountry = CIVICRM_DEFAULT_CONTACT_COUNTRY;
        }
        
        if ( defined( 'CIVICONTRIBUTE_DEFAULT_CURRENCY' ) and CRM_Utils_Rule::currencyCode( CIVICONTRIBUTE_DEFAULT_CURRENCY ) ) {
            $this->defaultCurrency = CIVICONTRIBUTE_DEFAULT_CURRENCY;
        }        
        
        if ( defined( 'CIVICRM_LC_MESSAGES' ) ) {
            $this->lcMessages = CIVICRM_LC_MESSAGES;
        }
        
        if ( defined( 'CIVICRM_ADDRESS_FORMAT' ) ) {

            // trim the format and unify line endings to LF
            $format = trim(CIVICRM_ADDRESS_FORMAT);
            $format = str_replace(array("\r\n", "\r"), "\n", $format);

            // get the field sequence from the format
            $newSequence = array();
            foreach($this->addressSequence as $field) {
                if (substr_count($format, $field)) {
                    $newSequence[strpos($format, $field)] = $field;
                }
            }
            ksort($newSequence);

            // add the addressSequence fields that are missing in the addressFormat
            // to the end of the list, so that (for example) if state_province is not
            // specified in the addressFormat it's still in the address-editing form
            $newSequence = array_merge($newSequence, $this->addressSequence);
            $newSequence = array_unique($newSequence);

            $this->addressSequence = $newSequence;
            $this->addressFormat   = $format;
        }
        
        if ( defined( 'CIVICRM_DATEFORMAT_DATETIME' ) ) {
            $this->dateformatDatetime = CIVICRM_DATEFORMAT_DATETIME;
        }
        
        if ( defined( 'CIVICRM_DATEFORMAT_FULL' ) ) {
            $this->dateformatFull = CIVICRM_DATEFORMAT_FULL;
        }
        
        if ( defined( 'CIVICRM_DATEFORMAT_PARTIAL' ) ) {
            $this->dateformatPartial = CIVICRM_DATEFORMAT_PARTIAL;
        }
        
        if ( defined( 'CIVICRM_DATEFORMAT_YEAR' ) ) {
            $this->dateformatYear = CIVICRM_DATEFORMAT_YEAR;
        }
        
        if ( defined( 'CIVICRM_DATEFORMAT_QF_DATE' ) ) {
            $this->dateformatQfDate = CIVICRM_DATEFORMAT_QF_DATE;
        }
        
        if ( defined( 'CIVICRM_DATEFORMAT_QF_DATETIME' ) ) {
            $this->dateformatQfDatetime = CIVICRM_DATEFORMAT_QF_DATETIME;
        }

        if ( defined( 'CIVICRM_MONEYFORMAT' ) ) {
            $this->moneyformat = CIVICRM_MONEYFORMAT;
        }

        if ( defined( 'CIVICRM_LC_MONETARY' ) ) {
            $this->lcMonetary = CIVICRM_LC_MONETARY;
            setlocale(LC_MONETARY, $this->lcMonetary . '.UTF-8', $this->lcMonetary, 'C');
        }
        
        if ( defined( 'CIVICRM_GETTEXT_CODESET' ) ) {
            $this->gettextCodeset = CIVICRM_GETTEXT_CODESET;
        }
        
        if ( defined( 'CIVICRM_GETTEXT_DOMAIN' ) ) {
            $this->gettextDomain = CIVICRM_GETTEXT_DOMAIN;
        }
        
        if ( defined( 'CIVICRM_GETTEXT_RESOURCEDIR' ) ) {
            $this->gettextResourceDir = CRM_Core_Config::addTrailingSlash( CIVICRM_GETTEXT_RESOURCEDIR );
        }

        if ( defined( 'CIVICRM_SMTP_SERVER' ) ) {
            $this->smtpServer = CIVICRM_SMTP_SERVER;
        }

        if ( defined( 'CIVICRM_SMTP_PORT' ) ) {
            $this->smtpPort = CIVICRM_SMTP_PORT;
        }

        if ( defined( 'CIVICRM_SMTP_AUTH' )) {
            if (CIVICRM_SMTP_AUTH === true) {
                $this->smtpAuth = true;
            } // else it stays false
        }

        if ( defined( 'CIVICRM_SMTP_USERNAME' ) ) {
            $this->smtpUsername = CIVICRM_SMTP_USERNAME;
        }

        if ( defined( 'CIVICRM_SMTP_PASSWORD' ) ) {
            $this->smtpPassword = CIVICRM_SMTP_PASSWORD;
        }

        if ( defined( 'CIVICRM_UF' ) ) {
            $this->userFramework       = CIVICRM_UF;
            $this->userFrameworkClass  = 'CRM_Utils_System_'    . $this->userFramework;
            $this->userHookClass       = 'CRM_Utils_Hook_'      . $this->userFramework;
            $this->userPermissionClass = 'CRM_Core_Permission_' . $this->userFramework;
        }

        if ( defined( 'CIVICRM_UF_VERSION' ) ) {
            $this->userFrameworkVersion = (float ) CIVICRM_UF_VERSION;
        }

        if ( defined( 'CIVICRM_UF_URLVAR' ) ) {
            $this->userFrameworkURLVar = CIVICRM_UF_URLVAR;
        }

        if ( defined( 'CIVICRM_UF_DSN' ) ) { 
            $this->userFrameworkDSN = CIVICRM_UF_DSN;
        }

        if ( defined( 'CIVICRM_UF_USERSTABLENAME' ) ) {
            $this->userFrameworkUsersTableName = CIVICRM_UF_USERSTABLENAME;
        }

        if ( defined( 'CIVICRM_UF_BASEURL' ) ) {
            $this->userFrameworkBaseURL = CRM_Core_Config::addTrailingSlash( CIVICRM_UF_BASEURL, '/' );
        }

        if ( defined( 'CIVICRM_UF_RESOURCEURL' ) ) {
            $this->userFrameworkResourceURL = CRM_Core_Config::addTrailingSlash( CIVICRM_UF_RESOURCEURL, '/' );
        }

        if ( defined( 'CIVICRM_UF_FRONTEND' ) ) {
            $this->userFrameworkFrontend = CIVICRM_UF_FRONTEND;
        }

        if ( defined( 'CIVICRM_MYSQL_VERSION' ) ) {
            $this->mysqlVersion = CIVICRM_MYSQL_VERSION;
        }

        if ( defined( 'CIVICRM_MYSQL_PATH' ) ) {
            $this->mysqlPath = CIVICRM_MYSQL_PATH;
        }

        $size = trim( ini_get( 'upload_max_filesize' ) );
        if ( $size ) {
            $last = strtolower($size{strlen($size)-1});
            switch($last) {
                // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
            }
            $this->maxImportFileSize = $size;
        }

        if ( defined( 'CIVICRM_MAP_PROVIDER' ) ) {
            $this->mapProvider = CIVICRM_MAP_PROVIDER;
        }

        if ( defined( 'CIVICRM_MAP_API_KEY' ) ) {
            $this->mapAPIKey = CIVICRM_MAP_API_KEY;
        }


        if ( defined( 'CIVICRM_GEOCODE_METHOD' ) ) {
            if ( CIVICRM_GEOCODE_METHOD == 'CRM_Utils_Geocode_ZipTable' ||
                 CIVICRM_GEOCODE_METHOD == 'CRM_Utils_Geocode_RPC'      ||
                 CIVICRM_GEOCODE_METHOD == 'CRM_Utils_Geocode_Yahoo' ) {
                $this->geocodeMethod = CIVICRM_GEOCODE_METHOD;
            }
        }

        if (defined('CIVICRM_VERSION_CHECK') and CIVICRM_VERSION_CHECK) {
            $this->versionCheck = true;
        }

        if ( defined( 'CIVICRM_MAILER_SPOOL_PERIOD' ) ) {
            $this->mailerPeriod = CIVICRM_MAILER_SPOOL_PERIOD;
        }

        if ( defined( 'CIVICRM_VERP_SEPARATOR' ) ) {
            $this->verpSeparator = CIVICRM_VERP_SEPARATOR;
        }

        if ( defined( 'CIVICRM_ENABLE_SSL' ) ) {
            $this->enableSSL = CIVICRM_ENABLE_SSL;
        }

        if ( in_array( 'CiviContribute', $this->enableComponents ) ) {
            require_once 'CRM/Contribute/Config.php';
            CRM_Contribute_Config::add( $this );
        }

        if ( in_array( 'CiviSMS', $this->enableComponents ) ) {
            require_once 'CRM/SMS/Config.php';
            CRM_SMS_Config::add( $this );
        }

        // initialize the framework
        $this->initialize();
    }

    /**
     * initializes the entire application. Currently we only need to initialize
     * the dataobject framework
     *
     * @return void
     * @access public
     */
    function initialize() {
        $this->initDAO();

        // also initialize the logger
        $GLOBALS['_CRM_CORE_CONFIG']['_log'] =& Log::singleton( 'display' );

        // set the error callback
        CRM_Core_Error::setCallback();
    }

    /**
     * initialize the DataObject framework
     *
     * @return void
     * @access private
     */
    function initDAO() {
        CRM_Core_DAO::init(
                      $this->dsn, 
                      $this->daoDebug
                      );

        $factoryClass = $this->DAOFactoryClass;
        CRM_Core_DAO::setFactory(new $factoryClass());
    }

    /**
     * returns the singleton logger for the applicationthe singleton logger for the application
     *
     * @param
     * @access private
     * @return object
     */
     function &getLog() {
        if ( ! isset( $GLOBALS['_CRM_CORE_CONFIG']['_log'] ) ) {
            $GLOBALS['_CRM_CORE_CONFIG']['_log'] =& Log::singleton( 'display' );
        }

        return $GLOBALS['_CRM_CORE_CONFIG']['_log'];
    }

    /**
     * retrieve a mailer to send any mail from the applciation
     *
     * @param
     * @access private
     * @return object
     */
     function &getMailer( ) {
        if ( ! isset( $GLOBALS['_CRM_CORE_CONFIG']['_mail'] ) ) {
            $params['host'] = $GLOBALS['_CRM_CORE_CONFIG']['_singleton']->smtpServer;
            $params['port'] = $GLOBALS['_CRM_CORE_CONFIG']['_singleton']->smtpPort;

            if ($GLOBALS['_CRM_CORE_CONFIG']['_singleton']->smtpAuth) {
                $params['username'] = $GLOBALS['_CRM_CORE_CONFIG']['_singleton']->smtpUsername;
                $params['password'] = $GLOBALS['_CRM_CORE_CONFIG']['_singleton']->smtpPassword;
                $params['auth']     = true;
            } else {
                $params['auth']     = false;
            }

            $GLOBALS['_CRM_CORE_CONFIG']['_mail'] =& Mail::factory( 'smtp', $params );
        }
        return $GLOBALS['_CRM_CORE_CONFIG']['_mail'];
    }

    /**
     * get the domain Id of the current user
     *
     * @param
     * @access private
     * @return int
     */
     function domainID( ) {
        return $GLOBALS['_CRM_CORE_CONFIG']['_domainID'];
    }

    /**
     * delete the web server writable directories
     *
     * @param int $value 1 - clean templates_c, 2 - clean upload, 3 - clean both
     *
     * @access public
     * @return void
     */
     function cleanup( $value ) {
        $value = (int ) $value;

        if ( $value & 1 ) {
            // clean templates_c
            CRM_Utils_File::cleanDir( $this->templateCompileDir );
        }
        if ( $value & 2 ) {
            // clean upload dir
            CRM_Utils_File::cleanDir( $this->uploadDir );
        }
    }


    /**
     * verify that the needed parameters are not null in the config
     *
     * @param CRM_Core_Config (reference ) the system config object
     * @param array           (reference ) the parameters that need a value
     *
     * @return boolean
     * @static
     * @access public
     */
     function check( &$config, &$required ) {
        foreach ( $required as $name ) {
            if ( CRM_Utils_System::isNull( $config->$name ) ) {
                return false;
            }
        }
        return true;
    }

     function addTrailingSlash( $name, $separator = null ) {
        if ( ! $separator ) {
            $separator = DIRECTORY_SEPARATOR;
        }
            
        if ( substr( $name, -1, 1 ) != $separator ) {
            $name .= $separator;
        }
        return $name;
    }

} // end CRM_Core_Config

?>

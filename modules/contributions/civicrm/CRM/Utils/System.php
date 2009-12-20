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

$GLOBALS['_CRM_UTILS_SYSTEM']['php4SpecialClassName'] =  array(
                                                'crm'                => 'CRM',
                                                'acceptcreditcard'   => 'AcceptCreditCard',
                                                'activityhistory'    => 'ActivityHistory',
                                                'addtogroup'         => 'AddToGroup',
                                                'addtohousehold'     => 'AddToHousehold',
                                                'addtoorganization'  => 'AddToOrganization',
                                                'addtotag'           => 'AddToTag',
                                                'addproduct'         => 'AddProduct',
                                                'api'                => 'API',
                                                'at'                 => 'AT',
                                                'activitytype'       => 'ActivityType',
                                                'bao'                => 'BAO',
                                                'basiccriteria'      => 'BasicCriteria',
                                                'createppd'          => 'CreatePPD',
                                                'customdata'         => 'CustomData',
                                                'customfield'        => 'CustomField',
                                                'customgroup'        => 'CustomGroup',
                                                'customoption'       => 'CustomOption',
                                                'customvalue'        => 'CustomValue',
                                                'contributionpage'   => 'ContributionPage',
                                                'contributionpageedit'=> 'ContributionPageEdit',
                                                'contributiontype'   => 'ContributionType',
                                                'dupematch'          => 'DupeMatch', 
                                                'dashboard'          => 'DashBoard',
                                                'dao'                => 'DAO',
                                                'deletefield'        => 'DeleteField', 
                                                'deletegroup'        => 'DeleteGroup', 
                                                'donationpage'       => 'DonationPage',
                                                'emailhistory'       => 'EmailHistory',
                                                'entitycategory'     => 'EntityCategory',
                                                'entitytag'          => 'EntityTag',
                                                'emptyresults'       => 'EmptyResults',
                                                'geocoord'           => 'GeoCoord',
                                                'groupcontact'       => 'GroupContact',
                                                'gmapsinput'         => 'GMapsInput',
                                                'im'                 => 'IM',
                                                'improvider'         => 'IMProvider',
                                                'locationtype'       => 'LocationType',
                                                'managepremiums'     => 'ManagePremiums',
                                                'mapfield'           => 'MapField',
                                                'mobileprovider'     => 'MobileProvider',
                                                'pseudoconstant'     => 'PseudoConstant',
                                                'pagerAToZ'          => 'pagerAToZ',//not needed here 
                                                'paymentinstrument'  => 'PaymentInstrument',
                                                'relationshiptype'   => 'RelationshipType',
                                                'removefromgroup'    => 'RemoveFromGroup',
                                                'removefromtag'      => 'RemoveFromTag',
                                                'savedsearch'        => 'SavedSearch',
                                                'savesearch'         => 'SaveSearch',
                                                'selectvalues'       => 'SelectValues',
                                                'showhideblocks'     => 'ShowHideBlocks',
                                                'statemachine'       => 'StateMachine',
                                                'stateprovince'      => 'StateProvince',
                                                'ufformfield'        => 'UFFormField',
                                                'ufform'             => 'UFForm',
                                                'ufmatch'            => 'UFMatch',
                                                'uploadfile'         => 'UploadFile',
                                                'uf'                 => 'UF',
                                                'otheractivity'      => 'OtherActivity',
                                                'selectfield'        => 'SelectField',
                                                'individualprefix'   => 'IndividualPrefix',
                                                'individualsuffix'   => 'IndividualSuffix',
                                                'versioncheck'       => 'VersionCheck',
                                                'thankyou'           => 'ThankYou',
                                                );
$GLOBALS['_CRM_UTILS_SYSTEM']['version'] = null;

require_once 'CRM/Utils/System/Drupal.php';
require_once 'CRM/Utils/System/Mambo.php' ;

/**
 * System wide utilities.
 *
 */
class CRM_Utils_System {

    /**
     * special cases for php4
     * @var array
     * @static
     */
    
    
    /**
     * Compose a new url string from the current url string
     * Used by all the framework components, specifically,
     * pager, sort and qfc
     *
     * @param string $urlVar the url variable being considered (i.e. crmPageID, crmSortID etc)
     *
     * @return string the url fragment
     * @access public
     */
     function makeURL( $urlVar ) {
        $config   =& CRM_Core_Config::singleton( );
        return CRM_Utils_System::url( $_GET[$config->userFrameworkURLVar],
                          CRM_Utils_System::getLinksUrl( $urlVar ) );
    }

    /**
     * get the query string and clean it up. Strip some variables that should not
     * be propagated, specically variable like 'reset'. Also strip any side-affect
     * actions (i.e. export)
     *
     * This function is copied mostly verbatim from Pager.php (_getLinksUrl)
     *
     * @param string  $urlVar       the url variable being considered (i.e. crmPageID, crmSortID etc)
     * @param boolean $includeReset should we include the reset var (generally this variable should be skipped)
     * @return string
     * @access public
     */
     function getLinksUrl( $urlVar, $includeReset = false ) {
        // Sort out query string to prevent messy urls
        $querystring = array();
        $qs          = array();
        $arrays      = array();

        if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
            $qs = explode('&', str_replace( '&amp;', '&', $_SERVER['QUERY_STRING'] ) );
            for ($i = 0, $cnt = count($qs); $i < $cnt; $i++) {
                if ( strstr( $qs[$i], '=' ) !== false ) { // check first if exist a pair
                    list($name, $value) = explode( '=', $qs[$i] );
                    if ( $name != $urlVar ) {
                        $name = rawurldecode($name);
                        //check for arrays in parameters: site.php?foo[]=1&foo[]=2&foo[]=3
                        if ((strpos($name, '[') !== false) &&
                            (strpos($name, ']') !== false)
                            ) {
                            $arrays[] = $qs[$i];
                        } else {
                            $qs[$name] = $value;
                        }
                    }
                } else {
                    $qs[$qs[$i]] = '';
                }
                unset( $qs[$i] );
            }
        }

        // add force=1 to force a recompute
        $qs['force'] = 1;
        foreach ($qs as $name => $value) {
            if ( $name != 'reset' || $includeReset ) {
                $querystring[] = $name . '=' . $value;
            }
        }

        $querystring = array_merge($querystring, array_unique($arrays));
        $querystring = array_map('htmlentities', $querystring);

        return implode('&amp;', $querystring) . (! empty($querystring) ? '&amp;' : '') . $urlVar .'=';
    }

    /**
     * if we are using a theming system, invoke theme, else just print the
     * content
     *
     * @param string  $type    name of theme object/file
     * @param string  $content the content that will be themed
     * @param array   $args    the args for the themeing function if any
     * @param boolean $print   are we displaying to the screen or bypassing theming?
     * 
     * @return void           prints content on stdout
     * @access public
     */
    function theme( $type, &$content, $args = null, $print = false ) {
        if ( function_exists( 'theme' ) && ! $print ) {
            print theme( $type, $content, $args );
        } else {
            print $content;
        }
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
    function url($path = null, $query = null, $absolute = true, $fragment = null, $htmlize = true ) {
        // we have a valid query and it has not yet been transformed
        if ( $htmlize && ! empty( $query ) && strpos( $query, '&amp;' ) === false ) {
            $query = htmlentities( $query );
        }

        $config   =& CRM_Core_Config::singleton( );
        return eval( 'return ' . $config->userFrameworkClass . '::url( $path, $query, $absolute, $fragment, $htmlize );' );

    }

    /**
     * What menu path are we currently on. Called for the primary tpl
     *
     * @return string the current menu path
     * @access public
     */
     function currentPath( ) {
        $config =& CRM_Core_Config::singleton( );
        return trim( $_GET[$config->userFrameworkURLVar], '/' );
    }

    /**
     * this function is called from a template to compose a url
     *
     * @param array $params list of parameters
     * 
     * @return string url
     * @access public
     */
    function crmURL( $params ) {
        $p = CRM_Utils_Array::value( 'p', $params );
        if ( ! isset( $p ) ) {
            $p = CRM_Utils_System::currentPath( );
        }

        return CRM_Utils_System::url( $p,
                          CRM_Utils_Array::value( 'q', $params ),
                          CRM_Utils_Array::value( 'a', $params, true ),
                          CRM_Utils_Array::value( 'f', $params ) );
    }

    /**
     * sets the title of the page
     *
     * @param string $title
     *
     * @return void
     * @access public
     */
    function setTitle( $title ) {
        $config   =& CRM_Core_Config::singleton( );
        return eval( $config->userFrameworkClass . '::setTitle( $title );' );
    }

    /**
     * figures and sets the userContext. Uses the referer if valid
     * else uses the default
     *
     * @param array  $names   refererer should match any str in this array
     * @param string $default the default userContext if no match found
     *
     * @return void
     * @access public
     */
     function setUserContext( $names, $default = null ) {
        $url = $default;

        $session =& CRM_Core_Session::singleton();
        $referer = CRM_Utils_Array::value( 'HTTP_REFERER', $_SERVER );

        if ( $referer && ! empty( $names ) ) {
            foreach ( $names as $name ) {
                if ( strstr( $referer, $name ) ) {
                    $url = $referer;
                    break;
                }
            }
        }

        if ( $url ) {
            $session->pushUserContext( $url );
        }
    }


    /**
     * gets a class name for an object
     *
     * This is used primarily by the PHP4 code since the
     * get_class($this) in php4 returns the class name in lowercases.
     *
     * We need to do some conversions before we can use the lower case class names.
     *
     * @param  object $object      - object whose class name is needed
     * @return string $className   - class name
     *
     * @access public
     * @static
     */
     function getClassName($object)
    {
        $className = get_class($object);
        if (!CRM_Utils_System::isPHP4()) {
            return $className;
        }

        // we are in php4 now
        // get all components of the class name
        $classNameComponent = explode("_", $className);
        foreach ($classNameComponent as $k => $v) {
            $v =& $classNameComponent[$k];
            if (array_key_exists($v, $GLOBALS['_CRM_UTILS_SYSTEM']['php4SpecialClassName'])) {
                $v = $GLOBALS['_CRM_UTILS_SYSTEM']['php4SpecialClassName'][$v]; // special case hence replace
            } else {
                $v = ucfirst($v); // regular component so just upcase first character
            }
            unset($v);
        }

        // create the class name
        $className = implode('_', $classNameComponent);
        return $className;
    }


    /**
     * check if PHP4 ?
     *
     * @return boolean true if php4 false otherwise
     * @access public
     * @static
     */
     function isPHP4()
    {
        
        if ( !isset( $GLOBALS['_CRM_UTILS_SYSTEM']['version'] ) ) {
            $GLOBALS['_CRM_UTILS_SYSTEM']['version'] = (substr(phpversion(), 0, 1) == 4) ? true:false;
        }
        return $GLOBALS['_CRM_UTILS_SYSTEM']['version'];
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
        $config   =& CRM_Core_Config::singleton( );
        return eval( 'return ' . $config->userFrameworkClass . '::checkPermission( $str ); ' );
    }

    /**
     * redirect to another url
     *
     * @param string $url the url to goto
     *
     * @return void
     * @access public
     * @static
     */
     function redirect( $url ) {
        // replace the &amp; characters with &
        // this is kinda hackish but not sure how to do it right
        $url = str_replace( '&amp;', '&', $url );
        header( 'Location: ' . $url );
        exit( );
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
        $config   =& CRM_Core_Config::singleton( );
        return eval( 'return ' . $config->userFrameworkClass . '::appendBreadCrumb( $bc );' );
    }

    /**
     * figure out the post url for the form
     *
     * @param the default action if one is pre-specified
     *
     * @return string the url to post the form
     * @access public
     * @static
     */
     function postURL( $action ) {
        $config   =& CRM_Core_Config::singleton( );
        return eval( 'return ' . $config->userFrameworkClass . '::postURL( "' . $action  . '" ); ' );
    }

    /**
     * rewrite various system urls to https
     *
     * @return void
     * access public 
     * @static 
     */ 
     function mapConfigToSSL( ) {
        $config   =& CRM_Core_Config::singleton( ); 

        $config->userFrameworkBaseURL = str_replace( 'http://', 'https://', $config->userFrameworkBaseURL );
        return eval( 'return ' . $config->userFrameworkClass . '::mapConfigToSSL( ); ' );
    }

    /**
     * Get the base URL from the system
     *
     * @param
     *
     * @return string
     * @access public
     * @static
     */
     function baseURL() {
        $config =& CRM_Core_Config::singleton( );
        return $config->userFrameworkBaseURL;
    }

    /** 
     * Authenticate the user against the uf db 
     * 
     * @param string $name     the user name 
     * @param string $password the password for the above user name 
     * 
     * @return mixed false if no auth 
     *               array( contactID, ufID, unique string ) if success 
     * @access public 
     * @static 
     */ 
     function authenticate( $name, $password ) {
        $config =& CRM_Core_Config::singleton( ); 
        return  
            eval( 'return ' . $config->userFrameworkClass . '::authenticate($name, $password);' ); 

    }

    /**  
     * Set a message in the UF to display to a user
     *  
     * @param string $name     the message to set
     *  
     * @access public  
     * @static  
     */  
     function setUFMessage( $message ) {
        $config =& CRM_Core_Config::singleton( );  
        return   
            eval( 'return ' . $config->userFrameworkClass . '::setMessage( $message );' );
    }

    /**
     * Set a status message in the session, then bounce back to the referrer.
     *
     * @param string $status        The status message to set
     * @return void
     * @access public
     * @static
     */
      function statusBounce($status) {
        $session =& CRM_Core_Session::singleton();
        $redirect = $session->readUserContext();
        $session->setStatus($status);
        CRM_Utils_System::redirect($redirect);
    }

     function isNull( $value ) {
        if ( ! isset( $value ) || $value === null || $value === '' ) {
            return true;
        }
        if ( is_array( $value ) ) {
            foreach ( $value as $key => $value ) {
                if ( ! CRM_Utils_System::isNull( $value ) ) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

     function mungeCreditCard( $number, $keep = 4 ) {
        $replace = str_repeat( '*' , strlen( $number ) - $keep );
        return substr_replace( $number, $replace, 0, -$keep );
    }

     function accessCiviContribute( ) {
        $config =& CRM_Core_Config::singleton( );
        if ( CRM_Utils_System::checkPermission( 'access CiviContribute' ) && 
             in_array( 'CiviContribute', $config->enableComponents ) ) {
            return true;
        }
        return false;
    }

    /** parse php modules from phpinfo */
    function parsePHPModules() {
        ob_start();
        phpinfo(INFO_MODULES);
        $s = ob_get_contents();
        ob_end_clean();
        
        $s = strip_tags($s,'<h2><th><td>');
        $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$s);
        $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$s);
        $vTmp = preg_split('/(<h2>[^<]+<\/h2>)/',$s,-1,PREG_SPLIT_DELIM_CAPTURE);
        $vModules = array();
        for ($i=1;$i<count($vTmp);$i++) {
            if (preg_match('/<h2>([^<]+)<\/h2>/',$vTmp[$i],$vMat)) {
                $vName = trim($vMat[1]);
                $vTmp2 = explode("\n",$vTmp[$i+1]);
                foreach ($vTmp2 AS $vOne) {
                    $vPat = '<info>([^<]+)<\/info>';
                    $vPat3 = "/$vPat\s*$vPat\s*$vPat/";
                    $vPat2 = "/$vPat\s*$vPat/";
                    if (preg_match($vPat3,$vOne,$vMat)) { // 3cols
                        $vModules[$vName][trim($vMat[1])] = array(trim($vMat[2]),trim($vMat[3]));
                    } elseif (preg_match($vPat2,$vOne,$vMat)) { // 2cols
                        $vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
                    }
                }
            }
        }
        return $vModules;
    }

    /** get a module setting */
    function getModuleSetting($pModuleName,$pSetting) {
        $vModules = CRM_Utils_System:: parsePHPModules();
        return $vModules[$pModuleName][$pSetting];
    }
    
}

?>
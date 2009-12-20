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
 * Stores all constants and pseudo constants for CRM application.
 *
 * examples of constants are "Contact Type" which will always be either
 * 'Individual', 'Household', 'Organization'.
 *
 * pseudo constants are entities from the database whose values rarely
 * change. examples are list of countries, states, location types,
 * relationship types.
 *
 * currently we're getting the data from the underlying database. this
 * will be reworked to use caching.
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationType'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationVcardName'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['activityType'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualPrefix'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualSuffix'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['gender'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['imProvider'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvinceAbbreviation'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['countryIsoCode'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['tag'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['group'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['relationshipType'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['ufGroup'] = null;
$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['currencyCode'] = null;

class CRM_Core_PseudoConstant {
    /**
     * location type
     * @var array
     * @static
     */
    
    
    /**
     * location vCard name
     * @var array
     * @static
     */
    
    
    /**
     * activity type
     * @var array
     * @static
     */
    
  
    /**
     * individual prefix
     * @var array
     * @static
     */
    

    /**
     * individual suffix
     * @var array
     * @static
     */
    
    
    /**
     * gender
     * @var array
     * @static
     */
    

    /**
     * im protocols
     * @var array
     * @static
     */
    

    /**
     * states, provinces
     * @var array
     * @static
     */
    

    /** 
     * states/provinces abbreviations
     * @var array
     * @static
     */
    

    /**
     * country
     * @var array
     * @static
     */
    


    /**
     * countryIsoCode
     * @var array
     * @static
     */
    

    /**
     * tag
     * @var array
     * @static
     */
    

    /**
     * group
     * @var array
     * @static
     */
    

    /**
     * relationshipType
     * @var array
     * @static
     */
    

    /**
     * user framework groups
     * @var array
     * @static
     */
    

    /**
     * currency codes
     * @var array
     * @static
     */
    

    /**
     * populate the object from the database. generic populate
     * method
     *
     * The static array $var is populated from the db
     * using the <b>$name DAO</b>. 
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @param array   $var        the associative array we will fill
     * @param string  $name       the name of the DAO
     * @param boolean $all        get all objects. default is to get only active ones.
     * @param string  $retrieve   the field that we are interested in (normally name, differs in some objects)
     * @param string  $filter     the field that we want to filter the result set with
     * @param string  $condition  the condition that gets passed to the final query as the WHERE clause
     *
     * @return void
     * @access protected
     * @static
     */
      function populate( &$var, $name, $all = false, $retrieve = 'name',
                                        $filter = 'is_active', $condition = null, $orderby = null ) {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $name) . ".php");
        eval( '$object =& new ' . $name . '( );' );
       
        $object->domain_id = CRM_Core_Config::domainID( );
        $object->selectAdd( );
        $object->selectAdd( "id, $retrieve" );
        if ($condition) {
            $object->whereAdd($condition);
        }
        
        if (!$orderby) {
            $object->orderBy( $retrieve );
        } else {
            $object->orderBy( $orderby );
        }

        if ( ! $all ) {
            $object->$filter = 1;
        }
        
        $object->find( );
        $var = array( );
        while ( $object->fetch( ) ) {
            $var[$object->id] = $object->$retrieve;
        }

    }

    /**
     * Get all location types.
     *
     * The static array locationType is returned
     *
     * @access public
     * @static
     *
     * @param boolean $all - get All location types - default is to get only active ones.
     *
     * @return array - array reference of all location types.
     *
     */
      function &locationType( $all=false )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationType'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationType'], 'CRM_Core_DAO_LocationType', $all );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationType'];
    }


    /**
     * Get all location vCard names.
     *
     * The static array locationVcardName is returned
     *
     * @access public
     * @static
     *
     * @param boolean $all - get All location vCard names - default is to get only active ones.
     *
     * @return array - array reference of all location vCard names.
     *
     */
      function &locationVcardName( $all=false )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationVcardName'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationVcardName'], 'CRM_Core_DAO_LocationType', $all, 'vcard_name' );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['locationVcardName'];
    }


    /**
     * Get all Activty types.
     *
     * The static array activityType is returned
     *
     * @access public
     * @static
     *
     * @param boolean $all - get All Activity  types - default is to get only active ones.
     *
     * @return array - array reference of all activty types.
     *
     */
      function &activityType( $all = false, $cond = 'id > 4' )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['activityType'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['activityType'], 'CRM_Core_DAO_ActivityType', $all, 'name', 'is_active', $cond );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['activityType'];
    }

    /**
     * Get all Individual Prefix.
     *
     * The static array individualPrefix is returned
     *
     * @access public
     * @static
     *
     * @param boolean $all - get All Individual Prefix - default is to get only active ones.
     *
     * @return array - array reference of all individual prefix.
     *
     */
      function &individualPrefix( $all=false )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualPrefix'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualPrefix'], 'CRM_Core_DAO_IndividualPrefix', $all, 'name', 'is_active', null, 'weight ASC' );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualPrefix'];
    }

    /**
     * Get all Individual Suffix.
     *
     * The static array individualSuffix is returned
     *
     * @access public
     * @static
     *
     * @param boolean $all - get All Individual Suffix - default is to get only active ones.
     *
     * @return array - array reference of all individual suffix.
     *
     */
      function &individualSuffix( $all=false )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualSuffix'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualSuffix'], 'CRM_Core_DAO_IndividualSuffix', $all, 'name', 'is_active', null, 'weight ASC' );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['individualSuffix'];
    }

    /**
     * Get all Gender.
     *
     * The static array gender is returned
     *
     * @access public
     * @static
     *
     * @param boolean $all - get All Gender - default is to get only active ones.
     *
     * @return array - array reference of all gender.
     *
     */
      function &gender( $all=false )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['gender'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['gender'], 'CRM_Core_DAO_Gender', $all, 'name', 'is_active', null, 'weight ASC' );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['gender'];
    }


    /**
     * Get all the IM Providers from database.
     *
     * The static array imProvider is returned, and if it's
     * called the first time, the <b>IM DAO</b> is used 
     * to get all the IM Providers.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @return array - array reference of all IM providers.
     *
     */
      function &IMProvider( $all = false ) {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['imProvider']) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['imProvider'], 'CRM_Core_DAO_IMProvider', $all );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['imProvider'];
    }

    /**
     * Get all the State/Province from database.
     *
     * The static array stateProvince is returned, and if it's
     * called the first time, the <b>State Province DAO</b> is used 
     * to get all the States.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @param int $id -  Optional id to return
     * @return array - array reference of all State/Provinces.
     *
     */
      function &stateProvince($id = false)
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince']) {

            // limit the state/province list to the countries specified in CIVICRM_PROVINCE_LIMIT
            $config =& CRM_Core_Config::singleton();
            $countryIsoCodes =& CRM_Core_PseudoConstant::countryIsoCode();
            $limitCodes = $config->provinceLimit;
            $limitIds = array();
            foreach ($limitCodes as $code) {
                $limitIds = array_merge($limitIds, array_keys($countryIsoCodes, $code));
            }
            $whereClause = 'country_id IN (' . implode(', ', $limitIds) . ')';

            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince'], 'CRM_Core_DAO_StateProvince', true, 'name', 'is_active', $whereClause );

            // localise the province names if in an non-en_US locale
            if ($config->lcMessages != '' and $config->lcMessages != 'en_US') {
                $i18n =& CRM_Core_I18n::singleton();
                $i18n->localizeArray($GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince']);
                asort($GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince']);
            }
        }
        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince'])) {
                return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvince'];
    }

    /**
     * Get all the State/Province abbreviations from the database.
     * 
     * Same as above, except gets the abbreviations instead of the names.
     *
     * @access public
     * @static
     * @param int $id  -     Optional id to return
     * @return array - array reference of all State/Province abbreviations.
     */
      function &stateProvinceAbbreviation($id = false)
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvinceAbbreviation']) {

            // limit the state/province list to the countries specified in CIVICRM_PROVINCE_LIMIT
            $config =& CRM_Core_Config::singleton();
            $countryIsoCodes =& CRM_Core_PseudoConstant::countryIsoCode();
            $limitCodes = $config->provinceLimit;
            $limitIds = array();
            foreach ($limitCodes as $code) {
                $tmpArray   = array_keys($countryIsoCodes, $code);

                if (!empty($tmpArray)) {
                    $limitIds[] = array_shift($tmpArray);
                }
            }
            $whereClause = 'country_id IN (' . implode(', ', $limitIds) . ')';

            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvinceAbbreviation'], 'CRM_Core_DAO_StateProvince', true, 'abbreviation', 'is_active', $whereClause );
        }

        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvinceAbbreviation'])) {
                return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvinceAbbreviation'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['stateProvinceAbbreviation'];
    }


    /**
     * Get all the countries from database.
     *
     * The static array country is returned, and if it's
     * called the first time, the <b>Country DAO</b> is used 
     * to get all the countries.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @param int $id - Optional id to return
     * @return array - array reference of all countries.
     *
     */
      function &country($id = false)
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country']) {

            $config =& CRM_Core_Config::singleton();

            // limit the country list to the countries specified in CIVICRM_COUNTRY_LIMIT
            // (ensuring it's a subset of the legal values)
            $limitCodes = $config->countryLimit;
            $limitCodes = array_intersect(CRM_Core_PseudoConstant::countryIsoCode(), $limitCodes);
            if (count($limitCodes)) {
                $whereClause = "iso_code IN ('" . implode("', '", $limitCodes) . "')";
            } else {
                $whereClause = null;
            }

            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country'], 'CRM_Core_DAO_Country', true, 'name', 'is_active', $whereClause );

            // localise the country names if in an non-en_US locale
            if ($config->lcMessages != '' and $config->lcMessages != 'en_US') {
                $i18n =& CRM_Core_I18n::singleton();
                $i18n->localizeArray($GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country']);
                asort($GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country']);
            }
        }
        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country'])) {
                return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['country'];
    }

    /**
     * Get all the country ISO Code abbreviations from the database.
     *
     * The static array countryIsoCode is returned, and if it's
     * called the first time, the <b>Country DAO</b> is used
     * to get all the countries' ISO codes.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @return array - array reference of all country ISO codes.
     *
     */
      function &countryIsoCode( $id = false )
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['countryIsoCode']) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['countryIsoCode'], 'CRM_Core_DAO_Country',
            true, 'iso_code');
        }
        if ($id) { 
            if (array_key_exists($id, $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['countryIsoCode'])) { 
                return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['countryIsoCode'][$id]; 
            } else { 
                return null; 
            } 
        } 
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['countryIsoCode'];
    }

    /**
     * Get all the categories from database.
     *
     * The static array tag is returned, and if it's
     * called the first time, the <b>Tag DAO</b> is used 
     * to get all the categories.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @return array - array reference of all categories.
     *
     */
      function &tag()
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['tag']) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['tag'], 'CRM_Core_DAO_Tag', true );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['tag'];
    }

    /**
    * Get all groups from database
    *
    * The static array group is returned, and if it's
    * called the first time, the <b>Group DAO</b> is used
    * to get all the groups.
    *
    * Note: any database errors will be trapped by the DAO.
    *
    * @access public
    * @static
    *
    * @return array - array reference of all groups.
    *
    */
      function &allGroup()
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['group']) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['group'], 'CRM_Contact_DAO_Group', false, 'title' );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['group'];
    }

    /**
     * Get all permissioned groups from database
     *
     * The static array group is returned, and if it's
     * called the first time, the <b>Group DAO</b> is used 
     * to get all the groups.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @return array - array reference of all groups.
     *
     */
      function &group()
    {
        require_once 'CRM/Core/Permission.php';
        return CRM_Core_Permission::group( );
    }

    /**
     * Get all the user framework groups
     *
     * @access public
     * @return array - array reference of all groups.
     * @static
     */
      function &ufGroup( )
    {
        if ( ! $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['ufGroup'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['ufGroup'], 'CRM_Core_DAO_UFGroup', false, 'title', 'is_active', null, 'title' );
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['ufGroup'];
    }

    /**
     * Get all Relationship Types  from database.
     *
     * The static array group is returned, and if it's
     * called the first time, the <b>RelationshipType DAO</b> is used 
     * to get all the relationship types.
     *
     * Note: any database errors will be trapped by the DAO.
     *
     * @access public
     * @static
     *
     * @return array - array reference of all relationship types.
     *
     */
      function &relationshipType()
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['relationshipType']) {
            $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['relationshipType'] = array();
            $relationshipTypeDAO =& new CRM_Contact_DAO_RelationshipType();
            $relationshipTypeDAO->selectAdd();
            $relationshipTypeDAO->selectAdd('id, name_a_b, name_b_a, contact_type_a, contact_type_b');
            $relationshipTypeDAO->is_active = 1;
            $relationshipTypeDAO->find();
            while($relationshipTypeDAO->fetch()) {
                $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['relationshipType'][$relationshipTypeDAO->id] = array(
                                                                          'name_a_b'       => "$relationshipTypeDAO->name_a_b",
                                                                          'name_b_a'       => "$relationshipTypeDAO->name_b_a",
                                                                          'contact_type_a' => "$relationshipTypeDAO->contact_type_a",
                                                                          'contact_type_b' => "$relationshipTypeDAO->contact_type_b",
                                                                         );
            }
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['relationshipType'];
    }

    /**
     * get all the ISO 4217 currency codes
     *
     * so far, we use this for validation only, so there's no point of putting this into the database
     *
     * @access public
     * @return array - array reference of all currency codes
     * @static
     */
      function &currencyCode()
    {
        if (!$GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['currencyCode']) {
            $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['currencyCode'] = array('AFN','ALL','DZD','USD','EUR','AOA','XCD','XCD','ARS','AMD',
                'AWG','AUD','EUR','AZM','BSD','BHD','BDT','BBD','BYR','EUR','BZD','XOF','BMD','INR',
                'BTN','BOB','BOV','BAM','BWP','NOK','BRL','USD','BND','BGN','XOF','BIF','KHR','XAF',
                'CAD','CVE','KYD','XAF','XAF','CLP','CLF','CNY','AUD','AUD','COP','COU','KMF','XAF',
                'CDF','NZD','CRC','XOF','HRK','CUP','CYP','CZK','DKK','DJF','XCD','DOP','USD','EGP',
                'SVC','USD','XAF','ERN','EEK','ETB','FKP','DKK','FJD','EUR','EUR','EUR','XPF','EUR',
                'XAF','GMD','GEL','EUR','GHC','GIP','EUR','DKK','XCD','EUR','USD','GTQ','GNF','GWP',
                'XOF','GYD','HTG','USD','AUD','EUR','HNL','HKD','HUF','ISK','INR','IDR','XDR','IRR',
                'IQD','EUR','ILS','EUR','JMD','JPY','JOD','KZT','KES','AUD','KPW','KRW','KWD','KGS',
                'LAK','LVL','LBP','ZAR','LSL','LRD','LYD','CHF','LTL','EUR','MOP','MKD','MGA','MWK',
                'MYR','MVR','XOF','MTL','USD','EUR','MRO','MUR','EUR','MXN','MXV','USD','MDL','EUR',
                'MNT','XCD','MAD','MZM','MMK','ZAR','NAD','AUD','NPR','EUR','ANG','XPF','NZD','NIO',
                'XOF','NGN','NZD','AUD','USD','NOK','OMR','PKR','USD','PAB','USD','PGK','PYG','PEN',
                'PHP','NZD','PLN','EUR','USD','QAR','EUR','ROL','RON','RUB','RWF','SHP','XCD','XCD',
                'EUR','XCD','WST','EUR','STD','SAR','XOF','CSD','EUR','SCR','SLL','SGD','SKK','SIT',
                'SBD','SOS','ZAR','EUR','LKR','SDD','SRD','NOK','SZL','SEK','CHF','CHW','CHE','SYP',
                'TWD','TJS','TZS','THB','USD','XOF','NZD','TOP','TTD','TND','TRY','TRL','TMM','USD',
                'AUD','UGX','UAH','AED','GBP','USD','USS','USN','USD','UYU','UZS','VUV','VEB','VND',
                'USD','USD','XPF','MAD','YER','ZMK','ZWD','XAU','XBA','XBB','XBC','XBD','XPD','XPT',
                'XAG','XFU','XFO','XTS','XXX');
        }
        return $GLOBALS['_CRM_CORE_PSEUDOCONSTANT']['currencyCode'];
    }

}

?>

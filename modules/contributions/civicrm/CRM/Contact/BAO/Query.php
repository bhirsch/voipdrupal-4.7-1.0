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
 | at http://www.openngo.org/faqs/licensing.html                      | 
 +--------------------------------------------------------------------+ 
*/ 
 
/** 
 * 
 * 
 * @package CRM 
 * @author Donald A. Lobo <lobo@yahoo.com> 
 * @copyright Donald A. Lobo (c) 2005 
 * $Id$ 
 * 
 */ 

define( 'CRM_CONTACT_BAO_QUERY_MODE_CONTACTS',1);
define( 'CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE',2);
define( 'CRM_CONTACT_BAO_QUERY_MODE_ALL',3);
$GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'] = null;
$GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultHierReturnProperties'] = null;
$GLOBALS['_CRM_CONTACT_BAO_QUERY']['_dependencies'] =  array( 'civicrm_state_province' => 1,
                                   'civicrm_country'        => 1,
                                   'civicrm_address'        => 1,
                                   'civicrm_phone'          => 1,
                                   'civicrm_email'          => 1,
                                   'civicrm_im'             => 1,
                                   'civicrm_location_type'  => 1,
                                   );
$GLOBALS['_CRM_CONTACT_BAO_QUERY']['special'] =  array( 'contact_type', 'sort_name', 'display_name' );
$GLOBALS['_CRM_CONTACT_BAO_QUERY']['skipFields'] =  array( 'postal_code', 'location_type');

require_once 'CRM/Core/DAO/Location.php'; 
require_once 'CRM/Core/DAO/Address.php'; 
require_once 'CRM/Core/DAO/Phone.php'; 
require_once 'CRM/Core/DAO/Email.php'; 

class CRM_Contact_BAO_Query {

    /**
     * The various search modes
     *
     * @var int
     */
    
            
          
                 

    /**
     * the default set of return properties
     *
     * @var array
     * @static
     */
    

    /**
     * the default set of hier return properties
     *
     * @var array
     * @static
     */
    
    
    /** 
     * the set of input params
     * 
     * @var array 
     */ 
    var $_params;

    /** 
     * the set of output params
     * 
     * @var array 
     */ 
    var $_returnProperties;

    /** 
     * the select clause 
     * 
     * @var array 
     */
    var $_select;

    /** 
     * the name of the elements that are in the select clause 
     * used to extract the values 
     * 
     * @var array 
     */ 
    var $_element;
 
    /**  
     * the tables involved in the query 
     *  
     * @var array  
     */  
    var $_tables;

    /**
     * the table involved in the where clause
     *
     * @var array
     */
    var $_whereTables;

    /**  
     * the where clause  
     *  
     * @var array  
     */  
    var $_where;

    /**   
     * the where string
     *
     * @var string
     *
     */
    var $_whereClause;

    /**    
     * the from string 
     * 
     * @var string 
     * 
     */ 
    var $_fromClause;

    /**
     * the from clause for the simple select and alphabetical
     * select
     *
     * @var string
     */
    var $_simpleFromClause;

    /** 
     * The english language version of the query 
     *   
     * @var array   
     */  
    var $_qill;

    /**
     * All the fields that could potentially be involved in
     * this query
     *
     * @var array
     */
    var    $_fields;

    /** 
     * The cache to translate the option values into labels 
     *    
     * @var array    
     */  
    var    $_options;

    /**
     * are we in search mode
     *
     * @var boolean
     */
    var $_search = true;

    /**
     * are we in strict mode (use equality over LIKE)
     *
     * @var boolean
     */
    var $_strict = false;

    var $_mode = 1;

    /** 
     * Should we only search on primary location
     *    
     * @var boolean
     */  
    var $_primaryLocation = true;

    /**
     * are contact ids part of the query
     *
     * @var boolean
     */
    var $_includeContactIds = false;

    /**
     * reference to the query object for custom values
     *
     * @var Object
     */
    var $_customQuery;

    /**
     * should we enable the distinct clause, used if we are including
     * more than one group
     *
     * @var boolean
     */
    var $_useDistinct = false;

    /**
     * The tables which have a dependency on location and/or address
     *
     * @var array
     * @static
     */
    

    /**
     * class constructor which also does all the work
     *
     * @param array   $params
     * @param array   $returnProperties
     * @param array   $fields
     * @param boolean $includeContactIds
     * @param boolean $strict
     * @param boolean $mode - mode the search is operating on
     *
     * @return Object
     * @access public
     */
    function CRM_Contact_BAO_Query( $params = null, $returnProperties = null, $fields = null,
                          $includeContactIds = false, $strict = false, $mode = 1 ) {
        require_once 'CRM/Contact/BAO/Contact.php';
        //CRM_Core_Error::debug( 'params', $params );
        //CRM_Core_Error::debug( 'post', $_POST );
        $this->_params =& $params;

        if ( empty( $returnProperties ) ) {
            $this->_returnProperties =& CRM_Contact_BAO_Query::defaultReturnProperties( $mode );
        } else {
            $this->_returnProperties =& $returnProperties;
        }

        $this->_includeContactIds = $includeContactIds;
        $this->_strict            = $strict;
        $this->_mode              = $mode;

        if ( $fields ) {
            $this->_fields =& $fields;
            $this->_search = false;
        } else {
            require_once 'CRM/Contact/BAO/Contact.php';
            $this->_fields = CRM_Contact_BAO_Contact::exportableFields( 'All', false, true );
            
            require_once 'CRM/Contribute/BAO/Contribution.php';
            $fields = CRM_Contribute_BAO_Contribution::exportableFields( );
            unset( $fields['contact_id']);
            unset( $fields['note'] );
            $this->_fields = array_merge( $this->_fields, $fields );
        }

        // basically do all the work once, and then reuse it
        $this->initialize( );
        // CRM_Core_Error::debug( 'q', $this );
    }

    /**
     * function which actually does all the work for the constructor
     *
     * @return void
     * @access private
     */
    function initialize( ) {
        $this->_select      = array( ); 
        $this->_element     = array( ); 
        $this->_tables      = array( );
        $this->_whereTables = array( );
        $this->_where       = array( ); 
        $this->_qill        = array( ); 
        $this->_options     = array( );

        $this->_customQuery = null; 
 
        $this->_select['contact_id']      = 'civicrm_contact.id as contact_id';
        $this->_element['contact_id']     = 1; 
        $this->_tables['civicrm_contact'] = 1;
        $this->_whereTables['civicrm_contact'] = 1;

        if ( $this->_mode & CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE) {
            $this->_select['contribution_id'] = "civicrm_contribution.id as contribution_id";
            $this->_element['contribution_id'] = 1;
            $this->_tables['civicrm_contribution'] = 1;
            $this->_whereTables['civicrm_contribution'] = 1;
        }

        $this->selectClause( ); 
        $this->_whereClause      = $this->whereClause( ); 
        $this->_fromClause       = CRM_Contact_BAO_Query::fromClause( $this->_tables     , null, null, $this->_primaryLocation, $this->_mode ); 
        $this->_simpleFromClause = CRM_Contact_BAO_Query::fromClause( $this->_whereTables, null, null, $this->_primaryLocation, $this->_mode );
    }

    /**
     * Some composite fields do not appear in the fields array
     * hack to make them part of the query
     *
     * @return void 
     * @access public 
     */
    function addSpecialFields( ) {
        
        foreach ( $GLOBALS['_CRM_CONTACT_BAO_QUERY']['special'] as $name ) {
            if ( CRM_Utils_Array::value( $name, $this->_returnProperties ) ) { 
                $this->_select[$name]  = "civicrm_contact.{$name} as $name";
                $this->_element[$name] = 1;
            }
        }
    }

    /** 
     * if contributions are involved, add the specific contribute fields
     * 
     * @return void  
     * @access public  
     */
    function addContributeFields( ) {
        if ( ! ( $this->_mode & CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE) ) {
            return;
        }

        // get contribution_type
        if ( CRM_Utils_Array::value( 'contribution_type', $this->_returnProperties ) ) {
            $this->_select['contribution_type']  = "civicrm_contribution_type.name as contribution_type";
            $this->_element['contribution_type'] = 1;
            $this->_tables['civicrm_contribution'] = 1;
            $this->_tables['civicrm_contribution_type'] = 1;
            $this->_whereTables['civicrm_contribution'] = 1;
            $this->_whereTables['civicrm_contribution_type'] = 1;
        }
    }

    /**
     * Given a list of conditions in params and a list of desired
     * return Properties generate the required select and from
     * clauses. Note that since the where clause introduces new
     * tables, the initial attempt also retrieves all variables used
     * in the params list
     *
     * @return void
     * @access public
     */
    function selectClause( ) {
        $properties = array( );
        $cfIDs      = array( );

        $this->addSpecialFields( );

        $this->addContributeFields( );
        
        //CRM_Core_Error::debug( 'f', $this->_fields );
        //CRM_Core_Error::debug( 'p', $this->_params );
        
        //format privacy options
        if ( is_array($this->_params['privacy']) ) {
            foreach ($this->_params['privacy'] as $key => $value) {
                if ($value) {
                    $this->_params[$key] = 1;
                }
            }
        }

        foreach ($this->_fields as $name => $field) {
            $value = CRM_Utils_Array::value( $name, $this->_params );
            // if we need to get the value for this param or we need all values
            if ( ! CRM_Utils_System::isNull( $value ) || 
                 CRM_Utils_Array::value( $name, $this->_returnProperties ) ) {
                $cfID = CRM_Core_BAO_CustomField::getKeyID( $name );
                if ( $cfID ) {
                    $value = CRM_Utils_Array::value( $name, $this->_params );
                    $cfIDs[$cfID] = $value;
                } else if ( isset( $field['where'] ) ) {
                    list( $tableName, $fieldName ) = explode( '.', $field['where'], 2 ); 
                    if ( isset( $tableName ) ) { 
                        if ( CRM_Utils_Array::value( $tableName, $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_dependencies'] ) ) {
                            $this->_tables['civicrm_location'] = 1;
                            $this->_select['location_id']      = 'civicrm_location.id as location_id';
                            $this->_element['location_id']     = 1;

                            $this->_tables['civicrm_address'] = 1;
                            $this->_select['address_id']      = 'civicrm_address.id as address_id';
                            $this->_element['address_id']     = 1;
                        }

                        $this->_tables[$tableName]         = 1;

                        // also get the id of the tableName
                        $tName = substr($tableName, 8 );

                        if ( $tName != 'contact' ) {
                            $this->_select["{$tName}_id"]  = "{$tableName}.id as {$tName}_id";
                            $this->_element["{$tName}_id"] = 1;
                        }
                        
                        //special case for phone
                        if ($name == 'phone') {
                            $this->_select ['phone_type'] = "civicrm_phone.phone_type as phone_type";
                            $this->_element['phone_type'] = 1;
                        }

                        if ( $name == 'state_province' ) {
                            $this->_select [$name]              = "civicrm_state_province.abbreviation as `$name`";
                        } else {
                            $this->_select [$name]              = $field['where'] . " as `$name`";
                        }
                        $this->_element[$name]             = 1;

                    }
                } elseif ($name === 'tags') {
                    $this->_select[$name               ] = "GROUP_CONCAT(DISTINCT(civicrm_tag.name)) AS tags";
                    $this->_tables['civicrm_tag'       ] = 1;
                    $this->_tables['civicrm_entity_tag'] = 1;
                } elseif ($name === 'groups') {
                    $this->_select[$name                  ] = "GROUP_CONCAT(DISTINCT(civicrm_group.name)) AS groups";
                    $this->_tables['civicrm_group'        ] = 1;
                    $this->_tables['civicrm_group_contact'] = 1;
                }
            } else if ( CRM_Utils_Array::value( 'is_search_range', $field ) ) {
                // this is a custom field with range search enabled, so we better check for two/from values
                $cfID = CRM_Core_BAO_CustomField::getKeyID( $name );
                if ( $cfID ) {
                    $value = CRM_Utils_Array::value( $name . '_from', $this->_params );
                    if ( ! CRM_Utils_System::isNull( $value ) ) {
                        $cfIDs[$cfID]['from'] = $value;
                    }
                    $value = CRM_Utils_Array::value( $name . '_to', $this->_params );
                    if ( ! CRM_Utils_System::isNull( $value ) ) {
                        $cfIDs[$cfID]['to'] = $value;
                    }
                }
            }
        }

        // add location as hierarchical elements
        $this->addHierarchicalElements( );

        if ( ! empty( $cfIDs ) ) {
            //CRM_Core_Error::debug( 'cfIDs', $cfIDs );
            require_once 'CRM/Core/BAO/CustomQuery.php';
            $this->_customQuery = new CRM_Core_BAO_CustomQuery( $cfIDs );
            $this->_customQuery->query( );
            $this->_select  = array_merge( $this->_select , $this->_customQuery->_select );
            $this->_element = array_merge( $this->_element, $this->_customQuery->_element);
            $this->_tables  = array_merge( $this->_tables , $this->_customQuery->_tables );
            $this->_whereTables  = array_merge( $this->_whereTables , $this->_customQuery->_whereTables );
            $this->_options = $this->_customQuery->_options;
        }
    }

    /**
     * If the return Properties are set in a hierarchy, traverse the hierarchy to get
     * the return values
     *
     * @return void 
     * @access public 
     */
    function addHierarchicalElements( ) {
        if ( ! CRM_Utils_Array::value( 'location', $this->_returnProperties ) ) {
            return;
        }
        if ( ! is_array( $this->_returnProperties['location'] ) ) {
            return;
        }

        $locationTypes = CRM_Core_PseudoConstant::locationType( );
        $processed     = array( );
        $index = 0;
        foreach ( $this->_returnProperties['location'] as $name => $elements ) {
            $index++;
            $lName = "`$name-location`";
            $lCond = CRM_Contact_BAO_Query::getPrimaryCondition( $name );

            if ( $lCond ) {
                $lCond = "$lName." . $lCond;
            } else {
                $locationTypeId = array_search( $name, $locationTypes );
                if ( $locationTypeId === false ) {
                    continue;
                }
                $lCond = "$lName.location_type_id = $locationTypeId";
            }

            $tName = "$name-location";
            $this->_select["{$tName}_id"]  = "`$tName`.id as `{$tName}_id`"; 
            $this->_element["{$tName}_id"] = 1; 
            $this->_tables[ 'civicrm_location_' . $index ] = "\nLEFT JOIN civicrm_location $lName ON ($lName.entity_table = 'civicrm_contact' AND $lName.entity_id = civicrm_contact.id AND $lCond )";

            $tName  = "$name-location_type";
            $ltName ="`$name-location_type`";
            $this->_select["{$tName}_id" ]  = "`$tName`.id as `{$tName}_id`"; 
            $this->_select["{$tName}"    ]  = "`$tName`.name as `{$tName}`"; 
            $this->_element["{$tName}_id"]  = 1;
            $this->_element["{$tName}"   ]  = 1;  
            $this->_tables[ 'civicrm_location_type_' . $index ] = "\nLEFT JOIN civicrm_location_type $ltName ON ($lName.location_type_id = $ltName.id )";


            $aName = "`$name-address`";
            $tName = "$name-address";
            $this->_select["{$tName}_id"]  = "`$tName`.id as `{$tName}_id`"; 
            $this->_element["{$tName}_id"] = 1; 
            $this->_tables[ 'civicrm_address_' . $index ] = "\nLEFT JOIN civicrm_address $aName ON ($aName.location_id = $lName.id)";
            
            $processed[$lName] = $processed[$aName] = 1;
            foreach ( $elements as $elementFullName => $dontCare ) {
                $index++;
                $cond = "is_primary = 1";
                $elementName = $elementFullName;
                $elementType = '';
                if ( strpos( $elementName, '-' ) ) {
                    // this is either phone, email or IM
                    list( $elementName, $elementType ) = explode( '-', $elementName );

                    $cond = CRM_Contact_BAO_Query::getPrimaryCondition( $elementType );
                    if ( ! $cond ) {
                        $cond = "phone_type = '$elementType'";
                    }
                    $elementType = '-' . $elementType;
                }

                $field = CRM_Utils_Array::value( $elementName, $this->_fields ); 

                // hack for profile, add location id
                if ( ! $field ) {
                    if ( ! is_numeric($elementType) ) { //fix for CRM-882( to handle phone types )
                        $field =& CRM_Utils_Array::value( $elementName . "-$locationTypeId$elementType", $this->_fields );
                    } else {
                        $field =& CRM_Utils_Array::value( $elementName . "-$locationTypeId", $this->_fields );
                    }
                }

                if ( $field && isset( $field['where'] ) ) {
                    list( $tableName, $fieldName ) = explode( '.', $field['where'], 2 );  
                    $tName = $name . '-' . substr( $tableName, 8 ) . $elementType;
                    $fieldName = $fieldName;
                    if ( isset( $tableName ) ) {
                        $this->_select["{$tName}_id"]                   = "`$tName`.id as `{$tName}_id`";
                        $this->_element["{$tName}_id"]                  = 1;
                        if ( substr( $tName, -15 ) == '-state_province' ) {
                            $this->_select["{$name}-{$elementFullName}"]  = "`$tName`.abbreviation as `{$name}-{$elementFullName}`";
                        } else {
                            $this->_select["{$name}-{$elementFullName}"]  = "`$tName`.$fieldName as `{$name}-{$elementFullName}`";
                        }
                        $this->_element["{$name}-{$elementFullName}"] = 1;
                        if ( ! CRM_Utils_Array::value( "`$tName`", $processed ) ) {
                            $processed["`$tName`"] = 1;
                            switch ( $tableName ) {
                            case 'civicrm_phone':
                            case 'civicrm_email':
                            case 'civicrm_im':
                                $this->_tables[$tableName . '_' . $index] = "\nLEFT JOIN $tableName `$tName` ON $lName.id = `$tName`.location_id AND `$tName`.$cond";
                                break;

                            case 'civicrm_state_province':
                                $this->_tables[$tableName . '_' . $index] = "\nLEFT JOIN $tableName `$tName` ON `$tName`.id = $aName.state_province_id";
                                break;

                            case 'civicrm_country':
                                $this->_tables[$tableName . '_' . $index] = "\nLEFT JOIN $tableName `$tName` ON `$tName`.id = $aName.country_id";
                                break;
                            }
                        }
                    }
                }
            }
        }
    }

    /** 
     * generate the query based on what type of query we need
     *
     * @param boolean $count
     * @param boolean $sortByChar
     * @param boolean $groupContacts
     * 
     * @return the sql string for that query (this will most likely
     * change soon)
     * @access public 
     */ 
    function query( $count = false, $sortByChar = false, $groupContacts = false ) {
        if ( $count ) {
            if ( $this->_useDistinct ) {
                $select = 'SELECT count(DISTINCT civicrm_contact.id)';
            } else {
                $select = 'SELECT count(civicrm_contact.id)'; 
            }
            $from = $this->_simpleFromClause;
        } else if ( $sortByChar ) {  
            $select = 'SELECT DISTINCT UPPER(LEFT(civicrm_contact.sort_name, 1)) as sort_name';
            $from = $this->_simpleFromClause;
        } else if ( $groupContacts ) { 
            if ( $this->_useDistinct ) { 
                $select  = 'SELECT DISTINCT(civicrm_contact.id) as id'; 
            } else {
                $select  = 'SELECT civicrm_contact.id as id'; 
            }
            $from = $this->_simpleFromClause;
        } else {
            if ( CRM_Utils_Array::value( 'group', $this->_params ) ) {
                // make sure there is only one element
                if ( count( $this->_params['group'] ) == 1 ) {
                    $this->_select['group_contact_id']      = 'civicrm_group_contact.id as group_contact_id';
                    $this->_element['group_contact_id']     = 1;
                    $this->_select['status']                = 'civicrm_group_contact.status as status';
                    $this->_element['status']               = 1;
                }
                $this->_tables['civicrm_group_contact'] = 1;
            }
            if ( $this->_useDistinct ) {
                $this->_select['contact_id'] = 'DISTINCT(civicrm_contact.id) as contact_id';
            }
            $select = 'SELECT ' . implode( ', ', $this->_select );
            $from = $this->_fromClause;
        }

        $where = '';
        if ( ! empty( $this->_whereClause ) ) {
            $where = "WHERE {$this->_whereClause}";
        }

        //CRM_Core_Error::debug( "t", $this );
        //CRM_Core_Error::debug( "$select, $from $where", $where );
        return array( $select, $from, $where );
    }

    /** 
     * Given a list of conditions in params generate the required
     * where clause
     * 
     * @return void 
     * @access public 
     */ 
    function whereClause( ) {
        //CRM_Core_Error::debug( 'p', $this->_params );
        // domain id is always part of the where clause
        $config  =& CRM_Core_Config::singleton( ); 
        $this->_where[] = 'civicrm_contact.domain_id = ' . $config->domainID( );
        
        // check for both id and contact_id
        $id = CRM_Utils_Array::value( 'id', $this->_params );
        if ( ! $id ) {
            $id = CRM_Utils_Array::value( 'contact_id', $this->_params );
        }
        if ( $id ) {
            $this->_where[] = "civicrm_contact.id = $id";
        }
        
        $this->contactType( );

        $this->sortName( );

        $this->sortByCharacter( );

        $this->locationTypeAndName( );

        $this->group( );

        $this->tag( );

        $this->postalCode( );

        $this->activity( );

        $this->includeContactIds( );

        $this->contribution( );

        //CRM_Core_Error::debug( 'p', $this->_params );
        //CRM_Core_Error::debug( 'f', $this->_fields );

        
        foreach ( $this->_fields as $name => $field ) { 
            if ( empty( $name ) ||
                 in_array( $name, $GLOBALS['_CRM_CONTACT_BAO_QUERY']['skipFields'] ) ) {
                continue;
            }

            $value = CRM_Utils_Array::value( $name, $this->_params );
                
            if ( ! isset( $value ) || $value == null ) {
                continue;
            }

            if ( CRM_Core_BAO_CustomField::getKeyID( $name ) ) { 
                continue;
            }

            //check if the location type exits for fields
            $lType = '';
            $locType = array( );
            $locType = explode('-', $name);
            
            if (is_numeric($locType[1])) {
                $this->_params['location_type'] = array($locType[1] => 1);
                $lType = $this->locationTypeAndName( true );
            }
            
            //add phone type if exists
            if ($locType[2]) {
                $this->_where[] = "civicrm_phone.phone_type ='".$locType[2]."'";
            }

            // FIXME: the LOWER/strtolower pairs below most probably won't work
            // with non-US-ASCII characters, as even if MySQL does the proper
            // thing with LOWER-ing them (4.0 almost certainly won't, but then
            // we don't officially support 4.0 for non-US-ASCII data), PHP
            // won't do the proper thing with strtolower-ing them unless the
            // underlying operating system uses an UTF-8 locale for LC_CTYPE
            // for the user the webserver runs at (or suEXECs); we should use
            // mb_strtolower(), but then we'd require mb_strings support; we
            // could wrap this in function_exist(), though
            if ( substr($name,0,14) === 'state_province' ) {
                $states =& CRM_Core_PseudoConstant::stateProvince(); 
                if ( is_numeric( $value ) ) {
                    $value  =  $states[(int ) $value];
                }
                $this->_where[] = 'LOWER(' . $field['where'] . ') = "' . strtolower( addslashes( $value ) ) . '"';
                if (!$lType) {
                    $this->_qill[] = ts('State - "%1"', array( 1 => $value ) );         
                } else {
                    $this->_qill[] = ts('State (%2) - "%1"', array( 1 => $value, 2 => $lType ) );         
                }
            } else if ( substr($name,0,7) === 'country' ) {
                $countries =& CRM_Core_PseudoConstant::country( ); 
                if ( is_numeric( $value ) ) { 
                    $value     =  $countries[(int ) $value]; 
                }
                $this->_where[] = 'LOWER(' . $field['where'] . ') = "' . strtolower( addslashes( $value ) ) . '"';
                if (!$lType) {
                    $this->_qill[] = ts('Country - "%1"', array( 1 => $value ) );
                } else {
                    $this->_qill[] = ts('Country (%2) - "%1"', array( 1 => $value, 2 => $lType ) );         
                }

            } else if ( $name === 'individual_prefix' ) {
                $individualPrefixs =& CRM_Core_PseudoConstant::individualPrefix( ); 
                if ( is_numeric( $value ) ) { 
                    $value     =  $individualPrefixs[(int ) $value];  
                }
                $this->_where[] = 'LOWER(' . $field['where'] . ') = "' . strtolower( addslashes( $value ) ) . '"';
                $this->_qill[] = ts('Individual Prefix - "%1"', array( 1 => $value ) );
            } else if ( $name === 'individual_suffix' ) {
                $individualSuffixs =& CRM_Core_PseudoConstant::individualsuffix( ); 
                if ( is_numeric( $value ) ) { 
                    $value     =  $individualSuffixs[(int ) $value];  
                }
                $this->_where[] = 'LOWER(' . $field['where'] . ') = "' . strtolower( addslashes( $value ) ) . '"';
                $this->_qill[] = ts('Individual Suffix - "%1"', array( 1 => $value ) );
            } else if ( $name === 'gender' ) {
                $genders =& CRM_Core_PseudoConstant::gender( );  
                if ( is_numeric( $value ) ) {  
                    $value     =  $genders[(int ) $value];  
                }
                $this->_where[] = 'LOWER(' . $field['where'] . ') = "' . strtolower( addslashes( $value ) ) . '"'; 
                $this->_qill[] = ts('Gender - "%1"', array( 1 => $value ) ); 
            } else if ( $name === 'birth_date' ) {
                $date = CRM_Utils_Date::format( $value );
                if ( ! $date ) {
                    continue;
                }
                $this->_where[] = $field['where'] . " = $date";
                $date = CRM_Utils_Date::customFormat( $value );
                $this->_qill[]  = "$field[title] \"$date\"";
            } else if ( $name === 'contact_id' ) {
                if ( is_int( $value ) ) {
                    $this->_where[] = $field['where'] . " = $value";
                    $this->_qill[]  = ts( '%1 is equal to %2', array( 1 => $field['title'], 2 => $value ) );
                }
            } else if ( $name === 'name' ) {
                $this->_where[] = 'LOWER(' . $field['where'] . ') LIKE "%' . strtolower( addslashes( $value ) ) . '%"';  
                $this->_qill[]  = ts( '%1 like "%2"', array( 1 => $field['title'], 2 => $value ) );
            } else {
                // sometime the value is an array, need to investigate and fix
                if ( is_array( $value ) ) {
                    $value = $value[0];
                }

                if ( ! empty( $field['where'] ) ) {
                    if ( $this->_strict ) {
                        $this->_where[] = 'LOWER(' . $field['where'] . ') = "' . strtolower( str_replace( "\"", "", $value)  ) . '"';  
                        $this->_qill[]  = ts( '%1 = "%2"', array( 1 => $field['title'], 2 => $value ) );
                    } else {
                        $this->_where[] = 'LOWER(' . $field['where'] . ') LIKE "%' . strtolower( addslashes( $value ) ) . '%"';  
                        $this->_qill[]  = ts( '%1 like "%2"', array( 1 => $field['title'], 2 => $value ) );
                    }
                }
            }           

            list( $tableName, $fieldName ) = explode( '.', $field['where'], 2 );  
            if ( isset( $tableName ) ) { 
                $this->_tables[$tableName] = 1;  
                $this->_whereTables[$tableName] = 1;  
            }
            // CRM_Core_Error::debug( 'f', $field );
            // CRM_Core_Error::debug( $value, $this->_qill );
        }

        if ( $this->_customQuery ) {
            $this->_where = array_merge( $this->_where  , $this->_customQuery->_where );
            $this->_qill  = array_merge( $this->_qill   , $this->_customQuery->_qill  );
        }
        return  implode( ' AND ', $this->_where );
    }

    /**
     * Given a result dao, extract the values and return that array
     *
     * @param Object $dao
     *
     * @return array values for this query
     */
    function store( $dao ) {
        $value = array( );
        foreach ( $this->_element as $key => $dontCare ) {
            if ( isset( $dao->$key ) ) {
                if ( strpos( $key, '-' ) ) {
                    $values = explode( '-', $key );
                    $lastElement = array_pop( $values );
                    $current =& $value;
                    foreach ( $values as $v ) {
                        if ( ! array_key_exists( $v, $current ) ) {
                            $current[$v] = array( );
                        }
                        $current =& $current[$v];
                    }
                    $current[$lastElement] = $dao->$key;
                } else {
                    $value[$key] = $dao->$key;
                }
            }
        }
        return $value;
    }

    /**
     * getter for tables array
     *
     * @return array
     * @access public
     */
    function tables( ) {
        return $this->_tables;
    }

    function whereTables( ) {
        return $this->_whereTables;
    }

    /**
     * generate the where clause (used in match contacts and permissions)
     *
     * @param array $params
     * @param array $fields
     * @param array $tables
     * @param boolean $strict
     * 
     * @return string
     * @access public
     * @static
     */
     function getWhereClause( $params, $fields, &$tables, &$whereTables, $strict = false ) {
        $query = new CRM_Contact_BAO_Query( $params, null, $fields,
                                            false, $strict );

        $tables      = array_merge( $query->tables( ), $tables );
        $whereTables = array_merge( $query->whereTables( ), $whereTables );

        return $query->_whereClause;
    }

    /**
     * create the from clause
     *
     * @param array $tables tables that need to be included in this from clause
     *                      if null, return mimimal from clause (i.e. civicrm_contact)
     * @param array $inner  tables that should be inner-joined
     * @param array $right  tables that should be right-joined
     *
     * @return string the from clause
     * @access public
     * @static
     */
     function fromClause( &$tables , $inner = null, $right = null, $primaryLocation = true, $mode = 1 ) {
       
        $from = ' FROM civicrm_contact ';
        if ( empty( $tables ) ) {
            return $from;
        }
        
        if ( ( CRM_Utils_Array::value( 'civicrm_gender', $tables ) ||
               CRM_Utils_Array::value( 'civicrm_individual_prefix' , $tables ) ||
               CRM_Utils_Array::value( 'civicrm_individual_suffix' , $tables )) &&
             ! CRM_Utils_Array::value( 'civicrm_individual'       , $tables ) ) {
            $tables = array_merge( array( 'civicrm_individual' => 1 ),
                                   $tables );
        }        

        if ( ( CRM_Utils_Array::value( 'civicrm_state_province', $tables ) ||
               CRM_Utils_Array::value( 'civicrm_country'       , $tables ) ) &&
             ! CRM_Utils_Array::value( 'civicrm_address'       , $tables ) ) {
            $tables = array_merge( array( 'civicrm_location' => 1,
                                          'civicrm_address'  => 1 ),
                                   $tables );
        }
        // add location table if address / phone / email is set
        if ( ( CRM_Utils_Array::value( 'civicrm_address' , $tables ) ||
               CRM_Utils_Array::value( 'civicrm_phone'   , $tables ) ||
               CRM_Utils_Array::value( 'civicrm_email'   , $tables ) ||
               CRM_Utils_Array::value( 'civicrm_im'      , $tables ) ) &&
             ! CRM_Utils_Array::value( 'civicrm_location', $tables ) ) {
            $tables = array_merge( array( 'civicrm_location' => 1 ),
                                   $tables ); 
        }

        // add group_contact table if group table is present
        if ( CRM_Utils_Array::value( 'civicrm_group', $tables ) &&
            !CRM_Utils_Array::value('civicrm_group_contact', $tables)) {
            $tables['civicrm_group_contact'] = 1;
        }

        // add group_contact and group table is subscription history is present
        if ( CRM_Utils_Array::value( 'civicrm_subscription_history', $tables )
            && !CRM_Utils_Array::value('civicrm_group', $tables)) {
            $tables = array_merge( array( 'civicrm_group'         => 1,
                                          'civicrm_group_contact' => 1 ),
                                   $tables );
        }


        //format the table list according to the weight
        require_once 'CRM/Core/TableHierarchy.php';
        $info =& CRM_Core_TableHierarchy::info( );

        foreach ($tables as $key => $value) {
            $k = 99;
            if ( strpos( $key, '-' ) ) {
                $keyArray = explode('-', $key);
                if ( is_numeric( array_shift( $keyArray ) ) ) {
                    $k = CRM_Utils_Array::value( 'civicrm_' . $keyArray[0], $info, 99 );
                }
            } if ( strpos( $key, '_' ) ) {
                $keyArray = explode( '_', $key );
                if ( is_numeric( array_pop( $keyArray ) ) ) {
                    $k = CRM_Utils_Array::value( implode( '_', $keyArray ), $info, 99 );
                } else {
                    $k = CRM_Utils_Array::value($key, $info, 99 );
                }
            } else {
                $k = CRM_Utils_Array::value($key, $info, 99 );
            }
            $tempTable[$k . ".$key"] = $key;
        }
        
        ksort($tempTable);

        $newTables = array ();
        foreach ($tempTable as $key) {
            $newTables[$key] = $tables[$key];
        }

        $tables = $newTables;
        
        foreach ( $tables as $name => $value ) {
            if ( ! $value ) {
                continue;
            }

            if (CRM_Utils_Array::value($name, $inner)) {
                $side = 'INNER';
            } elseif (CRM_Utils_Array::value($name, $right)) {
                $side = 'RIGHT';
            } else {
                $side = 'LEFT';
            }
            
            if ( $value != 1 ) {
                // if there is already a join statement in value, use value itself
                if ( strpos( $value, 'JOIN' ) ) { 
                    $from .= " $value ";
                } else {
                    $from .= " $side JOIN $name ON ( $value ) ";
                }
                continue;
            }

            switch ( $name ) {

            case 'civicrm_individual':
                $from .= " $side JOIN civicrm_individual ON (civicrm_contact.id = civicrm_individual.contact_id) ";
                continue;

            case 'civicrm_household':
                $from .= " $side JOIN civicrm_household ON (civicrm_contact.id = civicrm_household.contact_id) ";
                continue;

            case 'civicrm_organization':
                $from .= " $side JOIN civicrm_organization ON (civicrm_contact.id = civicrm_organization.contact_id) ";
                continue;

            case 'civicrm_location':
                $from .= " $side JOIN civicrm_location ON (civicrm_location.entity_table = 'civicrm_contact' AND
                                                           civicrm_contact.id = civicrm_location.entity_id ";
                if ( $primaryLocation ) {
                    $from .= "AND civicrm_location.is_primary = 1";
                }
                $from .= ")";
                continue;

            case 'civicrm_address':
                $from .= " $side JOIN civicrm_address ON civicrm_location.id = civicrm_address.location_id ";
                continue;

            case 'civicrm_phone':
                $from .= " $side JOIN civicrm_phone ON (civicrm_location.id = civicrm_phone.location_id AND civicrm_phone.is_primary = 1) ";
                continue;

            case 'civicrm_email':
                $from .= " $side JOIN civicrm_email ON (civicrm_location.id = civicrm_email.location_id AND civicrm_email.is_primary = 1) ";
                continue;

            case 'civicrm_im':
                $from .= " $side JOIN civicrm_im ON (civicrm_location.id = civicrm_im.location_id AND civicrm_im.is_primary = 1) ";
                continue;

            case 'civicrm_im_provider':
                $from .= " $side JOIN civicrm_im_provider ON civicrm_im.provider_id = civicrm_im_provider.id ";
                continue;

            case 'civicrm_state_province':
                $from .= " $side JOIN civicrm_state_province ON civicrm_address.state_province_id = civicrm_state_province.id ";
                continue;

            case 'civicrm_country':
                $from .= " $side JOIN civicrm_country ON civicrm_address.country_id = civicrm_country.id ";
                continue;
            
            case 'civicrm_location_type':
                $from .= " $side JOIN civicrm_location_type ON civicrm_location.location_type_id = civicrm_location_type.id ";
                continue;

            case 'civicrm_group':
                $from .= " $side JOIN civicrm_group ON civicrm_group.id =  civicrm_group_contact.group_id ";
                continue;

            case 'civicrm_group_contact':
                $from .= " $side JOIN civicrm_group_contact ON civicrm_contact.id = civicrm_group_contact.contact_id ";
                continue;

            case 'civicrm_entity_tag':
                $from .= " $side JOIN civicrm_entity_tag ON ( civicrm_entity_tag.entity_table = 'civicrm_contact' AND
                                                             civicrm_contact.id = civicrm_entity_tag.entity_id ) ";
                continue;

            case 'civicrm_note':
                $from .= " $side JOIN civicrm_note ON ( civicrm_note.entity_table = 'civicrm_contact' AND
                                                        civicrm_contact.id = civicrm_note.entity_id ) "; 
                continue; 

            case 'civicrm_activity_history':
                $from .= " $side JOIN civicrm_activity_history ON ( civicrm_activity_history.entity_table = 'civicrm_contact' AND  
                                                               civicrm_contact.id = civicrm_activity_history.entity_id ) ";
                continue;

            case 'civicrm_custom_value':
                $from .= " $side JOIN civicrm_custom_value ON ( civicrm_custom_value.entity_table = 'civicrm_contact' AND
                                                          civicrm_contact.id = civicrm_custom_value.entity_id )";
                continue;
                
            case 'civicrm_subscription_history':
                $from .= " $side JOIN civicrm_subscription_history
                                   ON civicrm_group_contact.contact_id = civicrm_subscription_history.contact_id
                                  AND civicrm_group_contact.group_id   =  civicrm_subscription_history.group_id";
                continue;

            case 'civicrm_individual_prefix':
                $from .= " $side JOIN civicrm_individual_prefix ON civicrm_individual.prefix_id = civicrm_individual_prefix.id ";
                continue;
            
            case 'civicrm_individual_suffix':
                $from .= " $side JOIN civicrm_individual_suffix ON civicrm_individual.suffix_id = civicrm_individual_suffix.id ";
                continue;

            case 'civicrm_gender':
                $from .= " $side JOIN civicrm_gender ON civicrm_individual.gender_id = civicrm_gender.id ";
                continue;

            case 'civicrm_contribution':
                if ( $mode & CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE) {
                    $from .= " INNER JOIN civicrm_contribution ON civicrm_contribution.contact_id = civicrm_contact.id ";
                } else {
                    // keep it INNER for now, at some point we might make it a left join
                    $from .= " INNER JOIN civicrm_contribution ON civicrm_contribution.contact_id = civicrm_contact.id ";
                }
                continue;

            case 'civicrm_contribution_type':
                if ( $mode & CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE) {
                    $from .= " INNER JOIN civicrm_contribution_type ON civicrm_contribution.contribution_type_id = civicrm_contribution_type.id ";
                } else {
                    $from .= " $side JOIN civicrm_contribution_type ON civicrm_contribution.contribution_type_id = civicrm_contribution_type.id ";
                }
                continue;

            case 'civicrm_contribution_product':
                $from .= " $side  JOIN civicrm_contribution_product ON civicrm_contribution_product.contribution_id = civicrm_contribution.id";
                continue;
                
            case 'civicrm_product':
                $from .= " $side  JOIN civicrm_product ON civicrm_contribution_product.product_id =civicrm_product.id ";
                continue;
             
            case 'civicrm_payment_instrument':
                $from .= " $side  JOIN civicrm_payment_instrument ON civicrm_contribution.payment_instrument_id =civicrm_payment_instrument.id ";
                continue;

            case 'civicrm_entity_tag':
                $from .= " $side  JOIN  civicrm_entity_tag  ON ( civicrm_entity_tag.entity_table = 'civicrm_contact' 
                                                                  AND civicrm_contact.id = civicrm_entity_tag.entity_id )";
                continue; 
                
            case 'civicrm_tag':
                $from .= " $side  JOIN civicrm_tag ON civicrm_entity_tag.tag_id = civicrm_tag.id ";
                continue; 
                
            case 'civicrm_group_contact':
                $from .= " $side  JOIN  civicrm_group_contact ON civicrm_contact.id = civicrm_group_contact.contact_id ";
                continue; 
                
            case 'civicrm_group':
                $from .= " $side  JOIN civicrm_group ON civicrm_group_contact.group_id = civicrm_group.id ";
                continue; 
            }


        }
        return $from;
    }

    /**
     * where / qill clause for contact_type
     *
     * @return void
     * @access public
     */
    function contactType( ) {
        // check for contact type restriction 
        if ( ! CRM_Utils_Array::value( 'contact_type', $this->_params ) ) {
            return;
        }
        
        $clause = array( );
        if ( is_array( $this->_params['contact_type'] ) ) {
            foreach ( $this->_params['contact_type'] as $k => $v) { 
                if ($k) { //fix for CRM-771
                    $clause[] = "'" . CRM_Utils_Type::escape( $k, 'String' ) . "'";
                }
            }
        } else {
            $clause[] = "'" . CRM_Utils_Type::escape( $this->_params['contact_type'], 'String' ) . "'";
        }
        
        if ( !empty($clause) ) { //fix for CRM-771
            $this->_where[] = 'civicrm_contact.contact_type IN (' . implode( ',', $clause ) . ')';
            $this->_qill[]  = ts('Contact Type -') . ' ' . implode( ' ' . ts('or') . ' ', $clause );
        }
    }

    /**
     * where / qill clause for groups
     *
     * @return void
     * @access public
     */
    function group( ) {
        if ( ! CRM_Utils_Array::value( 'group', $this->_params ) ) {
            return;
        }

        if ( count( $this->_params['group'] ) > 1 ) {
            $this->_useDistinct = true;
        }

        $groupClause = 'civicrm_group_contact.group_id IN (' . 
            implode( ',', array_keys($this->_params['group']) ) . ')'; 

        $names = array( );
        $groupNames =& CRM_Core_PseudoConstant::group();
        foreach ( $this->_params['group'] as $id => $dontCare ) {
            $names[] = $groupNames[$id];
        }
        $this->_qill[]  = ts('Member of Group -') . ' ' . implode( ' ' . ts('or') . ' ', $names );
        
        $statii = array(); 
        $in = false; 
        if ( CRM_Utils_Array::value( 'group_contact_status', $this->_params ) &&
             is_array( $this->_params['group_contact_status'] ) ) {
            foreach ( $this->_params['group_contact_status'] as $k => $v ) {
                if ( $v ) {
                    if ( $k == 'Added' ) {
                        $in = true;
                    }
                    $statii[] = "'" . CRM_Utils_Type::escape($k, 'String') . "'";
                }
            }
        } else {
            $statii[] = '"Added"'; 
            $in = true; 
        }

        $groupClause .= ' AND civicrm_group_contact.status IN (' . implode(', ', $statii) . ')';
        $this->_tables['civicrm_group_contact'] = 1;
        $this->_whereTables['civicrm_group_contact'] = 1;
        $this->_qill[] = ts('Group Status -') . ' ' . implode( ' ' . ts('or') . ' ', $statii );

        if ( $in ) {
            $ssClause = $this->savedSearch( );
            if ( $ssClause ) {
                $groupClause = "( ( $groupClause ) OR ( $ssClause ) )";
            }
        }
        
        $this->_where[] = $groupClause;
    }

    /**
     * where / qill clause for smart groups
     *
     * @return void
     * @access public
     */
    function savedSearch( ) {
        $config =& CRM_Core_Config::singleton( );
        $ssWhere = array(); 
        $group =& new CRM_Contact_BAO_Group(); 
        foreach ( array_keys( $this->_params['group'] ) as $group_id ) { 
            $group->id = $group_id; 
            $group->find(true); 
            if (isset($group->saved_search_id)) {
                require_once 'CRM/Contact/BAO/SavedSearch.php';
                if ( $config->mysqlVersion >= 4.1 ) { 
                    $sfv =& CRM_Contact_BAO_SavedSearch::getFormValues($group->saved_search_id);

                    $smarts =& CRM_Contact_BAO_Contact::searchQuery($sfv, 0, 0, null,  
                                                                    false, false, false, true, true);
                    $ssWhere[] = " 
                            (civicrm_contact.id IN ($smarts)  
                            AND civicrm_contact.id NOT IN ( 
                            SELECT contact_id FROM civicrm_group_contact 
                            WHERE civicrm_group_contact.group_id = "  
                        . CRM_Utils_Type::escape($group_id, 'Integer')
                        . " AND civicrm_group_contact.status = 'Removed'))"; 
                } else { 
                    $ssw = CRM_Contact_BAO_SavedSearch::whereClause( $group->saved_search_id, $this->_tables, $this->_whereTables);
                    /* FIXME: bug with multiple group searches */ 
                    $ssWhere[] = "($ssw AND
                                   (civicrm_group_contact.id is null OR
                                     (civicrm_group_contact.group_id = " . CRM_Utils_Type::escape($group_id, 'Integer') . " AND
                                      civicrm_group_contact.status = 'Added')))"; 
                }
            }
            $group->reset(); 
            $group->selectAdd('*'); 
        }
        if ( ! empty( $ssWhere ) ) {
            $this->_tables['civicrm_group_contact'] =  
                "civicrm_contact.id = civicrm_group_contact.contact_id AND civicrm_group_contact.group_id IN (" .
                implode(',', array_keys($this->_params['group'])) . ')'; 
            $this->_whereTables['civicrm_group_contact'] = $this->_tables['civicrm_group_contact'];
            return implode(' OR ', $ssWhere);
        }
        return null;
    }

    /**
     * where / qill clause for tag
     *
     * @return void
     * @access public
     */
    function tag( ) {
        if ( ! CRM_Utils_Array::value( 'tag', $this->_params ) ) { 
            return; 
        } 

        if ( count( $this->_params['tag'] ) > 1 ) {
            $this->_useDistinct = true;
        }

        $names = array( );
        $tagNames =& CRM_Core_PseudoConstant::tag();
        foreach ( $this->_params['tag'] as $id => $dontCare ) {
            $names[] = $tagNames[$id];
        }
        $this->_qill[]  = ts('Tagged as -') . ' ' . implode( ' ' . ts('or') . ' ', $names ); 

        $this->_where[] = 'tag_id IN (' . implode( ',', array_keys( $this->_params['tag'] ) ) . ')';
        $this->_tables['civicrm_entity_tag'] = $this->_whereTables['civicrm_entity_tag'] = 1;
    } 

    /**
     * where / qill clause for sort_name
     *
     * @return void
     * @access public
     */
    function sortName( ) {
        if ( ! CRM_Utils_Array::value( 'sort_name', $this->_params ) ) {
            return;
        }

        $name = trim($this->_params['sort_name']); 

        $sub  = array( ); 
        // if we have a comma in the string, search for the entire string 
        if ( strpos( $name, ',' ) !== false ) { 
            $sub[] = " ( LOWER(civicrm_contact.sort_name) LIKE '%" . strtolower(addslashes($name)) . "%' )"; 
            $sub[] = " ( LOWER(civicrm_email.email)       LIKE '%" . strtolower(addslashes($name)) . "%' )"; 
            $this->_tables['civicrm_location'] = $this->_whereTables['civicrm_location'] = 1;
            $this->_tables['civicrm_email'] = $this->_whereTables['civicrm_email'] = 1; 
        } else { 
            // split the string into pieces 
            $pieces =  explode( ' ', $name ); 
            foreach ( $pieces as $piece ) { 
                $sub[] = " ( LOWER(civicrm_contact.sort_name) LIKE '%" . strtolower(addslashes(trim($piece))) . "%' ) "; 
                $sub[] = " ( LOWER(civicrm_email.email)       LIKE '%" . strtolower(addslashes(trim($piece))) . "%' )"; 
            } 
            $this->_tables['civicrm_location'] = $this->_whereTables['civicrm_location'] = 1;
            $this->_tables['civicrm_email']    = $this->_whereTables['civicrm_email'] = 1; 
        } 
        $this->_where[] = ' ( ' . implode( '  OR ', $sub ) . ' ) '; 
        $this->_qill[]  = ts( 'Name or Email like - "%1"', array( 1 => $name ) );
    }

    /**
     * where / qill clause for sorting by character
     *
     * @return void
     * @access public
     */
    function sortByCharacter( ) {
        if ( ! CRM_Utils_Array::value( 'sortByCharacter', $this->_params ) ) {
            return;
        }

        $name = trim( $this->_params['sortByCharacter'] );
        $cond = " LOWER(civicrm_contact.sort_name) LIKE '" . strtolower(addslashes($name)) . "%'"; 
        $this->_where[] = $cond;
        $this->_qill[]  = ts( 'Restricted to Contacts starting with: "%1"', array( 1 => $name ) );
    }

    /**
     * where / qill clause for including contact ids
     *
     * @return void
     * @access public
     */
    function includeContactIDs( ) {
        if ( ! $this->_includeContactIds || empty( $this->_params ) ) {
            return;
        }

        $contactIds = array( ); 
        foreach ( $this->_params as $name => $value ) { 
            if ( substr( $name, 0, CRM_CORE_FORM_CB_PREFIX_LEN ) == CRM_CORE_FORM_CB_PREFIX ) { 
                $contactIds[] = substr( $name, CRM_CORE_FORM_CB_PREFIX_LEN ); 
            } 
        } 
        if ( ! empty( $contactIds ) ) { 
            $this->_where[] = " ( civicrm_contact.id in (" . implode( ',', $contactIds ) . " ) ) "; 
            //$this->whereClause = 'WHERE ' . implode( ' AND ', $this->_where ); // fixed for CRM-611
            $this->_whereClause = implode( ' AND ', $this->_where );
        }
    }

    /**
     * where / qill clause for postal code
     *
     * @return void
     * @access public
     */
    function postalCode( ) {
        // skip if the fields dont have anything to do with postal_code
        if ( ! CRM_Utils_Array::value( 'postal_code', $this->_fields ) ) {
            return;
        }

        // postal code processing 
        if ( CRM_Utils_Array::value( 'postal_code'     , $this->_params ) || 
             CRM_Utils_Array::value( 'postal_code_low' , $this->_params ) || 
             CRM_Utils_Array::value( 'postal_code_high', $this->_params ) ) { 
            // we need to do postal code processing 
            $pcArray   = array(); 
 
            if ($this->_params['postal_code']) { 
                $this->_where[] = 'civicrm_address.postal_code = "' .
                    CRM_Utils_Type::escape( $this->_params['postal_code'], 'String' ) .
                    '"'; 
                $this->_tables['civicrm_location'] = $this->_tables['civicrm_address' ] = 1;
                $this->_whereTables['civicrm_location'] = $this->_whereTables['civicrm_address' ] = 1;
                $this->_qill[] = ts('Postal code - "%1"', array( 1 => $this->_params['postal_code'] ) );
            } else {
                $qill = array( );
                if ($this->_params['postal_code_low']) { 
                    $pcArray[] = ' ( civicrm_address.postal_code >= "' .
                        CRM_Utils_Type::escape( $this->_params['postal_code_low'], 'String' ) . 
                        '" ) ';
                    $qill[] = ts( 'greater than "%1"', array( 1 => $this->_params['postal_code_low'] ) );
                } 
                if ($this->_params['postal_code_high']) { 
                    $pcArray[] = ' ( civicrm_address.postal_code <= "' .
                        CRM_Utils_Type::escape( $this->_params['postal_code_high'], 'String' ) . 
                        '" ) ';
                    $qill[] = ts( 'less than "%1"', array( 1 => $this->_params['postal_code_high'] ) );
                }
                if ( !empty( $pcArray ) ) {
                    $this->_where[] = '(' . implode( ' AND ', $pcArray ) . ')';
                    $this->_tables['civicrm_location'] = $this->_tables['civicrm_address' ] = 1;
                    $this->_whereTables['civicrm_location'] = $this->_whereTables['civicrm_address' ] = 1;

                    $this->_qill[]  = ts('Postal code -') . ' ' . implode( ' ' . ts('and') . ' ', $qill );
                }
            }
        }
    }

    /**
     * where / qill clause for location type and location Name
     *
     * @return void
     * @access public
     */
    function locationTypeAndName( $status = null ) {
        if ( CRM_Utils_Array::value( 'location_type', $this->_params ) ) {
            if (is_array($this->_params['location_type'])) {
                $this->_where[] = 'civicrm_location.location_type_id IN (' .
                    implode( ',', array_keys( $this->_params['location_type'] ) ) .
                    ')';
                $this->_tables['civicrm_location'] = 1;
                $this->_whereTables['civicrm_location'] = 1;
                
                $locationType =& CRM_Core_PseudoConstant::locationType();
                $names = array( );
                foreach ( array_keys( $this->_params['location_type'] ) as $id ) {
                    $names[] = $locationType[$id];
                }

                $this->_primaryLocation = false;
                
                if (!$status) {
                    $this->_qill[] = ts('Location type -') . ' ' . implode( ' ' . ts('or') . ' ', $names );
                } else {
                    return implode( ' ' . ts('or') . ' ', $names );
                }
            }
        }

        // do the same for location name
        if ( CRM_Utils_Array::value( 'location_name', $this->_params ) ) {
            $this->_where[] = "civicrm_location.name LIKE '%" .
                strtolower(addslashes(trim($this->_params['location_name']))) . "%'";
            $this->_tables['civicrm_location'] = 1;
            $this->_whereTables['civicrm_location'] = 1;
            $this->_qill[] = ts( 'Location name like "%1"', array( 1 => $this->_params['location_name'] ) );
        }
    }

    /**
     * where / qill clause for activity types
     *
     * @return void
     * @access public
     */
    function activity( ) {
        if ( CRM_Utils_Array::value( 'activity_type', $this->_params ) ) {
            $name = trim($this->_params['activity_type']); 

            // split the string into pieces 
            $pieces =  explode( ' ', $name ); 
            $sub    = array( );
            foreach ( $pieces as $piece ) { 
                $sub[] = " LOWER(civicrm_activity_history.activity_type) LIKE '%" . strtolower(addslashes(trim($piece))) . "%'"; 
            } 
            $this->_where[] = ' ( ' . implode( '  OR ', $sub ) . ' ) ';
            $this->_tables['civicrm_activity_history'] = $this->_whereTables['civicrm_activity_history'] = 1; 
            $this->_qill[]  = ts('Activity Type like - "%1"', array( 1 => $name ) );
        }

        $qill = array( );

        $this->dateQueryBuilder( 'civicrm_activity_history', 'activity_date', 'activity_date', 'Activity Date' );
    }

    function contribution( ) {
        $config =& CRM_Core_Config::singleton( ); 
        if (  ! in_array( 'CiviContribute', $config->enableComponents) ) {
            return;
        }

        // process to / from date
        $this->dateQueryBuilder( 'civicrm_contribution', 'contribution_date', 'receive_date', 'Contribution Date' );
        $qill = array( );
        if ( isset( $this->_params['contribution_date_from'] ) ) { 
            $revDate = array_reverse( $this->_params['contribution_date_from'] ); 
            $date    = CRM_Utils_Date::format( $revDate ); 
            $format  = CRM_Utils_Date::customFormat( CRM_Utils_Date::format( $revDate, '-' ) ); 
            if ( $date ) { 
                $this->_where[] = "civicrm_contribution.receive_date >= '$date'";  
                $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1; 
                $qill[] = ts( 'greater than "%1"', array( 1 => $format ) ); 
            } 
        }  
 
        if ( isset( $this->_params['contribution_date_to'] ) ) { 
            $revDate = array_reverse( $this->_params['contribution_date_to'] ); 
            $date    = CRM_Utils_Date::format( $revDate ); 
            $format  = CRM_Utils_Date::customFormat( CRM_Utils_Date::format( $revDate, '-' ) ); 
            if ( $date ) { 
                $this->_where[] = " ( civicrm_contribution.receive_date <= '$date' ) ";  
                $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;  
                $qill[] = ts( 'less than "%1"', array( 1 => $format ) ); 
            } 
        } 
         
        if ( ! empty( $qill ) ) { 
            $this->_qill[] = ts('Contribution Date - %1', array( 1 => implode( ' ' . ts('and') . ' ', $qill ) ) ); 
        } 

        // process min/max amount
        $qill = array( ); 
        if ( isset( $this->_params['contribution_min_amount'] ) ) {  
            $amount = $this->_params['contribution_min_amount'];
            if ( $amount > 0 ) {
                $this->_where[] = "civicrm_contribution.total_amount >= $amount";
                $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;  
                $qill[] = ts( 'greater than "%1"', array( 1 => $amount ) );
            } 
        }
    
        if ( isset( $this->_params['contribution_max_amount'] ) ) {  
            $amount = $this->_params['contribution_max_amount'];
            if ( $amount > 0 ) {
                $this->_where[] = "civicrm_contribution.total_amount <= $amount";
                $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;   
                $qill[] = ts( 'less than "%1"', array( 1 => $amount ) );
            }
        }

        if ( ! empty( $qill ) ) {  
            $this->_qill[] = ts('Contribution Amount - %1', array( 1 => implode( ' ' . ts('and') . ' ', $qill ) ) );  
        }  

        if ( CRM_Utils_Array::value( 'contribution_thankyou_date_isnull', $this->_params ) ) {
            $this->_where[] = "civicrm_contribution.thankyou_date is null";
            $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;
            $this->_qill[] = ts( 'Contribution Thank-you date is null' );
        }

        if ( CRM_Utils_Array::value( 'contribution_receipt_date_isnull', $this->_params ) ) {
            $this->_where[] = "civicrm_contribution.receipt_date is null";
            $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;
            $this->_qill[] = ts( 'Contribution Receipt date is null' );
        }

        if ( CRM_Utils_Array::value( 'contribution_type_id', $this->_params ) ) {
            require_once 'CRM/Contribute/PseudoConstant.php';
            $cType = $this->_params['contribution_type_id'];
            $types = CRM_Contribute_PseudoConstant::contributionType( );
            $this->_where[] = "civicrm_contribution.contribution_type_id = $cType";
            $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;
            $this->_qill[] = ts( 'Contribution Type - %1', array( 1 => $types[$cType] ) );
        }

        if ( CRM_Utils_Array::value( 'payment_instrument_id', $this->_params ) ) {
            require_once 'CRM/Contribute/PseudoConstant.php';
            $pi = $this->_params['payment_instrument_id'];
            $pis = CRM_Contribute_PseudoConstant::paymentInstrument( );
            $this->_where[] = "civicrm_contribution.payment_instrument_id = $pi";
            $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;
            $this->_qill[] = ts( 'Paid By - %1', array( 1 => $pis[$pi] ) );
        }

        if ( isset( $this->_params['contribution_status'] ) ) {
            switch( $this->_params['contribution_status'] ) {
            case 'Valid':
                $this->_where[] = "civicrm_contribution.cancel_date is null";
                $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;
                $this->_qill[]  = ts( 'Contribution Status - Valid' );
                break;

            case 'Cancelled':
                $this->_where[] = "civicrm_contribution.cancel_date is not null";
                $this->_tables['civicrm_contribution'] = $this->_whereTables['civicrm_contribution'] = 1;
                $this->_qill[]  = ts( 'Contribution Status - Cancelled' );
                break;
            }
        }
    }

    /**
     * default set of return properties
     *
     * @return void
     * @access public
     */
     function &defaultReturnProperties( $mode = 1 ) {
        if ( ! isset( $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'] ) ) {
            $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'] = array( );
            if ( $mode & CRM_CONTACT_BAO_QUERY_MODE_CONTACTS) {
                $properties = array( 
                                    'home_URL'               => 1, 
                                    'image_URL'              => 1, 
                                    'legal_identifier'       => 1, 
                                    'external_identifier'    => 1,
                                    'contact_type'           => 1,
                                    'sort_name'              => 1,
                                    'display_name'           => 1,
                                    'nick_name'              => 1, 
                                    'first_name'             => 1, 
                                    'middle_name'            => 1, 
                                    'last_name'              => 1, 
                                    'prefix'                 => 1, 
                                    'suffix'                 => 1,
                                    'birth_date'             => 1,
                                    'gender'                 => 1,
                                    'street_address'         => 1, 
                                    'supplemental_address_1' => 1, 
                                    'supplemental_address_2' => 1, 
                                    'city'                   => 1, 
                                    'postal_code'            => 1, 
                                    'postal_code_suffix'     => 1, 
                                    'state_province'         => 1, 
                                    'country'                => 1,
                                    'geo_code_1'             => 1,
                                    'geo_code_2'             => 1,
                                    'email'                  => 1, 
                                    'phone'                  => 1, 
                                    'im'                     => 1, 
                                    ); 
                $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'] = array_merge( $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'],
                                                               $properties );
            }

            if ( $mode & CRM_CONTACT_BAO_QUERY_MODE_CONTRIBUTE) {
                $properties = array(  
                                    'contact_type'           => 1, 
                                    'sort_name'              => 1, 
                                    'display_name'           => 1,
                                    'contribution_type'      => 1,
                                    'source'                 => 1,
                                    'receive_date'           => 1,
                                    'thankyou_date'          => 1,
                                    'cancel_date'            => 1,
                                    'total_amount'           => 1,
                                    'accounting_code'        => 1,
                                    'payment_instrument'     => 1,
                                    'non_deductible_amount'  => 1,
                                    'fee_amount'             => 1,
                                    'net_amount'             => 1,
                                    'trxn_id'                => 1,
                                    'invoice_id'             => 1,
                                    'currency'               => 1,
                                    'cancel_date'            => 1,
                                    'cancel_reason'          => 1,
                                    'receipt_date'           => 1,
                                    'thankyou_date'          => 1,
                                    'source'                 => 1,
                                    'name'                   => 1,
                                    'sku'                    => 1,
                                    'product_option'         => 1,
                                    'fulfilled_date'         => 1,
                                    'start_date'             => 1,
                                    'end_date'               => 1,
                                    );

                // also get all the custom contribution properties
                $fields = CRM_Core_BAO_CustomField::getFieldsForImport('Contribution');
                if ( ! empty( $fields ) ) {
                    foreach ( $fields as $name => $dontCare ) {
                        $properties[$name] = 1;
                    }
                }
                $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'] = array_merge( $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'],
                                                               $properties );
            }
        }
        return $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultReturnProperties'];
    }

    /**
     * get primary condition for a sql clause
     *
     * @param int $value
     *
     * @return void
     * @access public
     */
     function getPrimaryCondition( $value ) {
        if ( is_numeric( $value ) ) {
            $value = (int ) $value;
            return ( $value == 1 ) ?'is_primary = 1' : 'is_primary = 0';
        }
        return null;
    }

    /**
     * wrapper for a simple search query
     *
     * @param array $params
     * @param array $returnProperties
     * @param bolean $count
     *
     * @return void 
     * @access public 
     */
     function getQuery( $params = null, $returnProperties = null, $count = false ) {
        $query =& new CRM_Contact_BAO_Query( $params, $returnProperties );
        list( $select, $from, $where ) = $query->query( );
        return "$select $from $where";
    }

    /**
     * wrapper for a api search query
     *
     * @param array  $params
     * @param array  $returnProperties
     * @param string $sort
     * @param int    $offset
     * @param int    $row_count
     *
     * @return void 
     * @access public 
     */
     function apiQuery( $params = null, $returnProperties = null, $options = null ,$sort = null, $offset = 0, $row_count = 25 ) {
        $query = new CRM_Contact_BAO_Query( $params, $returnProperties, null );
        list( $select, $from, $where ) = $query->query( );
        $options = $query->_options;
        $sql = "$select $from $where";
        if ( ! empty( $sort ) ) {
            $sql .= " ORDER BY $sort ";
        }
        if ( $row_count > 0 && $offset >= 0 ) {
            $sql .= " LIMIT $offset, $row_count ";
        }

        $dao =& CRM_Core_DAO::executeQuery( $sql );

        $values = array( );
        while ( $dao->fetch( ) ) {
            $values[$dao->contact_id] = $query->store( $dao );
        }
        
        return array($values, $options);
    }



    /**
     * create and query the db for an contact search
     *
     * @param int      $offset   the offset for the query
     * @param int      $rowCount the number of rows to return
     * @param string   $sort     the order by string
     * @param boolean  $count    is this a count only query ?
     * @param boolean  $includeContactIds should we include contact ids?
     * @param boolean  $sortByChar if true returns the distinct array of first characters for search results
     * @param boolean  $groupContacts if true, use a single mysql group_concat statement to get the contact ids
     * @param boolean  $returnQuery   should we return the query as a string
     * @param string   $additionalWhereClause if the caller wants to further restrict the search (used in contributions)
     *
     * @return CRM_Contact_DAO_Contact 
     * @access public
     */
    function searchQuery( $offset = 0, $rowCount = 0, $sort = null, 
                          $count = false, $includeContactIds = false,
                          $sortByChar = false, $groupContacts = false,
                          $returnQuery = false,
                          $additionalWhereClause = null ) {
        require_once 'CRM/Core/Permission.php';

        if ( $includeContactIds ) {
            $this->_includeContactIds = true;
            $this->includeContactIds( );
        }

        // hack for now, add permission only if we are in search
        $permission = ' ( 1 ) ';
        if ( $this->_search ) {
            $permission = CRM_Core_Permission::whereClause( CRM_CORE_PERMISSION_VIEW, $this->_tables, $this->_whereTables );
            
            // regenerate fromClause since permission might have added tables
            if ( $permission ) {
                $this->_fromClause  = CRM_Contact_BAO_Query::fromClause( $this->_tables, null, null, $this->_primaryLocation, $this->_mode ); 
                $this->_simpleFromClause = CRM_Contact_BAO_Query::fromClause( $this->_whereTables, null, null, $this->_primaryLocation, $this->_mode );
            }
        }

        list( $select, $from, $where ) = $this->query( $count, $sortByChar, $groupContacts );
        
        if ( empty( $where ) ) {
            $where = 'WHERE ' . $permission;
        } else {
            $where = $where . ' AND ' . $permission;
        }

        if ( $additionalWhereClause ) {
            $where = $where . ' AND ' . $additionalWhereClause;
        }
        
        $order = $limit = '';

        if ( ! $count ) {
            if ($sort) {
                $orderBy = trim( $sort->orderBy() );
                if ( ! empty( $orderBy ) ) {
                    $order = " ORDER BY $orderBy";
                }
            } else if ($sortByChar) { 
                $order = " ORDER BY LEFT(civicrm_contact.sort_name, 1) ";
            }

            if ( $rowCount > 0 && $offset >= 0 ) {
                $limit = " LIMIT $offset, $rowCount ";
            }
        }

        // building the query string
        $query = "$select $from $where $order $limit";
        //CRM_Core_Error::debug( 'q', $query );

        if ( $returnQuery ) {
            return $query;
        }
        
        if ( $count ) {
            return CRM_Core_DAO::singleValueQuery( $query );
        }

        // CRM_Core_Error::debug( 'q', $query );
        $dao =& CRM_Core_DAO::executeQuery( $query );
        if ( $groupContacts ) {
            $ids = array( );
            while ( $dao->fetch( ) ) {
                $ids[] = $dao->id;
            }
            return implode( ',', $ids );
        }

        return $dao;
    }

    /**
     * getter for the qill object
     *
     * @return string
     * @access public
     */
    function qill( ) {
        return $this->_qill;
    }


    /**
     * default set of return default hier return properties
     *
     * @return void
     * @access public
     */
     function &defaultHierReturnProperties( ) {
        if ( ! isset( $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultHierReturnProperties'] ) ) {
            $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultHierReturnProperties'] = array(
                                                        'home_URL'               => 1, 
                                                        'image_URL'              => 1, 
                                                        'legal_identifier'       => 1, 
                                                        'external_identifier'    => 1,
                                                        'contact_type'           => 1,
                                                        'sort_name'              => 1,
                                                        'display_name'           => 1,
                                                        'nick_name'              => 1, 
                                                        'first_name'             => 1, 
                                                        'middle_name'            => 1, 
                                                        'last_name'              => 1, 
                                                        'individual_prefix'      => 1, 
                                                        'individual_suffix'      => 1,
                                                        'birth_date'             => 1,
                                                        'gender'                 => 1,
                                                        'preferred_communication_method' => 1,
                                                        'do_not_phone'                   => 1, 
                                                        'do_not_email'                   => 1, 
                                                        'do_not_mail'                    => 1, 
                                                        'do_not_trade'                   => 1, 
                                                        'location'                       => 
                                                        array( '1' => array ( 'location_type'      => 1,
                                                                              'street_address'     => 1,
                                                                              'city'               => 1,
                                                                              'state_province'     => 1,
                                                                              'postal_code'        => 1, 
                                                                              'postal_code_suffix' => 1, 
                                                                              'country'            => 1,
                                                                              'phone-Phone'        => 1,
                                                                              'phone-Mobile'       => 1,
                                                                              'phone-Fax'          => 1,
                                                                              'phone-1'            => 1,
                                                                              'phone-2'            => 1,
                                                                              'phone-3'            => 1,
                                                                              'im-1'               => 1,
                                                                              'im-2'               => 1,
                                                                              'im-3'               => 1,
                                                                              'email-1'            => 1,
                                                                              'email-2'            => 1,
                                                                              'email-3'            => 1,
                                                                              ),
                                                               '2' => array ( 
                                                                             'location_type'      => 1,
                                                                             'street_address'     => 1, 
                                                                             'city'               => 1, 
                                                                             'state_province'     => 1, 
                                                                             'postal_code'        => 1, 
                                                                             'postal_code_suffix' => 1, 
                                                                             'country'            => 1, 
                                                                             'phone-Phone'        => 1,
                                                                             'phone-Mobile'       => 1,
                                                                             'phone-1'            => 1,
                                                                             'phone-2'            => 1,
                                                                             'phone-3'            => 1,
                                                                             'im-1'               => 1,
                                                                             'im-2'               => 1,
                                                                             'im-3'               => 1,
                                                                             'email-1'            => 1,
                                                                             'email-2'            => 1,
                                                                             'email-3'            => 1,
                                                                             ) 
                                                               ),
                                                        );
            
        }
        return $GLOBALS['_CRM_CONTACT_BAO_QUERY']['_defaultHierReturnProperties'];
    }

    function dateQueryBuilder( $tableName, $fieldName, $dbFieldName, $fieldTitle ) {
        $qill = array( );

        if ( $this->_params[ $fieldName . '_from' ]['M'] ) {
            $revDate = array_reverse( $this->_params[ $fieldName . '_from' ] );
            $date    = CRM_Utils_Date::format( $revDate ); 
            $format  = CRM_Utils_Date::customFormat( CRM_Utils_Date::format( $revDate, '-' ) );
            if ( $date ) {
                $this->_where[] = $tableName . '.' . $dbFieldName . " >= '$date'";
                $this->_tables[$tableName] = $this->_whereTables[$tableName] = 1;
                $qill[] = ts( 'greater than "%1"', array( 1 => $format ) );
            }
        }

        if ( $this->_params[ $fieldName . '_to' ]['M'] ) {
            $revDate = array_reverse( $this->_params[ $fieldName . '_to' ] );
            $date    = CRM_Utils_Date::format( $revDate ); 
            $format  = CRM_Utils_Date::customFormat( CRM_Utils_Date::format( $revDate, '-' ) );
            if ( $date ) {
                $this->_where[] = $tableName . '.' . $dbFieldName . " <= '$date'";
                $this->_tables[$tableName] = $this->_whereTables[$tableName] = 1;
                $qill[] = ts( 'less than "%1"', array( 1 => $format ) );
            }
        }

        if ( ! empty( $qill ) ) {
            $this->_qill[] = $fieldTitle . ' - ' . implode( ' ' . ts('and') . ' ', $qill );
        }
    }

}

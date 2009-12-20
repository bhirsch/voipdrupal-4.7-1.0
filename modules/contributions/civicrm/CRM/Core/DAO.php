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
 * Our base DAO class. All DAO classes should inherit from this class.
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_CORE_DAO_NOT_NULL',1);
define( 'CRM_CORE_DAO_IS_NULL',2);
define( 'CRM_CORE_DAO_DB_DAO_NOTNULL',128);
$GLOBALS['_CRM_CORE_DAO']['_factory'] =  null;
$GLOBALS['_CRM_CORE_DAO']['_singleton'] =  null;
$GLOBALS['_CRM_CORE_DAO']['keys'] = null;
$GLOBALS['_CRM_CORE_DAO']['sequenceKeys'] = null;

require_once 'PEAR.php';
require_once 'DB/DataObject.php';

require_once 'CRM/Utils/Date.php';
require_once 'CRM/Core/I18n.php';
require_once 'CRM/Core/PseudoConstant.php';

class CRM_Core_DAO extends DB_DataObject {

    
                  
                   

          

    /**
     * the factory class for this application
     * @var object
     */
    

    /**
     * We use this object to encapsulate transactions
     *
     * @var object
     * @static
     */
    

    /**
     * Class constructor
     *
     * @return object
     * @access public
     */
    function CRM_Core_DAO() {
        $this->initialize( );
        $this->__table = $this->getTableName();
    }

    /**
     * empty definition for virtual function
     */
	function getTableName( ) {
        return null;
    }

    /**
     * initialize the DAO object
     *
     * @param string $dsn   the database connection string
     * @param int    $debug the debug level for DB_DataObject
     *
     * @return void
     * @access private
     */
    function init( $dsn, $debug = 0 ) {
        $options =& PEAR::getStaticProperty('DB_DataObject', 'options');
        $options =  array(
                          'database'         => $dsn,
                          );
    
        if ( $debug ) {
            CRM_Core_DAO::DebugLevel($debug);
        }
    }
	
    /**
     * reset the DAO object. DAO is kinda crappy in that there is an unwritten
     * rule of one query per DAO. We attempt to get around this crappy restricrion
     * by resetting some of DAO's internal fields. Use this with caution
     *
     * @return void
     * @access public
     *
     */
    function reset() {
        
        foreach( array_keys( $this->table() ) as $field ) {
            unset($this->$field);
        }

        /**
         * reset the various DB_DAO structures manually
         */
        $this->_query = array( );
        $this->whereAdd ( );
        $this->selectAdd( );
        $this->joinAdd  ( );
    }
	
    /**
     * Static function to set the factory instance for this class.
     *
     * @param object $factory  the factory application object
     *
     * @return void
     * @access public
     */
    function setFactory(&$factory) {
        $GLOBALS['_CRM_CORE_DAO']['_factory'] =& $factory;
    }
	
    /**
     * Factory method to instantiate a new object from a table name.
     *
     * @return void 
     * @access public
     */
    function factory($table) {
        if ( ! isset( $GLOBALS['_CRM_CORE_DAO']['_factory'] ) ) {
            return parent::factory($table);
        }
		
        return $GLOBALS['_CRM_CORE_DAO']['_factory']->create($table);
    }
	
    /**
     * Initialization for all DAO objects. Since we access DB_DO programatically
     * we need to set the links manually.
     *
     * @return void
     * @access protected
     */
    function initialize() {
        $links = $this->links();
        if ( empty( $links ) ) {
            return;
        }

        $this->_connect();
    
        if ( !isset($GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database]) ) {
            $GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database] = array();
        }
	    
        if ( ! array_key_exists( $this->__table, $GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database] ) ) {
            $GLOBALS['_DB_DATAOBJECT']['LINKS'][$this->_database][$this->__table] = $links;
        }
    }
	
    /**
     * Defines the default key as 'id'.
     *
     * @access protected
     * @return array
     */
    function keys() {
        
        if ( !isset ($GLOBALS['_CRM_CORE_DAO']['keys']) ) {
            $GLOBALS['_CRM_CORE_DAO']['keys'] = array('id');
        }
        return $GLOBALS['_CRM_CORE_DAO']['keys'];
    }
    
    /**
     * Tells DB_DataObject which keys use autoincrement.
     * 'id' is autoincrementing by default.
     * 
     * @access protected
     * @return array
     */
    function sequenceKey() {
        
        if ( !isset ($GLOBALS['_CRM_CORE_DAO']['sequenceKeys']) ) {
            $GLOBALS['_CRM_CORE_DAO']['sequenceKeys'] = array('id', true);
        }
        return $GLOBALS['_CRM_CORE_DAO']['sequenceKeys'];
    }

    /**
     * returns list of FK relationships
     *
     * @access public
     * @return array
     */
    function links( ) {
        return null;
    }


    /**
     * returns all the column names of this table
     *
     * @access public
     * @return array
     */
    function &fields( ) {
        return null;
    }

    function table() {
        $fields =& $this->fields();

        $table = array();
        foreach ( $fields as $name => $value ) {
            $table[$name] = $value['type'];
            if ( CRM_Utils_Array::value( 'required', $value ) ) {
                $table[$name] += CRM_CORE_DAO_DB_DAO_NOTNULL;
            }
        }

        // set the links
        $this->links();

        return $table;
    }

    function save( ) {
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;
    }

    /**
     * Given an associative array of name/value pairs, extract all the values
     * that belong to this object and initialize the object with said values
     *
     * @param array $params (reference ) associative array of name/value pairs
     *
     * @return boolean      did we copy all null values into the object
     * @access public
     */
    function copyValues( &$params ) {
        $fields =& $this->fields( );
        $allNull = true;
        foreach ( $fields as $name => $value ) {
            if ( array_key_exists( $name, $params ) ) {
                // if there is no value then make the variable NULL
                if ( $params[$name] == '' ) {
                    $this->$name = 'null';
                } else {
                    $this->$name = $params[$name];
                    $allNull = false;
                }
            }
        }
        return $allNull;
    }

    /**
     * Store all the values from this object in an associative array
     * this is a destructive store, calling function is responsible
     * for keeping sanity of id's. Note that this function is rewritten
     * to sidestep a wierd PHP4 bug
     *
     * @param object $object the object that we are extracting data from
     * @param array  $values (reference ) associative array of name/value pairs
     *
     * @return void
     * @access public
     */
    function storeValues( &$object, &$values ) {
        $fields =& $object->fields( );
        foreach ( $fields as $name => $value ) {
            if ( isset( $object->$name ) ) {
                $values[$name] = $object->$name;
            }
        }
    }

    /**
     * create an attribute for this specific field. We only do this for strings and text
     *
     * @param array $field the field under task
     *
     * @return array|null the attributes for the object
     * @access public
     * @static
     */
     function makeAttribute( $field ) {
        if ( $field ) {
            if ( $field['type'] == CRM_UTILS_TYPE_T_STRING ) {
                $maxLength  = CRM_Utils_Array::value( 'maxlength', $field );
                $size       = CRM_Utils_Array::value( 'size'     , $field );
                if ( $maxLength || $size ) {
                    $attributes = array( );
                    if ( $maxLength ) {
                        $attributes['maxlength'] = $maxLength;
                    }
                    if ( $size ) {
                        $attributes['size'] = $size;
                    }
                    return $attributes;
                }
            } else if ( $field['type'] == CRM_UTILS_TYPE_T_TEXT ) {
                $rows = CRM_Utils_Array::value( 'rows', $field );
                if ( ! isset( $rows ) ) {
                    $rows = 2;
                }
                $cols = CRM_Utils_Array::value( 'cols', $field );
                if ( ! isset( $cols ) ) {
                    $cols = 80;
                }

                $attributes = array( );
                $attributes['rows'] = $rows;
                $attributes['cols'] = $cols;
                return $attributes;
            } else if ( $field['type'] == CRM_UTILS_TYPE_T_INT || $field['type'] == CRM_UTILS_TYPE_T_FLOAT ) {
                $attributes['size']      = 4;
                $attributes['maxlength'] = 8; 
                return $attributes;
            }
        }
        return null;
    }

    /**
     * Get the size and maxLength attributes for this text field
     * (or for all text fields) in the DAO object.
     *
     * @param string $class     name of DAO class
     * @param string $fieldName field that i'm interested in or null if 
     *                          you want the attributes for all DAO text fields
     *
     * @return array assoc array of name => attribute pairs
     * @access public
     * @static
     */
    function getAttribute( $class, $fieldName = null) {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php');
        eval('$fields =& ' . $class . '::fields( );');
        if ( $fieldName != null ) {
            $field = CRM_Utils_Array::value( $fieldName, $fields );
            return CRM_Core_DAO::makeAttribute( $field );
        } else {
            $attributes = array( );
            foreach ($fields as $name => $field) {
                $attribute = CRM_Core_DAO::makeAttribute( $field );
                if ( $attribute ) {
                    $attributes[$name] = $attribute;
                }
            }
            if ( !empty($attributes)) {
                return $attributes;
            }
        }
        return null;
    }

    /**
     * Function to begin/commit/rollback a transaction
     *
     * @param string $type an enum which is either BEGIN|COMMIT|ROLLBACK
     * 
     * @return void
     * @access public
     */
     function transaction( $type ) {
        if ( $GLOBALS['_CRM_CORE_DAO']['_singleton'] == null ) {
            $GLOBALS['_CRM_CORE_DAO']['_singleton'] =& new CRM_Core_DAO( );
        }
        $GLOBALS['_CRM_CORE_DAO']['_singleton']->query( $type );
    }

    /**
     * Check if there is a record with the same name in the db
     *
     * @param string $value     the value of the field we are checking
     * @param string $daoName   the dao object name
     * @param string $daoID     the id of the object being updated. u can change your name
     *                          as long as there is no conflict
     * @param string $fieldName the name of the field in the DAO
     *
     * @return boolean     true if object exists
     * @access public
     * @static
     */
     function objectExists( $value, $daoName, $daoID, $fieldName = 'name' ) {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $daoName) . ".php");
        eval( '$object =& new ' . $daoName . '( );' );
        $object->$fieldName = $value;

        $config  =& CRM_Core_Config::singleton( );

        if ( $object->find( true ) ) {
            return ( $daoID && $object->id == $daoID ) ? true : false;
        } else {
            return true;
        }
    }

    /**
     * Given a DAO name and its id, get the value of the field requested
     *
     * @param string $daoName   the name of the DAO
     * @param int    $id        the id of the relevant object 
     * @param string $fieldName the name of the field whose value is needed
     *
     * @return string|null      the value of the field
     * @static
     * @access public
     */
     function getFieldValue( $daoName, $id, $fieldName = 'name' ) {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $daoName) . ".php");
        eval( '$object =& new ' . $daoName . '( );' );
        $object->id    = $id;
        $object->selectAdd( );
        $object->selectAdd( 'id, ' . $fieldName );
        if ( $object->find( true ) ) {
            return $object->$fieldName;
        }
        return null;
     }

    /**
     * Given a DAO name and its id, get the value of the field requested
     *
     * @param string $daoName   the name of the DAO
     * @param int    $id        the id of the relevant object
     * @param string $fieldName the name of the field whose value is needed
     * @param string $value     the value of the field
     *
     * @return boolean          true if we found and updated the object, else false
     * @static
     * @access public
     */
     function setFieldValue( $daoName, $id, $fieldName, $value ) {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $daoName) . ".php");
        eval( '$object =& new ' . $daoName . '( );' );
        $object->selectAdd( );
        $object->selectAdd( 'id, ' . $fieldName );
        $object->id    = $id;
        if ( $object->find( true ) ) {
            $object->$fieldName = $value;
            if ( $object->save( ) ) {
                return true;
            }
        }
        return false;
    }


    /**
     * Get sort string
     *
     * @param array|object $sort either array or CRM_Utils_Sort
     * @param string $default - default sort value
     *
     * @return string - sortString
     * @access public
     * @static
     */
     function getSortString($sort, $default = null)
    {
        // check if sort is of type CRM_Utils_Sort
        if ( is_a( $sort, 'CRM_Utils_Sort' ) ) {
            return $sort->orderBy();
        }

        // is it an array specified as $field => $sortDirection ?
        if ( $sort ) {
            foreach ( $sort as $k => $v ) {
                $sortString .= "$k $v,";
            }
            return rtrim( $sortString, ',' );
        }
        return $default;
    }

    /**
     * Takes a bunch of params that are needed to match certain criteria and
     * retrieves the relevant objects. Typically the valid params are only
     * contact_id. We'll tweak this function to be more full featured over a period
     * of time. This is the inverse function of create. It also stores all the retrieved
     * values in the default array
     *
     * @param string $daoName  name of the dao object
     * @param array  $params   (reference ) an assoc array of name/value pairs
     * @param array  $defaults (reference ) an assoc array to hold the flattened values
     *
     * @return object an object of type referenced by daoName
     * @access public
     * @static
     */
     function commonRetrieve($daoName, &$params, &$defaults)
    {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $daoName) . ".php");
        eval( '$object =& new ' . $daoName . '( );' );
        $object->copyValues($params);
        if ( $object->find( true ) ) {
            CRM_Core_DAO::storeValues( $object, $defaults);
            return $object;
        }
        return null;
    }

    /**
     * Delete the object records that are associated with this contact
     *
     * @param string $daoName  name of the dao object
     * @param  int  $contactId id of the contact to delete
     *
     * @return void
     * @access public
     * @static
     */
     function deleteEntityContact( $daoName, $contactId ) {
        require_once(str_replace('_', DIRECTORY_SEPARATOR, $daoName) . ".php");
        eval( '$object =& new ' . $daoName . '( );' );

        $object->entity_table = 'civicrm_contact';
        $object->entity_id   = $contactId;
        $object->delete( );
    }
 
    /**
     * execute a query
     *
     * @param string $query query to be executed
     *
     * @return Object CRM_Core_DAO object that holds the results of the query
     * @static
     * @access public
     */
     function &executeQuery( $query ) {
        $dao =& new CRM_Core_DAO( );
        $dao->query( $query );
        return $dao;
    }

    /**
     * execute a query and get the singleton result
     *
     * @param string $query query to be executed 
     * 
     * @return string the result of the query
     * @static 
     * @access public 
     */ 
     function singleValueQuery( $query ) {
        $dao =& new CRM_Core_DAO( ); 
        $dao->query( $query ); 
        
        $result = $dao->getDatabaseResult();
        if ( $result ) {
            $row = $result->fetchRow();
            if ( $row ) {
                return $row[0];
            }
        }
        return null;
    }

}

?>

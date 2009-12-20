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


define( 'CRM_CORE_SESSION_USER_CONTEXT','userContext');
$GLOBALS['_CRM_CORE_SESSION']['_singleton'] =  null;

require_once "PEAR.php"; 

require_once "CRM/Core/Error.php";

class CRM_Core_Session {

    /**
     * key is used to allow the application to have multiple top
     * level scopes rather than a single scope. (avoids naming
     * conflicts). We also extend this idea further and have local
     * scopes within a global scope. Allows us to do cool things
     * like resetting a specific area of the session code while 
     * keeping the rest intact
     *
     * @var string
     */
    var $_key = 'CiviCRM';

       


    /**
     * This is just a reference to the real session. Allows us to
     * debug this class a wee bit easier
     *
     * @var object
     */
    var $_session;

    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     *
     * @var object
     * @static
     */
    

    /**
     * Constructor
     *
     * Since we are now a client / module of drupal, drupal takes care
     * of initiating the php session handler session_start ().
     * All crm code should always use the session using
     * CRM_Core_Session. we prefix stuff to avoid collisions with drupal and also
     * collisions with other crm modules!!
     * This constructor is invoked whenever any module requests an instance of
     * the session and one is not available.
     *
     * @param  string   Index for session variables
     * @return void
     */
    function CRM_Core_Session( $key = 'CiviCRM' ) { 
        $this->_key     = $key;
        $this->_session =& $_SESSION;

        $this->create();
    }

    /**
     * singleton function used to manage this object
     *
     * @param string the key to permit session scope's
     *
     * @return object
     * @static
     *
     */
     function &singleton($key = 'CiviCRM') {
        if ($GLOBALS['_CRM_CORE_SESSION']['_singleton'] === null ) {
            $GLOBALS['_CRM_CORE_SESSION']['_singleton'] =& new CRM_Core_Session($key);
        }
        return $GLOBALS['_CRM_CORE_SESSION']['_singleton'];
    }

    /**
     * Creates an array in the session. All variables now will be stored
     * under this array
     *
     * @access private
     * @return void
     */
    function create() {
        if ( ! isset( $this->_session[$this->_key] ) ||
             ! is_array( $this->_session[$this->_key] ) ) {
            $this->_session[$this->_key] = array();
        }
        return;
    }
  
    /**
     * Resets the session store
     *
     * @access public
     * @return void
     */
    function reset( $all = 1) {
        if ( $all != 1 ) {
            // to make certain we clear it, firs initialize it to empty
            $this->_session[$this->_key] = array();
            unset( $this->_session[$this->_key] );
        } else {
            $this->_session = array( );
        }

        return;
    }

    /**
     * creates a session local scope
     *
     * @param string local scope name
     * @access public
     * @return void
     */
    function createScope( $prefix ) {
        if ( empty( $prefix ) ) {
            return;
        }

        if ( ! CRM_Utils_Array::value( $prefix, $this->_session[$this->_key] ) ) {
            $this->_session[$this->_key][$prefix] = array( );
        }
    }

    /**
     * resets the session local scope
     *
     * @param string local scope name
     * @access public
     * @return void
     */
    function resetScope( $prefix ) {
        if (empty( $prefix ) ) {
            return;
        }

        if ( array_key_exists( $prefix, $this->_session[$this->_key] ) ) {
            unset( $this->_session[$this->_key][$prefix] );
        }
    }

    /**
     * Store the variable with the value in the session scope
     *
     * This function takes a name, value pair and stores this
     * in the session scope. Not sure what happens if we try
     * to store complex objects in the session. I suspect it
     * is supported but we need to verify this
     *
     * @access public
     *
     * @param  string $name    name  of the variable
     * @param  mixed  $value   value of the variable
     * @param  string $prefix  a string to prefix the keys in the session with
     *
     * @return void
     *
     */
    function set( $name, $value = null, $prefix = null ) {
        // create session scope
        $this->create();
        $this->createScope( $prefix );

        if ( empty( $prefix ) ) {
            $session =& $this->_session[$this->_key];
        } else {
            $session =& $this->_session[$this->_key][$prefix];
        }

        if ( is_array( $name ) ) {
            foreach ( $name as $n => $v ) {
                $session[$n] = $v;
            }
        } else {
            $session[$name] = $value;
        }
    }

    /**
     * Gets the value of the named variable in the session scope
     *
     * This function takes a name and retrieves the value of this 
     * variable from the session scope.
     *
     * @access public
     * @param  string name  : name  of the variable
     * @param  string prefix : adds another level of scope to the session
     * @return mixed
     *
     */
    function get( $name, $prefix = null ) {
        // create session scope
        $this->create();
        $this->createScope( $prefix );

        if ( empty( $prefix ) ) {
            $session =& $this->_session[$this->_key];
        } else {
            $session =& $this->_session[$this->_key][$prefix];
        }

        return CRM_Utils_Array::value( $name, $session );
    }

  

    /**
     * Gets all the variables in the current session scope
     * and stuffs them in an associate array
     *
     * @access public
     * @param  array  vars : associative array to store name/value pairs
     * @param  string  Strip prefix from the key before putting it in the return
     * @return void
     *
     */
    function getVars( &$vars, $prefix = '' ) {
        // create session scope
        $this->create();
        $this->createScope( $prefix );

        if ( empty( $prefix ) ) {
            $session =& $this->_session[$this->_key];
        } else {
            $session =& $this->_session[$this->_key][$prefix];
        }

        foreach ($session as $name => $value) {
            $vars[$name] = $value;
        }
    }

    /**
     * adds a userContext to the stack
     *
     * @param string  $userContext the url to return to when done
     * @param boolean $check       should we do a dupe checking with the top element
     * @return void
     *
     * @access public
     * 
     */
    function pushUserContext( $userContext, $check = true ) {
        if ( empty( $userContext ) ) {
            return;
        }
        
        $this->createScope( CRM_CORE_SESSION_USER_CONTEXT);

        // hack, reset if too big
        if ( count( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT] ) > 10 ) {
            $this->resetScope ( CRM_CORE_SESSION_USER_CONTEXT);
            $this->createScope( CRM_CORE_SESSION_USER_CONTEXT);
        }

        $topUC = array_pop( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT] );

        // see if there is a match between the new UC and the top one. the match needs to be
        // fuzzy since we use the referer at times
        if ( $check && $topUC && CRM_Utils_String::match( $topUC, $userContext ) ) {
            array_push( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT], $topUC );
        } else {
            if ( $topUC ) {
                array_push( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT], $topUC       );
            }
            array_push( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT], $userContext );
        }
        // CRM_Core_Error::debug( 'UC', $this->_session[$this->_key][self::USER_CONTEXT] );
    }

    /**
     * replace the userContext of the stack with the passed one
     *
     * @param string the url to return to when done
     *
     * @return void
     *
     * @access public
     * 
     */
    function replaceUserContext( $userContext ) {
        if ( empty( $userContext ) ) {
            return;
        }

        $this->createScope( CRM_CORE_SESSION_USER_CONTEXT);

        array_pop ( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT] );
        array_push( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT], $userContext );
    }

    /**
     * pops the top userContext stack
     *
     * @param void
     *
     * @return the top of the userContext stack (also pops the top element)
     *
     */
    function popUserContext( ) {
        $this->createScope( CRM_CORE_SESSION_USER_CONTEXT);

        return array_pop ( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT] );
    }

    /**
     * reads the top userContext stack
     *
     * @param void
     *
     * @return the top of the userContext stack
     *
     */
    function readUserContext( ) {
        $this->createScope( CRM_CORE_SESSION_USER_CONTEXT);

        $config =& CRM_Core_Config::singleton( );
        $lastElement = count( $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT] ) - 1;
        return $lastElement >= 0 ? 
            $this->_session[$this->_key][CRM_CORE_SESSION_USER_CONTEXT][$lastElement] :
            $config->userFrameworkBaseURL;
    }

    /**
     * dumps the session to the log
     */
    function debug( $all = 1 ) {
        if ( $all != 1) {
            CRM_Core_Error::debug( 'CRM Session', $this->_session );
        } else {
            CRM_Core_Error::debug( 'CRM Session', $this->_session[$this->_key] );
        }
    }

    /**
     * stores a status message, resets status if asked to
     *
     * @param $reset boolean should we reset the status variable?
     *
     * @return string        the status message if any
     */
    function getStatus( $reset = false ) {
        $this->create( );

        $status = null;
        if ( array_key_exists( 'status', $this->_session[$this->_key] ) ) {
            $status = $this->_session[$this->_key]['status'];
        }
        if ( $reset ) {
            $this->_session[$this->_key]['status'] = null;
            unset( $this->_session[$this->_key]['status'] );
        }
        return $status;
    }

    /**
     * stores the status message in the session
     *
     * @param $status string the status message
     *
     * @static
     * @return void
     */
     function setStatus( $status ) {
        $GLOBALS['_CRM_CORE_SESSION']['_singleton']->_session[$GLOBALS['_CRM_CORE_SESSION']['_singleton']->_key]['status'] = $status;
    }

}

?>
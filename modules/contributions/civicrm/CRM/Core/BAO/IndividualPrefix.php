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
 *  this file contains functions for individual prefix
 */

$GLOBALS['_CRM_CORE_BAO_INDIVIDUALPREFIX']['_defaultIndividualPrefix'] =  null;

class CRM_Core_BAO_IndividualPrefix extends CRM_Core_DAO_IndividualPrefix {

    /**
     * static holder for the default LT
     */
    


    /**
     * class constructor
     */
    function CRM_Core_BAO_IndividualPrefix( ) {
        parent::CRM_Core_DAO_IndividualPrefix( );
    }

    /**
     * Takes a bunch of params that are needed to match certain criteria and
     * retrieves the relevant objects. Typically the valid params are only
     * contact_id. We'll tweak this function to be more full featured over a period
     * of time. This is the inverse function of create. It also stores all the retrieved
     * values in the default array
     *
     * @param array $params   (reference ) an assoc array of name/value pairs
     * @param array $defaults (reference ) an assoc array to hold the flattened values
     *
     * @return object   CRM_Core_BAO_IndividualPrefix object on success, null otherwise
     * @access public
     * @static
     */
     function retrieve( &$params, &$defaults ) {
        $individualPrefix =& new CRM_Core_DAO_IndividualPrefix( );
        $individualPrefix->copyValues( $params );
        if ( $individualPrefix->find( true ) ) {
            CRM_Core_DAO::storeValues( $individualPrefix, $defaults );
            return $individualPrefix;
        }
        return null;
    }

    /**
     * update the is_active flag in the db
     *
     * @param int      $id        id of the database record
     * @param boolean  $is_active value we want to set the is_active field
     *
     * @return Object             DAO object on sucess, null otherwise
     * 
     * @access public
     * @static
     */
     function setIsActive( $id, $is_active ) {
        return CRM_Core_DAO::setFieldValue( 'CRM_Core_DAO_IndividualPrefix', $id, 'is_active', $is_active );
    }


    /**
     * retrieve the list of prefix
     * 
     * @param NULL
     * 
     * @return object           The default activity type object on success,
     *                          null otherwise
     * @static
     * @access public
     */
     function &getDefault() {
        if ($GLOBALS['_CRM_CORE_BAO_INDIVIDUALPREFIX']['_defaultIndividualPrefix'] == null) {
            $defaults = array();
            $GLOBALS['_CRM_CORE_BAO_INDIVIDUALPREFIX']['_defaultIndividualPrefix'] = CRM_Core_BAO_IndividualPrefix::retrieve($params, $defaults);
        }
        return $GLOBALS['_CRM_CORE_BAO_INDIVIDUALPREFIX']['_defaultIndividualPrefix'];
    }
    
    /**
     * function to add the individual prefix
     *
     * @param array $params reference array contains the values submitted by the form
     * @param array $ids    reference array contains the id
     * 
     * @access public
     * @static 
     * @return object
     */
     function add(&$params, &$ids) {
        
        $params['is_active'] =  CRM_Utils_Array::value( 'is_active', $params, false );
        
        // action is taken depending upon the mode
        $individualPrefix               =& new CRM_Core_DAO_IndividualPrefix( );
        $individualPrefix->domain_id    = CRM_Core_Config::domainID( );
        
        $individualPrefix->copyValues( $params );;
        
        $individualPrefix->id = CRM_Utils_Array::value( 'individualPrefix', $ids );
        $individualPrefix->save( );
        require_once 'CRM/Contact/BAO/Individual.php';
        CRM_Contact_BAO_Individual::updateDisplayNames($ids, CRM_CORE_ACTION_UPDATE);
        return $individualPrefix;
    }
    
    /**
     * Function to delete Individual Prefix
     * 
     * @param  int  $prefixId     ID of the prefix to be deleted.
     * 
     * @return boolean
     * 
     * @access public
     * @static
     */
    
     function del($prefixId) 
    {
        require_once 'CRM/Contact/BAO/Individual.php';
        $ids = array('individualPrefix' => $prefixId);
        CRM_Contact_BAO_Individual::updateDisplayNames($ids, CRM_CORE_ACTION_DELETE);
        $prefix = & new CRM_Core_DAO_IndividualPrefix();
        $prefix->id = $prefixId;
        $prefix->delete();
        return true;
    }
}

?>
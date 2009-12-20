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
 *  this file contains functions for gender
 */

$GLOBALS['_CRM_CORE_BAO_GENDER']['_defaultGender'] =  null;

class CRM_Core_BAO_Gender extends CRM_Core_DAO_Gender {

    /**
     * static holder for the default LT
     */
    


    /**
     * class constructor
     */
    function CRM_Core_BAO_Gender( ) {
        parent::CRM_Core_DAO_Gender( );
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
     * @return object         CRM_Core_DAO_Gender object on success,
     *                        null otherwise.
     * @access public
     * @static
     */
     function retrieve( &$params, &$defaults ) {
        $gender =& new CRM_Core_DAO_Gender( );
        $gender->copyValues( $params );
        if ( $gender->find( true ) ) {
            CRM_Core_DAO::storeValues( $gender, $defaults );
            return $gender;
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
     * @static
     * @access public
     */
     function setIsActive( $id, $is_active ) {
        return CRM_Core_DAO::setFieldValue( 'CRM_Core_DAO_Gender', $id, 'is_active', $is_active );
    }


    /**
     * retrieve the list of gender.
     * 
     * @param NULL 
     * 
     * @return object           The default activity type object on success,
     *                          null otherwise
     * @access public
     * @static
     */
     function &getDefault() {
        if ($GLOBALS['_CRM_CORE_BAO_GENDER']['_defaultGender'] == null) {
            $defaults = array();
            $GLOBALS['_CRM_CORE_BAO_GENDER']['_defaultGender'] = CRM_Core_BAO_Gender::retrieve($params, $defaults);
        }
        return $GLOBALS['_CRM_CORE_BAO_GENDER']['_defaultGender'];
    }

    /**
     * function to add the gender
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
        $gender               =& new CRM_Core_DAO_Gender( );
        $gender->domain_id    = CRM_Core_Config::domainID( );
        
        $gender->copyValues( $params );;
        
        $gender->id = CRM_Utils_Array::value( 'gender', $ids );
        $gender->save( );
        return $gender;
    }

    /**
     * Function to delete Gender 
     * 
     * @param int $genderId  ID of the gender to be deleted.
     * 
     * @return boolean true if success, false otherwise
     * 
     * @access public
     * @static
     */
     function del($genderId) 
    {
        //check dependencies
        require_once 'CRM/Contact/DAO/Individual.php';
        require_once 'CRM/Contact/BAO/Contact.php';
        $deleteContactId = array();
        $session =& CRM_Core_Session::singleton( );
        $currentUserId = $session->get( 'userID' );
        $individual = & new CRM_Contact_DAO_Individual();
        $individual->gender_id = $genderId;
        $individual->find();
        while($individual->fetch()) {
            $contactId = $individual->contact_id;
            if ($currentUserId !=$contactId) {
                $deleteContactId[] = $contactId;
            }else {
                return false;
            }
        }
        foreach($deleteContactId as $cid) {
            CRM_Contact_BAO_Contact::deleteContact( $cid );
        }

        $gender = & new CRM_Core_DAO_Gender();
        $gender->id = $genderId;
        $gender->delete();
        return true;
    }
}

?>
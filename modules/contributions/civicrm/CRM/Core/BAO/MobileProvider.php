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


require_once 'CRM/Core/DAO/MobileProvider.php';

class CRM_Core_BAO_MobileProvider extends CRM_Core_DAO_MobileProvider {

    /**
     * class constructor
     */
    function CRM_Core_BAO_MobileProvider( ) {
        parent::CRM_Core_DAO_MobileProvider( );
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
     * @return object    CRM_Core_DAO_MobileProvider object on success, null otherwise.
     * @access public
     * @static
     */
     function retrieve( &$params, &$defaults ) {
        $mobileProvider =& new CRM_Core_DAO_MobileProvider( );
        $mobileProvider->copyValues( $params );
        if ( $mobileProvider->find( true ) ) {
            CRM_Core_DAO::storeValues( $mobileProvider, $defaults );
            return $mobileProvider;
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
     */
     function setIsActive( $id, $is_active ) {
        return CRM_Core_DAO::setFieldValue( 'CRM_Core_DAO_MobileProvider', $id, 'is_active', $is_active );
    }

     /**
     * Function to delete Mobile Provider  Types 
     * 
     * @param int   $mobileProviderId  ID of the Mobile Provider Type which is to be deleted.
     * 
     * @return void
     * 
     * @access public
     * @static
     */
    
     function del($mobileProviderId) 
    {
        require_once 'CRM/Core/DAO/Phone.php';
        //check dependencies
        $phone = & new CRM_Core_DAO_Phone();
        $phone->mobile_provider_id = $mobileProviderId;
        $phone->delete();
        
        $phone = & new CRM_Core_DAO_MobileProvider();
        $phone->id = $mobileProviderId;
        $phone->delete();
    }
}
?>
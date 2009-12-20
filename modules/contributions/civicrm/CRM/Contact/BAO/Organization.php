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
 * This class contains basic functions for Contact Organization
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


require_once 'CRM/Contact/DAO/Contact.php';
require_once 'CRM/Contact/DAO/Organization.php';

class CRM_Contact_BAO_Organization extends CRM_Contact_DAO_Organization
{
    /**
     * This is a contructor of the class.
     */
    function CRM_Contact_BAO_Organization() 
    {
        parent::CRM_Contact_DAO_Organization();
    }
    
    /**
     * takes an associative array and creates a contact object
     *
     * the function extract all the params it needs to initialize the create a
     * contact object. the params array could contain additional unused name/value
     * pairs
     *
     * @param array  $params (reference ) an assoc array of name/value pairs
     * @param array $ids    the array that holds all the db ids
     *
     * @return object CRM_Contact_BAO_Organization object
     * @access public
     * @static
     */
     function add( &$params, &$ids ) {
        $organization =& new CRM_Contact_BAO_Organization( );

        $organization->copyValues( $params );

        $organization->id = CRM_Utils_Array::value( 'organization', $ids );
        return $organization->save( );
    }

    /**
     * Given the list of params in the params array, fetch the object
     * and store the values in the values array
     *
     * @param array $params input parameters to find object
     * @param array $values output values of the object
     * @param array $ids    the array that holds all the db ids
     *
     * @return CRM_Contact_BAO_Organization|null the found object or null
     * @access public
     * @static
     */
     function getValues( &$params, &$values, &$ids ) {
        $organization =& new CRM_Contact_BAO_Organization( );
        
        $organization->copyValues( $params );
        if ( $organization->find(true) ) {
            $ids['organization'] = $organization->id;
            CRM_Core_DAO::storeValues( $organization, $values );

            return $organization;
        }
        return null;
    }
        
}

?>
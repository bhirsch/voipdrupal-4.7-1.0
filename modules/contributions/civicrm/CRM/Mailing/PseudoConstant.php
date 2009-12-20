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
 * This class holds all the Pseudo constants that are specific to Mass mailing. This avoids
 * polluting the core class and isolates the mass mailer class
 */
$GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['template'] = null;
$GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['completed'] = null;
$GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'] = null;

class CRM_Mailing_PseudoConstant extends CRM_Core_PseudoConstant {

    /**
     * mailing templates
     * @var array
     * @static
     */
    

    /**
     * completed mailings
     * @var array
     * @static
     */
    

    /**
     * mailing components
     * @var array
     * @static
     */
    

    /**
     * Get all the mailing components of a particular type
     *
     * @param $type the type of component needed
     * @access public
     * @return array - array reference of all mailing components
     * @static
     */
      function &component( $type = null ) {
        $name = $type ? $type : 'ALL';

        if ( ! $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'] || ! array_key_exists( $name, $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'] ) ) {
            if ( ! $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'] ) {
                $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'] = array( );
            }
            if ( ! $type ) {
                $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'][$name] = null;
                CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'][$name], 'CRM_Mailing_DAO_Component' );
            } else {
                // we need to add an additional filter for $type
                $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'][$name] = array( );

                require_once 'CRM/Mailing/DAO/Component.php';

                $object =& new CRM_Mailing_DAO_Component( );
                $object->domain_id = CRM_Core_Config::domainID( );
                $object->component_type = $type;
                $object->selectAdd( );
                $object->selectAdd( "id, name" );
                $object->orderBy( 'is_default, name' );
                $object->is_active = 1;
                $object->find( );
                while ( $object->fetch( ) ) {
                    $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'][$name][$object->id] = $object->name;
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['component'][$name];
    }

    /**
     * Get all the mailing templates
     *
     * @access public
     * @return array - array reference of all mailing templates if any
     * @static
     */
      function &template( ) {
        if ( ! $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['template'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['template'], 'CRM_Mailing_DAO_Mailing', true, 'name', 'is_template' );
        }
        return $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['template'];
    }

    /**
     * Get all the completed mailing
     *
     * @access public
     * @return array - array reference of all mailing templates if any
     * @static
     */
      function &completed( ) {
        if ( ! $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['completed'] ) {
            CRM_Mailing_PseudoConstant::populate( $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['completed'], 'CRM_Mailing_DAO_Mailing', true, 'name', 'is_completed' );
        }
        return $GLOBALS['_CRM_MAILING_PSEUDOCONSTANT']['completed'];
    }


}

?>

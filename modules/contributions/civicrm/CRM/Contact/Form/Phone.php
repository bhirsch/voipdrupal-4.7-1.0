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
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

/**
 * form helper class for a phone object 
 */

class CRM_Contact_Form_Phone 
{
    /**
     * build the form elements for a phone object
     *
     * @param CRM_Core_Form $form       reference to the form object
     * @param array         $location   the location object to store all the form elements in
     * @param int           $locationId the locationId we are dealing with
     * @param int           $count      the number of blocks to create
     *
     * @return void
     * @access public
     * @static
     */
     function buildPhoneBlock(&$form, &$location, $locationId, $count) {

        for ($i = 1; $i <= $count; $i++) {
            $label = ($i == 1) ? ts('Phone (preferred)') : ts('Phone');

            CRM_Core_ShowHideBlocks::linksForArray( $form, $i, $count, "location[$locationId][phone]", ts('another phone'), ts('hide this phone'));

            $location[$locationId]['phone'][$i]['phone_type'] = $form->addElement('select',
                                                                                  "location[$locationId][phone][$i][phone_type]",
                                                                                  null,
                                                                                  CRM_Core_SelectValues::phoneType());

            $location[$locationId]['phone'][$i]['phone']      = $form->addElement('text',
                                                                                  "location[$locationId][phone][$i][phone]", 
                                                                                  $label,
                                                                                  CRM_Core_DAO::getAttribute('CRM_Core_DAO_Phone',
                                                                                                        'phone'));

            // TODO: set this up as a group, we need a valid phone_type_id if we have a  phone number
//             $form->addRule( "location[$locationId][phone][$i][phone]", ts('Phone number is not valid.'), 'phone' );
        }
    }

}


?>

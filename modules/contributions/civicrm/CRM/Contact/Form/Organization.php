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


require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/SelectValues.php';
require_once 'CRM/Core/ShowHideBlocks.php';

/**
 * Auxilary class to provide support to the Contact Form class. Does this by implementing
 * a small set of static methods
 *
 */
class CRM_Contact_Form_Organization extends CRM_Core_Form 
{
    /**
     * This function provides the HTML form elements that are specific to this Contact Type
     *
     * @access public
     * @return None
     */
     function buildQuickForm( &$form ) {
        $attributes = CRM_Core_DAO::getAttribute('CRM_Contact_DAO_Organization');

        $form->applyFilter('__ALL__','trim');
        
        // Organization_name
        $form->add('text', 'organization_name', ts('Organization Name'), $attributes['organization_name']);
        
        // legal_name
        $form->addElement('text', 'legal_name', ts('Legal Name'), $attributes['legal_name']);

        // nick_name
        $form->addElement('text', 'nick_name', ts('Nick Name'),
                          CRM_Core_DAO::getAttribute('CRM_Contact_DAO_Contact', 'nick_name') );

        // sic_code
        $form->addElement('text', 'sic_code', ts('SIC Code'), $attributes['sic_code']);

        // home_URL
        $form->addElement('text', 'home_URL', ts('Website'), CRM_Core_DAO::getAttribute('CRM_Contact_DAO_Contact', 'home_URL') );
        $form->addRule('home_URL', ts('Enter a valid Website.'), 'url');

    }

     function formRule( &$fields ) {
        $errors = array( );
        
        $primaryEmail = CRM_Contact_Form_Edit::formRule( $fields, $errors );
        
        // make sure that organization name is set
        if (! CRM_Utils_Array::value( 'organization_name', $fields ) ) {
            $errors['organization_name'] = 'Organization Name should be set.';
        }

        // add code to make sure that the uniqueness criteria is satisfied
        return empty( $errors ) ? true : $errors;
    }
}


    
?>

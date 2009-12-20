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
 * @copyright Donald A. Lobo 01/15/2005
 * $Id$
 *
 */


require_once 'CRM/Core/Form.php';
require_once 'CRM/Profile/Form.php';

/**
 * This class generates form components generic to all the contact types.
 * 
 * It delegates the work to lower level subclasses and integrates the changes
 * back in. It also uses a lot of functionality with the CRM API's, so any change
 * made here could potentially affect the API etc. Be careful, be aware, use unit tests.
 *
 */
class CRM_Profile_Form_Search extends CRM_Profile_Form
{
    /** 
     * pre processing work done here. 
     * 
     * @param  
     * @return void 
     * 
     * @access public 
     * 
     */ 
    function preProcess() 
    { 
        $this->_mode = CRM_PROFILE_FORM_MODE_SEARCH; 
         
        parent::preProcess( ); 
    } 

    /** 
     * Set the default form values 
     * 
     * @access protected 
     * @return array the default array reference 
     */ 
    function &setDefaultValues() {
        $defaults = array(); 

        // note we intentionally overwrite value since we use it as defaults
        // and its all pass by value
        foreach ( $_GET as $key => $value ) {
            if ( substr( $key, 0, 7 ) == 'custom_' ) {
                $v = explode( CRM_CORE_BAO_CUSTOMOPTION_VALUE_SEPERATOR, $value );
                $value = array( );
                foreach ( $v as $item ) {
                    $value[$item] = 1;
                }
            } else if ( $key == 'group' || $key == 'tag' ) {
                $v = explode( ',', $value );
                $value = array( ); 
                foreach ( $v as $item ) { 
                    $value[$item] = 1; 
                } 
            }
            $defaults[$key] = $value;
        }

        return $defaults;
    }

    /**
     * Function to actually build the form
     *
     * @return void
     * @access public
     */
     function buildQuickForm( ) 
    {
        $this->addButtons(array( 
                                array ('type'      => 'refresh', 
                                       'name'      => ts('Search'), 
                                       'isDefault' => true ), 
                                ) ); 

        parent::buildQuickForm( );
     }

       
    /**
     *
     *
     * @access public
     * @return void
     */
     function postProcess() 
    {
    }
}

?>

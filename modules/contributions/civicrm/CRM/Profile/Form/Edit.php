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
 * @copyright Donald A. Lobo 01/15/2005
 * $Id$
 *
 */


require_once 'CRM/Core/Form.php';
require_once 'CRM/Profile/Form.php';
/**
 * This class generates form components for custom data
 * 
 * It delegates the work to lower level subclasses and integrates the changes
 * back in. It also uses a lot of functionality with the CRM API's, so any change
 * made here could potentially affect the API etc. Be careful, be aware, use unit tests.
 *
  */
class CRM_Profile_Form_Edit extends CRM_Profile_Form
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
        $this->_mode = CRM_PROFILE_FORM_MODE_CREATE;
        parent::preProcess( );
    }

    /**
     * Set the default form values
     *
     * @access protected
     * @return array the default array reference
     */
    function &setDefaultValues()
    {
        return parent::setContactValues( );
    }

    /**
     * Function to actually build the form
     *
     * @return void
     * @access public
     */
     function buildQuickForm()
    {
        require_once 'CRM/UF/Form/Group.php';


        $this->addButtons(array(
                                array ('type'      => 'next',
                                       'name'      => ts('Save'),
                                       'isDefault' => true),
                                array ('type'      => 'cancel',
                                       'name'      => ts('Cancel'),
                                       'isDefault' => true)
                                )
                          );

        // add the hidden field to redirect the postProcess from

        require_once 'CRM/Core/DAO/UFGroup.php';
        $ufGroup =& new CRM_Core_DAO_UFGroup( );
        
        $ufGroup->id = $this->_gid;
        $ufGroup->find(true);
        
        $postURL   = CRM_Utils_Array::value( 'postURL', $_POST );
        

        if ( ! $postURL ) {
            $postURL = $ufGroup->post_URL;
        } 
        if ( ! $postURL ) {
            $postURL = CRM_Utils_System::url('civicrm/profile/edit', '&amp;gid='.$this->_gid.'&amp;reset=1' );
        }

               
        // we do this gross hack since qf also does entity replacement
        $postURL = str_replace( '&amp;', '&', $postURL   );
       
       
        $this->addElement( 'hidden', 'postURL', $postURL );
       
        // also retain error URL if set
        $errorURL = CRM_Utils_Array::value( 'errorURL', $_POST );
        if ( $errorURL ) {
            // we do this gross hack since qf also does entity replacement 
            $errorURL = str_replace( '&amp;', '&', $errorURL ); 
            $this->addElement( 'hidden', 'errorURL', $errorURL ); 
        }

        // replace the sesssion stack in case user cancels (and we dont go into postProcess)
        $session =& CRM_Core_Session::singleton(); 
        $session->replaceUserContext( $postURL ); 

        parent::buildQuickForm( );

        $this->addFormRule( array( 'CRM_Profile_Form', 'formRule' ), $this->_id );
    }

    /**
     * Process the user submitted custom data values.
     *
     * @access public
     * @return void
     */
     function postProcess( ) 
    {
        parent::postProcess( );

        CRM_Core_Session::setStatus(ts('Thank you. Your contact information has been saved.'));
    }

    /**
     * Function to intercept QF validation and do our own redirection
     *
     * We use this to send control back to the user for a user formatted page
     * This allows the user to maintain the same state and display the error messages
     * in their own theme along with any modifications
     *
     * This is a first version and will be tweaked over a period of time
     *
     * @access    public                                                              
     * @return    boolean   true if no error found 
     */
    function validate( ) {
        $errors = parent::validate( );

        if ( ! $errors &&
             CRM_Utils_Array::value( 'errorURL', $_POST ) ) {
            $message = null;
            foreach ( $this->_errors as $name => $mess ) {
                $message .= $mess;
                $message .= '<p>';
            }
            
            if ( function_exists( 'drupal_set_message' ) ) {
                drupal_set_message( $message );
            }
            
            $message = urlencode( $message );

            $errorURL = $_POST['errorURL'];
            if ( strpos( $errorURL, '?' ) !== false ) {
                $errorURL .= '&';
            } else {
                $errorURL .= '?';
            }
            $errorURL .= "gid=" . $this->_gid;
            $errorURL .= "&msg=$message";
            CRM_Utils_System::redirect( $errorURL );
        }

        return $errors;
    }

}

?>

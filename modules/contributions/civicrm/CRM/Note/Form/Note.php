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

/**
 * This class generates form components generic to note
 * 
 * It delegates the work to lower level subclasses and integrates the changes
 * back in. It also uses a lot of functionality with the CRM API's, so any change
 * made here could potentially affect the API etc. Be careful, be aware, use unit tests.
 *
 */
class CRM_Note_Form_Note extends CRM_Core_Form
{
    /**
     * The table name, used when editing/creating a note
     *
     * @var string
     */
    var $_entityTable;

    /**
     * The table id, used when editing/creating a note
     *
     * @var int
     */
    var $_entityId;
    
    /**
     * The note id, used when editing the note
     *
     * @var int
     */
    var $_id;

    function preProcess( ) {
        $this->_entityTable = $this->get( 'entityTable' );
        $this->_entityId    = $this->get( 'entityId'   );
        $this->_id          = $this->get( 'id'    );
    }

    /**
     * This function sets the default values for the form. Note that in edit/view mode
     * the default values are retrieved from the database
     * 
     * @access public
     * @return None
     */
    function setDefaultValues( ) {
        $defaults = array( );

        if ( $this->_action & CRM_CORE_ACTION_UPDATE ) {
            if ( isset( $this->_id ) ) {
                $defaults['note'] = CRM_Core_BAO_Note::getNoteText( $this->_id );
            }
        }

        return $defaults;
    }

    /**
     * Function to actually build the form
     *
     * @return None
     * @access public
     */
     function buildQuickForm( ) {
       
        
        
        if ($this->_action & CRM_CORE_ACTION_DELETE ) { 
            $this->addButtons( array(
                                     array ( 'type'      => 'next',
                                             'name'      => ts('Delete'),
                                             'isDefault' => true   ),
                                     array ( 'type'       => 'cancel',
                                             'name'      => ts('Cancel') ),
                                     )
                               );
            return;
        }

        $this->add('textarea', 'note', ts('Notes'), CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_Note', 'note' ) );
        $this->addRule( 'note', ts('Please enter note text.'), 'required' );
        
        $this->addButtons( array(
                                 array ( 'type'      => 'next',
                                         'name'      => ts('Save'),
                                         'isDefault' => true   ),
                                 array ( 'type'       => 'cancel',
                                         'name'      => ts('Cancel') ),
                                 )
                           );
        
    }

       
    /**
     *
     * @access public
     * @return None
     */
     function postProcess() 
    {
       
        $session =& CRM_Core_Session::singleton( );

        // store the submitted values in an array
        $params = $this->exportValues();

        // action is taken depending upon the mode
        $note                =& new CRM_Core_DAO_Note( );
        $note->note          = $params['note'];
        $note->contact_id    = $session->get( 'userID' );
        if ( ! $note->contact_id ) {
            CRM_Utils_System::statusBounce(ts('We could not find your logged in user ID'));
        }
        
        $note->modified_date = date("Ymd");
        
        if ( $this->_action & CRM_CORE_ACTION_DELETE ) {
            CRM_Core_BAO_Note::del( $this->_id );
        
            //CRM_Core_Session::setStatus( ts('Selected Note has been Deleted Successfuly.') );
            return;
        }if ( $this->_action & CRM_CORE_ACTION_UPDATE ) {
            
            $note->id = $this->_id;
        } else {
            $note->entity_table = $this->_entityTable;
            $note->entity_id    = $this->_entityId;
        }
        $note->save( );

        CRM_Core_Session::setStatus( ts('Your Note has been saved.') );
    }//end of function


}

?>

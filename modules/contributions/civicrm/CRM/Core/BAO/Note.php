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

define( 'CRM_CORE_BAO_NOTE_MAX_NOTES',3);

require_once 'CRM/Core/DAO/Note.php';

/**
 * BAO object for crm_note table
 */
class CRM_Core_BAO_Note extends CRM_Core_DAO_Note {

    /**
     * const the max number of notes we display at any given time
     * @var int
     */
       
    
    /**
     * given a note id, retrieve the note text
     * 
     * @param int  $id   id of the note to retrieve
     * 
     * @return string   the note text or null if note not found
     * 
     * @access public
     * @static
     */
     function getNoteText( $id ) {
        return CRM_Core_DAO::getFieldValue( 'CRM_Core_DAO_Note', $id, 'note' );
    }
    
    /**
     * takes an associative array and creates a note object
     *
     * the function extract all the params it needs to initialize the create a
     * note object. the params array could contain additional unused name/value
     * pairs
     *
     * @param array  $params         (reference ) an assoc array of name/value pairs
     *
     * @return object CRM_Core_BAO_Note object
     * @access public
     * @static
     */
     function &add( &$params ) 
    {
        $dataExists = CRM_Core_BAO_Note::dataExists( $params );
        if ( ! $dataExists ) {
            return null;
        }

        $note =& new CRM_Core_BAO_Note( );
        
        $params['modified_date']  = date("Ymd");
        $params['entity_id']      = $params['entity_id'];
        $params['entity_table']   = $params['entity_table'];

        $note->copyValues( $params );

        $session =& CRM_Core_Session::singleton( );
        $note->contact_id = $session->get( 'userID' );
        if ( ! $note->contact_id ) {
            if ( $params['entity_table'] == 'civicrm_contact' ) {
                $note->contact_id = $params['entity_id'];
            } else {
                CRM_Utils_System::statusBounce(ts('We could not find your logged in user ID'));
            }
        }
        $note->save( );

        return $note;
    }

    /**
     * Check if there is data to create the object
     *
     * @param array  $params         (reference ) an assoc array of name/value pairs
     *
     * @return boolean
     * @access public
     * @static
     */
     function dataExists( &$params ) 
    {
        // return if no data present
        if ( ! strlen( $params['note']) ) {
            return false;
        } 
        return true;
     }

    /**
     * Given the list of params in the params array, fetch the object
     * and store the values in the values array
     *
     * @param array $params        input parameters to find object
     * @param array $values        output values of the object
     * @param array $ids           the array that holds all the db ids
     * @param int   $numNotes      the maximum number of notes to return (0 if all)
     *
     * @return object   Object of CRM_Core_BAO_Note
     * @access public
     * @static
     */
     function &getValues( &$params, &$values, &$ids, $numNotes = CRM_CORE_BAO_NOTE_MAX_NOTES) {
        $note =& new CRM_Core_BAO_Note( );
       
        $note->entity_id    = $params['contact_id'] ;        
        $note->entity_table = 'civicrm_contact';

        // get the total count of notes
        $values['noteTotalCount'] = $note->count( );

        // get only 3 recent notes
        $note->orderBy( 'modified_date desc' );
        $note->limit( $numNotes );
        $note->find();

        $notes       = array( );
        $ids['note'] = array( );
        $count = 0;
        while ( $note->fetch() ) {
            $values['note'][$note->id] = array();
            $ids['note'][] = $note->id;
            
            CRM_Core_DAO::storeValues( $note, $values['note'][$note->id] );

            $notes[] = $note;

            $count++;
            // if we have collected the number of notes, exit loop
            if ( $numNotes > 0 && $count >= $numNotes ) {
                break;
            }
        }
        
        return $notes;
    }


    /**
     * Function to delete the notes
     *
     * @param int $id note id
     *
     * @return null
     * @access public
     * @static
     *
     */
     function del ( $id ) {
        // delete from relationship table
        $note =& new CRM_Core_DAO_Note( );
        $note->id = $id;
        $note->delete();
        CRM_Core_Session::setStatus( ts('Selected Note has been Deleted Successfuly.') );        
    }

    /**
     * delete all records for this contact id
     * 
     * @param int  $id    ID of the contact for which records needs to be deleted.
     * 
     * @return void
     * 
     * @access public
     * @static
     */
      function deleteContact($id)
    {
        // need to delete for both entity_id
        $dao =& new CRM_Core_DAO_Note();
        $dao->entity_table = 'civicrm_contact';
        $dao->entity_id   = $id;
        $dao->delete();

        // and the creator contact id
        $dao =& new CRM_Core_DAO_Note();
        $dao->contact_id = $id;        
        $dao->delete();
    }
}
?>
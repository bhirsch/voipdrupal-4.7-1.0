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
 * This class contains functions for managing Tag(tag) for a contact
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


require_once 'CRM/Core/DAO/EntityTag.php';

class CRM_Core_BAO_EntityTag extends CRM_Core_DAO_EntityTag 
{

    /**
     *
     * Given a contact id, it returns an array of tag id's the 
     * contact belongs to.
     *
     * @param string $entityTable name of the entity table usually 'civicrm_contact'
     * @param int $entityID id of the entity usually the contactID.
     * @return array() reference $tag array of catagory id's the contact belongs to.
     *
     * @access public
     * @static
     */
     function &getTag($entityTable = 'civicrm_contact', $entityID) 
    {
        $tag = array();
        
        $entityTag =& new CRM_Core_BAO_EntityTag();
        $entityTag->entity_table = $entityTable;
        $entityTag->entity_id = $entityID;
        $entityTag->find();
        
        while ($entityTag->fetch()) {
            $tag[$entityTag->tag_id] = $entityTag->tag_id;
        } 
        return $tag;        
    }

    /**
     * takes an associative array and creates a entityTag object
     *
     * the function extract all the params it needs to initialize the create a
     * group object. the params array could contain additional unused name/value
     * pairs
     *
     * @param array  $params         (reference ) an assoc array of name/value pairs
     *
     * @return object CRM_Core_BAO_EntityTag object
     * @access public
     * @static
     */
     function add( &$params ) 
    {
       
        $dataExists = CRM_Core_BAO_EntityTag::dataExists( $params );
        if ( ! $dataExists ) {
            return null;
        }
      
        $entityTag =& new CRM_Core_BAO_EntityTag( );
        $entityTag->copyValues( $params );
        $entityTag->save( );
        return $entityTag;
    }

    /**
     * Check if there is data to create the object
     *
     * @params array  $params         (reference ) an assoc array of name/value pairs
     *
     * @return boolean
     * @access public
     * @static
     */
     function dataExists( &$params ) 
    {
        return ($params['tag_id'] == 0) ? false : true;
    }
    
    /**
     * Function to delete the tag for a contact
     *
     * @param array  $params         (reference ) an assoc array of name/value pairs
     *
     * @return object CRM_Core_BAO_EntityTag object
     * @access public
     * @static
     *
     */
     function del( &$params ) 
    {
        $entityTag =& new CRM_Core_BAO_EntityTag( );
        $entityTag->copyValues( $params );
        $entityTag->delete( );
        //return $entityTag;
    }


    /**
     * Given an array of contact ids, add all the contacts to the tags 
     *
     * @param array  $contactIds (reference ) the array of contact ids to be added
     * @param int    $tagId the id of the tag
     *
     * @return array             (total, added, notAdded) count of contacts added to group
     * @access public
     * @static
     */
     function addContactsToTag( &$contactIds, $tagId ) 
    {
        $numContactsAdded    = 0;
        $numContactsNotAdded = 0;
        foreach ( $contactIds as $contactId ) {
            $tag =& new CRM_Core_DAO_EntityTag( );
            
            $tag->entity_id    = $contactId;
            $tag->entity_table = 'civicrm_contact';
            $tag->tag_id  = $tagId;
            if ( ! $tag->find( ) ) {
                $tag->save( );
                $numContactsAdded++;
            } else {
                $numContactsNotAdded++;
            }
        }
        
        return array( count($contactIds), $numContactsAdded, $numContactsNotAdded );
    }

    /**
     * Given an array of contact ids, remove contact(s) tags 
     *
     * @param array  $contactIds (reference ) the array of contact ids to be added
     * @param int    $tagId the id of the tag
     *
     * @return array             (total, removed, notRemoved) count of contacts removed from tags
     * @access public
     * @static
     */
     function removeContactsFromTag( &$contactIds, $tagId ) 
    {
        $numContactsRemoved    = 0;
        $numContactsNotRemoved = 0;
        foreach ( $contactIds as $contactId ) {
            $tag =& new CRM_Core_DAO_EntityTag( );
            $tag->entity_id    = $contactId;
            $tag->entity_table = 'civicrm_contact';
            $tag->tag_id       = $tagId;
            if (  $tag->find( ) ) {
                $tag->delete( );
                $numContactsRemoved++;
            } else {
                $numContactsNotRemoved++;
            }
        }
        
        return array( count($contactIds), $numContactsRemoved, $numContactsNotRemoved );
    }

    
    /**
     * takes an associative array and creates a contact tags object 
     *
     *
     * @param array $params (reference )  an assoc array of name/value pairs
     * @param array $contactId            contact id
     *
     * @return void
     * @access public
     * @static
     */
     function create( &$params, $contactId ) 
    {
        // get categories for the contact id
        $entityTag =& CRM_Core_BAO_EntityTag::getTag('civicrm_contact', $contactId);
        
        // get the list of all the categories
        $allTag =& CRM_Core_PseudoConstant::tag();
        
        // this fix is done to prevent warning generated by array_key_exits incase of empty array is given as input
        if (!is_array($params)) {
            $params = array( );
        }
        
        // this fix is done to prevent warning generated by array_key_exits incase of empty array is given as input
        if (!is_array($entityTag)) {
            $entityTag = array();
        }

        // check which values has to be inserted/deleted for contact
        foreach ($allTag as $key => $varValue) {
            $tagParams['entity_id'] = $contactId;
            $tagParams['entity_table'] = 'civicrm_contact';
            $tagParams['tag_id'] = $key;
            
            if (array_key_exists($key, $params) && !array_key_exists($key, $entityTag) ) {
                // insert a new record
                CRM_Core_BAO_EntityTag::add($tagParams);
            } else if (!array_key_exists($key, $params) && array_key_exists($key, $entityTag) ) {
                // delete a record for existing contact
                CRM_Core_BAO_EntityTag::del($tagParams);
            }
        }
    }
    
    /**
     * This function returns all entities assigned to a specific tag
     * 
     * @param object  $tag    an object of a tag.
     *
     * @return  array   $contactIds    array of contact ids
     * @access public
     */
    function getEntitiesByTag($tag)
    {
        $contactIds = array();
        $entityTagDAO = & new CRM_Core_DAO_EntityTag();
        $entityTagDAO->tag_id       = $tag->id;
        $entityTagDAO->entity_table = 'civicrm_contact'; 
        $entityTagDAO->find();
        while($entityTagDAO->fetch()) {
            $contactIds[] = $entityTagDAO->entity_id;
        }
        return $contactIds;
    }
}
?>
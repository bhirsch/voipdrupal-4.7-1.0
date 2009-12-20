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


require_once 'CRM/Admin/Form.php';

/**
 * This class generates form components for Location Type
 * 
 */
class CRM_Admin_Form_LocationType extends CRM_Admin_Form
{
    /**
     * Function to build the form
     *
     * @return None
     * @access public
     */
     function buildQuickForm( ) 
    {
       
        parent::buildQuickForm( );
       
        if ($this->_action & CRM_CORE_ACTION_DELETE ) { 
             
            return;
        }
        
        $this->applyFilter('__ALL__', 'trim');
        $this->add('text', 'name', ts('Name'), CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_LocationType', 'name' ) );
        $this->addRule( 'name', ts('Please enter a valid location type name.'), 'required' );
        $this->addRule( 'name', ts('Name already exists in Database.'), 'objectExists', array( 'CRM_Core_DAO_LocationType', $this->_id ) );
        
        $this->add('text', 'vcard_name', ts('vCard Name'), CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_LocationType', 'vcard_name' ) );

        $this->add('text', 'description', ts('Description'), CRM_Core_DAO::getAttribute( 'CRM_Core_DAO_LocationType', 'description' ) );

        $this->add('checkbox', 'is_active', ts('Enabled?'));
        $this->add('checkbox', 'is_default', ts('Default?'));
        if ($this->_action == CRM_CORE_ACTION_UPDATE && CRM_Core_DAO::getFieldValue( 'CRM_Core_DAO_LocationType', $this->_id, 'is_reserved' )) { 
            $this->freeze(array('name', 'description', 'is_active' ));
        }
       
    }

       
    /**
     * Function to process the form
     *
     * @access public
     * @return None
     */
     function postProcess() 
    {
         if($this->_action & CRM_CORE_ACTION_DELETE) {
            CRM_Core_BAO_LocationType::del($this->_id);
            CRM_Core_Session::setStatus( ts('Selected Location type has been deleted.') );
        } else {
            // store the submitted values in an array
            $params = $this->exportValues();
            $params['is_active'] =  CRM_Utils_Array::value( 'is_active', $params, false );
            $params['is_default'] =  CRM_Utils_Array::value( 'is_default', $params, false );
            
            // action is taken depending upon the mode
            $locationType               =& new CRM_Core_DAO_LocationType( );
            $locationType->domain_id    = CRM_Core_Config::domainID( );
            $locationType->name         = $params['name'];
            $locationType->vcard_name   = $params['vcard_name'];
            $locationType->description  = $params['description'];
            $locationType->is_active    = $params['is_active'];
            $locationType->is_default   = $params['is_default'];
            
            if ($params['is_default']) {
                $unsetDefault =& new CRM_Core_DAO();
                $query = 'UPDATE civicrm_location_type SET is_default = 0';
                $unsetDefault->query($query);
            }
            
            if ($this->_action & CRM_CORE_ACTION_UPDATE ) {
                $locationType->id = $this->_id;
            }
            
        $locationType->save( );
        
        CRM_Core_Session::setStatus( ts('The location type "%1" has been saved.',
                                        array( 1 => $locationType->name )) );
        }
    }//end of function

}

?>

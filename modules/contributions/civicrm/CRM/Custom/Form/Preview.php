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
require_once 'CRM/Core/BAO/CustomGroup.php';
require_once 'CRM/Core/DAO/CustomField.php';
require_once 'CRM/Core/BAO/CustomOption.php';
/**
 * This class generates form components for previewing custom data
 * 
 * It delegates the work to lower level subclasses and integrates the changes
 * back in. It also uses a lot of functionality with the CRM API's, so any change
 * made here could potentially affect the API etc. Be careful, be aware, use unit tests.
 *
 */
class CRM_Custom_Form_Preview extends CRM_Core_Form
{
    /**
     * the group tree data
     *
     * @var array
     */
    var $_groupTree;

    /**
     * pre processing work done here.
     * 
     * gets session variables for group or field id
     * 
     * @param null
     * 
     * @return void
     * @access public
     */
    function preProcess()
    {
       
        // get the controller vars
        $groupId  = $this->get('groupId');
        $fieldId  = $this->get('fieldId');
        
        if ($fieldId) {
            // field preview
            $defaults = array();
            $params = array('id' => $fieldId);
            $fieldDAO =& new CRM_Core_DAO_CustomField();                    
            CRM_Core_DAO::commonRetrieve('CRM_Core_DAO_CustomField', $params, $defaults);
            $this->_groupTree = array();
            $this->_groupTree[0]['id'] = 0;
            $this->_groupTree[0]['fields'] = array();
            $this->_groupTree[0]['fields'][$fieldId] = $defaults;
            $this->assign('preview_type', 'field');
        } else {
            // group preview
            $this->_groupTree  = CRM_Core_BAO_CustomGroup::getGroupDetail($groupId);        
            $this->assign('preview_type', 'group');
        }
    }


    /**
     * Set the default form values
     * 
     * @param null
     * 
     * @return array   the default array reference
     * @access protected
     */
    function &setDefaultValues()
    {
        $defaults = array();

        require_once 'CRM/Core/BAO/CustomGroup.php';
        CRM_Core_BAO_CustomGroup::setDefaults( $this->_groupTree, $defaults, false, false );

        return $defaults;
    }

    /**
     * Function to actually build the form
     * 
     * @param null
     * 
     * @return void
     * @access public
     */
     function buildQuickForm()
    {
        //this is fix for calendar for date field
        foreach ($this->_groupTree as $key1 => $group) { 
            foreach ($group['fields'] as $key2 => $field) {
                if ($field['data_type'] == 'Date' && $field['date_parts'] ) {
                    $datePart = explode( CRM_CORE_BAO_CUSTOMOPTION_VALUE_SEPERATOR , $field['date_parts']);
                    if ( count( $datePart ) < 3) {
                        $this->_groupTree[$key1]['fields'][$key2]['skip_calendar'] = true;
                    }
                }
            }
        }
        $this->assign('groupTree', $this->_groupTree);

        // add the form elements
        require_once 'CRM/Core/BAO/CustomField.php';

        foreach ($this->_groupTree as $group) {
            $groupId = $group['id'];
            foreach ($group['fields'] as $field) {
                $fieldId = $field['id'];                
                $elementName = $groupId . '_' . $fieldId . '_' . $field['name']; 
                CRM_Core_BAO_CustomField::addQuickFormElement($this, $elementName, $fieldId, false, $field['is_required']);
            }
        }

        $this->addButtons(array(
                                array ('type'      => 'cancel',
                                       'name'      => ts('Done with Preview'),
                                       'isDefault' => true),
                                )
                          );
    }
}
?>
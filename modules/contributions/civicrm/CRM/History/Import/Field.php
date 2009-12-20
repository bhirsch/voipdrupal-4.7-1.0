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



require_once 'CRM/Utils/Type.php';


class CRM_History_Import_Field {
  
    /**#@+
     * @access protected
     * @var string
     */

    /**
     * name of the field
     */
    var $_name;

    /**
     * title of the field to be used in display
     */
    var $_title;

    /**
     * type of field
     * @var enum
     */
    var $_type;

    /**
     * is this field required
     * @var boolean
     */
    var $_required;

    /**
     * data to be carried for use by a derived class
     * @var object
     */
    var $_payload;

    /**
     * regexp to match the CSV header of this column/field
     * @var string
     */
     var $_headerPattern;

    /**
     * regexp to match the pattern of data from various column/fields
     * @var string
     */
     var $_dataPattern;

    /**
     * value of this field
     * @var object
     */
    var $_value;



    function CRM_History_Import_Field( $name, $title, $type = CRM_UTILS_TYPE_T_INT, $headerPattern = '//', $dataPattern = '//') {
        $this->_name      = $name;
        $this->_title     = $title;
        $this->_type      = $type;
        $this->_headerPattern = $headerPattern;
        $this->_dataPattern = $dataPattern;
    
        $this->_value     = null;
    }

    function resetValue( ) {
        $this->_value     = null;
    }

    /**
     * the value is in string format. convert the value to the type of this field
     * and set the field value with the appropriate type
     */
    function setValue( $value ) {
        $this->_value = $value;
    }

    function validate( ) {

        if ( CRM_Utils_System::isNull( $this->_value ) ) {
            return true;
        }

        /*switch ($this->_name) {
        // check whether that's a valid custom field id
        // and if so, check the contents' validity
        if ($customFieldID = CRM_Core_BAO_CustomField::getKeyID($this->_name)) {
            static $customFields = null;
            if (!$customFields) {
                $customFields =& CRM_Core_BAO_CustomField::getFields('Activity');
            }
            if (!array_key_exists($customFieldID, $customFields)) {
                return false;
            }
            return CRM_Core_BAO_CustomValue::typecheck($customFields[$customFieldID][2], $this->_value);
        }*/
        
        return true;
    }

}

?>

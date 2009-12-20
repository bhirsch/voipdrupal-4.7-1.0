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
 * $Id: Field.php 4807 2006-03-17 13:52:35Z shot $
 *
 */

define( 'CRM_CUSTOM_FORM_FIELD_NUM_OPTION',11);
$GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeValues'] =  null;
$GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys'] =  null;
$GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToHTML'] =  array(
            array(  'Text' => 'Text', 'Select' => 'Select', 
                    'Radio' => 'Radio', 'CheckBox' => 'CheckBox', 'Multi-Select' => 'Multi-Select'),
            array('Text' => 'Text', 'Select' => 'Select', 'Radio' => 'Radio'),
            array('Text' => 'Text', 'Select' => 'Select', 'Radio' => 'Radio'),
            array('Text' => 'Text', 'Select' => 'Select', 'Radio' => 'Radio'),
            array('TextArea' => 'TextArea'),
            array('Date' => 'Select Date'),
            array('Radio' => 'Radio'),
            array('StateProvince' => 'Select State/Province'),
            array('Country' => 'Select Country'),
    );
$GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToLabels'] =  null;

require_once 'CRM/Core/Form.php';
require_once 'CRM/Core/ShowHideBlocks.php';

/**
 * form to process actions on the field aspect of Custom
 */
class CRM_Custom_Form_Field extends CRM_Core_Form {

    /**
     * Constants for number of options for data types of multiple option.
     */
       


    /**
     * the custom group id saved to the session for an update
     *
     * @var int
     * @access protected
     */
    var $_gid;

    /**
     * The field id, used when editing the field
     *
     * @var int
     * @access protected
     */
    var $_id;


    /**
     * Array for valid combinations of data_type & html_type
     *
     * @var array
     * @static
     */
    
    
    
    
    
    
    

    /**
     * Function to set variables up before form is built
     * 
     * @param null
     * 
     * @return void
     * @access public
     */
     function preProcess()
    {
        require_once 'CRM/Core/BAO/CustomField.php';
        if (!($GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys'])) {
            $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys']   = array_keys  (CRM_Core_BAO_CustomField::dataType());
            $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeValues'] = array_values(CRM_Core_BAO_CustomField::dataType());
        }

        $this->_gid = CRM_Utils_Request::retrieve('gid', $this);
        $this->_id  = CRM_Utils_Request::retrieve('id' , $this);
        if ($GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToLabels'] == null) {
            $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToLabels'] = array(
                array('Text' => ts('Text'), 'Select' => ts('Select'), 
                        'Radio' => ts('Radio'), 'CheckBox' => ts('CheckBox'), 'Multi-Select' => ts('Multi-Select')),
                array('Text' => ts('Text'), 'Select' => ts('Select'), 
                        'Radio' => ts('Radio')),
                array('Text' => ts('Text'), 'Select' => ts('Select'), 
                        'Radio' => ts('Radio')),
                array('Text' => ts('Text'), 'Select' => ts('Select'), 
                        'Radio' => ts('Radio')),
                array('TextArea' => ts('TextArea')),
                array('Date' => ts('Select Date')),
                array('Radio' => ts('Radio')),
                array('StateProvince' => ts('Select State/Province')),
                array('Country' => ts('Select Country')),
            );
        }

    }

    /**
     * This function sets the default values for the form. Note that in edit/view mode
     * the default values are retrieved from the database
     * 
     * @param null
     * 
     * @return array    array of default values
     * @access public
     */
    function setDefaultValues()
    {
        $defaults = array();
       
        // is it an edit operation ?
        if (isset($this->_id)) {
            $params = array('id' => $this->_id);
            $this->assign('id',$this->_id);
            CRM_Core_BAO_CustomField::retrieve($params, $defaults);
            $this->_gid = $defaults['custom_group_id'];

            if ( $defaults['data_type'] == 'StateProvince' ) {
                $daoState =& new CRM_Core_DAO_StateProvince();
                $stateId = $defaults['default_value'];
                $daoState->id = $stateId;
                if ( $daoState->find( true ) ) {
                    $defaults['default_value'] = $daoState->name;
                }
            } else if ( $defaults['data_type'] == 'Country' ) {
                $daoCountry =& new CRM_Core_DAO_Country();
                $countryId = $defaults['default_value'];
                $daoCountry->id = $countryId;
                if ( $daoCountry->find( true ) ) {
                    $defaults['default_value'] = $daoCountry->name;
                }
            }
            
            if (CRM_Utils_Array::value('data_type', $defaults)) {
                $defaults['data_type'] = array('0' => array_search($defaults['data_type'], $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys']), '1' => $defaults['html_type']);
            }
            
            $date_parts = explode(CRM_CORE_BAO_CUSTOMOPTION_VALUE_SEPERATOR,$defaults['date_parts']);
            $temp_date_parts = array();
            if (is_array( $date_parts )) {
                foreach($date_parts as $v  ) {
                    $temp_date_parts[$v] = 1;
                }
                $defaults['date_parts'] = $temp_date_parts;
            }
        } else {
            $defaults['is_active'] = 1;
            for($i=1; $i<=CRM_CUSTOM_FORM_FIELD_NUM_OPTION; $i++) {
                $defaults['option_status['.$i.']'] = 1;
                $defaults['option_weight['.$i.']'] = $i;
            }
        }

        if ($this->_action & CRM_CORE_ACTION_ADD) {
            $cf =& new CRM_Core_DAO();
            $sql = "SELECT weight FROM civicrm_custom_field  WHERE custom_group_id = ". $this->_gid ." ORDER BY weight  DESC LIMIT 0, 1"; 
            $cf->query($sql);
            while( $cf->fetch( ) ) {
                $defaults['weight'] = $cf->weight + 1;
            }
            
            if ( empty($defaults['weight']) ) {
                $defaults['weight'] = 1;
            }
            $defaults['date_parts'] = array('d' => 1,'M' => 1,'Y' => 1); 
            $defaults['note_columns'] = 60;
            $defaults['note_rows']    = 4;
        }
        
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
        // lets trim all the whitespace
        $this->applyFilter('__ALL__', 'trim');

        // label
        $this->add('text', 'label', ts('Field Label'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'label'), true);
        $this->addRule( 'label', ts('Name already exists in Database.'), 
                        'objectExists', array( 'CRM_Core_DAO_CustomField', $this->_id, 'label' ) );

        $dt =& $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeValues'];
        $it = array();
        foreach ($dt as $key => $value) {
            $it[$key] = $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToLabels'][$key];
        }
        $sel =& $this->addElement('hierselect', "data_type", ts('Data and Input Field Type'), 'onClick="custom_option_html_type(this.form)"; onBlur="custom_option_html_type(this.form)";', '&nbsp;&nbsp;&nbsp;' );
        $sel->setOptions(array($dt, $it));
        if ($this->_action == CRM_CORE_ACTION_UPDATE) {
            $this->freeze('data_type');
        }
        
        // form fields of Custom Option rows
        $defaultOption = array();
        $_showHide =& new CRM_Core_ShowHideBlocks('','');
        for($i = 1; $i <= CRM_CUSTOM_FORM_FIELD_NUM_OPTION; $i++) {
            
            //the show hide blocks
            $showBlocks = 'optionField['.$i.']';
            if ($i > 2) {
                $_showHide->addHide($showBlocks);
                if ($i == CRM_CUSTOM_FORM_FIELD_NUM_OPTION)
                    $_showHide->addHide('additionalOption');
            } else {
                $_showHide->addShow($showBlocks);
            }
            // label
            $this->add('text','option_label['.$i.']', ts('Label'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomOption', 'label'));

            // value
            $this->add('text', 'option_value['.$i.']', ts('Value'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomOption', 'value'));
            //$this->addRule('option_value['.$i.']', ts('Please enter a valid value for this field.'), 'qfVariable');

            // weight
            $this->add('text', 'option_weight['.$i.']', ts('Weight'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomOption', 'weight'));

            // is active ?
            $this->add('checkbox', 'option_status['.$i.']', ts('Active?'));

            $defaultOption[$i] = $this->createElement('radio', null, null, null, $i);

            //for checkbox handling of default option
            $this->add('checkbox', 'default_checkbox_option['.$i.']', null);

        }

        $_showHide->addToTemplate();                
        //default option selection
        $tt =& $this->addGroup($defaultOption, 'default_option');
        $this->add('text', 'start_date_years', ts('Dates may be up to'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'start_date_years'), false);
        $this->add('text', 'end_date_years', ts('Dates may be up to'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'end_date_years'),false);
        
        $this->addRule('start_date_years', ts('Value should be a positive number') , 'integer');
        $this->addRule('end_date_years', ts('Value should be a positive number') , 'integer');

        
        $includedPart[] = $this->createElement('checkbox', 'M',true,ts('Month'));
        $includedPart[] = $this->createElement('checkbox', 'd',true,ts('Day'));
        $includedPart[] = $this->createElement('checkbox', 'Y',true,ts('Year'));

        $this->addGroup($includedPart, 'date_parts',ts('Included date parts'));
        
        // for Note field
        
        $this->add('text', 'note_columns', ts('Width (columns)') . ' ', CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'note_columns'), false);
        $this->add('text', 'note_rows', ts('Height (rows)') . ' ', CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'note_rows'),false);
        
        $this->addRule('note_columns', ts('Value should be a positive number') , 'positiveInteger');
        $this->addRule('note_rows', ts('Value should be a positive number') , 'positiveInteger');


        // weight
        $this->add('text', 'weight', ts('Weight'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'weight'), true);
        $this->addRule('weight', ts(' is a numeric field') , 'numeric');
        
        // is required ?
        $this->add('checkbox', 'is_required', ts('Required?') );

        // checkbox / radio options per line
        $this->add('text', 'options_per_line', ts('Options Per Line'));
        $this->addRule('options_per_line', ts(' must be a numeric value') , 'numeric');

        // default value, help pre, help post, mask, attributes, javascript ?
        $this->add('text', 'default_value', ts('Default Value'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'default_value'));
        $this->add('textarea', 'help_post', ts('Field Help'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'help_post'));        
        $this->add('text', 'mask', ts('Mask'), CRM_Core_DAO::getAttribute('CRM_Core_DAO_CustomField', 'mask'));        

        // is active ?
        $this->add('checkbox', 'is_active', ts('Active?'));

        // is searchable ?
        $this->addElement('checkbox', 'is_searchable', ts('Is this Field Searchable?'), null, array('onclick' =>"showSearchRange(this)"));

        // is searchable by range?
        //$this->add('radio', 'is_search_range', ts('Search by Range?'), 'Yes');
        //        $this->add('radio', 'is_search_range', null, 'Yes', 'no');
        $searchRange = array( );
        $searchRange[] = $this->createElement( 'radio', null, null, ts( 'Yes' )    , '1'     );
        $searchRange[] = $this->createElement( 'radio', null, null, ts( 'No' ), '0' );
        
        $this->addGroup( $searchRange, 'is_search_range', ts( 'Search by Range?' ));
        //$this->setDefaults(array('is_search_range' => '1'));

        
        // add buttons
        $this->addButtons(array(
                                array ('type'      => 'next',
                                       'name'      => ts('Save'),
                                       'isDefault' => true),
                                array ('type'      => 'cancel',
                                       'name'      => ts('Cancel')),
                                )
                          );

        // add a form rule to check default value
        $this->addFormRule( array( 'CRM_Custom_Form_Field', 'formRule' ) );

        // if view mode pls freeze it with the done button.
        if ($this->_action & CRM_CORE_ACTION_VIEW) {
            $this->freeze();
            $url = CRM_Utils_System::url( 'civicrm/admin/custom/group/field', 'reset=1&action=browse&gid=' . $this->_gid );
            $this->addElement( 'button',
                               'done',
                               ts('Done'),
                               array( 'onClick' => "location.href='$url'" ) );
        }
    }
    
    /**
     * global validation rules for the form
     *
     * @param array  $fields   (referance) posted values of the form
     *
     * @return array    if errors then list of errors to be posted back to the form,
     *                  true otherwise
     * @static
     * @access public
     */
     function formRule( &$fields ) {
        $default = CRM_Utils_Array::value( 'default_value', $fields );
        $errors  = array( );
        if ( $default ) {
            $dataType = $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys'][$fields['data_type'][0]];
            switch ( $dataType ) {
            case 'Int':
                if ( ! CRM_Utils_Rule::integer( $default ) ) {
                    $errors['default_value'] = ts( 'Please enter a valid integer as default value.' );
                }
                break;

            case 'Float':
            case 'Money':
                if ( ! CRM_Utils_Rule::numeric( $default ) ) {
                    $errors['default_value'] = ts( 'Please enter a valid number as default value.' );
                }
                break;
                    
            case 'Date':
                if ( ! CRM_Utils_Rule::date( $default ) ) {
                    $errors['default_value'] = ts ( 'Please enter a valid date as default value using YYYY-MM-DD format. Example: 2004-12-31.' );
                }
                break;

            case 'Boolean':
                if ( ! CRM_Utils_Rule::integer( $default ) &&
                     ( $default != '1' || $default != '0' ) ) {
                    $errors['default_value'] = ts( 'Please enter 1 or 0 as default value.' );
                }
                break;

            case 'Country':
                if( !empty($default) ) {
                    $fieldCountry = addslashes( $fields['default_value'] );
                    $query = "SELECT count(*) FROM civicrm_country WHERE name = '$fieldCountry' OR iso_code = '$fieldCountry'";
                    if ( CRM_Core_DAO::singleValueQuery( $query ) <= 0 ) {
                        $errors['default_value'] = ts( 'Invalid default value for country.' );
                    }
                }
                break;

            case 'StateProvince':
                if( !empty($default) ) {
                    $fieldStateProvince = addslashes( $fields['default_value'] );
                    $query = "SELECT count(*) FROM civicrm_state_province WHERE name = '$fieldStateProvince' OR abbreviation = '$fieldStateProvince'";
                    if ( CRM_Core_DAO::singleValueQuery( $query ) <= 0 ) {
                        $errors['default_value'] = ts( 'The invalid default value for State/Province data type' );
                    }
                }
                break;
            }
        }
        

        /** Check the option values entered
         *  Appropriate values are required for the selected datatype
         *  Incomplete row checking is also required.
         */
        if (CRM_CORE_ACTION_ADD) {

            $_flagOption = $_rowError = 0;
            $_showHide =& new CRM_Core_ShowHideBlocks('','');
            $dataType = $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys'][$fields['data_type'][0]];
            
            //capture duplicate Custom option values
            if( !empty($fields['option_value']) ) {
                $countValue = count($fields['option_value']);
                $uniqueCount = count(array_unique($fields['option_value']));

                if ( $countValue > $uniqueCount) {

                    $start=1;
                    while ($start < CRM_CUSTOM_FORM_FIELD_NUM_OPTION) { 
                        $nextIndex = $start + 1;

                        while ($nextIndex <= CRM_CUSTOM_FORM_FIELD_NUM_OPTION) {

                            if ( $fields['option_value'][$start] == $fields['option_value'][$nextIndex] && !empty($fields['option_value'][$nextIndex]) ) {

                                $errors['option_value['.$start.']']     = ts( 'Duplicate Option values' );
                                $errors['option_value['.$nextIndex.']'] = ts( 'Duplicate Option values' );
                                $_flagOption = 1;
                            }
                            $nextIndex++;
                        }
                        $start++;
                    }
                }
            }
            
            //capture duplicate Custom Option label
            if( !empty($fields['option_label']) ) {
                $countValue = count($fields['option_label']);
                $uniqueCount = count(array_unique($fields['option_label']));

                if ( $countValue > $uniqueCount) {

                    $start=1;
                    while ($start < CRM_CUSTOM_FORM_FIELD_NUM_OPTION) { 
                        $nextIndex = $start + 1;

                        while ($nextIndex <= CRM_CUSTOM_FORM_FIELD_NUM_OPTION) {

                            if ( $fields['option_label'][$start] == $fields['option_label'][$nextIndex] && !empty($fields['option_label'][$nextIndex]) ) {

                                $errors['option_label['.$start.']']     =  ts( 'Duplicate Option label' );
                                $errors['option_label['.$nextIndex.']'] = ts( 'Duplicate Option label' );
                                $_flagOption = 1;
                            }
                            $nextIndex++;
                        }
                        $start++;
                    }
                }
            }

            for($i=1; $i<= CRM_CUSTOM_FORM_FIELD_NUM_OPTION; $i++) {
                if (!$fields['option_label'][$i]) {
                    if ($fields['option_value'][$i]) {
                        $errors['option_label['.$i.']'] = ts( 'Option label cannot be empty' );
                        $_flagOption = 1;
                    } else {
                        $_emptyRow = 1;
                    }
                } else {
                    if (!strlen(trim($fields['option_value'][$i]))) {
                        if (!$fields['option_value'][$i]) {
                            $errors['option_value['.$i.']'] = ts( 'Option value cannot be empty' );
                            $_flagOption = 1;
                        }
                    }
                }
                if ($fields['option_value'][$i] && $dataType != 'String') {
                    if ( $dataType == 'Int') {
                        if ( ! CRM_Utils_Rule::integer( $fields['option_value'][$i] ) ) {
                            $_flagOption = 1;
                            $errors['option_value['.$i.']'] = ts( 'Please enter a valid integer.' );
                        }
                    } else {
                        if ( ! CRM_Utils_Rule::numeric( $fields['option_value'][$i] ) ) {
                            $_flagOption = 1;
                            $errors['option_value['.$i.']'] = ts( 'Please enter a valid number.' );
                        }
                    }
                }
                
                
                $showBlocks = 'optionField['.$i.']';
                if ($_flagOption) {
                    $_showHide->addShow($showBlocks);
                    $_rowError = 1;
                } 
                
                if ($_emptyRow) {
                    $_showHide->addHide($showBlocks);
                } else {
                    $_showHide->addShow($showBlocks);
                }
                if ($i == CRM_CUSTOM_FORM_FIELD_NUM_OPTION) {
                    $hideBlock = 'additionalOption';
                    $_showHide->addHide($hideBlock);
                }

                $_flagOption = $_emptyRow = 0;
            }
            
            if ($_rowError) {
                $_showHide->addToTemplate();
                CRM_Core_Page::assign('optionRowError', $_rowError);
            } else {
                switch ($GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToHTML'][$fields['data_type'][0]][$fields['data_type'][1]]) {
                case 'Radio':
                    $_fieldError = 1;
                    CRM_Core_Page::assign('fieldError', $_fieldError);
                    break; 
                
                case 'Checkbox':
                    $_fieldError = 1;
                    CRM_Core_Page::assign('fieldError', $_fieldError);
                    break; 

                case 'Select':
                    $_fieldError = 1;
                    CRM_Core_Page::assign('fieldError', $_fieldError);
                    break;
                default:
                    $_fieldError = 0;
                    CRM_Core_Page::assign('fieldError', $_fieldError);
                }
                
                
                for ($idx=1; $idx<= CRM_CUSTOM_FORM_FIELD_NUM_OPTION; $idx++) {
                    $showBlocks = 'optionField['.$idx.']';
                    if (!empty($fields['option_label'][$idx])) {
                        $_showHide->addShow($showBlocks);
                    } else {
                        $_showHide->addHide($showBlocks);
                    }
                }
                $_showHide->addToTemplate();
            }
        }
        
        return empty($errors) ? true : $errors;
    }

    /**
     * Process the form
     * 
     * @param null
     * 
     * @return void
     * @access public
     */
     function postProcess()
    {
        // store the submitted values in an array
        $params = $this->controller->exportValues('Field');
        // set values for custom field properties and save
        $customField                =& new CRM_Core_DAO_CustomField();
        $customField->label         = $params['label'];
        $customField->name          = CRM_Utils_String::titleToVar($params['label']);
        $customField->data_type     = $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys'][$params['data_type'][0]];
        $customField->html_type     = $GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataToHTML'][$params['data_type'][0]][$params['data_type'][1]];
        
        // fix for CRM-316
        if ($this->_action & CRM_CORE_ACTION_UPDATE) {

            $cf =& new CRM_Core_DAO_CustomField();
            $cf->id = $this->_id;
            $cf->find();

            
            if ( $cf->fetch() && $cf->weight != $params['weight'] ) {
                    
                $searchWeight =& new CRM_Core_DAO_CustomField();
                $searchWeight->custom_group_id = $this->_gid;
                $searchWeight->weight = $params['weight'];
                
                if ( $searchWeight->find() ) {
                    $tempDAO =& new CRM_Core_DAO();
                    $query = "SELECT id FROM civicrm_custom_field WHERE weight >= ". $searchWeight->weight ." AND custom_group_id = ".$this->_gid;
                    $tempDAO->query($query);

                    $fieldIds = array();
                    while($tempDAO->fetch()) {
                        $fieldIds[] = $tempDAO->id; 
                    }
                    
                    if ( !empty($fieldIds) ) {
                        $cfDAO =& new CRM_Core_DAO();
                        $updateSql = "UPDATE civicrm_custom_field SET weight = weight + 1 WHERE id IN ( ".implode(",", $fieldIds)." ) ";
                        $cfDAO->query($updateSql);                    
                    }
                }
            }                
                        
            $customField->weight  = $params['weight'];
            
        } else {
            $cf =& new CRM_Core_DAO_CustomField();
            $cf->custom_group_id = $this->_gid;
            $cf->weight = $params['weight'];
            
            if ( $cf->find() ) {
                $tempDAO =& new CRM_Core_DAO();
                $query = "SELECT id FROM civicrm_custom_field WHERE weight >= ". $cf->weight ." AND custom_group_id = ".$this->_gid;
                $tempDAO->query($query);
                
                $fieldIds = array();                
                while($tempDAO->fetch()) {
                    $fieldIds[] = $tempDAO->id;                
                }
                
                if ( !empty($fieldIds) ) {
                    $cfDAO =& new CRM_Core_DAO();
                    $updateSql = "UPDATE civicrm_custom_field SET weight = weight + 1 WHERE id IN ( ".implode(",", $fieldIds)." ) ";
                    $cfDAO->query($updateSql);
                }
            }          

            $customField->weight         = $params['weight'];             
        }

        //$customField->default_value = $params['default_value'];
        //store the primary key for State/Province or Country as default value.
        if ( strlen(trim($params['default_value']))) {
            switch ($GLOBALS['_CRM_CUSTOM_FORM_FIELD']['_dataTypeKeys'][$params['data_type'][0]]) {
            case 'StateProvince':
                $daoState =& new CRM_Core_DAO();
                $fieldStateProvince = $params['default_value'];
                $query = "SELECT * FROM civicrm_state_province WHERE name = '$fieldStateProvince' OR abbreviation = '$fieldStateProvince'";
                $daoState->query($query);
                $daoState->fetch();
                $customField->default_value = $daoState->id;
                break;
                
            case 'Country':                
                $daoCountry =& new CRM_Core_DAO();
                $fieldCountry = $params['default_value'];
                $query = "SELECT * FROM civicrm_country WHERE name = '$fieldCountry' OR iso_code = '$fieldCountry'";
                $daoCountry->query($query);
                $daoCountry->fetch();
                $customField->default_value = $daoCountry->id;            
                break;

            default:
                $customField->default_value = $params['default_value'];              
            }            
        }    

        // special for checkbox options
        if ($this->_action & CRM_CORE_ACTION_ADD) {
            if ( ($customField->html_type == 'CheckBox' || $customField->html_type == 'Multi-Select') &&  isset($params['default_checkbox_option'])) {
                $tempArray = array_keys($params['default_checkbox_option']);
                $defaultArray = array();
                foreach ($tempArray as $k => $v) {
                    if ( $params['option_value'][$v] ) {
                        $defaultArray[] = $params['option_value'][$v];
                    }
                }                
                $customField->default_value = implode(CRM_CORE_BAO_CUSTOMOPTION_VALUE_SEPERATOR, $defaultArray);                
            } else {
                if ( isset($params['option_value'][$params['default_option']]) ) {
                    $customField->default_value = $params['option_value'][$params['default_option']];
                } else {
                    $customField->default_value = $params['default_value'];
                }
            }
        }

        // for 'is_search_range' field.   
        if ($params['data_type'][0] == 1 || $params['data_type'][0] == 2 || $params['data_type'][0] == 3 || $params['data_type'][0] == 5) {
            if (!$params['is_searchable']) {
                $params['is_search_range'] = 0;
            }
            
        }
        else {
            if ($params['is_searchable']) {
                $params['is_search_range'] = 0;
            }
            else {
                $params['is_search_range'] = 0;
            }
        }

        $customField->help_post        = $params['help_post'];
        $customField->mask             = $params['mask'];
        $customField->is_required      = CRM_Utils_Array::value( 'is_required', $params, false );
        $customField->is_searchable    = CRM_Utils_Array::value( 'is_searchable', $params, false );
        $customField->is_search_range  = CRM_Utils_Array::value( 'is_search_range', $params, false );
        $customField->is_active        = CRM_Utils_Array::value( 'is_active', $params, false );
        $customField->options_per_line = $params['options_per_line'];
        $customField->start_date_years = $params['start_date_years'];
        $customField->end_date_years   = $params['end_date_years'];
        $customField->note_columns     = $params['note_columns'];
        $customField->note_rows        = $params['note_rows'];
        
        if( is_array($params['date_parts']) ) {
            $customField->date_parts       = implode(CRM_CORE_BAO_CUSTOMOPTION_VALUE_SEPERATOR,array_keys($params['date_parts']));
        } else {
            $customField->date_parts       = "";
        }
        
        if ( strtolower( $customField->html_type ) == 'textarea' ) {
            $customField->attributes = 'rows=4, cols=60';
        }

        if ($this->_action & CRM_CORE_ACTION_UPDATE) {
            $customField->id = $this->_id;
        }

        // need the FKEY - custom group id
        $customField->custom_group_id = $this->_gid;

        $customField->save();

        //Start Storing the values of Option field if the selected option is Multi Select
        if ($this->_action & CRM_CORE_ACTION_ADD) {
            
            if($customField->data_type == 'String' ||
               $customField->data_type == 'Int' ||
               $customField->data_type == 'Float' ||
               $customField->data_type == 'Money') {
                if($customField->html_type != 'Text') {                
                    foreach ($params['option_value'] as $k => $v) {
                        if (strlen(trim($v))) {
                            $customOptionDAO =& new CRM_Core_DAO_CustomOption();
                            $customOptionDAO->entity_id     = $customField->id;
                            $customOptionDAO->entity_table  = 'civicrm_custom_field';
                            $customOptionDAO->label         = $params['option_label'][$k];
                            $customOptionDAO->value         = $v;
                            $customOptionDAO->weight        = $params['option_weight'][$k];
                            $customOptionDAO->is_active     = $params['option_status'][$k];
                            $customOptionDAO->save();
                        }
                    }                                                       
                }
            }
        }
        CRM_Core_Session::setStatus(ts('Your custom field "%1" has been saved', array(1 => $customField->label)));
    }
}
?>

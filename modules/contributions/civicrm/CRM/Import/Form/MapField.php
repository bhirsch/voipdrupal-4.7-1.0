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


require_once 'CRM/Core/Form.php';

require_once 'CRM/Core/DAO/Mapping.php';
require_once 'CRM/Core/DAO/MappingField.php';
require_once 'CRM/Contact/DAO/RelationshipType.php';

require_once 'CRM/Core/BAO/LocationType.php';

require_once 'CRM/Import/Parser/Contact.php';

/**
 * This class gets the name of the file to upload
 */
class CRM_Import_Form_MapField extends CRM_Core_Form {

    /**
     * cache of preview data values
     *
     * @var array
     * @access protected
     */
    var $_dataValues;

    /**
     * mapper fields
     *
     * @var array
     * @access protected
     */
    var $_mapperFields;

    /**
     * loaded mapping ID
     *
     * @var int
     * @access protected
     */
    var $_loadedMappingId;

    /**
     * number of columns in import file
     *
     * @var int
     * @access protected
     */
    var $_columnCount;


    /**
     * column headers, if we have them
     *
     * @var array
     * @access protected
     */
    var $_columnHeaders;

    /**
     * an array of booleans to keep track of whether a field has been used in
     * form building already.
     *
     * @var array
     * @access protected
     */
    var $_fieldUsed;
    

    
    /**
     * Attempt to resolve the header with our mapper fields
     *
     * @param header
     * @param mapperFields
     * @return string
     * @access public
     */
     function defaultFromHeader($header, &$patterns) {
        foreach ($patterns as $key => $re) {
            /* Skip the first (empty) key/pattern */
            if ( empty( $re ) ) {
                continue;
            }

            if (preg_match($re, $header)) {
                $this->_fieldUsed[$key] = true;
                return $key;
            }
        }
        return '';
    }

    /**
     * Guess at the field names given the data and patterns from the schema
     *
     * @param patterns
     * @param index
     * @return string
     * @access public
     */
     function defaultFromData(&$patterns, $index) {
        $best = '';
        $bestHits = 0;
        $n = count($this->_dataValues);
        
        foreach ($patterns as $key => $re) {
            if (empty($re)) continue;

            /* Take a vote over the preview data set */
            $hits = 0;
            for ($i = 0; $i < $n; $i++) {
                if (preg_match($re, $this->_dataValues[$i][$index])) {
                    $hits++;
                }
            }

            if ($hits > $bestHits) {
                $bestHits = $hits;
                $best = $key;
            }
        }
    
        if ($best != '') {
            $this->_fieldUsed[$best] = true;
        }
        return $best;
    }

    /**
     * Function to set variables up before form is built
     *
     * @return void
     * @access public
     */
     function preProcess()
    {
        $this->_mapperFields = $this->get( 'fields' );
        
        $this->_columnCount = $this->get( 'columnCount' );
        $this->assign( 'columnCount' , $this->_columnCount );
        $this->_dataValues = $this->get( 'dataValues' );
        $this->assign( 'dataValues'  , $this->_dataValues );
        
        $skipColumnHeader = $this->controller->exportValue( 'UploadFile', 'skipColumnHeader' );

        if ( $skipColumnHeader ) {
            $this->assign( 'skipColumnHeader' , $skipColumnHeader );
            $this->assign( 'rowDisplayCount', 3 );
            /* if we had a column header to skip, stash it for later */
            $this->_columnHeaders = $this->_dataValues[0];
        } else {
            $this->assign( 'rowDisplayCount', 2 );
        }
        
    }

    /**
     * Function to actually build the form
     *
     * @return void
     * @access public
     */
     function buildQuickForm()
    {
        //get the saved mapping details
        $mappingDAO =&  new CRM_Core_DAO_Mapping();
        $mappingDAO->domain_id = CRM_Core_Config::domainID( );
        $mappingDAO->mapping_type = 'Import';
        $mappingDAO->find();
        
        $mappingArray = array();
        while ($mappingDAO->fetch()) {
            $mappingArray[$mappingDAO->id] = $mappingDAO->name;
        }

        $this->assign('savedMapping',$mappingArray);
        $this->add('select','savedMapping', ts('Mapping Option'), array('' => ts('- select -'))+$mappingArray);
        $this->addElement('submit','loadMapping',ts('Load Mapping'), null, array('onclick'=>'checkSelect()'));

        //to save the current mappings
        if ( !$this->get('savedMapping') ) {
            $saveDetailsName = ts('Save this field mapping');
            $this->add('text','saveMappingName',ts('Name'));
            $this->add('text','saveMappingDesc',ts('Description'));
        } else {
            $savedMapping = $this->get('savedMapping');
            //mapping is to be loaded from database
            $mapping =& new CRM_Core_DAO_MappingField();
            $mapping->mapping_id = $savedMapping;
            $mapping->orderBy('column_number');
            $mapping->find();

            $mappingName = array();
            $mappingLocation = array();
            $mappingContactType = array();
            $mappingPhoneType = array();
            $mappingRelation = array();
            while($mapping->fetch()) {
                $mappingName[$mapping->column_number] = $mapping->name;
                $mappingContactType[] = $mapping->contact_type;                

                if ( !empty($mapping->location_type_id ) ) {
                    $mappingLocation[$mapping->column_number] = $mapping->location_type_id;
                }

                if ( !empty( $mapping->phone_type ) ) {
                    $mappingPhoneType[$mapping->column_number] = $mapping->phone_type;
                }
                
                if ( !empty($mapping->relationship_type_id) ) {
                    $mappingRelation[$mapping->column_number] = $mapping->relationship_type_id;
                }
            }

            $this->assign('loadedMapping', $savedMapping);

            $getMappingName =&  new CRM_Core_DAO_Mapping();
            $getMappingName->id = $savedMapping;
            $getMappingName->mapping_type = 'Import';
            $getMappingName->find();
            while($getMappingName->fetch()) {
                $mapperName = $getMappingName->name;
            }

            $this->assign('savedName', $mapperName);

            $this->add('hidden','mappingId',$savedMapping);

            $this->addElement('checkbox','updateMapping',ts('Update this field mapping'), null);
            $saveDetailsName = ts('Save as a new field mapping');
            $this->add('text','saveMappingName',ts('Name'));
            $this->add('text','saveMappingDesc',ts('Description'));
        }
        
        $this->addElement('checkbox','saveMapping',$saveDetailsName, null, array('onclick' =>"showSaveDetails(this)"));
        
        $this->addFormRule( array( 'CRM_Import_Form_MapField', 'formRule' ) );

        //-------- end of saved mapping stuff ---------

        $defaults = array( );
        $mapperKeys      = array_keys( $this->_mapperFields );
        $hasHeaders      = !empty($this->_columnHeaders);
        $headerPatterns  = $this->get( 'headerPatterns' );
        $dataPatterns    = $this->get( 'dataPatterns' );
        $hasLocationTypes = $this->get( 'fieldTypes' );

        $this->_location_types  =& CRM_Core_PseudoConstant::locationType();

        $defaultLocationType =& CRM_Core_BAO_LocationType::getDefault();

        /* FIXME: dirty hack to make the default option show up first.  This
         * avoids a mozilla browser bug with defaults on dynamically constructed
         * selector widgets. */
        if ($defaultLocationType) {
            $defaultLocation = $this->_location_types[$defaultLocationType->id];
            unset($this->_location_types[$defaultLocationType->id]);
            $this->_location_types = 
                array($defaultLocationType->id => $defaultLocation) + 
                $this->_location_types;
        }

        /* Initialize all field usages to false */
        foreach ($mapperKeys as $key) {
            $this->_fieldUsed[$key] = false;
        }

        $sel1 = $this->_mapperFields;

        $sel2[''] = null;
        $phoneTypes = CRM_Core_SelectValues::phoneType();
        foreach ($this->_location_types as $key => $value) {
            $sel3['phone'][$key] =& $phoneTypes;
        }

        foreach ($mapperKeys as $key) {
            list($id, $first, $second) = explode('_', $key);
            if ( ($first == 'a' && $second == 'b') || ($first == 'b' && $second == 'a') ) {
                $contactRelation =& new CRM_Contact_DAO_RelationshipType();
                $contactRelation->id = $id;
                $contactRelation->find(true);

                eval( '$cType = $contactRelation->contact_type_' . $second . ';');

                if ( ! $cType ) {
                    $cType = 'All';
                }

                $relatedFields = array();
                require_once 'CRM/Contact/BAO/Contact.php'; 
                $relatedFields =& CRM_Contact_BAO_Contact::importableFields( $cType ); 
                unset($relatedFields['']);
                $values = array();
                foreach ($relatedFields as $name => $field ) {
                    $values[$name] = $field['title'];
                    if ($hasLocationTypes[$name]) {
                        $sel3[$key][$name] = $this->_location_types;
                    } else {
                        $sel3[$name] = null;
                    }
                }
                $sel2[$key] = $values;

                foreach ($this->_location_types as $k => $value) {
                    $sel4[$key]['phone'][$k] =& $phoneTypes;
                }
                
            } else {
                if ($hasLocationTypes[$key]) {
                    $sel2[$key] = $this->_location_types;
                } else {
                    $sel2[$key] = null;
                }
            }
        }

        $js = "<script type='text/javascript'>\n";
        $formName = 'document.forms.' . $this->_name;
        
        //used to warn for mismatch column count or mismatch mapping      
        $warning = 0;

        
        for ( $i = 0; $i < $this->_columnCount; $i++ ) {
            $sel =& $this->addElement('hierselect', "mapper[$i]", ts('Mapper for Field %1', array(1 => $i)), null);
            $jsSet = false;
            if( $this->get('savedMapping') ) {                                              
                if ( isset($mappingName[$i]) ) {
                    if ( $mappingName[$i] != ts('- do not import -')) {                                
                        
                        if ( isset($mappingRelation[$i]) ) {
                            // relationship mapping
                            switch ($this->get('contactType')) {
                            case CRM_IMPORT_PARSER_CONTACT_INDIVIDUAL :
                                $contactType = 'Individual';
                                break;
                            case CRM_IMPORT_PARSER_CONTACT_HOUSEHOLD :
                                $contactType = 'Household';
                                break;
                            case CRM_IMPORT_PARSER_CONTACT_ORGANIZATION :
                                $contactType = 'Organization';
                            }

                            $relations = CRM_Contact_BAO_Relationship::getContactRelationshipType( null, null, null, $contactType );
                            foreach ($relations as $key => $var) {
                                list( $type ) = explode( '_', $key );
                                if ( $type == $mappingRelation[$i]) {
                                    $relation = $key;
                                    break;
                                }
                            }

                            $contactDetails = strtolower(str_replace(" ", "_",$mappingName[$i]));
                            $locationId = isset($mappingLocation[$i])? $mappingLocation[$i] : 0;
                            $phoneType = isset($mappingPhoneType[$i]) ? $mappingPhoneType[$i] : null;
                            $defaults["mapper[$i]"] = array( $relation, $contactDetails, 
                                                             $locationId, $phoneType
                                                             );
                            if ( ! $contactDetails ) {
                                $js .= "{$formName}['mapper[$i][1]'].style.display = 'none';\n";
                            }
                            if ( ! $locationId ) {
                                $js .= "{$formName}['mapper[$i][2]'].style.display = 'none';\n";
                            }
                            if ( ! $phoneType ) {
                                $js .= "{$formName}['mapper[$i][3]'].style.display = 'none';\n";
                            }
                            //$js .= "{$formName}['mapper[$i][3]'].style.display = 'none';\n";
                            $jsSet = true;
                        } else {
                            $mappingHeader = array_keys($this->_mapperFields, $mappingName[$i]);
                            $locationId = isset($mappingLocation[$i])? $mappingLocation[$i] : 0;
                            $phoneType = isset($mappingPhoneType[$i]) ? $mappingPhoneType[$i] : null;
                            
                            if ( ! $locationId ) {
                                $js .= "{$formName}['mapper[$i][1]'].style.display = 'none';\n";
                            }

                            if ( ! $phoneType ) {
                                $js .= "{$formName}['mapper[$i][2]'].style.display = 'none';\n";
                            }
                            
                            $js .= "{$formName}['mapper[$i][3]'].style.display = 'none';\n";
                            
                            $defaults["mapper[$i]"] = array( $mappingHeader[0], $locationId, $phoneType );
                            $jsSet = true;
                        }                        
                    } else {
                        $defaults["mapper[$i]"] = array();
                    }                          
                    if ( ! $jsSet ) {
                        for ( $k = 1; $k < 4; $k++ ) {
                            $js .= "{$formName}['mapper[$i][$k]'].style.display = 'none';\n"; 
                        }
                    }
                } else {
                    // this load section to help mapping if we ran out of saved columns when doing Load Mapping
                    $js .= "swapOptions($formName, 'mapper[$i]', 0, 3, 'hs_mapper_".$i."_');\n";
                    
                    if ($hasHeaders) {
                        $defaults["mapper[$i]"] = array( $this->defaultFromHeader($this->_columnHeaders[$i],$headerPatterns) );
                    } else {
                        $defaults["mapper[$i]"] = array( $this->defaultFromData($dataPatterns, $i) );
                    }                    
                } //end of load mapping
            } else {
                $js .= "swapOptions($formName, 'mapper[$i]', 0, 3, 'hs_mapper_".$i."_');\n";
                if ($hasHeaders) {
                    // Infer the default from the skipped headers if we have them
                    $defaults["mapper[$i]"] = array(
                                                           $this->defaultFromHeader($this->_columnHeaders[$i], 
                                                                                    $headerPatterns),
                                                           0
                                                           );
                    
                } else {
                    // Otherwise guess the default from the form of the data
                    $defaults["mapper[$i]"] = array(
                                                           $this->defaultFromData($dataPatterns, $i),
                                                           //                     $defaultLocationType->id
                                                           0
                                                           );
                }
            }
            
            $sel->setOptions(array($sel1, $sel2, $sel3, $sel4));
        }
        $js .= "</script>\n";
        $this->assign('initHideBoxes', $js);

        //set warning if mismatch in more than 
        if ( ($this->_columnCount != count($mappingName)) ) {
            $warning++;            
        }

        if ( $warning != 0 && $this->get('savedMapping') ) {
            $session =& CRM_Core_Session::singleton( );
            $session->setStatus( ts( 'The data columns in this import file appear to be different from the saved mapping. Please verify that you have selected the correct saved mapping before continuing.' ) );
        } else {
            $session =& CRM_Core_Session::singleton( );
            $session->setStatus( null ); 
        }

        $this->setDefaults( $defaults );       

        $this->addButtons( array(
                                 array ( 'type'      => 'back',
                                         'name'      => ts('<< Previous') ),
                                 array ( 'type'      => 'next',
                                         'name'      => ts('Continue >>'),
                                         'spacing'   => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                         'isDefault' => true   ),
                                 array ( 'type'      => 'cancel',
                                         'name'      => ts('Cancel') ),
                                 )
                           );
    }

    /**
     * global validation rules for the form
     *
     * @param array $fields posted values of the form
     *
     * @return array list of errors to be posted back to the form
     * @static
     * @access public
     */
     function formRule( &$fields ) {
        $errors  = array( );

        if ( CRM_Utils_Array::value( 'saveMapping', $fields ) ) {
            $nameField = CRM_Utils_Array::value( 'saveMappingName', $fields );
            if ( empty( $nameField ) ) {
                $errors['saveMappingName'] = ts('Name is required to save Import Mapping');
            } else {
                $mappingName =& new CRM_Core_DAO_Mapping();
                $mappingName->name = $nameField;
                $mappingName->domain_id = CRM_Core_Config::domainID( );
                $mappingName->mapping_type = 'Import';
                if ( $mappingName->find( true ) ) {
                    $errors['saveMappingName'] = ts('Duplicate Import Mapping Name');
                }
            }
        }

        if ( !empty($errors) ) {
            $_flag = 1;
            require_once 'CRM/Core/Page.php';
            $assignError =& new CRM_Core_Page(); 
            $assignError->assign('mappingDetailsError', $_flag);
            return $errors;
        } else {
            return true;
        }
    }

    /**
     * Process the mapped fields and map it into the uploaded file
     * preview the file and extract some summary statistics
     *
     * @return void
     * @access public
     */
     function postProcess()
    {
        $params = $this->controller->exportValues( 'MapField' );

        //reload the mapfield if load mapping is pressed
        if( !empty($params['savedMapping']) ) {            
            $this->set('savedMapping', $params['savedMapping']);
            $this->controller->resetPage( $this->_name );
            return;
        }
        
        
        $fileName         = $this->controller->exportValue( 'UploadFile', 'uploadFile' );
        $skipColumnHeader = $this->controller->exportValue( 'UploadFile', 'skipColumnHeader' );

        $seperator = ',';

        $mapperKeys = array( );
        $mapper     = array( );
        $mapperKeys = $this->controller->exportValue( $this->_name, 'mapper' );
        $mapperKeysMain     = array();
        $mapperLocType      = array();
        $mapperPhoneType    = array();
        
        $locations = array();
        
        for ( $i = 0; $i < $this->_columnCount; $i++ ) {
            $mapper[$i]     = $this->_mapperFields[$mapperKeys[$i][0]];
            $mapperKeysMain[$i] = $mapperKeys[$i][0];

            //$mapperLocType[$i] = $mapperKeys[$i][1];
            
            if (is_numeric($mapperKeys[$i][1])) {
                $mapperLocType[$i] = $mapperKeys[$i][1];
            } else {
                $mapperLocType[$i] = null;
            }

            $locations[$i]  =   isset($mapperLocType[$i])
                            ?   $this->_location_types[$mapperLocType[$i]]
                            :   null;

            //$mapperPhoneType[$i] = $mapperKeys[$i][2];
            if ( !is_numeric($mapperKeys[$i][2])) {
                $mapperPhoneType[$i] = $mapperKeys[$i][2];
            } else {
                $mapperPhoneType[$i] = null;
            }

            //relationship info
            list($id, $first, $second) = explode('_', $mapperKeys[$i][0]);
            if ( ($first == 'a' && $second == 'b') || ($first == 'b' && $second == 'a') ) {
                $related[$i] = $this->_mapperFields[$mapperKeys[$i][0]];
                $relatedContactDetails[$i] = ucwords(str_replace("_", " ",$mapperKeys[$i][1]));
                $relatedContactLocType[$i] = isset($mapperKeys[$i][1]) ? $this->_location_types[$mapperKeys[$i][2]] : null;
                //$relatedContactPhoneType[$i] = !is_numeric($mapperKeys[$i][2]) ? $mapperKeys[$i][3] : null;
                $relatedContactPhoneType[$i] = isset($mapperKeys[$i][3]) ? $mapperKeys[$i][3] : null;
                $relationType =& new CRM_Contact_DAO_RelationshipType();
                $relationType->id = $id;
                $relationType->find(true);
                eval( '$relatedContactType[$i] = $relationType->contact_type_'.$second.';');
            } else {
                $related[$i] = null;
                $relatedContactType[$i] = null;
                $relatedContactDetails[$i] = null;
                $relatedContactLocType[$i] = null;                
                $relatedContactPhoneType[$i] = null;
            }            
        }

        $this->set( 'mapper'    , $mapper     );
        $this->set( 'locations' , $locations  );
        $this->set( 'phones', $mapperPhoneType);

        //relationship info
        $this->set( 'related'    , $related     );
        $this->set( 'relatedContactType',$relatedContactType );
        $this->set( 'relatedContactDetails',$relatedContactDetails );
        $this->set( 'relatedContactLocType',$relatedContactLocType );
        $this->set( 'relatedContactPhoneType',$relatedContactPhoneType );
               
        // store mapping Id to display it in the preview page 
        $this->set('loadMappingId', $params['mappingId']);
        
        //Updating Mapping Records
        if ( CRM_Utils_Array::value('updateMapping', $params)) {
            
            $locationTypes =& CRM_Core_PseudoConstant::locationType();            

            $mappingFields =& new CRM_Core_DAO_MappingField();
            $mappingFields->mapping_id = $params['mappingId'];
            $mappingFields->find( );
            
            $mappingFieldsId = array();                
            while($mappingFields->fetch()) {
                if ( $mappingFields->id ) {
                    $mappingFieldsId[$mappingFields->column_number] = $mappingFields->id;
                }
            }
                
            for ( $i = 0; $i < $this->_columnCount; $i++ ) {

                $updateMappingFields =& new CRM_Core_DAO_MappingField();
                $updateMappingFields->id = $mappingFieldsId[$i];
                $updateMappingFields->mapping_id = $params['mappingId'];
                $updateMappingFields->column_number = $i;

                list($id, $first, $second) = explode('_', $mapperKeys[$i][0]);
                if ( ($first == 'a' && $second == 'b') || ($first == 'b' && $second == 'a') ) {
                    $updateMappingFields->relationship_type_id = $id;
                    $updateMappingFields->name = ucwords(str_replace("_", " ",$mapperKeys[$i][1]));
                    $updateMappingFields->location_type_id = isset($mapperKeys[$i][2]) ? $mapperKeys[$i][2] : null;                 
                    $updateMappingFields->phone_type = isset($mapperKeys[$i][3]) ? $mapperKeys[$i][3] : null;                  
                } else {
                    $updateMappingFields->name = $mapper[$i];
                    $updateMappingFields->relationship_type_id = null;
                    $location = array_keys($locationTypes, $locations[$i]);
                    $updateMappingFields->location_type_id = isset($location) ? $location[0] : null;                    
                    $updateMappingFields->phone_type = !is_numeric($mapperPhoneType[$i]) ? $mapperPhoneType[$i] : null; 
                }
                $updateMappingFields->save();                
            }
        }
        
        //Saving Mapping Details and Records
        if ( CRM_Utils_Array::value('saveMapping', $params)) {
            $saveMapping =& new CRM_Core_DAO_Mapping();
            $saveMapping->domain_id = CRM_Core_Config::domainID( );
            $saveMapping->name = $params['saveMappingName'];
            $saveMapping->description = $params['saveMappingDesc'];
            $saveMapping->mapping_type = 'Import';
            $saveMapping->save();
            
            $locationTypes =& CRM_Core_PseudoConstant::locationType();
            $contactType = $this->get('contactType');
            switch ($contactType) {
            case CRM_IMPORT_PARSER_CONTACT_INDIVIDUAL :
                $cType = 'Individual';
                break;
            case CRM_IMPORT_PARSER_CONTACT_HOUSEHOLD :
                $cType = 'Household';
                break;
            case CRM_IMPORT_PARSER_CONTACT_ORGANIZATION :
                $cType = 'Organization';
            }

            for ( $i = 0; $i < $this->_columnCount; $i++ ) {                  
                
                $saveMappingFields =& new CRM_Core_DAO_MappingField();
                $saveMappingFields->mapping_id = $saveMapping->id;
                $saveMappingFields->contact_type = $cType;
                $saveMappingFields->column_number = $i;                             
                
                list($id, $first, $second) = explode('_', $mapperKeys[$i][0]);
                if ( ($first == 'a' && $second == 'b') || ($first == 'b' && $second == 'a') ) {
                    $saveMappingFields->name = ucwords(str_replace("_", " ",$mapperKeys[$i][1]));
                    $saveMappingFields->relationship_type_id = $id;
                    $saveMappingFields->phone_type = isset($mapperKeys[$i][3]) ? $mapperKeys[$i][3] : null;
                    $saveMappingFields->location_type_id = isset($mapperKeys[$i][2]) ? $mapperKeys[$i][2] : null;
                } else {
                    $saveMappingFields->name = $mapper[$i];
                    $location_id = array_keys($locationTypes, $locations[$i]);
                    $saveMappingFields->location_type_id = isset($location_id[0]) ? $location_id[0] : null;
                    $saveMappingFields->phone_type = !is_numeric($mapperPhoneType[$i]) ? $mapperPhoneType[$i] : null;
                    $saveMappingFields->relationship_type_id = null;
                }
                $saveMappingFields->save();
            }
        }

        $parser =& new CRM_Import_Parser_Contact(  $mapperKeysMain, $mapperLocType, $mapperPhoneType, 
                                                   $related, $relatedContactType, $relatedContactDetails, 
                                                   $relatedContactLocType, $relatedContactPhoneType );
        $parser->run( $fileName, $seperator, $mapper, $skipColumnHeader,
                      CRM_IMPORT_PARSER_MODE_PREVIEW, $this->get('contactType') );
        
        // add all the necessary variables to the form
        $parser->set( $this );        
    }

    /**
     * Return a descriptive name for the page, used in wizard header
     *
     * @return string
     * @access public
     */
     function getTitle()
    {
        return ts('Match Fields');
    }

    
}

?>

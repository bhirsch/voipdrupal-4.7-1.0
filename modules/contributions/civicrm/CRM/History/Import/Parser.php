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


define( 'CRM_HISTORY_IMPORT_PARSER_MAX_ERRORS',250);
define( 'CRM_HISTORY_IMPORT_PARSER_MAX_WARNINGS',25);
define( 'CRM_HISTORY_IMPORT_PARSER_VALID',1);
define( 'CRM_HISTORY_IMPORT_PARSER_WARNING',2);
define( 'CRM_HISTORY_IMPORT_PARSER_ERROR',4);
define( 'CRM_HISTORY_IMPORT_PARSER_CONFLICT',8);
define( 'CRM_HISTORY_IMPORT_PARSER_STOP',16);
define( 'CRM_HISTORY_IMPORT_PARSER_DUPLICATE',32);
define( 'CRM_HISTORY_IMPORT_PARSER_MULTIPLE_DUPE',64);
define( 'CRM_HISTORY_IMPORT_PARSER_MODE_MAPFIELD',1);
define( 'CRM_HISTORY_IMPORT_PARSER_MODE_PREVIEW',2);
define( 'CRM_HISTORY_IMPORT_PARSER_MODE_SUMMARY',4);
define( 'CRM_HISTORY_IMPORT_PARSER_MODE_IMPORT',8);
define( 'CRM_HISTORY_IMPORT_PARSER_DUPLICATE_SKIP',1);
define( 'CRM_HISTORY_IMPORT_PARSER_DUPLICATE_REPLACE',2);
define( 'CRM_HISTORY_IMPORT_PARSER_DUPLICATE_UPDATE',4);
define( 'CRM_HISTORY_IMPORT_PARSER_DUPLICATE_FILL',8);
define( 'CRM_HISTORY_IMPORT_PARSER_DUPLICATE_NOCHECK',16);

require_once 'CRM/Utils/String.php';
require_once 'CRM/Utils/Type.php';

require_once 'CRM/History/Import/Field.php';

 class CRM_History_Import_Parser {

    
               
             
                     
                   
                     
                  
                     
                
            

    /**
     * various parser modes
     */
    
          
           
           
            

    /**
     * codes for duplicate record handling
     */
    
          
          
          
          
          

    var $_fileName;

    /**#@+
     * @access protected
     * @var integer
     */

    /**
     * imported file size
     */
    var $_fileSize;

    /**
     * seperator being used
     */
    var $_seperator;

    /**
     * total number of lines in file
     */
    var $_lineCount;

    /**
     * total number of non empty lines
     */
    var $_totalCount;

    /**
     * running total number of valid lines
     */
    var $_validCount;

    /**
     * running total number of invalid rows
     */
    var $_invalidRowCount;

    /**
     * maximum number of invalid rows to store
     */
    var $_maxErrorCount;

    /**
     * array of error lines, bounded by MAX_ERROR
     */
    var $_errors;

    /**
     * total number of conflict lines
     */
    var $_conflictCount;

    /**
     * array of conflict lines
     */
    var $_conflicts;

    /**
     * total number of duplicate (from database) lines
     */
    var $_duplicateCount;

    /**
     * array of duplicate lines
     */
    var $_duplicates;

    /**
     * running total number of warnings
     */
    var $_warningCount;

    /**
     * maximum number of warnings to store
     */
    var $_maxWarningCount = CRM_HISTORY_IMPORT_PARSER_MAX_WARNINGS;

    /**
     * array of warning lines, bounded by MAX_WARNING
     */
    var $_warnings;

    /**
     * array of all the fields that could potentially be part
     * of this import process
     * @var array
     */
    var $_fields;

    /**
     * array of the fields that are actually part of the import process
     * the position in the array also dictates their position in the import
     * file
     * @var array
     */
    var $_activeFields;

    /**
     * cache the count of active fields
     *
     * @var int
     */
    var $_activeFieldCount;

    /**
     * maximum number of non-empty/comment lines to process
     *
     * @var int
     */
    var $_maxLinesToProcess;

    /**
     * cache of preview rows
     *
     * @var array
     */
    var $_rows;


    /**
     * filename of error data
     *
     * @var string
     */
    var $_errorFileName;


    /**
     * filename of conflict data
     *
     * @var string
     */
    var $_conflictFileName;


    /**
     * filename of duplicate data
     *
     * @var string
     */
    var $_duplicateFileName;

    /**
     * whether the file has a column header or not
     *
     * @var boolean
     */
    var $_haveColumnHeader;

 

    function CRM_History_Import_Parser() {
        $this->_maxLinesToProcess = 0;
        $this->_maxErrorCount = CRM_HISTORY_IMPORT_PARSER_MAX_ERRORS;
    }

    // abstract function init();

    function run( $fileName,
                  $seperator = ',',
                  &$mapper,
                  $skipColumnHeader = false,
                  $mode = CRM_HISTORY_IMPORT_PARSER_MODE_PREVIEW,
                  $onDuplicate = CRM_HISTORY_IMPORT_PARSER_DUPLICATE_SKIP) {

        $this->init();

        $this->_haveColumnHeader = $skipColumnHeader;
      
        $this->_seperator = $seperator;

        $fd = fopen( $fileName, "r" );
        if ( ! $fd ) {
            return false;
        }

        $this->_lineCount  = $this->_warningCount   = 0;
        $this->_invalidRowCount = $this->_validCount     = 0;
        $this->_totalCount = $this->_conflictCount = 0;
    
        $this->_errors   = array();
        $this->_warnings = array();
        $this->_conflicts = array();

        $this->_fileSize = number_format( filesize( $fileName ) / 1024.0, 2 );
        
        if ( $mode == CRM_HISTORY_IMPORT_PARSER_MODE_MAPFIELD) {
            $this->_rows = array( );
        } else {
            $this->_activeFieldCount = count( $this->_activeFields );
        }

        while ( ! feof( $fd ) ) {
            $this->_lineCount++;

            $values = fgetcsv( $fd, 8192, $seperator );
            if ( ! $values ) {
                continue;
            }

            CRM_History_Import_Parser::encloseScrub($values);

            // skip column header if we're not in mapfield mode
            if ( $mode != CRM_HISTORY_IMPORT_PARSER_MODE_MAPFIELD&& $skipColumnHeader ) {
                    $skipColumnHeader = false;
                    continue;
            }

            /* trim whitespace around the values */
            $empty = true;
            foreach ($values as $k => $v) {
                $values[$k] = trim($v, " .\t\r\n");
            }

            if ( CRM_Utils_System::isNull( $values ) ) {
                continue;
            }

            $this->_totalCount++;
            
            if ( $mode == CRM_HISTORY_IMPORT_PARSER_MODE_MAPFIELD) {
                $returnCode = $this->mapField( $values );
            } else if ( $mode == CRM_HISTORY_IMPORT_PARSER_MODE_PREVIEW) {
                $returnCode = $this->preview( $values );
            } else if ( $mode == CRM_HISTORY_IMPORT_PARSER_MODE_SUMMARY) {
                $returnCode = $this->summary( $values );
            } else if ( $mode == CRM_HISTORY_IMPORT_PARSER_MODE_IMPORT) {
                $returnCode = $this->import( $onDuplicate, $values );
            } else {
                $returnCode = CRM_HISTORY_IMPORT_PARSER_ERROR;
            }

            // note that a line could be valid but still produce a warning
            if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_VALID) {
                $this->_validCount++;
                if ( $mode == CRM_HISTORY_IMPORT_PARSER_MODE_MAPFIELD) {
                    $this->_rows[]           = $values;
                    $this->_activeFieldCount = max( $this->_activeFieldCount, count( $values ) );
                }
            }

            if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_WARNING) {
                $this->_warningCount++;
                if ( $this->_warningCount < $this->_maxWarningCount ) {
                    $this->_warningCount[] = $line;
                }
            } 

            if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_ERROR) {
                $this->_invalidRowCount++;
                if ( $this->_invalidRowCount < $this->_maxErrorCount ) {
                    $recordNumber = $this->_lineCount;
                    if ($this->_haveColumnHeader) $recordNumber--;
                    array_unshift($values, $recordNumber);
                    $this->_errors[] = $values;
                }
            } 

            if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_CONFLICT) {
                $this->_conflictCount++;
                $recordNumber = $this->_lineCount;
                if ($this->_haveColumnHeader) $recordNumber--;
                array_unshift($values, $recordNumber);
                $this->_conflicts[] = $values;
            } 
            
            if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_DUPLICATE) {
                if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_MULTIPLE_DUPE) {
                    /* TODO: multi-dupes should be counted apart from singles
                     * on non-skip action */
                }
                $this->_duplicateCount++;
                $recordNumber = $this->_lineCount;
                if ($this->_haveColumnHeader) $recordNumber--;
                array_unshift($values, $recordNumber);
                $this->_duplicates[] = $values;
                if ($onDuplicate != CRM_HISTORY_IMPORT_PARSER_DUPLICATE_SKIP) {
                    $this->_validCount++;
                }
            }

            // we give the derived class a way of aborting the process
            // note that the return code could be multiple code or'ed together
            if ( $returnCode & CRM_HISTORY_IMPORT_PARSER_STOP) {
                break;
            }

            // if we are done processing the maxNumber of lines, break
            if ( $this->_maxLinesToProcess > 0 && $this->_validCount >= $this->_maxLinesToProcess ) {
                break;
            }
        }

        fclose( $fd );

        
        if ($mode == CRM_HISTORY_IMPORT_PARSER_MODE_PREVIEW|| $mode == CRM_HISTORY_IMPORT_PARSER_MODE_IMPORT) {
            $customHeaders = $mapper;
            
            $customfields =& CRM_Core_BAO_CustomField::getFields('Activity');
            foreach ($customHeaders as $key => $value) {
                if ($id = CRM_Core_BAO_CustomField::getKeyID($value)) {
                    $customHeaders[$key] = $customfields[$id][0];
                }
            }
            if ($this->_invalidRowCount) {
                // removed view url for invlaid contacts
                $headers = array_merge( array(  ts('Record Number'),
                                                ts('Reason')), 
                                        $customHeaders);
                $this->_errorFileName = $fileName . '.errors';
                CRM_History_Import_Parser::exportCSV($this->_errorFileName, $headers, $this->_errors);
            }
            if ($this->_conflictCount) {
                $headers = array_merge( array(  ts('Record Number'),
                                                ts('Reason')), 
                                        $customHeaders);
                $this->_conflictFileName = $fileName . '.conflicts';
                CRM_History_Import_Parser::exportCSV($this->_conflictFileName, $headers, $this->_conflicts);
            }
            if ($this->_duplicateCount) {
                $headers = array_merge( array(  ts('Record Number'), 
                                                ts('View Activity History URL')),
                                        $customHeaders);

                $this->_duplicateFileName = $fileName . '.duplicates';
                CRM_History_Import_Parser::exportCSV($this->_duplicateFileName, $headers, $this->_duplicates);
            }
        }
        //echo "$this->_totalCount,$this->_invalidRowCount,$this->_conflictCount,$this->_duplicateCount";
        return $this->fini();
    }

    // abstract function mapField( &$values );
    // abstract function preview( &$values );
    // abstract function summary( &$values );
    // abstract function import ( $onDuplicate, &$values );

    // abstract function fini();

    /**
     * Given a list of the importable field keys that the user has selected
     * set the active fields array to this list
     *
     * @param array mapped array of values
     *
     * @return void
     * @access public
     */
    function setActiveFields( $fieldKeys ) {
        $this->_activeFieldCount = count( $fieldKeys );
        foreach ( $fieldKeys as $key ) {
            if ( empty( $this->_fields[$key] ) ) {
                $this->_activeFields[] =& new CRM_History_Import_Field( '', ts( '- do not import -' ) );
            } else {
                $this->_activeFields[] = clone( $this->_fields[$key] );
            }
        }
    }
    
    /*function setActiveFieldLocationTypes( $elements ) {
        for ($i = 0; $i < count( $elements ); $i++) {
            $this->_activeFields[$i]->_hasLocationType = $elements[$i];
        }
    }
    
    function setActiveFieldPhoneTypes( $elements ) {
        for ($i = 0; $i < count( $elements ); $i++) {
            $this->_activeFields[$i]->_phoneType = $elements[$i];
        }
    }*/
    

    //function setActiveFieldValues( $elements, &$erroneousField = null ) {// fixed for php4 compatibility Issue
    function setActiveFieldValues( $elements, &$erroneousField ) {    
        $maxCount = count( $elements ) < $this->_activeFieldCount ? count( $elements ) : $this->_activeFieldCount;
        for ( $i = 0; $i < $maxCount; $i++ ) {
            $this->_activeFields[$i]->setValue( $elements[$i] );
        }

        // reset all the values that we did not have an equivalent import element
        for ( ; $i < $this->_activeFieldCount; $i++ ) {
            $this->_activeFields[$i]->resetValue();
        }

        // now validate the fields and return false if error
        $valid = CRM_HISTORY_IMPORT_PARSER_VALID;
        for ( $i = 0; $i < $this->_activeFieldCount; $i++ ) {
            if ( ! $this->_activeFields[$i]->validate() ) {
                // no need to do any more validation
                $erroneousField = $i;
                $valid = CRM_HISTORY_IMPORT_PARSER_ERROR;
                break;
            }
        }
        return $valid;
    }

    /**
     * function to format the field values for input to the api
     *
     * @return array (reference ) associative array of name/value pairs
     * @access public
     */
    function &getActiveFieldParams( ) {
        $params = array( );
        for ( $i = 0; $i < $this->_activeFieldCount; $i++ ) {
            if ( isset( $this->_activeFields[$i]->_value ) ) {
                if (isset( $this->_activeFields[$i]->_hasLocationType)) {
                    if (! isset($params[$this->_activeFields[$i]->_name])) {
                        $params[$this->_activeFields[$i]->_name] = array();
                    }
                    
                    $value = array(
                        $this->_activeFields[$i]->_name => 
                                $this->_activeFields[$i]->_value,
                        'location_type_id' => 
                                $this->_activeFields[$i]->_hasLocationType);
                    
                    if (isset( $this->_activeFields[$i]->_phoneType)) {
                        $value['phone_type'] =
                            $this->_activeFields[$i]->_phoneType;
                    }
                    
                    $params[$this->_activeFields[$i]->_name][] = $value;
                }
                if (!isset($params[$this->_activeFields[$i]->_name])) {
                    if ( !isset($this->_activeFields[$i]->_related) ) {
                        $params[$this->_activeFields[$i]->_name] = $this->_activeFields[$i]->_value;
                    }
                }
            }
        }
        return $params;
    }

    function getSelectValues() {
        $values = array();
        foreach ($this->_fields as $name => $field ) {
            $values[$name] = $field->_title;
        }
        return $values;
    }

    function getSelectTypes() {
        $values = array();
        foreach ($this->_fields as $name => $field ) {
            $values[$name] = $field->_hasLocationType;
        }
        return $values;
    }

    function getHeaderPatterns() {
        $values = array();
        foreach ($this->_fields as $name => $field ) {
            $values[$name] = $field->_headerPattern;
        }
        return $values;
    }

    function getDataPatterns() {
        $values = array();
        foreach ($this->_fields as $name => $field ) {
            $values[$name] = $field->_dataPattern;
        }
        return $values;
    }

    function addField( $name, $title, $type = CRM_UTILS_TYPE_T_INT, $headerPattern = '//', $dataPattern = '//') {
        if ( empty( $name ) ) {
            $this->_fields['doNotImport'] =& new CRM_History_Import_Field($name, $title, $type, $headerPattern, $dataPattern);
        } else {
            
            $tempField = CRM_Contact_BAO_Contact::importableFields('Individual', null );
            if (! array_key_exists ($name,$tempField) ) {
                $this->_fields[$name] =& new CRM_History_Import_Field($name, $title, $type, $headerPattern, $dataPattern);
            } else {
                require_once 'CRM/Import/Field.php';
                $this->_fields[$name] =& new CRM_Import_Field($name, $title, $type, $headerPattern, $dataPattern,$tempField[$name]['hasLocationType']);
            }
                
        }
    }

    /**
     * setter function
     *
     * @param int $max 
     *
     * @return void
     * @access public
     */
    function setMaxLinesToProcess( $max ) {
        $this->_maxLinesToProcess = $max;
    }

    /**
     * Store parser values
     *
     * @param CRM_Core_Session $store 
     *
     * @return void
     * @access public
     */
    function set( $store, $mode = CRM_HISTORY_IMPORT_PARSER_MODE_SUMMARY) {
        $store->set( 'fileSize'   , $this->_fileSize          );
        $store->set( 'lineCount'  , $this->_lineCount         );
        $store->set( 'seperator'  , $this->_seperator         );
        $store->set( 'fields'     , $this->getSelectValues( ) );
        $store->set( 'fieldTypes' , $this->getSelectTypes( )  );
        
        $store->set( 'headerPatterns', $this->getHeaderPatterns( ) );
        $store->set( 'dataPatterns', $this->getDataPatterns( ) );
        $store->set( 'columnCount', $this->_activeFieldCount  );
        
        $store->set( 'totalRowCount'    , $this->_totalCount     );
        $store->set( 'validRowCount'    , $this->_validCount     );
        $store->set( 'invalidRowCount'  , $this->_invalidRowCount     );
        $store->set( 'conflictRowCount', $this->_conflictCount );
        
        if ($this->_invalidRowCount) {
            $store->set( 'errorsFileName', $this->_errorFileName );
        }
        if ($this->_conflictCount) {
            $store->set( 'conflictsFileName', $this->_conflictFileName );
        }
        if ( isset( $this->_rows ) && ! empty( $this->_rows ) ) {
            $store->set( 'dataValues', $this->_rows );
        }

        if ($mode == CRM_HISTORY_IMPORT_PARSER_MODE_IMPORT) {
            $store->set( 'duplicateRowCount', $this->_duplicateCount );
            if ($this->_duplicateCount) {
                $store->set( 'duplicatesFileName', $this->_duplicateFileName );
            }
        }
        //echo "$this->_totalCount,$this->_invalidRowCount,$this->_conflictCount,$this->_duplicateCount";
    }

    /**
     * Export data to a CSV file
     *
     * @param string $filename
     * @param array $header
     * @param data $data
     * @return void
     * @access public
     */
     function exportCSV($fileName, $header, $data) {
        $output = array();
        $fd = fopen($fileName, 'w');

        foreach ($header as $key => $value) {
            $header[$key] = "\"$value\"";
        }
        $output[] = implode(',', $header);

        foreach ($data as $datum) {
            foreach ($datum as $key => $value) {
                $datum[$key] = "\"$value\"";
            }
            $output[] = implode(',', $datum);
        }
        fwrite($fd, implode("\n", $output));
        fclose($fd);
    }

    /** 
     * Remove single-quote enclosures from a value array (row)
     *
     * @param array $values
     * @param string $enclosure
     * @return void
     * @static
     * @access public
     */
     function encloseScrub(&$values, $enclosure = "'") {
        if (empty($values)) 
            return;

        foreach ($values as $k => $v) {
            $values[$k] = preg_replace("/^$enclosure(.*)$enclosure$/", '$1', $v);
        }
    }

}

?>

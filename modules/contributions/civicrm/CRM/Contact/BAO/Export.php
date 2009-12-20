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

/**
 * This class is for exporting contact
 *
 */

class CRM_Contact_BAO_Export {
    
    /**
     * Function to get the list the export fields
     *
     * @param int $exportContact type of export
     *
     * @access public
     */
    function exportContacts( $selectAll, $ids, $formValues, $order = null, $fields = null ) {

        $headerRows  = array();
        $returnProperties = array();
        $primary = false;
 
        if ($fields) {
            $location = array();
            $locationType = array("Work"=>array(),"Home"=>array(),"Main"=>array(),"Other"=>array());
            $returnFields = $fields;

            foreach($returnFields as $key => $field) {
                $flag = true ;
                $phone_type = "";
                $phoneFlag = false;
                if( $field[3] && $field[1] == 'phone' ) {
                   
                    if($field[3] == 'Phone') {
                        $phone_type = $field[1]."-"."Phone";
                    } else if($field[3] == 'Mobile') {
                        $phone_type = $field[1]."-"."Mobile";
                    } else if($field[3] == 'Fax') {
                        $phone_type = $field[1]."-"."Fax";
                    } else if($field[3] == 'Pager') {
                        $phone_type = $field[1]."-"."Pager";
                    }
                    
                    $phoneFlag = true ;
                }
                if( $field[2] ) {
                    if ($field[2] == 1) {
                        if ($phoneFlag) {
                            $locationType["Home"][$phone_type] = 1;
                        } else {
                            $locationType["Home"][$field[1]] = 1;  
                        }
                    }else if ($field[2] == 2) {
                        if ($phoneFlag) {
                            $locationType["Work"][$phone_type] = 1;
                        } else {
                            $locationType["Work"][$field[1]] = 1;
                        }
                    }else if ($field[2] == 3) {
                        if ($phoneFlag) {
                            $locationType["Main"][$phone_type] = 1;
                        } else {
                            $locationType["Main"][$field[1]] = 1;
                        }
                    }else if ($field[2] == 4) {
                        if ($phoneFlag) {
                            $locationType["Other"][$phone_type] = 1;
                        } else {
                            $locationType["Other"][$field[1]] = 1;
                        }
                    }
                    $flag = false;   
                } 
                
                if ($flag) {
                    $returnProperties[$field[1]] = 1; 
                }
            }
            $returnProperties['location'] = $locationType;
        } else {
            $primary = true;
            $fields = CRM_Contact_BAO_Contact::exportableFields( 'All', true, true );
            
            foreach ($fields as $key => $var) { 
                if ($key) {
                    $returnProperties[$key] = 1;
                }
            }
        }
        
        if ($primary) {
            $returnProperties['location_type'] = 1;
            $returnProperties['im_provider'  ] = 1;
            $returnProperties['phone_type'   ] = 1;
        }

        $session =& new CRM_Core_Session();
        if ( $selectAll ) {
            if ($primary) {
                $query =& new CRM_Contact_BAO_Query( $formValues, $returnProperties, $fields );
            } else {
                $query =& new CRM_Contact_BAO_Query( $formValues, $returnProperties );
            }
        } else {
            $params = array( );
            foreach ($ids as $id) { 
                $params[CRM_CORE_FORM_CB_PREFIX . $id] = 1;
            }
            if ($primary) {
                $query =& new CRM_Contact_BAO_Query( $params, $returnProperties, $fields, true );         
            } else {
                $query =& new CRM_Contact_BAO_Query( $params, $returnProperties, null, true );         
            }
        }

        list( $select, $from, $where ) = $query->query( );
        $queryString = "$select $from $where";
        if ( $order ) {
            list( $field, $dir ) = explode( ' ', $order, 2 );
            $field = trim( $field );
            if ( CRM_Utils_Array::value( $field, $returnProperties ) ) {
                $queryString .= " ORDER BY $order";
            }
        }
        
        if ( CRM_Utils_Array::value( 'tags', $returnProperties ) || CRM_Utils_Array::value( 'groups', $returnProperties ) ) { 
            $queryString .= " GROUP BY civicrm_contact.id";
        }
        
        $dao =& CRM_Core_DAO::executeQuery($queryString);
        $header = false;

        $contactDetails = array( );

        while ($dao->fetch()) {
            $row = array( );
            $validRow = false;
            foreach ($dao as $key => $varValue) {
                $flag = false;
                foreach($returnProperties as $propKey=>$props) {
                    if (is_array($props)) {
                        foreach($props as $propKey1=>$prop) {
                            foreach($prop as $propkey2=>$prop1) {
                                if($propKey1."-".$propkey2 == $key) {
                                    $flag = true;
                                }
                            }
                        }
                    }
                } 

                if (array_key_exists($key, $returnProperties)) {
                    $flag = true;
                }
                if ($flag) {
                    if ( isset( $varValue ) && $varValue != '' ) {
                        if ( $cfID = CRM_Core_BAO_CustomField::getKeyID($key) ) {
                            $row[$key] = CRM_Core_BAO_CustomField::getDisplayValue( $varValue, $cfID, $query->_options );
                        } else {
                            $row[$key] = $varValue;
                        }
                        $validRow  = true;
                    } else {
                        $row[$key] = '';
                    }
                   
                    if ( ! $header ) {
                        if (isset($query->_fields[$key]['title'])) {
                            $headerRows[] = $query->_fields[$key]['title'];
                        } else if ($key == 'phone_type'){
                            $headerRows[] = 'Phone Type';
                        } else {
                            $keyArray = explode('-', $key);
                            $hdr      = $keyArray[0] . "-" . $query->_fields[$keyArray[1]]['title'];
                            if ( CRM_Utils_Array::value( 2, $keyArray ) ) {
                                $hdr .= " " . $keyArray[2];
                            }
                            $headerRows[] = $hdr;
                        }
                    }
                }
            }
            if ( $validRow ) {
                $contactDetails[$dao->contact_id] = $row;
            }
            $header = true;
        }
        
        require_once 'CRM/Core/Report/Excel.php';
        CRM_Core_Report_Excel::writeCSVFile( CRM_Contact_BAO_Export::getExportFileName( ), $headerRows, $contactDetails );
                
        exit();
    }
        
    /**
     * name of export file.
     *
     * @param string $output type of output
     * @return string name of the file
     */
    function getExportFileName( $output = 'csv') {
        return ts('CiviCRM Contact Search');
    }
}

?>

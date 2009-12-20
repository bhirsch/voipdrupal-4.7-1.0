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

define( 'CRM_UTILS_TYPE_T_INT',1);
define( 'CRM_UTILS_TYPE_T_STRING',2);
define( 'CRM_UTILS_TYPE_T_ENUM',2);
define( 'CRM_UTILS_TYPE_T_DATE',4);
define( 'CRM_UTILS_TYPE_T_TIME',8);
define( 'CRM_UTILS_TYPE_T_BOOL',16);
define( 'CRM_UTILS_TYPE_T_BOOLEAN',16);
define( 'CRM_UTILS_TYPE_T_TEXT',32);
define( 'CRM_UTILS_TYPE_T_BLOB',64);
define( 'CRM_UTILS_TYPE_T_TIMESTAMP',256);
define( 'CRM_UTILS_TYPE_T_FLOAT',512);
define( 'CRM_UTILS_TYPE_T_MONEY',1024);
define( 'CRM_UTILS_TYPE_T_EMAIL',2048);
define( 'CRM_UTILS_TYPE_T_URL',4096);
define( 'CRM_UTILS_TYPE_T_CCNUM',8192);
define( 'CRM_UTILS_TYPE_TWO',2);
define( 'CRM_UTILS_TYPE_FOUR',4);
define( 'CRM_UTILS_TYPE_EIGHT',8);
define( 'CRM_UTILS_TYPE_TWELVE',12);
define( 'CRM_UTILS_TYPE_SIXTEEN',16);
define( 'CRM_UTILS_TYPE_TWENTY',20);
define( 'CRM_UTILS_TYPE_MEDIUM',20);
define( 'CRM_UTILS_TYPE_THIRTY',30);
define( 'CRM_UTILS_TYPE_BIG',30);
define( 'CRM_UTILS_TYPE_FORTYFIVE',45);
define( 'CRM_UTILS_TYPE_HUGE',45);

class CRM_Utils_Type {
    
                    
                 
                   
                   
                   
                  
               
                  
                  
            
                
               
               
                 
               

    
                    
                   
                  
                
               
                
                
                
                   
             
                  

   

/**
 * Convert Constant Data type to String
 *
 * @param  $const_datatype       integer datatype
 * 
 * @return $string_datatype     String datatype respective to integer datatype
 *
 * @access public
 */


    function typeToString($const_datatype)
    {
        switch($const_datatype) {
        case 1:$string_datatype ='Int';break;
        case 2:$string_datatype ='String';break;
        case 3:$string_datatype ='Enum';break;
        case 4:$string_datatype ='Date';break; 
        case 8:$string_datatype ='Time';break;
        case 16:$string_datatype ='Boolean';break;    
        case 32:$string_datatype ='Text';break;
        case 64:$string_datatype ='Blob';break;    
        case 256:$string_datatype ='Timestamp';break;
        case 512:$string_datatype ='Float';break;
        case 1024:$string_datatype ='Money';break;
        case 2048:$string_datatype ='Date';break;
        case 4096:$string_datatype ='Email';break;
        }
        
        return $string_datatype;

    }


    /**
     * Verify that a variable is of a given type
     * 
     * @param mixed $data           The variable
     * @param string $type          The type
     * @return mixed                The data, escaped if necessary
     * @access public
     * @static
     */
      function escape($data, $type) {
        require_once 'CRM/Utils/Rule.php';
        switch($type) {
        case 'Integer':
        case 'Int':
            if (CRM_Utils_Rule::integer($data)) {
                return $data;
            }
            break;
            
        case 'Float':
        case 'Money':
            if (CRM_Utils_Rule::numeric($data)) {
                return $data;
            }
            break;
            
        case 'String':
            return addslashes($data);
            break;
            
        case 'Date':
            if (preg_match('/^\d{8}$/', $data)) {
                return $data;
            }
            break;
            
        case 'Timestamp':
            if (preg_match('/^\d{14}$/', $data)) {
                return $data;
            }
            break;
        }

    }
}

?>

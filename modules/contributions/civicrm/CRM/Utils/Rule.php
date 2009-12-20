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


$GLOBALS['_CRM_UTILS_RULE']['qfRule'] =  null;
$GLOBALS['_CRM_UTILS_RULE']['currencyCodes'] =  null;

require_once 'HTML/QuickForm/Rule/Email.php';

class CRM_Utils_Rule {

     function title( $str ) {
    
        // check length etc
        if ( empty( $str ) || strlen( $str ) < 3 || strlen( $str ) > 127 ) {
            return false;
        }
    
        // Make sure it include valid characters, alpha numeric and underscores
        if ( ! preg_match('/^[a-z][\w\s\'\&\,\$\#\-\.\"\?]+$/i', $str ) ) {
            return false;
        }

        return true;
    }

     function variable( $str ) {
        // check length etc
        if ( empty( $str ) || strlen( $str ) > 31 ) {
            return false;
        }
        
        // make sure it include valid characters, alpha numeric and underscores
        if ( ! preg_match('/^[\w\s]+$/i', $str ) ) {
            return false;
        }

        return true;
    }

     function qfVariable( $str ) {
        // check length etc 
        //if ( empty( $str ) || strlen( $str ) > 31 ) {  
        if (  strlen(trim($str)) == 0 || strlen( $str ) > 31 ) {  
            return false; 
        } 
        
        // make sure it include valid characters, alpha numeric and underscores 
        if ( ! preg_match('/^[\w\s]+$/i', $str ) ) { 
            return false; 
        } 
 
        return true; 
    } 

     function phone( $phone ) {
        // check length etc
        if ( empty( $phone ) || strlen( $phone ) > 16 ) {
            return false;
        }
    
        // make sure it include valid characters, (, \s and numeric
        if ( preg_match('/^[\d\(\)\-\.\s]+$/', $phone ) ) {
            return true;
        }
        return false;
    }


     function query( $query ) {

        // check length etc
        if ( empty( $query ) || strlen( $query ) < 3 || strlen( $query ) > 127 ) {
            return false;
        }
    
        // make sure it include valid characters, alpha numeric and underscores
        if ( ! preg_match('/^[\w\s\%\'\&\,\$\#]+$/i', $query ) ) {
            return false;
        }

        return true;
    }

     function url( $url, $checkDomain = false) {
        $options = array( 'domain_check'    => $checkDomain,
                          'allowed_schemes' => array( 'http', 'https', 'mailto', 'ftp' ) );

        require_once 'Validate.php';
        return Validate::uri( $url, $options );
    }

     function domain( $domain ) {
        if ( ! preg_match('/^(([A-Za-z0-9\-])+\.)+[A-Za-z\-]+$/', $domain ) ) {
            return false;
        }
        return true;
    }

     function date($value, $default = null) {
        if (is_string($value) &&
            preg_match('/^\d\d\d\d-?\d\d-?\d\d$/', $value)) {
            return $value;
        }
        return $default;
    }

    /**
     * check the validity of the date (in qf format)
     * note that only a year is valid, or a mon-year is
     * also valid in addition to day-mon-year
     *
     * @param array $date
     *
     * @return bool true if valid date
     * @static
     * @access public
     */
     function qfDate($date) {
        if ( ! $date['d'] && ! $date['M'] && ! $date['Y'] ) {
            return true;
        }

        $day = $mon = 1;
        $year = 0;
        if ($date['d']) $day  = $date['d'];
        if ($date['M']) $mon  = $date['M'];
        if ($date['Y']) $year = $date['Y'];

        // if we have day we need mon, and if we have mon we need year
        if ( ( $date['d'] && ! $date['M'] ) ||
             ( $date['d'] && ! $date['Y'] ) ||
             ( $date['M'] && ! $date['Y'] ) ) {
            return false;
        }

        if ( ! empty( $day ) || ! empty( $mon ) || ! empty( $year ) ) {
            return checkdate( $mon, $day, $year );
        }
        return false;
    }

    /** 
     * check the validity of the date (in qf format) 
     * note that only a year is valid, or a mon-year is 
     * also valid in addition to day-mon-year. The date
     * specified has to be beyond today. (i.e today or later)
     * 
     * @param array $date 
     * 
     * @return bool true if valid date 
     * @static 
     * @access public 
     */
     function currentDate( $date ) {
        if ( ! $date['d'] && ! $date['M'] && ! $date['Y'] ) { 
            return true; 
        } 
 
        $day = $mon = 1; 
        $year = 0; 
        if ($date['d']) $day  = $date['d']; 
        if ($date['M']) $mon  = $date['M']; 
        if ($date['Y']) $year = $date['Y']; 
 
        // if we have day we need mon, and if we have mon we need year 
        if ( ( $date['d'] && ! $date['M'] ) || 
             ( $date['d'] && ! $date['Y'] ) || 
             ( $date['M'] && ! $date['Y'] ) ) { 
            return false; 
        } 

        $result = false;
        if ( ! empty( $day ) || ! empty( $mon ) || ! empty( $year ) ) { 
            $result = checkdate( $mon, $day, $year ); 
        }

        if ( ! $result ) {
            return false;
        }

        // now make sure this date is greater that today
        $currentDate = getdate( );
        if ( $year > $currentDate['year'] ) {
            return true;
        } else if ( $year < $currentDate['year'] ) {
            return false;
        }

        if ( $date['M'] ) {
            if ( $mon > $currentDate['mon'] ) {
                return true;
            } else if ( $mon < $currentDate['mon'] ) {
                return false;
            }
        }

        if ( $date['d'] ) {
            if ( $day > $currentDate['mday'] ) {
                return true;
            } else if ( $day < $currentDate['mday'] ) {
                return false;
            }
        }

        return true;
    }

     function integer($value) {
        if ( is_int($value)) {
            return true;
        }
        
        if (($value < 0)) {
            $negValue = -1 * $value;
            if(is_int($negValue)) {
                return true;
            }
        }

        if (is_numeric($value) && preg_match('/^\d+$/', $value)) {
            return true;
        }

        return false;
    }

     function positiveInteger($value) {
        if ( is_int($value)) {
            return true;
        }
        
        if (($value < 0)) {
            return false;
        }
        if (is_numeric($value) && preg_match('/^\d+$/', $value)) {
            return true;
        }
        
        return false;
    }
    
     function numeric($value) {
        return preg_match( '/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/', $value ) ? true : false;
    }

     function money($value) {
        if ( CRM_Utils_Rule::integer( $value ) ) {
            return true;
        }
        return preg_match( '/(^\d+\.\d?\d?$)|(^\.\d\d?$)/', $value ) ? true : false;
    }

     function string($value, $maxLength = 0) {
        if (is_string($value) &&
            ($maxLength === 0 || strlen($value) <= $maxLength)) {
            return true;
        }
        return false;
    }

     function boolean($value) {
        return preg_match( 
            '/(^(1|0)$)|(^(Y(es)?|N(o)?)$)|(^(T(rue)?|F(alse)?)$)/i', $value) ?
            true : false;
    }

     function email($value, $checkDomain = false) {
        
        if ( ! isset( $GLOBALS['_CRM_UTILS_RULE']['qfRule'] ) ) {
            $GLOBALS['_CRM_UTILS_RULE']['qfRule'] =& new HTML_QuickForm_Rule_Email();
        }
        return $GLOBALS['_CRM_UTILS_RULE']['qfRule']->validate( $value, $checkDomain );
    }

     function emailList( $list, $checkDomain = false ) {
        $emails = explode( ',', $list );
        foreach ( $emails as $email ) {
            $email = trim( $email );
            if ( ! CRM_Utils_Rule::email( $email, $checkDomain ) ) {
                return false;
            }
        }
        return true;
    }

    // allow between 4-6 digits as postal code since india needs 6 and US needs 5 (or 
    // if u disregard the first 0, 4 (thanx excel!)
    // piotr: we need to figure out how to localize such rules
     function postalCode($value) {
        if ( preg_match('/^\d{4,6}(-\d{4})?$/', $value) ) {
            return true;
        }
        return false;
    }

    /**
     * see how file rules are written in HTML/QuickForm/file.php
     * Checks to make sure the uploaded file is ascii
     *
     * @param     array     Uploaded file info (from $_FILES)
     * @access    private
     * @return    bool      true if file has been uploaded, false otherwise
     */
     function asciiFile( $elementValue ) {
        if ((isset($elementValue['error']) && $elementValue['error'] == 0) ||
            (!empty($elementValue['tmp_name']) && $elementValue['tmp_name'] != 'none')) {
            return CRM_Utils_File::isAscii($elementValue['tmp_name']);
        }
        return false;
    }

    /**
     * see how file rules are written in HTML/QuickForm/file.php
     * Checks to make sure the uploaded file is html
     *
     * @param     array     Uploaded file info (from $_FILES)
     * @access    private
     * @return    bool      true if file has been uploaded, false otherwise
     */
     function htmlFile( $elementValue ) {
        if ((isset($elementValue['error']) && $elementValue['error'] == 0) ||
            (!empty($elementValue['tmp_name']) && $elementValue['tmp_name'] != 'none')) {
            return CRM_Utils_File::isHtmlFile($elementValue['tmp_name']);
        }
        return false;
    }

    /**
     * Check if there is a record with the same name in the db
     *
     * @param string $value     the value of the field we are checking
     * @param array  $options   the daoName and fieldName (optional )
     *
     * @return boolean     true if object exists
     * @access public
     * @static
     */
     function objectExists( $value, $options ) {
        return CRM_Core_DAO::objectExists( $value, $options[0], $options[1], CRM_Utils_Array::value( 2, $options, 'name' ) );
    }

     function creditCardNumber( $value, $type ) {
        require_once 'Validate/Finance/CreditCard.php';

        return Validate_Finance_CreditCard::number( $value, $type );
    }

     function cvv( $value, $type ) {
        require_once 'Validate/Finance/CreditCard.php';

        return Validate_Finance_CreditCard::cvv( $value, $type );
    }

     function currencyCode($value) {
        
        if (!$GLOBALS['_CRM_UTILS_RULE']['currencyCodes']) {
            $GLOBALS['_CRM_UTILS_RULE']['currencyCodes'] =& CRM_Core_PseudoConstant::currencyCode();
        }
        if (in_array($value, $GLOBALS['_CRM_UTILS_RULE']['currencyCodes'])) {
            return true;
        }
        return false;
    }

}

?>

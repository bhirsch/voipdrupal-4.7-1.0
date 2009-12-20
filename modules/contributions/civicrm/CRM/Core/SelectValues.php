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
 * One place to store frequently used values in Select Elements. Note that
 * some of the below elements will be dynamic, so we'll probably have a 
 * smart caching scheme on a per domain basis
 * 
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_CORE_SELECTVALUES']['greeting'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['phoneType'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['county'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['pcm'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['pmf'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['privacy'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['contactType'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['customDataType'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['customHtmlType'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupExtends'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupStyle'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['ufGroupType'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['groupContactStatus'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['groupType'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['_date'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['config'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['_visibility'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['activityStatus'] =  null;
$GLOBALS['_CRM_CORE_SELECTVALUES']['components'] =  null;

class CRM_Core_SelectValues {

    /**
     * greetings
     * @static
     */
     function &greeting()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['greeting']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['greeting'] = array(
                'Formal'    => ts('default - Dear [first] [last]'),
                'Informal'  => ts('Dear [first]'),
                'Honorific' => ts('Dear [prefix] [last]'),
                'Custom'    => ts('Customized')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['greeting'];
    }
    
    /**
     * different types of phones
     * @static
     */
     function &phoneType()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['phoneType']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['phoneType'] = array(
                ''       => ts('- select -'),
                'Phone'  => ts('Phone'),
                'Mobile' => ts('Mobile'),
                'Fax'    => ts('Fax'),
                'Pager'  => ts('Pager')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['phoneType'];
    }

    /**
     * list of counties
     * FIXME a bit short at the moment
     * @static
     */
     function &county()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['county']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['county'] = array(
                ''   => ts('-select-'),
                1001 => ts('San Francisco')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['county'];
    }
    
    /**
     * preferred communication method
     * @static
     */
     function &pcm()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['pcm']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['pcm'] = array(
                ''      => ts('- no preference -'),
                'Phone' => ts('Phone'),
                'Email' => ts('Email'), 
                'Post'  => ts('Postal Mail')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['pcm'];
    }
    
    /**
     * preferred mail format
     * @static
     */
     function &pmf()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['pmf']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['pmf'] = array(
                'Text' => ts('Text'),
                'HTML' => ts('HTML'), 
                'Both' => ts('Both')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['pmf'];
    }
    
    /**
     * privacy options
     * @static
     */
     function &privacy()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['privacy']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['privacy'] = array(
                'do_not_phone' => ts('Do not phone'),
                'do_not_email' => ts('Do not email'),
                'do_not_mail'  => ts('Do not mail'),
                'do_not_trade' => ts('Do not trade')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['privacy'];
    }

    /**
     * various pre defined contact super types
     * @static
     */
     function &contactType()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['contactType']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['contactType'] = array(
                ''             => ts('- all contacts -'),
                'Individual'   => ts('Individuals'),
                'Household'    => ts('Households'),
                'Organization' => ts('Organizations')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['contactType'];
    }

    /**
     * Extended property (custom field) data types
     * @static
     */
     function &customDataType()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['customDataType']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['customDataType'] = array(
                ''        => ts('-select-'),
                'String'  => ts('Text'),
                'Int'     => ts('Integer'),
                'Float'   => ts('Decimal Number'),
                'Money'   => ts('Money'),
                'Text'    => ts('Memo'),
                'Date'    => ts('Date'),
                'Boolean' => ts('Yes/No')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['customDataType'];
    }
    
    /**
     * Custom form field types
     * @static
     */
     function &customHtmlType()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['customHtmlType']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['customHtmlType'] = array(
                ''                        => ts('-select-'),
                'Text'                    => ts('Single-line input field (text or numeric)'),
                'TextArea'                => ts('Multi-line text box (textarea)'),
                'Select'                  => ts('Drop-down (select list)'),
                'Radio'                   => ts('Radio buttons'),
                'Checkbox'                => ts('Checkbox(es)'),
                'Select Date'             => ts('Date selector'),
                'Select State / Province' => ts('State / Province selector'),
                'Select Country'          => ts('Country selector')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['customHtmlType'];
    }
    
    /**
     * various pre defined extensions for dynamic properties and groups
     *
     * @static
     */
     function &customGroupExtends()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupExtends']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupExtends'] = array(
                'Contact'      => ts('- All Contacts -'),
                'Individual'   => ts('Individuals'),
                'Household'    => ts('Households'),
                'Organization' => ts('Organizations'),
                'Activity'     => ts('Activities'),
                'Phonecall'    => ts('Phonecalls'),
                'Meeting'      => ts('Meetings'),
                'Group'        => ts('Groups'),
                'Contribution' => ts('Contributions'),
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupExtends'];
    }

    /**
     * styles for displaying the custom data group
     *
     * @static
     */
     function &customGroupStyle()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupStyle']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupStyle'] = array(
                'Tab'    => ts('Tab'),
                'Inline' => ts('Inline')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['customGroupStyle'];
    }

    /**
     * for displaying the uf group types
     *
     * @static
     */
     function &ufGroupTypes()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['ufGroupType']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['ufGroupType'] = array(
                'User Registration' => ts('User Registration'),
                'User Account'      => ts('View/Edit User Account'),
                'Profile'           => ts('Profile'),
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['ufGroupType'];
    }


    /**
     * the status of a contact within a group
     *
     * @static
     */
     function &groupContactStatus()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['groupContactStatus']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['groupContactStatus'] = array(
                'Added'     => ts('Added'),
                'Removed'   => ts('Removed'),
                'Pending'   => ts('Pending')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['groupContactStatus'];
    }

    /**
     * list of Group Types
     * @static
     */
     function &groupType()
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['groupType']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['groupType'] = array(
                'query'  => ts('Dynamic'),
                'static' => ts('Static')
            );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['groupType'];
    }
  
    
    /**
     * compose the parameters for a date select object
     *
     * @param  $type the type of date
     *
     * @return array         the date array
     * @static
     */
     function &date($type = 'birth', $min = null, $max = null,$dateParts = null)
    {
        
        

        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['config']) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['config'] =& CRM_Core_Config::singleton();
        }

        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['_date']) {
            require_once 'CRM/Utils/Date.php';
            $GLOBALS['_CRM_CORE_SELECTVALUES']['_date'] = array(
                'format'           => CRM_Utils_Date::posixToPhp($GLOBALS['_CRM_CORE_SELECTVALUES']['config']->dateformatQfDate),
                'addEmptyOption'   => true,
                'emptyOptionText'  => ts('-select-'),
                'emptyOptionValue' => ''
            );
        }
        
        $newDate = $GLOBALS['_CRM_CORE_SELECTVALUES']['_date'];

        if ($type == 'birth') {
            $minOffset = 100;
            $maxOffset = 0;
        } elseif ($type == 'relative') {
            $minOffset = 20;
            $maxOffset = 20;
        } elseif ($type == 'custom') {
            $minOffset = $min; 
            $maxOffset = $max; 
            if( $dateParts ) {
                $format = explode(CRM_CORE_BAO_CUSTOMOPTION_VALUE_SEPERATOR,$dateParts);
                foreach( $format as $v ) {
                    $stringFormat = $stringFormat ." ".$v;  
                }
                $newDate['format'] = $stringFormat;
            }
        } elseif ($type == 'fixed') {
            $minOffset = 0;
            $maxOffset = 5;
        } elseif ( $type == 'manual' ) {
            $minOffset = $min;
            $maxOffset = $max;
        } elseif ($type == 'creditCard') {
            $newDate['format'] = 'M Y';
            $minOffset = 0;
            $maxOffset = 5;
        } elseif ($type == 'mailing') {
            $minOffset = 0;
            $maxOffset = 1;
            $newDate['format'] = 'Y M d H i';
            $newDate['optionIncrement']['i'] = 15;
        } elseif ($type == 'datetime') {
            require_once 'CRM/Utils/Date.php';
            $newDate['format'] = CRM_Utils_Date::posixToPhp($GLOBALS['_CRM_CORE_SELECTVALUES']['config']->dateformatQfDatetime);
            $newDate['optionIncrement']['i'] = 15;
            // change this to minus 1 so folks can at least go back 1 year
            $minOffset = 1;
            $maxOffset = 3;
        } elseif ($type =='duration') {
            $newDate['format'] = 'H i';
            $newDate['optionIncrement']['i'] = 15;
        }
        
        $year = date('Y');
        $newDate['minYear'] = $year - $minOffset;
        $newDate['maxYear'] = $year + $maxOffset;

        return $newDate;
    }

    /**
     * values for UF form visibility options
     *
     * @static
     */
     function ufVisibility( ) {
        
        if ( ! $GLOBALS['_CRM_CORE_SELECTVALUES']['_visibility'] ) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['_visibility'] = array(
                                 'User and User Admin Only'       => ts('User and User Admin Only'),
                                 'Public User Pages'              => ts('Public User Pages'),
                                 'Public User Pages and Listings' => ts('Public User Pages and Listings'),
                                 );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['_visibility'];
    }


    /**
     * different types of status for activities
     * @param $type if true Call status array else Meeting status array
     *
     * @static
     *
     */
     function &activityStatus($type = false)
    {
        
        if (!$GLOBALS['_CRM_CORE_SELECTVALUES']['activityStatus']) {
            if ($type) {
                $GLOBALS['_CRM_CORE_SELECTVALUES']['activityStatus'] = array(
                                        'Scheduled'         => ts('Scheduled'),
                                        'Completed'         => ts('Completed'),
                                        'Unreachable'       => ts('Unreachable'),
                                        'Left Message'      => ts('Left Message')
                                        );
            } else {
                $GLOBALS['_CRM_CORE_SELECTVALUES']['activityStatus'] = array(
                                        'Scheduled'         => ts('Scheduled'),
                                        'Completed'         => ts('Completed'),
                                        );
            }
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['activityStatus'];
    }

    /**
     * different type of Mailing Components
     *
     * @static
     * return array
     */
     function &mailingComponents( ) {
        

        if (! $GLOBALS['_CRM_CORE_SELECTVALUES']['components'] ) {
            $GLOBALS['_CRM_CORE_SELECTVALUES']['components'] = array( 'Header'      => ts('Header'),
                                 'Footer'      => ts('Footer'),
                                 'Reply'       => ts('Reply Auto-responder'),
                                 'Subscribe'   => ts('Subscription Message to organization'),
                                 'Welcome'     => ts('Welcome Message'),
                                 'Unsubscribe' => ts('Farewell Message'),
                                 );
        }
        return $GLOBALS['_CRM_CORE_SELECTVALUES']['components'];
    }

    /**
     * Function to get hours
     *
     * 
     * @static
     */
    function getHours () 
    {
        for ($i = 0; $i <= 6; $i++ ) {
            $hours[$i] = $i;
        }
        return $hours;
    }

    /**
     * Function to get minutes
     *
     * 
     * @static
     */
    function getMinutes () 
    {
        for ($i = 0; $i < 60; $i = $i+15 ) {
            $minutes[$i] = $i;
        }
        return $minutes;
    }

}

?>

<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 1.1                                                |
+--------------------------------------------------------------------+
| Copyright (c) 2005 Social Source Foundation                        |
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
* @copyright Donald A. Lobo 01/15/2005
* $Id$
*
*/
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_tableName'] =  'civicrm_contact';
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_export'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['enums'] =  array(
            'contact_type',
            'preferred_communication_method',
            'preferred_mail_format',
        );
$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_Contact extends CRM_Core_DAO {
    /**
    * static instance to hold the table name
    *
    * @var string
    * @static
    */
    
    /**
    * static instance to hold the field values
    *
    * @var array
    * @static
    */
    
    /**
    * static instance to hold the FK relationships
    *
    * @var string
    * @static
    */
    
    /**
    * static instance to hold the values that can
    * be imported / apu
    *
    * @var array
    * @static
    */
    
    /**
    * static instance to hold the values that can
    * be exported / apu
    *
    * @var array
    * @static
    */
    
    /**
    * Unique Contact ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this contact
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Type of Contact.
    *
    * @var enum('Individual', 'Organization', 'Household')
    */
    var $contact_type;
    /**
    * May be used for SSN, EIN/TIN, Household ID (census) or other applicable unique legal/government ID.
    *
    * @var string
    */
    var $legal_identifier;
    /**
    * Unique trusted external ID (generally from a legacy app/datasource). Particularly useful for deduping operations.
    *
    * @var string
    */
    var $external_identifier;
    /**
    * Name used for sorting different contact types
    *
    * @var string
    */
    var $sort_name;
    /**
    * Formatted name representing preferred format for display/print/other output.
    *
    * @var string
    */
    var $display_name;
    /**
    * Nick Name.
    *
    * @var string
    */
    var $nick_name;
    /**
    * optional "home page" URL for this contact.
    *
    * @var string
    */
    var $home_URL;
    /**
    * optional URL for preferred image (photo, logo, etc.) to display for this contact.
    *
    * @var string
    */
    var $image_URL;
    /**
    * where domain_id contact come from, e.g. import, donate module insert...
    *
    * @var string
    */
    var $source;
    /**
    * What is the preferred mode of communication.
    *
    * @var enum('Phone', 'Email', 'Post')
    */
    var $preferred_communication_method;
    /**
    * What is the preferred mode of sending an email.
    *
    * @var enum('Text', 'HTML', 'Both')
    */
    var $preferred_mail_format;
    /**
    *
    * @var boolean
    */
    var $do_not_phone;
    /**
    *
    * @var boolean
    */
    var $do_not_email;
    /**
    *
    * @var boolean
    */
    var $do_not_mail;
    /**
    *
    * @var boolean
    */
    var $do_not_trade;
    /**
    * Key for validating requests related to this contact.
    *
    * @var int unsigned
    */
    var $hash;
    /**
    * Has the contact opted out from the org?
    *
    * @var boolean
    */
    var $is_opt_out;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_contact
    */
    function CRM_Contact_DAO_Contact() 
    {
        parent::CRM_Core_DAO();
    }
    /**
    * return foreign links
    *
    * @access public
    * @return array
    */
    function &links() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Internal Contact ID') ,
                    'required'=>true,
                    'import'=>true,
                    'where'=>'civicrm_contact.id',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'domain_id'=>array(
                    'name'=>'domain_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_type'=>array(
                    'name'=>'contact_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Contact Type') ,
                ) ,
                'legal_identifier'=>array(
                    'name'=>'legal_identifier',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Legal Identifier') ,
                    'maxlength'=>32,
                    'size'=>CRM_UTILS_TYPE_MEDIUM,
                    'import'=>true,
                    'where'=>'civicrm_contact.legal_identifier',
                    'headerPattern'=>'/legal\s?id/i',
                    'dataPattern'=>'/\w+?\d{5,}/',
                    'export'=>true,
                ) ,
                'external_identifier'=>array(
                    'name'=>'external_identifier',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('External Identifier') ,
                    'maxlength'=>32,
                    'size'=>CRM_UTILS_TYPE_MEDIUM,
                    'import'=>true,
                    'where'=>'civicrm_contact.external_identifier',
                    'headerPattern'=>'/external\s?id/i',
                    'dataPattern'=>'/^\d{11,}$/',
                    'export'=>true,
                ) ,
                'sort_name'=>array(
                    'name'=>'sort_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Sort Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'display_name'=>array(
                    'name'=>'display_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Display Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'nick_name'=>array(
                    'name'=>'nick_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Nick Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_contact.nick_name',
                    'headerPattern'=>'/^nick|(n(ick\s)?name)$/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
                'home_URL'=>array(
                    'name'=>'home_URL',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Home URL') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_contact.home_URL',
                    'headerPattern'=>'/^(url|web|site)/i',
                    'dataPattern'=>'/^[\w\/\:\.]+$/',
                    'export'=>true,
                    'rule'=>'url',
                ) ,
                'image_URL'=>array(
                    'name'=>'image_URL',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Image Url') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'source'=>array(
                    'name'=>'source',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Source') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'preferred_communication_method'=>array(
                    'name'=>'preferred_communication_method',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Preferred Communication Method') ,
                    'import'=>true,
                    'where'=>'civicrm_contact.preferred_communication_method',
                    'headerPattern'=>'/(communication|method)/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
                'preferred_mail_format'=>array(
                    'name'=>'preferred_mail_format',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Preferred Mail Format') ,
                    'import'=>true,
                    'where'=>'civicrm_contact.preferred_mail_format',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'do_not_phone'=>array(
                    'name'=>'do_not_phone',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Do Not Phone') ,
                    'import'=>true,
                    'where'=>'civicrm_contact.do_not_phone',
                    'headerPattern'=>'/do not phone$/i',
                    'dataPattern'=>'/^\d{1,}$/',
                    'export'=>true,
                ) ,
                'do_not_email'=>array(
                    'name'=>'do_not_email',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Do Not Email') ,
                    'import'=>true,
                    'where'=>'civicrm_contact.do_not_email',
                    'headerPattern'=>'/do not email$/i',
                    'dataPattern'=>'/^\d{1,}$/',
                    'export'=>true,
                ) ,
                'do_not_mail'=>array(
                    'name'=>'do_not_mail',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Do Not Mail') ,
                    'import'=>true,
                    'where'=>'civicrm_contact.do_not_mail',
                    'headerPattern'=>'/mail$/i',
                    'dataPattern'=>'/^\d{1,}$/',
                    'export'=>true,
                ) ,
                'do_not_trade'=>array(
                    'name'=>'do_not_trade',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Do Not Trade') ,
                    'import'=>true,
                    'where'=>'civicrm_contact.do_not_trade',
                    'headerPattern'=>'/trade$/i',
                    'dataPattern'=>'/^\d{1,}$/',
                    'export'=>true,
                ) ,
                'hash'=>array(
                    'name'=>'hash',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Hash') ,
                    'required'=>true,
                ) ,
                'is_opt_out'=>array(
                    'name'=>'is_opt_out',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Opt-out?') ,
                    'required'=>true,
                    'import'=>true,
                    'where'=>'civicrm_contact.is_opt_out',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_import'] = array();
            $fields = &CRM_Contact_DAO_Contact::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_import']['contact'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_export'] = array();
            $fields = &CRM_Contact_DAO_Contact::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_export']['contact'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_contact table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['enums'];
    }
    /**
    * returns a ts()-translated enum value for display purposes
    *
    * @param string $field  the enum field in question
    * @param string $value  the enum value up for translation
    *
    * @return string  the display value of the enum
    */
     function tsEnum($field, $value) 
    {
        
        if (!$GLOBALS['_CRM_CONTACT_DAO_CONTACT']['translations']) {
            $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['translations'] = array(
                'contact_type'=>array(
                    'Individual'=>ts('Individual') ,
                    'Organization'=>ts('Organization') ,
                    'Household'=>ts('Household') ,
                ) ,
                'preferred_communication_method'=>array(
                    'Phone'=>ts('Phone') ,
                    'Email'=>ts('Email') ,
                    'Post'=>ts('Post') ,
                ) ,
                'preferred_mail_format'=>array(
                    'Text'=>ts('Text') ,
                    'HTML'=>ts('HTML') ,
                    'Both'=>ts('Both') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_CONTACT']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_contact
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contact_DAO_Contact::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contact_DAO_Contact::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
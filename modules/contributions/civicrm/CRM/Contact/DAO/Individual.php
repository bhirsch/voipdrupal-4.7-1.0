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
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_tableName'] =  'civicrm_individual';
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_export'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['enums'] =  array(
            'greeting_type',
        );
$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_Individual extends CRM_Core_DAO {
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
    * Unique Individual ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * FK to Contact ID
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * First Name.
    *
    * @var string
    */
    var $first_name;
    /**
    * Middle Name.
    *
    * @var string
    */
    var $middle_name;
    /**
    * Last Name.
    *
    * @var string
    */
    var $last_name;
    /**
    * Prefix or Title for name (Ms, Mr...). FK to prefix ID
    *
    * @var int unsigned
    */
    var $prefix_id;
    /**
    * Suffix for name (Jr, Sr...). FK to suffix ID
    *
    * @var int unsigned
    */
    var $suffix_id;
    /**
    * Preferred greeting format.
    *
    * @var enum('Formal', 'Informal', 'Honorific', 'Custom', 'Other')
    */
    var $greeting_type;
    /**
    * Custom greeting message.
    *
    * @var string
    */
    var $custom_greeting;
    /**
    * Job Title
    *
    * @var string
    */
    var $job_title;
    /**
    * FK to gender ID
    *
    * @var int unsigned
    */
    var $gender_id;
    /**
    * Date of birth
    *
    * @var date
    */
    var $birth_date;
    /**
    *
    * @var boolean
    */
    var $is_deceased;
    /**
    * OPTIONAL FK to civicrm_contact_household record. If NOT NULL, direct phone communications to household rather than individual location.
    *
    * @var int unsigned
    */
    var $phone_to_household_id;
    /**
    * OPTIONAL FK to civicrm_contact_household record. If NOT NULL, direct phone communications to household rather than individual location.
    *
    * @var int unsigned
    */
    var $email_to_household_id;
    /**
    * OPTIONAL FK to civicrm_contact_household record. If NOT NULL, direct mail communications to household rather than individual location.
    *
    * @var int unsigned
    */
    var $mail_to_household_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_individual
    */
    function CRM_Contact_DAO_Individual() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
                'prefix_id'=>'civicrm_individual_prefix:id',
                'suffix_id'=>'civicrm_individual_suffix:id',
                'gender_id'=>'civicrm_gender:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'first_name'=>array(
                    'name'=>'first_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('First Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_individual.first_name',
                    'headerPattern'=>'/^first|(f(irst\s)?name)$/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
                'middle_name'=>array(
                    'name'=>'middle_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Middle Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_individual.middle_name',
                    'headerPattern'=>'/^middle|(m(iddle\s)?name)$/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
                'last_name'=>array(
                    'name'=>'last_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Last Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_individual.last_name',
                    'headerPattern'=>'/^last|(l(ast\s)?name)$/i',
                    'dataPattern'=>'/^\w+(\s\w+)?+$/',
                    'export'=>true,
                ) ,
                'prefix_id'=>array(
                    'name'=>'prefix_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'suffix_id'=>array(
                    'name'=>'suffix_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'greeting_type'=>array(
                    'name'=>'greeting_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Greeting Type') ,
                ) ,
                'custom_greeting'=>array(
                    'name'=>'custom_greeting',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Custom Greeting') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'job_title'=>array(
                    'name'=>'job_title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Job Title') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_individual.job_title',
                    'headerPattern'=>'/^job|(j(ob\s)?title)$/i',
                    'dataPattern'=>'//',
                    'export'=>true,
                ) ,
                'gender_id'=>array(
                    'name'=>'gender_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'birth_date'=>array(
                    'name'=>'birth_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Birth Date') ,
                    'import'=>true,
                    'where'=>'civicrm_individual.birth_date',
                    'headerPattern'=>'/birth/i',
                    'dataPattern'=>'/\d{4}-?\d{2}-?\d{2}/',
                    'export'=>true,
                ) ,
                'is_deceased'=>array(
                    'name'=>'is_deceased',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Deceased') ,
                    'export'=>true,
                    'where'=>'civicrm_individual.is_deceased',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                ) ,
                'phone_to_household_id'=>array(
                    'name'=>'phone_to_household_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'email_to_household_id'=>array(
                    'name'=>'email_to_household_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'mail_to_household_id'=>array(
                    'name'=>'mail_to_household_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_import'] = array();
            $fields = &CRM_Contact_DAO_Individual::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_import']['individual'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_export'] = array();
            $fields = &CRM_Contact_DAO_Individual::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_export']['individual'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_individual table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['translations']) {
            $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['translations'] = array(
                'greeting_type'=>array(
                    'Formal'=>ts('Formal') ,
                    'Informal'=>ts('Informal') ,
                    'Honorific'=>ts('Honorific') ,
                    'Custom'=>ts('Custom') ,
                    'Other'=>ts('Other') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_INDIVIDUAL']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_individual
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contact_DAO_Individual::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contact_DAO_Individual::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
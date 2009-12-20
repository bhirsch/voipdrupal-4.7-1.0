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
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_tableName'] =  'civicrm_relationship_type';
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_fields'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_links'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_import'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_export'] =  null;
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['enums'] =  array(
            'contact_type_a',
            'contact_type_b',
        );
$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contact_DAO_RelationshipType extends CRM_Core_DAO {
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
    * Primary key
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
    * name/label for relationship of contact_a to contact_b.
    *
    * @var string
    */
    var $name_a_b;
    /**
    * Optional name/label for relationship of contact_b to contact_a.
    *
    * @var string
    */
    var $name_b_a;
    /**
    * Optional verbose description of the relationship type.
    *
    * @var string
    */
    var $description;
    /**
    * If defined, contact_a in a relationship of this type must be a specific contact_type.
    *
    * @var enum('Individual', 'Organization', 'Household')
    */
    var $contact_type_a;
    /**
    * If defined, contact_b in a relationship of this type must be a specific contact_type.
    *
    * @var enum('Individual', 'Organization', 'Household')
    */
    var $contact_type_b;
    /**
    * Is this relationship type a predefined system type (can not be changed or de-activated)?
    *
    * @var boolean
    */
    var $is_reserved;
    /**
    * Is this relationship type currently active (i.e. can be used when creating or editing relationships)?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_relationship_type
    */
    function CRM_Contact_DAO_RelationshipType() 
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
        if (!($GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_links'])) {
            $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_fields'])) {
            $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'domain_id'=>array(
                    'name'=>'domain_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'name_a_b'=>array(
                    'name'=>'name_a_b',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Name A B') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'name_b_a'=>array(
                    'name'=>'name_b_a',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Name B A') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'contact_type_a'=>array(
                    'name'=>'contact_type_a',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Contact Type A') ,
                ) ,
                'contact_type_b'=>array(
                    'name'=>'contact_type_b',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Contact Type B') ,
                ) ,
                'is_reserved'=>array(
                    'name'=>'is_reserved',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_import'])) {
            $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_import'] = array();
            $fields = &CRM_Contact_DAO_RelationshipType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_import']['relationship_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_export'])) {
            $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_export'] = array();
            $fields = &CRM_Contact_DAO_RelationshipType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_export']['relationship_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_relationship_type table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['enums'];
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
        
        if (!$GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['translations']) {
            $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['translations'] = array(
                'contact_type_a'=>array(
                    'Individual'=>ts('Individual') ,
                    'Organization'=>ts('Organization') ,
                    'Household'=>ts('Household') ,
                ) ,
                'contact_type_b'=>array(
                    'Individual'=>ts('Individual') ,
                    'Organization'=>ts('Organization') ,
                    'Household'=>ts('Household') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTACT_DAO_RELATIONSHIPTYPE']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_relationship_type
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Contact_DAO_RelationshipType::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Contact_DAO_RelationshipType::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>
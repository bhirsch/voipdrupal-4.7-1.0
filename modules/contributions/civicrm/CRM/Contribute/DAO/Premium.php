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
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_tableName'] =  'civicrm_premiums';
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_Premium extends CRM_Core_DAO {
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
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Joins these premium settings to another object. Always civicrm_contribution_page for now.
    *
    * @var string
    */
    var $entity_table;
    /**
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * Is the Premiums feature enabled for this page?
    *
    * @var boolean
    */
    var $premiums_active;
    /**
    * Title for Premiums section.
    *
    * @var string
    */
    var $premiums_intro_title;
    /**
    * Displayed in <div> at top of Premiums section of page. Text and HTML allowed.
    *
    * @var text
    */
    var $premiums_intro_text;
    /**
    * This email address is included in receipts if it is populated and a premium has been selected.
    *
    * @var string
    */
    var $premiums_contact_email;
    /**
    * This phone number is included in receipts if it is populated and a premium has been selected.
    *
    * @var string
    */
    var $premiums_contact_phone;
    /**
    * Boolean. Should we automatically display minimum contribution amount text after the premium descriptions.
    *
    * @var boolean
    */
    var $premiums_display_min_contribution;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_premiums
    */
    function CRM_Contribute_DAO_Premium() 
    {
        parent::CRM_Core_DAO();
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'entity_table'=>array(
                    'name'=>'entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_id'=>array(
                    'name'=>'entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'premiums_active'=>array(
                    'name'=>'premiums_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Premiums Active') ,
                    'required'=>true,
                ) ,
                'premiums_intro_title'=>array(
                    'name'=>'premiums_intro_title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Title for Premiums section') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'premiums_intro_text'=>array(
                    'name'=>'premiums_intro_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Premiums Intro Text') ,
                ) ,
                'premiums_contact_email'=>array(
                    'name'=>'premiums_contact_email',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Premiums Contact Email') ,
                    'maxlength'=>100,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'premiums_contact_phone'=>array(
                    'name'=>'premiums_contact_phone',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Premiums Contact Phone') ,
                    'maxlength'=>50,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'premiums_display_min_contribution'=>array(
                    'name'=>'premiums_display_min_contribution',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Premiums Display Min Contribution') ,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_import'] = array();
            $fields = &CRM_Contribute_DAO_Premium::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_import']['premiums'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_export'] = array();
            $fields = &CRM_Contribute_DAO_Premium::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_export']['premiums'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_PREMIUM']['_export'];
    }
}
?>
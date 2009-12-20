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
$GLOBALS['_CRM_CORE_DAO_GENDER']['_tableName'] =  'civicrm_gender';
$GLOBALS['_CRM_CORE_DAO_GENDER']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_GENDER']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_GENDER']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_GENDER']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Gender extends CRM_Core_DAO {
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
    * Gender ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this gender.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Gender Name.
    *
    * @var string
    */
    var $name;
    /**
    * Controls Gender order in the select box.
    *
    * @var int
    */
    var $weight;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_gender
    */
    function CRM_Core_DAO_Gender() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_GENDER']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_GENDER']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_GENDER']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_GENDER']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_GENDER']['_fields'] = array(
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
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Gender') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_gender.name',
                    'headerPattern'=>'/^(gender|sex)/i',
                    'dataPattern'=>'/^(f|m|(fe)?male)\.?$/i',
                    'export'=>true,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_GENDER']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_GENDER']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_GENDER']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_GENDER']['_import'] = array();
            $fields = &CRM_Core_DAO_Gender::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_GENDER']['_import']['gender'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_GENDER']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_GENDER']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_GENDER']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_GENDER']['_export'] = array();
            $fields = &CRM_Core_DAO_Gender::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_GENDER']['_export']['gender'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_GENDER']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_GENDER']['_export'];
    }
}
?>
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
$GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_tableName'] =  'civicrm_location_type';
$GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_LocationType extends CRM_Core_DAO {
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
    * Location Type ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this location type.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Location Type Name.
    *
    * @var string
    */
    var $name;
    /**
    * vCard Location Type Name.
    *
    * @var string
    */
    var $vcard_name;
    /**
    * Location Type Description.
    *
    * @var string
    */
    var $description;
    /**
    * Is this location type a predefined system location?
    *
    * @var boolean
    */
    var $is_reserved;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * Is this location type the default?
    *
    * @var boolean
    */
    var $is_default;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_location_type
    */
    function CRM_Core_DAO_LocationType() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_fields'] = array(
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
                    'title'=>ts('Location Type') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                    'import'=>true,
                    'where'=>'civicrm_location_type.name',
                    'headerPattern'=>'',
                    'dataPattern'=>'',
                    'export'=>true,
                ) ,
                'vcard_name'=>array(
                    'name'=>'vcard_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('vCard Location Type') ,
                    'maxlength'=>4,
                    'size'=>CRM_UTILS_TYPE_FOUR,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'is_reserved'=>array(
                    'name'=>'is_reserved',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_default'=>array(
                    'name'=>'is_default',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_import'] = array();
            $fields = &CRM_Core_DAO_LocationType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_import']['location_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_export'] = array();
            $fields = &CRM_Core_DAO_LocationType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_export']['location_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATIONTYPE']['_export'];
    }
}
?>
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
$GLOBALS['_CRM_CORE_DAO_LOCATION']['_tableName'] =  'civicrm_location';
$GLOBALS['_CRM_CORE_DAO_LOCATION']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOCATION']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
require_once 'CRM/Core/DAO/LocationType.php';
class CRM_Core_DAO_Location extends CRM_Core_DAO {
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
    * Unique Location ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Name of table where item being referenced is stored.
    *
    * @var string
    */
    var $entity_table;
    /**
    * Foreign key to the referenced item.
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * FK to Location Type ID
    *
    * @var int unsigned
    */
    var $location_type_id;
    /**
    * Is this the primary location for the contact. (allow only ONE primary location / contact.)
    *
    * @var boolean
    */
    var $is_primary;
    /**
    *
    * @var string
    */
    var $name;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_location
    */
    function CRM_Core_DAO_Location() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATION']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATION']['_links'] = array(
                'location_type_id'=>'civicrm_location_type:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATION']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATION']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATION']['_fields'] = array(
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
                'location_type_id'=>array(
                    'name'=>'location_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'is_primary'=>array(
                    'name'=>'is_primary',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Location Name') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                    'import'=>true,
                    'where'=>'civicrm_location.name',
                    'headerPattern'=>'/^location|(l(ocation\s)?name)$/i',
                    'dataPattern'=>'/^\w+$/',
                    'export'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATION']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_LOCATION']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'] = array();
            $fields = &CRM_Core_DAO_Location::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_LOCATION']['_import']['location'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'][$name] = &$fields[$name];
                    }
                }
            }
            $GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'] = array_merge($GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'], CRM_Core_DAO_LocationType::import(true));
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATION']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'] = array();
            $fields = &CRM_Core_DAO_Location::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_LOCATION']['_export']['location'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'][$name] = &$fields[$name];
                    }
                }
            }
            $GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'] = array_merge($GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'], CRM_Core_DAO_LocationType::export(true));
        }
        return $GLOBALS['_CRM_CORE_DAO_LOCATION']['_export'];
    }
}
?>
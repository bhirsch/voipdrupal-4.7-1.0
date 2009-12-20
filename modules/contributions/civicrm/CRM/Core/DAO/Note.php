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
$GLOBALS['_CRM_CORE_DAO_NOTE']['_tableName'] =  'civicrm_note';
$GLOBALS['_CRM_CORE_DAO_NOTE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_NOTE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_NOTE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_NOTE']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Note extends CRM_Core_DAO {
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
    * Note ID
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
    * Note and/or Comment.
    *
    * @var text
    */
    var $note;
    /**
    * FK to Contact ID creator
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * When was this note last modified/edited
    *
    * @var date
    */
    var $modified_date;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_note
    */
    function CRM_Core_DAO_Note() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_NOTE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_NOTE']['_links'] = array(
                'contact_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_NOTE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_NOTE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_NOTE']['_fields'] = array(
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
                'note'=>array(
                    'name'=>'note',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Note') ,
                    'rows'=>4,
                    'cols'=>80,
                    'import'=>true,
                    'where'=>'civicrm_note.note',
                    'headerPattern'=>'/Note|Comment/i',
                    'dataPattern'=>'//',
                    'export'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'modified_date'=>array(
                    'name'=>'modified_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Modified Date') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_NOTE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_NOTE']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_NOTE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_NOTE']['_import'] = array();
            $fields = &CRM_Core_DAO_Note::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_NOTE']['_import']['note'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_NOTE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_NOTE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_NOTE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_NOTE']['_export'] = array();
            $fields = &CRM_Core_DAO_Note::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_NOTE']['_export']['note'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_NOTE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_NOTE']['_export'];
    }
}
?>
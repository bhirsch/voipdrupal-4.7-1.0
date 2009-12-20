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
$GLOBALS['_CRM_MAILING_DAO_MAILING']['_tableName'] =  'civicrm_mailing';
$GLOBALS['_CRM_MAILING_DAO_MAILING']['_fields'] =  null;
$GLOBALS['_CRM_MAILING_DAO_MAILING']['_links'] =  null;
$GLOBALS['_CRM_MAILING_DAO_MAILING']['_import'] =  null;
$GLOBALS['_CRM_MAILING_DAO_MAILING']['_export'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Mailing_DAO_Mailing extends CRM_Core_DAO {
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
    * Which Domain owns this mailing
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * FK to the header component.
    *
    * @var int unsigned
    */
    var $header_id;
    /**
    * FK to the footer component.
    *
    * @var int unsigned
    */
    var $footer_id;
    /**
    * FK to the auto-responder component.
    *
    * @var int unsigned
    */
    var $reply_id;
    /**
    * FK to the unsubscribe component.
    *
    * @var int unsigned
    */
    var $unsubscribe_id;
    /**
    * FK to the opt-out component.
    *
    * @var int unsigned
    */
    var $optout_id;
    /**
    * Mailing Name.
    *
    * @var string
    */
    var $name;
    /**
    * From Header of mailing
    *
    * @var string
    */
    var $from_name;
    /**
    * From Email of mailing
    *
    * @var string
    */
    var $from_email;
    /**
    * Reply-To Email of mailing
    *
    * @var string
    */
    var $replyto_email;
    /**
    * Subject of mailing
    *
    * @var string
    */
    var $subject;
    /**
    * Body of the mailing in text format.
    *
    * @var text
    */
    var $body_text;
    /**
    * Body of the mailing in html format.
    *
    * @var text
    */
    var $body_html;
    /**
    * Is this object a mailing template?
    *
    * @var boolean
    */
    var $is_template;
    /**
    * Should we track URL click-throughs for this mailing?
    *
    * @var boolean
    */
    var $url_tracking;
    /**
    * Should we forward replies back to the author?
    *
    * @var boolean
    */
    var $forward_replies;
    /**
    * Should we enable the auto-responder?
    *
    * @var boolean
    */
    var $auto_responder;
    /**
    * Should we track when recipients open/read this mailing?
    *
    * @var boolean
    */
    var $open_tracking;
    /**
    * Has at least one job associated with this mailing finished?
    *
    * @var boolean
    */
    var $is_completed;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mailing
    */
    function CRM_Mailing_DAO_Mailing() 
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
        if (!($GLOBALS['_CRM_MAILING_DAO_MAILING']['_links'])) {
            $GLOBALS['_CRM_MAILING_DAO_MAILING']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'header_id'=>'civicrm_mailing_component:id',
                'footer_id'=>'civicrm_mailing_component:id',
                'reply_id'=>'civicrm_mailing_component:id',
                'unsubscribe_id'=>'civicrm_mailing_component:id',
                'optout_id'=>'civicrm_mailing_component:id',
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_MAILING']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_MAILING']['_fields'])) {
            $GLOBALS['_CRM_MAILING_DAO_MAILING']['_fields'] = array(
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
                'header_id'=>array(
                    'name'=>'header_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'footer_id'=>array(
                    'name'=>'footer_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'reply_id'=>array(
                    'name'=>'reply_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'unsubscribe_id'=>array(
                    'name'=>'unsubscribe_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'optout_id'=>array(
                    'name'=>'optout_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'from_name'=>array(
                    'name'=>'from_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('From Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'from_email'=>array(
                    'name'=>'from_email',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('From Email') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'replyto_email'=>array(
                    'name'=>'replyto_email',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Replyto Email') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'subject'=>array(
                    'name'=>'subject',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Subject') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'body_text'=>array(
                    'name'=>'body_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Body Text') ,
                ) ,
                'body_html'=>array(
                    'name'=>'body_html',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Body Html') ,
                ) ,
                'is_template'=>array(
                    'name'=>'is_template',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'url_tracking'=>array(
                    'name'=>'url_tracking',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Url Tracking') ,
                ) ,
                'forward_replies'=>array(
                    'name'=>'forward_replies',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Forward Replies') ,
                ) ,
                'auto_responder'=>array(
                    'name'=>'auto_responder',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Auto Responder') ,
                ) ,
                'open_tracking'=>array(
                    'name'=>'open_tracking',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Open Tracking') ,
                ) ,
                'is_completed'=>array(
                    'name'=>'is_completed',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_DAO_MAILING']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MAILING_DAO_MAILING']['_tableName'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_MAILING']['_import'])) {
            $GLOBALS['_CRM_MAILING_DAO_MAILING']['_import'] = array();
            $fields = &CRM_Mailing_DAO_Mailing::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_MAILING']['_import']['mailing'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_MAILING']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_MAILING']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_DAO_MAILING']['_export'])) {
            $GLOBALS['_CRM_MAILING_DAO_MAILING']['_export'] = array();
            $fields = &CRM_Mailing_DAO_Mailing::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_DAO_MAILING']['_export']['mailing'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_DAO_MAILING']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_DAO_MAILING']['_export'];
    }
}
?>
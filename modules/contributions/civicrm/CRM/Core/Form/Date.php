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
 * This class contains function to build date-format.
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


define( 'CRM_CORE_FORM_DATE_DATE_yyyy_mm_dd',1);
define( 'CRM_CORE_FORM_DATE_DATE_mm_dd_yy',2);
define( 'CRM_CORE_FORM_DATE_DATE_mm_dd_yyyy',4);
define( 'CRM_CORE_FORM_DATE_DATE_Month_dd_yyyy',8);
define( 'CRM_CORE_FORM_DATE_DATE_dd_mon_yy',16);

Class CRM_Core_Form_Date
{

    /**
     * various Date Formats
     */
    
              
                
              
           
               


    /**
     * This function is to build the date-format form
     *
     * @param Object  $form   the form object that we are operating on
     * 
     * @static
     * @access public
     */
     function buildAllowedDateFormats( &$form ) {

        $dateOptions = array();
        $dateOptions[] = HTML_QuickForm::createElement('radio', null, null, ts('yyyy-mm-dd OR yyyymmdd (1998-12-25 OR 19981225)'), CRM_CORE_FORM_DATE_DATE_yyyy_mm_dd);
        $dateOptions[] = HTML_QuickForm::createElement('radio', null, null, ts('mm/dd/yy OR mm-dd-yy (12/25/98 OR 12-25-98)'), CRM_CORE_FORM_DATE_DATE_mm_dd_yy);
        $dateOptions[] = HTML_QuickForm::createElement('radio', null, null, ts('mm/dd/yyyy OR mm-dd-yyyy (12/25/1998 OR 12-25-1998)'), CRM_CORE_FORM_DATE_DATE_mm_dd_yyyy);
        $dateOptions[] = HTML_QuickForm::createElement('radio', null, null, ts('Month dd, yyyy (December 12, 1998)'), CRM_CORE_FORM_DATE_DATE_Month_dd_yyyy);
        $dateOptions[] = HTML_QuickForm::createElement('radio', null, null, ts('dd-mon-yy (25-Dec-98)'), CRM_CORE_FORM_DATE_DATE_dd_mon_yy);
        $form->addGroup($dateOptions, 'dateFormats', ts('Date Format'), '<br/>');
        $form->setDefaults(array('dateFormats' => CRM_CORE_FORM_DATE_DATE_yyyy_mm_dd));
    }

}


?>

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
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_CONTACT_FORM_TASK_EXPORT_SELECT_EXPORT_ALL',1);
define( 'CRM_CONTACT_FORM_TASK_EXPORT_SELECT_EXPORT_SELECTED',2);

require_once 'CRM/Contact/Form/Task.php';
require_once 'CRM/Contact/BAO/Contact.php';

/**
 * This class gets the name of the file to upload
 */
class CRM_Contact_Form_Task_Export_Select extends CRM_Contact_Form_Task {
   
    /**
     * The array that holds all the contact ids
     *
     * @var array
     */
    var $_contactIds;

    /**
     * various Contact types
     */
    
               
          
    
    /**
     * build all the data structures needed to build the form
     *
     * @param
     * @return void
     * @access public
     */
    function preProcess( ) 
    {
        $this->_contactIds = array( ); 
        $this->_selectAll  = false;

        // get the submitted values of the search form 
        // we'll need to get fv from either search or adv search in the future 
        if ( $this->_action == CRM_CORE_ACTION_ADVANCED ) { 
            $values = $this->controller->exportValues( 'Advanced' ); 
        } else { 
            $values = $this->controller->exportValues( 'Search' ); 
        } 
         
        $this->_task = $values['task']; 
        $crmContactTaskTasks = CRM_Contact_Task::tasks(); 
        $this->assign( 'taskName', $crmContactTaskTasks[$this->_task] ); 
 
        // all contacts or action = save a search 
        if (($values['radio_ts'] == 'ts_all') || ($this->_task == CRM_CONTACT_TASK_SAVE_SEARCH)) { 
            $this->_selectAll = true;
            $this->assign( 'totalSelectedContacts', $this->get( 'rowCount' ) );
        } else if($values['radio_ts'] == 'ts_sel') { 
            // selected contacts only 
            // need to perform action on only selected contacts 
            foreach ( $values as $name => $value ) { 
                if ( substr( $name, 0, CRM_CORE_FORM_CB_PREFIX_LEN ) == CRM_CORE_FORM_CB_PREFIX ) { 
                    $this->_contactIds[] = substr( $name, CRM_CORE_FORM_CB_PREFIX_LEN ); 
                } 
            } 
            $this->assign( 'totalSelectedContacts', count( $this->_contactIds ) ); 
        }
        
        $this->set( 'contactIds', $this->_contactIds );
        $this->set( 'selectAll' , $this->_selectAll  );

    }


    /**
     * Function to actually build the form
     *
     * @return void
     * @access public
     */
     function buildQuickForm( ) {
        //export option
        $exportoptions = array();        
        $exportOptions[] = HTML_QuickForm::createElement('radio',
                                                         null, null, ts('Export PRIMARY contact fields'), CRM_CONTACT_FORM_TASK_EXPORT_SELECT_EXPORT_ALL);
        $exportOptions[] = HTML_QuickForm::createElement('radio',
                                                         null, null, ts('Select fields for export'), CRM_CONTACT_FORM_TASK_EXPORT_SELECT_EXPORT_SELECTED);

        $this->addGroup($exportOptions, 'exportOption', ts('Export Type'), '<br/>');

        $this->setDefaults(array('exportOption' => CRM_CONTACT_FORM_TASK_EXPORT_SELECT_EXPORT_ALL ));


        $this->addButtons( array(
                                 array ( 'type'      => 'next',
                                         'name'      => ts('Continue >>'),
                                         'spacing'   => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                         'isDefault' => true   ),
                                 array ( 'type'      => 'cancel',
                                         'name'      => ts('Cancel') ),
                                 )
                           );
    }

    /**
     * Process the uploaded file
     *
     * @return void
     * @access public
     */
     function postProcess( ) {
        $exportOption = $this->controller->exportValue( $this->_name, 'exportOption' ); 

        if ($exportOption == CRM_CONTACT_FORM_TASK_EXPORT_SELECT_EXPORT_ALL) {
            require_once 'CRM/Contact/BAO/Export.php';
            $export =& new CRM_Contact_BAO_Export( );
            $export->exportContacts( $this->_selectAll,
                                     $this->_contactIds,
                                     $this->get( 'formValues' ),
                                     $this->get( CRM_UTILS_SORT_SORT_ORDER ) );
        }
    }

    /**
     * Return a descriptive name for the page, used in wizard header
     *
     * @return string
     * @access public
     */
     function getTitle( ) {
        return ts('Export All or Selected Fields');
    }

}

?>

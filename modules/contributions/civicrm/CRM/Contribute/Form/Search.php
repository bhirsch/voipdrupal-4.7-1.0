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
 | at http://www.openngo.org/faqs/licensing.html                      |
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

/**
 * Files required
 */


require_once 'CRM/Contribute/PseudoConstant.php';
require_once 'CRM/Contribute/Selector/Search.php';
require_once 'CRM/Core/Selector/Controller.php';

/**
 * advanced search, extends basic search
 */
class CRM_Contribute_Form_Search extends CRM_Core_Form {

    /** 
     * Are we forced to run a search 
     * 
     * @var int 
     * @access protected 
     */ 
    var $_force; 
 
    /** 
     * name of search button 
     * 
     * @var string 
     * @access protected 
     */ 
    var $_searchButtonName;

    /** 
     * name of print button 
     * 
     * @var string 
     * @access protected 
     */ 
    var $_printButtonName; 
 
    /** 
     * name of action button 
     * 
     * @var string 
     * @access protected 
     */ 
    var $_actionButtonName;

    /** 
     * form values that we will be using 
     * 
     * @var array 
     * @access protected 
     */ 
    var $_formValues; 
 
    /** 
     * have we already done this search 
     * 
     * @access protected 
     * @var boolean 
     */ 
    var $_done; 

    /**
     * are we restricting ourselves to a single contact
     *
     * @access protected  
     * @var boolean  
     */  
    var $_single = false;

    /** 
     * are we restricting ourselves to a single contact 
     * 
     * @access protected   
     * @var boolean   
     */   
    var $_limit = null;

    /** 
     * what context are we being invoked from 
     *    
     * @access protected      
     * @var string 
     */      
    var $_context = null; 

    var $_defaults;

    /** 
     * processing needed for buildForm and later 
     * 
     * @return void 
     * @access public 
     */ 
    function preProcess( ) { 
        /** 
         * set the button names 
         */ 
        $this->_searchButtonName = $this->getButtonName( 'refresh' ); 
        $this->_printButtonName  = $this->getButtonName( 'next'   , 'print' ); 
        $this->_actionButtonName = $this->getButtonName( 'next'   , 'action' ); 

        $this->_done = false;

        $this->defaults = array( );

        /* 
         * we allow the controller to set force/reset externally, useful when we are being 
         * driven by the wizard framework 
         */ 
        $nullObject = null; 
        $this->_reset   = CRM_Utils_Request::retrieve( 'reset', $nullObject ); 
        $this->_force   = CRM_Utils_Request::retrieve( 'force', $this, false ); 
        $this->_limit   = CRM_Utils_Request::retrieve( 'limit', $this );
        $this->_context = CRM_Utils_Request::retrieve( 'context', $this );

        $this->assign( 'limit', $this->_limit );

        // we only force stuff once :) 
        $this->set( 'force', false ); 

        // get user submitted values  
        // get it from controller only if form has been submitted, else preProcess has set this  
        if ( ! empty( $_POST ) ) { 
            $this->_formValues = $this->controller->exportValues( $this->_name );  
        } else {
            $this->_formValues = $this->get( 'formValues' ); 
        } 
 
        if ( $this->_force ) { 
            $this->postProcess( );
        }

        $sortID = null; 
        if ( $this->get( CRM_UTILS_SORT_SORT_ID  ) ) { 
            $sortID = CRM_Utils_Sort::sortIDValue( $this->get( CRM_UTILS_SORT_SORT_ID  ), 
                                                   $this->get( CRM_UTILS_SORT_SORT_DIRECTION ) ); 
        } 
        $selector =& new CRM_Contribute_Selector_Search( $this->_formValues,
                                                         $this->_action,
                                                         null,
                                                         $this->_single,
                                                         $this->_limit,
                                                         $this->_context ); 
        $controller =& new CRM_Core_Selector_Controller($selector ,  
                                                        $this->get( CRM_UTILS_PAGER_PAGE_ID ),  
                                                        $sortID,  
                                                        CRM_CORE_ACTION_VIEW, 
                                                        $this, 
                                                        CRM_CORE_SELECTOR_CONTROLLER_TRANSFER );

        $controller->setEmbedded( true ); 
        $controller->moveFromSessionToTemplate(); 
    }

    function setDefaultValues( ) { 
        return $this->_defaults; 
    } 

    /**
     * Build the form
     *
     * @access public
     * @return void
     */
    function buildQuickForm( ) 
    {
        // text for sort_name 
        $this->addElement('text', 'sort_name', ts('Contributor'), CRM_Core_DAO::getAttribute('CRM_Contact_DAO_Contact', 'sort_name') );

        CRM_Contribute_Form_Search::buildQuickFormCommon( $this );

        /* 
         * add form checkboxes for each row. This is needed out here to conform to QF protocol 
         * of all elements being declared in builQuickForm 
         */ 
        $rows = $this->get( 'rows' ); 
        if ( is_array( $rows ) ) {
            $this->addElement( 'checkbox', 'toggleSelect', null, null, array( 'onChange' => "return toggleCheckboxVals('mark_x_',this.form);" ) ); 
            
            $total = $cancel = 0;
            foreach ($rows as $row) { 
                $this->addElement( 'checkbox', $row['checkbox'], 
                                   null, null, 
                                   array( 'onclick' => "return checkSelectedBox('" . $row['checkbox'] . "', '" . $this->getName() . "');" )
                                   ); 

                if ( $row['cancel_date'] ) {
                    $cancel += $row['total_amount'];
                } else {
                    $total     += $row['total_amount'];
                }
            }

            $this->assign( 'total_amount' , $total  );
            $this->assign( 'cancel_amount', $cancel );
            $this->assign( 'num_amount'   , count( $rows ) );
            $this->assign( 'single', $this->_single );

            // also add the action and radio boxes
            require_once 'CRM/Contribute/Task.php';
            $tasks = array( '' => ts('- more actions -') ) + CRM_Contribute_Task::tasks( );
            $this->add('select', 'task'   , ts('Actions:') . ' '    , $tasks    ); 
            $this->add('submit', $this->_actionButtonName, ts('Go'), 
                       array( 'class' => 'form-submit', 
                              'onclick' => "return checkPerformAction('mark_x', '".$this->getName()."', 0);" ) ); 

            $this->add('submit', $this->_printButtonName, ts('Print'), 
                       array( 'class' => 'form-submit', 
                              'onclick' => "return checkPerformAction('mark_x', '".$this->getName()."', 1);" ) ); 

            
            // need to perform tasks on all or selected items ? using radio_ts(task selection) for it 
            $this->addElement('radio', 'radio_ts', null, '', 'ts_sel', array( 'checked' => null) ); 
            $this->addElement('radio', 'radio_ts', null, '', 'ts_all', array( 'onchange' => $this->getName().".toggleSelect.checked = false; toggleCheckboxVals('mark_x_',".$this->getName()."); return false;" ) );
        }

         // add buttons 
        $this->addButtons( array( 
                                 array ( 'type'      => 'refresh', 
                                         'name'      => ts('Search') , 
                                         'isDefault' => true     ) 
                                 )         
                           ); 

    }

    /**
     * add all the elements shared between this and advnaced search
     *
     * @access public 
     * @return void
     * @static
     */ 
     function buildQuickFormCommon( &$form ) {
        // Date selects for date 
        $form->add('date', 'contribution_date_from', ts('Contribution Dates - From'), CRM_Core_SelectValues::date('relative')); 
        $form->addRule('contribution_date_from', ts('Select a valid date.'), 'qfDate'); 
 
        $form->add('date', 'contribution_date_to', ts('To'), CRM_Core_SelectValues::date('relative')); 
        $form->addRule('contribution_date_to', ts('Select a valid date.'), 'qfDate'); 

        $form->add('text', 'contribution_min_amount', ts('Minimum Amount'), array( 'size' => 8, 'maxlength' => 8 ) ); 
        $form->addRule( 'contribution_min_amount', ts( 'Please enter a valid money value (e.g. 9.99).' ), 'money' );

        $form->add('text', 'contribution_max_amount', ts('Maximum Amount'), array( 'size' => 8, 'maxlength' => 8 ) ); 
        $form->addRule( 'contribution_max_amount', ts( 'Please enter a valid money value (e.g. 99.99).' ), 'money' );


        $form->add('select', 'contribution_type_id', 
                   ts( 'Contribution Type' ),
                   array( '' => ts( '- select -' ) ) +
                   CRM_Contribute_PseudoConstant::contributionType( ) );

        $form->add('select', 'payment_instrument_id', 
                   ts( 'Payment Instrument' ), 
                   array( '' => ts( '- select -' ) ) +
                   CRM_Contribute_PseudoConstant::paymentInstrument( ) );

        $status = array( );
        $status[] = $form->createElement( 'radio', null, null, ts( 'Valid' )    , 'Valid'     );
        $status[] = $form->createElement( 'radio', null, null, ts( 'Cancelled' ), 'Cancelled' );
        $status[] = $form->createElement( 'radio', null, null, ts( 'All' )      , 'All'       );

        $form->addGroup( $status, 'contribution_status', ts( 'Contribution Status' ) );
        $form->setDefaults(array('contribution_status' => 'All'));

        // add null checkboxes for thank you and receipt
        $form->addElement( 'checkbox', 'contribution_thankyou_date_isnull', ts( 'Thank-you date not set?' ) );
        $form->addElement( 'checkbox', 'contribution_receipt_date_isnull' , ts( 'Receipt date not set?' ) );

        // add all the custom  searchable fields
        require_once 'CRM/Core/BAO/CustomGroup.php';
        $groupDetails = CRM_Core_BAO_CustomGroup::getGroupDetail( null, true, array( 'Contribution' ) );
        if ( $groupDetails ) {
            require_once 'CRM/Core/BAO/CustomField.php';
            $form->assign('contributeGroupTree', $groupDetails);
            foreach ($groupDetails as $group) {
                foreach ($group['fields'] as $field) {
                    $fieldId = $field['id'];                
                    $elementName = 'custom_' . $fieldId;
                    CRM_Core_BAO_CustomField::addQuickFormElement( $form,
                                                                   $elementName,
                                                                   $fieldId,
                                                                   false, false, true );
                }
            }
        }
    }

    /**
     * The post processing of the form gets done here.
     *
     * Key things done during post processing are
     *      - check for reset or next request. if present, skip post procesing.
     *      - now check if user requested running a saved search, if so, then
     *        the form values associated with the saved search are used for searching.
     *      - if user has done a submit with new values the regular post submissing is 
     *        done.
     * The processing consists of using a Selector / Controller framework for getting the
     * search results.
     *
     * @param
     *
     * @return void 
     * @access public
     */
    function postProcess() 
    {
        if ( $this->_done ) {
            return;
        }

        $this->_done = true;

        $this->_formValues = $this->controller->exportValues($this->_name);

        $this->fixFormValues( );

        $this->set( 'formValues', $this->_formValues );

        $buttonName = $this->controller->getButtonName( );
        if ( $buttonName == $this->_actionButtonName || $buttonName == $this->_printButtonName ) { 
            // check actionName and if next, then do not repeat a search, since we are going to the next page 
 
            // hack, make sure we reset the task values 
            $stateMachine =& $this->controller->getStateMachine( ); 
            $formName     =  $stateMachine->getTaskFormName( ); 
            $this->controller->resetPage( $formName ); 
            return; 
        }

        $sortID = null; 
        if ( $this->get( CRM_UTILS_SORT_SORT_ID  ) ) { 
            $sortID = CRM_Utils_Sort::sortIDValue( $this->get( CRM_UTILS_SORT_SORT_ID  ), 
                                                   $this->get( CRM_UTILS_SORT_SORT_DIRECTION ) ); 
        } 

        $selector =& new CRM_Contribute_Selector_Search( $this->_formValues,
                                                         $this->_action,
                                                         null,
                                                         $this->_single,
                                                         $this->_limit,
                                                         $this->_context ); 
        $controller =& new CRM_Core_Selector_Controller($selector , 
                                                        $this->get( CRM_UTILS_PAGER_PAGE_ID ), 
                                                        $sortID, 
                                                        CRM_CORE_ACTION_VIEW,
                                                        $this,
                                                        CRM_CORE_SELECTOR_CONTROLLER_SESSION );
        $controller->setEmbedded( true ); 
        $controller->run(); 

    }

    function fixFormValues( ) {
        // if this search has been forced
        // then see if there are any get values, and if so over-ride the post values
        // note that this means that GET over-rides POST :)

        // we fix date_to here if set to be the end of the day, i.e. 23:59:59
        if ( ! CRM_Utils_System::isNull( $this->_formValues['contribution_date_to'] ) ) {
            $this->_formValues['contribution_date_to']['H'] = 23;
            $this->_formValues['contribution_date_to']['i'] = 59;
            $this->_formValues['contribution_date_to']['s'] = 59;
        }

        if ( ! $this->_force ) {
            return;
        }

        $nullObject = null;
        $status = CRM_Utils_Request::retrieve( 'status', $nullObject );
        if ( $status ) {
            switch ( $status ) {
            case 'Valid':
            case 'Cancelled':
            case 'All':
                $this->_formValues['contribution_status'] = $status;
                $this->_defaults['contribution_status'] = $status;
                break;
            }
        }

        $cid = CRM_Utils_Request::retrieve( 'cid', $nullObject );
        if ( $cid ) {
            $cid = CRM_Utils_Type::escape( $cid, 'Integer' );
            if ( $cid > 0 ) {
                $this->_formValues['contact_id'] = $cid;
                list( $display, $image ) = CRM_Contact_BAO_Contact::getDisplayAndImage( $cid );
                $this->_defaults['sort_name'] = CRM_Core_DAO::getFieldValue( 'CRM_Contact_DAO_Contact', $cid,
                                                                             'sort_name' );
                // also assign individual mode to the template
                $this->_single = true;
            }
        }

        $fromDate = CRM_Utils_Request::retrieve( 'start', $nullObject );
        if ( $fromDate ) {
            $fromDate = CRM_Utils_Type::escape( $fromDate, 'Timestamp' );
            $date = CRM_Utils_Date::unformat( $fromDate, '' );
            $this->_formValues['contribution_date_from'] = $date;
            $this->_defaults['contribution_date_from'] = $date;
        }

        $toDate= CRM_Utils_Request::retrieve( 'end', $nullObject ); 
        if ( $toDate ) { 
            $toDate = CRM_Utils_Type::escape( $toDate, 'Timestamp' ); 
            $date = CRM_Utils_Date::unformat( $toDate, '' );
            $this->_formValues['contribution_date_to'] = $date;
            $this->_defaults['contribution_date_to'] = $date;
            $this->_formValues['contribution_date_to']['H'] = 23;
            $this->_formValues['contribution_date_to']['i'] = 59;
            $this->_formValues['contribution_date_to']['s'] = 59;
        }

        $this->_limit = CRM_Utils_Request::retrieve( 'limit', $this );
    }

}

?>

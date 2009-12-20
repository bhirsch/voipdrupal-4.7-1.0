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


require_once 'CRM/Core/StateMachine.php';

/**
 * State machine for managing different states of the Import process.
 *
 */
class CRM_Mailing_StateMachine_Send extends CRM_Core_StateMachine {

    /**
     * class constructor
     *
     * @param object  CRM_Mailing_Controller
     * @param int     $action
     *
     * @return object CRM_Mailing_StateMachine
     */
    function CRM_Mailing_StateMachine_Send( $controller, $action = CRM_CORE_ACTION_NONE ) {
        parent::CRM_Core_StateMachine( $controller, $action );
        
        $this->_pages = array(
                              'CRM_Mailing_Form_Name',
                              'CRM_Mailing_Form_Group',
                              'CRM_Mailing_Form_Upload',
                              'CRM_Mailing_Form_Test',
                              'CRM_Mailing_Form_Schedule',
                              );
        
        $this->addSequentialPages( $this->_pages, $action );
    }

}

?>
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

/**
 * class to represent the actions that can be performed on a group of contacts
 * used by the search forms
 *
 */
define( 'CRM_CONTRIBUTE_TASK_DELETE_CONTRIBUTIONS',8);
define( 'CRM_CONTRIBUTE_TASK_PRINT_CONTRIBUTIONS',64);
define( 'CRM_CONTRIBUTE_TASK_EXPORT_CONTRIBUTIONS',4096);
$GLOBALS['_CRM_CONTRIBUTE_TASK']['_tasks'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_TASK']['_optionalTasks'] =  null;

class CRM_Contribute_Task {
    
                    
                    
                 

    /**
     * the task array
     *
     * @var array
     * @static
     */
    

    /**
     * the optional task array
     *
     * @var array
     * @static
     */
    

    /**
     * These tasks are the core set of tasks that the user can perform
     * on a contact / group of contacts
     *
     * @return array the set of tasks for a group of contacts
     * @static
     * @access public
     */
     function &tasks()
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_TASK']['_tasks'])) {
            $GLOBALS['_CRM_CONTRIBUTE_TASK']['_tasks'] = array(
                                  4096  => ts( 'Export Contributions'               ),
                                  8     => ts( 'Delete Contributions'               ),
                                  );
        }
         
        return $GLOBALS['_CRM_CONTRIBUTE_TASK']['_tasks'];
    }

}

?>

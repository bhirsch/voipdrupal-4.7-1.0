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
 * This file contains the various menus of the CiviCRM module
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_UTILS_MENU_CALLBACK',4);
define( 'CRM_UTILS_MENU_NORMAL_ITEM',22);
define( 'CRM_UTILS_MENU_LOCAL_TASK',128);
define( 'CRM_UTILS_MENU_DEFAULT_LOCAL_TASK',640);
define( 'CRM_UTILS_MENU_ROOT_LOCAL_TASK',1152);
$GLOBALS['_CRM_UTILS_MENU']['_items'] =  null;
$GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'] =  null;
$GLOBALS['_CRM_UTILS_MENU']['_localTasks'] =  null;
$GLOBALS['_CRM_UTILS_MENU']['_params'] =  null;
$GLOBALS['_CRM_UTILS_MENU']['processed'] =  false;

require_once 'CRM/Core/I18n.php';

class CRM_Utils_Menu {
    /**
     * the list of menu items
     * 
     * @var array
     * @static
     */
    

    /**
     * the list of root local tasks
     *
     * @var array
     * @static
     */
    

    /**
     * the list of local tasks
     *
     * @var array
     * @static
     */
    

    /**
     * The list of dynamic params
     *
     * @var array
     * @static
     */
    

    /**
     * This is a super super gross hack, please fix sometime soon
     *
     * using constants from DRUPAL/includes/menu.inc, so that we can reuse 
     * the same code in both drupal and mambo
     */
    
                       
                   
                   
           
             
    
    /**
     * This function defines information for various menu items
     *
     * @static
     * @access public
     */
     function &items( ) {
        // helper variable for nicer formatting
        $drupalSyncExtra = ts('Synchronize Users to Contacts:') . ' ' . ts('CiviCRM will check each user record for a contact record. A new contact record will be created for each user where one does not already exist.') . '\n\n' . ts('Do you want to continue?');
        $backupDataExtra = ts('Backup Your Data:') . ' ' . ts('CiviCRM will create an SQL dump file with all of your existing data, and allow you to download it to your local computer. This process may take a long time and generate a very large file if you have a large number of records.') . '\n\n' . ts('Do you want to continue?');
 
        if ( ! $GLOBALS['_CRM_UTILS_MENU']['_items'] ) {
            // This is the minimum information you can provide for a menu item.
            $GLOBALS['_CRM_UTILS_MENU']['_items'] =
                array(
                      array(
                            'path'    => 'civicrm/admin',
                            'title'   => ts('Administer CiviCRM'),
                            'qs'      => 'reset=1',
                            'access'  => CRM_Utils_System::checkPermission('administer CiviCRM') &&
                                         CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_NORMAL_ITEM,
                            'weight'  => 40,
                            ),

                      array(
                            'path'    => 'civicrm/admin/access',
                            'title'   => ts('Access Control'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'adminGroup' => ts('Manage'),
                            'icon'    => 'admin/03.png',
                            'weight'  => 110
                            ),

                      array(
                            'path'    => 'civicrm/admin/backup',
                            'title'   => ts('Backup Data'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'extra' => 'onclick = "return confirm(\'' . $backupDataExtra . '\');"',
                            'adminGroup' => ts('Manage'),
                            'icon'    => 'admin/14.png',
                            'weight'  => 120
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/synchUser',
                            'title'   => ts('Synchronize Users-to-Contacts'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'extra' => 'onclick = "if (confirm(\'' . $drupalSyncExtra . '\')) this.href+=\'&amp;confirmed=1\'; else return false;"',
                            'adminGroup' => ts('Manage'),
                            'icon'    => 'admin/Synch_user.png',
                            'weight'  => 130
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/activityType',
                            'title'   => ts('Activity Types'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/05.png',
                            'weight'  => 210
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/uf/group',
                            'title'   => ts('CiviCRM Profile'),
                            'qs'      => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/Profile.png',
                            'weight'  => 220
                            ),
                      
                      array(
                            'path'   => 'civicrm/admin/uf/group/field',
                            'title'  => ts('CiviCRM Profile Fields'),
                            'qs'     => 'reset=1',
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_CALLBACK,
                            'weight' => 221
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/custom/group',
                            'title'   => ts('Custom Data'),
                            'qs'      => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/custm_data.png',
                            'weight'  => 230
                            ),
                      
                      array(
                            'path'   => 'civicrm/admin/custom/group/field',
                            'title'  => ts('Custom Data Fields'),
                            'qs'     => 'reset=1',
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_CALLBACK,
                            'weight' => 231
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/locationType',
                            'title'   => ts('Location Types (Home, Work...)'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/13.png',
                            'weight'  => 240
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/tag',
                            'title'   => ts('Tags (Categories)'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/11.png',
                            'weight'  => 260
                            ),

                      array(
                            'path'    => 'civicrm/contact/domain',
                            'title'   => ts('Edit Domain Information'),
                            'qs'     => 'reset=1&action=update',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/domain.png',
                            'weight'  => 270
                            ),

                      array(
                            'path'    => 'civicrm/admin/reltype',
                            'title'   => ts('Relationship Types'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/rela_type.png',
                            'weight'  => 250
                            ),
                      array(
                            'path'    => 'civicrm/admin/dupematch',
                            'title'   => ts('Duplicate Matching'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/duplicate_matching.png',
                            'weight'  => 239
                            ),

                      array(
                            'path'    => 'civicrm/admin/gender',
                            'title'   => ts('Gender Options (Male, Female...)'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/01.png',
                            'weight'  => 310
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/IMProvider',
                            'title'   => ts('Instant Messenger Services'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/07.png',
                            'weight'  => 320
                            ),

                      array(
                            'path'    => 'civicrm/admin/mobileProvider',
                            'title'   => ts('Mobile Phone Providers'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/08.png',
                            'weight'  => 339
                            ),
    
                      array(
                            'path'    => 'civicrm/admin/prefix',
                            'title'   => ts('Individual Prefixes (Ms, Mr...)'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/title.png',
                            'weight'  => 340
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/suffix',
                            'title'   => ts('Individual Suffixes (Jr, Sr...)'),
                            'qs'     => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/10.png',
                            'weight'  => 350
                            ),

                      array(
                            'path'     => 'civicrm',
                            'title'    => ts('CiviCRM'),
                            'access'   => CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'callback' => 'civicrm_invoke',
                            'type'     => CRM_UTILS_MENU_NORMAL_ITEM,
                            'crmType'  => CRM_UTILS_MENU_CALLBACK,
                            'weight'   => 0,
                            ),

                      array( 
                            'path'    => 'civicrm/quickreg', 
                            'title'   => ts( 'Quick Registration' ), 
                            'access'  => 1,
                            'type'    => CRM_UTILS_MENU_CALLBACK,  
                            'crmType' => CRM_UTILS_MENU_CALLBACK,  
                            'weight'  => 0,  
                            ),

                      array(
                            'path'    => 'civicrm/contact/search',
                            'title'   => ts('Contacts'),
                            'qs'      => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_ROOT_LOCAL_TASK,
                            'access'  => CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'weight'  => 10,
                            ),
        
                      array(
                            'path'    => 'civicrm/contact/search/basic',
                            'title'   => ts('Find Contacts'),
                            'qs'      => 'reset=1',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_DEFAULT_LOCAL_TASK| CRM_UTILS_MENU_NORMAL_ITEM,
                            'access'  => CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'weight'  => 0
                            ),

                      array(
                            'path'    => 'civicrm/contact/search/advanced',
                            'qs'      => 'force=1',
                            'title'   => ts('Advanced Search'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'weight'  => 1
                            ),
                      array(
                            'path'   => 'civicrm/contact/addI',
                            'title'  => ts('New Individual'),
                            'qs'     => 'reset=1',
                            'access' => CRM_Utils_System::checkPermission('add contacts') &&
                                        CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_CALLBACK,
                            'weight' => 1
                            ),
        
                      array(
                            'path'   => 'civicrm/contact/addO',
                            'title'  => ts('New Organization'),
                            'qs'     => 'reset=1',
                            'access' => CRM_Utils_System::checkPermission('add contacts') &&
                                        CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_CALLBACK,
                            'weight' => 1
                            ),
        
                      array(
                            'path'   => 'civicrm/contact/addH',
                            'title'  => ts('New Household'),
                            'qs'     => 'reset=1',
                            'access' => CRM_Utils_System::checkPermission('add contacts') &&
                                        CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_CALLBACK,
                            'weight' => 1
                            ),
        
                      array(
                            'path'    => 'civicrm/contact/view',
                            'qs'      => 'reset=1&cid=%%cid%%',
                            'title'   => ts('View Contact'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_ROOT_LOCAL_TASK,
                            'weight'   => 0,
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/basic',
                            'qs'      => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Contact Summary'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_DEFAULT_LOCAL_TASK,
                            'weight'  => 0
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/activity',
                            'qs'      => 'show=1&reset=1&cid=%%cid%%',
                            'title'   => ts('Activities'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'weight'  => 2
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/rel',
                            'qs'      => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Relationships'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'weight'  => 3
                            ),
        
                      array(
                            'path'    => 'civicrm/contact/view/group',
                            'qs'      => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Groups'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'weight'  => 4
                            ),
                      
                      array(
                            'path'    => 'civicrm/contact/view/note',
                            'qs'      => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Notes'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'weight'  => 5
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/tag',
                            'qs'      => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Tags'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_LOCAL_TASK,
                            'weight'  => 6
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/cd',
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'   => 'civicrm/group',
                            'title'  => ts('Manage Groups'),
                            'qs'     => 'reset=1',
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_NORMAL_ITEM,
                            'access' => CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'weight' => 20,
                            ),

                      array(
                            'path'   => 'civicrm/group/search',
                            'title'  => ts('Group Members'),
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType'=> CRM_UTILS_MENU_CALLBACK,
                            ),
        
                      array(
                            'path'    => 'civicrm/group/add',
                            'title'   => ts('Create New Group'),
                            'access' => CRM_Utils_System::checkPermission('edit groups') &&
                            CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_CALLBACK,
                            'weight'  => 0,
                            ),
        
                      array(
                            'path'   => 'civicrm/import',
                            'title'  => ts( 'Import' ),
                            'qs'     => 'reset=1',
                            'access' => CRM_Utils_System::checkPermission('administer CiviCRM') &&
                                        CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                            'type'   =>  CRM_UTILS_MENU_CALLBACK,
                            'crmType'=>  CRM_UTILS_MENU_NORMAL_ITEM,
                            'weight' =>  400,
                            ),
                      array( 
                             'path'    => 'civicrm/import/contact',
                             'qs'      => 'reset=1',
                             'title'   => ts( 'Contacts' ), 
                             'access'  => CRM_Utils_System::checkPermission('administer CiviCRM') &&
                                          CRM_Utils_System::checkPermission( 'access CiviCRM' ), 
                             'type'    => CRM_UTILS_MENU_CALLBACK,  
                             'crmType' => CRM_UTILS_MENU_NORMAL_ITEM,  
                             'weight'  => 410,
                             ),
                       array( 
                             'path'    => 'civicrm/import/activityHistory', 
                             'qs'      => 'reset=1',
                             'title'   => ts( 'Activity History' ), 
                             'access'  => CRM_Utils_System::checkPermission('administer CiviCRM') &&
                                          CRM_Utils_System::checkPermission( 'access CiviCRM' ),
                             'type'    => CRM_UTILS_MENU_CALLBACK,  
                             'crmType' => CRM_UTILS_MENU_NORMAL_ITEM,  
                             'weight'  => 420,  
                             ),

                      array(
                            'path'   => 'civicrm/export/contact',
                            'title'  => ts('Export Contacts'),
                            'type'   => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_CALLBACK,
                            'weight'  => 0,
                            ),
                      
                      array(
                            'path'    => 'civicrm/history/activity/detail',
                            'title'   => ts('Activity Detail'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/history/activity/delete',
                            'title'   => ts('Delete Activity'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/history/email',
                            'title'   => ts('Sent Email Message'),
                            'type'    => CRM_UTILS_MENU_CALLBACK,
                            'crmType' => CRM_UTILS_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/profile',
                            'title'   => ts( 'Contact Information' ),
                            'access'  => CRM_Utils_System::checkPermission( 'profile listings and forms'),
                            'type'    => CRM_UTILS_MENU_CALLBACK, 
                            'crmType' => CRM_UTILS_MENU_CALLBACK, 
                            'weight'  => 0, 
                            ),

                      array(
                            'path'    => 'civicrm/profile/create',
                            'title'   => ts( 'Add Contact Information' ),
                            'access'  => CRM_Utils_System::checkPermission( 'profile listings and forms'),
                            'type'    => CRM_UTILS_MENU_CALLBACK, 
                            'crmType' => CRM_UTILS_MENU_CALLBACK, 
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/profile/note',
                            'title'   => ts( 'Notes about the Person' ),
                            'access'  => CRM_Utils_System::checkPermission( 'profile listings and forms'),
                            'type'    => CRM_UTILS_MENU_CALLBACK, 
                            'crmType' => CRM_UTILS_MENU_CALLBACK, 
                            'weight'  => 0,
                            ),

                      );

            $config =& CRM_Core_Config::singleton( );
            if (  in_array( 'CiviContribute', $config->enableComponents) ) {
                require_once 'CRM/Contribute/Menu.php';
                $items =& CRM_Contribute_Menu::main( );
                $GLOBALS['_CRM_UTILS_MENU']['_items'] = array_merge( $GLOBALS['_CRM_UTILS_MENU']['_items'], $items );
            }

            if ( in_array( 'CiviMail', $config->enableComponents) ) { 
                require_once 'CRM/Mailing/Menu.php';
                $items =& CRM_Mailing_Menu::main( );
                $GLOBALS['_CRM_UTILS_MENU']['_items'] = array_merge( $GLOBALS['_CRM_UTILS_MENU']['_items'], $items );
            }
            
            CRM_Utils_Menu::initialize( );
        }
        
        return $GLOBALS['_CRM_UTILS_MENU']['_items'];
    }

    /**
     * create the local tasks array based on current url
     *
     * @param string $path current url path
     * 
     * @return void
     * @access static
     */
     function createLocalTasks( $path ) {
        CRM_Utils_Menu::items( );

        $config =& CRM_Core_Config::singleton( );
        if ( $config->userFramework == 'Mambo' ) {
            
            if ( ! $GLOBALS['_CRM_UTILS_MENU']['processed'] ) {                
                $GLOBALS['_CRM_UTILS_MENU']['processed'] = true;
                foreach ( $GLOBALS['_CRM_UTILS_MENU']['_items'] as $key => $item ) {
                    if ( $item['path'] == $path ) {
                        CRM_Utils_System::setTitle( $item['title'] );
                        break;
                    }
                }
            }
        }

        foreach ( $GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'] as $root => $dontCare ) {
            if ( strpos( $path, $GLOBALS['_CRM_UTILS_MENU']['_items'][$root]['path'] ) !== false ) {
                $localTasks = array( );
                foreach ( $GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'][$root]['children'] as $dontCare => $item ) {
                    $index = $item['index'];
                    $klass = '';
                    if ( strpos( $path, $GLOBALS['_CRM_UTILS_MENU']['_items'][$index]['path'] ) !== false ||
                         ( $GLOBALS['_CRM_UTILS_MENU']['_items'][$root ]['path'] == $path && CRM_Utils_Array::value( 'isDefault', $item ) ) ) {
                        $extra = CRM_Utils_Array::value( 'extra', $GLOBALS['_CRM_UTILS_MENU']['_items'][$index] );
                        if ( $extra ) {
                            foreach ( $extra as $k => $v ) {
                                if ( CRM_Utils_Array::value( $k, $_GET ) == $v ) {
                                    $klass = 'active';
                                }
                            }
                        } else {
                            $klass = 'active';
                        }
                    }
                    $qs  = CRM_Utils_Array::value( 'qs', $GLOBALS['_CRM_UTILS_MENU']['_items'][$index] );
                    if ( $GLOBALS['_CRM_UTILS_MENU']['_params'] ) {
                        foreach ( $GLOBALS['_CRM_UTILS_MENU']['_params'] as $n => $v ) {
                            $qs = str_replace( "%%$n%%", $v, $qs );
                        }
                    }
                    $url = CRM_Utils_System::url( $GLOBALS['_CRM_UTILS_MENU']['_items'][$index]['path'], $qs );
                    $localTasks[$GLOBALS['_CRM_UTILS_MENU']['_items'][$index]['weight']] =
                        array(
                              'url'    => $url, 
                              'title'  => $GLOBALS['_CRM_UTILS_MENU']['_items'][$index]['title'],
                              'class'  => $klass
                              );
                }
                ksort( $localTasks );
                $template =& CRM_Core_Smarty::singleton( );
                $template->assign_by_ref( 'localTasks', $localTasks );
                return;
            }
        }
    }

    /**
     * Add an item to the menu array
     *
     * @param array $item a menu item with the appropriate menu properties
     *
     * @return void
     * @access public
     * @static
     */
     function add( &$item ) {
        // make sure the menu system is initialized before we add stuff to it
        CRM_Utils_Menu::items( );

        $GLOBALS['_CRM_UTILS_MENU']['_items'][] = $item;
        CRM_Utils_Menu::initialize( );
    }

    /**
     * Add a key, value pair to the params array
     *
     * @param string $key  
     * @param string $value
     *
     * @return void
     * @access public
     * @static
     */
     function addParam( $key, $value ) {
        if ( ! $GLOBALS['_CRM_UTILS_MENU']['_params'] ) {
            $GLOBALS['_CRM_UTILS_MENU']['_params'] = array( );
        }
        $GLOBALS['_CRM_UTILS_MENU']['_params'][$key] = $value;
    }

    /**
     * intialize various objects in the meny array to make further processing simpler
     *
     * @return void
     * @static
     * @access private
     */
     function initialize( ) {
        $GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'] = array( );
        for ( $i = 0; $i < count( $GLOBALS['_CRM_UTILS_MENU']['_items'] ); $i++ ) {
            // this item is a root_local_task and potentially more
            if ( ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_UTILS_MENU']['_items'][$i] ) & CRM_UTILS_MENU_ROOT_LOCAL_TASK) &&
                 ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_UTILS_MENU']['_items'][$i] ) >= CRM_UTILS_MENU_ROOT_LOCAL_TASK) ) {
                $GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'][$i] = array(
                                                   'root'     => $i,
                                                   'children' => array( )
                                                   );
            } else if ( ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_UTILS_MENU']['_items'][$i] ) &  CRM_UTILS_MENU_LOCAL_TASK) &&
                        ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_UTILS_MENU']['_items'][$i] ) >= CRM_UTILS_MENU_LOCAL_TASK) ) {
                // find parent of the local task
                foreach ( $GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'] as $root => $dontCare ) {
                    if ( strpos( $GLOBALS['_CRM_UTILS_MENU']['_items'][$i]['path'], $GLOBALS['_CRM_UTILS_MENU']['_items'][$root]['path'] ) !== false &&
                         CRM_Utils_Array::value( 'access', $GLOBALS['_CRM_UTILS_MENU']['_items'][$i], true ) ) {
                        $isDefault =
                            ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_UTILS_MENU']['_items'][$i] ) == CRM_UTILS_MENU_DEFAULT_LOCAL_TASK) ? true : false;
                        $GLOBALS['_CRM_UTILS_MENU']['_rootLocalTasks'][$root]['children'][] = array( 'index'     => $i,
                                                                             'isDefault' => $isDefault );
                    }
                }
            }
        }
    }


    /**
     * Get children for a particular menu path sorted by ascending weight
     *
     * @param  string        $path  parent menu path
     * @param  int|array     $type  menu types
     *
     * @return array         $menus
     *
     * @static
     * @access public
     */
      function getChildren($path, $type)
    {

        $childMenu = array();

        $path = trim($path, '/');

        // since we need children only
        $path .= '/';
        
        foreach (CRM_Utils_Menu::items() as $menu) {
            if (strpos($menu['path'], $path) === 0) {
                // need to add logic for menu types
                $childMenu[] = $menu;
            }
        }
        return $childMenu;
    }


    /**
     * Get max weight for a path
     *
     * @param  string $path  parent menu path
     *
     * @return int    max weight for the path           
     *
     * @static
     * @access public
     */
      function getMaxWeight($path)
    {

        $path = trim($path, '/');

        // since we need children only
        $path .= '/';

        $maxWeight  = -1024;   // weights can have -ve numbers hence cant initialize it to 0
        $firstChild = true;

        foreach (CRM_Utils_Menu::items() as $menu) {
            if (strpos($menu['path'], $path) === 0) {
                if ($firstChild) {
                    // maxWeight is initialized to the weight of the first child
                    $maxWeight = $menu['weight'];
                    $firstChild = false;
                } else {
                    $maxWeight = ($menu['weight'] > $maxWeight) ? $menu['weight'] : $maxWeight;
                }
            }
        }

        return $maxWeight;
    }


}

?>

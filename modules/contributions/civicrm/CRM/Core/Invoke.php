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
 * Given an argument list, invoke the appropriate CRM function
 * Serves as a wrapper between the UserFrameWork and Core CRM
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */


class CRM_Core_Invoke {
    
    /**
     * This is the main function that is called on every click action and based on the argument
     * respective functions are called
     *
     * @param $args array this array contains the arguments of the url 
     * 
     * @static
     * @access public
     */    
     function invoke( $args ) {
        require_once 'CRM/Core/I18n.php';
        require_once 'CRM/Utils/Wrapper.php';
        require_once 'CRM/Core/Action.php';
        require_once 'CRM/Utils/Request.php';

        if ( $args[0] !== 'civicrm' ) {
            return;
        }

        $config =& CRM_Core_Config::singleton( );

        // also initialize the i18n framework
        $i18n   =& CRM_Core_I18n::singleton( );

        if ( $config->userFramework == 'Mambo' ) {
            require_once 'CRM/Core/Mambo.php';
            CRM_Core_Mambo::sidebarLeft( );
        }

        switch ( $args[1] ) {

        case 'contact'  : 
            CRM_Core_Invoke::contact ( $args );
            break;

        case 'admin'    : 
            CRM_Core_Invoke::admin   ( $args );
            break;

        case 'history'  : 
            CRM_Core_Invoke::history ( $args );
            break;

        case 'group'    : 
            CRM_Core_Invoke::group   ( $args );
            break;

        case 'import'   : 
            CRM_Core_Invoke::import  ( $args );
            break;
       
        case 'export'   : 
            CRM_Core_Invoke::export  ( $args );
            break;

        case 'activity' : 
            CRM_Core_Invoke::activity( $args );
            break;

        case 'profile'  : 
            CRM_Core_Invoke::profile ( $args );
            break;
        
        case 'server'   : 
            CRM_Core_Invoke::server ( $args );
            break;

        case 'mailing'  :
            require_once 'CRM/Mailing/Invoke.php';
            CRM_Mailing_Invoke::main( $args );
            break;

        case 'contribute' :
            require_once 'CRM/Contribute/Invoke.php';
            CRM_Contribute_Invoke::main( $args );
            break;

        default         :
            CRM_Utils_System::redirect( CRM_Utils_System::url( 'civicrm/contact/search/basic', 'reset=1' ) );
            break;

        }

        return;
    }

    /**
     * This function contains the actions for arg[1] = contact
     *
     * @param $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function contact( $args ) {
       
        //code added for testing ajax
        if ($args[2] == 'test') {
            $wrapper =& new CRM_Utils_Wrapper( );
            return $wrapper->run( 'CRM_Contact_Form_Test', ts('Test Ajax Page'), $action );
        }

        $session =& CRM_Core_Session::singleton();
        
        $breadCrumbPath = CRM_Utils_System::url( 'civicrm/contact/search/basic', 'force=1' );
       if ($session->get('isAdvanced')) {
           $breadCrumbPath = CRM_Utils_System::url( 'civicrm/contact/search/advanced', 'force=1' );
       }
       
        $additionalBreadCrumb = "<a href=\"$breadCrumbPath\">" . ts('Search Results') . '</a>';
       
        if ( $args[1] !== 'contact' ) {
            return;
        }

        if ( substr( $args[2], 0, 3 ) == 'add' ) {
            return CRM_Core_Invoke::form( CRM_CORE_ACTION_ADD );
        }
        
        if ( $args[2] == 'domain' ) {
            $session =& CRM_Core_Session::singleton();
            $session->pushUserContext( CRM_Utils_System::url('civicrm/contact/domain', 'action=view' ) );
            $wrapper =& new CRM_Utils_Wrapper( );
            return $wrapper->run( 'CRM_Contact_Form_Domain', ts('Domain Information Page'), null);
        }
        
        if ( $args[2] == 'email' ) {
            // set the userContext stack
            $session =& CRM_Core_Session::singleton();
            $session->pushUserContext( CRM_Utils_System::url('civicrm/contact/view/activity', 'action=browse' ) );

            $wrapper =& new CRM_Utils_Wrapper( );
            return $wrapper->run( 'CRM_Contact_Form_Task_Email', ts('Email a Contact'),  null );
        }

        if ($args[2] == 'view') {
            
            CRM_Utils_System::appendBreadCrumb( $additionalBreadCrumb );
            $thirdArg = CRM_Utils_Array::value( 3, $args, '' );
            $fourthArg = CRM_Utils_Array::value(4, $args, 0);
            
            switch ( $thirdArg ) {
            case 'contribution':
                require_once 'CRM/Contact/Page/View/Contribution.php'; 
                $view =& new CRM_Contact_Page_View_Contribution( );
                break;

            case 'note':
                require_once 'CRM/Contact/Page/View/Note.php';
                $view =& new CRM_Contact_Page_View_Note( );
                break;

            case 'rel':
                require_once 'CRM/Contact/Page/View/Relationship.php';
                $view =& new CRM_Contact_Page_View_Relationship( );
                break;

            case 'group':
                require_once 'CRM/Contact/Page/View/GroupContact.php';
                $view =& new CRM_Contact_Page_View_GroupContact( );
                break;

            case 'tag':
                require_once 'CRM/Contact/Page/View/Tag.php';
                $view =& new CRM_Contact_Page_View_Tag( );
                break;
            
            case 'cd':
                require_once 'CRM/Contact/Page/View/CustomData.php';
                $view =& new CRM_Contact_Page_View_CustomData( );
                break;

            case 'activity':
                $activityId = CRM_Utils_Request::retrieve('activity_id', $form);
                $show = CRM_Utils_Request::retrieve('show', $form);

                $session =& CRM_Core_Session::singleton();
                
                if(!$show) {
                    if ($activityId)  {
                        $session->set('activityId', $activityId);
                    } else {
                        $activityId = $session->get('activityId');
                    }
                }

                if ($activityId == 1) {
                    require_once 'CRM/Contact/Page/View/Meeting.php';
                    $view =& new CRM_Contact_Page_View_Meeting( );
                } elseif($activityId == 2) {
                    require_once 'CRM/Contact/Page/View/Phonecall.php';
                    $view =& new CRM_Contact_Page_View_Phonecall( );
                } elseif($activityId == 3) {
                    $details = CRM_Utils_Request::retrieve('details', $form);
                    if ($details) {
                        require_once 'CRM/Contact/Page/View/Email.php';
                        $view =& new CRM_Contact_Page_View_Email('View Email Details'); 
                    } else {
                        $session->pushUserContext( CRM_Utils_System::url('civicrm/contact/view/activity', 'action=browse' ) );
                        $wrapper =& new CRM_Utils_Wrapper( );
                        return $wrapper->run( 'CRM_Contact_Form_Task_Email', ts('Email a Contact'),  null );
                    }
                } elseif ($activityId == 4 ) {
                    require_once 'CRM/Contact/Page/View/SMS.php';
                    $view =& new CRM_Contact_Page_View_SMS( );
                } elseif ($activityId > 3 ) {
                    require_once 'CRM/Contact/Page/View/OtherActivity.php';
                    $view =& new CRM_Contact_Page_View_OtherActivity( );
                } else {
                    require_once 'CRM/Contact/Page/View/Activity.php';
                    $view =& new CRM_Contact_Page_View_Activity( );
                }

                break;
                
            case 'vcard':
                require_once 'CRM/Contact/Page/View/Vcard.php';
                $view =& new CRM_Contact_Page_View_Vcard();
                break;

            case 'delete':
                $wrapper =& new CRM_Utils_Wrapper( ); 
                return $wrapper->run( 'CRM_Contact_Form_Task_Delete', ts('Delete Contact'),  null ); 
            
            default:
                require_once 'CRM/Contact/Page/View/Basic.php';
                $view =& new CRM_Contact_Page_View_Basic( );
                break;
            }
            return $view->run( );
        }
        
        if ( $args[2] == 'search' ) {
            return CRM_Core_Invoke::search( $args );
        }
        
        return CRM_Utils_System::redirect( CRM_Utils_System::url('civicrm/contact/search/basic', 'reset=1', true) );
    }


    /**
     * This function contains the actions for search arguments
     *
     * @param $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function search( $args ) {
        $session =& CRM_Core_Session::singleton( );
        $thirdArg = CRM_Utils_Array::value( 3, $args, '' );

        if ( $thirdArg == 'advanced' ) {
            // advanced search
            $mode  = CRM_CORE_ACTION_ADVANCED;
            $title = ts('Advanced Search');
            $url   = 'civicrm/contact/search/advanced';
        } else if ( $thirdArg == 'map' ) {
            // set the userContext stack
            $session =& CRM_Core_Session::singleton();
            $session->pushUserContext( CRM_Utils_System::url('civicrm/contact/search/basic' ) );

            $wrapper =& new CRM_Utils_Wrapper( );
            return $wrapper->run( 'CRM_Contact_Form_Task_Map', ts('Map Contact'),  null );
        } else if ( $thirdArg == 'ymap' ) {
            // set the userContext stack
            $session =& CRM_Core_Session::singleton();
            $session->pushUserContext( CRM_Utils_System::url('civicrm/contact/search/basic' ) );

            $wrapper =& new CRM_Utils_Wrapper( );
            return $wrapper->run( 'CRM_Contact_Form_Task_YMap', ts('YMap Contact'),  null );
        } else {
            $mode  = CRM_CORE_ACTION_BASIC;
            $title = ts('Search');
            $url   = 'civicrm/contact/search/basic';
        }
        require_once 'CRM/Contact/Controller/Search.php';
        $controller =& new CRM_Contact_Controller_Search($title, $mode);
        $session->pushUserContext(CRM_Utils_System::url($url, 'force=1'));
        return $controller->run();
    }
    
    /**
     * This function contains the default action
     *
     * @param $action 
     *
     * @static
     * @access public
     */
     function form( $action ) {
        CRM_Utils_System::setUserContext( array( 'civicrm/contact/search/basic', 'civicrm/contact/view' ) );
        $wrapper =& new CRM_Utils_Wrapper( );
        $wrapper->run( 'CRM_Contact_Form_Edit', ts('Contact Page'), $action );
    }
    
    /**
     * This function contains the actions for history arguments
     *
     * @param $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function history( $args ) {
        if ( $args[2] == 'activity' && $args[3] == 'detail' ) {
            require_once 'CRM/History/Page/Activity.php';
            $page =& new CRM_History_Page_Activity('View Activity Details');
            return $page->run( );
        }

        if ($args[2] == 'email') {
            require_once 'CRM/History/Page/Email.php';
            $page =& new CRM_History_Page_Email('View Email Details');
            return $page->run( );
        }
    }


    /**
     * This function contains the actions for admin arguments
     *
     * @param $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function admin( $args ) {
        if ( $args[1] !== 'admin' ) {
            return;
        }

        $view = null;
        switch ( CRM_Utils_Array::value( 2, $args, '' ) ) {
            
        case 'access':
            CRM_Utils_System::redirect( CRM_Utils_System::url( 'admin/access' ) );
            break;

        case 'locationType':
            require_once 'CRM/Admin/Page/LocationType.php';
            $view =& new CRM_Admin_Page_LocationType(ts('View Location Types'));
            break;

        case 'activityType':
            require_once 'CRM/Admin/Page/ActivityType.php';
            $view =& new CRM_Admin_Page_ActivityType(ts('View Activity Types'));
            break;

        case 'IMProvider':
            require_once 'CRM/Admin/Page/IMProvider.php';
            $view =& new CRM_Admin_Page_IMProvider(ts('View Instant Messenger Providers'));
            break;

        case 'mobileProvider':
            require_once 'CRM/Admin/Page/MobileProvider.php';
            $view =& new CRM_Admin_Page_MobileProvider(ts('View Mobile Providers'));
            break;

        case 'reltype':
            require_once 'CRM/Admin/Page/RelationshipType.php';
            $view =& new CRM_Admin_Page_RelationshipType(ts('View Relationship Types'));
            break;

        case 'custom':
            if ( $args[3] == 'group' ) {
                if ( CRM_Utils_Array::value( 4, $args ) != 'field' ) {
                    require_once 'CRM/Custom/Page/Group.php';
                    $view =& new CRM_Custom_Page_Group(ts('Custom Data Group'));
                } else {
                    if ( CRM_Utils_Array::value( 5, $args ) != 'option' ) {
                        require_once 'CRM/Custom/Page/Field.php';
                        $view =& new CRM_Custom_Page_Field(ts('Custom Data Field'));
                    } else {
                        require_once 'CRM/Custom/Page/Option.php';
                        $view =& new CRM_Custom_Page_Option(ts('Custom Data Field'));
                        $url  = CRM_Utils_System::url( 'civicrm/admin/custom/group/field' );
                        $additionalBreadCrumb = '<a href="' . $url . '">' . ts('Custom Data Fields') . '</a>';
                        CRM_Utils_System::appendBreadCrumb( $additionalBreadCrumb );
                    }
                }
            }
            break;

        case 'uf':
            if ( $args[3] == 'group' ) {
                if ( CRM_Utils_Array::value( 4, $args ) != 'field' ) {
                    require_once 'CRM/UF/Page/Group.php';
                    $view =& new CRM_UF_Page_Group(ts('CiviCRM Profile Group'));
                } else {
                    require_once 'CRM/UF/Page/Field.php';
                    $view =& new CRM_UF_Page_Field(ts('CiviCRM Profile Field'));
                }
            }
            break;

        case 'tag':
            require_once 'CRM/Admin/Page/Tag.php';
            $view =& new CRM_Admin_Page_Tag(ts('View Tags'));
            break;

        case 'prefix':
            require_once 'CRM/Admin/Page/IndividualPrefix.php';
            $view =& new CRM_Admin_Page_IndividualPrefix(ts('View Individual Prefix'));
            break;
            
        case 'suffix':
            require_once 'CRM/Admin/Page/IndividualSuffix.php';
            $view =& new CRM_Admin_Page_IndividualSuffix(ts('View Individual Suffix'));
            break;
                
        case 'gender':
            require_once 'CRM/Admin/Page/Gender.php';
            $view =& new CRM_Admin_Page_Gender(ts('View Gender'));
            break;   

        case 'synchUser':
            require_once 'CRM/Admin/Page/DrupalUser.php';
            $view =& new CRM_Admin_Page_DrupalUser(ts('Sync Drupal Users'));
            break;   

        case 'backup':
            require_once 'CRM/Admin/Page/DomainDump.php';
            $view =& new CRM_Admin_Page_DomainDump(ts('Backup Database'));
            break;   
            
        case 'dupematch':
            require_once 'CRM/Admin/Page/DupeMatch.php';
            $view =& new CRM_Admin_Page_DupeMatch(ts('Duplicate Matching'));
            break;   

        case 'contribute':
            require_once 'CRM/Contribute/Invoke.php';
            return CRM_Contribute_Invoke::admin( $args );
            
        default:
            require_once 'CRM/Admin/Page/Admin.php';
            $view =& new CRM_Admin_Page_Admin(ts('Administer CiviCRM'));
            break;
        }

        if ( $view ) {
            return $view->run( );
        }

        return CRM_Utils_System::redirect( CRM_Utils_System::url('civicrm/contact/search/basic', 'reset=1', false) );
    }

    /**
     * This function contains the action for import arguments
     *
     * @params $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function import( $args ) {
        
        if ($args[2] == 'activityHistory' ) {
            require_once 'CRM/History/Import/Controller.php';
            $controller =& new CRM_History_Import_Controller(ts('Import Activity History'));
        } else {
            require_once 'CRM/Import/Controller.php';
            $controller =& new CRM_Import_Controller(ts('Import Contacts'));
        }
            return $controller->run();
    }


    /**
     * This function contains the actions for group arguments
     *
     * @params $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function group( $args ) {
        if ( $args[1] !== 'group' ) {
            return;
        }

        switch ( CRM_Utils_Array::value( 2, $args ) ) {
        case 'add':
            require_once 'CRM/Group/Controller.php';
            $controller =& new CRM_Group_Controller(ts('Groups'), CRM_CORE_ACTION_ADD);
            $session =& CRM_Core_Session::singleton( );
            $session->pushUserContext(CRM_Utils_System::url('civicrm/group', 'reset=1'));
            return $controller->run();

        case 'search':
            return CRM_Core_Invoke::search( $args );

        default:
            require_once 'CRM/Group/Page/Group.php';
            $view =& new CRM_Group_Page_Group(ts('View Groups'));
            return $view->run();
        }
    }
    
    /** 
     * This function contains the actions for profile arguments 
     * 
     * @param $args array this array contains the arguments of the url 
     * 
     * @static 
     * @access public 
     */ 
     function profile( $args ) { 
        if ( $args[1] !== 'profile' ) { 
            return; 
        } 

        $secondArg = CRM_Utils_Array::value( 2, $args, '' ); 

        if ($secondArg == 'view') {
            $session =& CRM_Core_Session::singleton();
            require_once 'CRM/Profile/Page/View.php';
            $view =& new CRM_Profile_Page_View();
            return $view->run();
        }

        
        if ( $secondArg == 'edit' || $secondArg == 'create' ) {
            // set the userContext stack
            $session =& CRM_Core_Session::singleton(); 
            $session->pushUserContext( CRM_Utils_System::url('civicrm/profile/edit', 'reset=1' ) ); 

            $userID = $session->get( 'userID' );
            if ( $userID ) {
                $controller =& new CRM_Core_Controller_Simple( 'CRM_Profile_Form_Edit', ts('Create Profile'), $action );
                $controller->set( 'id', $userID );
                $controller->process( );
                return $controller->run( );
            } else {
                $wrapper =& new CRM_Utils_Wrapper( ); 
                return $wrapper->run( 'CRM_Profile_Form_Edit', ts( 'Create Profile' ), CRM_CORE_ACTION_ADD );
            } 
        } 

        if ( $secondArg == 'note' ) {
            // set the userContext stack 
            $session =& CRM_Core_Session::singleton();  
            $session->pushUserContext( CRM_Utils_System::url('civicrm/profile/create', 'reset=1' ) );  

            $page =& new CRM_Profile_Page_Note( );
            return $page->run( );
        }

        if ( $secondArg == 'dojo' ) { 
            // set the userContext stack  
            $session =& CRM_Core_Session::singleton();   
            $session->pushUserContext( CRM_Utils_System::url('civicrm/profile/create', 'reset=1' ) );   
 
            $wrapper =& new CRM_Utils_Wrapper( );  
            return $wrapper->run( 'CRM_Profile_Form_Dojo', ts( 'Create Profile' ), CRM_CORE_ACTION_ADD ); 
        } 

        require_once 'CRM/Profile/Page/Listings.php';
        $page =& new CRM_Profile_Page_Listings( );
        return $page->run( );
    }

    /**
     * handle the export case. this is a hack, so please fix soon
     *
     * @param $args array this array contains the arguments of the url
     *
     * @static
     * @access public
     */
     function export( $args ) {
        // FIXME:  2005-06-22 15:17:33 by Brian McFee <brmcfee@gmail.com>
        // This function is a dirty, dirty hack.  It should live in its own
        // file.
        $session =& CRM_Core_Session::singleton();
        $type = $_GET['type'];
        
        if ($type == 1) {
            $varName = 'errors';
            $saveFileName = 'Import_Errors.csv';
        } else if ($type == 2) {
            $varName = 'conflicts';
            $saveFileName = 'Import_Conflicts.csv';
        } else if ($type == 3) {
            $varName = 'duplicates';
            $saveFileName = 'Import_Duplicates.csv';
        } else if ($type == 4) {
            $varName = 'mismatch';
            $saveFileName = 'Import_Mismatch.csv';
        }else {
            /* FIXME we should have an error here */
            return;
        }
        
        // FIXME: a hack until we have common import
        // mechanisms for contacts and contributions
        $realm = $_GET['realm'];
        if ($realm == 'contribution') {
            $importController = 'CRM_Contribute_Import_Controller';
        } else if ( $realm == 'history' ) {
            $importController = 'CRM_History_Import_Controller';
        } else {
            $importController = 'CRM_Import_Controller';
        }
        
        $fileName = $session->get($varName . 'FileName', $importController);
        $config =& CRM_Core_Config::singleton( ); 

        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Length: ' . filesize($fileName) );
        header('Content-Disposition: attachment; filename=' . $saveFileName);

        readfile($fileName);
        
        exit();
    }


    /**
     * This function contains the action for server pages (ajax)
     *
     * @params $args array this array contains the arguments of the url 
     *
     * @static
     * @access public
     */
     function server( $args ) {

        //this code is for state country widget
        if ($args[2] == 'stateCountry') {
            require_once 'CRM/Contact/Page/StateCountryServer.php';
            $server =& new CRM_Contact_Page_StateCountryServer( );
            $set = CRM_Utils_Request::retrieve('set', $form);
            if ($set) {
                $path = CRM_Utils_Request::retrieve('path', $form );
                $path= '?q='.$path;
                $session =& CRM_Core_Session::singleton( );
                $session->set('path', $path);
            }
            return $server->run( $set );
        }

        //this code is for search widget
        if ($args[2] == 'search') {
            require_once 'CRM/Contact/Page/SearchServer.php';
            $server =& new CRM_Contact_Page_SearchServer( );
            $set = CRM_Utils_Request::retrieve('set', $form);
            if ($set) {
                $path = CRM_Utils_Request::retrieve('path', $form );
                $path= '?q='.$path;
                $session =& CRM_Core_Session::singleton( ); 
                $session->set('path', $path);
            }
            return $server->run( $set );
        }

        //this code is for uf help text
        if ($args[2] == 'uf') {
            require_once 'CRM/UF/Page/UFServer.php';
            $server =& new CRM_UF_Page_UFServer( );
            $set = CRM_Utils_Request::retrieve('set', $form);
            if ($set) {
                $path = CRM_Utils_Request::retrieve('path', $form );
                $path= '?q='.$path;
                $session =& CRM_Core_Session::singleton( ); 
                $session->set('path', $path);
            }
            return $server->run( $set );
        }
    }

     function onlySSL( $args ) {
        if ( $args[1] = 'contribute' && $args[2] == 'transact' ) {
            return true;
        }
        return false;
    }

}

?>

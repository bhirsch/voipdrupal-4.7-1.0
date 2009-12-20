<?php

/*
 * Return codes from og_xmlrpc functions
 */
 
define('OG_XMLRPC_SUCCESS', 1);
define('OG_XMLRPC_PROCESSING_ERROR', -1);
define('OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD', -2);
define('OG_XMLRPC_INVALID_UID', -3);
define('OG_XMLRPC_NOT_A_MEMBER', -4);
define('OG_XMLRPC_NOT_ALLOWED', -5);
define('OG_XMLRPC_INVALID_GID', -6);


function og_xmlrpc_subscribe_user($username, $password, $gid, $uid) {
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) {  // only non-anonymous users can try to subscribe users
    $account = user_load(array('uid' => $uid));
    if ($account->uid) {
      // administrators can always subscribe other users	
      $node = node_load($gid);
      if (node_access('update', $node, $admin->uid)) {
        og_save_subscription($gid, $account->uid, array('is_active' => 1));
        $rc['error_code'] = OG_XMLRPC_SUCCESS;
        $rc['subscription_status'] = 'subscribed';
      } 
      // if user trying to subscribe himself...
      else if ($admin->uid == $account->uid){ 
        $r = og_subscribe_user($gid, $admin);
        $rc['error_code'] = OG_XMLRPC_SUCCESS;
        $rc['subscription_status'] = $r['type'];
      }
      // if user trying to subscribe somebody else...
      else {
      	$rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
      	$rc['error_msg'] = t('Only group administrators are allowed to subscribe other users.');
      }
    }
    else {
      $rc['error_code'] = OG_XMLRPC_INVALID_UID;
      $rc['error_msg'] = t('unrecognized user ID: %uid', array('%uid' => $uid));
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_unsubscribe_user($username, $password, $gid, $uid) {
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) {  // only non-anonymous users can try to subscribe users
    $account = user_load(array('uid' => $uid));
    if ($account->uid) {
      // administrators can always unsubscribe users
      $node = node_load($gid);
      if (node_access('update', $node, $admin->uid)) {
        og_delete_subscription($gid, $uid);
        $rc['error_code'] = OG_XMLRPC_SUCCESS;
      } 
      // if user trying to unsubscribe himself...
      else if ($admin->uid == $account->uid){ 
        $node = node_load($gid);
        if ($node->og_selective == OG_CLOSED) {
          $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
          $rc['error_msg'] = t('This is a closed-subscription group. Only group administrators are allowed to unsubscribe users.');
        }
        else {
          og_delete_subscription($gid, $uid);
          $rc['error_code'] = OG_XMLRPC_SUCCESS;
        }
      }
      // if user trying to unsubscribe somebody else...
      else {
      	$rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
      	$rc['error_msg'] = t('Only group administrators are allowed to unsubscribe other users.');
      }
    }
    else {
      $rc['error_code'] = OG_XMLRPC_INVALID_UID;
      $rc['error_msg'] = t('unrecognized user ID: %uid', array('%uid' => $uid));
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_approve($username, $password, $gid, $uid) {
// Note: this function is based on og_approve().  Should they be combined together somehow??
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) {  // only non-anonymous users can try to approve users
    $account = user_load(array('uid' => $uid));
    if ($account->uid) {
      // if admin is a member of the group
      if (in_array($gid, array_keys($admin->og_groups))) {
        // only administrators are allowed to approve subscriptions
        $node = node_load($gid);
        if (node_access('update', $node, $admin->uid)) {
          og_save_subscription($gid, $uid, array('is_active' => 1));
          $subj = t("Subscription request approved for '%title'", array('%title' => $node->title));
          $body = t('You may now post messages in this group located at %url', array('%url' => url("node/$node->nid", NULL, NULL, TRUE)));
          $from = variable_get('site_mail', ini_get('sendmail_from'));
          $headers = "From: $from\nReply-to: $from\nX-Mailer: Drupal\nReturn-path: $from\nErrors-to: $from";
          $account = user_load(array('uid' => $uid));
          user_mail($account->mail, $subj, $body, $headers);
          $rc['error_code'] = OG_XMLRPC_SUCCESS;
        } 
        else {
  	      $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
  	      $rc['error_msg'] = t('Only group administrators are allowed to approve subscriptions.');
        }
      }
      else {
        $rc['error_code'] = OG_XMLRPC_NOT_A_MEMBER;
        $rc['error_msg'] = t('User is not a member of the specified group');
      }
    }
    else {
      $rc['error_code'] = OG_XMLRPC_INVALID_UID;
      $rc['error_msg'] = t('Unrecognized user ID: %uid', array('%uid' => $uid));
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_deny($username, $password, $gid, $uid) {
// Note: this function is based on og_deny().  Should they be combined together somehow??
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) { 
    $account = user_load(array('uid' => $uid));
    if ($account->uid) {
      // check if admin is a member of the group
      if (in_array($gid, array_keys($admin->og_groups))) {
        // only administrators are allowed to deny subscriptions
        $node = node_load($gid);
        if (node_access('update', $node, $admin->uid)) {
          og_delete_subscription($gid, $uid);
          $subj = t('Subscription request denied for %title', array('%title' => $node->title));
          $body = t('Sorry, your subscription request was denied.');
          $from = variable_get('site_mail', ini_get('sendmail_from'));
          $headers = "From: $from\nReply-to: $from\nX-Mailer: Drupal\nReturn-path: $from\nErrors-to: $from";
          $account = user_load(array('uid' => $uid));
          user_mail($account->mail, $subj, $body, $headers);
          $rc['error_code'] = OG_XMLRPC_SUCCESS;
        } 
        else {
      	  $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
      	  $rc['error_msg'] = t('Only group administrators are allowed to deny subscriptions.');
        }
      }
      else {
        $rc['error_code'] = OG_XMLRPC_NOT_A_MEMBER;
        $rc['error_msg'] = t('User is not a member of the specified group');
      }
    }
    else {
      $rc['error_code'] = OG_XMLRPC_INVALID_UID;
      $rc['error_msg'] = t('Unrecognized user ID: %uid', array('%uid' => $uid));
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}


function og_xmlrpc_get_all_subscribers($username, $password, $gid, $min_is_active, $min_is_admin) {
  $rc = array();
// TODO: note: this function does not work for anonymous users... is that intentional?
  $account = user_authenticate($username, $password);
  if ($account->uid) {
    if (in_array($gid, array_keys($account->og_groups)) || user_access('administer organic groups', $account)) {
      $sql = og_list_users_sql($min_is_active, $min_is_admin);
      $result = db_query($sql, $gid);
      while ($row = db_fetch_array($result)) {
        $users[$row['uid']] = $row;
      }
      $rc['error_code'] = OG_XMLRPC_SUCCESS;
      $rc['subscribers'] = $users;
    }
    else {
      $rc['error_code'] = OG_XMLRPC_NOT_A_MEMBER;
      $rc['error_msg'] = t('User is not a member of the specified group');
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_get_user_groups($username, $password, $uid) {
  $rc = array();
  $caller = user_authenticate($username, $password);
  if ($caller->uid) {
    if ($caller->uid == $uid || user_access('administer organic groups', $caller)) {
      $rc['error_code'] = OG_XMLRPC_SUCCESS;
      $rc['subscriptions'] = og_get_subscriptions($uid);  
    }
    else {
      $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
      $rc['error_msg'] = t('User is not allowed to retrieve subscriptions for another user.');
    }
  }
  else {
    $rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

 
function og_xmlrpc_delete_group($username, $password, $gid) {
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) {
    $node = node_load($gid);
watchdog("og", "admin: " . print_r($admin, TRUE) . "\n\n node: " . print_r($node, TRUE));
    if (node_access('update', $node, $admin->uid)) {
      node_delete($gid);
      $rc['error_code'] = OG_XMLRPC_SUCCESS;
    }
    else {
      $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
      $rc['error_msg'] = t('User is not allowed to delete the specified group.');
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_create_admin($username, $password, $gid, $uid) {
// Note: this function is based on og_create_admin()
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) { 
    $account = user_load(array('uid' => $uid));
    if ($account->uid) {
      if (in_array($gid, array_keys($account->og_groups))) {
	    // only administrators can create other administators	
        $node = node_load($gid);
        if (node_access('update', $node, $admin->uid)) {
	      og_save_subscription($gid, $uid, array('is_admin' => 1));
	      $rc['error_code'] = OG_XMLRPC_SUCCESS;
	    } 
	    else {
	      $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
          $rc['error_msg'] = t('Only group administrators are allowed to create other administrators.');
		}
      }
      else {
        $rc['error_code'] = OG_XMLRPC_NOT_A_MEMBER;
        $rc['error_msg'] = t('User is not a member of the specified group');
      }
    }
    else {
      $rc['error_code'] = OG_XMLRPC_INVALID_UID;
      $rc['error_msg'] = t('unrecognized user ID: %uid', array('%uid' => $uid));
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_delete_admin($username, $password, $gid, $uid) {
// Note: this function is based on og_delete_admin()
  $rc = array();
  $admin = user_authenticate($username, $password);
  if ($admin->uid) { 
    $account = user_load(array('uid' => $uid));
    if ($account->uid) {
      // if user is a member of the group
      if (in_array($gid, array_keys($account->og_groups))) {
	    // only administrators can demote other administators	
        $node = node_load($gid);
        if (node_access('update', $node, $admin->uid)) {
	      og_save_subscription($gid, $uid, array('is_admin' => 0));
	      $rc['error_code'] = OG_XMLRPC_SUCCESS;
	    } 
	    else {
	      $rc['error_code'] = OG_XMLRPC_NOT_ALLOWED;
          $rc['error_msg'] = t('Only group administrators are allowed to delete other administrators.');
		}
      }
      else {
        $rc['error_code'] = OG_XMLRPC_NOT_A_MEMBER;
        $rc['error_msg'] = t('User is not a member of the specified group');
      }
    }
    else {
      $rc['error_code'] = OG_XMLRPC_INVALID_UID;
      $rc['error_msg'] = t('unrecognized user ID: %uid', array('%uid' => $uid));
    }
  }
  else {
  	$rc['error_code'] = OG_XMLRPC_INVALID_USER_NAME_OR_PASSWORD;
    $rc['error_msg'] = t('Wrong username or password.');
  }
  return $rc;
}

function og_xmlrpc_get_subscription_mode($gid) {
  $rc = array();
  $node = node_load($gid);
  if ((!$node) || (!og_is_group_type($node->type))) {
  	$rc['error_code'] = OG_XMLRPC_INVALID_GID;
  	$rc['error_msg'] = t('Invalid group id.');
    return $rc;
  }
  $rc['error_code'] = OG_XMLRPC_SUCCESS;
  switch ($node->og_selective) {
    case OG_MODERATED:
      $rc['subscription_mode'] = 'moderated';
      break;
    case OG_OPEN:
      $rc['subscription_mode'] = 'open';
      break;
    case OG_CLOSED:
      $rc['subscription_mode'] = 'closed';
      break;
    case OG_INVITE_ONLY:
      $rc['subscription_mode'] = 'invite only';
      break;
  }
  return $rc;
}


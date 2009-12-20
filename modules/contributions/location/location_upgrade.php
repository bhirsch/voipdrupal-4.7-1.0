<?php
// $Id: location_upgrade.php,v 1.5 2006/03/08 06:53:37 dww Exp $

/**
 * @file
 * Administrative page for handling updates from one location.module version to another.
 *
 * Copy this file to the root directory of your drupal installation.
 * Login as user 1, or disable the access checking below
 * Point your browser to "http://www.site.com/location_upgrade.php" and follow the
 * instructions.
 *
 * If you are not logged in as administrator, you will need to modify the access
 * check statement below. Change the TRUE into a FALSE to disable the access
 * check. After finishing the upgrade, be sure to open this file and change the
 * FALSE back into a TRUE!
 */

include_once "includes/bootstrap.inc";
include_once "includes/common.inc";
 
// Enable access checking?
$access_check = TRUE;

$sql_updates = array(0  => '',
                     1  => 'Mid 4.6 upgrade -- Merge location_user and location_node tables into location',
                     2  => "Mid 4.6 upgrade II -- Rename column 'exact' to 'source'",
                     3  => "Correction to zipcode data"
                    );

if (!ini_get("safe_mode")) {
  set_time_limit(180);
}

function location_upgrade_page_header($title) {
  $output = "<html><head><title>$title</title>";
  $output .= <<<EOF
      <link rel="stylesheet" type="text/css" media="print" href="misc/print.css" />
      <style type="text/css" title="layout" media="Screen">
        @import url("misc/drupal.css");
      </style>
EOF;
  $output .= "</head><body>";
  $output .= "<div id=\"logo\"><a href=\"http://drupal.org/\"><img src=\"misc/druplicon-small.png\" alt=\"Druplicon - Drupal logo\" title=\"Druplicon - Drupal logo\" /></a></div>";
  $output .= "<div id=\"update\"><h1>$title</h1>";
  return $output;
}

function location_upgrade_page_footer() {
  return "</div></body></html>";
}

function location_upgrade_page() {
  global $user, $sql_updates;

  if (isset($_POST['edit'])) {
    $edit = $_POST['edit'];
  }
  if (isset($_POST['op'])) {
    $op = $_POST['op'];
  }

  switch ($op) {
    case "Update":
      $edit = $_POST['edit'];

      if (!isset($edit['location_update_version']) || $edit['location_update_version'] == 0) { 
      
      //*****************************
        $form = form_select('Select the update after your most recent update', 'location_update_version', '', $sql_updates, 'Please select what you think was the last update for this module.  If you\'re not sure of what your last update was, it is better to select one that is older than what you think than to select one that is newer.  Updates that are too old for you will fail while the newer ones will still execute.');
        $form .= form_submit('Update');
        $form = form($form);
        print location_upgrade_page_header('location.module database update');
        print location_upgrade_info();
        print '<font color="#FF0000">You need to select your last update first!</font>'."<br/>\n";
        print $form;
        print location_upgrade_page_footer();
        break;
      //*****************************
      }
      else {
        // make sure we have updates to run.
        print location_upgrade_page_header("location.module database update");
        $links[] = "<a href=\"index.php\">main page</a>";
        $links[] = "<a href=\"index.php?q=admin\">administration pages</a>";
        print theme("item_list", $links);
      
        location_upgrade($edit['location_update_version']);

        print location_upgrade_page_footer();
      }
      break;
    default:
      $form = form_select('Select the update after your most recent update.', 'location_update_version', '', array_merge(array('' => ''), $sql_updates), 'Please select what you think was the last update for this module.  If you\'re not sure of what your last update was, it is better to select one that is older than what you think than to select one that is newer.  Updates that are too old for you will fail while the newer ones will still execute.');
      $form .= form_submit('Update');
      $form = form($form);
      print location_upgrade_page_header('location.module database update');
      print location_upgrade_info();
      print $form;
      print location_upgrade_page_footer();
      break;
  }
}

function location_upgrade($update_n) {
  global $base_url, $sql_updates;
  
  $update_keys = array_keys($sql_updates);
  $number = $update_n;
  while (in_array($number, $update_keys)) {
    print "PERFORMING UPDATE: <br/>\n";
    print '<pre>  '. $sql_updates[$number] ."</pre><br/>\n<br/>\n";
    $function = 'location_update_'. $number;
    $function();
    $number++;
  }
}

function location_upgrade_info() {
  $output = "<ul>\n";
  $output .= "<li>Use this script to <strong>update the database schema for changes to the location module</strong>.  You don't need this script when installing the location.module from scratch.</li>"."\n";
  $output .= "</ul>"."\n";
  return $output;
}

if (isset($_GET["op"])) {
  // Access check:
  if (($access_check == 0) || ($user->uid == 1)) {
    location_upgrade_page();
  }
  else {
    print location_upgrade_page_header("Access denied");
    print "Access denied.  You are not authorized to access to this page.  Please log in as the user with user ID #1. If you cannot log-in, you will have to edit <code>modules/location/location_upgrade.php</code> to by-pass this access check; in that case, open <code>modules/location/location_upgrade.php</code> in a text editor and follow the instructions at the top.";
    print location_upgrade_page_footer();
  }
}
else {
  //location_upgrade_info();
  location_upgrade_page();
}

function location_update_1() {
  db_query("ALTER TABLE {location_node} ADD type varchar(6) NOT NULL DEFAULT ''");
  db_query("UPDATE {location_node} SET type = 'node'");
  db_query("ALTER TABLE {location_node} DROP PRIMARY KEY");
  db_query("ALTER TABLE {location_node} CHANGE nid oid int(10) unsigned NOT NULL default '0'");
  db_query("ALTER TABLE {location_node} ADD PRIMARY KEY (type, oid)");
  
  $result = db_query("SELECT * FROM {location_user}");
  while ($row = db_fetch_object($result)) {
    db_query("INSERT INTO {location_node} (oid, name, street, additional, city, province, postal_code, country, latitude, longitude, exact, type) VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%f', %d, 'user')", $row->uid, $row->name, $row->street, $row->additional, $row->city, $row->province, $row->postal_code, $row->country, $row->latitude, $row->longitude, $row->exact, $row->type);
  }
  db_query("RENAME TABLE {location_node} TO {location}");
}

function location_update_2() {
  db_query("ALTER TABLE {location} CHANGE COLUMN exact source tinyint(4) default '0'");
}

function location_update_3() {
  db_query("UPDATE {zipcodes} SET city = 'North Plainfield' WHERE country = 'us' AND zip = '07060'");
}

?>

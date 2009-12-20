<?php

// $Id: template.php,v 1.2 2006/10/13 16:05:49 leob Exp $ 

/**
* Catch the theme_user_profile function, and redirect through the template api
*/

function phptemplate_user_profile($user, $fields = array()) {
  // Pass to phptemplate, including translating the parameters to an associative array. The element names are the names that the variables
  // will be assigned within your template.
  /* potential need for other code to extract field info */
  return _phptemplate_callback('user_profile', array('account' => $user, 'fields' => $fields));
}

/*************
function _phptemplate_user_profile($variables, $suggestions = NULL) {
  $user = $variables['account'];
  
  if($user->picture) {
  	$output = '<div class="picture"><img src="' . $user->picture . '"></div>';
  }
<div class="custom_profiles"> 
<?php
print_r($user);
print ("\n\n");
$output = "<h2>Latest Posts:</h2>";
$nlimit = 10;
$userid = $user->uid;
$result = db_query("SELECT n.created, n.title, n.nid, n.changed FROM node n WHERE n.uid = $userid AND n.type = 'audio' AND n.status = 1 ORDER BY n.changed DESC LIMIT $nlimit");
$output .= "<div class=\"item-list\"><ul>\n";
$list = node_title_list($result);
$output .= strip_tags($list) ? $list : 'No Blog Postings available';
$output .= "</ul></div>";
print $output;
}
***********/

?>

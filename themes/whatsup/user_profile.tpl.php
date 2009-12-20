<?php //$Id: user_profile.tpl.php,v 1.2 2006/10/17 11:38:01 leob Exp $ 
?>
<?php
  // NOTE: the formating of the following $output is based on theme_user_profile()
/********
echo "account: <br>" . print_r($account, TRUE);
print ("<p><p><p><hr>");
echo "fields: <br>" . print_r($fields, TRUE);
print ("\n\n<hr>");
*******/ 
  $output = '<div class="profile">';
  $output .= theme('user_picture', $account);
 
  global $base_url;

  // display about_me field
  $item = isset($fields[t('About me')])?$fields[t('About me')][0]:NULL;
  if ($item) {
    $output .= '<h2 class="title">'. $item['title'] .'</h2>';
    $output .= '<p class="'. $item['class'] .'">'. $item['value'] .'</p>';
  }
  
  // display telephony profile fields
  $item = isset($fields[t('Phone profile')])?$fields[t('Phone profile')][0]:NULL;
  if ($item) {
    $output .= '<h2 class="title">'. $item['title'] .'</h2>';
    $output .= '<p class="'. $item['class'] .'">'. $item['value'] .'</p>';
  }
  $item = isset($fields[t('Voicemail settings')])?$fields[t('Voicemail settings')][0]:NULL;
  if ($item) {
    $output .= '<h2 class="title">'. $item['title'] .'</h2>';
    $output .= '<fieldset>';
    $output .= '<p class="'. $item['class'] .'">'. $item['value'] .'</p>';
    $output .= '</fieldset>';
  }

  // display user's audio entries as a playlist
  $item = isset($fields[t('Personal audio playlist')])?$fields[t('Personal audio playlist')][0]:NULL;
  if ($item) {
    $output .= '<h2 class="title">'. $item['title'] .'</h2>';
    $output .= '<fieldset>';
    $output .= '<p class="'. $item['class'] .'">'. $item['value'] .'</p>';
    $output .= '</fieldset>';
  }
  
  // display user's audio entries as audioblog 
  if (isset($fields[t('History')])) {
    $history_items = $fields[t('History')];
    foreach ($history_items as $item) {
      if ($item['title'] == t('Audio')) {
        $audioblog_link = l(t("here"), 'audio/user/'. $account->uid, array('title' => t("%username's latest audioblog entries and community announcements.", array('%username' => $account->name))));
        $audioblog_link_text = t("To check %username's individual audioblog entries click %here.", array('%username' => $account->name, '%here' => $audioblog_link));
        $output .= '<h2 class="title">'. t("%username's latest audioblog entries", array('%username' => $account->name)) .'</h2>';
        $output .= '<fieldset>';
        $output .= '<p class="'. $item['class'] .'">'. $audioblog_link_text .'</p>';
        $output .= '</fieldset>';
        break;
      }
    }
  }
  
  // display voip groups user is affiliated with
  $extension_list = array();
  $groups = isset($account->og_groups)?array_keys($account->og_groups):NULL;
  foreach ($groups as $gid) {
  	$node = node_load($gid);
    if (isset($node->voip_extension_info) && (voip_extension_access($node->voip_extension_info, 'view'))) {
      $extension_list[] = $node->voip_extension_info;
    }
  }
  if ($extension_list) {
  	$output .= '<h2 class="title">' . t('Groups') . '</h2>';
//$output .= "<br><hr>" . print_t($extension_list, TRUE) . "<hr><br>";
    $output .= '<fieldset>';
    $header = array(t('Extension'), t('Name'), t('Audio name'), t('Audio description'));
    $rows = voip_extension_list($extension_list, FALSE);
    $output .= theme('table', $header, $rows);
    $output .= '</fieldset>';
  }
  
  // display selected profile categories
  $selected_categories = array(t("Member Info"), t('Referral info'));
  foreach($fields as $category => $items) {
    if (in_array($category, $selected_categories)) {
      if (strlen($category) > 0) {
        $output .= '<h2 class="title">'. $category .'</h2>';
      }
      $output .= '<dl>';
      foreach ($items as $item) {
        if (isset($item['title'])) {
          $output .= '<dt class="'. $item['class'] .'">'. $item['title'] .'</dt>';
        }
        $output .= '<p class="'. $item['class'] .'">'. $item['value'] .'</p>';
     }
     $output .= '</dl>';
    }
  }  

  
//$output .= print_r($fields, TRUE);

//return $rows ? '<fieldset><legend>' . node_get_name($type) . '</legend>'  . theme('table', $header, $rows) . '</fieldset>' : NULL;

  $output .= '</div>';
  print $output;
?>


<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:42:17
         compiled from CRM/Contact/Page/View/Basic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Page/View/Basic.tpl', 8, false),array('function', 'crmURL', 'CRM/Contact/Page/View/Basic.tpl', 11, false),array('function', 'cycle', 'CRM/Contact/Page/View/Basic.tpl', 204, false),array('modifier', 'nl2br', 'CRM/Contact/Page/View/Basic.tpl', 78, false),array('modifier', 'crmDate', 'CRM/Contact/Page/View/Basic.tpl', 133, false),array('modifier', 'crmMoney', 'CRM/Contact/Page/View/Basic.tpl', 146, false),array('modifier', 'mb_truncate', 'CRM/Contact/Page/View/Basic.tpl', 208, false),array('modifier', 'count_characters', 'CRM/Contact/Page/View/Basic.tpl', 421, false),)), $this); ?>
<?php if ($this->_tpl_vars['action'] == 2): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Edit.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  else: ?>
<div id="name" class="data-group">
   <div>
    <label><?php echo $this->_tpl_vars['displayName']; ?>
</label>
    <?php if ($this->_tpl_vars['contact_type'] == 'Individual' && $this->_tpl_vars['job_title']): ?>&nbsp;&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Job Title<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>:&nbsp;<?php echo $this->_tpl_vars['job_title']; ?>

    <?php elseif ($this->_tpl_vars['home_URL']): ?>&nbsp; &nbsp; <a href="<?php echo $this->_tpl_vars['home_URL']; ?>
" target="_blank"><?php echo $this->_tpl_vars['home_URL']; ?>
</a><?php endif; ?>
    <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
        &nbsp; &nbsp; <input type="button" value="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Edit<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" name="edit_contact_info" onclick="window.location='<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view','q' => "reset=1&action=update&cid=".($this->_tpl_vars['contactId'])), $this);?>
';"/>
    <?php endif; ?>
    &nbsp; &nbsp; <input type="button" value="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>vCard<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" name="vCard_export" onclick="window.location='<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/vcard','q' => "reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
';"/>
    <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
        &nbsp; &nbsp; <input type="button" value="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Delete<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" name="contact_delete" onclick="window.location='<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/delete','q' => "reset=1&delete=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
';"/>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['url']): ?> &nbsp; &nbsp; <a href="<?php echo $this->_tpl_vars['url']; ?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>View User Record<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a> <?php endif; ?>
    <?php if ($this->_tpl_vars['contactTag']): ?><br /><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Tags<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>:&nbsp;<?php echo $this->_tpl_vars['contactTag'];  endif; ?>
   </div>
</div>


<?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Page/View/ActivityLinks.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>

<?php $_from = $this->_tpl_vars['location']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['locationIndex'] => $this->_tpl_vars['loc']):
?>

 <div id="location[<?php echo $this->_tpl_vars['locationIndex']; ?>
][show]" class="data-group">
  <a href="#" onclick="hide('location[<?php echo $this->_tpl_vars['locationIndex']; ?>
][show]'); show('location[<?php echo $this->_tpl_vars['locationIndex']; ?>
]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php echo $this->_tpl_vars['loc']['location_type'];  if ($this->_tpl_vars['loc']['name']): ?> - <?php echo $this->_tpl_vars['loc']['name'];  endif;  if ($this->_tpl_vars['locationIndex'] == 1): ?> <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>(primary location)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></label>
  <?php if ($this->_tpl_vars['preferred_communication_method'] == 'Email'): ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Preferred Email:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> <?php echo $this->_tpl_vars['loc']['email']['1']['email']; ?>

  <?php elseif ($this->_tpl_vars['preferred_communication_method'] == 'Phone'): ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Preferred Phone:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> <?php echo $this->_tpl_vars['loc']['phone']['1']['phone'];  endif; ?>
 </div>

 <div id="location[<?php echo $this->_tpl_vars['locationIndex']; ?>
]">
  <fieldset>
   <legend<?php if ($this->_tpl_vars['locationIndex'] == 1): ?> class="label"<?php endif; ?>>
    <a href="#" onclick="hide('location[<?php echo $this->_tpl_vars['locationIndex']; ?>
]'); show('location[<?php echo $this->_tpl_vars['locationIndex']; ?>
][show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php echo $this->_tpl_vars['loc']['location_type'];  if ($this->_tpl_vars['loc']['name']): ?> - <?php echo $this->_tpl_vars['loc']['name'];  endif;  if ($this->_tpl_vars['locationIndex'] == 1): ?> <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>(primary location)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?>
   </legend>

  <div class="col1">
   <?php $_from = $this->_tpl_vars['loc']['phone']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['phone']):
?>
     <?php if ($this->_tpl_vars['phone']['phone']): ?>
        <?php if ($this->_tpl_vars['phone']['is_primary'] == 1): ?><strong><?php endif; ?>
        <?php if ($this->_tpl_vars['phone']['phone_type']):  echo $this->_tpl_vars['phone']['phone_type_display']; ?>
:<?php endif; ?> <?php echo $this->_tpl_vars['phone']['phone']; ?>

        <?php if ($this->_tpl_vars['phone']['is_primary'] == 1): ?></strong><?php endif; ?>
        <br />
     <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>

   <?php $_from = $this->_tpl_vars['loc']['email']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['email']):
?>
      <?php if ($this->_tpl_vars['email']['email']): ?>
        <?php if ($this->_tpl_vars['email']['is_primary'] == 1): ?><strong><?php endif; ?>
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Email:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?> <?php echo $this->_tpl_vars['email']['email']; ?>

        <?php if ($this->_tpl_vars['email']['is_primary'] == 1): ?></strong><?php endif; ?>
        <br />
      <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>

   <?php $_from = $this->_tpl_vars['loc']['im']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['imKey'] => $this->_tpl_vars['im']):
?>
     <?php if ($this->_tpl_vars['im']['name'] || $this->_tpl_vars['im']['provider']): ?>
        <?php if ($this->_tpl_vars['im']['is_primary'] == 1): ?><strong><?php endif; ?>
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Instant Messenger:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?> <?php if ($this->_tpl_vars['im']['name']):  echo $this->_tpl_vars['im']['name'];  endif; ?> <?php if ($this->_tpl_vars['im']['provider']): ?>( <?php echo $this->_tpl_vars['im']['provider']; ?>
 ) <?php endif; ?>
        <?php if ($this->_tpl_vars['im']['is_primary'] == 1): ?></strong><?php endif; ?>
        <br />
     <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>
   </div>

   <div class="col2">

        <?php if ($this->_tpl_vars['config']->mapAPIKey && $this->_tpl_vars['loc']['address']['geo_code_1'] && $this->_tpl_vars['loc']['address']['geo_code_2']): ?>
        <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/search/map','q' => "reset=1&cid=".($this->_tpl_vars['contactId'])."&lid=".($this->_tpl_vars['loc']['address']['location_id'])), $this);?>
" title="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Map Primary Address<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Map this Address<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a><br />
    <?php endif; ?>
    <?php echo ((is_array($_tmp=$this->_tpl_vars['loc']['address']['display'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

  </div>
  <div class="spacer"></div>
  </fieldset>
 </div>
<?php endforeach; endif; unset($_from); ?>

 <div id="commPrefs[show]" class="data-group">
  <a href="#" onclick="hide('commPrefs[show]'); show('commPrefs'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Communications Preferences<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
 </div>

<div id="commPrefs">
 <fieldset>
  <legend><a href="#" onclick="hide('commPrefs'); show('commPrefs[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Communications Preferences<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
  <div class="col1">
    <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Privacy:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label>
    <span class="font-red upper">
    <?php $_from = $this->_tpl_vars['privacy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['privacy_label'] => $this->_tpl_vars['privacy_val']):
?>
      <?php if ($this->_tpl_vars['privacy_val'] == 1):  echo $this->_tpl_vars['privacy_values'][$this->_tpl_vars['privacy_label']]; ?>
 &nbsp; <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php if ($this->_tpl_vars['is_opt_out']): ?>
      <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>DO NOT SEND BULK EMAIL<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
    <?php endif; ?>
    </span>
  </div>
  <div class="col2">
    <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Communication Preference:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> <?php echo $this->_tpl_vars['preferred_communication_method_display']; ?>

  </div>
  <div class="col2">
    <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Mail Format Preference:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> <?php echo $this->_tpl_vars['preferred_mail_format_display']; ?>

  </div>
  <div class="spacer"></div>
 </fieldset>
</div>

 <div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Page/View/InlineCustomData.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 </div>

 <?php if ($this->_tpl_vars['contact_type'] == 'Individual'): ?>
 <div id="demographics[show]" class="data-group">
  <a href="#" onclick="hide('demographics[show]'); show('demographics'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Demographics<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
 </div>

 <div id="demographics">
  <fieldset>
   <legend><a href="#" onclick="hide('demographics'); show('demographics[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Demographics<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
   <div class="col1">
    <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Gender:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> <?php echo $this->_tpl_vars['gender_display']; ?>
<br />
    <?php if ($this->_tpl_vars['is_deceased'] == 1): ?>
        <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Contact is Deceased<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label>
    <?php endif; ?>
   </div>
   <div class="col2">
    <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Date of Birth:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> <?php echo ((is_array($_tmp=$this->_tpl_vars['birth_date'])) ? $this->_run_mod_handler('crmDate', true, $_tmp) : smarty_modifier_crmDate($_tmp)); ?>

   </div>
   <div class="spacer"></div>
  </fieldset>
 </div>
 <?php endif; ?>

<?php if ($this->_tpl_vars['accessContribution']): ?>
    <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => "civicrm/contact/view/contribution",'q' => "reset=1&action=add&cid=".($this->_tpl_vars['contactId'])."&context=contribution"), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('newContribURL', ob_get_contents());ob_end_clean(); ?>
<div id="contributions[show]" class="data-group">
  <?php if ($this->_tpl_vars['pager']->_totalItems): ?>
    <dl><dt><a href="#" onclick="hide('contributions[show]'); show('contributions'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Contributions<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label></dt>
    <dd><strong><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Total Contributed<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?> - <?php if ($this->_tpl_vars['total_amount']):  echo ((is_array($_tmp=$this->_tpl_vars['total_amount'])) ? $this->_run_mod_handler('crmMoney', true, $_tmp) : smarty_modifier_crmMoney($_tmp));  else: ?>n/a<?php endif; ?>
        &nbsp; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?># Contributions<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?> - <?php echo $this->_tpl_vars['pager']->_totalItems; ?>
</strong></dd>
    </dl>
  <?php else: ?>
    <dl><dt><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Contributions<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dt>
    <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
        <dd><?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['newContribURL'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>There are no contributions recorded for this contact. You can <a href="%1">enter one now</a>.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <?php else: ?>
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>There are no contributions recorded for this contact.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
    <?php endif; ?>
    </dl>
  <?php endif; ?>
</div>

    <div id="contributions">
    <?php if ($this->_tpl_vars['pager']->_totalItems): ?>
        <fieldset><legend><a href="#" onclick="hide('contributions'); show('contributions[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php if ($this->_tpl_vars['pager']->_totalItems > 3):  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['pager']->_totalItems)); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Contributions (3 of %1)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Contributions<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contribute/Page/ContributionTotals.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <p>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contribute/Form/Selector.tpl", 'smarty_include_vars' => array('context' => 'Contact Summary')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>       
        </p>
        
        <div class="action-link">
            <a href="<?php echo $this->_tpl_vars['newContribURL']; ?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>New Contribution<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a> 
        </div>
        </fieldset>
    <?php endif; ?>
    </div>
<?php endif; ?>

<div id="openActivities[show]" class="data-group">
  <?php if ($this->_tpl_vars['openActivity']['totalCount']): ?>
    <a href="#" onclick="hide('openActivities[show]'); show('openActivities'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Open Activities<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> (<?php echo $this->_tpl_vars['openActivity']['totalCount']; ?>
)<br />
  <?php else: ?>
    <dl><dt><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Open Activities<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dt>
    <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
        <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=1&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('mtgURL', ob_get_contents());ob_end_clean(); ?>
        <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=2&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('callURL', ob_get_contents());ob_end_clean(); ?>
        <dd><?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['mtgURL'],'2' => $this->_tpl_vars['callURL'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>No open activities. You can schedule a <a href="%1">meeting</a> or a <a href="%2">call</a>.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <?php else: ?>
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>There are no open activities for this contact.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
    <?php endif; ?>
    </dl>
  <?php endif; ?>
</div>

<div id="openActivities">
 <fieldset><legend><a href="#" onclick="hide('openActivities'); show('openActivities[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php if ($this->_tpl_vars['openActivity']['totalCount'] > 3):  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['openActivity']['totalCount'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Open Activities (3 of %1)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Open Activities<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
	<?php echo '<table><tr class="columnheader"><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Activity Type';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Subject';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Created By';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'With';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Scheduled Date';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th></th></tr>';  $_from = $this->_tpl_vars['openActivity']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
 echo '<tr class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><tr class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><td>';  echo $this->_tpl_vars['row']['activity_type'];  echo '</td><td><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=".($this->_tpl_vars['row']['activity_type_id'])."&action=view&id=".($this->_tpl_vars['row']['id'])."&cid=".($this->_tpl_vars['contactId'])."&history=0"), $this); echo '">';  echo ((is_array($_tmp=$this->_tpl_vars['row']['subject'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 33, "...", true) : smarty_modifier_mb_truncate($_tmp, 33, "...", true));  echo '</a></td><td>';  if ($this->_tpl_vars['contactId'] != $this->_tpl_vars['row']['sourceID']):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view','q' => "reset=1&cid=".($this->_tpl_vars['row']['sourceID'])), $this); echo '">';  echo $this->_tpl_vars['row']['sourceName'];  echo '</a>';  else:  echo '';  echo $this->_tpl_vars['row']['sourceName'];  echo '';  endif;  echo '</td><td>';  if ("$".($this->_tpl_vars['contactId']) != $this->_tpl_vars['row']['targetID'] && $this->_tpl_vars['contactId'] == $this->_tpl_vars['row']['sourceID']):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view','q' => "reset=1&cid=".($this->_tpl_vars['row']['targetID'])), $this); echo '">';  echo $this->_tpl_vars['row']['targetName'];  echo '</a>';  else:  echo '';  echo $this->_tpl_vars['row']['targetName'];  echo '';  endif;  echo '</td><td>';  echo ((is_array($_tmp=$this->_tpl_vars['row']['date'])) ? $this->_run_mod_handler('crmDate', true, $_tmp) : smarty_modifier_crmDate($_tmp));  echo '</td><td>';  if ($this->_tpl_vars['permission'] == 'edit'):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=".($this->_tpl_vars['row']['activity_type_id'])."&action=update&id=".($this->_tpl_vars['row']['id'])."&cid=".($this->_tpl_vars['contactId'])."&history=0"), $this); echo '">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Edit';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a>';  else:  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=".($this->_tpl_vars['row']['activity_type_id'])."&action=view&id=".($this->_tpl_vars['row']['id'])."&cid=".($this->_tpl_vars['contactId'])."&history=0"), $this); echo '">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Details';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a>';  endif;  echo '</td></tr>';  endforeach; endif; unset($_from);  echo '';  if ($this->_tpl_vars['openActivity']['totalCount'] > 3):  echo '<tr class="even-row"><td colspan="7"><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "show=1&action=browse&cid=".($this->_tpl_vars['contactId'])), $this); echo '">&raquo; ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'View All Open Activities...';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></td></tr>';  endif;  echo '</table>'; ?>

 </fieldset>
</div>

<div id="activityHx[show]" class="data-group">
  <?php if ($this->_tpl_vars['activity']['totalCount']): ?>
    <a href="#" onclick="hide('activityHx[show]'); show('activityHx'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Activity History<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> (<?php echo $this->_tpl_vars['activity']['totalCount']; ?>
)<br />
  <?php else: ?>
    <dl><dt><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Activity History<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dt><dd><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>No activity history.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd></dl>
  <?php endif; ?>
</div>

<div id="activityHx">
 <fieldset><legend><a href="#" onclick="hide('activityHx'); show('activityHx[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php if ($this->_tpl_vars['activity']['totalCount'] > 3):  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['activity']['totalCount'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Activity History (3 of %1)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Activity History<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
	<?php echo '<table><tr class="columnheader"><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Activity Type';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Description';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Activity Date';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th></th></tr>';  $_from = $this->_tpl_vars['activity']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
 echo '<tr class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><td>';  echo $this->_tpl_vars['row']['activity_type'];  echo '</td><td>';  echo $this->_tpl_vars['row']['activity_summary'];  echo '</td><td>';  echo ((is_array($_tmp=$this->_tpl_vars['row']['activity_date'])) ? $this->_run_mod_handler('crmDate', true, $_tmp) : smarty_modifier_crmDate($_tmp));  echo '</td>';  if ($this->_tpl_vars['row']['callback']):  echo '<td><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/history/activity/detail','q' => "id=".($this->_tpl_vars['row']['id'])."&activity_id=".($this->_tpl_vars['row']['activity_id'])."&cid=".($this->_tpl_vars['contactId'])), $this); echo '">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Details';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></td>';  else:  echo ' <td></td>';  endif;  echo '</tr>';  endforeach; endif; unset($_from);  echo '';  if ($this->_tpl_vars['activity']['totalCount'] > 3):  echo '<tr class="even-row"><td colspan="7"><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "show=1&action=browse&history=true&cid=".($this->_tpl_vars['contactId'])), $this); echo '">&raquo; ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'View All Activity History...';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></td></tr>';  endif;  echo '</table>'; ?>

 </fieldset>
</div>

<div id="relationships[show]" class="data-group">
  <?php if ($this->_tpl_vars['relationship']['totalCount']): ?>
    <a href="#" onclick="hide('relationships[show]'); show('relationships'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Relationships<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> (<?php echo $this->_tpl_vars['relationship']['totalCount']; ?>
)<br />
  <?php else: ?>
    <dl><dt><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Relationships<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dt>
    <dd>
        <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
            <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/rel','q' => "action=add&cid=".($this->_tpl_vars['contactId'])), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('crmURL', ob_get_contents());ob_end_clean();  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['crmURL'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>No relationships. You can <a href="%1">create a new relationship</a>.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php else: ?>
            <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>There are no Relationships entered for this contact.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php endif; ?>
    </dd>
    </dl>
  <?php endif; ?>
</div>

<div id="relationships">
 <?php if ($this->_tpl_vars['relationship']['totalCount']): ?>
 <fieldset><legend><a href="#" onclick="hide('relationships'); show('relationships[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php if ($this->_tpl_vars['relationship']['totalCount'] > 3):  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['relationship']['totalCount'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Relationships (3 of %1)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Relationships<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
    <?php echo '<table><tr class="columnheader"><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Relationship';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th></th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'City';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'State';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Email';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Phone';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>&nbsp;</th></tr>';  $_from = $this->_tpl_vars['relationship']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rel']):
 echo '';  echo '<tr class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><td class="label"><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/rel','q' => "action=view&reset=1&cid=".($this->_tpl_vars['contactId'])."&id=".($this->_tpl_vars['rel']['id'])."&rtype=".($this->_tpl_vars['rel']['rtype'])), $this); echo '">';  echo $this->_tpl_vars['rel']['relation'];  echo '</a></td><td><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view','q' => "reset=1&cid=".($this->_tpl_vars['rel']['cid'])), $this); echo '">';  echo $this->_tpl_vars['rel']['name'];  echo '</a></td><td>';  echo $this->_tpl_vars['rel']['city'];  echo '</td><td>';  echo $this->_tpl_vars['rel']['state'];  echo '</td><td>';  echo $this->_tpl_vars['rel']['email'];  echo '</td><td>';  echo $this->_tpl_vars['rel']['phone'];  echo '</td><td>';  if ($this->_tpl_vars['permission'] == 'edit'):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/rel','q' => "rid=".($this->_tpl_vars['rel']['id'])."&action=update&rtype=".($this->_tpl_vars['rel']['rtype'])."&cid=".($this->_tpl_vars['contactId'])), $this); echo '">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Edit';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a>';  endif;  echo '</td></tr>';  endforeach; endif; unset($_from);  echo '';  if ($this->_tpl_vars['relationship']['totalCount'] > 3):  echo '<tr class="even-row"><td colspan="7"><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/rel','q' => "action=browse&cid=".($this->_tpl_vars['contactId'])), $this); echo '">&raquo; ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'View All Relationships...';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></td></tr>';  endif;  echo '</table>'; ?>

   <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
   <div class="action-link">
       <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/rel','q' => "action=add&cid=".($this->_tpl_vars['contactId'])), $this);?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>New Relationship<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
   </div>
   <?php endif; ?>
 </fieldset>
 <?php endif; ?>
</div>

<div id="groups[show]" class="data-group">
  <?php if ($this->_tpl_vars['group']['totalCount']): ?>
    <a href="#" onclick="hide('groups[show]'); show('groups'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group Memberships<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> (<?php echo $this->_tpl_vars['group']['totalCount']; ?>
)<br />
  <?php else: ?>
    <dl><dt><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group Memberships<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dt>
    <dd>
        <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
            <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/group','q' => "action=add&cid=".($this->_tpl_vars['contactId'])), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('crmURL', ob_get_contents());ob_end_clean();  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['crmURL'],'2' => $this->_tpl_vars['display_name'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>No current group memberships. You can <a href="%1">add %2 to a group</a>.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php else: ?>
            <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>No current group memberships.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php endif; ?>
    </dd>
    </dl>
  <?php endif; ?>
</div>

<div id="groups">
 <fieldset><legend><a href="#" onclick="hide('groups'); show('groups[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php if ($this->_tpl_vars['group']['totalCount'] > 3):  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['group']['totalCount'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group Memberships (3 of %1)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group Memberships<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
	<?php echo '<table><tr class="columnheader"><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Group';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Status';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Date Added';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th></tr>';  $_from = $this->_tpl_vars['group']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
 echo '<tr class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><td><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/group/search','q' => "reset=1&force=1&context=smog&gid=".($this->_tpl_vars['row']['group_id'])), $this); echo '">';  echo $this->_tpl_vars['row']['title'];  echo '</a></td><td>';  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['row']['in_method'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Added (by %1)';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</td><td>';  echo ((is_array($_tmp=$this->_tpl_vars['row']['in_date'])) ? $this->_run_mod_handler('crmDate', true, $_tmp) : smarty_modifier_crmDate($_tmp));  echo '</td></tr>';  endforeach; endif; unset($_from);  echo '';  if ($this->_tpl_vars['group']['totalCount'] > 3):  echo '<tr class="even-row"><td colspan="7"><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/group','q' => "action=browse&cid=".($this->_tpl_vars['contactId'])), $this); echo '">&raquo; ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'View All Group Memberships...';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></td></tr>';  endif;  echo '</table>'; ?>

   <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
   <div class="action-link">
       <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/group','q' => "reset=1&action=add&cid=".($this->_tpl_vars['contactId'])), $this);?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>New Group Membership<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
   </div>
   <?php endif; ?>
 </fieldset>
</div>

<div id="notes[show]" class="data-group">
  <?php if ($this->_tpl_vars['noteTotalCount']): ?>
    <a href="#" onclick="hide('notes[show]'); show('notes'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Notes<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> (<?php echo $this->_tpl_vars['noteTotalCount']; ?>
)<br />
  <?php else: ?>
    <dl><dt><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Notes<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dt>
    <dd>
        <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
            <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/note','q' => "action=add&cid=".($this->_tpl_vars['contactId'])), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('crmURL', ob_get_contents());ob_end_clean();  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['crmURL'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>There are no Notes. You can <a href="%1">enter notes</a> about this contact.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php else: ?>
            <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>There are no Notes for this contact.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php endif; ?>
    </dd>
    </dl>
  <?php endif; ?>
</div>

<div id="notes">
<?php if ($this->_tpl_vars['note']): ?>
  <fieldset><legend><a href="#" onclick="hide('notes'); show('notes[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php if ($this->_tpl_vars['noteTotalCount'] > 3):  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['noteTotalCount'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Notes (3 of %1)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Notes<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
       <?php echo '<table><tr class="columnheader"><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Note';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Date';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th></th></tr>';  $_from = $this->_tpl_vars['note']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['note']):
 echo '<tr class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><td>';  echo ((is_array($_tmp=$this->_tpl_vars['note']['note'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 80, "...", true) : smarty_modifier_mb_truncate($_tmp, 80, "...", true));  echo '';  echo '';  $this->assign('noteSize', ((is_array($_tmp=$this->_tpl_vars['note']['note'])) ? $this->_run_mod_handler('count_characters', true, $_tmp, true) : smarty_modifier_count_characters($_tmp, true)));  echo '';  if ($this->_tpl_vars['noteSize'] > 80):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/note','q' => "id=".($this->_tpl_vars['note']['id'])."&action=view&cid=".($this->_tpl_vars['contactId'])), $this); echo '">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo '(more)';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a>';  endif;  echo '</td><td>';  echo ((is_array($_tmp=$this->_tpl_vars['note']['modified_date'])) ? $this->_run_mod_handler('crmDate', true, $_tmp) : smarty_modifier_crmDate($_tmp));  echo '</td><td>';  if ($this->_tpl_vars['permission'] == 'edit'):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/note','q' => "id=".($this->_tpl_vars['note']['id'])."&action=update&cid=".($this->_tpl_vars['contactId'])), $this); echo '">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Edit';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a>';  endif;  echo '</td></tr>';  endforeach; endif; unset($_from);  echo '';  if ($this->_tpl_vars['noteTotalCount'] > 3):  echo '<tr class="even-row"><td colspan="7"><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/note','q' => "action=browse&cid=".($this->_tpl_vars['contactId'])), $this); echo '">&raquo; ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'View All Notes...';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></td></tr>';  endif;  echo '</table>'; ?>

       <?php if ($this->_tpl_vars['permission'] == 'edit'): ?>
       <div class="action-link">
         <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/note','q' => "action=add&cid=".($this->_tpl_vars['contactId'])), $this);?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>New Note<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
       </div>
       <?php endif; ?>
 </fieldset>
<?php endif; ?>
</div> <!-- End of Notes block -->

 <script type="text/javascript">
    var showBlocks = new Array(<?php echo $this->_tpl_vars['showBlocks']; ?>
);
    var hideBlocks = new Array(<?php echo $this->_tpl_vars['hideBlocks']; ?>
);

    on_load_init_blocks( showBlocks, hideBlocks );
 </script>

<?php endif; ?>
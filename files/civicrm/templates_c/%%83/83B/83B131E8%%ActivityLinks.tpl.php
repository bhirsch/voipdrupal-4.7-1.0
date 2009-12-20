<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:42:17
         compiled from CRM/Contact/Page/View/ActivityLinks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'crmURL', 'CRM/Contact/Page/View/ActivityLinks.tpl', 9, false),array('block', 'ts', 'CRM/Contact/Page/View/ActivityLinks.tpl', 9, false),)), $this); ?>

<?php if ($this->_tpl_vars['contact_id']):  $this->assign('contactId', $this->_tpl_vars['contact_id']);  endif; ?>

<div class= "data-group">
<?php if ($this->_tpl_vars['config']->smtpServer && $this->_tpl_vars['config']->smtpServer != 'YOUR SMTP SERVER' && ! $this->_tpl_vars['privacy']['do_not_email']): ?>
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=3&cid=".($this->_tpl_vars['contactId'])."&reset=1"), $this);?>
"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/EnvelopeIn.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Send Email<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a>&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=3&cid=".($this->_tpl_vars['contactId'])."&reset=1"), $this);?>
"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Send an Email<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>&nbsp;&nbsp;
<?php endif; ?>
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=1&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/meeting.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Schedule Meeting<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a>&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=1&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Schedule a Meeting<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>&nbsp;&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=2&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/tel.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Schedule Call<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a>&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=2&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Schedule a Call<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>&nbsp;&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=1&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])."&log=1"), $this);?>
"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/meeting.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Log a Meeting<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a>&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=1&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])."&log=1"), $this);?>
"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Log a Meeting<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>&nbsp;&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=2&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])."&log=1"), $this);?>
"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/tel.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Log a Call<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a>&nbsp;
   <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=2&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])."&log=1"), $this);?>
"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Log a Call<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>&nbsp;&nbsp;
      <?php if ($this->_tpl_vars['showOtherActivityLink']): ?>
        &nbsp;&nbsp;
        <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=5&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/custom_activity.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Other Activities<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a>&nbsp;
        <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view/activity','q' => "activity_id=5&action=add&reset=1&cid=".($this->_tpl_vars['contactId'])), $this);?>
"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Other Activities<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
   <?php endif; ?>

</div>
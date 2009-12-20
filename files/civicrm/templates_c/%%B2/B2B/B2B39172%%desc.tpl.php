<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:02
         compiled from CRM/common/calendar/desc.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/common/calendar/desc.tpl', 4, false),)), $this); ?>
<?php if (! $this->_tpl_vars['trigger']): ?>
  <?php $this->assign('trigger', 'trigger');  endif; ?>
<img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/cal.gif" id="<?php echo $this->_tpl_vars['trigger']; ?>
" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Calendar<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" style="padding: 5px 0px 0px 0px; vertical-align: text-bottom;"/> 
<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Click to select date/time from calendar.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?> 
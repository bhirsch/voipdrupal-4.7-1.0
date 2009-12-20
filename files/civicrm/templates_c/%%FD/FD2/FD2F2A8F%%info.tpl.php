<?php /* Smarty version 2.6.12-dev, created on 2006-07-11 10:22:07
         compiled from CRM/common/info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/common/info.tpl', 5, false),)), $this); ?>
<?php if ($this->_tpl_vars['infoMessage']): ?>
<div class="messages status">
    <dl>
    <dt><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/Inform.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>status<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></dt>
    <dd><?php echo $this->_tpl_vars['infoMessage']; ?>
</dd>
  </dl>
</div>
<?php endif; ?>
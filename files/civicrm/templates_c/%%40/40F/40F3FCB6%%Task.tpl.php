<?php /* Smarty version 2.6.12-dev, created on 2006-07-11 11:28:22
         compiled from CRM/Contact/Form/Task.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Task.tpl', 1, false),array('function', 'cycle', 'CRM/Contact/Form/Task.tpl', 10, false),)), $this); ?>
<?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['totalSelectedContacts'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Number of selected contacts: %1<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>

<?php if ($this->_tpl_vars['rows']): ?> 
<div class="form-item">
<table width="30%">
  <tr class="columnheader">
    <th><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Name<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></th>
  </tr>
<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
<tr class="<?php echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this);?>
">
<td><?php echo $this->_tpl_vars['row']['displayName']; ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</div>
<?php endif; ?>
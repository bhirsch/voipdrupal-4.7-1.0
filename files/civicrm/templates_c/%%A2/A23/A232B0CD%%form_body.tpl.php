<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:01
         compiled from CRM/common/form_body.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/common/form_body.tpl', 11, false),)), $this); ?>
<?php if ($this->_tpl_vars['form']['javascript']): ?>
  <?php echo $this->_tpl_vars['form']['javascript']; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['form']['hidden']): ?>
  <?php echo $this->_tpl_vars['form']['hidden']; ?>

<?php endif; ?>

<?php if (count ( $this->_tpl_vars['form']['errors'] ) > 0): ?>
   <div class="messages error">
   <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Please correct the following errors in the form fields below:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
   <ul id="errorList">
   <?php $_from = $this->_tpl_vars['form']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['error']):
?>
      <?php if (is_array ( $this->_tpl_vars['error'] )): ?>
         <li><?php echo $this->_tpl_vars['error']['label']; ?>
 <?php echo $this->_tpl_vars['error']['message']; ?>
</li>
      <?php else: ?>
         <li><?php echo $this->_tpl_vars['error']; ?>
</li>
      <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?>
   </ul>
   </div>
<?php endif; ?>
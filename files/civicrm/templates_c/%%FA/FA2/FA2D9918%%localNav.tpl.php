<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:42:15
         compiled from CRM/common/localNav.tpl */ ?>
<div class="tabs">
    <ul class="tabs primary">
    <?php $_from = $this->_tpl_vars['localTasks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['task']):
?>
        <li <?php if ($this->_tpl_vars['task']['class']): ?>class="<?php echo $this->_tpl_vars['task']['class']; ?>
"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['task']['url']; ?>
" <?php if ($this->_tpl_vars['task']['class']): ?>class="<?php echo $this->_tpl_vars['task']['class']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['task']['title']; ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
   </ul>
</div>
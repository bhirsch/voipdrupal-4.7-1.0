<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:53:35
         compiled from CRM/Block/Menu.tpl */ ?>
<div class='menu'>
<ul>
<?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menuItem']):
 if ($this->_tpl_vars['menuItem']['start']): ?><li><ul class="indented"><?php endif; ?>
<li class="<?php echo $this->_tpl_vars['menuItem']['class']; ?>
"><a href="<?php echo $this->_tpl_vars['menuItem']['url']; ?>
" <?php echo $this->_tpl_vars['menuItem']['active']; ?>
><?php echo $this->_tpl_vars['menuItem']['title']; ?>
</a></li>
<?php if ($this->_tpl_vars['menuItem']['end']): ?></ul></li><?php endif;  endforeach; endif; unset($_from); ?>
</ul>
</div>
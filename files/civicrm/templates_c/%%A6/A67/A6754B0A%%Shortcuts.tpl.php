<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:53:35
         compiled from CRM/Block/Shortcuts.tpl */ ?>
<div id='crm-shortcuts' class="menu">
<ul>
<?php $_from = $this->_tpl_vars['shortCuts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['short']):
?>
    <li class="leaf"><a href="<?php echo $this->_tpl_vars['short']['url']; ?>
"><?php echo $this->_tpl_vars['short']['title']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
</div>
<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 18:26:38
         compiled from CRM/Profile/Page/Dynamic.tpl */ ?>
<?php if (! empty ( $this->_tpl_vars['row'] )): ?>
<div id="crm-container">
<fieldset>
<table class="form-layout-compressed">                               
<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
  <tr><td class="label"><?php echo $this->_tpl_vars['name']; ?>
</td><td><?php echo $this->_tpl_vars['value']; ?>
</td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</fieldset>
</div>
<?php endif; ?> 
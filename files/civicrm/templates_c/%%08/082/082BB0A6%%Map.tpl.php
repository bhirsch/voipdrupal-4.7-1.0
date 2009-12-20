<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:45:19
         compiled from CRM/Contact/Form/Task/Map.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php if ($this->_tpl_vars['mapProvider'] == 'Google'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Task/Map/Google.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  elseif ($this->_tpl_vars['mapProvider'] == 'Yahoo'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Task/Map/Yahoo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>

<p>                                                                                                           
<div class="form-item">                     
    <p> 
    <?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
                                                                                      
    </p>    
</div>                            
</p>

</html>
<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:42:29
         compiled from CRM/Contact/Form/Selector.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Selector.tpl', 11, false),array('function', 'counter', 'CRM/Contact/Form/Selector.tpl', 26, false),array('function', 'cycle', 'CRM/Contact/Form/Selector.tpl', 28, false),array('function', 'crmURL', 'CRM/Contact/Form/Selector.tpl', 38, false),array('modifier', 'mb_truncate', 'CRM/Contact/Form/Selector.tpl', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/pager.tpl", 'smarty_include_vars' => array('location' => 'top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/pagerAToZ.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '<table><tr class="columnheader"><th>';  echo $this->_tpl_vars['form']['toggleSelect']['html'];  echo '</th>';  if ($this->_tpl_vars['context'] == 'smog'):  echo '<th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Status';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th>';  endif;  echo '';  $_from = $this->_tpl_vars['columnHeaders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
 echo '<th>';  if ($this->_tpl_vars['header']['sort']):  echo '';  $this->assign('key', $this->_tpl_vars['header']['sort']);  echo '';  echo $this->_tpl_vars['sort']->_response[$this->_tpl_vars['key']]['link'];  echo '';  else:  echo '';  echo $this->_tpl_vars['header']['name'];  echo '';  endif;  echo '</th>';  endforeach; endif; unset($_from);  echo '</tr>';  echo smarty_function_counter(array('start' => 0,'skip' => 1,'print' => false), $this); echo '';  $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
 echo '<tr id=\'rowid';  echo $this->_tpl_vars['row']['contact_id'];  echo '\' class="';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '">';  $this->assign('cbName', $this->_tpl_vars['row']['checkbox']);  echo '<td>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['cbName']]['html'];  echo '</td>';  if ($this->_tpl_vars['context'] == 'smog'):  echo '';  if ($this->_tpl_vars['row']['status'] == 'Pending'):  echo '<td class="status-pending"}>';  elseif ($this->_tpl_vars['row']['status'] == 'Removed'):  echo '<td class="status-removed">';  else:  echo '<td>';  endif;  echo '';  echo $this->_tpl_vars['row']['status'];  echo '</td>';  endif;  echo '<td>';  echo $this->_tpl_vars['row']['contact_type'];  echo '</td><td><a href="';  echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view','q' => "reset=1&cid=".($this->_tpl_vars['row']['contact_id'])), $this); echo '">';  echo $this->_tpl_vars['row']['sort_name'];  echo '</a></td><td>';  echo ((is_array($_tmp=$this->_tpl_vars['row']['street_address'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 22, "...", true) : smarty_modifier_mb_truncate($_tmp, 22, "...", true));  echo '</td><td>';  echo $this->_tpl_vars['row']['city'];  echo '</td><td>';  echo $this->_tpl_vars['row']['state_province'];  echo '</td><td>';  echo $this->_tpl_vars['row']['postal_code'];  echo '</td><td>';  echo $this->_tpl_vars['row']['country'];  echo '</td><td>';  echo ((is_array($_tmp=$this->_tpl_vars['row']['email'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 17, "...", true) : smarty_modifier_mb_truncate($_tmp, 17, "...", true));  echo '</td><td>';  echo $this->_tpl_vars['row']['phone'];  echo '</td><td>';  echo $this->_tpl_vars['row']['action'];  echo '</td></tr>';  endforeach; endif; unset($_from);  echo '</table>'; ?>


 <script type="text/javascript">
     var fname = "<?php echo $this->_tpl_vars['form']['formName']; ?>
";	
    on_load_init_checkboxes(fname);
 </script>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/pager.tpl", 'smarty_include_vars' => array('location' => 'bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
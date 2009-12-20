<?php /* Smarty version 2.6.12-dev, created on 2006-08-09 20:37:27
         compiled from CRM/Custom/Form/Preview.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Custom/Form/Preview.tpl', 2, false),array('modifier', 'cat', 'CRM/Custom/Form/Preview.tpl', 22, false),)), $this); ?>
<?php if ($this->_tpl_vars['preview_type'] == 'group'): ?>
    <?php ob_start();  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Preview of the custom data group (fieldset) as it will be displayed within an edit form.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('infoMessage', ob_get_contents());ob_end_clean(); ?>
    <?php ob_start(); ?>
        <?php $_from = $this->_tpl_vars['groupTree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name']):
?>
        <?php echo $this->_tpl_vars['name']['title']; ?>

        <?php endforeach; endif; unset($_from); ?>
    <?php $this->_smarty_vars['capture']['legend'] = ob_get_contents(); ob_end_clean();  else: ?>
    <?php ob_start();  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Preview of this field as it will be displayed in an edit form.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('infoMessage', ob_get_contents());ob_end_clean();  endif;  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/info.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="form-item">
<?php echo '';  $_from = $this->_tpl_vars['groupTree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group_id'] => $this->_tpl_vars['cd_edit']):
 echo '<p></p><fieldset>';  if ($this->_tpl_vars['preview_type'] == 'group'):  echo '<legend>';  echo $this->_smarty_vars['capture']['legend'];  echo '</legend>';  endif;  echo '';  if ($this->_tpl_vars['cd_edit']['help_pre']):  echo '<div class="messages help">';  echo $this->_tpl_vars['cd_edit']['help_pre'];  echo '</div><br />';  endif;  echo '<dl>';  $_from = $this->_tpl_vars['cd_edit']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_id'] => $this->_tpl_vars['element']):
 echo '';  if ($this->_tpl_vars['element']['options_per_line']):  echo '';  $this->assign('element_name', ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['group_id'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['element']['name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['element']['name'])));  echo '<dt>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label'];  echo ' </dt><dd>';  $this->assign('count', '1');  echo '<table class="form-layout-compressed">';  echo '';  $this->assign('index', '1');  echo '';  $_from = $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['outer']['iteration']++;
 echo '';  if ($this->_tpl_vars['index'] < 10):  echo '';  $this->assign('index', ($this->_tpl_vars['index']+1));  echo '';  else:  echo '<td class="labels font-light">';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']][$this->_tpl_vars['key']]['html'];  echo '</td>';  if ($this->_tpl_vars['count'] == $this->_tpl_vars['element']['options_per_line']):  echo '</tr><tr>';  $this->assign('count', '1');  echo '';  else:  echo '';  $this->assign('count', ($this->_tpl_vars['count']+1));  echo '';  endif;  echo '';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</tr></table></dd>';  if ($this->_tpl_vars['element']['help_post']):  echo '<dt>&nbsp;</dt><dd class="description">';  echo $this->_tpl_vars['element']['help_post'];  echo '</dd>';  endif;  echo '';  else:  echo '';  $this->assign('name', ($this->_tpl_vars['element']['name']));  echo '';  $this->assign('element_name', ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['group_id'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['element']['name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['element']['name'])));  echo '<dt>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label'];  echo '</dt><dd>&nbsp;';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['html'];  echo '';  if ($this->_tpl_vars['element']['data_type'] == 'Date'):  echo '';  if ($this->_tpl_vars['element']['skip_calendar'] != true):  echo '<span>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/calendar/desc.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/calendar/body.tpl", 'smarty_include_vars' => array('dateVar' => $this->_tpl_vars['element_name'],'startDate' => 1905,'endDate' => 2010)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '</span>';  endif;  echo '';  endif;  echo '</dd>';  if ($this->_tpl_vars['element']['help_post']):  echo '<dt>&nbsp;</dt><dd class="description">';  echo $this->_tpl_vars['element']['help_post'];  echo '</dd>';  endif;  echo '';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</dl>';  if ($this->_tpl_vars['cd_edit']['help_post']):  echo '<br /><div class="messages help">';  echo $this->_tpl_vars['cd_edit']['help_post'];  echo '</div>';  endif;  echo '</fieldset>';  endforeach; endif; unset($_from);  echo ''; ?>


<dl>
  <dt></dt><dd><?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</dd>
</dl>
</div>
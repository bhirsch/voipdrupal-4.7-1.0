<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:02
         compiled from CRM/Contact/Form/CustomData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/CustomData.tpl', 4, false),array('modifier', 'cat', 'CRM/Contact/Form/CustomData.tpl', 13, false),)), $this); ?>
<?php echo '';  $_from = $this->_tpl_vars['groupTree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group_id'] => $this->_tpl_vars['cd_edit']):
 echo '<div id="';  echo $this->_tpl_vars['cd_edit']['title'];  echo '[show]" class="data-group"><a href="#" onclick="hide(\'';  echo $this->_tpl_vars['cd_edit']['title'];  echo '[show]\'); show(\'';  echo $this->_tpl_vars['cd_edit']['title'];  echo '\'); return false;"><img src="';  echo $this->_tpl_vars['config']->resourceBase;  echo 'i/TreePlus.gif" class="action-icon" alt="';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'open section';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '"/></a><label>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo '';  echo $this->_tpl_vars['cd_edit']['title'];  echo '';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</label><br /></div><div id="';  echo $this->_tpl_vars['cd_edit']['title'];  echo '" class="form-item"><fieldset><legend><a href="#" onclick="hide(\'';  echo $this->_tpl_vars['cd_edit']['title'];  echo '\'); show(\'';  echo $this->_tpl_vars['cd_edit']['title'];  echo '[show]\'); return false;"><img src="';  echo $this->_tpl_vars['config']->resourceBase;  echo 'i/TreeMinus.gif" class="action-icon" alt="';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'close section';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '"/></a>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo '';  echo $this->_tpl_vars['cd_edit']['title'];  echo '';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</legend>';  if ($this->_tpl_vars['cd_edit']['help_pre']):  echo '<div class="messages help">';  echo $this->_tpl_vars['cd_edit']['help_pre'];  echo '</div>';  endif;  echo '<dl>';  $_from = $this->_tpl_vars['cd_edit']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_id'] => $this->_tpl_vars['element']):
 echo '';  if ($this->_tpl_vars['element']['options_per_line'] != 0):  echo '';  $this->assign('element_name', ((is_array($_tmp='custom_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id'])));  echo '<dt>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label'];  echo '</dt><dd class="html-adjust">';  $this->assign('count', '1');  echo '';  echo '<table class="form-layout-compressed"><tr>';  echo '';  $this->assign('index', '1');  echo '';  $_from = $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['outer']['iteration']++;
 echo '';  if ($this->_tpl_vars['index'] < 10):  echo '';  $this->assign('index', ($this->_tpl_vars['index']+1));  echo '';  else:  echo '<td class="labels font-light">';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']][$this->_tpl_vars['key']]['html'];  echo '</td>';  if ($this->_tpl_vars['count'] == $this->_tpl_vars['element']['options_per_line']):  echo '</tr><tr>';  $this->assign('count', '1');  echo '';  else:  echo '';  $this->assign('count', ($this->_tpl_vars['count']+1));  echo '';  endif;  echo '';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</tr></table>';  echo '</dd>';  if ($this->_tpl_vars['element']['help_post']):  echo '<dt></dt><dd class="html-adjust description">';  echo $this->_tpl_vars['element']['help_post'];  echo '</dd>';  endif;  echo '';  else:  echo '';  $this->assign('name', ($this->_tpl_vars['element']['name']));  echo '';  $this->assign('element_name', ((is_array($_tmp='custom_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id'])));  echo '<dt>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label'];  echo '</dt><dd class="html-adjust"><span>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['html'];  echo '</span>';  if ($this->_tpl_vars['element']['data_type'] == 'Date'):  echo '';  if ($this->_tpl_vars['element']['skip_calendar'] != true):  echo '<span>';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/calendar/desc.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '';  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/calendar/body.tpl", 'smarty_include_vars' => array('dateVar' => $this->_tpl_vars['element_name'],'startDate' => $this->_tpl_vars['currentYear']-$this->_tpl_vars['element']['start_date_years'],'endDate' => $this->_tpl_vars['currentYear']+$this->_tpl_vars['element']['end_date_years'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  echo '</span>';  endif;  echo '';  endif;  echo '</dd>';  if ($this->_tpl_vars['element']['help_post']):  echo '<dt>&nbsp;</dt><dd class="html-adjust description">';  echo $this->_tpl_vars['element']['help_post'];  echo '</dd>';  endif;  echo '';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</dl><div class="spacer"></div>';  if ($this->_tpl_vars['cd_edit']['help_post']):  echo '<div class="messages help">';  echo $this->_tpl_vars['cd_edit']['help_post'];  echo '</div>';  endif;  echo '</fieldset></div>';  endforeach; endif; unset($_from);  echo ''; ?>


<?php if (! $this->_tpl_vars['mainEditForm']): ?>
<dl>
  <dt></dt><dd class="html-adjust"><?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</dd>
</dl>  
<?php endif; ?>

<script type="text/javascript"> 
    var showBlocks = new Array(<?php echo $this->_tpl_vars['showBlocks1']; ?>
); 
    var hideBlocks = new Array(<?php echo $this->_tpl_vars['hideBlocks1']; ?>
); 
 
 
    on_load_init_blocks( showBlocks, hideBlocks ); 
 </script> 
 
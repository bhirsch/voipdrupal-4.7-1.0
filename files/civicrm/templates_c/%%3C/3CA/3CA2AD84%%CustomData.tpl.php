<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:01
         compiled from CRM/Contact/Page/View/CustomData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Page/View/CustomData.tpl', 13, false),array('modifier', 'cat', 'CRM/Contact/Page/View/CustomData.tpl', 21, false),array('function', 'crmURL', 'CRM/Contact/Page/View/CustomData.tpl', 69, false),)), $this); ?>
<?php if ($this->_tpl_vars['action'] == 1 || $this->_tpl_vars['action'] == 2): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/CustomData.tpl", 'smarty_include_vars' => array('mainEdit' => $this->_tpl_vars['mainEditForm'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

    <?php echo '';  if ($this->_tpl_vars['action'] == 16 || $this->_tpl_vars['action'] == 4):  echo ' ';  echo '';  if ($this->_tpl_vars['groupTree']):  echo '<div class="form-item">';  $_from = $this->_tpl_vars['groupTree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group_id'] => $this->_tpl_vars['cd']):
 echo '<div id="';  echo $this->_tpl_vars['cd']['title'];  echo '[show]" class="data-group"><a href="#" onclick="hide(\'';  echo $this->_tpl_vars['cd']['title'];  echo '[show]\'); show(\'';  echo $this->_tpl_vars['cd']['title'];  echo '\'); return false;"><img src="';  echo $this->_tpl_vars['config']->resourceBase;  echo 'i/TreePlus.gif" class="action-icon" alt="';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'open section';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '"/></a><label>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo '';  echo $this->_tpl_vars['cd']['title'];  echo '';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</label><br /></div><div id="';  echo $this->_tpl_vars['cd']['title'];  echo '"><fieldset><legend><a href="#" onclick="hide(\'';  echo $this->_tpl_vars['cd']['title'];  echo '\'); show(\'';  echo $this->_tpl_vars['cd']['title'];  echo '[show]\'); return false;"><img src="';  echo $this->_tpl_vars['config']->resourceBase;  echo 'i/TreeMinus.gif" class="action-icon" alt="';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'close section';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '"/></a>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo '';  echo $this->_tpl_vars['cd']['title'];  echo '';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</legend><dl>';  $_from = $this->_tpl_vars['cd']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_id'] => $this->_tpl_vars['cd_value']):
 echo '';  if ($this->_tpl_vars['cd_value']['options_per_line'] != 0):  echo '';  $this->assign('element_name', ((is_array($_tmp='custom_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id'])));  echo '<dt>';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label'];  echo ' </dt><dd class="html-adjust">';  if ($this->_tpl_vars['form'][$this->_tpl_vars['element_name']]):  echo '';  $this->assign('count', '1');  echo '';  $this->assign('no', '1');  echo '';  echo '<table class="form-layout-compressed"><tr>';  echo '';  $this->assign('index', '1');  echo '';  $_from = $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['outer']['iteration']++;
 echo '';  if ($this->_tpl_vars['index'] < 10):  echo '';  $this->assign('index', ($this->_tpl_vars['index']+1));  echo '';  else:  echo '<td class="labels font-light">';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']][$this->_tpl_vars['key']]['html'];  echo '</td>';  if ($this->_tpl_vars['count'] == $this->_tpl_vars['cd_value']['options_per_line']):  echo '';  echo '</tr><tr>';  $this->assign('count', '1');  echo '';  else:  echo '';  $this->assign('count', ($this->_tpl_vars['count']+1));  echo '';  endif;  echo '';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</tr></table>';  echo '';  else:  echo '&nbsp;';  endif;  echo '</dd>';  else:  echo '';  $this->assign('name', ($this->_tpl_vars['cd_value']['name']));  echo '';  $this->assign('element_name', ((is_array($_tmp='custom_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id'])));  echo '<dt>';  echo $this->_tpl_vars['cd_value']['label'];  echo '</dt>';  echo '<dd class="html-adjust">';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['html'];  echo '</dd>';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</dl><div class="spacer"></div></fieldset></div>';  endforeach; endif; unset($_from);  echo '';  if ($this->_tpl_vars['editCustomData']):  echo '<div class="action-link">';  if ($this->_tpl_vars['groupId']):  echo '<a href="';  echo CRM_Utils_System::crmURL(array('p' => "civicrm/contact/view/cd",'q' => "cid=".($this->_tpl_vars['contactId'])."&gid=".($this->_tpl_vars['groupId'])."&action=update&reset=1"), $this); echo '">&raquo; ';  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['groupTree'][$this->_tpl_vars['groupId']]['title'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Edit %1';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a>';  endif;  echo '</div>';  endif;  echo '</div>';  endif;  echo '';  endif;  echo ''; ?>


<?php if ($this->_tpl_vars['mainEditForm']): ?>
<script type="text/javascript"> 
    var showBlocks1 = new Array(<?php echo $this->_tpl_vars['showBlocks1']; ?>
); 
    var hideBlocks1 = new Array(<?php echo $this->_tpl_vars['hideBlocks1']; ?>
); 
 
    on_load_init_blocks( showBlocks1, hideBlocks1 ); 
</script>
<?php else: ?>
<script type="text/javascript">
    var showBlocks = new Array(<?php echo $this->_tpl_vars['showBlocks']; ?>
);
    var hideBlocks = new Array(<?php echo $this->_tpl_vars['hideBlocks']; ?>
);

        on_load_init_blocks( showBlocks, hideBlocks );
</script>
<?php endif; ?>
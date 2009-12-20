<?php /* Smarty version 2.6.12-dev, created on 2006-08-03 17:25:52
         compiled from CRM/Custom/Form/Search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Custom/Form/Search.tpl', 5, false),array('modifier', 'cat', 'CRM/Custom/Form/Search.tpl', 18, false),array('modifier', 'crmReplace', 'CRM/Custom/Form/Search.tpl', 60, false),)), $this); ?>
<?php if ($this->_tpl_vars['groupTree']):  $_from = $this->_tpl_vars['groupTree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group_id'] => $this->_tpl_vars['cd_edit']):
 if ($this->_tpl_vars['showHideLinks']): ?>
  <div id="<?php echo $this->_tpl_vars['cd_edit']['title']; ?>
[show]" class="data-group">
    <a href="#" onClick="hide('<?php echo $this->_tpl_vars['cd_edit']['title']; ?>
[show]'); show('<?php echo $this->_tpl_vars['cd_edit']['title']; ?>
'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['cd_edit']['title'];  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
  </div>
<?php endif; ?>

  <div id="<?php echo $this->_tpl_vars['cd_edit']['title']; ?>
">
  <p>
  <fieldset><legend>
<?php if ($this->_tpl_vars['showHideLinks']): ?>
<a href="#" onClick="hide('<?php echo $this->_tpl_vars['cd_edit']['title']; ?>
'); show('<?php echo $this->_tpl_vars['cd_edit']['title']; ?>
[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"></a>
<?php endif;  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo $this->_tpl_vars['cd_edit']['title'];  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <dl>
    <?php $_from = $this->_tpl_vars['cd_edit']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_id'] => $this->_tpl_vars['element']):
?>
      <?php $this->assign('element_name', ((is_array($_tmp='custom_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id']))); ?>
      <?php if ($this->_tpl_vars['element']['options_per_line'] != 0): ?>
         <dt><?php echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label']; ?>
</dt>
         <dd>
            <?php $this->assign('count', '1'); ?>
            <?php echo '<table class="form-layout-compressed"><tr>';  echo '';  $this->assign('index', '1');  echo '';  $_from = $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['outer']['iteration']++;
 echo '';  if ($this->_tpl_vars['index'] < 10):  echo '';  $this->assign('index', ($this->_tpl_vars['index']+1));  echo '';  else:  echo '<td class="labels font-light">';  echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']][$this->_tpl_vars['key']]['html'];  echo '</td>';  if ($this->_tpl_vars['count'] == $this->_tpl_vars['element']['options_per_line']):  echo '</tr><tr>';  $this->assign('count', '1');  echo '';  else:  echo '';  $this->assign('count', ($this->_tpl_vars['count']+1));  echo '';  endif;  echo '';  endif;  echo '';  endforeach; endif; unset($_from);  echo '</tr><tr><td>';  if ($this->_tpl_vars['element']['html_type'] == 'Radio'):  echo '&nbsp; <a href="#" title="unselect" onclick="unselectRadio(\'';  echo $this->_tpl_vars['element_name'];  echo '\', \'';  echo $this->_tpl_vars['form']['formName'];  echo '\'); return false;" >unselect</a>';  endif;  echo '</td></tr></table>'; ?>

            </dd>
        	<?php else: ?>
                  <?php $this->assign('type', ($this->_tpl_vars['element']['html_type'])); ?>
  	          <?php $this->assign('element_name', ((is_array($_tmp='custom_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['field_id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['field_id']))); ?>
  	          <?php if ($this->_tpl_vars['element']['is_search_range']): ?>
                     <?php $this->assign('element_name_from', ((is_array($_tmp=$this->_tpl_vars['element_name'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_from') : smarty_modifier_cat($_tmp, '_from'))); ?>
                     <?php $this->assign('element_name_to', ((is_array($_tmp=$this->_tpl_vars['element_name'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_to') : smarty_modifier_cat($_tmp, '_to'))); ?>
			<dt><?php echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name_from']]['label']; ?>
</dt><dd>
			 <?php echo ((is_array($_tmp=$this->_tpl_vars['form'][$this->_tpl_vars['element_name_from']]['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'six') : smarty_modifier_crmReplace($_tmp, 'class', 'six')); ?>

	                 &nbsp;&nbsp;<?php echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name_to']]['label']; ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['form'][$this->_tpl_vars['element_name_to']]['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'six') : smarty_modifier_crmReplace($_tmp, 'class', 'six')); ?>

	    <?php else: ?>
			<dt><?php echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form'][$this->_tpl_vars['element_name']]['html']; ?>

		  <?php endif; ?>
		  <?php if ($this->_tpl_vars['element']['html_type'] == 'Radio'): ?>
	 	     &nbsp; <a href="#" title="unselect" onclick="unselectRadio('<?php echo $this->_tpl_vars['element_name']; ?>
', '<?php echo $this->_tpl_vars['form']['formName']; ?>
'); return false;" >unselect</a>
                   <?php endif; ?>
                   </dd>
	    <?php endif; ?>
	    <?php endforeach; endif; unset($_from); ?>
	    </dl>
	 </fieldset>
	 </p>
    </div>
  <?php endforeach; endif; unset($_from);  endif; ?>

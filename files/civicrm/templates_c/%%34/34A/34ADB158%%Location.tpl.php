<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:02
         compiled from CRM/Contact/Form/Location.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Location.tpl', 12, false),)), $this); ?>


 <?php unset($this->_sections['locationLoop']);
$this->_sections['locationLoop']['name'] = 'locationLoop';
$this->_sections['locationLoop']['start'] = (int)1;
$this->_sections['locationLoop']['loop'] = is_array($_loop=$this->_tpl_vars['locationCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['locationLoop']['show'] = true;
$this->_sections['locationLoop']['max'] = $this->_sections['locationLoop']['loop'];
$this->_sections['locationLoop']['step'] = 1;
if ($this->_sections['locationLoop']['start'] < 0)
    $this->_sections['locationLoop']['start'] = max($this->_sections['locationLoop']['step'] > 0 ? 0 : -1, $this->_sections['locationLoop']['loop'] + $this->_sections['locationLoop']['start']);
else
    $this->_sections['locationLoop']['start'] = min($this->_sections['locationLoop']['start'], $this->_sections['locationLoop']['step'] > 0 ? $this->_sections['locationLoop']['loop'] : $this->_sections['locationLoop']['loop']-1);
if ($this->_sections['locationLoop']['show']) {
    $this->_sections['locationLoop']['total'] = min(ceil(($this->_sections['locationLoop']['step'] > 0 ? $this->_sections['locationLoop']['loop'] - $this->_sections['locationLoop']['start'] : $this->_sections['locationLoop']['start']+1)/abs($this->_sections['locationLoop']['step'])), $this->_sections['locationLoop']['max']);
    if ($this->_sections['locationLoop']['total'] == 0)
        $this->_sections['locationLoop']['show'] = false;
} else
    $this->_sections['locationLoop']['total'] = 0;
if ($this->_sections['locationLoop']['show']):

            for ($this->_sections['locationLoop']['index'] = $this->_sections['locationLoop']['start'], $this->_sections['locationLoop']['iteration'] = 1;
                 $this->_sections['locationLoop']['iteration'] <= $this->_sections['locationLoop']['total'];
                 $this->_sections['locationLoop']['index'] += $this->_sections['locationLoop']['step'], $this->_sections['locationLoop']['iteration']++):
$this->_sections['locationLoop']['rownum'] = $this->_sections['locationLoop']['iteration'];
$this->_sections['locationLoop']['index_prev'] = $this->_sections['locationLoop']['index'] - $this->_sections['locationLoop']['step'];
$this->_sections['locationLoop']['index_next'] = $this->_sections['locationLoop']['index'] + $this->_sections['locationLoop']['step'];
$this->_sections['locationLoop']['first']      = ($this->_sections['locationLoop']['iteration'] == 1);
$this->_sections['locationLoop']['last']       = ($this->_sections['locationLoop']['iteration'] == $this->_sections['locationLoop']['total']);
?>
 <?php $this->assign('index', $this->_sections['locationLoop']['index']); ?>

 <div id="location[<?php echo $this->_tpl_vars['index']; ?>
][show]" class="data-group label">
    <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['show']['html'];  if ($this->_tpl_vars['index'] == 1):  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Primary Location<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Additional Location<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?>
 </div>
<div id="location[<?php echo $this->_tpl_vars['index']; ?>
]">
	<fieldset>
    <legend><?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['hide']['html']; ?>

        <?php if ($this->_tpl_vars['index'] == 1):  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Primary Location<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Additional Location<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?>
    </legend>
    <div class="form-item">
        <!-- Location type drop-down (e.g. Home, Work...) -->
        <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['location_type_id']['html']; ?>


        <!-- Checkbox for "make this the primary location" -->
        <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['is_primary']['html']; ?>


        &nbsp; &nbsp; <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['name']['label']; ?>

        <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['name']['html']; ?>

    </div>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Phone.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Email.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/IM.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Address.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 

    </fieldset>
</div> <!-- End of Location block div -->
<?php endfor; endif; ?>

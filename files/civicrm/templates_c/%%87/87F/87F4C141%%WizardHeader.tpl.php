<?php /* Smarty version 2.6.12-dev, created on 2006-10-05 20:16:42
         compiled from CRM/WizardHeader.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/WizardHeader.tpl', 20, false),)), $this); ?>
<?php if (count ( $this->_tpl_vars['wizard']['steps'] ) > 1): ?>
<div id="wizard-steps">
   <ul class="wizard-bar">
    <?php unset($this->_sections['step']);
$this->_sections['step']['name'] = 'step';
$this->_sections['step']['loop'] = is_array($_loop=$this->_tpl_vars['wizard']['steps']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['step']['show'] = true;
$this->_sections['step']['max'] = $this->_sections['step']['loop'];
$this->_sections['step']['step'] = 1;
$this->_sections['step']['start'] = $this->_sections['step']['step'] > 0 ? 0 : $this->_sections['step']['loop']-1;
if ($this->_sections['step']['show']) {
    $this->_sections['step']['total'] = $this->_sections['step']['loop'];
    if ($this->_sections['step']['total'] == 0)
        $this->_sections['step']['show'] = false;
} else
    $this->_sections['step']['total'] = 0;
if ($this->_sections['step']['show']):

            for ($this->_sections['step']['index'] = $this->_sections['step']['start'], $this->_sections['step']['iteration'] = 1;
                 $this->_sections['step']['iteration'] <= $this->_sections['step']['total'];
                 $this->_sections['step']['index'] += $this->_sections['step']['step'], $this->_sections['step']['iteration']++):
$this->_sections['step']['rownum'] = $this->_sections['step']['iteration'];
$this->_sections['step']['index_prev'] = $this->_sections['step']['index'] - $this->_sections['step']['step'];
$this->_sections['step']['index_next'] = $this->_sections['step']['index'] + $this->_sections['step']['step'];
$this->_sections['step']['first']      = ($this->_sections['step']['iteration'] == 1);
$this->_sections['step']['last']       = ($this->_sections['step']['iteration'] == $this->_sections['step']['total']);
?>
        <?php if ($this->_tpl_vars['wizard']['currentStepNumber'] > $this->_sections['step']['iteration']): ?>
            <?php $this->assign('stepClass', "past-step"); ?>
            <?php $this->assign('stepPrefix', "&radic;"); ?>
        <?php elseif ($this->_tpl_vars['wizard']['currentStepNumber'] == $this->_sections['step']['iteration']): ?>
            <?php $this->assign('stepClass', "current-step"); ?>
            <?php $this->assign('stepPrefix', "&raquo;"); ?>
        <?php else: ?>
            <?php $this->assign('stepClass', "future-step"); ?>
            <?php $this->assign('stepPrefix', ""); ?>
        <?php endif; ?> 
        <li class="<?php echo $this->_tpl_vars['stepClass']; ?>
"><?php echo $this->_tpl_vars['stepPrefix']; ?>
 <?php echo $this->_sections['step']['iteration']; ?>
. <?php echo $this->_tpl_vars['wizard']['steps'][$this->_sections['step']['index']]['title']; ?>
</li>
    <?php endfor; endif; ?>
   </ul>
</div>

<h2><?php echo $this->_tpl_vars['wizard']['currentStepTitle']; ?>
 <?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['wizard']['currentStepNumber'],'2' => $this->_tpl_vars['wizard']['stepCount'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>(step %1 of %2)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></h2>
<?php endif; ?>

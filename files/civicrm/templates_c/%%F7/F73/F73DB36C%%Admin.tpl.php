<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:46:26
         compiled from CRM/Admin/Page/Admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Admin/Page/Admin.tpl', 8, false),array('modifier', 'replace', 'CRM/Admin/Page/Admin.tpl', 27, false),)), $this); ?>
<?php $this->assign('itemsPerRow', 5); ?>

<?php if ($this->_tpl_vars['newVersion']): ?>
    <div class="messages status">
        <dl>
        <dt><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/Inform.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>status<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></dt>
        <dd>
            <p><?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['newVersion'],'2' => $this->_tpl_vars['localVersion'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>A newer version of CiviCRM is available: %1 (this site is currently running %2).<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></p>
            <p><?php $this->_tag_stack[] = array('ts', array('1' => 'http://www.openngo.org/','2' => 'http://downloads.openngo.org/civicrm/')); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Read about the new version on <a href="%1">our website</a> and <a href="%2">download it here</a>.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></p>
        </dd>
      </dl>
    </div>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['adminPanel']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['groupName'] => $this->_tpl_vars['group']):
?>
    <fieldset><legend><?php echo $this->_tpl_vars['groupName']; ?>
</legend>
        <table class="control-panel">
        <?php $this->assign('i', 1); ?>
        <?php $_from = $this->_tpl_vars['group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['groupLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['groupLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['panelItem']):
        $this->_foreach['groupLoop']['iteration']++;
?>
            <?php if ($this->_tpl_vars['i'] == 1 || ( $this->_tpl_vars['i'] % $this->_tpl_vars['itemsPerRow'] == 1 )): ?>
                <tr>
            <?php endif; ?>
            <td>
                <a href="<?php echo $this->_tpl_vars['panelItem']['url']; ?>
"<?php if ($this->_tpl_vars['panelItem']['extra']): ?> <?php echo $this->_tpl_vars['panelItem']['extra'];  endif; ?>><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/<?php echo $this->_tpl_vars['panelItem']['icon']; ?>
" alt="<?php echo $this->_tpl_vars['panelItem']['title']; ?>
"/></a><br >
                <a href="<?php echo $this->_tpl_vars['panelItem']['url']; ?>
"<?php if ($this->_tpl_vars['panelItem']['extra']): ?> <?php echo $this->_tpl_vars['panelItem']['extra'];  endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['panelItem']['title'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', "<br />") : smarty_modifier_replace($_tmp, ' ', "<br />")); ?>
</a>
            </td>
            <?php if ($this->_tpl_vars['i'] % $this->_tpl_vars['itemsPerRow'] == 0): ?>
                </tr>
            <?php endif; ?>
            <?php if (($this->_foreach['groupLoop']['iteration'] == $this->_foreach['groupLoop']['total']) == false): ?>
                <?php $this->assign('i', ($this->_tpl_vars['i']+1)); ?>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        
                <?php $this->assign('j', ($this->_tpl_vars['i']%$this->_tpl_vars['itemsPerRow'])); ?>
        <?php if ($this->_tpl_vars['j'] > 0): ?>
            <?php unset($this->_sections['moreCells']);
$this->_sections['moreCells']['name'] = 'moreCells';
$this->_sections['moreCells']['start'] = (int)0;
$this->_sections['moreCells']['loop'] = is_array($_loop=$this->_tpl_vars['itemsPerRow']-$this->_tpl_vars['j']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['moreCells']['show'] = true;
$this->_sections['moreCells']['max'] = $this->_sections['moreCells']['loop'];
$this->_sections['moreCells']['step'] = 1;
if ($this->_sections['moreCells']['start'] < 0)
    $this->_sections['moreCells']['start'] = max($this->_sections['moreCells']['step'] > 0 ? 0 : -1, $this->_sections['moreCells']['loop'] + $this->_sections['moreCells']['start']);
else
    $this->_sections['moreCells']['start'] = min($this->_sections['moreCells']['start'], $this->_sections['moreCells']['step'] > 0 ? $this->_sections['moreCells']['loop'] : $this->_sections['moreCells']['loop']-1);
if ($this->_sections['moreCells']['show']) {
    $this->_sections['moreCells']['total'] = min(ceil(($this->_sections['moreCells']['step'] > 0 ? $this->_sections['moreCells']['loop'] - $this->_sections['moreCells']['start'] : $this->_sections['moreCells']['start']+1)/abs($this->_sections['moreCells']['step'])), $this->_sections['moreCells']['max']);
    if ($this->_sections['moreCells']['total'] == 0)
        $this->_sections['moreCells']['show'] = false;
} else
    $this->_sections['moreCells']['total'] = 0;
if ($this->_sections['moreCells']['show']):

            for ($this->_sections['moreCells']['index'] = $this->_sections['moreCells']['start'], $this->_sections['moreCells']['iteration'] = 1;
                 $this->_sections['moreCells']['iteration'] <= $this->_sections['moreCells']['total'];
                 $this->_sections['moreCells']['index'] += $this->_sections['moreCells']['step'], $this->_sections['moreCells']['iteration']++):
$this->_sections['moreCells']['rownum'] = $this->_sections['moreCells']['iteration'];
$this->_sections['moreCells']['index_prev'] = $this->_sections['moreCells']['index'] - $this->_sections['moreCells']['step'];
$this->_sections['moreCells']['index_next'] = $this->_sections['moreCells']['index'] + $this->_sections['moreCells']['step'];
$this->_sections['moreCells']['first']      = ($this->_sections['moreCells']['iteration'] == 1);
$this->_sections['moreCells']['last']       = ($this->_sections['moreCells']['iteration'] == $this->_sections['moreCells']['total']);
?>
                <td>&nbsp;</td>
            <?php endfor; endif; ?>
            </tr>
        <?php endif; ?>
        </table>
    </fieldset>
<?php endforeach; endif; unset($_from); ?>

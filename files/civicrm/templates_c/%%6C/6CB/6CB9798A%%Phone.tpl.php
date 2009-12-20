<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:02
         compiled from CRM/Contact/Form/Phone.tpl */ ?>
 
 
 
    <div class="form-item">
        <span class="labels">
            <label><?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone']['1']['phone']['label']; ?>
</label>
        </span>
        <span class="fields">
            <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone']['1']['phone_type']['html'];  echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone']['1']['phone']['html']; ?>

            <!-- Link to add a field.-->
            <span id="location[<?php echo $this->_tpl_vars['index']; ?>
][phone][2][show]" class="add-remove-link">
                <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone']['2']['show']['html']; ?>

            </span>
        </span>

    </div>
    <!-- Spacer div contains floated elements -->
    <div class="spacer"></div>

    <?php unset($this->_sections['innerLoop']);
$this->_sections['innerLoop']['name'] = 'innerLoop';
$this->_sections['innerLoop']['start'] = (int)2;
$this->_sections['innerLoop']['loop'] = is_array($_loop=$this->_tpl_vars['blockCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['innerLoop']['show'] = true;
$this->_sections['innerLoop']['max'] = $this->_sections['innerLoop']['loop'];
$this->_sections['innerLoop']['step'] = 1;
if ($this->_sections['innerLoop']['start'] < 0)
    $this->_sections['innerLoop']['start'] = max($this->_sections['innerLoop']['step'] > 0 ? 0 : -1, $this->_sections['innerLoop']['loop'] + $this->_sections['innerLoop']['start']);
else
    $this->_sections['innerLoop']['start'] = min($this->_sections['innerLoop']['start'], $this->_sections['innerLoop']['step'] > 0 ? $this->_sections['innerLoop']['loop'] : $this->_sections['innerLoop']['loop']-1);
if ($this->_sections['innerLoop']['show']) {
    $this->_sections['innerLoop']['total'] = min(ceil(($this->_sections['innerLoop']['step'] > 0 ? $this->_sections['innerLoop']['loop'] - $this->_sections['innerLoop']['start'] : $this->_sections['innerLoop']['start']+1)/abs($this->_sections['innerLoop']['step'])), $this->_sections['innerLoop']['max']);
    if ($this->_sections['innerLoop']['total'] == 0)
        $this->_sections['innerLoop']['show'] = false;
} else
    $this->_sections['innerLoop']['total'] = 0;
if ($this->_sections['innerLoop']['show']):

            for ($this->_sections['innerLoop']['index'] = $this->_sections['innerLoop']['start'], $this->_sections['innerLoop']['iteration'] = 1;
                 $this->_sections['innerLoop']['iteration'] <= $this->_sections['innerLoop']['total'];
                 $this->_sections['innerLoop']['index'] += $this->_sections['innerLoop']['step'], $this->_sections['innerLoop']['iteration']++):
$this->_sections['innerLoop']['rownum'] = $this->_sections['innerLoop']['iteration'];
$this->_sections['innerLoop']['index_prev'] = $this->_sections['innerLoop']['index'] - $this->_sections['innerLoop']['step'];
$this->_sections['innerLoop']['index_next'] = $this->_sections['innerLoop']['index'] + $this->_sections['innerLoop']['step'];
$this->_sections['innerLoop']['first']      = ($this->_sections['innerLoop']['iteration'] == 1);
$this->_sections['innerLoop']['last']       = ($this->_sections['innerLoop']['iteration'] == $this->_sections['innerLoop']['total']);
?>
       <?php $this->assign('innerIndex', $this->_sections['innerLoop']['index']); ?>

    <!-- Phone block <?php echo $this->_tpl_vars['innerIndex']; ?>
.-->
    <div id="location[<?php echo $this->_tpl_vars['index']; ?>
][phone][<?php echo $this->_tpl_vars['innerIndex']; ?>
]" class="form-item">
        <span class="labels">
            <label><?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone'][$this->_tpl_vars['innerIndex']]['phone']['label']; ?>
</label>
        </span>
        <span class="fields">
            <span><?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone'][$this->_tpl_vars['innerIndex']]['phone_type']['html']; ?>
</span><span><?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone'][$this->_tpl_vars['innerIndex']]['phone']['html']; ?>
</span>
            <!-- Link to hide this field -->
            <span id="location[<?php echo $this->_tpl_vars['index']; ?>
][phone][<?php echo $this->_tpl_vars['innerIndex']; ?>
][hide]" class="add-remove-link element-right">
            <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone'][$this->_tpl_vars['innerIndex']]['hide']['html']; ?>

            </span>
            <!-- Link to add another field.-->
            <?php if ($this->_tpl_vars['innerIndex'] < $this->_tpl_vars['blockCount']): ?>
            <?php $this->assign('j', $this->_tpl_vars['innerIndex']+1); ?>
            <span id="location[<?php echo $this->_tpl_vars['index']; ?>
][phone][<?php echo $this->_tpl_vars['j']; ?>
][show]" class="add-remove-link">
                <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['phone'][$this->_tpl_vars['j']]['show']['html']; ?>

            </span>        
             
                        <?php endif; ?>
        </span>
		
        <!-- Spacer div contains floated elements -->
        <div class="spacer"></div>
	 </div>

	<?php endfor; endif; ?>
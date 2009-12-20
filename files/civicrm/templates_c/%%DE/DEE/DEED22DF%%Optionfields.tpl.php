<?php /* Smarty version 2.6.12-dev, created on 2006-07-11 11:08:10
         compiled from CRM/Custom/Form/Optionfields.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Custom/Form/Optionfields.tpl', 1, false),array('function', 'cycle', 'CRM/Custom/Form/Optionfields.tpl', 17, false),)), $this); ?>
<fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Multiple Choice Options<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <div class="description">
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Enter up to ten (10) multiple choice options in this table (click 'another choice' for each additional choice). If desired, you can mark one of the choices as the default choice. The option 'label' is displayed on the form, while the option 'value' is stored in the contact record. The label and value may be the same or different. Inactive options are hidden when the field is presented.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
    </div>
	<?php echo '<table><tr><th>&nbsp;</th><th> ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Defaults';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th> ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Label';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th> ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Value';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th> ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Weight';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th><th> ';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Active?';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th></tr>';  unset($this->_sections['rowLoop']);
$this->_sections['rowLoop']['name'] = 'rowLoop';
$this->_sections['rowLoop']['start'] = (int)1;
$this->_sections['rowLoop']['loop'] = is_array($_loop=12) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['rowLoop']['show'] = true;
$this->_sections['rowLoop']['max'] = $this->_sections['rowLoop']['loop'];
$this->_sections['rowLoop']['step'] = 1;
if ($this->_sections['rowLoop']['start'] < 0)
    $this->_sections['rowLoop']['start'] = max($this->_sections['rowLoop']['step'] > 0 ? 0 : -1, $this->_sections['rowLoop']['loop'] + $this->_sections['rowLoop']['start']);
else
    $this->_sections['rowLoop']['start'] = min($this->_sections['rowLoop']['start'], $this->_sections['rowLoop']['step'] > 0 ? $this->_sections['rowLoop']['loop'] : $this->_sections['rowLoop']['loop']-1);
if ($this->_sections['rowLoop']['show']) {
    $this->_sections['rowLoop']['total'] = min(ceil(($this->_sections['rowLoop']['step'] > 0 ? $this->_sections['rowLoop']['loop'] - $this->_sections['rowLoop']['start'] : $this->_sections['rowLoop']['start']+1)/abs($this->_sections['rowLoop']['step'])), $this->_sections['rowLoop']['max']);
    if ($this->_sections['rowLoop']['total'] == 0)
        $this->_sections['rowLoop']['show'] = false;
} else
    $this->_sections['rowLoop']['total'] = 0;
if ($this->_sections['rowLoop']['show']):

            for ($this->_sections['rowLoop']['index'] = $this->_sections['rowLoop']['start'], $this->_sections['rowLoop']['iteration'] = 1;
                 $this->_sections['rowLoop']['iteration'] <= $this->_sections['rowLoop']['total'];
                 $this->_sections['rowLoop']['index'] += $this->_sections['rowLoop']['step'], $this->_sections['rowLoop']['iteration']++):
$this->_sections['rowLoop']['rownum'] = $this->_sections['rowLoop']['iteration'];
$this->_sections['rowLoop']['index_prev'] = $this->_sections['rowLoop']['index'] - $this->_sections['rowLoop']['step'];
$this->_sections['rowLoop']['index_next'] = $this->_sections['rowLoop']['index'] + $this->_sections['rowLoop']['step'];
$this->_sections['rowLoop']['first']      = ($this->_sections['rowLoop']['iteration'] == 1);
$this->_sections['rowLoop']['last']       = ($this->_sections['rowLoop']['iteration'] == $this->_sections['rowLoop']['total']);
 echo '';  $this->assign('index', $this->_sections['rowLoop']['index']);  echo '<tr id="optionField[';  echo $this->_tpl_vars['index'];  echo ']" class="form-item ';  echo smarty_function_cycle(array('values' => "odd-row,even-row"), $this); echo '"><td>';  if ($this->_tpl_vars['index'] > 1):  echo '<a onclick="hiderow(\'optionField[';  echo $this->_tpl_vars['index'];  echo ']\'); return false;" name="optionField[';  echo $this->_tpl_vars['index'];  echo ']" href="#optionField[';  echo $this->_tpl_vars['index'];  echo ']" class="form-link"><img src="';  echo $this->_tpl_vars['config']->resourceBase;  echo 'i/TreeMinus.gif" class="action-icon" alt="';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'hide field or section';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '"/></a>';  endif;  echo '</td><td><div id="radio';  echo $this->_tpl_vars['index'];  echo '" style="display:none">';  echo $this->_tpl_vars['form']['default_option'][$this->_tpl_vars['index']]['html'];  echo '</div><div id="checkbox';  echo $this->_tpl_vars['index'];  echo '" style="display:none">';  echo $this->_tpl_vars['form']['default_checkbox_option'][$this->_tpl_vars['index']]['html'];  echo '</div></td><td> ';  echo $this->_tpl_vars['form']['option_label'][$this->_tpl_vars['index']]['html'];  echo '</td><td> ';  echo $this->_tpl_vars['form']['option_value'][$this->_tpl_vars['index']]['html'];  echo '</td><td> ';  echo $this->_tpl_vars['form']['option_weight'][$this->_tpl_vars['index']]['html'];  echo '</td><td> ';  echo $this->_tpl_vars['form']['option_status'][$this->_tpl_vars['index']]['html'];  echo '</td></tr>';  endfor; endif;  echo '</table><div id="optionFieldLink" class="add-remove-link"><a onclick="showrow(); return false;" name="optionFieldLink" href="#optionFieldLink" class="form-link"><img src="';  echo $this->_tpl_vars['config']->resourceBase;  echo 'i/TreePlus.gif" class="action-icon" alt="';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'show field or section';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '"/>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'another choice';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</a></div><div id="additionalOption" class="description">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'If you need additional options - you can add them after you Save your current entries.';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</div>'; ?>

    
</fieldset>
<script type="text/javascript">
    var showRows   = new Array(<?php echo $this->_tpl_vars['showBlocks']; ?>
);
    var hideBlocks = new Array(<?php echo $this->_tpl_vars['hideBlocks']; ?>
);
    var rowcounter = 0;
    <?php echo '
    if (navigator.appName == "Microsoft Internet Explorer") {    
	for ( var count = 0; count < hideBlocks.length; count++ ) {
	    var r = document.getElementById(hideBlocks[count]);
            r.style.display = \'none\';
        }
    }
    '; ?>

        on_load_init_blocks( showRows, hideBlocks, 'table-row' );
</script>
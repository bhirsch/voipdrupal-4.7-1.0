<?php /* Smarty version 2.6.12-dev, created on 2006-10-05 20:18:12
         compiled from CRM/Contact/Form/Task/Export/table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Task/Export/table.tpl', 5, false),)), $this); ?>
 <div id="map-field">
    <?php if ($this->_tpl_vars['savedMapping']): ?>
    <div>
	<a href="#" onclick="mappingOption(); return false;" >&raquo; <?php if ($this->_tpl_vars['loadedMapping']):  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Select a Different Mapping<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Load Saved Field Mapping<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></a>
    </div>
    <div id="savedMappingOption">
	<span><?php echo $this->_tpl_vars['form']['savedMapping']['label']; ?>
</span>&nbsp;<span><?php echo $this->_tpl_vars['form']['savedMapping']['html']; ?>
</span>
        <span><?php echo $this->_tpl_vars['form']['loadMapping']['html']; ?>
</span> 
    </div>
    
    <script type="text/javascript">
	hide('savedMappingOption');
	document.getElementById("savedMapping").disabled = true;	
	<?php echo '
	function mappingOption() {
		if (document.getElementById("savedMappingOption").style.display == "block") {
		    hide(\'savedMappingOption\');
		    document.getElementById("savedMapping").disabled = true;
		    return false;
		} else {
		    show(\'savedMappingOption\');
		    document.getElementById("savedMapping").disabled = false;
		    return false;
		}
	}
		
	'; ?>

    </script>
    
    <?php endif; ?>

    <?php echo '<table>';  if ($this->_tpl_vars['loadedMapping']):  echo '<tr class="columnheader-dark"><th colspan="4">';  $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['savedName'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Using Field Mapping: %1';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</td></tr>';  endif;  echo '<tr class="columnheader"><th>';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Fields to Include in Export File';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</th></tr>';  echo '';  unset($this->_sections['cols']);
$this->_sections['cols']['name'] = 'cols';
$this->_sections['cols']['loop'] = is_array($_loop=$this->_tpl_vars['columnCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cols']['show'] = true;
$this->_sections['cols']['max'] = $this->_sections['cols']['loop'];
$this->_sections['cols']['step'] = 1;
$this->_sections['cols']['start'] = $this->_sections['cols']['step'] > 0 ? 0 : $this->_sections['cols']['loop']-1;
if ($this->_sections['cols']['show']) {
    $this->_sections['cols']['total'] = $this->_sections['cols']['loop'];
    if ($this->_sections['cols']['total'] == 0)
        $this->_sections['cols']['show'] = false;
} else
    $this->_sections['cols']['total'] = 0;
if ($this->_sections['cols']['show']):

            for ($this->_sections['cols']['index'] = $this->_sections['cols']['start'], $this->_sections['cols']['iteration'] = 1;
                 $this->_sections['cols']['iteration'] <= $this->_sections['cols']['total'];
                 $this->_sections['cols']['index'] += $this->_sections['cols']['step'], $this->_sections['cols']['iteration']++):
$this->_sections['cols']['rownum'] = $this->_sections['cols']['iteration'];
$this->_sections['cols']['index_prev'] = $this->_sections['cols']['index'] - $this->_sections['cols']['step'];
$this->_sections['cols']['index_next'] = $this->_sections['cols']['index'] + $this->_sections['cols']['step'];
$this->_sections['cols']['first']      = ($this->_sections['cols']['iteration'] == 1);
$this->_sections['cols']['last']       = ($this->_sections['cols']['iteration'] == $this->_sections['cols']['total']);
 echo '';  $this->assign('i', $this->_sections['cols']['index']);  echo '<tr>';  unset($this->_sections['rows']);
$this->_sections['rows']['name'] = 'rows';
$this->_sections['rows']['loop'] = is_array($_loop=$this->_tpl_vars['rowDisplayCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['rows']['show'] = true;
$this->_sections['rows']['max'] = $this->_sections['rows']['loop'];
$this->_sections['rows']['step'] = 1;
$this->_sections['rows']['start'] = $this->_sections['rows']['step'] > 0 ? 0 : $this->_sections['rows']['loop']-1;
if ($this->_sections['rows']['show']) {
    $this->_sections['rows']['total'] = $this->_sections['rows']['loop'];
    if ($this->_sections['rows']['total'] == 0)
        $this->_sections['rows']['show'] = false;
} else
    $this->_sections['rows']['total'] = 0;
if ($this->_sections['rows']['show']):

            for ($this->_sections['rows']['index'] = $this->_sections['rows']['start'], $this->_sections['rows']['iteration'] = 1;
                 $this->_sections['rows']['iteration'] <= $this->_sections['rows']['total'];
                 $this->_sections['rows']['index'] += $this->_sections['rows']['step'], $this->_sections['rows']['iteration']++):
$this->_sections['rows']['rownum'] = $this->_sections['rows']['iteration'];
$this->_sections['rows']['index_prev'] = $this->_sections['rows']['index'] - $this->_sections['rows']['step'];
$this->_sections['rows']['index_next'] = $this->_sections['rows']['index'] + $this->_sections['rows']['step'];
$this->_sections['rows']['first']      = ($this->_sections['rows']['iteration'] == 1);
$this->_sections['rows']['last']       = ($this->_sections['rows']['iteration'] == $this->_sections['rows']['total']);
 echo '';  $this->assign('j', $this->_sections['rows']['index']);  echo '<td class="';  if ($this->_tpl_vars['skipColumnHeader'] && $this->_sections['rows']['iteration'] == 1):  echo 'even-row labels';  else:  echo 'odd-row';  endif;  echo '">';  echo $this->_tpl_vars['dataValues'][$this->_tpl_vars['j']][$this->_tpl_vars['i']];  echo '</td>';  endfor; endif;  echo '<td class="form-item even-row">';  echo $this->_tpl_vars['form']['mapper'][$this->_tpl_vars['i']]['html'];  echo '</td></tr>';  endfor; endif;  echo '<tr><td class="form-item even-row">';  echo $this->_tpl_vars['form']['addMore']['html'];  echo '</td></tr></table>'; ?>



    <div>
	<?php if ($this->_tpl_vars['loadedMapping']): ?>
<span><?php echo $this->_tpl_vars['form']['updateMapping']['html'];  echo $this->_tpl_vars['form']['updateMapping']['label']; ?>
&nbsp;&nbsp;&nbsp;</span>
	<?php endif; ?>
	<span><?php echo $this->_tpl_vars['form']['saveMapping']['html'];  echo $this->_tpl_vars['form']['saveMapping']['label']; ?>
</span>
	<div id="saveDetails" class="form-item">
	      <dl>
		   <dt><?php echo $this->_tpl_vars['form']['saveMappingName']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['saveMappingName']['html']; ?>
</dd>
		   <dt><?php echo $this->_tpl_vars['form']['saveMappingDesc']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['saveMappingDesc']['html']; ?>
<dd>
	      </dl>
	</div>
	

	<script type="text/javascript">
         <?php if ($this->_tpl_vars['mappingDetailsError']): ?>
            show('saveDetails');    
         <?php else: ?>
    	    hide('saveDetails');
         <?php endif; ?>

	     <?php echo '   
 	     function showSaveDetails(chkbox) {
    		 if (chkbox.checked) {
    			document.getElementById("saveDetails").style.display = "block";
    			document.getElementById("saveMappingName").disabled = false;
    			document.getElementById("saveMappingDesc").disabled = false;
    		 } else {
    			document.getElementById("saveDetails").style.display = "none";
    			document.getElementById("saveMappingName").disabled = true;
    			document.getElementById("saveMappingDesc").disabled = true;
    		 }
         }
         '; ?>
	     
	</script>
    </div>

 </div>
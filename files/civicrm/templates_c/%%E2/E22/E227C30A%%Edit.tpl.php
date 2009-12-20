<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:01
         compiled from CRM/Contact/Form/Edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Edit.tpl', 16, false),array('modifier', 'crmReplace', 'CRM/Contact/Form/Edit.tpl', 28, false),)), $this); ?>
    


  <script type="text/javascript" src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
js/Individual.js"></script>
 
 <div class="crm-submit-buttons">
    <?php echo $this->_tpl_vars['form']['buttons']['html']; ?>

 </div>

<?php if ($this->_tpl_vars['contact_type'] == 'Individual'): ?>
 <div id="name">
 <fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Name and Greeting<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
	<table class="form-layout">
    <tr>
		<td><?php echo $this->_tpl_vars['form']['prefix_id']['label']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['first_name']['label']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['middle_name']['label']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['last_name']['label']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['suffix_id']['label']; ?>
</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['form']['prefix_id']['html']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['first_name']['html']; ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['middle_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'eight') : smarty_modifier_crmReplace($_tmp, 'class', 'eight')); ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['last_name']['html']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['suffix_id']['html']; ?>
</td>
	</tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo $this->_tpl_vars['form']['job_title']['label']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['greeting_type']['label']; ?>
</td>
        <td colspan="2"><?php echo $this->_tpl_vars['form']['nick_name']['label']; ?>
 &nbsp; </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo $this->_tpl_vars['form']['job_title']['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['greeting_type']['html']; ?>
</td>
        <td colspan="2"><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['nick_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>
</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="3"><?php echo $this->_tpl_vars['form']['home_URL']['label']; ?>
</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="3"><?php echo $this->_tpl_vars['form']['home_URL']['html']; ?>
</td>
        <td>&nbsp;</td>
    </tr>
    </table>

    <?php echo $this->_tpl_vars['form']['_qf_Edit_refresh_dedupe']['html']; ?>

    <?php if ($this->_tpl_vars['isDuplicate']): ?>&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['_qf_Edit_next_duplicate']['html'];  endif; ?>
    <div class="spacer"></div>
 </fieldset>
 </div>
<?php elseif ($this->_tpl_vars['contact_type'] == 'Household'): ?>
<div id="name">
 <fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Household<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <div class="form-item">
        <span class="labels"><?php echo $this->_tpl_vars['form']['household_name']['label']; ?>
</span>
        <span class="fields">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['form']['household_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>

        </span>
    </div>

    <div class="form-item">
        <span class="labels"><?php echo $this->_tpl_vars['form']['nick_name']['label']; ?>
</span>
        <span class="fields">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['form']['nick_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>

        </span>
    </div>

    <!-- Spacer div forces fieldset to contain floated elements -->
    <div class="spacer"></div>
 </fieldset>
 </div>
<?php elseif ($this->_tpl_vars['contact_type'] == 'Organization'): ?>
<div id="name">
 <fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Organization<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
	<table class="form-layout">
    <tr>
		<td><?php echo $this->_tpl_vars['form']['organization_name']['label']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['legal_name']['label']; ?>
</td>
		<td><?php echo $this->_tpl_vars['form']['sic_code']['label']; ?>
</td>
    </tr>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['organization_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['legal_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['sic_code']['html']; ?>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['form']['home_URL']['label']; ?>
</td>
		<td colspan="2"><?php echo $this->_tpl_vars['form']['nick_name']['label']; ?>
</td>
	</tr>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['home_URL']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>
</td>
        <td colspan="2"><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['nick_name']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'big') : smarty_modifier_crmReplace($_tmp, 'class', 'big')); ?>
</td>
    </tr>
    </table>
</fieldset>
</div>
<?php endif; ?>

 
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/CommPrefs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 
 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Page/View/CustomData.tpl", 'smarty_include_vars' => array('mainEditForm' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Location.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['contact_type'] == 'Individual'): ?>
 <div id = "demographics[show]" class="data-group label">
    <?php echo $this->_tpl_vars['demographics']['show'];  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Demographics<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
 </div>

 <div id="demographics">
 <fieldset><legend><?php echo $this->_tpl_vars['demographics']['hide'];  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Demographics<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <div class="form-item">
        <span class="labels">
        <?php echo $this->_tpl_vars['form']['gender_id']['label']; ?>

        </span>
        <span class="fields">
        <?php echo $this->_tpl_vars['form']['gender_id']['html']; ?>

        </span>
    </div>
	<div class="form-item">
        <span class="labels">
        <?php echo $this->_tpl_vars['form']['birth_date']['label']; ?>

        </span>
        <span class="fields">
		<?php echo $this->_tpl_vars['form']['birth_date']['html']; ?>

                <div class="description"> 
                   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/calendar/desc.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
        </span>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/calendar/body.tpl", 'smarty_include_vars' => array('dateVar' => 'birth_date','startDate' => 1905,'endDate' => 'currentYear')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
	<div class="form-item">
        <?php echo $this->_tpl_vars['form']['is_deceased']['html']; ?>

        <?php echo $this->_tpl_vars['form']['is_deceased']['label']; ?>

    </div>
  </fieldset>
 </div>
<?php endif; ?>  

 
  <?php if ($this->_tpl_vars['action'] == 1): ?>
     <div id = "notes[show]" class="data-group">
        <?php echo $this->_tpl_vars['notes']['show']; ?>
<label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Notes<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label>
     </div>

     <div id = "notes">
         <fieldset><legend><?php echo $this->_tpl_vars['notes']['hide'];  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Contact Notes<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
            <div class="form-item">
                <?php echo $this->_tpl_vars['form']['note']['html']; ?>

            </div>
         </fieldset>
     </div>
<?php endif; ?>
 <!-- End of "notes" div -->

  
<div id="group[show]" class="data-group">
    <a href="#" onclick="hide('group[show]'); show('group'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreePlus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>open section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Tags and Groups<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
</div>

<div id="group">
    <fieldset><legend><a href="#" onclick="hide('group'); show('group[show]'); return false;"><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/TreeMinus.gif" class="action-icon" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>close section<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"/></a><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Tags and Groups<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <?php echo '<div class="form-item"><table class="form-layout"><tr><td><div class="label">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Group(s)';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</div><div class="listing-box">';  echo $this->_tpl_vars['form']['group']['html'];  echo '</div></td><td><div class="label">';  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start();  echo 'Tag(s)';  $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  echo '</div><div class="listing-box">';  echo $this->_tpl_vars['form']['tag']['html'];  echo '</div></td></tr></table></div>'; ?>

    <div class="spacer"> </div>
    </fieldset>
</div>

 <div class="crm-submit-buttons">
    <?php echo $this->_tpl_vars['form']['buttons']['html']; ?>

 </div>

 <script type="text/javascript">
    var showBlocks = new Array(<?php echo $this->_tpl_vars['showBlocks']; ?>
);
    var hideBlocks = new Array(<?php echo $this->_tpl_vars['hideBlocks']; ?>
);

    on_load_init_blocks( showBlocks, hideBlocks );
 </script>
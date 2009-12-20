<?php /* Smarty version 2.6.12-dev, created on 2006-07-11 10:35:49
         compiled from CRM/UF/Form/Field.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/UF/Form/Field.tpl', 6, false),array('modifier', 'crmReplace', 'CRM/UF/Form/Field.tpl', 60, false),)), $this); ?>

<fieldset><legend><?php if ($this->_tpl_vars['action'] == 8):  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Delete CiviCRM Profile Field<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>CiviCRM Profile Field<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
<?php if ($this->_tpl_vars['action'] != 8): ?>     <div id="crm-submit-buttons" class="form-item"> 
    <dl> 
    <?php if ($this->_tpl_vars['action'] != 4): ?> 
        <dt>&nbsp;</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</dd> 
    <?php else: ?> 
        <dt>&nbsp;</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['done']['html']; ?>
</dd> 
    <?php endif; ?>  
    </dl> 
    </div> 
<?php endif; ?>     
    <div class="form-item">
    <?php if ($this->_tpl_vars['action'] == 8): ?>
      	<div class="messages status">
        <dl>
          <dt><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/Inform.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>status<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"></dt>
          <dd>    
            <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>WARNING: Deleting this profile field will remove it from Profile forms and listings. If this field is used in any 'stand-alone' Profile forms, you will need to update those forms to remove this field.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?> <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Do you want to continue?<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
          </dd>
       </dl>
      </div>
    <?php else: ?>
        <dl>
        <dt><?php echo $this->_tpl_vars['form']['field_name']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['field_name']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt> </dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Select the type of CiviCRM record and the field you want to include in this Profile.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['label']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['label']['html']; ?>
</dd>       
        <dt><?php echo $this->_tpl_vars['form']['is_required']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['is_required']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Are users required to complete this field?<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['is_view']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['is_view']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>If checked, users can view but not edit this field.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['visibility']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['visibility']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Is this field hidden from other users ('User and User Admin Only'), or is it visible to others ('Public User Pages')? Select 'Public User Pages and Listings' to make the field searchable (in the Profile Search form). When visibility is 'Public User Pages and Listings', users can also click the field value when viewing a contact in order to locate other contacts with the same value(s) (i.e. other contacts who live in Poland).<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['in_selector']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['in_selector']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Is this field visible in the selector table displayed in profile searches? This setting applies only to fields with 'Public User Pages and Listings' visibility.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['weight']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['weight']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Weight controls the order in which fields are displayed within a profile. Enter a positive or negative integer - lower numbers are displayed ahead of higher numbers.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['is_searchable']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['is_searchable']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Do you want to include this field in the profile's search form?<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['help_post']['label']; ?>
</dt><dd>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['form']['help_post']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'huge') : smarty_modifier_crmReplace($_tmp, 'class', 'huge')); ?>
</dd>
        <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd class="description">&nbsp;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Explanatory text displayed to users for this field.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
        <?php endif; ?>
        <dt><?php echo $this->_tpl_vars['form']['is_active']['label']; ?>
</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['is_active']['html']; ?>
</dd>
	    </dl>
    </div>
    
    <div id="crm-submit-buttons" class="form-item">
    <dl>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt>&nbsp;</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</dd>
    <?php else: ?>
        <dt>&nbsp;</dt><dd>&nbsp;<?php echo $this->_tpl_vars['form']['done']['html']; ?>
</dd>
    <?php endif; ?>     </dl>
    </div>

</fieldset>

 <?php echo $this->_tpl_vars['initHideBoxes']; ?>


<?php echo '
<script type="text/javascript">
	function showLabel( ) {

       if (document.forms.Field[\'field_name[0]\'].options[document.forms.Field[\'field_name[0]\'].selectedIndex].value) { 
          var labelValue = document.forms.Field[\'field_name[1]\'].options[document.forms.Field[\'field_name[1]\'].selectedIndex].text; 

          if (document.forms.Field[\'field_name[3]\'].value) { 
              labelValue = labelValue + \'-\' + document.forms.Field[\'field_name[3]\'].options[document.forms.Field[\'field_name[3]\'].selectedIndex].text + \'\'; 
          }   
          if (document.forms.Field[\'field_name[2]\'].value) { 
              labelValue = labelValue + \' (\' + document.forms.Field[\'field_name[2]\'].options[document.forms.Field[\'field_name[2]\'].selectedIndex].text + \')\'; 
           }   
       } else {
           labelValue = \'\';  
       }

       var input = document.getElementById(\'label\');
       input.value = labelValue;
    } 
</script> 
'; ?>

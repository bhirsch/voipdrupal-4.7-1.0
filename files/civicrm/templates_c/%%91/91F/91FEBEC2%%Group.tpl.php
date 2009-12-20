<?php /* Smarty version 2.6.12-dev, created on 2006-07-11 10:36:48
         compiled from CRM/UF/Form/Group.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/UF/Form/Group.tpl', 4, false),array('modifier', 'crmReplace', 'CRM/UF/Form/Group.tpl', 37, false),array('function', 'crmURL', 'CRM/UF/Form/Group.tpl', 65, false),)), $this); ?>

<div class="form-item">
    <fieldset><legend><?php if ($this->_tpl_vars['action'] == 8):  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Delete CiviCRM Profile<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  else:  $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>CiviCRM Profile<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack);  endif; ?></legend>
	<?php if ($this->_tpl_vars['action'] == 8): ?>
      <div class="messages status">
        <dl>
          <dt><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/Inform.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>status<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"></dt>
          <dd>    
          <?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['title'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Delete %1 Profile?<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
          </dd>
       </dl>
      </div>
    <?php else: ?>
    <dl>
    <dt><?php echo $this->_tpl_vars['form']['title']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['title']['html']; ?>
</dd>
        <?php if ($this->_tpl_vars['config']->userFramework == 'Drupal' || $this->_tpl_vars['otherModuleString']): ?>
        <dt><?php echo $this->_tpl_vars['form']['uf_group_type']['label']; ?>
</dt><dd><?php if ($this->_tpl_vars['config']->userFramework == 'Drupal'):  echo $this->_tpl_vars['form']['uf_group_type']['html']; ?>
&nbsp;<?php endif;  echo $this->_tpl_vars['otherModuleString']; ?>
</dd>
        <dt>&nbsp;</dt><dd class="description">
        <?php ob_start(); ?>&lt;<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>site root<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>&gt;<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('siteRoot', ob_get_contents());ob_end_clean(); ?>
        <table class="form-layout-compressed">
        <tr><td><?php $this->_tag_stack[] = array('ts', array('1' => ($this->_tpl_vars['siteRoot'])."/civicrm/profile?reset=1&gid=3")); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Profiles can be explicitly linked to a module page. Any Profile form/listings page can also be linked directly by adding it's ID to the civicrm/profile path. (Example: <em>%1</em>)<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        <?php if ($this->_tpl_vars['config']->userFramework == 'Drupal'): ?>
        <ul>
            <li><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Check <strong>User Registration</strong> if you want this Profile to be included in the New Account registration form.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
            <li><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Check <strong>View/Edit User Account</strong> to include it in the view and edit screens for existing user accounts.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
            <li><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Check <strong>Profile</strong> if you want it included in the default contact listing and view screens for the civicrm/profile path.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        </ul>
        <?php endif; ?>
        </td></tr></table></dd>
    <?php endif; ?>
    <dt><?php echo $this->_tpl_vars['form']['weight']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['weight']['html']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Weight controls the order in which profiles are presented when there are more than one. Enter a positive or negative integer - lower numbers are displayed ahead of higher numbers.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['group']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['group']['html']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Select a group if are using the profile for search and listings, AND you want to limit the listings to members of a specific group.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['help_pre']['label']; ?>
</dt><dd><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['help_pre']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'huge') : smarty_modifier_crmReplace($_tmp, 'class', 'huge')); ?>
&nbsp;</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Explanatory text displayed at the beginning of the fieldset.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['help_post']['label']; ?>
</dt><dd><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['help_post']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'huge') : smarty_modifier_crmReplace($_tmp, 'class', 'huge')); ?>
&nbsp;</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Explanatory text displayed at the end of the fieldset.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['post_URL']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['post_URL']['html']; ?>
</dd>  
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>If you are using this profile as a contact signup or edit form, and want to redirect the user to a static URL after they've submitted the form - enter the complete URL here. If this field is left blank, the profile form will be redisplayed with a generic status message - 'Your contact information has been saved.'<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    
    <dt></dt><dd><?php echo $this->_tpl_vars['form']['is_active']['html']; ?>
 <?php echo $this->_tpl_vars['form']['is_active']['label']; ?>
</dd>
   
    
    </dl>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt></dt>
        <dd>
        <div id="crm-submit-buttons"><?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</div>
        </dd>
    <?php else: ?>
        <div id="crm-done-button">
        <dt></dt><dd><?php echo $this->_tpl_vars['form']['done']['html']; ?>
</dd>
        </div>
    <?php endif; ?> 			
    </fieldset>
</div>
<?php if ($this->_tpl_vars['action'] == 2 || $this->_tpl_vars['action'] == 4): ?>     <p></p>
    <div class="action-link">
    <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/admin/uf/group/field','q' => "action=browse&reset=1&gid=".($this->_tpl_vars['gid'])), $this);?>
">&raquo;  <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>View or Edit Fields for this Profile<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
    </div>
<?php endif; ?>
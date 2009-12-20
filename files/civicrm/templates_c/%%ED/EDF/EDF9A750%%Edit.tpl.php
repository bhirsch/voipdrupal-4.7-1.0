<?php /* Smarty version 2.6.12-dev, created on 2006-08-03 17:24:56
         compiled from CRM/Group/Form/Edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'crmURL', 'CRM/Group/Form/Edit.tpl', 4, false),array('block', 'ts', 'CRM/Group/Form/Edit.tpl', 5, false),)), $this); ?>
<div id="help">
    <?php if ($this->_tpl_vars['action'] == 2): ?>
        <?php ob_start();  echo CRM_Utils_System::crmURL(array('p' => "civicrm/group/search",'q' => "reset=1&force=1&context=smog&gid=".($this->_tpl_vars['group']['id'])), $this); $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('crmURL', ob_get_contents());ob_end_clean(); ?>
        <?php $this->_tag_stack[] = array('ts', array('1' => $this->_tpl_vars['crmURL'])); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>You can edit the Name and Description for this group here. Click <a href="%1">Show Group Members</a> from Manage Groups to view, add or remove contacts in this group.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
    <?php else: ?>
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Enter a unique name and a description for your new group here. Then click 'Continue' to find contacts to add to your new group.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
    <?php endif; ?>
</div>
<div class="form-item">
<fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Group Settings<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <dl>
        <dt><?php echo $this->_tpl_vars['form']['title']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['title']['html'];  if ($this->_tpl_vars['group']['saved_search_id']): ?>&nbsp;(<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Smart Group<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>)<?php endif; ?></dd>
        <dt><?php echo $this->_tpl_vars['form']['description']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['description']['html']; ?>
</dd>
        <dt><?php echo $this->_tpl_vars['form']['visibility']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['visibility']['html']; ?>
</dd>
        <dt>&nbsp;</dt>
        <dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Select 'User and User Admin Only' if membership in this group is controlled by authorized CiviCRM users only. If you want to allow contacts to join and remove themselves from this group via the Registration and Account Profile forms, select 'Public User Pages'. If you also want to include group membership search and sharing in the Profile screens, select 'Public User Pages and Listings'.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd> 
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Page/View/CustomData.tpl", 'smarty_include_vars' => array('mainEditForm' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <dt>&nbsp;</dt><dd><?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</dd>
    </dl>
</fieldset>
</div>
<div class="action-link">
    <a href="<?php echo $this->_tpl_vars['crmURL']; ?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Show Group Members<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
    <?php if ($this->_tpl_vars['group']['saved_search_id']): ?>
        <br /><a href="<?php echo CRM_Utils_System::crmURL(array('p' => "civicrm/contact/search/advanced",'q' => "reset=1&force=1&ssID=".($this->_tpl_vars['group']['saved_search_id'])), $this);?>
">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Edit Smart Group Criteria<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
    <?php endif; ?>
<div>
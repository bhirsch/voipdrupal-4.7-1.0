<?php /* Smarty version 2.6.12-dev, created on 2006-07-11 11:07:07
         compiled from CRM/Custom/Form/Group.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Custom/Form/Group.tpl', 4, false),array('modifier', 'crmReplace', 'CRM/Custom/Form/Group.tpl', 21, false),array('function', 'crmURL', 'CRM/Custom/Form/Group.tpl', 43, false),)), $this); ?>

<div class="form-item">
    <fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Custom Data Group<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <div id="help">
        <p>
        <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Use this form to setup the title, group-level help, and display characteristics of each group of Custom Data fields. The 'Display Style' you select determines whether this group is edited and displayed on the same screens as the standard contact field ('Inline' style), or has it's own menu tab ('Tab' style).<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        </p>
    </div>
    <dl>
    <dt><?php echo $this->_tpl_vars['form']['title']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['title']['html']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>For 'inline' display custom groups, this name will appear as the fieldset legend. If this group uses the 'tab' display style, this name will be used for the navigation tab.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['extends']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['extends']['html']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Select the type of record that this group of custom fields is applicable for. You can configure custom data for a specific type of contact (e.g. Individuals but NOT Organizations), ANY type of contact, or other record types such as activities and contributions.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['weight']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['weight']['html']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Weight controls the order in which custom data groups are presented when there are more than one. Enter a positive or negative integer - lower numbers are displayed ahead of higher numbers.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['style']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['style']['html']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Select 'Inline' to include this group of fields in the main contact Add/Edit form and Contact Summary screens. Select 'Tab' to create a separate navigation tab for display and editing these values (generally for less frequently accessed and/or larger sets of fields).<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt>&nbsp;</dt><dd><?php echo $this->_tpl_vars['form']['collapse_display']['html']; ?>
 <?php echo $this->_tpl_vars['form']['collapse_display']['label']; ?>
</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Check this box if you want only the title for this fieldset to be displayed when the page is initially loaded (fields are hidden).<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['help_pre']['label']; ?>
</dt><dd><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['help_pre']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'huge') : smarty_modifier_crmReplace($_tmp, 'class', 'huge')); ?>
&nbsp;</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Explanatory text displayed at the beginning of this group of fields.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt><?php echo $this->_tpl_vars['form']['help_post']['label']; ?>
</dt><dd><?php echo ((is_array($_tmp=$this->_tpl_vars['form']['help_post']['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'class', 'huge') : smarty_modifier_crmReplace($_tmp, 'class', 'huge')); ?>
&nbsp;</dd>
    <dt>&nbsp;</dt><dd class="description"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Explanatory text displayed below this group of fields.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></dd>
    <dt></dt><dd><?php echo $this->_tpl_vars['form']['is_active']['html']; ?>
 <?php echo $this->_tpl_vars['form']['is_active']['label']; ?>
</dd>
    <?php if ($this->_tpl_vars['action'] != 4): ?>
        <dt></dt>
        <dd>
        <div id="crm-submit-buttons"><?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</div>
        </dd>
    <?php else: ?>
        <dt></dt>
        <dd>
        <div id="crm-done-button"><?php echo $this->_tpl_vars['form']['done']['html']; ?>
</div>
        </dd>
    <?php endif; ?>     </dl>
    </fieldset>
</div>
<?php if ($this->_tpl_vars['action'] == 2 || $this->_tpl_vars['action'] == 4): ?>     <p></p>
    <div class="action-link">
    <a href="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/admin/custom/group/field','q' => "action=browse&reset=1&gid=".($this->_tpl_vars['gid'])), $this);?>
">&raquo;  <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Custom Fields for this Group<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
    </div>
<?php endif; ?>
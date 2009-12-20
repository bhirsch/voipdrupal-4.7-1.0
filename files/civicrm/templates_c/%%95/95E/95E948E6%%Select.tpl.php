<?php /* Smarty version 2.6.12-dev, created on 2006-10-05 20:16:42
         compiled from CRM/Contact/Form/Task/Export/Select.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Task/Export/Select.tpl', 8, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/WizardHeader.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="help">
<p><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?><strong>Export PRIMARY contact fields</strong> provides the most commonly used data values. This includes primary address information, preferred phone and email, as well as all custom data.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></p>
<p><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Click <strong>Select fields for export</strong> and then <strong>Continue</strong> to choose a subset of fields for export. This option allows you to export multiple specific locations (Home, Work, etc.). You can also save your selections as a 'field mapping' so you can use it again later.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></p>
</div>

<div id="export-type" class="form-item">
 <fieldset>
    <dl>
        <dd>
         <?php $this->_tag_stack[] = array('ts', array('count' => $this->_tpl_vars['totalSelectedContacts'],'plural' => '%count records selected for export.')); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>One record selected for export.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
        </dd> 
        <dd><?php echo $this->_tpl_vars['form']['exportOption']['html']; ?>
</dd>
    </dl>
 </fieldset>
</div>
<div id="crm-submit-buttons">
    <?php echo $this->_tpl_vars['form']['buttons']['html']; ?>

</div>
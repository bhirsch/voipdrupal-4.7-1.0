<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:47:06
         compiled from CRM/Contact/Form/Domain.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Domain.tpl', 4, false),array('function', 'crmURL', 'CRM/Contact/Form/Domain.tpl', 20, false),)), $this); ?>

<div class="form-item">
<fieldset><legend><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Domain Information<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></legend>
    <dl>
        <dt><?php echo $this->_tpl_vars['form']['name']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['name']['html']; ?>
</dd>
        <dt><?php echo $this->_tpl_vars['form']['description']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['description']['html']; ?>
</dd>
        <dt><?php echo $this->_tpl_vars['form']['contact_name']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['contact_name']['html']; ?>
</dd>
        <dt><?php echo $this->_tpl_vars['form']['email_domain']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['email_domain']['html']; ?>
</dd>
        <dt><?php echo $this->_tpl_vars['form']['email_return_path']['label']; ?>
</dt><dd><?php echo $this->_tpl_vars['form']['email_return_path']['html']; ?>
</dd>
        <dt>&nbsp;</dt>
    </dl>
    </fieldset>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/Contact/Form/Location.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  if (! ( $this->_tpl_vars['action'] == 4 )):  echo $this->_tpl_vars['form']['buttons']['html']; ?>

<?php endif; ?>
        <?php if (( $this->_tpl_vars['action'] == 4 )): ?>
        <div class="action-link">
    	<a href="<?php echo CRM_Utils_System::crmURL(array('q' => "action=update&reset=1"), $this);?>
" id="editDomainInfo">&raquo; <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Edit Domain Information<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></a>
        </div>
        <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['emailDomain'] == true): ?>
<script type="text/javascript">
hide('location[1][show]');
hide('location[1][phone][2][show]');
hide('location[1][email][2][show]');
hide('location[1][im][2][show]');
</script>
<?php endif; ?>
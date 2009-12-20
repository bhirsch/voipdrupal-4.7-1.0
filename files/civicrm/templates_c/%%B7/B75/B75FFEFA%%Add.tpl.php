<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:53:35
         compiled from CRM/Block/Add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Block/Add.tpl', 5, false),)), $this); ?>
<div id="crm-quick-create">
<form action="<?php echo $this->_tpl_vars['postURL']; ?>
" method="post">

<div class="form-item">
    <label for="qa_first_name"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>First Name:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
    <input type="text" name="first_name" id="qa_first_name" class="form-text" maxlength="64" />
</div>

<div class="form-item">
    <label for="qa_last_name"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Last Name:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
    <input type="text" name="last_name" id="qa_last_name" class="form-text required" maxlength="64" />
</div>

<div class="form-item">
    <label for="qa_email"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Email:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label><br />
    <input type="text" name="location[1][email][1][email]" id="qa_email" class="form-text" maxlength="64" />
</div>

<input type="hidden" name="location[1][location_type_id]" value="<?php echo $this->_tpl_vars['primaryLocationType']; ?>
" />
<input type="hidden" name="location[1][is_primary]"       value="1" />
<input type="hidden" name="c_type"                        value="Individual" />

<div class="form-item"><input type="submit" name="_qf_Edit_next" value="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Save<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" class="form-submit" /></div>

</form>
</div>
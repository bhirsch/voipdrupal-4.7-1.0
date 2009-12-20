<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:02
         compiled from CRM/Contact/Form/Address/street_address.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Address/street_address.tpl', 8, false),)), $this); ?>
<div class="form-item">
    <span class="labels">
    <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['address']['street_address']['label']; ?>

    </span>
    <span class="fields">
    <?php echo $this->_tpl_vars['form']['location'][$this->_tpl_vars['index']]['address']['street_address']['html']; ?>

    <br class="spacer"/>
    <span class="description font-italic"><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Street number, street name, apartment/unit/suite - OR P.O. box<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></span>
    </span>
</div>
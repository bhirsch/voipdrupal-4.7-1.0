<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:01
         compiled from CRM/common/status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/common/status.tpl', 6, false),)), $this); ?>
<?php if ($this->_tpl_vars['session']->getStatus(false)): ?>
    <?php $this->assign('status', $this->_tpl_vars['session']->getStatus(true)); ?>
    <div class="messages status">
      <dl>
      <dt><img src="<?php echo $this->_tpl_vars['config']->resourceBase; ?>
i/Inform.gif" alt="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>status<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>"></dt>
      <dd>
        <?php if (is_array ( $this->_tpl_vars['status'] )): ?>
            <?php $_from = $this->_tpl_vars['status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['statLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['statLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['statItem']):
        $this->_foreach['statLoop']['iteration']++;
?>
                <?php if (($this->_foreach['statLoop']['iteration'] <= 1)): ?>
                    <h3><?php echo $this->_tpl_vars['statItem']; ?>
</h3>
                    <ul>
                <?php else: ?>
                    <li><?php echo $this->_tpl_vars['statItem']; ?>
</li>
                <?php endif; ?>
                </ul>
            <?php endforeach; endif; unset($_from); ?>
        <?php else: ?>
            <?php echo $this->_tpl_vars['status']; ?>

        <?php endif; ?>
      </dd>
      </dl>
    </div>
<?php endif; ?>
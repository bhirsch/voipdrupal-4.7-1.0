<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:42:28
         compiled from CRM/Contact/Form/Search/ResultTasks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/Contact/Form/Search/ResultTasks.tpl', 4, false),)), $this); ?>

 <div id="search-status">
  <?php if ($this->_tpl_vars['savedSearch']['name']):  echo $this->_tpl_vars['savedSearch']['name']; ?>
 (<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>smart group<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>) - <?php endif; ?>
    <?php if ($this->_tpl_vars['context'] == 'smog' || $this->_tpl_vars['ssID'] > 0): ?>
      <?php $this->_tag_stack[] = array('ts', array('count' => $this->_tpl_vars['pager']->_totalItems,'plural' => 'Found %count group members')); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Found %count group member<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
   <?php else: ?>
      <?php $this->_tag_stack[] = array('ts', array('count' => $this->_tpl_vars['pager']->_totalItems,'plural' => 'Found %count contacts')); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Found %count contact<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['qill']): ?>
    <ul>
    <?php $_from = $this->_tpl_vars['qill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['criteria']):
?>
      <li><?php echo $this->_tpl_vars['criteria']; ?>
</li>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
  <?php endif; ?>
 </div>

 <div class="form-item">
   <div>
          <?php if ($this->_tpl_vars['context'] != 'amtg'): ?>
        <?php if ($this->_tpl_vars['action'] == 512): ?>
          <?php echo $this->_tpl_vars['form']['_qf_Advanced_next_print']['html']; ?>
&nbsp;&nbsp;
        <?php else: ?>
          <?php echo $this->_tpl_vars['form']['_qf_Search_next_print']['html']; ?>
&nbsp;&nbsp;
        <?php endif; ?>
        <?php echo $this->_tpl_vars['form']['task']['html']; ?>

     <?php endif; ?>
     <?php if ($this->_tpl_vars['action'] == 512): ?>
       <?php echo $this->_tpl_vars['form']['_qf_Advanced_next_action']['html']; ?>

     <?php else: ?>
       <?php echo $this->_tpl_vars['form']['_qf_Search_next_action']['html']; ?>

     <?php endif; ?>
     <br />
     <label><?php echo $this->_tpl_vars['form']['radio_ts']['ts_sel']['html']; ?>
 <?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>selected records only<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label>&nbsp; <label><?php echo $this->_tpl_vars['form']['radio_ts']['ts_all']['html']; ?>
 <?php $this->_tag_stack[] = array('ts', array('count' => $this->_tpl_vars['pager']->_totalItems,'plural' => 'all %count records')); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>the found record<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label>
   </div>
 </div>  

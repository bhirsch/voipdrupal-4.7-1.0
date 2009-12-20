<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 15:42:29
         compiled from CRM/pager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/pager.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['pager'] && $this->_tpl_vars['pager']->_response): ?>
    <?php if ($this->_tpl_vars['pager']->_response['numPages'] > 1): ?>
        <div class="crm-pager">
          <span class="crm-pager-nav">
          <?php echo $this->_tpl_vars['pager']->_response['first']; ?>
&nbsp;
          <?php echo $this->_tpl_vars['pager']->_response['back']; ?>
&nbsp;
          <strong><?php echo $this->_tpl_vars['pager']->_response['status']; ?>
</strong>&nbsp;
          <?php echo $this->_tpl_vars['pager']->_response['next']; ?>
&nbsp;
          <?php echo $this->_tpl_vars['pager']->_response['last']; ?>
&nbsp;
          </span>
          <span class="element-right">
          <?php if ($this->_tpl_vars['location'] == 'top'): ?>
            <?php echo $this->_tpl_vars['pager']->_response['titleTop']; ?>
&nbsp;<input name="<?php echo $this->_tpl_vars['pager']->_response['buttonTop']; ?>
" value="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Go<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" type="submit"/>
          <?php else: ?>
            <?php echo $this->_tpl_vars['pager']->_response['titleBottom']; ?>
&nbsp;<input name="<?php echo $this->_tpl_vars['pager']->_response['buttonBottom']; ?>
" value="<?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Go<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>" type="submit"/>
          <?php endif; ?>
          </span>
        </div>
    <?php endif; ?>
    
        <?php if ($this->_tpl_vars['location'] == 'bottom' && $this->_tpl_vars['pager']->_totalItems > 25): ?>
     <div class="form-item float-right">
           <label><?php $this->_tag_stack[] = array('ts', array()); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Rows per page:<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?></label> &nbsp; 
           <?php echo $this->_tpl_vars['pager']->_response['twentyfive']; ?>
&nbsp; | &nbsp;
           <?php echo $this->_tpl_vars['pager']->_response['fifty']; ?>
&nbsp; | &nbsp;
           <?php echo $this->_tpl_vars['pager']->_response['onehundred']; ?>
&nbsp; 
     </div>
     <div class="spacer"></div>
    <?php endif; ?>

<?php endif; ?>
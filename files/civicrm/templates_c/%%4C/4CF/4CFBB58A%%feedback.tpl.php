<?php /* Smarty version 2.6.12-dev, created on 2006-07-10 13:58:02
         compiled from CRM/common/feedback.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'ts', 'CRM/common/feedback.tpl', 3, false),)), $this); ?>
<?php ob_start();
$_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/version.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
$this->assign('svn_revision', ob_get_contents()); ob_end_clean();
 ?>
<div class="footer" id="civicrm-footer"> 
<?php $this->_tag_stack[] = array('ts', array('1' => 'v1.4','2' => $this->_tpl_vars['svn_revision'],'3' => 'http://www.affero.org/oagpl.html','4' => 'http://downloads.openngo.org/civicrm/','5' => 'http://issues.civicrm.org/jira/browse/CRM?report=com.atlassian.jira.plugin.system.project:roadmap-panel','6' => 'http://wiki.civicrm.org/confluence/display/CRM/CiviCRM+Documentation')); smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat=true);while ($_block_repeat) { ob_start(); ?>Powered by CiviCRM %1 rev%2. CiviCRM is openly available under the <a href="%3">Affero General Public License (AGPL)</a>. <a href="%4">Download source</a>. <a href="%5">View issues and report bugs</a>. <a href="%6">Online documentation</a>.<?php $_block_content = ob_get_contents(); ob_end_clean(); echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat=false); }  array_pop($this->_tag_stack); ?>
</div> 
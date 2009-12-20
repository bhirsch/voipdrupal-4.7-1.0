<?php //$Id: node-og.tpl.php,v 1.3.2.2 2006/01/04 23:03:33 weitzman Exp $ 
?>
<div class="node<?php print ($sticky) ? " sticky" : ""; ?>">
  <?php if ($page == 0): ?>
    <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
  <?php endif; ?>


  <div class="content">
    <?php print $content ?>
  </div>

</div>

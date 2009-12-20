  <div class="block block-<?php print $block->module; ?>" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>">
    <?php if ($block->region == 'left') { ?>
      <?php if ($block->module != 'banner') { ?>
        <div class="title">
          <table width="184"  border="0" cellspacing="0" cellpadding="0">
            <tr background="<?php print base_path() . $directory; ?>/images/leftheaderback.gif">
              <td width="22" height="15" valign="top" background="<?php print base_path() . $directory; ?>/images/leftheaderback.gif"><img src="<?php print base_path() . $directory; ?>/images/leftheadertile.gif" width="22" height="15"></td>
              <td width="162" height="15" align="left" valign="top" background="<?php print base_path() . $directory; ?>/images/leftheaderback.gif"><?php $block_name = strtoupper(strip_tags($block->subject)); $pos = strpos($block_name, ' '); ?>
                <span class="left_first">
                  <?php if (!$pos) { print $block_name; } else { print substr($block_name, 0, $pos); } ?>
                </span>
                <span class="left_remainder">
                  <?php if ($pos) { print substr($block_name, $pos); } ?>
                </span>
              </td>
            </tr>
          </table>
        </div>
      <?php } ?>
      <?php if ($block->content) { ?>
        <div class="content">
          <table width="184"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><?php print $block->content; ?></td>
            </tr>
           </table>
         </div>
       <?php } ?>
    <?php } else { ?>
      <?php if ($block->module != 'banner') { ?>
        <div class="title">
          <table width="240"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td bgcolor="#000000" class="right_header" ><?php $block_name = strtoupper(strip_tags($block->subject)); ?>
                <span class="right_header">
                  <?php print $block_name; ?>
                </span>
              </td>
            </tr>
          </table>
        </div>
      <?php } ?>
        <?php if ($block->content) { ?>
          <div class="content">
          <table width="240"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><?php print $block->content; ?></td>
            </tr>
          </table>
        </div>
      <?php } ?>
    <?php } ?>
 </div>

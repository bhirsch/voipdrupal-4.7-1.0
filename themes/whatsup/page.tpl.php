<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
  <!-- script for google analytics -->
  <script src="http://www.google-analytics.com/urchin.js" type="text/javascript"> </script>
  <script type="text/javascript"> _uacct = "UA-1511572-1"; urchinTracker(); </script>
</head>

<body>
<div align="center">
<table bgcolor="#FFFFFF" width="924" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <table border="0" cellpadding="0" cellspacing="0" id="header">
      <tr>
	    <td id="logo">
	      <?php if ($logo) { ?><a href="<?php print $base_path ?>" title="<?php print t('Home')?>"><img src="<?php print $logo ?>" width="924" height="135" alt="<?php print t('Home') ?>" /></a><?php } ?>
	    </td>
      </tr>
	    <tr id="menu">
		  <td>
	      <?php if (isset($secondary_links)) { ?><div id="secondary"><?php print theme('links', $secondary_links) ?></div><?php } ?>
	      <?php if (isset($primary_links)) { ?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php } ?>
	      <?php print $search_box ?>
		  </td>
	    </tr>
      <tr>
	    <td colspan="2"><div><?php print $header ?></div></td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td bgcolor="#FFFFFF">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="content">
      <tr>
        <td width="1%"><img src="<?php print base_path() . $directory; ?>/images/spacer_left.gif" width="12" height="17"></td>
		<td width="184" id="sidebar-left"> 
	      <?php if ($sidebar_left) { print $sidebar_left ; } ?>		</td>
        <td width="2%"><img src="<?php print base_path() . $directory; ?>/images/spacers_mid.jpg" width="18" height="17"></td>
	    <td width="440" valign="top">
	      <?php if ($mission) { ?>
	        <div id="mission"> <?php print $mission ?> </div>
	      <?php } ?>
		  <?php if ($is_front) { ?>
              
			 <div id="pic"><img src="<?php print base_path() . $directory; ?>/images/welcome.jpg" width="440" height="195"></div>
			<?php } else {?> 
		    <div id="breadcrum"><?php print $breadcrumb ?></div> 
			
			<?php }?>  	
		    <div id="main">
			<h1 class="title"><?php print $title ?></h1>
		    <div class="tabs"><?php print $tabs ?></div>
		    <?php print $help ?>
		    <div id="msgs"><?php print $messages ?></div>
			
		    <?php print $content; ?>
	      </div>	  </td>
      <td width="2%"><img src="<?php print base_path() . $directory; ?>/images/spacers_mid.jpg" width="18" height="17"></td>
	  <td width="240" id="sidebar-right">
	    <?php if ($sidebar_right) { print $sidebar_right; } ?>      </td>
	  <td width="1%">&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr>
<td>
<div id="footer">
  <?php print $footer_message ?>
</div>
<?php print $closure ?>
</td>
</tr>
</table>
</div>
</body>
</html>

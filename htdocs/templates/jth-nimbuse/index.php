<?php
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
$jth = 0;
if ($this->countModules('left') == 0 && $this->countModules('right') == 0 ) { $jth = 1; }
if ($this->countModules('left') && $this->countModules('right') == 0) { $jth = 2; }
if ($this->countModules('left') == 0 && $this->countModules('right')) { $jth = 3; }
if ($this->countModules('left') && $this->countModules('right')) { $jth = 4; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head><jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/template.css" type="text/css" />
<?php if ($this->countModules('hornav')): ?>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/js/moomenu.js"></script>
<?php endif; ?>
<!--[if lte IE 6]>
<style>
#hornav ul li ul {
left: -999em;
margin-top: 0px;
margin-left: 0px;
}
.jth-top, .jth-bottom, .jth  {  behavior: url("templates/jth-nimbuse/js/iepngfix.htc"); }
</style>
<![endif]-->
</head>
<body>
<div id="jth-top" class="jth-top"></div>
<div id="jth" class="jth">
<div id="jth-nimbuse-top">
		<div class="jth-nimbuse-top-"></div>
		<div class="jth-nimbuse-top">
			<div id="jth-nimbuse-top-menu"><jdoc:include type="modules" name="user1" /></div>
			<div id="jth-nimbuse-top-second"><jdoc:include type="modules" name="user2" /></div>
		</div>
</div>
<div id="jth-nimbuse-menu"><div id="hornav"><jdoc:include type="modules" name="hornav" /></div></div>
<?php if ($this->countModules('breadcrumb') || $this->countModules('user3')) { ?><div id="jth_nimbuse-w">
	<div id="jth_nimbuse-wb">You are here :<jdoc:include type="modules" name="breadcrumb" /></div>
	<div id="jth_nimbuse-ws"><jdoc:include type="modules" name="user3" style="xhtml" /></div>
</div><?php } ?>
<?php if ($this->countModules('jth-user1') || $this->countModules('jth-user2')) { ?>
<div id="jth-users-top">
	<div class="jth-users1"><jdoc:include type="modules" name="jth-user1" style="xhtml" /></div>
	<div class="jth-users2"><jdoc:include type="modules" name="jth-user2" style="xhtml" /></div>
	<div style="clear: both;"></div>
</div>
<?php } ?>
<div id="jth-nimbuse">	
	<div id="jth-nimbuse-center<?php echo $jth ?>">				
		<?php if ($this->countModules('left')) { ?><div id="jth-nimbuse-center-left"><jdoc:include type="modules" name="left" style="rounded" /></div><?php } ?>	
		<div id="jth-nimbuse-center-center<?php echo $jth ?>">
		<div id="jth-nimbuse-center-center-center<?php echo $jth ?>"><jdoc:include type="component" />
		<div id="jth-advert1"><jdoc:include type="modules" name="jth-advert1" /></div>		
		</div>
		</div>		
		<?php if ($this->countModules('right')) { ?><div id="jth-nimbuse-center-right"><jdoc:include type="modules" name="right" style="rounded" /></div><?php } ?>	
		<div style="clear: both;"></div></div>
</div>
<?php if ($this->countModules('jth-user3') || $this->countModules('jth-user4')) { ?>
<div id="jth-users-bottom" class="clearfix">
	<div class="jth-users3"><jdoc:include type="modules" name="jth-user3" style="xhtml" /></div>
	<div class="jth-users4"><jdoc:include type="modules" name="jth-user4" style="xhtml" /></div>
</div>
<?php } ?>
<div id="jth-bottom-menu" class="clearfix">
<div id="jth-bottom-menu-left"><jdoc:include type="modules" name="footer" /></div>
<div id="jth-bottom-menu-right"></div>
</div>
</div>
<div id="jth-bottom" class="jth-bottom"><a href="http://www.joomlatheme.net">JoomlaTheme.net</a></div>
</body>
</html>
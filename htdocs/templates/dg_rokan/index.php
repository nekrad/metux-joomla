<?php
/**
 * @copyright	Copyright (C) 2008 Tobacamp. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 * dg_rokan is a free template for Joomla! 1.5.
 * @author	Tobacamp-Dani Gunawan <tobacamp@gmail.com>
 * @url		http://tobacamp.com
 *
 * Affiliate with Tobacamp <http://tobacamp.com>. Please link back to our site if you are using this template. Thank you.
 * Contact us if you need custom template.
 *
 * Tobacamp, Joomla! Templates & Extensions
 * More templates & extensions at http://tobacamp.com
 *
 * Enjoy it!
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" /> 
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link href="<?php echo $this->baseurl ?>/templates/dg_rokan/css/template.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->baseurl ?>/templates/dg_rokan/css/joomla.css" rel="stylesheet" type="text/css"/>
<!--[if lte IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/dg_rokan/css/patch_template.css" rel="stylesheet" type="text/css" />
<style type="text/css">
 img { behavior: url(<?php echo $this->baseurl ?>/templates/dg_rokan/css/iepngfix.htc) }
</style>
<![endif]-->
</head>
<body>
<div id="page_margins">
	<div id="page">
		<div id="header">
	        <div id="topnav"><jdoc:include type="modules" name="topnav" /></div>
			<img src="<?php echo $this->baseurl ?>/templates/dg_rokan/images/logo_tobacamp.png" alt="logo tobacamp" longdesc="http://tobacamp.com" />
        </div>
		<!-- begin: main navigation #nav -->
		<div id="nav"> 
			<div id="nav_main">
				<jdoc:include type="modules" name="user3" />
			</div>
		</div>
		<!-- end: main navigation -->
        <div id="teaser"><jdoc:include type="modules" name="breadcrumb" /></div>
		<!-- begin: main content area #main -->
		<div id="main">
			<!-- begin: #col1 - first float column -->
			<div id="col1">
				<div id="col1_content" class="clearfix">
					<jdoc:include type="modules" name="banner" style="xhtml" />
                    <jdoc:include type="message" />
					<div class="subcolumns">
						<div class="c50l">
							<div class="subcl">
								<jdoc:include type="modules" name="user1" style="xhtml" />
							</div>
						</div>
						<div class="c50r">
							<div class="subcr">
								<jdoc:include type="modules" name="user2" style="xhtml" />
							</div>
						</div>
					</div>					
					<jdoc:include type="component" />
				</div>
			</div>
			<!-- end: #col1 -->
			<!-- begin: #col2 second float column -->
			<div id="col2">
				<div id="col2_content" class="clearfix">
                    <jdoc:include type="modules" name="user4" style="xhtml" />
					<jdoc:include type="modules" name="left" style="xhtml" />
				</div>
			</div>
			<!-- end: #col2 -->
			<!-- begin: #col3 static column -->
			<div id="col3">
				<div id="col3_content" class="clearfix"> 
					<div id="col3_top">                
						<jdoc:include type="modules" name="top" style="xhtml" />
                    </div>
                	<div id="col3_right">
                    <jdoc:include type="modules" name="right" style="xhtml" />
                    </div>
                    <div style="margin-top:20px"><jdoc:include type="modules" name="syndicate" style="xhtml" /></div>
				</div>
				<div id="ie_clearing">&nbsp;</div>
				<!-- End: IE Column Clearing -->
			</div>
			<!-- end: #col3 -->
		</div>
		<!-- end: #main -->
		<!-- begin: #footer -->
		<div id="footer">
    		<jdoc:include type="modules" name="footer" /><br />
            designed by <a href="http://tobacamp.com">Tobacamp</a> | More <span style="font-weight:700">Free</span> Joomla! Templates &amp; Extensions at <a href="http://tobacamp.com">http://tobacamp.com</a>
		</div>	<!-- end: #footer -->
</div>
<jdoc:include type="modules" name="debug" />
</body>
</html>

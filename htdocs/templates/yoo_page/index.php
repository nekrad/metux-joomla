<?php
/**
 * YOOtheme template
 *
 * @author yootheme.com
 * @copyright Copyright (C) 2007 YOOtheme Ltd & Co. KG. All rights reserved.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

include_once(JPATH_ROOT . "/templates/" . $this->template . '/lib/php/yootools.php');
include_once(JPATH_ROOT . "/templates/" . $this->template . '/lib/php/yoolayout.php');

$template_baseurl = $this->baseurl . '/templates/' . $this->template;

JHTML::_('behavior.mootools');

// add template mootools to JDocumentHTML
if ($this->params->get('loadMootools')) {
	$this->_scripts = array_merge(array($template_baseurl . '/lib/js/mootools.js.php' => 'text/javascript'), $this->_scripts);
	unset($this->_scripts[$this->baseurl . '/media/system/js/mootools.js']);
}

// add template javascript to JDocumentHTML
if ($this->params->get('loadJavascript')) {
	$this->addScriptDeclaration($yootools->getJavaScript());
	$this->addCustomTag('<script type="text/javascript" src="' . $template_baseurl . '/lib/js/template.js.php"></script>');
}

// add template css to JDocumentHTML
$this->addStyleSheet($template_baseurl . '/css/template.css.php?color=' . $yootools->getCurrentColor()
															. '&amp;styleswitcherFont=' . $this->params->get('styleswitcherFont')
															. '&amp;styleswitcherWidth=' . $this->params->get('styleswitcherWidth')
															. '&amp;widthThinPx=' . $this->params->get('widthThinPx')
															. '&amp;widthWidePx=' . $this->params->get('widthWidePx')
															. '&amp;widthFluidPx=' . $this->params->get('widthFluidPx'));

$this->addStyleSheet($template_baseurl . '/lib/js/lightbox/css/shadowbox.css');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="apple-touch-icon" href="<?php echo $template_baseurl ?>/apple_touch_icon.png" />
</head>

<body id="page" class="<?php echo $yootools->getCurrentStyle(); ?> <?php echo $this->params->get('leftcolumn'); ?> <?php echo $this->params->get('rightcolumn'); ?> <?php echo $itemcolor; ?>">

	<?php if($this->countModules('absolute')) { ?>
	<div id="absolute">
		<jdoc:include type="modules" name="absolute" />
	</div>
	<?php } ?>

	<div id="page-body">
		<div class="wrapper floatholder">
			<div class="wrapper-tl">
				<div class="wrapper-tr">

					<div id="header">
						<div class="header-t">
							<div class="header-b">
								<div class="header-bl">
									<div class="header-br">
	
										<div id="toolbar">
											<div class="floatbox ie_fix_floats">
											
												<?php if($this->params->get('date')) { ?>
												<div id="date">
													<?php echo JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) ?>
												</div>
												<?php } ?>
											
												<?php if($this->countModules('topmenu')) { ?>
												<div id="topmenu">
													<jdoc:include type="modules" name="topmenu" />
												</div>
												<?php } ?>
												
												<?php if($this->params->get('styleswitcherFont') || $this->params->get('styleswitcherWidth')) { ?>
												<div id="styleswitcher">
													<?php if($this->params->get('styleswitcherWidth')) { ?>
													<a id="switchwidthfluid" href="javascript:void(0)" title="Fluid width"></a>
													<a id="switchwidthwide" href="javascript:void(0)" title="Wide width"></a>
													<a id="switchwidththin" href="javascript:void(0)" title="Thin width"></a>
													<?php } ?>
													<?php if($this->params->get('styleswitcherFont')) { ?>
													<a id="switchfontlarge" href="javascript:void(0)" title="Increase font size"></a>
													<a id="switchfontmedium" href="javascript:void(0)" title="Default font size"></a>
													<a id="switchfontsmall" href="javascript:void(0)" title="Decrease font size"></a>
													<?php } ?>
												</div>
												<?php } ?>
												
											</div>
										</div>
				
										<div id="headerbar">
											<div class="floatbox ie_fix_floats">
				
												<?php if($this->countModules('header')) { ?>
												<div id="headermodule">
													<jdoc:include type="modules" name="header" style="rounded" />
												</div>
												<?php } ?>
				
											</div>
										</div>
										
										<?php if($this->countModules('logo')) { ?>		
										<div id="logo">
											<jdoc:include type="modules" name="logo" />
										</div>
										<?php } ?>
	
										<?php if($this->countModules('menu')) { ?>		
										<div id="menu">
											<jdoc:include type="modules" name="menu" />
										</div>
										<?php } ?>
	
										<?php if($this->countModules('search')) { ?>
										<div id="search">
											<jdoc:include type="modules" name="search" />
										</div>
										<?php } ?>
	
										<?php if ($this->countModules('banner')) { ?>
										<div id="banner">
											<jdoc:include type="modules" name="banner" />
										</div>
										<?php } ?>
	
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- header end -->

					<?php if ($this->countModules('top1 + top2 + top3 + top4')) { ?>
					<div id="top">
						<div class="floatbox ie_fix_floats">
							
							<?php if($this->countModules('top1')) { ?>
							<div class="topbox <?php echo $this->params->get('topboxwidth'); ?> <?php echo $this->params->get('topbox12seperator'); ?> float-left">
								<jdoc:include type="modules" name="top1" style="xhtml" />
							</div>
							<?php } ?>
														
							<?php if($this->countModules('top2')) { ?>
							<div class="topbox <?php echo $this->params->get('topboxwidth'); ?> <?php echo $this->params->get('topbox23seperator'); ?> float-left">
								<jdoc:include type="modules" name="top2" style="xhtml" />
							</div>
							<?php } ?>
															
							<?php if($this->countModules('top3')) { ?>
							<div class="topbox <?php echo $this->params->get('topboxwidth'); ?> <?php echo $this->params->get('topbox34seperator'); ?> float-left">
								<jdoc:include type="modules" name="top3" style="xhtml" />
							</div>
							<?php } ?>
							
							<?php if($this->countModules('top4')) { ?>
							<div class="topbox <?php echo $this->params->get('topboxwidth'); ?> float-left">
								<jdoc:include type="modules" name="top4" style="xhtml" />
							</div>
							<?php } ?>
												
						</div>
					</div>
					<!-- top end -->
					<?php } ?>

					<div id="middle">
						<div class="background">
		
							<?php if($this->countModules('left')) { ?>
							<div id="left">
								<div id="left_container" class="clearfix">

									<jdoc:include type="modules" name="left" style="rounded" />

								</div>
							</div>
							<!-- left end -->
							<?php } ?>
			
							<div id="main">
								<div id="main_container" class="clearfix">

									<?php if ($this->countModules('user1 + user2')) { ?>
									<div id="maintop" class="floatbox">
							
										<?php if($this->countModules('user1')) { ?>
										<div class="maintopbox <?php echo $this->params->get('maintopboxwidth'); ?> <?php echo $this->params->get('maintopbox12seperator'); ?> float-left">
											<jdoc:include type="modules" name="user1" style="rounded" />
										</div>
										<?php } ?>
		
										<?php if($this->countModules('user2')) { ?>
										<div class="maintopbox <?php echo $this->params->get('maintopboxwidth'); ?> float-left">
											<jdoc:include type="modules" name="user2" style="rounded" />
										</div>
										<?php } ?>
											
									</div>
									<!-- maintop end -->
									<?php } ?>

									<div id="mainmiddle" class="floatbox">

										<?php if($this->countModules('right') && !class_exists('JEditor')) { ?>
										<div id="right">
											<div id="right_container" class="clearfix">
												<jdoc:include type="modules" name="right" style="rounded" />
											</div>
										</div>
										<!-- right end -->
										<?php } ?>
						
										<div id="content">
											<div id="content_container" class="clearfix">

												<?php if ($this->countModules('advert1 + advert2')) { ?>
												<div id="contenttop" class="floatbox">

													<?php if($this->countModules('advert1')) { ?>
													<div class="contenttopbox left <?php echo $this->params->get('contenttopboxwidth'); ?> <?php echo $this->params->get('contenttopbox12seperator'); ?> float-left">
														<jdoc:include type="modules" name="advert1" style="rounded" />
													</div>
													<?php } ?>

													<?php if($this->countModules('advert2')) { ?>
													<div class="contenttopbox right <?php echo $this->params->get('contenttopboxwidth'); ?> float-left">
														<jdoc:include type="modules" name="advert2" style="rounded" />
													</div>
													<?php } ?>
		
												</div>
												<!-- contenttop end -->
												<?php } ?>
		
												<?php if ($this->countModules('breadcrumb')) { ?>
												<div id="breadcrumb">
													<jdoc:include type="modules" name="breadcrumb" />
												</div>
												<?php } ?>
						
												<div class="floatbox">
													<jdoc:include type="message" />
													<jdoc:include type="component" />
												</div>
		
												<?php if ($this->countModules('advert3 + advert4')) { ?>
												<div id="contentbottom" class="floatbox">
														
													<?php if($this->countModules('advert3')) { ?>
													<div class="contentbottombox left <?php echo $this->params->get('contentbottomboxwidth'); ?> <?php echo $this->params->get('contentbottombox12seperator'); ?> float-left">
														<jdoc:include type="modules" name="advert3" style="rounded" />
													</div>
													<?php } ?>
									
													<?php if($this->countModules('advert4')) { ?>
													<div class="contentbottombox right <?php echo $this->params->get('contentbottomboxwidth'); ?> float-left">
														<jdoc:include type="modules" name="advert4" style="rounded" />
													</div>
													<?php } ?>
									
												</div>
												<!-- mainbottom end -->
												<?php } ?>

											</div>
										</div>
										<!-- content end -->
		
									</div>
									<!-- mainmiddle end -->

									<?php if ($this->countModules('user3 + user4')) { ?>
									<div id="mainbottom" class="floatbox">
					
										<?php if($this->countModules('user3')) { ?>
										<div class="mainbottombox <?php echo $this->params->get('mainbottomboxwidth'); ?> <?php echo $this->params->get('mainbottombox12seperator'); ?> float-left">
											<jdoc:include type="modules" name="user3" style="rounded" />
										</div>
										<?php } ?>
					
										<?php if($this->countModules('user4')) { ?>
										<div class="mainbottombox <?php echo $this->params->get('mainbottomboxwidth'); ?> float-left">
											<jdoc:include type="modules" name="user4" style="rounded" />
										</div>
										<?php } ?>
										
									</div>
									<!-- mainbottom end -->
									<?php } ?>

								</div>
							</div>
							<!-- main end -->
				
						</div>
					</div>
					<!-- middle end -->
					
				</div>	
			</div>	
		</div>		
	</div>
	<!-- page-body end -->
	
	<div id="page-footer">
		<div class="wrapper floatholder">

			<?php if ($this->countModules('bottom1 + bottom2 + bottom3 + bottom4')) { ?>
			<div id="bottom">
				<div class="floatbox ie_fix_floats">
					
					<?php if($this->countModules('bottom1')) { ?>
					<div class="bottombox <?php echo $this->params->get('bottomboxwidth'); ?> <?php echo $this->params->get('bottombox12seperator'); ?> float-left">
						<jdoc:include type="modules" name="bottom1" style="rounded" />
					</div>
					<?php } ?>
												
					<?php if($this->countModules('bottom2')) { ?>
					<div class="bottombox <?php echo $this->params->get('bottomboxwidth'); ?> <?php echo $this->params->get('bottombox23seperator'); ?> float-left">
						<jdoc:include type="modules" name="bottom2" style="rounded" />
					</div>
					<?php } ?>
													
					<?php if($this->countModules('bottom3')) { ?>
					<div class="bottombox <?php echo $this->params->get('bottomboxwidth'); ?> <?php echo $this->params->get('bottombox34seperator'); ?> float-left">
						<jdoc:include type="modules" name="bottom3" style="rounded" />
					</div>
					<?php } ?>
					
					<?php if($this->countModules('bottom4')) { ?>
					<div class="bottombox <?php echo $this->params->get('bottomboxwidth'); ?> float-left">
						<jdoc:include type="modules" name="bottom4" style="rounded" />
					</div>
					<?php } ?>
										
				</div>
			</div>
			<!-- bottom end -->
			<?php } ?>

			<?php if($this->countModules('footer')) { ?>
			<div id="footer">
				<a class="anchor" href="#page">&nbsp;</a>
				<jdoc:include type="modules" name="footer" />
			</div>
			<?php } ?>
			
			<jdoc:include type="modules" name="debug" />
			
		</div>
	</div>
	<!-- page-footer end -->
	
</body>
</html>
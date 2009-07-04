<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JPlugin::loadLanguage( 'tpl_SG1' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css" type="text/css" />

</head>
<body id="page_bg">
	<div class="center">		
		<div id="wrapper">
			<div id="area">	
				<div id="header">
					<div id="logo">
						<a href="index.php"><?php echo $mainframe->getCfg('sitename') ;?></a>
					</div>
				</div>
				
				<div id="content">
					<div id="leftcolumn" style="float: left;">	
						<jdoc:include type="modules" name="left" style="rounded" />
						<?php $sg = 'banner'; include "templates.php"; ?>
					</div>
					<div id="pathway">
						<jdoc:include type="module" name="breadcrumbs" />
					</div>
					<div id="maincolumn">
									
					<div class="nopad">
						<?php if($this->params->get('showComponent')) : ?>
							<jdoc:include type="component" />
						<?php endif; ?>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="clr"></div>
	</div>				
		
	<jdoc:include type="modules" name="debug" />
	</div>	
	<div id="footer">
		<p>
			Valid <a href="http://validator.w3.org/check/referer">XHTML</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>.
		</p>
		<div id="sgf">
			<?php $sg = ''; include "templates.php"; ?>
		</div>
	</div>	
</body>
</html>

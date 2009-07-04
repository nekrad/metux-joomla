<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?'.'>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
xml:lang="<?php echo $this->language; ?>"
lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7.]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<style type="text/css">
	<!--
	<?php if ($this->countModules( 'left' )&& $this->countModules( 'right' )) { ?>
	#content {
		padding-left:0px;
		width: 500px;
	}

	#container {
		background-image:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/body.png);
	}

	<?php } else if ($this->countModules( 'left' )) { ?>
	#content {
		padding-left:0px;
		width: 766px;
	}

	#container {
		background-image:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/body-left.png);
	}
	<?php } else if ($this->countModules( 'right' )) { ?>
	#content {
		padding-left:0px;
		width: 666px;
	}
	
	#container {
		background-image:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/body-right.png);
	}
	<?php } ?>
	-->
</style>
</head>
<body>
<div id="wrapper">
	<div id="header">
    <?php if ($this->countModules( 'top-banner-468-60' )) : ?>          
      <div id="top-ad"> <jdoc:include type="modules" name="top-banner-468-60" style="xhtml" /></div>
      <?php endif; ?>
	</div>
<div id="Menu">
        <div id="search">
        	<jdoc:include type="modules" name="search" style="xhtml" />
        </div >
        <div id="nav">
       		<jdoc:include type="modules" name="top-nav" style="none" />
        </div>
    </div>
    <div id="container">
        <div id="innerContainer">
			<?php if ($this->countModules( 'feature' )) : ?>
            <div id="FlashHeadpiece">
                <jdoc:include type="modules" name="feature" style="xhtml" />
            </div>
            <?php endif; ?>
            <div id="left">
                <jdoc:include type="modules" name="left" style="xhtml" />
            </div>
            <div id="right">
<?php
if ($templateOption == 1 && $this->countModules( 'right' )) {
?>                
<div id="colorpicker"><a id="lightgrey" class="colorpicker" href="javascript:setActiveStyleSheet('lightgrey')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/lightgrey/vertnavbutton-hover.png" alt="gray" /></a><a id="darkgrey" class="colorpicker" href="javascript:setActiveStyleSheet('darkgrey')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/darkgrey/vertnavbutton-hover.png" alt="gray" /></a><a id="purple" class="colorpicker" href="javascript:setActiveStyleSheet('purple')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/purple/vertnavbutton-hover.png" alt="purple" /></a><a id="default" class="colorpicker" href="javascript:setActiveStyleSheet('blue')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/blue/vertnavbutton-hover.png" alt="blue" /></a><a id="green" class="colorpicker" href="javascript:setActiveStyleSheet('green')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/green/vertnavbutton-hover.png" alt="green" /></a><a id="yellow" class="colorpicker" href="javascript:setActiveStyleSheet('yellow')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/yellow/vertnavbutton-hover.png" alt="yellow" /></a><a id="orange" class="colorpicker" href="javascript:setActiveStyleSheet('orange')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/orange/vertnavbutton-hover.png" alt="orange" /></a><a id="red" class="colorpicker" href="javascript:setActiveStyleSheet('red')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/red/vertnavbutton-hover.png" alt="red" /></a><a id="pink" class="colorpicker" href="javascript:setActiveStyleSheet('pink')"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/pink/vertnavbutton-hover.png" alt="pink" />
    </a></div>
    </a></div>
<?php
}
?>
              <jdoc:include type="modules" name="right" style="xhtml" />
            </div>
<div id="content">
                <jdoc:include type="component" />
            </div>
            <div class="clear">&nbsp;</div>
        </div>
    </div>				
	<div id="footer">
    	<jdoc:include type="modules" name="footer" style="xhtml" />
    </div>
<?php
if ($showLogo == 1) {
?>
	<div id="bear">
    	<a href="http://joomlabear.com">
        	<span class="joomla-template">DESIGNER JOOMLA TEMPLATES</span>
            <img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/joomla-template-by-joomlabear.png" alt="Joomla Templates By JoomlaBear" width="26" height="29" class="joomla-template-design" />
        </a>
	</div>
<?php
}
?>
</div>
</body>
</html>
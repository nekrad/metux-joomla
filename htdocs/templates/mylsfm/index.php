<?php

$tmpldir = 'templates/'.$this->template;
$cssdir  = $tmpldir.'/css';
$imgdir  = $tmpldir.'/images';

?>
<html>
    <head>
<jdoc:include type="head" />
        <link rel="stylesheet" href="templates/system/css/general.css" type="text/css" />
        <link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/template.css"
            type="text/css" />
            
<?php if($this->direction == 'rtl') : ?>
            <script src="diveinfuegen.js" type="text/javascript"> 
            <link href="<?php echo $cssdir ?>/template.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

<style type="text/css">
#nav li ul ul {
	margin: -1em 0 0 10em;
}

#nav li:hover ul, #nav li.sfhover ul {
	left: auto;
}
#nav, #nav ul {
	padding: 0;
	margin: 0;
	list-style: none;
}

#nav a {
	display: block;
    width:10em;
}

#nav li {
	float: left;
	width: 5em;
    padding: 0.3em;
}

#nav li ul {
	position: absolute;
	width: 160px;
	left: -999em;
    border : 1px solid white;
    display:block !important;
}

#nav li:hover ul {
	left: auto;
}
#nav, #nav ul {
	padding: 0;
	margin: 0;
	list-style: center; 
	line-height: 0;
}
#nav li:hover ul ul, #nav li.sfhover ul ul {
	left: -999em;
}
#nav li:hover ul, #nav li li:hover ul, #nav li.sfhover ul, #nav li li.sfhover ul {
	left: auto;
    background-color: #1A1818;
    border : 1px solid white;
	opacity: 0.9;
}


#modianzeige {
position:absolute;
left:803px;
top: 105px;
}
#submenu li, #submenu a {
    width:125px !important;
}
/*#submenu a {
    width:125px !important;
}*/

DIV.javamenu	.menu	ul	li
{
    width:	200px	!important;
}

#mylsfm_main
{
    padding:	5px;
}
</style>

</head>
<body>

<div id="mylsfm_main">

<table background="/templates/mylsfm/images/bannerground.png" width="850" cellpadding="0" cellspacing="0" height="120"><tr><td valign="top"><script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://www.livestylefm.de/werbung/www/delivery/ajs.php':'http://www.livestylefm.de/werbung/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?campaignid=1");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://www.livestylefm.de/werbung/www/delivery/ck.php?n=a46014ad&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://www.livestylefm.de/werbung/www/delivery/avw.php?campaignid=1&amp;n=a46014ad' border='0' alt='' /></a></noscript></td></tr></table>

<table width="890" cellpadding="0"  cellspacing="0">
    <tr background="/templates/mylsfm/images/naviground.png" height="30">
	<td>
		<ul id="nav" style="margin-left: 190">
		    <div class="javamenu">
<jdoc:include type="modules" name="top_menu"/>
		    </div>

		    <script language="Javascript">
sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
		    </script>
		</ul>
	</td>
    </tr>
    <tr style="width: 890" background="<?php echo $imgdir ?>/headerground.png" height="180">
	<td> &nbsp; </td>
    </tr>
</table>

<!-- <table background="<?php echo $imgdir ?>/spaceground.png" width="890" cellpadding="0"  cellspacing="0" height="40"><tr><td></td></tr></table> -->

<table border="0" cellpadding="0" cellspacing="12" width="890" style="background-image:url(<?php echo $imgdir ?>/seitenground.png);background-repeat: repeat-y;background-position: center">
    <tr>
	<td valign="top" width="620">
	    <jdoc:include type="component" />
	</td>
	<td valign="top">
	    <jdoc:include type="modules" name="right" style="rounded"/>
	</td>
    </tr>
</table>

    </div>

    <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
try {
var pageTracker = _gat._getTracker("UA-1443658-31");
pageTracker._trackPageview();
} catch(err) {}
    </script>
</body>
</html>

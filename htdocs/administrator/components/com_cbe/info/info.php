<?php
// wird von cpanel.php includiert
defined('_JEXEC') or die('Direct access is not allowed.');
?>
<script language="JavaScript">
var div_cbe_length = 4;
function div_show(ind){
	if ((ind + 1) < div_cbe_length) {
		tDiv = 'div_cbe_info[' + ind + ']';
		ind++;
		vDiv = 'div_cbe_info[' + ind + ']';
	} else {
		tDiv = 'div_cbe_info[' + ind + ']';
		ind=0;
		vDiv = 'div_cbe_info[' + ind + ']';
	}
	if($(tDiv).fx){$(tDiv).fx.stop();}
	if($(vDiv).fx){$(vDiv).fx.stop();}

	$(tDiv).fx = $(tDiv).effect('opacity', {duration: 2000}).start(0);
	$(vDiv).fx = $(vDiv).effect('opacity', {duration: 2000}).start(1);	

	div_show.delay(5000, null, [(ind)]);

}
window.addEvent('domready', function(){div_show.delay(2500,null, [(0)]);});
</script>
<div id='cbe_info_container' style="height:130px;padding:5px;border: solid 1px #aaa;">
	<div id='div_cbe_info[0]' style="position:absolute; opacity: 1;">
	<strong>Programmierung des neuen CBE: </strong><br />
	<a href="http://www.it-bruecke.de" target="_new"><img src="<?php echo JURI::root(); ?>administrator/components/com_cbe/info/it-bruecke.png" border=0></a>
	</div>
	<div id='div_cbe_info[1]' style="position:absolute; opacity: 0;">
	<strong>Grafikdesign / Lizenzverwaltung Grafiken: </strong><br />
	<a href="http://www.walz-media.de" target="_new"><img src="<?php echo JURI::root(); ?>administrator/components/com_cbe/info/walz-media-logo.jpg" border=0></a>
	</div>
	<div id='div_cbe_info[2]' style="position:absolute; opacity: 0;">
	<strong>Programmierung von Tabs: </strong><br />
	Danke an:<br />
	Jakob Glück, Homepage: <a href="http://glueck-bwalde.de/blog" target="_new">http://glueck-bwalde.de/blog</a>
	</div>
	<div id='div_cbe_info[3]' style="position:absolute; opacity: 0;">
	<strong>Powertester und Bereitstellungen von Testservern:</strong><br />
	Danke an cybork (Mirco) für alles !<br />
	Homepage: <a href="http://www.friends-com.com" target="_new">http://www.friends-com.com</a>
	</div>
</div>

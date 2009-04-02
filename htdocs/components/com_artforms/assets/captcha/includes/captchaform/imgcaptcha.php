<?php
/********************************************************************************
* output captchaform image 
********************************************************************************/

require_once( '../../../../../../administrator/components/com_artforms/config.artforms.php' );

session_start();

/* load php5 or php4 class files for demo */
if (version_compare(phpversion(), "5.0.0", ">=")) { 
    require_once( 'captchaform5.php' );
  } else {
    require_once( 'captchaform4.php' );
} 

	/* init captchaform class */
$captcha = new captchaform();

	/* options - see class for more info */
$captcha->session = "afcaptchaform";
$captcha->codelength = $afcfg_captcha_length;
$captcha->fontdir = '../../fonts';
// $captcha->fonts =array("fontname1", "fontname2");
// $captcha->type = "gif";
// $captcha->transparant = "FFFFFF";
$captcha->backgrounddir = '../../bg';
// $captcha->backgrounds =array("bg1.gif", "bg2.jpg");
// $captcha->fontsize = 20;
$captcha->colors = array("FF0000", "990099", "0000FF");
// $captcha->shades = array("FFFF00");
// $captcha->shadesize = 2;
// $captcha->rotate = 30;
// $captcha->dnsbl = array('zen.spamhaus.org','bl.spamcop.net','list.dsbl.org','tor.ahbl.org','opm.tornevall.org');

	/* output captcha image */
$captcha->image();
?>

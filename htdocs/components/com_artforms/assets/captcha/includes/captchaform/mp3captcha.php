<?php
/********************************************************************************
* output captcha mp3
********************************************************************************/

session_start();

/* load php5 or php4 class files for demo */
if (version_compare(phpversion(), "5.0.0", ">=")) { 
	require_once( 'mp3captchaform5.php' );
} else { 
	require_once( 'mp3captchaform4.php' );
} 

$lang = $_GET['l'];

/* init mp3captcha class with captcha value from session*/
$mp3 = new mp3captcha($_SESSION['afcaptchaform']);
	/* use language mapping */
// $mp3->mapping = true;

/* language switch for use in demo */
$mp3->language = $lang;

	/* output captcha mp3 */
$mp3->mp3stitch();
?>

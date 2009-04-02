<?php
// swfmovie.php - swf output and config

require_once( '../../../../../../administrator/components/com_artforms/config.artforms.php' );
session_start();

if (version_compare(phpversion(), "5.0.0", ">=")) { 
	include_once( 'swfcaptcha5.php' );
} else { 
	include_once( 'swfcaptcha4.php' );
} 

$swfc = new swfcaptcha();
$swfc->captcha_length = $afcfg_captcha_length;
$swfc->soundlang = $mosConfig_lang;
$swfc->fontdir = '../../fonts';
$swfc->imagesdir = '../../bg';
$swfc->sounddir = '../../audio';

if (($afcfg_captcha_mode=='audio') || ($afcfg_captcha_mode=='both')) {
   $swfc->talking = true;
} else {
   $swfc->talking = false;
}

$swfc->swfmovie();

?>

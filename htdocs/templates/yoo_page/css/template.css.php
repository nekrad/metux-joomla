<?php 

if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) @ob_start('ob_gzhandler');
header('Content-type: text/css; charset: UTF-8');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

define('DS', DIRECTORY_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__) . DS);

/* layout styling */
include(PATH_ROOT . 'layout.css');

if (isset($_GET['widthThinPx'])) echo 'body.width-thin div.wrapper { width: ' . $_GET['widthThinPx'] . 'px; }';
if (isset($_GET['widthWidePx'])) echo 'body.width-wide div.wrapper { width: ' . $_GET['widthWidePx'] . 'px; }';
if (isset($_GET['widthFluidPx'])) echo 'body.width-fluid div.wrapper { width: ' . intval($_GET['widthFluidPx'] * 100) . '%; }';

if (isset($_GET['styleswitcherFont']) && isset($_GET['styleswitcherWidth'])) {
	if ($_GET['styleswitcherFont'] && $_GET['styleswitcherWidth']) {
		echo 'div#styleswitcher { width: 90px; }';
	} else {
		echo 'div#styleswitcher { width: 45px; }';
	}
}

/* general tag styling */
include(PATH_ROOT . 'general.css');

/* menu styling */
include(PATH_ROOT . 'menus.css');

/* module styling */
include(PATH_ROOT . 'modules.css');

/* joomla core styling */
include(PATH_ROOT . 'joomla.css');

/* third party extensions styling */
include(PATH_ROOT . 'extensions.css');

/* color styling */
if (isset($_GET['color']) && $_GET['color'] != '' && $_GET['color'] != 'default') {
	if (is_readable(PATH_ROOT . $_GET['color'] . DS . $_GET['color'] . '-layout.css')) {
		include(PATH_ROOT . $_GET['color'] . DS . $_GET['color'] . '-layout.css');	
	}
}

/* ie browser */
if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
	$is_ie7 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 7') !== false;
	$is_ie6 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6') !== false;
	if ($is_ie7 || $is_ie6) include(PATH_ROOT . 'iehacks.css');
	if ($is_ie7) include(PATH_ROOT . 'ie7hacks.css');
	else if ($is_ie6) include(PATH_ROOT . 'ie6hacks.css');
}

/* custom styling */
// include(PATH_ROOT . 'custom.css');

?>
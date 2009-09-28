<?php 

if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) @ob_start('ob_gzhandler');
header('Content-type: application/x-javascript');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

define('DS', DIRECTORY_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__) . DS);

/* reflection */
include(PATH_ROOT . 'reflection/reflection_packed.js');

/* lightbox */
include(PATH_ROOT . 'lightbox/shadowbox_packed.js');

/* yootools */
include(PATH_ROOT . 'addons/base.js');
include(PATH_ROOT . 'addons/accordionmenu.js');
include(PATH_ROOT . 'addons/dropdownmenu.js');
include(PATH_ROOT . 'yoo_tools.js');

/* ie browser */
if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
	$is_ie7 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 7') !== false;	
	$is_ie6 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 6') !== false;
	if ($is_ie6 && !$is_ie7) include(PATH_ROOT . 'addons/ie6fix.js');
	if ($is_ie6 && !$is_ie7) include(PATH_ROOT . 'yoo_ie6fix.js');
}

?>
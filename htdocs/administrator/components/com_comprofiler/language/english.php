<?php
/*************************************************************
* Joomla Community Builder Backwards compatibility file: RC2 only! will be removed!
* @version $Id: english.php 41 2006-01-11 23:36:58Z beat $
* @package Community Builder
* @subpackage comprofiler.class.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe, $mosConfig_lang;
$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php')) {
	include_once($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php');
} else include_once($UElanguagePath.'/default_language/default_language.php');

?>

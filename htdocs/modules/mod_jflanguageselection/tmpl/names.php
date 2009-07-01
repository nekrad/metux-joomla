<?php // no direct access
defined('_JEXEC') or die('Restricted access');
require(dirname(__FILE__).DIRECTORY_SEPARATOR."namesplusimages.php");

if( $inc_jf_css && JFile::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jflanguageselection'.DS.'mod_jflanguageselection.css') ) {
	$document =& JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/modules/mod_jflanguageselection/mod_jflanguageselection.css');
}

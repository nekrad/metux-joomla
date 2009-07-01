<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$outString = '<div id="jflanguageselection">';
$outString .= '<ul class="jflanguageselection">';
foreach( $langActive as $language )
{
	$langActive = '';
	if( $language->code == $curLanguage->getTag() ) {
		if( !$show_active ) {
			continue;		// Not showing the active language
		} else {
			$langActive = ' id="active_language"';
		}
	}

	$href = JFModuleHTML::_createHRef ($language, $params);
	$outString .= '<li' .$langActive. '>';
	if($type == 'namesplusimages') {
		if( isset($language->image) && $language->image!="" ) {
			$langImg = '/images/' .$language->image;
		} else {
			$langImg = '/components/com_joomfish/images/flags/' .$language->getLanguageCode() .".gif";
		}
		$outString .='<img src="' .JURI::base(true). $langImg. '" alt="' .$language->name. '" title="' .$language->name. '" border="0" class="langImg"/>';
	}
	$outString .= '<a href="' .$href. '" ><span lang="' .$language->getLanguageCode(). '" xml:lang="' .$language->getLanguageCode(). '">' .$language->name. '</span></a></li>';
}
$outString .= '</ul></div>';

echo $outString;

if( $inc_jf_css && JFile::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jflanguageselection'.DS.'tmpl'.DS.'mod_jflanguageselection.css') ) {
	$document =& JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/modules/mod_jflanguageselection/tmpl/mod_jflanguageselection.css');
}


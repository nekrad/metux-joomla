<?php // no direct access
defined('_JEXEC') or die('Restricted access');
if ( count($langActive)>0 ) {
	$langOptions=array();
	$noscriptString='';
	foreach( $langActive as $language )
	{
		$href = JFModuleHTML::_createHRef ($language, $params);
		if( $language->code == $curLanguage->getTag() && !$show_active ) {
			continue;		// Not showing the active language
		}
		if ($language->code == $curLanguage->getTag() ) {
			$activehref=$href;
		}

		$langOption=JFModuleHTML::makeOption( $href, $language->name );
		$langOptions[] = $langOption;
		$href = JFModuleHTML::_createHRef ($language, $params);
		$noscriptString .= '<a href="' .$href. '"><span lang="' .$language->getLanguageCode(). '" xml:lang="' .$language->getLanguageCode(). '">' .$language->name. '</span></a>&nbsp;';
	}

	if( count( $langOptions ) > 1 ) {
		$langlist = JFModuleHTML::selectList( $langOptions, 'lang', ' class="jflanguageselection" size="1" onchange="document.location.replace(this.value);"', 'value', 'text', $activehref);
		$outString = '<div id="jflanguageselection">';
		$outString .= '<label for="jflanguageselection" class="jflanguageselection">' .JText::_("JFMSELECT"). '</label>';
		$outString .= $langlist;
		$outString .= '</div>';

		if( $noscriptString != '' ) {
			$outString .= '<noscript>' .$noscriptString. '</noscript>';
		}
	} elseif (count( $langOptions ) == 1) {
		$outString = '<div id="jflanguageselection"><ul class="jflanguageselection"><li id="active_language"><a href="' .$langOptions[0]->value. '"><span lang="' .$langOptions[0]->value. '" xml:lang="' .$langOptions[0]->value. '">' .$langOptions[0]->text. '</a></li></ul></div>';
	}

	echo $outString;
}

if( $inc_jf_css && JFile::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jflanguageselection'.DS.'tmpl'.DS.'mod_jflanguageselection.css') ) {
	$document =& JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/modules/mod_jflanguageselection/tmpl/mod_jflanguageselection.css');
}

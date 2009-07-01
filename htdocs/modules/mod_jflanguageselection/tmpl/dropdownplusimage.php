<?php // no direct access
defined('_JEXEC') or die('Restricted access');
if ( count($langActive)>0 ) {
	//$outString = '<div class="flaggedlist">'."\n";
	//$outString .= '<div class="jflabel">'."\n".'<label for="jflanguageselection" class="jflanguageselection">' .JText::_("JText::_("JFMSELECT")"). '</label>'."\n".'</div>'."\n".'<div class="jfselect">'."\n";
	$langOptions=array();
	$noscriptString='';
	$activeLangImg  = null;
	foreach( $langActive as $language )
	{
		$languageCode = $language->getLanguageCode();
		if( $language->code == $curLanguage->getTag() && !$show_active ) {
			continue;		// Not showing the active language
		}
		$href = JFModuleHTML::_createHRef ($language, $params);

		if( isset($language->image) && $language->image!="" ) {
			$langImg = '/images/' .$language->image;
		} else {
			$langImg = '/components/com_joomfish/images/flags/' .$languageCode .".gif";
		}
		if ($language->code == $curLanguage->getTag() ){
			$activehref=$href;
			$activeLangImg = array( 'img' => $langImg, 'code' => $languageCode, 'name' => $language->name );
		}
		$langOption=JFModuleHTML::makeOption($href , $language->name, " style='padding-left:22px;background-image: url(\"".JURI::base(true) . $langImg."\");background-repeat: no-repeat;background-position:center left;'" );
		$langOption->iso = $language->iso;
		$langOptions[] = $langOption;

		$noscriptString .= '<a href="' .$href. '"><span lang="' .$languageCode. '" xml:lang="' .$languageCode. '">' .$language->name. '</span></a>&nbsp;';
	}

	if( count( $langOptions ) > 1 ) {

		$outString = '<div id="jflanguageselection">';
		$outString .= '<label for="jflanguageselection" class="jflanguageselection">' .JText::_('JFMSELECT'). '</label>';
		if( $activeLangImg != null ) {
			$outString .='<img src="' .JURI::base(true). $activeLangImg['img']. '" alt="' .$activeLangImg['name']. '" title="' .$activeLangImg['name']. '" border="0" class="langImg"/>';
		}
		$langlist = JFModuleHTML::selectList( $langOptions, 'lang', ' class="jflanguageselection" onchange="document.location.replace(this.value);"', 'value', 'text', $activehref);
		$outString .= ''.$langlist.'';
		$outString .= '</div>'."\n";

		if( $noscriptString != '' ) {
			$outString .= '<noscript>' .$noscriptString. '</noscript>';
		}
	} elseif (count( $langOptions ) == 1) {
		$outString = '<div id="jflanguageselection">';
		if( $activeLangImg != null ) {
			$outString .='<img src="' .JURI::base(true). $activeLangImg['img']. '" alt="' .$activeLangImg['name']. '" title="' .$activeLangImg['name']. '" border="0" class="langImg"/>';
		}
		$outString .= '<ul class="jflanguageselection"><li id="active_language"><a href="' .$langOptions[0]->value. '"><span lang="' .$langOptions[0]->iso. '" xml:lang="' .$langOptions[0]->iso. '">' .$langOptions[0]->text. '</span></a></li></ul></div>';
	}
	
	echo $outString;
}

if( $inc_jf_css && JFile::exists(JPATH_ROOT.DS.'modules'.DS.'mod_jflanguageselection'.DS.'tmpl'.DS.'mod_jflanguageselection.css') ) {
	$document =& JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/modules/mod_jflanguageselection/tmpl/mod_jflanguageselection.css');
}

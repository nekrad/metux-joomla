<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
JPlugin::loadLanguage( 'plg_joomfish_m' );

class plgJoomfishMissing_Translation extends JPlugin
{
	var $_dbvalid = 0;
	
	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * Works out what to show if the translation is missing
	 *
	 * @param object $row_to_translate
	 * @param string $language
	 * @param string $reference_table
	 */
	function onMissingTranslation(&$row_to_translate, $language, $reference_table, $tableArray){
		global   $_JOOMFISH_MANAGER;
		$conf	=& JFactory::getConfig();
		$default_lang	= $conf->getValue('config.defaultlang');

		$db =& JFactory::getDBO();

		$noTranslationBehaviour = $_JOOMFISH_MANAGER->getCfg( 'noTranslation' );
		if( $noTranslationBehaviour  >= 1 && $language != $default_lang ) {
			// don't even think about translations if none exist for the table
			if ($db->translatedContentAvailable($reference_table)) {
				// only offer alternatives for table == content
				if( $reference_table == $_JOOMFISH_MANAGER->DEFAULT_CONTENTTYPE ) {
					// get default text from joomfish language (if present)
					$jflang =&  $conf->getValue("joomfish.language");
					$langParams = new JParameter( $jflang->params );
					$defaultText = $langParams->get('defaulttext',$_JOOMFISH_MANAGER->getCfg('defaultText'));

					if ($defaultText=="") {
						$defaultText = '<div class="jfdefaulttext">' .JText::_('There are no translations available.'). '</div>';
					}
					if ($noTranslationBehaviour==3 && isset($row_to_translate->id)){
						$defaultText="{jfalternative}".$row_to_translate->id."|content|$defaultText{/jfalternative}";
					}

					// Note that its critical that the content elements are only loaded here otherwise joomla caching of content is wasted
					// since the contentelement files are loaded unnecessarily even when the content is cached!!

					// cache this burdonsome analysis of field types
					$cache = & JFactory::getCache('com_content');
					$fieldInfo = $cache->call("JoomFish::_contentElementFields",$reference_table, $language);
					//$contentElement = $_JOOMFISH_MANAGER->getContentElement( $reference_table );
					//$contentObject = new ContentObject( $_JOOMFISH_MANAGER->getLanguageID($language), $contentElement );
					//$textFields = $contentObject->getTextFields();
					$textFields = $fieldInfo["textFields"];
					if( $textFields !== null ) {
						$defaultSet = false;
						foreach ($textFields as $field) {
							if( !$defaultSet && $fieldInfo["fieldTypes"][$field]=="htmltext") {
								if ($noTranslationBehaviour==1)	{
									$row_to_translate->$field = $defaultText;
								} else if ($noTranslationBehaviour>=2) {
									$cr="<br/>";
									$row_to_translate->$field = $defaultText .$cr.(isset($row_to_translate->$field)?$row_to_translate->$field:"");
								}
								$defaultSet = true;
							} else {
								if ($noTranslationBehaviour==1)	{
									$row_to_translate->$field = "";
								} else if ($noTranslationBehaviour>=2) {
									//if ($contentObject->getFieldType($field)=="htmltext"){
									if ($fieldInfo["fieldTypes"][$field]=="htmltext"){
										$cr="<br/>";
									} else {
										$cr="\n";
									}
									$row_to_translate->$field = (isset($row_to_translate->$field)?$row_to_translate->$field:"");
								}
							}
						}
					}
				}
			}
		}

	}
	
}


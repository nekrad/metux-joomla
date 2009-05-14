<?php
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );
JLoader::register('JPaneTabs',  JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'pane.php');

?>
<table class="adminform">
<tr>
	<td width="55%" valign="top">
<?php 
	$ccpanel_nr = 0;
	$database = &JFactory::getDBO();
	$get_adms_query = "SELECT * FROM #__cbe_admods WHERE published = 1 ORDER BY ordering";
	$database->setQuery($get_adms_query);
	$admods = $database->loadObjectList();
	if (!$database->query()) {
		echo "<font color='red'>AdMods Query Error: ".$database->getErrorMsg()."</font>\n<br />\n";
	}
	$count = count($admods);
	for ($i=0; $i <= $count; $i++) {
		if ($admods[$i]->position == 'ccpanel') {
			$ccpanel_nr ++;
		}
	}

	$doc = &JFactory::getDocument();
	$doc->addScript( JURI::root(true). '/media/system/js/modal.js' );
	$doc->addStylesheet(JURI::root(true) . "/media/system/css/modal.css");

	//$tabs = new mosTabs(1);
	$tabs = new JPaneTabs(1);

	$tabs->startPane( 'CBE-Core-Mods');   
	$tabs->startPanel( 'Core', 'CBEPanel-' . 'Core' );
		cbe_loadQuickIcon( 'quickicon', 0 ); 
	$tabs->endPanel();
	if ($ccpanel_nr > 0) {
		$tabs->startPanel( 'Custom', 'CBEPanel-' . 'Custom' );
		echo "<div id=\"cpanel\">\n";
		foreach ($admods as $admod) {
			cbe_loadQuickIcon( $admod->module, 0);
		}
		echo "\n</div>\n";
		$tabs->endPanel();
	}
	$tabs->endPane();

	// derelvis: CBE Version aus XML holen
	require_once( JPATH_SITE . '/includes/domit/xml_domit_lite_include.php' );
	$CBE_xml = JPATH_SITE.'/administrator/components/com_cbe/cbe.xml';
	if (file_exists($CBE_xml)) {
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $CBE_xml, false, true )) {
			$CBE_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$CBE_version = $element ? $element->getText() : '';
		}
		$ueConfig['version'] = $CBE_version;
	}

?>
	</td>
	<td width="45%" valign="top">

		<div style="width: 100%;">
			<?php
			echo "<br /><b>CBE-Version :</b>\t\t".$ueConfig['version']."\n<br /><br />\n";

			jimport('joomla.html.pane');
			$pane =& JPane::getInstance('sliders');

			echo $pane->startPane('CBE RSS');

			// hier die panels für rss rein
			$cbefeeds = array("cbe_shop" => "CBE Shop", "cbe_forum" => "CBE Forum", "cbe_news" => "CBE News");
			foreach ($cbefeeds as $key=>$val) {
				echo $pane->startPanel($val, $key);
				//startOffset
				echo "<script language='JavaScript'>
					var loaded_$key = 0;
					$('$key').addEvent('click', function(){
						//mySlider = new Fx.Slide('cbe_info_container');
						//mySlider.hide();

						if (loaded_$key == 0) {
							$('rss_$key').innerHTML = 'Lade $key...';
							new Ajax('index.php?option=com_cbe&task=cbeModul&format=raw&cbe_rss=$key', {method: 'get', update: 'rss_$key'}).request();
							loaded_$key = 1;
						}
					});

					</script>";
				echo "<div id='rss_$key' style='padding:5px;'></div>";
				echo $pane->endPanel();
			}
			echo $pane->endPane();
			echo "<script language='JavaScript'>
				window.addEvent('domready', function() {
					SqueezeBox.initialize({});
					$$('a.modal').each(function(el) {
						el.addEvent('click', function(e) {
						new Event(e).stop();
						SqueezeBox.fromElement(el);
						});
					});
				});
			</script>";
			//echo $pane->startPanel("CBE Info", "cbe_info");
			include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'info'.DS.'info.php');
			//echo $pane->endPanel();

			?>
		</div>
	</td>
</tr>
</table>
<?php
/**
* @copyright Copyright (C) 2006-2008 Geraint Edwards
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

require_once( JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers' .DS. 'defines.php' );
JLoader::register('JoomfishManager', JOOMFISH_ADMINPATH .DS. 'classes' .DS. 'JoomfishManager.class.php' );
JLoader::register('JoomFishVersion', JOOMFISH_ADMINPATH .DS. 'version.php' );

$linkType = $params->get("linktype","newwindow");

$value = array();
$value[]="com_content#content#cid#task#!edit";
$value[]="com_frontpage#content#cid#task#!edit";
$value[]="com_sections#sections#cid#task#!edit";
$value[]="com_categories#categories#cid#task#!edit";
$value[]="com_contact#contact_details#cid#!edit";
$value[]="com_menus#menu#cid#task#!edit";
$value[]="com_modules#modules#cid#task#!edit#client#!1";
$value[]="com_newsfeeds#newsfeeds#cid#task#!edit";
$value[]="com_poll#polls#cid#task#!edit";

$components = $params->get("components",$value);

$mapping=null;
foreach ($components as $component){
	$map = explode("#",$component);
	if (count($map)>=3 && trim($map[0])==$option){
		if (count($map)>3 && (count($map)-3)%2==0){
			$matched=true;
			for ($p=0;$p<(count($map)-3)/2;$p++){
				$testParam = JRequest::getVar( trim($map[3+$p*2]), '');
				if ((strpos(trim($map[4+$p*2]),"!")!==false && strpos(trim($map[4+$p*2]),"!")==0)){
					if ($testParam == substr(trim($map[4+$p*2]),1)){
						$matched=false;
						break;
					}
				}
				else {
					if ($testParam != trim($map[4+$p*2])){
						$matched=false;
						break;
					}
				}
			}
			if ($matched) {
				$mapping=$map;
				break;
			}
		}
		else {
			$mapping=$map;
			break;
		}
	}
}
if ($mapping!=null){
	$joomFishManager = & JoomFishManager::getInstance();// JoomFishManager(JPATH_ADMINISTRATOR."/components/com_joomfish");

	//Global definitions
	if( !defined('DS') ) {
		define( 'DS', DIRECTORY_SEPARATOR );
	}

	if( !defined('JOOMFISH_PATH') ) {
		define( 'JOOMFISH_PATH', JPATH_SITE .'components'.DS.'com_joomfish' );
		define( 'JOOMFISH_ADMINPATH', JPATH_ADMINISTRATOR .DS.'components'.DS.'com_joomfish' );
		define( 'JOOMFISH_LIBPATH', JOOMFISH_ADMINPATH .DS. 'libraries' );
		define( 'JOOMFISH_LANGPATH', JOOMFISH_PATH .DS. 'language' );
		define( 'JOOMFISH_URL', '/components/com_joomfish');
	}

//	require_once( JOOMFISH_LIBPATH .DS. 'joomla' .DS. 'language.php' );
//	require_once( JOOMFISH_LIBPATH .DS. 'joomla' .DS. 'registry.php' );

	$lang = JFactory::getLanguage();
	$lang->load('com_joomfish');
	
	$langActive = JoomFishManager::getLanguages( true );
	$langOptions[] = JHTML::_('select.option', -1, JText::_("SELECT LANGUAGE") );

	if ( count($langActive)>0 ) {
		foreach( $langActive as $language )
		{
			$langOptions[] = JHTML::_('select.option', $language->id, $language->name );
		}
	}
	$langlist = JHTML::_('select.genericlist', $langOptions, 'select_language_id', 'id="select_language_id" class="inputbox"  size="1"', 'value', 'text', -1);//$langActive[0]->id );
	// I also need to trap component specific actions e.g. pony gallery uses
?>
<span class='modtranslate'>
<script language="JavaScript" type="text/javascript">
function translateItem(){
	var langCode=document.getElementById('select_language_id').value;
	var option="<?php echo trim($mapping[1]);?>";

	if (document.adminForm.boxchecked.value==0) {
		<?php
		$setlang="&select_language_id=\"+langCode+\"";
		global $mosConfig_live_site;
		$targetURL = JURI::root()."/administrator/index2.php?option=com_joomfish&task=translate.edit&catid=\"+option+\"".$setlang;
		if ($linkType=="newwindow") echo "window.open(\"$targetURL\"";
		else echo "document.location.replace(\"$targetURL\"";

		if ($linkType=="newwindow") echo ',"translation","innerwidth=800,innerheight=500,menubar=yes,status=yes,location=yes,resizable=yes,scrollbars=yes"'?>);
		return;
	}

	if (document.adminForm.boxchecked.value!=1) {
		alert("You must select exactly one item to translate");
		return;
	}
	// not all components use "cid" e.g. ponygallery uses act=pictures or act=showcatg
	var cid = "<?php echo trim($mapping[2]);?>[]";
	var checkboxes = document.getElementsByName(cid);
	for (var i=0;i<checkboxes.length;i++){
		if (checkboxes[i].checked){
			//alert("you want to edit item "+(i+1)+" content item id = "+checkboxes[i].value);
			// second part is language id 1=Cymraeg,5=German etc!
			<?php
			global $mosConfig_live_site;
			$targetURL = JURI::root()."/administrator/index2.php?task=translate.edit&boxchecked=1&catid=\"+option+\"&cid[]=0|\"+checkboxes[i].value+\"|\"+langCode+\"&option=com_joomfish";
			if ($linkType=="newwindow") echo "window.open(\"$targetURL\"";
			else echo "document.location.replace(\"$targetURL\"";

			if ($linkType=="newwindow") echo ',"translation","innerwidth=800,innerheight=500,menubar=yes,status=yes,location=yes,resizable=yes,scrollbars=yes"'?>);
			return;
		}
	}
	alert("There was a problem");
}
</script>
<?php
JHTML::stylesheet("mod_translate.css","administrator/modules/mod_translate/");
echo $langlist;
?>
<a href="javascript:translateItem()" title="translate this item"><img src="modules/mod_translate/mod_translate.png"  class='jfimg' alt="translate" /></a>
</span>
<?php
}
else {
?>
<span class='modtranslate'>
<img src="modules/mod_translate/mod_translate_no.png" class='jfimg' alt="No Translation" />
</span>
<?php
}
?>

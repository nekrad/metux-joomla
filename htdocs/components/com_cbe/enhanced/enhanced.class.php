<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Include the enhanced language files
$database = &JFactory::getDBO();
$database->setQuery("SELECT enhanced_params FROM #__cbe_tabs");
$enhanced_names = $database->loadObjectList();
//print_r($enhanced_names);
$cbepath = dirname(JApplicationHelper::getPath( 'front_html', 'com_cbe' ));
$cbeadminpath = dirname(JApplicationHelper::getPath( 'admin_html', 'com_cbe' ));

foreach($enhanced_names as $enhanced_name)
{
	//$enhanced_params = new JParameter($enhanced_name->enhanced_params);
	$enhanced_params = new JParameter($enhanced_name->enhanced_params);
	//$enhanced_params = $tp->toString($format='INI', $namespace = null, $enhanced_name->enhanced_params);
	//echo "hier und jetzt: " . $enhanced_name->enhanced_params;
	//print_r($enhanced_params);
	//print_r($enhanced_params);
	//$enhanced_params = mosParseParams($enhanced_name->enhanced_params);
	//string get (string $key, [mixed $default = ''], [ $group = '_default'])
	//if(@$enhanced_params->tabtype != 3)
	if ($enhanced_params->get('tabtype') != 3)
	{
		//if (file_exists($cbepath.'/components/com_cbe/enhanced/'.@$enhanced_params->enhancedname.'/language/'.$mosConfig_lang.'.php'))
		if (file_exists($cbepath . '/enhanced/' . $enhanced_params->get('enhancedname') . '/language/' . $mosConfig_lang.'.php'))
		{
			include_once($cbepath . '/enhanced/' . $enhanced_params->get('enhancedname') . '/language/' . $mosConfig_lang.'.php');
		}
		else
		{
			include_once($cbepath . '/enhanced/' . $enhanced_params->get('enhancedname') . '/language/english.php');
		}
	}
}
if (file_exists($cbepath.'/enhanced/language/'.$mosConfig_lang.'.php'))
{
	include_once($cbepath.'/enhanced/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once($cbepath.'/enhanced/language/english.php');
}

class enhancedTabs {
	/** @var int Use cookies */
	var $useCookies = 0;
	var $ui=0; /** 1=Front End 2=Admin */
	var $action=0; /** 1=Display 2=Edit */
	var $fieldJS=""; /** adds additional validation javascript for edit tabs */
	var $pane;
	/**
	* Constructor
	* Includes files needed for displaying tabs and sets cookie options
	* @param int useCookies, if set to 1 cookie will hold last used tab between page refreshes
	*/
	function __construct($useCookies,$ui,$templatedir=null) {
		$this->enhancedTabs($useCookies,$ui,$templatedir);
	}

	function enhancedTabs($useCookies,$ui,$templatedir=null)
	{
		global $ueConfig,$enhanced_Config;
		//jimport('joomla.html.pane');
		//$this->pane =& JPane::getInstance('tabs'); 

		$this->ui=$ui;
		$tdir = (!empty($templatedir))? $templatedir:'default';

		echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . JURI::root() . "components/com_cbe/templates/$tdir/cbe.css\" />";
		echo "<script type='text/javascript' src='" . JURI::root() . "components/com_cbe/js/tabber.js'></script>";
		/*
		
		if($templatedir==null) $templatedir=$ueConfig['templatedir'];
		echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . substr_replace(JURI::root(), '', -1, 1). "/components/com_cbe/templates/".$templatedir."/tab.css\" />";
		if ($enhanced_Config['flatten_tabs'] != '1') {
			echo "<script type=\"text/javascript\" src=\"". substr_replace(JURI::root(), '', -1, 1) . "/components/com_cbe/templates/tabpane.js\"></script>";
		}
		*/
		$this->useCookies = $useCookies;
	}

	/**
	* creates a tab pane and creates JS obj
	* @param string The Tab Pane Name
	*/
	function startPane($id)
	{
		/*
		$pane = $this->pane;
		echo $pane->startPane($id);
		echo "<div class=\"tab-pane\" id=\"".$id."\">";
		echo "<script type=\"text/javascript\">\n";
		echo "   var tabPane".$id." = new WebFXTabPane( document.getElementById( \"".$id."\" ), ".$this->useCookies." )\n";
		echo "</script>\n";
		*/
		echo "<div class='tabber' id='$id'>\n";
	}

	/**
	* Ends Tab Pane
	*/
	function endPane() {
		/*
		$pane = $this->pane;
		echo $pane->endPane();
		$return =  "</div>";
		echo $return;
		*/
		echo '</div>';
	}

	/*
	* Creates a tab with title text and starts that tabs page
	* @param tabText - This is what is displayed on the tab
	* @param paneid - This is the parent pane to build this tab on
	*/


	function startTab($pID, $tabText, $paneid, $img=null ) {
		/*
		$pane = $this->pane;
		echo $pane->startPanel($tabText, "tab" . $paneid);

		echo "<div class=\"tab-page\" id=\"".$paneid."\">";
		echo "<h2 class=\"tab\">".$tabText."</h2>";
		echo "<script type=\"text/javascript\">\n";
		echo "  tabPane".$pID.".addTabPage( document.getElementById( \"".$paneid."\" ) );";
		echo "</script>";
		*/
		echo "<div class='tabbertab' title='$tabText'>\n";
		//if ($img)
		$icon = JURI::root() . "components/com_cbe/images/profiles.gif";
		echo "<img class='icontab' src='" . $icon . "'>";
	}


	// hide empty tabs
	function hideTab($pID,$tabText,$paneid ) {
		/*
		echo "<div class=\"tab-page\" id=\"".$paneid."\">";
		echo "<h2 class=\"tab\" style=\"display:none\">".$tabText."</h2>";
		echo "<script type=\"text/javascript\">\n";
		echo "  tabPane".$pID.".addTabPage( document.getElementById( \"".$paneid."\" ) );";
		echo "</script>";
		*/
	}

	/*
	* Ends a tab page
	*/
	function endTab() {
		/*

		$pane = $this->pane;
		echo $pane->endPanel();
		$return =  "</div>";
		echo $return;
		*/
		echo "</div>\n";
	}
}

function getLangEnDefinition($text)
{

	if(defined($text))

	$returnText = constant($text);

	else $returnText = $text;

	return $returnText;
}

//language filter by Jeffrey Randall
class moslanguage_filter extends JTable {

	var $id=null;
	var $badword=null;
	var $published=null;

	/**
* @param database A database connector object
*/

	function __construct(&$db) {
		$this->moslanguage_filter($db);
	}


	function moslanguage_filter( &$db ) {
		//
		//$this->JTable( '#__cbe_bad_words', 'id', $db );
		parent::__construct( '#__cbe_bad_words', 'id', $db );

	}
}

class mosbadUserNames extends JTable {

	var $id=null;
	var $badname=null;
	var $published=null;

	/**
* @param database A database connector object
*/

	function __construct(&$db) {
		$this->mosbadUserNames($db);
	}

	function mosbadUserNames( &$db ) {

		//$this->JTable( '#__cbe_bad_usernames', 'id', $db );
		parent::__construct( '#__cbe_usernames', 'id', $db );

	}
}
?>
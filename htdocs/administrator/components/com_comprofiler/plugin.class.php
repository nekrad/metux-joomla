<?php
/**
* Joomla/Mambo Community Builder : Plugin Handler
* @version $Id: plugin.class.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage plugin.class.php
* @author various, JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com and various
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mainframe;
include_once( $mainframe->getCfg( 'absolute_path' ) . "/administrator/components/com_comprofiler/plugin.foundation.php" );
cbimport( 'cb.database' );


/** utility: adds all vars of object $src to object $obj except the variable named in array exclude Array */
function addVarsToClass(&$obj,$src,$excludeArray) {
	foreach(get_object_vars($src) as $key => $val) {
		if(!in_array($key,$excludeArray)) {
			$obj->$key = $val;
		}
	}	
}

class cbPluginHandler {
	/** @var array An array of functions in event groups */
	var $_events=null;
	/** @var array An array of menu and status items (array) */
	var $_menus=null;
	/** @var array An array of lists */
	var $_lists=null;
	/** @var array An array of loaded plugins objects, index=pluginId */
	var $_plugins=null;
	/** @var array An array indexed by the group-name of arrays of plugin ids of the plugins already loaded containing stdClass objects of the plugin table entry */
	var $_pluginGroups=array();
	/** @var int Index of the plugin being loaded */
	var $_loading=null;
	/** @var array collection of debug data */
	var $debugMSG=array();
	/** @var string Error Message*/
	var $errorMSG=array();
	var $_iserror=false;
	var $params=null;	
	
	/**
	* Constructor
	*/
	function cbPluginHandler() {
		$this->_events = array();
	}
	/**
	* Loads all the bot files for a particular group (if group not already loaded)
	* @param string The group name, relates to the sub-directory in the plugins directory
	* @param mixed array of int : ids of plugins to load. OR: string : name of class 
	* @param int if 1 (DEFAULT): load only published plugins, if 0: load all plugins including unpublished ones
	* @return boolean TRUE: load done, FALSE: no plugin loaded
	*/
	function loadPluginGroup( $group,$ids=null, $publishedStatus=1 ) {
		global $_CB_database, $my;
		
		$this->_iserror = false;

		if (!isset($this->_pluginGroups[$group]) || !$this->all_in_array_key($ids, $this->_pluginGroups[$group])) {
			if ($ids === null) $where = "";
			elseif (count($ids)>=1) $where = "AND id IN (".implode(",",$ids).")";
			$group = trim( $group );
			if ( $publishedStatus == 1 ) {
				$published = "= 1";
			} else {
				$published = ">= " . (int) $publishedStatus;
			}
			$_CB_database->setQuery( "SELECT id, folder, element, published, type, params, CONCAT_WS('/',folder,element) AS lookup"
			. "\n FROM #__comprofiler_plugin"
			. "\n WHERE published " . $published . " AND access <= ". (int) $my->gid . " AND type='$group' $where "
			. "\n ORDER BY ordering"
			);
			if (!($plugins = $_CB_database->loadObjectList())) {
				// echo "Error loading Plugins: " . $_CB_database->getErrorMsg();
				return false;
			}
			foreach ($plugins AS $plugin) {
				if (!isset($this->_pluginGroups[$group][$plugin->id]) && $this->_loadPluginFile($plugin))
				{
					$this->_pluginGroups[$group][$plugin->id] = $plugin;
				}
			}
		}
		return true;
	}
	/** utility: checks if all elements of array needles are in array haystack */
	function all_in_array($needles,$haystack) {
		if (is_array($needles)) {
			foreach ($needles as $needle) {
				if (!in_array($needle,$haystack)) return false;
			}
		} else {
			if (!in_array($needles,$haystack)) return false;
		}
		return true;
	}
	/** utility: checks if all elements of array needles are in array haystack */
	function all_in_array_key($needles,$haystack) {
		if (is_array($needles)) {
			foreach ($needles as $needle) {
				if (!array_key_exists($needle,$haystack)) return false;
			}
		} else {
			if (!array_key_exists($needles,$haystack)) return false;
		}
		return true;
	}

	function _loadPluginFile($plugin) {
		global $mainframe,$_PLUGINS;
		
		$path = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' . $plugin->type . '/'. $plugin->folder . '/' . $plugin->element . '.php';
		if (file_exists( $path )) {
			$this->_loading = $plugin->id;
			$this->_plugins[$plugin->id] = $plugin;
			require_once( $path );
			$this->_loading = null;
			return true;
		} else {
			return false;
		}
	}
	function getPluginPath() {
		global $mainframe, $_PLUGINS;

		// $plugin		=	$_PLUGINS->_pluginGroups[$this->type][$this->_cbpluginid];	//TBD: check for multiple classes per plugin ??? + getPluginCLass/vs. getTabCLass
		$plugin		=	$_PLUGINS->_plugins[$this->_cbpluginid];					//TBD: remove those vars from here and make this function available to API
		$path = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' . $plugin->type . '/'. $plugin->folder;
		return $path;
	}
	function getPluginLIvePath() {
		global $mainframe, $_PLUGINS;

		// $plugin		=	$_PLUGINS->_pluginGroups[$this->type][$this->_cbpluginid];	//TBD: check for multiple classes per plugin ??? + getPluginCLass/vs. getTabCLass
		$plugin		=	$_PLUGINS->_plugins[$this->_cbpluginid];					//TBD: remove those vars from here and make this function available to API
		$path = $mainframe->getCfg('live_site') . '/components/com_comprofiler/plugin/' . $plugin->type . '/'. $plugin->folder;
		return $path;
	}
	function _loadParams($pluginid, $extraParams=null) {
		global $_PLUGINS;
		$this->params=new cbParamsBase($_PLUGINS->_plugins[$pluginid]->params . "\n" . $extraParams);	
	}
	function getParams() {
		return $this->params;
	}
	function getXml( $type = null, $typeValue = null ) {
		return null;		// override if needed
	}
	function _internalPLUGINSaddMenu( $menuItem ) {
		$this->_menus[] = $menuItem;
	}
	/**
	* Registers a menu or status item to a particular menu position
	* @param array a menu item like:
		// Test example:
		$mi = array(); $mi["_UE_MENU_CONNECTIONS"]["duplique"]=null;
		$this->addMenu( array(	"position"	=> "menuBar" ,		// "menuBar", "menuList"
									"arrayPos"	=> $mi ,
									"caption"	=> _UE_MENU_MANAGEMYCONNECTIONS ,
									"url"		=> sefRelToAbs($ue_manageConnection_url) ,		// can also be "<a ....>" or "javascript:void(0)" or ""
									"target"	=> "" ,	// e.g. "_blank"
									"img"		=> null ,	// e.g. "<img src='plugins/user/myplugin/images/icon.gif' width='16' height='16' alt='' />"
									"alt"		=> null ,	// e.g. "text"
									"tooltip"	=> _UE_MENU_MANAGEMYCONNECTIONS_DESC ,
									"keystroke"	=> null ) );	// e.g. "P"
		// Test example: Member Since:
		$mi = array(); $mi["_UE_MENU_STATUS"]["_UE_MEMBERSINCE"]["dupl"]=null;
		$dat = cbFormatDate($user->registerDate);
		if (!$dat) $dat="?";
		$this->addMenu( array(	"position"	=> "menuList" ,		// "menuBar", "menuList"
									"arrayPos"	=> $mi ,
									"caption"	=> $dat ,
									"url"		=> "" ,		// can also be "<a ....>" or "javascript:void(0)" or ""
									"target"	=> "" ,	// e.g. "_blank"
									"img"		=> null ,	// e.g. "<img src='plugins/user/myplugin/images/icon.gif' width='16' height='16' alt='' />"
									"alt"		=> null ,	// e.g. "text"
									"tooltip"	=> _UE_MEMBERSINCE_DESC ,
									"keystroke"	=> null ) );	// e.g. "P"
	*/
	function addMenu( $menuItem ) {
		global $_PLUGINS;
			$_PLUGINS->_internalPLUGINSaddMenu($menuItem);
	}
	/**
	* Returns all menu items registered with addMenu
	* @param string The event name
	* @param string The function name
	*/
	function getMenus() {
		return $this->_menus;
	}
	/**
	* Registers a function to a particular event group
	* @param string The event name
	* @param string The function name
	*/
	function registerFunction( $event, $method, $class=null ) {
		$this->_events[$event][] = array( $class,$method, $this->_loading );
	}
	/**
	* Calls all functions associated with an event group
	* @param string The event name
	* @param array An array of arguments
	* @param boolean True is unpublished bots are to be processed
	* @return array An array of results from each function call
	*/
	function trigger( $event, $args=null ) {
		$result = array();

		if ($args === null) {
			$args = array();
		}
		if (isset( $this->_events[$event] )) {
			foreach ($this->_events[$event] as $func) {
				$result[]=$this->call($func[2],$func[1],$func[0],$args);
			}
		}
		return $result;
	}
	function is_errors() {
		return $this->_iserror;
	}
	/**
	* Execute the plugin class/method pair
	* @param int id of plugin
	* @param string name of plugin variable
	* @param mixed value to assign (if any)
	* @return mixed : previous value
	*/
	function plugVarValue($pluginid, $var, $value=null) {
		$preValue = $this->_plugins[$pluginid]->$var;
		if ($value !== null) $this->_plugins[$pluginid]->$var = $value;
		return $preValue;
	}
	/**
	* Execute the plugin class/method pair
	* @param $pluginid int id of plugin
	* @param $method string name of plugin method
	* @param $class string name of plugin class
	* @param $args array set of variables to path to class/method
	* @param $extraParams string additional parameters external to plugin params (e.g. tab params)
	* @return mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function call( $pluginid, $method, $class, &$args, $extraParams = null, $ignorePublishedStatus = false ) {
		if ($class!=null && class_exists($class)) {
			if ( $this->_plugins[$pluginid]->published || $ignorePublishedStatus ) {
				if (!isset($this->_plugins[$pluginid]->classInstance[$class])) {
					if (!isset($this->_plugins[$pluginid]->classInstance)) {
						$this->_plugins[$pluginid]->classInstance = array();
					}
					$this->_plugins[$pluginid]->classInstance[$class] = new $class();
					$this->_plugins[$pluginid]->classInstance[$class]->_cbpluginid		=	$pluginid;
				}
				if (method_exists( $this->_plugins[$pluginid]->classInstance[$class],$method )) {
					$this->_plugins[$pluginid]->classInstance[$class]->_loadParams($pluginid, $extraParams);
					addVarsToClass($this->_plugins[$pluginid]->classInstance[$class], $this->_plugins[$pluginid], array("params"));
					return call_user_func_array(array(&$this->_plugins[$pluginid]->classInstance[$class],$method), $args);
				} 
			}
		} elseif (function_exists( $method )) {
			if ( $this->_plugins[$pluginid]->published || $ignorePublishedStatus ) {
				$this->_loadParams($pluginid, $extraParams);
				return call_user_func_array( $method, $args );
			} 
		}
		return false;
	}
	/**
	* Gets a variable from the plugin class
	* @param int id of plugin
	* @param string name of plugin class
	* @param string name of class variable
	* @return mixed : variable's content
	*/
	function getVar($pluginid, $class, $variable) {
		if ($class!=null && class_exists($class) && isset( $this->_plugins[$pluginid] ) ) {
			if ($this->_plugins[$pluginid]->published) {
				if (isset( $this->_plugins[$pluginid]->classInstance[$class]->$variable )) {
					return $this->_plugins[$pluginid]->classInstance[$class]->$variable;
				} 
			}
		}
		return false;
	}

	/**
	* Gets the text of the last error
	* @return string text for error message
	*/
	function getErrorMSG( $separator = "\n" ) {
		$error		=	null;
		if ( count( $this->errorMSG ) > 0 ) {
			$errs	=	$this->errorMSG;
			$error	=	implode( $separator, $errs );
		}
		return $error;
	}
	/**
	* PRIVATE method: sets the text of the last error
	* @param string error message
	* @return boolean true
	*/
	function _setErrorMSG($msg) {
		$this->errorMSG[]=$msg;
		return true;
	}
	/**
	* PRIVATE method: sets the error condition and priority (for now 0)
	* @param error priority
	* @return boolean true
	*/	
	function raiseError($priority) {
		$this->_iserror=true;	
		return true;
	}
	
	/**
	* Gets the debug text
	* @returns string text for debug
	*/
	function getDebugMSG() {
		return $this->debugMSG;
	}
	/**
	* PRIVATE method: sets the text of the last error
	* @returns void
	*/
	function _setDebugMSG($method,$msg) {
		$debugARRAY=array();
		$debugARRAY['class']=get_class($this);
		$debugARRAY['method']=$method;
		$debugARRAY['msg']=$msg;
		$this->debugMSG[]=$debugARRAY;
		return true;
	}
}	// end class cbPluginHandler

/**
* Event Class for handling the CB event api
* @package Community Builder
* @author JoomlaJoe
*/
class cbEventHandler extends cbPluginHandler  {

	/**
	* Constructor
	*/
	function cbEventHandler() {
		$this->cbPluginHandler();
	}
}

/**
* Tab Class for handling the CB tab api
* @package Community Builder
* @author JoomlaJoe and Beat
*/
class cbTabHandler extends cbPluginHandler  {
	var $fieldJS="";

	/**
	* Constructor
	*/
	function cbTabHandler() {
		$this->cbPluginHandler();
	}
	/**
	* Generates the menu and user status to display on the user profile by calling back $this->addMenu
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns boolean : either true, or false if ErrorMSG generated
	*/
	function getMenuAndStatus($tab,$user,$ui) {
	}
	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab, $user, $ui) {
	}
	/**
	* Generates the HTML to display the user edit tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getEditTab($tab, $user, $ui) {
	}
	/**
	* Saves the user edit tab postdata into the tab's permanent storage
	* @param object tab reflecting the tab database entry (incl. id. Will be stored after returning)
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function saveEditTab($tab, &$user, $ui, $postdata) {
	}
	/**
	* Generates the HTML to display the registration tab/area
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayRegistration($tab, $user, $ui) {
	}
	/**
	* Saves the registration tab/area postdata into the tab's permanent storage
	* @param object tab reflecting the tab database entry (incl. id. Will be stored after returning)
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function saveRegistrationTab($tab, &$user, $ui, $postdata) {
	}
	/**
	* WARNING: UNCHECKED ACCESS! On purpose unchecked access for M2M operations
	* Generates the HTML to display for a specific component-like page for the tab. WARNING: unchecked access !
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated, or null if nothing to display
	*/
	function getTabComponent($tab, $user, $ui, $postdata) {
		return null;
	}
	//
	// private methods for inheriting classes:
	//
	/**
	* adds a validation JS code for the Edit Profile and Registration pages
	* @param string Javascript code ready for HTML output, with a tab \t at the begin and a newline \n at the end.
	*/
	function _addValidationJS($js)
	{
		$this->fieldJS .= $js;
	}
	/**
	* internal utility method
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @returns string value of the tab forms&urls prefix
	*/
	function _getPrefix($postfix="")
	{
		return str_replace(".","_",((strncmp($this->element, "cb.", 3)==0)? substr($this->element,3) : $this->element).$postfix);
	}
	/**
	* gets an ESCAPED and urldecoded request parameter for the plugin
	* @param string name of parameter in REQUEST URL
	* @param string default value of parameter in REQUEST URL if none found
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @return string value of the parameter (urldecode processed for international and special chars) and ESCAPED! and ALLOW HTML!
	*		you need to call stripslashes to remove escapes, and htmlspecialchars before displaying.
	*/
	function _getReqParam( $name, $def=null, $postfix="" ) {
		global $_GET, $_POST;

		$prefix		=	$this->_getPrefix($postfix);

		if ( isset( $_POST[$prefix.$name] ) ) {
			return cbGetParam( $_POST, $prefix.$name, $def );
		} else if ( isset( $_GET[$prefix.$name] ) ) {
			return utf8ToISO( urldecode( cbGetParam( $_GET, $prefix.$name, $def ) ) );
		} else {
			return $def;
		}
	}
	/**
	* gets the name input parameter for search and other functions
	* @param string name of parameter of plugin
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @returns string value of the name input parameter
	*/
	function _getPagingParamName( $name="search", $postfix="" )
	{
		$prefix		=	$this->_getPrefix($postfix);
		return $prefix.$name;
	}
	/**
	* gives the URL of a link with plugin parameters.
	* @param array of string with key name of parameters
	* @param string cb task to link to (default: userProfile)
	* @param boolean TRUE to call sefRelToAbs (default), FALSE to leave URL unsefed
	* @param array of string with keys of parameters to not include
	* @return string value of the parameter
	*/
	function _getAbsURLwithParam( $paramArray, $task="userProfile", $sefed=true, $excludeParamList=array() )
	{
		global $_POST, $_GET, $_CB_database;
		
		$prefix = $this->_getPrefix();
		
		if (isset($paramArray["Itemid"])) {
			$Itemid		=	(int) $paramArray["Itemid"];
			unset($paramArray["Itemid"]);
		} else if(isset($_POST['Itemid'])) {
			$Itemid		=	(int) cbGetParam($_POST,'Itemid',0);
		} else if(isset($_GET['Itemid'])) {
			$Itemid		=	(int) cbGetParam($_GET,'Itemid',0);
		} else {
			$_CB_database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1");
			$Itemid		=	(int) $_CB_database->loadResult();
		}
		if ($task=="userProfile" && !isset($paramArray["user"])) {
			if (isset($_POST['user'])) {
				$paramArray["user"] = urldecode(cbGetParam($_POST,'user',null));
			} else {
				$paramArray["user"] = urldecode(cbGetParam($_GET,'user',null));
			}
		}
		if (!isset($paramArray["tab"])) {
	/*		if (isset($_POST['tab'])) {
				$paramArray["tab"] = cbGetParam($_POST,'tab',null);
			} else if (isset($_GET['tab'])) {
				$paramArray["tab"] = urldecode(cbGetParam($_GET,'tab',null));
			} else {
	*/
				$paramArray["tab"] = strtolower(get_class($this));
	//		}
		}
		$uri = "index.php?option=com_comprofiler&amp;task=".$task
			.( ( isset( $paramArray["user"] ) && $paramArray["user"] ) ? '&amp;user='.htmlspecialchars(stripslashes($paramArray["user"])) : '')
			.($Itemid ? '&amp;Itemid='.$Itemid : '')
			.($paramArray["tab"] ? '&amp;tab='.htmlspecialchars(stripslashes($paramArray["tab"])) : '');
		reset($paramArray);
		while (list($key, $val) = each($paramArray)) {
			if (!in_array($key,array("Itemid","user","tab")) && !in_array($key,$excludeParamList)) {
				if ($val) $uri .= "&amp;".htmlspecialchars($prefix.$key)."=".htmlspecialchars(stripslashes($val));
			}
		}
		if ( $sefed && is_callable("sefRelToAbs") ) {
			return sefRelToAbs($uri);
		} else {
			return $uri;
		}
	}
	/**
	 * Returns the tab description with all replacements of variables and of language strings made.
	 *
	 * @param  cbTabHandler  $tab
	 * @param  mosUser       $user
	 * @param  string        $htmlId  div id tag for the description html div
	 * @return string
	 */
	function _writeTabDescription( $tab, $user, $htmlId = null ) {
		if ( $tab->description != null ) {
			$return = "\t\t<div class=\"tab_Description\""
					. ( $htmlId ? " id=\"".$id."\"" : "" )
					. ">"
					. getLangDefinition( cbReplaceVars( unHtmlspecialchars( $tab->description ) , $user ))
					."</div>\n";
		} else {
			$return = null;
		}
		return $return;
	}
	/**
	* Writes the html search box as <form><div><input ....
	* @param array: paging parameters. ['limitstart'] is the record number to start dislpaying from will be ignored
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @param string the class/style for the div
	* @param string the class/style for the input
	* @param string cb task to link to (default: userProfile)
	* @return string html text displaying a nice search box
	*/
	function _writeSearchBox($pagingParams,$postfix="",$divClass="style=\"float:right;\"",$inputClass="class=\"inputbox\"",$task="userProfile")
	{
		$base_url = $this->_getAbsURLwithParam($pagingParams, $task, true, array($postfix."search",$postfix."limitstart"));
		$searchPagingParams = stripslashes($pagingParams[$postfix."search"]);

		$searchForm = "<form action=\"".$base_url."\" method=\"post\"><div".($divClass?" ".$divClass:"").">";
/* done in _getAbsURLwithParam:
		foreach ($pagingParams as $k => $pp) {
			if ($pp && !in_array($k,array($postfix."search",$postfix."limitstart"))) {
				$searchForm .= "<input type='hidden' name='".$this->_getPagingParamName($k)."' value=\"".htmlspecialchars($pp)."\" />";	//BB _ISO charset into htmlspecialchars everywhere ?
			}
		}
*/
		$searchForm .= "<input type=\"text\" name=\"".$this->_getPagingParamName("search",$postfix)."\" ".$inputClass." value=\""
					.($searchPagingParams ? htmlspecialchars($searchPagingParams) : _UE_SEARCH_INPUT)."\"";
		if (!$searchPagingParams) {
			$searchForm .= " onblur=\"if(this.value=='') { this.value='"._UE_SEARCH_INPUT."'; return false; }\""
						." onfocus=\"if(this.value=='"._UE_SEARCH_INPUT."') this.value='';\"";
		}
		$searchForm .= " onchange=\"if(this.value!='".($searchPagingParams ? str_replace(array("\\","'"),array("\\\\","\\'"),htmlspecialchars($searchPagingParams)) : _UE_SEARCH_INPUT)."')"
					." { ";
		if (!$searchPagingParams) {
			$searchForm .= "if (this.value=='"._UE_SEARCH_INPUT."') this.value=''; ";
		}
		$searchForm .= "this.form.submit(); }\" />"
					. "</div></form>";
		return $searchForm;
	}
	/**
	* Writes the html links for sorting as headers
	* @param array: paging parameters. ['limitstart'] is the record number to start dislpaying from will be ignored
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @param string sorting parameter added as &sortby=... if NOT NULL
	* @param string Name to display as column heading/hyperlink
	* @param boolean true if it is the default sorting field to not output sorting
	* @param string class/style html for the unselected sorting header
	* @param string class/style html for the selected sorting header
	* @param string cb task to link to (default: userProfile)
	* @return string html text displaying paging
	*/
	function _writeSortByLink($pagingParams,$postfix,$sortBy,$sortName,$defaultSort=false,$unselectedClass='class="cbSortHead"',$selectedClass='class="cbSortHeadSelected"',$task="userProfile")
	{
		$url = $this->_getAbsURLwithParam($pagingParams, $task, false, array($postfix."sortby",$postfix."limitstart"));
		$prefix = $this->_getPrefix();
		//done in _getAbsURLwithParam: foreach ($pagingParams as $k => $v) if ($v && $k!=$postfix."sortby")  $url .= "&amp;".htmlentities($prefix.$k)."=".htmlentities($v);
		if (!$defaultSort) $url .= "&amp;".htmlentities($prefix.$postfix)."sortby=".htmlentities($sortBy);
		$class = ((!$pagingParams[$postfix."sortby"] && $defaultSort) || ($pagingParams[$postfix."sortby"]==$sortBy))?" ".$selectedClass:" ".$unselectedClass;
		return '<a href="'.sefRelToAbs($url).'"'.$class.' title="'.sprintf(_UE_CLICKTOSORTBY,htmlspecialchars($sortName, ENT_QUOTES)).'">'
				.htmlspecialchars($sortName, ENT_QUOTES).'</a>';
	}
	/**
	* Writes the html links for pages inside tabs, eg, previous 1 2 3 ... x next
	* @param array: paging parameters. ['limitstart'] is the record number to start dislpaying from will be ignored
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @param int Number of rows to display per page
	* @param int Total number of rows
	* @param string cb task to link to (default: userProfile)
	* @return string html text displaying paging
	*/
	function _writePaging($pagingParams, $postfix, $limit, $total, $task="userProfile")
	{
		$base_url = $this->_getAbsURLwithParam($pagingParams, $task, false, array($postfix."limitstart"));
		$prefix = $this->_getPrefix($postfix);
		return writePagesLinks($pagingParams[$postfix.'limitstart'], $limit, $total,$base_url,null,$prefix);
	}
	/**
	* gets the paging limitstart, search and sortby parameters, as well as additional parameters
	* @param array of string : keyed additional parameters as "Param-name" => "default-value"
	* @param mixed : array of string OR string : postfix for identifying multiple pagings/search/sorts (optional)
	* @return array("limitstart" => current list-start value (default: null), "search" => search-string (default: null), "sortby" => sorting by, +additional parameters as keyed in $additionalParams)
	*/
	function _getPaging($additionalParams=array(), $postfixArray=null)
	{
		$return=array();

		if (!is_array($postfixArray)) {
			if (is_string($postfixArray)) {
				$postfixArray = array($postfixArray);
			} else {
				$postfixArray = array("");
			}
		}
		foreach ($postfixArray as $postfix) {	
			$return[$postfix."limitstart"] = $this->_getReqParam("limitstart", null, $postfix);
			$return[$postfix."search"] = $this->_getReqParam("search", null, $postfix);
			$return[$postfix."sortby"] = $this->_getReqParam("sortby", null, $postfix);
		}
		foreach ($additionalParams as $k => $p) {
			$return[$k] = $this->_getReqParam($k, $p);
		}
		return $return;
	}
	/**
	* sets the paging limitstart, search and sortby parameters, as well as additional parameters
	* @param array of string : keyed additional parameters as "Param-name" => "value"
	* @param string search string
	* @param string sorting parameter added as &sortby=... if NOT NULL
	* @param array of string : keyed additional parameters as "Param-name" => "default-value"
	* @param string postfix for identifying multiple pagings/search/sorts (optional)
	* @return array("limitstart" => current list-start value (default: null), "search" => search-string (default: null), "sortby" => sorting by, +additional parameters as keyed in $additionalParams)
	*/
	function _setPaging($limitstart="0",$search=null,$sortBy=null,$additionalParams=array(), $postfix="")
	{
		$return=array();

		$return[$postfix."limitstart"] = $limitstart;
		$return[$postfix."search"] = $search;
		$return[$postfix."sortby"] = $sortBy;
		foreach ($additionalParams as $k => $p) {
			$return[$k] = $p;
		}
		return $return;
	}
}	// end class cbTabHandler.


/**
* PMS Class for handling the CB PMS api
* @package Community Builder
* @author Beat
*/
class cbPMSHandler extends cbTabHandler  {
	/**
	* Constructor
	*/
	function cbPMSHandler() {
		$this->cbTabHandler();
	}
	/**
	* Sends a PMS message
	* @param int userId of receiver
	* @param int userId of sender
	* @param string subject of PMS message
	* @param string body of PMS message
	* @param boolean false: real user-to-user message; true: system-Generated by an action from user $fromid (if non-null)
	* @return mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function sendUserPMS($toid, $fromid, $subject, $message, $systemGenerated=false) {
	}
	/**
	* returns all the parameters needed for a hyperlink or a menu entry to do a pms action
	* @param int userId of receiver
	* @param int userId of sender
	* @param string subject of PMS message
	* @param string body of PMS message
	* @param int kind of link: 1: link to compose new PMS message for $toid user. 2: link to inbox of $fromid user; 3: outbox, 4: trashbox,
	  5: link to edit pms options
	* @return mixed array of string {"caption" => menu-text ,"url" => NON-sefRelToAbs relative url-link, "tooltip" => description} or false and errorMSG
	*/
	function getPMSlink($toid, $fromid, $subject, $message, $kind) {
	}
	/**
	* gets PMS system capabilities
	* @return mixed array of string {"subject" => boolean ,"body" => boolean} or false if ErrorMSG generated
	*/
	function getPMScapabilites() {
	}
	/**
	* gets PMS unread messages count
	* @param	int user id
	* @return	mixed number of messages unread by user $userid or false if ErrorMSG generated
	*/
	function getPMSunreadCount($userid) {
	}
}


// ----- NO MORE CLASSES OR FUNCTIONS PASSED THIS POINT -----
// Post class declaration initialisations
// some version of PHP don't allow the instantiation of classes
// before they are defined

global $_PLUGINS;
/** @global cbPluginHandler $_PLUGINS */
$_PLUGINS = new cbPluginHandler();


?>

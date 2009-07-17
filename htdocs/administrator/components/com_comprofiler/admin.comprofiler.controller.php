<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: admin.comprofiler.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage admin.comprofiler.php
* @author JoomlaJoe and Beat, database check function by Nick
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_debug, $acl, $mainframe, $mosConfig_lang, $mosConfig_emailpass, $option, $_CB_Admin_Done;
if($mosConfig_debug) {
	ini_set('display_errors',true);
	error_reporting(E_ALL);
}

if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' )) {
	cbRedirect( 'index2.php', _UE_NOT_AUTHORIZED );
}

$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php')) {
  include_once($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php');
} else include_once($UElanguagePath.'/default_language/default_language.php');

require_once( $mainframe->getPath( 'admin_html' ) );
/** @global string $_CB_adminpath
 *  @global string $_CB_joomla_adminpath
 *  @global array $ueConfig
 */
global $_CB_joomla_adminpath, $_CB_adminpath, $ueConfig;
$_CB_joomla_adminpath = $mainframe->getCfg( 'absolute_path' ). "/administrator";
$_CB_adminpath = $_CB_joomla_adminpath. "/components/com_comprofiler";
include_once($_CB_adminpath."/ue_config.php" );
include_once($_CB_adminpath."/plugin.class.php");
include_once($_CB_adminpath."/comprofiler.class.php");
cbimport( 'cb.installer' );
cbimport( 'cb.params' );
cbimport( 'cb.pagination' );
include_once($_CB_adminpath."/imgToolbox.class.php");

if(!isset($mosConfig_emailpass) || is_null($mosConfig_emailpass)) {
	$mosConfig_emailpass=0;
}

/** @global int $_CB_ui   : we're in 1: frontend, 2: admin back-end */
global $_CB_ui;
$_CB_ui = 2;

/** @global stdClass $_CB_Backend_Menu   : 'show' : only displays close button, 'edit' : special close button */
global $_CB_Backend_Menu;
$_CB_Backend_Menu = new stdClass();
									
$task = trim( cbGetParam( $_REQUEST, 'task', null ) );
$cid = cbGetParam( $_REQUEST, 'cid', array( 0 ) );
$uid = cbGetParam( $_REQUEST, 'uid', array( 0 ) );
if (!is_array( $cid )) {
	$ocid=$cid;
	$cid = array ();
	$cid[]=$ocid;
	if (is_callable("mosArrayToInts")) {
		mosArrayToInts($cid);
	}
}

$oldignoreuserabort = ignore_user_abort(true);

$taskPart1 = strtok( $task, '.' );

switch ( $taskPart1 ) {
	case "new":
		editUser( 0, $option );
		break;

	case "edit":
		editUser( intval( $cid[0] ), $option );
		break;

	case "save":
		saveUser( $option );
		break;

	case "remove":
		removeUsers( $cid, $option );
		break;
	
	case "block":
		changeUserBlock( $cid, 1, $option );
		break;

	case "unblock":
		changeUserBlock( $cid, 0, $option );
		break;

	case "approve":
	        approveUser( $cid, 1, $option );
	        break;
	
	case "reject":
	        approveUser( $cid, 0, $option );
	        break;

   	case "showconfig":
      		showConfig( $option );
      		break;

   	case "showinstruction":
      		showInstructions($_CB_database, $option, $mosConfig_lang);
      		break;

   	case "showsubscription":
      		showSubscription($_CB_database, $option, $mosConfig_lang);
      		break;

   	case "saveconfig":
      		saveConfig( $option );
      	break;

	case "newTab":
		editTab( 0, $option);
		break;

	case "editTab":
		editTab( intval( $cid[0] ), $option );
		break;

	case "saveTab":
		saveTab( $option );
		break;

	case "removeTab":
		removeTabs( $cid, $option );
		break;

	case "showTab":
		showTab( $option );
		break;

	case "orderupTab":
	case "orderdownTab":
		orderTabs( $cid[0], ($task == 'orderupTab' ? -1 : 1), $option);
		break;

	case "newField":
		editField( 0, $option);
		break;

	case "editField":
		editField( intval( $cid[0] ), $option );
		break;

	case "saveField":
		saveField( $option );
		break;

	case "removeField":
		removeField( $cid, $option );
		break;

	case "showField":
		showField( $option );
		break;

	case "orderupField":
		orderFields( $cid[0], -1, $option );
		break;

	case "orderdownField":
		orderFields( $cid[0], 1, $option );
		break;

	case "saveList":
		saveList($option );
		break;

	case "editList":
		editList( $cid[0], 1, $option );
		break;
	case "newList":
		editList( 0, $option);
		break;

	case "showLists":
		showLists( $option );
		break;
	case "removeList":
		removeList( $cid, $option );
		break;
	case "orderupList":
		orderLists( $cid[0], -1, $option );
		break;

	case "orderdownList":
		orderLists( $cid[0], 1, $option );
		break;

	case "fieldPublishedYes":
	        publishField( $cid, 1, $option );
	        break;

	case "fieldPublishedNo":
	        publishField( $cid, 0, $option );
	        break;

	case "fieldRequiredYes":
	        requiredField( $cid, 1, $option );
	        break;

	case "fieldRequiredNo":
	        requiredField( $cid, 0, $option );
	        break;

	case "fieldProfileYes1":
	        profileField( $cid, 1, $option );
	        break;

	case "fieldProfileYes2":
	        profileField( $cid, 2, $option );
	        break;

	case "fieldProfileNo":
	        profileField( $cid, 0, $option );
	        break;

	case "fieldRegistrationYes":
	        registrationField( $cid, 1, $option );
	        break;

	case "fieldRegistrationNo":
	        registrationField( $cid, 0, $option );
	        break;

	case "listPublishedYes":
	        listPublishedField( $cid, 1, $option );
	        break;

	case "listPublishedNo":
	        listPublishedField( $cid, 0, $option );
	        break;
	case "listDefaultYes":
	        listDefaultField( $cid, 1, $option );
	        break;

	case "listDefaultNo":
	        listDefaultField( $cid, 0, $option );
	        break;

	case "tabPublishedYes":
	        tabPublishedField( $cid, 1, $option );
	        break;

	case "tabPublishedNo":
	        tabPublishedField( $cid, 0, $option );
	        break;

	case "tools":
		loadTools();
		break;

	case "loadSampleData":
	        loadSampleData();
	        break;

	case "syncUsers":
	        syncUsers();
	        break;

	case "checkcbdb":
		checkcbdb();
		break;

	case "showusers":
		showUsers( $option );
		break;
		
	case 'savetaborder':
		saveTabOrder( $cid );
		break;
		
	case 'savefieldorder':
		saveFieldOrder( $cid );
		break;	
	case 'savelistorder':
		saveListOrder( $cid );
		break;	

		
		
	case 'newPlugin':
	case 'editPlugin':
		editPlugin( $option, $task,  $cid[0] );
		break;



	case 'savePlugin':
	case 'applyPlugin':
		savePlugin( $option, $task );
		break;

	case 'deletePlugin':
		removePlugin( $cid, $option );
		break;

	case 'cancelPlugin':
		cancelPlugin( $option );
		break;

	case 'cancelPluginAction':
		cancelPluginAction( $option );
		break;

	case 'publishPlugin':
	case 'unpublishPlugin':
		publishPlugin( $cid, ($task == 'publishPlugin'), $option );
		break;

	case 'orderupPlugin':
	case 'orderdownPlugin':
		orderPlugin( $cid[0], ($task == 'orderupPlugin' ? -1 : 1), $option);
		break;

	case 'accesspublic':
	case 'accessregistered':
	case 'accessspecial':
		accessMenu( $cid[0], $task, $option );
		break;

	case 'savepluginorder':
		savePluginOrder( $cid );
		break;

	case 'showPlugins':
		viewPlugins( $option);
		break;
		
	case 'installPluginUpload':
		installPluginUpload();
		break;
		
	case 'installPluginDir':
		installPluginDir();
		break;

	case 'installPluginURL':
		installPluginURL();
		break;

	case 'pluginmenu':
		pluginMenu( $option, $cid[0] );
		break;

	case 'latestVersion':
		latestVersion();
		break;

	default:
		// var_export( $ _POST );		//DEBUG!
		teamCredits(2);
		break;
}
if (!is_null($oldignoreuserabort)) ignore_user_abort($oldignoreuserabort);

function saveList( $option ) {
	global $_CB_database, $_POST;
	
	$row = new moscomprofilerLists( $_CB_database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	if(isset($_POST['col1'])) { $row->col1fields = implode("|*|",$_POST['col1']); } else { $row->col1fields = null; } ;
	if(isset($_POST['col2'])) { $row->col2fields = implode("|*|",$_POST['col2']); } else { $row->col2fields = null; } ;
	if(isset($_POST['col3'])) { $row->col3fields = implode("|*|",$_POST['col3']); } else { $row->col3fields = null; } ;
	if(isset($_POST['col4'])) { $row->col4fields = implode("|*|",$_POST['col4']); } else { $row->col4fields = null; } ;

	if ($row->col1enabled != 1) $row->col1enabled=0;
	if ($row->col2enabled != 1) $row->col2enabled=0;
	if ($row->col3enabled != 1) $row->col3enabled=0;
	if ($row->col4enabled != 1) $row->col4enabled=0;
	if ($row->col1captions != 1) $row->col1captions=0;
	if ($row->col2captions != 1) $row->col2captions=0;
	if ($row->col3captions != 1) $row->col3captions=0;
	if ($row->col4captions != 1) $row->col4captions=0;
	if (!$row->store( (int) $_POST['listid'],true)) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}

	cbRedirect( "index2.php?option=$option&task=showLists", "Successfully Saved List: ". $row->title );
}

function showLists( $option ) {
	global $_CB_database, $mainframe, $mosConfig_list_limit, $_CB_joomla_adminpath;

	if(!isset($mosConfig_list_limit) || !$mosConfig_list_limit) $limit = 10;
	else $limit = $mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$lastCBlist = $mainframe->getUserState( "view{$option}lastCBlist", null );
	if($lastCBlist=='showlists') {
		$limitstart	= $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
		$lastSearch = $mainframe->getUserState( "search{$option}", null );
		$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		if ($lastSearch != $search) {
			$limitstart = 0;
			$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		}
		$search = trim( strtolower( $search ) );
	} else {
		clearSearchBox();
		$search="";
		$limitstart = 0;
		$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		$mainframe->setUserState( "view{$option}lastCBlist", "showlists" );
	}

	$where = array();
	if (isset( $search ) && $search!= "") {
		$search = cbEscapeSQLsearch( trim( strtolower( cbGetEscaped($search))));
		$where[] = "(a.title LIKE '%$search%' OR a.description LIKE '%$search%')";
	}

	$_CB_database->setQuery( "SELECT COUNT(*)"
		. "\n FROM #__comprofiler_lists AS a"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $_CB_database->loadResult();
	echo $_CB_database->getErrorMsg();
	if ($total <= $limitstart) $limitstart = 0;
	
	require_once( $_CB_joomla_adminpath . "/includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	$_CB_database->setQuery( "SELECT listid, title, description, published,`default`,ordering,useraccessgroupid"
		. "\nFROM #__comprofiler_lists a"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
		. "\n ORDER BY ordering"
		. "\nLIMIT ". (int) $pageNav->limitstart . ", " . (int) $pageNav->limit
	);

	$rows = $_CB_database->loadObjectList();
	if ($_CB_database->getErrorNum()) {
		echo $_CB_database->stderr();
		return false;
	}

	HTML_comprofiler::showLists( $rows, $pageNav, $search, $option );
	return true;
}

function editList( $fid='0', $option='com_comprofiler' ) {
	global $_CB_database, $my, $acl;

	$row = new moscomprofilerLists( $_CB_database );
	
	if ( $fid ) {
		// load the row from the db table
		$row->load( (int) $fid );
	} else {
		$row->col1enabled	=	'1';
	}

	$lists['published'] = mosHTML::yesnoSelectList( 'published', 'class="inputbox" size="1"', $row->published );
	$lists['default'] = mosHTML::yesnoSelectList( 'default', 'class="inputbox" size="1"', $row->default );
/*
	if ( checkJversion() <= 0 ) {
		$my_groups 	= $acl->get_object_groups( 'users', $my->id, 'ARO' );
	} else {
		$aro_id		= $acl->get_object_id( 'users', $my->id, 'ARO' );
		$my_groups 	= $acl->get_object_groups( $aro_id, 'ARO' );
	}
*/
	$gtree2=array();
	$gtree2 = array_merge( $gtree2, $acl->get_group_children_tree( null, 'USERS', false ));

	$usergids=explode(",",$row->usergroupids);
	$ugids = array();
	foreach($usergids as $usergid) {
		$ugids[]->value=$usergid;
	}

	$lists['usergroups'] = moscomprofilerHTML::selectList( $gtree2, 'usergroups', 'size="4" MULTIPLE onblur="loadUGIDs(this);" mosReq=1 mosLabel="User Groups"', 'value', 'text', $ugids,1 );

	$gtree3=array();
    $gtree3[] = mosHTML::makeOption( -2 , '- Everybody -' );
    $gtree3[] = mosHTML::makeOption( -1, '- All Registered Users -' );
	$gtree3 = array_merge( $gtree3, $acl->get_group_children_tree( null, 'USERS', false ));
	
	$lists['useraccessgroup']=mosHTML::selectList( $gtree3, 'useraccessgroupid', 'size="4"', 'value', 'text', $row->useraccessgroupid );

	
	
	$_CB_database->setQuery( "SELECT f.fieldid, f.title"
		. "\n FROM #__comprofiler_fields AS f"
		. "\n WHERE f.published = 1 AND f.profile = 1" 
		. "\n ORDER BY f.ordering"
	);
	//echo $_CB_database->getQuery();
	$field = $_CB_database->loadObjectList();
	$fields = array();
	//print_r(array_values($field));
	for ($i=0, $n=count( $field ); $i < $n; $i++) {
		$fieldvalue = array();
		$fieldvalue =& $field[$i];
		//print "fieldid = ".$fieldvalue->fieldid;
		$fields[$fieldvalue->title] = $fieldvalue->fieldid;
	}
	//print_r(array_values($fields));
	HTML_comprofiler::editList( $row, $lists,$fields, $option, $fid );
}

function removeList( $cid, $option ) {
	global $_CB_database, $acl;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new moscomprofilerLists( $_CB_database );
		foreach ($cid as $id) {
				$obj->delete( $id );
			}
		}
	
	//if($msg!='') echo "<script type=\"text/javascript\"> alert('".$msg."'); window.history.go(-1);</script>\n";
	cbRedirect( "index2.php?option=$option&task=showLists", $msg );
}

function orderLists( $lid, $inc, $option ) {
	global $_CB_database;
	$row = new moscomprofilerLists( $_CB_database );
	$row->load( (int) $lid );
	$row->move( $inc );
	cbRedirect( "index2.php?option=$option&task=showLists" );
}

function showField( $option ) {
	global $_CB_database, $mainframe, $my, $acl, $mosConfig_list_limit, $_CB_joomla_adminpath;

	if(!isset($mosConfig_list_limit) || !$mosConfig_list_limit) $limit = 10;
	else $limit = $mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$lastCBlist = $mainframe->getUserState( "view{$option}lastCBlist", null );
	if($lastCBlist=='showfields') {
		$limitstart	= $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
		$lastSearch = $mainframe->getUserState( "search{$option}", null );
		$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		if ($lastSearch != $search) {
			$limitstart = 0;
			$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		}
		$search = trim( strtolower( $search ) );
	} else {
		clearSearchBox();
		$search="";
		$limitstart = 0;
		$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		$mainframe->setUserState( "view{$option}lastCBlist", "showfields" );
	}

	$where = array();
	$where[] = "(f.sys = 0)";
	if (isset( $search ) && $search!= "") {
		$search = cbEscapeSQLsearch( trim( strtolower( cbGetEscaped($search))));
		$where[] = "(f.name LIKE '%$search%' OR f.type LIKE '%$search%')";
	}
	$where[] = "(f.tabid = t.tabid)";
	$where[] = "(t.fields = 1)";

	$where[]	 =	"t.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")";

	$_CB_database->setQuery( "SELECT COUNT(*)"
		. "\nFROM #__comprofiler_fields AS f, #__comprofiler_tabs AS t"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $_CB_database->loadResult();
	echo $_CB_database->getErrorMsg();
	if ($total <= $limitstart) $limitstart = 0;

	require_once( $_CB_joomla_adminpath . "/includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	$_CB_database->setQuery( "SELECT f.fieldid, f.title, f.name, f.description, f.type, f.required, f.published, "
		. "f.profile, f.ordering, f.registration, "
		. "t.title AS 'tab', t.enabled AS 'tabenabled', t.pluginid AS 'pluginid', "
		. "p.name AS pluginname, p.published AS pluginpublished "
		. "\nFROM #__comprofiler_fields AS f, #__comprofiler_tabs AS t"
		. "\n LEFT JOIN #__comprofiler_plugin AS p ON p.id = t.pluginid"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
		. "\n ORDER BY t.ordering, f.ordering"
		. "\nLIMIT " . (int) $pageNav->limitstart . ", " . (int) $pageNav->limit
	);

	$rows = $_CB_database->loadObjectList();
	if ($_CB_database->getErrorNum()) {
		echo $_CB_database->stderr();
		return false;
	}

	HTML_comprofiler::showFields( $rows, $pageNav, $search, $option );
	return true;
}

function editField( $fid='0', $option='com_comprofiler' ) {
	global $_CB_database, $my, $acl;

	$row = new moscomprofilerFields( $_CB_database );
	
	if ( $fid != 0 ) {
		// load the row from the db table
		$row->load( (int) $fid );
	
		$fieldTab = new moscomprofilerTabs( $_CB_database );
		// load the row from the db table
		$fieldTab->load( (int) $row->tabid );
	
		if ( ! in_array( $fieldTab->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
			echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
			exit;
		}
	}
	$tabs = $_CB_database->setQuery("SELECT tabid, title FROM #__comprofiler_tabs WHERE `fields`=1 ORDER BY ordering");
	$tabs = $_CB_database->loadObjectList();
	$lists = array();
	$tablist = array();

	for ($i=0, $n=count( $tabs ); $i < $n; $i++) {
		$tab =& $tabs[$i];
	   	$tablist[] = mosHTML::makeOption( $tab->tabid, getLangDefinition($tab->title) );
	}
	
	$lists['tabs'] = mosHTML::selectList( $tablist, 'tabid', 'class="inputbox" size="1" mosReq=1 mosLabel="Tab"', 'value', 'text', $row->tabid );

	$types = array();

	$types[] = mosHTML::makeOption( 'checkbox', 'Check Box (Single)' );
	$types[] = mosHTML::makeOption( 'multicheckbox', 'Check Box (Multiple)' );
	$types[] = mosHTML::makeOption( 'date', 'Date' );
	$types[] = mosHTML::makeOption( 'select', 'Drop Down (Single Select)' );
	$types[] = mosHTML::makeOption( 'multiselect', 'Drop Down (Multi-Select)' );
	$types[] = mosHTML::makeOption( 'emailaddress', 'Email Address' );	
	//$types[] = mosHTML::makeOption( 'password', 'Password Field' );
	$types[] = mosHTML::makeOption( 'editorta', 'Editor Text Area' );
	$types[] = mosHTML::makeOption( 'textarea', 'Text Area' );
	$types[] = mosHTML::makeOption( 'text', 'Text Field' );
	$types[] = mosHTML::makeOption( 'radio', 'Radio Button' );
	$types[] = mosHTML::makeOption( 'webaddress', 'Web Address' );
	$types[] = mosHTML::makeOption( 'delimiter', 'Fields delimiter' );

	$webaddrtypes = array();

	$webaddrtypes[] = mosHTML::makeOption( '0', 'URL only' );
	$webaddrtypes[] = mosHTML::makeOption( '2', 'Hypertext and URL' );
	
	$profiles = array();

	$profiles[] = mosHTML::makeOption( '0', 'No' );
	$profiles[] = mosHTML::makeOption( '1', 'Yes: on 1 Line' );
	$profiles[] = mosHTML::makeOption( '2', 'Yes: on 2 Lines' );

	$fvalues = $_CB_database->setQuery( "SELECT fieldtitle "
		. "\n FROM #__comprofiler_field_values"
		. "\n WHERE fieldid=" . (int) $fid
		. "\n ORDER BY ordering" );
	$fvalues = $_CB_database->loadObjectList();

	$lists['webaddresstypes'] = mosHTML::selectList( $webaddrtypes, 'webaddresstypes', 'class="inputbox" size="1"', 'value', 'text', $row->rows );
		
	$lists['type'] = mosHTML::selectList( $types, 'type', 'class="inputbox" size="1" onchange="selType(this.options[this.selectedIndex].value);"', 'value', 'text', $row->type );

	$lists['required'] = mosHTML::yesnoSelectList( 'required', 'class="inputbox" size="1"', $row->required );

	$lists['published'] = mosHTML::yesnoSelectList( 'published', 'class="inputbox" size="1"', $row->published );

	$lists['readonly'] = mosHTML::yesnoSelectList( 'readonly', 'class="inputbox" size="1"', $row->readonly );

	$lists['profile'] = mosHTML::selectList( $profiles, 'profile', 'class="inputbox" size="1"', 'value', 'text', $row->profile );

	$lists['registration'] = mosHTML::yesnoSelectList( 'registration', 'class="inputbox" size="1"', $row->registration );

	HTML_comprofiler::editfield( $row, $lists, $fvalues, $option, $fid );
}

function saveField( $option ) {
	global $_CB_database, $my, $_POST, $ueConfig;

	if ( ! ( isset( $_POST['oldtabid'] ) && isset( $_POST['tabid'] ) && isset( $_POST['fieldid'] ) ) ) {
		cbRedirect( "index2.php?option=$option&task=showField" );
		return;
	}
	$row = new moscomprofilerFields( $_CB_database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$fieldTab = new moscomprofilerTabs( $_CB_database );
	$fieldTab->load( (int) $row->tabid );
	if ( ! in_array( $fieldTab->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
		echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
		exit;
	}

	if ($row->type == 'webaddress') {
		$row->rows = $_POST['webaddresstypes'];
		if ( !(($row->rows == 0) || ($row->rows == 2)) ) {
			$row->rows = 0;
		}
	}
	if($_POST['oldtabid'] != $_POST['tabid']) {
		if ($_POST['oldtabid'] !== "") {
			//Re-order old tab
			$sql="UPDATE #__comprofiler_fields SET ordering = ordering-1 WHERE ordering > ".(int) $_POST['ordering']." AND tabid = ".(int) $_POST['oldtabid'];
			$_CB_database->setQuery($sql);
			$_CB_database->loadResult();
		}
		//Select Last Order in New Tab
		$sql="SELECT MAX(ordering) FROM #__comprofiler_fields WHERE tabid=".(int) $_POST['tabid'];
		$_CB_database->SetQuery($sql);
		$max = $_CB_database->LoadResult();
		$row->ordering=$max+1;
	}
	mosMakeHtmlSafe($row);

	$row->name = str_replace(" ", "", strtolower($row->name));
	
	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if (!$row->store( (int) $_POST['fieldid'])) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	$fieldValues = array();
	$fieldNames = array();
	$fieldNames=$_POST['vNames'];
	$j=1;
	if($row->fieldid > 0) {
		$_CB_database->setQuery( "DELETE FROM #__comprofiler_field_values"
			. " WHERE fieldid = " . (int) $row->fieldid );
		if( $_CB_database->query() === false ) echo $_CB_database->getErrorMsg();
	} else {
		$_CB_database->setQuery( "SELECT MAX(fieldid) FROM #__comprofiler_fields");
		$maxID=$_CB_database->loadResult();
		$row->fieldid=$maxID;
		echo $_CB_database->getErrorMsg();
	}
	//for($i=0, $n=count( $fieldNames ); $i < $n; $i++) {
	foreach ($fieldNames as $fieldName) {
		if(trim($fieldName)!=null || trim($fieldName)!='') {
			$_CB_database->setQuery( "INSERT INTO #__comprofiler_field_values (fieldid,fieldtitle,ordering)"
				. " VALUES( " . (int) $row->fieldid . ",'".cbGetEscaped(htmlspecialchars($fieldName))."', " . (int) $j . ")"
			);
			if ( $_CB_database->query() === false ) echo $_CB_database->getErrorMsg();
			$j++;
		}

	}

	cbRedirect( "index2.php?option=$option&task=showField", "Successfully Saved Field: ". $row->name);
}

function removeField( $cid, $option ) {
	global $_CB_database, $acl, $ueConfig, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new moscomprofilerFields( $_CB_database );

		foreach ($cid as $id) {
			$id = (int) $id;
			$obj->load( $id );

			$fieldTab = new moscomprofilerTabs( $_CB_database );
			$fieldTab->load( (int) $obj->tabid );
			if ( ! in_array( $fieldTab->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
				echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
				exit;
			}

			$noDelete = 0;
			$_CB_database->setQuery("SELECT COUNT(*) FROM #__comprofiler_lists".
					" WHERE col1fields like '%|*|$id' OR col1fields like '$id|*|%' OR col1fields like '%|*|$id|*|%' OR col1fields='$id'".
					" OR col2fields like '%|*|$id' OR col2fields like '$id|*|%' OR col2fields like '%|*|$id|*|%' OR col2fields='$id'".
					" OR col3fields like '%|*|$id' OR col3fields like '$id|*|%' OR col3fields like '%|*|$id|*|%' OR col3fields='$id'".
					" OR col4fields like '%|*|$id' OR col4fields like '$id|*|%' OR col4fields like '%|*|$id|*|%' OR col4fields='$id'");
			$onList = $_CB_database->loadResult();
			if ($onList > 0) {
				$msg .= getLangDefinition($obj->title) . " cannot be deleted because it is on a List. \n";
				$noDelete = 1;
			}
			if ($obj->sys==1) {
				$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is a system field. \n";
				$noDelete = 1;
			} 
			if ($noDelete != 1) {
				$obj->deleteColumn('#__comprofiler',$obj->name);
				$obj->delete( $id );
				$sql="UPDATE #__comprofiler_fields SET ordering = ordering-1 WHERE ordering > ".(int) $obj->ordering." AND tabid = ".(int) $obj->tabid;
				$_CB_database->setQuery($sql);
				$_CB_database->loadResult();
				//print $_CB_database->getquery();
			}
		}
	}
	
	//if($msg!='') echo "<script type=\"text/javascript\"> alert('".$msg."'); window.history.go(-1);</script>\n";
	cbRedirect( "index2.php?option=$option&task=showField", $msg );
}


function orderFields( $fid, $inc, $option ) {
	global $_CB_database, $my;
	$row = new moscomprofilerFields( $_CB_database );
	$row->load( (int) $fid );

	$fieldTab = new moscomprofilerTabs( $_CB_database );
	$fieldTab->load( (int) $row->tabid );
	if ( ! in_array( $fieldTab->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
		echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
		exit;
	}

	$row->move( $inc , "tabid='$row->tabid'");
	cbRedirect( "index2.php?option=$option&task=showField" );
}


function showTab( $option ) {
	global $_CB_database, $mainframe, $my, $acl,$mosConfig_list_limit, $_CB_joomla_adminpath;

	if(!isset($mosConfig_list_limit) || !$mosConfig_list_limit) $limit = 10;
	else $limit = $mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$lastCBlist = $mainframe->getUserState( "view{$option}lastCBlist", null );
	if($lastCBlist=='showtab') {
		$limitstart	= $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
		$lastSearch = $mainframe->getUserState( "search{$option}", null );
		$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		if ($lastSearch != $search) {
			$limitstart = 0;
			$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		}
		$search = trim( strtolower( $search ) );
	} else {
		clearSearchBox();
		$search="";
		$limitstart = 0;
		$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		$mainframe->setUserState( "view{$option}lastCBlist", "showtab" );
	}

	$where = array();
	if (isset( $search ) && $search!= "") {
		$search  =	cbEscapeSQLsearch( trim( strtolower( cbGetEscaped($search))));
		$where[] =	"(a.title LIKE '%$search%')";
	}

	$where[]	 =	"a.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")";

	$_CB_database->setQuery( "SELECT COUNT(*)"
		. "\nFROM #__comprofiler_tabs AS a"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $_CB_database->loadResult();
	echo $_CB_database->getErrorMsg();
	if ($total <= $limitstart) $limitstart = 0;

	require_once( $_CB_joomla_adminpath . "/includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$_CB_database->setQuery( "SELECT a.*, p.name AS pluginname, p.published AS pluginpublished "
		. "\nFROM #__comprofiler_tabs AS a"
		. "\n LEFT JOIN #__comprofiler_plugin AS p ON p.id = a.pluginid"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
		. "\n ORDER BY position, ordering"
		. "\nLIMIT " . (int) $pageNav->limitstart . ", " . (int) $pageNav->limit
	);

	$rows = $_CB_database->loadObjectList();
	if ($_CB_database->getErrorNum()) {
		echo $_CB_database->stderr();
		return false;
	}

	HTML_comprofiler::showTabs( $rows, $pageNav, $search, $option );
	return true;
}

function editTab( $tid='0', $option='com_comprofiler' ) {
	global $_CB_database, $my, $acl;

	$row = new moscomprofilerTabs( $_CB_database );
	// load the row from the db table
	$row->load( (int) $tid );

	if ( $tid && ! in_array( $row->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
		echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
		exit;
	}
 	$lists = array();
	if($row->sys=='2') $lists['enabled'] = "Yes";
	else $lists['enabled'] = mosHTML::yesnoSelectList( 'enabled', 'class="inputbox" size="1"', $row->enabled );

	/*
	-------------------------
	!          head         !
	!-----------------------!
	!      !        !       !
	! left ! middle ! right !
	!      !        !       !
	!-----------------------!
	!                       !
	!        tabmain        !
	!                       !
	!-----------------------!
	!        underall       !
	-------------------------
	*/
	$position = array();
	$position[] = mosHTML::makeOption( 'cb_head', _UE_POS_CB_HEAD );
	$position[] = mosHTML::makeOption( 'cb_left', _UE_POS_CB_LEFT );
	$position[] = mosHTML::makeOption( 'cb_middle', _UE_POS_CB_MIDDLE );
	$position[] = mosHTML::makeOption( 'cb_right', _UE_POS_CB_RIGHT );
	$position[] = mosHTML::makeOption( 'cb_tabmain', _UE_POS_CB_MAIN );
	$position[] = mosHTML::makeOption( 'cb_underall', _UE_POS_CB_BOTTOM );
	if (!$row->position) $row->position = 'cb_tabmain';
	$lists['position'] = mosHTML::selectList( $position, 'position', 'class="inputbox" size="1"', 'value', 'text', $row->position );

	$displaytype = array();
	$displaytype[] = mosHTML::makeOption( 'tab', _UE_DISPLAY_TAB );
	$displaytype[] = mosHTML::makeOption( 'div', _UE_DISPLAY_DIV );
	$displaytype[] = mosHTML::makeOption( 'html', _UE_DISPLAY_HTML );
	$displaytype[] = mosHTML::makeOption( 'overlib', _UE_DISPLAY_OVERLIB );
	$displaytype[] = mosHTML::makeOption( 'overlibfix', _UE_DISPLAY_OVERLIBFIX );
	$displaytype[] = mosHTML::makeOption( 'overlibsticky', _UE_DISPLAY_OVERLIBSTICKY );
	$lists['displaytype'] = mosHTML::selectList( $displaytype, 'displaytype', 'class="inputbox" size="1"', 'value', 'text', $row->displaytype );

	if ($tid) {
		if ( $row->ordering > -10000 && $row->ordering < 10000 ) {
			// build the html select list for ordering
			$query = "SELECT ordering AS value, title AS text"
			. "\n FROM #__comprofiler_tabs"
			. "\n WHERE position='" . $_CB_database->getEscaped( $row->position ) . "'"
			. "\n AND enabled > 0"
			. "\n AND ordering > -10000"
			. "\n AND ordering < 10000"
			. "\n ORDER BY ordering"
			;
			$order = mosGetOrderingList( $query );
			$lists['ordering'] = mosHTML::selectList( $order, 'ordering', 'class="inputbox" size="1"', 'value', 'text', intval( $row->ordering ) );
		} else {
			$lists['ordering'] = '<input type="hidden" name="ordering" value="'. $row->ordering .'" />This plugin cannot be reordered';
		}
	} else {
		$row->ordering 				= 999;
		$row->ordering_register		= 10;
		$row->published 			= 1;
		$row->description 			= '';
		$row->useraccessgroupid		= -2;
		$lists['ordering']	= '<input type="hidden" name="ordering" value="'. $row->ordering
							.'" />New items default to the last place. Ordering can be changed after this item is saved.';
	}

	$gtree3=array();
    $gtree3[] = mosHTML::makeOption( -2 , '- Everybody -' );
    $gtree3[] = mosHTML::makeOption( -1, '- All Registered Users -' );
	$gtree3 = array_merge( $gtree3, $acl->get_group_children_tree( null, 'USERS', false ));
	
	$lists['useraccessgroup']=mosHTML::selectList( $gtree3, 'useraccessgroupid', 'size="4"', 'value', 'text', $row->useraccessgroupid );

	HTML_comprofiler::edittab( $row, $option, $lists, $tid );
}

function saveTab( $option ) {
	global $_CB_database, $my, $_POST, $ueConfig;

	if ( isset( $_POST['params'] ) ) {
	 	$_POST['params']	=	cbParamsEditorController::getRawParams( $_POST['params'] );
	} else {
		$_POST['params']	=	'';
	}

	if ( $_POST['tabid'] ) {
		$oldrow		=	new moscomprofilerTabs( $_CB_database );
		if ( $oldrow->load( (int) $_POST['tabid'] )
			&& 	( ! in_array( $oldrow->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) ) {
			echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
			exit;
		}
	}

	$row = new moscomprofilerTabs( $_CB_database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if ( ! $row->ordering_register ) {
		$row->ordering_register		=	10;
	}
	mosMakeHtmlSafe($row);
	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if ( ! $row->store( (int) $_POST['tabid'] ) ) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}

	$row->checkin();
	cbRedirect( "index2.php?option=$option&task=showTab", "Successfully Saved Tab: ". $row->title );
}

function removeTabs( $cid, $option ) {
	global $_CB_database, $acl, $ueConfig, $my;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new moscomprofilerTabs( $_CB_database );
		foreach ($cid as $id) {
				$obj->load( (int) $id );
				if ( ! in_array( $obj->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
					echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
					exit;
				}

				$_CB_database->setQuery("SELECT COUNT(*) FROM #__comprofiler_fields WHERE tabid=" . (int) $id);
				$onField = $_CB_database->loadResult();
				if($obj->sys > 0) {
					$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is a system tab. \n";
					$noDelete = 1;
				} 
				if( $obj->pluginid ) {
					$plugin	=	new moscomprofilerPlugin( $_CB_database );
					if ( $plugin->load( $obj->pluginid ) ) {
						$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is a tab belonging to an installed plugin. \n";
						$noDelete = 1;
					}
				} 
				if($onField>0) {
					$msg .= getLangDefinition($obj->title) ." is being referenced by an existing field and cannot be deleted!";
					$noDelete = 1;
				} 
				if($noDelete == 0) {
					$obj->delete( $id );
					$msg .= $obj->getError();
				}
				$noDelete = 0;
			}
		}

	cbRedirect( "index2.php?option=$option&task=showTab", $msg );
}


function orderTabs( $tid, $inc, $option ) {
	global $_CB_database, $my;

	$row = new moscomprofilerTabs( $_CB_database );
	$row->load( (int) $tid );

	if ( ! in_array( $row->useraccessgroupid, getChildGIDS( userGID( $my->id ) ) ) ) {
		echo "<script type=\"text/javascript\"> alert('Unauthorized Access'); window.history.go(-1);</script>\n";
		exit;
	}

	$row->move( $inc, "position='$row->position' AND ordering > -10000 AND ordering < 10000 "  );
	cbRedirect( "index2.php?option=$option&task=showTab" );
}

function showUsers( $option ) {
	global $_CB_database, $mainframe, $my, $acl,$mosConfig_list_limit,$_POST, $_CB_joomla_adminpath;
	
	if(!isset($mosConfig_list_limit) || !$mosConfig_list_limit) {
		$limit = 10;
	}
	else {
		$limit = $mosConfig_list_limit;
	}
	$filter_type	= $mainframe->getUserStateFromRequest( "filter_type{$option}", 'filter_type', 0 );
	$filter_status	= $mainframe->getUserStateFromRequest( "filter_status{$option}", 'filter_status', 0 );
	$filter_logged	= intval( $mainframe->getUserStateFromRequest( "filter_logged{$option}", 'filter_logged', 0 ) );
	$limit			= $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$lastCBlist		= $mainframe->getUserState( "view{$option}lastCBlist", null );
	if($lastCBlist=='showusers') {
		$limitstart	= $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
		$lastSearch = $mainframe->getUserState( "search{$option}", null );
		$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		if ($lastSearch != $search) {
			$limitstart = 0;
			$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		}
		$search = trim( strtolower( $search ) );
	} else {
		$filter_type	=	0;
		$filter_status	=	0;
		$filter_logged	=	0;
		clearSearchBox();
		$search="";
		$limitstart = 0;
		$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		$mainframe->setUserState( "view{$option}lastCBlist", "showusers" );
	}

	$where = array();
	if (isset( $search ) && $search!= "") {
		$where[] = "(a.username LIKE '%$search%' OR a.email LIKE '%$search%' OR a.name LIKE '%$search%')";
	}
	if ( $filter_type ) {
		if ( $filter_type == 'Public Frontend' ) {
			$where[] = "(a.usertype = 'Registered' OR a.usertype = 'Author' OR a.usertype = 'Editor'OR a.usertype = 'Publisher')";
		} else if ( $filter_type == 'Public Backend' ) {
			$where[] = "(a.usertype = 'Manager' OR a.usertype = 'Administrator' OR a.usertype = 'Super Administrator')";
		} else {
			$where[] = "a.usertype = " . $_CB_database->Quote( $filter_type );
		}
	}
	$userstates	=	array(	'Blocked'								=>	'a.block = 1',
							'Enabled'								=>	'a.block = 0',
							'Unconfirmed'							=>	'ue.confirmed = 0',
							'Confirmed'								=>	'ue.confirmed = 1',
							'Unapproved'							=>	'ue.approved = 0',
							'Disapproved'							=>	'ue.approved = 2',
							'Approved'								=>	'ue.approved = 1',
							'Banned'								=>	'ue.banned <> 0',
							'Blocked + Unconfirmed + Unapproved'	=>	'(a.block = 1 AND ue.confirmed = 0 AND ue.approved = 0)',
							'Enabled + Unconfirmed + Unapproved'	=>	'(a.block = 0 AND ue.confirmed = 0 AND ue.approved = 0)',
							'Blocked + Confirmed + Unapproved'		=>	'(a.block = 1 AND ue.confirmed = 1 AND ue.approved = 0)',
							'Enabled + Confirmed + Unapproved'		=>	'(a.block = 0 AND ue.confirmed = 1 AND ue.approved = 0)',
							'Blocked + Unconfirmed + Disapproved'	=>	'(a.block = 1 AND ue.confirmed = 0 AND ue.approved = 2)',
							'Enabled + Unconfirmed + Disapproved'	=>	'(a.block = 0 AND ue.confirmed = 0 AND ue.approved = 2)',
							'Blocked + Confirmed + Disapproved'		=>	'(a.block = 1 AND ue.confirmed = 1 AND ue.approved = 2)',
							'Enabled + Confirmed + Disapproved'		=>	'(a.block = 0 AND ue.confirmed = 1 AND ue.approved = 2)',
							'Blocked + Unconfirmed + Approved'		=>	'(a.block = 1 AND ue.confirmed = 0 AND ue.approved = 1)',
							'Enabled + Unconfirmed + Approved'		=>	'(a.block = 0 AND ue.confirmed = 0 AND ue.approved = 1)',
							'Blocked + Confirmed + Approved'		=>	'(a.block = 1 AND ue.confirmed = 1 AND ue.approved = 1)',
							'Enabled + Confirmed + Approved'		=>	'(a.block = 0 AND ue.confirmed = 1 AND ue.approved = 1)' );
	if ( $filter_status ) {
		$where[] = $userstates[$filter_status];
	}
	if ( $filter_logged == 1 ) {
		$where[] = "s.userid = a.id";
	} else if ($filter_logged == 2) {
		$where[] = "s.userid IS NULL";
	}

	// exclude any child group id's for this user
	//$acl->_debug = true;
	$pgids = $acl->get_group_children( userGID( $my->id ), 'ARO', 'RECURSE' );

	if (is_array( $pgids ) && count( $pgids ) > 0) {
		$where[] = "(a.gid NOT IN (" . implode( ',', $pgids ) . "))";
	}

	$query = "SELECT COUNT(a.id)"
	. "\n FROM #__users AS a"
	. "\n LEFT JOIN #__comprofiler AS ue ON a.id = ue.id";

	if ($filter_logged == 1 || $filter_logged == 2) {
		$query .= "\n INNER JOIN #__session AS s ON s.userid = a.id";
	}

	$query .= ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' )
	;
	$_CB_database->setQuery( $query );
	$total = $_CB_database->loadResult();
	echo $_CB_database->getErrorMsg();
	if ($total <= $limitstart) $limitstart = 0;

	require_once( $_CB_joomla_adminpath . "/includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	if (checkJversion() <= 0) {
		$query = "SELECT DISTINCT a.*, g.name AS groupname, ue.approved,ue.confirmed"
			. "\n FROM #__users AS a"
			. "\n LEFT JOIN #__comprofiler AS ue ON a.id = ue.id"
			. "\n INNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"	// map user to aro
			. "\n INNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.aro_id"	// map aro to group
			. "\n INNER JOIN #__core_acl_aro_groups AS g ON g.group_id = gm.group_id";
	} else {
		$query = "SELECT DISTINCT a.*, g.name AS groupname, ue.approved, ue.confirmed"
			. "\n FROM #__users AS a"
			. "\n LEFT JOIN #__comprofiler AS ue ON a.id = ue.id"
			. "\n INNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"	// map user to aro
			. "\n INNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.id"	// map aro to group
			. "\n INNER JOIN #__core_acl_aro_groups AS g ON g.id = gm.group_id";
	}
	if ($filter_logged == 1 || $filter_logged == 2) {
		$query .= "\n INNER JOIN #__session AS s ON s.userid = a.id";
	} else {
		// $query .= "\n LEFT JOIN #__session AS s ON s.userid = a.id";
	}
	$query .= "\n WHERE aro.section_value = 'users' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		. "\n LIMIT " . (int) $pageNav->limitstart . ", " . (int) $pageNav->limit
	;
	$_CB_database->setQuery( $query );
	$rows = $_CB_database->loadObjectList();
	if ($_CB_database->getErrorNum()) {
		echo $_CB_database->stderr();
		return false;
	}

	$template = 'SELECT COUNT(s.userid) FROM #__session AS s WHERE s.userid = ';
	$n = count( $rows );
	for ($i = 0; $i < $n; $i++) {
		$row = &$rows[$i];
		$query = $template . (int) $row->id;
		$_CB_database->setQuery( $query );
		$row->loggedin = $_CB_database->loadResult();
	}

	// get list of Groups for dropdown filter
	$query = "SELECT name AS value, name AS text"
	. "\n FROM #__core_acl_aro_groups"
	. "\n WHERE name != 'ROOT'"
	. "\n AND name != 'USERS'"
	;
	$types[] = mosHTML::makeOption( '0', '- Select Group -' );
	$_CB_database->setQuery( $query );
	$types = array_merge( $types, $_CB_database->loadObjectList() );
	$lists['type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_type" );

	$status[] = mosHTML::makeOption( 0, '- Select User Status - ');
	foreach ( $userstates as $k => $v ) {
		$status[] = mosHTML::makeOption( $k, $k );
	}
	$lists['status'] = mosHTML::selectList( $status, 'filter_status', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_status" );

	// get list of Log Status for dropdown filter
	$logged[] = mosHTML::makeOption( 0, '- Select Login State - ');
	$logged[] = mosHTML::makeOption( 1, 'Logged In');
	$lists['logged'] = mosHTML::selectList( $logged, 'filter_logged', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', "$filter_logged" );

	HTML_comprofiler::showUsers( $rows, $pageNav, stripslashes($search), $option, $lists );
	return true;
}

function editUser( $uid='0', $option='users' ) {
	global $_CB_database, $my, $acl,$ueConfig;

		$msg = checkCBpermissions( array($uid), "edit", true );
		if ($msg) {
			echo "<script type=\"text/javascript\"> alert('".$msg."'); window.history.go(-1);</script>\n";
			exit;
		}

		$_CB_database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id=" . (int) $uid);
		$users = $_CB_database->loadObjectList();
		if (count($users)>0) {
			$newCBuser = '0';
			$user = $users[0];
			$user->name		=	unHtmlspecialchars( $user->name );		// revert effect of mosMakeHtmlSafe on user save.
		} else {
			$newCBuser = '1';
			$_CB_database->setQuery( "SELECT * FROM #__users u WHERE u.id=" . (int) $uid);
			$users = $_CB_database->loadObjectList();
			if (count($users)>0) {
				$user = $users[0];
				$user->approved		=	'0';
				$user->confirmed	=	'1';
			} else {
				$user = new mosUser( $_CB_database );
				$user->approved		=	'1';
				$user->confirmed	=	'1';
				$user->sendEmail	=	'0';
			}
			$user->firstname = '';
			$user->middlename = '';
			$user->lastname = '';
			$_CB_database->setQuery( "SELECT f.* FROM #__comprofiler_fields f, #__comprofiler_tabs t"
			. "\n WHERE f.published=1 and f.tabid = t.tabid AND t.enabled=1" );
			$rowFields = $_CB_database->loadObjectList();
			for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
				$field=$rowFields[$i]->name;
				$value=$rowFields[$i]->default;
				if (!isset($user->$field)) {
					$user->$field=$value;
				}
			}
		}
		HTML_comprofiler::edituser( $user, $option, $uid, $newCBuser);
}

function saveUser( $option ) {
	global $_CB_database, $my, $acl;
	global $mosConfig_live_site,$_POST,$ueConfig,$_PLUGINS,$mosConfig_emailpass, $mosConfig_uniquemail;

	$myGid		=	userGID( $my->id );
	$userIdPosted = (int) cbGetParam($_POST, "id");
	if ( $userIdPosted != 0 ) {
		$msg	=	checkCBpermissions( array( $userIdPosted ), "save", in_array( $myGid, array( 24, 25 ) ) );
		if ($msg) {
			echo "<script type=\"text/javascript\"> alert('".$msg."'); window.history.go(-1);</script>\n";
			exit;
		}
	}

	$row = new mosUser( $_CB_database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->id = (int) $row->id;
	$row->gid = (int) $row->gid;
	$isNew = !$row->id;
	$pwd = '';
	if ($isNew) {
		// new user stuff
		if ($row->password == '') {
			$pwd = cbMakeRandomString();
		} else {
			$pwd = $row->password;
		}
		$row->password		=	cbHashPassword( $pwd );
		$row->registerDate	=	date("Y-m-d H:i:s");
	} else {
		$original			=	new mosUser( $_CB_database );
		$original->load( (int) $row->id );

		// existing user stuff
		if ($row->password == '') {
			// password set to null if empty
			$row->password	=	null;
		} else {
			$row->password	=	cbHashPassword( $row->password );
		}
		
		// if group has been changed and where original group was a Super Admin
		if ( $row->gid != $original->gid ) {
			if ( $original->gid == 25 ) {						
				// count number of active super admins
				$query = "SELECT COUNT( id )"
				. "\n FROM #__users"
				. "\n WHERE gid = 25"
				. "\n AND block = 0"
				;
				$_CB_database->setQuery( $query );
				$count = $_CB_database->loadResult();
				
				if ( $count <= 1 ) {
					// disallow change if only one Super Admin exists
					echo "<script> alert('You cannot change this users Group as it is the only active Super Administrator for your site'); window.history.go(-1); </script>\n";
					exit();
				}
			}

			$user_group = strtolower( $acl->get_group_name( $original->gid, 'ARO' ) );
			if (( $user_group == 'super administrator' && $myGid != 25) ) {
				// disallow change of super-Admin by non-super admin
				echo "<script> alert('You cannot change this users Group as you are not a Super Administrator for your site'); window.history.go(-1); </script>\n";
				exit();
			} elseif ( $row->id == $my->id && $myGid == 25) {
				// CB-specific: disallow change of own Super Admin group:
				echo "<script> alert('You cannot change your own Super Administrator status for your site'); window.history.go(-1); </script>\n";
				exit();
			} else if ( $myGid == 24 && $original->gid == 24 ) {
				// disallow change of super-Admin by non-super admin
				echo "<script> alert('You cannot change the Group of another Administrator as you are not a Super Administrator for your site'); window.history.go(-1); </script>\n";
				exit();
			}	// ensure user can't add group higher than themselves done below
		}
	}
	// Security check to avoid creating/editing user to higher level than himself: response to artf4529.
	if (!in_array($row->gid,getChildGIDS($myGid))) {
		echo "illegal attempt to set user at higher level than allowed !";
		exit();
	}
	
	if ( checkJversion() == 1 ) {
		$query = "SELECT name"
		. "\n FROM #__core_acl_aro_groups"
		. "\n WHERE id = " . (int) $row->gid
		;
	} else {
		$query = "SELECT name"
		. "\n FROM #__core_acl_aro_groups"
		. "\n WHERE group_id = " . (int) $row->gid
		;
	}
	$_CB_database->setQuery( $query );
	$usertype = $_CB_database->loadResult();
	$row->usertype = $usertype;

	if ( in_array( $ueConfig['name_style'], array( 2, 3 ) ) ) {
		$firstname = cbGetUnEscaped( isset( $_POST['firstname'] ) ? trim( $_POST['firstname'] ) : "");
		$lastname  = cbGetUnEscaped( isset( $_POST['lastname'] )  ? trim( $_POST['lastname']  ) : "");
	}
	switch ( $ueConfig['name_style'] ) {
		case 2:
			$row->name = $firstname . ' ' . $lastname;
		break;
		case 3:
			$middlename  = cbGetUnEscaped( isset( $_POST['middlename'] )  ? trim( $_POST['middlename']  ) : "");
			$row->name = $firstname . ' ' . ( $middlename ? ( $middlename . ' ' ) : '' ) . $lastname;
		break;
		default:
		break;
	}

	$row->username	= trim ( $row->username );
	$row->email		= trim ( $row->email );

	mosMakeHtmlSafe($row);
	
	// fix a joomla 1.0 bug preventing from saving profile without changing email if site switched from uniqueemails = 0 to = 1 and duplicates existed
	$original_uniqueemail	=	$mosConfig_uniquemail;
	if ( $mosConfig_uniquemail && isset( $original ) && ( $row->email == $original->email ) ) {
		$mosConfig_uniquemail	=	0;		
	}
	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if ( $original_uniqueemail && isset( $original ) && ( $row->email == $original->email ) ) {
		$mosConfig_uniquemail	=	$original_uniqueemail;
	}

	$_CB_database->setQuery( "SELECT f.* FROM #__comprofiler_fields f, #__comprofiler_tabs t"
	. "\n WHERE f.published=1 and f.tabid = t.tabid AND t.enabled=1" );
	$rowFields = $_CB_database->loadObjectList();

	$cbFields=new cbFields();
	$rowExtras = new moscomprofiler($_CB_database);
	for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
		$field=cbGetEscaped($rowFields[$i]->name);
		$value=null;
		if(isset($_POST[$rowFields[$i]->name])) {
			$value = $_POST[$rowFields[$i]->name];
		}
		$rowExtras->$field = $cbFields->prepareFieldDataSave( $rowFields[$i]->fieldid, $rowFields[$i]->type, $rowFields[$i]->name, $value );
	}

	$rowExtras->id				= $row->id;
	$rowExtras->user_id			= $row->id;
	$rowExtras->firstname		= cbGetUnEscaped((isset($_POST['firstname'])  ? trim( $_POST['firstname']  ) : ""));
	$rowExtras->middlename		= cbGetUnEscaped((isset($_POST['middlename']) ? trim( $_POST['middlename'] ) : ""));
	$rowExtras->lastname		= cbGetUnEscaped((isset($_POST['lastname'])   ? trim( $_POST['lastname']   ) : ""));
	$rowExtras->approved		= cbGetUnEscaped($_POST['approved']);
	$rowExtras->confirmed		= cbGetUnEscaped($_POST['confirmed']);

	$_PLUGINS->loadPluginGroup('user');

	$newCBuser = (isset($_POST['newCBuser'])) ? ($_POST['newCBuser']=="1") : true;
	
	// save user params
	$params = cbGetParam( $_POST, 'cbparams', null );
	//echo "params:".print_r($params);
	if($params != null) {
		if (is_array( $params )) {
			$txt = array();
			foreach ( $params as $k=>$v) {
				$txt[] = "$k=$v";
			}
			$row->params = implode( "\n", $txt );
		}
	}

	if($isNew || $newCBuser) {
		$_PLUGINS->trigger( 'onBeforeNewUser', array(&$row,&$rowExtras, false));
		if($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
			exit();
		}

		if ($isNew && !$row->store()) {		// first store to get new user id if id is not set (needed for savePluginTabs)
			// echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
			echo $row->getError();
			exit();
		}

		if ( $row->id == 0 ) {
			$_CB_database->setQuery("SELECT id FROM #__users WHERE username = '".cbGetEscaped($_POST['username'])."'");
			$row->id = $_CB_database->loadResult();	// this is only for mambo 4.5.0 backwards compatibility. 4.5.2.3 $row->store() updates id on insert
		}
		$rowExtras->id = $row->id;
		$rowExtras->user_id = $row->id;

		$userComplete =& moscomprofiler::dbObjectsMerge($row, $rowExtras);
		$tabs = new cbTabs( 0, 2, null, false );
		$tabs->savePluginTabs($userComplete, $_POST);		// this changes $row and $rowExtras by reference in $userComplete
		if($_PLUGINS->is_errors()) {
			if ( $isNew ) {
				$row->delete();
			}
			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$row->store()) {
			// echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
			echo $row->getError();
			exit();
		}

		// update the ACL
		if ( checkJversion() == 1 ) {
			$query	=	"SELECT id FROM #__core_acl_aro WHERE value=" . (int) $row->id;
		} else {
			$query	=	"SELECT aro_id FROM #__core_acl_aro WHERE value=" . (int) $row->id;			
		}
		$_CB_database->setQuery( $query );
		$aro_id = $_CB_database->loadResult();

		$_CB_database->setQuery( "UPDATE #__core_acl_groups_aro_map"
			. "\nSET group_id = " . (int) $row->gid
			. "\nWHERE aro_id = " . (int) $aro_id
		);
		if (!$_CB_database->query()) {
			die( $_CB_database->stderr() );
		}

		if(!$_CB_database->insertObject( '#__comprofiler', $rowExtras)) {		// escapes
			// echo "<script type=\"text/javascript\"> alert('store:".$_CB_database->stderr(true)."'); window.history.go(-2); </script>\n";
			echo $_CB_database->stderr(true);
			exit();
		}
		if ($isNew) {
			$row->password			= $pwd;		// set password in cleartext for onAfterNewUser trigger
			$userComplete->password = $pwd;		// set password in cleartext for email to new users
			$mosConfig_emailpass	= 1;		// set this global to 1 to force password to be sent to new users.
		}
		$_PLUGINS->trigger( 'onAfterNewUser', array($row, $rowExtras, false, true));
		if ( $row->block == 0 && $rowExtras->approved == 1 && $rowExtras->confirmed) {
			activateUser( $userComplete, 2, "NewUser", false, $isNew );
		}

	} else {
		
		$uid = $row->id;
		// get previous state for triggering the activation event:
		$_CB_database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id=" . (int) $uid);
		$previousState = $_CB_database->loadObjectList();
		if (count($previousState)>0) {
			$previousState = $previousState[0];
		}
		
		$rowExtras->id = $uid;
		$rowExtras->user_id = $uid;

		$_PLUGINS->trigger( 'onBeforeUpdateUser', array(&$row,&$rowExtras));
		if($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
			exit();
		}

		$userComplete =& moscomprofiler::dbObjectsMerge($row, $rowExtras);
		$tabs = new cbTabs( 0, 2, null, false );
		$tabs->savePluginTabs($userComplete, $_POST);		// this changes $row and $rowExtras by reference in $userComplete
		if($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$row->store()) {
			// echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
			echo $row->getError();
			exit();
		}
		
		// update the ACL
		if ( checkJversion() == 1 ) {
			$query	=	"SELECT id FROM #__core_acl_aro WHERE value=" . (int) $row->id;
		} else {
			$query	=	"SELECT aro_id FROM #__core_acl_aro WHERE value=" . (int) $row->id;			
		}
		$_CB_database->setQuery( $query );
		$aro_id = $_CB_database->loadResult();

		$_CB_database->setQuery( "UPDATE #__core_acl_groups_aro_map"
			. "\nSET group_id = " . (int) $row->gid
			. "\nWHERE aro_id = " . (int) $aro_id
		);
		if (!$_CB_database->query()) {
			die( $_CB_database->stderr() );
		}

		if( ! $_CB_database->updateObject( '#__comprofiler', $rowExtras,'id', false ) ) {	// escapes
			// echo "<script type=\"text/javascript\"> alert('store:".$_CB_database->stderr(true)."'); window.history.go(-2); </script>\n";
			echo $_CB_database->stderr(true);
			exit();
		}

		// updates current sessions of the user:
		$sessionGid		= 1;
		if ($acl->is_group_child_of( $row->usertype, 'Registered', 'ARO' ) || $acl->is_group_child_of( $row->usertype, 'Public Backend', 'ARO' )) {
			// Authors, Editors, Publishers and Super Administrators are part of the Special Group
			$sessionGid = 2;
		}
		$query = "UPDATE #__session "
		. "\n SET usertype = '" . $_CB_database->getEscaped( $row->usertype ) . "', "
		. " gid = " . $sessionGid
		. "\n WHERE userid = " . (int) $row->id;
		// TBD: here maybe jaclplus fields update if JACLplus installed....
		;
		$_CB_database->setQuery( $query );
		$_CB_database->query();

		$_PLUGINS->trigger( 'onAfterUpdateUser', array($row, $rowExtras, true));

		if (!(($previousState->approved == 1 || $previousState->approved == 2) && $previousState->confirmed) && ($rowExtras->approved == 1 && $rowExtras->confirmed)) {
			activateUser($userComplete, 2, "UpdateUser", false);
		}
	}

	$row->checkin();

	cbRedirect( "index2.php?option=$option&task=showusers", "Successfully Saved User: ". $row->username );
}

function deleteUsers( $cid, $inComprofilerOnly = false ) {
	global $_CB_database, $acl,$_PLUGINS, $ueConfig, $my;
	
	$msg = checkCBpermissions( $cid, "delete" );
	
	if (!$msg && is_array( $cid ) && count( $cid )) {
		$obj = new mosUser( $_CB_database );
		$obj2 = new moscomprofiler( $_CB_database );
		$tabs = new cbTabs( 0, 2);
		foreach ($cid as $id) {
			$obj->load( (int) $id );
			// check for a super admin ... can't delete them
/* done above
			$groups = $acl->get_object_groups( 'users', $id, 'ARO' );
			$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
			if ( $this_group == 'super administrator' && $my--->gid != 25 ) {
				$msg .= "You cannot delete a Super Administrator";
 			} else if ( $id == $my->id ){
 				$msg .= "You cannot delete Yourself!";
 			} else if ( ( $this_group == 'administrator' ) && ( $my--->gid == 24 ) ){
 				$msg .= "You cannot delete another `Administrator` only `Super Administrators` have this power";
			} else if (($obj->gid == $my--->gid && $my--->gid != 25) || !in_array($obj->gid,getChildGIDS($my--->gid))) {
				$msg .= "You cannot delete a `".$this_group."`. Only higher-level users have this power";
			} else
*/			{
				$count = 2;
				if ( $obj->gid == 25 ) {
					// count number of active super admins
					$query = "SELECT COUNT( id )"
					. "\n FROM #__users"
					. "\n WHERE gid = 25"
					. "\n AND block = 0"
					;
					$_CB_database->setQuery( $query );
					$count = $_CB_database->loadResult();
				}
				
				if ( $count <= 1 && $obj->gid == 25 ) {
				// cannot delete Super Admin where it is the only one that exists
					$msg .= "You cannot delete this Super Administrator as it is the only active Super Administrator for your site";
				} else {
					// delete user
					$result = cbDeleteUser( $id, null, $inComprofilerOnly );
					if ( $result === null ) {
						$msg .= "User not found";
					} elseif (is_string( $result ) && ( $result != "" ) ) {
						$msg .= $result;
					}
				}
			}
		}
	}
	return $msg;
}

function removeUsers( $cid, $option ) {

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}

	$msg = deleteUsers($cid);
	if ($msg) {
		echo "<script type=\"text/javascript\"> alert('".$msg."'); window.history.go(-1);</script>\n";
		exit;
	}

	cbRedirect( "index2.php?option=$option&task=showusers", $msg );
}

/**
* Blocks or Unblocks one or more user records
* @param array An array of unique category id numbers
* @param integer 0 if unblock, 1 if blocking
* @param string The current url option
*/
function changeUserBlock( $cid=null, $block=1, $option ) {
	$action = $block ? 'block' : 'unblock';
	changeUsersStatus( $cid, $action, $block, $option );
}
/**
* Approves or Rejects one or more user records
* @param array An array of unique category id numbers
* @param integer 0 if reject, 1 if approve
* @param string The current url option
*/
function approveUser( $cid=null, $approved=1, $option ) {
	$action = $approved ? 'Approve' : 'Reject';
	changeUsersStatus( $cid, $action, $approved, $option );
}

/**
 * Change users status
 *
 * @param array of int $cid
 * @param string       $action   ( Approve, Reject, block, unblock )
 * @param int          $actionValue
 * @param string       $option
 */
function changeUsersStatus( $cid=null, $action, $actionValue, $option ) {
    global $_CB_database, $my, $ueConfig,$mosConfig_emailpass,$_PLUGINS;
    
    if (count( $cid ) < 1) {
    	echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
    	exit;
    }
	$msg = checkCBpermissions( $cid, $action );
	if ($msg) {
		echo "<script type=\"text/javascript\"> alert('".$msg."'); window.history.go(-1);</script>\n";
		exit;
	}

	if (is_callable("mosArrayToInts")) {
		mosArrayToInts($cid);
	}
	$cids = implode( ',', $cid );

    $_PLUGINS->loadPluginGroup('user');
	$query = "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id IN ( " . $cids . " )";
	$_CB_database->setQuery($query);
	$users = $_CB_database->loadObjectList();
	
	foreach ( $users as $row ) {
		switch ( $action ) {
			case 'Approve':
			case 'Reject':
				if ($actionValue == 0) {
					$approved = 2;		// "rejected"
				} else {
					$approved = $actionValue;
				}
				$_PLUGINS->trigger( 'onBeforeUserApproval', array( $row, $approved ) );
				$_CB_database->setQuery( "UPDATE #__comprofiler SET approved=" . (int) $approved . " WHERE id = " . (int) $row->id );
				if ($_CB_database->query()) {
					if($approved==1) {
						if($mosConfig_emailpass == "1") {
							$pwd			=	cbMakeRandomString( 8, true );
							$row->password	=	$pwd;
							$pwd			=	cbHashPassword( $pwd );
							$_CB_database->setQuery( "UPDATE #__users SET password='" . $_CB_database->getEscaped($pwd) . "' WHERE id = " . (int) $row->id );
			    			$_CB_database->query();
							//createEmail($row, 'welcome', $ueConfig,null,1);
						} 
						$_PLUGINS->trigger('onAfterUserApproval',array($row,$approved,true));
						if ($row->approved == 0 && $approved == 1 && $row->confirmed == 1 ) {
							$row->approved = 1;
							activateUser($row, 2, "UserApproval", false);
						}
		
						//$tabs = new cbTabs( 0, 2);
						//$tabs->confirmRegistrationPluginTabs($row);
					}
				}
				break;
		
			case 'block':
			case 'unblock':
				$_PLUGINS->trigger( 'onBeforeUserBlocking', array( $row, $actionValue ) );
				$_CB_database->setQuery( "UPDATE #__users SET block = " . (int) $actionValue . " WHERE id = " . (int) $row->id );
				if ($_CB_database->query()) {
					// if action is to block a user, delete user acounts active sessions
					if ( $actionValue == 1 ) {
						$query = "DELETE FROM #__session"
					 	. "\n WHERE userid = " . (int) $row->id;
						$_CB_database->setQuery( $query );
						$_CB_database->query();
					}
				}
				break;
		
			default:
				echo "<script type=\"text/javascript\"> alert('unknown action ".$action."'); window.history.go(-1);</script>\n";
				exit;
				break;
		}
	}
    cbRedirect( "index2.php?option=$option&task=showusers" );
}

function cbIsEmail($email){
	$rBool=false;

	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
		$rBool=true;
	}
	return $rBool;
}
function showConfig( $option ) {
	global $_CB_database,$ueConfig,$acl,$my,$mainframe;
	global $_PLUGINS, $_CB_adminpath, $mainframe;

	$configfile = $_CB_adminpath."/ue_config.php";
	@chmod ($configfile, 0766);

	if (!is_callable(array("JFile","write")) || ($mainframe->getCfg('ftp_enable') != 1)) {
		$permission = is_writable($configfile);
		if (!$permission) {
			echo "<center><h1><font color=red>" . _UE_WARNING . "...</font></h1><BR>";
			echo "<b>" . _UE_YOUR_CONFIG_FILE . ": $configfile <font color=red>" . _UE_IS_NOT_WRITABLE . "</font></b><br />";
			echo "<b>" . _UE_NEED_TO_CHMOD_CONFIG . "</b></center><br /><br />";
		}
	}
	
	$lists = array();	
	// make a standard yes/no list
	$yesno = array();
	$yesno[] = mosHTML::makeOption( '0', _UE_NO );
	$yesno[] = mosHTML::makeOption( '1', _UE_YES );
	
	$admin_allowcbregistration = array();
	$admin_allowcbregistration[] = mosHTML::makeOption( '0', _UE_REG_ALLOWREG_SAME_AS_GLOBAL );
	$admin_allowcbregistration[] = mosHTML::makeOption( '1', _UE_REG_ALLOWREG_YES );
	
	$conNotifyTypes=array();
	$conNotifyTypes[] = mosHTML::makeOption( '0', _UE_NONE );
	$conNotifyTypes[] = mosHTML::makeOption( '1', 'Email' );
	$conNotifyTypes[] = mosHTML::makeOption( '2', 'PMS' );
	$conNotifyTypes[] = mosHTML::makeOption( '3', 'PMS+Email' );
	
	$dateformats = array();
	$dateformats[] = mosHTML::makeOption('Y/m/d','yyyy/mm/dd');
	$dateformats[] = mosHTML::makeOption('d/m/y','dd/mm/yy');
	$dateformats[] = mosHTML::makeOption('y/m/d','yy/mm/dd');
	$dateformats[] = mosHTML::makeOption('d/m/Y','dd/mm/yyyy');
	$dateformats[] = mosHTML::makeOption('m/d/y','mm/dd/yy');
	$dateformats[] = mosHTML::makeOption('m/d/Y','mm/dd/yyyy');
	$dateformats[] = mosHTML::makeOption('Y-m-d','yyyy-mm-dd');
	$dateformats[] = mosHTML::makeOption('d-m-y','dd-mm-yy');
	$dateformats[] = mosHTML::makeOption('y-m-d','yy-mm-dd');
	$dateformats[] = mosHTML::makeOption('d-m-Y','dd-mm-yyyy');
	$dateformats[] = mosHTML::makeOption('m-d-y','mm-dd-yy');
	$dateformats[] = mosHTML::makeOption('m-d-Y','mm-dd-yyyy');
	$dateformats[] = mosHTML::makeOption('Y.m.d','yyyy.mm.dd');
	$dateformats[] = mosHTML::makeOption('d.m.y','dd.mm.yy');
	$dateformats[] = mosHTML::makeOption('y.m.d','yy.mm.dd');
	$dateformats[] = mosHTML::makeOption('d.m.Y','dd.mm.yyyy');
	$dateformats[] = mosHTML::makeOption('m.d.y','mm.dd.yy');
	$dateformats[] = mosHTML::makeOption('m.d.Y','mm.dd.yyyy');
	
	$calendartypes = array();
	$calendartypes[] = mosHTML::makeOption('2', _UE_CALENDAR_TYPE_DROPDOWN_POPUP );
	$calendartypes[] = mosHTML::makeOption('1', _UE_CALENDAR_TYPE_POPUP );

	$nameformats = array();
	$nameformats[] = mosHTML::makeOption('1', _UE_REG_NAMEFORMAT_NAME_ONLY );
	$nameformats[] = mosHTML::makeOption('2', _UE_REG_NAMEFORMAT_NAME_USERNAME );
	$nameformats[] = mosHTML::makeOption('3', _UE_REG_NAMEFORMAT_USERNAME_ONLY );
	$nameformats[] = mosHTML::makeOption('4', _UE_REG_NAMEFORMAT_USERNAME_NAME );

	$imgToolBox = new imgToolBox();
	$imageLibs = $imgToolBox->getImageLibs();
	$conversiontype = array();
	if(array_key_exists('imagemagick',$imageLibs)|| ($ueConfig['conversiontype']=='1')) $conversiontype[] = mosHTML::makeOption('1','ImageMagick');
	if(array_key_exists('netpbm',$imageLibs)	 || ($ueConfig['conversiontype']=='2')) $conversiontype[] = mosHTML::makeOption('2','NetPBM');
	if(array_key_exists('gd1',$imageLibs['gd'])	 || ($ueConfig['conversiontype']=='3')) $conversiontype[] = mosHTML::makeOption('3','GD1 library');
	if(array_key_exists('gd2',$imageLibs['gd'])	 || ($ueConfig['conversiontype']=='4')) $conversiontype[] = mosHTML::makeOption('4','GD2 library');
	
	$namestyles = array();
	$namestyles[] = mosHTML::makeOption('1', _UE_REG_NAMEFORMAT_SINGLE_FIELD );
	$namestyles[] = mosHTML::makeOption('2', _UE_REG_NAMEFORMAT_TWO_FIELDS );
	$namestyles[] = mosHTML::makeOption('3', _UE_REG_NAMEFORMAT_THREE_FIELDS );
	
	$emailhandling = array();
	$emailhandling[] = mosHTML::makeOption('1', _UE_REG_EMAILDISPLAY_EMAIL_ONLY );
	$emailhandling[] = mosHTML::makeOption('2', _UE_REG_EMAILDISPLAY_EMAIL_W_MAILTO );
	$emailhandling[] = mosHTML::makeOption('3', _UE_REG_EMAILDISPLAY_EMAIL_W_FORM );
	$emailhandling[] = mosHTML::makeOption('4', _UE_REG_EMAILDISPLAY_EMAIL_NO );

	$emailreplyto = array();
	$emailreplyto[] = mosHTML::makeOption('1',_UE_A_FROM_USER );
	$emailreplyto[] = mosHTML::makeOption('2',_UE_A_FROM_ADMIN );

	$connectionDisplay = array();
	$connectionDisplay[] = mosHTML::makeOption( '0', _UE_PUBLIC );
	$connectionDisplay[] = mosHTML::makeOption( '1', _UE_PRIVATE );

	$noVersionCheck = array();
	$noVersionCheck[] = mosHTML::makeOption( '0', _UE_AUTOMATIC );
	$noVersionCheck[] = mosHTML::makeOption( '1', _UE_MANUAL );

	$userprofileEdits = array();
	$userprofileEdits[] = mosHTML::makeOption( '0', _UE_NO );
	$userprofileEdits[] = mosHTML::makeOption( '1', _UE_MODERATORS_AND_ABOVE );
	$userprofileEdits[] = mosHTML::makeOption( '24', _UE_ADMINS_AND_SUPERADMINS_ONLY );
	$userprofileEdits[] = mosHTML::makeOption( '25', _UE_SUPERADMINS_ONLY );

	// ensure user can't add group higher than themselves
	if ( checkJversion() <= 0 ) {
		$my_groups 	= $acl->get_object_groups( 'users', $my->id, 'ARO' );
	} else {
		$aro_id		= $acl->get_object_id( 'users', $my->id, 'ARO' );
		$my_groups 	= $acl->get_object_groups( $aro_id, 'ARO' );
	}
	//print_r($my_groups);

	if (is_array( $my_groups ) && count( $my_groups ) > 0) {
		$ex_groups = $acl->get_group_children( $my_groups[0], 'ARO', 'RECURSE' );
	} else {
		$ex_groups = array();
	}
	//print_r($ex_groups);
	$gtree = $acl->get_group_children_tree( null, 'USERS', false );
	// remove users 'above' me

	$i = 0;
	if (is_array($ex_groups)) {
		while ($i < count( $gtree )) {
			if (in_array( $gtree[$i]->value, $ex_groups )) {
				array_splice( $gtree, $i, 1 );
			} else {
				$i++;
			}
		}
	}
	$gtree2=array();
        $gtree2[] = mosHTML::makeOption( -2 , '- ' ._UE_GROUPS_EVERYBODY . ' -' );				// '- Everybody -'
        $gtree2[] = mosHTML::makeOption( -1, '- ' . _UE_GROUPS_ALL_REG_USERS . ' -' );			// '- All Registered Users -'
	$gtree2 = array_merge( $gtree2, $acl->get_group_children_tree( null, 'USERS', false ));


   	$lists['imageApproverGid'] = mosHTML::selectList( $gtree, 'cfg_imageApproverGid', 'size="4"', 'value', 'text', $ueConfig['imageApproverGid'] );

	$lists['allow_profileviewbyGID']=mosHTML::selectList( $gtree2, 'cfg_allow_profileviewbyGID', 'size="4"', 'value', 'text', $ueConfig['allow_profileviewbyGID'] );
	//$lists['allow_listviewbyGID']=mosHTML::selectList( $gtree2, 'cfg_allow_listviewbyGID', 'size="4"', 'value', 'text', $ueConfig['allow_listviewbyGID'] );
   // registered users only
  	$tempdir = array();
	//$templates=cbReadDirectory($mainframe->getCfg('absolute_path')."/components/com_comprofiler/plugin/templates");
	$_CB_database->setQuery("SELECT `name`,`folder` FROM `#__comprofiler_plugin` WHERE `type`='templates' AND `published`=1 ORDER BY ordering");
	//echo $_CB_database->getQuery();
	$templates=$_CB_database->loadObjectList();
	foreach ($templates AS $template) {
		$tempdir[]=mosHTML::makeOption( $template->folder , $template->name );
	}
	/*
	require($mainframe->getCfg('absolute_path').'/components/com_comprofiler/plugin/user/plug_yancintegration/yanc.php');
	$getNewslettersTab= new getNewslettersTab();
	$newslettersList = $getNewslettersTab->getNewslettersList();
	$newslettersRegList = array();
	if ($newslettersList !== false) {
		foreach ($newslettersList AS $nl) {
			$newslettersRegList[] = mosHTML::makeOption( $nl->id, $nl->list_name);
		}
	}
	*/
	$cbFielfs = & new cbFields();
	$badHtmlFilter = & $cbFielfs->getInputFilter( array (), array (), 1, 1 );
	$lists['_filteredbydefault']	=	implode( ', ', $badHtmlFilter->tagBlacklist );
	if ( ! isset( $ueConfig['html_filter_allowed_tags'] ) ) {
		$ueConfig['html_filter_allowed_tags']	=	'';
	}

	$lists['allow_email_display'] = mosHTML::selectList( $emailhandling, 'cfg_allow_email_display', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_email_display'] );
	
	$lists['allow_email_replyto'] = mosHTML::selectList( $emailreplyto, 'cfg_allow_email_replyto', 'class="inputbox" size="1"', 'value', 'text', (isset($ueConfig['allow_email_replyto']) ? $ueConfig['allow_email_replyto'] : '1') );
	
	$lists['name_format'] = mosHTML::selectList($nameformats, 'cfg_name_format','class="inputbox" size="1"', 'value', 'text', $ueConfig['name_format'] );
	
	$lists['name_style'] = mosHTML::selectList($namestyles, 'cfg_name_style','class="inputbox" size="1"', 'value', 'text', $ueConfig['name_style'] );
	
	$lists['date_format'] = mosHTML::selectList($dateformats, 'cfg_date_format','class="inputbox" size="1"', 'value', 'text', $ueConfig['date_format'] );
	$lists['calendar_type'] = mosHTML::selectList($calendartypes, 'cfg_calendar_type','class="inputbox" size="1"', 'value', 'text', ( isset( $ueConfig['calendar_type'] ) ? $ueConfig['calendar_type'] : '2' ) );
	
	$lists['usernameedit'] = mosHTML::selectList( $yesno, 'cfg_usernameedit', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['usernameedit'] );
	
	$lists['allow_profilelink'] = mosHTML::selectList( $yesno, 'cfg_allow_profilelink', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_profilelink'] );
	
	$lists['allow_email'] = mosHTML::selectList( $yesno, 'cfg_allow_email', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_email'] );
	$lists['allow_onlinestatus'] = mosHTML::selectList( $yesno, 'cfg_allow_onlinestatus', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_onlinestatus'] );
	$lists['allow_website'] = mosHTML::selectList( $yesno, 'cfg_allow_website', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_website'] );
	
	$lists['reg_enable_toc'] = mosHTML::selectList( $yesno, 'cfg_reg_enable_toc', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_enable_toc'] );
	
	$lists['admin_allowcbregistration'] = mosHTML::selectList( $admin_allowcbregistration, 'cfg_reg_admin_allowcbregistration', 'class="inputbox" size="1"', 'value', 'text', (isset($ueConfig['reg_admin_allowcbregistration']) ? $ueConfig['reg_admin_allowcbregistration'] : '0' ) );
	
	$lists['admin_approval'] = mosHTML::selectList( $yesno, 'cfg_reg_admin_approval', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_admin_approval'] );
	
	$lists['confirmation'] = mosHTML::selectList( $yesno, 'cfg_reg_confirmation', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_confirmation'] );

	$lists['reg_username_checker'] = mosHTML::selectList( $yesno, 'cfg_reg_username_checker', 'class="inputbox" size="1"', 'value', 'text', ( isset( $ueConfig['reg_username_checker'] ) ? $ueConfig['reg_username_checker'] : '0' ) );
	
	$lists['allowAvatar'] = mosHTML::selectList( $yesno, 'cfg_allowAvatar', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatar'] );
	
	$lists['allowAvatarUpload'] = mosHTML::selectList( $yesno, 'cfg_allowAvatarUpload', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatarUpload'] );
	
	$lists['allowAvatarGallery'] = mosHTML::selectList( $yesno, 'cfg_allowAvatarGallery', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatarGallery'] );
	
	$lists['avatarUploadApproval'] = mosHTML::selectList( $yesno, 'cfg_avatarUploadApproval', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['avatarUploadApproval'] );

	$lists['allowUserReports'] = mosHTML::selectList( $yesno, 'cfg_allowUserReports', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowUserReports'] );
	$lists['allowModeratorsUserEdit'] = mosHTML::selectList( $userprofileEdits, 'cfg_allowModeratorsUserEdit', 'class="inputbox" size="1"', 'value', 'text', isset($ueConfig['allowModeratorsUserEdit']) ? $ueConfig['allowModeratorsUserEdit'] : '0' );
	$lists['allowUserBanning'] = mosHTML::selectList( $yesno, 'cfg_allowUserBanning', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowUserBanning'] );
	$lists['adminrequiredfields'] = mosHTML::selectList( $yesno, 'cfg_adminrequiredfields', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['adminrequiredfields'] );
	$lists['moderatorEmail'] = mosHTML::selectList( $yesno, 'cfg_moderatorEmail', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['moderatorEmail'] );
	$lists['allowModUserApproval'] = mosHTML::selectList( $yesno, 'cfg_allowModUserApproval', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowModUserApproval'] );
	$lists['templatedir'] = mosHTML::selectList( $tempdir, 'cfg_templatedir', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['templatedir'] );
	$lists['nesttabs'] = mosHTML::selectList( $yesno, 'cfg_nesttabs', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['nesttabs'] );
	$lists['xhtmlComply'] = mosHTML::selectList( $yesno, 'cfg_xhtmlComply', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['xhtmlComply'] );
	$lists['conversiontype'] = mosHTML::selectList( $conversiontype, 'cfg_conversiontype', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['conversiontype'] );
	$lists['allowConnections'] = mosHTML::selectList( $yesno, 'cfg_allowConnections', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowConnections'] );
	$lists['useMutualConnections'] = mosHTML::selectList( $yesno, 'cfg_useMutualConnections', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['useMutualConnections'] );
	$lists['autoAddConnections'] = mosHTML::selectList( $yesno, 'cfg_autoAddConnections', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['autoAddConnections'] );
	$lists['conNotifyTypes'] = mosHTML::selectList( $conNotifyTypes, 'cfg_conNotifyType', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['conNotifyType'] );
	$lists['connectionDisplay'] = mosHTML::selectList( $connectionDisplay, 'cfg_connectionDisplay', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['connectionDisplay'] );
	$lists['connectionPath'] = mosHTML::selectList( $yesno, 'cfg_connectionPath', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['connectionPath'] );
	$lists['noVersionCheck'] = mosHTML::selectList( $noVersionCheck, 'cfg_noVersionCheck', 'class="inputbox" size="1"', 'value', 'text', isset($ueConfig['noVersionCheck']) ? $ueConfig['noVersionCheck'] : '0' );
	
	HTML_comprofiler::showConfig( $ueConfig, $lists, $option );
}

function saveConfig ( $option ) {
	global $_CB_adminpath;
	
	$configfile = $_CB_adminpath."/ue_config.php";
	
   //Add code to check if config file is writeable.
   if (!is_callable(array("JFile","write")) && !is_writable($configfile)) {
      @chmod ($configfile, 0766);
      if (!is_writable($configfile)) {
         cbRedirect("index2.php?option=$option", "FATAL ERROR: Config File Not writeable" );
      }
   }

   $txt = "<?php\n";
   foreach ($_POST as $k=>$v) {
   	  if (is_array($v)) $v = implode("|*|", $v);
      if (strpos( $k, 'cfg_' ) === 0) {
//BB this :
         if (!get_magic_quotes_gpc()) {
            $v = addslashes( $v );
         }
/* //BB should be: but isn't (and it's compensated for all over the place...
         if (get_magic_quotes_gpc()) {
            $v = stripslashes( $v );
         }
         $v = str_replace( array('\\',"'"), array('\\\\','\\\''), $v );
        then check for stripslashes all over the place incl. in configuration display and email of welcome messages

*/
		 $txt .= "\$ueConfig['".substr( $k, 4 )."']='$v';\n";
      }
   }
   $txt .= "?>";

   if (is_callable(array("JFile","write"))) {
		$result = JFile::write( $configfile, $txt );
   } else {
		$result = false;
		if ($fp = fopen( $configfile, "w")) {
			$result = fwrite($fp, $txt, strlen($txt));
			fclose ($fp);
		}
   }
   if ($result != false) {
      cbRedirect( "index2.php?option=$option&task=showconfig", "Configuration file saved" );
   } else {
      cbRedirect( "index2.php?option=$option", "FATAL ERROR: File could not be opened." );
   }
}

function requiredField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Make Required' : 'Make Non-required';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}

	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_fields SET required = " . (int) $flag . " WHERE fieldid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showField" );
}

function publishField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Publish' : 'UnPublish';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}

	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_fields SET published = " . (int) $flag . " WHERE fieldid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showField" );
}

function registrationField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Add to Registration' : 'Remove from Registration';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}

	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_fields SET registration = " . (int) $flag . " WHERE fieldid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showField" );
}

function listPublishedField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Publish' : 'UnPublish';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}

	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_lists SET published = " . (int) $flag . " WHERE listid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showLists" );
}
function tabPublishedField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Publish' : 'UnPublish';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}

	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_tabs SET enabled = " . (int) $flag . " WHERE tabid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showTab" );
}
function listDefaultField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Make Default' : 'Reset Default';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}
	
    $published = "";
	if($flag==1) {
		$published = ", published = 1";
	}
	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_lists SET `default` = 0");
	    	$_CB_database->query();
		$_CB_database->setQuery( "UPDATE #__comprofiler_lists SET `default` = " . (int) $flag . " $published WHERE listid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showLists" );
}

function profileField( $cid=null, $flag=1, $option ) {
    global $_CB_database, $my, $ueConfig;
    
	if (count( $cid ) < 1) {
   	    $action = $flag ? 'Add to Profile' : 'Remove from Profile';
	    echo "<script type=\"text/javascript\"> alert('Select an item to $action'); window.history.go(-1);</script>\n";
	    exit;
	}

	foreach ($cid AS $cids) {
		$_CB_database->setQuery( "UPDATE #__comprofiler_fields SET profile = " . (int) $flag . " WHERE fieldid = " . (int) $cids);
	    	$_CB_database->query();
		//print $_CB_database->getquery();
	}
    cbRedirect( "index2.php?option=$option&task=showField" );
}

function loadSampleData() {
    global $_CB_database, $my, $ueConfig;
	$sql="SELECT COUNT(*) FROM #__comprofiler_fields"
	."\n WHERE name IN ('website','location','occupation','interests','company','address','city','state','zipcode','country','phone','fax')";
	$_CB_database->setQuery($sql);
    	$fieldCount=$_CB_database->loadresult();

	IF($fieldCount < 1) {
		$sqlStatements = array();

		$sqlStatements[0]['query'] = "INSERT IGNORE INTO `#__comprofiler_tabs` (`tabid`, `title`, `position`, `ordering`, `sys`) "
			."\n VALUES (2, 'Additional Info', 'cb_tabmain', 1, 0)";
		$sqlStatements[0]['message'] = "<font color=green>Tab Added Successfully!</font><br />";

		$sqlStatements[1]['query'] = "ALTER TABLE `#__comprofiler` ADD `website` varchar(255) default NULL,"
			  ."\n ADD `location` varchar(255) default NULL,"
			  ."\n ADD `occupation` varchar(255) default NULL,"
			  ."\n ADD `interests` varchar(255) default NULL,"
			  ."\n ADD `company` varchar(255) default NULL,"
			  ."\n ADD `address` varchar(255) default NULL,"
			  ."\n ADD `city` varchar(255) default NULL,"
			  ."\n ADD `state` varchar(255) default NULL,"
			  ."\n ADD `zipcode` varchar(255) default NULL,"
			  ."\n ADD `country` varchar(255) default NULL,"
			  ."\n ADD `phone` varchar(255) default NULL,"
			  ."\n ADD `fax` varchar(255) default NULL";
		$sqlStatements[1]['message'] = "<font color=green>Schema Changes Added Successfully!</font><br />";

		$sqlStatements[2]['query'] = "INSERT IGNORE INTO `#__comprofiler_fields`  (`fieldid`, `name`, `table`, `title`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `calculated`, `sys`) "
			."\n VALUES (30, 'website', '#__comprofiler', '_UE_Website', 'webaddress', 0, 0, 0, 2, 1, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
			."\n (31, 'location', '#__comprofiler', '_UE_Location', 'text', 50, 25, 0, 2, 2, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
			."\n (32, 'occupation', '#__comprofiler', '_UE_Occupation', 'text', 0, 0, 0, 2, 3, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
			."\n (33, 'interests', '#__comprofiler', '_UE_Interests', 'text', 0, 0, 0, 2, 4, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
			."\n (34, 'company', '#__comprofiler', '_UE_Company', 'text', 0, 0, 0, 2, 5, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (35, 'city', '#__comprofiler', '_UE_City', 'text', 0, 0, 0, 2, 6, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (36, 'state', '#__comprofiler', '_UE_State', 'text', 10, 4, 0, 2, 7, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (37, 'zipcode', '#__comprofiler', '_UE_ZipCode', 'text', 0, 0, 0, 2, 8, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (38, 'country', '#__comprofiler', '_UE_Country', 'text', 0, 0, 0, 2, 9, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (40, 'address', '#__comprofiler', '_UE_Address', 'text', 0, 0, 0, 2, 10, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (43, 'phone', '#__comprofiler', '_UE_PHONE', 'text', 0, 0, 0, 2, 11, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
			."\n (44, 'fax', '#__comprofiler', '_UE_FAX', 'text', 0, 0, 0, 2, 12, 0, 0, NULL, NULL, 1, 1, 1, 0, 0)";
		$sqlStatements[2]['message'] = "<font color=green>Fields Added Successfully!</font><br />";

		$sqlStatements[3]['query'] = "INSERT INTO `#__comprofiler_lists` (`listid`, `title`, `description`, `published`, `default`, `usergroupids`, `sortfields`, `col1title`, `col1enabled`, `col1fields`, `col2title`, `col2enabled`, `col1captions`, `col2fields`, `col2captions`, `col3title`, `col3enabled`, `col3fields`, `col3captions`, `col4title`, `col4enabled`, `col4fields`, `col4captions`) "
					."\n VALUES (2, 'Members List', 'my Description', 1, 1, '29, 18, 19, 20, 21, 30, 23, 24, 25', '`username` ASC', 'Image', 1, '29', 'Username', 1, 0, '42', 0, 'Other', 1, '26|*|28|*|27', 1, '', 0, '', 0)";

		$sqlStatements[3]['message'] = "<font color=green>List Added Successfully!</font><br />"; 	
	
		foreach ($sqlStatements AS $sql) {
			$_CB_database->setQuery($sql['query']);
			if (!$_CB_database->query()) {
				print("<font color=red>SQL error" . $_CB_database->stderr(true)."</font><br />");
				return;
			} else {
				print $sql['message'];
			}
			//print $_CB_database->getquery();
		}
	} else {
		print "Sample Data is already loaded!";
	}
}

function syncUsers() {
    global $_CB_database, $my, $ueConfig;

    // 1. add missing comprofiler entries, guessing naming depending on CB's name style:
	switch ( $ueConfig['name_style'] ) {
		case 2:
			// firstname + lastname:
 			$sql = "INSERT IGNORE INTO #__comprofiler(id,user_id,lastname,firstname) "
 				  ." SELECT id,id, SUBSTRING_INDEX(name,' ',-1), "
 								 ."SUBSTRING( name, 1, length( name ) - length( SUBSTRING_INDEX( name, ' ', -1 ) ) -1 ) "
 				  ." FROM #__users";    		
		break;
		case 3:
			// firstname + middlename + lastname:
			$sql = "INSERT IGNORE INTO #__comprofiler(id,user_id,middlename,lastname,firstname) "
				 . " SELECT id,id,SUBSTRING( name, INSTR( name, ' ' ) +1,"
				 						  ." length( name ) - INSTR( name, ' ' ) - length( SUBSTRING_INDEX( name, ' ', -1 ) ) -1 ),"
				 		 ." SUBSTRING_INDEX(name,' ',-1),"
				 		 ." IF(INSTR(name,' '),SUBSTRING_INDEX( name, ' ', 1 ),'') "
				 . " FROM #__users";
    		break;
    	default:
 			// name only:
			$sql = "INSERT IGNORE INTO #__comprofiler(id,user_id) SELECT id,id FROM #__users";
   			break;
    }
	$_CB_database->setQuery($sql);
	if (!$_CB_database->query()) {
		print("<font color=red>SQL error" . $_CB_database->stderr(true)."</font><br />");
		return;
	}
	$affected = mysql_affected_rows();
	if ($affected) {
		print "<p><font color='orange'>Added ".$affected." new entries to Community Builder from users Table.</font></p>";
	}

	$sql = "UPDATE #__comprofiler SET `user_id`=`id`";
	$_CB_database->setQuery($sql);
	if (!$_CB_database->query()) {
		print("<font color=red>SQL error" . $_CB_database->stderr(true)."</font><br />");
		return;
	}
	$affected = mysql_affected_rows();
	if ($affected) {
		print "<p><font color='orange'>Fixed ".$affected." existing entries in Community Builder: fixed wrong user_id.</font></p>";
	}

	// 2. remove excessive comprofiler entries (e.g. if admin used mambo/joomla delete user function:
	$sql = "SELECT c.id FROM #__comprofiler c LEFT JOIN #__users u ON u.id = c.id WHERE u.id IS NULL";
	$_CB_database->setQuery($sql);
	$users = $_CB_database->loadResultArray();
	if (count($users)) {
		print "<p><font color='orange'>Removing ".count($users)." entries from Community Builder missing in users Table.</font></p>";
	}
	if ($_CB_database->getErrorNum()) {
		print("<font color=red>SQL error" . $_CB_database->stderr(true)."</font><br />");
		return;
	}
	$msg = deleteUsers($users, true);
	print "<p>".$msg."</p>";
	print "<font color=green>Joomla/Mambo User Table and Joomla/Mambo Community Builder User Table now in sync!</font>";
}

/**
* Fetch a result row as an associative array
*
* return array
*/
function _cb_prov_loadAssoc() {
	global $_CB_database;
	if (!($cur = $_CB_database->query())) {
		return null;
	}
	$ret = null;
	if ($array = mysql_fetch_array( $cur, MYSQL_ASSOC )) {
		$ret = $array;
	}
	mysql_free_result( $cur );
	return $ret;
}

function checkcbdb(){
	global $_CB_database, $mainframe, $ueConfig;
	
	echo "<div style='text-align:left;'><p>Checking Community Builder Datbase:</p>";
	
	// 1. check comprofiler_field_values table for bad rows
	$sql = "SELECT fieldvalueid,fieldid FROM #__comprofiler_field_values WHERE fieldid=0";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in Community Builder comprofiler_field_values have bad fieldid values.</font></p>";
   		foreach ($bad_rows as $bad_row) {
			if ( $bad_row->fieldvalueid == 0 ) {
				echo "<p><font color=red>ZERO fieldvalueid illegal: fieldvalueid=" . $bad_row->fieldvalueid . " fieldid=0</font></p>";
			} else {
				echo "<p><font color=red>fieldvalueid=" . $bad_row->fieldvalueid . " fieldid=0</font></p>";
			}
		}
		echo "<p><font color=red>This one can be fixed in SQL using a tool like phpMyAdmin.</font></p>";
	} else {
		echo "<p><font color=green>All Community Builder comprofiler_field_values table fieldid rows all match existing fields.</font></p>";
	}
	
	// 2.	check if comprofiler_field_values table has entries where corresponding fieldtype value in comprofiler_fields table 
	//		does not allow values
	$sql = "SELECT v.fieldvalueid, v.fieldid, f.name, f.type FROM #__comprofiler_field_values as v, #__comprofiler_fields as f WHERE v.fieldid = f.fieldid AND f.type NOT IN ('checkbox','multicheckbox','select','multiselect','radio')";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in Community Builder comprofiler_field_values link back to fields of wrong fieldtype.</font></p>";
		foreach ($bad_rows as $bad_row) {
			echo "<p><font color=red>fieldvalueid=" . $bad_row->fieldvalueid . " fieldtype=" . $bad_row->type ."</font></p>";
		}
		echo "<p><font color=red>This one can be fixed in SQL using a tool like phpMyAdmin.</font></p>";
	} else {
		echo "<p><font color=green>All Community Builder comprofiler_field_values table rows link to correct fieldtype fields in comprofiler_field table.</font></p>";
	}

	// 3.	check if comprofiler table is in sync with users table	
	$sql = "SELECT c.id FROM #__comprofiler c LEFT JOIN #__users u ON u.id = c.id WHERE u.id IS NULL";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in Community Builder comprofiler table without corresponding user table rows.</font></p>";
		foreach ($bad_rows as $bad_row) {
			echo "<p><font color=red>comprofiler id=" . $bad_row->id . " missing in user table" . ( ( $bad_row->id == 0 ) ? " This comprofiler entry with id 0 should be removed, as it's not allowed." : "" ) . "</font></p>";
		}
		echo "<p><font color=red>This one can be fixed using menu Components-&gt; Community Builder-&gt; tools and then click `Synchronize users`.</font></p>";
	} else {
		echo "<p><font color=green>All Community Builder comprofiler table rows have links to user table.</font></p>";
	}

	// 4.	check if users table is in sync with comprofiler table	
	$sql = "SELECT u.id FROM #__users u LEFT JOIN #__comprofiler c ON c.id = u.id WHERE c.id IS NULL";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in users table without corresponding comprofiler table rows.</font></p>";
		foreach ($bad_rows as $bad_row) {
			echo "<p><font color=red>users id=" . $bad_row->id . " missing in comprofiler table</font></p>";
		}
		echo "<p><font color=red>This one can be fixed using menu Components-&gt; Community Builder-&gt; tools and then click `Synchronize users`.</font></p>";
	} else {
		echo "<p><font color=green>All users table rows have links to comprofiler table.</font></p>";
	}
	
	// 5.	check if all cb defined fields have corresponding comprofiler columns
	$sql = "SELECT * FROM #__comprofiler LIMIT 1";
	$_CB_database->setQuery($sql);
	
	if ( ! method_exists( $_CB_database, "loadAssoc" ) ) {
		$all_comprofiler_fields_and_values = _cb_prov_loadAssoc();
	} else {
		$all_comprofiler_fields_and_values = $_CB_database->loadAssoc();
	}
	
	$all_comprofiler_fields = array();
	while ( list( $_cbfield, $_cbvalue ) = each( $all_comprofiler_fields_and_values ) ) {
		array_push( $all_comprofiler_fields, $_cbfield );
	}
 	
	$sql = "SELECT name FROM #__comprofiler_fields WHERE `name` != 'NA' AND `table` = '#__comprofiler'";
	$_CB_database->setQuery( $sql );
	$field_rows = $_CB_database->loadObjectList();
	$html_output = array();
	foreach ( $field_rows as $field_row ) {
		if ( ! in_array( $field_row->name, $all_comprofiler_fields ) ) {
				$html_output[] = "<p><font color=red> - Column " . $field_row->name . " is missing from comprofiler table.</font></p>";
		}
	}
	if ( count( $html_output ) > 0 ) {
		echo "<p><font color=red>There are " . count( $html_output ) . " column(s) missing in the comprofiler table, which are defined as fields (rows in comprofiler_fields):</font></p>";
		echo implode( $html_output );
		echo "<p><font color=red>This one can be fixed by deleting and recreating the field(s) using components -&gt; Community Builder -&gt; Field Management.<br />"
			. "Please additionally make sure that columns in comprofiler table <strong>are not also duplicated in users table</strong>.</font></p>";
	} else {
		echo "<p><font color=green>All Community Builder fields from comprofiler_fields are present as columns in the comprofiler table.</font></p>";
	}
	// 6.	check if users table has id=0 in it	
	$sql = "SELECT u.id FROM #__users u WHERE u.id = 0";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in users table with id=0.</font></p>";
		foreach ($bad_rows as $bad_row) {
			echo "<p><font color=red>users id=" . $bad_row->id . " is not allowed.</font></p>";
		}
		echo "<p><font color=red>This one can be fixed in SQL using a tool like phpMyAdmin. <strong><u>You also need to check in SQL if id is autoincremented.<u><strong></font></p>";
	} else {
		echo "<p><font color=green>users table has no zero id row.</font></p>";
	}
	// 7.	check if comprofiler table has id=0 in it	
	$sql = "SELECT c.id FROM #__comprofiler c WHERE c.id = 0";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in comprofiler table with id=0.</font></p>";
		foreach ($bad_rows as $bad_row) {
			echo "<p><font color=red>comprofiler id=" . $bad_row->id . " is not allowed.</font></p>";
		}
		echo "<p><font color=red>This one can be fixed using menu Components-&gt; Community Builder-&gt; tools and then click `Synchronize users` if users table has no such entry with id=0, otherwise in SQL using a tool like phpMyAdmin.</font></p>";
	} else {
		echo "<p><font color=green>comprofiler table has no zero id row.</font></p>";
	}
	// 8.	check if comprofiler table has user_id != id in it	
	$sql = "SELECT c.id, c.user_id FROM #__comprofiler c WHERE c.id <> c.user_id";
	$_CB_database->setQuery($sql);
	$bad_rows = $_CB_database->loadObjectList();
	if (count($bad_rows)!=0) {
		echo "<p><font color=red>Warning: ".count($bad_rows)." entries in comprofiler table with user_id <> id.</font></p>";
		foreach ($bad_rows as $bad_row) {
			echo "<p><font color=red>comprofiler id=" . $bad_row->id . " is different from user_id=" . $bad_row->user_id . ".</font></p>";
		}
		echo "<p><font color=red>This one can be fixed using menu Components-&gt; Community Builder-&gt; tools and then click `Synchronize users`.</font></p>";
	} else {
		echo "<p><font color=green>All rows in comprofiler table have user_id columns identical to id columns.</font></p>";
	}
	// 9. Check if images/comprofiler is writable:
	$folder = 'images/comprofiler/';
	if ( $ueConfig['allowAvatarUpload'] == 1 ) {
		echo "<p>Checking Community Builder folders:</p>";
		if ( ! is_writable( $mainframe->getCfg('absolute_path'). '/' . $folder ) ) {
			echo '<font color="red">Avatars and thumbnails folder: ' . $mainframe->getCfg('absolute_path') . '/' . $folder . ' is NOT writeable by the webserver.</font>';
		} else {
			echo '<font color="green">Avatars and thumbnails folder is Writeable.</font>';
		}
	}
	echo "<p>Test done. If all lines above are in green, test completed successfully. Otherwise, please take corrective measures proposed in red.</p></div>";
}

function loadTools() {
	HTML_comprofiler::showTools();
}

/**
* Compacts the ordering sequence of the selected records
* @param array of table key ids which need to get saved ($row[]->ordering contains old ordering and $_POST['order'] contains new ordering)
* @param object derived from comprofilerDBTable of corresponding class
* @param string Additional "WHERE" query to limit ordering to a particular subset of records
*/
function saveOrder( $cid, &$row, $conditionStatement ) {
	global $_CB_database,$_POST;

	$total		= count( $cid );
	$order 		= cbGetParam( $_POST, 'order', array(0) );
	$conditions = array();
	$cidsChanged	= array();

    // update ordering values
	for( $i=0; $i < $total; $i++ ) {
		$row->load( (int) $cid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
	        if (!$row->store( (int) $cid[$i])) {
	            echo "<script type=\"text/javascript\"> alert('saveOrder:".$_CB_database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	            exit();
	        } // if
	        $cidsChanged[] = $cid[$i];
	        // remember to updateOrder this group if multiple groups (conditionStatement gives the group)
	        if ($conditionStatement) {
	        	$condition=null;				// to make php checker happy: the next line defines $condition
	        	eval($conditionStatement);
	        	$found = false;
	        	foreach ( $conditions as $cond )
		        	if ($cond[1]==$condition) {
		        		$found = true;
		        		break;
		        	} // if
	        	if (!$found) $conditions[] = array($cid[$i], $condition);
	        }
		} // if
	} // for

	if ($conditionStatement) {
	// execute updateOrder for each group
	foreach ( $conditions as $cond ) {
		$row->load( (int) $cond[0] );
		$row->updateOrder( $cond[1], $cidsChanged );
	} // foreach
	} else if ($cidsChanged) {
		$row->load( (int) $cidsChanged[0] );
		$row->updateOrder( null, $cidsChanged );
	}
	return 'New ordering saved';
} // saveOrder

function saveFieldOrder( &$cid ) {
	global $_CB_database;
	$row = new moscomprofilerFields( $_CB_database );
	$msg = saveOrder( $cid, $row, "\$condition = \"tabid='\$row->tabid'\";" );
	cbRedirect( 'index2.php?option=com_comprofiler&task=showField', $msg );
} // saveFieldOrder

function saveTabOrder( &$cid ) {
	global $_CB_database;
	$row 		= new moscomprofilerTabs( $_CB_database );
	$msg = saveOrder( $cid, $row, "\$condition = \"position='\$row->position' AND ordering > -10000 AND ordering < 10000 \";" );
	cbRedirect( 'index2.php?option=com_comprofiler&task=showTab', $msg );
} // saveTabOrder saveOrder

function saveListOrder( &$cid ) {
	global $_CB_database;
	$row 		= new moscomprofilerLists( $_CB_database );
	$msg = saveOrder( $cid, $row, null );
	cbRedirect( 'index2.php?option=com_comprofiler&task=showLists', $msg );
} // saveListOrder saveOrder




//plugin
function viewPlugins( $option ) {
	global $_CB_database, $mainframe, $mosConfig_list_limit, $_CB_joomla_adminpath;

	if(!isset($mosConfig_list_limit) || !$mosConfig_list_limit) $limit = 10;
	else $limit = $mosConfig_list_limit;
	$limit 			= $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$lastCBlist = $mainframe->getUserState( "view{$option}lastCBlist", null );
	if ($lastCBlist == 'showplugins') {
		$limitstart 	= $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
		$lastSearch = $mainframe->getUserState( "search{$option}", null );
		$search		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		if ($lastSearch != $search) {
			$limitstart = 0;
			$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		}
		$search = trim( strtolower( $search ) );
		$filter_type	= $mainframe->getUserStateFromRequest( "filter_type{$option}", 'filter_type', "0" );
	} else {
		clearSearchBox();
		$search="";
		$limitstart = 0;
		$mainframe->setUserState( "view{$option}limitstart", $limitstart );
		$mainframe->setUserState( "view{$option}lastCBlist", "showplugins" );
		$filter_type = "0";
		$mainframe->setUserState( "filter_type{$option}", $filter_type );
	}
	$where=array();
	
	// used by filter
	if ( $filter_type ) {
		$where[] = "m.type = '$filter_type'";
	}
	if ( $search ) {
		$search = cbEscapeSQLsearch( trim( strtolower( cbGetEscaped($search))));
		$where[] = "LOWER( m.name ) LIKE '%$search%'";
	}

	// get the total number of records
	$query = "SELECT COUNT(*) FROM #__comprofiler_plugin AS m ". ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' );
	$_CB_database->setQuery( $query );
	$total = $_CB_database->loadResult();
	if ($total <= $limitstart) $limitstart = 0;

	require_once( $_CB_joomla_adminpath . "/includes/pageNavigation.php" );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$query = "SELECT m.*, u.name AS editor, g.name AS groupname"
	. "\n FROM #__comprofiler_plugin AS m"
	. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
	. "\n LEFT JOIN #__groups AS g ON g.id = m.access"
	. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' )
	. "\n GROUP BY m.id"
	. "\n ORDER BY m.type ASC, m.ordering ASC, m.name ASC"
	. "\n LIMIT " . (int) $pageNav->limitstart . ", " . (int) $pageNav->limit
	;
	$_CB_database->setQuery( $query );
	$rows = $_CB_database->loadObjectList();
	if ($_CB_database->getErrorNum()) {
		echo $_CB_database->stderr();
		return false;
	}

	// get list of Positions for dropdown filter
	$query = "SELECT type AS value, type AS text"
	. "\n FROM #__comprofiler_plugin"
	. "\n GROUP BY type"
	. "\n ORDER BY type"
	;
	$types[] = mosHTML::makeOption( '0', (!defined('_SEL_TYPE')) ? '- Select Type -' : _SEL_TYPE );		// Mambo 4.5.1 Compatibility
	$_CB_database->setQuery( $query );
	$types = array_merge( $types, $_CB_database->loadObjectList() );
	$lists['type']	= mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $filter_type );

	HTML_comprofiler::showPlugins( $rows, $pageNav, $option, $lists, $search );
	return true;
}

/**
* Saves the CB plugin after an edit form submit
*/
function savePlugin( $option, $task ) {
	global $_CB_database, $mainframe, $_PLUGINS;
	if ( $task == 'showPlugins' ) {
		cbRedirect( 'index2.php?option=' . $option . '&task=showPlugins');
		return;
	}
	
	$action = cbGetParam( $_REQUEST, 'action' );
	
	if ( ! $action ) {
		savePluginParams( $option, $task );
	} else {
		$uid	= cbGetParam( $_REQUEST, 'cid' );
		$row 	= new moscomprofilerPlugin($_CB_database);
		if ( $uid ) {
			$row->load( (int) $uid );
		}

		// get params values
		if ($row->type !== "language") {
			$_PLUGINS->loadPluginGroup($row->type,array($row->id), 0);
		}
		// xml file for plugin
		$element	=&	_loadPluginXML( $row, 'action', $action );

		$_REQUEST['task'] = 'editPlugin';		// so that the actionPath matches
		$params =& new cbParamsBase( $row->params );
		editPluginView( $row, $option, 'editPlugin', $uid, $action, $element, $task, $params );
	}
}
	
/**
* Saves the CB plugin params after an edit form submit
*/
function savePluginParams( $option, $task ) {
	global $_CB_database, $_POST;
	
 	$_POST['params'] = cbParamsEditorController::getRawParams( $_POST['params'] );

	$row = new moscomprofilerPlugin( $_CB_database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();

	$row->updateOrder( "type='".$_CB_database->getEscaped($row->type)."' AND ordering > -10000 AND ordering < 10000 " );

	switch ( $task ) {
		case 'applyPlugin':
			$msg = 'Successfully Saved changes to Plugin: '. $row->name;
			cbRedirect( 'index2.php?option='. $option .'&task=editPlugin&cid='. $row->id, $msg );

		case 'savePlugin':
		default:
			$msg = 'Successfully Saved Plugin: '. $row->name;
			cbRedirect( 'index2.php?option='. $option .'&task=showPlugins' , $msg );
			break;
	}
}

/**
 * xml file for plugin
 *
 * @param  comprofilerPlugin  $row
 * @param  string             $actionType
 * @param  string             $action
 * @return CBSimpleXMLElement
 */
function & _loadPluginXML( &$row, $actionType, $action ) {
	global $mainframe, $_PLUGINS;

	$element = null;
	$xmlString	=	null;
	
	// security sanitization to disable use of `/`, `\\` and `:` in $action variable
	$unsecureChars		=	array( '/', '\\', ':', ';', '{', '}', '(', ')', "\"", "'", '.', ',', "\0", ' ', "\t", "\n", "\r", "\x0B" );
	$classname			=	'CBplug_' . strtolower( substr( str_replace( $unsecureChars, '', $row->element ), 0, 32 ) );
	$action_cleaned		=				strtolower( substr( str_replace( $unsecureChars, '', $action ),		  0, 32 ) );
	
	if ( class_exists( $classname ) && is_callable( array( $classname, 'loadAdmin' ) ) ) {
		$array			=	array( );
		$_PLUGINS->call( $row->id, 'loadAdmin', $classname, $array, null, true );

		if ( is_callable( array( $classname, 'getXml' ) ) ) {
			// $xmlString	=	$pluginClass->getXml( 'action', $action_cleaned );
			$array		=	array( $actionType, $action_cleaned );
			$xmlString	=	$_PLUGINS->call( $row->id, 'getXml', $classname, $array, null, true );
		}
	}
	if ( ! $xmlString && $action_cleaned ) {
		$xmlfile = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' .$row->type . '/'.$row->folder . '/xml/edit.' . $actionType . '.' . $action_cleaned .'.xml';
		if ( file_exists( $xmlfile ) ) {
			$xmlString = trim( file_get_contents( $xmlfile ) );
		}
	}
	if ( ! $xmlString ) {
		$xmlfile = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' .$row->type . '/'.$row->folder . '/xml/edit.plugin.xml';
		if ( file_exists( $xmlfile ) ) {
			$xmlString = trim( file_get_contents( $xmlfile ) );
		}
	}
	if ( ! $xmlString ) {
		$xmlfile = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' .$row->type . '/'.$row->folder . '/' . $row->element .'.xml';
		if ( file_exists( $xmlfile ) ) {
			$xmlString = trim( file_get_contents( $xmlfile ) );
		}
	}
	if ( ! $xmlString ) {
		$row->description = '<b><font style="color:red;">Plugin not installed</font></b>';
	} else {
		//TBD if ( cbStartOfStringMatch( $xmlString, '@import ') ...

		cbimport('cb.xml.simplexml');
		$element =& new CBSimpleXMLElement( $xmlString );
	}
	return $element;
}
/**
* Compiles information to add or edit a plugin
* @param string The current GET/POST option
* @param integer The unique id of the record to edit
*/
function editPlugin( $option, $task, $uid) {
	global $_CB_database, $my, $mainframe, $_PLUGINS, $_POST;
	
	$action	= cbGetParam( $_REQUEST, 'action', null );

	if ( ! $uid ) {
		$uid = cbGetParam( $_POST, 'id' );
	}

	$row 	= new moscomprofilerPlugin($_CB_database);
	if ( $uid ) {
		// load the row from the db table
		$row->load( (int) $uid );
	}
	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		echo "<script type=\"text/javascript\">alert('The plugin $row->name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</script>\n";
		exit(0);
	}

	// get params values
	if ( $row->type !== "language" && $row->id ) {
		$_PLUGINS->loadPluginGroup($row->type,array($row->id), 0);
	}

	// xml file for plugin
	$element = null;
	if ($uid) {
		$element	=&	_loadPluginXML( $row, 'action', $action );
	}

	if ( $action === null ) {
		$adminActionsModel	=&	$element->getChildByNameAttr( 'actions', 'ui', 'admin' );
		if ( $adminActionsModel ) {
			$defaultAction	=&	$adminActionsModel->getChildByNameAttr( 'action', 'name', 'default' );
			$actionRequest	=	$defaultAction->attributes( 'request' );
			$actionAction	=	$defaultAction->attributes( 'action' );
			if ( ( $actionRequest === '' ) && ( $actionRequest === '' ) ) {
				$action = '';
			}
		}
	}
	$description			=&	$element->getChildByNameAttributes( 'description' );
	if ( $description ) {
		$row->description	=	$description->data();
	} else {
		$row->description	=	'-';
	}
	if ( $action === null ) {
		
		$params =& new cbParamsEditorController( $row->params, $element, $element, $row );
		$options = array( 'option' => $option, 'task' => $task, 'pluginid' => $uid, 'tabid' => null );
		$params->setOptions( $options );
		editPluginSettingsParams( $row, $option, $task, $uid, $element, $params, $options );
		
	} else {
		$params =& new cbParamsBase( $row->params );
		editPluginView( $row, $option, $task, $uid, $action, $element, 'editPlugin', $params );
		
	}
}

function editPluginSettingsParams( &$row, $option, $task, $uid, &$element, &$params, &$options ) {
	global $_CB_database, $my, $mainframe;

	$lists 	= array();

	// get list of groups
	if ($row->access == 99 || $row->client_id == 1) {
		$lists['access'] = 'Administrator<input type="hidden" name="access" value="99" />';
	} else {
		// build the html select list for the group access
		if (is_callable(array("mosAdminMenus","Access"))) {
			$lists['access'] 		= mosAdminMenus::Access( $row );
		} else {
			/* Mambo 4.5.0 support: */
			$_CB_database->setQuery( 'SELECT id AS value, name AS text FROM #__groups ORDER BY id' );
			$lists['access'] = mosHTML::selectList( $_CB_database->loadObjectList(), 'access', 'class="inputbox" size="3"', 'value', 'text', intval( $row->access ) );
		}
	}

	if ($uid) {
		$row->checkout( $my->id );

		if ( $row->ordering > -10000 && $row->ordering < 10000 ) {
			// build the html select list for ordering
			$query = "SELECT ordering AS value, name AS text"
			. "\n FROM #__comprofiler_plugin"
			. "\n WHERE type='" . $_CB_database->getEscaped( $row->type ) . "'"
			. "\n AND published > 0"
			. "\n AND ordering > -10000"
			. "\n AND ordering < 10000"
			. "\n ORDER BY ordering"
			;
			$order = mosGetOrderingList( $query );
			$lists['ordering'] = mosHTML::selectList( $order, 'ordering', 'class="inputbox" size="1"', 'value', 'text', intval( $row->ordering ) );
		} else {
			$lists['ordering'] = '<input type="hidden" name="ordering" value="'. $row->ordering .'" />This plugin cannot be reordered';
		}
		$lists['type'] = '<input type="hidden" name="type" value="'. $row->type .'" />'. $row->type;

		if ($element && $element->name() == 'cbinstall' && $element->attributes( 'type' ) == 'plugin' ) {
			$description =& $element->getElementByPath( 'description' );
			$row->description = ( $description ) ? trim( $description->data() ) : '';
		}

	} else {
		$row->folder 		= '';
		$row->ordering 		= 999;
		$row->published 	= 1;
		$row->description 	= '';

		$folders = mosReadDirectory( $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' );
		$folders2 = array();
		foreach ($folders as $folder) {
		    if (is_dir( $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' . $folder ) && ( $folder <> 'CVS' ) ) {
		        $folders2[] = mosHTML::makeOption( $folder );
			}
		}
		$lists['type'] = mosHTML::selectList( $folders2, 'type', 'class="inputbox" size="1"', 'value', 'text', null );
		$lists['ordering'] = '<input type="hidden" name="ordering" value="'. $row->ordering .'" />New items default to the last place. Ordering can be changed after this item is saved.';
	}

	$Yesoptions = array();
	$Yesoptions[] = mosHTML::makeOption( '1', _CMN_YES );
	if ($row->type == "language") {
		$row->published = '1';
	} else {
		$Yesoptions[] = mosHTML::makeOption( '0', _CMN_NO );
	}
	if (is_callable(array("mosHTML","radioList"))) {			// mambo 4.5.0 compatibility:
		$lists['published'] = mosHTML::radioList( $Yesoptions, 'published', 'class="inputbox"', $row->published );
	} else {
		$lists['published'] = mosHTML::selectList( $Yesoptions, 'published', 'class="inputbox"', 'value', 'text', $row->published );
	}

	HTML_comprofiler::editPlugin( $row, $lists, $params, $options );
}

function editPluginView( &$row, $option, $task, $uid, $action, &$element, $mode, &$pluginParams ) {
	global $_CB_database;

		if ( ! $row->id ) {
		echo 'Plugin id not found.';
		return;
	}
	if ( ! $element ) {
		echo 'No plugin XML found.';
		return;
	}

	$adminHandlerModel	=& $element->getChildByNameAttr( 'handler', 'ui', 'admin' );
	if ( ! $adminHandlerModel ) {
		echo 'No admin handler defined in XML';
		return;
	}
	$class	=	$adminHandlerModel->attributes( 'class' );
	if ( ! class_exists( $class ) ) {
		echo 'Admin handler class ' . $class . ' does not exist.';
		return;
	}
	
	$handler	=&	new $class( $_CB_database );
	return $handler->editPluginView( $row, $option, $task, $uid, $action, $element, $mode, $pluginParams );
}

/**
* Compiles information to add or edit a plugin
* @param string The current GET/POST option
* @param integer The unique id of the record to edit
*/
function pluginMenu( $option, $uid) {
	global $_CB_database, $my, $mainframe;
	
	$row 	= new moscomprofilerPlugin($_CB_database);

	// load the row from the db table
	$row->load( (int) $uid );

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		echo "<script type=\"text/javascript\">alert('The plugin $row->name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</script>\n";
		exit(0);
	}
	$basepath = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' . $row->type . '/'.$row->folder.'/';
	$phpfile = $basepath . "admin." . $row->element . '.php';

	// see if there is an xml install file, must be same name as element
	if (file_exists( $phpfile )) {
		$menu = cbGetParam( $_REQUEST, 'menu' );

		$element	=&	_loadPluginXML( $row, 'menu', $menu );		// xml file for plugin

		$params =& new cbParamsEditorController( $row->params, $element, $element, $row );

		require_once( $phpfile );
		$classname = $row->element . "Admin";
		$adminClass = new $classname();
		echo $adminClass->menu( $row, $menu, $params );		
	} else {
		echo "<script type=\"text/javascript\">alert('The plugin $row->name has no administrator file $phpfile'); document.location.href='index2.php?option=$option'</script>\n";
		exit(0);
	}
}

/**
* Deletes one or more plugins
*
* Also deletes associated entries in the #__comprofiler_plugin table.
* @param array An array of unique category id numbers
*/
function removePlugin( &$cid, $option ) {
	global $_CB_database, $my;

	if (count( $cid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('Select a plugin to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$installer = new cbInstallerPlugin();
	foreach($cid AS $id) {
		$ret=$installer->uninstall($id,$option);
	}
	
	HTML_comprofiler::showInstallMessage( $installer->getError(), 'Uninstall Plugin - '.($ret ? 'Success' : 'Failed'),
	$installer->returnTo( $option, 'showPlugins' ) );
}

/**
* Publishes or Unpublishes one or more plugins
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
*/
function publishPlugin( $cid=null, $publish=1, $option ) {
	global $_CB_database, $my;

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script type=\"text/javascript\"> alert('Select a plugin to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	if (is_callable("mosArrayToInts")) {
		mosArrayToInts($cid);
	}
	$cids = implode( ',', $cid );

	$query = "UPDATE #__comprofiler_plugin SET published = " . (int) $publish
	. "\n WHERE id IN ($cids)"
	. "\n AND ((checked_out = 0) OR (checked_out = " . (int) $my->id . "))"
	;
	$_CB_database->setQuery( $query );
	if (!$_CB_database->query()) {
		echo "<script type=\"text/javascript\"> alert('".$_CB_database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new moscomprofilerPlugin( $_CB_database );
		$row->checkin( $cid[0] );
	}

	cbRedirect( 'index2.php?option='. $option .'&task=showPlugins'  );
}

/**
* Cancels an edit operation
*/
function cancelPlugin( $option) {
	global $_CB_database, $_POST;

	$row = new moscomprofilerPlugin( $_CB_database );
	$row->bind( $_POST );
	$row->checkin();

	cbRedirect( 'index2.php?option='. $option .'&task=showPlugins' );
}

function cancelPluginAction( $option) {
	global $_POST;

	$pluginId	=	(int) cbGetParam( $_POST, 'cid' );
	if ( $pluginId ) {
		cbRedirect( 'index2.php?option='. $option .'&task=editPlugin&cid=' . $pluginId );
	} else {
		cbRedirect( 'index2.php?option='. $option .'&task=showPlugins' );
	}
}

/**
* Moves the order of a record
* @param integer The unique id of record
* @param integer The increment to reorder by
*/
function orderPlugin( $uid, $inc, $option ) {
	global $_CB_database;

	$row = new moscomprofilerPlugin( $_CB_database );
	$row->load( (int) $uid );
	$row->move( $inc, "type='$row->type' AND ordering > -10000 AND ordering < 10000 "  );

	cbRedirect( 'index2.php?option='. $option .'&task=showPlugins' );
}

/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function accessMenu( $uid, $access, $option ) {
	global $_CB_database;

	switch ( $access ) {
		case 'accesspublic':
			$access = 0;
			break;

		case 'accessregistered':
			$access = 1;
			break;

		case 'accessspecial':
			$access = 2;
			break;
	}

	$row = new moscomprofilerPlugin( $_CB_database );
	$row->load( (int) $uid );
	$row->access = $access;

	if ( !$row->check() ) {
		return $row->getError();
	}
	if ( !$row->store() ) {
		return $row->getError();
	}

	cbRedirect( 'index2.php?option='. $option .'&task=showPlugins' );
	return null;
}

function savePluginOrder( &$cid ) {
	global $_CB_database;
	$row = new moscomprofilerPlugin( $_CB_database );
	$msg = saveOrder( $cid, $row, "\$condition = \"type='\$row->type' AND ordering > -10000 AND ordering < 10000 \";" );
	cbRedirect( 'index2.php?option=com_comprofiler&task=showPlugins', $msg );
} // savePluginOrder

function installPluginUpload() {
	global $mainframe,$_FILES;
	
	$option="com_comprofiler";
	$task="showPlugins";
	$client=0;
	//echo "installPluginUpload";
	
	$installer = new cbInstallerPlugin();

	// Check if file uploads are enabled
	if (!(bool)ini_get('file_uploads')) {
		HTML_comprofiler::showInstallMessage( "The installer can't continue before file uploads are enabled. Please use the install from directory method.",
			'Installer - Error', $installer->returnTo( $option, $task, $client ) );
		exit();
	}

	// Check that the zlib is available
	if(!extension_loaded('zlib')) {
		HTML_comprofiler::showInstallMessage( "The installer can't continue before zlib is installed",
			'Installer - Error', $installer->returnTo( $option, $task, $client ) );
		exit();
	}

	$userfile = cbGetParam( $_FILES, 'userfile', null );

	if (!$userfile || $userfile==null) {
		HTML_comprofiler::showInstallMessage( 'No file selected', 'Upload new plugin - error',
			$installer->returnTo( $option, $task, $client ));
		exit();
	}

	$msg = '';
	//echo "step-uploadfile<br />";
	$resultdir = uploadFile( $userfile['tmp_name'], $userfile['name'], $msg );
	
	if ($resultdir !== false) {
		//echo "step-upload<br />";
		if (!$installer->upload( $userfile['name'] )) {
			if ( $installer->unpackDir() ) {
				cleanupInstall( $userfile['name'], $installer->unpackDir() );
			}
			HTML_comprofiler::showInstallMessage( $installer->getError(), 'Upload '.$task.' - Upload Failed',
				$installer->returnTo( $option, $task, $client ) );
		}
		//echo "step-install<br />";
		$ret = $installer->install();

		HTML_comprofiler::showInstallMessage( $installer->getError(), 'Upload '.$task.' - '.($ret ? 'Success' : 'Failed'),
			$installer->returnTo( $option, $task, $client ) );
		cleanupInstall( $userfile['name'], $installer->unpackDir() );
	} else {
		HTML_comprofiler::showInstallMessage( $msg, 'Upload '.$task.' -  Upload Error',
			$installer->returnTo( $option, $task, $client ) );
	}
	
}

function uploadFile( $filename, $userfile_name, &$msg ) {
	global $mainframe;
	$baseDir = mosPathName( $mainframe->getCfg('absolute_path') . '/media' );

	if (file_exists( $baseDir )) {
		if (is_writable( $baseDir )) {
			if (move_uploaded_file( $filename, $baseDir . $userfile_name )) {
			    if ((!is_callable("mosChmod")) or mosChmod( $baseDir . $userfile_name )) {		// mambo 4.5.1 support
			        return true;
				} else {
					$msg = 'Failed to change the permissions of the uploaded file.';
				}
			} else {
				$msg = 'Failed to move uploaded file to <code>/media</code> directory.';
			}
		} else {
		    $msg = 'Upload failed as <code>/media</code> directory is not writable.';
		}
	} else {
	    $msg = 'Upload failed as <code>/media</code> directory does not exist.';
	}
	return false;
}

function installPluginDir() {

	global $mainframe,$_FILES;
	
	$option="com_comprofiler";
	$task="showPlugins";
	$client=0;
	// echo "installPluginDir";
	
	$installer = new cbInstallerPlugin();

	$userfile = cbGetParam( $_REQUEST, 'userfile', null );	
	
	// Check if file name exists
	if (!$userfile) {
		HTML_comprofiler::showInstallMessage( 'No file selected', 'Install new plugin from directory - error',
			$installer->returnTo( $option, $task, $client ) );
		exit();
	}

	$path = mosPathName( $userfile );
	if (!is_dir( $path )) {
		$path = dirname( $path );
	}

	$ret = $installer->install( $path);

	HTML_comprofiler::showInstallMessage( $installer->getError(), 'Install new plugin from directory '.$userfile.' - '.($ret ? 'Success' : 'Failed'),
		$installer->returnTo( $option, $task, $client ) );
}


function installPluginURL() {
	global $mainframe,$_FILES;
	
	$option="com_comprofiler";
	$task="showPlugins";
	$client=0;
	// echo "installPluginURL";
	
	$installer = new cbInstallerPlugin();

	// Check that the zlib is available
	if(!extension_loaded('zlib')) {
		HTML_comprofiler::showInstallMessage( "The installer can't continue before zlib is installed",
			'Installer - Error', $installer->returnTo( $option, $task, $client ) );
		exit();
	}

	$userfileURL = cbGetParam( $_REQUEST, 'userfile', null );	

	if (!$userfileURL) {
		HTML_comprofiler::showInstallMessage( 'No URL selected', 'Upload new plugin - error',
			$installer->returnTo( $option, $task, $client ));
		exit();
	}

	$msg = '';
	$userfileName = "comprofiler_temp.zip";
	//echo "step-uploadfile<br />";
	$resultdir = uploadFileURL( $userfileURL, $userfileName, $msg );
	
	if ($resultdir !== false) {
		//echo "step-upload<br />";
		if (!$installer->upload( $userfileName )) {
			HTML_comprofiler::showInstallMessage( $installer->getError(), 'Download '.$userfileURL.' - Upload Failed',
				$installer->returnTo( $option, $task, $client ) );
		}
		//echo "step-install<br />";
		$ret = $installer->install();

		HTML_comprofiler::showInstallMessage( $installer->getError(), 'Download '.$userfileURL.' - '.($ret ? 'Success' : 'Failed'),
			$installer->returnTo( $option, $task, $client ) );
		cleanupInstall( $userfileName, $installer->unpackDir() );
	} else {
		HTML_comprofiler::showInstallMessage( $msg, 'Download '.$userfileURL.' -  Download Error',
			$installer->returnTo( $option, $task, $client ) );
	}
	
}

function uploadFileURL( $userfileURL, $userfile_name, &$msg ) {
	global $mainframe;

	include_once( $mainframe->getCfg('absolute_path') . '/administrator/components/com_comprofiler/Snoopy.class.php' );

	$baseDir = mosPathName( $mainframe->getCfg('absolute_path') . '/media' );

	if (file_exists( $baseDir )) {
		if (is_writable( $baseDir )) {
			
			$s = new Snoopy();
			@$s->fetch($userfileURL);

	  
			if (!$s->error) {			
				if ($fileHandle = fopen($baseDir . $userfile_name, "w")) {
					if (fwrite($fileHandle, $s->results) !== false) {
						fclose($fileHandle);
						if ((!is_callable("mosChmod")) or mosChmod( $baseDir . $userfile_name )) {		// mambo 4.5.1 support
							return true;
						} else {
							$msg = 'Failed to change the permissions of the uploaded file '.$baseDir.$userfile_name;
						}
					} else {
						fclose($fileHandle);
						unlink( $baseDir . $userfile_name );
						$msg = 'Failed to write the uploaded file in '.$baseDir.$userfile_name;
					}
				} else {
					$msg = 'Failed to create uploaded file in '.$baseDir.$userfile_name;
				}
			} else {
				$msg = 'Failed to download package file from <code>'.$userfileURL
						.'</code> to <code>/media</code> directory due to following error: '.$s->error;
			}
		} else {
		    $msg = 'Upload failed as <code>/media</code> directory is not writable.';
		}
	} else {
	    $msg = 'Upload failed as <code>/media</code> directory does not exist.';
	}
	return false;
}

function clearSearchBox(){
	global $mainframe;
	$mainframe->setUserState('searchcom_comprofiler','');
}

// Ajax: administrator/index3.php?option=com_comprofiler&task=latestVersion&no_html=1 :
function latestVersion(){
	global $mainframe, $mosConfig_live_site, $ueConfig;
	
	include_once( $mainframe->getCfg('absolute_path') . '/administrator/components/com_comprofiler/Snoopy.class.php' );
	
	$s = new Snoopy();
	$s->read_timeout = 90;
	$s->referer = $mosConfig_live_site;
	@$s->fetch('http://www.joomlapolis.com/versions/comprofilerversion.php?currentversion='.urlencode($ueConfig['version']));
	$version_info = $s->results;
	$version_info_pos = strpos($version_info, ":");
	if ($version_info_pos === false) {
		$version = $version_info;
		$info = null;
	} else {
		$version = substr( $version_info, 0, $version_info_pos );
		$info = substr( $version_info, $version_info_pos + 1 );
	}
	if($s->error || $s->status != 200){
    	echo '<font color="red">Connection to update server failed: ERROR: ' . $s->error . ($s->status == -100 ? 'Timeout' : $s->status).'</font>';
    } else if($version == $ueConfig['version']){
    	echo '<font color="green">' . $version . '</font>' . $info;
    } else {
    	echo '<font color="red">' . $version . '</font>' . $info;
    }
}

?>

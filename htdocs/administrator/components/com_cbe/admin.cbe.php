<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

// ensure this file is being included by a parent file
/* verändert Anfang */
defined('_JEXEC') or die('Restricted access');
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(0);
global $ueConfig, $enhanced_Config, $mosConfig_sitename, $mosConfig_lang;
$lang =& JFactory::getLanguage();
$mosConfig_lang = $lang->getBackwardLang();
$database = &JFactory::getDBO();
$mosConfig_sitename =  $mainframe->getCfg('sitename');
JLoader::register('JTableUser', JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'user.php');
$cbepath = JPATH_SITE.'/components/com_cbe';
$cbeadminpath = JPATH_BASE.'/components/com_cbe';
/* verändert Ende */

/*
if (!$acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' )) {
	$mainframe->redirect( 'index2.php', _NOT_AUTH );
}
$user = & JFactory::getUser();
if (!$user->authorize( 'com_cbe', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}
*/

if (file_exists($cbeadminpath . '/language/'.$mosConfig_lang.'.php')) {
	include($cbeadminpath . '/language/'.$mosConfig_lang.'.php');
} else {
	include($cbeadminpath . '/language/english.php');
}

require_once( JApplicationHelper::getPath( 'admin_html', 'com_cbe') );

require($cbeadminpath . "/ue_config.php" );
require($cbeadminpath . "/imgToolbox.class.php");

include_once($cbepath . '/enhanced/enhanced.class.php');
include_once($cbeadminpath . '/enhanced_admin/enhanced_config.php' );

//Include the enhanced language files
$database = &JFactory::getDBO();
$database->setQuery("SELECT enhanced_params FROM #__cbe_tabs");
$enhanced_names = $database->loadObjectList();

foreach($enhanced_names as $enhanced_name)
{
	$enhanced_params = new JParameter($enhanced_name->enhanced_params);

	//$enhanced_params = mosParseParams($enhanced_name->enhanced_params);

	if($enhanced_params->get('tabtype') != 3)
	{
		if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/'.$enhanced_params->get('enhancedname').'/language/'.$mosConfig_lang.'.php'))
		{
			include_once(JPATH_SITE.'/components/com_cbe/enhanced/'.$enhanced_params->get('enhancedname').'/language/'.$mosConfig_lang.'.php');
		}
		else
		{
			include_once(JPATH_SITE.'/components/com_cbe/enhanced/'.$enhanced_params->get('enhancedname').'/language/english.php');
		}
	}
}
if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/language/'.$mosConfig_lang.'.php'))
{
	include_once(JPATH_SITE.'/components/com_cbe/enhanced/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once(JPATH_SITE.'/components/com_cbe/enhanced/language/english.php');
}



//$task 		= trim( JArrayHelper::getValue( $_REQUEST, 'task', null ) );
$task = JRequest::getVar('task', null);
$listtype = JRequest::getVar('listType', '-null-');
$cid = JRequest::getVar('cid', array(0));
$option = JRequest::getVar('option', '');
$ret	= JRequest::getVar('ret', '');

//$listtype 	= strval( JArrayHelper::getValue( $_REQUEST, 'listType', '-null-' ) );
//$cid 		= JArrayHelper::getValue( $_REQUEST, 'cid', array( 0 ) );
if (!is_array( $cid )) {
	$cid = array ( 0 );
}

$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0') AND access='0' ORDER BY id DESC Limit 1");
$Itemid_comb = $database->loadResult();
if ($Itemid_comb!='' || $Itemid_com!=NULL) {
	$Itemid_comb = '&amp;Itemid='.$Itemid_comb;
} else {
	$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0') AND access='1' ORDER BY id DESC Limit 1");
	$Itemid_comb = $database->loadResult();
	if ($Itemid_comb!='' || $Itemid_comb!=NULL) {
		$Itemid_comb = '&amp;Itemid='.$Itemid_comb;
	} else {
		$Itemid_comb = '';
	}
}

switch ($task) {
	case 'cbeModul':
		$was = JRequest::getVar('cbe_rss', '');
		cbeModul($was);
		break;

	case 'cbeUpdate':
		cbeUpdate();
		break;

	case 'cbeUpdateFeed':
		cbeUpdateFeed();
		break;

	case 'cbeCheckUpdate':
		cbeCheckUpdate();
		break;

	case 'cbeInstallUpdate':
		cbeInstallUpdate();
		break;

	case "cbeNewExtension":
		HTML_cbe::cbeNewExtension();
		break;

	case "cbeInstallExtension":
		cbeInstallExtension();
		break;

	case "pluginConfig":
		PluginConfig();
		break;

	case "savePluginConfig":
		savePluginConfig($option);
		break;

	case 'cbePluginInstall':
		cbe_plugins_install();
		break;
	case "new":
	editUser( 0, $option);
	break;

	case "add":
	editUser( 0, $option);
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

	case "avatarApprove":
	approveAvatar( $cid, 1, $option );
	break;

	case "avatarDisapprove":
	approveAvatar( $cid, 0, $option );
	break;

	case "userConfirm":
	confirmUser( $cid, 1, $option );
	break;

	case "userDisconfirm":
	confirmUser( $cid, 0, $option );
	break;

	case "showconfig":
	showConfig( $option );
	break;

	case "showinstruction":
	showInstructions($database, $option, $mosConfig_lang);
	break;

	case "showsubscription":
	showSubscription($database, $option, $mosConfig_lang);
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
	removeTabs( $cid, $option, $ret );
	break;

	case "showTab":
	showTab( $option );
	break;

	case "orderupTab":
	orderTabs( $cid[0], -1, $option );
	break;

	case "orderdownTab":
	orderTabs( $cid[0], 1, $option );
	break;

	case 'saveorder':
		switch ($listtype) {
			case 'showTabs':
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeTabs.php');
				$row = new moscbeTabs( $database );
				$cond_trans = "\$condition = \"ordering >= 0 AND ordering <=1000\";";
				$rt_msg = saveOrder( $cid, $row, $listtype, $cond_trans );
				$mainframe->redirect( 'index.php?option=com_cbe&task=showTab', JText::_($rt_msg) );

				//mosRedirect( 'index2.php?option=com_cbe&task=showTab', $rt_msg );
			break;
			
			case 'showLists':
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeLists.php');
				$row = new moscbeLists( $database );
				$cond_trans = "\$condition = \"ordering >= 0 AND ordering <=1000\";";
				$rt_msg = saveOrder( $cid, $row, $listtype, $cond_trans );
				//mosRedirect( 'index2.php?option=com_cbe&task=showLists', $rt_msg );
				$mainframe->redirect( 'index.php?option=com_cbe&task=showLists', JText::_($rt_msg) );

			break;

			case 'showFields':
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeFields.php');
				$row = new moscbeFields( $database );
				$cond_trans = "\$condition = \"tabid='\$row->tabid' AND sys='0' AND ordering >= 0 AND ordering <=1000\";";
				$rt_msg = saveOrder( $cid, $row, $listtype, $cond_trans );
				$mainframe->redirect( 'index.php?option=com_cbe&task=showField', JText::_($rt_msg) );

				//mosRedirect( 'index2.php?option=com_cbe&task=showField', $rt_msg );
			break;

			case 'show_AdMods':
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdMods.php');
				$row = new cbeAdMods( $database );
				$cond_trans = "\$condition = \"ordering >= 0 AND ordering <=1000\";";
				$rt_msg = saveOrder( $cid, $row, $listtype, $cond_trans );
				//mosRedirect( 'index2.php?option=com_cbe&task=showAdMods', $rt_msg );
				$mainframe->redirect( 'index.php?option=com_cbe&task=showAdMods', JText::_($rt_msg) );

			break;
			
			case '-null-':
				return;
			break;
		}
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
	case "copyList":
	copyList( $cid, $option );
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

	case "fieldProfileYes":
	profileField( $cid, 1, $option );
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

	case "showusers":
	showUsers( $option );
	break;

	case "enhancedConfig":
	enhancedConfig( $option );
	break;

	case "saveEnhancedConfig":
	saveEnhancedConfig( $option );
	break;

	case "languageFilter":
	showLanguageFilter( $option );
	break;

	case "editLanguageFilter":
	editLanguageFilter( $cid[0], $option );
	break;

	case "newLanguageFilter":
	editLanguageFilter( 0, $option );
	break;

	case "saveLanguageFilter":
	saveLanguageFilter( $option );
	break;

	case "cancelLanguageFilter":
	cancelLanguageFilter( $option );
	break;

	case "publishLanguageFilter":
	publishLanguageFilter( $cid, 1, $option );
	break;

	case "unpublishLanguageFilter":
	publishLanguageFilter( $cid, 0, $option );
	break;

	case "deleteLanguageFilter":
	deleteLanguageFilter( $cid, $option );
	break;

	case "searchManage":
	searchManage( $option );  // added by Rasmus Dahl-Sorensen, January 2005
	break;

	case "fieldRangeallowNo":
	allowRange( $cid, 0, $option ); // added by Rasmus Dahl-Sorensen, January 2005
	break;

	case "fieldRangeallowYes":
	allowRange( $cid, 1, $option ); // added by Rasmus Dahl-Sorensen, January 2005
	break;

	case "fieldSimpleNo":
	simpleField( $cid, 0, $option ); // added by Rasmus Dahl-Sorensen, January 2005
	break;

	case "fieldSimpleYes":
	simpleField( $cid, 1, $option ); // added by Rasmus Dahl-Sorensen, January 2005
	break;

	case "fieldAdvancedNo":
	advancedField( $cid, 0, $option ); // added by Rasmus Dahl-Sorensen, January 2005
	break;

	case "fieldAdvancedYes":
	advancedField( $cid, 1, $option ); // added by Rasmus Dahl-Sorensen, January 2005

	case "fieldModuleNo":
	SMmoduleField( $cid, 0, $option );

	case "fieldModuleYes":
	SMmoduleField( $cid, 1, $option );

	// added sv0.62
	case "orderupSearchField":
	orderSearchFields( $cid[0], -1, $option );
	break;

	case "orderdownSearchField":
	orderSearchFields( $cid[0], 1, $option );
	break;
	// sv062 end

	//sv0623
	case "adminUpAvatar":
	adminAvatarUp( $option );
	break;

	case "adminDelAvatar":
	adminAvatarDel( $option );
	break;
	//sv0623 end
	//sv06232
	case "resendConfirm":
	resendConfirmC( $cid, $option );
	break;

	case "badUserNames":
	show_badUserNames( $option );
	break;

	case "newbadUserNames":
	edit_badUserNames( 0, $option );
	break;

	case "editbadUserNames":
	edit_badUserNames( $cid[0], $option );
	break;
	
	case "savebadUserNames":
	save_badUserNames( $option );
	break;

	case "cancelbadUserNames":
	cancel_badUserNames( $option );
	break;

	case "publishbadUserNames":
	publish_badUserNames( $cid, 1, $option );
	break;

	case "unpublishbadUserNames":
	publish_badUserNames( $cid, 0, $option );
	break;

	case "deletebadUserNames":
	delete_badUserNames( $cid, $option );
	break;
	//sv06232 end

	// AdMods start
	case "showAdMods":
	show_AdMods( $option );
	break;
	
	case "newAdMods":
	edit_AdMods( 0, $option );
	break;

	case "editAdMods":
	edit_AdMods( $cid[0], $option);
	break;
	
	case "saveAdMods":
	save_AdMods( $option);
	break;

	case "cancelAdMods":
	cancel_AdMods( $option);
	break;

	case "publishAdMods":
	publish_AdMods( $cid, 1, $option);
	break;

	case "unpublishAdMods":
	publish_AdMods( $cid, 0, $option);
	break;

	case "deleteAdMods":
	delete_AdMods( $cid, $option);
	break;

	case "orderupAdMods":
	order_AdMods( $cid[0], -1, $option );
	break;

	case "orderdownAdMods":
	order_AdMods( $cid[0], 1, $option );
	break;
	// AdMods end	

	case 'cpanel':
	HTML_cbe::controlPanel();
	break;

	default:
	cbe_catch_task($option, $cid, $listtype);
	break;
}

//die();
/************************************/
function yesnoSelectList( $tag_name, $tag_attribs, $selected, $yes='yes', $no='no' )
{
	$arr = array(
		JHTML::_('select.option', 0, JText::_( $no ) ),
		JHTML::_('select.option', 1, JText::_( $yes ) ),
	);
	return JHTML::_('select.genericlist', $arr, $tag_name, $tag_attribs, 'value', 'text', (int) $selected );
}

function searchManage( $option )

// added by Rasmus Dahl-Sorensen, January 2005

{
	global $mainframe, $my, $_POST,$mosConfig_list_limit, $task;;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if(!isset($mosConfig_list_limit)) $limit = 10;
	else $limit=$mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	
	if($task=='searchManage')

	{
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
	}

	$where = array();
//	$where[] = "(f.sys = 0)";
	$where[] = "(f.sys = 0 OR f.name='zodiac' OR f.name='zodiac_c' OR f.name='name' OR f.name='username') and f.fieldid=t.fieldid";
	if (isset( $search ) && $search!= "") {
		$where[] = "(f.name LIKE '%$search%' OR f.type LIKE '%$search%')";
	}

	// count number of fields

	$database->setQuery( "SELECT COUNT(*)"
	. "\nFROM #__cbe_fields AS f, #__cbe_searchmanager as t"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);

	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	//$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	$pageNav = new JPagination( $total, $limitstart, $limit  );

	$where[] = "(f.fieldid = t.fieldid)";

	// get all field information from database

	$database->setQuery( "SELECT f.fieldid AS 'fieldid', f.title, f.name, f.type, f.published, t.range, t.simple, t.advanced, t.module"
	. "\nFROM #__cbe_fields AS f, #__cbe_searchmanager AS t"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\nORDER BY t.ordering"
	. "\nLIMIT $pageNav->limitstart, $pageNav->limit");

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_cbe::searchManage( $rows, $pageNav, $search, $option );

}
function allowRange( $cid=null, $flag=1, $option ) {

	// allows the field to be searched as a range
	// added by Rasmus Dahl-Sorensen

	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Allow' : 'Disallow';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_searchmanager SET range='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}

	//mosRedirect( "index2.php?option=$option&task=searchManage" );
	$mainframe->redirect( 'index.php?option=com_cbe&task=searchManage');

}
function simpleField( $cid=null, $flag=1, $option ) {

	// publishes the relevant field to the simple search form
	// added by Rasmus Dahl-Sorensen

	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Publish' : 'UnPublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_searchmanager SET simple='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}

	//mosRedirect( "index2.php?option=$option&task=searchManage" );
	$mainframe->redirect("index.php?option=$option&task=searchManage");

}
function advancedField( $cid=null, $flag=1, $option )
{

	// publishes the relevant field to the advanced search form
	// added by Rasmus Dahl-Sorensen
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Publish' : 'UnPublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_searchmanager SET advanced='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}

	//mosRedirect( "index2.php?option=$option&task=searchManage" );
	$mainframe->redirect("index.php?option=$option&task=searchManage");

}

function SMmoduleField( $cid=null, $flag=1, $option )
{

	// publishes the relevant field to the advanced search form
	// added by Rasmus Dahl-Sorensen

	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Publish' : 'UnPublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_searchmanager SET module='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}

	//mosRedirect( "index2.php?option=$option&task=searchManage" );
	$mainframe->redirect("index.php?option=$option&task=searchManage");

}
// sv0.62 add
function orderSearchFields( $cid, $inc, $option ) {
	global $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeSearchField.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeSearchField( $database );
	$row->load( $cid );
	$row->move( $inc );
	//mosRedirect( "index2.php?option=$option&task=searchManage" );
	$mainframe->redirect("index.php?option=$option&task=searchManage");

}


function showLanguageFilter($option)
{
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__cbe_bad_words" );

	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	//$pageNav = new mosPageNav( $total, $limitstart, $limit );
	$pageNav = new JPagination( $total, $limitstart, $limit );

	$database->setQuery( "SELECT * FROM #__cbe_bad_words ORDER BY id LIMIT $pageNav->limitstart,$pageNav->limit" );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_cbe::showLanguageFilter( $rows, $pageNav, $option );
}
function editLanguageFilter( $cid, $option )
{
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moslanguage_filter( $database );
	$row->load( $cid );

	HTML_cbe::editLanguageFilter( $row, $option );
}
function saveLanguageFilter( $option )
{
	global $mainframe;

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moslanguage_filter( $database );

	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	//mosRedirect( "index2.php?option=com_cbe&task=languageFilter" );
	$mainframe->redirect("index.php?option=$option&task=languageFilter");

}
function cancelLanguageFilter( $option )
{
	global $mainframe;

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moslanguage_filter( $database );
	$row->bind( $_POST );
	$row->checkin();
	//mosRedirect( "index2.php?option=com_cbe&task=languageFilter" );
	$mainframe->redirect( 'index.php?option=com_cbe&task=languageFilter');

}
function publishLanguageFilter( $cid, $publish, $option )
{
	global $mainframe;

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1)
	{
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select a item to ".$action."'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__cbe_bad_words SET published=($publish) WHERE id IN ($cids)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1)
	{
		$row = new moslanguage_filter( $database );
		$row->checkin( $cid[0] );
	}

	//mosRedirect( "index2.php?option=com_cbe&task=languageFilter" );
	$mainframe->redirect( 'index.php?option=com_cbe&task=languageFilter');

}
function deleteLanguageFilter( $cid, $option )
{
	global $mainframe;

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (!is_array( $cid ) || count( $cid ) < 1)
	{
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );
	$database->setQuery( "DELETE FROM #__cbe_bad_words WHERE id IN ($cids)" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	//mosRedirect( "index2.php?option=com_cbe&task=languageFilter" );
	$mainframe->redirect( 'index.php?option=com_cbe&task=languageFilter');
}
function saveList( $option ) {
	global $my, $_POST;
	global $mosConfig_live_site;
	global $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeLists.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");

	$row = new moscbeLists( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if(isset($_POST['col1'])) { $row->col1fields = implode("|*|",$_POST['col1']); } else { $row->col1fields = null; } ;
	if(isset($_POST['col2'])) { $row->col2fields = implode("|*|",$_POST['col2']); } else { $row->col2fields = null; } ;
	if(isset($_POST['col3'])) { $row->col3fields = implode("|*|",$_POST['col3']); } else { $row->col3fields = null; } ;
	if(isset($_POST['col4'])) { $row->col4fields = implode("|*|",$_POST['col4']); } else { $row->col4fields = null; } ;

	if($_POST['filteronline']=='1') { $row->filteronline = '1'; } else { $row->filteronline = '0'; };

	if ($row->col1enabled != 1) $row->col1enabled=0;
	if ($row->col2enabled != 1) $row->col2enabled=0;
	if ($row->col3enabled != 1) $row->col3enabled=0;
	if ($row->col4enabled != 1) $row->col4enabled=0;
	if ($row->col1captions != 1) $row->col1captions=0;
	if ($row->col2captions != 1) $row->col2captions=0;
	if ($row->col3captions != 1) $row->col3captions=0;
	if ($row->col4captions != 1) $row->col4captions=0;
	
	if (!$row->store($_POST['listid'],true)) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}

	//sv0.6232 reordering check
	$database->setQuery("SELECT COUNT(ordering) as count, MAX(ordering)+1 as max from #__cbe_lists");
	$database->loadObject($checkold);
	If ($checkold->count != $checkold->max) {
		$database->setQuery("SELECT listid from #__cbe_lists ORDER BY ordering ASC");
		$cklists = $database->loadResultArray();
		if ($cklists[0]!='') {
			$i=0;
			foreach ( $cklists as $cklist) {
				$database->setQuery("UPDATE #__cbe_lists SET ordering = '".$i."' WHERE listid='".$cklist."'");
				$database->query();
				$i++;
			}
		}
	}	

	//mosRedirect( "index2.php?option=$option&task=showLists" );
	$mainframe->redirect( "index.php?option=$option&task=showLists");
}

function showLists( $option ) {
	global $mainframe, $my, $mosConfig_list_limit;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$task="";
	$search="";
	if(!isset($mosConfig_list_limit)) $limit = 10;
	else $limit=$mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	if(ISSET($_POST['task'])) $task=$_POST['task'];
	if($task=='showLists') {
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
	}
	$where = array();
	if (isset( $search ) && $search!= "") {
		$where[] = "(a.title LIKE '%$search%' OR a.description LIKE '%$search%')";
	}

	$database->setQuery( "SELECT COUNT(*)"
	. "\nFROM #__cbe_lists AS a"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	$pageNav = new JPagination( $total, $limitstart, $limit  );
	$database->setQuery( "SELECT listid, title, description, published,`default`, ordering"
	. "\nFROM #__cbe_lists a"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\n ORDER BY ordering"
	. "\nLIMIT $pageNav->limitstart, $pageNav->limit"
	);

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_cbe::showLists( $rows, $pageNav, $search, $option );
}

function editList( $fid='0', $option='com_cbe' ) {
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeLists.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeHTML.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeLists( $database );
	// load the row from the db table
	$row->load( $fid );

	$lists['published'] = yesnoSelectList( 'published', 'class="inputbox" size="1"', $row->published );
	$lists['default'] = yesnoSelectList( 'default', 'class="inputbox" size="1"', $row->default );
	$my_groups = $acl->get_object_groups( 'users', $my->id, 'ARO' );

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
	while ($i < count( $gtree )) {
		if (in_array( $gtree[$i]->value, $ex_groups )) {
			array_splice( $gtree, $i, 1 );
		} else {
			$i++;
		}
	}

	$gtree2=array();
	$gtree2 = array_merge( $gtree2, $acl->get_group_children_tree( null, 'USERS', false ));

	$usergids=explode(",",$row->usergroupids);
	$ugids = array();
	foreach($usergids as $usergid) {
		$ugids[]->value=$usergid;
	}

	$gtree3=array();
	$gtree3[] = JHTML::_('select.option',  -2 , '- Everybody -' );
	$gtree3[] = JHTML::_('select.option',  -1, '- All Registered Users -' );
	$gtree3 = array_merge( $gtree3, $acl->get_group_children_tree( null, 'USERS', false ));


	$lists['usergroups'] = moscbeHTML::selectList( $gtree2, 'usergroups', 'size="4" MULTIPLE onblur="loadUGIDs(this);" mosReq=1 mosLabel="User Groups"', 'value', 'text', $ugids,1 );
	$lists['aclgroup']=JHTML::_('select.genericlist',  $gtree3, 'aclgroup', 'size="4"', 'value', 'text', $row->aclgroup );

	$database->setQuery( "SELECT f.fieldid, f.title"
	. "\nFROM #__cbe_fields AS f"
	. "\nWHERE f.published = 1 AND f.profile=1"
	. "\n ORDER BY f.ordering"
	);
	//echo $database->getQuery();
	$field = $database->loadObjectList();
	$fields = array();
	//print_r(array_values($field));
	for ($i=0, $n=count( $field ); $i < $n; $i++) {
		$fieldvalue = array();
		$fieldvalue =& $field[$i];
		//print "fieldid = ".$fieldvalue->fieldid;
		$fields[$fieldvalue->title] = $fieldvalue->fieldid;
	}
	//print_r(array_values($fields));
	HTML_cbe::editList( $row, $lists,$fields, $option, $fid );
}

function copyList( $cid, $option ) {
	global $mainframe;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeLists.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (!is_array( $cid ) || count( $cid ) != 1 ) {
		echo "<script> alert('Select one item to copy'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';

	$database->setQuery("SELECT MAX(ordering)+1 as max FROM #__cbe_lists");
	$new_ordering = $database->loadResult();
	
	if (count( $cid ) == 1) {
		$obj = new moscbeLists( $database );
		$obj->load($cid[0]);
		$new_obj = new moscbeLists( $database );
		$nid = 0;
		$new_obj->load($nid);
		$tmpid = $new_obj->listid;
		$new_obj = $obj;
		$new_obj->listid = $tmpid;
		$new_obj->title = $obj->title."_copy";
		$new_obj->default = 0;
		$new_obj->published = 0;
		$new_obj->ordering = $new_ordering;
		if (!$new_obj->store($tmpid,true)) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
			exit();
		}
		$msg = "userlist was copied to ".$new_obj->title;

	} else {
		$msg = " Error ";
	}
	//mosRedirect( "index2.php?option=$option&task=showLists", $msg );
	$mainframe->redirect( "index.php?option=$option&task=showLists", $msg);

}

function removeList( $cid, $option ) {
	global $mainframe;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeLists.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new moscbeLists( $database );
		foreach ($cid as $id) {
			$obj->delete( $id );
		}
	}

	//if($msg!='') echo "<script> alert('".$msg."'); window.history.go(-1);</script>\n";
	//mosRedirect( "index2.php?option=$option&task=showLists", $msg );
	$mainframe->redirect( "index.php?option=$option&task=showLists", $msg);

}

function orderLists( $lid, $inc, $option ) {
	global $mainframe;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeLists.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeLists( $database );
	$row->load( $lid );
	$row->move( $inc );
	//mosRedirect( "index2.php?option=$option&task=showLists" );
	$mainframe->redirect( "index.php?option=$option&task=showLists");
}

function showField( $option ) {
	global $mainframe, $my, $_POST,$mosConfig_list_limit;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdminMenus.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$task="";
	$search="";
	$tabid = $mainframe->getUserStateFromRequest( "tabid{$option}", 'tabid', 0 );
	
	if(!isset($mosConfig_list_limit)) $limit = 10;
	else $limit=$mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	if(ISSET($_POST['task'])) $task=$_POST['task'];
	if($task=='showField') {
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
	}
	$where = array();
	if ($tabid > 0) {
		$where[] = "f.tabid=" . $tabid;
    	}

	$where[] = "(f.sys = 0)";
	if (isset( $search ) && $search!= "") {
		$where[] = "(f.name LIKE '%$search%' OR f.type LIKE '%$search%')";
	}

	$database->setQuery( "SELECT COUNT(*)"
	. "\nFROM #__cbe_fields AS f"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	$pageNav = new JPagination( $total, $limitstart, $limit  );
	$where[] = "(f.tabid = t.tabid)";
	$database->setQuery( "SELECT f.fieldid, f.title, f.name, f.type, f.required, f.published, f.profile, f.ordering, f.registration, f.tabid, t.title AS 'tab'"
	. "\nFROM #__cbe_fields AS f, #__cbe_tabs AS t"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\n ORDER BY t.ordering, f.ordering"
	. "\nLIMIT $pageNav->limitstart, $pageNav->limit"
	);

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['tabid'] = cbeAdminMenus::TabCategory( 'tabid', 'com_cbe', intval( $tabid ), $javascript );

	HTML_cbe::showFields( $rows, $pageNav, $search, $option, $lists );
}

function editField( $fid='0', $option='com_cbe' ) {
	global $my;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeFields.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeFields( $database );
	// load the row from the db table
	$row->load( $fid );
	$tabs = $database->setQuery("SELECT tabid, title FROM #__cbe_tabs WHERE `fields`=1 ORDER BY ordering");
	$tabs = $database->loadObjectList();
	$lists = array();
	$tablist = array();

	for ($i=0, $n=count( $tabs ); $i < $n; $i++) {
		$tab =& $tabs[$i];
		$tablist[] = JHTML::_('select.option',  $tab->tabid, getLangDefinition($tab->title) );
	}

	$lists['tabs'] = JHTML::_('select.genericlist',  $tablist, 'tabid', 'class="inputbox" size="1" mosReq=1 mosLabel="Tab"', 'value', 'text', $row->tabid );

	$types = array();

	$types[] = JHTML::_('select.option',  'checkbox', 'Check Box (Single)' );
	$types[] = JHTML::_('select.option',  'multicheckbox', 'Check Box (Muliple)' );
	$types[] = JHTML::_('select.option',  'date', 'Date' );
	$types[] = JHTML::_('select.option',  'birthdate', 'Date (with allowed Range)' );
	$types[] = JHTML::_('select.option',  'dateselect', 'Date (triple DropDown)' );
	//$types[] = JHTML::_('select.option',  'dateselectrange', 'Date (triple DropDown & Range)' );
	$types[] = JHTML::_('select.option',  'select', 'Drop Down (Single Select)' );
	$types[] = JHTML::_('select.option',  'multiselect', 'Drop Down (Multi-Select)' );
	$types[] = JHTML::_('select.option',  'emailaddress', 'Email Address' );
	//$types[] = JHTML::_('select.option',  'password', 'Password Field' );
	$types[] = JHTML::_('select.option',  'editorta', 'Editor Text Area' );
	$types[] = JHTML::_('select.option',  'textarea', 'Text Area' );
	$types[] = JHTML::_('select.option',  'text', 'Text Field' );
	$types[] = JHTML::_('select.option',  'radio', 'Radio Button' );
	$types[] = JHTML::_('select.option',  'webaddress', 'Web Address' );
	$types[] = JHTML::_('select.option',  'numericfloat', 'Number Field (Float)' );
	$types[] = JHTML::_('select.option',  'numericint', 'Number Field (Integer)' );
	$types[] = JHTML::_('select.option',  'spacer', 'Spacer Line' );

	$info_tag[] = JHTML::_('select.option',  'none', _UE_CBE_FM_FIELD_NO_TP );
	$info_tag[] = JHTML::_('select.option',  'icon', _UE_CBE_FM_FIELD_ICON_TP );
	$info_tag[] = JHTML::_('select.option',  'tag', _UE_CBE_FM_FIELD_TAGED_TP );
	$info_tag[] = JHTML::_('select.option',  'both', _UE_CBE_FM_FIELD_BOTH_TP );

	$fvalues = $database->setQuery( "SELECT fieldtitle "
	. "\n FROM #__cbe_field_values"
	. "\n WHERE fieldid=$fid"
	. "\n ORDER BY ordering" );
	$fvalues = $database->loadObjectList();

	$lists['type'] = JHTML::_('select.genericlist',  $types, 'type', 'class="inputbox" size="1" onchange="selType(this.options[this.selectedIndex].value);"', 'value', 'text', $row->type );
	$lists['required'] = yesnoSelectList( 'required', 'class="inputbox" size="1"', $row->required );
	$lists['published'] = yesnoSelectList( 'published', 'class="inputbox" size="1"', $row->published );
	$lists['readonly'] = yesnoSelectList( 'readonly', 'class="inputbox" size="1"', $row->readonly );
	$lists['profile'] = yesnoSelectList( 'profile', 'class="inputbox" size="1"', $row->profile );
	$lists['registration'] = yesnoSelectList( 'registration', 'class="inputbox" size="1"', $row->registration );
	$lists['information_tag'] = JHTML::_('select.genericlist',  $info_tag, 'infotag', 'class="inputbox" size="1"', 'value', 'text', $row->infotag );

	$database->setQuery("SELECT id, simple, advanced FROM #__cbe_searchmanager WHERE fieldid='".$fid."'");
	$f_search = $database->loadObject();
	$f_searchid = (!empty($f_search))?$f_search->id:'';

	if ($f_searchid != '') {
		if ($f_search->simple == '1' || $f_search->advanced == '1') {
			$row->searchmanager = '1';
		} else {
			$row->searchmanager = '0';
		}
		$row->searchmanager_p = '1';
		$row->search_id = $f_searchid;
	} else {
		$row->searchmanager = '0';
		$row->searchmanager_p = '0';
		$database->setQuery("SELECT MAX(id) FROM #__cbe_searchmanager");
		$f_maxid = $database->loadResult();
		$row->search_id = $f_maxid + 1;
	}
	$lists['searchmanager'] = yesnoSelectList( 'searchmanager', 'class="inputbox" size="1"', $row->searchmanager );

	HTML_cbe::editfield( $row, $lists, $fvalues, $option, $fid );
}

function saveField( $option ) {
	global $_POST;
	global $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeFields.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	global $mosConfig_live_site;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");
	$row = new moscbeFields( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if ($row->type == 'textarea' || $row->type == 'editorta') {
		$_maxlength_check = 16777216;
		if (intval($_POST['maxlength2']) > 0) {
			$_maxlength_check = $_POST['maxlength2'];
		}
		//$row->maxlength = $_POST['maxlength2'];
		$row->maxlength = $_maxlength_check;
	}
	if ($row->type == "birthdate" || $row->type == "dateselectrange") {
		$df_lowRange = intval(JArrayHelper::getValue($_POST, 'lowRange', 1900 ) );
		$df_highRange = intval(JArrayHelper::getValue($_POST, 'highRange', 3000 ) );
		$row->value = implode(",", array($df_lowRange, $df_highRange));
		$row->default = intval(JArrayHelper::getValue($_POST, 'default', NULL ) );
	}
	if($_POST['oldtabid'] != $_POST['tabid']) {
		//Re-order old tab
		$sql="UPDATE #__cbe_fields SET ordering = ordering-1 WHERE ordering > ".$_POST['ordering']." AND tabid = ".$_POST['oldtabid']." ";
		$database->setQuery($sql);
		$database->loadResult();
		//print $database->getquery();
		// double check for clean ordering sv0.6232
		$database->setQuery("SELECT COUNT(ordering) as count, MAX(ordering) as max from #__cbe_fields WHERE tabid='".$_POST['oldtabid']."'");
		$checkold= $database->loadObject();
		If ($checkold->count != $checkold->max) {
			$database->setQuery("SELECT fieldid from #__cbe_fields WHERE ordering IS NOT NULL and tabid='".$_POST['oldtabid']."' AND fieldid!='".$_POST['fieldid']."' ORDER BY ordering ASC");
			$ckfields = $database->loadResultArray();
			if ($ckfields[0]!='') {
				$i=1;
				foreach ( $ckfields as $ckfield) {
					$database->setQuery("UPDATE #__cbe_fields SET ordering = '".$i."' WHERE fieldid='".$ckfield."' AND tabid='".$_POST['oldtabid']."'");
					$database->query();
					$i++;
				}
			}
		} 

		//Select Last Order in New Tab
		$sql="Select max(ordering) from #__cbe_fields WHERE tabid=".$_POST['tabid'];
		$database->SetQuery($sql);
		$max = $database->loadResult();
		$row->ordering=$max+1;
	}
	//JFilterOutput::objectHTMLSafe($row);
	JFilterOutput::objectHTMLSafe( $row);
	$row->name = str_replace(" ", "", strtolower($row->name));

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	$fieldValues = array();
	$fieldNames = array();
	$fieldNames=$_POST['vNames'];
	$j=1;
	if($row->fieldid > 0) {
		$database->setQuery( "DELETE FROM #__cbe_field_values"
		. " WHERE fieldid='$row->fieldid'" );
		if(!$database->loadResult()) echo $database->getErrorMsg();
	} else {
		$database->setQuery( "SELECT MAX(fieldid) FROM #__cbe_fields");
		$maxID=$database->loadResult();
		$row->fieldid=$maxID;
		echo $database->getErrorMsg();
	}
	//for($i=0, $n=count( $fieldNames ); $i < $n; $i++) {
	foreach ($fieldNames as $fieldName) {
		if(trim($fieldName)!=null || trim($fieldName)!='') {
			$database->setQuery( "INSERT INTO #__cbe_field_values (fieldid,fieldtitle,ordering)"
			. " VALUES('$row->fieldid','".cbGetEscaped(htmlspecialchars($fieldName))."',$j)"
			);
			if(!$database->loadResult()) echo $database->getErrorMsg();
			$j++;
		}

	}
// sv0.623 CBE-Search start

	$f_searchmanager = $_POST['searchmanager'];
	$f_searchmanager_p = $_POST['searchmanager_p'];
	$f_searchid = $_POST['search_id'];
	$f_ordering = $f_searchid - 1;

	if ($f_searchmanager == 1 && $f_searchmanager_p == 0) {
		$database->setQuery("INSERT INTO #__cbe_searchmanager (id,fieldid,range,simple,advanced,ordering)"
				." VALUES ('".$f_searchid."','".$row->fieldid."','0','1','1','".$f_ordering."')");
		if(!$database->loadResult()) echo $database->getErrorMsg();
	}
	if ($f_searchmanager == 0 && $f_searchmanager_p == 0) {
		$database->setQuery("INSERT INTO #__cbe_searchmanager (id,fieldid,range,simple,advanced,ordering)"
				." VALUES ('".$f_searchid."','".$row->fieldid."','0','0','0','".$f_ordering."')");
		if(!$database->loadResult()) echo $database->getErrorMsg();
	}
	if ($f_searchmanager == 0 && $f_searchmanager_p == 1) {
		$database->setQuery("UPDATE #__cbe_searchmanager SET range='0', simple='0', advanced='0' WHERE id='".$f_searchid."' AND fieldid='".$row->fieldid."'");
		if(!$database->loadResult()) echo $database->getErrorMsg();
	}
	if ($f_searchmanager == 1 && $f_searchmanager_p == 1) {
		$database->setQuery("UPDATE #__cbe_searchmanager SET range='0', simple='1', advanced='1' WHERE id='".$f_searchid."' AND fieldid='".$row->fieldid."'");
		if(!$database->loadResult()) echo $database->getErrorMsg();
	}

// sv0.623 CBE-Search end
	$limit = intval( JArrayHelper::getValue( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( JArrayHelper::getValue( $_REQUEST, 'limitstart', 0 ) );

	//mosRedirect( "index2.php?option=$option&task=showField" );
	$mainframe->redirect( "index.php?option=$option&task=showField");

}

function removeField( $cid, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeFields.php');
	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new moscbeFields( $database );

		foreach ($cid as $id) {
			$obj->load($id);
			$database->setQuery("SELECT COUNT(*) FROM #__cbe_lists".
			" WHERE col1fields like '%|*|$id' OR col1fields like '$id|*|%' OR col1fields like '%|*|$id|*|%' OR col1fields='$id'".
			" OR col2fields like '%|*|$id' OR col2fields like '$id|*|%' OR col2fields like '%|*|$id|*|%' OR col2fields='$id'".
			" OR col3fields like '%|*|$id' OR col3fields like '$id|*|%' OR col3fields like '%|*|$id|*|%' OR col3fields='$id'".
			" OR col4fields like '%|*|$id' OR col4fields like '$id|*|%' OR col4fields like '%|*|$id|*|%' OR col4fields='$id'");
			$onList = $database->loadResult();
			$database->setQuery("SELECT COUNT(*) FROM #__cbe_listst".
			" WHERE sortfields LIKE '%".$obj->name."%'OR filterfields LIKE '%".$obj->name."%'");
			$onList2 = $database->loadResult();
			if($onList > 0 || $onList2 > 0) {
				$msg .= getLangDefinition($obj->title) . " cannot be deleted because it is on a List. \n";
				$noDelete = 1;
			}
			if($obj->sys==1) {
				$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is a system field. \n";
				$noDelete = 1;
			}
			if($obj->delete_able==0) {
				$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is an enhanced-function (system) field. \n";
				$noDelete = 1;
			}
			if($noDelete != 1) {
				$obj->deleteColumn('#__cbe',$obj->name);
				$obj->delete( $id );
				$sql="UPDATE #__cbe_fields SET ordering = ordering-1 WHERE ordering > ".$obj->ordering." AND tabid = ".$obj->tabid." ";
				$database->setQuery($sql);
				$database->loadResult();
				//print $database->getquery();
				$check_val = "SELECT COUNT(fieldvalueid) as counter FROM #__cbe_field_values WHERE fieldid='".$id."'";
				$database->setQuery($check_val);
				$value_count = $database->loadResult();
				if ($value_count > 0) {
					$sql_val_del ="DELETE FROM #__cbe_field_values WHERE fieldid='".$id."'";
					$database->setQuery($sql_val_del);
					if (!$database->query()) {
						echo "<script> alert('Deletetion of Values failed.'); window.history.go(-1);</script>\n";
					}
				}
//sv0.623 cbe-search start
				$database->setQuery("SELECT id FROM #__cbe_searchmanager WHERE fieldid='".$id."'");
				$s_id = $database->loadResult();
				if ($s_id != '') {
					$database->setQuery("DELETE FROM #__cbe_searchmanager WHERE fieldid='".$id."' AND id='".$s_id."'");
					if (!$database->query()) {
						echo "<script> alert('Deletetion of Values failed.'); window.history.go(-1);</script>\n";
					}
					$query="SELECT id FROM #__cbe_searchmanager ORDER BY id ASC";
					$database->setQuery($query);
					$entries = $database->loadObjectList();
				        $order=0;
				        foreach($entries AS $entry) {
				        	$database->setQuery("UPDATE #__cbe_searchmanager SET ordering = $order WHERE id='".$entry->id."'");
				        	$database->query();
				        	$order++;
				        }
				}
//sv0.623 cbe-search end
			}
			$noDelete = 0;
		}
	}
	$mainframe->redirect( "index.php?option=$option&task=showField", $msg);
}


function orderFields( $fid, $inc, $option ) {
	global $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeFields.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeFields( $database );
	$row->load( $fid );
	$row->move( $inc );
	//mosRedirect( "index2.php?option=$option&task=showField" );
	$mainframe->redirect( "index.php?option=$option&task=showField", $msg);

}


function showTab( $option ) {
	global $mainframe, $my, $mosConfig_list_limit;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$task="";
	$search="";
	if(!isset($mosConfig_list_limit)) $limit = 10;
	else $limit=$mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	if(ISSET($_POST['task'])) $task=$_POST['task'];
	if($task=='showTab') {
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
	}
	$where = array();
	if (isset( $search ) && $search!= "") {
		$where[] = "(title LIKE '%$search%')";
	}

	$database->setQuery( "SELECT COUNT(*)"
	. "\nFROM #__cbe_tabs AS a"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	);
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	$pageNav = new JPagination( $total, $limitstart, $limit  );

	$database->setQuery( "SELECT * "
	. "\nFROM #__cbe_tabs AS a"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\n ORDER BY ordering"
	. "\nLIMIT $pageNav->limitstart, $pageNav->limit"
	);

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_cbe::showTabs( $rows, $pageNav, $search, $option );
}

function editTab( $tid='0', $option='com_cbe' ) {
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeTabs.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeHTML.php');

	$my = &JFactory::getUser();
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeTabs( $database );
	// load the row from the db table
	$row->load( $tid );

	$lists = array();
	$lists['enabled'] = yesnoSelectList( 'enabled', 'class="inputbox" size="1"', $row->enabled );

	//sv0.6232 ACL by GID selection ( editList paste-over)
	$my_groups = $acl->get_object_groups( 'users', $my->id, 'ARO' );
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
	while ($i < count( $gtree )) {
//		if (in_array( $gtree[$i]->value, $ex_groups )) {
//			array_splice( $gtree, $i, 1 );
//		} else {
			$selectable[] = $gtree[$i]->value;
			$i++;
//		}
	}

	$gtree2=array();
	$gtree2[] = JHTML::_('select.option',  -2 , '- Everybody -' );
	$gtree2[] = JHTML::_('select.option',  -1, '- All Registered Users -' );
	$gtree2 = array_merge( $gtree2, $acl->get_group_children_tree( null, 'USERS', false ));

	if ($row->aclgroups == '') {
		$row->aclgroups = '-2';
	}
	$usergids=explode(",",$row->aclgroups);
	$ugids = array();
	foreach($usergids as $usergid) {
		$ugids[]->value=$usergid;
	}

	$lists['aclgroupsL'] = moscbeHTML::selectList( $gtree2, 'aclgroupsL', 'size="4" MULTIPLE onblur="loadUGIDs(this);" mosReq=1 mosLabel="User Groups" id="aclgroupsL"', 'value', 'text', $ugids,1 );
	//

	$tabnid = array();
	$tabnid[] = JHTML::_('select.option',  '-1', _UE_PROFILETAB );

	$database->setQuery("SELECT tabid, title FROM #__cbe_tabs WHERE is_nest=1 AND enabled=1 AND nested=0 ORDER BY ordering ASC");
	$nest_tab_list = $database->loadObjectList();
	if (count($nest_tab_list) != 0) {
		foreach ($nest_tab_list as $nest_tab) {
			$tabnid[] = JHTML::_('select.option',  $nest_tab->tabid, getLangDefinition($nest_tab->title) );
		}
	}

	$q_bind_sel = array();
	$q_bind_sel[] = JHTML::_('select.option', 'AND', 'AND');
	$q_bind_sel[] = JHTML::_('select.option', 'OR', 'OR');

	$lists['is_nest'] = yesnoSelectList( 'is_nest', 'class="inputbox" size="1" onChange="checkNest(this);" onBlur="checkNest(this);" id="is_nest"', $row->is_nest );
	$lists['nested'] = yesnoSelectList( 'nested', 'class="inputbox" size="1" onChange="checkNest(this);" onBlur="checkNest(this);" id="nested"', $row->nested );
	$lists['nest_id'] = JHTML::_('select.genericlist',  $tabnid, 'nest_id', 'class="inputbox" size="1"', 'value', 'text', $row->nest_id );
	$lists['q_bind'] = JHTML::_('select.genericlist',  $q_bind_sel, 'q_bind', 'class="inputbox" size="1"', 'value', 'text', $row->q_bind );

	HTML_cbe::edittab( $row, $option, $lists, $tid );
}

function saveTab( $option ) {
	global $my, $mainframe;
	global $mosConfig_live_site;

	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeTabs.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/ue_config.php" );
	$row = new moscbeTabs( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	//JFilterOutput::objectHTMLSafe($row);
	JFilterOutput::objectHTMLSafe( $row);

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}

	$row->checkin();
	$limit = intval(JArrayHelper::getValue( $_REQUEST, 'limit', 0));
	//$limit = intval( JArrayHelper::getValue( $_REQUEST, 'limit', 10 ) );
	//$limitstart	= intval( JArrayHelper::getValue( $_REQUEST, 'limitstart', 0 ) );
	$limitstart	= intval( JArrayHelper::getValue( $_REQUEST, 'limitstart', 0 ) );
	//mosRedirect( "index2.php?option=$option&task=showTab" );
	$mainframe->redirect( "index.php?option=$option&task=showTab");

}

function removeTabs( $cid, $option, $ret=null ) {
	global $mainframe;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeTabs.php');
	//die(print_r($_REQUEST));
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new moscbeTabs( $database );
		foreach ($cid as $id) {
			$obj->load($id);
			$database->setQuery("SELECT COUNT(*) FROM #__cbe_fields WHERE tabid='$id'");
			$onField = $database->loadResult();
			if($obj->sys==1) {
				$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is a system tab. \n";
				$noDelete = 1;
			}
			if ($obj->plugin=='getContactTab') {
				$msg .= getLangDefinition($obj->title) ." cannot be deleted because it is a system tab. \n";
				$noDelete = 1;
			}
			if($onField>0) {

				$msg .= "This tab is being referenced by an existing field and cannot be deleted!";
				$noDelete = 1;
			}
			if(!empty($obj->tabname)) {
				// hier wird der tab gelöscht, danach alle files in dem ordner löschen
				deleteTabDirectory(JPATH_SITE.DS."components".DS."com_cbe".DS."enhanced".DS.$obj->tabname);
				$obj->delete( $id );
				$msg .= $obj->getError();

				// danach noch aus der cbe_extensions löschen
				$sql = "DELETE FROM #__cbe_extensions WHERE extname='" . $obj->tabname . "'";
				$database->setQuery($sql);
				if (!$database->query())
					$msg .= $database->getError();
			} else {
				$msg .= "Tab deleted";
				$obj->delete();
			}
		}
	}
	
	$limit = intval( JArrayHelper::getValue( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( JArrayHelper::getValue( $_REQUEST, 'limitstart', 0 ) );
	$retour = (!empty($ret))?"index.php?option=$option&task=$ret":"index.php?option=$option&task=showTab";
	$mainframe->redirect($retour, $msg);
}

function deleteTabDirectory($path) {
	if (!is_dir ($path))
		return -1;
	$dir = @opendir ($path);
	
	if (!$dir)
		return -2;

	while (($entry = @readdir($dir)) !== false) {
		if ($entry == '.' || $entry == '..') continue;
		if (is_dir ($path.'/'.$entry)) {
			$res = deleteTabDirectory ($path.'/'.$entry);
			if ($res == -1) {
				@closedir ($dir); // Verzeichnis schliessen
				return -2; // normalen Fehler melden
			} else if ($res == -2) { // Fehler?
				@closedir ($dir); // Verzeichnis schliessen
				return -2; // Fehler weitergeben
			} else if ($res == -3) { // nicht unterstuetzer Dateityp?
				@closedir ($dir); // Verzeichnis schliessen
				return -3; // Fehler weitergeben
			} else if ($res != 0) { // das duerfe auch nicht passieren...
				@closedir ($dir); // Verzeichnis schliessen
				return -2; // Fehler zurueck
			}
		} else if (is_file ($path.'/'.$entry) || is_link ($path.'/'.$entry)) {
			$res = @unlink ($path.'/'.$entry);
			if (!$res) {
				@closedir ($dir); // Verzeichnis schliessen
				return -2; // melde ihn
			}
		} else {
			@closedir ($dir); // Verzeichnis schliessen
			return -3; // tut mir schrecklich leid...
		}
	}
	@closedir ($dir);
	$res = @rmdir ($path);
	if (!$res) {
		return -2; // melde ihn
	}
	return 0;
}


function orderTabs( $tid, $inc, $option ) {
	global $mainframe;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeTabs.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new moscbeTabs( $database );
	$row->load( $tid );
	$row->move( $inc );
	$mainframe->redirect( "index.php?option=$option&task=showTab");
}

/////////////////////////////
function saveOrder( &$cid, $row, $listtype, $cond_trans ) {
	global $_POST;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$total		= count( $cid );
	if (function_exists('josGetArrayInts'))
		$order	= josGetArrayInts( 'order' );
	else
		$order	= JArrayHelper::getValue( $_POST, 'order', array(0) );

	if ($listtype == '-null-') {
		return;
	}
	
	$conditions = array();
	$old_cids = array();

	// update ordering values
	for( $i=0; $i < $total; $i++ ) {
		$row->load( (int) $cid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store((int) $cid[$i])) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			}
			$old_cids[] = $cid[$i];
			// remember to updateOrder this group
			if ($cond_trans) {
				$condition = '';
				//$condition = $cond_trans;
				eval($cond_trans);
			}
			$found = false;
			foreach ( $conditions as $cond )
				if ($cond[1]==$condition) {
					$found = true;
					break;
				} 
			if (!$found) $conditions[] = array((int) $cid[$i], $condition);
		} 
	} 

	// execute updateOrder for each group
	if ($cond_trans) {
		foreach ( $conditions as $cond ) {
			$row->load( $cond[0] );
			//$row->updateOrder( $cond[1], $old_cids );
		}
	} elseif ($old_cids) {
		$row->load( $old_cids[0] );
		$row->updateOrder( null, $old_cids );
	}
	
	$msg 	= _UE_CBE_BE_NEW_ORDER_SAVED;
	//if ($listtype=='showTabs') {
	//	mosRedirect( 'index2.php?option=com_cbe&task=showTab', $msg );
	//}
	return $msg;
} 
////////////////////////////

function showUsers( $option ) {
	global $mainframe, $my, $mosConfig_list_limit,$_POST;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$task="";
	$search="";
	$sort="";
	if(!isset($mosConfig_list_limit)) $limit = 10;
	else $limit=$mosConfig_list_limit;
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	if(ISSET($_POST['task'])) $task=$_POST['task'];
	if($task=='showusers') {
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
		$sort = $mainframe->getUserStateFromRequest( "sort{$option}", 'sort', '' );
		$sort = $database->getEscaped( trim( strtolower( $sort ) ) );
	}
	$where = array();
	if (isset( $search ) && $search!= "") {
		$where[] = "(a.username LIKE '%$search%' OR a.email LIKE '%$search%' OR a.name LIKE '%$search%' OR ue.last_ip LIKE '%$search%')";
	}
	if (isset( $sort ) && $sort!= "") {
		if ($sort == 'unconfirmed') {
			$where[] = "(ue.confirmed = '0' AND a.id=ue.id)";
		} else if ($sort == 'unapproved') {
			$where[] = "(ue.approved = '0' AND a.id=ue.id)";
		} else if ($sort == 'blocked') {
			$where[] = "(a.block = '1' AND a.id=ue.id)";
		}
	}


	// exclude any child group id's for this user
	//$acl->_debug = true;
	$acl =& JFactory::getACL();
	$pgids = $acl->get_group_children( $my->gid, 'ARO', 'RECURSE' );

	if (is_array( $pgids ) && count( $pgids ) > 0) {
		$where[] = "(a.gid NOT IN (" . implode( ',', $pgids ) . "))";
	}

	$database->setQuery( "SELECT COUNT(*)"
	. "\nFROM #__users AS a, #__cbe as ue"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "\nWHERE a.id = ue.id")
	);
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	//$pageNav = new mosPageNav( $total, $limitstart, $limit  );
	$pageNav = new JPagination($total, $limitstart, $limit);
	/*	
	$database->setQuery( "SELECT DISTINCT a.*, g.name AS groupname, s.userid AS loggedin,ue.approved,ue.confirmed,ue.avatarapproved, ue.id as cbe_user "
	. "\nFROM #__users AS a"
	. "\nLEFT JOIN #__cbe AS ue ON a.id = ue.id"
	. "\nINNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"	// map user to aro
	. "\nINNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.aro_id"	// map aro to group
	. "\nINNER JOIN #__core_acl_aro_groups AS g ON g.group_id = gm.group_id"
	. "\n LEFT JOIN #__session AS s ON s.userid = a.id"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\nLIMIT $pageNav->limitstart, $pageNav->limit"
	);
	*/
	$database->setQuery( "SELECT DISTINCT a.*, g.name AS groupname, s.userid AS loggedin,ue.approved,ue.confirmed,ue.avatar,ue.avatarapproved, ue.id as cbe_user "
	. "\nFROM #__users AS a"
	. "\nLEFT JOIN #__cbe AS ue ON a.id = ue.id"
	. "\nINNER JOIN #__core_acl_aro AS aro ON aro.value = a.id"	// map user to aro
	. "\nINNER JOIN #__core_acl_groups_aro_map AS gm ON gm.aro_id = aro.id"	// map aro to group
	. "\nINNER JOIN #__core_acl_aro_groups AS g ON g.id = gm.group_id"
	. "\n LEFT JOIN #__session AS s ON s.userid = a.id"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. "\nLIMIT $pageNav->limitstart, $pageNav->limit"
	);

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	HTML_cbe::showUsers( $rows, $pageNav, $search, $option, $sort );
}

function editUser( $uid='0', $option='users' ) {
	global $ueConfig, $mainframe, $my;
	$database = &JFactory::getDBO();
	$database->setQuery( "SELECT * FROM #__cbe c, #__users u WHERE c.id=u.id AND c.id='".$uid."'");
	$users = $database->loadObjectList();
	$user = $users[0];

	HTML_cbe::edituser( $user, $option, $uid, $params );
}

function saveUser( $option ) {
	global $mainframe;
	//die(print_r($_POST));
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeGeoObj.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'astro.php');

	global $mosConfig_live_site,$_POST,$ueConfig, $enhanced_Config;
	include_once( "components/com_cbe/ue_config.php" );
	//$row = new JTableUser( $database );
	$row = new JTableUser($database);
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$isNew = !$row->id;
	$pwd = '';
	if ($isNew) {
		// new user stuff
		if ($row->password == '') {
			jimport('joomla.user.helper');
			$pwd = JUserHelper::genRandomPassword();
			$row->password = md5( $pwd );
		} else {
			$pwd = $row->password;
			$row->password = md5( $row->password );
		}
		$row->registerDate = date("Y-m-d H:i:s");
	} else {
		// existing user stuff
		if ($row->password == '') {
			// password set to null if empty
			$row->password = null;
		} else {
			$row->password = md5( $row->password );
		}
	}

	SWITCH ($ueConfig['name_style']) {
		case 2:
		$row->name = $_POST['firstname'] . ' ' . $_POST['lastname'];
		break;
		case 3:
		if(isset($_POST['middlename'])) $row->name = $_POST['firstname'] . ' ' . $_POST['middlename']. ' ' . $_POST['lastname'];
		else $row->name = $_POST['firstname']. ' ' . $_POST['lastname'];
		break;
	}

// pk edit name override
	if ($row->name == '' || $row->name == ' ' || $row->name == '  ') {
		$row->name = "dummy user";
	} else {
		echo "tilt3 <br>";
	}
// pk end
// Joomla related
	// save usertype to usetype column
	$query = "SELECT name"
	. "\n FROM #__core_acl_aro_groups"
	. "\n WHERE id = $row->gid"
	;
	$database->setQuery( $query );
	$usertype = $database->loadResult();
	$row->usertype = $usertype;

	// save params
	$params = JArrayHelper::getValue( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ( $params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$row->params = implode( "\n", $txt );
	}
// Joomla end

	JFilterOutput::objectHTMLSafe($row);
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}

	$sqlFormat = "Y-m-d";
	$selFields = '';
	$database->setQuery( "SELECT f.* FROM #__cbe_fields f, #__cbe_tabs t"
	. "\n WHERE f.published=1 and f.tabid = t.tabid AND t.enabled=1" );
	$rowFields = $database->loadObjectList();

	if(!$_POST['id'] > 0) {
		$database->setQuery("SELECT id FROM #__users WHERE username = '".$_POST['username']."'");
		$uid = $database->loadResult();
		$sqlType = 'I';
	} else {
		$uid = $row->id;
		$sqlType = 'U';
	}
	//$colList = "`id`, `user_id`, `approved`, `confirmed`, `firstname`, `middlename`, `lastname`";
	//$valueList = "'$uid','$uid','".$_POST['approved']."','".$_POST['confirmed']."','".$_POST['firstname']."','".$_POST['middlename']."','";
	$colList = "`id`, `user_id`,  `firstname`, `middlename`, `lastname`";
	$valueList = "'$uid','$uid','".$_POST['firstname']."','".$_POST['middlename']."','";

	if ($ueConfig['name_style'] == 1) {
		$valueList .= cbGetEscaped($_POST['name'])."'";
	} else {
		$valueList .= cbGetEscaped($_POST['lastname'])."'";
	}
	if(count($rowFields) > 0) {
		for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
			if($i > 0 && ($rowFields[$i]->type !='geo_calc_dist' && $rowFields[$i]->type!='cbe_calced_age')) $selFields .=", ";
			switch($rowFields[$i]->type) {
				CASE 'date':
				CASE 'birthdate':
				$selFields .= "`".$rowFields[$i]->name."`='".dateConverter($database->getEscaped($_POST[$rowFields[$i]->name]),$ueConfig[date_format],$sqlFormat)."' ";
				$colList .= ", `".$rowFields[$i]->name."`";
				$valueList .= ", '".dateConverter($database->getEscaped($_POST[$rowFields[$i]->name]),$ueConfig[date_format],$sqlFormat)."'";
				break;

				CASE 'dateselect':
				CASE 'dateselectrange':
				 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".dateConverter(cbGetEscaped($_POST[$rowFields[$i]->name."_hid"]),$ueConfig['date_format'],$sqlFormat)."' ";
				 $colList .= ", `".$rowFields[$i]->name."`";
				 $valueList .= ", '".dateConverter($database->getEscaped($_POST[$rowFields[$i]->name."_hid"]),$ueConfig[date_format],$sqlFormat)."'";
				break;

				CASE 'webaddress':
				CASE 'emailaddress':
				$selFields .= "`".$rowFields[$i]->name."`='".str_replace(array('mailto:','http://','https://'),'',cbGetEscaped($_POST[$rowFields[$i]->name]))."' ";
				$colList .= ", `".$rowFields[$i]->name."`";
				$valueList .= ", '".str_replace(array('mailto:','http://','https://'),'',cbGetEscaped($_POST[$rowFields[$i]->name]))."'";
				break;
				CASE 'editorta':
				$selFields .= "`".$rowFields[$i]->name."`='".$database->getEscaped($_POST[$rowFields[$i]->name])."' ";
				$colList .= ", `".$rowFields[$i]->name."`";
				$valueList .= ", '".$database->getEscaped($_POST[$rowFields[$i]->name])."'";
				break;
				case 'multiselect':
				case 'multicheckbox':
				case 'select':
				$selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".htmlspecialchars(cbGetEscaped(implode("|*|",$_POST[$rowFields[$i]->name])))."' ";
				$colList .= ", `".$rowFields[$i]->name."`";
				$valueList .= ", '".htmlspecialchars(cbGetEscaped(implode("|*|",$_POST[$rowFields[$i]->name])))."' ";
				break;
				case 'geo_calc_dist':
				case 'cbe_calced_age':
			 	// do nothing
				break;
				DEFAULT:
				$selFields .= "`".$rowFields[$i]->name."`='".htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name]))."' ";
				$colList .= ", `".$rowFields[$i]->name."`";
				$valueList .= ", '".htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name]))."'";
				break;
			}
		}
		$selFields .= ", `lastupdatedate`='".date('Y-m-d\TH:i:s')."', `confirmed`='".cbGetEscaped($_POST['confirmed'])."', `approved`='".cbGetEscaped($_POST['approved'])."', `firstname`='".cbGetEscaped($_POST['firstname'])."', `middlename`='".cbGetEscaped($_POST['middlename'])."',";
		if ($ueConfig['name_style'] == 1) {
			$selFields .= " `lastname`='".cbGetEscaped($_POST['name'])."'";
		} else {
			$selFields .= " `lastname`='".cbGetEscaped($_POST['lastname'])."'";
		}
		$selFields .= ", `avatarapproved`='".cbGetEscaped($_POST['avatarapproved'])."'";
		if($sqlType == 'U') $sql = "UPDATE #__cbe SET ".$selFields." WHERE `id`='".$row->id."'";
		else $sql = "INSERT INTO #__cbe (".$colList.") VALUES (".$valueList.")";
		$database->setQuery( $sql );
		//print $database->getquery();
		if (!$database->query()) {
			die("SQL error" . $database->stderr(true));
		}
	}
	// update the ACL

	if ($isNew) {
	} else {
		$database->setQuery( "SELECT aro_id FROM #__core_acl_aro WHERE value='$row->id'" );
		$aro_id = $database->loadResult();

		$database->setQuery( "UPDATE #__core_acl_groups_aro_map"
		. "\nSET group_id = '$row->gid'"
		. "\nWHERE aro_id = '$aro_id'"
		);
		$database->query() or die( $database->stderr() );
	}

	$row->checkin();
	if ($isNew) {
		//TODO: Add emails configuration code.
		$database->setQuery( "SELECT email FROM #__users WHERE id=$my->id" );
		$adminEmail = $database->loadResult();
		$subject = "New User Details";
		$pwd_clear = $pwd;
		$message = '';
		$message = replaceVariables(_UE_CBE_UM_USERMAIL_ON_ADMIN_ADD,$row,0,$ueConfig,$pwd_clear);
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain; "._ISO."\r\n";
		$headers .= "From: $adminEmail\r\n";
		$headers .= "Reply-To: $adminEmail\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-MSMail-Priority: Low\r\n";
		$headers .= "X-Mailer: Mambo Open Source 4.5\r\n";
		JUTility::sendMail($adminEmail, $adminEmail, $row->email,$subject, $message);

	}

	// PK edit Zodiac
	if ($isNew) {
		$database->setQuery("SELECT id FROM #__users WHERE username = '".$row->username."'");
		$cbeuid = $database->loadResult();
		if (!$row->id) {
			$row->id = $cbeuid;
		}
	}
	if ($enhanced_Config['show_zodiacs'] == '1' || $enhanced_Config['show_zodiacs_ch'] == '1') {
		$birthday_field = $enhanced_Config['lastvisitors_birthday_field'];
		$query = "SELECT ".$birthday_field." FROM #__cbe WHERE id='".$row->id."'";
		$database->setQuery($query);
		$birthday = $database->loadResult();
		
		if($birthday =="0000-00-00")
		{
			$user_zodiac = '_UE_ZODIAC_NO';
			$user_zodiac_chinese = '_UE_ZODIAC_NO';
		} else {
			$person = new astro($birthday);
			if ($enhanced_Config['show_zodiacs_static'] == '1') {
				$user_zodiac = $person->chaldeanSignStatic;
			} else {
				$user_zodiac = $person->chaldeanSign;
			}
			$user_zodiac_chinese = $person->chineseSign;
		}

		if ($enhanced_Config['show_zodiacs'] == '1' || $enhanced_Config['show_zodiacs_ch'] == '1') {
			$query_z = "UPDATE #__cbe SET zodiac='".$user_zodiac."' WHERE id='".$row->id."'";
			$database->setQuery($query_z);
			if (!$database->query()) {
			//	echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			//	exit();
			}
		
			$query_zch = "UPDATE #__cbe SET zodiac_c='$user_zodiac_chinese' WHERE id='".$row->id."'";
			$database->setQuery($query_zch);
			if (!$database->query()) {
			//	echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			//	exit();
			}
		}
	}

	$cbe_GeoObj = new moscbeGeoObj($database);
	$cbe_GeoObj->load($row->id);
	if (!$cbe_GeoObj->bind( $_POST )) {
		echo "<script> alert('".$cbe_GeoObj->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if ($cbe_GeoObj->check() == 1 || $cbe_GeoObj->check() == 3) {
		if (!$cbe_GeoObj->store($row->id)) {
			echo "<script> alert('store:".$cbe_GeoObj->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if ($enhanced_Config['geocoder_do_export'] == '1') {
			$exp_query = "UPDATE #__cbe SET cb_geolatitude='".$cbe_GeoObj->GeoLat."', cb_geolongitude='".$cbe_GeoObj->GeoLng."' WHERE id='".$uid."'";
			$database->setQuery($exp_query);
			if (!$database->query()) {
				//
			}
		}
	}
	// PK

	$limit = intval( JArrayHelper::getValue( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( JArrayHelper::getValue( $_REQUEST, 'limitstart', 0 ) );
	//mosRedirect( "index2.php?option=$option&task=showusers" );
	$mainframe->redirect( "index.php?option=$option&task=showusers");

}

function removeUsers( $cid, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbe.php');

	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new JTableUser( $database );
		$obj2 = new moscbe( $database );
		$msg .= "Deleted User-ID(s) : ";
		foreach ($cid as $id) {
			// check for a super admin ... can't delete them
			$groups = $acl->get_object_groups( 'users', $id, 'ARO' );
			$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
			if ($this_group == 'super administrator') {
				$msg .= "You cannot delete a Super Administrator";
			} else {
				$database->setQuery("SELECT username FROM #__users where id='".$id."'");
				$del_username = $database->loadResult();
				$obj->delete( $id );
				$obj2->load( $id );
				if(eregi("gallery/",$obj2->avatar)==false && is_file(JPATH_SITE."/images/cbe/".$obj2->avatar)) {
					unlink(JPATH_SITE."/images/cbe/".$obj2->avatar);
					if(is_file(JPATH_SITE."/images/cbe/tn".$obj2->avatar)) {
						unlink(JPATH_SITE."/images/cbe/tn".$obj2->avatar);
					}
				}
				$obj2->delete( $id );
				$msg .= $obj->getError();
				$msg .= $obj2->getError();
				$database->setQuery("DELETE FROM #__cbe_buddylist WHERE buddyid='$id' OR userid='$id'");
				if (!$database->query()) {
					//$msg .= "Buddylist entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_mambome_gbook WHERE by_user='$id' OR userid='$id'");
				if (!$database->query()) {
					//$msg .= "Guestbook entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_mambome_journal WHERE userid='$id'");
				if (!$database->query()) {
					//$msg .= "Journal entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_profile_comments WHERE by_user='$id' OR userid='$id'");
				if (!$database->query()) {
					//$msg .= "Comment entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_ratings WHERE profile='$id'");
				if (!$database->query()) {
					//$msg .= "Rating entry could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_testimonials WHERE by_user='$id' OR userid='$id'");
				if (!$database->query()) {
					//$msg .= "Testimonials entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_userreports WHERE reporteduser='$id' OR reportedbyuser='$id'");
				if (!$database->query()) {
					//$msg .= "UserReport entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_lastvisitor WHERE uid='$id' OR visitor='$id'");
				if (!$database->query()) {
					//$msg .= "LastVisitor entries could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_userstime WHERE userid='$id'");
				if (!$database->query()) {
					//$msg .= "TopMostUser data could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_authorlist WHERE userid='$id'");
				if (!$database->query()) {
					//$msg .= "Authorlist data could not be deleted, maybe there are no.<br>\n";
				}
				$database->setQuery("DELETE FROM #__cbe_geodata WHERE uid='$id'");
				if (!$database->query()) {
					//$msg .= "GeoCoder data could not be deleted, maybe there are no.<br>\n";
				}
				$msg .= $id." (".$del_username.") | ";
			}
		}
	}

	$limit = intval( JArrayHelper::getValue( $_REQUEST, 'limit', 10 ) );
	$limitstart	= intval( JArrayHelper::getValue( $_REQUEST, 'limitstart', 0 ) );
	//mosRedirect( "index2.php?option=$option&task=showusers", $msg );
	$mainframe->redirect( "index.php?option=$option&task=showusers", 0);

}

/**
* Blocks or Unblocks one or more user records
* @param array An array of unique category id numbers
* @param integer 0 if unblock, 1 if blocking
* @param string The current url option
*/
function changeUserBlock( $cid=null, $block=1, $option ) {
	global $my, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $block ? 'block' : 'unblock';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__users SET block='$block'"
	. "\nWHERE id IN ($cids)"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	//mosRedirect( "index2.php?option=$option&task=showusers" );
	$mainframe->redirect( "index.php?option=$option&task=showusers");

}

function approveAvatar( $cid=null, $avatarapproved=1, $option ) {
	global $my, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	if (count( $cid ) < 1) {
		$action = $avatarapproved ? 'approve' : 'disapprove';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );
	//die("hier bin ich..., $cids, $avatarapproved, $option");

	$database->setQuery( "UPDATE #__cbe SET avatarapproved='$avatarapproved' WHERE id IN ($cids)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect( "index.php?option=$option&task=showusers");

}

function confirmUser( $cid=null, $confirmedUser=1, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	if (count( $cid ) < 1) {
		$action = $confirmedUser ? 'confirm' : 'disconfirm';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );
	//die("hier bin ich..., $cids, $avatarapproved, $option");

	$database->setQuery( "UPDATE #__cbe SET confirmed='$confirmedUser' WHERE id IN ($cids)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect( "index.php?option=$option&task=showusers");

}


function is_email($email){
	$rBool=false;

	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
		$rBool=true;
	}
	return $rBool;
}
function showConfig( $option ) {
	global $ueConfig,$my;//,JPATH_SITE;
	global $mosConfig_lang;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$database = &JFactory::getDBO();

	$configfile = "components/com_cbe/ue_config.php";
	@chmod ($configfile, 0766);
	$permission = is_writable($configfile);
	if (!$permission) {
		echo "<center><h1><font color=red>Warning...</FONT></h1><BR>";
		echo "<B>Your config file is /administrator/$configfile</b><BR>";
		echo "<B>You need to chmod this to 766 in order for the config to be updated</B></center><BR><BR>";
	}

	//include_once( $configfile );

	$lists = array();
	// make a standard yes/no list
	$yesno = array();
	$yesno[] = JHTML::_('select.option', '0', _UE_NO );
	$yesno[] = JHTML::_('select.option',  '1', _UE_YES );

	$mypms[] = JHTML::_('select.option',  '0', _UE_NO );
	$mypms[] = JHTML::_('select.option',  '1', 'MyPMS-OS 2.1x' );
	$mypms[] = JHTML::_('select.option',  '2', 'MyPMS-PRO' );
	$mypms[] = JHTML::_('select.option',  '3', 'MyPMS-OS 2.5 alpha or higher' );
	$mypms[] = JHTML::_('select.option',  '4', 'MyPMS-Enhanced 1.2.x to 1.3.x' );
	$mypms[] = JHTML::_('select.option',  '9', 'MyPMS-Enhanced 2.x or higher' );
	$mypms[] = JHTML::_('select.option',  '5', 'uddeIM 0.4 or higher' );
	$mypms[] = JHTML::_('select.option',  '6', 'Missus 1.0 beta2' );
	$mypms[] = JHTML::_('select.option',  '7', 'Clexus 1.2.1 or higher' );
	$mypms[] = JHTML::_('select.option',  '8', 'Jim 1.0.1 or higher' );
	// 9 myPMS-Enh 2.x
	
	$x_mailer[] = JHTML::_('select.option',  '0', 'PHP' );
	$x_mailer[] = JHTML::_('select.option',  '1', 'Outlook' );

	$dateformats = array();
	$dateformats[] = JHTML::_('select.option', 'Y/m/d','yyyy/mm/dd');
	$dateformats[] = JHTML::_('select.option', 'd/m/y','dd/mm/yy');
	$dateformats[] = JHTML::_('select.option', 'y/m/d','yy/mm/dd');
	$dateformats[] = JHTML::_('select.option', 'd/m/Y','dd/mm/yyyy');
	$dateformats[] = JHTML::_('select.option', 'm/d/y','mm/dd/yy');
	$dateformats[] = JHTML::_('select.option', 'm/d/Y','mm/dd/yyyy');
	$dateformats[] = JHTML::_('select.option', 'Y-m-d','yyyy-mm-dd');
	$dateformats[] = JHTML::_('select.option', 'd-m-y','dd-mm-yy');
	$dateformats[] = JHTML::_('select.option', 'y-m-d','yy-mm-dd');
	$dateformats[] = JHTML::_('select.option', 'd-m-Y','dd-mm-yyyy');
	$dateformats[] = JHTML::_('select.option', 'm-d-y','mm-dd-yy');
	$dateformats[] = JHTML::_('select.option', 'm-d-Y','mm-dd-yyyy');
	$dateformats[] = JHTML::_('select.option', 'Y.m.d','yyyy.mm.dd');
	$dateformats[] = JHTML::_('select.option', 'd.m.y','dd.mm.yy');
	$dateformats[] = JHTML::_('select.option', 'y.m.d','yy.mm.dd');
	$dateformats[] = JHTML::_('select.option', 'd.m.Y','dd.mm.yyyy');
	$dateformats[] = JHTML::_('select.option', 'm.d.y','mm.dd.yy');
	$dateformats[] = JHTML::_('select.option', 'm.d.Y','mm.dd.yyyy');

	$nameformats = array();
	$nameformats[] = JHTML::_('select.option', '1','Name Only');
	$nameformats[] = JHTML::_('select.option', '2','Name (username)');
	$nameformats[] = JHTML::_('select.option', '3','Username Only');
	$nameformats[] = JHTML::_('select.option', '4','Username (Name)');
	$nameformats[] = JHTML::_('select.option', '8','Username (Firstname)');
	$nameformats[] = JHTML::_('select.option', '5','Username (Lastname, Firstname)');
	$nameformats[] = JHTML::_('select.option', '6','Lastname, Firstname only');
	$nameformats[] = JHTML::_('select.option', '7','Lastname, Firstname (Username)');

	$username_min[] = JHTML::_('select.option', '2','2');
	$username_min[] = JHTML::_('select.option', '3','3');
	$username_min[] = JHTML::_('select.option', '4','4');
	
	$username_max[] = JHTML::_('select.option', '4','4');
	$username_max[] = JHTML::_('select.option', '5','5');
	$username_max[] = JHTML::_('select.option', '6','6');
	$username_max[] = JHTML::_('select.option', '7','7');
	$username_max[] = JHTML::_('select.option', '8','8');
	$username_max[] = JHTML::_('select.option', '9','9');
	$username_max[] = JHTML::_('select.option', '10','10');
	$username_max[] = JHTML::_('select.option', '12','12');
	$username_max[] = JHTML::_('select.option', '15','15');
	$username_max[] = JHTML::_('select.option', '20','20');
	$username_max[] = JHTML::_('select.option', '25','25');
	$username_max[] = JHTML::_('select.option', '30','30');
	$username_max[] = JHTML::_('select.option', '35','35');
	$username_max[] = JHTML::_('select.option', '40','40');
	$username_max[] = JHTML::_('select.option', '45','45');
	$username_max[] = JHTML::_('select.option', '50','50');
	$username_max[] = JHTML::_('select.option', '55','55');
	$username_max[] = JHTML::_('select.option', '60','60');

	$password_min[] = JHTML::_('select.option', '4','4');
	$password_min[] = JHTML::_('select.option', '6','6');
	$password_min[] = JHTML::_('select.option', '8','8');
	$password_min[] = JHTML::_('select.option', '10','10');
	$password_min[] = JHTML::_('select.option', '12','12');
	$password_min[] = JHTML::_('select.option', '16','16');

	$conversiontype = array();
	$conversiontype[] = JHTML::_('select.option', '1','ImageMagick');
	$conversiontype[] = JHTML::_('select.option', '2','NetPBM');
	$conversiontype[] = JHTML::_('select.option', '3','GD1 library');
	$conversiontype[] = JHTML::_('select.option', '4','GD2 library');

	$namestyles = array();
	$namestyles[] = JHTML::_('select.option', '1','Single Name Field');
	$namestyles[] = JHTML::_('select.option', '2','First and Last Name Field');
	$namestyles[] = JHTML::_('select.option', '3','First, Middle, and Last Name Field');

	$emailhandling = array();
	$emailhandling[] = JHTML::_('select.option', '1','Display Email Only');
	$emailhandling[] = JHTML::_('select.option', '2','Display Email w/ MailTo link');
	$emailhandling[] = JHTML::_('select.option', '3','Display Link to Email Form');
	$emailhandling[] = JHTML::_('select.option', '4','Do Not Display Email');

	$nrrowsgallery = array();
	$nrrowsgallery[]= JHTML::_('select.option', '2','2');
	$nrrowsgallery[]= JHTML::_('select.option', '3','3');
	$nrrowsgallery[]= JHTML::_('select.option', '4','4');
	$nrrowsgallery[]= JHTML::_('select.option', '5','5');
	$nrrowsgallery[]= JHTML::_('select.option', '6','6');

	$nrrowuserslist = array();
	$nrrowuserslist[]= JHTML::_('select.option', '1','1');
	$nrrowuserslist[]= JHTML::_('select.option', '2','2');
	$nrrowuserslist[]= JHTML::_('select.option', '3','3');
	$nrrowuserslist[]= JHTML::_('select.option', '4','4');
	$nrrowuserslist[]= JHTML::_('select.option', '5','5');
	$nrrowuserslist[]= JHTML::_('select.option', '6','6');
	$nrrowuserslist[]= JHTML::_('select.option', '7','7');
	$nrrowuserslist[]= JHTML::_('select.option', '8','8');
	$nrrowuserslist[]= JHTML::_('select.option', '9','9');
	$nrrowuserslist[]= JHTML::_('select.option', '10','10');
	
	$stampsize = array();
	$stampsize[] = JHTML::_('select.option', '1','1');
	$stampsize[] = JHTML::_('select.option', '2','2');
	$stampsize[] = JHTML::_('select.option', '3','3');
	$stampsize[] = JHTML::_('select.option', '4','4');
	$stampsize[] = JHTML::_('select.option', '5','5');

	$inc_js_switch = array();
	$inc_js_switch[] = JHTML::_('select.option', '2','Javascript by tag');
	$inc_js_switch[] = JHTML::_('select.option', '1','include in page-source');

	$watermarkpath = JPATH_SITE.'/images/cbe/watermark';
	$watermarkfiles = array();
	$wm_files = array();
	$watermarkfiles = display_watermarks($watermarkpath);
	for($i = 0; $i < count($watermarkfiles); $i++) {
		$wm_files[] = JHTML::_('select.option', $watermarkfiles[$i],$watermarkfiles[$i]);
	}

	// ensure user can't add group higher than themselves

	$acl =& JFactory::getACL();
	$my_groups = $acl->get_object_groups( 'users', $my->id, 'ARO' );
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
	while ($i < count( $gtree )) {
		if (in_array( $gtree[$i]->value, $ex_groups )) {
			array_splice( $gtree, $i, 1 );
		} else {
			$i++;
		}
	}

	$i = 0;
	$gtree_acl = array();
	while ($i < count($gtree)) {
	        $gtree_acl[] = $gtree[$i]->value;
	        $i++;
	}

	$gtree2=array();
	$gtree2[] = JHTML::_('select.option',  -2 , '- Everybody -' );
	$gtree2[] = JHTML::_('select.option',  -1, '- All Registered Users -' );
	$gtree2 = array_merge( $gtree2, $acl->get_group_children_tree( null, 'USERS', false ));
	//print_r($gtree);

//	if($my_groups[0] >= $ueConfig['imageApproverGid']) {
	if (in_array($ueConfig['imageApproverGid'], $gtree_acl)) {
		$lists['imageApproverGid'] = JHTML::_('select.genericlist', $gtree, 'cfg_imageApproverGid', 'size="4"', 'value', 'text', $ueConfig['imageApproverGid'] );
	} else {
		$lists['imageApproverGid']="<b>".$acl->get_group_name($ueConfig['imageApproverGid'])."</b>\n<input type='hidden' name='cfg_imageApproverGid' value='".$ueConfig['imageApproverGid']."' />";
	}

	$lists['allow_profileviewbyGID']=JHTML::_('select.genericlist',  $gtree2, 'cfg_allow_profileviewbyGID', 'size="4"', 'value', 'text', $ueConfig['allow_profileviewbyGID'] );
	$lists['allow_listviewbyGID']=JHTML::_('select.genericlist',  $gtree2, 'cfg_allow_listviewbyGID', 'size="4"', 'value', 'text', $ueConfig['allow_listviewbyGID'] );
	// registered users only
	$tempdir = array();
	$templates=cbReadDirectory(JPATH_SITE."/components/com_cbe/templates/");
	foreach ($templates AS $template) {
		if($template!='images') $tempdir[]=JHTML::_('select.option',  $template , $template );
	}

	$lists['name_style'] = JHTML::_('select.genericlist', $namestyles, 'cfg_name_style','class="inputbox" size="1"', 'value', 'text', $ueConfig['name_style'] );
	$lists['name_format'] = JHTML::_('select.genericlist', $nameformats, 'cfg_name_format','class="inputbox" size="1"', 'value', 'text', $ueConfig['name_format'] );
	$lists['date_format'] = JHTML::_('select.genericlist', $dateformats, 'cfg_date_format','class="inputbox" size="1"', 'value', 'text', $ueConfig['date_format'] );
	$lists['uname_pathway'] = JHTML::_('select.genericlist',  $yesno, 'cfg_uname_pathway', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['uname_pathway'] );
	$lists['allow_email_display'] = JHTML::_('select.genericlist',  $emailhandling, 'cfg_allow_email_display', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_email_display'] );
	$lists['allow_email'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_email', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_email'] );
	$lists['allow_onlinestatus'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_onlinestatus', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_onlinestatus'] );
	$lists['allow_website'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_website', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_website'] );
	$lists['show_jeditor'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_jeditor', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['show_jeditor'] );
	$lists['cbedologin'] = JHTML::_('select.genericlist',  $yesno, 'cfg_cbedologin', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['cbedologin'] );
	$lists['switch_js_inc'] = JHTML::_('select.genericlist',  $inc_js_switch, 'cfg_switch_js_inc', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['switch_js_inc'] );

// enter min / max's
	$lists['username_min'] = JHTML::_('select.genericlist', $username_min, 'cfg_username_min','class="inputbox" size="1"', 'value', 'text', $ueConfig['username_min'] );
	$lists['username_max'] = JHTML::_('select.genericlist', $username_max, 'cfg_username_max','class="inputbox" size="1"', 'value', 'text', $ueConfig['username_max'] );
	$lists['password_min'] = JHTML::_('select.genericlist', $password_min, 'cfg_password_min','class="inputbox" size="1"', 'value', 'text', $ueConfig['password_min'] );
	$lists['generatepass_on_reg'] = JHTML::_('select.genericlist',  $yesno, 'cfg_generatepass_on_reg', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['generatepass_on_reg'] );
	$lists['emailpass_on_reg'] = JHTML::_('select.genericlist',  $yesno, 'cfg_emailpass_on_reg', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['emailpass_on_reg'] );
	$lists['user_unregister_allow'] = JHTML::_('select.genericlist',  $yesno, 'cfg_user_unregister_allow', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['user_unregister_allow'] );
	$lists['show_unregister_editmode'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_unregister_editmode', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['show_unregister_editmode'] );
	$lists['show_unregister_profilemode'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_unregister_profilemode', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['show_unregister_profilemode'] );
	$lists['unregister_send_email'] = JHTML::_('select.genericlist',  $yesno, 'cfg_unregister_send_email', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['unregister_send_email'] );
	$lists['unregister_moderatorEmail'] = JHTML::_('select.genericlist',  $yesno, 'cfg_unregister_moderatorEmail', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['unregister_moderatorEmail'] );
	$lists['reg_enable_toc'] = JHTML::_('select.genericlist',  $yesno, 'cfg_reg_enable_toc', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_enable_toc'] );
	$lists['reg_enable_datasec'] = JHTML::_('select.genericlist',  $yesno, 'cfg_reg_enable_datasec', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_enable_datasec'] );
	$lists['admin_approval'] = JHTML::_('select.genericlist',  $yesno, 'cfg_reg_admin_approval', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_admin_approval'] );
	$lists['confirmation'] = JHTML::_('select.genericlist',  $yesno, 'cfg_reg_confirmation', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_confirmation'] );
	$ueConfig['reg_confirmation_hash'] = floatval($ueConfig['reg_confirmation_hash']);
	$lists['set_mail_xheader'] = JHTML::_('select.genericlist',  $x_mailer, 'cfg_set_mail_xheader', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['set_mail_xheader'] );

// RegEx is enter field
	$lists['reg_useajax'] = JHTML::_('select.genericlist',  $yesno, 'cfg_reg_useajax', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_useajax'] );
	$lists['reg_useajax_button'] = JHTML::_('select.genericlist',  $yesno, 'cfg_reg_useajax_button', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['reg_useajax_button'] );
	
	$lists['search_username'] = JHTML::_('select.genericlist',  $yesno, 'cfg_search_username', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['search_username'] );
	$lists['hide_searchbox'] = JHTML::_('select.genericlist',  $yesno, 'cfg_hide_searchbox', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['hide_searchbox'] );
	$lists['hide_listsbox'] = JHTML::_('select.genericlist',  $yesno, 'cfg_hide_listsbox', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['hide_listsbox'] );
	$lists['allow_profilelink'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_profilelink', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_profilelink'] );
	$lists['allow_profile_popup'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_profile_popup', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_profile_popup'] );
	// css class usersList is editfield
	if ($ueConfig['userslist_css1'] == '') {
		$ueConfig['userslist_css1'] = 'sectiontableentry1';
	}
	if ($ueConfig['userslist_css2'] == '') {
		$ueConfig['userslist_css2'] = 'sectiontableentry2';
	}
	if ($ueConfig['userslist_rnr'] =='' || $ueConfig['userslist_rnr'] == null) {
		$ueConfig['userslist_rnr'] = '4';
	}
	$lists['userslist_rnr'] = JHTML::_('select.genericlist',  $nrrowuserslist, 'cfg_userslist_rnr', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['userslist_rnr'] );
	
	$lists['usernameedit'] = JHTML::_('select.genericlist',  $yesno, 'cfg_usernameedit', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['usernameedit'] );
	$lists['allow_mailchange'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_mailchange', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allow_mailchange'] );
	$lists['adminrequiredfields'] = JHTML::_('select.genericlist',  $yesno, 'cfg_adminrequiredfields', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['adminrequiredfields'] );
	$lists['adminshowalltabs'] = JHTML::_('select.genericlist',  $yesno, 'cfg_adminshowalltabs', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['adminshowalltabs'] );
	$lists['templatedir'] = JHTML::_('select.genericlist',  $tempdir, 'cfg_templatedir', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['templatedir'] );
	$lists['nesttabs'] = JHTML::_('select.genericlist',  $yesno, 'cfg_nesttabs', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['nesttabs'] );


	$lists['conversiontype'] = JHTML::_('select.genericlist',  $conversiontype, 'cfg_conversiontype', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['conversiontype'] );
	$lists['allowAvatar'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowAvatar', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatar'] );
	$lists['allowAvatarUpload'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowAvatarUpload', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatarUpload'] );
	$lists['allowAvatarUploadOnReg'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowAvatarUploadOnReg', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatarUploadOnReg'] );
	$lists['allowAvatarGallery'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowAvatarGallery', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowAvatarGallery'] );
	$lists['avatarUploadApproval'] = JHTML::_('select.genericlist',  $yesno, 'cfg_avatarUploadApproval', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['avatarUploadApproval'] );
	if ($ueConfig['rows_of_gallery'] =='' || $ueConfig['rows_of_gallery'] == null) {
		$ueConfig['rows_of_gallery'] = '5';
	}
	$lists['rows_of_gallery'] = JHTML::_('select.genericlist',  $nrrowsgallery, 'cfg_rows_of_gallery', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['rows_of_gallery'] );
	$lists['avatardeljs'] = JHTML::_('select.genericlist',  $yesno, 'cfg_avatardeljs', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['avatardeljs'] );
	$lists['showAvatarRules'] = JHTML::_('select.genericlist',  $yesno, 'cfg_showAvatarRules', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['showAvatarRules'] );

//sv0.6233 watermarking
	$lists['wm_force_png'] = JHTML::_('select.genericlist',  $yesno, 'cfg_wm_force_png', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_force_png'] );
	$lists['wm_force_zoom'] = JHTML::_('select.genericlist',  $yesno, 'cfg_wm_force_zoom', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_force_zoom'] );
	$lists['wm_canvas'] = JHTML::_('select.genericlist',  $yesno, 'cfg_wm_canvas', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_canvas'] );
	//$lists['wm_canvas_trans'] = JHTML::_('select.genericlist',  $yesno, 'cfg_wm_canvas_trans', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_canvas_trans'] );
	// canvas color is selection field
	$lists['wm_stampit'] = JHTML::_('select.genericlist',  $yesno, 'cfg_wm_stampit', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_stampit'] );
	//	wm_stampit_text	fillin
	$lists['wm_stampit_size'] = JHTML::_('select.genericlist',  $stampsize, 'cfg_wm_stampit_size', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_stampit_size'] );
	// stampit color is selection field
	$lists['wm_doit'] = JHTML::_('select.genericlist',  $yesno, 'cfg_wm_doit', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_doit'] );
	$lists['wm_filename'] = JHTML::_('select.genericlist',  $wm_files, 'cfg_wm_filename', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['wm_filename'] );
	//	wm_filename fillin wm_files

	$lists['allowUserReports'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowUserReports', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowUserReports'] );
	$lists['allowUserBanning'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowUserBanning', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowUserBanning'] );
	$lists['moderatorEmail'] = JHTML::_('select.genericlist',  $yesno, 'cfg_moderatorEmail', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['moderatorEmail'] );
	$lists['allowModUserApproval'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allowModUserApproval', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['allowModUserApproval'] );
	$lists['sendMailonProfileUpdate'] = JHTML::_('select.genericlist',  $yesno, 'cfg_sendMailonProfileUpdate', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['sendMailonProfileUpdate'] );


	$lists['pms'] = JHTML::_('select.genericlist',  $mypms, 'cfg_pms', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['pms'] );
	$lists['use_cbe_gallery'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_cbe_gallery', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_cbe_gallery'] );
	$lists['use_acctexp'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_acctexp', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_acctexp'] );
	$lists['use_secimages'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_secimages', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_secimages'] );
	$lists['use_secimages_lostpass'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_secimages_lostpass', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_secimages_lostpass'] );
	$lists['use_secimages_login'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_secimages_login', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_secimages_login'] );
	$lists['use_smfBridge'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_smfBridge', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_smfBridge'] );
	$lists['use_fqmulticorreos'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_fqmulticorreos', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_fqmulticorreos'] );
	$lists['use_yanc'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_yanc', 'class="inputbox" size="1"', 'value', 'text', $ueConfig['use_yanc'] );

	HTML_cbe::showConfig( $ueConfig, $lists, $option );
}

function enhancedConfig( $option )
{
	global $enhanced_Config,$ueConfig,$my;//,JPATH_SITE;
	global $mosConfig_lang;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/enhanced_admin/enhanced_config.php" );
	$configfile = "components/com_cbe/enhanced_admin/enhanced_config.php";
	@chmod ($configfile, 0766);
	$permission = is_writable($configfile);
	if (!$permission) {
		echo "<center><h1><font color=red>Warning...</FONT></h1><BR>";
		echo "<B>Your enhanced config file is /administrator/$configfile</b><BR>";
		echo "<B>You need to chmod this to 766 in order for the config to be updated</B></center><BR><BR>";
	}

	//include_once( $configfile );

	$lists = array();
	// make a standard yes/no list
	$yesno = array();
	$yesno[] = JHTML::_('select.option',  '0', _UE_NO );
	$yesno[] = JHTML::_('select.option',  '1', _UE_YES );

	$zoomversion[] = JHTML::_('select.option',  '1', 'Version 2.1.4 RC3 or earlier' );
	$zoomversion[] = JHTML::_('select.option',  '2', 'Version 2.1.5 or later' );
	$zoomversion[] = JHTML::_('select.option',  '3', 'Version 2.5 Beta-3 or later' );

	$zoomOrder[] = JHTML::_('select.option', '1', _UE_ZOOM_ORDER_DATE_ASC);
	$zoomOrder[] = JHTML::_('select.option', '2', _UE_ZOOM_ORDER_DATE_DESC);
	$zoomOrder[] = JHTML::_('select.option', '3', _UE_ZOOM_ORDER_FLNM_ASC);
	$zoomOrder[] = JHTML::_('select.option', '4', _UE_ZOOM_ORDER_FLNM_DESC);
	$zoomOrder[] = JHTML::_('select.option', '5', _UE_ZOOM_ORDER_NAME_ASC);
	$zoomOrder[] = JHTML::_('select.option', '6', _UE_ZOOM_ORDER_NAME_DESC);

	$wordlimit[] = JHTML::_('select.option',  '100', '100' );
	$wordlimit[] = JHTML::_('select.option',  '150', '150' );
	$wordlimit[] = JHTML::_('select.option',  '200', '200' );
	$wordlimit[] = JHTML::_('select.option',  '250', '250' );
	$wordlimit[] = JHTML::_('select.option',  '300', '300' );
	$wordlimit[] = JHTML::_('select.option',  '350', '350' );
	$wordlimit[] = JHTML::_('select.option',  '400', '400' );
	$wordlimit[] = JHTML::_('select.option',  '450', '450' );
	$wordlimit[] = JHTML::_('select.option',  '500', '500' );
	$wordlimit[] = JHTML::_('select.option',  '550', '550' );
	$wordlimit[] = JHTML::_('select.option',  '600', '600' );
	$wordlimit[] = JHTML::_('select.option',  '650', '650' );
	$wordlimit[] = JHTML::_('select.option',  '700', '700' );
	$wordlimit[] = JHTML::_('select.option',  '750', '750' );
	$wordlimit[] = JHTML::_('select.option',  '800', '800' );
	$wordlimit[] = JHTML::_('select.option',  '850', '850' );
	$wordlimit[] = JHTML::_('select.option',  '900', '900' );
	$wordlimit[] = JHTML::_('select.option',  '950', '950' );
	$wordlimit[] = JHTML::_('select.option',  '1000', '1000' );

	$listlimit[] = JHTML::_('select.option',  '5', '5' );
	$listlimit[] = JHTML::_('select.option',  '10', '10' );
	$listlimit[] = JHTML::_('select.option',  '15', '15' );
	$listlimit[] = JHTML::_('select.option',  '20', '20' );
	$listlimit[] = JHTML::_('select.option',  '25', '25' );
	$listlimit[] = JHTML::_('select.option',  '30', '30' );
	$listlimit[] = JHTML::_('select.option',  '35', '35' );
	$listlimit[] = JHTML::_('select.option',  '40', '40' );
	$listlimit[] = JHTML::_('select.option',  '45', '45' );
	$listlimit[] = JHTML::_('select.option',  '50', '50' );

	//admin profile color list
	$colorlist[] = JHTML::_('select.option',  '', _UE_PROFILE_COLOR_DEFAULT );		//no default color set
	$colorlist[] = JHTML::_('select.option',  '#0000FF', _UE_PROFILE_COLOR_BLUE );	//blue
	$colorlist[] = JHTML::_('select.option',  '#008000', _UE_PROFILE_COLOR_GREEN );	//green
	$colorlist[] = JHTML::_('select.option',  '#E3007B', _UE_PROFILE_COLOR_PINK );	//pink
	$colorlist[] = JHTML::_('select.option',  '#FF0000', _UE_PROFILE_COLOR_RED );		//red
	$colorlist[] = JHTML::_('select.option',  '#EF9C00', _UE_PROFILE_COLOR_ORANGE );	//orange
	$colorlist[] = JHTML::_('select.option',  '#FFFF00', _UE_PROFILE_COLOR_YELLOW );	//yellow
	$colorlist[] = JHTML::_('select.option',  '#000000', _UE_PROFILE_COLOR_BLACK );	//black
	$colorlist[] = JHTML::_('select.option',  '#00FF00', _UE_PROFILE_COLOR_LIME );	//lime
	$colorlist[] = JHTML::_('select.option',  '#FF00FF', _UE_PROFILE_COLOR_FUCHIA );	//fuschia
	$colorlist[] = JHTML::_('select.option',  '#000080', _UE_PROFILE_COLOR_NAVY );	//navy
	$colorlist[] = JHTML::_('select.option',  '#800080', _UE_PROFILE_COLOR_PURPLE );	//purple
	$colorlist[] = JHTML::_('select.option',  '#800000', _UE_PROFILE_COLOR_MAROON );	//maroon
	$colorlist[] = JHTML::_('select.option',  '#008080', _UE_PROFILE_COLOR_TEAL );	//teal
	$colorlist[] = JHTML::_('select.option',  '#00FFFF', _UE_PROFILE_COLOR_AQUA );	//aqua
	$colorlist[] = JHTML::_('select.option',  '#808000', _UE_PROFILE_COLOR_OLIVE );	//olive
	$colorlist[] = JHTML::_('select.option',  '#C0C0C0', _UE_PROFILE_COLOR_SILVER );	//silver
	$colorlist[] = JHTML::_('select.option',  '#808080', _UE_PROFILE_COLOR_GREY );	//grey
	$colorlist[] = JHTML::_('select.option',  '#FFFFFF', _UE_PROFILE_COLOR_WHITE );	//white

	//admin rateit days
	$rateitdayslist[] = JHTML::_('select.option',  '0', '0' );
	$rateitdayslist[] = JHTML::_('select.option',  '1', '1' );
	$rateitdayslist[] = JHTML::_('select.option',  '2', '2' );
	$rateitdayslist[] = JHTML::_('select.option',  '3', '3' );
	$rateitdayslist[] = JHTML::_('select.option',  '4', '4' );
	$rateitdayslist[] = JHTML::_('select.option',  '5', '5' );
	$rateitdayslist[] = JHTML::_('select.option',  '6', '6' );
	$rateitdayslist[] = JHTML::_('select.option',  '7', '7' );
	
	$rateitprecision[] = JHTML::_('select.option',  '0', '0' );
	$rateitprecision[] = JHTML::_('select.option',  '1', '1' );
	$rateitprecision[] = JHTML::_('select.option',  '2', '2' );
	$rateitprecision[] = JHTML::_('select.option',  '3', '3' );
	$rateitprecision[] = JHTML::_('select.option',  '4', '4' );

	//admin Lastvisitors tab
	$visitorcount[] = JHTML::_('select.option',  '5', '5' );
	$visitorcount[] = JHTML::_('select.option',  '10', '10' );
	$visitorcount[] = JHTML::_('select.option',  '15', '15' );
	$visitorcount[] = JHTML::_('select.option',  '20', '20' );
	
	$visitortime[] = JHTML::_('select.option',  '0', _UE_LASTVISITORS_NODATE );
	$visitortime[] = JHTML::_('select.option',  '1', _UE_LASTVISITORS_SHOWDATE );
	$visitortime[] = JHTML::_('select.option',  '2', _UE_LASTVISITORS_SHOWSINCE );
	
	$visitorgender[] = JHTML::_('select.option',  'symbol', _UE_LASTVISITORS_GENDERSYMBOL );
	$visitorgender[] = JHTML::_('select.option',  'tag', _UE_LASTVISITORS_GENDERTEXT );
	$visitorgender[] = JHTML::_('select.option',  'not', _UE_LASTVISITORS_NOGENDER );

	$cbsearchlists = array();
	$cbsearchlists[] = JHTML::_('select.option', '', 'default userslist');
	$database->setQuery("SELECT listid, title FROM #__cbe_lists ORDER BY title ASC");
	$cbelists_o = $database->loadObjectList();
	if (count($cbelists_o) != 0) {
		foreach ($cbelists_o as $cbelist_o) {
			$cbsearchlists[] = JHTML::_('select.option', $cbelist_o->listid, $cbelist_o->title);
		}
	} else {
		$cbsearchlists[] = JHTML::_('select.option', '0', 'no userlists-templates found');
	}

	//TopMostUser Count
	$topmostc[] = JHTML::_('select.option',  '5', '5' );
	$topmostc[] = JHTML::_('select.option',  '10', '10' );
	$topmostc[] = JHTML::_('select.option',  '15', '15' );
	$topmostc[] = JHTML::_('select.option',  '20', '20' );
	$topmostc[] = JHTML::_('select.option',  '25', '25' );
	$topmostc[] = JHTML::_('select.option',  '30', '30' );
	$topmostc[] = JHTML::_('select.option',  '35', '35' );
	$topmostc[] = JHTML::_('select.option',  '40', '40' );
	$topmostc[] = JHTML::_('select.option',  '45', '45' );
	$topmostc[] = JHTML::_('select.option',  '50', '50' );

	//CBSearch expire times
	$search_expire_times[] = JHTML::_('select.option',  '5', '5' );
	$search_expire_times[] = JHTML::_('select.option',  '10', '10' );
	$search_expire_times[] = JHTML::_('select.option',  '15', '15' );
	$search_expire_times[] = JHTML::_('select.option',  '20', '20' );
	$search_expire_times[] = JHTML::_('select.option',  '25', '25' );
	$search_expire_times[] = JHTML::_('select.option',  '30', '30' );
	$search_expire_times[] = JHTML::_('select.option',  '35', '35' );
	$search_expire_times[] = JHTML::_('select.option',  '40', '40' );
	$search_expire_times[] = JHTML::_('select.option',  '45', '45' );
	$search_expire_times[] = JHTML::_('select.option',  '50', '50' );
	$search_expire_times[] = JHTML::_('select.option',  '55', '55' );
	$search_expire_times[] = JHTML::_('select.option',  '60', '60' );

	// gtree2 ACL Builder
	$gtree2=array();
	$gtree2[] = JHTML::_('select.option',  -2 , '- Everybody -' );
	$gtree2[] = JHTML::_('select.option',  -1, '- All Registered Users -' );
	$gtree2 = array_merge( $gtree2, $acl->get_group_children_tree( null, 'USERS', false ));
	if ($enhanced_Config['allow_cbsearchviewbyGID'] == '' || $enhanced_Config['allow_cbsearchviewbyGID'] == NULL ) {
		$enhanced_Config['allow_cbsearchviewbyGID'] = $ueConfig['allow_listviewbyGID'];
	}

	//Guestbook System
	$lists['use_guestbook_rating'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_guestbook_rating', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['use_guestbook_rating'] );
	$lists['guestbook_use_emoticons'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_use_emoticons', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_use_emoticons'] );
	$lists['guestbook_use_bbc_code'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_use_bbc_code', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_use_bbc_code'] );
	$lists['guestbook_show_avatar'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_show_avatar', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_show_avatar'] );
	$lists['allow_gbdirectmail'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_gbdirectmail', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_gbdirectmail'] );
	$lists['allow_gbdirectanswer'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_gbdirectanswer', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_gbdirectanswer'] );
	$lists['guestbook_auto_publish'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_auto_publish', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_auto_publish'] );
	$lists['guestbook_allow_anon'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_allow_anon', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_allow_anon'] );
	$lists['guestbook_use_pms_notify'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_use_pms_notify', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_use_pms_notify'] );
	$lists['guestbook_use_language_filter'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_use_language_filter', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_use_language_filter'] );
	$lists['guestbook_set_word_limit'] = JHTML::_('select.genericlist',  $wordlimit, 'cfg_guestbook_set_word_limit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_set_word_limit'] );
	$lists['guestbook_entries_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_guestbook_entries_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_entries_per_page'] );
	$lists['guestbook_allow_sign_own'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_allow_sign_own', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_allow_sign_own'] );
	$lists['guestbook_use_entry_limit'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_use_entry_limit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_use_entry_limit'] );
	$lists['guestbook_uselocale'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_uselocale', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_uselocale'] );
	$lists['guestbook_usewordwrap'] = JHTML::_('select.genericlist',  $yesno, 'cfg_guestbook_usewordwrap', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['guestbook_usewordwrap'] );

	//Comments System
	$lists['comment_allow_sign_own'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_allow_sign_own', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_allow_sign_own'] );
	$lists['comment_auto_publish'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_auto_publish', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_auto_publish'] );
	$lists['comment_use_bbc_code'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_use_bbc_code', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_use_bbc_code'] );
	$lists['comment_use_emoticons'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_use_emoticons', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_use_emoticons'] );
	$lists['comment_show_avatar'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_show_avatar', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_show_avatar'] );
	$lists['comment_use_language_filter'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_use_language_filter', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_use_language_filter'] );
	$lists['comment_set_word_limit'] = JHTML::_('select.genericlist',  $wordlimit, 'cfg_comment_set_word_limit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_set_word_limit'] );
	$lists['comment_entries_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_comment_entries_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_entries_per_page'] );
	$lists['comment_uselocale'] = JHTML::_('select.genericlist',  $yesno, 'cfg_comment_uselocale', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['comment_uselocale'] );

	//Testimonials System
	$lists['use_pms_testimonial'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_pms_testimonial', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['use_pms_testimonial'] );
	$lists['testimonials_use_language_filter'] = JHTML::_('select.genericlist',  $yesno, 'cfg_testimonials_use_language_filter', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['testimonials_use_language_filter'] );
	$lists['testimonial_set_word_limit'] = JHTML::_('select.genericlist',  $wordlimit, 'cfg_testimonial_set_word_limit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['testimonial_set_word_limit'] );
	$lists['testimonial_entries_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_testimonial_entries_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['testimonial_entries_per_page'] );
	$lists['testimonials_uselocale'] = JHTML::_('select.genericlist',  $yesno, 'cfg_testimonials_uselocale', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['testimonials_uselocale'] );

	//zOOm Gallery Integration
	$lists['zoomversion'] = JHTML::_('select.genericlist',  $zoomversion, 'cfg_zoomversion', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['zoomversion'] );
	$lists['setzoomsize'] = JHTML::_('select.genericlist',  $yesno, 'cfg_setzoomsize', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['setzoomsize'] );
	$lists['showzoomimagehits'] = JHTML::_('select.genericlist',  $yesno, 'cfg_showzoomimagehits', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['showzoomimagehits'] );
	$lists['showzoomimagerating'] = JHTML::_('select.genericlist',  $yesno, 'cfg_showzoomimagerating', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['showzoomimagerating'] );
	$lists['use_zoom_limiter'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_zoom_limiter', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['use_zoom_limiter'] );
	$lists['use_zoom_keyword'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_zoom_keyword', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['use_zoom_keyword'] );
	$lists['show_photos_number'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_photos_number', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_photos_number'] );
	$lists['show_mp3_number'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_mp3_number', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_mp3_number'] );
	$lists['use_zoom_mp3_filter'] = JHTML::_('select.genericlist',  $yesno, 'cfg_use_zoom_mp3_filter', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['use_zoom_mp3_filter'] );
	$lists['zoom_orderMethod'] = JHTML::_('select.genericlist',  $zoomOrder, 'cfg_zoom_orderMethod', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['zoom_orderMethod'] );
	$lists['zoom_orderMethod_mp3'] = JHTML::_('select.genericlist',  $zoomOrder, 'cfg_zoom_orderMethod_mp3', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['zoom_orderMethod_mp3'] );
	$lists['zoom_full_link'] = JHTML::_('select.genericlist',  $yesno, 'cfg_zoom_full_link', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['zoom_full_link'] );
	$lists['zoom_full_link_mp3'] = JHTML::_('select.genericlist',  $yesno, 'cfg_zoom_full_link_mp3', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['zoom_full_link_mp3'] );
	$lists['zoom_popupopen'] = JHTML::_('select.genericlist',  $yesno, 'cfg_zoom_popupopen', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['zoom_popupopen'] );

	//SB Forum
	$lists['show_forum_karma'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_forum_karma', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_forum_karma'] );
	$lists['show_forum_ranking'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_forum_ranking', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_forum_ranking'] );
	$lists['show_forum_post_number'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_forum_post_number', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_forum_post_number'] );
	$lists['sb_forum_posts_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_sb_forum_posts_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['sb_forum_posts_per_page'] );
	$lists['sb_forum_chkgid'] = JHTML::_('select.genericlist',  $yesno, 'cfg_sb_forum_chkgid', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['sb_forum_chkgid'] );
	$lists['sb_use_fb'] = JHTML::_('select.genericlist',  $yesno, 'cfg_sb_use_fb', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['sb_use_fb'] );

	//Articles tab
	$lists['articles_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_articles_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['articles_per_page'] );

	//Mamblog tab
	$lists['mamblog_entries_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_mamblog_entries_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['mamblog_entries_per_page'] );

	//Buddy
	$lists['allow_pmbuddy'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_pmbuddy', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_pmbuddy'] );
	$lists['allow_onlinebuddy'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_onlinebuddy', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_onlinebuddy'] );
	$lists['allow_guestbookbuddy'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_guestbookbuddy', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_guestbookbuddy'] );
	$lists['show_add_del_bud_link'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_add_del_bud_link', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_add_del_bud_link'] );
	$lists['buddylist_sender'] = JHTML::_('select.genericlist',  $yesno, 'cfg_buddylist_sender', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['buddylist_sender'] );
	$lists['buddylist_use_pms_notify'] = JHTML::_('select.genericlist',  $yesno, 'cfg_buddylist_use_pms_notify', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['buddylist_use_pms_notify'] );
	$lists['buddy_entries_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_buddies_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['buddies_per_page'] );

	//Search Manager by Rasmus Dahl-Sorensen
	$lists['allow_cbsearchviewbyGID']=JHTML::_('select.genericlist',  $gtree2, 'cfg_allow_cbsearchviewbyGID', 'size="4"', 'value', 'text', $enhanced_Config['allow_cbsearchviewbyGID'] );
	$lists['allow_cbesearch_module'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_cbesearch_module', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_cbesearch_module'] );
	$lists['cbsearch_geo_dist'] = JHTML::_('select.genericlist',  $yesno, 'cfg_cbsearch_geo_dist', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['cbsearch_geo_dist'] );
	$lists['onlinenow'] = JHTML::_('select.genericlist',  $yesno, 'cfg_onlinenow', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['onlinenow'] );
	$lists['picture'] = JHTML::_('select.genericlist',  $yesno, 'cfg_picture', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['picture'] );
	$lists['added10'] = JHTML::_('select.genericlist',  $yesno, 'cfg_added10', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['added10'] );
	$lists['online10'] = JHTML::_('select.genericlist',  $yesno, 'cfg_online10', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['online10'] );
	$lists['show_advanced_search_tab'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_advanced_search_tab', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_advanced_search_tab'] );
	$lists['search_age_common_style'] = JHTML::_('select.genericlist',  $yesno, 'cfg_search_age_common_style', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['search_age_common_style'] );	// PK
	$lists['cbs_allow_profile_popup'] = JHTML::_('select.genericlist',  $yesno, 'cfg_cbs_allow_profile_popup', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['cbs_allow_profile_popup'] );	// PK
	$lists['cbsearch_expire_time'] = JHTML::_('select.genericlist',  $search_expire_times, 'cfg_cbsearch_expire_time', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['cbsearch_expire_time'] );	// PK
	// css class cbsearch is editfield
	if ($enhanced_Config['cbsearch_css1'] == '') {
		$enhanced_Config['cbsearch_css1'] = 'sectiontableentry1';
	}
	if ($enhanced_Config['cbsearch_css2'] == '') {
		$enhanced_Config['cbsearch_css2'] = 'sectiontableentry2';
	}
	$lists['cbsearchlistid'] = JHTML::_('select.genericlist',  $cbsearchlists, 'cfg_cbsearchlistid', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['cbsearchlistid'] );
	if (!$enhanced_Config['searchtab_color']) {
		$enhanced_Config['searchtab_color'] = "gray";
	}

	//Profile Journal System
	$lists['journal_set_word_limit'] = JHTML::_('select.genericlist',  $wordlimit, 'cfg_journal_set_word_limit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['journal_set_word_limit'] );
	$lists['journal_entries_per_page'] = JHTML::_('select.genericlist',  $listlimit, 'cfg_journal_entries_per_page', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['journal_entries_per_page'] );
	$lists['journal_use_entry_limit'] = JHTML::_('select.genericlist',  $yesno, 'cfg_journal_use_entry_limit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['journal_use_entry_limit'] );
	$lists['journal_uselocale'] = JHTML::_('select.genericlist',  $yesno, 'cfg_journal_uselocale', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['journal_uselocale'] );

	//Author System
	$lists['author_subscribe'] = JHTML::_('select.genericlist',  $yesno, 'cfg_author_subscribe', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['author_subscribe'] );
	$lists['allow_onlineauthor'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_onlineauthor', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_onlineauthor'] );
	$lists['allow_pmauthor'] = JHTML::_('select.genericlist',  $yesno, 'cfg_allow_pmauthor', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['allow_pmauthor'] );

	//General Settings

	//Profile Colors-user allow
	$lists['profile_allow_colors'] = JHTML::_('select.genericlist',  $yesno, 'cfg_profile_allow_colors', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['profile_allow_colors'] );
	$lists['profile_color'] = JHTML::_('select.genericlist',  $colorlist, 'cfg_profile_color', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['profile_color'] );
	
	// Pic2Pic setting -> User without pic is not allowed to view other avatar-pics
	$lists['profile_by_name'] = JHTML::_('select.genericlist',  $yesno, 'cfg_profile_by_name', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['profile_by_name'] );
	$lists['tooltip_wz'] = JHTML::_('select.genericlist',  $yesno, 'cfg_tooltip_wz', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['tooltip_wz'] );
	$lists['profile_langFilterText'] = JHTML::_('select.genericlist',  $yesno, 'cfg_profile_langFilterText', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['profile_langFilterText'] );
	$lists['allow_pic2pic'] = JHTML::_('select.genericlist',  $yesno, 'cfg_pic2pic', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['pic2pic'] );
	$lists['allow_pic2profile'] = JHTML::_('select.genericlist',  $yesno, 'cfg_pic2profile', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['pic2profile'] );
	$lists['allow_showage'] = JHTML::_('select.genericlist',  $yesno, 'cfg_showage', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['showage'] );
	$lists['show_zodiacs'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_zodiacs', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_zodiacs'] );
	$lists['show_zodiacs_static'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_zodiacs_static', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_zodiacs_static'] );
	$lists['show_zodiacs_ch'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_zodiacs_ch', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_zodiacs_ch'] );
	$lists['uhp_integration'] = JHTML::_('select.genericlist',  $yesno, 'cfg_uhp_integration', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['uhp_integration'] );
	$lists['show_easyProfileLink'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_easyProfileLink', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_easyProfileLink'] );
	$lists['flatten_tabs'] = JHTML::_('select.genericlist',  $yesno, 'cfg_flatten_tabs', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['flatten_tabs'] );
	$lists['full_editorfield'] = JHTML::_('select.genericlist',  $yesno, 'cfg_full_editorfield', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['full_editorfield'] );

	$lists['allow_rateit'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_allow', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_allow'] );
	$lists['rateit_form'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_form', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_form'] );
	$lists['rateit_self'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_self', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_self'] );
	$lists['rateit_guest'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_guest', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_guest'] );
	$lists['rateit_stars'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_stars', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_stars'] );
	$lists['rateit_count'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_count', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_count'] );
	$lists['rateit_precision'] = JHTML::_('select.genericlist',  $rateitprecision, 'cfg_rateit_precision', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_precision'] );
	$lists['rateit_result_allow'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_result_allow', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_result_allow'] );
	$lists['rateit_days'] = JHTML::_('select.genericlist',  $rateitdayslist, 'cfg_rateit_days', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_days'] );
	$lists['allow_rateit_mod'] = JHTML::_('select.genericlist',  $yesno, 'cfg_rateit_mod', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['rateit_mod'] );

	$lists['profile_txt_wordwrap'] = JHTML::_('select.genericlist',  $yesno, 'cfg_profile_txt_wordwrap', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['profile_txt_wordwrap'] );
	
	// Lastvisitors Tab
	$lists['visitorcount'] = JHTML::_('select.genericlist',  $visitorcount, 'cfg_lastvisitors_maxentry', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_maxentry'] );
	$lists['visitortime'] = JHTML::_('select.genericlist',  $visitortime, 'cfg_lastvisitors_showtime', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showtime'] );
	$lists['visitorgender'] = JHTML::_('select.genericlist',  $visitorgender, 'cfg_lastvisitors_showgender', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showgender'] );
	$lists['visitorself'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_countself', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_countself'] );
	$lists['visitorowner'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_owneronly', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_owneronly'] );
	$lists['visitoronline'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_showonline', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showonline'] );
	$lists['visitorage'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_showage', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showage'] );
	$lists['visitor_showvisitcount'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_showvisitcount', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showvisitcount'] );
	$lists['visitor_showvisitedtab'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_showvisitedtab', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showvisitedtab'] );
	$lists['visitor_showtitlerow'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_showtitlerow', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showtitlerow'] );
	$lists['visitor_showuserfield'] = JHTML::_('select.genericlist',  $yesno, 'cfg_lastvisitors_showuserfield', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['lastvisitors_showuserfield'] );
	
	// brithday field is text input
	// gender field is text input
	// datestring is text input
	// userfield is text input
	
	// Profile Stats Tab
	$lists['show_profile_hits'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_profile_hits', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_profile_hits'] );
	$lists['show_profile_stats'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_profile_stats', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_profile_stats'] );
	$lists['show_core_usertype'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_core_usertype', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_core_usertype'] );
	$lists['topMost_active'] = JHTML::_('select.genericlist',  $yesno, 'cfg_topMost_active', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['topMost_active'] );
	$lists['topMostLimit'] = JHTML::_('select.genericlist',  $topmostc, 'cfg_topMostLimit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['topMostLimit'] );

	// GroupJive Integration Swicth Tab
	$lists['groupjive_integration'] = JHTML::_('select.genericlist',  $yesno, 'cfg_groupjive_integration', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['groupjive_integration'] );
	$lists['show_gj_owned_groups'] = JHTML::_('select.genericlist',  $yesno, 'cfg_show_gj_owned_groups', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['show_gj_owned_groups'] );
	$lists['link_gj_owned_groups'] = JHTML::_('select.genericlist',  $yesno, 'cfg_link_gj_owned_groups', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['link_gj_owned_groups'] );

	// GeoCoder Backendtab
	// GoogleApi is text input $enhanced_Config['geocoder_google_apikey']
	if (empty($enhanced_Config['geocoder_google_apikey'])) {
		$database->setQuery("SELECT APIKey FROM #__google_maps_conf LIMIT 1");
		$google_apikey = $database->loadResult();
		if ($database->query()) {
			$enhanced_Config['geocoder_google_apikey'] = $google_apikey;
		}
	}
	// gtree2 defined at start for cbsearch
	if ($enhanced_Config['geocoder_allow_viewbyGID'] == '' || $enhanced_Config['geocoder_allow_viewbyGID'] == NULL ) {
		$enhanced_Config['geocoder_allow_viewbyGID'] = $ueConfig['allow_listviewbyGID'];
	}

	$unsharp_digit = array();
	for ($i=6; $i > -1; $i--) {
		$unsharp_digit[] = JHTML::_('select.option', $i,$i);
	}
	$start_zoom = array();
	for ($i=0; $i < 21; $i++) {
		$start_zoom[] = JHTML::_('select.option', $i,$i);
	}
	$start_type = array();
	$start_type[] = JHTML::_('select.option', "G_NORMAL_MAP","Normal");
	$start_type[] = JHTML::_('select.option', "G_SATELLITE_MAP","Sat");
	$start_type[] = JHTML::_('select.option', "G_HYBRID_MAP","Hybrid");

	$coder_method = array();
	$coder_method[] = JHTML::_('select.option', "0","HTTP");
	$coder_method[] = JHTML::_('select.option', "1","JavaScript");

	$enhanced_Config['geocoder_show_single_addrfield'] = 1;
	$lists['geocoder_geocode_byJS'] = JHTML::_('select.genericlist',  $coder_method, 'cfg_geocoder_geocode_byJS', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_geocode_byJS'] );
	$lists['geocoder_useragree_usage'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_useragree_usage', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_useragree_usage'] );
	$lists['geocoder_lock_addr_on_success'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_lock_addr_on_success', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_lock_addr_on_success'] );
	$lists['geocoder_show_acc'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_show_acc', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_show_acc'] );
	$lists['geocoder_show_single_addrfield'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_show_single_addrfield', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_show_single_addrfield'] );
	$lists['geocoder_allow_directinput'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_allow_directinput', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_allow_directinput'] );
	$lists['geocoder_allow_visualverify'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_allow_visualverify', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_allow_visualverify'] );
	$lists['geocoder_allow_visualrelocate'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_allow_visualrelocate', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_allow_visualrelocate'] );
	$lists['geocoder_allow_visualrelocate_onclick'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_allow_visualrelocate_onclick', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_allow_visualrelocate_onclick'] );
	$lists['geocoder_use_addrfield'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_use_addrfield', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_use_addrfield'] );
	$lists['geocoder_use_addrfield_auto'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_use_addrfield_auto', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_use_addrfield_auto'] );
	$lists['geocoder_do_export'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_do_export', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_do_export'] );
	// usermap fields start here
	$lists['geocoder_show_usermap'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_show_usermap', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_show_usermap'] );
	$lists['geocoder_allow_viewbyGID']=JHTML::_('select.genericlist',  $gtree2, 'cfg_geocoder_allow_viewbyGID', 'size="4"', 'value', 'text', $enhanced_Config['geocoder_allow_viewbyGID'] );
	// height & width entry fields / geocoder_usermap_interval is entry field / geocoder_usermap_scanwide is entry field
	$lists['geocoder_usermap_force_center'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_usermap_force_center', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_usermap_force_center'] );
	$lists['geocoder_usermap_force_unsharp'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_usermap_force_unsharp', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_usermap_force_unsharp'] );
	$lists['geocoder_usermap_force_unsharp_digit'] = JHTML::_('select.genericlist',  $unsharp_digit, 'cfg_geocoder_usermap_force_unsharp_digit', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_usermap_force_unsharp_digit'] );
	// UM_Center_Lat UM_Center_Lng are entry fields
	$lists['geocoder_usermap_showsearch'] = JHTML::_('select.genericlist',  $yesno, 'cfg_geocoder_usermap_showsearch', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_usermap_showsearch'] );
	$lists['geocoder_usermap_start_zoom'] = JHTML::_('select.genericlist',  $start_zoom, 'cfg_geocoder_usermap_start_zoom', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_usermap_start_zoom'] );
	$lists['geocoder_usermap_start_type'] = JHTML::_('select.genericlist',  $start_type, 'cfg_geocoder_usermap_start_type', 'class="inputbox" size="1"', 'value', 'text', $enhanced_Config['geocoder_usermap_start_type'] );

	HTML_cbe::enhancedConfig( $enhanced_Config, $lists, $option );
}

function getXMLParams ($path, $asText) {
	require_once(JPATH_SITE.DS.'includes'.DS.'domit'.DS.'xml_domit_lite_parser.php');
	$xmlDoc = new DOMIT_Lite_Document();
	$xmlDoc->resolveErrors( true );

	$params=null;
	if ($xmlDoc->loadXML( $path, false, true )) {
		$root =& $xmlDoc->documentElement;

		$tagName = $root->getTagName();
		$isParamsFile = ($tagName == 'mosinstall' || $tagName == 'install' || $tagName == 'mosparams');
		if ($isParamsFile && $root->getAttribute( 'type' ) == 'cbe_ext') {
			//$params = &$root->getElementsByPath( 'enhancedparams', 1 );
			$params = &$root->getElementsByPath( 'params', 1 );
		}
	}

	$result = ($asText)? '' : array();
	if (is_object( $params )) {
		foreach ($params->childNodes as $param) {
			$name = $param->getAttribute( 'name' );
			$label = $param->getAttribute( 'label' );

			$key = $name ? $name : $label;
			if ( $label != '@spacer' && $name != '@spacer') {
				$value = str_replace("\n",'\n',$param->getAttribute( 'default' ));
				if ($asText) {
					$result.="$key=$value\n";
				} else {
					$result[$key]=$value;
				}
			}
		}
	}
	return $result;
}

function PluginConfig( $option ) {
	// domit bereitstellen
	global $mosConfig_lang;
	require_once (JPATH_SITE.DS.'libraries'.DS.'domit'.DS.'xml_domit_lite_parser.php');
	require_once (JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBETabHandler.php');

	// für mootools
	$doc =& JFactory::getDocument();
	//$doc->addScript(JURI::root() . "components/com_cbe/js/mootools.js");
	
	jimport('joomla.html.pane');
	$pane =& JPane::getInstance('sliders');

	/* alle tabs aus der db auslesen, dann die xml-dateien parsen */
	$db = &JFactory::getDBO();
	$sql = "SELECT * FROM #__cbe_tabs";
	$db->setQuery($sql);
	
	// das tabsverzeichnis mit abschließendem '/'
	$tabsroot = JPATH_SITE.DS.'components'.DS.'com_cbe'.DS.'enhanced'.DS;
	$enhancedTabs = $db->loadObjectList();
	
	// zweispaltiges layout
	// spalte eins: logo
	// spalte zwei sliders
	$logo = JURI::root().DS.'components'.DS.'com_cbe'.DS.'images'.DS.'cbelogo-gruen.jpg';
	echo <<<EOT
		<form name="adminForm" action="index.php">
		<input type="hidden" name="task" value="-1">
		<input type="hidden" name="option" value="com_cbe">
		<table width="100%">
		<tr>
			<td valign=top width="40%"><img src="$logo"></td>
			<td valign=top width="60%">
EOT;

	echo $pane->startPane('CBE Enhanced Config');
	foreach ($enhancedTabs as $enhancedTab) {
		//echo "name: " . $enhancedTab->tabname . "<br />";
		$tabxml = $tabsroot.DS.$enhancedTab->tabname.DS.$enhancedTab->tabname.'.xml';
		if (!file_exists($tabxml))
			continue;
		// für die sprachen und anzeigen
		$langfile = $tabsroot.DS.$enhancedTab->tabname.DS.'language'.DS.$mosConfig_lang.'.php';
		$engfile = $tabsroot.DS.$enhancedTab->tabname.DS.'language'.DS.'english.php';

		(file_exists($langfile))? include_once($langfile):include_once($engfile);
		$label = (defined($enhancedTab->title))? constant($enhancedTab->title):$enhancedTab->title;

		echo $pane->startPanel($label, $enhancedTab->tabname);

		$tabHandler = new CBETabHandler($enhancedTab->tabname);
		$params = new JParameter($tabHandler->getParams(-1, true), $tabxml, 'cbe_ext' );
		//print_r($params);
		echo $params->render();
		echo $pane->endPanel();
	}
	echo $pane->endPane();

	echo <<<EOT
			</td>
		</tr>
		</table>
		</form>
EOT;


}


function savePluginConfig($option) {
	require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBETabHandler.php');

	global $mainframe;
	$db = &JFactory::getDBO();
	$sql = "SELECT * FROM #__cbe_tabs WHERE tabname != ''";
	$db->setQuery($sql);
	
	$enhancedTabs = $db->loadObjectList();
	$params = JRequest::getVar('params');
	$keys = array_keys($params);

	foreach ($enhancedTabs as $enhancedTab) {
		$tab_params = array();
		// jetzt aus dem params array alle einträge rausfiltern
		foreach ($keys as $key) {
			// überprüft das Vorhandensein von enhancedTab->tabname an erster Stelle von key
			if (strpos($key, $enhancedTab->tabname) === 0)
				$tab_params[$key] = $params[$key];
		}

		$cbeTab = new CBETabHandler($enhancedTab->tabname, $db);
		if (is_array($tab_params)) {
			$cbeTab->parseParams();
			$txt = array();
			foreach ($tab_params as $k=>$v)
				$txt[] = "$k=" . str_replace( "\n", '<br />', $v );

			$pars = implode("\n",$txt);
			$cbeTab->setParams($pars);
			if (!$cbeTab->store() )
				die($database->getErrorMsg());
		}
	}
	$mainframe->redirect( "index.php?option=$option&task=pluginConfig", "Configuration saved");
}

function saveEnhancedConfig ( $option ) {

	global $mainframe;
	//Add code to check if config file is writeable.
	$configfile = "components/com_cbe/enhanced_admin/enhanced_config.php";
	@chmod ($configfile, 0766);
	if (!is_writable($configfile)) {
		//mosRedirect("index2.php?option=$option", "FATAL ERROR: Config File Not writeable" );
		$mainframe->redirect( "index.php?option=$option", "FATAL ERROR: Config File not writeable");

	}

	$txt = "<?php\n";
	foreach ($_POST as $k=>$v) {
		if (strpos( $k, 'cfg_' ) === 0) {
			if (!get_magic_quotes_gpc()) {
				$v = addslashes( $v );
			}
			$txt .= "\$enhanced_Config['".substr( $k, 4 )."']='$v';\n";
		}
	}
	$txt .= "?>";

	if ($fp = fopen( $configfile, "w")) {
		fputs($fp, $txt, strlen($txt));
		fclose ($fp);
		//mosRedirect( "index2.php?option=$option&task=enhancedConfig", "Configuration file saved" );
		$mainframe->redirect( "index.php?option=$option&task=enhancedConfig", "Configuration file saved");

	} else {
		$mainframe->redirect( "index.php?option=$option", "FATAL ERROR: File could not be opened." );

		//mosRedirect( "index2.php?option=$option", "FATAL ERROR: File could not be opened." );
	}
}

function saveConfig ( $option ) {
	global $mainframe;

	//Add code to check if config file is writeable.
	$configfile = "components/com_cbe/ue_config.php";
	@chmod ($configfile, 0766);
	if (!is_writable($configfile)) {
		//mosRedirect("index2.php?option=$option", "FATAL ERROR: Config File Not writeable" );
		$mainframe->redirect( "index.php?option=$option", "FATAL ERROR: Config File not writeable");
	}

	$txt = "<?php\n";
	foreach ($_POST as $k=>$v) {
		if (strpos( $k, 'cfg_' ) === 0) {
			if (!get_magic_quotes_gpc()) {
				$v = addslashes( $v );
			}
			$txt .= "\$ueConfig['".substr( $k, 4 )."']='$v';\n";
		}
	}
	$txt .= "?>";

	if ($fp = fopen( $configfile, "w")) {
		fputs($fp, $txt, strlen($txt));
		fclose ($fp);
		//mosRedirect( "index2.php?option=$option&task=showconfig", "Configuration file saved" );
		$mainframe->redirect( "index.php?option=$option&task=showconfig", "Configuration file saved");

	} else {
		//mosRedirect( "index2.php?option=$option", "FATAL ERROR: File could not be opened." );
		$mainframe->redirect( "index.php?option=$option", "FATAL ERROR: Config File not writeable");
	}
}

function approveUser( $cid=null, $approved=1, $option ) {
	global $my, $ueConfig,$mosConfig_emailpass, $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	include_once( "components/com_cbe/ue_config.php" );
	include_once ("components/com_cbe/cbe.class.php");
	if (count( $cid ) < 1) {
		$action = $approved ? 'Approve' : 'Reject';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe SET approved='$approved' WHERE id = '$cids'");
		if ($database->query()) {
			if($approved==1) {
				//$row = new JTableUser( $database );
				$row=new JTableUser($database);
				$row->load( $cids );
				if($mosConfig_emailpass == "1") {
					$pwd = makePass();
					$row->password = $pwd;
					$pwd=md5($pwd);
					$database->setQuery( "UPDATE #__users SET password='$pwd' WHERE id = '$cids'");
					$database->query();
					createEmail($row, 'welcome', $ueConfig,null,1);
				} else {
					createEmail($row, 'welcome', $ueConfig,null,0);
				}
			}
		}

	}
	//mosRedirect( "index2.php?option=$option&task=showusers" );
	$mainframe->redirect( "index.php?option=$option&task=showusers");

}

function requiredField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Make Required' : 'Make Non-required';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_fields SET required='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showField" );
	$mainframe->redirect( "index.php?option=$option&task=showField");

}

function publishField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Publish' : 'UnPublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_fields SET published='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showField" );
	$mainframe->redirect( "index.php?option=$option&task=showField");
}

function registrationField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Add to Registration' : 'Remove from Registration';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_fields SET registration='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showField" );
	$mainframe->redirect( "index.php?option=$option&task=showField");

}

function listPublishedField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Publish' : 'UnPublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_lists SET published='$flag' WHERE listid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showLists" );
	$mainframe->redirect( "index.php?option=$option&task=showLists");
}
function tabPublishedField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Publish' : 'UnPublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_tabs SET enabled='$flag' WHERE tabid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showTab" );
	$mainframe->redirect( "index.php?option=$option&task=showTab");
}
function listDefaultField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Make Default' : 'Reset Default';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	if($flag==1) $published = ", published='1'";
	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_lists SET `default`='0'");
		$database->query();
		$database->setQuery( "UPDATE #__cbe_lists SET `default`='$flag' $published WHERE listid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showLists" );
	$mainframe->redirect( "index.php?option=$option&task=showLists");
}

function profileField( $cid=null, $flag=1, $option ) {
	global $my, $ueConfig, $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1) {
		$action = $flag ? 'Add to Profile' : 'Remove from Profile';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	foreach ($cid AS $cids) {
		$database->setQuery( "UPDATE #__cbe_fields SET profile='$flag' WHERE fieldid = '$cids'");
		$database->query();
		//print $database->getquery();
	}
	//mosRedirect( "index2.php?option=$option&task=showField" );
	$mainframe->redirect( "index.php?option=$option&task=showField");
}

function makePass(){
	$makepass="";
	$salt = "abchefghjkmnpqrstuvwxyz0123456789";
	srand((double)microtime()*1000000);
	$i = 0;
	while ($i <= 7) {
		$num = rand() % 33;
		$tmp = substr($salt, $num, 1);
		$makepass = $makepass . $tmp;
		$i++;
	}
	return ($makepass);
}
function loadSampleData() {
	global $my, $ueConfig;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$sql="SELECT COUNT(*) FROM #__cbe_fields"
	."\n WHERE name IN ('website','location','occupation','interests','company','address','city','state','zipcode','country','phone','fax')";
	$database->setQuery($sql);
	$fieldCount=$database->loadresult();

	IF($fieldCount < 1) {
		$sqlStatements = array();

		$sqlStatements[0]['query'] = "INSERT IGNORE INTO `#__cbe_tabs` (`tabid`, `title`, `ordering`, `sys`) "
		."\n VALUES (2, 'Additional Info', 1, 0)";
		$sqlStatements[0]['message'] = "<font color=green>Tab Added Successfully!</font><br />";

		$sqlStatements[1]['query'] = "ALTER TABLE `#__cbe` ADD `website` varchar(255) default NULL,"
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

		$sqlStatements[2]['query'] = "INSERT IGNORE INTO `#__cbe_fields`  (`fieldid`, `name`, `table`, `title`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `calculated`, `sys`) "
		."\n VALUES (30, 'website', '#__cbe', '_UE_Website', 'webaddress', 0, 0, 0, 2, 1, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
		."\n (31, 'location', '#__cbe', '_UE_Location', 'text', 50, 25, 0, 2, 2, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
		."\n (32, 'occupation', '#__cbe', '_UE_Occupation', 'text', 0, 0, 0, 2, 3, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
		."\n (33, 'interests', '#__cbe', '_UE_Interests', 'text', 0, 0, 0, 2, 4, 0, 0, NULL, NULL, 1, 0, 1, 0, 0),"
		."\n (34, 'company', '#__cbe', '_UE_Company', 'text', 0, 0, 0, 2, 5, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (35, 'city', '#__cbe', '_UE_City', 'text', 0, 0, 0, 2, 6, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (36, 'state', '#__cbe', '_UE_State', 'text', 2, 4, 0, 2, 7, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (37, 'zipcode', '#__cbe', '_UE_ZipCode', 'text', 0, 0, 0, 2, 8, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (38, 'country', '#__cbe', '_UE_Country', 'text', 0, 0, 0, 2, 9, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (40, 'address', '#__cbe', '_UE_Address', 'text', 0, 0, 0, 2, 10, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (43, 'phone', '#__cbe', '_UE_PHONE', 'text', 0, 0, 0, 2, 11, 0, 0, NULL, NULL, 1, 1, 1, 0, 0),"
		."\n (44, 'fax', '#__cbe', '_UE_FAX', 'text', 0, 0, 0, 2, 12, 0, 0, NULL, NULL, 1, 1, 1, 0, 0)";
		$sqlStatements[2]['message'] = "<font color=green>Fields Added Successfully!</font><br />";

		$sqlStatements[3]['query'] = "INSERT INTO `#__cbe_lists` (`listid`, `title`, `description`, `published`, `default`, `usergroupids`, `sortfields`, `col1title`, `col1enabled`, `col1fields`, `col2title`, `col2enabled`, `col1captions`, `col2fields`, `col2captions`, `col3title`, `col3enabled`, `col3fields`, `col3captions`, `col4title`, `col4enabled`, `col4fields`, `col4captions`) "
		."\n VALUES (2, 'Members List', 'my Description', 1, 1, '29, 18, 19, 20, 21, 30, 23, 24, 25', '`username` ASC', 'Image', 1, '29', 'Name', 1, 0, '41', 0, 'Other', 1, '26|*|28|*|27', 1, '', 0, '', 0)";

		$sqlStatements[3]['message'] = "<font color=green>List Added Successfully!</font><br />";

		//$sqlStatements[3]['query'] = "INSERT INTO `#__menu` (`menutype`, `name`, `alias`, `link`, `type`, `published`, ...);
		foreach ($sqlStatements AS $sql) {
			$database->setQuery($sql['query']);
			if (!$database->query()) {
				print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
				return;
			} else {
				print $sql['message'];
			}
			//print $database->getquery();
		}
	} else {
		print "Sample Data is already loaded!";
	}
}
function syncUsers() {
	global $my, $ueConfig;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$sql="INSERT IGNORE INTO #__cbe(id,user_id) SELECT id,id FROM #__users";
	$database->setQuery($sql);
	if (!$database->query()) {
		print("<font color=red>SQL error" . $database->stderr(true)."</font><br />");
	} else {
		print "<font color=green>Mambo User Table and Mambo Community Builder User Table now in sync!</font>";
	}
}

function loadTools() {
	global $mosConfig_lang;

	$func = JRequest::getVar('func',null);
	if ($func) {
		// dann tools.php einbinden und func ausführen
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'enhanced_admin'.DS.'tools.php');
		cbe_switch_func($func);
	} else {
		if (file_exists(JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/language/'.$mosConfig_lang.'.php')) {
			include(JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/language/'.$mosConfig_lang.'.php');
		} else {
			include(JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/language/english.php');
		}
	}
	HTML_cbe::showTools();
}

function adminAvatarUp( $option ) {
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$user_uid = JRequest::getVar('id');
	if ($user_uid == '') {
		$user_uid = Jrequest::getVar('user_id');
	}

	$row = new JTableUser( $database );
	$row->load( $user_uid );
	$row->orig_password = $row->password;
	HTML_cbe::adminAvatar( $row, $option, $user_uid, $submitvalue);
}

function adminAvatarDel() {
	global $my;
	global $mosConfig_live_site,$_POST,$ueConfig;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$user_uid = JArrayHelper::getValue($_POST, 'id');
	if ($user_uid == '') {
		$user_uid = JArrayHelper::getValue($_REQUEST, 'user_id');
	}

	$row = new JTableUser( $database );
	$row->load( $user_uid );
	$row->orig_password = $row->password;
	$_REQUEST['do'] = "deleteavatar";
	HTML_cbe::adminAvatar( $row, $option, $user_uid, $submitvalue);

}

function resendConfirmC ( $cid, $option ) {
	global $ueConfig, $enhanced_Config;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	include_once ("components/com_cbe/cbe.class.php");
	if (!is_array( $cid ) || count( $cid ) < 1 || $cid[0] == '0') {
		echo "<script> alert('Select an item to resend code to'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	if (count( $cid )) {
		$obj = new JTableUser( $database );
		$output = "<div style=\"text-align:center;height:100px;width:200px;\">\n";
		foreach ($cid as $id) {
			// check for a super admin ... can't delete them
			$groups = $acl->get_object_groups( 'users', $id, 'ARO' );
			$this_group = strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
			if ($this_group == 'super administrator') {
				$msg .= "You can not resend confirm-code to a Super-Admin";
			} else {
				$obj->load($id);
				createEmail($obj,'pending',$ueConfig);
				$output .= "Confirm Code send to user <b>".$obj->username."</b><br/>";
			}
		}
		$output .= "</div>\n";
		echo $output;
	}
}

function show_badUserNames ( $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__cbe_bad_usernames" );

	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	$pageNav = new JPagination( $total, $limitstart, $limit );

	$database->setQuery( "SELECT * FROM #__cbe_bad_usernames ORDER BY id LIMIT $pageNav->limitstart,$pageNav->limit" );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_cbe::show_badUserNames( $rows, $pageNav, $option );
}

function edit_badUserNames( $cid, $option ) {
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new mosbadUserNames( $database );
	$row->load( $cid );

	HTML_cbe::edit_badUserNames( $row, $option );
}

function save_badUserNames( $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$row = new mosbadUserNames( $database );

	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	//mosRedirect( "index2.php?option=com_cbe&task=badUserNames" );
	$mainframe->redirect( "index.php?option=$option&task=badUserNames");
}

function cancel_badUserNames( $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$row = new mosbadUserNames( $database );
	$row->bind( $_POST );
	$row->checkin();
	//mosRedirect( "index2.php?option=com_cbe&task=badUserNames" );
	$mainframe->redirect( "index.php?option=$option&task=badUserNames");

}

function publish_badUserNames( $cid, $publish, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1)
	{
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select a item to ".$action."'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__cbe_bad_usernames SET published=($publish) WHERE id IN ($cids)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1)
	{
		$row = new mosbadUserNames( $database );
		$row->checkin( $cid[0] );
	}

	//mosRedirect( "index2.php?option=com_cbe&task=badUserNames" );
	$mainframe->redirect( "index.php?option=$option&task=badUserNames");

}

function delete_badUserNames( $cid, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (!is_array( $cid ) || count( $cid ) < 1)
	{
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );
	$database->setQuery( "DELETE FROM #__cbe_bad_usernames WHERE id IN ($cids)" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	//mosRedirect( "index2.php?option=com_cbe&task=badUserNames" );
	$mainframe->redirect( "index.php?option=$option&task=badUserNames");

}

// AdMods
function show_AdMods( $option ) {
	global $mainframe, $my, $mosConfig_list_limit;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$task="";
	$search="";
	if (!isset($mosConfig_list_limit)) {
		$limit = 10;
	} else {
		$limit=$mosConfig_list_limit;
	}
	$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	if (ISSET($_POST['task'])) $task=$_POST['task'];
	if($task=='showAdMods') {
		$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
		$search = $database->getEscaped( trim( strtolower( $search ) ) );
	}
	$where = array();
	if (isset( $search ) && $search!= "") {
		$where[] = "(a.title LIKE '%$search%' OR a.content LIKE '%$search%' OR a.plugin_func LIKE '%$search%')";
	}

	// get the total number of records
	$database->setQuery( "SELECT count(*) FROM #__cbe_admods as a "
			  .(count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			  );
	$total = $database->loadResult();
	echo $database->getErrorMsg();

	require_once("includes/pageNavigation.php");
	$pageNav = new JPagination( $total, $limitstart, $limit );

	$database->setQuery( "SELECT * FROM #__cbe_admods as a "
			   .(count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			   ." ORDER BY a.ordering LIMIT $pageNav->limitstart,$pageNav->limit" );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	HTML_cbe::show_AdMods( $rows, $pageNav, $search, $option );
}

function edit_AdMods( $cid, $option ) {
	global $my;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdMods.php');

	$row = new cbeAdMods( $database );
	$row->load( $cid );

	$lists = array();
	$m_pos = array();
	$m_pos[] = JHTML::_('select.option',  'ccpanel', 'Custum cpanel' );
	
	$lists['position'] = JHTML::_('select.genericlist',  $m_pos, 'position', 'class="inputbox" size="1"', 'value', 'text', $row->position );
	$lists['published'] = yesnoSelectList( 'published', 'class="inputbox" size="1"', $row->published );
	
	HTML_cbe::edit_AdMods( $row, $lists, $option );
}

function save_AdMods( $option){
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdMods.php');

	$row = new cbeAdMods( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	JFilterOutput::objectHTMLSafe($row);
	$row->check();
	if ($row->_has_error == 1) {
		echo "<script> alert('"._UE_CBE_ADM_DOUBLET_ERROR."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	//mosRedirect( "index2.php?option=com_cbe&task=showAdMods" );
	$mainframe->redirect( "index.php?option=$option&task=showAdMods");

}

function cancel_AdMods( $option){
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdMods.php');

	$row = new cbeAdMods( $database );
	$row->bind( $_POST );
	$row->checkin();
	//mosRedirect( "index2.php?option=com_cbe&task=showAdMods" );
	$mainframe->redirect( "index.php?option=$option&task=showAdMods");

}

function publish_AdMods( $cid, $publish, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (count( $cid ) < 1)
	{
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select a item to ".$action."'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__cbe_admods SET published=($publish) WHERE id IN ($cids)");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdMods.php');

	if (count( $cid ) == 1)
	{
		$row = new cbeAdMods( $database );
		$row->checkin( $cid[0] );
	}

	//mosRedirect( "index2.php?option=com_cbe&task=showAdMods" );
	$mainframe->redirect( "index.php?option=$option&task=showAdMods");

}

function delete_AdMods( $cid, $option){
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	if (!is_array( $cid ) || count( $cid ) < 1)
	{
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );
	$database->setQuery( "DELETE FROM #__cbe_admods WHERE id IN ($cids) AND iscore = 0" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	//mosRedirect( "index2.php?option=com_cbe&task=showAdMods" );
	$mainframe->redirect( "index.php?option=$option&task=showAdMods");

}

function order_AdMods( $tid, $inc, $option ) {
	global $mainframe;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeAdMods.php');

	$row = new cbeAdMods( $database );
	$row->load( $tid );
	$row->move( $inc );
	//mosRedirect( "index2.php?option=$option&task=showAdMods" );
	$mainframe->redirect( "index.php?option=$option&task=showAdMods");

}


function cbe_catch_task($option, $cid, $listtype) {
	global $mosConfig_live_site, $task;
	global $my, $mainframe, $option, $version;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	
	$admsPath = JPATH_SITE."/administrator/components/com_cbe/adm_mods/";
	$doDefault = 1;

	$admod = '';
	$task = JRequest::getVar('task', null);
	
	$get_adms_query = "SELECT * FROM #__cbe_admods WHERE published = 1 AND plugin_func LIKE '%".$task."%' LIMIT 1";
	$database->setQuery($get_adms_query);
	$admod = $database->loadObject();
	if (!$database->query()) {
		echo "<font color='red'>AdMods Query Error: ".$database->getErrorMsg()."</font>\n<br />\n";
	}
	//die(print_r($database));
	$count = count($admod);
	if ($count > 0) {
		$inc_path = $admsPath.$admod->module."/".$admod->plugin.".php";
		if (file_exists($inc_path)) {
			include_once($inc_path);
		} else {
			echo "<font color='red'>AdminModule Inc-File is missing for ".$admod->module."</font>\n<br />\n";
		}
	}
	
	if ($doDefault == 1) {
		HTML_cbe::controlPanel();
		// mosRedirect( "index2.php?option=com_cbe&task=cpanel" );
	}
}

function cbe_loadQuickIcon( $name, $params) {
	global $mosConfig_live_site, $task;
	global $my, $mainframe, $option, $version;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

	$act = JArrayHelper::getValue( $_REQUEST, 'act', '' );
	$name = str_replace( '/', '', $name );
	$name = str_replace( '\\', '', $name );
	$path = JPATH_SITE . "/administrator/components/com_cbe/adm_mods/cbe_$name.php";
	if (file_exists( $path )) {
		require $path;
	}
}

function cbe_quickiconButton( $link, $image, $text, $cbe_img=0, $rel ) {
	if ($cbe_img == 0) {
		$t = (!empty($rel))?"rel=\"$rel\" class='modal'":"";
		$cbe_qi_out  = "<div style=\"float:left;\">\n";
		$cbe_qi_out .= "\t<div class=\"icon\">\n";
		$cbe_qi_out .= "\t<a href=\"".$link."\" $t>\n";
		$cbe_qi_out .= "\t\t".JHTML::_('image.administrator', $image, '/administrator/images/', NULL, NULL, $text )."\n";
		$cbe_qi_out .= "\t\t<br /><span>".$text."</span>\n";
		$cbe_qi_out .= "\t\t</a>\n";
		$cbe_qi_out .= "\t</div>\n";
		$cbe_qi_out .= "</div>\n";
	} else if ($cbe_img == 1) {
		$cbe_qi_out  = "<div style=\"float:left;\">\n";
		$cbe_qi_out .= "\t<div class=\"icon\">\n";
		$cbe_qi_out .= "\t<a href=\"".$link."\">\n";
		$cbe_qi_out .= "\t\t".JHTML::_('image.administrator', $image, '/administrator/components/com_cbe/adm_img/', NULL, NULL, $text )."\n";
		$cbe_qi_out .= "\t\t<br /><span>".$text."</span>\n";
		$cbe_qi_out .= "\t\t</a>\n";
		$cbe_qi_out .= "\t</div>\n";
		$cbe_qi_out .= "</div>\n";
	}
	return $cbe_qi_out;
}

function cbeInstallExtension() {
	require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_installer'.DS.'models'.DS.'install.php');
	require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBEPluginInstaller.php');

	$lang =& JFactory::getLanguage();
	$lang->load('com_installer',JPATH_ADMINISTRATOR);

	$installerModel = new InstallerModelInstall;

	 // Get an installer instance
	$installer =& JInstaller::getInstance();

	$cbeInstaller = new CBEPluginInstaller($installer);
	$cbe_ext_type = JRequest::getVar('cbe_ext_type', null);

	/* Fix for a small bug on Joomla on PHP 4 */
	if (version_compare(PHP_VERSION, '5.0.0', '<')) {
                // We use eval to avoid PHP warnings on PHP>=5 versions
                eval("\$installer->setAdapter('".$cbe_ext_type."',&\$cbeInstaller);");
        }else {
                $installer->setAdapter($cbe_ext_type,$cbeInstaller);
        }
	$cbeInstaller->parent = &$installer;
	$install->_adapters[$cbe_ext_type] = &$cbeXinstaller;
	/* End of the fix for PHP <= 4 */

        if ($installerModel->install()) {
		//XmapAdminHtml::showInstallMessage(_XMAP_EXT_INSTALLED_MSG, '', 'index.php?option=com_xmap');
		echo "Das Plugin wurde installiert.<br />Sie können die Einstellungen unter der 
		<a href='index.php?option=com_cbe&task=enhancedConfig'>Enhanced Configuration</a> verändern.<br />
		<a href='index.php?option=com_cbe&task=cbeNewExtension'>Zurück zur Übersicht</a>";
        } else {
		echo "Das Plugin konnte leider nicht installiert werden. <br />
		<a href='index.php?option=com_cbe&task=cbeNewExtension'>Zurück zur Übersicht</a>";
		echo $cbeInstaller->getError();
	}
}

function cbeModul($was) {
	switch ($was) {
		case 'cbe_info':
			echo "<iframe height=100 width=100% style='border:1px solid #aaa;' src='".JURI::root()."/administrator/components/com_cbe/info.php'></iframe>";
			exit;
			break;
		case 'cbe_news':
			$modurl = "http://www.joomla-cbe.de/cbe-news/feed/";
			break;
		case 'cbe_forum':
			$modurl = "http://www.joomla-cbe.de/forum/?func=fb_rss&no_html=1";
			break;
		case 'cbe_shop':
			$modurl = "http://www.joomla-cbe.de/cbe-shop/feed/";
			break;
		case 'cbe_callback':
			$modurl = "http://www.joomla-cbe.de/cbe-callback/index.php";
			$fp = @file_get_contents($modurl);
			exit;
			break;
		default:
			exit;
			break;
		}

	jimport('joomla.application.module.helper');
	$mod = &JModuleHelper::getModule('mod_feed');
	$mod->params="moduleclass_sfx=\nrssurl=$modurl\nrssrtl=0\nrsstitle=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=0\ncache=0\ncache_time=15";
	echo JModuleHelper::renderModule($mod);
}

function cbeUpdate() {
	global $mainframe;
	$moo	= JURI::root(true)."/media/system/js/mootools.js";
	$cbeup	= JURI::root(true)."/administrator/components/com_cbe/js/cbeupdate.js";
	$dom	= JURI::root(true)."/administrator/components/com_cbe/js/dombuilder.js";

	$css	= JURI::root(true)."/administrator/templates/" . $mainframe->getTemplate() . "/css/template.css";

	echo <<<EOT
	<html>
	<head>
		<title>CBE Updates</title>
		<script language="JavaScript" src="$moo"></script>
		<script language="JavaScript" src="$cbeup"></script>
		<script language="JavaScript" src="$dom"></script>
		<link rel="stylesheet" type="text/css" href="$css" />
	</head>
	<body>
	<div id='cbe_updates'>
		<h1>CBE Updates</h1>
		<h2>Es stehen folgende Updates zur Verfügung:</h2>
	</div>
	<div id='cbe_update'>
	Lade...
	</div>
	</body>
	</html>
EOT;
}

function cbeUpdateFeed() {
	$dat = @file_get_contents("http://www.joomla-cbe.de/index.php?option=com_cbeupdate&format=raw");
	echo $dat;
}

function cbeCheckUpdate() {
	$bild = JURI::root(true) . "/components/com_cbe/images/tick.png";
	echo "<img border=0 src='$bild' />";
}

function cbeInstallUpdate() {
	jimport('joomla.installer.helper');
	jimport('joomla.installer.installer');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBEPluginInstaller.php');
	$errpic	= JURI::root(true) . "/components/com_cbe/images/reject.png";
	$okpic	= JURI::root(true) . "/components/com_cbe/images/tick.png";

	$ext = JRequest::getVar('ext', '');
	if (empty($ext))
		die("<img src='$errpic' title='Installpackage not defined' border=0 />");

	$installerhelper = new JInstallerHelper();
	$was = $installerhelper->downloadPackage($ext);
	
	if (empty($was))
		die("<img src='$errpic' title='Installpackage could not be downloaded' border=0 />");
	
	$config = &JFactory::getConfig();
	$package = $config->getValue('config.tmp_path').DS.basename($was);
	//die("ext: $ext, was: $was, package: $package, $errpic");

	$tpackage	= $installerhelper->unpack($package);

	// Get an installer instance
	$installer = new JInstaller();//::getInstance();

	$cbe_ext_type = $tpackage['type'];
	$cbeInstaller = new CBEPluginInstaller($installer, $cbe_ext_type);

	/* Fix for a small bug on Joomla on PHP 4 */
	if (version_compare(PHP_VERSION, '5.0.0', '<')) {
		// We use eval to avoid PHP warnings on PHP>=5 versions
		eval("\$installer->setAdapter('".$cbe_ext_type."',&\$cbeInstaller);");
	}else {
		$installer->setAdapter($cbe_ext_type,$cbeInstaller);
	}
	$cbeInstaller->parent = &$installer;
	$install->_adapters[$cbe_ext_type] = &$cbeXinstaller;
	/* End of the fix for PHP <= 4 */

	if (!$installer->install($tpackage['dir']))
		echo "<img src='$errpic' title='" . $cbeInstaller->getError() . "' border=0 />";
	else
		echo "<img src='$okpic' border=0 />";
}

?>

<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: comprofiler.php 609 2006-12-13 17:30:15Z beat $
* @package Community Builder
* @subpackage comprofiler.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_debug, $mosConfig_lang, $mosConfig_emailpass, $option, $task;

if($mosConfig_debug) {
	ini_set('display_errors',true);
	error_reporting(E_ALL);
}

/** @global mosMainFrame $mainframe
 *  @global mosUser $my
 *  @global gacl_api $acl
 *  @global stdClass $access
 */
global $access, $mainframe, $my, $acl;
$access = new stdClass();
$access->canEdit = $acl->acl_check( 'action', 'edit', 'users', $my->usertype, 'content', 'all' );
$access->canEditOwn = $acl->acl_check( 'action', 'edit', 'users', $my->usertype, 'content', 'own' );

require_once ( $mainframe->getPath( 'front_html' ) );
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
include_once($_CB_adminpath."/imgToolbox.class.php");

$UElanguagePath	= $mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
$UElanguage		= $mainframe->getCfg( 'lang' );
if ( ! file_exists( $UElanguagePath . '/' . $mosConfig_lang . '/' . $mosConfig_lang . '.php' ) ) {
	$UElanguage = 'default_language';
}
include_once( $UElanguagePath . '/' . $UElanguage . '/' . $UElanguage . '.php' );

/**
 * @global int $_CB_ui   : we're in 1: frontend, 2: admin back-end
 */
global $_CB_ui;
$_CB_ui = 1;

$form	=	cbGetParam( $_REQUEST, 'reportform', 1 );
$uid	=	cbGetParam( $_REQUEST, 'uid', 0 );
$act	=	cbGetParam( $_REQUEST, 'act', 1 );

if(!isset($mosConfig_emailpass) || is_null($mosConfig_emailpass)) $mosConfig_emailpass=0;

$oldignoreuserabort = null;

switch( $task ) {

	case "userDetails":
	case "userdetails":
	userEdit( $option, $uid, _UE_UPDATE );
	break;

	case "saveUserEdit":
	case "saveuseredit":
	$oldignoreuserabort = ignore_user_abort(true);
	userSave( $option, (int) cbGetParam( $_POST, 'id', 0 ) );
	break;
	
	case "userProfile":
	case "userprofile":
	userProfile($option, $my->id, _UE_UPDATE);
	break;

	case "usersList":
	case "userslist":
	usersList($my->id);
	break;

	case "userAvatar":
	case "useravatar":
	userAvatar($option, $uid, _UE_UPDATE);
	break;

	case "lostPassword":
	case "lostpassword":
	lostPassForm( $option );
	break;

	case "sendNewPass":
	case "sendnewpass":
	$oldignoreuserabort = ignore_user_abort(true);
	sendNewPass( $option );
	break;

	case "registers":
	registerForm( $option, $mosConfig_emailpass );
	break;

	case "saveregisters":
	$oldignoreuserabort = ignore_user_abort(true);
	saveRegistration( $option );
	break;

	case "login":
	$oldignoreuserabort = ignore_user_abort(true);
	login();
	break;
	
	case "logout":
	$oldignoreuserabort = ignore_user_abort(true);
	logout();
	break;

	case "confirm":
	$oldignoreuserabort = ignore_user_abort(true);
	confirm( cbGetParam( $_GET, 'confirmcode', '1' ) );		// mambo 4.5.3h braindead: does intval of octal from hex in cbGetParam...
	break;

	case "moderateImages":
	case "moderateimages":
	$oldignoreuserabort = ignore_user_abort(true);
	moderateImages($option);
	break;

	case "moderateReports":
	case "moderatereports":
	$oldignoreuserabort = ignore_user_abort(true);
	moderateReports($option);
	break;

	case "moderateBans":
	case "moderatebans":
	$oldignoreuserabort = ignore_user_abort(true);
	moderateBans($option,$act,$uid);
	break;

	case "approveImage":
	case "approveimage":
	$oldignoreuserabort = ignore_user_abort(true);
	approveImage();
	break;

	case "reportUser":
	case "reportuser":
	$oldignoreuserabort = ignore_user_abort(true);
	reportUser($option,$form,$uid);
	break;

	case "processReports":
	case "processreports":
	$oldignoreuserabort = ignore_user_abort(true);
	processReports();
	break;

	case "banProfile":
	case "banprofile":
	$oldignoreuserabort = ignore_user_abort(true);
	banUser($option,$uid,$form,$act);
	break;

	case "viewReports":
	case "viewreports":
	viewReports($option,$uid,$act);
	break;

	case "emailUser":
	case "emailuser":
	emailUser($option,$uid);
	break;

	case "pendingApprovalUser":
	case "pendingapprovaluser":
	pendingApprovalUsers($option);
	break;

	case "approveUser":
	case "approveuser":
	$oldignoreuserabort = ignore_user_abort(true);
	approveUser(cbGetParam($_POST,'uids'));
	break;

	case "rejectUser":
	case "rejectuser":
	$oldignoreuserabort = ignore_user_abort(true);
	rejectUser(cbGetParam($_POST,'uids'));
	break;

	case "sendUserEmail":
	case "senduseremail":
	$oldignoreuserabort = ignore_user_abort(true);
	sendUserEmail( $option, (int) cbGetParam( $_POST, 'toID', 0 ), (int) cbGetParam( $_POST, 'fromID', 0 ), cbGetParam( $_POST, 'emailSubject', '' ), cbGetParam( $_POST, 'emailBody', '' ) );
	break;

	case "addConnection":
	case "addconnection":
	$oldignoreuserabort = ignore_user_abort(true);
	addConnection($my->id, (int) cbGetParam($_REQUEST,'connectionid'), ((isset($_POST['message'])) ? cbGetParam($_POST,'message') : ""));
	break;

	case "removeConnection":
	case "removeconnection":
	$oldignoreuserabort = ignore_user_abort(true);
	removeConnection($my->id,cbGetParam($_REQUEST,'connectionid'));
	break;

	case "denyConnection":
	case "denyconnection":
	$oldignoreuserabort = ignore_user_abort(true);
	denyConnection($my->id,cbGetParam($_REQUEST,'connectionid'));
	break;	

	case "acceptConnection":
	case "acceptconnection":
	$oldignoreuserabort = ignore_user_abort(true);
	acceptConnection($my->id,cbGetParam($_REQUEST,'connectionid'));
	break;

	case "manageConnections":
	case "manageconnections":
	manageConnections($my->id);
	break;

	case "saveConnections":
	case "saveconnections":
	$oldignoreuserabort = ignore_user_abort(true);
	saveConnections(cbGetParam($_POST,'uid'));
	break;

	case "processConnectionActions":
	case "processconnectionactions":
	$oldignoreuserabort = ignore_user_abort(true);
	processConnectionActions(cbGetParam($_POST,'uid'));
	break;

	case "teamCredits":
	case "teamcredits":
	teamCredits(1);
	break;

	case "tabclass":
	tabClass($option, $my->id);
	break;

	case "done":
	break;

	case "checkusernameavailability":
	checkUsernameAvailability( cbGetParam( $_POST, 'username' ) );
	break;

	default:
	userProfile($option, $my->id, _UE_UPDATE);
	break;
}
if (!is_null($oldignoreuserabort)) ignore_user_abort($oldignoreuserabort);

function sendUserEmail( $option, $toid, $fromid, $subject, $message ) {
	global $ueConfig,$my, $_CB_database, $_POST, $_PLUGINS;

	// simple spoof check security
	cbSpoofCheck();
	$errorMsg	=	cbAntiSpamCheck( false );

	if (($my->id == 0) || ($my->id != $fromid) || ( ! $toid ) || ($ueConfig['allow_email_display']!=1 && $ueConfig['allow_email_display']!=3)) {
		mosNotAuth();
		return;
	}

	$rowFrom = new mosUser( $_CB_database );
	$rowFrom->load( (int) $fromid );
	
	$rowTo = new mosUser( $_CB_database );
	$rowTo->load( (int) $toid );

	$subject	=	stripslashes( $subject );		// cbGetParam() adds slashes...remove'em...
	$message	=	stripslashes( $message );
	
	if ( ! $errorMsg ) {
		$errorMsg	=	_UE_SESSIONTIMEOUT . " " . _UE_SENTEMAILFAILED;
		if ( isset( $_POST["protect"] ) ) {
			$parts	=	explode( '_', cbGetParam( $_POST, 'protect', '' ) );
			if ( ( count( $parts ) == 3 ) && ( $parts[0] == 'cbmv1' ) && ( strlen( $parts[2] ) == 16 ) && ( $parts[1] == md5($parts[2].$rowTo->id.$rowTo->password.$rowTo->lastvisitDate.$rowFrom->password.$rowFrom->lastvisitDate) ) ) {
				$errorMsg	=	null;
				$_PLUGINS->loadPluginGroup('user');
				$pluginResults = $_PLUGINS->trigger( 'onBeforeEmailUser', array( &$rowFrom, &$rowTo, 1 ));	//$ui=1
				if ($_PLUGINS->is_errors()) {
					$errorMsg	=	$_PLUGINS->getErrorMSG( '<br />') . "\n";
				} else {
					$spamCheck = cbSpamProtect( $my->id, true );
					if ( $spamCheck ) {
						$errorMsg	=	$spamCheck;
					} else {
						$cbNotification	=	new cbNotification();
						$res			=	$cbNotification->sendUserEmail($toid,$fromid,$subject,$message, true);
					
						if ($res) {
							echo _UE_SENTEMAILSUCCESS;
							if (is_array($pluginResults)) {
								echo implode( "<br />", $pluginResults );
							}
							return;
						}
						else {
							$errorMsg	=	_UE_SENTEMAILFAILED;
						}
					}
				}
			}
		}
	}
	echo '<div class="error">' . $errorMsg . '</div>';
	HTML_comprofiler::emailUser( $option, $rowFrom, $rowTo, $subject, $message );
}

function emailUser($option,$uid) {
	global $_CB_database,$ueConfig,$my;
	if (($my->id == 0) || ($ueConfig['allow_email_display']!=1 && $ueConfig['allow_email_display']!=3)) {
		mosNotAuth();
		return;
	}
	
	$spamCheck = cbSpamProtect( $my->id, false );
	if ( $spamCheck ) {
		echo $spamCheck;
		return;
	}
	$rowFrom = new mosUser( $_CB_database );
	$rowFrom->load( $my->id );
	
	$rowTo = new mosUser( $_CB_database );
	$rowTo->load( (int) $uid );	
	HTML_comprofiler::emailUser($option,$rowFrom,$rowTo);
}

function userEdit( $option, $uid, $submitvalue, $regErrorMSG=null ) {
	global $_CB_database, $ueConfig, $_POST, $my;

	$msg	=	cbCheckIfUserCanPerformUserTask( $uid, 'allowModeratorsUserEdit');
	if ( $msg ) {
		echo $msg;
		return;
	}

	$_CB_database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id=".(int) $uid);
	$users = $_CB_database->loadObjectList();
	$user = $users[0];

	$user->name		=	unHtmlspecialchars( $user->name );		// revert effect of mosMakeHtmlSafe on user save.

	if($regErrorMSG!==null) {
		// simple spoof check security
		//cbSpoofCheck();	Already done in UserSave()
		$user->firstname	= stripslashes( cbGetParam( $_POST, 'firstname', '' ) );
		$user->middlename	= stripslashes( cbGetParam( $_POST, 'middlename', '' ) );
		$user->lastname		= stripslashes( cbGetParam( $_POST, 'lastname', '' ));
		$user->name			= stripslashes( cbGetParam( $_POST, 'name', '' ) );
		$user->username		= stripslashes( cbGetParam( $_POST, 'username', '' ) );
		$user->email		= stripslashes( cbGetParam( $_POST, 'email', '' ) );
		
		$_CB_database->setQuery( "SELECT f.* FROM #__comprofiler_fields f, #__comprofiler_tabs t"
						. "\n WHERE f.published=1 and f.tabid = t.tabid AND t.enabled=1 AND f.readonly=0 AND t.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")" );
		$rowFields = $_CB_database->loadObjectList();
		$cbFields=new cbFields();
		for ($i=0, $n=is_array($rowFields) ? count( $rowFields ) : 0; $i < $n; $i++) {
			$field=cbGetEscaped($rowFields[$i]->name);
			$value=null;
			if(isset($_POST[$rowFields[$i]->name])) {
				$value = $_POST[$rowFields[$i]->name];
			}
			$user->$field = $cbFields->prepareFieldDataSave( $rowFields[$i]->fieldid, $rowFields[$i]->type, $rowFields[$i]->name, $value );
		}
		// save user params
		$params = cbGetParam( $_POST, 'cbparams', null );
		//echo "params:".print_r($params);
		if($params != null) {
			if (is_array( $params )) {
				$txt = array();
				foreach ( $params as $k=>$v) {
					$txt[] = "$k=$v";
				}
				$user->params = implode( "\n", $txt );
			}
		}
	}
	
	HTML_comprofiler::userEdit( $user, $option, $submitvalue, $regErrorMSG );
}

function userAvatar( $option, $uid, $submitvalue) {
	global $_CB_database;

	$msg	=	cbCheckIfUserCanPerformUserTask( $uid, 'allowModeratorsUserEdit');
	if ( $msg ) {
		echo $msg;
		return;
	}
	$row = new mosUser( $_CB_database );
	$row->load( (int) $uid );
	$row->orig_password = $row->password;
	HTML_comprofiler::userAvatar( $row, $option, $submitvalue);
}

function setUserDBrequest( $uid ) {
	global $_CB_database, $_REQUEST;
	
	if (!isset($_REQUEST['user'])) {
		if (!$uid) {
			return false;
		}
		$_CB_database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id=".(int) $uid);
	} else {
		$userReq = urldecode(stripslashes( cbGetParam( $_REQUEST, 'user' ) ) );
		$len = strlen( $userReq );
		if (($len > 2) && (substr($userReq, 0, 1) == "'") && (substr($userReq, $len-1, 1) == "'")) {
			$userReq = substr($userReq, 1, $len-2);
			$_CB_database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND u.username='" . cbGetEscaped(utf8ToISO($userReq)) . "'");
		} else {
			$_CB_database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id=" . (int) $userReq );
		}
	}
	return true;
}

function userProfile( $option, $uid, $submitvalue) {
	global $_CB_database, $_REQUEST, $ueConfig,$my, $acl, $mosConfig_allowUserRegistration;
	if ( isset( $_REQUEST['user'] ) ) {
		if ( ! allowAccess( $ueConfig['allow_profileviewbyGID'], 'RECURSE', userGID( $my->id ) ) ) {
			if (	( $my->id < 1 )
				&&	( ! ( ( ( $mosConfig_allowUserRegistration == '0' )
		   				    && ( ( ! isset($ueConfig['reg_admin_allowcbregistration']) ) || $ueConfig['reg_admin_allowcbregistration'] != '1' ) )
						)
					)
					&&
					allowAccess( $ueConfig['allow_profileviewbyGID'], 'RECURSE', $acl->get_group_id('Registered','ARO') )
			) {
				echo _UE_REGISTERFORPROFILEVIEW;
			} else {
				echo _UE_NOT_AUTHORIZED;
			}
			return;
		}
	} else {
		if ($uid==0) {
			echo _UE_REGISTERFORPROFILE;
			return;
		}
	}
	$users=array();
	if (setUserDBrequest($uid)) {
		$users = $_CB_database->loadObjectList();
	}
	if (count($users)==0) { 
		echo _UE_NOSUCHPROFILE; 
		return; 
	}

	$user = $users[0];

	HTML_comprofiler::userProfile( $user, $option, $submitvalue);
}

function tabClass( $option, $uid ) {
	global $_CB_database, $ueConfig,$my;

	$users=array();
	if (setUserDBrequest($uid)) {
		$users = $_CB_database->loadObjectList();
	}

	if (count($users)==0) { 
		$user = null;
	} else {
		$user = $users[0];
	}
	HTML_comprofiler::tabClass( $user, $option );
}

function usersList($uid) {
	global $_CB_database, $my, $acl, $ueConfig, $_PLUGINS, $_POST, $_REQUEST;

	$search					=	"";
	$searchPOST				=	stripslashes( cbGetParam( $_POST, 'search', "" ) );
	$searchGET				=	stripslashes( cbGetParam( $_GET, 'search', "" ) );
	$limitstart				=	(int) cbGetParam( $_REQUEST, 'limitstart', 0 );
	$limit					=	$ueConfig['num_per_page'];

	if ( $searchPOST || count( $_POST ) ) {
		// simple spoof check security
		cbSpoofCheck();
		if ( cbGetParam( $_GET, "action" ) == "search" ) {
			$search			=	$searchPOST;
		}
	} elseif ( $searchGET || $limitstart ) {
		cbSpoofCheck( 'GET' );
		if ( isset( $_GET['limitstart'] ) ) {
			$search			=	$searchGET;
		}
	}

	$useraccessgroupSQL		=	" AND useraccessgroupid IN (".implode(',',getChildGIDS(userGID($uid))).")";
	$_CB_database->setQuery("SELECT listid, title FROM #__comprofiler_lists WHERE published=1" . $useraccessgroupSQL . " ORDER BY ordering");
	$plists					=	$_CB_database->loadObjectList();
	$lists					=	array();
	$publishedlists			=	array();

	for ( $i=0, $n=count( $plists ); $i < $n; $i++ ) {
		$plist				=&	$plists[$i];
	   	$publishedlists[]	=	mosHTML::makeOption( $plist->listid, getLangDefinition($plist->title) );
	}

	if ( ( ! isset( $_POST['listid'] ) ) && ( ! ( isset( $_GET['listid'] ) ) ) ) {
		$_CB_database->setQuery( "SELECT listid FROM #__comprofiler_lists "
		. "\n WHERE `default`=1 AND published=1" . $useraccessgroupSQL );
		$listid				=	(int) $_CB_database->loadresult();
		if ( $listid == 0 && ( count( $plists ) > 0 ) ) {
			$listid			=	(int) $plists[0]->listid;
		}
	} else {
		if ( isset( $_POST['listid'] ) ) {
			$listid			=	(int) cbGetParam( $_POST, 'listid', 0 );
		} else {
			$listid			=	(int) cbGetParam( $_GET, 'listid', 0 );
		}
	}
	if ( ! ( $listid > 0 ) ) {
		echo _UE_NOLISTFOUND;
		return;
	}
	if ( count( $plists ) > 1 ) {
		$lists['plists']	= mosHTML::selectList( $publishedlists, 'listid', 'class="inputbox" size="1" onchange="this.form.submit();"', 'value', 'text', $listid );
	} else {
		$lists['plists']	= "&nbsp;";
	}
	
	$row					=	new moscomprofilerLists( $_CB_database );
	if ( ( ! $row->load( (int) $listid ) ) || ( $row->published != 1 ) ) {
		echo _UE_LIST_DOES_NOT_EXIST;
		return;
	}
	if (!allowAccess( $row->useraccessgroupid,'RECURSE', userGID($uid))) {
		echo _UE_NOT_AUTHORIZED;
		return;
	}

	$isModerator			=	isModerator( $my->id );

	$_PLUGINS->loadPluginGroup( 'user' );
	$plugSearchFieldsArray	=	$_PLUGINS->trigger( 'onStartUsersList', array( &$listid, &$row, &$search, &$limitstart, &$limit, 1 ) );	// $uid = 1

	$allusergids			=	array();
	$usergids				=	explode(",",$row->usergroupids);
	foreach( $usergids AS $usergid ) {
		$allusergids[]		=	$usergid;
		if ($usergid==29 || $usergid==30) {
			$groupchildren	=	array();
			$groupchildren	=	$acl->get_group_children( $usergid, 'ARO','RECURSE' );
			$allusergids	=	array_merge($allusergids,$groupchildren);
		}
	}
	$usergids				=	implode( ",", $allusergids );

	// Select query
	if($row->sortfields!='') {
		$orderby			=	" ORDER BY " . $row->sortfields;
	}
	$filterby="";
	if($row->filterfields!='') {
		$filterby			=	" AND ". utf8RawUrlDecode( substr( $row->filterfields, 1 ) );
	}

	// Prepare part after SELECT .... " and before "FROM" :
	$queryFrom = "FROM #__users u, #__comprofiler ue WHERE u.id = ue.id AND u.block = 0 AND ue.approved = 1".( !($isModerator) ? " AND ue.banned = 0" : "")." AND ue.confirmed = 1 AND u.gid IN (".$usergids.")";
	if ( $search != "" ) {
		$searchSQL			=	cbEscapeSQLsearch( strtolower( $_CB_database->getEscaped( $search ) ) );
		$queryFrom 			.=	" AND (";
		
		$searchFields		=	array();
		if ( $ueConfig['name_format']!='3' ) {
			$searchFields[]	=	"u.name LIKE '%%s%'";
		}
		if ( $ueConfig['name_format']!='1' ) {
			$searchFields[]	=	"u.username LIKE '%%s%'";
		}
		foreach ( $plugSearchFieldsArray as $v ) {
			if ( is_array( $v ) ) {
				$searchFields = array_merge( $searchFields, $v );
			}
		}
		for ( $i = 0, $n = count( $searchFields ); $i < $n; ++$i ) {
			$searchFields[$i]	=	str_replace( '%s', $searchSQL, $searchFields[$i] );
		}
		$queryFrom			.=	implode( " OR ", $searchFields );
		$queryFrom			.=	")";
	}
	$queryFrom				.=	" " . $filterby;

	$_PLUGINS->trigger( 'onBeforeQueryUsersList', array( &$queryFrom, 1 ) );	// $uid = 1

	$_CB_database->setQuery( "SELECT COUNT(*) " . $queryFrom );
	$total			=	$_CB_database->loadResult();

	if ( ( $limit > $total ) || ( $limitstart >= $total ) ) {
		$limitstart = 0;
	}

	$query = "SELECT *, '' AS 'NA' " . $queryFrom . " " . $orderby . " LIMIT " . (int) $limitstart . ", " . (int) $limit;

	$_CB_database->setQuery($query);
	$users				=	$_CB_database->loadObjectList();

	//Make columns array. This array will later be constructed from the tabs table:

	$columns=array();
	
	for ( $i = 1; $i < 50; ++$i ) {
		$enabledVar			=	"col".$i."enabled";

		if ( ! isset( $row->$enabledVar ) ) {
			break;
		}
		$titleVar			=	"col".$i."title";
		$fieldsVar			=	"col".$i."fields";
		$captionsVar		=	"col".$i."captions";

		if( $row->$enabledVar == 1 ){
			$col			=	new stdClass();
			$col->fields	=	( $row->$fieldsVar ? explode( '|*|', $row->$fieldsVar ) : array() );
			$col->title		=	$row->$titleVar;
			$col->captions	=	$row->$captionsVar;
			// $col->sort		=	1; //All columns can be sorted
			$columns[]=$col;
		}
	}

	// Fetch all fields:
	
	$_CB_database->setQuery("SELECT * FROM #__comprofiler_fields WHERE published = 1");
	$allFields				=	$_CB_database->loadObjectList( 'fieldid' );

	// Compute itemId of users in users-list:
	$itemId					=	(int) cbGetParam( $_REQUEST, 'Itemid', 0 );
	if ( $itemId ) {
		$option_itemid		=	"&amp;Itemid=" . $itemId;
	} else {
		$option_itemid		=	getCBprofileItemid( true );
	}

	HTML_comprofiler::usersList( $row, $users, $columns, $allFields, $lists, $listid, $search, $option_itemid, $limitstart, $limit, $total );
}

function userSave($option, $uid) {
	global $_CB_database, $ueConfig, $_POST, $_PLUGINS, $_CB_framework, $my, $mosConfig_uniquemail;

	// simple spoof check security
	cbSpoofCheck();

	$msg	=	cbCheckIfUserCanPerformUserTask( $uid, 'allowModeratorsUserEdit');
	if ( $msg ) {
		echo $msg;
		return;
	}

	$row = new mosUser( $_CB_database );
	$row->load( $uid );
	$row->orig_password = $row->password;

	$original_email	=	$row->email;

	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".addslashes(unhtmlentities($row->getError()))."');</script>\n";
		userEdit($option, $uid, _UE_UPDATE, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;

	}

	$firstname		= trim( stripslashes( cbGetParam( $_POST, 'firstname', '' ) ) );
	$middlename		= trim( stripslashes( cbGetParam( $_POST, 'middlename', '' ) ) );
	$lastname		= trim( stripslashes( cbGetParam( $_POST, 'lastname', '' ) ) );

	switch ( $ueConfig['name_style'] ) {
		case 2:
			$row->name = $firstname . ' ' . $lastname;
		break;
		case 3:
			$row->name = $firstname . ' ' . ( $middlename ? ( $middlename . ' ' ) : '' ) . $lastname;
		break;
		default:
		break;
	}
	
	$row->username	= trim ( $row->username );
	$row->email		= trim ( $row->email );

	mosMakeHtmlSafe($row);


	if(isset($_POST["password"]) && $_POST["password"] != "") {
		if(isset($_POST["verifyPass"]) && ($_POST["verifyPass"] == $_POST["password"])) {
			$row->password	=	cbHashPassword( $row->password );
		} else {
			echo "<script type=\"text/javascript\"> alert(\""._PASS_MATCH."\");</script>\n";
			userEdit($option, $uid, _UE_UPDATE, _PASS_MATCH );
			return;

		}
	} else {
		// Restore 'original password'
		$row->password = $row->orig_password;
	}
	
	// fix a joomla 1.0 bug preventing from saving profile without changing email if site switched from uniqueemails = 0 to = 1 and duplicates existed
	$original_uniqueemail	=	$mosConfig_uniquemail;
	if ( $mosConfig_uniquemail && ( $row->email == $original_email ) ) {
		$mosConfig_uniquemail	=	0;
	}
	if (!$row->check()) {
		$mosConfig_uniquemail	=	$original_uniqueemail;
		echo "<script type=\"text/javascript\"> alert('".addslashes(unhtmlentities($row->getError()))."');</script>\n";
		userEdit($option, $uid, _UE_UPDATE, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;
	}
	if ( $original_uniqueemail && ( $row->email == $original_email ) ) {
		$mosConfig_uniquemail	=	$original_uniqueemail;
	}
	unset($row->orig_password); // prevent DB error!!
	
	

	$_CB_database->setQuery( "SELECT f.* FROM #__comprofiler_fields f, #__comprofiler_tabs t"
	. "\n WHERE f.published=1 and f.tabid = t.tabid AND t.enabled=1 " . /* AND f.readonly=0 */ "AND t.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")" );
	$rowFields = $_CB_database->loadObjectList();

	$reqErrors = array();

	$cbFields=new cbFields();
	$rowExtras = new moscomprofiler($_CB_database);

	$_CB_database->setQuery( "SELECT * FROM #__comprofiler c WHERE c.id=".(int) $uid);
	$oldRowExtrasList	=	$_CB_database->loadObjectList();
	$oldRowExtras		=	$oldRowExtrasList[0];
	for($i=0, $n=is_array($rowFields) ? count( $rowFields ) : 0; $i < $n; $i++) {
		$field		=	cbGetEscaped( $rowFields[$i]->name );
		if ( $rowFields[$i]->readonly === '0' ) {
			$value=null;
			if(isset($_POST[$rowFields[$i]->name])) {
				$value = $_POST[$rowFields[$i]->name];
			}
			$rowExtras->$field = $cbFields->prepareFieldDataSave( $rowFields[$i]->fieldid, $rowFields[$i]->type, $rowFields[$i]->name, $value );
			if ($rowExtras->$field == "" && $rowFields[$i]->required == 1 && !in_array($rowFields[$i]->type, array("delimiter", "hidden"))) {
				$reqErrors[] = getLangDefinition($rowFields[$i]->title) . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
			}
		} else {
			$rowExtras->$field	=	$oldRowExtras->$field;
		}
	}
	
	$rowExtras->id				= $uid;
	$rowExtras->user_id			= $uid;
	$rowExtras->lastupdatedate	= date('Y-m-d\TH:i:s');
	$rowExtras->firstname		= trim( stripslashes( cbGetParam( $_POST, 'firstname', '' ) ) );
	$rowExtras->middlename		= trim( stripslashes( cbGetParam( $_POST, 'middlename', '' ) ) );
	$rowExtras->lastname		= trim( stripslashes( cbGetParam( $_POST, 'lastname', '' ) ) );

	if (in_array($_CB_framework->getCfg("frontend_userparams"), array('1', null))) {
		// save user params
		$params = cbGetParam( $_POST, 'cbparams', null );
		if($params != null) {
			if (is_array( $params )) {
				$txt = array();
				foreach ( $params as $k=>$v) {
					$txt[] = "$k=$v";
				}
				$row->params = implode( "\n", $txt );
			}
		}
	}
	
	// check server-side the JS front-end checks:
	switch( $ueConfig['name_style'] ) {
		case 2:
		case 3:
			if ($rowExtras->firstname == "") {
				$reqErrors[] = _UE_YOUR_FNAME . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
			}
			if ($rowExtras->lastname == "") {
				$reqErrors[] = _UE_YOUR_LNAME . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
			}
		break;
		default:
		break;
	}
	if (strlen($row->username) < 3) {
		$reqErrors[] = sprintf( unHtmlspecialchars(_VALID_AZ09), unHtmlspecialchars(_PROMPT_UNAME), 2 );
	}
	if(isset($_POST["password"]) && $_POST["password"] != "") {
		if (strlen(cbGetUnEscaped($_POST["password"])) < 6) {
			$reqErrors[] = sprintf( unHtmlspecialchars(_VALID_AZ09), unHtmlspecialchars(_REGISTER_PASS), 6 );
		} elseif (isset($_POST["verifyPass"]) && ($_POST["verifyPass"] != $_POST["password"])) {
			$reqErrors[] = unHtmlspecialchars(_REGWARN_VPASS2);
		}
	}
	if (count($reqErrors) > 0) {
		echo "<script type=\"text/javascript\">alert(\'".addslashes(implode('\n',$reqErrors))."'); </script>\n";
		userEdit($option, $uid, _UE_UPDATE, implode("<br />",$reqErrors)."<br />" );
		return;
	}

	$_PLUGINS->loadPluginGroup('user');
	$_PLUGINS->trigger( 'onBeforeUserUpdate', array(&$row,&$rowExtras));
	if($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); </script>\n";
		userEdit($option, $uid, _UE_UPDATE, $_PLUGINS->getErrorMSG("<br />") );
		return;
	}

	$userComplete =& moscomprofiler::dbObjectsMerge($row, $rowExtras);
	$tabs = new cbTabs( 0, 1, null, false );
	$tabs->savePluginTabs($userComplete, $_POST);		// this changes $row and $rowExtras by reference in $userComplete
	if($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); </script>\n";
		userEdit($option, $uid, _UE_UPDATE, $_PLUGINS->getErrorMSG("<br />") );
		return;
	}
	
	if ( ! $row->store() ) {
		echo "<script type=\"text/javascript\"> alert('store user:".addslashes(unhtmlentities($row->getError()))."');</script>\n";
		userEdit($option, $uid, _UE_UPDATE, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;
	}
	
	if ( ! $_CB_database->updateObject( '#__comprofiler', $rowExtras, 'id', false ) ) {
		echo "<script type=\"text/javascript\"> alert('store comprofiler:".addslashes(unhtmlentities($_CB_database->stderr(true)))."'); window.history.go(-1); </script>\n";
	}

	$_PLUGINS->trigger( 'onAfterUserUpdate', array($row, $rowExtras, true));

	cbRedirectToProfile( $uid, _USER_DETAILS_SAVE );
}

function lostPassForm( $option ) {
	global $mainframe;
	
	if (method_exists($mainframe, "SetPageTitle")) $mainframe->SetPageTitle(_PROMPT_PASSWORD);
	HTML_comprofiler::lostPassForm($option);
}

function sendNewPass( $option ) {
	global $_CB_database, $Itemid;
	global $ueConfig,$_PLUGINS;
	// for _NEWPASS_MSG and _NEWPASS_SUB :
	global $mosConfig_live_site, $mosConfig_sitename;
	
	// simple spoof check security
	cbSpoofCheck();

	// ensure no malicous sql gets past
	$checkusername = trim( cbGetParam( $_POST, 'checkusername', '') );
	$confirmEmail = trim( cbGetParam( $_POST, 'confirmEmail', '') );

	$_PLUGINS->loadPluginGroup('user');
	$_PLUGINS->trigger( 'onStartNewPassword', array( &$checkusername, &$confirmEmail ));
	if ($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); window.history.go(-1); </script>\n";
		exit();
	}

	// these two are used by _NEWPASS_SUB message below:
	$_live_site = $mosConfig_live_site;
	$_sitename = "";	// NEEDED BY _NEWPASS_SUB for  sitename already added in subject by cbNotification class. was = $mosConfig_sitename;

	$_CB_database->setQuery( "SELECT id FROM #__users"
	. "\nWHERE username='$checkusername' AND email='$confirmEmail'"
	);

	if (!($user_id = $_CB_database->loadResult()) || !$checkusername || !$confirmEmail) {
		cbRedirect(sefRelToAbs("index.php?option=$option&task=lostPassword".($Itemid ? "&Itemid=".$Itemid : "")),_ERROR_PASS );
	}

	$newpass = cbMakeRandomString( 8, true );
	$message = _NEWPASS_MSG;
	eval ("\$message = \"$message\";");
	$subject = _NEWPASS_SUB;
	eval ("\$subject = \"$subject\";");

	$_PLUGINS->trigger( 'onBeforeNewPassword', array( $user_id, &$newpass, &$subject, &$message ));
	if ($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); window.history.go(-1); </script>\n";
		exit();
	}

	$cbNotification = new cbNotification();
	$res	=	$cbNotification->sendFromSystem($user_id,$subject,$message);
	
	
	if ($res) {
		$_PLUGINS->trigger( 'onNewPassword', array($user_id,$newpass));

		$newpass	=	cbHashPassword( $newpass );
		$sql		=	"UPDATE #__users SET password = '" . $_CB_database->getEscaped( $newpass ) . "' WHERE id = " . (int) $user_id;
		$_CB_database->setQuery( $sql );
		if (!$_CB_database->query()) {
			die("SQL error" . $_CB_database->stderr(true));
		}

	 	cbRedirect(sefRelToAbs("index.php?option=$option&task=done".($Itemid ? "&Itemid=".$Itemid : "")),_NEWPASS_SENT );
	 } else { 
		cbRedirect(sefRelToAbs("index.php?option=$option&task=done".($Itemid ? "&Itemid=".$Itemid : "")),_UE_NEWPASS_FAILED );
	}
}

function registerForm( $option, $emailpass,$regErrorMSG=null ) {
	global $mosConfig_allowUserRegistration, $ueConfig, $_CB_database, $my, $acl, $_POST, $_PLUGINS;

	if ( ( ( $mosConfig_allowUserRegistration == '0' )
		   && ( ( ! isset($ueConfig['reg_admin_allowcbregistration']) ) || $ueConfig['reg_admin_allowcbregistration'] != '1' ) )
		 || $my->id ) {
		mosNotAuth();
		return;
	}

	$fieldsQuery = "SELECT f.*, t.ordering_register AS tab_ordering_register, t.position AS tab_position, t.ordering AS tab_ordering FROM #__comprofiler_fields f, #__comprofiler_tabs t"
			. "\n WHERE t.tabid = f.tabid AND f.published=1 AND f.registration=1 AND t.enabled=1"		// AND t.useraccessgroupid = -2
			. "\n ORDER BY t.ordering_register, t.position, t.ordering, f.ordering";

	$_PLUGINS->loadPluginGroup('user');
	$results = $_PLUGINS->trigger( 'onBeforeRegisterForm', array( $option, $emailpass, &$regErrorMSG, &$fieldsQuery ) );
	if($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG(" ; "))."'); </script>\n";
		echo $_PLUGINS->getErrorMSG("<br />");
		return;
	}
	if ( implode( $results ) != "" ) {
		$allResults = implode( "</div><div>", $results );
		echo "<div>" . $allResults . "</div>";
		return;
	}

	$_CB_database->setQuery( $fieldsQuery );
	$rowFields = $_CB_database->loadObjectList();
	$rowFieldValues=array();
	for ($i=0, $n=is_array($rowFields) ? count( $rowFields ) : 0; $i < $n; $i++) {
		$rowFields[$i]->readonly = 0;		// read-only setting must be ignored at registration, as it's for profile only.
		$k="";
		if ($regErrorMSG!==null) {
			if (isset($_POST[$rowFields[$i]->name]) || ($rowFields[$i]->type=='webaddress' && $rowFields[$i]->rows==2 && isset($_POST[$rowFields[$i]->name."Text"]))) {
				if (is_array($_POST[$rowFields[$i]->name])) $k = implode("|*|",$_POST[$rowFields[$i]->name]);
				else $k=$_POST[$rowFields[$i]->name];
				$k=htmlspecialchars(cbGetUnEscaped($k));
			}
		} else {
			if ( $rowFields[$i]->type=='webaddress' && $rowFields[$i]->rows==2 ) {
				$webAdrEls			= explode( "|*|", ((get_magic_quotes_gpc()==1) ? addslashes($rowFields[$i]->default) : $rowFields[$i]->default) );
				$_POST[$rowFields[$i]->name] = isset( $webAdrEls[1] ) ? $webAdrEls[1] : ( isset( $webAdrEls[0] ) ? $webAdrEls[0] : "" );
				$_POST[$rowFields[$i]->name."Text"] = isset( $webAdrEls[0] ) ? $webAdrEls[0] : "";
			} else {
				$_POST[$rowFields[$i]->name] = ((get_magic_quotes_gpc()==1) ? addslashes($rowFields[$i]->default) : $rowFields[$i]->default);
			}
			$k=htmlspecialchars($rowFields[$i]->default);
		}
		$_CB_database->setQuery( "SELECT fieldtitle FROM #__comprofiler_field_values"
		. "\n WHERE fieldid = ".(int) $rowFields[$i]->fieldid
		. "\n ORDER BY ordering" );
		$Values = $_CB_database->loadObjectList();
		if(count($Values) > 0) {
			$multi = ($rowFields[$i]->type=='multiselect') ? 'multiple="multiple"' : '';
			$vardisabled = ($rowFields[$i]->readonly > 0) ? ' disabled="disabled"' : '';
			if($rowFields[$i]->type=='radio') {
				$rowFieldValues['lst_'.$rowFields[$i]->name] = moscomprofilerHTML::radioListTable( $Values, $rowFields[$i]->name, 
					'size="1" '.$vardisabled.'mosLabel="'.getLangDefinition($rowFields[$i]->title).'"', 
					'fieldtitle', 'fieldtitle', $k, $rowFields[$i]->cols, $rowFields[$i]->rows, $rowFields[$i]->size, $rowFields[$i]->required);
			} else {
				$ks=explode("|*|",$k);
				$k = array();
				foreach($ks as $kv) {
					$k[]->fieldtitle=$kv;
				}
				if($rowFields[$i]->type=='multicheckbox') {
					$rowFieldValues['lst_'.$rowFields[$i]->name] = moscomprofilerHTML::checkboxListTable( $Values, $rowFields[$i]->name."[]", 
						'size="'.$rowFields[$i]->size.'" '.$multi.$vardisabled.' mosLabel="'.getLangDefinition($rowFields[$i]->title).'"', 
						'fieldtitle', 'fieldtitle', $k, $rowFields[$i]->cols, $rowFields[$i]->rows, $rowFields[$i]->size, $rowFields[$i]->required);
				} else {
					$rowFieldValues['lst_'.$rowFields[$i]->name] = moscomprofilerHTML::selectList( $Values, $rowFields[$i]->name."[]", 
						'class="inputbox" size="'.$rowFields[$i]->size.'" '.$multi.$vardisabled.' mosReq="'.$rowFields[$i]->required.'" mosLabel="'.getLangDefinition($rowFields[$i]->title).'"', 
						'fieldtitle', 'fieldtitle', $k);
				}
			}
		}
	}
	if ($regErrorMSG===null) {
		$regErrorMSG = "";			// So that default values are displayed
		$_POST['firstname'] = "";
		$_POST['middlename'] = "";
		$_POST['lastname'] = "";
		$_POST['name'] = "";
		$_POST['username'] = "";
		$_POST['email'] = "";	
	}

	HTML_comprofiler::registerForm($option, $emailpass, $rowFields, $rowFieldValues,$regErrorMSG);
}

function saveRegistration( $option ) {
	global $_CB_database, $my, $acl, $ueConfig, $mainframe, $_POST;
	global $mosConfig_emailpass, $mosConfig_allowUserRegistration, $_PLUGINS;

	// simple spoof check security
	cbSpoofCheck();
	cbRegAntiSpamCheck();

	if ( ( ( $mosConfig_allowUserRegistration == '0' )
		   && ( ( ! isset($ueConfig['reg_admin_allowcbregistration']) ) || $ueConfig['reg_admin_allowcbregistration'] != '1' ) )
		 || $my->id ) {
		mosNotAuth();
		return;
	}

	$_PLUGINS->loadPluginGroup('user');
	$results = $_PLUGINS->trigger( 'onStartSaveUserRegistration', array() );
	if($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); </script>\n";
		registerForm( $option, $mosConfig_emailpass, $_PLUGINS->getErrorMSG("<br />") );
		return;
	}

	$row = new mosUser( $_CB_database );
	
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".addslashes(unhtmlentities(strip_tags(stripslashes($row->getError()))))."');</script>\n";
		registerForm( $option, $mosConfig_emailpass, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;
	}

	// check if this user already registered with exactly this username and password:
	if ( $row->username && $row->password ) {
		$existingUser = null;
		$query = "SELECT * "
		. "\n FROM #__comprofiler c, #__users u "
		. "\n WHERE u.username = '" . $_CB_database->getEscaped( $row->username ) . "'"
		. "\n AND c.id = u.id"
		;
		$_CB_database->setQuery( $query );
		$existingUser = $_CB_database->loadObjectList();
		if ( is_array( $existingUser ) && ( count( $existingUser ) > 0 ) && cbHashPassword( $row->password, $existingUser[0] ) ) {
			
			$pwd_md5 = $existingUser[0]->password;
			$existingUser[0]->password = $row->password;
			$messagesToUser = activateUser( $existingUser[0], 1, "SameUserRegistrationAgain" );
			$existingUser[0]->password = $pwd_md5;
			echo "\n<div>" . implode( "</div>\n<div>", $messagesToUser ) . "</div>\n";
			return;
		}
	}
	
	if ( in_array( $ueConfig['name_style'], array( 2, 3 ) ) ) {
		$error = null;
		if ( isset( $_POST['firstname'] ) ) {
			$firstname = isset( $_POST['firstname'] )  ? trim( stripslashes( cbGetParam( $_POST, 'firstname' ) ) ) : "";
		} else {
			$error = _UE_YOUR_FNAME . ": " . _UE_REQUIRED_ERROR;
		}
		if ( isset( $_POST['lastname'] ) ) {
			$lastname = isset( $_POST['lastname'] )  ? trim( stripslashes( cbGetParam( $_POST, 'lastname' ) ) ) : "";
		} else {
			$error = _UE_YOUR_LNAME . ": " . _UE_REQUIRED_ERROR;
		}
		if ( $error ) {
			echo "<script type=\"text/javascript\"> alert('".addslashes(unhtmlentities($error))."');</script>\n";
			registerForm( $option, $mosConfig_emailpass,$error );
			return;
		}
	}
	switch ( $ueConfig['name_style'] ) {
		case 2:
			$row->name = $firstname . ' ' . $lastname;
		break;
		case 3:
			$middlename  = isset( $_POST['middlename'] )  ? trim( stripslashes( cbGetParam( $_POST, 'middlename' ) ) ) : "";
			$row->name = $firstname . ' ' . ( $middlename ? ( $middlename . ' ' ) : '' ) . $lastname;
		break;
		default:
		break;
	}
	
	mosMakeHtmlSafe($row);
	$row->id 		= 0;
	$row->gid		= $acl->get_group_id('Registered','ARO');
	$row->usertype	= 'Registered';
	
	$row->username	= trim ( $row->username );
	$row->email		= trim ( $row->email );

	if (!$row->password) {
		$row->password = cbMakeRandomString( 8, true );
		$generatedPassword = true;
	} else {
		$generatedPassword = false;
	}

	$row->registerDate = date("Y-m-d H:i:s");

	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".addslashes(unhtmlentities(strip_tags(stripslashes( $row->getError() ))))."');</script>\n";
		registerForm( $option, $mosConfig_emailpass, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;
	}

	if ($ueConfig['reg_admin_approval']=="0") {
		$approved	= "1";
	} else {
		$approved	= "0";
		$row->block	= '1';
	} 
	if ($ueConfig['reg_confirmation']=="0") {
		$confirmed	= "1";
	} else {
		$confirmed	= "0";
		$row->block = '1';
	} 
	if ( isset( $_POST['acceptedterms'] ) ) {
		$acceptedterms = (int) cbGetParam( $_POST, 'acceptedterms', 0 );
	} else {
		$acceptedterms = null;
	}

	$_CB_database->setQuery( "SELECT f.* FROM #__comprofiler_fields f, #__comprofiler_tabs t"
	. "\n WHERE t.tabid = f.tabid AND f.published=1 AND f.registration=1 AND t.enabled=1"		// AND t.useraccessgroupid = -2
	);
	$rowFields = $_CB_database->loadObjectList();

	$reqErrors = array();

	$notallowed = array("http:", "https:", "mailto:", "//", "[url]", "<a", "</a>", "&#");
	$cbFields  = new cbFields();
	$badHtmlFilter	  = & $cbFields->getInputFilter( array (), array (), 1, 1 );
	$badNonHtmlFilter = & $cbFields->getInputFilter();
	$rowExtras = new moscomprofiler($_CB_database);
	for($i=0, $n=is_array($rowFields) ? count( $rowFields ) : 0; $i < $n; $i++) {
		$field=cbGetEscaped($rowFields[$i]->name);
		$value=null;
		if(isset($_POST[$rowFields[$i]->name])) {
			$value = $_POST[$rowFields[$i]->name];
		}
		$rowExtras->$field = $cbFields->prepareFieldDataSave( $rowFields[$i]->fieldid, $rowFields[$i]->type, $rowFields[$i]->name, $value );
		if ($rowExtras->$field == "" && $rowFields[$i]->required == 1 && !in_array($rowFields[$i]->type, array("delimiter", "hidden"))) {
			$reqErrors[] = getLangDefinition($rowFields[$i]->title) . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
		}
		// some registration anti-spam measures:
		if ( is_array( $value ) && in_array( $rowFields[$i]->type, array('multiselect', 'multicheckbox', 'select', 'delimiter' ) ) ) {
			// values check already done in prepareFieldDataSave()
		} elseif ( is_array( $value ) ) {
			$reqErrors[] = getLangDefinition($rowFields[$i]->title) . " : " . _UE_INPUT_VALUE_NOT_ALLOWED;
		} elseif ( $value !== null ) {
			$value = cbGetUnEscaped( $value );
			switch ( $rowFields[$i]->type ) {
				case "webaddress":
					$value = str_replace( array( 'http://','https://' ), '', $value );
					break;
				case 'emailaddress': 
					$value = str_replace( 'mailto:', '', $value );
					break;		
				default:
					break;
			}
			if ( $rowFields[$i]->type == "editorta") {
				$filteredValue = $cbFields->clean( $badHtmlFilter, $value );
			} else {
				$filteredValue = $cbFields->clean( $badNonHtmlFilter, str_replace( $notallowed, "", $value ) );
			}
			if ( $value !== $filteredValue ) {
				$reqErrors[] = getLangDefinition($rowFields[$i]->title) . " : " . _UE_INPUT_VALUE_NOT_ALLOWED;
			}
		}
	}
	
	$rowExtras->id				= null;
	$rowExtras->user_id			= null;
	$rowExtras->firstname		= trim( stripslashes( cbGetParam( $_POST, 'firstname', '' ) ) );
	$rowExtras->middlename		= trim( stripslashes( cbGetParam( $_POST, 'middlename', '' ) ) );
	$rowExtras->lastname		= trim( stripslashes( cbGetParam( $_POST, 'lastname', '' ) ) );
	$rowExtras->acceptedterms	= $acceptedterms;
	$rowExtras->approved		= $approved;
	$rowExtras->confirmed		= $confirmed;
	$rowExtras->registeripaddr	= cbGetIPlist();

	// some more registration anti-spam measures:
	$testfields = array( '_REGISTER_UNAME' => $row->username,
						 '_REGISTER_EMAIL' => $row->email,
						 '_UE_YOUR_NAME'   => $row->name, 
						 '_UE_YOUR_FNAME'  => $rowExtras->firstname,
						 '_UE_YOUR_MNAME'  => $rowExtras->middlename,
						 '_UE_YOUR_LNAME'  => $rowExtras->lastname );
	foreach ( $testfields as $k => $v ) {
		$filteredValue = $cbFields->clean( $badNonHtmlFilter, str_replace( $notallowed, "", $v ) );
		if ( $filteredValue != $v ) {
			$reqErrors[] = getLangDefinition($k) . " : " . _UE_INPUT_VALUE_NOT_ALLOWED;			
		}
	}

	switch( $ueConfig['name_style'] ) {
		case 2:
		case 3:
			if ($rowExtras->firstname == "") {
				$reqErrors[] = _UE_YOUR_FNAME . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
			}
			if ($rowExtras->lastname == "") {
				$reqErrors[] = _UE_YOUR_LNAME . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
			}
		break;
		default:
		break;
	}
	if (strlen($row->username) < 3) {
		$reqErrors[] = sprintf( unHtmlspecialchars(_VALID_AZ09), unHtmlspecialchars(_PROMPT_UNAME), 2 );
	}
	if ($mosConfig_emailpass != "1") {
		if ($generatedPassword || strlen($row->password) < 6) {
			$reqErrors[] = sprintf( unHtmlspecialchars(_VALID_AZ09), unHtmlspecialchars(_REGISTER_PASS), 6 );
		} elseif (isset($_POST["verifyPass"]) && ($_POST["verifyPass"] != $_POST["password"])) {
			$reqErrors[] = unHtmlspecialchars(_REGWARN_VPASS2);
		}
	}
	if($ueConfig['reg_enable_toc']) {
		if ($rowExtras->acceptedterms == "") {
			$reqErrors[] = _UE_TOC_REQUIRED;
		}
	}
	if (count($reqErrors) > 0) {
		echo "<script type=\"text/javascript\">alert('" . addslashes( unHtmlspecialchars( implode('\n',$reqErrors) ) ) ."'); </script>\n";
		registerForm( $option, $mosConfig_emailpass,implode("<br />",$reqErrors)."<br />" );
		return;
	}

	$_PLUGINS->loadPluginGroup('user');
	$_PLUGINS->trigger( 'onBeforeUserRegistration', array(&$row,&$rowExtras));
	if($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes( $_PLUGINS->getErrorMSG())."'); </script>\n";
		registerForm( $option, $mosConfig_emailpass,$_PLUGINS->getErrorMSG("<br />") );
		return;
	}
	$approved	= $rowExtras->approved;		// in case changed by onBeforeUserRegistration trigger
	$confirmed	= $rowExtras->confirmed;

	$pwd			=	$row->password;
	$row->password	=	cbHashPassword( $row->password );

	if (!$row->store()) {		// first store to get new user id if id is not set (needed for saveRegistrationPluginTabs)
		echo "<script type=\"text/javascript\"> alert('store:".addslashes(unhtmlentities($row->getError()))."'); </script>\n";
		registerForm( $option, $mosConfig_emailpass, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;
	}

	if ( $row->id == 0 ) {
		$_CB_database->setQuery("SELECT id FROM #__users WHERE username = '". cbGetParam( $_POST, 'username', '' ) . "'");
		$uid = $_CB_database->loadResult();
		$row->id=$uid;		// this is only for mambo 4.5.0 backwards compatibility. 4.5.2.3 $row->store() updates id on insert
	}	
	$rowExtras->id = $row->id;
	$rowExtras->user_id = $row->id;
	
	$row->password = $pwd;
	
	if ( $confirmed == '0' ) {
		$randomHash		= md5( cbMakeRandomString() );
		$scrambleSeed	= (int) hexdec(substr( md5 ( $mainframe->getCfg( 'secret' ) . $mainframe->getCfg( 'db' ) ), 0, 7));
		$scrambledId	= $scrambleSeed ^ ( (int) $row->id );
		$rowExtras->cbactivation = "reg" . $randomHash . sprintf( "%08x", $scrambledId );
	}

	$userComplete =& moscomprofiler::dbObjectsMerge($row, $rowExtras);
	$tabs = new cbTabs( 0, 1);
	$results_save_tabs = $tabs->saveRegistrationPluginTabs($userComplete, $_POST);
	$pwd			=	$row->password;
	$row->password	=	cbHashPassword( $row->password );

	if (!$row->store()) {
		echo "<script type=\"text/javascript\"> alert('".addslashes(unhtmlentities($row->getError()))."'); </script>\n";
		registerForm( $option, $mosConfig_emailpass, stripslashes( $row->getError() ) );		// there is an addslashes in joomla 1.0.12
		return;
	}

	if(!$_CB_database->insertObject( '#__comprofiler', $rowExtras)) {
		// added this help error message at 1.0.2, since this is the place where rows using new columns registeripaddr and cbactivation are inserted first:
		echo "comprofiler store error (did you apply all database changes ? try reapplying all SQL queries described in experts upgrade instructions in README.txt):<br />"
		. $_CB_database->stderr(true) . "\n";
		exit();
	}

	$row->password = $pwd;
	$results_after = $_PLUGINS->trigger( 'onAfterUserRegistration', array($row, $rowExtras, true));

	$query = "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id =" . (int) $row->id;
	$_CB_database->setQuery($query);
	$user = $_CB_database->loadObjectList();
	
	$pwd_md5 = $user[0]->password;
	$user[0]->password = $pwd;
	$messagesToUser = activateUser( $user[0], 1, "UserRegistration" );
	$user[0]->password = $pwd_md5;

	foreach ($results_save_tabs as $res) {
		if ($res) {
			$messagesToUser[] = $res;
		}
	}

	$_PLUGINS->trigger( 'onAfterUserRegistrationMailsSent', array($row, $rowExtras, &$messagesToUser, $ueConfig['reg_confirmation'], $ueConfig['reg_admin_approval'], true));

	foreach ($results_after as $res) {
		if ($res) {
			echo "\n<div>" . $res . "</div>\n";
		}
	}

	if($_PLUGINS->is_errors()) {
		echo $_PLUGINS->getErrorMSG();
		return;
	}

	echo "\n<div>" . implode( "</div>\n<div>", $messagesToUser ) . "</div>\n";
}

/**
 * Checks the availability of a username for registration and echoes a text containing the result of username search.
 *
 * @param string $username
 */
function checkUsernameAvailability( $username ) {
	global $_CB_database, $ueConfig;

	if ( ( ! isset( $ueConfig['reg_username_checker'] ) ) || ( ! $ueConfig['reg_username_checker'] ) ) {
		echo _UE_NOT_AUTHORIZED;
		exit();
	}
	// simple spoof check security
	cbSpoofCheck();
	cbRegAntiSpamCheck();
	
	$usernameISO =	utf8ToISO( $username );			// ajax sends in utf8, we need to convert back to the site's encoding.

	if ( $_CB_database->isDbCollationCaseInsensitive() ) {
		$query	=	"SELECT COUNT(*) AS result FROM #__users WHERE username = '" . $_CB_database->getEscaped( ( trim( $usernameISO ) ) ) . "'";
	} else {
		$query	=	"SELECT COUNT(*) AS result FROM #__users WHERE LOWER(username) = '" . $_CB_database->getEscaped( ( strtolower( trim( $usernameISO ) ) ) ) . "'";
	}
	$_CB_database->setQuery($query);
	$dataObj	=	null;
	if ( $_CB_database->loadObject( $dataObj ) ) {
		if ( $dataObj->result ) {
			// funily, the output needs to be UTF8 again:
			echo '<span style="color:red;">' . sprintf( _UE_USERNAME_ALREADY_EXISTS, htmlspecialchars( $username ) ) . "</span>";
		} else {
			echo '<span style="color:green;">' . sprintf( _UE_USERNAME_DOESNT_EXISTS, htmlspecialchars( $username ) ) . "</span>";
		}
	} else {
		echo '<span style="color:red;">Search error!' . "</span>";
	}
}


function login( $username=null, $passwd2=null ) {
    global $acl, $_CB_database, $_COOKIE, $_GET, $_POST, $mainframe, $ueConfig, $_PLUGINS;

	// simple spoof check security (login module does it only with Joomla functions, no cb.class inclusion)
	if ( is_callable("josSpoofCheck")) {
		josSpoofCheck(1);
	}

	$messagesToUser		=	array();
    $resultError		=	null;

    // $usercookie = cbGetParam( $_COOKIE, 'usercookie', '' );
    // $sessioncookie = cbGetParam( $_COOKIE, 'sessioncookie', '' );
    if ( !$username || !$passwd2 ) {
		$username	= trim( cbGetParam( $_POST, 'username', '' ) );
		$passwd2	= trim( cbGetParam( $_POST, 'passwd', '' ) );
    }
	$return		= trim( cbGetParam( $_POST, 'return', null ) );
	$message	= trim( cbGetParam( $_POST, 'message', 0 ) );
	//print "message:".$message;
    // $remember = trim( cbGetParam( $_POST, 'remember', '' ) );
	// $lang = trim( cbGetParam( $_POST, 'lang', '' ) );

	if ( !$username || !$passwd2 ) {
		$resultError = _LOGIN_INCOMPLETE;
	} else {
		$_PLUGINS->loadPluginGroup('user');
		$_PLUGINS->trigger( 'onBeforeLogin', array( &$username, &$passwd2 ) );
		
		$alertmessages	= array();
		$showSysMessage = true;
		$stopLogin		= false;
		$returnURL		= null;
		
		if($_PLUGINS->is_errors()) {
			$resultError = $_PLUGINS->getErrorMSG();
		} else {
			$_CB_database->setQuery( "SELECT * "
			. "\n FROM #__users u, "
			. "\n #__comprofiler ue "
			. "\n WHERE u.username='".$username."' AND u.id = ue.id"
			);
			$row = null;
			if ( $_CB_database->loadObject( $row ) && cbHashPassword( $passwd2, $row ) ) {
				$pluginResults = $_PLUGINS->trigger( 'onDuringLogin', array( &$row, 1, &$return ) );
				if ( is_array( $pluginResults ) && count( $pluginResults ) ) {
					foreach ( $pluginResults as $res ) {
						if ( is_array( $res ) ) {
							if ( isset( $res['messagesToUser'] ) ) {
								$messagesToUser[]	= $res['messagesToUser'];
							}
							if ( isset( $res['alertMessage'] ) ) {
								$alertmessages[]	= $res['alertMessage'];
							}
							if ( isset( $res['showSysMessage'] ) ) {
								$showSysMessage		= $showSysMessage && $res['showSysMessage'];
							}
							if ( isset( $res['stopLogin'] ) ) {
								$stopLogin			= $stopLogin || $res['stopLogin'];
							}
						}
					}
				}
				if($_PLUGINS->is_errors()) {
					$resultError = $_PLUGINS->getErrorMSG();
				}
				elseif ( $stopLogin ) {
					// login stopped: don't even check for errors...
				}
				elseif ($row->approved == 2){
					$resultError = _LOGIN_REJECTED;
				}
				elseif ($row->confirmed != 1){
					$cbNotification = new cbNotification();
					$cbNotification->sendFromSystem($row->id,getLangDefinition(stripslashes($ueConfig['reg_pend_appr_sub'])),getLangDefinition(stripslashes($ueConfig['reg_pend_appr_msg'])));
					$resultError = _LOGIN_NOT_CONFIRMED;
				}
				elseif ($row->approved == 0){
					$resultError = _LOGIN_NOT_APPROVED;
				}
				elseif ($row->block == 1) {
					$resultError = _LOGIN_BLOCKED;
				}
				elseif ($row->lastvisitDate == '0000-00-00 00:00:00') {
					if (isset($ueConfig['reg_first_visit_url']) and ($ueConfig['reg_first_visit_url'] != "")) {
						$return = sefRelToAbs($ueConfig['reg_first_visit_url']);
					}
					$_PLUGINS->trigger( 'onBeforeFirstLogin', array( &$row, $username, $passwd2, &$return ));
					if ($_PLUGINS->is_errors()) {
						$resultError = $_PLUGINS->getErrorMSG( "<br />" );
					}					
				}
			} else {
				$resultError = _LOGIN_INCORRECT;
			}
		}

		if ( $resultError ) {
			if ( $showSysMessage ) {
				$alertmessages[] = $resultError;
			}
		} elseif ( ! $stopLogin ) {
			$hashedPwdLogin	=	false;
			if ( checkJversion() == 0 ) {
				global $_VERSION;
				if ($_VERSION->PRODUCT == "Joomla!" || $_VERSION->PRODUCT == "Accessible Joomla!") {
					// $build_arr	=	array();
					// if ( preg_match( '/[0-9]+/', $_VERSION->BUILD, $build_arr ) ) {
					//	if ( $build_arr[0] < 7813 ) {			// 1.0.13 RC3
					if ( ( $_VERSION->RELEASE == '1.0' ) && ( $_VERSION->DEV_LEVEL < 13 ) ) {
							$hashedPwdLogin		=	true;
						}
				//	}
				} else {
					$hashedPwdLogin		=	true;
				}
			}
			if ( $hashedPwdLogin ) {				// Joomla 1.0.12 and below:
				$mainframe->login( $username, cbHashPassword( $passwd2 ) );
			} elseif ( checkJversion() == 1 ) {		// Joomla 1.5 RC and above:
				$mainframe->login( array( 'username' => $username, 'password' => $passwd2 ), array() );
			} else {
				$mainframe->login( $username, $passwd2 );
			}
			$_PLUGINS->trigger( 'onAfterLogin', array($row, true));
			if ( $message && $showSysMessage ) {
				$alertmessages[] = _LOGIN_SUCCESS;
			}			
			if ( $return && !( strpos( $return, 'com_comprofiler') && ( strpos( $return, 'login') || strpos( $return, 'registers' ) ) ) ) {
			// checks for the presence of a return url
			// and ensures that this url is not the registration or login pages
				$returnURL = (strncasecmp($return, "http:", 5)||strncasecmp($return, "https:", 6)) ? $return : sefRelToAbs($return);
			} elseif ( ! $returnURL ) {
				$returnURL = sefRelToAbs('index.php');
			}
		}
		// JS Popup message
		if ( count( $alertmessages ) > 0 ) {
			echo '<script type="text/javascript"><!--//'."\n";
			echo 'alert( "' . str_replace( '<br />', '\n', implode( '\n', $alertmessages ) ) . '" );';
			if ( $returnURL ) {
				echo "window.location = '" . $returnURL . "';";
			}
			echo "\n//-->\n</script>\n";
			/*
			**not sure if this is the best case but the 
			**reason why we weren't seeing the login message was
			**because we are immediately redirecting to another page
			**so if we flush out the contents to the browser then we get the alert.
			*/
			if (!$resultError && ( ! ( count( $messagesToUser ) > 0 ) ) && function_exists("ob_flush")) {
				ob_flush();			// warning: this makes cbRedirect fail in IE6, as headers are already sent...JS redirect will work.
			}
		}
	}
	if ( count( $messagesToUser ) > 0 ) {
		if ( $resultError ) {
			echo "<div class=\"message\">".$resultError."</div>";
		}
		echo "\n<div>" . implode( "</div>\n<div>", $messagesToUser ) . "</div>\n";
	} elseif ($resultError) {
		echo "<div class=\"message\">".$resultError."</div>";
	} else {
		cbRedirect( $returnURL );
	}
}

function logout() {
	global $_POST, $mainframe, $my, $_CB_database, $_PLUGINS;
	
	$return = trim( cbGetParam( $_POST, 'return', null ) );
	$message = trim( cbGetParam( $_POST, 'message', 0 ) );
	
	if ($return || $message) {
		// simple spoof check security (login module does it only with Joomla functions, no cb.class inclusion)
		if ( is_callable("josSpoofCheck")) {
			josSpoofCheck(1);
		}
	}
	
	$_CB_database->setQuery( "SELECT * "
	. "\nFROM #__users u, "
	. "\n#__comprofiler ue"
	. "\nWHERE u.id=".$my->id." AND u.id = ue.id"
	);
	$row = null;
	$_CB_database->loadObject( $row );
	$_PLUGINS->loadPluginGroup('user');
	$_PLUGINS->trigger( 'onBeforeLogout', array($row));
	if($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."');</script>\n";
		echo "<div class=\"message\">".$_PLUGINS->getErrorMSG()."</div>";;
		return;
	}
	$mainframe->logout();
	$_PLUGINS->trigger( 'onAfterLogout', array($row, true));

	// JS Popup message
	if ( $message ) {
		?>
		<script type="text/javascript"> 
		<!--//
		alert( "<?php echo _LOGOUT_SUCCESS; ?>" ); 
		//-->
		</script>
		<?php
		/*
		**not sure if this is the best case but the 
		**reason why we weren't seeing the logout message was
		**because we are immediately redirecting to another page
		**so if we flush out the contents to the browser then we get the alert.
		*/
		if (function_exists("ob_flush")) {
			ob_flush();
		}
	}

	if ($return) {
		cbRedirect( (strncasecmp($return, "http:", 5)||strncasecmp($return, "https:", 6)) ? $return : sefRelToAbs($return));
	} else {
		cbRedirect(sefRelToAbs('index.php'));
	}
}
function confirm($confirmcode){
	global $_CB_database, $mainframe, $my, $ueConfig, $_PLUGINS;
	
	if($my->id < 1) {
		$lengthConfirmcode = strlen($confirmcode);
		if ($lengthConfirmcode == ( 3+32+8 ) ) {
			$scrambleSeed	= (int) hexdec(substr( md5 ( $mainframe->getCfg( 'secret' ) . $mainframe->getCfg( 'db' ) ), 0, 7));
			$unscrambledId	= $scrambleSeed ^ ( (int) hexdec(substr( $confirmcode, 3+32 ) ) );
			$query = "SELECT * FROM #__comprofiler c, #__users u "
					. " WHERE c.id = " . (int) $unscrambledId . " AND c.cbactivation = '" . cbGetEscaped($confirmcode) . "' AND c.id=u.id";
	//	} elseif ($lengthConfirmcode == 32) {	//BBTODO: this is for confirmation links previous to CB 1.0.2: remove after CB 1.0.2:
	//		$query = "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND md5(c.id) = '" . cbGetEscaped($confirmcode) . "'";
		} else {
			mosNotAuth();
			return;			
		}
		$_CB_database->setQuery($query);
		$user = $_CB_database->loadObjectList();	

		if ( ( $user === null ) || ( count( $user ) == 0 ) /* || ( ($lengthConfirmcode == 32) && isset($user[0]->cbactivation ) && $user[0]->cbactivation ) */ ) {
			$query = "SELECT * FROM #__comprofiler c, #__users u "
					. " WHERE c.id = " . (int) $unscrambledId . " AND c.id=u.id";
			$_CB_database->setQuery($query);
			$user = $_CB_database->loadObjectList();
			if ( ( $user === null ) || ( count( $user ) == 0 ) || ($user[0]->confirmed == 0) ) {
				mosNotAuth();
			} else {
				$messagesToUser = getActivationMessage($user[0], "UserConfirmation");
				echo "\n<div>" . implode( "</div>\n<div>", $messagesToUser ) . "</div>\n";
			}
			return;
		}

		$_PLUGINS->loadPluginGroup('user');		
		$_PLUGINS->trigger( 'onBeforeUserConfirm', array($user[0]));
		if($_PLUGINS->is_errors()) {
				echo $_PLUGINS->getErrorMSG("<br />");
				exit();
		}

		$query = "UPDATE #__comprofiler SET confirmed = 1 WHERE id=" . (int) $user[0]->id;
		$_CB_database->setQuery($query);
		$_CB_database->query();
		
		if ( $user[0]->confirmed == 1 ) {
			$messagesToUser = getActivationMessage($user[0], "UserConfirmation");
		} else {
			$user[0]->confirmed = 1;
			$messagesToUser = activateUser($user[0], 1, "UserConfirmation");
		}
		$_PLUGINS->trigger( 'onAfterUserConfirm', array($user[0],true));
		
		echo "\n<div>" . implode( "</div>\n<div>", $messagesToUser ) . "</div>\n";

	} else {
//		cbRedirect(sefRelToAbs('index.php?option=com_comprofiler'.getCBprofileItemid()));
//		mosNotAuth(); :
		echo _UE_NOT_AUTHORIZED." :<br /><br />"._UE_DO_LOGOUT." !<br />";
		return;
	}

}


function approveImage() {
	global $_CB_database, $_POST, $_REQUEST, $_SERVER, $mainframe, $my, $ueConfig;

	$andItemid = getCBprofileItemid();

	// simple spoof check security for posts (menus do gets):
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		cbSpoofCheck();
	}
	$isModerator=isModerator($my->id);
	if (!$isModerator) {
		mosNotAuth();
		return;
	}
	$avatars=array();
	if(isset($_POST['avatar'])) $avatars=$_POST['avatar'];
	else $avatars[] = $_REQUEST['avatars'];
	if(isset($_POST['act'])) $act=$_POST['act'];
	else $act = $_REQUEST['flag'];
	$cbNotification = new cbNotification();
	if($act=='1') {
		foreach ($avatars AS $avatar) {
			$query = "UPDATE #__comprofiler SET avatarapproved = 1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id = " . (int) $avatar;
			$_CB_database->setQuery($query);
			$_CB_database->query();
			$cbNotification->sendFromSystem( (int) $avatar, _UE_IMAGEAPPROVED_SUB, _UE_IMAGEAPPROVED_MSG );
		}
	} else {
		foreach ($avatars AS $avatar) {
			$query = "SELECT avatar FROM #__comprofiler WHERE id = " . (int) $avatar;
			$_CB_database->setQuery($query);
			$file = $_CB_database->loadResult();
		   	if(eregi("gallery/",$file)==false && is_file($mainframe->getCfg('absolute_path')."/images/comprofiler/".$file)) {
				unlink($mainframe->getCfg('absolute_path')."/images/comprofiler/".$file);
				if(is_file($mainframe->getCfg('absolute_path')."/images/comprofiler/tn".$file)) unlink($mainframe->getCfg('absolute_path')."/images/comprofiler/tn".$file);
			}
			$query = "UPDATE #__comprofiler SET avatarapproved = 1, avatar=null WHERE id = " . (int) $avatar;
			$_CB_database->setQuery($query);
			$_CB_database->query();
			$cbNotification->sendFromSystem( (int) $avatar, _UE_IMAGEREJECTED_SUB, _UE_IMAGEREJECTED_MSG );
		}

	}
	cbRedirect(sefRelToAbs( 'index.php?option=com_comprofiler&task=moderateImages' . $andItemid ), _UE_USERIMAGEMODERATED_SUCCESSFUL);
}

function reportUser($option,$form=1,$uid=0) {
	global $_CB_database,$ueConfig,$_POST,$my;
	
	if($ueConfig['allowUserReports']==0) {
			echo _UE_FUNCTIONALITY_DISABLED;
			exit();
	}
	if (!allowAccess( $ueConfig['allow_profileviewbyGID'],'RECURSE', userGID($my->id))) {
		echo _UE_NOT_AUTHORIZED;
		return;
	}
	if($form==1) {
		HTML_comprofiler::reportUserForm($option,$uid);
	} else {
		// simple spoof check security
		cbSpoofCheck();
		
		$row = new moscomprofilerUserReport( $_CB_database );
		
		if (!$row->bind( $_POST )) {
			echo "<script type=\"text/javascript\"> alert('".addslashes($row->getError())."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		mosMakeHtmlSafe($row);
	
		$row->reportedondate = date("Y-m-d\TH:i:s");
	
		if (!$row->check()) {
			echo "<script type=\"text/javascript\"> alert('".addslashes($row->getError())."'); window.history.go(-1); </script>\n";
			exit();
		}
	
		if (!$row->store()) {
			echo "<script type=\"text/javascript\"> alert('".addslashes($row->getError())."'); window.history.go(-1); </script>\n";
			exit();
		}
		if($ueConfig['moderatorEmail']==1) {
			$cbNotification = new cbNotification();
			$cbNotification->sendToModerators(_UE_USERREPORT_SUB,_UE_USERREPORT_MSG);
		}
		echo _UE_USERREPORT_SUCCESSFUL;
	}
}

function banUser( $option, $uid, $form=1, $act=1 ) {
	global $_CB_database, $ueConfig, $_POST, $my;
	
	$isModerator=isModerator($my->id);
	if ( ( $my->id < 1 ) || ( $uid < 1 ) )  {
			mosNotAuth();
			exit();
	}
	if ( $ueConfig['allowUserBanning'] == 0 ) {
			echo _UE_FUNCTIONALITY_DISABLED;
			exit();
	}

	if ( $form == 1 ) {
		$_CB_database->setQuery( "SELECT bannedreason FROM #__comprofiler WHERE id = " . (int) $uid );
		$orgbannedreason	=	$_CB_database->loadresult();

		HTML_comprofiler::banUserForm( $option, $uid, $act, $orgbannedreason);
	} else {

		$now				=	time();
		$dateStr			=	cbFormatDate( $now );

		$cbNotification		=	new cbNotification();
		if ( $act == 1 ) {
			// Ban by moderator:
			if ( ( ! $isModerator ) || ( $my->id != cbGetParam( $_POST, 'bannedby', 0 ) ) ) {
				mosNotAuth();
				return;
			}
			// simple spoof check security
			cbSpoofCheck();

			$bannedreason	=	'<b>' . htmlspecialchars("["._UE_MODERATORBANRESPONSE.", " . $dateStr . "]") . "</b>\n" . htmlspecialchars( stripslashes( cbGetParam( $_POST, 'bannedreason') ) ) ."\n";
			$sql="UPDATE #__comprofiler SET banned=1, bannedby=" . (int) $my->id . ", banneddate='".date('Y-m-d\TH:i:s')."', bannedreason = CONCAT_WS('','" . $_CB_database->getEscaped( $bannedreason ) . "', bannedreason) WHERE id=". (int) $uid;
			$_CB_database->SetQuery($sql);
			$_CB_database->query();

			$cbNotification->sendFromSystem($uid,_UE_BANUSER_SUB,_UE_BANUSER_MSG);
			echo _UE_USERBAN_SUCCESSFUL;
		} elseif ( $act == 0 ) {
			// Unban by moderator:
			if (!$isModerator){
				mosNotAuth();
				return;
			}
			$myName		=	getNameFormat($my->name,$my->username,$ueConfig['name_format']);
			// DEFINE('_UE_UNBANUSER_BY_ON','User profile unbanned by %s on %s');
			// $unbannedBy	=	"<b>" . addslashes( htmlspecialchars("[".sprintf( _UE_UNBANUSER_BY_ON, $myName, $dateStr ) ) ) . "]</b>\n";
			$unbannedBy	=	"<b>" . htmlspecialchars("[". _UE_UNBANUSER . ", " . $dateStr ) . "]</b>\n";
			$sql="UPDATE #__comprofiler SET banned=0, unbannedby=" . (int) $my->id . ", bannedreason = CONCAT_WS('','" . $_CB_database->getEscaped( $unbannedBy ) . "', bannedreason), unbanneddate='".date('Y-m-d\TH:i:s')."'  WHERE id=".(int) $uid;				// , bannedreason=null, bannedby=null, banneddate=null
			$_CB_database->SetQuery($sql);
			$_CB_database->query();
			$cbNotification->sendFromSystem($uid,_UE_UNBANUSER_SUB,_UE_UNBANUSER_MSG);

			echo _UE_USERUNBAN_SUCCESSFUL;
		} elseif ( $act == 2 ) {
			// Unban request from user:
			if ($my->id!=$uid){
				mosNotAuth();
				return;
			}
			$bannedreason = "<b>".htmlspecialchars("["._UE_USERBANRESPONSE.", " . $dateStr . "]")."</b>\n" . htmlspecialchars( stripslashes( cbGetParam( $_POST, 'bannedreason' ) ) ) ."\n";
			$sql="UPDATE #__comprofiler SET banned=2, bannedreason = CONCAT_WS('','" . $_CB_database->getEscaped( $bannedreason) . "', bannedreason) WHERE id=" . (int) $uid;
			$_CB_database->SetQuery($sql);
			$_CB_database->query();
			if($ueConfig['moderatorEmail']==1) {
				$cbNotification->sendToModerators(_UE_UNBANUSERREQUEST_SUB,_UE_UNBANUSERREQUEST_MSG);
			}
			echo _UE_USERUNBANREQUEST_SUCCESSFUL;

		}
	}
}

function processReports(){
	global $_CB_database, $_POST, $my;

	// simple spoof check security
	cbSpoofCheck();

	$isModerator=isModerator($my->id);
	if (!$isModerator) {
		mosNotAuth();
		return;
	}
	$reports	=	cbGetParam( $_POST, 'reports', array() );
	foreach ($reports AS $report) {
		$query = "UPDATE #__comprofiler_userreports SET reportedstatus = 1 WHERE reportid = " . (int) $report;
		$_CB_database->setQuery($query);
		$_CB_database->query();
	}
	cbRedirect(sefRelToAbs( 'index.php?option=com_comprofiler&task=moderateReports' . getCBprofileItemid() ), _UE_USERREPORTMODERATED_SUCCESSFUL);
}

function moderator(){
  global $_CB_database, $my;
	$isModerator=isModerator($my->id);
	if (!$isModerator) {
		mosNotAuth();
		return;
	}
	$query = "SELECT count(*) FROM #__comprofiler  WHERE avatarapproved=0 AND approved=1 AND confirmed=1 AND banned=0";
	if(!$_CB_database->setQuery($query)) print $_CB_database->getErrorMsg();
	$totalimages = $_CB_database->loadResult();

	$query = "SELECT count(*) FROM #__comprofiler_userreports  WHERE reportedstatus=0 ";
	if(!$_CB_database->setQuery($query)) print $_CB_database->getErrorMsg();
	$totaluserreports = $_CB_database->loadResult();

	$query = "SELECT count(*) FROM #__comprofiler WHERE banned=2 AND approved=1 AND confirmed=1";
	if(!$_CB_database->setQuery($query)) print $_CB_database->getErrorMsg();
	$totalunban = $_CB_database->loadResult();

	if($totalunban > 0 || $totaluserreports > 0 || $totalimages > 0) {
		if($totalunban > 0) echo "<div>".$totalunban._UE_UNBANREQUIREACTION."</div>";
		if($totaluserreports > 0) echo "<div>".$totaluserreports._UE_USERREPORTSREQUIREACTION."</div>";
		if($totalimages > 0) echo "<div>".$totalimages._UE_IMAGESREQUIREACTION."</div>";


	} else {
		echo _UE_NOACTIONREQUIRED;

	}

}


function approveUser($uids) {
	global $_CB_database, $ueConfig, $my, $mosConfig_emailpass, $_PLUGINS;

	$andItemid = getCBprofileItemid();

	// simple spoof check security
	cbSpoofCheck();

	if($ueConfig['allowModUserApproval']==0) {
			echo _UE_FUNCTIONALITY_DISABLED;
			exit();
	}

	$isModerator=isModerator($my->id);
	if (!$isModerator){
		mosNotAuth();
		return;
	}

	//$tabs = new cbTabs( 0, 1);
	
	$_PLUGINS->loadPluginGroup('user');

	foreach($uids AS $uid) {
		$query = "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id = " . (int) $uid;
		$_CB_database->setQuery($query);
		$user = $_CB_database->loadObjectList();
		$row = $user[0];
		if ( $mosConfig_emailpass == "1" ) {
			$pwd = cbMakeRandomString( 8, true );
			$row->password = $pwd;
			$pwd = ", password='" . cbHashPassword( $pwd ) . "' ";
		} else {
			$pwd = "";
		}
		$_PLUGINS->trigger( 'onBeforeUserApproval', array($row,true));
		if($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); window.history.go(-1); </script>\n";
			exit();
		}
		$sql = "UPDATE #__comprofiler SET approved= 1 " . $pwd . " WHERE id=" . (int) $uid;
		$_CB_database->SetQuery( $sql );
		$_CB_database->query();
		$row->approved = 1;
		$_PLUGINS->trigger( 'onAfterUserApproval', array($row,true,true));
		$messagesToUser = activateUser($row, 1, "UserApproval", false);
	}
	cbRedirect(sefRelToAbs( 'index.php?option=com_comprofiler&task=pendingApprovalUser' . $andItemid ),(count($uids))?count($uids)." "._UE_USERAPPROVAL_SUCCESSFUL:"");

}

function rejectUser($uids) {
	global $_CB_database, $ueConfig, $_POST, $my, $mosConfig_emailpass, $_PLUGINS, $mosConfig_sitename;

	$andItemid = getCBprofileItemid();

	// simple spoof check security
	cbSpoofCheck();

	if($ueConfig['allowModUserApproval']==0) {
			echo _UE_FUNCTIONALITY_DISABLED;
			exit();
	}
	
	$isModerator=isModerator($my->id);
	if (!$isModerator){
		mosNotAuth();
		return;
	}
	
	$cbNotification= new cbNotification();
	foreach($uids AS $uid) {
		$query = "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id = " . (int) $uid;
		$_CB_database->setQuery($query);
		$user = $_CB_database->loadObjectList();
		$row = $user[0];
		$_PLUGINS->loadPluginGroup('user');
		$_PLUGINS->trigger( 'onBeforeUserApproval', array($row,false));
		if($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert('".addslashes($_PLUGINS->getErrorMSG())."'); window.history.go(-1); </script>\n";
			exit();
		}
		$sql="UPDATE #__comprofiler SET approved=2 WHERE id=" . (int) $uid;
		$_CB_database->SetQuery($sql);
		$_CB_database->query();
		$_PLUGINS->trigger( 'onAfterUserApproval', array($row,false,true));
		$cbNotification->sendFromSystem(cbGetEscaped($uid),_UE_REG_REJECT_SUB,sprintf(_UE_USERREJECT_MSG,$mosConfig_sitename, stripslashes( cbGetParam( $_POST, 'comment' . $uid, '' ) ) ) );
	}
	cbRedirect(sefRelToAbs( 'index.php?option=com_comprofiler&task=pendingApprovalUser' . $andItemid ),(count($uids))?count($uids)." "._UE_USERREJECT_SUCCESSFUL:"");

}

function pendingApprovalUsers($option) {
	global $_CB_database,$ueConfig,$my,$mosConfig_emailpass;
	$isModerator=isModerator($my->id);
	if($ueConfig['allowModUserApproval']==0) {
			echo _UE_FUNCTIONALITY_DISABLED;
			exit();
	}
	if (!$isModerator){
		mosNotAuth();
		return;
	}

	$_CB_database->setQuery( "SELECT u.id, u.name, u.username, u.email, u.registerDate "
	."\n FROM #__users u, #__comprofiler c "
	."\n WHERE u.id=c.id AND c.approved=0 AND c.confirmed=1" );
	$rows = $_CB_database->loadObjectList();
	
	HTML_comprofiler::pendingApprovalUsers($option, $rows);	
}

//Connections

function addConnection($userid,$connectionid,$umsg=null) {
	global $_CB_database, $ueConfig, $my;

	$andItemid = getCBprofileItemid(true);
		
	if(!$ueConfig['allowConnections']) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if (!$my->id > 0) {
		mosNotAuth();
		return;
	}
	$cbCon=new cbConnection($userid);
	$cbCon->addConnection($connectionid,stripcslashes($umsg));
	$url=sefRelToAbs( "index.php?option=com_comprofiler&amp;task=userProfile&amp;user=" . $connectionid . $andItemid );
	echo "<script type=\"text/javascript\"> alert('".addslashes(htmlspecialchars($cbCon->getUserMSG()))."'); document.location.href='".unHtmlspecialchars($url)."'; </script>\n";
}

function removeConnection($userid,$connectionid) {
	global $_CB_database, $ueConfig, $my;

	$andItemid = getCBprofileItemid(true);

	if(!$ueConfig['allowConnections']) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if (!$my->id > 0) {
		mosNotAuth();
		return;
	}
	$cbCon=new cbConnection($userid);
	if(!$cbCon->removeConnection($userid,$connectionid)) $msg=$cbCon->getErrorMSG(); 
	else $msg = $cbCon->getUserMSG();

	// $url=sefRelToAbs("index.php?option=com_comprofiler&task=manageConnections");
	$url=sefRelToAbs( "index.php?option=com_comprofiler&amp;tab=getConnectionTab" . $andItemid );
	echo "<script type=\"text/javascript\"> alert('".addslashes($msg)."'); document.location.href='".unHtmlspecialchars($url)."'; </script>\n";

}

function denyConnection($userid,$connectionid) {
	global $_CB_database,$ueConfig,$my;

	if(!$ueConfig['allowConnections']) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if (!$my->id > 0) {
		mosNotAuth();
		return;
	}

	$cbCon=new cbConnection($userid);
	$cbCon->denyConnection($userid,$connectionid);

	echo "<script type=\"text/javascript\"> alert('".addslashes($cbCon->getUserMSG())."'); window.history.go(-1); </script>\n";

}

function acceptConnection($userid,$connectionid) {
	global $_CB_database,$ueConfig,$my;
	
	if(!$ueConfig['allowConnections']) {			// do not test, needed if rules changed! || !$ueConfig['useMutualConnections']
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if (!$my->id > 0) {
		mosNotAuth();
		return;
	}
	
	$cbCon=new cbConnection($userid);
	$cbCon->acceptConnection($userid,$connectionid);
	
	echo "<script type=\"text/javascript\"> alert('".addslashes($cbCon->getUserMSG())."'); window.history.go(-1); </script>\n";
}


function manageConnections($userid) {
	global $_CB_database,$ueConfig,$my;

	if(!$ueConfig['allowConnections']) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if ($my->id!=$userid || $my->id==0) {
		mosNotAuth();
		return;
	}
	
	$cbCon=new cbConnection($userid);
	
	$connections=$cbCon->getActiveConnections($userid);

	$actions = $cbCon->getPendingConnections($userid);

	$connecteds = $cbCon->getConnectedToMe($userid);

	HTML_comprofiler::manageConnections($connections,$actions,$connecteds);	
}

function saveConnections($connectionids) {
	global $_CB_database, $ueConfig, $my, $_POST;
	
	$andItemid = getCBprofileItemid();
	
	// simple spoof check security
	cbSpoofCheck();

	if(!$ueConfig['allowConnections']) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if (!$my->id > 0) {
		mosNotAuth();
		return;
	}
	$cbCon=new cbConnection($my->id);
	if (is_array($connectionids)) {
		foreach($connectionids AS $cid) {
			$connectionTypes	=	cbGetParam( $_POST, $cid.'connectiontype', array() );
			$cbCon->saveConnection( $cid, stripslashes( cbGetParam( $_POST, $cid . 'description', '' ) ), implode( '|*|', $connectionTypes ) );
		}
	}
	cbRedirect(sefRelToAbs( 'index.php?option=com_comprofiler&task=manageConnections&tab=1' . $andItemid ),
							(is_array($connectionids)) ? _UE_CONNECTIONSUPDATEDSUCCESSFULL : null);

}

function processConnectionActions($connectionids) {
	global $_CB_database, $ueConfig, $my, $_POST;

	// simple spoof check security
	cbSpoofCheck();

	if(!$ueConfig['allowConnections']) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if ( ! ( $my->id > 0 ) ) {
		mosNotAuth();
		return;
	}
	$cbCon	=	new cbConnection($my->id);
	
	if (is_array($connectionids)) {
		foreach($connectionids AS $cid) {
			$action		=	cbGetParam( $_POST, $cid . 'action' );
			if ( $action== 'd' ) {
				$cbCon->denyConnection( $my->id, $cid );
			} elseif ( $action == 'a' ) {
				$cbCon->acceptConnection( $my->id, $cid );
			}
		}
	}
	cbRedirect(sefRelToAbs( 'index.php?option=com_comprofiler&task=manageConnections' . getCBprofileItemid() ),
							(is_array($connectionids)) ? _UE_CONNECTIONACTIONSSUCCESSFULL : null);
	return;
}

function getConnectionTypes( $types ) {
	$typelist	=	null;
	$types		=	explode( "|*|", $types );
	foreach( $types AS $type ) {
		if( $typelist == null ) {
			$typelist	=	getLangDefinition( $type );
		} else {
			$typelist	.=	", " . getLangDefinition( $type );	
		}
	}
	return $typelist;
}

?>

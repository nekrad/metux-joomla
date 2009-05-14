<?php
/*************************************************************
* Mambo Community Builder L895-> double name warning
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/
// defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/* verändert Anfang */
defined('_JEXEC') or die('Restricted access');
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(0);
JLoader::register('JTableUser', JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'user.php');
global $ueConfig, $enhanced_Config, $mosConfig_lang, $limitstart, $mainframe;
$lang =& JFactory::getLanguage();
$mosConfig_lang = $lang->getBackwardLang();
require_once( JApplicationHelper::getPath( 'front_html', 'com_cbe' ) );
$database = &JFactory::getDBO();
$acl =& JFactory::getACL();
$my =& JFactory::getUser();
$usersConfig = &JComponentHelper::getParams( 'com_users' );
$contentConfig = &JComponentHelper::getParams( 'com_content' );    
// User registration settings
$mosConfig_allowUserRegistration = $usersConfig->get('allowUserRegistration');
$mosConfig_useractivation = $usersConfig->get('useractivation');
$GLOBALS["mosConfig_allowUserRegistration"] = $mosConfig_allowUserRegistration;
//die($mosConfig_allowUserRegistration);
/* verändert Ende */

$document = &JFactory::getDocument();
$document->addScript( JURI::root().'components'.DS.'com_cbe'.DS.'js'.DS.'mootools.js');

$access = new stdClass();
$access->canEdit = $acl->acl_check( 'action', 'edit', 'users', $my->usertype, 'content', 'all' );
$access->canEditOwn = $acl->acl_check( 'action', 'edit', 'users', $my->usertype, 'content', 'own' );

//require_once ( $mainframe->getPath( 'front_html' ) );
include_once( "administrator/components/com_cbe/ue_config.php" );
include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');
include_once("administrator/components/com_cbe/imgToolbox.class.php");

$do_die = 0;

if ($ueConfig['use_cbe_gallery'] == '1' && file_exists(JPATH_SITE.'/components/com_cbe/enhanced/gallery/gallery.php')) {
	include_once(JPATH_SITE.'/components/com_cbe/enhanced/gallery/cbe_inc_gallery.php');
} else {
	$cbe_gallery_installed = 0;
}

if ($ueConfig['use_acctexp']=='1') {
	$acct_cbe_ver = $ueConfig['use_acctexp_version'];
	if (file_exists(JPATH_SITE.'/administrator/components/com_acctexp/acctexp.xml')) {
		//include_once ("components/com_acctexp/acctexp.class.php");
		include_once ("components/com_acctexp/acctexp.html.php");
		include_once('administrator/components/com_cbe/enhanced_admin/cbe_acctexp.class_'.$acct_cbe_ver.'.php');
	} else {
		echo "INSTALL com_acctexp FIRST!<br>\n";
		$do_die = 1;
	}
}
if ($ueConfig['use_smfBridge'] == '1') {
	if(!file_exists(JPATH_SITE.'/administrator/components/com_smf/config.smf.php')) {
		if(!file_exists(JPATH_SITE.'/administrator/components/com_smf/smf.xml')) {
			echo "INSTALL com_smf ( SMF-Bridge: www.joomlahacks.com ) FIRST!<br>\n";
			$do_die = 1;
		}
	}
}
if ($ueConfig['use_fqmulticorreos'] == '1') {
	if(!file_exists(JPATH_SITE.'/administrator/components/com_fq/fq.xml')) {
		echo "INSTALL com_fq ( Multicorreos ) FIRST!<br>\n";
		$do_die = 1;
	}
}
if ($ueConfig['use_yanc'] == '1') {
	if(!file_exists(JPATH_SITE.'/administrator/components/com_yanc/yanc.xml')) {
		echo "INSTALL com_smf ( SMF-Bridge: www.joomlahacks.com ) FIRST!<br>\n";
		$do_die = 1;
	}
}


if ($do_die == 1) {
	die();
}

$UEAdminPath=JPATH_BASE . '/administrator/components/com_cbe';

if (file_exists($UEAdminPath.'/language/'.$mosConfig_lang.'.php')) {
	include_once($UEAdminPath.'/language/'.$mosConfig_lang.'.php');
} else {
	include_once($UEAdminPath.'/language/english.php');
}

$form		= JRequest::getVar('reportform', 1);
$uid		= JRequest::getVar('uid', 0);
$doUnblock	= JRequest::getVar('unblock', 0);
$pt_js_call	= JRequest::getVar('scrp', 'none' );
$act		= JRequest::getVar('act', 1 );
$userpr		= JRequest::getVar('userid','');

$limitstart = JRequest::getVar('limitstart',0);
$search = JRequest::getVar('search','');

$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0') AND access='0' ORDER BY id DESC Limit 1");
$Itemid_com = $database->loadResult();
if ($Itemid_com!='' || $Itemid_com!=NULL) {
	$Itemid_com = '&Itemid='.$Itemid_com;
} else {
	$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0') AND access='1' ORDER BY id DESC Limit 1");
	$Itemid_com = $database->loadResult();
	if ($Itemid_com!='' || $Itemid_com!=NULL) {
		$Itemid_com = '&amp;Itemid='.$Itemid_com;
	} else {
		$Itemid_com = '';
	}
}

//Enhanced includes
include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

if (file_exists('components/com_cbe/enhanced/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/language/english.php');
}
if (file_exists('components/com_cbe/enhanced/geocoder/language/'.$mosConfig_lang.'.php')) {
	include_once('components/com_cbe/enhanced/geocoder/language/'.$mosConfig_lang.'.php');
}

if(!ISSET($mosConfig_emailpass)) $mosConfig_emailpass=0;

switch( $task )
{

        case "unRegister":
        unregister_( $option, $my->id, $submitvalue );
        break;
        
        case "deleteUser":
        deleteUser_( $option, $my->id, $submitvalue );
        break;
	
	case "userDetails":
	userEdit( $option, $my->id, _UE_UPDATE );
	break;

	case "saveUserEdit":
	userSave( $option, $my->id );
	break;

	case "userProfile":
	userProfile($option, $my->id, _UE_UPDATE);
	break;

	case "usersList":
	usersList($option, $my->id, _UE_UPDATE);
	break;

	case "userAvatar":
	userAvatar($option, $my->id, _UE_UPDATE);
	break;

	case "lostPassword":
	lostPassForm( $option );
	break;

	case "sendNewPass":
	sendNewPass( $option );
	break;

	case "registers":
	registerForm( $option, intval($ueConfig['generatepass_on_reg']) );
	break;

	case "saveRegistration":
	saveRegistration( $option );
	break;

	case "login":
	login();
	break;

	case "logout":
	logout();
	break;

	case "confirm":
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
		(isset($_GET['confirmCode'])) ? $confirmCode = cbGetEscaped($_GET['confirmCode']) : $confirmCode = '';
		confirm($confirmCode);
	break;

	case "moderator":
	moderator($option);
	break;

	case "moderateImages":
	moderateImages($option);
	break;

	case "moderateReports":
	moderateReports($option);
	break;

	case "moderateBans":
	moderateBans($option);
	break;

	case "approveImage":
	approveImage();
	break;

	case "reportUser":
	reportUser($option,$form,$uid);
	break;

	case "processReports":
	processReports();
	break;

	case "banProfile":
	banUser($option,$uid,$form,$act,$doUnblock);
	break;

	case "viewReports":
	viewReports($option,$uid);
	break;

	case "emailUser":
	emailUser($option,$uid);
	break;

	case "pendingApprovalUser":
	pendingApprovalUsers($option);
	break;

	case "approveUser":
	approveUser($option,$uids);
	break;

	case "rejectUser":
	rejectUser($option,$uids);
	break;

	case "sendUserEmail":
	sendUserEmail($_POST['toID'],$_POST['fromID'],$_POST['emailSubject'],$_POST['emailBody']);
	break;

	case "cbsearch":
	cbsearch($option, $my->id, _UE_UPDATE);
	break; // added by Rasmus Dahl-Sorensen - January 18 2005

	case "cbsearchlist":
	cbsearchlist($option, $my->id, _UE_UPDATE);
	break; // added by Rasmus Dahl-Sorensen - January 18 2005

	case "realChat":
	realChat($option, $my->id);
	break; // added by Philipp Kolloczek - 24.09.2005

	case "CheckUSRname":
	checkUserName($option, JArrayHelper::getValue($_GET, 'name', ''));
	break; // added by Philipp Kolloczek - 25.03.2006
	
	case "doGeoCoder":
	doGeoCoderCall($option, JArrayHelper::getValue($_GET, 'address', ''), JArrayHelper::getValue($_GET, 'uidu', '0'), JArrayHelper::getValue($_GET, 'uidh', '0'));
	break;

	case "doGeoMapXML":
	doGeoMapXMLCall();
	break;

	case "doGeoMapUsr";
	doGeoMapShowCall();
	break;

	case "Version":
	case "version":
	cbe_version();
	break;
	
	case "TopMostUser":
	showTopMost($Itemid_com, $Itemid);
	break;

	case "callthrough":
	doJSpassthrough($pt_js_call);
	break;

	case "moderateGallery":
	 moderateGallery($option);
	break;

	case "approveGallery":
	 approveGallery();
	break;
	
	default:
	userProfile($option, $my->id, _UE_UPDATE);
	break;
}

function sendUserEmail($toid,$fromid,$subject,$message) {
	global $ueConfig,$_SERVER,$mosConfig_sitename;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();

	$rowFrom = new JTableUser( $database );
	$rowFrom->load( $fromid );

	$rowTo = new JTableUser( $database );
	$rowTo->load( $toid );
	$uname=getNameFormat($rowFrom->name,$rowFrom->username,$ueConfig['name_format']);
	$to=$rowTo->email;
	$from_name= $uname. " @ ".$mosConfig_sitename;
	$from_email= $rowFrom->email;
	$subject=$subject;
	$premessage=sprintf(_UE_SENDEMAILNOTICE,$uname,$mosConfig_sitename,JURI::root(),$mosConfig_sitename);
	$message=$premessage."\r\n\r\n".stripslashes($message);
	$res = JUTility::sendMail($from_email, $from_name, $to, $subject, $message);
	if ($res) echo _UE_SENTEMAILSUCCESS;
	else echo _UE_SENTEMAILFAILED;
}

function emailUser($option,$uid) {
	global $ueConfig;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();

	if ($my->id == 0) {
		echo JText::_('ALERTNOTAUTH');

		//echo JText::_(ALERTNOTAUTH);
		return;
	}
	$rowFrom = new JTableUser( $database );
	$rowFrom->load( $my->id );

	$rowTo = new JTableUser( $database );
	$rowTo->load( $uid );
	HTML_cbe::emailUser($option,$rowFrom,$rowTo);
}

function userEdit( $option, $uid, $submitvalue) {
	global $ueConfig,$mainframe;
	$database = &JFactory::getDBO();

	if ($uid == 0) {
		echo JText::_('ALERTNOTAUTH');

		//echo JText::_(ALERTNOTAUTH);
		return;
	}

	$database->setQuery( "SELECT * FROM #__cbe c, #__users u WHERE c.id=u.id AND c.id='".$uid."'");
	$users = $database->loadObjectList();
	$user = $users[0];

	$mainframe->setPageTitle(_UE_EDIT_TITLE);
	
	HTML_cbe::userEdit( $user, $option, $submitvalue);
}

function userAvatar( $option, $uid, $submitvalue) {
	$database = &JFactory::getDBO();

	if ($uid == 0) {
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	$row = new JTableUser($database);
	//$row = new JTableUser( $database );
	$row->load( $uid );
	$row->orig_password = $row->password;
	HTML_cbe::userAvatar( $row, $option, $submitvalue);
}

function userProfile( $option, $uid, $submitvalue) {
	global $_REQUEST, $ueConfig,$my,$mainframe, $_POST, $user;
	global $enhanced_Config,$mosConfig_lang,$mosConfig_live_site;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
// 
	// funktionen einbinden
	JHTML::script('mootools.js', 'components/com_cbe/enhanced/ajaxmod/js/', false);
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$my	=& JFactory::getUser();

	$mainframe->setPageTitle(_UE_PROFILE_TITLE);

	if (!allowAccess( $ueConfig['allow_profileviewbyGID'],'RECURSE', userGID($my->id), $acl, '1'))
	{
		echo _UE_NOT_AUTHORIZED;
		return;
	}

	//print_r($_REQUEST);
	
	if (!ISSET($_REQUEST['user']) && $uid==0)
	{
		echo _UE_REGISTERFORPROFILE;
		return;
	}

	$ajaxdirekt	= JRequest::getVar('ajaxdirekt', null);
	$tabname = JRequest::getVar('tabname', null);

	if ($ajaxdirekt) {
		$tabfile = JPATH_SITE.DS.'components'.DS.'com_cbe'.DS.'enhanced'.DS.$tabname.DS.$tabname.".php";
		if (file_exists($tabfile)) {
			include_once($tabfile);
		}
		return;
	}
	//$row = new JTableUser( $database );
	$row = new JTableUser($database);
	if(!ISSET($_REQUEST['user']))
	{
		$database->setQuery("SELECT * FROM #__cbe c, #__users u WHERE c.id=u.id AND c.id='".$uid."'");
	}
	else
	{
// PK edit
		if ($enhanced_Config['profile_by_name']=='1') {
			if (eregi("[a-z']",cbGetEscaped($_REQUEST['user']))) {

				$cb_user = cbGetEscaped($_REQUEST['user']);
				$cb_user = str_replace(';','',$cb_user);
				$cb_user = str_replace("\'",'',$cb_user);
				$query = "SELECT id from #__users where username='$cb_user' LIMIT 1";
				$database->setQuery($query);
				$cb_uid = $database->loadResult();
			} else {
				$cb_uid = cbGetEscaped($_REQUEST['user']);
			}
		} else {
			$cb_uid = cbGetEscaped($_REQUEST['user']);
		}
		$database->setQuery( "SELECT * FROM #__cbe c, #__users u WHERE c.user_id=u.id AND c.user_id='".$cb_uid."'");

// PK end
	}
	$users = $database->loadObjectList();
	if (count($users)==0)
	{
		echo _UE_NOSUCHPROFILE;
		return;
	}

	$user = $users[0];

	//$pop_win = JArrayHelper::getValue( $_REQUEST, 'pop', 0 );
	$pop_win = JArrayHelper::getValue($_REQUEST, 'pop', 0);
// PK edit ----

	$database->setQuery ( "SELECT avatar, avatarapproved FROM #__cbe WHERE user_id ='".$my->id."'");
	$useravatar = $database->loadObjectList();

	if ( $enhanced_Config['pic2profile'] == '1' ) {
		if (($useravatar[0]->avatar == '' || $useravatar==null || $useravatar[0]->avatarapproved != 1) && ($my->id != $user->id)) {
			$do_profile_view = 0;
		} else {
			$do_profile_view = 1;
		}
	} else {
		$do_profile_view = 1;
	}

	$isModerator=isModerator($my->id);
	if ($isModerator=='1') {
		$do_profile_view = 1;
	}
	
	if ($do_profile_view == 0) {
		echo _UE_PIC2PROFILE_WARNING;
	} else {

// --- PK edit	-> watch L-485 !

        $pop_enh = '';
        $pop_link= '';
        if ($pop_win == 1) {
                $pop_enh = '2';
                $pop_link = '&amp;pop=1';
		echo "<div style=\"text-align: center;\"> <a href=\"javascript:window.close();\"> CLOSE </a></div> \n";
        }
	// echo "<div style=\"text-align: center;\"> <a href=\"javascript:window.history.go(-1);;\"> Back </a></div> \n";

	HTML_cbe::userProfile( $user,$option, $submitvalue);

// Profile Blocked ?
// 811
//	$isModerator=isModerator($my->id); see line 315
	if(($user->banned == '0') || ($my->id == $user->id) || ($isModerator=='1')) {

// -- PK edit RateIt

	if ($enhanced_Config['rateit_allow'] == '1') {
		include('components/com_cbe/enhanced/rating/rateing.php');
	}
//	RateGetRate();
	
//	RateShowForm($user->id,10,"Bewerte das Profile","Vote!","",$my->id);

// -- PK end RateIt

	//****Begin Enhanced ****/
	//*** DO TABS SECTION *****/
	/**** Modular tabbing and redirection ****/

	include_once('components/com_cbe/enhanced/enhanced.class.php');
	include_once('components/com_cbe/enhanced/enhanced_functions.inc');
	// include PMS Links
	include_once('components/com_cbe/enhanced/pms_includes.php');

	//start mostab class
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBETabHandler.php');

	$tabs = new enhancedTabs( 0,1, $ueConfig['templatedir'] );
	//print_r($tabs);
	/**** Profile tabb coloring ****/
	$query = "SELECT profile_color
			  FROM #__cbe 
			  WHERE user_id = '".$user->id."'";
	$database ->setQuery ($query);
	$bgcolor = $database->loadResult();

	if($enhanced_Config['profile_allow_colors']=='1')
	{
		if($bgcolor)
		{
			$bgcolor = getLangEnDefinition($bgcolor);
			$profileColor=profileColors($bgcolor);
		}
		elseif(!$bgcolor)
		{
			$color=$enhanced_Config['profile_color'];

			if($color)
			{
				$profileColor = $color;
			}
			else
			{
				$profileColor='transparent';
			}
		}

	}

	if($enhanced_Config['profile_allow_colors']=='0')
	{
		$color=$enhanced_Config['profile_color'];

		if($color)
		{
			$profileColor = $color;
		}
		else
		{
			$profileColor='transparent';
		}
	}
// 1
$pID='CBE';
//start a tab pane	cbprofiletabpane
$tabs->startPane($pID);//for identification

/////////////////
	$paneID = $pID;

	if($ueConfig['nesttabs']) {
		$database->setQuery("SELECT tabid,title,description,enhanced_params,aclgroups,sys,nested,is_nest,nest_id,q_me,q_you,q_bind FROM #__cbe_tabs WHERE enabled=1 AND sys !=1 ORDER by ordering");
		$tabrunthrus = $database->loadObjectList();
		$def_nest = array( (object) array("tabid" => "-1", "title" => "_UE_PROFILETAB", "is_nest" => "1"));
		$tabrunthrus = array_merge($def_nest, $tabrunthrus);
	} else {
		$database->setQuery("SELECT tabid,title,description,enhanced_params,aclgroups,sys,nested,is_nest,nest_id,q_me,q_you,q_bind FROM #__cbe_tabs WHERE enabled=1 AND sys !=1 AND is_nest=0 ORDER by ordering");
		$tabrunthrus = $database->loadObjectList();
	}

	// do ACL check
	$i_p = 0;
	//print_r($tabrunthrus);
	foreach($tabrunthrus AS $pTab) {
		//$tabparams = new JRegistry($pTab->enhanced_params);
		$tabparams = new JRegistry($pTab->enhanced_params);
		if ((@$tabparams->reg_only) && ($my->usertype == '')) {
			unset($tabrunthrus[$i_p]);
		}
		// tab-avatar-switch
		if ((@$tabparams->avatar_only) && ($useravatar[0]->avatar == '' || $useravatar==null || $useravatar[0]->avatarapproved != 1) && ($my->id != $user->id)) {
			unset($tabrunthrus[$i_p]);
		}
		//sv0.6232
		if ($pTab->aclgroups!='') {
			$aclgroups = explode(",", $pTab->aclgroups);
			$do_unset=1;
			foreach ($aclgroups as $aclgroup) {
				if (allowAccess($aclgroup, 'RECURSE', userGID($my->id), $acl)) {
					$do_unset=0;
				}
			}
			if ($do_unset!=0) {
				unset($tabrunthrus[$i_p]);
			}
		}
		//sv0.6235 conditions
		if ($pTab->q_me!='' || $pTab->q_you!='') {
			$do_unset = 0;
			$do_unset_me = 0;
			$do_unset_you = 0;
			if ($pTab->q_me!='') {
				$cond_type = substr($pTab->q_me,0,1);
				if ($cond_type=='a' || $cond_type=='s') {
					$cond_text = utf8RawUrlDecode(substr($pTab->q_me,1));
					//$cond_text = eregi_replace('username','u.username',$cond_text);
					//$cond_text = eregi_replace('usertype','u.usertype',$cond_text);
					$database->setQuery("SELECT c.user_id FROM #__cbe as c, #__users as u WHERE c.user_id='".$user->id."' AND c.user_id=u.id AND ".$cond_text);
					$cond_ret = $database->loadResult();
					if (!$database->query() || $cond_ret==NULL || $cond_ret =='') {
						$do_unset_me = 1;
					} else {
						if ($cond_ret != $user->id) {
							$do_unset_me = 1;
						}
					}
				} else if ($cond_type=='i') {
					$cond_check = false;
					$cond_text = utf8RawUrlDecode(substr($pTab->q_me,2,-1));
					$cond_check = strpos(strtolower($cond_text),'select');
					$cond_check1 = strpos(strtolower($cond_text),';');
					if ($cond_check!==false && $cond_check == 0 && $cond_check1 === false) {
						$cond_text = str_replace('$user->id',$user->id,$cond_text);
						$cond_text = str_replace('$my->id',$my->id,$cond_text);
						$database->setQuery($cond_text);
						$cond_ret = $database->loadResult();
						if (!$database->query() || $cond_ret==NULL || $cond_ret =='') {
							$do_unset_me = 1;
						} else {
							if ($cond_ret != $user->id) {
								$do_unset_me = 1;
							}
						}
					} else {
						$do_unset_me = 1;
					}
				}
			}
			if ($pTab->q_you!='' && $my->id != $user->id && $isModerator=='0') {
				// do q_you
				$invert_type = substr($pTab->q_you,0,1);
				if ($invert_type == 'i') {
					$query_uid = $user->id;
				} else { 
					$query_uid = $my->id;
				}
				$pTab->q_you = substr($pTab->q_you,1);
				$cond_type = substr($pTab->q_you,0,1);
				if ($cond_type=='a' || $cond_type=='s') {
					$cond_text = utf8RawUrlDecode(substr($pTab->q_you,1));
					//$cond_text = eregi_replace('username','u.username',$cond_text);
					//$cond_text = eregi_replace('usertype','u.usertype',$cond_text);
					$database->setQuery("SELECT c.user_id FROM #__cbe as c, #__users as u WHERE c.user_id='".$query_uid."' AND c.user_id=u.id AND ".$cond_text);
					$cond_ret = $database->loadResult();
					if (!$database->query() || $cond_ret==NULL || $cond_ret =='') {
						$do_unset_you = 1;
					} else {
						if ($cond_ret != $query_uid) {
							$do_unset_you = 1;
						}
					}
				} else if ($cond_type=='i') {
					$cond_check = false;
					$cond_text = utf8RawUrlDecode(substr($pTab->q_you,2,-1));
					$cond_check = strpos(strtolower($cond_text),'select');
					$cond_check1 = strpos(strtolower($cond_text),';');
					if ($cond_check!==false && $cond_check == 0 && $cond_check1 === false) {
						$cond_text = str_replace('$user->id',$user->id,$cond_text);
						$cond_text = str_replace('$my->id',$my->id,$cond_text);
						$database->setQuery($cond_text);
						$cond_ret = $database->loadResult();
						if (!$database->query() || $cond_ret==NULL || $cond_ret =='') {
							$do_unset_you = 1;
						} else {
							if ($cond_ret != $query_uid) {
								$do_unset_you = 1;
							}
						}
					} else {
						$do_unset_you = 1;
					}
				}
			}
			if ($my->id != $user->id && $isModerator == '0') {
				if ($pTab->q_bind == 'AND') {
					if ($do_unset_me == 0 && $do_unset_you == 0) {
						$do_unset = 0;
					} else {
						$do_unset = 1;
					}
				} else if ($pTab->q_bind == 'OR') {
					if ($do_unset_me == 0 || $do_unset_you == 0) {
						$do_unset = 0;
					} else {
						$do_unset = 1;
					}
				}
			} else {
				$do_unset = $do_unset_me;
			}
			if ($do_unset!=0) {
				unset($tabrunthrus[$i_p]);
			}
		}
		// cond end
		$i_p++;
	}
	$tmp_tab = array();
	foreach ($tabrunthrus as $tabrunthru) {
		$tmp_tab[] = $tabrunthru;
	}
	$tabrunthrus = $tmp_tab;
	// ACL End

	$tab_count = count($tabrunthrus);

	$tabNavHelper = array();
	$pID = (isset($panedID))?$paneID:0;
	$tab_c = 0;
	$i_pa = 0;
	$i_nn = 0;
	//($ueConfig['nesttabs']) ? $i_np = 1 : $i_np = 0 ;
	$i_np = 0;
	while ( $tab_c < $tab_count ) {
		
		// first check if tab is nest, then give out nest-tabs
		//print_r($tabrunthrus[$tab_c]); 
		if ($tabrunthrus[$tab_c]->is_nest == 1 && $ueConfig['nesttabs']) {
			$i_pa++;
			if ($tabrunthrus[$tab_c]->tabid == -1) {
				$pID = $paneID."Nest";
			} else {
				$pID = $paneID."Nest".$tabrunthrus[$tab_c]->tabid;
			}
			$tabs->startTab($paneID,getLangEnDefinition($tabrunthrus[$tab_c]->title),$i_pa);
			if ($tabrunthrus[$tab_c]->description) {
				echo "<div class=\"CBESubTabDesCell\">".$tabrunthrus[$tab_c]->description."</div><br>\n";
			}
			$tabs->startPane($pID);

			$i_pp = 0;
			foreach($tabrunthrus as $tabrunthru)
			{
				if ($tabrunthru->nest_id == $tabrunthrus[$tab_c]->tabid && $tabrunthru->nested == 1) {
					$tabparams = new JRegistry($tabrunthru->enhanced_params);

					if(@$tabparams->profile || @$tabparams->profile=='' ||
					  (@$tabparams->profileuseronly && ($my->id == $user->id || $isModerator=='1')))
					{
						$doHelper = 0;
						if(@$tabparams->tabtype == '1')
						{
							//enhanced
							//start a tab page
							$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
							include_once('components/com_cbe/enhanced/'.$tabparams->enhancedname.'/'.$tabparams->enhancedname.'.php');
							$classname = "CBE_" . $tabparams->enhancedname;
							if (class_exists($classname)) {
								$cbetab = new CBETabHandler($tabparams->enhancedname);
								$ptrClass = new $classname($cbetab);
								$ptrClass->display();
							}
							$tabs->endTab();
							$doHelper= 1;
						}
						elseif(@$tabparams->tabtype == '2')
						{
							//module
							//start a tab page
			         	
							$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
							//include a module
							include('modules/'.$tabparams->modulename.'.php');
							//end a tab page
							$tabs->endTab();
							$doHelper= 1;
						}
						elseif(@$tabparams->tabtype == '3')
						{
							//start a tab page
			         	
							$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
							//include a component
							include('components/com_'.$tabparams->enhancedname.'/'.$tabparams->enhancedname.'.php');
							//end a tab page
							$tabs->endTab();
							$doHelper= 1;
						}
						else
						{
			         	
							//CB original
							if ($ueConfig['allow_email_display']==0)
							{
								$whereAdd = " AND type != 'emailaddress' ";
							}
							$database->setQuery( "SELECT * FROM #__cbe_fields"
							. "\n WHERE published=1 AND profile=1 AND tabid = $tabrunthru->tabid"
							. @$whereAdd
							. "\n ORDER BY ordering" );
			         	
							$rowFields = $database->loadObjectList();
			         	
							$t=1;
							$n=count($rowFields);
							$tabhasfilledfield= 0;
							$tfield='';
			         	
							for($i=0; $i < $n; $i++)
							{
								$fValue='$user->'.$rowFields[$i]->name;
								eval("\$fValue = \"".$fValue."\";");
								$fieldValue = getFieldValue($rowFields[$i]->type,stripslashes($fValue),$user,null,$rowFields[$i]->cols);
			         	
								if($fieldValue!=null || trim($fieldValue)!='')
								{
			         	
									if ($enhanced_Config['profile_langFilterText'] == '1') {
										if ($rowFields[$i]->type=='text' || $rowFields[$i]->type=='textarea' || $rowFields[$i]->type=='editorta' || $rowFields[$i]->type=='webaddress') {
											$fieldValue = language_filter($fieldValue);
										}
									}
									//if ($enhanced_Config['profile_txt_wordwrap'] == '1') {
									//	if ($rowFields[$i]->type=='textarea' || $rowFields[$i]->type=='editorta') {
									//		$fieldValue = cbe_wordwrap($fieldValue, $rowFields[$i]->cols, 1);
									//	}
									//}
									$fieldtitle = getLangDefinition($rowFields[$i]->title);
									$evenodd = $t % 2;
									if ($evenodd == 0)
									$class = 'sectiontableentry1';
									else
									$class = 'sectiontableentry2';
									$t++;
			         	
									if ($rowFields[$i]->type=='editorta' && $enhanced_Config['full_editorfield']=='1') {
										$tfield .= '<tr><td colspan="2" class="'.$class.'">'.$fieldValue.'</td></tr>';
									} else if ($rowFields[$i]->type=='multicheckbox' || $rowFields[$i]->type=='multiselect') {
										// $fieldValue = str_replace(";", " <br /> ", $fieldValue);
										$fieldValue = str_replace("&amp;", "&", $fieldValue);
										$fV_arr = explode(";", $fieldValue);
										$fV_arr_c = count($fV_arr);
										$fV_arr_ct = round($fV_arr_c / 2);
										$fV_new = '';
										$fV_new = "<table cellspacing=\"0\" cellpadding=\"0\"> <tr><td>\n";
										$fV_new .= "<ul class=\"cbefrontul\">\n";
										for ($fV_i=0; $fV_i < $fV_arr_ct ; $fV_i++) {
											$fV_new .= "<li class=\"cbefrontli1\">".$fV_arr[$fV_i]."<br />\n";
										}
										$fV_new .= " </ul></td><td><ul class=\"cbefrontul\"> \n";
										for ($fV_i=$fV_arr_ct; $fV_i < $fV_arr_c ; $fV_i++) {
											$fV_new .= "<li class=\"cbefrontli2\">".$fV_arr[$fV_i]."<br />\n";
										}
										$fV_new .= "</ul> ";
										$fV_new .= "</td></tr> </table> \n";
										$fieldValue = $fV_new;
										
										$tfield .= '<tr><td class="'.$class.'" width=40% style="font-weight:bold;">'.$fieldtitle.':</td>';
										$tfield .= '<td class="'.$class.'">'.$fieldValue.'</td></tr>';
									} else {
										$tfield .= '<tr><td class="'.$class.'" width=40% style="font-weight:bold;">'.$fieldtitle.':</td>';
										$tfield .= '<td class="'.$class.'">'.$fieldValue.'</td></tr>';
									}
									
									$tabhasfilledfield= 1;
								}//end if
								if ($rowFields[$i]->type == 'spacer') {
									if ($rowFields[$i]->title == '-null-') {
										$tfield .= "<tr><td colspan=\"2\" class=\"CBEspacerCell\">&nbsp;</td></tr>\n";
									} else {
										$tfield .= "<tr><td colspan=\"2\" class=\"CBEspacerCell\">". getLangDefinition($rowFields[$i]->title) ."</td></tr>\n";
									}
									if ($rowFields[$i]->information == '-null-' || $rowFields[$i]->infotag == 'none') {
										$tfield .= "<tr><td colspan=\"2\" class=\"CBEfieldInfoCell\">&nbsp;</td></tr>\n";
									} else if (($rowFields[$i]->infotag != 'none') && $rowFields[$i]->information != '-null-') {
										$tfield .= "</tr>\n<tr>\n<td colspan=\"2\" class=\"CBEfieldInfoCell\">". getLangDefinition($rowFields[$i]->information) ."</td>\n";
									}
									if ($rowFields[$i]->infotag == "both") {
										$tabhasfilledfield = 1;
									}
								}
							}//end for
			         	
							if($tabhasfilledfield)
							{
								//start a tab page
								$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
								echo '<table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td>';
								//list cb tab fields
								echo $tfield;
								echo '</td></tr></table>';
								//end a tab page
								$tabs->endTab();
								$doHelper = 1;
							}		
						}
						if ($doHelper) {
							$tabNavHelper[$i_pa][$i_pp]->nestpane = $pID;
							$tabNavHelper[$i_pa][$i_pp]->id = $i_pp;
							$tabNavHelper[$i_pa][$i_pp]->tabid = $tabrunthru->tabid;
							$tabNavHelper[$i_pa][$i_pp]->title = getLangEnDefinition($tabrunthru->title);
							$tabNavHelper[$i_pa][$i_pp]->nested = true;
							$tabNavHelper[$i_pa][$i_pp]->pane = $i_nn;
							$i_pp++;
						}
					} // if access end
				}
			}//end foreach
			$i_nn++;
			$tabs->endPane();
			$tabs->endTab();

		} elseif (($tabrunthrus[$tab_c]->nested == 0 && $ueConfig['nesttabs']) || ($tabrunthrus[$tab_c]->is_nest != 1 && !$ueConfig['nesttabs'])) { //nest end
			$pID = $paneID;
			$tabrunthru = $tabrunthrus[$tab_c];
			//$tabparams = new JRegistry($tabrunthru->enhanced_params);
			$tp = new JRegistry();
			$tp->loadINI($tabrunthru->enhanced_params);
			//$tabparams = new JRegistry($tabrunthru->enhanced_params);
			$tabparams = $tp->toObject();

			if(@$tabparams->profile || @$tabparams->profile=='' ||
			  (@$tabparams->profileuseronly && ($my->id == $user->id || $isModerator=='1')))
			{
				$doHelper = 0;
				if(@$tabparams->tabtype == '1')
				{
					//enhanced
					//start a tab page
			
					$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
					//include a enhanced
					//include('components/com_cbe/enhanced/'.$tabparams->enhancedname.'/'.$tabparams->enhancedname.'.php');
					require(JPATH_SITE .'/components/com_cbe/enhanced/'.$tabparams->enhancedname.'/'.$tabparams->enhancedname.'.php');
					$classname = "CBE_" . $tabparams->enhancedname;
					if (class_exists($classname)) {
						$cbetab = new CBETabHandler($tabparams->enhancedname);
						$ptrClass = new $classname($cbetab);
						$ptrClass->display();
					}

					//end a tab page
					$tabs->endTab();
					$doHelper= 1;
				}
				elseif(@$tabparams->tabtype == '2')
				{
					//module
					//start a tab page
			
					$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
					//include a module
					include('modules/'.$tabparams->modulename.'.php');
					//end a tab page
					$tabs->endTab();
					$doHelper= 1;
				}
				elseif(@$tabparams->tabtype == '3')
				{
					//start a tab page
			
					$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
					//include a component
					include('components/com_'.$tabparams->enhancedname.'/'.$tabparams->enhancedname.'.php');
					//end a tab page
					$tabs->endTab();
					$doHelper= 1;
				}
				else
				{
			
					//CB original
					if ($ueConfig['allow_email_display']==0)
					{
						$whereAdd = " AND type != 'emailaddress' ";
					}
					$database->setQuery( "SELECT * FROM #__cbe_fields"
					. "\n WHERE published=1 AND profile=1 AND tabid = $tabrunthru->tabid"
					. @$whereAdd
					. "\n ORDER BY ordering" );
			
					$rowFields = $database->loadObjectList();
			
					$t=1;
					$n=count($rowFields);
					$tabhasfilledfield= 0;
					$tfield='';
			
					for($i=0; $i < $n; $i++)
					{
						$fValue='$user->'.$rowFields[$i]->name;
						eval("\$fValue = \"".$fValue."\";");
						$fieldValue = getFieldValue($rowFields[$i]->type,stripslashes($fValue),$user,null,$rowFields[$i]->cols);
			
						if($fieldValue!=null || trim($fieldValue)!='')
						{
			
							if ($enhanced_Config['profile_langFilterText'] == '1') {
								if ($rowFields[$i]->type=='text' || $rowFields[$i]->type=='textarea' || $rowFields[$i]->type=='editorta' || $rowFields[$i]->type=='webaddress') {
									$fieldValue = language_filter($fieldValue);
								}
							}
							//if ($enhanced_Config['profile_txt_wordwrap'] == '1') {
							//	if ($rowFields[$i]->type=='textarea' || $rowFields[$i]->type=='editorta') {
							//		$fieldValue = cbe_wordwrap($fieldValue, $rowFields[$i]->cols, 1);
							//	}
							//}
							$fieldtitle = getLangDefinition($rowFields[$i]->title);
							$evenodd = $t % 2;
							if ($evenodd == 0)
							$class = 'sectiontableentry1';
							else
							$class = 'sectiontableentry2';
							$t++;
			
							if ($rowFields[$i]->type=='editorta' && $enhanced_Config['full_editorfield']=='1') {
								$tfield .= '<tr><td colspan="2" class="'.$class.'">'.$fieldValue.'</td></tr>';
							} else if ($rowFields[$i]->type=='multicheckbox' || $rowFields[$i]->type=='multiselect') {
								// $fieldValue = str_replace(";", " <br /> ", $fieldValue);
								$fieldValue = str_replace("&amp;", "&", $fieldValue);
								$fV_arr = explode(";", $fieldValue);
								$fV_arr_c = count($fV_arr);
								$fV_arr_ct = round($fV_arr_c / 2);
								$fV_new = '';
								$fV_new = "<table cellspacing=\"0\" cellpadding=\"0\"> <tr><td>\n";
								$fV_new .= "<ul class=\"cbefrontul\">\n";
								for ($fV_i=0; $fV_i < $fV_arr_ct ; $fV_i++) {
									$fV_new .= "<li class=\"cbefrontli1\">".$fV_arr[$fV_i]."<br />\n";
								}
								$fV_new .= " </ul></td><td><ul class=\"cbefrontul\"> \n";
								for ($fV_i=$fV_arr_ct; $fV_i < $fV_arr_c ; $fV_i++) {
									$fV_new .= "<li class=\"cbefrontli2\">".$fV_arr[$fV_i]."<br />\n";
								}
								$fV_new .= "</ul> ";
								$fV_new .= "</td></tr> </table> \n";
								$fieldValue = $fV_new;
								
								$tfield .= '<tr><td class="'.$class.'" width=40% style="font-weight:bold;">'.$fieldtitle.':</td>';
								$tfield .= '<td class="'.$class.'">'.$fieldValue.'</td></tr>';
							} else {
								$tfield .= '<tr><td class="'.$class.'" width=40% style="font-weight:bold;">'.$fieldtitle.':</td>';
								$tfield .= '<td class="'.$class.'">'.$fieldValue.'</td></tr>';
							}
							
							$tabhasfilledfield= 1;
						}//end if
						if ($rowFields[$i]->type == 'spacer') {
							if ($rowFields[$i]->title == '-null-') {
								$tfield .= "<tr><td colspan=\"2\" class=\"CBEspacerCell\">&nbsp;</td></tr>\n";
							} else {
								$tfield .= "<tr><td colspan=\"2\" class=\"CBEspacerCell\">". getLangDefinition($rowFields[$i]->title) ."</td></tr>\n";
							}
							if ($rowFields[$i]->information == '-null-' || $rowFields[$i]->infotag == 'none') {
								$tfield .= "<tr><td colspan=\"2\" class=\"CBEfieldInfoCell\">&nbsp;</td></tr>\n";
							} else if (($rowFields[$i]->infotag != 'none') && $rowFields[$i]->information != '-null-') {
								$tfield .= "</tr>\n<tr>\n<td colspan=\"2\" class=\"CBEfieldInfoCell\">". getLangDefinition($rowFields[$i]->information) ."</td>\n";
							}
							if ($rowFields[$i]->infotag == "both") {
								$tabhasfilledfield = 1;
							}

						}
					}//end for
			
					if($tabhasfilledfield)
					{
						//start a tab page
						$tabs->startTab( $pID, getLangEnDefinition($tabrunthru->title), getLangEnDefinition($tabrunthru->title));
						echo '<table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td>';
						//list cb tab fields
						echo $tfield;
						echo '</td></tr></table>';
						//end a tab page
						$tabs->endTab();
						$doHelper = 1;
					}		
				}
				if ($doHelper) {
					$tabNavHelper[0][$i_np]->nestpane = $pID;
					$tabNavHelper[0][$i_np]->id = $i_np + $i_pa;
					$tabNavHelper[0][$i_np]->tabid = $tabrunthru->tabid;
					$tabNavHelper[0][$i_np]->title = getLangEnDefinition($tabrunthru->title);
					$tabNavHelper[0][$i_np]->nested = false;
					$i_np++;
				}
				$i_nn++;
			} // if access end
		} //nest complete end
		$tab_c++;
	} //while
/////////////////

$tabs->endPane();

$index=JArrayHelper::getValue( $_REQUEST, 'index', null);
if (!$index) {
	$index= trim(strval($_REQUEST['index']));
}
if($index)
{

	foreach($tabNavHelper as $tabNavHelp) {
		foreach($tabNavHelp as $tabNav) {
			if (getLangEnDefinition($tabNav->title) == $index) {
				echo "<script type=\"text/javascript\">\n";
				if ($tabNav->nested == true) {
					echo "  tabPaneCBE.setSelectedIndex(\"".$tabNav->pane."\"); \n";
				}
				echo "
				/**
				* John Resig, erklärt bei quirksmode
				*/
				function addEvent( obj, type, fn ) {
					if (obj.addEventListener) {
						obj.addEventListener( type, fn, false );
					} else if (obj.attachEvent) {
						obj['e'+type+fn] = fn;
						obj[type+fn] = function() { obj['e'+type+fn]( window.event ); }
						obj.attachEvent( 'on'+type, obj[type+fn] );
					}
				}

				function cbeShowTab() {
					document.getElementById('CBE').tabber.tabShow(" . $tabNav->id . ");
				}
				addEvent(window,'load', cbeShowTab);";
				//echo "  tabPane".$tabNav->nestpane.".setSelectedIndex(\"".$tabNav->id."\"); \n";
				echo "</script> \n";
			}
		}
	}
}
} // PK edit END

	if ($pop_win == 1) {
		echo "<script type=\"text/javascript\"> \n";
		echo "for (var i = 0; i < document.links.length; ++i) { \n";
		echo "  var test1 = document.links[i].href.search(/\(\)/); \n";
		echo "  var test2 = document.links[i].href.search(/\#/); \n";
		echo "  if (test1 == -1) { \n";
		echo "   if (test2 == -1) { \n";
		echo "    var vormals = document.links[i].href; \n";
		echo "    var jetzt = vormals.replace(/index\.php/, \"index2.php\"); \n";
		echo "    var jetzt = jetzt.replace(/com_cbe&/, \"com_cbe&pop=1&\"); \n";
		echo "    var jetzt = jetzt.replace(/com_cbe\//, \"com_cbe/pop,1/\"); \n";
		echo "    document.links[i].href = jetzt; \n";
		//echo "    document.write(\"<br>\" + document.links[i]); \n";
		echo "   } \n";
		echo "  } \n";
		echo "} \n";
		echo "</script> \n";
		echo "<div style=\"text-align: center;\"> <a href=\"javascript:window.close();\"> CLOSE </a></div> \n";
	}

} // end profile blocked
//****End Enhanced ****/
}


function usersList( $option, $uid, $submitvalue) {
	global $ueConfig,$_POST,$_REQUEST;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	if (!allowAccess( $ueConfig['allow_listviewbyGID'],'RECURSE', userGID($my->id), $acl, '1')) {
		echo _UE_NOT_AUTHORIZED;
		return;
	}
	// sv0.6233 get all parent gids and below
	$my_parGroups = getBelowGids(userGID($uid),1);
	
//	$database->setQuery("SELECT listid, title FROM #__cbe_lists WHERE published=1 ORDER BY ordering");
	$database->setQuery("SELECT listid, title FROM #__cbe_lists WHERE published=1 AND aclgroup IN (".$my_parGroups.") ORDER BY ordering");
	$plists = $database->loadObjectList();
	$lists = array();
	$publishedlists = array();

	for ($i=0, $n=count( $plists ); $i < $n; $i++) {
		$plist =& $plists[$i];
		$publishedlists[] = JHTML::_('select.option', $plist->listid, getLangDefinition($plist->title) );
	}

	if(!isset($_POST['listid']) && !isset($_REQUEST['listid'])) {
		$database->setQuery( "SELECT listid FROM #__cbe_lists "
		. "\n WHERE `default`=1 AND published=1" );
		$listid = $database->loadresult();
	} else {
		if(isset($_POST['listid'])) $listid = $_POST['listid'];
		else $listid = $_REQUEST['listid'];
	}
//PK edit
        $query_cklist = "SELECT listid FROM #__cbe_lists WHERE published='1' AND listid='".$listid."'";
        $database->setQuery($query_cklist);
        $listid = $database->loadResult();
//PK end
	if(!$listid > 0) {
		echo _UE_NOLISTFOUND;
		return;
	}
	$lists['plists'] = JHTML::_('select.genericlist', $publishedlists, 'listid', 'class="inputbox" size="1" onchange="document.ueform.submit();"', 'value', 'text', $listid );

	$database->setQuery( "SELECT l.* FROM #__cbe_lists l"
	. "\n WHERE l.listid='$listid' AND l.published=1" );
	$row = $database->loadObjectList();

	if (!checkParentBelow($row[0]->aclgroup,'RECURSE', userGID($uid))) {
		echo _UE_NOT_AUTHORIZED;
		return;
	}

	$col=$row[0]->col1fields;
	$col=explode('|*|',$col);
	$lfields="";
	$active_cols = 0;
	if ($row[0]->col1enabled && ($row[0]->col2enabled || $row[0]->col3enabled || $row[0]->col4enabled)) {
		$active_cols = 1;
	}
	if($row[0]->col1enabled) {
		for ($i=0, $n=count( $col ); $i < $n; $i++) {
			if($i==0 && $active_cols==1) $lfields .= "<td class='userslist_col1' valign='top'>\n";
			else $lfields .= "<br/>\n";
			if($col[$i]!='' && $col[$i]!=null) {
				$database->setQuery( "SELECT f.name, f.title, f.type "
				. "\nFROM #__cbe_fields AS f"
				. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
				$cfield = $database->loadObjectList();
				$cfield = $cfield[0];
				if($row[0]->col1captions==1)  $oTitle =  getLangDefinition($cfield->title).": ";
				else $oTitle='';
				$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
			}
		}
	
		if ($active_cols > 0) {
			$lfields .= "</td>\n";
		} else {
			$lfields .= "<br/>\n";
		}
	}
	if($row[0]->col2enabled) {
		$col=$row[0]->col2fields;
		$col=explode('|*|',$col);
		for ($i=0, $n=count( $col ); $i < $n; $i++) {
			if($i==0) $lfields .= "<td class='userslist_col2' valign='top'>\n";
			else $lfields .= "<br/>\n";
			if($col[$i]!='' && $col[$i]!=null) {
				$database->setQuery( "SELECT f.name, f.title, f.type "
				. "\nFROM #__cbe_fields AS f"
				. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
				$cfield = $database->loadObjectList();
				$cfield = $cfield[0];
				if($row[0]->col2captions==1) $oTitle =  getLangDefinition($cfield->title).": ";
				else $oTitle='';
				$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
			}
		}
		$lfields .= "</td>\n";
	}
	if($row[0]->col3enabled) {
		$col=$row[0]->col3fields;
		$col=explode('|*|',$col);
		for ($i=0, $n=count( $col ); $i < $n; $i++) {
			if($i==0) $lfields .= "<td class='userslist_col3' valign='top'>\n";
			else $lfields .= "<br/>\n";
			$database->setQuery( "SELECT f.name, f.title, f.type "
			. "\nFROM #__cbe_fields AS f"
			. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
			$cfield = $database->loadObjectList();
			$cfield = $cfield[0];
			if($row[0]->col3captions==1)  $oTitle =  getLangDefinition($cfield->title).": ";
			else $oTitle='';
			$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
		}
		$lfields .= "</td>\n";
	}
	if($row[0]->col4enabled) {
		$col=$row[0]->col4fields;
		$col=explode('|*|',$col);
		for ($i=0, $n=count( $col ); $i < $n; $i++) {
			if($i==0) $lfields .= "<td class='userslist_col4' valign='top'>\n";
			else $lfields .= "<br/>\n";
			if($col[$i]!='' && $col[$i]!=null) {
				$database->setQuery( "SELECT f.name, f.title, f.type "
				. "\nFROM #__cbe_fields AS f"
				. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
				$cfield = $database->loadObjectList();
				$cfield = $cfield[0];
				if($row[0]->col4captions==1)  $oTitle =  getLangDefinition($cfield->title).": ";
				else $oTitle='';
				$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
			}

		}
		$lfields .= "</td>\n";
	}
	$row=$row[0];
	HTML_cbe::usersList($row,$lfields,$lists,$listid);
}

function userSave( $option, $uid) {
	global $ueConfig,$enhanced_Config,$_REQUEST,$_POST,$mainframe;
	$database = &JFactory::getDBO();
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeGeoObj.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'astro.php');

	$user_id = intval( JArrayHelper::getValue( $_POST, 'id', 0 ));
	if ($uid == 0 || $user_id == 0 || $user_id <> $uid) {
		echo JText::_('ALERTNOTAUTH');

		//echo JText::_(ALERTNOTAUTH);
		return;
	}

	$row = new JTableUser($database);
	//$row = new JTableUser( $database );
	$row->load( $user_id );
	$row->orig_password = $row->password;


	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
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
	//mosMakeHtmlSafe($row);
	JFilterOutput::objectHTMLSafe($row);

	if(isset($_POST["password"]) && $_POST["password"] != "") {
		if(isset($_POST["verifyPass"]) && ($_POST["verifyPass"] == $_POST["password"])) {
			$row->password = md5($_POST["password"]);
		} else {
			echo "<script> alert(\""._PASS_MATCH."\"); window.history.go(-1); </script>\n";
			exit();
		}
	} else {
		// Restore 'original password'
		$row->password = $row->orig_password;
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	unset($row->orig_password); // prevent DB error!!

	if (!$row->store()) {
		echo "<script> alert('store:".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$sqlFormat = "Y-m-d";
	$selFields = '';
	$database->setQuery( "SELECT f.* FROM #__cbe_fields f, #__cbe_tabs t"
	. "\n WHERE f.published=1 and f.tabid = t.tabid AND t.enabled=1 and f.readonly=0" );
	$rowFields = $database->loadObjectList();
	for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
		if($i > 0) $selFields .=", ";
		switch($rowFields[$i]->type) {
			CASE 'date':
			CASE 'birthdate':
			 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".dateConverter(cbGetEscaped($_POST[$rowFields[$i]->name]),$ueConfig['date_format'],$sqlFormat)."' ";
			break;
			CASE 'dateselect':
			CASE 'dateselectrange':
			 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".dateConverter(cbGetEscaped($_POST[$rowFields[$i]->name."_hid"]),$ueConfig['date_format'],$sqlFormat)."' ";
			break;
			CASE 'webaddress':
			CASE 'emailaddress':
			 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".htmlspecialchars(str_replace(array('mailto:','http://','https://'),'',cbGetEscaped($_POST[$rowFields[$i]->name])))."' ";
			break;
			CASE 'editorta':
			 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".cbGetEscaped($_POST[$rowFields[$i]->name])."' ";
			break;
			case 'multiselect':
			case 'multicheckbox':
			case 'select':
			 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".htmlspecialchars(cbGetEscaped(implode("|*|",$_POST[$rowFields[$i]->name])))."' ";
			break;
			case 'numericfloat':
			 if (floatval(htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name]))) == 0) {
			 	$selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`=NULL ";
			 } else {
			 	$selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".floatval(htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name])))."' ";
			 }
			break;
			case 'numericint':
			 if (intval(htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name]))) == 0) {
			 	$selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`=NULL ";
			 } else {
			 	$selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".intval(htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name])))."' ";
			 }
			break;
			case 'geo_calc_dist':
			case 'cbe_calced_age':
			 // do nothing
			break;
			DEFAULT:
			 $selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".htmlspecialchars(cbGetEscaped($_POST[$rowFields[$i]->name]))."' ";
			break;
		}
	}
	if($selFields !='') $selFields .=", ";
	$selFields .= " `lastupdatedate`='".date('Y-m-d\TH:i:s')."', `firstname`='".cbGetEscaped($_POST['firstname'])."', `middlename`='".cbGetEscaped($_POST['middlename'])."',";
	if ($ueConfig['name_style'] == 1) {
		$selFields .= " `lastname`='".cbGetEscaped($_POST['name'])."'";
	} else {
		$selFields .= " `lastname`='".cbGetEscaped($_POST['lastname'])."'";
	}

	$sql = "UPDATE #__cbe SET ".$selFields." WHERE id='$user_id'";
	$database->setQuery( $sql );
	if (!$database->query()) {
		die("SQL error" . $database->stderr(true));
	}

	// PK edit Zodiac
	if ($enhanced_Config['show_zodiacs'] == '1' || $enhanced_Config['show_zodiacs_ch'] == '1') {
		
		$birthday_field = $enhanced_Config['lastvisitors_birthday_field'];
		$query = "SELECT ".$birthday_field." FROM #__cbe WHERE id='".$uid."'";
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
			$query_z = "UPDATE #__cbe SET zodiac='$user_zodiac' WHERE id='$uid'";
			$database->setQuery($query_z);
			if (!$database->query()) {
			//	echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			//	exit();
			}
		
			$query_zch = "UPDATE #__cbe SET zodiac_c='$user_zodiac_chinese' WHERE id='$uid'";
			$database->setQuery($query_zch);
			if (!$database->query()) {
			//	echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			//	exit();
			}
		}
	}

	$cbe_GeoObj = new moscbeGeoObj($database);
	$cbe_GeoObj->load($uid);
	if (!$cbe_GeoObj->bindme( $_POST )) {
		echo "<script> alert('".$cbe_GeoObj->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if ($cbe_GeoObj->check() == 1 || $cbe_GeoObj->check() == 3) {
		if (!$cbe_GeoObj->store($uid)) {
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

	if ($ueConfig['sendMailonProfileUpdate']=='1') {
		$emailType='ProfileUpdateMail';
		
		if($emailType!=null) {
			if($ueConfig['moderatorEmail']==1) {
				$database->setQuery( "SELECT name, email, u.id as uid FROM #__users u, #__cbe c "
				."\n WHERE u.id=c.id AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed='1' AND c.approved='1'" );
				$rowAdmins = $database->loadObjectList();
				foreach ($rowAdmins AS $rowAdmin) {
					$isModerator=isModerator($rowAdmin->uid);
					if ($isModerator==1) {
						createEmail($row,$emailType,$ueConfig,$rowAdmin);
					}
				}
			}
		}
	} //end sendOnUpdate
	// PK end

//	$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_cbe'");
//	$Itemid = $database->loadResult();
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}

	//mosRedirect ("index.php?option=com_cbe".$Itemid_c."&task=userDetails", _USER_DETAILS_SAVE);
	$mainframe->redirect ("index.php?option=com_cbe".$Itemid_c."&task=userProfile&amp;user=".$user_id, _USER_DETAILS_SAVE);
}
function mosGetConfig() {
	$configfile = "administrator/components/com_cbe/ue_config.php";
	include_once( $configfile );
	RETURN $ueConfig;
}

function lostPassForm( $option ) {
	global $Itemid, $Itemid_com;
	if ($Itemid == '' || $Itemid == '0') {
		$Itemid = $Itemid_com;
	}
	HTML_cbe::lostPassForm($option);//, $Itemid);
}

function sendNewPass( $option ) {
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	global $Itemid, $Itemid_com, $mainframe;
	global $mosConfig_sitename,$ueConfig;
	$database = &JFactory::getDBO();

	if (function_exists('josSpoofCheck')) {
		josSpoofCheck();
	}

	$_live_site = JURI::root();
	$_sitename = $mosConfig_sitename;

	if ($Itemid == '' || $Itemid == '0') {
		$Itemid = $Itemid_com;
	}

	// ensure no malicous sql gets past
	$checkusername = trim( JArrayHelper::getValue( $_POST, 'checkusername', '') );
	$checkusername = cbGetEscaped( $checkusername  );
	$confirmEmail = trim( JArrayHelper::getValue( $_POST, 'confirmEmail', '') );
	$confirmEmail = cbGetEscaped( $confirmEmail );

	if ($ueConfig['use_secimages_lostpass'] == '1') {
		$check = null;
		$userEntry = JRequest::getVar('securityImagesmy3rdpartyExtensions', false, '', 'CMD'); 
		$check = $mainframe->triggerEvent('onSecurityImagesCheck', array($userEntry));
		if ($check[0] != true) {
			$secimage_error = _UE_SECIMAGES_ERROR;
			echo "<script> alert('".$secimage_error."');</script>\n";
			lostPassForm( $option, $secimage_error );
			return;
		}
	}

	$database->setQuery( "SELECT id FROM #__users"
	. "\nWHERE username='$checkusername' AND email='$confirmEmail'"
	);

	if (!($user_id = $database->loadResult()) || !$checkusername || !$confirmEmail) {
		$mainframe->redirect( "index.php?option=$option&task=lostPassword",_ERROR_PASS );
	}

	$newpass = makePass();
	$message = _NEWPASS_MSG;
	eval ("\$message = \"$message\";");
	$subject = _NEWPASS_SUB;
	eval ("\$subject = \"$subject\";");
	$res = JUTility::sendMail($ueConfig['reg_email_from'], $ueConfig['reg_email_name'], $confirmEmail, $subject, $message);

	if ($res) {
		$newpass = md5( $newpass );
		$sql = "UPDATE #__users SET password='$newpass' WHERE id='".cbGetEscaped($user_id)."'";
		$database->setQuery( $sql );
		if (!$database->query()) {
			die("SQL error" . $database->stderr(true));
		}
		$mainframe->redirect( "index.php",_NEWPASS_SENT );
	} else {
		$mainframe->redirect( "index.php",_UE_NEWPASS_FAILED );
	}
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

function registerForm( $option, $emailpass,$regErrorMSG=null ) {
	global $mosConfig_allowUserRegistration,$_POST;
	global $mosConfig_frontend_login;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeHTML.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	//die("hier: $mosConfig_allowUserRegistration");
	if ($mosConfig_allowUserRegistration == "0" || $my->id || ($mosConfig_frontend_login != NULL && ($mosConfig_frontend_login === 0 || $mosConfig_frontend_login === '0'))) {
		echo JText::_('ALERTNOTAUTH');

		//echo JText::_(ALERTNOTAUTH);
		return;
	}

	$database->setQuery( "SELECT f.* FROM #__cbe_fields f, #__cbe_tabs t"
	. "\n WHERE t.tabid = f.tabid AND f.published=1 AND f.registration=1 AND t.enabled=1"
	. "\n ORDER BY t.ordering, f.ordering" );
	$rowFields = $database->loadObjectList();
	$rowFieldValues=array();
	for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
		$rowExtras="";
		$k="";
		if($regErrorMSG!=null && isset($_POST[$rowFields[$i]->name])) {
			if(is_array($_POST[$rowFields[$i]->name])) $k = implode("|*|",$_POST[$rowFields[$i]->name]);
			else $k=$_POST[$rowFields[$i]->name];
		}
		$database->setQuery( "SELECT fieldtitle FROM #__cbe_field_values"
		. "\n WHERE fieldid = ".$rowFields[$i]->fieldid
		. "\n ORDER BY ordering" );
		$Values = $database->loadObjectList();
		$multi="";
		$multi_o = 0;
		if($rowFields[$i]->type=='multiselect') {
			$multi="MULTIPLE";
			$multi_o = 1;
		}
		if(count($Values) > 0) {
			if($rowFields[$i]->type=='radio') $rowFieldValues['lst_'.$rowFields[$i]->name] = moscbeHTML::radioList( $Values, $rowFields[$i]->name, 'class="inputbox" size="1" mosLabel="'.getLangDefinition($rowFields[$i]->title).'"', 'fieldtitle', 'fieldtitle', $k, $rowFields[$i]->required);
			else {
				$ks=explode("|*|",$k);
				$k = array();
				foreach($ks as $kv) {
					$k[]->fieldtitle=$kv;
				}
				if($rowFields[$i]->type=='multicheckbox') $rowFieldValues['lst_'.$rowFields[$i]->name] = moscbeHTML::checkboxList( $Values, $rowFields[$i]->name."[]", 'class="inputbox" size="'.$rowFields[$i]->size.'" '.$multi.' mosLabel="'.getLangDefinition($rowFields[$i]->title).'"', 'fieldtitle', 'fieldtitle', $k,$rowFields[$i]->required);
				else $rowFieldValues['lst_'.$rowFields[$i]->name] = moscbeHTML::selectList( $Values, $rowFields[$i]->name."[]", 'class="inputbox" size="'.$rowFields[$i]->size.'" '.$multi.' mosLabel="'.getLangDefinition($rowFields[$i]->title).'"', 'fieldtitle', 'fieldtitle', $k, $rowFields[$i]->required,0,$multi_o);
			}
		}
	}


	HTML_cbe::registerForm($option, $emailpass, $rowFields, $rowFieldValues,$regErrorMSG);
}

function saveRegistration( $option ) {
	global $ueConfig,$enhanced_Config,$_POST, $mainframe;
	global $mosConfig_emailpass, $mosConfig_allowUserRegistration,$uDetails;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'astro.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if ($mosConfig_allowUserRegistration=="0" || $my->id) {
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}

	// simple spoof check security
	if (function_exists('josSpoofCheck')) {
		josSpoofCheck();
	}

	//sv0.6232 first part
	if ($ueConfig['allowAvatarUpload']=='1' && $ueConfig['allowAvatarUploadOnReg']=='1') {
		global $_FILES, $avatar, $avatar_name;
		// echo "Avatar Name: ".$avatar_name." -- Avatar FileName: ".$avatar."</br>";
		$UpAvatar = $_FILES['avatar'];
		$avatar = $_FILES['avatar']['tmp_name'];
		$abatar_name = $_FILES['avatar']['tmp_name'];
		$avatar_error = $_FILES['avatar']['error'];

		$avatar_empty = 0;
		$filename = split("\.", $avatar_name);
		$avatarName=$filename[0];
		$avatarExt=$filename[1];
		//$avatarSize=filesize($avatar);
		$isModerator=isModerator($my->id);
        	
		if (empty($avatar) || $avatar_error != 0) {
			$avatar_empty = 1;
			$avatarSize = 0;
		} else {
			$avatarSize=filesize($avatar);
		}
	}

	if ($ueConfig['use_secimages']=='1'){
		$check = null;
		$userEntry = JRequest::getVar('securityImagesmy3rdpartyExtensions', false, '', 'CMD'); 
		$check = $mainframe->triggerEvent('onSecurityImagesCheck', array($userEntry));
		if ($check[0] != true) {
			$secimage_error = _UE_SECIMAGES_ERROR;
			echo "<script> alert('".$secimage_error."');</script>\n";
			registerForm( $option, intval($ueConfig['generatepass_on_reg']),$secimage_error );
			return;
		}
        }

	// for AccountExp
	if ($ueConfig['use_acctexp']=='1') {
		include_once ("components/com_acctexp/acctexp.class.php");
		$cfg = new Config_General( $database );
		$cfg->load(1);
	}
	// for AccountExp END


	$database->setQuery("SELECT id FROM #__users WHERE email = '".cbGetEscaped( $_POST['email'] )."' AND username='0'");
	$uid = $database->loadResult();

	if($uid >0 ) {
		$_POST['id'] = $uid;
	} else {
		$uid = 0;
	}

	$ck_username	= trim( JArrayHelper::getValue( $_POST, 'username', '' ) );
	$ck_firstname 	= trim( JArrayHelper::getValue( $_POST, 'firstname', '' ) );
	$ck_middlename	= trim( JArrayHelper::getValue( $_POST, 'middlename', '' ) );
	$ck_lastname	= trim( JArrayHelper::getValue( $_POST, 'lastname', '' ) );
	
	$row = new JTableUser( $database );

	if (do_badname_check($ck_username)) {
		echo "<script> alert('"._REGWARN_INUSE."');</script>\n";
		registerForm( $option, intval($ueConfig['generatepass_on_reg']),_REGWARN_INUSE );
		return;
	}

	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."');</script>\n";
		registerForm( $option, intval($ueConfig['generatepass_on_reg']),$row->getError() );
		return;
	}

	SWITCH ($ueConfig['name_style']) {
		case 2:
		$row->name = $ck_firstname . ' ' . $ck_lastname;
		break;
		case 3:
		if(isset($ck_middlename) && !empty($ck_middlename)) {
			$row->name = $ck_firstname . ' ' . $ck_middlename. ' ' . $ck_lastname;
		}
		else $row->name = $ck_firstname. ' ' . $ck_lastname;
		break;
	}
	JFilterOutput::objectHTMLSafe($row);

	//mosMakeHtmlSafe($row);
	$pwd = '';
	//added for AccountExp integration by Michael Spredemann (scubaguy)
	if ($ueConfig['use_acctexp']=='1') {
		if($cfg->paypal || $cfg->transfer) {
			$row->block = "1"; // Force blocked.
		}
	}
	// End Added for AccountExp

	//sv0.6232 user to be aproved set to block in #__users
	if ($ueConfig['reg_admin_approval']=="0" && $ueConfig['use_acctexp']!='1') {
		$row->block = "0";
	} else if ($ueConfig['reg_admin_approval']=="1" && $ueConfig['use_acctexp']!='1'){
		$row->block = "1";
	}

	$row->gid = $acl->get_group_id('Registered','ARO');
	// save usertype to usetype column
	$query = "SELECT name"
	. "\n FROM #__core_acl_aro_groups"
	. "\n WHERE id = $row->gid"
	;
	$database->setQuery( $query );
	$usertype = $database->loadResult();
	$row->usertype = $usertype;

	if (!$row->password) {
		$pwd = makePass();
		$row->password = md5( $pwd );
		$includePWD=1;
	} else {
		$pwd = $row->password;
		$row->password = md5( $row->password );
		if ($ueConfig['emailpass_on_reg'] == "1") {
			$includePWD = 1;
		} else {
			$includePWD=0;
		}
	}

	$row->registerDate = date("Y-m-d H:i:s");

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."');</script>\n";
		registerForm( $option, intval($ueConfig['generatepass_on_reg']),$row->getError() );
		return;
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); </script>\n";
		registerForm( $option, intval($ueConfig['generatepass_on_reg']),$row->getError() );
		return;
	}
	$sqlFormat = "Y-m-d";
	$selFields = '';
	$database->setQuery( "SELECT f.* FROM #__cbe_fields f, #__cbe_tabs t"
	. "\n WHERE f.published=1 and f.tabid = t.tabid and f.registration=1 and t.enabled=1" );
	$rowFields = $database->loadObjectList();

	$database->setQuery("SELECT id FROM #__users WHERE username = '".cbGetEscaped( $_POST['username'] )."'");
	$uid = $database->loadResult();
	$sqlType = 'I';

	if ($ueConfig['reg_admin_approval']=="0") {
		$approved="1";
	} else {
		$approved="0";
	}
	if ($ueConfig['reg_confirmation']=="0") {
		$confirmed="1";
	} else {
		$confirmed="0";
	}
	if(ISSET($_POST['acceptedterms'])) {
		$acceptedterms=cbGetEscaped($_POST['acceptedterms']);
		$acceptedterms_date = date('Y-m-d\TH:i:s');
	} else {
		$acceptedterms=null;
		$acceptedterms_date = null;
	}

	if(ISSET($_POST['accepteddatasec'])) {
		$accepteddatasec=cbGetEscaped($_POST['accepteddatasec']);
		$accepteddatasec_date = date('Y-m-d\TH:i:s');
	} else {
		$accepteddatasec=null;
		$accepteddatasec_date = null;
	}

	//sv0.6232 part two
	$new_avatar = NULL;
	$avatarapproved = '1';
	if ($ueConfig['allowAvatarUpload']=='1' && $ueConfig['allowAvatarUploadOnReg']=='1' && $avatar_empty=='0') {
		$imgToolBox = new imgToolBox();
		$imgToolBox->_conversiontype=$ueConfig['conversiontype'];
		$imgToolBox->_IM_path = $ueConfig['im_path'];
		$imgToolBox->_NETPBM_path = $ueConfig['netpbm_path'];
		$imgToolBox->_maxsize = $ueConfig['avatarSize'];
		$imgToolBox->_maxwidth = $ueConfig['avatarWidth'];
		$imgToolBox->_maxheight = $ueConfig['avatarHeight'];
		$imgToolBox->_thumbwidth = $ueConfig['thumbWidth'];
		$imgToolBox->_thumbheight = $ueConfig['thumbHeight'];
		$imgToolBox->_debug = 0;
		//	sv0.6233 / 0.6234
		$imgToolBox->_wm2_force_png	= $ueConfig['wm_force_png'];
		$imgToolBox->_wm2_force_zoom 	= $ueConfig['wm_force_zoom'];
		$imgToolBox->_wm2_canvas_col 	= $ueConfig['wm_canvas_color'];
		$imgToolBox->_wm2_canvas_coltr 	= $ueConfig['wm_canvas_trans'];
		$imgToolBox->_wm2_canvas 	= $ueConfig['wm_canvas'];
		$imgToolBox->_wm2_stampit 	= $ueConfig['wm_stampit'];
		$imgToolBox->_wm2_stampit_txt 	= $ueConfig['wm_stampit_text'];
		$imgToolBox->_wm2_stampit_size 	= $ueConfig['wm_stampit_size'];
		if ($ueConfig['wm_stampit_text']=='' ||$ueConfig['wm_stampit_text']==null) {
			$imgToolBox->_wm2_stampit_txt = substr_replace(JURI::root(), '', -1, 1)."/".$my->username;
		}
		if (!($ueConfig['wm_stampit_color']=='' || $ueConfig['wm_stampit_color']==null || strlen(trim($ueConfig['wm_stampit_color']))!=6)) {
			$red = hexdec(substr($ueConfig['wm_stampit_color'],0,2));
			$yellow = hexdec(substr($ueConfig['wm_stampit_color'],2,2));
			$green = hexdec(substr($ueConfig['wm_stampit_color'],4,2));
			
			$imgToolBox->_wm2_stampit_cred = $red;
			$imgToolBox->_wm2_stampit_cyellow = $yellow;
			$imgToolBox->_wm2_stampit_cgreen = $green;
		}
		$imgToolBox->_wm2_doit = $ueConfig['wm_doit'];
		$imgToolBox->_wm2_img = $ueConfig['wm_filename'];
		//

		if(!($newFileName=$imgToolBox->processImage($_FILES['avatar'], $uid,JPATH_SITE.'/images/cbe/', 0, 0, 1))) {
			$newFileName = NULL;
		}

		if ($newFileName != NULL) {
			If($ueConfig['avatarUploadApproval']==1 && $isModerator==0) {
				$database->setQuery( "SELECT name, email FROM #__users u, #__cbe c WHERE u.id=c.id"
				."\n AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed='1' AND c.approved='1'" );
				$rowAdmins = $database->loadObjectList();
				foreach ($rowAdmins AS $rowAdmin) {
					$isModerator=isModerator($rowAdmin->uid);
					if ($isModerator==1) {
						createEmail($row,'imageAdmin',$ueConfig,$rowAdmin);
					}
				}
				$avatarapproved = '0';
			} else {
				$avatarapproved = '1';
			}
		}
		$new_avatar = $newFileName;
	}

	$colList = "id, user_id, avatar, avatarapproved, approved, confirmed, acceptedterms, last_terms_date, accepteddatasec, last_datasec_date, firstname, middlename, lastname";
	$valueList = "'$uid','$uid',";
	if ($new_avatar != NULL) {
		$valueList .= "'$new_avatar'";
	} else {
		$valueList .= "NULL";
	}
	$valueList .= ",'$avatarapproved','$approved','$confirmed','$acceptedterms','$acceptedterms_date','$accepteddatasec','$accepteddatasec_date','".cbGetEscaped($_POST['firstname'])."','".cbGetEscaped($_POST['middlename'])."','";
	if ($ueConfig['name_style'] == 1) {
		$valueList .= cbGetEscaped($_POST['name'])."'";
	} else {
		$valueList .= cbGetEscaped($_POST['lastname'])."'";
	}
	for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
		if($i > 0) $selFields .=", ";

		switch($rowFields[$i]->type) {
			CASE 'date':
			CASE 'birthdate':
			 $colList .= ", `".cbGetEscaped($rowFields[$i]->name)."`";
			 $valueList .= ", '".dateConverter(cbGetEscaped($_POST[$rowFields[$i]->name]),$ueConfig['date_format'],$sqlFormat)."'";
			break;
			CASE 'dateselect':
			CASE 'dateselectrange':
			 //$selFields .= "`".cbGetEscaped($rowFields[$i]->name)."`='".dateConverter(cbGetEscaped($_POST[$rowFields[$i]->name."_hid"]),$ueConfig['date_format'],$sqlFormat)."' ";
			 $colList .= ", `".cbGetEscaped($rowFields[$i]->name)."`";
			 $valueList .= ", '".dateConverter(cbGetEscaped($_POST[$rowFields[$i]->name."_hid"]),$ueConfig['date_format'],$sqlFormat)."'";
			break;
			CASE 'webaddress':
			CASE 'emailaddress':
			 $colList .= ", `".cbGetEscaped($rowFields[$i]->name)."`";
			 $valueList .= ", '".str_replace(array('mailto:','http://','https://'),'',cbGetEscaped($_POST[$rowFields[$i]->name]))."'";
			break;
			case 'multiselect':
			case 'multicheckbox':
			case 'select':
			if ($_POST[$rowFields[$i]->name] != '' || $_POST[$rowFields[$i]->name] != null) {
				$colList .= ", `".cbGetEscaped($rowFields[$i]->name)."`";
				$valueList .= ", '".htmlspecialchars(cbGetEscaped(implode("|*|",$_POST[$rowFields[$i]->name])))."' ";
			}
			break;
			DEFAULT:
			 $colList .= ", `".cbGetEscaped($rowFields[$i]->name)."`";
			 $valueList .= ", '".cbGetEscaped($_POST[$rowFields[$i]->name])."'";
			break;
		}
	}
	$sql = "INSERT INTO #__cbe (".$colList.") VALUES (".$valueList.")";
	$database->setQuery( $sql );
	//print $database->getQuery();
	if (!$database->query()) {
//		echo "<script> alert('"."SQL error" . $database->stderr(true)."'); </script>\n";
		echo "<script> alert('"._REGWARN_INUSE."'); </script>\n";
//		registerForm( $option, $mosConfig_emailpass,"SQL error" . $database->stderr(true) );
		registerForm( $option, intval($ueConfig['generatepass_on_reg']), _REGWARN_INUSE );
		return;
	}
	$row->checkin();
	if($includePWD == 1) $row->password =$pwd ;
	else $mosConfig_emailpass=0;

	if($confirmed==0) {
		createEmail($row,'pending',$ueConfig,null,$includePWD);
		$emailType=null;
	} elseif($approved==0 && $confirmed==1) {
		createEmail($row,'pending',$ueConfig,null,$includePWD);
		$emailType='pendingAdmin';
	} else {
		createEmail($row,'welcome',$ueConfig,null,$includePWD);
		$emailType='welcomeAdmin';
	}
	if($emailType!=null) {
		if($ueConfig['moderatorEmail']==1) {
			$database->setQuery( "SELECT name, email, u.id as uid FROM #__users u, #__cbe c "
			."\n WHERE u.id=c.id AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed='1' AND c.approved='1'" );
			$rowAdmins = $database->loadObjectList();
			foreach ($rowAdmins AS $rowAdmin) {
				$isModerator=isModerator($rowAdmin->uid);
				if ($isModerator==1) {
					createEmail($row,$emailType,$ueConfig,$rowAdmin);
				}
			}
		}
	}

	//added for AccountExp integration by phil_k
	if ($ueConfig['use_acctexp']=='1') {
		$name = $row->name;
		$email = $row->email;
		$username = $row->username;
		$userid = $row->id;
		$registerDate = $row->registerDate; // For use on expiration date

// old 0.3.1		
//		if(!$cfg->paypal) {
//			// Set default expiration unless PayPal processed
//			$database->setQuery( "INSERT INTO #__acctexp SET userid=$userid, expiration=DATE_ADD('$registerDate', INTERVAL $cfg->initialexp DAY)" );
//			$database->query();
//		}
//		if($cfg->paypal || $cfg->transfer) {
//			payForm($option, $userid, $username, $name);
//		}

		// 0.8.x Update Subscription table
		$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
		$database->setQuery( $query );
		$id = $database->loadResult();
		$db = new mosSubscription($database);
		// Test if new
		if(!$id) {
			$db->load(0);
		} else {
			$db->load($id);
		}
		$db->userid		= $userid;
		$db->status		= 'Pending';
		$db->signup_date	= date( 'Y-m-d H:i:s' );
		$db->check();
		$db->store();
		// ..PlanB since 0.8.0b
		if (function_exists('selectSubscriptionPlanB')) {
			selectSubscriptionPlanB($option, $userid, $username, $name, $intro=0);
		} else if (function_exists('selectSubscriptionPlan')) {
			selectSubscriptionPlan($option, $userid, $username, $name);
		}

	} else {
	// AcctExp temp-end
		if ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="0"){
			echo _UE_REG_COMPLETE_NOPASS_NOAPPR;
		} elseif ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="1") {
			echo _UE_REG_COMPLETE_NOPASS_NOAPPR_CONF;
		} elseif ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="0" && $ueConfig['reg_confirmation']=="0") {
			echo _UE_REG_COMPLETE_NOPASS;
		} elseif ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="0" && $ueConfig['reg_confirmation']=="1") {
			echo _UE_REG_COMPLETE_NOPASS_CONF;
		} elseif ($mosConfig_emailpass == "0" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="0") {
			echo _UE_REG_COMPLETE_NOAPPR;
		} elseif ($mosConfig_emailpass == "0" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="1") {
			echo _UE_REG_COMPLETE_NOAPPR_CONF;
		} elseif ($mosConfig_emailpass == "0" && $ueConfig['reg_admin_approval']=="0" && $ueConfig['reg_confirmation']=="1") {
			echo _UE_REG_COMPLETE_CONF;
		} else {
			echo _UE_REG_COMPLETE;
		}
	}
	// AccountExp END. 
	
	// PK edit Zodiac
	$birthday_field = $enhanced_Config['lastvisitors_birthday_field'];
	$query = "SELECT ".$birthday_field." FROM #__cbe WHERE id='".$uid."'";
	$database->setQuery($query);
	$birthday = $database->loadResult();
	
	if($birthday =="0000-00-00")
	{
		$user_zodiac = _UE_ZODIAC_NO;
		$user_zodiac_chinese = _UE_ZODIAC_NO;
	} else {
		$person = new astro($birthday);
		$user_zodiac = $person->chaldeanSign;
		$user_zodiac_chinese = $person->chineseSign;
	}
	$query_z = "UPDATE #__cbe SET zodiac='$user_zodiac', zodiac_c='$user_zodiac_chinese' WHERE id='$uid'";
	$database->setQuery($query_z);
	if (!$database->query()) {
	//	echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	//	exit();
	}
	$user_log_ip = $_SERVER['REMOTE_ADDR'];
	$database->setQuery("UPDATE #__cbe SET last_ip='".$user_log_ip."' WHERE id='".$uid."'");
	if (!$database->query()) {
	//	echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	//	exit();
	}
	// PK end

	//sv0.6232 newsletter
	if ($ueConfig['use_fqmulticorreos']=='1') {
		require_once (JPATH_SITE . '/components/com_fq/codehacks/reg_integration.php');
		savefqRegistration();
	}
	if ($ueConfig['use_yanc']=='1') {
		$_POST['name']= $_POST['username'];
		require_once (JPATH_SITE . '/components/com_yanc/codehacks/reg_integration.php');
		saveYancRegistration();
	}
}


function login( $username=null,$passwd=null ) {
	global $_COOKIE,$_POST,$_SESSION,$mainframe, $ueConfig, $mosConfig_lang;
	global $mosConfig_frontend_login, $version;

	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if ( $mosConfig_frontend_login != NULL && ($mosConfig_frontend_login === 0 || $mosConfig_frontend_login === '0')) {
		header( "HTTP/1.0 403 Forbidden" );
		echo _NOT_AUTH;
		return;
	}
	
	$usercookie = JArrayHelper::getValue( $_COOKIE, 'usercookie', '' );
	$sessioncookie = JArrayHelper::getValue( $_COOKIE, 'sessioncookie', '' );
	if (!$username || !$passwd) {
		$username = trim( JArrayHelper::getValue( $_POST, 'username', '' ) );
		$passwd2 = trim( JArrayHelper::getValue( $_POST, 'passwd', '' ) );
		$passwd = md5( $passwd2 );
	}
	//$credentials = array("username"=>$username, "password"=>$passwd);
	$credentials = array("username"=>$username, "password"=>$passwd2);
	$return = trim( JArrayHelper::getValue( $_POST, 'return', '' ) );
	$remember = trim( JArrayHelper::getValue( $_POST, 'remember', '' ) );
	//derelvis: Remember Hack
	$remember = array("remember"=>$remember);
	$message = trim( JArrayHelper::getValue( $_POST, 'message', '' ) );
	$lang = trim( JArrayHelper::getValue( $_POST, 'lang', '' ) );

// SecImages integration
	if ($ueConfig['use_secimages_login']=='1') {
		if (file_exists(JPATH_SITE.'/administrator/components/com_securityimages/patches/joomla.login.php')) {
			include_once(JPATH_SITE.'/administrator/components/com_securityimages/patches/joomla.login.php');
		}
	}
// SecImages end

	if (!$username || !$passwd) {
		echo "<script> alert(\""._LOGIN_INCOMPLETE."\"); window.history.go(-1); </script>\n";
		exit();
	} else {
		$database->setQuery( "SELECT u.id, u.gid, u.block, u.usertype, u.email, u.username, u.name, u.lastvisitDate, ue.approved, ue.confirmed"
		. "\nFROM #__users u, "
		. "\n#__cbe ue"
		. "\nWHERE u.username='".cbGetEscaped($username)."' AND u.password='".$passwd."' AND u.id = ue.id"
		);
		$row = null;
		
		$row = $database->loadObject();
		
		if (empty($row->password)) {
			$database->setQuery( "SELECT u.id, u.gid, u.block, u.usertype, u.email, u.username, u.password, u.name, u.lastvisitDate, ue.approved, ue.confirmed"
			. "\nFROM #__users u, "
			. "\n#__cbe ue"
			. "\nWHERE u.username='".cbGetEscaped($username)."' AND u.id = ue.id"
			);
			$row = null;
			$row = $database->loadObject();
		
			list($hash, $salt) = explode(':', $row->password);
			$check_password = md5($passwd2.$salt);
			if ($hash != $check_password) {
				$row = null;
			}
		}
		
		// if ($database->loadObject( $row )) {
		if (!empty($row->username)) {
			if ($row->block == 1 && $row->approved == 1 && $row->confirmed == 1) {
				echo "<script>alert(\""._LOGIN_BLOCKED."\"); window.history.go(-1); </script>\n";
				exit();
			}
			else if ($row->approved == 2){
				echo "<script>alert(\""._LOGIN_REJECTED."\"); window.history.go(-1); </script>\n";
				exit();
			}
			else if ($row->approved == 0){
				echo "<script>alert(\""._LOGIN_NOT_APPROVED."\"); window.history.go(-1); </script>\n";
				exit();
			}
			else if ($row->confirmed != 1){
				createEmail($row,'pending',$ueConfig,null,0);
				echo "<script>alert(\""._LOGIN_NOT_CONFIRMED."\"); window.history.go(-1); </script>\n";
				exit();
			}
			else if ($row->lastvisitDate == '0000-00-00 00:00:00') {
				if (isset($ueConfig['reg_first_visit_url']) and ($ueConfig['reg_first_visit_url'] != "")) {
					$return = JRoute::_($ueConfig['reg_first_visit_url']);
				}
			}
// PK edit IP loging
			$user_log_ip = $_SERVER['REMOTE_ADDR'];
			
			$database->setQuery("UPDATE #__cbe SET last_ip='".$user_log_ip."' WHERE id='".$row->id."'");
			if (!$database->query()) {
			        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			        exit();
			}
//PK edit end
			$database->setQuery("SELECT * FROM #__cbe_userstime WHERE userid='".$row->id."'");
			$users_time = $database->loadObject();
			if (!$users_time) {
				$u_time = time();
				$database->setQuery("INSERT INTO #__cbe_userstime (id, userid, logcount, logtime) VALUES ('max(id)+1', '".$row->id."', '1', '".$u_time."')");
				if (!$database->query()) {
					echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
					exit();
				}
			} else {
				$u_time = time();
				$sum_count = $users_time->logcount + 1;
				$database->setQuery("UPDATE #__cbe_userstime SET logcount='".$sum_count."', logtime='".$u_time."' WHERE id='".$users_time->id."' AND userid='".$row->id."'");
				$database->query();
			}
			

		} else {
			$mainframe->redirect($return, _LOGIN_INCORRECT);
		}

// AcctExp 0.8x integration
		if ($ueConfig['use_acctexp']=='1') {
			if (file_exists( JPATH_SITE . "/administrator/components/com_acctexp/includes/login.validate.php")) {
				include_once( JPATH_SITE . "/administrator/components/com_acctexp/includes/login.validate.php" );
				loginValidate($username);
			} else {
				loginValidate_acct_cbe($username);
			}
		}


// SMF coex patch
		if ($ueConfig['use_smfBridge'] == '1') {
			if(file_exists(JPATH_SITE.'/administrator/components/com_smf/config.smf.php')) {
				//if the config file is their we can assume the bridge is installed
				require_once (JPATH_SITE.'/administrator/components/com_smf/config.smf.php');
				require_once (JPATH_SITE.'/administrator/components/com_smf/functions.smf.php');
                	
				$_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION['_FROM_MOS'] = true;

				doMamboSMF(true);
			} // SMF 1.x end
			else
			{ // SMF 2.x start
				require_once(JPATH_SITE.'/components/com_smf/smf.class.php');
				if (file_exists(JPATH_SITE.'/administrator/components/com_smf/language/'.$mosConfig_lang.'.php')) {
				    require_once(JPATH_SITE.'/administrator/components/com_smf/language/'.$mosConfig_lang.'.php');
				} else {
				    require_once(JPATH_SITE.'/administrator/components/com_smf/language/english.php');
				}
				
				$jsmfConfig = jsmfFrontend::loadParams();
				jsmfFrontend::saveVars($savedVars);
				require_once($jsmfConfig->smf_path."/SSI.php");
				$jsmf =& jsmfFrontend::singleton();
				$jsmf->restoreVars($savedVars);
				
				$_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION['_FROM_MOS'] = TRUE;
				$_SESSION['_RETURN'] = $return;

				$jsmf->doLogin(true);

			} // SMF 2.x stop
		}


		if ($ueConfig['cbedologin']=='1' || $ueConfig['use_smfBridge'] == '1') {

				//print_r($credentials);

				//$mainframe->login($credentials);
				//derelvis: Remember Hack
				$mainframe->login($credentials,$remember);
				//JApplication::login();
				// JS Popup message
				if ( $message ) {
					$js_message = "<script type=\"text/javascript\"> \n";
					$js_message .= "<!--// \n";
					$js_message .= "alert(\""._LOGIN_SUCCESS."\");  \n";
					$js_message .= "//--> \n";
					$js_message .= "</script> \n";
					echo $js_message;
				}

				$chk_jv_pro = $version->PRODUCT;
				$chk_jv_rel = $version->RELEASE;
				$chk_jv_dev = intval($version->DEV_LEVEL);
        				if (($chk_jv_pro == "Joomla" && $chk_jv_rel == "1.0" && $chk_jv_dev <= 11) || $chk_jv_pro != "Joomla") {
					if ( $return && !( strpos( $return, 'com_registration' ) || strpos( $return, 'com_login' ) ) ) {
					// checks for the presence of a return url 
					// and ensures that this url is not the registration or login pages
						$mainframe->redirect($return);
						//$mainframe->redirect( $return );
					} else {
						$mainframe->redirect($substr_replace(JURI::root(), '', -1, 1) .'/index.php' );
						//$mainframe->redirect( $substr_replace(JURI::root(), '', -1, 1) .'/index.php' );
					}

                                    } else {
					if ( $return && !( strpos( $return, 'com_registration' ) || strpos( $return, 'com_login' ) ) ) {
					// checks for the presence of a return url
					// and ensures that this url is not the registration or login pages
						// If a sessioncookie exists, redirect to the given page. Otherwise, take an extra round for a cookiecheck
						if (isset( $_COOKIE[mosMainFrame::sessionCookieName()] )) {
							$mainframe->redirect( $return );
						} else {
							$mainframe->redirect( JURI::root().'index.php?option=cookiecheck&return=' . urlencode( $return ) );
						}
					} else {
						// If a sessioncookie exists, redirect to the start page. Otherwise, take an extra round for a cookiecheck
						if (isset( $_COOKIE[mosMainFrame::sessionCookieName()] )) {
							$mainframe->redirect( JURI::root().'index.php' );
						} else {
							$mainframe->redirect(JURI::root().'index.php?option=cookiecheck&return=' . urlencode(JURI::root().'index.php' ) );
						}
					}
				}


		} else {
			//die("mähh");

			if (function_exists('josSpoofValue')) {
				$validate = josSpoofValue(1);
			}
			//echo "<div style='visibility:hidden;'><form action='".JRoute::_("index.php")."' method='post' name='login2' id='login2'>\n";
			echo "<div style='visibility:hidden;'><form action='".JRoute::_("index.php")."' method='post' name='login2' id='login2'>\n";

			echo '<input type="hidden" name="username" value="'.$username.'" />\n';
			echo '<input type="hidden" name="passwd" value="'.$passwd2.'" />\n';
			echo '<input type="hidden" name="option" value="login" />\n';
			echo '<input type="hidden" name="op2" value="login" />\n';
			echo '<input type="hidden" name="lang" value="'.$lang.'" />\n';
			echo '<input type="hidden" name="return" value="'.$return.'" />\n';
			echo '<input type="hidden" name="message" value="'.$message.'" />\n';
			echo '<input type="hidden" name="remember" value="'.$remember.'" />\n';
			if (function_exists('josSpoofValue')) {
				echo '<input type="hidden" name="force_session" value="1" />'." \n";
				echo '<input type="hidden" name="'.$validate.'" value="1" /> \n';
			}
			echo '<input type="submit" name="btnsubmit" />\n';
			echo "</form></div>\n";
	
			echo "<script> document.login2.submit(); </script>\n";
		}

	}
}

function logout() {
	global $_POST, $mainframe;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();
	
	$return	 = trim(JArrayHelper::getValue( $_POST, 'return', NULL ));
	$message = trim(JArrayHelper::getValue( $_POST, 'message', 0 ));

	$database->setQuery("SELECT * FROM #__cbe_userstime WHERE userid='".$my->id."'");
	$database->loadObject($users_time);
	if ($database->query()) {
		$u_time = time();
		$diff_time = $u_time - $users_time->logtime;
		$sum_time = $users_time->logtimesum + $diff_time;
		$database->setQuery("UPDATE #__cbe_userstime SET logtime='".$u_time."', logtimesum='".$sum_time."' WHERE id='".$users_time->id."' AND userid='".$my->id."'");
		$database->query();
	}

	
	$mainframe->logout();

	// JS Popup message
	if ( $message ) {
		$js_message = '<script language="javascript" type="text/javascript">'." \n";
		$js_message .= '<!--//'." \n";
		$js_message .= 'alert( "'._LOGOUT_SUCCESS.'" );'." \n";
		$js_message .= '//-->'." \n";
		$js_message .= '</script>'." \n";
		echo $js_message;
		//ob_flush();
	}

	if ( $return ) {
	// checks for the presence of a return url 
	// and ensures that this url is not the registration or logout pages
		$mainframe->redirect( JRoute::_($return) );
	} else {
		$mainframe->redirect( JRoute::_($substr_replace(JURI::root(), '', -1, 1).'/index.php') );
	}


}

function confirm($confirmCode){
	global $ueConfig;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if($my->id < 1) {

		$conf_hash = floatval($ueConfig['reg_confirmation_hash']);
		$query = "SELECT * FROM #__cbe c, #__users u WHERE c.id=u.id AND confirmed=0 AND md5(c.id+".$conf_hash.") = '" . cbGetEscaped($confirmCode) . "'";
		$database->setQuery($query);
		$user = $database->loadObjectList();

		$query = "UPDATE #__cbe SET confirmed = 1 WHERE confirmed=0 AND md5(id+".$conf_hash.") = '" . cbGetEscaped($confirmCode) . "'";
		$database->setQuery($query);
		$database->query();

		if(mysql_affected_rows() == 0) {
			if ($user == null) {
				echo _UE_USER_NOTCONFIRMED . "<br>";
			} else {
				if ($user[0]->approved == 0) echo _UE_USER_CONFIRMED_NEEDAPPR . "<br>";
				else echo _UE_USER_CONFIRMED . "<br>";
			}
		} else {
			if($user[0]->approved == 0) {
				if($ueConfig['moderatorEmail']==1) {
					$database->setQuery( "SELECT name, username, email, id FROM #__users"
					."\n WHERE gid >='".$ueConfig['imageApproverGid']."' AND block=0 AND sendEmail='1'" );
					$rowAdmins = $database->loadObjectList();
					foreach ($rowAdmins AS $rowAdmin) {
						$isModerator=isModerator($rowAdmin->id);
						if ($isModerator==1) {
							createEmail($user[0],'pendingAdmin',$ueConfig,$rowAdmin);
						}
					}
				}
				echo _UE_USER_CONFIRMED_NEEDAPPR . "<br>";

			} else {
				if($ueConfig['moderatorEmail']==1) {
					$database->setQuery( "SELECT name, username, email, id FROM #__users"
					."\n WHERE gid >='".$ueConfig['imageApproverGid']."' AND block=0 AND sendEmail='1'" );
					$rowAdmins = $database->loadObjectList();
					foreach ($rowAdmins AS $rowAdmin) {
						$isModerator=isModerator($rowAdmin->id);
						if ($isModerator==1) {
							createEmail($user[0],'welcomeAdmin',$ueConfig,$rowAdmin);
						}
					}
				}
				createEmail($user[0],'welcome',$ueConfig);
				echo _UE_USER_CONFIRMED . "<br>";
			}
		}


	} else {
//		$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_cbe'");
//		$Itemid = $database->loadResult();
		if (!isset($_REQUEST['Itemid'])) {
			if ($GLOBALS['Itemid_com']!='') {
				$Itemid_c = $GLOBALS['Itemid_com'];
			} else {
				$Itemid_c = '';
			}
		} else {
			$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
		}

		$mainframe->redirect(JRoute::_('index.php?option=com_cbe'.$Itemid_c));
	}

}


function approveImage(){
	global $_POST,$_REQUEST,$ueConfig, $mainframe;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	$avatars=array();
	if(isset($_POST['avatar'])) $avatars=$_POST['avatar'];
	else $avatars[] = $_REQUEST['avatars'];
	if(isset($_POST['act'])) $act=$_POST['act'];
	else $act = $_REQUEST['flag'];
	if($act=='1') {
		foreach ($avatars AS $avatar) {
			$query = "UPDATE #__cbe SET avatarapproved = 1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id = '" . cbGetEscaped($avatar) . "'";
			$database->setQuery($query);
			$database->query();
			echo $database->getquery();
			$database->setQuery( "SELECT name, email FROM #__users"
			."\n WHERE id='$avatar'" );
			$rows = $database->loadObjectList();
			echo $database->getquery();
			foreach ($rows AS $row) {
				createEmail($row,'imageApproved',$ueConfig);
			}
		}
	} else {
		foreach ($avatars AS $avatar) {
			$query = "SELECT avatar FROM #__cbe WHERE id = '" . $avatar . "'";
			$database->setQuery($query);
			$file = $database->loadResult();
			if(eregi("gallery/",$file)==false && is_file(JPATH_SITE."/images/cbe/".$file)) {
				unlink(JPATH_SITE."/images/cbe/".$file);
				if(is_file(JPATH_SITE."/images/cbe/tn".$file)) unlink(JPATH_SITE."/images/cbe/tn".$file);
			}
			$query = "UPDATE #__cbe SET avatarapproved = 1, avatar=null WHERE id = '" . cbGetEscaped($avatar) . "'";
			$database->setQuery($query);
			$database->query();
			$database->setQuery( "SELECT name, email FROM #__users"
			."\n WHERE id='$avatar'" );
			$rows = $database->loadObjectList();
			foreach ($rows AS $row) {
				createEmail($row,'imageRejected',$ueConfig);
			}
		}

	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
	}
	$mainframe->redirect('index.php?option=com_cbe'.$Itemid_c.'&task=moderateImages',_UE_USERIMAGEMODERATED_SUCCESSFUL);
}

function isModerator($oID){
	global $ueConfig;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$gid = userGID($oID);
	if (!allowAccess( $ueConfig['imageApproverGid'],'RECURSE', userGID($oID), $acl, '1'))
	{
		return 0;
	} else {
		return 1;
	}

//	if($gid >= $ueConfig['imageApproverGid']) return 1;
//	else return 0;
}

function userGID($oID){
	global $ueConfig;
	$database = &JFactory::getDBO();

	if($oID > 0) {
		$query = "SELECT gid FROM #__users WHERE id = '".$oID."'";
		$database->setQuery($query);
		$gid = $database->loadResult();
		return $gid;
	}
	else return 0;
}

function reportUser($option,$form=1,$uid=0) {
	global $ueConfig,$_POST;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeUserReport.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if($ueConfig['allowUserReports']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		exit();
	}
	if($form==1) {
		HTML_cbe::reportUserForm($option,$uid);
	} else {
		$row = new moscbeUserReport( $database );

		if (!$row->bind( $_POST )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		JFilterOutput::objectHTMLSafe($row);

		//mosMakeHtmlSafe($row);

		$row->reportedondate = date("Y-m-d\TH:i:s");

		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		if($ueConfig['moderatorEmail']==1) {
			$rep_user = '';
			$database->setQuery( "SELECT u.*, c.* FROM #__users as u, #__cbe as c"
			."\n WHERE u.id='".$row->reporteduser."' AND u.id=c.id" );
			$database->loadObject($rep_user);

			$database->setQuery( "SELECT name, email, u.id as uid FROM #__users u, #__cbe c "
			."\n WHERE u.id=c.id AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed='1' AND c.approved='1'" );
			$rowAdmins = $database->loadObjectList();
			foreach ($rowAdmins AS $rowAdmin) {
				$isModerator=isModerator($rowAdmin->uid);
				if ($isModerator==1) {
					createEmail($rep_user,'reportAdmin',$ueConfig,$rowAdmin);
				}
			}
		}
		echo _UE_USERREPORT_SUCCESSFUL;
	}
}

function banUser($option,$uid,$form=1,$act=1,$doUnblock=0) {
	global $ueConfig,$_POST;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();
	
	$doBlockBanUser = JArrayHelper::getValue($_POST, 'doBlockBanUser', '');
	$isModerator=isModerator($my->id);
	if($ueConfig['allowUserBanning']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		exit();
	}
	if($form==1) {
		$database->setquery("SELECT bannedreason FROM #__cbe WHERE id = '$uid'");
		$orgbannedreason=$database->loadresult();
		HTML_cbe::banUserForm($option,$uid,$act,$orgbannedreason);
	} else {
		if($act==1) {
			if ($isModerator!=1){
				//echo JText::_(ALERTNOTAUTH);
				echo JText::_('ALERTNOTAUTH');

				return;
			}
			
			$sql="UPDATE #__cbe SET banned='1', bannedby='".cbGetEscaped($_POST['bannedby'])."', banneddate='".date('Y-m-d\TH:i:s')."', bannedreason='<b>".cbGetEscaped(htmlspecialchars("["._UE_MODERATORBANRESPONSE."]"))."</b>\n".cbGetEscaped($_POST['bannedreason'])."' WHERE id='$uid'";
			$database->SetQuery($sql);
			$database->query();
			
			if ($doBlockBanUser == 'doBlock') {
				$sql="UPDATE #__users SET block='1' WHERE id='$uid'";
				$database->SetQuery($sql);
				$database->query();
			}
			$database->setQuery( "SELECT u.name, u.email, u.block, c.bannedreason as reason FROM #__users as u, #__cbe as c"
			."\n WHERE u.id='$uid' AND u.id=c.id" );
			$rows = $database->loadObjectList();
			foreach ($rows AS $row) {
				$row->reason = strip_tags($row->reason);
				createEmail($row,'banUser',$ueConfig);
			}
			echo _UE_USERBAN_SUCCESSFUL;
		} elseif($act==0) {
			if ($isModerator!=1){
				//echo JText::_(ALERTNOTAUTH);
				echo JText::_('ALERTNOTAUTH');

				return;
			}
			$sql="UPDATE #__cbe SET banned='0', bannedby=null, banneddate=null, bannedreason=null WHERE id='".cbGetEscaped($uid)."'";
			$database->SetQuery($sql);
			$database->query();

			if ($doUnblock == 1) {
				$sql="UPDATE #__users SET block='0' WHERE id='".cbGetEscaped($uid)."'";
				$database->SetQuery($sql);
				$database->query();
			}
			$database->setQuery( "SELECT name, email FROM #__users"
			."\n WHERE id='$uid'" );
			$rows = $database->loadObjectList();
			foreach ($rows AS $row) {
				createEmail($row,'unbanUser',$ueConfig);
			}

			echo _UE_USERUNBAN_SUCCESSFUL;
		}elseif($act==2) {
			if ($my->id!=$uid){
				//echo JText::_(ALERTNOTAUTH);
				echo JText::_('ALERTNOTAUTH');

				return;
			}
			$bannedreason = "<b>".htmlspecialchars("["._UE_USERBANRESPONSE."]")."</b>\n".$_POST['bannedreason']."\n".$_POST['orgbannedreason'];
			$sql="UPDATE #__cbe SET banned='2', bannedreason='".cbGetEscaped($bannedreason)."' WHERE id='".cbGetEscaped($uid)."'";
			$database->SetQuery($sql);
			$database->query();
			if($ueConfig['moderatorEmail']==1) {
				$database->setQuery( "SELECT name, email, u.id as uid FROM #__users u, #__cbe c "
				."\n WHERE u.id=c.id AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed='1' AND c.approved='1'" );
				$rowAdmins = $database->loadObjectList();
				foreach ($rowAdmins AS $rowAdmin) {
					$isModerator=isModerator($rowAdmin->uid);
					if ($isModerator==1) {
						createEmail($row,'unbanAdmin',$ueConfig,$rowAdmin);
					}
				}
			}
			echo _UE_USERUNBANREQUEST_SUCCESSFUL;

		}
	}
}

function processReports(){
	global $mainframe;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	$reports=array();
	$reports=$_POST['reports'];
	foreach ($reports AS $report) {
		$query = "UPDATE #__cbe_userreports SET reportedstatus = 1 WHERE reportid = '" . cbGetEscaped($report) . "'";
		$database->setQuery($query);
		$database->query();
	}
	
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
	}
	$mainframe->redirect(JRoute::_('index.php?option=com_cbe'.$Itemid_c.'&task=moderateReports'),_UE_USERREPORTMODERATED_SUCCESSFUL);
}
function moderator(){
	global $ueConfig;
	global $cbe_gallery_installed;

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();
	
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	echo _UE_MODERATE_TITLE;
	echo "<center>";
	$query = "SELECT count(*) FROM #__cbe  WHERE avatarapproved=0";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totalimages = $database->loadResult();

	$query = "SELECT count(*) FROM #__cbe_userreports  WHERE reportedstatus=0 ";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totaluserreports = $database->loadResult();

	$query = "SELECT count(*) FROM #__cbe WHERE banned=2";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totalunban = $database->loadResult();

	$query = "SELECT count(*) FROM #__cbe WHERE approved=0 AND confirmed=1 ";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$totaluserpendapproval = $database->loadResult();

	$totalgallery = 0;
	if ($cbe_gallery_installed == 1) {
		$totalgallery = check_gallery_mtask();
	}

	if($totalgallery > 0 || $totalunban > 0 || $totaluserreports > 0 || $totalimages > 0 || ($totaluserpendapproval > 0 && $ueConfig['allowModUserApproval'])) {
		if($totalunban > 0) echo "<div><a href='index.php?option=com_cbe&amp;task=moderateBans'>".$totalunban." "._UE_UNBANREQUIREACTION."</a></div>";
		if($totaluserreports > 0) echo "<div><a href='index.php?option=com_cbe&amp;task=moderateReports'>".$totaluserreports." "._UE_USERREPORTSREQUIREACTION."</a></div>";
		if($totalimages > 0) echo "<div><a href='index.php?option=com_cbe&amp;task=moderateImages'>".$totalimages." "._UE_IMAGESREQUIREACTION."</a></div>";
		if($totaluserpendapproval > 0 && $ueConfig['allowModUserApproval']) echo "<div><a href='index.php?option=com_cbe&amp;task=pendingApprovalUser'>".$totaluserpendapproval." "._UE_USERPENDAPPRACTION."</a></div>";
		if($totalgallery > 0) echo "<div><a href='index.php?option=com_cbe&amp;task=moderateGallery'>".$totalgallery." "._UE_CBE_GALLERY_REQUIREACTION."</a></div>";
	} else {
		echo _UE_NOACTIONREQUIRED;

	}
	echo "</center>";
}


function approveUser($option,$uids) {
	global $ueConfig,$_POST,$mosConfig_emailpass, $mainframe;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$isModerator=isModerator($my->id);
	if($ueConfig['allowModUserApproval']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		exit();
	}
	if ($isModerator!=1){
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	if($mosConfig_emailpass!=1) $mosConfig_emailpass=0;

	$uids = array();
	$uids = $_POST['uids'];
	if (count($uids) > 0 ) {
		foreach($uids AS $uid) {
			$sql="UPDATE #__cbe SET approved='1'WHERE id='".cbGetEscaped($uid)."'";
			$database->SetQuery($sql);
			$database->query();
			//sv0.6232 aprovel-block-combination
			$sql="UPDATE #__users SET block='0' WHERE id='".cbGetEscaped($uid)."' AND block='1'";
			$database->SetQuery($sql);
			$database->query();
         	
			$database->setQuery( "SELECT name, username, email FROM #__users"
			."\n WHERE id='$uid'" );
			$rows = $database->loadObjectList();
			foreach ($rows AS $row) {
				createEmail($row,'welcome',$ueConfig,null,$mosConfig_emailpass);
			}
			$comment="";
			if(ISSET($_POST[$comment])) $comment=$_POST[$comment];
		}
		
		if (!isset($_REQUEST['Itemid'])) {
			if ($GLOBALS['Itemid_com']!='') {
				$Itemid_c = $GLOBALS['Itemid_com'];
			} else {
				$Itemid_c = '';
			}
		} else {
			$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
		}
		$mainframe->redirect('index.php?option=com_cbe'.$Itemid_c.'&task=pendingApprovalUser',_UE_USERAPPROVAL_SUCCESSFUL);
	}
}

function rejectUser($option,&$uids) {
	global $ueConfig,$_POST,$mosConfig_emailpass;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$isModerator=isModerator($my->id);
	if($ueConfig['allowModUserApproval']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		exit();
	}
	if ($isModerator!=1){
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	if($mosConfig_emailpass!=1) $mosConfig_emailpass=0;

	$uids = array();
	$uids = $_POST['uids'];
	if (count($uids) > 0) {
		foreach($uids AS $uid) {
			$sql="UPDATE #__cbe SET approved='2'WHERE id='".cbGetEscaped($uid)."'";
			$database->SetQuery($sql);
			$database->query();
			$database->setQuery( "SELECT name, username, email FROM #__users"
			."\n WHERE id='$uid'" );
			$rows = $database->loadObjectList();
			foreach ($rows AS $row) {
				createEmail($row,'rejectUser',$ueConfig,$_POST['comment'.$uid],$mosConfig_emailpass);
			}
		}
		
		if (!isset($_REQUEST['Itemid'])) {
			if ($GLOBALS['Itemid_com']!='') {
				$Itemid_c = $GLOBALS['Itemid_com'];
			} else {
				$Itemid_c = '';
			}
		} else {
			$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
		}
		$mainframe->redirect('index.php?option=com_cbe'.$Itemid_c.'&task=pendingApprovalUser',_UE_USERREJECT_SUCCESSFUL);
	}

}

function pendingApprovalUsers($option) {
	global $ueConfig,$_POST,$mosConfig_emailpass;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$isModerator=isModerator($my->id);
	if($ueConfig['allowModUserApproval']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		exit();
	}
	if ($isModerator!=1){
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	if($mosConfig_emailpass!=1) $mosConfig_emailpass=0;

	$database->setQuery( "SELECT u.id, u.name, u.username, u.email, u.registerDate "
	."\n FROM #__users u, #__cbe c "
	."\n WHERE u.id=c.id AND c.approved=0 AND c.confirmed=1" );
	$rows = $database->loadObjectList();

	HTML_cbe::pendingApprovalUsers($option, $rows);
}
function cbsearch( $option, $uid, $submitvalue)
{
	global $ueConfig,$enhanced_Config;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$cbe_check1 = '';
	$cbe_check1 = JArrayHelper::getValue($_POST, 'mod_cbe_search', '');
	$cbe_check2 = '';
	$cbe_check2 = JArrayHelper::getValue($_POST, 'mod_cbe_search1', '');

	$cbe_check1 = str_replace('-B-E', '', str_replace('C-','', $cbe_check1));
	$cbe_check = 0;
	$cbe_check = ((md5($cbe_check1) == $cbe_check2) ? 1 : 0);

	if (!allowAccess( $enhanced_Config['allow_cbsearchviewbyGID'],'RECURSE', userGID($my->id), $acl, '1') && ($cbe_check==0 || $enhanced_Config['allow_cbesearch_module']=='0'))
	{
		echo _UE_NOT_AUTHORIZED;
		return;
	}

	$whereadd = '';
	$prefix = 'ue.';
	$query = '';
	$sform='';

	if (isset($_POST['adminForm']) || isset($_POST['CBEsearchModuleForm']))
	{
		cbsearch_passthrough( $option, $uid, $submitvalue);
	} // end isset($_POST('AdminForm'))

	else

	{

		// generate the search form
		// will be submitted to HTML_cbe::cbsearch
		// which then reposts it back to this function
		// and captured above

		for ($g=0; $g<=1; $g++) {
			if ($g<1) {
				$whereadd = "\n AND t.simple = '1'";
			} else {
				$whereadd = "\n AND t.advanced = '1'";
			}

			$database->setQuery( "SELECT f.fieldid, f.name, f.title, f.type, t.range FROM #__cbe_fields AS f, #__cbe_searchmanager AS t" . "\n WHERE f.published=1"
			. "\n AND f.fieldid = t.fieldid"
			.$whereadd
			. "\n ORDER BY t.ordering" );
			$rowFields[$g] = $database->loadObjectList();

			foreach ( $rowFields[$g] as $rowField )

			{
				$fieldid = $rowField->fieldid;
				$name = $rowField->name;
				$title = getLangDefinition($rowField->title);
				$type = $rowField->type;
				$rangeflag = $rowField->range;

				switch ($type)

				{

					case "checkbox":

					{
						$sform[$g] .= '<tr><td width=15%>';
						$sform[$g] .= $title.' ';
						$sform[$g] .= '</td><td width=85%>';
						$sform[$g] .= '<input type="checkbox" name="'.$name.'" value = "1" />';
						$sform[$g] .= '</td></tr>';
					}

					break;
// PK MultiCheckbox start
					case "multicheckbox":
					{
						$database->setQuery( "SELECT fieldtitle FROM #__cbe_field_values"
						. "\n WHERE fieldid = ".$database->getEscaped($fieldid)
						. "\n ORDER BY ordering" );
						$Values = $database->loadObjectList();
						
						if ( $Values ) {
							$options = "<table><tr><td>";
							$i=0;
							foreach ( $Values as $Value )
							{
								$i= ($i==1) ? 2 : 1;
								$Value=$Value->fieldtitle;
								$langValue = getLangDefinition($Value);
								$options .= '<input type="checkbox" name="'.$name.'[]" value = "'.$Value.'" >'.$langValue.'</input>'."\n";
								if ( $i == 2 ) {
//									$options .= "<br>";
									$options .= "</td></tr><tr><td>";
								} else if (count($Values) == 1) {
									$options .= "</td><td></td></tr>";
								} else {
									$options .= "</td><td>";
								}
							}
							
							
							$sform[$g] .= '<tr><td width=15%>';
							$sform[$g] .= $title.' ';
							$sform[$g] .= "</td><td width=85%>\n";
							
							$sform[$g] .= $options."</td></tr></table>";
							$sform[$g] .= '</td></tr>';
						}

					}
					break;
// PK MultiCheckbox end

					case "select":
					case "radio":
					{
						// patched 14-03-05
						$database->setQuery( "SELECT fieldtitle FROM #__cbe_field_values"
						. "\n WHERE fieldid = ".$database->getEscaped($fieldid)
						. "\n ORDER BY ordering" );
						$Values = $database->loadObjectList();
						$options='';
						if ( $Values ) {
							// first create $options because it is common regardless of t.range
							$options .= "<option value=\"\"";
							$options .= ">"._UE_SEARCH_ANY."</option> \n";
							// iterate through $Values, appending them to $options
							foreach ( $Values as $Value ) {
								$Value=$Value->fieldtitle;
								$langValue = getLangDefinition($Value);
								$options .= '<option value="'.$Value.'" ';
								$options .= ">$langValue</option> \n";
							}
							// add the tail </select> to close off
							$options .="</select> \n";
						}

						// make title part

						$sform[$g] .= '<tr><td width=15%>';
						$sform[$g] .= $title.' ';
						$sform[$g] .= '</td><td width=85%>';

						// now test for t.range

						if  ( $rangeflag < 1 ) {
							$sform[$g] .= '<select class="inputbox" name="'.$name.'" size="1"> ';
						} else {
							$sform[$g] .= '<select class="inputbox" name="'.$name.'from" size="1"> ';
							$sform[$g] .= $options.'  '._UE_SEARCH_TO.'  ';
							$sform[$g] .= '<select class="inputbox" name="'.$name.'to" size="1"> ';
						} // end if ( $rangeflag )
						$sform[$g] .= $options;
						$sform[$g] .= '</td></tr>';

					}
					break;

// PK MultiSelect start
					case "multiselect":
					{
						// patched 14-03-05
						$database->setQuery( "SELECT fieldtitle FROM #__cbe_field_values"
						. "\n WHERE fieldid = ".$database->getEscaped($fieldid)
						. "\n ORDER BY ordering" );
						$Values = $database->loadObjectList();

						$database->setQuery( "SELECT size FROM #__cbe_fields WHERE fieldid='".$database->getEscaped($fieldid)."'" );
						//$fieldsize = $database->loadResult();
						$fieldsize = count($Values);
						if ($fieldsize < 1){ 
							$fieldsize = 1;
						}

						$options='';

						if ( $Values )

						{

							// first create $options because it is common regardless of t.range

//							$options .= "<option value=\"\"";
//							$options .= ">"._UE_SEARCH_ANY."</option>\n";

							// iterate through $Values, appending them to $options

							foreach ( $Values as $Value )

							{
								$Value=$Value->fieldtitle;
								$langValue = getLangDefinition($Value);
								$options .= '<option value="'.$Value.'" ';
								$options .= ">$langValue</option>\n";
							}

							// add the tail </select> to close off

							$options .="</select>\n";

						}

						// make title part

						$sform[$g] .= '<tr><td width=15%>';
						$sform[$g] .= $title.' ';
						$sform[$g] .= "</td><td width=85%>\n";

						$sform[$g] .= '<select class="inputbox" name="'.$name.'[]" multiple size="'.$fieldsize.'">'."\n";

						$sform[$g] .= $options;
						$sform[$g] .= '</td></tr>';

					}
					break;

// PK MultiSelect end

// PK edit PREDEFINED
					case "predefined":
					case "editorta":
					case "textarea":
					case "text":
					{

//						$sform[$g] .= '<tr><td width="15%">';
//						$sform[$g] .= $title.' ';
//						$sform[$g] .= '</td><td width="85%">';
//						$sform[$g] .= '<input type="text" name="'.$name.'" size = "20" maxlength="20";"\>';
//						$sform[$g] .= '</td></tr>';

						if  ( $rangeflag < 1 ) {
							$sform[$g] = '<tr><td width="15%">';
							$sform[$g] .= $title.' ';
							$sform[$g] .= '</td><td width="85%">';
							$sform[$g] .= '<input type="text" name="'.$name.'" size = "20" maxlength="20" \>';
							$sform[$g] .= '</td></tr>';
						} else {
							$sform[$g] .= '<tr><td width="15%">';
							$sform[$g] .= $title.' ';
							$sform[$g] .= '</td><td width="85%">';
							$sform[$g] .= '<input type="text" name="'.$name.'from" size = "20" maxlength="20";" \>';
							$sform[$g] .= '<br>'._UE_SEARCH_TO.'<br>  ';
							$sform[$g] .= '<input type="text" name="'.$name.'to" size = "20" maxlength="20";" \>';
							$sform[$g] .= '</td></tr>';
						} // end if ( $rangeflag )
					}
					break;

					case "webaddress":
					{
						$sform[$g] .= '<tr><td width="15%">';
						$sform[$g] .= $title.' ';
						$sform[$g] .= '</td><td width="85%">';
						$sform[$g] .= '<input type="text" name="'.$name.'" size = "20" maxlength="20";" \>';
						$sform[$g] .= '</td></tr>';
					}
					break;
// PK Datefield (Age & Birthday only)
					case "date":
					case "birthdate":
					case "dateselect":
					case "dateselectrange":
					{
						if ($name == $enhanced_Config['lastvisitors_birthday_field']) {
							$title = _UE_SHOWAGE_TITLE;
							
							if  ( $rangeflag < 1 ) {
								$sform[$g] .= '<tr><td width="15%">';
								$sform[$g] .= $title.' ';
								$sform[$g] .= '</td><td width="85%">';
								$sform[$g] .= '<input type="text" name="'.$name.'" size = "5" maxlength="3";" \>';
								$sform[$g] .= '</td></tr>';
							} else {
								$sform[$g] .= '<tr><td width="15%">';
								$sform[$g] .= $title.' ';
								$sform[$g] .= '</td><td width="85%">';
								$sform[$g] .= '<input type="text" name="'.$name.'from" size = "4" maxlength="3";" \>';
								$sform[$g] .= ' '._UE_SEARCH_TO.' ';
								$sform[$g] .= '<input type="text" name="'.$name.'to" size = "4" maxlength="3";" \>';
								$sform[$g] .= '</td></tr>';
							}
							
						} else {
							$sform[$g] .= '<tr><td width="15%">';
							$sform[$g] .= $title.' ';
							$sform[$g] .= '</td><td width="85%">';
							$sform[$g] .= '<input type="text" name="'.$name.'" size = "5" maxlength="3";" \>';
							$sform[$g] .= '</td></tr>';
						}
					}
					break;
// Age end
					case "numericint":
					case "numericfloat":
					{
						if  ( $rangeflag < 1 ) {
							$sform[$g] .= '<tr><td width="15%">';
							$sform[$g] .= $title.' ';
							$sform[$g] .= '</td><td width="85%">';
							$sform[$g] .= '<input type="text" name="'.$name.'" size = "5";" \>';
							$sform[$g] .= '</td></tr>';
						} else {
							$sform[$g] .= '<tr><td width="15%">';
							$sform[$g] .= $title.' ';
							$sform[$g] .= '</td><td width="85%">';
							$sform[$g] .= '<input type="text" name="'.$name.'from" size="4" \>';
							$sform[$g] .= '&nbsp;'._UE_SEARCH_TO.'&nbsp;';
							$sform[$g] .= '<input type="text" name="'.$name.'to" size = "4" \>';
							$sform[$g] .= '</td></tr>';
						} // end if ( $rangeflag )
					}
					break;
// nummeric end
				} // end switch ($type)
			} // end foreach
		} // end for
		{

			// create additional search options for the $ueConfig['searchtab2'] tab

			$g=2;

			if ($enhanced_Config['cbsearch_geo_dist']=='1') {
				$myGeoInfo = '';
				$doGeoInfo = 1;
				$database->setQuery("SELECT GeoLat, GeoLng FROM #__cbe_geodata WHERE uid='".$my->id."' AND GeoLat != 0 AND GeoLng != 0 AND GeoAllowShow = '1'");
				$database->loadObject($myGeoInfo);
				if (!$database->query() || $myGeoInfo->GeoLat == 0) {
					$doGeoInfo = 0;
				}
				$sform[$g] .= '<tr><td width="15%">';
				$sform[$g] .= _UE_CBE_GEOINFO_DISTANCE.' ';
				$sform[$g] .= '</td><td width="85%">';
				if ($doGeoInfo == 1) {
					$sform[$g] .= '<input type="text" name="cbs_geodistance" size = "6" maxlength="5" />'._UE_CBE_GEOINFO_Km;
				} else {
					$sform[$g] .= ' N/A ';
				}
				$sform[$g] .= '</td></tr>';
			}

			if ($enhanced_Config['onlinenow']=="1")

			{
				$sform[$g] = '<tr><td width="15%">';
				$sform[$g] .= _UE_ONLINE_NOW_ONLY.' ';
				$sform[$g] .= '</td><td width="85%">';
				$sform[$g] .= '<input type="checkbox" name="onlinenow" value = "1" />';
				$sform[$g] .= '</td></tr>';
			}

			if ($enhanced_Config['picture']=="1")

			{
				$sform[$g] .= '<tr><td width="15%">';
				$sform[$g] .= _UE_PICTURE_ONLY.' ';
				$sform[$g] .= '</td><td width="85%">';
				$sform[$g] .= '<input type="checkbox" name="picture" value = "1" />';
				$sform[$g] .= '</td></tr>';
			}

			if ($enhanced_Config['added10']=="1")

			{
				$sform[$g] .= '<tr><td width="15%">';
				$sform[$g] .= _UE_ADDED_10_DAYS_OR_LESS.' ';
				$sform[$g] .= '</td><td width="85%">';
				$sform[$g] .= '<input type="checkbox" name="added10" value = "1" />';
				$sform[$g] .= '</td></tr>';
			}

			if ($enhanced_Config['online10']=="1")

			{
				$sform[$g] .= '<tr><td width="15%">';
				$sform[$g] .= _UE_ONLINE_10_DAYS_OR_LESS.' ';
				$sform[$g] .= '</td><td width="85%">';
				$sform[$g] .= '<input type="checkbox" name="online10" value = "1" />';
				$sform[$g] .= '</td></tr>';
			}

		}
		HTML_cbe::cbsearch($sform);
	}
}
function cbsearch_passthrough( $option, $uid, $submitvalue) {
	global $ueConfig,$enhanced_Config;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeCBSObj.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$cbe_check1 = '';
	$cbe_check1 = JArrayHelper::getValue($_POST, 'mod_cbe_search', '');
	$cbe_check2 = '';
	$cbe_check2 = JArrayHelper::getValue($_POST, 'mod_cbe_search1', '');

	$cbe_check1 = str_replace('-B-E', '', str_replace('C-','', $cbe_check1));
	$cbe_check = 0;
	$cbe_check = ((md5($cbe_check1) == $cbe_check2) ? 1 : 0);

	$whereadd = '';
	$prefix = 'ue.';
	$query = '';
	$sform='';

	if (isset($_POST['adminForm']) || isset($_POST['CBEsearchModuleForm']))
	{
		$database->setQuery( "SELECT f.fieldid, f.name AS name, f.title, f.type, t.range AS range FROM #__cbe_fields AS f, #__cbe_searchmanager AS t WHERE f.published=1 AND f.fieldid = t.fieldid");
		$valids = $database->loadObjectList();
		foreach ($valids as $valid)
		{
			if (($valid->type)=="select" || ($valid->type)=="radio")
			{
				if (($valid->range)==1)
				{
					// range = 1
					$from = $valid->name."from";
					$to = $valid->name."to";

					if ( !empty($_POST[($from)]) && !empty($_POST[($to)]) )

					{
						// neither empty
						// patched 14-03-05
						$afrom = $database->getEscaped($_POST[($from)]);
						$ato = $database->getEscaped($_POST[($to)]);

						if ($afrom>$ato)

						{
							list($afrom, $ato) = array($ato, $afrom);
						}


						$query .= "AND " . $prefix . ($valid->name) . " BETWEEN '" . $afrom . "' AND '" . $ato . "' ";

					}
					 elseif ( ( empty($_POST[($from)]) && !empty($_POST[($to)]) ) OR ( !empty($_POST[($from)]) && empty($_POST[($to)]) ) )
					{
						// either one empty, not valid when range = 1
						echo _UE_QUERY_NOT_VALID;
						return;
					}

				}
				 elseif (!empty($_POST[($valid->name)]))
				{
					// range = 0, only one variable
					// patched 14-03-05
					$query .= "AND " . $prefix . ($valid->name) . "='" . $database->getEscaped($_POST[($valid->name)]) . "' ";
				}
				// elseif ($cbe_check==0 && $enhanced_Config['allow_cbesearch_module']=='1' && $cbe_check1!='')
				//{
				//	$query .= '';
				//}

			} // end type=select and radio

			if (($valid->type)=="checkbox")

			{

				if (!empty($_POST[($valid->name)]))

				{
					$query .= "AND " . $prefix . ($valid->name) . "= 1 ";
				}

			} // end type=checkbox


			if (($valid->type)=="text" || ($valid->type)=="textarea" || ($valid->type)=="editorta" || ($valid->type)=="webaddress")
			{

// range text
				if (($valid->range)==1)
				{
					// range = 1
					$from = $valid->name."from";
					$to = $valid->name."to";

					if ( !empty($_POST[($from)]) && !empty($_POST[($to)]) )

					{
						// neither empty
						// patched 14-03-05
						$afrom = $database->getEscaped($_POST[($from)]);
						$ato = $database->getEscaped($_POST[($to)]);

						if ($afrom>$ato)

						{
							list($afrom, $ato) = array($ato, $afrom);
						}


						$query .= "AND " . $prefix . ($valid->name) . " BETWEEN '" . $afrom . "' AND '" . $ato . "' ";

					}

					elseif ( ( empty($_POST[($from)]) && !empty($_POST[($to)]) ) OR ( !empty($_POST[($from)]) && empty($_POST[($to)]) ) )

					{
						// either one empty, not valid when range = 1
						echo _UE_QUERY_NOT_VALID;
						return;

					}
				} else {
// range END
					if (!empty($_POST[($valid->name)]))
					{
	
						$escaped = $database->getEscaped(trim( strtolower( $_POST[($valid->name)] )));
						$query .= "AND " . $prefix . ($valid->name) . " LIKE '%$escaped%'";
	
					}
// range close
				} // close
			} // end type=text, textarea or editorta

// PK edit PREDEFINED
			if (($valid->type)=="predefined")
			{
				if (!empty($_POST[($valid->name)]))
				{
					$escaped = $database->getEscaped(trim( strtolower( $_POST[($valid->name)] )));
					$query .= "AND " . "u." . ($valid->name) . " LIKE '%$escaped%'";

				}

			} // end type=predefined
// PK MultiSelect
			if (($valid->type)=="multiselect") 
			{
				if (!empty($_POST[($valid->name)]) && is_array($_POST[($valid->name)])) {
					$query .= "AND ( ";
					
					$mcount = count($_POST[($valid->name)]);
					$multi_sarray = $_POST[($valid->name)];

					$i=0;
					for ($i; $i<$mcount; $i++) {
//						$ms_value = $database->getEscaped(trim( strtolower( $multi_sarray[$i] )));
						$ms_value = $multi_sarray[$i];
						if ($i==0) {
							$query .= $prefix.($valid->name)." LIKE '%".$ms_value."%'";
						} else {
							$query .= " OR ".$prefix.($valid->name)." LIKE '%".$ms_value."%'";
						}
					}
					$query .= ")";
				}
			} // end multiselect	

// PK MultiCheckbox
			if (($valid->type)=="multicheckbox")
			{
				if (!empty($_POST[($valid->name)]) && is_array($_POST[($valid->name)])) {
					$query .= "AND ( ";
					
					$mcount = count($_POST[($valid->name)]);
					$multi_sarray = $_POST[($valid->name)];

					$i=0;
					for ($i; $i<$mcount; $i++) {
//						$mc_value = $database->getEscaped(trim( strtolower( $multi_sarray[$i] )));
						$mc_value = $multi_sarray[$i];
						if ($i==0) {
							$query .= $prefix.($valid->name)." LIKE '%".$mc_value."%'";
						} else {
							$query .= " OR ".$prefix.($valid->name)." LIKE '%".$mc_value."%'";
						}
					}
					$query .= ")";
				}
			} // end type=multicheckbox

// PK Date (Age & Birthday only)
			if (($valid->type)=="date" || $valid->type=="birthdate" || $valid->type=="dateselect" || $valid->type=="dateselectrange")
			{
				if ($valid->name == $enhanced_Config['lastvisitors_birthday_field']) {
					if (($valid->range)==1)
					{
						// range = 1
						$from = $valid->name."from";
						$to = $valid->name."to";
	
						if ( !empty($_POST[($from)]) && !empty($_POST[($to)]) )
						{
							$this_year = date('Y');
							$search_age_from = $database->getEscaped($_POST[($from)]);
							$search_age_to = $database->getEscaped($_POST[($to)]);
	
							if ($search_age_from < $search_age_to) {
								list($search_age_from, $search_age_to) = array($search_age_to, $search_age_from);
							}
	
							if ($enhanced_Config['search_age_common_style']=='1') {
								$search_year_from = $this_year - 1 - $search_age_from."-01-01";
								//$search_year_to = $this_year - 1 - $search_age_to."-12-31";
								$search_year_to = $this_year  - $search_age_to."-12-31";
							} else {
								$search_year_from = $this_year - $search_age_from."-01-01";
								$search_year_to = $this_year - $search_age_to."-12-31";
							}
							$query .= "AND " . $prefix . ($valid->name) . " BETWEEN '" . $search_year_from . "' AND '" . $search_year_to . "' ";
						}
						elseif ( ( empty($_POST[($from)]) && !empty($_POST[($to)]) ) OR ( !empty($_POST[($from)]) && empty($_POST[($to)]) ) )
						{
							// either one empty, not valid when range = 1
							echo _UE_QUERY_NOT_VALID;
							return;
						}
					} else {
//no range
						if (!empty($_POST[($valid->name)])) {
							$search_age = $_POST[($valid->name)];
							$this_year = date('Y');
							//if ($enhanced_Config['search_age_common_style']=='1') {
							//	$search_year = $this_year - 1 - $search_age;
							//} else {
								$search_year = $this_year - $search_age;
							//}
							$query .= "AND ".$prefix.($valid->name)." LIKE '".$search_year."%'";
						}
					}
				} else {
					// to do
				}
			} // end type=date age/birthday
			
			if (($valid->type)=="numericfloat" || ($valid->type)=="numericint") {
				if (($valid->range)==1)
				{
					// range = 1
					$from = $valid->name."from";
					$to = $valid->name."to";

					if ( !empty($_POST[($from)]) && !empty($_POST[($to)]) )
					{
						$_from = str_replace(',','.',$_POST[($from)]);
						$_to = str_replace(',','.',$_POST[($to)]);
						$afrom = floatval($database->getEscaped($_from));
						$ato = floatval($database->getEscaped($_to));

						if ($afrom>$ato) {
							list($afrom, $ato) = array($ato, $afrom);
						}
						$query .= "AND " . $prefix . ($valid->name) . " BETWEEN '" . $afrom . "' AND '" . $ato . "' ";
					}
					elseif ( ( empty($_POST[($from)]) && !empty($_POST[($to)]) ) OR ( !empty($_POST[($from)]) && empty($_POST[($to)]) ) )
					{
						// either one empty, not valid when range = 1
						echo _UE_QUERY_NOT_VALID;
						return;
					}
				} else {
					if (!empty($_POST[($valid->name)])) {
						$_escaped = str_replace(',','.',$_POST[($valid->name)]);
						$escaped = floatval($database->getEscaped(trim(strtolower($_escaped))));
						$query .= "AND " . $prefix . ($valid->name) . " LIKE '$escaped%'";
					}
				} // close
			} // end type=nummericint, nummericfloat
		}

		// end of run-thru of parameters
		// now do hidden form to be posted to cbsearchlist
		// in order to process the query
			if (!isset($_REQUEST['Itemid'])) {
				if ($GLOBALS['Itemid_com']!='') {
					$Itemid_c = $GLOBALS['Itemid_com'];
				} else {
					$Itemid_c = '';
				}
			} else {
				$Itemid_c = "&amp;Itemid=".$_REQUEST['Itemid'];
			}

		$new_search_ses = new moscbeCBSObj($database);
		$new_search_array = array();
		$new_search_array['cbquery'] = $query;
		$new_search_array['do_cbquery'] = (($query!='') ? 1 : 0);
		$new_search_array['listid'] = $enhanced_Config['cbsearchlistid'];
		$new_search_array['mod_cbe_search'] = "C-".JArrayHelper::getValue($_POST, 'mod_cbe_search', '')."-B-E";
		$new_search_array['mod_cbe_search1'] = JArrayHelper::getValue($_POST, 'mod_cbe_search1', '');

		if ( JRequest::getInt('cbs_geodistance') > 0 ) {
			$geoSearchDist = intval($_POST[('cbs_geodistance')]);
			$myGeoInfo = '';
			$database->setQuery("SELECT GeoLat, GeoLng FROM #__cbe_geodata WHERE uid='".$my->id."' AND GeoLat != 0 AND GeoLng != 0 AND GeoAllowShow = '1'");
			$myGeoInfo = $database->loadObject();
			$new_search_array['geo_distance'] = 1;
			$new_search_array['cbquery'] .= " AND u.id=ugeo.uid AND ugeo.GeoAllowShow = '1' AND ugeo.GeoLat != 0 AND ugeo.GeoLng != 0 AND "
			."(acos(sin(radians(ugeo.GeoLat)) * sin(radians(".$myGeoInfo->GeoLat.")) + cos(radians(ugeo.GeoLat)) * cos(radians(".$myGeoInfo->GeoLat.")) *"
			." cos(radians(ugeo.GeoLng) - radians(".$myGeoInfo->GeoLng."))) * 6371.11) <= ".$geoSearchDist;
			$new_search_array['do_cbquery'] = 1;
		}
		if ( JRequest::getVar('onlinenow')=="1")
		{
			$new_search_array['onlinenow'] = 1;
			$new_search_array['cbquery'] .= " AND ue.id = s.userid ";
			$new_search_array['do_cbquery'] = 1;
		}
		if ( JRequest::getVar('picture')=="1")
		{
			$new_search_array['picture'] = 1;
			$new_search_array['cbquery'] .= " AND ue.avatar IS NOT NULL ";
			$new_search_array['do_cbquery'] = 1;
		}
		if ( JRequest::getVar('added10')=="1")
		{
			$new_search_array['added10'] = 1;
			$new_search_array['cbquery'] .= " AND DATE_SUB(CURDATE(),INTERVAL 10 DAY) <= u.registerDate ";
			$new_search_array['do_cbquery'] = 1;
		}
		if ( JRequest::getVar('online10')=="1")
		{
			$new_search_array['online10'] = 1;
			$new_search_array['cbquery'] .= " AND DATE_SUB(CURDATE(),INTERVAL 10 DAY) <= u.lastvisitDate ";
			$new_search_array['do_cbquery'] = 1;
		}

		$new_search_ses->bind( $new_search_array );
		$new_search_ses->store($my->id);

		$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=cbsearchlist&cbsearchid=".$new_search_ses->id."&cbsearcht=".$new_search_ses->q_time);
	} // end isset($_POST('AdminForm'))
}

function cbsearchlist( $option, $uid, $submitvalue)
{
	global $ueConfig,$enhanced_Config,$_POST,$_REQUEST;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeCBSObj.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$tmp_searchid = JRequest::getVar('cbsearchid', 0);
	$tmp_searcht = JRequest::getVar('cbsearcht', 0);
	$act_search_ses = new moscbeCBSObj($database);
	$act_search_ses->_sessiontimeout = intval($enhanced_Config['cbsearch_expire_time']);
	//die($tmp_searchid . ", " . $tmp_searcht . ", " . $my->id);
	$act_search_ses->check($tmp_searchid, $tmp_searcht, $my->id);

	if ($act_search_ses->_loadstate == false) {
		$reItemId = JArrayHelper::getValue($_REQUEST, 'Itemid', 0);
		if ($reItemId != 0) {
			$reItemId = "&Itemid=".$reItemId;
		} else {
			$reItemId = '';
		}
		$message = _UE_CBSEARCH_QUERY_EXPIRED;
		$mainframe->redirect("index.php?option=com_cbe".$reItemId."&task=cbsearch", $message);
		exit();
	} else {
		if ($enhanced_Config['cbsearch_update_ses_on_page'] == '1') {
			$act_search_ses->store($act_search_ses->uid, $act_search_ses->id);
		}
	}

	$cbe_check1 = '';
	$cbe_check1 = $act_search_ses->mod_cbe_search;
	$cbe_check2 = '';
	$cbe_check2 = $act_search_ses->mod_cbe_search1;

	$cbe_check1 = str_replace('-B-E', '', str_replace('C-','', $cbe_check1));
	$cbe_check = 0;
	$cbe_check = ((md5($cbe_check1) == $cbe_check2) ? 1 : 0);

	if (!allowAccess( $enhanced_Config['allow_cbsearchviewbyGID'],'RECURSE', userGID($my->id), $acl, '1') && ($cbe_check==0 || $enhanced_Config['allow_cbesearch_module']=='0'))
	{
		echo _UE_NOT_AUTHORIZED;
		if ($my->id == 0) {
			echo "<br />";
			echo _UE_CBSEARCH_DO_LOGIN;
		} elseif ($my->id > 0) {
			echo "<br />";
			echo _UE_CBSEARCH_ERR_ACL;
		}
		return;
	}

	$database->setQuery("SELECT listid, title FROM #__cbe_lists WHERE published=1 ORDER BY ordering");
	$plists = $database->loadObjectList();
	$lists = array();
	$publishedlists = array();

	$n=count( $plists );
	for ($i=0; $i < $n; $i++)

	{
		$plist =& $plists[$i];
		$publishedlists[] = JHTML::_('select.option',  $plist->listid, getLangDefinition($plist->title) );
	}

	if(empty($act_search_ses->listid))
	{
		$database->setQuery( "SELECT listid FROM #__cbe_lists "
		. "\n WHERE `default`=1 AND published=1" );
		$listid = $database->loadresult();
	}
	else
	{
		$listid = $act_search_ses->listid;
	}
	if(!$listid > 0)
	{
		echo _UE_NOLISTFOUND;
		//echo "<br/>LISTID: ->".$_POST['listid']."<--";
		//print_r($_POST);
		return;
	}

	$lists['plists'] = JHTML::_('select.genericlist', $publishedlists, 'listid', 'class="inputbox" size="1" onchange="document.ueform.submit();"', 'value', 'text', $listid );

	$database->setQuery( "SELECT l.* FROM #__cbe_lists l"
	. "\n WHERE l.listid='$listid' AND l.published=1" );
	$row = $database->loadObjectList();

	$col=$row[0]->col1fields;
	$col=explode('|*|',$col);

	$n=count( $col );
	$active_cols = 0;
	if ($row[0]->col1enabled && ($row[0]->col2enabled || $row[0]->col3enabled || $row[0]->col4enabled)) {
		$active_cols = 1;
	}
	if($row[0]->col1enabled) {
		for ($i=0; $i < $n; $i++)
		{
         	
         	
			if($i==0 && $active_cols==1) {
				$lfields .= "<td class='cbsearchlist_col1' valign='top'>\n";
			} else {
				$lfields .= "<br/>\n";
			}
			if($col[$i]!='' && $col[$i]!=null)
			{
				$database->setQuery( "SELECT f.name, f.title, f.type "
				. "\nFROM #__cbe_fields AS f"
				. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
				$cfield = $database->loadObjectList();
				$cfield = $cfield[0];
				if($row[0]->col1captions==1)
				$oTitle =  getLangDefinition($cfield->title).": ";
				else $oTitle='';
				$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
			}
		}
         	
		if ($active_cols > 0) {
			$lfields .= "</td>\n";
		} else {
			$lfields .= "<br/>\n";
		}
	}

	if($row[0]->col2enabled) {
		$col=$row[0]->col2fields;
		$col=explode('|*|',$col);

		$n=count( $col );
		for ($i=0; $i < $n; $i++)

		{
			if($i==0)

			$lfields .= "<td class='cbsearchlist_col2' valign='top'>\n";
			else

			$lfields .= "<br/>\n";

			if($col[$i]!='' && $col[$i]!=null)
			{
				$database->setQuery( "SELECT f.name, f.title, f.type "
				. "\nFROM #__cbe_fields AS f"
				. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
				$cfield = $database->loadObjectList();
				$cfield = $cfield[0];

				if($row[0]->col2captions==1)

				$oTitle =  getLangDefinition($cfield->title).": ";

				else

				$oTitle='';

				$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
			}
		}
		$lfields .= "</td>\n";
	}
	if($row[0]->col3enabled)
	{
		$col=$row[0]->col3fields;
		$col=explode('|*|',$col);

		$n=count( $col );
		for ($i=0; $i < $n; $i++)

		{

			if($i==0) $lfields .= "<td class='cbsearchlist_col3' valign='top'>\n";
			else $lfields .= "<br/>\n";
			$database->setQuery( "SELECT f.name, f.title, f.type "
			. "\nFROM #__cbe_fields AS f"
			. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
			$cfield = $database->loadObjectList();
			$cfield = $cfield[0];
			if($row[0]->col3captions==1)  $oTitle =  getLangDefinition($cfield->title).": ";
			else $oTitle='';
			$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";
		}
		$lfields .= "</td>\n";
	}

	if($row[0]->col4enabled)

	{
		$col=$row[0]->col4fields;
		$col=explode('|*|',$col);

		$n=count( $col );
		for ($i=0; $i < $n; $i++)

		{
			if($i==0) $lfields .= "<td class='cbsearchlist_col4' valign='top'>\n";
			else $lfields .= "<br/>\n";
			if($col[$i]!='' && $col[$i]!=null)

			{
				$database->setQuery( "SELECT f.name, f.title, f.type "
				. "\nFROM #__cbe_fields AS f"
				. "\nWHERE f.published = 1 AND f.fieldid=".$col[$i]);
				$cfield = $database->loadObjectList();
				$cfield = $cfield[0];
				if($row[0]->col4captions==1)  $oTitle =  getLangDefinition($cfield->title).": ";
				else $oTitle='';
				$lfields .=  " \".getFieldValue('".$cfield->type."',\$user->".$cfield->name.",\$user,'".$oTitle."').\"";

			}

		}

		$lfields .= "</td>\n";
	}

	$row=$row[0];

	HTML_cbe::cbsearchlist($row,$lfields,$lists,$listid,$act_search_ses,$submitvalue);
}

function unregister_( $option, $uid, $submitvalue ) {
        global $database, $my, $acl;

        include("components/com_cbe/enhanced/enhanced_functions.inc");
        unRegister($option, $uid, $submitvalue);
}

function deleteUser_( $option, $uid, $submitvalue ) {
	global $database, $my, $acl;
	
	include("components/com_cbe/enhanced/enhanced_functions.inc");
	deleteUser($option, $uid, $submitvalue);
}

function checkUserName ( $option, $val_name ) {
	global $ueConfig, $_GET, $_REQUEST;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if ($ueConfig['reg_useajax']!='1') {
		exit();
	}

//	echo "Name -> ".$val_name."<br>";
	if ($val_name != "") {
		if (eregi("[a-z']",cbGetEscaped($val_name))) {
			$val_name = cbGetEscaped($val_name);
			$val_name = str_replace(';','',$val_name);
			$val_name = str_replace("\'",'',$val_name);
		}
		
		$database->setQuery("SELECT username FROM #__users WHERE username='".$val_name."' LIMIT 1");
		$con_name = $database->loadResult();
		
		if ($con_name != '') {
			$ck_stat = "USRtest:false \n";
		} else {
			if (do_badname_check($val_name)) {
				$ck_stat = "USRtest:false \n";
			} else {
				$ck_stat = "USRtest:true \n";
			}
		}
	} else {
		$ck_stat = "USRtest:empty \n";
	}
	
	echo $ck_stat;
}

function do_badname_check ( $ck_name ) {
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();
	
	$database->setQuery("SELECT badname FROM #__cbe_bad_usernames WHERE published='1'");
	$badnames = $database->loadResultArray();
	$tilt = 0;
	foreach ($badnames as $badname) {
		if (stristr($ck_name, $badname)) {
			$tilt = 1;
		}
	}
	return $tilt;
}

function showTopMost($Itemid_cbe, $Itemid_j) {
	global $ueConfig, $enhanced_Config, $acl, $my;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if ($enhanced_Config['topMost_active'] != '1') {
		echo _UE_TPM_NOTACTIVE;
		return;
	}
	
	$limit = $enhanced_Config['topMostLimit'];
	$tp_query = "SELECT ct.*, u.username from #__cbe_userstime as ct, #__users as u WHERE ct.userid = u.id ORDER BY ct.logtimesum DESC LIMIT ".$limit;
	$database->setQuery($tp_query);
	$toptimes = $database->loadObjectList();
	if (!$database->query()) {
//		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
//		exit();
	}

	HTML_cbe::showTopMost($toptimes,$option,$my,$Itemid_cbe,$Itemid_j);
}

function doGeoCoderCall($option, $check_address, $check_uidu, $check_uidh) {
	global $ueConfig, $enhanced_Config, $mosConfig_live_site, $acl;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$result = "";
	$check = 0;
	if (intval($check_uidu) == '0' || empty($check_uidu)) {
		$result = "empty";
		echo $result;
		exit();
	}
	
	$database->setQuery("SELECT session_id FROM #__session WHERE userid='".intval($check_uidu)."'");
	$check_uhash = md5($database->loadResult());
	
	if ($check_uhash != $check_uidh) {
		$result = "empty";
		echo $result;
		exit();
	} else {
		$check = 1;
	}

	if ($check_address == '') {
		// $check_address = "R�pingstr.26+48151+M�nster";
		$result = "empty";
	} else {
		$google_api_key = $enhanced_Config['geocoder_google_apikey'];
		$url = "http://maps.google.com/maps/geo?key=".$google_api_key."&output=csv&q=";
		$check_address = str_replace(" ","+",$check_address);
		$google_url = $url.$check_address;
         	
		if (!file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/Snoopy.class.php')) {
			$result = "snoop-error";
		} else {
			include(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/Snoopy.class.php');
			$snoopy = new Snoopy;
			$snoopy->fetch($google_url);
			$result = $snoopy->results;
		}
	}
	echo $result;
	exit();
}

function doGeoMapXMLCall() {
	global $ueConfig, $enhanced_Config, $mosConfig_live_site;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();
	
	if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.mapclass.php')) {
		include_once(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.mapclass.php');
		$scan_wide = $enhanced_Config['geocoder_usermap_scanwide'];
		// -> 0 exit, 1 genXML/write and return, 2 only genXML/write, 3 readXML, 4 auto with update-interval
		$res_xml = cbeGeoMap::genXML($scan_wide, 4, $enhanced_Config['geocoder_usermap_interval']);
		header("Content-Type: text/xml");
		header("Content-length: ".strlen($res_xml));
		echo $res_xml;
		
	} else {
		$mosmsg = "GeoCoder Frontend Map not installed - Code XML";
		echo $mosmsg;
		return $mosmsg;
	}
}

function doGeoMapShowCall() {
	global $ueConfig, $enhanced_Config, $mosConfig_live_site;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeGeoObj.php');

	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if ($enhanced_Config['geocoder_show_usermap'] != '1') {
		echo _UE_GEOCODER_USERMAP_NOT_ACTIVE;
		return;
	}

	if (!allowAccess($enhanced_Config['geocoder_allow_viewbyGID'],'RECURSE', userGID($my->id), $acl, '1')) {
		echo _UE_NOT_AUTHORIZED;
		return;
	}
	
	if (!file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.mapclass.php')) {
		$mosmsg = "GeoCoder Frontend Map not installed - Code Map";
		echo $mosmsg;
		return $mosmsg;
	} else {
		include_once(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/geocoder.mapclass.php');
		HTML_cbeUsermap::show_usermap();
	}
}

function realChat($option, $uid) {
	global $ueConfig, $enhanced_Config, $mosConfig_live_site;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	if (!ISSET($_REQUEST['user']) && $uid==0)
	{
		echo _UE_REGISTERFORPROFILE;
		return;
	}

	if ($uid == '0') {
		//echo JText::_(ALERTNOTAUTH);
		echo JText::_('ALERTNOTAUTH');

		return;
	}

	//	include('components/com_cbe/enhanced/realchat/chat_api.php');
	include('components/com_cbe/enhanced/enhanced_functions.inc');

	$time_now = time();

	$database->setQuery( "SELECT * FROM #__cbe c, #__users u WHERE c.id=u.id AND c.id='".$uid."'");
	$users = $database->loadObjectList();
	$user = $users[0];
	
	$user->age = cb_user_age($user->cb_birthday, $time_now);
	
	$user->registerDate = explode(' ', $user->registerDate);
	$user->registerDate = $user->registerDate[0];
	$user->registerDate = dateConverter($user->registerDate, 'Y-m-d', 'd.m.Y');

	HTML_cbe::realChat($user,$option,$submitvalue);

}

function doJSpassthrough($_js_call) {

	global $ueConfig, $enhanced_Config;
	global $mosConfig_live_site;
	$my	=& JFactory::getUser();
	$database = &JFactory::getDBO();
	$acl =& JFactory::getACL();

	$js_global_out = 'JS_CALL: '.$_js_call;
	
	switch($_js_call) {
		case "cbe_tb":
		 if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/_js_toolbox.php')) {
			include(JPATH_SITE.'/components/com_cbe/enhanced/_js_toolbox.php');
			$js_global_out = $js_cbe_toolbox;
		 }
		break;
		
		case "cbe_db":
		 if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/_js_datebox.php')) {
			include(JPATH_SITE.'/components/com_cbe/enhanced/_js_datebox.php');
			$js_global_out = $js_cbe_datebox;
		 }
		break;
		
		case "cbe_gce":
		 if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php')) {
			include(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php');
			$js_global_out = $js_cbe_geocoder_edit;
		 }
		break;
		
		case "cbe_gcm":
		 if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/_js_geocoder_usermap.php')) {
			include(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/_js_geocoder_usermap.php');
			$js_global_out = $js_cbe_UserMap;
		}
		break;
		
		case "none":
		 $js_global_out = 'Big Error';
		break;
	}

	$js_global_out = preg_replace('/(<script)(.*)>/','',$js_global_out);
	$js_global_out = preg_replace('/(<\/script>)/','',$js_global_out);

	header("Content-Type: text/plain");
	header("Content-length: ".strlen($js_global_out));
	echo $js_global_out;
	
}

function cbe_version() {
	global $ueConfig;
	
	echo "Version: ".$ueConfig['version']."<br>";
}
		

?>

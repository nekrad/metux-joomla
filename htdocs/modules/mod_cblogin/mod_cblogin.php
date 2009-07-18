<?php
/**
* Community builder Login Module 1.1
* $Id: mod_cblogin.php 531 2006-11-12 01:40:44Z beat $
*
* @version 1.1
* @package Community Builder 1.0.2 extensions
* @copyright (C) 2005-2006 Beat & JoomlaJoe & parts 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* Credits to: Jeffrey Randall for initial implementation of avatar, and
* to Antony Ventouris for the PMS integration (he also added the cool animated image)
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $ueConfig, $my, $mosConfig_lang, $mainframe, $mosConfig_live_site, $_SERVER, $Itemid;

$absolute_path	=	$mainframe->getCfg('absolute_path');

$len_live_site	=	strlen($mosConfig_live_site);		// do not remove: used further down as well
// variant 1: (13 lines up to variant 2):
$request_uri	=	mosGetParam( $_SERVER, 'REQUEST_URI', null );
$isHttps		=	(isset($_SERVER['HTTPS']) && ( !empty( $_SERVER['HTTPS'] ) ) && ($_SERVER['HTTPS'] != 'off') );
if (!(strncmp($request_uri, "http:", 5)==0) && !(strncmp($request_uri, "https:", 6)==0)) {
	$return = "http".( $isHttps ?"s":"")
			."://".mosGetParam( $_SERVER, 'HTTP_HOST', null ).((strpos($request_uri, '/') !== 0) ? "/":"").$request_uri;
} else {
	$return = $request_uri;
}
if (strncmp($mosConfig_live_site, $return, $len_live_site) == 0) {
	$return = substr($return, $len_live_site);
	if (strncmp($return,"/",1) == 0) {
		$return = substr($return, 1);
	}
}
// variant 2: 1 line:
// $return = 'index.php?' . mosGetParam( $_SERVER, 'QUERY_STRING', '' );

// avoid unauthorized page acces at very first login after registration confirmation
if (eregi( 'index.php\?option=com_comprofiler&task=confirm&confirmCode=', $return)) $return = "index.php";
// converts & to &amp; for xhtml compliance
$return = str_replace( '&', '&amp;', $return );

// copied from comprofiler.class.php:
if (!is_callable("cbLoginCheckJversion")) {
	function cbLoginCheckJversion() {
		global $_VERSION;
		if ($_VERSION->PRODUCT == "Mambo") {
			if ( strncasecmp( $_VERSION->RELEASE, "4.6", 3 ) < 0 ) {
				$version = 0;
			} else {
				$version = -1;
			}
		} elseif ($_VERSION->PRODUCT == "Joomla!" || $_VERSION->PRODUCT == "Accessible Joomla!") {
			if (strncasecmp($_VERSION->RELEASE, "1.0", 3)) {
				$version = 1;
			} else {
				$version = 0;
			}
		}
		return $version;
	}
}

// module parameter may override the system configuration setting
if ( cbLoginCheckJversion() == 1 ) {
	$usersConfig = &JComponentHelper::getParams( 'com_users' );
	$registration_enabled	=	$usersConfig->get('allowUserRegistration');
} else {
	$registration_enabled	=	$mainframe->getCfg( 'allowUserRegistration' );
}
if (is_callable(array($params,"get"))) {				// Mambo 4.5.0 compatibility
	$message_login 	= $params->def( 'login_message', 0 );
	$message_logout = $params->def( 'logout_message', 0 );
	$pretext 		= $params->get( 'pretext' );
	$posttext 		= $params->get( 'posttext' );
	$login 			= $params->def( 'login', $return );
	$logout 		= $params->def( 'logout', "index.php" );
	if ( cbLoginCheckJversion() == 1 && ( $logout == "index.php" ) ) {
		$logout		= "index.php?option=com_content&view=frontpage&Itemid=1";	// 1.5 RC 1 sefRelToAbs bug fix
	}
	$name 			= $params->def( 'name', 0 );
	$greeting 		= $params->def( 'greeting', 1 );
	$class_sfx		= $params->get( 'moduleclass_sfx', "");
	$horizontal		= $params->get( 'horizontal', 0);
	$show_avatar	= $params->get( 'show_avatar', 0);
	$avatar_position = $params->get( 'avatar_position', "default");
	$pms_type		= $params->get( 'pms_type', 0);
	$show_pms		= $params->get( 'show_pms', 0);
	$remember_enabled = $params->get( 'remember_enabled', 1);
	$https_post		= $params->get( 'https_post', 0);
	$showPendingConnections = $params->get( 'show_connection_notifications', 0);
	$show_newaccount = $params->def( 'show_newaccount', 1 );
	$show_lostpass 	= $params->def( 'show_lostpass', 1 );
	$name_lenght 	= $params->def( 'name_lenght', "10" );
	$pass_lenght 	= $params->def( 'pass_lenght', "10" );
	$compact 		= $params->def( 'compact', 0 );
} else {
	$message_login 	= 0;
	$message_logout = 0;
	$pretext 		= "";
	$posttext 		= "";
	$login 			= $return;
	$logout 		= "index.php";
	$name 			= 0;
	$greeting 		= 1;
	$class_sfx		= "";
	$horizontal		= 0;
	$show_avatar	= 0;
	$avatar_position = "default";
	$pms_type		= 0;
	$show_pms		= 0;
	$remember_enabled = 1;
	$https_post		= 0;
	$showPendingConnections = 0;
	$show_newaccount = 1;
	$show_lostpass 	= 1;
	$name_lenght 	= "10";
	$pass_lenght 	= "10";
}

if ($name) {
	if ($name == 2) {
		$query = "SELECT firstname FROM #__comprofiler WHERE id = ". $my->id;
	} else {
		$query = "SELECT name FROM #__users WHERE id = ". $my->id;
	}
	$database->setQuery( $query );
	$name = htmlspecialchars($database->loadResult());
} else {
	$name = htmlspecialchars($my->username);
}

if ((($my->id) && ($show_pms != 0 || $show_avatar != 0 || $showPendingConnections)) ||
	((!$my->id) && $compact)) {
	$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
	if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php')) {
		include_once($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php');
	} else include_once($UElanguagePath.'/default_language/default_language.php');
}

if ($my->id) {
	$logout = sefRelToAbs( htmlspecialchars( $logout ) );
	if (!(strncmp($logout, "http:", 5)==0) && !(strncmp($logout, "https:", 6)==0)) $logout = $mosConfig_live_site . "/" . $logout;

	$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1");
	$cbItemid = $database->loadResult();
	if (is_numeric($cbItemid)) $andItemid = "&amp;Itemid=".$cbItemid;
	else $andItemid = "";

	switch ( cbLoginCheckJversion() ) {
	 	case 0:
		// Mambo 4.5 & Joomla 1.0:
			$urlImgPath = $mosConfig_live_site."/modules/mod_cblogin/";
			$hiName		= _HI."%s";	 		
	 		break;
	 	case -1:
		// Mambo 4.6.x:
			$urlImgPath = $mosConfig_live_site."/modules/mod_cblogin/";
			$hiName		= T_('Hi, %s');
			if (!defined('_BUTTON_LOGOUT')) {
				define( '_BUTTON_LOGOUT', T_('Logout'));
			}
			global $mosConfig_locale;
			$mosConfig_lang	=	$mosConfig_locale;
			break;
	 	case 1:
	 	default:
		// Joomla 1.5+
			$urlImgPath = $mosConfig_live_site."/modules/mod_cblogin/mod_cblogin/";
			$lang =& JFactory::getLanguage();
			$lang->load("mod_login");
			$hiName		= JText::_( 'HINAME' );
			if (!defined('_BUTTON_LOGOUT')) {
				define( '_BUTTON_LOGOUT', JText::_( '_BUTTON_LOGOUT' ));
			}
	 		break;
	 }
	echo '<div style="width:100%; overflow: hidden; padding:0px; border-width:0px; margin:0px;">'."\n";

	$logoutPost = sefRelToAbs("index.php?option=com_comprofiler&amp;task=logout");
	echo '<form action="'.$logoutPost.'" method="post" id="mod_login_logoutform'.$class_sfx.'" style="margin:0px;">'."\n";

	$avatarDisplayed = false;
	if ($show_avatar == 0) {
		if ($greeting) echo '<span id="mod_login_greeting'.$class_sfx.'">'.sprintf( $hiName, $name ).'</span>'.($horizontal ? "&nbsp;" : "");
	} else {
		
		if (($avatar_position=="default") and ($greeting)) echo '<span id="mod_login_greeting'.$class_sfx.'">'.sprintf( $hiName, $name ).'</span>';

		$query = "SELECT avatar, avatarapproved FROM #__comprofiler WHERE id = ". $my->id;
		$database->setQuery( $query );
		$row = null;
		if ($database->loadObject( $row )) {
			$avatar			= $row->avatar;
			$avatarapproved	= $row->avatarapproved;
			
			if(is_dir($absolute_path."/components/com_comprofiler/plugin/language/".$mosConfig_lang."/images")) $fileLang=$mosConfig_lang;
			else $fileLang="default_language";
			
			if($avatarapproved==0) $oValue="components/com_comprofiler/plugin/language/".$fileLang."/images/tnpendphoto.jpg";
			elseif(($avatar=='' || $avatar==null) && $avatarapproved==1) $oValue = null;
			elseif(strpos($avatar,"gallery/")===false) $oValue="images/comprofiler/tn".$avatar;
			else $oValue="images/comprofiler/".$avatar;
			if(!is_file($absolute_path."/".$oValue)) $oValue = null;

			if (!$oValue and ($show_avatar==2)) $oValue = "components/com_comprofiler/plugin/language/".$fileLang."/images/tnnophoto.jpg";
			
			if ($oValue) {
				if ($class_sfx == "") {
					$attributes = 'style="margin: 3px 1px 7px 1px; border:0;'
					  . (($avatar_position == "left" or $avatar_position == "right") ? ' float:'.$avatar_position.';"' : '"' );
				} else $attributes = "";

				if ($avatar_position=="default") echo '<div style="text-align:center; margin-left:auto; margin-right:auto;">';
				else echo '<div style="float:'.$avatar_position.'; margin: 3px 0px 4px 0px; ">';
				echo '<a href="'.sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile".$andItemid).'" class="mod_login'.$class_sfx.'">';		
				echo '<img src="' . htmlspecialchars( $oValue ) . '" style="margin: 0px 1px 3px 1px; border-width:0px;" alt="'.$name
					 . '" title="'._UE_SHOW_POFILE_OF.$name.'" class="mod_login'.$class_sfx.'" id="mod_login_avatar'.$class_sfx.'" />';
				echo "</a></div>\n";
				$avatarDisplayed = true;
			}
		}
	}

	if ( !$horizontal ) {
		$preDiv = '<div style="text-align:center; margin:0px auto;"> '
				. '<div style="margin:auto; align:center; width:100%;"> '
				. '<div style="display:table; margin:auto; align:center;';
		$postDiv = "</div></div></div>\n";
	}
	
	if ( $show_avatar and ($avatar_position!="default") and ($greeting) ) {
		if ($avatarDisplayed) {
			if ( !$horizontal ) echo $preDiv.'" id="mod_login_greeting'.$class_sfx.'">';
			/* if (!$show_pms) */ echo '<br />';
			echo sprintf( $hiName, '<br />'.$name );
			if ( !$horizontal ) echo $postDiv;
		} else {
			echo '<span id="mod_login_greeting'.$class_sfx.'">'.sprintf( $hiName, $name ).'</span>';
		}
	}
	
	$pms = 0;
	if($show_pms != 0) {
		// include_once( $absolute_path."/administrator/components/com_comprofiler/ue_config.php" );
		// if (isset($ueConfig['pms'])) $pms = $ueConfig['pms'];
		$pms = $pms_type;		// RC2 quick fix
		if($pms != 0)
		{
			switch ($pms) {
				case 1:
					$pmsnameprefix = "";
					$query_pms_count = "SELECT count(id) FROM #__".$pmsnameprefix."pms WHERE username='$my->username' AND readstate=0";
					$database->setQuery( $query_pms_count );
					$total_pms = $database->loadResult();
		
					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."pms%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_".$pmsnameprefix."pms&amp;page=index".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				case 2:
					$pmsnameprefix = "my";
					$query_pms_count = "SELECT count(id) FROM #__".$pmsnameprefix."pms WHERE username='$my->username' AND readstate=0";
					$database->setQuery( $query_pms_count );
					$total_pms = $database->loadResult();
		
					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."pms%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_".$pmsnameprefix."pms&amp;task=inbox".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				case 3:
					// $query_pms_count="SELECT count(id) FROM #__uddeim WHERE toread<1 AND toid=".$my->id;
					$query_pms_count="SELECT count(u.id) FROM #__uddeim u INNER JOIN #__users s ON u.fromid=s.id WHERE toread<1 AND toid=".$my->id;
					$database->setQuery($query_pms_count);
					$total_pms = $database->loadResult();	

					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_uddeim%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_uddeim&amp;task=inbox".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				case 4:		// PMS Enhanced by Stefan:
					$pmsnameprefix = "";
					$query_pms_count = "SELECT count(id) FROM #__".$pmsnameprefix."pms WHERE username='$my->username' AND readstate=0 AND inbox=1";
					$database->setQuery( $query_pms_count );
					$total_pms = $database->loadResult();
		
					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."pms%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_".$pmsnameprefix."pms&amp;page=inbox".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				case 5:		// Clexus:
					$pmsnameprefix = "my";
					$query_pms_count = "SELECT count(id) FROM #__".$pmsnameprefix."pms WHERE userid='$my->id' AND readstate=0";
					$database->setQuery( $query_pms_count );
					$total_pms = $database->loadResult();
		
					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."pms%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_".$pmsnameprefix."pms&amp;task=inbox".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				case 6:		// PMS Enhanced 2.x by Stefan:
					$pmsnameprefix = "";
					$query_pms_count = "SELECT count(id) FROM #__".$pmsnameprefix."pms WHERE recip_id=$my->id AND readstate%2=0 AND inbox=1";
					$database->setQuery( $query_pms_count );
					$total_pms = $database->loadResult();
		
					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."pms%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_".$pmsnameprefix."pms&amp;page=inbox".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				case 7:
					$pmsnameprefix="missus";
                    $query_pms_count = "SELECT COUNT(*) FROM #__missus AS m JOIN #__missus_receipt AS r WHERE m.id=r.id AND r.receptorid='$my->id' AND r.rptr_rstate=0 AND r.rptr_tstate=0 AND r.rptr_dstate=0 AND m.is_draft=0";
                    $database->setQuery( $query_pms_count );
                    $total_pms = $database->loadResult();
                    
                    $query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."%'";
                    $database->setQuery( $query_pms_link );
                    $pms_link_id = $database->loadResult();
                    $pms_link = "index.php?option=com_".$pmsnameprefix."&amp;func=showinbox".($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
                    break;
                case 8:
                	$pmsnameprefix="jim";
                	$query_pms_count = "SELECT COUNT(id) FROM #__jim WHERE username='$my->username' AND readstate=0";
                    $database->setQuery( $query_pms_count );
                    $total_pms = intval($database->loadResult());

					$query_pms_link = "SELECT id FROM #__menu WHERE published>=0 AND link LIKE '%com_".$pmsnameprefix."%'";
					$database->setQuery( $query_pms_link );
					$pms_link_id = $database->loadResult();
					$pms_link = "index.php?option=com_".$pmsnameprefix.($pms_link_id ? "&amp;Itemid=".$pms_link_id : "");
					break;
				/* Test-code for SMF PMS integration: to be validated with SMF team before integration !
				case xxx:
					global $user_info;
					$total_pms = $user_info['unread_messages'];
					$pms_link = ???
				*/
				default:
					break;
			}

			$pmsMsg = "";
			if (($total_pms) > 0 ) {
				$pmsMsg .= '<a href="'.sefRelToAbs("$pms_link").'" class="mod_login'.$class_sfx.'" id="mod_login_pmsimg'.$class_sfx.'">';
				$pmsMsg .= '<img border="0" src="'.$urlImgPath.'mail.gif" width="14" height="15" alt="NEW" class="mod_login'.$class_sfx.'" id="mod_login_messagesimg'.$class_sfx.'" /></a><br />'."\n";
				$pmsMsg .= '<a href="'.sefRelToAbs("$pms_link").'" class="mod_login'.$class_sfx.'" id="mod_login_pmsa'.$class_sfx.'">';
				$pmsMsg .= '<span id="mod_login_messagestext'.$class_sfx.'">'._UE_PM_MESSAGES_HAVE." ".$total_pms."&nbsp;".($total_pms == 1 ? _UE_PM_NEW_MESSAGE : _UE_PM_NEW_MESSAGES)."</span></a>\n";
			} else {
				if($show_pms >= 2 ) {
					$pmsMsg .= '<a href="'.sefRelToAbs("$pms_link").'" class="mod_login'.$class_sfx.'" id="mod_login_no_pms'.$class_sfx.'">';
					$pmsMsg .= '<span id="mod_login_nomessagestext'.$class_sfx.'">'._UE_PM_NO_MESSAGES."</span></a>\n";
				}
			}
			if ($pmsMsg) {
				if ( !$horizontal ) echo $preDiv.' margin-top:0.7em;" id="mod_login_pms'.$class_sfx.'">';
				echo $pmsMsg;
				if ( !$horizontal ) echo $postDiv;
			}
		}
	}

	if($showPendingConnections) {
		include_once( $absolute_path."/administrator/components/com_comprofiler/ue_config.php" );
		if(isset($ueConfig['allowConnections']) && $ueConfig['allowConnections']) {
			$query = "SELECT count(*) FROM #__comprofiler_members WHERE pending=1 AND memberid=". $my->id;
			if(!$database->setQuery($query)) print $database->getErrorMsg();
			$totalpendingconnections = $database->loadResult();
			if($totalpendingconnections > 0) {
				if ( !$horizontal ) echo '<div style="margin:0.7em 0px 0px 0px; align:center; text-align:center;" id="mod_login_connections'.$class_sfx.'">';
				echo "<span id='mod_login_pendingConn".$class_sfx."'>";
				echo "<a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=manageConnections".$andItemid)."' class='mod_login".$class_sfx."' id='mod_login_connectimg".$class_sfx."'>";
				echo '<img border="0" src="'.$urlImgPath.'users.gif" width="21" height="15" alt="NEW" class="mod_login'.$class_sfx.'" id="mod_login_connections_img'.$class_sfx.'" />';
				echo "</a> ";
				echo "<a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=manageConnections".$andItemid)."' class='mod_login".$class_sfx."' id='mod_login_connect".$class_sfx."'>";
				echo _UE_PM_MESSAGES_HAVE." ".$totalpendingconnections."&nbsp;"._UE_CONNECTIONREQUIREACTION."</a></span>";
				if ( !$horizontal ) echo "</div>";
			}
		}
	}

	if (!$horizontal) {
		if ((!$avatarDisplayed) or ($avatar_position!="default") or ($pms)) $topMargin = "1.4em";
		else $topMargin = "2px";
		echo '<div style="text-align:center; margin:auto; margin: '.$topMargin.' 0px 2px 0px;">';
	}
	echo '<input type="submit" name="Submit" class="button'.$class_sfx.'" value="'._BUTTON_LOGOUT."\" />";
	echo "\n".'<input type="hidden" name="op2" value="logout" />'."\n";
	echo '<input type="hidden" name="lang" value="'.$mosConfig_lang.'" />'."\n";
	echo '<input type="hidden" name="return" value="' . $logout . '" />'."\n";
	echo '<input type="hidden" name="message" value="' . htmlspecialchars( $message_logout ) . '" />'."\n";
	if ( is_callable("josSpoofValue")) {
		$validate = josSpoofValue();
		echo "<input type=\"hidden\" name=\"" .  $validate . "\" value=\"1\" />\n";
	}
	if ( !$horizontal ) echo "</div>";
	echo "</form></div>";

} else {	// Login Form :
	// redirect to site url (so cookies are recognized correctly after login):
	if (strncasecmp($mosConfig_live_site, "http://www.", 11)==0 && strncasecmp($mosConfig_live_site, "http://", 7)==0
		&& strncasecmp( substr($mosConfig_live_site, 11), substr($login, 7), $len_live_site - 11 ) == 0 ) {
			$login = "http://www." . substr($login, 7);
	} elseif (strncasecmp($mosConfig_live_site, "https://www.", 12)==0 && strncasecmp($mosConfig_live_site, "https://", 8)==0
		&& strncasecmp( substr($mosConfig_live_site, 12), substr($login, 8), $len_live_site - 12 ) == 0 ) {
			$login = "https://www." . substr($login, 8);
	} elseif (strncasecmp($mosConfig_live_site, "http://", 7)==0 && strncasecmp($mosConfig_live_site, "http://www.", 11)==0
		&& strncasecmp( substr($mosConfig_live_site, 7), substr($login, 11), $len_live_site - 7 ) == 0 ) {
			$login = "http://" . substr($login, 11);
	} elseif (strncasecmp($mosConfig_live_site, "https://", 8)==0 && strncasecmp($mosConfig_live_site, "https://www.", 12)==0
		&& strncasecmp( substr($mosConfig_live_site, 8), substr($login, 12), $len_live_site - 8 ) == 0 ) {
			$login = "https://" . substr($login, 12);
	}

	if (strncmp($login, $mosConfig_live_site, $len_live_site) || strncmp($login, "index.php", 9)) {
		$login = sefRelToAbs( $login );
	}
	if (!(strncmp($login, "http:", 5)==0) && !(strncmp($login, "https:", 6)==0)) $login = $mosConfig_live_site . "/" . $login;

	if ( $https_post > 1 /* && ! $isHttps */ ) {
		$login = str_replace("http://","https://",$login);
	}

	$loginPost = sefRelToAbs("index.php?option=com_comprofiler&amp;task=login");
	if ( $https_post /* && ! $isHttps */ ) {
		if ( ( substr($loginPost, 0, 5) != "http:" ) && ( substr($loginPost, 0, 6) != "https:" ) ) {
			$loginPost = $mosConfig_live_site."/".$loginPost;
		}
		$loginPost = str_replace("http://","https://",$loginPost);
	}
	switch ( cbLoginCheckJversion() ) {
	 	case -1:
		// Mambo 4.6.x:
			if (!defined('_USERNAME')) {
				$strings = array(	'_USERNAME'			=> 'Username',
									'_PASSWORD' 		=> 'Password',
									'_REMEMBER_ME'		=> 'Remember me',
									'_BUTTON_LOGIN'		=> 'Login',
									'_LOST_PASSWORD'	=> 'Password Reminder',
									'_NO_ACCOUNT'		=> 'No account yet?',
									'_CREATE_ACCOUNT'	=> 'Create one' );
				foreach ( $strings as $key => $value ) {
					define( $key, T_( $value ));
				}
			}
			global $mosConfig_locale;
			$mosConfig_lang	=	$mosConfig_locale;
			break;
	 	case 1:
		// Joomla 1.5+
			if (!defined('_USERNAME')) {
				$lang =& JFactory::getLanguage();
				$lang->load("mod_login");
				$strings = array(	'_USERNAME'			=> 'Username',
									'_PASSWORD' 		=> 'Password',
									'_REMEMBER_ME'		=> 'Remember me',
									'_BUTTON_LOGIN'		=> 'BUTTON_LOGIN',
									'_LOST_PASSWORD'	=> 'Lost Password?',
									'_NO_ACCOUNT'		=> 'No account yet?',
									'_CREATE_ACCOUNT'	=> 'Register' );
				foreach ( $strings as $key => $value ) {
					define( $key, JText::_( $value ));
				}
			}
			break;
	 	default:
	 		break;
	}

	echo '<form action="'.$loginPost.'" method="post" id="mod_loginform'.$class_sfx.'" ';
/*
	if ($compact) {
		echo "onsubmit=\""
			. "return ( ( this.elements['mod_login_username" . $class_sfx . "'].value != '"._USERNAME."')"
			. "&& ( this.elements['mod_login_password" . $class_sfx . "'].value != 'pasw') )"
			."\" ";
	}
*/
	echo 'style="margin:0px;">'."\n";
	echo $pretext."\n";
	if (!$horizontal) echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_login'.$class_sfx.'">'."\n"
						."<tr><td>";

	$txtusername = '<label for="mod_login_username'.$class_sfx.'">'._USERNAME."</label>";
	$txtpassword = '<label for="mod_login_password'.$class_sfx.'">'._PASSWORD."</label>";
	
	if (!$compact)	 echo '<span id="mod_login_usernametext'.$class_sfx.'">'.$txtusername.'</span>';
	if ($horizontal) echo "&nbsp;\n"; elseif (!$compact) echo "<br />\n";
	echo '<input type="text" name="username" id="mod_login_username'.$class_sfx.'" class="inputbox'.$class_sfx.'" size="'.$name_lenght.'"';
	if ($compact)	 echo " alt=\""._USERNAME."\" value=\""._USERNAME."\" "
						. "onfocus=\"if (this.value=='"._USERNAME."') this.value=''\" onblur=\"if(this.value=='') { this.value='"._USERNAME."'; return false; }\"";
 	echo ' />';
	if ($horizontal) echo "&nbsp;\n"; elseif (!$compact) echo "<br />\n";
	if (!$compact)	 echo '<span id="mod_login_passwordtext'.$class_sfx.'">'.$txtpassword.'</span>';
	if ($horizontal) echo "&nbsp;"; else echo "<br />";
	echo '<input type="password" name="passwd" id="mod_login_password'.$class_sfx.'" class="inputbox'.$class_sfx.'" size="'.$pass_lenght.'"';
	if ($compact)	 echo " alt=\""._PASSWORD."\" value=\"pasw\" onfocus=\"if (this.value=='pasw') this.value=''\" onblur=\"if(this.value=='') { this.value='pasw'; return false; }\"";
 	echo ' />';
	if ($horizontal) echo "&nbsp;\n"; else echo "<br />\n";

	echo '<input type="hidden" name="op2" value="login" />'."\n";
	echo '<input type="hidden" name="lang" value="'.$mosConfig_lang.'" />'."\n";
	echo '<input type="hidden" name="force_session" value="1" />'."\n";		// makes sure to create joomla 1.0.11+12 session/bugfix
	echo '<input type="hidden" name="return" value="' . htmlspecialchars( $login ) . '" />'."\n";
	echo '<input type="hidden" name="message" value="' . htmlspecialchars( $message_login ) . '" />'."\n";
	if ( is_callable("josSpoofValue")) {
		$validate = josSpoofValue();
		echo "<input type=\"hidden\" name=\"" .  $validate . "\" value=\"1\" />\n";
	}

	switch ($remember_enabled) {
		case 1:
			echo '<input type="checkbox" name="remember" id="mod_login_remember'.$class_sfx.'" class="inputbox'.$class_sfx.'" value="yes" /> '
				.'<span id="mod_login_remembermetext'.$class_sfx.'"><label for="mod_login_remember'.$class_sfx.'">'._REMEMBER_ME."</label></span>";
			if ($horizontal) echo "&nbsp;\n"; else echo "<br />\n";
		break;
		case 2:
			echo '<input type="hidden" name="remember" value="yes" />';
		break;
		case 3:
			echo '<input type="checkbox" name="remember" id="mod_login_remember'.$class_sfx.'" class="inputbox'.$class_sfx.'" value="yes" checked="checked" /> '
				.'<span id="mod_login_remembermetext'.$class_sfx.'"><label for="mod_login_remember'.$class_sfx.'">'._REMEMBER_ME."</label></span>";
			if ($horizontal) echo "&nbsp;\n"; else echo "<br />\n";
		break;
		default:
		break;
	}
	echo '<input type="submit" name="Submit" class="button'.$class_sfx.'" value="'._BUTTON_LOGIN.'" />';
	if ($horizontal) echo "&nbsp;&nbsp;\n"; else echo "</td></tr>\n<tr><td>";
	
	if ($show_lostpass) {
		$loginPost = sefRelToAbs("index.php?option=com_comprofiler&amp;task=lostPassword");
		if ( $https_post /* && ! $isHttps */ ) {
			if ( ( substr($loginPost, 0, 5) != "http:" ) && ( substr($loginPost, 0, 6) != "https:" ) ) {
				$loginPost = $mosConfig_live_site."/".$loginPost;
			}
			$loginPost = str_replace("http://","https://",$loginPost);
		}
		echo '<a href="'.$loginPost.'" class="mod_login'.$class_sfx.'">';
		if ($compact) echo _UE_FORGOT_PASSWORD;	
		else echo _LOST_PASSWORD;
		echo '</a>';
		if ($horizontal) {
			if ($compact) echo "&nbsp;|";
			else echo "&nbsp;\n"; 
		} else echo "</td></tr>\n";
	}
	if ( ! $registration_enabled ) {
		include_once( $absolute_path."/administrator/components/com_comprofiler/ue_config.php" );
		if ( isset($ueConfig['reg_admin_allowcbregistration']) && $ueConfig['reg_admin_allowcbregistration'] == '1' ) {
			$registration_enabled = true;
		}
	}
	if ($registration_enabled && $show_newaccount) {
		if ($horizontal) echo '&nbsp;<span id="mod_login_noaccount'.$class_sfx.'">'; else echo "<tr><td>";
		if (!$compact)	 echo _NO_ACCOUNT." ";
		$loginPost = sefRelToAbs("index.php?option=com_comprofiler&amp;task=registers");
		if ( $https_post /* && ! $isHttps */ ) {
			if ( ( substr($loginPost, 0, 5) != "http:" ) && ( substr($loginPost, 0, 6) != "https:" ) ) {
				$loginPost = $mosConfig_live_site."/".$loginPost;
			}
			$loginPost = str_replace("http://","https://",$loginPost);
		}
		echo '<a href="'.$loginPost.'" class="mod_login'.$class_sfx.'">';
		if ($compact) echo _UE_REGISTER;
		else echo _CREATE_ACCOUNT;
		echo '</a>';
		if ($horizontal) echo "</span>\n"; else echo "</td></tr>\n";
	}
	if (!$horizontal) echo "</table>";
	if ($posttext) echo $posttext."\n";
	echo "</form>";
}
?>

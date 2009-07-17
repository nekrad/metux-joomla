<?php
/**
* Core plugin with tab classes for: Portrait and Contact Tabs for handling the core CB tab api
* @version $Id: cb.core.php 609 2006-12-13 17:30:15Z beat $
* @package Community Builder
* @subpackage Page Title, Portrait, Contact tabs CB core plugin
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com and various
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Tab Class for User Profile Page title display
* @package Community Builder : cb.core pluing
* @subpackage Page Title tab CB core module
* @author JoomlaJoe and Beat
*/
class getPageTitleTab  extends cbTabHandler {
	/**
	* Constructor
	*/
	function getPageTitleTab() {
		$this->cbTabHandler();
	}
	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) {
		global $ueConfig;
		// Display user's name + "Profile Page"
		$params=$this->params;
		$title=getLangDefinition($params->get('title', '_UE_PROFILE_TITLE_TEXT'));
		$name = getNameFormat($user->name,$user->username,$ueConfig['name_format']);
		$return = '<div class="contentheading" id="cbProfileTitle">' . sprintf($title, $name) . "</div>\n";
		
		$return .= $this->_writeTabDescription( $tab, $user );
		
		return $return;
	}
}	// end class getPageTitleTab

/**
* Tab Class for User Profile Portrait/Avatar display
* @package Community Builder : cb.core pluing
* @subpackage Portrait tab CB core module
* @author JoomlaJoe and Beat
*/
class getPortraitTab  extends cbTabHandler {
	/**
	* Constructor
	*/
	function getContactTab() {
		$this->cbTabHandler();
	}
	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) {
		global $ueConfig, $mosConfig_lang, $my;
		
		$params		=	$this->params;
		
		// Display Avatar/Image:
		$return		=	"";
		if ( $ueConfig['allowAvatar'] == '1' ) {

			$cbMyIsModerator	=	isModerator( $my->id );
			if ( $params->get( 'portrait_descrPos', 'above' ) == "above" ) {
				$return		.=	$this->_writeTabDescription( $tab, $user, 'cbPortraitDescription' );
			}

			$name			=	htmlspecialchars(getNameFormat($user->name,$user->username,$ueConfig['name_format']));
			$return			.=	"\n\t\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>";
			$uimage			=	$user->avatar;
			if ( file_exists( "components/com_comprofiler/plugin/language/".$mosConfig_lang."/images" ) ) {
				$uimagepath	=	"components/com_comprofiler/plugin/language/".$mosConfig_lang."/images/";
			} else {
				$uimagepath	=	"components/com_comprofiler/plugin/language/default_language/images/";
			}
			if ( $user->avatarapproved == 0 ) {
				$uimage		=	$uimagepath."pendphoto.jpg";
			} elseif ( $user->avatar == '' || $user->avatar == null ) {
				$uimage		=	$uimagepath."nophoto.jpg";
			}
			else {
				$uimage		=	"images/comprofiler/".$uimage;
			}
			$return			.=	"<td align=\"center\" width=\"100%\"><img src=\"".sefRelToAbs($uimage)."\" alt=\"".$name."\" title=\"".$name."\" /></td>";
			if ( $user->avatarapproved == 0 && $cbMyIsModerator ) {
				$uimage		=	"images/comprofiler/".$user->avatar;
				$return		.=	"<td align=\"center\" width=\"100%\">"._UE_IMAGE_ADMIN_SUB.":<br /><br />"
							.	"<img src=\"".$uimage."\" alt=\"".$name."\" title=\"".$name."\" /></td>";
			}
			$return .= "</tr></table>";
			
			if ( $params->get( 'portrait_descrPos', 'above' ) == "below" ) {
				$return .= $this->_writeTabDescription( $tab, $user, 'cbPortraitDescription' );
			}

		}
		return $return;
	}
}	// end class getPortraitTab

/**
* Tab Class for User Profile EDIT Contacts special fields display
* @package Community Builder : cb.core pluing
* @subpackage Contact tab CB core module
* @author JoomlaJoe and Beat
*/
class getContactTab extends cbTabHandler {
	/**
	* Constructor
	*/
	function getContactTab() {
		$this->cbTabHandler();
	}
	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) {		
	}
	/**
	* Generates the HTML to display the user edit tab
	* @param  moscomprofilerTab  $tab   reflecting the tab database entry
	* @param  mosUser            $user  + moscomprofiler: reflecting the user being displayed
	* @param  int                $ui    1 for front-end, 2 for back-end
	* @return mixed              either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getEditTab($tab,$user,$ui) {
		global $ueConfig, $acl, $my, $_CB_framework, $_PLUGINS;

		if (class_exists("JFactory")) {						// Joomla 1.5 :
			// if ($ui == 2) {
				//load common language files
				$lang =& JFactory::getLanguage();
				$lang->load("com_users");
			// }
		}
		
		$return="";
		$return .= "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n";

		$return .= $this->_writeTabDescription( $tab, $user );

		SWITCH($ueConfig["name_style"]) {
			case 2:
				$return .= "		<tr>\n";
				$return .= "			<td class=\"titleCell\">"._UE_YOUR_FNAME.":</td>\n";
				$return .= "			<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" size=\"40\" mosReq=\"1\" mosLabel=\""._UE_YOUR_FNAME."\" id=\"firstname\" name=\"firstname\" value=\"".htmlspecialchars($user->firstname)."\" />";
				$return .= getFieldIcons($ui, true,($ueConfig["name_format"]!=3));
				$return .= "		</td></tr>\n";
				$return .= "		<tr>\n";
				$return .= "			<td class=\"titleCell\">"._UE_YOUR_LNAME.":</td>\n";
				$return .= "			<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" size=\"40\" mosReq=\"1\" mosLabel=\""._UE_YOUR_LNAME."\" id=\"lastname\" name=\"lastname\" value=\"".htmlspecialchars($user->lastname)."\" />";
				$return .= getFieldIcons($ui, true,($ueConfig["name_format"]!=3));
				$return .= "		</td></tr>\n";
			break;
			case 3:
				$return .= "		<tr>\n";
				$return .= "			<td class=\"titleCell\">"._UE_YOUR_FNAME.":</td>\n";
				$return .= "			<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" size=\"40\" mosReq=\"1\" mosLabel=\""._UE_YOUR_FNAME."\" id=\"firstname\" name=\"firstname\" value=\"".htmlspecialchars($user->firstname)."\" />";
				$return .= getFieldIcons($ui, true,($ueConfig["name_format"]!=3));
				$return .= "		</td></tr>\n";
				$return .= "<tr>\n";
				$return .= "	<td class=\"titleCell\">"._UE_YOUR_MNAME.":</td>\n";
				$return .= "	<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" size=\"40\" mosReq=\"0\" mosLabel=\""._UE_YOUR_MNAME."\" id=\"middlename\" name=\"middlename\" value=\"".htmlspecialchars($user->middlename)."\" />\n";
				$return .= getFieldIcons($ui, false,($ueConfig["name_format"]!=3));
				$return .= "		</td></tr>\n";
				$return .= "		<tr>\n";
				$return .= "			<td class=\"titleCell\">"._UE_YOUR_LNAME.":</td>\n";
				$return .= "			<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" size=\"40\" mosReq=\"1\" mosLabel=\""._UE_YOUR_LNAME."\" id=\"lastname\" name=\"lastname\" value=\"".htmlspecialchars($user->lastname)."\" />";
				$return .= getFieldIcons($ui, true,($ueConfig["name_format"]!=3));
				$return .= "		</td></tr>\n";
			break;
			DEFAULT:
				$return .= "<tr>\n";
				$return .= "	<td class=\"titleCell\">"._UE_YOUR_NAME.":</td>\n";
				$return .= "	<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" size=\"40\" id=\"name\" name=\"name\" mosReq=\"1\" mosLabel=\"Name\"  value=\"".htmlspecialchars($user->name)."\" />";
				$return .= getFieldIcons($ui, true,($ueConfig["name_format"]!=3));
				$return .= "</td></tr>\n";
			break;
		}
		$return .= "		<tr>\n";
		$return .= "			<td class=\"titleCell\">"._UE_UNAME.":</td>\n";
		$return .= "			<td class=\"fieldCell\">";
		IF(($ueConfig["usernameedit"]==1) or ($user->username=="") or ($ui == 2)) { 
			$return .= "<input class=\"inputbox\" type=\"text\" size=\"40\" id=\"username\" name=\"username\" value=\"".htmlspecialchars($user->username)."\" />";
			$return .= getFieldIcons($ui, true,($ueConfig["name_format"]!=1),sprintf( _VALID_AZ09, _UE_UNAME, 2 ) , _UE_UNAME.":");

			$_PLUGINS->loadPluginGroup('user');
			$usernameSpecialsResults	=	$_PLUGINS->trigger( 'onUsernameSpecials', array( $ui, $user->id ) );
			if ( is_array( $usernameSpecialsResults ) ) {
				$return	.=	' ' . implode( ' ', $usernameSpecialsResults );
			}

		} else {
			$return .= $user->username;
			$return .= "<input class=\"inputbox\" type=\"hidden\" name=\"username\" value=\"".htmlspecialchars($user->username)."\" />";
		}
		$return .= "\n</td>\n</tr>\n";
	
		$return .= "<tr>\n";
		$return .= "	<td class=\"titleCell\">"._UE_EMAIL.":</td>\n";
		$return .= "	<td class=\"fieldCell\"><input class=\"inputbox\" type=\"text\" id=\"email\" name=\"email\" mosReq=\"1\" mosLabel=\"Email\" value=\"".htmlspecialchars($user->email)."\" size=\"40\" />";
		$return .= getFieldIcons($ui, true,($ueConfig["allow_email_display"]==1 || $ueConfig["allow_email_display"]==2), _REGWARN_MAIL, _UE_EMAIL.":");
		$return .= "</td></tr>\n";
		$return .= "<tr>\n";
		$return .= "	<td class=\"titleCell\">"._UE_PASS.":</td>\n";
		$return .= "	<td class=\"fieldCell\"><input class=\"inputbox\" type=\"password\" size=\"40\" id=\"password\" name=\"password\" value=\"\" autocomplete=\"off\" />";
		$return .= getFieldIcons($ui, false, false, sprintf( _VALID_AZ09, _UE_PASS, 6 ), _UE_PASS.":");
		$return .= "</td>\n</tr>\n";
		$return .= "<tr>\n";
		$return .= "	<td class=\"titleCell\">"._UE_VPASS.":</td>\n";
		$return .= "	<td class=\"fieldCell\"><input class=\"inputbox\" type=\"password\" size=\"40\" id=\"verifyPass\" name=\"verifyPass\" autocomplete=\"off\" />";
		$return .= getFieldIcons($ui, false, false);
		$return .= "</td>\n</tr>\n";
		
		//Implementing Joomla's new user parameters such as editor
		$userParams = array();
		$userParams = $this->_getUserParams($ui, $user);		

		if ( ( count( $userParams ) > 0 ) && in_array( $_CB_framework->getCfg( "frontend_userparams" ), array( '1', null) ) ) {
			//Loop through each parameter and render it appropriately.
			foreach($userParams AS $userParam) {
				$return .= "<tr>\n";
				$return .= "<td class=\"titleCell\">" . $userParam[0] . ":</td>\n";
				$return .= "<td class=\"fieldCell\">" . $userParam[1];
				$return .= getFieldIcons($ui, false, false, (isset($userParam[2]) && class_exists("JText") ? JText::_($userParam[2]) : null), (isset($userParam[3]) && class_exists("JText") ? JText::_($userParam[3]) : null));
				$return .= "</td></tr>\n";	
			}
		}
		if($ui==2) {
			$myGid			=	userGID( $my->id );
			$canBlockUser	= $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'user properties', 'block_user' );
			$canEmailEvents	=  ( ( $user->id == 0 ) && ( in_array( $myGid, array( 24, 25 ) ) ) )
							|| $acl->acl_check( 'workflow', 'email_events', 'users', $acl->get_group_name( $user->gid, 'ARO' ) )
							|| in_array( $user->gid, getParentGIDS( $ueConfig['imageApproverGid'] ) );	// allow also CB isModerator
			$lists = array();
			$user_group = strtolower( $acl->get_group_name( $user->gid, 'ARO' ) );
			if (( $user_group == 'super administrator' && $myGid != 25) || ( $user->id == $my->id && $myGid == 25)) {
				$lists['gid'] = "<input type=\"hidden\" mosReq=\"0\" name=\"gid\" value=\"$user->gid\" /><strong>Super Administrator</strong>";
			} else if ( $myGid == 24 && $user->gid == 24 ) {
				$lists['gid'] = "<input type=\"hidden\" mosReq=\"0\" name=\"gid\" value=\"$user->gid\" /><strong>Administrator</strong>";
			} else {
				// ensure user can't add group higher than themselves
				if ( checkJversion() <= 0 ) {
					$my_groups 	= $acl->get_object_groups( 'users', $my->id, 'ARO' );
				} else {
					$aro_id		= $acl->get_object_id( 'users', $my->id, 'ARO' );
					$my_groups 	= $acl->get_object_groups( $aro_id, 'ARO' );
				}

				if (is_array( $my_groups ) && count( $my_groups ) > 0) {
					$ex_groups = $acl->get_group_children( $my_groups[0], 'ARO', 'RECURSE' );
					if ( $ex_groups === null ) {
						$ex_groups	=	array();		// mambo fix
					}
				} else {
					$ex_groups = array();
				}
	
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
	
				$lists['gid'] = mosHTML::selectList( $gtree, 'gid', 'size="11" mosReq="0"', 'value', 'text', $user->gid );
			}
	
			// make the select list for yes/no fields
			$yesno[] = mosHTML::makeOption( '0', 'No' );
			$yesno[] = mosHTML::makeOption( '1', 'Yes' );
	
			// build the html select list
			$lists['block'] = mosHTML::yesnoSelectList( 'block', 'class="inputbox" size="1"', $user->block );
			$lists['approved'] = mosHTML::yesnoSelectList( 'approved', 'class="inputbox" size="1"', $user->approved );
			$lists['confirmed'] = mosHTML::yesnoSelectList( 'confirmed', 'class="inputbox" size="1"', $user->confirmed );
			// build the html select list
			$lists['sendEmail'] = mosHTML::yesnoSelectList( 'sendEmail', 'class="inputbox" size="1"', $user->sendEmail );
			$return .= "<tr>\n";
			$return .= "  <td valign=\"top\" class=\"titleCell\">Group:</td>\n";
			$return .= "  <td class=\"fieldCell\">".$lists['gid']."</td>\n";
			$return .= "</tr>\n";
			if ($canBlockUser) {
				$return .= "<tr>\n";
				$return .= "  <td class=\"titleCell\">Block User</td>\n";
				$return .= "  <td class=\"fieldCell\">".$lists['block']."</td>\n";
				$return .= "</tr>\n";
				$return .= "<tr>\n";
				$return .= "  <td class=\"titleCell\">Approve User</td>\n";
				$return .= "  <td class=\"fieldCell\">".$lists['approved']."</td>\n";
				$return .= "</tr>\n";
				$return .= "<tr>\n";
				$return .= "  <td class=\"titleCell\">Confirm User</td>\n";
				$return .= "  <td class=\"fieldCell\">".$lists['confirmed']."</td>\n";
				$return .= "</tr>\n";
			}
			$return .= "<tr>\n";
			$return .= "  <td class=\"titleCell\">Receive Moderator Emails</td>\n";
			$return .= "  <td class=\"fieldCell\">";
			if ($canEmailEvents || $user->sendEmail) {
				$return .= $lists['sendEmail'];
			} else {
				$return .= "No (User's group-level doesn't allow this)<input type=\"hidden\" name=\"sendEmail\" value=\"0\" />";
			}
			$return .= "</td>\n</tr>\n";
			if( $user->id) {
				$return .= "<tr>\n";
				$return .= "   <td class=\"titleCell\">Register Date</td>\n";
				$return .= "   <td class=\"fieldCell\">".$user->registerDate."</td>\n";
				$return .= "</tr>\n";
				$return .= "<tr>\n";
				$return .= "   <td class=\"titleCell\">Last Visit Date</td>\n";
				$return .= "   <td class=\"fieldCell\">".$user->lastvisitDate."</td>\n";
				$return .= "</tr>\n";
			}
		}
		$return .= "</table>\n";
	
		return $return;
	}
	/**
	* Saves the user edit tab postdata into the tab's permanent storage
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function saveEditTab($tab, &$user, $ui, $postdata) {
		// this is (for now) handled in the core of CB...
	}
	/**
	* Generates the HTML to display the registration tab/area
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed (here null)
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data in case of error only
	* @return mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayRegistration($tab, $user, $ui, $postdata) {
		global $ueConfig, $_POST, $mosConfig_emailpass;
;
		
		// gets values from post, in case we got an error:
		$rowExtras="";
		$row = "";
		if( $postdata !== null ) {
			if (isset($_POST['firstname']))		$rowExtras->firstname	= stripslashes( cbGetParam( $_POST, 'firstname' ) );
			if (isset($_POST['middlename']))	$rowExtras->middlename	= stripslashes( cbGetParam( $_POST, 'middlename' ) );
			if (isset($_POST['lastname']))		$rowExtras->lastname	= stripslashes( cbGetParam( $_POST, 'lastname' ) );
			if (isset($_POST['name']))			$row->name				= stripslashes( cbGetParam( $_POST, 'name' ) );
			if (isset($_POST['username']))		$row->username			= stripslashes( cbGetParam( $_POST, 'username' ) );
			if (isset($_POST['email']))			$row->email				= stripslashes( cbGetParam( $_POST, 'email' ) );
		} else {
			$rowExtras->firstname	= null;
			$rowExtras->middlename	= null;
			$rowExtras->lastname	= null;
			$row->name				= null;
			$row->username			= null;
			$row->email				= null;
		}
		
		// outputs contacts fields for registration form:

		ob_start();
		
		SWITCH($ueConfig['name_style']) {
			case 2:
?>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_FNAME; ?>:</td>
			<td class="fieldCell"><input class="inputbox" type="text" size="40" mosReq="1" mosLabel="<?php
			echo _UE_YOUR_FNAME; ?>" id="firstname" name="firstname" value="<?php if (isset($rowExtras->firstname)) echo htmlspecialchars($rowExtras->firstname);?>" /><?php
			echo getFieldIcons(1,true,($ueConfig['name_format']!=3)); ?></td>
		</tr>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_LNAME; ?>:</td>
			<td class="fieldCell"><input class="inputbox" type="text" size="40" mosReq="1" mosLabel="<?php
			echo _UE_YOUR_LNAME; ?>" id="lastname" name="lastname" value="<?php if (isset($rowExtras->lastname)) echo htmlspecialchars($rowExtras->lastname);?>" /><?php
			echo getFieldIcons(1,true,($ueConfig['name_format']!=3)); ?></td>
		</tr>
<?php
				break;
			case 3:
?>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_FNAME; ?>:</td>
			<td class="fieldCell"><input class="inputbox" type="text" size="40" mosReq="1" mosLabel="<?php
			echo _UE_YOUR_FNAME; ?>" id="firstname" name="firstname" value="<?php if (isset($rowExtras->firstname)) echo htmlspecialchars($rowExtras->firstname);?>" /><?php
			echo getFieldIcons(1,true,($ueConfig['name_format']!=3)); ?></td>
		</tr>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_MNAME; ?>:</td>
			<td class="fieldCell"><input class="inputbox" type="text" size="40" mosReq="0" mosLabel="<?php
			echo _UE_YOUR_MNAME; ?>" id="middlename" name="middlename" value="<?php if (isset($rowExtras->middlename)) echo htmlspecialchars($rowExtras->middlename);?>" /><?php
			echo getFieldIcons(1,false,($ueConfig['name_format']!=3)); ?></td>
		</tr>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_LNAME; ?>:</td>
			<td class="fieldCell"><input class="inputbox" type="text" size="40" mosReq="1" mosLabel="<?php
			echo _UE_YOUR_LNAME; ?>" id="lastname" name="lastname" value="<?php if (isset($rowExtras->lastname)) echo htmlspecialchars($rowExtras->lastname);?>" /><?php
			echo getFieldIcons(1,true,($ueConfig['name_format']!=3)); ?></td>
		</tr>
<?php
				break;
			default:
?>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_NAME; ?>:</td>
			<td class="fieldCell"><input class="inputbox" type="text" size="40" id="name" name="name" mosReq="1" mosLabel="Name"  value="<?php
			if (isset($row->name)) echo htmlspecialchars($row->name);?>" /><?php
			echo getFieldIcons(1,true,($ueConfig['name_format']!=3)); ?></td>
		</tr>
<?php 		
				break;
		} 
?>

    <tr>
		<td class="titleCell"><?php echo _REGISTER_UNAME; ?></td>
		<td class="fieldCell"><input type="text" id="username" name="username" autocomplete="off" mosReq="0" mosLabel="<?php
		echo _REGISTER_UNAME; ?>"  size="40" value="<?php if (isset($row->username)) echo htmlspecialchars($row->username);?>" class="inputbox" <?php
		if ( ( isset( $ueConfig['reg_username_checker'] ) ) && ( $ueConfig['reg_username_checker'] ) ) {
			echo 'onblur="cbSendUsernameCheck(this);" onkeyup="if (this.value != cbLastUsername) { document.getElementById(\'usernameCheckResponse\').innerHTML = \'\'; cbLastUsername = \'\'; }" ';
		}
		?>/><?php
		echo getFieldIcons(1,true,($ueConfig['name_format']!=1), sprintf( _VALID_AZ09, _UE_UNAME, 2 ), _REGISTER_UNAME); ?></td>
	</tr>
<?php
		if ( ( isset( $ueConfig['reg_username_checker'] ) ) && ( $ueConfig['reg_username_checker'] ) ) {
?>
   <tr>
		<td class="titleCell">&nbsp;</td>
		<td class="fieldCell"><?php
		//	<div id="usernameCheckLink"><input type=button value="<?php echo _UE_CHECK_USERNAME_AVAILABILITY; ? >" class="button" onclick="sendUsernameCheck(this);" /></div>
			?><div id="usernameCheckResponse"></div>
		</td>
    </tr>
<?php
		}
?>

	<tr>
		<td class="titleCell"><?php echo _REGISTER_EMAIL; ?></td>
		<td class="fieldCell"><input type="text" id="email" name="email" mosReq="1" mosLabel="<?php
		echo _REGISTER_EMAIL; ?>" size="40" value="<?php if (isset($row->email)) echo htmlspecialchars($row->email);?>" class="inputbox" /><?php
		echo getFieldIcons(1,true,($ueConfig['allow_email_display']==1 || $ueConfig['allow_email_display']==2), _REGWARN_MAIL, _REGISTER_EMAIL); ?></td>
	</tr>

	<?php
		if ($mosConfig_emailpass=="0" || isset($mosConfig_useractivation)) { ?>

	<tr>
		<td class="titleCell"><?php echo _REGISTER_PASS; ?></td>
		<td class="fieldCell"><input class="inputbox" type="password" id="password" name="password" autocomplete="off" mosReq="0" mosLabel="<?php
		echo _REGISTER_PASS; ?>" size="40" value="" /><?php
		echo getFieldIcons(1,true,false, sprintf( _VALID_AZ09, _UE_PASS, 6 ), _REGISTER_PASS); ?></td>
	</tr>
    <tr>
		<td class="titleCell"><?php echo _REGISTER_VPASS; ?></td>
		<td class="fieldCell"><input class="inputbox" type="password" id="verifyPass" name="verifyPass" autocomplete="off" mosReq="0" mosLabel="<?php
		echo _REGISTER_VPASS; ?>" size="40" value="" /><?php
		echo getFieldIcons(1,true,false); ?></td>
	</tr>

    <?php } else { ?>

    <tr>
		<td class="titleCell"><?php echo _REGISTER_PASS; ?></td>
        <td class="fieldCell"><?php echo _SENDING_PASSWORD; ?>
			<input type="hidden" id="password" name="password" value="" />
			<input type="hidden" id="verifyPass" name="verifyPass" value="" />
		</td>
	</tr>
<?php	}

		$ret .= ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	/**
	* Saves the registration tab/area postdata into the tab's permanent storage
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed (here null)
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @return boolean : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function saveRegistrationTab($tab, &$user, $ui, $postdata) {
		// this is (for now) handled in the core of CB...
	}
	/**
	* Retrieve joomla standard user parameters so that they can be displayed in user edit mode.
	* @param object user reflecting the user being edited
	* @return array of user parameter attributes (title,value)
	*/
	function _getUserParams($ui, $user,$name="cbparams") {
		global $mainframe;

		$result = array();	// in case not Joomla

		if (class_exists("JUser")) {						// Joomla 1.5 :
			$juser =& JUser::getInstance($user->id);
			$params =& $juser->getParameters();
			$params->loadSetupFile(JApplicationHelper::getPath( 'com_xml', 'com_users' ));
			// $result = $params->render( 'params' );
			if (is_callable(array("JParameter","getParams"))) {
				$result = $params->getParams( $name );	//BBB new API submited to Jinx 17.4.2006.
			} else {
				foreach ($params->_xml->param as $param) {	//BBB still needs core help... accessing private variable _xml .
					$result[] = $params->renderParam( $param, $name );
				}
			}
					
		} else {							
			if(file_exists($mainframe->getCfg('absolute_path') .'/administrator/components/com_users/users.class.php')){
				require_once( $mainframe->getCfg('absolute_path') .'/administrator/components/com_users/users.class.php' );		
			}
			if (class_exists('mosUserParameters')) {		// Joomla 1.0 :
				$file 	= $mainframe->getPath( 'com_xml', 'com_users' );
	
				$userParams =& new mosUserParameters( $user->params, $file, 'component' );
	
				if (isset($userParams->_path) && $userParams->_path) {						// Joomla 1.0
					if (!is_object( $userParams->_xmlElem )) {
						require_once( $mainframe->getCfg('absolute_path') . '/includes/domit/xml_domit_lite_include.php' );
		
						$xmlDoc = new DOMIT_Lite_Document();
						$xmlDoc->resolveErrors( true );
						if ($xmlDoc->loadXML( $userParams->_path, false, true )) {
							$root =& $xmlDoc->documentElement;
		
							$tagName = $root->getTagName();
							$isParamsFile = ($tagName == 'mosinstall' || $tagName == 'mosparams');
							if ($isParamsFile && $root->getAttribute( 'type' ) == $userParams->_type) {
								if ($params = &$root->getElementsByPath( 'params', 1 )) {
									$userParams->_xmlElem =& $params;
								}
							}
						}
					}
				}
				$result=array();
				
				if (isset($userParams->_xmlElem) && is_object( $userParams->_xmlElem )) {    // Joomla 1.0
					$element =& $userParams->_xmlElem;
					//$params = mosParseParams( $row->params );
					$userParams->_methods = get_class_methods( "mosUserParameters" );
					foreach ($element->childNodes as $param) {
						$result[] = $userParams->renderParam( $param, $name );
					}
				}
			}
		}
		return $result;
	}
	
}	// end class getContactTab

?>
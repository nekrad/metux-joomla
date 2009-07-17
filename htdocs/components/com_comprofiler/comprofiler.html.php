<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: comprofiler.html.php 609 2006-12-13 17:30:15Z beat $
* @package Community Builder
* @subpackage comprofiler.html.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/


defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_comprofiler {

	function outputMosFormVal() {
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
var cbDefaultFieldBackground;
function submitbutton(mfrm) {
	var me = mfrm.elements;
	var errorMSG = '';
	var iserror=0;
	// loop through all input elements in form
	for (var i=0; i < me.length; i++) {
		// check if element is mandatory; here mosReq="1"
		if ( (typeof(me[i].getAttribute('mosReq')) != "undefined") && ( me[i].getAttribute('mosReq') == 1) ) {
			if (me[i].type == 'radio' || me[i].type == 'checkbox') {
				var rOptions = me[me[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						if (rOptions[r].checked) {
							rChecked=1;
						}
					}
				} else {
					if (me[i].checked) {
						rChecked=1;
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
					// notify user by changing background color, in this case to red
					if (cbDefaultFieldBackground === undefined) cbDefaultFieldBackground = ((me[i].style.getPropertyValue) ? me[i].style.getPropertyValue("backgroundColor") : me[i].style.backgroundColor);
					me[i].style.backgroundColor = "red";
					iserror=1;
				} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldBackground;
			}
			if (me[i].value == '') {
				// add up all error messages
				errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
				// notify user by changing background color, in this case to red
				if (cbDefaultFieldBackground === undefined) cbDefaultFieldBackground = ((me[i].style.getPropertyValue) ? me[i].style.getPropertyValue("backgroundColor") : me[i].style.backgroundColor);
				me[i].style.backgroundColor = "red";
				iserror=1;
			} else if ((me[i].getAttribute('mosLength')) && (me[i].value.length > me[i].getAttribute('mosLength'))) {
				errorMSG += me[i].getAttribute('mosLabel') + " <?php echo unhtmlentities(_UE_LENGTH_ERROR); ?> " + (me[i].value.length - me[i].getAttribute('mosLength')) + " <?php echo unhtmlentities(_UE_CHARACTERS); ?>\n";
				// notify user by changing background color, in this case to red
				if (cbDefaultFieldBackground === undefined) cbDefaultFieldBackground = ((me[i].style.getPropertyValue) ? me[i].style.getPropertyValue("backgroundColor") : me[i].style.backgroundColor);
				me[i].style.backgroundColor = "red";
				iserror=1;
			} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldBackground;
		}
	}	
	if(iserror==1) {
		alert(errorMSG);
		return false;
	} else {
		return true;
	}
}
//--><!]]></script>
<?php
	}	// end of php method HTML_comprofiler::outputMosFormVal()


	function emailUser( $option, $rowFrom, $rowTo, $subject = '', $message = '' ) {
	global $ueConfig, $mosConfig_live_site, $_PLUGINS;
	
	if($rowFrom->id == $rowTo->id) {
		echo "<div class=\"contentheading\" >"._UE_NOSELFEMAIL."</div>";
		return;
	}
	HTML_comprofiler::outputMosFormVal();

	$_PLUGINS->loadPluginGroup('user');
	$results = $_PLUGINS->trigger( 'onBeforeEmailUserForm', array( &$rowFrom, &$rowTo, 1 ));	//$ui=1
	if ($_PLUGINS->is_errors()) {
		echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
		exit();
	}
?>
	<div style="text-align:left;">
	<div class="contentheading" ><?php
	echo sprintf(_UE_EMAILFORMTITLE,"<a href=\"".sefRelToAbs( "index.php?option=com_comprofiler&amp;task=UserDetails&amp;user=".$rowTo->id )."\">".getNameFormat($rowTo->name,$rowTo->username,$ueConfig['name_format'])."</a>");
	?></div>
	<form action="<?php echo sefRelToAbs("index.php?option=$option".getCBprofileItemid(true)); ?>" method="post" id="adminForm" name="adminForm" onsubmit="return submitbutton(this)">
		<br /><?php echo _UE_EMAILFORMSUBJECT; ?><br />
<?php
	if (is_array($results)) {
		echo implode( "<br />", $results );
	}
?>
		<input mosReq="1" mosLabel="<?php echo _UE_EMAILFORMSUBJECT; ?>" type="text" class="inputbox" name="emailSubject" size="50" value="<?php echo htmlspecialchars( $subject ); ?>" /><?php
		echo "<img src='".$mosConfig_live_site."/components/com_comprofiler/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> ";
		?><br />
		<br /><?php echo _UE_EMAILFORMMESSAGE; ?><br />
		<textarea mosReq="1" mosLabel='<?php echo _UE_EMAILFORMMESSAGE; ?>' class="inputbox" name="emailBody" cols="50" rows="15" ><?php echo htmlspecialchars( $message ); ?></textarea><?php
		echo "<img src='".$mosConfig_live_site."/components/com_comprofiler/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; ?><br />
<?php
	$warning = _UE_EMAILFORMWARNING;
	$results = $_PLUGINS->trigger( 'onAfterEmailUserForm', array( &$rowFrom, &$rowTo, &$warning, 1 ));	//$ui=1
	if (is_array($results)) {
		echo implode( "<br />", $results );
	}
?>
		<div><?php echo sprintf( $warning, $rowFrom->email ); ?></div>
		<input type="hidden" name="fromID" value="<?php echo $rowFrom->id; ?>" />
		<input type="hidden" name="toID" value="<?php echo $rowTo->id; ?>" />
		<input type="hidden" name="protect" value="<?php
	$salt	=	cbMakeRandomString( 16 );
	echo 'cbmv1_' . md5($salt.$rowTo->id.$rowTo->password.$rowTo->lastvisitDate.$rowFrom->password.$rowFrom->lastvisitDate) . '_' . $salt; ?>" />
		<?php
	echo cbGetSpoofInputTag();
	echo "\t\t" . cbGetAntiSpamInputTag();
?>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="sendUserEmail" />
		<input type="submit" class="button" value="<?php echo _UE_SENDEMAIL; ?>" />
	</form>
	</div>
	<div style="align:center;">
	<?php
	echo "<img src='".$mosConfig_live_site."/components/com_comprofiler/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "._UE_FIELDREQUIRED;
	?>
	</div>
<?php

	}

/******************************
Profile Functions
******************************/

	function userEdit( $user, $option, $submitvalue, $regErrorMSG=null )
	{
	global $ueConfig, $_REQUEST, $mosConfig_live_site, $mainframe, $my;

	outputCbTemplate( 1 );
	echo initToolTip( 1 );
	
	$title		=	cbSetTitlePath( $user, _UE_EDIT_TITLE, _UE_EDIT_OTHER_USER_TITLE );

	$calendars	=	new cbCalendars( 1 );	
	$tabs		=	new cbTabs( 0, 1, $calendars );
	$tabcontent	=	$tabs->getEditTabs( $user );

?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
var cbDefaultFieldBackground;
function submitbutton(mfrm) {
	var me = mfrm.elements;
<?php
$version = checkJversion();
if ($version == 1) {
?>
	var r = new RegExp("^[a-zA-Z](([\.\-a-zA-Z0-9@])?[a-zA-Z0-9]*)*$", "i");
<?php
} elseif ( $version == -1 ) {
?>
	var r = new RegExp("[^A-Za-z0-9]", "i");
<?php
} else {
?>
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
<?php
}
?>
	var errorMSG = '';
	var iserror=0;
	if (cbDefaultFieldBackground === undefined) cbDefaultFieldBackground = ((me['username'].style.getPropertyValue) ? me['username'].style.getPropertyValue("backgroundColor") : me['username'].style.backgroundColor);
<?php echo $tabs->fieldJS; ?>
	if (me['username'].value == "") {
		errorMSG += "<?php echo unhtmlentities(_REGWARN_UNAME);?>\n";
		me['username'].style.backgroundColor = "red";
		iserror=1;
	} else if (<?php if ($version==1) echo "!"; ?>r.exec(me['username'].value) || (me['username'].value.length < 3)) {
		errorMSG += "<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_PROMPT_UNAME), 2 );?>\n";
		me['username'].style.backgroundColor = "red";
		iserror=1;
	} else if (me['username'].style.backgroundColor.slice(0,3)=="red") {
		me['username'].style.backgroundColor = cbDefaultFieldBackground;
	}
	if ((me['password'].value) && (<?php if ($version==1) echo "!"; ?>r.exec(me['password'].value) || (me['password'].value.length < 6))) {
		errorMSG += "<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_REGISTER_PASS), 6 );?>\n";
		me['password'].style.backgroundColor = "red";
		iserror=1;
	} else if ((me['password'].value != "") && (me['password'].value != me['verifyPass'].value)){
		errorMSG += "<?php echo unhtmlentities(_REGWARN_VPASS2);?>\n";
		me['password'].style.backgroundColor = "red"; me['verifyPass'].style.backgroundColor = "red";
		iserror=1;
	} else {
		if (me['password'].style.backgroundColor.slice(0,3)=="red") me['password'].style.backgroundColor = cbDefaultFieldBackground;
		if (me['verifyPass'].style.backgroundColor.slice(0,3)=="red") me['verifyPass'].style.backgroundColor = cbDefaultFieldBackground;
	}
	// loop through all input elements in form
	for (var i=0; i < me.length; i++) {
		// check if element is mandatory; here mosReq="1"
		if ( (typeof(me[i].getAttribute('mosReq')) != "undefined") && ( me[i].getAttribute('mosReq') == 1) ) {
			if (me[i].type == 'radio' || me[i].type == 'checkbox') {
				var rOptions = me[me[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						if (rOptions[r].checked) {
							rChecked=1;
						}
					}
				} else {
					if (me[i].checked) {
						rChecked=1;
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
					// notify user by changing background color, in this case to red
					me[i].style.backgroundColor = "red";
					iserror=1;
				} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldBackground;
			}
			if (me[i].value == '') {
				// add up all error messages
				errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
				// notify user by changing background color, in this case to red
				me[i].style.backgroundColor = "red";
				iserror=1;
			} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldBackground;
		}
	}
	if(iserror==1) {
		alert(errorMSG);
		return false;
	} else {
		return true;
	}
}
//--><!]]></script>
<form action="<?php echo sefRelToAbs("index.php?option=$option".getCBprofileItemid(true)); ?>" method="post" id="adminForm" name="adminForm" onsubmit="return submitbutton(this)">
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo htmlspecialchars( $title ); ?></div></td>
	</tr>
</table>
<br />
<?php
if ( $regErrorMSG ) {
	echo "<div class='error'>".$regErrorMSG."</div>\n";
}
if ( $user->id != $my->id ) {
	echo "<div class='message' style='font-weight:bold;color:red;margin-bottom:20px;'>" . sprintf( _UE_WARNING_EDIT_OTHER_USER_PROFILE, getNameFormat( $user->name, $user->username, $ueConfig['name_format'] ) ) . "</div>\n";
}
echo "<table cellspacing='0' cellpadding='4' border='0' width='100%' id='userEditTable'><tr><td width='100%'>\n";
echo $tabcontent;
echo "</td></tr></table>";

?>
	<input class="button" type="submit" value="<?php echo $submitvalue; ?>" />
	<input type="button" class="button" name="btncancel" value="<?php echo _UE_CANCEL; ?>" onclick="window.location='<?php
									 echo sefRelToAbs("index.php?option=" . htmlspecialchars( cbGetParam( $_REQUEST, 'option' ) ) . ( ( $user->id == $my->id ) ? '' : ( '&amp;uid=' . $user->id ) ) . getCBprofileItemid( true )); ?>';" />
	<input type="hidden" name="id" value="<?php echo $user->id;?>" />
	<input type="hidden" name="task" value="saveUserEdit" />
	<?php
	echo cbGetSpoofInputTag();
?>
<div style="align:center;">
<?php
echo getFieldIcons(1,true,true,"","",true);
if ( isset( $_REQUEST['tab'] ) ) {
	echo "<script type=\"text/javascript\">showCBTab( '" . urldecode( cbGetParam( $_REQUEST, 'tab' ) ) . "' );</script>";
}
?>
</div>
</form>

<?php
	}

	function tabClass(&$user,&$option) {
		global $ueConfig, $_REQUEST, $_POST, $_PLUGINS;
		
		$tabClassName	= urldecode( cbGetParam( $_REQUEST, "tab" ) );
		$pluginName		= urldecode( cbGetParam( $_REQUEST, "plugin" ) );
		if ( $tabClassName ) {
			$tabs = new cbTabs( 0, 1, null, false );	//	function cbTabs($useCookies, $ui, $calendars=null, $outputTabpaneScript=true) {
			$method = "getTabComponent";
			$result = $tabs->tabClassPluginTabs($user, $_POST, $pluginName, $tabClassName, $method);
			if ( $result !== null ) {
				echo $result;
			} elseif ( $result === false ) {
			 	if( $_PLUGINS->is_errors() ) {
					echo "<script type=\"text/javascript\">alert(\"" . $_PLUGINS->getErrorMSG() . "\"); </script>\n";
			 	}
			}
		}
	}
	
	function userProfile($user, $option, $submitvalue) {
		global $my,$ueConfig,$_POST,$_PLUGINS, $mainframe;
		
		$_PLUGINS->loadPluginGroup('user');
		$results = $_PLUGINS->trigger( 'onBeforeUserProfileRequest', array(&$user,1));
		if ($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
			exit();
		}

		$cbMyIsModerator = isModerator($my->id);
		$cbUserIsModerator = isModerator($user->id);

		$showProfile=1;
		if ( ( $user->banned != 0 ) || ( ( $user->block == 1 ) && $user->confirmed && $user->approved ) ) {
			echo "<font color=red>";
			if ($user->banned != 0 ) {
				if ( $my->id != $user->id ) {
					echo _UE_USERPROFILEBANNED;
				} else {
					echo _UE_BANNED_CHANGE_PROFILE;
				}
			}
			if ( ( $user->block == 1 ) && $user->confirmed && $user->approved ) {
				echo _UE_USERPROFILEBLOCKED;
			}
			if ( ( $my->id != $user->id ) && ( $cbMyIsModerator != 1 ) ) {
				$showProfile=0;
			} else {
				if ($user->block == 1) {
					echo ": "._LOGIN_BLOCKED;
				}
				if ($user->banned != 0) {
					echo "<br />".nl2br($user->bannedreason);
				}
			}
			echo "<br /></font>";
		}
		if (!$user->confirmed) echo "<font color=red>"._UE_USER_NOT_CONFIRMED."</font><br />";
		if (!$user->approved) echo "<font color=red>"._UE_USER_NOT_APPROVED."</font><br />";
		if ((!$user->confirmed || !$user->approved) && $cbMyIsModerator!=1) {
				$showProfile=0;
		}
		if ($showProfile==1) {
			if ( method_exists($mainframe,"setPageTitle")) {
				$mainframe->setPageTitle( unHtmlspecialchars(getNameFormat($user->name,$user->username,$ueConfig['name_format'])));
			}
			if ( method_exists($mainframe,"appendPathWay")) {
				$mainframe->appendPathWay( getNameFormat($user->name,$user->username,$ueConfig['name_format']));
			}
			$i=1;
			outputCbTemplate(1);
			echo initToolTip(1);
?>
<script type="text/javascript">
	function cbConnSubmReq() {
		cClick();
		document.connOverForm.submit();
	}
	function confirmSubmit() {
	if (confirm("<?php echo _UE_CONFIRMREMOVECONNECTION; ?>"))
		return true ;
	else
		return false ;
	}
</script>
<?php
			$results = $_PLUGINS->trigger( 'onBeforeUserProfileDisplay', array(&$user,1,&$cbUserIsModerator,&$cbMyIsModerator));	//$ui=1	//BBB: params?
			if ($_PLUGINS->is_errors()) {
				echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
				exit();
			}
			if (is_array($results)) {
				for ($i=0, $n=count($results); $i<$n; $i++) {
					echo $results[$i];
				}
			}
			
			$tabs = new cbTabs( 0, 1 );
			$userViewTabs = $tabs->getViewTabs($user);			// this loads, registers menu and user status and renders the tabs

			//positions: head left middle right tabmain underall
			$wLeft	 = isset($userViewTabs["cb_left"])	 ? 100 : 0;
			$wMiddle = isset($userViewTabs["cb_middle"]) ? 100 : 0;
			$wRight	 = isset($userViewTabs["cb_right"])	 ? 100 : 0;
			$nCols	 = intval(($wLeft + $wMiddle + $wRight)/100);
			switch ($nCols) {
				case 0:
				case 1:
					break;
				case 2:
					$wLeft	 = $wLeft	? intval($ueConfig['left2colsWidth'])-1 : 0;
					$wMiddle = $wMiddle	? ($wLeft ? 100-intval($ueConfig['left2colsWidth'])-1 : intval($ueConfig['left2colsWidth'])-1) : 0;
					$wRight	 = $wRight	? 100-intval($ueConfig['left2colsWidth'])-1 : 0;
					break;
				case 3:
					$wLeft	 = intval($ueConfig['left3colsWidth'])-1;
					$wMiddle = 100-intval($ueConfig['left3colsWidth'])-intval($ueConfig['right3colsWidth'])-1;
					$wRight	 = intval($ueConfig['right3colsWidth'])-1;
					break;
			}
if (true) {
			echo "\n\t<div class=\"cbProfile\">";

			// Display "head" tabs: (Menu + shortest connection path / Degree of relationship + Uname Profile Page)
			if (isset($userViewTabs["cb_head"])) {
				echo "<div class=\"cbPosHead\">";
	    		echo $userViewTabs["cb_head"];
    			echo "</div>";
			}
			if ($nCols != 0) {
				echo "\n\t\t<div class=\"cbPosTop\">";

				// Display "Left" tabs
				if (isset($userViewTabs["cb_left"])) {
					echo "\n\t\t\t<div class=\"cbPosLeft\" style=\"width:".$wLeft."%;\">";
	    			echo $userViewTabs["cb_left"];
    				echo "</div>";
				}
				// Display "Middle" tabs (User Avatar/Image):
				if (isset($userViewTabs["cb_middle"])) {
					echo "\n\t\t\t<div class=\"cbPosMiddle\" style=\"width:".$wMiddle."%;\">";
	    			echo $userViewTabs["cb_middle"];
    				echo "</div>";
				}
				// Display "Right" tabs (User Status):
				if (isset($userViewTabs["cb_right"])) {
					echo "\n\t\t\t<div class=\"cbPosRight\" style=\"width:".$wRight."%;\">";
	    			echo $userViewTabs["cb_right"];
    				echo "</div>";
				}
				echo "<div class=\"cbClr\">&nbsp;</div></div>";
			}
			if (isset($userViewTabs["cb_tabmain"])) {
				echo "\n\t\t<div class=\"cbPosTabMain\">";
				echo $userViewTabs["cb_tabmain"];
				echo "</div>";
			}
			if (isset($userViewTabs["cb_underall"])) {
				echo "\n\t\t<div class=\"cbPosUnderAll\">";
				echo $userViewTabs["cb_underall"];
				echo "</div>";
			}
			echo "</div>\n";
} else {
/* TABS OLD WAY:
			echo "\n\t<table cellpadding='5' cellspacing='0' id='cbPosUpper'>";

			// Display "head" tabs: (Menu + shortest connection path / Degree of relationship + Uname Profile Page)
			if (isset($userViewTabs["cb_head"])) {
				echo "\n\t\t<tr style='width:100%;'><td id='cbPosHead' colspan='".$nCols."'>";
	    		echo $userViewTabs["cb_head"];
    			echo "</td></tr>";
			}
			if ($nCols != 0) {
				echo "\n\t\t<tr style='width:100%;'>";

				// Display "Left" tabs
				if (isset($userViewTabs["cb_left"])) {
					echo "\n\t\t\t<td id='cbPosLeft' style='width:".$wLeft."%;'>";
	    			echo $userViewTabs["cb_left"];
    				echo "</td>";
				}
				// Display "Middle" tabs (User Avatar/Image):
				if (isset($userViewTabs["cb_middle"])) {
					echo "\n\t\t\t<td id='cbPosMiddle' style='width:".$wMiddle."%;'>";
	    			echo $userViewTabs["cb_middle"];
    				echo "</td>";
				}
				// Display "Right" tabs (User Status):
				if (isset($userViewTabs["cb_right"])) {
					echo "\n\t\t\t<td id='cbPosRight' style='width:".$wRight."%;'>";
	    			echo $userViewTabs["cb_right"];
    				echo "</td>";
				}
				echo "</tr>";
			}
			echo "</table> <br />";
			if (isset($userViewTabs["cb_tabmain"])) {
				echo "\n\t<table cellpadding=\"5\" cellspacing=\"0\" style='width:100%' id=\"cbPosTabMain\"><tr><td>";
				echo $userViewTabs["cb_tabmain"];
				echo "</td></tr></table>";
			}
			if (isset($userViewTabs["cb_underall"])) {
				echo "\n\t<table cellpadding=\"5\" cellspacing=\"0\" style='width:100%' id=\"cbPosUnderAll\"><tr><td>";
				echo $userViewTabs["cb_underall"];
				echo "</td></tr></table>";
			}
END TABS OLD WAY */
}
			$tab = null;
			if ( isset( $_GET['tab'] ) ) {
				$tab = urldecode( cbGetParam( $_GET, 'tab', '' ) );
			} elseif ( isset( $_POST['tab'] ) ) {
				$tab = cbGetParam( $_POST, 'tab', '' );
			}
			if ($tab) {
				echo "<script type=\"text/javascript\">showCBTab('".addslashes(htmlspecialchars($tab))."');</script>\n";
			}

			if($my->id!=$user->id) {
				recordViewHit($my->id,$user->id,getenv('REMOTE_ADDR'));
			}
			$_PLUGINS->trigger( 'onAfterUserProfileDisplay', array($user,true));
		}
	}

	function userAvatar($row, $option,$submitvalue) {
		global $_CB_database, $_REQUEST, $ueConfig, $_PLUGINS, $my, $mainframe, $_FILES;

		$rowExtras = new moscomprofiler ($_CB_database);
		$rowExtras->load( (int) $row->id);

		$do		=	cbGetParam( $_REQUEST, 'do', 'init' );
		if ($do=='init'){
			outputCbTemplate(1);
	
			$title		=	cbSetTitlePath( $row, _UE_EDIT_TITLE, _UE_EDIT_OTHER_USER_TITLE );
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo $title; ?></div></td>
	</tr>
</table>   
<?php                       
			if($ueConfig['allowAvatarUpload']){
				echo "<span class='contentheading'>"._UE_UPLOAD_SUBMIT."</span><br /><br />";
				echo _UE_UPLOAD_DIMENSIONS.": ".$ueConfig['avatarWidth']."x".$ueConfig['avatarHeight']." - ".$ueConfig['avatarSize']." KB";
				echo "\n<form action='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userAvatar".getCBprofileItemid(true))."' method='post' name='adminForm' enctype='multipart/form-data'>";
				echo "\n\t<input type='hidden' name='do' value='validate' />";
				if ( $my->id != $row->id ) {
					echo "\n\t<input type='hidden' name='uid' value='" . $row->id . "' />";
				}
				echo "\n\t<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
				echo "\n\t\t<tr align='center' valign='middle'>\n\t\t\t<td align='center' valign='top'>";

				//echo " <input type='hidden' name='MAX_FILE_SIZE' value='".$maxAllowed."' />";
				echo _UE_UPLOAD_SELECT_FILE." <input type='file' name='avatar' value='' />";
				echo " <input type='submit' class='button' value='"._UE_UPLOAD_UPLOAD."' />";
				echo "</td>\n\t\t</tr></table><br/><br/>";
				echo "\n";
				echo cbGetSpoofInputTag();
				echo "</form>";
			}

			if($ueConfig['allowAvatarGallery']){
				echo "\n<span class='contentheading'>"._UE_UPLOAD_GALLERY."</span><br /><br />";
				echo "\n<form action='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userAvatar".getCBprofileItemid(true))."' method='post' name='adminForm'>";
				echo "\n\t<input type='hidden' name='do' value='fromgallery' />";
				if ( $my->id != $row->id ) {
					echo "\n\t<input type='hidden' name='uid' value='" . $row->id . "' />";
				}
				echo "\n\t<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
				echo "\n\t\t<tr align='center' valign='middle'>";
				echo '<td colspan="5">&nbsp;</td></tr>';
				echo "\n\t\t<tr align='center' valign='middle'>";
				$avatar_gallery_path='images/comprofiler/gallery';
				$avatar_images=array();
				$avatar_images=display_avatar_gallery($avatar_gallery_path);
				for($i = 0; $i < count($avatar_images); $i++) {
					$j=$i+1;
					echo "\n\t\t\t<td>";
					$avatar_name = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $avatar_images[$i])));
					echo '<img src="images/comprofiler/gallery/'. $avatar_images[$i].'" alt="'.$avatar_name.'" title="'.$avatar_name.'" />';
					echo '<input type="radio" name="newavatar" value="gallery/'.$avatar_images[$i].'" />';
					echo '</td>';
					if (function_exists('fmod')) {
						if (!fmod(($j),5)) { echo "</tr>\n\t\t<tr align=\"center\" valign=\"middle\">"; }
					} else {
						if (!fmodReplace(($j),5)) { echo "</tr>\n\t\t<tr align=\"center\" valign=\"middle\">"; }
					}

				}
				echo "\n\t\t</tr>\n\t\t";
				echo '<tr><td colspan="5" align="center"><input class="button"  type="submit" value="'._UE_UPLOAD_CHOOSE.'" /></td></tr>';
				echo "\n\t</table>";
				echo "\n";
				echo cbGetSpoofInputTag();
				echo "</form>\n";
			}

		}else if ($do=='validate'){

			// simple spoof check security
			cbSpoofCheck();

			if (!$ueConfig['allowAvatarUpload']) {
				mosNotAuth();
				return;
			}

			$isModerator=isModerator($my->id);

			if (!isset($_FILES['avatar']['tmp_name']) || empty($_FILES['avatar']['tmp_name']) || $_FILES['avatar']['error'] != 0) {
				cbRedirectToProfile( $row->id, _UE_UPLOAD_ERROR_EMPTY, 'userAvatar' );
			}

			$_PLUGINS->loadPluginGroup('user');
			$_PLUGINS->trigger( 'onBeforeUserAvatarUpdate', array(&$row,&$rowExtras,$isModerator,&$_FILES['avatar']['tmp_name']));
			if ($_PLUGINS->is_errors()) {
				cbRedirectToProfile( $row->id, $_PLUGINS->getErrorMSG(), 'userAvatar' );
			}

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

			if (!($newFileName=$imgToolBox->processImage($_FILES['avatar'],uniqid($row->id."_"),$mainframe->getCfg('absolute_path').'/images/comprofiler/', 0, 0, 1))) {
				cbRedirectToProfile( $row->id, $imgToolBox->_errMSG, 'userAvatar' );
			}

			if ($rowExtras->avatar != null && $rowExtras->avatar!="") {
				deleteAvatar($rowExtras->avatar);
			}

			if ($ueConfig['avatarUploadApproval']==1 && $isModerator==0) {

				$cbNotification	=	new cbNotification();
				$cbNotification->sendToModerators(_UE_IMAGE_ADMIN_SUB,_UE_IMAGE_ADMIN_MSG);

				$_CB_database->setQuery("UPDATE #__comprofiler SET avatar='" . $_CB_database->getEscaped($newFileName) . "', avatarapproved=0 WHERE id=" . (int) $row->id);
				$redMsg			=	_UE_UPLOAD_PEND_APPROVAL;
			} else {
				$_CB_database->setQuery("UPDATE #__comprofiler SET avatar='" . $_CB_database->getEscaped($newFileName) . "', avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id=" . (int) $row->id);
				$redMsg			=	_UE_UPLOAD_SUCCESSFUL;
			}

			$_CB_database->query();

			$_PLUGINS->trigger( 'onAfterUserAvatarUpdate', array(&$row,&$rowExtras,$isModerator,$newFileName) );
			cbRedirectToProfile( $row->id, $redMsg );
   ?>
   <script type="text/javascript">
   setTimeout("location='<?php echo sefRelToAbs("index.php?option=com_comprofiler&task=userProfile".getCBprofileItemid()); ?>'",350000);
   </script>
   <?php

		} else if ($do=='fromgallery') {

			// simple spoof check security
			cbSpoofCheck();

			if(!$ueConfig['allowAvatarGallery']){
				mosNotAuth();
				return;
			}

			$newAvatar = cbGetParam( $_POST, 'newavatar', null );
			if($newAvatar==''){
				cbRedirectToProfile( $row->id, _UE_UPLOAD_ERROR_CHOOSE, 'userAvatar' );
			}
			$_CB_database->setQuery("UPDATE #__comprofiler SET avatar='" . $_CB_database->getEscaped($newAvatar) . "', avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id=" . (int) $row->id);

			if( ! $_CB_database->query() ) {
				echo _UE_USER_PROFILE_NOT."<br/><br/>";
			}else {
				// delete old avatar:
				if(eregi("gallery/",$rowExtras->avatar)==false && is_file($mainframe->getCfg('absolute_path')."/images/comprofiler/".$rowExtras->avatar)) {
					unlink($mainframe->getCfg('absolute_path')."/images/comprofiler/".$rowExtras->avatar);
					if(is_file($mainframe->getCfg('absolute_path')."/images/comprofiler/tn".$rowExtras->avatar)) unlink($mainframe->getCfg('absolute_path')."/images/comprofiler/tn".$rowExtras->avatar);
				}

				cbRedirectToProfile( $row->id, _UE_USER_PROFILE_UPDATED );
			}
			echo _UE_USER_RETURN_A." <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile".getCBprofileItemid(true))."\">"._UE_USER_RETURN_B."</a><br/><br/>";
   ?>
   <script  type="text/javascript">
   setTimeout("location='<?php echo sefRelToAbs("index.php?option=com_comprofiler&task=userProfile".getCBprofileItemid()); ?>'",3500);
   </script>
   <?php
		} else if ($do=='deleteavatar') {

			if ($rowExtras->avatar != null && $rowExtras->avatar!="") {
				deleteAvatar($rowExtras->avatar);
				$_CB_database->setQuery("UPDATE  #__comprofiler SET avatar=null, avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id=" . (int) $row->id);
				$_CB_database->query();
			}



			cbRedirectToProfile( $row->id, _USER_DETAILS_SAVE );
		}
	}


/******************************
List Functions
******************************/

	function usersList( &$row, &$users, &$columns, &$allFields, &$lists, $listid, $search, $option_itemid, $limitstart, $limit, $total ) {
		global $_CB_database, $mosConfig_sitename, $ueConfig, $_PLUGINS, $_POST, $_GET, $_REQUEST, $my, $mainframe;

		$results				=	$_PLUGINS->trigger( 'onBeforeDisplayUsersList', array( &$row, &$users, &$columns, &$allFields, &$lists, $listid, &$search, &$option_itemid, 1 ) );	// $uid = 1

		// regroup parts of the different plugins:
		$pluginAdditions		=	array( 'header', 'footer' );
		$pluginAdditions['header']	=	array();
		$pluginAdditions['footer']	=	array();
		if ( is_array( $results ) && ( count( $results ) > 0 ) ) {
			foreach ($results as $res ) {
				if ( is_array( $res ) ) {
					foreach ( $res as $k => $v ) {
						$pluginAdditions[$k][]	=	$v;
					}
				}
			}
		}

		if ( method_exists($mainframe,"setPageTitle")) {
			$mainframe->setPageTitle( getLangDefinition($row->title) );
		}
		if ( method_exists($mainframe,"appendPathWay")) {
			$mainframe->appendPathWay( htmlspecialchars(getLangDefinition($row->title)) );
		}

		$cbSpoofField			=	cbSpoofField();
		$cbSpoofString			=	cbSpoofString();

		$spoofAmp				=	"&amp;" . $cbSpoofField . '=' . urlencode( $cbSpoofString );
		$ue_base_url			= "index.php?option=com_comprofiler&amp;task=usersList&amp;listid=" . $listid . $option_itemid; // . $spoofAmp;	// Base URL string
		$adminimagesdir			= "components/com_comprofiler/images/";


?>
<form name="adminForm" method="post" action="<?php echo sefRelToAbs($ue_base_url."&amp;action=search");?>" >
  <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
  	<tr>
  	  <td colspan="2"><span class="contentheading"><?php echo getLangDefinition($row->title); ?></span></td>
  	</tr>
  	<tr>
      <td valign="top" class="contentdescription" colspan="2">
	   <?php
if ((isset($search) && $search != "") || ($row->filterfields!='')) {
	echo "<b>" . $total . "</b> " . _UE_USERPENDAPPRACTION . ":";
} else {
	echo $mosConfig_sitename . " " . _UE_HAS . ": <b>" . $total . "</b> " . _UE_USERS;
}
	  ?></td>
	</tr>
	<tr>
	 <td>
	  <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
		<tr>
			<td style="width:50%;">
              			<input type="text" name="search" class="inputbox" size="15" maxlength="100"<?php 
if (isset($search)) echo " value=\"".htmlspecialchars($search)."\""; ?> />
              			<input type="image" src="<?php echo $adminimagesdir; ?>search.gif" alt="<?php echo _UE_SEARCH; ?>" align="top" style="border: 0px;" />
			</td>
			<td style="width:50%;text-align:right;">
				<?php echo $lists['plists']; ?>
			</td>
		</tr>
	  </table>
	  <?php
		echo cbGetSpoofInputTag( $cbSpoofString );
?>
	</td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
    		<td><a href="<?php echo sefRelToAbs($ue_base_url); ?>" onclick="javascript:adminForm.search.value=''"><?php echo _UE_LIST_ALL; ?></a></td>
    		<td align="right"></td>
        </tr>
      </table>

<?php
		if ( count( $pluginAdditions['header'] ) ) {
			echo '<div id="cbUserListHeader"><div>' . implode( '</div><div>', $pluginAdditions['header'] ) . '</div></div>';
		}
		if ( ( $limitstart != 0 ) || ( $limit <= $total ) ) {
?>
	<div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url.$spoofAmp, $search); ?></div>
<?php	}	?>

      <hr size="1" />
<script type="text/javascript"><!--//--><![CDATA[//><!--

var cbW3CDOM = (document.createElement && document.getElementsByTagName);
var cbUserURLs = new Array(<?php
	if (is_array($users)) {
		foreach($users as $user) {
			echo "\""
			.unHtmlspecialchars(sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$user->id.$option_itemid))."\",";
		}
	}
?>"");
function cbInitUserClick()
{
	if (!cbW3CDOM) return;
	var nav = document.getElementById('cbUserTable');
	var trs = nav.getElementsByTagName('tr');
	for (var i=0;i<trs.length;i++)
	{
		if (trs[i].id) {
			trs[i].onclick = cbUserClick;
		}
	}
}

function cbUserClick(thisevent)
{
/*	ddumpObject(thisevent,"event",3,0); */
/*	alert("clicked!"+this.toString()+window.event.target+window.event.currentTarget+(window.event.target==window.event.currentTarget));
*/
	var mine;
	if (thisevent) {
		// alert("event!"+thisevent.toString()+thisevent.target+thisevent.target.toString()+(thisevent.target.parentNode == this));
		mine = (thisevent.target.parentNode == this);
	} else if (window.event.target) {
		// alert("clickedWE!"+this.toString()+window.event.target+window.event.currentTarget+(window.event.target==window.event.currentTarget));
		mine = (window.event.target==window.event.currentTarget);
	} else if (window.event.srcElement) {
		// alert("eventSRC!"+window.event.srcElement+window.event.srcElement.toString()+(window.event.srcElement.parentNode == this));
		mine = (window.event.srcElement.parentNode == this);
	}
	if (mine) {
		window.location=cbUserURLs[this.id.substr(3)];		// cbUxxx --> xxx
	}
	return !mine;
}

function cbAddEvent(obj, evType, fn){ 
 if (obj.addEventListener){ 
   obj.addEventListener(evType, fn, true); 
   return true; 
 } else if (obj.attachEvent){ 
   var r = obj.attachEvent("on"+evType, fn); 
   return r; 
 } else { 
   return false; 
 }
}

cbAddEvent(window, 'load', cbInitUserClick);

//--><!]]></script>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="cbUserTable">
		<tr>
<?php
		$colsNbr = count( $columns );
		foreach ( $columns as $column ) {
			echo "\t\t\t<th><b>" . getLangDefinition( $column->title) . "</b></th>\n";
		}
?>

		</tr>
<?php
		$i = 0;
		if (is_array($users) && count($users)>0) {
			foreach($users as $user) {
				$class = "sectiontableentry" . ( 1 + ( $i % 2 ) );		// evenodd class

				if($ueConfig['allow_profilelink']==1) {
					$style = "style=\"cursor:hand;cursor:pointer;\"";
					$style .= " id=\"cbU".$i."\"" ;
					// $style .= " onclick=\"javascript:window.location='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$user->id.$option_itemid)."'\"";
				} else {
					$style = "";
				}
				if ( $user->banned ) {
					echo "\t\t<tr class=\"$class\"><td colspan=\"".$colsNbr."\"><span class=\"error\" style=\"color:red;\">"._UE_BANNEDUSER." ("._UE_VISIBLE_ONLY_MODERATOR.") :</span></td></tr>";
				}
				echo "\t\t<tr class=\"$class\" ".$style.">\n";
	
				foreach ( $columns as $column ) {
					echo "\t\t\t<td valign='top'>" . HTML_comprofiler::getUserListCell( $user, $column, $allFields, $option_itemid ) . "</td>\n";
				}
				echo "\t</tr>\n";
				$i++;
			}
		} else {
			echo "\t\t<tr class=\"sectiontableentry1\"><td colspan=\"".$colsNbr."\">"._UE_NO_USERS_IN_LIST."</td></tr>";
		}
?>
	</table>	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>&nbsp;</td>
			<td align="right"></td>
		</tr>
	</table>
	<hr size="1" />
<?php	if ( ( $limitstart != 0 ) || ( $limit <= $total ) ) {
?>

	<div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url.$spoofAmp, $search); ?></div>
<?php	}	?>

   </td>
  </tr>
 </table>
<?php
		if ( count( $pluginAdditions['footer'] ) ) {
			echo '<div id="cbUserListFooter"><div>' . implode( '</div><div>', $pluginAdditions['footer'] ) . '</div></div>';
		}
?>

</form>

<?php
	}	// end function usersList

	function getUserListCell( &$user, &$column, &$fields, $option_itemid ){

		$htmlFields		=	array();		
		
		foreach ( $column->fields as $fieldId ) {
 			$field		=	$fields[$fieldId];
			$name		=	$field->name;
			$title		=	"";

			if  ( $column->captions ) {
				$title	=	getLangDefinition( $field->title ) . ': ';
			}
			$html[]		=	getFieldValue( $field->type, $user->$name, $user, $title, 0,
										   ( $field->type=="predefined" ? sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=" . $user->id . $option_itemid ) : null ) );
		}
		return implode( '<br />', $html );
	}

/******************************
Registration Functions
******************************/

	function confirmation() {
		?>
	<table>
		<tr>
			<td><div class="componentheading"><?php echo _UE_SUBMIT_SUCCESS; ?></div></td>
		</tr>
		<tr>
			<td><?php echo _UE_SUBMIT_SUCCESS_DESC; ?></td>
		</tr>
	</table>
<?php
	}
	
	function lostPassForm($option) {
		global $_PLUGINS;
		
		$_PLUGINS->loadPluginGroup('user');
		$results = $_PLUGINS->trigger( 'onLostPassForm', array( 1 ));	//$ui=1
		if ($_PLUGINS->is_errors()) {
			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); window.history.go(-1); </script>\n";
			exit();
		}

//TODO: Add ability to change password on form.
		?>
<table cellpadding="4" cellspacing="0" border="0" width="98%" class="contentpane">
  <form action="<?php echo sefRelToAbs("index.php?option=".$option); ?>" id="adminForm" name="adminForm" method="post">
    <tr>
      <td colspan="2"><div class="componentheading"><?php echo _PROMPT_PASSWORD; ?></div></td>
    </tr>
    <tr>
      <td colspan="2"><?php echo _NEW_PASS_DESC; ?></td>
    </tr>
    <tr>
      <td><?php echo _PROMPT_UNAME; ?></td>
      <td><input type="text" name="checkusername" class="inputbox" size="40" maxlength="25" /></td>
    </tr>
    <tr>
      <td><?php echo _PROMPT_EMAIL; ?></td>
      <td><input type="text" name="confirmEmail" class="inputbox" size="40" /></td>
    </tr>
<?php
	if (is_array($results)) {
		foreach ( $results as $r ) {
			echo "    <tr>\n";
			echo "      <td>" . $r[0] . "</td>\n";
			echo "      <td>" . $r[1] . "</td>\n";
			echo "    </tr>\n";
		}
	}
?>
    <tr>
      <td colspan="2"> <input type="hidden" name="option" value="<?php echo $option;?>" />
        <input type="hidden" name="task" value="sendNewPass" />
        <?php
	echo cbGetSpoofInputTag();
?>
        <input type="submit" class="button" value="<?php echo _BUTTON_SEND_PASS; ?>" /></td>
    </tr>
  </form>
</table>
<?php
	}

	function registerForm($option, $emailpass, $rowFields, $rowFieldValues,$regErrorMSG=null) {
		global $mosConfig_live_site,$mosConfig_useractivation,$ueConfig,$_POST, $mainframe;
		
		outputCbTemplate(1);
		outputCbJs(1);
		echo initToolTip(1);
		if ( method_exists($mainframe,"setPageTitle")) {
			$mainframe->setPageTitle( _UE_REGISTRATION );
		}
		if ( method_exists($mainframe,"appendPathWay")) {
			$mainframe->appendPathWay( _UE_REGISTRATION );
		}
	
		// gets registration tabs from plugins (including the contacts tab core plugin for username, password, etc:
	
		$calendars = new cbCalendars(1);
		$tabs = new cbTabs( 0, 1);
		if ( $regErrorMSG!==null ) {
			$ptabsArray = $tabs->getRegistrationPluginTabs( $_POST );	// $ptabsArray[(int) $oTab->ordering_register][$oTab->position][(int) $oTab->ordering]
		} else {
			$null		= null;
			$ptabsArray = $tabs->getRegistrationPluginTabs( $null );	// $ptabsArray[(int) $oTab->ordering_register][$oTab->position][(int) $oTab->ordering]
		}
		
		$rowExtras="";
		$row = "";
		if($regErrorMSG!==null) {
			// gets values from post, in case we got an error:
			for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
				$oValue		=	null;
				if ( ! ( $rowFields[$i]->type=='delimiter') ) {
					$fieldName = $rowFields[$i]->name;
					if( isset($_POST[$rowFields[$i]->name]) ) {
						if (!is_array($_POST[$rowFields[$i]->name])) {
							$oValue = cbGetUnEscaped($_POST[$rowFields[$i]->name]);
						}
						if ($rowFields[$i]->type=='date') {
							$oValue=dateConverter($oValue,$ueConfig['date_format'],'Y-m-d');
						}
						if ($rowFields[$i]->type=='webaddress' && $rowFields[$i]->rows==2) {
							$oValue=$oValue."|*|".cbGetUnEscaped($_POST[$rowFields[$i]->name."Text"]);
						}
					} else $oValue = null;
					$rowExtras->$fieldName = $oValue;
				}
				
			}
		} else {
			// otherwise just sets to null all the fields:
			for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
				$fieldName = $rowFields[$i]->name;
				$rowExtras->$fieldName = null;
			}
		}
		
		// generates output for fields:
		
		for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
			$pfields='';
			$fieldName = $rowFields[$i]->name;
			$pfields .= "\t\t<tr id=\"cbfr_" . $rowFields[$i]->fieldid . "\">\n";
			$colspan = 2;
			if($rowFields[$i]->type=='delimiter') {
				$pfields .= "\t\t\t<td colspan=\"".$colspan."\" class=\"delimiterCell\">". unHtmlspecialchars(getLangDefinition($rowFields[$i]->title)) ."</td>\n";
				if ($rowFields[$i]->description) $pfields .= "\t\t\t</tr><tr><td colspan=\"".$colspan."\" class=\"descriptionCell\">". unHtmlspecialchars(getLangDefinition($rowFields[$i]->description)) ."</td>\n";
			} else {
				if(getLangDefinition($rowFields[$i]->title)!="") {
					$pfields .= "\t\t\t<td class=\"titleCell\">". getLangDefinition($rowFields[$i]->title) .":</td>";
					$colspan=1;
				}
				$oValue = $rowExtras->$fieldName;
				if(!ISSET($rowFields[$i]->id)) $rowFields[$i]->id="";
				if(!ISSET($rowFieldValues['lst_'.$rowFields[$i]->name])) $rowFieldValues['lst_'.$rowFields[$i]->name]="";
				$pfields .= "\t\t\t<td colspan=\"".$colspan."\" class=\"fieldCell\">".getFieldEntry(1,$calendars,$rowFields[$i]->type,$rowFields[$i]->name,$rowFields[$i]->description,$rowFields[$i]->title,$oValue,$rowFields[$i]->required,$rowFields[$i]->title,$rowFields[$i]->id,$rowFields[$i]->size, $rowFields[$i]->maxlength, $rowFields[$i]->cols, $rowFields[$i]->rows,$rowFields[$i]->profile,$rowFieldValues['lst_'.$rowFields[$i]->name],$rowFields[$i]->readonly)."</td>\n";
			}
			$pfields .= "\t\t</tr>\n";
			if ( ! isset( $ptabsArray[(int) $rowFields[$i]->tab_ordering_register][$rowFields[$i]->tab_position][(int) $rowFields[$i]->tab_ordering] ) ) {
				$ptabsArray[(int) $rowFields[$i]->tab_ordering_register][$rowFields[$i]->tab_position][(int) $rowFields[$i]->tab_ordering]	=	'';
			}
			$ptabsArray[(int) $rowFields[$i]->tab_ordering_register][$rowFields[$i]->tab_position][(int) $rowFields[$i]->tab_ordering] .= $pfields;
		
		}

		// now generates output from the sorted $ptabsArray:

		ksort( $ptabsArray );

		// starts outputing:
	
	
		$cbSpoofField			=	cbSpoofField();
		$cbSpoofString			=	cbSpoofString();
		$regAntiSpamFieldName	=	cbGetRegAntiSpamFieldName();
		$regAntiSpamValues		=	cbGetRegAntiSpams();
?>
<script type="text/javascript" src="includes/js/mambojavascript.js"></script>
<script type="text/javascript"><!--//--><![CDATA[//><!--
var cbDefaultFieldBackground;
function submitbutton(mfrm) {
	var me = mfrm.elements;
<?php
		$version = checkJversion();
		if ($version == 1) {
?>
	var r = new RegExp("^[a-zA-Z](([\.\-a-zA-Z0-9@])?[a-zA-Z0-9]*)*$", "i");
<?php
		} elseif ( $version == -1 ) {
?>
	var r = new RegExp("[^A-Za-z0-9]", "i");
<?php
		} else {
?>
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
<?php
		}
?>
	var errorMSG = '';
	var iserror=0;
	if (cbDefaultFieldBackground === undefined) cbDefaultFieldBackground = ((me['username'].style.getPropertyValue) ? me['username'].style.getPropertyValue("backgroundColor") : me['username'].style.backgroundColor);
<?php echo $tabs->fieldJS; ?>
	if (me['username'].value == "") {
		errorMSG += "<?php echo unhtmlentities(_REGWARN_UNAME);?>\n";
		me['username'].style.backgroundColor = "red";
		iserror=1;
	} else if (<?php if ($version==1) echo "!"; ?>r.exec(me['username'].value) || (me['username'].value.length < 3)) {
		errorMSG += "<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_PROMPT_UNAME), 2 );?>\n";
		me['username'].style.backgroundColor = "red";
		iserror=1;
	} else if (me['username'].style.backgroundColor.slice(0,3)=="red") { me['username'].style.backgroundColor = cbDefaultFieldBackground;
<?php if ($emailpass!="1") { ?>
	} if (<?php if ($version==1) echo "!"; ?>r.exec(me['password'].value) || (me['password'].value.length < 6)) {
		errorMSG += "<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_REGISTER_PASS), 6 );?>\n";
		me['password'].style.backgroundColor = "red";
		iserror=1;
	} else if ((me['password'].value != "") && (me['password'].value != me['verifyPass'].value)){
		errorMSG += "<?php echo unhtmlentities(_REGWARN_VPASS2);?>\n";
		me['password'].style.backgroundColor = "red"; me['verifyPass'].style.backgroundColor = "red";
		iserror=1;
	} else {
		if (me['password'].style.backgroundColor.slice(0,3)=="red") me['password'].style.backgroundColor = cbDefaultFieldBackground;
		if (me['verifyPass'].style.backgroundColor.slice(0,3)=="red") me['verifyPass'].style.backgroundColor = cbDefaultFieldBackground;
<?php } ?>
	}
<?php	if($ueConfig['reg_enable_toc']) { ?>
	if(!me['acceptedterms'].checked) {
		errorMSG += "<?php echo unhtmlentities(_UE_TOC_REQUIRED); ?>\n";
		iserror=1;
	}
<?php	} ?>
	// loop through all input elements in form
	for (var i=0; i < me.length; i++) {
		// check if element is mandatory; here mosReq="1"
		if ( (typeof(me[i].getAttribute('mosReq')) != "undefined") && ( me[i].getAttribute('mosReq') == 1) ) {
			if (me[i].type == 'radio' || me[i].type == 'checkbox') {
				var rOptions = me[me[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						if (rOptions[r].checked) {
							rChecked=1;
						}
					}
				} else {
					if (me[i].checked) {
						rChecked=1;
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
					// notify user by changing background color, in this case to red
					me[i].style.backgroundColor = "red";
					iserror=1;
				} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldBackground;
			}
			if (me[i].value == '') {
				// add up all error messages
				errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
				// notify user by changing background color, in this case to red
				me[i].style.backgroundColor = "red";
				iserror=1;
			} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldBackground;
		}
	}
	if(iserror==1) {
		alert(errorMSG);
		return false;
	} else {
		return true;
	}
}
<?php
		if ( ( isset( $ueConfig['reg_username_checker'] ) ) && ( $ueConfig['reg_username_checker'] ) ) {
?>

var cbUnameXhttp;
var cbLastUsername = '';

function cbSendUsernameCheck(meButton) {
<?php
			$version = checkJversion();
			if ($version == 1) {
?>
	var r = new RegExp("^[a-zA-Z](([\.\-a-zA-Z0-9@])?[a-zA-Z0-9]*)*$", "i");
<?php
			} elseif ( $version == -1 ) {
?>
	var r = new RegExp("[^A-Za-z0-9]", "i");
<?php
			} else {
?>
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
<?php
			}
?>
	var myFormEls = cbParentForm(meButton).elements;
	var usernameVal = myFormEls['username'].value;
	if (usernameVal == cbLastUsername) {
		return false;
	}
	cbLastUsername = usernameVal;

	if (usernameVal.length == 0) {
		document.getElementById('usernameCheckResponse').innerHTML = '';
		return false;
	}
	if (<?php if ($version==1) echo "!"; ?>r.exec(usernameVal) || (usernameVal.length < 3)) {
		document.getElementById('usernameCheckResponse').innerHTML = '';
		alert('<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_PROMPT_UNAME), 2 );?>\n');
		return false;
	}
	cbUnameXhttp = CBgetHttpRequestInstance();
	if (cbUnameXhttp) {
		var usernameCheckResponseDiv = document.getElementById('usernameCheckResponse');
		// document.getElementById('usernameCheckResponse').innerHTML = '<img src=\"components/com_comprofiler/images/cb_wheel.gif\" /> <?php echo _UE_CHECKING; ?>';
		document.getElementById('usernameCheckResponse').innerHTML = '';
		CBmakeHttpRequest('index2.php?option=com_comprofiler&task=checkusernameavailability&no_html=1&format=raw', 'usernameCheckResponse', '<?php 
							echo ''; /* unHtmlspecialchars( _UE_SORRY_CANT_CHECK ); */ ?>', 'username=' + encodeURI(usernameVal) + '&<?php
							echo $cbSpoofField; ?>=' + encodeURI('<?php echo $cbSpoofString; ?>') + '&<?php
							echo $regAntiSpamFieldName; ?>=' + encodeURI('<?php echo $regAntiSpamValues[0]; ?>'), cbUnameXhttp );
	}
	return false;
}
<?php 	} ?>

//--><!]]></script>
<?php

		if ($regErrorMSG) echo "<div class='error'>".$regErrorMSG."</div>\n";
?>
<div style="align:center;" id="cbIconsTop"><?php
		echo getFieldIcons(1,true,true,"","",true);		// to remove top icons explanation just comment or remove this line
?></div>
<form action="<?php echo sefRelToAbs("index.php?option=".$option); ?>" method="post" id="adminForm" name="adminForm" onsubmit="return submitbutton(this)">
<table cellpadding="5" cellspacing="0" border="0" width="98%" class="contentpane" id="registrationTable">
    <tr>
      <td colspan="2" width="100%"><div class="componentheading"><?php echo _REGISTER_TITLE; ?></div></td>
    </tr>
<?php
		if (isset($ueConfig['reg_intro_msg']) and ($ueConfig['reg_intro_msg'])) {
?>
    <tr>
      <td colspan="2" width="100%" class="contentpaneopen"><?php echo stripslashes(getLangDefinition($ueConfig['reg_intro_msg'])); ?></td>
    </tr>
<?php
		}
	
		// outputs all tabs, including contact tab:

		foreach ($ptabsArray as $ptabsPositionsArray ) {
			foreach ($ptabsPositionsArray as $ptabsOrderingArray ) {
				echo implode( $ptabsOrderingArray );
			}
		}

		// outputs the site terms and conditions link and approval checkbox:

		if($ueConfig['reg_enable_toc']) {
			echo "\t<tr>\n";
		      	echo "\t\t<td>&nbsp;</td>\n<td class='fieldCell'><input type='checkbox' name='acceptedterms' value='1' mosReq='0' mosLabel='"._UE_TOC."' /> "
		      	. sprintf(_UE_TOC_LINK,"<a href='".sefRelToAbs(htmlspecialchars($ueConfig['reg_toc_url']))."' target='_BLANK'> ","</a>") . "</td>\n";
			echo "\t</tr>\n";
		}
		
		// outputs conclusion text and different default values:
?>
    <tr>
      <td colspan="2" width="100%" class="contentpaneopen"><?php
   	  if (isset($ueConfig['reg_conclusion_msg']) and ($ueConfig['reg_conclusion_msg'])) {
 		echo stripslashes(getLangDefinition($ueConfig['reg_conclusion_msg']));
   	  } else {
   	  	echo "&nbsp;";
   	  }
   	  ?></td>
    </tr>
    <tr>
      <td colspan="2">
		<input type="hidden" name="id" value="0" />
		<input type="hidden" name="gid" value="0" />
		<input type="hidden" name="emailpass" value="<?php echo $emailpass;?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="saveregisters" />
		<?php
		echo cbGetSpoofInputTag( $cbSpoofString );
		echo "\t\t" . cbGetRegAntiSpamInputTag( $regAntiSpamValues );
?>
		<input type="submit" value="<?php echo _BUTTON_SEND_REG; ?>" class="button" />
      </td>
    </tr>
</table>
</form>
<div style="align:center;" id="cbIconsBottom"><?php
		echo getFieldIcons(1,true,true,"","",true);		// to remove bottom icons explanation just comment or remove this line
?></div>
<?php
		// finally small javascript to focus on first field on registration form if there is no introduction text and it's a text field:

		if ( ! ( isset( $ueConfig['reg_intro_msg'] ) && ( $ueConfig['reg_intro_msg'] ) ) ) {
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
function cbIEfocus() {
	if ( document.forms['adminForm'].elements[0].type == 'text' ) {
		document.forms['adminForm'].elements[0].focus();
	}
}
if (window.addEventListener) window.addEventListener("load", cbIEfocus, true);
else if (window.attachEvent) window.attachEvent("onload", cbIEfocus);
else cbIEfocus();
//--><!]]></script>
<?php
		}
	}


/******************************
Moderation Functions
******************************/

	function reportUserForm($option,$uid)
	{
	global $_CB_database,$ueConfig,$my, $Itemid;
	if($ueConfig['allowUserReports']==0) {
			echo _UE_FUNCTIONALITY_DISABLED;
			return;
	}
	HTML_comprofiler::outputMosFormVal();
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo _UE_REPORTUSER_TITLE; ?></div></td>
	</tr>
</table> 
<form action='<?php
	echo sefRelToAbs('index.php?option=com_comprofiler&amp;task=reportUser'.($Itemid ? "&amp;Itemid=".$Itemid : ""));
		?>' method="post" id="adminForm" name="adminForm" onsubmit="return submitbutton(this)">
<table width='100%' border='0' cellpadding='4' cellspacing='2'>
<tr align='left' valign='middle'>
	<td colspan="4">
<br /><br />
<?php echo _UE_REPORTUSERSACTIVITY; ?><br />
<textarea mosReq="1" mosLabel="User Report" mosLength="4000" cols="50" rows="10" name="reportexplaination"></textarea>
<br /><br />
</td></tr>
<tr><td colspan="4" align="center">
<input class="button" type="submit" value="<?php echo _UE_SUBMITFORM; ?>" />
</td></tr>
</table>
<input type="hidden" name="reportedbyuser" value="<?php echo $my->id; ?>" />
<input type="hidden" name="reporteduser" value="<?php echo $uid; ?>" />
<input type="hidden" name="reportform" value="0" />
<?php
	echo cbGetSpoofInputTag();
?>
</form>
<?php
}

	function banUserForm($option,$uid,$act,$orgbannedreason)
	{
	global $_CB_database,$ueConfig,$my, $Itemid;
	if($ueConfig['allowUserBanning']==0) {
			echo _UE_FUNCTIONALITY_DISABLED;
			return;
	}
	HTML_comprofiler::outputMosFormVal();
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php if($my->id != $uid) echo _UE_REPORTBAN_TITLE; ELSE echo _UE_REPORTUNBAN_TITLE;; ?></div></td>
	</tr>
</table>
<form action='<?php 
	echo sefRelToAbs('index.php?option=com_comprofiler&amp;task=banProfile&amp;act='.(($my->id != $uid) ? '1': '2').'&amp;user='.$uid.($Itemid ? "&amp;Itemid=".$Itemid : ""))
		?>' method="post" id="adminForm" name="adminForm" onsubmit="return submitbutton(this)">
<table width='100%' border='0' cellpadding='4' cellspacing='2'>
<tr align='left' valign='middle'>
<td colspan="4">
<br /><br />
<?php if($my->id != $uid) echo _UE_BANREASON; ELSE echo _UE_UNBANREQUEST; ?><br />
<textarea mosReq="1" mosLabel='<?php if($my->id != $uid) echo _UE_BANREASON; ELSE echo _UE_UNBANREQUEST; ?>' mosLength="4000" cols="50" rows="10" name="bannedreason"></textarea>
<br /><br />
</td></tr>
<tr><td colspan="4" align="center">
<input class="button" type="submit" value="<?php echo _UE_SUBMITFORM; ?>" />
</td></tr>
</table>
<input type="hidden" name="bannedby" value="<?php echo $my->id; ?>" />
<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
<input type="hidden" name="orgbannedreason" value="<?php echo $orgbannedreason; ?>" />
<input type="hidden" name="reportform" value="0" />
<?php
	echo cbGetSpoofInputTag();
?>
</form>
<?php
}

function pendingApprovalUsers($option,$users) {
	global $ueConfig, $my, $Itemid;

?>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo _UE_MODERATE_TITLE; ?></div></td>
	</tr>
</table>
<?php
	if(count($users)<1) {
		echo _UE_NOUSERSPENDING;
		return;
	} 
?>    
<br />                    
<span class='contentheading'><?php echo _UE_USERAPPROVAL_MODERATE; ?></span><br /><br />
          <form action='<?php echo sefRelToAbs("index.php?option=$option".($Itemid ? "&amp;Itemid=".$Itemid : "")); ?>' method='post' id='adminForm' name='adminForm'>
          <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead><tr align='left'>
		<th>&nbsp;</th>
		<th><?php echo _UE_USER; ?></th>
		<th><?php echo _UE_EMAIL; ?></th>
		<th><?php echo _UE_REGISTERDATE; ?></th>
		<th><?php echo _UE_COMMENT; ?></th>
		</tr></thead>	
<?php  
		for($i = 0; $i < count($users); $i++) {
			echo "<tr align='left' valign='middle'>";
			echo "<td><input id='u".$users[$i]->id."' type=\"checkbox\" checked=\"checked\" name=\"uids[]\" value=\"".$users[$i]->id."\" /></td>";
			echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$users[$i]->id.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($users[$i]->name,$users[$i]->username,$ueConfig['name_format']). "</a></td>";
			echo "<td>".$users[$i]->email."</td>";
			echo "<td>".cbFormatDate($users[$i]->registerDate)."</td>";
			echo "<td><textarea name='comment".$users[$i]->id."' cols='20' rows='3'></textarea></td>";
			echo "</tr>";
		}
		echo '<tr align="center" valign="middle"><td colspan="5">'
		.'<input class="button" style="background-color:#CFC;" onclick="this.form.task.value=\'approveUser\';this.form.submit();" type="button" value="'._UE_APPROVE.'" />'
		.'&nbsp;&nbsp;&nbsp;'
		.'<input class="button" style="background-color:#FCC;" onclick="this.form.task.value=\'rejectUser\';this.form.submit();" type="button" value="'._UE_REJECT.'" /></td></tr>';
		echo "</table>\n";
		echo "<input type='hidden' name='task' value='' />\n";
		echo "<input type='hidden' name='option' value='".$option."' />\n";
		echo cbGetSpoofInputTag();
		echo "</form>\n";
}
function manageConnections($connections,$actions,$connecteds=null) {
	global $ueConfig, $my, $_REQUEST, $Itemid;

	$ui=1;
	outputCbTemplate($ui);
    echo initToolTip($ui);
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
var tabPanemyCon;
function showCBTab( sName ) {
	if (typeof tabPanemyCon != "undefined" ) {
		switch ( sName.toLowerCase() ) {
			case "<?php echo strtolower(_UE_MANAGEACTIONS); ?>":
			case "manageactions":
			case "0":
				tabPanemyCon.setSelectedIndex( 0 );
				break;
			case "<?php echo strtolower(_UE_MANAGECONNECTIONS); ?>":
			case "manageaonnections":
			case "1":
				tabPanemyCon.setSelectedIndex( 1 );
				break;
			case "<?php echo strtolower(_UE_CONNECTEDWITH); ?>":
			case "connectedfrom":
			case "2":
				tabPanemyCon.setSelectedIndex( 2 );
				break;
		}
	}
}

  function confirmSubmit() {
	if (confirm("<?php echo _UE_CONFIRMREMOVECONNECTION; ?>"))
		return true ;
	else
		return false ;
}
//--><!]]></script>
<?php
	$tabs = new cbTabs( 0, $ui);
	$cTypes=explode("\n",$ueConfig['connection_categories']);
	$connectionTypes=array();
	foreach($cTypes as $cType) {
		if(trim($cType)!=null && trim($cType)!="") $connectionTypes[]=mosHTML::makeOption( trim($cType) , getLangDefinition(trim($cType)) );
	}
	echo $tabs->startPane("myCon");
	
	// Tab 0: Manange Actions:
	echo $tabs->startTab("myCon",_UE_MANAGEACTIONS." (".count($actions).")","action");
	if(!count($actions)>0) {
		echo _UE_NOACTIONREQUIRED;
	} else {
?>
	<form method='post' action='<?php 
	echo sefRelToAbs('index.php?option=com_comprofiler&amp;task=processConnectionActions'.($Itemid ? "&amp;Itemid=".$Itemid : ""));
		?>'>
<?php
	echo "\t\t<div class=\"tab_Description\">"._UE_CONNECT_ACTIONREQUIRED."</div>\n";
	// echo "<div style=\"width:100%;text-align:right;\"><input type=\"submit\" class=\"inputbox\"  value=\""._UE_UPDATE."\" /></div>";
	echo "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
	echo "<tr>";
	echo "<td>";
	foreach($actions AS $action) {
		$conAvatar = null;
		$conAvatar = getFieldValue('image',$action->avatar,$action);
		$onlineIMG = ($ueConfig['allow_onlinestatus']==1) ? getFieldValue('status',$action->isOnline,$action,null,1) : "";

		$tipField = "<b>"._UE_CONNECTIONREQUIREDON."</b> : ".dateConverter($action->membersince,'Y-m-d',$ueConfig['date_format']);
		if($action->reason!=null) $tipField .= "<br /><b>"._UE_CONNECTIONMESSAGE."</b> :<br />".htmlspecialchars($action->reason, ENT_QUOTES);
		$tipTitle = _UE_CONNECTIONREQUESTDETAIL;
		$htmltext = $conAvatar;
		$style = "style=\"padding:5px;\"";
		$tooltip = cbFieldTip($ui, $tipField, $tipTitle, $width='250', $icon='', $htmltext, $href='', $style, $olparams='',false);
		
		echo "<div class=\"connectionBox\">";
		echo $onlineIMG.' '.getNameFormat($action->name,$action->username,$ueConfig['name_format'])."<br />"
			.$tooltip
			."<br /><img src=\"components/com_comprofiler/images/tick.png\" border=\"0\" alt=\""._UE_ACCEPTCONNECTION
			."\" title=\""._UE_ACCEPTCONNECTION."\" /><input type=\"radio\"  value=\"a\" checked=\"checked\" name=\"".$action->id
			."action\"/> <img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_DECLINECONNECTION
			."\" title=\""._UE_DECLINECONNECTION."\" /><input type=\"radio\" value=\"d\" name=\"".$action->id
			."action\"/><input type=\"hidden\" name=\"uid[]\" value=\"".$action->id."\" />";
		echo " </div>\n";
	}

	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<div style=\"width:100%;text-align:right;\"><input type=\"submit\" class=\"inputbox\"  value=\""._UE_UPDATE."\" /></div>";
	echo cbGetSpoofInputTag();
	echo "</form>";
	}
	echo $tabs->endTab();
	
	// Tab 1: Manange Connections:
	echo $tabs->startTab("myCon",_UE_MANAGECONNECTIONS,"connections");
	if(!count($connections)>0) {
		echo _UE_NOCONNECTIONS;
	} else {
?>
	<form action='<?php 
	echo sefRelToAbs('index.php?option=com_comprofiler&amp;task=saveConnections'.($Itemid ? "&amp;Itemid=".$Itemid : ""));
		?>' method='post' name='userAdmin'>
	<div class="tab_Description"><?php echo _UE_CONNECT_MANAGECONNECTIONS; ?></div>
	<table cellpadding="5" cellspacing="0" border="0" width="95%">
	  <thead><tr>
		<th style='text-align:center;'><?php echo _UE_CONNECTION; ?></th>
		<th style='text-align:center;'><?php echo _UE_CONNECTIONTYPE; ?></th>
		<th style='text-align:center;'><?php echo _UE_CONNECTIONCOMMENT; ?></th>
	  </tr></thead>
	  <tbody>
<?php
		$i=1;
		foreach($connections AS $connection) {
		$ks=explode("|*|",trim($connection->type));
		$k = array();
		foreach($ks as $kv) {
			$k[]->value=$kv;
		}
	$list=array();
	$list['connectionType'] = moscomprofilerHTML::selectList( $connectionTypes, $connection->id.'connectiontype[]', 'class="inputbox" multiple="multiple" size="5"', 'value', 'text', $k,0 );
	$conAvatar = null;
	$conAvatar = getFieldValue('image',$connection->avatar,$connection);
	$emailIMG  = getFieldValue('primaryemailaddress',$connection->email,$connection,null,1);
	$pmIMG	   = getFieldValue('pm',$connection->username,$connection,null,1);
	$onlineIMG = ($ueConfig['allow_onlinestatus']==1) ? getFieldValue('status',$connection->isOnline,$connection,null,1) : "";
	if($connection->accepted==1 && $connection->pending==1) $actionIMG = "<img src=\"components/com_comprofiler/images/pending.png\" border=\"0\" alt=\""._UE_CONNECTIONPENDING."\" title=\""._UE_CONNECTIONPENDING."\" /> <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connection->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\" onclick=\"return confirmSubmit();\" ><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_REMOVECONNECTION."\" /></a>";
	elseif($connection->accepted==1 && $connection->pending==0) $actionIMG="<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connection->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\" onclick=\"return confirmSubmit();\" ><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_REMOVECONNECTION."\" /></a>";
	elseif($connection->accepted==0) $actionIMG="<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=acceptConnection&amp;connectionid=".$connection->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\"><img src=\"components/com_comprofiler/images/tick.png\" border=\"0\" alt=\""._UE_ACCEPTCONNECTION."\" title=\""._UE_ACCEPTCONNECTION."\" /></a> <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connection->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\"><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_DECLINECONNECTION."\" /></a>";

	$tipField = "<b>"._UE_CONNECTEDSINCE."</b> : ".dateConverter($connection->membersince,'Y-m-d',$ueConfig['date_format']);
	if($connection->type!=null) $tipField .= "<br /><b>"._UE_CONNECTIONTYPE."</b> : ".getConnectionTypes($connection->type);
	if($connection->description!=null) $tipField .= "<br /><b>"._UE_CONNECTEDCOMMENT."</b> : ".htmlspecialchars($connection->description);
	$tipTitle = _UE_CONNECTEDDETAIL;
	$htmltext = $conAvatar;
	$style = "style=\"padding:5px;\"";
	$tooltip = cbFieldTip($ui, $tipField, $tipTitle, $width='200', $icon='', $htmltext, $href='', $style, $olparams='',false);

	echo "\n<tr style='vertical-align:top;' class='sectiontableentry".$i."'>";
	echo "\n\t<td style='text-align:center;'>".$onlineIMG.' '.getNameFormat($connection->name,$connection->username,$ueConfig['name_format'])
	."<br />".$tooltip."<br />"
	.$actionIMG." <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$connection->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))
	."\"><img src=\"components/com_comprofiler/images/profiles.gif\" border=\"0\" alt=\""._UE_VIEWPROFILE."\" title=\""._UE_VIEWPROFILE
	."\" /></a> ".$emailIMG." ".$pmIMG."</td>";
	echo "\n\t<td style='text-align:center;'>".$list['connectionType']."</td>";
	echo "\n\t<td style='text-align:center;'><textarea cols=\"25\" class=\"inputbox\"  rows=\"5\" name=\"".$connection->id."description\">".$connection->description."</textarea><input type=\"hidden\" name=\"uid[]\" value=\"".$connection->id."\" /></td>";
	echo "\n</tr>";
	$i= ($i==1) ? 2 : 1;
	}
	echo "</tbody>";
	echo "</table><br />";
	echo "<div style=\"width:100%;text-align:right;\"><input type=\"submit\" class=\"inputbox\"  value=\""._UE_UPDATE."\" /></div>";
	echo cbGetSpoofInputTag();
	echo "</form>";
	}
	echo $tabs->endTab();

	// Tab 2: Users connected with me:
	if($ueConfig['autoAddConnections']==0) {
		echo $tabs->startTab("myCon",_UE_CONNECTEDWITH,"connected");
		if(!count($connecteds)>0) {
			echo _UE_NOCONNECTEDWITH;
		} else {

			echo "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
			echo "<tr>";
			echo "<td>";
			foreach($connecteds AS $connected) {
				$conAvatar=null;
				$conAvatar = getFieldValue('image',$connected->avatar,$connected);
				$emailIMG  = getFieldValue('primaryemailaddress',$connected->email,$connected,null,1);
				$pmIMG	   = getFieldValue('pm',$connected->username,$connected,null,1);
				$onlineIMG = ($ueConfig['allow_onlinestatus']==1) ? getFieldValue('status',$connected->isOnline,$connected,null,1) : "";
				if($connected->accepted==1 && $connected->pending==1) $actionIMG = "<img src=\"components/com_comprofiler/images/pending.png\" border=\"0\" alt=\""._UE_CONNECTIONPENDING."\" title=\""._UE_CONNECTIONPENDING."\" /> <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connected->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\"><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_REMOVECONNECTION."\" /></a>";
				elseif($connected->accepted==1 && $connected->pending==0) $actionIMG="<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connected->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\"><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_REMOVECONNECTION."\" /></a>";
				elseif($connected->accepted==0) $actionIMG="<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=acceptConnection&amp;connectionid=".$connected->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\"><img src=\"components/com_comprofiler/images/tick.png\" border=\"0\" alt=\""._UE_ACCEPTCONNECTION."\" title=\""._UE_ACCEPTCONNECTION."\" /></a> <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connected->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))."\"><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_DECLINECONNECTION."\" /></a>";

				$tipField = "<b>"._UE_CONNECTEDSINCE."</b> : ".dateConverter($connected->membersince,'Y-m-d',$ueConfig['date_format']);
				if(getLangDefinition($connected->type)!=null) $tipField .= "<br /><b>"._UE_CONNECTIONTYPE."</b> : ".getLangDefinition($connected->type);
				if($connected->description!=null) $tipField .= "<br /><b>"._UE_CONNECTEDCOMMENT."</b> : ".htmlspecialchars($connected->description);
				$tipTitle = _UE_CONNECTEDDETAIL;
				$htmltext = $conAvatar;
				$style = "style=\"padding:5px;\"";
				$tooltip = cbFieldTip($ui, $tipField, $tipTitle, $width='200', $icon='', $htmltext, $href='', $style, $olparams='',false);

				echo "<div class=\"connectionBox\">";
				echo $actionIMG.'<br />';
				echo $tooltip."<br />";
				echo $onlineIMG." ".getNameFormat($connected->name,$connected->username,$ueConfig['name_format']);
				echo "<br /><a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$connected->memberid.($Itemid ? "&amp;Itemid=".$Itemid : ""))
				."\"><img src=\"components/com_comprofiler/images/profiles.gif\" border=\"0\" alt=\""._UE_VIEWPROFILE
				."\" title=\""._UE_VIEWPROFILE."\" /></a> ".$emailIMG." ".$pmIMG."\n";
				echo " </div>\n";
			}
			echo "</td>";
			echo "</tr>";
			echo "</table>";
		}
		echo $tabs->endTab();	
	}
	echo $tabs->endPane();
	if ( isset($_REQUEST['tab'] ) ) {
		echo "<script type=\"text/javascript\">showCBTab( '" . urldecode( cbGetParam( $_REQUEST, 'tab' ) ) . "' );</script>";
	} elseif ( ! ( count( $actions ) > 0 ) ) {
		echo "<script type=\"text/javascript\">tabPanemyCon.setSelectedIndex( 1 );</script>";
	}
	echo '<div style="clear:both;"><a href="' . cbSefRelToAbs( 'index.php?option=com_comprofiler' . getCBprofileItemid( true ) ) . '">' . _UE_BACK_TO_YOUR_PROFILE . '</a></div>';
}

}	// end class HTML_comprofiler

	function moderateBans( $option, $act, $uid ) {
	global $_CB_database, $ueConfig, $my, $Itemid, $_REQUEST;
	
	$isModerator=isModerator($my->id);
	if ( ( $isModerator == 0 ) || ( ( $act == 2 ) && ( $uid == $my->id ) ) ) {
		mosNotAuth();
		return;
	}
	$ue_base_url = "index.php?option=com_comprofiler&amp;task=moderateBans".($Itemid ? "&amp;Itemid=".$Itemid : "");	// Base URL string

	if ( $act == 2 ) {
		$query = "SELECT count(*) FROM #__comprofiler WHERE NOT(ISNULL(bannedby)) AND approved=1 AND confirmed=1 AND id=" . (int) $uid;
	} else {
		$query = "SELECT count(*) FROM #__comprofiler WHERE banned=2 AND approved=1 AND confirmed=1 AND id!=".(int) $my->id;
	}
	if(!$_CB_database->setQuery($query)) print $_CB_database->getErrorMsg();
	$total = $_CB_database->loadResult();

	$limitstart	= (int) cbGetParam( $_REQUEST, 'limitstart', 0 );
	if (empty($limitstart)) {
		$limitstart = 0;
	}
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query	=	"SELECT c.id, c.banned, u2.name AS bannedbyname, u2.username as bannedbyusername, u3.name AS unbannedbyname, u3.username as unbannedbyusername, "
			.	"u.name as bannedname, u.username as bannedusername, c.banneddate, c.unbanneddate, c.bannedreason, c.bannedby, c.unbannedby"
			.	"\n FROM jos_comprofiler AS c"
			.	"\n INNER JOIN jos_users AS u ON u.id=c.id"
			.	"\n INNER JOIN jos_users AS u2 ON u2.id= c.bannedby"
			.	"\n LEFT JOIN jos_users AS u3 ON  u3.id = c.unbannedby";
	if ( $act == 2 ) {
		$query	.=	"\n WHERE NOT(ISNULL(c.bannedby)) AND c.id = " . (int) $uid;
	} else {
		$query	.=	"\n WHERE c.banned = 2 AND c.id != " . (int) $uid;
	}
	$query	.=	" AND  c.approved = 1 AND c.confirmed = 1";
	$query	.=	"\n LIMIT $limitstart, $limit";
	$_CB_database->setQuery($query);
	$row = $_CB_database->loadObjectList();

	outputCbTemplate(1);
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo _UE_MODERATE_TITLE; ?></div></td>
	</tr>
</table>   
<?php
if($total<1) {
	echo _UE_NOUNBANREQUESTS;
	return;
}  
?>                  
<div class='contentheading'><?php echo _UE_UNBAN_MODERATE; ?></div>
<p><?php echo _UE_UNBAN_MODERATE_DESC; ?></p>
     <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead><tr align='left'>
		<th><?php echo _UE_BANNEDUSER; ?></th>
		<th><?php echo _UE_BANNEDREASON; ?></th>
		<th><?php echo _UE_BANNEDON; ?></th>
		<th><?php echo _UE_BANNEDBY; ?></th>
		<th><?php echo _UE_UNBANNEDON; ?></th>
		<th><?php echo _UE_UNBANNEDBY; ?></th>
		<th><?php echo _UE_BANSTATUS; ?></th>
		</tr></thead>	
<?php  
     for($i = 0; $i < count($row); $i++) {
	     echo "<tr align='left' valign='middle'>";
             echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->id.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->bannedname,$row[$i]->bannedusername,$ueConfig['name_format']). "</a></td>";
	     echo "<td>".nl2br($row[$i]->bannedreason)."</td>";  
	     echo "<td>".dateConverter($row[$i]->banneddate,'Y-m-d',$ueConfig['date_format'])."</td>";
             echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->bannedby.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->bannedbyname,$row[$i]->bannedbyusername,$ueConfig['name_format']). "</a></td>";           
	     echo "<td>".dateConverter($row[$i]->unbanneddate,'Y-m-d',$ueConfig['date_format'])."</td>";
             echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->unbannedby.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->unbannedbyname,$row[$i]->unbannedbyusername,$ueConfig['name_format']). "</a></td>";
             echo "<td>";
             switch ( $row[$i]->banned ) {
             	case 1:
             		echo '<span style="color:red;">' . _UE_BANSTATUS_BANNED  . '</span>';
             		break;
                case 2:
             		echo '<span style="color:orange;">' . _UE_BANSTATUS_UNBAN_REQUEST_PENDING  . '</span>';
             		break;          
             	default:
              		echo '<span style="color:green;">' . _UE_BANSTATUS_PROCESSED  . '</span>';
            		break;
             }
             echo "</td>";
	     echo '</tr>';
     }
     echo '</table>';
     if ($total > $limit) { ?>
<hr /><div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div>
<?php
     }
}


	function moderateReports($option) {
	global $_CB_database, $ueConfig, $my, $Itemid, $_REQUEST;
	
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		mosNotAuth();
		return;
	}
	$ue_base_url = "index.php?option=com_comprofiler&amp;task=moderateReports".($Itemid ? "&amp;Itemid=".$Itemid : "");	// Base URL string


	$query = "SELECT count(*) FROM #__comprofiler_userreports  WHERE reportedstatus=0 ";
	if (!$_CB_database->setQuery($query)) {
		print $_CB_database->getErrorMsg();
	}
	$total = $_CB_database->loadResult();
	
	if($total<1) {
		echo _UE_NONEWUSERREPORTS;
		return;
	}
	
	$limitstart	= intval( cbGetParam( $_REQUEST, 'limitstart', 0 ) );
	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT u2.name as reportedbyname, u2.username as reportedbyusername, u.name as reportedname, u.username as reportedusername, ur.* FROM #__users u, #__comprofiler_userreports ur, #__users u2 WHERE u.id=ur.reporteduser AND u2.id=ur.reportedbyuser AND  ur.reportedstatus=0 ORDER BY ur.reporteduser,ur.reportedondate";
	$query .= " LIMIT $limitstart, $limit";
	$_CB_database->setQuery($query);
	$row = $_CB_database->loadObjectList();

	outputCbTemplate(1);
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo _UE_MODERATE_TITLE; ?></div></td>
	</tr>
</table>   
                    
<div class='contentheading'><?php echo _UE_USERREPORT_MODERATE; ?></div><br />
          <form action='<?php 
	echo sefRelToAbs('index.php?option=com_comprofiler&amp;task=processReports'.($Itemid ? "&amp;Itemid=".$Itemid : ""));
		?>' method='post' name='adminForm'>
          <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead><tr align='left'>
		<th>&nbsp;</th>
		<th><?php echo _UE_REPORTEDUSER; ?></th>
		<th><?php echo _UE_REPORT; ?></th>
		<th><?php echo _UE_REPORTEDONDATE; ?></th>
		<th><?php echo _UE_REPORTEDBY; ?></th>	
		</tr></thead>	
<?php  
       for($i = 0; $i < count($row); $i++) {
	     echo "<tr align='left' valign='middle'>";
             echo "<td><input id='img".$row[$i]->reportid."' type=\"checkbox\" checked=\"checked\" name=\"reports[]\" value=\"".$row[$i]->reportid."\" /></td>";
             echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->reporteduser.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->reportedname,$row[$i]->reportedusername,$ueConfig['name_format']). "</a></td>";
	     echo "<td>".$row[$i]->reportexplaination."</td>";  
	     echo "<td>".dateConverter($row[$i]->reportedondate,'Y-m-d',$ueConfig['date_format'])."</td>";
             echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->reportedbyuser.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->reportedbyname,$row[$i]->reportedbyusername,$ueConfig['name_format']). "</a></td>";           
	     echo '</tr>';
          }
          
          echo '<tr align="center" valign="middle"><td colspan="5">'
          .'<input class="button" type="submit" value="'._UE_PROCESSUSERREPORT.'" /></td></tr>';
          echo '</table>';
          echo cbGetSpoofInputTag();
          echo "</form>";
		if($total > $limit) { ?>
<hr /><div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div>
<?php
		}
    }



	function moderateImages($option) {
	global $_CB_database, $ueConfig, $my, $Itemid, $_REQUEST;
	
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		mosNotAuth();
		return;
	}
	$ue_base_url = "index.php?option=com_comprofiler&amp;task=moderateImages".($Itemid ? "&amp;Itemid=".$Itemid : "");	// Base URL string

	$query = "SELECT count(*) FROM #__comprofiler  WHERE avatarapproved=0 AND approved=1 AND confirmed=1 AND banned=0";
	if(!$_CB_database->setQuery($query)) print $_CB_database->getErrorMsg();
	$total = $_CB_database->loadResult();

	$limitstart	= intval( cbGetParam( $_REQUEST, 'limitstart', 0 ) );
	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT * FROM #__comprofiler c, #__users u WHERE u.id= c.id AND c.avatarapproved=0 AND approved=1 AND confirmed=1 AND banned=0";
	$query .= " LIMIT $limitstart, $limit";
	$_CB_database->setQuery($query);
	$row = $_CB_database->loadObjectList();

	outputCbTemplate(1);
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo _UE_MODERATE_TITLE; ?></div></td>
	</tr>
</table>  
<?php
	if($total<1) {
		echo _UE_NOIMAGESTOAPPROVE;
		return;
	} 
?>                    
<div class='contentheading'><?php echo _UE_IMAGE_MODERATE; ?></div><br />
<?php if($total > $limit) { ?>
<div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div><hr />
<?php
}  

          echo "<form action='".sefRelToAbs('index.php?option=com_comprofiler&amp;task=approveImage'.($Itemid ? "&amp;Itemid=".$Itemid : ""))."' method='post' name='adminForm'>";
          echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
          echo "<tr align='center' valign='middle'><td>";
          $avatar_gallery_path='images/comprofiler/';
          $sys_gallery_path='components/com_comprofiler/images/';
          for($i = 0; $i < count($row); $i++) {
	     	$image=$avatar_gallery_path.'tn'.$row[$i]->avatar;	
            echo '<div class="containerBox">';
            echo '<img style="cursor:hand;" src="'.$image.'" onclick="this.src=\''.$avatar_gallery_path.$row[$i]->avatar.'\'" alt="" /><br />';
            echo "<label for='img".$row[$i]->id."'>".getNameFormat($row[$i]->name,$row[$i]->username,$ueConfig['name_format'])
            . " <input id='img".$row[$i]->id."' type=\"checkbox\" checked=\"checked\" name=\"avatar[]\" value=\"".$row[$i]->id."\" /></label>";
	     	echo "<br /><img style='cursor:hand;' onclick='window.location=\""
	     	.sefRelToAbs("index.php?option=com_comprofiler&amp;task=approveImage&amp;flag=1&amp;avatars=".$row[$i]->id.($Itemid ? "&amp;Itemid=".$Itemid : ""))
	     	."\"' src='".$sys_gallery_path."approve.png' title='"._UE_APPROVE_IMAGE."' alt='"._UE_APPROVE
	     	."' /> <img style='cursor:hand;' src='".$sys_gallery_path."reject.png' onclick='javascript:window.location=\""
	     	.sefRelToAbs("index.php?option=com_comprofiler&amp;task=approveImage&amp;flag=0&amp;avatars=".$row[$i]->id.($Itemid ? "&amp;Itemid=".$Itemid : ""))
	     	."\"' title='"._UE_REJECT_IMAGE."' alt='"._UE_REJECT."' /> <img style='cursor:hand;' src='".$sys_gallery_path
	     	."updateprofile.gif' title='"._UE_VIEWPROFILE."' onclick='javascript:window.location=\""
	     	.sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->id.($Itemid ? "&amp;Itemid=".$Itemid : ""))
	     	."\"' alt='"._UE_VIEWPROFILE."' />";
			echo "</div>";
          }
          echo '</td></tr>';
          echo '<tr><td colspan="4" align="center">'
          .'<input class="button" style="background-color:#CFC;" onclick="this.form.act.value=\'1\';this.form.submit();" type="button" value="'._UE_APPROVE.'" />'
          .'&nbsp;&nbsp;&nbsp;'
          .'<input class="button" style="background-color:#FCC;" onclick="this.form.act.value=\'0\';this.form.submit();" type="button" value="'._UE_REJECT.'" />';
          echo '</td></tr>';
          echo '</table>';
		  echo '<input type="hidden" name="act" value="" />';
		  echo cbGetSpoofInputTag();
          echo "</form>";
		if ($total > $limit) { ?>
<hr /><div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div>
<?php
		}  
    }


	function viewReports($option,$uid,$act)
	{
	global $_CB_database, $ueConfig, $my, $Itemid, $_REQUEST;
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		mosNotAuth();
		return;
	}
	$ue_base_url = "index.php?option=com_comprofiler&amp;task=viewReports".($Itemid ? "&amp;Itemid=".$Itemid : "");	// Base URL string

	$query = "SELECT count(*) FROM #__comprofiler_userreports  WHERE " . ( $act = 1 ? '' : "reportedstatus=0 AND " ) . "reporteduser=" . (int) $uid;
	if(!$_CB_database->setQuery($query)) print $_CB_database->getErrorMsg();
	$total = $_CB_database->loadResult();

	$limitstart	= intval( cbGetParam( $_REQUEST, 'limitstart', 0 ) );
	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT u2.name as reportedbyname, u2.username as reportedbyusername, u.name as reportedname, u.username as reportedusername, ur.* FROM #__users u, #__comprofiler_userreports ur, #__users u2 WHERE u.id=ur.reporteduser AND u2.id=ur.reportedbyuser AND " . ( $act = 1 ? '' : "ur.reportedstatus=0 AND " ) . "ur.reporteduser=".(int) $uid." ORDER BY ur.reporteduser,ur.reportedondate";
	$query .= " LIMIT $limitstart, $limit";
	$_CB_database->setQuery($query);
	$row = $_CB_database->loadObjectList();

	outputCbTemplate(1);
?>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td colspan="6"><div class="componentheading"><?php echo _UE_MODERATE_TITLE; ?></div></td>
	</tr>
</table>   
<?php
if($total<1) {
	echo _UE_NOREPORTSTOPROCESS;
	return;
} 
?> 
                    
<div class='contentheading'><?php echo _UE_USERREPORT; ?></div><br />
<?php if($total > $limit) { ?>
<div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div><hr />
<?php
} 
?>
	<table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead><tr align='left'>
			<th><?php echo _UE_REPORTEDUSER; ?></th>
			<th><?php echo _UE_REPORT; ?></th>
			<th><?php echo _UE_REPORTEDONDATE; ?></th>
			<th><?php echo _UE_REPORTEDBY; ?></th>	
			<th><?php echo _UE_REPORTSTATUS; ?></th>	
		</tr></thead>
<?php  
	for($i = 0; $i < count($row); $i++) {
		echo "<tr align='left' valign='middle'>";
		echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->reporteduser.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->reportedname,$row[$i]->reportedusername,$ueConfig['name_format']). "</a></td>";
		echo "<td>".$row[$i]->reportexplaination."</td>";
		echo "<td>".dateConverter($row[$i]->reportedondate,'Y-m-d',$ueConfig['date_format'])."</td>";
		echo "<td><a href='".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$row[$i]->reportedbyuser.($Itemid ? "&amp;Itemid=".$Itemid : ""))."'>".getNameFormat($row[$i]->reportedbyname,$row[$i]->reportedbyusername,$ueConfig['name_format']). "</a></td>";
		echo "<td>". ( $row[$i]->reportedstatus ? ( '<span style="color:green;">' . _UE_REPORTSTATUS_PROCESSED  . '</span>' ) : ( '<span style="color:red;font-weight:bold;">' . _UE_REPORTSTATUS_OPEN  . '</span>' ) ) ."</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
		if($total > $limit) { ?>
<hr /><div style="width:100%;text-align:center;"><?php echo writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div>
<?php
	}
	echo "<br /><div style='width:100%;text-align:center;'>\n";
	echo "<form action='".sefRelToAbs('index.php?option=com_comprofiler&amp;task=moderateReports'.($Itemid ? "&amp;Itemid=".$Itemid : ""))."' method='post' name='adminForm'>\n";
    echo '<input class="button" type="submit" value="'._UE_USERREPORT_MODERATE."\" />\n";
    echo "</form>\n</div>\n";
}

?>

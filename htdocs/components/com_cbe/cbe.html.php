<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $ueConfig, $enhanced_Config;
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ALL);
class HTML_cbe {

	function emailUser($option,$rowFrom,$rowTo) {
		global $ueConfig,$_REQUEST,$mosConfig_live_site;
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

		$Itemid_ce = JArrayHelper::getValue( $_REQUEST, 'Itemid', '');
		
		if($rowFrom->id == $rowTo->id) {
			echo "<div class=\"contentheading\" >"._UE_NOSELFEMAIL."</div>";
			return;
		}
?>
	<script>
	function submitbutton_emailuser() {
		var coll = document.emailUser.elements;
		var errorMSG = '';
		var iserror=0;
		for (i=0; i<coll.length; i++) {
			if(coll[i].mosReq==1) {
				if(coll[i].value=='') {
					//alert(coll.elements.item(i).mosLabel + ':' + coll.item(i).mosReq);
					errorMSG += coll[i].mosLabel + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
					iserror=1;
				}
				if(coll[i].mosLength > 0) {
					if(coll[i].value.length > coll[i].mosLength) {
						errorMSG += coll.item(i).mosLabel + ': <?php echo _UE_LENGTH_ERROR; ?>\n';
						iserror=1;
					}
				}
			}
		}
		if(iserror==1) { alert(errorMSG); }
		else {
			document.emailUser.submit();
		}
	}
	</script>
	<div style="text-align:left;">
	<div class="contentheading" ><?php echo sprintf(_UE_EMAILFORMINSTRUCT,$rowTo->id,getNameFormat($rowTo->name,$rowTo->username,$ueConfig['name_format'])); ?></div>
	<form name=emailUser method=post action=index.php>
		<?php echo _UE_EMAILFORMSUBJECT; ?><br />
		<input mosReq=1 mosLabel='<?php echo _UE_EMAILFORMSUBJECT; ?>' type=text class="inputbox" name=emailSubject size="50" /><?php echo "<img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; ?><br />
		<?php echo _UE_EMAILFORMMESSAGE; ?><br />
		<textarea mosReq=1 mosLabel='<?php echo _UE_EMAILFORMMESSAGE; ?>' class="inputbox" name=emailBody cols=50 rows=15 ></textarea><?php echo "<img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; ?><br />
		<div><?php echo _UE_EMAILFORMWARNING; ?></div>
		<input type=hidden name=fromID value="<?php echo $rowFrom->id; ?>" />
		<input type=hidden name=toID value="<?php echo $rowTo->id; ?>" />
		<input type=hidden name=option value="<?php echo $option; ?>" />
		<input type=hidden name=itemid value="<?php echo $Itemid_ce; ?>" />
		<input type=hidden name=task value=sendUserEmail />
		<input type="button" onclick="submitbutton_emailuser();" class="button" name=btnsubmit value="Send Email" />
		
	</form>
	</div>
	<div style="align:center;">
	<?php
	echo "<img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "._UE_FIELDREQUIRED;
	?>
	</div>
<?php

}

/******************************
Profile Functions
******************************/

function userEdit($user, $option,$submitvalue)
{
	global $ueConfig,$_REQUEST,$mosConfig_live_site,$enhanced_Config;
	global $Itemid_com;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbTabs.php');

	$database = &JFactory::getDBO();
	jimport('joomla.html.pane');
	if ($enhanced_Config['tooltip_wz'] != '1') {
		//mosCommonHTML::loadOverlib();
		JHTML::_('behavior.tooltip');

	}
	$tabs = new cbTabs( 0,1, 'default' );
	//$tabs->startPane("CB");
	$tabcontent=$tabs->getEditTabs($user);


	if ($ueConfig['switch_js_inc'] != 1) {
		echo "\n<script type=\"text/javascript\" src=\"".JURI::root()."index2.php?option=com_cbe".$Itemid_com."&format=raw&task=callthrough&scrp=cbe_db\"></script>";
		echo "\n<script type=\"text/javascript\" src=\"".JURI::root()."index2.php?option=com_cbe".$Itemid_com."&format=raw&task=callthrough&scrp=cbe_tb\"></script>\n";
	} else {
		$js_cbe_datebox = '';
		if (file_exists('components/com_cbe/enhanced/_js_datebox.php')) {
			include('components/com_cbe/enhanced/_js_datebox.php');
			echo $js_cbe_datebox;
		}
	
		$js_cbe_toolbox = '';
		if (file_exists('components/com_cbe/enhanced/_js_toolbox.php')) {
			include('components/com_cbe/enhanced/_js_toolbox.php');
			echo $js_cbe_toolbox;
		}
	}

	$database->setQuery("SELECT enabled FROM #__cbe_tabs WHERE plugin='getGeoCoderEdit' LIMIT 1");
	$geo_enabled = $database->loadResult();
	if ($geo_enabled == '1') {
		echo '<script src="http://maps.google.com/maps?file=api&v=2.x&key='.$enhanced_Config['geocoder_google_apikey'].'" type="text/javascript"></script> ';
		echo "\n";
	
		//$js_cbe_geocoder_edit = '';
		//if (file_exists('components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php')) {
		//	include('components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php');
		//	echo $js_cbe_geocoder_edit;
		//}
		// echo "\n<script type=\"text/javascript\" src=\"".$mosConfig_live_site."/index2.php?option=com_cbe&no_html=1&task=callthrough&scrp=cbe_gce\"></script>\n";
	}

?>
<link rel="stylesheet" type="text/css" media="all" href="includes/js/calendar/calendar-mos.css" title="green" />
<link href="<?php echo JURI::root(); ?>components/com_cbe/enhanced/enhanced_css.css" rel="stylesheet" type="text/css"/>

<!-- import the calendar script -->
<script type="text/javascript" src="includes/js/calendar/calendar.js"></script>
<!-- import the language module -->
<script type="text/javascript" src="includes/js/calendar/lang/calendar-en.js"></script>
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script language="javascript" type="text/javascript">
function getObject(obj) {
	var strObj;
	if (document.all) {
		strObj = document.all.item(obj);
	} else if (document.getElementById) {
		strObj = document.getElementById(obj);
	}
	return strObj;
}

var cbeDefaultFieldBackground;
<?php
	if ($enhanced_Config['geocoder_use_addrfield_auto'] == '1' && $enhanced_Config['geocoder_use_addrfield'] == '1') {
		echo "function submitbutton_cbe_edit() {\n";
		echo "\tvar formBTN 	= document.getElementsByName(\"btnsubmit\")[0];\n";
		echo "\tformBTN.disabled	= true;\n";
		echo "\tvar gc_chk = cbe_geoCode_GGFD_C(); \n";
		echo "\tsetTimeout(\"submitbutton_cbe_edit_()\",2500);\n";
		echo "}\n\n";
		echo "function submitbutton_cbe_edit_() {\n";
	} else {
		echo "function submitbutton_cbe_edit() {\n";
	}
?>
	//alert("I got clicked!");
	var coll = document.adminForm.elements;
<?php //	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-|\u0020]", "i");
      // var r = new RegExp("^\_|^\-|[^a-z|A-Z|^0-9|\_|\-]|\_$|\-$", "i"); 
?>
	var r = new RegExp("<?php echo $ueConfig['reg_regex']; ?>", "i");
	var errorMSG = '';
	var iserror=0;
	var reWhitespace = /^\s+$/
	if (cbeDefaultFieldBackground === undefined) {
		var cbeForm = document.adminForm.elements;
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}

	<?php echo $tabs->fieldJS; ?>

	if (coll['username'].value == "") {
		//errorMSG += "<?php echo html_entity_decode(_REGWARN_UNAME);?>";
		iserror=1;
	} else if (r.exec(coll['username'].value) || coll['username'].value.length < <?php echo $ueConfig['username_min']?> ||coll['username'].value.length > <?php echo $ueConfig['username_max']?>) {
		errorMSG +=  "<?php printf( html_entity_decode(_VALID_AZ09), html_entity_decode(_PROMPT_UNAME), $ueConfig['username_min'] );?>";
		iserror=1;
	} else if ((coll['password'].value != "") && (coll['password'].value != coll['verifyPass'].value)){
		errorMSG += "<?php echo _REGWARN_VPASS2;?>";
		iserror=1;
	} else if ((r.exec(coll['password'].value) || coll['password'].value.length < <?php echo $ueConfig['password_min']?>) && (coll['password'].value != "")) {
		errorMSG += "<?php printf( _VALID_AZ09, _UE_REG_PASS, $ueConfig['password_min'] );?>";
		iserror=1;
	}
	if(document.all) {
		if ( coll.fireEvent ) {
			coll.fireEvent('onsubmit');
		}
	} else if (document.getElementById) {
		if ( document.createEvent && window.dispatchEvent ) {
			var evt = document.createEvent("HTMLEvents");
			evt.initEvent("onsubmit", false, false);
			window.dispatchEvent(evt);
		}
	}
	
	// loop through all input elements in form
	for (var i=0; i < coll.length; i++) {
		// check if element is mandatory; here mosReq=1
		if (coll[i].getAttribute('mosReq') == 1) {
			//alert(elements.item(i).getAttribute('name')+' '+elements.item(i).getAttribute('mosReq')+' '+elements.item(i).value.length);
			if (coll[i].type == 'radio' || coll[i].type == 'checkbox') {
				var rOptions = coll[coll[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						//alert(rOptions.item(r).checked);
						if (rOptions[r].checked) {
							rChecked=1; //alert('I found a CHECKED One!');
						}
					}
				} else {
					if (coll[i].checked) {
						rChecked=1; //alert('I found a CHECKED One!');
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += coll[i].getAttribute('mosLabel') + '\t: <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					coll[i].style.background = "red";
					iserror=1;
				} else {
					coll[i].style.background = "";
				}
			}
			if (coll[i].value == '' || reWhitespace.test(coll[i].value)) {
				// add up all error messages
				errorMSG += coll[i].getAttribute('mosLabel') + '\t: <?php echo _UE_REQUIRED_ERROR; ?>\n';
				// notify user by changing background color, in this case to red
				coll[i].style.backgroundColor = "red";
				iserror=1;
			} else if (coll[i].value != '' && (coll[i].type != 'radio' && coll[i].type != 'checkbox')) {
				coll[i].style.backgroundColor = cbeDefaultFieldBackground;
			}
			if (coll[i].getAttribute('cbe_type') == 'birthdate') {
				var hf_i = i + 1;
				var co1name = coll[i].name + "_hid";
				var chk_cf = cbe_compareHidden(coll[i], coll[co1name]);
			//	alert(coll[i].name + ": " + coll[i].value + " -- " + coll[co1name].name + ": " + coll[co1name].value );
				if (chk_cf == false || coll[i].value == '') {
					if (coll[i].value != '') {
						errorMSG += coll[i].getAttribute('mosLabel') + '\t: <?php echo _UE_REQUIRED_ERROR; ?>\n';
					}
					// notify user by changing background color, in this case to red
					coll[i].style.backgroundColor = "red";
					iserror=1;
				} else {
					coll[i].style.backgroundColor = cbeDefaultFieldBackground;
				}
			}
			if (coll[i].getAttribute('cbe_type') == 'dateselect' || coll[i].getAttribute('cbe_type') == 'dateselectrange') {
				var co1name = coll[i].getAttribute('cbe_name') + "_hid";
				if (coll[co1name].value == null || coll[co1name].value.length == 0 || coll[co1name].value == '') {
					errorMSG += coll[i].getAttribute('mosLabel') + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					coll[i].style.backgroundColor = "red";
					iserror=1;
				} else {
					coll[i].style.backgroundColor = cbeDefaultFieldBackground;
				}
			}
		}
	}
<?php
	if ($enhanced_Config['geocoder_use_addrfield_auto'] == '1') {
		echo "\t cbe_geoCode_reqCheck(); \n";
		echo "\t if (cbe_geocoder_dto == 1) {\n";
		echo "\t\t if (cbe_geocoder_as_error == 1) {\n";
		echo "\t\t\t iserror = 1;\n";
		echo "\t\t\t errorMSG += \"".getLangDefinition("_UE_CBE_GEOCODER_E_ASNOTDONE")."\";\n";
		echo "\t\t }\n";
		echo "\t\t if (cbe_geocoder_dto_success == 0 && cbe_geocoder_as_error == 0) {\n";
		echo "\t\t\t iserror = 1;\n";
		echo "\t\t\t errorMSG += \"".getLangDefinition("_UE_CBE_GEOCODER_E_ASNOSUCCESS")."\";\n";
		echo "\t\t }\n";
		echo "\t }\n";
	}
?>
	if(iserror==1) { 
		var formBTN 	= document.getElementsByName("btnsubmit")[0];
		formBTN.disabled	= false;
		alert(errorMSG); 
	} else {
		document.adminForm.submit();
	}
}

function showCalendar2(id,dFormat,lowRange,highRange) {
	var el = getObject(id);
	var st_year = 1900;
	var en_year = 2070;
	if (lowRange != 0) {
		st_year = lowRange;
	}
	if (highRange != 0) {
		en_year = highRange;
	}
	if (calendar != null) {
		// we already have one created, so just update it.
		calendar.hide();    // hide the existing calendar
		calendar.parseDate(el.value); // set it to a new date
		calendar.setRange(st_year, en_year);  // min/max year allowed
	} else {
		// first-time call, create the calendar
		var cal = new Calendar(true, null, selected, closeHandler);
		calendar = cal;    // remember the calendar in the global
		cal.setRange(st_year, en_year);  // min/max year allowed
		cal.dateFormat = dFormat;
		calendar.create();    // create a popup calendar
		if (el.value != '') {
			calendar.parseDate(el.value); // set it to a new date
		} else {
			calendar.parseDate('01.01.1970'); // set it to a new date
		}
	}
	calendar.sel = el;    // inform it about the input field in use
	calendar.showAtElement(el);  // show the calendar next to the input field

	// catch mousedown on the document
	Calendar.addEvent(document, "mousedown", checkCalendar);
	return false;
}
</script>
<form action="index.php" method="post" id="adminForm" name="adminForm">
<script language="javascript" type="text/javascript">
	var cbeForm = document.adminForm.elements;
</script>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_EDIT_TITLE; ?></td>
	</tr>
<?php
if($ueConfig['user_unregister_allow']==1 && $ueConfig['show_unregister_editmode']==1) {
	echo "<tr>\n<td colspan='6' align='right'>\n";
	echo "<a href='".JRoute::_("index.php?option=com_cbe&task=unRegister")."'>"._UE_USER_UNREGISTER_UNREGISTER."</a>";
	echo "</td>\n</tr>\n";
}
?>
</table>
<br />
<?php

echo "<table cellspacing='0' cellpadding='4' border='0' width='100%'><tr><td width='100%'>\n";
echo $tabcontent;
echo "</td></tr></table>";

?>
	<input class="button" type="button" name="btnsubmit" id=\"btnsubmit\" onclick="submitbutton_cbe_edit();" value="<?php echo $submitvalue; ?>" /> <input type="button" class="button" name=btncancel value="<?php echo _UE_CANCEL; ?>" onclick="window.location='<?php echo JRoute::_("index.php?option=".$_REQUEST['option']."&Itemid=".$_REQUEST['Itemid']); ?>';" />
<?php
IF($ueConfig["usernameedit"]==0) {
	echo "<input class='inputbox' type='hidden' name='username' value='".$user->username."' />";
}
?>
	<input type="hidden" name="id" value="<?php echo $user->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="saveUserEdit" />
<div style="align:center;">
<?php
echo "<img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "._UE_FIELDREQUIRED." | ";
echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' /> "._UE_FIELDONPROFILE." | ";
echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' /> "._UE_FIELDNOPROFILE;
?>
</div>
</form>

<?php
}

function userProfile($user, $option,$submitvalue) {
	global $ueConfig,$enhanced_Config,$mosConfig_lang,$mosConfig_live_site,$mosConfig_vote,$mosConfig_hits;
	global $mainframe, $Itemid_com;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$acl = &JFactory::getACL();

	$mainframe->appendPathWay(_UE_PROFILE_TITLE);
	if ($ueConfig['uname_pathway'] != 1) {
		$mainframe->appendPathWay(getNameFormat($user->name,$user->username,$ueConfig['name_format']));
		$mainframe->setPageTitle(_UE_PROFILE_TITLE." - ".getNameFormat($user->name,$user->username,$ueConfig['name_format']));
		$mainframe->appendMetaTag('keywords',_UE_PROFILE_TITLE." - ".getNameFormat($user->name,$user->username,$ueConfig['name_format']));
		$mainframe->addMetaTag(_UE_PROFILE_TITLE,getNameFormat($user->name,$user->username,$ueConfig['name_format']));
	} else {
		$mainframe->appendPathWay($user->username);
		$mainframe->setPageTitle(_UE_PROFILE_TITLE." - ".$user->username);
		$mainframe->appendMetaTag('keywords',_UE_PROFILE_TITLE." - ".$user->username);
		$mainframe->addMetaTag(_UE_PROFILE_TITLE,$user->username);
	}
	
	
	$pfields='';
	$isModerator=isModerator($my->id);
	$userIsModerator=isModerator($user->id);
	$database->setQuery("SELECT COUNT(*) FROM #__session WHERE userid =".$user->id);
	$isonline = $database->loadResult();

	$database->setQuery("SELECT id FROM #__menu WHERE (link = 'index.php?option=com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' or published='0') AND access='0' ORDER BY id DESC Limit 1");
	$Itemid_p = $database->loadResult();
	if ( $Itemid_p != '' ) {
		$Itemid_p = "&Itemid=".$Itemid_p;
	}

	$pop_win = JArrayHelper::getValue( $_REQUEST, 'pop', 0 );
        $pop_enh = '';
       	$pop_link= '';
       	if ($pop_win == 1) {
               	$pop_enh = '2';
               	$pop_link = '&pop=1';
       	}

	$ue_base_url = "index".$pop_enh.".php?option=com_cbe". (($Itemid_com) ? $Itemid_com : $Itemid_p) . $pop_link;	// Base URL string
	$ue_userdetails_url = $ue_base_url."&task=userDetails";
	$ue_useravatar_url = $ue_base_url."&task=userAvatar";
	$ue_profile_url = $ue_base_url."&task=userProfile&user=".$user->id;
	$adminimagesdir = JURI::root()."components/com_cbe/images/";
	$showProfile=1;
	
	if($user->banned!=0) {
		echo "<font color=red>"._UE_USERPROFILEBANNED."</font>";
		if($my->id!=$user->id && $isModerator!=1) {
			$showProfile=0;
		} else {
			echo "<br /><font color=red>".nl2br($user->bannedreason)."</font>";
			$showProfile=1;
		}
	}
	if($showProfile==1) {
		$i=1;
?>

	<table cellpadding="5" cellspacing="0" border="0" width="98%">
		<tr>
    			<td class="contentheading" width="50%" style="width:50%;">
    				<?php 
				if ($pop_win == 1) {
					echo "<small>". _UE_PROFILE_TITLE ."</small><br><br>".getNameFormat($user->name,$user->username,$ueConfig['name_format'])." "; 
				} else {
					echo "".getNameFormat($user->name,$user->username,$ueConfig['name_format'])." "; 
				}
    				?>
    			</td>
    			<td style="width:50%;text-align:right;">
			<?php 
			$y="";
			if($my->id==$user->id) {
				$y=" | ";
				echo "<a href='".JRoute::_($ue_userdetails_url)."'><img src='".$adminimagesdir."updateprofile.gif' border=0 /> "._UE_UPDATEPROFILE."</a>";
				if($ueConfig['user_unregister_allow']==1 && $ueConfig['show_unregister_profilemode']==1) echo " | <a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=unRegister")."'>"._UE_USER_UNREGISTER_UNREGISTER."</a>";
				if($user->banned==1 && $userIsModerator==0 && $ueConfig['allowUserBanning']==1) echo " | <a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=banProfile&act=2&reportform=1&uid=".$user->id)."'>"._UE_REQUESTUNBANPROFILE."</a>";
			} else {
				if($ueConfig['allowUserReports']==1 && $userIsModerator==0 && $isModerator==0 && $my->id > 0) echo "<a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=reportUser&uid=".$user->id)."'>"._UE_REPORTUSER."</a>";

			}
			if($isModerator==1 && $my->id!=$user->id && $userIsModerator==0) {
				$query = "SELECT count(*) FROM #__cbe_userreports  WHERE reportedstatus=0 AND reporteduser='".$user->id."'";
				if(!$database->setQuery($query)) print $database->getErrorMsg();
				$userreports = $database->loadResult();
				if($ueConfig['allowUserBanning']==1) {
					if($user->banned!=0 ) {
						$doUnblock = '';
						if ($user->block == 1) {
							$doUnblock = "&unblock=1";
						}
						echo $y."<a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=banProfile&act=0&reportform=0".$doUnblock."&uid=".$user->id)."'>"._UE_UNBANPROFILE."</a>";
					} else {
						echo $y."<a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=banProfile&act=1&uid=".$user->id)."'>"._UE_BANPROFILE."</a>";
					}
				}
				if($ueConfig['allowUserReports']==1 && $userreports>0) echo " | <a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=viewReports&uid=".$user->id)."'>"._UE_VIEWUSERREPORTS."</a>";
			}
			?></td>

    		</tr>
<?php
// EasyProfile Link Code

if ($enhanced_Config['show_easyProfileLink']=='1') {
	$easyLinkOut = "";

	$bookmark_url = JURI::root();
	$bookmark_url = ereg_replace('//$','/', $bookmark_url);
	$bookmark_url .= $user->username;

	$easyLinkOut .= "<tr>\n<td class=\"contentheading\" colspan=2>";
	$easyLinkOut .= "<script language=\"JavaScript1.2\">\n"; 
	$easyLinkOut .= "var bookmarkurl=\"".$bookmark_url."\"; \n";
	$easyLinkOut .= "var bookmarktitle=\"".$bookmark_url."\"; \n";
	$easyLinkOut .= "function addbookmark_cb(){ \n";
	$easyLinkOut .= "if (document.all) \n";
	$easyLinkOut .= "window.external.AddFavorite(bookmarkurl,bookmarktitle) \n";
	$easyLinkOut .= "} \n";
	$easyLinkOut .= "</script> \n";

	$easyLinkOut .= "<a href=\"javascript:addbookmark_cb()\">".$bookmark_url."</a>";
	$easyLinkOut .= "</td>\n</tr>\n";
	
	echo $easyLinkOut;
}
?>


<!-- PK edit -->
<?php
	if ($enhanced_Config['pic2pic'] == '1' ) {
	?>
                <tr>
                        <td valign=center>
                                <table cellpadding="5" cellspacing="0" border="0" width="100%" valign=bottom>
                                        <tr><?php
                                        $database->setQuery ( "SELECT avatar, avatarapproved FROM #__cbe WHERE user_id ='".$my->id."'");
                                        $useravatar = $database->loadObjectList();
                                        $uimage=$user->avatar;
                                        if(file_exists("components/com_cbe/images/".$mosConfig_lang)) $uimagepath="components/com_cbe/images/".$mosConfig_lang."/";
                                        else $uimagepath="components/com_cbe/images/english/";
                                        if($user->avatarapproved==0) $uimage=$uimagepath."pendphoto.jpg";
                                        elseif($user->avatar=='' || $user->avatar==null) $uimage=$uimagepath."nophoto.jpg";
                                        elseif(($useravatar[0]->avatar == '' || $useravatar==null || $useravatar[0]->avatarapproved != 1) && !$isModerator) $uimage=$uimagepath."nophoto2.jpg";
					else $uimage="images/cbe/".$uimage; ?>
                                                <td valign=center align=center colspan=2><img src="<?php echo $uimage; ?>" /></td>
                                        </tr>
<?php
	} else {
	?>
		<tr>
			<td valign=center>
				<table cellpadding="5" cellspacing="0" border="0" width="100%" valign=bottom>
					<tr><?php
					$uimage=$user->avatar;
					if(file_exists("components/com_cbe/images/".$mosConfig_lang)) $uimagepath="components/com_cbe/images/".$mosConfig_lang."/";
					else $uimagepath="components/com_cbe/images/english/";
					if($user->avatarapproved==0) $uimage=$uimagepath."pendphoto.jpg";
					elseif($user->avatar=='' || $user->avatar==null) $uimage=$uimagepath."nophoto.jpg";
						else $uimage="images/cbe/".$uimage; ?>
						<td align=center align=center colspan=2><img src="<?php echo $uimage; ?>" /></td>
					</tr>

<?php
	}

	if($my->id==$user->id && $ueConfig['avatardeljs']==1) {
		$av_del_Link = "index.php?option=com_cbe".$Itemid_p."&task=userAvatar&do=deleteavatar";
		$av_del_Link = str_replace("&", "&", JRoute::_($av_del_Link));
		$av_del_Out = "<script language=\"JavaScript1.2\">\n";
		$av_del_Out .= "function CheckDelAv() { \n";
		$av_del_Out .= " Check = confirm('"._UE_CBE_DELET_AVATAR_NOTE."') \n";
		$av_del_Out .= " if (Check == true) { \n";
		$av_del_Out .= "  window.location.href = '".$av_del_Link."'; \n";
//		$av_del_Out .= "  window.location.href = '".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=userAvatar&do=deleteavatar")."'; \n";
//		$av_del_Out .= " } else {\n";
//		$av_del_Out .= "  window.location.href = '".JRoute::_($ue_profile_url)."'; \n";
		$av_del_Out .= " } \n";
		$av_del_Out .= "} \n";
		$av_del_Out .= "</script> \n";
		echo $av_del_Out;
	}


?>
<!-- edit end -->


					<tr valign="bottom" width=100%>
						<td valign="bottom" align="left">
							<?php 
								if($my->id==$user->id && $ueConfig['allowAvatar']==1 && ($ueConfig['allowAvatarUpload']==1 || $ueConfig['allowAvatarGallery']==1)) { 
									echo "<a href='".JRoute::_($ue_useravatar_url)."'><img src='".$adminimagesdir."updateprofile.gif' border=0 /> "._UE_UPDATEAVATAR."</a>"; 
							?></td>
						<td valign="bottom" align="right">
							<?php 
									if($user->avatar!='' && $user->avatar!=null) {
										if ($ueConfig['avatardeljs']==1) {
											echo "<a href='JavaScript:CheckDelAv();'>"._UE_DELETE_AVATAR."</a>"; 
										} else {
											echo "<a href='".JRoute::_("index.php?option=com_cbe".$Itemid_p."&task=userAvatar&do=deleteavatar")."'><img src='".$adminimagesdir."reject.png' border=0 />"._UE_DELETE_AVATAR."</a>";
										}
									}
								} 
							?></td>
					</tr>

<?php
//Author subscribe
include_once('components/com_cbe/enhanced/authors/author_subscribe.php');
?>					
				</table>
			</td>
			<td valign=middle>

				<table cellpadding="5" cellspacing="0" border="0" width="100%">
				<?php $emailText=getFieldValue('primaryemailaddress',$user->email,$user); ?>
				<?php	$i= ($i==1) ? 2 : 1; IF($ueConfig['allow_email_display']!=4 && $my->id != $user->id) {?>
					<tr>
						<td  class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_EMAIL; ?></td>
						<td  class=sectiontableentry<?php echo $i; ?>><?php echo $emailText;?></td>
					</tr>
				<?php	
					$i= ($i==1) ? 2 : 1; } 
// PMS check DONE					
					if ($ueConfig['pms']!=0 && $my->id!=$user->id && ($my->usertype!='')) { 
						if($ueConfig['pms']==1) {
							// MyPMS-OS 2.1x
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_pms".$pms_id."&page=new&id=".$user->username;
						} else if ($ueConfig['pms']==2) {
							// MyPMS-PRO
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_mypms%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_mypms".$pms_id."&task=new&to=".$user->username;
						} else if ($ueConfig['pms']==3) {
							// MyPMS-OS 2.5 alpha or higher
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_pms".$pms_id."&page=new&id=".$user->username; 
						} else if ($ueConfig['pms']==4) {
							// MyPMS-OSenhanced 1.2.x to 1.3.x
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_pms".$pms_id."&page=new&id=".$user->username;
						} else if ($ueConfig['pms']==9) {
							// MyPMS-OSenhanced 2.x or higher
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%' OR link LIKE '%com_pms%&page=inbox%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_pms".$pms_id."&page=new&id=".$user->id;
						} else if ($ueConfig['pms']==5) {
							// uddeIM 0.4 or higher
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_uddeim%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_uddeim".$pms_id."&task=new&recip=".$user->id;
						} else if ($ueConfig['pms']==6) {
							// Missus 1.0 Beta2
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_missus%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_missus".$pms_id."&func=newmsg&user=".$user->id;
						} else if ($ueConfig['pms']==7) {
							// Clexus 1.2.1 and higher
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_mypms%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_mypms&task=compose&to=".$user->id.$pms_id;
						} else if ($ueConfig['pms']==8) {
							// Jim 1.0.1 and higher
							$query_pms = "SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_jim%'"; 
							$database->setQuery( $query_pms );
							$pms_id = $database->loadResult();
							$pmsurl="index.php?option=com_jim&task=new&id=".$user->username.$pms_id;
						} else if ($ueConfig['pms']==10) {
							// CBE Messenger not included in CBE-Beta1
							$pmsurl="index.php?option=com_cbe&Itemid=".$Itemid."&task=userProfile&user=$my->id&id=$user->username&func=compose&index=Messenger";
						}
					?>
					<tr>
						<td  class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_PM; ?></td>
						<td  class=sectiontableentry<?php echo $i; ?> ><a href="<?php echo JRoute::_($pmsurl); ?>"><?php echo UE_PM_USER; ?></a></td>
					</tr>
				<?php $i= ($i==1) ? 2 : 1; } If ($enhanced_Config['uhp_integration']=='1') {?>
					<tr>
						<td class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_UHP; ?></td>
					<?php 
						$query_uhp = "SELECT id FROM #__uhp WHERE user_id='".$user->id."'";
						$database->setQuery($query_uhp);
						$uhp_id = $database->loadResult();

						if ($uhp_id !=''){
							$query_uhpitemid = "SELECT id FROM #__menu WHERE link LIKE '%com_uhp%' AND (published='1' or published='0')";
							$database->setQuery($query_uhpitemid);
							$uhp_itemid = $database->loadResult();
					?>
						<td  class=sectiontableentry<?php echo $i; ?> ><a href="<?php echo JRoute::_("index.php?option=com_uhp&task=view&Itemid=".$uhp_itemid."&id=".$uhp_id); ?>"><?php echo _UE_UHP_LINK; ?></a></td>
					</tr>
					<?php
						} else {
					?>
						<td  class=sectiontableentry<?php echo $i; ?> ><?php echo _UE_UHP_LINK_NO; ?></td>
					</tr>	
				<?php 		}
					$i= ($i==1) ? 2 : 1; }
					if ($enhanced_Config['show_profile_hits']=='1') {?>
					<tr>
				      		<td class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_HITS; ?></td>
				      		<td class=sectiontableentry<?php echo $i; ?> ><?php echo $user->hits; ?></td>
					</tr>
					
				<?php $i= ($i==1) ? 2 : 1; }
					if ($ueConfig['allow_onlinestatus']==1) { ?>
					<tr>
						<td class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_ONLINESTATUS; ?></td>
						<td class=sectiontableentry<?php echo $i; ?> ><?php if($isonline > 0) echo _UE_ISONLINE; 
							  else echo _UE_ISOFFLINE; ?></td>
					</tr>
				<?php $i= ($i==1) ? 2 : 1; } ?>
				<?php 
				//Enhanced profile info
				include_once('components/com_cbe/enhanced/display.php');
				if (file_exists('components/com_cbe/enhanced/geocoder/geoinfo_profile.php')) {
					include_once('components/com_cbe/enhanced/geocoder/geoinfo_profile.php');
				}

				if ($enhanced_Config['show_profile_stats']=='1') {
				?>
					<tr>
						<td class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_MEMBERSINCE; ?></td>
						<td class=sectiontableentry<?php echo $i; ?> ><?php echo getFieldValue('date',$user->registerDate);?></td>
					</tr>	
				<?php $i= ($i==1) ? 2 : 1; ?>				
					<tr>
						<td class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_LASTONLINE; ?></td>
						<td class=sectiontableentry<?php echo $i; ?> ><?php echo getFieldValue('date',$user->lastvisitDate);?></td>
					</tr>
				<?php $i= ($i==1) ? 2 : 1; ?>
					<tr>
						<td class=sectiontableentry<?php echo $i; ?> width=35% style="font-weight:bold;"><?php echo _UE_LASTUPDATEDON; ?></td>
						<td class=sectiontableentry<?php echo $i; ?> ><?php echo getFieldValue('date',$user->lastupdatedate);?></td>
					</tr>
				<?php $i= null; } ?>
				</table>
			</td>
		</tr>
	</table> <br />


<style type="text/css">
.dynamic-tab-pane-control h2 {
	text-align:	center;
	width:		auto;
}

.dynamic-tab-pane-control h2 a {
	display:	inline;
	width:		auto;
}

.dynamic-tab-pane-control a:hover {
	background: transparent;
}

</style>

<?php

		if($my->id!=$user->id){
			$database->setQuery("UPDATE #__cbe SET hits=(hits+1) WHERE id='".$user->id."'");
			if (!$database->query())
			{
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}
}

function userAvatar($row, $option,$submitvalue) {
	global $ueConfig,$mosConfig_live_site, $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbe.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();

	$rowExtras = new moscbe ($database);
	$rowExtras->load($row->id);

//	$database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_cbe' AND (published='0' OR published='1')");
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


?> 
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script language="javascript" type="text/javascript">
function submitbutton() {
	//alert("I got clicked!");
	var coll = document.EditUser;
	var errorMSG = '';
	var iserror=0;
	if (coll != null) {
		var elements = coll.elements;
		//elements += document.getElementsByTagName('textarea');
		// loop through all input elements in form
		for (var i=0; i < elements.length; i++) {
			// check if element is mandatory; here mosReq=1
			if (elements.item(i).getAttribute('mosReq') == 1) {
				if (elements.item(i).value == '') {
					//alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
					// add up all error messages
					errorMSG += elements.item(i).getAttribute('mosLabel') + ' <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					elements.item(i).style.background = "red";
					iserror=1;
				}
			}
		}
	}
	if(iserror==1) { alert(errorMSG); }
	else {
		document.EditUser.submit();
	}

}
	</script>
<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_EDIT_TITLE; ?></td>
	</tr>
</table>   
<?php                       
global $my,$avatar,$avatar_name,$newAvatar,$_FILES;
$do='';
$do= JRequest::getVar('do', 'init' );
$UpAvatar = $_FILES['avatar'];
$avatar = $_FILES['avatar']['tmp_name'];
$avatar_name = $_FILES['avatar']['tmp_name'];
$avatar_error = $_FILES['avatar']['error'];
$newAvatar = JArrayHelper::getValue( $_POST, 'newAvatar', NULL);
$avatarRules_checked = JArrayHelper::getValue ( $_POST, 'avatar_rules_check', NULL);
if ($do=='init'){
	if($ueConfig['allowAvatarUpload']){
		echo "<span class='contentheading'>"._UE_UPLOAD_SUBMIT."</span><br><br>";
		echo _UE_UPLOAD_DIMENSIONS.": ".$ueConfig['avatarWidth']."x".$ueConfig['avatarHeight']." - ".$ueConfig['avatarSize']." KB";
		echo "<form action='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userAvatar&do=validate")."' method='post' name='adminForm' enctype='multipart/form-data'>";
		echo "<input type='hidden' value='do' text='validate'>";
		echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
		echo "<tr align='center' valign='middle'><td align='center' valign='top'>";
		$uplabel=_UE_UPLOAD_UPLOAD;
		//echo " <input type='hidden' name='MAX_FILE_SIZE' value='".$maxAllowed."' />";
		echo _UE_UPLOAD_SELECT_FILE." <input type='file' class='button' name='avatar' value='' />";
		echo "<input type='submit' class='button' value='"._UE_UPLOAD_UPLOAD."' />";
		echo "</td></tr>\n";
		if ($ueConfig['showAvatarRules'] == '1') {
			echo "<tr><td>&nbsp;</td></tr> \n";
			echo "<tr align='center' valign='middle'><td align='center' valign='middle'> \n";
			echo "<input type='checkbox' name='avatar_rules_check' id='avatar_rules_check' value='used' disabled='disabled' />&nbsp;";
			//echo "<input type='checkbox' name='avatar_rules_check' id='avatar_rules_check' value='used' />&nbsp;";
			$img_rules_url = str_replace("&","&",$ueConfig['showAvatarRules_url']);
			$check_str = "/(index2.php).*(&pop=1)/i";
			$isOpenPop = preg_match($check_str, $img_rules_url);
			if ($isOpenPop) {
				echo "<a href=\"javascript:void window.open('".$ueConfig['showAvatarRules_url']."', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"Avatar Rules\" ";
				echo " onclick=\"document.getElementById('avatar_rules_check').checked = true; document.getElementById('avatar_rules_check').disabled = false;\">"._UE_AVATAR_RULES_LINKTEXT."</a>";
			} else {
				echo "<a href=\"".$ueConfig['showAvatarRules_url']."\">"._UE_AVATAR_RULES_LINKTEXT."</a>";
			}
			echo "</td></tr> \n";
		}
		echo "</table><br/><br/>";
		echo "</form>";
	}

	if($ueConfig['allowAvatarGallery']){
		if ($ueConfig['rows_of_gallery'] == '' || $ueConfig['rows_of_gallery'] == null) {
			$gal_cols = '5';
		} else {
			$gal_cols = $ueConfig['rows_of_gallery'];
		}
		echo "<span class='contentheading'>"._UE_UPLOAD_GALLERY."</span><br><br>";
		echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
		echo "<form action='".JRoute::_("index.php?option=com_cbe&task=userAvatar&do=fromgallery".$Itemid_c)."' method='post' name='adminForm'>";
		echo "<tr align='center' valign='middle'>";
		echo '<td colspan="'.$gal_cols.'">&nbsp;</td></tr>';
		echo "<tr align='center' valign='middle'>";
		$avatar_gallery_path= JPATH_SITE.DS.'images'.DS.'cbe'.DS.'gallery';
		$avatar_images=array();
		$avatar_images=display_avatar_gallery($avatar_gallery_path);
		for($i = 0; $i < count($avatar_images); $i++) {
			$j=$i+1;
			echo '<td>';
			echo '<img src="'.JURI::root().'/images/cbe/gallery/'. $avatar_images[$i].'">';
			echo '<input type="radio" name="newAvatar" value="gallery/'.$avatar_images[$i].'">';
			echo '</td>';
			if (function_exists('fmod')) {
				if (!fmod(($j),$gal_cols)){echo '</tr><tr align="center" valign="middle">';}
			} else {
				if (!cbe_fmodReplace(($j),$gal_cols)){echo '</tr><tr align="center" valign="middle">';}
			}

		}
		echo '</tr>';
		echo '<tr><td colspan="5" align="center"><input class="button"  type="submit" value="'._UE_UPLOAD_CHOOSE.'">';
		echo '</table>';
		echo "</form>";
	}

}else if ($do=='validate'){

	$my = &JFactory::getUser();
   	if (!$ueConfig['allowAvatarUpload']) {
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	echo $avatar_name;
	$filename = split("\.", $avatar_name);
	$avatarName=$filename[0];
	$avatarExt=$filename[1];
	$avatarSize=filesize($avatar);
	$isModerator=isModerator($my->id);

	if ($ueConfig['showAvatarRules'] == '1' && $avatarRules_checked != 'used' ) {
		$mainframe->redirect("index.php?option=com_cbe&task=userAvatar".$Itemid_c,_UE_AVATAR_RULES_IGNORED);
	}

	if (empty($avatar) || $avatar_error != 0) {
		$mainframe->redirect("index.php?option=com_cbe&task=userAvatar".$Itemid_c,_UE_UPLOAD_ERROR_EMPTY);
	}

//get rid of old Avatar
   	if (eregi("gallery/",$rowExtras->avatar)==false && is_file(JPATH_SITE."/images/cbe/".$rowExtras->avatar)) {
		unlink(JPATH_SITE."/images/cbe/".$rowExtras->avatar);
		if (is_file(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar)) {
			unlink(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar);
		}
		$database->setQuery("UPDATE  #__cbe SET avatar=null, avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$my->id'");
		$database->query();
	}
	$watermark_path = JPATH_SITE.'/images/cbe/watermark/';

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
		$imgToolBox->_wm2_stampit_txt = JURI::root()."".$my->username;
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

	if(!($newFileName=$imgToolBox->processImage($_FILES['avatar'], $my->id,JPATH_SITE .'/images/cbe/', 0, 0, 1))) {
		$mainframe->redirect("index.php?option=com_cbe&task=userAvatar".$Itemid_c,$imgToolBox->_errMSG);
		return;
	}

	IF($ueConfig['avatarUploadApproval']==1 && $isModerator==0) {
		$database->setQuery( "SELECT name, email, user_id FROM #__users u , #__cbe c WHERE u.id=c.id"
		."\n AND u.gid >='".$ueConfig['imageApproverGid']."' AND u.block=0 AND u.sendEmail='1' AND c.confirmed='1' AND c.approved='1'" );
		$rowAdmins = $database->loadObjectList();
		foreach ($rowAdmins AS $rowAdmin) {
			$isModerator=isModerator($rowAdmin->user_id);
			if ($isModerator==1) {
				createEmail($row,'imageAdmin',$ueConfig,$rowAdmin);
			}
		}
		$database->setQuery("UPDATE #__cbe SET avatar='$newFileName', avatarapproved=0 WHERE id='$my->id'");
		$redMsg=_UE_UPLOAD_PEND_APPROVAL;
	} ELSE {
		$database->setQuery("UPDATE #__cbe SET avatar='$newFileName', avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$my->id'");
		$redMsg=_UE_UPLOAD_SUCCESSFUL;
	}

	$database->query();

	$mainframe->redirect ("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$my->id,$redMsg);
   
   	echo "<script language=\"javascript\"> \n";
   	echo "setTimeout(\"location='index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$my->id."'\",350000); \n";
   	echo "</script> \n";
   
}else if ($do=='fromgallery'){

	$my = &JFactory::getUser();
	if(!$ueConfig['allowAvatarGallery']){
		echo JText::_('ALERTNOTAUTH');

		return;
	}

	if($newAvatar==''){
		$mainframe->redirect("index.php?option=com_cbe&task=userAvatar".$Itemid_c,_UE_UPLOAD_ERROR_CHOOSE);
	}
	$database->setQuery("UPDATE #__cbe SET avatar='$newAvatar', avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$my->id'");

	if(!$database->query()) {
		echo _UE_USER_PROFILE_NOT."<br/><br/>";
	}else {
		echo _UE_USER_PROFILE_UPDATED."<br/><br/>";
		$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$my->id);
	}
	echo _UE_USER_RETURN_A." <a href=\"".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$my->id)."\">"._UE_USER_RETURN_B."</a><br /><br />";
   	
   	echo "<script language=\"javascript\"> \n";
   	echo "setTimeout(\"location='index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$my->id."'\",3500); \n";
   	echo "</script> \n";
   
}else if ($do=='deleteavatar') {
	$my = &JFactory::getUser();
	if(eregi("gallery/",$rowExtras->avatar)==false && is_file(JPATH_SITE."/images/cbe/".$rowExtras->avatar)) {
		unlink(JPATH_SITE."/images/cbe/".$rowExtras->avatar);
		if(is_file(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar)) unlink(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar);
	}
	$database->setQuery("UPDATE  #__cbe SET avatar=null, avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$my->id'");
	$database->query();

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$my->id);
}

} // Funktion end


	/******************************
	List Functions
	******************************/

function usersList($row,$lfields,$lists,$listid)
	{
		global $limitstart,$search,$mosConfig_sitename,$ueConfig,$_POST;
		global $mosConfig_live_site,$mainframe;
		$search = JRequest::getVar('search','');

		//echo print_r($lfields);
		$acl =& JFactory::getACL();
		$database = &JFactory::getDBO();
		
		$mainframe->setPageTitle(getLangDefinition($row->title));
		$mainframe->appendMetaTag('keywords',getLangDefinition($row->title));
		
		$search = cbGetEscaped(trim( strtolower( $search)));
		$Itemid_ul = JRequest::getVar('Itemid', '');
		$Itemid_pro = '';
		if (!isset($_REQUEST['Itemid'])) {
			if ($GLOBALS['Itemid_com']!='') {
				$Itemid_pro = $GLOBALS['Itemid_com'];
			}
		} else {
			$Itemid_pro = "&Itemid=".$_REQUEST['Itemid'];
		}
		$ue_base_url = "index.php?option=com_cbe&task=usersList&listid=".$listid."&Itemid=".$Itemid_ul;	// Base URL string
		$ue_profile_url = $ue_base_url."&task=userProfile&user=";
		$adminimagesdir = JURI::root()."components/com_cbe/images/";

		$allusergids=array();
		$usergids=explode(",",$row->usergroupids);
		foreach($usergids AS $usergid) {
			$allusergids[]=$usergid;
			if ($usergid==29 || $usergid==30) {
				$groupchildern=array();
				$groupchildren=$acl->get_group_children( $usergid, 'ARO','RECURSE' );
				$allusergids=array_merge($allusergids,$groupchildren);
			}
		}
		$usergids=implode(",",$allusergids);

		// Total
		$database->setQuery("SELECT count(u.id) FROM #__users u, #__cbe ue WHERE u.id=ue.id AND u.block !=1 AND ue.approved=1 AND ue.banned!=1 AND ue.confirmed=1 AND u.gid IN (".$usergids.")");
		$total_results = $database->loadResult();

		$search_query = "";

		// Select query
		if($row->sortfields!='') $orderby = " ORDER BY ".$row->sortfields;
		$filterby="";
		if($row->filterfields!='') $filterby = " AND ".utf8RawUrlDecode(substr($row->filterfields,1));

		// Search total
// Onlinestatus hack
		if ($row->filteronline=='1') {
			$orderby = eregi_replace('username','u.username',$orderby);
			$orderby = str_replace('`','',$orderby);
			$query = "SELECT count(u.id) FROM #__users u, #__cbe ue, #__session ses WHERE u.id=ue.id AND u.id=ses.userid AND u.block !=1 AND ue.approved=1 AND ue.banned!=1 AND ue.confirmed=1 AND u.gid IN (".$usergids.")";
		} else {
			$query = "SELECT count(u.id) FROM #__users u, #__cbe ue WHERE u.id=ue.id AND u.block !=1 AND ue.approved=1 AND ue.banned!=1 AND ue.confirmed=1 AND u.gid IN (".$usergids.")";
		}
		if (isset($search) && $search != "") {
			$query .= " AND (u.username LIKE '%$search%'";
			if ($ueConfig['search_username'] == '1') {
				$query .= " OR u.name LIKE '%$search%')";
			} else {
				$query .= ")";
			}
		}
		$query .= " ".$filterby;
		if(!$database->setQuery($query)) print $database->getErrorMsg();
		$total = $database->loadResult();

		if (empty($limitstart)) $limitstart = 0;
		$limit = $ueConfig['num_per_page'];
		if ($limit > $total) {
			$limitstart = 0;
		}

		if ($row->filteronline=='1') {
			$query = "SELECT *, '' AS 'NA' FROM #__users u, #__cbe ue, #__session ses WHERE u.id=ue.id AND u.id=ses.userid AND u.block!=1 and ue.approved=1 AND ue.banned!=1 AND ue.confirmed=1 AND u.gid IN (".$usergids.")";
		} else {
			$query = "SELECT *, '' AS 'NA' FROM #__users u, #__cbe ue WHERE u.id=ue.id AND u.block!=1 and ue.approved=1 AND ue.banned!=1 AND ue.confirmed=1 AND u.gid IN (".$usergids.")";
		}
		if (isset($search) && $search != "") {
			$query .= " AND (u.username LIKE '%$search%'";
			if ($ueConfig['search_username'] == '1') {
				$query .= " OR u.name LIKE '%$search%')";
			} else {
				$query .= ")";
			}
			$search_query = "&search=".$search;
		}
		$query .= " ".$filterby;
		$query .= " ".$orderby;
		$query .= " LIMIT $limitstart, $limit";

		$database->setQuery($query);
		$users=$database->loadObjectList();
?>
<link href="<?php echo JURI::root();?>components/com_cbe/enhanced/enhanced_css.css" rel="stylesheet" type="text/css"/>
<script language="JavaScript">
<!--
function validate(){
	if ((document.ueform.search=="") || (document.ueform.search.value=="")) {
		alert('<?php echo _UE_SEARCH_ALERT; ?>');
		return false;
	} else {
		return true;
	}
}
//-->
</script>

  <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
  	<tr>
  	  <td colspan="2"><span class="contentheading"><?php echo getLangDefinition($row->title); ?></span></td>
  	</tr>
  <tr>
  <form name="ueform" method="post" action="<?php echo $ue_base_url;?>&action=search" >
    <td valign="top" class="contentdescription" colspan=2>
       <?php echo $mosConfig_sitename . " " . _UE_HAS . ": <b>" . $total_results . "</b> " . _UE_USERS; ?>
	</td>
</tr>
<tr>
	<td>
	<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
		<tr>
			<td style="width:50%;">
			<?php
				if ($ueConfig['hide_searchbox']!='0') {
			?>
              			<input type="text" name="search" class="inputbox" size="15" maxlength="100"<?php if (isset($search)) echo " value=".$search; ?>>
              			<input type="image" src="<?php echo $adminimagesdir; ?>search.gif" alt="<?php echo _UE_SEARCH; ?>" border="0" align="top" style="border: 0px;">
			<?php
				}
			?>
			</td>
			<td style="width:50%;text-align:right;">
				<?php 
					if ($ueConfig['hide_listsbox']!='0') {
						echo $lists['plists'];
					}
				?>
			</td>
		</tr>
	</table>
	</td>	
  </form>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
    		<td>
    		<?php
    			if ($ueConfig['hide_searchbox']!='0') {
    		?>
    			<a href="<?php echo $ue_base_url; ?>" onclick="javascript:ueform.search.value=''"><?php echo _UE_LIST_ALL; ?></a>
    		<?php
    			}
    		?>
    		</td>

    		<td align="right"></td>
        </tr>
      </table>
	<div style="width:100%;text-align:center;"><?php echo (($total > $limit) ? cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url,$search) : "&nbsp;"); ?></div>
	<div style="width:100%;text-align:right;"><?php echo cbe_writePagesCounter($limitstart, $limit, $total); ?></div>
      <hr noshade size="1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<?php
		$active_col = 0;
		if ($row->col1enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col1title)."</b></td>\n";
		}
		if ($row->col2enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col2title)."</b></td>\n";
		}
		if ($row->col3enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col3title)."</b></td>\n";
		}
		if ($row->col4enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col4title)."</b></td>\n";
		}
		?>		
        </tr>
<?php
$i = 1;
$inlist_count = 0;
$colin = 1;
$in_row_oe = (intval($ueConfig['userslist_rnr']) % 2 == 0) ? 1 : 0 ;
// 0 == even , 1 == odd

if (count($users) > 0 ) {
	foreach($users as $user) {
		$evenodd = $i % 2;
		if ($evenodd == 0) {
			//$class = "sectiontableentry1";
			$class = $ueConfig['userslist_css1'];
		} else {
			//$class = "sectiontableentry2";
			$class = $ueConfig['userslist_css2'];
		}
		$nr=$i+$limitstart;
		//print $user->name;
		if($ueConfig['allow_profilelink']==1) {
			//$onclick = "onclick=\"javascript:window.location='".JRoute::_($mosConfig_live_site."/index.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id)."'\"";
			//$onclick_pop = "onclick=\"javascript:window.open('".JRoute::_($mosConfig_live_site."/index2.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id."&pop=1")."','cbe_win','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"CBE-Profile\" ";

/*
			$onclick = "onclick=\"javascript:window.location='".JRoute::_("index.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id)."'\"";
			$onclick_pop = "onclick=\"javascript:window.open('".JRoute::_("index2.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id."&pop=1")."','cbe_win','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"CBE-Profile\" ";
*/
			$onclick = "onclick=\"javascript:window.location='".JRoute::_("index.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id)."'\"";
			$onclick_pop = "onclick=\"javascript:window.open('".JRoute::_("index2.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id."&pop=1")."','cbe_win','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"CBE-Profile\" ";
	
			$style="style=\"cursor:hand;cursor:pointer;\"";
		} else {
			$onclick = "";
			$onclick_pop = "";
			$style = "";
		}
		
		if ( $ueConfig['allow_profile_popup'] == '1' ) {
			$onclick = $onclick_pop;
		}
		
		if ($active_col > 1) {
			print "\t<tr class=\"$class\" ".$style." ".$onclick.">\n";
			//print $lfields;
		} else {
			if ($inlist_count == 0) {
				echo "\t<tr class=\"".$class."\"><td>\n<center>";
			}
			if ($evenodd == 0) {
				$colin = 1;
			} else {
				$colin = 2;
			}
				
			echo "<div class=\"ulistcol".$colin."\" ".$style." ".$onclick.">\n";
			$inlist_count++;
		}
		eval("\$str = \"$lfields\";");
		echo $str. "\n";
		if ($activ_col > 1) {
			print "\t</tr>\n";
		} else {
			if ($inlist_count < intval($ueConfig['userslist_rnr'])) {
			//if ($inlist_count < 4) {
				echo "</div>\n";
			} else {
				echo "</div>\n </center></td></tr>\n";
				$inlist_count = 0;
				$i++;
			}
		}
		$i++;
	}
	if ($inlist_count > 0) {
		echo "</center></td></tr>";
	}
}
?>
        </table>	
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
    		<td>&nbsp;</td>
    		<td align="right"></td>
        </tr>
      </table>
        <hr noshade size="1">
	<div style="width:100%;text-align:center;"><?php echo (($total > $limit) ? cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url,$search) : "&nbsp;"); ?></div>
      </td>
    </tr>
  </TABLE>
<?php }

function cbsearch($sform)
{

	global $ueConfig,$enhanced_Config,$mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
	jimport('joomla.html.pane');
	$mainframe->setPageTitle(_UE_PROFILESEARCH);
	$mainframe->appendMetaTag('keywords',_UE_PROFILESEARCH);
	$my = &JFactory::getUser();
	$database = &JFactory::getDBO();
	// (c) 2005 by Rasmus Dahl-Sorensen
	// released under GPL

	// create form with tabs
	$Itemid_cs = JRequest::getVar('Itemid', '');
	if ($Itemid_cs == '') {
		if ($my->id != '0') {
			$database->setQuery("SELECT id FROM #__menu WHERE (link = 'index.php?option=com_cbe&task=cbsearch' OR link LIKE '%com_cbe%cbsearch') AND published='1' AND access='1' ORDER BY id DESC Limit 1");
		} else {
			$database->setQuery("SELECT id FROM #__menu WHERE (link = 'index.php?option=com_cbe&task=cbsearch' OR link LIKE '%com_cbe%cbsearch') AND published='1' AND access='0' ORDER BY id DESC Limit 1");
		}
		$Itemid_cs = $database->loadResult();
		if ( $Itemid_cs != '' ) {
			$Itemid_cs = "&Itemid=".$Itemid_cs;
		} else {
			$Itemid_cs = '';
		}
	} else {
		$Itemid_cs = '&Itemid='.$Itemid_cs;
	}

?>

<table cellspacing="0" cellpadding="4" border="0" width="100%">
<tr><td class="contentheading"><?php echo _UE_PROFILESEARCH; ?></td></tr>
</table>

<?php

JLoader::register('JPaneTabs', JPATH_LIBRARIES.DS.'joomla'.DS.'html'.DS.'pane.php');
$tabs = new JPaneTabs(0);
echo '<style type="text/css">'."\n";
echo ".dynamic-tab-pane-control .tab-page { \n";
echo "  background: ".$enhanced_Config['searchtab_color']."; \n";
echo "} \n";
echo "</style> \n";
$tabs->startPane( 'cbsearchprofiletabpane' );
$tabs->startPanel( getLangDefinition($enhanced_Config['searchtab1']), 'cbsearchtab1' );

echo '<table border="0" cellspacing="0" cellpadding="2">';

?>
			<form method="post" action="index.php?option=com_cbe<?php echo $Itemid_cs; ?>&task=cbsearch" name="adminForm">
		
<tr><th colspan=2 align=left><?php echo _UE_SELECTCRITERIA; ?></th></tr>

				<tr><td>&nbsp;</td></tr>
				
				<?php echo $sform[0]; ?>

				<tr><td>&nbsp;</td></tr>
				
				<tr><td colspan=2>

				<input type="submit" class=button name="adminForm" value="<?php echo _UE_FORMSEARCH; ?>">
				<input type="reset" class=button name="adminForm" value="<?php echo _UE_FORMRESET; ?>">
				</td></tr>
			</form>
<?php
echo '</table>';
//end a tab page
$tabs->endPanel();

if ($enhanced_Config['show_advanced_search_tab']=='1') { 
	$tabs->startPanel( getLangDefinition($enhanced_Config['searchtab2']), 'cbsearchtab2' );
	echo '<table border="0" cellspacing="0" cellpadding="2">';
?>

	<form method="post" action="index.php?option=com_cbe&Itemid=<?php echo $Itemid_cs; ?>&task=cbsearch" name="adminForm">

<tr><th colspan=2 align=left><?php echo _UE_SELECTCRITERIA; ?></th></tr>
				<tr><td>&nbsp;</td></tr>
				
<?php 
echo $sform[1];
echo $sform[2];
echo '<input type="hidden" name="boxchecked" value="0" />';
?>

				<tr><td>&nbsp;</td></tr>
				<tr><td colspan=2>
				<input type="submit" class=button name="adminForm" value="<?php echo _UE_FORMSEARCH; ?>">
				<input type="reset" class=button name="adminForm" value="<?php echo _UE_FORMRESET; ?>">
				</td></tr>
			</form>
			</table>
<?php

//end a tab page
$tabs->endPanel();
}

$tabs->endPane();

}

function cbsearchlist($row,$lfields,$lists,$listid,$act_search_ses,$submitvalue)
{
	//print_r(debug_backtrace());
	global $limitstart,$search,$enhanced_Config,$mosConfig_sitename,$ueConfig,$_POST,$_REQUEST,$acl;
	global $mosConfig_live_site,$mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$database = &JFactory::getDBO();
	$mainframe->setPageTitle(_UE_SEARCHRESULTS);
	$mainframe->appendMetaTag('keywords',_UE_SEARCHRESULTS);
	$acl = &JFactory::getACL();

	$cbe_check1 = '';
	$cbe_check1 = $act_search_ses->mod_cbe_search;
	$cbe_check2 = '';
	$cbe_check2 = $act_search_ses->mod_cbe_search1;

	$cbe_check1 = str_replace('-B-E', '', str_replace('C-','', $cbe_check1));
	$cbe_check = 0;
	$cbe_check = ((md5($cbe_check1) == $cbe_check2) ? 1 : 0);


	// (c) 2005 by Rasmus Dahl-Sorensen
	// released under GPL
	
	// Modified and additional features 
	// added by Jeffrey Randall
	// http://mambome.com
	// 17-06-2005

	//$ue_base_url = "index.php?option=com_cbe&task=cbsearchlist&listid=".$listid;

	$adminimagesdir = JURI::root()."components/com_cbe/images/";

	$allusergids = array();
	$usergids = explode(",",$row->usergroupids);

	foreach($usergids AS $usergid)
	{
		$allusergids[]= $usergid;
		if ($usergid=='29' || $usergid=='30')
		{
			$groupchildern = array();
			$groupchildren = $acl->get_group_children( $usergid, 'ARO','RECURSE' );
			$allusergids = array_merge($allusergids,$groupchildren);
		}
	}
	$usergids = implode(",",$allusergids);

	$select = "SELECT count(u.id) ";
	$defbase = "FROM #__users u, #__cbe ue";
	if ($act_search_ses->onlinenow == '1') {
		$defbase .= ", #__session as s";
	}
	if ($act_search_ses->geo_distance == '1') {
		$defbase .= ", #__cbe_geodata as ugeo";
	}
	$defwherestart = " WHERE u.id=ue.id";
	$defwhereend = " AND u.block !=1 AND ue.approved=1 AND ue.confirmed=1 AND u.gid IN (".$usergids.")";

	$cbquery = $act_search_ses->cbquery;
	//$cbquery = stripslashes($cbquery);
	$cbquery = cbGetUnEscaped($cbquery);
	$cbquery = str_replace("%-","%",$cbquery);

	$do_cbquery = 0;
	$do_cbquery = $act_search_ses->do_cbquery;

	$Itemid_c = '';
	$ue_base_url = "index.php?option=com_cbe&task=cbsearchlist".$Itemid_c."&cbsearchid=".$act_search_ses->id."&cbsearcht=".$act_search_ses->q_time;
	$ue_base_url = str_replace("%", "%-",$ue_base_url);
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_pro = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_pro = '';
		}
	} else {
		$Itemid_pro = "&Itemid=".$_REQUEST['Itemid'];
	}
	
	// build count query
	$query = $select.$defbase.$defwherestart.$defwhereend." ".$cbquery;

	if(!$database->setQuery($query))
	{
		print $database->getErrorMsg();
	}

	$total = $database->loadResult();

	if (empty($limitstart))
	{
		$limitstart = '0';
	}

	$limit = $ueConfig['num_per_page'];

	if ($limit > $total)
	{
		$limitstart = '0';
	}

	if($row->sortfields!='')
	{
		$orderby = " ORDER BY ".$row->sortfields;
	}

	// rebuild $query
	$select = "SELECT u.*,ue.* ";
	$query = $select.$defbase.$defwherestart.$defwhereend." ".$cbquery;
	$query .= " ".$orderby;
	if ($do_cbquery == 1) {
		$query .= " LIMIT $limitstart, $limit";
	} else {
		$query .= " LIMIT 0";
		$total = 0;
	}
	$database->setQuery($query);
	$users = $database->loadObjectList();

?>
<link href="<?php echo JURI::root();?>components/com_cbe/enhanced/enhanced_css.css" rel="stylesheet" type="text/css""/>
<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane">
  	<tr>
  	  </tr>
  <tr>
  </tr>

  <tr>
    <td>
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
	  <td colspan="2"><span class="contentheading"><?php echo _UE_SEARCHRESULTS; ?></span></td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
    	  <td align="right"><?php echo (($total > $limit) ? cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url) : "&nbsp;"); ?></td>
        </tr>
        <tr>
          <td align="right"><?php echo cbe_writePagesCounter($limitstart, $limit, $total); ?></td>
        </tr>
       </table>
      <hr noshade size="1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<?php
		$active_col = 0;
		if ($row->col1enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col1title)."</b></td>\n";
		}
		if ($row->col2enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col2title)."</b></td>\n";
		}
		if ($row->col3enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col3title)."</b></td>\n";
		}
		if ($row->col4enabled) {
			$active_col++;
			echo "<td><b>".getLangDefinition($row->col4title)."</b></td>\n";
		}
		?>		
        </tr>

<?php
$i = '1';
$inlist_count = 0;
$colin = 1;

if (count($users) > 0) {
	foreach($users as $user)
	{
		$evenodd = $i % '2';
		if ($evenodd == '0')
		{
			//$class = "sectiontableentry1";
			$class = $enhanced_Config['cbsearch_css1'];
		}
	
		else
		{
			//$class = "sectiontableentry2";
			$class = $enhanced_Config['cbsearch_css2'];
		}
	
		$nr = $i+$limitstart;
	
		if($ueConfig['allow_profilelink']==1) {
			//$onclick = "onclick=\"javascript:window.location='".JRoute::_($mosConfig_live_site."/index.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id)."'\"";
			//$onclick_pop = "onclick=\"javascript:window.open('".JRoute::_($mosConfig_live_site."/index2.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id."&pop=1")."','cbe_win','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"CBE-Profile\" ";
			$onclick = "onclick=\"javascript:window.location='".JRoute::_("index.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id)."'\"";
			$onclick_pop = "onclick=\"javascript:window.open('".JRoute::_("index2.php?option=com_cbe".$Itemid_pro."&task=userProfile&user=".$user->id."&pop=1")."','cbe_win','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\" title=\"CBE-Profile\" ";
			$style="style=\"cursor:hand;cursor:pointer;\"";
		} else {
			$onclick = "";
			$onclick_pop = "";
			$style = "";
		}
		
		if ( $enhanced_Config['cbs_allow_profile_popup'] == '1' ) {
			$onclick = $onclick_pop;
		}
	
		if ($active_col > 1) {
			print "\t<tr class=\"$class\" ".$style." ".$onclick.">\n";
			//print $lfields;
		} else {
			if ($inlist_count == 0) {
				echo "\t<tr class=\"".$class."\"><td>\n<center>";
			}
			if ($evenodd == 0) {
				$colin = 1;
			} else {
				$colin = 2;
			}
			echo "<div class=\"ulistcol".$colin."\" ".$style." ".$onclick.">\n";
			$inlist_count++;
		}
		@eval("\$str = \"$lfields\";");
		echo $str. "\n";
		if ($activ_col > 1) {
			print "\t</tr>\n";
		} else {
			if ($inlist_count < intval($ueConfig['userslist_rnr'])) {
			//if ($inlist_count < 4) {
				echo "</div>\n";
			} else {
				echo "</div>\n </center></td></tr>\n";
				$inlist_count = 0;
				$i++;
			}
		}
		$i++;
	}
	if ($inlist_count > 0) {
		echo "</center>\n</td></tr>";
	}
}
?>
        </table>	
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
          <td><hr noshade size="1"></td>
        </tr>
        <tr>
    		<td align="right"><?php echo (($total > $limit) ? cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url) : "&nbsp;"); ?></td>
        </tr>
	<tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
         <td align="right"><?php echo cbe_writePagesCounter($limitstart, $limit, $total); ?></td>
        </tr>
      </table>

      </td>
    </tr>
  </table>
<?php 
}

/******************************
Registration Functions
******************************/

function confirmation() {
		?>
	<table>
		<tr>
			<td class="componentheading"><?php echo _UE_SUBMIT_SUCCESS; ?></td>
		</tr>
		<tr>
			<td><?php echo _UE_SUBMIT_SUCCESS_DESC; ?></td>
		</tr>
	</table>
<?php
}
function lostPassForm($option, $Itemid_lp=-1) {
	global $ueConfig, $database, $mosConfig_lang;
	
	$js_cbe_toolbox = '';
	if (file_exists('components/com_cbe/enhanced/_js_toolbox.php')) {
		include('components/com_cbe/enhanced/_js_toolbox.php');
		echo $js_cbe_toolbox;
	}

	?>
<table cellpadding="4" cellspacing="0" border="0" width="98%" class="contentpane">
  <form action="index.php" method="post" onsubmit="return CheckInput('lostForm_cbe');" name="lostForm_cbe" id="lostForm_cbe">
    <tr>
      <td colspan="2" class="componentheading"><?php echo _PROMPT_PASSWORD; ?></td>
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
      <td><input type="text" onBlur="isValidEmailAddress(this);" name="confirmEmail" class="inputbox" size="40" /></td>
    </tr>
    <?php
	if ($ueConfig['use_secimages_lostpass'] == '1') {
		if (file_exists(JPATH_SITE.'/administrator/components/com_securityimages/securityimages.xml')) {
		// security images by walter cedric, changed by Joomla CBE
	?>
    <tr>
      <td>&nbsp;</td>
      <td><img src="<?php echo JURI::root(true); ?>/index.php?option=com_securityimages&task=displayCaptcha"><input type="text" name="securityImagesmy3rdpartyExtensions" /></td>
    </tr>
<?php
		}
	}
?>
    <tr>
      <td colspan="2"> <input type="hidden" name="option" value="<?php echo $option;?>" /> 
      	<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
      </td>
      <td colspan="2"> <input type="hidden" name="Itemid" value="<?php echo $Itemid_lp;?>" />
        <input type="hidden" name="task" value="sendNewPass" /> 
        <input type="submit" class="button" value="<?php echo _BUTTON_SEND_PASS; ?>" />
      </td>
    </tr>
  </form>
</table>
<?php
}

function registerForm($option, $emailpass, $rowFields, $rowFieldValues,$regErrorMSG=null) {
	global $mosConfig_live_site,$mosConfig_useractivation,$ueConfig,$enhanced_Config,$_POST;
	global $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$mainframe->setPageTitle(_UE_REG_TITLE);
	$mainframe->appendMetaTag('keywords',_UE_REG_TITLE);

	$templatedir=$ueConfig['templatedir'];
	echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . JURI::root(). "components/com_cbe/templates/".$templatedir."/tab.css\" /> \n";

	if ($enhanced_Config['tooltip_wz'] != '1') {
		JHTML::_('behavior.tooltip');

		//mosCommonHTML::loadOverlib();
	}

	if ($ueConfig['reg_useajax']=='1') {
//		echo "<script type=\"text/javascript\" src=\"components/com_cbe/enhanced/register_ajax.js\"></script>";
		include_once('components/com_cbe/enhanced/register_ajax.php');
		$register_ajax = str_replace('_AXA_REGEXP', $ueConfig['reg_regex'], $register_ajax);
		$register_ajax = str_replace('_AXA_USERNAMEMIN', $ueConfig['username_min'], $register_ajax);
		$register_ajax = str_replace('_AXA_USERNAMEMAX', $ueConfig['username_max'], $register_ajax);
		$register_ajax = str_replace('_AXA_ERRORUSRCODE', sprintf(html_entity_decode(_VALID_AZ09), html_entity_decode(_PROMPT_UNAME), 2 ), $register_ajax);
		
		$register_ajax = str_replace('_USEAJAX_FAIL_USR', _USEAJAX_FAIL_USR, $register_ajax);
		$register_ajax = str_replace('_USEAJAX_TRUE_USR', _USEAJAX_TRUE_USR, $register_ajax);
		echo "<script type=\"text/javascript\">\n".$register_ajax."\n </script>\n";
	}

	$js_cbe_datebox = '';
	if (file_exists('components/com_cbe/enhanced/_js_datebox.php')) {
		include('components/com_cbe/enhanced/_js_datebox.php');
		echo $js_cbe_datebox;
	}
	$js_cbe_toolbox = '';
	if (file_exists('components/com_cbe/enhanced/_js_toolbox.php')) {
		include('components/com_cbe/enhanced/_js_toolbox.php');
		echo $js_cbe_toolbox;
	}

	if (function_exists('josSpoofValue')) {
		$validate = josSpoofValue();
	}

?>
<link rel="stylesheet" type="text/css" media="all" href="includes/js/calendar/calendar-mos.css" title="green" />
<!-- import the calendar script -->
<script type="text/javascript" src="includes/js/calendar/calendar.js"></script>
<!-- import the language module -->
<script type="text/javascript" src="includes/js/calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="includes/js/mambojavascript.js"></script>
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script language="javascript" type="text/javascript">
function getObject(obj) {
	var strObj;
	if (document.all) {
		strObj = document.all.item(obj);
	} else if (document.getElementById) {
		strObj = document.getElementById(obj);
	}
	return strObj;
}

var cbeDefaultFieldBackground;
function submitbutton_cbe() {
	var coll = document.mosForm_cbe.elements;
	var r = new RegExp("<?php echo $ueConfig['reg_regex']; ?>", "i");
	var errorMSG = '';
	var iserror=0;
	if (cbeDefaultFieldBackground === undefined) {
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}
	if (coll['username'].value == "") {
		//errorMSG += "<?php echo html_entity_decode(_REGWARN_UNAME);?>";
		iserror=1;
	} else if (r.exec(coll['username'].value) || coll['username'].value.length < <?php echo $ueConfig['username_min']?> ||coll['username'].value.length > <?php echo $ueConfig['username_max']?>) {
		errorMSG +=  "<?php printf( html_entity_decode(_VALID_AZ09), html_entity_decode(_PROMPT_UNAME), $ueConfig['username_min'] );?>";
		iserror=1;
		<?php if ($emailpass!="1") { ?>
	} else if ((coll['password'].value != "") && (coll['password'].value != coll['password2'].value)){
	errorMSG += "<?php echo _REGWARN_VPASS2;?>";
	iserror=1;
	} else if (r.exec(coll['password'].value) || coll['password'].value.length < <?php echo $ueConfig['password_min']?>) {
	errorMSG += "<?php printf( _VALID_AZ09, _UE_REG_PASS, $ueConfig['password_min'] );?>";
	iserror=1;
	<?php } ?>
	}
	<?php if($ueConfig['reg_enable_toc']) { ?>
	if(!coll['acceptedterms'].checked) {
		errorMSG += "<?php echo _UE_TOC_REQUIRED; ?>"+"\n";
		iserror=1;
	}
	<?php } ?>
	<?php if($ueConfig['reg_enable_datasec']) { ?>
	if(!coll['accepteddatasec'].checked) {
		errorMSG += "<?php echo _UE_REG_DATASEC_REQUIRED; ?>"+"\n";
		iserror=1;
	}
	<?php } ?>
	var emr = new RegExp("[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}", "i");
	if ( emr.exec(coll['email'].value) ) {
		errorMSG += "<?php echo _BNR_VALID_EMAIL; ?>"+"\n";
		iserror=1;
	}
	if(document.all) {
		if ( coll.fireEvent ) {
			coll.fireEvent('onsubmit');
		}
	} else if (document.getElementById) {
		if ( document.createEvent && window.dispatchEvent ) {
			var evt = document.createEvent("HTMLEvents");
			evt.initEvent("onsubmit", false, false);
			window.dispatchEvent(evt);
		}
	}

	// loop through all input elements in form
	for (var i=0; i < coll.length; i++) {
		// check if element is mandatory; here mosReq=1
		if (coll[i].getAttribute('mosReq') == 1) {
			//alert(elements.item(i).getAttribute('name')+' '+elements.item(i).getAttribute('mosReq')+' '+elements.item(i).value.length);
			if (coll[i].type == 'radio' || coll[i].type == 'checkbox') {
				var rOptions = coll[coll[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						//alert(rOptions.item(r).checked);
						if (rOptions[r].checked) {
							rChecked=1; //alert('I found a CHECKED One!');
						}
					}
				} else {
					if (coll[i].checked) {
						rChecked=1; //alert('I found a CHECKED One!');
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += coll[i].getAttribute('mosLabel') + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					coll[i].style.background = "red";
					iserror=1;
				} else {
					coll[i].style.background = "";
				}
			}
			if (coll[i].value == '') {
				// add up all error messages
				errorMSG += coll[i].getAttribute('mosLabel') + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
				// notify user by changing background color, in this case to red
				coll[i].style.background = "red";
				iserror=1;
			} else if (coll[i].value != '' && (coll[i].type != 'radio' && coll[i].type != 'checkbox')) {
				coll[i].style.background = "";
			}
			if (coll[i].getAttribute('cbe_type') == 'birthdate') {
				var hf_i = i + 1;
				var co1name = coll[i].name + "_hid";
				var chk_cf = cbe_compareHidden(coll[i], coll[co1name]);
			//	alert(coll[i].name + ": " + coll[i].value + " -- " + coll[co1name].name + ": " + coll[co1name].value );
				if (chk_cf == false) {
					errorMSG += coll[i].getAttribute('mosLabel') + '\t: <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					coll[i].style.backgroundColor = "red";
					iserror=1;
				} else {
					coll[i].style.backgroundColor = cbeDefaultFieldBackground;
				}
			}
			if (coll[i].getAttribute('cbe_type') == 'dateselect' || coll[i].getAttribute('cbe_type') == 'dateselectrange') {
				var co1name = coll[i].getAttribute('cbe_name') + "_hid";
				if (coll[co1name].value == null || coll[co1name].value.length == 0 || coll[co1name].value == '') {
					errorMSG += coll[i].getAttribute('mosLabel') + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					coll[i].style.backgroundColor = "red";
					iserror=1;
				} else {
					coll[i].style.backgroundColor = cbeDefaultFieldBackground;
				}
			}
		}
	}
	
	if(iserror==1) { alert(errorMSG); }
	else {
		document.mosForm_cbe.submit();
	}
}
function showCalendar2(id,dFormat,lowRange,highRange) {
	var el = getObject(id);
	var st_year = 1900;
	var en_year = 2070;
	if (lowRange != 0) {
		st_year = lowRange;
	}
	if (highRange != 0) {
		en_year = highRange;
	}
	if (calendar != null) {
		// we already have one created, so just update it.
		calendar.hide();    // hide the existing calendar
		calendar.parseDate(el.value); // set it to a new date
		calendar.setRange(st_year, en_year);  // min/max year allowed
	} else {
		// first-time call, create the calendar
		var cal = new Calendar(true, null, selected, closeHandler);
		calendar = cal;    // remember the calendar in the global
		cal.setRange(st_year, en_year);  // min/max year allowed
		cal.dateFormat = dFormat;
		calendar.create();    // create a popup calendar
		if (el.value != '') {
			calendar.parseDate(el.value); // set it to a new date
		} else {
			calendar.parseDate('01.01.1970'); // set it to a new date
		}
	}
	calendar.sel = el;    // inform it about the input field in use
	calendar.showAtElement(el);  // show the calendar next to the input field

	// catch mousedown on the document
	Calendar.addEvent(document, "mousedown", checkCalendar);
	return false;
}
	</script>
<?php
$ptabs='';
$pfields='';
$poldtab='';
$t=2;
$rowExtras="";
$row = "";

$rowExtras->firstname=(ISSET($_POST['firstname']))?$_POST['firstname']:'';
$rowExtras->middlename=(ISSET($_POST['middlename']))?$_POST['middlename']:'';
$rowExtras->lastname=(ISSET($_POST['lastname']))?$_POST['lastname']:'';
$rowExtras->name=(ISSET($_POST['name']))?$_POST['name']:'';
$rowExtras->username=(ISSET($_POST['username']))?$_POST['username']:'';
$rowExtras->email=(ISSET($_POST['email']))?$_POST['email']:'';

for($i=0, $n=count( $rowFields ); $i < $n; $i++) {
	$pfields .= "\t\t<tr>";
	$colspan = 2;
	if($rowFields[$i]->type=='spacer') {
		if ($rowFields[$i]->title=='-null-') {
			$pfields .= "\t\t\t<td colspan=\"".$colspan."\" class=\"CBEspacerCell\">&nbsp;</td>\n";
		} else {
			$pfields .= "\t\t\t<td colspan=\"".$colspan."\" class=\"CBEspacerCell\">". getLangDefinition($rowFields[$i]->title) ."</td>\n";
		}
		if ($rowFields[$i]->information) {
			if ($rowFields[$i]->information=='-null-') {
				$pfields .= "\t\t</tr>\n\t\t<tr>\n\t\t\t<td colspan=\"".$colspan."\" class=\"CBEfieldInfoCell\">&nbsp;</td>\n";
			} else {
				$pfields .= "\t\t</tr>\n\t\t<tr>\n\t\t\t<td colspan=\"".$colspan."\" class=\"CBEfieldInfoCell\">". getLangDefinition($rowFields[$i]->information) ."</td>\n";
			}
		}
	} else {
	
		if ($rowFields[$i]->information && ($rowFields[$i]->infotag == 'tag' || $rowFields[$i]->infotag == 'both')) {
			$CBEtip = getCBEtip($rowFields[$i]->title,$rowFields[$i]->information);
			$pfields .= "\t\t\t<td class=\"titleCell\"><div style=\"border-bottom:2px dotted #FB0303;\" ".$CBEtip.">". getLangDefinition($rowFields[$i]->title) .":</div></td>";
		} else {
			$pfields .= "\t\t\t<td class=\"titleCell\">". getLangDefinition($rowFields[$i]->title) .":</td>";
		}
		if($regErrorMSG!=null && isset($_POST[$rowFields[$i]->name])) {
			$oValue = $_POST[$rowFields[$i]->name];
			if($rowFields[$i]->type=='date') $oValue=dateConverter($oValue,$ueConfig['date_format'],'Y-m-d');
		}
		else $oValue = "";
		if(!ISSET($rowFields[$i]->id)) $rowFields[$i]->id="";
		if(!ISSET($rowFieldValues['lst_'.$rowFields[$i]->name])) $rowFieldValues['lst_'.$rowFields[$i]->name]="";
//		$pfields .= "\t\t\t<td>".getFieldEntry($rowFields[$i]->type,$rowFields[$i]->name,$oValue,$rowFields[$i]->required,$rowFields[$i]->title,$rowFields[$i]->id,$rowFields[$i]->size, $rowFields[$i]->maxlength, $rowFields[$i]->cols, $rowFields[$i]->rows,$rowFields[$i]->profile,$rowFieldValues['lst_'.$rowFields[$i]->name],$rowFields[$i]->readonly)."</td>\n";
// 	anti-readonly on registration hack
		$pfields .= "\t\t\t<td>".getFieldEntry($rowFields[$i]->type,$rowFields[$i]->name,$rowFields[$i]->information,$rowFields[$i]->infotag,$oValue,$rowFields[$i]->required,$rowFields[$i]->title,$rowFields[$i]->id,$rowFields[$i]->size, $rowFields[$i]->maxlength, $rowFields[$i]->cols, $rowFields[$i]->rows,$rowFields[$i]->profile,$rowFieldValues['lst_'.$rowFields[$i]->name],$rowFields[$i]->value,$rowFields[$i]->default)."</td>\n";
	}

}
$pfields .= "\t\t</tr>";
if ($regErrorMSG!=null) echo "<div class='message'>".$regErrorMSG."</div>\n";

// enctype='multipart/form-data'
?>

<form action="index.php" method="post" name="mosForm_cbe" id="mosForm_cbe" enctype="multipart/form-data">
<script language="javascript" type="text/javascript">
	var cbeForm = document.mosForm_cbe.elements;
</script>
<table cellpadding="5" cellspacing="0" border="0" width="98%" class="contentpane">
    <tr>
      <td colspan="2" width="100%" class="componentheading"><?php echo _UE_REG_TITLE; ?></td>
    </tr>

<?php
SWITCH($ueConfig['name_style']) {
	case 2:
?>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_FNAME; ?>:</td>
			<td><input class="inputbox" type="text" size="40" mosReq=1 mosLabel="<?php echo _UE_YOUR_FNAME; ?>" name="firstname" value="<?php echo $rowExtras->firstname;?>" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['name_format']!=3) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?></td>
		</tr>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_LNAME; ?>:</td>
			<td><input class="inputbox" type="text" size="40" mosReq=1 mosLabel="<?php echo _UE_YOUR_LNAME; ?>" name="lastname" value="<?php echo $rowExtras->lastname;?>" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['name_format']!=3) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?></td>
		</tr>
<?php
break;
case 3:
?>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_FNAME; ?>:</td>
			<td><input class="inputbox" type="text" size="40" mosReq=1 mosLabel="<?php echo _UE_YOUR_FNAME; ?>" name="firstname" value="<?php echo $rowExtras->firstname;?>" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['name_format']!=3) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?></td>
		</tr>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_MNAME; ?>:</td>
			<td><input class="inputbox" type="text" size="40" mosReq=0 mosLabel="<?php echo _UE_YOUR_MNAME; ?>" name="middlename" value="<?php echo $rowExtras->middlename;?>" /><?php IF($ueConfig['name_format']!=3) echo " <img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo " <img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?></td>
		</tr>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_LNAME; ?>:</td>
			<td><input class="inputbox" type="text" size="40" mosReq=1 mosLabel="<?php echo _UE_YOUR_LNAME; ?>" name="lastname" value="<?php echo $rowExtras->lastname;?>" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['name_format']!=3) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?></td>
		</tr>
<?php
break;
DEFAULT:
?>
		<tr>
			<td class="titleCell"><?php echo _UE_YOUR_NAME; ?>:</td>
			<td><input class="inputbox" type="text" size="40" name="name" mosReq=1 mosLabel="Name"  value="<?php echo $rowExtras->name;?>" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['name_format']!=3) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?></td>
		</tr>
<?php 		
break;
}

	$usr_onkey = '';
	$usr_onkey_button = '';
	if ($ueConfig['reg_useajax']=='1' && $ueConfig['reg_useajax_button'] != '1') {
		$usr_onkey = 'id="usrname" onkeyup="validateUserId()"';
	} else if ($ueConfig['reg_useajax']=='1' && $ueConfig['reg_useajax_button'] == '1') {
		$usr_onkey = 'id="usrname"';
		$usr_onkey_button = '<input type="button" value="Check" class="button" onclick="validateUserId()" id="ajax_btn" />';
	}

?>

    <tr>

      <td class="titleCell"><?php echo _UE_REG_UNAME; ?></td>
      <td><input type="text" name="username" <?php echo $usr_onkey; ?> mosReq="1" mosLabel="<?php echo _UE_REG_UNAME; ?>"  size="30" maxlength="<?php echo $ueConfig['username_max']?>" value="<?php echo $rowExtras->username;?>" class="inputbox" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['name_format']!=1) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />"; ?>
          &nbsp; <?php echo $usr_onkey_button; ?>
      </td>
    </tr>
    <tr><td></td><td><div id="userIdMessage"></div></td></tr>
    <tr>

      <td class="titleCell"><?php echo _UE_REG_EMAIL; ?></td>
      <td><input type="text" name="email" onBlur="isValidEmailAddress(this);" mosReq="1" mosLabel="<?php echo _UE_REG_EMAIL; ?>" size="40" value="<?php echo $rowExtras->email;?>" class="inputbox" /><?php echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "; IF($ueConfig['allow_email_display']==1 || $ueConfig['allow_email_display']==2) echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' />"; ELSE echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' />";  ?></td>
    </tr>

    <?php 
    	if ($emailpass=="0" ) {  
    	// || isset($mosConfig_useractivation)
    ?>

    <tr>

      <td class="titleCell"><?php echo _UE_REG_PASS; ?></td>
      <td><input class="inputbox" type="password" name="password" <?php if ($emailpass=="0") echo "mosReq=\"1\""; ?> mosLabel="<?php echo _UE_REG_PASS; ?>" size="40" value="" /><?php if ($emailpass=="0") echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' />"; ?></td>
    </tr>

    <tr>

      <td class="titleCell"><?php echo _UE_REG_VPASS; ?></td>
      <td><input class="inputbox" type="password" name="password2" <?php if ($emailpass=="0") echo "mosReq=\"1\""; ?> mosLabel="<?php echo _UE_REG_VPASS; ?>" size="40" value="" /><?php if ($emailpass=="0") echo " <img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' />"; ?></td>
    </tr>

    <?php } else { ?>

    <tr>

      <td colspan="2"><?php echo _SENDING_PASSWORD; ?></td>
      <input type="hidden" name="password" value="" />
      <input type="hidden" name="password2" value="" />

	</tr>

    <?php } 
	if ($ueConfig['use_secimages'] == '1') {
		if (file_exists(JPATH_SITE.'/administrator/components/com_securityimages/securityimages.xml')) {
		// security images by walter cedric, changed by Joomla CBE
	?>
    <tr>
      <td>&nbsp;</td>
      <td><img src="<?php echo JURI::root(true); ?>/index.php?option=com_securityimages&task=displayCaptcha"> <input type="text" name="securityImagesmy3rdpartyExtensions" /></td>
    </tr>
<?php
		}
	}

    print stripslashes($pfields);
    
    //sv0.6232 avatar upload on register
	if ($ueConfig['allowAvatarUpload']=='1' && $ueConfig['allowAvatarUploadOnReg']=='1') {
		echo "<tr><td colspan=\"2\" class=\"CBEspacerCell\"> \n";
		echo "<span class='contentheading'>"._UE_AVATARUPLOADONREGFRONT."</span><br>\n</td></tr>\n";
		echo "<tr><td colspan=\"2\"> \n";
		echo _UE_UPLOAD_DIMENSIONS.": ".$ueConfig['avatarWidth']."x".$ueConfig['avatarHeight']." - ".$ueConfig['avatarSize']." KB";
		echo "<td>\n</tr>\n";
		echo "<tr>\n";
		echo "<td colspan=\"2\">";
		echo _UE_UPLOAD_SELECT_FILE." <input type='file' class='button' name='avatar' value='' />";
		echo "</td>\n</tr>\n";
	}
    
    if($ueConfig['reg_enable_toc']) {
    	echo "<tr>\n";
    	echo "<td>&nbsp;</td>\n<td colspan='2'><input type=checkbox name='acceptedterms' value='1' mosReq='0' mosLabel='"._UE_TOC."' /><a href='".$ueConfig['reg_toc_url']."' target='_blank'> "._UE_TOC."</a></td>\n";
    	echo "</tr>\n";
    }
    if($ueConfig['reg_enable_datasec']) {
    	echo "<tr>\n";
    	echo "<td>&nbsp;</td>\n<td colspan='2'><input type=checkbox name='accepteddatasec' value='1' mosReq='0' mosLabel='"._UE_REG_DATASEC."' /><a href='".$ueConfig['reg_datasec_url']."' target='_blank'> "._UE_REG_DATASEC."</a></td>\n";
    	echo "</tr>\n";
    }

	if ($ueConfig['use_fqmulticorreos']=='1') {
		require_once (JPATH_SITE . '/components/com_fq/codehacks/reg_integration.php');
		echo "<tr><td colspan=\"2\" class=\"CBEspacerCell\"> \n";
		echo "<span class='contentheading'>Newsletter</span><br>\n</td></tr>\n";
		showLists();
	}

	if ($ueConfig['use_yanc']=='1') {
		require_once (JPATH_SITE . '/components/com_yanc/codehacks/reg_integration.php');
		echo "<tr><td colspan=\"2\" class=\"CBEspacerCell\"> \n";
		echo "<span class='contentheading'>Newsletter</span><br>\n</td></tr>\n";
		showLists();
	}

	?>

    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
     <tr>
      <td colspan=2>
  <input type="hidden" name="id" value="0" />
  <input type="hidden" name="gid" value="0" />
  <input type="hidden" name="emailpass" value="<?php echo $emailpass;?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="saveRegistration" />
  <input type="button" value="<?php echo _BUTTON_SEND_REG; ?>" class="button" onclick="submitbutton_cbe()" id="submit_btn" />
  <input type="hidden" name="<?php echo $validate; ?>" value="1" />
  </td>
    </tr>
</table>
</form>
<div style="align:center;">
<?php
echo "<img src='".JURI::root()."components/com_cbe/images/required.gif' width='16' height='16' alt='*' title='"._UE_FIELDREQUIRED."' /> "._UE_FIELDREQUIRED." | ";
echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' width='11' height='14' alt='+' title='"._UE_FIELDONPROFILE."' /> "._UE_FIELDONPROFILE." | ";
echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' width='11' height='14' alt='-' title='"._UE_FIELDNOPROFILE."' /> "._UE_FIELDNOPROFILE;
?>
</div>
<?php
}


/******************************
Moderation Functions
******************************/

function reportUserForm($option,$uid)
{
	global $database,$ueConfig,$my;
	$my = JFactory::getUser();
	if($ueConfig['allowUserReports']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}

	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}

?> 
<script>
function submitbutton_repuser() {
	var coll = document.userReport.elements;
	var errorMSG = '';
	var iserror=0;
	for (i=0; i<coll.length; i++) {
		if(coll[i].mosReq==1) {
			if(coll[i].value=='') {
				//alert(coll.elements.item(i).mosLabel + ':' + coll.item(i).mosReq);
				errorMSG += coll[i].mosLabel + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
				iserror=1;
			}
			if(coll[i].mosLength > 0) {
				if(coll[i].value.length > coll[i].mosLength) {
					errorMSG += coll.item(i).mosLabel + ': <?php echo _UE_LENGTH_ERROR; ?>\n';
					iserror=1;
				}
			}
		}
	}
	if(iserror==1) { alert(errorMSG); }
	else {
		document.userReport.submit();
	}
}

</script>

<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_REPORTUSER_TITLE; ?></td>
	</tr>
</table>   
<table width='100%' border='0' cellpadding='4' cellspacing='2'>
<form action='index.php?option=com_cbe<?php echo $Itemid_c; ?>&task=reportUser' method='post' name='userReport'>
<tr align='center' valign='middle'>
	<td colspan="4">&nbsp;</td>
</tr>
<tr align='center' valign='middle'>
<br /><br />
<?php echo _UE_REPORTUSERSACTIVITY; ?><br />
<textarea maxlenght=4000 align=center mosReq=1 mosLabel='User Report' cols=50 rows=10 name=reportexplaination></textarea>
<br /><br ?>
</tr>
<tr><td colspan="4" align="center">
<input class="button" onclick="submitbutton_repuser();" type="button" value="<?php echo _UE_SUBMITFORM; ?>">
</table>
<input type=hidden name="reportedbyuser" value="<?php echo $my->id; ?>">
<input type=hidden name="reporteduser" value="<?php echo $uid; ?>">
<input type=hidden name="reportform" value="0">
</form>
<?php

}
function banUserForm($option,$uid,$act,$orgbannedreason)
{
	global $database,$ueConfig,$my;
	if($ueConfig['allowUserBanning']==0) {
		echo _UE_FUNCTIONALITY_DISABLED;
		return;
	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = "&Itemid=".$GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}

?> 
<script>
function submitbutton_banuser() {
	var coll = document.userReport.elements;
	var errorMSG = '';
	var iserror=0;
	for (i=0; i<coll.length; i++) {
		if(coll[i].mosReq==1) {
			if(coll[i].value=='') {
				//alert(coll.elements.item(i).mosLabel + ':' + coll.item(i).mosReq);
				errorMSG += coll[i].mosLabel + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
				iserror=1;
			}
			if(coll[i].mosLength > 0) {
				if(coll[i].value.length > coll[i].mosLength) {
					errorMSG += coll.item(i).mosLabel + ': <?php echo _UE_LENGTH_ERROR; ?>\n';
					iserror=1;
				}
			}
		}
	}
	if(iserror==1) { alert(errorMSG); }
	else {
		document.userReport.submit();
	}
}

</script>

<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php if($my->id != $uid) echo _UE_REPORTBAN_TITLE; ELSE echo _UE_REPORTUNBAN_TITLE;; ?></td>
	</tr>
</table>   
<table width='100%' border='0' cellpadding='4' cellspacing='2'>
<form action='index.php?option=com_cbe<?php echo $Itemid_c; ?>&task=banProfile&act=<?php if($my->id != $uid) echo 1; ELSE echo 2; ?>' method='post' name='userReport'>
<tr align='center' valign='middle'>
	<td colspan="4">&nbsp;</td>
</tr>
<tr align='center' valign='middle'>
<br /><br />
<?php if($my->id != $uid) echo _UE_BANREASON; ELSE echo _UE_UNBANREQUEST; ?><br />
<textarea maxlenght=4000 align=center mosReq=1 mosLabel='<?php if($my->id != $uid) echo _UE_BANREASON; ELSE echo _UE_UNBANREQUEST; ?>' cols=50 rows=10 name=bannedreason></textarea>
</tr>
<?php
	if (isModerator($my->id) == 1) {
		echo "<tr> \n";
		echo " <td>"._UE_CBE_BANREQUEST_DOBLOCK."<input type=\"checkbox\" name=\"doBlockBanUser\" value=\"doBlock\" /><br /><br /></td> \n";
		echo "</tr>";
	}
?>
<tr><td colspan="4" align="center">
<input class="button" onclick="submitbutton_banuser();" type="button" value="<?php echo _UE_SUBMITFORM; ?>" />
</table>
<input type=hidden name="bannedby" value="<?php echo $my->id; ?>" />
<input type=hidden name="uid" value="<?php echo $uid; ?>" />
<input type=hidden name="orgbannedreason" value="<?php echo $orgbannedreason; ?>" />
<input type=hidden name="reportform" value="0" />
</form>
<?php
}

function pendingApprovalUsers($option,$users) {
	global $ueConfig,$limitstart,$my;

	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST;
	}

?>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_MODERATE_TITLE; ?></td>
	</tr>
</table>
<?php
if(count($users)<1) {
	echo _UE_NOUSERSPENDING;
	return;
}
?>    
<br />                    
<span class='contentheading'><?php echo _UE_USERAPPROVAL_MODERATE; ?></span><br><br>
          <form action='index.php?option=com_cbe<?php echo $Itemid_c; ?>&task=processReports' method='post' name='userAdmin'>
          <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead>
		<th>&nbsp;</th>
		<th><?php echo _UE_USER; ?></th>
		<th><?php echo _UE_EMAIL; ?></th>
		<th><?php echo _UE_REGISTERDATE; ?></th>
		<th><?php echo _UE_COMMENT; ?></th>
		</thead>	
<?php  
for($i = 0; $i < count($users); $i++) {
	$j=$i+1;
	echo "<tr align='center' valign='middle'>";
	echo "<td><input id='".$users[$i]->id."' type=\"checkbox\" CHECKED name=\"uids[]\" value=\"".$users[$i]->id."\"></td>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$users[$i]->id)."'>".getNameFormat($users[$i]->name,$users[$i]->username,$ueConfig['name_format']). "</a></td>";
	echo "<td>".$users[$i]->email."</td>";
	echo "<td>".dateConverter($users[$i]->registerDate,'Y-m-d',$ueConfig['date_format'])."</td>";
	echo "<td><textarea name='comment".$users[$i]->id."' cols=20 rows=3></textarea></td>";
	echo "</tr>";
}
echo "<input type=hidden name=task value='' />";
echo "<input type=hidden name=option value=".$option." />";
echo '<tr align="center" valign="middle"><td colspan=5><input class="button" onclick="userAdmin.task.value=\'approveUser\';userAdmin.submit();" type="button" value="'._UE_APPROVE.'"><input class="button" onclick="userAdmin.task.value=\'rejectUser\';userAdmin.submit();" type="button" value="'._UE_REJECT.'"></td></tr>';
echo '</table>';
echo "</form>";
}

function realChat($user,$option,$submitvalue)
{
	global $ueConfig,$enhanced_Config,$mosConfig_lang,$mosConfig_live_site,$_POST,$_REQUEST;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	if ($user->id != $my->id) {
		echo JText::_('ALERTNOTAUTH');

		return;
	}
//	$Item_id = JArrayHelper::getValue( $_REQUEST, 'Itemid','');
	if (!isset($_REQUEST['Itemid'])) {
		$Item_id = $GLOBALS['Itemid_com'];
	} else {
		$Item_id = "&Itemid=".$_REQUEST['Itemid'];
	}
	$isModerator=isModerator($my->id);

	$chat_java = '';
	$chat_java_close = '';
	$realchat_out = '';

	$chat_server = 'muechata.citykom.de';
	$chat_srv_path = '/rchat';
	$chat_embeded = '0';

	$comProfile_url = JURI::root()."index.php?option=com_cbe".$Item_id."&task=userProfile&user=";

	if ($chat_embeded == '0') {
		$chat_width = '1';
		$chat_height = '1';
		$chat_embeded = 'no';
	} else {
		$chat_width = '100%';	// enhanced_Config['chat_width']
		$chat_height = '100%';	// enhanced_Config['chat_height']
		$chat_embeded = 'yes';
	}

	$gender = $user->cb_gender;
	if ($gender == "") {
	        $gender = "keine Angabe";
	 } elseif ($gender == "Mann") {
	        $gender_av = "2";
	 } elseif ($gender == "Frau") {
	        $gender_av = "4";
	 } elseif (eregi('Paar', $gender)) {
	        $gender_av = "6";
	}
	

	$chat_java .= '<!-- Begin: RealChat Client code -->             '.chr(10);
	$chat_java .= '<applet                                          '.chr(10);
	$chat_java .= '  archive = "RealChat.jar"                       '.chr(10);
	$chat_java .= '  codebase = "http://'.$chat_server.$chat_srv_path.'/."'.chr(10);
	$chat_java .= '  code     = "rcs.client.RealChatClient.class"   '.chr(10);
	$chat_java .= '  name     = "ChatClient"                        '.chr(10);
	$chat_java .= '  width    = "'.$chat_width.'"                   '.chr(10);
	$chat_java .= '  height   = "'.$chat_height.'"                  '.chr(10);
	$chat_java .= '  align    = "top"                               '.chr(10);
	$chat_java .= '  alt      = "Chat Client applet"                '.chr(10);
	$chat_java .= '  MAYSCRIPT>                                     '.chr(10);

	$chat_java .= '<param name="nick" value="'.$my->username.'">      '.chr(10);
	$chat_java .= '<param name="embedded" value="'.$chat_embeded.'">  '.chr(10);
	$chat_java .= '<!-- -->                                           '.chr(10);
	$chat_java .= '<param name="pValue1" value="'.$user->username.'">   '.chr(10);
	$chat_java .= '<param name="pValue2" value="'.$user->age.'">        '.chr(10);	// age
	$chat_java .= '<param name="pValue3" value="'.$user->cb_gender.'">  '.chr(10);
	$chat_java .= '<param name="pValue4" value="'.$user->location.'">    '.chr(10);
	$chat_java .= '<param name="pValue5" value="'.$user->registerDate.'">     '.chr(10);
//	$chat_java .= '<param name="pValue6" value=" $confirmed">       '.chr(10);
//	$chat_java .= '<!-- -->'.chr(10);
	$chat_java .= '<param name="avatarIcon" value="'.$gender_av.'">    '.chr(10);
	$chat_java .= '<!-- -->'.chr(10);
	
	if ($isModerator == '1' || $user->cb_ischatmod == '1') {
		$chat_java .= '<param name="hasFontButtons" value="yes">  '.chr(10);
		$chat_java .= '<param name="hasFontsMenu" value="yes">    '.chr(10);
		$chat_java .= '<param name="hasAvatarButton" value="yes"> '.chr(10);
		$chat_java .= '<param name="canCreateRooms" value="yes">  '.chr(10);
		$chat_java .= '<param name="canSendPrivate" value="yes">  '.chr(10);
	} else {
		$chat_java .= '<param name="canSendPrivate" value="no">   '.chr(10);
	}

	$chat_java .= '<!-- -->'.chr(10);
	$chat_java .= '<param name="externalProfileURL" value="'.$comProfile_url.'_USER_">'.chr(10);

	$chat_java .= '<!-- -->'.chr(10);
	$chat_java .= '<param name="exploreMenuItem0" value="Citykom|http://www.citykom.de/|_extern">                                                '.chr(10);
	$chat_java .= '<param name="exploreMenuItem1" value="M�nster|http://www.muenster.de/|_extern">                                               '.chr(10);
	$chat_java .= '<param name="exploreMenuItem2" value="separator">                                                                             '.chr(10);
	$chat_java .= '<param name="exploreMenuItem3" value="Netiquette|http://nwn.de/hgm/knigge/ntq-irc.htm#|_blank">                               '.chr(10);
	$chat_java .= '<param name="exploreMenuItem4" value="separator">                                                                             '.chr(10);
	$chat_java .= '<param name="exploreMenuItem5" value="Jugenschutz.net|http://www.jugendschutz.net/|_kids">                                    '.chr(10);
	$chat_java .= '<param name="exploreMenuItem6" value="Chattipps - Zartbitter|http://www.zartbitter.de/e102/e5779/index_ger.html|_kids">       '.chr(10);
	$chat_java .= '<param name="exploreMenuItem7" value="Netz gegen K...|http://www.heise.de/ct/Netz_gegen_Kinderporno/meldestellen.shtml|_kids">'.chr(10);
	$chat_java .= '<param name="exploreMenuItem8" value="separator">                                                                             '.chr(10);
	$chat_java .= '<param name="exploreMenuItem9" value="Internauten - Tipps f�r Kids|http://www.internauten.de/|_kids">                         '.chr(10);

	$chat_java .= '<param name="maxIconsPerLine" value="3"> '.chr(10);
	$chat_java .= '<param name="Language" value ="de">      '.chr(10);


	$chat_java_close .= '</applet> '.chr(10);
	$realchat_out = $chat_java.$chat_java_close;
	echo $realchat_out;

}

function showTopMost($toptimes,$option,$my,$Itemid_cbe,$Itemid_j) {
	global $database, $ueConfig, $enhancec_Config, $acl, $mainframe;

	$mainframe->setPageTitle(_UE_TPM_FETITLE);
	$mainframe->appendMetaTag('keywords',_UE_TPM_FETITLE);
	
	$output = "";
	$output .= "<br /><span class='contentheading'>". _UE_TPM_FETITLE ."</span><br /><br /> \n";
	$output .= '<table cellpadding="5" cellspacing="0" border="0" width="98%" class="contentpane">'." \n";
	$output .= '<thead class="sectiontableheader"><th>'._UE_USER.'</th><th>'._UE_TPM_COUNT.'</th><th>'._UE_TPM_TIMESUM.'</th><th>'._UE_TPM_AVG.'</th></thead>'." \n";

	$i = 1;
	if (count($toptimes) > 0) {
		foreach( $toptimes as $toptimer ) {
			$evenodd = $i % 2;
			if ($evenodd == 0) {
				//$class = "sectiontableentry1";
				$class = $ueConfig['userslist_css1'];
			} else {
				//$class = "sectiontableentry2";
				$class = $ueConfig['userslist_css2'];
			}
         	
			$output .= "<tr class=\"".$class."\" align='center' valign='middle'><td>";
			if ($toptimer->userid == $my->id) {
				$output .= "<b>".$toptimer->username."</b></td><td>";
			} else {
				$output .= $toptimer->username."</td><td>";
			}
			$mins = 60;
			$hours = 3600;
			$days = 86400;
			$months = 2592000;
			$years = 31104000;
			
			if ($toptimer->logtimesum > $mins && $toptimer->logtimesum < $hours) {
				$out_time = round(($toptimer->logtimesum / $mins),2) . " (m)";
			} elseif ($toptimer->logtimesum > $hours && $toptimer->logtimesum < $days) {
				$out_time = round(($toptimer->logtimesum / $hours),2) . " (h)";
			} elseif ($toptimer->logtimesum > $days && $toptimer->logtimesum < $months) {
				$out_time = round(($toptimer->logtimesum / $days),2) . " (d)";
			} elseif ($toptimer->logtimesum > $months && $toptimer->logtimesum < $years) {
				$out_time = round(($toptimer->logtimesum / $months),2) . " (M)";
			} elseif ($toptimer->logtimesum > $years) {
				$out_time = round(($toptimer->logtimesum / $years),2) . " (Y)";
			} else {
				$out_time = $toptimer->logtimesum ." (s)";
			}
			
			$output .= $toptimer->logcount ."</td><td>";
			//$output .= $toptimer->logtimesum ."</td><td>";
         		$output .= $out_time ."</td><td>";
         		
			$avg = round($toptimer->logtimesum / $toptimer->logcount, 2);

			if ($avg > $mins && $avg < $hours) {
				$out_avg = round(($avg / $mins),2) . " (m)";
			} elseif ($avg > $hours && $avg < $days) {
				$out_avg = round(($avg / $hours),2) . " (h)";
			} elseif ($avg > $days && $avg < $months) {
				$out_avg = round(($avg / $days),2) . " (d)";
			} elseif ($avg > $months && $avg < $years) {
				$out_avg = round(($avg / $months),2) . " (M)";
			} elseif ($avg > $years) {
				$out_avg = round(($avg / $years),2) . " (Y)";
			} else {
				$out_avg = $avg ." (s)";
			}
			
			$output .= $out_avg."</td></tr> \n";
			$i++;
		}
	}
	$output .= "</table> \n";

	echo $output;
}

// class close
}

function moderateBans($option)
{
	global $ueConfig,$limitstart;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}
	
	$ue_base_url = "index.php?option=com_cbe&task=moderateBans".$Itemid_c;	// Base URL string


	$query = "SELECT count(*) FROM #__cbe WHERE banned=2";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$total = $database->loadResult();



	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT u2.name AS bannedbyname, u2.username as bannedbyusername, u.name as bannedname, u.username as bannedusername, c.* FROM #__users u, #__cbe c, #__users u2 WHERE u.id=c.id AND c.bannedby=u2.id AND c.banned=2 AND u.id!='".$my->id."'";
	$query .= " LIMIT $limitstart, $limit";
	$database->setQuery($query);
	$row = $database->loadObjectList();
?> 
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script>

function process() {
	document.imageAdmin.submit();
}


</script>

<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_MODERATE_TITLE; ?></td>
	</tr>
</table>   
<?php
if($total<1) {
	echo _UE_NOUNBANREQUESTS;
	return;
}
?>                  
<span class='contentheading'><?php echo _UE_UNBAN_MODERATE; ?></span><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td align="right"><?php echo _UE_PAGE; ?>: <?php echo cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></td>
</tr>
</table>
          <form action='index.php?option=com_cbe&task=processReports<?php echo $Itemid_c; ?>' method='post' name='imageAdmin'>
          <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead>
		<th><?php echo _UE_BANNEDUSER; ?></th>
		<th><?php echo _UE_BANNEDREASON; ?></th>
		<th><?php echo _UE_BANNEDON; ?></th>
		<th><?php echo _UE_BANNEDBY; ?></th>
		</thead>	
<?php  
for($i = 0; $i < count($row); $i++) {
	$j=$i+1;
	echo "<tr align='center' valign='middle'>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->id)."'>".getNameFormat($row[$i]->bannedname,$row[$i]->bannedusername,$ueConfig['name_format']). "</a></td>";
	echo "<td>".nl2br($row[$i]->bannedreason)."</td>";
	echo "<td>".dateConverter($row[$i]->banneddate,'Y-m-d',$ueConfig['date_format'])."</td>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->bannedby)."'>".getNameFormat($row[$i]->bannedbyname,$row[$i]->bannedbyusername,$ueConfig['name_format']). "</a></td>";
	echo '</tr>';
}
echo '</table>';
echo "</form>";
}


function moderateReports($option)
{
	global $ueConfig,$limitstart;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}

	$ue_base_url = "index.php?option=com_cbe&task=moderateReports".$Itemid_c;	// Base URL string


	$query = "SELECT count(*) FROM #__cbe_userreports  WHERE reportedstatus=0 ";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$total = $database->loadResult();

	if($total<1) {
		echo _UE_NONEWUSERREPORTS;
		return;
	}

	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT u2.name as reportedbyname, u2.username as reportedbyusername, u.name as reportedname, u.username as reportedusername, ur.* FROM #__users u, #__cbe_userreports ur, #__users u2 WHERE u.id=ur.reporteduser AND u2.id=ur.reportedbyuser AND  ur.reportedstatus=0 ORDER BY ur.reporteduser,ur.reportedondate";
	$query .= " LIMIT $limitstart, $limit";
	$database->setQuery($query);
	$row = $database->loadObjectList();
?> 
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script>

function process() {
	document.imageAdmin.submit();
}


</script>

<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_MODERATE_TITLE; ?></td>
	</tr>
</table>   
                    
<span class='contentheading'><?php echo _UE_USERREPORT_MODERATE; ?></span><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td align="right"><?php echo _UE_PAGE; ?>: <?php echo cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></td>
</tr>
</table>
          <form action='index.php?option=com_cbe&task=processReports<?php echo $Itemid_c; ?>' method='post' name='imageAdmin'>
          <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead>
		<th>&nbsp;</th>
		<th><?php echo _UE_REPORTEDUSER; ?></th>
		<th><?php echo _UE_REPORT; ?></th>
		<th><?php echo _UE_REPORTEDONDATE; ?></th>
		<th><?php echo _UE_REPORTEDBY; ?></th>	
		</thead>	
<?php  
for($i = 0; $i < count($row); $i++) {
	$j=$i+1;
	echo "<tr align='center' valign='middle'>";
	echo "<td><input id='img".$row[$i]->reportid."' type=\"checkbox\" CHECKED name=\"reports[]\" value=\"".$row[$i]->reportid."\"></td>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->reporteduser)."'>".getNameFormat($row[$i]->reportedname,$row[$i]->reportedusername,$ueConfig['name_format']). "</a></td>";
	echo "<td>".$row[$i]->reportexplaination."</td>";
	echo "<td>".dateConverter($row[$i]->reportedondate,'Y-m-d',$ueConfig['date_format'])."</td>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->reportedbyuser)."'>".getNameFormat($row[$i]->reportedbyname,$row[$i]->reportedbyusername,$ueConfig['name_format']). "</a></td>";
	echo '</tr>';
}

echo '<tr align="center" valign="middle"><td colspan=5><input class="button" onclick="javascript:process();" type="button" value="'._UE_PROCESSUSERREPORT.'"></td></tr>';
echo '</table>';
echo "</form>";
}



function moderateImages($option)
{
	global $ueConfig,$limitstart;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		echo JText::_('ALERTNOTAUTH');

		return;
	}
	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}

	$ue_base_url = "index.php?option=com_cbe&task=moderateImages".$Itemid_c;	// Base URL string


	$query = "SELECT count(*) FROM #__cbe  WHERE avatarapproved=0";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$total = $database->loadResult();



	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT * FROM #__cbe c, #__users u WHERE u.id= c.id AND c.avatarapproved=0";
	$query .= " LIMIT $limitstart, $limit";
	$database->setQuery($query);
	$row = $database->loadObjectList();
?> 
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script>
function approve() {
	//imageAdmin.action='index.php?option=com_cbe&task=approveImage';
	document.imageAdmin.act.value='1';
	document.imageAdmin.submit();
}
function reject() {
	//imageAdmin.action='index.php?option=com_cbe&task=approveImage';
	document.imageAdmin.act.value='0';
	document.imageAdmin.submit();
}


</script>

<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_MODERATE_TITLE; ?></td>
	</tr>
</table>  
<?php
if($total<1) {
	echo _UE_NOIMAGESTOAPPROVE;
	return;
}
?>                    
<span class='contentheading'><?php echo _UE_IMAGE_MODERATE; ?></span><br><br>
<?php if(count($row) > $limit) { ?>
<div style="width:100%;text-align:center;"><?php echo cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div><hr>
<?php
}
echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
echo "<form action='index.php?option=com_cbe&task=approveImage".$Itemid_c."' method='post' name='imageAdmin'>";
echo "<tr align='center' valign='middle'>";
echo '<td colspan="4">&nbsp;</td></tr>';
echo "<tr align='center' valign='middle'>";
$avatar_gallery_path='images/cbe/';
$sys_gallery_path=JPATH_SITE . 'components/com_cbe/images/';
for($i = 0; $i < count($row); $i++) {
	$j=$i+1;
	$image=$avatar_gallery_path.'tn'.$row[$i]->avatar;
	echo '<td>';
	echo '<img style="cursor:hand;" src="'.$image.'" onclick="this.src=\''.$avatar_gallery_path.$row[$i]->avatar.'\'" /><br />';
	echo "<label for='img".$row[$i]->id."'>".getNameFormat($row[$i]->name,$row[$i]->username,$ueConfig['name_format']). " <input id='img".$row[$i]->id."' type=\"checkbox\" name=\"avatar[]\" value=\"".$row[$i]->id."\"></label>";
	echo "<br /><img style='cursor:hand;' onclick='javascript:window.location=\"".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=approveImage&flag=1&avatars=".$row[$i]->id)."\"' src='".$sys_gallery_path."approve.png' title='Approval Image'> <img style='cursor:hand;' src='".$sys_gallery_path."reject.png' onclick='javascript:window.location=\"".JRoute::_("index.php?option=com_cbe&task=approveImage&flag=0&avatars=".$row[$i]->id)."\"' title='Reject Image'> <img style='cursor:hand;' src='".$sys_gallery_path."updateprofile.gif' title='View Profile' onclick='javascript:window.location=\"".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->id)."\"'> <img style='cursor:hand;' src='".$sys_gallery_path."ban.png' title='Ban Profile'>";
	echo '</td>';
	if (function_exists('fmod')) {
		if (!fmod(($j),4)){echo '</tr><tr align="center" valign="middle">';}
	} else {
		if (!cbe_fmodReplace(($j),4)){echo '</tr><tr align="center" valign="middle">';}
	}

}
echo '</tr>';
echo '<tr><td colspan="4" align="center"><input class="button" onclick="javascript:approve();" type="button" value="'._UE_APPROVE_IMAGES.'"><input class="button" onclick="javascript:reject();" type="button" value="'._UE_REJECT_IMAGES.'">';
echo '</table>';
echo '<input type=hidden name="act" value="">';
echo "</form>";
if(count($row) > $limit) { ?>
<hr><div style="width:100%;text-align:center;"><?php echo cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div>
<?php
}
}


function viewReports($option,$uid)
{
	global $ueConfig,$limitstart;

	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	$isModerator=isModerator($my->id);
	if ($isModerator == 0) {
		echo JText::_('ALERTNOTAUTH');

		return;
	}

	if (!isset($_REQUEST['Itemid'])) {
		if ($GLOBALS['Itemid_com']!='') {
			$Itemid_c = $GLOBALS['Itemid_com'];
		} else {
			$Itemid_c = '';
		}
	} else {
		$Itemid_c = "&Itemid=".$_REQUEST['Itemid'];
	}

	$ue_base_url = "index.php?option=com_cbe&task=viewReports".$Itemid_c;	// Base URL string


	$query = "SELECT count(*) FROM #__cbe_userreports  WHERE reportedstatus=0 AND reporteduser='".$uid."'";
	if(!$database->setQuery($query)) print $database->getErrorMsg();
	$total = $database->loadResult();


	if (empty($limitstart)) $limitstart = 0;
	$limit = 20;
	if ($limit > $total) {
		$limitstart = 0;
	}

	$query = "SELECT u2.name as reportedbyname, u2.username as reportedbyusername, u.name as reportedname, u.username as reportedusername, ur.* FROM #__users u, #__cbe_userreports ur, #__users u2 WHERE u.id=ur.reporteduser AND u2.id=ur.reportedbyuser AND  ur.reportedstatus=0 AND ur.reporteduser='".$uid."' ORDER BY ur.reporteduser,ur.reportedondate";
	$query .= " LIMIT $limitstart, $limit";
	$database->setQuery($query);
	$row = $database->loadObjectList();
?> 
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>

<!-- TAB -->
<table cellspacing="0" cellpadding="4" border="0" width="100%">
	<tr>
		<td class="componentheading" colspan="6"><?php echo _UE_MODERATE_TITLE; ?></td>
	</tr>
</table>   
<?php
if($total<1) {
	echo _UE_NOREPORTSTOPROCESS;
	return;
}
?> 
                    
<span class='contentheading'><?php echo _UE_USERREPORT; ?></span><br><br>
<?php if(count($row) > $limit) { ?>
<div style="width:100%;text-align:center;"><?php echo cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div><hr>
<?php
}
?>
          <table width='100%' border='0' cellpadding='4' cellspacing='2'>
		<thead>
		<th><?php echo _UE_REPORTEDUSER; ?></th>
		<th><?php echo _UE_REPORT; ?></th>
		<th><?php echo _UE_REPORTEDONDATE; ?></th>
		<th><?php echo _UE_REPORTEDBY; ?></th>	
		</thead>	
<?php  
for($i = 0; $i < count($row); $i++) {
	$j=$i+1;
	echo "<tr align='center' valign='middle'>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->reporteduser)."'>".getNameFormat($row[$i]->reportedname,$row[$i]->reportedusername,$ueConfig['name_format']). "</a></td>";
	echo "<td>".$row[$i]->reportexplaination."</td>";
	echo "<td>".dateConverter($row[$i]->reportedondate,'Y-m-d',$ueConfig['date_format'])."</td>";
	echo "<td><a href='".JRoute::_("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=".$row[$i]->reportedbyuser)."'>".getNameFormat($row[$i]->reportedbyname,$row[$i]->reportedbyusername,$ueConfig['name_format']). "</a></td>";
	echo '</tr>';
}
echo '</table>';
if(count($row) > $limit) { ?>
<hr><div style="width:100%;text-align:center;"><?php echo cbe_writePagesLinks($limitstart, $limit, $total, $ue_base_url); ?></div>
<?php
}


} // end of class
?>
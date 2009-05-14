<?php

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/* cbe.class.php include part, providing geocoder edit mode */

// get coord
$enhanced_Config['geocoder_show_single_addrfield'] = 1; // for later use only, do not change!
$my_geo_coord = null;
$first_load_addr = null;
$first_load_addr_ = null;
$geo_btn_dis = '';
$lat_out_val = '';
$lng_out_val = '';
$stat_out_val = '';
$statc_out_val = '';
$acc_out_val = '';
$accc_out_val = '';
$allow_show_out = '';
$allow_show_out_val = 0;
$GeoAddr_readonly = '';
$database = &JFactory::getDBO();
$database->setQuery("SELECT * FROM #__cbe_geodata WHERE uid='".$user->id."'");
$my_geo_coord= $database->loadObject();
$my_geo_coord->GeoAddr = str_replace("+", " ", $my_geo_coord->GeoAddr);
if (!empty($my_geo_coord->GeoLat) || !empty($my_geo_coord->GeoLng)) {
	$geo_btn_dis = " disabled ";
	$lat_out_val = "value=\"".$my_geo_coord->GeoLat."\" ";
	$lng_out_val = "value=\"".$my_geo_coord->GeoLng."\" ";
	$stat_out_val = "value=\""._UE_CBE_GEOCODER_E_QSTATUSRDB."\" ";
	$statc_out_val = " value=\"200\"";
}
if (!empty($my_geo_coord->GeoAccCode)) {
	$accc_out_val = " value=\"".$my_geo_coord->GeoAccCode."\"";
	if ( $my_geo_coord->GeoAccCode == "8" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_ADDR."\" ";
	if ( $my_geo_coord->GeoAccCode == "6" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_STREET."\" ";
	if ( $my_geo_coord->GeoAccCode == "5" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_ZIPPLZ."\" ";
	if ( $my_geo_coord->GeoAccCode == "4" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_CITY."\" ";
	if ( $my_geo_coord->GeoAccCode == "3" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_SUBREGION."\" ";
	if ( $my_geo_coord->GeoAccCode == "2" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_REGION."\" ";
	if ( $my_geo_coord->GeoAccCode == "1" ) $acc_out_val = " value=\""._UE_CBE_GEOCODER_E_ACC_COUNTRY."\" ";
}
if (!empty($my_geo_coord->GeoAllowShow)) {
	// $allow_show_out = " checked disabled";
	$allow_show_out = " checked ";
	$allow_show_out_val = 1;
}

$geo_readonly = 'readonly';
if ($enhanced_Config['geocoder_allow_directinput'] == '1') {
	$geo_readonly = '';
}
if ($enhanced_Config['geocoder_use_addrfield'] == '1' ) {
	$_fge = 0;
	$_fgq = "";
	if (!empty($enhanced_Config['geocoder_street_dbname'])) {
		$_fgq .= $enhanced_Config['geocoder_street_dbname']." as Geo_street";
		$_fge++;
	}
	if (!empty($enhanced_Config['geocoder_postcode_dbname'])) {
		if ($_fge > 0) { 
			$_fgq .= ", ";
		}
		$_fgq .= $enhanced_Config['geocoder_postcode_dbname']." as Geo_postcode";
		$_fge++;
	}
	if (!empty($enhanced_Config['geocoder_city_dbname'])) {
		if ($_fge > 0) { 
			$_fgq .= ", ";
		}
		$_fgq .= $enhanced_Config['geocoder_city_dbname']." as Geo_city";
		$_fge++;
	}
	if (!empty($enhanced_Config['geocoder_state_dbname'])) {
		if ($_fge > 0) { 
			$_fgq .= ", ";
		}
		$_fgq .= $enhanced_Config['geocoder_state_dbname']." as Geo_state";
		$_fge++;
	}
	if (!empty($enhanced_Config['geocoder_country_dbname'])) {
		if ($_fge > 0) { 
			$_fgq .= ", ";
		}
		$_fgq .= $enhanced_Config['geocoder_country_dbname']." as Geo_country";
		$_fge++;
	}
	if ($_fge > 0) { 
		$_fge = 1;
	}
	
	if ($_fge == 1) {
		$_query = "SELECT ".$_fgq." FROM #__cbe WHERE user_id='".$my->id."'";
		$database->setQuery($_query);
		$database->loadObject($first_load_addr);
		if ($database->query()) {
			$first_load_addr_ = $first_load_addr->Geo_street." ".$first_load_addr->Geo_postcode." ".$first_load_addr->Geo_city
					." ".$first_load_addr->Geo_state." ".$first_load_addr->Geo_country;
			if (empty($my_geo_coord->GeoAddr) || $my_geo_coord->GeoAddr == '') {
				$my_geo_coord->GeoAddr = $first_load_addr_;
			}
		} else {
			$enhanced_Config['geocoder_use_addrfield']='0';
		}
	} else {
		$enhanced_Config['geocoder_use_addrfield']='0';
	}
}
if ($my_geo_coord->GeoAddr !='') {
	$GeoAddr_readonly = ' readonly ';
}

$re_output = "";
//$re_output .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\"> \n";

if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php')) {
	if ($ui == 2) {
		include(JPATH_SITE.'/components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php');
		$re_output .= $js_cbe_geocoder_edit."\n\n";
	} else if ($ui == 1) {
		if ($ueConfig['switch_js_inc'] != 1) {
			$re_output .="\n<script type=\"text/javascript\" src=\"".JURI::root()."index2.php?option=com_cbe".$Itemid_com."&format=raw&task=callthrough&scrp=cbe_gce\"></script>\n";
		} else {
			$js_cbe_geocoder_edit = '';
			if (file_exists('components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php')) {
				include('components/com_cbe/enhanced/geocoder/_js_geocoder_edit.php');
				echo $js_cbe_geocoder_edit;
			}
		}
	}
}

$re_ouput .= "\n\n";
$re_ouput .= "<style type=\"text/css\">\n";
$re_ouput .= "div#popup {\n";
$re_ouput .= "\tbackground:#EFEFEF;\n";
$re_ouput .= "\tborder:1px solid #999999;\n";
$re_ouput .= "\tmargin:0px;\n";
$re_ouput .= "\tpadding:7px;\n";
$re_ouput .= "\twidth:270px;\n";
$re_ouput .= "}\n";
$re_ouput .= "v\:* { \n";
$re_ouput .= "\tbehavior:url(#default#VML); \n";
$re_ouput .= "}\n";
$re_ouput .= "</style>\n";

$re_output .= "\n\n<table cellpadding='5' cellspacing='0' border='0' width='100%'>\n";
$re_output .= "\t\t<br /><div><b>".getLangDefinition($tab->description)."</b></div><br />\n";
// if ($enhanced_Config['geocoder_show_single_addrfield']== '1') {
	$re_output .= "<tr><td>"._UE_CBE_GEOCODER_E_ADDR."</td>";
	$re_output .= "<td><textarea name=\"GeoAddr\" id=\"GeoAddr\" rows=\"7\" cols=\"30\" onChange=\"act_geo_btn();\"".$GeoAddr_readonly.">";
	if ($my_geo_coord->GeoAddr != '') {
		$re_output .= $my_geo_coord->GeoAddr;
	}
	$re_output .= "</textarea> \n";
	if ($enhanced_Config['geocoder_use_addrfield'] == '1') {
		$re_output .= "<input type=\"hidden\" name=\"Geo_street\" id=\"Geo_street\" value=\"".$first_load_addr->Geo_street."\" /> \n";
		$re_output .= "<input type=\"hidden\" name=\"Geo_postcode\" id=\"Geo_postcode\" value=\"".$first_load_addr->Geo_postcode."\" /> \n";
		$re_output .= "<input type=\"hidden\" name=\"Geo_city\" id=\"Geo_city\" value=\"".$first_load_addr->Geo_city."\" /> \n";
		$re_output .= "<input type=\"hidden\" name=\"Geo_state\" id=\"Geo_state\" value=\"".$first_load_addr->Geo_state."\" /> \n";
		$re_output .= "<input type=\"hidden\" name=\"Geo_country\" id=\"Geo_country\" value=\"".$first_load_addr->Geo_country."\" /> \n";
		$re_output .= "</td></tr> \n";
	}
//} else {
//	$re_output .= "<tr><td>Stra�e</td><td><input type=\"text\" name=\"street\" id=\"geo_street\" /> </td></tr>\n";
//	$re_output .= "<tr><td>Nr.</td><td><input type=\"text\" name=\"str_nr\" id=\"geo_street_nr\" size=\"6\" /> </td></tr>\n";
//	$re_output .= "<tr><td>PLZ</td><td><input type=\"text\" name=\"plz\" id=\"geo_plz\" size=\"6\" /> </td></tr>\n";
//	$re_output .= "<tr><td>Ort</td><td><input type=\"text\" name=\"city\" id=\"geo_City\" /> </td></tr>\n";
//	$re_output .= "<tr><td>Land</td><td><input type=\"text\" name=\"country\" id=\"geo_country\" /> </td></tr>\n";
//}
$re_output .= "<tr> \n <td>&nbsp;</td><td>";
//$re_output .= "<tr> \n <td colspan=\"2\">";
//$re_output .= "<center><input type=\"button\" value=\""._UE_CBE_GEOCODER_E_BTN."\" class=\"button\" onclick=\"GeoCode();\" id=\"cbe_geo_ajax_btn\" ".$geo_btn_dis."/> &nbsp;";
if ($enhanced_Config['geocoder_use_addrfield'] == '0') {
$re_output .= "<center><input type=\"button\" value=\""._UE_CBE_GEOCODER_E_BTN."\" class=\"button\" onclick=\"GeoCode();\" id=\"cbe_geo_ajax_btn\" ".$geo_btn_dis."/> &nbsp;";
	$re_output .= "<input type=\"button\" value=\""._UE_CBE_GEOCODER_CHANGE_BTN."\" class=\"button\" onclick=\"cbe_geoCode_EBTN();\" id=\"cbe_geo_ajax_btn\" /> &nbsp;";
	$re_output .= "<input type=\"button\" value=\""._UE_CBE_GEOCODER_CLEARALL_BTN."\" class=\"button\" onclick=\"cbe_geoCode_CLA();\" id=\"cbe_geo_ajax_btn\" /></center> \n";
} else {
	$re_output .= "<input type=\"button\" value=\""._UE_CBE_GEOCODER_E_BTN."\" class=\"button\" onclick=\"cbe_geoCode_GGFD();\" id=\"cbe_geo_ajax_btn\" /> &nbsp;";
	$re_output .= "<input type=\"button\" value=\""._UE_CBE_GEOCODER_CLEARALL_BTN."\" class=\"button\" onclick=\"cbe_geoCode_CLA();\" id=\"cbe_geo_ajax_btn\" /></center> \n";
}
$re_output .= "<br><div id=\"GeoMessage\">&nbsp</div> \n";
$re_output .= "</td>\n</tr><tr> \n";
$re_output .= "<td> \n"._UE_CBE_GEOCODER_E_STATUS."</td><td><input type=\"text\" name=\"GeoStatus\" id=\"GeoStatus\" ".$stat_out_val."readonly /><br> \n";
$re_output .= " <input type=\"hidden\" name=\"GeoStatusCode\" id=\"GeoStatusCode\"".$statc_out_val." readonly />\n";
$re_output .= " <input type=\"hidden\" name=\"GeoCoder_doUpdate\" id=\"GeoCoder_doUpdate\" value=\"0\" /> \n";
$re_output .= "</td></tr> \n";
$re_output .= "<tr> \n";
if ($enhanced_Config['geocoder_show_acc'] == '1') {
	$re_output .= "<td> \n"._UE_CBE_GEOCODER_E_ACC."</td><td><input type=\"text\" name=\"GeoAcc\" id=\"GeoAcc\" ".$acc_out_val."readonly /><br> \n";
} else {
	$re_output .= "<td colspan=\"2\"> \n<input type=\"hidden\" name=\"GeoAcc\" id=\"GeoAcc\" ".$acc_out_val."readonly /> \n";
}
$re_output .= "<input type=\"hidden\" name=\"GeoAccCode\" id=\"GeoAccCode\"".$accc_out_val." readonly /></td> \n";
$re_output .= "</tr> \n<tr> \n";
$re_output .= "<td> \n"._UE_CBE_GEOCODER_E_GEOLNG."</td><td>\n<input type=\"text\" name=\"GeoLng\" id=\"GeoLng\" ".$lng_out_val.$geo_readonly." /><br> \n</td> \n";
$re_output .= "</tr><tr> \n";
$re_output .= "<td> \n"._UE_CBE_GEOCODER_E_GEOLAT."</td><td>\n<input type=\"text\" name=\"GeoLat\" id=\"GeoLat\" ".$lat_out_val.$geo_readonly." /><br> \n</td> \n";
$re_output .= "</td>\n</tr> \n";
if ($enhanced_Config['geocoder_useragree_usage']=='1') {
	$re_output .= "<tr><td>\n"._UE_CBE_GEOCODER_E_ALLOWVIEW."</td><td>\n<input type=\"checkbox\" name=\"GeoAllowShow\" id=\"GeoAllowShow\" value=\"".$allow_show_out_val."\" onClick=\"cbeGeoAllowShowChange();\" ".$allow_show_out."/></td></tr> \n";
} else {
	$re_output .= "<tr><td>\n &nbsp; </td><td>\n<input type=\"hidden\" name=\"GeoAllowShow\" id=\"GeoAllowShow\" value=\"1\" onClick=\"cbeGeoAllowShowChange();\" /></td></tr> \n";
}

if ($enhanced_Config['geocoder_allow_visualverify']=='1') {
	if (!empty($lng_out_val) && !empty($lat_out_val)) {
		$re_output .= "<tr><td colspan=\"2\"><div id=\"check_Saved\"><a href=\"#cbe_edit_map\" onClick=\"showSavedPoint();return false;\">"._UE_CBE_GEOCODER_E_ALLOWVIEW_CHECKSAVED."</a></div></td></tr>";
	} else {
		$re_output .= "<tr><td colspan=\"2\"><div id=\"check_Saved\"></div></td></tr>";
	}
	$re_output .= "<tr><td colspan=\"2\"> \n";
	$re_output .= "<a name=\"cbe_edit_map\"></a><div id=\"cbe_geo_map\" style=\"width:400px; height:350px\"></div> \n";
	$re_output .= "</td></tr> \n";
}
$re_output .= "</table> \n";

?>
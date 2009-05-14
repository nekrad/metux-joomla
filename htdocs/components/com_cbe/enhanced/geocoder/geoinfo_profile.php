<?php
 defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (file_exists('components/com_cbe/enhanced/geocoder/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/geocoder/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/geocoder/language/english.php');
}

$do_meter = 0;
$geo_dist_obj = array();
$geo_distance = 0;
$geo_dist_null = 0;
$tab_enable = 0;
$geoInfo_out = "";
$geoTabLink  = "index.php?option=com_cbe".$GLOBALS['Itemid_com']."&amp;task=userProfile&user=".$user->id;
$geoTabLink .= "&amp;geoinfo_func=show_distance&amp;index="._UE_CBE_GEOINFO_PROFILE_TAB;

$my=&JFactory::getUser();
$database = &JFactory::getDBO();
if ($my->id != $user->id) {
	// get distance
	$geo_query = "SELECT (acos(sin(radians(u2.GeoLat)) * sin(radians(u1.GeoLat)) + cos(radians(u2.GeoLat)) * cos(radians(u1.GeoLat)) *"
		." cos(radians(u2.GeoLng) - radians(u1.GeoLng))) * 6371.11) as distance, u3.uid as has_data FROM #__cbe_geodata as u1, #__cbe_geodata as u2, #__cbe_geodata as u3 WHERE "
		."u1.uid='".$my->id."' AND u2.uid='".$user->id."' AND u2.uid=u3.uid AND (u1.GeoLat != 0 AND u1.GeoLng != 0 AND u2.GeoLat != 0 AND u2.GeoLng != 0)";
	if ($enhanced_Config['geocoder_useragree_usage'] == '1') {
		$geo_query .= " AND (u1.GeoAllowShow = '1' AND u2.GeoAllowShow = '1')";
	}
	$database->setQuery($geo_query);
	//#### derelvis: GeoDistance Bugfix hier....
	$geo_dist_obj = $database->loadObject();
	$geo_distance = number_format($geo_dist_obj->distance, 1, '.', '');

	if ($geo_distance < 1 && $geo_distance > 0) {
		$geo_distance = $geo_distance * 1000;
		$do_meter = 1;
	}
	if ($geo_distance == 0 AND !empty($geo_dist_obj->has_data)) {
		$do_meter = 1;
		$geo_dist_null = 1;
	}

	$database->setQuery("SELECT enabled FROM #__cbe_tabs WHERE title = '_UE_CBE_GEOINFO_PROFILE_TAB'");
	$tab_enable = $database->loadResult();

	$geoInfo_out = "<tr> \n";
	$geoInfo_out .= "<td class=\"sectiontableentry".$i."\" width=\"35%\" style=\"font-weight:bold;\">"._UE_CBE_GEOINFO_DISTANCE."</td> \n";
	$geoInfo_out .= "<td class=\"sectiontableentry".$i."\">";
	if ($tab_enable == 1 && $geo_distance > 0) {
		$geoInfo_out .= "<a href=\"".JRoute::_($geoTabLink)."\">";
	}
	if ($geo_distance > 0 || $geo_dist_null == 1) {
		$geoInfo_out .= $geo_distance." ".(($do_meter == 1) ? _UE_CBE_GEOINFO_m : _UE_CBE_GEOINFO_Km);
	} else {
		$geoInfo_out .= _UE_CBE_GEOINFO_NODATA;
	}
	if ($tab_enable == 1 && ($geo_distance > 0 || $geo_dist_null == 1)) {
		$geoInfo_out .= "</a>";
	}
	$geoInfo_out .= "</td> \n";
	$geoInfo_out .= "</tr> \n";
	
	// $geoInfo_out = "Entfernung: ".$geo_distance." ".(($do_meter == 1) ? "m" : "Km");
}

if ($my->id != 0 && !empty($geo_distance)) {
	echo $geoInfo_out;
	$i= ($i==1) ? 2 : 1;
}
?>
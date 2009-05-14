<?php
/*************************************************************
* Community Builder Enhanced
* Author Phil_K
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$js_cbe_UserMap = <<<EOT

<script language="javascript" type="text/javascript">
<!--

var map;
var icon0;
var scrolldiv = 1;
var cbe_user_cluster = 0;
var cbe_use_custom_icon = 0;

function cbe_addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function'){
		window.onload = func;
	} else {
		window.onload = function() {
			oldonload();
			func();
		}
	}
}

function cbe_addUnLoadEvent(func) { 
	var oldundonload = window.onunload;
	if (typeof window.onunload != 'function'){ 
		window.onunload = func;
	} else { 
		window.onunload = function() {
			oldonunload();
			func();
		}
	}
}

function cbe_showAddress(address) {
	var geocoder = new GClientGeocoder();
	if (geocoder) {
		geocoder.getLatLng(address,function(point) {
			if (!point) {
				alert(address + " not found");
			} else {
				map.panTo(point, CBE_RP_USERMAP_ZOOMF_RP);
			}
		});
	}
}

function cbe_load_userMap() {
	if (GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("cbe_user_map"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.setCenter(new GLatLng(CBE_RP_USERMAP_CENTER_RP), CBE_RP_USERMAP_ZOOMF_RP, CBE_RP_USERMAP_MAPTYP_RP);
		//map.setCenter(new GLatLng( 51.960734, 7.627115), 10);

		cbe_loadPointsFromXML();
		GEvent.addListener(map,"moveend", function(){
			cbe_loadPointsFromXML();
		});

		 icon0 = new GIcon();
		 icon0.image = "http://www.google.com/mapfiles/marker.png";
		 icon0.shadow = "http://www.google.com/mapfiles/shadow50.png";
		 icon0.iconSize = new GSize(20, 34);
		 icon0.shadowSize = new GSize(37, 34);
		 icon0.iconAnchor = new GPoint(9, 34);
		 icon0.infoWindowAnchor = new GPoint(9, 2);
		 icon0.infoShadowAnchor = new GPoint(18, 25);
		return true;
	} else {
		return false;
	}
}

function cbe_loadPointsFromXML() {
	var request = GXmlHttp.create();
	//grab the xml
	request.open("GET", "CBE_RP_USERMAP_XML_URL_RP", true);
	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			var xmlDoc = request.responseXML;
			cbe_parseXML(xmlDoc);
		}
	}
	request.send(null);
}

function cbe_parseXML(xmlDoc) {
	var markers = xmlDoc.documentElement.getElementsByTagName("poi");
	//get the viewing area of the map...to be used later
	var bounds = map.getBounds();
	//get rid of existing markers
	map.clearOverlays();
	for (var i = 0; i < markers.length; i++) {
		// obtain the attribues of each marker
		var lat = parseFloat(markers[i].getAttribute("lat"));
		var lng = parseFloat(markers[i].getAttribute("lng"));
		//create point from lat/lng
		var point = new GLatLng(lat,lng);
		//check if point is inside the viewing area of the map
		if (bounds.contains(point) == true) {
			var do_tabs = parseInt(markers[i].getAttribute("InfoCount"));
			if (do_tabs == 1) {
				var html = markers[i].getAttribute("info0");
				var tooltip = markers[i].getAttribute("username");
				var marker = cbe_createMarker(point,html,tooltip);
			} else {
				if (scrolldiv == 0) {
					var html_s = new Array();
					var label_s = new Array();
					for ( var ti = 0; ti < do_tabs; ti++) {
						var infotag = "info" + ti;
						html_s[ti] = markers[i].getAttribute(infotag);
						label_s[ti] = ti + 1;
					}
					var marker = cbe_createTabbedMarker(point, html_s, label_s);
				} else {
					var html = '<div style="width:210px; height:120px; overflow:auto">';
					for ( var ti = 0; ti < do_tabs; ti++) {
						var infotag = "info" + ti;
						html = html + markers[i].getAttribute(infotag);
					}
					html = html + '</div>';
					var tooltip = do_tabs + " User";
					var marker = cbe_createMarker(point,html,tooltip);
				}
			}
			map.addOverlay(marker);
		}
	}
}

function cbe_createMarker(point,html,tooltip) {
	if (tooltip != '') {
		var marker = new GMarker(point, {title: tooltip});
	} else {
		var marker = new GMarker(point);
	}
	GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(html);
	});
	return marker;
}

function cbe_createTabbedMarker(point,htmls,labels) {
	var marker = new GMarker(point);
	var htll = htmls.length;
	GEvent.addListener(marker, "click", function() {
		// adjust the width so that the info window is large enough for this many tabs
		if (htll > 2) {
			htmls[0] = '<div style="width:'+htmls.length*88+'px">' + htmls[0] + '</div>';
		}
		var tabs = [];
		for (var i=0; i<htll; i++) {
			tabs.push(new GInfoWindowTab(labels[i],htmls[i]));
		}
		marker.openInfoWindowTabsHtml(tabs);
	});
	return marker;
}


cbe_addLoadEvent(cbe_load_userMap);
cbe_addUnLoadEvent(GUnload);
//cbe_load_userMap();

//-->
</script>
EOT;


//
//<style type="text/css">
//div#popup {
//	background:#EFEFEF;
//	border:1px solid #999999;
//	margin:0px;
//	padding:7px;
//	width:270px;
//}
//v\:* { 
//	behavior:url(#default#VML); 
//}
//</style>


// Check what has to be queried and replaced
$database = &JFactory::getDBO();
$cbe_usermap_start_center = '';
$cbe_usermap_start_ucoord = array();
$xml_query_url = '';

$cbe_usermap_start_center = $enhanced_Config['geocoder_usermap_center_lat'].",".$enhanced_Config['geocoder_usermap_center_lng'];
if ($enhanced_Config['geocoder_usermap_force_center'] != '1') {
	$database->setQuery("SELECT GeoLat, GeoLng FROM #__cbe_geodata WHERE uid='".$my->id."'");
	$cbe_usermap_start_ucoord = $database->loadObject();
	if (!empty($cbe_usermap_start_ucoord->GeoLat) && !empty($cbe_usermap_start_ucoord->GeoLng)) {
		$cbe_usermap_start_center = $cbe_usermap_start_ucoord->GeoLat.",".$cbe_usermap_start_ucoord->GeoLng;
	}
}	
$js_cbe_UserMap = str_replace('CBE_RP_USERMAP_CENTER_RP', $cbe_usermap_start_center, $js_cbe_UserMap);
$js_cbe_UserMap = str_replace('CBE_RP_USERMAP_ZOOMF_RP', $enhanced_Config['geocoder_usermap_start_zoom'], $js_cbe_UserMap);
$js_cbe_UserMap = str_replace('CBE_RP_USERMAP_MAPTYP_RP', $enhanced_Config['geocoder_usermap_start_type'], $js_cbe_UserMap);

$xml_query_url = JPATH_SITE."/index2.php?option=com_cbe&format=raw&task=doGeoMapXML";
$js_cbe_UserMap = str_replace('CBE_RP_USERMAP_XML_URL_RP', $xml_query_url, $js_cbe_UserMap);

?>

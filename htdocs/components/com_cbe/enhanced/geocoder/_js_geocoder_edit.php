<?php
/*************************************************************
* Community Builder Enhanced
* Author Phil_K
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$js_cbe_geocoder_edit = <<<EOT

<script language="javascript" type="text/javascript">
<!--
var req=null;
var target;
var isIE;
var NewCenter = new Array();
var newpoints = new Array();
var cbe_points = new Array();
var cbe_GeoCodeTime = 0;
var cbe_GeoCodeTimeChk;
var cbe_allowMapClick_call = 0;
var cbe_geocode_byJS = CBE_RP_GeoCode_byJS_RP;
var cbe_geocoder;
var cbe_geocoder_dto = 0;
var cbe_geocoder_dto_wait = 0;
var cbe_geocoder_dto_success = 0;
var cbe_geocoder_req_done = 0;
var cbe_geocoder_as_error = 0;

function act_geo_btn() {
	var btn = document.getElementById("cbe_geo_ajax_btn");
	btn.disabled = false;
	return true;
}

function cbe_geoCode_EBTN() {
	var btn = document.getElementById("cbe_geo_ajax_btn");
	var geoAddrField = document.getElementById("GeoAddr");
	var ShowSavedLink	 = document.getElementById("check_Saved");
	btn.disabled = false;
	ShowSavedLink.innerHTML = "&nbsp";
	geoAddrField.readOnly = false;
	geoAddrField.focus();
	geoAddrField.select();
	return true;
}

function cbe_geoCode_GGFD() {
	var btn = document.getElementById("cbe_geo_ajax_btn");
	var geoAddrField = document.getElementById("GeoAddr");
	var ShowSavedLink	 = document.getElementById("check_Saved");
	var newInstertAddr = CBE_RPtakeOverFieldsSumVarRP;
	var reWhitespace = /^\s+$/;
	cbe_geocoder_as_error = 0;
	if (newInstertAddr == geoAddrField.value && cbe_geocoder_dto_wait == 0) {
		setMessageUsingDOM("_UE_CBE_GEOCODER_E_UNCHANCHED");
		cbe_geocoder_dto = 0;
		return true;
	}
	if (newInstertAddr.length <= 3 || reWhitespace.test(newInstertAddr)) {
		setMessageUsingDOM("empty");
		cbe_geocoder_dto = 0;
		return true;
	}
	cbe_geocoder_dto = 1;
	btn.disabled = false;
	ShowSavedLink.innerHTML = "&nbsp";
	cbe_geoCode_GGFD_A();
	geoAddrField.value = newInstertAddr;
	geoAddrField.focus();
	geoAddrField.select();
	GeoCode();
	return true;
}

function cbe_geoCode_GGFD_C() {
	var btn = document.getElementById("cbe_geo_ajax_btn");
	var geoAddrField = document.getElementById("GeoAddr");
	var ShowSavedLink	 = document.getElementById("check_Saved");
	var newInstertAddr = CBE_RPtakeOverFieldsSumVarRP;
	var reWhitespace = /^\s+$/;
	cbe_geocoder_as_error = 0;
	if (newInstertAddr == geoAddrField.value && cbe_geocoder_dto_wait == 0) {
		setMessageUsingDOM("_UE_CBE_GEOCODER_E_UNCHANCHED");
		cbe_geocoder_dto = 0;
		return true;
	}
	if (newInstertAddr.length <= 3 || reWhitespace.test(newInstertAddr)) {
		setMessageUsingDOM("empty");
		cbe_geocoder_dto = 0;
		return true;
	}
	cbe_geocoder_dto = 1;
	btn.disabled = false;
	ShowSavedLink.innerHTML = "&nbsp";
	cbe_geoCode_GGFD_A();
	geoAddrField.value = newInstertAddr;
	var gc_chk = GeoCode();
	if (gc_chk == false) {
		cbe_geocoder_as_error = 1;
		return false;
	}
	return true;
}

function cbe_geoCode_CLA() {
	var btn = document.getElementById("cbe_geo_ajax_btn");
	var geoAddrField = document.getElementById("GeoAddr");
	var FormStatus	= document.getElementById("GeoStatus");
	var FormAcc	= document.getElementById("GeoAcc");
	var FormLong	= document.getElementById("GeoLng");
	var FormLat	= document.getElementById("GeoLat");
	var FormDoUpdate	 = document.getElementById("GeoCoder_doUpdate");
	var ShowSavedLink	 = document.getElementById("check_Saved");
	btn.disabled = false;
	geoAddrField.value = '';
	FormStatus.value	= '';
	FormAcc.value	= '';
	FormLong.value	= '';
	FormLat.value	= '';
	FormDoUpdate.value = "3";
	ShowSavedLink.innerHTML = "&nbsp";
	setMessageUsingDOM(" ");
	return true;
}

function cbe_geoCode_GGFD_A() {
	//
	var geo_street	= document.getElementById("Geo_street");
	var geo_postcode	= document.getElementById("Geo_postcode");
	var geo_city	= document.getElementById("Geo_city");
	var geo_state	= document.getElementById("Geo_state");
	var geo_country	= document.getElementById("Geo_country");

	CBE_RPtakeOverFieldsVarStreet_RP;
	CBE_RPtakeOverFieldsVarPostcode_RP;
	CBE_RPtakeOverFieldsVarCity_RP;
	CBE_RPtakeOverFieldsVarState_RP;
	CBE_RPtakeOverFieldsVarCountry_RP;

	CBE_RPtakeOverFieldsVarTransStreet_RP;
	CBE_RPtakeOverFieldsVarTransPostcode_RP;
	CBE_RPtakeOverFieldsVarTransCity_RP;
	CBE_RPtakeOverFieldsVarTransState_RP;
	CBE_RPtakeOverFieldsVarTransCountry_RP;

	return true;
}

function cbe_geoCode_reqCheck() {
	var formBTN 	= document.getElementsByName("btnsubmit")[0];
	formBTN.disabled	= true;
	if (cbe_geocoder_req_done != 1) {
		cbe_geocoder_as_error = 1;
		formBTN.disabled	= false;
		return;
	}
}

function cbe_sleep(ms){ 
	var zeit=(new Date()).getTime(); 
	var stoppZeit=zeit+ms; 
	while((new Date()).getTime()<stoppZeit){}; 
}

function cbeGeoAllowShowChange() {
	var FormDoUpdate	 = document.getElementById("GeoCoder_doUpdate");
	var FormStatusCode = document.getElementById("GeoStatusCode");
	var FormGeoAllowShow = document.getElementById("GeoAllowShow");
	if (FormStatusCode.value == '200') {
		FormDoUpdate.value = '1';
	}
	if (FormGeoAllowShow.value == '0') {
		FormGeoAllowShow.value = '1';
		return true;
	}
	if (FormGeoAllowShow.value == '1') {
		FormGeoAllowShow.value = '0';
		return true;
	}
	FormGeoAllowShow.value = '1';
	return true;
}

function cbe_req() {
	this.readyState = 0;
	this.status = 0;
	this.responseText = 0;
}


function cbe_geo2process(response) {
	req = new cbe_req();
	if (!response || response.Status.code != 200) {
		req.readyState = 4;
		req.status = 200;
		req.responseText = "602,0,0,0";
	} else {
		var place = response.Placemark[0];
		var point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
		var Accur = place.AddressDetails.Accuracy;
		var cbeLat = place.Point.coordinates[1];
		var cbeLng = place.Point.coordinates[0];
		req.readyState = 4;
		req.status = 200;
		req.responseText = "200,"+Accur+","+cbeLat+","+cbeLng;
	}
	processRequest(req);
}

function cbe_gc_Address_js(address) {
	cbe_geocoder = new GClientGeocoder();
	if (cbe_geocoder) {
		cbe_geocoder.getLocations(address, cbe_geo2process);
	}
}

function initRequest(url) {
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        isIE = true;
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function getAddress_cbegeo(ga_ck) {
	var geo_street	= document.getElementById("geo_street");
	var geo_street_nr	= document.getElementById("geo_street_nr");
	var geo_plz	= document.getElementById("geo_plz");
	var geo_city	= document.getElementById("geo_city");
	var geo_country	= document.getElementById("geo_country");
	var ga_obj = new Object();
	ga_obj.value = "";
	var ga_value = geo_street.value + "+" + geo_street_nr.value + "+" + geo_plz.value + "+" + geo_city.value + "+" + geo_country.value;
	var ga_vck = ga_value.replace(/\++/,'');
	if (ga_vck !='') {
		ga_obj.value = "VALUE";
	}
	var ga_target = ga_obj;

	if (ga_ck=='1') {
		return ga_target;
	} else {
		return ga_value;
	}
}

function GeoCode() {

	cbe_geocoder_req_done = 0;
	cbe_geocoder_dto_wait = 0;
	var chk_gc_date 	= new Date();
	cbe_GeoCodeTimeChk = chk_gc_date.getTime() - (30 * 1000);
	if (cbe_GeoCodeTime > cbe_GeoCodeTimeChk) {
		setMessageUsingDOM("_UE_CBE_GEOCODER_Q_OVERLOADBLOCK");
		cbe_geocoder_dto_wait = 1;
		return false;
	} else {
		cbe_GeoCodeTime = chk_gc_date.getTime();
	}

	var FormStatus	= document.getElementById("GeoStatus");
	var FormAcc	= document.getElementById("GeoAcc");
	var FormLong	= document.getElementById("GeoLng");
	var FormLat	= document.getElementById("GeoLat");
	FormStatus.value	= "";
	FormAcc.value	= "";
	FormLong.value	= "";
	FormLat.value	= "";

    if (!target) {
    	var target = document.getElementById("GeoAddr");
    	CBE_RPsingleAddressInput1RP
    	CBE_RPsingleAddressInput2RP
	var t_value = t_value.replace(/\s+/g,"+");
    }
    	
    if (target.value != "") {
	var coll = document.mosForm;
    	if (cbe_geocode_byJS == 0) {
		var url="CBE_RPSitePathRP/index2.php?option=com_cbe&format=raw&task=doGeoCoderCBE_RPUIDHASHRP&address=" + escape(t_value);
    		initRequest(url);
		setMessageUsingDOM("_UE_CBE_GEOCODER_Q_WORKING");
		//alert(req);

    		req.open("GET", url, true); 
    		req.onreadystatechange = processRequest;

    		req.send(null);
    	} else {
    		req = cbe_gc_Address_js(t_value);
    	}
    } else {
    	setMessageUsingDOM("empty");
    	cbe_geocoder_dto = 0;
    	cbe_geocoder_req_done = 1;
    	cbe_geocoder_as_error = 0;
    	return true;
    }
}

function processRequest(req1) {
	if (req1) {
		req = req1;
	}
    if (req.readyState == 4) {
	alert(req.responseText);
        if (req.status == 200) {
            var Aussage = req.responseText;
            var message = "";
// setMessageUsingDOM(Aussage);

	var GeoAntwort = Aussage.split(",");
	var GeoStatusCode = GeoAntwort[0];
	var GeoAccCode = GeoAntwort[1];
	var GeoAcc = "";
	var GeoLat = GeoAntwort[2];
	var GeoLng = GeoAntwort[3]
	var out_mes = "Code: " + GeoStatusCode + " " + "Acc:" + GeoAccCode + "  Coord: Lat " + GeoLat + " Long "+GeoLng ;
	cbe_geocoder_dto_success = 0;

	NewCenter[0] = new Array(GeoLat, GeoLng);
	newpoints[0] = new Array(GeoLat, GeoLng, icon0, 'Test', 'Your Address', CBE_RPallowVisualRelocate2RP);

	cbe_points[0] = new GLatLng(GeoLat, GeoLng);

//	var Ausgabe = getValues( Aussage, "coordinates");
//	var statusCode = getValues( Aussage, "code");
//	var out_mes = "Code: " + statusCode + " --- " + "Coord: " + Ausgabe;

	setMessageUsingDOM(out_mes);

	var FormStatus	 = document.getElementById("GeoStatus");
	var FormStatusCode = document.getElementById("GeoStatusCode");
	var FormAcc	 = document.getElementById("GeoAcc");
	var FormAccCode	 = document.getElementById("GeoAccCode");
	var FormLong	 = document.getElementById("GeoLng");
	var FormLat	 = document.getElementById("GeoLat");
	var FormDoUpdate	 = document.getElementById("GeoCoder_doUpdate");
	var FormAllowShow	 = document.getElementById("GeoAllowShow");
	var AddrField_ 	 = document.getElementById("GeoAddr");

	if ( GeoStatusCode == "200" ) { 
		var GeoStatusCodeTxt = "_UE_CBE_GEOCODER_E_QSUCCESS";
		cbe_allowMapClick_call = 1;
		FormDoUpdate.value = "1";
		CBE_RPlockAddrFieldRP
		// FormAllowShow.disabled = false;
		cbe_geocoder_req_done = 1;
		cbe_geocoder_dto_success = 1;
	}
	if ( GeoStatusCode == "602" ) {
		var GeoStatusCodeTxt = "_UE_CBE_GEOCODER_E_QFAILURE";
		FormDoUpdate.value = "0";
		cbe_geocoder_req_done = 1;
		cbe_geocoder_dto_success = 0;
	}

	if ( GeoAccCode == "8" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_ADDR";
	if ( GeoAccCode == "6" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_STREET";
	if ( GeoAccCode == "5" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_ZIPPLZ";
	if ( GeoAccCode == "4" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_CITY";
	if ( GeoAccCode == "3" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_SUBREGION";
	if ( GeoAccCode == "2" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_REGION";
	if ( GeoAccCode == "1" ) GeoAcc = "_UE_CBE_GEOCODER_E_ACC_COUNTRY";

	FormStatus.value		= GeoStatusCodeTxt;
	FormStatusCode.value	= GeoStatusCode;
	CBE_RPshowAccRP
	FormAccCode.value		= GeoAccCode;
	FormLong.value		= GeoLng;
	FormLat.value		= GeoLat;
	
	CBE_RPloadMapCodeRP
        }
    }
}

function getValues( xmlDocument, strTagName )
{
	var xmlTags;
	if( strTagName )
		xmlTags =  xmlDocument.getElementsByTagName( strTagName );
	else
		xmlTags =  xmlDocument.childNodes;
		
	var intLen = xmlTags.length;
	if( !intLen )
		return null;
	else if( intLen == 1 )
	{
		return xmlTags[ 0 ].firstChild.nodeValue;
	}
	else
	{
		var arrValues = new Array( );
		for( var i = 0; i < intLen; i++ )
		{
			arrValues[ i ] = xmlTags[ i ].firstChild.nodeValue;
		}			
		return arrValues;
	}
}

function setMessageUsingInline(message) {
    mdiv = document.getElementById("GeoMessage");
    mdiv.innerHTML = message;
}

 function setMessageUsingDOM(message) {
     var userMessageElement = document.getElementById("GeoMessage");
     var messageText;
     if (message !="") {
         userMessageElement.style.color = "green";
         messageText = message;
     }
     var messageBody = document.createTextNode(messageText);
     // if the messageBody element has been created simple replace it otherwise
     // append the new element
     if (userMessageElement.childNodes[0]) {
         userMessageElement.replaceChild(messageBody, userMessageElement.childNodes[0]);
     } else {
         userMessageElement.appendChild(messageBody);
     }
 }

// --- Google Maps related starts here --- //

var map;
var icon0;

function addUnLoadEvent(func) { 
	var oldundonload = window.onunload;
	if (typeof window.onunload != 'function'){ 
		window.onunload = func
	} else { 
		window.onunload = function() {
			oldonunload();
			func();
		}
	}
}

function StartMap() {
	addUnLoadEvent(GUnload)
	loadMap(NewCenter);
	addPoints(newpoints);
}

function updPoints() {
	//addPoints(newpoints);
	doPointsPolyline(newpoints);
}

function showSavedPoint() {
	var FormLong	 = document.getElementById("GeoLng");
	var FormLat	 = document.getElementById("GeoLat");
	var ShowSavedLink	 = document.getElementById("check_Saved");
	newpoints[0] = new Array(FormLat.value, FormLong.value, icon0, 'Test', 'Your Address', 'nodrag');
	NewCenter[0] = new Array(FormLat.value, FormLong.value);
	cbe_allowMapClick_call = 0;
	StartMap();
	ShowSavedLink.innerHTML = "&nbsp";
	return true;
}

function loadMap(NewCenter) {
	if (GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("cbe_geo_map"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		if (NewCenter == '' ) {
			map.setCenter(new GLatLng( 51.960734, 7.627115), 12);
		} else {
			map.setCenter(new GLatLng(NewCenter[0][0], NewCenter[0][1]), 11);
		}
		// map.setMapType(G_MAP_TYPE);

		CBE_RPallowVisualRelocate1RP
 
		icon0 = new GIcon();
		icon0.image = "http://www.google.com/mapfiles/marker.png";
		icon0.shadow = "http://www.google.com/mapfiles/shadow50.png";
		icon0.iconSize = new GSize(20, 34);
		icon0.shadowSize = new GSize(37, 34);
		icon0.iconAnchor = new GPoint(9, 34);
		icon0.infoWindowAnchor = new GPoint(9, 2);
		icon0.infoShadowAnchor = new GPoint(18, 25);
	}
}

function GeoOnClick(overlay, point) {
	if (cbe_allowMapClick_call == 1) {
		document.getElementById("GeoLng").value = point.x;
		document.getElementById("GeoLat").value = point.y;
		map.clearOverlays()
		newpoints[0] = new Array(point.y, point.x, icon0, 'Test', '');
		//document.getElementById("GeoCoder_doUpdate").value = '1';
		addPoints(newpoints);
	}
};
 
function addPoints(newpoints) {
	for(var i = 0; i < newpoints.length; i++) {
		var point = new GPoint(newpoints[i][1],newpoints[i][0]);
		var popuphtml = newpoints[i][4] ;
		var cbedrag = newpoints[i][5];
		var marker = createMarker(point,newpoints[i][2],popuphtml,cbedrag);
		map.addOverlay(marker);
	}
}

function doPointsPolyline(newpoints) {
	var points_distance = cbe_points[0].distanceFrom(cbe_points[1]);
	var cbe_polyline = new GPolyline(cbe_points, "#FF0000", 10);
	var dis_place = document.getElementById("pdistance");
	map.addOverlay(cbe_polyline);
	dis_place.innerHTML = "_UE_CBE_JS_GEO_DISTANCE_BETWEE" + points_distance + "m";
}

 
function createMarker(point, icon, popuphtml, cbedrag) {
	var popuphtml = "<div id=\"popup\">" + popuphtml + "<\/div>";

	if ( cbedrag == 'nodrag' ) {
		var marker = new GMarker(point, icon);
		
	} else {
		var marker = new GMarker(point, {draggable: true});
		//GEvent.addListener(marker, "click", function() {
		//	marker.openInfoWindowHtml(popuphtml);
		//});
		
		GEvent.addListener(marker, "dragstart", function() {
			map.closeInfoWindow();
		});
         	
		GEvent.addListener(marker, "dragend", function(overlay, point) {
			var tpoint = marker.getPoint();
			
			var npoint_x = tpoint.lng();
			var npoint_y = tpoint.lat();
			document.getElementById("GeoLng").value = npoint_x;
			document.getElementById("GeoLat").value = npoint_y;;
  		});
  	}
	return marker;
}

//-->
</script>

EOT;

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


$js_cbe_geocoder_edit = str_replace('CBE_RP_GeoCode_byJS_RP', intval($enhanced_Config['geocoder_geocode_byJS']), $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('CBE_RPSitePathRP', JURI::root(), $js_cbe_geocoder_edit);

$js_cbe_geocoder_edit = str_replace('_UE_CBE_JS_GEO_DISTANCE_BETWEEN', _UE_CBE_JS_GEO_DISTANCE_BETWEEN, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_Q_OVERLOADBLOCK', _UE_CBE_GEOCODER_Q_OVERLOADBLOCK, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_Q_WORKING', _UE_CBE_GEOCODER_Q_WORKING, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_QSUCCESS', _UE_CBE_GEOCODER_E_QSUCCESS, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_QFAILURE', _UE_CBE_GEOCODER_E_QFAILURE, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_UNCHANCHED', _UE_CBE_GEOCODER_E_UNCHANCHED, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_ADDR', _UE_CBE_GEOCODER_E_ACC_ADDR, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_STREET', _UE_CBE_GEOCODER_E_ACC_STREET, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_ZIPPLZ', _UE_CBE_GEOCODER_E_ACC_ZIPPLZ, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_CITY', _UE_CBE_GEOCODER_E_ACC_CITY, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_SUBREGION', _UE_CBE_GEOCODER_E_ACC_SUBREGION, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_REGION', _UE_CBE_GEOCODER_E_ACC_REGION, $js_cbe_geocoder_edit);
$js_cbe_geocoder_edit = str_replace('_UE_CBE_GEOCODER_E_ACC_COUNTRY', _UE_CBE_GEOCODER_E_ACC_COUNTRY, $js_cbe_geocoder_edit);

// $user->user_id (if not includes as src-Call
$database = &JFactory::getDBO();
if (intval($my->id) != 0) {
	$uidhashrp = '&uidu='.$my->id;
	$database->setQuery("SELECT session_id FROM #__session WHERE userid='".intval($my->id)."'");
	$mysessionbase = $database->loadResult();
	$uidhashrp .= '&uidh='.md5($mysessionbase);
	$js_cbe_geocoder_edit = str_replace('CBE_RPUIDHASHRP', $uidhashrp , $js_cbe_geocoder_edit);
} else {
	$js_cbe_geocoder_edit = str_replace('CBE_RPUIDHASHRP', '' , $js_cbe_geocoder_edit);
}


// if ($enhanced_Config['geocoder_show_single_addrfield']== '1') {
	$js_cbe_geocoder_edit = str_replace('CBE_RPsingleAddressInput1RP', 'var t_value = target.value;', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPsingleAddressInput2RP', '', $js_cbe_geocoder_edit);
//} else {
//	$js_cbe_geocoder_edit = str_replace('CBE_RPsingleAddressInput1RP', 'var t_value = getAddress_cbegeo();', $js_cbe_geocoder_edit);
//	$js_cbe_geocoder_edit = str_replace('CBE_RPsingleAddressInput2RP', 'var target = getAddress_cbegeo("1");', $js_cbe_geocoder_edit);
//}

if ($enhanced_Config['geocoder_use_addrfield'] == '1') {
	$_js_fge = 0;
	$_js_fgq = "";
	if (!empty($enhanced_Config['geocoder_street_dbname'])) {
		$_js_fgq .= 'document.getElementsByName("'.$enhanced_Config['geocoder_street_dbname'].'")[0].value';
		$_js_fge++;

		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransStreet_RP','geo_street.value = _geo_street.value', $js_cbe_geocoder_edit);
	} else {
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransStreet_RP;','', $js_cbe_geocoder_edit);
	}
	if (!empty($enhanced_Config['geocoder_postcode_dbname'])) {
		if ($_js_fge > 0) { 
			$_js_fgq .= ' + " " + ';
		}
		$_js_fgq .= 'document.getElementsByName("'.$enhanced_Config['geocoder_postcode_dbname'].'")[0].value';
		$_js_fge++;

		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransPostcode_RP','geo_postcode.value = _geo_postcode.value', $js_cbe_geocoder_edit);
	} else {
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransPostcode_RP;','', $js_cbe_geocoder_edit);
	}
	if (!empty($enhanced_Config['geocoder_city_dbname'])) {
		if ($_js_fge > 0) { 
			$_js_fgq .= ' + " " + ';
		}
		$_js_fgq .= 'document.getElementsByName("'.$enhanced_Config['geocoder_city_dbname'].'")[0].value';
		$_js_fge++;

		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransCity_RP','geo_city.value = _geo_city.value', $js_cbe_geocoder_edit);
	} else {
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransCity_RP;','', $js_cbe_geocoder_edit);
	}
	if (!empty($enhanced_Config['geocoder_state_dbname'])) {
		if ($_js_fge > 0) { 
			$_js_fgq .= ' + " " + ';
		}
		$_js_fgq .= 'document.getElementsByName("'.$enhanced_Config['geocoder_state_dbname'].'")[0].value';
		$_js_fge++;
		
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransState_RP','geo_state.value = _geo_state.value', $js_cbe_geocoder_edit);
	} else {
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransState_RP;','', $js_cbe_geocoder_edit);
	}
	if (!empty($enhanced_Config['geocoder_country_dbname'])) {
		if ($_js_fge > 0) { 
			$_js_fgq .= ' + " " + ';
		}
		$_js_fgq .= 'document.getElementsByName("'.$enhanced_Config['geocoder_country_dbname'].'")[0].value';
		$_js_fge++;
		
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransCountry_RP','geo_country.value = _geo_country.value', $js_cbe_geocoder_edit);
	} else {
		$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransCountry_RP;','', $js_cbe_geocoder_edit);
	}
	if ($_js_fge > 0) { 
		$_js_fgq .= ' ';
		$_js_fge = 1;
	} else {
		$_js_fgq .= 'document.getElementById("GeoAddr").value ';
	}

	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsSumVarRP',$_js_fgq, $js_cbe_geocoder_edit);

	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarStreet_RP','var _geo_street	= document.getElementsByName("'.$enhanced_Config['geocoder_street_dbname'].'")[0]', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarPostcode_RP','var _geo_postcode	= document.getElementsByName("'.$enhanced_Config['geocoder_postcode_dbname'].'")[0]', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarCity_RP','var _geo_city	= document.getElementsByName("'.$enhanced_Config['geocoder_city_dbname'].'")[0]', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarState_RP','var _geo_state	= document.getElementsByName("'.$enhanced_Config['geocoder_state_dbname'].'")[0]', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarCountry_RP','var _geo_country	= document.getElementsByName("'.$enhanced_Config['geocoder_country_dbname'].'")[0]', $js_cbe_geocoder_edit);

} else {
	$_js_fgq = '';
	$_js_fgq = 'geoAddrField.value';
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsSumVarRP',$_js_fgq, $js_cbe_geocoder_edit);

	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransStreet_RP;','', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransPostcode_RP;','', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransCity_RP;','', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransState_RP;','', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarTransCountry_RP;','', $js_cbe_geocoder_edit);

	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarStreet_RP','var _geo_street', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarPostcode_RP','var _geo_postcode', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarCity_RP','var _geo_city', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarState_RP','var _geo_state', $js_cbe_geocoder_edit);
	$js_cbe_geocoder_edit = str_replace('CBE_RPtakeOverFieldsVarCountry_RP','var _geo_country', $js_cbe_geocoder_edit);

}

if ($enhanced_Config['geocoder_lock_addr_on_success'] == '1') {
	$js_cbe_geocoder_edit = str_replace('CBE_RPlockAddrFieldRP', 'AddrField_.readOnly = true;', $js_cbe_geocoder_edit);
} else {
	$js_cbe_geocoder_edit = str_replace('CBE_RPlockAddrFieldRP', '', $js_cbe_geocoder_edit);
}

if ($enhanced_Config['geocoder_allow_visualverify']=='1') {
	$js_cbe_geocoder_edit = str_replace('CBE_RPloadMapCodeRP', 'if (GeoStatusCode == "200") StartMap();', $js_cbe_geocoder_edit);
} else {
	$js_cbe_geocoder_edit = str_replace('CBE_RPloadMapCodeRP', '', $js_cbe_geocoder_edit);
}
if ($enhanced_Config['geocoder_show_acc']=='1') {
	$js_cbe_geocoder_edit = str_replace('CBE_RPshowAccRP', 'FormAcc.value = GeoAcc;', $js_cbe_geocoder_edit);
} else {
	$js_cbe_geocoder_edit = str_replace('CBE_RPshowAccRP', '', $js_cbe_geocoder_edit);
}
if ($enhanced_Config['geocoder_allow_visualrelocate']=='1' && $enhanced_Config['geocoder_allow_visualverify']=='1') {
	$js_cbe_geocoder_edit = str_replace('CBE_RPallowVisualRelocate2RP', '\'drag\'', $js_cbe_geocoder_edit);
} else {
	$js_cbe_geocoder_edit = str_replace('CBE_RPallowVisualRelocate2RP', '\'nodrag\'', $js_cbe_geocoder_edit);
}
if ($enhanced_Config['geocoder_allow_visualrelocate_onclick']=='1' && $enhanced_Config['geocoder_allow_visualverify']=='1') {
	$js_cbe_geocoder_edit = str_replace('CBE_RPallowVisualRelocate1RP', 'GEvent.bind(this.map, "click", this, GeoOnClick);', $js_cbe_geocoder_edit);
} else {
	$js_cbe_geocoder_edit = str_replace('CBE_RPallowVisualRelocate1RP', '', $js_cbe_geocoder_edit);
}
?>
<?php

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/* cbe.php include part, providing geocoder frontend map function */
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeGeoObj.php');

class cbeGeoMap extends moscbeGeoObj {
	// core definition of class starts in cbe.class.php

	function loadCoords($load_wide) {
		global $enhanced_Config;
		
		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();
		$scan = intval($load_wide);
		$limit = '';
		$scan_data = array();
		if ($scan != 0) {
			$limit = ' LIMIT '.$scan;
		}
		$q_user_perm = "";
		if ($enhanced_Config['geocoder_useragree_usage'] == '1') {
			$q_user_perm = "cg.GeoAllowShow = '1' AND ";
		}
		if ($enhanced_Config['geocoder_usermap_force_unsharp'] == '1') {
			$nrdigit = intval($enhanced_Config['geocoder_usermap_force_unsharp_digit']);
			$scan_query = "SELECT u.username, cg.uid, TRUNCATE(cg.GeoLat,".$nrdigit.") as GeoLat, TRUNCATE(cg.GeoLng,".$nrdigit.") as GeoLng, cg.GeoText, cg.GeoAllowShow, c.avatar, c.avatarapproved FROM #__cbe_geodata cg, #__cbe c, #__users u WHERE ".$q_user_perm."cg.uid=c.user_id AND cg.uid=u.id ORDER by cg.GeoLat,cg.GeoLng".$limit;
		} else {
			$scan_query = "SELECT u.username, cg.*, c.avatar, c.avatarapproved FROM #__cbe_geodata cg, #__cbe c, #__users u WHERE ".$q_user_perm."cg.uid=c.user_id AND cg.uid=u.id ORDER by cg.GeoLat,cg.GeoLng".$limit;
		}
		$database->setQuery($scan_query);
		$scan_data = $database->loadObjectList();
		//if (!$database->query()) {
		//	$scan_data[0] = 0;
		//}
		return $scan_data;
	}
	
	function writeXML($xml_target, $xml_out) {
		if (!is_writable($xml_target)) {
			$mosmsg = "XML target file not writeable.";
			// echo $mosmsg;
			return $mosmsg;
		} else {
			$xml_out_php  = "<?php\n";
			$xml_out_php .= " defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );\n";
			$xml_out_php .= "\$cbe_XML_Out = <<<EOT\n";
			$xml_out_php .= $xml_out;
			$xml_out_php .= "EOT;\n";
			$xml_out_php .= "?>";
			$fp = fopen("$xml_target", "w");
			fputs($fp, $xml_out_php, strlen($xml_out_php));
			fclose ($fp);
			return true;
		}
	}
	
	function readXML($xml_target) {
		if (!is_readable($xml_target)) {
			$mosmsg = "XML target file not readable.";
			// echo $mosmsg;
			return $mosmsg;
		}
		$fp = fopen($xml_target, "r");
		$xml_out = fread($fp, filesize($xml_target));
		fclose ($fp);
		$xml_array = array();
		$xml_array = explode("EOT", $xml_out);
		$xml_out = trim($xml_array[1]);
		unset($xml_array);
		return $xml_out;
	}
	
	function genXML($scan_wide,$serv,$cbe_xml_interval) {
		global $database,$mosConfig_absolute_path,$mosConfig_lang,$mosConfig_live_site;
		global $enhanced_Config,$ueConfig;

		$database = &JFactory::getDBO();
		// serv -> 0 exit, 1 genXML/write and return, 2 only genXML/write, 3 readXML/return, 4 auto with update-interval/return
		$serv = intval($serv);
		$cbe_xml_interval = intval($cbe_xml_interval);
		if ($serv > 4) {
			$mosmsg = "Wrong XML Call.";
			return $mosmsg;
		} elseif ($serv == 0) {
			return false;
		}
		$xml_target = JPATH_SITE."/components/com_cbe/enhanced/geocoder/cbe_usermap.xml.php";

		// check how old file is
		$lastModify = filemtime($xml_target);
		$currentTime = time();
		
		if ($serv == 4) {
			if ( ((($currentTime - $lastModify) / 60) <= $cbe_xml_interval) ) {
				$serv = 3;
			}
		}
		
		if ($serv != 3) {
			$Itemid_p = '';
			$database->setQuery("SELECT id FROM #__menu WHERE (link = 'index.php?option=com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' or published='0') AND access='0' ORDER BY id DESC Limit 1");
			$Itemid_p = $database->loadResult();
			if ( $Itemid_p != '' ) {
				$Itemid_p = "&Itemid=".$Itemid_p;
			}
			$profile_url = JPATH_SITE."/index.php?option=com_cbe".$Itemid_p."&task=userProfile&user=";
			if (file_exists(JPATH_SITE."/components/com_cbe/images/".$mosConfig_lang)) {
				$uimagepath="components/com_cbe/images/".$mosConfig_lang."/";
			} else {
				$uimagepath="components/com_cbe/images/english/";
			}

			$badString = array('&','<','>');
			$goodString = array('&amp;','&lt;','&gt;');

			$u_data = array();
			$u_data = cbeGeoMap::loadCoords($scan_wide);

			$xml_out = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n<items>\n";

			$u_data_count = 0;
			$do_back_ins = 0;
			foreach ($u_data as $u_dat) {
				$u_data[$u_data_count]->InfoCount = 0;
				$u_data[$u_data_count]->InfoPrev = 0;

				//if ($enhanced_Config['geocoder_usermap_force_unsharp'] == '1') {
				//	$nrdigit = intval($enhanced_Config['geocoder_usermap_force_unsharp_digit']);
				//	$u_dat->GeoLat = number_format($u_dat->GeoLat, $nrdigit, '.', '');
				//	$u_dat->GeoLng = number_format($u_dat->GeoLng, $nrdigit, '.', '');
				//}
				
				$uimage=$u_dat->avatar;
				if ($u_dat->avatarapproved==0) {
					$uimage=$uimagepath."tnpendphoto.jpg";
				} elseif ($u_dat->avatar=='' || $u_dat->avatar==null) {
					$uimage=$uimagepath."tnnophoto.jpg";
				} else {
					if (!preg_match('/(gallery)/',$u_dat->avatar)) {
						$uimage=JURI::root()."images/cbe/tn".$uimage;
						//$uimage="/images/cbe/tn".$uimage;
					} else {
						$uimage=JURI::root()."images/cbe/".$uimage;
						//$uimage="/images/cbe/".$uimage;
					}
				}
				$div_height = intval($ueConfig['thumbHeight']) + 10;
				$div_width = intval($ueConfig['thumbWidth']) + 25;
				$html_dat  = "<div style=\"width: ".$div_width."px; height: ".$div_height."px\"><a href=\"".$profile_url.$u_dat->uid."\">";
				$html_dat .= "<img src=\"".$uimage."\" /></a><br />";
				$html_dat .= "<a href=\"".$profile_url.$u_dat->uid."\">";
				$html_dat .= $u_dat->username."</a><br /><br /></div>";
				$u_dat->GeoText = str_replace($badString, $goodString, $html_dat);
				$u_info_xml = "info0='".$u_dat->GeoText;
				
				$poi_start = "\t<poi "; $poi_start1 = "' />\n\t<poi "; $poi_end = "' />\n"; $poi_end1 = "";
				if ($u_data_count > 0) {
					$u_data_prev = $u_data_count - 1;
					if ($u_data[$u_data_prev]->GeoLat == $u_dat->GeoLat && $u_data[$u_data_prev]->GeoLng == $u_dat->GeoLng) {
						// $u_info_add_xml
						$w_check = 1;
						while ( $w_check != 0 ) {
							if ($u_data[$u_data_prev]->InfoPrev > 0) {
								$u_data_prev = $u_data_prev - $u_data[$u_data_prev]->InfoPrev;
							} else {
								$w_check = 0;
							}
						}
						$xml_out .= "' info".$u_data[$u_data_prev]->InfoCount."='".$u_dat->GeoText;
						$u_data[$u_data_prev]->InfoCount = intval($u_data[$u_data_prev]->InfoCount) + 1;
						$u_data[$u_data_count]->InfoPrev = 1;
						$u_data[$u_data_count]->InfoCount = $u_data[$u_data_prev]->InfoCount;
					} else {
						$xml_out .= "' InfoCount='".$u_data[$u_data_prev]->InfoCount;
						$poi_start = $poi_start1;
						$poi_end = $poi_end1;
						$xml_out .= $poi_start."lat='".$u_dat->GeoLat."' lng='".$u_dat->GeoLng."' uid='".$u_dat->uid."' username='".$u_dat->username."' ".$u_info_xml.$poi_end;
						$u_data[$u_data_count]->InfoCount = 1;
					}
				} else {
					//$u_info_xml .= " InfoCount='".$u_data[$u_data_count]->InfoCount;
					$poi_end = $poi_end1;
					$xml_out .= $poi_start."lat='".$u_dat->GeoLat."' lng='".$u_dat->GeoLng."' uid='".$u_dat->uid."' username='".$u_dat->username."' ".$u_info_xml.$poi_end;
					$u_data[$u_data_count]->InfoCount = 1;
				}
				
				$u_data_count++;
			}
			if ($u_data_count > 1) {
				if ($u_data[$u_data_count-1]->InfoCount >= 1) {
					$xml_out .= "' InfoCount='".$u_data[$u_data_count-1]->InfoCount;
				}
				$xml_out .= "' />\n";
			} else {
				$xml_out .= "' InfoCount='".$u_data[$u_data_count-1]->InfoCount."' />\n";
			}
			$xml_out .= "</items>\n";

			$wreturn = cbeGeoMap::writeXML($xml_target, $xml_out);
			if ($wreturn !== true && $serv == 2) {
				$ret_msg = "XML target file not writeable.";
				return $ret_msg;
			}
		} else {
			$xml_out = cbeGeoMap::readXML($xml_target);
			$read_check = strpos($xml_out, "?xml");
			if ($read_check === false && $serv == 2) {
				$ret_msg = "XML target file not readable.";
				return $ret_msg;
			}
		}
		
		if ($serv != 2) {
			return $xml_out;
		}
		return true;
	}

} //end class

class HTML_cbeUsermap {
	// frontend map generator
	
	function show_usermap() {
		global $enhanced_Config, $ueConfig, $my, $database, $mainframe, $Itemid_com;
		global $mosConfig_live_site;
		
		$cbe_UserMap_output = "";
		$cbe_UserMap_output .= "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=".$enhanced_Config['geocoder_google_apikey']."\" type=\"text/javascript\"></script>"."\n\n";
		
		$js_cbe_UserMap = "";
		if (file_exists('components/com_cbe/enhanced/geocoder/_js_geocoder_usermap.php')) {
			//include('components/com_cbe/enhanced/geocoder/_js_geocoder_usermap.php');
			//$cbe_UserMap_output .= $js_cbe_UserMap."\n\n";
			$cbe_UserMap_output .= "\n<script type=\"text/javascript\" src=\"".JURI::root()."index2.php?option=com_cbe".$Itemid_com."&format=raw&task=callthrough&scrp=cbe_gcm\"></script>\n";
		}
		$cbe_UserMap_output .= "\n\n";
		$cbe_UserMap_output .= "<style type=\"text/css\">\n";
		$cbe_UserMap_output .= "div#popup {\n";
		$cbe_UserMap_output .= "\tbackground:#EFEFEF;\n";
		$cbe_UserMap_output .= "\tborder:1px solid #999999;\n";
		$cbe_UserMap_output .= "\tmargin:0px;\n";
		$cbe_UserMap_output .= "\tpadding:7px;\n";
		$cbe_UserMap_output .= "\twidth:270px;\n";
		$cbe_UserMap_output .= "}\n";
		$cbe_UserMap_output .= "v\:* { \n";
		$cbe_UserMap_output .= "\tbehavior:url(#default#VML); \n";
		$cbe_UserMap_output .= "}\n";
		$cbe_UserMap_output .= "</style>\n";

		$cbe_UserMap_output .= "\n<div style=\"text-align: center\">\n";
		if ($enhanced_Config['geocoder_usermap_showsearch'] == '1') {
			$cbe_UserMap_output .= "\n<form onsubmit=\"cbe_showAddress(this.address.value); return false\">\n";
			$cbe_UserMap_output .= "<p>\n<input type=\"text\" size=\"45\" name=\"address\" value=\"\" />\n";
			$cbe_UserMap_output .= "<input type=\"submit\" value=\"Center\" />\n</p>\n";
			$cbe_UserMap_output .= "</form>\n";
		}

		$map_height = $enhanced_Config['geocoder_usermap_height'];
		$map_width = $enhanced_Config['geocoder_usermap_width'];
		$cbe_UserMap_output .= "\n<div>\n<div id=\"cbe_user_map\" style=\"width:".$map_width."; height:".$map_height."\"></div> \n</div>\n";
		$cbe_UserMap_output .= "\n</div>\n";

		echo $cbe_UserMap_output;
	}
	
} //end class

?>

<?php
/**
* @version		1.5j
* @copyright		Copyright (C) 2007-2009 Stephen Brandon
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementGeoipcheck extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Geoipcheck';

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mosConfig_absolute_path;
		$files = $this->geoIPFolders();
		$foundcountry = $foundlitecity = $foundcity = false;
		$messages = array();
		
		foreach ($files as $file) {
			$proposed_file = JPATH_SITE.DS.$file.'GeoIP.dat';
			$country = is_file($proposed_file) && is_readable($proposed_file);
			$proposed_file = JPATH_SITE.DS.$file.'GeoLiteCity.dat';
			$litecity = is_file($proposed_file) && is_readable($proposed_file);
			$proposed_file = JPATH_SITE.DS.$file.'GeoIPCity.dat';
			$city = is_file($proposed_file) && is_readable($proposed_file);
			
			if ($country && !$foundcountry) {
				$age = intval((time() - filemtime(JPATH_SITE.DS.$file.'GeoIP.dat'))/(24*60*60));
				if ($age > 30) $age = "<span style='color:red;'>File is $age days old. Please update your database from <a href='http://www.maxmind.com/app/ip-location' target='_blank'>MaxMind</a>.</span>";
				else $age = "";
				$messages[] = $file."GeoIP.dat found. GeoIP Country features enabled. $age";
				$foundcountry = true;
			}
			if ($litecity && !$foundlitecity) {
				$age = intval((time() - filemtime(JPATH_SITE.DS.$file.'GeoLiteCity.dat'))/(24*60*60));
				if ($age > 30) $age = "<span style='color:red;'>File is $age days old. Please update your database from <a href='http://www.maxmind.com/app/ip-location' target='_blank'>MaxMind</a>.</span>";
				else $age = "";
				$messages[] = $file."GeoLiteCity.dat found. GeoIP City/region features enabled. $age";
				$foundlitecity = true;
			}
			if ($city && !$foundcity) {
				$age = intval((time() - filemtime(JPATH_SITE.DS.$file.'GeoIPCity.dat'))/(24*60*60));
				if ($age > 30) $age = "<span style='color:red;'>File is $age days old. Please update your database from <a href='http://www.maxmind.com/app/ip-location' target='_blank'>MaxMind</a>.</span>";
				else $age = "";
				$messages[] = $file."GeoIPCity.dat found. GeoIP City/region features enabled. $age";
				$foundcity = true;
			}
			
		}
		if ($foundcountry || $foundlitecity || $foundcity) {
			return "<b>".implode("<br/>",$messages).'</b>
			<br />Keep your GeoIP databases up to date from
			<a href="http://www.maxmind.com/app/ip-location" target="_blank">MaxMind</a>';
		}
		return '<b>I couldn\'t find any GeoIP database at <i>jooma_root</i>/geoip/GeoIP.dat, <i>jooma_root</i>/geoip/GeoFreeCity.dat or <i>jooma_root</i>/geoip/GeoIPCity.dat.</b><br />
			If you want to use the GeoIP Country features, please obtain the GeoLite Country or GeoIP Country database
			at <a href="http://www.maxmind.com/app/geolitecountry" target="_blank">MaxMind</a>
			(<a href="http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz">direct download</a>),
			uncompress it, and copy it to <i>jooma_root</i>/geoip/GeoIP.dat in your server file system. For full City and 
			location features, please obtain the GeoLite City or GeoIP City database
			at <a href="http://www.maxmind.com/app/geolitecity" target="_blank">MaxMind</a>
			(<a href="http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz">direct download</a>),
			uncompress it, and copy it to <i>jooma_root</i>/geoip/GeoLiteCity.dat in your file system.';
	}
	
	function geoIPFolders() {
		return array(
			"geoip".DS,
			"GeoIP".DS,
			"geoIP".DS,
			"GEOIP".DS,
			"GEO IP".DS,
			"",
			"geo_ip".DS,
			"geo_IP".DS,
			"Geo_IP".DS
			);
		
	}
	
}
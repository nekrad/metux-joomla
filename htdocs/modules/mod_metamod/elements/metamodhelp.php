<?php
/**
* @version		1.5j
* @copyright		Copyright (C) 2007-2009 Stephen Brandon
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementMetamodhelp extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Metamodhelp';

	function fetchElement($name, $value, &$node, $control_name)
	{
				return 'Create some PHP code to determine which module should be used. Once the script has decided which module or modules to display, return the module id, a comma-separated list of module ids as a string, or an array of module ids. For more help and recipes, see the <a href="http://www.brandonitconsulting.co.uk/mod_metamod/" target="_blank">MetaMod home page</a>. e.g.
<pre>
if ( MM_NOT_LOGGED_IN ) return 65;
if ( MM_LOGGED_IN ) return 66;
if ( MM_DAY_OF_WEEK == 1 )
     return 67; // Monday = "1"
if ( MM_DAY_OF_MONTH == 1 )
     return 68; // only show on 1st day of every month
if ( MM_MONTH == 5 )
     return 69; // only show during month of May
if ( MM_YEAR == 2010 )
     return 70; // only show during year 2010
if ( MM_HOUR >= 9 && MM_HOUR < 17 )
     return 71; // 9AM-4:59:59PM daily
if ( MM_TIME >= 93010 && MM_TIME <= 171500)
     return 72; // 09:30:10 to 17:15:00 daily
if ( MM_DATE >= 20090101 && MM_DATE <= 20090723)
     return 73; // 1 Jan 2009 to 23 July 2009

if ( $fromCountryId == "US" ) return 55;
if ( $fromCountryId == "GB" ) return "55,56,57";
if ( $fromCountryId == "NL" ) return array(58,59,73);
if ( $fromCountryName == "New Zealand" ) return 21;</pre>
		<p>You have access to the following PHP variables:
			<ul><li><b>$fromCountryId</b> - the upper-case 2-letter ISO country code (e.g. GB, US, FR, DE)</li>
			<li><b>$fromCountryName</b> - the official ISO country name</li>
			<li><b>$geoip</b> - if you have enabled GeoLiteCity or GeoIPCity, a record containing the following items:</li>
			<ul>
			<li><b>$geoip-&gt;country_name</b> - full country name, as above</li>
			<li><b>$geoip-&gt;country_code</b> - 2-letter ISO country code, as above</li>
			<li><b>$geoip-&gt;country_code3</b> - 3-letter ISO country code (e.g. GBR, USA, FRA, DEU)</li>
			<li><b>$geoip-&gt;region</b> - 2-letter code. For US/Canada, <a href="http://www.maxmind.com/app/iso3166_2" target="_blank">ISO-3166-2</a> code for the state/province name, e.g. "GA" (Georgia, USA). Outside of the US and Canada, <a href="http://www.maxmind.com/app/fips10_4" target="_blank">FIPS 10-4</a> code., e.g. "M9" (Staffordshire, UK)</li>
			<li><b>$geoip-&gt;city</b> - full city name</li>
			<li><b>$geoip-&gt;postal_code</b> - For US, Zipcodes, for Canada, postal codes. Available for about 56% of US GeoIP Records. <a href="http://www.maxmind.com/app/faq#postalcode" target="_blank">More info</a>.</li>
			<li><b>$geoip-&gt;latitude</b></li>
			<li><b>$geoip-&gt;longitude</b></li>
			<li><b>$geoip-&gt;dma_code</b> - 3-digit <a href="http://code.google.com/apis/adwords/docs/developer/adwords_api_us_metros.html" target="_blank">DMA/Metro code</a> (US only)</li>
			<li><b>$geoip-&gt;area_code</b> - 3-digit telephone prefix (US Only)</li>
			</ul>
			<li><b>$Itemid</b> - the Itemid of the main component on the page</li>
			<li><b>$option</b> - the option of the main component on the page (e.g. com_content)</li>
			<li><b>$view</b> - the view of the main component on the page (e.g. "article")</li>
			<li><b>$id</b> - the id of the item in the main component on the page (e.g. "24:content-layouts")</li>
			<li><b>$db</b> - in case you want to query the database for anything (for experts!)</li>
			<li><b>$language</b> - a lower-case language code. By default this returns the default language of the web visitor&rsquo;s browser, but can alternatively return the language code of the Joomla front-end, or intelligently find the best match between a user&rsquo;s browser languages and a list of languages that you provide. Typical language strings returned include: en, en-gb, en-us, fr, de and <a href="http://www.brandonitconsulting.co.uk/mod_metamod/language-codes/">many others</a>.</li>
			<li><b>$language_code</b> - the 2-letter language code without region (lower case) e.g. "en"</li>
			<li><b>$language_region</b> - if it exists, the 2-letter region code (lower case). e.g. if $language == "en-us", $language_code == "en" and $language_region == "us". Having them in separate variables like this makes it easier to put into MetaMod rules.</li>
			<li><b>$user</b> - information about the user, if they are logged in.... </li>
			<ul>
			<li><b>$user-&gt;id</b></li>
			<li><b>$user-&gt;name</b></li>
			<li><b>$user-&gt;username</b></li>
			<li><b>$user-&gt;email</b></li>
			<li><b>$user-&gt;usertype</b>, e.g. "" or "Public Frontend"=not logged in (test for both), otherwise "Registered", "Author", "Editor", "Publisher", "Manager", "Administrator" or "Super Administrator"</li>
			<li><b>$user-&gt;registerDate</b> e.g. &quot;2007-05-17
	              01:25:52&quot;</li>
			<li><b>$user-&gt;lastvisitDate</b> e.g. &quot;2007-11-02
		              18:51:29&quot;</li>
			</ul>
			
			</ul>
			</p>
			<p>
			<b>Note:</b> <b>$fromCountryName</b> and <b>$fromCountryId</b> will only be available if 
			you have one of the "Enable GeoIP" options selected above, and if you have one of the 
			GeoLite Country, GeoIP Country, GeoLiteCity or GeoIPCity databases installed 
			(see <a href="http://www.maxmind.com/app/geolitecountry" target="_blank">Maxmind</a>, 
			<a href="http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz">direct GeoLite Country download</a>, 
			or <a href="http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz">direct GeoLite City download</a>)
			</p>
			</p>';
	}
}
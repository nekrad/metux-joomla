<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

// zodiac class
// Class 'astro' v1.0 - Calculate the chaldean and chinese signs of a given date.
// (c) Paris. 06 oct 2005. Pierre FAUQUE, pierre@fauque.net
class astro {

//	var $chaldeanZodiac = array("aries","taurus","gemini","cancer","leo","virgo","libra",
//	                            "scorpio","sagittarius","capricorn","aquarius","pisces");
//	var $chineseZodiac  = array("monkey","rooster","dog","pig","rat","ox","tiger",
//                                    "rabbit","dragon","serpent","horse","goat");
                                    

	var $chaldeanZodiac = array('_UE_A_ARIES','_UE_A_TAURUS','_UE_A_GEMINI','_UE_A_CANCER','_UE_A_LEO','_UE_A_VIRGO','_UE_A_LIBRA',
				    '_UE_A_SCORPIO','_UE_A_SAGITTARIUS','_UE_A_CAPRICORN','_UE_A_AQUARIUS','_UE_A_PISCES');
	var $chineseZodiac  = array('_UE_AC_MONKEY','_UE_AC_ROOSTER','_UE_AC_DOG','_UE_AC_PIG','_UE_AC_RAT','_UE_AC_OX','_UE_AC_TIGER',
				    '_UE_AC_RABBIT','_UE_AC_DRAGON','_UE_AC_SERPENT','_UE_AC_HORSE','_UE_AC_GOAT');


	var $chaldeanSign   	= "";
	var $chaldeanSignStatic	= "";
	var $chineseSign		= "";

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Format date : AAAA-MM-JJ. (format not tested)
	function __construct($date) {
		$this->astro($date);
	}

	function astro($date) {
		$idcha = $this->chaldeanSign($date);
		$idchi = $this->chineseSign($date);
		$zod_sta = $this->get_zodiac_static($date);
		$this->chaldeanSign 	= $this->chaldeanZodiac[$idcha];
		$this->chaldeanSignStatic	= $this->chaldeanZodiac[$zod_sta];
		$this->chineseSign  	= $this->chineseZodiac[$idchi];
	}

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Return an index for the given date in the chinese zodiac array.
	function chineseSign($date) { 
		$td = explode("-",$date); 
		$return = $td[0] % 12;
		if ((int)$td[1] == 1 && (int)$td[2] <= 23) {
			$return = $return - 1;
		} 
		return $return;
	}

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Calculate the sun position.
	// Return an index for the given date in the chaldean zodiac array.
	function rev($x) { return $x-floor($x/360.0)*360.0; }
	function chaldeanSign($date) {
		$t = explode("-",$date);
		$d = (367*$t[0]-floor((7*($t[0]+floor(($t[1]+9)/12)))/4)
		     +floor((275*$t[1])/9)+$t[2]-730530);
		$w = $this->rev(282.9404+4.70935E-5*$d); $M=$this->rev(356.0470+0.9856002585*$d);
		return floor($this->rev($w+$M)/30.0);
	}

	function get_zodiac_static($date) {
		list($z_year, $z_month, $z_day) = explode("-", $date);
		
		//$zodiac = array('Steinbock','Steinbock','Wassermann','Fische','Widder', 'Stier',
		//'Zwilling','Krebs','L�we','Jungfrau','Waage','Skorpion','Sch�tze');
		$dates = array(	0 => array(mktime(0,0,0,3,21), mktime(0,0,0,4,19)),
				1 => array(mktime(0,0,0,4,20), mktime(0,0,0,5,20)),
				2 => array(mktime(0,0,0,5,21), mktime(0,0,0,6,21)),
				3 => array(mktime(0,0,0,6,22), mktime(0,0,0,7,22)),
				4 => array(mktime(0,0,0,7,23), mktime(0,0,0,8,22)),
				5 => array(mktime(0,0,0,8,23), mktime(0,0,0,9,22)),
				6 => array(mktime(0,0,0,9,23), mktime(0,0,0,10,23)),
				7 => array(mktime(0,0,0,10,24), mktime(0,0,0,11,21)),
				8 => array(mktime(0,0,0,11,22), mktime(0,0,0,12,21)),
				9 => array(mktime(0,0,0,12,22), mktime(0,0,0,12,31)),
				10 => array(mktime(0,0,0,1,20), mktime(0,0,0,2,18)),
				11 => array(mktime(0,0,0,2,19), mktime(0,0,0,3,20)),
				12 => array(mktime(0,0,0,1,01), mktime(0,0,0,1,19)));
				// 9 equal 0 in old array, 12 equal 1 in old array
		foreach($dates as $k=>$v) {
     			if(mktime(0,0,0,$z_month,$z_day) >= $v[0] && mktime(0,0,0,$z_month,$z_day) <= $v[1]) {
     				if ($k == 12) {
     					$kk = 9;
     					return intval($kk);
     				}
				return intval($k);
     			}
    		}
    		return false;
    	} // function End
} // class end
?>
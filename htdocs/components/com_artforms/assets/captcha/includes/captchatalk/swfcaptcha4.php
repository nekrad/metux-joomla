<?php
/********************************************************************************
* @ CAPTCHA-TALK
* @ A Ming based Animated Talking Captcha PHP4 Class
* @ with optional DNSBL ( IP blacklist) check
* @ swfcaptcha class - scripts.titude.nl -(c) 2007
* @ A Ming based Animated and Talking SFW based Captcha class
* @ Requires: PHP5 with Ming
* @ License - Disclaimer at the bottom
* @ Version Build: 15-04-2007
* @
* @ 16-04 Update for valid x-html output for the swf ( No embed tag anymore )
********************************************************************************/
// error_reporting(E_ALL);
class swfcaptcha {
/********************************************************************************
*  swfcaptcha class user options
********************************************************************************/
		// Default colors for characters
	var $colors = array('EE0000','00EE00','0000EE','00EEEE','EEEE00','EE00EE');

		// Default background color
	var $bgcolors = array('000000');

		// Swf movie width and height
	var $swf_width = 210;
	var $swf_height = 75;

		// Offset for char movie in main swf movie
	var $swf_x = 10;
	var $swf_y = 50;

		// Scale char movie in main movie
	var $x_scale = 5;
	var $y_scale = 5;

		// Space between chars in char movie
	var $font_width = 30;

		// Thickness of font lines in char movie
	var $font_line = 65;

		// Captcha char lenght
	var $captcha_length = "";

		// Time settings for animation: draw - still display and rotate
	var $drawtime = 70;
	var $stilltime = 3000;
	var $rotatetime = 150;

		// different animation type = 0, 1, 2, 3
	var $animation = 3;
		// animation scale to ( from zero to scale )
	var $animateoffset = 0;
		// y float, 0 = off ( value is random y axis movement )
	var $animatefloat = 5;

		// Default fonts to use - empty is read all .fdb fonts from font dir
		// Note: only .fdb fonts
	var $font = array();
	var $fontdir = "";
		// Free bitstream vera fdb fonts - http://ming.sourceforge.net/

		// Default Ming captcha url for output in html code
	var $swf_url = "";
		// Html code with swf transparency
	var $swf_transparent = false;
	var $swf_validxhtml = true;

		// form input catpcha value name
	var $post_captcha = "captcha";
		// captcha session name
	var $session_captcha = "captcha";
	
		// Default background image ( optional )
		// jpg - png or gif ( NB this Ming function is buggy with jpg's )
		// $bgimages empty and $bgimgauto true is autoscan dir for images
	var $bgimages = array();
	var $bgimgauto = false;
		// Default dir to background images
	var $imagesdir = "";

		// Enable talking catcha
		// Captcha code will always be set in lowercase on true
	var $talking = "";
		// Default dir to sounds 
	var $sounddir = "";
		// Language folder user defined (  country code lowercase )
	var $soundlang = "";

		// Movie frame rate
	var $framerate = 12;
		// Frames for dound duration - depends on framerate
		// Experiment with values for correct sound duration
	var $soundframes = 20;
		// Sample sounds 22 kc mono - 24kb/s mp3
	
		// for more dnsbl lists and info see http://www.moensted.dk/spam/
		// http://www.sdsc.edu/~jeff/spam/cbc.html - http://www.declude.com/Articles.asp?ID=97
	var $dnsblists = array('zen.spamhaus.org','bl.spamcop.net','list.dsbl.org','tor.ahbl.org','opm.tornevall.org');
		// use DNSBL check if dnsblist is not empty and usednsbl = true
	var $usednsbl = false;
	var $session_dnsbl = "dnsbl";
		// On DNSBL listed - generate an error background ( NOTE: from sound dir )
	var $forbidden_img = "../../images/forbidden.png";
		// On DNSBL listed - generate an error sound ( from sound dir )
	var $forbidden_sound = "../../audio/forbidden.mp3";

		// Internal vars
	var $bgcolor = "";
	var $captchaval = "";
	var $soundlangdefault = "english";
	
/********************************************************************************
* @ function swfcaptcha()
* @ init class
********************************************************************************/
	function swfcaptcha() {
		if (!session_id()) { 
			@session_start(); 
		}	
	}
	
/********************************************************************************
* @ function swfmovie()
* @ output the swf captcha movie
********************************************************************************/
	function swfmovie() {
		// A little delay - can prevents quick reload hickups
		// sleep(1);
		// Create movie and properties
		ming_useswfversion(5);
		$movie = new SWFMovie();
		$movie->setRate($this->framerate);
		$movie->setDimension($this->swf_width, $this->swf_height);
		shuffle($this->bgcolors);
		$bgcol = $this->deccolors($this->bgcolors[0]);
		$this->bgcolor = "#" . $bgcol[0] . $bgcol[1] . $bgcol[2];
		$movie->setBackground($bgcol[0], $bgcol[1], $bgcol[2]);	

		// Captcha characters
		$captchars = "abcdefghijklmnopqrstuvwxyz";
		$captchars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$captchars .= "0123456789";

		// $asscript var contains main as script animation code
		$asscript = "fontshapes = new Array(); captchalen = " . $this->captcha_length . "; ";
		$asscript .= "animation = " . $this->animation . "; anioffset = " . $this->animateoffset . ";";
		// Set ( random ) font and Get font outlines
		if (substr($this->fontdir, -1 ) == '/') {
			$this->fontdir = substr($this->fontdir, 0, -1);
		}
		$fontset = array();
		// Empty font -> read dir auto for .fdb fonts
		if (empty($this->font)) {
			$this->font = glob($this->fontdir . "/*.fdb");
			// Create multiple font objects
			for ($i = 0; $i < count($this->font); $i++)  {
				$cfont = $this->font[$i];
				$fontset[$i] = new SWFFont($cfont); 
			}
		} else {
			// Create multiple font objects
			for ($i = 0; $i < count($this->font); $i++)  {
				$cfont = $this->fontdir . "/" . $this->font[$i];
				$fontset[$i] = new SWFFont($cfont);
			} 
		}
		$fontshapes = array();
		// Get outline per character
		for ($i = 0; $i < $this->captcha_length; $i++) {
			shuffle($fontset);
			$this->captchaval .= $captchars[rand(1, strlen($captchars))];
			$fontshape = $fontset[0]->getShape(ord($this->captchaval[$i])); 
			$fontshape = str_replace("\n", ":", $fontshape);
			$fontshape = str_replace("to ", "to:", $fontshape);
			$fontshape = str_replace(" ", ",", $fontshape);
			$fontshapes[$i] = $fontshape;
			$asscript .= " fontshapes[" . $i . "] = \"" . $fontshapes[$i] . "\"; ";
		}
		// Talking catcha code always in lowercase
		if ($this->talking === true) {
			$this->captchaval = strtolower($this->captchaval);
		}
		$_SESSION[$this->session_captcha] = $this->captchaval;
		if (substr($this->imagesdir, -1 ) == '/') {
			$this->imagesdir = substr($this->imagesdir, 0, -1);
		}
		// Reset all Captcha on DNSBL forbidden
		if ($this->usednsbl === true && isset($_SESSION[$this->session_dnsbl])) {
			if ($_SESSION[$this->session_dnsbl] != "oke") {
				$this->bgimages = array($this->forbidden_img);
				if (substr($this->sounddir, -1 ) == '/') {
					$this->imagesdir = substr($this->sounddir, 0, -1);
				} else {
					$this->imagesdir = $this->sounddir;
				}
				$asscript = "fontshapes = new Array(); captchalen =0; ";
				$asscript .= "animation = 0; anioffset = " . $this->animateoffset . ";";
				if (isset($_SESSION[$this->session_captcha])) {
					unset($_SESSION[$this->session_captcha]);
				}
			}
		}
		if ($this->bgimgauto === true && empty($this->bgimages)) {
			// Add a bg image auto - NOTE jpg are buggy in this Ming function
			$this->bgimages = glob($this->imagesdir . "/" . "{*.gif,*.jpg,*.png}", GLOB_BRACE);
			if (!empty($this->bgimages)) {
				shuffle($this->bgimages);
				$img = $this->bgimages[0];
				if (file_exists($img)) {
					$bgimg = new SWFBitmap(fopen($img,"rb")); 
					$movie->add($bgimg);
				}
			}
		} else {
			// Add a bg image - optional - NOTE jpg are buggy in this Ming function
			if (!empty($this->bgimages)) {
				shuffle($this->bgimages);
				$img = $this->imagesdir . "/" . $this->bgimages[0];
				if (file_exists($img)) {
					$bgimg = new SWFBitmap(fopen($img,"rb")); 
					$movie->add($bgimg);
				}
			}
		}
		$asscript .= "
		fontparts = new Array();
		for (i = 0; i < fontshapes.length; i++) {
			fontparts[i] = fontshapes[i].split(':');
		}
		for (i = 0; i < captchalen; i++) {
			mcname = 'mc'+ (i + 1);
			this.createEmptyMovieClip(mcname, (i + 1));
			mc = eval(mcname);
			mc._x = " . $this->swf_x . " + " . $this->font_width . " * i; 
			mc._y = " . $this->swf_y . "; 
			mc._xscale = " . $this->x_scale . "; 
			mc._yscale = " . $this->y_scale . ";
		}
		tmpp = 0; 
		curn = 0;
		curr = 0;
		intval = new Object();
		intvalreset = new Object();
		intvalrotate = new Object();
		randomcolors = new Array(" . $this->randomcolors() . ");
		randnum = Math.floor(Math.random()*randomcolors.length);
		fontdraw = function() {
			var fntprts = fontparts[curn];
			if (tmpp >= fntprts.length){ 
				curn = (++curn%fontshapes.length);
				curr++;
				tmpp = 0;	
				randnum = Math.floor(Math.random()*randomcolors.length);	
			} else {
				mcname = 'mc'+ (curn + 1);
				mc = eval(mcname);
				mc.lineStyle(" . $this->font_line . ", randomcolors[randnum], 100);
				var cord = fntprts[tmpp + 1].split(',');
				if (fntprts[tmpp] == 'curveto') {
					mc[fntprts[tmpp]](cord[0], cord[1], cord[2], cord[3]);
				} else {
					mc[fntprts[tmpp]](cord[0], cord[1]); 
				}
				tmpp += 2;
			}
			if (curr >= captchalen) {
				clearInterval(intval);
				clearInterval(intvalrotate);
				intvalrotate = setInterval(fontrotate, " . $this->rotatetime . ", 'r');
				for (m = 0; m < captchalen; m++) {
					mcname = 'mc'+ (m + 1);
					mc = eval(mcname);
				}
				intvalreset = setInterval(fontdrawreset, " . $this->stilltime . ");
			}
		};
		fontdrawreset = function() {
		// Reset captcha animation
			for (m = 0; m < captchalen; m++) {
				mcname = 'mc'+ (m + 1);
				mc = eval(mcname);
				mc.clear();
				mc._xscale = " . $this->x_scale . ";
				mc._yscale = " . $this->y_scale . ";
				mc._x = " . $this->swf_x . " + " . $this->font_width . " * m; 
				mc._y = " . $this->swf_y . "; 
				tmpp = 0; 
				curn = 0;
				curr = 0;
			}
			clearInterval(intvalreset);
			intval = setInterval(fontdraw, " . $this->drawtime . ");
			clearInterval(intvalrotate);
			intvalrotate = setInterval(fontrotate, " . $this->rotatetime . ", 'l');
		};
		fontrotate = function(direction) {
			// Defines type of animation
			for (m = 0; m < curr; m++) {
				mcname = 'mc'+ (m + 1);
				mcr = eval(mcname);
				if (animation == 1 || animation == 3) {
					if (mcr._xscale > anioffset && direction == 'l') {
						mcr._xscale--;
					} else if (mcr._xscale < " . $this->x_scale . " && direction == 'r') {
						mcr._xscale++;
					}
				}
				if (animation == 2 || animation == 3) {
					if (mcr._yscale > anioffset && direction == 'l') {
						mcr._yscale--;
					} else if (mcr._yscale < " . $this->y_scale . " && direction == 'r') {
						mcr._yscale++;
					}
				}
				if (" . $this->animatefloat . " != 0) {
					yfloat = Math.floor(Math.random()*" . $this->animatefloat . ");
					mcr._y = yfloat + " . $this->swf_y . ";
				}
			}
		};
		intval = setInterval(fontdraw, " . $this->drawtime . ");
		intvalrotate = setInterval(fontrotate, " . $this->rotatetime . ", 'l');
		_parent.soundtrigger = false;
		_parent.stop();
		";
		// As main code to sprite movie
		$capmc = new SWFSprite();
		$capmc->add(new SWFAction($asscript));
		$capmc->nextFrame();
		$movie->add($capmc);
		if ($this->talking === true) {
			$sounds = array();
			$sounds = $this->checksound();
			// Only sound and button when all files are valid (  with language or default )
			if (!empty($sounds)) {
				// Create a full movie shape
				$shp = new SWFShape();
				$shp->setRightFill($shp->addFill(0, 0, 0));
				$shp->drawLine($this->swf_width, 0);
				$shp->drawLine(0, $this->swf_height);
				$shp->drawLine((-1 * $this->swf_width), 0);
				$shp->drawLine(0, (-1 * $this->swf_height));
				// Add shape to a button and define actions
				$but = new SWFButton();
				$but->addShape($shp, SWFBUTTON_HIT);
				$asscript = "if (soundtrigger == true) { soundtrigger = false; stop(); }
				else { soundtrigger = true; gotoAndPlay(1); }
				";
				$but->addAction(new SWFAction($asscript), SWFBUTTON_HIT);
				$movie->add($but);	
				// Stream multiple mp3 (  experimental - may be buggy )
				for ($i = 0; $i < count($sounds); $i++) {
					$mp3f = fopen($sounds[$i],"rb");
					$movie->streamMp3($mp3f);
					for ($a = 0; $a < $this->soundframes; $a++) {
						$movie->nextFrame();
					}
					// Do not close filehandle here - kills stream for multiple files
				}
			}
		}
		header('Content-type: application/x-shockwave-flash'); 
			// $movie->save('captcha.swf');  
			$movie->output();
		// Close filehandle - NOTE: rem this if sound stream gets aborted
		if (isset($mp3f)) {
			fclose($mp3f);
		}
	}
	
/********************************************************************************
* @ function swfhtml()
* @ returns x-html code for the swf captcha
********************************************************************************/	
	function swfhtml() {
		// Prevent cache display by adding unique date query
		// No cache headers for the swf output causes a problem in IE7 browsers
		$url = $this->swf_url . "?nc=" . date('YmHis');
		// Two types off html output
		// First = swf valid xhtml ( prefered ) - Second = standard ( normaly used ) xhtml
		if ($this->swf_validxhtml === true) {
			$htmlout = '<object type="application/x-shockwave-flash" ';
			$htmlout .= 'width="' . $this->swf_width . '" height="' . $this->swf_height . '" id="talkingcaptcha" ';
			$htmlout .= 'data="' . $url . '" /><param name="allowScriptAccess" value="sameDomain" />';
			$htmlout .= '<param name="movie" value="' . $url . '" />';
			$htmlout .= '<param name="quality" value="high" />';
			if ($this->swf_transparent !== true) {
				$htmlout .= '<param name="bgcolor" value="' . $this->bgcolor . '" />';
			} else {
				$htmlout .= '<param name="wmode" value="transparent" />';
			}
			$htmlout .= '</object>';
		} else {
			$htmlout = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
			$htmlout .= 'width="' . $this->swf_width . '" height="' . $this->swf_height . '" id="talkingcaptcha">';
			$htmlout .= '<param name="allowScriptAccess" value="sameDomain" />';
			$htmlout .= '<param name="movie" value="' . $url . '" />';
			$htmlout .= '<param name="quality" value="high" />';
			if ($this->swf_transparent !== true) {
				$htmlout .= '<param name="bgcolor" value="' . $this->bgcolor . '" />';
				$embedcode = 'bgcolor="' . $this->bgcolor . '" ';
			} else {
				$htmlout .= '<param name="wmode" value="transparent" />';
				$embedcode = 'wmode="transparent" ';
			}
			$htmlout .= '<embed src="' . $url . '" quality="high" ' . $embedcode;
			$htmlout .= 'width="' . $this->swf_width . '" height="' . $this->swf_height . '" name="talkingcaptcha" ';
			$htmlout .= 'allowScriptAccess="sameDomain" type="application/x-shockwave-flash"';
			$htmlout .= ' /></object>';
		}
		return $htmlout;
	}

/********************************************************************************
* @ function validate()
* @ returns true on post captcha value == session value
********************************************************************************/	
	function validate() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->usednsbl === true && !isset($_SESSION[$this->session_dnsbl])) {
				if ($this->dnsbl() === false) {
					return false;
				}
			} else if ($this->usednsbl === true && $_SESSION[$this->session_dnsbl] != "oke") {
					return false;
			}
			if (isset($_POST[$this->post_captcha]) && isset($_SESSION[$this->session_captcha])) {
				$val = $_POST[$this->post_captcha];
				if ($this->talking === true) {
					$val = strtolower($val);
				}
				if ($val != "" && $val == $_SESSION[$this->session_captcha]) {
					unset($_SESSION[$this->session_captcha]);
					return true;
				}
			} 
		}
		if (isset($_SESSION[$this->session_captcha])) {
			unset($_SESSION[$this->session_captcha]);
		}
		return false;
	}
	
/********************************************************************************
* @ function checksounds()
* @ check user defined lang first ( fill in missing from default dir )
* @ returns sound files array or empty on a missing file (  disables sounds auto on missing )
********************************************************************************/
	function checksound() {
		$sounds = array();
		if (substr($this->sounddir, -1 ) == '/') {
			$this->sounddir = substr($this->sounddir, 0, -1);
		}
		$defdir = $this->sounddir . "/" . strtolower($this->soundlangdefault);
		$sdir = $this->sounddir . "/" . strtolower($this->soundlang);
		if ($this->usednsbl === true && isset($_SESSION[$this->session_dnsbl])) {
			if ($_SESSION[$this->session_dnsbl] != "oke") {
				// forbidden.mp3 - used for blocked IP
				if (file_exists($sdir . "/" . $this->forbidden_sound)) {
					$sounds[0] = $sdir . "/" . $this->forbidden_sound;
				} else if (file_exists($defdir . "/" . $this->forbidden_sound)) {
					$sounds[0] = $defdir . "/" . $this->forbidden_sound;	
				} else {
					return array();
				}
				return $sounds;
			}
		}
		// codestart.mp3 - used for captcha code start
		if (file_exists($sdir . "/codestart.mp3")) {
			$sounds[0] = $sdir . "/codestart.mp3";
		} else if (file_exists($defdir . "/codestart.mp3")) {
			$sounds[0] = $defdir . "/codestart.mp3";	
		} else {
			return array();
		}
		for ($i = 1; $i <= $this->captcha_length; $i++) {
			// all other sound files have format  captcha-character.mp3
			if (file_exists($sdir . "/" . strtolower($this->captchaval[$i-1]) . ".mp3")) {
				$sounds[$i] = $sdir . "/" . strtolower($this->captchaval[$i-1]) . ".mp3";
			} else if (file_exists($defdir . "/" . strtolower($this->captchaval[$i-1]) . ".mp3")) {
				$sounds[$i] = $defdir . "/" . strtolower($this->captchaval[$i-1]) . ".mp3";
			} else {
				return array();
			}	
		}
		return $sounds;
	}

/********************************************************************************
* @ function deccolors()
* @ input string hex color
* @ returns array with RGB color
********************************************************************************/
	function deccolors($webcolors) {
		$webcolors = str_replace("#", "", $webcolors);
		$webcolors = str_replace("0x", "", $webcolors);
		$deccolor = array();
		$deccolor[0] = hexdec(substr($webcolors, 0, 2));
		$deccolor[1] = hexdec(substr($webcolors, 2, 2));
		$deccolor[2] = hexdec(substr($webcolors, 4, 2));
		return $deccolor;
	}
	
/********************************************************************************
* @ function randomcolors()
* @ returns string for random font colors for ming captcha swf
********************************************************************************/
	function randomcolors() {
		$colorstr = "";
		for ($i = 0; $i < count($this->colors); $i++) {
			$var = str_replace("#", "", $this->colors[$i]);
			$var = str_replace("0x", "", $var);
			if ($i < count($this->colors) - 1) {
				$colorstr .= "0x" . strtolower($var) . ",";
			} else {
				$colorstr .= "0x" . strtolower($var) . "";			
			}
		}
		if (count($this->colors) == 1) {
			// adjust string if 1 color for flash ani ( needs 2 )
			$var = str_replace("#", "", $this->colors[0]);
			$var = str_replace("0x", "", $var);
			$colorstr = "0x" . strtolower($var) . ", 0x" . strtolower($var) . "";
		}
		return $colorstr;
	}
	
/********************************************************************************
* @ function dnsbl
* @ validate IP on DNSBL ( blacklists )
* @ returns false if not found
* @ sets $_SESSION[$this->sessiondnsbl] - returns true on not listed
********************************************************************************/
	function dnsbl() { 
		if (preg_match('/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/', $_SERVER["REMOTE_ADDR"])) { 
			$reversip = implode(".", array_reverse(explode(".", $_SERVER["REMOTE_ADDR"]))); 
			$win_os = strtolower(substr(PHP_OS, 0, 3)) == "win" ? true : false; 
			foreach ($this->dnsblists as $list){ 
				if (function_exists("checkdnsrr")) { 
					if (checkdnsrr($reversip . "." . $list . ".", "A")) { 
						$_SESSION[$this->session_dnsbl] = $list;
						return false;
					} 
				} else if ($win_os) { 
					$lookup = array(); 
					@exec("nslookup -type=A " . $reversip . "." . $list . ".", $lookup); 
					foreach ($lookup as $line) { 
						if (strstr($line, $list)) { 
							$_SESSION[$this->session_dnsbl] = $list;
							return false;
						} 
					} 
				} 
			} 
		} 
		$_SESSION[$this->session_dnsbl] = "oke";
		return true;
	} 
}
/********************************************************************************
Copyright (c) 2007, scripts.titude.nl - all rights reserved.
Author: scripts [[@]] titude.nl - scripts.titude.nl - Netherlands

Disclaimer & License

Current state: development - educational - experimental

	THE AUTHOR MAKES NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR
	IMPLIED.  BY WAY OF EXAMPLE, BUT NOT LIMITATION, THE AUTHOR MAKES NO 
	REPRESENTATIONS OR WARRANTIES OF MERCHANTABILITY OR FITNESS FOR
	ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SCRIPT, COMPONENTS, 
	OR DOCUMENTATION WILL NOT INFRINGE ANY PATENTS, COPYRIGHTS, 
	TRADEMARKS, OR OTHER RIGHTS.  THE AUTHOR SHALL NOT BE HELD LIABLE 
	FOR ANY LIABILITY NOR FOR ANY DIRECT, INDIRECT, OR CONSEQUENTIAL 
	DAMAGES WITH RESPECT TO ANY CLAIM BY RECIPIENT OR ANY THIRD PARTY 
	ON ACCOUNT OF OR ARISING FROM THIS AGREEMENT OR USE OF THIS SCRIPT
	AND ITS COMPONENTS.

	Released under GNU Lesser General Public License - http://www.gnu.org/licenses/lgpl.html

********************************************************************************/
?>

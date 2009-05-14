<?php
/**
* FileName: mamblog.php
*	Date: 13 Mar 2004
* License: GNU General Public License
* Script Version #: 1.0
* MOS Version #: 4.5
* Script TimeStamp: "10/19/2003 14:08PM"
* Original Script: Olle Johansson - Olle@Johansson.com
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Turn on error reporting with notices.
#error_reporting(E_ALL);

//Get right Language file
if ( file_exists( "$mosConfig_absolute_path/components/$option/language/$mosConfig_lang.php" ) ) {
	include_once("$mosConfig_absolute_path/components/$option/language/$mosConfig_lang.php");
} else {
	include_once("$mosConfig_absolute_path/components/$option/language/english.php");
}
include_once("$mosConfig_absolute_path/components/$option/configuration.php");

require_once( $mainframe->getPath( 'front_html' ) );
#require_once( $mainframe->getPath( 'class' ) );

// option masks
define( "MASK_BACKTOLIST", 0x0001 );
define( "MASK_READON",     0x0002 );
define( "MASK_POPUP",      0x0004 );
define( "MASK_PRINT",      0x0008 );
define( "MASK_MAIL",       0x0010 );
define( "MASK_IMAGES",     0x0020 );

define( "MASK_HIDEAUTHOR",     0x0100 );
define( "MASK_HIDECREATEDATE", 0x0200 );
define( "MASK_HIDEMODIFYDATE", 0x0400 );

$task =  mosGetParam( $_REQUEST ,'task', '' );
$action = mosGetParam( $_REQUEST, 'action', '');
$id = mosGetParam( $_REQUEST, 'id', 0 );
$pop = mosGetParam( $_REQUEST, 'pop', 0 );
$ignorecount = mosGetParam( $_REQUEST, 'ignorecount', 0 );
$Itemid = mosGetParam( $_REQUEST, 'Itemid', 0 );

$count = $cfg_mamblog['count'];
$intro = $cfg_mamblog['intro'];
$image = $cfg_mamblog['image'];
$sort = $cfg_mamblog['sort'];
$showdefault = $cfg_mamblog['showdefault'];
$specified = $cfg_mamblog['specified'];

// A couple of preset settings
$cfg_mamblog['border'] =
array("0" => _BLOG_NOBORDER,
      "1" => "1 " . _BLOG_PIXEL,
      "2" => "2 " . _BLOG_PIXELS,
      "3" => "3 " . _BLOG_PIXELS,
      "4" => "4 " . _BLOG_PIXELS,
      "5" => "5 " . _BLOG_PIXELS,
);
$cfg_mamblog['textalign'] =
array(
      "left" => _BLOG_LEFT,
      "right" => _BLOG_RIGHT,
      "justify" => _BLOG_JUSTIFIED,
      "center" => _BLOG_CENTERED,
);

print "<link rel='stylesheet' href='components/$option/style.css' type='text/css' />\n";

// Find out which section id the blog items are in.
$sectionid = intval( $cfg_mamblog['sectionid'] );
$sectioncat = intval( $cfg_mamblog['catid'] );
$database->setQuery( "SELECT id FROM #__sections WHERE id = '$sectionid'");
$obj = null;
if ( !$database->loadObject( $obj ) ) {
	showError( _BLOG_SECTIONNOTFOUND );
	exit();
}

// Get the Itemid from the database if we didn't recieve it, just in case.
if ( !$Itemid ) {
	$sql = "SELECT id from #__menu WHERE link='index.php?option=com_mamblog'";
	$database->setQuery($sql);
	$menurow = null;
	if ( $database->loadObject( $menurow ) ) {
		$Itemid = $menurow->id;
	}
}

// Let's find out what to do.
switch( $task ) {
	case "edit":
		include_once("$mosConfig_absolute_path/components/$option/editblog.php");
		break;
	case "register":
		include_once("$mosConfig_absolute_path/components/$option/register.php");
		break;
	case "listbloggers":
		include_once("$mosConfig_absolute_path/components/$option/listbloggers.php");
		break;
	case "view":
		$task = "show";
		$action = "view";
	case "show":
	default:
		include_once("$mosConfig_absolute_path/components/$option/showblogs.php");
}
#print "<!-- end of mamblog -->";

function showError( $error, $error_header = _BLOG_ERROR ) {
	print <<<CONTENT
<blockquote class="error">
<h2 class="error">$error_header</h2>
<p>$error</p>
</blockquote>
CONTENT;
}

function formatdate($date){
	global $mosConfig_offset;
	if ( $date && ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})[ ]([0-9]{2}):([0-9]{2}):([0-9]{2})", $date, $regs ) ) {
		$date = mktime( $regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1] );
		#$date = $date > -1 ? strftime( "%d %B %Y %H:%M", $date + ($mosConfig_offset*60*60) ) : '-';
		$date = $date > -1 ? strftime( _DATE_FORMAT_LC, $date + ($mosConfig_offset*60*60) ) : '-';
	}
	return $date;
}

function is_date($date) {
	if ( $date && ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})[ ]([0-9]{2}):([0-9]{2}):([0-9]{2})", $date, $regs ) ) {
		$date = mktime( $regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1] );
		return $date;
	}
	return false;
}


?>

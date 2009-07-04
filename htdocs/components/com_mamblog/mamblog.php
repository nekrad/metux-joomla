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

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// Turn on error reporting with notices.
#error_reporting(E_ALL);

global $cfg_mamblog;
require_once(JPATH_COMPONENT.'/configuration.php');
require_once(JPATH_COMPONENT.'/Mamblog_URL.class.php');

$cfg_mamblog{'current_user'} = JFactory::getUser();
$cfg_mamblog{'current_lang'} = JFactory::getLanguage();
$cfg_mamblog{'url_render'}   = new Mamblog_URL();
$cfg_mamblog{'current_lang'}->load('com_mamblog');

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

global $count, $image, $sort, $showdefault, $specified;
$count = $cfg_mamblog['count'];
$image = $cfg_mamblog['image'];
$sort = $cfg_mamblog['sort'];
$showdefault = $cfg_mamblog['showdefault'];
$specified = $cfg_mamblog['specified'];

// A couple of preset settings
$cfg_mamblog['border'] =
array("0" => _mbtextp('NO_BORDER'),
      "1" => "1 " . _mbtextp('PIXEL'),
      "2" => "2 " . _mbtextp('PIXELS'),
      "3" => "3 " . _mbtextp('PIXELS'),
      "4" => "4 " . _mbtextp('PIXELS'),
      "5" => "5 " . _mbtextp('PIXELS'),
);
$cfg_mamblog['textalign'] =
array(
      "left"    => _mbtextp('LEFT'),
      "right"   => _mbtextp('RIGHT'),
      "justify" => _mbtextp('JUSTIFIED'),
      "center"  => _mbtextp('CENTERED'),
);

print "<link rel='stylesheet' href='components/$option/style.css' type='text/css' />\n";

// Find out which section id the blog items are in.
$database->setQuery( "SELECT id FROM #__sections WHERE id = '{$cfg_mamblog{'sectionid'}}'");
$obj = null;
if ( !$database->loadObject( $obj ) ) {
	showError(_mbtextp('ERROR_INVALID_SECTION') );
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

function showError( $error, $error_header = false ) {
	if (!$error_header)
	     $error_header = _mbtextp('ERROR');
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

/* retrieve a text resource w/ MAMBLOG: prefix */
function _mbtextp($t)
{
	global $cfg_mamblog;
	return $cfg_mamblog{'current_lang'}->_('MAMBLOG:'.$t);
}

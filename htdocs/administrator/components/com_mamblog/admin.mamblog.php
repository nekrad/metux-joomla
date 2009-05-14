<?php
//Mamblog Admin//
	/**
	 *	Mamblog Component for Mambo Site Server 4.5
	 *	Dynamic portal server and Content managment engine
	 *	13 Mar 2004
 	 *
	 *	Copyright (C) 2004 Olle Johansson
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided and
	 *  copyright statements are left intact.
	 *
	 *	Site Name: Mambo Site Server 4.5
	 *	File Name: admin.mamblog.html.php
	 *	Developer: Olle Johansson - Olle@Johansson.com
	 *	Date: 13 Mar 2004
	 * 	Version #: 1.0
	 *	Comments:
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

require_once( $mainframe->getPath( 'admin_html' ) );

global $cfgfile;
$cfgfile = "$mosConfig_absolute_path/components/$option/configuration.php";
include_once( $cfgfile );

// Create a html object
$blogadmin = new HTML_mamblog_admin();

// Titles and files for the information page.
$pages = array();
$pages[1]['title'] = "Information";
$pages[1]['file'] = "readme.html";
$pages[2]['title'] = "TODO";
$pages[2]['file'] = "TODO.txt";
$pages[3]['title'] = "Changefile";
$pages[3]['file'] = "CHANGES.txt";
$pages[4]['title'] = "License";
$pages[4]['file'] = "gnu_gpl.txt";

// Define which admin page to show.
switch ($task) {
	case "conf":
		showConfig();
		break;
	case "saveconf":
		saveConfig();
		break;
	case "info":
	default:
		showPages( $pages );
}

// Include a standard footer.
include_once( "$mosConfig_absolute_path/administrator/components/$option/footer.php" );

function showConfig() {
   global $database, $mosConfig_absolute_path, $option, $cfgfile, $cfg_mamblog, $blogadmin;

   @chmod( $cfgfile, 0766 );
   $permission = is_writable( $cfgfile );
   if ( !$permission ) {
	   $err = "<b>" . _ERR_YOURCONFIG . " $cfgfile</b><br />";
	   $err .= "<b>". _ERR_CHMODFILE . "</b></div><br /><br />";
	   showError ( $err, _ERR_WARNING );
   }

   $preset_attribs = mosParseParams( $cfg_mamblog['preset_values']['attribs'] );

   $cfg = array();

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
   $borderselect = array();
   foreach ( $cfg_mamblog['border'] as $k => $v ) {
	   $borderselect[] = mosHTML::makeOption( $k, $v );
   }
   $textalignselect = array();
   foreach ( $cfg_mamblog['textalign'] as $k => $v ) {
	   $textalignselect[] = mosHTML::makeOption( $k, $v );
   }

   // Make select list options for comment systems
   $commentsystems = array();
   $commentsystems[] = mosHTML::makeOption( "none", _BLOG_NO_COMMENT_SYSTEM );
   $commentsystems[] = mosHTML::makeOption( "combo", "ComboLITE or ComboMAX" );
   $commentsystems[] = mosHTML::makeOption( "akocomment", "AkoComment" );
   $commentsystems[] = mosHTML::makeOption( "mxcomment", "MX Comment" );
   //added for Joomlaboard support as commenting system
   $commentsystems[] = mosHTML::makeOption( "joomlaboard", "Joomlaboard" );

   // Make a select list for column template selection
   $itemstructure = array();
   $itemstructure[] = mosHTML::makeOption( "1", _BLOG_ONE_COLUMN );
   $itemstructure[] = mosHTML::makeOption( "2", _BLOG_TWO_COLUMNS );
   $itemstructure[] = mosHTML::makeOption( "3", _BLOG_TWOCOL_WITHLEAD );
   
   // List editor selection option.
   $edits = array();
   $edits[] = mosHTML::makeOption( '_jx_none', _BLOG_NO_EDITOR );
   $edits[] = mosHTML::makeOption( '_jx_default', _BLOG_DEFAULT_EDITOR );

   // Configuration options
   $cfg['showarchivelink'] = mosHTML::yesnoSelectList( 'cfg_showarchivelink', 'class="inputbox" size="1"', $cfg_mamblog['showarchivelink'] );
   $cfg['useattribs'] = mosHTML::yesnoSelectList( 'cfg_useattribs', 'class="inputbox" size="1"', $cfg_mamblog['useattribs'] );
   $cfg['use_bgcolor'] = mosHTML::yesnoSelectList( 'cfg_use_bgcolor', 'class="inputbox" size="1"', $cfg_mamblog['use_bgcolor'] );
   $cfg['use_fgcolor'] = mosHTML::yesnoSelectList( 'cfg_use_fgcolor', 'class="inputbox" size="1"', $cfg_mamblog['use_fgcolor'] );
   $cfg['use_border'] = mosHTML::yesnoSelectList( 'cfg_use_border', 'class="inputbox" size="1"', $cfg_mamblog['use_border'] );
   $cfg['use_bordercolor'] = mosHTML::yesnoSelectList( 'cfg_use_bordercolor', 'class="inputbox" size="1"', $cfg_mamblog['use_bordercolor'] );
   $cfg['use_width'] = mosHTML::yesnoSelectList( 'cfg_use_width', 'class="inputbox" size="1"', $cfg_mamblog['use_width'] );
   $cfg['use_height'] = mosHTML::yesnoSelectList( 'cfg_use_height', 'class="inputbox" size="1"', $cfg_mamblog['use_height'] );
   $cfg['use_textalign'] = mosHTML::yesnoSelectList( 'cfg_use_textalign', 'class="inputbox" size="1"', $cfg_mamblog['use_textalign'] );
   $cfg['use_allowcomments'] = mosHTML::yesnoSelectList( 'cfg_use_allowcomments', 'class="inputbox" size="1"', $cfg_mamblog['use_allowcomments'] );
   $cfg['use_showcomments'] = mosHTML::yesnoSelectList( 'cfg_use_showcomments', 'class="inputbox" size="1"', $cfg_mamblog['use_showcomments'] );
   $cfg['use_frontpage'] = mosHTML::yesnoSelectList( 'cfg_use_frontpage', 'class="inputbox" size="1"', 'value', $cfg_mamblog['use_frontpage'] );
   $cfg['use_state'] = mosHTML::yesnoSelectList( 'cfg_use_state', 'class="inputbox" size="1"', $cfg_mamblog['use_state'] );
   $cfg['use_access'] = mosHTML::yesnoSelectList( 'cfg_use_access', 'class="inputbox" size="1"', $cfg_mamblog['use_access'] );
   $cfg['commentsystem'] = mosHTML::selectList( $commentsystems, 'cfg_commentsystem', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['commentsystem'] );
   $cfg['showusername'] = mosHTML::yesnoSelectList( 'cfg_showusername', 'class="inputbox" size="1"', $cfg_mamblog['showusername'] );
   $cfg['editor'] = mosHTML::selectList( $edits, 'cfg_editor', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['editor'] );

   /* Preset values */
   $state[] = mosHTML::makeOption( '0', _UNPUBLISHED );
   $state[] = mosHTML::makeOption( '1', _PUBLISHED );
   $state[] = mosHTML::makeOption( '2', _ARCHIVED );
   $cfg['preset_values_state'] = mosHTML::selectList( $state, 'cfg_preset_values_state', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['preset_values']['state'] );
   $access[] = mosHTML::makeOption( '0', _ACCESS_ALL );
   $access[] = mosHTML::makeOption( '1', _ACCESS_REGISTERED );
   $access[] = mosHTML::makeOption( '2', _ACCESS_USER );
   $cfg['preset_values_access'] = mosHTML::selectList( $access, 'cfg_preset_values_access', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['preset_values']['access'] );
   $cfg['preset_values_frontpage'] = mosHTML::yesnoSelectList( 'cfg_preset_values_frontpage', 'class="inputbox" size="1"', $cfg_mamblog['preset_values']['frontpage'] );
   $cfg['preset_values_allowcomments'] = mosHTML::yesnoSelectList( 'cfg_preset_values_allowcomments', 'class="inputbox" size="1"', $preset_attribs->allowcomments );
   $cfg['preset_values_showcomments'] = mosHTML::yesnoSelectList( 'cfg_preset_values_showcomments', 'class="inputbox" size="1"', $preset_attribs->showcomments );
   $cfg['preset_values_textalign'] = mosHTML::selectList( $textalignselect, 'cfg_preset_values_textalign', 'class="inputbox" size="1"', 'value', 'text', $preset_attribs->textalign );
   $cfg['preset_values_border'] = mosHTML::selectList( $borderselect, 'cfg_preset_values_border', 'class="inputbox" size="1"', 'value', 'text', $preset_attribs->border );

   /* Blog viewing settings */
   $cfg['image'] = mosHTML::yesnoSelectList( 'cfg_image', 'class="inputbox" size="1"', $cfg_mamblog['image'] );
   $showdefsel = array();
   $showdefsel[] = mosHTML::makeOption( "frontpage", _BLOG_FRONTPAGEITEMS );
   $showdefsel[] = mosHTML::makeOption( "user", _BLOG_FROMAUSER );
   $showdefsel[] = mosHTML::makeOption( "userarchive", _BLOG_ARCHIVEFROMAUSER );
   $showdefsel[] = mosHTML::makeOption( "all", _BLOG_ALL );
   $showdefsel[] = mosHTML::makeOption( "date", _BLOG_BYDATE );
   $cfg['showdefault'] = mosHTML::selectList( $showdefsel, 'cfg_showdefault', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['showdefault'] );
   $sortsel = array();
   $sortsel[] = mosHTML::makeOption( "datedesc", _BLOG_DATEDESC );
   $sortsel[] = mosHTML::makeOption( "dateasc", _BLOG_DATEASC );
   $sortsel[] = mosHTML::makeOption( "ordering", _BLOG_ORDERING );
   $sortsel[] = mosHTML::makeOption( "orderingdesc", _BLOG_ORDERINGDESC );
   $cfg['sort'] = mosHTML::selectList( $sortsel, 'cfg_sort', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['sort'] );
   $cfg['itemstructure'] = mosHTML::selectList( $itemstructure, 'cfg_itemstructure', 'class="inputbox" size="1"', 'value', 'text', $cfg_mamblog['itemstructure'] );

   $blogadmin->showConfig( $cfg_mamblog, $cfg );
}

function saveConfig() {
   global $database, $mosConfig_absolute_path, $option, $cfgfile;

   @chmod( $cfgfile, 0766 );
   if ( !is_writable( $cfgfile ) ) {
      mosRedirect( "index2.php?option=$option", _BLOG_ERR_NOT_WRITEABLE );
   }

   $attribs = array();
   $txt = "<?php\n";
   foreach ( $_POST as $k => $v ) {
      if ( strpos( $k, 'cfg_' ) === 0 ) {
         if ( !get_magic_quotes_gpc() ) {
            $v = addslashes( $v );
         }
		 if ( strpos( $k, 'cfg_preset_values_' ) === 0 ) {
			 if ( $k == "cfg_preset_values_state" ) {
				 $state = $v;
			 }
			 else if ( $k == "cfg_preset_values_frontpage" ) {
				 $frontpage = $v;
			 }
			 else if ( $k == "cfg_preset_values_access" ) {
				 $access = $v;
			 }
			 else {
				 $attribs[ substr( $k, 18 ) ] = $v;
			 }
		 }
		 else {
			 $txt .= "\$cfg_mamblog['" . substr( $k, 4 ) . "']='$v';\n";
		 }
      }
   }
   $txt .= "\$cfg_mamblog['preset_values'] =\n";
   $txt .= "array(\n";
   $txt .= "      \"state\" => \"$state\",\n";
   $txt .= "      \"frontpage\" => \"$frontpage\",\n";
   $txt .= "      \"access\" => \"$access\",\n";
   $txt .= "      \"attribs\" => \"\n";
   foreach ( $attribs as $k => $v ) {
	   $txt .= "$k=$v\n";
   }
   $txt .= "\",\n);\n";
   $txt .= "?>";

   if ( $fp = fopen( $cfgfile, "w" ) ) {
      fputs( $fp, $txt, strlen( $txt ) );
      fclose( $fp );
      mosRedirect( "index2.php?option=$option&task=conf", _BLOG_CONFIG_SAVED );
   } else {
      mosRedirect( "index2.php?option=$option", _BLOG_ERR_OPEN_FILE );
   }
}

function showPages( $pages ) {
	global $mosConfig_absolute_path, $option, $blogadmin;
	
	// Read all files and convert if necessary.
	$pc = count( $pages );
	for ( $i = 1; $i <= $pc; $i++ ) {
		$filecontent = implode( '',  @file( "$mosConfig_absolute_path/administrator/components/$option/" . $pages[$i]['file'] ) );
		
		// Text files get newlines added after each line.
		if ( substr( $pages[$i]['file'], -4 ) == ".txt" ) {
			$filecontent = nl2br($filecontent);
		}
		$pages[$i]['content'] = $filecontent;
	}

	$blogadmin->showAdminPages( $pages, _BLOG_INFORMATION );
}


/** Some helper functions **/

function showError( $error, $title="" ) {
	$error_header = $title ? $title : _BLOG_ERROR;
	print <<<CONTENT
<blockquote class="error">
<h2 class="error">$error_header</h2>
<p>$error</p>
</blockquote>
CONTENT;
}

/**
* Mambo function to parse parameters, only necessary in old Mambo versions.
*/
if ( !function_exists( 'mosParseParams' ) ) {
	function mosParseParams( $txt ) {
		$sep1 = "\n";	// line separator
		$sep2 = "=";	// key value separator
		
		$temp = explode( $sep1, $txt );
		$obj = new stdClass();
		// We use trim() to make sure a numeric that has spaces
		// is properly treated as a numeric
		foreach ($temp as $item) {
			if($item) {
				$temp2 = explode( $sep2, $item, 2 );
				$k = trim( $temp2[0] );
				if (isset( $temp2[1] )) {
					$obj->$k = trim( $temp2[1] );
				} else {
					$obj->$k = $k;
				}
			}
		}
		return $obj;
	}
}

?>

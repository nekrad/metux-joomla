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

class HTML_mamblog_admin {
	function showHeader( $title, $display = "", $pageNav = "" ) {
		global $option;
		?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%">
      <tr>
         <td><img src="../components/<?php echo $option; ?>/mamblog_small.gif" align="middle" alt="<?php echo $title; ?>" /></td>
         <td width="100%" class="sectionname">&nbsp;&nbsp;&nbsp;<?php echo $title; ?></td>
<?php if ( $display ) { ?>
      <td nowrap><?php echo $display; ?></td>
<?php } ?>
<?php if ( $pageNav ) { ?>
      <td>
         <?php echo $pageNav->writeLimitBox(); ?>
      </td>
<?php } ?>
      </tr>
   </table>
<?php
	}

	function showAdminPages( $pages, $title ) {
		global $option;
		$this->showHeader( $title );
		?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%">
      <tr>
         <td>
<?php
    $tabs = new mosTabs(1);
    $tabs->startPane( 'mamblog-infopages' );
	$pc = count( $pages );
	for ( $i = 1; $i <= $pc; $i++ ) {
		$tabs->startTab( $pages[$i]['title'] , 'mamblog-page' . $i );
		echo $pages[$i]['content'];
		$tabs->endTab();
	}
    $tabs->endPane();
?>
        </td>
      </tr>
   </table>
<?php
	}

   function showConfig( &$cfg_mamblog, &$cfg ) {
	   global $option;

	   $attribs = mosParseParams( $cfg_mamblog['preset_values']['attribs'] );
	   $this->showHeader( _BLOG_CONFIGURATION );
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
			if (pressbutton == 'saveconf') {
				if (confirm ("<?php echo _BLOG_AREYOUSURE; ?>")) {
					submitform( pressbutton );
				}
			} else {
				document.location.href = 'index2.php';
			}
	}
</script>
<table cellpadding="4" cellspacing="0" border="0" width="100%">
  <tr>
    <td>
      <form action="index2.php" method="POST" name="adminForm">

<?php
    $tabs = new mosTabs(1);
    $tabs->startPane( 'mamblog-config' );
    $tabs->startTab( _BLOG_SETTINGS, 'mamblog-config' . 1 );
?>
    <table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <td align="left" valign="top" width="375"><?php echo _BLOG_SHOWARCHIVELINK; ?></td>
         <td align="left" valign="top"><?php echo $cfg['showarchivelink']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USEATTRIBS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['useattribs']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_BGCOLOR; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_bgcolor']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_FGCOLOR; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_fgcolor']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_BORDER; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_border']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_BORDERCOLOR; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_bordercolor']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_WIDTH; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_width']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_HEIGHT; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_height']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_TEXTALIGN; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_textalign']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_ALLOWCOMMENTS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_allowcomments']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_SHOWCOMMENTS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_showcomments']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_FRONTPAGE; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_frontpage']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_STATE; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_state']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_USE_ACCESS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['use_access']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_MIN_WIDTH; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_min_width" value="<?php echo $cfg_mamblog['min_width']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_MAX_WIDTH; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_max_width" value="<?php echo $cfg_mamblog['max_width']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_MIN_HEIGHT; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_min_height" value="<?php echo $cfg_mamblog['min_height']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_MAX_HEIGHT; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_max_height" value="<?php echo $cfg_mamblog['max_height']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_COMMENT_SYSTEM; ?></td>
         <td align="left" valign="top"><?php echo $cfg['commentsystem']; ?></td>
      </tr>
	  <!-- added for Joomlaboard Forum Support as commenting system -->
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_JOOMLABOARD_FORUMID; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_joomlaboardid" value="<?php echo $cfg_mamblog['joomlaboardid']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>	  
    </table>
<?php
    $tabs->endTab();
    $tabs->startTab( _BLOG_PRESETVALUES, 'mamblog-config' . 2 );
?>
    <table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <td align="left" valign="top" width="175"><?php echo _BLOG_A_STATE; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_state']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_FRONTPAGE; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_frontpage']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_ACCESS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_access']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_ALLOWCOMMENTS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_allowcomments']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_SHOWCOMMENTS; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_showcomments']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_TEXTALIGN; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_textalign']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_FGCOLOR; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_preset_values_fgcolor" value="<?php echo $attribs->fgcolor; ?>" class="inputbox" size="10" maxlength="20" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_BGCOLOR; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_preset_values_bgcolor" value="<?php echo $attribs->bgcolor; ?>" class="inputbox" size="10" maxlength="20" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_BORDER; ?></td>
         <td align="left" valign="top"><?php echo $cfg['preset_values_border']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_BORDERCOLOR; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_preset_values_bordercolor" value="<?php echo $attribs->bordercolor; ?>" class="inputbox" size="10" maxlength="20" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_WIDTH; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_preset_values_width" value="<?php echo $attribs->width; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_HEIGHT; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_preset_values_height" value="<?php echo $attribs->height; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
    </table>
<?php
   $tabs->endTab();
   $tabs->startTab( _BLOG_VIEWING, 'mamblog-config' . 3 );
?>
    <table cellpadding="2" cellspacing="4" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <td align="left" valign="top" width="375"><?php echo _BLOG_COUNT; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_count" value="<?php echo $cfg_mamblog['count']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_INTRO; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_intro" value="<?php echo $cfg_mamblog['intro']; ?>" class="inputbox" size="4" maxlength="4" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_MAXCHARS; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_maxchars" value="<?php echo $cfg_mamblog['maxchars']; ?>" class="inputbox" size="4" maxlength="10" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_SHOWDEFAULT; ?></td>
         <td align="left" valign="top"><?php echo $cfg['showdefault']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_SPECIFIED; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_specified" value="<?php echo $cfg_mamblog['specified']; ?>" class="inputbox" size="20" maxlength="100" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_SORT; ?></td>
         <td align="left" valign="top"><?php echo $cfg['sort']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_IMAGE; ?></td>
         <td align="left" valign="top"><?php echo $cfg['image']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_ITEM_STRUCTURE; ?></td>
         <td align="left" valign="top"><?php echo $cfg['itemstructure']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_HEADER; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_header" value="<?php echo $cfg_mamblog['header']; ?>" class="inputbox" size="50" maxlength="255" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_SELECTEDITOR; ?></td>
         <td align="left" valign="top"><?php echo $cfg['editor']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_EDITORWIDTH; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_editorwidth" value="<?php echo $cfg_mamblog['editorwidth']; ?>" class="inputbox" size="5" maxlength="5" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_EDITORHEIGHT; ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_editorheight" value="<?php echo $cfg_mamblog['editorheight']; ?>" class="inputbox" size="5" maxlength="5" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _BLOG_SHOW_USERNAME; ?></td>
         <td align="left" valign="top"><?php echo $cfg['showusername']; ?></td>
      </tr>
    </table>
<?php
    $tabs->endTab();
    $tabs->endPane();
?>

  <input type="hidden" name="task" value="" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="cfg_version" value="<?php echo $cfg_mamblog['version']; ?>" />
  <input type="hidden" name="cfg_sectionid" value="<?php echo $cfg_mamblog['sectionid']; ?>" />
  <input type="hidden" name="cfg_catid" value="<?php echo $cfg_mamblog['catid']; ?>" />

      </form>
    </td>
  </tr>
</table>

<?php
   }

}
?>
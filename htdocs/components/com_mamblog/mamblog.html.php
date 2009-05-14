<?php
// $Id$
/**
* Content code
* @package Mamblog
* @Copyright (C) 2004 Olle Johansson
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0 $
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_mamblog {

	function showCommentLink( $id, $count, $link ) {
		global $Itemid;
		echo "<br clear='all' />";
		#echo "<a href=\"" . sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=view&amp;id=$id" ) . "\">";
		echo $link;
		echo _BLOG_VIEWADDCOMMENT . "</a> ($count)";
		echo "<br /><br />";
	}

	function showForumLink ( $link ) {
		echo "<br clear='all' />";
		echo $link;
		echo "<br /><br />";
	}

	function blogMessage( $message, $header ) {
		global $my, $option, $Itemid;

		$link = _BLOG_GOTOBLOGS;
		?>
  <table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
      <td class="contentheading" colspan="2"><?php echo $header; ?></td>
    </tr>
    <tr>
      <td class="contentpane" colspan="2"><?php echo $message . ' <a href="' . sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=user&amp;id={$my->id}" ) . '">' . $link; ?></a></td>
    </tr>
  </table>
<?php
	}

	function editBlog( $id, $blog, $header, $head, $frm, $headattribs, $frmattribs ) {
		global $cfg_mamblog, $Itemid, $my, $option;

		mosMakeHtmlSafe( $blog );

		// Put language constants in an array to use when printing.
		$lang['_TITLE']          = _TITLE;
		$lang['_CONTENT']        = _CONTENT;
		$lang['_BUTTON_MAMBLOG'] = _BUTTON_MAMBLOG;
		$lang['_EXTRAS']         = _EXTRAS;
		$lang['_ATTRIBS']        = _ATTRIBS;
		$lang['_ALLOWCOMMENTS']  = _ALLOWCOMMENTS;
		$lang['_SHOWCOMMENTS']   = _SHOWCOMMENTS;
		$lang['_FRONTPAGE']      = _FRONTPAGE;
		$lang['_ARCHIVED']       = _ARCHIVED;
		$lang['_PUBLISHED']      = _PUBLISHED;
		$lang['_ERROR']          = _ERROR;
		$lang['_BUTTON_DELETE']  = _BLOG_BUTTON_DELETE;
		$lang['_BLOG_CONFIRM_DELETE'] = _BLOG_CONFIRM_DELETE;

		print <<<CONTENT
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
CONTENT;
// Where editor1 = your areaname and content = the field name
print getEditorContentsJx( 'editor1', 'blogcontent') ;
		print <<<CONTENT
		return true;
	}

	function confirmDelete() {
		var del = window.confirm( '{$lang['_BLOG_CONFIRM_DELETE']}' );
		if (del) {
			document.adminForm.action.value = 'delete';
			document.adminForm.submit();
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" onsubmit="return submitbutton();">
<div class="componentheading">{$header}</div>
<br />
{$lang['_TITLE']}<br />
<input class="inputbox" type="text" name="title" size="30" value="{$blog->title}" /><br />
<br />

{$lang['_CONTENT']}<br />
CONTENT;
   // parameters : areaname, content, hidden field, width, height, rows, cols
   print editorAreaJx( 'editor1',  "$blog->fulltext", 'blogcontent', '50', '20' );
		print <<<CONTENT

CONTENT;
		if ( count( $frm ) ) {
			print <<<CONTENT
        <h4>{$lang['_EXTRAS']}</h4>
        <table border="0" cellspacing="0" cellpadding="5" width="100%">

CONTENT;
		for ( $i = 0; $i < count( $frm ); $i++ ) {
			print ( $i % 2 ) ? '' : "          <tr>\n";
			print <<<CONTENT
            <td width="100">{$head[$i]}</td>
            <td>
				{$frm[$i]}
            </td>

CONTENT;
			print ( $i % 2 ) ? "          </tr>\n" : '';
		}
		print ( $i % 2 ) ? "            <td colspan='2'>&nbsp;</td>\n          </tr>\n" : "";
		print <<<CONTENT
        </table>

CONTENT;
		}

		if ( count( $frmattribs ) ) {
			print <<<CONTENT
        <h4>{$lang['_ATTRIBS']}</h4>
        <table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td rowspan="6" width="10"></td>
            <td colspan="2"></td>
          </tr>

CONTENT;
			for ( $i = 0; $i < count( $frmattribs ); $i++ ) {
				print <<<CONTENT
          <tr>
            <td>
              {$headattribs[$i]}
            </td>
            <td>
              {$frmattribs[$i]}
            </td>
          </tr>

CONTENT;
			}
			print <<<CONTENT
        </table>

CONTENT;
		}
		print <<<CONTENT

  <br />
  <input class="button" type="submit" name="buttonsubmit" value="{$lang['_BUTTON_MAMBLOG']}" />

CONTENT;

    if ( $id ) {
	print <<<CONTENT
  <input class="button" type="button" name="delete" value="{$lang['_BUTTON_DELETE']}" onclick="confirmDelete();" />

CONTENT;
	}
    print <<<CONTENT
  <input type="hidden" name="option" value="$option" />
  <input type="hidden" name="id" value="$id" />
  <input type="hidden" name="Itemid" value="$Itemid" />
  <input type="hidden" name="catid" value="0" />
  <input type="hidden" name="task" value="edit" />
  <input type="hidden" name="action" value="save" />
</form>

CONTENT;

	}

	function show( $blog, $mask=0, $gid, $option ) {
		global $cfg_mamblog, $Itemid, $my, $mosConfig_live_site;
		$create_date = null;
		if (intval( $blog->created ) <> 0) {
			$create_date = mosFormatDate($blog->created);
		}
		switch (intval($blog->state)) {
			case 0: $state = _BLOG_UNPUBLISHED; break;
			case 1: $state = _BLOG_PUBLISHED; break;
			case -1: $state = _BLOG_ARCHIVED; break;
			default: $state = _BLOG_UNKNOWNSTATE; break;
		}
		$attribs = mosParseParams( $blog->attribs );
		$preset_attribs = mosParseParams( $cfg_mamblog['preset_values']['attribs'] );
		?>
<?php if ( $cfg_mamblog['useattribs'] ) { ?>
    <table cellpadding="<?php echo isset( $attribs->border ) ? $attribs->border : $preset_attribs->border; ?>" cellspacing="5" border="0" <?php echo isset( $attribs->width ) ? "width='$attribs->width'" : ""; ?> <?php echo isset( $attribs->height ) ? "height='$attribs->height'" : ""; ?> align="left">
		 <tr>
		 <td valign="top" bgcolor="<?php echo isset( $attribs->bordercolor ) ? $attribs->bordercolor : $preset_attribs->bordercolor; ?>">
<?php } ?>

	<table cellpadding="0" cellspacing="5" border="0" width="100%" class="contentpane"<?php if ( $cfg_mamblog['useattribs'] ) { ?> style="background-color: <?php echo isset( $attribs->bgcolor ) ? $attribs->bgcolor : $preset_attribs->bgcolor; ?>; color: <?php echo isset( $attribs->fgcolor ) ? $attribs->fgcolor : $preset_attribs->fgcolor; ?>; text-align: <?php echo isset( $attribs->textalign ) ? $attribs->textalign : $preset_attribs->textalign; ?>;" height="<?php echo isset( $attribs->height ) ? $attribs->height : $preset_attribs->height; ?>"<?php } ?>>
		<tr class="contentheading">
			<td width="100%">
<?php		if($blog->access <= $gid ) { ?>
				<a href="<?php echo sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=view&amp;id=$blog->id&amp;Itemid=$Itemid" ); ?>"><?php echo $blog->title; ?></a>
<?php		} else { ?>
                <?php echo $blog->title; ?>
<?php		} ?>
    <?php	if ( ( $my->id == $blog->created_by ) && !($mask&MASK_POPUP)) {?>
    <a href="<?php echo sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=edit&amp;action=modify&amp;id=$blog->id" ); ?>"><img src="images/M_images/edit.png" width="13" height="14" align="middle" border="0" alt="Edit" /></a>
    <?php	} ?>
            </td>
    <?php	if ($mask&MASK_POPUP) { ?>
    <td><a href="#" onClick="window.print(); return false");"><img src="images/M_images/printButton.png" border='0' alt="print" /></a></td>
    <?php	} else if ($mask&MASK_PRINT) { ?>
    <td align="right"> <a href="#" onClick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_content&Itemid=<?php echo $Itemid; ?>&task=view&id=<?php echo $row->id; ?>&pop=1&page=<?php echo $page;?>', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');"> 
      <img src="images/M_images/printButton.png" border="0" alt="print" /> </a> 
    </td>
    <?php	} ?>
    <?php	if ($mask&MASK_MAIL) { ?>
    <td> <a href="#" onClick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_content&Itemid=$Itemid&task=emailform&id=<?php echo $row->id; ?>', 'win2', 'status=no,toolbar=no,scrollbars=no,titlebar=no,menubar=no,resizable=yes,width=400,height=200,directories=no,location=no');"> 
      <img src="images/M_images/emailButton.png" border='0' alt="E-mail" /> </a> 
    </td>
    <?php	} ?>
		</tr>
<?php	if (!($mask&MASK_HIDECREATEDATE)) { ?>
		<tr>
			<td class="createdate" colspan="4" align="left"> (<?php echo $create_date; ?>) <?php echo _WRITTEN_BY; ?> <a href="<?php echo sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=user&amp;id=$blog->created_by" ); ?>"><?php echo $blog->author; ?></a></td>
		</tr>
<?php	} else { ?>
		<tr>
			<td class="createdate" colspan="4" align="left"> <?php echo _WRITTEN_BY; ?> <a href="<?php echo sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=user&amp;id=$blog->created_by" ); ?>"><?php echo $blog->author; ?></a></td>
		</tr>
<?php	} ?>
<?php	if ( ( $my->id == $blog->created_by ) ) { ?>
		<tr>
			<td class="createdate" colspan="4" align="left"><?php echo  _BLOG_STATE . " " . $state; ?></td>
		</tr>
<?php	} ?>
		<tr>
			<td valign="top" colspan="4"> <?php echo $blog->text; ?> </td>
		</tr>
<?php	if ($mask&MASK_READON && trim( $blog->fulltext ) ) { ?>
		<tr>
			<td colspan="3" align="left">
<?php		if($blog->access <= $gid ) { ?>
				<a href="<?php echo sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=view&amp;id=$blog->id&amp;Itemid=$Itemid" ); ?>" class="readon"><?php echo _BLOG_READ_ON;?></a>
<?php		} else { ?>
				<a href="<?php echo sefRelToAbs( "index.php?option=com_registration&amp;task=register" ); ?>" class="readon"><?php echo _BLOG_READ_ON_REGISTER;?></a>
<?php		} ?>
			</td>
		</tr>
<?php	} ?>
  <?php	if ($mask&MASK_BACKTOLIST) { ?>
  <tr> 
    <td colspan="3" align="center"><a href="javascript:window.history.go(-1);"><?php echo _BACK; ?></a></td>
  </tr>
  <?php	} ?>
	</table>

<?php if ( $cfg_mamblog['useattribs'] ) { ?>
		</td></tr>
	</table>
<?php	} ?>
<?php
	}

	function showLinks( &$rows, $limitstart, $limit ) {
		global $Itemid, $option;
		$n = min( count( $rows ), $limit );
?>
<br clear="all" />
<table cellpadding="0" cellspacing="5" border="0" width="100%" class="contentpaneopen">
  <tr> 
    <td> <strong><?php echo _MORE; ?></strong> </td>
  </tr>
  <?php for ($i=$limitstart; $i < $n; $i++) {
?>
  <tr> 
    <td> <a class="blogsection" href="<?php echo sefRelToAbs( "index.php?option=$option&amp;task=show&amp;action=view&amp;id={$rows[$i]->id}&amp;Itemid=$Itemid" );?>"> 
      <?php echo $rows[$i]->title;?></a></td>
  </tr>
  <?php
  }
?>
</table>
<?php
	}
}

?>
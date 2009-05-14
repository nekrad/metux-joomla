<?php
//Mamblog Edit//
/**
* FileName: mamblog.php
*	Date: 10-19-2003
* License: GNU General Public License
* Script Version #: 1.0
* MOS Version #: 4.5
* Script TimeStamp: "10/19/2003 14:08PM"
* Original Script: Olle Johansson - Olle@Johansson.com
*
* Description:
* Allows users to create a new or change current Mamblogs.
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Make sure they are logged in.
$id = intval($id);
if ( $gid && $my->username ) {
	if ( mosMenuCheck( "", "$option", "edit", $gid ) ) {
		switch( $action ) {
			case "modify":
				editMamblog( $id, $my->id, $option );
				break;
			case "save":
				saveMamblog( $id, $my->id, $option );
				break;
			case "delete":
				deleteMamblog( $id, $my->id, $option );
				break;
			default:
				editMamblog( 0, $my->id, $option );
		}
	} else {
		print _NOT_VALID;
	}
} else {
	// Not logged in
	print _NOT_VALID;
}

function deleteMamblog( $id, $uid, $option ) {
	global $cfg_mamblog, $database, $sectionid, $my;

	$msg = "";
	$uid = intval( $uid );
	$id = intval( $id );

	// First check that this user owns the blog entry (unless they are an administrator)
	if ( $my->usertype != "administrator" ) {
		$database->setQuery( "SELECT id FROM #__content WHERE created_by = '$uid' AND id = '$id'" );
		$id = $database->loadResult();
	}

	// Use the internal delete method.
	if ( $id ) {
		$obj = new mosContent( $database );
		$obj->delete( $id );
		$msg = $obj->getError();
	} else {
		$msg = _BLOG_NOBLOGENTRY;
	}

	if ( $msg ) {
		showError( $msg );
	} else {
		HTML_mamblog::blogMessage( _BLOG_DELETED_LONG, _BLOG_DELETED );
	}
}

function editMamblog( $id, $uid, $option, $err="", $mamblog="" ) {
	global $cfg_mamblog, $database, $sectionid;
	
	$header = _NEW_MAMBLOG;
	
	// Check if we need to read an existing Mamblog
	if ( $mamblog ) {
		$header = _EDIT_MAMBLOG;
	} else {
		$mamblog = new mosContent( $database );
		$mamblog->load( $id );
		if ( $mamblog->id && $mamblog->created_by == $uid && $mamblog->sectionid == $sectionid ) {
			$header = _EDIT_MAMBLOG;
		} else if ( $mamblog->id ) {
			$err .= "<ul><li>" . _ERR_MAMBLOGNOTFOUND. "</li></ul>";
			$mamblog = new mosContent( $database );
			$id = 0;
		} else {
			$id = 0;
		}
	}

	if ( !$mamblog->id ) {
		// New mamblog, let's set some default values.
		// Maybe the users should be able to set their own default values?
		$mamblog->bind( $cfg_mamblog['preset_values'] );
	}
	
	// We need to read the attribs of this blog.
	$attribs = mosParseParams( $mamblog->attribs );

	$errorinfo = "";
	if ( $err ) {
		showError( $err );
	}

	// Only print the form if this mamblog isn't checked out.

	// *** All html should be moved to mamblog.html.php ***

	if ($mamblog->checked_out && $mamblog->checked_out <> $uid ) {
		print _CHECKED_OUT . $mamblog->editor . _CHECKED_OUT_AT . $mamblog->checked_out_time;
	} else {

		// First we check out this item so that others won't be able to edit it.
		$mamblog->checkout( $uid );

		$head = array();
		$frm = array();
		
		if ( $cfg_mamblog['useattribs'] ) {
			// Define the html for those options the user can change
			if ( $cfg_mamblog['use_bgcolor'] ) {
				$head[] = _BGCOLOR;
				$frm[] = '<input class="inputbox" type="text" name="bgcolor" size="10" maxlength="10" value="' . @$attribs->bgcolor . '" />';
			}
			
			if ( $cfg_mamblog['use_fgcolor'] ) {
				$head[] = _FGCOLOR;
				$frm[] = '<input class="inputbox" type="text" name="fgcolor" size="10" maxlength="10" value="' . @$attribs->fgcolor . '" />';
			}
			
			if ( $cfg_mamblog['use_bordercolor'] ) {
				$head[] = _BORDERCOLOR;
				$frm[] = '<input class="inputbox" type="text" name="bordercolor" size="10" maxlength="10" value="' . @$attribs->bordercolor . '" />';
			}
			
			if ( $cfg_mamblog['use_width'] ) {
				$head[] = _WIDTH . " (" . $cfg_mamblog['min_width'] . " - " . $cfg_mamblog['max_width'] . ")";
				$frm[] = '<input class="inputbox" type="text" name="width" size="4" maxlength="4" value="' . @$attribs->width . '" />';
			}
			
			if ( $cfg_mamblog['use_height'] ) {
				$head[] = _HEIGHT . " (" . $cfg_mamblog['min_height'] . " - " . $cfg_mamblog['max_height'] . ")";
				$frm[] = '<input class="inputbox" type="text" name="height" size="4" maxlength="4" value="' . @$attribs->height . '" />';
			}
			
			if ( $cfg_mamblog['use_border'] ) {
				$borderselect = array();
				foreach ( $cfg_mamblog['border'] as $k => $v ) {
					$borderselect[] = mosHTML::makeOption( $k, $v );
				}
				$head[] = _BORDER;
				$frm[] = mosHTML::selectList( $borderselect, 'border', 'class="inputbox" size="1"', 'value', 'text', @$attribs->border );
			}
			
			if ( $cfg_mamblog['use_textalign'] ) {
				$textalignselect = array();
				foreach ( $cfg_mamblog['textalign'] as $k => $v ) {
					$textalignselect[] = mosHTML::makeOption( $k, $v );
				}
				$head[] = _TEXTALIGN;
				$frm[] = mosHTML::selectList( $textalignselect, 'textalign', 'class="inputbox" size="1"', 'value', 'text', $attribs->textalign );
			}
		}

		// make a standard yes/no list
		$yesno = array();
		$yesno[] = mosHTML::makeOption( '0', _BLOG_A_NO );
		$yesno[] = mosHTML::makeOption( '1', _BLOG_A_YES );

		$frmattribs = array();
		$headattribs = array();

		if ( $cfg_mamblog['use_allowcomments'] ) {
			$headattribs[] = _ALLOWCOMMENTS;
			$frmattribs[] = mosHTML::selectList( $yesno, 'allowcomments', 'class="inputbox" size="1"', 'value', 'text', @$attribs->allowcomments );
		}

		if ( $cfg_mamblog['use_showcomments'] ) {
			$headattribs[] = _SHOWCOMMENTS;
			$frmattribs[] = mosHTML::selectList( $yesno, 'showcomments', 'class="inputbox" size="1"', 'value', 'text', @$attribs->showcomments );
		}

		if ( $cfg_mamblog['use_frontpage'] ) {
			$headattribs[] = _FRONTPAGE;
			$frmattribs[] = mosHTML::selectList( $yesno, 'mask', 'class="inputbox" size="1"', 'value', 'text', $mamblog->mask );
		}

		if ( $cfg_mamblog['use_state'] ) {
			$headattribs[] = _PUBLISHED_HEADER;
			$state[] = mosHTML::makeOption( '0', _UNPUBLISHED );
			$state[] = mosHTML::makeOption( '1', _PUBLISHED );
			$state[] = mosHTML::makeOption( '-1', _ARCHIVED );
			$frmattribs[] = mosHTML::selectList( $state, 'state', 'class="inputbox" size="1"', 'value', 'text', $mamblog->state );
		}

		if ( $cfg_mamblog['use_access'] ) {
			$headattribs[] = _ACCESS;
			$access[] = mosHTML::makeOption( '0', _ACCESS_ALL );
			$access[] = mosHTML::makeOption( '1', _ACCESS_REGISTERED );
			$access[] = mosHTML::makeOption( '2', _ACCESS_USER );
			$frmattribs[] = mosHTML::selectList( $access, 'access', 'class="inputbox" size="1"', 'value', 'text', $mamblog->access );
		}

		// Print the edit form.
		HTML_mamblog::editBlog( $id, $mamblog, $header, $head, $frm, $headattribs, $frmattribs );
	}
}

function saveMamblog( $id, $uid, $option, $arrmamblog=array() ) {
	global $cfg_mamblog, $database, $sectionid;

	$err = "";

	// Bind the contents from the POST variables to the correct object vars.
	$mamblog = new mosContent( $database );
	$_POST['fulltext'] = $_POST['blogcontent']; // Ugly, but necessary because the first editor field can't be named 'fulltext' with the wysiwygpro editor in mambo.
	if (!$mamblog->bind( $_POST, "created created_by created_by_alias checked_out checked_out_time ordering hits publish_up publish_down modified modified_by images urls attribs version metakey metadesc" ) ) {
		$err .= "<li>" . $row->getError() . "</li>\n";
	}
	$attribs = new stdClass();
	$preset_attribs = mosParseParams( $cfg_mamblog['preset_values']['attribs'] );
	$attribs = $preset_attribs;
	$mamblog->mask = intval( $mamblog->mask );

	if ( $cfg_mamblog['use_allowcomments'] ) {
		$attribs->allowcomments = mosGetParam( $_POST, "allowcomments", $preset_attribs->allowcomments );
	}
	if ( $cfg_mamblog['use_showcomments'] ) {
		$attribs->showcomments = mosGetParam( $_POST, "showcomments", $preset_attribs->showcomments );
	}
	if ( $cfg_mamblog['useattribs'] ) {
		if ( $cfg_mamblog['use_fgcolor'] ) {
			$attribs->fgcolor = mosGetParam( $_POST, "fgcolor", $preset_attribs->fgcolor );
		}
		if ( $cfg_mamblog['use_bgcolor'] ) {
			$attribs->bgcolor = mosGetParam( $_POST, "bgcolor", $preset_attribs->bgcolor );
		}
		if ( $cfg_mamblog['use_textalign'] ) {
			$attribs->textalign = mosGetParam( $_POST, "textalign", $preset_attribs->textalign );
		}
		if ( $cfg_mamblog['use_border'] ) {
			$attribs->border = mosGetParam( $_POST, "border", $preset_attribs->border );
		}
		if ( $cfg_mamblog['use_bordercolor'] ) {
			$attribs->bordercolor = mosGetParam( $_POST, "bordercolor", $preset_attribs->bordercolor );
		}
		if ( $cfg_mamblog['use_width'] ) {
			$attribs->width = mosGetParam( $_POST, "width", $preset_attribs->width );
		}
		if ( $cfg_mamblog['use_height'] ) {
			$attribs->height = mosGetParam( $_POST, "height", $preset_attribs->height );
		}
	}

	// Always use the section in the config file.
	$mamblog->sectionid = $sectionid;

	// Now let's check that all values are within valid ranges.
	// *** This should be moved to the check() function in mosMamblog ***

	if ( $cfg_mamblog['useattribs'] ) {
		if ( $cfg_mamblog['use_border'] && !isset($cfg_mamblog['border'][$attribs->border]) ) {
			$err .= "<li>" . _ERR_WRONG_BORDER . "</li>\n";
		}
		if ( $cfg_mamblog['use_textalign'] && !isset($cfg_mamblog['textalign'][$attribs->textalign]) ) {
			$err .= "<li>" . _ERR_WRONG_TEXTALIGN . "</li>\n";
		}
		if ( $cfg_mamblog['use_fgcolor'] && ( $attribs->fgcolor != "" && !preg_match( "/^(#[0-9a-fA-F]{6}|[a-zA-Z]+)$/", $attribs->fgcolor) ) ) {
			$err .= "<li>" . _ERR_WRONG_FGCOLOR . "</li>\n";
		}
		if ( $cfg_mamblog['use_bgcolor'] && ( $attribs->bgcolor != "" && !preg_match( "/^(#[0-9a-fA-F]{6}|[a-zA-Z]+)$/", $attribs->bgcolor) ) ) {
			$err .= "<li>" . _ERR_WRONG_BGCOLOR . "</li>\n";
		}
		if ( $cfg_mamblog['use_bordercolor'] && ( $attribs->bordercolor != "" && !preg_match( "/^(#[0-9a-fA-F]{6}|[a-zA-Z]+)$/", $attribs->bordercolor) ) ) {
			$err .= "<li>" . _ERR_WRONG_BORDERCOLOR . "</li>\n";
		}
		if ( $cfg_mamblog['use_width'] && $attribs->width ) {
			if ( substr($attribs->width, -1, 1) == "%" ) {
				if ( intval( substr( $attribs->width, 0, -1 ) ) < 1 ||
					 intval( substr( $attribs->width, 0, -1 ) ) > 100 ) {
					$err .= "<li>" . _ERR_WIDTH . "</li>\n";
				}
			} else {
				if ( intval($attribs->width) < $cfg_mamblog['min_width'] || 
					 intval($attribs->width) > $cfg_mamblog['max_width'] ) {
					$err .= "<li>" . _ERR_WIDTH . "</li>\n";
				}
			}
		}
		if ( $cfg_mamblog['use_height'] && $attribs->height ) {
			if ( substr($attribs->height, -1, 1) == "%" ) {
				if ( intval( substr( $attribs->height, 0, -1 ) ) < 1 ||
					 intval( substr( $attribs->height, 0, -1 ) ) > 100 ) {
					$err .= "<li>" . _ERR_HEIGHT . "</li>\n";
				}
			} else {
				if ( intval($attribs->height) < $cfg_mamblog['min_height'] || 
					 intval($attribs->height) > $cfg_mamblog['max_height'] ) {
					$err .= "<li>" . _ERR_HEIGHT . "</li>\n";
				}
			}
		}
	}

	// The following checks for the checkboxes is just to make sure
	// noone is entering bogus values.
	if ( $cfg_mamblog['use_allowcomments'] ) {
		if ($attribs->allowcomments == "") {
			$attribs->allowcomments = 0;
		} else if ( $attribs->allowcomments != "0" && $attribs->allowcomments != "1" ) {
			$err .= "<li>" . _ERR_WRONG_ALLOWCOMMENTS . "</li>\n";
		}
	}
	if ( $cfg_mamblog['use_showcomments'] ) {
		if ($attribs->showcomments == "") {
			$attribs->showcomments = 0;
		} else if ( $attribs->showcomments != "0" && $attribs->showcomments != "1" ) {
			$err .= "<li>" . _ERR_WRONG_SHOWCOMMENTS . "</li>\n";
		}
	}
/*
	if ($attribs->archived == "") {
		$attribs->archived = 0;
	} else if ( $attribs->archived != "1" ) {
		$err .= "<li>" . _ERR_WRONG_ARCHIVED . "</li>\n";
	}
*/
	if ( $cfg_mamblog['use_state'] ) {
		if ($mamblog->state == "") {
			$mamblog->state = 0;
		} else if ( $mamblog->state != "0" && $mamblog->state != "1" && $mamblog->state != "-1" ) {
			$err .= "<li>" . _ERR_WRONG_PUBLISHED . "</li>\n";
		}
	} else {
		$mamblog->state = $cfg_mamblog['preset_values']['state'];
	}
	if ( $cfg_mamblog['use_frontpage'] ) {
		if ( $mamblog->mask != 0 && $mamblog->mask != 1 ) {
			$err .= "<li>" . _ERR_WRONG_FRONTPAGE . "</li>\n";
		}
	} else {
		$mamblog->mask = intval( $cfg_mamblog['preset_values']['frontpage'] );
	}
	if ( $cfg_mamblog['use_access'] ) {
		if ($mamblog->access == "") {
			$mamblog->access = 0;
		} else if ( $mamblog->access != "0" && $mamblog->access != "1" && $mamblog->access != "2" ) {
			$err .= "<li>" . _ERR_WRONG_ACCESS . "</li>\n";
		}
	} else {
		$mamblog->access = $cfg_mamblog['preset_values']['access'];
	}

	// Set the attribs field
	$mamblog->attribs = "";
	$mamblog->attribs .= isset($attribs->allowcomments) ? "allowcomments=$attribs->allowcomments\n" : "";
	$mamblog->attribs .= isset($attribs->showcomments) ? "showcomments=$attribs->showcomments\n" : "";
	if ( $cfg_mamblog['useattribs'] ) {
		$mamblog->attribs .= isset($attribs->textalign) ? "textalign=$attribs->textalign\n" : "";
		$mamblog->attribs .= isset($attribs->fgcolor) ? "fgcolor=$attribs->fgcolor\n" : "";
		$mamblog->attribs .= isset($attribs->bgcolor) ? "bgcolor=$attribs->bgcolor\n" : "";
		$mamblog->attribs .= isset($attribs->border) ? "border=$attribs->border\n" : "";
		$mamblog->attribs .= isset($attribs->bordercolor) ? "bordercolor=$attribs->bordercolor\n" : "";
		$mamblog->attribs .= isset($attribs->width) ? "width=$attribs->width\n" : "";
		$mamblog->attribs .= isset($attribs->height) ? "height=$attribs->height\n" : "";
	}

	if (!$mamblog->check()) {
		$err .= "<li>" . $mamblog->getError() . "</li>\n";
	}

	// If we got an error we show the edit box again, otherwise we save the info.
	if ($err) {
		$err = "<ul>" . $err . "</ul>" . _ERR_HELP;
		editMamblog( $id, $uid, $option, $err, $mamblog );
	} else {
		saveToDB( $id, $uid, $option, $mamblog );
	}
}

function saveToDB( $id, $uid, $option, $mamblog ) {
	global $database, $sectionid, $sectioncat, $mainframe;
	$time = date("Y-m-d H:i:s");

	if (!$mamblog->id) {
		$mamblog->created = $time;
		$mamblog->created_by = $uid;
	} else {
		$mamblog->modified = $time;
		$mamblog->modified_by = $uid;
	}
	$mamblog->mask = intval( $mamblog->mask );
	if ( !$mamblog->sectionid ) {
		$mamblog->sectionid = $sectionid;
	}
	if ( !$mamblog->catid ) {
		$mamblog->catid = $sectioncat;
	}

	if (!$mamblog->store()) {
		echo "<script> alert('".$mamblog->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mamblog->checkin();

	// Set frontpage setting
	require_once( $mainframe->getPath( 'class', 'com_frontpage' ) );
	$fp = new mosFrontPage( $database );
	$fpl = $fp->load( $mamblog->id );
	
	if ( $mamblog->mask && !$fpl) {
		// new entry
		$database->setQuery( "INSERT INTO #__content_frontpage VALUES ('{$mamblog->id}','0')" );
		if (!$database->query()) {
			echo "<script> alert('".$database->stderr()."');</script>\n";
			exit();
		}
		$fp->ordering = 0;
	} else if ( !$mamblog->mask && $fpl ) {
		// If this is an existing blog, remove from frontpage
		$fp->delete( $mamblog->id );
	}
	$fp->updateOrder();

	HTML_mamblog::blogMessage( _MAMBLOG_SAVED, _BLOG_SAVE );
}


/* Joomla wysiwyg editor functions */
/* ------------------------------- */

/**
 * Create place holder editor functions if they haven't been loaded by the template.
 *
 */

if ( !function_exists( "editorArea" ) ) {
	function editorArea( $name, $content, $hiddenField, $width, $height, $col, $row  ) {
		?>
	<textarea class="inputbox" name="<?php echo $hiddenField; ?>" id="<?php echo $hiddenField; ?>" cols="<?php echo $col; ?>" rows="<?php echo $row; ?>" style="width:<?php echo $width; ?>; height:<?php echo $height; ?>"><?php echo $content; ?></textarea>
        <?php
	}
}
if ( !function_exists( "initEditor" ) ) {
	function initEditor() {
	}
}
if ( !function_exists( "getEditorContents" ) ) {
	function getEditorContents( $editorArea, $hiddenField ) {
	}
}

function editorAreaJx( $name, $editorcontent, $hiddenField, $col, $row  ) {
	global $cfg_mamblog;
	$editorwidth = intval( $cfg_mamblog['editorwidth'] );
	$editorheight = intval( $cfg_mamblog['editorheight'] );

	$content = "";
	if ( strtolower( $cfg_mamblog['editor'] ) == '_jx_default' ) {
		ob_start();
		editorArea( $name, $editorcontent, $hiddenField, $editorwidth, $editorheight, $col, $row );
		$content = ob_get_contents();
		ob_end_clean();
	} else {
		$content = "<textarea class='inputbox' name='$hiddenField' id='$hiddenField' cols='$col' rows='$row' style='width: $editorwidth; height: $editorheight'>$editorcontent</textarea>";
	}
	return $content;
}

function getEditorContentsJx( $editorArea, $hiddenField ) {
	global $cfg_mamblog;

	$content = "";
	if ( strtolower( $cfg_mamblog['editor'] ) == '_jx_default' ) {
		ob_start();
		getEditorContents( $editorArea, $hiddenField );
		$content = ob_get_contents();
		ob_end_clean();
	}
	return $content;
}

function initEditorJx() {
	global $mainframe, $_VERSION, $cfg_mamblog, $mosConfig_absolute_path;

	// Make sure editor script is called.
	if (!defined( '_MOS_EDITOR_INCLUDED' )) {
		print "hej1";
		include( "$mosConfig_absolute_path/editor/editor.php" );
	}

	// Make sure that the editor will be loaded, needed for Joomla 1.0.3
	if ( $_VERSION->PRODUCT == "Joomla!" && 
		 ( ( $_VERSION->RELEASE == "1.0" && $_VERSION->DEV_LEVEL >= "3" )
		   || $_VERSION->RELEASE > "1.0" ) ) {
		$mainframe->set( 'loadEditor', true );
	}

	// Only initialize editor if editor config option is set to default Joomla editor.
	$content = "";
	if ( strtolower( $cfg_mamblog['editor'] ) == '_jx_default' ) {
		ob_start();
		initEditor();
		$content = ob_get_contents();
		ob_end_clean();
	}
	return $content;
}

?>
<?php
/**
* FileName: showblogs.php
*	Date: 10-19-2003
* License: GNU General Public License
* Script Version #: 1.0
* MOS Version #: 4.5
* Script TimeStamp: "10/19/2003 14:08PM"
* Original Script: Olle Johansson - Olle@Johansson.com
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

switch( $action ) {
	case "user":
		listBlogs( $id, $my->id, $option, $gid, "user", $sort, $ignorecount ); break;
	case "userarchive":
		listBlogs( $id, $my->id, $option, $gid, "userarchive", $sort, $ignorecount ); break;
	case "view":
		showBlog( intval($id), $my->id, $option, $gid, 0 ); break;
	case "comment":
		showBlog( intval($id), $my->id, $option, $gid, 0, 1 ); break;
	case "bydate":
		listBlogs( $id, $my->id, $option, $gid, "date", $sort, $ignorecount ); break;
	case "all":
		listBlogs( 0, $my->id, $option, $gid, "all", $sort, $ignorecount ); break;
	case "frontpage":
		listBlogs( 0, $my->id, $option, $gid, "frontpage", $sort, $ignorecount ); break;
	case "showmyblog":
		listBlogs( $my->id, $my->id, $option, $gid, "user", $sort, $ignorecount ); break;
	case "showmyarchive":
		listBlogs( $my->id, $my->id, $option, $gid, "userarchive", $sort, $ignorecount ); break;
	default:
		if ( $showdefault == "user" || $showdefault == "userarchive" ) {
			$id = $specified;
		}
		else if ( $showdefault == "date" ) {
			if ( is_date( "$specified 00:00:00" ) ) {
				$id = $specified;
			} else {
				$id = date("Y-m-d");
			}
		}
		else {
			$id = 0;
		}
		listBlogs( $id, $my->id, $option, $gid, $showdefault, $sort, $ignorecount );
}

function showBlog( $id, $uid, $option, $gid, $mask=0, $notext=0 ) {
	global $cfg_mamblog, $database, $mainframe, $sectionid;
	global $mosConfig_hideAuthor, $mosConfig_hideCreateDate, $mosConfig_hideModifyDate;

	#$mask = MASK_BACKTOLIST|MASK_PRINT|MASK_MAIL|MASK_IMAGES;
	$mask = MASK_BACKTOLIST|MASK_IMAGES;
	$mask |= $mosConfig_hideAuthor ? MASK_HIDEAUTHOR : 0;
	$mask |= $mosConfig_hideCreateDate ? MASK_HIDECREATEDATE : 0;
	$mask |= $mosConfig_hideModifyDate ? MASK_HIDEMODIFYDATE : 0;

	$authorfield = "name";
	if ( $cfg_mamblog['showusername'] ) {
		$authorfield = "username";
	}

	$database->setQuery( "SELECT a.*, u.$authorfield AS author, u.usertype"
	. "\nFROM #__content AS a"
	. "\nLEFT JOIN #__users AS u ON u.id = a.created_by"
	. "\nWHERE (a.id='$id') "
	. "\n\tAND ( u.id='$uid' OR ( a.state='1' AND a.access <= $gid ) )"
	. "\n\tAND a.sectionid='{$sectionid}'"
	);
	$row = null;
	$database->loadObject( $row );

	if ( $row->id ) {
		if ( $notext ) {
			$row->text = "";
		} else {
			if ( $mask&MASK_READON ) {
				$row->text = $row->introtext;
			} else {
				$row->text = $row->introtext . $row->fulltext;
			}
		}

		show( $row, $mask, $gid, $option, 1 );
	} else {
		showError( _BLOG_NOTFOUND );
	}
}

function listBlogs( $id, $uid, $option, $gid, $type="", $sort="", $ignorecount=0 ) {
	global $cfg_mamblog, $database, $mainframe, $sectionid;
	global $mosConfig_hideAuthor, $mosConfig_hideCreateDate, $mosConfig_hideModifyDate;
	global $count, $intro, $image, $Itemid;

	$access = !$mainframe->getCfg( 'shownoauth' );	// requires honouring of access
	
	#$mask = MASK_PRINT|MASK_MAIL|MASK_IMAGES;
	#$mask = MASK_READON;
	$mask = 0;
	$mask |= $mosConfig_hideAuthor ? MASK_HIDEAUTHOR : 0;
	$mask |= $mosConfig_hideCreateDate ? MASK_HIDECREATEDATE : 0;
	$mask |= $mosConfig_hideModifyDate ? MASK_HIDEMODIFYDATE : 0;

	$authorfield = "name";
	if ( $cfg_mamblog['showusername'] ) {
		$authorfield = "username";
	}

	if ( $type == "user" || $type == "userarchive" ) {
		if ( intval($id) > 0 ) {
			$userwhere = "id='$id'";
		} else {
			$id = urldecode($id);
			$userwhere = "username='$id'";
		}
		$database->setQuery("SELECT id, $authorfield AS author FROM #__users WHERE $userwhere");
		$userobj = null;
		if ( !$database->loadObject( $userobj ) ) {
			showError( _BLOG_USERNOTFOUND . ": " . $id );
			return false;
		}
		$id = $userobj->id;
	}

	$where = array();
	if ( $type == "userarchive" ) {
		$where[] = "a.state=-1";
	} else {
		// Show all of this users blogs but only published blogs by others.
		if ( $uid ) {
			$where[] = "( a.state=1 OR ( a.state>=0 AND a.created_by = '$uid' ) )";
		} else {
			$where[] = "a.state=1";
		}
	}
	if ( $id != $uid ) {
		$where[] = "(a.publish_up = '0000-00-00 00:00:00' OR a.publish_up <= NOW())";
		$where[] = "(a.publish_down = '0000-00-00 00:00:00' OR a.publish_down >= NOW())";
	}
	if ( $access ) {
		$where[] = "a.access<='$gid'";
	}
	if ( ( $type == "user" || $type == "userarchive" ) && intval( $id ) ) {
		$where[] = "a.created_by='$id'";
	}
	if ( $type == "date") {
		if ( is_date( "$id 00:00:00" ) ) {
			$where[] = "( (a.publish_up = '0000-00-00 00:00:00' AND "
				. "a.created >= '$id 00:00:00' AND a.created <= '$id 23:59:59') "
				. " OR ( a.publish_up >= '$id 00:00:00' AND a.publish_up <= '$id 23:59:59' ) )";
		} else {
			showError( _BLOG_WRONGDATE . " $id" );
			return false;
		}
	}
	#if ( $type == "frontpage" ) {
	#	$where[] = "a.mask = 1";
	#}
	// Only list items in the mamblog section.
	$where[] = "a.sectionid='{$sectionid}'";

	// Set the order by
	switch ($sort) {
		case "datedesc":
			$orderby = "a.created DESC"; break;
		case "dateasc":
			$orderby = "a.created ASC"; break;
		case "ordering":
			$orderby = "a.catid, a.ordering ASC"; break;
		case "orderingdesc":
			$orderby = "a.catid, a.ordering DESC"; break;
		default:
			$orderby = "a.created DESC"; break;
	}

	// Count the blog entries
	$database->setQuery( "SELECT COUNT(*)"
						 . "\nFROM #__content AS a"
						 . "\nLEFT JOIN #__users AS u ON u.id = a.created_by"
						 . (count( $where ) ? "\nWHERE ".implode( "\n	AND ", $where ) : '')
		);
	$blogentries = $database->loadResult();

	// Should we list all entries?
	if ( $ignorecount ) {
		$count = $blogentries;
		$intro = $count;
	}

	// Set the limit so we won't get more items than necessary
	$limit = "";
	if ( $count != $blogentries && intval( $count ) > 0 ) {
		$limit = "LIMIT $count";
	}


	// get the list of items for this category
	$database->setQuery( "SELECT a.*, u.$authorfield AS author, u.usertype"
	. "\nFROM #__content AS a"
	. "\nLEFT JOIN #__users AS u ON u.id = a.created_by"
	. (count( $where ) ? "\nWHERE ".implode( "\n	AND ", $where ) : '')
	. "\nORDER BY $orderby $limit"
	);
	$rows = $database->loadObjectList();

	$n = min( count( $rows ), $count );

	switch ( $type ) {
		case "user":
			$header = _BLOG_SHOWBLOGFROMUSER . " " . $userobj->author; break;
		case "userarchive":
			$header = _BLOG_SHOWUSERARCHIVE . " " . $userobj->author; break;
		case "date":
			$header = _BLOG_SHOWBYDATE . " " . mosFormatDate($id); break;
		default:
			#$header = _BLOG_SHOWALL;
			$header = $cfg_mamblog['header'];
	}
	print "<div class=\"componentheading\">$header</div>\n";

	if ( $n > 0 ) {

		$col = intval( $cfg_mamblog['itemstructure'] );
		if ( $col == 1 ) {
			for ( $i=0; $i<$intro; $i++ ) {
				if ( $i >= $n ) break;
				$text = $rows[$i]->introtext . $rows[$i]->fulltext;
				$rows[$i]->text = checkLength( $text );
				show( $rows[$i], $mask|$image, $gid, $option );
			}
			if ( $i < $n ) {
				print "<br clear='all' />";
				HTML_mamblog::showLinks( $rows, $intro, $n );
			}
		} else {
			echo "\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";

			$i2=0;
			$n2=$n;
			$intro2 = $intro;
			// Leading story
			if ( $col == 3 ) {
				$text = $rows[$i2]->introtext . $rows[$i2]->fulltext;
				$rows[$i2]->text = checkLength( $text );
				echo "<tr>\n";
				echo "<td valign=\"top\" colspan=\"2\">\n";
				show( $rows[$i2], $mask|$image, $gid, $option );
				echo "</td>\n";
				echo "</tr>\n";
				$i2++;
				$n2--;
				$intro2--;
			}

			for ( $i=0 ; $i < $n2; $i++ ) {
				if (!($i%2) || $col==1) {
					echo "<tr>\n";
				}
		
				echo $col==1 ? "<td valign=\"top\">\n" : "<td width=\"50%\" valign=\"top\">\n";
				if ($i < $intro2) {
					$text = $rows[$i+$i2]->introtext . $rows[$i+$i2]->fulltext;
					$rows[$i+$i2]->text = checkLength( $text );
					show( $rows[$i+$i2], $mask|$image, $gid, $option );
				} else {
					HTML_mamblog::showLinks( $rows, $intro, $n );
					echo "</td>\n</tr>\n";
					break;
				}
				echo "</td>\n";
		
				if (($i%2) || $col==1) {
					echo "</tr>\n";
				}
			}
			if ( $i%2 ) {
				echo "<td></td></tr>\n";
			}
	
			echo "\n</table>";
		}

		// Add link to all blogs if all aren't listed
		if ( $count < $blogentries ) {
			echo "<br clear='all' /><a href='" . sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=$type&amp;id=$id&amp;ignorecount=1" ) . "'><strong>" . _BLOG_SHOWALLENTRIES . "</strong></a><br />";
			
		}
	} else {
		echo _BLOG_NOBLOGSFOUND;
	}

	if ( $cfg_mamblog['showarchivelink'] && $type == "user" && intval( $id ) ) {
		echo "<br clear='all' /><a href='" . sefRelToAbs( "index.php?option=$option&amp;Itemid=$Itemid&amp;task=show&amp;action=userarchive&amp;id=$id" ) . "'><strong>" . _BLOG_USERARCHIVE . "</strong></a><br />";
	}
}

/** Show a link to comments/comment field if necessary
 *  @param int Id of article to show comments for.
 */
function showCommentLink( $id ) {
	global $mosConfig_absolute_path, $cfg_mamblog, $database, $Itemid;

	switch( $cfg_mamblog['commentsystem'] ) {
		case "combo":
			$database->setQuery("SELECT COUNT(*) FROM #__content_comments WHERE articleid = '$id'");
			$count = intval( $database->loadResult() );
			$link = "<a href=\"" . sefRelToAbs( "index.php?option=com_content&amp;Itemid=$Itemid&amp;task=view&amp;id=$id" ) . "\">";
			HTML_mamblog::showCommentLink( $id, $count, $link );
			break;
		case "mxcomment":
			$database->setQuery( "SELECT count(*) FROM #__mxcomment WHERE component='com_mamblog' AND contentid='$id' AND published='1'" );
			$count = intval( $database->loadResult() );
			$link = "<a href=\"" . sefRelToAbs( "index.php?option=com_mamblog&amp;Itemid=$Itemid&amp;task=show&amp;action=comment&amp;id=$id" ) . "\">";
			HTML_mamblog::showCommentLink( $id, $count, $link );
			break;
		case "akocomment":
			$database->setQuery( "SELECT count(*) FROM #__akocomment WHERE contentid='$id' AND published='1'" );
			$count = intval( $database->loadResult() );
            # Load configuration file for AkoComment
			include( $mosConfig_absolute_path."/administrator/components/com_akocomment/config.akocomment.php" );
			if ($ac_openingmode) {
				$link = "<a href=\"javascript:void window.open('index2.php?option=com_content&task=view&id=$id&pop=1&page=0', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\">";
			} else {
				$link = "<a href='".sefRelToAbs("index.php?option=com_content&task=view&id=$id")."'>";
			}
			HTML_mamblog::showCommentLink( $id, $count, $link );
			break;
		//added for Joomlaboard support as commenting system
		case "joomlaboard":
			$database->setQuery ("SELECT id, title, sectionid FROM #__content WHERE id = '$id'");
			$row=$database->loadObjectList();
			if (count($row)>0) $row=$row[0];
		//echo "<br/>query== SELECT id, title, sectionid FROM jos_content WHERE id = '$id'<br/><br/>";
		//var_dump ($row);
		//die("<br/>stop here");
            $showbottext = makeForumLink( $cfg_mamblog['joomlaboardid'], $row);
            HTML_mamblog::showForumLink( $showbottext );
		   break;			
		default:
	}
}

/**
 * Show a given blog entry.
 * @param object Blog entry object to show
 * @param int Mask to define viewing options
 * @param int Group id
 * @param string Name of this component to use in links etc.
 */
function show( $row, $mask=0, $gid, $option, $showcommentform=0 ) {
	global $cfg_mamblog, $database, $mainframe, $my, $mosConfig_absolute_path, $mosConfig_live_site, $pop, $action;

	$access = !$mainframe->getCfg( 'shownoauth' );	// requires honouring of access
	
	if ($row->created_by != $my->id && $row->access > $gid) {
		if ($access) {
			echo _NOT_AUTH;
			return;
		} else {
			if (!($mask&MASK_READON)) {
				echo _NOT_AUTH;
				return;
			}
		}
	}

/*
	if ( $mask&MASK_READON ) {
		$row->text = $row->introtext;
	} else {
		$row->text = $row->introtext . $row->fulltext;
	}
*/

	// record the hit
	if (!($mask&MASK_READON)) {
		$obj = new mosContent( $database );
		$obj->hit( $row->id );
	}

	$params =& new mosParameters( $row->attribs );
	if ( $params->get('showcomments') == "1" && $showcommentform ) {
		if (  $cfg_mamblog['commentsystem'] == "akocomment" ) {
			if ( file_exists( "$mosConfig_absolute_path/mambots/content/akocommentbot.php" ) ) {
				include "$mosConfig_absolute_path/mambots/content/akocommentbot.php";
				global $option, $task;
				$old = array( $option, $task );
				$option = "com_content"; $task = "view";
				botAkoComment( 1, $row, $params, 0 );
				$option = $old[0]; $task = $old[1];
			}
		}
	}

	HTML_mamblog::show( $row, $mask, $gid, $option );
	if ( $params->get('showcomments') == "1" && $action != "comment" && !$showcommentform ) {
		showCommentLink( $row->id );
	}
}

/**
 * Convert html entities to their corresponding characters.
 * Only needed in PHP < 4.3.0.
 * Taken from a comment in the PHP manual.
 */
function decodeEntities ($string, $opt = ENT_COMPAT) {
	if (phpversion() >= "4.3.0") {
		$string = html_entity_decode ($string, $opt);
		return $string;
	} else {

		$trans_tbl = get_html_translation_table (HTML_ENTITIES);
		$trans_tbl = array_flip ($trans_tbl);
		
		if ($opt & 1) { // Translating single quotes

			// Add single quote to translation table;
			// doesn't appear to be there by default
			$trans_tbl["&apos;"] = "'";
		}
		
		if (!($opt & 2)) { // Not translating double quotes
			
			// Remove double quote from translation table
			unset($trans_tbl["&quot;"]);
		}

		return strtr ($string, $trans_tbl);
	}
}
// Just to be safe ;o)
if (!defined("ENT_COMPAT")) define("ENT_COMPAT", 2);
if (!defined("ENT_NOQUOTES")) define("ENT_NOQUOTES", 0);
if (!defined("ENT_QUOTES")) define("ENT_QUOTES", 3);

/**
 * Strips tags without removing possible white space between words.
 *
 * @param string String to strip tags from.
 */
function safeStrip( $text ) {
	#$text = strip_tags( $text );
	$text = preg_replace( '/</', ' <', $text);
	$text = preg_replace( '/>/', '> ', $text);
	$desc = decodeEntities( strip_tags( $text ) );
	#$desc = preg_replace( '/[\n\r\t]/', ' ', $desc );
	$desc = preg_replace( '/  /', ' ', $desc );

	return $desc;
}

/**
 * Strips a string down to the maximum allowed length, if necessary.
 *
 * @param string The string to check the length of.
 */
function checkLength( $text ) {
	global $cfg_mamblog;
	
	$maxchars = intval( $cfg_mamblog['maxchars'] );
	$newtext = safeStrip( $text );
	$strlen = strlen( $newtext );

	if ( $maxchars > 0 && $maxchars < $strlen ) {
		$text = substr( $newtext, 0, $maxchars ) . "...";
		$text .= " (" . ( $strlen - $maxchars ) . " " . _BLOG_MORE_CHARS . ")";
	} else {
		$text = safeStrip( $text );
	}

	return $text;
}


/**
 * Creates a link to a Joomlaboard discussion thread about this blog entry.
 */
function makeForumLink( $catid, &$row ) {
	global $database, $mainframe, $my, $mosConfig_absolute_path;

	// Include the joomlaboard config file
	if ( file_exists( $mosConfig_absolute_path.'/administrator/components/com_joomlaboard/joomlaboard_config.php' ) ) {
		include( $mosConfig_absolute_path.'/administrator/components/com_joomlaboard/joomlaboard_config.php' );
	}
	else {
		return 'Error, missing joomlaboard config file!';
	}

	$sbConfig_lang = $mainframe->getCfg( 'lang' );
	if ( file_exists( $mosConfig_absolute_path.'/administrator/components/com_joomlaboard/language/'.$sbConfig_lang.'.php' ) ) {
		include_once( $mosConfig_absolute_path.'/administrator/components/com_joomlaboard/language/'.$sbConfig_lang.'.php' );
	} else {
		include_once( $mosConfig_absolute_path.'/administrator/components/com_joomlaboard/language/english.php' );
	}

	if ( !$sbConfig['discussBot'] ) {
		return '';
	}

	$database->setQuery( "SELECT id FROM #__menu WHERE link='index.php?option=com_joomlaboard'" );
	$Itemid = $database->loadResult();

	// Check if the subject as content title exists in the messages table
	$database->setQuery( "SELECT id"
						 . "\nFROM #__sb_messages"
						 . "\nWHERE catid = ".$catid." AND subject = '".$row->title."'" );
	$resultid = $database->loadResult();


    if ( $resultid == "" ) {
		// If there is no result from the first query let the link open a new reply possibility
		$showlink = sefRelToAbs("index.php?option=com_joomlaboard&Itemid=" . $Itemid
								. "&func=post&do=newFromBot&resubject=".strtr( base64_encode( $row->title ), "+/", "()")
								. "&catid=".$catid
								. "&rowid=".$row->id
								. "&rowItemid=".$row->sectionid
								. "&mamblog=1"
			);
		$countPosts=0;
	} else {
		// If there is no result from the first query do an insert and get the new id
		$database->setQuery( "SELECT count(id) from #__sb_messages where thread=$resultid" );
		$countPosts = $database->loadResult();
		// Create the sef link and return it
		$showlink = sefRelToAbs("index.php?option=com_joomlaboard&Itemid=" . $Itemid
								. "&func=view"
								. "&id=" . $resultid
								. "&catid=" . $catid
								. "&mamblog=1"
			);
		
	}

	//return ' Title='.$title.' - Resultid='.$resultid.' <A HREF="'.$showlink.'">'._MOSBOT_DISCUSS_A.''._MOSBOT_DISCUSS_B.'</a> ';
	return '<a href="'.$showlink.'">'._MOSBOT_DISCUSS_A.''.$countPosts.''._MOSBOT_DISCUSS_B.'</a>';

}


/*
if ( $my->id ) {
   $database->setQuery( "SELECT id, title, description, finished_by, priority FROM #__todo"
   . "\nWHERE created_by = '$my->id'"
   . "\nORDER BY priority DESC, ordering ASC"
   );
   $blogs = $database->loadObjectList();
   displayTodoList( $blogs );
}
*/

?>
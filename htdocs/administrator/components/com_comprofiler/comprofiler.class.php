<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: comprofiler.class.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage comprofiler.class.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$ueConfig['version']='1.1';

/** @global int $_CB_OneTwoRowsStyleToggle */
/** @global int $_CB_ProfileItemid */
/** @global array $_CB_outputedHeads storing already outputed items in head to output only once and avoid double-outputing */
global $_CB_PMS, $_CB_OneTwoRowsStyleToggle, $_CB__Cache_ProfileItemid, $_CB_outputedHeads, $_CB_ui;
// $_CB_PMS = new cbPMS();					// moved at end of file
$_CB_OneTwoRowsStyleToggle	=	1;			// toggle for status sectionTableEntry display
$_CB_outputedHeads			=	array();
$_CB__Cache_ProfileItemid	=	null;

/**
 * gets Itemid of CB profile, or by default of homepage
 * @param boolean TRUE if should return "&amp:Itemid...." instead of "&Itemid..." (with FALSE as default), === 0 if return only int
 * @return string "&Itemid=xxx"
 */
function getCBprofileItemid( $htmlspecialchars= false ) {
	global $_CB__Cache_ProfileItemid, $_CB_database;
	
	if ( $_CB__Cache_ProfileItemid === null ) {
		if( ! isset( $_REQUEST['Itemid'] ) ) {
			$_CB_database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1");
			$Itemid = (int) $_CB_database->loadResult();
		} else {
			$Itemid = (int) cbGetParam( $_REQUEST, 'Itemid', 0 );
		}
		if ( ! $Itemid ) {		// if no user profile, try getting itemid of the default list:
			$_CB_database->setQuery("SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler&task=usersList' AND published=1");
			$Itemid = (int) $_CB_database->loadResult();
		}
		if ( ! $Itemid ) {
			/** Nope, just use the homepage then. */
			$query = "SELECT id"
			. "\n FROM #__menu"
			. "\n WHERE menutype = 'mainmenu'"
			. "\n AND published = 1"
			. "\n ORDER BY parent, ordering"
			. "\n LIMIT 1"
			;
			$_CB_database->setQuery( $query );
			$Itemid = (int) $_CB_database->loadResult();
		}
		$_CB__Cache_ProfileItemid = $Itemid;
	}
	if ( $_CB__Cache_ProfileItemid ) {
		if ( is_bool( $htmlspecialchars ) ) {
			return ( $htmlspecialchars ? "&amp;" : "&") . "Itemid=" . $_CB__Cache_ProfileItemid;
		} else {
			return $_CB__Cache_ProfileItemid;
		}
	} else {
		return null;
	}
}


/** mosMail():
*	1) was copying BCC fields int CC
*	2) did not include the ReplyTo field, to avoid having to spoof an email address.
*	MF bug id #7713.
*/


/**
* Function to create a mail object for futher use (uses phpMailer)
* @param string From e-mail address
* @param string From name
* @param string E-mail subject
* @param string Message body
* @return object Mail object
*/
function comprofilerCreateMail( $from='', $fromname='', $subject, $body ) {
	global $mainframe, $mosConfig_sendmail;
	global $mosConfig_smtpauth, $mosConfig_smtpuser;
	global $mosConfig_smtppass, $mosConfig_smtphost;
	global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailer;

	$mail = new mosPHPMailer();

	$mail->PluginDir = $mainframe->getCfg('absolute_path') .'/includes/phpmailer/';
	$mail->SetLanguage( 'en', $mainframe->getCfg('absolute_path') . '/includes/phpmailer/language/' );
	$mail->CharSet 	= substr_replace(_ISO, '', 0, 8);
	$mail->IsMail();
	$mail->From 	= $from ? $from : $mosConfig_mailfrom;
	$mail->FromName = $fromname ? $fromname : $mosConfig_fromname;
	$mail->Mailer 	= $mosConfig_mailer;

	// Add smtp values if needed
	if ( $mosConfig_mailer == 'smtp' ) {
		$mail->SMTPAuth = $mosConfig_smtpauth;
		$mail->Username = $mosConfig_smtpuser;
		$mail->Password = $mosConfig_smtppass;
		$mail->Host 	= $mosConfig_smtphost;
	} else

	// Set sendmail path
	if ( $mosConfig_mailer == 'sendmail' ) {
		if (isset($mosConfig_sendmail))
			$mail->Sendmail = $mosConfig_sendmail;
	} // if

	$mail->Subject 	= $subject;
	$mail->Body 	= $body;

	return $mail;
}

/**
* Mail function (uses phpMailer)
* @param string From e-mail address
* @param string From name
* @param string/array Recipient e-mail address(es)
* @param string E-mail subject
* @param string Message body
* @param boolean false = plain text, true = HTML
* @param string/array CC e-mail address(es)
* @param string/array BCC e-mail address(es)
* @param string/array Attachment file name(s)
* @param string/array ReplyTo e-mail address(es)
* @param string/array ReplyTo name(s)
*/
function comprofilerMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=NULL, $bcc=NULL, $attachment=NULL, $replyto=NULL, $replytoname=NULL ) {
	global $mosConfig_debug;
	$mail = comprofilerCreateMail( $from, $fromname, $subject, $body );

	// activate HTML formatted emails
	if ( $mode ) {
		$mail->IsHTML(true);
	}

	if( is_array($recipient) ) {
		foreach ($recipient as $to) {
			$mail->AddAddress($to);
		}
	} else {
		$mail->AddAddress($recipient);
	}
	if (isset($cc)) {
	    if( is_array($cc) )
	        foreach ($cc as $to) $mail->AddCC($to);
	    else
	        $mail->AddCC($cc);
	}
	if (isset($bcc)) {
	    if( is_array($bcc) )
	        foreach ($bcc as $to) $mail->AddBCC($to);
	    else
	        $mail->AddBCC($bcc);
	}
    if ($attachment) {
        if ( is_array($attachment) )
            foreach ($attachment as $fname) $mail->AddAttachment($fname);
        else
            $mail->AddAttachment($attachment);
    } // if
    if ($replyto) {
        if ( is_array($replyto) ) {
        	reset($replytoname);
            foreach ($replyto as $to) {
            	$toname = ((list($key, $value) = each($replytoname)) ? $value : "");
            	$mail->AddReplyTo($to, $toname);
            }
        } else
            $mail->AddReplyTo($replyto, $replytoname);
    }
	$mailssend = $mail->Send();

	if( $mosConfig_debug ) {
		//$mosDebug->message( "Mails send: $mailssend");
	}
	if( $mail->error_count > 0 ) {
		//$mosDebug->message( "The mail message $fromname <$from> about $subject to $recipient <b>failed</b><br /><pre>$body</pre>", false );
		//$mosDebug->message( "Mailer Error: " . $mail->ErrorInfo . "" );
	}
	return $mailssend;
} // mosMail

/** END OF MAMBO CORE BUGS CORRECTIONS !
*/


class moscomprofilerHTML extends mosHTML {

	function radioListArr( &$arr, $tag_name, $tag_attribs, $key, $text, $selected, $required=0 ) {
		reset( $arr );
		$html = array();
		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = stripslashes($arr[$i]->$key);
			$t = stripslashes($arr[$i]->$text);
			if ( isset($arr[$i]->id) ) {
				$id = $arr[$i]->id;
			} else {
				$id = str_replace( array( '[', ']'), array( '_', '_' ), $tag_name ) . $i;
			}
			$extra = " id=\"" . $id . "\"";

			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					$k2 = stripslashes($obj->$key);
					if ($k == $k2) {
						$extra .= " checked=\"checked\"";
						break;
					}
				}
			} else {
				$extra .= ($k == stripslashes($selected) ? "  checked=\"checked\"" : '');
			}
			if ( $required && ( $i == 0 ) ) {
				$isReq="mosReq=\"".$required."\"";
			} else {
				$isReq="";
			}
			$html[] = "<input type=\"radio\" name=\"$tag_name\" $isReq $tag_attribs value=\"" . $k . "\"$extra /> <label for=\"" . $id . "\">" . getLangDefinition($t) . "</label>";
		}
		return $html;
	}
	function radioList( $arr, $tag_name, $tag_attribs, $key, $text, $selected, $required=0 ) {
		return "\n\t".implode("\n\t ", moscomprofilerHTML::radioListArr( $arr, $tag_name, $tag_attribs, $key, $text, $selected, $required ))."\n";
	}
	function radioListTable( $arr, $tag_name, $tag_attribs, $key, $text, $selected, $cols=0, $rows=1, $size=0, $required=0 ) {
		$cellsHtml = moscomprofilerHTML::radioListArr( $arr, $tag_name, $tag_attribs, $key, $text, $selected, $required );
		return moscomprofilerHTML::list2Table( $cellsHtml, $cols, $rows, $size );
	}
	function selectList( $arr, $tag_name, $tag_attribs, $key, $text, $selected, $required=0 ) {
		reset( $arr );
		$html = "\n<select name=\"$tag_name\" $tag_attribs>";
		if(!$required) $html .= "\n\t<option value=\"\"> </option>";

		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = stripslashes($arr[$i]->$key);
			$t = stripslashes($arr[$i]->$text);
			$id = isset($arr[$i]->id) ? $arr[$i]->id : null;

			$extra = '';
			$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					if ( is_object( $obj ) ) {
						$k2		=	$obj->$key;
					} else {
						$k2		=	$obj;
					}
					if ($k == $k2) {
						$extra	.=	" selected=\"selected\"";
						break;
					}
				}
			} else {
				$extra .= ($k == stripslashes($selected) ? " selected=\"selected\"" : '');
			}
			$html .= "\n\t<option value=\"".$k."\"$extra>";
			$html .= getLangDefinition($t);
			$html .= "</option>";
		}
		$html .= "\n</select>\n";
		return $html;
	}
	function checkboxListArr( $arr, $tag_name, $tag_attribs,  $key='value', $text='text',$selected=null, $required=0  ) {
		reset( $arr );
		$html = array();
		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = $arr[$i]->$key;
			$t = $arr[$i]->$text;
			if ( isset($arr[$i]->id) ) {
				$id = $arr[$i]->id;
			} else {
				$id = str_replace( array( '[', ']'), array( '_', '_' ), $tag_name ) . $i;
			}
			$extra = " id=\"" . $id . "\"";

			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					if ( is_object( $obj ) ) {
						$k2		=	$obj->$key;
					} else {
						$k2		=	$obj;
					}
					if ($k == $k2) {
						$extra	.=	" checked=\"checked\"";
						break;
					}
				}
			} else {
				$extra .= ($k == $selected ? " checked=\"checked\"" : '');
			}
			if ( $required && ( $i == 0 ) ) {
				$isReq="mosReq=\"".$required."\"";
			} else {
				$isReq="";
			}
			$html[] = "<input type=\"checkbox\" name=\"$tag_name\" $isReq value=\"".$k."\"$extra $tag_attribs /> <label for=\"" . $id . "\">" . getLangDefinition($t) . "</label>";
		}
		return $html;
	}
	function checkboxList( $arr, $tag_name, $tag_attribs,  $key='value', $text='text',$selected=null, $required=0 ) {
		return "\n\t".implode("\n\t", moscomprofilerHTML::checkboxListArr( $arr, $tag_name, $tag_attribs,  $key, $text,$selected, $required ))."\n";
	}
	function checkboxListTable( $arr, $tag_name, $tag_attribs,  $key='value', $text='text',$selected=null, $cols=0, $rows=0, $size=0, $required=0 ) {
		$cellsHtml = moscomprofilerHTML::checkboxListArr( $arr, $tag_name, $tag_attribs,  $key, $text,$selected, $required );
		return moscomprofilerHTML::list2Table( $cellsHtml, $cols, $rows, $size );
	}
	// private methods:
	function list2Table ( $cellsHtml, $cols, $rows, $size ) {
		$cells = count($cellsHtml);
		if ($size == 0) {
			$localstyle = ""; //" style='width:100%'";
		} else {
			$size = (($size-($size % 3)) / 3  ) * 2; // int div  3 * 2 width/heigh ratio
			$localstyle = " style='width:".$size."em;'";
		}
		$return="";
		if ($cells) {
			if ($rows) {
				$return = "\n\t<table class='cbMulti'".$localstyle.">";
				$cols = ($cells-($cells % $rows)) / $rows;	// int div
				if ($cells % $rows) $cols++;
				$lineIdx=0;
				for ($lineIdx=0 ; $lineIdx < min($rows, $cells) ; $lineIdx++) {
					$return .= "\n\t\t<tr>";
					for ($i=$lineIdx ; $i < $cells; $i += $rows) {
						$return .= "<td>".$cellsHtml[$i]."</td>";
					}
					$return .= "</tr>\n";
				}
				$return .= "\t</table>\n";
			} else if ($cols) {
				$return = "\n\t<table class='cbMulti'".$localstyle.">";
				$idx=0;
				while ($cells) {
					$return .= "\n\t\t<tr>";
					for ($i=0, $n=min($cells,$cols); $i < $n; $i++, $cells-- ) {
						$return .= "<td>".$cellsHtml[$idx++]."</td>";
					}
					$return .= "</tr>\n";
				}
				$return .= "\t</table>\n";
			} else {
				$return = "\n\t".implode("\n\t ", $cellsHtml)."\n";
			}
		}
		return $return;
	}
} // end class moscomprofilerHTML

class moscomprofilerPlugin extends comprofilerDBTable {
	/** @var int */
	var $id=null;
	/** @var varchar */
	var $name=null;
	/** @var varchar */
	var $element=null;
	/** @var varchar */
	var $type=null;
	/** @var varchar */
	var $folder=null;
	/** @var varchar */
	var $backend_menu=null;
	/** @var tinyint unsigned */
	var $access=null;
	/** @var int */
	var $ordering=null;
	/** @var tinyint */
	var $published=null;
	/** @var tinyint */
	var $iscore=null;
	/** @var tinyint */
	var $client_id=null;
	/** @var int unsigned */
	var $checked_out=null;
	/** @var datetime */
	var $checked_out_time=null;
	/** @var text */
	var $params=null;
	/**
	* Constructor
	*/
	function moscomprofilerPlugin( &$db ) {
		$this->comprofilerDBTable( '#__comprofiler_plugin', 'id', $db );
	}
}

class moscomprofilerLists extends comprofilerDBTable {

   var $listid=null;
   var $title=null;
   var $description=null;
   var $published=null;
   var $default=null;
   var $usergroupids=null;
   var $useraccessgroupid=null;
   var $sortfields=null; 
   var $filterfields=null; 
   var $ordering=null;
   var $col1title=null;
   var $col1enabled=null;
   var $col1fields=null;
   var $col1captions=null;
   var $col2title=null;
   var $col2enabled=null;
   var $col2fields=null;
   var $col2captions=null;
   var $col3title=null;
   var $col3enabled=null;
   var $col3fields=null;
   var $col3captions=null;
   var $col4title=null;
   var $col4enabled=null;
   var $col4fields=null;
   var $col4captions=null;

    /**
    * Constructor
    * @param database A database connector object
    */
	function moscomprofilerLists( &$db ) {
	
		$this->comprofilerDBTable( '#__comprofiler_lists', 'listid', $db );
	
	} //end func

	function store( $listid=0, $updateNulls=false) {
			global $_CB_database, $_POST;
	
		if ( ( ! isset( $_POST['listid'] ) ) || $_POST['listid'] == null || $_POST['listid'] == '' ) {
			$this->listid = (int) $listid;
		} else {
			$this->listid = (int) cbGetParam( $_POST, 'listid', 0 );
		}
		$sql="SELECT COUNT(*) FROM #__comprofiler_lists WHERE listid = ".  (int) $this->listid;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if($this->default==1) {
			$sql="UPDATE #__comprofiler_lists SET `default` = 0";
			$_CB_database->SetQuery($sql);
			$_CB_database->query();
		}
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
			
		} else {
			// new record
			$sql="SELECT MAX(ordering) FROM #__comprofiler_lists";
			$_CB_database->SetQuery($sql);
			$max = $_CB_database->LoadResult();
			$this->ordering=$max+1;
			$this->listid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if ( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}


} //end class

class moscomprofilerFields extends comprofilerDBTable {

   var $fieldid		= null;
   var $name		= null;
   var $table		= null;
   var $title		= null;
   var $description	= null;
   var $type		= null;
   var $maxlength	= null;
   var $size		= null;
   var $required	= null;
   var $tabid		= null;
   var $ordering	= null;
   var $cols		= null;
   var $rows		= null;
   var $value		= null;
   var $default		= null;
   var $published	= null;
   var $registration = null;
   var $profile		= null;
   var $readonly	= null;
   var $calculated	= null;
   var $sys			= null;
   var $pluginid	= null;
   var $params		= null;

    /**
    * Constructor
    * @param database A database connector object
    */
	function moscomprofilerFields( &$db ) {
	
		$this->comprofilerDBTable( '#__comprofiler_fields', 'fieldid', $db );
	
	} //end func
	
	function store( $fieldid=0, $updateNulls=false ) {
			global $_CB_database;

			$this->fieldid = $fieldid;

			SWITCH($this->type) {
				CASE 'date':
					$cType='DATE';
				break;
				CASE 'editorta':
				CASE 'textarea':
				CASE 'multiselect':
				CASE 'multicheckbox':
					$cType='MEDIUMTEXT';
				break;	
				CASE 'checkbox':
					$cType='TINYINT';
				break;			
				default:
					$cType='VARCHAR(255)';
				break;
			}

			$sql="SELECT COUNT(*) FROM #__comprofiler_fields WHERE fieldid = ". (int) $this->fieldid;
			$_CB_database->SetQuery($sql);
			$total = $_CB_database->LoadResult();

			if ( $total > 0 ) {
				// existing record
				//echo "updating";
				$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );	// escapes values
				if ($ret) {
					$ret = $this->changeColumn('#__comprofiler',$this->name,$cType);
				}
			} else {
				// new record
				//echo "inserting";
				$sql="SELECT COUNT(*) FROM #__comprofiler_fields WHERE name='" . $_CB_database->getEscaped( $this->name ) . "'";
				$_CB_database->SetQuery($sql);
				if ( $_CB_database->LoadResult() > 0 ) {
					$this->_error = "The field name ".$this->name." is already in use!";
					return false;
				}				
				$sql="SELECT MAX(ordering) FROM #__comprofiler_fields WHERE tabid=" . (int) $this->tabid;
				$_CB_database->SetQuery($sql);
				$max = $_CB_database->LoadResult();
				$this->ordering = $max + 1;
				$this->fieldid  = null;
				$ret = $this->createColumn('#__comprofiler',$this->name,$cType);
				if ($ret) {
					$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );		// do inserObject last to keep insertId intact
				}
			}
			if( !$ret ) {
				$this->_error = get_class( $this ) . "::store failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				return true;
			}
	}
	/**
	*	Delete method for fields deleting also fieldvalues, but not the data column in the comprofiler table.
	*	For that, deleteColumn() method must be called separately.
	*
	*	@param id of row to delete
	*	@return true if successful otherwise returns and error message
	*/
	function delete( $oid=null ) {
		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$result = true;
		
		//Find all fieldValues related to the field
		$this->_db->setQuery("SELECT `fieldvalueid` FROM #__comprofiler_field_values WHERE `fieldid`=" . (int) $this->$k);
		$fieldvalues=$this->_db->loadObjectList();
		$rowFieldValues=new moscomprofilerFieldValues($this->_db);
		if ( count( $fieldvalues ) > 0 ) {
			//delete each field value related to a field
			foreach ( $fieldvalues AS $fieldvalue ) {
				$result = $rowFieldValues->delete( $fieldvalue->fieldvalueid ) && $result;
			}	
		}
		//Now delete the field itself without deleting the user data, preserving it for reinstall
		//$rowField->deleteColumn('#__comprofiler',$field->name);	// this would delete the user data
		$result = parent::delete($this->$k) && $result;
		return $result;
	}

	function createColumn( $table, $column, $type) {
		global $_CB_database;
		
		$sql = "SELECT * FROM `" . $_CB_database->getEscaped( $table) . "` LIMIT 1";
		$_CB_database->setQuery($sql);
		$obj = null;
		if ( ! ( $_CB_database->loadObject( $obj ) && array_key_exists( $column, $obj ) ) ) {
			$sql = "ALTER TABLE `" . $_CB_database->getEscaped( $table)
				 . "` ADD `" . $_CB_database->getEscaped( $column) . "` " . $_CB_database->getEscaped( $type );
			$_CB_database->SetQuery($sql);
			$ret = $_CB_database->query();
			if ( !$ret ) {
				$this->_error .= get_class( $this )."::createColumn failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				return true;
			}
		} else {
			return $this->changeColumn( $table, $column, $type);
		}
	}

	function changeColumn( $table, $column, $type) {
		global $_CB_database;
		
		$sql = "ALTER TABLE `" . $_CB_database->getEscaped( $table)
				. "` CHANGE `" . $_CB_database->getEscaped( $column)
				. "` `" . $_CB_database->getEscaped( $column)
				. "` " . $_CB_database->getEscaped( $type );
		$_CB_database->SetQuery($sql);
		$ret = $_CB_database->query();
		if ( !$ret ) {
			$this->_error .= get_class( $this )."::changeColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}

	function deleteColumn( $table, $column) {
			global $_CB_database;
		$sql = "ALTER TABLE `" . $_CB_database->getEscaped( $table)
				. "` DROP `" . $_CB_database->getEscaped( $column)
				. "`";
		$_CB_database->SetQuery($sql);
		$ret = $_CB_database->query();
		if ( !$ret ) {
			$this->_error .= get_class( $this )."::deleteColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
} //end class

class moscomprofilerTabs extends comprofilerDBTable {

   var $tabid=null;
   var $title=null;
   var $description=null;
   var $ordering=null;
   var $ordering_register=null;
   var $width=null;
   var $enabled=null;
   var $pluginclass=null;
   var $pluginid=null;
   var $fields=null;
   var $params=null;
   /**	@var system tab: >=1: from comprofiler core: can't be deleted. ==2: always enabled. ==3: collecting element (menu+status): rendered at end. */
   var $sys=null;
   var $displaytype=null;
   var $position=null;
   var $useraccessgroupid=null;

    /**
    * Constructor
    * @param database A database connector object
    */
	function moscomprofilerTabs( &$db ) {
	
		$this->comprofilerDBTable( '#__comprofiler_tabs', 'tabid', $db );
	
	} //end func

	function store( $tabid, $updateNulls=false) {
		global $_CB_database, $_POST;
	
		if ( ( ! isset( $_POST['tabid'] ) ) || $_POST['tabid'] == null || $_POST['tabid'] == '' ) {
			$this->tabid = (int) $tabid;
		} else {
			$this->tabid = (int) cbGetParam( $_POST, 'tabid', 0 );
		}
		$sql = "SELECT COUNT(*) FROM #__comprofiler_tabs WHERE tabid = ". (int) $this->tabid;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );	// escapes values!
			
		} else {
			$sql = "SELECT MAX(ordering) FROM #__comprofiler_tabs";
			$_CB_database->SetQuery($sql);
			$max = $_CB_database->LoadResult();
			$this->ordering = $max + 1;
			// new record
			$this->tabid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
			
		}
		if ( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
} //end class

class moscomprofilerFieldValues extends comprofilerDBTable {
   var $fieldvalueid	=	null;
   var $fieldid			=	null;
   var $fieldtitle		=	null;
   var $ordering		=	null;
   var $sys				=	null;

    /**
    * Constructor
    * @param database A database connector object
    */

	function moscomprofilerFieldValues( &$db ) {
	
		$this->comprofilerDBTable( '#__comprofiler_field_values', 'fieldvalueid', $db );
	
	} //end func

	function store( $fieldvalueid=0, $updateNulls=false) {
			global $_CB_database, $_POST;
	
		if ( ( ! isset( $_POST['fieldvalueid'] ) ) || $_POST['fieldvalueid'] == null || $_POST['fieldvalueid'] == '' ) {
			$this->fieldvalueid = (int) $fieldvalueid;
		} else {
			$this->fieldvalueid = (int) cbGetParam( $_POST, 'fieldvalueid', 0 );
		}
		$sql = "SELECT COUNT(*) FROM #__comprofiler_field_values WHERE fieldvalueid = " . (int) $this->fieldvalueid;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
			
		} else {
			// new record
			$this->fieldvalueid = null;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if ( !$ret) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			
			return true;
		}
	}


} //end class

class moscomprofiler extends comprofilerDBTable {

   // IMPORTANT: ALL VARIABLES HERE MUST BE NULL in order to not be updated if not set.
   var $id					= null;
   var $user_id				= null;
   var $avatar				= null;
   var $avatarapproved		= null;
   var $approved			= null;
   var $confirmed			= null;
   var $hits				= null;
   var $message_last_sent	= null;
   var $message_number_sent	= null;
   var $registeripaddr		= null;
   var $cbactivation		= null;

    /**
    * Constructor
    * @param database A database connector object
    */

	function moscomprofiler( &$db ) {
	
		$this->comprofilerDBTable( '#__comprofiler', 'id', $db );
	
	} //end func

	function storeExtras( $id=0, $updateNulls=false) {
		global $_CB_database, $_POST;
	
		if ( ( ! isset( $_POST['id'] ) ) || $_POST['id'] == null || $_POST['id'] == '' ) {
			$this->id = (int) $id;
		} else {
			$this->id = (int) cbGetParam( $_POST, 'id', 0 );
		}
		$sql = "SELECT count(*) FROM #__comprofiler WHERE id = ". (int) $this->id;
		$_CB_database->SetQuery($sql);
		$total = $_CB_database->LoadResult();
		if ( $total > 0 ) {
			// existing record
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );	// escapes values
			
		} else {
			// new record
			$sql = "SELECT MAX(id) FROM #__users";
			$_CB_database->SetQuery($sql);
			$last_id		= $_CB_database->LoadResult();
			$this->id		= $last_id;
			$this->user_id	= $last_id;
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );					// escapes values
			
		}
		if ( !$ret ) {
			$this->_error = get_class( $this )."::store failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
	/**
	*	Merges two object into one by reference ( avoids "_db", "_tbl", "_tbl_key", and $o2->($o2->_tbl_key) )
	*   @static function:
	*	@param object $o1 first object
	*	@param object $o2 second object
	*	@return object
	*/
	function & dbObjectsMerge( &$o1, &$o2 ) {
		$r = new stdClass();
		
		$class_vars = get_object_vars($o1);
		foreach ($class_vars as $name => $value) {
			if (($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key")) {
				$r->$name =& $o1->$name;
			}
		}
		$class_vars = get_object_vars($o2);
		$k = $o2->_tbl_key;
		foreach ($class_vars as $name => $value) {
			if (($name != $k) and ($name != "_db") and ($name != "_tbl") and ($name != "_tbl_key")) {
				$r->$name =& $o2->$name;
			}
		}
		return $r;
	}

} //end class

class moscomprofilerUserReport extends comprofilerDBTable {

   var $reportid			=	null;
   var $reporteduser		=	null;
   var $reportedbyuser		=	null;
   var $reportedondate		=	null;
   var $reportexplaination	=	null;
   var $reportedstatus		=	null;

    /**
    * Constructor
    * @param database A database connector object
    */
	function moscomprofilerUserReport( &$db ) {
	
		$this->comprofilerDBTable( '#__comprofiler_userreports', 'reportid', $db );
	
	}
	/**
	 * Deletes all user reports from that user and for that user (called on user delete)
	 *
	 * @param int $userId
	 * @return boolean true if ok, false with warning on sql error
	 */
	function deleteUserReports( $userId ) {
		global $_CB_database;
		$sql="DELETE FROM #__comprofiler_userreports WHERE reporteduser = ".(int) $userId." OR reportedbyuser = ".(int) $userId;
		$_CB_database->SetQuery($sql);
		if (!$_CB_database->query()) {
			echo "SQL error" . $_CB_database->stderr(true);
			return false;
		}
		return true;
	}
} //end class


/**
 * Deletes all user views from that user and for that user (called on user delete). Temporary function !!
 *
 * @param int $userId
 * @return boolean true if ok, false with warning on sql error
 */
function _cbdeleteUserViews( $userId ) {
	global $_CB_database;
	$sql="DELETE FROM #__comprofiler_views WHERE viewer_id = ".(int) $userId." OR profile_id = ".(int) $userId;
	$_CB_database->SetQuery($sql);
	if (!$_CB_database->query()) {
		$this->_setErrorMSG("SQL error" . $_CB_database->stderr(true));
		return false;
	}
	return true;
}

//FUNCTIONS

function deleteAvatar($avatar){
	global $mainframe;
   	if(eregi("gallery/",$avatar)==false && is_file($mainframe->getCfg('absolute_path')."/images/comprofiler/".$avatar)) {
		@unlink($mainframe->getCfg('absolute_path')."/images/comprofiler/".$avatar);
		if(is_file($mainframe->getCfg('absolute_path')."/images/comprofiler/tn".$avatar)) @unlink($mainframe->getCfg('absolute_path')."/images/comprofiler/tn".$avatar);
	}
}

function getActivationMessage( &$user, $cause ) {
	global $_CB_database, $ueConfig, $_PLUGINS, $mosConfig_emailpass;
	
	$messagesToUser = null;
	if ( in_array( $cause, array( "UserRegistration", "SameUserRegistrationAgain" ) ) ) {
		if 		 ($mosConfig_emailpass == "1" && $user->approved != 1 && $user->confirmed == 1 ){
			$messagesToUser = _UE_REG_COMPLETE_NOPASS_NOAPPR;
		} elseif ($mosConfig_emailpass == "1" && $user->approved != 1 && $user->confirmed == 0 ) {
			$messagesToUser = _UE_REG_COMPLETE_NOPASS_NOAPPR_CONF;
		} elseif ($mosConfig_emailpass == "1" && $user->approved == 1 && $user->confirmed == 1 ) {
			$messagesToUser = _UE_REG_COMPLETE_NOPASS;
		} elseif ($mosConfig_emailpass == "1" && $user->approved == 1 && $user->confirmed == 0 ) {
			$messagesToUser = _UE_REG_COMPLETE_NOPASS_CONF;
		} elseif ($mosConfig_emailpass == "0" && $user->approved != 1 && $user->confirmed == 1 ) {
			$messagesToUser = _UE_REG_COMPLETE_NOAPPR;
		} elseif ($mosConfig_emailpass == "0" && $user->approved != 1 && $user->confirmed == 0 ) {
			$messagesToUser = _UE_REG_COMPLETE_NOAPPR_CONF;
		} elseif ($mosConfig_emailpass == "0" && $user->approved == 1 && $user->confirmed == 0 ) {
			$messagesToUser = _UE_REG_COMPLETE_CONF;
		} else {
			$messagesToUser = _UE_REG_COMPLETE;
		}
	} elseif ( $cause == "UserConfirmation" ) {
		if ($user->approved != 1) {
			$messagesToUser = _UE_USER_CONFIRMED_NEEDAPPR;
		} else {
			$messagesToUser = _UE_USER_CONFIRMED;
		}
	}
	
	if ( $messagesToUser ) {
		$messagesToUser = array( 'sys' => $messagesToUser );
		if ( $cause == "SameUserRegistrationAgain" ) {
			array_unshift( $messagesToUser, _UE_YOU_ARE_ALREADY_REGISTERED );
		}
	}
	return $messagesToUser;
}
/**
 * Activates a user
 * user plugins must have been loaded
 *
 * @param object mos+cbUser $user
 * @param int $ui 1=frontend, 2=backend, 0=no UI: machine-machine UI
 * @param string $cause	(one of: "UserRegistration", "UserConfirmation", "UserApproval", "NewUser", "UpdateUser")
 * @param boolean $mailToAdmins		true if the standard new-user email should be sent to admins if moderator emails are enabled
 * @param boolean $mailToUser		true if the welcome new user email (from CB config) should be sent to the new user
 * @param boolean $triggerBeforeActivate
 * @return array of string			texts to display
 */
function activateUser( &$user, $ui, $cause, $mailToAdmins = true, $mailToUser = true, $triggerBeforeActivate = true ) {
	global $_CB_database, $ueConfig, $_PLUGINS, $mosConfig_emailpass;
	
	$activate = ( $user->confirmed && ( $user->approved == 1 ) );
	$showSysMessage = true;
	$messagesToUser = getActivationMessage( $user, $cause );
	
	if ( $cause == "UserConfirmation" && $user->approved == 0) {
		$activate = false;
		$msg = array(
			'emailAdminSubject'	=> array( 'sys' => _UE_REG_ADMIN_PA_SUB ),
			'emailAdminMessage'	=> array( 'sys' => _UE_REG_ADMIN_PA_MSG ),
			'emailUserSubject'	=> array( ),
			'emailUserMessage'	=> array( )
		);
	} elseif ( $user->confirmed == 0 ) {
		$msg = array(
			'emailAdminSubject'	=> array( ),
			'emailAdminMessage'	=> array( ),
			'emailUserSubject'	=> array( 'sys' => getLangDefinition( stripslashes( $ueConfig['reg_pend_appr_sub'] ) ) ),
			'emailUserMessage'	=> array( 'sys' => getLangDefinition( stripslashes( $ueConfig['reg_pend_appr_msg'] ) ) )
		);
	} elseif ( $cause == "SameUserRegistrationAgain" ) {
		$activate = false;
		$msg = array(
			'emailAdminSubject'	=> array( ),
			'emailAdminMessage'	=> array( ),
			'emailUserSubject'	=> array( ),
			'emailUserMessage'	=> array( )
		);
	} elseif ( $user->confirmed && ! ( $user->approved == 1 ) ) {
		$msg = array(
			'emailAdminSubject'	=> array( 'sys' => _UE_REG_ADMIN_PA_SUB ),
			'emailAdminMessage'	=> array( 'sys' => _UE_REG_ADMIN_PA_MSG ),
			'emailUserSubject'	=> array( 'sys' => getLangDefinition( stripslashes( $ueConfig['reg_pend_appr_sub'] ) ) ),
			'emailUserMessage'	=> array( 'sys' => getLangDefinition( stripslashes( $ueConfig['reg_pend_appr_msg'] ) ) )
		);
	} elseif  ( $user->confirmed && ( $user->approved == 1 ) ) {
		$msg = array(
			'emailAdminSubject'	=> array( 'sys' => _UE_REG_ADMIN_SUB ),
			'emailAdminMessage'	=> array( 'sys' => _UE_REG_ADMIN_MSG ),
			'emailUserSubject'	=> array( 'sys' => getLangDefinition( stripslashes( $ueConfig['reg_welcome_sub'] ) ) ),
			'emailUserMessage'	=> array( 'sys' => getLangDefinition( stripslashes( $ueConfig['reg_welcome_msg'] ) ) )
		);
	}
	$msg['messagesToUser'] = $messagesToUser;
	
	if ( $triggerBeforeActivate ) {
		$results = $_PLUGINS->trigger( 'onBeforeUserActive', array( &$user, $ui, $cause, $mailToAdmins, $mailToUser ));
		if( $_PLUGINS->is_errors() && ( $ui != 0 ) ) {
			echo $_PLUGINS->getErrorMSG( "<br />" );
		}

		foreach ( $results as $res ) {
			if ( is_array( $res ) ) {
				$activate		= $activate			&& $res['activate'];
				$mailToAdmins	= $mailToAdmins		&& $res['mailToAdmins'];
				$mailToUser		= $mailToUser		&& $res['mailToUser'];
				$showSysMessage	= $showSysMessage	&& $res['showSysMessage'];
				foreach ( $msg as $key => $val ) {
					if ( isset( $res[$key] ) && $res[$key] ) {
						array_push( $msg[$key], $res[$key] );
					}
				}
			}
		}
		if ( ! ( $mailToAdmins && ( $ueConfig['moderatorEmail'] == 1 ) ) ) {
			unset( $msg['emailAdminSubject']['sys'] );
			unset( $msg['emailAdminMessage']['sys'] );
		}
		if ( ! $mailToUser ) {
			unset( $msg['emailUserSubject']['sys'] );
			unset( $msg['emailUserMessage']['sys'] );
		}
		if ( ! $showSysMessage ) {
			unset( $msg['messagesToUser']['sys'] );
		}
	}
	
	if ( $activate ) {
		$query = "UPDATE #__users"
		. "\n SET block = 0"
		. "\n WHERE id = " . (int) $user->id;
		$_CB_database->setQuery( $query );
		if ( ( !$_CB_database->query() ) && ( $ui != 0 ) ) {
			echo "SQL-unblock1 error: " . $_CB_database->stderr(true);
		}
		$query = "UPDATE #__comprofiler"
		. "\n SET cbactivation = ''"
		. "\n WHERE id = " . (int) $user->id;
		$_CB_database->setQuery( $query );
		if ( ( !$_CB_database->query() ) && ( $ui != 0 ) ) {
			echo "SQL-unblock2 error: " . $_CB_database->stderr(true);
		}
	}
	
	$cbNotification = new cbNotification();
	
	if ( $ueConfig['moderatorEmail'] && count( $msg['emailAdminMessage'] ) ) {
		$pwd = $user->password;
		$user->password = null;
		$cbNotification->sendToModerators( implode( ', ', $msg['emailAdminSubject'] ), 
										   $cbNotification->_replaceVariables( implode( '\n\n', $msg['emailAdminMessage'] ), $user ) );
		$user->password = $pwd;
	}

	if ( count( $msg['emailUserMessage'] ) ) {
		$cbNotification->sendFromSystem( $user, implode( ', ', $msg['emailUserSubject'] ), implode( '\n\n', $msg['emailUserMessage'] ) );
	}
	
	if ( $activate ) {
		$_PLUGINS->trigger( 'onUserActive', array( $user, true ) );
		if( $_PLUGINS->is_errors() && ( $ui != 0 ) ) {
			echo $_PLUGINS->getErrorMSG( "<br />" );
		}
	}	
	return $msg['messagesToUser'];
}

/**
* Page navigation support functions
*/

/**
* Writes the html links for pages, eg, previous 1 2 3 ... x next
* @param int The record number to start dislpaying from
* @param int Number of rows to display per page
* @param int Total number of rows
* @param string base url (without SEF): sefRelToAbs done inside this function
* @param mixed string/array : string: search parameter added as &$prefix.search=... if NOT NULL ; array: each added as $prefix.&key=$val
* @param string prefix on the &limitstart and &search URL items
*/

function writePagesLinks($limitstart, $limit, $total,$ue_base_url,$search=null,$prefix="") {
	$limitstart = max( (int) $limitstart, 0 );
	$limit		= max( (int) $limit, 1 );
	$total		= (int) $total;
	$ret="";
	if (is_array($search)) {
		$search_str = "";
		foreach ($search as $k => $v) {
			if ($v && $k!="limitstart")  $search_str .= "&amp;".urlencode($prefix.$k)."=".urlencode($v);
		}
	} else {
		$search_str = (($search) ? "&amp;".urlencode($prefix)."search=".urlencode($search) : "");
	}
	$limstart_str = "&amp;".urlencode($prefix)."limitstart=";
	$pages_in_list = 6;                // set how many pages you want displayed in the menu (not including first&last, and ev. ... repl by single page number.
	$displayed_pages = $pages_in_list;
	$total_pages = ceil( $total / $limit );
	$this_page = ceil( ($limitstart+1) / $limit );
	// $start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
	$start_loop = $this_page-floor($displayed_pages/2); if ($start_loop < 1) $start_loop = 1; if ($start_loop == 3) $start_loop = 2;		//BB
	if ($start_loop + $displayed_pages - 1 < $total_pages-2) {
		$stop_loop = $start_loop + $displayed_pages - 1;
	} else {
		$stop_loop = $total_pages;
	}

	if ($this_page > 1) {
		$page = ($this_page - 2) * $limit;
		$ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str."0".$search_str)."\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
		$ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str.$page.$search_str)."\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
		if ($start_loop > 1) $ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str."0".$search_str)."\" title=\"" . _UE_FIRST_PAGE . "\"><strong>1</strong></a>";
		if ($start_loop > 2) $ret .= "\n<span class=\"pagenav\"> <strong>...</strong> </span>";
	} else {
		$ret .= '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
		$ret .= '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
	}

	for ($i=$start_loop; $i <= $stop_loop; $i++) {
		$page = ($i - 1) * $limit;
		if ($i == $this_page) {
			$ret .= "\n <span class=\"pagenav\">[".$i."]</span> ";
		} else {
			$ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str.$page.$search_str)."\"><strong>$i</strong></a>";
		}
	}

	if ($this_page < $total_pages) {
		$page = $this_page * $limit;
		$end_page = ($total_pages-1) * $limit;
		if ($stop_loop < $total_pages-1) $ret .= "\n<span class=\"pagenav\"> <strong>...</strong> </span>";
		if ($stop_loop < $total_pages) $ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str.$end_page.$search_str)."\" title=\"" . _UE_END_PAGE . "\"><strong>".$total_pages."</strong></a>";
		$ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str.$page.$search_str)."\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
		$ret .= "\n<a class=\"pagenav\" href=\"".sefRelToAbs($ue_base_url.$limstart_str.$end_page.$search_str)."\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
	} else {
		$ret .= '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
		$ret .= '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
	}
	return $ret;
}

/**
* Writes the html for the pages counter, eg, Results 1-10 of x
*
* @param int The record number to start dislpaying from
* @param int Number of rows to display per page
* @param int Total number of rows
*/
function writePagesCounter($limitstart, $limit, $total) {
	$from_result = $limitstart+1;
	if ($limitstart + $limit < $total) {
		$to_result = $limitstart + $limit;
	} else {
		$to_result = $total;
	}
	if ($total > 0) {
		echo _UE_RESULTS . " <b>" . $from_result . " - " . $to_result . "</b> " . _UE_OF_TOTAL . " <b>" . $total . "</b>";
	} else {
		echo _UE_NO_RESULTS . ".";
	}
}
function isOdd($x){
if($x & 1) return TRUE;
else return FALSE;
}
function check_filesize($file,$maxSize) {

   $size = filesize($file);

   if($size <= $maxSize) {
      return true;
   }
   return false;
}

function check_image_type($type)
{
   switch( $type )
   {
      case 'jpeg':
      case 'pjpeg':
      case 'jpg':
         return '.jpg';
         break;
      case 'png':
         return '.png';
         break;
   }

   return false;
}

function display_avatar_gallery($avatar_gallery_path)
{
   $dir = @opendir($avatar_gallery_path);
   $avatar_images = array();
   $avatar_col_count = 0;
   while( $file = @readdir($dir) )
   {

      if( $file != '.' && $file != '..' && is_file($avatar_gallery_path . '/' . $file) && !is_link($avatar_gallery_path. '/' . $file) )
      {
            if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $file) )
            {
               $avatar_images[$avatar_col_count] = $file;
               // $avatar_name[$avatar_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $file)));
               $avatar_col_count++;
            }
       }
   }

   @closedir($dir);

   @ksort($avatar_images);
   @reset($avatar_images);

   return $avatar_images;
}

function fmodReplace($x,$y)
{ //function provided for older PHP versions which do not have an fmod function yet
   $i = floor($x/$y);
   return $x - $i*$y;
}

function dateConverter($oDate,$oFromFormat,$oToFormat) {
	if($oDate=="" || $oDate == null || !isset($oDate)) {
		return "";
	} else {
		$specChar = array(".","/");
		$oDate = str_replace($specChar,"-",$oDate);
		$oFromFormat = str_replace($specChar,"-",$oFromFormat);
		$oDate=explode(" ",$oDate);
		if (!ISSET($oDate[1])) $oDate[1]="";
		$dateParts=explode ("-", $oDate[0] );
		$fromParts=explode( "-", $oFromFormat );

		$dateArray = array();
		$dateArray[$fromParts[0]] = $dateParts[0];
		$dateArray[$fromParts[1]] = $dateParts[1];
		$dateArray[$fromParts[2]] = $dateParts[2];

		if (strpos($oToFormat,"/")!=false) $char = "/";
		elseif (strpos($oToFormat,".")!=false) $char = ".";
		else $char = "-";

		$toParts=explode( $char, $oToFormat );

		$returnDate=$oToFormat;
		foreach ($toParts as $toPart) {
			if ($toPart=='Y' || $toPart=='y') {
				if ( array_key_exists( $toPart, $dateArray ) ) {
					$returnDate		=	str_replace($toPart,$dateArray[$toPart],$returnDate);
				} elseif ( $toPart == 'y' ) {
					$returnDate		=	str_replace($toPart,substr($dateArray['Y'],-2),$returnDate);
				} else {
					$returnDate		=	str_replace($toPart,$dateArray['y'],$returnDate);
				}
			}else {
				$returnDate=str_replace($toPart,substr($dateArray[$toPart],0,2),$returnDate);
			}
		}
		return $returnDate. ( ( $oDate[1] != "" ) ? " ".$oDate[1] : "" );
	}

}

/**
 * offsets date-time if time is present and $serverTimeOffset 1, then formats to CB's configured date-time format.
 *
 * @param mixed		string $date in "Y-m-d H:i:s" format, or 	int : unix timestamp
 * @param int $serverTimeOffset : 0: don't offset, 1: offset if time also in $date
 * @param boolean $showtime : false don't show time even if time is present in string
 * @return string date formatted 
 */
function cbFormatDate( $date, $serverTimeOffset = 1, $showtime=true ) {
	global $ueConfig;
	
	if ( is_int( $date ) ) {
		$date = date( ($showtime) ? "Y-m-d H:i:s" : "Y-m-d", $date );
	}
	if ( ( $date!='' ) && ( $date != null ) && ( $date != '0000-00-00 00:00:00' ) && ( $date != '0000-00-00' ) ) {
		if ( strlen( $date ) > 10 ) {
			if ( ( $serverTimeOffset == 1 ) ) {
				$date = mosFormatDate( $date, (($showtime) ? "%Y-%m-%d %H:%M:%S" : "%Y-%m-%d" ) );		// offsets datetime with server offset setting
			} else {
				$date = substr( $date, 0, 10 );
			}
		}
		$ret = dateConverter( $date, 'Y-m-d', $ueConfig['date_format'] );
	} else {
		$ret = "";
	}
	return $ret;
}

function getNameFormat($name,$uname,$format) {
	if ( $name || $uname ) {
		SWITCH ($format) {
			CASE 1 :
				$returnName = unHtmlspecialchars($name);
			break;
			CASE 2 :
				$returnName = unHtmlspecialchars($name)." (".$uname.")";
			break;
			CASE 3 :
				$returnName = $uname;
			break;
			CASE 4 :
				$returnName = $uname." (".unHtmlspecialchars($name).")";
			break;
		}
	} else {
		$returnName = _UE_UNNAMED_USER;
	}
	return htmlspecialchars($returnName);
}

function getFieldValue( $oType, $oValue=null, $user=null, $prefix=null, $imgMode=0, $linkURL=null ) {
	global $ueConfig,$_CB_database,$mosConfig_lang,$mainframe,$my;
	$oReturn="";
	switch ($oType){
		CASE 'checkbox':
			if($oValue!='' && $oValue!=null) {
				if($oValue==1) { $oReturn=_UE_YES; 
				} elseif($oValue==0) { $oReturn=_UE_NO;
				} else { $oReturn=null; }
			}
		break;
		CASE 'select':
		CASE 'radio':
			$oReturn = getLangDefinition(htmlspecialchars( $oValue ));
		break;
		CASE 'multiselect':
		CASE 'multicheckbox':
			$oReturn=array();
			$oReturn = explode("|*|",htmlspecialchars( $oValue ));
			for($i = 0; $i < count($oReturn); $i++) {
   				$oReturn[$i]=getLangDefinition($oReturn[$i]);
			}
			$oReturn = implode("; ",$oReturn);
		break;
		CASE 'date':
			if($oValue!='' || $oValue!=null) {
				if ($oValue!='0000-00-00 00:00:00' && $oValue!='0000-00-00') {
					$oReturn = cbFormatDate( htmlspecialchars( $oValue ) );
				} else {
					$oReturn = "";
				}
			}
		break;
		CASE 'primaryemailaddress':
			if ($ueConfig['allow_email_display']==3 || $imgMode != 0) {
				$oValueText = _UE_SENDEMAIL;
			} else {
				$oValueText = htmlspecialchars( $oValue );
			}
			$emailIMG = "<img src=\"components/com_comprofiler/images/email.gif\" border=\"0\" alt=\""._UE_SENDEMAIL."\" title=\""._UE_SENDEMAIL."\" />";
			switch ( $imgMode ) {
				case 0:
					$linkItemImg = null;
					$linkItemSep = null;
					$linkItemTxt = $oValueText;
				break;
				case 1:
					$linkItemImg = $emailIMG;
					$linkItemSep = null;
					$linkItemTxt = null;
				break;
				case 2:
					$linkItemImg = $emailIMG;
					$linkItemSep = ' ';
					$linkItemTxt = $oValueText;
				break;
			}
			//if no email or 4 (do not display email) then return empty string
			if ( $oValue==null || $ueConfig['allow_email_display']==4 || ($imgMode!=0 && $ueConfig['allow_email_display']==1) ) {
				$oReturn="";
			} else {
				switch ( $ueConfig['allow_email_display'] ) {
					case 1: //display email only
						//if emailCloaking is supported then use it
						if ( is_callable( array("mosHTML","emailCloaking") ) ) {
							$oReturn = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 0 );
						} else {
							$oReturn = htmlspecialchars( $oValue );		
						}
					break;
					case 2: //mailTo link
						if ( /* $imgMode == 0 && */ is_callable( array("mosHTML","emailCloaking") ) ) {
							// mambo/joomla's cloacking doesn't cloack the text of the hyperlink, if that text does contain email addresses
							if ( ! $linkItemImg && $linkItemTxt == htmlspecialchars( $oValue ) ) {
								$oReturn  = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 1, '', 0 );
							} elseif ( $linkItemImg && $linkItemTxt != htmlspecialchars( $oValue ) ) {
								$oReturn  = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 1, $linkItemImg . $linkItemSep . $linkItemTxt, 0 );
							} elseif ( $linkItemImg && $linkItemTxt == htmlspecialchars( $oValue ) ) {
								$oReturn  = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 1, $linkItemImg, 0 ) . $linkItemSep;
								$oReturn .= mosHTML::emailCloaking( htmlspecialchars( $oValue ), 1, '', 0 );
							} elseif ( ! $linkItemImg && $linkItemTxt != htmlspecialchars( $oValue ) ) {
								$oReturn  = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 1, $linkItemTxt, 0 );
							}
						} else {
							$oReturn = "<a href=\"mailto:".htmlspecialchars( $oValue )."\" title=\""._UE_MENU_SENDUSEREMAIL_DESC."\">"
									 . $linkItemImg . $linkItemSep . $linkItemTxt . "</a>";
						}
					break;
					case 3: //email Form (with cloacked email address if visible)
						$oReturn = "<a href=\""
						. sefRelToAbs("index.php?option=com_comprofiler&amp;task=emailUser&amp;uid=" . $user->id . getCBprofileItemid(true))
						. "\" title=\"" . _UE_MENU_SENDUSEREMAIL_DESC . "\">" . $linkItemImg . $linkItemSep;
						if ( ( $linkItemTxt && ( $linkItemTxt != _UE_SENDEMAIL ) ) &&  is_callable( array("mosHTML","emailCloaking") ) ) {
							$oReturn .= mosHTML::emailCloaking( $linkItemTxt, 0 );
						} else {
							$oReturn .= $linkItemTxt;
						}
						$oReturn .=  "</a>";
					break;
				}
			}
		break;
		CASE 'pm':
			$pmIMG="<img src=\"components/com_comprofiler/images/pm.gif\" border=\"0\" alt=\""._UE_PM_USER."\" title=\""._UE_PM_USER."\" />";
			$oReturn="";
			global $_CB_PMS;
			$resultArray = $_CB_PMS->getPMSlinks($user->id, $my->id, "", "", 1);	// toid,fromid,subject,message,1: link to compose new PMS message for $toid user.
			if (count($resultArray) > 0) {
				foreach ($resultArray as $res) {
				 	if (is_array($res)) {
						switch ($imgMode) {
							case 0:
								$linkItem=getLangDefinition($res["caption"]);
							break;
							case 1:
								$linkItem=$pmIMG;
							break;
							case 2:
								$linkItem=$pmIMG.' '.getLangDefinition($res["caption"]);
							break;
						}
						$oReturn .= "<a href=\"".sefRelToAbs($res["url"])."\" title=\"".getLangDefinition($res["tooltip"])."\">".$linkItem."</a>";
				 	}
				}
			}			
		break;
		CASE 'emailaddress':
			IF($oValue==null) $oReturn="";
			elseif (is_callable(array("mosHTML","emailCloaking"))) {		// 	/* Mambo 4.5.0 support: */
				IF($ueConfig['allow_email']==1) $oReturn = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 1, "", 0 );
				ELSE $oReturn = mosHTML::emailCloaking( htmlspecialchars( $oValue ), 0 );
			} else {
				IF($ueConfig['allow_email']==1)	$oReturn="<a href=\"mailto:".htmlspecialchars( $oValue )."\">".htmlspecialchars( $oValue)."</a>";
				ELSE $oReturn=htmlspecialchars( $oValue );
			}
		break;
		CASE 'webaddress':
			IF($oValue==null) $oReturn="";
			ELSEIF($ueConfig['allow_website']==1) {
				$oReturn=array();
				$oReturn = explode("|*|",$oValue);
				if (count($oReturn) < 2) $oReturn[1]=$oReturn[0];
				$oReturn="<a href=\"http://".htmlspecialchars($oReturn[0])."\" target=\"_blank\">".htmlspecialchars($oReturn[1])."</a>";
			} ELSE {
				$oReturn=$oValue;
			}
		break;
		CASE 'image':
			if(is_dir($mainframe->getCfg('absolute_path')."/components/com_comprofiler/plugin/language/".$mosConfig_lang."/images")) $fileLang=$mosConfig_lang;
			else $fileLang="default_language";
			
			if($user->avatarapproved==0) $oValue="components/com_comprofiler/plugin/language/".$fileLang."/images/tnpendphoto.jpg";
			elseif(($user->avatar=='' || $user->avatar==null) && $user->avatarapproved==1) $oValue = "components/com_comprofiler/plugin/language/".$fileLang."/images/tnnophoto.jpg";
			elseif(strpos($user->avatar,"gallery/")===false) $oValue="images/comprofiler/tn".$oValue;
			else $oValue="images/comprofiler/".$oValue;

			if(!is_file($mainframe->getCfg('absolute_path')."/".$oValue)) $oValue = "components/com_comprofiler/plugin/language/".$fileLang."/images/tnnophoto.jpg";
			if(is_file($mainframe->getCfg('absolute_path')."/".$oValue)) {
				$onclick = null;
				$aTag = null;
				if($ueConfig['allow_profilelink']==1) {
					$profileURL = sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$user->id.getCBprofileItemid(true));
					// $onclick = "onclick=\"javascript:window.location='".$profileURL."'\"";
					$aTag = "<a href=\"".$profileURL."\">";
				}
				$oReturn = $aTag."<img src=\"".$oValue. "\" ".$onclick." alt=\"\" style=\"border-style: none;\" />".($aTag ? "</a>" : "");
			}
		break;
		CASE 'status':
			if ( $ueConfig['allow_onlinestatus'] == 1 ) {
				if ( isset( $user ) ) {
					$_CB_database->setQuery("SELECT COUNT(*) FROM #__session WHERE userid = " . (int) $user->id . " AND guest = 0");
					$isonline = $_CB_database->loadResult();
				} else {
					$isonline = $oValue;
				}
				if($isonline > 0) { 
					$oValue = _UE_ISONLINE;
					$onlineIMG= "<img src=\"components/com_comprofiler/images/online.gif\" border=\"0\" alt=\"".$oValue."\" title=\"".$oValue."\" />";
				} else { 
					$oValue = _UE_ISOFFLINE;
					$onlineIMG= "<img src=\"components/com_comprofiler/images/offline.gif\" border=\"0\" alt=\"".$oValue."\" title=\"".$oValue."\" />";
				}
				SWITCH($imgMode) {
					CASE 0:
						$oReturn=$oValue;
					break;
					CASE 1:
						$oReturn=$onlineIMG;
					break;
					CASE 2:
						$oReturn=$onlineIMG.' '.$oValue;
					break;
				}
			}
		break;
		CASE 'formatname':
			if ($linkURL && $ueConfig['allow_profilelink']==1) $oReturn = "<a href=\"".$linkURL."\">";
			$oReturn .= getNameFormat($user->name,$user->username,$ueConfig['name_format']);
			if ($linkURL && $ueConfig['allow_profilelink']==1) $oReturn .= "</a>";
		break;
		CASE 'textarea':
			$oReturn = nl2br(htmlspecialchars($oValue));
		break;
		CASE 'delimiter':
			$oReturn = '';
		break;
		CASE 'editorta':
			$cbFielfs = & new cbFields();
			$badHtmlFilter = & $cbFielfs->getInputFilter( array (), array (), 1, 1 );
			if ( isset( $ueConfig['html_filter_allowed_tags'] ) && $ueConfig['html_filter_allowed_tags'] ) {
				$badHtmlFilter->tagBlacklist = array_diff( $badHtmlFilter->tagBlacklist, explode(" ", $ueConfig['html_filter_allowed_tags']) );
			}
			$oReturn = $cbFielfs->clean( $badHtmlFilter, $oValue );
			unset( $cbFielfs );
		break;
		CASE 'predefined':
			if ($linkURL && $ueConfig['allow_profilelink']==1) $oReturn = "<a href=\"".$linkURL."\">";
			$oReturn .= htmlspecialchars(unHtmlspecialchars($oValue));		// needed for jos_users:name (has &039; instead of ' in it...)
			if ($linkURL && $ueConfig['allow_profilelink']==1) $oReturn .= "</a>";
		break;
		DEFAULT:
			$oReturn = htmlspecialchars($oValue);	//htmlspecialchars(str_replace("&quot;",'"',$oValue));	// corrects double-escapings of " in mysql_escape_string used in j! db.
		break;	
	}
	if($prefix != null && ($oReturn != null || $oReturn != '')) $oReturn = $prefix.$oReturn;
	return $oReturn;
}

/**
* Returns full path to template directory
* @param int user interface : 1: frontend, 2: backend
* @return template directory path with trailing '/'
*/
function selectTemplate($ui) {
	global $mosConfig_live_site, $ueConfig;

	if ($ui==1) $templatedir=$ueConfig['templatedir'];
	else $templatedir="luna";

	return $mosConfig_live_site . '/components/com_comprofiler/plugin/templates/'.$templatedir.'/';
}

/** CORRECTION FOR OLD-STYLE TEMPLATES:
*/
/**
* Outputs once an arbitrary html text into head tags if possible and configured, otherwise echo it.
* @param string html text for header
*/
function addCbHeadTag($ui,$text) {
	global $mainframe, $ueConfig, $_CB_outputedHeads;
	if ( ! in_array( $text, $_CB_outputedHeads) ) {
		$_CB_outputedHeads[] = $text;
		if ($ui==1 && method_exists($mainframe,"addCustomHeadTag") && isset($ueConfig['xhtmlComply']) && $ueConfig['xhtmlComply']) {
			$mainframe->addCustomHeadTag($text);
		} else {
			echo $text . "\n";
		}
	}
}
/**
* Outputs an arbitrary html text into head tags if possible and configured, otherwise echo it.
* @param int user interface : 1: frontend, 2: backend
*/
function outputCbTemplate($ui) {
	addCbHeadTag( $ui, '<link type="text/css" rel="stylesheet" href="' . selectTemplate($ui) . 'template.css" />' );
	addCbHeadTag( $ui, '<script type="text/javascript">var cbTemplateDir="' . selectTemplate($ui) . '"</script>' );
}
/**
* Outputs an arbitrary html text into head tags if possible and configured, otherwise echo it.
* @param int user interface : 1: frontend, 2: backend
*/
function outputCbJs($ui) {
	global $mainframe;
	addCbHeadTag( $ui, '<script type="text/javascript" src="' . $mainframe->getCfg('live_site') . '/components/com_comprofiler/js/cb.js"></script>' );
}

function utf8RawUrlDecode ($source) {
	$decodedStr = ''; 
	$pos = 0;
	$len = strlen ($source); 
	while ($pos < $len) { 
		$charAt = substr ($source, $pos, 1); 
		if ($charAt=='%') { 
			$pos++; 
			$charAt = substr ($source, $pos, 1); 
			if ($charAt=='u') { // we got a unicode character 
				$pos++; 
				$unicodeHexVal = substr ($source, $pos, 4); 
				$unicode = hexdec ($unicodeHexVal); 
				$entity = "&#". $unicode . ';'; 
				$decodedStr .= utf8_encode ($entity); 
				$pos += 4;
			} else { // we have an escaped ascii character 
				$hexVal = substr ($source, $pos, 2); 
				$decodedStr .= chr (hexdec ($hexVal)); 
				$pos += 2;
			} 
		} else { 
			$decodedStr .= $charAt; 
			$pos++; 
		} 
	} 
	return $decodedStr;
}
/**
 * Redirects browser to new $url with a $message .
 * No return from this function !
 *
 * @param string $url
 * @param string $message
 */
function cbRedirect( $url, $message = '' ) {
	global $mainframe, $_CB_database;

	if ( ( $mainframe->getCfg( 'debug' ) > 0 ) && ( ob_get_length() || ( $mainframe->getCfg( 'debug' ) > 1 ) ) ) {
		$outputBufferLength		=	ob_get_length();
		echo '<br /><br /><strong>Site Debug mode: CB redirection';
		if ( $outputBufferLength ) {
			echo ' <u>without empty output</u>';
		}
		echo "<br /><p><em>During it's normal operations Community Builder often redirects you between pages and this causes potentially interesting debug information to be missed. "
			. "When your site is in debug mode (global joomla/mambo config is site debug ON), some of these automatic redirects are disabled. "
			. "This is a normal feature of the debug mode and does not directly mean that you have any problems.</em></p>";
		echo '</strong>Click this link to proceed with the next page (in non-debug mode this is automatic): ';
		echo '<a href="' . $url . '">' . $url . '</a><br /><br /><hr />';

		echo $_CB_database->_db->_ticker . ' queries executed';	
		echo '<pre>';
 		foreach ( $_CB_database->_db->_log as $k => $sql ) {
 			echo $k + 1 . "\n" . $sql . '<hr />';
		}
		echo '</hr>';
		echo '</hr>POST: ';
		var_export( $_POST );
		echo '</pre>';
		die();
	} else {
		mosRedirect( $url, $message );
	}
}

/**
 * Converts an absolute URL to SEF format
 * @param  string The relative URL
 * @return string The absolute URL
 */
function cbSefRelToAbs( $string ) {
	global $_CB_framework;

	$uri		=	sefRelToAbs( $string );
	if ( ! cbStartOfStringMatch( $uri, 'http' ) ) {
		$uri	=	$_CB_framework->getCfg( 'live_site' ) . '/' . $uri;
	}
	return $uri;
}

class cbHtmlFilterOld {
	function process($string) {
		return strip_tags( $string );
	}
}
/**
 * Utility function to return a value from a named array or a specified default.
 * TO CONTRARY OF MAMBO AND JOOMLA mos Get Param:
 * 1) DOES NOT MODIFY ORIGINAL ARRAY
 * @param array A named array
 * @param string The key to search for
 * @param mixed The default value to give if no key found
 * @param int An options mask: _MOS_NOTRIM prevents trim, _MOS_ALLOWHTML allows safe html, _MOS_ALLOWRAW allows raw input
 */
define( "_CB_NOTRIM", 0x0001 );
//define( "_MOS_ALLOWHTML", 0x0002 );
define( "_CB_ALLOWRAW", 0x0004 );
function cbGetParam( &$arr, $name, $def=null, $mask=0 ) {	
	static $noHtmlFilter = null;
	// static $safeHtmlFilter = null;

	if ( isset( $arr[$name] ) ) {
        if ( is_array( $arr[$name] ) ) {
        	$ret			=	array();
        	foreach ( $arr[$name] as $k => $v ) {
        		$ret[$k]	=	cbGetParam( $arr[$name], $k, $def, $mask);
        	}
        } else {
			$ret			=	$arr[$name];
			if ( is_string( $ret ) ) {
				if ( ! ( $mask & _CB_NOTRIM ) ) {
					$ret	=	trim( $ret );
				}
				if ( ! ( $mask & _CB_ALLOWRAW ) ) {
					if ( is_null( $noHtmlFilter ) ) {
						if ( class_exists( "InputFilter" ) ) {		// Mambo 4.5.0 compatibility
							$noHtmlFilter = new InputFilter( /* $tags, $attr, $tag_method, $attr_method, $xss_auto */ );
						} else {
							$noHtmlFilter = new cbHtmlFilterOld;
						}
					}
					$ret	=	$noHtmlFilter->process( $ret );
				}
				if ( is_int( $def ) ) {
					$ret	=	(int) $ret;
				} elseif ( !  get_magic_quotes_gpc() ) {
					$ret	=	addslashes( $ret );
				}
			}
        }
		return $ret;
	} else {
		return $def;
	}
}

/** Escapes with real database escaping algorythm (stripslashes first if magic_quotes_gpc are set to take care of MB charsets) */
function cbGetEscaped( $string ) {
	global $_CB_database;
	if (get_magic_quotes_gpc()==1) {
		return ( $_CB_database->getEscaped( stripslashes( $string ) ) );
	} else {
		return ( $_CB_database->getEscaped( $string ) );
	}
}

/** Unescapes from PHP escaping algorythm if magic_quotes are set */
function cbGetUnEscaped( $string ) {
	if (get_magic_quotes_gpc()==1) {
		// if (ini_get('magic_quotes_sybase')) return str_replace("''","'",$string);
		return ( stripslashes( $string ));			// this does not handle it correctly if magic_quotes_sybase is ON.
	} else {
		return ( $string );
	}
}

/** Unescapes SQL string except % and _ . So it's reverse of $_CB_database->getEscaped... */
function cbUnEscapeSQL($string) {
	return str_replace(array("\\0","\\n","\\r","\\\\","\\'","\\\"","\\Z"),array("\x00","\n","\r","\\","'","\"","\x1a"),$string);
}

/** Escapes SQL search strings. To be used only on escaped strings */
function cbEscapeSQLsearch( $string ) {
	return str_replace(array("%","_"),array("\\%","\\_"), $string );
}

/** Unescapes SQL search strings */
function cbUnEscapeSQLsearch( $string ) {
	return str_replace(array("\\%","\\_"),array("%","_"), $string );
}

function unAmpersand($text) {
	return str_replace("&amp;","&", $text);
}

function unHtmlspecialchars($text) {
	// if (strpos($text, "&lt;") !== false) {
	return str_replace(array("&amp;","&quot;","&#039;","&lt;","&gt;"), array("&","\"","'","<",">"), $text);
	// } else {
	//	return $text;
	// }
}

function unhtmlentities( $string, $quotes = ENT_COMPAT, $charset = "ISO-8859-1" ) {
	$phpv = phpversion();
	if ( ( $phpv < '4.4.3' )
		 || ( ( $phpv >= '5.0.0' ) && ( $phpv < '5.1.3' ) )
	     || ( ( $phpv <  '5.0.0' ) && ( ! in_array( $charset, array( "ISO-8859-1", "ISO-8859-15", "cp866", "cp1251", "cp1252" ) ) ) )
	     || ( ( $phpv >= '5.1.3' ) && ( ! in_array( $charset, array( "ISO-8859-1", "ISO-8859-15", "cp866", "cp1251", "cp1252", 
	     								   "KOI8-R", "BIG5", "GB2312", "UTF-8", "BIG5-HKSCS", "Shift_JIS", "EUC-JP" ) ) ) )
	   ) {
		// For 4.1.0 =< PHP < 4.3.0 use this function instead of html_entity_decode: also php < 5.0 does not support UTF-8 outputs !
		// Plus up to 4.4.2 and 5.1.2 html_entity_decode is deadly buggy
		$trans_tbl = get_html_translation_table( HTML_ENTITIES );
		if ( $charset == "UTF-8" ) {
			foreach ( $trans_tbl as $k => $v ) {
				$ttr[$v] = utf8_encode($k);
			}
		} else {
			$ttr = array_flip( $trans_tbl );
		}
		return strtr ( $string, $ttr );
	} else  {
		return html_entity_decode ($string, $quotes, $charset);
	}
}

/**
 * Convert HTML entities to plaintext
 * Rewritten in CB to use CB's own version of html_entity_decode where innexistant or buggy in < joomla 1.5
 *
 * @access	protected
 * @param	string	$source
 * @return	string	Plaintext string
 */
function cb_html_entity_decode_all( $source ) {
	// entity decode : use own version of html_entity_decode :
	$source = unhtmlentities( $source, ENT_QUOTES, strtoupper( str_replace( "charset=", "", _ISO ) ) );
	// convert decimal
	$source = preg_replace('/&#(\d+);/me', "chr(\\1)", $source); // decimal notation
	// convert hex
	$source = preg_replace('/&#x([a-f0-9]+);/mei', "chr(0x\\1)", $source); // hex notation
	return $source;
}

function utf8ToISO( $string ) {
	$iso = strtoupper( str_replace( "charset=", "", _ISO ) );
	if ($iso == "UTF-8") {
		return $string;
	} else if (strncmp($iso,"ISO-8859-1",9)==0) {
		return utf8_decode($string);
	} else {
		return unhtmlentities(htmlentities($string,ENT_NOQUOTES,"UTF-8"),ENT_NOQUOTES,$iso);
	}
}
function ISOtoUtf8( $string ) {
	$iso = strtoupper( str_replace( "charset=", "", _ISO ) );
	if ($iso == "UTF-8") {
		return $string;
	} else if (strncmp($iso,"ISO-8859-1",9)==0) {
		return utf8_encode($string);
	} else {
		return unhtmlentities(htmlentities($string,ENT_NOQUOTES,$iso),ENT_NOQUOTES,"UTF-8");
	}
}
/**
 * Checks if begin of $subject matches a $search string
 *
 * @param string|array of string $subject
 * @param string|array of string $search
 * @return boolean true if a match is found
 */
function cbStartOfStringMatch( $subject, $search ) {
	if ( is_array( $search)) {
		foreach ($search as $s ) {
			if ( substr( $subject, 0, sizeof( $s ) ) == $s ) {
				return true;
			}
		}
		return false;
	}
	return( substr( $subject, 0, strlen( $search ) ) == $search );
}

/**
 * UTF8 helper functions
 * @license    LGPL (http://www.gnu.org/copyleft/lesser.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */
/**
 * Unicode aware replacement for strlen()
 *
 * utf8_decode() converts characters that are not in ISO-8859-1
 * to '?', which, for the purpose of counting, is alright - It's
 * even faster than mb_strlen.
 *
 * @author <chernyshevsky at hotmail dot com>
 * @see    strlen()
 * @see    utf8_decode()
 */
function cbutf8_strlen($string){
	return strlen(utf8_decode($string));
}
/**
 * Unicode aware replacement for substr()
 *
 * @author lmak at NOSPAM dot iti dot gr
 * @link   http://www.php.net/manual/en/function.substr.php
 * @see    substr()
 */
function cbutf8_substr($str,$start,$length=null){
	if ( function_exists( 'mb_substr' ) ) {
		return mb_substr( $str, $start, $length );
	} else {
		preg_match_all("/./u", $str, $ar);
	
		if($length != null) {
			return join("",array_slice($ar[0],$start,$length));
		} else {
			return join("",array_slice($ar[0],$start));
		}
	}
}

function cbReadDirectory($path) {
	$arr = array();
//	print $path;
	if (!@is_dir( $path )) {
		return $arr;
	}
	$handle = opendir( $path );
	while ($file = readdir($handle)) {
		$dir = mosPathName( $path.'/'.$file, false );
	//	print $dir;
		if(is_dir( $dir )) {
			if (($file <> ".") && ($file <> "..")) {
				//print $file;
				$arr[] = trim( $file );
			}
		}
	}
	closedir($handle);
	asort($arr);
	return $arr;
}


/**
* Utility function to include ToolTips and set defaults for CB
* @param int user interface : 1: frontend, 2: backend
* @param string width of tooltips
* @returns HTML code for init ToolTip in head section
*/
function initToolTip( $ui, $width='250' ) {
	$tip='<script type="text/javascript" src="'.(($ui==2) ? ('../') : ("")) . 'components/com_comprofiler/js/overlib_mini.js"></script>'
	."\n".'<script type="text/javascript" src="'.(($ui==2) ? ('../') : ("")) . 'components/com_comprofiler/js/overlib_hideform_mini.js"></script>'
	."\n".'<script type="text/javascript" src="'.(($ui==2) ? ('../') : ("")) . 'components/com_comprofiler/js/overlib_anchor_mini.js"></script>'
	."\n".'<script type="text/javascript" src="'.(($ui==2) ? ('../') : ("")) . 'components/com_comprofiler/js/overlib_centerpopup_mini.js"></script>'
	."\n".'<script type="text/javascript">'
	.'overlib_pagedefaults(WIDTH,'.$width.',VAUTO,RIGHT,AUTOSTATUSCAP, CSSCLASS,'
	.'TEXTFONTCLASS,\'cb-tips-font\',FGCLASS,\'cb-tips-fg\',BGCLASS,\'cb-tips-bg\''
	.',CAPTIONFONTCLASS,\'cb-tips-capfont\', CLOSEFONTCLASS, \'cb-tips-closefont\');'
	."</script>\n";
	return $tip;
}
	// This function is partly "repeated" here for mambo 4.5 backwards compatibility.
	// Corrected: VAUTO, AUTOSTATUS, <img> tag xhtml 1.0 trans compatibility.

	/**
* Utility function to provide ToolTips
* @param int user interface : 1: frontend, 2: backend
* @param string ToolTip text
* @param string Box title
* @returns HTML code for ToolTip
*/
function CB45_mosToolTip( $ui, $tooltip, $title='', $width='', $image='tooltip.png', $htmltext='', $href='', $style='', $olparams='',$click=false, $altText=' ' ) {
	if ( $altText == ' ' ) {
		$altText	=	' alt="' . strip_tags( sprintf( _UE_INFORMATION_FOR_FIELD, stripslashes( $tipTitle ), stripslashes( $fieldTip ) ) ) . '"';
	}
	if ( $width ) {
		$width = ', WIDTH, \''.$width .'\'';
	}
	if ( $title ){
		$title = ', CAPTION, \''.$title .'\'';
	}
	if ( $olparams ) {
		$olparams = ', '.$olparams;
	}
	if ($click) {
		$tooltipcode = " onclick=\"return overlib('" . $tooltip . "'". $title . $width . $olparams . ");\"";
	} else {
		$tooltipcode = " onmouseover=\"return overlib('" . $tooltip . "'". $title . $width . $olparams . ");\" onmouseout=\"return nd();\"";
	}
	if ( !$htmltext ) {
		if ($image == 'tooltip.png') {
			$style = 'style="border:0" width="16" height="16" title=""';
		}
		$image 	= selectTemplate($ui). $image;
		if ($href) {
			$htmltext = '<img src="'. $image .'" '. $style . $altText . ' />';
		}
	}
	if ( $href ) {
		$tip 	= "<a href=\"". $href . '"' . $tooltipcode . ' ' . $style .">". $htmltext ."</a>";
	} else {
		if ($htmltext) {
			$tip 	= "<span" . $tooltipcode . ' ' . $style . ">" . $htmltext ."</span>";
		} else {
			$tip 	= '<img src="'. $image .'" ' . $style . $altText . $tooltipcode . " />";
		}
	}
	return $tip;
}

function cbFieldTip($ui, $fieldTip, $tipTitle='', $width='', $image='tooltip.png', $htmltext='', $href='', $style='', $olparams='',$click=false) {
	$altText	=	' alt="' . strip_tags( sprintf( _UE_INFORMATION_FOR_FIELD, $tipTitle , $fieldTip ) ) . '"';
	// overlib_mini does not support newlines:
	if (strpos($fieldTip, "&lt;") === false) {
		$fieldTip = str_replace("\r\n", "&lt;br /&gt;", $fieldTip);	
		$fieldTip = str_replace("\n", "&lt;br /&gt;", $fieldTip);
	} else {
		$fieldTip = str_replace("\r\n", " ", $fieldTip);	
		$fieldTip = str_replace("\n", " ", $fieldTip);
	}
	$fieldTip = str_replace(array('"','<','>',"\\"), array("&quot;","&lt;","&gt;","\\\\"), $fieldTip);
	$tipTitle = str_replace(array('"','<','>',"\\"), array("&quot;","&lt;","&gt;","\\\\"), $tipTitle);
	$fieldTip = str_replace(array("'","&#039;"), "\\'", $fieldTip);
	$tipTitle = str_replace(array("'","&#039;"), "\\'", $tipTitle);
	return CB45_mosToolTip( $ui, $fieldTip, $tipTitle, $width, $image, $htmltext, $href, $style, $olparams, $click, $altText );
}

/**
 * Shows tooltip icons or explanation line for fields
 *
 * @param int         $ui            =1 front-end, =2 back-end
 * @param boolean|int $oReq          =true|1: field required
 * @param boolean|int $oProfile      =true|1: on profile, =false|0: not on profile, =null: icon not shown at all
 * @param string      $oDescription  description to show in tooltip ove a i (if any)
 * @param string      $oTitle        Title of description to show in tooltip
 * @param boolean     $showLabels    Description to show in tooltip
 * @return string                    HTML code.
 */
function getFieldIcons($ui, $oReq, $oProfile, $oDescription="", $oTitle="", $showLabels=false) {
	$templatePath = selectTemplate($ui);
	$oReturn = "";
	if ($oReq)				$oReturn .= " <img src='".$templatePath."required.gif' width='16' height='16' alt='* "._UE_FIELDREQUIRED."' title='"._UE_FIELDREQUIRED."' />";
	if ($showLabels)		$oReturn .= " "._UE_FIELDREQUIRED." | ";
	if ( $oProfile !== null ) {
		if ($oProfile)		$oReturn .= " <img src='".$templatePath."profiles.gif' width='16' height='16' alt='"._UE_FIELDONPROFILE."' title='"._UE_FIELDONPROFILE."' />";		
		if ($showLabels)	$oReturn .= " "._UE_FIELDONPROFILE." | ";
		if ((!$oProfile) || $showLabels) {
							$oReturn .= " <img src='".$templatePath."noprofiles.gif' width='16' height='16' alt='"._UE_FIELDNOPROFILE."' title='"._UE_FIELDNOPROFILE."' />";
		}
		if ($showLabels)	$oReturn .= " "._UE_FIELDNOPROFILE." | ";
	}
	if ($oDescription)		$oReturn .= " ".cbFieldTip($ui, getLangDefinition($oDescription), getLangDefinition($oTitle) );
	if ($showLabels)		$oReturn .= " ".cbFieldTip($ui, _UE_FIELDDESCRIPTION, "?")." "._UE_FIELDDESCRIPTION;
	return "<span class='cbFieldIcons".(($showLabels) ? "Labels" : "")."'>".$oReturn."</span>";
}

function cbSpoofString( $string = null ) {
	global $mainframe;
	if ( $string === null ) {
		$salt		=	array();
		$salt[0]	=	mt_rand( 1, 2147483647 );
		$salt[1]	=	mt_rand( 1, 2147483647 );		// 2 * 31 bits random
	} else {
		$salt = sscanf( $string, 'cbm_%08x_%08x' );
	}
	return sprintf( 'cbm_%08x_%08x_%s', $salt[0], $salt[1], md5( $salt[0] . date( 'dmY' ) . $mainframe->getCfg( 'db' ) . $mainframe->getCfg('secret') . $salt[1] ) );
}
function cbSpoofField() {
	return 'cbsecurityg1';
}
/**
 * Computes and returns an antifspoofing additional input tag
 *
 * @return string "<input type="hidden...\n" tag
 */
function cbGetSpoofInputTag( $cbSpoofString = null ) {
	if ( $cbSpoofString === null ) {
		$cbSpoofString		=	cbSpoofString();
	}
	return "<input type=\"hidden\" name=\"" . cbSpoofField() . "\" value=\"" .  $cbSpoofString . "\" />\n";
}

function _cbjosSpoofCheck($array, $badStrings) {
	foreach ($array as $k => $v) {
		foreach ($badStrings as $v2) {
			if (is_array($v)) {
				_cbjosSpoofCheck($v, $badStrings);
			} else if (strpos( $v, $v2 ) !== false) {
				header( "HTTP/1.0 403 Forbidden" );
				mosErrorAlert( _UE_NOT_AUTHORIZED );
				return;
			}
		}
	}
}
/**
 * Checks spoof value and other spoofing and injection tricks
 *
 */
function cbSpoofCheck( $var = 'POST' ) {
	global $_POST, $_GET, $_REQUEST;

	if ( $var == 'GET' ) {
		$validateValue 	=	cbGetParam( $_GET,     cbSpoofField(), '' );
	} elseif ( $var == 'REQUEST' ) {
		$validateValue 	=	cbGetParam( $_REQUEST, cbSpoofField(), '' );
	} else {
		$validateValue 	=	cbGetParam( $_POST,    cbSpoofField(), '' );
	}
	if ( ( ! $validateValue ) || ( $validateValue != cbSpoofString( $validateValue ) ) ) {
		echo "<script>alert('" . _UE_SESSION_EXPIRED . "'); window.history.go(-1);</script> \n";
		exit;
	}

	// First, make sure the form was posted from a browser.
	// For basic web-forms, we don't care about anything
	// other than requests from a browser:
	if (!isset( $_SERVER['HTTP_USER_AGENT'] )) {
		header( 'HTTP/1.0 403 Forbidden' );
		mosErrorAlert( _UE_NOT_AUTHORIZED );
		return;
	}

	// Make sure the form was indeed POST'ed:
	//  (requires your html form to use: action="post")
	if (!$_SERVER['REQUEST_METHOD'] == 'POST' ) {
		header( 'HTTP/1.0 403 Forbidden' );
		mosErrorAlert( _UE_NOT_AUTHORIZED );
		return;
	}

	// Attempt to defend against header injections:
	$badStrings = array(
		'Content-Type:',
		'MIME-Version:',
		'Content-Transfer-Encoding:',
		'bcc:',
		'cc:'
	);

	// Loop through each POST'ed value and test if it contains
	// one of the $badStrings:
	foreach ($_POST as $k => $v){
		foreach ($badStrings as $v2) {
			if (is_array($v)) {
				_cbjosSpoofCheck($v, $badStrings);
			} else if (strpos( $v, $v2 ) !== false) {
				header( "HTTP/1.0 403 Forbidden" );
				mosErrorAlert( _UE_NOT_AUTHORIZED );
				return;
			}
		}
	}

	// Made it past spammer test, free up some memory
	// and continue rest of script:
	unset($k, $v, $v2, $badStrings);
}

/**
 * Explodes a text like: href="text1" img="text'it" alt='alt"joe'   into an array with defined keys and values, but null for missing ones.
 *
 * @param string $text	text to parse
 * @param array of string $validTags	valid tag names
 * @return array of string	array( "tagname" => "tagvalue", "notsetTagname" => null)
 */
function cbExplodeTags( $text, $validTags ) {
	$text = trim($text);
	$result = array();
	foreach ($validTags as $tagName) {
		$result[$tagName] = null;
	}
	while ( $text != "" ) {
		$posEqual = strpos( $text, "=" );
		if ( $posEqual !== false ) {
			$tagName	= trim( substr( $text, 0, $posEqual ) );
			$text		= trim( substr( $text, $posEqual + 1 ) );
			$quoteMark	= substr( $text, 0, 1);
			$posEndQuote	= strpos( $text, $quoteMark, 1 );
			$tagValue	= false;
			if ( ($posEndQuote !== false) && in_array( $quoteMark, array( "'", '"' ) ) ) {
				$tagValue	= substr( $text, 1, $posEndQuote - 1 );
				$text		= trim( substr( $text, $posEndQuote + 1 ) );
				if ( in_array( $tagName, $validTags ) ) {
					$result[$tagName] = $tagValue;
				}
			} else {
				break;
			}
		} else {
			break;
		}
	}
	return $result;
}
/**
 * Replaces "$1" in $text with $cbMenuTagsArray[$cbMenuTagsArrayKey] if non-null but doesn't tag if empty
 * otherwise replace by $cbMenu[$cbMenuKey] if set and non-empty
 *
 * @param array of string	$cbMenuTagsArray
 * @param string			$cbMenuTagsArrayKey
 * @param array of string	$cbMenu
 * @param string			$cbMenuKey
 * @param string			$text
 * @return string
 */
function cbPlaceTags ( $cbMenuTagsArray, $cbMenuTagsArrayKey, $cbMenu, $cbMenuKey, $text ) {
	if ( $cbMenuTagsArray[$cbMenuTagsArrayKey] !== null) {
		if ( $cbMenuTagsArray[$cbMenuTagsArrayKey] != "" ) {
			return str_replace( '$1', /*allow tags! htmlspecialchars */ ( $cbMenuTagsArray[$cbMenuTagsArrayKey] ), $text );
		} else {
			return null;
		}
	} elseif ( isset($cbMenu[$cbMenuKey]) && ( $cbMenu[$cbMenuKey] !== null ) && ( $cbMenu[$cbMenuKey] !== "" ) ) {
		return str_replace( '$1', $cbMenu[$cbMenuKey], $text );
	} else {
		return null;
	}
}
function cbReplacePragma( $msg, $row, $pragma, $position, $htmlspecialcharsEncoded ) {
	global $_PLUGINS;

	$msgResult = "";
	$pragmaLen = strlen( $pragma );
    while ( ( $foundPosBegin = strpos( $msg, "[" . $pragma ) ) !== false ) {
   		$foundPosEnd = strpos( $msg, "[/" . $pragma . "]", $foundPosBegin + $pragmaLen + 1 );
		if ( $foundPosEnd !== false ) {
			$foundPosTagEnd = strpos( $msg, "]", $foundPosBegin + $pragmaLen + 1 );
			if ( ( $foundPosTagEnd !== false ) && ( $foundPosTagEnd < $foundPosEnd ) ) {
				// found [menu .... : $cbMenuTreePath /] : check to see if $cbMenuTreePath is in current menu:
		    	$cbMenuTreePath = substr( $msg, $foundPosTagEnd + 1, $foundPosEnd - ($foundPosTagEnd + 1) );
		    	$cbMenuTreePathArray = explode( ":", $cbMenuTreePath );
	    		$pm = $_PLUGINS->getMenus();
	    		$pmc=count($pm);
				for ( $i=0; $i<$pmc; $i++ ) {
					if ( $pm[$i]['position'] == $position ) {
						$arrayPos = $pm[$i]['arrayPos'];
						foreach ( $cbMenuTreePathArray as $menuName ) {
							if ( key( $arrayPos ) == trim( $menuName ) ) {
								$arrayPos = $arrayPos[key( $arrayPos )];
							} else {
								// not matching full menu path: check next:
								break;
							}
						}
						if ( !is_array( $arrayPos ) ) {
							// came to end of path: match found: stop searching:
							break;
						}
					}
				}
				// replace by nothing in case not found:
				$replaceString = "";
				if ( $i < $pmc ) {
					// found: replace with menu item: first check for qualifiers for special changes:
		    		$cbMenuTags = substr( $msg, $foundPosBegin + $pragmaLen + 1, $foundPosTagEnd - ($foundPosBegin + $pragmaLen + 1) );
		    		if ($htmlspecialcharsEncoded) {
		    			$cbMenuTags = unHtmlspecialchars( $cbMenuTags );
		    		}
					$cbMenuTagsArray = cbExplodeTags( $cbMenuTags, array( "href", "target", "title", "class", "style", "img", "caption") );
					
					$replaceString .= cbPlaceTags( $cbMenuTagsArray, 'href', $pm[$i], 'url', '<a href="$1"'
												. cbPlaceTags( $cbMenuTagsArray, 'target', $pm[$i], 'target', ' target="$1"' )
												. cbPlaceTags( $cbMenuTagsArray, 'title', $pm[$i], 'tooltip', ' title="$1"' )
												. cbPlaceTags( $cbMenuTagsArray, 'class', $pm[$i], 'undef', ' class="$1"' )
												. cbPlaceTags( $cbMenuTagsArray, 'style', $pm[$i], 'undef', ' style="$1"' )
												. ">"
											  );
					$replaceString .= cbPlaceTags( $cbMenuTagsArray, 'img', $pm[$i], 'img', '$1' );
					$replaceString .= cbPlaceTags( $cbMenuTagsArray, 'caption', $pm[$i], 'caption', '$1' );
					$replaceString .= cbPlaceTags( $cbMenuTagsArray, 'href', $pm[$i], 'url', '</a>' );
					
							/*	$this->menuBar->addObjectItem( $pm[$i]['arrayPos'], $pm[$i]['caption'],
								isset($pm[$i]['url'])	?$pm[$i]['url']		:"",
								isset($pm[$i]['target'])?$pm[$i]['target']	:"",
								isset($pm[$i]['img'])	?$pm[$i]['img']		:null,
								isset($pm[$i]['alt'])	?$pm[$i]['alt']		:null,
								isset($pm[$i]['tooltip'])?$pm[$i]['tooltip']:null,
								isset($pm[$i]['keystroke'])?$pm[$i]['keystroke']:null );
							*/
				}
				$msgResult .= substr( $msg, 0, $foundPosBegin );
				$msgResult .= $replaceString;
				$msg		= substr( $msg, $foundPosEnd + $pragmaLen + 3 );
		//        $srchtxt = "[menu:".$cbMenuTreePath."]";    // get new search text  
		//        $msg = str_replace($srchtxt,$replaceString,$msg);    // replace founded case insensitive search text with $replace 
			} else {
				break;
			}
    	} else {
    		break;
    	}
    }
   	return $msgResult . $msg;
}
/**
 * Replaces [fieldname] by the content of the user row (except for [password])
 *
 * @param string $msg
 * @param object $row
 * @return unknown
 */
function cbReplaceVars( $msg, $row, $htmlspecialcharsEncoded = true ){
	$array = get_object_vars($row);
	foreach( $array AS $k=>$v) {
		if(!is_object($v)) {
			if (!(strtolower($k) == "password"    /* && strlen($v) >= 32 */      )) {
				$msg = cbstr_ireplace("[".$k."]", getLangDefinition($v), $msg );
			}
		}
	}
	
	// find [menu .... : path1:path2:path3 /] and replace with HTML code if menu active, otherwise remove it all
	$msg = cbReplacePragma( $msg, $row, 'menu', 'menuBar', $htmlspecialcharsEncoded );
	$msg = cbReplacePragma( $msg, $row, 'status', 'menuList', $htmlspecialcharsEncoded );
	
	$msg = str_replace( array( "&91;", "&93;" ), array( "[", "]" ), $msg );
	return $msg;
}

/**
* Random string of a-z,A-Z,0-9 generator
* 
* @param  int       $stringLength  number of chars
* @return password
*/
function cbMakeRandomString( $stringLength = 8, $noCaps = false ) {
	if ( $noCaps ) {
		$chars		=	'abchefghjkmnpqrstuvwxyz0123456789';
	} else {
		$chars		=	'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	}
	$len			=	strlen( $chars );
	$rndString		=	'';
	mt_srand( 10000000 * (double) microtime() );
	for ( $i = 0; $i < $stringLength; $i++ ) {
		$rndString	.=	$chars[mt_rand( 0, $len - 1 )];
	}
	return $rndString;
}

/**
* Generate the hashed/salted/encoded password for the database
* and to check the password at login:
* if $row provided, it is checking the existing password (and update if needed)
* if not provided, it will generate a new hashed password
*
* @param  string          $passwd  cleartext
* @param  mosUser         $row
* @return string|boolean  salted/hashed password if $row not provided, otherwise TRUE/FALSE on password check
*/
function cbHashPassword( $passwd, $row = null ) {
	global $_VERSION, $_CB_database;
	$method			=	'md5';
	if ( ($_VERSION->PRODUCT == "Joomla!") || ($_VERSION->PRODUCT == "Accessible Joomla!") ) {
		// $build_arr	=	array();
		// if ( preg_match( '/[0-9]+/', $_VERSION->BUILD, $build_arr )  && ( $build_arr[0] >= 7813 ) ) {
		if ( ( $_VERSION->RELEASE == '1.0' ) && ( $_VERSION->DEV_LEVEL >= 13 ) )	{
			// 1.0.13+ (in fact RC3+):
			$method			=	'md5salt';
			$saltLength		=	16;				
		}
		if ( $_VERSION->RELEASE >= '1.5' ) {
			// 1.5 (in fact RC1+):
			$method			=	'md5salt';
			$saltLength		=	32;
		}
	}
	switch ( $method ) {
		case 'md5salt':
			if ( $row ) {
				$parts			=	explode( ':', $row->password );
				if ( count( $parts ) > 1 ) {
					$salt		=	$parts[1];
				} else {
					// check password, if ok, auto-upgrade database:
					$salt		=	cbMakeRandomString( $saltLength );
					$crypt		=	md5( $passwd . $salt );
					$hashedPwd	=	$crypt. ':' . $salt;
					if ( md5( $passwd ) === $row->password ) {
						$query	= "UPDATE #__users SET password = '"
								. $_CB_database->getEscaped( $hashedPwd ) . "'"
								. " WHERE id = " . (int) $row->id;
						$_CB_database->setQuery( $query );
						$_CB_database->query();
						$row->password	=	$hashedPwd;
					}
				}
			} else {
				$salt		=	cbMakeRandomString( $saltLength );
			}
			$crypt			=	md5( $passwd . $salt );
			$hashedPwd		=	$crypt. ':' . $salt;
			break;
	
		case 'md5':
		default:
			if ( $row ) {
				$parts			=	explode( ':', $row->password );
				if ( count( $parts ) > 1 ) {
					// check password, if ok, auto-downgrade database:
					$salt		=	$parts[2];
					$crypt		=	md5( $passwd . $salt );
					$hashedPwd	=	$crypt. ':' . $salt;
					if ( $hashedPwd === $row->password ) {
						$hashedPwd	=	md5( $passwd );
						$query	= "UPDATE #__users SET password = '"
								. $_CB_database->getEscaped( $hashedPwd ) . "'"
								. " WHERE id = " . (int) $row->id;
						$_CB_database->setQuery( $query );
						$_CB_database->query();
						$row->password	=	$hashedPwd;
					}
				}
			}
			$hashedPwd		=	md5( $passwd );
			break;
	}
	if ( $row ) {
		return ( $hashedPwd === $row->password );
	} else {
		return $hashedPwd;
	}
}


/**
 * CB registration spam protections:
 */
function cbGetRegAntiSpams( $decrement = 0, $salt = null ) {
	global $mainframe, $my;
	if ( $salt === null ) {
		$salt		=	cbMakeRandomString( 16 );
	}
	$time	 	=	time();
	$valtime	=	( (int) ( $time / 1800 )) - $decrement;
	// no IP addresses here, since on AOL it changes all the time.... $hostIPs = cbGetIParray();
	if ( strlen( $salt ) == 16 ) {
		$validate = array();
		$validate[0] = 'cbrv1_' . md5( $salt . $mainframe->getCfg('secret') . $valtime ) . '_' . $salt;
		$validate[1] = 'cbrv1_' . md5( $salt . $mainframe->getCfg( 'db' )   . $valtime ) . '_' . $salt;
		return $validate;
	} else {
		header( 'HTTP/1.0 403 Forbidden' );
		echo "<script>alert(\"" . _UE_SESSION_EXPIRED ."\"); window.history.go(-1);</script> \n";
		exit;
	}
}
function cbGetRegAntiSpamFieldName() {
	return 'cbrasitway';
}
function cbGetRegAntiSpamInputTag( $cbGetRegAntiSpams = null ) {
	if ( $cbGetRegAntiSpams === null ) {
		$cbGetRegAntiSpams = cbGetRegAntiSpams();
	}
	setcookie( "cbrvs", $cbGetRegAntiSpams[1], false, '/' );
	return "<input type=\"hidden\" name=\"" . cbGetRegAntiSpamFieldName() ."\" value=\"" .  $cbGetRegAntiSpams[0] . "\" />\n";
}

function cbRegAntiSpamCheck() {
	global $_POST, $_COOKIE;

	$validateValuePost	 	=	cbGetParam( $_POST, cbGetRegAntiSpamFieldName() );
	$validateValueCookie	=	cbGetParam( $_COOKIE, "cbrvs" );
	$parts					=	explode( '_', $validateValuePost );
	if ( count( $parts ) == 3 ) {
		for($i = 0; $i < 2; $i++) {
			$validate		=	cbGetRegAntiSpams( $i, $parts[2] );
			if ( ( $validateValuePost == $validate[0] ) && ( $validateValueCookie == $validate[1] ) ) {
				break;
			}
		}
	} else {
		$i	=	2;
	}
	if ( $i == 2 ) {
		echo "<script>alert(\"" . _UE_SESSION_EXPIRED . "\"); window.history.go(-1);</script> \n";
		exit;
	}
}

/**
 * CB email to user spam protections:
 */
function cbGetAntiSpams( $salt = null ) {
	global $mainframe, $_CB_database, $my;
	
	if ( $salt === null ) {
		$salt		=	cbMakeRandomString( 32 );
	}
	$query = "SELECT message_number_sent, message_last_sent FROM #__comprofiler WHERE id = " . (int) $my->id;
	$_CB_database->setQuery($query);
	$users = $_CB_database->loadObjectList();
	if ( ( strlen( $salt ) == 32 ) && is_array( $users ) && ( count( $users ) == 1 ) ) {
		$message_number_sent	= $users[0]->message_number_sent;
		$message_last_sent		= $users[0]->message_last_sent;
		$validate = array();
		$validate[0] = 'cbsv1_' . md5( $salt . $mainframe->getCfg('secret') .  $mainframe->getCfg( 'db' ) . $message_number_sent . $message_last_sent . $my->id )       . '_' . $salt;
		$validate[1] = 'cbsv1_' . md5( $salt . $mainframe->getCfg('secret') .  $mainframe->getCfg( 'db' ) . $message_number_sent . $message_last_sent . $my->username ) . '_' . $salt;
		return $validate;
	} else {
		header( 'HTTP/1.0 403 Forbidden' );
		echo "<script>alert(\"" . _UE_SESSION_EXPIRED ."\"); window.history.go(-1);</script> \n";
		exit;
	}
}
function cbGetAntiSpamInputTag() {
	$validate = cbGetAntiSpams();
	setcookie( "cbvs", $validate[1], false, '/' );
	return "<input type=\"hidden\" name=\"cbvssps\" value=\"" .  $validate[0] . "\" />\n";
}
function cbAntiSpamCheck( $autoBack = true ) {
	global $_POST, $_COOKIE;

	$validateValuePost	 	=	cbGetParam( $_POST, 'cbvssps', '' );
	$validateValueCookie	=	cbGetParam( $_COOKIE, "cbvs", '' );
	$parts					=	explode( '_', $validateValuePost );
	if ( count( $parts ) == 3 ) {
		$validate			=	cbGetAntiSpams( $parts[2] );
	}
	if ( ( count( $parts ) != 3 ) || ( $validateValuePost !== $validate[0] ) || ( $validateValueCookie !== $validate[1] ) ) {
		if ( $autoBack ) {
			header( 'HTTP/1.0 403 Forbidden' );
			echo "<script>alert(\"" . _UE_SESSION_EXPIRED . ' ' . _UE_PLEASE_REFRESH . "\"); window.history.go(-1);</script> \n";
			exit;
		} else {
			return _UE_SESSION_EXPIRED;
		}
	}
	return null;
}
function cbSpamProtect( $userid, $count ) {
	global $_CB_database;
	
	$maxmails		= 10;		// mails per
	$maxinterval	= 24*3600;	// hours (expressed in seconds) limit
	
	$time = time();
	
	$query = "SELECT message_number_sent, message_last_sent FROM #__comprofiler WHERE id = " . (int) $userid;
	$_CB_database->setQuery($query);
	$users = $_CB_database->loadObjectList();
	if ( is_array($users) && ( count($users) == 1 ) ) {
		$message_number_sent	= $users[0]->message_number_sent;
		$message_last_sent		= $users[0]->message_last_sent;
		if ( $message_last_sent != '0000-00-00 00:00:00' ) { 
			list( $y, $c, $d, $h, $m, $s ) = sscanf( $message_last_sent, "%4d-%2d-%2d\t%2d:%2d:%2d" );
			$expiryTime = mktime($h, $m, $s, $c, $d, $y) + $maxinterval;
			if ( $time < $expiryTime ) {
				if ( $message_number_sent >= $maxmails ) {
					if (!defined('_UE_MAXEMAILSLIMIT')) DEFINE('_UE_MAXEMAILSLIMIT','You exceeded the maximum limit of %d emails per %d hours. Please try again later.');
					return sprintf( _UE_MAXEMAILSLIMIT, $maxmails, $maxinterval/3600 );
				} else {
					if ( $count ) {
						$query = "UPDATE #__comprofiler SET message_number_sent = message_number_sent + 1 WHERE id = " . (int) $userid;
						$_CB_database->setQuery($query);
						$users = $_CB_database->query();
					}
				}
			} else {
				if ( $count ) {
					$query = "UPDATE #__comprofiler SET message_number_sent = 1, message_last_sent = NOW() WHERE id = " . (int) $userid;
					$_CB_database->setQuery($query);
					$users = $_CB_database->query();
				}
			}
		} else {
			if ( $count ) {
				$query = "UPDATE #__comprofiler SET message_number_sent = 1, message_last_sent = NOW() WHERE id = " . (int) $userid;
				$_CB_database->setQuery($query);
				$users = $_CB_database->query();
			}
		}
		return null;
	} else {
		return "Not Authorized";
	}
}

	function getFieldEntry($ui,&$calendars,$oType,$oName,$oDescription,$oTitle,$oValue,$oReq,$oLabel,$oID,$oSize, $oMaxLen, $oCols, $oRows,$oProfile, $rowFieldValues=null,$oReadOnly=0) {
		global $ueConfig,$_CB_database,$mosConfig_live_site;

		if($oSize > 0) $pSize=" size='".$oSize."' ";
		else $pSize="";
		if($oMaxLen > 0) $pMax=" maxlength='".$oMaxLen."' ";	
		else $pMax="";
		if($oCols > 0) $pCols=" cols='".$oCols."' ";	
		else $pCols="";
		if($oRows > 0) $pRows=" rows='".$oRows."' ";	
		else $pRows="";
		if($oReadOnly > 0) { 
			$pReadOnly=" disabled=\"disabled\" ";
			$oReq=0;
		} else { 
			$pReadOnly="";
		}
		$mosReq = "mosReq=\"".$oReq."\"";
		$displayFieldIcons = true;
		SWITCH ($oType){
			CASE 'text':
				$oReturn = "<input class=\"inputbox\" $pReadOnly $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" $pSize $pMax type=\"text\" name=\"".$oName."\" value=\"".htmlspecialchars($oValue)."\" />";
			break;
			CASE 'textarea':
				$oReturn = "<textarea class=\"inputbox\" $pReadOnly $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" $pCols $pRows  name=\"".$oName."\">".htmlspecialchars($oValue)."</textarea>";		//TBD: limit by pmax using JS
			break;
			CASE 'editorta':
				if(!($oReadOnly > 0)) {
					ob_start();
					editorArea( 'editor'.$oName ,  $oValue , $oName , 500, 350, $oCols, $oRows ) ;
					$oReturn=ob_get_contents();
					ob_end_clean();
					$oReturn .= ' <script type="text/javascript"> document.adminForm.'.$oName.".setAttribute('mosReq',".$oReq."); document.adminForm.".$oName.".setAttribute('mosLabel','".getLangDefinition($oLabel)."'); </script>";
				} else {
					$oReturn = $oValue;
				}
			break;
			CASE 'select':
			CASE 'multiselect':
			CASE 'radio':
			CASE 'multicheckbox':
				$oReturn = $rowFieldValues;
			break;
			CASE 'checkbox':
				$checked='';
				if($oValue!='' && $oValue != null && $oValue==1) $checked=" checked=\"checked\"";
				$oReturn = "<input $pReadOnly $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" type=\"checkbox\" $checked name=\"".$oName."\" value=\"1\" />";		
			break;
			CASE 'hidden':
				$oReturn = "<input $pReadOnly mosLabel=\"".getLangDefinition($oLabel)."\" type=\"hidden\" name=\"".$oName."\" value=\"".htmlspecialchars($oValue)."\" />";
			break;
			CASE 'password':
				$oReturn = "<input class=\"inputbox\" $pReadOnly $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" type=\"password\" name=\"".$oName."\" value=\"".htmlspecialchars($oValue)."\" />";
			break;
			CASE 'date':
				$oReturn = $calendars->cbAddCalendar($oName,$oLabel,$oReq,$oValue,$oReadOnly);
			break;
			CASE 'emailaddress':
				$oReturn = "<input class=\"inputbox\" $pReadOnly $pMax $mosReq $pSize mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" name=\"".$oName."\" id=\"".$oName."\" value=\"".htmlspecialchars($oValue)."\" />";
			break;
			CASE 'webaddress':
				if ($oRows!=2) {
					$oReturn = "<input class=\"inputbox\" $pReadOnly $pMax $pSize $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" name=\"".$oName."\" id=\"".$oName."\" value=\"".htmlspecialchars($oValue)."\" />";
				} else {
					$oValuesArr=array();
					$oValuesArr = explode("|*|",$oValue);
					if (count($oValuesArr) < 2) $oValuesArr[1]="";
					$oReturn = "<span class=\"webUrlSpan\">";
					$oReturn .= "<span class=\"subTitleSpan\">"._UE_WEBURL.":</span>";
					$oReturn .= "<span class=\"subFieldSpan\"><input class=\"inputbox\" $pReadOnly $pMax $pSize $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" name=\"".$oName."\" id=\"".$oName."\" value=\"".htmlspecialchars($oValuesArr[0])."\" />";
					$oReturn .= getFieldIcons($ui, $oReq, $oProfile, $oDescription, $oTitle)."</span>";
					$displayFieldIcons = false;
					
					$oReturn .= "</span><span class=\"webTextSpan\">";
					$oReturn .= "<span class=\"subTitleSpan\">"._UE_WEBTEXT.":</span>";
					$oReturn .= "<span class=\"subFieldSpan\"><input class=\"inputbox\" $pReadOnly $pMax $pSize $mosReq mosLabel=\"".getLangDefinition($oLabel)."\" type=\"text\" name=\"".$oName."Text\" id=\"".$oName."Text\" value=\"".htmlspecialchars($oValuesArr[1])."\" /></span>";
					$oReturn .= "</span>";
				}			
				break;
			CASE 'delimiter':
				$oReturn = '';
		
		}
		if ($oReturn and $displayFieldIcons) $oReturn .= getFieldIcons($ui, $oReq, $oProfile, $oDescription, $oTitle);
		return $oReturn;
	}

/**
 * ACL functions:
 */

	/**
	 * Checks if $oID userid is a moderator for CB
	 *
	 * @param int  $oID
	 * @return boolean   true is moderator, otherwise false
	 */
	function isModerator( $oID ) {
		global $ueConfig;

		static $uidArry		=	array();	// cache

		$oID				=	(int) $oID;
		if ( ! isset( $uidArry[$oID] ) ) {
			$uidArry[$oID]	=	( $oID && in_array( userGID( $oID ), getParentGIDS( $ueConfig['imageApproverGid'] ) ) );
		}
		return $uidArry[$oID];
	}
	/**
	 * Gives ACL group id of userid $oID
	 *
	 * @param int $oID   user id
	 * @return int       ACL group id
	 */
	function userGID( $oID ){
	  	global $_CB_database, $ueConfig;
	
		static $uidArry			=	array();	// cache

		$oID					=	(int) $oID;
		if ( ! isset( $uidArry[$oID] ) ) {
		  	if( $oID > 0 ) {
				$query			=	"SELECT gid FROM #__users WHERE id = ".(int) $oID;
				$_CB_database->setQuery( $query );
				$uidArry[$oID]	=	$_CB_database->loadResult();
			}
			else {
				$uidArry[$oID]	=	0;
			}
		}
		return $uidArry[$oID];
	}

	function allowAccess( $accessgroupid, $recurse, $usersgroupid) {
		global $_CB_database;
	
		if ($accessgroupid == -2 || ($accessgroupid == -1 && $usersgroupid > 0)) {
			//grant public access or access to all registered users
			return true;
		}
		else {
			//need to do more checking based on more restrictions
			if( $usersgroupid == $accessgroupid ) {
				//direct match
				return true;
			}
			else {
				if ($recurse=='RECURSE') {
					//check if there are children groups
	
					//$groupchildren=$acl->get_group_children( $usersgroupid, 'ARO', $recurse );
					//print_r($groupchildren);
					$groupchildren=array();
					$groupchildren=getParentGIDS($accessgroupid);
					if ( is_array( $groupchildren ) && count( $groupchildren ) > 0) {
						if ( in_array($usersgroupid, $groupchildren) ) {
							//match
							return true;
						}
					}
				}
			}
			//deny access
			return false;
		}
	}
	function cbGetAllUsergroupsBelowMe( ) {
		global $acl, $my;

		// ensure user can't add group higher than themselves
		if ( checkJversion() <= 0 ) {
			$my_groups 	= $acl->get_object_groups( 'users', $my->id, 'ARO' );
		} else {
			$aro_id		= $acl->get_object_id( 'users', $my->id, 'ARO' );
			$my_groups 	= $acl->get_object_groups( $aro_id, 'ARO' );
		}
		if (is_array( $my_groups ) && count( $my_groups ) > 0) {
			$ex_groups = $acl->get_group_children( $my_groups[0], 'ARO', 'RECURSE' );
			if ( $ex_groups === null ) {
				$ex_groups	=	array();		// Mambo
			}
		} else {
			$ex_groups		=	array();
		}

		$gtree = $acl->get_group_children_tree( null, 'USERS', false );

		// remove users 'above' me
		$i = 0;
		while ($i < count( $gtree )) {
			if (in_array( $gtree[$i]->value, $ex_groups )) {
				array_splice( $gtree, $i, 1 );
			} else {
				$i++;
			}
		}
		return $gtree;
	}
	function getChildGIDS( $gid ) {
		global $_CB_database;

		static $gidsArry			=	array();	// cache

		$gid		=	(int) $gid;

		if ( ! isset( $gidsArry[$gid] ) ) {
			if ( checkJversion() <= 0 ) {
	           	$query	=	"SELECT g1.group_id, g1.name"
				."\n FROM #__core_acl_aro_groups g1"
				."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft >= g1.lft"
				."\n WHERE g2.group_id =" . (int) $gid
				."\n ORDER BY g1.name";
			} else {
	           	$query	=	"SELECT g1.id AS group_id, g1.name"
				."\n FROM #__core_acl_aro_groups g1"
				."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft >= g1.lft"
				."\n WHERE g2.id =" . (int) $gid
				."\n ORDER BY g1.name";
			}
			$standardlist		=	array( -2 );
			if( $gid > 0) {
				$standardlist[]	=	-1;
			}
	       	$_CB_database->setQuery( $query );
			$gidsArry[$gid]		=	$_CB_database->loadResultArray();
	      	if ( ! is_array( $gidsArry[$gid] ) ) {
	       		$gidsArry[$gid]	=	array();
	       	}
			$gidsArry[$gid]		=	array_merge( $gidsArry[$gid], $standardlist );
		}
		return $gidsArry[$gid];
	}
	
	function getParentGIDS( $gid ) {
		global $_CB_database;

		static $gidsArry			=	array();	// cache

		$gid		=	(int) $gid;

		if ( ! isset( $gidsArry[$gid] ) ) {
			if ( checkJversion() <= 0 ) {
	          	$query	=	"SELECT g1.group_id, g1.name"
				."\n FROM #__core_acl_aro_groups g1"
				."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft <= g1.lft"
				."\n WHERE g2.group_id =" . (int) $gid
				."\n ORDER BY g1.name";
			} else {
	          	$query	=	"SELECT g1.id AS group_id, g1.name"
				."\n FROM #__core_acl_aro_groups g1"
				."\n LEFT JOIN #__core_acl_aro_groups g2 ON g2.lft <= g1.lft"
				."\n WHERE g2.id =" . (int) $gid
				."\n ORDER BY g1.name";
			}
	       	$_CB_database->setQuery( $query );
			$gidsArry[$gid]		=	$_CB_database->loadResultArray();
	      	if ( ! is_array( $gidsArry[$gid] ) ) {
	       		$gidsArry[$gid]	=	array();
	       	}
		}
		return $gidsArry[$gid];
	}

	/**
	 * Backend: Check if users are of lower permissions than current user (if not super-admin) and if the user himself is not included
	 *
	 * @param array of userId $cid
	 * @param string $actionName to insert in message.
	 * @return string of error if error, otherwise null
	 */
	function checkCBpermissions( $cid, $actionName, $allowActionToMyself = false ) {
		global $_CB_database, $acl,$_PLUGINS, $ueConfig, $my;

		$msg = null;
		if (is_array( $cid ) && count( $cid )) {
			$obj = new mosUser( $_CB_database );
			foreach ($cid as $id) {
				if ( $id != 0 ) {
					$obj->load( (int) $id );
					if ( checkJversion() <= 0 ) {
						$groups 	= $acl->get_object_groups( 'users', $id, 'ARO' );
					} else {
						$aro_id		= $acl->get_object_id( 'users', $id, 'ARO' );
						$groups 	= $acl->get_object_groups( $aro_id, 'ARO' );
					}
					$this_group 	= strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
				} else {
					$this_group = 'Registered';		// minimal user group
					$obj->gid 	= $acl->get_group_id( $this_group, 'ARO' );
				}
	
				if ( ( ! $allowActionToMyself ) && ( $id == $my->id ) ){
	 				$msg .= "You cannot ".$actionName." Yourself! ";
	 			} else {
	 				$myGid		=	userGID( $my->id );
	 				if (($obj->gid == $myGid && !in_array($myGid, array(24, 25))) ||
	 					   ($id && $obj->gid && !in_array($obj->gid,getChildGIDS($myGid))))
	 				{
						$msg .= "You cannot ".$actionName." a `".$this_group."`. Only higher-level users have this power. ";
	 				}
				}
			}
		}
		return $msg;
	}
	/**
	 * Frontend: Check if task is enabled in front-end and if user is himself, or a moderator allowed to perform a task onto that other user in frontend
	 *
	 * @param  int    $uid              userid  !!! WARNING if is 0 it will assign $my->id to it !!!
	 * @param  string $ueConfigVarName  $ueConfig variable name to be checked if == 0: mods disabled, == 1.: all CB mods, > 1: it's the GID (24 or 25 for now)
	 * @return string|null              null: allowed, string: not allowed, error string
	 */
	function cbCheckIfUserCanPerformUserTask( &$uid, $ueConfigVarName ) {
		global $my, $acl, $ueConfig;

		if ( $uid == 0 ) {
			$uid				=	$my->id;
		}

		if ( $uid == 0 ) {
			$ret				=	false;
		} elseif ( $uid == $my->id ) {
			// user can perform task on himself:
			$ret				=	null;
		} else {
			if ( ( ! isset( $ueConfig[$ueConfigVarName] ) ) || ( $ueConfig[$ueConfigVarName] == 0 ) ) {
				$ret			=	_UE_FUNCTIONALITY_DISABLED;
			} elseif ( $ueConfig[$ueConfigVarName] == 1 ) {
				// site moderators can act on non-pears and above:
				$isModerator	=	isModerator($my->id);
				if ( ! $isModerator ) {
					$ret		=	false;
				} else {
					$cbUserIsModerator	=	isModerator( $uid );
					if ( $cbUserIsModerator ) {
						// moderator acting on other moderator: only if level below him:
						$ret	=	checkCBpermissions( array($uid), "edit", true );
					} else {
						// moderator acts on normal user: ok
						$ret	=	null;
					}
				}
			} elseif ( $ueConfig[$ueConfigVarName] > 1 ) {
				if ( in_array( userGID( $my->id ), getParentGIDS( $ueConfig[$ueConfigVarName] ) ) ) {
					$ret		=	null;
				} else {
					$ret		=	false;
				}
			} else {
				$ret			=	false;	// Safeguard :)
			}
		}
		if ( $ret === false ) {
			$ret		=	_UE_NOT_AUTHORIZED;
			if ($my->id < 1) {
				$ret 	.=	'<br />' . _UE_DO_LOGIN;
			}
		}
		return $ret;
	}

	/**
	 * Check Joomla/Mambo version for API
	 *
	 * @return int API version: =0 = mambo 4.5.0-4.5.3+Joomla 1.0.x, =1 = Joomla! 1.1, >1 newever ones: maybe compatible, <0: -1: Mambo 4.6
	 */
	function checkJversion() {
		global $_VERSION;
		
		static $version	=	null;
		
		if ( $version !== null ) {
			return $version;
		}

		if ( $_VERSION->PRODUCT == "Mambo" ) {
			if ( strncasecmp( $_VERSION->RELEASE, "4.6", 3 ) < 0 ) {
				$version = 0;
			} else {
				$version = -1;
			}
		} elseif ( $_VERSION->PRODUCT == "Elxis" ) {
			$version	 = 0;
		} elseif ( ($_VERSION->PRODUCT == "Joomla!") || ($_VERSION->PRODUCT == "Accessible Joomla!") ) {
			if (strncasecmp($_VERSION->RELEASE, "1.0", 3)) {
				$version = 1;
			} else {
				$version = 0;
			}
		}
		return $version;
	}

	/**
	 * Deletes a user without any check or warning
	 *
	 * @param int $id userid
	 * @param string $condition php condition string on $user e.g. "return (\$user->block == 1);"
	 * @param string $inComprofilerOnly deletes user only in CB, not in Mambo/Joomla
	 * @return mixed : "" if user deleted and found ok, null if user not found, false if condition was not met, string error in case of error raised by plugin
	 */
	function cbDeleteUser ( $id, $condition = null, $inComprofilerOnly = false ) {
		global $_CB_database, $_PLUGINS;

		$msg = null;
		$obj = new mosUser( $_CB_database );
		$obj2 = new moscomprofiler( $_CB_database );

		$query = "SELECT * FROM #__comprofiler c LEFT JOIN #__users u ON c.id = u.id WHERE c.id = " . (int) $id;
		$_CB_database->setQuery($query);
		$user = $_CB_database->loadObjectList();

		if ( is_array( $user ) && ( count( $user ) > 0 ) ) {
			$user = $user[0];
			
			if ( ( $condition == null ) || eval( $condition ) ) {
				$_PLUGINS->loadPluginGroup( 'user' );
				$_PLUGINS->trigger( 'onBeforeDeleteUser', array( $user ) );
				if ( $_PLUGINS->is_errors() ) {
					$msg = $_PLUGINS->getErrorMSG();
				} else {
					deleteAvatar( $user->avatar );
					$reports = new moscomprofilerUserReport( $_CB_database );
					$reports->deleteUserReports ( $user->id );
					_cbdeleteUserViews( $user->id );
					if ( ! $inComprofilerOnly ) {
						$obj->delete( $id );
						$msg .= $obj->getError();
					}
					$obj2->delete( $id );
					$msg .= $obj2->getError();
					
					// delete user acounts active sessions
					$query = "DELETE FROM #__session"
				 	. "\n WHERE userid = " . (int) $id
				 	;
					$_CB_database->setQuery( $query );
					$_CB_database->query();

					$_PLUGINS->trigger( 'onAfterDeleteUser', array( $user, true ) );
				}
			} else {
				$msg = false;
			}
		}
		return $msg;
	}
	/**
	 * Computes page title, sets page title and pathway
	 *
	 * @param  mosUser $user
	 * @param  string  $thisUserTitle    Title if it's the user displaying
	 * @param  string  $otherUserTitle   Title if it's another user displayed
	 * @return string  title (plaintext, without htmlspecialchars or slashes)
	 */
	function cbSetTitlePath( $user, $thisUserTitle, $otherUserTitle ) {
		global $my, $ueConfig, $mainframe;

		if ( $my->id == $user->id ) {
			$title	=	$thisUserTitle;
		} else {
			$name	=	getNameFormat( $user->name, $user->username, $ueConfig['name_format'] );
			$title	=	sprintf( $otherUserTitle, $name );
		}
		if ( method_exists($mainframe,"setPageTitle")) {
			$mainframe->setPageTitle( $title );
		}
		if ( method_exists($mainframe,"appendPathWay")) {
			$mainframe->appendPathWay( htmlspecialchars( $title ) );
		}
		return $title;
	}
	/**
	 * Redirects user to a/his profile or a given task.
	 *
	 * @param unknown_type $uid
	 * @param unknown_type $message
	 * @param unknown_type $task
	 */
	function cbRedirectToProfile( $uid, $message, $task = null ) {
		global $my;

		$redirectURL		=	"index.php?option=com_comprofiler";
		if ( $my->id != $uid ) {
			$redirectURL	.=	"&amp;user=" . $uid;
		}
		if ( $task ) {
			$redirectURL	.=	"&task=" . $task;
		}
		$redirectURL		.=	getCBprofileItemid();
		cbRedirect( sefRelToAbs( $redirectURL ), $message );
	}

	/**	Gives credits display for frontend and backend
	*	@param int	1=frontend, 2=backend
	*/
	function teamCredits( $ui ) {
		global $ueConfig, $my;
	
		outputCbTemplate( $ui );
		outputCbJs( $ui );

?>
		<table style="width=:100%;border0;align:center;padding:8px;" cellpadding="0" cellspacing="0">
		<tr>
			<td bgcolor="#FFFFFF"> 
				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td style="text-align:center" colspan="2">
					<?php
					if ($ui == 2) {
						echo '<a href="http://www.joomlapolis.com" target="_blank"><img src="../components/com_comprofiler/images/smcblogo.gif" /></a><br />';
						update_checker();
					} else {
						echo "<b>"._UE_SITE_POWEREDBY."</b><br />";
						echo '<a href="http://www.joomlapolis.com" target="_blank" style="border:0px;"><img src="components/com_comprofiler/images/smcblogo.gif" /></a><br />';
					}
					?>
					</td>
				</tr>
				<tr>
					<td style="text-align:center" colspan="2">
					<b>
					Software: Copyright 2004 - 2007 MamboJoe/JoomlaJoe, Beat and CB team. This component is released under the GNU/GPL version 2 License and parts under Community Builder Free License. All copyright statements must be kept. Derivate work must prominently duly acknowledge original work and include visible online links. Official site:<br /><a href="http://www.joomlapolis.com">www.joomlapolis.com</a> .
<?php
		if ( $ui == 1 ) {
?>
					<br /><br />Please note that the authors and distributors of this software are not affiliated in any way with the site owners using this free software, and declines any warranty regarding the content and functions of this site.
<?php
		}
?>
					<br /><br />
					Credits:
					</b>
					<br />
					</td>
				</tr>
				<tr>
					<td style="text-align:center" colspan="2">
					<script language="JavaScript1.2" type="text/javascript"><!--//--><![CDATA[//><!--
					/*
					Fading Scroller- By DynamicDrive.com
					For full source code, and usage terms, visit http://www.dynamicdrive.com
					This notice MUST stay intact for use
					fcontent[4]="<h3>damian caynes<br />inspired digital<br /></h3>Logo Design";
					*/
					var delay=1000 //set delay between message change (in miliseconds)
					var fcontent=new Array()
					begintag='' //set opening tag, such as font declarations
					fcontent[0]="<h3>JoomlaJoe/MamboJoe<br /></h3>Founder &amp; First Developer";
					fcontent[1]="<h3>DJTrail<br /></h3>Co-Founder &amp; Lead Tester";
					fcontent[2]="<h3>Nick A.<br /></h3>Documentation and Public Relations";
					fcontent[3]="<h3>Beat B.<br /></h3>Lead Developer";
					fcontent[4]="<h3>Lou Griffith<br />Spottsfield Entertainment<br /></h3>Logo Design";
					closetag=''
					
					var fwidth='100%'	//'250px' //set scroller width
					var fheight='80px' //set scroller height
					
					var fadescheme=0 //set 0 to fade text color from (white to black), 1 for (black to white)
					var fadelinks=1 //should links inside scroller content also fade like text? 0 for no, 1 for yes.
					
					///No need to edit below this line/////////////////
					
					var hex=(fadescheme==0)? 255 : 0
					var startcolor=(fadescheme==0)? "rgb(255,255,255)" : "rgb(0,0,0)"
					var endcolor=(fadescheme==0)? "rgb(0,0,0)" : "rgb(255,255,255)"
					
					var ie4=document.all&&!document.getElementById
					var ns4=document.layers
					var DOM2=document.getElementById
					var faderdelay=0
					var index=0
					
					if (DOM2)
					faderdelay=2000
					
					//function to change content
					function changecontent(){
						if (index>=fcontent.length)
							index=0
							if (DOM2){
								document.getElementById("fscroller").style.color=startcolor
								document.getElementById("fscroller").innerHTML=begintag+fcontent[index]+closetag
								linksobj=document.getElementById("fscroller").getElementsByTagName("A")
								if (fadelinks)
									linkcolorchange(linksobj)
									colorfade()
								} else if (ie4)
									document.all.fscroller.innerHTML=begintag+fcontent[index]+closetag
								else if (ns4){
								document.fscrollerns.document.fscrollerns_sub.document.write(begintag+fcontent[index]+closetag)
								document.fscrollerns.document.fscrollerns_sub.document.close()
							}
						index++
						setTimeout("changecontent()",delay+faderdelay)
					}
					
					// colorfade() partially by Marcio Galli for Netscape Communications.  ////////////
					// Modified by Dynamicdrive.com
					
					frame=20;
					
					function linkcolorchange(obj){
						if (obj.length>0){
							for (i=0;i<obj.length;i++)
								obj[i].style.color="rgb("+hex+","+hex+","+hex+")"
							}
						}
					
					function colorfade() {
					// 20 frames fading process
					if(frame>0) {
						hex=(fadescheme==0)? hex-12 : hex+12 // increase or decrease color value depd on fadescheme
						document.getElementById("fscroller").style.color="rgb("+hex+","+hex+","+hex+")"; // Set color value.
						if (fadelinks)
							linkcolorchange(linksobj)
							frame--;
							setTimeout("colorfade()",20);
						} else {
							document.getElementById("fscroller").style.color=endcolor;
							frame=20;
							hex=(fadescheme==0)? 255 : 0
						}
					}
					
					if (ie4||DOM2)
						document.write('<div id="fscroller" style="border:0px solid black;width:'+fwidth+';height:'+fheight+';padding:2px"></div>')
						window.onload=changecontent
					//--><!]]></script>
					<ilayer id="fscrollerns" width="&{fwidth};" height="&{fheight};">
						<layer id="fscrollerns_sub" width="&{fwidth};" height="&{fheight};" left=0 top=0></layer>
					</ilayer>
					</td>
				</tr>
			<?php
			if ($ui==2) {
			?><tr>
					<td style="text-align:center" colspan="2"><strong>Please note there is a free installation document, as well as a full documentation subscription for this free component available at <a href="http://www.joomlapolis.com/">www.joomlapolis.com</a></strong><br />&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center" colspan="2">If you like the services provided by this free component, <a href="http://www.joomlapolis.com/">please consider making a small donation to support the team behind it</a><br />&nbsp;</td>
				</tr>
			<?php
			} elseif ( $my->id ) {
			?><tr>
					<td style="text-align:center" colspan="2"><a href="<?php echo cbSefRelToAbs( 'index.php?option=com_comprofiler' .getCBprofileItemid( true ) ); ?>"><?php echo _UE_BACK_TO_YOUR_PROFILE; ?></a><br />&nbsp;</td>
				</tr>
			<?php
			}
			?></table>
		<br />Community Builder includes following components:<br />
		<table class="adminform" cellpadding="0" cellspacing="0" style="border:0; width:100%; text-align:left;">
		<tr>
			<th>
			Application
			</th>
			<?php
			if ($ui==2) {
			?><th>
			Version
			</th>
			<?php
			}
			?><th>
			License
			</th>
		</tr>
		<tr>
			<td>
			<a href="http://www.foood.net" target="_blank">Icons</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			N/A
			</td>
			<?php
			}
			?><td>
			<a href="http://www.foood.net/agreement.htm" target="_blank">
			http://www.foood.net/agreement.htm
			</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="http://webfx.eae.net" target="_blank">Tabs</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			1.02
			</td>
			<?php
			}
			?><td>
			<a href="http://webfx.eae.net/license.html" target="_blank">
			http://webfx.eae.net/license.html
			</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="http://www.dynarch.com/projects/calendar" target="_blank">Calendar</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			1.1
			</td>
			<?php
			}
			?><td>
			<a href="http://www.gnu.org/licenses/lgpl.html" target="_blank">
			GNU Lesser General Public License
			</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="http://www.dynamicdrive.com/dynamicindex7/jasoncalendar.htm" target="_blank">Jason&#039;s Calendar</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			2005-09-05
			</td>
			<?php
			}
			?><td>
			<a href="http://dynamicdrive.com/notice.htm" target="_blank">
			Dynamic Drive terms of use License
			</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="http://www.bosrup.com/web/overlib/" target="_blank">overLib</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			4.17
			</td>
			<?php
			}
			?><td>
			<a href="http://www.bosrup.com/web/overlib/?License" target="_blank">
			http://www.bosrup.com/web/overlib/?License
			</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="http://snoopy.sourceforge.net/" target="_blank">Snoopy</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			1.2.3
			</td>
			<?php
			}
			?><td>
			<a href="http://www.gnu.org/licenses/lgpl.html" target="_blank">
			GNU Lesser General Public License
			</a>
			</td>
		</tr>
		<tr>
			<td>
			<a href="http://www.joomlapolis.com/" target="_blank">BestMenus</a>
			</td>
			<?php
			if ($ui==2) {
			?><td>
			1.0
			</td>
			<?php
			}
			?><td>
			<a href="http://www.joomlapolis.com/" target="_blank">
			Limited Community Builder JoomlaPolis License
			</a>
			</td>
		</tr>
		</table>
			</td>
		</tr>
</table>
<?php
	}

/**
 * Gets an array of IP addresses taking in account the proxys on the way.
 * An array is needed because FORWARDED_FOR can be facked as well.
 * 
 * @return array of IP addresses, first one being host, and last one last proxy (except fackings)
 */
function cbGetIParray() {
	global $_SERVER;
	
	$ip_adr_array = array();
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')) {
			$ip_adr_array +=  explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
		} else {
			$ip_adr_array[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	}
	$ip_adr_array[] = $_SERVER['REMOTE_ADDR'];
	return $ip_adr_array;
}
/**
 * Gets a comma-separated list of IP addresses taking in account the proxys on the way.
 * An array is needed because FORWARDED_FOR can be facked as well.
 * 
 * @return string of IP addresses, first one being host, and last one last proxy (except fackings)
 */
function cbGetIPlist() {
	return addslashes(implode(",",cbGetIParray()));
}
/**
* records the hit to a user profile
* @access private
* @param int viewed user id
*/
function _incHits($profileId) {
	global $_CB_database;
	$_CB_database->setQuery("UPDATE #__comprofiler SET hits=(hits+1) WHERE id=" . (int) $profileId);
	if (!$_CB_database->query()) {
		echo "<script type=\"text/javascript\"> alert('UpdateHits: ".$_CB_database->getErrorMsg()."');</script>\n";
		// exit();
	}
}
/**
* records a visit and the hit with timed protection similar to voting protections
* @param int viewing user id
* @param int viewed user id
* @param IP address of viewing user
*/
function recordViewHit ( $viewerId, $profileId, $currip) {
	global $_CB_database, $ueConfig;

	$query = "SELECT * FROM #__comprofiler_views WHERE viewer_id = " . (int) $viewerId . " AND profile_id = " . (int) $profileId;
	if ($viewerId == 0) $query .= " AND lastip = '" . $_CB_database->getEscaped($currip) . "'";
	$_CB_database->setQuery( $query );
	$views = null;
	if ( !( $_CB_database->loadObject( $views ) ) ) {
		$query = "INSERT INTO #__comprofiler_views ( viewer_id, profile_id, lastip, lastview, viewscount )"
		. "\n VALUES ( " . (int) $viewerId . ", " . (int) $profileId . ", '" . $_CB_database->getEscaped($currip) . "', NOW(), 1 )";
		$_CB_database->setQuery( $query );
		if (!$_CB_database->query()) {
			echo "<script type=\"text/javascript\"> alert('InsertViews: ".$_CB_database->getErrorMsg()."');</script>\n";
			// exit();
		}
		_incHits($profileId);
	} else {
		$lastview = strtotime($views->lastview);
		if ($currip != $views->lastip || time() - $lastview > $ueConfig['minHitsInterval']*60) {
			$query = "UPDATE #__comprofiler_views"
			. "\n SET viewscount = (viewscount+1),"
			. "\n lastview = NOW(),"
			. "\n lastip = '" . $_CB_database->getEscaped($currip) . "'"
			. "\n WHERE viewer_id = " . (int) $viewerId . " AND profile_id = " . (int) $profileId;
			if ($viewerId == 0) $query .= " AND lastip = '" . $_CB_database->getEscaped($currip) . "'";
			$_CB_database->setQuery( $query );
			if (!$_CB_database->query()) {
				echo "<script type=\"text/javascript\"> alert('UpdateViews: ".$_CB_database->getErrorMsg()."');</script>\n";
				// exit();
			}
			_incHits($profileId);
		// } else {
		//	echo "ALREADY_HIT!!!";
		}
	}
}

/**
* a function that does a string based find and replace that is case insensitive.
* @param string value to look for
* @param string value to replace with
* @param string text to be searched
* @return string with text searched and replaced
*/
function cbstr_ireplace($search,$replace,$subject) {
	if ( function_exists('str_ireplace') ) {
		return str_ireplace($search,$replace,$subject);		// php 5 only
	}
	$srchlen = strlen($search);    // lenght of searched string
	$result  = "";

	while ($find = stristr($subject,$search)) {				// find $search text in $subject - case insensitiv
		$srchtxt = substr($find,0,$srchlen);    			// get new case-sensitively-correct search text
		$pos	 = strpos( $subject, $srchtxt );			// stripos is php5 only...
		$result	 .= substr( $subject, 0, $pos ) . $replace;	// replace found case insensitive search text with $replace
		$subject = substr( $subject, $pos + $srchlen );
	}
	return $result . $subject;
}

/**
* Calendars for date fields handler
* @package Community Builder
* @author Beat
*/
class cbCalendars {
	/**	@var int 1=Front End 2=Admin */
	var $ui=0;
	/** @var string Date Format */
    var $dateFormat;
    /** @var int 1=popup 2=jason's */
	var $calendarType;
	/**
	* Constructor
	* Includes files needed for displaying calendar for date fields
	* @param int $ui            user interface: 1=Front End 2=Admin
	* @param int $calendarType  calendar type: 1 = popup only  2=drop downs, null=according to config
	*/
	function cbCalendars($ui, $calendarType = null ) {
		global $mosConfig_live_site, $mainframe, $mosConfig_lang, $ueConfig;
		
		$this->ui			=	$ui;
		if ( $calendarType === null ) {
			if ( isset( $ueConfig['calendar_type'] ) ) {
				$calendarType	=	$ueConfig['calendar_type'];
			} else {
				$calendarType	=	2;
			}
		}
		$this->calendarType	=	$calendarType;

		if ( $this->calendarType == 1 ) {

			$dFind				=	array("d","m","y","Y");
			$dReplace			=	array("%d","%m","%Y","%Y");				// array("%d","%m","%y","%Y"); keep always 4 digits for year
			$this->dateFormat	=	str_replace($dFind, $dReplace, $ueConfig['date_format']);
	
			$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
			if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/calendar-locals.js')) {
				$calendarLangFile = $mosConfig_live_site.'/components/com_comprofiler/plugin/language/'.$mosConfig_lang.'/calendar-locals.js';
			} else {
				$calendarLangFile = $mosConfig_live_site.'/components/com_comprofiler/plugin/language/default_language/calendar-locals.js';
			}
			addCbHeadTag($ui,'<link rel="stylesheet" type="text/css" media="all" href="'.selectTemplate($ui).'calendar.css" title="win2k-cold-1" />'
			."\n".'<script type="text/javascript" src="'. $mosConfig_live_site . '/components/com_comprofiler/js/calendar.js"></script>'."\n"
			.'<script type="text/javascript" src="'. $calendarLangFile . '"></script>'."\n"		// language
			.'<script type="text/javascript" src="'. $mosConfig_live_site . '/components/com_comprofiler/js/calendar-setup.js"></script>');

		} else {

			$dFind				=	array("d","m","Y","y");
			$dReplace			=	array("DD","MM","YYYY","YYYY");			// array("DD","MM","YYYY","YY"); keep always 4 digits for year
			$this->dateFormat	=	str_replace($dFind, $dReplace, $ueConfig['date_format']);

			$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_comprofiler/plugin/language';
			if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/calendar-locals.js')) {
				$calendarLangFile = $mosConfig_live_site.'/components/com_comprofiler/plugin/language/'.$mosConfig_lang.'/calendar-locals.js';
			} else {
				$calendarLangFile = $mosConfig_live_site.'/components/com_comprofiler/plugin/language/default_language/calendar-locals.js';
			}
			addCbHeadTag( $ui,
				  '<script type="text/javascript">Calendar = function () { };</script>'."\n"
				. '<script type="text/javascript" src="'. $calendarLangFile . '"></script>'."\n"		// language
				. '<script type="text/javascript" src="'. $mosConfig_live_site . '/components/com_comprofiler/js/calendardateinput.js"></script>');
		}
	}

	/**
	* echos a calendar field
	* @param string the field name
	* @param string the field label
	* @param boolean true if field is required
	* @param string the existing value (in Y-mm-dd SQL format)
	* @param boolean read-only field
	*/
	function cbAddCalendar( $oName, $oLabel, $oReq, $oValue="", $oReadOnly=false, $showTime=false ) {
		global $ueConfig;

		if ($oValue=='0000-00-00 00:00:00' || $oValue=='0000-00-00') {
			$oValue			=	"";
		} else {
			$fieldForm		=	str_replace( 'y', 'Y', $ueConfig['date_format'] );
			$oValue			=	dateConverter( $oValue, 'Y-m-d', $fieldForm );			// 'date' type of field
		}

		if ( $this->calendarType == 1 ) {
			$vardisabled	=	($oReadOnly) ? ' disabled="disabled"' : '';

			$return = '<input class="inputbox"'.$vardisabled.' mosReq="'.$oReq.'" mosLabel="'.getLangDefinition($oLabel).'"'
					. ' type="text" name="' . $oName .'" readonly="readonly" id="' . $oName . '" value="' . $oValue . '" />'
					. "\n";
			if (!$oReadOnly) {
				$return .= "<script type=\"text/javascript\">\n"
				. "Calendar.setup({"
				. 'inputField : "'.$oName.'",'	// id of the input field
				. 'ifFormat   : "'.$this->dateFormat.($showTime ? ' %H:%M:00' : '').'",'	// format of the input field
				. 'showsTime  : '.($showTime ? 'true' : 'false').','				// will display a time selector
				. 'singleClick: true'				// single-click mode
				. "});\n"
				. "</script>\n";
			}
		} else {
			if ( $oReadOnly ) {
				$return			=	htmlspecialchars( $oValue );
			} else {
				$jsReqBoolean	=	'false';		// in fact this only sets today's date, making our JS for required not working ( $oReq ? 'true' : 'false' );
				$AdditionalInputAttributes	=	( $oReq ? 'mosReq="1" mosLabel="' . htmlspecialchars( getLangDefinition( $oLabel ) ) .'"' : '' );
				// format: "<script>DateInput('orderdate', true, 'DD-MON-YYYY')</script>"
				$oIdName		=	str_replace( array( '[', ']' ), '', $oName );
				$return			=	"<script type=\"text/javascript\">cbcalDateInput('" . $oIdName . "', " . $jsReqBoolean . ", '" . $this->dateFormat . "', '" . $oValue . "', '" . $oName . "', '" . $AdditionalInputAttributes . "')</script>";
			}
		}
		return $return;
	}
}	// end Class cbCalendars


/**
* Tab Creation handler
* @package Mambo
* @author Phil Taylor
* @author Extended by MamboJoe
*/
class cbTabs extends cbTabHandler {
	/** @var int Use cookies */
	var $useCookies = 0;
	/** @var int 1=Front End 2=Admin */
	var $ui=0;
	/**	@var int 1=Display 2=Edit */
	var $action=0;
	/** @var string adds additional validation javascript for edit tabs */
	var $fieldJS="";
	/**	@var cbCalendars object for displaying calendars */
	var $calendars=null;
	/**	@var array of tab objects for displaying */
	var $tabsToDisplay=null;

	/**
	* Constructor
	* Includes files needed for displaying tabs and sets cookie options
	* @param int useCookies, if set to 1 cookie will hold last used tab between page refreshes
	* @param int ui user interface: 1: frontend, 2: backend
	* @param cbCalendar object reference
	* @param boolean: TRUE (DEFAULT): output scripts for tabpanes, FALSE: silent, no echo output
	*/
	function cbTabs($useCookies, $ui, $calendars=null, $outputTabpaneScript=true) {
		global $mosConfig_live_site;

		$this->cbTabHandler();
		$this->ui=$ui;
		$this->useCookies = $useCookies;
		$this->calendars = $calendars;
		if ($outputTabpaneScript) {
			addCbHeadTag( $ui, "<script type=\"text/javascript\" src=\"". $mosConfig_live_site . "/components/com_comprofiler/js/tabpane.js\"></script>" );
		}
	}

	/**
	* creates a tab pane and creates JS obj
	* @param string The Tab Pane Name
	*/
	function startPane($id){
		$return = "<div class=\"tab-pane\" id=\"".$id."\">";
		$return .= "<script type=\"text/javascript\">\n";
		$return .= "   var tabPane".$id." = new WebFXTabPane( document.getElementById( \"".$id."\" ), ".$this->useCookies." )\n";
		$return .= "</script>\n";
		return $return;
	}

	/**
	* Ends Tab Pane
	*/
	function endPane() {
		$return =  "</div>";
		return $return;
	}

	/**
	* Creates a tab with title text and starts that tabs page
	* @param pID - This is the pane unique identifier
	* @param tabText - This is what is displayed on the tab
	* @param paneid - This is the parent pane to build this tab on
	*/
	function startTab( $pID, $tabText, $paneid ) {
		$return = "<div class=\"tab-page\" id=\"cbtab".$paneid."\">";
		$return .= "<h2 class=\"tab\">".$tabText."</h2>";
		$return .= "<script type=\"text/javascript\">\n";
		$return .= "  tabPane".$pID.".addTabPage( document.getElementById( \"cbtab".$paneid."\" ) );";
		$return .= "</script>";
		return $return;
	}

	/**
	* Ends a tab page
	*/
	function endTab() {
		$return =  "</div>";
		return $return;
	}
	/**
	* Loads tabs list from database (if not already loaded)
	* @access private
	* @param object cb user object to display
	* @param string name of position if only one position to display (default: null)
	* @return array of object tabs from comprofiler tabs database (ordered by position, ordering)
	*/	
	function _loadTabsList($user, $position=null) {
		global $_CB_database, $my;
		if ($this->tabsToDisplay === null) {
			$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
			. "\n WHERE t.enabled=1"
			. ($position==null ? "" : "\n AND t.position='" . $_CB_database->getEscaped($position) . "'")
			. "\n AND t.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")"
			. "\n ORDER BY t.position, t.ordering" );
			$this->tabsToDisplay = $_CB_database->loadObjectList();
		}
	}
	/**
	* Gets html code for all cb tabs, sorted by position (default: all, no position name in db means "cb_tabmain")
	* @param object cb user object to display
	* @param string name of position if only one position to display (default: null)
	* @return array of string with html to display at each position, key = position name
	*/	
	function getViewTabs($user, $position=null) {
		global $mosConfig_live_site, $_CB_database, $ueConfig, $_CB_OneTwoRowsStyleToggle;
		$html=array();
		$results=array();
		$oNest=array();
		$i=0;
		$tabNavJS=array();
		$tabOneTwoRowsStyleToggle=array();
		$this->action=1;

		$this->_loadTabsList($user, $position);
		
		if (!is_array($this->tabsToDisplay)) {
			return null;
		}
		//Pass 1: gets all menu and status content
		$oContent=array();
		foreach($this->tabsToDisplay AS $k => $oTab) {
			if($oTab->pluginclass!=null) {
				$this->_callTabPlugin($oTab, $user, $oTab->pluginclass, 'getMenuAndStatus', $oTab->pluginid);
			}
		}
		//Pass 2: generate content
		$oContent=array();
		foreach($this->tabsToDisplay AS $k => $oTab) {
			if (isset($oTab->position) && ($oTab->position != "")) $pos=$oTab->position; else $pos="cb_tabmain";
			if (!isset($tabOneTwoRowsStyleToggle[$pos])) $tabOneTwoRowsStyleToggle[$pos] = 1;
			
			$oContent[$k] = "";
			if($oTab->pluginclass!=null) {
				$_CB_OneTwoRowsStyleToggle = $tabOneTwoRowsStyleToggle[$pos];
				$oContent[$k] .= $this->_callTabPlugin($oTab, $user, $oTab->pluginclass, 'getDisplayTab', $oTab->pluginid);
				$tabOneTwoRowsStyleToggle[$pos] = $_CB_OneTwoRowsStyleToggle;
			}
		}
		foreach($this->tabsToDisplay AS $k => $oTab) {
			if (isset($oTab->position) && ($oTab->position != "")) $pos=$oTab->position; else $pos="cb_tabmain";
			if($oTab->fields) {
				$_CB_OneTwoRowsStyleToggle = $tabOneTwoRowsStyleToggle[$pos];
				$oContent[$k] .= $this->_getViewTabContents( $oTab->tabid, $user );
				$tabOneTwoRowsStyleToggle[$pos] = $_CB_OneTwoRowsStyleToggle;
			}
		}
		//Pass 3: generate formatted output for each position by display type (keeping tabs together in each position)
		foreach($this->tabsToDisplay AS $k => $oTab) {
			if (isset($oTab->position) && ($oTab->position != "")) $pos=$oTab->position; else $pos="cb_tabmain";
			if(!isset($html[$pos])) {
				$html[$pos]="";
				$results[$pos]="";
				$oNest[$pos]="";
				$tabNavJS[$pos]=array();
			}
			if($oContent[$k]!="") {
				$overlaysWidth ="400";						//BB later this could be one more tab parameter...
				switch ($oTab->displaytype) {
					case "html":
						$html[$pos] .= $oContent[$k];
						break;
					case "div":
						$html[$pos] .= "\n\t\t\t<div style=\"width:95%\" class=\"contentheading\">"		// id=\"".$oTab->???."\
									.getLangDefinition($oTab->title)."</div>"
									.  "\n\t\t\t<div class=\"contentpaneopen\" style=\"width:95%\">".$oContent[$k]."</div>";
						break;
					case "overlib":
						$tipTitle = $htmltext = getLangDefinition($oTab->title);
						$fieldTip = "&lt;div class=\"contentpaneopen\" style=\"width:100%\"&gt;".$oContent[$k]."&lt;/div&gt;";
						$style = "class=\"cb-tips-hover\"";
						$olparams = "";
						$html[$pos] .= cbFieldTip($this->ui, $fieldTip, $tipTitle, $overlaysWidth, '', $htmltext, "", $style, $olparams,false);
						break;
					case "overlibfix":
						$tipTitle = $htmltext = getLangDefinition($oTab->title);
						$fieldTip = "&lt;div class=\"contentpaneopen\" style=\"width:100%\"&gt;".$oContent[$k]."&lt;/div&gt;";
						$style = "class=\"cb-tips-hover\"";
						$olparams = "STICKY,NOCLOSE,CLOSETEXT,'"._UE_CLOSE_OVERLIB."'";
						$html[$pos] .= cbFieldTip($this->ui, $fieldTip, $tipTitle, $overlaysWidth, '', $htmltext, "", $style, $olparams,false);
						break;
					case "overlibsticky":
						$tipTitle = $htmltext = getLangDefinition($oTab->title);
						$href = "javascript:void(0)";
						$fieldTip = "&lt;div class=\"contentpaneopen\" style=\"width:100%\"&gt;".$oContent[$k]."&lt;/div&gt;";
						$style = "class=\"cb-tips-button\" title=\""._UE_CLICKTOVIEW." ".$tipTitle."\"";
						$olparams = "STICKY,CLOSECLICK,CLOSETEXT,'"._UE_CLOSE_OVERLIB."'";
						$html[$pos] .= cbFieldTip($this->ui, $fieldTip, $tipTitle, $overlaysWidth, '', $htmltext, $href, $style, $olparams,true);
						break;
					case "tab":
					default:
						//$results .= $this->startPane($pos);	done at the end below
						if ( $ueConfig['nesttabs'] && $oTab->fields && ( ( $oTab->pluginclass == null ) || ( $oTab->sys == 2 ) ) ) {
							$oNest[$pos] .= $this->startTab("CBNest".$pos,getLangDefinition($oTab->title),$oTab->tabid)
									. "\n\t\t\t<div class=\"tab-content\">"
									. $oContent[$k]
									. "</div>\n"
									. $this->endTab();
							$tabNavJS[$pos][$i]->nested = true;
						} else {
							$results[$pos] .= $this->startTab($pos,getLangDefinition($oTab->title),$oTab->tabid)
									. "\n\t\t\t<div class=\"tab-content\">"
									. $oContent[$k]
									. "</div>\n"
									. $this->endTab();
							$tabNavJS[$pos][$i]->nested = false;
						}
						$tabNavJS[$pos][$i]->name = getLangDefinition($oTab->title);
						$tabNavJS[$pos][$i]->id = $oTab->tabid;
						$tabNavJS[$pos][$i]->pluginclass = $oTab->pluginclass;
						$i++;
						break;
				}
			}
		}	//foreach tab
		// Pass 4: concat different types, generating tabs preambles/postambles:
		foreach ($html as $pos => $val) {
			if($ueConfig['nesttabs'] && $oNest[$pos]) {
				$oNestPre = $this->startTab($pos,_UE_PROFILETAB,$pos . 0)
						  . "<div style=\"width:97%; margin:13px 1% 13px 1%;\">"
						  . $this->startPane("CBNest".$pos);
				$oNest[$pos] .= $this->endPane()
							 . "</div>"
							 . $this->endTab();
				$results[$pos] = $oNestPre.$oNest[$pos].$results[$pos];

				// reorder tabs to regroup nested ones:
				$newNavJS	=	array();
				$i			=	0;
				foreach ( $tabNavJS[$pos] as $k => $v ) {
					if ( $v->nested ) {
						$newNavJS[$i++]		=	$v;
					}
				}
				if ( count( $newNavJS ) > 0 ) {
					$newNavJS[$i]->name			=	_UE_PROFILETAB;
					$newNavJS[$i]->id			=	32000;
					$newNavJS[$i]->pluginclass	=	'profiletab';
					$newNavJS[$i]->nested		=	false;
					$i++;
				}
				foreach ( $tabNavJS[$pos] as $k => $v ) {
					if ( ! $v->nested ) {
						$newNavJS[$i++]		=	$v;
					}
				}
				$tabNavJS[$pos]	=	$newNavJS;

			}
			if ($results[$pos]) {
				if ($val) $html[$pos] .= "<br />";
				$html[$pos] .= $this->_getTabNavJS($pos, $tabNavJS[$pos])
							. $this->startPane($pos)
							. $results[$pos]
							. $this->endPane();
			}
		}
		return $html;
	}

	function _getViewTabContents( $tabid, $user ) {
		global $ueConfig,$_CB_database,$_CB_OneTwoRowsStyleToggle;
	$return="";
	$results="";
	$whereAdd=""; 
	IF ( $ueConfig['allow_email_display'] == 0 ) {
		$whereAdd = " AND f.type != 'emailaddress' ";
	}
	$_CB_database->setQuery( "SELECT * FROM #__comprofiler_fields f"
	. "\n WHERE f.published = 1 AND f.profile != 0 AND f.tabid = " . (int) $tabid . " "
	. $whereAdd
	. "\n ORDER BY f.ordering" );
	$oFields = $_CB_database->loadObjectList();

	if (is_array($oFields)) {
		foreach($oFields AS $oField) {
			$fValue='$user->'.$oField->name;
			eval("\$fValue = \"".$fValue."\";");
			$oValue = getFieldValue($oField->type, /* stripslashes */ ($fValue),$user);
			if($oValue!=null || trim($oValue)!='' || $oField->type == 'delimiter') {
				$class = "sectiontableentry".$_CB_OneTwoRowsStyleToggle;
				$_CB_OneTwoRowsStyleToggle = ($_CB_OneTwoRowsStyleToggle == 1 ? 2 : 1);
				$results .= "\n\t\t\t\t<tr class=\"".$class."\" id=\"cbfr_" . $oField->fieldid . "\">";
				$colspan=2;
				if($oField->type != 'delimiter') {
					if(getLangDefinition($oField->title)!="") {
						$results .= "\n\t\t\t\t\t<td class=\"titleCell\""
						. ( ( $oField->profile == 2 ) ? " colspan=\"2\"" : "" )
						.">". getLangDefinition($oField->title) .":</td>";
						if ( $oField->profile == 2 ) {
							$results .= "\n\t\t\t\t</tr>"
									  . "\n\t\t\t\t<tr class=\"".$class."\">";
						} else {
							$colspan=1;
						}
					}
					$results .= "\n\t\t\t\t\t<td colspan=\"".$colspan."\" class=\"fieldCell\">".$oValue."</td>";
					$results .= "\n\t\t\t\t</tr>";
				} else {
					$results .= "\n\t\t\t\t\t<td colspan=\"".$colspan."\" class=\"delimiterCell\">". unHtmlspecialchars(getLangDefinition($oField->title)) ."</td>";
					$results .= "\n\t\t\t\t</tr>";
					if ($oField->description) {
						$results .= "\n\t\t\t\t<tr class=\"".$class."\">\n\t\t\t\t\t<td colspan=\"".$colspan."\" class=\"descriptionCell\">". unHtmlspecialchars(getLangDefinition($oField->description)) ."</td>\n";
						$results .= "\n\t\t\t\t</tr>";
					}
				}
			}
		}
	}
	if($results!="") {
		// only displayed at Profile Edit: $return .= $this->_writeTabDescription( $tab, $user );
		$return .= "\n\t\t\t<table class=\"cbFields\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:95%\">";
		$return .= $results;
		$return .= "\n\t\t\t</table>";
	}
	return $return;
}

	function _callTabPlugin($tab, &$user, $pluginclass, $method, $pluginid=null, $postdata=null) {
		global $_PLUGINS;
		$results=null;
        if ( $pluginid ) {
	        if($_PLUGINS->loadPluginGroup('user',array($pluginid))) {
	        	$args=array($tab , &$user, $this->ui);
	        	if ($postdata !== null) $args[]	=&	$postdata;
	        	$results	=	$_PLUGINS->call($pluginid,$method,$pluginclass, $args, ( is_object( $tab ) ? $tab->params : null ) );
	        }
        }
	    return $results;
	}
	function _getVarPlugin($tab, $pluginclass, $variable, $pluginid=null) {
		global $_PLUGINS;
		return $_PLUGINS->getVar($pluginid,$pluginclass, $variable);
	}

	function getEditTabs($user) {
		global $_CB_database, $my, $ueConfig;
		$i=0;
		$tabNavJS=array();
		$this->action=2;
		$this->fieldJS="";
		$results="";
		$nestResults	=	"";
		$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
		. "\n WHERE t.enabled=1 "
		. "\n AND t.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")"
		. "\n ORDER BY t.position, t.ordering" );
		$oTabs = $_CB_database->loadObjectList();
		foreach($oTabs AS $oTab) {
			$oPContent="";
			$oFContent="";
			$oContent="";
			if($oTab->pluginclass!=null) {
				$oPContent = $this->_callTabPlugin($oTab, $user, $oTab->pluginclass, 'getEditTab', $oTab->pluginid);
				$this->fieldJS .= $this->_getVarPlugin($oTab, $oTab->pluginclass, 'fieldJS', $oTab->pluginid);
			}
			if($oTab->fields) {
				if($oTab->pluginclass!=null) {
					$oTab->description=null;
				}
				$oFContent = $this->_getEditTabContents($oTab,$user);
			}
			if($oPContent!="") $oContent .= $oPContent;
			if($oFContent!="") $oContent .= $oFContent;
			if($oContent!="") {
				if ( $ueConfig['nesttabs'] && $oTab->fields && ( ( $oTab->pluginclass == null ) || ( $oTab->sys == 2 ) ) ) {
					if ( ! $nestResults ) {
						$nestResults = $this->startTab("CB",_UE_PROFILETAB, 0)
						. "<div style=\"width:97%; margin:13px 1% 13px 1%;\">"
						. $this->startPane( "CBNest" . "CB" );
					}
					$nestResults .= $this->startTab( "CBNest" . "CB", getLangDefinition($oTab->title),$oTab->tabid);
					$nestResults .= "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\"><tr><td>";
					$nestResults .= $oContent;
					$nestResults .= "\n\t</td></tr></table>";
					$nestResults .= $this->endTab();
					$tabNavJS[$i]->nested = true;
				} else {
					$results .= $this->startTab("CB",getLangDefinition($oTab->title),$oTab->tabid);
					$results .= "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\"><tr><td>";
					$results .= $oContent;
					$results .= "\n\t</td></tr></table>";
					$results .= $this->endTab();
					$tabNavJS[$i]->nested = false;
				}
				$tabNavJS[$i]->name = getLangDefinition($oTab->title);
				$tabNavJS[$i]->id = $oTab->tabid;
				$tabNavJS[$i]->pluginclass = $oTab->pluginclass;
				$i++;
			}
		}
		if ( $nestResults ) {
			// reorder tabs to regroup nested ones:
			$newNavJS	=	array();
			$i			=	0;
			foreach ( $tabNavJS as $k => $v ) {
				if ( $v->nested ) {
					$newNavJS[$i++]		=	$tabNavJS[$k];
				}
			}
			if ( count( $newNavJS ) > 0 ) {
				$newNavJS[$i]->name			=	_UE_PROFILETAB;
				$newNavJS[$i]->id			=	32000;
				$newNavJS[$i]->pluginclass	=	'profiletab';
				$newNavJS[$i]->nested		=	false;
				$i++;
			}
			foreach ( $tabNavJS as $k => $v ) {
				if ( ! $v->nested ) {
					$newNavJS[$i++]		=	$tabNavJS[$k];
				}
			}
			$tabNavJS	=	$newNavJS;

			$nestResults .= $this->endPane()
			. "</div>"
			. $this->endTab();
			$results = $nestResults . $results;
			$nestResults	=	"";
		}
		$return = $this->_getTabNavJS("CB", $tabNavJS);
		$return .= $this->startPane("CB");
		$return .= $results;
		$return .= $this->endPane();

		return $return;
	}
	function _getEditTabContents($tab,$user) {
		global $_CB_database,$ueConfig;
		$results="";
		$return="";
		$_CB_database->setQuery( "SELECT f.* FROM #__comprofiler_fields f"
		. "\n WHERE f.published=1 AND f.tabid=" . (int) $tab->tabid . " ORDER BY f.ordering");
		$rowFields = $_CB_database->loadObjectList();
		$rowFieldValues=array();
		$fieldJS='';
		if (count($rowFields)>0) {
			$results .= $this->_writeTabDescription( $tab, $user );

			$results .= "\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n";
			foreach($rowFields AS $rowField) {
				$k = "\$user->".$rowField->name;
				eval("\$k = \"$k\";");
				if($rowField->type=='editorta') {
					ob_start();
					getEditorContents( 'editor'.$rowField->name, $rowField->name ) ;
					$fieldJS .= ob_get_contents();
					ob_end_clean();
				}
				$_CB_database->setQuery( "SELECT fieldtitle, concat('cbf',fieldvalueid) AS id FROM #__comprofiler_field_values"		// id needed for the labels
				. "\n WHERE fieldid = " . (int) $rowField->fieldid
				. "\n ORDER BY ordering" );
				$Values = $_CB_database->loadObjectList();
				$adminReq=$rowField->required;
				if($this->ui==2) {
					$rowField->readonly=0;
					if($ueConfig['adminrequiredfields']==0) {
						$adminReq=0;
					}
				}
				$multi=null;
				$disabled=null;
				if($rowField->type=='multiselect') {
					$multi="multiple='multiple'";
				}
				if($rowField->readonly==1) {
					$disabled = "disabled=\"disabled\"";
					$adminReq = "0";
				}
				if(count($Values) > 0) {
					if ($rowField->type=='radio') {
						$rowFieldValues['lst_'.$rowField->name] = moscomprofilerHTML::radioListTable( $Values, $rowField->name, $disabled.' size="1" mosLabel="'.getLangDefinition($rowField->title).'"', 'fieldtitle', 'fieldtitle', $k, $rowField->cols, $rowField->rows, $rowField->size, $adminReq);
					} else {
						$ks=explode("|*|",$k);
						$k = array();
						foreach($ks as $kv) {
							$k[]->fieldtitle=$kv;
						}
						if ($rowField->type=='multicheckbox') {
							$rowFieldValues['lst_'.$rowField->name] = moscomprofilerHTML::checkboxListTable( $Values, $rowField->name."[]", $disabled.' size="'.$rowField->size.'" '.$multi.' mosLabel="'.getLangDefinition($rowField->title).'"', 'fieldtitle', 'fieldtitle', $k, $rowField->cols, $rowField->rows, $rowField->size, $adminReq);
						}
						else {
							$rowFieldValues['lst_'.$rowField->name] = moscomprofilerHTML::selectList( $Values, $rowField->name."[]", 'class="inputbox" '.$disabled.' size="'.$rowField->size.'" '.$multi.' mosReq="'.$adminReq.'" mosLabel="'.getLangDefinition($rowField->title).'"', 'fieldtitle', 'fieldtitle', $k);
						}
					}
				}
				$fieldValueList="";
				$fieldIDValue="";
				$results .= "\t\t<tr>\n";
				$colspan=2;
				if ($rowField->type=='delimiter') {
					$results .= "\t\t\t<td colspan=\"".$colspan."\" class=\"delimiterCell\">". unHtmlspecialchars(getLangDefinition($rowField->title)) ."</td>\n";
					if ($rowField->description) $results .= "\t\t</tr>\n\t\t<tr>\n\t\t\t<td colspan=\"".$colspan."\" class=\"descriptionCell\">". unHtmlspecialchars(getLangDefinition($rowField->description)) ."</td>\n";
				} else {
					if (getLangDefinition($rowField->title)!="") {
						$results .= "\t\t\t<td class=\"titleCell\"" . ( ( $rowField->profile == 2 ) ? " colspan=\"2\"" : "" ) .">". getLangDefinition($rowField->title) .":</td>\n";
						if ( $rowField->profile == 2 ) {
							$results .= "\t\t</tr>\n"
									  . "\t\t<tr>\n";
						} else {
							$colspan=1;
						}
					}
					if(ISSET($rowFieldValues['lst_'.$rowField->name])) {
						$fieldValueList=$rowFieldValues['lst_'.$rowField->name];
					}
					if(ISSET($rowField->id)) $fieldIDValue=$rowField->id;
					$results .= "\t\t\t<td colspan=\"".$colspan."\" class=\"fieldCell\">".getFieldEntry($this->ui,$this->calendars,$rowField->type,$rowField->name,$rowField->description,$rowField->title,$k,$adminReq,$rowField->title,$fieldIDValue,$rowField->size, $rowField->maxlength, $rowField->cols, $rowField->rows,$rowField->profile,$fieldValueList,$rowField->readonly)."</td>\n";
				}
				$results .= "\t\t</tr>\n";
			}
			$results.="\t</table>\n";
			$this->fieldJS .=$fieldJS;
			$return		.=	$results;
		}
		return $return;
	}

	function _getTabNavJS($pID, $tabs) {
		global $ueConfig;
		
		static $functionOutputed	=	false;

		$i				=	0;
		$i_nest			=	0;
		if( ! ( count( $tabs ) > 0 ) ) {
			return "";
		}
		$return="<script type=\"text/javascript\"><!--//--><![CDATA[//><!--\n";
		$return			.=	"var tabPane".$pID.";\n";
		if ($ueConfig["nesttabs"]) {
			$return		.=	"var tabPaneCBNest".$pID.";\n";
		}
		
		if ( ! $functionOutputed ) {
			$return		.=	"var cbshowtabsArray = new Array();\n";
			$return		.=	"function showCBTab( sName ) {\n";
			$return		.=	"	if ( typeof(sName) == 'string' ) {\n";
			$return		.=	"		sName = sName.toLowerCase();\n";
			$return		.=	"	}\n";
			$return		.=	"	for (var i=0;i<cbshowtabsArray.length;i++) {\n";
			$return		.=	"		for (var j=0;j<cbshowtabsArray[i][0].length;j++) {\n";
			$return		.=	"			if (cbshowtabsArray[i][0][j] == sName) {\n";
			$return		.=	"				eval(cbshowtabsArray[i][1]);\n";
			$return		.=	"				return;\n";
			$return		.=	"			}\n";
			$return		.=	"		}\n";
			$return		.=	"	}\n";
			$return		.=	"}\n";

			$functionOutputed	=	true;
		}

		foreach( $tabs AS $tab ) {
			$evals			=	"tabPane".$pID.".setSelectedIndex( ".$i." );";
			if ( $tab->nested ) {
				$evals		.=	"tabPaneCBNest".$pID.".setSelectedIndex( ".$i_nest." );";
			}

			$values			=	array();
			$values[]		=	strtolower( $tab->name );
			$values[]		=	$tab->id;
			if ( $tab->pluginclass != null ) {
				$values[]	=	strtolower($tab->pluginclass);
			}

			$return			.=	"cbshowtabsArray.push( [['" . implode( "','", $values ) . "'],'" . $evals . "'] );\n";

			if ( $tab->nested ) {
				$i_nest++;
			}
			else {
				$i++;
			}
		}
		$return			.=	"//--><!]]></script>\n";
		return $return;
	}

	function savePluginTabs(&$user, &$postdata) {
		global $_CB_database, $my;
		$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
		. "\n WHERE t.enabled=1 AND t.pluginclass is not null"
		. "\n AND t.useraccessgroupid IN (".implode(',',getChildGIDS(userGID($my->id))).")"
		. "\n ORDER BY t.position, t.ordering" );
		$oTabs = $_CB_database->loadObjectList();

		foreach($oTabs AS $oTab) {
			if($oTab->pluginclass!=null) {
				$this->_callTabPlugin($oTab, $user, $oTab->pluginclass, 'saveEditTab', $oTab->pluginid, $postdata);
			} 
		}
		return 1;
	}

	function getRegistrationPluginTabs( &$postdata ) {
		global $_CB_database, $acl;
		$results = array();
		$userNull = null;
		$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
		. "\n WHERE t.enabled=1 AND t.pluginclass is not null"
		// . "\n AND t.useraccessgroupid = -2"
		. "\n ORDER BY t.ordering_register, t.position, t.ordering" );
		$oTabs = $_CB_database->loadObjectList();

		foreach($oTabs AS $oTab) {
			if($oTab->pluginclass!=null) {
				if ( ! isset( $results[(int) $oTab->ordering_register][$oTab->position][(int) $oTab->ordering] ) ) {
					$results[(int) $oTab->ordering_register][$oTab->position][(int) $oTab->ordering]	=	'';
				}
				$results[(int) $oTab->ordering_register][$oTab->position][(int) $oTab->ordering] .= $this->_callTabPlugin( $oTab, $userNull, $oTab->pluginclass, 'getDisplayRegistration', $oTab->pluginid, $postdata );
				$this->fieldJS .= $this->_getVarPlugin($oTab, $oTab->pluginclass, 'fieldJS', $oTab->pluginid);
			} 
		}
		return $results;
	}

	function saveRegistrationPluginTabs(&$user, $postdata) {
		global $_CB_database, $acl;
		$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
		. "\n WHERE t.enabled=1 AND t.pluginclass is not null"
		// . "\n AND t.useraccessgroupid = -2"
		. "\n ORDER BY t.ordering_register, t.position, t.ordering" );
		$oTabs = $_CB_database->loadObjectList();
		$results = array();
		foreach($oTabs AS $oTab) {
			if($oTab->pluginclass!=null) {
				$results[] = $this->_callTabPlugin($oTab, $user, $oTab->pluginclass, 'saveRegistrationTab', $oTab->pluginid, $postdata);
			}
		}
		return $results;
	}

	/**
	* Loads plugin corresponding to tab from database and calls a method of it.
	* @param object cb user object to display
	* @param array $_POST data
	* @param string name of class to search for and to call
	* @param string name of method to call
	* @return mixed returned result of call (null if call not performed)
	*/	
	function tabClassPluginTabs($user, $postdata, $pluginName, $tabClassName, $method) {
		global $_CB_database, $_PLUGINS;

		$result = null;

		if ($pluginName) {
			$_CB_database->setQuery( "SELECT * FROM #__comprofiler_plugin p"
			. "\n WHERE p.published = 1 AND p.element ='".strtolower(cbGetEscaped($pluginName))."'");
			$pluginsList = $_CB_database->loadObjectList();
			if ( count( $pluginsList ) == 1 ) {
				$plugin = $pluginsList[0];
				if ($_PLUGINS->loadPluginGroup('user', array($plugin->id))) {
					if( class_exists( $tabClassName ) ) {
						$result = $this->_callTabPlugin( null, $user, $tabClassName, $method, $plugin->id, $postdata );
					}
				}
			}
		} else {
			$_CB_database->setQuery( "SELECT * FROM #__comprofiler_tabs t"
			. "\n WHERE t.enabled=1 AND t.pluginclass is not null AND LOWER(t.pluginclass) ='".strtolower(cbGetEscaped($tabClassName))."'");		// no ACL check here on purpose
			$oTabs = $_CB_database->loadObjectList();
			if (count($oTabs)==1) {
				$oTab = $oTabs[0];
				if($oTab->pluginid) {
					if ($_PLUGINS->loadPluginGroup('user', array($oTab->pluginid))) {
						if($oTab->pluginclass!=null) {
							$result = $this->_callTabPlugin($oTab, $user, $oTab->pluginclass, $method, $oTab->pluginid, $postdata);
						}
					}
				}
			}
		}
		return $result;
	}
}	// end Class cbTabs

/**
* PMS handler
* @package Community Builder
* @author Beat
*/
class cbPMS extends cbPMSHandler {
	var $PMSpluginsList;
	/**
	* Constructor
	*/
	function cbPMS() {
		$this->cbPMSHandler();
		$this->PMSpluginsList = null;
	}

	function _callPlugin($plug, $args, $pluginclass, $method) {
		global $_PLUGINS;
		$results=null;
		if ( $plug->id ) {
			if($_PLUGINS->loadPluginGroup('user', array($plug->id))) {
				$results=$_PLUGINS->call($plug->id, $method, $pluginclass, $args, $plug->params);
			}
		}
		return $results;
	}
	function _callPluginTypeMethod($type, $methodName, $args) {
		global $_CB_database;
		$results = array();
		if ($this->PMSpluginsList === null) {
			$_CB_database->setQuery( "SELECT * FROM #__comprofiler_plugin p"
			. "\n WHERE p.published=1 "
			. "\n AND p.element LIKE '%" . cbEscapeSQLsearch( trim( strtolower( $_CB_database->getEscaped($type) ) ) ) . ".%' "
			. "\n ORDER BY p.ordering" );
			$this->PMSpluginsList = $_CB_database->loadObjectList();
		}
		if ( is_array( $this->PMSpluginsList ) ) {
			foreach($this->PMSpluginsList AS $plug) {
				$className = 'get'.substr($plug->element, strlen($type)+1).'Tab';
				$results[] = $this->_callPlugin($plug, $args, $className, $methodName);
			}
		}
		return $results;
	}
	/**
	* Sends a PMS message on the enabled "pms.*" plugins
	* @param int userId of receiver
	* @param int userId of sender
	* @param string subject of PMS message (UNESCAPED)
	* @param string body of PMS message (UNESCAPED)
	* @param boolean false: real user-to-user message; true: system-Generated by an action from user $fromid (if non-null)
	* @param boolean false: subject and message body UNESCAPED = default; true: ESCAPED
	* @return boolean : true for OK, or false if ErrorMSG generated. Special error: _UE_PMS_TYPE_UNSUPPORTED : if anonym fromid>=0 sysgenerated unsupported
	*/
	function sendPMSMSG($toid, $fromid, $subject, $message, $systemGenerated=false, $escaped=false) {
		$args = array($toid, $fromid, $subject, $message, $systemGenerated, $escaped);
		return $this->_callPluginTypeMethod("pms", "sendUserPMS", $args);
	}
	/**
	* returns all the parameters needed for a hyperlink or a menu entry to do a pms action
	* @param int userId of receiver
	* @param int userId of sender
	* @param string subject of PMS message
	* @param string body of PMS message
	* @param int kind of link: 1: link to compose new PMS message for $toid user. 2: link to inbox of $fromid user; 3: outbox, 4: trashbox,
	  5: link to edit pms options
	* @return mixed array of string {"caption" => menu-text ,"url" => NON-sefRelToAbs relative url-link, "tooltip" => description} or false and errorMSG
	*/
	function getPMSlinks($toid=0, $fromid=0, $subject="", $message="", $kind) {
		$args = array($toid, $fromid, $subject, $message, $kind);
		return $this->_callPluginTypeMethod("pms", "getPMSlink", $args);
	}
	/**
	* gets PMS system capabilities
	* @return mixed array of string {"subject" => boolean ,"body" => boolean} or false if ErrorMSG generated
	*/
	function getPMScapabilites() {
		$args = array();
		return $this->_callPluginTypeMethod("pms", "getPMScapabilites", $args);
	}
	/**
	* gets PMS unread messages count
	* @param	int user id
	* @return	mixed number of messages unread by user $userid or false if ErrorMSG generated
	*/
	function getPMSunreadCount($userid) {
		$args = array($userid);
		return $this->_callPluginTypeMethod("pms", "getPMSunreadCount", $args);
	}
}	// end Class cbPMS

/**
* Connections Class for handeling CB connections
* @package Community Builder
* @author MamboJoe
*/
class cbConnection {
	/**	@var errorMSG should be used to store the error message when an error is encountered*/
	var $errorMSG;
	/**	@var errorNum should be used to store the error number when an error is encountered*/
	var $errorNum;
	/**	@var referenceid should be used to store the userid related to base user of the connection action*/
	var $referenceid;
	/**	@var connectionid should be used to store the userid related to target user of the connection action*/
	var $connectionid;
	/**	@var degreeOfSep should be used to store the numeric value related to distance between referenceid and connectionid*/
	var $degreeOfSep;
	/**	@var userMSG should be used to store the message that needs to be returned to the user*/
	var $userMSG;
	
	function cbConnection($referenceid) {
		$this->referenceid=$referenceid;
		return;
	}
	function addConnection($connectionid,$umsg=null) {
		global $_CB_database,$ueConfig, $mosConfig_live_site, $_PLUGINS;

		$existingConnection = $this->getConnectionDetails( $this->referenceid , $connectionid );
		if ( $existingConnection === false ) {

			$_PLUGINS->loadPluginGroup('user');
			$_PLUGINS->trigger( 'onBeforeAddConnection', array($this->referenceid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections'],&$umsg));
			if($_PLUGINS->is_errors()) {
				$this->_setUserMSG($_PLUGINS->getErrorMSG());
				return false;
			}
	
			if(!$this->_insertConnection($this->referenceid,$connectionid,$umsg)) {	
				$this->_setUserMSG($this->getErrorMSG());
				return false;
			}
			if($ueConfig['useMutualConnections']) {
				$msg = _UE_CONNECTIONPENDINGACCEPTANCE;
				$subject= _UE_CONNECTIONPENDSUB;
				$messageHTML = _UE_CONNECTIONPENDMSG;
			} else {
				$msg = _UE_CONNECTIONADDSUCCESSFULL;
				$subject= _UE_CONNECTIONMADESUB;
				$messageHTML = _UE_CONNECTIONMADEMSG;
			}
			$messageText = $messageHTML;
		
			$result = $this->_notifyConnectionChange($this->referenceid,$connectionid,$msg,$subject,$messageHTML,$messageText,$umsg);
			$_PLUGINS->trigger( 'onAfterAddConnection', array($this->referenceid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));

		} else {
			$result		=	false;
		}
		return $result;
	}
	function _notifyConnectionChange($userid,$connectionid,$msg,$subject,$messageHTML,$messageText,$userMessage=null) {
		global $_CB_database,$ueConfig,$mosConfig_live_site;
	
		$rowFrom = new mosUser( $_CB_database );
		$rowFrom->load( (int) $userid );
	
		$fromname=getNameFormat($rowFrom->name,$rowFrom->username,$ueConfig['name_format']);
		$fromURL="index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$userid."&amp;tab=1".getCBprofileItemid(true);
		if (is_callable("sefRelToAbs")) {			// in Joomla 1.0 backend it's not callable...
			$fromURL = sefRelToAbs( $fromURL );
		}
		if (strncasecmp("http", $fromURL, 4) != 0) $fromURL = $mosConfig_live_site . "/" . $fromURL;
		$subject= sprintf($subject,$fromname);

		if($userMessage!=null) {
			$messageHTML .= sprintf(str_replace("\n", "\n<br />", _UE_CONNECTIONMSGPREFIX),$fromname,"<strong>".htmlspecialchars($userMessage)."</strong>");
			$messageText .= sprintf(str_replace("\n", "\r\n", _UE_CONNECTIONMSGPREFIX),$fromname,$userMessage);
		}

		$nmsgHTML= sprintf($messageHTML,'<strong><a href="'.$fromURL.'">'.$fromname.'</a></strong>');
		$nmsgText = sprintf($messageText,$fromname);

		$manageURL = 'index.php?option=com_comprofiler&amp;task=manageConnections'.getCBprofileItemid(true);
		if (is_callable("sefRelToAbs")) {			// in Joomla 1.0 backend it's not callable...
			$manageURL = sefRelToAbs( $manageURL );
		}
		if (strncasecmp("http", $manageURL, 4) != 0) $manageURL = $mosConfig_live_site . "/" . $manageURL;
		$nmsgHTML = $nmsgHTML . "\n<br /><br /><a href=\"".$manageURL."\">"._UE_MANAGECONNECTIONS."</a>\n";
		$nmsgText = $nmsgText . "\r\n\r\n\r\n".$fromname." "._UE_PROFILE.": ".unAmpersand($fromURL);
		$nmsgText = $nmsgText . "\r\n\r\n"._UE_MANAGECONNECTIONS.": ".unAmpersand($manageURL)."\r\n";
		$nmsgHTML = '<div style="padding: 4px; margin: 4px 3px 6px 0px; background: #C44; font-weight: bold;" class="cbNotice">'
										._UE_SENDPMSNOTICE . "</div>\n\n" . $nmsgHTML;

		$cbNotification= new cbNotification();
		$cbNotification->sendFromUser($connectionid,$userid,$subject,$nmsgHTML,$nmsgText);
		
		$this->_setUserMSG($msg);
		return true;
	
	}
	function _insertConnection($refid, $connid, $userMessage) {
		global $_CB_database,$ueConfig;
		$accepted=1;
		$pending=0;
		if($ueConfig['useMutualConnections']) {
			$accepted=1;
			$pending=1;
		} 
		$sql="INSERT INTO #__comprofiler_members (referenceid,memberid,accepted,pending,membersince,reason) VALUES (" . (int) $refid . "," . (int) $connid . "," . (int) $accepted . "," . (int) $pending.",CURDATE(),'" . $_CB_database->getEscaped($userMessage) . "')";
		$_CB_database->SetQuery($sql);
		if (!$_CB_database->query()) {
			$this->_setErrorMSG("SQL error insCon1 " . $_CB_database->stderr(true));
			return false;
		}
		if($ueConfig['autoAddConnections']) {
			$accepted=1;
			$pending=0;
			if($ueConfig['useMutualConnections']) {
				$accepted=0;
				$pending=0;
			}
			$sql="INSERT INTO #__comprofiler_members (referenceid,memberid,accepted,pending,membersince,reason) VALUES (" . (int) $connid . "," . (int) $refid . "," . (int) $accepted . "," . (int) $pending . ",CURDATE(),'" . $_CB_database->getEscaped($userMessage) . "')";
			$_CB_database->SetQuery($sql);
			if (!$_CB_database->query()) {
				$this->_setErrorMSG("SQL error insCon2 " . $_CB_database->stderr(true));
				return false;
			}
		}
		return true;
	}
	function removeConnection($userid,$connectionid) {
		global $ueConfig, $_PLUGINS;

		if ($this->getConnectionDetails($userid,$connectionid) === false) {
			$this->_setErrorMSG(_UE_NODIRECTCONNECTION);
			return false;
		}
		$_PLUGINS->loadPluginGroup('user');
		$_PLUGINS->trigger( 'onBeforeRemoveConnection', array($userid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));
		if($_PLUGINS->is_errors()) {
			$this->_setUserMSG($_PLUGINS->getErrorMSG());
			return false;
		}

		$this->_deleteConnection($userid,$connectionid);
		
		$msg = _UE_CONNECTIONREMOVESUCCESSFULL;
		$subject = _UE_CONNECTIONREMOVED_SUB;
		$messageHTML = _UE_CONNECTIONREMOVED_MSG;
		$messageText = $messageHTML;
		$result = $this->_notifyConnectionChange($userid,$connectionid,$msg,$subject,$messageHTML,$messageText);
		$_PLUGINS->trigger( 'onAfterRemoveConnection', array($userid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));
		return $result;
	}

	function denyConnection($userid,$connectionid) {			//BB needs to be called+do different then remove (one way if ...?)
		global $ueConfig, $_PLUGINS;

		if ($this->getConnectionDetails($userid,$connectionid) === false) {
			$this->_setErrorMSG(_UE_NODIRECTCONNECTION);
			return false;
		}
		$_PLUGINS->loadPluginGroup('user');
		$_PLUGINS->trigger( 'onBeforeDenyConnection', array($userid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));
		if($_PLUGINS->is_errors()) {
			$this->_setUserMSG($_PLUGINS->getErrorMSG());
			return false;
		}

		$this->_deleteConnection($userid,$connectionid);
		
		$msg = _UE_CONNECTIONDENYSUCCESSFULL;
		$subject = _UE_CONNECTIONDENIED_SUB;
		$messageHTML = _UE_CONNECTIONDENIED_MSG;
		$messageText = $messageHTML;
		$result = $this->_notifyConnectionChange($userid,$connectionid,$msg,$subject,$messageHTML,$messageText);
		$_PLUGINS->trigger( 'onAfterDenyConnection', array($userid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));
		return $result;
	}
	function _deleteConnection($refid,$connid) {
		global $_CB_database,$ueConfig;
		$sql="DELETE FROM #__comprofiler_members WHERE referenceid=".(int) $refid." AND memberid=".(int) $connid;
		$_CB_database->SetQuery($sql);
		if (!$_CB_database->query()) {
			$this->_setErrorMSG("SQL error" . $_CB_database->stderr(true));
			return 0;
		}
		
		if($ueConfig['autoAddConnections']) {
			$sql="DELETE FROM #__comprofiler_members WHERE referenceid=".(int) $connid." AND memberid=".(int) $refid;
			$_CB_database->SetQuery($sql);
			if (!$_CB_database->query()) {
				$this->_setErrorMSG("SQL error" . $_CB_database->stderr(true));
				return 0;
			}
		}
		return 1;
	}

	function acceptConnection($userid,$connectionid) {
		global $ueConfig, $_PLUGINS;

		if ($this->getConnectionDetails( $connectionid, $userid ) === false) {
			$this->_setErrorMSG(_UE_NODIRECTCONNECTION);
			return false;
		}
		$_PLUGINS->loadPluginGroup('user');
		$_PLUGINS->trigger( 'onBeforeAcceptConnection', array($userid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));
		if($_PLUGINS->is_errors()) {
			$this->_setUserMSG($_PLUGINS->getErrorMSG());
			return false;
		}
	
		$this->_activateConnection($userid,$connectionid);
		
		$msg = _UE_CONNECTIONACCEPTSUCCESSFULL;
		$subject = _UE_CONNECTIONACCEPTED_SUB;
		$messageHTML = _UE_CONNECTIONACCEPTED_MSG;
		$messageText = $messageHTML;
		$result = $this->_notifyConnectionChange($userid,$connectionid,$msg,$subject,$messageHTML,$messageText);
		$_PLUGINS->trigger( 'onAfterAcceptConnection', array($userid,$connectionid,$ueConfig['useMutualConnections'],$ueConfig['autoAddConnections']));
		return $result;
	}
	function _activateConnection($userid,$connectionid) {
		global $_CB_database,$ueConfig;
		$sql="UPDATE #__comprofiler_members SET accepted=1, pending=0, membersince=CURDATE() WHERE referenceid=".(int) $connectionid." AND memberid=".(int) $userid;
		$_CB_database->SetQuery($sql);
		//echo $_CB_database->getQuery();
		if (!$_CB_database->query()) {
			$this->_setErrorMSG("SQL error" . $_CB_database->stderr(true));
			return 0;
		}
		
		if($ueConfig['autoAddConnections']) {
			$sql="UPDATE #__comprofiler_members SET accepted=1, pending=0, membersince=CURDATE() WHERE referenceid=".(int) $userid." AND memberid=".(int) $connectionid;
			$_CB_database->SetQuery($sql);
			//echo $_CB_database->getQuery();
			if (!$_CB_database->query()) {
				$this->_setErrorMSG("SQL error" . $_CB_database->stderr(true));
				return 0;
			}
		}
		return 1;
	
	}
	function getPendingConnections($userid) {
		global $_CB_database;
		$query = "SELECT DISTINCT m.*,u.name,u.email,u.username,c.avatar,c.avatarapproved, u.id, IF(s.session_id=null,0,1) AS 'isOnline' "
		. "\n FROM #__comprofiler_members AS m"
		. "\n LEFT JOIN #__comprofiler AS c ON m.referenceid=c.id"
		. "\n LEFT JOIN #__users AS u ON m.referenceid=u.id"
		. "\n LEFT JOIN #__session AS s ON s.userid=u.id"	
		. "\n WHERE m.memberid=". (int) $userid ." and m.pending=1"
		. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0"
		;
		$_CB_database->setQuery( $query );
		$objects = $_CB_database->loadObjectList();	
		return $objects;	
	}
	function getActiveConnections($userid) {
		global $_CB_database;
		$query = "SELECT DISTINCT m.*,u.name,u.email,u.username,c.avatar,c.avatarapproved, u.id, IF(s.session_id=null,0,1) AS 'isOnline' "
		. "\n FROM #__comprofiler_members AS m"
		. "\n LEFT JOIN #__comprofiler AS c ON m.memberid=c.id"
		. "\n LEFT JOIN #__users AS u ON m.memberid=u.id"
		. "\n LEFT JOIN #__session AS s ON s.userid=u.id"	
		. "\n WHERE m.referenceid=". (int) $userid .""
		. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0 AND m.accepted=1"
		. "\n ORDER BY m.accepted "
		;
		$_CB_database->setQuery( $query );
		$objects = $_CB_database->loadObjectList();	
		return $objects;	
	}
	function getConnectedToMe($userid) {
		global $_CB_database;
		$query = "SELECT DISTINCT m.*,u.name,u.email,u.username,c.avatar,c.avatarapproved, u.id, IF(s.session_id=null,0,1) AS 'isOnline' "
		. "\n FROM #__comprofiler_members AS m"
		. "\n LEFT JOIN #__comprofiler AS c ON m.referenceid=c.id"
		. "\n LEFT JOIN #__users AS u ON m.referenceid=u.id"
		. "\n LEFT JOIN #__session AS s ON s.userid=u.id"	
		. "\n WHERE m.memberid=". (int) $userid ." and m.pending=0"
		. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0"
		;
		$_CB_database->setQuery( $query );
		$objects = $_CB_database->loadObjectList();	
		return $objects;	
	}

	function saveConnection($connectionid,$desc=null,$contype=null) {
		global $_CB_database;

		$sql="UPDATE #__comprofiler_members SET description='".htmlspecialchars(cbGetEscaped($desc))."', type='".htmlspecialchars(cbGetEscaped($contype))."' WHERE referenceid=".(int) $this->referenceid." AND memberid=".(int) $connectionid;
		$_CB_database->SetQuery($sql);
		if (!$_CB_database->query()) {
			$this->_setErrorMSG("SQL error" . $_CB_database->stderr(true));
			return 0;
		}
		return 1;
	}

	function getDegreeOfSepPathArray( $fromid, $toid, $limit = 10, $degree = 6 ) {
		global $_CB_database;
				
		$fromid	= (int) $fromid;
		$toid	= (int) $toid;
		$limit	= (int) $limit;
		
		if ( $degree >= 1 ) {
$sql="SELECT a.referenceid, a.memberid AS d1 "
."\n FROM `#__comprofiler_members` AS a "
."\n WHERE a.referenceid = " . $fromid . " AND a.accepted=1 AND a.pending=0 AND a.memberid = " . $toid;
		$_CB_database->setQuery( $sql );
		$congroups = $_CB_database->loadRowList();
		}
		if ( empty( $congroups ) && $degree >= 2 ) {
$sql="SELECT a.referenceid, a.memberid AS d1,  b.memberid AS d2 "
."\n FROM `#__comprofiler_members` AS a "
."\n LEFT JOIN  #__comprofiler_members AS b ON a.memberid=b.referenceid AND b.accepted=1 AND b.pending=0 "
."\n WHERE a.referenceid = " . $fromid . " AND a.accepted=1 AND a.pending=0 AND b.memberid = " . $toid
."\n AND b.memberid NOT IN ( " . $fromid . ",a.memberid ) "
// ."\n ORDER BY a.memberid,b.memberid "
."\n LIMIT " . $limit;
		$_CB_database->setQuery( $sql );
		$congroups = $_CB_database->loadRowList();
		}
		if ( empty( $congroups ) && $degree >= 3 ) {
$sql="SELECT a.referenceid, a.memberid AS d1,  b.memberid AS d2,  c.memberid AS d3 "
."\n FROM `#__comprofiler_members` AS a "
."\n LEFT JOIN  #__comprofiler_members AS b ON a.memberid=b.referenceid AND b.accepted=1 AND b.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS c ON b.memberid=c.referenceid AND c.accepted=1 AND c.pending=0 "
."\n WHERE a.referenceid = " . $fromid . " AND a.accepted=1 AND a.pending=0 AND c.memberid = " . $toid
."\n AND b.memberid NOT IN ( " . $fromid . ",a.memberid) "
."\n AND c.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid) "
// ."\n ORDER BY a.memberid,b.memberid,c.memberid "
."\n LIMIT " . $limit;
		$_CB_database->setQuery( $sql );
		$congroups = $_CB_database->loadRowList();
		}
		if ( empty( $congroups ) && $degree >= 4 ) {
$sql="SELECT a.referenceid, a.memberid AS d1,  b.memberid AS d2,  c.memberid AS d3,  d.memberid AS d4 "
."\n FROM `#__comprofiler_members` AS a "
."\n LEFT JOIN  #__comprofiler_members AS b ON a.memberid=b.referenceid AND b.accepted=1 AND b.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS c ON b.memberid=c.referenceid AND c.accepted=1 AND c.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS d ON c.memberid=d.referenceid AND d.accepted=1 AND d.pending=0 "
."\n WHERE a.referenceid = " . $fromid . " AND a.accepted=1 AND a.pending=0 AND d.memberid = " . $toid
."\n AND b.memberid NOT IN ( " . $fromid . ",a.memberid) "
."\n AND c.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid) "
."\n AND d.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid,c.memberid) "
// ."\n ORDER BY a.memberid,b.memberid,c.memberid,d.memberid "
."\n LIMIT " . $limit;
		$_CB_database->setQuery( $sql );
		$congroups = $_CB_database->loadRowList();
		}
		if ( empty( $congroups ) && $degree >= 5 ) {
$sql="SELECT a.referenceid, a.memberid AS d1,  b.memberid AS d2,  c.memberid AS d3,  d.memberid AS d4,  e.memberid AS d5 "
."\n FROM `#__comprofiler_members` AS a "
."\n LEFT JOIN  #__comprofiler_members AS b ON a.memberid=b.referenceid AND b.accepted=1 AND b.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS c ON b.memberid=c.referenceid AND c.accepted=1 AND c.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS d ON c.memberid=d.referenceid AND d.accepted=1 AND d.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS e ON d.memberid=e.referenceid AND e.accepted=1 AND e.pending=0 "
."\n WHERE a.referenceid = " . $fromid . " AND a.accepted=1 AND a.pending=0 AND e.memberid = " . $toid
."\n AND b.memberid NOT IN ( " . $fromid . ",a.memberid) "
."\n AND c.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid) "
."\n AND d.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid,c.memberid) "
."\n AND e.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid,c.memberid,d.memberid) "
// ."\n ORDER BY a.memberid,b.memberid,c.memberid,d.memberid,e.memberid "
."\n LIMIT " . $limit;
		$_CB_database->setQuery( $sql );
		$congroups = $_CB_database->loadRowList();
		}
		if ( empty( $congroups ) && $degree >= 6 ) {
$sql="SELECT a.referenceid, a.memberid AS d1,  b.memberid AS d2,  c.memberid AS d3,  d.memberid AS d4,  e.memberid AS d5,  f.memberid AS d6 "
."\n FROM `#__comprofiler_members` AS a "
."\n LEFT JOIN  #__comprofiler_members AS b ON a.memberid=b.referenceid AND b.accepted=1 AND b.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS c ON b.memberid=c.referenceid AND c.accepted=1 AND c.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS d ON c.memberid=d.referenceid AND d.accepted=1 AND d.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS e ON d.memberid=e.referenceid AND e.accepted=1 AND e.pending=0 "
."\n LEFT JOIN  #__comprofiler_members AS f ON e.memberid=f.referenceid AND f.accepted=1 AND f.pending=0 "
."\n WHERE a.referenceid = " . $fromid . " AND a.accepted=1 AND a.pending=0 AND f.memberid = " . $toid
."\n AND b.memberid NOT IN ( " . $fromid . ",a.memberid) "
."\n AND c.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid) "
."\n AND d.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid,c.memberid) "
."\n AND e.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid,c.memberid,d.memberid) "
."\n AND f.memberid NOT IN ( " . $fromid . ",a.memberid,b.memberid,c.memberid,d.memberid,e.memberid) "
// ."\n ORDER BY a.memberid,b.memberid,c.memberid,d.memberid,e.memberid,f.memberid "
."\n LIMIT " . $limit;
		$_CB_database->setQuery( $sql );
		$congroups = $_CB_database->loadRowList();
		}
		return $congroups;
	}
	function getDegreeOfSepPath( $fromid, $toid ) {
		$congroups = $this->getDegreeOfSepPathArray( $fromid, $toid, 1 );
		if ( is_array( $congroups ) && ( count( $congroups ) > 0 ) ) {
			$this->_setDegreeOfSep( count( $congroups[0] ) - 1 );
			return $congroups[0];
		} else {
			return null;
		}
	}

	function getConnectionDetails($fromid,$toid) {
		global $_CB_database;
		$query = "SELECT * "
		. "\n FROM #__comprofiler_members AS m"
		. "\n WHERE m.referenceid=".(int) $fromid." AND m.memberid=".(int) $toid
		;
		
		$_CB_database->setQuery( $query );
		$connections = $_CB_database->loadObjectList();
		if ($connections && count($connections)>0)	return $connections[0];
		else return false;
	}
	function getDegreeOfSep() {
		return $this->degreeOfSep;
	}
	function _setDegreeOfSep( $deg ) {
		$this->degreeOfSep = $deg;
		return;
	}
	function getUserMSG() {
		return $this->userMSG;
	}
	function _setUserMSG($msg) {
		$this->userMSG=$msg;
		return;
	}
	function getErrorMSG() {
		return $this->errorMSG;
	}
	function _setErrorMSG($msg) {
		$this->errorMSG=$msg;
		return;
	}
}	// end class cbConnection

/**
* Notification Class for handeling CB notifications
* @package Community Builder
* @author MamboJoe
*/
class cbNotification {
	/**	@var errorMSG should be used to store the error message when an error is encountered*/
	var $errorMSG;
	/**	@var errorNum should be used to store the error number when an error is encountered*/
	var $errorNum;
	
	function cbNotification() {
	}
	function sendFromUser($toid,$fromid,$subject,$message, $messageEmail=null) {		//BB: add html email notifications processing later
		global $ueConfig;

		if ($messageEmail === null) $messageEmail = $message;
		SWITCH($ueConfig['conNotifyType']) {
			case 1:
				return $this->sendUserEmail($toid,$fromid,$subject,$messageEmail);
			break;
			case 2:
				return $this->sendUserPMSmsg($toid,$fromid,$subject,$message, true);
			break;
			case 3:
				$resultPMS	 = $this->sendUserPMSmsg($toid,$fromid,$subject,$message, true);
				$resultEmail = $this->sendUserEmail($toid,$fromid,$subject,$messageEmail);
				return $resultPMS && $resultEmail;
			break;
			default:
				return false;
			break;		
		}
	}
	function sendUserPMSmsg($toid,$fromid,$subject,$message, $systemGenerated=false) {
		global $_CB_PMS;
		$resultArray = $_CB_PMS->sendPMSMSG($toid,$fromid,$subject,$message,$systemGenerated);
		if (count($resultArray) > 0) return $resultArray[0];
		else return false;
	}
	function sendUserEmail($toid,$fromid,$subject,$message,$revealEmail=false) {
		global $_CB_database,$ueConfig,$my,$_SERVER,$mosConfig_live_site,$mosConfig_sitename;

		if ( ( ! $subject ) && ( ! $message ) ) {
			return true;
		}
		$rowFrom = new mosUser( $_CB_database );
		$rowFrom->load( (int) $fromid );

		$rowTo = new mosUser( $_CB_database );
		$rowTo->load( (int) $toid );
		$uname=getNameFormat($rowFrom->name,$rowFrom->username,$ueConfig['name_format']);
		if ($revealEmail) {
			if (isset($ueConfig['allow_email_replyto']) && $ueConfig['allow_email_replyto'] == 2) {
				$rowFrom->replytoEmail = $rowFrom->email;
				$rowFrom->replytoName  = $uname;
				$rowFrom->email = $ueConfig['reg_email_from'];
			} else {	// if (!isset($ueConfig['allow_email_replyto']) || $ueConfig['allow_email_replyto'] == 1)
				$rowFrom->replytoEmail = null;
				$rowFrom->replytoName  = null;
				$rowFrom->email = $rowFrom->email;
			}
		} else {
			$rowFrom->replytoEmail = null;
			$rowFrom->replytoName  = null;
			$rowFrom->name = _UE_NOTIFICATIONSAT." ".cb_html_entity_decode_all($mosConfig_sitename);
			$rowFrom->email = $ueConfig['reg_email_from'];
			$message.="\n\n".sprintf(_UE_EMAILFOOTER,cb_html_entity_decode_all($mosConfig_sitename),$mosConfig_live_site);
		}
		return $this->_sendEmailMSG( $rowTo, $rowFrom, $subject, $message, $revealEmail );
	}
	function sendFromSystem( $toid, $sub, $message, $replaceVariables = true ) {
		global $_CB_database,$ueConfig,$mosConfig_sitename,$mosConfig_live_site;

		if ( ( ! $sub ) && ( ! $message ) ) {
			return true;
		}
		$rowFrom= new stdClass();
		$rowFrom->email = $ueConfig['reg_email_from'];
		$rowFrom->name = stripslashes( $ueConfig['reg_email_name'] );
		$rowFrom->replytoEmail = $ueConfig['reg_email_replyto'];
		$rowFrom->replytoName = stripslashes( $ueConfig['reg_email_name'] );
		
		if(!is_object($toid)) {
			$query = "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id =" . (int) $toid;
			$_CB_database->setQuery($query);
			$rowTo = $_CB_database->loadObjectList();
			$rowTo = $rowTo[0];
		} else {
			$rowTo = $toid;
		}

		if ($replaceVariables) {
			$message = $this->_replaceVariables($message,$rowTo);
		}
		$message.="\n\n".sprintf(_UE_EMAILFOOTER,cb_html_entity_decode_all($mosConfig_sitename),$mosConfig_live_site);
		// $message = str_replace(array("\\","\"","\$"), array("\\\\","\\\"","\\\$"), $message);
		// eval ("\$message = \"$message\";");	
		$message = str_replace( array( '\n' ), array( "\n" ), $message ); // compensate for wrong language definitions (using '\n' instaed of "\n")
			
		return $this->_sendEmailMSG($rowTo,$rowFrom,cb_html_entity_decode_all($mosConfig_sitename).' - '.$sub,$message,FALSE);
	
	}
	function sendToModerators( $sub, $message ) {
		global $_CB_database,$ueConfig;
		$_CB_database->setQuery( "SELECT u.id FROM #__users u INNER JOIN #__comprofiler c ON u.id=c.id"
		."\n WHERE u.gid IN (".implode(',',getParentGIDS($ueConfig['imageApproverGid'])).") AND u.block=0 AND c.confirmed=1 AND c.approved=1 AND u.sendEmail=1" );
		$mods = $_CB_database->loadObjectList();
		foreach ($mods AS $mod) {
			$this->sendFromSystem($mod->id, $sub, $message, false);
		}

	}
	
	function _sendEmailMSG($to,$from,$sub,$msg,$addPrefix=FALSE) {			//BB: add html
		global $_SERVER,$ueConfig,$mosConfig_sitename,$mosConfig_live_site;
		if($addPrefix) {
			$uname=getNameFormat($from->name,$from->username,$ueConfig['name_format']);
			$premessage = sprintf(_UE_SENDEMAILNOTICE, $uname, cb_html_entity_decode_all($mosConfig_sitename), $mosConfig_live_site);
			if (isset($ueConfig['allow_email_replyto']) && $ueConfig['allow_email_replyto'] == 2) {
				$premessage .= sprintf(_UE_SENDEMAILNOTICE_REPLYTO, $uname, $from->email);
			}
			$premessage .= sprintf(_UE_SENDEMAILNOTICE_DISCLAIMER, cb_html_entity_decode_all($mosConfig_sitename));
			$premessage .= sprintf(_UE_SENDEMAILNOTICE_MESSAGEHEADER, $uname);
			$msg=$premessage.$msg;
			$from->name = $uname . " @ ". cb_html_entity_decode_all($mosConfig_sitename);		// $ueConfig['reg_email_name']
		}
		if (class_exists("mosPHPMailer")) {
			$res = comprofilerMail($from->email, $from->name, $to->email, $sub, $msg, 0, NULL, NULL, NULL, $from->replytoEmail, $from->replytoName );
		} else if (function_exists( 'mosMail' )) {
			$res = mosMail($from->email, $from->name, $to->email, $sub, $msg);
		} else { //TODO drop this once we are dedicated to >= 4.5.2
			$header  = "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$header .= "Organization: ".cb_html_entity_decode_all($mosConfig_sitename)."\r\n";
			$header .= "Content-Transfer-encoding: 8bit\r\n";
			$fromTag  = $from->name." <" . $from->email . ">";
			$header .= "From: ".$fromTag."\r\n";
			$replyTag = $from->replyName." <" . $from->replyEmail . ">";
			$header .= "Reply-To: ".$replyTag."\r\n";
			$header .= "Message-ID: <".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>\r\n";
			$header .= "Return-Path: ".$from->email."\r\n";
			$header .= "X-Priority: 3\r\n";
			$header .= "X-MSmail-Priority: Low\r\n";
			$header .= "X-Mailer: PHP\r\n"; //hotmail and others dont like PHP mailer. --Microsoft Office Outlook, Build 11.0.5510
			$header .= "X-Sender: ".$from->email."\r\n";
			$res =  mail($to->email, $sub, $msg, $header);
		}
		return $res;
	}
	function _getUserDetails($row,$includePWD) {
		$uDetails = _UE_EMAIL." : ".$row->email;
		$uDetails .= "\n"._UE_UNAME." : ".$row->username."\n";
		if($includePWD==1) $uDetails .= _UE_PASS." : ".$row->password."\n";
	 	return $uDetails;
	}

	function _replaceVariables($msg, $row){
		global $mosConfig_live_site, $ueConfig, $mosConfig_emailpass;
		
		if($ueConfig['reg_confirmation']==1) {
			if ( $row->cbactivation ) {
				$confirmCode = $row->cbactivation;
			} else {
				$confirmCode = '';		// this was registrations-confirm codes before 1.0.2, removed at 1.1: md5($row->id);
			}
			// no sef here !  space added after link for dumb emailers (Ms Entourage)
			$confirmLink = " \n".$mosConfig_live_site."/index.php?option=com_comprofiler&task=confirm&confirmcode=".$confirmCode." \n";		
		} else {
			$confirmLink = ' ';
		}

		$msg = str_replace( array( '\n' ), array( "\n" ), $msg );	// was eval ("\$msg = \"$msg\";"); // compensate for wrong language definitions (using '\n' instaed of "\n")
		$msg = cbstr_ireplace("[USERNAME]", $row->username, $msg);
		$msg = cbstr_ireplace("[NAME]", $row->name, $msg);
		$msg = cbstr_ireplace("[EMAILADDRESS]", $row->email, $msg);
		$msg = cbstr_ireplace("[SITEURL]", $mosConfig_live_site, $msg);
		$msg = cbstr_ireplace("[DETAILS]", $this->_getUserDetails($row,$mosConfig_emailpass), $msg);
		$msg = cbstr_ireplace("[CONFIRM]", $confirmLink, $msg );
		$msg = cbReplaceVars( $msg, $row );
		return $msg;
	}
}	// end class cbNotification

class cbFields {
	/**	@var errorMSG should be used to store the error message when an error is encountered*/
	var $errorMSG;
	/**	@var errorNum should be used to store the error number when an error is encountered*/
	var $errorNum;

	function cbFields() {
	}
	
	/**
	 * Returns a reference to an input filter object, only creating it if it doesn't already exist.
	 *
	 * This method must be invoked as:
	 * 		<pre>  $filter = & JInputFilter::getInstance();</pre>
	 *
	 * @static
	 * @param	array	$tagsArray	list of user-defined tags
	 * @param	array	$attrArray	list of user-defined attributes
	 * @param	int		$tagsMethod	WhiteList method = 0, BlackList method = 1
	 * @param	int		$attrMethod	WhiteList method = 0, BlackList method = 1
	 * @param	int		$xssAuto	Only auto clean essentials = 0, Allow clean blacklisted tags/attr = 1
	 * @return	object	The JInputFilter object.
	 */
	function & getInputFilter( $tagsArray = array(), $attrArray = array(), $tagsMethod = 0, $attrMethod = 0, $xssAuto = 1 ) {
		global $mainframe;
		if ( class_exists( "JFilterInput" ) ) {
			return JFilterInput::getInstance( $tagsArray, $attrArray, $tagsMethod, $attrMethod, $xssAuto );
		} elseif ( class_exists( "InputFilter" ) ) {
			$filter = & new InputFilter( $tagsArray, $attrArray, $tagsMethod, $attrMethod, $xssAuto );
			return $filter;
		} elseif ( file_exists( $mainframe->getCfg( 'absolute_path' ) . '/includes/phpInputFilter/class.inputfilter.php' ) ) {
			include_once( $mainframe->getCfg( 'absolute_path' ) . '/includes/phpInputFilter/class.inputfilter.php' );
			if ( class_exists( "InputFilter" ) ) {
				$filter = & new InputFilter( $tagsArray, $attrArray, $tagsMethod, $attrMethod, $xssAuto );
				return $filter;
			}
		}
		$null	=	null;
		return $null;
	}
	/**
	 * Try to convert to plaintext
	 * Rewritten in CB to use CB's own version of html_entity_decode where innexistant or buggy in < joomla 1.5
	 *
	 * @access	protected
	 * @param	string	$source
	 * @return	string	Plaintext string
	 * @since	1.5
	 */
	function _decode($source)
	{
		// entity decode : use own version of html_entity_decode, including dec & hex:
		return cb_html_entity_decode_all( $source );
	}
	/**
	 * Method to be called by another php script. Processes for XSS and
	 * specified bad code.
	 * Rewritten in CB to use own decode
	 * 
	 * @access	public
	 * @param	mixed	$source	Input string/array-of-string to be 'cleaned'
	 * @return mixed	$source	'cleaned' version of input parameter
	 */
	function _process( $filter, $source )
	{
		/*
		 * Are we dealing with an array?
		 */
		if (is_array($source))
		{
			foreach ($source as $key => $value)
			{
				// filter element for XSS and other 'bad' code etc.
				if (is_string($value))
				{
					$source[$key] = $filter->remove($this->_decode($value));
				}
			}
			return $source;
		} else
		{
			/*
			 * Or a string?
			 */
			if (is_string($source) && !empty ($source))
			{
				// filter source for XSS and other 'bad' code etc.
				return $filter->remove($this->_decode($source));
			} else
			{
				/*
				 * Not an array or string.. return the passed parameter
				 */
				return $source;
			}
		}
	}
	/**
	 * Method to be called by another php script. Processes for XSS and
	 * specified bad code.
	 *
	 * @access	public
	 * @param	mixed	$source	Input string/array-of-string to be 'cleaned'
	 * @param	string	$type	Return type for the variable (INT, FLOAT, WORD, BOOLEAN, STRING)
	 * @return	mixed	'Cleaned' version of input parameter
	 */
	function clean( $filter, $source, $type='string' ) {
		if ( class_exists( "JInputFilter" ) ) {
			$result = $filter->clean( $source, $type );
		} elseif ( class_exists( "InputFilter" ) ) {
			// Handle the type constraint
			switch (strtoupper($type))
			{
				case 'INT' :
				case 'INTEGER' :
					// Only use the first integer value
					@ preg_match('/-?[0-9]+/', $source, $matches);
					$result = @ (int) $matches[0];
					break;
	
				case 'FLOAT' :
				case 'DOUBLE' :
					// Only use the first floating point value
					@ preg_match('/-?[0-9]+(\.[0-9]+)?/', $source, $matches);
					$result = @ (float) $matches[0];
					break;
	
				case 'BOOL' :
				case 'BOOLEAN' :
					$result = (bool) $source;
					break;
	
				case 'WORD' :
					$result = (string) preg_replace( '#\W#', '', $source );
					break;
	
				default :
					$result = $this->_process( $filter, $source );
					break;
			}
		} else {
			$result = strip_tags( $source );	// sorry, but old mambo versions are unsafe
		}
		return $result;
	}
	
	function prepareFieldDataView() {

	}
	
	function prepareFieldDataSave( $fieldId, $fieldType, $fieldName, $value=null, $registration=0 ) {
		global $ueConfig, $_POST, $_CB_database;
		
		switch($fieldType) {
		CASE 'date': 
			$sqlFormat	=	"Y-m-d";
			$fieldForm	=	str_replace( 'y', 'Y', $ueConfig['date_format'] );
			$value		=	dateConverter( cbGetUnEscaped( $value ), $fieldForm, $sqlFormat );
		break;
		CASE 'webaddress':
			if (isset($_POST[$fieldName."Text"]) && ($_POST[$fieldName."Text"])) {
				$oValuesArr=array();
				$oValuesArr[0]=str_replace(array('mailto:','http://','https://'),'',
								cbGetUnEscaped($value));
				$oValuesArr[1]=str_replace(array('mailto:','http://','https://'),'',
								cbGetUnEscaped((isset($_POST[$fieldName."Text"]) ? stripslashes( cbGetParam( $_POST, $fieldName."Text", '' ) ) : "")));
				$value = implode("|*|",$oValuesArr);
			} else {
				$value= str_replace(array('mailto:','http://','https://'),'',cbGetUnEscaped($value));
			}
		break;
		CASE 'emailaddress': 
			$value=str_replace(array('mailto:','http://','https://'),'',cbGetUnEscaped($value));
		break;
		CASE 'editorta': 
			$value = cbGetUnEscaped( $value );
			$badHtmlFilter = & $this->getInputFilter( array (), array (), 1, 1 );
			if ( isset( $ueConfig['html_filter_allowed_tags'] ) && $ueConfig['html_filter_allowed_tags'] ) {
				$badHtmlFilter->tagBlacklist = array_diff( $badHtmlFilter->tagBlacklist, explode(" ", $ueConfig['html_filter_allowed_tags']) );
			}
			$value = $this->clean( $badHtmlFilter, $value );	
		break;
		case 'radio':
			$value = array( $value );
		// intentionally no break: fall through:
		case 'multiselect':
		case 'multicheckbox':
		case 'select':
			if ($value === null) {
				$value = array();
			}
			$_CB_database->setQuery( "SELECT fieldtitle AS id FROM #__comprofiler_field_values"
			. "\n WHERE fieldid = " . (int) $fieldId
			. "\n ORDER BY ordering" );
			$Values = $_CB_database->loadResultArray();
			if (! is_array( $Values ) ) {
				$Values = array();
			}
			foreach ( $value as $k => $v ) {
				if ( ! in_array( cbGetUnEscaped( $v ), $Values ) ) {
					unset( $value[$k] );
				}
			}

			$value=cbGetUnEscaped(implode("|*|",$value));
			
		break;
		case 'checkbox':
			if ( ( $value === null ) || ( ! in_array( $value, array( "0", "1" ) ) ) ) $value = "";
			$value=cbGetUnEscaped($value);
		break;
		case 'delimiter':
		break;
		CASE 'textarea':
		CASE 'primaryemailaddress':
		CASE 'pm':
		CASE 'image':
		CASE 'status':
		CASE 'formatname':
		CASE 'delimiter':
		CASE 'predefined':
		DEFAULT:
			$value=cbGetUnEscaped($value);
		break;
		}
		return $value;
		
	}
	
	function getErrorMSG() {
		return $this->errorMSG;
	}
	function _setErrorMSG($msg) {
		$this->errorMSG=$msg;
		return;
	}
}	// end class cbFields

class CBframework {
	/** Base framework class
	 * @var mosMainFrame */
	var $_baseFramework;

	function CBframework( &$baseFramework ) {
		$this->_baseFramework	=&	$baseFramework;
	}
	function getCfg( $config ) {
		if ( $config == 'frontend_userparams' ) {
			global $_VERSION;
			if ( ! ( ($_VERSION->PRODUCT == "Joomla!") || ($_VERSION->PRODUCT == "Accessible Joomla!") ) ) {
				return '0';
			}
		}
		return $this->_baseFramework->getCfg( $config );
	}
}

// ----- NO MORE CLASSES OR FUNCTIONS PASSED THIS POINT -----
// Post class declaration initialisations
// some version of PHP don't allow the instantiation of classes
// before they are defined

global $_CB_PMS, $_CB_framework;
global $mainframe;
/** @global cbPMS $_CB_PMS */
$_CB_PMS		=	new cbPMS();
/** @global CBframework $_CB_framework */
$_CB_framework	=	new CBframework( $mainframe );

?>

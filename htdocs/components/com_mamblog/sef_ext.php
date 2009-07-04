<?php
/**
* SEF advance component extension
*
* This extension will give the SEF advance style URLs to the Mamblog component
* Place this file (sef_ext.php) in the main component directory
* Note that class must be named: sef_componentname
*
* Copyright (C) 2003-2004 Emir Sakic, http://www.sakic.net, All rights reserved.
*
* Comments: for SEF advance > v3.6
**/

class sef_mamblog {

	var $url_array = array();

	function _getValue( &$string, &$sefstring, $val, $addval=false ) {
		$retval = "";
		if ( trim( $val ) ) {
			if (eregi("&amp;$val=",$string)) {
				$temp = split("&amp;$val=", $string);
				$temp = split("&", $temp[1]);
				if ($addval) $sefstring .= $temp[0]."/";
				$retval = $temp[0];
			}
		}
		return $retval;
	}

	function _revertValue( &$QUERY_STRING, $pos, $valname="" ) {
		$var = "";
		if (isset($this->url_array[$pos]) && $this->url_array[$pos]!="") {
			// component/example/$var1/
			$var = $this->url_array[$pos];
			if ( $valname ) $this->_setValue( $valname, $var );
		}
		return $var;
	}

	function _setValue( $valname, $var ) {
		$_GET[$valname] = $var;
		$_REQUEST[$valname] = $var;
		$QUERY_STRING .= "&$valname=$var";
	}

	function _cleanupString( $string ) {
		global $lowercase, $longurl, $url_replace;
		$string = strtr( $string, " ", _SEF_SPACE );
		$string = strtr( $string, $url_replace );
		if ( $lowercase > 0 ) $string = strtolower( $string );
		return $string;
	}

	/**
	* Creates the SEF advance URL out of the Mambo request
	* Input: $string, string, The request URL (index.php?option=com_example&Itemid=$Itemid)
	* Output: $sefstring, string, SEF advance URL ($var1/$var2/)
	**/
	function create ($string) {
		global $database;
		// $string == "index.php?option=com_example&Itemid=$Itemid&var1=$var1&var2=$var2"
		$sefstring = "";
		$action = $this->_getValue( $string, $sefstring, 'action' );
		$task = $this->_getValue( $string, $sefstring, 'task' );
		$ignorecount = intval( $this->_getValue( $string, $sefstring, 'ignorecount' ) );
		if ( $task == "show" ) {
			if ( $action == "user" || $action == "userarchive" ) {
				$id = $this->_getValue( $string, $sefstring, 'id' );
				if ( intval($id) > 0 ) {
					$id = intval( $id );
					$database->setQuery("SELECT username FROM #__users WHERE id='$id'");
					$user = $database->loadResult();
				} else {
					$user = $id;
				}
				$user = $this->_cleanupString( $user );
				$sefstring .= "$action/$user/";
				$sefstring .= $ignorecount ? "1/" : "";
			} else if ( $action == "view" || $action == "comment" ) {
				$id = intval( $this->_getValue( $string, $sefstring, 'id' ) );
				$database->setQuery("SELECT title FROM #__content WHERE id='$id'");
				$title = $this->_cleanupString( $database->loadResult() );
				$sefstring .= "$action/$id/$title/";
			} else if ( $action == "bydate" ) {
				$sefstring .= "$action/";
				$id = intval( $this->_getValue( $string, $sefstring, 'id' ), true );
				$sefstring .= $ignorecount ? "1/" : "";
			} else if ( $action == "all" || $action == "frontpage" || 
						$action == "showmyblog" || $action == "showmyarchive" ) {
				$sefstring .= "$action/";
				$sefstring .= $ignorecount ? "1/" : "";
			} else {
				$sefstring .= "show/";
				$sefstring .= $ignorecount ? "1/" : "";
			}
		} else if ( $task == "edit" ) {
			if ( $action == "delete" ) {
				$sefstring .= "delete/";
				$id = intval( $this->_getValue( $string, $sefstring, 'id' ), true );
			} else if ( $action == "modify" ) {
				$sefstring .= "edit/";
				$id = intval( $this->_getValue( $string, $sefstring, 'id', true ) );
			} else {
				$sefstring .= "edit/";
			}
		} else {

		}
		// $sefstring == "$var1/$var2/"
		return $sefstring;
	}

	/**
	* Reverts to the Mambo query string out of the SEF advance URL
	* Input:
	*    $url_array, array, The SEF advance URL split in arrays (first custom virtual directory beginning at $pos+1)
	*    $pos, int, The position of the first virtual directory (component)
	* Output: $QUERY_STRING, string, Mambo query string (var1=$var1&var2=$var2)
	*    Note that this will be added to already defined first part (option=com_example&Itemid=$Itemid)
	**/
	function revert ($url_array, $pos) {
		// define all variables you pass as globals
		global $task, $action, $id, $ignorecount;
 		// Examine the SEF advance URL and extract the variables building the query string
		$this->url_array = $url_array;
		$QUERY_STRING = "";
		$check = $this->_revertValue( &$QUERY_STRING, $pos + 2 );
		switch ( $check ) {
			case "user":
			case "userarchive":
				$task = "show";
				$this->_setValue( "task", $task );
				$action = $check;
				$this->_setValue( "action", $action );
				$id = $this->_revertValue( &$QUERY_STRING, $pos + 3, 'id' );
				$foo = $this->_revertValue( &$QUERY_STRING, $pos + 4 );
				if ( $foo ) {
					$ignorecount = "1";
					$this->_setValue( "ignorecount", "1" );
				}
				break;
			case "view":
			case "comment":
				$task = "show";
				$this->_setValue( "task", $task );
				$action = $check;
				$this->_setValue( "action", $action );
				$id = $this->_revertValue( &$QUERY_STRING, $pos + 3, 'id' );
				break;
			case "bydate":
				$task = "show";
				$this->_setValue( "task", $task );
				$action = $check;
				$this->_setValue( "action", $action );
				$id = $this->_revertValue( &$QUERY_STRING, $pos + 3, 'id' );
				$foo = $this->_revertValue( &$QUERY_STRING, $pos + 4 );
				if ( $foo ) {
					$ignorecount = "1";
					$this->_setValue( "ignorecount", "1" );
				}
				break;
			case "show":
				$task = "show";
				$this->_setValue( "task", $task );
				$action = "";
				$this->_setValue( "action", $action );
				$foo = $this->_revertValue( &$QUERY_STRING, $pos + 3 );
				if ( $foo ) {
					$ignorecount = "1";
					$this->_setValue( "ignorecount", "1" );
				}
				break;
			case "all":
			case "frontpage":
			case "showmyblog":
			case "showmyarchive":
				$task = "show";
				$this->_setValue( "task", $task );
				$action = $check;
				$this->_setValue( "action", $action );
				$foo = $this->_revertValue( &$QUERY_STRING, $pos + 4 );
				if ( $foo ) {
					$ignorecount = "1";
					$this->_setValue( "ignorecount", "1" );
				}
				break;
			case "edit":
			case "delete":
				$task = "edit";
				$this->_setValue( "task", $task );
				$id = $this->_revertValue( &$QUERY_STRING, $pos + 3, 'id' );
				if ( $check == "edit" && trim( $id ) ) {
					$action = "modify";
				} else {
					$action = $check;
				}
				$this->_setValue( "action", $action );
				break;
			case "":
				break;
			default:
		}
		return $QUERY_STRING;
	}

}
?>
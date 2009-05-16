<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

class moscbeHTML extends JHTML {

	function radioList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected, $required=0, $readOnly=0 ) {
		// $adminReq=0, 
		reset( $arr );
		// needs more work : if ($readOnly == '1' && !empty($selected)) {
		if ($readOnly == '1') {
			$pReadOnly = " DISABLED disabled=\"disabled\" ";
		} else {
			$pReadOnly = "";
		}
		$html = "";
		$html .= "<table class=\"cbe_radioList_table\"> \n <tr><td> \n";
		$f_options = "";
		$f_anz = count($arr);
		$f_tbp = 0;
		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = stripslashes($arr[$i]->$key);
			$t = stripslashes($arr[$i]->$text);
			$id = @$arr[$i]->id;

			$extra = '';
			$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					$k2 = stripslashes($obj->$key);
					if ($k == $k2) {
						$extra .= " CHECKED";
						break;
					}
				}
			} else {
				$extra .= ($k == stripslashes($selected) ? " CHECKED" : '');
			}
			if($i==0) $isReq="mosReq=".$required;
			else $isReq="";
			
			$f_tbp = ($f_tbp==1) ? 2 : 1;
			if ( $f_tbp == 2 ) {
				$f_options = "</td></tr><tr><td>";
			} else if (count($arr) == 1) {
				$f_options = "</td><td></td></tr>";
			} else {
				$f_options = "</td><td>";
			}
			
			$html .= "\n\t <input type=\"radio\" name=\"$tag_name\" $isReq $pReadOnly $tag_attribs value=\"".$k."\"$extra> " . CBE_getLangDefinition($t) . $f_options;
		}
		$html .= "\n";
		$html .= "</td></tr> </table> \n";
		
		return $html;
	}
	function selectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected, $required=0, $readOnly=0, $multi=0 ) {
		reset( $arr );
		if ($readOnly == '1') {
			$pReadOnly = " DISABLED disabled=\"disabled\" ";
		} else {
			$pReadOnly = "";
		}
		if($required==0) $isReq="mosReq=".$required;
		else $isReq="";
		$html = "\n<select name=\"$tag_name\" $tag_attribs".$pReadOnly." ".$isReq.">";
		//if(!$required) $html .= "\n\t<option value=\"\"> </option>";
		if(!$multi) $html .= "\n\t<option value=\"\"> </option>";

		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = stripslashes($arr[$i]->$key);
			$t = stripslashes($arr[$i]->$text);
			$id = @$arr[$i]->id;

			$extra = '';
			$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					$k2 = stripslashes($obj->$key);
					if ($k == $k2) {
						$extra .= " selected=\"selected\"";
						break;
					}
				}
			} else {
				$extra .= ($k == stripslashes($selected) ? " selected=\"selected\"" : '');
			}
			$html .= "\n\t<option value=\"".$k."\"$extra>";
			$html .= CBE_getLangDefinition($t);
			$html .= "</option>";
		}
		$html .= "\n</select>\n";
		return $html;
	}
	function checkboxList( &$arr, $tag_name, $tag_attribs,  $key='value', $text='text',$selected=null, $required=0, $readOnly=0  ) {
		reset( $arr );
		if ($readOnly == '1') {
			$pReadOnly = " DISABLED disabled=\"disabled\" ";
		} else {
			$pReadOnly = "";
		}
		$html = "";
		$html .= "<table class=\"cbe_checkboxList_table\"> \n <tr><td> \n";
		$f_options = "";
		$f_anz = count($arr);
		$f_tbp = 0;
		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
			$k = $arr[$i]->$key;
			$t = $arr[$i]->$text;
			$id = @$arr[$i]->id;

			$extra = '';
			$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected )) {
				foreach ($selected as $obj) {
					$k2 = $obj->$key;
					if ($k == $k2) {
						$extra .= " checked=\"checked\"";
						break;
					}
				}
			} else {
				$extra .= ($k == $selected ? " checked=\"checked\"" : '');
			}
			if($i==0) $isReq=$required;
			else $isReq=0;
			
			$f_tbp = ($f_tbp==1) ? 2 : 1;
			if ( $f_tbp == 2 ) {
				$f_options = "</td></tr><tr><td>";
			} else if (count($arr) == 1) {
				$f_options = "</td><td></td></tr>";
			} else {
				$f_options = "</td><td>";
			}

			$html .= "\n\t<input type=\"checkbox\" name=\"$tag_name\" mosReq=\"$isReq\"".$pReadOnly."value=\"".$k."\"$extra $tag_attribs />" . CBE_getLangDefinition($t) . $f_options;
		}
		$html .= "\n";
		$html .= "</td></tr> </table> \n";
		return $html;
	}
}
?>
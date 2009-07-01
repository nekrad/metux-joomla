<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementSefsubdomain extends JElement
{
	function fetchElement($name, $value, &$node, $control_name)
	{
			if(JPath::find(JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers','defines.php')) {
				require_once(JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers'.DS.'defines.php');
				require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_joomfish' .DS. 'classes' .DS.'JoomfishManager.class.php' );
			} else {
				JError::raiseNotice('no_jf_component', JText::_('Joom!Fish component not installed correctly. Plugin not executed'));
			}
			$jfm = JoomFishManager::getInstance();
			$activeLanguages = $jfm->getActiveLanguages();

			$indexedvalues = array();
			if (!is_array($value)){
				$default = $value;
				foreach ($activeLanguages as $key => $val) {
					$indexedvalues[$key] = $val->id."::".$default; 
				}
			}
			else {
				foreach ($value as $val) {
					list($key,$val) = split("::",$val,2);
					$indexedvalues[$key] = $val; 					
				}
			}
			$html = "<fieldset><table>";
			$html .= "<tr style='font-weight:bold;'><td>".JText::_("Language")."</td><td>".JText::_("Prefix")."</td></tr>";
			foreach ($activeLanguages as $key => $val) {
				$html .= "<tr>";
				$html .= '<td>'.$val->name.'</td><td>';
				$prefix = array_key_exists($val->id,$indexedvalues)? $indexedvalues[$val->id] : ""; 
				$idprefix = $val->id."::".$prefix;
				$html .= "<input type='text' length='10' maxlength='50' id='sefprefix".$val->id."' onblur='document.getElementById(\"hiddensefsubdomain".$val->id."\").value=\"".$val->id."::\"+this.value;' value='".$prefix."' />";
				$html .= "<input type='hidden' id='hiddensefsubdomain".$val->id."' name='".$control_name.'['.$name.'][]'."' value='".$idprefix."' />";	
				$html .= "</td></tr>";
			}
			$html .="</table></fieldset>";

			return $html;
		
	}
}
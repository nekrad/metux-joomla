<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementDtcomps extends JElement
{

	function fetchElement($name, $value, &$node, $control_name)
	{

		if (!is_array($value)){
			$value = array();
			$value[]="com_content#content#cid#task#!edit";
			$value[]="com_frontpage#content#cid#task#!edit";
			$value[]="com_sections#sections#cid#task#!edit";
			$value[]="com_categories#categories#cid#task#!edit";
			$value[]="com_contact#contact_details#cid#!edit";
			$value[]="com_menus#menu#cid#task#!edit";
			$value[]="com_modules#modules#cid#task#!edit#client#!1";
			$value[]="com_newsfeeds#newsfeeds#cid#task#!edit";
			$value[]="com_poll#polls#cid#task#!edit";
		}
		$html ="";
		for ($i=0;$i<count($value)+10;$i++) {
			$val = "";
			if ($i<count($value)){
				$val = $value[$i];
				if ($val=="") continue;
			}
			$html .= "<div>";
			$html .= "<input type='text' size='50' maxsize='100'  name='".$control_name.'['.$name.'][]'."' value='".$val."' />";
			$html .= "</div>";
		}

		return $html;

	}
}
<?php
/**
* @version $Id: af.lib.legacy.php v.2.1b7 2007-12-10 16:44:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @copyright Copyright (C) 2005 Andreas Duswald
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

function afMenuSelect( $name='menuselect', $javascript=NULL )
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT params'
		. ' FROM #__modules'
		. ' WHERE module = "mod_mainmenu"'
		;
		$db->setQuery( $query );
		$menus = $db->loadObjectList();
		$total = count( $menus );
		$menuselect = array();
		for( $i = 0; $i < $total; $i++ )
		{
			$registry = new JRegistry();
			$registry->loadINI($menus[$i]->params);
			$params = $registry->toObject( );

			$menuselect[$i]->value 	= $params->menutype;
			$menuselect[$i]->text 	= $params->menutype;
		}
		// sort array of objects
		JArrayHelper::sortObjects( $menuselect, 'text', 1 );

		$menus = JHTML::_('select.genericlist',   $menuselect, $name, 'class="inputbox" size="10" '. $javascript, 'value', 'text' );

		return $menus;
	}


function afBindArrayToObject( $array, &$obj, $ignore='', $prefix=NULL, $checkSlashes=true )
{
	if (!is_array( $array ) || !is_object( $obj )) {
		return (false);
	}

	foreach (get_object_vars($obj) as $k => $v)
	{
		if( substr( $k, 0, 1 ) != '_' )
		{
			// internal attributes of an object are ignored
			if (strpos( $ignore, $k) === false)
			{
				if ($prefix) {
					$ak = $prefix . $k;
				} else {
					$ak = $k;
				}
				if (isset($array[$ak])) {
					$obj->$k = ($checkSlashes && get_magic_quotes_gpc()) ? afStripslashes( $array[$ak] ) : $array[$ak];
				}
			}
		}
	}

	return true;
}


function afStripslashes( &$value )
{
	$ret = '';
	if (is_string( $value )) {
		$ret = stripslashes( $value );
	} else {
		if (is_array( $value )) {
			$ret = array();
			foreach ($value as $key => $val) {
				$ret[$key] = mosStripslashes( $val );
			}
		} else {
			$ret = $value;
		}
	}
	return $ret;
}


/* Deprecated? Check this  */
function afLinks2Menu( $type, $and ){
   /*
   $db =& JFactory::getDBO();

   $query = 'SELECT * '
   . ' FROM #__menu '
   . ' WHERE type = '.$db->Quote($type)
   . ' AND published = 1'
   . $and
   ;
   $db->setQuery( $query );
   $menus = $db->loadObjectList();

   return $menus;
   */
}


?>

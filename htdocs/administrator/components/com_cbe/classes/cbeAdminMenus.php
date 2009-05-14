<?php

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

class cbeAdminMenus {
	
	function TabCategory( $name, $option, $active=NULL, $javascript=NULL, $order='ordering', $size=1, $sel_cat=1 ) {
		global $mainframe;
		// funktionen einbinden
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

		$acl =& JFactory::getACL();
		$database = &JFactory::getDBO();

		$query = "SELECT tabid AS value, title AS text, enhanced_params as enhp"
		. "\n FROM #__cbe_tabs"
		. "\n WHERE enabled = 1"
		. "\n ORDER BY $order"
		;
		$database->setQuery( $query );
		$tab_cats = $database->loadObjectList();
		if (count($tab_cats) > 0) {
			$tab_catn = array();
			foreach ($tab_cats as $tab_cat) {
				$tab_cat->text = getLangDefinition($tab_cat->text);
				if ($tab_cat->enhp != "") {
					$tab_cat->text = $tab_cat->text." -EnhTab- ";
				}
				$tab_catn[] = $tab_cat;
			}
		}

		if ( $sel_cat ) {
			$categories[] = JHTML::_('select.option','0', _SEL_CATEGORY);
//			$categories = array_merge( $categories, $database->loadObjectList() );
			$categories = array_merge( $categories, $tab_catn );
		} else {
//			$categories = $database->loadObjectList();
			$categories = $tab_catn;
		}

		if ( count( $categories ) < 1 ) {
			$mainframe->redirect( "index2.php?option=$option&task=showField" );
		}

		//$category = mosHTML::selectList( $categories, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

		$category = JHTML::_('select.genericlist', $categories, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );
		//print_r($category);
		return $category;
	}
	
} // end class cbeAdminMenus
?>
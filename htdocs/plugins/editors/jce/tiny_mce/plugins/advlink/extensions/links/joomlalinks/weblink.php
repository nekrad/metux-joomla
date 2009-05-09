<?php
// no direct access
defined( '_JCE_EXT' ) or die( 'Restricted access' );
class WeblinkLinks{
	function getOptions(){
		$advlink =& AdvLink::getInstance();
		$options = '';
		if( $advlink->checkAccess( 'weblink', '18' ) ){
			$options .= '<option value="weblink.category">' . JText::_('WEBLINK') . '</option>';
		}
		return $options;	
	}
	function getItems( $type, $id ){
		$items = new stdClass();
		$items->level 	= 1;
		$items->next 	= '';
		switch( $type ){
			case 'weblink.category':
				$items->label	= JText::_('Select Category');
				$items->next 	= 'weblink';
				$categories = AdvLink::getCategory( 'com_weblinks' );
				foreach( $categories as $category ){
					$items->data[] = array(
						'value' => intval( $category->value ),
						'text' 	=> $category->text
					);
				}
				break;
			case 'weblink':
				require_once(JPATH_SITE.DS.'components'.DS.'com_weblinks'.DS.'helpers'.DS.'route.php');
				
				$items->label	= JText::_('Select Weblink');
				$items->level 	= 2;
				$weblinks = WeblinkLinks::_weblinks( $id );
				foreach( $weblinks as $weblink ){
					$items->data[] = array(
						'value' => WeblinksHelperRoute::getWeblinkRoute($weblink->slug, $weblink->catslug),
						'text' 	=> $weblink->text
					);
				}
				break;
		}
		return $items;
	}
	function _weblinks( $id ){
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();
		
		$query = 'SELECT a.title AS text,'
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '
		. ' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(\':\', b.id, b.alias) ELSE b.id END as catslug'
		. ' FROM #__weblinks AS a'
		. ' INNER JOIN #__categories AS b ON b.id = '.(int) $id
		. ' WHERE a.published = 1'
		. ' AND b.published = 1'
		. ' AND b.access <= '.(int) $user->get( 'aid' )
		. ' ORDER BY a.title'
		;
		
		$db->setQuery( $query, 0 );
		return $db->loadObjectList();
	}
}
?>

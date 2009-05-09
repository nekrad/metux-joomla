<?php
// no direct access
defined( '_JCE_EXT' ) or die( 'Restricted access' );
class ContentLinks{
	function getOptions(){
		$advlink =& AdvLink::getInstance();
		$options = '';
		if( $advlink->checkAccess( 'advlink_section', '1' ) ){
				$options .= '<option value="content.section">' . JText::_('SECTION') . '</option>';
		}
		if( $advlink->checkAccess( 'advlink_category', '1' ) ){
				$options .= '<option value="content.category.section">' . JText::_('CATEGORY') . '</option>';
		}
		if( $advlink->checkAccess( 'advlink_article', '1' ) ){
				$options .= '<option value="content.article.section">' . JText::_('ARTICLE') . '</option>';
		}
		if( $advlink->checkAccess( 'advlink_static', '1' ) ){
				$options .= '<option value="content.static">' . JText::_('UNCATEGORIZED') . '</option>';
		}
		return $options;	
	}
	function getItems( $type, $id=0 ){		
		global $mainframe;		
		require_once( JPATH_SITE .DS. 'components' .DS. 'com_content' .DS. 'helpers' .DS. 'route.php' );
		
		$sections = ContentLinks::_section();
		$items = new stdClass();
		$items->level 	= 1;
		$items->next 	= '';
		switch( $type ){
			case 'content.section':
				$items->label = JText::_('Select Section');
				foreach( $sections as $section ){
					$items->data[] = array(
						'value' => ContentHelperRoute::getSectionRoute($section->value),
						'text' 	=> $section->text
					);
				}
				break;
			case 'content.category.section':
			case 'content.article.section':
				$items->next 	= ( $type == 'content.category.section' ) ? 'content.category' : 'content.article.category';
				$items->label 	= JText::_('Select Section');
				foreach( $sections as $section ){
					$items->data[] = array(
						'value' => intval( $section->value ),
						'text' 	=> $section->text
					);
				}
				break;
			case 'content.category':			
				$categories = AdvLink::getCategory( $id );
				$items->level = 2;
				foreach( $categories as $category ){
					$items->label = JText::_('Select Category');
					$items->data[] = array(
						'value' => ContentHelperRoute::getCategoryRoute( $category->slug, $id ),
						'text' 	=> $category->text
					);
				}
				break;
			case 'content.article.category':
				$items->next 	= 'content.article';
				$items->label 	= JText::_('Select Category');
				$items->level 	= 2;
				$categories = AdvLink::getCategory( $id );
				foreach( $categories as $category ){
					$items->data[] = array(
						'value' => intval( $category->value ),
						'text' 	=> $category->text
					);
				}
				break;
			case 'content.article':
				$articles = ContentLinks::_articles( $id );
				$items->label = JText::_('Select Article');
				$items->level = 3;
				foreach( $articles as $article ){
					$items->data[] = array(
						'value' => ContentHelperRoute::getArticleRoute( $article->slug, $article->catslug, $article->sectionid ),
						'text' 	=> $article->text
					);
				}
				break;
			case 'content.static':			
				$statics = ContentLinks::_statics();
				$items->label = JText::_('Select Uncategorized');
				foreach( $statics as $static ){
					$Itemid = $mainframe->getItemid( $static->text );
					if( !$Itemid ) $Itemid = '1';
					$items->data[] = array(
						'value' => ContentHelperRoute::getArticleRoute( $static->value ),
						'text' 	=> $static->text
					);
				}
				break;
		}
		return $items;
	}
	function _section(){
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();
		
		$query = 'SELECT id as value, CONCAT( title, " /",  name, "" ) AS text'
		. ' FROM #__sections'
		. ' WHERE published = 1'
		. ' AND access <= '.(int) $user->get( 'aid' )
		//. ' GROUP BY id'
		. ' ORDER BY title'
		;

		$db->setQuery( $query );
		return $db->loadObjectList();		
	}
	function _articles( $id ){
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();
	
		$query = 'SELECT a.title AS title, u.id AS sectionid,'
		. ' CONCAT(a.title, " /", a.title_alias) AS text,'
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'
		. ' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(":", b.id, b.alias) ELSE b.id END as catslug'
		. ' FROM #__content AS a'
		. ' INNER JOIN #__categories AS b ON b.id = '.(int) $id
		. ' INNER JOIN #__sections AS u ON u.id = a.sectionid'
		. ' WHERE a.catid = '.(int) $id
		. ' AND a.state = 1'
		. ' AND a.access <= '.(int) $user->get( 'aid' )
		//. ' GROUP BY a.id'
		. ' ORDER BY a.title'
		;
		$db->setQuery( $query, 0 );
		return $db->loadObjectList();
	}
	function _statics(){
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();
		
		$query = 'SELECT id AS value, CONCAT( title, " /", title_alias, "" ) AS text'
		. ' FROM #__content'
		. ' WHERE state = 1'
		. ' AND access <= '.(int) $user->get( 'aid' )
		. ' AND sectionid = 0'
		. ' AND catid = 0'
		. ' ORDER BY title'
		;
		$db->setQuery( $query, 0 );
		return $db->loadObjectList();
	}
}
?>
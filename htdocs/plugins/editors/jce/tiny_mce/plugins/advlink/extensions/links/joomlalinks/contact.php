<?php
// no direct access
defined( '_JCE_EXT' ) or die( 'Restricted access' );
class ContactLinks {
	function getOptions(){
		//Reference to JConentEditor (JCE) instance
		$advlink =& AdvLink::getInstance();
		$options = '';
		if( $advlink->checkAccess( 'contact', '1' ) ){	
			$options .= '<option value="contact.category">' . JText::_('CONTACT') . '</option>';
		}
		return $options;	
	}
	function getItems( $type, $id='' ){
		$items = new stdClass();
		$items->level 	= 1;
		$items->next 	= '';
		switch( $type ){
			case 'contact.category':
				$items->next 	= 'contact';
				$items->label 	= JText::_('Select Category');
				$categories 	= AdvLink::getCategory( 'com_contact_details' );
				foreach( $categories as $category ){
					$items->data[] = array(
						'value' => intval( $category->value ),
						'text' 	=> $category->text
					);
				}
				break;
			case 'contact':
				$items->level 	= 2;
				$items->label 	= JText::_('Select Contact');
				$contacts 		= ContactLinks::_contacts( $id );
				foreach( $contacts as $contact ){
					$items->data[] = array(
						'value' => 'index.php?option=com_contact&view=contact&catid='. $id .'&id='.$contact->slug,
						'text' 	=> $contact->text
					);
				}
				break;
		}
		return $items;
	}
	function _contacts( $id ){
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();	
		
		$query	= 'SELECT CONCAT_WS( name, " /", con_position, "" ) AS text, '
		. ' CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(":", id, alias) ELSE id END as slug'
		. ' FROM #__contact_details'
		. ' WHERE catid = '.(int) $id
		. ' AND published = 1'
		. ' AND access <= '.(int) $user->get( 'aid' )
		//. ' GROUP BY id'
		. ' ORDER BY name'
		;
		$db->setQuery( $query );
		return $db->loadObjectList();
	}
}
?>

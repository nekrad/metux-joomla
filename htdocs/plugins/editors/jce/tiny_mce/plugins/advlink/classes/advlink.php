<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Set flag that this is an extension parent
DEFINE( '_JCE_EXT', 1 );
class AdvLink extends JContentEditorPlugin {
	/*
	*  @var varchar
	*/
	var $_linkextensions = array();
	/**
	* Constructor activating the default information of the class
	*
	* @access	protected
	*/
	function __construct(){
		parent::__construct();
				
		$extensions = $this->loadExtensions( 'links' );
		
		foreach( $extensions as $extension ){
			if( $extension ){
				if( is_array( $extension ) ){
					foreach( $extension as $sibling ){
						$this->_linkextensions[] = $sibling;
					}
				}else{
					$this->_linkextensions[] = $extension;
				}
			}
		}
		// Setup XHR callback functions 
		$this->setXHR( array( &$this, 'getLinks' ) );
		
		// Set javascript file array
		$this->script( array( 
			'tiny_mce_popup', 
		), 'tiny_mce' );
		$this->script( array( 
			'tiny_mce_utils',
			'mootools',
			'jce',
			'plugin'
		) );
		$this->script( array( 'advlink' ), 'plugins' );
		// Set css file array
		$this->css( array( 'common' ) );
		$this->css( array( 'advlink' ), 'plugins' );
		$this->loadLanguages();
	}
	/**
	 * Returns a reference to a plugin object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $advlink = &AdvLink::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance(){
		static $instance;

		if ( !is_object( $instance ) ){
			$instance = new AdvLink();
		}
		return $instance;
	}	
	function getLists(){
		$options = '<option value="">--' . JText::_('SELECT LINK TYPE') . '--</option>';
		foreach( $this->_linkextensions as $extension ){			
			// Path specified, assume extra files			
			if( $extension['path'] ){
				include_once( $extension['path'] .DS. $extension['file'] );
			}
			$class = ucfirst( $extension['name'] ) . 'Links';
			if( is_callable( array( $class, 'getOptions' ) ) ){
				$options .= call_user_func( array( $class, 'getOptions' ) );	
			}else{
				// No class file specified, use function instead.
				$options .= call_user_func( $extension['name'] . 'getOptions' );
			}
		}	
		return $options;
	}
	function getLinks( $type, $level, $id=0 ){
		foreach( $this->_linkextensions as $ext ){
			// Check the prefix of the request
			$pre = explode( '.', $type );
			if( $pre[0] == $ext['name'] ){
				// Path specified, assume extra files
				if( $ext['path'] ){
					include_once( $ext['path'] .DS. $ext['file'] );
					$class = ucfirst( $ext['name'] ) . 'Links';
					$items = call_user_func( array( $class, 'getItems' ), $type, $id );
				}else{
					// No class file specified, use function instead.
					$items = call_user_func( $ext['name'] . 'getItems', $type, $id );
				}
			}
		}
		$result = array(
			'next'		=>	'',
			'label'		=>	JText::_('No Items'),
			'level'		=>	$level + 1,
			'items'		=>	''
		);
		if( isset( $items->data ) ){			
			foreach( $items->data as $item ){
				$array[] = array(
					'value' =>	$this->xmlEncode( $item['value'] ), 
					'text'	=>	$this->xmlEncode( $item['text'] )
				);
			}
			$result = array( 
				'next'		=>	$items->next,
				'label'		=>	$items->label,
				'level'		=>	$items->level,
				'items'		=>	$array
			);
		}
		return $result;
	}
	/**
	 * Category function used by many extensions
	 *
	 * @access	public
	 * @return	Category list object.
	 * @since	1.5
	 */
	function getCategory( $sid ){
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		$query	= 'SELECT CONCAT( title, " /", name, "" ) AS text,'
		. ' id AS value,'
		. ' CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(":", id, alias) ELSE id END as slug'
		. ' FROM #__categories'
		. ' WHERE section = '. $db->Quote( $sid )
		. ' AND published = 1'
		. ' AND access <= '.(int) $user->get('aid')
		. ' GROUP BY id'
		. ' ORDER BY title'
		;
		$db->setQuery( $query );
		return $db->loadObjectList();		
	}
}
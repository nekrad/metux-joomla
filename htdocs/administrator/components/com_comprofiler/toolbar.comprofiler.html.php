<?php
/**
* User Menu Button Bar HTML
* @version $Id: toolbar.comprofiler.html.php 344 2006-08-05 10:25:39Z beat $
* @package Community Builder
* @subpackage toolbar.comprofiler.html.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class CBtoolmenuBar extends mosMenuBar {
	/**
	* Writes the common $action icon for the button bar
	* @param string url link
	* @param string action (for displaying correct icon))
	* @param string An override for the alt text
	*/
	function linkAction( $action='new', $link='', $alt='New' ) {
		$image2 = mosAdminMenus::ImageCheckAdmin( $action . '_f2.png', '/administrator/images/', NULL, NULL, $alt, NULL, 1, 'middle', $alt );
		if ( cbStartOfStringMatch( $link, 'javascript:' ) ) {
			$link	=	'javascript:void(0);" onclick="' . $link;
		}
		?>
		<td>
			<a class="toolbar" href="<?php echo $link;?>">
				<?php echo $image2; ?>
				<br /><?php echo $alt; ?></a>
		</td>
		<?php
	}
	/**
	* Writes a common 'edit' button for a list of records
	* @param string An override for the task
	* @param string An override for the alt text
	*/
	function editList( $task='edit', $alt='Edit' ) {
		$image2 = mosAdminMenus::ImageCheckAdmin( 'edit_f2.png', '/administrator/images/', NULL, NULL, $alt, $task, 1, 'middle', $alt );
		?>
		<td>
			<a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>', '');">
				<?php echo $image2; ?>
				<br /><?php echo $alt; ?></a>
		</td>
		<?php
	}
}

class TOOLBAR_usersextras {
	/**
	* Draws the menu for a New users
	*/
	function _NEW() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::cancel('showusers');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	
	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::cancel('showusers');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _NEW_TAB() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveTab');
		mosMenuBar::cancel('showTab');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	
	function _EDIT_TAB() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveTab');
		mosMenuBar::cancel('showTab');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	function _DEFAULT_TAB() {
		mosMenuBar::startTable();
		mosMenuBar::custom( 'newTab', 'new.png', 'new_f2.png', 'New Tab', false );
		mosMenuBar::editList('editTab');
		mosMenuBar::deleteList('The tab will be deleted and cannot be undone!','removeTab');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	function _NEW_FIELD() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveField');
		mosMenuBar::cancel('showField');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	
	function _EDIT_FIELD() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveField');
		mosMenuBar::cancel('showField');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	function _DEFAULT_FIELD() {
		mosMenuBar::startTable();
		mosMenuBar::custom( 'newField', 'new.png', 'new_f2.png', 'New Field', false );
		mosMenuBar::editList('editField');
		mosMenuBar::deleteList('The Field and all user data associated to this field will be lost and cannot be undone!','removeField');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	function _NEW_LIST() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveList');
		mosMenuBar::cancel('showLists');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	
	function _EDIT_LIST() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveList');
		mosMenuBar::cancel('showLists');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	function _DEFAULT_LIST() {
		mosMenuBar::startTable();
		mosMenuBar::custom( 'newList', 'new.png', 'new_f2.png', 'New List', false );
		mosMenuBar::editList('editList');
		mosMenuBar::deleteList('The selected List(s) will be deleted and cannot be undone!','removeList');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
	function _EDIT_CONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveconfig');
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

	function _EDIT_PLUGIN() {
		global $id;
		
		mosMenuBar::startTable();
		mosMenuBar::save('savePlugin');
		mosMenuBar::spacer();
		mosMenuBar::apply('applyPlugin');
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelPlugin', 'Close' );
		/*
		if ( $id ) {
			// for existing content items the button is renamed `close`
			mosMenuBar::cancel( 'cancelPlugin', 'Close' );
		} else {
			mosMenuBar::cancel('showPlugins');
		}
		*/
		mosMenuBar::endTable();
	}

	function _PLUGIN_ACTION_SHOW() {
		mosMenuBar::startTable();
		mosMenuBar::cancel( 'cancelPluginAction', 'Close' );
		mosMenuBar::endTable();
	}

	function _PLUGIN_ACTION_EDIT() {
		global $id;
		
		mosMenuBar::startTable();
		mosMenuBar::save('savePlugin');
		mosMenuBar::spacer();
		mosMenuBar::apply('applyPlugin');
		mosMenuBar::spacer();
		mosMenuBar::cancel( 'cancelPluginAction', 'Close' );
		/*
		if ( $id ) {
			// for existing content items the button is renamed `close`
			mosMenuBar::cancel( 'cancelPlugin', 'Close' );
		} else {
			mosMenuBar::cancel('showPlugins');
		}
		*/
		mosMenuBar::endTable();
	}

	function _PLUGIN_MENU( &$xmlToolbarMenuArray ) {
		if ( $xmlToolbarMenuArray && ( count( $xmlToolbarMenuArray ) > 0 ) ) {
			CBtoolmenuBar::startTable();
			foreach ( $xmlToolbarMenuArray as $xmlTBmenu ) {
				if ( $xmlTBmenu && ( count( $xmlTBmenu->children() ) > 0 ) ) {
					$menuitems				=	$xmlTBmenu->children();
					foreach ( $menuitems as $menu ) {
						if ( $menu->name() == 'menu' ) {
							$name			=	$menu->attributes( 'name' );
							$action			=	$menu->attributes( 'action' );
							$task			=	$menu->attributes( 'task' );
							$label			=	$menu->attributes( 'label' );
							// $description	=	$menu->attributes( 'description' );
							
							if ( in_array( $action, get_class_methods( 'CBtoolmenuBar' ) ) || in_array( strtolower( $action ), get_class_methods( 'CBtoolmenuBar' ) ) ) {		// PHP 5 || PHP 4
								switch ( $action ) {
									case 'custom':
									case 'customX':
										$icon		=	$menu->attributes( 'icon' );
										$iconOver	=	$menu->attributes( 'iconover' );
										CBtoolmenuBar::$action( $task, $icon, $iconOver, $label, false );
										break;
									case 'deleteList':
									case 'deleteListX':
										$message	=	$menu->attributes( 'message' );
										CBtoolmenuBar::$action( $message, $task, $label );
										break;
									case 'trash':
										CBtoolmenuBar::$action( $task, $label, false );
										break;
									case 'preview':
										$popup	=	$menu->attributes( 'popup' );
										CBtoolmenuBar::$action( $popup, true );
										break;
									case 'help':
										$ref	=	$menu->attributes( 'ref' );
										CBtoolmenuBar::$action( $ref, true );
										break;
									case 'savenew':
									case 'saveedit':
									case 'divider':
									case 'spacer':
										CBtoolmenuBar::$action();
										break;
									case 'back':
										$href	=	$menu->attributes( 'href' );
										CBtoolmenuBar::$action( $label, $href );
										break;
									case 'media_manager':
										$directory	=	$menu->attributes( 'directory' );
										CBtoolmenuBar::$action( $directory, $label );
										break;
									case 'linkAction':
										$urllink	=	$menu->attributes( 'urllink' );
										CBtoolmenuBar::$action( $task, $urllink, $label );
										break;
									default:
										CBtoolmenuBar::$action( $task, $label );
										break;
								}
	
							}
							if ( in_array( $action, array(	'customX', 'addNew', 'addNewX', 'publish', 'publishList', 'makeDefault', 'assign', 'unpublish', 'unpublishList', 
															'archiveList', 'unarchiveList', ) ) ) {
								// nothing
							}
						}
					}
				}
			}
			CBtoolmenuBar::endTable();
		}
	}

	function _DEFAULT_PLUGIN() {
		mosMenuBar::startTable();
		mosMenuBar::publishList('publishPlugin');
		mosMenuBar::spacer();
		mosMenuBar::unpublishList('unpublishPlugin');
		// mosMenuBar::spacer();
		// mosMenuBar::   "addInstall" link ('newPlugin');
/*
		mosMenuBar::spacer();
		if (is_callable(array("mosMenuBar","addNewX"))) {		// Mambo 4.5.0 support:
			mosMenuBar::addNewX('newPlugin');
		} else {
			mosMenuBar::addNew('newPlugin');
		}
*/
		mosMenuBar::spacer();
		if (is_callable(array("mosMenuBar","editListX"))) {		// Mambo 4.5.0 support:
			mosMenuBar::editListX('editPlugin');
		} else {
			mosMenuBar::editList('editPlugin');
		}
		mosMenuBar::spacer();
		mosMenuBar::deleteList('','deletePlugin');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}
}
?>
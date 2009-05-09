<?php
/**
 * @version		$Id: manager.php 2007-08-04 09:51:30Z happy_noodle_boy $
 * @package		JCE
 * @copyright	Copyright (C) 2005 - 2007 Ryan Demmer. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

/**
 * Manager class
 *
 * @static
 * @package		JCE
 * @since	1.5
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class Manager extends JContentEditorPlugin{
		/*
		*  @var varchar
		*/
        var $_base = null;
		/*
		*  @var array
		*/
		var $_buttons = array();
		/*
		*  @var array
		*/
		var $_actions = array();
		/*
		*  @var string
		*/
		var $_filetypes = 'jpg,jpeg,gif,png';
		/*
		*  @var array
		*/
		var $_events = array();
		/*
		*  @var array
		*/
		var $_result = array(
			'error' => ''
		);
		/*
		*  @var array
		*/
		var $_alerts = array();
		/**
		* @access	protected
		*/
		function __construct(){
			// Call parent
			parent::__construct();
			
			$this->_base 			= $this->getRootDir();
			$this->_filetypes 		= $this->getFileTypes();
			$this->_plugin->type	= 'manager';

		}
		/**
		 * Returns a reference to a Manager object
		 *
		 * This method must be invoked as:
		 * 		<pre>  $manager = &Manager::getInstance();</pre>
		 *
		 * @access	public
		 * @return	JCE  The editor object.
		 * @since	1.5
		 */
		function &getInstance(){
			static $instance;

			if ( !is_object( $instance ) ){
				$instance = new Manager();
			}
			return $instance;
		}
		function init(){
			// Setup XHR callback funtions
			$this->setXHR( array( &$this, 'getItems' ) );
			$this->setXHR( array( &$this, 'getFileDetails' ) );
			$this->setXHR( array( &$this, 'getFolderDetails' ) );
			$this->setXHR( array( &$this, 'getTree' ) );
			$this->setXHR( array( &$this, 'getTreeItem' ) );
			
			// Get actions
			$this->getStdActions();
			// Get buttons
			$this->getStdButtons();
			
			// Store default manager scripts
			$this->script( array( 'tiny_mce_popup' ), 'tiny_mce' );
			$this->script( array( 				
				'tiny_mce_utils',
				'mootools',
				'jce',
				'plugin', 
				'window',
				'listsorter',
				'searchables',
				'tree',
				'swiff',
				'manager'
			) );
			
			// Store default manager css
			$this->css( array( 
				'common', 
				'manager',
				'upload',
				'tree'
			) );
			$this->css( array( 
				'window',
				'dialog'
			), 'skins' );
			
			// Load language files
			$this->loadLanguages();
		}
		/**
         * Get the relative base directory variable.
         * @return string base dir
         */
		function getBase(){
			return $this->_base;
		}
		/**
         * Get the base directory.
         * @return string base dir
         */
        function getBaseDir(){
			return Utils::makePath( JPATH_ROOT, $this->_base );
        }
        /**
         * Get the full base url
         * @return string base url
         */
        function getBaseURL(){
			return Utils::makePath( $this->_site_url, $this->_base );
        }
		/**
		 * Return the full user directory path. Create if required
		 *
		 * @param string	The base path
		 * @access public
		 * @return Full path to folder
		*/
		function getRootDir(){
			jimport('joomla.filesystem.folder');
			
			// Get base directory as shared parameter
			$base = $this->getSharedParam( 'dir' );
			
			// Remove first leading slash
			if( substr( $base, 0, 1 ) == '/' ){
				$base = substr( $base, 1 );
			}			
			// Force default directory if base param starts with a variable, eg $id or a slash and variable, eg: /$id
			if( preg_match( '/(\$|\/\$|\.|\/\.)/', substr( $base, 0, 2 ) ) ){
				$base = 'images/stories';
			}			
			// Super Administrators not affected
			if( $this->isSuperAdmin() ){
				// Get the root folder before dynamic variables for Super Admin
				$parts 	= explode( '$', $base );
				$base	= $parts[0];
			}else{
				// Replace any path variables
				$base = preg_replace( array( '/\$id/', '/\$username/', '/\$usertype/', '/\$group/' ), array( $this->_id, $this->_username, $this->_usertype, strtolower( $this->_group->name ) ), $base );
			}
			
			$full = Utils::makePath( JPATH_SITE, $base );
			if( !JFolder::exists( $full ) ){
				$this->folderCreate( $full );
			}
			$base = JFolder::exists( $full ) ? $base : 'images/stories';
			
			// Fallback value
			if( !$base ){
				$base = 'images/stories';
			}
			
			return ( substr( $base, 0, 1) == '/' ) ? substr( $base, 1 ) : $base;
		}
		/**
		 * Return a list of allowed file extensions
		 *
		 * @access public
		 * @return extension list
		*/
		function getFileTypes(){
			if( !isset( $this->_filetypes ) ){
				$this->_filetypes = $this->_plugin->params->get( 'filetypes', 'jpg,jpeg,gif,png' );
			}
			return strtolower ( $this->_filetypes );
		}
		/**
		 * Set a list of allowed file extensions
		 *
		 * @param Array / String Estension list
		 * @access public
		 * @return extension list
		*/
		function setFileTypes( $types ){
			if( is_array( $types ) ){
				$types = implode( ',', $types );
			}
			$this->_filetypes = strtolower( $types );
		}
		/**
		 * Get the maximum upload size
		 *
		 * @access public
		 * @return upload size
		*/
		function getUploadSize(){
			return $this->getSharedParam( 'max_size', '1024' );
		}
		/**
		 * Get the upload method
		 *
		 * @access public
		 * @return upload method
		*/
		function getUploadMethod(){
			return $this->_params->get( 'upload', 'flash' );
		}
		function returnResult(){
			return $this->_result;
		}
		function addAlert( $class='info', $title='', $text='' ){
			$this->_alerts[] = array(
				'class' => $class,
				'title'	=> $title,
				'text'	=> $text
			);
		}
		function getAlerts(){
			return $this->json_encode( $this->_alerts );
		}
		/**
         * Simulate javascript escape function, ie: escape all but /?@*+
         * @return escaped string
        */
		function jsEscape( $string ){
			// Already escaped? Avoid double escaping
			if( preg_match( '/%([0-9A-Z]+)/', $string ) ){
				return $string;
			}
			return preg_replace( 
				array( '/%2F/', '/%3F/', '/%40/', '/%2A/', '/%2B/' ), 
				array( '/', '?', '@', '*', '+' ), 
			rawurlencode( $string ) );
		}
        function getFiles( $relative, $filter='.' ){
			jimport('joomla.filesystem.folder');
			$path = Utils::makePath( $this->getBaseDir(), $relative );
            $list = JFolder::files( $path, $filter );
            if( !empty( $list ) ){
                for ($i = 0; $i < count( $list ); $i++) {
                    $file = $list[$i];
                    $files[] = array(
						'url' 		=> Utils::makePath( $relative, $file ),
						'name' 		=> $file
                    );
                }
                return $files;
            }else{
                return $list;
            }
        }
        function getFolders( $relative ){
			jimport('joomla.filesystem.folder');
			$path = Utils::makePath( $this->getBaseDir(), $relative );
            $list = JFolder::folders( $path );
            if( !empty( $list ) ){
                for ($i = 0; $i < count( $list ); $i++) {
                    $folder = $list[$i];
                    $folders[] = array(
                        'url' 	=> Utils::makePath( $relative, $folder ),
						'name' 	=> $folder
                    );
                }
                return $folders;
            }else{
                return $list;
            }
        }
		function getTreeItem( $dir ){
			$folders 	= $this->getFolders( rawurldecode( $dir ) );
			$array 		= array();
			foreach( $folders as $folder ){
				$array[] = array(
					'url'		=>	$folder['url'],
					'name'		=>	$folder['name']
				);
			}
			$result[] = array( 
				'folders'	=>	$array
			);
			return $result;
		}
		function getTree( $dir ){
			$result = $this->getTreeItems( $dir );
			return $result;
		}
		function getTreeItems( $dir, $root=true, $init=true ){									
			$result = '';			
			if( $init ){
				$this->treedir = $dir;
				if( $root ){
					$result = '<ul><li id="/"><div class="open"></div><span class="open"><a href="javascript:;">'. JText::_('Root') .'</a></span>';
					$dir = '/';
				}
			}
			$folders = $this->getFolders( $dir );
			if( $folders ){
				$result .= '<ul>'; 
				foreach( $folders as $folder ) {
					$result .= '<li id="'. $this->jsEscape( $folder['url'] ) .'"><div></div><span><a href="javascript:;">'. $folder['name'] .'</a></span>';
					if( strpos( $this->treedir, $folder['url'] ) !== false ){
						if( $h = $this->getTreeItems( $folder['url'], false ) ){
							$result .= $h;
						}
					}
					$result .= '</li>';
				}
				$result .= '</ul>';
			}
			if( $init && $root ){
				$result .= '</li></ul>';
			}
			$init = false;
			return $result;
		}
		function getFolderDetails( $dir ){
			jimport('joomla.filesystem.folder');
			clearstatcache();
			
			$path 	= Utils::makePath( $this->getBaseDir(), rawurldecode( $dir ) );			
			$date 	= Utils::formatDate( @filemtime( $path ) );
			
			$folders 	= count( JFolder::folders( $path ) );
			$files 		= count( JFolder::files( $path, '\.(' . str_replace( ',', '|', $this->getFileTypes() ) . ')$' ) );
			
			$h = array(
				'modified'	=>	$date,
				'contents'	=>	$folders. ' ' .JText::_('folders'). ', ' .$files. ' ' .JText::_('files')
			);
			return $h;
		}
		function getStdActions(){			
			$this->addAction( 'help', '', '', JText::_('Help') );
			if( $this->checkAccess('upload') ){
				$this->addAction( 'upload', '', '', JText::_('Upload') );
				$this->setXHR( array( &$this, 'uploadFiles' ) );
			}
			if( $this->checkAccess('folder_new') ){
				$this->addAction( 'folder_new', '', '', JText::_('New Folder') );
				$this->setXHR( array( &$this, 'folderNew' ) );
			}
		}
		function addAction( $name, $icon, $action, $title ){
			$this->_actions[$name] = array(
				'name'		=>  $name,
				'icon'		=>	$icon,
				'action'	=>	$action,
				'title'		=>	$title
			);
		}
		function getActions(){
			return $this->json_encode( $this->_actions );
		}
		function removeAction( $name ){
			if( array_key_exists( $this->_actions[$name] ) ){
				unset( $this->_actions[$name] );
			}
		}
		function getStdButtons(){
			if( $this->checkAccess('folder_delete') ){
				$this->addButton( 'folder', 'delete', '', '', JText::_('Delete Folder') );
				
				$this->setXHR( array( &$this, 'folderDelete' ) );
			}
			if( $this->checkAccess('folder_rename') ){
				$this->addButton( 'folder', 'rename', '', '', JText::_('Rename Folder') );
				
				$this->setXHR( array( &$this, 'folderRename' ) );
			}
			if( $this->checkAccess('file_rename') ){
				$this->addButton( 'file', 'rename', '', '', JText::_('Rename File') );
				
				$this->setXHR( array( &$this, 'fileRename' ) );
			}
			if( $this->checkAccess('file_delete') ){
				$this->addButton( 'file', 'delete', '', '', JText::_('Delete Files'), true );
				
				$this->setXHR( array( &$this, 'fileDelete' ) );
			}
			if( $this->checkAccess('file_move') ){
				$this->addButton( 'file', 'copy', '', '', JText::_('Copy Files'), true );
				$this->addButton( 'file', 'cut', '', '', JText::_('Cut Files'), true );
				
				$this->addButton( 'file', 'paste', '', '', JText::_('Paste Files'), true, true );
				
				$this->setXHR( array( &$this, 'fileCopy' ) );
				$this->setXHR( array( &$this, 'fileMove' ) );
			}
			$this->addButton( 'file', 'view', '', '', JText::_('View File') );
		}
		function addButton( $type='file', $name, $icon='', $action='', $title, $multiple=false, $trigger=false ){
			$this->_buttons[$type][$name] = array(
				'name'		=>	$name,
				'icon'		=>	$icon,
				'action'	=>	$action,
				'title'		=>	$title,
				'multiple'	=> 	$multiple,
				'trigger'	=>	$trigger
			);
		}
		function getButtons(){
			return $this->json_encode( $this->_buttons );
		}
		function removeButton( $type, $name ){
			if( array_key_exists( $name, $this->_buttons[$type] ) ){
				unset( $this->_buttons[$type][$name] );
			}
		}
		function changeButton( $type, $name, $keys ){			
			foreach( $keys as $key => $value ){
				if( isset( $this->_buttons[$type][$name][$key] ) ){
					$this->_buttons[$type][$name][$key] = $value;
				}
			}
		}
		function addEvent( $name, $function ){
			$this->_events[$name] = $function;
		}
		function fireEvent( $name, $args=null ){
			if( array_key_exists( $name, $this->_events ) ){
				return call_user_func_array( array( &$this, $this->_events[$name] ), $args );
			}
			return $this->_result;
		}
		function getItems( $relative, $args ){			
			$files 		= Manager::getFiles( $relative, '\.(?i)(' . str_replace( ',', '|', $this->getFileTypes() ) . ')$' );
			$folders 	= Manager::getFolders( $relative );
			
			$folderArray 	= array();
			$fileArray 		= array();
			if( $folders ){
				foreach( $folders as $folder ){
					$classes 	= array();
					$classes[] 	= is_writable( Utils::makePath( $this->getBaseDir(), $folder['url'] ) ) ? 'writable' : 'unwritable';
					$classes[] 	= preg_match( '/[^a-z0-9\.\_\-]/i', $folder['name'] ) ? 'notsafe' : 'safe';
					
					$folderArray[] = array(
						'name'		=>	$folder['name'],
						'url'		=>	$folder['url'],
						'classes'	=>	implode( ' ', $classes )
					);
				}
			}
			if( $files ){
				foreach( $files as $file ){
					$classes 	= array();
					$classes[] 	= is_writable( Utils::makePath( $this->getBaseDir(), $file['url'] ) ) ? 'writable' : 'unwritable';
					$classes[] 	= preg_match( '/[^a-z0-9\.\_\-]/i', $file['name'] ) ? 'notsafe' : 'safe';
					
					$fileArray[] = array(
						'name'		=>	$file['name'],
						'url'		=>	$file['url'],
						'classes'	=>	implode( ' ', $classes )
					);
				}
			}
			$result = array( 
				'folders'	=>	$folderArray,
				'files'		=>	$fileArray
			);
			$this->fireEvent( 'onGetItems', array( &$result, $args ) );
			return $result;
		}
		function getFileIcon( $ext ){
			if( JFile::exists( JCE_LIBRARIES . '/img/icons/' . $ext . '.gif' )){
				return $this->image( 'libraries.icons/' . $ext . '.gif' );
			}elseif( JFile::exists( $this->getPluginPath() . '/img/icons/' . $ext . '.gif' )){
				return $this->image( 'plugins.icons/' . $ext . '.gif' );
			}else{
				return $this->image( 'libraries.icons/def.gif' );
			}
		}
		function loadBrowser(){
			$session =& JFactory::getSession();
			
			jimport('joomla.application.component.view');
			$browser = new JView( $config = array(
				'base_path' 	=> JCE_LIBRARIES,
				'layout' 		=> 'browser'
			) );
			$browser->assignRef( 'session', $session );
			$browser->assign( 'action', $this->getUploadAction() );
			$browser->display();
		}
		// Legacy to be removed at stable
		function getEditorOption( $key ){
			switch( $key ){
				case 'upload':
					$key 		= 'editor_upload_method';
					$default 	= 'flash';
					break;
				case 'tree':
					$key 		= 'editor_folder_tree';
					$default 	= '1';
					break;
			}
			return $this->getEditorParam( $key, $default='' );
		}
		function uploadFiles(){
			$file = JRequest::getVar( 'Filedata', '', 'files', 'array' );
			
			$dir		= JRequest::getVar( 'upload-dir', '' );
			$overwrite 	= JRequest::getVar( 'upload-overwrite', '0' );	
			$name		= JRequest::getVar( 'upload-name' );
			$method		= JRequest::getVar( 'upload-method', 'swf' );

			$this->_result = array(
				'error' => true,
				'text'	=> ''
			);
			
			if( isset( $file['name'] ) ){
				jimport('joomla.filesystem.file' );
				
				$max_size 	= intval( $this->getUploadSize( 'max_size' ) )*1024;
				
				$allowable 	= explode( ',', $this->getFileTypes() );
				$extension  = strtolower( JFile::getExt( $file['name'] ) );
				
				if( !$name ){
					$name = JFile::stripExt( $file['name'] );
				}				
				if( $file['size'] > $max_size ){
					if( $method == 'html' ){
						$this->_result['text'] = JText::_('Upload Size Error');
					}else{
						header('HTTP/1.0 400 File size exceeds maximum size');
						die(JText::_('Upload Size Error'));
					}
				}elseif( !in_array( $extension, $allowable ) ){
					if( $method == 'html' ){
						$this->_result['text'] = JText::_('Upload Extension Error');
					}else{
						header('HTTP/1.0 415 Unsupported Media Type');
						die( JText::_('Upload Extension Error') );
					}
				}else{
					$path = Utils::makePath( $this->getBaseDir(), rawurldecode( $dir ) );
					$dest = Utils::makePath( $path, Utils::makeSafe( $name . '.' . $extension ) );
					
					if( !$overwrite ){
            			while( JFile::exists( $dest ) ){
                			$name .= '_copy';
							$dest = Utils::makePath( $path, Utils::makeSafe( $name . '.' . $extension ) );
            			}
        			}
					
					if( !JFile::upload( $file['tmp_name'], $dest ) ){
						if( $method == 'html' ){
							$this->_result['text'] = JText::_('Upload Error');
						}else{
							header('HTTP/1.0 400 Bad Request');
							die(JText::_('Upload Error'));
						}
					}else{
						if( !JFile::exists( $dest ) ){
							if( $method == 'html' ){
								$this->_result['text'] = JText::_('Upload Error');
							}else{
								header('HTTP/1.0 400 Bad Request');
								die(JText::_('Upload Error'));
							}
						}else{
							if( $method == 'html' ){
								$this->_result['text'] 	= basename( $dest );
								$this->_result['error'] = false;
							}
							$this->_result = $this->fireEvent('onUpload', array( $dest ) );
						}
					}
				}
			}
			die( $this->json_encode( $this->_result ) );
        }
        /**
         * Delete the relative file(s).
         * @param $files the relative path to the file name or comma seperated list of multiple paths.
         * @return string $error on failure.
         */
        function fileDelete( $files ){
			jimport('joomla.filesystem.file');
			$files = explode( ",", rawurldecode( $files ) );
            foreach( $files as $file ){
                $path = Utils::makePath( $this->getBaseDir(), rawurldecode( $file ) );
                if( JFile::exists( $path ) ){
                    if( @!JFile::delete( $path ) ){
						$this->_result['error'] = JText::_('Delete File Error');
					}else{
						$this->_result = $this->fireEvent('onFileDelete', array( rawurldecode( $file ) ) );
					}
				}
            }
			return $this->returnResult();
        }
        /**
	     * Delete a folder
         * @param string $relative The relative path of the folder to delete
	     * @return string $error on failure
	     */
        function folderDelete( $relative ){
            jimport('joomla.filesystem.folder');
			$folder = Utils::makePath( $this->getBaseDir(), rawurldecode( $relative ) );
            if( Utils::countFiles( $folder, '^[(index.html)]' ) != 0 || Utils::countDirs( $folder ) != 0 ){
                $error = JText::_('Folder Not Empty');
            }else{
                if( @!JFolder::delete( $folder ) ){
                    $this->_result['error'] = JText::_('Delete Folder Error');
                }else{
					$this->_result = $this->fireEvent('onFolderDelete');
				}
            }
            return $this->returnResult();
        }
        /*
        * Rename a file.
        * @param string $src The relative path of the source file
        * @param string $dest The name of the new file
        * @return string $error
        */
        function fileRename( $src, $dest ){			            
			jimport('joomla.filesystem.file');
			$src = Utils::makePath( $this->getBaseDir(), rawurldecode( $src ) );

            $dir = dirname( $src );
            $ext = JFile::getExt( $src );

            $dest = Utils::makePath( $dir, $dest.'.'.$ext );
            if( !JFile::move( $src, $dest ) ){
				$this->_result['error'] = JText::_('Rename File Error');
			}else{
				$this->_result = $this->fireEvent('onFileRename');
			}
            return $this->returnResult();
        }
        /*
        * Rename a folder.
        * @param string $src The relative path of the source file
        * @param string $dest The name of the new folder
        * @return array $error
        */
        function folderRename( $src, $dest ){
            jimport('joomla.filesystem.folder');
			$src = Utils::makePath( $this->getBaseDir(), rawurldecode( $src ) );

            $dir = dirname( $src );

            $dest = Utils::makePath( $dir, $dest );
            if( !JFolder::move( $src, $dest ) ){
				$this->_result['error'] = JText::_('Rename Folder Error');
			}else{
				$this->_result = $this->fireEvent('onFolderRename');
			}
			return $this->returnResult(); 
        }
        /*
        * Copy a file.
        * @param string $files The relative file or comma seperated list of files
        * @param string $dest The relative path of the destination dir
        * @return string $error on failure
        */
        function fileCopy( $files, $dest ){			
            jimport('joomla.filesystem.file');
			$files = explode( ",", rawurldecode( $files ) );
            foreach( $files as $file ){
                $filesrc 	= Utils::makePath( $this->getBaseDir(), $file );
                $filedest 	= Utils::makePath( $this->getBaseDir(), Utils::makePath( $dest, basename( $file ) ) );
				
				if( !JFile::copy( $filesrc, $filedest ) ){
					$this->_result['error'] = JText::_('Copy File Error');
				}else{
					$this->_result = $this->fireEvent('onFileCopy');
				}
            }
            return $this->returnResult();
        }
        /*
        * Copy a file.
        * @param string $files The relative file or comma seperated list of files
        * @param string $dest The relative path of the destination dir
        * @return string $error on failure
        */
        function fileMove( $files, $dest ){			
			jimport('joomla.filesystem.file');
			$files = explode( ",", rawurldecode( $files ) );
            foreach( $files as $file ){
                $filesrc 	= Utils::makePath( $this->getBaseDir(), $file );
                $filedest 	= Utils::makePath( $this->getBaseDir(), Utils::makePath( $dest, basename( $file ) ) );
				
                if( !JFile::move( $filesrc, $filedest ) ){
					$this->_result['error'] = JText::_('Move File Error');
				}else{
					$this->_result = $this->fireEvent('onFileMove');
				}
            }
            return $this->returnResult();
        }
		/**
		* New folder base function. A wrapper for the JFolder::create function
		* @param string $folder The folder to create
		* @return boolean true on success
		*/
		function folderCreate( $folder ){
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.file');
			
			if( @JFolder::create( $folder ) ){
				$html = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
				$file = $folder .DS. "index.html";
				@JFile::write( $file, $html );
			}else{
				return false;
			}
			return true;
		}
		/**
		* New folder
		* @param string $dir The base dir
		* @param string $new_dir The folder to be created
		* @return string $error on failure
		*/
		function folderNew( $dir, $new ){						
			$dir = Utils::makePath( rawurldecode( $dir ), Utils::makeSafe( $new ) );
			$dir = Utils::makePath( $this->getBaseDir(), $dir );
			if( !Manager::folderCreate( $dir ) ){
				$this->_result['error'] = JText::_('New Folder Error');
			}else{
				$this->_result = $this->fireEvent('onFolderNew');
			}
			return $this->returnResult();
		}
}
?>

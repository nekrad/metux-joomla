<?php
// no direct access
defined( '_JCE_EXT' ) or die( 'Restricted access' );
// Core function	
function joomlalinks(){
	// Joomla! file and folder processing functions
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
		
	// Base path for corelinks files
	$path = dirname( __FILE__ ) .DS. 'joomlalinks';	
	// Get all files
	$files = JFolder::files( $path, '\.(php)$' );	
	
	// For AdvLink link plugins
	if( $files ){
		foreach( $files as $file ){
			$items[] = array(
				'name'		=> JFile::stripExt( $file ),
				'path' 		=> $path,
				'file' 		=> $file
			);
		}
	}
	return $items;
}	
?>

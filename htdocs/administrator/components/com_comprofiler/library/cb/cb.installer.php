<?php
/**
* Joomla Community Builder : Plugin Handler
* @version $Id: library/cb/cb.params.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage cb.params.php
* @author various, JoomlaJoe and Beat
* @copyright (C) Beat and JoomlaJoe, www.joomlapolis.com and various
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


if (is_callable("jimport")) {
	jimport('joomla.filesystem.*');
}

/**
* Installer class
* @package Community Builder
* @subpackage Installer
* @abstract
*/
class cbInstaller {
	// name of the XML file with installation information
	var $i_installfilename	= "";
	var $i_installarchive	= "";
	var $i_installdir		= "";
	var $i_iswin			= false;
	var $i_errno			= 0;
	var $i_error			= "";
	var $i_installtype		= "";
	var $i_unpackdir		= "";
	var $i_docleanup		= true;

	/** @var string The directory where the element is to be installed */
	var $i_elementdir = '';
	/** @var string The name of the Mambo element */
	var $i_elementname = '';
	/** @var string The name of a special atttibute in a tag */
	var $i_elementspecial = '';
	/** @var object A DOMIT XML document */
	var $i_xmldocument		= null;

	var $i_hasinstallfile = null;
	var $i_installfile = null;

	/**
	* Constructor
	*/
	function cbInstaller() {
		$this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
	}
	/**
	* Uploads and unpacks a file
	* @param string The uploaded package filename or install directory
	* @param boolean True if the file is an archive file
	* @return boolean True on success, False on error
	*/
	function upload($p_filename = null, $p_unpack = true) {
		$this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
		$this->installArchive( $p_filename );

		if ($p_unpack) {
			if ($this->extractArchive()) {
				return $this->findInstallFile();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/**
	* Extracts the package archive file
	* @return boolean True on success, False on error
	*/
	function extractArchive() {
		global $mainframe;

		$base_Dir = mosPathName( $mainframe->getCfg('absolute_path') . '/media' );

		$archivename = $base_Dir . $this->installArchive();
		$tmpdir = uniqid( 'install_' );

		$extractdir = mosPathName( $base_Dir . $tmpdir );
		$archivename = mosPathName( $archivename, false );

		$this->unpackDir( $extractdir );

		if (eregi( '.zip$', $archivename )) {
			// Extract functions
			if (file_exists($mainframe->getCfg('absolute_path') . '/libraries/pcl/pclzip.php')) {
				require_once( $mainframe->getCfg('absolute_path') . '/libraries/pcl/pclzip.php' );
				require_once( $mainframe->getCfg('absolute_path') . '/libraries/pcl/pclerror.php' );
			} elseif (file_exists($mainframe->getCfg('absolute_path') . '/administrator/includes/pcl/pclzip.lib.php')) {
				require_once( $mainframe->getCfg('absolute_path') . '/administrator/includes/pcl/pclzip.lib.php' );
				require_once( $mainframe->getCfg('absolute_path') . '/administrator/includes/pcl/pclerror.lib.php' );
			} else {
				$this->setError( 1, 'Unrecoverable error: Zip library missing: "'.$mainframe->getCfg('absolute_path') . '/administrator/includes/pcl/pclzip.lib.php'.'"' );
				return false;
			}
			$zipfile = new PclZip( $archivename );
			if($this->isWindows()) {
				define('OS_WINDOWS',1);
			} else {
				define('OS_WINDOWS',0);
			}

			$ret = $zipfile->extract( PCLZIP_OPT_PATH, $extractdir );
			if($ret == 0) {
				$this->setError( 1, 'Unrecoverable error "'.$zipfile->errorName(true).'"' );
				return false;
			}
		} else {
			require_once( $mainframe->getCfg('absolute_path') . '/includes/Archive/Tar.php' );
			$archive =& new Archive_Tar( $archivename );
			$archive->setErrorHandling( PEAR_ERROR_PRINT );

			if (!$archive->extractModify( $extractdir, '' )) {
				$this->setError( 1, 'Extract Error' );
				return false;
			}
		}

		$this->installDir( $extractdir );

		// Try to find the correct install dir. in case that the package have subdirs
		// Save the install dir for later cleanup
		$filesindir = mosReadDirectory( $this->installDir(), '' );

		if (count( $filesindir ) == 1) {
			if (is_dir( $extractdir . $filesindir[0] )) {
				$this->installDir( mosPathName( $extractdir . $filesindir[0] ) );
			}
		}
		return true;
	}
	/**
	* Tries to find the package XML file
	* @return boolean True on success, False on error
	*/
	function findInstallFile() {
		$found = false;
		// Search the install dir for an xml file
		$files = mosReadDirectory( $this->installDir(), '.xml$', true, false );

		if (count( $files ) > 0) {
			foreach ($files as $file) {
				$packagefile	=&	$this->isPackageFile( $this->installDir() . $file );
				if (!is_null( $packagefile ) && !$found ) {
					$this->i_xmldocument =& $packagefile;
					return true;
				}
			}
			$this->setError( 1, 'ERROR: Could not find a CB XML setup file in the package.' );
			return false;
		} else {
			$this->setError( 1, 'ERROR: Could not find an XML setup file in the package.' );
			return false;
		}
	}
	/**
	* @param string A file path
	* @return object A DOMIT XML document, or null if the file failed to parse
	*/
	function & isPackageFile( $p_file ) {
		$null		=	null;
		if ( ! file_exists( $p_file ) ) {
			return $null;
		}
		cbimport('cb.xml.simplexml');
		$xmlString	=	trim( file_get_contents( $p_file ) );

		$element	=&	new CBSimpleXMLElement( $xmlString );
		if ( count( $element->children() ) == 0 ) {
			return $null;
		}

		if ( $element->name() != 'cbinstall' ) {
			//echo "didn't find cbinstall";
			return $null;
		}
		// Set the type
		//echo "<br />element->attributes( 'type' )=".$element->attributes( 'type' );
		$this->installType( $element->attributes( 'type' ) );
		$this->installFilename( $p_file );
		return $element;
	}
	/**
	* Loads and parses the XML setup file
	* @return boolean True on success, False on error
	*/
	function readInstallFile() {

		if ($this->installFilename() == "") {
			$this->setError( 1, 'No filename specified' );
			return false;
		}

		cbimport('cb.xml.simplexml');

		if ( file_exists( $this->installFilename() ) ) {
			$xmlString = trim( file_get_contents( $this->installFilename() ) );

			$this->i_xmldocument	=&	new CBSimpleXMLElement( $xmlString );
			if ( count( $this->i_xmldocument->children() ) == 0 ) {
				return false;
			}
		}
		$main_element	=&	$this->i_xmldocument;

		// Check that it's am installation file
		if ($main_element->name() != 'cbinstall') {
			$this->setError( 1, 'File :"' . $this->installFilename() . '" is not a valid Joomla installation file' );
			return false;
		}
		//echo "<br />main_element->attributes( 'type' )=".$main_element->attributes( 'type' );
		$this->installType( $main_element->attributes( 'type' ) );
		return true;
	}
	/**
	* Abstract install method
	*/
	function install() {
		die( 'Method "install" cannot be called by class ' . strtolower(get_class( $this )) );
	}
	/**
	* Abstract uninstall method
	*/
	function uninstall() {
		die( 'Method "uninstall" cannot be called by class ' . strtolower(get_class( $this )) );
	}
	/**
	* return to method
	*/
	function returnTo( $option, $task ) {
		return "index2.php?option=$option&task=$task";
	}
	/**
	* @param string Install from directory
	* @param string The install type
	* @return boolean
	*/
	function preInstallCheck( $p_fromdir, $type='plugin' ) {

		if (!is_null($p_fromdir)) {
			$this->installDir($p_fromdir);
		}

		if (!$this->installfile()) {
			$this->findInstallFile();
		}

		if (!$this->readInstallFile()) {
			$this->setError( 1, 'Installation file not found:<br />' . $this->installDir() );
			return false;
		}
		
		//echo "<br />type=".$type." this->installType()=".$this->installType();
		if (trim($this->installType()) != trim($type)) {
			//echo "<br />failing here<br />";
			$this->setError( 1, 'XML setup file is not for a "'.$type.'".' );
			return false;
		}
		

		// In case there where an error doring reading or extracting the archive
		if ($this->errno()) {
			return false;
		}

		return true;
	}
	/**
	* @param string The tag name to parse
	* @param string An attribute to search for in a filename element
	* @param string The value of the 'special' element if found
	* @param boolean True for Administrator components
	* @return mixed Number of file or False on error
	*/
	function parseFiles( $tagName='files', $special='', $specialError='', $adminFiles=0 ) {
		global $mainframe;
		// Find files to copy
		$cbInstallXML	=&	$this->i_xmldocument;

		$files_element	=&	$cbInstallXML->getElementByPath( $tagName );
		if ( ! ( $files_element )) {
			return 0;
		}

		if (! count( $files_element->children() ) ) {
			// no files
			return 0;
		}
		$files = $files_element->children();
		$copyfiles = array();
		if (count( $files ) == 0) {
			// nothing more to do
			return 0;
		}

		if ($folder = $files_element->attributes( 'folder' )) {
			$temp = mosPathName( $this->unpackDir() . $folder );
			if ($temp == $this->installDir()) {
				// this must be only an admin component
				$installFrom = $this->installDir();
			} else {
				$installFrom = mosPathName( $this->installDir() . $folder );
			}
		} else {
			$installFrom = $this->installDir();
		}

		foreach ($files as $file) {
			if (basename( $file->data() ) != $file->data()) {
				$newdir = dirname( $file->data() );

				if ($adminFiles){
					if (!$this->mosMakePath( $this->componentAdminDir(), $newdir )) {
						$this->setError( 1, 'Failed to create directory "' . ($this->componentAdminDir()) . $newdir . '"' );
						return false;
					}
				} else {
					if (!$this->mosMakePath( $this->elementDir(), $newdir )) {
						$this->setError( 1, 'Failed to create directory "' . ($this->elementDir()) . $newdir . '"' );
						return false;
					}
				}
			}
			$copyfiles[] = $file->data();

			// check special for attribute
			if ($file->attributes( $special )) {
				$this->elementSpecial( $file->attributes( $special ) );
			}
		}

		if ($specialError) {
			if ($this->elementSpecial() == '') {
				$this->setError( 1, $specialError );
				return false;
			}
		}

		if ($tagName == 'media') {
			// media is a special tag
			$installTo = mosPathName( $mainframe->getCfg('absolute_path') . '/images/stories' );
		} else if ($adminFiles) {
			$installTo = $this->componentAdminDir();
		} else {
			$installTo = $this->elementDir();
		}
		$result = $this->copyFiles( $installFrom, $installTo, $copyfiles );

		return $result;
	}
	/**
	* @param string Source directory
	* @param string Destination directory
	* @param array array with filenames
	* @param boolean True is existing files can be replaced
	* @return boolean True on success, False on error
	*/
	function copyFiles( $p_sourcedir, $p_destdir, $p_files, $overwrite=false ) {
		if (is_array( $p_files ) && count( $p_files ) > 0) {
			foreach($p_files as $_file) {
				$filesource	= mosPathName( mosPathName( $p_sourcedir ) . $_file, false );
				$filedest	= mosPathName( mosPathName( $p_destdir ) . $_file, false );

				if (!file_exists( $filesource )) {
					$this->setError( 1, "File $filesource does not exist!" );
					return false;
				} else if (file_exists( $filedest ) && !$overwrite) {
					$this->setError( 1, "There is already a file called $filedest - Are you trying to install the same Plugin twice?" );
					return false;
				} else if ( (is_callable(array("JFile","copy")) ? !(JFile::copy($filesource, $filedest)) : !(copy($filesource,$filedest))) ) {
					$this->setError( 1, "Failed to copy file: $filesource to $filedest" );
					return false;
				} else if (!((!is_callable("mosChmod")) || is_callable(array("JFile","copy")) || mosChmod( $filedest ))) {		// mambo 4.5.1 support
					$this->setError( 1, "Failed to chmod file: $filedest" );
					return false;
				}
			}
		} else {
			return false;
		}
		return count( $p_files );
	}
	/**
	* Copies the XML setup file to the element Admin directory
	* Used by Plugin Installer
	* @return boolean True on success, False on error
	*/
	function copySetupFile( $where='admin' ) {
		if ($where == 'admin') {
			return $this->copyFiles( $this->installDir(), $this->componentAdminDir(), array( basename( $this->installFilename() ) ), true );
		} else if ($where == 'front') {
			return $this->copyFiles( $this->installDir(), $this->elementDir(), array( basename( $this->installFilename() ) ), true );
		}
		return false;
	}

	/**
	* @param int The error number
	* @param string The error message
	*/
	function setError( $p_errno, $p_error ) {
		$this->errno( $p_errno );
		$this->error( $p_error );
	}
	/**
	* @param boolean True to display both number and message
	* @param string The error message
	* @return string
	*/
	function getError($p_full = false) {
		if ($p_full) {
			return $this->errno() . " " . $this->error();
		} else {
			return $this->error();
		}
	}
	/**
	* @param string The name of the property to set/get
	* @param mixed The value of the property to set
	* @return The value of the property
	*/
	function setVar( $name, $value=null ) {
		if (!is_null( $value )) {
			$this->$name = $value;
		}
		return $this->$name;
	}

	function installFilename( $p_filename = null ) {
		if(!is_null($p_filename)) {
			if($this->isWindows()) {
				$this->i_installfilename = str_replace('/','\\',$p_filename);
			} else {
				$this->i_installfilename = str_replace('\\','/',$p_filename);
			}
		}
		return $this->i_installfilename;
	}

	function installType( $p_installtype = null ) {
		return $this->setVar( 'i_installtype', $p_installtype );
	}

	function error( $p_error = null ) {
		return $this->setVar( 'i_error', $p_error );
	}

	function installArchive( $p_filename = null ) {
		return $this->setVar( 'i_installarchive', $p_filename );
	}

	function installDir( $p_dirname = null ) {
		return $this->setVar( 'i_installdir', $p_dirname );
	}

	function unpackDir( $p_dirname = null ) {
		return $this->setVar( 'i_unpackdir', $p_dirname );
	}

	function isWindows() {
		return $this->i_iswin;
	}

	function errno( $p_errno = null ) {
		return $this->setVar( 'i_errno', $p_errno );
	}

	function hasInstallfile( $p_hasinstallfile = null ) {
		return $this->setVar( 'i_hasinstallfile', $p_hasinstallfile );
	}

	function installfile( $p_installfile = null ) {
		return $this->setVar( 'i_installfile', $p_installfile );
	}

	function elementDir( $p_dirname = null )	{
		return $this->setVar( 'i_elementdir', $p_dirname );
	}

	function elementName( $p_name = null )	{
		return $this->setVar( 'i_elementname', $p_name );
	}
	function elementSpecial( $p_name = null )	{
		return $this->setVar( 'i_elementspecial', $p_name );
	}
	/**
* @param string An existing base path
* @param string A path to create from the base path
* @param int Directory permissions
* @return boolean True if successful
*/
	function mosMakePath($base, $path='', $mode = NULL)
	{
		global $mosConfig_dirperms;

		if (is_callable("mosMakePath"))	return mosMakePath($base, $path, $mode);
		else {									
			// mambo 4.5.1 compatibility:
			// convert windows paths
			$path = str_replace( '\\', '/', $path );
			$path = str_replace( '//', '/', $path );

			// check if dir exists
			if (file_exists( $base . $path )) return true;

			// set mode
			$origmask = NULL;
			if (isset($mode)) {
				$origmask = @umask(0);
			} else {
				if ($mosConfig_dirperms=='') {
					// rely on umask
					$mode = 0777;
				} else {
					$origmask = @umask(0);
					$mode = octdec($mosConfig_dirperms);
				} // if
			} // if

			$parts = explode( '/', $path );
			$n = count( $parts );
			$ret = true;
			if ($n < 1) {
				$ret = @mkdir($base, $mode);
			} else {
				$path = $base;
				for ($i = 0; $i < $n; $i++) {
					$path .= $parts[$i] . '/';
					if (!file_exists( $path )) {
						if (!@mkdir( $path, $mode )) {
							$ret = false;
							break;
						}
					}
				}
			}
			if (isset($origmask)) @umask($origmask);
			return $ret;
		}
	}
}	// end class cbInstaller

function cleanupInstall( $userfile_name, $resultdir) {
	global $mainframe;

	if (file_exists( $resultdir )) {
		deldir( $resultdir );
		if ( $userfile_name ) {
			unlink( mosPathName( $mainframe->getCfg('absolute_path') . '/media/' . $userfile_name, false ) );
		}
	}
}

if ( ! function_exists( 'deldir' ) ) {
	function deldir( $dir ) {
		$current_dir = opendir( $dir );
		while ($entryname = readdir( $current_dir )) {
			if ($entryname != '.' and $entryname != '..') {
				if (is_dir( $dir . $entryname )) {
					deldir( mosPathName( $dir . $entryname ) );
				} else {
					unlink( $dir . $entryname );
				}
			}
		}
		closedir( $current_dir );
		return rmdir( $dir );
	}
}

class cbInstallerPlugin extends cbInstaller {
	/** @var string The element type */
	var $elementType = 'plugin';

	/**
	* Constructor
	*/
	function cbInstallerPlugin() {
		$this->cbInstaller();
	}

	/**
	* Custom install method
	* @param boolean True if installing from directory
	*/
	function install( $p_fromdir = null ) {
		global $mainframe, $_CB_database, $ueConfig;
        
		if (!$this->preInstallCheck( $p_fromdir,$this->elementType )) {
			return false;
		}

		$cbInstallXML	=&	$this->i_xmldocument;

		// Get name
		$e = &$cbInstallXML->getElementByPath( 'name' );
		$this->elementName( $e->data() );
		$cleanedElementName = strtolower(str_replace(array(" ","."),array("","_"),$this->elementName()));

		// Get plugin filename
		$files_element = &$cbInstallXML->getElementByPath( 'files' );
		if ( count ($files_element->children() ) ) {
			$files = $files_element->children();
			foreach ($files as $file) {
				if ($file->attributes( "plugin" )) {
					$this->elementSpecial( $file->attributes( "plugin" ) );
				}
			}
		}
		$fileNopathNoext = null;
		$eregmatches = array();
		if ( ereg("^.*[\\/\\\\](.*)\\..*$", $this->installFilename(), $eregmatches ) ) {
			$fileNopathNoext = $eregmatches[1];
		}
		if ( ! ( $fileNopathNoext && ( $this->elementSpecial() == $fileNopathNoext ) ) ) {
			$this->setError( 1, 'Installation filename `' . $fileNopathNoext . '` (with .xml) does not match main php file plugin attribute `'  . $this->elementSpecial() . '` in the plugin xml file<br />' );
			return false;
		}
		$cleanedMainFileName = strtolower(str_replace(array(" ","."),array("","_"),$this->elementSpecial()));

		// check version
		$v = &$cbInstallXML->getElementByPath( 'version' );
		$version = $v->data();
		if (($version == $ueConfig['version']) || ($version=="1.0 RC 2" || $version=="1.0" || $version=="1.0.1" || $version=="1.0.2")) {
			;
		} else {
      		$this->setError( 1, 'Plugin version ('.$version.') different from Community Builder version ('.$ueConfig['version'].')' );
			return false;
    	}

    	$backendMenu = "";
    	$adminmenusnode = & $cbInstallXML->getElementByPath( 'adminmenus' );
		if ( $adminmenusnode ) {
			$menusArr = array();
			//get set of menus
			$menus = $adminmenusnode->children();
			//cycle through each menu
			foreach($menus AS $menu) {
				if ( $menu->name() == "menu" ) {
					$action = $menu->attributes('action');
					$text	= getLangDefinition($menu->data());
					$menusArr[] = $text . ":" . $action;
				}
			}
			$backendMenu = implode( ",", $menusArr );
		}

		$folder = strtolower($cbInstallXML->attributes( 'group' ));
		$subFolderPrefix = (($folder=="user") ? "plug_" : "");
		$subFolder = $subFolderPrefix . $cleanedElementName;
		$this->elementDir( $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' . $folder . "/" . $subFolder . "/" );
		
		if (file_exists($this->elementDir())) {
      		$this->setError( 1, 'Another plugin is already using directory: "' . $this->elementDir() . '"' );
			return false;
    	}

		if(!file_exists($this->elementDir()) && !$this->mosMakePath($this->elementDir())) {
			$this->setError( 1, 'Failed to create directory' .' "' . $this->elementDir() . '"' );
			return false;
		}

		// Copy files from package:
		if ($this->parseFiles( 'files', 'plugin', 'No file is marked as plugin file' ) === false) {
			cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
			return false;
		}

		// Check to see if plugin already exists in db
		$_CB_database->setQuery( "SELECT id FROM #__comprofiler_plugin WHERE element = '" . $this->elementSpecial() . "' AND folder = '" . $subFolder . "'" );
		if (!$_CB_database->query()) {
			$this->setError( 1, 'SQL error' .': ' . $_CB_database->stderr( true ) );
			cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
			return false;
		}

		$pluginid 					=	$_CB_database->loadResult();

		$pluginRowWasNotExisting	=	( ! $pluginid );

		$row = new moscomprofilerPlugin( $_CB_database );
		$row->id = $pluginid;
		if (!$pluginid) {
			$row->name = $this->elementName();
			$row->ordering = 99;
		}
		$row->type = $folder;
		$row->folder = $subFolder;
		$row->backend_menu = $backendMenu;
		$row->iscore = 0;
		$row->access = 0;
		$row->client_id = 0;
		$row->element = $this->elementSpecial();

		if (!$row->store()) {
			$this->setError( 1, 'SQL error' .': ' . $row->getError() );
			cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
			return false;
		}
		if (!$pluginid) {
			$pluginid	=	$_CB_database->insertid();
		}
			
		if ( $e = &$cbInstallXML->getElementByPath( 'description' ) ) {
			$desc = $this->elementName() . '<p>' . $e->data() . '</p>';
			$this->setError( 0, $desc );
		}
		//If type equals user then check for tabs and fields
		if($folder=='user') {
			$tabsnode=&$cbInstallXML->getElementByPath( 'tabs' );
			if( $tabsnode ) {
				//get set of tabs
				$tabs=$tabsnode->children();
				//cycle through each tab
				foreach($tabs AS $tab) {
					if ($tab->name() == "tab") {
						//install each tab
						$tabid=$this->installTab($pluginid,$tab);
						//get all fields in the tab
						if ( $fieldsnode = $tab->getElementByPath( 'fields' ) ) {
							//echo $fieldsnode->toNormalizedString(true);
							if ( $fieldsnode ) {
								//echo "found fields";
								$fields=$fieldsnode->children();
								//cycle through each field
								foreach($fields AS $field) {
									if ($field->name() == "field") {
										//install each field
										//echo "installing field...";
										$fieldid=$this->installField($pluginid,$tabid,$field);
										//get all fieldvalues for the field
										$fieldValues=$field->children();
										//check to see if the node exists
										if(!is_null($fieldValues)) {
											//cycle through each fieldValue
											foreach($fieldValues AS $fieldValue) {	
												if ($fieldValue->name() == "fieldvalue") $this->installFieldValue($fieldid,$fieldValue);
													
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		// Are there any SQL queries??
		$query_element = &$cbInstallXML->getElementByPath( 'install/queries' );
		if ( $query_element ) {
			$queries = $query_element->children();
			foreach($queries as $query)
			{
				$_CB_database->setQuery( $query->data());
				if (!$_CB_database->query())
				{
					$this->setError( 1, "SQL Error " . $_CB_database->stderr( true ) );
					if ( $pluginRowWasNotExisting ) {
						$this->deleteTabAndFieldsOfPlugin( $row->id );	// delete tabs and private fields of plugin
						$row->delete();
					}
					cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
					return false;
				}
			}
		}
		
		// Is there an installfile
		$installfile_elemet = &$cbInstallXML->getElementByPath( 'installfile' );

		if ( $installfile_elemet ) {
			// check if parse files has already copied the install.component.php file (error in 3rd party xml's!)
			if (!file_exists($this->elementDir().$installfile_elemet->data())) {
				if(!$this->copyFiles($this->installDir(), $this->elementDir(), array($installfile_elemet->data())))  			{
					$this->setError( 1, 'Could not copy PHP install file.' );
					if ( $pluginRowWasNotExisting ) {
						$this->deleteTabAndFieldsOfPlugin( $row->id );	// delete tabs and private fields of plugin
						$row->delete();
					}
					cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
					return false;
				}
			}
			$this->hasInstallfile(true);
			$this->installFile($installfile_elemet->data());
		}
		// Is there an uninstallfile
		$uninstallfile_elemet = &$cbInstallXML->getElementByPath( 'uninstallfile' );
		if( $uninstallfile_elemet ) {
			if (!file_exists($this->elementDir().$uninstallfile_elemet->data())) {
				if(!$this->copyFiles($this->installDir(), $this->elementDir(), array($uninstallfile_elemet->data()))) {
					$this->setError( 1, 'Could not copy PHP uninstall file' );
					if ( $pluginRowWasNotExisting ) {
						$this->deleteTabAndFieldsOfPlugin( $row->id );	// delete tabs and private fields of plugin
						$row->delete();
					}
					cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
					return false;
				}
			}
		}
		
		if ($this->hasInstallfile()) {
			if (is_file($this->elementDir() . '/' . $this->installFile())) {
				global $_PLUGINS;
				require_once($this->elementDir() . "/" . $this->installFile());
				$ret = call_user_func_array("plug_".$cleanedMainFileName."_install", array());
				if ($ret != '') {
					$this->setError( 0, $desc . $ret );
				}
			}
		}
		
		$res	=	$this->copySetupFile('front');
		if ( $res === false ) {
			if ( $pluginRowWasNotExisting ) {
				$this->deleteTabAndFieldsOfPlugin( $row->id );	// delete tabs and private fields of plugin
				$row->delete();
			}
			cleanupInstall( null, $this->elementDir() );	// try removing directory and content just created successfully
			return false;
		}
		return true;
	}
	
	
	/**
	* @param string The tag name to parse
	* @param string An attribute to search for in a filename element
	* @param string The value of the 'special' element if found
	* @param boolean True for Administrator components
	* @return mixed Number of file or False on error
	*/
	function installTab( $pluginid,$tab) {
		global $_CB_database, $acl;

		// Check to see if plugin tab already exists in db
		$_CB_database->setQuery( "SELECT tabid FROM #__comprofiler_tabs WHERE pluginid = " . (int) $pluginid . " AND pluginclass = '" . $tab->attributes('class') . "'" );
		$tabid = $_CB_database->loadResult();
		
		$row = new moscomprofilerTabs( $_CB_database );
		if (!$tabid) {
			$row->title = $tab->attributes('name');
			$row->description = $tab->attributes('description');
			$row->ordering=99;
			$row->position = $tab->attributes('position');
			$row->displaytype = $tab->attributes('displaytype');
		}
		$row->width = $tab->attributes('width');
		$row->pluginclass = $tab->attributes('class');
		$row->pluginid = $pluginid;
		$row->fields = $tab->attributes('fields');
		$row->sys = $tab->attributes('sys');

		$userGroupName							=	$tab->attributes( 'useraccessgroup' );
		switch ( $userGroupName ) {
			case 'All Registered Users':
				$row->useraccessgroupid			=	-1;
				break;
			case 'Everybody':
			default:
				if ( $userGroupName && ( $userGroupName != 'Everybody' ) ) {
					$groupId					=	$acl->get_group_id( $userGroupName, 'ARO' );
					if ( $groupId ) {
						$row->useraccessgroupid	=	$groupId;
				} else {
					$row->useraccessgroupid		=	-2;
				}
				break;
				}
		}

		if (!$row->store($tabid)) {
			$this->setError( 1, 'SQL error' .': ' . $row->getError() );
			return false;
		}

		if (!$tabid) $tabid = $_CB_database->insertid();
		return $tabid;
	}
	
	/**
	* @param string The tag name to parse
	* @param string An attribute to search for in a filename element
	* @param string The value of the 'special' element if found
	* @param boolean True for Administrator components
	* @return mixed Number of file or False on error
	*/
	function installField( $pluginid,$tabid,$field) {
		global $_CB_database;

		// Check to see if plugin tab already exists in db
		$_CB_database->setQuery( "SELECT fieldid FROM #__comprofiler_fields WHERE name = '".$field->attributes('name')."'" );
		$fieldid				=	$_CB_database->loadResult();

		$row					=	new moscomprofilerFields( $_CB_database );
		$row->name				=	$field->attributes('name');
		$row->pluginid			=	$pluginid;
		$row->tabid				=	$tabid;
		$row->type				=	$field->attributes('type');
		if (!$fieldid) {
			$row->title			=	$field->attributes('title');
			$row->description	=	$field->attributes('description');
			$row->ordering		=	99;
			$row->registration	=	$field->attributes('registration');
			$row->profile		=	$field->attributes('profile');
			$row->readonly		=	$field->attributes('readonly');
			$row->params		=	$field->attributes('params');
		}

		if (!$row->store($fieldid)) {
			$this->setError( 1, 'SQL error on field store2' .': ' . $row->getError() );
			return false;
		}
		
		if (!$fieldid) {
			$fieldid			=	$_CB_database->insertid();
		}
		return $fieldid;
	}

	function installFieldValue($fieldid,$fieldvalue) {
		global $_CB_database;		
		$row = new moscomprofilerFieldValues($_CB_database);
		$row->fieldid = $fieldid;
		$row->fieldtitle = $fieldvalue->attributes('title');
		$row->ordering = $fieldvalue->attributes('ordering');
		$row->sys = $fieldvalue->attributes('sys');
		
		$_CB_database->setQuery("SELECT fieldvalueid FROM #__comprofiler_field_values WHERE fieldid = ". (int) $fieldid . " AND fieldtitle = '".$row->fieldtitle."'");
		$fieldvalueid = $_CB_database->loadResult();
		
		if (!$row->store($fieldvalueid)) {
			$this->setError( 1, 'SQL error on field store' .': ' . $row->getError() );
			return false;
		}
		
		return true;
	}
	
	/**
	* Custom install method
	* @param int The id of the module
	* @param string The URL option
	* @param int The client id
	*/
	function uninstall( $id, $option, $client=0 ) {
		global $_CB_database, $mainframe;

		$id = intval( $id );
		$_CB_database->setQuery( "SELECT `name`, `folder`, `element`, `type`, `iscore` FROM #__comprofiler_plugin WHERE `id` = " . (int) $id );

		$row = null;
		$_CB_database->loadObject( $row );
		if ($_CB_database->getErrorNum()) {
			HTML_comprofiler::showInstallMessage( $_CB_database->stderr(), 'Uninstall -  error' ,
			$this->returnTo( $option, 'showPlugins') );
			exit();
		}
		if ($row == null) {
			HTML_comprofiler::showInstallMessage( 'Invalid object id', 'Uninstall -  error' ,
			$this->returnTo( $option, 'showPlugins') );
			exit();
		}

		if (trim( $row->folder ) == '') {
			HTML_comprofiler::showInstallMessage( 'Folder field empty, cannot remove files', 'Uninstall -  error',
			$this->returnTo( $option, 'showPlugins') );
			exit();
		}
		
		if ($row->iscore) {
			HTML_comprofiler::showInstallMessage( $row->name .' '. "is a core element, and cannot be uninstalled.<br />You need to unpublish it if you don\'t want to use it" ,
			'Uninstall -  error', $this->returnTo( $option, 'showPlugins') );
			exit();
		}

		$basepath = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' . $row->type . '/'.$row->folder.'/';
		$xmlfile = $basepath . $row->element . '.xml';

		// see if there is an xml install file, must be same name as element
		if (file_exists( $xmlfile )) {
			cbimport('cb.xml.simplexml');

			$xmlString = trim( file_get_contents( $xmlfile ) );
	
			$this->i_xmldocument	=&	new CBSimpleXMLElement( $xmlString );
			if ( count( $this->i_xmldocument->children() ) > 0 ) {
				$cbInstallXML	=&	$this->i_xmldocument;
				
				// get the element name:
				$e =& $cbInstallXML->getElementByPath( 'name' );
				$this->elementName( $e->data() );
				$cleanedElementName = strtolower(str_replace(array(" ","."),array("","_"),$this->elementName()));
				
				// get the files element
				$files_element =& $cbInstallXML->getElementByPath( 'files' );
				if ( $files_element ) {

					if ( count( $files_element->children() ) ) {
						$files = $files_element->children();
						foreach ($files as $file) {
							if ($file->attributes( "plugin" )) {
								$this->elementSpecial( $file->attributes( "plugin" ) );
							}
						}
						$cleanedMainFileName = strtolower(str_replace(array(" ","."),array("","_"),$this->elementSpecial()));
					}

					// Is there an uninstallfile
					$uninstallfile_elemet = &$cbInstallXML->getElementByPath( 'uninstallfile' );
					if ( $uninstallfile_elemet ) {
						if (is_file($basepath . $uninstallfile_elemet->data())) {
							global $_PLUGINS;
							require_once($basepath . $uninstallfile_elemet->data());
							$ret = call_user_func_array("plug_".$cleanedMainFileName."_uninstall", array());

							if ($ret != '') {
								$this->setError( 0, $ret );
							}
						}
					}

					
					$files = $files_element->children();
					foreach ($files as $file) {
						// delete the files
						$filename = $file->data();
						if (file_exists( $basepath . $filename )) {
							$parts = pathinfo( $filename );
							$subpath = $parts['dirname'];
							if ($subpath <> '' && $subpath <> '.' && $subpath <> '..') {
								//echo '<br />'. 'Deleting'  .': '. $basepath . $subpath;
								if (is_callable(array("JFolder","delete"))) {
									$result = JFolder::delete(mosPathName( $basepath . $subpath . '/' ));
								} else {
									$result = deldir(mosPathName( $basepath . $subpath . '/' ));
								}
							} else {
								//echo '<br />'. 'Deleting'  .': '. $basepath . $filename;
								if (is_callable(array("JFile","delete"))) {
									$result = JFile::delete( mosPathName ($basepath . $filename, false));
								} else {
									$result = unlink( mosPathName ($basepath . $filename, false));
								}
							}
							//echo intval( $result );
						}
					}
					
					// Are there any SQL queries??
					$query_element = &$cbInstallXML->getElementByPath( 'uninstall/queries' );
					if ( $query_element ) {
						$queries = $query_element->children();
						foreach($queries as $query)
						{
							$_CB_database->setQuery( $query->data());
							if (!$_CB_database->query())
							{
								$this->setError( 1, "SQL Error " . $_CB_database->stderr( true ) );
								return false;
							}
						}
					}

					// Delete tabs and private fields of plugin:
					$this->deleteTabAndFieldsOfPlugin( $id );

					// remove XML file from front
					if (is_callable(array("JFile","delete"))) {
						$result = JFile::delete(mosPathName ($xmlfile, false ));
					} else {
						@unlink(  mosPathName ($xmlfile, false ) );
					}

					// define folders that should not be removed
					$sysFolders = array(
					'content',
					'search'
					);
					if (!in_array( $row->folder, $sysFolders )) {
						// delete the non-system folders if empty
						if (count( mosReadDirectory( $basepath ) ) < 1) {
							if (is_callable(array("JFolder","delete"))) {
								$result = JFolder::delete( $basepath );
							} else {
								deldir( $basepath );
							}
						}
					}
				}
			}
		}



		$_CB_database->setQuery( "DELETE FROM #__comprofiler_plugin WHERE id = " . (int) $id );
		if (!$_CB_database->query()) {
			$msg = $_CB_database->stderr;
			die( $msg );
		}
		return true;
	}
	/**
	 * Deletes tabs and private fields of plugin id
	 *
	 * @param int $id   id of plugin
	 */
	function deleteTabAndFieldsOfPlugin( $id ) {
		global $_CB_database;

		//Find all tabs related to this plugin
		$_CB_database->setQuery( "SELECT `tabid`, `fields` FROM #__comprofiler_tabs WHERE pluginid=" . (int) $id );
		$tabs				=	$_CB_database->loadObjectList();
		if ( count( $tabs ) > 0 ) {
			$rowTab			=	new moscomprofilerTabs( $_CB_database );
			foreach( $tabs AS $tab ) {
				//Find all fields related to the tab
				$_CB_database->setQuery( "SELECT `fieldid`, `name` FROM #__comprofiler_fields WHERE `tabid`=" . (int) $tab->tabid . " AND `pluginid`=" . (int) $id );
				$fields		=	$_CB_database->loadObjectList();
				$rowField	=	new moscomprofilerFields( $_CB_database );
				
				//Delete fields and fieldValues, but not data content itself in the comprofilier table so they stay on reinstall
				if ( count( $fields ) > 0 ) {
					//delete each field related to a tab and all field value related to a field, but not the content
					foreach( $fields AS $field ) {
						//Now delete the field itself without deleting the user data, preserving it for reinstall
						//$rowField->deleteColumn('#__comprofiler',$field->name);	// this would delete the user data
						$rowField->delete( $field->fieldid );
					}
				}
				$fcount		=	0;
				if( $tab->fields ) {
					$_CB_database->setQuery( "SELECT COUNT(*) FROM #__comprofiler_fields WHERE tabid=" . (int) $tab->tabid );
					$fcount	=	$_CB_database->loadResult();
					if( $fcount > 0 ) {
						$_CB_database->setQuery( "UPDATE #__comprofiler_tabs SET `pluginclass`=null, `pluginid`=null WHERE `tabid`=" . (int) $tab->tabid );
						$_CB_database->query();
					} else {
						//delete each tab
						$rowTab->delete( $tab->tabid );
					}
				} else {
					//delete each tab
					$rowTab->delete( $tab->tabid );
				}
			}	
		}
	}

}

?>

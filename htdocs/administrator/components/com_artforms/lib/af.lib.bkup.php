<?php
/**
* @version $Id: af.lib.bkup.php v.2.1b7 2007-12-09 04:52:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @original name code from MOSTlyDB Admin
* @original author Mambo Foundation Inc
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

global $my, $mainframe;

// Make sure the user is authorized to view this page
$user = & JFactory::getUser();
if ($user->gid!=25) {
	$mainframe->redirect( 'index.php?option=com_artforms&task=update', JText::_('ALERTNOTAUTH') );
}

afLoadLib( 'bkuphtml' );
require_once( JPATH_ADMINISTRATOR.DS.'includes'.DS.'pcl'.DS.'pclzip.lib.php' );
require_once( AFPATH_SITE.'version.php' );

function dbBackup( $p_option ) {
	global $mosConfig_dbprefix;
        $db =& JFactory::getDBO();
        
	$db->setQuery( "SHOW tables FROM #__artforms, #__artforms_inbox, #__artforms_items" );
	$tables = $db->loadResultArray();
	$tables[] = JHTML::_('select.option', $mosConfig_dbprefix.'artforms' );
        $tables[] = JHTML::_('select.option', $mosConfig_dbprefix.'artforms_inbox' );
        $tables[] = JHTML::_('select.option', $mosConfig_dbprefix.'artforms_items' );
	$tablelist = JHTML::_('select.genericlist', $tables, 'tables[]', 'class="inputbox" size="3" id="tables" multiple="multiple"',
	'value', 'text', '' );

	HTML_dbadmin::backupIntro( $tablelist, $p_option );
}

function doBackup( $tables, $OutType, $OutDest, $toBackUp, $UserAgent, $local_backup_path) {
	global $mosConfig_dbprefix, $mosConfig_absolute_path, $mosConfig_live_site;
	global $mosConfig_db, $mosConfig_sitename, $version,$option,$task;
        $db =& JFactory::getDBO();
        jimport('joomla.user.helper');
        
	if (!$tables[0])
	{
		HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_NODBSELECTED' ), '0' );
		return;
	}

	/* Need to know what browser the user has to accomodate nonstandard headers */

	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $UserAgent)) {
		$UserBrowser = "Opera";
	}
	elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $UserAgent)) {
		$UserBrowser = "IE";
	} else {
		$UserBrowser = '';
	}

	/* Determine the mime type and file extension for the output file */

	if ($OutType == "bzip") {
		$filename = "ArtForms_BackUp_" . $mosConfig_db . "_" . date("Y_j_m_H_i_s") . "_" . JUserHelper::genRandomPassword('5') . ".bz2";
		$mime_type = 'application/x-bzip';
	} elseif ($OutType == "gzip") {
		$filename = "ArtForms_BackUp_" . $mosConfig_db . "_" . date("Y_j_m_H_i_s") . "_" . JUserHelper::genRandomPassword('5') . ".sql.gz";
		$mime_type = 'application/x-gzip';
	} elseif ($OutType == "zip") {
		$filename = "ArtForms_BackUp_" . $mosConfig_db . "_" . date("Y_j_m_H_i_s") . "_" . JUserHelper::genRandomPassword('5') . ".zip";
		$mime_type = 'application/x-zip';
	} elseif ($OutType == "html") {
		$filename = "ArtForms_BackUp_" . $mosConfig_db . "_" . date("Y_j_m_H_i_s") . "_" . JUserHelper::genRandomPassword('5') . ".html";
		$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
	} else {
		$filename = "ArtForms_BackUp_" . $mosConfig_db . "_" . date("Y_j_m_H_i_s") . "_" . JUserHelper::genRandomPassword('5') . ".sql";
		$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
	};

	/* Store the "Create Tables" SQL in variable $CreateTable[$tblval] */
	if ($toBackUp!="data")
	{
		foreach ($tables as $tblval)
		{
			$db->setQuery("SHOW CREATE table $tblval");
			$db->query();
			$CreateTable[$tblval] = $db->loadResultArray(1);
		}
	}

	/* Store all the FIELD TYPES being backed-up (text fields need to be delimited) in variable $FieldType*/
	if ($toBackUp!="structure")
	{
		foreach ($tables as $tblval)
		{
			$db->setQuery("SHOW FIELDS FROM $tblval");
			$db->query();
			$fields = $db->loadObjectList();
			foreach($fields as $field)
			{
				$FieldType[$tblval][$field->Field] = preg_replace("/[(0-9)]/",'', $field->Type);
			}
		}
	}

	/* Build the fancy header on the dump file */
	$OutBuffer = "";
	if ($OutType == 'html') {
	} else {
		$OutBuffer .= "#\n";
		$OutBuffer .= "# ArtForms MySQL-Dump\n";
		$OutBuffer .= "# ArtForms Version: ".afVersion()."\n";
		$OutBuffer .= "# http://jartforms.interjoomla.com.ar/\n";
		$OutBuffer .= "#\n";
		$OutBuffer .= "# Host: $mosConfig_live_site\n";
		$OutBuffer .= "# Web Site Name: $mosConfig_sitename\n";
		$OutBuffer .= "# Generation Time: " . date("M j, Y \a\\t H:i") . "\n";
		$OutBuffer .= "# Server version: " . $db->getVersion() . "\n";
		$OutBuffer .= "# PHP Version: " . phpversion() . "\n";
		$OutBuffer .= "# Database : `" . $mosConfig_db . "`\n# --------------------------------------------------------\n";
	}

	/* Okay, here's the meat & potatoes */
	foreach ($tables as $tblval) {
		if ($toBackUp != "data") {
			if ($OutType == 'html') {
			} else {
				$OutBuffer .= "#\n# Table structure for table `$tblval`\n";
				$OutBuffer .= "#\nDROP table IF EXISTS $tblval;\n";
				$OutBuffer .= $CreateTable[$tblval][0].";\r\n";
			}
		}
		if ($toBackUp != "structure") {
			if ($OutType == 'html') {
				$OutBuffer .= "<div align=\"left\">";
				$OutBuffer .= "<table cellspacing=\"0\" cellpadding=\"2\" style=\"border:1px solid #777;\">";
				$db->setQuery("SELECT * FROM $tblval");
				$rows = $db->loadObjectList();

				$OutBuffer .= "<tr><th colspan=\"".count( @array_keys( @$rows[0] ) )."\" style=\"border:1px solid #777;\">`$tblval`</th></tr>";
				if (count( $rows )) {
					$OutBuffer .= "<tr>";
					foreach($rows[0] as $key => $value) {
						$OutBuffer .= "<th style=\"border:1px solid #777;\">$key</th>";
					}
					$OutBuffer .= "</tr>";
				}

				if ($rows) foreach($rows as $row)
				{
					$OutBuffer .= "<tr>";
					foreach (get_object_vars($row) as $key=>$value)
					{
						$value = addslashes( $value );
						$value = str_replace( "\n", '\r\n', $value );
						$value = str_replace( "\r", '', $value );

						$value = htmlspecialchars( $value );

						if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET"))
						{
							$OutBuffer .= "<td style=\"border:1px solid #777;\">'$value'</td>";
						}
						else
						{
							$OutBuffer .= "<td style=\"border:1px solid #777;\">$value</td>";
						}
					}
					$OutBuffer .= "</tr>";
				}
				$OutBuffer .= "</table></div><br />";
			} else {
				$OutBuffer .= "#\n# Dumping data for table `$tblval`\n#\n";
				$db->setQuery("SELECT * FROM $tblval");
				$rows = $db->loadObjectList(); if (!$rows) $rows = array();
				foreach($rows as $row)
				{
					$InsertDump = "INSERT INTO $tblval VALUES (";
					//$arr = mosObjectToArray($row);
					//foreach($arr as $key => $value)
					foreach (get_object_vars($row) as $key=>$value)
					{
						$value = addslashes( $value );
						$value = str_replace( "\n", '\r\n', $value );
						$value = str_replace( "\r", '', $value );
						if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET"))
						{
							$InsertDump .= "'$value',";
						}
						else
						{
							$InsertDump .= "$value,";
						}
					}
					$OutBuffer .= rtrim($InsertDump,',') . ");\n";
				}
			}
		}
	}

	/* Send the HTML headers */
	if ($OutDest == "remote") {
		// dump anything in the buffer
		@ob_end_clean();
		ob_start();
		header('Content-Type: ' . $mime_type);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

		if ($UserBrowser == 'IE') {
			header('Content-Disposition: inline; filename="' . $filename . '"');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} else {
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Pragma: no-cache');
		}
	}

	if ($OutDest == "screen" || $OutType == "html" ) {
		if ($OutType == "html") {
                        afLoadSectionTitle( JText::_( 'ARTF_BKUP_DBBACKUP' ), 'backup', 1, 'images/' );
                        echo '<div style="width:577px;height:297px;overflow:scroll;border:1px solid #ddd;">'.$OutBuffer.'</div><br /><br />';
		} elseif ($OutDest == "screen") {
			$OutBuffer = str_replace("<","&lt;",$OutBuffer);
			$OutBuffer = str_replace(">","&gt;",$OutBuffer);
                        afLoadSectionTitle( JText::_( 'ARTF_BKUP_DBBACKUP' ), 'backup', 1, 'images/' );
                        ?>
			<form>
				<textarea rows="20" cols="80" name="sqldump"  style="background-color:#e0e0e0;"><?php echo $OutBuffer;?></textarea>
				<br />
				<input type="button" onclick="javascript:this.form.sqldump.focus();this.form.sqldump.select();" class="button" value="<?php echo JText::_( 'ARTF_MULTI_SELECTALL' );?>" /><br /><br />
			</form>
			<?php
		}
	}

        if ($OutDest != "screen") {
	switch ($OutType) {
		case "sql" :
			if ($OutDest == "local") {
				$fp = fopen($local_backup_path.$filename, "w");
				if (!$fp) {
					HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILENOTWRITABLE' ),$filename), '0' );
					return;
				} else {
					fwrite($fp, $OutBuffer);
					fclose($fp);
					HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_BKUPSUCCSAVEDDIR' ),$local_backup_path,$filename), '1' );
					return;
				}
			} else {
				echo $OutBuffer;
				ob_end_flush();
				ob_start();
				// do no more
				exit();
			}
			break;
		case "bzip" :
			if (function_exists('bzcompress')) {
				if ($OutDest == "local") {
					$fp = fopen($local_backup_path.$filename, "wb");
					if (!$fp) {
						HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILENOTWRITABLE' ),$filename),'0' );
					} else {
						fwrite($fp, bzcompress($OutBuffer));
						fclose($fp);
						HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_BKUPSUCCSAVEDDIR' ),$filename),'1' );
						return;
					}
				} else {
					echo bzcompress($OutBuffer);
					ob_end_flush();
					ob_start();
					// do no more
					exit();
				}
			} else {
				echo $OutBuffer;
			}
			break;
		case "gzip" :
			if (function_exists('gzencode')) {
				if ($OutDest == "local") {
					$fp = gzopen($local_backup_path.$filename, "wb");
					if (!$fp) {
						HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILENOTWRITABLE' ),$filename), '0' );
						return;
					} else {
						gzwrite($fp,$OutBuffer);
						gzclose($fp);
						HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_BKUPSUCCSAVEDDIR' ),$filename), '1' );
						return;
					}
				} else {
					echo gzencode($OutBuffer);
					ob_end_flush();
					ob_start();
					// do no more
					exit();
				}
			} else {
				echo $OutBuffer;
			}
			break;
		case "zip" :
			if (function_exists('gzcompress')) {
                                include( JPATH_ADMINISTRATOR.DS.'includes'.DS.'pcl'.DS.'zip.lib.php' );
                                $zipfile = new zipfile();
				$zipfile -> addFile($OutBuffer, $filename . ".sql");
				}
			switch ($OutDest) {
				case "local" :
					$fp = fopen($local_backup_path.$filename, "wb");
					if (!$fp) {
						HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILENOTWRITABLE' ),$filename), '0' );
						return;
					} else {
						fwrite($fp, $zipfile->file());
						fclose($fp);
						HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_BKUPSUCCSAVEDDIR' ),$filename), '1' );
						return;
					}
					break;
				case "remote" :
					echo $zipfile->file();
					ob_end_flush();
					ob_start();
					// do no more
					exit();
					break;
				default :
					echo $OutBuffer;
					break;
			}
			break;
	}
	}
}

function dbRestore( $local_backup_path) {

	$uploads_okay = (function_exists('ini_get')) ? ((strtolower(ini_get('file_uploads')) == 'on' || ini_get('file_uploads') == 1) && intval(ini_get('upload_max_filesize'))) : (intval(@get_cfg_var('upload_max_filesize')));
	if ($uploads_okay)
	{
		$enctype = " enctype=\"multipart/form-data\"";
	}
	else
	{
		$enctype = '';
	}

	HTML_dbadmin::restoreIntro($enctype,$uploads_okay,$local_backup_path);
}

function doRestore( $file, $uploadedFile, $local_backup_path ) {
	global $option,$mosConfig_absolute_path;
        $db =& JFactory::getDBO();
        
        //afLoadSectionTitle( JText::_( 'ARTF_BKUP_DBBACKUP' ), 'backup', 1, 'assets/images/' );

	if(!is_null($uploadedFile) && is_array($uploadedFile) && $uploadedFile["name"] != "")
	{
		$base_Dir = $mosConfig_absolute_path . "/media/";
		if (!move_uploaded_file($uploadedFile['tmp_name'], $base_Dir . $uploadedFile['name']))
		{
			HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_FILEDONTMOVED' ), '0' );
			return false;
		}

	}
	if ((!$file) && (!$uploadedFile['name']))
	{
		HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_FILERESTOREFAULT' ), '0' );
		return;
	}

	if ($file)
	{
		if (isset($local_backup_path))
		{
			$infile		= $local_backup_path . $file;
			$upfileFull	= $file;
			$destfile = $mosConfig_absolute_path . "/media/$file";

			// If it's a zip file, we copy it so we can extract it
			if(eregi(".\.zip$",$upfileFull))
			{
				copy($infile,$destfile);
			}
		}
		else
		{
			HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_PATHERROR' ), '0' );
			return;
		}
	}
	else
	{

		$upfileFull	= $uploadedFile['name'];
		$infile	= $base_Dir . $uploadedFile['name']; 
		
	}

	if (!eregi(".\.sql$",$upfileFull) && !eregi(".\.bz2$",$upfileFull) && !eregi(".\.gz$",$upfileFull) && !eregi(".\.zip$",$upfileFull))
	{
		HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_INVALIDFILETYPE' ),$upfileFull), '0' );
		return;
	}
	
	if (substr($upfileFull,-3)==".gz")
	{
		if (function_exists('gzinflate'))
		{
			$fp=fopen("$infile","rb");
			if ((!$fp) || filesize("$infile")==0)
			{
				HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILEOPENERROR' ),$infile), '0' );
				return;
			}
			else
			{
				$content = fread($fp,filesize("$infile"));
				fclose($fp);
				$content = gzinflate(substr($content,10));
			}
		}
		else
		{
			HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_GZIPERROR' ), '0' );
			return;
		}
	}
	elseif (substr($upfileFull,-4)==".bz2")
	{
		if (function_exists('bzdecompress'))
		{
			$fp=fopen("$infile","rb");
			if ((!$fp) || filesize("$infile")==0)
			{
				HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILEOPENERROR' ),$infile), '0' );
				return;
			}
			else
			{
				$content=fread($fp,filesize("$infile"));
				fclose($fp);
				$content=bzdecompress($content);
			}
		}
		else
		{
			HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_BZIPERROR' ), '0' );
			return;
		}
	}
	elseif (substr($upfileFull,-4)==".sql")
	{
		$fp=fopen("$infile","r");
		if ((!$fp) || filesize("$infile")==0)
		{
			HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILEOPENERROR' ),$infile), '0' );
			return;
		}
		else
		{
			$content=fread($fp,filesize("$infile"));
			fclose($fp);
		}
	}
	elseif (substr($upfileFull,-4)==".zip")
	{
		// unzip the file
		$base_Dir		= $mosConfig_absolute_path . "/media/";
		$archivename	= $base_Dir . $upfileFull;
		$tmpdir			= uniqid("dbrestore_");

		$isWindows = (substr(PHP_OS, 0, 3) == 'WIN' && stristr ( $_SERVER["SERVER_SOFTWARE"], "microsoft"));
		if($isWindows)
		{
			$extractdir	= str_replace('/','\\',$base_Dir . "$tmpdir/");
			$archivename = str_replace('/','\\',$archivename);
		}
		else
		{
			$extractdir	= str_replace('\\','/',$base_Dir . "$tmpdir/");
			$archivename = str_replace('\\','/',$archivename);
		}

		$zipfile	= new PclZip($archivename);
		if($isWindows)
			define('OS_WINDOWS',1);

		$ret = $zipfile->extract(PCLZIP_OPT_PATH,$extractdir);
		if($ret == 0)
		{
			HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_UNRECOVERROR' ),$zipfile->errorName(true)), '0' );
			return false;
		}
		$filesinzip = $zipfile->listContent();
		if(is_array($filesinzip) && count($filesinzip) > 0)
		{
			$fp			= fopen($extractdir . $filesinzip[0]["filename"],"r");
			$content	= fread($fp,filesize($extractdir . $filesinzip[0]["filename"]));
			fclose($fp);

			// Cleanup temp extract dir
			afbkupdeldir($extractdir);
			//unlink($mosConfig_absolute_path . "media/$file");

		}
		else
		{
			HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_SQLFILEERROR' ),$upfileFull), '0' );
			return;
		}
	}
	else
	{
		HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_FILETYPEERROR' ),$infile,$upfileFull), '0' );
		return;
	}


	$decodedIn	= explode(chr(10),$content);
	$decodedOut	= "";
	$queries	= 0;

	foreach ($decodedIn as $rawdata)
	{
		$rawdata=trim($rawdata);
		if (($rawdata!="") && ($rawdata{0}!="#"))
		{
			$decodedOut .= $rawdata;
			if (substr($rawdata,-1)==";")
			{
				if  ((substr($rawdata,-2)==");") || (strtoupper(substr($decodedOut,0,6))!="INSERT"))
				{
					if (eregi('^(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(DATABASE)[[:space:]]+(.+)', $decodedOut))
					{
						HTML_dbadmin::showDbAdminMessage(JText::_( 'ARTF_BKUP_FILECONTENTERROR' ), '0' );
						return;
					}
					$db->setQuery($decodedOut);
					$db->query();
					$decodedOut="";
					$queries++;
				}
			}
		}
	}
	HTML_dbadmin::showDbAdminMessage(sprintf(JText::_( 'ARTF_BKUP_DBRESTOREDSUCC' ),$queries), '1' );
	return;
}

function afbkupdeldir($dir)
{
	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir))
	{
    	if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!=".."))
    	{
			afbkupdeldir("${dir}/${entryname}");
		}
		elseif($entryname != "." and $entryname!="..")
		{
			unlink("${dir}/${entryname}");
		}
	}
	closedir($current_dir);
	rmdir($dir);
}


?>

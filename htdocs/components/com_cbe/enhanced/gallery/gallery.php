<?php
//***********************************************
// CBE-Gallery by Michael Neufing               *
// Copyright (c) 2007 Michael Neufing           *
// http://www.k-b-j.de.vu                       *
// Released under the GNU/GPL License           *
// Version 1.3 File date: 10-04-2007            *
//***********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
ini_set("memory_limit", "42M");
// Ab hier nichts ändern!
// edit: oh, doch...
?>
<a name="gallery" id="gallery"></a>
<?php

if (file_exists('components/com_cbe/enhanced/gallery/language/'.$mosConfig_lang.'.php'))
	include_once('components/com_cbe/enhanced/gallery/language/'.$mosConfig_lang.'.php');
else
	include_once('components/com_cbe/enhanced/gallery/language/german.php');

//
global $mainframe;
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'CBETabHandler.php');


class CBE_gallery extends CBETabHandler {
	var $params;
	function __construct($parent) {
		$this->parent = $parent;
		$this->params = $this->parent->getParams();
	}
	
	function display() {
		global $user, $mainframe;
		//
		$maxpics = $this->params['gallery_maxpics'];
		$maxupload = $this->params['gallery_maxupload'];
		$permissions = $this->params['gallery_permissions'];
		$limit = $this->params['gallery_limit'];
		$anzahl_spalten = $this->params['gallery_anzahl_spalten'];
		$this->bildbreite = $this->params['gallery_bildbreite'];
		$this->thumbbreite = $this->params['gallery_thumbbreite'];
		$approving = (isset($this->params['gallery_approving']))?$this->params['gallery_approving']:0;
		$pages_in_list = $this->params['gallery_pages_in_list'];
		$uploadfield = $this->params['gallery_uploadfield'];
		$descriptionfield = $this->params['gallery_descriptionfield'];
		$dir = JPATH_SITE . $this->params['gallery_dir'].$user->id.'/';
		$thumb_dir = JPATH_SITE . $this->params['gallery_dir'].$user->id.'/thumbs/';
		$this->bildbreite2 = $this->bildbreite;
		$this->thumbbreite2 = $this->thumbbreite;

		//
		$my = &JFactory::getUser();
		$database = &JFactory::getDBO();
		$func = JRequest::getVar('func');
		$Itemid = JRequest::getVar('Itemid');
		$titel = JRequest::getVar('titel');
		$file = JRequest::getVar('file');

		$limitstart = JRequest::getVar('limitstart', 0);
		$anzahlupload = JRequest::getVar('anzahlupload', 1);
		$isModerator = isModerator($my->id);

		if ($approving == "1") {
			if ($isModerator) {
				$approved="1";
			}else {
				$approved="0";
			}
		}
		elseif ($approving == "0") {
			$approved="1";
		}
		else {
			die ('Fehler in der Variable $approving!');
		}

		$fileid = JRequest::getVar('fileid', 0);
		$titelnummer="1";

		$database = &JFactory::getDBO();
		$my = &JFactory::getUser();

		$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0') AND access='0' ORDER BY id DESC Limit 1");
		$Itemid_com = $database->loadResult();
		if ($Itemid_com!='' || $Itemid_com!=NULL) {
			$Itemid = $Itemid_com;
		} else {
			$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0') AND access='1' ORDER BY id DESC Limit 1");
			$Itemid_com = $database->loadResult();
			if ($Itemid_com!='' || $Itemid_com!=NULL) {
				$Itemid = $Itemid_com;
			} else {
				$Itemid = '';
			}
		}
		switch ($func) {
			case 'uploader':
				foreach ($_FILES as $files) {
					$this->bildbreite = $this->bildbreite2;
					$this->thumbbreite = $this->thumbbreite2;
					
					if($files['name']) {
						if (!file_exists($dir)) {
							mkdir($dir);
							chmod($dir, $permissions);
							mkdir($thumb_dir);
							chmod($thumb_dir, $permissions);
						}
						$zeichen="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
						$filename = "";
						mt_srand((double)microtime()*1000000);
						for ($i=1; $i <= 8; $i++) {
							$filename .= substr($zeichen, mt_rand(0,strlen($zeichen)-1), 1);
						} 
						$titel = JRequest::getVar('titel'.$titelnummer);

						$size = getimagesize($files['tmp_name']);
						if ($size[2]==1) {
							$originalbreite = $size["0"];
							$originalhoehe = $size["1"];
							
							if ($originalbreite >= $this->thumbbreite) {
								$tumbbreite=$this->thumbbreite;
								$tumbhoehe=intval($originalhoehe*$tumbbreite/$originalbreite);
							} else {
								$tumbbreite=$originalbreite;
								$tumbhoehe=$originalhoehe;
							}
							
							if ($originalbreite >= $this->bildbreite) {
								$this->bildbreite=$this->bildbreite;
								$bildhoehe=intval($originalhoehe*$this->bildbreite/$originalbreite);
							} else {
								$this->bildbreite=$originalbreite;
								$bildhoehe=$originalhoehe;
							}
							
							$originalbild = ImageCreateFromGIF($files['tmp_name']);
							
							$bild = imagecreatetruecolor($this->bildbreite, $bildhoehe);
							imagecopyresampled($bild, $originalbild, 0, 0, 0, 0, $this->bildbreite, $bildhoehe, $originalbreite, $originalhoehe);
							ImageGIF ($bild, $dir.$filename.".gif");
							
							$thumbbild = imagecreatetruecolor($tumbbreite, $tumbhoehe);
							imagecopyresampled($thumbbild, $originalbild, 0, 0, 0, 0, $tumbbreite, $tumbhoehe, $originalbreite, $originalhoehe);
							ImageGIF ($thumbbild, $thumb_dir.$filename.".gif");	
							$endung=".gif";
							
							imagedestroy($bild);
							imagedestroy($thumbbild);
							imagedestroy($originalbild);
							$query = "INSERT INTO #__cbe_gallery (uid,datei,titel,datum,approved) VALUES ('$my->id','$filename$endung','$titel','".date("Y-m-d H:i:s")."','".$approved."');";
							$database->setQuery( $query );
							if (!$database->query())
							{
								echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
								exit();
							}
						}
						elseif ($size[2]==2) {
							$originalbreite = $size["0"];
							$originalhoehe = $size["1"];
							
							if ($originalbreite >= $this->thumbbreite) {
								$tumbbreite=$this->thumbbreite;
								$tumbhoehe=intval($originalhoehe*$tumbbreite/$originalbreite);
							} else {
								$tumbbreite=$originalbreite;
								$tumbhoehe=$originalhoehe;
							}
							
							if ($originalbreite >= $this->bildbreite) {
								$this->bildbreite=$this->bildbreite;
								$bildhoehe=intval($originalhoehe*$this->bildbreite/$originalbreite);
							} else {
								$this->bildbreite=$originalbreite;
								$bildhoehe=$originalhoehe;
							}
							
							$originalbild = imagecreatefromjpeg($files['tmp_name']);
							
							$bild = imagecreatetruecolor($this->bildbreite, $bildhoehe);
							imagecopyresampled($bild, $originalbild, 0, 0, 0, 0, $this->bildbreite, $bildhoehe, $originalbreite, $originalhoehe);
							ImageJPEG ($bild, $dir.$filename.".jpg");
							
							$thumbbild = imagecreatetruecolor($tumbbreite, $tumbhoehe);
							imagecopyresampled($thumbbild, $originalbild, 0, 0, 0, 0, $tumbbreite, $tumbhoehe, $originalbreite, $originalhoehe);
							ImageJPEG ($thumbbild, $thumb_dir.$filename.".jpg");
							$endung=".jpg";	
							
							imagedestroy($bild);
							imagedestroy($thumbbild);
							imagedestroy($originalbild);
							$query = "INSERT INTO #__cbe_gallery (uid,datei,titel,datum,approved) VALUES ('$my->id','$filename$endung','$titel','".date("Y-m-d H:i:s")."','".$approved."');";
							$database->setQuery( $query );
							if (!$database->query())
							{
								echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
								exit();
							}
						}
						elseif ($size[2]==3) {
							$originalbreite = $size["0"];
							$originalhoehe = $size["1"];
					
							if ($originalbreite >= $this->thumbbreite) {
								$tumbbreite=$this->thumbbreite;
								$tumbhoehe=intval($originalhoehe*$tumbbreite/$originalbreite);
							} else {
								$tumbbreite=$originalbreite;
								$tumbhoehe=$originalhoehe;
							}
							
							if ($originalbreite >= $this->bildbreite) {
								$this->bildbreite=$this->bildbreite;
								$bildhoehe=intval($originalhoehe*$this->bildbreite/$originalbreite);
							} else {
								$this->bildbreite=$originalbreite;
								$bildhoehe=$originalhoehe;
							}
							
							$originalbild = ImageCreateFromPNG($files['tmp_name']);
							
							$bild = imagecreatetruecolor($this->bildbreite, $bildhoehe);
							imagecopyresampled($bild, $originalbild, 0, 0, 0, 0, $this->bildbreite, $bildhoehe, $originalbreite, $originalhoehe);
							ImagePNG ($bild, $dir.$filename.".png");
							
							$thumbbild = imagecreatetruecolor($tumbbreite, $tumbhoehe);
							imagecopyresampled($thumbbild, $originalbild, 0, 0, 0, 0, $tumbbreite, $tumbhoehe, $originalbreite, $originalhoehe);
							ImagePNG ($thumbbild, $thumb_dir.$filename.".png");	
							$endung=".png";
							imagedestroy($bild);
							imagedestroy($thumbbild);
							imagedestroy($originalbild);
							$query = "INSERT INTO #__cbe_gallery (uid,datei,titel,datum,approved) VALUES ('$my->id','$filename$endung','$titel','".date("Y-m-d H:i:s")."','".$approved."');";
							$database->setQuery( $query );
							if (!$database->query())
							{
								echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
								exit();
							}
						}
						elseif($files['name']) {
							$fname = $files['name'];
							$nachricht = GALLERY_UPLOADED_FILE." \"".$fname."\" ".GALLERY_WRONG_FORMAT;
							$fehler="1";
						}
					
						if (!$fehler=="1") {
						?>

		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td class="sectiontableheader" colspan="2"><?php echo GALLERY_UPLOAD_SUCCESS; ?></td>
		</tr>
		<tr>
		<td class="sectiontableentry1"><?php echo GALLERY_TITEL;?>:</td>
		<td class="sectiontableentry1"><?php echo $titel; ?></td>
		</tr>
		<tr>
		<td class="sectiontableentry2"><?php echo GALLERY_THUMB;?>:</td>
		<td class="sectiontableentry2"><img src="<?php echo JURI::root(); ?>components/com_cbe/enhanced/gallery/images/<?php echo $user->id;?>/thumbs/<?php echo $filename.$endung; ?>" alt="<?php echo $titel; ?>" /></td>
		</tr>
		<?php if($approved=="0") {?>
		<tr>
		<td class="sectiontableentry1"><strong><?php echo GALLERY_ATTENTION1;?></strong>:</td>
		<td class="sectiontableentry1"><strong><?php echo GALLERY_ATTENTION2;?></strong></td>
		</tr>
		<?php
						}
						?>
		</table>
		<?php
						}
						else {
							?>
		<h1><?php echo GALLERY_UPLOAD_ERROR;?></h1>
		<?php
							echo $nachricht;
						}
						$titelnummer++;
					} else {
						$titelnummer++;
					}
				}
				?>
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<form action="<?php echo JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=upload&limitstart=".$limitstart."#gallery");?>" method="post">
		<td class="sectiontableheader" style="padding-left:5px;text-align:left">
			<input type="submit" value="<?php echo GALLERY_UPLOAD_MORE; ?>" class="button"/>
		</td>
		</form>
		<form action="<?php echo JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery");?>" method="post">
		<td class="sectiontableheader" style="padding-right:5px;text-align:right">
			<input type="submit" value="<?php echo GALLERY_BACK;?>" class="button"/>
		</td>
		</form>
		</tr>
		</table>
		<?php
			break;
			case 'upload':
				if ($my->id == $user->id) {

					$query3 = "SELECT COUNT(id) FROM #__cbe_gallery WHERE uid='".$user->id."'";
					$database->setQuery($query3);
					$anzahlpics = $database->loadResult();
					if ($my->id == $user->id && $maxpics > $anzahlpics) {
					?>
		<table width="100%" cellpadding="0" cellspacing="0">
		<?php
		echo   "<tr>";
		echo   "<form enctype=\"multipart/form-data\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=uploader&limitstart=".$limitstart."#gallery")."\" method=\"post\">";
		echo   "<td colspan=\"2\" class=\"sectiontableheader\">".GALLERY_UPLOAD_TITEL."</td>";
		echo   "</tr>";
		for ($i=1; $i <= $anzahlupload; $i++) {			
		echo "<tr><td class=\"sectiontableentry1\">".GALLERY_FILE.":</td><td class=\"sectiontableentry1\"><input type=\"file\" style=\"width:".$uploadfield."px\" name=\"file".$i."\" class=\"inputbox\" width=\"350\" /></td></tr>";
		echo "<tr><td class=\"sectiontableentry2\">".GALLERY_TITEL.":</td><td class=\"sectiontableentry2\"><input type=\"text\" maxlength=\"100\" size=\"".$descriptionfield."\" name=\"titel".$i."\" class=\"inputbox\" /></td></tr>";
		}
		?>
		<tr>
		<td class="sectiontableentry1"><strong><?php echo GALLERY_ATTENTION1;?></strong>:</td>
		<td class="sectiontableentry1"><strong><?php echo GALLERY_ATTENTION3;?></strong></td>
		</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td class="sectiontableheader" style="padding-left:5px;text-align:left"><input type="submit" value="<?php echo GALLERY_UPLOAD;?>" class="button"/></td><td class="sectiontableheader" style="padding-right:5px;text-align:right"><input type="button" onclick="window.location.href = '<?php echo JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery");?>'" value="<?php echo GALLERY_BACK; ?>" class="button"/></td>
		</form>
		</tr>
		</table>
		<?php
					}
					else {
						$ausgabe .= GALLERY_PIC_LIMIT;
						$ausgabe .= "<br/><b>".$anzahlpics."</b> ".GALLERY_OF."<b>".$maxpics."</b> ".GALLERY_PICS."<br/>";
					}
				}else {
					$ausgabe .= GALLERY_NOT_ALLOWED;
				}
				echo $ausgabe;
			break;
			
			case 'delete':
				global $mainframe;
				$query1 = "SELECT uid, datei FROM #__cbe_gallery WHERE id='".$fileid."'";
				$database->setQuery($query1);
				$result = $database->loadObjectList();
				foreach ($result as $results) {
					if ($results->uid == $my->id or $isModerator) {
						$query = "DELETE FROM #__cbe_gallery WHERE id='".$fileid."'";
						$database->setQuery($query);
						$database->query();
						unlink($dir.$results->datei);
						unlink($thumb_dir.$results->datei);

						$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Itemid."&task=userProfile&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery");
					}
					else {
						$ausgabe = GALLERY_NOT_ALLOWED_TO_DELETE;
						$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery")."\">";
						$ausgabe .= "<input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" />";
						$ausgabe .= "</form>";
						echo $ausgabe;
					}
				}
			break;
			
			case 'delete1':
				$query1 = "SELECT uid, datei FROM #__cbe_gallery WHERE id='".$fileid."'";
				$database->setQuery($query1);
				$result = $database->loadObjectList();
				foreach ($result as $results) {
					if ($results->uid == $my->id or $isModerator) {
						$query = "DELETE FROM #__cbe_gallery WHERE id='".$fileid."'";
						$database->setQuery($query);
						$database->query();
						unlink($dir.$results->datei);
						unlink($thumb_dir.$results->datei);
						$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Itemid."&task=userProfile&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=warteschlange&limitstart=".$limitstart."#gallery");
					}
					else {
						$ausgabe = GALLERY_NOT_ALLOWED_TO_DELETE;
						$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery")."\">";
						$ausgabe .= "<input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" />";
						$ausgabe .= "</form>";
						echo $ausgabe;
					}
				}
			break;
			
			case 'bearbeiten':		
				$query1 = "SELECT uid, datei, titel FROM #__cbe_gallery WHERE id='".$fileid."'";
				$database->setQuery($query1);
				$result = $database->loadObjectList();
				foreach ($result as $results) {
					if ($results->uid == $my->id or $isModerator) {
						$ausgabe = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
						$ausgabe .= "<tr>";
						$ausgabe .= "<td class=\"sectiontableheader\" colspan=\"2\">".EDIT_PICTURE."</td>";
						$ausgabe .= "</tr>";
						$ausgabe .= "<tr>";
						$ausgabe .= "<form action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=bearbeiten2&limitstart=".$limitstart."#gallery")."\" method=\"post\">";
						$ausgabe .= "<td class=\"sectiontableentry1\">".GALLERY_PIC.":</td><td class=\"sectiontableentry1\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/images/".$user->id."/thumbs/".$results->datei."\" alt=\"".$results->titel."\" /></td>";
						$ausgabe .= "</tr>";
						$ausgabe .= "<tr><td class=\"sectiontableentry2\">".GALLERY_TITEL.":</td><td class=\"sectiontableentry2\"><input type=\"text\" maxlength=\"100\" size=\"".$descriptionfield."\" name=\"titel\" value=\"".$results->titel."\" /></td></tr>";
						$ausgabe .= "<tr><td class=\"sectiontableentry1\"><strong>".GALLERY_ATTENTION1."</strong>:</td><td class=\"sectiontableentry1\"><strong>".GALLERY_ATTENTION3."</strong></td></tr>";
						$ausgabe .= "<tr><td align=\"center\"><input type=\"hidden\" name=\"fileid\" value=\"".$fileid."\" /></td></tr>";
						$ausgabe .= "<tr>";
						$ausgabe .= "<td class=\"sectiontableheader\" style=\"padding-left:5px;text-align:left\"><input type=\"submit\" class=\"button\" value=\"".GALLERY_EDIT."\" /></td>";
						$ausgabe .= "<td class=\"sectiontableheader\" style=\"padding-right:5px;text-align:right\"><input type=\"button\" class=\"button\" onclick=\"window.location.href = '".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery")."'\" value=\"".GALLERY_BACK."\" /></td>";
						$ausgabe .= "</form>";
						$ausgabe .= "</tr>";
						$ausgabe .= "</table>";
						echo $ausgabe;
					}
					else {
						$ausgabe = GALLERY_NOT_ALLOWED_TO_EDIT;
						$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery")."\">";
						$ausgabe .= "<input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" />";
						$ausgabe .= "</form>";
						echo $ausgabe;
					}
				}
			break;
			
			case 'bearbeiten2':
				$query1 = "SELECT uid FROM #__cbe_gallery WHERE id='".$fileid."'";
				$database->setQuery($query1);
				$result = $database->loadObjectList();
				foreach ($result as $results) {
					if ($results->uid == $my->id or $isModerator) {
						$query = "UPDATE #__cbe_gallery SET titel='".$titel."' WHERE id='".$fileid."'";
						$database->setQuery($query);
						$database->query();
						
						$mainframe->redirect("index.php?option=com_cbe&Itemid=".$Itemid."&task=userProfile&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery");
					}
					else {
						$ausgabe = GALLERY_NOT_ALLOWED_TO_EDIT;
						$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&limitstart=".$limitstart."#gallery")."\">";
						$ausgabe .= "<input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" />";
						$ausgabe .= "</form>";
						echo $ausgabe;
					}
				}
			break;

			case 'warteschlange':
				if ($my->id == $user->id) {
					$query2 = "SELECT COUNT(id) FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='0'";
					$database->setQuery($query2);
					$result2 = $database->loadResult();
					if ($result2 > 0) {
						$ue_base_url= "index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=warteschlange";
						
						if (empty($limitstart)) $limitstart = 0;
						if ($limit >= $result2) {
							$limitstart = 0;
						}
						if($result2 > $limit) {
							?>
							<hr><div style="width:100%;text-align:center;"><?php echo $this->gallery_writePagesLinks($limitstart, $limit, $result2, $ue_base_url, $pages_in_list);?></div><br />
							<?php
						}
				
						$ausgabe .= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"text-align:center; vertical-align: bottom;\">";
						$query2 = "SELECT id, datei, titel FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='0' ORDER BY datum ASC LIMIT $limitstart, $limit";
						$database->setQuery($query2);
						$result = $database->loadObjectList();
						$nummer = "2";
						$spalten = "1";
						$ausgabe .= "<tr><td align=\"left\" colspan=\"3\" class=\"sectiontableheader\">".GALLERY_WARTE."</td></tr>";
						foreach ($result as $val => $results) {
							if ($nummer == "2") {
								$nummer = "1";
							}
							elseif ($nummer == "1") {
								$nummer ="2";
							}
							if ($my->id == $user->id or $isModerator) {
								$delete = "<br /><br /><a href=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=delete1&fileid=".$results->id."#gallery")."\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/sysimages/delete.png\" alt=\"".GALLERY_DELETE."\" title=\"".GALLERY_DELETE."\" /></a>";
			$bearbeiten = "&nbsp;<a href=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=bearbeiten&fileid=".$results->id."&limitstart=".$limitstart."#gallery")."\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/sysimages/edit.png\" alt=\"".GALLERY_EDIT1."\" title=\"".GALLERY_EDIT1."\"/></a>";
							}
							if ($spalten=="1") {
								$ausgabe.="<tr>";
								$spalten = "1";
							}
							$ausgabe .= "<td class=\"sectiontableentry".$nummer."\" style=\"text-align:center;vertical-align:bottom;\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/images/".$user->id."/thumbs/".$results->datei."\" alt=\"".$results->titel."\" /><br />".nl2br($results->titel).$delete.$bearbeiten."</td>";
							if ($spalten==$anzahl_spalten or !isset($result[($val + 1)])){
								$ausgabe .= "</tr>";
								$spalten = "1";
							}
							else {
								$spalten++;
							}
							if (!isset($result[($val + 1)])){
								$ids_last = " AND id > '".$results->id."'";
							}
						}
						$ausgabe .= "<tr>";
						$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."#gallery")."\">";
						$ausgabe .= "<td colspan=\"3\" class=\"sectiontableheader\" style=\"padding-right:5px;text-align:right\">";
						$ausgabe .= "<input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" />";
						$ausgabe .= "</td>";
						$ausgabe .= "</form>";
						$ausgabe .= "</tr>";
						$ausgabe .= "</table>";
						echo $ausgabe;
						if($result2 > $limit) {
							?>
							<hr><div style="width:100%;text-align:center;"><?php echo $this->gallery_writePagesLinks($limitstart, $limit, $result2, $ue_base_url, $pages_in_list);?></div><br />
							<?php
						}
					} else {
						$ausgabe .= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
						$ausgabe .= "<tr><td class=\"sectiontableentry1\">".GALLERY_NO_WARTE."</td></tr>";
						$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."#gallery")."\">";
						$ausgabe .= "<tr><td class=\"sectiontableheader\" style=\"padding-right:5px;text-align:right\"><input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" /></td></tr>";
						$ausgabe .= "</form>";
						$ausgabe .= "</table>";
						echo $ausgabe;
					}
				}
				else {
					$ausgabe .= GALLERY_NOT_ALLOWED_TO_WARTE;
					$ausgabe .= "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."#gallery")."\">";
					$ausgabe .= "<input type=\"submit\" class=\"button\" value=\"".GALLERY_BACK."\" />";
					$ausgabe .= "</form>";
					echo $ausgabe;
				}
			break;

			default:
				$query10= "SELECT COUNT(id) FROM #__cbe_gallery WHERE uid='".$user->id."'";
				$database->setQuery($query10);
				$anzahlpics1 = $database->loadResult();
				
				$query2 = "SELECT COUNT(id) FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='0'";
				$database->setQuery($query2);
				$anzahlpics2 = $database->loadResult();
				
				$query3 = "SELECT COUNT(id) FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='1'";
				$database->setQuery($query3);
				$anzahlpics = $database->loadResult();
				
				if ($anzahlpics == "0" && $user->id!=$my->id) {
					echo GALLERY_USER_NO_PICS;
				}
				if ($my->id == $user->id && $maxpics > $anzahlpics1) {
					$restpics = $maxpics - $anzahlpics1;
					if ($maxupload > $restpics) {
						$maxupload = $restpics;
					}
					echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
					echo "<tr>";
					echo "<form method=\"post\" action=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=upload&limitstart=".$limitstart."#gallery")."\">";
					echo "<td align=\"center\"><select name=\"anzahlupload\">";
					for ($i=1; $i <= $maxupload; $i++) {
						echo "<option>".$i."</option>";
					}
					echo "</select>";
					echo "&nbsp;<input type=\"submit\" class=\"button\" value=\"".GALLERY_PIC_ADD."\" /><br /><br /></td>";
					echo "</form>";
					echo "<tr>";
					echo "</tr>";
					echo "<td class=\"sectiontableheader\"><b>".$anzahlpics."</b> ".GALLERY_OF."<b> ".$maxpics."</b> ".GALLERY_PICS." | <b>".$anzahlpics2."</b> ".GALLERY_IN." <a href=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&task=userProfile&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=warteschlange#gallery")."\">".GALLERY_WARTE."</a></td>";
					echo "</tr>";
				}
				elseif ($my->id == $user->id && $maxpics <= $anzahlpics1) {
					echo GALLERY_PIC_LIMIT;
					echo "<br/><b>".$anzahlpics."</b> ".GALLERY_OF."<b> ".$maxpics."</b> ".GALLERY_PICS." | ".$anzahlpics2." ".GALLERY_IN." <a href=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&task=userProfile&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=warteschlange#gallery")."\">".GALLERY_WARTE."</a><br/>";
				}
				?>
		<!-- Lightbox:(c)Ponygallery ML  [anfang]//-->
		<script language="javascript" type="text/javascript">
			<!--
			var resizeSpeed = 5;
			var resizeJsImage = 1;
			var borderSize = 10;
			//-->
		</script>
		<script language="javascript" type="text/javascript" src="<?php echo JURI::root(); ?>components/com_cbe/enhanced/gallery/lightbox/prototype.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo JURI::root(); ?>components/com_cbe/enhanced/gallery/lightbox/scriptaculous.js?load=effects"></script>
		<script language="javascript" type="text/javascript" src="<?php echo JURI::root(); ?>components/com_cbe/enhanced/gallery/lightbox/lightbox.js"></script>
		<link href="<?php echo JURI::root(); ?>components/com_cbe/enhanced/gallery/lightbox/lightbox.css" rel="stylesheet" type="text/css" />

		<style type="text/css">
			<!--
			#outerImageContainer{	background-color: white; }
			#imageContainer{ padding: 10px; }
			#imageDataContainer{ background-color: white; }
			#overlay{ background-color: black; }
			-->
		</style>
		<script language="javascript" type="text/javascript">
		<!--
		//Config
		var pg_ffwrong = "red";
		var pg_padding = "10";
		var pg_filenamewithjs = "1";
		var pg_dhtml_border = "gray";
		var pg_openjs_background = "white";
		var pg_disableclick = "1";
		var pg_use_code = "1";
		var pg_show_title_in_dhtml = "0";
		var pg_show_description_in_dhtml = "0";
		//Language
		var ponygallery_select_category = "Du mußt eine Kategorie auswählen.";
		var ponygallery_select_file = "Du mußt mindestens eine Datei auswählen.";
		var ponygallery_pic_must_have_title = "Das Bild muß einen Titel haben";
		var ponygallery_filename_double1 = "Identische Dateien!\nIn Feld";
		var ponygallery_filename_double2 = "und Feld";
		var ponygallery_wrong_filename = "Falscher Dateiname!\nEs sind keine Sonderzeichen erlaubt.";
		var ponygallery_wrong_extension = "Falscher Dateityp!\nNur .jpg, .jpeg, .jpe, .gif und .png sind erlaubt.";
		var ponygallery_must_have_fname = "Du mußt mindestens ein Bild auswählen.";
		var ponygallery_enter_name_email = "Bitte gebe den Namen Deines Freundes und dessen Email-Adresse ein!";
		var ponygallery_enter_comment = "Bitte gib ein Kommentar ein";
		var ponygallery_enter_code = "Bitte gib den Bildcode ein!";
		var ponygallery_image = "Bild";
		var ponygallery_of = "von";
		//-->
		</script>
		<!-- Lightbox:(c)Ponygallery ML  [ende]//-->
		<?php
			$ue_base_url= "index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE;
			
			if (empty($limitstart)) $limitstart = 0;
			if ($limit >= $anzahlpics) {
				$limitstart = 0;
			}
				if($anzahlpics > $limit) {
					?>
					<hr><div style="width:100%;text-align:center;"><?php echo $this->gallery_writePagesLinks($limitstart, $limit, $anzahlpics, $ue_base_url, $pages_in_list);?></div><br />
					<?php
				}
				$database = &JFactory::getDBO();
				$ausgabe .= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"text-align:center; vertical-align: bottom;\">";
				$query1 = "SELECT id, datei, titel FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='1' ORDER BY datum ASC LIMIT $limitstart, $limit";
				$database->setQuery($query1);
				$result = $database->loadObjectList();
				$nummer = "2";
				$spalten = "1";
				$ids = "";
				foreach ($result as $val => $results) {
					if (!isset($result[($val - 1)])){
						$ids_first = " AND id < '".$results->id."'";
					}
					$ids .= " AND id!='".$results->id."'";
				}
				$query3 = "SELECT datei, titel FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='1' ".$ids.$ids_first." ORDER BY datum ASC";
				$database->setQuery($query3);
				$result3 = $database->loadObjectList();
				foreach ($result3 as $results3) {
					$ausgabe .= "<a href=\"".JURI::root()."components/com_cbe/enhanced/gallery/images/".$user->id."/".$results3->datei."\" rel=\"lightbox[gallery]\" title=\"".nl2br($results3->titel)."\"></a>";
				}
				foreach ($result as $val => $results) {
					if ($nummer == "2") {
						$nummer = "1";
					}
					elseif ($nummer == "1") {
						$nummer ="2";
					}
					if ($my->id == $user->id or $isModerator) {
						$delete = "<br /><br /><a href=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=delete&fileid=".$results->id."&limitstart=".$limitstart."#gallery")."\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/sysimages/delete.png\" alt=\"".GALLERY_DELETE."\" title=\"".GALLERY_DELETE."\" /></a>";
						$bearbeiten = "&nbsp;<a href=\"".JRoute::_("index.php?option=com_cbe&Itemid=".$Itemid."&user=".$user->id."&index=".GALLERY_TAB_TITLE."&func=bearbeiten&fileid=".$results->id."&limitstart=".$limitstart."#gallery")."\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/sysimages/edit.png\" alt=\"".GALLERY_EDIT1."\" title=\"".GALLERY_EDIT1."\"/></a>";
					}
					if ($spalten=="1") {
						$ausgabe.="<tr>";
						$spalten = "1";
					}
					$ausgabe .= "<td class=\"sectiontableentry".$nummer."\" style=\"text-align:center; vertical-align: bottom;\"><a href=\"".JURI::root()."components/com_cbe/enhanced/gallery/images/".$user->id."/".$results->datei."\" rel=\"lightbox[gallery]\" title=\"".nl2br($results->titel)."\"><img src=\"".JURI::root()."components/com_cbe/enhanced/gallery/images/".$user->id."/thumbs/".$results->datei."\" alt=\"".$results->titel."\" /></a><br />".nl2br($results->titel).$delete.$bearbeiten."</td>";
					if ($spalten==$anzahl_spalten or !isset($result[($val + 1)])){
						$ausgabe .= "</tr>";
						$spalten = "1";
					}
					else {
						$spalten++;
					}
					if (!isset($result[($val + 1)])){
						$ids_last = " AND id > '".$results->id."'";
					}
				}
				$ausgabe .= "</table>";
				$query2 = "SELECT datei, titel FROM #__cbe_gallery WHERE uid='".$user->id."' AND approved='1' ".$ids.$ids_last." ORDER BY datum ASC";
				$database->setQuery($query2);
				$result2 = $database->loadObjectList();
				foreach ($result2 as $results2) {
					$ausgabe .= "<a href=\"".JURI::root()."components/com_cbe/enhanced/gallery/images/".$user->id."/".$results2->datei."\" rel=\"lightbox[gallery]\" title=\"".nl2br($results2->titel)."\"></a>";
				}
				echo $ausgabe;
				if($anzahlpics > $limit) {
					?>
					<hr><div style="width:100%;text-align:center;"><?php echo $this->gallery_writePagesLinks($limitstart, $limit, $anzahlpics, $ue_base_url, $pages_in_list);?></div><br />
					<?php
				}
			break;
		}
	}
	function gallery_writePagesLinks($limitstart, $limit, $anzahlpics, $ue_base_url, $pages_in_list)
	{
		$displayed_pages = $pages_in_list;
		$total_pages = ceil( $anzahlpics / $limit );
		$this_page = ceil( ($limitstart+1) / $limit );
		$start_loop = (floor(($this_page-1)/$displayed_pages))*$displayed_pages+1;
		if ($start_loop + $displayed_pages - 1 < $total_pages) {
			$stop_loop = $start_loop + $displayed_pages - 1;
		} else {
			$stop_loop = $total_pages;
		}

		if ($this_page > 1) {
			$page = ($this_page - 2) * $limit;
			echo "\n<a class=\"pagenav\" href=\"".JRoute::_($ue_base_url."&limitstar=0#gallery")."\" title=\"" . _UE_FIRST_PAGE . "\">&lt;&lt; " . _UE_FIRST_PAGE . "</a>";
			echo "\n<a class=\"pagenav\" href=\"".JRoute::_($ue_base_url."&limitstart=".$page."#gallery")."\" title=\"" . _UE_PREV_PAGE . "\">&lt; " . _UE_PREV_PAGE . "</a>";
		} else {
			echo '<span class="pagenav">&lt;&lt; '. _UE_FIRST_PAGE .'</span> ';
			echo '<span class="pagenav">&lt; '. _UE_PREV_PAGE .'</span> ';
		}

		for ($i=$start_loop; $i <= $stop_loop; $i++) {
			$page = ($i - 1) * $limit;
			if ($i == $this_page) {
				echo "\n <span class=\"pagenav\">$i</span> ";
			} else {
				echo "\n<a class=\"pagenav\" href=\"".JRoute::_($ue_base_url."&limitstart=".$page."#gallery")."\"><strong>$i</strong></a>";
			}
		}

		if ($this_page < $total_pages) {
			$page = $this_page * $limit;
			$end_page = ($total_pages-1) * $limit;
			if ($start_loop + $displayed_pages - 1 < $total_pages) {
				echo "\n <span class=\"pagenav\">&hellip;</span> ";
			}
			echo "\n<a class=\"pagenav\" href=\"".JRoute::_($ue_base_url."&limitstart=".$page."#gallery")."\" title=\"" . _UE_NEXT_PAGE . "\">" . _UE_NEXT_PAGE . " &gt;</a>";
			echo "\n<a class=\"pagenav\" href=\"".JRoute::_($ue_base_url."&limitstart=".$end_page."#gallery")."\" title=\"" . _UE_END_PAGE . "\">" . _UE_END_PAGE . " &gt;&gt;</a>";
		} else {
			echo '<span class="pagenav">'. _UE_NEXT_PAGE .' &gt;</span> ';
			echo '<span class="pagenav">'. _UE_END_PAGE .' &gt;&gt;</span>';
		}	
		
	}
}
?>
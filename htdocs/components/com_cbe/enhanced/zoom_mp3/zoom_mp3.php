<?php
//****************************************************
// Zoom Photos in Profile By Jeffrey Randall         *
// Copyright (c) 2005 By Jeffrey Randall             *
// 02-04-2005 http://mambome.com                     *
// Released under the GNU/GPL License                *
// Version 1.0.5                                     *
// File date: 16-05-2005                             *
//****************************************************
//todo ad integrated upload form
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (file_exists('components/com_cbe/enhanced/zoom_mp3/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/zoom_mp3/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/zoom_mp3/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

?>
<link href="<?php echo JURI::root();?>components/com_cbe/enhanced/enhanced_css.css" rel="stylesheet" type="text/css""/>
<?php

if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}
$my = &JFactory::getUser();
$func=JRequest::getVar('func', 'zoom_mp3' );
$prof=JRequest::getVar('prof','');
$picid=JRequest::getVar('picid','');

switch ($func)
{
	case "mp3_delzphoto":
	mp3_delzphoto($Itemid_c, $option, $my->id, $pathid, $picid, _UE_UPDATE);
	break;

	case "mp3_unpubzphoto":
	mp3_unpubzphoto($Itemid_c, $option, $my->id, $picid, _UE_UPDATE);
	break;

	case "mp3_pubzphoto":
	mp3_pubzphoto($Itemid_c, $option, $my->id, $picid, _UE_UPDATE);
	break;

}

//Zoom Functions
function mp3_delzphoto($Itemid_c, $option, $uid, $submitvalue1, $submitvalue2)
{
	global $database,$my,$prof,$mainframe;
	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_('ALERTNOTAUTH');
		return;
	}

	$file1 = urldecode($submitvalue);
	$file2 = mp3_insert_to_path($filename, "thumbs");
	$file3 = mp3_insert_to_path($filename, "viewsize");
	$error = false;

	if(is_writable($file1))
	{
		if(!@fs_unlink($file1))
		{
			$error = true;
		}
	}
	//If image is deleted, delete thumb (if it exists at all)
	if (!$error)
	{
		if(is_writable($file2))
		{
			if(!@fs_unlink($file2))
			{
				$error = true;
			}
		}
	}
	//If thumbnail is deleted, delete the viewsize image (if it exists at all)
	if (!$error)
	{
		if (is_writable($file3))
		{
			if (!@fs_unlink($file3))
			{
				$error = true;
			}
		}
	}

	if (!$error)
	{
		//Delete record from mos_zoomfiles and comments from mos_zoom_comments
		$database->setQuery("DELETE FROM  #__zoomfiles
							 WHERE imgid=".mysql_escape_string($submitvalue2));
		$database->query();
		$database->setQuery("DELETE FROM #__zoom_comments
							 WHERE imgid=".mysql_escape_string($submitvalue2));
		$database->query();
		// check if the image was a category image...
		$database->setQuery("SELECT catid FROM #__zoom
							 WHERE catimg = ".mysql_escape_string($submitvalue2)." 
							 LIMIT 1");
		$this->_result = $database->query();

		$mainframe->redirect ("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=zoom_mp3&index="._UE_ZOOM_MP3_PHOTOS_TAB_LABEL);
	}
	return $error;

}

function mp3_insert_to_path($filepath, $addition)
{
	$expl_fn=explode("/", $filepath);
	$actual_file=$expl_fn[count($expl_fn)-1];
	$expl_fn[count($expl_fn)-1]=$addition;
	$expl_fn[count($expl_fn)]=$actual_file;
	$new_path=implode("/",$expl_fn);
	return $new_path;
}

function mp3_unpubzphoto($Itemid_c, $option, $uid, $submitvalue)
{
	global $my,$prof,$ueConfig,$mainframe;
	$database = &JFactory::getDBO();
	if ($uid == 0)
	{
		echo JText::_('ALERTNOTAUTH');
		return;
	}
	$query = "UPDATE #__zoomfiles
			  SET published=0 
			  WHERE uid='".$uid."' 
			  AND imgid='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$mainframe->redirect("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=zoom_mp3&index="._UE_ZOOM_MP3_PHOTOS_TAB_LABEL);

}
function mp3_pubzphoto($Itemid_c, $option, $uid, $submitvalue)
{
	global $my,$prof,$mainframe;
	$database = &JFactory::getDBO();

	if ($uid == 0)
	{
		echo JText::_('ALERTNOTAUTH');
		return;
	}

	$query = "UPDATE #__zoomfiles
			  SET published=1 
			  WHERE uid='".$uid."' 
			  AND imgid='".$submitvalue."'";
	$database->setQuery($query);

	if (!$database->query())
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$mainframe->redirect ("index.php?option=com_cbe".$Itemid_c."&task=userProfile&user=$prof&func=zoom_mp3&index="._UE_ZOOM_MP3_PHOTOS_TAB_LABEL);
}

function ztmp3_isImage($tag) {
	$tag = strtolower($tag);
	return in_array($tag, ztmp3_acceptableImageList());
}
function ztmp3_isMovie($tag) {
	$tag = strtolower($tag);
	return in_array($tag, ztmp3_acceptableMovieList());
}
function ztmp3_isAudio($tag) {
	$tag = strtolower($tag);
	return in_array($tag, ztmp3_acceptableAudioList());
}
function ztmp3_isPlayable($tag) {
	$tag = strtolower($tag);
	return in_array($tag, ztmp3_playableAudioList());
}
function ztmp3_isDocument($tag) {
	$tag = strtolower($tag);
	return in_array($tag, ztmp3_acceptableDocumentList());
}

function ztmp3_acceptableImageList() {
	return array('jpg', 'jpeg', 'gif', 'png');
}
function ztmp3_acceptableDocumentList() {
	return array('doc', 'ppt', 'pdf', 'rtf');
}
function ztmp3_acceptableAudioList() {
	return array('mp3','ogg','wma');
}
function ztmp3_playableAudioList() {
	return array('mp3','wma');
}
function ztmp3_acceptableMovieList() {
	return array('avi', 'mpg', 'mpeg', 'wmv', 'mov', 'rm', 'swf');
}
function ztmp3_isAdmin($my_user) {
	//
	$_isAdmin = false;
	if (strtolower($my_user->usertype) == 'administrator' || strtolower($my_user->usertype) == 'superadministrator' || strtolower($my_user->usertype) == 'super administrator') {
		$_isAdmin = true;
	}
	return $_isAdmin;
}
function ztmp3_getOrderMethod($orderMethod) {
	switch ($orderMethod) {
	        case 1:
	                return "imgdate ASC";
	                break;
	        case 2:
	                return "imgdate DESC";
	                break;
	        case 3:
	                return "imgfilename ASC";
	                break;
	        case 4:
	                return "imgfilename DESC";
	                break;
	        case 5:
	                return "imgname ASC";
	                break;
	        case 6:
	                return "imgname DESC";
	                break;
	}
}


// get Zoom Itemid
$database = &JFactory::getDBO();
$database->setQuery("select id from #__menu where link='index.php?option=com_zoom' AND (published='1' OR published='0') AND access='0' ORDER BY id DESC Limit 1");
$Itemid_zoom=$database->loadResult();
if ($Itemid_zoom!='' || $Itemid_zoom!=NULL) {
	$Itemid_zoom = "&amp;Itemid=".$Itemid_zoom;
} else {
	$Itemid_zoom = '';
}


//Zoom Display
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";

$safepath='';
$zOOm_no_rating_label = _UE_ZOOM_MP3_IMAGE_NO_RATING_LABEL;
$zOOm_rating_label = _UE_ZOOM_MP3_RATING_LABEL;
$zOOm_upload_link_text = _UE_ZOOM_MP3_UPLOAD_LINK_TEXT;

$setsize = $enhanced_Config['setzoomsize'];
$imagewidth = $enhanced_Config['zoomimagewidth'];
$imageheight =  $enhanced_Config['zoomimageheight'];
$zoom = "";

$setwidth ='';
$setheight ='';

if($setsize =='1')
{
	$imagewidth = str_replace('%','',$imagewidth);
	$imageheight = str_replace('%','',$imageheight);
	
	
//	$setwidth = "width=\"$imagewidth\""; //set image width
//	$setheight = "height=\"$imageheight\""; // set image height
}

//old zOOm version config is in database
if ($enhanced_Config['zoomversion']==1)
{
	$query = "SELECT imagepath
			  FROM #__zoom_config";
	$database ->setQuery ($query);
	$ZoomPath = $database->loadResult();
}
//new zOOm config is in file
elseif ($enhanced_Config['zoomversion']==2)
{
	include_once(JPATH_SITE."/components/com_zoom/zoom_config.php");
	$ZoomPath = $zoomConfig['imagepath'];
}
//zoom 2.5b3
elseif ($enhanced_Config['zoomversion']==3)
{
	include_once(JPATH_SITE.'/components/com_zoom/etc/zoom_config.php');
	$GLOBALS['zoomConfig'] = $zoomConfig;
	$ZoomPath = $zoomConfig['imagepath'];
	$Zver = 3;
}

$ZoomString = "<tr><td colspan=\"2\">\n";

$ZoomQueryFilter = "";
$first_sort = ztmp3_getOrderMethod($enhanced_Config['zoom_orderMethod_mp3']);
if ($enhanced_Config['use_zoom_limiter']=='1') {
	if ($enhanced_Config['use_zoom_keyword']=='1') {
		$ZoomQueryFilter .= " AND imgkeywords LIKE '%CBEtab%'";
	}
	$ZoomQueryFilter .= " ORDER BY ".$first_sort;

	$enhanced_Config['use_zoom_maxnr_mp3'] = $enhanced_Config['use_zoom_maxnr_mp3'] + 1 - 1;
	if (($enhanced_Config['use_zoom_maxnr_mp3']!='0' || $enhanced_Config['use_zoom_maxnr_mp3']!='') AND is_integer($enhanced_Config['use_zoom_maxnr_mp3'])) {
		$ZoomQueryFilter .= " LIMIT ".$enhanced_Config['use_zoom_maxnr_mp3']."";
	}
	$first_sort = ztmp3_getOrderMethod($zoomConfig['orderMethod']);
}

if ($ZoomQueryFilter == "") {
	$ZoomQueryFilter = " ORDER BY ".$first_sort;
}

$my = &JFactory::getUser();
$query = "SELECT imgid, imgfilename, imgname, imghits, votesum, published, catid, uid FROM #__zoomfiles WHERE uid='".$user->id."'"; //get photos
$query .= " AND imgfilename LIKE '%.mp3'";
if($my->id != $user->id) {
	$query .= " AND published=1"; //get photos
}
$query .= $ZoomQueryFilter;
$database ->setQuery ($query);
$photos = $database->loadObjectList();


if (count($photos) > 0) {
	foreach($photos as $photo) //get the directory of the photo
	{
	$query = "SELECT catid,
					 catdir 
			  FROM #__zoom 
			  WHERE published=1 
			  AND catid='".$photo->catid."'";
	$database ->setQuery ($query);
	$catdirs =  $database->loadObjectList();

	$thumbphoto = $photo->imgfilename;
	$photo_tag = ereg_replace(".*\.([^\.]*)$", "\\1", $photo->imgfilename);
	$photoname = $photo->imgname;
	$photoname = wordwrap($photoname, 14, "\n", 1); //wrap the name if over certain length

	foreach($catdirs as $catdir)
	{

		$imgdir = $catdir->catdir;
		$thumbpath = "/thumbs/";
		$slash='/';
		//$imgsize=getimagesize($mosConfig_live_site."/".$ZoomPath.$catdir->catdir."/".$photo->imgfilename);
// PK edit
		if (ztmp3_isImage($photo_tag)) {
			$imgsize=getimagesize($ZoomPath.$catdir->catdir."/".$photo->imgfilename);
			$imgWidth = ($imgsize[0]+40);
			$imgHeight = ($imgsize[1]+40);

			if($setsize =='1') {
					$thmsize = getimagesize($ZoomPath.$imgdir.$thumbpath.$thumbphoto);
					$thmWidth = $thmsize[0];
					$thmHeight = $thmsize[1];
					$thmRatiow = $thmsize[0] / $thmsize[1];
					$thmRatioh = $thmsize[1] / $thmsize[0];
		
					$imageRatiow = $imagewidth / $imageheight;
					$imageRatioh = $imageheight / $imagewidth;
		
					if ($thmRaitiow == $imageRatiow) {
						$setwidth = " width=\"$imagewidth\""; //set image width
						$setheight = " height=\"$imageheight\""; // set image height
					} else if ($thmWidth >= $imagewidth) {
						$setwidth = " width=\"$imagewidth\""; //set image width
						$imageheight = $imagewidth / $thmRatiow;
						$setheight = " height=\"$imageheight\""; // set image height
					} else if ($thmHeight >= $imageheight) {
						$imagewidth = $imageheight / $thmRatioh;
						$setwidth = " width=\"$imagewidth\""; //set image width
						$setheight = " height=\"$imageheight\""; // set image height
					} else if ($thmWidth < $imagewidth) {
						$setwidth = " width=\"$thmWidth\""; //set image width
						$imageheight = $thmWidth / $thmRatiow;
						$setheight = " height=\"$imageheight\""; // set image height
					} else if ($thmHeight < $imageheight) {
						$imagewidth = $thmHeight / $thmRatioh;
						$setwidth = " width=\"$imagewidth\""; //set image width
						$setheight = " height=\"$thmHeight\""; // set image height
					}
			} else {
				$setwidth = "";
				$setheight = "";
			}
		} elseif (ztmp3_isPlayable($photo_tag)) {
			$imgHeight = 200;
			$imgWidth = 300;
		} else {
			$imgHeight = 100;
			$imgWidth = 100;
		}	

// PK edit END		
		$ZoomString .= "<div class=\"zoom_pic\">";
		if ($enhanced_Config['zoom_full_link_mp3']=='1') {
			$ZoomString .= "<a href=\"#\" onclick=\"javascript: window.open('".JURI::root().$ZoomPath.$catdir->catdir."/".$photo->imgfilename."','imgwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=".$imgWidth.",height=".$imgHeight."'"."); return false\" >"._UE_ZOOM_MP3_TAB_FULLSIZE."</a>";
		}

		if($my->id == $user->id && $photo->published==1)
		{
			$ZoomString .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user->id&func=mp3_unpubzphoto&amp;picid=$photo->imgid\">"._UE_ZOOM_MP3_TAB_UNPUBLISH."</a><br />\n";
		}
		elseif($my->id == $user->id && $photo->published==0)
		{
			$ZoomString .= "<a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user->id&func=mp3_pubzphoto&amp;picid=$photo->imgid\">"._UE_ZOOM_MP3_TAB_PUBLISH."</a><br />\n";
		}

		$key_sort = ztmp3_getOrderMethod($zoomConfig['orderMethod']);
		$_where = "";
		if (ztmp3_isAdmin($my) != true) {
			$_where = " AND published='1' ";
		}
		$database->setQuery("SELECT imgid FROM #__zoomfiles WHERE catid='".$photo->catid."'".$_where." ORDER BY ".$key_sort."");
		$ph_co_run = $database->loadResultArray();
		$key_i_m = count($ph_co_run);
		for ($key=0; $key < $key_i_m; $key++) {
			if ($ph_co_run[$key] == $photo->imgid) {
				$b_key = $key;
				break;
			} else {
				$b_key = 0;
			}
		}

		if (ztmp3_isPlayable($photo_tag)) {
		//	$database->setQuery("SELECT imgid FROM #__zoomfiles WHERE catid='".$photo->catid."' ORDER by imgid");
		//	$ph_co_run = $database->loadResultArray();
		//	$key_i_m = count($ph_co_run);
		//	for ($key=0; $key < $key_i_m; $key++) {
		//		if ($ph_co_run[$key] == $photo->imgid) {
		//			$b_key = $key;
		//			break;
		//		} else {
		//			$b_key = 0;
		//		}
		//	}
			$key = $b_key;
			$ZoomString .= "<a href=\"#\" onclick=\"javascript: window.open('".JURI::root()."index2.php?option=com_zoom".$Itemid_zoom."&page=view&catid=".$photo->catid."&PageNo=1&key=".$key."&hit=1','imgwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=".$imgWidth.",height=".$imgHeight."'"."); return false\" >";
		} else {
			$key = $b_key;
			//$ZoomString .= "<a href=\"#\" onclick=\"javascript: window.open('".$mosConfig_live_site."/".$ZoomPath.$catdir->catdir."/".$photo->imgfilename."','imgwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=".$imgWidth.",height=".$imgHeight."'"."); return false\" >";
			$ZoomString .= "<a href=\"".JURI::root()."index.php?option=com_zoom".$Itemid_zoom."&page=view&catid=".$photo->catid."&PageNo=1&key=".$key."&hit=1\" >";
		}

		if (ztmp3_isImage($photo_tag)) {
			$ZoomString .= "<img src=\"$ZoomPath$imgdir$thumbpath$thumbphoto\"$setwidth$setheight border=\"0\"/></a>\n<br />".stripslashes($photoname)."\n";
		} elseif (ztmp3_isAudio($photo_tag)) {
			$image_virt = JURI::root()."components/com_zoom/www/images/filetypes/audio.png";
			$imgWidth = $imgHeight = 64;
			$setwidth = " width=\"$imgWidth\""; //set image width
			$setheight = " height=\"$imgHeight\""; // set image height
			$ZoomString .= "<img src=\"".$image_virt."\"$setwidth$setheight border=\"0\"/></a>\n<br />".stripslashes($photoname)."\n";
		} elseif (ztmp3_isDocument($photo_tag)) {
			$image_virt = JURI::root()."components/com_zoom/www/images/filetypes/document.png";
			$imgWidth = $imgHeight = 64;
			$imgWidth = $imgHeight = 64;
			$setwidth = " width=\"$imgWidth\""; //set image width
			$setheight = " height=\"$imgHeight\""; // set image height
			$ZoomString .= "<img src=\"".$image_virt."\"$setwidth$setheight border=\"0\"/></a>\n<br />".stripslashes($photoname)."\n";
//		} elseif (ztmp3_is) {
//			$image_virt = $mosConfig_live_site."/components/com_zoom/www/images/filetypes/document.png";
//			$imgWidth = $imgHeight = 64;
//			$imgWidth = $imgHeight = 64;
//			$setwidth = " width=\"$imgWidth\""; //set image width
//			$setheight = " height=\"$imgHeight\""; // set image height
//			$ZoomString .= "<img src=\"".$image_virt."\"$setwidth$setheight border=\"0\"/></a>\n<br />".stripslashes($photoname)."\n";
		} elseif (ztmp3_isMovie($photo_tag)) {
			$image_virt = JURI::root()."components/com_zoom/www/images/filetypes/video.png";
			$imgWidth = $imgHeight = 64;
			$imgWidth = $imgHeight = 64;
			$setwidth = " width=\"$imgWidth\""; //set image width
			$setheight = " height=\"$imgHeight\""; // set image height
			$ZoomString .= "<img src=\"".$image_virt."\"$setwidth$setheight border=\"0\"/></a>\n<br />".stripslashes($photoname)."\n";
		}

		if($enhanced_Config['showzoomimagehits']==1) //Show hits?
		{
			$ZoomString .= "<br />"._UE_ZOOM_MP3_VIEWED."&nbsp;".$photo->imghits."&nbsp;"._UE_ZOOM_MP3_VIEWTIME. ($photo->imghits == 1 ? '' : _UE_ZOOM_MP3_PLURALIZE)."\n"; //to pluralize or not
			if($enhanced_Config['showzoomimagerating']==1) //show rating?
			{
				if($photo->votesum <1)
				{
					$ZoomString .= "<br />$zOOm_no_rating_label\n";
				}
				else
				{
					$ZoomString .= "<br />$zOOm_rating_label $photo->votesum\n";
				}
			}
		}
		if($my->id == $user->id)
		{
			$ZoomString .= "<br /><a href=\"index.php?option=com_cbe".$Itemid_c."&prof=$user->id&func=mp3_delzphoto&amp;pathid=$safepath&amp;picid=$photo->imgid\">"._UE_ZOOM_MP3_TAB_DELETE."</a>\n";
		}
		$ZoomString .= "</div>";
	}
	}
} else {
	 echo "<br /><center>"._UE_ZOOM_MP3_GALLERY_NO_PHOTOS_VISITOR."</center><br />";
}
$tablabelUpload = '';

if($user->id == $my->id)
{

	$tablabelUpload = "<a href=\"index.php?option=com_zoom".$Itemid_zoom."&amp;page=upload&amp;formtype=multiple\">$zOOm_upload_link_text</a>";
	
}

$upload_link = "<td align=\"right\">$tablabelUpload</td></tr>";
$zoom_final_display = $upload_link.$ZoomString;

echo $zoom_final_display.'</table>';
?>
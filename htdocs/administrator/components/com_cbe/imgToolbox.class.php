<?php
/**
-----------------------------------------------------------------------
|                                                                     |
| Date: March, 2005						      |
| Author: MamboJoe, <http://www.mambojoe.com>                         |
| Original Author: Mike de Boer, <http://www.mikedeboer.nl>           |
| Copyright: copyright (C) 2004 by Mike de Boer                       |
| Description: Abstracted Image Class			              |
| License: GPL                                                        |
| Filename: imgToolbox.class.php                                      |
| Version: 3.0                                                        |
|                                                                     |
-----------------------------------------------------------------------
-----------------------------------------------------------------------
|                                                                     |
| What is the toolbox? --> well, it's an object that bundles all      |
| medium-manipulation tools into one convenient class.                |
| These tools would include:                                          |
|                                                                     |
| - Image resizing                                                    |
| - Image rotating                                                    |
| - Image watermarking with custom TrueType fonts                     |
| - ALL tools have implementations for the following manipulation     |
|   software: ImageMagick, NetPBM, GD1.x and GD2.x.                   |
|                                                                     |
-----------------------------------------------------------------------
| convert to png added by phil_K June.2006			      |
-----------------------------------------------------------------------
**/
class imgToolbox{
	var $_platform = null;
	var $_isBackend = null;
	var $_conversiontype = null;
	var $_IM_path = null;
	var $_NETPBM_path = null;
	var $_JPEGquality = null;
	var $_err_num = null;
    	var $_err_names = array();
    	var $_err_types = array();
	var $_wmtext = null;
	var $_wmdatfmt = null;
	var $_wmfont = null;
	var $_wmfont_size = null;
	var $_wmrgbtext = null;
	var $_wmrgbtsdw = null;
	var $_wmhotspot = null;
	var $_wmtxp = null;
	var $_wmtyp = null;
	var $_wmsxp = null;
	var $_wmsyp = null;
    	var $_buffer = null;
	var $_filepath= null;
	var $_rotate = null;
	var $_maxsize = null;
	var $_maxwidth = null;
	var $_maxheight = null;
	var $_thumbwidth = null;
	var $_thumbheight = null;
	var $_errMSG = null;
	var $_debug = null;
	//sv0.6233 0.6234
	var $_wm2_force_png = null;
	var $_wm2_force_zoom = null;
	var $_wm2_canvas = null;
	var $_wm2_canvas_col = null;
	var $_wm2_canvas_coltr = null;
	var $_wm2_stampit = null;
	var $_wm2_stampit_txt = null;
	var $_wm2_stampit_size = null;
	var $_wm2_stampit_col = null;
	var $_wm2_stampit_cred = null;
	var $_wm2_stampit_cyellow = null;
	var $_wm2_stampit_crgreen = null;
	var $_wm2_doit = null;
	var $_wm2_img = null;


	
	function imgToolBox(){
		// constructor of the toolbox - primary init...
			$this->_conversiontype=1;
			$this->_rotate=0;
			$this->_IM_path = "auto";
			$this->_NETPBM_path = "auto";
			$this->_maxsize = 102400;
			$this->_maxwidth = 200;
			$this->_maxheight = 500;
			$this->_thumbwidth = 86;
			$this->_thumbheight = 60;
			$this->_JPEGquality = 85;
		// load watermark settings...
			$this->_wmtext = "[date]";
			$this->_wmfont = "ARIAL.TTF";
			$this->_wmfont_size = 12;
			$this->_wmrgbtext = "FFFFFF";
			$this->_wmrgbtsdw = "000000";
			$this->_wmhotspot = 8;
			$this->_wmdatfmt = "Y-m-d";
		// watermark offset coordinates...t = top and s = side.
			$this->_wmtxp = 0;
			$this->_wmtyp = 0;
			$this->_wmsxp = 1;
			$this->_wmsyp = 1;
		// watermark2 setups
			$this->_wm2_stampit_size = 1;
			$this->_wm2_stampit_cred = 255;
			$this->_wm2_stampit_cyellow = 255;
			$this->_wm2_stampit_crgreen = 255;
			
		// toolbox ready for use...
	}
    function processImage($image, $filename,$filepath, $rotate, $degrees = 0, $copyMethod = 1){
		// reset script execution time limit (as set in MAX_EXECUTION_TIME ini directive)...
		// requires SAFE MODE to be OFF!
		//die("filepath: $filepath " . print_r(debug_backtrace()));
		$this->_filepath=$filepath;
		if( ini_get( 'safe_mode' ) != 1 ){
			set_time_limit(0);
		}
		$error=0;
		$errorMSG=null;
		switch ($this->_conversiontype){
			//Imagemagick
			case 1:
				if($this->_IM_path == 'auto'){
					$this->_IM_path = '';
				}else{
					if($this->_IM_path){
						if(!is_dir($this->_IM_path)){
								$error=1;
								$errorMSG = "Error: your ImageMagick path is not correct! Please (re)specify it in the Admin-system under 'Settings'";
							}
					}
				}
				break;
			//NetPBM
			case 2:
				if($this->_NETPBM_path == 'auto'){
					$this->_NETPBM_path ='';
				}else{
					if($this->_NETPBM_path){
						if(!is_dir($this->_NETPBM_path)){
								$error=1;
								$errorMSG = "Error: your NetPBM path is not correct! Please (re)specify it in the Admin-system under 'Settings'";
							}
					}
				}
				break;
			//GD1
			case 3:
				if (!function_exists('imagecreatefromjpeg')) {
				    $error=1;
				    $errorMSG = "PHP running on your server does not support the GD image library, check with your webhost if ImageMagick is installed";
				}
				break;
			//GD2
			case 4:
				if (!function_exists('imagecreatefromjpeg')) {
				    $error=1;
				    $errorMSG = "Error: PHP running on your server does not support the GD image library, check with your webhost if ImageMagick is installed";
				}
				if (!function_exists('imagecreatetruecolor')) {
				    $error=1;
				    $errorMSG = "Error: PHP running on your server does not support GD version 2.x, please switch to GD version 1.x on the config page";
				}
				break;
		}
		if($error) {
			$this->raiseError($errorMSG);
                    	return false;
		}
		if(!$this->checkFilesize($image['tmp_name'],$this->_maxsize*1024)) {
			$this->raiseError("The file exceeds the maximum size of ".$this->_maxsize." kilobites");
                    	return false;
		}
			
		$filepath = $this->_filepath;  
		$filename = urldecode($filename);
        	// replace every space-character with a single "_"
	    	$filename = ereg_replace(" ", "_", $filename);
     		// Get rid of extra underscores
     		$filename = ereg_replace("_+", "_", $filename);
     		$filename = ereg_replace("(^_|_$)", "", $filename);
		$tag = ereg_replace(".*\.([^\.]*)$", "\\1", $image['name']);
		$tag = strtolower($tag);
		$filenamepng=$filename.".png";
		//$filename_ = $filenamepng;
		$filename=$filename.".".$tag;
		$filename_= $filename;
		$image=$image['tmp_name'];
        if($this->acceptableFormat($tag)){
            // File is an image/ movie/ document...
            $file = $this->_filepath.$filename;
            $filepng = $this->_filepath.$filenamepng;
            $thumbfile = $this->_filepath."tn".$filename;
            if($copyMethod == 1){
                if (!@move_uploaded_file($image, $file)){
                    // some error occured while moving file, register this...
			$this->raiseError("Error occurred during the moving of the uploaded file.");
                    	return false;
                }
            }elseif($copyMethod == 2){
                if (!@fs_copy($image, $file)){
                    // some error occured while moving file, register this...
                    $this->raiseError("Error occurred during the moving of the uploaded file.");
                    return false;
                }
            }
            @chmod($file, 0644);

           if($this->isImage($tag)){
           	$imginfo = getimagesize($file);
		// convert all to png -- Phil_K
		if ($this->_wm2_force_png != '1') {
			$this->_wm2_doit='0';
		}
			
		if ($tag != 'png' && $this->_wm2_force_png == '1') {
			if (!$this->_imgToPNG($file, $filepng)) {
				$this->raiseError("Error converting image to png.");
				return false;
			} else {
				@chmod($filepng, 0644);
				unlink($file);
				$file = $filepng;
				$filename_ = $filenamepng;
				$thumbfile = $this->_filepath."tn".$filenamepng;
			}
		}

               if($this->_rotate){
                   if(!$this->rotateImage($file, $file, $filename_, $degrees)){
                       $this->raiseError("Error rotating image");
                       return false;
                   }
               }
               // if the image size is greater than the given maximum: resize it!               
               if($imginfo[0] > $this->_maxwidth || $imginfo[1] > $this->_maxheight){
               		if(!$this->resizeImage($file, $file, $this->_maxwidth, $this->_maxheight, $filename_)){
               		   $this->raiseError("Error: resizing image failed - 1.");
	                   return false;
               		}
               }
               // resize to fit picture frame ( forced / Phil_K )
             	if($this->_wm2_force_zoom == '1' && ($imginfo[0] < $this->_maxwidth || $imginfo[1] < $this->_maxheight)){
			if(!$this->resizeImage($file, $file, $this->_maxwidth, $this->_maxheight, $filename_)){
				$this->raiseError("Error: resizing image failed - 2.");
				return false;
			}
		}

		if ($this->testWMbasic() && $this->_wm2_canvas=='1' && $this->_wm2_force_png=='1') {
			if(!$this->doCanvas($file, $this->_maxwidth, $this->_maxheight, $this->_wm2_canvas_col, $this->_wm2_canvas_coltr)) {
				$this->raiseError("Error: Canvas-add failed.");
				return false;
			}
		}
               
               // resize to thumbnail...
		if(!$this->resizeImage($file, $thumbfile, $this->_thumbwidth, $this->_thumbheight, $filename_)){
			$this->raiseError("Error: resizing thumbnail image failed.");
			return false;
		}
		@chmod($thumbfile, 0644);

		// do watermark on main image
		if ($this->testWMbasic() && $this->_wm2_doit=='1') {
			$watermark = $this->_filepath."watermark/".$this->_wm2_img;
			if (!$this->watermark2($file, $watermark, $this->_maxwidth, $this->_maxheight)) {
				$this->raiseError("Error: watermarking image failed.");
				return false;
			}
		}


           }
        }else{
            //Not the right format, register this...
            $this->raiseError("Error: ".$tag." is not a supported format.");;
            return false;
        }
        return $filename_;
    }
	function acceptableFormat($tag){
		return ($this->isImage($tag));
	}
	function isImage($tag){
	    return in_array($tag, $this->acceptableImageList());
	}
	function acceptableImageList(){
	    return array('jpg', 'jpeg', 'gif', 'png');
	}
	function resizeImage($file, $desfile, $maxWidth, $maxHeight, $filename = ""){
		list($width, $height) = @getimagesize($file);

		if( $width > $maxWidth & $height <= $maxHeight )
		{
			$ratio = $maxWidth / $width;
		}
		elseif( $height > $maxHeight & $width <= $maxWidth )
		{
			$ratio = $maxHeight / $height;
		}
		elseif( $width > $maxWidth & $height > $maxHeight )
		{
			$ratio1 = $maxWidth / $width;
			$ratio2 = $maxHeight / $height;
			$ratio = ($ratio1 < $ratio2)? $ratio1:$ratio2;
		}
		// sv0.6234
		elseif (($width < $maxWidth & $height < $maxHeight) && $this->_wm2_force_zoom == '1')
		{
			$ratio1 = $maxWidth / $width;
			$ratio2 = $maxHeight / $height;
			$ratio = ($ratio1 < $ratio2) ? $ratio1 : $ratio2;
		}
		//
		else
		{
			$ratio = 1;
		}

		//if ($width < $maxWidth & $height < $maxHeight) {
		//	$nWidth = $maxWidth;
		//	$nHeight = $maxHeight;
		//} else {
			$nWidth = floor($width*$ratio);
			$nHeight = floor($height*$ratio);
		//}

		switch ($this->_conversiontype){
			//Imagemagick
			case 1:
				if($this->resizeImageIM($file, $desfile, $nWidth,$nHeight))
					return true;
				else
					return false;
				break;
			//NetPBM
			case 2:
				if($this->resizeImageNETPBM($file,$desfile,$nWidth,$nHeight,$filename))
					return true;
				else
					return false;
				break;
			//GD1
			case 3:
				if($this->resizeImageGD1($file, $desfile, $nWidth,$nHeight))
					return true;
				else
					return false;
				break;
			//GD2
			case 4:
				if($this->resizeImageGD2($file, $desfile, $nWidth,$nHeight))
					return true;
				else
					return false;
				break;
		}
		return true;
	}
	function resizeImageIM($src_file, $dest_file, $destWidth,$destHeight){
		//$cmd = $this->_IM_path."convert -resize $new_size \"$src_file\" \"$dest_file\"";
   		$cmd = "'".$this->_IM_path."convert' -geometry ".$destWidth."x".$destHeight." '$src_file' '$dest_file'"; 
		$output=array();
		exec($cmd, $output, $retval);
		if($this->debug()) {
			echo "<div>cmd=$cmd<br/>output=". join("\n", $output)."</div>";
		}
		return true;
	}
	function resizeImageNETPBM($src_file,$des_file,$destWidth,$destHeight,$orig_name){
		$quality = $this->_JPEGquality;
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) {
			$this->raiseError("Error: Unable to execute getimagesize function");
			return false;
		}
		if (eregi("\.png", $orig_name)){
			$cmd = $this->_NETPBM_path . "pngtopnm $src_file | " . $this->_NETPBM_path . "pnmscale -xysize $destWidth $destHeight | " . $this->_NETPBM_path . "pnmtopng > $des_file" ; 
		}
		else if (eregi("\.(jpg|jpeg)", $orig_name)){
			$cmd = $this->_NETPBM_path . "jpegtopnm $src_file | " . $this->_NETPBM_path . "pnmscale -xysize $destWidth $destHeight | " . $this->_NETPBM_path . "ppmtojpeg -quality=$quality > $des_file" ;
	}
		else if (eregi("\.gif", $orig_name)){
			$cmd = $this->_NETPBM_path . "giftopnm $src_file | " . $this->_NETPBM_path . "pnmscale -xysize $destWidth $destHeight | " . $this->_NETPBM_path . "ppmquant 256 | " . $this->_NETPBM_path . "ppmtogif > $des_file" ; 
		}else{
			$this->raiseError("Error: NetPBM doesn't support this file type.");
			return false;
		}
		$output = array();
		//echo $cmd;	
		exec($cmd, $output, $retval);
		if($this->debug()) {
			echo "<div>cmd=$cmd<br/>output=". join("\n", $output)."</div>";
		}
			return true;
	}
	function resizeImageGD1($src_file, $dest_file, $destWidth,$destHeight){
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) {
			$this->raiseError("Error: Unable to execute getimagesize function");
			return false;
		}
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 2 && $imginfo[2] != 3 && ($imginfo[2] == 1 && !function_exists(imagecreatefromgif))){
			$this->raiseError("Error: GD1 doesn't support this file type.");
			return false;
		}
		if ($imginfo[2] == 2)
			$src_img = imagecreatefromjpeg($src_file);
		elseif ($imginfo[2] == 1)
			$src_img = imagecreatefromgif($src_file);
		else
			$src_img = imagecreatefrompng($src_file);
		if (!$src_img) {
			$this->raiseError("Error: GD1 Unable to create image from imagetype function");
			return false;
		}
		$dst_img = imagecreate($destWidth, $destHeight);
		imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $destWidth, $destHeight, $imginfo[0], $imginfo[1]);
		if ($imginfo[2] == 2)
			imagejpeg($dst_img, $dest_file, $this->_JPEGquality);
		elseif ($imginfo[2] == 1)
			imagegif($dst_img, $dest_file);
		else
			imagepng($dst_img, $dest_file);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		return true; 
	}
	function resizeImageGD2($src_file, $dest_file, $destWidth,$destHeight){
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) {
			$this->raiseError("Error: Unable to execute getimagesize function");
			return false;
		}
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 2 && $imginfo[2] != 3 && ($imginfo[2] == 1 && !function_exists(imagecreatefromgif))){
			$this->raiseError("Error: GD2 Unable to create image from imagetype function");
			return false;
		}
		if ($imginfo[2] == 2)
			$src_img = imagecreatefromjpeg($src_file);
		elseif ($imginfo[2] == 1)
			$src_img = imagecreatefromgif($src_file);
		else
			$src_img = imagecreatefrompng($src_file);
		if (!$src_img) {
			$this->raiseError("Error: GD2 Unable to create image from imagetype function");
			return false;
		}
		$dst_img = imagecreatetruecolor($destWidth, $destHeight);
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, $destHeight, $imginfo[0], $imginfo[1]);
		if ($imginfo[2] == 2)
			imagejpeg($dst_img, $dest_file, $this->_JPEGquality);
		elseif ($imginfo[2] == 1)
			imagegif($dst_img, $dest_file);
		else
			imagepng($dst_img, $dest_file);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		return true;
	}
	function rotateImage($file, $desfile, $filename, $degrees){
		$degrees = intval($degrees);
		switch ($this->_conversiontype){
			//Imagemagick
			case 1:
				if($this->rotateImageIM($file, $desfile, $degrees))
					return true;
				else
					return false;
				break;
			//NetPBM
			case 2:
				if($this->rotateImageNETPBM($file,$desfile, $filename, $degrees))
					return true;
				else
					return false;
				break;
			//GD1
			case 3:
				if($this->rotateImageGD1($file, $desfile, $degrees))
					return true;
				else
					return false;
				break;
			//GD2
			case 4:
				if($this->rotateImageGD2($file, $desfile, $degrees))
					return true;
				else
					return false;
				break;
		}
		return true;
	}
	function checkFilesize($file,$maxSize) {
	   $size = filesize($file);
	   if($size <= $maxSize) {
	      return true;
	   }
	   return false;
	}

	function rotateImageIM($file, $desfile, $degrees){
		$cmd = $this->_IM_path."convert -rotate $degrees \"$file\" \"$desfile\"";
		exec($cmd, $output, $retval);
		if($retval)
			return false;
		else
			return true;
	}
	function rotateImageNETPBM($file, $desfile, $filename, $degrees){
		$quality = $this->_JPEGquality;
		$fileOut = "$file.1";
		fs_copy($file,$fileOut); 
		if (eregi("\.png", $filename)){
			$cmd = $this->_NETPBM_path . "pngtopnm $file | " . $this->_NETPBM_path . "pnmrotate $degrees | " . $this->_NETPBM_path . "ppmtopng > $fileOut" ; 
		}
		else if (eregi("\.(jpg|jpeg)", $filename)){
			$cmd = $this->_NETPBM_path . "jpegtopnm $file | " . $this->_NETPBM_path . "pnmrotate $degrees | " . $this->_NETPBM_path . "ppmtojpeg -quality=$quality > $fileOut" ;
		}
		else if (eregi("\.gif", $orig_name)){
			$cmd = $this->_NETPBM_path . "giftopnm $file | " . $this->_NETPBM_path . "pnmrotate $degrees | " . $this->_NETPBM_path . "ppmquant 256 | " . $this->_NETPBM_path . "ppmtogif > $fileOut" ; 
		}else{
			return false;
		}
		exec($cmd, $output, $retval);
		if($retval){
			return false;
		}else{
			$erg = fs_rename($fileOut, $desfile); 
			return true;
		}
	}
	function rotateImageGD1($file, $desfile, $degrees){
		$imginfo = getimagesize($file);
		if ($imginfo == null)
			return false;
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 2 && $imginfo[2] != 3){
			return false;
		}
		if ($imginfo[2] == 2)
			$src_img = imagecreatefromjpeg($file);
		else
			$src_img = imagecreatefrompng($file);
		if (!$src_img)
			return false;
		// The rotation routine...
		$src_img = imagerotate($src_img, $degrees, 0);
		$dst_img = imagecreate($imginfo[0], $imginfo[1]);
		imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
		if ($imginfo[2] == 2)
			imagejpeg($dst_img, $desfile, $this->_JPEGquality);
		else
			imagepng($dst_img, $desfile);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		return true; 
	}
	function rotateImageGD2($file, $desfile, $degrees){
		$imginfo = getimagesize($file);
		if ($imginfo == null)
			return false;
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 2 && $imginfo[2] != 3){
			return false;
		}
		if ($imginfo[2] == 2)
			$src_img = imagecreatefromjpeg($file);
		else
			$src_img = imagecreatefrompng($file);
		if (!$src_img)
			return false;
		// The rotation routine...
		$src_img = imagerotate($src_img, $degrees, 0);
		$dst_img = imagecreatetruecolor($imginfo[0], $imginfo[1]);
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
		if ($imginfo[2] == 2)
			imagejpeg($dst_img, $desfile, $this->_JPEGquality);
		else
			imagepng($dst_img, $desfile);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		return true;
	}
	// watermark by Elf Qrin ( http://www.ElfQrin.com/ ) - modified for use with zOOm.
	function watermark($file, $desfile) {
		$suffx = substr($file,strlen($file)-4,4);
		if ($suffx == ".jpg" || $suffx == "jpeg" || $suffx == ".png") {
			$text = str_replace("[date]",date($this->_wmdatfmt),$this->_wmtext);
			if ($suffx == ".jpg" || $suffx == "jpeg") {
				$image = imagecreatefromjpeg($file);
			}
			if ($suffx == ".png") {
				$image = imagecreatefrompng($file);
			}
			$rgbtext = HexDec($this->_wmrgbtext);
			$txtr = floor($rgbtext/pow(256,2));
			$txtg = floor(($rgbtext%pow(256,2))/pow(256,1));
			$txtb = floor((($rgbtext%pow(256,2))%pow(256,1))/pow(256,0));
			
			$rgbtsdw = HexDec($this->_wmrgbtsdw);
			$tsdr = floor($rgbtsdw/pow(256,2));
			$tsdg = floor(($rgbtsdw%pow(256,2))/pow(256,1));
			$tsdb = floor((($rgbtsdw%pow(256,2))%pow(256,1))/pow(256,0));
			
			$coltext = imagecolorallocate($image,$txtr,$txtg,$txtb);
			$coltsdw = imagecolorallocate($image,$tsdr,$tsdg,$tsdb);
			
			if ($this->_wmhotspot != 0) {
				$ix = imagesx($image);
				$iy = imagesy($image);
				$tsw = strlen($text)*$this->_wmfont_size/imagefontwidth($this->_wmfont)*3;
				$tsh = $this->_wmfont_size/imagefontheight($this->_wmfont);
				switch ($this->_wmhotspot) {
					case 1:
						$txp = $this->_wmtxp;
						$typ = $tsh*$tsh+imagefontheight($this->_wmfont)*2+$this->_wmtyp;
						break;
					case 2:
						$txp = floor(($ix-$tsw)/2);
						$typ = $tsh*$tsh+imagefontheight($this->_wmfont)*2+$this->_wmtyp;
						break;
					case 3:
						$txp = $ix-$tsw-$txp;
						$typ = $tsh*$tsh+imagefontheight($this->_wmfont)*2+$this->_wmtyp;
						break;
					case 4:
						$txp = $this->_wmtxp;
						$typ = floor(($iy-$tsh)/2);
						break;
					case 5:
						$txp = floor(($ix-$tsw)/2);
						$typ = floor(($iy-$tsh)/2);
						break;
					case 6:
						$txp = $ix-$tsw-$this->_wmtxp;
						$typ = floor(($iy-$tsh)/2);
						break;
					case 7:
						$txp = $this->_wmtxp;
						$typ = $iy-$tsh-$this->_wmtyp;
						break;
					case 8:
						$txp = floor(($ix-$tsw)/2);
						$typ = $iy-$tsh-$this->_wmtyp;
						break;
					case 9:
						$txp = $ix-$tsw-$this->_wmtxp;
						$typ = $iy-$tsh-$this->_wmtyp;
						break;
				}
			}
			ImageTTFText($image, $this->_wmfont_size, 0, $txp+$sxp, $typ+$syp, $coltsdw, $this->_wmfont,$text);
			ImageTTFText($image, $this->_wmfont_size, 0, $txp, $typ, $coltext, $this->wmfont, $text);	
			if ($suffx == ".jpg" || $suffx == "jpeg") {
				imagejpeg($image, $desfile, $this->_JPEGquality);
			}elseif($suffx == ".png"){
				imagepng($image, $desfile);
			}
			imagedestroy($image);
			return true;
		}else{
			return false;
		}
	}
	function parseDir($dir){
		global $zoom;
		// start the scan...(open the local dir)
		$images = array();
		$handle = fs_opendir($dir);
		while (($file = readdir($handle)) != false) {
			if ($file != "." && $file != "..") {
				$tag = ereg_replace(".*\.([^\.]*)$", "\\1", $file);
				$tag = strtolower($tag);
				if ($zoom->acceptableFormat($tag)) {
					// Tack it onto images...
					$images[] = $file;
				}
			}
		}
		closedir($handle);
		return $images;
	}
	function getImageLibs(){
		// do auto-detection on the available graphics libraries
		// This assumes the executables are within the shell's path
		$imageLibs= array();
		// do various tests:
		if ($testIM = $this->testIM()) {
			$imageLibs['imagemagick'] = $testIM;
		}
		if ($testNetPBM = $this->testNetPBM()) {
			$imageLibs['netpbm'] = $testNetPBM;
		}			
		$imageLibs['gd'] = $this->testGD();		
		return $imageLibs;
	}
	function testIM(){
		exec('convert -version', $output, $status);
		if(!$status){
			if(preg_match("/imagemagick[ \t]+([0-9\.]+)/i",$output[0],$matches))
			   return $matches[0];
		}
		unset($output, $status);
	}
	function testNetPBM(){
		exec('jpegtopnm -version 2>&1',  $output, $status);
		if(!$status){
			if(preg_match("/netpbm[ \t]+([0-9\.]+)/i",$output[0],$matches))
			   return $matches[0];
		}
		unset($output, $status);
	}
	function testGD(){
		$gd = array();
		$GDfuncList = get_extension_funcs('gd');
		ob_start();
		@phpinfo(INFO_MODULES);
		$output=ob_get_contents();
		ob_end_clean();
		$matches[1]='';
		if(preg_match("/GD Version[ \t]*(<[^>]+>[ \t]*)+([^<>]+)/s",$output,$matches)){
			$gdversion = $matches[2];
		}

		if (function_exists('imagecreatetruecolor') && function_exists('imagecreatefromjpeg')) {
			$gd['gd2'] = $gdversion;
		} elseif (function_exists('imagecreatefromjpeg')) {
			$gd['gd1'] = $gdversion;
		}
		/*
		

		*/
		return $gd;
	}
	// --- test basic image functions -- Phil_K ------- //
	function testWMbasic() {
		if (function_exists('imagecreatefrompng') && function_exists('imagecreatetruecolor')) {
			return true;
		} else {
			return false;
		}
	}
	
	function strip_nulls( $str ){
		$res = explode( chr(0), $str );
		return chop( $res[0] );
	}
	//--------------------Error handling functions-------------------------//
	function debug() {
		if($this->_debug) return true;
		else return false;

	}
	function raiseError($errorMSG) {
		$this->_errMSG=$errorMSG;
		return true;
	}


	function displayErrors(){
		if ($this->_err_num <> 0){
			echo '<center><table border="0" cellpadding="3" cellspacing="0" width="70%">';
			echo '<tr class="sectiontableheader"><td width="100" align="left">Image Name</td><td align="left">Error type</td></tr>';
			$tabcnt = 0;
			for ($x = 0; $x <= $this->_err_num; $x++){
				echo '<tr align="left"><td>'.$this->_err_names[$x].'</td><td align="left">'.$this->_err_types[$x].'</td></tr>';
				if ($tabcnt == 1){
	    			$tabcnt = 0;
				} else {
					$tabcnt++;
	    		}
			}
			echo "</table></center>";
		}
	}
	//--------------------END error handling functions----------------------//
	//--------------------START convert to png ------------------------------//
	function _imgToPNG($file, $desfile) {
		switch ($this->_conversiontype){
		//Imagemagick
		case 1:
			if($this->_imgToPNG_IM($file, $desfile))
				return true;
			else
				return false;
			break;
		//NetPBM
		case 2:
			if($this->_imgToPNG_NETPBM($file,$desfile))
				return true;
			else
				return false;
			break;
		//GD1
		case 3:
			if($this->_imgToPNG_GD1($file, $desfile))
				return true;
			else
				return false;
			break;
		//GD2
		case 4:
			if($this->_imgToPNG_GD2($file, $desfile))
				return true;
			else
				return false;
			break;
		}
		return true;
	}
	
	function _imgToPNG_IM($src_file, $dest_file) {
		$cmd = "'".$this->_IM_path."convert' '".$src_file."[0]' '$dest_file'"; 
		$output=array();
		exec($cmd, $output, $retval);
		if($this->debug()) {
			echo "<div>cmd=$cmd<br/>output=". join("\n", $output)."</div>";
		}
		return true;
	}

	function _imgToPNG_NETPBM($src_file,$des_file){
		$quality = $this->_JPEGquality;
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) {
			$this->raiseError("Error: Unable to execute getimagesize function");
			return false;
		}
		if (eregi("\.png", $orig_name)){
			$cmd = $this->_NETPBM_path . "pngtopnm $src_file | " . $this->_NETPBM_path . "pnmtopng > $des_file" ;
		}
		else if (eregi("\.(jpg|jpeg)", $orig_name)){
			$cmd = $this->_NETPBM_path . "jpegtopnm $src_file | " . $this->_NETPBM_path . "pnmtopng > $des_file" ;
		}
		else if (eregi("\.gif", $orig_name)){
			$cmd = $this->_NETPBM_path . "giftopnm $src_file | " . $this->_NETPBM_path . "pnmtopng > $des_file" ;
		}else{
			$this->raiseError("Error: NetPBM doesn't support this file type.");
			return false;
		}
		$output = array();
		//echo $cmd;	
		exec($cmd, $output, $retval);
		if($this->debug()) {
			echo "<div>cmd=$cmd<br/>output=". join("\n", $output)."</div>";
		}
		return true;
	}

	function _imgToPNG_GD1($src_file, $dest_file){
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) {
			$this->raiseError("Error: Unable to execute getimagesize function");
			return false;
		}
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 2 && $imginfo[2] != 3 && ($imginfo[2] == 1 && !function_exists(imagecreatefromgif))){
			$this->raiseError("Error: GD1 doesn't support this file type.");
			return false;
		}
		if ($imginfo[2] == 2)
			$src_img = imagecreatefromjpeg($src_file);
		elseif ($imginfo[2] == 1)
			$src_img = imagecreatefromgif($src_file);
		else
			$src_img = imagecreatefrompng($src_file);
		if (!$src_img) {
			$this->raiseError("Error: GD1 Unable to create image from imagetype function");
			return false;
		}
		$dst_img = imagecreate($imginfo[0],$imginfo[1]);
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $imginfo[0], $imginfo[1], $imginfo[0], $imginfo[1]);
		imagepng($dst_img, $dest_file);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		return true; 
	}
	function _imgToPNG_GD2($src_file, $dest_file){
		$imginfo = getimagesize($src_file);
		if ($imginfo == null) {
			$this->raiseError("Error: Unable to execute getimagesize function");
			return false;
		}
		// GD can only handle JPG & PNG images
		if ($imginfo[2] != 2 && $imginfo[2] != 3 && ($imginfo[2] == 1 && !function_exists(imagecreatefromgif))){
			$this->raiseError("Error: GD2 Unable to create image from imagetype function");
			return false;
		}
		if ($imginfo[2] == 2)
			$src_img = imagecreatefromjpeg($src_file);
		elseif ($imginfo[2] == 1)
			$src_img = imagecreatefromgif($src_file);
		else
			$src_img = imagecreatefrompng($src_file);
		if (!$src_img) {
			$this->raiseError("Error: GD2 Unable to create image from imagetype function");
			return false;
		}
		$dst_img = imagecreatetruecolor($imginfo[0],$imginfo[1]);
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $imginfo[0],$imginfo[1], $imginfo[0], $imginfo[1]);
		imagepng($dst_img, $dest_file);
		imagedestroy($src_img);
		imagedestroy($dst_img);
		return true;
	}
	
	//--------------------END convert to png ------------------------------//
	//--------------------Start do canvas  ------------------------------//
	function doCanvas($src_file, $maxWidth, $maxHeight, $canCol, $canColtrans) {
		$srcfile_id = imagecreatefrompng($src_file);
		$sourcefile_width=imageSX($srcfile_id);
		$sourcefile_height=imageSY($srcfile_id);

		$underlay = imagecreatetruecolor($maxWidth,$maxHeight);
		//if ($canColtrans == '1') {
		//	imagetruecolortopalette($underlay, false, 256);
		//}
		if ($canCol !='') {
			$canv_red = hexdec(substr($canCol,0,2));
			$canv_yellow = hexdec(substr($canCol,2,2));
			$canv_green = hexdec(substr($canCol,4,2));
			$canvas_col = imagecolorallocate($underlay,$canv_red,$canv_yellow,$canv_green);
			imagefill($underlay,0,0,$canvas_col);
		} else {
			$canvas_col = imagecolorallocate($underlay,0,0,0);
			imagefill($underlay,0,0,$canvas_col);
		}

		//if ($canColtrans == '1') {
		//	imagecolortransparent($underlay, $canvas_col);
		//}

		$x_pos = ($maxWidth - $sourcefile_width) / 2;
		$y_pos = ($maxHeight - $sourcefile_height) / 2;
		imagecopy($underlay, $srcfile_id, $x_pos, $y_pos, 0, 0, $sourcefile_width, $sourcefile_height);

		imagepng($underlay, $src_file);
		imagedestroy($srcfile_id);
		imagedestroy($underlay);
		return true;		
	}
	
	//--------------------Start do canvas  ------------------------------//
	//--------------------Start watermark2  ------------------------------//
	function watermark2($sourcefile, $watermarkfile, $maxWidth, $maxHeight) {
		
		#
		# $sourcefile = Filename of the picture to be watermarked.
		# $watermarkfile = Filename of the 24-bit PNG watermark file.
		# I recommend creating a white logo or text over a transparent 
		# background in Photoshop.  Save this as a 24-bit PNG via 
		# 'Save for the Web...'.  Be sure to set the transparency of the 
		# logo layer in Photoshop itself.  30-40% is a good setting.
		
		//Get the resource ids of the pictures
		if (!file_exists($watermarkfile)) {
			echo "Watermarkfile:<br>";
			print_r($watermarkfile);
			return false;
		}
		$watermarkfile_id = imagecreatefrompng($watermarkfile);
		
		imageAlphaBlending($watermarkfile_id, false);
		imageSaveAlpha($watermarkfile_id, true);
		
		$fileType = strtolower(substr($sourcefile, strlen($sourcefile)-3));
		
		switch($fileType) {
			case('png'):
				$sourcefile_id = imagecreatefrompng($sourcefile);
				break;
			    
			default:
				$sourcefile_id = imagecreatefrompng($sourcefile);
		}
		
		//Get the sizes of both pix  
		$sourcefile_width=imageSX($sourcefile_id);
		$sourcefile_height=imageSY($sourcefile_id);
		$watermarkfile_width=imageSX($watermarkfile_id);
		$watermarkfile_height=imageSY($watermarkfile_id);
		
		$dest_x = ( $sourcefile_width / 2 ) - ( $watermarkfile_width / 2 );
		$dest_y = ( $sourcefile_height / 2 ) - ( $watermarkfile_height / 2 );
		
		imagecopy($sourcefile_id, $watermarkfile_id, $dest_x, $dest_y, 0, 0, $watermarkfile_width, $watermarkfile_height);
		if ($this->_wm2_stampit) {
			$dest_x_text = 5;
			$dest_y_text = $sourcefile_height - 5;
			$txtcol = imagecolorallocate($sourcefile_id,$this->_wm2_stampit_cred,$this->_wm2_stampit_cyellow,$this->_wm2_stampit_cgreen);
			$text = $this->_wm2_stampit_txt;
			imagestringup($sourcefile_id, $this->_wm2_stampit_size, $dest_x_text, $dest_y_text, $text, $txtcol );
		}

		//Create a jpeg out of the modified picture
		switch($fileType) {
			// remember we don't need gif any more, so we use only png or jpeg.
			// See the upsaple code immediately above to see how we handle gifs
			case('png'):
				imagepng ($sourcefile_id, $sourcefile);
		        	break;
		        
			default:
				imagepng ($sourcefile_id, $sourcefile);
		}

		imagedestroy($sourcefile_id);
		imagedestroy($watermarkfile_id);
		
		return true;
	}


	//--------------------END watermark2  ------------------------------//
}

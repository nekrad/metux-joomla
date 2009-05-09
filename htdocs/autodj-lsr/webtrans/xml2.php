<?php 

/*
// +--------------------------------------------------------------------------+
// | Project:    Webtrans - Webinterface for sc_trans_linux                   |
// +--------------------------------------------------------------------------+
// | This file is part of Webtrans. Webtrans is a web interface for           |
// | sc_trans_linux from shoutcast.com. This interface should make it         |
// | easyer to handle the playlists and config files.                         |
// |                                                                          |
// | Webtrans is free software; you can redistribute it and/or modify         |
// | it under the terms of the GNU General Public License as published by     |
// | the Free Software Foundation; either version 2 of the License, or        |
// | (at your option) any later version.                                      |
// |                                                                          |
// | Webtrans is distributed in the hope that it will be useful,              |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with Webtrans; if not, write to the Free Software Foundation,      |
// | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA            |
// +--------------------------------------------------------------------------+
// | Obige Zeilen dürfen nicht entfernt werden!    Do not remove above lines! |
// +--------------------------------------------------------------------------+
*/

include('loginauth.php');
header("Content-type:text/xml"); print("<?xml version=\"1.0\"?>");

include_once("config.php");

//	echo $dirName;
//	echo $url_var;

$file = $soundbase."/sc_trans.conf";

$filehandle = fopen ($file, "r+");
$contents = fread($filehandle, filesize($file));
fclose($filehandle);

strtok($contents, "=");
$tok = strtok("=");
$PlaylistFile = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
		$PlaylistFile .= $tok[$i];
	}
}

$filehandle = fopen($soundbase."/".$PlaylistFile, "r");
$contents = fread($filehandle, filesize($soundbase."/".$PlaylistFile));
//var_dump($contents);
$entrys = explode("\n",$contents);	

//	var_dump($entrys);
//    natsort($entrys);
	print("<tree id='0'>");
	$inta = 0;
	
    foreach($entrys as $entry)
    {
		$inta ++;
		
		$entry1 = str_replace($soundfiles."/", "", $entry);
		
		if($entry1 != "")
			print("<item child='0' id='".$entry1."' text='".$entry1."'></item>");
    }

	
fclose($filehandle);	
	

 
			 
print("</tree>");
?> 

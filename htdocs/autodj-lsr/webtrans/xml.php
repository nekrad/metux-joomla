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
include_once("config.php");
header("Content-type:text/xml"); print("<?xml version=\"1.0\"?>");
print("<tree id='0'>");

getdir( $soundfiles );

print("</tree>");

function getdir($dir) {

	$handle = opendir($dir);
	
    while($entry = readdir($handle))
    {
		
        $entrys[] = $entry;
    }
    natsort($entrys);
	echo "<!-- ".$dir." -->";
	
	//$finfo = finfo_open(FILEINFO_NONE, "/usr/share/file/magic"); 
	$inta = 0;
	
    foreach($entrys as $entry)
    {
		$inta ++;
		
        if ($entry != "." && $entry != ".." && substr($entry, 0, 1) != ".")
        {
			//echo $dirName.$entry;
           if (@is_dir($dir."/".$entry))
            {
                  print("<item id='".$dir."/".$entry."' text='".$entry."'>");
				  getdir($dir."/".$entry);
				  print("</item>\n");
            }
           else {
		   		
				//$type = finfo_file($finfo, $dir."/".$entry);
				$type = strtoupper(substr($entry,-3));
				//echo $type;
				if($type == "MP3") {
			   		print("<item id='".$dir."/".$entry."' text='".$entry."'></item>\n");
        		}
			}
		}
    }
    closedir($handle);
}

?> 

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
include("config.php");

if(substr($_SERVER['HTTP_REFERER'], -21) == "editplay.php?mode=add")
{
//var_dump($_POST);
$ss = $_POST['arv']; 
$ss = urldecode($ss);


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

$filehandle = fopen($soundbase."/".$PlaylistFile, "w+");

$tok = explode(',',$ss);

foreach ($tok as $playlistentry) {

	fwrite($filehandle, "$playlistentry\n");
	}
fclose($filehandle);
}
		$hostname = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['PHP_SELF']);
		//header('Location: 
		//echo ('http://'.$hostname.($path == '/' ? '' : $path).'/editplay.php');
       	//header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/editplay.php');
       echo ('
	   	<html>
		<head>
		</head>
		<body>
		<script language="javascript">
		top.location="index.php";
		</script>
		</body>
		</html>
	   	
		');

</script>

	   

?>
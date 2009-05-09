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
?>
<head>
<title>Untitled Document</title>
</head>
<body>

<?php

include_once("functions.php");
include_once("config.php");

$PlaylistFile = getRequestVar('PlaylistFile');
$ServerIP = getRequestVar('ServerIP');
$ServerPort = getRequestVar('ServerPort');
$Password = getRequestVar('Password');
$StreamTitle = getRequestVar('StreamTitle');
$StreamURL = getRequestVar('StreamURL');
$Genre = getRequestVar('Genre');
$LogFile = getRequestVar('LogFile');
$Shuffle = getRequestVar('Shuffle');
$Bitrate = getRequestVar('Bitrate');
$InputSamplerate = getRequestVar('InputSamplerate');
$InputChannels = getRequestVar('InputChannels');
$Quality = getRequestVar('Quality');
$CrossfadeMode = getRequestVar('CrossfadeMode');
$CrossfadeLength = getRequestVar('CrossfadeLength');
$UseID3 = getRequestVar('UseID3');
$Public = getRequestVar('Public');
$AIM = getRequestVar('AIM');
$ICQ = getRequestVar('ICQ');
$IRC = getRequestVar('IRC');

//echo $IRC;
//echo $UseID3;




//$contents = fread($filehandle, filesize($file));

$out = "PlaylistFile=".$PlaylistFile."\nServerIP=".$ServerIP."\nServerPort=".$ServerPort."\nPassword=".$Password."\nStreamTitle=".$StreamTitle."\nStreamURL=".$StreamURL."\nGenre=".$Genre."\nLogFile=".$LogFile."\nShuffle=".$Shuffle."\nBitrate=".$Bitrate."\nInputSamplerate=".$InputSamplerate."\nInputChannels=".$InputChannels."\nQuality=".$Quality."\nCrossfadeMode=".$CrossfadeMode."\nCrossfadeLength=".$CrossfadeLength."\nUseID3=".$UseID3."\nPublic=".$Public."\nAIM=".$AIM."\nICQ=".$ICQ."\nIRC=".$IRC;

//echo $out;
$filehandle = fopen ($soundbase."/sc_trans.conf", "w");
fwrite($filehandle, $out);

fclose($filehandle);

echo " SC_TRANS configuration saved.<br>";



?>
<form name="form1" method="post" action="editconf.php">
  <input type="submit" name="Ok" value="Ok">
</form>
</body>
</html>

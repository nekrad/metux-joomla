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
<title>Edit SC_TRANS Configuration</title>
</head>
<body>
<?php
//include("./webtrans.php");
include_once("config.php");

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
$tok = strtok("=");
$ServerIP = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$ServerIP .= $tok[$i];
	}
}

$tok = strtok("=");
$ServerPort = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$ServerPort .= $tok[$i];
	}
}

$tok = strtok("=");
$Password = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$Password .= $tok[$i];
	}
}
$tok = strtok("=");
$StreamTitle = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$StreamTitle .= $tok[$i];
	}
}
$tok = strtok("=");
$StreamURL = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$StreamURL .= $tok[$i];
	}
}
$tok = strtok("=");
$Genre = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$Genre .= $tok[$i];
	}
}
$tok = strtok("=");
$LogFile = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$LogFile .= $tok[$i];
	}
}
$tok = strtok("=");
$Shuffle = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$Shuffle .= $tok[$i];
	}
}

$tok = strtok("=");
$Bitrate = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$Bitrate .= $tok[$i];
	}
}

$tok = strtok("=");
$InputSamplerate = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$InputSamplerate .= $tok[$i];
	}
}

$tok = strtok("=");
$InputChannels = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$InputChannels .= $tok[$i];
	}
}

$tok = strtok("=");
$Quality = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$Quality .= $tok[$i];
	}
}

$tok = strtok("=");
$CrossfadeMode = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$CrossfadeMode .= $tok[$i];
	}
}
$tok = strtok("=");
$CrossfadeLength = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$CrossfadeLength .= $tok[$i];
	}
}
$tok = strtok("=");
$UseID3 = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$UseID3 .= $tok[$i];
	}
}

$tok = strtok("=");
$Public = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$Public .= $tok[$i];
	}
}
$tok = strtok("=");
$AIM = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$AIM .= $tok[$i];
	}
}
$tok = strtok("=");
$ICQ = "";
if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != "\n"; $i++) {
	$ICQ .= $tok[$i];
	}
}
$tok = strtok("=");

$IRC = "";

if($tok[0] != '\n') {
	for($i = 0; $tok[$i] != '\n' && $i <= strlen($tok); $i++) {
	$IRC .= $tok[$i];
	}
}

echo "<br>";
//for($i = 0; $i == '\0'; $i++)
//{
	
?>


<form name="form1" method="post" action="saveconf.php?<? echo 'PlaylistFile='.$PlaylistFile.'&ServerIP='.$ServerIP.'&ServerPort='.$ServerPort.'&Password='.$Password.'&StreamTitle='.$StreamTitle.'&StreamURL='.$StreamURL.'&Genre='.$Genre.'&LogFile='.$LogFile.'&Shuffle='.$Shuffle.'&Bitrate='.$Bitrate.'&InputSamplerate='.$InputSamplerate.'&InputChannels='.$InputChannels.'&Quality='.$Quality.'&CrossfadeMode='.$CrossfadeMode.'&CrossfadeLength='.$CrossfadeLength.'&UseID3='.$UseID3.'&Public='.$Public.'&AIM='.$AIM.'&ICQ='.$ICQ.'&IRC='.$IRC?>">
<div align="center">
<table border="1">
  <tr>
    <td>Playlist</td>
    <td><? echo $PlaylistFile; ?></td>
    <td><input name="PlaylistFile" type="text" value="<? echo $PlaylistFile; ?>"></td>
  </tr>
  <tr>
    <td>Server IP </td>
    <td><? echo $ServerIP; ?></td>
    <td><input name="ServerIP" type="text" value="<? echo $ServerIP; ?>"></td>
  </tr>
  <tr>
    <td>Server Port </td>
    <td><? echo $ServerPort; ?></td>
    <td><input name="ServerPort" type="text" value="<? echo $ServerPort; ?>"></td>
  </tr>
  <tr>
    <td>Server Passwort </td>
    <td><? echo $Password; ?></td>
    <td><input name="Password" type="text" value="<? echo $Password; ?>"></td>
  </tr>
  <tr>
    <td>Stream Title </td>
    <td><? echo $StreamTitle; ?></td>
    <td><input name="StreamTitle" type="text" value="<? echo $StreamTitle; ?>"></td>
  </tr>
  <tr>
    <td>Stream URL</td>
    <td><? echo $StreamURL; ?></td>
    <td><input name="StreamURL" type="text" value="<? echo $StreamURL; ?>"></td>
  </tr>
  <tr>
    <td>Genre</td>
    <td><? echo $Genre; ?></td>
    <td><input name="Genre" type="text" value="<? echo $Genre; ?>"></td>
  </tr>
  <tr>
    <td>LogFile</td>
    <td><? echo $LogFile; ?></td>
    <td><input name="LogFile" type="text" value="<? echo $LogFile; ?>"></td>
  </tr>
  <tr>
    <td>Shuffle</td>
    <td><? echo $Shuffle; ?></td>
    <td><input name="Shuffle" type="text" value="<? echo $Shuffle; ?>"></td>
  </tr>
  <tr>
    <td>Bitrate</td>
    <td><? echo $Bitrate; ?></td>
    <td><input name="Bitrate" type="text" value="<? echo $Bitrate; ?>"></td>
  </tr>
  <tr>
    <td>Sample Rate </td>
    <td><? echo $InputSamplerate; ?></td>
    <td><input name="InputSamplerate" type="text" value="<? echo $InputSamplerate; ?>"></td>
  </tr>
  <tr>
    <td>Channels</td>
    <td><? echo $InputChannels; ?></td>
    <td><input name="InputChannels" type="text" value="<? echo $InputChannels; ?>"></td>
  </tr>
  <tr>
    <td>Quality</td>
    <td><? echo $Quality; ?></td>
    <td><input name="Quality" type="text" value="<? echo $Quality; ?>"></td>
  </tr>
  <tr>
    <td>Crossfade Mode </td>
    <td><? echo $CrossfadeMode; ?></td>
    <td><input name="CrossfadeMode" type="text" value="<? echo $CrossfadeMode; ?>"></td>
  </tr>
  <tr>
    <td>Crossfade Length </td>
    <td><? echo $CrossfadeLength; ?></td>
    <td><input name="CrossfadeLength" type="text" value="<? echo $CrossfadeLength; ?>"></td>
  </tr>
  <tr>
    <td>Use ID3 </td>
    <td><? echo $UseID3; ?></td>
    <td><input name="UseID3" type="text" value="<? echo $UseID3; ?>"></td>
  </tr>
  <tr>
    <td>Public</td>
    <td><? echo $Public; ?></td>
    <td><input name="Public" type="text" value="<? echo $Public; ?>"></td>
  </tr>
  <tr>
    <td>AIM</td>
    <td><? echo $AIM; ?></td>
    <td><input name="AIM" type="text" value="<? echo $AIM; ?>"></td>
  </tr>
  <tr>
    <td>ICQ</td>
    <td><? echo $ICQ; ?></td>
    <td><input name="ICQ" type="text" value="<? echo $ICQ; ?>"></td>
  </tr>
  <tr>
    <td>IRC</td>
    <td><? echo $IRC; ?></td>
    <td><input name="IRC" type="text" value="<? echo $IRC; ?>"></td>
  </tr>
</table>
<p><input type="submit" value=" Save "> &nbsp; <input type="reset" value=" Cancel ">
</p>
</div>
</form>
<?



?>

</body>
</html>

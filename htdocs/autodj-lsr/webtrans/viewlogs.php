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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta  http-equiv="refresh" content="2";>
<title>Webtrans - View Logs</title>
<link href="webtrans.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
<!--
var countDownInterval=5;
var countDownTime=countDownInterval;

function countDown()
{
    --countDownTime;
    if (countDownTime < 0)
    {
        countDownTime=countDownInterval;
    }
    setTimeout("countDown()", 1000);
    if (countDownTime == 0)
    {
        location.reload();
    }
}
// -->
</script>

</head>
<body>
<?php
include_once("config.php");

$file = $soundbase."/sc_trans.conf";

$filehandle = fopen ($file, "r+");
$contents = fread($filehandle, filesize($file));
fclose($filehandle);
$pos = strpos($contents, "LogFile=") ;
$contents = substr($contents, $pos+8);
$Logfile = strtok($contents, "\n");

$command = "tail -10 ".$soundbase."/".$Logfile;

$lastlog =  shell_exec($command);
$lastlog = str_replace("\n", "<br>\n", $lastlog);
echo $lastlog;

?>
</body>
</html>

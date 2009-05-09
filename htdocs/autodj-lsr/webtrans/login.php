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


//var_dump($_POST);
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      session_start();

      include_once("config.php");
	  
	  $username = $_POST['username'];
      $passwort = $_POST['passwort'];

      $hostname = $_SERVER['HTTP_HOST'];
      $path = dirname($_SERVER['PHP_SELF']);

      // Benutzername und Passwort werden überprüft
      if ($username == $loginuser && $passwort == $loginpass) {
       $_SESSION['angemeldet'] = true;
       // Weiterleitung zur geschützten Startseite
       if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
        if (php_sapi_name() == 'cgi') {
         header('Status: 303 See Other');
         }
        else {
         header('HTTP/1.1 303 See Other');
         }
        }

       header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
       exit;
       }
      }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
  <title>Geschützter Bereich</title>
  
  <style type="text/css">
<!--
@import url("webtrans.css");
-->
  </style>
</head>
 <body>
 <br /> <br /> <br />
  <form action="login.php" method="post">
   <table align="center" >
   		<tr>
			<td><span class="Stil1">Username: </span></td>
			<td><input type="text" name="username" /></td>
		</tr>
   		<tr>
   			<td><span class="Stil1">Passwort: </span></td>
			<td><input type="password" name="passwort" /></td>
		</tr>
   		<tr>
			<td></td>
   			<td><input type="submit" value="Anmelden" /></td>
		<tr>
	</table>
   <p>&nbsp;</p>
   <p align="center">Tipp: Schau in der Config nach =) </p>
  </form>
 </body>
</html>


<?php
// Quellserver. Der Server, der die richtigen Songinformationen liefert.
	$s_host         = "127.0.0.1";
	$s_port         = "8000";

// Zielserver. Dieser Server bekommt die Daten gesendet.
	$host           = "127.0.0.1";
	$port           = "8000";
	$password       = "adminniclas";

/*******************/
/* Eingabeformular */
/*******************/
if(isset($_GET['form']) && $_GET['form'] == 'true'){
?>

<html>

<head>
	<title>Shoutupdate - Eingabeformular</title>

</head>
<body>

<form action="shout_update.php" method="GET">
	<input type="text" size="100" name="song" /><input type="submit" name="submit" value="Absenden" />
	<input type="hidden" name="form" value="true" />
</form>

</body>
</html>

<?php
}
/************************************************************************************************/
/*					Ab hier nur noch etwas ändern, wenn du weisst, was du tust.                 */
/************************************************************************************************/

// Quellserver abfragen
	if(isset($_GET['song']) && $_GET['song'] != ""){
		$song = $_GET['song'];
	}
	elseif(!isset($_GET['form'])){
		$handle = @fsockopen($s_host, $s_port, &$errno, &$errstr, 10);
		if (!$handle)
			die('Error while connecting to Server.');
		else{
			fputs($handle, "GET /7.html HTTP/1.1\nUser-Agent: Mozilla\n\n");
			$song_data = fread($handle, 256);
			usleep(500000);

			$song_data = ereg_replace("^.<body>", "", $song_data);
			$song_data = ereg_replace("</body>.*", "", $song_data);

			$song_data_ = explode(",", $song_data);
			$song = $song_data_[6];
		}
	}

// Daten an den Zielserver senden
	if($song != ''){
		$sp = @fsockopen($host, $port, &$errno, &$errstr, 10);

		if (!$sp)
			die('Error while connecting to Server.');
		else{
			set_socket_blocking($sp, false);
			fputs($sp, "GET /admin.cgi?pass=" . $password . "&mode=updinfo&song=" . rawurlencode($song) . " HTTP/1.1\nUser-Agent: Mozilla\n\n");
		}
	}
?>

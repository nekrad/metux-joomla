<?php
include('loginauth.php');
include_once("functions.php");
include_once("config.php");

$action = getRequestVar('action');

if ($action == "")
{
    unset($action);
}

if (isset($action))
{
    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
	
	if ($action == "stop")
    {	
     	//if($sc_proc_id != 0){
	    	shell_exec($soundbase."/sc_trans stop");
    	//}
		//else {
			//echo "SC_TRANS_LINUX killed";
		header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
		//}
	}
    elseif($action == "restart")
    {
		shell_exec($soundbase."/sc_trans stop");
		shell_exec($soundbase."/sc_trans start");
		header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
   	}
	elseif($action == "reload")
    {
		$sc_proc_id = shell_exec("ps -A | grep sc_trans_linux | cut -c 0-6;");
		shell_exec("kill -s USR1 ".$sc_proc_id);
		
		//header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
   	}
	elseif($action == "next")
    {
		$sc_proc_id = shell_exec("ps -A | grep sc_trans_linux | cut -c 0-6;");
		shell_exec("kill -s WINCH ".$sc_proc_id);
		
		//header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
   	}
	elseif($action == "start")
	{
		$file = $soundbase."/sc_trans.conf";
		$filehandle = fopen ($file, "r+");
		$contents = fread($filehandle, filesize($file));
		fclose($filehandle);
		$pos = strpos($contents, "LogFile=") ;
		$contents = substr($contents, $pos+8);
		$Logfile = strtok($contents, "\n");
		
		if($sc_proc_id == 0){
			shell_exec("rm ".$soundbase."/".$Logfile);
			shell_exec("touch ".$soundbase."/".$Logfile);
			shell_exec($soundbase."/sc_trans start");
			}
		header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
	}
	elseif($action == "config")
    {
	echo ('	<SCRIPT LANGUAGE="javascript">
			window.open ("editconf.php")
		</SCRIPT> ');
	header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/index.php');
   	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WebTrans</title>
<link href="webtrans.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function oeffnefenster (url, breite, hoehe) {
 fenster=window.open(url, "_blank", "status=yes,scrollbars=yes,resizable=yes,location=yes");
 fenster.innerWidth = breite;
 fenster.innerHeight = hoehe;
fenster.moveTo(screen.width - breite - 50, screen.height - 700);

 fenster.focus();
 return false;
}
</script>
</head>
<body>

<?




$sc_proc_id = "";
$sc_proc_id = shell_exec("ps -A | grep sc_trans_linux | cut -c 0-6;");
//var_dump($sc_proc_id);
if($sc_proc_id == "") { echo "SC_TRANS not running<br>";}
else echo "Proc_ID = $sc_proc_id<br>";
echo "<br>";
?>

<table width="350" border="0">
  <tr>
    <td><table align="center">
			<tr>
				<td class="tablea1"><a class="tablea1" style="display:block;" href="index.php?action=start"></a></td>
	    		<td class="tablea2"><a class="tablea2" style="display:block;" href="index.php?action=stop"></a></td>
		 		<td class="tablea3"><a class="tablea3" style="display:block;" href="index.php?action=restart"></a></td>
				<td class="tablea8"><a href="editfiles.php" target="_blank" class="tablea8" style="display:block;"  onclick="oeffnefenster(this.href, 700, 500); return false"></a></td>
			</tr>
			<tr>
				<td class="tablea4"><a class="tablea4" style="display:block;" href="index.php?action=add"></a></td>
				<td class="tablea5"><a href="editconf.php" target="_blank" class="tablea5" style="display:block;" onclick="oeffnefenster(this.href,450,650); return false"></a></td>
				<td class="tablea6"><a class="tablea6" style="display:block;" href="index.php?action=reload"></a></td>
				<td class="tablea7"><a class="tablea7" style="display:block;" href="index.php?action=next"></a></td>
			</tr>
 		</table>
	</td>
    
  </tr>

  <tr>
    <td align="center" ><IFRAME src="<?php if($action == "add") echo ('editplay.php?mode=add"  width="900" height="450"');
							else echo ('editplay.php" width="450" height="400"');?>	align="middle" >
</IFRAME></td>
    
  </tr>
  <tr>
    <td align="center"><?php if($sc_proc_id != "") echo ('<IFRAME src="viewlogs.php" align="middle" width="900" height="150">'); ?>
</IFRAME></td>
    
  </tr>
</table>
</body>
</html>

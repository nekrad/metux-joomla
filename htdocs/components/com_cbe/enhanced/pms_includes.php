<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if($ueConfig['pms']==1) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%' AND (published='1' OR published='0')");
	$pms_ops = $database->loadResult();
	$pms_open_source_path = 'index.php?option=com_pms'.$pms_ops.'&amp;page=new&amp;id='; // MyPMS-OS II 2.1x
} else if ($ueConfig['pms']==2) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_mypms%' AND (published='1' OR published='0')");
	$pms_mypms = $database->loadResult();
	$mypms_path = 'index.php?option=com_mypms'.$pms_mypms.'&amp;task=new&amp;to=';	 // MyPMS-Pro
} else if ($ueConfig['pms']==3) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_pms%' AND (published='1' OR published='0')");
	$pms_os2 = $database->loadResult();
	$pms_os_2_path="index.php?option=com_pms".$pms_os2."&page=new&id=";			 // MyPMS-OS 2.5alpha	.$user->username; 
} else if ($ueConfig['pms']==4) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE (link LIKE '%com_pms' OR link LIKE '%com_pms%&task=new%') AND (published='1' OR published='0')");
	$pms_oseh = $database->loadResult();
	$pms_os_enh_path="index.php?option=com_pms".$pms_oseh."&page=new&id=";		 // MyPMS-OSenh 1.2.x	.$user->username;
} else if ($ueConfig['pms']==9) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE (link LIKE '%com_pms' OR link LIKE '%com_pms%&task=new%') AND (published='1' OR published='0')");
	$pms_oseh2 = $database->loadResult();
	$pms_os_enh2_path="index.php?option=com_pms".$pms_oseh."&page=new&id=";		 // MyPMS-OSenh 2.x	.$user->id;
} else if ($ueConfig['pms']==5) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_uddeim%' AND (published='1' OR published='0')");
	$pms_uddeim = $database->loadResult();
	$pms_uddeim_path="index.php?option=com_uddeim".$pms_uddeim."&task=new&recip=";		 // uddeIM 0.4>		.$user->id;
} else if ($ueConfig['pms']==6) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_missus%' AND (published='1' OR published='0')");
	$pms_missus = $database->loadResult();
	$pms_missus_path="index.php?option=com_missus".$pms_missus."&func=newmsg&user=";	 // Missus 1.0 Beta2	.$user->id;
} else if ($ueConfig['pms']==7) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_mypms%' AND (published='1' OR published='0')");
	$pms_mypmsc = $database->loadResult();
	$pms_clexus_path = 'index.php?option=com_mypms'.$pms_mypmsc.'&amp;task=new&amp;to=';	 // Clexus 1.2.1 and higer	.$user->id;
} else if ($ueConfig['pms']==8) {
	$database->setQuery("SELECT concat('&Itemid=',id) FROM #__menu WHERE link LIKE '%com_jim%' AND (published='1' OR published='0')");
	$pms_jim = $database->loadResult();
	$pms_jim_path="index.php?option=com_jim".$pms_jim."&task=new&id=";	 // Jim 1.0.1	.$user->username;
}

?>
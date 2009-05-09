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
include_once("functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script language="javascript">

function clearPlaylist()
{
			var itemId=this.tree2.rootId;
      		var temp=this.tree2._globalIdStorageFind(itemId);
      		this.tree2.deleteChildItems(itemId);

}

function setValue()
		{
		var i = 0;
		var j = 0;
		var n = 0;
		arvArray = new Array();	
			
			arvArray = getChilds(this.tree2.htmlNode, arvArray, "<?php echo $soundfiles."/";?>")
			
			var arv = arvArray.toString(); // Array in String umcodieren
			document.treeform.arv.value = escape(arv); //String url-encodieren
		}
		
function getChilds(Childs, arr, label) {

	var i = 0;

	for(i = 0; i < Childs.childsCount; i++) {
				
				if(Childs.childNodes[i].childsCount == 0) {
				
					if(Childs.childNodes[i].label[0] != "/") {
						arr.push(label+Childs.childNodes[i].label);
					}
					else arr.push(Childs.childNodes[i].label);
				}
				else {
				//	for(j = 0; j < this.tree2.htmlNode.childNodes[i].childsCount; j++) {	
			
				//		arvArray[n] = this.tree2.htmlNode.childNodes[i].childNodes[j].id;
						//alert(arvArray[n]);
				//		n++;
				//	}
					//alert("Next Child");
					arr = getChilds(Childs.childNodes[i], arr, label+Childs.childNodes[i].label+"/")
				
				}
			}
	return arr;
}

</script>	

<title>Drag and Drop</title>

</head>

<body bgcolor="#D0D0D0">
<form action="editplay1.php" method=post name=treeform onSubmit=setValue()>
    <input name=arv  type=hidden>
			

<link rel='STYLESHEET' type='text/css' href='style.css'>

<link rel="STYLESHEET" type="text/css" href="dhtmlxtree.css">
	
	<script  src="dhtmlxcommon.js"></script>
	<script  src="dhtmlxtree.js"></script>
	

	<table>
		<tr>
			<td valign="top">
<?php
	
		$mode = getRequestVar('mode');

		if (isset($mode) && $mode == "add")
		{ 
	
		echo('
				<div id="tree1" style="width:300; height:350;background-color:#f5f5f5;border :1px solid Silver;"></div><br>			</td>
			<td style="padding-left:25px" valign="top"> ');
		}
		?>	
		  <div id="playlist" style="width:400; height:350;background-color:#f5f5f5;border :1px solid Silver;background-image=url(./imgs/closedFolder.gif)"></div></td>

	<?php
	
		if (isset($mode) && $mode == "add")
		{ 
	
			echo('				
			<td style="padding-left:25px" valign="top" title="bask">
				<div id="basket" style="width:100; height:100;background-color:#f5f5f5;border :1px solid Silver;"></div><br>			</td> '); 
		}	
		
		?>
		</tr>
	</table>

	<script>
	<?php
	
		if (isset($mode) && $mode == "add")
		{ 
	
		echo('	tree=new dhtmlXTreeObject("tree1","100%","100%",0);
			tree.setImagePath("imgs/csh_winstyle/");
			tree.enableDragAndDrop(true);
			tree.label = "tree1";
            //load first level of tree
            tree.loadXML("xml.php");
			
			');
		}
		echo('
			tree2=new dhtmlXTreeObject("playlist","100%","100%",0);
			tree2.setImagePath("imgs/csh_winstyle/");
			'); 
		if ((isset($mode) && $mode == "add"))	{
			echo('
			tree2.enableDragAndDrop(true);
			');
		}	
		echo('	
			tree2.loadXML("xml2.php");
			tree2.enabledpcpy(true);
			tree2.label = "tree2";
		');
		if (isset($mode) && $mode == "add")
		{ 
	
			echo('	
			tree3=new dhtmlXTreeObject("basket","100%","100%",0);
			tree3.setImagePath("imgs/csh_winstyle/");
			tree3.enableDragAndDrop(true);
			tree3.label = "tree3";
			tree3.enabledpcpy(true);
			');
		} ?>
			
				


	</script>
	<?php
		if ((isset($mode) && $mode == "add"))
		echo (' 
		<input type=submit value="Save playlist">
		<input type="button" name="clear" value="Clear Playlist" onClick="clearPlaylist()">
		'); ?>
    

</form>
</body>
</html>

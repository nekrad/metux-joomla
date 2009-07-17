<?php
/**
* Joomla/Mambo Community Builder
* @version $Id: admin.comprofiler.html.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage admin.comprofiler.html.php
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_comprofiler {
	
	function installPluginForm() {
		
		
		
	}
	
	
	function showLists( &$rows, $pageNav, $search, $option ) {
		global $mosConfig_offset, $acl;
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
function cbsaveorder( n ) {
	cbcheckAll_button( n );
	submitform('savelistorder');
}

//needed by cbsaveorder function
function cbcheckAll_button( n ) {
	for ( var j = 0; j <= n; j++ ) {
		box = eval( "document.adminForm.cb" + j );
		if ( box.checked == false ) {
			box.checked = true;
		}
	}
}
//--><!]]></script>
<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="../components/com_comprofiler/images/cblist.gif" align="middle" />List Manager</td>
      <td nowrap="nowrap">Display #</td>
      <td> <?php echo $pageNav->writeLimitBox(); ?> </td>
      <td>Search:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</th>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="25%" class="title">Title</th>
      <th width="25%" class="title">Description</th>
      <th width="5%" class="title">Published?</th>
      <th width="5%" class="title">Default?</th>
      <th width="15%" class="title">Access</th>
      <th width="5%" class="title" colspan="2">Re-Order</th>
      <th width="1%"><a href="javascript: cbsaveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a></th>
      <th width="2%" class="title">listid</th>
    </tr>
<?php
		$k = 0;
		$imgpath='../components/com_comprofiler/images/';
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row =& $rows[$i];

		        $img3 = $row->published ?  'tick.png' : 'publish_x.png';
		        $task3 = $row->published ?  'listPublishedNo' : 'listPublishedYes';
		        $img4 = $row->default ?  'tick.png' : 'publish_x.png';
			$task4 = $row->default ?  'listDefaultNo' : 'listDefaultYes';
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->listid; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="#editList" onClick="return listItemTask('cb<?php echo $i;?>','editList')"><?php echo getLangDefinition($row->title); ?></a></td>
      <td><?php echo getLangDefinition($row->description); ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task3;?>')"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task4;?>')"><img src="<?php echo $imgpath.$img4;?>" width="12" height="12" border="0" alt="" /></a></td>
	  <td><?php 
	  		if ( $row->useraccessgroupid >= 0 ) {
		  		echo '<span style="color:red;">' . $acl->get_group_name( (int) $row->useraccessgroupid ) . '</span>';
	  		} elseif ( $row->useraccessgroupid == -2 ) {
	  			echo '<span style="color:green;">Everybody</span>';
	  		} elseif ( $row->useraccessgroupid == -1 ) {
	  			echo '<span style="color:orange;">All Registered Users</span>';
	  		}
	  ?></td>
      <td>
	<?php    if ($i > 0 || ($i+$pageNav->limitstart > 0)) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupList')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up" />
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if ($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownList')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down" />
         </a>
	<?php    } ?>
      </td>
	  <td align="center">
	  <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
	  </td>
      <td style="text-align:right"><?php echo $row->listid;?></td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="12"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="12"> <?php echo $pageNav->writePagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showLists" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }
	function editList( &$row, $lists, $fields, $option, $tabid ) {
		global $my, $acl, $task, $_CB_database, $mainframe;

		outputCbTemplate( 2 );
		if ( $row->listid && ( ! $row->published ) ) {
			echo '<div class="cbWarning">List is not published</div>' . "\n";
		}

		$sqlWhere="";
		$fieldids=null;
		$col1options="";
		$col2options="";
		$col3options="";
		$col4options="";
		if($tabid >0) {
			$col1fields=explode('|*|',$row->col1fields);
				$fieldids="";
				for ($i=0, $n=count( $col1fields ); $i < $n; $i++) {
					$col1field =& $col1fields[$i];
					if(trim($col1field)!='' && trim($col1field)!=null) { 
					$col1options .= "<option value=\"".$col1field."\">".getLangDefinition(array_search($col1field,$fields))."\n";
					if($i>0) $fieldids .= ",";
					$fieldids .= "'".$col1field."'";
					}
			}
			$col2fields=explode('|*|',$row->col2fields);
				for ($i=0, $n=count( $col2fields ); $i < $n; $i++) {
					$col2field =& $col2fields[$i];
					if(trim($col2field)!='' && trim($col2field)!=null) { 
					$col2options .= "<option value=\"".$col2field."\">".getLangDefinition(array_search($col2field,$fields))."\n";
						$fieldids .= ",";
						$fieldids .= "'".$col2field."'";
					}
				}
			$col3fields=explode('|*|',$row->col3fields);
				for ($i=0, $n=count( $col3fields ); $i < $n; $i++) {
					$col3field =& $col3fields[$i];
					if(trim($col3field)!='' && trim($col3field)!=null) { 
					$col3options .= "<option value=\"".$col3field."\">".getLangDefinition(array_search($col3field,$fields))."\n";
						$fieldids .= ",";
						$fieldids .= "'".$col3field."'";			
					}
				}
			$col4fields=explode('|*|',$row->col4fields);
				for ($i=0, $n=count( $col4fields ); $i < $n; $i++) {
					$col4field =& $col4fields[$i];
					if(trim($col4field)!='' && trim($col4field)!=null) { 
					$col4options .= "<option value=\"".$col4field."\">".getLangDefinition(array_search($col4field,$fields))."\n";
						$fieldids .= ",";
						$fieldids .= "'".$col4field."'";
					}
			}
			if($fieldids!=null) $sqlWhere="\nAND fieldid NOT IN ($fieldids)";
		}
		$_CB_database->setQuery( "SELECT f.fieldid, f.title, f.name"
			. "\nFROM #__comprofiler_fields f"
			. "\nWHERE f.published = 1 AND f.profile = 1"
			. $sqlWhere
		);

		$fields = $_CB_database->loadObjectList();

		$stripME = array(" ASC", " DESC","`");
		$WhereIn = str_replace($stripME, "", $row->sortfields);
		$WhereIn = "'".str_replace(", ","','",$WhereIn)."'";
		$_CB_database->setQuery( "SELECT f.title, f.name"
			. "\nFROM #__comprofiler_fields f"
			. "\nWHERE f.published = 1 AND f.name!='NA'"
			. "\nAND f.name NOT IN(".$WhereIn.")"
		);
		
		$sortfields = $_CB_database->loadObjectList();
		
		$_CB_database->setQuery( "SELECT f.title, f.name"
			. "\nFROM #__comprofiler_fields f"
			. "\nWHERE f.published = 1 AND f.name!='NA'"
		);
		$filterfields = $_CB_database->loadObjectList();
		
		
		
		$sortlists=explode(", ",str_replace("`","",$row->sortfields));
		$sortparts=array();
		$i=0;
		foreach($sortlists as $sortlist) {
			$sortlistpart=array();
			$sortlistpart=explode(" ",$sortlist);
			if(!ISSET($sortlistpart[1])) $sortlistpart[1]="";
			$sortparts[$i]['field']=$sortlistpart[0];	
			$sortparts[$i]['dir']=$sortlistpart[1];
			$_CB_database->setQuery("SELECT title FROM #__comprofiler_fields WHERE name='".$sortlistpart[0]."' LIMIT 1");
			$sortparts[$i]['title']=$_CB_database->loadResult();
		$i++;
		}


?>
	<script type="text/javascript"><!--//--><![CDATA[//><!--
  function getObject(obj) {
    var strObj;
    if (document.all) {
      strObj = document.all.item(obj);
    } else if (document.getElementById) {
      strObj = document.getElementById(obj);
    }
	return strObj;
}
function shDiv(objID,sh) {
	var strObj;
	strObj = getObject(objID);
	if(sh==0) {
	strObj.style.display="none";
	} else {
	strObj.style.display="block";
	}
}
		function submitbutton(pressbutton) {
			if (pressbutton == 'showLists') {
				submitform( pressbutton );
				return;
			}
			var coll = document.adminForm;
			var errorMSG = '';
			var iserror=0;
			if (coll.col1enabled.checked == true) coll.col1title.setAttribute('mosReq',1);
			if (coll.col2enabled.checked == true) coll.col2title.setAttribute('mosReq',1);
			if (coll.col3enabled.checked == true) coll.col3title.setAttribute('mosReq',1);
			if (coll.col4enabled.checked == true) coll.col4title.setAttribute('mosReq',1);
			getSortList(document.adminForm.sort);
			getFilterList(document.adminForm.filter);
		     if (coll != null) {
		       var elements = coll.elements;
		       // loop through all input elements in form
		       for (var i=0; i < elements.length; i++) {
		         // check if element is mandatory; here mosReq=1
		         if ((typeof(elements.item(i).getAttribute('mosReq')) != "undefined") && (elements.item(i).getAttribute('mosReq') == 1)) {
		           if (elements.item(i).value == '') {
		             //alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
		             // add up all error messages
		             errorMSG += elements.item(i).getAttribute('mosLabel') + ' : <?php echo _UE_REQUIRED_ERROR; ?>\n';
		             // notify user by changing background color, in this case to red
		             elements.item(i).style.backgroundColor = "red";
		             iserror=1;
		           }
		         }
		       }
		     }
			if(iserror==1) { alert(errorMSG); }
			else {
				selectAll(document.adminForm.col1);
				selectAll(document.adminForm.col2);
				selectAll(document.adminForm.col3);
				selectAll(document.adminForm.col4);
				submitform( pressbutton );
			}

		}

    function addOption(selectObj, value)
    {
      optionSelected = (value == null);
      if(value == null) value = prompt('', '');
      if(value != null)
      {
        if(value.indexOf(',') != -1)
          alert('Commas are not allowed in size values');
        else
        {
          var i = selectObj.options.length;
          value = value.replace(/1\/2/g, '�');
          selectObj.options.length = i + 1;
          selectObj.options[i].value = (value != '' && value != ' ') ? value : ' ';
          selectObj.options[i].text = (value != '' && value != ' ') ? value : '[empty]';
          selectObj.options[i].selected = optionSelected;
// uncomment the line below if you want the select list to change it's size to match the number of options it contains.
//          selectObj.size = selectObj.options.length;
        }
      }
    }
  
    function editOptions(selectObj)
    {
      for(var i = 0; i < selectObj.options.length; i++)
      {
        if(selectObj.options[i].selected)
        {
          var value = prompt('', selectObj.options[i].value);
          if(value != null)
          {
            if(value.indexOf(',') != -1)
              alert('Commas are not allowed in size values');
            else
            {
              selectObj.options[i].value = value;
              selectObj.options[i].text = (value != '') ? value : '[empty]';
              selectObj.options[i].selected = true;
            }
          }
        }
      }
    }
    
    function deleteOptions(selectObj)
    {
      for(var i = 0; i < selectObj.options.length; i++)
      {
        if(selectObj.options[i].selected)
        {
          for(var j = i; j < selectObj.options.length - 1; j++)
          {
            selectObj.options[j].value = selectObj.options[j + 1].value;
            selectObj.options[j].text = selectObj.options[j + 1].text;
            selectObj.options[j].selected = selectObj.options[j + 1].selected;
          }
          selectObj.options.length = selectObj.options.length - 1;
          i--;
        }
      }
    }
    
    function moveOptions(selectObj, direction)
    {
      if(selectObj.selectedIndex != -1)
      {
        if(direction < 0)
        {
          for(i = 0; i < selectObj.options.length; i++)
          {
            swapValue = (i == 0 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].value;
            swapText = (i == 0 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].text;
            if(selectObj.options[i].selected && swapValue != null && swapText != null)
            {
              thisValue = selectObj.options[i].value;
              thisText = selectObj.options[i].text;
              selectObj.options[i].value = swapValue;
              selectObj.options[i].text = swapText;
              selectObj.options[i + direction].value = thisValue;
              selectObj.options[i + direction].text = thisText;
              selectObj.options[i].selected = false;
              selectObj.options[i + direction].selected = true;
            }
          }
        }
        else
        {
          for(i = selectObj.options.length - 1; i >= 0; i--)
          {
            swapValue = (i == selectObj.options.length - 1 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].value;
            swapText = (i == selectObj.options.length - 1 || selectObj.options[i + direction].selected) ? null : selectObj.options[i + direction].text;
            if(selectObj.options[i].selected && swapValue != null && swapText != null)
            {
              thisValue = selectObj.options[i].value;
              thisText = selectObj.options[i].text;
              selectObj.options[i].value = swapValue;
              selectObj.options[i].text = swapText;
              selectObj.options[i + direction].value = thisValue;
              selectObj.options[i + direction].text = thisText;
              selectObj.options[i].selected = false;
              selectObj.options[i + direction].selected = true;
            }
          }
        }
      }
    }
    var NS4 = (document.layers);

    function moveOption(fromObj, toObj)
    {
      for(var i = fromObj.options.length - 1; i >= 0; i--)
      {
        if(fromObj.options[i].selected)
        {
          fromObj.options[i].selected = false;
          optionText = fromObj.options[i].text.replace(' [ASC]','');
	  optionText = optionText.replace(' [DESC]','');
          optionValue = fromObj.options[i].value.replace(' ASC','');
	  optionValue = optionValue.replace(' DESC','');
          for(var j = i; j < fromObj.options.length - 1; j++)
          {
            fromObj.options[j].text = fromObj.options[j + 1].text;
            fromObj.options[j].value = fromObj.options[j + 1].value;
          }
          fromObj.options.length = fromObj.options.length - 1;
          toObjIndex = toObj.options.length;
          toObj.options.length = toObj.options.length + 1;
          toObj.options[toObjIndex].text = optionText;
          toObj.options[toObjIndex].value = optionValue;
          if(NS4)
            history.go(0);
        }
      }
    }

    function moveOption2(fromObj, toObj, appendValue)
    {
        if(fromObj.options[fromObj.selectedIndex].selected)
        {
	  fromObjIndex=fromObj.selectedIndex;
          fromObj.options[fromObjIndex].selected = false;
          optionText = fromObj.options[fromObjIndex].text+ ' ['+appendValue+']';
          optionValue = fromObj.options[fromObjIndex].value+' '+appendValue;
          for(var j = fromObjIndex; j < fromObj.options.length - 1; j++)
          {
            fromObj.options[j].text = fromObj.options[j + 1].text;
            fromObj.options[j].value = fromObj.options[j + 1].value;
          }
          fromObj.options.length = fromObj.options.length - 1;
          toObjIndex = toObj.options.length;
          toObj.options.length = toObj.options.length + 1;
          toObj.options[toObjIndex].text = optionText;
          toObj.options[toObjIndex].value = optionValue;
	  toObj.options[toObjIndex].selected=false;
          if(NS4)
            history.go(0);
        }

    }

    function moveOption3(fromObj, toObj, comparison, condition)
    {
        if(fromObj.options[fromObj.selectedIndex].selected)
        {
	  if((condition=='' || condition==null) && document.adminForm.condition.getAttribute('Req')==1) {
		alert("You must define a condition text!");
		return;
	  }
	  fromObjIndex=fromObj.selectedIndex;
          fromObj.options[fromObjIndex].selected = false;
          optionText = fromObj.options[fromObjIndex].text+ ' '+comparison+' '+condition;
	  condition=condition.replace("'", "\\'");
	  if(condition!='' && condition!=null) condition="'"+escape(condition)+"'";
          optionValue = fromObj.options[fromObjIndex].value+' '+comparison+condition;
          toObjIndex = toObj.options.length;
          toObj.options.length = toObj.options.length + 1;
          toObj.options[toObjIndex].text = optionText;
          toObj.options[toObjIndex].value = optionValue;
	  toObj.options[toObjIndex].selected=false;
          if(NS4)
            history.go(0);
        }

    }
    function moveOption4(fromObj, toObj)
    {
      for(var i = fromObj.options.length - 1; i >= 0; i--)
      {
        if(fromObj.options[i].selected)
        {
          fromObj.options[i].selected = false;
          for(var j = i; j < fromObj.options.length - 1; j++)
          {
            fromObj.options[j].text = fromObj.options[j + 1].text;
            fromObj.options[j].value = fromObj.options[j + 1].value;
          }
          fromObj.options.length = fromObj.options.length - 1;
          if(NS4)
            history.go(0);
        }
      }
    }

   
    function getSortList(selectObj) {
	var sortfields='';
	var j=0;
	selectAll(selectObj);
      if(selectObj.selectedIndex != -1)
      {
          for(i = 0; i < selectObj.options.length; i++)
          {
		if(j>0) sortfields +=  ', ';
		sortfields +=  selectObj.options[i].value;
		j++
          }
		//alert(sortfields);
		document.adminForm.sortfields.value=sortfields;
        }
    }

    function getFilterList(selectObj) {
	var filterfields='';
	var j=0;
	var advType=getObject('ft2');
	var simType=getObject('ft1');
	//alert(simType.checked);
	if(simType.checked) {
		selectAll(selectObj);
      		if(selectObj.selectedIndex != -1)
      		{
          		for(i = 0; i < selectObj.options.length; i++)
          		{
				if(j>0) filterfields +=  ' AND ';
				filterfields +=  selectObj.options[i].value;
				j++
   		       }
			//alert(filterfields);
			if(filterfields!="") {
				document.adminForm.filterfields.value="s("+filterfields+")";
			} else {
				document.adminForm.filterfields.value="";
		}
        	}
    	} else {
		if(document.adminForm.advFilterText.value!="") {
			document.adminForm.filterfields.value="a("+escape(document.adminForm.advFilterText.value)+")";
		} else {
			document.adminForm.filterfields.value="";
		}
	}
}
  
    function selectAll(selectObj)
    {
      if(selectObj.options.length)
        for(i = 0; i < selectObj.options.length; i++)
          selectObj.options[i].selected = true;
      return false;
    }

    function loadUGIDs(selectObj)
    {
	var UGIDs='';
	var j=0;
      if(selectObj.selectedIndex != -1)
      {
          for(i = 0; i < selectObj.options.length; i++)
          {
		if(selectObj.options[i].selected) {
			if(j>0) UGIDs +=  ', ';
			UGIDs +=  selectObj.options[i].value;
			j++;
		}
          }
		document.adminForm.usergroupids.value=UGIDs;
        }
    }
    function enableListColumn(colnum) {
	var oForm;
	var colName;
	oForm=document.adminForm;
	colName="col"+colnum+"enabled";
	if(oForm.elements[colName].checked) {
		//alert("Enabled");
		oForm.col1title.readOnly=false;
		oForm.col1captions.disabled=false;
		//document.col1.disabled=false;
		oForm.col1up.disabled=false;
		oForm.col1down.disabled=false;
		oForm.col1remove.disabled=false;
		oForm.addcol1.disabled=false;
	} else {
		//alert("Disabled");
		oForm.col1title.readOnly=true;
		oForm.col1captions.disabled=true;
		//document.col1.disabled=true;
		oForm.col1up.disabled=true;
		oForm.col1down.disabled=true;
		oForm.col1remove.disabled=true;
		oForm.addcol1.disabled=true;
	}		

    }
	function filterCondition(needCond) {
		if(needCond==0) {
			document.adminForm.condition.value="";
			document.adminForm.condition.readOnly=true;
			document.adminForm.condition.setAttribute("Req",0);
		} else {
			document.adminForm.condition.value="";
			document.adminForm.condition.readOnly=false;
			document.adminForm.condition.setAttribute("Req",1);
		}

	}

//--><!]]></script>

	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="../components/com_comprofiler/images/cblist.gif" align="middle" /><?php echo $row->listid ? 'Edit' : 'Add';?> List</td>
		</tr>
	</table>

	<form action="index2.php?option=com_comprofiler&task=saveList" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%">URL for menu link to this list:</td>
			<td align=left  width="40%"><?php
		if ( $row->listid ) {
			echo '<a href="' . $mainframe->getCfg('live_site') . '/index.php?option=com_comprofiler&amp;task=usersList&amp;listid=' . (int) $row->listid . '" target="_blank">index.php?option=com_comprofiler&amp;task=usersList&amp;listid=' . (int) $row->listid . '</a>';
		} else {
			echo "You need to save this new list first to see the direct menu link url.";
		}
			?></td>
			<td width="40%">&nbsp;</td>
		</tr>
		<tr>
			<td>Title:</td>
			<td align=left><input type="text" name="title" mosReq=1 mosLabel="Title" class="inputbox" value="<?php echo htmlspecialchars($row->title); ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Description:</td>
			<td align=left><input type="text" name="description" mosReq=1 mosLabel="Description" class="inputbox" value="<?php echo htmlspecialchars($row->description); ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>User Group to allow access to:</td>
			<td><?php echo $lists['useraccessgroup']; ?></td>
			<td>All groups above that level will also have access to the list.</td>
		</tr>
		<tr>
			<td>User Groups to Include in List:</td>
			<td><?php echo $lists['usergroups']; ?></td>
			<td><strong><font color="red">Multiple choices:</font> CTRL/CMD-click to add/remove single choices.</strong></td>
		</tr>
		<tr>
			<td>Published:</td>
			<td><?php echo $lists['published']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Default:</td>
			<td><?php echo $lists['default']; ?></td>
			<td><strong><font color="red">WARNING:</font></strong> The default list should be the one with the lowest user groups access rights !</td>
		</tr>
		<tr>
			<td>Sort By:</td>
			<td>
				<select name="sortfieldlist">
					<?php
						for ($i=0, $n=count( $sortfields ); $i < $n; $i++) {
							$sortfield =& $sortfields[$i];
							echo "<option value=\"`".$sortfield->name."`\">".getLangDefinition($sortfield->title)."\n";
						}
		
					?>
				</select><select name=direction><option value="ASC">ASC</option><option value="DESC">DESC</option></select><input type=button onclick="moveOption2(this.form.sortfieldlist, sort, this.form.direction.value);" value=" Add "><br />
				<select id=sort name=sort size="5" multiple  mosReq=1 mosLabel="Sort By">
					<?php
						for ($i=0, $n=count( $sortparts ); $i < $n; $i++) {
							$sortpart = $sortparts[$i];
							if($sortpart['field']!='') {
								echo "<option value=\"`".$sortpart['field']."` ".$sortpart['dir']."\">".getLangDefinition($sortpart['title'])." [".$sortpart['dir']."]\n";
							}
						}
		
					?>
				</select><br />
				<input type=button onclick="moveOptions(sort, -1);" value=" + " />
				<input type=button onclick="moveOptions(sort, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(this.form.sort,this.form.sortfieldlist);" value=" Remove ">
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Filter:</td>
			<td colspan="2">
<?php

		$simChecked="";
		$advChecked="";
		$simStyle="display:none;";
		$advStyle="display:none;";
		//echo $row->filterfields;
		$filttype=substr($row->filterfields,0,1);
		$row->filterfields=substr($row->filterfields,2,-1);
		//substr($row->filterfields,1,-1)
		// echo "row->filterfields=".$row->filterfields;
		if($filttype=="a") {
			$advChecked="CHECKED";
			$advStyle="display:block;";
		} else {
			$simChecked="CHECKED";
			$simStyle="display:block;";
		}
		$filterlists=explode(" AND ",$row->filterfields);
		$filterparts=array();
		$i=0;
		foreach($filterlists as $filterlist) {
		
			$filterlistpart=array();
			$filterlistpart=explode(" ",$filterlist);
			$filterparts[$i]['field']=str_replace("`","",$filterlistpart[0]);
			$_CB_database->setQuery("SELECT title FROM #__comprofiler_fields WHERE name='".$filterparts[$i]['field']."' LIMIT 1");
			$filtertitle=$_CB_database->loadResult();
			$filterparts[$i]['value']=$filterlist;
			$filterparts[$i]['title']=str_replace(array("'","`"),"",str_replace($filterparts[$i]['field'],getLangDefinition($filtertitle),$filterlist));
		
			$i++;
		}
?>
				<label for=ft1 ><input type=radio <?php echo $simChecked; ?> id=ft1 onclick="javascript:shDiv('simFilter',1);shDiv('advFilter',0);" name=filtertype value=0 checked />Simple </label><label for=ft2 ><input type="radio" <?php echo $advChecked; ?> onclick="javascript:shDiv('simFilter',0);shDiv('advFilter',1);" id="ft2" name="filtertype" value="1" />Advanced </label>
				<br />
				<div id="simFilter" name="simFilter" style="<?php echo $simStyle; ?>" >
				<select name="filterfieldlist">
					<?php
						foreach ($filterfields AS $filterfield) {
							echo "<option value=\"`".$filterfield->name."`\">".getLangDefinition($filterfield->title)."\n";
						}
		
					?>
				</select>
				<select name=comparison onchange="javascript:filterCondition(this.options[this.selectedIndex].getAttribute('needCond'));">
					<option value=">" needCond=1>Greater Than</option>
					<option value=">=" needCond=1>Greater Than or Equal To</option>
					<option value="<" needCond=1>Less Than</option>
					<option value="<=" needCond=1>Less Than or Equal To</option>
					<option value="=" needCond=1>Equal To</option>
					<option value="!=" needCond=1>Not Equal To</option>
					<option value="IS NULL" needCond=0>Is NULL</option>
					<option value="IS NOT NULL"  needCond=0>Is Not NULL</option>
					<option value="LIKE"  needCond=1>Like</option>
				</select>
				<input type=text name=condition value="" Req=1 />
				<input type=button onclick="moveOption3(this.form.filterfieldlist, filter, this.form.comparison.value, this.form.condition.value);" value=" Add ">
				<br />
				<select id=filter name=filter size="5" multiple  mosReq=0 mosLabel="Filter By">
					<?php
						foreach ($filterparts AS $filterpart) {
							if($filterpart['value']!='') {
								echo "<option value=\"".$filterpart['value']."\">".stripslashes(utf8RawUrlDecode($filterpart['title']))."\n";	//BB todo sortout htmlspecialchars...not compatible with utf8rawdecode
							}
						}
		
					?>
				</select><br />
				<input type=button onclick="moveOptions(filter, -1);" value=" + " />
				<input type=button onclick="moveOptions(fitler, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption4(this.form.filter,this.form.filterfieldlist);" value=" Remove ">
				</div>
				<div id="advFilter" name="advFilter" style="<?php echo $advStyle; ?>">
					<textarea name="advFilterText" cols="50" rows="7"><?php echo stripslashes(utf8RawUrlDecode($row->filterfields)); 	//BB todo sortout htmlspecialchars...not compatible with utf8rawdecode
					?></textarea>
				</div>
			</td>
		</tr>
	</table>
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="33%">
				Enable Column 1: <input type=checkbox <?php /* onclick="javascript:enableListColumn(1);" */ ?> name="col1enabled" <?php if($row->col1enabled == 1) echo ' checked="checked" ';  ?> value=1 ><br />
				Column 1 Title:<br />
				<input type="text" name="col1title" mosReq=0 mosLabel="Column 1 Title" class="inputbox" value="<?php echo htmlspecialchars($row->col1title); ?>" /><br />
				Column 1 Captions:<input type=checkbox name=col1captions <?php if($row->col1captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col1 size="5" multiple name=col1[] >
					<?php
					echo $col1options;
					?>
				</select><br />
				<input name=col1up type=button onclick="moveOptions(col1, -1);" value=" + " />
				<input name=col1down type=button onclick="moveOptions(col1, 1);" value=" - " />
				<br />
				<input name=col1remove type=button onclick="moveOption(col1,this.form.fieldlist);" value=" Remove ">
			</td>
			<td width="33%" rowspan=3 valign=center align=center>Field List:<br />
				<input name=addcol1 type=button onclick="moveOption(this.form.fieldlist, col1);" value=" <- Add ">
				<input type=button onclick="moveOption(this.form.fieldlist, col2);" value=" Add -> "><br />
				<select name="fieldlist" size="10" multiple>
					<?php
						for ($i=0, $n=count( $fields ); $i < $n; $i++) {
							$field =& $fields[$i];
							echo "<option value=\"".$field->fieldid."\">".getLangDefinition($field->title)."\n";
						}
		
					?>
				</select><br />
				<input type=button onclick="moveOption(this.form.fieldlist, col3);" value=" <- Add ">
				<input type=button onclick="moveOption(this.form.fieldlist, col4);" value=" Add -> ">
			</td>
			<td width="33%">
				Enable Column 2: <input type=checkbox name=col2enabled <?php if($row->col2enabled == 1) echo " CHECKED ";  ?> value=1 ><br />
				Column 2 Title:<br />
				<input type="text" name="col2title" mosReq=0 mosLabel="Column 2 Title" class="inputbox" value="<?php echo htmlspecialchars($row->col2title); ?>" /><br />
				Column 2 Captions:<input type=checkbox name=col2captions <?php if($row->col2captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col2 size="5" multiple name=col2[] >
					<?php
					echo $col2options;
					?>
				</select><br />
				<input type=button onclick="moveOptions(col2, -1);" value=" + " />
				<input type=button onclick="moveOptions(col2, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(col2,this.form.fieldlist);" value=" Remove ">
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td width="33%">
				Enable Column 3: <input type=checkbox name=col3enabled <?php if($row->col3enabled == 1) echo " CHECKED ";  ?> value=1 /><br />
				Column 3 Title:<br />
				<input type="text" name="col3title" mosReq=0 mosLabel="Column 3 Title" class="inputbox" value="<?php echo htmlspecialchars($row->col3title); ?>" /><br />
				Column 3 Captions:<input type=checkbox name=col3captions <?php if($row->col3captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col3 size="5" multiple name=col3[]>
					<?php
					echo $col3options;
					?>
				</select><br />
				<input type=button onclick="moveOptions(col3, -1);" value=" + " />
				<input type=button onclick="moveOptions(col3, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(col3,this.form.fieldlist);" value=" Remove ">
			</td>
			<td width="33%">
				Enable Column 4: <input type=checkbox name=col4enabled <?php if($row->col4enabled == 1) echo " CHECKED ";  ?> value=1 ><br />
				Column 4 Title:<br />
				<input type="text" name="col4title" mosReq=0 mosLabel="Column 4 Title" class="inputbox" value="<?php echo htmlspecialchars($row->col4title); ?>" /><br />
				Column 4 Captions:<input type=checkbox name=col4captions <?php if($row->col4captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col4 size="5" multiple name=col4[]>
					<?php
					echo $col4options;
					?>
				</select><br />
				<input type=button onclick="moveOptions(col4, -1);" value=" + " />
				<input type=button onclick="moveOptions(col4, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(col4,this.form.fieldlist);" value=" Remove ">
			</td>
		</tr>
	</table>
  <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>

  </table>
  <input type="hidden" name="sortfields" value="<?php echo $row->sortfields; ?>" />
  <input type="hidden" name="filterfields" value="<?php echo $row->filterfields; ?>" />
  <input type="hidden" name="usergroupids" value="<?php echo $row->usergroupids; ?>" />
  <input type="hidden" name="listid" value="<?php echo $row->listid; ?>" />
  <input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
  <input type="hidden" name="option" value="com_comprofiler" />
  <input type="hidden" name="task" value="" />
</form>
  
<?php 	
}

	function showFields( &$rows, $pageNav, $search, $option ) {
		global $mosConfig_offset;
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
function cbsaveorder( n ) {
	cbcheckAll_button( n );
	submitform('savefieldorder');
}

//needed by sbsaveorder function
function cbcheckAll_button( n ) {
	for ( var j = 0; j <= n; j++ ) {
		box = eval( "document.adminForm.cb" + j );
		if ( box.checked == false ) {
			box.checked = true;
		}
	}
}
//--><!]]></script>
<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="../components/com_comprofiler/images/cbfield.gif" align="middle" />Field Manager</td>
      <td nowrap="nowrap">Display #</td>
      <td> <?php echo $pageNav->writeLimitBox(); ?> </td>
      <td>Search:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</th>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="10%" class="title">Name</th>
      <th width="10%" class="title">Title</th>
      <th width="10%" class="title">Type</th>
      <th width="10%" class="title">Tab</th>
      <th width="5%" class="title">Required?</th>
      <th width="5%" class="title">Profile?</th>
      <th width="5%" class="title">Registration?</th>
      <th width="5%" class="title">Published?</th>
      <th width="5%" class="title" colspan="2">Re-Order</th>
	  <th width="1%"><a href="javascript: cbsaveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a></th>
    </tr>
<?php
		$k = 0;
		$imgpath='../components/com_comprofiler/images/';
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row =& $rows[$i];
			$img = $row->required ? 'tick.png' : 'publish_x.png' ;
			$task = $row->required ? 'fieldRequiredNo' : 'fieldRequiredYes' ;
			switch ($row->profile) {
				case 0:
					$img2	= 'publish_x.png';
					$task2	= 'fieldProfileYes1';
					$text2	= '';
					break;
				case 1:
					$img2	= 'tick.png';
					$task2	= 'fieldProfileYes2';
					$text2	= '<span style="color:green;">(1 Line)</span>';
					break;
				case 2:
				default:
					$img2	= 'tick.png';
					$task2	= 'fieldProfileNo';
					$text2	= '<span style="color:green;">(2 Lines)</span>';
					break;
			}
			$img3  = $row->published ?  'tick.png' : 'publish_x.png';
			$task3 = $row->published ?  'fieldPublishedNo' : 'fieldPublishedYes';
			$img4  = $row->registration ?  'tick.png' : 'publish_x.png';
			$task4 = $row->registration ?  'fieldRegistrationNo' : 'fieldRegistrationYes';
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->fieldid; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="#editField" onClick="return listItemTask('cb<?php echo $i;?>','editField')">
        <?php echo $row->name; ?> </a> </td>
      <td><?php echo getLangDefinition($row->title); ?></td>
      <td><?php echo $row->type; ?></td>
      <td><?php
      		if ( $row->tabenabled == 0 ) {
      			echo '<span style="color:red;" title="field will not be visible as tab is not enabled.">';
      		} elseif ( $row->pluginid && ( $row->pluginpublished == 0 ) ) {
      			echo '<span style="color:red;" title="field will not be visible as tab\'s plugin \'' . $row->pluginname . '\' is not published.">';
      		}
			echo getLangDefinition($row->tab);
     		if ( $row->tabenabled == 0 || ( $row->pluginid && ( $row->pluginpublished == 0 ) ) ) {
     			echo '</span>';
     		}
	  ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task;?>')"><img src="<?php echo $imgpath.$img;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task2;?>')"><img src="<?php echo $imgpath.$img2;?>" width="12" height="12" border="0" alt="" /><?php echo $text2;?></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task4;?>')"><img src="<?php echo $imgpath.$img4;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task3;?>')"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td>
	<?php    if (($i > 0 || ($i+$pageNav->limitstart > 0)) && $row->tab == @$rows[$i-1]->tab) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupField')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up" />
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if (($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) && $row->tab == @$rows[$i+1]->tab) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownField')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down" />
         </a>
	<?php    } ?>
      </td>
	  <td align="center">
	  <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
	  </td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="13"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="13"> <?php echo $pageNav->writePagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showField" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

	function editfield( &$row, $lists, $fieldvalues, $option, $tabid ) {
		global $my, $acl, $task;

		outputCbTemplate( 2 );

		if ( $row->fieldid && ( ! $row->published ) ) {
			echo '<div class="cbWarning">Field is not published</div>' . "\n";
		}

?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
  function getObject(obj) {
    var strObj;
    if (document.all) {
      strObj = document.all.item(obj);
    } else if (document.getElementById) {
      strObj = document.getElementById(obj);
    }
    return strObj;
  }
  
   function submitbutton(pressbutton) {
     if (pressbutton == 'showField') {
       document.adminForm.type.disabled=false;
       submitform(pressbutton);
       return;
     }
     var coll = document.adminForm;
     var errorMSG = '';
     var iserror=0;
     if (coll != null) {
       var elements = coll.elements;
       // loop through all input elements in form
       for (var i=0; i < elements.length; i++) {
         // check if element is mandatory; here mosReq=1
         if ( (typeof(elements.item(i).getAttribute('mosReq')) != "undefined") && (elements.item(i).getAttribute('mosReq') == 1) ) {
           if (elements.item(i).value == '') {
             //alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
             // add up all error messages
             errorMSG += elements.item(i).getAttribute('mosLabel') + ' : <?php echo _UE_REQUIRED_ERROR; ?>\n';
             // notify user by changing background color, in this case to red
             elements.item(i).style.backgroundColor = "red";
             iserror=1;
           }
         }
       }
     }
     if(iserror==1) {
       alert(errorMSG);
     } else {
       document.adminForm.type.disabled=false;
       submitform(pressbutton);
     }
   }

  function insertRow() {
    var oTable = getObject("fieldValuesBody");
    var oRow, oCell ,oCellCont, oInput;
    var i, j;
    i=document.adminForm.valueCount.value;
    i++;
    // Create and insert rows and cells into the first body.
    oRow = document.createElement("TR");
    oTable.appendChild(oRow);

    oCell = document.createElement("TD");
    oInput=document.createElement("INPUT");
    oInput.name="vNames["+i+"]";
    oInput.setAttribute('mosLabel','Name');
    oInput.setAttribute('mosReq',0);
    oCell.appendChild(oInput);
    oRow.appendChild(oCell);
    oInput.focus();

    document.adminForm.valueCount.value=i;
  }

  function disableAll() {
    var elem;
    elem=getObject('divValues');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divColsRows');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divWeb');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divText');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    if (elem=getObject('vNames[0]')) {
      elem.setAttribute('mosReq',0);
    }
  }
  
  function selType(sType) {
    var elem;
    //alert(sType);
    switch (sType) {
      case 'editorta':
      case 'textarea':
        disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;
      
      case 'emailaddress':
      case 'password':
      case 'text':
        disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;
      
      case 'select':
      case 'multiselect':
        disableAll();
        elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
      break;
      
      case 'radio':
      case 'multicheckbox':
        disableAll();
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
      break;

      case 'webaddress':
        disableAll();
        elem=getObject('divWeb');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;

      case 'delimiter':
      default: 
        disableAll();
    }
  }

  function prep4SQL(o){
	if(o.value!='') {
		var cbsqloldvalue, cbsqlnewvalue;
		o.value=o.value.replace('cb_','');
		cbsqloldvalue = o.value;
		o.value=o.value.replace(/[^a-zA-Z]+/g,'');
		cbsqlnewvalue = o.value;
		o.value='cb_' + o.value;
		if (cbsqloldvalue != cbsqlnewvalue) {
			alert("Warning: SQL name of field has been changed to fit SQL constraints")
		}
	}
  }

//--><!]]></script>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="../components/com_comprofiler/images/cbfield.gif" align="middle" /><?php echo $row->fieldid ? 'Edit' : 'Add';?> Field</td>
		</tr>
	</table>

	<form action="index2.php?option=com_comprofiler&task=saveField" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%">Type:</td>
			<td width="20%"><?php echo $lists['type']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Tab:</td>
			<td width="20%"><?php echo $lists['tabs']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Name:</td>
			<td align=left  width="20%"><input onchange="prep4SQL(this);" type="text" name="name" maxlength='64' mosReq=1 mosLabel="Name" class="inputbox" value="<?php echo $row->name; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Title:</td>
			<td width="20%" align=left><input type="text" name="title" mosReq=1 mosLabel="Title" class="inputbox" value="<?php echo $row->title; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Description/"i" field-tip: text or HTML:</td>
			<td width="20%" align=left><textarea name="description" cols=50 rows=6 maxlength='255' mosReq=0 mosLabel="Description" class="inputbox"><?php echo $row->description; ?></textarea></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Required?:</td>
			<td width="20%"><?php echo $lists['required']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Show on Profile?:</td>
			<td width="20%"><?php echo $lists['profile']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">User Read Only?:</td>
			<td width="20%"><?php echo $lists['readonly']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Show at Registration?:</td>
			<td width="20%"><?php echo $lists['registration']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Published:</td>
			<td width="20%"><?php echo $lists['published']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Size:</td>
			<td width="20%"><input type="text" name="size" mosLabel="Size" class="inputbox" value="<?php echo $row->size; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		<div id=page1  class="pagetext">
		
		</div>
		<div id=divText  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%">Max Length:</td>
			<td width="20%"><input type="text" name="maxlength" mosLabel="Max Length" class="inputbox" value="<?php echo $row->maxlength; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divColsRows  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%">Cols:</td>
			<td width="20%"><input type="text" name="cols" mosLabel="Cols" class="inputbox" value="<?php echo $row->cols; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%">Rows:</td>
			<td width="20%"><input type="text" name="rows"  mosLabel="Rows" class="inputbox" value="<?php echo $row->rows; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divWeb  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%">Type:</td>
			<td width="20%"><?php echo $lists['webaddresstypes']; ?></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divValues style="text-align:left;">
		Use the table below to add new values.<br />
		<input type=button onclick="insertRow();" value="Add a Value" />
		<table align=left id="divFieldValues" cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform" >
		<thead>
			<th width="20%">Name</th>
		</thead>
		<tbody id="fieldValuesBody">
		<tr>
			<td></td>
		</tr>
	<?php	
		//echo "count:".count( $fieldvalues );
		//print_r (array_values($fieldvalues));
		for ($i=0, $n=count( $fieldvalues ); $i < $n; $i++) {
			//print "count:".$i;
			$fieldvalue = $fieldvalues[$i];
			if ($i==0) $req =1;
			else $req = 0;
			echo "<tr>\n<td width=\"20%\"><input type=text mosReq=$req  mosLabel='Value' value=\"".stripslashes($fieldvalue->fieldtitle)."\" name=vNames[".$i."] /></td></tr>\n";
		}
		if(count( $fieldvalues )< 1) {
			echo "<tr>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Value' value='' name=vNames[0] /></td></tr>\n";
			$i=0;
		}
	?>
		</tbody>
		</table>
		</div>
  <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>

  </table>
  <input type="hidden" name="valueCount" value=<?php echo $i; ?> />
  <input type="hidden" name="oldtabid" value="<?php echo $row->tabid; ?>" />
  <input type="hidden" name="fieldid" value="<?php echo $row->fieldid; ?>" />
  <input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="" />
</form>
  
<?php 
	if($row->fieldid > 0) {
		print "<script type=\"text/javascript\"> document.adminForm.name.readOnly=true; </script>";	
		print "<script type=\"text/javascript\"> document.adminForm.type.disabled=true; </script>";		
	}
		print "<script type=\"text/javascript\"> disableAll(); </script>";
		print "<script type=\"text/javascript\"> selType('".$row->type."'); </script>";	
}


	function showTabs( &$rows, $pageNav, $search, $option ) {
		global $acl, $mosConfig_offset;
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
function cbsaveorder( n ) {
	cbcheckAll_button( n );
	submitform('savetaborder');
}

//needed by sbsaveorder function
function cbcheckAll_button( n ) {
	for ( var j = 0; j <= n; j++ ) {
		box = eval( "document.adminForm.cb" + j );
		if ( box.checked == false ) {
			box.checked = true;
		}
	}
}
//--><!]]></script>
<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="../components/com_comprofiler/images/cbtab.gif" align="middle" />Tab Manager</td>
      <td nowrap="nowrap">Display #</td>
      <td> <?php echo $pageNav->writeLimitBox(); ?> </td>
      <td>Search:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</th>
      <th width="2%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" /></th>
      <th width="18%" class="title">Title</th>
      <th width="30%" class="title">Description</th>
      <th width="10%" class="title">Display</th>
      <th width="15%" class="title">Plugin</th>
      <th width="5%" class="title">Published</th>
      <th width="10%" class="title">Access</th>
      <th width="5%" class="title">Position</th>
      <th width="5%" class="title" colspan="2">Re-Order</th>
      <th width="3%"><a href="javascript: cbsaveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a></th>
    </tr>
<?php
		$k = 0;
		$imgpath='../components/com_comprofiler/images/';
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row =& $rows[$i];
			if($row->sys==2) {
				$img3='tick.png';
				$task3=null;
			} else {
			        $img3 = $row->enabled ?  'tick.png' : 'publish_x.png';
			        $task3 = $row->enabled ?  'tabPublishedNo' : 'tabPublishedYes';
			}
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->tabid; ?>" onclick="isChecked(this.checked);" /></td>
      <td> <a href="#editTab" onclick="return listItemTask('cb<?php echo $i;?>','editTab')">
        <?php echo getLangDefinition($row->title); ?> </a> </td>
	<td><?php echo getLangDefinition($row->description); ?></td>
	<td><?php echo $row->displaytype; ?></td>
	<td><?php
      		if ( $row->pluginid && ( $row->pluginpublished == 0 ) ) {
      			echo '<span style="color:red;" title="tab will not be visible as plugin is not published.">';
      		}
			echo ( ( $row->pluginname) ? $row->pluginname : "-" );
     		if ( $row->pluginid && ( $row->pluginpublished == 0 ) ) {
     			echo '</span>';
     		}
	  ?></td>
	<?php $task3 = ($task3==null) ? " " : "onClick=\"return listItemTask('cb".$i."','".$task3."')\"" ; ?>
      <td><a href="javascript: void(0);" <?php echo $task3; ?> ><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
	  <td><?php 
	  		if ( $row->useraccessgroupid >= 0 ) {
		  		echo '<span style="color:red;">' . $acl->get_group_name( (int) $row->useraccessgroupid ) . '</span>';
	  		} elseif ( $row->useraccessgroupid == -2 ) {
	  			echo '<span style="color:green;">Everybody</span>';
	  		} elseif ( $row->useraccessgroupid == -1 ) {
	  			echo '<span style="color:orange;">All Registered Users</span>';
	  		}
	  ?></td>
	<td><?php echo substr($row->position, 3); ?></td>
      <td>
	<?php    if (($i > 0 || ($i+$pageNav->limitstart > 0)) && $row->position == @$rows[$i-1]->position) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupTab')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up" />
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if (($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) && $row->position == @$rows[$i+1]->position) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownTab')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down" />
         </a>
	<?php    } ?>
      </td>
	  <td align="center" colspan="2">
	  <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
	  </td>      
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="14"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="14"> <?php echo $pageNav->writePagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showTab" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

	function edittab( &$row, $option, &$lists, $tabid ) {
		global $my, $acl, $task,$_CB_database,$mainframe,$mosConfig_live_site, $_PLUGINS;

		outputCbTemplate( 2 );

		$row->nameA = '';
		if ( $row->tabid ) {
			$row->nameA = '<small><small>[ '. $row->title .' ]</small></small>';
		}

		if ( $row->tabid && ( ! $row->enabled ) ) {
			echo '<div class="cbWarning">Tab is not published</div>' . "\n";
		}

?>
	<script type="text/javascript"><!--//--><![CDATA[//><!--
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'showTab') {
				submitform( pressbutton );
				return;
			}
			var r = new RegExp("[^0-9A-Za-z]", "i");

			// do field validation
			if (trim(form.title.value) == "") {
				alert( "You must provide a title." );
			} else {
				submitform( pressbutton );
			}
		}
//--><!]]></script>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="../components/com_comprofiler/images/cbtab.gif" align="middle" /><?php echo $row->tabid ? 'Edit' : 'Add';?> Tab
			<?php echo $row->nameA; ?>
			</td>
		</tr>
	</table>

	<form action="index2.php?option=com_comprofiler&task=saveTab" method="POST" name="adminForm">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
		<td width="60%" valign="top">
			<table class="adminform">
			<tr>
				<th colspan="3">
				Tab Details
				</th>
			</tr>
			<tr>
				<td width="20%">Title:</td>
				<td width="35%"><input type="text" name="title" class="inputbox" size="40" value="<?php echo $row->title; ?>" /></td>
				<td width="45%">Title as will appear on tab.</td>
			</tr>
			<tr>
				<td>Description:</td>
				<td><textarea name="description" class="inputbox" cols="40" rows="10"><?php echo $row->description; ?></textarea></td>
				<td>This description appears only on user edit, not on profile. For profile text, use delimiter fields.</td>
			</tr>
			<tr>
				<td>Publish:</td>
				<td><?php echo $lists['enabled']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Profile ordering:</td>
				<td><?php echo $lists['ordering']; ?></td>
				<td>Tabs and fields on profile are ordered as follows:<ol>
				    <li>position of tab on user profile (top-down, left-right)</li>
				    <li>This ordering of tab on position of user profile</li>
				    <li>ordering of field within tab position of user profile.</li></ol>
				</td>
			</tr>
			<tr>
				<td>Registration ordering<br />(default value: 10):</td>
				<td><input type="text" name="ordering_register" class="inputbox" size="40" value="<?php echo $row->ordering_register; ?>" /></td>
				<td>Tabs and fields on registration are ordered as follows:<ol>
					<li>This registration ordering of tab</li>
				    <li>position of tab on user profile (top-down, left-right)</li>
				    <li>ordering of tab on position of user profile</li>
				    <li>ordering of field within tab position of user profile.</li></ol>
				</td>
			</tr>
			<tr>
				<td>Position:</td>
				<td><?php echo $lists['position']; ?></td>
				<td>Position on profile and ordering on registration.</td>
			</tr>
			<tr>
				<td>Display type:</td>
				<td><?php echo $lists['displaytype']; ?></td>
				<td>In which way the content of this tab will be displayed on the profile.</td>
			</tr>
			<tr>
				<td>User Group to allow access to:</td>
				<td><?php echo $lists['useraccessgroup']; ?></td>
				<td>All groups above that level will also have access to the list.</td>
			</tr>
			</table>
		</td>
		<td width="40%">
			<table class="adminform">
			<tr>
				<th colspan="2">
				Parameters
				</th>
			</tr>
			<tr>
				<td>
				<?php
				if ( $row->tabid && $row->pluginid > 0 ) {
					$plugin= new moscomprofilerPlugin($_CB_database);
					$plugin->load( (int) $row->pluginid);

					// fail if checked out not by 'me'
					if ($plugin->checked_out && $plugin->checked_out <> $my->id) {
						echo "<script type=\"text/javascript\">alert('The plugin $plugin->name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</script>\n";
						exit(0);
					}
				
					// get params values
					if ( $plugin->type !== "language" && $plugin->id ) {
						$_PLUGINS->loadPluginGroup($plugin->type,array($plugin->id), 0);
					}

					$element	=	_loadPluginXML( $plugin, 'editTab', $row->pluginclass );
/*
					$xmlfile = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' .$plugin->type . '/'.$plugin->folder . '/' . $plugin->element .'.xml';
					// $params =& new cbParameters( $row->params, $xmlfile );
					cbimport('cb.xml.simplexml');
					$xmlDoc =& new CBSimpleXML();
					if ( $xmlDoc->loadFile( $xmlfile ) ) {
						$element =& $xmlDoc->document;
					} else {
						$element = null;
					}
*/
					$pluginParams = new cbParamsBase( $plugin->params );
					
					$params =& new cbParamsEditorController( $row->params, $element, $element, $plugin, $row->tabid );
					$params->setPluginParams( $pluginParams );
					$options = array( 'option' => $option, 'task' => $task, 'pluginid' => $row->pluginid, 'tabid' => $row->tabid );
					$params->setOptions( $options );

					echo $params->draw( 'params', 'tabs', 'tab', 'class', $row->pluginclass );
				} else {
					echo '<i>No Parameters</i>';
				}
				?>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
  <input type="hidden" name="tabid" value="<?php echo $row->tabid; ?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="" />
</form>
<script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
<?php }

	function showUsers( &$rows, $pageNav, $search, $option, $lists ) {
		global $mosConfig_offset, $_CB_database;
?>
<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="../components/com_comprofiler/images/cbuser.gif" align="middle" />User Manager</td>
      <td>Search:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
	  <td width="right">
		<?php echo $lists['logged'];?>
	  </td>
	  <td width="right">
		<?php echo $lists['type'];?>
	  </td>
	  <td width="right">
		<?php echo $lists['status'];?>
	  </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th align="center" colspan="13"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <th width="1%" class="title">#</th>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="15%" class="title">Name</th>
      <th width="10%" class="title">UserName</th>
      <th width="5%" class="title" nowrap="nowrap">Logged In</th>
      <th width="15%" class="title">Group</th>
      <th width="15%" class="title">E-Mail</th>
      <th width="10%" class="title">Registered</th>
      <th width="10%" class="title" nowrap="nowrap">Last Visit</th>
      <th width="5%" class="title">Enabled</th>
      <th width="5%" class="title">Confirmed</th>
      <th width="5%" class="title">Approved</th>
      <th width="1%" class="title">ID</th>
    </tr>
<?php
		$k = 0;
		$imgpath='../components/com_comprofiler/images/';
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row =& $rows[$i];
			$img = $row->block ? 'publish_x.png' : 'tick.png';
			$task = $row->block ? 'unblock' : 'block';
			$hover1 = $row->block ? 'Blocked' : 'Enabled';
			
			switch ($row->approved) {
				case 0:
	        		$img2 = 'pending.png';
	        		$task2 = 'approve';
					$hover = 'Pending Approval';
				break;
				case 1:
	        		$img2 = 'tick.png';
	        		$task2 = 'reject';
					$hover = 'Approved';
				break;				
				case 2:
	        		$img2 = 'publish_x.png';
	        		$task2 = 'approve';
					$hover = 'Rejected';
				break;				

			}

		        $img3 = $row->confirmed ?  'tick.png' : 'publish_x.png';
		        $task3 = $row->confirmed ?   'reject' : 'approve';
		        $hover3 = $row->confirmed ?   'confirmed' : 'unconfirmed';

?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
        <?php echo $row->name; ?> </a> </td>
      <td><?php echo $row->username; ?></td>
      <td align="center"><?php echo $row->loggedin ? '<img src="images/tick.png" width="12" height="12" border="0" alt="" />': ''; ?></td>
      <td><?php echo $row->groupname; ?></td>
      <td><a href="mailto:<?php echo htmlspecialchars( $row->email ); ?>"><?php echo htmlspecialchars( $row->email ); ?></a></td>
      <td><?php echo cbFormatDate( $row->registerDate ); ?></td>
      <td><?php echo cbFormatDate( $row->lastvisitDate ); ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="<?php echo $imgpath.$img;?>" width="12" height="12" border="0" title="<?php echo $hover1; ?>" alt="<?php echo $hover1; ?>" /></a></td>
      <td width="10%"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" title="<?php echo $hover3; ?>" alt="<?php echo $hover3; ?>" /></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task2;?>')"><img src="<?php echo $imgpath.$img2;?>" width="12" height="12" border="0" title="<?php echo $hover; ?>" alt="<?php echo $hover; ?>" /></a></td>
      <td><?php echo $row->id; ?></td>

    </tr>
    <?php $k = 1 - $k;
		} ?>
    <tr>
      <th align="center" colspan="13"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="13"> <?php echo "Display "; echo $pageNav->writeLimitBox(); echo " &nbsp; &nbsp;"; echo $pageNav->writePagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showusers" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

	function edituser( $user, $option, $uid, $newCBuser) {
		global $my, $acl,$_CB_database,$ueConfig,$mosConfig_live_site;
		outputCbTemplate(2);
		echo initToolTip(2);
		$calendars = new cbCalendars(2);	
		$tabs = new cbTabs( 0, 2, $calendars );
		$tabcontent=$tabs->getEditTabs($user);
?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
function getObject(obj) {
	var strObj;
	if (document.all) {
		strObj = document.all.item(obj);
	} else if (document.getElementById) {
		strObj = document.getElementById(obj);
	}
	return strObj;
}
function submitbutton(pressbutton) {
	if (pressbutton == 'showusers') {
		/* submitform(pressbutton); */
		document.forms['adminForm'].task.value=pressbutton;
		document.forms['adminForm'].submit();
		return;
	} else {
		if (submitmyform(document.forms['adminForm'])) {
			/* submitform(pressbutton) : */
			document.forms['adminForm'].task.value=pressbutton;
			try {
				document.forms['adminForm'].onsubmit();
				}
			catch(e){}
			document.forms['adminForm'].submit();
		}
		return;
	}
}
var cbDefaultFieldbackgroundColor;
function submitmyform(mfrm) {
	var me = mfrm.elements;
<?php
$version = checkJversion();
if ($version == 1) {
?>
	var r = new RegExp("^[a-zA-Z](([\.\-a-zA-Z0-9@])?[a-zA-Z0-9]*)*$", "i");
<?php
} elseif ( $version == -1 ) {
?>
	var r = new RegExp("[^A-Za-z0-9]", "i");
<?php
} else {
?>
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
<?php
}
?>
	var errorMSG = '';
	var iserror=0;
	if (cbDefaultFieldbackgroundColor === undefined) cbDefaultFieldbackgroundColor = ((me['username'].style.getPropertyValue) ? me['username'].style.getPropertyValue("backgroundColor") : me['username'].style.backgroundColor);
<?php echo $tabs->fieldJS; ?>
	if (me['username'].value == "") {
		errorMSG += "<?php echo unhtmlentities(_REGWARN_UNAME);?>\n";
		me['username'].style.backgroundColor = "red";
		iserror=1;
	} else if (<?php if ($version==1) echo "!"; ?>r.exec(me['username'].value) || (me['username'].value.length < 3)) {
		errorMSG += "<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_PROMPT_UNAME), 2 );?>\n";
		me['username'].style.backgroundColor = "red";
		iserror=1;
	} else if (me['username'].style.backgroundColor.slice(0,3)=="red") {
		me['username'].style.backgroundColor = cbDefaultFieldbackgroundColor;
	}
	if ((me['password'].value) && (<?php if ($version==1) echo "!"; ?>r.exec(me['password'].value) || (me['password'].value.length < 6))) {
		errorMSG += "<?php printf( unhtmlentities(_VALID_AZ09), unhtmlentities(_REGISTER_PASS), 6 );?>\n";
		me['password'].style.backgroundColor = "red";
		iserror=1;
	} else if ((me['password'].value != "") && (me['password'].value != me['verifyPass'].value)){
		errorMSG += "<?php echo unhtmlentities(_REGWARN_VPASS2);?>\n";
		me['password'].style.backgroundColor = "red"; me['verifyPass'].style.backgroundColor = "red";
		iserror=1;
	} else {
		if (me['password'].style.backgroundColor.slice(0,3)=="red") me['password'].style.backgroundColor = cbDefaultFieldbackgroundColor;
		if (me['verifyPass'].style.backgroundColor.slice(0,3)=="red") me['verifyPass'].style.backgroundColor = cbDefaultFieldbackgroundColor;
	}
	if (me['gid'].value == "") {
		errorMSG += "You must assign user to a group.\n";
		iserror=1;
	}

	// loop through all input elements in form
	for (var i=0; i < me.length; i++) {
		// check if element is mandatory; here mosReq=1
		if ( (typeof(me[i].getAttribute('mosReq')) != "undefined") && ( me[i].getAttribute('mosReq') == 1) ) {
			if (me[i].type == 'radio' || me[i].type == 'checkbox') {
				var rOptions = me[me[i].getAttribute('name')];
				var rChecked = 0;
				if(rOptions.length > 1) {
					for (var r=0; r < rOptions.length; r++) {
						if (rOptions[r].checked) {
							rChecked=1;
						}
					}
				} else {
					if (me[i].checked) {
						rChecked=1;
					}
				}
				if(rChecked==0) {
					// add up all error messages
					errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
					// notify user by changing background color, in this case to red
					me[i].style.backgroundColor = "red";
					iserror=1;
				} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldbackgroundColor;
			}
			if (me[i].value == '') {
				// add up all error messages
				errorMSG += me[i].getAttribute('mosLabel') + ' : <?php echo unhtmlentities(_UE_REQUIRED_ERROR); ?>\n';
				// notify user by changing background color, in this case to red
				me[i].style.backgroundColor = "red";
				iserror=1;
			} else if (me[i].style.backgroundColor.slice(0,3)=="red") me[i].style.backgroundColor = cbDefaultFieldbackgroundColor;
		}
	}
	if(iserror==1) {
		alert(errorMSG);
		return false;
	} else {
		return true;
	}
}
//--><!]]></script>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="../components/com_comprofiler/images/cbuser.gif" align="middle" /><?php echo $user->id ? 'Edit' : 'Add';?> User</td>
		</tr>
	</table>
	<form action="index2.php" method="post" name="adminForm" id="adminForm" onsubmit="return submitmyform(this)" autocomplete="off">
<style type="text/css">
/* over ride styles from webfxlayout */
.dynamic-tab-pane-control h2 {
	text-align:	center;
	width:		auto;
}

.dynamic-tab-pane-control h2 a {
	display:	inline;
	width:		auto;
}

.dynamic-tab-pane-control a:hover {
	background: transparent;
}
</style>
<?php
echo "<table cellspacing='0' cellpadding='4' border='0' width='100%' id='userEditTable'><tr><td width='100%'>\n";
echo $tabcontent;
echo "</td></tr></table>";
?>
  <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
  <input type="hidden" name="newCBuser" value="<?php echo $newCBuser; ?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="save" />
</form>
<div style="align:center;">
<?php
echo getFieldIcons(2,true,true,"","",true);
if(isset($_REQUEST['tab'])) echo "<script type=\"text/javascript\"> showCBTab( '".urldecode($_REQUEST['tab'])."' ); </script>\n";
?>
</div>
<?php }

   function showConfig( &$ueConfig, &$lists, $option ) {
   	global $mosConfig_live_site, $mosConfig_gzip;

	//based on this trackermessage, ob_flush and flush don't play nicely with gzip enabled.. disable it because of that..
	// $mosConfig_gzip = 0;

	outputCbTemplate(2);
	outputCbJs(2);

?>
<style type="text/css">

/* over ride styles from webfxlayout */


.dynamic-tab-pane-control h2 {
	text-align:	center;
	width:		auto;
}

.dynamic-tab-pane-control h2 a {
	display:	inline;
	width:		auto;
}

.dynamic-tab-pane-control a:hover {
	background: transparent;
}
</style>

	<table cellpadding="4" cellspacing="0" border="0" width="95%">
		<tr>
			<td class="sectionname"><img src="../components/com_comprofiler/images/cbconfig.gif" align="middle" /><?php echo _UE_REG_CONFIGURATION_MANAGER; ?></td>
		</tr>
	</table>
<?php update_checker(); ?><br />
   <form action="index2.php" method="post" name="adminForm">
   <table cellspacing='0' cellpadding='4' border='0' width='100%'><tr><td width='100%'>
<?php
$tabs = new cbTabs( 0,2 );
?>
<?php

echo $tabs->startPane( "CB" );
echo $tabs->startTab("CB",_UE_GENERAL,"tab1");
?>

   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NAME_STYLE ?></td>
         <td align="left" valign="top"><?php echo $lists['name_style']; ?></td>
         <td align="left" valign="top"><?php echo _UE_NAME_STYLE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NAME_FORMAT ?></td>
         <td align="left" valign="top"><?php echo $lists['name_format']; ?></td>
         <td align="left" valign="top"><?php echo _UE_NAME_FORMAT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_DATE_FORMAT ?></td>
         <td align="left" valign="top"><?php echo $lists['date_format']; ?></td>
         <td align="left" valign="top"><?php echo _UE_DATE_FORMAT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CALENDAR_TYPE ?></td>
         <td align="left" valign="top"><?php echo $lists['calendar_type']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CALENDAR_TYPE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_DISPLAY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_email_display']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_DISPLAY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_REPLYTO ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_email_replyto']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_REPLYTO_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_email']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_WEBSITE ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_website']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_WEBSITE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_ONLINESTATUS ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_onlinestatus']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_ONLINESTATUS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();
echo $tabs->startTab("CB",_UE_REGISTRATION,"tab2");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_CB_ALLOW ?></td>
         <td align="left" valign="top"><?php echo $lists['admin_allowcbregistration']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_CB_ALLOW_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_ADMIN_APPROVAL ?></td>
         <td align="left" valign="top"><?php echo $lists['admin_approval']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_ADMIN_APPROVAL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_CONFIRMATION ?></td>
         <td align="left" valign="top"><?php echo $lists['confirmation']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_CONFIRMATION_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_USERNAMECHECKER ?></td>
         <td align="left" valign="top"><?php echo $lists['reg_username_checker']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_USERNAMECHECKER_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_NAME ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_email_name" value="<?php echo htmlspecialchars(stripslashes($ueConfig['reg_email_name'])); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_NAME_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_FROM ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_email_from" value="<?php echo htmlspecialchars($ueConfig['reg_email_from']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_FROM_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_REPLYTO ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_email_replyto" value="<?php echo htmlspecialchars($ueConfig['reg_email_replyto']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_REPLYTO_DESC ?></td>
      </tr>
      <tr  align="left" valign="middle">
	 <td align="left" valign="top"></td>
	 <td align="left" valign="top" colspan="2"><?php echo _UE_REG_EMAIL_TAGS; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PEND_APPR_SUB ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_pend_appr_sub" value="<?php echo htmlspecialchars(stripslashes($ueConfig['reg_pend_appr_sub'])); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_PEND_APPR_SUB_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PEND_APPR_MSG ?></td>
         <td align="left" valign="top" colspan=2><textarea name="cfg_reg_pend_appr_msg" cols=50 rows=6><?php echo htmlspecialchars(stripslashes($ueConfig['reg_pend_appr_msg'])); ?></textarea></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_WELCOME_SUB ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_welcome_sub" value="<?php echo htmlspecialchars(stripslashes($ueConfig['reg_welcome_sub'])); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_WELCOME_SUB_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_WELCOME_MSG ?></td>
         <td align="left" valign="top" colspan=2><textarea name="cfg_reg_welcome_msg" cols=50 rows=6><?php echo htmlspecialchars(stripslashes($ueConfig['reg_welcome_msg'])); ?></textarea></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_INTRO_MSG ?></td>
         <td align="left" valign="top"><textarea name="cfg_reg_intro_msg" cols=50 rows=6><?php echo htmlspecialchars(stripslashes($ueConfig['reg_intro_msg'])); ?></textarea></td>
         <td align="left" valign="top"><?php echo _UE_REG_INTRO_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_CONCLUSION_MSG ?></td>
         <td align="left" valign="top"><textarea name="cfg_reg_conclusion_msg" cols=50 rows=6><?php echo htmlspecialchars(stripslashes($ueConfig['reg_conclusion_msg'])); ?></textarea></td>
         <td align="left" valign="top"><?php echo _UE_REG_CONCLUSION_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_TOC_MSG ?></td>
         <td align="left" valign="top"><?php echo $lists['reg_enable_toc']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_TOC_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_TOC_URL_MSG ?></td>
         <td align="left" valign="top"><input type="text" size="50" name="cfg_reg_toc_url" value="<?php echo htmlspecialchars($ueConfig['reg_toc_url']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_TOC_URL_DESC ?></td>
      </tr>
     <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_FIRST_VISIT_URL_MSG ?></td>
         <td align="left" valign="top"><input type="text" size="50" name="cfg_reg_first_visit_url" value="<?php echo htmlspecialchars($ueConfig['reg_first_visit_url']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_FIRST_VISIT_URL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();
echo $tabs->startTab("CB",_UE_USERLIST,"tab3");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NUM_PER_PAGE ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_num_per_page" value="<?php echo htmlspecialchars($ueConfig['num_per_page']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_NUM_PER_PAGE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILELINK ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_profilelink']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILELINK_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();
echo $tabs->startTab("CB",_UE_USERPROFILE,"tab4");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERNAME ?></td>
         <td align="left" valign="top"><?php echo $lists['usernameedit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USERNAME_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ADMINREQUIREDFIELDS ?></td>
         <td align="left" valign="top"><?php echo $lists['adminrequiredfields']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ADMINREQUIREDFIELDS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILEVIEWBY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_profileviewbyGID']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILEVIEWBY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_MINHITSINTV ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_minHitsInterval" value="<?php echo htmlspecialchars($ueConfig['minHitsInterval']);?>" /></td>
         <td align="left" valign="top"><?php echo _UE_MINHITSINTV_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TEMPLATEDIR ?></td>
         <td align="left" valign="top"><?php echo $lists['templatedir']; ?></td>
         <td align="left" valign="top"><?php echo _UE_TEMPLATEDIR_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PROFILE_2COLS ?></td>
         <td align="left" valign="top"><?php echo _UE_LEFT ?>: <input type="text" size="2" name="cfg_left2colsWidth" value="<?php echo htmlspecialchars($ueConfig['left2colsWidth']);?>" /> %&nbsp;&nbsp;&nbsp;&nbsp;<?php echo _UE_REG_PROFILE_2COLS_RIGHT_REST ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_PROFILE_2COLS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PROFILE_3COLS ?></td>
         <td align="left" valign="top"><?php echo _UE_LEFT ?>: <input type="text" size="2" name="cfg_left3colsWidth" value="<?php echo htmlspecialchars($ueConfig['left3colsWidth']);?>" /> %&nbsp;&nbsp;&nbsp;&nbsp;
         							  <?php echo _UE_RIGHT ?>: <input type="text" size="2" name="cfg_right3colsWidth" value="<?php echo htmlspecialchars($ueConfig['right3colsWidth']);?>" /> %</td>
         <td align="left" valign="top"><?php echo _UE_REG_PROFILE_3COLS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NESTTABS ?></td>
         <td align="left" valign="top"><?php echo $lists['nesttabs']; ?></td>
         <td align="left" valign="top"><?php echo _UE_NESTTABS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_XHTMLCOMPLY ?></td>
         <td align="left" valign="top"><?php echo $lists['xhtmlComply']; ?></td>
         <td align="left" valign="top"><?php echo _UE_XHTMLCOMPLY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_FILTER_ALLOWED_TAGS ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_html_filter_allowed_tags" value="<?php echo htmlspecialchars($ueConfig['html_filter_allowed_tags']);?>" /></td>
         <td align="left" valign="top"><?php echo  _UE_REG_FILTER_ALLOWED_TAGS_DESC . '<br />' . $lists['_filteredbydefault']; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();


$imgToolBox = new imgToolBox();
$imageLibs = $imgToolBox->getImageLibs();

echo $tabs->startTab("CB",_UE_AVATARS,"tab5");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	 <tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _UE_IMPATH;?></td>
		<td align="left" valign="top">
			<input type="text" name="cfg_im_path" value="<?php echo (array_key_exists('imagemagick',$imageLibs)) ? 'auto' : htmlspecialchars($ueConfig['im_path']);?>" size="40" >
		</td>
		<td align="left" valign="top">
			<?php echo _UE_IMPATH_DESC;?>
		</td>
	</tr>
	 <tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _UE_NETPBMPATH;?></td>
		<td align="left" valign="top">
			<input type="text" name="cfg_netpbm_path" value="<?php echo (array_key_exists('netpbm',$imageLibs)) ? 'auto' : htmlspecialchars($ueConfig['netpbm_path']);?>" size="40" >
		</td>
		<td align="left" valign="top">
			<?php echo _UE_NETPBMPATH_DESC;?>
		</td>
	</tr>
      <tr align="center" valign="middle">
	<td align="left" valign="top">
		<?php echo _UE_CONVERSIONTYPE;?>
	</td>	
	<td align="left" valign="top">
	<?php echo $lists['conversiontype']; ?>
	</td>
	<td align="left" valign="top">
		<a href="http://www.imagemagick.org" target=_blank>ImageMagick</a>&nbsp;&nbsp;
			<?php if(array_key_exists('imagemagick',$imageLibs)) echo '<strong><font color="green">'._UE_AUTODET.' '.$imageLibs['imagemagick'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</font></strong>'; ?>
			<br />
		<a href="http://sourceforge.net/projects/netpbm" target=_blank>NetPBM</a>&nbsp;&nbsp;
			<?php if(array_key_exists('netpbm',$imageLibs)) echo '<strong><font color="green">'._UE_AUTODET.' '.$imageLibs['netpbm'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</font></strong>'; ?>
			<br />
		GD1 library 
			<?php if(array_key_exists('gd1',$imageLibs['gd'])) echo '&nbsp;&nbsp;<strong><font color="green">'._UE_AUTODET.', '.$imageLibs['gd']['gd1'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</font></strong>'; ?>
			<br />
		GD2 library 
			<?php if(array_key_exists('gd2',$imageLibs['gd'])) echo '&nbsp;&nbsp;<strong><font color="green">'._UE_AUTODET.', '.$imageLibs['gd']['gd2'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</font></strong>'; ?>

	</td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATAR ?></td>
         <td align="left" valign="top"><?php echo $lists['allowAvatar']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATAR_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOAD ?></td>
         <td align="left" valign="top"><?php echo $lists['allowAvatarUpload']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOAD_DESC ?></td>
      </tr>      
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARGALLERY ?></td>
         <td align="left" valign="top"><?php echo $lists['allowAvatarGallery']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARGALLERY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVHEIGHT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_avatarHeight" value="<?php echo htmlspecialchars($ueConfig['avatarHeight']);?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVWIDTH ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_avatarWidth" value="<?php echo htmlspecialchars($ueConfig['avatarWidth']);?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVSIZE ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_avatarSize" value="<?php echo htmlspecialchars($ueConfig['avatarSize']);?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TNHEIGHT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_thumbHeight" value="<?php echo htmlspecialchars($ueConfig['thumbHeight']);?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TNWIDTH ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_thumbWidth" value="<?php echo htmlspecialchars($ueConfig['thumbWidth']);?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();
echo $tabs->startTab("CB",_UE_MODERATE,"tab6");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOADAPPROVALGROUP ?></td>
         <td align="left" valign="top"><?php echo $lists['imageApproverGid']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOADAPPROVALGROUP_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_MODERATORUSERAPPOVAL ?></td>
         <td align="left" valign="top"><?php echo $lists['allowModUserApproval']; ?></td>
         <td align="left" valign="top"><?php echo _UE_MODERATORUSERAPPOVAL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_MODERATOREMAIL ?></td>
         <td align="left" valign="top"><?php echo $lists['moderatorEmail']; ?></td>
         <td align="left" valign="top"><?php echo _UE_MODERATOREMAIL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOWUSERREPORTS ?></td>
         <td align="left" valign="top"><?php echo $lists['allowUserReports']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOWUSERREPORTS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOADAPPROVAL ?></td>
         <td align="left" valign="top"><?php echo $lists['avatarUploadApproval']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOADAPPROVAL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOWMODERATORSUSEREDIT ?></td>
         <td align="left" valign="top"><?php echo $lists['allowModeratorsUserEdit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOWMODERATORSUSEREDIT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOWUSERPROFILEBANNING ?></td>
         <td align="left" valign="top"><?php echo $lists['allowUserBanning']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOWUSERPROFILEBANNING_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();
echo $tabs->startTab("CB",_UE_CONNECTION,"tab7");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOWCONNECTIONS ?></td>
         <td align="left" valign="top"><?php echo $lists['allowConnections']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOWCONNECTIONS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CONNECTIONDISPLAY ?></td>
         <td align="left" valign="top"><?php echo $lists['connectionDisplay']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CONNECTIONDISPLAY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CONNECTIONPATH ?></td>
         <td align="left" valign="top"><?php echo $lists['connectionPath']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CONNECTIONPATH_DESC ?></td>
      </tr>      
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USEMUTUALCONNECTIONACCEPTANCE ?></td>
         <td align="left" valign="top"><?php echo $lists['useMutualConnections']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USEMUTUALCONNECTIONACCEPTANCE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CONNECTOINNOTIFYTYPE ?></td>
         <td align="left" valign="top"><?php echo $lists['conNotifyTypes']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CONNECTOINNOTIFYTYPE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AUTOADDCONNECTIONS ?></td>
         <td align="left" valign="top"><?php echo $lists['autoAddConnections']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AUTOADDCONNECTIONS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CONNECTIONCATEGORIES ?></td>
         <td align="left" valign="top" ><textarea name="cfg_connection_categories" cols=25 rows=6><?php echo htmlspecialchars($ueConfig['connection_categories']); ?></textarea></td>
         <td align="left" valign="top"><?php echo _UE_CONNECTIONCATEGORIES_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $tabs->endTab();
echo $tabs->startTab("CB",_UE_INTEGRATION,"tab8");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NOVERSIONCHECK ?></td>
         <td align="left" valign="top"><?php echo $lists['noVersionCheck']; ?></td>
         <td align="left" valign="top"><?php echo _UE_NOVERSIONCHECK_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_FURTHER_SETTINGS ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_FURTHER_SETTINGS_MORE ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_FURTHER_SETTINGS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>

<?php
echo $tabs->endTab();
echo $tabs->endPane();

?>
</td></tr></table>
   <input type="hidden" name="task" value="" />
   <input type="hidden" name="option" value="<?php echo $option; ?>" />
   <input type="hidden" name="cfg_version" value="<?php echo $ueConfig['version']; ?>" />
   </form>

<?php
		// flush();
		// ob_flush(); ?>
<div style="align:center;">
   <p><?php echo _UE_BY ?>
      <a href="http://www.joomlapolis.com" target="_blank">Community Builder Team of Joomlapolis</a>
      <br />
      <font class="small"><?php echo _UE_VERSION ?>: <?php echo $ueConfig['version']; ?></font>
      <?php
		// update_checker(); ?>
   </p>
</div>
<?php
   }


function showTools() {
   ?>
<div style="text-align:left;">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
	<tr>
		<td class="sectionname"><img src="../components/com_comprofiler/images/cbtool.gif" align="middle" />Tools Manager</td>
	</tr>
</table>

   <table width="90%" border="0" cellpadding="2" cellspacing="2" class="adminForm">
      <tr>
        <td>
		<a href="index2.php?option=com_comprofiler&amp;task=loadSampleData">Load Sample Data</a>
      	</td>
	<td>
		This will load sample data into the Joomla/Mambo Community Builder component.
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_comprofiler&amp;task=syncUsers">Synchronize Users</a>
      	</td>
	<td>
		This will synchronize the Joomla/Mambo User table with the Joomla/Mambo Community Builder User Table.<br />
		Please make sure before synchronizing that the user name type (first/lastname mode choice) is set correctly in 
		Components -&gt; Community Builder -&gt; Configuration -&gt; General, so that the user-synchronization imports 
		the names in the appropriate format.
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_comprofiler&task=checkcbdb">Check Community Builder Database</a>
      	</td>
	<td>
		This will perform a series of tests on the Community Builder database and report back potential inconsistencies without changing or correcting the database.
	</td>
      </tr>      
   </table>
</div>
 <?php
} //end function showTools

	/**
	* Writes a list of the defined modules
	* @param array An array of category objects
	*/
	function showPlugins( &$rows, &$pageNav, $option, &$lists, $search ) {
		global $my, $mosConfig_live_site, $mainframe;

		$p_startdir=$mainframe->getCfg('absolute_path')."/components/com_comprofiler/plugin/";
		if (is_callable(array("mosCommonHTML","loadOverlib"))) {		// 	/* Mambo 4.5.1 support: */
			mosCommonHTML::loadOverlib();
		} else {
			?>
			<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
			<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
			<?php
		}
		?>
		<script type="text/javascript"><!--//--><![CDATA[//><!--
		function cbsaveorder( n ) {
			cbcheckAll_button( n );
			submitform('savepluginorder');
		}
		//needed by cbsaveorder function
		function cbcheckAll_button( n ) {
			for ( var j = 0; j <= n; j++ ) {
				box = eval( "document.adminForm.cb" + j );
				if ( box.checked == false ) {
					box.checked = true;
				}
			}
		}
		function submitbutton3(pressbutton) {
			var form = document.adminForm_dir;
	
			// do field validation
			if (form.userfile.value == ""){
				alert( "Please select a directory" );
			} else {
				form.submit();
			}
		}
//--><!]]></script>
		

		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="modules">
			Plugin Manager <small><small>[ Site ]</small></small> &nbsp;&nbsp;&nbsp;&nbsp; <a href="#install">Install Plugin</a>
			</th>
<?php
	if (!method_exists($pageNav, "getListFooter")) {			// Mambo 4.5.0 support:
?>
			<td nowrap="nowrap">Display #</td>
			<td> <?php echo $pageNav->writeLimitBox(); ?> </td>
<?php
	}
?>
			<td>
			Filter:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<td align="right">
			<?php echo $lists['type'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20">#</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title">
			Plugin Name
			</th>
			<th nowrap="nowrap" width="5%">
	  		Installed
			</th>
			<th nowrap="nowrap" width="5%">
	  		Published
			</th>
			<th colspan="2" nowrap="nowrap" width="5%">
			Reorder
			</th>
			<th width="2%">
			Order
			</th>
			<th width="1%">
			<a href="javascript: cbsaveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a>
			</th>
			<th nowrap="nowrap" width="10%">
			Access
			</th>
			<th nowrap="nowrap" align="left" width="10%">
			Type
			</th>
			<th nowrap="nowrap" align="left" width="10%">
			Directory
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			
			$xmlfile = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' .$row->type . '/'.$row->folder . '/' . $row->element .'.xml';
			$filesInstalled = file_exists($xmlfile);

			$link = 'index2.php?option=com_comprofiler&amp;task=editPlugin&amp;cid='. $row->id;

			//Access
			if ( !$row->access ) {
				$color_access = 'style="color: green;"';
				$task_access = 'accessregistered';
			} else if ( $row->access == 1 ) {
				$color_access = 'style="color: red;"';
				$task_access = 'accessspecial';
			} else {
				$color_access = 'style="color: black;"';
				$task_access = 'accesspublic';
			}
	
			$access = '	<a href="javascript: void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task_access .'\')" '. $color_access .'>
			'. $row->groupname .'
			</a>';
			
			//Checked Out
			if ( $filesInstalled && $row->checked_out ) {
				$hover = '';
				$date 				= cbFormatDate( $row->checked_out_time );
				$checked_out_text 	= '<table>';
				$checked_out_text 	.= '<tr><td>'. addslashes($row->editor) .'</td></tr>';
				$checked_out_text 	.= '<tr><td>'. $date .'</td></tr>';
				$checked_out_text 	.= '</table>';
				$hover = 'onMouseOver="return overlib(\''. $checked_out_text .'\', CAPTION, \'Checked Out\', BELOW, RIGHT);" onMouseOut="return nd();"';
				$checked	 		= '<img src="images/checked_out.png" '. $hover .'/>';
			} else {
				$checked = '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$row->id.'" onclick="isChecked(this.checked);" />';
			}

			//Installedg
			$instImg 	= $filesInstalled ? 'tick.png' : 'publish_x.png';
			$instAlt 	= $row->published ? 'Installed' : 'Plugin Files missing';
			$installed  = '<img src="images/'. $instImg .'" border="0" alt="'. $instAlt .'" />';

			//Published
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$task 	= $row->published ? 'unpublishPlugin' : 'publishPlugin';
			$alt 	= $row->published ? 'Published' : 'Unpublished';
			$action	= $row->published ? 'Unpublish Item' : 'Publish item';
			if ($row->type == "language") {
				$published = '<img src="images/publish_g.png" border="0" alt="" title="language plugins cannot be unpublished, only uninstalled" />';
			} else {
				$published = '<a href="javascript: void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task .'\')" title="'. $action .'">
			<img src="images/'. $img .'" border="0" alt="'. $alt .'" />
			</a>';
			}
			
			//Backend plugin menu:
			$backendPluginMenus = array();
			if ( $row->backend_menu ) {
				$backend = explode( ",", $row->backend_menu );
				foreach ( $backend as $backendAction ) {
					$backendActionParts = explode( ":", $backendAction );
					$backendActionLink = 'index2.php?option=com_comprofiler&amp;task=pluginmenu&amp;cid=' . $row->id
										. '&amp;menu=' . $backendActionParts[1];
					$backendPluginMenus[] = '&nbsp; [<a href="' . $backendActionLink . '">' . $backendActionParts[0] . '</a>] ';
				}
			}

			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="right"><?php echo $i + 1 + $pageNav->limitstart ?></td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td>
				<?php
				if ( ($row->checked_out && ( $row->checked_out != $my->id )) || !$filesInstalled ) {
					echo $row->name;
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php echo $row->name; ?>
					</a>
					<?php
					echo implode( $backendPluginMenus );
				}
				?>
				</td>
				<td align="center">
				<?php echo $installed;?>
				</td>
				<td align="center">
				<?php echo $published;?>
				</td>
				<td>
				<?php    if (($i > 0 || ($i+$pageNav->limitstart > 0)) && $row->type == @$rows[$i-1]->type) { ?>
			         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupPlugin')">
			            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up" />
			         </a>
				<?php    } ?>
			      </td>
			      <td>
				<?php    if (($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) && $row->type == @$rows[$i+1]->type) { ?>
			         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownPlugin')">
			            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down" />
			         </a>
				<?php    } ?>
				</td>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
				<?php echo $access;?>
				</td>
				<td align="left" nowrap="true">
				<?php echo $row->type;?>
				</td>
				<td align="left" nowrap="true">
				<?php
			if (!$filesInstalled) echo "<span style=\"text-decoration:line-through\">";
			echo $row->element;
			if (!$filesInstalled) echo "</span>";
				?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		if (!method_exists($pageNav, "getListFooter")) {			// Mambo 4.5.0 support:
		?>
    <tr>
      <th align="center" colspan="12"> <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="12"> <?php echo $pageNav->writePagesCounter(); ?></td>
    </tr><?php
		}
		?>
		</table>

		<?php if (method_exists($pageNav, "getListFooter")) echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="showPlugins" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		
	</form>
		
	<div style="clear:both;">	
		<form enctype="multipart/form-data" action="index2.php" method="post" name="filename">
		<table class="adminheading">
		<tr>
			<th class="install">
			<a name="install">Install New Plugin</a>
			</th>
		</tr>
		</table>
		
		<table class="adminform">
		<tr>
			<th>
			Upload Package File
			</th>
		</tr>
		<tr>
			<td align="left">
			Package File:
			<input class="text_area" name="userfile" type="file" size="70"/>
			<input class="button" type="submit" value="Upload File &amp; Install" />
			</td>
		</tr>
		</table>
		
		<input type="hidden" name="task" value="installPluginUpload"/>
		<input type="hidden" name="option" value="com_comprofiler"/>
		<input type="hidden" name="client" value=""/>
		</form>
		<br />
		
		<form enctype="multipart/form-data" action="index2.php" method="post" name="adminForm_dir">
		<table class="adminform">
		<tr>
			<th>
			Install from directory
			</th>
		</tr>
		<tr>
			<td align="left">
			Install directory:&nbsp;
			<input type="text" name="userfile" class="text_area" size="65" value="<?php echo $p_startdir; ?>"/>&nbsp;
			<input type="button" class="button" value="Install" onclick="submitbutton3()" />
			</td>
		</tr>
		</table>
		
		<input type="hidden" name="task" value="installPluginDir" />
		<input type="hidden" name="option" value="com_comprofiler"/>
		<input type="hidden" name="client" value=""/>
		</form>
		<br />

		<form enctype="multipart/form-data" action="index2.php" method="post" name="adminForm_URL">
		<table class="adminform">
		<tr>
			<th>
			Install package from web (http/https)
			</th>
		</tr>
		<tr>
			<td align="left">
			Installation package URL:&nbsp;
			<input type="text" name="userfile" class="text_area" size="65" value="http://www.joomlapolis.com/plugins/"/>&nbsp;
			<input class="button" type="submit" value="Download Package &amp; Install" />
			</td>
		</tr>
		</table>
		
		<input type="hidden" name="task" value="installPluginURL" />
		<input type="hidden" name="option" value="com_comprofiler"/>
		<input type="hidden" name="client" value=""/>
		</form>
		<br />
		<table class="content">
		<?php
	if (!is_callable(array("JFile","write")) || ($mainframe->getCfg('ftp_enable') != 1)) {
			writableCell( 'components/com_comprofiler/plugin/user' );
			// writableCell( 'components/com_comprofiler/plugin/fieldtypes' );
			writableCell( 'components/com_comprofiler/plugin/templates' );
			writableCell( 'components/com_comprofiler/plugin/language' );
	}
		writableCell( 'media' );
				
		?>
	</div>
		</table>
		<?php
	}

	/**
	* Writes the edit form for new and existing module
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param moscomprofilerPlugin $row
	* @param array of string $lists  An array of select lists
	* @param cbParamsEditor $params
	* @param string $option of component.
	* 
	*/
	function editPlugin( &$row, &$lists, &$params, $options ) {
		global $mosConfig_live_site, $mainframe;

		outputCbTemplate( 2 );
		outputCbJs( 2 );
	    echo initToolTip( 2 );

	    $row->nameA = '';
		$filesInstalled = true;
		if ( $row->id ) {
			$row->nameA = '<small><small>[ '. $row->name .' ]</small></small>';
			
			$xmlfile = $mainframe->getCfg('absolute_path') . '/components/com_comprofiler/plugin/' .$row->type . '/'.$row->folder . '/' . $row->element .'.xml';
			$filesInstalled = file_exists($xmlfile);

		}
		if ( $row->id && ( ! $row->published ) ) {
			echo '<div class="cbWarning">Plugin is not published</div>' . "\n";
		}
		?>
		<table class="adminheading">
		<tr>
			<th class="mambots">
			Community Builder Plugin:
			<small>
			<?php echo $row->id ? 'Edit' : 'New';?>
			</small>
			<?php echo $row->nameA; ?>
			</th>
		</tr>
		</table>

		<form action="index2.php" method="post" name="adminForm">
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr valign="top">
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Plugin Common Settings
					</th>
				</tr>
				<tr>
					<td width="100" align="left">
					Name:
					</td>
					<td>
					<input class="text_area" type="text" name="name" size="35" value="<?php echo $row->name; ?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">
					Plugin Order:
					</td>
					<td>
					<?php echo $lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">
					Access Level:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
					Published:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">&nbsp;

					</td>
				</tr>
				<tr>
					<td valign="top">
					Description:
					</td>
					<td>
					<?php echo $row->description; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">
					Folder / File:
					</td>
					<td>
					<?php echo $lists['type'] . "/" . $row->element . ".php"; ?>
					</td>
				</tr>
				</table>
<?php				if ( $filesInstalled && $row->id ) {
						$settingsHtml = $params->draw( 'params', 'views', 'view', 'type', 'settings' );
						if ( $settingsHtml ) {	?>
				<table class="adminform">
				<tr>
					<th>
					<?php echo $row->name; ?> Specific Plugin Settings
					</th>
				</tr>
				<tr>
					<td width="100%" align="left"><?php echo $settingsHtml; ?></td>
				</tr>
				</table>
<?php					}
					}   ?>
			</td>
			<td width="40%">
				<table class="adminform" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th colspan="2">
					Parameters
					</th>
				</tr>
				<tr>
					<td>
					<?php
					if ( $filesInstalled && $row->id ) {
						echo $params->draw();
					} elseif ( !$filesInstalled ) {
						echo '<b><font style="color:red;">Plugin not installed</font></b><br />';
						echo $params->draw();
					} else {
						echo '<i>No Parameters</i>';
					}
					?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $options['option']; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="editPlugin" />
		</form>
		<?php
	}
	
	
	function showInstallMessage( $message, $title, $url ) {
		global $PHP_SELF;
		?>
		<table class="adminheading">
		<tr>
			<th class="install">
			<?php echo $title; ?>
			</th>
		</tr>
		</table>
		
		<table class="adminform">
		<tr>
			<td align="left">
			<strong><?php echo $message; ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
			[&nbsp;<a href="<?php echo $url;?>" style="font-size: 16px; font-weight: bold">Continue ...</a>&nbsp;]
			</td>
		</tr>
		</table>
		<?php
	}

} // class HTML_moscomprofiler 


function writableCell( $folder ) {
	global $mainframe;
	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="left">';
	echo is_writable( $mainframe->getCfg('absolute_path') . '/' . $folder ) ? '<b><font color="green">Writeable</font></b>' : '<b><font color="red">Unwriteable</font></b>' . '</td>';
	echo '</tr>';
}


	function update_checker(){
	  global $ueConfig;
  
/*	  ?>
	  
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
      <tr>
        <th width="100%" class="info">Update check</th>
      </tr>
      </table>
      <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr>
        <th class="title" colspan="2">Checking for updates...</th>
      </tr>
*/	  ?>
      <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
      <tr>
        <td width="15%"><?php echo _UE_VERSION; ?> : </td>
        <td><?php echo $ueConfig['version']; ?></td>
      </tr>
      <tr>
        <td><?php echo _UE_LATEST_VERSION; ?> : </td>
        <td><?php
      if (isset($ueConfig["noVersionCheck"]) && $ueConfig["noVersionCheck"] == "1") {
      	?><div id="cbLatestVersion"><a href="check_now" onclick="return cbCheckVersion();" style="cursor: pointer; text-decoration:underline;">check now</a></div><?php
      } else {
        ?><div id="cbLatestVersion" style="color:#CCC">...</div><?php
      }        
        ?></td>
      </tr>
    </table>

<script type="text/javascript"><!--//--><![CDATA[//><!--

    function cbCheckVersion() {
    	document.getElementById('cbLatestVersion').innerHTML = 'Checking latest version now...';
    	CBmakeHttpRequest('<?php 
    		echo "index3.php?option=com_comprofiler&task=latestVersion&no_html=1";
    		?>', 'cbLatestVersion', 'There was a problem with the request.', null);
    	return false;
    }
    function cbInitAjax() {
    	CBmakeHttpRequest('<?php 
    		echo "index3.php?option=com_comprofiler&task=latestVersion&no_html=1";
    		?>', 'cbLatestVersion', 'There was a problem with the request.', null);
    }

<?php
    if (!(isset($ueConfig["noVersionCheck"]) && $ueConfig["noVersionCheck"] == "1")) {
?>
	cbAddEvent(window, 'load', cbInitAjax);
<?php
    }
?>
//--><!]]></script>
<?php
	}
?>

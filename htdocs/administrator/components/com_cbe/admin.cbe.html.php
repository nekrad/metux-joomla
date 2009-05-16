<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(0);
class HTML_cbe {
function showLists( &$rows, $pageNav, $search, $option ) {
	global $mosConfig_offset;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

?>
<form action="index2.php" method="post" name="adminForm">
<input type=hidden name="limitstart" value="<?php echo $pageNav->limitstart; ?>">

  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/query.png" align="middle"><?php echo _UE_CBE_LIST_MANAGER; ?></td>
      <td nowrap="nowrap"><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
      <td> <?php echo $pageNav->getLimitBox(); ?> </td>
      <td><?php echo _UE_CBE_LM_SEARCH; ?>:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</th>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="10%" class="title"><?php echo _UE_CBE_TITLE; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_DESCRIPTION; ?></th>
      <th width="5%" class="title"><?php echo _UE_CBE_PUBLISHED; ?>?</th>
      <th width="5%" class="title"><?php echo _UE_CBE_DEFAULT; ?>?</th>
      <th width="5%" class="title"><?php echo _UE_CBE_LIST_ID; ?></th>
      <th width="5%" class="title" colspan="2"><?php echo _UE_CBE_RE_ORDER; ?></th>
      <th width="5%" class="title" colspan="2">
	<center><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="<?php echo _UE_CBE_BE_NEW_ORDER; ?>" /></a></center>
      </th>
    </tr>
<?php
$k = 0;
$imgpath='../components/com_cbe/images/';
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
      <td> <a href="#editList" onClick="return listItemTask('cb<?php echo $i;?>','editList')"><?php echo CBE_getLangDefinition($row->title); ?></a></td>
      <td><?php echo CBE_getLangDefinition($row->description); ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task3;?>')"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task4;?>')"><img src="<?php echo $imgpath.$img4;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td><?php echo $row->listid; ?></td>
      <td>
	<?php    if ($i > 0 || ($i+$pageNav->limitstart > 0)) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupList')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up">
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if ($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownList')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down">
         </a>
	<?php    } ?>
      </td>
      <td align="center" colspan="2">
	<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
      </td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="11"> <?php echo $pageNav->getPagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="11"> <?php echo $pageNav->getPagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showLists" />
  <input type="hidden" name="listType" value="showLists" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

function showLanguageFilter( &$rows, $pageNav, $option )
{
?>
	<form action="index2.php" method="post" name="adminForm">
	<input type=hidden name="limitstart" value="<?php echo $pageNav->limitstart; ?>">

	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/langmanager.png" align="middle"><?php echo _UE_CBE_LANGUAGE_FILTER_MANAGER; ?></span></td>
			<td nowrap><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
			<td> <?php echo $pageNav->getLimitBox(); ?> </td>
		</tr>
	</table>

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
			<th width="20">#</th>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th><?php echo _UE_CBE_LFM_LIST_OF_WORDS; ?></th>
			<th><?php echo _UE_CBE_LFM_PUBLISHED; ?></th>
		</tr>
<?php
$k = 0;
for($i=0; $i < count( $rows ); $i++) {
	$row = $rows[$i];
	$img = $row->published ? 'tick.png' : 'publish_x.png';
	$task = $row->published ? 'unpublishLanguageFilter' : 'publishLanguageFilter';
?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center"><?php echo $i+$pageNav->limitstart+1;?></td>
			<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
			<td><a href="#editLanguageFilter" onclick="return listItemTask('cb<?php echo $i;?>','editLanguageFilter')"><?php echo $row->badword; ?></a></td>
			<td width="10%" align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" border="0" alt="" /></a></td>
		</tr>
<?php
$k = 1 - $k;
}
?>
		<tr>
			<th align="center" colspan="10"> <?php echo $pageNav->getPagesLinks(); ?></th>
		</tr>
		<tr>
			<td align="center" colspan="10"> <?php echo $pageNav->getPagesCounter(); ?></td>
		</tr>
	</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
<?php 
}

function editLanguageFilter( &$row, $option )
{
	JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );
?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == "cancelLanguageFilter") {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.badword.value == '') {
			alert( "<?php echo _UE_CBE_LFM_POPERROR; ?>" );
		} else {
			submitform( pressbutton );
		}
	}
	</script>

	<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">

		<table border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td><b><?php echo _UE_CBE_LFM_WORD; ?></b>:&nbsp; </td>
				<td><input class="inputbox" type="text" size="50" maxlength="100" name="badword" value="<?php echo $row->badword; ?>" /></td>
			</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
	</form>
<?php 
}

function searchManage( &$rows, $pageNav, $search, $option )
{
	global $mosConfig_offset,$ueConfig,$enhanced_Config;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
 
	// added by Rasmus Dahl-Sorensen, January 2005

?>
<form action="index2.php" method="post" name="adminForm">
<input type=hidden name="limitstart" value="<?php echo $pageNav->limitstart; ?>">

  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/searchtext.png" align="middle"><?php echo _UE_CBE_SEARCH_MANAGER; ?></td>
      <td nowrap="nowrap"><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
      <td> <?php echo $pageNav->getLimitBox(); ?> </td>
      <td><?php echo _UE_CBE_SM_SEARCH; ?>:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</th>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" /></th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_DBNAME; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_FIELDNAME; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_FIELDTYPE; ?></th>
      <th width="5%" class="title"><?php echo _UE_CBE_SM_RANGE; ?>?</th>
      <th width="5%" class="title"><?php echo CBE_getLangDefinition($enhanced_Config['searchtab1']); ?></th>
      <th width="5%" class="title"><?php echo CBE_getLangDefinition($enhanced_Config['searchtab2']); ?></th>
      <th width="5%" class="title"><?php echo _UE_CBE_SM_MODULE; ?>?</th>
      <th width="5%" class="title" colspan="2"><?php echo _UE_CBE_FM_RE_ORDER; ?></th>
          </tr>
<?php
$k = 0;
$n=count ( $rows );

for ($i=0; $i < $n; $i++) {
	$row =& $rows[$i];
	$img = $row->range ? 'tick.png' : 'publish_x.png' ;
	$task = $row->range ? 'fieldRangeallowNo' : 'fieldRangeallowYes' ;

	$img2 = $row->simple ?  'tick.png' : 'publish_x.png';
	$task2 = $row->simple ?  'fieldSimpleNo' : 'fieldSimpleYes';

	$img3 = $row->advanced ?  'tick.png' : 'publish_x.png';
	$task3 = $row->advanced ?  'fieldAdvancedNo' : 'fieldAdvancedYes';

	$img4 = $row->module ?  'tick.png' : 'publish_x.png';
	$task4 = $row->module ?  'fieldModuleNo' : 'fieldModuleYes';

?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->fieldid; ?>" onClick="isChecked(this.checked);" /></td>
      <td><?php echo $row->name; ?></td>
      <td><?php echo CBE_getLangDefinition($row->title); ?></td>
      <td><?php echo $row->type; ?></td>

      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task2;?>')"><img src="images/<?php echo $img2;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task3;?>')"><img src="images/<?php echo $img3;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task4;?>')"><img src="images/<?php echo $img4;?>" width="12" height="12" border="0" alt="" /></a></td>

<!-- sv062 -->
      <td>
	<?php    if ($i > 0 || ($i+$pageNav->limitstart > 0)) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupSearchField')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up">
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if ($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownSearchField')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down">
         </a>
	<?php    } ?>
      </td>
<!-- sv062 -->      
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="12"> <?php echo $pageNav->getPagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="12"> <?php echo $pageNav->getPagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="searchManage" />
  <input type="hidden" name="boxchecked" value="0" />

</form>
<?php 
}

function editList( &$row, $lists, $fields, $option, $tabid ) {
	global $my, $acl, $task, $database;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$sqlWhere="";
	$fieldids=null;
	if($tabid >0) {
		$col1fields=explode('|*|',$row->col1fields);
		$col1options="";
		$fieldids="";
		for ($i=0, $n=count( $col1fields ); $i < $n; $i++) {
			$col1field =& $col1fields[$i];
			if(trim($col1field)!='' && trim($col1field)!=null) {
				$col1options .= "<option value=\"".$col1field."\">".CBE_getLangDefinition(array_search($col1field,$fields))."\n";
				if($i>0) $fieldids .= ",";
				$fieldids .= "'".$col1field."'";
			}
		}
		$col2fields=explode('|*|',$row->col2fields);
		$col2options="";
		for ($i=0, $n=count( $col2fields ); $i < $n; $i++) {
			$col2field =& $col2fields[$i];
			if(trim($col2field)!='' && trim($col2field)!=null) {
				$col2options .= "<option value=\"".$col2field."\">".CBE_getLangDefinition(array_search($col2field,$fields))."\n";
				$fieldids .= ",";
				$fieldids .= "'".$col2field."'";
			}
		}
		$col3fields=explode('|*|',$row->col3fields);
		$col3options="";
		for ($i=0, $n=count( $col3fields ); $i < $n; $i++) {
			$col3field =& $col3fields[$i];
			if(trim($col3field)!='' && trim($col3field)!=null) {
				$col3options .= "<option value=\"".$col3field."\">".CBE_getLangDefinition(array_search($col3field,$fields))."\n";
				$fieldids .= ",";
				$fieldids .= "'".$col3field."'";
			}
		}
		$col4fields=explode('|*|',$row->col4fields);
		$col4options="";
		for ($i=0, $n=count( $col4fields ); $i < $n; $i++) {
			$col4field =& $col4fields[$i];
			if(trim($col4field)!='' && trim($col4field)!=null) {
				$col4options .= "<option value=\"".$col4field."\">".CBE_getLangDefinition(array_search($col4field,$fields))."\n";
				$fieldids .= ",";
				$fieldids .= "'".$col4field."'";
			}
		}
		if($fieldids!=null) $sqlWhere="\nAND fieldid NOT IN ($fieldids)";
	}
	$database->setQuery( "SELECT f.fieldid, f.title, f.name"
	. "\nFROM #__cbe_fields f"
	. "\nWHERE f.published = 1 AND f.profile = 1"
	. $sqlWhere
	);

	$fields = $database->loadObjectList();

	$stripME = array(" ASC", " DESC","`");
	$WhereIn = str_replace($stripME, "", $row->sortfields);
	$WhereIn = "'".str_replace(", ","','",$WhereIn)."'";
	$database->setQuery( "SELECT f.title, f.name"
	. "\nFROM #__cbe_fields f"
	. "\nWHERE f.published = 1 AND f.name!='NA'"
	. " AND (type != 'geo_calc_dist' AND type !='cbe_calced_age') "
	. "\nAND f.name NOT IN(".$WhereIn.")"
	);

	$sortfields = $database->loadObjectList();

	$database->setQuery( "SELECT f.title, f.name"
	. "\nFROM #__cbe_fields f"
	. "\nWHERE f.published = 1 AND f.name!='NA'"
	. " AND (type!='geo_calc_dist' AND type!='cbe_calced_age') "
	);
	$filterfields = $database->loadObjectList();



	$sortlists=explode(", ",str_replace("`","",$row->sortfields));
	$sortparts=array();
	$i=0;
	foreach($sortlists as $sortlist) {
		$sortlistpart=array();
		$sortlistpart=explode(" ",$sortlist);
		if(!ISSET($sortlistpart[1])) $sortlistpart[1]="";
		$sortparts[$i]['field']=$sortlistpart[0];
		$sortparts[$i]['dir']=$sortlistpart[1];
		$database->setQuery("SELECT title FROM #__cbe_fields WHERE name='".$sortlistpart[0]."' LIMIT 1");
		$sortparts[$i]['title']=$database->loadResult();
		$i++;
	}


?>
	<script language="JavaScript" src="<?php echo JURI::root() . "/administrator/components/com_cbe/js/admin.cbe.js"; ?>"></script>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/query.png" align="middle"><?php echo $row->listid ? _UE_CBE_LM_EDIT : _UE_CBE_LM_ADD; ?></td>
		</tr>
	</table>

	<form action="index2.php?option=com_cbe&task=saveList" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_TITLE; ?>:</td>
			<td align=left  width="20%"><input type="text" name="title" mosReq=1 mosLabel="Title" class="inputbox" value="<?php echo $row->title; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_DESCRIPTION; ?>:</td>
			<td width="20%" align=left><input type="text" name="description" mosReq=1 mosLabel="Description" class="inputbox" value="<?php echo $row->description; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_GID_INCL; ?>:</td>
			<td width="20%"><?php echo $lists['usergroups']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_GID_ACL; ?>:</td>
			<td width="20%"><?php echo $lists['aclgroup']; ?></td>
			<td><?php echo _UE_CBE_GID_ACL_DESC; ?></td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_PUBLISHED; ?>:</td>
			<td width="20%"><?php echo $lists['published']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_DEFAULT; ?>:</td>
			<td width="20%"><?php echo $lists['default']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_SORT_BY; ?>:</td>
			<td width="20%">
				<select name="sortfieldlist">
					<?php
					for ($i=0, $n=count( $sortfields ); $i < $n; $i++) {
						$sortfield =& $sortfields[$i];
						echo "<option value=\"`".$sortfield->name."`\">".CBE_getLangDefinition($sortfield->title)."\n";
					}

					?>
				</select><select name=direction><option value="ASC"><?php echo _UE_CBE_LM_ASC; ?></option><option value="DESC"><?php echo _UE_CBE_LM_DESC; ?></option></select><input type=button onclick="moveOption2(this.form.sortfieldlist, sort, this.form.direction.value);" value=" <?php echo _UE_CBE_ADD; ?> "><br />
				<select id=sort name=sort size="5" multiple  mosReq=1 mosLabel="Sort By">
					<?php
					for ($i=0, $n=count( $sortparts ); $i < $n; $i++) {
						$sortpart = $sortparts[$i];
						if($sortpart['field']!='') {
							echo "<option value=\"`".$sortpart['field']."` ".$sortpart['dir']."\">".CBE_getLangDefinition($sortpart['title'])." [".$sortpart['dir']."]\n";
						}
					}

					?>
				</select><br />
				<input type=button onclick="moveOptions(sort, -1);" value=" + " />
				<input type=button onclick="moveOptions(sort, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(this.form.sort,this.form.sortfieldlist);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
			</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_LM_FILTER; ?>:</td>
			<td width="60%">
<?php

$simChecked="";
$advChecked="";
$simStyle="display:none;";
$advStyle="display:none;";
//echo $row->filterfields;
$filttype=substr($row->filterfields,0,1);
$row->filterfields=substr($row->filterfields,1);
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
	$database->setQuery("SELECT title FROM #__cbe_fields WHERE name='".$filterparts[$i]['field']."' LIMIT 1");
	$filtertitle=$database->loadResult();
	$filterparts[$i]['value']=$filterlist;
	$filterparts[$i]['title']=str_replace(array("'","`"),"",str_replace($filterparts[$i]['field'],CBE_getLangDefinition($filtertitle),$filterlist));

	$i++;
}
?>
				<label for=ft1 ><input type=radio <?php echo $simChecked; ?> id=ft1 onclick="javascript:shDiv('simFilter',1);shDiv('advFilter',0);" name=filtertype value=0 checked /><?php echo _UE_CBE_LM_FSIMPLE; ?> </label><label for=ft2 ><input type="radio" <?php echo $advChecked; ?> onclick="javascript:shDiv('simFilter',0);shDiv('advFilter',1);" id="ft2" name="filtertype" value="1" /><?php echo _UE_CBE_LM_FADVANCED; ?> </label>
				<br />
				<div id="simFilter" name="simFilter" style="<?php echo $simStyle; ?>" >
				<select name="filterfieldlist">
					<?php
					foreach ($filterfields AS $filterfield) {
						echo "<option value=\"`".$filterfield->name."`\">".CBE_getLangDefinition($filterfield->title)."\n";
					}

					?>
				</select>
				<select name=comparison onchange="javascript:filterCondition(this.options[this.selectedIndex].getAttribute('needCond'));">
					<option value=">" needCond=1><?php echo _UE_CBE_LM_SQL_1; ?></option>
					<option value=">=" needCond=1><?php echo _UE_CBE_LM_SQL_2; ?></option>
					<option value="<" needCond=1><?php echo _UE_CBE_LM_SQL_3; ?></option>
					<option value="<=" needCond=1><?php echo _UE_CBE_LM_SQL_4; ?></option>
					<option value="=" needCond=1><?php echo _UE_CBE_LM_SQL_5; ?></option>
					<option value="!=" needCond=1><?php echo _UE_CBE_LM_SQL_6; ?></option>
					<option value="IS NULL" needCond=0><?php echo _UE_CBE_LM_SQL_7; ?></option>
					<option value="IS NOT NULL"  needCond=0><?php echo _UE_CBE_LM_SQL_8; ?></option>
					<option value="LIKE"  needCond=1><?php echo _UE_CBE_LM_SQL_9; ?></option>
				</select>
				<input type=text name=condition value="" Req=1 />
				<input type=button onclick="moveOption3(this.form.filterfieldlist, filter, this.form.comparison.value, this.form.condition.value);" value=" <?php echo _UE_CBE_ADD; ?> ">
				<br />
				<select id=filter name=filter size="5" multiple  mosReq=0 mosLabel="Filter By">
					<?php
					foreach ($filterparts AS $filterpart) {
						if($filterpart['value']!='') {
							echo "<option value=\"".str_replace(array("(",")"),"",$filterpart['value'])."\">".stripslashes(utf8RawUrlDecode($filterpart['title']))."\n";
						}
					}

					?>
				</select><br />
				<input type=button onclick="moveOptions(filter, -1);" value=" + " />
				<input type=button onclick="moveOptions(filter, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption4(this.form.filter,this.form.filterfieldlist);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
				</div>
				<div id="advFilter" name="advFilter" style="<?php echo $advStyle; ?>">
					<textarea name="advFilterText" cols="50" rows="7"><?php echo utf8RawUrlDecode(substr($row->filterfields,1,-1)); ?></textarea>
				</div>
			</td>
		</tr>
<?php //Onlinestatus hack start 
	if($row->filteronline=='1') {
		$filteronline_selected = 'CHECKED';
	} else {
		$filteronline_selected = '';
	}
?>
		<tr>
			<td>
				<b><?php echo _UE_CBE_LM_FILTER_ONLINE; ?>:</b>
			</td>
			<td>
				<input type="checkbox" name="filteronline" value="1" <?php echo $filteronline_selected; ?>>
			</td>
		</tr>
<?php //Onlinestatus hack end ?>
	</table>
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="33%">
				<?php echo _UE_CBE_LM_COLUMN_ENABLE; ?> 1: <input type=checkbox onclick="javascript:enableListColumn(1);" name=col1enabled <?php if($row->col1enabled == 1) echo " CHECKED ";  ?> value=1 ><br />
				<?php echo _UE_CBE_LM_COLUMN_TITLE; ?> 1:<br />
				<input type="text" name="col1title" mosReq=0 mosLabel="Column 1 Title" class="inputbox" value="<?php echo $row->col1title; ?>" /><br />
				<?php echo _UE_CBE_LM_COLUMN_CAPTIONS; ?> 1:<input type=checkbox name=col1captions <?php if($row->col1captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col1 size="5" multiple name=col1[] >
					<?php
					echo $col1options;
					?>
				</select><br />
				<input name=col1up type=button onclick="moveOptions(col1, -1);" value=" + " />
				<input name=col1down type=button onclick="moveOptions(col1, 1);" value=" - " />
				<br />
				<input name=col1remove type=button onclick="moveOption(col1,this.form.fieldlist);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
			</td>
			<td width="33%" rowspan=3 valign=center align=center><?php echo _UE_CBE_LM_FIELD_LIST; ?>:<br />
				<input name=addcol1 type=button onclick="moveOption(this.form.fieldlist, col1);" value=" <- <?php echo _UE_CBE_ADD; ?> ">
				<input type=button onclick="moveOption(this.form.fieldlist, col2);" value=" <?php echo _UE_CBE_ADD; ?> -> "><br />
				<select name="fieldlist" size="10" multiple>
					<?php
					for ($i=0, $n=count( $fields ); $i < $n; $i++) {
						$field =& $fields[$i];
						echo "<option value=\"".$field->fieldid."\">".CBE_getLangDefinition($field->title)."\n";
					}

					?>
				</select><br />
				<input type=button onclick="moveOption(this.form.fieldlist, col3);" value=" <- <?php echo _UE_CBE_ADD; ?> ">
				<input type=button onclick="moveOption(this.form.fieldlist, col4);" value=" <?php echo _UE_CBE_ADD; ?> -> ">
			</td>
			<td width="33%">
				<?php echo _UE_CBE_LM_COLUMN_ENABLE; ?> 2: <input type=checkbox name=col2enabled <?php if($row->col2enabled == 1) echo " CHECKED ";  ?> value=1 ><br />
				<?php echo _UE_CBE_LM_COLUMN_TITLE; ?> 2:<br />
				<input type="text" name="col2title" mosReq=0 mosLabel="Column 2 Title" class="inputbox" value="<?php echo $row->col2title; ?>" /><br />
				<?php echo _UE_CBE_LM_COLUMN_CAPTIONS; ?> 2:<input type=checkbox name=col2captions <?php if($row->col2captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col2 size="5" multiple name=col2[] >
					<?php
					echo $col2options;
					?>
				</select><br />
				<input type=button onclick="moveOptions(col2, -1);" value=" + " />
				<input type=button onclick="moveOptions(col2, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(col2,this.form.fieldlist);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td width="33%">
				<?php echo _UE_CBE_LM_COLUMN_ENABLE; ?> 3: <input type=checkbox name=col3enabled <?php if($row->col3enabled == 1) echo " CHECKED ";  ?> value=1 /><br />
				<?php echo _UE_CBE_LM_COLUMN_TITLE; ?> 3:<br />
				<input type="text" name="col3title" mosReq=0 mosLabel="Column 3 Title" class="inputbox" value="<?php echo $row->col3title; ?>" /><br />
				<?php echo _UE_CBE_LM_COLUMN_CAPTIONS; ?> 3:<input type=checkbox name=col3captions <?php if($row->col3captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col3 size="5" multiple name=col3[]>
					<?php
					echo $col3options;
					?>
				</select><br />
				<input type=button onclick="moveOptions(col3, -1);" value=" + " />
				<input type=button onclick="moveOptions(col3, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(col3,this.form.fieldlist);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
			</td>
			<td width="33%">
				<?php echo _UE_CBE_LM_COLUMN_ENABLE; ?> 4: <input type=checkbox name=col4enabled <?php if($row->col4enabled == 1) echo " CHECKED ";  ?> value=1 ><br />
				<?php echo _UE_CBE_LM_COLUMN_TITLE; ?> 4:<br />
				<input type="text" name="col4title" mosReq=0 mosLabel="Column 4 Title" class="inputbox" value="<?php echo $row->col4title; ?>" /><br />
				<?php echo _UE_CBE_LM_COLUMN_CAPTIONS; ?> 4:<input type=checkbox name=col4captions <?php if($row->col4captions == 1) echo " CHECKED ";  ?> value=1 ><br />
				<select id=col4 size="5" multiple name=col4[]>
					<?php
					echo $col4options;
					?>
				</select><br />
				<input type=button onclick="moveOptions(col4, -1);" value=" + " />
				<input type=button onclick="moveOptions(col4, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption(col4,this.form.fieldlist);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
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
  <input type="hidden" name="option" value="com_cbe" />
  <input type="hidden" name="task" value="" />
</form>
  
<?php 	
}

function showFields( &$rows, $pageNav, $search, $option, &$lists ) {
	global $mosConfig_offset;

?>
<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/addedit.png" align="middle"><?php echo _UE_CBE_FIELD_MANAGER; ?></td>
      <td nowrap="nowrap"><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
      <td> <?php echo $pageNav->getLimitBox(); ?> </td>
      <td><?php echo _UE_CBE_FM_SEARCH; ?>:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td width="right"><?php echo $lists['tabid'];?></td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</td>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_DBNAME; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_FIELDNAME; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_FIELDTYPE; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_FM_FIELDTAB; ?></th>
      <th width="5%" class="title"><?php echo _UE_CBE_FM_REQUIRED; ?>?</th>
      <th width="5%" class="title"><?php echo _UE_CBE_FM_PROFILE; ?>?</th>
      <th width="5%" class="title"><?php echo _UE_CBE_FM_REGISTRATION; ?>?</th>
      <th width="5%" class="title"><?php echo _UE_CBE_FM_PUBLISHED; ?>?</th>
      <th width="5%" class="title" colspan="2"><?php echo _UE_CBE_FM_RE_ORDER; ?></th>
      <th width="5%" class="title" colspan="2">
	<center><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="<?php echo _UE_CBE_BE_NEW_ORDER; ?>" /></a></center>
      </th>
    </tr>
<?php
$k = 0;
$imgpath='../components/com_cbe/images/';
for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row =& $rows[$i];
	$img = $row->required ? 'tick.png' : 'publish_x.png' ;
	$task = $row->required ? 'fieldRequiredNo' : 'fieldRequiredYes' ;
	$img2 = $row->profile ?  'tick.png' : 'publish_x.png';
	$task2 = $row->profile ?  'fieldProfileNo' : 'fieldProfileYes';
	$img3 = $row->published ?  'tick.png' : 'publish_x.png';
	$task3 = $row->published ?  'fieldPublishedNo' : 'fieldPublishedYes';
	$img4 = $row->registration ?  'tick.png' : 'publish_x.png';
	$task4 = $row->registration ?  'fieldRegistrationNo' : 'fieldRegistrationYes';

	if ($i > 0 && $row->tabid != $rows[$i-1]->tabid) {
		echo "<th class=\"title\" colspan=\"14\"><center>".CBE_getLangDefinition($row->tab)."</centcer></th>";
	}
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->fieldid; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="#editField" onClick="return listItemTask('cb<?php echo $i;?>','editField')">
        <?php echo $row->name; ?> </a> </td>
      <td><?php echo CBE_getLangDefinition($row->title); ?></td>
      <td><?php echo $row->type; ?></td>
      <td><?php echo CBE_getLangDefinition($row->tab); ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task;?>')"><img src="<?php echo $imgpath.$img;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task2;?>')"><img src="<?php echo $imgpath.$img2;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task4;?>')"><img src="<?php echo $imgpath.$img4;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task3;?>')"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td>
	<?php    if (($i > 0 || ($i+$pageNav->limitstart > 0)) && $row->tab == @$rows[$i-1]->tab) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupField')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up">
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if (($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) && $row->tab == @$rows[$i+1]->tab) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownField')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down">
         </a>
	<?php    } ?>
      </td>
      <td align="center" colspan="2">
	<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
      </td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="14"> <?php echo $pageNav->getPagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="14"> <?php echo $pageNav->getPagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showField" />
  <input type="hidden" name="listType" value="showFields" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

function editfield( &$row, $lists, $fieldvalues, $option, $tabid ) {
	global $task, $mosConfig_live_site;

	$my = &JFactory::getUser();
	$acl = &JFactory::getACL();

	if ($row->fieldid > 0 && $row->type == "birthdate") {
		if (!empty($row->value)) {
			list($bd_lowrange, $bd_highrange) = explode(",", $row->value);
			$bd_lowrange = (int)$bd_lowrange;
			$bd_highrange = (int)$bd_highrange;
		}
	}

?>
<script language="javascript" type="text/javascript">
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
			if (elements.item(i).getAttribute('mosReq') == 1) {
				if (elements.item(i).value == '') {
					//alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
					// add up all error messages
					errorMSG += elements.item(i).getAttribute('mosLabel') + ' <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					elements.item(i).style.background = "red";
					iserror=1;
				}
			}
		}
	}
	if(iserror==1) {
		alert(errorMSG);
	} else {
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
	elem=getObject('divTextarea');
	elem.style.visibility = 'hidden';
	elem.style.display = 'none';
	elem=getObject('divText');
	elem.style.visibility = 'hidden';
	elem.style.display = 'none';
	elem=getObject('divBirthDate');
	elem.style.visibility = 'hidden';
	elem.style.display = 'none';
	elem=getObject('divStartDate');
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
		elem=getObject('divTextarea');
		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		break;

		case 'emailaddress':
		case 'webaddress':
		case 'password':
		case 'text':
		case 'numericfloat':
		case 'numericint':
		disableAll();
		elem=getObject('divText');
		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		break;

		case 'radio':
		case 'select':
		case 'multiselect':
		case 'multicheckbox':
		disableAll();
		elem=getObject('divValues');
		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		if (elem=getObject('vNames[0]')) {
			elem.setAttribute('mosReq',1);
		}
		break;

		case 'spacer':
		disableAll();
		break;

		case 'dateselect':
		disableAll();
		elem=getObject('divStartDate');
		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		break;

		case 'birthdate':
		case 'dateselectrange':
		disableAll();
		elem=getObject('divBirthDate');
		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		elem.setAttribute('mosReq',1);
		elem=getObject('divStartDate');
		elem.style.visibility = 'visible';
		elem.style.display = 'block';
		break;

		default:
		disableAll();
	}
}

function prep4SQL(o){
	if(o.value!='') {
		o.value=o.value.replace('cbe_','');
		o.value='cbe_' + o.value.replace(/[^a-zA-Z_]+/g,'');
	}
}

</script>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/addedit.png" align="middle"><?php echo $row->fieldid ? _UE_CBE_FM_EDIT : _UE_CBE_FM_ADD;?></td>
		</tr>
	</table>

	<form action="index2.php?option=com_cbe&task=saveField" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_FIELDTYPE; ?>:</td>
			<td width="20%"><?php echo $lists['type']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_FIELDTAB; ?>:</td>
			<td width="20%"><?php echo $lists['tabs']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_DBNAME; ?>:</td>
			<td align=left  width="20%"><input onchange="prep4SQL(this);" type="text" name="name" mosReq=1 mosLabel="Name" class="inputbox" value="<?php echo $row->name; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_FIELDNAME; ?>:</td>
			<td width="20%" align=left><input type="text" name="title" mosReq=1 mosLabel="Title" class="inputbox" value="<?php echo $row->title; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_REQUIRED; ?>?:</td>
			<td width="20%"><?php echo $lists['required']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_SHOW_ON_PROFILE; ?>?:</td>
			<td width="20%"><?php echo $lists['profile']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_READ_ONLY; ?>?:</td>
			<td width="20%"><?php echo $lists['readonly']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_REQUIRED_FOR_REGISTRATION; ?>?:</td>
			<td width="20%"><?php echo $lists['registration']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_PUBLISHED; ?>:</td>
			<td width="20%"><?php echo $lists['published']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_USE_IN_CBSEARCH; ?>:</td>
			<td width="20%"><?php echo $lists['searchmanager']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_FIELD_TOOLTIP; ?>:</td>
			<td width="20%"><?php echo $lists['information_tag']; ?></td>
			<td><img src='<?php echo JURI::root(); ?>components/com_cbe/images/attention.gif' width='16' height='16' alt='!' >
			<input type="text" name="information" mosLabel="Information" size="35" maxlength="250" class="inputbox" value="<?php echo $row->information; ?>" /></td>
		</tr>

		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_SIZE; ?>:</td>
			<td width="20%"><input type="text" name="size" mosLabel="Size" class="inputbox" value="<?php echo $row->size; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		<div id=page1  class="pagetext">
		
		</div>
		<div id=divText  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_MAX_LENGTH; ?>:</td>
			<td width="20%"><input type="text" name="<?php if($row->type=='textarea') { echo 'maxlength2'; } ELSE { echo 'maxlength'; } ?>" mosLabel="Max Length" class="inputbox" value="<?php echo $row->maxlength; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divTextarea  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_MAX_LENGTH; ?>:</td>
			<td width="20%"><input type="text" name="<?php if($row->fieldid > 0 && $row->type=='textarea') { echo 'maxlength'; } ELSE { echo 'maxlength2'; } ?>" mosLabel="Max Length" class="inputbox" value="<?php echo $row->maxlength; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_COLS; ?>:</td>
			<td width="20%"><input type="text" name="cols" mosLabel="Cols" class="inputbox" value="<?php echo $row->cols; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_ROWS; ?>:</td>
			<td width="20%"><input type="text" name="rows"  mosLabel="Rows" class="inputbox" value="<?php echo $row->rows; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>

		<div id=divBirthDate  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_BD_LOWRANGE; ?>:</td>
			<td width="20%"><input type="text" name="lowRange" mosLabel="Low Range" mosReq=0 class="inputbox" value="<?php echo $bd_lowrange; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_BD_HIGHRANGE; ?>:</td>
			<td width="20%"><input type="text" name="highRange" mosLabel="High Range" mosReq=0 class="inputbox" value="<?php echo $bd_highrange; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divStartDate  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_FM_BD_STARTDATE; ?>:</td>
			<td width="20%"><input type="text" name="default" mosLabel="StartDate" class="inputbox" value="<?php echo $row->default; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>

		<div id=divValues style="text-align:left;">
		<?php echo _UE_CBE_FM_VALUES_INFO; ?><br />
		<input type=button onclick="insertRow();" value="<?php echo _UE_CBE_FM_ADD_VALUE; ?>" />
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
  <input type="hidden" name="search_id" value="<?php echo $row->search_id; ?>" />
  <input type="hidden" name="searchmanager_p" value="<?php echo $row->searchmanager_p; ?>" />
  <input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="" />
</form>
  
<?php 
if($row->fieldid > 0) {
	print "<script> document.adminForm.name.readOnly=true; </script>";
	print "<script> document.adminForm.type.disabled=true; </script>";
}
print "<script> disableAll(); </script>";
print "<script> selType('".$row->type."'); </script>";
}


function showTabs( &$rows, $pageNav, $search, $option ) {
	global $mosConfig_offset;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

?>
<script type="text/javascript">
function saveorderTabs( n ) {
	docheckAll_entries( n )
	submitform('saveorderTabs');
}
function docheckAll_entries( n ) {
	for ( var j = 0; j <= n; j++ ) {
		box = eval( "document.adminForm.cb" + j );
		if ( box.checked == false ) {
			box.checked = true;
		}
	}
}
</script>
<form action="index2.php" method="post" name="adminForm">
<input type=hidden name="limitstart" />
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/categories.png" align="middle"><?php echo _UE_CBE_TAB_MANAGER; ?></td>
      <td nowrap="nowrap"><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
      <td> <?php echo $pageNav->getLimitBox(); ?> </td>
      <td><?php echo _UE_CBE_TM_SEARCH; ?>:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</td>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="15%" class="title"><?php echo _UE_CBE_TM_TITLE; ?></th>
      <th width="25%" class="title"><?php echo _UE_CBE_TM_DESCRIPTION; ?></th>
      <th width="5%" class="title"><?php echo _UE_CBE_TM_PUBLISHED; ?></th>
      <th width="5%" class="title" colspan="2"><?php echo _UE_CBE_TM_RE_ORDER; ?></th>
      <th width="5%" class="title" colspan="2">
	<center><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="<?php echo _UE_CBE_BE_NEW_ORDER; ?>" /></a></center>
      </th>
    </tr>
<?php
$k = 0;
$imgpath='../components/com_cbe/images/';
for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row =& $rows[$i];

	$img3 = $row->enabled ?  'tick.png' : 'publish_x.png';
	$task3 = $row->enabled ?  'tabPublishedNo' : 'tabPublishedYes';
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->tabid; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="#editTab" onClick="return listItemTask('cb<?php echo $i;?>','editTab')">
        <?php echo CBE_getLangDefinition($row->title); ?> </a> </td>
	<td><?php echo CBE_getLangDefinition($row->description); ?> </td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task3;?>')"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
      <td>
	<?php    if ($i > 0 || ($i+$pageNav->limitstart > 0)) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupTab')">
            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up">
         </a>
	<?php    } ?>
      </td>
      <td>
	<?php    if ($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) { ?>
         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownTab')">
            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down">
         </a>
	<?php    } ?>
      </td>
      <td align="center" colspan="2">
	<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
      </td>
    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="9"> <?php echo $pageNav->getPagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="9"> <?php echo $pageNav->getPagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showTab" />
  <input type="hidden" name="listType" value="showTabs" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

function edittab( &$row, $option, &$lists, $tabid ) {
	global $my, $task;
	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();

//
	$database->setQuery( "SELECT f.title, f.name"
	. "\nFROM #__cbe_fields f"
	. "\nWHERE f.published = 1 AND f.name!='NA'"
	);
	$filterfields = $database->loadObjectList();
// JS scripte

	$title_readonly = '';
	if ($row->title == '_UE_CONTACT_INFO_HEADER') {
		$title_readonly = 'readonly';
	}
?>
	<script language="javascript" type="text/javascript">
	<!--
	function submitbutton1(pressbutton) {
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
			document.adminForm.aclgroups.value=UGIDs;
		}
	}
	function clearUGIDs() {
		var UGIDs='';
		document.adminForm.aclgroups.value=UGIDs;
		document.adminForm.aclgroupsL.selectedIndex = -1;
	}
	
	function checkNest(nest_f) {
		var nested = document.adminForm.nested;
		var is_nest = document.adminForm.is_nest;
		if (nest_f.id == 'is_nest' && is_nest.value == 1) {
			nested.value = 0;
		}
		if (nest_f.id == 'nested' && nested.value == 1) {
			is_nest.value = 0;
		}
	}

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
		if (pressbutton == 'showTab') {
			submitform( pressbutton );
			return;
		}
		var coll = document.adminForm;
		var errorMSG = '';
		var iserror=0;
		getFilterList_me(document.adminForm.filter_me);
		getFilterList_you(document.adminForm.filter_you);
		if (coll != null) {
			var elements = coll.elements;
			// loop through all input elements in form
			for (var i=0; i < elements.length; i++) {
				// check if element is mandatory; here mosReq=1
				if (elements.item(i).getAttribute('mosReq') == 1) {
					if (elements.item(i).value == '') {
						//alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
						// add up all error messages
						errorMSG += elements.item(i).getAttribute('mosLabel') + ' <?php echo _UE_REQUIRED_ERROR; ?>\n';
						// notify user by changing background color, in this case to red
						elements.item(i).style.background = "red";
						iserror=1;
					}
				}
			}
		}
		if(iserror==1) { alert(errorMSG); }
		else {
			submitform( pressbutton );
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

	function moveOption3_me(fromObj, toObj, comparison, condition)
	{
		if(fromObj.options[fromObj.selectedIndex].selected)
		{
			if((condition=='' || condition==null) && document.adminForm.condition_me.getAttribute('Req')==1) {
				alert("You must define a condition text!");
				return;
			}
			fromObjIndex=fromObj.selectedIndex;
			fromObj.options[fromObjIndex].selected = false;
			optionText = fromObj.options[fromObjIndex].text+ ' '+comparison+' '+condition;
			condition=condition.replace("'", "\\'");
			if(condition!='' && condition!=null) condition="'"+escape(condition)+"'";
			optionValue = fromObj.options[fromObjIndex].value+' '+comparison+' '+condition;
			toObjIndex = toObj.options.length;
			toObj.options.length = toObj.options.length + 1;
			toObj.options[toObjIndex].text = optionText;
			toObj.options[toObjIndex].value = optionValue;
			toObj.options[toObjIndex].selected=false;
			if(NS4)
			history.go(0);
		}
	}
	function moveOption3_you(fromObj, toObj, comparison, condition)
	{
		if(fromObj.options[fromObj.selectedIndex].selected)
		{
			if((condition=='' || condition==null) && document.adminForm.condition_you.getAttribute('Req')==1) {
				alert("You must define a condition text!");
				return;
			}
			fromObjIndex=fromObj.selectedIndex;
			fromObj.options[fromObjIndex].selected = false;
			optionText = fromObj.options[fromObjIndex].text+ ' '+comparison+' '+condition;
			condition=condition.replace("'", "\\'");
			if(condition!='' && condition!=null) condition="'"+escape(condition)+"'";
			optionValue = fromObj.options[fromObjIndex].value+' '+comparison+' '+condition;
			toObjIndex = toObj.options.length;
			toObj.options.length = toObj.options.length + 1;
			toObj.options[toObjIndex].text = optionText;
			toObj.options[toObjIndex].value = optionValue;
			toObj.options[toObjIndex].selected=false;
			if(NS4)
			history.go(0);
		}
	}
	
	function moveOption4_me(fromObj, toObj)
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
		if (fromObj.options.length == 0) {
			document.adminForm.q_me.value=""
		}
	}
	function moveOption4_you(fromObj, toObj)
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
		if (fromObj.options.length == 0) {
			document.adminForm.q_you.value=""
		}
	}


	function getFilterList_me(selectObj) {
		var filterfields_me='';
		var j=0;
		var idvType_me=getObject('ft3_me');
		var advType_me=getObject('ft2_me');
		var simType_me=getObject('ft1_me');
		//alert(simType.checked);
		if(simType_me.checked) {
			selectAll(selectObj);
			if(selectObj.selectedIndex != -1)
			{
				for(i = 0; i < selectObj.options.length; i++)
				{
					if(j>0) filterfields_me +=  ' AND ';
					filterfields_me +=  selectObj.options[i].value;
					j++
				}
				//alert(filterfields);
				if(filterfields_me!="") {
					document.adminForm.q_me.value="s("+filterfields_me+")";
				} else {
					document.adminForm.q_me.value="";
				}
			}
		} else if (advType_me.checked) {
			if(document.adminForm.advFilterText_me.value!="") {
				document.adminForm.q_me.value="a("+escape(document.adminForm.advFilterText_me.value)+")";
			} else {
				document.adminForm.q_me.value="";
			}
		} else {
			if(document.adminForm.idvFilterText_me.value!="") {
				document.adminForm.q_me.value="i("+escape(document.adminForm.idvFilterText_me.value)+")";
			} else {
				document.adminForm.q_me.value="";
			}
		}
	}
	function getFilterList_you(selectObj) {
		var filterfields_you='';
		var j=0;
		var inv_set = 'n';
		var idvType_you=getObject('ft3_you');
		var advType_you=getObject('ft2_you');
		var simType_you=getObject('ft1_you');
		//alert(simType.checked);
		
		if (document.adminForm.invert_you.checked) {
			inv_set = 'i';
		}
		if(simType_you.checked) {
			selectAll(selectObj);
			if(selectObj.selectedIndex != -1)
			{
				for(i = 0; i < selectObj.options.length; i++)
				{
					if(j>0) filterfields_you +=  ' AND ';
					filterfields_you +=  selectObj.options[i].value;
					j++
				}
				//alert(filterfields);
				if(filterfields_you!="") {
					document.adminForm.q_you.value=inv_set+"s("+filterfields_you+")";
				} else {
					document.adminForm.q_you.value="";
				}
			}
		} else if (advType_you.checked) {
			if(document.adminForm.advFilterText_you.value!="") {
				document.adminForm.q_you.value=inv_set+"a("+escape(document.adminForm.advFilterText_you.value)+")";
			} else {
				document.adminForm.q_you.value="";
			}
		} else {
			if(document.adminForm.idvFilterText_you.value!="") {
				document.adminForm.q_you.value=inv_set+"i("+escape(document.adminForm.idvFilterText_you.value)+")";
			} else {
				document.adminForm.q_you.value="";
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

	function filterCondition_me(needCond) {
		if(needCond==0) {
			document.adminForm.condition_me.value="";
			document.adminForm.condition_me.readOnly=true;
			document.adminForm.condition_me.setAttribute("Req",0);
		} else {
			document.adminForm.condition_me.value="";
			document.adminForm.condition_me.readOnly=false;
			document.adminForm.condition_me.setAttribute("Req",1);
		}

	}
	function filterCondition_you(needCond) {
		if(needCond==0) {
			document.adminForm.condition_you.value="";
			document.adminForm.condition_you.readOnly=true;
			document.adminForm.condition_you.setAttribute("Req",0);
		} else {
			document.adminForm.condition_you.value="";
			document.adminForm.condition_you.readOnly=false;
			document.adminForm.condition_you.setAttribute("Req",1);
		}

	}

	function ins_isBuddy(where) {
		var isBuddy_txt = "SELECT b.id FROM #__cbe_buddylist AS a, #__users AS b WHERE (((a.userid=$user->id AND a.buddyid=$my->id AND b.id=a.buddyid) OR (a.buddyid=$user->id AND a.userid=$my->id AND b.id=a.userid)) AND a.buddy=1)";
		where.value = isBuddy_txt;
	}
	function ins_over18(where) {
		var over18_text = "SELECT user_id FROM #__cbe WHERE ((DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(cb_birthday, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(cb_birthday, '00-%m-%d'))) >= 18 AND user_id=$my->id)";
		where.value = over18_text;
	}

	// -->
	</script>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/categories.png" align="middle"><?php echo $row->tabid ? _UE_CBE_TM_EDIT : _UE_CBE_TM_ADD;?></td>
		</tr>
	</table>

	<form action="index2.php?option=com_cbe&task=saveTab" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_TITLE; ?>:</td>
			<td width="85%"><input type="text" name="title" class="inputbox" mosReq=1 size="40" value="<?php echo $row->title; ?>" <?php echo $title_readonly; ?>/></td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_DESCRIPTION; ?>:</td>
			<td width="85%"><textarea name="description" class="inputbox" cols="40" rows="10"><?php echo $row->description; ?></textarea></td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_PUBLISHED; ?>:</td>
			<td width="85%"><?php echo $lists['enabled']; ?></td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_ENH_PARAMS; ?>:</td>
			<td width="85%"><textarea name="enhanced_params" class="inputbox" cols="40" rows="5"><?php echo $row->enhanced_params; ?></textarea></td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_ISNEST; ?>:</td>
			<td width="85%"><?php echo $lists['is_nest']; ?></td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_NESTED; ?>:</td>
			<td width="85%"><?php echo $lists['nested']; ?></td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_NESTID; ?>:</td>
			<td width="85%"><?php echo $lists['nest_id']; ?></td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_GID_ACL; ?>:</td>
			<td width="20%" style="valign:center;"><?php echo $lists['aclgroupsL']; ?>&nbsp;<input type="button" name="clearall" value="Free for all" class="button" onclick="clearUGIDs()" />
			<br /><?php echo _UE_CBE_TM_ACL_DESC1; ?>
			<br /><b><?php echo _UE_CBE_TM_ACL_DESC2; ?></b>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<hr width="80%" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_FEXPLAIN; ?>:</td>
			<td width="85%"><?php echo _UE_CBE_TM_FEXPLAIN_DESC; ?></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<hr width="80%" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_TM_FQME; ?>:</td>
			<td width="60%">
<?php

$simChecked_me="";
$advChecked_me="";
$idvChecked_me="";
$simStyle_me="display:none;";
$advStyle_me="display:none;";
$idvStyle_me="display:none;";
//echo $row->q_me;
$filttype_me=substr($row->q_me,0,1);
$row->q_me=substr($row->q_me,1);
if($filttype_me=="a") {
	$advChecked_me="CHECKED";
	$advStyle_me="display:block;";
} elseif ($filttype_me=="i") {
	$idvChecked_me="CHECKED";
	$idvStyle_me="display:block;";
} else {
	$simChecked_me="CHECKED";
	$simStyle_me="display:block;";
}
$filterlists_me=explode(" AND ",$row->q_me);
$filterparts_me=array();
$i=0;
foreach($filterlists_me as $filterlist_me) {

	$filterlistpart_me=array();
	$filterlistpart_me=explode(" ",$filterlist_me);
	$filterparts_me[$i]['field']=str_replace("`","",$filterlistpart_me[0]);
	$database->setQuery("SELECT title FROM #__cbe_fields WHERE name='".$filterparts_me[$i]['field']."' LIMIT 1");
	$filtertitle_me=$database->loadResult();
	$filterparts_me[$i]['value']=$filterlist_me;
	$filterparts_me[$i]['title']=str_replace(array("'","`"),"",str_replace($filterparts_me[$i]['field'],CBE_getLangDefinition($filtertitle_me),$filterlist_me));

	$i++;
}
?>
				<label for=ft1_me ><input type="radio" <?php echo $simChecked_me; ?> id=ft1_me onclick="javascript:shDiv('simFilter_me',1);shDiv('advFilter_me',0);shDiv('idvFilter_me',0);" name="filtertype_me" value=0 checked /><?php echo _UE_CBE_TM_FSIMPLE; ?> </label><label for=ft2_me ><input type="radio" <?php echo $advChecked_me; ?> onclick="javascript:shDiv('simFilter_me',0);shDiv('advFilter_me',1);shDiv('idvFilter_me',0);" id="ft2_me" name="filtertype_me" value="1" /><?php echo _UE_CBE_TM_FADVANCED; ?> </label>
				<label for=ft3_me ><input type="radio" <?php echo $idvChecked_me; ?> onclick="javascript:shDiv('simFilter_me',0);shDiv('advFilter_me',0);shDiv('idvFilter_me',1);" id="ft3_me" name="filtertype_me" value="2" /><?php echo _UE_CBE_TM_FINDIVIDUAL; ?> </label>
				<br />
				<div id="simFilter_me" name="simFilter_me" style="<?php echo $simStyle_me; ?>" >
				<select name="filterfieldlist_me">
					<?php
					foreach ($filterfields AS $filterfield) {
						echo "<option value=\"`".$filterfield->name."`\">".CBE_getLangDefinition($filterfield->title)."\n";
					}

					?>
				</select>
				<select name=comparison_me onchange="javascript:filterCondition_me(this.options[this.selectedIndex].getAttribute('needCond'));">
					<option value=">" needCond=1><?php echo _UE_CBE_LM_SQL_1; ?></option>
					<option value=">=" needCond=1><?php echo _UE_CBE_LM_SQL_2; ?></option>
					<option value="<" needCond=1><?php echo _UE_CBE_LM_SQL_3; ?></option>
					<option value="<=" needCond=1><?php echo _UE_CBE_LM_SQL_4; ?></option>
					<option value="=" needCond=1><?php echo _UE_CBE_LM_SQL_5; ?></option>
					<option value="!=" needCond=1><?php echo _UE_CBE_LM_SQL_6; ?></option>
					<option value="IS NULL" needCond=0><?php echo _UE_CBE_LM_SQL_7; ?></option>
					<option value="IS NOT NULL"  needCond=0><?php echo _UE_CBE_LM_SQL_8; ?></option>
					<option value="LIKE"  needCond=1><?php echo _UE_CBE_LM_SQL_9; ?></option>
				</select>
				<input type=text name=condition_me value="" Req=1 />
				<input type=button onclick="moveOption3_me(this.form.filterfieldlist_me, filter_me, this.form.comparison_me.value, this.form.condition_me.value);" value=" <?php echo _UE_CBE_ADD; ?> ">
				<br />
				<select id=filter_me name=filter_me size="5" multiple  mosReq=0 mosLabel="Filter By">
					<?php
					foreach ($filterparts_me AS $filterpart_me) {
						if($filterpart_me['value']!='') {
							echo "<option value=\"".str_replace(array("(",")"),"",$filterpart_me['value'])."\">".stripslashes(utf8RawUrlDecode($filterpart_me['title']))."\n";
						}
					}

					?>
				</select><br />
				<input type=button onclick="moveOptions(filter_me, -1);" value=" + " />
				<input type=button onclick="moveOptions(filter_me, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption4_me(this.form.filter_me,this.form.filterfieldlist_me);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
				</div>
				<div id="advFilter_me" name="advFilter_me" style="<?php echo $advStyle_me; ?>">
					<textarea name="advFilterText_me" cols="50" rows="4"><?php  
							$checkpos = false;
							$checkpos = strpos(strtolower(utf8RawUrlDecode(substr($row->q_me,1,-1))),'select');
							$checkpos1 = strpos(strtolower(utf8RawUrlDecode(substr($row->q_me,1,-1))),';');
							if (($checkpos===false) && ($filttype=='a' || $filttype='s') && ($checkpos1===false)) {
								echo utf8RawUrlDecode(substr($row->q_me,1,-1)); 
							}
						?></textarea>
				</div>
				<div id="idvFilter_me" name="idvFilter_me" style="<?php echo $idvStyle_me; ?>">
					<textarea name="idvFilterText_me" cols="50" rows="7"><?php 
							$checkpos = false;
							$q_me_invalid = 0;
							$checkpos = strpos(strtolower(utf8RawUrlDecode(substr($row->q_me,1,-1))),'select');
							$checkpos1 = strpos(strtolower(utf8RawUrlDecode(substr($row->q_me,1,-1))),';');
							if ($checkpos!==false && $checkpos == 0 && $checkpos1 === false) {
								echo utf8RawUrlDecode(substr($row->q_me,1,-1)); 
							} else {
								$q_me_invalid = 1;
							}
						?></textarea>
						<?php 
							if ($q_me_invalid == 1) {
								echo "<br />"._UE_CBE_TM_FINVALID."<br />";
							}
						?>
				</div>

			</td>
		</tr>
		<tr>
			<td width="25"><?php echo _UE_CBE_TM_FQBIND; ?>:</td>
			<td width="85%"><?php echo $lists['q_bind']; ?></td>
		</tr>

<!-- // in -->
		<tr>
			<td width="20%"><?php echo _UE_CBE_TM_FQYOU; ?>:</td>
			<td width="60%">
<?php

$simChecked_you="";
$advChecked_you="";
$idvChecked_you="";
$simStyle_you="display:none;";
$advStyle_you="display:none;";
$idvStyle_you="display:none;";
//echo $row->q_you;
$inv_you_set = '';
$filttype_you_inv = substr($row->q_you,0,1);
if ($filttype_you_inv == 'i') {
	$inv_you_set = 'checked';
}
$row->q_you=substr($row->q_you,1);
$filttype_you=substr($row->q_you,0,1);
$row->q_you=substr($row->q_you,1);
if($filttype_you=="a") {
	$advChecked_you="CHECKED";
	$advStyle_you="display:block;";
} elseif ($filttype_you=="i") {
	$idvChecked_you="CHECKED";
	$idvStyle_you="display:block;";
} else {
	$simChecked_you="CHECKED";
	$simStyle_you="display:block;";
}
$filterlists_you=explode(" AND ",$row->q_you);
$filterparts_you=array();
$i=0;
foreach($filterlists_you as $filterlist_you) {

	$filterlistpart_you=array();
	$filterlistpart_you=explode(" ",$filterlist_you);
	$filterparts_you[$i]['field']=str_replace("`","",$filterlistpart_you[0]);
	$database->setQuery("SELECT title FROM #__cbe_fields WHERE name='".$filterparts_you[$i]['field']."' LIMIT 1");
	$filtertitle_you=$database->loadResult();
	$filterparts_you[$i]['value']=$filterlist_you;
	$filterparts_you[$i]['title']=str_replace(array("'","`"),"",str_replace($filterparts_you[$i]['field'],CBE_getLangDefinition($filtertitle_you),$filterlist_you));

	$i++;
}
?>
				<label for=ft1_you ><input type="radio" <?php echo $simChecked_you; ?> id=ft1_you onclick="javascript:shDiv('simFilter_you',1);shDiv('advFilter_you',0);shDiv('idvFilter_you',0);" name="filtertype_you" value=0 checked /><?php echo _UE_CBE_TM_FSIMPLE; ?> </label><label for=ft2_you ><input type="radio" <?php echo $advChecked_you; ?> onclick="javascript:shDiv('simFilter_you',0);shDiv('advFilter_you',1);shDiv('idvFilter_you',0);" id="ft2_you" name="filtertype_you" value="1" /><?php echo _UE_CBE_TM_FADVANCED; ?> </label>
				<label for=ft3_you ><input type="radio" <?php echo $idvChecked_you; ?> onclick="javascript:shDiv('simFilter_you',0);shDiv('advFilter_you',0);shDiv('idvFilter_you',1);" id="ft3_you" name="filtertype_you" value="2" /><?php echo _UE_CBE_TM_FINDIVIDUAL; ?> </label>
				<br />
				<div id="simFilter_you" name="simFilter_you" style="<?php echo $simStyle_you; ?>" >
				<select name="filterfieldlist_you">
					<?php
					foreach ($filterfields AS $filterfield) {
						echo "<option value=\"`".$filterfield->name."`\">".CBE_getLangDefinition($filterfield->title)."\n";
					}

					?>
				</select>
				<select name=comparison_you onchange="javascript:filterCondition_you(this.options[this.selectedIndex].getAttribute('needCond'));">
					<option value=">" needCond=1><?php echo _UE_CBE_LM_SQL_1; ?></option>
					<option value=">=" needCond=1><?php echo _UE_CBE_LM_SQL_2; ?></option>
					<option value="<" needCond=1><?php echo _UE_CBE_LM_SQL_3; ?></option>
					<option value="<=" needCond=1><?php echo _UE_CBE_LM_SQL_4; ?></option>
					<option value="=" needCond=1><?php echo _UE_CBE_LM_SQL_5; ?></option>
					<option value="!=" needCond=1><?php echo _UE_CBE_LM_SQL_6; ?></option>
					<option value="IS NULL" needCond=0><?php echo _UE_CBE_LM_SQL_7; ?></option>
					<option value="IS NOT NULL"  needCond=0><?php echo _UE_CBE_LM_SQL_8; ?></option>
					<option value="LIKE"  needCond=1><?php echo _UE_CBE_LM_SQL_9; ?></option>
				</select>
				<input type=text name=condition_you value="" Req=1 />
				<input type=button onclick="moveOption3_you(this.form.filterfieldlist_you, filter_you, this.form.comparison_you.value, this.form.condition_you.value);" value=" <?php echo _UE_CBE_ADD; ?> ">
				<br />
				<select id=filter_you name=filter_you size="5" multiple  mosReq=0 mosLabel="Filter By">
					<?php
					foreach ($filterparts_you AS $filterpart_you) {
						if($filterpart_you['value']!='') {
							echo "<option value=\"".str_replace(array("(",")"),"",$filterpart_you['value'])."\">".stripslashes(utf8RawUrlDecode($filterpart_you['title']))."\n";
						}
					}

					?>
				</select><br />
				<input type=button onclick="moveOptions(filter_you, -1);" value=" + " />
				<input type=button onclick="moveOptions(filter_you, 1);" value=" - " />
				<br />
				<input type=button onclick="moveOption4_you(this.form.filter_you,this.form.filterfieldlist_you);" value=" <?php echo _UE_CBE_REMOVE; ?> ">
				</div>
				<div id="advFilter_you" name="advFilter_you" style="<?php echo $advStyle_you; ?>">
					<textarea name="advFilterText_you" cols="50" rows="4"><?php  
							$checkpos = false;
							$checkpos = strpos(strtolower(utf8RawUrlDecode(substr($row->q_you,1,-1))),'select');
							$checkpos1 = strpos(strtolower(utf8RawUrlDecode(substr($row->q_you,1,-1))),';');
							if (($checkpos===false) && ($filttype=='a' || $filttype='s') && ($checkpos1===false)) {
								echo utf8RawUrlDecode(substr($row->q_you,1,-1)); 
							}
						?></textarea>
				</div>
				<div id="idvFilter_you" name="idvFilter_you" style="<?php echo $idvStyle_you; ?>">
					<textarea name="idvFilterText_you" cols="50" rows="7"><?php 
							$checkpos = false;
							$q_you_invalid = 0;
							$checkpos = strpos(strtolower(utf8RawUrlDecode(substr($row->q_you,1,-1))),'select');
							$checkpos1 = strpos(strtolower(utf8RawUrlDecode(substr($row->q_you,1,-1))),';');
							if ($checkpos!==false && $checkpos == 0 && $checkpos1 === false) {
								echo utf8RawUrlDecode(substr($row->q_you,1,-1)); 
							} else {
								$q_you_invalid = 1;
							}
						?></textarea>
						<?php 
							if ($q_you_invalid == 1) {
								echo "<br />"._UE_CBE_TM_FINVALID."<br />";
							}
						?>
						<br />
						<input type="button" onClick="ins_isBuddy(this.form.idvFilterText_you);" value="isBuddy" />
						<input type="button" onClick="ins_over18(this.form.idvFilterText_you);" value="isOver18" />
				</div>
				<br>
				<input type="checkbox" name="invert_you" value="1" <?php echo $inv_you_set; ?>/> <?php echo _UE_CBE_TM_FQYOU_INVERT; ?>

			</td>
		</tr>

		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
<!-- // out -->
  </table>
  <input type="hidden" name="tabid" value="<?php echo $row->tabid; ?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="aclgroups" value="<?php echo $row->aclgroups; ?>" />
  <input type="hidden" name="q_me" value="<?php echo $row->q_me; ?>" />
  <input type="hidden" name="q_you" value="<?php echo $row->q_you; ?>" />
  <input type="hidden" name="task" value="" />
</form>
<?php 
}

function showUsers( &$rows, $pageNav, $search, $option, $sort ) {
	global $mosConfig_offset, $mosConfig_lang;
	JHTML::_('behavior.tooltip');

?>
<form action="index2.php" method="post" name="adminForm">
<input type=hidden name="limitstart" value="<?php echo $pageNav->limitstart; ?>">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>/administrator/images/user.png" align="middle"><?php echo _UE_CBE_USER_MANAGER; ?></td>
      <td nowrap="nowrap"><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
      <td> <?php echo $pageNav->getLimitBox(); ?> </td>
      <td><?php echo _UE_CBE_UM_SEARCH; ?>:</td>
      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
      </td>
    </tr>
<!--    <tr>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td><a href="#" onClick="JavaScript:document.adminForm.sort.value='';document.adminForm.submit();">Reset Sort</a>
      </td>
    </tr>
-->
  </table>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</td>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="20%" class="title" onMouseOver="this.style.cursor='pointer'" onClick="JavaScript:document.adminForm.sort.value='';document.adminForm.submit();"><?php echo _UE_CBE_UM_REALNAME; ?><br><?php echo _UE_CBE_M_CLICK; ?></th>
      <th width="10%" class="title"><?php echo _UE_CBE_UM_USERNAME; ?></th>
      <th width="5%" class="title" nowrap="nowrap"><?php echo _UE_CBE_UM_LOGGED_IN; ?></th>
      <th width="15%" class="title"><?php echo _UE_CBE_UM_USERGROUP; ?></th>
      <th width="15%" class="title"><?php echo _UE_CBE_UM_EMAIL; ?></th>
      <th width="15%" class="title"><?php echo _UE_CBE_UM_LAST_VISIT; ?></th>
      <th width="5%" class="title" onMouseOver="this.style.cursor='pointer'" onClick="JavaScript:document.adminForm.sort.value='blocked';document.adminForm.submit();"><?php echo _UE_CBE_UM_ENABLED; ?><br><?php echo _UE_CBE_M_JOOMLA; ?><br><?php echo _UE_CBE_M_CLICK; ?></th>
      <th width="5%" class="title" onMouseOver="this.style.cursor='pointer'" onClick="JavaScript:document.adminForm.sort.value='unconfirmed';document.adminForm.submit();"><?php echo _UE_CBE_UM_CONFIRMED; ?><br><?php echo _UE_CBE_M_USER; ?><br><?php echo _UE_CBE_M_CLICK; ?></th>
      <th width="5%" class="title" onMouseOver="this.style.cursor='pointer'" onClick="JavaScript:document.adminForm.sort.value='unapproved';document.adminForm.submit();"><?php echo _UE_CBE_UM_APPROVED; ?><br><?php echo _UE_CBE_M_ADMIN; ?><br><?php echo _UE_CBE_M_CLICK; ?></th>
      <th width="5%" class="title"><?php echo _UE_CBE_UM_AVATAR_APPROVED; ?><br><?php echo _UE_CBE_M_ADMIN; ?></th>
    </tr>
<?php
$k = 0;
$imgpath='../components/com_cbe/images/';
for ($i=0, $n=count( $rows ); $i < $n; $i++) {
	$row =& $rows[$i];
	$img = $row->block ? 'publish_x.png' : 'tick.png';
	$task = $row->block ? 'unblock' : 'block';

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
	$task3 = $row->confirmed ?   'reject':'approve';

	$img4 = $row->avatarapproved ?  'tick.png' : 'publish_x.png';
	$task4 = $row->avatarapproved ?   'avatarDisapprove':'avatarApprove';

	$img5 = $row->confirmed ?  'tick.png' : 'publish_x.png';
	$task5 = $row->confirmed ?   'userDisconfirm':'userConfirm';

	$no_cbe_user = '';
	if ($row->cbe_user == '' || !$row->cbe_user || $row->cbe_user == '0') {
		$no_cbe_user = ' style="background: rgb(255,0,0);"';
	}

	if (file_exists(JPATH_SITE . "/images/cbe/tn" . $row->avatar))
		$tnpic = "<img src='" . JURI::root() . "images/cbe/tn" . $row->avatar . "'>";
	else
		$tnpic = "<img src='" . JURI::root() . "components/com_cbe/images/$mosConfig_lang/tnpendphoto.jpg'>";
?>
    <tr class="<?php echo "row$k"; ?>"<?php echo $no_cbe_user; ?> >
      <td><?php echo $i+1+$pageNav->limitstart;?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" /></td>
      <td>
	<span class="editlinktip hasTip" title="Vorschaubild::<?php echo $tnpic; ?>">
		<a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
        <?php echo $row->name; ?> </a>	</span></td>
      <td><?php echo $row->username; ?></td>
      <td align="center"><?php echo $row->loggedin ? '<img src="images/tick.png" width="12" height="12" border="0" alt="" />': ''; ?></td>
      <td><?php echo $row->groupname; ?></td>
      <td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
      <td><?php echo JHTML::_('date',$row->lastvisitDate, "%Y-%m-%d %H:%M:%S" ); ?></td>
      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task;?>')"><img src="<?php echo $imgpath.$img;?>" width="12" height="12" border="0" alt="" /></a></td>
	<td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task5;?>')"><img src="<?php echo $imgpath.$img5;?>" width="12" height="12" border="0" alt="" /></a></td>
	<td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task2;?>')"><img src="<?php echo $imgpath.$img2;?>" width="12" height="12" border="0" title="<?php echo $hover; ?>" alt="<?php echo $hover; ?>" /></a></td>
	<td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
','<?php echo $task4;?>')"><img src="<?php echo $imgpath.$img4;?>" width="12" height="12" border="0" alt="" /></a></td>

    </tr>
    <?php $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="12"> <?php echo $pageNav->getPagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="12"> <?php echo $pageNav->getPagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="sort" value="<?php echo $sort;?>" />
  <input type="hidden" name="task" value="showusers" />
  <input type="hidden" name="boxchecked" value="0" />
</form>
<?php }

function edituser( $user, $option, $uid, &$params ) {
	global $ueConfig,$enhanced_Config,$mosConfig_live_site;
	// funktionen einbinden
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbTabs.php');
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');

	$acl =& JFactory::getACL();
	$database = &JFactory::getDBO();
	$my = &JFactory::getUser();
	global $Itemid_comb;
	if ($enhanced_Config['tooltip_wz'] != '1') {
		//mosCommonHTML::loadOverlib();
		JHTML::_('behavior.tooltip');

	}

	$tabs = new cbTabs( 0,2,"luna" );
	$tabcontent=$tabs->getEditTabs($user);
	$canEmailEvents = $acl->acl_check( 'workflow', 'email_events', 'users', $acl->get_group_name( $user->gid, 'ARO' ) );

	echo "\n<script type=\"text/javascript\" src=\"".JURI::root()."index2.php?option=com_cbe".$Itemid_comb."&format=raw&task=callthrough&scrp=cbe_db\"></script>";
	echo "\n<script type=\"text/javascript\" src=\"".JURI::root()."index2.php?option=com_cbe".$Itemid_comb."&format=raw&task=callthrough&scrp=cbe_tb\"></script>\n";
	$database->setQuery("SELECT enabled FROM #__cbe_tabs WHERE plugin='getGeoCoderEdit' LIMIT 1");
	$geo_enabled = $database->loadResult();
	if ($geo_enabled == '1') {
		echo '<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key='.$enhanced_Config['geocoder_google_apikey'].'" type="text/javascript"></script> ';
		echo "\n";
	}

?>
<link rel="stylesheet" type="text/css" media="all" href="../includes/js/calendar/calendar-mos.css" title="green" />
<!-- import the calendar script -->
<script type="text/javascript" src="../includes/js/calendar/calendar.js"></script>
<!-- import the language module -->
<script type="text/javascript" src="../includes/js/calendar/lang/calendar-en.js"></script>
<style>
.titleCell {
	font-weight:bold;
	width:85px;
}
</style>
<script language="javascript" type="text/javascript">
function getObject(obj) {
	var strObj;
	if (document.all) {
		strObj = document.all.item(obj);
	} else if (document.getElementById) {
		strObj = document.getElementById(obj);
	}
	return strObj;
}

var cbeDefaultFieldBackground;
function submitbutton(pressbutton) {
	if (pressbutton == 'showusers') {
		submitform(pressbutton);
		return;
	}
	if (pressbutton == 'adminUpAvatar') {
		submitform(pressbutton);
		return;
	}
	if (pressbutton == 'adminDelAvatar') {
		submitform(pressbutton);
		return;
	}
	var coll = document.adminForm;
<?php //	var r = new RegExp("^\_|^\-|[^a-z|A-Z|^0-9|\_|\-]|\_$|\-$", "i"); ?>
	var r = new RegExp("<?php echo $ueConfig['reg_regex']; ?>", "i");
	var errorMSG = '';
	var iserror=0;
	if (cbeDefaultFieldBackground === undefined) {
		cbeDefaultFieldBackground = ((cbeForm['username'].style.getPropertyValue) ? cbeForm['username'].style.getPropertyValue("background-color") : cbeForm['username'].style.backgroundColor);
	}
	<?php echo $tabs->fieldJS; ?>
	if (r.exec(coll.username.value)) {
		errorMSG += '<?php printf( _VALID_AZ09, _PROMPT_UNAME, 6 );?>\n';
		iserror=1;
	} else if ((coll.password.value != "") && (coll.password.value != coll.verifyPass.value)){
		errorMSG += '<?php echo _REGWARN_VPASS2;?>\n';
		iserror=1;
	} else if (r.exec(coll.password.value)) {
		errorMSG += '<?php printf( _VALID_AZ09, _REGISTER_PASS, 6 );?>\n';
		iserror=1;
	} else if (coll.gid.value == "") {
		errorMSG += 'You must assign user to a group.\n';
		iserror=1;
	}
	if(document.all) {
		if ( coll.fireEvent ) {
			coll.fireEvent('onsubmit');
		}
	} else if (document.getElementById) {
		if ( document.createEvent && window.dispatchEvent ) {
			var evt = document.createEvent("HTMLEvents");
			evt.initEvent("onsubmit", false, false);
			window.dispatchEvent(evt);
		}
	}
	if (coll != null) {
		var elements = coll.elements;
		// loop through all input elements in form
		for (var i=0; i < elements.length; i++) {
			// check if element is mandatory; here mosReq=1
			if (elements.item(i).getAttribute('mosReq') == 1) {
				//alert(elements.item(i).getAttribute('name')+' '+elements.item(i).getAttribute('mosReq')+' '+elements.item(i).value.length);
				if (elements.item(i).type == 'radio' || elements.item(i).type == 'checkbox') {
					var rOptions = coll.elements[elements.item(i).getAttribute('name')];
					var rChecked = 0;
					if(rOptions.length > 1) {
						for (var r=0; r < rOptions.length; r++) {
							//alert(rOptions.item(r).checked);
							if (rOptions.item(r).checked) {
								rChecked=1; //alert('I found a CHECKED One!');
							}
						}
					} else {
						if (elements.item(i).checked) {
							rChecked=1; //alert('I found a CHECKED One!');
						}
					}
					if(rChecked==0) {
						// add up all error messages
						errorMSG += elements.item(i).getAttribute('mosLabel') + ' <?php echo _UE_REQUIRED_ERROR; ?>\n';
						// notify user by changing background color, in this case to red
						elements.item(i).style.background = "red";
						iserror=1;
					}
				}
				if (elements.item(i).value == '') {
					// add up all error messages
					errorMSG += elements.item(i).getAttribute('mosLabel') + ' <?php echo _UE_REQUIRED_ERROR; ?>\n';
					// notify user by changing background color, in this case to red
					elements.item(i).style.background = "red";
					iserror=1;
				}
				if (coll[i].getAttribute('cbe_type') == 'birthdate') {
					var hf_i = i + 1;
					var co1name = coll[i].name + "_hid";
					var chk_cf = cbe_compareHidden(coll[i], coll[co1name]);
				//	alert(coll[i].name + ": " + coll[i].value + " -- " + coll[co1name].name + ": " + coll[co1name].value );
					if (chk_cf == false) {
						errorMSG += coll[i].getAttribute('mosLabel') + '\t: <?php echo _UE_REQUIRED_ERROR; ?>\n';
						// notify user by changing background color, in this case to red
						coll[i].style.backgroundColor = "red";
						iserror=1;
					} else {
						coll[i].style.backgroundColor = cbeDefaultFieldBackground;
					}
				}
				if (coll[i].getAttribute('cbe_type') == 'dateselect' || coll[i].getAttribute('cbe_type') == 'dateselectrange') {
					var co1name = coll[i].getAttribute('cbe_name') + "_hid";
					if (coll[co1name].value == null || coll[co1name].value.length == 0 || coll[co1name].value == '') {
						errorMSG += coll[i].getAttribute('mosLabel') + ': <?php echo _UE_REQUIRED_ERROR; ?>\n';
						// notify user by changing background color, in this case to red
						coll[i].style.backgroundColor = "red";
						iserror=1;
					} else {
						coll[i].style.backgroundColor = cbeDefaultFieldBackground;
					}
				}
			}
		}
	}
	if(iserror==1) { alert(errorMSG); }
	else {
		coll.submit();
	}
}
function showCalendar2(id,dFormat,lowRange,highRange) {
	var el = getObject(id);
	var st_year = 1900;
	var en_year = 2070;
	if (lowRange != 0) {
		st_year = lowRange;
	}
	if (highRange != 0) {
		en_year = highRange;
	}
	if (calendar != null) {
		// we already have one created, so just update it.
		calendar.hide();    // hide the existing calendar
		calendar.parseDate(el.value); // set it to a new date
		calendar.setRange(st_year, en_year);  // min/max year allowed
	} else {
		// first-time call, create the calendar
		var cal = new Calendar(true, null, selected, closeHandler);
		calendar = cal;    // remember the calendar in the global
		cal.setRange(st_year, en_year);  // min/max year allowed
		cal.dateFormat = dFormat;
		calendar.create();    // create a popup calendar
		if (el.value != '') {
			calendar.parseDate(el.value); // set it to a new date
		} else {
			calendar.parseDate('01.01.1970'); // set it to a new date
		}
	}
	calendar.sel = el;    // inform it about the input field in use
	calendar.showAtElement(el);  // show the calendar next to the input field

	// catch mousedown on the document
	Calendar.addEvent(document, "mousedown", checkCalendar);
	return false;
}
  </script>
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>/administrator/images/user.png" align="middle"><?php echo $user->id ? _UE_CBE_UM_EDIT : _UE_CBE_UM_ADD;?></td>
		</tr>
	</table>
	<form action="index2.php" method="POST" name="adminForm" id="adminForm">
		<script language="javascript" type="text/javascript">
			var cbeForm = document.adminForm.elements;
		</script>
<?php
echo "<table cellspacing='0' cellpadding='4' border='0' width='100%'><tr><td width='100%'>\n";
echo $tabcontent;
echo "</td></tr></table>";
?>
  <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
<?php	if (!$canEmailEvents) { ?>
  <input type="hidden" name="sendEmail" value="0" />
<?php } 
If (($ueConfig["usernameedit"]=='0') AND ($ueConfig['adminrequiredfields']=='1')) {
	echo "<input class='inputbox' type='hidden' name='username' value='".$user->username."' />";
}
?>
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="save" />
</form>
<div style="align:center;">
<?php
echo "<img src='".JURI::root()."components/com_cbe/images/required.gif' title='"._UE_FIELDREQUIRED."' /> "._UE_FIELDREQUIRED." | ";
echo "<img src='".JURI::root()."components/com_cbe/images/profiles.gif' title='"._UE_FIELDONPROFILE."' /> "._UE_FIELDONPROFILE." | ";
echo "<img src='".JURI::root()."components/com_cbe/images/noprofiles.gif' title='"._UE_FIELDNOPROFILE."' /> "._UE_FIELDNOPROFILE;
?>
</div>
<?php }

function showConfig( &$ueConfig, &$lists, $option ) {
	require_once( JPATH_SITE . '/includes/domit/xml_domit_lite_include.php' );
	jimport('joomla.html.pane');

?>
<script language="javascript" type="text/javascript">
<!--
function isNummericFieldFloat(elem)
{
	var str = elem.value;
	var re = /[-+]?\b[0-9]+(\.[0-9]+)?\b/;
	if ((!str.match(re) || (str.match(/[,]/))) && str!='')
	{
		alert("<?php echo _UE_CBE_FLOAT_ERROR; ?>");
		//alert("Verify the value format. Only floating point nummerics allowed.");
		elem.style.background = "red";
		setTimeout("focusElement('" + elem.form.name + "', '" + elem.name + "')", 0);
		return false;
	}
	else
	{
		if (elem.style.background=="red") {
			elem.style.background = "";
		}
		return true;
	}
}
//-->
</script>



	<table cellpadding="4" cellspacing="0" border="0" width="95%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/config.png" align="middle">Configuration Manager</td>
		</tr>
	</table>
   <form action="index2.php" method="post" name="adminForm">
   <input type="hidden" name="cfg_version" value="<?php echo $ueConfig['version']; ?>" />
   <table cellspacing='0' cellpadding='4' border='0' width='100%'><tr><td width='100%'>
<?php
//$tabs = new cbTabs( 0,2,"luna" );
$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
echo $pane->startPane('CB');
echo $pane->startPanel(_UE_GENERAL, 'tab1');
//echo $tabs->startPane( "CB" );
//echo $tabs->startTab("CB",_UE_GENERAL,"tab1");
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
         <td align="left" valign="top"><?php echo _UE_UNAME_PATHWAY ?></td>
         <td align="left" valign="top"><?php echo $lists['uname_pathway']; ?></td>
         <td align="left" valign="top"><?php echo _UE_UNAME_PATHWAY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_DISPLAY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_email_display']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_EMAIL_DISPLAY_DESC ?></td>
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
         <td align="left" valign="top"><?php echo _UE_SHOW_JEDITOR ?></td>
         <td align="left" valign="top"><?php echo $lists['show_jeditor']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_JEDITOR_DESC ?></td>
      </tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBEDOLOGIN ?></td>
         <td align="left" valign="top"><?php echo $lists['cbedologin']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBEDOLOGIN_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_JS_SWITCH ?></td>
         <td align="left" valign="top"><?php echo $lists['switch_js_inc']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_JS_SWITCH_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_REGISTRATION,"tab2");
//echo $tabs->endTab();
//echo $tabs->startTab("CB",_UE_REGISTRATION,"tab2");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_USERNAME_MIN ?></td>
         <td align="left" valign="top"><?php echo $lists['username_min']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_USERNAME_MIN_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_USERNAME_MAX ?></td>
         <td align="left" valign="top"><?php echo $lists['username_max']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_USERNAME_MAX_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PASSWORD_MIN ?></td>
         <td align="left" valign="top"><?php echo $lists['password_min']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_PASSWORD_MIN_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_GENPASSWORD ?></td>
         <td align="left" valign="top"><?php echo $lists['generatepass_on_reg']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_GENPASSWORD_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PASSWORD_MAIL ?></td>
         <td align="left" valign="top"><?php echo $lists['emailpass_on_reg']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_PASSWORD_MAIL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_REGEX ?></td>
<?php
	$ueConfig['reg_regex'] = str_replace('\"', '&quot;',$ueConfig['reg_regex']);
?>
         <td align="left" valign="top"><input type="text" name="cfg_reg_regex" value="<?php echo $ueConfig['reg_regex']; ?>" size="40"/></td>
         <td align="left" valign="top"><?php echo _UE_REG_REGEX_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
          <td align="center" valign="middle"></td>
         <td align="center" valign="middle" colspan="2"><?php echo _UE_REG_REGEX_NOTE ?></td>
      </tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_USEAJAX ?></td>
         <td align="left" valign="top"><?php echo $lists['reg_useajax']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_USEAJAX_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_USEAJAX_BUTTON ?></td>
         <td align="left" valign="top"><?php echo $lists['reg_useajax_button']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_USEAJAX_BUTTON_DESC ?></td>
      </tr>

	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_ALLOW ?></td>
         <td align="left" valign="top"><?php echo $lists['user_unregister_allow']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_ALLOW_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_EDITMODE ?></td>
         <td align="left" valign="top"><?php echo $lists['show_unregister_editmode']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_EDITMODE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_PROFILEMODE ?></td>
         <td align="left" valign="top"><?php echo $lists['show_unregister_profilemode']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_PROFILEMODE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_SENDMAILUSER ?></td>
         <td align="left" valign="top"><?php echo $lists['unregister_send_email']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_SENDMAILUSER_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_SENDMAILADMIN ?></td>
         <td align="left" valign="top"><?php echo $lists['unregister_moderatorEmail']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_SENDMAILADMIN_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_MAILSUB ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_unregister_sub" value="<?php echo stripslashes($ueConfig['reg_unregister_sub']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_MAILSUB_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_UNREGISTER_MAILMSG ?></td>
         <td align="left" valign="top" colspan=2><textarea name="cfg_reg_unregister_msg" cols=50 rows=6><?php echo stripslashes($ueConfig['reg_unregister_msg']); ?></textarea></td>
      </tr>
      <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
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
         <td align="left" valign="top"><?php echo _UE_REG_CONFIRMATION_HASH ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_confirmation_hash" onBlur="isNummericFieldFloat(this);" value="<?php echo $ueConfig['reg_confirmation_hash']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_CONFIRMATION_HASH_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_NAME ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_email_name" value="<?php echo $ueConfig['reg_email_name']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_NAME_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_FROM ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_email_from" value="<?php echo $ueConfig['reg_email_from']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_FROM_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_REPLYTO ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_email_replyto" value="<?php echo $ueConfig['reg_email_replyto']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_EMAIL_REPLYTO_DESC ?></td>
      </tr>
      <tr  align="left" valign="middle">
	 <td align="left" valign="top"></td>
	 <td align="left" valign="top" colspan=2><?php echo _UE_REG_EMAIL_TAGS; ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PEND_APPR_SUB ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_pend_appr_sub" value="<?php echo stripslashes($ueConfig['reg_pend_appr_sub']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_PEND_APPR_SUB_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_PEND_APPR_MSG ?></td>
         <td align="left" valign="top" colspan=2><textarea name="cfg_reg_pend_appr_msg" cols=50 rows=6><?php echo stripslashes($ueConfig['reg_pend_appr_msg']); ?></textarea></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_WELCOME_SUB ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_reg_welcome_sub" value="<?php echo stripslashes($ueConfig['reg_welcome_sub']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_WELCOME_SUB_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_WELCOME_MSG ?></td>
         <td align="left" valign="top" colspan=2><textarea name="cfg_reg_welcome_msg" cols=50 rows=6><?php echo stripslashes($ueConfig['reg_welcome_msg']); ?></textarea></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SET_MAIL_XHEADER ?></td>
         <td align="left" valign="top"><?php echo $lists['set_mail_xheader']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SET_MAIL_XHEADER_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_TOC_MSG ?></td>
         <td align="left" valign="top"><?php echo $lists['reg_enable_toc']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_TOC_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_TOC_URL_MSG ?></td>
         <td align="left" valign="top"><input type="text" size="50" name="cfg_reg_toc_url" value="<?php echo $ueConfig['reg_toc_url']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_TOC_URL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_DATASEC_MSG ?></td>
         <td align="left" valign="top"><?php echo $lists['reg_enable_datasec']; ?></td>
         <td align="left" valign="top"><?php echo _UE_REG_DATASEC_MSG_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_DATASEC_URL_MSG ?></td>
         <td align="left" valign="top"><input type="text" size="50" name="cfg_reg_datasec_url" value="<?php echo $ueConfig['reg_datasec_url']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_DATASEC_URL_MSG_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
      </tr>
     <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_REG_FIRST_VISIT_URL_MSG ?></td>
         <td align="left" valign="top"><input type="text" size="50" name="cfg_reg_first_visit_url" value="<?php echo $ueConfig['reg_first_visit_url']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_REG_FIRST_VISIT_URL_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_USERLIST,"tab3");
//echo $tabs->endTab();
//echo $tabs->startTab("CB",_UE_USERLIST,"tab3");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERLIST_SEARCH_USERNAME ?></td>
         <td align="left" valign="top"><?php echo $lists['search_username']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USERLIST_SEARCH_USERNAME_DESC ?></td>
	</tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERLIST_SHOW_SEARCHBOX ?></td>
         <td align="left" valign="top"><?php echo $lists['hide_searchbox']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USERLIST_SHOW_SEARCHBOX_DESC ?></td>
	</tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERLIST_SHOW_LISTSBOX ?></td>
         <td align="left" valign="top"><?php echo $lists['hide_listsbox']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USERLIST_SHOW_LISTSBOX_DESC ?></td>
	</tr>

	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NUM_PER_PAGE ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_num_per_page" value="<?php echo $ueConfig['num_per_page']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_NUM_PER_PAGE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERSLIST_RNR ?></td>
         <td align="left" valign="top"><?php echo $lists['userslist_rnr']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USERSLIST_RNR_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILELINK ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_profilelink']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILELINK_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILE_POPUP ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_profile_popup']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILE_POPUP_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_LISTVIEWBY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_listviewbyGID']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_LISTVIEWBY_DESC ?></td>
      </tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS1 ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_userslist_css1" value="<?php echo $ueConfig['userslist_css1']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS1_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS2 ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_userslist_css2" value="<?php echo $ueConfig['userslist_css2']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS2_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_USERPROFILE,"tab4");
//echo $tabs->endTab();
//echo $tabs->startTab("CB",_UE_USERPROFILE,"tab4");
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
         <td align="left" valign="top"><?php echo _UE_ALLOW_MAILCHANGE ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_mailchange']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_MAILCHANGE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ADMINREQUIREDFIELDS ?></td>
         <td align="left" valign="top"><?php echo $lists['adminrequiredfields']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ADMINREQUIREDFIELDS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ADMINSHOWALLTABS ?></td>
         <td align="left" valign="top"><?php echo $lists['adminshowalltabs']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ADMINSHOWALLTABS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILEVIEWBY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_profileviewbyGID']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILEVIEWBY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TEMPLATEDIR ?></td>
         <td align="left" valign="top"><?php echo $lists['templatedir']; ?></td>
         <td align="left" valign="top"><?php echo _UE_TEMPLATEDIR_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_NESTTABS ?></td>
         <td align="left" valign="top"><?php echo $lists['nesttabs']; ?></td>
         <td align="left" valign="top"><?php echo _UE_NESTTABS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
//echo $tabs->endTab();
echo $pane->endPanel();

$imgToolBox = new imgToolBox();
$imageLibs = $imgToolBox->getImageLibs();

echo $pane->startPanel(_UE_AVATARS,"tab5");
//echo $tabs->startTab("CB",_UE_AVATARS,"tab5");
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
			<input type="text" name="cfg_im_path" value="<?php echo (array_key_exists('imagemagick',$imageLibs)) ? 'auto' : $ueConfig['im_path'];?>" size="20" >
		</td>
		<td align="left" valign="top">
			<?php echo _UE_IMPATH_DESC;?>
		</td>
	</tr>
	 <tr align="center" valign="middle">
		<td align="left" valign="top"><?php echo _UE_NETPBMPATH;?></td>
		<td align="left" valign="top">
			<input type="text" name="cfg_netpbm_path" value="<?php echo (array_key_exists('netpbm',$imageLibs)) ? 'auto' : $ueConfig['netpbm_path'];?>" size="20" >
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
			<?php if(array_key_exists('imagemagick',$imageLibs)) echo '<strong><font color="green">'._UE_AUTODET.' '.$imageLibs['imagemagick'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</strong></font>'; ?>
			<br />
		<a href="http://sourceforge.net/projects/netpbm" target=_blank>NetPBM</a>&nbsp;&nbsp;
			<?php if(array_key_exists('netpbm',$imageLibs)) echo '<strong><font color="green">'._UE_AUTODET.' '.$imageLibs['netpbm'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</strong></font>'; ?>
			<br />
		GD1 library 
			<?php if(array_key_exists('gd1',$imageLibs['gd'])) echo '&nbsp;&nbsp;<strong><font color="green">'._UE_AUTODET.' '.$imageLibs['gd']['gd1'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</strong></font>'; ?>
			<br />
		GD2 library 
			<?php if(array_key_exists('gd2',$imageLibs['gd'])) echo '&nbsp;&nbsp;<strong><font color="green">'._UE_AUTODET.' '.$imageLibs['gd']['gd2'].'</font></strong>'; else echo '<strong><font color="red">' . _UE_ERROR_NOTINSTALLED . '</strong></font>'; ?>

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
         <td align="left" valign="top"><?php echo _UE_AVATAR_SHOW_RULES ?></td>
         <td align="left" valign="top"><?php echo $lists['showAvatarRules']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATAR_SHOW_RULES_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATAR_SHOW_RULES_URL ?></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_showAvatarRules_url" value="<?php echo $ueConfig['showAvatarRules_url']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_AVATAR_SHOW_RULES_URL_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARUPLOADONREG ?></td>
         <td align="left" valign="center"><?php echo $lists['allowAvatarUploadOnReg']; ?></td>
         <td align="left" valign="center"><?php echo _UE_AVATARUPLOADONREG_DESC ?></td>
      </tr>      

      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARGALLERY ?></td>
         <td align="left" valign="top"><?php echo $lists['allowAvatarGallery']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARGALLERY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARGALLERY_ROWS ?></td>
         <td align="left" valign="top"><?php echo $lists['rows_of_gallery']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARGALLERY_ROWS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVATARDELETE_JS ?></td>
         <td align="left" valign="top"><?php echo $lists['avatardeljs']; ?></td>
         <td align="left" valign="top"><?php echo _UE_AVATARDELETE_JS_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVHEIGHT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_avatarHeight" value="<?php echo $ueConfig['avatarHeight'];?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVWIDTH ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_avatarWidth" value="<?php echo $ueConfig['avatarWidth'];?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_AVSIZE ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_avatarSize" value="<?php echo $ueConfig['avatarSize'];?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TNHEIGHT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_thumbHeight" value="<?php echo $ueConfig['thumbHeight'];?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TNWIDTH ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_thumbWidth" value="<?php echo $ueConfig['thumbWidth'];?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
//echo $tabs->endTab();
echo $pane->endPanel();
//sv0.6233
	// toolBox init at avatar tab
	$basicCheckOK = $imgToolBox->testWMbasic();
	if ($basicCheckOK) {
		$basicOut = "<font color='green'>"._UE_YES."</font>";
	} else {
		$basicOut = "<font color='green'>"._UE_NO."</font>";
	}
	//
echo $pane->startPanel(_UE_WATERMARKS,"tab6");
//echo $tabs->startTab("CB",_UE_WATERMARKS,"tab6");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><center><?php echo _UE_WATERMARKS_NOTE ?></center></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_BASICS ?></td>
         <td align="left" valign="top"><?php echo $basicOut ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_BASICS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_FORCEPNG ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_force_png']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_FORCEPNG_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_FORCEZOOM ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_force_zoom']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_FORCEZOOM_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_CANVAS ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_canvas']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_CANVAS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php // echo _UE_WM_CANVAS_TRANS ?></td>
         <td align="left" valign="top"><?php // echo $lists['wm_canvas_trans']; ?></td>
         <td align="left" valign="top"><?php // echo _UE_WM_CANVAS_TRANS_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_CANVAS_COLOR ?></td>
                  <td align="left" valign="top"><input type="text" size="10" maxlength="6" name="cfg_wm_canvas_color" value="<?php echo $ueConfig['wm_canvas_color'];?>" /></td>
         <td align="left" valign="top">
         <?php
         
         // Original script
         $counter = 0;
         $colortable = "<table>";
	for ($x=1;$x<=6;$x++){ 
	   $varx = dechex(51*($x-1)); 
	   if ($varx == "0"){$varx = "00";} 
	   for ($y=1;$y<=6;$y++){ 
	      $vary = dechex(51*($y-1)); 
	      if ($vary == "0"){$vary = "00";} 
	      for ($z=1;$z<=6;$z++){ 
	         $varz = dechex(51*($z-1)); 
	         if ($varz == "0"){$varz = "00";} 
	         $color = "".$varx.$vary.$varz; 
	         $counter++; 
	         if ($counter == 1){$colortable.= "<tr height = \"15\">";} 
	         $colortable .= "<td bgcolor = \"$color\" width = \"10\"\" style = \"cursor: hand\" onclick = \"adminForm.cfg_wm_canvas_color.value='$color'\"></td>"; 
	         if($counter == 18){$counter = 0;$colortable.= "</tr>";} 
	      } 
	   } 
	} 
	// Added lines below (courtesy of Jeremie B.)
	for ($x=1;$x<=6;$x++){ 
	   $varx = dechex(51*($x-1)); 
	   if ($varx == "0"){$varx = "00";} 
	   $color = "".$varx.$varx.$varx; 
	   $counter++; 
	   if ($counter == 1){$colortable.= "<tr height = \"15\">";} 
	   $colortable .= "<td bgcolor = \"$color\" colspan=\"3\" width = \"30\"\" style = \"cursor: hand\" onclick = \"adminForm.cfg_wm_canvas_color.value='$color'\"></td>"; 
	   if($counter == 18){$counter = 0;$colortable.= "</tr>";} 
	} 
	$colortable .= "</table>";
	
	echo $colortable;
	echo _UE_WM_CANVAS_COLOR_DESC ?>
	</td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_DOIT ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_doit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_DOIT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_FILENAME ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_filename']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_FILENAME_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_STAMPIT ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_stampit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_STAMPIT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_STAMPIT_TEXT ?></td>
         <td align="left" valign="top" colspan="2"><input type="text" size="60" maxlength="59" name="cfg_wm_stampit_text" value="<?php echo $ueConfig['wm_stampit_text'];?>" /></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_STAMPIT_SIZE ?></td>
         <td align="left" valign="top"><?php echo $lists['wm_stampit_size']; ?></td>
         <td align="left" valign="top"><?php echo _UE_WM_STAMPIT_SIZE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_WM_STAMPIT_COLOR ?></td>
                  <td align="left" valign="top"><input type="text" size="10" maxlength="6" name="cfg_wm_stampit_color" value="<?php echo $ueConfig['wm_stampit_color'];?>" /></td>
         <td align="left" valign="top">
         <?php
         
         // Original script
         $counter = 0;
         $colortable = "<table>";
	for ($x=1;$x<=6;$x++){ 
	   $varx = dechex(51*($x-1)); 
	   if ($varx == "0"){$varx = "00";} 
	   for ($y=1;$y<=6;$y++){ 
	      $vary = dechex(51*($y-1)); 
	      if ($vary == "0"){$vary = "00";} 
	      for ($z=1;$z<=6;$z++){ 
	         $varz = dechex(51*($z-1)); 
	         if ($varz == "0"){$varz = "00";} 
	         $color = "".$varx.$vary.$varz; 
	         $counter++; 
	         if ($counter == 1){$colortable.= "<tr height = \"15\">";} 
	         $colortable .= "<td bgcolor = \"$color\" width = \"10\"\" style = \"cursor: hand\" onclick = \"adminForm.cfg_wm_stampit_color.value='$color'\"></td>"; 
	         if($counter == 18){$counter = 0;$colortable.= "</tr>";} 
	      } 
	   } 
	} 
	// Added lines below (courtesy of Jeremie B.)
	for ($x=1;$x<=6;$x++){ 
	   $varx = dechex(51*($x-1)); 
	   if ($varx == "0"){$varx = "00";} 
	   $color = "".$varx.$varx.$varx; 
	   $counter++; 
	   if ($counter == 1){$colortable.= "<tr height = \"15\">";} 
	   $colortable .= "<td bgcolor = \"$color\" colspan=\"3\" width = \"30\"\" style = \"cursor: hand\" onclick = \"adminForm.cfg_wm_stampit_color.value='$color'\"></td>"; 
	   if($counter == 18){$counter = 0;$colortable.= "</tr>";} 
	} 
	$colortable .= "</table>";
	
	echo $colortable;
	echo _UE_WM_STAMPIT_COLOR_DESC ?>
	</td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
         </tr>

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
//echo $tabs->endTab();
echo $pane->endPanel();
echo $pane->startPanel(_UE_MODERATE,"tab7");
//echo $tabs->startTab("CB",_UE_MODERATE,"tab7");
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
         <td align="left" valign="top"><?php echo _UE_ALLOWUSERPROFILEBANNING ?></td>
         <td align="left" valign="top"><?php echo $lists['allowUserBanning']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOWUSERPROFILEBANNING_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SENDMAIL_ON_PROFILE_UPDATE ?></td>
         <td align="left" valign="top"><?php echo $lists['sendMailonProfileUpdate']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SENDMAIL_ON_PROFILE_UPDATE_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_INTEGRATION,"tab8");
//echo $tabs->endTab();
//echo $tabs->startTab("CB",_UE_INTEGRATION,"tab8");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="95%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PMS ?></td>
         <td align="left" valign="top"><?php echo $lists['pms']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PMS_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GALLERY ?></td>
         <td align="left" valign="top"><?php echo $lists['use_cbe_gallery']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GALLERY_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ACCTEXP ?></td>
         <td align="left" valign="top"><?php echo $lists['use_acctexp']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ACCTEXP_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><?php echo _UE_ACCTEXP_NOTE ?></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top">
<?php
	$acctexp_installed = "<font color='red'>"._UE_NO."</font>";
	$acctexp_version = 0;
	$acctexp_xml = JPATH_SITE.'/administrator/components/com_acctexp/acctexp.xml';
	if (file_exists($acctexp_xml)) {
		$acctexp_installed = "<font color='green'>"._UE_YES."</font>";
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $acctexp_xml, false, true )) {
			$acctexp_version = "error";
			$acctexp_version_cbe = "0";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$acctexp_version = $element ? $element->getText() : '';
			$acctexp_version_cbe = str_replace(".","_",$acctexp_version);
		}
	}
	echo _UE_ACCTEXP_INSTALLED."</td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo $acctexp_installed."</b></td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo "Version: ".$acctexp_version."</b>";
	echo "<input type=\"hidden\" name=\"cfg_use_acctexp_version\" value=\"".$acctexp_version_cbe."\" />";
?>
         </td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SECIMAGES; ?></td>
         <td align="left" valign="top"><?php echo $lists['use_secimages']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SECIMAGES_DESC; ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SECIMAGES_LOSTPASS; ?></td>
         <td align="left" valign="top"><?php echo $lists['use_secimages_lostpass']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SECIMAGES_LOSTPASS_DESC; ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SECIMAGES_CBE_LOGIN; ?></td>
         <td align="left" valign="top"><?php echo $lists['use_secimages_login']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SECIMAGES_CBE_LOGIN_DESC; ?></td>
	</tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><?php echo _UE_SECIMAGES_NOTE; ?></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top">
<?php
	$secimages_installed = "<font color='red'>"._UE_NO."</font>";
	$secimages_version = 0;
	$secimages_xml = JPATH_SITE.'/administrator/components/com_securityimages/securityimages.xml';
	if (file_exists($secimages_xml)) {
		$secimages_installed = "<font color='green'>"._UE_YES."</font>";
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $secimages_xml, false, true )) {
			$secimages_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$secimages_version = $element ? $element->getText() : '';
		}
	}
	echo _UE_SECIMAGES_INSTALLED."</td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo $secimages_installed."</b></td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo "Version: ".$secimages_version."</b>";
?>
         </td>
	</tr>	
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SMFBRIDGE ?></td>
         <td align="left" valign="top"><?php echo $lists['use_smfBridge']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SMFBRIDGE_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><?php echo _UE_SMFBRIDGE_NOTE ?></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top">
<?php
	$SMF_installed = "<font color='red'>"._UE_NO."</font>";
	$SMF_version = 0;
	$SMF_xml = JPATH_SITE.'/administrator/components/com_smf/smf.xml';
	if (file_exists($SMF_xml)) {
		$SMF_installed = "<font color='green'>"._UE_YES."</font>";
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $SMF_xml, false, true )) {
			$SMF_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$SMF_version = $element ? $element->getText() : '';
		}
	}
	echo _UE_SMFBRIDGE_INSTALLED."</td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo $SMF_installed."</b></td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo "Version: ".$SMF_version."</b>";
?>
         </td>
	</tr>	
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_FQMULTI ?></td>
         <td align="left" valign="top"><?php echo $lists['use_fqmulticorreos']; ?></td>
         <td align="left" valign="top"><?php echo _UE_FQMULTI_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><?php echo _UE_FQMULTI_NOTE ?></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top">
<?php
	$FQM_installed = "<font color='red'>"._UE_NO."</font>";
	$FQM_version = 0;
	$FQM_xml = JPATH_SITE.'/administrator/components/com_fq/fq.xml';
	if (file_exists($FQM_xml)) {
		$FQM_installed = "<font color='green'>"._UE_YES."</font>";
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $FQM_xml, false, true )) {
			$FQM_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$FQM_version = $element ? $element->getText() : '';
		}
	}
	echo _UE_FQMULTI_INSTALLED."</td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo $FQM_installed."</b></td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo "Version: ".$FQM_version."</b>";
?>
         </td>
	</tr>	
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><hr></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_YANC ?></td>
         <td align="left" valign="top"><?php echo $lists['use_yanc']; ?></td>
         <td align="left" valign="top"><?php echo _UE_YANC_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><?php echo _UE_YANC_NOTE ?></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top">
<?php
	$YANC_installed = "<font color='red'>"._UE_NO."</font>";
	$YANC_version = 0;
	$YANC_xml = JPATH_SITE.'/administrator/components/com_yanc/yanc.xml';
	if (file_exists($YANC_xml)) {
		$YANC_installed = "<font color='green'>"._UE_YES."</font>";
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $YANC_xml, false, true )) {
			$YANC_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$YANC_version = $element ? $element->getText() : '';
		}
	}
	echo _UE_YANC_INSTALLED."</td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo $YANC_installed."</b></td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo "Version: ".$YANC_version."</b>";
?>
         </td>
	</tr>	

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>

<?php
echo $pane->endPanel();
echo $pane->endPane();
//echo $tabs->endTab();
//echo $tabs->endPane();

/*
$CBE_xml = JPATH_SITE.'/administrator/components/com_cbe/cbe.xml';
if (file_exists($CBE_xml)) {
	
	$xmlDoc =& new DOMIT_Lite_Document();
	$xmlDoc->resolveErrors( true );
	if (!$xmlDoc->loadXML( $CBE_xml, false, true )) {
		$CBE_version = "error";
	} else {
		$element = &$xmlDoc->documentElement;
		$element = &$xmlDoc->getElementsByPath('version', 1);
		$CBE_version = $element ? $element->getText() : '';
	}
	$ueConfig['version'] = $CBE_version;
} else {
	$CBE_version = "error reading cbe.xml";
}*/

?>
</td></tr></table>
   <input type="hidden" name="task" value="" />
   <input type="hidden" name="option" value="<?php echo $option; ?>" />
   </form>

<?php
}

function enhancedConfig( &$enhanced_Config, &$lists, $option )
{
	global $version;
	require_once( JPATH_SITE . '/includes/domit/xml_domit_lite_include.php' );
	jimport('joomla.html.pane');

	?>

	<table cellpadding="4" cellspacing="0" border="0" width="95%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/systeminfo.png" align="middle">Enhanced Configuration Manager</td>
		</tr>
	</table>
   <form action="index2.php" method="post" name="adminForm">
   <input type="hidden" name="cfg_version" value="<?php echo $enhanced_Config['version']; ?>" />
   <table cellspacing='0' cellpadding='4' border='0' width='100%'><tr><td width='100%'>
<?php
//$tabs = new cbTabs( 0,2,"luna" );
$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 

?>
<?php
echo $pane->startPane("Enhanced");
echo $pane->startPanel(_UE_PROFILE_GUESTBOOK_TAB_GUESTBOOK,"tab1");
//echo $tabs->startPane( "Enhanced" );
//echo $tabs->startTab("Enhanced",_UE_PROFILE_GUESTBOOK_TAB_GUESTBOOK,"tab1");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>

	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_AUTO ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_auto_publish']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_AUTO_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_ALLOW_ANON ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_allow_anon']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_ALLOW_ANON_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_PMS_NOTIFY ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_use_pms_notify']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_PMS_NOTIFY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_BBC ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_use_bbc_code']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_BBC_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_EMOTICONS ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_use_emoticons']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_EMOTICONS_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_RATING ?></td>
         <td align="left" valign="top"><?php echo $lists['use_guestbook_rating']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_RATING_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_AVATAR ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_show_avatar']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_AVATAR_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_MAILLINK ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_gbdirectmail']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_MAILLINK_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_ANSWERLINK ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_gbdirectanswer']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ANSWERLINK_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_LANGUAGE_FILTER ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_use_language_filter']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_LANGUAGE_FILTER_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ENTRY_LIMIT_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_entries_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ENTRY_LIMIT_PER_PAGE_DESC ?></td>
	</tr>	
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_WORD_LIMIT ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_set_word_limit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_WORD_LIMIT_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ALLOW_SIGN_OWN ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_allow_sign_own']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ALLOW_SIGN_OWN_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_ENTRY_LIMIT ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_use_entry_limit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_ENTRY_LIMIT_DESC ?></td>
	</tr>
	  <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ENTRY_LIMIT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_guestbook_entry_limit" value="<?php echo $enhanced_Config['guestbook_entry_limit']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_ENTRY_LIMIT_DESC ?></td>
      </tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_WORDWRAP ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_usewordwrap']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_WORDWRAP_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_WORDWRAP_LIMIT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_guestbook_usewordwrap_limit" value="<?php echo $enhanced_Config['cfg_guestbook_usewordwrap_limit']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TAB_USE_WORDWRAP_LIMIT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TIMEFORMAT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_guestbook_timeformat" value="<?php echo $enhanced_Config['guestbook_timeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_TIMEFORMAT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_USELOCALE ?></td>
         <td align="left" valign="top"><?php echo $lists['guestbook_uselocale']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_USELOCALE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_LOCALEFORMAT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_guestbook_localeformat" value="<?php echo $enhanced_Config['guestbook_localeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_LOCALEFORMAT_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_PROFILE_COMMENTS_TAB_COMMENTS,"tab2");
//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_PROFILE_COMMENTS_TAB_COMMENTS,"tab2");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>

	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_ALLOW_SIGN_OWN ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_allow_sign_own']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_ALLOW_SIGN_OWN_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_AUTO ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_auto_publish']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_AUTO_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_BBC ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_use_bbc_code']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_BBC_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_EMOTICONS ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_use_emoticons']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_EMOTICONS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_AVATAR ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_show_avatar']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_AVATAR_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_LANGUAGE_FILTER ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_use_language_filter']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_USE_LANGUAGE_FILTER_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_ENTRY_LIMIT_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_entries_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_ENTRY_LIMIT_PER_PAGE_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_WORD_LIMIT ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_set_word_limit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TAB_WORD_LIMIT_DESC ?></td>
	</tr>
         <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TIMEFORMAT ?></td>
         <?php if ($enhanced_Config['comment_timeformat']=='') $enhanced_Config['comment_timeformat']="jS F Y H:i:s"; ?>
         <td align="left" valign="top"><input type="text" name="cfg_comment_timeformat" value="<?php echo $enhanced_Config['comment_timeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_TIMEFORMAT_DESC ?></td>
      </tr>
        <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_USELOCALE ?></td>
         <td align="left" valign="top"><?php echo $lists['comment_uselocale']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_USELOCALE_DESC ?></td>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_LOCALEFORMAT ?></td>
         <?php if ($enhanced_Config['comment_localeformat']=='') $enhanced_Config['comment_localeformat']="%d %B %G %T"; ?>
         <td align="left" valign="top"><input type="text" name="cfg_comment_localeformat" value="<?php echo $enhanced_Config['comment_localeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COMMENTS_LOCALEFORMAT_DESC ?></td>
      </tr>

     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_USE_TESTIMONIALS_TESTIMONIALS,"tab3");
//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_USE_TESTIMONIALS_TESTIMONIALS,"tab3");
?>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_PMS ?></td>
         <td align="left" valign="top"><?php echo $lists['use_pms_testimonial']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_PMS_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_TESTIMONIALS_TAB_ENTRY_LIMIT_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['testimonial_entries_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_TESTIMONIALS_TAB_ENTRY_LIMIT_PER_PAGE_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_WORD_LIMIT ?></td>
         <td align="left" valign="top"><?php echo $lists['testimonial_set_word_limit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_WORD_LIMIT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_LANGUAGE_FILTER ?></td>
         <td align="left" valign="top"><?php echo $lists['testimonials_use_language_filter']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_LANGUAGE_FILTER_DESC ?></td>
	</tr>
      	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
       <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_TIMEFORMAT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_testimonials_timeformat" value="<?php echo $enhanced_Config['testimonials_timeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_TIMEFORMAT_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_USELOCALE ?></td>
         <td align="left" valign="top"><?php echo $lists['testimonials_uselocale']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_USELOCALE_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_LOCALEFORMAT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_testimonials_localeformat" value="<?php echo $enhanced_Config['testimonials_localeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USE_TESTIMONIALS_LOCALEFORMAT_DESC ?></td>
      </tr>
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_ZOOM_IMAGE_GALLERY_TAB,"tab4");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_ZOOM_IMAGE_GALLERY_TAB,"tab4");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ZOOM_VERSION ?></td>
         <td align="left" valign="top"><?php echo $lists['zoomversion']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ZOOM_VERSION_DESC ?></td>
  <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SET_ZOOM_SIZE ?></td>
<td align="left" valign="top"><?php echo $lists['setzoomsize']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SET_ZOOM_SIZE_DESC ?></td>
      </tr>
  <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ZOOM_IMAGE_WIDTH ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_zoomimagewidth" value="<?php echo $enhanced_Config['zoomimagewidth']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_ZOOM_IMAGE_WIDTH_DESC ?></td>
      </tr>
 <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ZOOM_IMAGE_HEIGHT ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_zoomimageheight" value="<?php echo $enhanced_Config['zoomimageheight']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_ZOOM_IMAGE_HEIGHT_DESC ?></td>
      </tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_NUMBER_OF_PHOTOS ?></td>
         <td align="left" valign="top"><?php echo $lists['show_photos_number']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_NUMBER_OF_PHOTOS_DESC ?></td>
	</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_NUMBER_OF_MP3 ?></td>
         <td align="left" valign="top"><?php echo $lists['show_mp3_number']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_NUMBER_OF_MP3_DESC ?></td>
	</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_WITHOUT_MP3 ?></td>
         <td align="left" valign="top"><?php echo $lists['use_zoom_mp3_filter']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_WITHOUT_MP3_DESC ?></td>
	</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_IMAGE_HITS ?></td>
         <td align="left" valign="top"><?php echo $lists['showzoomimagehits']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_IMAGE_HITS_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_IMAGE_RATING ?></td>
         <td align="left" valign="top"><?php echo $lists['showzoomimagerating']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_ZOOM_IMAGE_RATING_DESC ?></td>
</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>   
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_LIMITER ?></td>
         <td align="left" valign="top"><?php echo $lists['use_zoom_limiter']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_LIMITER_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_KEYWORD ?></td>
         <td align="left" valign="top"><?php echo $lists['use_zoom_keyword']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_KEYWORD_DESC ?></td>
</tr>
 <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_MAXNR ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_use_zoom_maxnr" value="<?php echo $enhanced_Config['use_zoom_maxnr']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_MAXNR_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_MP3_MAXNR ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_use_zoom_maxnr_mp3" value="<?php echo $enhanced_Config['use_zoom_maxnr_mp3']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_MP3_MAXNR_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_ORDER ?></td>
         <td align="left" valign="top"><?php echo $lists['zoom_orderMethod']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_ORDER_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_ORDER_MP3 ?></td>
         <td align="left" valign="top"><?php echo $lists['zoom_orderMethod_mp3']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_ORDER_MP3_DESC ?></td>
</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>   
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_FULL_LINK ?></td>
         <td align="left" valign="top"><?php echo $lists['zoom_full_link']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_FULL_LINK_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_FULL_LINK_MP3 ?></td>
         <td align="left" valign="top"><?php echo $lists['zoom_full_link_mp3']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_FULL_LINK_MP3_DESC ?></td>
</tr>
<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_POPUP ?></td>
         <td align="left" valign="top"><?php echo $lists['zoom_popupopen']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_ZOOM_POPUP_DESC ?></td>
</tr>
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_SIMPLEBOARD_FORUM_TAB,"tab5");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_SIMPLEBOARD_FORUM_TAB,"tab5");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th align="center" colspan="3"><center><?php echo _UE_SBJB_FORUM; ?></center></th>
      </tr>	
	<tr align="center" valign="middle">
	 <td align="center" valign="middle" colspan="3"><center><b><?php echo _UE_SBJB_FORUM_DESC; ?></b></center></td>
	</tr>
	<tr align="center" valign="middle">
	 <td align="center" valign="middle" colspan="3"><hr></td>
	<tr>
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>	
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_USE_FB ?></td>
         <td align="left" valign="top"><?php echo $lists['sb_use_fb']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_USE_FB_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr> 
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_KARMA ?></td>
         <td align="left" valign="top"><?php echo $lists['show_forum_karma']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_KARMA_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_RANKING ?></td>
         <td align="left" valign="top"><?php echo $lists['show_forum_ranking']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_RANKING_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_POST_NUMBER ?></td>
         <td align="left" valign="top"><?php echo $lists['show_forum_post_number']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_POST_NUMBER_DESC ?></td>
	</tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SB_FORUM_TAB_POSTS_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['sb_forum_posts_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SB_FORUM_TAB_POSTS_PER_PAGE_DESC ?></td>
	</tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_USEGID ?></td>
         <td align="left" valign="top"><?php echo $lists['sb_forum_chkgid']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_FORUM_USEGID_DESC ?></td>
	</tr>

     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_BUDDY_TAB_ADMIN,"tab6");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_BUDDY_TAB_ADMIN,"tab6");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_ADD_DEL_BUD_LINK ?></td>
         <td align="left" valign="top"><?php echo $lists['show_add_del_bud_link']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_ADD_DEL_BUD_LINK_DESC ?></td>
	</tr>

	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PM_BUDDY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_pmbuddy']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PM_BUDDY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_ONLINE_BUDDY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_onlinebuddy']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_ONLINE_BUDDY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_GUESTBOOK_BUDDY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_guestbookbuddy']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_GUESTBOOK_BUDDY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_BUDDY_SENDER ?></td>
         <td align="left" valign="top"><?php echo $lists['buddylist_sender']; ?></td>
         <td align="left" valign="top"><?php echo _UE_BUDDY_SENDER_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_BUDDY_USE_PMS_NOTIFY ?></td>
         <td align="left" valign="top"><?php echo $lists['buddylist_use_pms_notify']; ?></td>
         <td align="left" valign="top"><?php echo _UE_BUDDY_USE_PMS_NOTIFY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_BUDDY_TAB_BUDDIES_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['buddy_entries_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_BUDDY_TAB_BUDDIES_PER_PAGE_DESC ?></td>
	</tr>
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_SEARCH_MANAGER,"tab7");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_SEARCH_MANAGER,"tab7");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_LISTVIEWBY ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_cbsearchviewbyGID']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_LISTVIEWBY_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_CBESEARCH_MODULE ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_cbesearch_module']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_CBESEARCH_MODULE_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SEARCHTAB1 ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_searchtab1" value="<?php echo $enhanced_Config['searchtab1']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_SEARCHTAB1_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SEARCHTAB2 ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_searchtab2" value="<?php echo $enhanced_Config['searchtab2']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_SEARCHTAB2_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SEARCHTAB_COLOR ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_searchtab_color" value="<?php echo $enhanced_Config['searchtab_color']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_SEARCHTAB_COLOR_DESC ?></td>
      </tr>
      	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SEARCH_MANAGER_SHOW_ADVANCED ?></td>
         <td align="left" valign="top"><?php echo $lists['show_advanced_search_tab']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SEARCH_MANAGER_SHOW_ADVANCED_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SEARCH_SHOW_DISTANCE ?></td>
         <td align="left" valign="top"><?php echo $lists['cbsearch_geo_dist']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SEARCH_SHOW_DISTANCE_DESC ?></td>
	</tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ONLINE_NOW_ONLY ?></td>
         <td align="left" valign="top"><?php echo $lists['onlinenow']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ONLINE_NOW_ONLY_DESC ?></td>
	</tr>
	
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PICTURE_ONLY ?></td>
         <td align="left" valign="top"><?php echo $lists['picture']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PICTURE_ONLY_DESC ?></td>
	</tr>
	
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ADDED_10_DAYS_OR_LESS ?></td>
         <td align="left" valign="top"><?php echo $lists['added10']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ADDED_10_DAYS_OR_LESS_DESC ?></td>
	</tr>
	
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ONLINE_10_DAYS_OR_LESS ?></td>
         <td align="left" valign="top"><?php echo $lists['online10']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ONLINE_10_DAYS_OR_LESS_DESC ?></td>
	</tr>

	<tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr>   
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SEARCH_AGE_COMMON_STYLE ?></td>
         <td align="left" valign="top"><?php echo $lists['search_age_common_style']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SEARCH_AGE_COMMON_STYLE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr>   
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILE_POPUP ?></td>
         <td align="left" valign="top"><?php echo $lists['cbs_allow_profile_popup']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PROFILE_POPUP_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_SM_USERLISTID ?></td>
         <td align="left" valign="top"><?php echo $lists['cbsearchlistid']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_SM_USERLISTID_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_SM_SEARCH_TIMEOUT ?></td>
         <td align="left" valign="top"><?php echo $lists['cbsearch_expire_time']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_SM_SEARCH_TIMEOUT_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS1 ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_cbsearch_css1" value="<?php echo $enhanced_Config['cbsearch_css1']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS1_DESC ?></td>
      </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS2 ?></td>
         <td align="left" valign="top"><input type="text" name="cfg_cbsearch_css2" value="<?php echo $enhanced_Config['cbsearch_css2']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_USERSLIST_CSS2_DESC ?></td>
      </tr>

      <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_MY_PROFILE_JOURNAL_TAB,"tab8");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_MY_PROFILE_JOURNAL_TAB,"tab8");
?>
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>	
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_MY_PROFILE_JOURNAL_TAB_WORD_LIMIT ?></td>
		 <td align="left" valign="top"><?php echo $lists['journal_set_word_limit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_MY_PROFILE_JOURNAL_TAB_WORD_LIMIT_DESC ?></td>
      </tr>
        <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_TAB_ENTRY_LIMIT_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['journal_entries_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_TAB_ENTRY_LIMIT_PER_PAGE_DESC ?></td>
	</tr>   
       <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
       <tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_TIMEFORMAT ?></td>
         <?php if ($enhanced_Config['journal_timeformat']=='') $enhanced_Config['journal_timeformat']="jS F Y H:i:s"; ?>
         <td align="left" valign="top"><input type="text" name="cfg_journal_timeformat" value="<?php echo $enhanced_Config['journal_timeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_TIMEFORMAT_DESC ?></td>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_USELOCALE ?></td>
         <td align="left" valign="top"><?php echo $lists['journal_uselocale']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_GUESTBOOK_USELOCALE_DESC ?></td>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_LOCALEFORMAT ?></td>
         <?php if ($enhanced_Config['journal_localeformat']=='') $enhanced_Config['journal_localeformat']="%d %B %G %T"; ?>
         <td align="left" valign="top"><input type="text" name="cfg_journal_localeformat" value="<?php echo $enhanced_Config['journal_localeformat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_JOURNAL_LOCALEFORMAT_DESC ?></td>
      </tr>

     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_AUTHORS_TAB,"tab9");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_AUTHORS_TAB,"tab9");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USE_AUTHOR_NOTIFY ?></td>
         <td align="left" valign="top"><?php echo $lists['author_subscribe']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USE_AUTHOR_NOTIFY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_PM_AUTHOR ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_pmauthor']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_PM_AUTHOR_DESC ?></td>
	</tr>	
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ALLOW_ONLINE_AUTHOR ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_onlineauthor']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ALLOW_ONLINE_AUTHOR_DESC ?></td>
	</tr>   
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_ARTICLES_TAB,"tab10");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_ARTICLES_TAB,"tab10");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_ARTICLES_TAB_ARTICLES_PER_PAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['articles_per_page']; ?></td>
         <td align="left" valign="top"><?php echo _UE_ARTICLES_TAB_ARTICLES_PER_PAGE_DESC ?></td>
	</tr>
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_COLORS_TAB_ADMIN_LABEL,"tab12");

//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_COLORS_TAB_ADMIN_LABEL,"tab12");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COLOR_ALLOW ?></td>
         <td align="left" valign="top"><?php echo $lists['profile_allow_colors']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COLOR_ALLOW_DESC ?></td>
	</tr>
		<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_COLOR_SET_DEFAULT ?></td>
         <td align="left" valign="top"><?php echo $lists['profile_color']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_COLOR_SET_DEFAULT_DESC ?></td>
	</tr>
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_PSPECIAL_TAB_ADMIN_LABEL,"tab13");
//echo $tabs->endTab();
// PK edit start
//echo $tabs->startTab("Enhanced",_UE_PSPECIAL_TAB_ADMIN_LABEL,"tab13");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_BY_NAME ?></td>
         <td align="left" valign="top"><?php echo $lists['profile_by_name']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_BY_NAME_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TOOLTIP_WZ ?></td>
         <td align="left" valign="top"><?php echo $lists['tooltip_wz']; ?></td>
         <td align="left" valign="top"><?php echo _UE_TOOLTIP_WZ_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PROFILE_LANGFILTER ?></td>
         <td align="left" valign="top"><?php echo $lists['profile_langFilterText']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PROFILE_LANGFILTER_DESC ?></td>
	</tr>

	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PIC2PIC_ALLOW ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_pic2pic']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PIC2PIC_ALLOW_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_PIC2PROFILE_ALLOW ?></td>
         <td align="left" valign="top"><?php echo $lists['allow_pic2profile']; ?></td>
         <td align="left" valign="top"><?php echo _UE_PIC2PROFILE_ALLOW_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOWAGE ?></td>
         <td align="center" valign="top"><?php echo $lists['allow_showage']; ?></td>
         <td align="center" valign="top"><?php echo _UE_SHOWAGE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"></td>
         <td align="center" valign="top" colspan="2"><?php echo _UE_SHOWAGE_NOTE1._UE_LASTVISITORS_TAB_ADMIN_LABEL._UE_SHOWAGE_NOTE2; ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOWZODIAC ?></td>
         <td align="center" valign="top"><?php echo $lists['show_zodiacs']; ?></td>
         <td align="center" valign="top"><?php echo _UE_SHOWZODIAC_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOWZODIAC_STATIC ?></td>
         <td align="center" valign="top"><?php echo $lists['show_zodiacs_static']; ?></td>
         <td align="center" valign="top"><?php echo _UE_SHOWZODIAC_STATIC_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOWZODIAC_CH ?></td>
         <td align="center" valign="top"><?php echo $lists['show_zodiacs_ch']; ?></td>
         <td align="center" valign="top"><?php echo _UE_SHOWZODIAC_CH_DESC ?></td>
	</tr>

	<tr align="center" valign="middle">
         <td align="center" valign="middle" colspan="3"><center><b><?php echo _UE_SHOWZODIAC_NOTE ?></b></center></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_UHP_ALLOW ?></td>
         <td align="center" valign="top"><?php echo $lists['uhp_integration']; ?></td>
         <td align="center" valign="top"><?php echo _UE_UHP_ALLOW_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_EASYPROFILELINK ?></td>
         <td align="center" valign="top"><?php echo $lists['show_easyProfileLink']; ?></td>
         <td align="center" valign="top"><?php echo _UE_SHOW_EASYPROFILELINK_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_FLATTEN_TABS ?></td>
         <td align="center" valign="top"><?php echo $lists['flatten_tabs']; ?></td>
         <td align="center" valign="top"><?php echo _UE_FLATTEN_TABS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="center" valign="middle" colspan="3"><center><b><?php echo _UE_FLATTEN_TABS_NOTE ?></b></center></td>
	</tr>

	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_FULL_EDITORFIELD ?></td>
         <td align="center" valign="top"><?php echo $lists['full_editorfield']; ?></td>
         <td align="center" valign="top"><?php echo _UE_FULL_EDITORFIELD_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_ALLOW ?></td>
         <td align="center" valign="top"><?php echo $lists['allow_rateit']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_ALLOW_DESC ?></td>
	</tr>

	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_FORM ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_form']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_FORM_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_SELF ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_self']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_SELF_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_GUEST ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_guest']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_GUEST_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_STARS ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_stars']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_STARS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_COUNT ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_count']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_COUNT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_PRECISION ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_precision']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_PRECISION_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_RESULT_ALLOW ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_result_allow']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_RESULT_ALLOW_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_DAYS ?></td>
         <td align="center" valign="top"><?php echo $lists['rateit_days']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_DAYS_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_MOD ?></td>
         <td align="center" valign="top"><?php echo $lists['allow_rateit_mod']; ?></td>
         <td align="center" valign="top"><?php echo _UE_RATEIT_MOD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="center" valign="middle" colspan="3"><center><?php echo _UE_RATEIT_MOD_TXT1."<br>"._UE_RATEIT_MOD_TXT2 ?></center></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_ICON_FULL ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_rateit_iconfull" value="<?php echo $enhanced_Config['rateit_iconfull']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_RATEIT_ICON_FULL_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_ICON_HALF ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_rateit_iconhalf" value="<?php echo $enhanced_Config['rateit_iconhalf']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_RATEIT_ICON_HALF_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="center" valign="middle" colspan="3"><center><?php echo _UE_RATEIT_MC_VALUE_DESC1."<br>"._UE_RATEIT_MC_VALUE_DESC2."<br>"._UE_RATEIT_MC_VALUE_DESC3 ?></center></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_M_VALUE ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_rateit_mvalue" value="<?php echo $enhanced_Config['rateit_mvalue']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_RATEIT_M_VALUE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_RATEIT_C_VALUE ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_rateit_cvalue" value="<?php echo $enhanced_Config['rateit_cvalue']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_RATEIT_C_VALUE_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_USEWORDWRAP_TXT ?></td>
         <td align="center" valign="top"><?php echo $lists['profile_txt_wordwrap']; ?></td>
         <td align="left" valign="top"><?php echo _UE_USEWORDWRAP_TXT_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>

     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;</th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_LASTVISITORS_TAB_ADMIN_LABEL,"tab14");
//echo $tabs->endTab();
//echo $tabs->startTab("Enhanced",_UE_LASTVISITORS_TAB_ADMIN_LABEL,"tab14");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_COUNT ?></td>
         <td align="left" valign="top"><?php echo $lists['visitorcount']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_COUNT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_DATE ?></td>
         <td align="left" valign="top"><?php echo $lists['visitortime']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_DATE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_GENDER ?></td>
         <td align="left" valign="top"><?php echo $lists['visitorgender']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_GENDER_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOWSELF ?></td>
         <td align="left" valign="top"><?php echo $lists['visitorself']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOWSELF_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_OWNERONLY ?></td>
         <td align="left" valign="top"><?php echo $lists['visitorowner']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_OWNERONLY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOWONLINE ?></td>
         <td align="left" valign="top"><?php echo $lists['visitoronline']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOWONLINE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOWAGE ?></td>
         <td align="left" valign="top"><?php echo $lists['visitorage']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOWAGE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_BIRTHDAYFIELD ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_birthday_field" value="<?php echo $enhanced_Config['lastvisitors_birthday_field']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_BIRTHDAYFIELD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_GENDERFIELD ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_gender_field" value="<?php echo $enhanced_Config['lastvisitors_gender_field']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_GENDERFIELD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_DATESTRING ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_datestring" value="<?php echo $enhanced_Config['lastvisitors_datestring']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_DATESTRING_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_VISITCOUNT ?></td>
         <td align="left" valign="top"><?php echo $lists['visitor_showvisitcount']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_VISITCOUNT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_VISITEDTAB ?></td>
         <td align="left" valign="top"><?php echo $lists['visitor_showvisitedtab']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_VISITEDTAB_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_HEADERS ?></td>
         <td align="left" valign="top"><?php echo $lists['visitor_showtitlerow']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_HEADERS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_USERFIELD ?></td>
         <td align="left" valign="top"><?php echo $lists['visitor_showuserfield']; ?></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_SHOW_USERFIELD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_USERFIELD ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_userfield" value="<?php echo $enhanced_Config['lastvisitors_userfield']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_USERFIELD_DESC ?></td>
	</tr>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="center" valign="middle" colspan="3"><?php echo _UE_LASTVISITORS_GENDERFIELDS_DESC ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"></td>
         <td align="center" valign="middle"><?php echo _UE_LASTVISITORS_GENDER ?></td>
         <td align="center" valign="middle"><?php echo _UE_LASTVISITORS_IMAGEPATH ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_FEMALE ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_female" value="<?php echo $enhanced_Config['lastvisitors_female']; ?>" /></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_femaleimage" value="<?php echo $enhanced_Config['lastvisitors_femaleimage']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_MALE ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_male" value="<?php echo $enhanced_Config['lastvisitors_male']; ?>" /></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_maleimage" value="<?php echo $enhanced_Config['lastvisitors_maleimage']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_COUPLE1 ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_couple1" value="<?php echo $enhanced_Config['lastvisitors_couple1']; ?>" /></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_couple1image" value="<?php echo $enhanced_Config['lastvisitors_couple1image']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_COUPLE2 ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_couple2" value="<?php echo $enhanced_Config['lastvisitors_couple2']; ?>" /></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_couple2image" value="<?php echo $enhanced_Config['lastvisitors_couple2image']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_COUPLE3 ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_lastvisitors_couple3" value="<?php echo $enhanced_Config['lastvisitors_couple3']; ?>" /></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_couple3image" value="<?php echo $enhanced_Config['lastvisitors_couple3image']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"></td>
         <td align="center" valign="middle" colspan="2"><?php echo _UE_LASTVISITORS_NEUTRAL_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_NEUTRAL ?></td>
         <td align="left" valign="top"></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_neutralimage" value="<?php echo $enhanced_Config['lastvisitors_neutralimage']; ?>" /></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="center" valign="middle" colspan="3"><?php echo _UE_LASTVISITORS_ONLINEOFFLINE ?></td>
	</tr>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	 </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_ONLINE ?></td>
         <td align="left" valign="top"></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_onlineimage" value="<?php echo $enhanced_Config['lastvisitors_onlineimage']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_LASTVISITORS_OFFLINE ?></td>
         <td align="left" valign="top"></td>
         <td align="left" valign="top"><input type="text" size="20" name="cfg_lastvisitors_offlineimage" value="<?php echo $enhanced_Config['lastvisitors_offlineimage']; ?>" /></td>
	</tr>

     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;LastVisitors Tab by <a href="http://www.kolloczek.com/" target="_new">Philipp Kolloczek</a></th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_PROFILE_GROUPJIVE_TAB_ADMIN_LABEL,"tab15");
//echo $tabs->endTab();
// GroupJive
//echo $tabs->startTab("Enhanced",_UE_PROFILE_GROUPJIVE_TAB_ADMIN_LABEL,"tab15");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>

      <tr align="center" valign="middle">
         <td align="left" valign="top" colspan="3"><?php echo _UE_GROUPJIVE_NOTE ?></td>
         </tr>
      <tr align="center" valign="middle">
         <td align="left" valign="top">
<?php
	$groupjive_installed = "<font color='red'>"._UE_NO."</font>";
	$groupjive_version = 0;
	$groupjive_xml = JPATH_SITE.'/administrator/components/com_groupjive/groupjive.xml';
	if (file_exists($groupjive_xml)) {
		$groupjive_installed = "<font color='green'>"._UE_YES."</font>";
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $groupjive_xml, false, true )) {
			$groupjive_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$groupjive_version = $element ? $element->getText() : '';
		}
	}
	echo _UE_GROUPJIVE_INSTALLED."</td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo $groupjive_installed."</b></td>\n";
	echo "<td align=\"left\" valign=\"top\"><b>";
	echo "Version: ".$groupjive_version."</b>";
?>
	 <tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr/></td>
	 </tr>

	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_GJ_INTEGRATION ?></td>
         <td align="left" valign="top"><?php echo $lists['groupjive_integration']; ?></td>
         <td align="left" valign="top"><?php echo _UE_GJ_INTEGRATION_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_GJ_SHOW_OWNDED_GROUPS ?></td>
         <td align="left" valign="top"><?php echo $lists['show_gj_owned_groups']; ?></td>
         <td align="left" valign="top"><?php echo _UE_GJ_SHOW_OWNDED_GROUPS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_GJ_LINK_OWNED_GROUPS ?></td>
         <td align="left" valign="top"><?php echo $lists['link_gj_owned_groups']; ?></td>
         <td align="left" valign="top"><?php echo _UE_GJ_LINK_OWNED_GROUPS_DESC ?></td>
	</tr>
	 
     <tr align="center" valign="middle">
         <th colspan="3">&nbsp;<a href="www.groupjive.com" target="_new">GroupJive</a>-Switch Tab by <a href="http://www.kolloczek.com/" target="_new">Philipp Kolloczek</a></th>
      </tr>
   </table>
<?php
echo $pane->endPanel();
echo $pane->startPanel(_UE_PROFILE_STATS_TAB_ADMIN_LABEL,"tab16");

//echo $tabs->endTab();
// stats
//echo $tabs->startTab("Enhanced",_UE_PROFILE_STATS_TAB_ADMIN_LABEL,"tab16");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_PROFILE_HITS ?></td>
         <td align="left" valign="top"><?php echo $lists['show_profile_hits']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_PROFILE_HITS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_PROFILE_STATS ?></td>
         <td align="left" valign="top"><?php echo $lists['show_profile_stats']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_PROFILE_STATS_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_SHOW_CORE_USERTYPE ?></td>
         <td align="left" valign="top"><?php echo $lists['show_core_usertype']; ?></td>
         <td align="left" valign="top"><?php echo _UE_SHOW_CORE_USERTYPE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TPMA_ACTIVE ?></td>
         <td align="left" valign="top"><?php echo $lists['topMost_active']; ?></td>
         <td align="left" valign="top"><?php echo _UE_TPMA_ACTIVE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_TPMA_LIMIT ?></td>
         <td align="left" valign="top"><?php echo $lists['topMostLimit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_TPMA_LIMIT_DESC ?></td>
	</tr>

   </table>
<?php
echo $pane->endPanel();
//echo $tabs->endTab();
// PK edit END
// GeoCoder Backend Tab
echo $pane->startPanel(_UE_PROFILE_GEOCODER_TAB_ADMIN_LABEL,"tab17");
//echo $tabs->startTab("Enhanced",_UE_PROFILE_GEOCODER_TAB_ADMIN_LABEL,"tab17");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_GOOGLE_APIKEY ?></td>
         <td align="left" valign="top" colspan="2"><input type="text" size="80" name="cfg_geocoder_google_apikey" value="<?php echo $enhanced_Config['geocoder_google_apikey']; ?>" /></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top">&nbsp;</td>
         <td align="left" valign="top">&nbsp;</td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_GOOGLE_APIKEY_DESC ?></td>
	</tr>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_CODERMETHOD ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_geocode_byJS']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_CODERMETHOD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERAGREE ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_useragree_usage']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERAGREE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_LOCK_ADDR ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_lock_addr_on_success']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_LOCK_ADDR_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_SHOW_ACC ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_show_acc']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_SHOW_ACC_DESC ?></td>
	</tr>
<!--	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_SINGLE_ADDRFIELD ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_show_single_addrfield']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_SINGLE_ADDRFIELD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_ALLOW_DIRECTINPUT ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_allow_directinput']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_ALLOW_DIRECTINPUT_DESC ?></td>
	</tr>
-->	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_ALLOW_VISUALVERIFY ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_allow_visualverify']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_ALLOW_VISUALVERIFY_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_VISUALRELOCATE ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_allow_visualrelocate']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_VISUALRELOCATE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_VISUALRELOCATE_ONCLICK ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_allow_visualrelocate_onclick']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_VISUALRELOCATE_ONCLICK_DESC ?></td>
	</tr>
	</tr>
	<tr align="center" valign="middle">
          <td align="center" valign="middle" colspan="3"><hr></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USE_ADDRFIELD ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_use_addrfield']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USE_ADDRFIELD_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USE_ADDRFIELD_AUTO ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_use_addrfield_auto']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USE_ADDRFIELD_AUTO_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_STREET_DBNAME ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_street_dbname" value="<?php echo $enhanced_Config['geocoder_street_dbname']; ?>" /></td>
         <td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_POSTCODE_DBNAME ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_postcode_dbname" value="<?php echo $enhanced_Config['geocoder_postcode_dbname']; ?>" /></td>
         <td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_CITY_DBNAME ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_city_dbname" value="<?php echo $enhanced_Config['geocoder_city_dbname']; ?>" /></td>
         <td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_STATE_DBNAME ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_state_dbname" value="<?php echo $enhanced_Config['geocoder_state_dbname']; ?>" /></td>
         <td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_COUNTRY_DBNAME ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_country_dbname" value="<?php echo $enhanced_Config['geocoder_country_dbname']; ?>" /></td>
         <td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_DO_EXPORT ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_do_export']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_DO_EXPORT_DESC ?></td>
	</tr>
   </table>
<?php
echo $pane->endPanel();
//echo $tabs->endTab();
// PK edit END
// GeoCoder Backend Tab
echo $pane->startPanel(_UE_PROFILE_GEOCODER_USERMAP_ADMIN_LABEL,"tab18");
//echo $tabs->startTab("Enhanced",_UE_PROFILE_GEOCODER_USERMAP_ADMIN_LABEL,"tab18");
?>
   <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
      <tr align="center" valign="middle">
         <th width="20%">&nbsp;</th>
         <th width="20%"><?php echo _UE_CURRENT_SETTINGS ?></th>
         <th width="60%"><?php echo _UE_EXPLANATION ?></th>
      </tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_SHOW_USERMAP ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_show_usermap']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_SHOW_USERMAP_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
	<td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_ALLOW_VIEWBYGID ?></td>
	<td align="left" valign="top"><?php echo $lists['geocoder_allow_viewbyGID']; ?></td>
	<td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_ALLOW_VIEWBYGID_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_HEIGHT ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_usermap_height" value="<?php echo $enhanced_Config['geocoder_usermap_height']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_HEIGHT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_WIDE ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_usermap_width" value="<?php echo $enhanced_Config['geocoder_usermap_width']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_WIDE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_XML_UPDATE_INTERVAL ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_usermap_interval" value="<?php echo intval($enhanced_Config['geocoder_usermap_interval']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_XML_UPDATE_INTERVAL_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_SCANWIDE ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_scanwide" value="<?php echo intval($enhanced_Config['geocoder_usermap_scanwide']); ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_SCANWIDE_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCECENTER ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_usermap_force_center']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCECENTER_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCECENTER_LAT ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_usermap_center_lat" value="<?php echo $enhanced_Config['geocoder_usermap_center_lat']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCECENTER_LAT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCECENTER_LNG ?></td>
         <td align="left" valign="top"><input type="text" size="10" name="cfg_geocoder_usermap_center_lng" value="<?php echo $enhanced_Config['geocoder_usermap_center_lng']; ?>" /></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCECENTER_LNG_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_usermap_force_unsharp']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DIGIT ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_usermap_force_unsharp_digit']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DIGIT_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_SHOWSEARCH ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_usermap_showsearch']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_SHOWSEARCH_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_STARTZOOM ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_usermap_start_zoom']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_STARTZOOM_DESC ?></td>
	</tr>
	<tr align="center" valign="middle">
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_STARTTYPE ?></td>
         <td align="left" valign="top"><?php echo $lists['geocoder_usermap_start_type']; ?></td>
         <td align="left" valign="top"><?php echo _UE_CBE_GEOCODER_USERMAP_STARTTYPE_DESC ?></td>
	</tr>
   </table>
<?php
//echo $tabs->endTab();
echo $pane->endPanel();
echo $pane->endPane();
//echo $tabs->endPane();

	$CBE_xml = JPATH_SITE.'/administrator/components/com_cbe/cbe.xml';
	if (file_exists($CBE_xml)) {
		
		$xmlDoc =& new DOMIT_Lite_Document();
		$xmlDoc->resolveErrors( true );
		if (!$xmlDoc->loadXML( $CBE_xml, false, true )) {
			$CBE_version = "error";
		} else {
			$element = &$xmlDoc->documentElement;
			$element = &$xmlDoc->getElementsByPath('version', 1);
			$CBE_version = $element ? $element->getText() : '';
		}
		//$ueConfig['version'] = $CBE_version;
	} else {
		$CBE_version = "error reading cbe.xml";
	}

?>
</td></tr></table>
   <input type="hidden" name="task" value="" />
   <input type="hidden" name="option" value="<?php echo $option; ?>" />
   </form>

<?php

	echo "<font class=\"small\">"._UE_VERSION.": ".$CBE_version."</font>";
	echo "<br/>";
}

function showTools() {
global $mosConfig_lang;
		if (file_exists(JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/language/'.$mosConfig_lang.'.php')) {
			include(JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/language/'.$mosConfig_lang.'.php');
		} else {
			include(JPATH_SITE.'/administrator/components/com_cbe/enhanced_admin/language/english.php');
		}
   ?>
<table cellpadding="4" cellspacing="0" border="0" width="100%">
	<tr>
		<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/menu.png" align="middle"><?php echo _UE_TOOLS_MANAGER; ?></td>
	</tr>
</table>
	<form action="index2.php" method="post" name="adminForm">
	  <input type="hidden" name="option" value="com_cbe" />
	  <input type="hidden" name="task" value="showTools" />
	  <input type="hidden" name="boxchecked" value="0" />
	</form>

   <table width="90%" border="0" cellpadding="2" cellspacing="2" class="adminForm">
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=loadSampleData"><?php echo _UE_TOOLS_SAMPLEDATA; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_SAMPLEDATA_DESC; ?>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=syncUsers"><?php echo _UE_TOOLS_SYNCUSERS; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_SYNCUSERS_DESC; ?>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=showsyncUsersJoomla"><?php echo _UE_TOOLS_SYNCUSERS_JOOMLA_SHOW; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_SYNCUSERS_JOOMLA_SHOW_DESC; ?>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=syncUsersJoomla"><?php echo _UE_TOOLS_SYNCUSERS_JOOMLA; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_SYNCUSERS_JOOMLA_DESC; ?>
	</td>
      </tr>

      <?php
      if (file_exists('components/com_cbe/enhanced_admin/tools.php'))
      {
	?>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
	      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=syncSearchTable"><?php echo _UE_TOOLS_SYNCSEARCHTABLE; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_SYNCSEARCHTABLE_DESC; ?>
	</td>
	      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=reasignFields"><?php echo _UE_TOOLS_REASIGNFIELDS; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_REASIGNFIELDS_DEC; ?>
	</td>
      </tr>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
           <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=loadCountries"><?php echo _UE_TOOLS_LOADCOUNTRIES; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_LOADCOUNTRIES_DESC; ?>
	</td>
      </tr>      
          <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=loadUSstates"><?php echo _UE_TOOLS_LOADUSSTATES; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_LOADUSSTATES_DESC; ?>
	</td>
      </tr>
<tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=loadSimpleBoardSettings"><?php echo _UE_TOOLS_LOADSIMPLEBOARD; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_LOADSIMPLEBOARD_DESC; ?>
	</td>
      </tr>
      
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=loadProfileColors"><?php echo _UE_TOOLS_LOADPROFILE_COLOR; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_LOADPROFILE_COLOR_DESC; ?>
	</td>
      </tr>

      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=loadDEstates"><?php echo _UE_TOOLS_LOADGERMANSTATES; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_LOADGERMANSTATES_DESC; ?>
	</td>
      </tr>
<!-- // Outdated since sv0.621
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&func=createLastVisitors">Creates database field used by LastVisitors tab </a>
      	</td>
	<td>
		This will create the database field used by LastVisitorsTab.
	</td>
      </tr>
-->
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=clearLastVisitors"><?php echo _UE_TOOLS_CLEANLVTAB; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CLEANLVTAB_DESC; ?>
	</td>
      </tr>

      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=createTopVoteFields"><?php echo _UE_TOOLS_CREATETOPVOTE; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CREATETOPVOTE_DESC; ?>
	</td>
      </tr>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=createZodiacFields"><?php echo _UE_TOOLS_CREATEZODIACS; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CREATEZODIACS_DESC; ?>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=publishZodiacFields"><?php echo _UE_TOOLS_UNPUBLISHZODIACS; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_UNPUBLISHZODIACS_DESC; ?>
	</td>
      </tr>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=NewLastVisitor"><?php echo _UE_TOOLS_PREPARELVTAB; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_PREPARELVTAB_DESC; ?>
	</td>
      </tr>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=WatermarkAllAvatars"><?php echo _UE_TOOLS_DOWATERMARKALL; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_DOWATERMARKALL_DESC; ?>
	</td>
      </tr>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=GeocoderUserMapGen"><?php echo _UE_TOOLS_GEOCODER_GENXML; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_GEOCODER_GENXML_DESC; ?>
	</td>
      </tr>
      <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=GalleryCBEDB"><?php echo _UE_TOOLS_CBE_GALLERY; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CBE_GALLERY_DESC; ?>
	</td>
      </tr>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=GalleryCBEadm"><?php echo _UE_TOOLS_CBE_GALLERY_ADM; ?></a>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CBE_GALLERY_ADM_DESC; ?>
	</td>
      </tr>
	  <tr>
	<td colspan="2">
		<hr>
	</td>
      </tr>
            <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=backupDB"><?php echo _UE_TOOLS_CBE_BACKUPDB; ?></a>&nbsp;
      	</td>
	<td>
		<?php echo _UE_TOOLS_CBE_BACKUPDB_DESC; ?>
	</td>
      </tr>
<?php
					$database = JFactory::getDBO();
					$query = "SELECT value FROM #__cbe_config WHERE varname='backupdate' OR varname='version' ORDER BY varname ASC";
					$database->setQuery($query);
					$backup = $database->loadObjectlist();
?>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=backup"><?php echo _UE_TOOLS_CBE_BACKUP; ?></a>&nbsp;
<?php	if ($backup[0]->value) echo "<a href=\"index2.php?option=com_cbe&task=tools&func=restore\">". _UE_TOOLS_CBE_RESTORE ."</a>&nbsp"; ?>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CBE_BACKUPRESTORE_DESC; 
		if ($backup[0]->value) echo "<br />"._UE_BACKUPRESTORE_DATE."<strong><em>".$backup[0]->value." (Version: ".$backup[1]->value.")</em></strong>"; ?>
	</td>
      </tr>
<?php
					$query = "SELECT value FROM #__cbe_config_enh WHERE varname='backupdate' OR varname='version' ORDER BY varname ASC";
					$database->setQuery($query);
					$backupenh = $database->loadObjectlist();
?>
      <tr>
        <td>
		<a href="index2.php?option=com_cbe&task=tools&func=backupenh"><?php echo _UE_TOOLS_CBE_BACKUP; ?></a>&nbsp;
<?php	if ($backupenh[0]->value) echo "<a href=\"index2.php?option=com_cbe&task=tools&func=restoreenh\">". _UE_TOOLS_CBE_RESTORE ."</a>&nbsp"; ?>
      	</td>
	<td>
		<?php echo _UE_TOOLS_CBE_BACKUPRESTOREENH_DESC; 
		if ($backupenh[0]->value) echo "<br />"._UE_BACKUPRESTORE_DATE."<strong><em>".$backupenh[0]->value." (Version: ".$backupenh[1]->value.")</em></strong>"; ?>
	</td>
      </tr>
	  
      <?php
      }
?>
   </table>

 <?php
} //end function showTools


////////////////////////////////////////
function adminAvatar($row, $option, $user_uid, $submitvalue) {
	global $ueConfig,$mosConfig_live_site, $mainframe;
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbe.php');

	$database = &JFactory::getDBO();
	$rowExtras = new moscbe ($database);
	$rowExtras->load($row->id);

	?> 
	<style>
	.titleCell {
		font-weight:bold;
		width:85px;
	}
	</style>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		if (pressbutton == 'showusers') {
			pressbutton = 'edit';
			submitform(pressbutton);
			return;
		}
		//alert("I got clicked!");
	}
		</script>
	<!-- TAB -->
	<table cellspacing="0" cellpadding="4" border="0" width="100%">
		<tr>
			<td class="componentheading" colspan="6"><?php echo "Avatar Upload"; ?></td>
		</tr>
	</table>   
	<?php                       
	global $my,$user_uid,$avatar,$avatar_name,$newAvatar,$_FILES;
	$do='';
	$do= JRequest::getVar('do', 'init' );
	$UpAvatar = $_FILES['avatar'];
	$avatar = $_FILES['avatar']['tmp_name'];
	$avatar_name = $_FILES['avatar']['tmp_name'];
	$avatar_error = $_FILES['avatar']['error'];
	$newAvatar = JRequest::getVar('newAvatar', NULL);
	
	if ($do=='init'){
		if($ueConfig['allowAvatarUpload']){
			echo "<span class='contentheading'>"._UE_UPLOAD_SUBMIT."</span><br><br>";
			echo _UE_UPLOAD_DIMENSIONS.": ".$ueConfig['avatarWidth']."x".$ueConfig['avatarHeight']." - ".$ueConfig['avatarSize']." KB";
//			echo "<form action='index2.php?option=com_cbe&amp;task=adminUpAvatar&amp;do=validate' method='post' name='adminForm' enctype='multipart/form-data'>";
			echo "<form action='index2.php?option=com_cbe' method='post' name='adminForm' enctype='multipart/form-data'>";
			echo "<input type='hidden' name='do' value='validate'>";
			echo "<input type='hidden' name='user_id' value='".$row->id."'>";
			echo "<input type='hidden' name='task' value='adminUpAvatar'>";
			echo "<input type='hidden' name='cid[]' value='".$row->id."'>";
			echo "<input type='hidden' name='opion' value='".$option."'>";
			echo "<table width='100%' border='0' cellpadding='4' cellspacing='2'>";
			echo "<tr align='center' valign='middle'><td align='center' valign='top'>";
	
			$uplabel=_UE_UPLOAD_UPLOAD;
			//echo " <input type='hidden' name='MAX_FILE_SIZE' value='".$maxAllowed."' />";
			echo _UE_UPLOAD_SELECT_FILE." <input type='file' class='button' name='avatar' value='' />";
			echo "<input type='submit' class='button' value='"._UE_UPLOAD_UPLOAD."' />";
			echo "</td></tr></table><br/><br/>";
			echo "</form>";
//			echo "<a href=\"index2.php?option=com_cbe&amp;task=showusers\">cancel</a>";

		}
	} else if ($do=='validate'){
//		echo $avatar_name;
		$user_uid = $row->id;

		$filename = split("\.", $avatar_name);
		$avatarName=$filename[0];
		$avatarExt=$filename[1];
		$avatarSize=filesize($avatar);
	
		if (empty($avatar)) {
			echo "<a href=\"index2.php?option=com_cbe&amp;task=edit&amp;cid[]=".$user_uid."\">"._UE_UPLOAD_ERROR_EMPTY."</a><br>";
		}

	//get rid of old Avatar
	   	if (eregi("gallery/",$rowExtras->avatar)==false && is_file(JPATH_SITE."/images/cbe/".$rowExtras->avatar)) {
			unlink(JPATH_SITE."/images/cbe/".$rowExtras->avatar);
			if (is_file(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar)) {
				unlink(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar);
			}
		}

	
		$imgToolBox = new imgToolBox();
		$imgToolBox->_conversiontype=$ueConfig['conversiontype'];
		$imgToolBox->_IM_path = $ueConfig['im_path'];
		$imgToolBox->_NETPBM_path = $ueConfig['netpbm_path'];
		$imgToolBox->_maxsize = $ueConfig['avatarSize'];
		$imgToolBox->_maxwidth = $ueConfig['avatarWidth'];
		$imgToolBox->_maxheight = $ueConfig['avatarHeight'];
		$imgToolBox->_thumbwidth = $ueConfig['thumbWidth'];
		$imgToolBox->_thumbheight = $ueConfig['thumbHeight'];
		$imgToolBox->_debug = 0;
		//	sv0.6233 / 0.6234
		$imgToolBox->_wm2_force_png	= $ueConfig['wm_force_png'];
		$imgToolBox->_wm2_force_zoom 	= $ueConfig['wm_force_zoom'];
		$imgToolBox->_wm2_canvas_col 	= $ueConfig['wm_canvas_color'];	
		$imgToolBox->_wm2_canvas_coltr 	= $ueConfig['wm_canvas_trans'];	
		$imgToolBox->_wm2_canvas 	= $ueConfig['wm_canvas'];
		$imgToolBox->_wm2_stampit 	= $ueConfig['wm_stampit'];
		$imgToolBox->_wm2_stampit_txt 	= $ueConfig['wm_stampit_text'];
		$imgToolBox->_wm2_stampit_size 	= $ueConfig['wm_stampit_size'];
		if ($ueConfig['wm_stampit_text']=='' ||$ueConfig['wm_stampit_text']==null) {
			$imgToolBox->_wm2_stampit_txt = JURI::root().$row->username;
		}
		if (!($ueConfig['wm_stampit_color']=='' || $ueConfig['wm_stampit_color']==null || strlen(trim($ueConfig['wm_stampit_color']))!=6)) {
			$red = hexdec(substr($ueConfig['wm_stampit_color'],0,2));
			$yellow = hexdec(substr($ueConfig['wm_stampit_color'],2,2));
			$green = hexdec(substr($ueConfig['wm_stampit_color'],4,2));
			
			$imgToolBox->_wm2_stampit_cred = $red;
			$imgToolBox->_wm2_stampit_cyellow = $yellow;
			$imgToolBox->_wm2_stampit_cgreen = $green;
		}
		$imgToolBox->_wm2_doit = $ueConfig['wm_doit'];
		$imgToolBox->_wm2_img = $ueConfig['wm_filename'];
		//

		if(!($newFileName=$imgToolBox->processImage($_FILES['avatar'], $user_uid,JPATH_SITE.'/images/cbe/', 0, 0, 1))) {
			echo "<a href=\"index2.php?option=com_cbe&amp;task=showusers\">".$imgToolBox->_errMSG."</a><br>";
			return;
		}
	
		$database->setQuery("UPDATE #__cbe SET avatar='$newFileName', avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$user_uid'");
		$redMsg=_UE_UPLOAD_SUCCESSFUL;
		$database->query();

		echo "<a href=\"index2.php?option=com_cbe&amp;task=showusers\">".$redMsg."</a><br>";

	} else if ($do=='fromgallery'){
	
		if($newAvatar==''){
//			MOSredirect(sefRelToAbs("index2.php?option=com_cbe&task=userAvatar".$Itemid_c),_UE_UPLOAD_ERROR_CHOOSE);
		}
		$database->setQuery("UPDATE #__cbe SET avatar='$newAvatar', avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$user_uid'");
	
		if(!$database->query()) {
			echo _UE_USER_PROFILE_NOT."<br/><br/>";
		}else {
			echo _UE_USER_PROFILE_UPDATED."<br/><br/>";
			$mainframe->redirect ("index2.php?option=com_cbe&task=showusers");
		}
		echo _UE_USER_RETURN_A." <a href=\"index2.php?option=com_cbe&amp;task=showusers\">"._UE_USER_RETURN_B."</a><br/><br/>";

	} else if ($do=='deleteavatar') {
		$user_uid = $row->id;
		if(eregi("gallery/",$rowExtras->avatar)==false && is_file(JPATH_SITE."/images/cbe/".$rowExtras->avatar)) {
			unlink(JPATH_SITE."/images/cbe/".$rowExtras->avatar);
			if(is_file(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar)) unlink(JPATH_SITE."/images/cbe/tn".$rowExtras->avatar);
		}
		$database->setQuery("UPDATE  #__cbe SET avatar=null, avatarapproved=1, lastupdatedate='".date('Y-m-d\TH:i:s')."' WHERE id='$user_uid'");
		$database->query();
	
		$mainframe->redirect("index2.php?option=com_cbe&task=edit&cid[]=".$row->id);
	}

}

function show_badUserNames( &$rows, $pageNav, $option )
{
?>
	<form action="index2.php" method="post" name="adminForm">
	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/person1_f2.png" align="middle"><?php echo _UE_CBE_BLOCKED_NAMES_MANAGER; ?></span></td>
			<td nowrap><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
			<td> <?php echo $pageNav->getLimitBox(); ?> </td>
		</tr>
	</table>

	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
			<th width="20">#</th>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th><?php echo _UE_CBE_BNM_LIST_OF_PARTS; ?></th>
			<th><?php echo _UE_CBE_BNM_PUBLISHED; ?></th>
		</tr>
<?php
$k = 0;
for($i=0; $i < count( $rows ); $i++) {
	$row = $rows[$i];
	$img = $row->published ? 'tick.png' : 'publish_x.png';
	$task = $row->published ? 'unpublishbadUserNames' : 'publishbadUserNames';
?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center"><?php echo $i+$pageNav->limitstart+1;?></td>
			<td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
			<td><a href="#editbadUserNames" onclick="return listItemTask('cb<?php echo $i;?>','editbadUserNames')"><?php echo $row->badname; ?></a></td>
			<td width="10%" align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" border="0" alt="" /></a></td>
		</tr>
<?php
$k = 1 - $k;
}
?>
		<tr>
			<th align="center" colspan="10"> <?php echo $pageNav->getPagesLinks(); ?></th>
		</tr>
		<tr>
			<td align="center" colspan="10"> <?php echo $pageNav->getPagesCounter(); ?></td>
		</tr>
	</table>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
<?php 
}

function edit_badUserNames( &$row, $option )
{
	JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );
?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == "cancelbadUserNames") {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.badname.value == '') {
			alert( "<?php echo _UE_CBE_BNM_POPERROR; ?>" );
		} else {
			submitform( pressbutton );
		}
	}
	</script>

	<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm">
		<table border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td><b><?php echo _UE_CBE_BNM_NAME_PART; ?></b>:&nbsp; </td>
				<td><input class="inputbox" type="text" size="50" maxlength="100" name="badname" value="<?php echo $row->badname; ?>" /></td>
			</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
	</form>
<?php 
}

function controlPanel() {
	global $mosConfig_live_site, $task;
	global $database, $acl, $my, $mainframe, $option, $version, $ueConfig;

	if (preg_match("/Mambo/i", $version->PRODUCT)) {
		$css_html = '<link rel="stylesheet" href="components/com_cbe/adm_tpls/cpanel.css" type="text/css" />';
		//$mainframe->addCustomHeadTag($css_html);
		echo $css_html;
	}
	?>
	<table class="adminheading" border="0">
	<tr>
		<th class="cpanel">
		CBE - Control Panel
		</th>
	</tr>
	</table>
	<?php
	$path = JPATH_SITE . '/administrator/components/com_cbe/adm_tpls/cpanel.php';
	if (file_exists( $path ))
		require $path;
	else
		echo '<br />';
}

// AdMods
function show_AdMods( &$rows, $pageNav, $search, $option ) {
	global $mosConfig_offset;
?>
	<form action="index2.php" method="post" name="adminForm">
	  <table cellpadding="4" cellspacing="0" border="0" width="100%">
	    <tr>
	      <td width="100%" class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/module.png" align="middle"><?php echo _UE_CBE_ADMODS_M; ?></td>
	      <td nowrap="nowrap"><?php echo _UE_CBE_NR_DISPLAY; ?> #</td>
	      <td> <?php echo $pageNav->getLimitBox(); ?> </td>
	      <td><?php echo _UE_CBE_LM_SEARCH; ?>:</td>
	      <td> <input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
	      </td>
	    </tr>
	  </table>
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	    <tr>
	      <th width="2%" class="title">#</th>
	      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
	      </th>
	      <th width="10%" class="title"><?php echo _UE_CBE_TITLE; ?></th>
	      <th width="10%" class="title"><?php echo _UE_CBE_DESCRIPTION; ?></th>
	      <th width="5%" class="title"><?php echo _UE_CBE_PUBLISHED; ?>?</th>
	      <th width="5%" class="title"><?php echo _UE_CBE_ADM_POSITION; ?></th>
	      <th width="5%" class="title" colspan="2"><?php echo _UE_CBE_RE_ORDER; ?></th>
	      <th width="5%" class="title" colspan="2">
		<center><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="<?php echo _UE_CBE_BE_NEW_ORDER; ?>" /></a></center>
	      </th>
	    </tr>
	<?php
	$k = 0;
	$imgpath='../components/com_cbe/images/';
	for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		$row =& $rows[$i];
	
		$img3 = $row->published ?  'tick.png' : 'publish_x.png';
		$task3 = $row->published ?  'unpublishAdMods' : 'publishAdMods';
	?>
	    <tr class="<?php echo "row$k"; ?>">
	      <td><?php echo $i+1+$pageNav->limitstart;?></td>
	      <td><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);" /></td>
	      <td> <a href="#editAdMods" onClick="return listItemTask('cb<?php echo $i;?>','editAdMods')"><?php echo CBE_getLangDefinition($row->title); ?></a></td>
	      <td><?php echo CBE_getLangDefinition($row->content); ?></td>
	      <td width="10%"><a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>
	','<?php echo $task3;?>')"><img src="<?php echo $imgpath.$img3;?>" width="12" height="12" border="0" alt="" /></a></td>
	      <td><?php echo $row->position; ?></td>
	      <td>
		<?php    if ($i > 0 || ($i+$pageNav->limitstart > 0)) { ?>
	         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderupAdMods')">
	            <img src="images/uparrow.png" width="12" height="12" border="0" alt="Move Up">
	         </a>
		<?php    } ?>
	      </td>
	      <td>
		<?php    if ($i < $n-1 || $i+$pageNav->limitstart < $pageNav->total-1) { ?>
	         <a href="#reorder" onClick="return listItemTask('cb<?php echo $i;?>','orderdownAdMods')">
	            <img src="images/downarrow.png" width="12" height="12" border="0" alt="Move Down">
	         </a>
		<?php    } ?>
	      </td>
	      <td align="center" colspan="2">
		<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
	      </td>
	    </tr>
	    <?php $k = 1 - $k; } ?>
	    <tr>
	      <th align="center" colspan="11"> <?php echo $pageNav->getPagesLinks(); ?></th>
	    </tr>
	    <tr>
	      <td align="center" colspan="11"> <?php echo $pageNav->getPagesCounter(); ?></td>
	    </tr>
	  </table>
	  <input type="hidden" name="option" value="<?php echo $option;?>" />
	  <input type="hidden" name="task" value="showAdMods" />
	  <input type="hidden" name="listType" value="show_AdMods" />
	  <input type="hidden" name="boxchecked" value="0" />
	</form>
<?php 
}

function edit_AdMods( &$row, $lists, $option ) {
	global $my, $acl, $task, $mosConfig_live_site;
	
	JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );
?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		if (pressbutton == 'cancelAdMods') {
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
				if (elements.item(i).getAttribute('mosReq') == 1) {
					if (elements.item(i).value == '') {
						//alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
						// add up all error messages
						errorMSG += elements.item(i).getAttribute('mosLabel') + '\t: <?php echo _UE_REQUIRED_ERROR; ?>\n';
						// notify user by changing background color, in this case to red
						elements.item(i).style.background = "red";
						iserror=1;
					}
				}
			}
		}
		if(iserror==1) {
			alert(errorMSG);
		} else {
			submitform(pressbutton);
		}
	}
	</script>

	<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="sectionname"><img src="<?php echo JURI::root() ?>administrator/images/module.png" align="middle"><?php echo $row->id ? _UE_CBE_ADMODS_M_EDIT : _UE_CBE_ADMODS_M_ADD;?></td>
		</tr>
	</table>

	<form action="index2.php?option=com_cbe&task=saveAdMods" method="POST" name="adminForm">
	<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo _UE_CBE_TITLE; ?>:</td>
			<td width="20%"><input type="text" name="title" mosLabel="<?php echo _UE_CBE_TITLE; ?>" class="inputbox" mosReq=1 size="40" value="<?php echo $row->title; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_DESCRIPTION; ?>:</td>
			<td width="20%"><textarea name="content" mosLabel="<?php echo _UE_CBE_DESCRIPTION; ?>" class="inputbox" cols="38" rows="5"><?php echo $row->content; ?></textarea></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_ADM_PUBLISHED; ?>:</td>
			<td width="20%"><?php echo $lists['published']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_ADM_POSITION; ?>:</td>
			<td width="20%"><?php echo $lists['position']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_ADM_MODULE; ?>:</td>
			<td width="20%"><input type="text" name="module" mosLabel="<?php echo _UE_CBE_ADM_MODULE; ?>" class="inputbox" mosReq=1 size="40" maxlength=50 value="<?php echo $row->module; ?>" /></td>
			<td><?php echo _UE_CBE_ADM_MODULE_DESC; ?></td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_ADM_PLUGIN_NAME; ?>:</td>
			<td width="20%"><input type="text" name="plugin" mosLabel="<?php echo _UE_CBE_ADM_PLUGIN_NAME; ?>" class="inputbox" mosReq=1 size="40" value="<?php echo $row->plugin; ?>" /></td>
			<td><?php echo _UE_CBE_ADM_PLUGIN_NAME_DESC; ?></td>
		</tr>
		<tr>
			<td width="20%"><?php echo _UE_CBE_ADM_PLUGIN_FUNC; ?>:</td>
			<td width="20%"><input type="text" name="plugin_func" mosLabel="<?php echo _UE_CBE_ADM_PLUGIN_FUNC; ?>" class="inputbox" mosReq=1 size="40" value="<?php echo $row->plugin_func; ?>" /></td>
			<td><?php echo _UE_CBE_ADM_PLUGIN_FUNC_DESC; ?></td>
		</tr>

	</table>
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
		<input type="hidden" name="task" value="" />
	</form>
<?php 
}

///////////////////
function cbeNewExtension() {
	jimport('joomla.html.pane');
	$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
	$database = &JFactory::getDBO();
	$sql = "SELECT * FROM #__cbe_extensions";
	$database->setQuery($sql);
	$exts = $database->loadObjectList();
	//print_r($exts);
	// die installierten erweiterungen anzeigen
	echo $pane->startPane("CBE Installed Extensions");
	echo $pane->startPanel("CBE Installed Extensions", "cbe_installed");
	echo "<table>
		<tr>
			<th align=left width=20%>Name</th>
			<th align=left width=20%>Typ</th>
			<th align=left width=20%>Autor</th>
			<th align=left width=20%>Homepage</th>
			<th align=left width=20%>Funktionen</th>
		</tr>";

	$appimg = '<img src=' . JURI::root() . "/components/com_cbe/images/updateprofile.gif" . '>';
	$delimg = '<img src=' . JURI::root() . "/components/com_cbe/images/reject.png" . '>';
	
	foreach ($exts as $ext) {
		$applink = '<a href="index.php?option=com_cbe&edit">' . $appimg . '</a>';
		$dellink = '<a href="index.php?option=com_cbe&task=removeTab&ret=cbeNewExtension&cid[]=' . $ext->tabid . '">' . $delimg . '</a>';

		$title = (!empty($ext->exttitle))?$ext->exttitle:$ext->extname;
		echo "
		<tr>
			<td>$title</td>
			<td>$ext->exttype</td>
			<td>$ext->author</td>
			<td><a href='http://$ext->hp' target='_new'>$ext->hp</a></td>
			<td>$applink&nbsp;$dellink</td>
		</tr>";
	}

	echo "</table>";
	echo $pane->endPanel();
	echo $pane->endPane();



	$sections = array("cbe_tab"	=> "CBE Tab","cbe_template"	=> "CBE Template", "cbe_core"	=> "CBE Update" );
	
	// ab hier die panes
	echo $pane->startPane("CBE New Extension");

	foreach ($sections as $section=>$title) {
		echo $pane->startPanel($title,$section);

		echo <<<EOT
		<form enctype="multipart/form-data" action="index2.php" method="post" name="filename">
		<input type=hidden name="option" value="com_cbe" />
		<input type=hidden name="installtype" value="upload" />
		<input type=hidden name="task" value="cbeInstallExtension" />
		<input type=hidden name="cbe_ext_type" value="$section" />

		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform" style="margin:5px;">
			<tr>
				<th>Neuen Tab / neues Plugin installieren</th>
			</tr>
			<tr>
				<td><input name="install_package" type=file></td>
			</tr>
			<tr>
				<td><input type=submit value="Installieren"></td>
			</tr>
		</table>
		</form>
EOT;
		echo $pane->endPanel();
	}
	echo $pane->endPane();
}
}
?>
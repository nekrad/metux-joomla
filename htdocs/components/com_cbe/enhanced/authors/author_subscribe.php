<?php

//********************************************
// Author Subscribe/UnSubscribe              *
// Copyright (c) Jeffrey Randall 2005        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.1 File Date: 16-05-2005         *
//********************************************

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
$my = &JFactory::getUser();
$database = &JFactory::getDBO();

if (file_exists('components/com_cbe/enhanced/authors/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/authors/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/authors/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');

//$database->setQuery("SELECT id FROM #__menu WHERE (link LIKE '%com_cbe' OR link LIKE '%com_cbe%userProfile') AND (published='1' OR published='0')");
//$Itemid = $database->loadResult();
if ($GLOBALS['Itemid_com']!='') {
	$Itemid_c = $GLOBALS['Itemid_com'];
} else {
	$Itemid_c = '';
}


if($enhanced_Config['author_subscribe']==1)
{
	if($my->id &&  $my->id!=$user->id)
	{
	?>
	<tr>
	<td width="35%" style="font-weight:bold;"></td>
	</tr>
	<?php

	$query = "SELECT authorid
			  FROM #__cbe_authorlist 
			  WHERE userid='".$my->id."' 
			  AND authorid='".$user->id."'";
	$database->setQuery($query);
	$result = '';
	$result = $database->loadObjectList();
	$total = count ($result);

	if($total<1)
	{
	?>
	<form action="index.php?option=com_cbe<?php echo $Itemid_c; ?>&amp;task=subauthor" method="post" name="adminForm">	
<?php

echo "<tr><td>"._UE_SUBSCRIBE_TO_AUTHOR."<input type=\"checkbox\" id=\"cb\" name=\"addauth[$user->id]\" value=\"add\" onclick=\"document.adminForm.submit();\"/>\n";

?>
	<input type="hidden" name="adminForm" class="button" value="<?php echo _UE_SUBSCRIBE_TO_AUTHOR; ?>"></td></tr>
		
	</form>
	<?php 
	}
	else
	{
	?>	
	<form action="index.php?option=com_cbe<?php echo $Itemid_c; ?>&amp;task=delauthor" method="post" name="adminForm">	
	<?php	
	echo "<tr><td>"._UE_UNSUBSCRIBE_FROM_AUTHOR."<input type=\"checkbox\" CHECKED id=\"cb\" name=\"delete[$user->id]\" value=\"del\" onclick=\"document.adminForm.submit();\"/></td></tr>\n";
	echo "<tr><td><input type=\"hidden\" id=\"cb\" name=\"delete[$user->id]\" value=\"del\" onclick=\"document.adminForm.submit();\"/></td></tr>\n";
	?>
	<td align="left"><input type="hidden" name="adminForm" class="button" value="<?php echo _UE_DELETE_CHECKED; ?>"></td>
</form>
	<?php 
	}
	}
}
?>
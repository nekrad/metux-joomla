<?php
 defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

 /******************************/
 /* rateit.php                 */
 /* author: gregor@klevze.si   */
 /* 23.Maj, 2003               */
 /* http://www.skintech.org    */
 /******************************/
 /* rateit for mambo           */
 /* aditional code by sunnyboy */
 /* 16.Aug, 2005               */
 /******************************/
 /* shaped for integration     */
 /* Phil_K 		       */
 /* 04.10.2005                 */
 /******************************/

include_once('components/com_cbe/enhanced/enhanced_functions.inc');

if (file_exists('components/com_cbe/enhanced/rating/language/'.$mosConfig_lang.'.php'))
{
	include_once('components/com_cbe/enhanced/rating/language/'.$mosConfig_lang.'.php');
}
else
{
	include_once('components/com_cbe/enhanced/rating/language/english.php');
}

include_once('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');



function RateGetRate($enhanced_Config) {
	
	global $enhancedConfig;

	$database = &JFactory::getDBO();

	$rating_days	= $enhanced_Config['rateit_days'];
	$rating_m	= $enhanced_Config['rateit_mvalue'];
	$rating_C	= $enhanced_Config['rateit_cvalue'];
	
	 
	 if($_POST['action'] == "rateit_doit") {
	 	if($_POST['rates']>0 && $_POST['rates']<11 && !empty($_POST['rateit_id'])) {
	 		$ip  = getenv("REMOTE_ADDR"); 
	 		$query = "SELECT count(*) AS num FROM #__cbe_ratings WHERE (date>SUBDATE(now(),INTERVAL ".$rating_days." DAY) AND ip='$ip' AND profile='".$_POST['rateit_id']."')";
	//		$rs = mysql_query($query) or die("LINE 17:".mysql_error());
			$database->setQuery($query);
	//		$as = mysql_fetch_array($rs);
			$as[num] = $database->loadResult();
	
			if($as[num]==0) {
	//			mysql_query("INSERT INTO #__cbe_ratings VALUES(0,'".$_POST['rateit_id']."','".$_POST['rates']."','".$ip."',NOW(),'".$_POST['visitor_id']."')") or die(mysql_error());
				$queryset= "INSERT INTO #__cbe_ratings VALUES(0,'".$_POST['rateit_id']."','".$_POST['rates']."','".$ip."',NOW(),'".$_POST['visitor_id']."')";
				$database->setQuery($queryset);
				if ( !$database->query() ) {
					$GetRate_out = "Error db insert.<br>";
				}
				if ( $enhanced_Config['rateit_mod'] == '1') {
					$rate_uid = $_POST['rateit_id'];
					$rate_votecount = RateNumRates($rate_uid);
					$rate_voteresult = RateShowResult($rate_uid,$enhanced_Config);
					$query_mod = "UPDATE #__cbe SET votecount='".$rate_votecount."', voteresult='".$rate_voteresult."' WHERE user_id='".$rate_uid."'";
					$database->setQuery($query_mod);
					if ( !$database->query() ) {
						$GetRate_out .= "2Module: Error db insert.<br>";
					}
				}
				

			} else {
				$GetRate_out = '<font color="red">'._UE_RATEIT_DAY_TXT1.' '.$rating_days.' ';
				if ($rating_days < 2 ) {
					$GetRate_out .= _UE_RATEIT_DAY_TXT2.'</font><br>';
				} else {
					$GetRate_out .= _UE_RATEIT_DAY_TXT3.'</font><br>';
				}
			}
	//		echo $ad[num];
			$uid = $rateit_id;
			$vis = $visitor_id;
	  	}
	 }
	return $GetRate_out;
}

function RateShowForm($id,$num,$rate_me="Rate Me",$rate_it="Rate!",$class="",$vis) {
	global $ueConfig,$enhancedConfig,$my,$user;

	$database = &JFactory::getDBO();

	if ($GLOBALS['Itemid_com']!='') {
		$Itemid_c = $GLOBALS['Itemid_com'];
	} else {
		$Itemid_c = '';
	}
	
	$rate_form_out .= '<form action="index.php?option=com_cbe'.$Itemid_c.'&task=userProfile&user='.$id.'" method="post">';
	$rate_form_out .= '<select name="rates" class="inputbox">';
	$rate_form_out .= '<option value="x" selected>'.$rate_me.'</option>';
	for($x=$num;$x>0;$x--)
		$rate_form_out .= '<option value="'.$x.'">'.$x.'</option>';
	$rate_form_out .= '</select>';
	$rate_form_out .= '<input type="hidden" name="rateit_id" value="'.$id.'">';
	$rate_form_out .= '<input type="hidden" name="action" value="rateit_doit"> ';
	$rate_form_out .= '<br><input type="submit" value="'.$rate_it.'" class="'.$class.'">';
	$rate_form_out .= '<input type="hidden" name="visitor_id" value="'.$vis.'">';
	$rate_form_out .= '</form>';
	
	return $rate_form_out;
}

function RateNumRates($id) {
	global $ueConfig,$enhancedConfig,$my,$user;
	$database = &JFactory::getDBO();

//	$res = mysql_query("SELECT count(*) AS num FROM #__cbe_ratings WHERE profile='".$id."'") or die("LINE 50:".mysql_error());
//	$ar = mysql_fetch_array($res);
	$query_res = "SELECT count(*) AS num FROM #__cbe_ratings WHERE profile='".$id."'";
	$database->setQuery($query_res);
	$ar[num] = $database->loadResult();

	if(empty($ar[num])) {
		$ar[num] = "0";
	}
	return $ar[num];
}

function RateShowResult($id,$enhanced_Config) {
	global $ueConfig,$enhancedConfig,$my,$user;
	$database = &JFactory::getDBO();

//	if (file_exists('administrator/components/com_cbe/enhanced_admin/enhanced_config.php')) {
//		include('administrator/components/com_cbe/enhanced_admin/enhanced_config.php');
//	} else {
//		echo "INCLUDE ERROR";
//	}

	$rating_days	= $enhanced_Config['rateit_days'];
	$rating_m	= $enhanced_Config['rateit_mvalue'];
	$rating_C	= $enhanced_Config['rateit_cvalue'];
	$rprec		= $enhanced_Config['rateit_precision'];

	if (!$rprec) {
		$rprec = 4;
	}

 	/*
 	 The formula for calculating the top 250 films gives a true Bayesian estimate:
 	
 	    weighted rank (WR) = (v � (v+m)) � R + (m � (v+m)) � C
 	
 	 where:
 	    R = average for the movie (mean) = (Rating)
 	    v = number of votes for the movie = (votes)
 	    m = minimum votes required to be listed in the top 250 (currently 1250)
 	    C = the mean vote across the whole report (currently 6.9)
 	*/

 	$query = "SELECT COUNT(*) as num, ((COUNT(*)/(COUNT(*)+".$rating_m."))*AVG(rate)+(".$rating_m."/(COUNT(*)+".$rating_m."))*".$rating_C.") AS rate FROM #__cbe_ratings WHERE rate>0 AND rate<11 AND profile='".$id."'";
// 	$res = mysql_query($query) or die("<b>LINE 74</b>:".mysql_error());
// 	$ar  = mysql_fetch_array($res);
 	$database->setQuery($query);
 	$ar = $database->loadAssocList();
 	$ar = $ar[0];
 	$percent = $ar[rate];
 
 	if(empty($percent) || $percent<0) {
 		$percent=0;
 	} else {
 		$percent = round($percent, $rprec);
 	}
	
 	return $percent;
}

function RateShowStars($id,$width=20,$enhanced_Config) {
	global $ueConfig,$enhancedConfig,$user;
	$database = &JFactory::getDBO();
	$rating_days	= $enhanced_Config['rateit_days'];
	$rating_m	= $enhanced_Config['rateit_mvalue'];
	$rating_C	= $enhanced_Config['rateit_cvalue'];

 	$query = "SELECT COUNT(*) as num, ((COUNT(*)/(COUNT(*)+".$rating_m."))*AVG(rate)+(".$rating_m."/(COUNT(*)+".$rating_m."))*".$rating_C.") AS rate FROM #__cbe_ratings WHERE rate>0 AND rate<11 AND profile='".$id."'";
// 	$res = mysql_query($query) or die("<b>LINE 85</b>:".mysql_error());
//	$ar  = mysql_fetch_array($res);
 	$database->setQuery($query);
 	$ar = $database->loadAssocList();
 	$ar = $ar[0];

 	$percent = (int) $ar[rate]+0.5;
 	if(empty($percent) || $percent<0) {
 		$percent=0;
 	}
 	
 	for($x=1;$x<=$percent;$x++)
 	  $rate_stars_out .= '<img src="components/com_cbe/enhanced/rating/'.$enhanced_Config['rateit_iconfull'].'" alt="" width="'.$width.'"/>';
 	
 	$io = $ar[rate] - (int)$ar[rate];
 	if($io>0.49) {
 		$rate_stars_out .= '<img src="components/com_cbe/enhanced/rating/'.$enhanced_Config['rateit_iconhalf'].'" alt="" width="'.$width.'"/>';
 	}

 	return $rate_stars_out;
}

// Main Function

$rate_output = '';

$my = &JFactory::getUser();
if ($enhanced_Config['rateit_allow'] == '1') {

		$rate_output .= '<div align="center">';
		$rate_output .= '	<table border="0" width="90%" id="table1">';
		$rate_output .= '		<tr>';
		$rate_output .= '			<td colspan="3" align="center">';
		$rate_output .= RateGetRate($enhanced_Config);
		$rate_output .= '			 </td>';
		$rate_output .= '		</tr>';
		$rate_output .= '		<tr>';
		$rate_output .= '			<td width="20%" align="center">';

	if ($enhanced_Config['rateit_count'] == '1') {
		$rate_output .= _UE_RATEIT_COUNT_TXT.'<br>'.RateNumRates($user->id);
	} else {
		$rate_output .= '&nbsp;';
	}

		$rate_output .= '			 </td>';
		$rate_output .= '			<td width="50%" align="center">';

	if ($enhanced_Config['rateit_stars'] == '1') {
		$rate_output .= RateShowStars($user->id,'20',$enhanced_Config);
	} else {
		$rate_output .= '&nbsp;';
	}

		$rate_output .= '			 </td>';
		$rate_output .= '			<td width="20%" align="center">';
	if ($enhanced_Config['rateit_result_allow'] == '1') {
		$rate_output .= _UE_RATEIT_AVG_TXT.'<br>'.RateShowResult($user->id,$enhanced_Config);
	} else {
		$rate_output .= '&nbsp;';
	}
	
		$rate_output .= '			 </td>';
		$rate_output .= '		</tr>';
		$rate_output .= '		<tr>';
		$rate_output .= '			<td width="20%">&nbsp;';
		$rate_output .= '			 </td>';
		$rate_output .= '			<td width="50%" align="center">';

	if ($enhanced_Config['rateit_form'] == '1') {
		if ( (($enhanced_Config['rateit_self'] == '1') && ($user->id == $my->id)) || ($user->id != $my->id)) {
			if ( ($enhanced_Config['rateit_guest'] != '1') && ($my->id == '0')) {
				$rate_output .= _UE_RATEIT_GUEST_NOT;
			} else {
				$rate_output .= RateShowForm($user->id,10,_UE_RATEIT_VOTE_TEXT,_UE_RATEIT_VOTE_BUTTON,"button",$my->id);
			}
		} else {
			$rate_output .= _UE_RATEIT_SELF_NOT;

		}
	}

		$rate_output .= '			  </td>';
		$rate_output .= '			<td width="20%">&nbsp;';
		$rate_output .= '			 </td>';
		$rate_output .= '		</tr>';
		$rate_output .= '	</table>';
		$rate_output .= '</div>';
		$rate_output .= '<p>';

}

	echo $rate_output;

?>
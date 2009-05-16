<?php 
/*
Package myJSpace
Copyright 2008 D'Abronzo Vincenzo/ ~ jalil ~ All rights reserved.
Lcense GNU / GPL
Creator/Author D'Abronzo Vincenzo / Coder  ~ jalil ~ 
*/

/* 
MyJSpace is free software. This version may have been modified pursuant
to the GNU General Public License, and as distributed it includes or
is derivative of works licensed under the GNU General Public License or
other free or open source software licenses.
*/

/* 
VERSION 13 BUILD 010
*/

/*
Sources
*/
// top level error control
error_reporting(E_ALL);
error_reporting(0);

// no direct access
defined( '_MJSEXEC' ) or die( 'Restricted access' );



class HTML_Mod_ViewMJSPages extends MJS_Mod_ViewMJSPages
{
var	$user=0;
var	$Itemid=0;
var	$speaker;


	function HTML_Mod_ViewMJSPages() 
	{
	//.......................................................................................................................................................................
	global $mainframe,$database,$mosConfig_absolute_path,$mosConfig_live_site;
	global $db,$user,$Itemid,$id;
	$this->speaker = new MJS_Com_Vocabulary;
	parent::init();
	$this->init();

	include_once( dirname(__FILE__).DS.'mod_viewmjspages'.DS.'myJSpace_JavaScript_Library.js' );
	//.......................................................................................................................................................................
	} // function MJS_Mod_ViewMJSPages



	function issue_style($instance)
	{
	// issue built in styles ( instead of template styles )
	//....................................................................................................
	$output='
		<style type="text/css">';

	$output.='
		div.mjs_legend_title
		{
		height:20px;
		border:1px solid #777;
		color:brown;
		text-align:center;
		margin-top:20px;
		}

		#whitebox div
		{
		}

		span#mjs_links a
		{
		}
		
		span#mjs_links a:hover
		{
		color:blue;
		}

		span.mjs_stats
		{
		border:1px #777777 solid;
		padding:3px;
		}

		input.mjs_search
		{
		font-size:14px;
		line-height:14px;
		text-align:left;
		padding:2px;
		padding-left:5px;
		}

		span.mjs_captions
		{
		font-size:66%;
		text-align:left;
		padding:2px;
		}

		span.mjs_message
		{
		border:1px dotted blue;
		padding:3px;
		font-size:12px;
		}

		select.sort_order
		{
		width:100px;
		}

		span.mjs_titles
		{
		padding:3px;
		font-size:12px;
		}

		ul.menu
		{
		align:left;
		text-align:left;
		}

		ol.viewmjspages,ul.viewmjspages 
		{
		align:left;
		text-align:left;
		}

		ol.viewmjspages li,ul.viewmjspages li
		{
		padding:0;
		line-height:12px;
		}

		table.mjs_stats
			{
			border:1px #777777 solid;
			}

		td.mjs_stats_mark
			{
			border:1px red solid;
			padding:3px;
			}

		td.mjs_stats
			{
			border:1px #777777 solid;
			}

		#mjsUserForm
			{
			align:left;
			text-align:left;
			}	


		.mjs_latest
			{
			align:left;
			text-align:left;
			}

		.mjs_user_panel 
			{
			width:100%;
			border:0px #777777 solid;
			padding:0px;
			align:left;
			text-align:left;
			}

		.mjs_user_panel ul li a
			{
			align:left;
			text-align:left;
			}

		table.mjs_user_panel tbody
			{
			width:100%;
			}	

		table.mjs_user_panel tbody td
			{
			border:0px #777777 solid;
			padding:0px;
			align:left;
			text-align:left;
			}	

		table.mjs_user_panel tbody td ul
			{
			align:left;
			text-align:left;
			list-style-type:none;
			}
		
		table.mjs_user_panel tbody td a,table.mjs_user_panel tbody td a:visited
			{
			align:left;
			text-align:left;
			}
	
			';	

	//....................................................................................................

	if ($instance->_link_text_align<>'CSS') 
	$output.='ul.viewmjspages li
			{
			list-style-type:none;
			text-align:'.$instance->_link_text_align.';}';

	$output.='</style>'
					;

	return ($output);

	} // 	end function issue_style
	//....................................................................................................


	function start_mjs_form_and_table($instance)
	{
	//$Itemid=$this->Itemid;
	$Itemid=$instance->Itemid;
	$output='<form id="mjsUserForm" name="mjsUserForm" method="post" 
		action="index.php?option=com_myjspace&amp;task=module_command&amp;Itemid='.$Itemid.'">';
	$output.='<table cellspacing="2" cellpadding="5" width="100%" class="mjs_user_panel" border="0">';
	$output.='<td align="center">&nbsp;</td>';	
	$output.='<td align="center">&nbsp;</td>';
	$output.='<td align="center">&nbsp;</td>';
	$output.='<td align="center">&nbsp;</td>';
	$output.='<td align="center">&nbsp;</td>';
	$output.='<td align="center">&nbsp;</td>';
	return ($output);
	}

	function end_mjs_form_and_table($instance)
	{
		$output='</table>';
		$output.='</form>'; 
	return ($output);
	}



	function show_user_control_panel($instance)
	{
		// sort controls
		//............................................................................................
		$output ='<tr>';
		$output.='<td colspan="6" align="left"  class="mjs_user_panel" >';
		$output.='<input type="hidden" id="mjs_sort_order" name="mjs_sort_order" value="" />';
		$output.='<input type="hidden" id="mod_viewmjspages_order" name="mod_viewmjspages_order"  value="" />';

		$output.='<span class="mjs_captions">'.$this->speaker->speak('SortPages').'</span><br />';
		$output.='<select name="sort_order" id="sort_order" class="mjs_option" 
		onchange="var form = document.mjsUserForm; 
		form.mjs_sort_order.value=this.options[this.selectedIndex].value; 
		form.submit();" value="'.$instance->_sort_order.'" >';

		$sort_options=HTML_Mod_ViewMJSPages::get_sort_options();
		
		// posts are automaticaly set to their respective variables in myjspace
		// merely to shorten codes, it is fine to use $foo=$instance->_bar
		$p=array();
		$p[0]=$instance->_sort_order;
		$p[1]=$instance->_show_statistics;
		$p[2]=$instance->_show_legend;
		$p[3]=$instance->_show_summary;
		$p[4]=$instance->_show_top40;

		foreach($sort_options as $key=>$value) 
		{
		$output.= '<option class="mjs_options" value="';
		$output.= $key.'"';
		if ($p[0]==$key) $output.= ' selected ';
		$output.= '>';
		$output.= $value;
		$output.= '</option>'; 
		}
		$output.= '</select>';
		$output.='</td>';
		$output.='</tr>';

		// end sort pages
		//............................................................................................

		// user buttons
		//............................................................................................
		$output.='<tr>';
		$output.='<td colspan="1" class="mjs_user_panel" >';
		$output.='<input type="checkbox" size="1" id="show_statistics" name="show_statistics"  class="mjs_user_panel" ';
		if ($p[1]>0) $output.=' checked ';
		$output.='  onclick="var form=document.mjsUserForm; form.submit();"';
		$output.='  value="1" />';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('ShowStats').'</span>';
		$output.='</td>';

		$output.='<td colspan="1" class="mjs_user_panel" >';
		$output.='<input type="checkbox" size="1" id="show_legend" name="show_legend" class="mjs_user_panel" ';
		if ($p[2]>0) $output.=' checked ';
		$output.='  onclick="var form=document.mjsUserForm; form.submit();"';
		$output.='  value="1" />';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('ShowLegend').'</span>';
		$output.='</td>';

$bypass=1;
if (!$bypass)
		{
		$output.='<th colspan="1" class="mjs_user_panel" >';
		$output.='<input type="checkbox" size="1" id="_show_summary" name="_show_summary" ';
		if ($p[3]) $output.=' checked ';
		$output.='  onclick="this.value=!this.value;var form = document.mjsUserForm; form.submit();"';
		$output.='  value="'.$p[3].'" />';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('ShowSummary').'</span>';
		$output.='</th>';

		$output.='<th colspan="1" class="mjs_user_panel" >';
		$output.='<input type="checkbox" size="1" id="_show_top40" name="_show_top40" ';
		if ($p[4]) $output.=' checked ';
		$output.='  onclick="this.value=!this.value;var form = document.mjsUserForm; form.submit();"';
		$output.='  value="'.$p[4].'" />';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('ShowTop40').'</span>';
		$output.='</th>';
		}
else
		{
		$output.='<th colspan="1" class="mjs_user_panel" >';
		$output.=str_repeat('&nbsp;', 20);
		$output.='</th>';
		$output.='<th colspan="1" class="mjs_user_panel" >';
		$output.=str_repeat('&nbsp;', 20);
		$output.='</th>';
		}


		$output.='</tr>';

		// end buttons
		//............................................................................................

		$output.='<tr>';

		$output.='<th colspan="6" class="mjs_user_controls" >';
		//$output.=$this->issue_button('preview');
		//$output.=$this->issue_button('preview');
		//$output.=$this->issue_button('preview');
		//$output.=$this->issue_button('preview');
		//$output.=$this->issue_button('preview');
		//$output.=$this->issue_button('preview');
		$output.='</th>';

		$output.='</tr>';

		// search header
		$output.='<tr>';
		$output.='<td style="font-size:60%;" colspan="6" align="left">';
		$output.='<input type="text" id="mjs_search" size="20" name="mjs_search" class="mjs_search" ';  
		$output.=' value="'.$instance->_mjs_search.'" />';
		$output.='<input type="button" size="3" id="mjs_search_go" name="mjs_search_go" '; 
		$output.=' onclick="var form = document.mjsUserForm; form.submit();" ';
		$output.='value="Go" />';
		$output.='</td>';
		$output.='</tr>';

		$output.='<tr>';
		$output.='<td colspan="6" align="left">';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('search_myjspace').'</span>';
		$output.='</td>';
		$output.='</tr>';

		$output.='<tr>';
		$output.='<td colspan="6" align="left">';
		$output.='<span class=class="mjs_message">'.$instance->_message.'</span>';
		$output.='</td>';
		$output.='</tr>';

		return ($output);

	} // 	end function show_user_control_panel()
	//....................................................................................................


	function show_legend($instance)
	{
	$output='';
	//....................................................................................................
	$output.='<table cellspacing="2" cellpadding="5" width="100%" class="mjs_legend" border="0">';
	$output.='<tr>';
	$output.='<td width="15%" rowspan="2" >';
	$output.='<img width="58" height="58" alt="mjs_avatar" src="'.$instance->avatar.'" class="mjs_avatar" />';
	$output.='</td>';
	$output.='<td width="30%" ><span>Name</span></td>';
	$output.='<td width="30%" ><span>'.$this->speaker->speak('WordCount').'</span>  </td>';
	$output.='<td width="5%" ><span> '.$this->speaker->speak('OnlineStatus').'</span></td>';
	$output.='</tr>';

	$output.='<tr>';
	$output.='<td><span>'.$this->speaker->speak('Modified Date').'</span></td>';
	$output.='<td><span>'.$this->speaker->speak('UsedBytes').'  </span></td>';
	$output.='<td><span>'.$this->speaker->speak('Services').'</span></td>';
	$output.='</tr>';
	$output.='</table>';

	$output.='<span class="mjs_legend_title"> Legend </span>';

		return ($output);

	} // 	function show_legend()
	//....................................................................................................

	function messages($instance,$message)
	{
	switch ($message)
	{
	case 'found_pages':
		{
		$output=' Found '.count($instance->pages_info).' '.$this->speaker->speak('Pages');
		break;
		}
	case 'no_pages':
		{
		$output=$this->speaker->speak('NoPages');
		break;
		}
	case 'search_no_pages':
		{
		$output=$this->speaker->speak('SearchNoPagesFound');
		break;
		}
	default:
	break;
	}
		return ($output);

	} // 	function no_pages()
	//....................................................................................................

	//....................................................................................................
	function show_page_link_start($instance)
	{
	$output='';
	$output.='<tr>';
	$output.='<td colspan="6" align="left" >';
	$output.=chr(13).chr(13).'<ul class="viewmjspages'.$instance->_moduleclass_sfx.'">';
	return ($output);
	}
	//....................................................................................................
	function show_page_link_end($instance)
	{
	$output='</ul>'.chr(13).chr(13);
	$output.='</td>';
	$output.='</tr>';
	return ($output);
	}
	//....................................................................................................
	function show_page_link($mjs,$instance)
	{
	$output='<li class="item'.$mjs->pointer.'">';
	if ($mjs->pagename==$mjs->latest_page) $class='mjs_latest'; else $class='mjs_links';

	$output.='<span class="'.$class.'">';
	$output.='<a class="mainlevel'.$instance->_moduleclass_sfx.'" ';
	$output.='href="'.$mjs->url.'">';
	$output.=$mjs->pagename.'</a></span>';
	$output.='</li>';
		return ($output);

	} // 	end function show_page_link
	//....................................................................................................

	function show_page_navigation($instance)
	{
	$instance->_mjs_db_start;
	$instance->_mjs_db_limit;
	
	$output='';
	$output.='<input type="hidden" id="mjs_db_start" name="mjs_db_start" value="'.$instance->_mjs_db_start.'" />';
	$output.='<input type="hidden" id="mjs_db_limit" name="mjs_db_limit" value="'.$instance->_mjs_db_limit.'" />';

	$output='';
	$output.='<input type="hidden" id="mjs_db_total" name="mjs_db_total" value="'.$instance->_mjs_db_total.'" />';
	$output.='<input type="hidden" id="mjs_db_step" name="mjs_db_step" value="'.$instance->_mjs_db_step.'" />';

		// start with number
		//............................................................................................
		$output.='<tr>';
		$output.='<td colspan="2" align="left">';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('Start_Page').'</span><br />';
		$output.='<select name="mjs_db_start" id="mjs_db_start" style="width:70px;" class="mjs_option" 
		onchange="var form = document.mjsUserForm; 
		this.value=this.options[this.selectedIndex].value; 
		form.submit(); 
		">';

		$step=intval($instance->_mjs_db_total/10)+10;
		for ($c=0;$c<=$instance->_mjs_db_total;$c=$c+$step)
			{
			$output.= '<option class="mjs_options" value="';
			$output.= $c.'"';
			if ($c==$instance->_mjs_db_start) $output.= ' selected ';
			$output.= '>';
			$output.= $c;
			$output.= '</option>'; 
			}
		$output.= '</select>';
		$output.='</td>';

		$output.='</tr>';
		$output.='</tr>';

		// display quantity
		//............................................................................................
		$output.='<td colspan="2" align="left">';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('Max_Pages').'</span><br />';
		$output.='<select name="mjs_db_limit" id="mjs_db_limit" style="width:70px;" class="mjs_option" 
		onchange="var form = document.mjsUserForm; 
		this.value=this.options[this.selectedIndex].value; 
		form.submit(); 
		">';

		$mjs_pages_max=Array(1,5,10,20,30,50,100,200);
		$mjs_pages_max[]=$instance->_mjs_db_total;
		sort($mjs_pages_max);
		$selected=false;

		for ($c=0;$c<count($mjs_pages_max);$c++)
			{
			if (!isset($mjs_pages_max[$c])) continue;
			$output.= '<option class="mjs_options" value="';
			$output.= $mjs_pages_max[$c].'"';
			if (!$selected)
			{
			if ($mjs_pages_max[$c]>=$instance->_mjs_db_limit) 
				{
				$output.= ' selected ';
				$selected=true;
				}
			}	
			$output.= '>';
			$output.= $mjs_pages_max[$c];
			$output.= '</option>'; 
			if ($mjs_pages_max[$c]>=$instance->_mjs_db_total) break; // stop list of more than total
			}
		$output.= '</select>';
		$output.='</td>';
		$output.='</tr>';
		// end nav options
		//............................................................................................

		return ($output);

	} // 	end function show_page_navigation









	//....................................................................................................
	function mark_stats($this_mark,$instance)
	{
	if (empty($instance->_link_sort_method)) return ('class="mjs_stats" '); 

	if ( @strpos( strtolower($this_mark),strtolower($instance->_link_sort_method) )>-1 ) 
		return ('class="mjs_stats_mark" '); 
	else
		return; 
	}	
	//....................................................................................................
	


	//....................................................................................................
	function show_stats($mjs,$instance)
	{
	$output=chr(13).chr(13);
		$output.='<table cellspacing="2" cellpadding="5" width="100%" class="mjs_stats" border="0">';
		$output.='<tr>';

		$output.='<td width="20%" align="center"  valign="middle" rowspan="2" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('XX',$instance);
		$output.='>';
		$output.='<img width="58" height="58" alt="mjs_avatar" src="'.$mjs->avatar.'" class="mjs_avatar" />';
		$output.'</td>';


		$output.='<td width="30%" align="center" onmouseover=";" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('UN UNR',$instance);
		$output.='>';
		$output.='<span> '.$mjs->username.'</span>&nbsp';
		$output.='';
		$output.'</td>';

		$output.='<td width="20%"align="center" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('PS PSR',$instance);
		$output.='>';
		$output.='<span> '.$mjs->words.'</span>';
		$output.'</td>';

		$output.='<td width="5" align="center" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('XX',$instance);
		$output.='>';
		$output.='<span>&nbsp;</span>';
		$output.'</td>';

		$output.='</tr>';
		$output.='<tr>';

		$output.='<td width="30%"  align="center" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('DA DD',$instance);
		$output.='>';
		$output.='<span> '.$mjs->date.'</span>';
		$output.'</td>';

		$output.='<td width="20%"  align="center" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('UB UBR',$instance);
		$output.='>';
		$output.='<span> '.$mjs->dir_size.'</span>';
		$output.'</td>';

		$output.='<td width="5"  align="center" ';
		$output.=HTML_Mod_ViewMJSPages::mark_stats('XX',$instance);
		$output.='>';
		$output.='<span>&nbsp;</span>';
		$output.'</td>';

		$output.='</tr>';
		$output.='</table>';
		$output.=chr(13).chr(13);

		return ($output);

	} // 	end function show_stats()
	//....................................................................................................

	function issue_update($element)
	{
	// javascript for updater
	//....................................................................................................
	?>
			var form = document.mjsUserForm;
			element=document.getElementById('<?php echo $element->id; ?>');
			if (element) element.value='<?php echo $element->value; ?>';
		  	</script>
	<?php	
	} // end issue update
	//....................................................................................................


	function issue_button($button_function)
	{
	// issue user command buttons
	//....................................................................................................
	$adminindex='index.php';
	$Itemid=$this->Itemid;
	?>
			<!-- issue buttons for client -->
		  	<script language="javascript" type="text/javascript">
			function submitbutton(pressbutton) 
				{
				var form = document.mjsUserForm;
				if (pressbutton=='save') form.submit();
				if (pressbutton=='back') history.go(-1);
				if (pressbutton=='cancel') 
				{
				url='<?php echo $adminindex; ?>?option=com_myjspace&amp;task=module_command&amp;Itemid=<?php echo $Itemid; ?>';
				location.href=(url);
				}

				return;
				}

			function setgood(){ document.adminForm.goodexit.value=1; }
		  	</script>

			<?php 
			switch ($button_function)
			{
			case 'upload': 
			$image='upload_f2.png';
			break;

			case 'new': 
			$image='new_f2.png';
			break;

			case 'apply': 
			$image='apply_f2.png';
			break;

			case 'back': 
			$image='back_f2.png';
			break;

			case 'html': 
			$image='html_f2.png';
			break;

			case 'preview': 
			$image='preview_f2.png';
			break;

			default:
			$image='archive_f2.png';
			break;
			}
			?>
			<a class="mjs_buttons" href="javascript:submitbutton('<?php echo $button_function; ?>');" >
			<img src="<?php echo $this->imagepath.$image; ?>"  alt="<?php echo $button_function; ?>" name="<?php echo $button_function; ?>_img" 
			title="<?php echo $button_function; ?>" align="middle" border="0" />
			<?php //echo ucfirst(strtolower($button_function)); 
			?>
			</a>

	<?php	
	} // end issue button
	//....................................................................................................

	//'PT'=>'by Page Title','PH'=>'by Page Hits','PS'=>'by Page Size ( word count )','UB'=>'by Used Bytes ( capacity )'

	function get_sort_options()
	{
	$options=array(
	'DA'=>'by Latest First','DD'=>'by Latest Last','UN'=>'by Username A->Z','UNR'=>'by Username Z->A',
	'PT'=>'by Page Title','PTR'=>'by Page Title (R)','PS'=>'by Page Size ( words )','PSR'=>'by Page Size (R)',
	'UB'=>'by Used Bytes ( capacity )','UBR'=>'by Used Bytes (R)'
	);
	return($options);
	}

	function set_resource_paths()
	{
	parent::set_resource_paths();
	} // end set_resource_paths()

	function init()
	{
	//HTML_Mod_ViewMJSPages::set_resource_paths();
	$config=parent::get_default();
	$this->Itemid=$config->itemid;
	$this->joomla_images=parent::get_resource_paths('joomla_images');
	$this->joomla_admin_images=parent::get_resource_paths('joomla_admin_images');
	}

} // end class HTML_Mod_ViewMJSPages extends MJS_Mod_ViewMJSPages

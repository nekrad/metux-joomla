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



class HTML_mod_mjs_list_pages extends mod_mjs_list_pages
{
var	$user=0;
var	$speaker;
var $FORM_ID;

	function HTML_mod_mjs_list_pages() 
	{
	//.......................................................................................................................................................................
	global $mainframe,$database,$mosConfig_absolute_path,$mosConfig_live_site;
	global $db,$user,$id;
	$this->speaker = new MJS_Com_Vocabulary;
	//parent::init();
	$this->init();

	include_once( dirname(__FILE__).DS.'mod_mjs_list_pages'.DS.'myJSpace_JavaScript_Library.js' );
	//.......................................................................................................................................................................
	} // end HTML_mod_mjs_list_pages



	function issue_style($instance)
	{
	// issue module styles specified in /modules/mod_mjs_list_pages/mod_mjs_list_pages.css ( instead of template styles )
	//....................................................................................................
	$output='
		<link rel="stylesheet" type="text/css" href="'.$this->live_site.'/modules/mod_mjs_list_pages/mod_mjs_list_pages.css" />
			';	
	return ($output);

	} // 	end function issue_style
	//....................................................................................................



	function show_stats($mjs,$instance)
	{
	$output=chr(13).chr(13);
		$output.='<table cellspacing="2" cellpadding="5" width="100%" class="mjs_stats" border="0">';
		$output.='<tr>';

		$output.='<td width="20%" align="center"  valign="middle" rowspan="2" ';
		$output.='>';
		$output.='<img width="58" height="58" alt="mjs_avatar" src="'.$mjs->avatar.'" class="mjs_avatar" />';
		$output.'</td>';


		$output.='<td width="30%" align="center" onmouseover=";" ';
		$output.='>';
		$output.='<span> '.$mjs->username.'</span>&nbsp;';
		$output.='';
		$output.'</td>';

		$output.='<td width="20%"align="center" ';
		$output.='>';
		$output.='<span> '.$mjs->words.'</span>';
		$output.'</td>';

		$output.='<td width="5" align="center" ';
		$output.='>';
		$output.='<span>&nbsp;</span>';
		$output.'</td>';

		$output.='</tr>';
		$output.='<tr>';

		$output.='<td width="30%"  align="center" ';
		$output.='>';
		$output.='<span> '.$mjs->date.'</span>';
		$output.'</td>';

		$output.='<td width="20%"  align="center" ';
		$output.='>';
		$output.='<span> '.$mjs->dir_size.'</span>';
		$output.'</td>';

		$output.='<td width="5"  align="center" ';
		$output.='>';
		$output.='<span>&nbsp;</span>';
		$output.'</td>';

		$output.='</tr>';
		$output.='</table>';
		$output.=chr(13).chr(13);

		return ($output);

	} // 	end function show_stats()
	//....................................................................................................


	function start_mjs_form_and_table($instance)
	{
	$Itemid=$this->itemid;

	$output='';
	$output.='<form id="'.$this->FORM_ID.'" name="'.$this->FORM_ID.'" method="post" 
	action="index.php?option=com_myjspace&amp;task=module_command&amp;Itemid='.$Itemid.'">';
	return ($output);
	}

	function end_mjs_form_and_table($instance)
	{
	$output='';
	$output.='</form>'; 
	return ($output);
	}


	function show_user_control_panel($instance)
	{
		// sort controls
		//............................................................................................
		$output ='';
		$output.='<br />';
		$output.='<input type="hidden" id="mjs_sort_order" name="mjs_sort_order" value="" />';
		$output.='<input type="hidden" id="mod_mjs_list_pages_order" name="mod_mjs_list_pages_order"  value="" />';

		$output.='<span class="mjs_captions">'.$this->speaker->speak('SortPages').'</span><br />';
		$output.='<select name="sort_order" id="sort_order" class="mjs_option" ';
		$output.='onchange="var form = document.getElementById(';
		$output.="'".$this->FORM_ID."');";
		$output.='form.mjs_sort_order.value=this.options[this.selectedIndex].value; 
		form.submit();" value="'.$instance->_sort_order.'" >';

		$sort_options=HTML_mod_mjs_list_pages::get_sort_options();
		
		// posts are automaticaly set to their respective variables in myjspace
		// merely to shorten codes, it is fine to use $foo=$instance->_bar
		$p=array();
		$p[0]=$instance->_sort_order;
		$p[1]=$instance->_show_statistics;
		$p[2]=$instance->_show_summary;


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
		$output.='<br />';

		// end sort pages
		//............................................................................................

		$output.='<br />';

		// search header
		$output.='<input type="text" id="mjs_search" size="20" name="mjs_search" class="mjs_search" ';  
		$output.=' value="'.$instance->_mjs_search.'" />';
		$output.='<input type="button" size="3" id="mjs_search_go" name="mjs_search_go" '; 
		$output.=' onclick="var form = document.getElementById(\''.$this->FORM_ID.'\'); form.submit();" ';
		$output.='value="Go" />';

		$output.='<span class="mjs_captions">'.$this->speaker->speak('search_myjspace').'</span>';
		$output.='<br />';

		$output.='<span class=class="mjs_message">'.$instance->_message.'</span>';
		$output.='<br />';

		return ($output);

	} // 	end function show_user_control_panel()
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
	$output.=chr(13).chr(13).'<li>';
	return ($output);
	}
	//....................................................................................................
	function show_page_link_end($instance)
	{
	$output='</li>'.chr(13).chr(13);
	return ($output);
	}
	//....................................................................................................
	function show_page_link($mjs,$instance)
	{
	if ($mjs->pagename==$mjs->latest_page) $class='mjs_latest'; else $class='mjs_links';

	$output='';
	$output.='<span class="'.$class.'">';
	$output.='<a class="mainlevel'.$instance->_moduleclass_sfx.'" ';
	$output.='href="'.$mjs->url.'">';
	$output.=$mjs->pagename.'</a></span>';

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
	$output.='<input type="hidden" id="mjs_db_total" name="mjs_db_total" value="'.$instance->_mjs_db_total.'" />';
	$output.='<input type="hidden" id="mjs_db_step" name="mjs_db_step" value="'.$instance->_mjs_db_step.'" />';

		// start with number
		//............................................................................................
		$output.='<span class="mjs_captions">'.$this->speaker->speak('Start_Page').'</span><br />';
		$output.='<select name="mjs_db_start" id="mjs_db_start" style="width:70px;" class="mjs_option" ';
		$output.=' onchange="var form = document.getElementById(\''.$this->FORM_ID.'\');
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

		// display quantity
		//............................................................................................
		$output.='<br />';
		$output.='<span class="mjs_captions">'.$this->speaker->speak('Max_Pages').'</span><br />';
		$output.='<select name="mjs_db_limit" id="mjs_db_limit" style="width:70px;" class="mjs_option" ';
		$output.=' onchange="var form = document.getElementById(\''.$this->FORM_ID.'\');
		this.value=this.options[this.selectedIndex].value; 
		form.submit(); 
		">';

		$mjs_pages_max=Array(1,5,10,20,30,50,100,200,500,1000);
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
		$output.='<br />';
		$output.='<br />';

		// end nav options
		//............................................................................................

		return ($output);

	} // 	end function show_page_navigation



	function issue_update($element)
	{
	// javascript for updater
	//....................................................................................................
	?>
			var form = document.getElementById(\'<?php echo $this->FORM_ID; ?>\'); 
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
	$Itemid=$this->itemid;
	?>
			<!-- issue buttons for client -->
		  	<script language="javascript" type="text/javascript">
			function submitbutton(pressbutton) 
				{
				var form = document.getElementById(\'<?php echo $this->FORM_ID; ?>\'); 
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
	$config=parent::get_default();
	if (isset($config->itemid)) 
			$Itemid=$config->itemid; 
	else 
			$Itemid=@$_GET['Itemid'];
	
	$this->itemid=intval($Itemid);

	// force itemid to current itemid
	//$this->itemid=intval(@$_GET['Itemid']);

	$this->joomla_images=parent::get_resource_paths('joomla_images');
	$this->joomla_admin_images=parent::get_resource_paths('joomla_admin_images');

	//$FORM_ID=md5(uniqid(rand(), true));
	$this->FORM_ID=md5(uniqid(rand(), true));

	}

} // end class HTML_mod_mjs_list_pages extends mod_mjs_list_pages

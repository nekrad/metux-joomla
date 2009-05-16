<?php
/*
Package myJSpace
Copyright 2008 D'Abronzo Vincenzo/ ~ jalil ~ All rights reserved.
Lcense GNU / GPL
Author D'Abronzo Vincenzo
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
1.Date Format -> http://www.saqqara.demon.co.uk/datefmt.htm
Purpose - ISO Date Format for easy use and standardisation.
*/

// no direct access
defined( '_MJSEXEC' ) or die( 'Restricted access' );

// top level error control - use error_reporting(0) for live sites
error_reporting(E_ALL);
error_reporting(0);

	// Standard J1-J5 Coverter Inclusion ~ jalil ~ June 2008
	//.........................................................
		if (constant('_J1'))
		{
		global $mainframe,$database,$mosConfig_absolute_path,$mosConfig_live_site;
		$db=$database;
		}
		else if (constant('_J5'))
		{
			// Get Paths
			$mosConfig_absolute_path = JPATH_SITE;	// Get root directory
			$mosConfig_live_site=JURI::root();
			$db = &JFactory::getDBO();
			$database=$db;
		}
	//.........................................................

// load language vocabulary
require_once( $mosConfig_absolute_path.DS."components".DS."com_myjspace".DS.'myjspace.com.vocabulary.php' );

class MJS_Mod_ViewMJSPages
{
	var $verbose;
	var $speaker;

	var $foldername;
	var $pages = array();
	var $pages_info = array();
	var $original_pages_info = array();
	var $parameters;
	var $_number_of_links;
	var $_start_link_number;
	var $_show_diagnostics=0;
	var $_show_user_control_panel=1;
	var $_show_statistics=0;
	var $_show_legend=0;
	var $_show_summary=0;
	var $_show_top40=0;
	var $_sort_order;
	var $_mjs_search;
	var $_message;

	var $_link_text_align;
	var $_period;
	var $_fixed_Itemid;
	var $_use_this_style;
	var $_datetime_format;
	var $_moduleclass_sfx;

	var $db;
	var $user	= null;
	var $Itemid = 0;
	var $id	= 0;
	var $pageid	= 0;
	var $userid	= 0;
	var $joomla_images;
	var $joomla_admin_images;
	var $mjs_directory;
	var $mjs_resources;
	var $message_dispatched=false;

	var $_mjs_db_step=50;
	var $_mjs_db_start=0;
	var $_mjs_db_total=10;
	var $_mjs_db_limit=50;
	var $_mjs_user_db_start=0;
	var $_mjs_db_start_select;
	var $_mjs_pages_max=50;

	var $live_site;
	var $absolute_path;
	var $resourcepath;
	var $imagepath;


	var $html;
	var $html_buffer;
	var $update_varnames=array();

	function MJS_Mod_ViewMJSPages() 
	{
	//.......................................................................................................................................................................
	global $mainframe,$database,$mosConfig_absolute_path,$mosConfig_live_site;
	global $db,$user,$Itemid,$id;
	$this->init();
	//.......................................................................................................................................................................
	} // function MJS_Mod_ViewMJSPages

	//.........................................................
	function sort_pages_info($t_carrier) 	
	//.........................................................
	{
	$this->pages_info=$this->original_pages_info;
		$holder=Array(); reset($t_carrier);
		foreach ($t_carrier as $key=>$value)
		{
			$holder[]=$this->pages_info[$key];
		}
		$this->pages_info=$holder;
	} // end sort page_info	
	//.........................................................

	//.........................................................
	function naturalsort($t_carrier) 	
	//.........................................................
	{
//print_r($this);
		natcasesort($t_carrier);
		//$this->sort_pages_info($t_carrier); 	
	} 
	//.........................................................

	function rnaturalsort($t_carrier) 	
	//.........................................................
	{
		natcasesort($t_carrier);
		$this->sort_pages_info($t_carrier); 	
	} 
	//.........................................................

	//.........................................................
	function strsort($t_carrier) 	
	//.........................................................
	{
		asort($t_carrier,SORT_STRING);
		$this->sort_pages_info($t_carrier); 	
	} 
	//.........................................................

	//.........................................................
	function numsort($t_carrier) 	
	//.........................................................
	{
		asort($t_carrier,SORT_NUMERIC);
		$this->sort_pages_info($t_carrier); 	
	} 
	//.........................................................

	//.........................................................
	function rnumsort($t_carrier) 	
	//.........................................................
	{
		arsort($t_carrier,SORT_NUMERIC);
		$this->sort_pages_info($t_carrier); 	
	} 
	//.........................................................


	function show() 
	{
error_reporting(0);
	// if you are in a hurry to see where the codes are for show, find ->show time
	if ($this->_show_diagnostics>0) 
		{
		$this->verbose=1;
		}

	if ($this->_use_this_style)
		{
		$output=$this->html->issue_style($this);
		echo $output;
		}


	//.......................................................................................................................................................................
		if( !$this->loadConfig() ) 
			{
			echo $this->speaker->speak('errloadconfig');
			return;
			}	

		$this->_mjs_db_total=intval($this->_mjs_db_total);
		$this->_mjs_db_start=intval($this->_mjs_db_start);
		$this->_mjs_db_limit=intval($this->_mjs_db_limit);

		// safety nets
		if ($this->_mjs_db_total<1) $this->_mjs_db_total=$this->countPages();
		if ( ($this->_mjs_db_limit<1 OR $this->_mjs_db_limit>$this->_mjs_db_total) AND (empty($this->_mjs_search)) ) 
		{	$this->_mjs_db_limit=$this->_mjs_db_total; }
		if ($this->_mjs_db_limit>500) $this->_mjs_db_limit=500;
		if ($this->_mjs_db_start>$this->_mjs_db_total) $this->_mjs_db_start=0;
		// safety nets

		if ($this->_mjs_db_total>=0) 
		{
			if ( !$this->loadPages() ) //  load the whole db
			//if ( !$this->loadPages_limited($this->_mjs_db_start,$this->_mjs_db_limit) )
				{
				$this->_message=$this->html->messages($this,'search_no_pages');
				} 
		} // end if (this->_mjs_db_total>=0) 

	//.......................................................................................................................................................................

		$this->original_pages_info=$this->pages_info;

		//start output
		$output = $this->html->start_mjs_form_and_table($this);

		// navigator
		$output.= $this->html->show_page_navigation($this);

		// PERFORM SEARCH / FILTER
		//........................................................
		if (!empty($this->_mjs_search)) 
		{
		$this->pages_info=array();		
		foreach ($this->original_pages_info as $key=>$page)
		{ 
			if ( strpos($page->content,$this->_mjs_search)>-1 ) 
			{
			$this->pages_info[]=$page; 
			}
		}

		// if no pages alert user
		if (count($this->pages_info)<1) 
			$this->_message=$this->html->messages($this,'search_no_pages');
		else 
			$this->_message=$this->html->messages($this,'found_pages');

		// tell module message has been set and switch on stats
		// set original pages to only searched pages

		$this->set_message_dispatched();
		//$this->_show_statistics=1;   // no, let user choose

		$this->original_pages_info=$this->pages_info;

 		} // if !empty this->_mjs_search 
		//........................................................


		// USER CONTROL PANEL
		if ($this->_show_user_control_panel>0) 
		{
		$output.= $this->html->show_user_control_panel($this);
		} // if _show_user_control_panel 

		// USER LEGEND
		if ($this->_show_legend>0) 
					{
					$this->avatar=$this->resourcepath.'/avatar.png'; 
					$output.= $this->html->show_legend($this);
					$this->avatar=null;
					} // if (this->_show_legend) 



		// SORT
		//.............................................................................
		if (count($this->pages_info)>0)
		{
		// do a little bit of running for the stats.
		// $t_x holds temporary values for sorting purposes
		//.............................................................................

			$t_filemtime=Array();
			$t_content_words=Array();
			$t_content_chars=Array();
			$t_dir_size=Array();
			$t_username=Array();
			$t_pagename=Array();

			while (current($this->pages_info))
			{
				$key=key($this->pages_info);
				$page=current($this->pages_info);
				$path=$this->absolute_path.DS.$this->foldername.DS.$page->pagename;
				$index=$path.DS.'index.php';

				if (file_exists($index)) $t_filemtime[]=filemtime($index);
				else $t_filemtime[]=0;

				$t_content_words[]=str_word_count ($page->content);
				$t_content_chars[]=strlen($page->content);
				$t_username[]=strtolower($page->username);
				$t_pagename[]=$page->pagename;

				if (is_dir($path)) $dsize=$this->getDirectorySize($path); else $dsize['size']=0;
				$t_dir_size[]=$this->sizeFormat($dsize['size']);
				next($this->pages_info);		
			}

			// GET LATEST PAGE for marking
			$this->naturalsort($t_filemtime);
			$latest_page=end($this->pages_info);
			$latest_page=$latest_page->pagename;

			//...........................................................................

			switch ($this->_sort_order)
			{
			case 'DD':
			$this->numsort($t_filemtime);
			break;

			case 'PT':
			$this->naturalsort($t_pagename);
			break;

			case 'PTR':
			$this->rnaturalsort($t_pagename);
			break;

			case 'PS':
			$this->numsort($t_content_words);
			break;

			case 'PSR':
			$this->rnumsort($t_content_words);
			break;

			case 'UN':
			$this->naturalsort($t_username);
			break;

			case 'UNR':
			$this->rnaturalsort($t_username);
			break;

			case 'PH':
			echo 'Page Hits not in this version';
			//$this->numsort($t_hits);
			break;

			case 'PHR':
			echo 'Page Hits not in this version';
			//$this->rnumsort($t_hits);
			break;

			case 'UB':
			$this->naturalsort($t_dir_size);
			break;

			case 'UBR':
			$this->rnaturalsort($t_dir_size);
			break;

			default:
			case 'DA':
			$this->rnumsort($t_filemtime);
			break;
			}

			//.................................................................................................
			// boudary limits
			$this->_number_of_links		=$this->_mjs_db_limit;
			$this->_start_link_number	=intval($this->_mjs_db_start);
			
			// boudary check LWM
			if ($this->_start_link_number<0) $this->_start_link_number=0;
			if ($this->_start_link_number>count($this->pages_info)) 
				{
				$this->_start_link_number=0;
				$this->_mjs_db_start=0;
				$this->update_queue('mjs_db_start');
				}

			//.........................................................
			// boudary check HWM
			if ($this->_number_of_links>count($this->pages_info)) $this->_number_of_links=count($this->pages_info);
			$HWM=$this->_start_link_number+$this->_number_of_links;
			if ($HWM>$this->_number_of_links) $hwm=$this->_number_of_links;

		//$instance->_mjs_db_total;
		//$instance->_mjs_db_step;

			//.................................................................................................

		} // end if count(this-> pages info>0)

		// show time
		//................................................................


		// USER PAGES
		// list pages normal according to sorted order or search criteria/filters
		if (count($this->pages_info)>0) 
		{
			for($i=$this->_start_link_number; $i<$HWM; $i++) 
			{

			// check that user page is available
			if (!isset($this->pages_info[$i])) continue;

			// assign to object mjs
			$mjs=$this->pages_info[$i];
			$mjs->pagename=stripslashes(trim($mjs->pagename));

			// MAIN USER PAGE INFO BODY

			$output.=  $this->html->show_page_link_start($this);

			$mjs->url=$this->live_site.'/'.$this->foldername.'/'.$mjs->pagename;
			$mjs->index=$this->absolute_path.DS.$this->foldername.DS.$mjs->pagename.DS.'index.php';
			$avatar=$this->absolute_path.DS.$this->foldername.DS.$mjs->pagename.DS.'avatar.png';
			if (file_exists($avatar))
				{ $mjs->avatar=$this->mjs_directory.'/avatar.png'; }
			else 
				{ $mjs->avatar=$this->resourcepath.'/avatar.png'; }
			$mjs->latest_page=$latest_page;
			$mjs->pointer=$i;

			$output.= $this->html->show_page_link($mjs,$this);
			$output.= $this->html->show_page_link_end($this);

			// END MAIN USER PAGE INFO BODY



		// USER STATISTICS
		if ($this->_show_statistics>0) 
			{
			//................................................................
			// * STATISTICS DEPARTMENT
			// prepare stats
			$mjs->dir_size=$t_dir_size[$i];
			$mjs->words=str_word_count($mjs->content);
			$mjs->date=Date($this->_datetime_format,@filemtime($mjs->index));
			$output.=  $this->html->show_stats($mjs,$this);
			//................................................................
			} // if (this->_show_statistics) 
			// * END STATISTICS DEPARTMENT


	} // end links list

	} // if (number_of_pages>0) 

	 else 
		{
		if (!$this->message_dispatched)
			{
			$output.=$this->html->messages($this,'no_pages');
			$this->reset_message_dispatched();
			}
		}
	

	// end output
	$output.= $this->html->end_mjs_form_and_table($this);
	echo $output; // print 
	$output=null; // destroy output
	$this->update_client_display();

	} // 	end function show() 
	//.......................................................................................................................................................................	



	/*
	this function sends a java script to client to update value when program need sort adjust them to be within 
	operating limit and thus need to be reflected to the client
	*/
	//.........................................................
	function update_client_display() {
	//.........................................................
	foreach ($this->update_varnames as $key=>$name)
	{ 
	$element=new stdClass;
	$element->id=$name;
	eval('$element->value=$this->_'.$name.';');
	$this->html->issue_update($element);
	}
	} // 	end update_client_display()
	//.........................................................

	/*
	this function puts objects/elements to be updated in an internal queue
	*/
	//.........................................................
	function update_queue($varname) {
	//.........................................................
	$this->update_varnames[]=$varname;
	} // 	end update client
	//.........................................................



	/*
	when a message is despatched, this flag will be raised so that other functions will be aware that a message
	has been booked into the message box of view_myjspace module and therefore should avoid congesting it.
	this flag will be lowered after delivery
	*/
	//.........................................................
	function set_message_dispatched() {
	//.........................................................
	$this->message_dispatched=true;
	} // 	set_message_dispatch 
	//.........................................................

	/*
	when a message is despatched, this flag will be raised so that other functions will be aware that a message
	has been booked into the message box of view_myjspace module and therefore should avoid congesting it.
	this flag will be lowered after delivery
	*/
	//.........................................................
	function reset_message_dispatched() {
	//.........................................................
	$this->message_dispatched=false;
	} // 	set_message_dispatch 
	//.........................................................


//.......................................................................................................................................................................
// loaders

	/*
	get default reads myjspace default configuration from SQL ( usuauly table jos_myjspace_cfg)
	and returns an object with properties

	object->foldername
	object->templatename
	object->itemid

		which are myjspace configuration properties
	*/
	//.........................................................
	function get_default() 	{
	//.........................................................
	$db=$this->db;
	$query = "SELECT * FROM #__mjs_config";
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	if (empty($rows)) return;

	$default=$rows[0];
	if (isset($default))
	{
	$default->foldername=stripslashes($default->foldername);
	}

	return($default);
	} // is_default_template
	//.......



	function loadConfig() {
	$db=$this->db;
		$query = "SELECT * FROM #__mjs_config";
		$db->setQuery($query);
		$result_set = $db->loadObjectList();
		if( $result_set != null ) {
			foreach( $result_set as $result) {
				$this->foldername = stripslashes($result->foldername);
			}
			return 1;
		}
		return 0;		
	} //
	//.......


	function countPages() 
	{
	$db=$this->db;
		$query = "SELECT COUNT(*) FROM #__myjspace";
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	} //
	//.......

	function loadPages() 
	{
	$db=$this->db;
		$query = "SELECT * FROM #__myjspace mjs LEFT JOIN #__users jos ON mjs.id=jos.id";
		$db->setQuery($query);
		$result_set = $db->loadObjectList();
		if( $result_set != null ) {
			$i = 0;
			foreach( $result_set as $result) {
				$this->pages[] = $result->pagename;
				$this->pages_info[] = $result;
				$i++;
			}
			return $i;
		}
		return 0;
	} //
	//.......

	function loadPages_limited($start,$limit) 
	{
	$db=$this->db;
		$query = "SELECT * FROM #__myjspace mjs LEFT JOIN #__users jos ON mjs.id=jos.id ";
		$query.= "LIMIT ".$start.",".$limit;
		$db->setQuery($query);
		$result_set = $db->loadObjectList();
		if( $result_set != null ) {
			$i = 0;
			foreach( $result_set as $result) {
				$this->pages[] = $result->pagename;
				$this->pages_info[] = $result;
				$i++;
			}
			return $i;
		}
		return 0;
	} //
	//.......
//.......................................................................................................................................................................


//.......................................................................................................................................................................
	function setDatabase($db) 
	{
		$this->db = $db;
	}

	function setHTML($object) 
	{
	$this->html=$object;
	}

	function setParams($parameters) 
	{
	$this->parameters=$parameters;	
	$class_vars = get_class_vars(get_class($this));
	foreach ($class_vars as $name => $value) 
		{
			if (substr($name,0,1)<>'_') continue;
			$parameter=substr($name,1,strlen($name));
			$var='$this->'.$name;
			$get='$parameters->get("'.$parameter.'")';
			eval($var.' = '.$get.';');
		}
	}// end set params
	//..............................................................

	function getPostsSetVars($post_vars) 
	{
	// can set security here
	$this->setVars($post_vars);
	}// end set posts
	//..............................................................

	function setVars($post_vars)
	{
	$class_vars = get_class_vars(get_class($this));
	foreach ($class_vars as $name => $value) 
		{
			if (substr($name,0,1)<>'_') continue;
			$post_var=substr($name,1,strlen($name));
			eval('$a=isset($post_vars["'.$post_var.'"]);'); 	// scan for name
			if ($a) 
			{
				$var='$this->'.$name;
				$x=$var.'=$post_vars["'.$post_var.'"];';
				//echo $x.'<br />'; 
				eval($var.'=$post_vars["'.$post_var.'"];');
			}
		}

	$this->AdjustVars();
	$post_vars=null;
	}// end set posted Vars
	//..............................................................

	// Resets selective vars
	function AdjustVars()
	{
	}// end set posted Vars
	//..............................................................



















//.......................................................................................................................................................................


/*------------------------------------------------------------------------
function getDirectorySize
FROM http://www.go4expert.com/forums/showthread.php?t=290
Examle
	$path="/httpd/html/pradeep/"; 
	$ar=getDirectorySize($path); 
	echo "<h4>Details for the path : $path</h4>"; 
	echo "Total size : ".sizeFormat($ar['size'])."<br>"; 
	echo "No. of files : ".$ar['count']."<br>"; 
	echo "No. of directories : ".$ar['dircount']."<br>"; 
*------------------------------------------------------------------------*/

function getDirectorySize($path) 
{ 
  $totalsize = 0; 
  $totalcount = 0; 
  $dircount = 0; 
  if ($handle = opendir ($path)) 
  { 
    while (false !== ($file = readdir($handle))) 
    { 
      $nextpath = $path . '/' . $file; 
      if ($file != '.' && $file != '..' && !is_link ($nextpath)) 
      { 
        if (is_dir ($nextpath)) 
        { 
          $dircount++; 
          $result = $this->getDirectorySize($nextpath); 
          $totalsize += $result['size']; 
          $totalcount += $result['count']; 
          $dircount += $result['dircount']; 
        } 
        elseif (is_file ($nextpath)) 
        { 
          $totalsize += filesize ($nextpath); 
          $totalcount++; 
        } 
      } 
    } 
  } 
  closedir ($handle); 
  $total['size'] = $totalsize; 
  $total['count'] = $totalcount; 
  $total['dircount'] = $dircount; 
  return $total; 
} // end getDirectorySize
//.......................................................................................

function sizeFormat($size) 
{ 
    if($size<1024) 
    { 
        return $size." bytes"; 
    } 
    else if($size<(1024*1024)) 
    { 
        $size=round($size/1024,1); 
        return $size." KB"; 
    } 
    else if($size<(1024*1024*1024)) 
    { 
        $size=round($size/(1024*1024),1); 
        return $size." MB"; 
    } 
    else 
    { 
        $size=round($size/(1024*1024*1024),1); 
        return $size." GB"; 
    } 
 
} // end sizeFormat
//.......................................................................................................................................................................


function get_resource_paths($name)
{
global $mosConfig_live_site;
eval('$a=$this->'.$name.';');
if ($a)  return $a; else return 'none';
}

function set_resource_paths()
{
global $mosConfig_live_site;
$this->resourcepath=$mosConfig_live_site.'/components/com_myjspace/resources/';
$this->imagepath=$mosConfig_live_site.'/images/';

$this->mjs_directory=$this->live_site.'/'.$this->foldername;
$this->joomla_images=$this->live_site.'/images';
$this->joomla_admin_images=$this->live_site.'/administrator/images';
}

function getItemid()
{
return ($this->Itemid);
}

function init()
{
//.......................................................................................................................................................................
// Standard J1-J5 Coverter Inclusion ~ jalil ~ June 2008
//.........................................................
global $mainframe,$database,$mosConfig_absolute_path,$mosConfig_live_site;
global $db,$user,$Itemid,$id;

	if (constant('_J1'))
	{
	$db=$database;
	}
	else if (constant('_J5'))
	{
		// Get Paths
		$mosConfig_absolute_path = JPATH_SITE;	// Get root directory
		$mosConfig_live_site=JURI::root();
		$db = &JFactory::getDBO();
		$database=$db;
	}
//.........................................................

/* Set version specific variables - userid   */

	if (constant('_J1'))
		{
		$user=$mainframe->getUser();
		} 
	else if (constant('_J5'))
		{
		$user =& JFactory::getUser(); // Get user id
		}

/* Set version specific variables -Itemid Handling   */

$this->db=$db;
$config=$this->get_default();

if (isset($config->itemid)) $Itemid=$config->itemid; else $Itemid=@$_GET['Itemid'];

//echo 'Itemid='.$Itemid;
/* End Itemid Handling   */

/* Set version specific variables - user id, page id */
//---------------------------------------------
if (constant('_J1'))
{
      	$id  = intval( mosGetParam( $_REQUEST, 'id', 0 ) );
      	$pageid  = intval( mosGetParam( $_REQUEST, 'pageid', 0 ) );
}
else if (constant('_J5'))
{
$id = JRequest::getInt( 'id');	
$pageid  = JRequest::getInt( 'pageid');	
}

$this->live_site=$mosConfig_live_site;
$this->absolute_path=$mosConfig_absolute_path;
$this->db=$db;	
$this->id=$id;	
$this->pageid=$pageid;	
$this->userid=@intval($user->id); // Get user id
$this->Itemid=$Itemid;
error_reporting(E_ALL);
$this->speaker = new MJS_Com_Vocabulary;
$this->set_resource_paths();
} // end init
//.......................................................................................................................................................................



}  // end class MJS_Mod_ViewMJSPages 


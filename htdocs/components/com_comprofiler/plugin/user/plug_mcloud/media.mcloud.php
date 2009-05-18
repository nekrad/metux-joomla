<?php
/**
* Shows media from the mediacloud service
* @package Community Builder
* @subpackage media.mcloud.php
* @author Enrico Weigelt, metux IT service
* @copyright (C) metux IT service, www.metux.de
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_PLUGINS->registerFunction( 'onAfterDeleteUser', 'userDeleted','getMCloudMediaTab' );

// import the mediacloud config
// FIXME: should check whether com_mcloud is installed !
ini_set('include_path', ini_get('include_path').':'.JPATH_SITE);

require_once('mcloud-client.conf.php');
ini_set('include_path', ini_get('include_path').':'.MEDIACLOUD_CLASSES);

require_once('MC_ClientHelper.class.php');
require_once('MC_RemoteClient.class.php');
require_once(JPATH_SITE.'/components/com_mcloud/source/MCloud_URL.class.php');

/**
* Connections Tab Class for handling the Connections List CB tab (other parts are still in core CB)
* @package Community Builder
* @subpackage Connections CB core module
* @author JoomlaJoe and Beat
*/
class getMCloudMediaTab extends cbTabHandler 
{
	var $userNumberOfConnections	= null;
	var $remoteclient;

	/**
	* Constructor
	*/
	function getMCloudMediaTab() 
	{
		$this->cbTabHandler();
		$this->remoteclient = new MC_RemoteClient(array(
		    'namespace'	=> MEDIACLOUD_SRV_NAMESPACE,
		    'prefix'	=> MEDIACLOUD_SRV_PREFIX,
		    'secret'	=> MEDIACLOUD_SRV_SECRET
		));
		$this->lang = JFactory::getLanguage();
		$this->lang->load('com_mcloud');
		$this->strings = $this->lang->_strings;
		$this->urlrender = new MCloud_URL();
	}

	function medium_url($medium_id)
	{
	    global $mosConfig_live_site;
	    return $mosConfig_live_site."/index.php?option=com_mcloud&view=medium-show&Itemid=178&medium_id=".$medium_id;
	}

	function group_url($group_id)
	{
	    global $mosConfig_live_site;
	    return $mosConfig_live_site."/index.php?option=com_mcloud&view=groupshow&Itemid=178&group_id=".$group_id;
	}

	/**
	* Generates the menu and user status to display on the user profile by calling back $this->addMenu
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns boolean : either true, or false if ErrorMSG generated
	*/
	function getMenuAndStatus($tab,$user,$ui) 
	{
		global $database, $ueConfig;

		$params				=	$this->params;
		$con_StatDisplay	=	$params->get('con_StatDisplay', '1');
		
		if ( $ueConfig['allowConnections'] && $con_StatDisplay ) {
			//------------------- User Status items for User Status Window:
			// Connections:
			$contotal		=	0;
			
			$mi = array(); $mi["_UE_MENU_STATUS"]["_UE_CONNECTION"]["_UE_CONNECTION"]=null;
			$dat			=	cbFormatDate($user->registerDate);
			if ( ! $dat ) {
				$dat		=	"?";
			}
			$this->addMenu( array(	"position"	=> "menuList" ,		// "menuBar", "menuList"
										"arrayPos"	=> $mi ,
										"caption"	=> $contotal ,
										"url"		=> "" ,		// can also be "<a ....>" or "javascript:void(0)" or ""
										"target"	=> "" ,	// e.g. "_blank"
										"img"		=> null ,	// e.g. "<img src='plugins/user/myplugin/images/icon.gif' width='16' height='16' alt='' />"
										"alt"		=> null ,	// e.g. "text"
										"tooltip"	=> null ,
										"keystroke"	=> null ) );	// e.g. "P"
		}
		return true;
	}

	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) 
	{
		global $database, $ueConfig, $my;
		$return=null;

		if(!$ueConfig['allowConnections'] || (isset($ueConfig['connectionDisplay']) && $ueConfig['connectionDisplay']==1 && $my->id!=$user->id)) {
			return null;
		}
		$params		        = $this->params;
		$con_ShowSummary	= $params->get( 'con_ShowSummary',	'0' );
		$con_SummaryEntries	= $params->get( 'con_SummaryEntries',	'4' );
		$con_pagingenabled	= $params->get( 'con_PagingEnabled',	'1' );
		$con_entriesperpage	= $params->get( 'con_EntriesPerPage',	'10' );

		$pagingParams = $this->_getPaging( array(), array( "connshow_" ) );
		$showall = $this->_getReqParam( "showall", false );

		if ( $con_ShowSummary && !$showall && ( $pagingParams["connshow_limitstart"] === null ) ) 
		{
			$summaryMode		= true;
			$showpaging		= false;
			$con_entriesperpage	= $con_SummaryEntries;
		} else {
			$summaryMode		= false;
			$showpaging		= $con_pagingenabled;
		}

#		$return .= $this->_writeTabDescription( $tab, $user );

		$umedia = $this->remoteclient->getMediaVisibleForUser(array(
		    'username'		=> $my->username,
		    'owner_name'	=> $user->username
#		    'groupfilter'	=> '*'
		));

		$ugroups = $this->remoteclient->getGroupsVisibleForUser(array(
		    'username'		=> $my->username,
		    'owner_name'	=> $user->username
		));
		
		if ($my->username == $user->username)
		{
		    $mymc = $this->remoteclient->User_GetByName($my->username);
		    $quota = sprintf("%2.3f", $mymc{'space_quota'} / 1024 / 1024);
		    $sused = sprintf("%2.3f", $mymc{'space_free'} / 1024 / 1024);
		    $free  = sprintf("%2.3f", $quota - $sused);

		    $return .= 
			"<center><table width=\"100%\">\n".
			    "<tr>".
				"<td>".$this->strings{'MCLOUD:CB-TAB:SPACE-QUOTA'}."</td>\n".
				"<td align=\"right\">".$quota." MB </td>\n".
			    "</tr><tr>\n".
				"<td>".$this->strings{'MCLOUD:CB-TAB:SPACE-USED'}."</td>\n".
				"<td align=\"right\">".$sused." MB </td>\n".
			    "</tr><tr>\n".
				"<td>".$this->strings{'MCLOUD:CB-TAB:SPACE-FREE'}."</td>\n".
				"<td align=\"right\">".$free." MB </td>\n".
			    "</tr>\n".
			"</table></center>\n";
		}
		$return .= "<center>\n<table width=\"100%\">\n";

		while (count($umedia))
		{
		    $return .= "
			<tr>
";
		    for ($x=0; (($x<5) && count($umedia)); $x++)
		    {
			global $mosConfig_live_site;
			$mediaent = array_pop($umedia);
			$url = $this->urlrender->medium_url($mediaent{'id'});
			$return .= "
	<td align=\"center\">
	    <a href=\"$url\">
		<img width=\"100\" src=\"".$mediaent{'conversions'}{'thumb'}{'download_url'}."\">
		<p align=\"center\"> ".$mediaent{'title'}."</p>
	    </a>
	</td>
\n";
		    }
		    $return .= "
    </tr>
";
		}
		$return .= "</table>\n </center>\n";

		global $Itemid;

		$url_groups   = $mosConfig_live_site.'?option=hwdvideoshare&task=groups&owner_name='.urlencode($user->username).'&Itemid='.urlencode($Itemid);
		// FIXME: move out locales
		$label_media  = str_replace('{USERNAME}',urlencode($user->username), "{USERNAME}'s Medien");
		$label_groups = str_replace('{USERNAME}',urlencode($user->username), "{USERNAME}'s Gruppen");

		if (is_array($ugroups) && count($ugroups))
		{
		    $return .= "
    <h3>
    $label_groups
    </h3>
    <ul>
";
		    foreach($ugroups as $walk => $cur)
		    {
			$url_groups = "/index.php?option=com_mcloud&view=groupshow&Itemid=178&group_id=".$cur{'id'};
			$url_groups = $this->urlrender->group_show_url($cur{'id'});
			$return .= "
	<li>
	    <a href=\"$url_groups\"> ".$cur{'title'}." </a>
	</li>
";
		    }
		    $return .= "
    </ul>
";
		}


		return $return;
	}

	/**
	* UserBot Called when a user is deleted from backend (prepare future unregistration)
	* @param object mosUser reflecting the user being deleted
	* @param int 1 for successful deleting
	* @returns true if all is ok, or false if ErrorMSG generated
	*/
	function userDeleted($user, $success) {
		global $database,$ueConfig;
		return true;
	}
}	// end class getMCloudMediaTab.

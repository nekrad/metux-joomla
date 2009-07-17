<?php
/**
* Connections CB core plugin with tab classes for handling display of shortest connection path and connections tab on user profile.
* @version $Id: cb.connections.php 609 2006-12-13 17:30:15Z beat $
* @package Community Builder
* @subpackage cb.connections.php
* @author JoomlaJoe and Beat. Thanks to Nant for proposing paging
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_PLUGINS->registerFunction( 'onAfterDeleteUser', 'userDeleted','getConnectionTab' );

/**
* Connections Tab Class for handling the Shortest Connections Path CB tab in head by default (other parts are still in core CB)
* @package Community Builder
* @subpackage Connections CB core module
* @author JoomlaJoe and Beat
*/
class getConnectionPathsTab  extends cbTabHandler {
	/**
	* Constructor
	*/
	function getConnectionPathsTab() {
		$this->cbTabHandler();
	}
	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) {
		global $database, $my, $ueConfig;
		// Display shortest connection path / Degree of relationship:
		$return = "";
		if($my->id!=$user->id && $my->id > 0 && isset($ueConfig['connectionPath']) && $ueConfig['connectionPath'] && $ueConfig['allowConnections']) {
			$return .= $this->_writeTabDescription( $tab, $user );

			$return .= "\t\t<div class=\"cbConnectionPaths\">";
			$i=0;
			$cbCon=new cbConnection($my->id);
			$congroups=$cbCon->getDegreeOfSepPath($my->id,$user->id);
			$directConDetails=$cbCon->getConnectionDetails($my->id,$user->id);
			if(count($congroups)>2) {
				$query = "SELECT u.name,u.email,u.username,c.avatar,c.avatarapproved, u.id "
				. "\n FROM #__comprofiler AS c"
				. "\n LEFT JOIN #__users AS u ON c.id=u.id"
				. "\n WHERE c.id IN (".implode(',',$congroups).")"
				. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0"
				;
				$database->setQuery( $query );
				$connections = $database->loadObjectList('id');

				$prevConID=null;
				$prevConName=null;
				$return .= _UE_CONNECTIONPATH1.getNameFormat($connections[$user->id]->name,$connections[$user->id]->username,$ueConfig['name_format'])." ( ".$cbCon->getDegreeOfSep()._UE_CONNECTIONPATH2;
				foreach($congroups AS $congroup) {
					if($i!=0) $return .= " <img src=\"components/com_comprofiler/images/arrow.png\" alt=\"\" /> ";
					$conName=getNameFormat($connections[$congroup]->name,$connections[$congroup]->username,$ueConfig['name_format']);
					if ( ( $congroup!=$my->id ) && ( isset( $connections[$congroup] ) ) ) {
						$conDetail=$cbCon->getConnectionDetails($prevConID,$congroup);
						$conAvatar=getFieldValue('image',$connections[$congroup]->avatar,$connections[$congroup]);
						$tipField = "<b>"._UE_CONNECTEDSINCE."</b> : ".dateConverter($conDetail->membersince,'Y-m-d',$ueConfig['date_format']);
						if(getLangDefinition($conDetail->type)!=null) $tipField .= "<br /><b>"._UE_CONNECTIONTYPE."</b> : ".getConnectionTypes($conDetail->type);
						if($conDetail->description!=null) $tipField .= "<br /><b>"._UE_CONNECTEDCOMMENT."</b> : ".htmlspecialchars($conDetail->description);
						$tipField .= "<div style=\"text-align:center;margin:8px;\">".htmlspecialchars(preg_replace('/onclick\s*=\s*".+"/Uis', "", $conAvatar), ENT_QUOTES)."</div>";
						$tipTitle = $prevConName. _UE_DETAILSABOUT . str_replace("'", "&amp;#039;",$conName);
						$htmltext = $conName;
						$href='javascript:void(0)';
						if ($congroup!=$user->id) $href = sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$congroup);
						$tooltip = cbFieldTip($ui, $tipField, $tipTitle, $width='250', $icon='', $htmltext, $href, $style='', $olparams='',false);
						$return .= $tooltip;
					} else {
						$return .= $conName;
					}
					$i++;
					$prevConID=$congroup;
					$prevConName=$conName;
				}
				if ($directConDetails !== false && $directConDetails->pending) $return .= "<br />".sprintf(_UE_DIRECTCONNECTIONPENDINGACCEPTANCE,getNameFormat($user->name,$user->username,$ueConfig['name_format']));
			} elseif(count($congroups)==2) {
				$return .= _UE_DIRECTCONNECTION.getNameFormat($user->name,$user->username,$ueConfig['name_format']);
			} else {
				if ($directConDetails !== false && $directConDetails->pending) $return .= "<br />".sprintf(_UE_DIRECTCONNECTIONPENDINGACCEPTANCE,getNameFormat($user->name,$user->username,$ueConfig['name_format']));
				else $return .= _UE_NOESTABLISHEDCONNECTION.getNameFormat($user->name,$user->username,$ueConfig['name_format']);
			}
			$return .= "</div>";
		}
		return $return;
	}
}	// end class getConnectionPathsTab

/**
* Connections Tab Class for handling the Connections List CB tab (other parts are still in core CB)
* @package Community Builder
* @subpackage Connections CB core module
* @author JoomlaJoe and Beat
*/
class getConnectionTab extends cbTabHandler {
	var $userNumberOfConnections	= null;
	/**
	* Constructor
	*/
	function getConnectionTab() {
		$this->cbTabHandler();
	}
	function _getUserNumberOfConnections( $user)  {
		global $database;
		
		if ($this->userNumberOfConnections === null) {
			//select a count of all applicable entries
			$query="SELECT COUNT(*)"
				. "\n FROM #__comprofiler_members AS m"
				. "\n LEFT JOIN #__comprofiler AS c ON m.memberid=c.id"
				. "\n LEFT JOIN #__users AS u ON m.memberid=u.id"
				. "\n WHERE m.referenceid=" . (int) $user->id
				. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0"
				. "\n AND m.pending=0 AND m.accepted=1"
				. "\n ";
			$database->setQuery($query);
			$this->userNumberOfConnections = (int) $database->loadResult();
		}
		return $this->userNumberOfConnections;
	}
	/**
	* Generates the menu and user status to display on the user profile by calling back $this->addMenu
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns boolean : either true, or false if ErrorMSG generated
	*/
	function getMenuAndStatus($tab,$user,$ui) {
		global $database, $ueConfig;

		$params				=	$this->params;
		$con_StatDisplay	=	$params->get('con_StatDisplay', '1');
		
		if ( $ueConfig['allowConnections'] && $con_StatDisplay ) {
			//------------------- User Status items for User Status Window:
			// Connections:
			$contotal		=	$this->_getUserNumberOfConnections( $user );
			
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
	function getDisplayTab($tab,$user,$ui) {
		global $database, $ueConfig, $mosConfig_hits, $mosConfig_vote, $my, $mosConfig_lang;
		$return=null;
		
		if(!$ueConfig['allowConnections'] || (isset($ueConfig['connectionDisplay']) && $ueConfig['connectionDisplay']==1 && $my->id!=$user->id)) {
			return null;
		}
		$params				= $this->params;
		$con_ShowTitle		= $params->get( 'con_ShowTitle',		'1' );
		$con_ShowSummary	= $params->get( 'con_ShowSummary',		'0' );
		$con_SummaryEntries	= $params->get( 'con_SummaryEntries',	'4' );
		$con_pagingenabled	= $params->get( 'con_PagingEnabled',	'1' );
		$con_entriesperpage	= $params->get( 'con_EntriesPerPage',	'10' );

		$pagingParams = $this->_getPaging( array(), array( "connshow_" ) );
		
		$showall = $this->_getReqParam( "showall", false );
		
		if ( $con_ShowSummary && !$showall && ( $pagingParams["connshow_limitstart"] === null ) ) {
			$summaryMode		= true;
			$showpaging			= false;
			$con_entriesperpage	= $con_SummaryEntries;
		} else {
			$summaryMode		= false;
			$showpaging			= $con_pagingenabled;
		}

		$isVisitor=null;
		if ( $my->id != $user->id ) {
			$isVisitor="\n AND m.pending=0 AND m.accepted=1";
		}

		if ( $showpaging || $summaryMode ) {
			//select a count of all applicable entries for pagination
			if ( $isVisitor ) {
				$contotal = $this->_getUserNumberOfConnections( $user );
			} else {
				$query="SELECT COUNT(*)"
					. "\n FROM #__comprofiler_members AS m"
					. "\n LEFT JOIN #__comprofiler AS c ON m.memberid=c.id"
					. "\n LEFT JOIN #__users AS u ON m.memberid=u.id"
					. "\n WHERE m.referenceid=" . (int) $user->id
					. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0"
					. $isVisitor
					. "\n ";
				
				$database->setQuery($query);
				$contotal = $database->loadResult();
				
				if (!is_numeric($contotal)) $contotal = 0;
			}
		}
		if ( (! $showpaging) || ($pagingParams["connshow_limitstart"] === null) || ( $con_entriesperpage > $contotal ) ) {
			$pagingParams["connshow_limitstart"] = "0";
		}

		$query = "SELECT m.*,u.name,u.email,u.username,c.avatar,c.avatarapproved, u.id "
		. "\n FROM #__comprofiler_members AS m"
		. "\n LEFT JOIN #__comprofiler AS c ON m.memberid=c.id"
		. "\n LEFT JOIN #__users AS u ON m.memberid=u.id"
		// removed  . "\n LEFT JOIN #__session AS s ON s.userid=u.id"	and in SELECT: IF((s.session_id<=>null) OR (s.guest<=>1),0,1) AS 'isOnline' to avoid blocking site in case members table get locked
		. "\n WHERE m.referenceid=" . (int) $user->id .""
		. "\n AND c.approved=1 AND c.confirmed=1 AND c.banned=0 AND u.block=0"
		. $isVisitor
		. "\n ORDER BY m.membersince DESC, m.memberid ASC"
		. "\n LIMIT ".($pagingParams["connshow_limitstart"]?$pagingParams["connshow_limitstart"]:"0").",".$con_entriesperpage;

		$database->setQuery( $query );
		$connections = $database->loadObjectList();

		if(!count($connections)>0) {
			$return .= _UE_NOCONNECTIONS;
			return $return;
		}
		
		if ( $con_ShowTitle ) {
			if ( $my->id == $user->id ) {
				$return .= "<h3 class=\"cbConTitle\">"._UE_YOURCONNECTIONS."</h3>";
			} else {
				$return .= "<h3 class=\"cbConTitle\">".sprintf( _UE_USERSNCONNECTIONS, getNameFormat( $user->name, $user->username, $ueConfig['name_format'] ) )."</h3>";
			}
		}
		
		$return .= $this->_writeTabDescription( $tab, $user );
		
		$boxHeight = $ueConfig['thumbHeight']+46;
		$boxWidth  = $ueConfig['thumbWidth']+28;
		foreach ( $connections AS $connection ) {
			$conAvatar=null;
			$conAvatar=getFieldValue('image',$connection->avatar,$connection);
			$emailIMG=getFieldValue('primaryemailaddress',$connection->email,$connection,null,1);
			$pmIMG=getFieldValue('pm',$connection->username,$connection,null,1);
			$onlineIMG	= ($ueConfig['allow_onlinestatus']==1) ? getFieldValue('status', null /* $connection->isOnline */, $connection /* null */ ,null,1) : "";
			if ( $connection->accepted == 1 && $connection->pending == 1 ) {
				$actionIMG = "<img src=\"components/com_comprofiler/images/pending.png\" border=\"0\" alt=\""._UE_CONNECTIONPENDING."\" title=\""._UE_CONNECTIONPENDING."\" /> <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connection->memberid)."\" onclick=\"return confirmSubmit();\" ><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_REMOVECONNECTION."\" /></a>";
			} elseif ( $connection->accepted == 1 && $connection->pending == 0 ) {
				$actionIMG = "<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connection->memberid)."\" onclick=\"return confirmSubmit();\" ><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_REMOVECONNECTION."\" /></a>";
			} elseif ( $connection->accepted == 0 ) {
				$actionIMG = "<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=acceptConnection&amp;connectionid=".$connection->memberid)."\"><img src=\"components/com_comprofiler/images/tick.png\" border=\"0\" alt=\""._UE_ACCEPTCONNECTION."\" title=\""._UE_ACCEPTCONNECTION."\" /></a> <a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;act=connections&amp;task=removeConnection&amp;connectionid=".$connection->memberid)."\"><img src=\"components/com_comprofiler/images/publish_x.png\" border=\"0\" alt=\""._UE_REMOVECONNECTION."\" title=\""._UE_DECLINECONNECTION."\" /></a>";
			}
			$tipField = "<b>"._UE_CONNECTEDSINCE."</b> : ".dateConverter($connection->membersince,'Y-m-d',$ueConfig['date_format']);
			if ( getLangDefinition($connection->type) != null ) {
				$tipField .= "<br /><b>"._UE_CONNECTIONTYPE."</b> : ".getConnectionTypes($connection->type);
			}
			if ( $connection->description != null ) {
				$tipField .= "<br /><b>"._UE_CONNECTEDCOMMENT."</b> : ".htmlspecialchars($connection->description);
			}
			$tipTitle = _UE_CONNECTEDDETAIL;
			$htmltext = $conAvatar;
			$style = "style=\"padding:5px;\"";
			$tooltipAvatar = cbFieldTip($ui, $tipField, $tipTitle, $width='250', $icon='', $htmltext, $href='', $style, $olparams='',false);
			if ( $my->id == $user->id ) {
			$return .= "<div class=\"connectionBox\" style=\"position:relative;height:".($boxHeight+24)."px;width:".$boxWidth."px;\">"
					 . "<div style=\"position:absolute; top:3px; width:auto;left:5px;right:5px;\">".$actionIMG.'</div>'
					 . "<div style=\"position:absolute; top:18px; width:auto;left:5px;right:5px;\">".$tooltipAvatar.'</div>'
					 . "<div style=\"position:absolute; bottom:0px; width:auto;left:5px;right:5px;\">"
					 . $onlineIMG." ".getNameFormat($connection->name,$connection->username,$ueConfig['name_format'])
					 . "<br /><a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$connection->memberid)
					 ."\"><img src=\"components/com_comprofiler/images/profiles.gif\" border=\"0\" alt=\""._UE_VIEWPROFILE."\" title=\""
					 ._UE_VIEWPROFILE."\" /></a> ".$emailIMG." ".$pmIMG."\n";
			} else {
			$return .= "<div class=\"connectionBox\" style=\"position:relative;height:".$boxHeight."px;width:".$boxWidth."px;\">"
					 . "<div style=\"position:absolute; top:10px; width:auto;left:5px;right:5px;\">".$tooltipAvatar.'</div>'
					 . "<div style=\"position:absolute; bottom:0px; width:auto;left:5px;right:5px;\">"
					 . $onlineIMG." ".getNameFormat($connection->name,$connection->username,$ueConfig['name_format'])."\n";
			}
			$return .= "</div></div>\n";
		}
		$return .= "<div style=\"clear:both;\">&nbsp;</div>";
		
		// Add paging control at end of list if paging enabled
		if ($showpaging && ($con_entriesperpage < $contotal)) {
			$return .= "<div style='width:95%;text-align:center;'>"
			.$this->_writePaging($pagingParams,"connshow_",$con_entriesperpage,$contotal)
			."</div>";
		}
		
		if ( $con_ShowSummary && ( $my->id == $user->id ) || ( $summaryMode && ( $con_entriesperpage < $contotal ) ) ) {
			$return .= "<div class=\"connSummaryFooter\" style=\"width:100%;clear:both;\">";
			if ( $my->id == $user->id ) {
				// Manage connections link:
				$return .= "<div id=\"connSummaryFooterManage\" style=\"float:left;\">"
						 . "<a href=\"".sefRelToAbs('index.php?option=com_comprofiler&amp;task=manageConnections')."\" >["._UE_MANAGECONNECTIONS."]</a>"
						 . "</div>";
			}
			if ( $summaryMode && ( $con_entriesperpage < $contotal ) ) {
				// See all of user's ## connections
				$return .= "<div id=\"connSummaryFooterSeeConnections\" style=\"float:right;\">"
						 . "<a href=\"".$this->_getAbsURLwithParam( array("showall" => "1") )."\">";
				if ( $my->id == $user->id ) {
					$return .= sprintf( _UE_SEEALLNCONNECTIONS, $contotal );
				} else {
					$return .= sprintf( _UE_SEEALLOFUSERSNCONNECTIONS, getNameFormat($user->name,$user->username,$ueConfig['name_format']), "<strong>".$contotal."</strong>" );
				}
				$return .= "</a>"
						 . "</div>";
			}
			$return .= "&nbsp;</div>"
					 . "<div style=\"clear:both;\">&nbsp;</div>";			
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
		$sql="DELETE FROM #__comprofiler_members WHERE referenceid=" . (int) $user->id;
		$database->SetQuery($sql);
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error cb.connections:userDelted-1" . $database->stderr(true));
			return false;
		}
		
		if($ueConfig['autoAddConnections']) {
			$sql="DELETE FROM #__comprofiler_members WHERE memberid=" . (int) $user->id;
			$database->SetQuery($sql);
			if (!$database->query()) {
				$this->_setErrorMSG("SQL error cb.connections:userDelted-2" . $database->stderr(true));
				return false;
			}
		}
		return true;
	}
}	// end class getConnectionTab.

?>

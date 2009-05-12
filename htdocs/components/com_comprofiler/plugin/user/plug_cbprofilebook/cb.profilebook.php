<?php
/**
* ProfileBook plugin with tab class for user guestbook on profile
* @version $Id$
* @package Community Builder
* @subpackage ProfileBook plugin
* @author JoomlaJoe and Beat
* @copyright (C) JoomlaJoe and Beat 2005-2006, www.joomlapolis.com and various
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or defined ('_JEXEC') or die( 'Direct Access to this location is not allowed.' );

$_PLUGINS->registerFunction( 'onAfterDeleteUser', 'userDeleted','getProfileBookTab' );

class getProfileBookTab extends cbTabHandler {

	/**
	* Constructor
	*/
	function getProfileBook() {
		$this->cbTabHandler();
	}

	/**
	 * Gets an array of IP addresses taking in account the proxys on the way.
	 * An array is needed because FORWARDED_FOR can be facked as well.
	 * 
	 * @return array of IP addresses, first one being host, and last one last proxy (except fackings)
	 */
	function _get_ip_list() {
		$ip_adr_array = array();
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')) {
				$ip_adr_array +=  explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
			} else {
				$ip_adr_array[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		$ip_adr_array[] = $_SERVER['REMOTE_ADDR'];
		return $ip_adr_array;
	}

	function pbSave($id, $tab) {
		global $my, $database, $_SERVER;
		$postercomment = $this->_getReqParam("postercomments", null);
		$postername = $this->_getReqParam("postername", null);
		$posterlocation = $this->_getReqParam("posterlocation", null);
		$posteremail = $this->_getReqParam("posteremail", null);
		$posterurl = $this->_getReqParam("posterurl", null);
		$posterid = $my->id;
		$posterip = $database->getEscaped(implode(",",$this->_get_ip_list()));
		$postervote = $this->_getReqParam("postervote", "NULL");
		
		$userConfig = $this->pbGetUserConfig($id);
		$autoPublish = strtolower($userConfig->cb_pb_autopublish);
		if($autoPublish=='_ue_no') $published=0;
		else $published = 1;

		$query = "SELECT COUNT(*) FROM #__comprofiler_plug_profilebook WHERE postername='$postername' AND posteremail='$posteremail' AND postercomment='$postercomment' AND posterid='$posterid' AND userid='$id'";
		$database->setQuery($query);
		$count=$database->loadResult();
		
		if ($count == 0) {			// avoid double-posts on clicking reload !
			$query = "INSERT INTO #__comprofiler_plug_profilebook SET postername='$postername', posteremail='$posteremail', posterlocation='$posterlocation', postercomment='$postercomment', postervote=$postervote, posterip='$posterip',posterid='$posterid',userid='$id',published='$published',date=NOW(),posterurl='$posterurl'";
			$database->setQuery($query);
			if (!$database->query()) {
				print("<font color=\"red\">pbSave SQL error: " . $database->stderr(true)."</font><br />");
				return;
			}
			$notify = strtolower($userConfig->cb_pb_notifyme);
	
			if($notify=='_ue_yes'){
				$cbNotification = new cbNotification();
			$res=$cbNotification->sendFromSystem($id,sprintf(_pb_MSGSUB,getLangDefinition($tab->title)),sprintf(_pb_MSGBODY,$postername,getLangDefinition($tab->title)).sprintf($autoPublish?_pb_MSGBODYAUTOAPPROVED:_pb_MSGBODYREVIEWAPPROVE,	getLangDefinition($tab->title),$this->_getAbsURLwithParam(array())));

			}
		}
	}
	
	function pbEdit($id, $userId, $curruser, $iAmModerator, $tab) {
		global $my, $database, $_SERVER, $ueConfig;
		$postercomment = $this->_getReqParam("postercomments", null);
		$postername = $this->_getReqParam("postername", null);
		$posterlocation = $this->_getReqParam("posterlocation", null);
		$posteremail = $this->_getReqParam("posteremail", null);
		$posterurl = $this->_getReqParam("posterurl", null);
		$posterid = $my->id;
		$posterip = $database->getEscaped(implode(",",$this->_get_ip_list()));
		$postervote = $this->_getReqParam("postervote", "NULL");
		
		$editedbyname = ($my->id ? $database->getEscaped(getNameFormat($curruser->name,$curruser->username,$ueConfig['name_format']))
								  : $postername);
		$userConfig = $this->pbGetUserConfig($userId);
		$autoPublish = strtolower($userConfig->cb_pb_autopublish);
		if ($iAmModerator) {
			$published = null;
		} else {
			if($autoPublish=='_ue_no') $published=0;
			else $published = 1;
		}
		$query = "UPDATE #__comprofiler_plug_profilebook SET editdate=NOW(), "
				.($my->id ? "editedbyid=".$my->id.", " : "")
				."editedbyname='".$editedbyname."', "
				."postername='$postername', "
				.($posteremail ? "posteremail='$posteremail', " : "")
				."posterlocation='$posterlocation', postercomment='$postercomment', postervote=$postervote, "
				."posterip='$posterip', "
				.($published !== null ? "published='$published', " : "")
				."posterurl='$posterurl' WHERE id=$id AND userid=$userId"
				.($iAmModerator ? "" : " AND posterid=$posterid");
		$database->setQuery($query);
		if (!$database->query()) {
			print("<font color=\"red\">pbEdit SQL error: " . $database->stderr(true)."</font><br />");
			return;
		}
		$notify = strtolower($userConfig->cb_pb_notifyme);

		if($notify=='_ue_yes'){
			$cbNotification = new cbNotification();
			$res=$cbNotification->sendFromSystem($userId, sprintf(_pb_MSGSUBEDIT, getLangDefinition($tab->title)),
											sprintf(_pb_MSGBODYEDIT, $editedbyname, $postername, getLangDefinition($tab->title))
											.($iAmModerator ? "" : sprintf($autoPublish ? _pb_MSGBODYAUTOAPPROVED : _pb_MSGBODYREVIEWAPPROVE,
											 getLangDefinition($tab->title),
											 $this->_getAbsURLwithParam(array()))));
		}
	}

	function pbDelete($id) {
		global $database;
		$database->setQuery("DELETE FROM #__comprofiler_plug_profilebook WHERE id=".$id);
		$database->query();
		if (!$database->query()) {
			print("<font color=\"red\">pbDelete SQL error: " . $database->stderr(true)."</font><br />");
			return;
		}
	}
	
	function pbUpdate($id, $isMe) {
		global $database;
		//$postercomment = $this->_getReqParam("postercomments", null);
		$feedback = $this->_getReqParam("feedback", null);
		if (!$isMe && $feedback) $feedback = "["._pb_ModeratorEdited."]: ".$feedback;
		$published = $this->_getReqParam("published", 0);
		$query = "UPDATE #__comprofiler_plug_profilebook SET  feedback='$feedback', published='$published' WHERE id='$id'";
		$database->setQuery($query);
		if (!$database->query()) {
			print("<font color=\"red\">pbUpdate SQL error: " . $database->stderr(true)."</font><br />");
			return;
		}
	}

	function pbPublish($id) {
		global $database;

		$published = $this->_getReqParam("published", 0);
		$query = "UPDATE #__comprofiler_plug_profilebook SET  published='$published' WHERE id='$id'";
		$database->setQuery($query);
		if (!$database->query()) {
			print("<font color=\"red\">pbPublish SQL error: " . $database->stderr(true)."</font><br />");
			return;
		}
	}	
	
	function pbGetUserConfig($id) {
		global $database;
		
		$database->setQuery("SELECT cb_pb_enable, cb_pb_autopublish, cb_pb_notifyme FROM #__comprofiler WHERE id=".$id);
		$userConfig=$database->loadObjectList();
		
		return $userConfig[0];
	}
	
	function getEditTab( $tab, $user, $ui) {
		$this->_getlanguageFile();
	}
	
	function _getLanguageFile() {
		global $mainframe,$mosConfig_lang;
		$UElanguagePath=JPATH_BASE.'/components/com_comprofiler/plugin/user/plug_cbprofilebook';
		if (file_exists($UElanguagePath.'/language/'.$mosConfig_lang.'.php')) {
		  include_once($UElanguagePath.'/language/'.$mosConfig_lang.'.php');
		} else include_once($UElanguagePath.'/language/english.php');	
	}


	/**
	* Generates the HTML to display the user profile tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayTab($tab,$user,$ui) {
		global $database,$mosConfig_live_site,$acl,$my,$mosConfig_offset,$ueConfig,$mainframe,$mosConfig_lang;
		
		$this->_getLanguageFile();
		
		$iAmModerator = isModerator($my->id);
		
		//Get User Level Configuration Options
		$userConfig = $this->pbGetUserConfig($user->id);
		$autoPublish = strtolower($userConfig->cb_pb_autopublish);
		$notify = strtolower($userConfig->cb_pb_notifyme);
		
		//Return if the user doesn't have the ProfileBook enabled no need to go any further
		if(strtolower($userConfig->cb_pb_enable) == '_ue_no') return;

		$return="";
		
		//If there is a tab description display it
		if($tab->description != null) $return .= "\t\t<div class=\"tab_Description\">".unHtmlspecialchars(getLangDefinition($tab->description))."</div>\n";
	
		//Get the tab related paramaters, these settings are global and set by administrator
		$params=$this->params;
		$pbAllowAnony		= $params->get('pbAllowAnony', '0');		//Determine whether Anonymous Users can post
		$pbEnableRating		= $params->get('pbEnableRating', '1');		//Determine if Profile Ratings should be used
		$pbEntriesPerPage 	= $params->get('pbEntriesPerPage', '10');	//Determine number of posts to show per page
		$pagingEnabled		= $params->get('pbPagingEnabled', 1);		//Determine if Pagination is enabled
		$sortDirection		= $params->get('pbSortDirection','DESC');	//Determine sort order of posting date
		$pbUseLocation		= $params->get('pbUseLocation', '1');		//Determine whether to use Location Field
		$pbLocationField	= $params->get('pbLocationField', '0');		//Determine whether what field is the location field
		$pbUseWebAddress	= $params->get('pbUseWebAddress', '1');		//Determine whether to use Web Address Field
		$pbWebField			= $params->get('pbWebField', '0');			//Determine whether what field is the web address field
		$pbEnableGesture	= $params->get('pbEnableGesture','0');		//Determine whether return gestures are enabled
		$pbAllowBBCode		= $params->get('pbAllowBBCode', '1');		//Determine if BBCode is allowed
		$pbAllowSmiles		= $params->get('pbAllowSmiles', '1');		//Determine if Smiles are allowed

		//Check to see if there are actions that need to be executed
		$action = $this->_getReqParam("formaction", null);
		$id = $this->_getReqParam("id",0);
		$showform = $this->_getReqParam("showform", 0);
		
		$jsSent = 0;
		
		//Section for posting a entry
		//Check to see if the visting user is the profile owner
		if($my->id != $user->id) {
			//Not the owner
			$isME=false;
			
			//Check to see if the user is logged in
			if($my->id==0) {
				//Not logged in so assumed to be annonymous
				$isAnony=true;
				$required=true;
			} else {
				//Yes logged in so not annonymous
				$isAnony=false;
				$required=false;
				
				//get the attributes of the user visiting the profile
				$database->setQuery( "SELECT * FROM #__comprofiler c, #__users u WHERE c.id=u.id AND c.id='".$my->id."'");
				$users = $database->loadObjectList();
				$curruser = $users[0];
			}
			
			
			//Allow Posting based on AllowAnony config setting
			if(($pbAllowAnony=='1') || ($pbAllowAnony=='0' && $my->id > 0))	{

				//Check to see if a user has submitted a profile entry to be saved
				if ($action == "new") {
					$this->pbSave($user->id, $tab);
				} else {
					$formName = "pbnewcomment";
					$linkTitle = _pb_SubmitEntry;
					$txtSubmit = _pb_PostEntry;
					if (!$jsSent++) echo $this->_getpbJS();
					$return .= $this->_hiddenBBeditor(null, $formName, $linkTitle, $txtSubmit, $showform, $curruser, $pbEnableRating, $pbUseLocation, $pbLocationField, $pbUseWebAddress, $pbWebField, $required, $pbAllowBBCode, $pbAllowSmiles, null);
				}
			}
		} else {
			//The visiting user is the profile owner
			$isME=true;
			$isAnony=false;
			$required=false;
			$curruser =& $user;
		}
		if ($iAmModerator || !$isAnony) {
			if ($action == 'edit') {
				$this->pbEdit($id, $user->id, $curruser, $iAmModerator, $tab);
			}
		}

		if ($isME || $iAmModerator) {
			//Take necessary profile owner action if there is
			switch ($action) {
				CASE 'delete':
					$this->pbDelete($id);
					//print "I'm deleting post id:".$id;
				break;
				CASE 'update':
					$this->pbUpdate($id, $isME);
					//print "I'm updating feedback for post id:".$id;
				break;
				CASE 'publish':
					$this->pbPublish($id);
					//print "I'm publishing post id:".$id;
				break;				
				DEFAULT:
					//print "I'm doing nothing:".$id." action:".$action;
				break;
			}
		}

		
		//Find and Show Postings
		$pagingParams = $this->_getPaging(array(),array("pbposts_"));
		$pWHERE=null;
		
		//if the user viewing the profile is not the owner then only show published entries
		if(!$isME && !$iAmModerator) $pWHERE = "\n AND published=1";
		
		//check to see if the Admin enabled pagination
		if ($pagingEnabled) {
			//select a count of all applicable entries for pagination
			$query="SELECT count(*)"
			. "\n FROM #__comprofiler_plug_profilebook"
			. "\n WHERE userid=".$user->id
			. "\n ".$pWHERE;
		
			$database->setQuery($query);
			$total = $database->loadResult();
			
			if (!is_numeric($total)) $total = 0;

			if ($pagingParams["pbposts_limitstart"] === null) $pagingParams["pbposts_limitstart"] = "0";
			if ($pbEntriesPerPage > $total) $pagingParams["pbposts_limitstart"] = "0";
			
		} else {
			$pagingParams["pbposts_limitstart"] = "0";
		}
		

		//select all entries and related details
		$query="SELECT *, pb.id AS pbid "
		. "\n FROM #__comprofiler_plug_profilebook pb"
		. "\n LEFT JOIN #__users u ON pb.posterid=u.id"
		. "\n LEFT JOIN #__comprofiler c ON pb.posterid=c.id"
		. "\n WHERE pb.userid=".$user->id
		. $pWHERE
		. "\n ORDER BY date ".$sortDirection
		. "\n LIMIT ".($pagingParams["pbposts_limitstart"]?$pagingParams["pbposts_limitstart"]:"0").",".$pbEntriesPerPage;
		$database->setQuery( $query );
		// print $database->getQuery();
		$items = $database->loadObjectList();
		
		//check to make sure we got at least 1 record
		if(count($items) >0) {
			//build header information for display table
			$return .= "<br /><div style=\"text-align:left;width:100%;\">";
			$return .= "\n<table cellpadding=\"3\" cellspacing=\"0\" style=\"border:0px; width:100%; table-layout:fixed\">";
			$return .= "\n\t<tr class=\"sectiontableheader\">";
			$return .= "\n<td style=\"width:30%;\">"._pb_NameHeader."</td>";
			$return .= "\n<td style=\"width:70%;\">"._pb_EntryHeader."</td>";
			$return .= "\n</tr>";
			$i=2;
			$k=0;
						
			//iterate through each item and display it accordingly
			foreach($items AS $item) {
				$k++;
				$i= ($i==1) ? 2 : 1;
				
				//get the date that the entry was submitted on a format it according to CB config
				$signtime = cbFormatDate($item->date);
				$edittime = cbFormatDate($item->editdate);
				
				$img = null;
				//check to see if Ratings are enabled
				if($pbEnableRating) $img = $this->_getRatingImage($item->postervote);

				//start a new row for the record
				$return .= "\n\t<tr class=\"sectiontableentry$i\" style=\"margin-bottom:5px;\" >";
				$pimg = "";
				$returnFavor=null;
				//check to see if the entry was submitted by a member
				if($item->posterid!=0 && $item->posterid!="" && $item->posterid!=null && isset($item->username)) {
					
					//make link to profile and format name according to cb config
					$pname="<a href=\"".sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;user=".$item->posterid)."\">".htmlspecialchars(getNameFormat($item->name,$item->username,$ueConfig['name_format']))."</a>";
					
					//get users avatar if they have one
					// if (isset($item->avatar)) {
					$pimg="<br />".getFieldValue('image',$item->avatar,$item);
					// }
					//get users primary email address and display it according to CB config
					$pEmail="<br />".getFieldValue('primaryemailaddress',$item->posteremail,$item);
					
					if($pbEnableGesture && $isME) {
						$returnFavor = "| <a href=\"".$this->_getAbsURLwithParam(array('user'=>$item->posterid,'showform'=>1))."\">"
									 ._pb_ReturnFavor."</a>";
					}
					
				} else {
					//entry was submitted by anonymous user just diplay entered data
					$pname=htmlspecialchars($item->postername);
					$pEmail="<br />".getFieldValue('emailaddress',$item->posteremail,$item);
				}
				//check to see if the location was entered to determine how to display it
				if($pbUseLocation && $item->posterlocation!=null && $item->posterlocation!="") {
					$pLocation = "<br />".htmlspecialchars($item->posterlocation);
				} else $pLocation=null;
				//check to see if the web address was entered to determine how to display it
				if($pbUseWebAddress && $item->posterurl!=null && $item->posterurl!="") {
					$URL ="<br />".getFieldValue('webaddress',$item->posterurl);
				} else $URL=null; 
				
				//if the profile visitor is the profile owner and the ip address of the poster is not null then show the ip address with link to lookup site
				$ip="";
				if($iAmModerator && $item->posterip!="") {
					$ips = explode(",",$item->posterip);
					foreach ($ips as $poster_proxy_ip) {
						$ip .= "<br /><a href=\"http://openrbl.org/dnsbl?i=".$poster_proxy_ip."&amp;f=2\" target=\"_blank\">"
							. getFieldValue('text',$poster_proxy_ip) . "</a>";	
					}
				}
				
				//display information about the poster
				$return .= "\n\t\t<td style=\"overflow:hidden;\" valign=\"top\"><b>".$pname."</b>".$pEmail.$pLocation.$URL.$ip.$pimg."</td>";
				$return .= "\n\t\t<td style=\"overflow:hidden;\" valign=\"top\">";
				
				//display unpublished, signed on date, edited by on date, and rating
				$return .= "<span class='small' style='width:60%;'>";
				if (!$item->published) {
					$return .= "<strong>"._pb_NotPublished."</strong> | ";
				}
				$return .= sprintf(_pb_CreatedOn, $signtime);
				if ($item->editdate) {
					$return .= "<br />".htmlspecialchars(sprintf(_pb_EditedByOn, $item->editedbyname, $edittime));
				}
				$return .= "</span>";
				if ($img) {
					$return .= "<span style='width:30%;text-align:right;'> ".$img."</span>";
				}
				
				//parse bbcode and display			
				$return .= "<br /><hr />".$this->parseBBCode(nl2br(htmlspecialchars($item->postercomment)), $pbAllowBBCode, $pbAllowSmiles);
				
				//add warning if it's not the author who edited
				if ($item->editdate && ($item->posterid != $item->editedbyid || $item->postername != $item->editedbyname)) {
					$return .= _pb_EditedByModerator;
				}
				
				//check to see if the profile owner has left feedback and determine how to display
				if ($item->feedback<>"") {
					$return .= "<hr /><span class='small'><b>".htmlspecialchars(sprintf(_pb_FeedbackFrom, getNameFormat($user->name,$user->username,$ueConfig['name_format'])))."</b>".$this->parseBBCode(nl2br(htmlspecialchars($item->feedback)), $pbAllowBBCode, $pbAllowSmiles)."</span>";
				}
				
				//check to see if the profile visitor is the profile owner or a moderator or original poster
				if($isME || $iAmModerator || ($my->id && $my->id == $item->posterid)) {
					$return .= "<br />";
				}
				if ($iAmModerator || ($my->id && $my->id == $item->posterid)) {
					$formName = "pbeditcomment".$k;
					$linkTitle = _pb_EditEntry;
					$txtSubmit = _pb_UpdateEntry;
					if (!$jsSent++) echo $this->_getpbJS();
					$return .= $this->_hiddenBBeditor($item, $formName, $linkTitle, $txtSubmit, 0, $curruser, $pbEnableRating, $pbUseLocation, $pbLocationField, $pbUseWebAddress, $pbWebField, $required, $pbAllowBBCode, $pbAllowSmiles, ($iAmModerator && ($my->id != $item->posterid)) ? _pb_EditOthersAreYouSure : null);
					if ($iAmModerator) {
						$return .= " | ";
					}
				}
				if ($isME || $iAmModerator) {

					//yes it is so display action links
					$base_url = $this->_getAbsURLwithParam($pagingParams);
					
					$return .= "<form name=\"actionForm".$k."\" id=\"actionForm".$k."\" method=\"post\" action=\"".$base_url."\" style=\"display:none;\">"
					."<input type=\"submit\" name=\"submitform\" value=\"submit\" style=\"display:none;\" />"
					."<input type=\"hidden\" name=\"".$this->_getPagingParamName("id")."\" value=\"".$item->pbid."\" />"
					."<input type=\"hidden\" name=\"".$this->_getPagingParamName("published")."\" id=\"published".$k."\" value=\"1\" />"
					."<input type=\"hidden\" id=\"formaction".$k."\" name=\"".$this->_getPagingParamName("formaction")."\" value=\"update\" />"
					."</form>";
					
					if($item->published==0) {
						$published=null; 
						$publishLink="<a href=\"javascript:document.actionForm".$k.".formaction".$k.".value='publish';document.actionForm".$k.".published".$k.".value=1;document.actionForm".$k.".submit();\">"._pb_Publish."</a>";
					}
					else {
						$published = "checked=\"checked\"";
						$publishLink="<a href=\"javascript:document.actionForm".$k.".formaction".$k.".value='publish';document.actionForm".$k.".published".$k.".value=0;document.actionForm".$k.".submit();\">"._pb_UnPublish."</a>";
					}
					$popform=null;
					$popform .= "<form name=\"adminForm".$k."\" id=\"adminForm".$k."\" method=\"post\" action=\"".$base_url."\">";
					$popform .= "<b>"._pb_Publish.":</b><input type=\"checkbox\" name=\"".$this->_getPagingParamName("published")."\" id=\"published".$k."\" value=\"1\" ".$published." />";
					$popform .= "<input type=\"hidden\" name=\"".$this->_getPagingParamName("id")."\" value=\"".$item->pbid."\" /><input type=\"hidden\" name=\"".$this->_getPagingParamName("formaction")."\" value=\"update\" />";
					$popform .= "<br /><b>"._pb_YourFeedback.":</b><br /><textarea class=\"inputbox\" name=\"".$this->_getPagingParamName("feedback")."\" style=\"height:75px;width:400px;overflow:auto;\" >".htmlspecialchars($item->feedback)."</textarea>";
					$popform .= "<br /><input type=\"submit\" value=\""._pb_Update."\" /></form>";					

					$return .= "<a href=\"javascript:if (confirm('".str_replace("'","\\'",_pb_DeleteAreYouSure)."')) { document.actionForm".$k.".formaction".$k.".value='delete';document.actionForm".$k.".submit(); }\">"._pb_Delete
					."</a> | ".$publishLink;
					if ($isME || ($iAmModerator && $item->feedback)) {
						$return .= " | <a href=\"javascript:void(0);\" name=\"pbFeedback".$k."\" id=\"pbFeedback".$k."\" onclick=\""
						.($iAmModerator && !$isME ? "if (confirm('".str_replace("'","\\'",_pb_EditOthersAreYouSure)."')) " : "")
						."return overlib('".str_replace(array("&","\\",'"',"<",">","'","\n","\r"), array("&amp;","\\\\","&quot;","&lt;","&gt;","\'","\\n","\\r"),$popform)."', STICKY, CAPTION,'"._pb_GiveFeedback."', CENTER,CLOSECLICK,CLOSETEXT,'"._UE_CLOSE_OVERLIB."',WIDTH,350, ANCHOR,'pbFeedback".$k."',ANCHORALIGN,'LR','UR');\">".($item->feedback ? _pb_EditFeedback : _pb_GiveFeedback)."</a> ";
					}
					$return .= $returnFavor;
				}

				$return .= "<br /><br /></td>";
				$return .= "\n\t</tr>";
			}
			$return .= "\n</table>";
			
			//display pagination
			if ($pagingEnabled && ($pbEntriesPerPage < $total)) {
				$return .= "<div style='width:95%;text-align:center;'>"
				.$this->_writePaging($pagingParams,"pbposts_",$pbEntriesPerPage,$total)
				."</div>";
			}
			$return .= "";
			$return .= "\n</div>";
		} else {
			//no posts so determine what to display
			 $return .= "<br /><br /><div class=\"sectiontableheader\" style=\"text-align:left;width:95%;\">";
			 $return .= _pb_NoPosts;
			 $return .= "</div>";
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
		$sql="DELETE FROM #__comprofiler_plug_profilebook WHERE userid='".$user->id."'";
		$database->SetQuery($sql);
		if (!$database->query()) {
			$this->_setErrorMSG("SQL error cb.profilebook:userDeleted-1" . $database->stderr(true));
			return false;
		}
		
		return true;
	}

	function _hiddenBBeditor($item, $formName, $linkTitle, $txtSubmit, $showform, $curruser, $pbEnableRating, $pbUseLocation, $pbLocationField, $pbUseWebAddress, $pbWebField, $required, $pbAllowBBCode, $pbAllowSmiles, $warnText) {
		$return = "";
		$return .= "<a href=\"javascript:void(0);\" onclick=\"pb_Expand('".$formName."', '".str_replace("'","\\'",$warnText)."');\">".$linkTitle." <img style=\"cursor:pointer;border:0px;\" id=\"direction".$formName."\" src=\"components/com_comprofiler/plugin/user/plug_cbprofilebook/smilies/none-arrow.gif\" alt=\"\" /></a>";

		$return .= $this->_bbeditor($item, $formName, $txtSubmit, $curruser, $pbEnableRating, $pbUseLocation, $pbLocationField, $pbUseWebAddress, $pbWebField, $required, $pbAllowBBCode, $pbAllowSmiles);
		if ($showform) $return .= "\n<script> pb_Expand('".$formName."', ''); </script>\n";
		return $return;
	}

	function _bbeditor($item, $idTag, $txtSubmit , $curruser, $pbEnableRating, $pbUseLocation, $pbLocationField, $pbUseWebAddress, $pbWebField, $required, $pbAllowBBCode, $pbAllowSmiles) {
		global $my, $database, $ueConfig, $acl;

		if ($item == null) {
			$item = new stdClass();
			$item->postercomment = null;
			$item->postername = null;
			$item->posterlocation = null;
			$item->posteremail = null;
			$item->posterurl = null;
			$item->postervote = null;
			$item->posterid = -1;
			$item->pbid=null;
		}

		$htmltext="";
		$htmltext .= "<div id=\"div".$idTag."\" style=\"display:none;width:100%;\">";

		//get the CB initiatied form action path this is used for all forms
		$base_url = $this->_getAbsURLwithParam(array());
		$htmltext .= "<form name=\"admin".$idTag."\" id=\"admin".$idTag."\" method=\"post\" onsubmit=\"javascript: return pb_submitForm(this);\" action=\"".$base_url."\">\n";
		$htmltext .= "<input type=\"hidden\" name=\"".$this->_getPagingParamName("formaction")."\" value=\"".($item->pbid?"edit":"new")."\" />\n";
		if ($item->pbid) {
			$htmltext .= "<input type=\"hidden\" name=\"".$this->_getPagingParamName("id")."\" value=\"".$item->pbid."\" />\n";
		}
		if ($pbAllowBBCode) $editor = $this->getEditor($idTag);
		else $editor = null;
		$htmltext .= "<table width=\"100%\">\n";
		$locationField=null;
		//Check to see if the Location field should be used
		if($pbUseLocation) {
			//Check to see if a registered user is logged in and if the admin has defined a a value for the location field
			if($my->id && $pbLocationField!=0) {
				$locationField=new moscomprofilerFields($database);
				$locationField->load($pbLocationField);
				$pbLocationField=$locationField->name;
				//if they true then display the location value from the users cb profile in read only
				$locationField= "<td class=\"titleCell\">"._pb_Location.":<br /><input class=\"inputbox\" type=\"hidden\" name=\"".$this->_getPagingParamName("posterlocation")."\" value=\"".htmlspecialchars($curruser->$pbLocationField)."\" />".getFieldValue('text',$curruser->$pbLocationField,$curruser)."</td>";
			} else {
				//else display an entry field to capture the location
				$locationField= "<td class=\"titleCell\">"._pb_Location.":<br /><input class=\"inputbox\" type=\"text\" name=\"".$this->_getPagingParamName("posterlocation")."\" value=\"".htmlspecialchars($item->posterlocation)."\" /></td>";
			}
		}

		$webField=null;
		if($pbUseWebAddress) {
			if($my->id && $pbWebField!=0) {
				$webfield=new moscomprofilerFields($database);
				$webfield->load($pbWebField);
				$pbWebField=$webfield->name;
				$webField= "<td class=\"titleCell\">"._pb_Url.":<br /><input class=\"inputbox\" type=\"hidden\" name=\"".$this->_getPagingParamName("posterurl")."\" value=\"".$curruser->$pbWebField."\" />".getFieldValue('webaddress',$curruser->$pbWebField,$curruser)."</td>";
			} else {
				$webField= "<td class=\"titleCell\">"._pb_Url.":<br /><input class=\"inputbox\" type=\"text\" name=\"".$this->_getPagingParamName("posterurl")."\" value=\"".htmlspecialchars($item->posterurl)."\" /></td>";
			}
		}

		if(!$my->id) {
			$htmltext .= "\n<tr><td class=\"titleCell\" >"._pb_Name.":<br /><input class=\"inputbox\" type=\"text\" name=\"".$this->_getPagingParamName("postername")."\" value=\"".htmlspecialchars($item->postername)."\" /></td>";
			$htmltext .= "<td class=\"titleCell\" >"._pb_Email.":<br /><input class=\"inputbox\" type=\"text\" name=\"".$this->_getPagingParamName("posteremail")."\" value=\"".htmlspecialchars($item->posteremail)."\" /></td></tr>";
		} else {
			$htmltext .= "\n<tr><td class=\"titleCell\" >"._pb_Name.":<br /><input class=\"inputbox\" type=\"hidden\" name=\"".$this->_getPagingParamName("postername")."\" value=\"".htmlspecialchars($item->postername? $item->postername : getNameFormat($curruser->name,$curruser->username,$ueConfig['name_format']))."\" />".htmlspecialchars($item->postername? $item->postername : getNameFormat($curruser->name,$curruser->username,$ueConfig['name_format']))."</td>";
			$htmltext .= "<td class=\"titleCell\" >"._pb_Email.":<br />";
			if (!$item->posteremail || $my->id==$item->posterid || $acl->acl_check( 'administration', 'manage', 'users', $my->usertype, 'components', 'com_users' )) {
				$htmltext .= "<input class=\"inputbox\" type=\"hidden\" name=\"".$this->_getPagingParamName("posteremail")."\" value=\"".($item->posteremail?htmlspecialchars($item->posteremail):$curruser->email)."\" />".($item->posteremail?htmlspecialchars($item->posteremail):getFieldValue('text',$curruser->email,$curruser));
			} else {
				$htmltext .= _pb_Hidden;
			}
			$htmltext .= "</td></tr>";
		}

		//Check to see if we are displaying the web address or location field. If we are then add a row for them
		if($webField!=null || $locationField!=null) $htmltext .= "\n<tr>".$locationField.$webField."</tr>";

		$htmltext .= "<tr><td colspan=\"2\">";

		//Check to see if the admin has enabled rating for profile entries
		if ($pbEnableRating){
			//Yep its enabled so get the ratings HTML/Code
			$htmltext .= "<tr><td colspan=\"2\"><span class=\"titleCell\">"._pb_UserRating.":</span><br />"
					  .$this->getRatingForm($item->postervote)."<br /><br />";
		}

		$htmltext .= "<span class=\"titleCell\">"._pb_Comments.":</span><br />".$editor
					."<table style=\"table-layout:auto;width:100%\">\n<tr>\n";
		if ($pbAllowSmiles) {
			$htmltext .= "<td width=\"60%\">\n";
		} else {
			$htmltext .= "<td width=\"100%\">\n";
		}
		$htmltext .= "<textarea class=\"inputbox\" name=\"".$this->_getPagingParamName("postercomments")
					."\" rows=\"7\" cols =\"40\" style=\"height: 100px; width: 95%; overflow:auto;\" >"
					.htmlspecialchars($item->postercomment)."</textarea>\n</td>\n";
		if ($pbAllowSmiles) {
			$htmltext .= "<td>\n".$this->getSmilies($idTag)."</td>\n";
		}
		$htmltext .= "</tr>\n</table>\n<br /></td></tr>";

		$htmltext .= "<tr><td colspan=\"2\"><input class=\"button\" name=\"submitentry\" type=\"submit\" value=\"".$txtSubmit."\" /></td></tr>\n";
		$htmltext .= "</table>\n";
		$htmltext .= "</form>\n";
		$htmltext .="</div>\n";

		//Add the localized Javascript Paramaters so that error messages are properly translated
		$validateArray = array();
		if ($required) {
			$validateArray[] = array("field"=>"postername",		"confirm"=>null,	"error"=>_pb_NameRequired);
			$validateArray[] = array("field"=>"posteremail",	"confirm"=>null,	"error"=>_pb_EmailRequired);
		}
		if ($pbEnableRating == 3) {
			$validateArray[] = array("field"=>$this->_getPagingParamName("postervote"),	"confirm"=>null,	"error"=>_pb_RatingRequired);
		} elseif ($pbEnableRating == 2) {
			$validateArray[] = array("field"=>$this->_getPagingParamName("postervote"),	"confirm"=>_pb_RatingUnselectedAreYouSure,	"error"=>null);
		}
		$validateArray[] 	 = array("field"=>"profilebookpostercomments",	"confirm"=>null,	"error"=>_pb_CommentRequired);
		
		$res = array();
		foreach ($validateArray as $validateField) {
			$res[] = "Array('".$validateField["field"]."',"
							."'".str_replace(array("'","\\"),array("\\'","\\\\"),$validateField["confirm"])."',"
							."'".str_replace(array("'","\\"),array("\\'","\\\\"),$validateField["error"])."')";
		}
		$htmltext .="\n\n<script type=\"text/javascript\">\n";
		$htmltext .="var _admin".$idTag."_validations = Array( ".implode(",",$res).");\n";
		$htmltext .="var _admin".$idTag."_bbcodestack = Array();\n";
		$htmltext .="</script>\n\n";

		return $htmltext;
	}
	
	function _getpbJS() {
		global $mosConfig_live_site;
		$editor=null;
		$editor .="\n<script type=\"text/javascript\" src=\"".$mosConfig_live_site."/components/com_comprofiler/plugin/user/plug_cbprofilebook/bb_adm.js\"></script>\n";
/*
		$editor .="<script type=\"text/javascript\">\n";
		$editor .="b_help = \""._pb_BOLD."\";\n";
		$editor .="i_help = \""._pb_ITALIC."\";\n";
		$editor .="u_help = \""._pb_UNDERL."\";\n";
		$editor .="q_help = \""._pb_QUOTE."\";\n";
		$editor .="c_help = \""._pb_CODE."\";\n";
		$editor .="k_help = \""._pb_ULIST."\";\n";
		$editor .="o_help = \""._pb_OLIST."\";\n";
		$editor .="p_help = \""._pb_IMAGE."\";\n";
		$editor .="w_help = \""._pb_LINK."\";\n";
		$editor .="a_help = \""._pb_CLOSE."\";\n";
		$editor .="s_help = \""._pb_COLOR."\";\n";
		$editor .="f_help = \""._pb_SIZE."\";\n";
		$editor .="l_help = \""._pb_LITEM."\";\n";
		$editor .="iu_help = \""._pb_IMAGE_DIMENSIONS.": x -  KB\";\n";
		$editor .="fu_help = \""._pb_FILE_TYPES.":  - KB\";\n";
		$editor .="submit_help = \""._pb_HELP_SUBMIT."\";\n";
		$editor .="preview_help = \""._pb_HELP_PREVIEW."\";\n";
		$editor .="cancel_help = \""._pb_HELP_CANCEL."\";\n";
		$editor .="</script>\n";
*/
		return $editor;
	}
	
	function getEditor($idTag) {
		$editor=null;
		$editor .='<table border="0" cellspacing="0" cellpadding="0">';
		$editor .='    <tr>';
		$editor .='       <td style="padding: 2px 1px 2px 0px;"><input type="button" class="button" accesskey="b" name="addbbcode0" value="B" style="font-weight:bold; width: 30px" onclick="bbstyle(this.form,0)" onmouseover="helpline(\'b\')" title="'._pb_HELP_BOLD.'" />';
		$editor .='       <input type="button" class="button" accesskey="i" name="addbbcode2" value="i" style="font-style:italic; width: 30px" onclick="bbstyle(this.form,2)" onmouseover="helpline(\'i\')" title="'._pb_HELP_ITALIC.'" />';
		$editor .='       <input type="button" class="button" accesskey="u" name="addbbcode4" value="u" style="text-decoration: underline; width: 30px" onclick="bbstyle(this.form,4)" onmouseover="helpline(\'u\')" title="'._pb_HELP_UNDERL.'" />';
		$editor .='       <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 55px" onclick="bbstyle(this.form,6)" onmouseover="helpline(\'q\')" title="'._pb_HELP_QUOTE.'" />';
		$editor .='       <input type="button" class="button" accesskey="k" name="addbbcode10" value="ul" style="width: 40px" onclick="bbstyle(this.form,10)" onmouseover="helpline(\'k\')" title="'._pb_HELP_ULIST.'" />';
		$editor .='       <input type="button" class="button" accesskey="o" name="addbbcode12" value="ol" style="width: 40px" onclick="bbstyle(this.form,12)" onmouseover="helpline(\'o\')" title="'._pb_HELP_OLIST.'" />';

		$editor .='       <input type="button" class="button" accesskey="l" name="addbbcode18" value="li" style="width: 40px" onclick="bbstyle(this.form,18)" onmouseover="helpline(\'l\')" title="'._pb_HELP_LITEM.'" />';
		//      $editor .='       <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onclick="bbstyle(this.form,14)" onmouseover="helpline(\'p\')" />';
		$editor .='       <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onclick="bbstyle(this.form,16)" onmouseover="helpline(\'w\')" title="'._pb_HELP_LINK.'" /></td>';
		$editor .='    </tr><tr>';
		$editor .='      <td style="padding: 2px 1px 2px 0px;">&nbsp;<span title="'._pb_HELP_COLOR.'">'._pb_Color.':</span>';
		$editor .='         <select name="addbbcode20" onchange="bbfontstyle(document.admin'.$idTag.'.profilebookpostercomments,\'[color=\' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" onmouseover="helpline(\'s\')" title="'._pb_HELP_COLOR.'" class="button">';
		$editor .='                     <option style="color:black;   background-color: #FAFAFA" value="">'._pb_Standard.'</option>';
		$editor .='                     <option style="color:#FF0000; background-color: #FAFAFA" value="#FF0000">'._pb_Red.'</option>';

		$editor .='                     <option style="color:#800080; background-color: #FAFAFA" value="#800080">'._pb_Purple.'</option>';
		$editor .='                     <option style="color:#0000FF; background-color: #FAFAFA" value="#0000FF">'._pb_Blue.'</option>';
		$editor .='                     <option style="color:#008000; background-color: #FAFAFA" value="#008000">'._pb_Green.'</option>';
		$editor .='                    <option style="color:#FFFF00; background-color: #FAFAFA" value="#FFFF00">'._pb_Yellow.'</option>';
		$editor .='                     <option style="color:#FF6600; background-color: #FAFAFA" value="#FF6600">'._pb_Orange.'</option>';
		$editor .='                     <option style="color:#000080; background-color: #FAFAFA" value="#000080">'._pb_Darkblue.'</option>';

		$editor .='                     <option style="color:#825900; background-color: #FAFAFA" value="#825900">'._pb_Brown.'</option>';
		$editor .='                     <option style="color:#9A9C02; background-color: #FAFAFA" value="#9A9C02">'._pb_Gold.'</option>';
		$editor .='                     <option style="color:#A7A7A7; background-color: #FAFAFA" value="#A7A7A7">'._pb_Silver.'</option>';
		$editor .='                   </select> &nbsp;<span title="'._pb_HELP_SIZE.'">'._pb_Size.':</span><select name="addbbcode22" onchange="bbfontstyle(document.admin'.$idTag.'.profilebookpostercomments,\'[size=\' + this.form.addbbcode22.options[this.form.addbbcode22.selectedIndex].value + \']\', \'[/size]\');this.selectedIndex=2;" onmouseover="helpline(\'f\')" title="'._pb_HELP_SIZE.'" class="button">';
		$editor .='                     <option value="1">'._pb_VerySmall.'</option>';
		$editor .='                     <option value="2">'._pb_Small.'</option>';
		$editor .='                     <option value="3" selected="selected">'._pb_Normal.'</option>';
		$editor .='                     <option value="4">'._pb_Big.'</option>';
		$editor .='                     <option value="5">'._pb_VeryBig.'</option>';
		$editor .='                   </select>';
		$editor .='                  &nbsp;&nbsp;<a href="javascript:bbstyle(document.admin'.$idTag.',-1)" onmouseover="helpline(\'a\')" title="'._pb_HELP_CLOSE.'"><small>'._pb_CloseAll.'</small></a>';
		$editor .='		</td>';
		$editor .='    </tr>';

		//$editor .='    <tr>';
		//$editor .='       <td style="padding: 2px 1px 2px 0px;"><input type="text" name="helpbox"id="helpbox" size="45" class="inputbox" maxlength="100" style="width: 450px; font-size:9px; border: 0px" value="bbCode Help - Hint: bbCode can be used on selected text!" /></td>';
		//$editor .='    </tr>';
		$editor .=' </table>';
		return $editor;
	}
	
	function smiliesArray() {
				$smilies = array(
					 ':)'=>'smile.png'
					,';)'=>'wink.png'
					,'B)'=>'cool.png'
					,'8)'=>'cool.png'
					,':lol:'=>'grin.png'
					,':laugh:'=>'laughing.png'
					,':cheer:'=>'cheerful.png'
					,':kiss:'=>'kissing.png'
					,':silly:'=>'silly.png'
					,':ohmy:'=>'shocked.png'
					,':woohoo:'=>'w00t.png'
					,':whistle:'=>'whistling.png'
					,':('=>'sad.png'
					,':angry:'=>'angry.png'
					,':blink:'=>'blink.png'
					,':sick:'=>'sick.png'
					,':unsure:'=>'unsure.png'
					,':dry:'=>'ermm.png'
					,':huh:'=>'wassat.png'
					,':pinch:'=>'pinch.png'
					,':side:'=>'sideways.png'
					,':evil:'=>'devil.png'
					,':blush:'=>'blush.png'
					,':-)'=>'smile.png'
					,':-('=>'sad.png'
					,';-)'=>'wink.png'
					,':S'=>'dizzy.png'
					,':s'=>'dizzy.png'
					,':P'=>'tongue.png'
					,':p'=>'tongue.png'
					,':D'=>'laughing.png'
					,':X'=>'sick.png'
					,':x'=>'sick.png');
					return $smilies;
	}
	
	function getSmilies($idTag) {
		$params = $this->params;
		$pbAllowSmiles=$params->get('pbAllowSmiles', '1'); //Determine if Smilies are allowed
		if(!$pbAllowSmiles) {
			return null;
		}
		$smilies = $this->smiliesArray();
		$return=null;
		$outputed = array();
		foreach($smilies as $code => $location) {
			if (!in_array($location,$outputed)) {
				$return .= '<img onclick="javascript:pb_emo(document.admin'.$idTag.'.profilebookpostercomments,\'' . $code .'\');" style="cursor:pointer" class="btnImage" src="components/com_comprofiler/plugin/user/plug_cbprofilebook/smilies/' . $location. '" alt="' . $code . '" title="' . $code . '" /> ';
				$outputed[] = $location;
			}
		}	
		return $return;	
	}
	
	function getRatingForm($vote) {
		global $mosConfig_live_site;
		
		// look for images in template if available
		if (is_callable(array("mosAdminMenus","ImageCheck"))) {
			$starImageOn = mosAdminMenus::ImageCheck( 'rating_star.png', '/images/M_images/' );
			$starImageOff = mosAdminMenus::ImageCheck( 'rating_star_blank.png', '/images/M_images/' );
		} else {			// Mambo 4.5.0:
			$starImageOn  = '<img src="'.$mosConfig_live_site.'/images/M_images/rating_star.png" alt="" align="middle" style="border:0px;" />';
			$starImageOff = '<img src="'.$mosConfig_live_site.'/images/M_images/rating_star_blank.png" alt="" align="middle" style="border:0px;" />';
		}
		$chk = ' checked="checked"';
		$html=null;
		$html .= '<span class="content_vote">';
		$html .= _VOTE_POOR;
		$html .= '<input type="radio" alt="vote 1 star" name="'.$this->_getPagingParamName("postervote").'"'.($vote==1?$chk:'').' value="1" />';
		$html .= '<input type="radio" alt="vote 2 star" name="'.$this->_getPagingParamName("postervote").'"'.($vote==2?$chk:'').' value="2" />';
		$html .= '<input type="radio" alt="vote 3 star" name="'.$this->_getPagingParamName("postervote").'"'.($vote==3?$chk:'').' value="3" />';
		$html .= '<input type="radio" alt="vote 4 star" name="'.$this->_getPagingParamName("postervote").'"'.($vote==4?$chk:'').' value="4" />';
		$html .= '<input type="radio" alt="vote 5 star" name="'.$this->_getPagingParamName("postervote").'"'.($vote==5?$chk:'').' value="5" />';
		$html .= _VOTE_BEST;
		$html .= '</span>';
		return $html;
	}
	
	function _getRatingImage( $rating, $alwaysShowStars=false ) {
		global $mosConfig_live_site;

		if (!$alwaysShowStars && $rating === null) return "";
		
		//get standard joomla rating stars for template
		if (is_callable(array("mosAdminMenus","ImageCheck"))) {
			$starImageOn = mosAdminMenus::ImageCheck( 'rating_star.png', '/images/M_images/' );
			$starImageOff = mosAdminMenus::ImageCheck( 'rating_star_blank.png', '/images/M_images/' );
		} else {			// Mambo 4.5.0:
			$starImageOn  = '<img src="'.$mosConfig_live_site.'/images/M_images/rating_star.png" alt="" align="middle" style="border:0px;" />';
			$starImageOff = '<img src="'.$mosConfig_live_site.'/images/M_images/rating_star_blank.png" alt="" align="middle" style="border:0px;" />';
		}
		
		$img="";
		
		//return $rating;
		
		//get all the colored rating images
		for ($j=0; $j < $rating; $j++) {
			$img .= $starImageOn;
		}
		//get all the grayed out rating images
		for ($j=$rating; $j < 5; $j++) {
			$img .= $starImageOff;
		}			
	
		return $img;
	}
	
	function parseSmilies($text){
		$smilies = $this->smiliesArray();
		foreach($smilies as $code => $location) {
			$text = str_replace($code,'<img src="components/com_comprofiler/plugin/user/plug_cbprofilebook/smilies/'. $location . '" alt="" style="vertical-align: middle;border:0px;" />',$text);
		}
		return $text;
	}
	
	function parseBBCode($text, $pbAllowBBCode, $pbAllowSmiles) {
		if ($pbAllowSmiles) {
			$text = $this->parseSmilies($text);
		}
		if ($pbAllowBBCode) {
			require_once("components/com_comprofiler/plugin/user/plug_cbprofilebook/classes/bbcode.inc.php");
			$bbcode = new bbcode();
			$bbcode->add_tag(array('Name'=>'quote','HtmlBegin'=>'<div style="padding:5px;border:solid 1px #000000;background-color:#e6e6e6;color:#000000;font-family: Arial, Verdana, sans-serif;font-size: 9px;display: block;">','HtmlEnd'=>'</div>'));
			$bbcode->add_tag(array('Name'=>'b','HtmlBegin'=>'<span style="font-weight: bold;">','HtmlEnd'=>'</span>'));
			$bbcode->add_tag(array('Name'=>'ul','HtmlBegin'=>'<ul>','HtmlEnd'=>'</ul>'));
			$bbcode->add_tag(array('Name'=>'ol','HtmlBegin'=>'<ol type="1">','HtmlEnd'=>'</ol>'));
			$bbcode->add_tag(array('Name'=>'li','HtmlBegin'=>'<li>','HtmlEnd'=>'</li>'));
			$bbcode->add_tag(array('Name'=>'i','HtmlBegin'=>'<span style="font-style: italic;">','HtmlEnd'=>'</span>'));
			$bbcode->add_tag(array('Name'=>'u','HtmlBegin'=>'<span style="text-decoration: underline;">','HtmlEnd'=>'</span>'));
			$bbcode->add_tag(array('Name'=>'link','HasParam'=>true,'HtmlBegin'=>'<a href="%%P%%">','HtmlEnd'=>'</a>'));
			$bbcode->add_tag(array('Name'=>'img','HasParam'=>true,'HtmlBegin'=>'<img src="%%P%%" size="%%P%%" alt="" />','HasEnd'=>false));
			$bbcode->add_tag(array('Name'=>'color','HasParam'=>true,'ParamRegex'=>'[A-Za-z0-9#]+','HtmlBegin'=>'<span style="color: %%P%%;">','HtmlEnd'=>'</span>','ParamRegexReplace'=>array('/^[A-Fa-f0-9]{6}$/'=>'#$0')));
			$bbcode->add_tag(array('Name'=>'email','HasParam'=>true,'HtmlBegin'=>'<a href="mailto:%%P%%">','HtmlEnd'=>'</a>'));
	//		$bbcode->add_tag(array('Name'=>'size','HasParam'=>true,'HtmlBegin'=>'<span style="font-size:%%P%%pt;">','HtmlEnd'=>'</span>','ParamRegex'=>'[0-9]+'));
			$bbcode->add_tag(array('Name'=>'size','HasParam'=>true,'HtmlBegin'=>'<span style="font-size:%%P%%%;">','HtmlEnd'=>'</span>','ParamRegexReplace'=>array('/^1$/'=>'80','/^2$/'=>'90','/^3$/'=>'100','/^4$/'=>'125','/^5$/'=>'200') ));
			$bbcode->add_tag(array('Name'=>'align','HtmlBegin'=>'<div style="text-align: %%P%%">','HtmlEnd'=>'</div>','HasParam'=>true,'ParamRegex'=>'(center|right|left)'));
			$bbcode->add_alias('url','link');
			$text = $bbcode->parse_bbcode($text);
		}
		return $text;
	}
	
	/**
	* ProfileBook Internal method: sets User Status
	* @access private
	* @param array sbConfig
	* @param object user being displayed
	* @param object sbUserDetails
	*/
	function _setStatusMenuPBstats(&$params, $value) {
		if ($params->get('pbStatRating', '1')) {
			$mi = array(); $mi["_UE_MENU_STATUS"][getLangDefinition($params->get('pbStatRatingText', "_pb_DefaultRatingText"))]["duplicate"]=null;
			$this->addMenu( array(	"position"	=> "menuList" ,		// "menuBar", "menuList"
								"arrayPos"	=> $mi ,
								"caption"	=> $value ,
								"url"		=> "" ,		// can also be "<a ....>" or "javascript:void(0)" or ""
								"target"	=> "" ,		// e.g. "_blank"
								"img"		=> null ,	// e.g. "<img src='plugins/user/myplugin/images/icon.gif' width='16' height='16' alt='' />"
								"alt"		=> null ,	// e.g. "text"
								"tooltip"	=> "") );
		}

	}
	
	/**
	* Generates the menu and user status to display on the user profile by calling back $this->addMenu
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns boolean : either true, or false if ErrorMSG generated
	*/
	function getMenuAndStatus($tab,$user,$ui) {
		$this->_getLanguageFile();
		$params=$this->params;
		$pbStatDisplay=$params->get('pbStatRating', '1');
		if ($pbStatDisplay==1) {
			$value = $this->_getAvgRating($user);
			$this->_setStatusMenuPBstats($params, $value);
		}
		return true;
	}

	function _getAvgRating($user){
		global $database;
		$sql = "SELECT ROUND(AVG(postervote),0) FROM #__comprofiler_plug_profilebook WHERE userid=".$user->id;
		$database->setQuery($sql);
		$value = $database->loadResult();
		
		return $this->_getRatingImage($value, true);
	}

}	// end class getForumTab.
?>
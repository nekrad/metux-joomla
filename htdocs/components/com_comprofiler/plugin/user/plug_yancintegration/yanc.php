<?php
/**
* Newsletter Tab Class for handling the CB tab api
* @version $Id: yanc.php 396 2006-08-24 14:16:31Z beat $
* @package Community Builder
* @subpackage yanc.php
* @author Beat
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_PLUGINS->registerFunction( 'onUserActive', 'userActivated','getNewslettersTab' );
$_PLUGINS->registerFunction( 'onAfterDeleteUser', 'userDeleteTab','getNewslettersTab' );

DEFINE('_NEWSLETTERFILE','/administrator/components/com_yanc/classes/class.yancsubscription.php');

class getNewslettersTab extends cbTabHandler {
	/**
	* Constructor
	*/	
	function getNewslettersTab() {
		$this->cbTabHandler();
	}
	// function getDisplayTab($tab,$user,$ui) {
	// }
	/**
	* Generates the HTML to display the user edit tab
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getEditTab( $tab, $user, $ui) {
		global $my, $mainframe, $_POST;
		if(intval($my->id) < 1){
			mosNotAuth();
			return false;
		}
		if(!$this->_CheckYancInstalled()) {
			return _UE_NEWSLETTERNOTINSTALLED;
		}
		require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
		$newslettersSubscriptions = new YancSubscription();

		$return="";
	
		if ($user->id) {
			$rows = $newslettersSubscriptions->getSubscriberLists($user);

			if (isset($_POST['newsLhtml'])) {
				$postedLists = cbGetParam($_POST, 'newsLitems', array());
				$postedHtml = cbGetParam($_POST, 'newsLhtml', 1);
				
				for ($i = 0, $n=count($rows); $i < $n; $i++) {
					$rows[$i]->subscribed = in_array($rows[$i]->id,$postedLists);
					$rows[$i]->receive_html = $postedHtml;
				}
			}
		} else {
			$params=$this->params;
			$newslettersRegList=$params->get('newslettersRegList');
			$listsArray = (isset($newslettersRegList)) ? explode("|*|", $newslettersRegList) : null;
			$rows = $newslettersSubscriptions->getLists($my, $listsArray);
			
			$postedLists = cbGetParam($_POST, 'newsLitems', array());
			$postedHtml = cbGetParam($_POST, 'newsLhtml', 1);

			for ($i = 0, $n=count($rows); $i < $n; $i++) {
				$rows[$i]->subscribed = in_array($rows[$i]->id,$postedLists);
				$rows[$i]->receive_html = $postedHtml;
			}
		}
	
		if(count($rows)==0) {
			$return = _UE_NONEWSLETTERS;
		} else {
			if($tab->description != null) $return .= "\t\t<div class=\"tab_Description\">".unHtmlspecialchars(getLangDefinition($tab->description))."</div>\n";
			$return .= $this->_getFormattedNewsletters($rows, false, _UE_NEWSLETTER_NAME, _UE_NEWSLETTER_DESCRIPTION);
		}
		return $return;
	}
	
	//private method:
	function _getFormattedNewsletters($rows, $linesStyle, $name=_UE_NEWSLETTER_NAME, $desc=_UE_NEWSLETTER_DESCRIPTION) {
		$htmltext = array();
		$htmltext[] = mosHTML::makeOption( '1', _UE_NEWSLETTER_HTML."&nbsp;&nbsp;&nbsp;" );
		$htmltext[] = mosHTML::makeOption( '0', _UE_NEWSLETTER_TEXT );

		$return = "<div class='newslettersList'>"
		. "<table style='width:100%; border:0px;' cellspacing='0' cellpadding='0'>\n";
		if (!$linesStyle) $return .= "\t<tr>\n"
		. "\t\t<th class='captionCell'>".$name."</th>\n"
		. "\t\t<th class='captionCell'>".$desc."</th>\n"
		. "\t</tr>\n";
		foreach ($rows AS $row) {
			$return .= "\t<tr>\n";
			$return .= "\t\t<td style='width:".($linesStyle ? "2%" : "30%").";' class='fieldCell'>";
			$return .= "<input type='checkbox' style='margin-right: 8px;' name='newsLitems[]' value=\"".$row->id."\" ";
			if ($row->subscribed) $return .= 'checked="checked" ';
			$return .= "/> ";
			if ($linesStyle) $return .= "</td>\n\t\t<td style='width:98%;' class='fieldCell'>";
			$return .= "<span class='captionCell'>".getLangDefinition($row->list_name)."</span>";
			if ($row->subscribed && (!$row->confirmed)) $return .= "<br /><span class='fieldError'>("._UE_NEWSLETTER_NOT_CONFIRMED.")</span>";
			if ($linesStyle) $return .= "<br />";
			else $return .= "</td>\n\t\t<td class='fieldCell'>";
			$return .= "<span class='fieldCell'>".getLangDefinition($row->list_desc)."</span>"."</td>\n";
			$return .= "\t</tr>\n";
		}
		$return .= "\t<tr>\n\t\t<td class='captionCell' colspan='2'>"
		. "<span class='captionCell' id='newsLettersFormatTitle'>"._UE_NEWSLETTER_FORMAT_TITLE . ":"."</span>"
		. "</td>\n\t</tr>\n";
		$return .= "\t<tr>\n\t\t<td style='width:20%;' class='fieldCell'".($linesStyle ? " colspan='2'" : "").">";
		$return .= "<span class='fieldCell' id='newsLettersFormatField'>"._UE_NEWSLETTER_FORMAT_FIELD."</span>";
		if ($linesStyle) $return .= "&nbsp;&nbsp;";
		else $return .= "</td>\n\t\t<td class='fieldCell'>";
		$return .= moscomprofilerHTML::radioList($htmltext, 'newsLhtml','class="inputbox" size="1"', 'value', 'text', $rows[0]->receive_html );
		$return .= "</td>\n";
		
		$return .= "\t</tr>\n";
		$return .= "</table>";
		$return .= "</div>";
		return $return;
	}
	/**
	* Saves the user edit tab postdata into the tab's permanent storage
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function saveEditTab($tab, &$user, $ui, $postdata) {
		global $my, $mainframe, $_POST;
		if(intval($my->id) < 1) {
			mosNotAuth();
			return;
		}
		if(!$this->_CheckYancInstalled()) {
			return;
		}
		require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
		$newslettersSubscriptions = new YancSubscription();

		$lists = cbGetParam($_POST, 'newsLitems', array());
		$html = cbGetParam($_POST, 'newsLhtml', 0);
		$subscribemessage = !($ui==2 && $user->approved && $user->confirmed);
		$result = $newslettersSubscriptions->saveMassSubscribe($user, $lists, $html, $subscribemessage);
		if ($result) {
			$this->_setErrorMSG($result);
		}
	}
	/**
	* Generates the HTML to display the registration tab/area
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed (here null)
	* @param int 1 for front-end, 2 for back-end
	* @return mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function getDisplayRegistration($tab, $user, $ui) {
		global $my, $mainframe, $_POST;;
		
		if(!$this->_CheckYancInstalled()) {
			return null;
		}
		if (true) {
			require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
			$newslettersSubscriptions = new YancSubscription();
			$params=$this->params;
			$newslettersRegList=$params->get('newslettersRegList');
			$listsArray = (isset($newslettersRegList)) ? explode("|*|", $newslettersRegList) : null;
			$lists = $newslettersSubscriptions->getLists($my, $listsArray);
			if (count($lists) > 0){

				$postedLists = cbGetParam($_POST, 'newsLitems', array());
				$postedHtml = cbGetParam($_POST, 'newsLhtml', 1);

				$lists[0]->receive_html = $postedHtml;
				for ($i = 0, $n=count($lists); $i < $n; $i++) {
					$lists[$i]->subscribed = in_array($lists[$i]->id,$postedLists);
					$lists[$i]->confirmed = $lists[$i]->subscribed;	// avoid display "not confirmed" on registration server-validation error.
				}
				$return = "\t<tr>\n";
				$return .= "\t\t<td class='titleCell'>" . _UE_NEWSLETTER_SUBSCRIBE . "</td>\n";
				$return .= "\t\t<td class='fieldCell'>";
				$return .= $this->_getFormattedNewsletters($lists, true, _UE_NEWSLETTER_NAME_REG, _UE_NEWSLETTER_DESCRIPTION_REG);
				$return .= "</td>";
				$return .= "\t</tr>\n";
				$return .= "\t<tr><td class='titleCell'>&nbsp;</td><td class='fieldCell' id='newslettersSpacer'>&nbsp;</td></tr>\n";
				return $return;
			}
		}
	}
	/**
	* Saves the registration tab/area postdata into the tab's permanent storage
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed (here null)
	* @param int 1 for front-end, 2 for back-end
	* @param array _POST data for saving edited tab content as generated with getEditTab
	* @return boolean : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function saveRegistrationTab($tab, &$user, $ui, $postdata) {
		global $ueConfig, $mainframe;

		if(!$this->_CheckYancInstalled()) {
			return null;
		}
		$ret = null;
		if (true) {
			require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
			$newslettersSubscriptions = new YancSubscription();

			$lists			=	cbGetParam($postdata, 'newsLitems', array());
			$html			=	cbGetParam($postdata, 'newsLhtml', 1);

			$sendEmail		=	(($ueConfig['reg_confirmation']!="1") and ($ueConfig['reg_admin_approval']!="1"));

			$result = $newslettersSubscriptions->saveMassSubscribe($user, $lists, $html, $sendEmail);
			if ($result !== true) {
				$this->_setErrorMSG($result);
				$ret 	=	false;
			}
		}
		return $ret;
	}
	/**
	* Called once ConfirmationCode verified and user found and approved by moderator if needed
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function userActivated($user, $success) {
		global $ueConfig, $mainframe, $mosConfig_uniquemail;

		if(!$this->_CheckYancInstalled()) {
			return true;
		}
		if ($success) {
			require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
			$newslettersSubscriptions = new YancSubscription();
			if ($mosConfig_uniquemail=='1') {
				$newslettersSubscriptions->updateUnregisteredSubscriber($user);
			}
			$confirmCode = md5($user->id);
			$result = $newslettersSubscriptions->confirmSubscriber($confirmCode);
			if ($result !== NULL) {
				$this->_setErrorMSG($result);
				return false;
			}
		} else {		//MJ: what to do else here ?
			return true;
		}
		return true;
	}
	/**
	* Called when a user is deleted from backend (prepare future unregistration)
	* @param object tab reflecting the tab database entry
	* @param object mosUser reflecting the user being displayed
	* @param int 1 for front-end, 2 for back-end
	* @returns mixed : either string HTML for tab content, or false if ErrorMSG generated
	*/
	function userDeleteTab($user, $success) {
		global $ueConfig, $mainframe;

		if(!$this->_CheckYancInstalled()) {
			return;
		}
		require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
		$newslettersSubscriptions = new YancSubscription();

		$newslettersSubscriptions->deleteSubscriber($user);
	}
	// Additional public method:
	/**
	* Returns list of all newsletters available
	* @return array of newsletter objects
	*/
	function getNewslettersList() {
		global $my, $mainframe;
	
		if(!$this->_CheckYancInstalled()) {
			return false;
		}		
		require_once( $mainframe->getCfg('absolute_path') . _NEWSLETTERFILE );
		$newslettersSubscriptions = new YancSubscription();

		return $newslettersSubscriptions->getLists($my);
	}
	
	// Private Method:
	/**
	* Checks if newsletters component installed
	* @return boolean true =installed, false = not
	*/
	function _CheckYancInstalled() {
		global $database, $mainframe;
		if(!file_exists($mainframe->getCfg('absolute_path') . _NEWSLETTERFILE)) {
			return false;
		}
		$query = "SELECT COUNT( * ) FROM #__components WHERE link LIKE '%com_yanc%'";
		$database->setQuery( $query );
		if ($database->LoadResult() < 1) {
			return false;
		}
		return true;
	}
	
	function loadNewslettersList($name,$value,$control_name) {
		$newslettersList = $this->getNewslettersList();
		$newslettersRegList = array();
		if ($newslettersList !== false) {
			foreach ($newslettersList AS $nl) {
				$newslettersRegList[] = mosHTML::makeOption( $nl->id, $nl->list_name);
			}
		}
		$valAsObj = (isset($value)) ?
		array_map(create_function('$v', '$o=new stdClass(); $o->value=$v; return $o;'), explode("|*|", $value ))
		: null;
		
		return moscomprofilerHTML::selectList( $newslettersRegList, $control_name .'['. $name .'][]', 'size="4" multiple="multiple"', 'value', 'text', $valAsObj, true );
	}
	
} // end class getNewslettersTab.
?>

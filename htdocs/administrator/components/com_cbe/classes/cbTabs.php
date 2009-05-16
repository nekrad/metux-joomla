<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
global $mainframe, $mosConfig_sitename;
$mosConfig_sitename =  $mainframe->getCfg('sitename');

/**
* Tab Creation handler
* @package Mambo
* @author Phil Taylor
*/
class cbTabs {
	/** @var int Use cookies */
	var $useCookies = 0;
	var $ui=0; /** 1=Front End 2=Admin */
	var $action=0; /** 1=Display 2=Edit */
	var $fieldJS=""; /** adds additional validation javascript for edit tabs */
	var $pane;

	/**
	* Constructor
	* Includes files needed for displaying tabs and sets cookie options
	* @param int useCookies, if set to 1 cookie will hold last used tab between page refreshes
	*/
	function __construct($useCookies,$ui,$templatedir=null) {
		$this->cbTabs($useCookies,$ui,$templatedir);
	}

	function cbTabs($useCookies,$ui,$templatedir=null) {
		global $ueConfig,$enhanced_Config, $user;
		jimport('joomla.html.pane');
		$this->pane =& JPane::getInstance('tabs'); 
		//die(print_r($this->pane));
		$database = &JFactory::getDBO();
		$this->ui=$ui;
		/*
		if($templatedir==null) $templatedir=$ueConfig['templatedir'];
		echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"" . substr_replace(JURI::root(), '', -1, 1). "/components/com_cbe/templates/".$templatedir."/tab.css\" />";
		*/
		$query = "SELECT profile_color
				  FROM #__cbe 
				  WHERE user_id = '".$user->id."'";
		$database ->setQuery ($query);
		$bgcolor = $database->loadResult();
        	
		if($enhanced_Config['profile_allow_colors']=='1') {
			if($bgcolor) {
				$bgcolor = getLangEnDefinition($bgcolor);
				$profileColor=profileColors($bgcolor);
			} elseif(!$bgcolor) {
				$color=$enhanced_Config['profile_color'];
				if($color) {
					$profileColor = $color;
				} else {
					$profileColor='transparent';
				}
			}
		}
        	
		if($enhanced_Config['profile_allow_colors']=='0') {
			$color=$enhanced_Config['profile_color'];
			if($color) {
				$profileColor = $color;
			} else {
				$profileColor='transparent';
			}
		}
		/*
		echo "<style type=\"text/css\"> \n";
		echo ".dynamic-tab-pane-control .tab-page { \n";
		echo "background:".$profileColor."; \n";
		echo "} \n";
		echo "</style> \n";

		echo "<script type=\"text/javascript\" src=\"". substr_replace(JURI::root(), '', -1, 1) . "/components/com_cbe/templates/tabpane.js\"></script>";
		*/
		$this->useCookies = $useCookies;
	}

	/**
	* creates a tab pane and creates JS obj
	* @param string The Tab Pane Name
	*/
	function startPane($id){
		$pane = $this->pane;
		//die($this->startPane($id));
		return $pane->startPane($id);
		/*
		$return = "<div class=\"tab-page\" id=\"".$id."\">";
		$return .= "<script type=\"text/javascript\">\n";
		$return .= "   var tabPane".$id." = new WebFXTabPane( document.getElementById( \"".$id."\" ), ".$this->useCookies." )\n";
		$return .= "</script>\n";
		return $return;
		*/
	}

	/**
	* Ends Tab Pane
	*/
	function endPane() {
		$pane = $this->pane;
		return $pane->endPane();
		/*
		$return =  "</div>";
		return $return;
		*/
	}

	/*
	* Creates a tab with title text and starts that tabs page
	* @param tabText - This is what is displayed on the tab
	* @param paneid - This is the parent pane to build this tab on
	*/

	function startTab( $pID, $tabText, $paneid ) {
		$pane = $this->pane;
		return $pane->startPanel($tabText, "tab" . $paneid);
		/*
		$return = "<div class=\"tab-page\" id=\"CBE_tabid_".$paneid."\">";
		$return .= "<h2 class=\"tab\">".$tabText."</h2>";
		$return .= "<script type=\"text/javascript\">\n";
		$return .= "  tabPane".$pID.".addTabPage( document.getElementById( \"CBE_tabid_".$paneid."\" ) );";
		$return .= "</script>";
		return $return;
		*/
	}

	/*
	* Ends a tab page
	*/
	function endTab() {
		$pane = $this->pane;
		return $pane->endPanel();
		/*
		$return =  "</div>";
		return $return;
		*/
	}
	function getViewTabs($user) {
		global $database,$ueConfig;
		$results="";
		$oNest="";
		$this->action=1;
		$tabimagepath=substr_replace(JURI::root(), '', -1, 1)."/components/com_cbe/templates/images/";

		$database->setQuery( "SELECT * FROM #__cbe_tabs t"
		. "\n WHERE t.enabled=1"
		. "\n ORDER BY t.ordering" );
		$oTabs = $database->loadObjectList();
		$results .= $this->startPane("CB");
		
		if($ueConfig['nesttabs']) {
			$tabimage="<img src=\"".$tabimagepath."icon_fav.gif\" border=\"0\" align=\"absmiddle\">";
			$oNest = $this->startTab("CB",_UE_PROFILETAB,0);
			$oNest .= $this->startPane("CBNest");
		}
// PK edit start
		$i_p = 0;
		foreach($oTabs AS $pTab) {
			$tabparams = new JParameter($pTab->enhanced_params);
			if ((@$tabparams->adminonly) && ($this->ui == 1)) {
				unset($oTabs[$i_p]);
			}
			$i_p++;
		}
		foreach ($oTabs as $pTab) {
			$tmp_tab[] = $pTab;
		}
		$oTabs = $tmp_tab;			
// PK edit end          
                        
		foreach($oTabs AS $oTab) {
			$oPContent="";
			$oFContent="";
			$oContent="";
			if($oTab->plugin!=null) {
				$oPContent = $this->_callTabPlugin($oTab->tabid, $user, $oTab->plugin, $oTab->plugin_include);
			}
			if($oTab->fields) {
				$oFContent = $this->_getViewTabContents($oTab->tabid,$user);
			}
			if($oPContent!="") $oContent .= $oPContent;
			if($oFContent!="") $oContent .= $oFContent;
			if($oContent!="") {
				if($ueConfig['nesttabs'] && $oTab->fields) {
					$oNest .= $this->startTab("CBNest",CBE_getLangDefinition($oTab->title),$oTab->tabid);
					$oNest .= "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"90%\"><tr><td>";
					$oNest .= $oContent;
					$oNest .= "\n\t</td></tr></table>";
					$oNest .= $this->endTab();
				} else {
					$results .= $this->startTab("CB",CBE_getLangDefinition($oTab->title),$oTab->tabid);
					$results .= "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\"><tr><td>";
					$results .= $oContent;
					$results .= "\n\t</td></tr></table>";
					$results .= $this->endTab();
				}
			}
		}
		if($ueConfig['nesttabs']) {
			$oNest .= $this->endPane();
			$oNest .= $this->endTab();
			$results=$oNest.$results;
		}
		$return = $this->startPane("CB");
		$return .= $results;
		$return .= $this->endPane();
		return $return;
	}


	function _getViewTabContents($tabid,$user) {
		global $ueConfig,$database;
		$return="";
		$results="";
		$whereAdd="";
		IF ($ueConfig['allow_email_display']==0) $whereAdd = " AND f.type != 'emailaddress' ";
		$database->setQuery( "SELECT * FROM #__cbe_fields f"
		. "\n WHERE f.published=1 AND f.profile=1 AND f.tabid = ".$tabid." "
		. $whereAdd
		. "\n ORDER BY f.ordering" );
		$oFields = $database->loadObjectList();

		$t=1;

		foreach($oFields AS $oField) {
			$fValue='$user->'.$oField->name;
			eval("\$fValue = \"".$fValue."\";");
			$oValue = getFieldValue($oField->type,stripslashes($fValue),$user);
			if($oValue!=null || trim($oValue)!='') {
				$evenodd = $t % 2;
				if ($evenodd == 0) {
					$class = "sectiontableentry1";
				} else {
					$class = "sectiontableentry2";
				}
				$t++;
				$results .= "\n\t\t\t\t<tr class=".$class.">";
				$results .= "\n\t\t\t\t\t<td style=\"font-weight:bold;width:40%;\">". CBE_getLangDefinition($oField->title) .":</td>";

				$results .= "\n\t\t\t\t\t<td>".$oValue."</td>";
				$results .= "\n\t\t\t\t</tr>";
			}
		}
		if($results!="") {
			$return = "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
			$return .= $results;
			$return .= "\n\t\t\t</table>";
		}
		return $return;
	}
	function _callTabPlugin($tabid, $user, $plugin, $plugin_include=null) {
		$return="";
		$results="";
		if(function_exists($plugin)) $results = call_user_func($plugin,$tabid,$user,$this->action,$this->ui);
		else $results = "ERROR: The function '".$plugin."' doesn't exist!";
		$return = $results;
		return $return;
	}
	function getEditTabs($user) {
		global $mosConfig_lang,$ueConfig;
		$database = &JFactory::getDBO();
		$acl =&JFactory::getACL();
		$my = &JFactory::getUser();

		$this->action=2;
		$results="";
		$database->setQuery( "SELECT * FROM #__cbe_tabs t"
		. "\n WHERE t.enabled=1 AND t.fields=1"
		. "\n ORDER BY t.ordering" );
		$oTabs = $database->loadObjectList();
// PK edit start
		$i_p = 0;
		$was_unset = 0;
		foreach($oTabs AS $pTab) {
			//$tabparams = mosParseParams($pTab->enhanced_params);

			$tabparams = new JParameter($pTab->enhanced_params);
			if (($tabparams->get('adminonly')) && ($this->ui == 1)) {
				unset($oTabs[$i_p]);
				$was_unset = 1;
			}
			//sv0.6232
			if ($pTab->aclgroups!='' && $this->ui == 1) {
				$acl_adming = array();
				$acl_adming[] = $acl->get_group_id('Administrator','ARO');
				$acl_adming[] = $acl->get_group_id('Super Administrator','ARO');
				$aclgroups = explode(",", $pTab->aclgroups);
				$do_unset=1;
				foreach ($aclgroups as $aclgroup) {
					if (in_array($aclgroup, $acl_adming)) {
						if (allowAccess($aclgroup, 'RECURSE', AuserGID($my->id), $acl)) {
							$do_unset=0;
						}
					} else {
						$do_unset=0;
					}
				}
				if ($do_unset!=0) {
					unset($oTabs[$i_p]);
					$was_unset = 1;
				}
			}
			// condition start
			if (($pTab->q_me!='' || $pTab->q_you!='') && ($this->ui==1 || ($ueConfig['adminshowalltabs']=='0' && $this->ui==2))) {
			// if (($pTab->q_me!='' || $pTab->q_you!='') && $this->ui == 1) {
				$do_unset = 0;
				$do_unset_me = 0;
				$do_unset_you = 0;
				if ($pTab->q_me!='') {
					$cond_type = substr($pTab->q_me,0,1);
					if ($cond_type=='a' || $cond_type=='s') {
						$cond_text = utf8RawUrlDecode(substr($pTab->q_me,1));
						//$cond_text = eregi_replace('username','u.username',$cond_text);
						//$cond_text = eregi_replace('usertype','u.usertype',$cond_text);
						$database->setQuery("SELECT c.user_id FROM #__cbe as c, #__users as u WHERE c.user_id='".$user->id."' AND c.user_id=u.id AND ".$cond_text);
						$cond_ret = $database->loadResult();
						if (!$database->query() || $cond_ret==NULL || $cond_ret =='') {
							$do_unset_me = 1;
						} else {
							if ($cond_ret != $user->id) {
								$do_unset_me = 1;
							}
						}
					} else if ($cond_type=='i') {
						$cond_check = false;
						$cond_text = utf8RawUrlDecode(substr($pTab->q_me,2,-1));
						$cond_check = strpos(strtolower($cond_text),'select');
						$cond_check1 = strpos(strtolower($cond_text),';');
						if ($cond_check!==false && $cond_check == 0 && $cond_check1 === false) {
							$cond_text = str_replace('$user->id',$user->id,$cond_text);
							$cond_text = str_replace('$my->id',$my->id,$cond_text);
							$database->setQuery($cond_text);
							$cond_ret = $database->loadResult();
							if (!$database->query() || $cond_ret==NULL || $cond_ret =='') {
								$do_unset_me = 1;
							} else {
								if ($cond_ret != $user->id) {
									$do_unset_me = 1;
								}
							}
						} else {
							$do_unset_me = 1;
						}
					}
				}
				if ($do_unset_me == 0) {
					$do_unset = 0;
				} else {
					$do_unset = 1;
				} 
				if ($do_unset!=0) {
					$was_unset = 1;
					unset($oTabs[$i_p]);
				}
			}
			// condition end
			if ($was_unset == 0) {
				if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/'.@$tabparams->get('enhancedname').'/language/'.$mosConfig_lang.'.php')) {
					include_once(JPATH_SITE.'/components/com_cbe/enhanced/'.@$tabparams->get('enhancedname').'/language/'.$mosConfig_lang.'.php');
				} else if (file_exists(JPATH_SITE.'/components/com_cbe/enhanced/'.@$tabparams->get('enhancedname').'/language/english.php')) {
					include_once(JPATH_SITE.'/components/com_cbe/enhanced/'.@$tabparams->get('enhancedname').'/language/english.php');
				}
			} else {
				$was_unset = 0;
			}
			$i_p++;
		}
			
// PK edit end
		foreach($oTabs AS $oTab) {
			$oPContent="";
			$oFContent="";
			$oContent="";
			if($oTab->plugin!=null) {
				$oPContent = $this->_callTabPlugin($oTab, $user, $oTab->plugin, $oTab->plugin_include);
			}
			if($oTab->fields) {
				if($oTab->plugin!=null) $oTab->description=null;
				$oFContent = $this->_getEditTabContents($oTab,$user);
			}
			if($oPContent!="") $oContent .= $oPContent;
			if($oFContent!="") $oContent .= $oFContent;
			if($oContent!="") {

				$results .= $this->startTab("CB",CBE_getLangDefinition($oTab->title),$oTab->tabid);
				//$results .= $pane->startPanel(CBE_getLangDefinition($oTab->title),$oTab->tabid);
				$results .= "\n\t\t\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"95%\"><tr><td>";
				$results .= $oContent;
				$results .= "\n\t</td></tr></table>";
				//$results .= $pane->endPanel();
				$results .= $this->endTab();
			}
		}
		//$pane = $this->pane;
		$return = $this->startPane("CB");
		$return .= $results;
		$return .= $this->endPane();

		return $return;
	}
function _getEditTabContents($tab,$user) {
		global $ueConfig;
		// funktionen einbinden
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'cbeFunctions.php');
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_cbe'.DS.'classes'.DS.'moscbeHTML.php');

		$acl =& JFactory::getACL();
		$database = &JFactory::getDBO();

		$results="";
		$return="";
		$database->setQuery( "SELECT f.* FROM #__cbe_fields f"
		. "\n WHERE f.published=1 AND f.tabid=".$tab->tabid." ORDER BY f.ordering");
		$rowFields = $database->loadObjectList();
		$rowFieldValues=array();
		$fieldJS=' ';
		if(count($rowFields)>0) {
			$results .= "\t<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n";
			if($tab->description != null) $results .= "\t\t<br /><div><b>".CBE_getLangDefinition($tab->description)."</b></div><br />\n";
			foreach($rowFields AS $rowField) {
				$k = "\$user->".$rowField->name;
				eval("\$k = \"$k\";");
				if($rowField->type=='editorta') {
					ob_start();
					//getEditorContents( 'editor'.$rowField->name, $rowField->name ) ;
					$editor =& JFactory::getEditor();
					echo $editor->save( 'editor'.$rowField->name, $rowField->name );
					$fieldJS .= ob_get_contents();
					ob_end_clean();
				}
				$database->setQuery( "SELECT fieldtitle, fieldid AS id FROM #__cbe_field_values"
				. "\n WHERE fieldid = ".$rowField->fieldid
				. "\n ORDER BY ordering" );
				$Values = $database->loadObjectList();
//				if($ueConfig['adminrequiredfields']==0 && $this->ui==2) $adminReq=0;
//				else $adminReq=$rowField->required;
// fix for readonly fields not changeable by admin
// PK start
				if($this->ui==2) {
					$rowField->readonly=0;
					if($ueConfig['adminrequiredfields']==0) {
						$adminReq=0;
					} else {
						$adminReq=$rowField->required;
					}
				} else {
					$adminReq=$rowField->required;
				}
// PK end

				$multi="";
				$multi_o = 0;
				if($rowField->type=='multiselect') {
					$multi="MULTIPLE";
					$multi_o = 1;
				}
				if(count($Values) > 0) {
					if($rowField->type=='radio') $rowFieldValues['lst_'.$rowField->name] = moscbeHTML::radioList( $Values, $rowField->name, 'class="inputbox" size="1" mosReq="'.$adminReq.'" mosLabel="'.CBE_getLangDefinition($rowField->title).'"', 'fieldtitle', 'fieldtitle', $k, $adminReq, $rowField->readonly);
					else {
						$ks=explode("|*|",$k);
						$k = array();
						foreach($ks as $kv) {
							$k[]->fieldtitle=$kv;
						}
						if($rowField->type=='multicheckbox') $rowFieldValues['lst_'.$rowField->name] = moscbeHTML::checkboxList( $Values, $rowField->name."[]", 'class="inputbox" size="'.$rowField->size.'" '.$multi.' mosLabel="'.CBE_getLangDefinition($rowField->title).'"', 'fieldtitle', 'fieldtitle', $k, $adminReq, $rowField->readonly);
						else $rowFieldValues['lst_'.$rowField->name] = moscbeHTML::selectList( $Values, $rowField->name."[]", 'class="inputbox" size="'.$rowField->size.'" '.$multi.' mosReq="'.$adminReq.'" mosLabel="'.CBE_getLangDefinition($rowField->title).'"', 'fieldtitle', 'fieldtitle', $k, $adminReq, $rowField->readonly, $multi_o);
					}
				}
				$fieldValueList="";
				$fieldIDValue="";
				$results .= "\t\t<tr>";
				$colspan=2;
				if($rowField->type=='spacer') {
					if ($rowField->title == '-null-') {
						$results .= "\t\t\t<td colspan=\"".$colspan."\" class=\"CBEspacerCell\">&nbsp;</td>\n";
					} else {
						$results .= "\t\t\t<td colspan=\"".$colspan."\" class=\"CBEspacerCell\">". CBE_getLangDefinition($rowField->title) ."</td>\n";
					}
					if ($rowField->information) {
						if ($rowField->information=='-null-') {
							$results .= "\t\t</tr>\n\t\t<tr>\n\t\t\t<td colspan=\"".$colspan."\" class=\"CBEfieldInfoCell\">&nbsp;</td>\n";
						} else {
							$results .= "\t\t</tr>\n\t\t<tr>\n\t\t\t<td colspan=\"".$colspan."\" class=\"CBEfieldInfoCell\">". CBE_getLangDefinition($rowField->information) ."</td>\n";
						}
					}
				} else {
					if(CBE_getLangDefinition($rowField->title)!="") {
						if ($rowField->information && ($rowField->infotag == 'tag' || $rowField->infotag == 'both')) {
							$CBEtip = getCBEtip($rowField->title, $rowField->information);
							$results .= "\t\t\t<td class=\"titleCell\"><div style=\"border-bottom:2px dotted #FB0303;\" ".$CBEtip.">". CBE_getLangDefinition($rowField->title) .":</div></td>";
						} else {
							$results .= "\t\t\t<td class=\"titleCell\">". CBE_getLangDefinition($rowField->title) .":</td>";
						}
						$colspan=1;
					}
					if(ISSET($rowFieldValues['lst_'.$rowField->name])) $fieldValueList=$rowFieldValues['lst_'.$rowField->name];
					if(ISSET($rowField->id)) $fieldIDValue=$rowField->id;
					$results .= "\t\t\t<td colspan=\"".$colspan."\">".getFieldEntry($rowField->type,$rowField->name,$rowField->information,$rowField->infotag,$k,$adminReq,$rowField->title,$fieldIDValue,$rowField->size, $rowField->maxlength, $rowField->cols, $rowField->rows,$rowField->profile,$fieldValueList,$rowField->value,$rowField->default,$rowField->readonly)."</td>\n";
				}
				$results .= "\t\t</tr>";
			}
			$results.="</table>";
			$this->fieldJS .=$fieldJS;
			//$return="<script> ".$fieldJS." </script>\n\n";
			$return.=$results;
		}
		return $return;
	}
}
?>
<?php
/**
* @version $Id: admin.artforms.php v.2.1b7 2007-11-26 04:52:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @copyright Copyright (C) 2005 Andreas Duswald
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

// Make sure the user is authorized to view this page
$user = & JFactory::getUser();
$acl = & JFactory::getACL();
$acl->addACL( 'com_artforms', 'manage', 'users', 'super administrator' );
$acl->addACL( 'com_artforms', 'manage', 'users', 'administrator' );
$acl->addACL( 'com_artforms', 'manage', 'users', 'manager' );
if (!$user->authorize( 'com_artforms', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

require_once( JApplicationHelper::getPath( 'admin_html' ) );
require_once( JApplicationHelper::getPath( 'class' ) );

$lang =& JFactory::getLanguage();
$component = 'com_artforms';
$lang->load($component, JPATH_ADMINISTRATOR);

afLoadLib( 'loadassets' );
afLoadLib( 'adm' );
showErrRep();
afLoadBECSS();
afLoadMTCSS();

$id = JArrayHelper::getValue( $_REQUEST, 'id' );
$cid = JArrayHelper::getValue( $_REQUEST, 'cid', 0 );
$task = JArrayHelper::getValue( $_REQUEST, 'task', 'menu' );


switch ( $task ) {
   case 'showaf':
      showArtForms( $option );
      break;
   case 'rforms':
      showRForms( $option );
      break;
   case 'vrforms':
      showViewRForms( $option );
      break;
   case 'help':
      HTML_artforms::showHelp( $option );
      break;
   case 'language':
      HTML_artforms::showLanguage();
      break;
   case 'cssedit':
      HTML_artforms::showCSS();
      break;
   case 'config':
      HTML_artforms::showConfig();
      break;
   case 'update':
      HTML_artforms::showUpdate();
      break;
   case 'info':
      HTML_artforms::showArtFormsInfo();
      break;
   case 'publish':
      publishArtForms( $cid, 1, $option );
      break;
   case 'unpublish':
      publishArtForms( $cid, 0, $option );
      break;
   case 'add':
      editArtForms( 0, $option );
      break;
   case 'edit':
      editArtForms( $cid[0], $option );
      break;
   case 'editA':
      editArtForms( $id, $option );
      break;
   case 'copy':
      copyArtForms( $cid, $option );
      break;
   case 'remove':
      removeArtForms( $cid, $option );
      break;
   case 'removerf':
      removeRForms( $cid, $option );
      break;
   case 'apply':
      saveArtForms( $db, $option, 1 );
      break;
   case 'save':
      saveArtForms( $db, $option );
      break;
   case 'savelanguage':
      saveLanguage( $option );
      break;
   case 'saveconfig':
      saveConfig( $option );
      break;
   case 'savecssedit':
      saveCSS( $option );
      break;
   case 'applylanguage':
      saveLanguage( $option, 1 );
      break;
   case 'applyconfig':
      saveConfig( $option, 1 );
      break;
   case 'applycssedit':
      saveCSS( $option, 1 );
      break;
   case 'uploadcfg':
      afUploadAsterisks();
      break;
   case 'afresethits':
      afResetHits( $id, $option );
      break;
   case 'menulink':
      afSaveMenu();
      break;
   case 'go2menu':
      afGo2Menu();
      break;
   case 'go2menuitem':
      afGo2MenuItem();
      break;
   case 'saveorder':
      afSaveOrder( $cid );
      break;
   case 'orderup':
      afOrder( intval( $cid[0] ), -1, $option );
      break;
   case 'orderdown':
      afOrder( intval( $cid[0] ), 1, $option );
      break;
   case 'accesspublic':
      afAccessMenu( intval( $cid[0] ), 0, $option );
      break;
   case 'accessregistered':
      afAccessMenu( intval( $cid[0] ), 1, $option );
      break;
   case 'accessspecial':
      afAccessMenu( intval( $cid[0] ), 2, $option );
      break;
   case 'cancel':
      cancelArtForms( $option );
      break;
   case 'delrow':
      afDelRow( $id, $option );
      break;
   case "exprformscsv":
      afExportRFormsCSV( $option, $cid );
      break;
   case "exprformsxls":
      afExportRFormsXLS( $option, $cid );
      break;
   case 'menu':
      HTML_artforms::showArtformsPanel();
      break;
   case 'cancellanguage':
   case 'cancelconfig':
   case 'cancelupdate':
   case 'cancelhelp':
   case 'cancelinfo':
   case 'cancelcssedit':
   case 'cancelrforms':
   default:
      $subtask = JArrayHelper::getValue( $_REQUEST, 'subtask', '' );
      switch ( $subtask ) {
         case 'showaf':
            showArtForms( $option );
            break;
         case 'rforms':
            showRForms( $option );
            break;
         default:
            $mainframe->redirect( 'index.php?option=com_artforms&task=menu' );
            break;
      }
      break;
}


function showArtForms( $option ) {

   global $mainframe, $mosConfig_list_limit;

   $db =& JFactory::getDBO();

   $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
   $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
   $search     = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
   $search     = $db->getEscaped( trim( strtolower( $search ) ) );

   if (get_magic_quotes_gpc()) {
      $search = stripslashes( $search );
   }
	
   if ($search) {
      $where = " WHERE a.titel LIKE '%$search%' OR a.text LIKE '%$search%'";
   } else {
      $where = "";
   }
   
   $db->setQuery( "SELECT count(*) FROM #__artforms AS a $where" );
   $total = $db->loadResult();

   jimport('joomla.html.pagination');
   $pageNav = new JPagination( $total, $limitstart, $limit );

   $query = "SELECT a.*, u.name AS editor, g.name AS groupname"
	  . "\nFROM #__artforms AS a"
	  . "\nLEFT JOIN #__users AS u ON u.id=a.checked_out"
	  . "\nLEFT JOIN #__groups AS g ON g.id = a.access"
	  . "\n$where ORDER BY ordering ASC";
   $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
   $rows = $db->loadObjectList();

   HTML_artforms::showArtForms( $rows, $search, $pageNav, $option );

}


function saveArtForms( &$db, $option, $apply=0 ) {

        global $option, $task, $mainframe, $id, $mosConfig_offset;

        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        $nullDate = $db->getNullDate();
        $row = new mosartforms( $db );
        afLoadLib( 'legacy' );
        afLoadLib( 'attfiles' );
	$_POST['allowattfiles'] = afPostAtt2DB();
        
	$a_post_items = null;
	$itemcount = count( JArrayHelper::getValue( $_POST, 'item_id' ) );
	for($i = 0; $i<$itemcount; $i++){
	
		if($db->getErrorNum()) {
		   return $db->getErrorMsg();
		}

                $gitem_id        = $_POST['item_id'][$i];
		$gform_id        = $_POST['id'];
		$gname           = trim( $_POST['name'][$i] );
		$gtype           = $_POST['type'][$i];
		$grequired       = $_POST['required'][$i];
		$gvalidation     = $_POST['validation'][$i];
		$gvalues         = trim( $_POST['values'][$i] );
		$gdefault_values = trim( $_POST['default_values'][$i] );
		$greadonly       = $_POST['readonly'][$i];
		$gcustomcode     = trim( $_POST['customcode'][$i] );
		$glayout         = trim( $_POST['layout'][$i] );
		$gitem_ordering  = $_POST['item_ordering'][$i];
					 
		$a_post_items[] = array( 'item_id'        => $gitem_id,
					 'form_id'        => $gform_id,
					 'name'           => $gname,
					 'type'           => $gtype,
					 'required'       => $grequired,
					 'validation'     => $gvalidation,
					 'values'         => $gvalues,
					 'default_values' => $gdefault_values,
					 'readonly'       => $greadonly,
					 'customcode'     => $gcustomcode,
					 'layout'         => $glayout,
					 'item_ordering'  => $gitem_ordering
                                       );
	}
	
        $row->titel = JFilterOutput::ampReplace( $row->titel );
	$row->text = str_replace( '<br>', '<br />', $row->text );
	$row->danktext 	= str_replace( '<br>', '<br />', $row->danktext );

	$row->created_by = $row->created_by ? $row->created_by : $user->id;

	if ($row->created && strlen(trim( $row->created )) <= 10) {
		$row->created .= ' 00:00:00';
	}
        $row->created = $row->created ? JHTML::_('date', $row->created, JText::_('DATE_FORMAT_LC1' ), -$mosConfig_offset ) : date( 'Y-m-d H:i:s' );

	if (strlen(trim( $row->publish_up )) <= 10) {
		$row->publish_up .= ' 00:00:00';
 	}
        $row->publish_up = JHTML::_('date', $row->publish_up, JText::_('DATE_FORMAT_LC1' ), -$mosConfig_offset );

	if (trim( $row->publish_down ) == 'Never' || trim( $row->publish_down ) == '') {
		$row->publish_down = $nullDate;
	} else {
		if (strlen(trim( $row->publish_down )) <= 10) {
			$row->publish_down .= ' 00:00:00';
		}
                $row->publish_down = JHTML::_('date', $row->publish_down, JText::_('DATE_FORMAT_LC1' ), -$mosConfig_offset );
	}

        $query = "SELECT name"
		. "\n FROM #__users"
		. "\n WHERE id = " . (int) $row->created_by
		;
	$db->setQuery( $query );
	$row->author = $db->loadResult();

        $row->id = (int) $row->id;
        
        if (JArrayHelper::getValue( $_POST, 'id' )) {
		$row->modified = date( 'Y-m-d H:i:s' );
		$row->modified_by = $user->id;

                $query = "SELECT name"
		. "\n FROM #__users"
		. "\n WHERE id = " . (int) $row->modified_by
		;
	        $db->setQuery( $query );
         	$row->modifier = $db->loadResult();

	}
	
	$params = JArrayHelper::getValue( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ( $params as $k=>$v) {
			if (get_magic_quotes_gpc()) {
				$v = stripslashes( $v );
			}
			$txt[] = "$k=$v";
		}
		$row->attribs = implode( "\n", $txt );
	}
	
	$obj_items = null;
	for($i = 0; $i<count($a_post_items); $i++){
		$obj_items[$i] = new mosartforms_item ( $db );
                afBindArrayToObject($a_post_items[$i], $obj_items[$i]);
	}       //mosBindArrayToObject     //JArrayHelper::toObject
	
        if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	// Bind Form Data
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	// Save Form Data
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

        $row->checkin();
        
	foreach($obj_items as $item){

		if(JArrayHelper::getValue( $_POST, 'id' ) == 0){
			$item->form_id = $row->id;
		}

		if($item->name == ''){
			if (!$item->delete()) {
				echo 'delete error';
				echo "<script> alert('".$item->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}
		} else {
			if (!$item->store()) {
				echo 'store error';
				echo "<script> alert('".$item->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}
        $cache =& JFactory::getCache( 'com_artforms' );
	$cache->clean( 'com_artforms' );

	$msg = JText::_( 'ARTF_FORM_FORMSAVED' ).'&afimg=1';
        $getid = JArrayHelper::getValue( $_POST, 'getid' );
        if( $apply == 1 ){

           if( $getid == '' || $getid == '0' ){
              $query = 'SELECT id FROM #__artforms ORDER BY id DESC';
              $db->setQuery( $query );
              $getrow = $db->loadRow();
              $idvalue = $getrow[0];
           } else {
              $idvalue = $getid;
           }
           
           $mainframe->redirect( 'index.php?option='.$option.'&task=editA&id='.$idvalue.'&afmsg='.$msg );
        } else {
           $mainframe->redirect( 'index.php?option='.$option.'&task=showaf&afmsg='.$msg  );
        }

}


function editArtForms( $cid, $option ) {

   global $option, $task, $mainframe;
   $db =& JFactory::getDBO();
   $user =& JFactory::getUser();

   $row = new mosartforms( $db );
   $row->load( $cid );
   $nullDate = $db->getNullDate();
   $formid = $row->id;
   /*
   if($row->isCheckedOut( $user->id )){
      $mainframe->redirect( 'index.php?option=com_artforms&task=showaf', $row->titel.' is currently being edited by another administrator.' );
   }*/

   $query = "SELECT *"
	   ."\n FROM #__artforms_items"
	   ."\n WHERE form_id = $formid"
	   ."\n ORDER BY item_ordering ASC"
	   ;
   $db->setQuery( $query );
   $items = $db->loadObjectList();
   
   $lists = array();
   $itlists = array();
   
   $formopt[] = JHTML::_('select.option', '0', JText::_( 'ARTF_FORM_TEXTMAIL' ) );
   $formopt[] = JHTML::_('select.option', '1', JText::_( 'ARTF_FORM_HTMLMAIL' ) );
   $lists['formopt'] = JHTML::_('select.genericlist', $formopt, 'html', 'class="text_area" size="1"', 'value', 'text', $row->html );

   $afeditorallow[] = JHTML::_('select.option', 'tinymce_light', 'TinyMCE Light' );
   $afeditorallow[] = JHTML::_('select.option', 'tinymce_simple', 'TinyMCE Simple' );
   $afeditorallow[] = JHTML::_('select.option', 'tinymce_full', 'TinyMCE Full' );
   $afeditorallow[] = JHTML::_('select.option', 'fckeditor_def', 'FCK Editor - Default' );
   $afeditorallow[] = JHTML::_('select.option', 'fckeditor_o2003', 'FCK Editor - Office 2003' );
   $afeditorallow[] = JHTML::_('select.option', 'fckeditor_silver', 'FCK Editor - Silver' );
   //$afeditorallow[] = JHTML::_('select.option', 'htmlarea3_xtd', 'HtmlArea3 Xtd' );
   //$afeditorallow[] = JHTML::_('select.option', 'jce', 'JCE' );
   //$afeditorallow[] = JHTML::_('select.option', 'jeditor', 'JEditor' );
   //$afeditorallow[] = JHTML::_('select.option', 'tmedit', 'TMEdit' );
   //$afeditorallow[] = JHTML::_('select.option', 'wysiwygpro', 'WYSIWYG Pro' );
   //$afeditorallow[] = JHTML::_('select.option', 'xinha', 'Xinha' );
   //$afeditorallow[] = JHTML::_('select.option', 'xstandard', 'X Standard' );
   $lists['afeditor'] = JHTML::_('select.genericlist', $afeditorallow, 'afeditor', 'class="text_area" size="1"', 'value', 'text', $row->afeditor );

   $seccodeallow[] = JHTML::_('select.option', '0', JText::_( 'ARTF_FORM_NONE' ) );
   $seccodeallow[] = JHTML::_('select.option', '1','Alikon Mod');
   $seccodeallow[] = JHTML::_('select.option', '2','Captcha Form');
   $seccodeallow[] = JHTML::_('select.option', '3','Captcha Talk');
   $seccodeallow[] = JHTML::_('select.option', '4','ReChaptcha');
   $seccodeallow[] = JHTML::_('select.option', '5','Alikon Mambot');
   $seccodeallow[] = JHTML::_('select.option', '6','Security Images Component');
   $seccodeallow[] = JHTML::_('select.option', '7','EasyCaptcha Component');
   $lists['seccodeallow'] = JHTML::_('select.genericlist', $seccodeallow, 'seccode', 'class="text_area" size="1"', 'value', 'text', $row->seccode );

   $emailfieldallow[] = JHTML::_('select.option', '0', JText::_( 'ARTF_MULTI_NO' ) );
   $emailfieldallow[] = JHTML::_('select.option', '1', JText::_( 'ARTF_MULTI_YES' ) );
   $lists['emailfieldallow'] = JHTML::_('select.genericlist', $emailfieldallow, 'emailfield', 'class="text_area" size="1"', 'value', 'text', $row->emailfield );

   $formattallow[] = JHTML::_('select.option', '0', JText::_( 'ARTF_FORM_WITHOUTATTF' ) );
   $formattallow[] = JHTML::_('select.option', '1', JText::_( 'ARTF_FORM_ATTFSIMPLE' ) );
   $formattallow[] = JHTML::_('select.option', '2', JText::_( 'ARTF_FORM_ATTFGMAIL' ) );
   $formattallow[] = JHTML::_('select.option', '3', JText::_( 'ARTF_FORM_ATTFSMMU' ) );
   $formattallow[] = JHTML::_('select.option', '4', JText::_( 'ARTF_FORM_ATTFSMMUMT' ) );
   $lists['formattallow'] = JHTML::_('select.genericlist', $formattallow, 'allowatt', 'class="text_area" size="1"', 'value', 'text', $row->allowatt);

   $itlists['newslettersel'][] = JHTML::_('select.option', '0', JText::_( 'ARTF_FORM_NONE' ) );
   $itlists['newslettersel'][] = JHTML::_('select.option', 'letterman', 'Letterman' );

   $itlists['a_types'][] = JHTML::_('select.option', '1',  JText::_( 'ARTF_FORM_INPUT' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '2',  JText::_( 'ARTF_FORM_TEXTAREA' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '3',  JText::_( 'ARTF_FORM_LIST' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '4',  JText::_( 'ARTF_FORM_CHECKBOX' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '5',  JText::_( 'ARTF_FORM_DROPDS' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '6',  JText::_( 'ARTF_FORM_DROPDM' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '7',  JText::_( 'ARTF_FORM_DATE' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '8',  JText::_( 'ARTF_FORM_HTMLTEXT' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '9',  JText::_( 'ARTF_FORM_TEXTAREAPLAIN' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '10', JText::_( 'ARTF_FORM_HIDDENINPUT' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '11', JText::_( 'ARTF_FORM_PASSWORD' ) );
   $itlists['a_types'][] = JHTML::_('select.option', '12', JText::_( 'ARTF_FORM_PASSWORD2' ) );

   $itlists['a_requ'][] = JHTML::_('select.option', '1', JText::_( 'ARTF_FORM_OPTIONAL' ) );
   $itlists['a_requ'][] = JHTML::_('select.option', '2', JText::_( 'ARTF_FORM_MANDATORY' ) );

   $itlists['a_valid'][] = JHTML::_('select.option', '0', JText::_( 'ARTF_FORM_NONE' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '1', JText::_( 'ARTF_FORM_EMAIL' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '2', JText::_( 'ARTF_FORM_NUMBER' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '3', JText::_( 'ARTF_FORM_TEXT' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '4', JText::_( 'ARTF_FORM_TEXTNUMBER' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '5', JText::_( 'ARTF_FORM_DECIMAL' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '6', JText::_( 'ARTF_FORM_DATE' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '7', JText::_( 'ARTF_FORM_ZIPCODE' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '8', JText::_( 'ARTF_FORM_IP' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '9', JText::_( 'ARTF_FORM_URL' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '10', JText::_( 'ARTF_FORM_CREDITCARD' ) );
   $itlists['a_valid'][] = JHTML::_('select.option', '11', JText::_( 'ARTF_FORM_CUSTOM' ).' 1' );
   $itlists['a_valid'][] = JHTML::_('select.option', '12', JText::_( 'ARTF_FORM_CUSTOM' ).' 2' );
   $itlists['a_valid'][] = JHTML::_('select.option', '13', JText::_( 'ARTF_FORM_CUSTOM' ).' 3' );
   $itlists['a_valid'][] = JHTML::_('select.option', '14', JText::_( 'ARTF_FORM_CUSTOM' ).' 4' );
   $itlists['a_valid'][] = JHTML::_('select.option', '15', JText::_( 'ARTF_FORM_CUSTOM' ).' 5' );

   $itlists['a_ronly'][] = JHTML::_('select.option', '0', JText::_( 'ARTF_MULTI_NO' ) );
   $itlists['a_ronly'][] = JHTML::_('select.option', '1', JText::_( 'ARTF_MULTI_YES' ) );

   $itlists['addFieldx'][] = JHTML::_('select.option', 'n', JText::_( 'ARTF_FORM_NONE' ) );
   for ($i=1; $i<31; $i++) {
      $itlists['addFieldx'][] = JHTML::_('select.option', $i, $i );
   }
   
   $row->created = JHTML::_('date', $row->created, JText::_('DATE_FORMAT_LC1' ) );
   $row->modified = $row->modified == $nullDate ? '' : JHTML::_('date', $row->modified, JText::_('DATE_FORMAT_LC1' ) );
   $row->publish_up = JHTML::_('date', $row->publish_up, JText::_('DATE_FORMAT_LC1' ) );

   if (trim( $row->publish_down ) == $nullDate || trim( $row->publish_down ) == '' || trim( $row->publish_down ) == '-' ) {
      $row->publish_down = 'Never';
   }
   $row->publish_down = JHTML::_('date', $row->publish_down, JText::_('DATE_FORMAT_LC1' ) );

   $query = "SELECT name"
   . "\n FROM #__users"
   . "\n WHERE id = " . (int) $row->created_by
   ;
   $db->setQuery( $query );
   $row->author = $db->loadResult();

   if ( $row->created_by == $row->modified_by ) {
      $row->modifier = $row->author;
   } else {
      $query = "SELECT name"
      . "\n FROM #__users"
      . "\n WHERE id = " . (int) $row->modified_by
      ;
      $db->setQuery( $query );
      $row->modifier = $db->loadResult();
   }
   
   @$active = intval( $row->created_by ) ? intval( $row->created_by ) : $user->id;
   $lists['created_by'] = JHTML::_('list.users', 'created_by', $active );
   $lists['access'] = JHTML::_('list.accesslevel', $row );

   $query = "SELECT ordering AS value, titel AS text"
	. "\n FROM #__artforms"
	. "\n ORDER BY ordering"
	;
   $lists['ordering'] = JHTML::_('list.specificordering', $row, $cid, $query, 1 );

   $params = new JParameter( $row->attribs, $mainframe->getPath( 'com_xml', 'com_artforms' ), 'component' );
   
   if($cid){
      $row->checkout( $user->id );
   }
   
   HTML_artforms::editArtForms( $row, $option, $formid, $items, $lists, $itlists, $params );

}


function showRForms( $option ) {

	global $mainframe, $mosConfig_list_limit;
        $db =& JFactory::getDBO();

        $limit      = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
        $search     = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search     = $db->getEscaped( trim( strtolower( $search ) ) );

        if (get_magic_quotes_gpc()) {
           $search = stripslashes( $search );
        }

        if ($search) {
           $where = " WHERE a.item_data LIKE '%$search%'";
        } else {
           $where = "";
        }

        $db->setQuery( "SELECT count(*) FROM #__artforms_inbox AS a $where" );
        $total = $db->loadResult();

        jimport('joomla.html.pagination');
        $pageNav = new JPagination( $total, $limitstart, $limit );

        $query = "SELECT *"
        . "\n FROM #__artforms_inbox"
        . "\n ORDER BY id DESC"
        ;
        $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
        $rows = $db->loadObjectList();

	HTML_artforms::showRForms( $rows, $search, $pageNav, $option );
	
}


function showViewRForms( $option ) {

        $db =& JFactory::getDBO();

        $id = JArrayHelper::getValue( $_GET, 'id' );

	$db->setQuery( "SELECT * FROM #__artforms_inbox WHERE id = $id ORDER BY id DESC" );
	$rows = $db->loadObjectList();

	HTML_artforms::showViewRForms( $rows, $option );
}


function saveLanguage( $option, $apply=0 ) {

           global $mainframe;

           $fname1 = JArrayHelper::getValue( $_POST, 'fname1' );
           $fcontent1 = $_POST['fcontent1'];
           $fcontent1 = stripslashes($fcontent1);
           $enable_write1 = JArrayHelper::getValue( $_POST, 'enable_write1', 0 );
	   $oldperms1 = fileperms($fname1);
	   if ( $enable_write1 ) {
		@chmod( $fname1, $oldperms1 | 0222);
	   }

           $fname2 = JArrayHelper::getValue( $_POST, 'fname2' );
           $fcontent2 = $_POST['fcontent2'];
           $fcontent2 = stripslashes($fcontent2);
           $enable_write2 = JArrayHelper::getValue( $_POST, 'enable_write2', 0 );
	   $oldperms2 = fileperms($fname2);
	   if ( $enable_write2 ) {
		@chmod( $fname2, $oldperms2 | 0222);
	   }

           clearstatcache();

	   if ( $fp1 = @fopen($fname1, 'w') ) {
		fputs($fp1, $fcontent1, strlen($fcontent1));
		fclose($fp1);
		if ($enable_write1) {
			@chmod($fname1, $oldperms1);
		} else {
                        if( JArrayHelper::getValue( $_POST, 'disable_write1', 0 )){
                           @chmod($fname1, $oldperms1 & 0777555);
                        }
		}

		$msg1 = JText::_( 'ARTF_MULTI_FSAVEDSUCCESS' );
                $ico1 = '1';

           } else {

		if ($enable_write1) {
			@chmod( $fname1, $oldperms1 );
		}

		$msg1 = JText::_( 'ARTF_MULTI_WRITENOTALLOWERROR' );
                $ico1 = '0';

           }

	   if ( $fp2 = @fopen($fname2, 'w') ) {
		fputs($fp2, $fcontent2, strlen($fcontent2));
		fclose($fp2);
		if ($enable_write2) {
			@chmod($fname2, $oldperms2);
		} else {
                        if( JArrayHelper::getValue( $_POST, 'disable_write2', 0 )){
                           @chmod($fname2, $oldperms2 & 0777555);
                        }
		}

		$msg2 = JText::_( 'ARTF_MULTI_FSAVEDSUCCESS' );
                $ico2 = '1';

           } else {

		if ($enable_write2) {
			@chmod( $fname2, $oldperms2 );
		}

		$msg2 = JText::_( 'ARTF_MULTI_WRITENOTALLOWERROR' );
                $ico2 = '0';

           }
	   if( $ico1 == '0' || $ico2 = '0' ){
	      $ico = '&afimg=0';
	   } else {
	      $ico = '&afimg=1';
	   }

	   $msg = ARTF_LANG_FRONTENDLANG.': '.$msg1.'<br />'.ARTF_LANG_BACKENDLANG.': '.$msg2;

           if( $apply == 1 ){
              $mainframe->redirect( 'index.php?option='.$option.'&task=language&afmsg='.$msg.$ico  );
           } else {
              $mainframe->redirect( 'index.php?option='.$option.'&task=menu&afmsg='.$msg.$ico );
           }
}


function saveCSS( $option, $apply=0 ) {

           global $mainframe;

           $fname = JArrayHelper::getValue( $_POST, 'fname' );
           $fcontent = $_POST['fcontent'];
           $fcontent = stripslashes($fcontent);

	   $enable_write = intval( JArrayHelper::getValue( $_POST, 'enable_write', 0 ) );
	   $oldperms = fileperms($fname);
	   if ( $enable_write ) {
		@chmod( $fname, $oldperms | 0222);
	   }

	   if ( $fp = fopen($fname, 'w') ) {
		fputs($fp, $fcontent, strlen($fcontent));
		fclose($fp);
		if ($enable_write) {
			@chmod($fname, $oldperms);
		} else {
			if ( JArrayHelper::getValue( $_POST, 'disable_write', 0 ) ){
                           @chmod($fname, $oldperms & 0777555);
                        }
		}

                $msg = JText::_( 'ARTF_MULTI_FSAVEDSUCCESS' ).'&afimg=1';
                if( $apply == 1 ){
                   $mainframe->redirect( 'index.php?option='.$option.'&task=cssedit&afmsg='.$msg  );
                } else {
                   $mainframe->redirect( 'index.php?option='.$option.'&task=menu&afmsg='.$msg );
                }

           } else {
		if ($enable_write) {
			@chmod( $fname, $oldperms );
		}
                $msg = JText::_( 'ARTF_MULTI_WRITENOTALLOWERROR' ).'&afimg=0';
                if( $apply == 1 ){
                   $mainframe->redirect( 'index.php?option='.$option.'&task=language&afmsg='.$msg );
                } else {
                   $mainframe->redirect( 'index.php?option='.$option.'&task=menu&afmsg='.$msg  );
                }
	   }

}


function saveConfig( $option, $apply=0 ) {

   $afcfg_att_path        = JArrayHelper::getValue( $_POST, 'afcfg_att_path', '/images/artforms/attachedfiles/' );
   $afcfg_bkup_path       = JArrayHelper::getValue( $_POST, 'afcfg_bkup_path', '/administrator/components/com_artforms/backups/' );
   $afcfg_attimagew       = JArrayHelper::getValue( $_POST, 'afcfg_attimagew', null );
   $afcfg_attimageh       = JArrayHelper::getValue( $_POST, 'afcfg_attimageh', null );
   $afcfg_attfilesave     = JArrayHelper::getValue( $_POST, 'afcfg_attfilesave', null );
   $afcfg_loadfrontcss    = JArrayHelper::getValue( $_POST, 'afcfg_loadfrontcss', null );
   $afcfg_showfrontfooter = JArrayHelper::getValue( $_POST, 'afcfg_showfrontfooter', null );
   $afcfg_allowajax       = JArrayHelper::getValue( $_POST, 'afcfg_allowajax', null );
   $afcfg_dbsaveforms     = JArrayHelper::getValue( $_POST, 'afcfg_dbsaveforms', null );
   $afcfg_allowerr_rep    = JArrayHelper::getValue( $_POST, 'afcfg_allowerr_rep', null );
   $afcfg_beitemsinterfase = JArrayHelper::getValue( $_POST, 'afcfg_beitemsinterfase', 'ajax' );
   $afcfg_showferforms = JArrayHelper::getValue( $_POST, 'afcfg_showferforms', null );
   $afcfg_showattinvferforms = JArrayHelper::getValue( $_POST, 'afcfg_showattinvferforms', null );
   $afcfg_usebehelper     = JArrayHelper::getValue( $_POST, 'afcfg_usebehelper', '0' );
   $afcfg_fieldsdefaultlayout = JArrayHelper::getValue( $_POST, 'afcfg_fieldsdefaultlayout', null, JREQUEST_ALLOWRAW );
   $afcfg_asteriskimg     = JArrayHelper::getValue( $_POST, 'afcfg_asteriskimg', null );
   $afcfg_valide_zipcode  = JArrayHelper::getValue( $_POST, 'afcfg_valide_zipcode', null );
   $afcfg_valide_custom1  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom1', null );
   $afcfg_valide_custom2  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom2', null );
   $afcfg_valide_custom3  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom3', null );
   $afcfg_valide_custom4  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom4', null );
   $afcfg_valide_custom5  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom5', null );
   $afcfg_valide_custom1_legend  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom1_legend', null );
   $afcfg_valide_custom2_legend  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom2_legend', null );
   $afcfg_valide_custom3_legend  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom3_legend', null );
   $afcfg_valide_custom4_legend  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom4_legend', null );
   $afcfg_valide_custom5_legend  = JArrayHelper::getValue( $_POST, 'afcfg_valide_custom5_legend', null );
   $afcfg_captcha_mode    = JArrayHelper::getValue( $_POST, 'afcfg_captcha_mode', null );
   $afcfg_captcha_length  = JArrayHelper::getValue( $_POST, 'afcfg_captcha_length', null );
   $afcfg_captcha_recapt_theme = JArrayHelper::getValue( $_POST, 'afcfg_captcha_recapt_theme', null );
   $afcfg_captcha_recapt_tabindex = JArrayHelper::getValue( $_POST, 'afcfg_captcha_recapt_tabindex', null );
   $afcfg_captcha_recapt_publickey = JArrayHelper::getValue( $_POST, 'afcfg_captcha_recapt_publickey', null );
   $afcfg_captcha_recapt_privatekey = JArrayHelper::getValue( $_POST, 'afcfg_captcha_recapt_privatekey', null );

   global $mainframe;
   $db =& JFactory::getDBO();

   $afcfg_fieldsdefaultlayout = str_replace('\"','"',$afcfg_fieldsdefaultlayout);
   $afcfg_fieldsdefaultlayout = urlencode( $afcfg_fieldsdefaultlayout );

   $params[]= 'rootfronttitle='.JArrayHelper::getValue( $_POST, 'rootfronttitle', null );
   $params[]= 'fronttext='.urlencode( JArrayHelper::getValue( $_POST, 'fronttext', null, JREQUEST_ALLOWRAW ) );
   $compid  = JArrayHelper::getValue( $_POST, 'compid', null );
   $params  = implode( "\n", $params );

   JLoader::register('JTableComponent', JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'component.php');
   $row = new JTableComponent( $db );
   $row->load( $compid );
   $row->params = $params;

   if (!$row->check()) {
   echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
   exit();
   }
   if (!$row->store()) {
   echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
   exit();
   }

   $fname = AFPATH_ADM_SITE.'config.artforms.php';
   $enable_write = intval( $_POST['enable_write'], 0 );
   $oldperms = fileperms($fname);
   if ( $enable_write ) {
      @chmod( $fname, $oldperms | 0222);
   }

   $config = "<?php\n";
   $config .= "\$afcfg_att_path                  = '$afcfg_att_path';\n";
   $config .= "\$afcfg_bkup_path                 = '$afcfg_bkup_path';\n";
   $config .= "\$afcfg_attimagew                 = '$afcfg_attimagew';\n";
   $config .= "\$afcfg_attimageh                 = '$afcfg_attimageh';\n";
   $config .= "\$afcfg_attfilesave               = '$afcfg_attfilesave';\n";
   $config .= "\$afcfg_loadfrontcss              = '$afcfg_loadfrontcss';\n";
   $config .= "\$afcfg_showfrontfooter           = '$afcfg_showfrontfooter';\n";
   $config .= "\$afcfg_allowajax                 = '$afcfg_allowajax';\n";
   $config .= "\$afcfg_dbsaveforms               = '$afcfg_dbsaveforms';\n";
   $config .= "\$afcfg_allowerr_rep              = '$afcfg_allowerr_rep';\n";
   $config .= "\$afcfg_beitemsinterfase          = '$afcfg_beitemsinterfase';\n";
   $config .= "\$afcfg_usebehelper               = '$afcfg_usebehelper';\n";
   $config .= "\$afcfg_fieldsdefaultlayout       = '$afcfg_fieldsdefaultlayout';\n";
   $config .= "\$afcfg_asteriskimg               = '$afcfg_asteriskimg';\n";
   $config .= "\$afcfg_showferforms              = '$afcfg_showferforms';\n";
   $config .= "\$afcfg_showattinvferforms        = '$afcfg_showattinvferforms';\n";
   $config .= "\$afcfg_valide_zipcode            = '$afcfg_valide_zipcode';\n";
   $config .= "\$afcfg_valide_custom1            = '$afcfg_valide_custom1';\n";
   $config .= "\$afcfg_valide_custom1_legend     = '$afcfg_valide_custom1_legend';\n";
   $config .= "\$afcfg_valide_custom2            = '$afcfg_valide_custom2';\n";
   $config .= "\$afcfg_valide_custom2_legend     = '$afcfg_valide_custom2_legend';\n";
   $config .= "\$afcfg_valide_custom3            = '$afcfg_valide_custom3';\n";
   $config .= "\$afcfg_valide_custom3_legend     = '$afcfg_valide_custom3_legend';\n";
   $config .= "\$afcfg_valide_custom4            = '$afcfg_valide_custom4';\n";
   $config .= "\$afcfg_valide_custom4_legend     = '$afcfg_valide_custom4_legend';\n";
   $config .= "\$afcfg_valide_custom5            = '$afcfg_valide_custom5';\n";
   $config .= "\$afcfg_valide_custom5_legend     = '$afcfg_valide_custom5_legend';\n";
   $config .= "\$afcfg_captcha_mode              = '$afcfg_captcha_mode';\n";
   $config .= "\$afcfg_captcha_length            = '$afcfg_captcha_length';\n";
   $config .= "\$afcfg_captcha_recapt_theme      = '$afcfg_captcha_recapt_theme';\n";
   $config .= "\$afcfg_captcha_recapt_tabindex   = '$afcfg_captcha_recapt_tabindex';\n";
   $config .= "\$afcfg_captcha_recapt_publickey  = '$afcfg_captcha_recapt_publickey';\n";
   $config .= "\$afcfg_captcha_recapt_privatekey = '$afcfg_captcha_recapt_privatekey';\n";
   $config .= "?".">";

   if ( $fp = fopen($fname, 'w') ) {
      fputs($fp, $config, strlen($config));
      fclose($fp);
      if ($enable_write) {

         @chmod($fname, $oldperms);

      } else {

         if (JArrayHelper::getValue($_POST,'disable_write', 0 )){
            @chmod($fname, $oldperms & 0777555);
         }

      }
      $msg = JText::_( 'ARTF_CFG_CONFIGSAVED' ).'&afimg=1';
      if( $apply == 1 ){
         $mainframe->redirect( 'index.php?option='.$option.'&task=config&afmsg='.$msg );
      } else {
         $mainframe->redirect( 'index.php?option='.$option.'&task=menu&afmsg='.$msg );
      }

   } else {

      if ($enable_write) {
	 @chmod( $fname, $oldperms );
      }
      $msg = JText::_( 'ARTF_CFG_FILEERROR' ).'&afimg=0';
      if( $apply == 1 ){
         $mainframe->redirect( 'index.php?option='.$option.'&task=language&afmsg='.$msg );
      } else {
         $mainframe->redirect( 'index.php?option='.$option.'&task=menu&afmsg='.$msg );
      }

   }

}


?>

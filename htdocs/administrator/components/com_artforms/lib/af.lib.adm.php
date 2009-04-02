<?php
/**
* @version $Id: af.lib.adm.php v.2.1b7 2007-12-16 16:44:59Z GMT-3 $
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


function afSaveMenu() {

        global $mainframe;
        $db =& JFactory::getDBO();
	$row = new mosMenu( $db );

        $menuid	= intval( JArrayHelper::getValue( $_POST, 'menufid', 0 ) );
        $row->menutype = strval( JArrayHelper::getValue( $_POST, 'menuselect', 'mainmenu' ) );
        $row->name = strval( JArrayHelper::getValue( $_POST, 'link_name', 'Form' ) );
        $row->link = 'index.php?option=com_artforms&formid='.$menuid;
	$row->type = JArrayHelper::getValue( $_POST, 'link_type', 'artforms_form_link' );
        $row->published = strval( JArrayHelper::getValue( $_POST, 'link_published', '1' ) );
        $row->access = strval( JArrayHelper::getValue( $_POST, 'maccess', 1 ) );

	if (!$row->check()) {
		echo '<script> alert("'.$row->getError().'"); window.history.go(-1); </script>';
		exit();
	}

	if (!$row->store()) {
		echo '<script> alert("'.$row->getError().'"); window.history.go(-1); </script>';
		exit();
	}

	$row->checkin();

	if (!$db->query()) {
		echo '<script> alert("'.$db->getErrorMsg().'"); window.history.go(-1); </script>';
		exit();
	}

 	$mainframe->redirect( 'index.php?option=com_artforms&task=editA&id='.$menuid );

}


function afResetHits( $formid, $option ){

        global $mainframe;
        $db =& JFactory::getDBO();

	$db->setQuery( 'UPDATE #__artforms SET hits = 0 WHERE id = '.$formid );

        if (!$db->query()) {
		echo '<script> alert(\''.$db->getErrorMsg().'\'); window.history.go(-1); </script>';
		exit();
	}

	$mainframe->redirect( 'index.php?option='.$option.'&task=editA&id='.$formid );

}


function afDelRow( $formid, $option ){

        global $mainframe;
        $db =& JFactory::getDBO();

        $itemdel = JArrayHelper::getValue( $_GET, 'itemdel' );

	$db->setQuery( 'DELETE FROM #__artforms_items WHERE item_id='.$itemdel.' AND form_id='.$formid );

        if (!$db->query()) {
		echo '<script> alert(\''.$db->getErrorMsg().'\'); window.history.go(-1); </script>';
		exit();
	}

        $msg = ARTF_FORM_ITEMDELETED.'&afimg=1';
	$mainframe->redirect( 'index.php?option='.$option.'&task=editA&id='.$formid.'&afmsg='.$msg );

}



function afUploadAsterisks() {

   global $mainframe;

   echo '
   <script type="text/javascript">
         function control() {
            var form = document.adminForm;
            if (form.astfile.value == ""){
               alert( "'.JText::_( 'ARTF_TOOL_UPLOADERROR1' ).'" );
            } else {
               return true;
            }
            return false;
         }
      </script>
      <style>
      .upload {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
	color: #3D5EA0;
	margin: 5px 0;
	text-align: left;
      }

      .upload2 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 10px;
	color: #800000;
	margin: 5px 0;
	text-align: left;
      }

      .inputbox {
        font-size: 11px;
      }
   </style>';

   if(JArrayHelper::getValue( $_GET, 'mosmsg' )) echo '<div align="center" style="font-weight:bold; color:red;"><br />'.JArrayHelper::getValue( $_GET, 'mosmsg' ).'<br /></div>';
   echo '
   <div class="upload">
      <form action="index2.php" method="post" id="adminForm" name="adminForm" enctype="multipart/form-data" onsubmit="return control();">
         <table width="100%" border="0" cellpadding="4" cellspacing="2" class="adminForm">
         <tr>
            <td class="upload2" align="left" valign="top">
               <div class="upload">
                  '.JText::_( 'ARTF_TOOL_UPLOADTITLE' ).'
               </div>
            </td>
         </tr>
         <tr>
            <td class="upload2" align="left" valign="top">
               <input type="hidden" name="option" value="com_artforms" />
               <input type="hidden" name="task" value="uploadcfg" />
               <input type="hidden" name="astcheck" value="1" />
               <input type="hidden" name="no_html" value="1" />
               <input type="hidden" name="no_affoo" value="1" />
               <input class="inputbox" type="file" name="astfile" style="height:18px;" /><br />
               <input class="upload2" type="submit" value="'.JText::_( 'ARTF_TOOL_UPLOADBUTTON' ).'" />
            </td>
         </tr>
         </table>
      </form>
   </div>';

   if( JArrayHelper::getValue( $_POST, 'astcheck' ) == '1' ){

      $uploadedfile = str_replace(' ', '-', $_FILES['astfile']['name']);

      if ($_FILES['astfile']['size'] < 512000 && $uploadedfile != ''){

         move_uploaded_file($_FILES['astfile']['tmp_name'], AFPATH_ASTERISKS_SITE.strtolower($uploadedfile));
         $mainframe->redirect( 'index.php?option=com_artforms&task=uploadcfg&no_html=1&no_affoo=1', JText::_( 'ARTF_TOOL_UPLOADSUCCESS' ) );

      } else {

         $mainframe->redirect( 'index.php?option=com_artforms&task=uploadcfg&no_html=1&no_affoo=1', JText::_( 'ARTF_TOOL_UPLOADERROR2' ) );

      }

   }

}


function afAccessMenu( $uid, $access, $option ) {

        global $mainframe;
        $db =& JFactory::getDBO();
	$row = new mosartforms( $db );
	$row->load( (int)$uid );
	$row->access = $access;

	if ( !$row->check() ) {
		return $row->getError();
	}
	if ( !$row->store() ) {
		return $row->getError();
	}

	$cache =& JFactory::getCache( 'com_artforms' );
	$cache->clean( 'com_artforms' );

        $msg = JText::_( 'ARTF_FORM_ACCESSSAVED' ).'&afimg=1';
        $mainframe->redirect( 'index.php?option='.$option.'&task=showaf&afmsg='.$msg );
}


function afGo2Menu() {

        global $mainframe;
        $menu = strval( JArrayHelper::getValue( $_POST, 'menu' ) );
        $mainframe->redirect( 'index.php?option=com_menus&menutype='.$menu );

}


function afGo2MenuItem() {

      global $mainframe;
      $menu = strval( JArrayHelper::getValue( $_POST, 'menu', 'mainmenu' ) );
      $menuid = intval( JArrayHelper::getValue( $_POST, 'menuid' ) );
      $mainframe->redirect( 'index.php?option=com_menus&menutype='.$menu.'&task=edit&hidemainmenu=1&id='.$menuid );

}


function afOrder( $uid, $inc, $option ) {

        global $mainframe;
        $db =& JFactory::getDBO();
	$row = new mosartforms( $db );
	$row->load( (int)$uid );
	$row->move( $inc, '' );

	$cache =& JFactory::getCache( 'com_artforms' );
	$cache->clean( 'com_artforms' );

        $mainframe->redirect( 'index.php?option='.$option.'&task=showaf' );
}


function afSaveOrder( &$cid ) {

        global $option, $mainframe;
        $db =& JFactory::getDBO();
	$total = count( $cid );
	$rettask = strval( JArrayHelper::getValue( $_POST, 'returntask', '' ) );
	$order = josGetArrayInts( 'order' );

	$row = new mosartforms( $db );
	$conditions = array();

	for( $i=0; $i < $total; $i++ ) {
		$row->load( (int) $cid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store()) {
				echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			}
			$condition = '';
			$found = false;
			foreach ( $conditions as $cond )
				if ($cond[1]==$condition) {
					$found = true;
					break;
				}
			if (!$found) $conditions[] = array($row->id, $condition);
		}
	}

	foreach ( $conditions as $cond ) {
		$row->load( $cond[0] );
		$row->updateOrder( $cond[1] );
	}

	$cache =& JFactory::getCache( 'com_artforms' );
	$cache->clean( 'com_artforms' );

	$msg = JText::_( 'ARTF_FORM_ORDERSAVED' ).'&afimg=1';
        $mainframe->redirect( 'index.php?option='.$option.'&task=showaf&afmsg='.$msg );

}


function copyArtForms( $cid, $option ){

        global $mainframe;
        $db =& JFactory::getDBO();
	$curr = new mosartforms( $db );
	$cidref = array();
        foreach( $cid as $id ) {
		$curr->load( $id );
		$curr->id = NULL;
		if ( !$curr->store() ) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$cidref[] = array($id, $curr->id);

                $query = 'SELECT * FROM #__artforms_items WHERE form_id = '.$id.' ORDER BY `item_id` ASC';
                $db->setQuery( $query );
                $itemcopy = $db->loadObjectList();

                foreach ( $itemcopy as $itemscopy ) {
                   $curr2 = new mosartforms_item( $db );
                   $curr2->item_id        =  NULL;
                   $curr2->form_id        =  $curr->id;
                   $curr2->name           =  $itemscopy->name;
                   $curr2->type           =  $itemscopy->type;
                   $curr2->required       =  $itemscopy->required;
                   $curr2->validation     =  $itemscopy->validation;
                   $curr2->values         =  $itemscopy->values;
                   $curr2->default_values =  $itemscopy->default_values;
                   $curr2->readonly       =  $itemscopy->readonly;
                   $curr2->customcode     =  $itemscopy->customcode;
                   $curr2->item_ordering  =  $itemscopy->item_ordering;
                   $curr2->layout         =  $itemscopy->layout;
                   $curr2->store();
                }
	}
	foreach ( $cidref as $ref ) {
		$curr->load( $ref[1] );
		$curr->titel = JText::_( 'ARTF_FORM_COPYFORMSNAME' ).' '.$curr->titel;
		$curr->ordering = '9999';
		if ( !$curr->store() ) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

	}

	$cache =& JFactory::getCache( 'com_artforms' );
	$cache->clean( 'com_artforms' );

   if (!$curr->store()) {
      $msg = count( $cid ).' '.JText::_( 'ARTF_FORM_COPYFORMSERROR' ).'&afimg=0';
      exit();
   } else {
      $msg = count( $cid ).' '.JText::_( 'ARTF_FORM_COPYFORMSSUCC' ).'&afimg=1';
   }
   $mainframe->redirect( 'index.php?option='.$option.'&task=showaf&afmsg='.$msg );

}


function removeArtForms( $cid, $option ) {

        global $mainframe;
        $db =& JFactory::getDBO();

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('".JText::_( 'ARTF_MULTI_ITEMSELALERT' )."'); window.history.go(-1);</script>\n";
		exit;
	}
	$cids = implode( ',', $cid );
	$db->setQuery( "DELETE FROM #__artforms WHERE id IN ($cids)" );
	if (!$db->query()) {
		echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	$db->setQuery( "DELETE FROM #__artforms_items WHERE form_id IN ($cids)" );
	if (!$db->query()) {
		echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	$mainframe->redirect( 'index.php?option='.$option.'&task=showaf' );
	
}


function cancelArtForms( $option ) {

        global $mainframe;
        $db =& JFactory::getDBO();
	$row = new mosartforms( $db );
	$row->bind( $_POST );
	$row->checkin();
	$mainframe->redirect( 'index.php?option='.$option.'&task=showaf' );

}


function publishArtForms( $cid, $publish, $option ) {

        global $mainframe;
        $db =& JFactory::getDBO();
	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('".JText::_( 'ARTF_TOOL_PUBLERROR' )." ".$action."'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$db->setQuery( "UPDATE #__artforms SET published=$publish WHERE id IN ($cids)");
	if (!$db->query()) {
		echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosartforms( $db, $option );
		$row->checkin( $cid[0] );
	}

	$mainframe->redirect( 'index.php?option='.$option.'&task=showaf' );

}


function removeRForms( $cid, $option ) {

        global $mainframe;
        $db =& JFactory::getDBO();

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('".JText::_( 'ARTF_MULTI_ITEMSELALERT' )."'); window.history.go(-1);</script>\n";
		exit;
	}
	$cids = implode( ',', $cid );
	$db->setQuery( "DELETE FROM #__artforms_inbox WHERE id IN ($cids)" );
	if (!$db->query()) {
		echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	$mainframe->redirect( "index.php?option=$option&task=rforms" );
}


function afShowInfoDocs( $title, $doc ) {

   ?>
   <div class="afinfotxtbox">
      <div class="afinfotxttitle">
         <?php echo $title;?>
      </div>
      <textarea name="<?php echo $doc;?>" cols="80" rows="25" class="text_area" readonly="true">
         <?php readfile( AFPATH_DOC_ADM_SITE.$doc.'.txt' );?>
      </textarea>
   </div>
<?php

}


function afShowFlagsInInfo( $lang ) {

   if(file_exists(JPATH_SITE.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php')){
      $html = '<img src="'.JURI::base().'components/com_joomfish/images/flags/'.$lang.'.gif" width="18" height="12" alt="" title="" /> ';
      return $html;
   } else {
      return;
   }
   
}


function afExportRFormsCSV( $option, $cids ) {

  $db =& JFactory::getDBO();
  $sep = ";";
  $csvfile = '';
  
  foreach ($cids as $cid) {
    // Compile list of headersfields
    $db->setQuery( "SELECT * FROM #__artforms_inbox WHERE id=$cid ORDER BY form_date ASC" );
    $rows = $db->loadObjectList();
    if ($db->getErrorNum()) {
      echo $db->stderr();
      return false;
    }
    foreach ($rows as $row) {

      $f_name = explode(";", $row->item_name);
      $f_data = explode(";", $row->item_data);

      if( $f_name[0] == 'ARTFJUSER' )$f_name[0]=JText::_( 'ARTF_MULTI_JUSER' );
      
      $csvfile .= ''.$sep.JText::_( 'ARTF_RFORMS_ID' ).$sep.JText::_( 'ARTF_RFORMS_FORMTITLE' ).$sep.JText::_( 'ARTF_RFORMS_FID' ).$sep.JText::_( 'ARTF_RFORMS_NAME' ).$sep.JText::_( 'ARTF_RFORMS_FIELD' ).$sep.JText::_( 'ARTF_RFORMS_DATE' ).$sep;
      $csvfile .= "\r\n";
      $csvfile .= ''.$sep.$row->id.$sep.$row->title.$sep.$row->form_id.$sep.$f_name[0].$sep.$f_data[0].$sep.$row->form_date.$sep;


      for($i=1; $i < (count( $f_name )-1); $i++){
        if( $f_name[$i] == 'ARTFJUSER' )$f_name[$i]=JText::_( 'ARTF_MULTI_JUSER' );
        if( $f_name[$i] == 'ARTFJUSERNAME' )$f_name[$i]=JText::_( 'ARTF_MULTI_JUSERNAME' );
        if( $f_name[$i] == 'ARTFJUSERIP' )$f_name[$i]=JText::_( 'ARTF_MULTI_JUSERIP' );
        if( $f_name[$i] == 'ARTFATTACHFILE' )$f_name[$i]=JText::_( 'ARTF_MULTI_ATTACHFILE' );
        $csvfile .= "\r\n";
        $csvfile .= ''.$sep.''.$sep.''.$sep.''.$sep.$f_name[$i].$sep.$f_data[$i].$sep;
      }
      
    }
    $csvfile .= "\r\n";
    
  }

  $contenttype = "application/octetstream";

  @ob_end_clean();
  @ini_set('zlib.output_compression', 'Off');

  header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header("Cache-Control: private");
  header("Content-Type: ".$contenttype);
  header("Content-Disposition: attachment; filename=\"artforms-rforms-".date( 'Y-m-d-H-i-s' ).".csv\"");
  header("Content-Length: ".strlen($csvfile));
  echo $csvfile;
  exit;
  
}


function afExportRFormsXLS( $option, $cids ) {

  $db =& JFactory::getDBO();
  $user =& JFactory::getUser();
  
  $query = "SELECT name"
	  ."\n FROM #__users"
          ."\n WHERE id = " . (int) $user->id
          ;
  $db->setQuery( $query );
  $author = $db->loadResult();
  $daytime = date( 'Y-m-d H:i:s' );
  $daytimeb = str_replace(" ","T",$daytime);

  $csvfile = '<?xml version="1.0"?'.'>
<?mso-application progid="Excel.Sheet"?'.'>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <LastAuthor>'.$author.'</LastAuthor>
  <Created>'.$daytimeb.'Z</Created>
  <Version>11.8132</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>9960</WindowHeight>
  <WindowWidth>16395</WindowWidth>
  <WindowTopX>240</WindowTopX>
  <WindowTopY>30</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s137">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s138">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s139">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s141">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font x:Family="Swiss" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#3366FF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s145">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s146">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s147">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s150">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:Color="#000080"/>
   <Interior ss:Color="#99CCFF" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="General Date"/>
  </Style>
  <Style ss:ID="s151">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
  </Style>
  <Style ss:ID="s152">
   <Font ss:FontName="Times New Roman" x:Family="Roman" ss:Size="14"
    ss:Color="#800000" ss:Bold="1"/>
  </Style>
 </Styles>
   ';

  $j=1;
  foreach ($cids as $cid) {
    // Compile list of headersfields
    $db->setQuery( "SELECT * FROM #__artforms_inbox WHERE id=$cid ORDER BY form_date ASC" );
    $rows = $db->loadObjectList();
    if ($db->getErrorNum()) {
      echo $db->stderr();
      return false;
    }
    foreach ($rows as $row) {

      $f_name = explode(";", $row->item_name);
      $f_data = explode(";", $row->item_data);
      
      if( $f_name[0] == 'ARTFJUSER' )$f_name[0]=JText::_( 'ARTF_MULTI_JUSER' );
      $csvfile .= '<Worksheet ss:Name="('.$j.') '.$row->title.'">
                  <Table ss:ExpandedColumnCount="7" ss:ExpandedRowCount="99" x:FullColumns="1"
                   x:FullRows="1" ss:DefaultColumnWidth="60">
                   <Column ss:AutoFitWidth="0" ss:Width="28.5"/>
                   <Column ss:AutoFitWidth="0" ss:Width="42"/>
                   <Column ss:AutoFitWidth="0" ss:Width="108.75"/>
                   <Column ss:AutoFitWidth="0" ss:Width="77.25"/>
                   <Column ss:AutoFitWidth="0" ss:Width="105.75"/>
                   <Column ss:AutoFitWidth="0" ss:Width="112.5"/>
                   <Column ss:AutoFitWidth="0" ss:Width="108"/>
                   <Row ss:Index="2" ss:Height="18.75">
                     <Cell ss:Index="2" ss:StyleID="s152"><Data ss:Type="String">ArtForms - '.JText::_( 'ARTF_MENU_RFORMS' ).' - '.$daytime.'</Data></Cell>
                   </Row>
                   <Row ss:Height="13.5"/>
                   <Row ss:Height="13.5">
                     <Cell ss:Index="2" ss:StyleID="s141"><Data ss:Type="String">'.JText::_( 'ARTF_RFORMS_ID' ).'</Data></Cell>
                     <Cell ss:StyleID="s141"><Data ss:Type="String">'.JText::_( 'ARTF_RFORMS_FORMTITLE' ).'</Data></Cell>
                     <Cell ss:StyleID="s141"><Data ss:Type="String">'.JText::_( 'ARTF_RFORMS_FID' ).'</Data></Cell>
                     <Cell ss:StyleID="s141"><Data ss:Type="String">'.JText::_( 'ARTF_RFORMS_NAME' ).'</Data></Cell>
                     <Cell ss:StyleID="s141"><Data ss:Type="String">'.JText::_( 'ARTF_RFORMS_FIELD' ).'</Data></Cell>
                     <Cell ss:StyleID="s141"><Data ss:Type="String">'.JText::_( 'ARTF_RFORMS_DATE' ).'</Data></Cell>
                   </Row>
                   <Row>
                     <Cell ss:Index="2" ss:StyleID="s145"><Data ss:Type="Number">'.$row->id.'</Data></Cell>
                     <Cell ss:StyleID="s145"><Data ss:Type="String">'.$row->title.'</Data></Cell>
                     <Cell ss:StyleID="s145"><Data ss:Type="Number">'.$row->form_id.'</Data></Cell>
                     <Cell ss:StyleID="s137"><Data ss:Type="String">'.$f_name[0].'</Data></Cell>
                     <Cell ss:StyleID="s137"><Data ss:Type="String">'.$f_data[0].'</Data></Cell>
                     <Cell ss:StyleID="s145"><Data ss:Type="String">'.$row->form_date.'</Data></Cell>
                   </Row>
                   ';


      for($i=1; $i < (count( $f_name )-1); $i++){
        if( $f_name[$i] == 'ARTFJUSER' )$f_name[$i]=JText::_( 'ARTF_MULTI_JUSER' );
        if( $f_name[$i] == 'ARTFJUSERNAME' )$f_name[$i]=JText::_( 'ARTF_MULTI_JUSERNAME' );
        if( $f_name[$i] == 'ARTFJUSERIP' )$f_name[$i]=JText::_( 'ARTF_MULTI_JUSERIP' );
        if( $f_name[$i] == 'ARTFATTACHFILE' )$f_name[$i]=JText::_( 'ARTF_MULTI_ATTACHFILE' );
        $csvfile .= '<Row>
                       <Cell ss:Index="2" ss:StyleID="s146"/>
                       <Cell ss:StyleID="s146"/>
                       <Cell ss:StyleID="s146"/>
                       <Cell ss:StyleID="s138"><Data ss:Type="String">'.$f_name[$i].'</Data></Cell>
                       <Cell ss:StyleID="s138"><Data ss:Type="String">'.$f_data[$i].'</Data></Cell>
                       <Cell ss:StyleID="s146"/>
                     </Row>
                     ';
      }

  $csvfile .='<Row>
      <Cell ss:Index="2" ss:StyleID="s151"/>
      <Cell ss:StyleID="s151"/>
      <Cell ss:StyleID="s151"/>
      <Cell ss:StyleID="s151"/>
      <Cell ss:StyleID="s151"/>
      <Cell ss:StyleID="s151"/>
    </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0"/>
    <Footer x:Margin="0"/>
    <PageMargins x:Bottom="0.984251969" x:Left="0.78740157499999996"
     x:Right="0.78740157499999996" x:Top="0.984251969"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <VerticalResolution>0</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>8</ActiveRow>
     <ActiveCol>10</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>';

    }
    $j++;
  }

$csvfile .='</Workbook>';

  $csvfile = utf8_encode( $csvfile );
  $contenttype = "application/x-msexcel";

  @ob_end_clean();
  @ini_set('zlib.output_compression', 'Off');

  header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header("Cache-Control: private");
  header("Content-Type: ".$contenttype);
  header("Content-Disposition: attachment; filename=\"artforms-rforms-".date( 'Y-m-d-H-i-s' ).".xls\"");
  header("Content-Length: ".strlen($csvfile));
  echo $csvfile;
  exit;

}


?>

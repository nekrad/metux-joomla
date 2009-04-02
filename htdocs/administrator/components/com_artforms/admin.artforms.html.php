<?php
/**
* @version $Id: admin.artforms.html.php v.2.1b7 2007-12-16 04:52:59Z GMT-3 $
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

require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_artforms'.DS.'lib'.DS.'af.lib.core.php');

class HTML_artforms {

   function showArtformsPanel() {

      global $mosConfig_live_site;
      ?>
      <div id="cpanel">
      <?php
         afPanelButton( 'showaf', 'forms48', JText::_( 'ARTF_MENU_FORMS' ) );
         afPanelButton( 'rforms', 'rforms48', JText::_( 'ARTF_MENU_RFORMS' ) );
         afPanelButton( 'help', 'help48', JText::_( 'ARTF_MENU_HELP' ) );
         afPanelButton( 'language', 'lang48', JText::_( 'ARTF_MENU_LANG' ) );
         afPanelButton( 'cssedit', 'css48', JText::_( 'ARTF_MENU_CSS' ) );
         afPanelButton( 'config', 'config48', JText::_( 'ARTF_MENU_CONFIG' ) );
         afPanelButton( 'update', 'update48', JText::_( 'ARTF_MENU_UPDATE' ) );
         afPanelButton( 'info', 'info48', JText::_( 'ARTF_MENU_INFO' ) );
      ?>
      </div>
      <?php
      echo afLoadTitleError();
      echo afFooter();

   }


   function showLanguage() {

          global $option, $mosConfig_absolute_path, $mosConfig_lang, $mosConfig_live_site;

          $lang =& JFactory::getLanguage();
          $langTag = $lang->getTag();

          if (file_exists(JPATH_SITE.DS.'language'.DS.$langTag.DS.$langTag.'.'.$option.'.ini')) {
             $fname1 = JPATH_SITE.DS.'language'.DS.$langTag.DS.$langTag.'.'.$option.'.ini';
          } else {
             $fname1 = JPATH_SITE.DS.'language'.DS.'en-GB'.DS.'en-GB.'.$option.'.ini';
          }

          if (file_exists(JPATH_ADMINISTRATOR.DS.'language'.DS.$langTag.DS.$langTag.'.'.$option.'.ini')) {
             $fname2 = JPATH_ADMINISTRATOR.DS.'language'.DS.$langTag.DS.$langTag.'.'.$option.'.ini';
          } else {
             $fname2 = JPATH_ADMINISTRATOR.DS.'language'.DS.'en-GB'.DS.'en-GB.'.$option.'.ini';
          }

          afLoadSectionTitle( JText::_( 'ARTF_MENU_LANG' ), 'lang48' );

          echo '<table cellpadding="1" cellspacing="1" border="0" width="100%"><tr><td width="70%">
                <form action="index.php" method="post" name="adminForm" class="adminform" id="adminForm">';
          jimport('joomla.html.pane');
          $pane	=& JPane::getInstance('sliders');

          echo $pane->startPane( 'artformslang' );
          echo $pane->startPanel( JText::_('ARTF_LANG_FRONTENDLANG'), 'frontendlang' );
          ?>
             <table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="270">
				<span class="componentheading"><?php echo $mosConfig_lang;?>.php:
				<?php echo is_writable( $fname1 ) ? '<b><font color="green"> '.JText::_( 'ARTF_MULTI_WRITABLE' ).'</font></b>' : '<b><font color="red"> '.JText::_( 'ARTF_MULTI_UNWRITABLE' ).'</font></b>' ?>
				</span>
			</td>
			<?php
			jimport('joomla.filesystem.path');
			if (JPath::canChmod($fname1)) {
				if (is_writable($fname1)) {
					?>
					<td>
						<input type="checkbox" id="disable_write1" name="disable_write1" value="1"/>
						<label for="disable_write1"><?php echo JText::_( 'ARTF_MULTI_ENAWRITEFILE' ); ?></label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write1" name="enable_write1" value="1"/>
						<label for="enable_write1"><?php echo JText::_( 'ARTF_MULTI_DISAWRITEFILE' ); ?></label>
					</td>
				<?php
				}
			}
			?>
                </tr>
             </table>

          <?php
	  $f1=fopen($fname1,"r");
	  $fcontent1 = fread($f1, filesize($fname1));
	  $fcontent1 = htmlspecialchars($fcontent1);
	  ?>
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
	     <tr>
	       <th>
               <?php echo JText::_( 'ARTF_MULTI_PATH' ); ?>: <?php echo $fname1; ?>
               </th>
             </tr>
	     <tr>
	       <td>
                     <input type="hidden" name="fname1" value="<?php echo $fname1; ?>" />
                     <textarea cols="90" rows="20" name="fcontent1"><?php echo $fcontent1; ?></textarea>
	       </td>
	     </tr>
             <tr>
	       <td colspan="2"><?php echo JText::_( 'ARTF_MULTI_FILENEEDPERM' ); ?></td>
	     </tr>
         </table>

         <?php
         echo $pane->endPanel();
         echo $pane->startPanel( JText::_('ARTF_LANG_BACKENDLANG'), 'frontendlang' );
         ?>

             <table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="270">
				<span class="componentheading"><?php echo $mosConfig_lang;?>.php:
				<?php echo is_writable( $fname2 ) ? '<b><font color="green"> '.JText::_( 'ARTF_MULTI_WRITABLE' ).'</font></b>' : '<b><font color="red"> '.JText::_( 'ARTF_MULTI_UNWRITABLE' ).'</font></b>' ?>
				</span>
			</td>
			<?php
			jimport('joomla.filesystem.path');
			if (JPath::canChmod($fname2)) {
				if (is_writable($fname2)) {
					?>
					<td>
						<input type="checkbox" id="disable_write2" name="disable_write2" value="1"/>
						<label for="disable_write2"><?php echo JText::_( 'ARTF_MULTI_ENAWRITEFILE' ); ?></label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write2" name="enable_write2" value="1"/>
						<label for="enable_write2"><?php echo JText::_( 'ARTF_MULTI_DISAWRITEFILE' ); ?></label>
					</td>
				<?php
				}
			}
			?>
                </tr>
             </table>

          <?php
	  $f2=fopen($fname2,"r");
	  $fcontent2 = fread($f2, filesize($fname2));
	  $fcontent2 = htmlspecialchars($fcontent2);
	  ?>
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
	     <tr>
	       <th>
               <?php echo JText::_( 'ARTF_MULTI_PATH' ); ?>: <?php echo $fname2; ?>
               </th>
             </tr>
	     <tr>
	       <td>
                     <input type="hidden" name="fname2" value="<?php echo $fname2; ?>" />
                     <textarea cols="90" rows="20" name="fcontent2"><?php echo $fcontent2; ?></textarea>
	       </td>
             </tr>
             <tr>
	       <td colspan="2"><?php echo JText::_( 'ARTF_MULTI_FILENEEDPERM' ); ?></td>
	     </tr>
         </table>

         <?php
         echo $pane->endPanel();
         echo $pane->endPane();
         ?>

         <input type="hidden" name="option" value="<?php echo $option; ?>">
	 <input type="hidden" name="task" value="language">
	 <input type="hidden" name="boxchecked" value="0">
	 </form>

	 <?php
         echo '</td><td>';
	 ?>

         <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
             <tr>
               <td>
		  <div align="center">
		     <p><img src="<?php echo AFPATH_WEB_IMG_ADM_SITE; ?>update48.png" /></p>
		     <form action="index.php" method="post" name="adminForm2" id="adminForm2" height="100%">
		        <input type="hidden" name="option" value="<?php echo $option; ?>">
	                <input type="hidden" name="task" value="language">
			<input type="hidden" name="dotask" value="linkconv">
			<input type="submit" value="<?php echo JText::_( 'ARTF_LANG_MENULANGFIX' ); ?>" style="width: 270; height: 24">
		     </form>
		     <?php
		     afLoadLib( 'upd' );
		     if( JArrayHelper::getValue( $_POST, 'dotask' ) == 'linkconv' ){
                        afUpdMLangEnt();
                     }
                     ?>
		  </div>
	       </td>
	     </tr>
	  </table>

         <?php
         echo '</td></tr></table>';

        echo afFooter();

   }
        

   function showCSS() {

        global $option;

          $fname = AFPATH_ASSETS_SITE.'css'.DS.'artforms.css';

          afLoadSectionTitle( JText::_( 'ARTF_MENU_CSS' ), 'css48' );
          ?>
          <form action="index.php" method="post" name="adminForm" class="adminform" id="adminForm">
	     <table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="270">
				<span class="componentheading">arforms.css:
				<?php echo is_writable( $fname ) ? '<b><font color="green"> '.JText::_( 'ARTF_MULTI_WRITABLE' ).'</font></b>' : '<b><font color="red"> '.JText::_( 'ARTF_MULTI_UNWRITABLE' ).'</font></b>' ?>
				</span>
			</td>
			<?php
                        jimport('joomla.filesystem.path');
			if (JPath::canChmod($fname)) {
				if (is_writable($fname)) {
					?>
					<td>
						<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
						<label for="disable_write"><?php echo JText::_( 'ARTF_MULTI_ENAWRITEFILE' ); ?></label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
						<label for="enable_write"><?php echo JText::_( 'ARTF_MULTI_DISAWRITEFILE' ); ?></label>
					</td>
				<?php
				}
			}
			?>
                </tr>
                </table>
          <?php

	  $f=fopen($fname,"r");
	  $fcontent = fread($f, filesize($fname));
	  $fcontent = htmlspecialchars($fcontent);
	  ?>
	  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform">
	     <tr>
	       <th colspan="2"><?php echo JText::_( 'ARTF_MULTI_PATH' ); ?>: <?php echo $fname; ?></td> </tr>
	     <tr>
	       <td>
                     <input type="hidden" name="fname" value="<?php echo $fname; ?>" />
                     <textarea cols="90" rows="20" name="fcontent"><?php echo $fcontent; ?></textarea>
		     <input type="hidden" name="option" value="<?php echo $option; ?>">
		     <input type="hidden" name="task" value="cssedit">
		     <input type="hidden" name="boxchecked" value="0">
		  </form>
	       </td>
	       <td>

		   </td>
		 </tr>
	     <tr>
	       <td colspan="2"><?php echo JText::_( 'ARTF_MULTI_FILENEEDPERM' ); ?></td>
	     </tr>
	  </table>
        <?php
          echo afFooter();
          
   }

        
   function showUpdate() {
        
      global $option;

      if ( JArrayHelper::getValue( $_GET, 'no_afhtml' ) != '1' ) afLoadSectionTitle( JText::_( 'ARTF_MENU_UPDATE' ), 'update48' );
      afLoadLib( 'upd' );
      
      require_once( AFPATH_SITE.'version.php' );

      $file	= JArrayHelper::getValue( $_POST, "file", null );
      $upfile	= JArrayHelper::getValue( $_FILES,"upfile",null );
      $tables = JArrayHelper::getValue( $_POST, "tables", null );
      $OutType = JArrayHelper::getValue( $_POST, "OutType", null );
      $OutDest = JArrayHelper::getValue( $_POST, "OutDest", null );
      $toBackUp = JArrayHelper::getValue( $_POST, "toBackUp", null );
      
      require( AFPATH_ADM_SITE.'config.artforms.php' );
      if( $afcfg_bkup_path != '' && is_dir(JPATH_SITE.$afcfg_bkup_path) ){
         $afbkup_path = JPATH_SITE.$afcfg_bkup_path;
      } else {
         $afbkup_path = AFPATH_ADM_SITE.'bkups'.DS;
      }
      $dotask = JArrayHelper::getValue( $_GET, 'dotask' );
      if ( JArrayHelper::getValue( $_GET, 'no_afhtml' ) != '1' ) {
      ?>
         <div id="updpanel">
            <div align="center">
               <?php afUpdBnt( $option, 'afupd21b5html', JText::_( 'ARTF_UPD_UPDATETEXT').' v.2.1 b5.1' );?>
            </div>
            <div align="center">
               <?php afUpdBnt( $option, 'afupd21b6html', 'v.2.1 b5.1 => v.2.1 b6' );?>
            </div>
            <div align="center">
               <?php afUpdBnt( $option, 'afupd21b7html', 'v.2.1 b6 => '.afVersion() );?>
            </div>
            <div align="center">
               <?php afUpdBnt( $option, 'dbbackup', JText::_( 'ARTF_BKUP_MAKEDBBACKUP' ), 'update', JText::_( 'ARTF_BKUP_DOBACKUP' ) );?>
            </div>
            <div align="center">
               <?php afUpdBnt( $option, 'dbrestore', JText::_( 'ARTF_BKUP_MAKEDBRESTORE' ), 'update', JText::_( 'ARTF_BKUP_DORESTORE' ) );?>
            </div>
         </div>
         <div class="clear"></div>
         <div align="center">
         <?php
      }

      switch ($dotask) {
        case 'afupd21b5html':
                afLoadAFUpdate( '15', 'afupd21b5' );
		break;
	case 'afupd21b6html':
                afLoadAFUpdate( '35', 'afupd21b6' );
		break;
	case 'afupd21b7html':
                afLoadAFUpdate( '7', 'afupd21b7' );
		break;
	case 'afupd21b5':
                header( 'Content-Type: text/html; charset=utf-8' );
                header( 'Cache-Control: no-cache, must-revalidate ' );
                afUpd21b5();
		break;
	case 'afupd21b6':
                header( 'Content-Type: text/html; charset=utf-8' );
                header( 'Cache-Control: no-cache, must-revalidate ' );
                afUpd21b6();
		break;
	case 'afupd21b7':
                header( 'Content-Type: text/html; charset=utf-8' );
                header( 'Cache-Control: no-cache, must-revalidate ' );
                afUpd21b7();
		break;
	case 'dbbackup':
	        afLoadLib( 'bkup' );
		dbBackup( $option );
		break;
	case 'dobackup':
	        afLoadLib( 'bkup' );
		doBackup( $tables, $OutType, $OutDest, $toBackUp, $_SERVER['HTTP_USER_AGENT'], $afbkup_path );
		break;
	case 'dbrestore':
	        afLoadLib( 'bkup' );
		dbRestore( $afbkup_path );
		break;
	case 'dorestore':
	        afLoadLib( 'bkup' );
		doRestore( $file, $upfile, $afbkup_path );
		break;
      }

      if ( JArrayHelper::getValue( $_GET, 'no_afhtml' ) != '1' ) {
      echo '</div>';
      echo afFooter(0);
      }
        
   }

        
   function showRForms( &$rows, $search, &$pageNav, $option ) {

           afLoadHSJS();
           afLoadBERFormsToolbar();
           afLoadSectionTitle( JText::_( 'ARTF_MENU_RFORMS' ), 'rforms48' );
           ?>
              <form action="index.php" method="post" name="adminForm">
                 <table class="adminheading" border="0" cellpadding="3" cellspacing="0" width="100%">
                    <tr>
                       <td align="right">
                          <?php echo JText::_( 'ARTF_MULTI_SEARCHTITLE' ) ?>: <input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
                       </td>
                    </tr>
                 </table>
                 <table width="100%" border="0" cellpadding="4" cellspacing="0" class="adminlist">
                    <tr>
			<th width="20">#</th>
			<th width="20">
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
                        </th>
			<th width="120" align="center">
                        <?php echo JText::_( 'ARTF_RFORMS_DATE' ); ?>
                        </th>
			<th width="20" align="center">
                        <?php echo JText::_( 'ARTF_RFORMS_PREVIEW' ); ?>
                        </th>
                        <th align="left">
                        <?php echo JText::_( 'ARTF_RFORMS_FORMTITLE' ); ?>
                        </th>
                        <th align="left">
                        <?php echo JText::_( 'ARTF_RFORMS_JUSER' ); ?>
                        </th>
                        <th align="left">
                        IP
                        </th>
                        <th align="left">
                        <?php echo JText::_( 'ARTF_RFORMS_FIRSTFIELD' ); ?>
                        </th>
                        <th align="left">
                        <?php echo JText::_( 'ARTF_RFORMS_SECONDFIELD' ); ?>
                        </th>
                        <th align="left">
                        <?php echo JText::_( 'ARTF_RFORMS_EMAIL' ); ?>
                        </th>
                    </tr>
                 <?php
		 $k = 0;
                 for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = $rows[$i];
                        $link = 'index2.php?option=com_artforms&task=vrforms&id='.$row->id;
                        $checked = JHTML::_('grid.id', $i, $row->id );
                        $item_name = explode(";", $row->item_name);
                        $item_data = explode(";", $row->item_data);
                        ?>
		    <tr class="<?php echo "row$k"; ?>">
			<td align="center">
                        <?php echo ( $i + 1 + intval( JArrayHelper::getValue($_REQUEST, 'limitstart', 0) ) ); ?>
                        </td>
			<td align="center">
                        <?php echo $checked; ?>
                        </td>
                        <td width="120" align="center">
                        <?php echo $row->form_date; ?>
                        </td>
                        <td width="20" align="center">
                           <?php echo "<a href=\"".$link."&no_html=1&no_affoo=1&afjcss=1\" onclick=\"return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 900} )\" class=\"highslide\">
                           <img src=\"".JURI::base()."/images/preview_f2.png\" align=\"middle\" height=\"16\" width=\"16\" border=\"0\" alt=\"".JText::_( 'ARTF_RFORMS_PREVIEW' )."\"/>
                           </a>";?>
                        </td>
                        <td align="left">
                        <a href="<?php echo $link; ?>"><?php echo $row->title; ?></a>
                        </td>
                        <td align="left">
                        <?php echo $item_data[array_search('ARTFJUSER', $item_name)];?>
                        </td>
                        <td align="left">
                        <?php echo $item_data[array_search('ARTFJUSERIP', $item_name)];?>
                        </td>
                        <td align="left">
                        <?php echo strip_tags($item_data[0]);?>
                        </td>
                        <td align="left">
                        <?php
                        if( isset( $item_data[1] ) ) echo strip_tags($item_data[1]);?>
                        </td>
                        <td align="left">
                        <?php
                       foreach ($item_data as $itd){
                        if (strrchr($itd, '@')){
                           $item_email = array();
                           for ($j=0;$j < count($item_data); $j++ ){
	                      $item_email[$j] = $itd;
                           }
                           echo $item_email[0];
                        }
                       }
                        ?>
                        </td>
		    </tr>
                 <?php
		 $k = 1 - $k;
		 }
                 ?>
	         </table>
                 <?php echo $pageNav->getListFooter(); ?>
	         <input type="hidden" name="option" value="<?php echo $option; ?>" />
	         <input type="hidden" name="task" value="" />
	         <input type="hidden" name="subtask" value="rforms" />
	         <input type="hidden" name="boxchecked" value="0" />
	      </form>
              <?php
              afLoadHSDivs();
              echo afFooter();
              
   }


   function showViewRForms( &$rows, $option ) {

         require( AFPATH_ADM_SITE.'config.artforms.php' );
         afLoadLib ( 'attfiles' );
         $row = $rows[0];

         $subtask = JArrayHelper::getValue( $_GET, 'subtask' );
         switch ( $subtask ) {
          case 'dattach':

              $nfile = JArrayHelper::getValue( $_GET, 'dattachfile' );
              afDLFileFromRForms ( $nfile );

          break;
          
          default:
          
           $item_name = explode(";", $row->item_name);
           $item_data = explode(";", $row->item_data);

           if( JArrayHelper::getValue( $_GET, 'afjcss' ) == '1' ){
              afLoadVRAdmCSS();
           }

           afLoadSectionTitle( JText::_( 'ARTF_MENU_RFORMS' ), 'rforms48' );
           ?>
                 <table width="100%" border="0" cellpadding="4" cellspacing="4" class="adminlist">
                    <tr>
			<th colspan="2"><?php echo JText::_( 'ARTF_RFORMS_FORMTITLE' ).': '.$row->title; ?></th>
                    </tr>
                    <tr>
			<td colspan="2" align="right"><?php echo $row->form_date; ?></td>
                    </tr>
                    <?php
                    for($i=0; $i < count( $item_name ); $i++) {

                       if ( $item_name[$i] == 'ARTFJUSER' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSER' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
                       } elseif ( $item_name[$i] == 'ARTFJUSERNAME' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSERNAME' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
                       } elseif ( $item_name[$i] == 'ARTFJUSERIP' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_MULTI_JUSERIP' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
		       } elseif ( $item_name[$i] == 'ARTFNLYES' ){
                           echo '<tr>
			           <td align="right"><strong>'.JText::_( 'ARTF_RFORMS_USERSUBSCNL' ).':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
		       } elseif ( $item_name[$i] == 'ARTFATTACHFILE' && $item_data[$i] == '' ){
		       
		       
                       } elseif ( $item_name[$i] == 'ARTFATTACHFILE' && $item_data[$i] != '' ){
                          $dlink = JURI::base().'index.php?option=com_artforms&task=vrforms&subtask=dattach&id='.$row->id.'&no_html=1&no_affoo=1';
                          $dattachfiles = explode('|', $item_data[$i]);

                          if( $afcfg_att_path != '' && is_dir(JPATH_SITE.$afcfg_att_path) ){
                             $dattachfilepath = JPATH_SITE.$afcfg_att_path;
                          } else {
                             $dattachfilepath = AFPATH_ATTACHS_SITE;
                          }

                          foreach($dattachfiles as $dattachfile){
                             echo '<tr>
			              <td align="right">
                                         <strong>'.JText::_( 'ARTF_MULTI_ATTACHFILE' ).':</strong>
                                      </td>
			              <td align="left">
                                         <a href="'.$dlink.'&dattachfile='.$dattachfile.'">'.$dattachfile.'</a> ( '.afGetFileSize( filesize( $dattachfilepath.$dattachfile ) ).' )
                                      </td>
		                   </tr>';
		          }
                       } else {

                          echo '<tr>
			           <td align="right"><strong>'.$item_name[$i].':</strong></td>
			           <td align="left">'.$item_data[$i].'</td>
		                </tr>';
                       }
		    }
                    echo '</table>';
          echo afFooter();

          break;
          }
   }

        
   function showHelp($option){

           afLoadSectionTitle( JText::_( 'ARTF_MENU_FORMS' ), 'forms48' );
           $lang =& JFactory::getLanguage();
           $backwardLang = $lang->getbackwardLang();

           echo '<form action="index.php" method="post" name="adminForm" class="adminform" id="adminForm">';
           if (file_exists(AFPATH_TUTORIAL_ADM_SITE.'tutorial.'.$backwardLang.'.php')) {
              include(AFPATH_TUTORIAL_ADM_SITE.'tutorial.'.$backwardLang.'.php');
           } else {
              include(AFPATH_TUTORIAL_ADM_SITE.'tutorial.english.php');
           }
           
           echo '<input type="hidden" name="option" value="'.$option.'">
          <input type="hidden" name="task" value=""></form>';
           echo afFooter();

   }


   function showConfig() {

             global $mainframe, $option, $mosConfig_absolute_path, $mosConfig_live_site;
             $db =& JFactory::getDBO();
             $editor =& JFactory::getEditor();
             afLoadSectionTitle( JText::_( 'ARTF_MENU_CONFIG' ), 'config48' );

             require(AFPATH_ADM_SITE.'config.artforms.php');
             $fname = AFPATH_ADM_SITE. 'config.artforms.php';

             $query = "SELECT a.id FROM #__components AS a WHERE a.option = 'com_artforms' AND a.parent = '0'";
	     $db->setQuery( $query );
	     $compid = $db->loadResult();
	     JLoader::register('JTableComponent', JPATH_LIBRARIES.DS.'joomla'.DS.'database'.DS.'table'.DS.'component.php');
             $row = new JTableComponent( $db );
	     $row->load( $compid );
             $params = new JParameter( $row->params, $mainframe->getPath( 'com_xml', $row->option ), 'component' );
             $rootfronttitle = $params->get( 'rootfronttitle' );
             $fronttext = urldecode( $params->get( 'fronttext' ) );
             if( get_magic_quotes_gpc()) {
                $fronttext = stripcslashes($fronttext);
             }
             ?>
		<script type="text/javascript">
		function changeDisplayImage() {
                        var imgFile = document.adminForm.afcfg_asteriskimg.value;
                        var imgExt = (imgFile.substring(imgFile.lastIndexOf("."))).toLowerCase();
                        var container2 = document.getElementById('imagelib2');
                        var urlPath = '<?php echo $mosConfig_live_site;?>';

                        if (document.adminForm.afcfg_asteriskimg.value ==''){
                             var imgfunc = urlPath+'/images/artforms/asterisks/ast01.png';
                        } else {
			     var imgfunc = urlPath+'/images/artforms/asterisks/' + document.adminForm.afcfg_asteriskimg.value;
                        }
                        var bannerfilesource = '<img src="'+ imgfunc +'" name="imagelib" />';
			html = '';
                        html += (bannerfilesource);
                        container2.innerHTML = html;
		}
                function submitbutton(pressbutton) {
                   var form = document.adminForm;
                   if (pressbutton == 'cancel') {
                      submitform( pressbutton );
                      return;
                   } else {
                   <?php $editor->save( 'fronttext' ); ?>
                   submitform( pressbutton );
                   }
                }
             </script>
             <form action="index.php" method="post" name="adminForm" class="adminform" id="adminForm">

		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="350">
				<span class="componentheading">config.artforms.php:
				<?php echo is_writable( $fname ) ? '<b><font color="green"> '.JText::_( 'ARTF_MULTI_WRITABLE' ).'</font></b>' : '<b><font color="red"> '.JText::_( 'ARTF_MULTI_UNWRITABLE' ).'</font></b>' ?>
				</span>
			</td>
			<?php
                        jimport('joomla.filesystem.path');
			if (JPath::canChmod($fname)) {
				if (is_writable($fname)) {
					?>
					<td>
						<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
						<label for="disable_write"><?php echo JText::_( 'ARTF_MULTI_ENAWRITEFILE' ); ?></label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
						<label for="enable_write"><?php echo JText::_( 'ARTF_MULTI_DISAWRITEFILE' ); ?></label>
					</td>
				<?php
				}
			}
			?>
                </tr>
                </table>

               <?php
               jimport('joomla.html.pane');
               $pane =& JPane::getInstance('tabs');
               echo $pane->startPane( 'artformscfg' );
               echo $pane->startPanel( JText::_( 'ARTF_CFG_CONFIGTAB' ), 'cfg1' );
               ?>

               <table width="100%" border="0" cellpadding="4" cellspacing="4" class="adminform">
                 <th colspan="3" class="sectionname">
                   <div align="left" class="title">
                     <?php echo JText::_( 'ARTF_CFG_CONFIGTITLE' ); ?>
                   </div>
                 </th>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ASTERISKSPATH' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_asterisks_path = DS.'images'.DS.'artforms'.DS.'asterisks'.DS;
                     echo '<input type="text" size="60" name="afcfg_asterisks_path" value="'.$afcfg_asterisks_path.'" class="text_area" readonly="true">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_BKUPFILEPATH' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     if( $afcfg_bkup_path == '' )$afcfg_bkup_path = DS.'components'.DS.'com_artforms'.DS.'backups'.DS;
                     echo '<input type="text" size="60" name="afcfg_bkup_path" value="'.$afcfg_bkup_path.'" class="text_area">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ATTFILEPATH' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     if( $afcfg_att_path == '' )$afcfg_att_path = DS.'images'.DS.'artforms'.DS.'attachedfiles'.DS;
                     echo '<input type="text" size="60" name="afcfg_att_path" value="'.$afcfg_att_path.'" class="text_area">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ATTFILESAVE' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_attfilesavesel[] = JHTML::_('select.option', '0', JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_attfilesavesel[] = JHTML::_('select.option', '1', JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_attfilesaveview = JHTML::_('select.genericlist', $afcfg_attfilesavesel, 'afcfg_attfilesave', 'class="text_area" size="1"', 'value', 'text', $afcfg_attfilesave );
                     echo $afcfg_attfilesaveview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ATTIMAGEW' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="6" name="afcfg_attimagew" style="text-align:right;" class="text_area" value="'.$afcfg_attimagew.'"> px';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ATTIMAGEH' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="6" name="afcfg_attimageh" style="text-align:right;" class="text_area" value="'.$afcfg_attimageh.'"> px';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                      <strong>
                      <?php echo JText::_( 'ARTF_CFG_DBSAVEFORMS' ); ?>
                      </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_dbsaveformssel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_dbsaveformssel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_dbsaveformsview = JHTML::_('select.genericlist', $afcfg_dbsaveformssel, 'afcfg_dbsaveforms', 'class="text_area" size="1"', 'value', 'text', $afcfg_dbsaveforms );
                     echo $afcfg_dbsaveformsview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ALLOWERRREP' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_allowerr_repsel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_allowerr_repsel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_allowerr_repview = JHTML::_('select.genericlist', $afcfg_allowerr_repsel, 'afcfg_allowerr_rep', 'class="text_area" size="1"', 'value', 'text', $afcfg_allowerr_rep );
                     echo $afcfg_allowerr_repview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_BEITEMSINTERF' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_beitemsinterfasesel[] = JHTML::_('select.option', 'ajax',JText::_( 'ARTF_CFG_BEITEMSINTERFNEW' ) );
                     $afcfg_beitemsinterfasesel[] = JHTML::_('select.option', 'old',JText::_( 'ARTF_CFG_BEITEMSINTERFOLD' ) );
                     $afcfg_beitemsinterfaseview = JHTML::_('select.genericlist', $afcfg_beitemsinterfasesel, 'afcfg_beitemsinterfase', 'class="text_area" size="1"', 'value', 'text', $afcfg_beitemsinterfase );
                     echo $afcfg_beitemsinterfaseview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_USEBEHELPER' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_usebehelpersel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_usebehelpersel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_usebehelperview = JHTML::_('select.genericlist', $afcfg_usebehelpersel, 'afcfg_usebehelper', 'class="text_area" size="1"', 'value', 'text', $afcfg_usebehelper );
                     echo $afcfg_usebehelperview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_EDITDEFFIELDSLAYOUT' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     if( $afcfg_fieldsdefaultlayout == '' ){
                        $afcfg_fieldsdefaultlayout ='<div style="margin-left:15px;">
<div style="float:left;margin-top:5px;width:100px;">###FIELDNAME###</div>
<div style="float:left;margin-top:5px;">###THEFIELD###</div>
<div style="float:left;margin-top:5px;">###ASTERISK###</div>
</div>
<div class="clear"></div>';
                     } else {
                        $afcfg_fieldsdefaultlayout = urldecode( $afcfg_fieldsdefaultlayout );
                     }
                     ?>
                     <textarea class="text_area" type="text" cols="74" rows="12" name="afcfg_fieldsdefaultlayout" /><?php echo $afcfg_fieldsdefaultlayout;?></textarea>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
               </table>

               <?php
               echo $pane->endPanel();
               echo $pane->startPanel( JText::_( 'ARTF_CFG_FRONTTAB' ), 'cfg2' );
               ?>
               
               <table width="100%" border="0" cellpadding="4" cellspacing="4" class="adminform">
                 <tr>
                   <th colspan="3" class="sectionname">
                     <div align="left" class="title">
                       <?php echo JText::_( 'ARTF_CFG_FRONTTITLE' ); ?>
                     </div>
                   </th>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_SHOWFRONTCSS' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_loadfrontcsssel[] = JHTML::_('select.option', '1', JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_loadfrontcsssel[] = JHTML::_('select.option', '0', JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_loadfrontcssview = JHTML::_('select.genericlist', $afcfg_loadfrontcsssel, 'afcfg_loadfrontcss', 'class="text_area" size="1"', 'value', 'text', $afcfg_loadfrontcss );
                     echo $afcfg_loadfrontcssview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_SHOWFRONTFOOTER' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_showfrontfootersel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_showfrontfootersel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_showfrontfooterview = JHTML::_('select.genericlist', $afcfg_showfrontfootersel, 'afcfg_showfrontfooter', 'class="text_area" size="1"', 'value', 'text', $afcfg_showfrontfooter );
                     echo $afcfg_showfrontfooterview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                      <strong><?php echo JText::_( 'ARTF_CFG_ALLOWAJAX' ); ?></strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_allowajaxsel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_allowajaxsel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_allowajaxview = JHTML::_('select.genericlist', $afcfg_allowajaxsel, 'afcfg_allowajax', 'class="text_area" size="1"', 'value', 'text', $afcfg_allowajax );
                     echo $afcfg_allowajaxview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                      <strong><?php echo JText::_( 'ARTF_CFG_ALLOWFERFORMS' ); ?></strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_showferformssel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_showferformssel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_showferformsview = JHTML::_('select.genericlist', $afcfg_showferformssel, 'afcfg_showferforms', 'class="text_area" size="1"', 'value', 'text', $afcfg_showferforms );
                     echo $afcfg_showferformsview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                      <strong><?php echo JText::_( 'ARTF_CFG_ALLOWATTINFERFORMS' ); ?></strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_showattinvferformssel[] = JHTML::_('select.option', '0',JText::_( 'ARTF_MULTI_NO' ) );
                     $afcfg_showattinvferformssel[] = JHTML::_('select.option', '1',JText::_( 'ARTF_MULTI_YES' ) );
                     $afcfg_showattinvferformsview = JHTML::_('select.genericlist', $afcfg_showattinvferformssel, 'afcfg_showattinvferforms', 'class="text_area" size="1"', 'value', 'text', $afcfg_showattinvferforms );
                     echo $afcfg_showattinvferformsview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ASTERISKIMGSEL' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <div id="cfgimgsel">
                     <?php
                     $afcfg_asteriskimgview = array();
                     $javascript = 'onchange="changeDisplayImage();"';
	             $directory = '/images/artforms/asterisks/';
	             $afcfg_asteriskimgview = JHTML::_('list.images','afcfg_asteriskimg', $afcfg_asteriskimg, $javascript, $directory );
                     echo $afcfg_asteriskimgview.'</div>';

                     if($afcfg_asteriskimg != ''){

                         echo '<div id="imagelib2" align="left" width="100%">
                                  <script type="text/javascript">
                                     document.write(\'<img src="'.AFPATH_WEB_ASTERISKS_SITE.$afcfg_asteriskimg.'" name="imagelib" />\');
                                  </script>
                               </div>
                               <script type="text/javascript">window.onload=changeDisplayImage();</script>';

                     } else {

                         echo'<div id="imagelib2" align="left" width="100%">
                              </div>';

                     }
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ROOTFRONTTITLE' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="60" name="rootfronttitle" class="text_area" value="'.$rootfronttitle.'">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_FRONTTEXT' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo $editor->display( 'fronttext',  $fronttext , '600', '230', '80', '10' ) ;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
               </table>

               <?php
               echo $pane->endPanel();
               echo $pane->startPanel( JText::_( 'ARTF_CFG_VALIDETAB' ), 'cfg3' );
               ?>

               <table width="100%" border="0" cellpadding="4" cellspacing="4" class="adminform">
                 <tr>
                   <th colspan="3" class="sectionname">
                     <div align="left" class="title">
                       <?php echo JText::_( 'ARTF_CFG_VALIDETITLE' ); ?>
                     </div>
                   </th>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_ZIPCODEVALIDATION' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_valide_zipcodesel[] = JHTML::_('select.option', '^[0-9]{5}$|^[0-9]{5}-[0-9]{4}$', '33125 or 54321-6789 (USA)' );
                     $afcfg_valide_zipcodesel[] = JHTML::_('select.option', '^[A-Z]\d[A-Z] \d[A-Z]\d$', 'T0A0A0 (CANADA)' );
                     $afcfg_valide_zipcodesel[] = JHTML::_('select.option', '^[1-9][0-9]{3}\s?[a-zA-Z]{2}$', '145 EG (DU)' );
                     $afcfg_valide_zipcodesel[] = JHTML::_('select.option', '^[0-9]{5}$', '05000 (France-Germany)' );
                     $afcfg_valide_zipcodesel[] = JHTML::_('select.option', '^[0-9]{4}$', '5000 (Arg)' );
                     $afcfg_valide_zipcodesel[] = JHTML::_('select.option', '^(MC-)[0-9]{5}$', 'MC-98025 (Monaco)' );
                     $afcfg_valide_zipcodeview = JHTML::_('select.genericlist', $afcfg_valide_zipcodesel, 'afcfg_valide_zipcode', 'class="text_area" size="1"', 'value', 'text', $afcfg_valide_zipcode );
                     echo $afcfg_valide_zipcodeview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CUSTOMVALIDATION' ).' 1'; ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="60" name="afcfg_valide_custom1" class="text_area" value="'.$afcfg_valide_custom1.'">';
                     echo '<div style="margin-top:2px;">'.JText::_( 'ARTF_CFG_CUSTOMVALIDATIONLEGEND' ).' : <input type="text" size="50" name="afcfg_valide_custom1_legend" class="text_area" value="'.$afcfg_valide_custom1_legend.'"></div>';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CUSTOMVALIDATION' ).' 2'; ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="60" name="afcfg_valide_custom2" class="text_area" value="'.$afcfg_valide_custom2.'">';
                     echo '<div style="margin-top:2px;">'.JText::_( 'ARTF_CFG_CUSTOMVALIDATIONLEGEND' ).' : <input type="text" size="50" name="afcfg_valide_custom2_legend" class="text_area" value="'.$afcfg_valide_custom2_legend.'"></div>';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CUSTOMVALIDATION' ).' 3'; ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="60" name="afcfg_valide_custom3" class="text_area" value="'.$afcfg_valide_custom3.'">';
                     echo '<div style="margin-top:2px;">'.JText::_( 'ARTF_CFG_CUSTOMVALIDATIONLEGEND' ).' : <input type="text" size="50" name="afcfg_valide_custom3_legend" class="text_area" value="'.$afcfg_valide_custom3_legend.'"></div>';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CUSTOMVALIDATION' ).' 4'; ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="60" name="afcfg_valide_custom4" class="text_area" value="'.$afcfg_valide_custom4.'">';
                     echo '<div style="margin-top:2px;">'.JText::_( 'ARTF_CFG_CUSTOMVALIDATIONLEGEND' ).' : <input type="text" size="50" name="afcfg_valide_custom4_legend" class="text_area" value="'.$afcfg_valide_custom4_legend.'"></div>';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CUSTOMVALIDATION' ).' 5'; ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="60" name="afcfg_valide_custom5" class="text_area" value="'.$afcfg_valide_custom5.'">';
                     echo '<div style="margin-top:2px;">'.JText::_( 'ARTF_CFG_CUSTOMVALIDATIONLEGEND' ).' : <input type="text" size="50" name="afcfg_valide_custom5_legend" class="text_area" value="'.$afcfg_valide_custom5_legend.'"></div>';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
               </table>

               <?php
               echo $pane->endPanel();
               echo $pane->startPanel( JText::_( 'ARTF_CFG_CAPTCHATAB' ), 'cfg4' );
               ?>

               <table width="100%" border="0" cellpadding="4" cellspacing="4" class="adminform">
                 <tr>
                   <th colspan="3" class="sectionname">
                     <div align="left" class="title">
                       <?php echo JText::_( 'ARTF_CFG_CAPTCHATITLE' ); ?>
                     </div>
                   </th>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="200px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CAPTCHAMODE' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_captcha_modesel[] = JHTML::_('select.option', 'both', JText::_( 'ARTF_CFG_CAPTCHAM_BOTH' ) );
                     $afcfg_captcha_modesel[] = JHTML::_('select.option', 'image', JText::_( 'ARTF_CFG_CAPTCHAM_IMAGE' ) );
                     $afcfg_captcha_modesel[] = JHTML::_('select.option', 'audio', JText::_( 'ARTF_CFG_CAPTCHAM_AUDIO' ) );
                     $afcfg_captcha_modeview = JHTML::_('select.genericlist', $afcfg_captcha_modesel, 'afcfg_captcha_mode', 'class="text_area" size="1"', 'value', 'text', $afcfg_captcha_mode );
                     echo $afcfg_captcha_modeview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="200px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_CAPTCHALENGTH' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_captcha_lengthsel[] = JHTML::_('select.option', '3', '3' );
                     $afcfg_captcha_lengthsel[] = JHTML::_('select.option', '4', '4' );
                     $afcfg_captcha_lengthsel[] = JHTML::_('select.option', '5', '5' );
                     $afcfg_captcha_lengthsel[] = JHTML::_('select.option', '6', '6' );
                     $afcfg_captcha_lengthsel[] = JHTML::_('select.option', '7', '7' );
                     $afcfg_captcha_lengthsel[] = JHTML::_('select.option', '8', '8' );
                     $afcfg_captcha_lengthview = JHTML::_('select.genericlist', $afcfg_captcha_lengthsel, 'afcfg_captcha_length', 'class="text_area" size="1"', 'value', 'text', $afcfg_captcha_length );
                     echo $afcfg_captcha_lengthview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <th colspan="3" class="sectionname">
                     <div align="left" class="title">
                       <?php echo JText::_( 'ARTF_CFG_RECAPTCHASET' ); ?>
                     </div>
                   </th>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_RECAPTTHEME' );?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     $afcfg_captcha_recapt_themesel[] = JHTML::_('select.option', 'red', 'red' );
                     $afcfg_captcha_recapt_themesel[] = JHTML::_('select.option', 'white', 'white' );
                     $afcfg_captcha_recapt_themesel[] = JHTML::_('select.option', 'blackglass', 'blackglass' );
                     $afcfg_captcha_recapt_themeview = JHTML::_('select.genericlist', $afcfg_captcha_recapt_themesel, 'afcfg_captcha_recapt_theme', 'class="text_area" size="1"', 'value', 'text', $afcfg_captcha_recapt_theme );
                     echo $afcfg_captcha_recapt_themeview;
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="300px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_RECAPTTABINDEX' );?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="2" maxlength="2" name="afcfg_captcha_recapt_tabindex" style="text-align:center;" class="text_area" value="'.$afcfg_captcha_recapt_tabindex.'">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="200px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_RECAPTPUBKEY' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="70" name="afcfg_captcha_recapt_publickey" class="text_area" value="'.$afcfg_captcha_recapt_publickey.'">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="200px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_RECAPTPRIVKEY' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<input type="text" size="70" name="afcfg_captcha_recapt_privatekey" class="text_area" value="'.$afcfg_captcha_recapt_privatekey.'">';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
                 <tr>
                   <td align="left" valign="top" width="200px">
                     <strong>
                     <?php echo JText::_( 'ARTF_CFG_RECAPTGETKEYS' ); ?>
                     </strong>
                   </td>
                   <td align="left" valign="top">
                     <?php
                     echo '<a href="http://recaptcha.net/api/getkey" target="_blank">'.JText::_( 'ARTF_CFG_RECAPTGETKEYS' ).': reCAPTCHA.net</a>';
                     ?>
                   </td>
                   <td align="left" valign="top">
                   <?php echo '&nbsp;';?>
                   </td>
                 </tr>
               </table>

               <?php
               echo $pane->endPanel();
               echo $pane->endPane(); ?>

          <input type="hidden" name="compid" value="<?php echo $compid; ?>">
          <input type="hidden" name="option" value="<?php echo $option; ?>">
          <input type="hidden" name="task" value="saveconfig">
          <input type="hidden" name="boxchecked" value="0">
        </form>
        <?php
        echo afFooter();
        
        }


        function showArtForms( &$rows, $search, $pageNav, $option ) {

        global $mainframe, $acl, $mosConfig_offset;

        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        $acl =& JFactory::getACL();
        afLoadSectionTitle( JText::_( 'ARTF_MENU_FORMS' ), 'forms48' );
        afLoadHSJS();
        JHTML::_('behavior.tooltip');
        ?>
        
        <form action="index.php" method="post" name="adminForm">
        <table class="adminheading" border="0" cellpadding="3" cellspacing="0" width="100%">
           <tr>
              <td align="right">
                 <?php echo JText::_( 'ARTF_MULTI_SEARCHTITLE' ) ?>: <input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
              </td>
           </tr>
	</table>
	<table class="adminlist">
		<tr>
			<th width="20">#</th>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th align="left"><?php echo JText::_( 'ARTF_FORM_FORMTITLE' ); ?></th>
			<th width="20" align="left"><?php echo JText::_( 'ARTF_FORM_PUBLISHED' ); ?></th>
                        <th width="20" align="left"><?php echo JText::_( 'ARTF_RFORMS_PREVIEW' ); ?></th>
                        <th width="2%">ID</th>
                        <th align="center" width="10"><?php echo JText::_( 'ARTF_FORM_DATE' );?></th>
                        <th colspan="2" align="center" width="5%"><?php echo JText::_( 'ARTF_FORM_REORDER' );?></th>
			<th width="2%"><?php echo JText::_( 'ARTF_FORM_ORDER' );?></th>
			<th width="1%"><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="<?php JText::_( 'ARTF_FORM_SAVEORDER' );?>" /></a></th>
                        <th><?php echo JText::_( 'ARTF_FORM_ACCESS' );?></th>
			<th align="left"><?php echo JText::_( 'ARTF_FORM_AUTHOR' );?></th>
		</tr>

                <?php
                $i = 0;
		$k = 0;
		$nullDate = $db->getNullDate();
		for($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
                        JFilterOutput::objectHTMLSafe($row);
			
			$img = $row->published ? 'components/com_artforms/images/success.png' : 'images/publish_x.png';
			$task = $row->published ? 'unpublish' : 'publish';
                        $link = 'index.php?option=com_artforms&task=editA&id='.$row->id;
                        $_Itemid = afGetItemid( $row->id );
                        $linkp = $mainframe->getSiteURL().'/index2.php?option=com_artforms&formid='.$row->id.'&af_mod=1'.($_Itemid ? '&Itemid='.$_Itemid : '&Itemid=99999');

                        $now = date("Y-m-d H:i:s",strtotime($mainframe->get('requestTime')));
			if ( $now <= $row->publish_up && $row->published == 1 ) {
			// Published
				$img = 'publish_y.png';
				$alt = JText::_( 'ARTF_FORM_PUBLISHED' );
			} else if ( ( $now <= $row->publish_down || $row->publish_down == $nullDate ) && $row->published == 1 ) {
			// Pending
				$img = 'publish_g.png';
				$alt = JText::_( 'ARTF_FORM_PENDING' );
			} else if ( $now > $row->publish_down && $row->published == 1 ) {
			// Expired
				$img = 'publish_r.png';
				$alt = JText::_( 'ARTF_FORM_EXPIRED' );
			} elseif ( $row->published == 0 ) {
			// Unpublished
				$img = 'publish_x.png';
				$alt = JText::_( 'ARTF_FORM_DRAFT' );
			}
                        // correct times to include server offset info
			$row->publish_up = JHTML::_('date', $row->publish_up, JText::_('DATE_FORMAT_LC1' ) );
			if (trim( $row->publish_down ) == $nullDate || trim( $row->publish_down ) == '' || trim( $row->publish_down ) == '-' ) {
				$row->publish_down = JText::_( 'ARTF_FORM_NEVER' );
			}
			$row->publish_down = JHTML::_('date', $row->publish_down, JText::_('DATE_FORMAT_LC1' ) );

			$times = '';
			if ($row->publish_up == $nullDate) {
				$times .= JText::_( 'ARTF_FORM_START' ).': '.JText::_( 'ARTF_FORM_ALWAYS' ).'<br />';
			} else {
				$times .= JText::_( 'ARTF_FORM_START' ).': '.$row->publish_up.'<br />';
			}
			if ($row->publish_down == $nullDate || $row->publish_down == 'Never') {
				$times .= JText::_( 'ARTF_FORM_END' ).': '.JText::_( 'ARTF_FORM_NOTEXPIRED' ).'<br />';
			} else {
				$times .= JText::_( 'ARTF_FORM_END' ).': '.$row->publish_down.'<br />';
			}

			if ( $user->authorize( 'com_users', 'manage' ) ) {
				if ( $row->created_by_alias ) {
					$author = $row->created_by_alias;
				} else {
					$linkA 	= 'index.php?option=com_users&task=editA&hidemainmenu=1&id='. $row->created_by;
					$author = '<a href="'. $linkA .'" title="'.JText::_( 'ARTF_FORM_EDITUSER' ).'">'. $row->author .'</a>';
				}
			} else {
				if ( $row->created_by_alias ) {
					$author = $row->created_by_alias;
				} else {
					$author = $row->author;
				}
			}
                        $date      = JHTML::_('date', $row->created, '%x' );
                        $access    = JHTML::_('grid.access',   $row, $i );
			$checked   = JHTML::_('grid.checkedout',   $row, $i );
                        ?>
		   <tr class="row<?php echo $k; ?>">
			<td align="center">
                           <?php echo ( $i + 1 + intval( JArrayHelper::getValue($_REQUEST, 'limitstart', 0) ) ); ?>
                        </td>
			<td align="center">
                           <?php echo $checked; ?>
                        </td>
			<td align="left">
			   <span class="editlinktip hasTip" title="<?php echo JText::_( 'ARTF_FORM_EDITCONTENTOF' );?>::<?php echo $row->titel; ?>">
					<?php
					if (  JTable::isCheckedOut($user->get ('id'), $row->checked_out )  ) {
						echo $row->titel;
					} else {
						?>
						<a href="<?php echo JRoute::_( $link ); ?>">
							<?php echo $row->titel; ?></a>
						<?php
					}
			   ?></span>
                        </td>
                        <td width="20" align="center">
                        <?php
				if ( $times ) {
					?>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'ARTF_FORM_PUBLISHINFO' ).' :: '.$times;?>">
                                           <a href="javascript: void(0);" title="" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->published ? "unpublish" : "publish";?>')">
					   <img src="images/<?php echo $img;?>" border="0" alt="<?php echo $alt; ?>" /></a>
					</span>
					<?php
				}
				?>
                        </td>
                        <td width="20" align="center">
                        <?php echo "<a href=\"".$linkp."\" onclick=\"return hs.htmlExpand(this, { contentId: 'highslide-html', objectType: 'iframe', objectWidth: 700, objectHeight: 900} )\" class=\"highslide\">
                           <img src=\"".JURI::base()."/images/preview_f2.png\" align=\"middle\" height=\"16\" width=\"16\" border=\"0\" alt=\"".JText::_( 'ARTF_RFORMS_PREVIEW' )."\"/>
                           </a>";?>
                        </td>
                        <td align="left">
		           <?php echo $row->id; ?>
                        </td>
                        <td align="left">
		           <?php echo $date; ?>
                        </td>
                        <td align="right">
                           <?php echo $pageNav->orderUpIcon( $i, true, 'orderup' ); ?>
                        </td>
                        <td align="left">
                           <?php echo $pageNav->orderDownIcon( $i, $n, true, 'orderdown' ); ?>
                        </td>
                        <td align="center" colspan="2">
                           <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
                        </td>
                        <td align="center">
                           <?php echo $access;?>
                        </td>
                        <td align="left">
                           <?php echo $author; ?>
                        </td>
		   </tr>
                   <?php
		   $k = 1 - $k;
		}
        ?>

	</table>
        <?php
        afLoadHSDivs();
        echo $pageNav->getListFooter();
        ?>
        
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="subtask" value="showaf" />
	<input type="hidden" name="boxchecked" value="0" />

	</form>

        <?php
        echo afFooter();
   }


   function editArtForms( $row, $option, $formid, $items, $lists, $itlists, $params ) {

      global $mosConfig_offset;
      $db =& JFactory::getDBO();
      $editor =& JFactory::getEditor();

      include( AFPATH_ADM_SITE.'config.artforms.php' );
      include( AFPATH_LIB_ADM_SITE.'af.lib.loadhelper.php' );

      JHTML::_('behavior.calendar');
      JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES );
      afLoadFrontEndCSS();
      
      $nullDate = $db->getNullDate();
      $create_date = null;
      if ( $row->created != $nullDate ) $create_date = JHTML::_('date', $row->created, '%A, %d %B %Y %H:%M', '0' );
      $mod_date = null;
      if ( $row->modified != $nullDate ) $mod_date = JHTML::_('date', $row->modified, '%A, %d %B %Y %H:%M', '0' );
      if ( !$row->hits ) {
         $visibility = "style='display: none; visibility: hidden;'";
      } else {
         $visibility = '';
      }
      ?>
          <script type="text/javascript">
	     function submitbutton(pressbutton) {

                        var form = document.adminForm;

                        if ( pressbutton == 'menulink' ) {
			      // do field validation
			      if (trim(form.link_name.value) == ""){
				alert( "<?php echo JText::_( 'ARTF_FORM_CHECKEMPTYMENUNAME' ); ?>" );
			      } else if (trim(form.menuselect.value) == ""){
				alert( "<?php echo JText::_( 'ARTF_FORM_CHECKEMPTYMENUSEL' ); ?>" );
			      } else if (trim(form.link_type.value) == ""){
				alert( "<?php echo JText::_( 'ARTF_FORM_CHECKEMPTYMENUTYPE' ); ?>" );
			      } else {
				submitform( pressbutton );
			      }
			}

                        if ( pressbutton == 'afresethits' ) {
			      submitform( pressbutton );
			}

                        if (pressbutton == 'cancel' || pressbutton == 'menu' || pressbutton == 'help') {
			      submitform( pressbutton );
			      return;
			}

			if ( pressbutton == 'save' || pressbutton == 'apply' ) {
			   if (form.titel.value == ""){
				alert( "<?php echo JText::_( 'ARTF_FORM_CHECKEMPTYFORMTITLE' ); ?>" );
			   } else if (form.email.value == ""){
				alert( "<?php echo JText::_( 'ARTF_FORM_CHECKEMPTYFORMMAILTO' ); ?>" );
			   <?php /*} else if (form.danktext.value == ""){
				alert( "<?php echo JText::_( 'ARTF_FORM_CHECKEMPTYDANKTEXT' ); ? >" ); */?>
                           } else {
				<?php $editor->save( 'text' ); ?>
				<?php $editor->save( 'danktext' ); ?>
				submitform( pressbutton );
                           }
                        }
             }
          </script>

          <form action="index.php" method="post" name="adminForm" id="adminForm" class="adminform">
          <input type="hidden" name="getid" value="<?php echo $formid;?>" />
          <?php
          afLoadSectionTitle( JText::_( 'ARTF_MENU_FORMS' ), 'forms48' );
          
          $customjscode = urldecode( $row->customjscode );
          if( get_magic_quotes_gpc()) $customjscode = stripcslashes($customjscode);
          $customjscode = str_replace("<","&lt;",$customjscode);
	  $customjscode = str_replace(">","&gt;",$customjscode);

          jimport('joomla.html.pane');
          $pane =& JPane::getInstance('tabs');
          echo $pane->startPane( 'artforms' );
          echo $pane->startPanel( JText::_( 'ARTF_FORM_TABCONFIG' ), 'menu1' );
          ?>
          <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
             <tr>
                <td valign="top">
                   <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                      <tr>
                         <th align="left" colspan="2">
                            <?php echo JText::_( 'ARTF_FORM_TITLECONFIG' ); ?>
                         </th>
                      </tr>
                      <tr>
                         <td width="250px">
                            <?php echo JText::_( 'ARTF_FORM_FORMTITLE' ); ?>:
                         </td>
                         <td>
                            <input class="text_area" type="text" size="51" maxlength="100"  style="width:276px" name="titel" value="<?php echo $row->titel; ?>" />
                            <?php echo $helper_title;?>
                         </td>
                      </tr>
                      <tr>
                         <td width="250px" valign="top">
                            <?php echo JText::_( 'ARTF_FORM_EMAILS' ); ?>:
                         </td>
                         <td>
                            <table border="0" cellpadding="0" style="border-collapse: collapse" width="100%" id="table1">
                               <tr>
                                  <td width="49">
                                     <?php echo JText::_( 'ARTF_FORM_TO' ) ;?>:
                                  </td>
                                  <td>
                                     <input class="text_area" type="text" size="40" maxlength="100" name="email" value="<?php echo $row->email; ?>" />
                                     <?php echo $helper_destto;?>
                                  </td>
                               </tr>
                               <tr>
                                  <td width="49">
                                     <?php echo JText::_( 'ARTF_FORM_CC' ) ;?>:
                                  </td>
                                  <td>
                                     <input class="text_area" type="text" size="40" name="ccmail" value="<?php echo $row->ccmail; ?>" />
                                     <?php echo $helper_destcc;?>
                                  </td>
                               </tr>
                               <tr>
                                  <td width="49">
                                     <?php echo JText::_( 'ARTF_FORM_BCC' ) ;?>:
                                  </td>
                                  <td>
                                     <input class="text_area" type="text" size="40" name="bccmail" value="<?php echo $row->bccmail; ?>" />
                                     <?php echo $helper_destbcc;?>
                                  </td>
                               </tr>
                            </table>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" width="250px">
                            <?php echo JText::_( 'ARTF_FORM_CONFIRMATIONEMAIL' ); ?>:
                         </td>
                         <td>
                            <input class="text_area" type="text" size="40" name="params[confirmation_email]" value="<?php echo $params->get( 'confirmation_email' ); ?>" />
                            <?php echo $helper_confirmationemail;?>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" width="250px">
                            <?php echo JText::_( 'ARTF_FORM_TEXTHTMLSET' ); ?>:
                         </td>
                         <td>
                            <?php echo $lists['formopt'];?>
                            <?php echo $helper_htmlmode;?>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" width="250px">
                            <?php echo JText::_( 'ARTF_FORM_EDITORSEL' ).' (HTML)';?>:
                         </td>
                         <td>
                            <?php echo $lists['afeditor'];?>
                            <?php echo $helper_editorsel;?>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" width="250px">
                            <?php echo JText::_( 'ARTF_FORM_EMAILCOPYFIELD' ); ?>:
                         </td>
                         <td>
                            <?php echo $lists['emailfieldallow'];?>
                            <?php echo $helper_allsendcopy;?>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top">
                            <?php echo JText::_( 'ARTF_FORM_CUSTOMJSCODE' );?>:
                         </td>
                         <td>
                            <textarea class="text_area" cols="50" rows="7" name="customjscode"><?php echo $customjscode;?></textarea>
                            <?php echo $helper_custjscode;?>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top">
                            <?php echo JText::_( 'ARTF_FORM_CUSTOMCSS' );?>:
                         </td>
                         <td>
                            <textarea class="text_area" cols="50" rows="7" name="customcss" id="afcustomcss"><?php if(isset($row->customcss))echo $row->customcss;?></textarea>
                            <a href="javascript:void(0);" id="afloadcss" class="afbutton" style="width:86px;text-align:center;float:left;"><?php echo JText::_( 'ARTF_FORM_LOADCSS' );?></a>
                            <a id="afstopcss" href="javascript:void(0);" class="afbutton" style="width:86px;text-align:center;float:left;"><?php echo JText::_( 'ARTF_BKUP_RESET' );?></a>
                            <?php echo $helper_custcss;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="left" colspan="2" class="clear">
                   &nbsp;
                         </td>
                      </tr>
                   </table>
                   <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                      <tr>
                        <th colspan="2">
                          <?php echo JText::_( 'ARTF_FORM_NEWSLETTER' );?>
                        </th>
                      </tr>
                      <tr>
                        <td valign="top" width="250px">
                         <?php echo JText::_( 'ARTF_FORM_NEWSLETTERSEL' );?>:
                        </td>
                        <td valign="top">
                          <?php
                          if($params->get( 'show_newsletter_system' ) != ''){
                             $getnewsletter = $params->get( 'show_newsletter_system' );
                          } else {
                             $getnewsletter ='0';
                          }
                          $lists['newslettersys'] = JHTML::_('select.genericlist', $itlists['newslettersel'], 'params[show_newsletter_system]', 'class="text_area" size="1"', 'value', 'text', $getnewsletter);
                          echo $lists['newslettersys'];
                          ?>
                        </td>
                      </tr>
                      <tr>
                         <td align="left" colspan="2">
                   &nbsp;
                         </td>
                      </tr>
                   </table>
                   <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                      <tr>
                        <th colspan="2">
                          <?php echo JText::_( 'ARTF_FORM_TEXTCAPTCHA' );?>
                        </th>
                      </tr>
                      <tr>
                        <td valign="top" width="250px">
                         <?php echo JText::_( 'ARTF_FORM_CAPTCHASYSTEM' );?>:
                        </td>
                        <td valign="top">
                          <?php echo $lists['seccodeallow'];?>
                          <?php echo $helper_captcha;?>
                        </td>
                      </tr>
                      <tr>
                         <td align="left" colspan="2">
                   &nbsp;
                         </td>
                      </tr>
                   </table>
                   <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                      <tr>
                        <th colspan="2">
                          <?php echo JText::_( 'ARTF_FORM_METADATA' );?>
                        </th>
                      </tr>
                      <tr>
                        <td valign="top">
                         <?php echo JText::_( 'ARTF_FORM_METADESCRIPTION' );?>:
                         <?php echo $helper_metadesc;?>
                        </td>
                        <td valign="top" align="right">
                          <?php echo JText::_( 'ARTF_FORM_METAKEYWORDS' );?>:
                          <?php echo $helper_metakey;?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top">
                         <textarea class="text_area" cols="40" rows="5" name="metadesc"><?php echo $row->metadesc;?></textarea>
                        </td>
                        <td valign="top">
                          <textarea class="text_area" cols="40" rows="5" name="metakey"><?php echo $row->metakey;?></textarea>
                        </td>
                      </tr>
                      <tr>
                         <td align="left" colspan="2">
                   &nbsp;
                         </td>
                      </tr>
                   </table>
                </td>
                <td width="25%" valign="top">
                   <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                      <tr>
                         <th align="left" colspan="2">
                            <?php echo JText::_( 'ARTF_FORM_TITLEPUBLCATION' );?>
                         </th>
                      </tr>
                        <tr>
                          <td valign="top" align="right"><?php echo JText::_( 'ARTF_FORM_PUBLISH' );?>:
                            <input type="checkbox" name="published" value="1" <?php echo $row->published ? 'checked="checked"' : ''; ?> />
                            <?php echo $helper_publish;?>
                          </td>
                        </tr>
                        <tr>
                          <td valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_MENUACCESS' );?>:
                            <br />
                            <?php echo $lists['access']; ?>
                            <?php echo $helper_access;?>
                          </td>
                        </tr>
                        <tr>
                          <td valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_AUTHORALIAS' );?>:
                            <br />
                            <input type="text" name="created_by_alias" size="30" maxlength="100" value="<?php echo $row->created_by_alias; ?>" class="text_area" />
                            <?php echo $helper_authoralias;?>
                          </td>
                        </tr>
                        <tr>
                          <td width="100%">
                            <?php echo JText::_( 'ARTF_FORM_MODCREATEDBY' );?>:
                            <br />
                            <?php echo $lists['created_by']; ?>
                            <?php echo $helper_creator;?>
                          </td>
                        </tr>
                        <tr>
                          <td width="100%">
                            <?php echo JText::_( 'ARTF_FORM_ORDER' );?>:
                            <br />
                            <?php echo $lists['ordering']; ?>
                            <?php echo $helper_forder;?>
                          </td>
                        </tr>
                        <tr>
                          <td width="100%">
                            <?php echo JText::_( 'ARTF_FORM_MODCREATEDDATE' );?>:
                            <br />
                            <input class="text_area" type="text" name="created" id="created" size="25" maxlength="19" value="<?php echo $row->created; ?>" />
			    <input name="reset" type="reset" class="button" onclick="return showCalendar('created', 'y-mm-dd');" value="..." />
                            <?php echo $helper_createddate;?>
                          </td>
                        </tr>
                        <tr>
                          <td width="100%">
                            <?php echo JText::_( 'ARTF_FORM_PUBLISHUP' );?>:
                            <br />
                            <input class="text_area" type="text" name="publish_up" id="publish_up" size="25" maxlength="19" value="<?php echo $row->publish_up; ?>" />
			    <input type="reset" class="button" value="..." onClick="return showCalendar('publish_up', 'y-mm-dd');">
                            <?php echo $helper_publishup;?>
                          </td>
                        </tr>
                        <tr>
                          <td width="100%">
                            <?php echo JText::_( 'ARTF_FORM_PUBLISHDOWN' );?>:
                            <br />
                            <input class="text_area" type="text" name="publish_down" id="publish_down" size="25" maxlength="19" value="<?php echo $row->publish_down; ?>" />
		            <input type="reset" class="button" value="..." onClick="return showCalendar('publish_down', 'y-mm-dd');">
                            <?php echo $helper_publishdown;?>
                          </td>
                        </tr>
                   </table>
                   <br />
                   <table class="adminform">
                   <?php
                   if ( $row->id ) {?>
                      <tr>
                         <td>
                            ID:
                         </td>
                         <td>
                            <?php echo $formid; ?>
                         </td>
                      </tr>
                      <tr>
                         <td>
                            <?php echo JText::_( 'ARTF_FORM_URLLINK' ); ?>:
                         </td>
                         <td>
                            index.php?option=com_artforms&formid=<?php echo $formid; ?>
                         </td>
                      </tr>
                      <?php
                   }?>
                      <tr>
                         <td width="120" valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_STATE' );?>:
                         </td>
                         <td>
                            <?php echo $row->published > 0 ? JText::_( 'ARTF_FORM_PUBLISHED' ) : ($row->published < 0 ? JText::_( 'ARTF_FORM_ARCHIVED' ) : JText::_( 'ARTF_FORM_DRAFT' ));?>
                         </td>
                      </tr>
                      <tr >
                         <td valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_HITS' );?>:
                         </td>
                         <td>
                            <?php $afhits = $row->hits;
                            echo $afhits;?>
                            <div <?php echo $visibility; ?>>
                               <input name="afresethits" type="button" class="button" value="<?php echo JText::_( 'ARTF_FORM_DELHITS' );?>" onClick="submitbutton('afresethits');">
                            </div>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_REV' );?>:
                         </td>
                         <td>
                            <?php
                            if( isset($row->version) ){
                               echo $row->version.' '.JText::_( 'ARTF_FORM_REVTIMES' );
                            } else {
                               echo '-';
                            }
                            ?>
                            <input type="hidden" name="version" value="<?php echo $row->version+1;?>" />
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_CREATED' );?>:
                         </td>
                         <td>
                            <?php
                            if ( !$create_date ) {?>
                               <?php echo JText::_( 'ARTF_FORM_NEWFORM' );?>
                            <?php
                            } else {
                               echo $create_date;
                            }?>
                         </td>
                      </tr>
                      <tr>
                         <td valign="top" align="right">
                            <?php echo JText::_( 'ARTF_FORM_LASTMOD' );?>:
                         </td>
                         <td>
                            <?php
                            if ( !$mod_date ) {?>
                               <?php echo JText::_( 'ARTF_FORM_NOTMOD' );?>
                            <?php
                            } else {
                               echo $mod_date;
                               ?>
                               <br />
                               <?php
                               echo $row->modifier;
                            }?>
                         </td>
                      </tr>
                   </table>
                   <table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                      <tr>
                         <th align="left" colspan="2">
                            <?php echo JText::_( 'ARTF_FORM_TITLEPARAMS' ); ?>
                         </th>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_SHOWRESETBTN' );?>:
                         </td>
                         <td>
	                    <input name="params[show_reset_button]" id="params[show_reset_button]0" value="0"<?php if($params->get( 'show_reset_button' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_reset_button]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[show_reset_button]" id="params[show_reset_button]1" value="1"<?php if($params->get( 'show_reset_button' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_reset_button]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_resetbtn;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_SHOWBACKBTN' );?>:
                         </td>
                         <td>
                            <input name="params[show_back_button]" id="params[show_back_button]0" value="0"<?php if($params->get( 'show_back_button' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_back_button]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[show_back_button]" id="params[show_back_button]1" value="1"<?php if($params->get( 'show_back_button' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_back_button]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_backbtn;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_SHOWFORMTITLE' );?>:
                         </td>
                         <td>
                            <input name="params[show_form_title]" id="params[show_form_title]0" value="0"<?php if($params->get( 'show_form_title' )=='0')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_form_title]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[show_form_title]" id="params[show_form_title]1" value="1"<?php if($params->get( 'show_form_title' )!='0')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_form_title]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_showtitle;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_DYNAMICPAGETITLES' );?>:
                         </td>
                         <td>
                            <input name="params[change_page_title]" id="params[change_page_title]0" value="0"<?php if($params->get( 'change_page_title' )=='0')echo ' checked="checked"';?> type="radio">
	                    <label for="params[change_page_title]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[change_page_title]" id="params[change_page_title]1" value="1"<?php if($params->get( 'change_page_title' )!='0')echo ' checked="checked"';?> type="radio">
	                    <label for="params[change_page_title]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_dynpagetitle;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_SHOWCREATEDDATE' );?>:
                         </td>
                         <td>
                            <input name="params[show_created_date]" id="params[show_created_date]0" value="0"<?php if($params->get( 'show_created_date' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_created_date]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[show_created_date]" id="params[show_created_date]1" value="1"<?php if($params->get( 'show_created_date' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_created_date]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_showcreated;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_SHOWMODIFDATE' );?>:
                         </td>
                         <td>
                            <input name="params[show_modif_date]" id="params[show_modif_date]0" value="0"<?php if($params->get( 'show_modif_date' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_modif_date]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[show_modif_date]" id="params[show_modif_date]1" value="1"<?php if($params->get( 'show_modif_date' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_modif_date]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_showmodif;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_SHOWAUTHOR' );?>:
                         </td>
                         <td>
                            <input name="params[show_author]" id="params[show_author]0" value="0"<?php if($params->get( 'show_author' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_author]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[show_author]" id="params[show_author]1" value="1"<?php if($params->get( 'show_author' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[show_author]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_showauthor;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_USECUSTOMCSS' );?>:
                         </td>
                         <td>
	                    <input name="params[use_custom_css]" id="params[use_custom_css]0" value="0"<?php if($params->get( 'use_custom_css' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[use_custom_css]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[use_custom_css]" id="params[use_custom_css]1" value="1"<?php if($params->get( 'use_custom_css' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[use_custom_css]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_usecustcss;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_USEREDIRECTURL' );?>:
                         </td>
                         <td>
	                    <input name="params[use_redirect_url]" id="params[use_redirect_url]0" value="0"<?php if($params->get( 'use_redirect_url' )!='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[use_redirect_url]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                    <input name="params[use_redirect_url]" id="params[use_redirect_url]1" value="1"<?php if($params->get( 'use_redirect_url' )=='1')echo ' checked="checked"';?> type="radio">
	                    <label for="params[use_redirect_url]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                            <?php echo $helper_useredir;?>
                         </td>
                      </tr>
                      <tr>
                         <td align="right" valign="top" width="40%">
                            <?php echo JText::_( 'ARTF_FORM_REDIRECTURL' );?>:
                         </td>
                         <td>
                            <input name="params[redirect_url]" value="<?php echo $params->get( 'redirect_url' );?>" class="text_area" size="" type="text">
                            <?php echo $helper_redirurl;?>
                         </td>
                      </tr>
                   </table>
                </td>
             </tr>
          </table>

          <?php
          echo $pane->endPanel();
          echo $pane->startPanel( JText::_( 'ARTF_FORM_TABTEXTS' ), 'menu2' );
          ?>
		<table border="0" cellpadding="3" cellspacing="0" width="100%" class="adminform">
                   <tr>
                      <th align="left">
                         <?php echo JText::_( 'ARTF_FORM_TITLETEXTS' ); ?>
                      </th>
                   </tr>
                   <tr>
                      <td valign="top">
                         <br /><?php echo JText::_( 'ARTF_FORM_INFTEXT' ); ?>:
                         <?php echo $helper_text;?>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <?php echo $editor->display( 'text',  $row->text , '600', '230', '80', '10' ) ; ?>
                      </td>
                   </tr>
                   <tr>
                      <td valign="top">
                         <br /><?php echo JText::_( 'ARTF_FORM_SENDEDTEXT' ); ?>:
                         <?php echo $helper_danktext;?>
                      </td>
                   </tr>
                   <tr>
                      <td>
                         <?php echo $editor->display( 'danktext',  $row->danktext , '600', '230', '80', '10' ) ; ?>
                      </td>
                   </tr>
		</table>

          <?php
          echo $pane->endPanel();
          echo $pane->startPanel( JText::_( 'ARTF_FORM_TABATTFILE' ), 'menu3' );
          ?>

		<table class="adminform" border="0" cellpadding="3" cellspacing="0" width="100%">
		   <tr>
                      <th align="left">
                         <?php echo JText::_( 'ARTF_FORM_TITLEATTFILE' );?>
                      </th>
                      <th align="left" colspan="2"></th>
                   </tr>
                   <tr>
                      <td valign="top" width="300px">
                         <?php echo JText::_( 'ARTF_FORM_ALLOWATTFILES' );?>:
                      </td>
                      <td align="left">
                         <?php echo $lists['formattallow'];?>
                         <?php echo $helper_allowattfiles;?>
                      </td>
                      <td>
                         &nbsp;
                      </td>
                   </tr>
                   <tr>
                      <td valign="top" width="300px">
                         <?php echo JText::_( 'ARTF_FORM_ALLOWATTFILESSIZE' );?>:
                      </td>
                      <td align="left">
                         <input class="text_area" type="text" size="10" maxlength="100" name="allowattfilesize" style="text-align:right;" value="<?php echo $row->allowattfilesize;?>" /> KBytes
                         <?php echo $helper_allowattfilessize;?>
                      </td>
                      <td>
                         &nbsp;
                      </td>
                   </tr>
                   <tr>
                      <td align="right" valign="top" width="40%">
                         <?php echo JText::_( 'ARTF_FORM_LIMITATT' );?>:
                      </td>
                      <td>
                         <input name="params[limit_attachs]" value="<?php echo $params->get( 'limit_attachs' );?>" class="text_area" size="3" style="text-align:center;" type="text">
                         <?php echo $helper_limitatt;?>
                      </td>
                   </tr>
                   <tr>
                      <td align="right" valign="top" width="40%">
                         <?php echo JText::_( 'ARTF_FORM_SETATTMANDITORY' );?>:
                      </td>
                      <td>
	                 <input name="params[set_att_manditory]" id="params[set_att_manditory]0" value="0"<?php if($params->get( 'set_att_manditory' )!='1')echo ' checked="checked"';?> type="radio">
	                 <label for="params[set_att_manditory]0"><?php echo JText::_( 'ARTF_MULTI_NO' );?></label>
	                 <input name="params[set_att_manditory]" id="params[set_att_manditory]1" value="1"<?php if($params->get( 'set_att_manditory' )=='1')echo ' checked="checked"';?> type="radio">
	                 <label for="params[set_att_manditory]1"><?php echo JText::_( 'ARTF_MULTI_YES' );?></label>
                         <?php echo $helper_attmanditory;?>
                      </td>
                   </tr>
                   <tr>
                      <td align="left" colspan="3">
                         <?php echo JText::_( 'ARTF_FORM_ALLOWATTFILESSET' );?>:
                         <?php echo $helper_allowattfilesset;?>
                      </td>
                   </tr>
                   <tr>
                      <td align="left" valign="top" colspan="2">
                      <?php
                      afLoadLib ( 'attfiles' );
                      $chkarr = explode( ",", $row->allowattfiles );
                      afLoadMTTips();
                      echo '<table><tr><td valign="top">';
                      afAdmShowAttSelCombo( 'compress', $chkarr );
                      afAdmShowAttSelCombo( 'misc', $chkarr );
                      echo '</td><td valign="top">';
                      afAdmShowAttSelCombo( 'office', $chkarr );
                      afAdmShowAttSelCombo( 'video', $chkarr );
                      echo '</td><td valign="top">';
                      afAdmShowAttSelCombo( 'audio', $chkarr );
                      echo '</td><td valign="top">';
                      afAdmShowAttSelCombo( 'image', $chkarr );
                      afAdmShowAttSelCombo( 'p2p', $chkarr );
                      echo '</td></tr></table>';
                      ?>
                      </td>
                      <td align="left">
                         &nbsp;
                      </td>
                   </tr>
                   <tr>
                      <td align="left" colspan="3">
                         &nbsp;
                      </td>
                   </tr>
                </table>
                <?php
          echo $pane->endPanel();
          echo $pane->startPanel( JText::_( 'ARTF_FORM_TABMENU' ), 'menu4' );

          afLoadLib( 'loadmenus' );
          afLoadLib( 'legacy' );
          
	if ( $formid > 0 ) {
	?>
           <table class="adminform">
              <tr>
                 <td valign="top">
                    <table class="adminform">
                       <tr>
                          <th colspan="2">
                             <?php echo JText::_( 'ARTF_FORM_TITLEMENU' ); ?>
                          </th>
                       </tr>
                       <tr>
                          <td colspan="2">
                             <?php echo JText::_( 'ARTF_FORM_MENUTEXT' ); ?>
                             <br /><br />
                          </td>
                       </tr>
                       <tr>
                          <td valign="top" width="130">
                             <?php echo JText::_( 'ARTF_FORM_MENUSELMENU' ).':'; ?>
                          </td>
                          <td>
                             <?php
                             echo afMenuSelect(); ?>
                             <?php echo $helper_selmenu;?>
                          </td>
                       </tr>
                       <tr>
                          <td valign="top" width="130">
                             <?php echo JText::_( 'ARTF_FORM_MENUTYPE' ).':'; ?>
                          </td>
                          <td>
                             <?php
                             $types[] = JHTML::_('select.option', '', JText::_( 'ARTF_FORM_MENUSELTYPE' ) );
                             $types[] = JHTML::_('select.option', 'artforms_form_link', JText::_( 'ARTF_FORM_MENUTYPEAFL' ) );
                             $types[] = JHTML::_('select.option', 'url', JText::_( 'ARTF_FORM_MENUTYPEURL' ) );
                             $lists['link_type'] = JHTML::_('select.genericlist', $types, 'link_type', 'class="text_area" size="1"', 'value', 'text' );
                             echo $lists['link_type']; ?>
                             <?php echo $helper_seltitletype;?>
                          </td>
                       </tr>
                       <tr>
                          <td valign="top" width="130">
                             <?php echo JText::_( 'ARTF_FORM_MENUINSERTNAME' ).':'; ?>
                          </td>
                          <td>
                             <input type="text" name="link_name" class="text_area" value="" size="25" />
                             <?php echo $helper_menutitle;?>
                          </td>
                       </tr>
                       <tr>
                          <td valign="top" width="130">
                             <?php echo JText::_( 'ARTF_FORM_MENUACCESS' ).':'; ?>
                          </td>
                          <td>
                             <?php echo afMenuAccess(); ?>
                             <?php echo $helper_menuaccess;?>
                          </td>
                       </tr>
                       <tr>
                          <td valign="top" width="130">
                             <?php echo JText::_( 'ARTF_FORM_MENUPUBLISH' ).':'; ?>
                          </td>
	                  <td>
	                     <input type="checkbox" id="link_published" name="link_published" value="1"/>
                             <?php echo $helper_menupublish;?>
                          </td>
                       </tr>
                          <tr>
                          <td>
                             <input type="hidden" name="menufid" value="<?php echo $formid;?>" />
                          </td>
                          <td>
	                     <input name="menulink" type="button" class="button" value="<?php echo JText::_( 'ARTF_FORM_MENUMAKEMENU' ); ?>" onClick="submitbutton('menulink');" />
	                  </td>
                       </tr>
                    </table>
                 </td>
                 <td valign="top">
                    <table class="adminform">
		       <tr>
	                  <th colspan="2">
	                     <?php echo JText::_( 'ARTF_FORM_MENULINKSTITLE' ); ?>
	                  </th>
                       </tr>
		       <?php
		       $and = "\n AND link = 'index.php?option=com_artforms&formid=".$formid."'";
		       $menusafl = afLinks2Menu( 'artforms_form_link', $and );
                       $menusurl = afLinks2Menu( 'url', $and );

	               if ( $menusafl != NULL || $menusurl != NULL ) {

                          afmenuLinksSecCat( $menusafl );
                          afmenuLinksSecCat( $menusurl );
                          afmenuLinksSecCatJS();
                          
                       } else {
                       ?>
	                  <tr>
	                     <td colspan="2">
                                <?php echo JText::_( 'ARTF_FORM_NONE' ); ?>
		             </td>
			  </tr>
                         <?php
                       }
					?>
                       <tr>
                          <td colspan="2">
                          </td>
                       </tr>
                    </table>
                 </td>
              </tr>
           </table>
					<?php
	} else {
					?>
	   <table class="adminform" width="40%">
	      <tr>
                 <th>
                    &nbsp;
                 </th>
              </tr>
              <tr>
                 <td>
                    <br />
                    <?php echo JText::_( 'ARTF_FORM_MENULINKSALERT' ); ?>
                    <br />
                    <br />
                    <br />
                    <br />
                 </td>
              </tr>
           </table>
	<?php
	}

          echo $pane->endPanel();
          echo $pane->startPanel( JText::_( 'ARTF_FORM_TABFIELDS' ), 'menu5' );


          if( $afcfg_beitemsinterfase == 'old' ){
             afLoadLib( 'fields' );
          } else {
             afLoadLib( 'fieldsajax' );
          }
          showEditFields( $option, $formid, $items, $itlists, $afcfg_usebehelper, $afcfg_fieldsdefaultlayout );

          echo $pane->endPanel();
          echo $pane->endPane();
          
          echo afFooter();

   }
	
	
   function showArtFormsInfo() {

      global $option;
      require_once( AFPATH_SITE.'version.php' );
      afLoadSectionTitle( JText::_( 'ARTF_MENU_INFO' ), 'info48' );

      afLoadLib( 'rdf' );
      $rdf = new afRDF();
      $url = 'http://jartforms.interjoomla.com.ar/afj15versioncheck.rdf';
      $rdf->getRDF($url, 1);

      jimport('joomla.html.pane');
      $pane =& JPane::getInstance('tabs');
      echo $pane->startPane( 'artformsinfo' );
      echo $pane->startPanel( JText::_( 'ARTF_CRED_TABA' ), 'info1' );

      $spamfix = base64_decode('QA==');//only to prevent spam from JoomlaCode's SVN

      echo '<form action="index.php" method="post" name="adminForm" class="adminform" id="adminForm">
           <input type="hidden" name="option" value="'.$option.'">
           <input type="hidden" name="task" value=""></form>
           <table cellpadding="4" cellspacing="10" border="0" width="100%">
	    <tr>
	       <td width="250px">
                  <div align="center" width="100%">
                     <div align="center" width="100%">
                        <img src="'.AFPATH_WEB_IMG_ADM_SITE.'artformsbox.png" align="center" alt="ArtForms Box" title="ArtForms Box" />
                     </div>
                     <div align="left">
                        <img style="margin-bottom:-4px;" border="0" src="'.AFPATH_WEB_IMG_ADM_SITE.'minilogo.png" alt="ArtForms" title="" /><br />
                        <font color="#000000" size="1">'.JText::_( 'ARTF_CRED_OLDDEV' ).' <a target="_blank" href="http://Joomla-Radio.de/">Andreas Duswald</a><br />
                        '.JText::_( 'ARTF_CRED_BYNEW21A' ).' <a target="_blank" href="http://www.interjoomla.com.ar/">InterJoomla</a></font>
                     </div>
                  </div>
                  <div align="center" width="100%" style="margin-top:25px;border:1px solid #c3c3c3;">
                     <div style="border:1px solid #c3c3c3;" align="center" width="100%">
                        Support InterJoomla`s Work!
                     </div>
                     <div style="border:1px solid #c3c3c3;padding-top:10px;padding-bottom:10px;" align="center" width="100%">
                        <div align="center" width="100%">
                           <a href="javascript:void(0);" onclick="window.open(\'https://www.e-gold.com/sci_asp/payments.asp?PAYEE_ACCOUNT=5006214&PAYEE_NAME=InterJoomla&PAYMENT_AMOUNT=0&PAYMENT_UNITS=0&PAYMENT_METAL_ID=0&STATUS_URL=AUTO&NOPAYMENT_URL=http%3A%2F%2Fwww%2Ee%2Dgold%2Ecom&NOPAYMENT_URL_METHOD=LINK&PAYMENT_URL=http%3A%2F%2Fwww%2Ee%2Dgold%2Ecom&PAYMENT_URL_METHOD=LINK&BAGGAGE_FIELDS=\',\'Donation for InterJoomla\',\'width=800,height=600,toolbar=yes,location=yes,status=yes,menubar=yes,resizable=yes,scrollbars=yes,directories=no\');">
                              <img style="margin-bottom:15px;" border="0" src="'.AFPATH_WEB_IMG_ADM_SITE.'egold.gif" alt="Donate with eGold!" title="" />
                           </a>
                        </div>
                        <div align="center" width="100%" style="margin-bottom:15px;" >
                           <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                           <input type="hidden" name="cmd" value="_s-xclick">
                           <input type="image" src="'.AFPATH_WEB_IMG_ADM_SITE.'paypal.gif" border="0" name="submit" alt="Donate with Paypal!">
                           <img alt="" border="0" src="https://www.paypal.com/es_XC/i/scr/pixel.gif" width="1" height="1">
                           <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHTwYJKoZIhvcNAQcEoIIHQDCCBzwCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYCcIVnN201fI6Q4bnpMNurroIsWPq2I3lEixFCubLigeJDB8q3ABVENpsYUtYLk9Y8IVZFpMtr0JJswQ9gRdmqbnL/mbGhb+tATibhpe34Ts4YNtZVZMID6cCQIQXvt6LnY3YKeEDN0OUeuWyuZaCubHXCrQXTjNHGlEEMZXCBqiTELMAkGBSsOAwIaBQAwgcwGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIrMaFoS2ufLSAgagxXtVGXLmPx0AHzDzRRSPC5rS9PmGFcRW0uetfecZdX3BjRJpC+QrJZmM8a02iL7F8QJqJimFjfYUilOX2M6t3HZFp3Ven1xnme531tEUovG2XpqN+mtTmkqCsIgL5ShqHBlQrgSsKdVeciYNEvJBmxmue90NA96/l9zSTeaRaIxDqxdmlDsd+TMUN9Jofw00O6fXfHDnrFNuFA7rPTOk6xSwUYmd8IBGgggOHMIIDgzCCAuygAwIBAgIBADANBgkqhkiG9w0BAQUFADCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wHhcNMDQwMjEzMTAxMzE1WhcNMzUwMjEzMTAxMzE1WjCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJAoGBAMFHTt38RMxLXJyO2SmS+Ndl72T7oKJ4u4uw+6awntALWh03PewmIJuzbALScsTS4sZoS1fKciBGoh11gIfHzylvkdNe/hJl66/RGqrj5rFb08sAABNTzDTiqqNpJeBsYs/c2aiGozptX2RlnBktH+SUNpAajW724Nv2Wvhif6sFAgMBAAGjge4wgeswHQYDVR0OBBYEFJaffLvGbxe9WT9S1wob7BDWZJRrMIG7BgNVHSMEgbMwgbCAFJaffLvGbxe9WT9S1wob7BDWZJRroYGUpIGRMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbYIBADAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4GBAIFfOlaagFrl71+jq6OKidbWFSE+Q4FqROvdgIONth+8kSK//Y/4ihuE4Ymvzn5ceE3S/iBSQQMjyvb+s2TWbQYDwcp129OPIbD9epdr4tJOUNiSojw7BHwYRiPh58S1xGlFgHFXwrEBb3dgNbMUa+u4qectsMAXpVHnD9wIyfmHMYIBmjCCAZYCAQEwgZQwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tAgEAMAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0wNzEyMTYxOTIwMTdaMCMGCSqGSIb3DQEJBDEWBBQj8ru/cujsnQ/TvJ5xwGRbHOzqPDANBgkqhkiG9w0BAQEFAASBgJcZb74SZChlIs2p4fHhMlijjCUSwRfomgvqPFUYjlqiDyTgUTlrjVUjMMAPW2aCLuIZUsXRh6G2Y0WO+GLD5FG32sAhlFMpM1qch1iQl89B+BMCnoiw1f9Ldr4M6CysFXbtmCJXP88W0NbNEXrl9D7u7h5tbXGliGqPte9lGuCA-----END PKCS7-----
">                         </form>
                        </div>
                        <div align="center" width="100%">
                           <a href="javascript:void(0);" onclick="window.open(\'https://www.dineromail.com/Carrito/cart.asp?NombreItem=Donar+a+InterJoomla&TipoMoneda=1&PrecioItem=5%2E00&NroItem=%2D&image_url=https%3A%2F%2F&DireccionExito=http%3A%2F%2F&DireccionFracaso=http%3A%2F%2F&DireccionEnvio=0&Mensaje=1&MediosPago=4%2C5%2C6%2C14%2C15%2C16%2C17%2C2%2C7%2C13&Comercio=579650\',\'Donación para InterJoomla - Pesos Argentinos\',\'width=800,height=400,toolbar=yes,location=yes,status=yes,menubar=yes,resizable=yes,scrollbars=yes,directories=no\');">
                              <img style="margin-bottom:15px;" border="0" src="'.AFPATH_WEB_IMG_ADM_SITE.'dineromail.png" alt="Donate with DineroMail!" title="" />
                           </a>
                        </div>
                        <div align="center" width="100%">
                           <a href="javascript:void(0);" onclick="window.open(\'https://www.dineromail.com/Carrito/cart.asp?NombreItem=Donar+a+InterJoomla&TipoMoneda=2&PrecioItem=5%2E00&NroItem=%2D&image_url=https%3A%2F%2F&DireccionExito=http%3A%2F%2F&DireccionFracaso=http%3A%2F%2F&DireccionEnvio=0&Mensaje=1&MediosPago=4%2C5%2C6%2C14%2C15%2C16%2C17%2C2%2C7%2C13&Comercio=579650\',\'Donación para InterJoomla - Dólares Estadounidenses\',\'width=800,height=400,toolbar=yes,location=yes,status=yes,menubar=yes,resizable=yes,scrollbars=yes,directories=no\');">
                              <img border="0" src="'.AFPATH_WEB_IMG_ADM_SITE.'dineromail2.png" alt="Donate with DineroMail!" title="" />
                           </a>
                        </div>
                     </div>
                  </div>
               </td>
               <td>
                  <div align="left">
                  <strong>'.JText::_( 'ARTF_CRED_ABOUT' ).'</strong>
                  <p>
                  <strong>'.JText::_( 'ARTF_CRED_NAME' ).': <img style="margin-bottom:-4px;" border="0" src="'.AFPATH_WEB_IMG_ADM_SITE.'minilogo.png" alt="ArtForms" title="ArtForms" /></strong><br />
                  <strong>'.JText::_( 'ARTF_CRED_VER' ).': '.afVersion().'</strong><br />
                  <strong>'.JText::_( 'ARTF_CRED_LASTVER' ).': ';

                  if(!$rdf->displayRDF(basename($url), false, 1, ''))echo 'N/A';

                  echo '</strong><br />
                  <strong>JoomlaCode: <a target="_blank" href="http://joomlacode.org/gf/project/jartforms/">ArtForms</a></strong><br />
                  <strong>Joomla! Extensions Directory: <a target="_blank" href="http://extensions.joomla.org/component/option,com_mtree/task,viewlink/link_id,3028/Itemid,35/">ArtForms</a></strong><br />
                  <strong>'.JText::_( 'ARTF_CRED_WEB' ).': <a target="_blank" href="http://jartforms.interjoomla.com.ar/">ArtForms</a></strong><br /><br />
                  <strong>'.JText::_( 'ARTF_CRED_OLDDEV' ).': <a target="_blank" href="http://Joomla-Radio.de/">Andreas Duswald</a></strong><br />
                  '.JText::_( 'ARTF_CRED_WEB' ).': <a target="_blank" href="http://Joomla-Radio.de/">http://Joomla-Radio.de/</a><br />
                  '.JText::_( 'ARTF_CRED_WEB' ).': <a target="_blank" href="http://www.duswald.de/">http://www.duswald.de/</a><br /><br />
                  <strong>'.JText::_( 'ARTF_CRED_BYNEW21B' ).':<br /><a target="_blank" href="http://joomlacode.org/gf/user/gonzalom/">Gonzalo M.</a> '.JText::_( 'ARTF_CRED_FOR' ).' <a target="_blank" href="http://www.interjoomla.com.ar/">InterJoomla</a></strong><br />
                  '.JText::_( 'ARTF_CRED_EMAIL' ).': <a href="mailto:interjoomla'.$spamfix.'gmail.com">InterJoomla'.$spamfix.'GMail.com</a><br /><br />

                  <strong>'.JText::_( 'ARTF_CRED_THKSTO' ).':</strong><br /><br />
                  '.'    <strong>'.JText::_( 'ARTF_CRED_BETATESTERS' ).':</strong><br />
                  '.'    '.JText::_( 'ARTF_CRED_NAME' ).': <a target="_blank" href="http://joomlacode.org/gf/user/aravot/">Peter Osipof</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:aravot'.$spamfix.'gmail.com">aravot'.$spamfix.'gmail.com</a><br />
                  '.'    '.JText::_( 'ARTF_CRED_NAME' ).': <a target="_blank" href="http://joomlacode.org/gf/user/mark.s/">Mark Staghouwer</a><br />
                  '.'    '.JText::_( 'ARTF_CRED_NAME' ).': <a target="_blank" href="http://joomlacode.org/gf/user/mturgutalp/">Mustafa Turgutalp</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:mustafaturgutalp'.$spamfix.'gmail.com">mustafaturgutalp'.$spamfix.'gmail.com</a><br />
                  <br />
                  '.'    <strong>'.JText::_( 'ARTF_CRED_TRANSLATORS' ).':</strong><br />
                  '.'    '.afShowFlagsInInfo( 'br' ).'<strong>Brazilian:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/saulolima/">Saulo Lima</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:saulo'.$spamfix.'detran.pe.gov.br">saulo'.$spamfix.'detran.pe.gov.br</a><br />
                  '.'    '.afShowFlagsInInfo( 'nl' ).'<strong>Dutch:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/petjez/">Patrick Zonneveld</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:fujigas'.$spamfix.'hotmail.com">fujigas'.$spamfix.'hotmail.com</a><br />
                  '.'    '.afShowFlagsInInfo( 'en' ).'<strong>English:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/gonzalom/">Gonzalo M.</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a href="mailto:interjoomla'.$spamfix.'gmail.com">InterJoomla'.$spamfix.'GMail.com</a><br />
                  '.'    '.afShowFlagsInInfo( 'fr' ).'<strong>French:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/daneel/">Daneel</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:daneel.joomla'.$spamfix.'gmail.com">daneel.joomla'.$spamfix.'gmail.com</a><br />
                  '.'    '.afShowFlagsInInfo( 'de' ).'<strong>German:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="javascript:void(0);">Wolfgang Heinemann</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:info'.$spamfix.'praxis-heinemann.com">info'.$spamfix.'praxis-heinemann.com</a><br />
                  '.'    '.afShowFlagsInInfo( 'hu' ).'<strong>Hungarian:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/zvaranka/">Zoltan Varanka</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:zvaranka'.$spamfix.'freemail.hu">zvaranka'.$spamfix.'freemail.hu</a><br />
                  '.'    '.afShowFlagsInInfo( 'it' ).'<strong>Italian:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/teddy/">Mittelcom</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:mittelcom'.$spamfix.'gmail.com">mittelcom'.$spamfix.'gmail.com</a><br />
                  '.'    '.afShowFlagsInInfo( 'pl' ).'<strong>Polish:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/zwiastun/">Stefan Wajda</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:zwiastun'.$spamfix.'zwiastun.net">zwiastun'.$spamfix.'zwiastun.net</a><br />
                  '.'    '.afShowFlagsInInfo( 'es' ).'<strong>Spanish:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/gonzalom/">Gonzalo M.</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a href="mailto:interjoomla'.$spamfix.'gmail.com">InterJoomla'.$spamfix.'GMail.com</a><br />
                  '.'    '.afShowFlagsInInfo( 'tr' ).'<strong>Turkish:</strong> '.JText::_( 'ARTF_CRED_NAME' ).':  <a target="_blank" href="http://joomlacode.org/gf/user/mturgutalp/">Mustafa Turgutalp</a> - '.JText::_( 'ARTF_CRED_EMAIL' ).': <a target="_blank" href="mailto:mustafaturgutalp'.$spamfix.'gmail.com">mustafaturgutalp'.$spamfix.'gmail.com</a><br />
                  <br />
                  </p>
                  </div>
               </td>
	    </tr>
	    </table>';


      echo $pane->endPanel();
      echo $pane->startPanel( JText::_( 'ARTF_CRED_TABB' ), 'info2' );

      afShowInfoDocs( JText::_( 'ARTF_CRED_TABB' ), 'license' );

      echo $pane->endPanel();
      echo $pane->startPanel( JText::_( 'ARTF_CRED_TABC' ), 'info3' );

      afShowInfoDocs( JText::_( 'ARTF_CRED_TABC' ), 'copyright' );

      echo $pane->endPanel();
      echo $pane->startPanel( JText::_( 'ARTF_CRED_TABD' ), 'info4' );

      afShowInfoDocs( JText::_( 'ARTF_CRED_TABD' ), 'readme' );

      echo $pane->endPanel();
      echo $pane->startPanel( JText::_( 'ARTF_CRED_TABE' ), 'info5' );

      afShowInfoDocs( JText::_( 'ARTF_CRED_TABE' ), 'changelog' );

      echo $pane->endPanel();
      echo $pane->endPane();

      echo afFooter(0);
   
   }
	
}
?>

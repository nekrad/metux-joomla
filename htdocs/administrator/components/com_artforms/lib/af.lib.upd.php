<?php
/**
* @version $Id: af.lib.upd.php v.2.1b7 2007-12-16 16:44:59Z GMT-3 $
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

      
function afCopyImgTmp( $image ) {
   
   global $mosConfig_absolute_path;

   copy( AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.$image, AFPATH_ASTERISKS_SITE.$image );

}


function afDelImgTmp( $image ) {

   global $mosConfig_absolute_path;

   unlink( AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.$image );

}


function afDelDirTmp( $dir ) {

   global $mosConfig_absolute_path;
   rmdir( AFPATH_ASSETS_SITE.'images'.DS.$dir.DS );

}


function afJoomFish() {

   if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'config.joomfish.php') && file_exists(AFPATH_ASSETS_SITE.'joomfish'.DS.'artforms.artforms.xml')){

      $checker = '';
      if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'artforms.artforms.xml'))unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'artforms.artforms.xml' );
      if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'artforms.items.xml'))unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'artforms.items.xml' );

      if(!@rename( AFPATH_ASSETS_SITE.'joomfish'.DS.'artforms.artforms.xml', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'artforms.artforms.xml' ))$checker = 'error';
      if(!@rename( AFPATH_ASSETS_SITE.'joomfish'.DS.'artforms.items.xml', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'artforms.items.xml' ))$checker = 'error';
      @unlink( AFPATH_ASSETS_SITE.'joomfish'.DS.'index.html' );
      @rmdir( AFPATH_ASSETS_SITE.'joomfish'.DS );

      if( $checker == 'error' ){
         $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDERROR' ).' :: JoomFish Support"><font color=red><strong>'.JText::_( 'ARTF_UPD_UPDERROR' ).'</strong></font></span>';
      } else {
         $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDSUCESS' ).' :: JoomFish Support"><font color=green><strong>'.JText::_( 'ARTF_UPD_UPDSUCESS' ).'</strong></font></span>';
      }

   } else {

      @unlink( AFPATH_ASSETS_SITE.'joomfish'.DS.'artforms.artforms.xml' );
      @unlink( AFPATH_ASSETS_SITE.'joomfish'.DS.'artforms.items.xml' );
      @unlink( AFPATH_ASSETS_SITE.'joomfish'.DS.'index.html' );
      @rmdir ( AFPATH_ASSETS_SITE.'joomfish'.DS.'joomfish'.DS );

      $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: JoomFish Support"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';

   }
   
   return $updmsg;
   
}


function afSEFsh404SEF() {

   if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'shCache.php') && file_exists(AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'com_artforms.php')){

      $checker = '';
      if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'sef_ext'.DS.'com_artforms.php'))unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'sef_ext'.DS.'com_artforms.php' );
      if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'language'.DS.'plugins'.DS.'com_artforms.php'))unlink( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'language'.DS.'plugins'.DS.'com_artforms.php' );

      if(!@rename( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'com_artforms.php', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'sef_ext'.DS.'com_artforms.php' ))$checker = 'error';
      if(!@rename( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'com_artforms.lang.php', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_sef'.DS.'language'.DS.'plugins'.DS.'com_artforms.php' ))$checker = 'error';
      @unlink( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'index.html' );
      @rmdir( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS);

      if( $checker == 'error' ){
         $updmsg = '<span class="MTTips" title="'.ARTF_UPD_UPDERROR.' :: sh404SEF Support"><font color=red><strong>'.ARTF_UPD_SQLERROR.'</strong></font></span>';
      } else {
         $updmsg = '<span class="MTTips" title="'.ARTF_UPD_UPDSUCESS.' :: sh404SEF Support"><font color=green><strong>'.ARTF_UPD_SQLSUCESS.'</strong></font></span>';
      }

   } else {

      @unlink( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'com_artforms.php' );
      @unlink( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'sh404sef/com_artforms.lang.php' );
      @unlink( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS.'index.html' );
      @rmdir ( AFPATH_ASSETS_SITE.'sef'.DS.'sh404sef'.DS );

      $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: sh404SEF Support"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';

   }

   return $updmsg;

}


function afUpdMLangEnt( $shorticon = 0 ) {

   global $mosConfig_live_site;

      if( $shorticon == 1 ){
         $fix=' width="12" height="12"';
      } else {
         $fix='';
         echo JText::_( 'ARTF_UPD_LINKSFIX' ).'<br />';
      }
      
      $db =& JFactory::getDBO();
      
      # Set up new icons for admin menu
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_FORMS' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_FORMS' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/forms16.png' WHERE admin_menu_link='option=com_artforms&task=showaf'");
      $iconresult[0] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_RFORMS' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_RFORMS' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/rforms16.png' WHERE admin_menu_link='option=com_artforms&task=rforms'");
      $iconresult[1] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_HELP' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_HELP' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/help16.png' WHERE admin_menu_link='option=com_artforms&task=help'");
      $iconresult[2] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_LANG' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_LANG' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/lang16.png' WHERE admin_menu_link='option=com_artforms&task=language'");
      $iconresult[3] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_CSS' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_CSS' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/css16.png' WHERE admin_menu_link='option=com_artforms&task=cssedit'");
      $iconresult[4] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_CONFIG' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_CONFIG' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/config16.png' WHERE admin_menu_link='option=com_artforms&task=config'");
      $iconresult[5] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_UPDATE' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_UPDATE' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/update16.png' WHERE admin_menu_link='option=com_artforms&task=update'");
      $iconresult[6] = $db->query();
      $db->setQuery("UPDATE #__components SET `name` = '".JText::_( 'ARTF_MENU_INFO' )."', `admin_menu_alt` = '".JText::_( 'ARTF_MENU_INFO' )."', admin_menu_img='../administrator/components/com_artforms/assets/images/info16.png' WHERE admin_menu_link='option=com_artforms&task=info'");
      $iconresult[7] = $db->query();
      $db->setQuery("UPDATE #__components SET admin_menu_img='../administrator/components/com_artforms/assets/images/iconlogo.png' WHERE admin_menu_link='option=com_artforms'");
      $iconresult[8] = $db->query();

      foreach ($iconresult as $i=>$icresult) {
         if ($icresult) {
            echo ' '.$i.' <img alt="OK" src="'.AFPATH_WEB_IMG_ADM_SITE.'success.png"'.$fix.'>';
         } else {
            echo ' '.$i.' <img alt="Error!" src="'.AFPATH_WEB_IMG_ADM_SITE.'admerror.png"'.$fix.'>';
         }
      }
      
}


function afUpdBnt( $option, $dotask, $text, $task='update', $btntxtchk='' ) {

   if($btntxtchk==''){$btntxt = JText::_( 'ARTF_UPD_UPDATE' );}else{ $btntxt = $btntxtchk;}
   ?>
   <div class="updbtn">
         <p><img src="<?php echo JURI::base().'images/';?>install.png" /></p>
         <form action="index.php" method="get" name="adminForm">
            <input type="hidden" name="option" value="<?php echo $option;?>">
            <input type="hidden" name="task" value="<?php echo $task;?>">
            <input type="hidden" name="dotask" value="<?php echo $dotask;?>">
            <input type="submit" value="<?php echo $btntxt;?>" class="button" style="width:130px;">
         </form>
         <p><?php echo $text;?></p>
   </div>
   <?php
}


function afLoadAFUpdate( $upd, $updversion ) {

   afLoadAFUpdAjax( $upd, $updversion );
   afLoadAFUpdHTML( $upd );

}


function afLoadAFUpdAjax( $upd, $updversion ) {

   global $mainframe;
   $html = "<script type=\"text/javascript\">
                var load_method = (window.ie ? 'load' : 'domready');
   		window.addEvent(load_method, function(){
      var url = '".JURI::base()."index.php?option=com_artforms&task=update&dotask=".$updversion."&no_html=1&no_afhtml=1&antiCache=' + \$random(100, 999) + '&dotaskupd=';
      var id = 0;
      var options = {
				method: 'get',
				onRequest: function(){
					this.options.reqState
						.addClass('ajax-loading')
						.setHTML('".JText::_( 'ARTF_UPD_UPDREQUEST' )."');
				},
                                onComplete: function(resp){
                                        this.options.reqState
						.removeClass('ajax-loading')
                                                .setHTML(resp);

                                }

			};
      var xhrs = [];
      var group = [];
      for( i=1;i<".$upd.";i++) {
        xhrs[i] = new Ajax(url+i, \$merge({reqState: $('req-state-' + (++id))}, options));
        var group = new Group(xhrs[i]);
      };

			group
				.addEvent('onRequest', function() {
					$('req-state-all')
						.addClass('ajax-loading')
						.setHTML('<strong>".JText::_( 'ARTF_UPD_ALLUPDSTART' )."</strong>');
				})
				.addEvent('onComplete', function() {
					$('req-state-all')
						.removeClass('ajax-loading')
						.setHTML('<strong style=\"color:green;\">".JText::_( 'ARTF_UPD_ALLUPDFINISHED' )."</strong>');
                                                new Tips($$('.MTTips'), {
				                       initialize:function(){
				                    	   this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
				                       },
                                                       className: 'custom',
				                       onShow: function(toolTip) {
				                     	   this.fx.start(1);
			                       	       },
				                       onHide: function(toolTip) {
				                	   this.fx.start(0);
				                       }
			                        });
                                });
			$('req-start').addEvent('click', function(e) {
                                new Event(e).stop();
                                for( i=1;i<".$upd.";i++) {
                                xhrs[i].request();
                                };

			});

		});
	</script>";
   $mainframe->addCustomHeadTag( $html );

}


function afLoadAFUpdHTML( $upd ) {

?>
<div id="upd-container">
   <a id="req-start" class="afbutton" href="javascript:void(0);"><?php echo JText::_( 'ARTF_UPD_UPDSTART' );?></a>
   <dl id="req-states">
   <?php
   for( $i=1;$i<$upd;$i++ ){
   ?>
	<dt><?php echo JText::_( 'ARTF_UPD_UPD' ).' #'.$i;?>:</dt>
	<dd id="req-state-<?php echo $i;?>">-</dd>
   <?php
   }
   ?>
	<dt><strong><?php echo JText::_( 'ARTF_UPD_UPDPROGRESS' );?>:</strong></dt>
	<dd id="req-state-all">-</dd>
   </dl>
</div>
<div class="clear"></div>
<?php

}


function afUpd21b5() {

   $db =& JFactory::getDBO();
   
   $dotaskupd = $_GET['dotaskupd'];
   switch ( $dotaskupd ) {
              case '1':
                $test = "SELECT `seccode` FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE `#__artforms` ADD `seccode` VARCHAR( 2 ) DEFAULT '0' NOT NULL AFTER `html` ";
                if (!$db->query()){

		     $db->setQuery($upgrade);
		       if(!$db->query()){
			   //Upgrade failed
			   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		           return;
		       }else{
		           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		       }
		} else {
                   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
                }
                echo $updmsg;
              break;

              case '2':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms_items CHANGE `name` `name` TEXT NOT NULL";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '3':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms_items CHANGE `values` `values` TEXT DEFAULT '' NOT NULL";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
		   
              break;

              case '4':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms CHANGE `allowattfiles` `allowattfiles` MEDIUMTEXT NOT NULL";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

               case '5':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "UPDATE #__components SET `admin_menu_link` = 'option=com_artforms&task=info' WHERE admin_menu_link='option=com_artforms&act=info';";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
               break;

               case '6':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "UPDATE #__components SET `ordering` = '8' WHERE admin_menu_link='option=com_artforms&task=info';";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
               break;

               case '7':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "UPDATE #__components SET `admin_menu_link` = 'option=com_artforms&task=showaf' WHERE admin_menu_link='option=com_artforms&act=all';";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
               break;

              case '8':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                if(!$db->query()){
                  $test2 = "SELECT `admin_menu_link` FROM #__components WHERE `admin_menu_link` = 'option=com_artforms&task=update'";
		  $db->setQuery($test2);
                  $testcomp = $db->loadResult();

                  if (!$testcomp == 'option=com_artforms&task=update'){

                   $db->setQuery( "SELECT id FROM `#__components` WHERE `option` = 'com_artforms' AND `link` = 'option=com_artforms';");
	           $parentcomp = $db->loadResult();

                   $upgrade1 = "INSERT INTO `#__components` (`name`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`) VALUES ('".ARTF_MENU_CONFIG."', '".$parentcomp."', 'option=com_artforms&task=config', '".ARTF_MENU_CONFIG."', 'com_artforms', '6', '../administrator/components/com_artforms/images/config16.png');";
		   $db->setQuery($upgrade1);
                   $db->query();
                   
                   $upgrade2 = "INSERT INTO `#__components` (`name`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`) VALUES ('".ARTF_MENU_UPDATE."', '".$parentcomp."', 'option=com_artforms&task=update', '".ARTF_MENU_UPDATE."', 'com_artforms', '7', '../administrator/components/com_artforms/images/update16.png');";
		   $db->setQuery($upgrade2);
		      if(!$db->query()){
		      //Upgrade failed
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		          return;
		      }else{
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade1.'<br />'.$upgrade2.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		      }

                  } else {

                   $upgrade3 = "UPDATE #__components SET `ordering` = '6' WHERE admin_menu_link='option=com_artforms&task=config';";
                   $db->setQuery($upgrade3);

		   $upgrade4 = "UPDATE #__components SET `ordering` = '7' WHERE admin_menu_link='option=com_artforms&task=update';";
		   $db->setQuery($upgrade4);
		      if(!$db->query()){
		      //Upgrade failed
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		          return;
		      }else{
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade3.'<br />'.$upgrade4.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		      }

                  }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: ArtForms Menu"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
                echo $updmsg;
              break;

              case '9':
                $test3 = "SELECT `admin_menu_link` FROM #__components WHERE `admin_menu_link` = 'option=com_artforms&task=rforms'";
		$db->setQuery($test3);
                $testcomp = $db->loadResult();
                
                if (!$testcomp == 'option=com_artforms&task=rforms'){
                   $db->setQuery( "SELECT id FROM `#__components` WHERE `option` = 'com_artforms' AND `link` = 'option=com_artforms';");
	           $parentcomp = $db->loadResult();

		   $upgrade1 = "INSERT INTO `#__components` (`name`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`) VALUES ('".ARTF_MENU_RFORMS."', '".$parentcomp."', 'option=com_artforms&task=rforms', '".ARTF_MENU_RFORMS."', 'com_artforms', '2', '../administrator/components/com_artforms/images/rforms16.png');";
		   $db->setQuery($upgrade1);
		      if(!$db->query()){
		      //Upgrade failed
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		          return;
		      }else{
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade1.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		      }

		   $upgrade2 = "INSERT INTO `#__components` (`name`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`) VALUES ('".ARTF_MENU_CSS."', '".$parentcomp."', 'option=com_artforms&task=cssedit', '".ARTF_MENU_CSS."', 'com_artforms', '5', '../administrator/components/com_artforms/images/css16.png');";
		   $db->setQuery($upgrade2);
		      if(!$db->query()){
		      //Upgrade failed
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		          return;
		      }else{
                          $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade2.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		      }

		   $upgrade3 = "UPDATE #__components SET `ordering` = '4' WHERE admin_menu_link='option=com_artforms&task=language';";
		   $db->setQuery($upgrade3);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade3.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }

		   $upgrade4 = "UPDATE #__components SET `ordering` = '3' WHERE admin_menu_link='option=com_artforms&task=help';";
		   $db->setQuery($upgrade4);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade4.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }

                } else {
                   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: ArtForms Menu"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
                }
                echo $updmsg;
              break;

              case '10':
                $test4 = "SELECT `secbot` FROM #__artforms";
		$db->setQuery($test4);
                $upgrade = "ALTER TABLE `#__artforms` DROP `secbot`";
                if ($db->query()){
		     $db->setQuery($upgrade);
		       if(!$db->query()){
			   //Upgrade failed
                           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		           return;
		       }else{
                           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		       }
		} else {
                   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
                }
                echo $updmsg;
              break;

              case '11':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms CHANGE `emailfield` `emailfield` VARCHAR( 2 ) DEFAULT '0' NOT NULL";
                if(!$db->query()){
		  $db->setQuery($upgrade);
		  if(!$db->query()){
		    //Upgrade failed
                    $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		    return;
		  }else{
                    $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                  }
                } else {
                   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
                }
                echo $updmsg;
              break;

              case '12':
                $test5 = "SELECT * FROM #__artforms_inbox";
		$db->setQuery($test5);
		$upgrade = "CREATE TABLE #__artforms_inbox ( `id` INT NOT NULL AUTO_INCREMENT, `title` VARCHAR(255) NOT NULL, `form_id` INT NOT NULL, `item_name` VARCHAR(255) NOT NULL, `item_data` TEXT NOT NULL, `form_date` VARCHAR(45) NOT NULL, PRIMARY KEY (`id`) )";
		if (!$db->query()){
		     $db->setQuery($upgrade);
		       if(!$db->query()){
			   //Upgrade failed
                           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		           return;
		       }else{
                           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		       }
		} else {
                   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
                }
                echo $updmsg;
              break;

   case '13':
     $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
     $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
     $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
     if(!file_exists(AFPATH_ASTERISKS_SITE.'ast01.png') && file_exists(AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.'ast01.png')) {
        $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
	if (@mkdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766) || is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS)) {
    	   @chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766);
	   $cdirtask1 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';

	   $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
	   if (@mkdir (AFPATH_ATTACHS_SITE, 0766) || is_dir(AFPATH_ATTACHS_SITE)) {
    	      @chmod (AFPATH_ATTACHS_SITE, 0766);
    	      $cdirtask2 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask2 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ATTACHS_SITE.'</strong></font>';
	   }

	   $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
	   if (@mkdir (AFPATH_ASTERISKS_SITE, 0766) || is_dir(AFPATH_ASTERISKS_SITE)) {
    	      @chmod (AFPATH_ASTERISKS_SITE, 0766);
    	      $cdirtask3 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask3 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ASTERISKS_SITE.'</strong></font>';
	   }

	   afCopyImgTmp( 'ast01.png' );
           afCopyImgTmp( 'ast02.png' );
           afCopyImgTmp( 'ast03.png' );
           afCopyImgTmp( 'ast04.png' );
           afCopyImgTmp( 'ast05.png' );
           afCopyImgTmp( 'ast06.png' );
           afCopyImgTmp( 'ast07.png' );
           afCopyImgTmp( 'ast08.png' );
           afCopyImgTmp( 'ast09.png' );
           afCopyImgTmp( 'ast10.png' );
           afCopyImgTmp( 'ast11.png' );
           afCopyImgTmp( 'ast12.png' );
           afCopyImgTmp( 'ast13.png' );
           afCopyImgTmp( 'ast14.png' );
           afCopyImgTmp( 'ast15.png' );
           afCopyImgTmp( 'ast16.png' );
           afCopyImgTmp( 'ast17.png' );
           afCopyImgTmp( 'ast18.png' );
           afCopyImgTmp( 'ast19.png' );
           afCopyImgTmp( 'ast20.png' );
           afCopyImgTmp( 'ast21.png' );
           afCopyImgTmp( 'ast22.png' );
           afCopyImgTmp( 'ast23.png' );
           afCopyImgTmp( 'ast24.png' );
           afCopyImgTmp( 'ast25.png' );
           afCopyImgTmp( 'ast26.png' );
           afCopyImgTmp( 'ast27.png' );
           afCopyImgTmp( 'ast28.png' );

           afDelImgTmp( 'ast01.png' );
           afDelImgTmp( 'ast02.png' );
           afDelImgTmp( 'ast03.png' );
           afDelImgTmp( 'ast04.png' );
           afDelImgTmp( 'ast05.png' );
           afDelImgTmp( 'ast06.png' );
           afDelImgTmp( 'ast07.png' );
           afDelImgTmp( 'ast08.png' );
           afDelImgTmp( 'ast09.png' );
           afDelImgTmp( 'ast10.png' );
           afDelImgTmp( 'ast11.png' );
           afDelImgTmp( 'ast12.png' );
           afDelImgTmp( 'ast13.png' );
           afDelImgTmp( 'ast14.png' );
           afDelImgTmp( 'ast15.png' );
           afDelImgTmp( 'ast16.png' );
           afDelImgTmp( 'ast17.png' );
           afDelImgTmp( 'ast18.png' );
           afDelImgTmp( 'ast19.png' );
           afDelImgTmp( 'ast20.png' );
           afDelImgTmp( 'ast21.png' );
           afDelImgTmp( 'ast22.png' );
           afDelImgTmp( 'ast23.png' );
           afDelImgTmp( 'ast24.png' );
           afDelImgTmp( 'ast25.png' );
           afDelImgTmp( 'ast26.png' );
           afDelImgTmp( 'ast27.png' );
           afDelImgTmp( 'ast28.png' );
           afDelDirTmp( 'temp');
           chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0755);
           chmod (AFPATH_ASTERISKS_SITE, 0755);
           chmod (AFPATH_ATTACHS_SITE, 0755);

           $updmsg = '<span class="MTTips" title="ArtForms :: '.$cdir1.$cdirtask1.'<br />'.$cdir2.$cdirtask2.'<br />'.$cdir3.$cdirtask3.'">
                      <font color=green><strong>'.JText::_( 'ARTF_UPD_UPDASTIMGSUCC' ).'</strong></font></span>';
        }
     } else {
        $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$cdir1.'<br />'.$cdir2.'<br />'.$cdir3.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
     }
   echo $updmsg;
   break;

 case '14':
   afUpdMLangEnt( 1 );
 break;
 }
}


function afUpd21b6() {

   $db =& JFactory::getDBO();

   $dotaskupd = $_GET['dotaskupd'];
   switch ( $dotaskupd ) {
              case '1':
                $test = "SELECT metakey FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD metakey mediumtext NOT NULL AFTER danktext";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '2':
                $test = "SELECT metadesc FROM #__artforms";
		$db->setQuery($test);
		$upgrade = "ALTER TABLE #__artforms ADD metadesc text NOT NULL AFTER danktext";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '3':
                $test = "SELECT customcss FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD customcss text NOT NULL AFTER danktext";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '4':
                $test = "SELECT customjscode FROM #__artforms";
		$db->setQuery($test);
		$upgrade = "ALTER TABLE #__artforms ADD customjscode text NOT NULL AFTER danktext";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '5':
                $test = "SELECT version FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD version int(10) unsigned NOT NULL default '1'";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '6':
                $test = "SELECT hits FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD hits int(10) unsigned NOT NULL default '0'";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '7':
                $test = "SELECT author FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD author varchar(255) NOT NULL default '' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '8':
                $test = "SELECT created_by_alias FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD created_by_alias varchar(255) NOT NULL default '' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '9':
                $test = "SELECT modified_by FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD modified_by int(10) unsigned NOT NULL default '0' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '10':
                $test = "SELECT modified FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD modified datetime NOT NULL default '0000-00-00 00:00:00' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '11':
                $test = "SELECT publish_down FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD publish_down datetime NOT NULL default '0000-00-00 00:00:00' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '12':
                $test = "SELECT publish_up FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD publish_up datetime NOT NULL default '0000-00-00 00:00:00' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '13':
                $test = "SELECT ordering FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD ordering int(10) unsigned NOT NULL default '9999' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '14':
                $test = "SELECT access FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD access int(10) unsigned NOT NULL default '0' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '15':
                $test = "SELECT checked_out_time FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD checked_out_time datetime NOT NULL default '0000-00-00 00:00:00' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '16':
                $test = "SELECT checked_out FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD checked_out tinyint(1) unsigned NOT NULL default '0' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '17':
                $test = "SELECT created_by FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD created_by int(10) unsigned NOT NULL default '0' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '18':
                $test = "SELECT created FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD created datetime NOT NULL default '0000-00-00 00:00:00' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '19':
                $test = "SELECT item_name FROM #__artforms_inbox";
		$db->setQuery($test);
		$result = $db->query();
                $coltype = mysql_field_type( $result, 0 );
                $upgrade = "ALTER TABLE #__artforms_inbox CHANGE item_name item_name TEXT NOT NULL";
                if( $coltype != 'blob' ){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade2.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '20':
                $test = 'INSERT INTO #__artforms_items ( form_id, name, type ) VALUES ( 77, 77, 77 )';
                $db->setQuery($test);
                $db->query();
                
                $test2 = "SELECT type FROM #__artforms_items WHERE name = '77'";
		$db->setQuery($test2);
		$result = $db->loadRow();
                $result = $result[0];

                $upgrade = "ALTER TABLE #__artforms_items CHANGE type type VARCHAR(10) NOT NULL DEFAULT ''";
                if( $result != '77' ){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade2.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		$test3 = 'DELETE FROM #__artforms_items WHERE name=77';
                $db->setQuery($test3);
                $db->query();
		echo $updmsg;
              break;
              
              case '21':
                $test = 'INSERT INTO #__artforms_items ( form_id, name, type, required, validation ) VALUES ( 88, 88, 0, 0, 88 )';
                $db->setQuery($test);
                $db->query();

                $test2 = "SELECT validation FROM #__artforms_items WHERE name = '88'";
		$db->setQuery($test2);
		$resultb = $db->loadRow();
                $resultb = $resultb[0];

                $upgrade = "ALTER TABLE #__artforms_items CHANGE validation validation VARCHAR(10) NOT NULL DEFAULT '0'";
                if( $resultb != '88' ){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade2.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
                $test3 = 'DELETE FROM #__artforms_items WHERE name=88';
                $db->setQuery($test3);
                $db->query();
		echo $updmsg;
              break;
              
              case '22':
                $test = "SELECT default_values FROM #__artforms_items";
		$db->setQuery($test);
		$result = $db->query();
                $coltype = mysql_field_type( $result, 0 );

                $upgrade = "ALTER TABLE #__artforms_items CHANGE default_values default_values TEXT NOT NULL DEFAULT ''";
                if( $coltype != 'blob' ){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade2.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '23':
                $test = "SELECT item_ordering FROM #__artforms_items";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms_items ADD item_ordering tinyint(5) unsigned NOT NULL default '0'";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
             case '24':
                $test = "SELECT customcode FROM #__artforms_items";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms_items ADD customcode varchar(255) NOT NULL default ''";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
           case '25':
                $test = "SELECT readonly FROM #__artforms_items";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms_items ADD readonly char(1) NOT NULL default '0'";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
           case '26':
                $test = "SELECT selection FROM #__artforms_items";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms_items DROP `selection`";
                if($db->query()){
                   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '27':
                $test = "SELECT sorting FROM #__artforms_items";
		$db->setQuery($test);

                $upgrade = "ALTER TABLE #__artforms_items DROP `sorting`";
                if($db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade3.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
                   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;

              break;

              case '28':
                $test = "SELECT afeditor FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD afeditor VARCHAR(255) NOT NULL default '' AFTER seccode";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;

              case '29':
                $test = "SELECT params FROM #__components WHERE link = 'option=com_artforms' AND parent = '0'";
		$db->setQuery($test);
		$resultc = $db->loadRow();
                $resultc = $resultc[0];
                
                $upgrade = "UPDATE #__components SET `params` = 'rootfronttitle=ArtForms\nfronttext=Select a form' WHERE link = 'option=com_artforms' AND parent = '0'";
                if( !$resultc ){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '30':
                $test = "SELECT modifier FROM #__artforms";
		$db->setQuery($test);
                $upgrade = "ALTER TABLE #__artforms ADD modifier varchar(255) NOT NULL default '' AFTER published";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
              case '31':
                $test = "SELECT attribs FROM #__artforms";
		$db->setQuery($test);
		$upgrade = "ALTER TABLE #__artforms ADD attribs text NOT NULL AFTER danktext";
                if(!$db->query()){
		   $db->setQuery($upgrade);
		   if(!$db->query()){
		   //Upgrade failed
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
		       return;
		   }else{
                       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
		   }
		} else {
		   $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
		}
		echo $updmsg;
              break;
              
   case '32':
     $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
     $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
     $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
     if(!file_exists(AFPATH_ASTERISKS_SITE.'ast01.png') && file_exists(AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.'ast01.png')) {
        $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
	if (@mkdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766) || is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS)) {
    	   @chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766);
	   $cdirtask1 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';

	   $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
	   if (@mkdir (AFPATH_ATTACHS_SITE, 0766) || is_dir(AFPATH_ATTACHS_SITE)) {
    	      @chmod (AFPATH_ATTACHS_SITE, 0766);
    	      $cdirtask2 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask2 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ATTACHS_SITE.'</strong></font>';
	   }

	   $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
	   if (@mkdir (AFPATH_ASTERISKS_SITE, 0766) || is_dir(AFPATH_ASTERISKS_SITE)) {
    	      @chmod (AFPATH_ASTERISKS_SITE, 0766);
    	      $cdirtask3 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask3 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ASTERISKS_SITE.'</strong></font>';
	   }

	   afCopyImgTmp( 'ast01.png' );
           afCopyImgTmp( 'ast02.png' );
           afCopyImgTmp( 'ast03.png' );
           afCopyImgTmp( 'ast04.png' );
           afCopyImgTmp( 'ast05.png' );
           afCopyImgTmp( 'ast06.png' );
           afCopyImgTmp( 'ast07.png' );
           afCopyImgTmp( 'ast08.png' );
           afCopyImgTmp( 'ast09.png' );
           afCopyImgTmp( 'ast10.png' );
           afCopyImgTmp( 'ast11.png' );
           afCopyImgTmp( 'ast12.png' );
           afCopyImgTmp( 'ast13.png' );
           afCopyImgTmp( 'ast14.png' );
           afCopyImgTmp( 'ast15.png' );
           afCopyImgTmp( 'ast16.png' );
           afCopyImgTmp( 'ast17.png' );
           afCopyImgTmp( 'ast18.png' );
           afCopyImgTmp( 'ast19.png' );
           afCopyImgTmp( 'ast20.png' );
           afCopyImgTmp( 'ast21.png' );
           afCopyImgTmp( 'ast22.png' );
           afCopyImgTmp( 'ast23.png' );
           afCopyImgTmp( 'ast24.png' );
           afCopyImgTmp( 'ast25.png' );
           afCopyImgTmp( 'ast26.png' );
           afCopyImgTmp( 'ast27.png' );
           afCopyImgTmp( 'ast28.png' );

           afDelImgTmp( 'ast01.png' );
           afDelImgTmp( 'ast02.png' );
           afDelImgTmp( 'ast03.png' );
           afDelImgTmp( 'ast04.png' );
           afDelImgTmp( 'ast05.png' );
           afDelImgTmp( 'ast06.png' );
           afDelImgTmp( 'ast07.png' );
           afDelImgTmp( 'ast08.png' );
           afDelImgTmp( 'ast09.png' );
           afDelImgTmp( 'ast10.png' );
           afDelImgTmp( 'ast11.png' );
           afDelImgTmp( 'ast12.png' );
           afDelImgTmp( 'ast13.png' );
           afDelImgTmp( 'ast14.png' );
           afDelImgTmp( 'ast15.png' );
           afDelImgTmp( 'ast16.png' );
           afDelImgTmp( 'ast17.png' );
           afDelImgTmp( 'ast18.png' );
           afDelImgTmp( 'ast19.png' );
           afDelImgTmp( 'ast20.png' );
           afDelImgTmp( 'ast21.png' );
           afDelImgTmp( 'ast22.png' );
           afDelImgTmp( 'ast23.png' );
           afDelImgTmp( 'ast24.png' );
           afDelImgTmp( 'ast25.png' );
           afDelImgTmp( 'ast26.png' );
           afDelImgTmp( 'ast27.png' );
           afDelImgTmp( 'ast28.png' );
           afDelDirTmp( 'temp');
           chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0755);
           chmod (AFPATH_ASTERISKS_SITE, 0755);
           chmod (AFPATH_ATTACHS_SITE, 0755);
           
           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDASTIMGSUCC' ).' :: '.$cdir1.'  '.$cdirtask1.'<br />'.$cdir2.'  '.$cdirtask2.'<br />'.$cdir3.'  '.$cdirtask3.'">
                      <font color=green><strong>'.JText::_( 'ARTF_UPD_UPDASTIMGSUCC' ).'</strong></font></span>';
        }
     } else {
        $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$cdir1.'<br />'.$cdir2.'<br />'.$cdir3.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
     }
     if(file_exists(AFPATH_ASTERISKS_SITE.'ast01.png') && file_exists(AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.'ast01.png')) {
           afDelImgTmp( 'ast01.png' );
           afDelImgTmp( 'ast02.png' );
           afDelImgTmp( 'ast03.png' );
           afDelImgTmp( 'ast04.png' );
           afDelImgTmp( 'ast05.png' );
           afDelImgTmp( 'ast06.png' );
           afDelImgTmp( 'ast07.png' );
           afDelImgTmp( 'ast08.png' );
           afDelImgTmp( 'ast09.png' );
           afDelImgTmp( 'ast10.png' );
           afDelImgTmp( 'ast11.png' );
           afDelImgTmp( 'ast12.png' );
           afDelImgTmp( 'ast13.png' );
           afDelImgTmp( 'ast14.png' );
           afDelImgTmp( 'ast15.png' );
           afDelImgTmp( 'ast16.png' );
           afDelImgTmp( 'ast17.png' );
           afDelImgTmp( 'ast18.png' );
           afDelImgTmp( 'ast19.png' );
           afDelImgTmp( 'ast20.png' );
           afDelImgTmp( 'ast21.png' );
           afDelImgTmp( 'ast22.png' );
           afDelImgTmp( 'ast23.png' );
           afDelImgTmp( 'ast24.png' );
           afDelImgTmp( 'ast25.png' );
           afDelImgTmp( 'ast26.png' );
           afDelImgTmp( 'ast27.png' );
           afDelImgTmp( 'ast28.png' );
           afDelDirTmp( 'temp');
     }
   echo $updmsg;
   break;

 case '33':
    if( is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS) && is_dir(AFPATH_ASTERISKS_SITE) && is_dir(AFPATH_ATTACHS_SITE) ) {
       chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0755);
       chmod (AFPATH_ASTERISKS_SITE, 0755);
       chmod (AFPATH_ATTACHS_SITE, 0755);
       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_DIRCHMSUCC' ).' :: '.JPATH_SITE.DS.'images'.DS.'artforms'.DS.'<br />'.AFPATH_ASTERISKS_SITE.'<br />'.AFPATH_ATTACHS_SITE.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_DIRCHMSUCC' ).'</strong></font></span>';
    } else {
       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_DIRCHMERROR' ).' :: '.JPATH_SITE.DS.'images'.DS.'artforms'.DS.'<br />'.AFPATH_ASTERISKS_SITE.'<br />'.AFPATH_ATTACHS_SITE.'"><font color=red><strong>'.JText::_( 'ARTF_UPD_DIRCHMERROR' ).'</strong></font></span>';
    }
    echo $updmsg;
 break;
   
 case '34':
    afUpdMLangEnt( 1 );
 break;

 }
 
}


function afUpd21b7() {

   $db =& JFactory::getDBO();

   $dotaskupd = $_GET['dotaskupd'];
   switch ( $dotaskupd ) {
      case '1':
         $test = "SELECT layout FROM #__artforms_items";
         $db->setQuery($test);
         $upgrade = "ALTER TABLE #__artforms_items ADD layout TEXT NOT NULL DEFAULT ''";
         if(!$db->query()){
            $db->setQuery($upgrade);
            if(!$db->query()){
               //Upgrade failed
               $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLERROR' ).' :: '.$db->stderr(true).'"><font color=red><strong>'.JText::_( 'ARTF_UPD_SQLERROR' ).'</strong></font></span>';
               return;
            }else{
               $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_SQLSUCESS' ).' :: '.$upgrade.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_SQLSUCESS' ).'</strong></font></span>';
            }
         } else {
            $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$upgrade.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
         }
         echo $updmsg;
      break;

     case '2':
     $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
     $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
     $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
     if(!file_exists(AFPATH_ASTERISKS_SITE.'ast01.png') && file_exists(AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.'ast01.png')) {
        $cdir1 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms\'';
	if (@mkdir (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766) || is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS)) {
    	   @chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0766);
	   $cdirtask1 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';

	   $cdir2 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/attachedfiles\'';
	   if (@mkdir (AFPATH_ATTACHS_SITE, 0766) || is_dir(AFPATH_ATTACHS_SITE)) {
    	      @chmod (AFPATH_ATTACHS_SITE, 0766);
    	      $cdirtask2 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask2 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ATTACHS_SITE.'</strong></font>';
	   }

	   $cdir3 = JText::_( 'ARTF_INST_CREATEDIR' ).' \'images/artforms/asterisks\'';
	   if (@mkdir (AFPATH_ASTERISKS_SITE, 0766) || is_dir(AFPATH_ASTERISKS_SITE)) {
    	      @chmod (AFPATH_ASTERISKS_SITE, 0766);
    	      $cdirtask3 = '<font color=\'green\'>'.JText::_( 'ARTF_INST_CREATEDIRSUCC' ).'</font>';
	   } else {
	      $cdirtask3 = '<font color=\'red\'><strong>'.JText::_( 'ARTF_INST_CREATEDIRFAIL' ).': '.AFPATH_ASTERISKS_SITE.'</strong></font>';
	   }

	   afCopyImgTmp( 'ast01.png' );
           afCopyImgTmp( 'ast02.png' );
           afCopyImgTmp( 'ast03.png' );
           afCopyImgTmp( 'ast04.png' );
           afCopyImgTmp( 'ast05.png' );
           afCopyImgTmp( 'ast06.png' );
           afCopyImgTmp( 'ast07.png' );
           afCopyImgTmp( 'ast08.png' );
           afCopyImgTmp( 'ast09.png' );
           afCopyImgTmp( 'ast10.png' );
           afCopyImgTmp( 'ast11.png' );
           afCopyImgTmp( 'ast12.png' );
           afCopyImgTmp( 'ast13.png' );
           afCopyImgTmp( 'ast14.png' );
           afCopyImgTmp( 'ast15.png' );
           afCopyImgTmp( 'ast16.png' );
           afCopyImgTmp( 'ast17.png' );
           afCopyImgTmp( 'ast18.png' );
           afCopyImgTmp( 'ast19.png' );
           afCopyImgTmp( 'ast20.png' );
           afCopyImgTmp( 'ast21.png' );
           afCopyImgTmp( 'ast22.png' );
           afCopyImgTmp( 'ast23.png' );
           afCopyImgTmp( 'ast24.png' );
           afCopyImgTmp( 'ast25.png' );
           afCopyImgTmp( 'ast26.png' );
           afCopyImgTmp( 'ast27.png' );
           afCopyImgTmp( 'ast28.png' );

           afDelImgTmp( 'ast01.png' );
           afDelImgTmp( 'ast02.png' );
           afDelImgTmp( 'ast03.png' );
           afDelImgTmp( 'ast04.png' );
           afDelImgTmp( 'ast05.png' );
           afDelImgTmp( 'ast06.png' );
           afDelImgTmp( 'ast07.png' );
           afDelImgTmp( 'ast08.png' );
           afDelImgTmp( 'ast09.png' );
           afDelImgTmp( 'ast10.png' );
           afDelImgTmp( 'ast11.png' );
           afDelImgTmp( 'ast12.png' );
           afDelImgTmp( 'ast13.png' );
           afDelImgTmp( 'ast14.png' );
           afDelImgTmp( 'ast15.png' );
           afDelImgTmp( 'ast16.png' );
           afDelImgTmp( 'ast17.png' );
           afDelImgTmp( 'ast18.png' );
           afDelImgTmp( 'ast19.png' );
           afDelImgTmp( 'ast20.png' );
           afDelImgTmp( 'ast21.png' );
           afDelImgTmp( 'ast22.png' );
           afDelImgTmp( 'ast23.png' );
           afDelImgTmp( 'ast24.png' );
           afDelImgTmp( 'ast25.png' );
           afDelImgTmp( 'ast26.png' );
           afDelImgTmp( 'ast27.png' );
           afDelImgTmp( 'ast28.png' );
           afDelDirTmp( 'temp');
           chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0755);
           chmod (AFPATH_ASTERISKS_SITE, 0755);
           chmod (AFPATH_ATTACHS_SITE, 0755);

           $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDASTIMGSUCC' ).' :: '.$cdir1.'  '.$cdirtask1.'<br />'.$cdir2.'  '.$cdirtask2.'<br />'.$cdir3.'  '.$cdirtask3.'">
                      <font color=green><strong>'.JText::_( 'ARTF_UPD_UPDASTIMGSUCC' ).'</strong></font></span>';
        }
     } else {
        $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).' :: '.$cdir1.'<br />'.$cdir2.'<br />'.$cdir3.'"><font color=blue><strong>'.JText::_( 'ARTF_UPD_UPDNOTREQ' ).'</strong></font></span>';
     }
     if(file_exists(AFPATH_ASTERISKS_SITE.'ast01.png') && file_exists(AFPATH_ASSETS_SITE.'images'.DS.'temp'.DS.'ast01.png')) {
           afDelImgTmp( 'ast01.png' );
           afDelImgTmp( 'ast02.png' );
           afDelImgTmp( 'ast03.png' );
           afDelImgTmp( 'ast04.png' );
           afDelImgTmp( 'ast05.png' );
           afDelImgTmp( 'ast06.png' );
           afDelImgTmp( 'ast07.png' );
           afDelImgTmp( 'ast08.png' );
           afDelImgTmp( 'ast09.png' );
           afDelImgTmp( 'ast10.png' );
           afDelImgTmp( 'ast11.png' );
           afDelImgTmp( 'ast12.png' );
           afDelImgTmp( 'ast13.png' );
           afDelImgTmp( 'ast14.png' );
           afDelImgTmp( 'ast15.png' );
           afDelImgTmp( 'ast16.png' );
           afDelImgTmp( 'ast17.png' );
           afDelImgTmp( 'ast18.png' );
           afDelImgTmp( 'ast19.png' );
           afDelImgTmp( 'ast20.png' );
           afDelImgTmp( 'ast21.png' );
           afDelImgTmp( 'ast22.png' );
           afDelImgTmp( 'ast23.png' );
           afDelImgTmp( 'ast24.png' );
           afDelImgTmp( 'ast25.png' );
           afDelImgTmp( 'ast26.png' );
           afDelImgTmp( 'ast27.png' );
           afDelImgTmp( 'ast28.png' );
           afDelDirTmp( 'temp');
       }
     echo $updmsg;
     break;

     case '3':
        echo afJoomFish();
     break;
     
     case '4':
        echo afSEFsh404SEF();
     break;

     case '5':
    if( is_dir(JPATH_SITE.DS.'images'.DS.'artforms'.DS) && is_dir(AFPATH_ASTERISKS_SITE) && is_dir(AFPATH_ATTACHS_SITE) ) {
       chmod (JPATH_SITE.DS.'images'.DS.'artforms'.DS, 0755);
       chmod (AFPATH_ASTERISKS_SITE, 0755);
       chmod (AFPATH_ATTACHS_SITE, 0755);
       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_DIRCHMSUCC' ).' :: '.JPATH_SITE.DS.'images'.DS.'artforms'.DS.'<br />'.AFPATH_ASTERISKS_SITE.'<br />'.AFPATH_ATTACHS_SITE.'"><font color=green><strong>'.JText::_( 'ARTF_UPD_DIRCHMSUCC' ).'</strong></font></span>';
    } else {
       $updmsg = '<span class="MTTips" title="'.JText::_( 'ARTF_UPD_DIRCHMERROR' ).' :: '.JPATH_SITE.DS.'images'.DS.'artforms'.DS.'<br />'.AFPATH_ASTERISKS_SITE.'<br />'.AFPATH_ATTACHS_SITE.'"><font color=red><strong>'.JText::_( 'ARTF_UPD_DIRCHMERROR' ).'</strong></font></span>';
    }
    echo $updmsg;
     break;

     case '6':
        afUpdMLangEnt( 1 );
     break;

   }

}


?>

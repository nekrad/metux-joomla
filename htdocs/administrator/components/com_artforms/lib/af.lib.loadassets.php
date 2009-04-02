<?php
/**
* @version $Id: af.lib.loadassets.php v.2.1b7 2007-08-31 16:44:59Z GMT-3 $
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

function afLoadFECSS() {

   global $mainframe;
   $html = '<link rel="stylesheet" href="'.AFPATH_WEB_CSS_SITE.'artforms.css" type="text/css">';
   return $mainframe->addCustomHeadTag( $html );

}


function afLoadBECSS() {
   
   global $mainframe;
   $html = '<link rel="stylesheet" href="'.AFPATH_WEB_CSS_ADM_SITE.'artformsadm.css" type="text/css">';
   return $mainframe->addCustomHeadTag( $html );
      
}


function afLoadVRAdmCSS() {

   global $mainframe;
   $html = '<link rel="stylesheet" href="'.AFPATH_WEB_CSS_ADM_SITE.'artformsadm.css" type="text/css">
            <link rel="stylesheet" href="'.JURI::base().'/templates/system/css/system.css" type="text/css" />
            <link rel="stylesheet" href="'.JURI::base().'/templates/khepri/css/template.css" type="text/css" />';
   echo $html;

}


function afLoadCurrentFETplCSS() {

   global $mainframe;
   $html = '<link rel="stylesheet" href="'.JURI::base().'/templates/'.$mainframe->getTemplate().'/css/template_css.css" type="text/css" />';
   echo $html;

}


function afLoadMTCSS() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;

   global $mainframe;
   $html = '<link rel="stylesheet" href="'.AFPATH_WEB_CSS_ADM_SITE.'afmoot.css" type="text/css">';
   $mainframe->addCustomHeadTag( $html );
   
}


function afLoadCal( $lang ) {

   global $mainframe;
   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;
   
   if(file_exists(JPATH_ADMINISTRATOR.DS.'includes'.DS.'js'.DS.'jscalendar-1.0'.DS.'lang'.DS.'calendar-'.$lang.'.js')){
      $callang = 'calendar-'.$lang.'.js';
   } else {
      $callang = 'calendar-en.js';
   }

   $html = '<link rel="stylesheet" type="text/css" media="all" href="'.JURI::base().'/includes/js/jscalendar-1.0/calendar-system.css" title="green" />
            <script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'date/jscalendar.js"></script>
            <script type="text/javascript" src="'.JURI::base().'/includes/js/jscalendar-1.0/calendar_stripped.js"></script>
            <script type="text/javascript" src="'.JURI::base().'/includes/js/jscalendar-1.0/lang/'.$callang.'"></script>';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadBERFormsToolbar() {

   global $mainframe;
   $html = '<style type="text/css">
              #toolbar-expcsv {
	         background-image: url(../administrator/components/com_artforms/assets/images/expcsv.png);
                 background-repeat: no-repeat;
                 background-position: center 4px;
              }
              #toolbar-expxls {
	         background-image: url(../administrator/components/com_artforms/assets/images/expxls.png);
                 background-repeat: no-repeat;
                 background-position: center 4px;
              }
           </style>';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadBESettingsToolbar() {

   global $mainframe;
   $html = '<style type="text/css">
              #toolbar-uploadbtn {
	         background-image: url(../administrator/templates/khepri/images/toolbar/icon-32-upload.png);
                 background-repeat: no-repeat;
                 background-position: center 4px;
              }
           </style>';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadHSJS() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;

   global $mainframe;
   $html = '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'highslide/highslide.js"></script>
            <script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'highslide/highslide-html.js"></script>
            <script type="text/javascript">
                        hs.graphicsDir = \''.AFPATH_WEB_JS_SITE.'highslide/\';
                        hs.outlineType = \'beveled\';
                        hs.outlineWhileAnimating = true;
                        hs.objectLoadTime = \'after\';
                        window.onload = function() {
                            hs.preloadImages();
                        }
            </script>';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadHSDivs() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;

   ?>
   <div class="highslide-html-content" id="highslide-html" style="width: 550px">
      <div class="highslide-move" style="border: 0; height: 18px; padding: 2px; cursor: default">
         <a href="#" onclick="return hs.close(this)" class="control"><?php echo JText::_( 'ARTF_RFORMS_CLOSE' ); ?></a>
      </div>
      <div class="highslide-body"></div>
   </div>
   <?php
}


function afLoadMultiAttG() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;
   global $mainframe;
   $html = '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'multiupload-gmail/multiupload.js"></script>';
   $mainframe->addCustomHeadTag( $html );
   
}


function afLoadMultiAttSM() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;
   global $mainframe;
   $html = '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'multiple-file-element/multifile.js"></script>';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadMultiAttSMMT() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;
   global $mainframe;
   $html = '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'stickman-multiupload/Stickman.MultiUpload.js"></script>
            <link rel="stylesheet" type="text/css" media="screen" href="'.AFPATH_WEB_JS_SITE.'stickman-multiupload/Stickman.MultiUpload.css" />';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadMooToolsJS() {

   if(JArrayHelper::getValue( $_GET, 'af_nojs' ) == '1' )return;
   global $mainframe;
   $html = '<script type="text/javascript" src="'.JURI::base().'media/system/js/mootools.js"></script>';
   $mainframe->addCustomHeadTag( $html );

}


function afLoadMTTips() {

   global $mainframe;
   $html = "<script type=\"text/javascript\">
                var load_method = (window.ie ? 'load' : 'load');
      		window.addEvent(load_method, function(){
			var MTTips = new Tips($$('.MTTips'), {
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
   </script>";
   $mainframe->addCustomHeadTag( $html );

}


function afLoadMTMultiAcord() {

   global $mainframe;
   $html = '<script type="text/javascript" src="'.AFPATH_WEB_JS_SITE.'cnet/multiple.open.accordion.js"></script>';
   $html.= "<script type=\"text/javascript\">
               var load_method = (window.ie ? 'load' : 'load');
               window.addEvent(load_method, function(){
			var maccordion = new MultipleOpenAccordion($$('h3.atStart'), $$('div.atStart'), {
                                openAll: false,
		                allowMultipleOpen: true,
		                firstElementsOpen: [0],
		                start: 'open-first',
		                fixedHeight: false,
		                fixedWidth: false,
		                alwaysHide: true,
		                wait: true,
                                onActive: function(toggler, element){
					toggler.setStyle('color', '#ff3300');
				},
				onBackground: function(toggler, element){
					toggler.setStyle('color', '#222');
				},
		                height: true,
		                opacity: true,
		                width: false
			});
			$('hideall').addEvent('click', function(){
                           maccordion.hideAll(true);
                           this.fx.start(0);
                        });
                        $('showall').addEvent('click', function(){
                           maccordion.showAll(false);
                           this.fx.start(1);
                        });
                        $('addFieldx').addEvent('change', function(){
                           extrainputbox(this.form);
                           var maccordion = new MultipleOpenAccordion($$('h3.atStart'), $$('div.atStart'), {
                                openAll: false,
		                allowMultipleOpen: true,
		                firstElementsOpen: [0],
		                start: 'open-first',
		                fixedHeight: false,
		                fixedWidth: false,
		                alwaysHide: true,
		                wait: true,
                                onActive: function(toggler, element){
					toggler.setStyle('color', '#ff3300');
				},
				onBackground: function(toggler, element){
					toggler.setStyle('color', '#222');
				},
		                height: true,
		                opacity: true,
		                width: false
			});
			$('hideall').addEvent('click', function(){
                           maccordion.hideAll(true);
                        });
                        $('showall').addEvent('click', function(){
                           maccordion.showAll(false);
                        });
                           new Tips($$('.MTTips2'), {
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
               });

   </script>";
   $mainframe->addCustomHeadTag( $html );

}


function afLoadFrontEndCSS() {

   global $mainframe;
   $file = AFPATH_WEB_CSS_SITE.'artforms.css';
   $html = "<script type=\"text/javascript\">
         var load_method = (window.ie ? 'load' : 'load');
         window.addEvent(load_method, function(){
              var url = '".$file."';

              var start = $('afloadcss');
              var stop = $('afstopcss');
              var txtarea = $('afcustomcss');

              var ajax = new Ajax(url, {
              	update: txtarea,
               	method: 'get',
                	onComplete: function() {
                   		txtarea.removeClass('ajax-loading');
                     	},
                      	onCancel: function() {
		                txtarea.removeClass('ajax-loading');
        	        }
              });

              start.addEvent('click', function(e) {
                  new Event(e).stop();
	          txtarea.empty().addClass('ajax-loading');
           ajax.request(\$time());
              });

              stop.addEvent('click', function(e) {
	          new Event(e).stop();
                  $('afcustomcss').empty();
	          ajax.cancel();
              });
         });
   </script>";
   $mainframe->addCustomHeadTag( $html );

}


?>

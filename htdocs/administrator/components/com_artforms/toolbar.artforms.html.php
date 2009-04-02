<?php
/**
* @version $Id: toolbar.artforms.html.php v.2.1b7 2007-12-16 04:52:59Z 16:44:59Z GMT-3 $
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

class menuartforms {
	function MENU_Default() {

	}

	function MENU_EDIT() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_FORMS' ), 'forms48.png' );
	    JToolBarHelper::save();
	    JToolBarHelper::spacer();
	    JToolBarHelper::apply();
	    JToolBarHelper::spacer();
	    JToolBarHelper::cancel();
  	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'help', JText::_( 'ARTF_TOOL_HELP' ), false);
	}

	function MENU_SHOW() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_FORMS' ), 'forms48.png' );
	    JToolBarHelper::publishList();
	    JToolBarHelper::spacer();
	    JToolBarHelper::unpublishList();
  	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::addNew();
	    JToolBarHelper::spacer();
	    JToolBarHelper::editList();
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom( 'copy', 'copy.png', 'copy_f2.png', 'Copy', false );
	    JToolBarHelper::spacer();
	    JToolBarHelper::deleteList();
  	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}
	
	function MENU_RFORMS() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_RFORMS' ), 'rforms48.png' );
            JToolBarHelper::custom('exprformscsv','expcsv','expcsv','=&gt; CSV',true);
            JToolBarHelper::spacer();
            JToolBarHelper::custom('exprformsxls','expxls','expxls','=&gt; XLS',true);
            JToolBarHelper::spacer();
            JToolBarHelper::divider();
            JToolBarHelper::spacer();
	    JToolBarHelper::deleteList( JText::_( 'ARTF_TOOL_DEL' ), 'removerf' );
	    JToolBarHelper::spacer();
            JToolBarHelper::cancel( 'cancelrforms', JText::_( 'ARTF_TOOL_CANCEL' ) );
  	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}
	
	function MENU_VRFORMS() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_RFORMS' ), 'rforms48.png' );
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}
	
	function MENU_HELP() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_HELP' ), 'help48.png' );
            JToolBarHelper::cancel( 'cancelhelp', JText::_( 'ARTF_TOOL_CANCEL' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
	}
	
	function MENU_LANG() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_LANG' ), 'lang48.png' );
	    JToolBarHelper::save( 'savelanguage', JText::_( 'ARTF_TOOL_SFILE' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::apply( 'applylanguage', JText::_( 'ARTF_TOOL_APPLY' ) );
            JToolBarHelper::spacer();
	    JToolBarHelper::cancel( 'cancellanguage', JText::_( 'ARTF_TOOL_CANCEL' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}

	function MENU_CSS() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_CSS' ), 'css48.png' );
	    JToolBarHelper::save( 'savecssedit', JText::_( 'ARTF_TOOL_SFILE' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::apply( 'applycssedit', JText::_( 'ARTF_TOOL_APPLY' ) );
            JToolBarHelper::spacer();
	    JToolBarHelper::cancel( 'cancelcssedit', JText::_( 'ARTF_TOOL_CANCEL' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}
    
	function MENU_CONFIG() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_CONFIG' ), 'config48.png' );
	    JToolBarHelperUpload::media_manager_upload();
	    JToolBarHelper::spacer();
	    JToolBarHelper::save( 'saveconfig', JText::_( 'ARTF_TOOL_SCFG' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::apply( 'applyconfig', JText::_( 'ARTF_TOOL_APPLY' ) );
            JToolBarHelper::spacer();
	    JToolBarHelper::cancel( 'cancelconfig', JText::_( 'ARTF_TOOL_CANCEL' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}
	
	function MENU_UPDATE() {
	    JToolBarHelper::title( JText::_( 'ARTF_MENU_UPDATE' ), 'update48.png' );
	    JToolBarHelper::cancel( 'cancelupdate', JText::_( 'ARTF_TOOL_CANCEL' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
	}
	
	function MENU_INFO() {
            JToolBarHelper::title( JText::_( 'ARTF_MENU_INFO' ), 'info48.png' );
            JToolBarHelper::cancel( 'cancelinfo', JText::_( 'ARTF_TOOL_CANCEL' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::divider();
	    JToolBarHelper::spacer();
	    JToolBarHelper::back( JText::_( 'ARTF_TOOL_BACK' ) );
	    JToolBarHelper::spacer();
	    JToolBarHelper::custom('menu', 'menus', 'menubtn', JText::_( 'ARTF_TOOL_AFMENU' ), false);
            JToolBarHelper::spacer();
	    JToolBarHelper::custom('help', 'help', 'helpbtn', JText::_( 'ARTF_TOOL_HELP' ), false);
        }
}

class JToolBarHelperUpload extends JToolBarHelper {

	function media_manager_upload() {

           afLoadBESettingsToolbar();
           $html = '<td class="button" id="toolbar-Link">
                       <a href="javascript:void(0);" onclick="javascript:popupWindow(\'index.php?option=com_artforms&task=uploadcfg&no_html=1&no_affoo=1\',\'win1\',400,200,\'no\');" class="toolbar">
                          <span id="toolbar-uploadbtn" title="'.JText::_( 'ARTF_TOOL_UPLOAD' ).'"></span>
                          '.JText::_( 'ARTF_TOOL_UPLOAD' ).'
                       </a>
                    </td>';                                      //JText::_( 'ARTF_TOOL_UPLOAD' )
           $bar = & JToolBar::getInstance('toolbar');
	   $bar->appendButton( 'Custom', $html, JText::_( 'ARTF_TOOL_UPLOAD' ) );

	}
}

?>

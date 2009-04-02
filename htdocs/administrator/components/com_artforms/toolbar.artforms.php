<?php
/**
* @version $Id: toolbar.artforms.php v.2.1b7 2007-12-16 16:44:59Z GMT-3 $
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

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

switch($task) {
	case 'add':
		menuartforms::MENU_EDIT();
	break;
	case 'edit':
        case 'editA':
		menuartforms::MENU_EDIT();
	break;
        case 'copy':
		menuartforms::MENU_COPY();
	break;
        case 'showaf';
		menuartforms::MENU_SHOW();
	break;
        case 'rforms';
		menuartforms::MENU_RFORMS();
	break;
        case 'vrforms';
		menuartforms::MENU_VRFORMS();
	break;
        case 'help';
		menuartforms::MENU_HELP();
	break;
        case 'language';
	        menuartforms::MENU_LANG();
        break;
        case 'cssedit';
	        menuartforms::MENU_CSS();
        break;
        case 'config';
		menuartforms::MENU_CONFIG();
	break;
        case 'update';
		menuartforms::MENU_UPDATE();
	break;
        case 'info';
		menuartforms::MENU_INFO();
	break;
	case 'menu';
	menuartforms::MENU_DEFAULT();
        break;
        
	default:
           $subtask = JArrayHelper::getValue( $_REQUEST, 'subtask', '' );
           switch ( $subtask ) {
              case 'showaf':
              menuartforms::MENU_SHOW();
              break;
              case 'rforms':
              menuartforms::MENU_RFORMS();
              break;
              default:
              menuartforms::MENU_DEFAULT();
              break;
           }
	break;

}

?>

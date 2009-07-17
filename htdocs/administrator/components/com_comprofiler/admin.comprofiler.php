<?php
/**
* Joomla Community Builder
* @version $Id: admin.comprofiler.php 610 2006-12-13 17:33:44Z beat $
* @package Community Builder
* @subpackage admin.comprofiler.php
* @author JoomlaJoe and Beat, database check function by Nick
* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $_CB_Admin_Done, $mainframe;

if ( $_CB_Admin_Done ) {
	echo $_CB_Admin_Done;
} else {
	require( $mainframe->getCfg( 'absolute_path' ) . '/administrator/components/com_comprofiler/admin.comprofiler.controller.php' );
	$_CB_Admin_Done		=	true;
}

?>

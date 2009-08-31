<?php
/**
 * Template Chooser Module Entry Point
 * 
 * @package    Joomla
 * @subpackage Modules
 * @link http://templates.linkster.be/
 * @license		GNU/GPL, see LICENSE.php
 * mod_templatechooser is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */



// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe;
$cur_template = $mainframe->getTemplate();

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

if (isset( $_POST["mod_change_template"])) {
  modTemplateChooserHelper::setTemplate($_POST["mod_change_template"]);
}

$titlelength = $params->get( 'title_length', 20 );
$preview_height = $params->get( 'preview_height', 90 );
$preview_width = $params->get( 'preview_width', 140 );
$show_preview = $params->get( 'show_preview', 0 );
$darray = modTemplateChooserHelper::getTemplates($params);

require( JModuleHelper::getLayoutPath( 'mod_templatechooser' ) );
?>
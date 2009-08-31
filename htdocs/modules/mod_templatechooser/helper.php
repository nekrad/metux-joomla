<?php
/**
 * Helper class for Template Chooser module
 * 
 * @package    mod_templatechooser
 * @subpackage Modules
 * @link http://templates.linkster.be/
 * @license		GNU/GPL, see LICENSE.php
 * mod_templatechooseris free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */


class modTemplateChooserHelper
{

  function setTemplate($newTemplate)
  {
    global $mainframe;


    // Initialize some variables

    $mainframe->setUserState('setTemplate', $newTemplate);
    setcookie('template', $newTemplate);
    $kickback = $_REQUEST{'templatechooser_kickback'};
    $mainframe->redirect($kickback);
    die("DONE: $kickback");
//    $mainframe->setTemplate($newTemplate);
//    $mainframe->redirect('index.php');
    $url = $_SERVER['PHP_SELF'];
    if ($_SERVER['QUERY_STRING'] != "") {
      $url .= '?'.$_SERVER['QUERY_STRING'];
    }
    $mainframe->redirect($url);
  }

  function getTemplates(&$params) {

    // titlelength can be set in module params
    $titlelength = $params->get( 'title_length', 20 );
    $preview_height = $params->get( 'preview_height', 90 );
    $preview_width = $params->get( 'preview_width', 140 );
    $show_preview = $params->get( 'show_preview', 0 );

    // Read files from template directory
    $template_path = "templates";
    $templatefolder = @dir( $template_path );
    $darray = array();

    if ($templatefolder) {
	while ($templatefile = $templatefolder->read()) {
		if ($templatefile != "." && $templatefile != ".."&& $templatefile != "_system"&& $templatefile != "system" && $templatefile != ".svn" && $templatefile != "css" && is_dir( "$template_path/$templatefile" )  ) {
		  if ($params->get($templatefile, 1) == 1 ) {
		        if(strlen($templatefile) > $titlelength) {
				$templatename = substr( $templatefile, 0, $titlelength-3 );
				$templatename .= "...";
			} else {
				$templatename = $templatefile;
			}
		        $darray[] = JHTML::_('select.option', $templatefile, $templatename );
		  }
		}
	}
	$templatefolder->close();
    }
 
    sort( $darray );
    return $darray;
  }
}
<?php
/**
* @version $Id: manager.php 2005-12-27 09:23:43Z Ryan Demmer $
* @package JCE
* @copyright Copyright (C) 2005 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$version = "1.5.0";

require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'editor.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'plugin.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'utils.php' );
require_once( JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php' );

require_once( dirname( __FILE__ ) .DS. 'classes' .DS. 'imgmanager.php' );

$manager =& ImageManager::getInstance();

// check the user/group has editor permissions
$manager->checkPlugin() or die( 'Restricted access' );

// Load Plugin Parameters
$params	= $manager->getPluginParams();

// Setup plugin XHR callback functions 
$manager->setXHR( array( &$manager, 'getDimensions' ) );

// Set javascript file array
$manager->script( array( 'imgmanager' ), 'plugins' );
// Set css file array
$manager->css( array( 'imgmanager' ), 'plugins' );

// Load extensions if any
$manager->loadExtensions();
// Process requests
$manager->processXHR();

$manager->_debug = false;
$version .= $manager->_debug ? ' - debug' : '';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $manager->getLanguageTag();?>" lang="<?php echo $manager->getLanguageTag();?>" dir="<?php echo $manager->getLanguageDir();?>" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo JText::_('PLUGIN TITLE').' : '.$version;?></title>
<?php
$manager->printScripts();
$manager->printCss();
?>
	<script type="text/javascript">
		function initManager(src){
			// Create ImageManager (see imgmanager.js)
			var imgmanager = new ImageManager(src, {
				// Global parameters
				actions: <?php echo $manager->getActions();?>,
				buttons: <?php echo $manager->getButtons();?>, 
				lang: '<?php echo $manager->getLanguage();?>',
				// Uploader options
				upload: {
					method: '<?php echo $manager->getEditorParam('editor_upload_method', 'flash'); ?>',
					size: <?php echo $manager->getUploadSize(); ?>
				},
				tree: <?php echo $manager->getEditorParam('editor_folder_tree', '1'); ?>,
				// Plugin parameters
				params: {
					// Relative base directory
					base: '<?php echo $manager->getBase(); ?>',
					// Default values
					defaults : {	
						'align': 		'<?php echo $params->get( 'imgmanager_align', 'left' );?>',
						'border': 		'<?php echo $params->get( 'imgmanager_border', '0' );?>',
						'border_width': '<?php echo $params->get( 'imgmanager_border_width', '1' );?>',
						'border_style': '<?php echo $params->get( 'imgmanager_border_style', 'solid' );?>',
						'border_color': '<?php echo $params->get( 'imgmanager_border_color', '#000000' );?>',
						'hspace': 		'<?php echo $params->get( 'imgmanager_hspace', '5' );?>',
						'vspace': 		'<?php echo $params->get( 'imgmanager_vspace', '5' );?>'	
					}
				} 
			});
			// return object
			return imgmanager;
		}
	</script>
</head>
<body lang="<?php echo $manager->getLanguage(); ?>" style="display: none;">
    <div class="tabs">
            <ul>
                <li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onMouseDown="return false;"><?php echo JText::_('Article Image');?></a></span></li>
                <li id="swap_tab"><span><a href="javascript:mcTabs.displayTab('swap_tab','swap_panel');" onMouseDown="return false;"><?php echo JText::_('Rollover Image');?></a></span></li>
                <li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onMouseDown="return false;"><?php echo JText::_('Advanced');?></a></span></li>
            </ul>
        </div>
        <div class="panel_wrapper">
            <div id="general_panel" class="panel current">
                <fieldset>
                        <legend><?php echo JText::_('Article Image');?></legend>
                        <table class="properties" border="0">
                            <tr>
                                <td class="column1"><label id="srclabel" for="src"><?php echo JText::_('Url');?></label></td>
                                <td colspan="3"><table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input type="text" id="src" value="" /></td>
                                    </tr>
                                  </table></td>
                                <td rowspan="7" valign="top">
                                <div class="alignPreview">
                                        <img id="sample" src="<?php echo $manager->image('sample.jpg', 'plugins');?>" alt="sample" />
                                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="column1"><label id="altlabel" for="alt"><?php echo JText::_('Alt');?></label></td>
                                <td colspan="3"><input id="alt" type="text" value="" /></td>
                            </tr>
                            <tr>
                                <td class="column1"><label id="titlelabel" for="title"><?php echo JText::_('Title');?></label></td>
                                <td colspan="3"><input id="title" type="text" value="" /></td>
                            </tr>
                            <tr>
                            <td class="column1"><label id="widthlabel" for="width"><?php echo JText::_('Dimensions');?></label></td>
                            <td nowrap="nowrap" colspan="3">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><input type="text" id="width" name="width" value="" onchange="changeDimensions('width', 'height');" /> x <input type="text" id="height" name="height" value="" onChange="changeDimensions('height', 'width');" /></td>
                                        <input type="hidden" id="tmp-width" value=""  />
                                        <input type="hidden" id="tmp-height" value="" />
                                        <td>&nbsp;&nbsp;<input id="constrain" type="checkbox" name="constrain" class="check" checked="checked" /></td>
                                        <td><label id="constrainlabel" for="constrain"><?php echo JText::_('Proportional');?></label></td>
                                        <td><div id="dim_loader"></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="column1"><label id="vspacelabel" for="vspace"><?php echo JText::_('VSpace');?></label></td>
                            <td style="width:10%"><input type="text" id="vspace" value="" size="3" maxlength="3" onChange="ImageManagerDialog.updateStyles();" /></td>	
                            <td class="column1" style="width:10%"><label id="hspacelabel" for="hspace"><?php echo  JText::_('HSpace');?></label></td>
                            <td><input type="text" id="hspace" value="" size="3" maxlength="3" onChange="ImageManagerDialog.updateStyles();" /></td>
                        </tr>
                        <tr>
                            <td class="column1"><label id="alignlabel" for="align"><?php echo JText::_('Align');?></label></td>
                            <td>
                            	<select name="align" id="align" onchange="ImageManagerDialog.updateStyles();">
                                    <option value=""><?php echo JText::_('Align Default');?></option>
                                    <option value="top"><?php echo JText::_('Align Top');?></option>
                                    <option value="middle"><?php echo JText::_('Align Middle');?></option>
                                    <option value="bottom"><?php echo JText::_('Align Bottom');?></option>
                                    <option value="left"><?php echo JText::_('Align Left');?></option>
                                    <option value="right"><?php echo JText::_('Align Right');?></option>
                                </select>
                            </td>
                            <td class="column1"><label id="clearlabel" for="clear" class="disabled"><?php echo JText::_('Clear');?></label></td>
                            <td>
                            	<select name="clear" id="clear" disabled="disabled" onchange="ImageManagerDialog.updateStyles();">
                                    <option value=""><?php echo JText::_('Not Set');?></option>
                                    <option value="none"><?php echo JText::_('None');?></option>
                                    <option value="both"><?php echo JText::_('Both');?></option>
                                    <option value="left"><?php echo JText::_('Left');?></option>
                                    <option value="right"><?php echo JText::_('Right');?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label><?php echo JText::_('Border');?></label></td>
                            <td colspan="3">
                            <table cellspacing="0">
                                <tr>
                                    <td><input type="checkbox" class="check" id="border" onclick="ImageManagerDialog.setBorder();"></td>
                                    <td><label for="border_width"><?php echo JText::_('Width');?></label></td>
                                    <td>
                                    <select id="border_width" name="border_width" onchange="ImageManagerDialog.updateStyles();">
                                        <option value="0">0</option>
                                        <option value="1" selected="selected">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="thin"><?php echo JText::_('BORDER THIN');?></option>
                                        <option value="medium"><?php echo JText::_('BORDER MEDIUM');?></option>
                                        <option value="thick"><?php echo JText::_('BORDER THICK');?></option>
                                    </select>
                                    </td>
                                    <td><label for="border_style"><?php echo JText::_('Style');?></label></td>
                                    <td>
                                        <select id="border_style" name="border_style" onchange="ImageManagerDialog.updateStyles();">
                                            <option value="none"><?php echo JText::_('BORDER NONE');?></option>
                                            <option value="solid" selected="selected"><?php echo JText::_('BORDER SOLID');?></option>
                                            <option value="dashed"><?php echo JText::_('BORDER DASHED');?></option>
                                            <option value="dotted"><?php echo JText::_('BORDER DOTTED');?></option>
                                            <option value="double"><?php echo JText::_('BORDER DOUBLE');?></option>
                                            <option value="groove"><?php echo JText::_('BORDER GROOVE');?></option>
                                            <option value="inset"><?php echo JText::_('BORDER INSET');?></option>
                                            <option value="outset"><?php echo JText::_('BORDER OUTSET');?></option>
                                            <option value="ridge"><?php echo JText::_('BORDER RIDGE');?></option>
                                        </select>
                                    </td>
                                    <td><label for="border_color"><?php echo JText::_('Color');?></label></td>
                                    <td><input id="border_color" type="text" value="#000000" size="9" onchange="TinyMCE_Utils.updateColor(this);ImageManagerDialog.updateStyles();" /></td>
                                    <td id="border_color_pickcontainer">&nbsp;</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div id="swap_panel" class="panel">
                <fieldset>
                    <legend><?php echo JText::_('Rollover Image');?></legend>
    
                    <input type="checkbox" id="onmousemovecheck" class="check" onclick="ImageManagerDialog.setSwapImage();" />
                    <label id="onmousemovechecklabel" for="onmousemovecheck"><?php echo JText::_('Enable');?></label>
    
                    <table border="0" cellpadding="4" cellspacing="0" width="100%">
                            <tr>
                                <td class="column1"><label id="onmouseoversrclabel" for="onmouseoversrc"><?php echo JText::_('Mouseover');?></label></td>
                                <td><table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input id="onmouseoversrc" type="text" value="" /></td>
                                    </tr>
                                  </table></td>
                            </tr>
                            <tr>
                                <td class="column1"><label id="onmouseoutsrclabel" for="onmouseoutsrc"><?php echo JText::_('Mouseout');?></label></td>
                                <td class="column2"><table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input id="onmouseoutsrc" type="text" value="" /></td>
                                    </tr>
                                  </table></td>
                            </tr>
                    </table>
                </fieldset>
            </div>
            <div id="advanced_panel" class="panel">
                <fieldset>
                    <legend><?php echo JText::_('Advanced');?></legend>
                    <table border="0" cellpadding="4" cellspacing="0">
                        <tr>
                            <td class="column1"><label id="stylelabel" for="style"><?php echo JText::_('Style');?></label></td>
                            <td><input id="style" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <td><label id="classlabel" for="classlist"><?php echo JText::_('Class List');?></label></td>
                            <td><select id="classlist" class="mceEditableSelect"></select>
                            </td>
                        </tr>
                        <tr>
                            <td class="column1"><label id="idlabel" for="id"><?php echo JText::_('Id');?></label></td>
                            <td><input id="id" type="text" value="" /></td>
                        </tr>
    
                        <tr>
                            <td class="column1"><label id="dirlabel" for="dir"><?php echo JText::_('Language Direction');?></label></td>
                            <td>
                                <select id="dir" name="dir" onchange="ImageManagerDialog.updateStyles();">
                                        <option value=""><?php echo JText::_('Not Set');?></option>
                                        <option value="ltr"><?php echo JText::_('LTR');?></option>
                                        <option value="rtl"><?php echo JText::_('RTL');?></option>
                                </select>
                            </td>
                        </tr>
    
                        <tr>
                            <td class="column1"><label id="langlabel" for="lang"><?php echo JText::_('Language Code');?></label></td>
                            <td>
                                <input id="lang" type="text" value="" />
                            </td>
                        </tr>
    
                        <tr>
                            <td class="column1"><label id="usemaplabel" for="usemap"><?php echo JText::_('Image Map');?></label></td>
                            <td>
                                <input id="usemap" type="text" value="" />
                            </td>
                        </tr>
    
                        <tr>
                            <td class="column1"><label id="longdesclabel" for="longdesc"><?php echo JText::_('Long Description');?></label></td>
                            <td><table border="0" cellspacing="1" cellpadding="0">
                                    <tr>
                                      <td><input id="longdesc" type="text" value="" /></td>
                                      <td id="longdesccontainer">&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </div>
    <?php $manager->loadBrowser();?>
	<div class="mceActionPanel">
		<div style="float: right">
    		<input type="button" class="button "id="refresh" value="<?php echo JText::_('Refresh');?>" />
			<input type="button" id="insert" value="<?php echo JText::_('Insert');?>" onClick="ImageManagerDialog.insert();" />
			<input type="button" id="cancel" value="<?php echo JText::_('Cancel');?>" onClick="tinyMCEPopup.close();" />
		</div>
	</div>
</body> 
</html>
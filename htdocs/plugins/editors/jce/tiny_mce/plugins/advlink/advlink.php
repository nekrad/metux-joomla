<?php
/**
* @version $Id: link.php 2008-02-20 Ryan Demmer $
* @package JCE
* @copyright Copyright (C) 2006-2007 Ryan Demmer. All rights reserved.
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

require_once( dirname( __FILE__ ) .DS. 'classes' .DS. 'advlink.php' );

$advlink =& AdvLink::getInstance();

$advlink->checkPlugin() or die( 'Restricted access' );
// Load Plugin Parameters
$params	= $advlink->getPluginParams();

// Process any XHR requests
$advlink->processXHR();

$advlink->_debug = false;
$version .= $advlink->_debug ? ' - debug' : '';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $advlink->getLanguageTag();?>" lang="<?php echo $advlink->getLanguageTag();?>" dir="<?php echo $advlink->getLanguageDir();?>" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo JText::_('PLUGIN TITLE');?> : <?php echo $version;?></title>
<?php
$advlink->printScripts();
$advlink->printCss();
?>
	<script type="text/javascript">
		var advlink = new Plugin('advlink', {
			lang: '<?php echo $advlink->getLanguage(); ?>',
			params: {
				'defaults': {
					'target': "<?php echo $params->get('target', '');?>"
				}
			}
		});
	</script>
</head>
<body lang="<?php echo $advlink->getLanguage();?>" id="advlink" style="display: none">
	<form onSubmit="insertAction();return false;" action="#">
	<div class="tabs">
		<ul>
			<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onMouseDown="return false;"><?php echo JText::_('GENERAL TAB');?></a></span></li>
			<li id="events_tab"><span><a href="javascript:mcTabs.displayTab('events_tab','events_panel');" onMouseDown="return false;"><?php echo JText::_('EVENTS TAB');?></a></span></li>
			<li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onMouseDown="return false;"><?php echo JText::_('ADVANCED TAB');?></a></span></li>
		</ul>
	</div>
	<div class="panel_wrapper" style="border-bottom:0px;">
		<div id="general_panel" class="panel current">
			<fieldset>
				<legend><?php echo JText::_('GENERAL TAB');?></legend>
				<table border="0" cellpadding="4" cellspacing="0">
					<tr>
						<td nowrap="nowrap"><label id="hreflabel" for="href"><?php echo JText::_('Url');?></label></td>
						<td><input id="href" type="text" value="" size="150" /></td>
                        <td id="hrefbrowsercontainer">&nbsp;</td>
					</tr>
					<tr>
						<td class="column1"><label for="anchorlist"><?php echo JText::_('Anchors');?></label></td>
						<td colspan="3" id="anchorlistcontainer">&nbsp;</td>
					</tr>
					<tr>
						<td><label id="targetlistlabel" for="targetlist"><?php echo JText::_('Target');?></label></td>
						<td colspan="3"><select id="targetlist">
								<option value=""><?php echo JText::_('NOT SET');?></option>
								<option value="_self"><?php echo JText::_('TARGET SELF');?></option>
								<option value="_blank"><?php echo JText::_('TARGET BLANK');?></option>
								<option value="_parent"><?php echo JText::_('TARGET PARENT');?></option>
								<option value="_top"><?php echo JText::_('TARGET TOP');?></option>								
							</select>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap"><label id="titlelabel" for="title"><?php echo JText::_('TITLE');?></label></td>
						<td colspan="3"><input id="title" name="title" type="text" value="" /></td>
					</tr>
					<tr>
						<td><label id="classlabel" for="classlist"><?php echo JText::_('CLASS');?></label></td>
						<td colspan="3">
						<select id="classlist" name="classlist" onChange="AdvLinkDialog.setClass(this.value);"></select>
						</td>
					</tr>
				</table>
				</fieldset>
				<fieldset>
					<legend><strong><?php echo JText::_('EMAIL');?></strong></legend>
                    <table border="0" cellpadding="4" cellspacing="0">
				        <tr id="emailaddressrow">
							<td class="column1"><label for="emailaddress"><?php echo JText::_('ADDRESS');?></label></td>
							<td><input id="emailaddress" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="emailsubject"><?php echo JText::_('SUBJECT');?></label></td>
							<td><input id="emailsubject"  type="text" value="" /></td>
						</tr>
						<tr>
							<td colspan="2"><input id="emailcreate" class="button" type="button" onClick="AdvLinkDialog.buildAddress();" value="<?php echo JText::_('CREATE');?>" /></td>
						</tr>
                    </table>
                </fieldset>
			</div>
			<div id="advanced_panel" class="panel">
			<fieldset>
					<legend><?php echo JText::_('ADVANCED TAB');?></legend>

					<table border="0" cellpadding="0" cellspacing="4">
						<tr>
							<td class="column1"><label id="idlabel" for="id"><?php echo JText::_('ID');?></label></td>
							<td><input id="id" type="text" value="" /></td> 
						</tr>

						<tr>
							<td><label id="stylelabel" for="style"><?php echo JText::_('STYLE');?></label></td>
							<td><input type="text" id="style" value="" /></td>
						</tr>

						<tr>
							<td><label id="classeslabel" for="classes"><?php echo JText::_('CLASS');?></label></td>
							<td><input type="text" id="classes" value="" onChange="AdvLinkDialog.setClassList(this.value);" /></td>
						</tr>

						<tr>
							<td><label id="targetlabel" for="target"><?php echo JText::_('TARGET NAME');?></label></td>
							<td><input type="text" id="target" value="" onChange="AdvLinkDialog.setTargetList(this.value);" /></td>
						</tr>

						<tr>
							<td class="column1"><label id="dirlabel" for="dir"><?php echo JText::_('LANGUAGE DIRECTION');?></label></td>
							<td>
								<select id="dir" name="dir"> 
									<option value=""><?php echo JText::_('NOT SET');?></option>
									<option value="ltr"><?php echo JText::_('LTR');?></option>
									<option value="rtl"><?php echo JText::_('RTL');?></option>
								</select>
							</td> 
						</tr>

						<tr>
							<td><label id="hreflanglabel" for="hreflang"><?php echo JText::_('TARGET LANGUAGE CODE');?></label></td>
							<td><input type="text" id="hreflang" value="" /></td>
						</tr>

						<tr>
							<td class="column1"><label id="langlabel" for="lang"><?php echo JText::_('LANGUAGE CODE');?></label></td>
							<td>
								<input id="lang" type="text" value="" />
							</td> 
						</tr>

						<tr>
							<td><label id="charsetlabel" for="charset"><?php echo JText::_('CHARSET');?></label></td>
							<td><input type="text" id="charset" value="" /></td>
						</tr>

						<tr>
							<td><label id="typelabel" for="type"><?php echo JText::_('MIMETYPE');?></label></td>
							<td><input type="text" id="type" value="" /></td>
						</tr>

						<tr>
							<td><label id="rellabel" for="rel"><?php echo JText::_('REL');?></label></td>
							<td><select id="rel" class="mceEditableSelect"> 
									<option value=""><?php echo JText::_('NOT SET');?></option>
									<option value="lightbox">Lightbox</option>
                                    <option value="alternate">Alternate</option> 
									<option value="designates">Designates</option> 
									<option value="stylesheet">Stylesheet</option> 
									<option value="start">Start</option> 
									<option value="next">Next</option> 
									<option value="prev">Prev</option> 
									<option value="contents">Contents</option> 
									<option value="index">Index</option> 
									<option value="glossary">Glossary</option> 
									<option value="copyright">Copyright</option> 
									<option value="chapter">Chapter</option> 
									<option value="subsection">Subsection</option> 
									<option value="appendix">Appendix</option> 
									<option value="help">Help</option> 
									<option value="bookmark">Bookmark</option> 
								</select> 
							</td>
						</tr>

						<tr>
							<td><label id="revlabel" for="rev"><?php echo JText::_('REV');?></label></td>
							<td><select id="rev"> 
									<option value=""><?php echo JText::_('NOT SET');?></option>
									<option value="alternate">Alternate</option> 
									<option value="designates">Designates</option> 
									<option value="stylesheet">Stylesheet</option> 
									<option value="start">Start</option> 
									<option value="next">Next</option> 
									<option value="prev">Prev</option> 
									<option value="contents">Contents</option> 
									<option value="index">Index</option> 
									<option value="glossary">Glossary</option> 
									<option value="copyright">Copyright</option> 
									<option value="chapter">Chapter</option> 
									<option value="subsection">Subsection</option> 
									<option value="appendix">Appendix</option> 
									<option value="help">Help</option> 
									<option value="bookmark">Bookmark</option> 
								</select> 
							</td>
						</tr>

						<tr>
							<td><label id="tabindexlabel" for="tabindex"><?php echo JText::_('TABINDEX');?></label></td>
							<td><input type="text" id="tabindex" value="" /></td>
						</tr>

						<tr>
							<td><label id="accesskeylabel" for="accesskey"><?php echo JText::_('ACCESSKEY');?></label></td>
							<td><input type="text" id="accesskey" value="" /></td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="events_panel" class="panel">
			<fieldset>
					<legend><?php echo JText::_('EVENTS TAB');?></legend>

					<table border="0" cellpadding="0" cellspacing="4">
						<tr>
							<td class="column1"><label for="onfocus">onfocus</label></td> 
							<td><input id="onfocus" type="text" value="" /></td> 
						</tr>
						<tr>
							<td class="column1"><label for="onblur">onblur</label></td>
							<td><input id="onblur" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onclick">onclick</label></td> 
							<td><input id="onclick" type="text" value="" /></td> 
						</tr>
						<tr>
							<td class="column1"><label for="ondblclick">ondblclick</label></td>
							<td><input id="ondblclick" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onmousedown">onmousedown</label></td> 
							<td><input id="onmousedown" type="text" value="" /></td> 
						</tr>
						<tr>
							<td class="column1"><label for="onmouseup">onmouseup</label></td>
							<td><input id="onmouseup" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onmouseover">onmouseover</label></td> 
							<td><input id="onmouseover" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onmousemove">onmousemove</label></td>
							<td><input id="onmousemove" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onmouseout">onmouseout</label></td> 
							<td><input id="onmouseout" type="text" value="" /></td> 
						</tr>
						<tr>
							 <td class="column1"><label for="onkeypress">onkeypress</label></td>
							<td><input id="onkeypress" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onkeydown">onkeydown</label></td> 
							<td><input id="onkeydown" type="text" value="" /></td>
						</tr>
						<tr>
							<td class="column1"><label for="onkeyup">onkeyup</label></td>
							<td><input id="onkeyup" type="text" value="" /></td>
						</tr>
					</table>
				</fieldset>
			</div>
		</div>
		<div class="panel_wrapper" style="border-top:0px; margin-top:0px; padding-top:0px; height:120px">
			<fieldset>
				<legend><strong><?php echo JText::_('CONTENT');?></strong></legend>
				<div id="loader" class="loader-off"></div>
                <div id="link-options">
                    <div>
                    	<select id="link-types" class="link-items" onChange="AdvLinkDialog.clearLists();AdvLinkDialog.getList(this.value,'');">
                        	<?php echo $advlink->getLists();?>
                        </select>
                    </div>
                    <div id="link-items-1"></div>
                    <div id="link-items-2"></div>
                    <div id="link-items-3"></div>
                    <div id="link-items-4"></div>
                </div>
			</fieldset>
        </div>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" id="insert" name="insert" value="<?php echo JText::_('Insert');?>" onClick="AdvLinkDialog.insert();" />
			</div>
			<div style="float: right">
				<input type="button" class="button" id="help" name="help" value="<?php echo JText::_('Help');?>" onClick="advlink.openHelp();" />
				<input type="button" id="cancel" name="cancel" value="<?php echo JText::_('Cancel');?>" onClick="tinyMCEPopup.close();" />
			</div>
		</div>
    </form>
</body>
</html>

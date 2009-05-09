<?php
/**
* @version browser.php 2008-02-25 Ryan Demmer $
* @package JCE
* @copyright Copyright (C) 2005 - 2008 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<form action="<?php echo $this->action;?>&<?php echo $this->session->getName().'='.$this->session->getId(); ?>" id="uploadForm" method="post" enctype="multipart/form-data">
<div id="browser">
    <fieldset>
        <legend><?php echo JText::_('Browse');?></legend>
        <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="7" class="layout-header"><div id="message"></div></td>
            </tr>
            <tr>
                <td class="layout-left">
                	<div id="searchbox"><input id="search" type="text" /></div>
                </td>
                <td rowspan="3" id="tree-handle">&nbsp;</td>
                <td class="layout-center">
                	<div id="sort-ext"></div>
                	<div id="sort-name"></div>
                </td>
                <td rowspan="3" id="list-handle">&nbsp;</td>
                <td colspan="2">
                    <div id="actions"></div>
                    <div class="spacer horizontal"></div>
                </td>
            </tr>
            <tr>
                <td rowspan="2">
                    <div id="tree">
                        <div class="top">
                            <div class="left"></div>
                            <div class="center"></div>
                            <div class="right"></div>
                            <span><?php echo JText::_('Folders');?></span>
                        </div>
                        <div id="tree-body"></div>
                    </div>
                </td>
                <td rowspan="2" class="layout-center">
                	<div id="dir-list"></div>
                </td>
                <td class="layout-right">
                    <div id="info">
                        <div class="top">
                            <div class="left"></div>
                            <div class="center"></div>
                            <div class="right"></div>
                            <span><?php echo JText::_('Details');?></span>
                        </div>
                        <div id="info-body"></div>
                    </div>                
                </td>
                <td style="width:22px;" rowspan="2">
                	<div id="buttons"></div>
                    <div class="spacer vertical"></div>
                </td>
            </tr>
            <tr>
                <td>
                	<div id="info-nav">
                        <div id="info-nav-left"></div>
                        <div id="info-nav-text"></div>
                        <div id="info-nav-right"></div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
</div>
</form>
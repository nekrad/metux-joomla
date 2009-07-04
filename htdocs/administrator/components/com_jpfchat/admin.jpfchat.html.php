<?php
/**
 * jPFChat15 - A joomla 1.5.x chatroom component
 *
 * @version $Id: jPFChat.php
 * @author Tim Milo
 * @link http://www.jPFChat.com
 * @copyright (C) 2008 ViziMetrics, Inc - All rights reserved.
 * @license GNU/GPL License
 */

defined( '_JEXEC' ) or die( 'Restricted Access' );

class jPFChatView {

        function showjPFChat(  $option, $rows ) {

                ?><form action="index.php" method="post" name="adminForm"><?php
                
                jimport('joomla.html.pane');
                $pane = JPane::getInstance('tabs');
                echo $pane->startPane( "jPFChat" );
                echo $pane->startPanel( 'Main Settings' , "tabGeneral" );

                tablestart() ;
                jPFChatView::showconfrows($rows, 1);
                ?></table><?php

                echo $pane->endPanel();
                echo $pane->startPanel( 'Display' , "tabDisplay" );

                tablestart() ;
                jPFChatView::showconfrows($rows, 2);
                ?></table><?php

                echo $pane->endPanel();
                echo $pane->startPanel( 'Advanced' , "tabAdvanced" );

                tablestart() ;
                jPFChatView::showconfrows($rows, 3);
                ?></table><?php
                
                echo $pane->endPanel();
                echo $pane->startPanel("About...", "tabAbout" ); ?>

                <table width="90%" border="0" cellpadding="4" cellspacing="2" class="adminFform">
                <tr><td align="left">
                        <p><img style="margin-bottom: 10px; margin-right: 15px;" align="left" border="1" src='../../components/com_jpfchat/images/jpfchat_logo_mini.png' alt='jPFChat' /></p>
                        <p><a target="_blank" href="http://www.jpfchat.com/index2.php?option=com_versions&catid=2&myVersion=<?php echo jPFC_VERSION ?>"><font color="black" size="2"><u>Version Check</u></font></a></p>
                        <p>jPFChat is maintained and supported by <a href="http://www.vizimetrics.com">Vizimetrics, Inc.</a><br />
                        <p>Please visit the <strong><u>official jPFChat website</u></strong> at <a href="http://www.jPFChat.com">www.jPFChat.com</a> for updates.</p>
                        <p>Support is available via our online help ticket system at
                        <a href="http://support.vizimetrics.com">support.vizimetrics.com</a> or via email: <a href="mailto:service@vizimetrics.com">service@vizimetrics.com</a> </p>

                        <p>phpFreeChat information and help is available at: <a href="http://www.phpfreechat.net">www.phpFreeChat.net</a></p>

                        <p>If you're pleased with jPFChat, please don't forget to support the jPFChat project.</p>
                        <ul>
                                <li>Write a favorable comment on the Joomla.org website...</li>
                                <li>Purchase the right to remove the jPFChat logo, or...</li>
                                <li>Donate to the jPFChat project.</li>
                        </ul>
                        <p>Thanks for your continued confidence and for giving jPFChat a try!</p>
                        <p>jPFChat for Joomla 1.5.x&nbsp;&nbsp;&nbsp;&copy; 2008 ViziMetrics, Inc - All rights reserved.</p>
                        </td>
                        <td></td>
                </tr>
                </table>
                <?php
                echo $pane->endPanel();
                echo $pane->endPane(); ?>

                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="task" value="" />
                </form><?php
        }   //end function

     function showconfrows($rows, $c_row) {

          foreach ($rows as $row) {
            if ($row->tab == $c_row) {
                if ($row->type == 'B') {

                     $optionHTML = JHTML::_( 'select.booleanlist', 'newValues['.$row->name.']', '', $row->value, 'ON', 'OFF' );

                } elseif ($row->name == 'date_format') {

                     $myDates = array();
                     $myDates[] = JHTML::_( 'select.option', 'm/d/Y', 'm/d/Y' );
                     $myDates[] = JHTML::_( 'select.option', 'd/m/Y', 'd/m/Y' );

                     $optionHTML = JHTML::_('select.genericlist', $myDates,    'newValues['.$row->name.']', 'size="1" class="inputbox"', 'value', 'text', $row->value );

                } elseif ($row->name == 'name_or_uname') {

                     $myName = array();
                     $myName[] = JHTML::_( 'select.option', 'Username', 'Username' );
                     $myName[] = JHTML::_( 'select.option', 'Name', 'Name' );

                     $optionHTML = JHTML::_('select.genericlist', $myName,    'newValues['.$row->name.']', 'size="1" class="inputbox"', 'value', 'text', $row->value );

                } elseif ($row->name == 'theme') {

                     $myFolders = getFolders ( COM_PATH.'/pfc/themes');
                     $optionHTML = JHTML::_('select.genericlist', $myFolders, 'newValues['.$row->name.']', 'size="1" class="inputbox"', 'value', 'text', $row->value );

                } elseif ($row->name == 'language') {

                     $myFolders = getFolders ( COM_PATH.'/pfc/i18n');
                     $optionHTML = JHTML::_('select.genericlist', $myFolders, 'newValues['.$row->name.']', 'size="1" class="inputbox"', 'value', 'text', $row->value );

                } elseif ($row->name == 'shownotice') {

                     $myNotices = array();
                     $myNotices[] = JHTML::_( 'select.option', 0, 'No Notifications' );
                     $myNotices[] = JHTML::_( 'select.option', 1, 'Nickname Changes Only' );
                     $myNotices[] = JHTML::_( 'select.option', 2, 'Connects/Disconnects Only' );
                     $myNotices[] = JHTML::_( 'select.option', 3, 'All Notices' );

                     $optionHTML = JHTML::_('select.genericlist', $myNotices, 'newValues['.$row->name.']', 'size="1" class="inputbox"', 'value', 'text', $row->value );

                } else {

                     $optionHTML = '<input type="text" name="newValues['.$row->name.']" value="'. ( !empty( $row->value ) ?  $row->value  : "" ).'"';
                }

                if ($row->name == 'display_pfc_logo') {
                        $row->description .= '&nbsp;&nbsp;<font color= "red">NOTE: Before turning OFF the phpFreeChat Logo Display, you MUST comply with phpFreeChat License Requirements!</font>';
                     }

           ?>   <tr><th align="left" valign="top"><?php echo $row->prompt; ?></th>
                    <td align="left" valign="top"><?php echo $optionHTML; ?></td>
                    <td align="left" valign="top"><?php echo $row->description; ?></td>
                </tr><?php
            }
          }
     }  //end function
}  // end class

function tablestart()  {
  ?><table width="90%" border="0" cellpadding="6" cellspacing="4" class="adminForm"> <?php
}

function getFolders( $dir ) {
    $myFolders = array();
    if ($handle = opendir($dir)) {
        while (false !== ($folder = readdir($handle))) {
            if ($folder != "." && $folder != "..") {
                $myFolders[] = JHTML::_( 'select.option', $folder );
            }
        }
        closedir($handle);
    }
    return $myFolders;
}
?>




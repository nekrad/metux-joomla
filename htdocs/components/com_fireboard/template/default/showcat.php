<?php
/**
* @version $Id: showcat.php 462 2007-12-10 00:05:53Z fxstein $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
*
* Based on Joomlaboard Component
* @copyright (C) 2000 - 2004 TSMF / Jan de Graaff / All Rights Reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @author TSMF & Jan de Graaff
**/
// Dont allow direct linking
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
global $fbConfig;

require_once(JB_ABSSOURCESPATH . 'fb_auth.php');
//Security basics begin
//Securing passed form elements:
$catid = (int)$catid;

//resetting some things:
$moderatedForum = 0;
$lockedForum = 0;
$lockedTopic = 0;
$topicSticky = 0;
$is_Mod = 0;

//Security Basics end
if (!$is_admin)
{
    $database->setQuery("SELECT userid FROM #__fb_moderation WHERE catid='$catid' and userid='$my->id'");

    if ($database->loadResult()) {
        $is_Mod = 1;
    }
}
else {
    $is_Mod = 1;
} //superadmins always are

unset($allow_forum);
$allow_forum = array ();

//get the db data with allowed forums and turn it into an array
if ($fbSession->allowed != "na" && !$new_fb_user) {
    $allow_forum = explode(',', $fbSession->allowed);
}
else
{
    //get only the publicly accessible forums..
    $database->setQuery("SELECT id FROM #__fb_categories WHERE published='1' AND pub_access='0'");
    $allowed_forums = $database->loadObjectList();
    $i = 0;

    foreach ($allowed_forums as $af)
    {
        if (count($allow_forum) == 0) {
            $allow_forum[0] = $af->id;
        }
        else
        {
            $allow_forum[$i] = $af->id;
            $i++;
        }
    }
}

if (!$is_Mod)
{
    //check Access Level Restrictions but don't bother for Moderators
    //get all the info on this forum:
    $database->setQuery("SELECT id,pub_access,pub_recurse,admin_access,admin_recurse FROM #__fb_categories where id='$catid'");
    $row = $database->loadObjectList();
    //Do user identification based upon the ACL
    $letPass = 0;
    $letPass = fb_auth::validate_user($row[0], $allow_forum, $aro_group->group_id, $acl);
}

if ($letPass || $is_Mod)
{
    $threads_per_page = $fbConfig['threads_per_page'];

    if ($catid <= 0) {
        //make sure we got a valid category id
        $catid = 1;
    }

    $view = $view == "" ? $settings[current_view] : $view;
    setcookie("fboard_settings[current_view]", $view, time() + 31536000, '/');
    /*//////////////// Start selecting messages, prepare them for threading, etc... /////////////////*/
    $page = (int)$page;
    $page = $page < 1 ? 1 : $page;
    $offset = ($page - 1) * $threads_per_page;
    $row_count = $page * $threads_per_page;
    $database->setQuery("Select count(*) FROM #__fb_messages WHERE parent = '0' AND catid= '$catid' AND hold = '0' ");
    $total = (int)$database->loadResult();
    $database->setQuery(
        "SELECT a. * , MAX( b.time )  AS lastpost FROM  #__fb_messages  AS a LEFT  JOIN #__fb_messages  AS b ON b.thread = a.thread WHERE a.parent =  '0' AND a.catid =  $catid AND a.hold =  '0' GROUP  BY id ORDER  BY ordering DESC , lastpost DESC  LIMIT $offset,$threads_per_page");

    foreach ($database->loadObjectList()as $message)
    {
        $threadids[] = $message->id;
        $messages[$message->parent][] = $message;
        $last_reply[$message->id] = $message;
        $hits[$message->id] = $message->hits;
    }

    if (count($threadids) > 0)
    {
        $idstr = @join("','", $threadids);
        $database->setQuery("SELECT id,parent,thread,catid,subject,name,time,topic_emoticon,locked,ordering,userid moved FROM #__fb_messages WHERE thread IN ('$idstr') AND id NOT IN ('$idstr') and hold=0");

        foreach ($database->loadObjectList()as $message)
        {
            $messages[$message->parent][] = $message;
            $thread_counts[$message->thread]++;
            $last_reply[$message->thread] = $last_reply[$message->thread]->time < $message->time ? $message : $last_reply[$message->thread];
        }
    }

    //get number of pending messages
    $database->setQuery("select count(*) from #__fb_messages where catid='$catid' and hold=1");
    $numPending = $database->loadResult();
    //@rsort($messages[0]);
?>
<!-- Pathway -->
<?php
    if (file_exists(JB_ABSTMPLTPATH . '/fb_pathway.php')) {
        require_once(JB_ABSTMPLTPATH . '/fb_pathway.php');
    }
    else {
        require_once(JB_ABSPATH . '/template/default/fb_pathway.php');
    }

    //Get the category name for breadcrumb
    unset($objCatInfo, $objCatParentInfo);
    $database->setQuery("SELECT * from #__fb_categories where id = {$catid}");
    $objCatInfo = $database->loadObject();
    //Get the Category's parent category name for breadcrumb
    $database->setQuery("SELECT name,id FROM #__fb_categories WHERE id = {$objCatInfo->parent}");
    $objCatParentInfo = $database->loadObject();
    // set page title
    //$mainframe->setPageTitle( $objCatParentInfo->name.' - '.$objCatInfo->name.' - '.$fbConfig['board_title'] );
    //check if this forum is locked
    $forumLocked = $objCatInfo->locked;
    //check if this forum is subject to review
    $forumReviewed = $objCatInfo->review;
    /*      echo '<a href="'.sefRelToAbs(JB_LIVEURLREL).'">';
          echo $fbIcons['forumlist'] ? '<img src="' . JB_URLICONSPATH . ''.$fbIcons['forumlist'].'" border="0" alt="'._GEN_FORUMLIST.'" > > ' : _GEN_FORUMLIST;
          echo '</a> ';
          if (file_exists(JPATH_SITE.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
          echo '<img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" />';
          } else {
          echo '<img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" />';
        }
          echo ' <a href="'.sefRelToAbs(JB_LIVEURLREL.'&amp;func=showcat&amp;catid='.$objCatParentInfo->id).'">'.$objCatParentInfo->name.'</a> ';
          if (file_exists(JPATH_SITE.'/templates/'.$mainframe->getTemplate().'/images/arrow.png')) {
          echo '<img src="'.JB_JLIVEURL.'/templates/'.$mainframe->getTemplate().'/images/arrow.png" alt="" />';
          } else {
          echo '<img src="'.JB_JLIVEURL.'/images/M_images/arrow.png" alt="" /> ';
        }*/
    // echo '<strong> '.$objCatInfo->name.'</strong>  ';
?>
<!--</div>
</td>
</tr>
</table>-->
<!-- / Pathway -->
<?php if($objCatInfo->headerdesc) { ?>
<div class="headerdesc"><?php echo $objCatInfo->headerdesc; ?></div>
<?php } ?>
<?php
    //(JJ)
    if (file_exists(JB_ABSTMPLTPATH . '/fb_sub_category_list.php')) {
        include(JB_ABSTMPLTPATH . '/fb_sub_category_list.php');
    }
    else {
        include(JB_ABSPATH . '/template/default/fb_sub_category_list.php');
    }
?>
    <!-- top nav -->

    <table border = "0" cellspacing = "0" class = "jr-topnav" cellpadding = "0">
        <tr>
            <td class = "jr-topnav-left">
                <?php
                //go to bottom
                echo '<a name="forumtop" /> <a href="'.htmlspecialchars(sefRelToAbs("index.php?".$_SERVER["QUERY_STRING"])).'#forumbottom" >';
                echo $fbIcons['bottomarrow'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['bottomarrow'] . '" border="0" alt="' . _GEN_GOTOBOTTOM . '" title="' . _GEN_GOTOBOTTOM . '"/>' : _GEN_GOTOBOTTOM;
                echo '</a>';
                ?>

                <?php
                if ((($fbConfig['pubwrite'] == 0 && $my_id != 0) || $fbConfig['pubwrite'] == 1) && ($topicLock == 0 || ($topicLock == 1 && $is_moderator)))
                {
                    //this user is allowed to post a new topic:
                    if ($fbIcons['new_topic']) {
                        echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=post&amp;do=reply&amp;catid='
                                                           . $catid) . '"><img src="' . JB_URLICONSPATH . '' . $fbIcons['new_topic'] . '" alt="' . _GEN_POST_NEW_TOPIC . '" title="' . _GEN_POST_NEW_TOPIC . '" border="0" /></a>';
                    }
                    else {
                        echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=post&amp;do=reply&amp;catid=' . $catid) . '">' . _GEN_POST_NEW_TOPIC . '</a>';
                    }
                }

                echo '</td><td class="jr-topnav-right">';

                //pagination 1
                if (count($messages[0]) > 0)
                {
                    echo '<div class="jr-pagenav"><ul>';
                    echo '<li class="jr-pagenav-text">';
                    echo _PAGE;
                    echo '</li>';

                    if (($page - 2) > 1)
                    {
                        echo '<li class="jr-pagenav-nb"><a  class="jr-pagenav-nb" href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid . '&amp;page=1') . '">1</a></li>';
                        echo "<li class=\"jr-pagenav-nb\">...&nbsp;</li>";
                    }

                    for ($i = ($page - 2) <= 0 ? 1 : ($page - 2); $i <= $page + 2 && $i <= ceil($total / $threads_per_page); $i++)
                    {
                        if ($page == $i) {
                            echo "<li class=\"jr-pagenav-nb-act\">$i</li>";
                        }
                        else {
                            echo '<li class="jr-pagenav-nb"><a  class="jr-pagenav-nb" href="'
                                     . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid . '&amp;page=' . $i) . '">' . $i . '</a></li>';
                        }
                    }

                    if ($page + 2 < ceil($total / $threads_per_page))
                    {
                        echo "<li class=\"jr-pagenav-nb\">...&nbsp;</li>";
                        echo
                            '<li class="jr-pagenav-nb"><a  class="jr-pagenav-nb" href="'
                                . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid . '&amp;page=' . ceil($total / $threads_per_page)) . '">' . ceil($total / $threads_per_page) . '</a></li>';
                    }

                    echo '</ul></div>';
                }
                ?>
            </td>
        </tr>
    </table>
    <!-- /top nav -->

    <?php
    //get all readTopics in an array
    $readTopics = "";
    $database->setQuery("SELECT readtopics FROM #__fb_sessions WHERE userid=$my->id");
    $readTopics = $database->loadResult();

    if (count($readTopics) == 0) {
        $readTopics = "0";
    } //make sure at least something is in there..
    //make it into an array
    $read_topics = explode(',', $readTopics);

    if (count($messages) > 0)
    {
        if ($view == "flat")
            if (file_exists(JB_ABSTMPLTPATH . '/flat.php')) {
                include(JB_ABSTMPLTPATH . '/flat.php');
            }
            else {
                include(JB_ABSPATH . '/template/default/flat.php');
            }
        else if (file_exists(JB_ABSTMPLTPATH . '/thread.php')) {
            include(JB_ABSTMPLTPATH . '/thread.php');
        }
        else {
            include(JB_ABSPATH . '/template/default/thread.php');
        }
    }
    else
    {
        echo "<p align=\"center\">";
        echo '<br /><br />' . _SHOWCAT_NO_TOPICS;
        echo "</p>";
    }
    ?>
    <!-- bottom nav -->

    <table border = "0" cellspacing = "0" class = "jr-bottomnav" cellpadding = "0">
        <tr>
            <td class = "jr-topnav-left">
                <?php
                //go to top
                echo '<a name="forumbottom" /><a href="'.htmlspecialchars(sefRelToAbs("index.php?".$_SERVER["QUERY_STRING"])).'#forumtop" >';
                echo $fbIcons['toparrow'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['toparrow'] . '" border="0" alt="' . _GEN_GOTOTOP . '" title="' . _GEN_GOTOTOP . '"/>' : _GEN_GOTOTOP;
                echo '</a>';
                ?>

                <?php
                if ((($fbConfig['pubwrite'] == 0 && $my_id != 0) || $fbConfig['pubwrite'] == 1) && ($topicLock == 0 || ($topicLock == 1 && $is_moderator)))
                {
                    //this user is allowed to post a new topic:
                    if ($fbIcons['new_topic']) {
                        echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=post&amp;do=reply&amp;catid='
                                                           . $catid) . '"><img src="' . JB_URLICONSPATH . '' . $fbIcons['new_topic'] . '" alt="' . _GEN_POST_NEW_TOPIC . '" title="' . _GEN_POST_NEW_TOPIC . '" border="0" /></a>';
                    }
                    else {
                        echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=post&amp;do=reply&amp;catid=' . $catid) . '">' . _GEN_POST_NEW_TOPIC . '</a>';
                    }
                }

                echo '</td><td class="jr-topnav-right">';

                //pagination 1
                if (count($messages[0]) > 0)
                {
                    echo '<div class="jr-pagenav"><ul>';
                    echo '<li class="jr-pagenav-text">';
                    echo _PAGE;
                    echo '</li>';

                    if (($page - 2) > 1)
                    {
                        echo '<li class="jr-pagenav-nb"><a  class="jr-pagenav-nb" href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid . '&amp;page=1') . '">1</a></li>';
                        echo "<li class=\"jr-pagenav-nb\">...&nbsp;</li>";
                    }

                    for ($i = ($page - 2) <= 0 ? 1 : ($page - 2); $i <= $page + 2 && $i <= ceil($total / $threads_per_page); $i++)
                    {
                        if ($page == $i) {
                            echo "<li class=\"jr-pagenav-nb-act\">$i</li>";
                        }
                        else {
                            echo '<li class="jr-pagenav-nb"><a  class="jr-pagenav-nb" href="'
                                     . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid . '&amp;page=' . $i) . '">' . $i . '</a></li>';
                        }
                    }

                    if ($page + 2 < ceil($total / $threads_per_page))
                    {
                        echo "<li class=\"jr-pagenav-nb\">...&nbsp;</li>";
                        echo
                            '<li class="jr-pagenav-nb"><a  class="jr-pagenav-nb" href="'
                                . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid . '&amp;page=' . ceil($total / $threads_per_page)) . '">' . ceil($total / $threads_per_page) . '</a></li>';
                    }

                    echo '</ul></div>';
                }
                ?>
            </td>
        </tr>
    </table>
    <!-- -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
    <table class = "fb_blocktable"  id="fb_bottomarea" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
        <thead>
            <tr>
                <th class = "th-left" align="left" >
                    <?php
                    if ($my->id != 0)
                    {
                        echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=markThisRead&amp;catid=' . $catid) . '">';
                        echo $fbIcons['markThisForumRead']
                                 ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['markThisForumRead'] . '" border="0" alt="' . _GEN_MARK_THIS_FORUM_READ . '" title="' . _GEN_MARK_THIS_FORUM_READ . '"/>' : _GEN_MARK_THIS_FORUM_READ;
                        echo '</a>';
                    }
                    ?>
                    <!-- Mod List -->

                   
                        <?php
                        //get the Moderator list for display
                        $database->setQuery("select * from #__fb_moderation left join #__users on #__users.id=#__fb_moderation.userid where #__fb_moderation.catid=$catid");
                        $modslist = $database->loadObjectList();
                        ?>

                        <?php
                        if (count($modslist) > 0)
                        { ?>
                         <div class = "jr-bottomarea-modlist fbs">
                        <?php
                            echo '' . _GEN_MODERATORS . ": ";

                            foreach ($modslist as $mod) {
                                echo '&nbsp;<a href = "' . sefRelToAbs(FB_PROFILE_LINK_SUFFIX.''.$mod->userid).'">'.$mod->username.'</a>&nbsp; ';
                            } ?>
                             </div>
                            <?php
                        }
                        ?>
                   
                <!-- /Mod List -->
                </th>

                <th  class = "th-right fbs" align="right">
                    <?php
                    //(JJ) FINISH: CAT LIST BOTTOM
                    if ($fbConfig['enableForumJump'])
                        require_once (JB_ABSSOURCESPATH . 'fb_forumjump.php');
                    ?>
                </th>
            </tr>
        </thead>
        <!-- /bottom nav -->
        <tbody id = "fb-bottomarea_tbody">
            <tr class = "<?php echo $boardclass ;?>sectiontableentry1">
                <td class = "td-1 fbs" align="left">
                    <?php
                    if ($my->id != 0)
                    {
                        echo $fbIcons['unreadmessage'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['unreadmessage'] . '" border="0" alt="' . _GEN_UNREAD . '" title="' . _GEN_UNREAD . '" />' : $fbConfig['newChar'];
                        echo ' - ' . _GEN_UNREAD . '';
                    }
                    ?>

                    <br/>

                    <?php
                    if ($my->id != 0)
                    {
                        echo $fbIcons['readmessage'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['readmessage'] . '" border="0" alt="' . _GEN_NOUNREAD . '" title="' . _GEN_NOUNREAD . '"/>' : $fbConfig['newChar'];
                        echo ' - ' . _GEN_NOUNREAD . '';
                    }
                    ?>

                    <br/>

                <?php
                if ($moderatedForum == 1) {
                    echo $fbIcons['forummoderated'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['forummoderated']
                             . '" border="0" alt="' . _GEN_MODERATED . '" /> - ' . _GEN_MODERATED . '' : '  <img src="' . JB_URLEMOTIONSPATH . 'review.gif" border="0"  alt="' . _GEN_MODERATED . '" /> - ' . _GEN_MODERATED . '';
                }
                else {
                    echo "";
                }
                ?>
                </td>

                <td class = "td-2 fbs" align="left">
                    <?php
                    if ($topicLocked) {
                        echo
                            $fbIcons['topiclocked'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['topiclocked'] . '" border="0" alt="' . _GEN_LOCKED_TOPIC
                                . '" title="' . _GEN_LOCKED_TOPIC . '" /> - ' . _GEN_LOCKED_TOPIC . '' : '<img src="' . JB_URLEMOTIONSPATH . 'lock.gif" alt="' . _GEN_LOCKED_TOPIC . '" title="' . _GEN_LOCKED_TOPIC . '" /> - ' . _GEN_LOCKED_TOPIC . '';
                    }
                    ?>

                    <br/>

                    <?php
                    if ($topicSticky) {
                        echo $fbIcons['topicsticky'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['topicsticky'] . '" border="0" alt="'
                                 . _GEN_ISSTICKY . '" title="' . _GEN_ISSTICKY . '" /> - ' . _GEN_ISSTICKY . '' : '<img src="' . JB_URLEMOTIONSPATH . 'pushpin.gif" alt="' . _GEN_ISSTICKY . '" title="' . _GEN_ISSTICKY . '" /> - ' . _GEN_ISSTICKY . '';
                    }
                    ?>

                    <br/>

                        <?php
                        if ($lockedForum == 1)
                        {
                            echo $fbIcons['forumlocked'] ? '<img src="' . JB_URLICONSPATH . '' . $fbIcons['forumlocked']
                                     . '" border="0" alt="' . _GEN_LOCKED_FORUM . '" /> - ' . _GEN_LOCKED_FORUM . '' : '  <img src="' . JB_URLEMOTIONSPATH . 'lock.gif" border="0"   alt="' . _GEN_LOCKED_FORUM . '" /> - ' . _GEN_LOCKED_FORUM . '';
                            echo '<br />';
                        }
                        else {
                            echo "";
                        }
                        ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
<?php
}
else
{
?>
    <!-- e jump -->

    <div>
        <?php
        echo _FB_NO_ACCESS;

        if ($fbConfig['enableForumJump'])
        {
        ?>

            <form id = "jumpto" name = "jumpto" method = "post" target = "_self" action = "index.php" onsubmit = "if(document.jumpto.catid.value &lt; 2){return false;}">
                <div style = "width: 100%" align = "right">
                    <input type = "hidden" name = "Itemid" value = "<?php echo FB_FB_ITEMID;?>"/>

                    <input type = "hidden" name = "option" value = "com_fireboard"/>

                    <input type = "hidden" name = "func" value = "showcat"/>

                    <input type = "submit" name = "Go"  class="fbs" value = "<?php echo _FB_GO; ?>"/>

                    <select name = "catid" class="fbs" onchange = "if(this.options[this.selectedIndex].value > 0){ forms['jumpto'].submit() }">
                        <option name = "" SELECTED><?php echo _GEN_FORUM_JUMP; ?></option>

                        <?php
                        showChildren(0, "", $allow_forum);
                        ?>
                    </select>
                </div>
            </form>
    </div>
    <!-- /e jump -->

<?php
        }
}

function showChildren($category, $prefix = "", &$allow_forum)
{
    global $database;
    $database->setQuery("SELECT id, name, parent FROM #__fb_categories WHERE parent='$category'  and published='1' order by ordering");
    $forums = $database->loadObjectList();

    foreach ($forums as $forum)
    {
        if (in_array($forum->id, $allow_forum)) {
            echo("<option value=\"{$forum->id}\">$prefix {$forum->name}</option>");
        }

        showChildren($forum->id, $prefix . "---", $allow_forum);
    }
}
?>

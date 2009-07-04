<?php
/**
* @version $Id: post.php 511 2007-12-18 19:20:59Z danialt $
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
defined ('_JEXEC') or die('Direct Access to this location is not allowed.');
global $fbConfig;

// For joomla mambot support
if ($fbConfig['jmambot'])
{
    class t
    {
        var $text = "";
    }
}

//
//ob_start();
$catid = (int)$catid;
$pubwrite = (int)$pubwrite;
//ip for floodprotection, post logging, subscriptions, etcetera
$ip = $_SERVER["REMOTE_ADDR"];
//reset variables used
// ERROR: mixed global $editmode
global $editmode;
$editmode = 0;
// $message=mosGetParam($_POST, 'message','',1); // For some reason this just doesn't work like it should
$message = mosGetParam($_REQUEST, "message", null, _MOS_ALLOWRAW);
$resubject = mosGetParam($_REQUEST, "resubject", null);

// Begin captcha
if ($fbConfig['captcha'] == 1 && $my->id < 1) {
    session_start();
    $number = $_POST['txtNumber'];

    if ($message != NULL)
    {
        if (md5($number) != $_SESSION['image_random_value'])
        {
            $mess = _FB_CAPERR;
            echo "<script language='javascript' type='text/javascript'>alert('" . $mess . "')</script>";
            echo "<script language='javascript' type='text/javascript'>window.history.back()</script>";
            return;
            die();
            //break;
        }
    }
}

// Finish captcha

//flood protection
$fbConfig['floodprotection'] = (int)$fbConfig['floodprotection'];

if ($fbConfig['floodprotection'] != 0)
{
    $database->setQuery("select max(time) from #__fb_messages where ip='{$ip}'");
    $lastPostTime = $database->loadResult();
}

if (($fbConfig['floodprotection'] != 0 && ((($lastPostTime + $fbConfig['floodprotection']) < $systime) || $do == "edit" || $is_admin)) || $fbConfig['floodprotection'] == 0)
{
    //Let's find out who we're dealing with if a registered user wants to make a post
    $my = &JFactory::getUser();
    if ($my->id)
    {
        if ($my->email)
        {
            $my_name = $fbConfig['username'] ? $my->username : $my->name;
            $my_email = $my->email;
            $registeredUser = 1;
        }
        else
        {
            echo _POST_ERROR . "(user seems valid, but missing email addr) <br />";
            echo _POST_EXIT;
            return;
        }
    }
}
else
{
    echo _POST_TOPIC_FLOOD1;
    echo $fbConfig['floodprotection'] . " " . _POST_TOPIC_FLOOD2 . "<br />";
    echo _POST_TOPIC_FLOOD3;
    return;
}

//Now find out the forumname to which the user wants to post (for reference only)
unset($objCatInfo);
$database->setQuery("SELECT * FROM #__fb_categories WHERE id={$catid}");
$objCatInfo = $database->loadObject();
$catName = $objCatInfo->name;
?>

<table border = "0" cellspacing = "0" cellpadding = "0" width = "100%" align = "center">
    <tr>
        <td>
            <?php
            if (file_exists(JB_ABSTMPLTPATH . '/fb_pathway.php')) {
                require_once (JB_ABSTMPLTPATH . '/fb_pathway.php');
            }
            else {
                require_once (JB_ABSPATH . '/template/default/fb_pathway.php');
            }

            if ($action == "post" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig['pubwrite'], $is_moderator)))
            {
            ?>

                <table border = "0" cellspacing = "1" cellpadding = "3" width = "70%" align = "center" class = "contentpane">
                    <tr>
                        <td>
                            <?php
                            $parent = (int)$parentid;

                            if (empty($fb_authorname)) {
                                echo _POST_FORGOT_NAME;
                            }
                            else if (empty($subject)) {
                                echo _POST_FORGOT_SUBJECT;
                            }
                            else if (empty($message)) {
                                echo _POST_FORGOT_MESSAGE;
                            }
                            else
                            {
                                if ($parent == 0) {
                                    $thread = $parent = 0;
                                }

                                $database->setQuery("SELECT id,thread,parent FROM #__fb_messages WHERE id={$parent}");
                                unset($m);
                                $m = $database->loadObject();

                                if (count($m) < 1)
                                {
                                    // bad parent, create a new post
                                    $parent = 0;
                                    $thread = 0;
                                }
                                else
                                {

                                    $thread = $m->parent == 0 ? $m->id : $m->thread;
                                }

                                if ($catid == 0) {
                                    $catid = 1; //make sure there's a proper category
                                }

                                if ($attachfile != '')
                                {
                                    $noFileUpload = 0;
                                    $GLOBALS['FB_rc'] = 1;
                                    include (JB_ABSSOURCESPATH . 'fb_file_upload.php');

                                    if ($GLOBALS['FB_rc'] == 0) {
                                        $noFileUpload = 1;
                                    }
                                }

                                if ($attachimage != '')
                                {
                                    $noImgUpload = 0;
                                    $GLOBALS['FB_rc'] = 1;
                                    include (JB_ABSSOURCESPATH . 'fb_image_upload.php');

                                    if ($GLOBALS['FB_rc'] == 0) {
                                        $noImgUpload = 1;
                                    }
                                }

                                $messagesubject = $subject; //before we add slashes and all... used later in mail

                                $fb_authorname = trim(addslashes($fb_authorname));
                                $subject = trim(addslashes($subject));
                                $message = trim(addslashes($message));

                                if ($contentURL != "empty") {
                                    $message = $contentURL . '\n\n' . $message;
                                }


                                //--
                                $email = trim(addslashes($email));
                                $topic_emoticon = (int)$topic_emoticon;
                                $topic_emoticon = $topic_emoticon > 7 ? 0 : $topic_emoticon;
                                $posttime = FBTools::fbGetInternalTime();
                                //check if the post must be reviewed by a Moderator prior to showing
                                //doesn't apply to admin/moderator posts ;-)
                                $holdPost = 0;

                                if (!$is_moderator)
                                {
                                    $database->setQuery("SELECT review FROM #__fb_categories WHERE id={$catid}");
                                    $holdPost = $database->loadResult();
                                }

                                //
                                // Final chance to check whether or not to proceed
                                // DO NOT PROCEED if there is an exact copy of the message already in the db
                                //
                                $duplicatetimewindow = $posttime - JB_SESSION_TIMEOUT;
                                unset($existingPost);
                                $database->setQuery("SELECT id FROM #__fb_messages JOIN #__fb_messages_text ON id=mesid WHERE userid={$my->id} AND name='$fb_authorname' AND email='$email' AND subject='$subject' AND ip='$ip' AND message='$message' AND time>='$duplicatetimewindow'");
                                
                                if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());

                                $existingPost = $database->loadObject();
                                $pid = $existingPost->id;
                                
                                // echo 'pid: '.$pid;
                                // echo ' query: '.$database->GetQuery();

                                if ($pid=='')
                                {
                                    $database->setQuery(
                                    "INSERT INTO #__fb_messages (parent,thread,catid,name,userid,email,subject,time,ip,topic_emoticon,hold) VALUES('$parent','$thread','$catid','$fb_authorname','{$my->id}','$email','$subject','$posttime','$ip','$topic_emoticon','$holdPost')");
    
    			                    if ($database->query()) 
                                    {
                                        $pid = $database->insertId();
    
                                        // now increase the #s in categories only case approved
                                        if($holdPost==0) {
                                          FBTools::modifyCategoryStats($pid, $parent, $posttime, $catid);
                                        }
    
                                        $database->setQuery("INSERT INTO #__fb_messages_text (mesid,message) VALUES('$pid','$message')");
                                        $database->query();
    
                                        if ($thread == 0)
                                        {
                                            //if thread was zero, we now know to which id it belongs, so we can determine the thread and update it
                                            $database->setQuery("UPDATE #__fb_messages SET thread='$pid' WHERE id='$pid'");
                                            $database->query();
                                        }
    
                                        //update the user posts count
                                        if ($my->id)
                                        {
                                            $database->setQuery("UPDATE #__fb_users SET posts=posts+1 WHERE userid={$my->id}");
                                            $database->query();
                                        }
    
                                        //Update the attachments table if an image has been attached
                                        if ($imageLocation != "" && !$noImgUpload)
                                        {
                                            $database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$pid','$imageLocation')");
    
                                            if (!$database->query()) {
                                                echo "<script> alert('Storing image failed: " . $database->getErrorMsg() . "'); </script>\n";
                                            }
                                        }
    
                                        //Update the attachments table if an file has been attached
                                        if ($fileLocation != "" && !$noFileUpload)
                                        {
                                            $database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$pid','$fileLocation')");
    
                                            if (!$database->query()) {
                                                echo "<script> alert('Storing file failed: " . $database->getErrorMsg() . "'); </script>\n";
                                            }
                                        }
    
                                        //Now manage the subscriptions (only if subscriptions are allowed)
                                        if ($fbConfig['allowsubscriptions'] == 1)
                                        { //they're allowed
                                            //get the proper user credentials for each subscription to this topic
                                            if ($thread == 0) {
                                                $querythread = $pid;
                                            }
                                            else {
                                                $querythread = $thread;
                                            }
    
                                            //clean up the message
                                            $mailmessage = smile::purify($message);
                                            $database->setQuery("SELECT * FROM #__fb_subscriptions AS a"
                                            . "\n LEFT JOIN #__users as u ON a.userid=u.id "
                                            . "\n WHERE a.thread= {$querythread}");
    
                                            $subsList = $database->loadObjectList();
                                            //construct a useable URL (for plaintext - so no &amp; encoding!)
                                            $messageUrl = sefRelToAbs(JB_LIVEURLREL . "&func=view&catid=$catid&id=$pid") . "#$pid";
    
                                            if (count($subsList) > 0)
                                            {                                                     //we got more than 0 subscriptions
                                                require_once (JB_ABSSOURCESPATH . 'fb_mail.php'); // include fbMail class for mailing
    
                                                foreach ($subsList as $subs)
                                                {
                                                    $mailsubject = "$_COM_A_NOTIFICATION "._GEN_SUBJECT.": '" . stripslashes($messagesubject) . "' "._FB_IN_FORUM." '" . stripslashes($catName) . "'";
                                                    $msg = "$subs->name,\n";
                                                    $msg .= "$_COM_A_NOTIFICATION1 $board_title "._FB_FORUM."\n";
                                                    $msg .= _GEN_SUBJECT.": '" . stripslashes($messagesubject) . "' "._FB_IN_FORUM." '" . stripslashes($catName) . "'\n";
                                                    $msg .= _VIEW_POSTED.": " . stripslashes($fb_authorname) . "\n\n";
                                                    $msg .= "$_COM_A_NOTIFICATION2\n";
                                                    $msg .= "URL: $messageUrl\n\n";
                                                    if ($fbConfig['mailfull'] == 1) {
                                                        $msg .= _GEN_MESSAGE.":\n";
                                                        $msg .= stripslashes($mailmessage);
                                                    }
                                                    $msg .= "\n\n";
                                                    $msg .= "$_COM_A_NOTIFICATION3\n";
                                                    $msg .= "\n\n\n\n\n";
                                                    $msg .= "** Powered by FireBoard **\n";
                                                    $msg .= "** Best of Joomla! - http://www.bestofjoomla.com **";
    
                                                    if ($ip != "127.0.0.1" && $my->id != $subs->id) { //don't mail yourself
                                                        mosmail($fbConfig['email'], _FB_FORUM_AT." " . $_SERVER['SERVER_NAME'], $subs->email, $mailsubject, $msg);
                                                    }
                                                }
                                            }
                                        }
    
                                        //Now manage the mail for moderator or admins (only if configured)
                                        if($fbConfig['mailmod']=='1'
                                        || $fbConfig['mailadmin']=='1')
                                        { //they're configured
                                            //get the proper user credentials for each moderator for this forum
                                            $sql = "SELECT * FROM #__users AS u";
                                            if($fbConfig['mailmod']==1) {
                                                $sql .= "\n LEFT JOIN #__fb_moderation AS a";
                                                $sql .= "\n ON a.userid=u.id";
                                                $sql .= "\n  AND a.catid=$catid";
                                            }
                                            $sql .= "\n WHERE 1=1";
                                            $sql .= "\n AND (";
                                            // helper for OR condition
                                            $sql2 = '';
                                            if($fbConfig['mailmod']==1) {
                                                $sql2 .= " a.userid IS NOT NULL";
                                            }
                                            if($fbConfig['mailadmin']==1) {
                                                if(strlen($sql2)) { $sql2 .= "\n  OR "; }
                                                $sql2 .= " u.sendEmail=1";
                                            }
                                            $sql .= "\n".$sql2;
                                            $sql .= "\n)";
    
                                            $database->setQuery($sql);
                                            $modsList = $database->loadObjectList();
    
                                            if (count($modsList) > 0)
                                            {                                                     //we got more than 0 moderators eligible for email
                                                require_once (JB_ABSSOURCESPATH . 'fb_mail.php'); // include fbMail class for mailing
    
                                                foreach ($modsList as $mods)
                                                {
                                                    $mailsubject = "$_COM_A_NOTIFICATION "._GEN_SUBJECT.": '" . stripslashes($messagesubject) . "' "._FB_IN_FORUM." '" . stripslashes($catName) . "'";
                                                    $msg = "$mods->name,\n";
                                                    $msg .= "$_COM_A_NOT_MOD1 $board_title "._FB_FORUM."\n";
                                                    $msg .= _GEN_SUBJECT.": '" . stripslashes($messagesubject) . "' "._FB_IN_FORUM." '" . stripslashes($catName) . "'\n";
                                                    $msg .= _VIEW_POSTED.": " . stripslashes($fb_authorname) . "\n\n";
                                                    $msg .= "$_COM_A_NOT_MOD2\n";
                                                    $msg .= "URL: $messageUrl\n\n";
                                                    if ($fbConfig['mailfull'] == 1) {
                                                        $msg .= _GEN_MESSAGE.":\n";
                                                        $msg .= stripslashes($mailmessage);
                                                    }
                                                    $msg .= "\n\n";
                                                    $msg .= "$_COM_A_NOTIFICATION3\n";
                                                    $msg .= "\n\n\n\n\n";
                                                    $msg .= "** Powered by FireBoard **\n";
                                                    $msg .= "** Best of Joomla! - http://www.bestofjoomla.com **";
    
                                                    if ($ip != "127.0.0.1" && $my->id != $mods->id) { //don't mail yourself
                                                        //Send away
                                                        mosmail($fbConfig['email'], "Forum at " . $_SERVER['SERVER_NAME'], $mods->email, $mailsubject, $msg);
                                                    }
                                                }
                                            }
                                        }
    
                                        //now try adding any new subscriptions if asked for by the poster
                                        if ($subscribeMe == 1)
                                        {
                                            if ($thread == 0) {
                                                $fb_thread = $pid;
                                            }
                                            else {
                                                $fb_thread = $thread;
                                            }
    
                                            $database->setQuery("INSERT INTO #__fb_subscriptions (thread,userid) VALUES ('$fb_thread','{$my->id}')");
    
                                            if ($database->query()) {
                                                echo _POST_SUBSCRIBED_TOPIC . "<br /><br />";
                                            }
                                            else {
                                                echo _POST_NO_SUBSCRIBED_TOPIC . "<br /><br />";
                                            }
                                        }
    
                                        if ($holdPost == 1) {
                                            echo _POST_SUCCES_REVIEW . ' <a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _GEN_CONTINUE . '</a>.';
                                        }
                                        else
                                        {
                                            echo '<div align="center">' . _POST_SUCCESS_POSTED . '<br /><br />';
                                            echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '#' . $pid . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                                            echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                                            echo '</div>';
                                ?>
    
                                        <script language = "javascript">
                                        setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$pid).'#'.$pid;?>'", 3500);
                                        </script>
    
                                <?php
                                        }
                                    }
                                    else {
                                        echo _POST_ERROR_MESSAGE;
                                    }
                                }
                                else
                                // We get here in case we have detected a double post
                                // We did not do any further processing and just display the success message
                                // In the future we could define a specific message for ignored double posts
                                {
                                    echo '<div align="center">' . _POST_SUCCESS_POSTED . '<br /><br />';
                                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '#' . $pid . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                                    echo '</div>';
                        ?>

                                <script language = "javascript">
                                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$pid).'#'.$pid;?>'", 3500);
                                </script>

                        <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                </table>

            <?php
            }
            else if ($action == "cancel")
            {
                echo '<br /><br /><div align="center">' . _SUBMIT_CANCEL . "</div><br />";
                echo '<div align="center">' . _SUBMIT_CANCEL . '<br /><br />';
                echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $pid) . '#' . $pid . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                echo '</div>';

		?>
                                    <script language = "javascript">
                                        setTimeout("location='<?php echo sefRelToAbs(str_replace('&amp;', '&', JB_LIVEURLREL).'&func=view&catid='.$catid.'&id='.$pid).'#'.$pid;?>'", 3500);
                                    </script>

		<?php
            }
            else
            {
                if ($do == "quote" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig['pubwrite'], $is_moderator)))
                { //reply do quote
                    $parentid = 0;
                    $replyto = (int)$replyto;

                    if ($replyto > 0)
                    {
                        $database->setQuery("SELECT #__fb_messages.*,#__fb_messages_text.message FROM #__fb_messages,#__fb_messages_text WHERE id={$replyto} AND mesid={$replyto}");
                        $database->query();

                        if ($database->getNumRows() > 0)
                        {
                            unset($message);
                            $message = $database->loadObject();

                            // don't forget stripslashes
                            //$message->message=smile::smileReplace($message->message,0);
			    $table = array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES));
                            //$quote = strtr($message->message, $table);
                            $quote = $message->message;

                            $htmlText = "[b]" . stripslashes($message->name) . " " . _POST_WROTE . ":[/b]\n";
                            $htmlText .= '[quote]' . $quote . "[/quote]";
                            //$quote = smile::fbStripHtmlTags($quote);
                            $resubject = strtr($message->subject, $table);

                            $resubject = strtolower(substr($resubject, 0, strlen(_POST_RE))) == strtolower(_POST_RE) ? stripslashes($resubject) : _POST_RE . stripslashes($resubject);
                            //$resubject = htmlspecialchars($resubject);
                            $resubject = smile::fbStripHtmlTags($resubject);
                            //$resubject = smile::fbStripHtmlTags($resubject);
                            $parentid = $message->id;
                            $authorName = $my_name;
                        }
                    }
            ?>

                    <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL.'&amp;func=post'); ?>" method = "post" name = "postform" enctype = "multipart/form-data">
                        <input type = "hidden" name = "parentid" value = "<?php echo $parentid;?>"/>

                        <input type = "hidden" name = "catid" value = "<?php echo $catid;?>"/>

                        <input type = "hidden" name = "action" value = "post"/>

                        <input type = "hidden" name = "contentURL" value = "empty"/>

                        <?php
                        //get the writing stuff in:
                        $no_upload = "0"; //only edit mode should disallow this

                        if (file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')) {
                            include (JB_ABSTMPLTPATH . '/fb_write.html.php');
                        }
                        else {
                            include (JB_ABSPATH . '/template/default/fb_write.html.php');
                        }
                        //--
                        //echo "</form>";
                }
                else if ($do == "reply" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig['pubwrite'], $is_moderator)))
                { // reply no quote
                    $parentid = 0;
                    $replyto = (int)$replyto;
                    $setFocus = 0;

                    if ($replyto > 0)
                    {
                        $database->setQuery('SELECT #__fb_messages.*,#__fb_messages_text.message'
                        . "\n" . 'FROM #__fb_messages,#__fb_messages_text'
                        . "\n" . 'WHERE id=' . $replyto . ' AND mesid=' . $replyto);
                        $database->query();

                        if ($database->getNumRows() > 0)
                        {
                            unset($message);
                            $message = $database->loadObject();
                            $table = array_flip(get_html_translation_table(HTML_ENTITIES));
                            $resubject = htmlspecialchars(strtr($message->subject, $table));
                            $resubject = strtolower(substr($resubject, 0, strlen(_POST_RE))) == strtolower(_POST_RE) ? stripslashes($resubject) : _POST_RE . stripslashes($resubject);
                            $parentid = $message->id;
                            $htmlText = "";
                        }
                    }

                    $authorName = $my_name;
                        ?>

                    <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL . '&amp;func=post'); ?>" method = "post" name = "postform" enctype = "multipart/form-data">
                        <input type = "hidden" name = "parentid" value = "<?php echo $parentid;?>"/>

                        <input type = "hidden" name = "catid" value = "<?php echo $catid;?>"/>

                        <input type = "hidden" name = "action" value = "post"/>

                        <input type = "hidden" name = "contentURL" value = "empty"/>

                        <?php
                        //get the writing stuff in:
                        $no_upload = "0"; //only edit mode should disallow this

                        if (file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')) {
                            include (JB_ABSTMPLTPATH . '/fb_write.html.php');
                        }
                        else {
                            include (JB_ABSPATH . '/template/default/fb_write.html.php');
                        }
                        //--
                        //echo "</form>";
                }
                else if ($do == "newFromBot" && (hasPostPermission($database, $catid, $replyto, $my->id, $fbConfig['pubwrite'], $is_moderator)))
                { // The Mosbot "discuss on forums" has detected an unexisting thread and wants to create one
                    $parentid = 0;
                    $replyto = (int)$replyto;
                    $setFocus = 0;
                    //                $resubject = base64_decode($resubject); //per mf#6100  -- jdg 16/07/2005
                    $resubject = base64_decode(strtr($resubject, "()", "+/"));
                    $resubject = str_replace("%20", " ", $resubject);
                    $resubject = preg_replace('/%32/', '&', $resubject);
                    $resubject = preg_replace('/%33/', ';', $resubject);
                    $resubject = preg_replace("/\'/", '&#039;', $resubject);
                    $resubject = preg_replace("/\"/", '&quot;', $resubject);
                    //$table = array_flip(get_html_translation_table(HTML_ENTITIES));
                    //$resubject = strtr($resubject, $table);
                    $fromBot = 1; //this new topic comes from the discuss mambot
                    $authorName = htmlspecialchars($my_name);
                    $rowid = mosGetParam($_REQUEST, 'rowid', 0);
                    $rowItemid = mosGetParam($_REQUEST, 'rowItemid', 0);

                    if ($rowItemid) {
                        $contentURL = sefRelToAbs('index.php?option=com_content&amp;task=view&amp;Itemid=' . $rowItemid . '&amp;id=' . $rowid);
                    }
                    else {
                        $contentURL = sefRelToAbs('index.php?option=com_content&amp;task=view&amp;Itemid=1&amp;id=' . $rowid);
                    }

                    $contentURL = _POST_DISCUSS . ': [url=' . $contentURL . ']' . $resubject . '[/url]';
                        ?>

                    <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL."&amp;func=post");?>" method = "post" name = "postform" enctype = "multipart/form-data">
                        <input type = "hidden" name = "parentid" value = "<?php echo $parentid;?>"/>

                        <input type = "hidden" name = "catid" value = "<?php echo $catid;?>"/>

                        <input type = "hidden" name = "action" value = "post"/>

                        <input type = "hidden" name = "contentURL" value = "<?php echo $contentURL ;?>"/>

                        <?php
                        //get the writing stuff in:
                        $no_upload = "0"; //only edit mode should disallow this

                        if (file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')) {
                            include (JB_ABSTMPLTPATH . '/fb_write.html.php');
                        }
                        else {
                            include (JB_ABSPATH . '/template/default/fb_write.html.php');
                        }
                        //--
                        //echo "</form>";
                }
                else if ($do == "edit")
                {
                    $allowEdit = 0;
                    $id = (int)$id;
                    $database->setQuery("SELECT * FROM #__fb_messages LEFT JOIN #__fb_messages_text ON #__fb_messages.id=#__fb_messages_text.mesid WHERE #__fb_messages.id=$id");
                    $message1 = $database->loadObjectList();
                    $mes = $message1[0];

                    $userID = $mes->userid;

                    //Check for a moderator or superadmin
                    if ($is_moderator) {
                        $allowEdit = 1;
                    }

                    if ($fbConfig['useredit'] == 1 && $my->id != "")
                    {
                        //Now, if the author==viewer and the viewer is allowed to edit his/her own post the let them edit
                        if ($my->id == $userID) {
                            if(((int)$fbConfig['usereditTime'])==0) {
                                $allowEdit = 1;
                            }
                            else {
                                //Check whether edit is in time
                                $modtime = $mes->modified_time;
                                if(!$modtime) {
                                    $modtime = $mes->time;
                                }
                                if(($modtime + ((int)$fbConfig['usereditTime'])) >= FBTools::fbGetInternalTime()) {
                                    $allowEdit = 1;
                                }
                            }
                        }
                    }

                    if ($allowEdit == 1)
                    {
                        //we're now in edit mode
                        $editmode = 1;

                        /*foreach ($message1 as $mes)
                        {*/

                        //$htmlText = smile::fbStripHtmlTags($mes->message);
                        $htmlText = $mes->message;
                        $table = array_flip(get_html_translation_table(HTML_ENTITIES));

                        //$htmlText = strtr($htmlText, $table);

                        //$htmlText = smile::fbHtmlSafe($htmlText);
                        $resubject = htmlspecialchars(stripslashes($mes->subject));
                        $authorName = htmlspecialchars($mes->name);
                        ?>

                        <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL."&amp;catid=$catid&amp;func=post"); ?>" method = "post" name = "postform" enctype = "multipart/form-data"/>

                        <input type = "hidden" name = "id" value = "<?php echo $mes->id;?>"/>

                        <input type = "hidden" name = "do" value = "editpostnow"/>

                        <?php
                        //get the writing stuff in:
                        //first check if there is an uploaded image or file already for this post (no new ones allowed)
                        $no_file_upload = 0;
                        $no_image_upload = 0;
                        $database->setQuery("SELECT filelocation FROM #__fb_attachments WHERE mesid='$id'");
                        $attachments = $database->loadObjectList();

                        if (count($attachments > 0))
                        {
                            foreach ($attachments as $att)
                            {
                                if (preg_match("&/fbfiles/files/&si", $att->filelocation)) {
                                    $no_file_upload = "1";
                                }

                                if (preg_match("&/fbfiles/images/&si", $att->filelocation)) {
                                    $no_image_upload = "1";
                                }
                            }
                        }
                        else {
                            $no_upload = "0";
                        }

                        if (file_exists(JB_ABSTMPLTPATH . '/fb_write.html.php')) {
                            include (JB_ABSTMPLTPATH . '/fb_write.html.php');
                        }
                        else {
                            include (JB_ABSPATH . '/template/default/fb_write.html.php');
                        }
                        //echo "</form>";
                        //}
                    }
                    else {
                        echo "Hacking attempt!";
                    }
                }
                else if ($do == "editpostnow")
                {
                    $modified_reason = addslashes(mosGetParam($_POST, "modified_reason", null));
                    $modified_by = $my->id;
                    $modified_time = FBTools::fbGetInternalTime();
                    $id  = (int) $id;

		    print "HUHU";
		    
                    $database->setQuery("SELECT * FROM #__fb_messages LEFT JOIN #__fb_messages_text ON #__fb_messages.id=#__fb_messages_text.mesid WHERE #__fb_messages.id=$id");
                    $message1 = $database->loadObjectList();
                    $mes = $message1[0];
                    $userid = $mes->userid;

                    //Check for a moderator or superadmin
                    if ($is_moderator) {
                        $allowEdit = 1;
                    }

                    if ($fbConfig['useredit'] == 1 && $my->id != "")
                    {
                        //Now, if the author==viewer and the viewer is allowed to edit his/her own post the let them edit
                        if ($my->id == $userid) {
                            if(((int)$fbConfig['usereditTime'])==0) {
                                $allowEdit = 1;
                            }
                            else {
                                $modtime = $mes->modified_time;
                                if(!$modtime) {
                                    $modtime = $mes->time;
                                }
                                if(($modtime + ((int)$fbConfig['usereditTime']) + ((int)$fbConfig['usereditTimeGrace'])) >= FBTools::fbGetInternalTime()) {
                                    $allowEdit = 1;
                                }
                            }
                        }
                    }

                    if ($allowEdit == 1)
                    {
                        if ($attachfile != '') {
                            include JB_ABSSOURCESPATH . 'fb_file_upload.php';
                        }

                        if ($attachimage != '') {
                            include JB_ABSSOURCESPATH . 'fb_image_upload.php';
                        }

                        //$message = trim(htmlspecialchars(addslashes($message)));
                        $message = trim(addslashes($message));

                        //parse the message for some preliminary bbcode and stripping of HTML
                        //$message = smile::bbencode_first_pass($message);

                        if (count($message1) > 0)
                        {
                            $database->setQuery(
                            "UPDATE #__fb_messages SET name='$fb_authorname', email='" . addslashes($email)
                            . (($fbConfig['editMarkUp']) ? "' ,modified_by='" . $modified_by
                            . "' ,modified_time='" . $modified_time . "' ,modified_reason='" . $modified_reason : "") . "', subject='" . addslashes($subject) . "', topic_emoticon='" . ((int)$topic_emoticon) . "' WHERE id={$id}");

                            $dbr_nameset = $database->query();
                            $database->setQuery("UPDATE #__fb_messages_text SET message='{$message}' WHERE mesid={$id}");

                            if ($database->query() && $dbr_nameset)
                            {
                                //Update the attachments table if an image has been attached
                                if ($imageLocation != "")
                                {
                                    $database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$id','$imageLocation')");

                                    if (!$database->query()) {
                                        echo "<script> alert('Storing image failed: " . $database->getErrorMsg() . "'); </script>\n";
                                    }
                                }

                                //Update the attachments table if an file has been attached
                                if ($fileLocation != "")
                                {
                                    $database->setQuery("INSERT INTO #__fb_attachments (mesid, filelocation) values ('$id','$fileLocation')");

                                    if (!$database->query()) {
                                        echo "<script> alert('Storing file failed: " . $database->getErrorMsg() . "'); </script>\n";
                                    }
                                }

                                echo '<div align="center">' . _POST_SUCCESS_EDIT . '<br /><br />';
                                echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                                echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                                echo '</div>';?>                               
                                <script language = "javascript">
                                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$id).'#'.$id;?>'", 3500);
                                </script>
                            <?php
                            }
                            else {
                                echo _POST_ERROR_MESSAGE_OCCURED;
                            }
                        }
                        else {
                            echo _POST_INVALID;
                        }
                    }
                    else {
                        echo ("Hacking attempt");
                    }
                }
                else if ($do == "delete")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $id = (int)$id;
                    $database->setQuery("SELECT * FROM #__fb_messages WHERE id=$id");
                    $message = $database->loadObjectList();

                    foreach ($message as $mes)
                    {
                        ?>

                        <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL."&amp;catid=$catid&amp;func=post"); ?>" method = "post" name = "myform">
                            <input type = "hidden" name = "do" value = "deletepostnow"/>

                            <input type = "hidden" name = "id" value = "<?php echo $mes->id;?>"/> <?php echo _POST_ABOUT_TO_DELETE; ?>: <strong><?php echo stripslashes(htmlspecialchars($mes->subject)); ?></strong>.

    <br/>

    <br/> <?php echo _POST_ABOUT_DELETE; ?><br/>

    <br/>

    <input type = "checkbox" checked name = "delAttachments" value = "delAtt"/> <?php echo _POST_DELETE_ATT; ?>

    <br/>

    <br/>

    <a href = "javascript:document.myform.submit();"><?php echo _GEN_CONTINUE; ?></a> | <a href = "<?php echo sefRelToAbs(JB_LIVEURLREL."&amp;func=view&amp;catid=$catid;&amp;id=$id");?>"><?php echo _GEN_CANCEL; ?></a>
                        </form>

            <?php
                    }
                }
                else if ($do == "deletepostnow")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $id = (int)mosGetParam($_POST, 'id', '');
                    $dellattach = mosGetParam($_POST, 'delAttachments', '') == 'delAtt' ? 1 : 0;
                    $thread = fb_delete_post($database, $id, $dellattach);

                    switch ($thread)
                    {
                        case -1:
                            echo _POST_ERROR_TOPIC . '<br />';

                            echo _FB_POST_DEL_ERR_CHILD;
                            break;

                        case -2:
                            echo _POST_ERROR_TOPIC . '<br />';

                            echo _FB_POST_DEL_ERR_MSG;
                            break;

                        case -3:
                            echo _POST_ERROR_TOPIC . '<br />';

                            $tmpstr = _FB_POST_DEL_ERR_TXT;
                            $tmpstr = str_replace('%id%', $id, $tmpstr);
                            echo $tmpstr;
                            break;

                        case -4:
                            echo _POST_ERROR_TOPIC . '<br />';

                            echo _FB_POST_DEL_ERR_USR;
                            break;

                        default:
                            echo '<div align="center">' . _POST_SUCCESS_DELETE . '<br /><br />';

                            if ($do == 'deletepostnow') {
                                // echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $thread) . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                            }

                            echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                            echo '</div>';
                            echo '<script language="javascript">';

                            if ($do == 'deletetopicnow') {
                                echo 'setTimeout("location=\'' . sefRelToAbs(JB_LIVEURLREL . '&func=showcat&catid=' . $catid) . '\'",3500)';
                            }
                            else {
                                //echo 'setTimeout("location=\'' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $thread) . '\'",3500)';
                                echo 'setTimeout("location=\'' . sefRelToAbs(JB_LIVEURLREL . '&func=showcat&catid=' . $catid) . '\'",3500)';
                            }

                            echo '</script>';
                            break;
                    }
                } //fi $do==deletepostnow
                else if ($do == "move")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $catid = (int)$catid;
                    $id = (int)$id;
                    //get list of available forums
                    //$database->setQuery("SELECT id,name FROM #__fb_categories WHERE parent != '0'");
                    $database->setQuery("SELECT a.*, b.name AS category" . "\nFROM #__fb_categories AS a" . "\nLEFT JOIN #__fb_categories AS b ON b.id = a.parent" . "\nWHERE a.parent != '0'" . "\nORDER BY parent, ordering");
                    $catlist = $database->loadObjectList();
                    // get topic subject:
                    $database->setQuery("select subject from #__fb_messages where id=$id");
                    $topicSubject = $database->loadResult();
            ?>

                    <form action = "<?php echo sefRelToAbs(JB_LIVEURLREL."&amp;func=post"); ?>" method = "post" name = "myform">
                        <input type = "hidden" name = "do" value = "domovepost"/>

                        <input type = "hidden" name = "id" value = "<?php echo $id;?>"/>

                        <p>
<?php echo _GEN_TOPIC; ?>: <strong><?php echo $topicSubject; ?></strong>

    <br/>

    <br/> <?php echo _POST_MOVE_TOPIC; ?>:

    <br/>

    <select name = "catid" size = "15" class = "fb_move_selectbox">
        <?php
        foreach ($catlist as $cat) {
            echo "<OPTION value=\"$cat->id\" > $cat->category/$cat->name </OPTION>";
        }
        ?>
    </select>

    <br/>

    <input type = "checkbox" checked name = "leaveGhost" value = "1"/> <?php echo _POST_MOVE_GHOST; ?>

    <br/>

    <input type = "submit" class = "button" value = "<?php echo _GEN_MOVE;?>"/>
                    </form>

            <?php
                }
                else if ($do == "domovepost")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $catid = (int)$catid;
                    $id = (int)$id;
                    $bool_leaveGhost = (int)mosGetParam($_POST, 'leaveGhost', 0);
                    //get the some details from the original post for later
                    $database->setQuery("SELECT `subject`, `catid`, `time` AS timestamp FROM #__fb_messages WHERE `id`='$id'");
                    $oldRecord = $database->loadObjectList();
                    $newSubject = _MOVED_TOPIC . " " . $oldRecord[0]->subject;
                    $database->setQuery("SELECT MAX(time) AS timestamp FROM #__fb_messages WHERE `thread`='$id'");
                    $lastTimestamp = $database->loadResult();

                    if ($lastTimestamp == "") {
                        $lastTimestamp = $oldRecord[0]->timestamp;
                    }

                    //perform the actual move
                    //Move topic post first
                    $database->setQuery("UPDATE #__fb_messages SET `catid`='$catid' WHERE `id`='$id'");

                    if ($database->query())
                    { //succeeded; move the rest of the thread if exists
                        $database->setQuery("UPDATE #__fb_messages set `catid`='$catid' WHERE `thread`='$id'");

                        if ($database->query())
                        {
                            // insert 'moved topic' notification in old forum if needed
                            if ($bool_leaveGhost)
                            {
                                $database->setQuery("INSERT INTO #__fb_messages (`parent`, `subject`, `time`, `catid`, `moved`) VALUES ('0','$newSubject','" . $lastTimestamp . "','" . $oldRecord[0]->catid . "','1')");

                                if ($database->query())
                                {
                                    //determine the new location for link composition
                                    $newId = $database->insertid();

                                    $newURL = "catid=" . $catid . "&amp;id=" . $id;
                                    $database->setQuery("INSERT INTO #__fb_messages_text (`mesid`, `message`) VALUES ('$newId', '$newURL')");

                                    if (!$database->query()) {
                                        $database->stderr(true);
                                    }

                                    //and update the thread id on the 'moved' post for the right ordering when viewing the forum..
                                    $database->setQuery("UPDATE #__fb_messages SET `thread`='$newId' WHERE `id`='$newId'");

                                    if (!$database->query()) {
                                        $database->stderr(true);
                                    }
                                }
                                else {
                                    echo '<p style="text-align:center">' . _POST_GHOST_FAILED . '</p>';
                                }
                            }

                            //move succeeded
                            echo '<div align="center">' . _POST_SUCCESS_MOVE . '<br /><br />';
                            echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                            echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                            echo '</div>';
            ?>

                        <script language = "javascript">
                        setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$id); ?>'", 3500);
                        </script>

            <?php
                        }
                        else {
                            echo _FB_POST_MOV_ERR_DB;
                            //this is severe.. takes a lot of coding to programatically correct it. Won't do that.
                            //chances of this happening are very slim. Disclaimer: this is software as-is *lol*;
                            //go read the GPL and the header of this file..
                        }
                    }
                    else
                    {
            ?>

            <?php echo _POST_TOPIC_NOT_MOVED; ?>

<a href = "<?php echo sefRelToAbs(JB_LIVEURLREL."&amp;func=view&amp;catid=$catid&amp;id=$id");?>"><?php echo _POST_CLICK; ?></a>

            <?php
                    }
                }
                else if ($do == "subscribe")
                {
                    $catid = (int)$catid;
                    $id = (int)$id;
                    $database->setQuery("INSERT INTO #__fb_subscriptions (thread,userid) VALUES ('$fb_thread','$my->id')");

                    if ($database->query()) {
                        echo _POST_SUBSCRIBED_TOPIC . "<br /><br />";
                    }
                    else {
                        echo _POST_NO_SUBSCRIBED_TOPIC . "<br /><br />";
                    }

                    echo '<div align="center">' . _POST_SUCCESS_SUBSCRIBE . '<br /><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                    echo '</div>';
            ?>

                <script language = "javascript">
                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=userprofile&do=show'); ?>'", 3500);
                </script>

            <?php
                }
                else if ($do == "favorite")
                {
                    $catid = (int)$catid;
                    $id = (int)$id;
                    $database->setQuery("INSERT INTO #__fb_favorites (thread,userid) VALUES ('$fb_thread','$my->id')");

                    if ($database->query()) {
                        echo _POST_FAVORITED_TOPIC . "<br /><br />";
                    }
                    else {
                        echo _POST_NO_FAVORITED_TOPIC . "<br /><br />";
                    }

                    echo '<div align="center">' . _POST_SUCCESS_FAVORITE . '<br /><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                    echo '</div>';
            ?>

                <script language = "javascript">
                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=userprofile&do=show'); ?>'", 3500);
                </script>

            <?php
                }
                else if ($do == "sticky")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $database->setQuery("update #__fb_messages set ordering=1 where id=$id");

                    if ($database->query()) {
                        echo '<p align="center">' . _POST_STICKY_SET . '<br /><br />';
                    }
                    else {
                        echo '<p align="center">' . _POST_STICKY_NOT_SET . '<br /><br />';
                    }

                    echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                    echo '</div>';
            ?>

                <script language = "javascript">
                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$id);?>'", 3500);
                </script>

            <?php
                }
                else if ($do == "unsticky")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $database->setQuery("update #__fb_messages set ordering=0 where id=$id");

                    if ($database->query()) {
                        echo '<p align="center">' . _POST_STICKY_UNSET . '<br /><br />';
                    }
                    else {
                        echo '<p align="center">' . _POST_STICKY_NOT_UNSET . '<br /><br />';
                    }

                    echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                    echo '</div>';
            ?>

                <script language = "javascript">
                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$id) ;?>'", 3500);
                </script>

            <?php
                }
                else if ($do == "lock")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    //lock topic post
                    $database->setQuery("update #__fb_messages set locked=1 where id=$id");

                    if ($database->query()) {
                        echo '<p align="center">' . _POST_LOCK_SET . '<br /><br />';
                    }
                    else {
                        echo '<p align="center">' . _POST_LOCK_NOT_SET . '<br /><br />';
                    }

                    echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                    echo '</div>';
            ?>

                <script language = "javascript">
                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$id);?>'", 3500);
                </script>

            <?php
                }
                else if ($do == "unlock")
                {
                    if (!$is_moderator) {
                        die ("Hacking Attempt!");
                    }

                    $database->setQuery("update #__fb_messages set locked=0 where id=$id");

                    if ($database->query()) {
                        echo '<p align="center">' . _POST_LOCK_UNSET . '<br /><br />';
                    }
                    else {
                        echo '<p align="center">' . _POST_LOCK_NOT_UNSET . '<br /><br />';
                    }

                    echo '<div align="center">' . _POST_SUCCESS_REQUEST2 . '<br /><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=view&amp;catid=' . $catid . '&amp;id=' . $id) . '#' . $id . '">' . _POST_SUCCESS_VIEW . '</a><br />';
                    echo '<a href="' . sefRelToAbs(JB_LIVEURLREL . '&amp;func=showcat&amp;catid=' . $catid) . '">' . _POST_SUCCESS_FORUM . '</a><br />';
                    echo '</div>';
            ?>

                <script language = "javascript">
                setTimeout("location='<?php echo sefRelToAbs(JB_LIVEURLREL.'&func=view&catid='.$catid.'&id='.$id);?>'", 3500);
                </script>

            <?php
                }
            }
            ?>
        </td>
    </tr>
</table>

<?php
/**
 * Checks if a user has postpermission in given thread
 * @param database object
 * @param int
 * @param int
 * @param boolean
 * @param boolean
 */
function hasPostPermission($database, $catid, $replyto, $userid, $pubwrite, $ismod)
{
    global $fbConfig;

    if ($replyto != 0)
    {
        $database->setQuery("select thread from #__fb_messages where id='$replyto'");
        $topicID = $database->loadResult();
        $lockedWhat = _GEN_TOPIC;

        if ($topicID != 0) //message replied to is not the topic post; check if the topic post itself is locked
        {
            $sql = 'select locked from #__fb_messages where id=' . $topicID;
        }
        else {
            $sql = 'select locked from #__fb_messages where id=' . $replyto;
        }

        $database->setQuery($sql);
        $topicLock = $database->loadResult();
    }

    if ($topicLock == 0)
    { //topic not locked; check if forum is locked
        $database->setQuery("select locked from #__fb_categories where id=$catid");
        $topicLock = $database->loadResult();
        $lockedWhat = _GEN_FORUM;
    }

    if (($userid != 0 || $pubwrite) && ($topicLock == 0 || $ismod)) {
        return 1;
    }
    else
    {
        //user is not allowed to write a post
        if ($pubwrite)
        {
            echo "<p align=\"center\">$lockedWhat " . _POST_LOCKED . "<br />";
            echo _POST_NO_NEW . "<br /><br /></p>";
        }
        else
        {
            echo "<p align=\"center\">";
            echo _POST_NO_PUBACCESS1 . "<br />";
            echo _POST_NO_PUBACCESS2 . "<br /><br />";

            if ($fbConfig['cb_profile']) {
                echo '<a href="' . sefRelToAbs('index.php?option=com_comprofiler&amp;task=registers') . '">' . _POST_NO_PUBACCESS3 . '</a><br /></p>';
            }
            else {
                echo '<a href="' . sefRelToAbs('index.php?option=com_registration&amp;task=register') . '">' . _POST_NO_PUBACCESS3 . '</a><br /></p>';
            }
        }

        return 0;
    }
}
/**
 * Function to delete posts
 *
 * @param database object
 * @param int the id if the post to be deleted
 * @param boolean determines if we need to delete attachements as well
 *
 * @return int returns thread id if all went well, -1 to -4 are error numbers
**/
function fb_delete_post(&$database, $id, $dellattach)
{
    $database->setQuery('SELECT id,catid,parent,thread,subject,userid FROM #__fb_messages WHERE id=' . $id);

    if (!$database->query()) {
        return -2;
    }

    unset($mes);
    $mes = $database->loadObject();
    $thread = $mes->thread;

    if ($mes->parent == 0)
    {
        // this is the forum topic; if removed, all children must be removed as well.
        $children = array ();
        $userids = array ();
        $database->setQuery('SELECT userid,id, catid FROM #__fb_messages WHERE thread=' . $id . ' OR id=' . $id);

        foreach ($database->loadObjectList()as $line)
        {
            $children[] = $line->id;

            if ($line->userid > 0) {
                $userids[] = $line->userid;
            }
        }

        $children = implode(',', $children);
        $userids = implode(',', $userids);
    }
    else
    {
        //this is not the forum topic, so delete it and promote the direct children one level up in the hierarchy
        $database->setQuery('UPDATE #__fb_messages SET parent=\'' . $mes->parent . '\' WHERE parent=\'' . $id . '\'');

        if (!$database->query()) {
            return -1;
        }

        $children = $id;
        $userids = $mes->userid > 0 ? $mes->userid : '';
    }

    //Delete the post (and it's children when it's the first post)
    $database->setQuery('DELETE FROM #__fb_messages WHERE id=' . $id . ' OR thread=' . $id);

    if (!$database->query()) {
        return -2;
    }

    // now update stats
    FBTools::decreaseCategoryStats($id, $mes->catid);

    //Delete message text(s)
    $database->setQuery('DELETE FROM #__fb_messages_text WHERE mesid IN (' . $children . ')');

    if (!$database->query()) {
        return -3;
    }

    //Update user post stats
    if (count($userids) > 0)
    {
        $database->setQuery('UPDATE #__fb_users SET posts=posts-1 WHERE userid IN (' . $userids . ')');

        if (!$database->query()) {
            return -4;
        }
    }

    //Delete (possible) ghost post
    $database->setQuery('SELECT mesid FROM #__fb_messages_text WHERE message=\'catid=' . $mes->catid . '&amp;id=' . $id . '\'');
    $int_ghost_id = $database->loadResult();

    if ($int_ghost_id > 0)
    {
        $database->setQuery('DELETE FROM #__fb_messages WHERE id=' . $int_ghost_id);
        $database->query();
        $database->setQuery('DELETE FROM #__fb_messages_text WHERE mesid=' . $int_ghost_id);
        $database->query();
    }

    //Delete attachments
    if ($dellattach)
    {
        $database->setQuery('SELECT filelocation FROM #__fb_attachments WHERE mesid IN (' . $children . ')');
        $fileList = $database->loadObjectList();

        if (count($fileList) > 0)
        {
            foreach ($fileList as $fl) {
                unlink ($fl->filelocation);
            }

            $database->setQuery('DELETE FROM #__fb_attachments WHERE mesid IN (' . $children . ')');
            $database->query();
        }
    }

    return $thread; // all went well :-)
}

function listThreadHistory($id, $fbConfig, $database)
{
    if ($id != 0)
    {
        //get the parent# for the post on which 'reply' or 'quote' is chosen
        $database->setQuery("SELECT parent FROM #__fb_messages WHERE id='$id'");
        $this_message_parent = $database->loadResult();
        //Get the thread# for the same post
        $database->setQuery("SELECT thread FROM #__fb_messages WHERE id='$id'");
        $this_message_thread = $database->loadResult();

        //determine the correct thread# for the entire thread
        if ($this_message_parent == 0) {
            $thread = $id;
        }
        else {
            $thread = $this_message_thread;
        }

        //get all the messages for this thread
        $database->setQuery("SELECT * FROM #__fb_messages LEFT JOIN #__fb_messages_text ON #__fb_messages.id=#__fb_messages_text.mesid WHERE thread='$thread' OR id='$thread' AND hold = 0 ORDER BY time DESC LIMIT " . $fbConfig['historyLimit']);
        $messages = $database->loadObjectList();
        //and the subject of the first thread (for reference)
        $database->setQuery("SELECT subject FROM #__fb_messages WHERE id='$thread' and parent=0");
        $this_message_subject = $database->loadResult();
        echo "<b>" . _POST_TOPIC_HISTORY . ":</b> " . htmlspecialchars($this_message_subject) . " <br />" . _POST_TOPIC_HISTORY_MAX . " $historyLimit " . _POST_TOPIC_HISTORY_LAST . "<br />";
?>

        <table border = "0" cellspacing = "1" cellpadding = "3" width = "100%" class = "fb_review_table">
            <tr>
                <td class = "fb_review_header" width = "20%" align = "center">
                    <strong><?php echo _GEN_AUTHOR; ?></strong>
                </td>

                <td class = "fb_review_header" align = "center">
                    <strong><?php echo _GEN_MESSAGE; ?></strong>
                </td>
            </tr>

            <?php
            $k = 0;
            $smileyList = smile::getEmoticons(1);

            foreach ($messages as $mes)
            {
                $k = 1 - $k;
                $mes->name = htmlspecialchars($mes->name);
                $mes->email = htmlspecialchars($mes->email);
                $mes->subject = htmlspecialchars($mes->subject);


                $fb_message_txt = stripslashes(($mes->message));
                $fb_message_txt = smile::smileReplace($fb_message_txt, 1, $fbConfig['disemoticons'], $smileyList);
            ?>

                <tr>
                    <td class = "fb_review_body<?php echo $k;?>" valign = "top">
                        <?php echo stripslashes($mes->name); ?>
                    </td>

                    <td class = "fb_review_body<?php echo $k;?>">
                        <?php
                        $fb_message_txt = str_replace("</P><br />", "</P>", $fb_message_txt);
                        //Long Words Wrap:
                        $fb_message_txt = smile::htmlwrap($fb_message_txt, $fbConfig['wrap']);

                        // Joomla Mambot Support
                        if ($fbConfig['jmambot'])
                        {
                            global $_MAMBOTS;
                            $row = new t();
                            $row->text = $fb_message_txt;
                            $_MAMBOTS->loadBotGroup('content');
                            $params = &new mosParameters('');
                            $results = $_MAMBOTS->trigger('onPrepareContent', array
                            (
                            &$row,
                            &$params,
                            0
                            ), true);

                            $fb_message_txt = $row->text;
                        }
                        // Finish Joomla Mambot Support

                        if ($fbConfig['badwords'] && is_file(JPATH_SITE.'/components/com_badword/class.badword.php'))
                        {
                            $badwords = Badword::filter($fb_message_txt, $my);

                            if ($badwords == "true") {
                                $fb_message_txt = _COM_A_BADWORDS_NOTICE;
                            }
                        }

                        echo $fb_message_txt;
                        ?>
                    </td>
                </tr>

            <?php
            }
            ?>
        </table>

<?php
    } //else: this is a new topic so there can't be a history
}
?>
<!-- Begin: Forum Jump -->
<div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
<table class = "fb_blocktable" id = "fb_bottomarea" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
    <thead>
        <tr>
            <th class = "th-right">
                <?php
                //(JJ) FINISH: CAT LIST BOTTOM
                if ($fbConfig['enableForumJump']) {
                    require_once (JB_ABSSOURCESPATH . 'fb_forumjump.php');
                }
                ?>
            </th>
        </tr>
    </thead>
    <tbody><tr><td></td></tr></tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- Finish: Forum Jump -->

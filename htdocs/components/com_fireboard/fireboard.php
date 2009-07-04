<?php
/**
* @version $Id: fireboard.php 512 2007-12-18 22:15:28Z danialt $
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

require_once(JPATH_SITE.'/plugins/system/legacy/functions.php');
define('FIREBOARD_FRONTEND', JPATH_COMPONENT);
define('FIREBOARD_BACKEND',  JPATH_SITE.'/administrator/components/com_fireboard');
define('JPATH_LEGACY',       JPATH_SITE.'/plugins/system/legacy');

global $my;
$GLOBALS{'my'} = $my = &JFactory::getUser();

// Just for debugging and performance analysis
$mtime = explode(" ", microtime());
$tstart = $mtime[1] + $mtime[0];

// Kill notices (we have many..)
error_reporting (E_ALL ^ E_NOTICE);

global $mosConfig_lang, $fbIcons;

// ERROR: global scope mix
global $message;
// Get all the variables we need and strip them in case
$action = mosGetParam($_REQUEST, 'action', '');
$attachfile = mosGetParam($_FILES['attachfile'], 'name', '');
$attachimage = mosGetParam($_FILES['attachimage'], 'name', '');
$catid = (int)mosGetParam($_REQUEST, 'catid', '0');
$contentURL = mosGetParam($_REQUEST, 'contentURL', '');
$do = mosGetParam($_REQUEST, 'do', '');
$email = mosGetParam($_REQUEST, 'email', '');
$favoriteMe = mosGetParam($_REQUEST, 'favoriteMe', '');
$fb_authorname = mosGetParam($_REQUEST, 'fb_authorname', '');
$fb_thread = mosGetParam($_REQUEST, 'fb_thread', '');
$func = mosGetParam($_REQUEST, 'func', 'listcat');
$id = (int)mosGetParam($_REQUEST, 'id', '');
$limit = intval(mosGetParam($_REQUEST, 'limit', 0));
$limitstart = intval(mosGetParam($_REQUEST, 'limitstart', 0));
$markaction = mosGetParam($_REQUEST, 'markaction', '');
$message = mosGetParam($_REQUEST, 'message', '');
$page = mosGetParam($_REQUEST, 'page', '');
$parentid = (int)mosGetParam($_REQUEST, 'parentid', '');
$pid = (int)mosGetParam($_REQUEST, 'pid', '');
$replyto = mosGetParam($_REQUEST, 'replyto', '');
$resubject = mosGetParam($_REQUEST, 'resubject', '');
$return = mosGetParam($_REQUEST, 'return', '');
$rowid = (int)mosGetParam($_REQUEST, 'rowid', '');
$rowItemid = mosGetParam($_REQUEST, 'rowItemid', '');
$sel = mosGetParam($_REQUEST, 'sel', '');
$subject = mosGetParam($_REQUEST, 'subject', '');
$subscribeMe = mosGetParam($_REQUEST, 'subscribeMe', '');
$thread = (int)mosGetParam($_REQUEST, 'thread', '');
$topic_emoticon = mosGetParam($_REQUEST, 'topic_emoticon', '');
$userid = (int)mosGetParam($_REQUEST, 'userid', '');
$view = mosGetParam($_REQUEST, 'view', '');
$msgpreview = mosGetParam($_REQUEST, 'msgpreview', '');

// get fireboards configuration params in
global $fbConfig;
include_once (JPATH_SITE . '/administrator/components/com_fireboard/fireboard_config.php');

// Class structure should be used after this and all the common task should be moved to this class
require_once (JPATH_SITE . "/components/com_fireboard/class.fireboard.php");

// get right Language file
if (file_exists(JB_ABSADMPATH . '/language/' . JB_LANG . '.php')) {
    include_once (JB_ABSADMPATH . '/language/' . JB_LANG . '.php');
    }
else {
    include_once (JB_ABSADMPATH . '/language/english.php');
    }

// Include Clexus PM class file
if ($fbConfig['pm_component'] == "clexuspm")
{
    require_once (JPATH_SITE. '/components/com_mypms/class.mypms.php');
    $ClexusPMconfig = new ClexusPMConfig();
}

//time format
include_once (JB_ABSSOURCESPATH . 'fb_timeformat.class.php');

// systime is current time with proper board offset
define ('JB_SECONDS_IN_HOUR', 3600);
define ('JB_SECONDS_IN_YEAR', 31536000);
define ('JB_SESSION_TIMEOUT', 1800); // Our session limit is 30 mins
// define ('JB_OFFSET_USER', ($mainframe->getCfg('offset_user') * JB_SECONDS_IN_HOUR));
// For now: we add the correct offset to systime
// In the future the offset should be removed and only applied when
// displaying items -> store data in UTC
define ('JB_OFFSET_BOARD',($fbConfig['board_ofset'] * JB_SECONDS_IN_HOUR));

$systime = time() + JB_OFFSET_BOARD;

// additional database defines
define ('JB_DB_MISSING_COLUMN', 1054);

// Retrieve current cookie data for session handling
$settings = $_COOKIE['fboard_settings'];

// set configuration dependent params
$str_FB_templ_path = JB_ABSPATH . '/template/' . ($fb_user_template?$fb_user_template:$fbConfig['template']);
$board_title = $fbConfig['board_title'];
$fromBot = 0;
$prefview = $fbConfig['default_view'];

// JOOMLA STYLE CHECK
if ($fbConfig['joomlaStyle'] < 1) {
    $boardclass = "fb_";
    }

    
// Include preview here before inclusion of other files
if ($func == "getpreview") {
    
    if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
        include (JB_ABSTMPLTPATH . '/smile.class.php');
    }
    else {
        include (JB_ABSPATH . '/template/default/smile.class.php');
    }

    $message = urldecode(utf8_decode($msgpreview));
    //$message = str_replace("_@fb@_", "\n", $message);

    $msgbody = smile::smileReplace( $message , 0, _CLEXUSPM_LIVEPATH, $ClexusPMconfig->show_smiles);
    $msgbody = smile::htmlwrap($msgbody, $fbConfig['wrap']);
    header("Content-Type: text/html; charset=utf-8");
    echo utf8_encode($msgbody);
    die();
}    
    
// Add required header tags
$mainframe->addCustomHeadTag('<script type="text/javascript" src="' . JB_JQURL . '"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript">
//1: show, 0 : hide
jr_expandImg_url = "' . JB_URLIMAGESPATH . '";</script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="' . JB_COREJSURL . '"></script>');

if ($fbConfig['joomlaStyle'] < 1) {
    $mainframe->addCustomHeadTag('<link type="text/css" rel="stylesheet" href="' . JB_TMPLTCSSURL . '" />');
    }
else {
    $mainframe->addCustomHeadTag('<link type="text/css" rel="stylesheet" href="' . JB_DIRECTURL . '/template/default/joomla.css" />');
    }

// WHOIS ONLINE IN FORUM
if (file_exists(JB_ABSTMPLTPATH . '/plugin/who/who.class.php')) {
    include (JB_ABSTMPLTPATH . '/plugin/who/who.class.php');
    }
else {
    include (JB_ABSPATH . '/template/default/plugin/who/who.class.php');
    }

// include required libraries
if (file_exists(JB_ABSTMPLTPATH . '/fb_layout.php')) {
    require_once (JB_ABSTMPLTPATH . '/fb_layout.php');
    }
else {
    require_once (JB_ABSPATH . '/template/default/fb_layout.php');
    }

require_once (JB_ABSSOURCESPATH . 'fb_permissions.php');
require_once (JB_ABSSOURCESPATH . 'fb_category.class.php');

if ($catid != '') {
    $thisCat = new jbCategory($database, $catid);
    }

if (defined('JPATH_BASE')) {
    jimport ('pattemplate.patTemplate');
    }
else {
    require_once (JB_JABSPATH . '/includes/patTemplate/patTemplate.php');
    }

$obj_FB_tmpl = new patTemplate();
$obj_FB_tmpl->setBasedir($str_FB_templ_path);

// Permissions: Check for administrators and moderators
if ($my->id != 0)
{
    $aro_group = $acl->getAroGroup($my->id);
    $is_admin = (strtolower($aro_group->name) == 'super administrator' || strtolower($aro_group->name) == 'administrator');
}
else
{
    $aro_group = 0;
    $is_admin = 0;
}

$is_moderator = fb_has_moderator_permission($database, $thisCat, $my->id, $is_admin);

// TODO: both rss and pdf are totally broken atm, need to fix!
//intercept the RSS request; we should stop afterwards
if ($func == 'fb_rss')
{
    include (JB_ABSSOURCESPATH . 'fb_rss.php');
    die();
}

if ($func == 'fb_pdf')
{
    include (JB_ABSSOURCESPATH . 'fb_pdf.php');
    die();
}

// Include the Community Builder language file if necessary and set CB itemid value
$cbitemid = 0;

if ($fbConfig['cb_profile'])
{
    // $cbitemid = JBgetCBprofileItemid();
    // Include CB language files
    $UElanguagePath = JPATH_SITE . '/components/com_comprofiler/plugin/language';
    $UElanguage = $mainframe->getCfg('lang');

    if (!file_exists($UElanguagePath . '/' . $mosConfig_lang . '/' . $mosConfig_lang . '.php')) {
        $UElanguage = 'default_language';
        }

    include_once ($UElanguagePath . '/' . $UElanguage . '/' . $UElanguage . '.php');
}

// fireboard Current Template Icons Pack
// See if there's an icon pack installed
$useIcons = 0; //init
$fbIcons = 0;

if (file_exists(JB_ABSTMPLTPATH . '/icons.php'))
{
    include_once (JB_ABSTMPLTPATH . '/icons.php');
    $useIcons = 1;
}
else 
{
    include_once (JB_ABSPATH . '/template/default/icons.php');
}

//Get the userid; sometimes the new var works whilst $my->id doesn't..?!?
$my_id = $my->id;

// Check if we only allow registered users
if ($fbConfig['regonly'] && !$my_id)
{
    echo _FORUM_UNAUTHORIZIED . "<br />";
    echo _FORUM_UNAUTHORIZIED2;
}
// or if the board is offline
else if ($fbConfig['board_offline'] && !$is_admin) 
{
    echo $fbConfig['offline_message'];
}
else
{
//
// This is the main session handling section. We rely both on cookie as well as our own
// fireboard session table inside the database. We are leveraging the cookie to keep track
// of an individual session and its various refreshes. As we will never know what the last 
// pageview of a session will be (as defined by a commonly used 30min break/pause) we
// keep updateing the cookie until we detect a 30+min break. That break tells us to reset
// the last visit timestamp inside the database.
// We also redo the security checks with every new session to minimize the risk of exposed 
// access rights though someone 'leeching' on to another session. This resets the cached 
// priviliges after every 30 min of inactivity 
//
	// We only do the session handling for registered users
	// No point in keeping track of whats new for guests
	if ($my_id > 0)
	{ 
		// First we drop an updated cookie, good for 1 year
		// We have consolidated multiple instances of cookie management into this single location
		// NOT SURE IF WE STILL NEED THIS ONE after session management got dbtized
		setcookie("fboard_settings[member_id]", $my_id, time() + JB_SECONDS_IN_YEAR, '/');
	
		// We assume that this is a new user and that we don't know about a previous visit
		$new_fb_user = 0;
		$previousVisit = 0;
		$resetView = 0;
	
		// Lookup existing session sored in db. If none exists this is a first time visitor 
		$database->setQuery("SELECT userid, allowed, lasttime, readtopics, currvisit from #__fb_sessions where userid=" . $my_id);
		if (!$database->query()) 
		{
			// Temporary code - once we have finalized the upgrade database portion of the backend\
			// this upgrade and init portion can go
		
			// Test for missing column and if currtime is missing upgrade the db schema to new 1.0.4 version
			if ($database->getErrorNum()==JB_DB_MISSING_COLUMN && strpos($database->getErrorMsg(),"currvisit")!=0)
			{
				// New column introduced in 1.0.4 is missing -> inplace db upgarde
			 	$database->setQuery("ALTER TABLE #__fb_sessions ADD COLUMN currvisit int(11) NOT NULL default '0' AFTER readtopics");
				if (!$database->query()) die ("Serious db upgrade problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
				// Initialize new column
				$database->setQuery("UPDATE #__fb_sessions SET currvisit=lasttime");
				if (!$database->query()) die ("Serious db upgrade problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
				// Now re-run original query to fetch the data like nothing has happened
				$database->setQuery("SELECT userid, allowed, lasttime, readtopics, currvisit from #__fb_sessions where userid=" . $my_id);
				if (!$database->query()) die ("Serious db problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
			}
			else
			{
				// Not a missing column issue
				die ("Serious db problem " . $database->getErrorNum() . ":" . $database->getErrorMsg());
			}
	
		}
		$fbSessionArray = $database->loadObjectList();
		$fbSession = $fbSessionArray[0];
		
		// If userid is empty/null no prior record did exist -> new session and first time around
		if ($fbSession->userid == "" )
		{
			$new_fb_user = 1;
			$resetView = 1;
			
			// For first time registered users we show threads up to 1 year back as new
			$previousVisit = $systime - JB_SECONDS_IN_YEAR; 
	
			// Create new sessions entry in db for first time user
			$database->setQuery("INSERT INTO #__fb_sessions (userid,allowed,lasttime,readtopics,currvisit) values ($my_id, 'na',  $previousVisit,'',$systime)");
			if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
		}
		else 
		{
			// User has been here before
			$previousVisit = $fbSession->lasttime;
			// Record current time in session table so we keep a trail for the next visit
			$database->setQuery("UPDATE #__fb_sessions SET currvisit=$systime where userid=$my_id");
			if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
		}
		
		// If this is NOT a new user than we check if we ran over a 30 min gap in the session and reset
		// We also want to make sure the cookie is for the same user or the last time visited is void
		// And if the user hit the Mark all forums as read we also don't need to perform the check
		if ($new_fb_user == 0 && $markaction != "allread")
		{
			$inactivePeriod = $fbSession->currvisit + JB_SESSION_TIMEOUT;
	
			if ($inactivePeriod < $systime)
			{
			    // IN a new session we go back to the preferred view of the profile
			    $resetView = 1;
				//grant them 30 minutes of inactivity; then recheck privileges and try to send them back where they came from
				$previousVisit = $fbSession->currvisit;
				$database->setQuery("UPDATE #__fb_sessions SET allowed='na', readtopics='', lasttime=$previousVisit where userid=$my_id");
				if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
			}
		}
		else
		{
			// Other or new user
			if ($newfb_user == 1)
			{
				$allowed_forums = "";
			}
			else if ($markaction == "allread")
			{
				// All read simple means to reset the last visit to now
				$previousVisit = $systime;
				$database->setQuery("UPDATE #__fb_sessions SET lasttime=$previousVisit, readtopics='' where userid=$my_id");
				if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
	
				echo "<script> alert('" . _GEN_ALL_MARKED . "'); window.location='" . sefRelToAbs(JB_LIVEURLREL) . "';</script>\n";			
			}
		}
	
		// Now lets get the view type for the forum
		$database->setQuery("select view from #__fb_users where userid=$my_id");
		$database->query();
		$prefview = $database->loadResult();
		
		// If the prefferred view comes back empty this must be a new user
		// who does not yet have a FireBoard profile -> lets create one	
		if ($prefview == "")
		{
			//assume there's no profile; set userid and the default view type as preferred view type.
			$prefview = $fbConfig['default_view'];

			$database->setQuery("insert into #__fb_users (userid,view,moderator) values ('$my_id','$prefview','$is_admin')");
			if (!$database->query()) echo _PROBLEM_CREATING_PROFILE;

			// If Cummunity Builder is enabled, lets make sure we update the view preference
			if ($fbConfig['cb_profile']) 
			{
		        $cbprefview = $prefview == "threaded" ? "_UE_FB_VIEWTYPE_THREADED" : "_UE_FB_VIEWTYPE_FLAT";

				$database->setQuery("update #__comprofiler set fbviewtype='$cbprefview' where user_id='$my_id'");
				if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
			}
		}
		// If its not a new profile check if we have Community Builder enabled and read from there
		else if ($fbConfig['cb_profile'])
		{
			$database->setQuery("select fbviewtype from #__comprofiler where user_id='$my_id'");
			if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
			$fbviewtype = $database->loadResult();
	
			$prefview = $fbviewtype == "_UE_FB_VIEWTYPE_THREADED" ? "threaded" : "flat"; 
		}
		// Only reset the view if we have determined above that we need to
		// Without that test the user would not be able to make intra session
		// view changes by clicking on the threaded vs flat view link
		if ($resetView == 1)
		{
    		setcookie("fboard_settings[current_view]", $prefview, time() + JB_SECONDS_IN_YEAR, '/');
	    	$view = $prefview;
	    }
		
	    // Assign previous visit without user offset to variable for templates to decide
		// whether or not to use the NEW indicator on forums and posts 
		$prevCheck = $previousVisit; // - JB_OFFSET_USER; Don't use the user offset - it throws the NEW indicator off
	}
	else
	{
		// For guests we don't show new posts
		$prevCheck = $systime;
	}

    //Initial:: determining what kind of view to use... from profile, cookie or default settings.
    //pseudo: if (no view is set and the cookie_view is not set)
    if ($view == "" && $settings['current_view'] == "")
    {
        //pseudo: if there's no prefered type, use FB's default view otherwise use preferred view from profile
        //and then set the cookie right
        $view = $prefview == "" ? $fbConfig['default_view'] : $prefview;
        setcookie("fboard_settings[current_view]", $view, time() + JB_SECONDS_IN_YEAR, '/');
    }
    //pseudo: otherwise if (no view set but cookie isn't empty use view as set in cookie
    else if ($view == "" && $settings['current_view'] != "") 
  	{
        $view = $settings['current_view'];
    }

    //Get the max# of posts for any one user
    $database->setQuery("SELECT max(posts) from #__fb_users");
  	if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
    $maxPosts = $database->loadResult();

    //Get the topics this user has already read this session from #__fb_sessions
    $readTopics=$fbSession->readtopics;
    $read_topics = explode(',', $readTopics);

    /*       _\|/_
             (o o)
     +----oOO-{_}-OOo--------------------------------+
     |    Until this section we have included the    |
     |   necessary files and gathered the required   |
     |     variables. Now let's start processing     |
     |                     them                      |
     +----------------------------------------------*/

    //Check if the catid requested is a parent category, because if it is
    //the only thing we can do with it is 'listcat' and nothing else
    if ($func == "showcat" || $func == "view" || $func == "post")
    {
        $database->setQuery("SELECT parent FROM #__fb_categories WHERE id=$catid");
        if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());

		    $strCatParent = $database->loadResult();

        if ($catid == '' || $strCatParent == 0)
    		{
            $func = 'listcat';
        }
    }

    switch ($func)
    {
        case 'view':
            $fbMenu = jb_get_menu(FB_CB_ITEMID, $fbConfig, $fbIcons, $my_id, 3, $view, $catid, $id, $thread);

            break;

        case 'showcat':
            //get number of pending messages
            $database->setQuery("SELECT count(*) FROM #__fb_messages WHERE catid=$catid and hold=1");
      			if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());

            $numPending = $database->loadResult();

            $fbMenu = jb_get_menu(FB_CB_ITEMID, $fbConfig, $fbIcons, $my_id, 2, $view, $catid, $id, $thread, $is_moderator, $numPending);
            break;

        default:
            $fbMenu = jb_get_menu(FB_CB_ITEMID, $fbConfig, $fbIcons, $my_id, 1);

            break;
    }

    // display header
    $obj_FB_tmpl->readTemplatesFromFile("header.html");
    $obj_FB_tmpl->addVar('jb-header', 'menu', $fbMenu);
    $obj_FB_tmpl->addVar('jb-header', 'board_title', $board_title);
    $obj_FB_tmpl->addVar('jb-header', 'css_path', JB_DIRECTURL . '/template/' . $fbConfig['template'] . '/forum.css');
    $obj_FB_tmpl->addVar('jb-header', 'offline_message', $fbConfig['board_offline'] ? '<span id="fbOffline">' . _FORUM_IS_OFFLINE . '</span>' : '');
    $obj_FB_tmpl->addVar('jb-header', 'searchbox', getSearchBox());
    $obj_FB_tmpl->addVar('jb-header', 'pb_imgswitchurl', JB_URLIMAGESPATH . "shrink.gif");
    $obj_FB_tmpl->displayParsedTemplate('jb-header');

    //BEGIN: PROFILEBOX
    if (file_exists(JB_ABSTMPLTPATH . '/plugin/profilebox/profilebox.php')) {
        include (JB_ABSTMPLTPATH . '/plugin/profilebox/profilebox.php');
        }
    else {
        include (JB_ABSPATH . '/template/default/plugin/profilebox/profilebox.php');
        }
    //FINISH: PROFILEBOX

    switch (strtolower($func))
    {
        case 'who':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/who/who.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/who/who.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/who/who.php');
                }

            break;

        #########################################################################################
        case 'announcement':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/announcement/announcement.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/announcement/announcement.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/announcement/announcement.php');
                }

            break;

        #########################################################################################
        case 'stats':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/stats/stats.class.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/stats/stats.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/stats/stats.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/plugin/stats/stats.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/stats/stats.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/stats/stats.php');
                }

            break;

        #########################################################################################
        case 'fbprofile':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/fbprofile/fbprofile.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/fbprofile/fbprofile.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/fbprofile/fbprofile.php');
                }

            break;

        #########################################################################################
        case 'userlist':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/userlist/userlist.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/userlist/userlist.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/userlist/userlist.php');
                }

            break;

        #########################################################################################
        case 'post':
            if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
                include (JB_ABSTMPLTPATH . '/smile.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/smile.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/post.php')) {
                include (JB_ABSTMPLTPATH . '/post.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/post.php');
                }

            break;

        #########################################################################################
        case 'view':
            if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
                include (JB_ABSTMPLTPATH . '/smile.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/smile.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/view.php')) {
                include (JB_ABSTMPLTPATH . '/view.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/view.php');
                }

            break;

        #########################################################################################
        case 'faq':
            if (file_exists(JB_ABSTMPLTPATH . '/faq.php')) {
                include (JB_ABSTMPLTPATH . '/faq.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/faq.php');
                }

            break;

        #########################################################################################
        case 'showcat':
            if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
                include (JB_ABSTMPLTPATH . '/smile.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/smile.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/showcat.php')) {
                include (JB_ABSTMPLTPATH . '/showcat.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/showcat.php');
                }

            break;

        #########################################################################################
        case 'listcat':
            if (file_exists(JB_ABSTMPLTPATH . '/listcat.php')) {
                include (JB_ABSTMPLTPATH . '/listcat.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/listcat.php');
                }

            break;

        #########################################################################################
        case 'review':
            if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
                include (JB_ABSTMPLTPATH . '/smile.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/smile.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/moderate_messages.php')) {
                include (JB_ABSTMPLTPATH . '/moderate_messages.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/moderate_messages.php');
                }

            break;

        #########################################################################################
        case 'rules':
            include (JB_ABSSOURCESPATH . 'fb_rules.php');

            break;

        #########################################################################################

        // TODO: Will be delete
        case 'userprofile':
            if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
                include (JB_ABSTMPLTPATH . '/smile.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/smile.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile.php');
                }

            break;

        #########################################################################################
        case 'myprofile':
            if (file_exists(JB_ABSTMPLTPATH . '/smile.class.php')) {
                include (JB_ABSTMPLTPATH . '/smile.class.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/smile.class.php');
                }

            if (file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile.php');
                }

            break;

        #########################################################################################
        case 'report':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/report/report.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/report/report.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/report/report.php');
                }

            break;

        #########################################################################################
        case 'uploadavatar':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_avatar_upload.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/myprofile/myprofile_avatar_upload.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/myprofile/myprofile_avatar_upload.php');
                }

            break;

        #########################################################################################
        case 'latest':
            if (file_exists(JB_ABSTMPLTPATH . '/latestx.php')) {
                include (JB_ABSTMPLTPATH . '/latestx.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/latestx.php');
                }

            break;

        #########################################################################################
        case 'search':
            require_once (JB_ABSSOURCESPATH . 'fb_search.class.php');

            $searchword = mosGetParam($_REQUEST, 'searchword', '');

            $obj_FB_search = &new jbSearch($database, $searchword, $my_id, $limitstart, $fbConfig['messages_per_page_search']);
            $obj_FB_search->show();
            break;

        //needs work ... still in progress
        case 'advsearch':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearch.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearch.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/advancedsearch/advsearch.php');
                }

            break;

        case 'advsearchresult':
            if (file_exists(JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearchresult.php')) {
                include (JB_ABSTMPLTPATH . '/plugin/advancedsearch/advsearchresult.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/plugin/advancedsearch/advsearchresult.php');
                }

            break;

        #########################################################################################
        case 'markthisread':
            // get all already read topics
            $database->setQuery("SELECT readtopics FROM #__fb_sessions WHERE userid=$my_id");
		        if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
			      $allreadyRead = $database->loadResult();
            /* Mark all these topics read */
            $database->setQuery("SELECT thread FROM #__fb_messages WHERE catid=$catid and thread not in ('$allreadyRead') GROUP BY THREAD");
			      if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());
	          $readForum = $database->loadObjectList();
            $readTopics = '--';

            foreach ($readForum as $rf) {
                $readTopics = $readTopics . ',' . $rf->thread;
                }

            $readTopics = str_replace('--,', '', $readTopics);

            if ($allreadyRead != "") {
                $readTopics = $readTopics . ',' . $allreadyRead;
                }

            $database->setQuery("UPDATE #__fb_sessions set readtopics='$readTopics' WHERE userid=$my_id");
            if (!$database->query()) die ("Serious db problem:" . $database->getErrorMsg());

            echo "<script> alert('" . _GEN_FORUM_MARKED . "'); window.history.go(-1); </script>\n";
            break;

        #########################################################################################
        case 'karma':
            include (JB_ABSSOURCESPATH . 'fb_karma.php');

            break;

        #########################################################################################
        case 'bulkactions':
            switch ($do)
            {
                case "bulkDel":
                    FBTools::fbDeletePosts( $is_moderator, $return);

                    break;

                case "bulkMove":
                    FBTools::fbMovePosts($catid, $is_moderator, $return);
                    break;
            }

            break;

        ######################

        /*    template chooser    */
        case "templatechooser":
            $fb_user_template = strval(mosGetParam($_COOKIE, 'fb_user_template', ''));

            $fb_user_img_template = strval(mosGetParam($_REQUEST, 'fb_user_img_template', $fb_user_img_template));
            $fb_change_template = strval(mosGetParam($_REQUEST, 'fb_change_template', $fb_user_template));
            $fb_change_img_template = strval(mosGetParam($_REQUEST, 'fb_change_img_template', $fb_user_img_template));

            if ($fb_change_template)
            {
                // clean template name
                $fb_change_template = preg_replace('#\W#', '', $fb_change_template);

                if (strlen($fb_change_template) >= 40) {
                    $fb_change_template = substr($fb_change_template, 0, 39);
                    }

                // check that template exists in case it was deleted
                if (file_exists(JPATH_SITE. '/components/com_fireboard/template/' . $fb_change_template . '/forum.css'))
                {
                    $lifetime = 60 * 10;
                    $fb_current_template = $fb_change_template;
                    setcookie('fb_user_template', "$fb_change_template", time() + $lifetime);
                }
                else {
                    setcookie('fb_user_template', '', time() - 3600);
                    }
            }

            if ($fb_change_img_template)
            {
                // clean template name
                $fb_change_img_template = preg_replace('#\W#', '', $fb_change_img_template);

                if (strlen($fb_change_img_template) >= 40) {
                    $fb_change_img_template = substr($fb_change_img_template, 0, 39);
                    }

                // check that template exists in case it was deleted
                if (file_exists(JPATH_SITE. '/components/com_fireboard/template/' . $fb_change_img_template . '/forum.css'))
                {
                    $lifetime = 60 * 10;
                    $fb_current_img_template = $fb_change_img_template;
                    setcookie('fb_user_img_template', "$fb_change_img_template", time() + $lifetime);
                }
                else {
                    setcookie('fb_user_img_template', '', time() - 3600);
                    }
            }

            mosRedirect (sefRelToAbs(JB_LIVEURLREL));
            break;

        #########################################################################################
        default:
            if (file_exists(JB_ABSTMPLTPATH . '/listcat.php')) {
                include (JB_ABSTMPLTPATH . '/listcat.php');
                }
            else {
                include (JB_ABSPATH . '/template/default/listcat.php');
                }

            break;
    } //hctiws

    // Bottom Module
    if (mosCountModules('fb_bottom'))
    {
?>

        <div class = "bof-bottom-modul">
            <?php
            mosLoadModules('fb_bottom', -2);
            ?>
        </div>

<?php
    }

    // Credits
    echo '<div class="fb_credits"> ' . _FB_POWEREDBY . ' <a href="http://www.bestofjoomla.com" target="_blank">FireBoard</a>';

    if ($fbConfig['enableRSS']) {
        echo '<a href="' . $mosConfig_live_site . '/index2.php?option=com_fireboard&amp;func=fb_rss&amp;no_html=1'.FB_FB_ITEMID_SUFFIX.'" target="_blank" ><img
class="rsslink" src="' . JB_URLEMOTIONSPATH . 'rss.gif" border="0" alt="' . _LISTCAT_RSS . '" title="' . _LISTCAT_RSS . '" /></a>';
        }

    echo '</div>';
    // display footer
    $obj_FB_tmpl->readTemplatesFromFile("footer.html");
    $obj_FB_tmpl->displayParsedTemplate('fb-footer');
} //else

// Just for debugging and performance analysis
$mtime = explode(" ", microtime());
$tend = $mtime[1] + $mtime[0];
$tpassed = ($tend - $tstart);
//echo $tpassed;
?>
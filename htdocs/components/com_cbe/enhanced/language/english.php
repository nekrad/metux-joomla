<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//********************************************
// MamboMe Enhanced Language File            *
// Copyright (c) 2005 Jeffrey Randall        *
// http://mambome.com                        *
// Released under the GNU/GPL License        *
// Version 1.0                               *
// File date: 21-05-2005                     *
//********************************************

//Profile Color Language
DEFINE('_UE_PROFILE_COLOR','Profile Color');
DEFINE('_UE_PROFILE_COLOR_BLUE','Blue');	//blue
DEFINE('_UE_PROFILE_COLOR_GREEN','Green');	//green
DEFINE('_UE_PROFILE_COLOR_RED','Red');		//red
DEFINE('_UE_PROFILE_COLOR_PINK','Pink');	//pink
DEFINE('_UE_PROFILE_COLOR_ORANGE','Orange');//orange
DEFINE('_UE_PROFILE_COLOR_YELLOW','Yellow');//yellow
DEFINE('_UE_PROFILE_COLOR_BLACK','Black');	//black
DEFINE('_UE_PROFILE_COLOR_LIME','Lime');	//lime
DEFINE('_UE_PROFILE_COLOR_FUCHIA','Fuchia');//fuchia
DEFINE('_UE_PROFILE_COLOR_NAVY','Navy');	//navy
DEFINE('_UE_PROFILE_COLOR_PURPLE','Purple');//purple
DEFINE('_UE_PROFILE_COLOR_MAROON','Maroon');//maroon
DEFINE('_UE_PROFILE_COLOR_TEAL','Teal');	//teal
DEFINE('_UE_PROFILE_COLOR_AQUA','Aqua');	//aqua
DEFINE('_UE_PROFILE_COLOR_OLIVE','Olive');	//olive
DEFINE('_UE_PROFILE_COLOR_SILVER','Silver');//silver
DEFINE('_UE_PROFILE_COLOR_GREY','Grey');	//grey
DEFINE('_UE_PROFILE_COLOR_WHITE','White');	//white

//Profile Color Admin Language
DEFINE('_UE_COLORS_TAB_ADMIN_LABEL','Profile Color');
DEFINE('_UE_PROFILE_COLOR_ALLOW','Profile Color');
DEFINE('_UE_PROFILE_COLOR_ALLOW_DESC','Allow users to change thier profile color');
DEFINE('_UE_PROFILE_COLOR_DEFAULT','None');
DEFINE('_UE_PROFILE_COLOR_SET_DEFAULT','Default Color');
DEFINE('_UE_PROFILE_COLOR_SET_DEFAULT_DESC','Set the default color of users profile. Set to none to use template color.');

//User unregister language
DEFINE('_UE_USER_UNREGISTER_CONFIRM','You are about to delete your account, all of your information will be lost and you will no longer be able to log into this site. If you wish to become a member again, you will have to sign up as a new user.');
DEFINE('_UE_USER_UNREGISTER_PASSWORD','Password:');
DEFINE('_UE_USER_UNREGISTER_PASSWORD_VERIFY','Verify Password:');
DEFINE('_UE_USER_UNREGISTER_PASSWORD_INCORRECT','Incorrect password');
DEFINE('_UE_USER_UNREGISTER_UNREGISTER','unregister');
DEFINE('_UE_USER_UNREGISTER_PASSWORDS_NO_MATCH','Passwords do not match');
DEFINE('_UE_USER_UNREGISTER_REDIRECT','Redirecting....');
DEFINE('_UE_USER_UNREGISTER_DESCRIPTION','You are currently registered as a user on this site. To unregister from this site, please type in your password below and then again to verify it. Then click the unregister button.');
DEFINE('_UE_USER_UNREGISTER_UNREGISTERED','You are now unregistered from this site.');
DEFINE('_UE_USER_UNREGISTER_SECURITY_QUESTION','Security question:');
DEFINE('_UE_USER_UNREGISTER_SECURITY_QUESTION_ANSWER','Answer');
DEFINE('_UE_USER_UNREGISTER_SUPERADMIN','You can not unregister the superadminitrator!');
// User unregister Admin
DEFINE('_UE_REG_UNREGISTER_ALLOW','Allow unregister');
DEFINE('_UE_REG_UNREGISTER_ALLOW_DESC','Allows the user to unregister his account by himself');
DEFINE('_UE_REG_UNREGISTER_EDITMODE','unregister on edit');
DEFINE('_UE_REG_UNREGISTER_EDITMODE_DESC','Shows the unregister link in profile edit mode');
DEFINE('_UE_REG_UNREGISTER_PROFILEMODE','unregister on profile');
DEFINE('_UE_REG_UNREGISTER_PROFILEMODE_DESC','Shows the unregister link in normal profile view');
//
DEFINE('_UE_REG_UNREGISTER_SENDMAILUSER','Notify User');
DEFINE('_UE_REG_UNREGISTER_SENDMAILUSER_DESC','Sends the user an unregister reply message');
DEFINE('_UE_REG_UNREGISTER_SENDMAILADMIN','Notify Moderator');
DEFINE('_UE_REG_UNREGISTER_SENDMAILADMIN_DESC','Sends a notify message to the moderator(s)');
DEFINE('_UE_REG_UNREGISTER_MAILSUB','Subject of unRegister Mail');
DEFINE('_UE_REG_UNREGISTER_MAILSUB_DESC','Define a subject for the unregister email. (user)');
DEFINE('_UE_REG_UNREGISTER_MAILMSG','Message of unRegister Mail');
DEFINE('_UE_REG_UNREGISTER_MAILMSG_DESC','Define a text for the unregister email');
// Unregister Mail Text
DEFINE('_UE_MAIL_UNREG_SUB','Account deleted');
DEFINE('_UE_MAIL_UNREG_MSG','Dear [NAME],
You have choosen to delete your account.
The system has deleted all data for account:
[DETAILS]

If you want to use our system again, feel free
to register again.

Kind Regards,
Website Administration Team');
DEFINE('_UE_UNREGISTER_ADMIN_SUB','User deletion');
DEFINE('_UE_UNREGISTER_ADMIN_MSG','Dear Moderator,
The following user has unregistered himself from
the site. The data and avatar was deleted. Please
review the dump:

 [FULLDUMP] 
 
 Kind Regards
 Website Administration Team');



//Display language
DEFINE('_UE_FORUM_NO_KARMA','No Karma');
DEFINE('_UE_FORUM_KARMA','Karma');
DEFINE('_UE_PHOTOSNUMBER', 'Number of Photos');
DEFINE('_UE_MP3SNUMBER','Number of MP3s');
DEFINE('_UE_VIEWBLOG','Read Blog');
DEFINE('_UE_BLOG_HEADER','Member Blog');
DEFINE('_UE_BUDDYLIST','Buddy List');
DEFINE('_UE_BUDDYLIST_ADD','Add to Buddy List');
DEFINE('_UE_BUDDYLIST_DELETE','Delete from Buddy List');

//Search Manager
DEFINE('_UE_PROFILESEARCH','Search profiles');
DEFINE('_UE_SELECTCRITERIA','Select one or more criteria');
DEFINE('_UE_QUERY_NOT_VALID','That is not a valid query');
DEFINE('_UE_FORMSEARCH','Search');
DEFINE('_UE_FORMRESET','Reset');
DEFINE('_UE_SEARCH_TO','to');
DEFINE('_UE_SEARCHRESULTS','Search results');


//Search Manager Admin Language
DEFINE('_UE_SEARCH_MANAGER','CB Search');
DEFINE('_UE_SEARCH_MANAGER_SHOW_ADVANCED','Show Advanced');
DEFINE('_UE_SEARCH_MANAGER_SHOW_ADVANCED_DESC','Allows the display of the advanced profile search tab');
DEFINE('_UE_SEARCHTAB1','Search tab 1');
DEFINE('_UE_SEARCHTAB1_DESC','Label on search tab 1 (without advanced options)');
DEFINE('_UE_CBSEARCH_TITLE_TAB1','Simple');
DEFINE('_UE_SEARCHTAB2','Search tab 2');
DEFINE('_UE_SEARCHTAB2_DESC','Label on search tab 2 (with advanced options)');
DEFINE('_UE_CBSEARCH_TITLE_TAB2','Advanced');
DEFINE('_UE_SEARCHTAB_COLOR','Tab-Backgroundcolor');
DEFINE('_UE_SEARCHTAB_COLOR_DESC','Set the backgroundcolor of both tabs. You can user #hex or wordlike definitions like gray to set color.');
DEFINE('_UE_SEARCH_SHOW_DISTANCE','Entfernungssuche');
DEFINE('_UE_SEARCH_SHOW_DISTANCE_DESC','Aktiviert die Umkreis/Entfernungssuche sofern der GeoCoder aktiv ist und GeoDaten vorliegen.');
DEFINE('_UE_ONLINE_NOW_ONLY','Only users currently online');
DEFINE('_UE_ONLINE_NOW_ONLY_DESC','Allow this option in search form - search result will only return users currently online');
DEFINE('_UE_PICTURE_ONLY','Only users with a picture in their profile');
DEFINE('_UE_PICTURE_ONLY_DESC','Allow this option in search form - search result will only return users with a picture in their profile');
DEFINE('_UE_ONLINE_10_DAYS_OR_LESS','Only profiles online within last 10 days');
DEFINE('_UE_ONLINE_10_DAYS_OR_LESS_DESC','Allow this option in search form - search result will only return profiles online within last 10 days');
DEFINE('_UE_ADDED_10_DAYS_OR_LESS','Only profiles added within last 10 days');
DEFINE('_UE_ADDED_10_DAYS_OR_LESS_DESC','Allow this option in search form - search result will only return profiles added within last 10 days');
DEFINE('_UE_SEARCH_ANY','Any');
DEFINE('_UE_SEARCH_AGE_COMMON_STYLE','Fuzzy Age-search');
DEFINE('_UE_SEARCH_AGE_COMMON_STYLE_DESC','If active age search collects data based on years a person is in. A person who had his 23rd birthday is in his 24th year.');
DEFINE('_UE_ALLOW_CBESEARCH_MODULE','Allow access by Module');
DEFINE('_UE_ALLOW_CBESEARCH_MODULE_DESC','Allows cbe_search module to CBSearch. Please Check GroupAccess for CBSearch.');
DEFINE('_UE_CBSEARCH_DO_LOGIN','To see more search results, plese login or register.');
DEFINE('_UE_CBSEARCH_ERR_ACL','Sorry, but your usergroup rights are not allowed to see more search results.');
DEFINE('_UE_CBSEARCH_QUERY_EXPIRED','Your search-session has expired.');

//SB Forum Admin Language
DEFINE('_UE_SIMPLEBOARD_FORUM_TAB','SB forum');
DEFINE('_UE_SBJB_FORUM','FireBoard / JoomlaBoard / SimpleBoard');
DEFINE('_UE_SBJB_FORUM_DESC','This settings use the name Simpleboard, but they also are in charge for Joomlaboard as it the next version of Simpleboard.<br /> This settings also apply to the FireBoard-Tab!');
DEFINE('_UE_SHOW_FORUM_RANKING','Simpleboard forum rank in user profile');
DEFINE('_UE_SHOW_FORUM_RANKING_DESC','Allows displaying the forum ranking of a user in their profile');
DEFINE('_UE_SHOW_FORUM_POST_NUMBER','Simpleboard post number in user profile');
DEFINE('_UE_SHOW_FORUM_POST_NUMBER_DESC','Allows displaying the number of forum posts a user has made in their profile');
DEFINE('_UE_SHOW_FORUM_KARMA','Simpleboard forum karma in user profile');
DEFINE('_UE_SHOW_FORUM_KARMA_DESC','Allows displaying the forum karma of a user in their profile');
DEFINE('_UE_SHOW_FORUM_USEGID','Check viewer gid');
DEFINE('_UE_SHOW_FORUM_USEGID_DESC','Checks the viewers gid against the access gid of the forum');
DEFINE('_UE_SHOW_FORUM_USE_FB','FireBoard');
DEFINE('_UE_SHOW_FORUM_USE_FB_DESC','If Fireboard is used instead of SB/JB you have to set this active.');
// Profile Enhancements
// Phil_K
// German Federal States
DEFINE('_UE_DE_STATE_TITLE','German Federal State');
DEFINE('_UE_DE_STATE01','Baden-W�rttemberg');
DEFINE('_UE_DE_STATE02','Bavaria');
DEFINE('_UE_DE_STATE03','Berlin');
DEFINE('_UE_DE_STATE04','Brandenburg');
DEFINE('_UE_DE_STATE05','Bremen');
DEFINE('_UE_DE_STATE06','Hamburg');
DEFINE('_UE_DE_STATE07','Hesse');
DEFINE('_UE_DE_STATE08','Lower Saxony');
DEFINE('_UE_DE_STATE09','Mecklenburg-Western Pomerania');
DEFINE('_UE_DE_STATE10','North Rhine-Westphalia');
DEFINE('_UE_DE_STATE11','Rhineland-Palatinate');
DEFINE('_UE_DE_STATE12','Saarland');
DEFINE('_UE_DE_STATE13','Saxony');
DEFINE('_UE_DE_STATE14','Saxony-Anhalt');
DEFINE('_UE_DE_STATE15','Schleswig-Holstein');
DEFINE('_UE_DE_STATE16','Thuringia');
// Admin Infos
DEFINE('_UE_PSPECIAL_TAB_ADMIN_LABEL','Profile Specials');
DEFINE('_UE_PROFILE_BY_NAME','Get Profile by Name');
DEFINE('_UE_PROFILE_BY_NAME_DESC','Allows the call of profiles by using the username instead of the userid');
DEFINE('_UE_TOOLTIP_WZ','Use WZtooltip');
DEFINE('_UE_TOOLTIP_WZ_DESC','Switch which tooltip script to use. If <b>No</b> is selected Joomla Tooltips are used, if <b>Yes</b> you have to make sure wztooltip.js is connected in your template.');
DEFINE('_UE_PROFILE_LANGFILTER','Filter BadWords');
DEFINE('_UE_PROFILE_LANGFILTER_DESC','Activates Language Filter to mask bad words in user entered texts on the profile.');
DEFINE('_UE_PIC2PIC_ALLOW','Check for avatar');
DEFINE('_UE_PIC2PIC_ALLOW_DESC','If set a user without approved avatar can not see other avatars in profiles');
DEFINE('_UE_PIC2PROFILE_ALLOW','Check for profile');
DEFINE('_UE_PIC2PROFILE_ALLOW_DESC','If set a user without approved avatar can not see other profiles');
DEFINE('_UE_PIC2PROFILE_WARNING','Profile view not allowed. Please upload a photo to your profile first!');
DEFINE('_UE_SHOWAGE','Show Age');
DEFINE('_UE_SHOWAGE_TITLE','Age');
DEFINE('_UE_SHOWAGE_DESC','If selected the age is displayed in the users profile');
DEFINE('_UE_SHOWAGE_NOTE1','! IMPORTANT ! Do not forget to set the birthdayfield at ');
DEFINE('_UE_SHOWAGE_NOTE2','');
DEFINE('_UE_SHOWAGE_NO','no birthday entered');
DEFINE('_UE_RATEIT_ALLOW','Show Rate part');
DEFINE('_UE_RATEIT_ALLOW_DESC','If set the rate data and form is able to be shown ( <b>Main Switch</b> )');
DEFINE('_UE_RATEIT_FORM','Show Rate Form');
DEFINE('_UE_RATEIT_FORM_DESC','If set the rate formular is shown');
DEFINE('_UE_RATEIT_SELF','Allow self vote');
DEFINE('_UE_RATEIT_SELF_DESC','If set users can rate themself');
DEFINE('_UE_RATEIT_GUEST','Allow Guest vote');
DEFINE('_UE_RATEIT_GUEST_DESC','If set Guests can rate profiles');
DEFINE('_UE_RATEIT_STARS','Show result symbols');
DEFINE('_UE_RATEIT_STARS_DESC','If set result is displayed by images');
DEFINE('_UE_RATEIT_COUNT','Show count');
DEFINE('_UE_RATEIT_COUNT_DESC','If set the count of given votes is shown');
DEFINE('_UE_RATEIT_PRECISION','Decimal Digits');
DEFINE('_UE_RATEIT_PRECISION_DESC','Set the number of dezimal digits to show in the result value.');
DEFINE('_UE_RATEIT_RESULT_ALLOW','show votes');
DEFINE('_UE_RATEIT_RESULT_ALLOW_DESC','allows display of given votes average');
DEFINE('_UE_RATEIT_DAYS','Rate every x days');
DEFINE('_UE_RATEIT_DAYS_DESC','Set the time between two votes, based on a 24 hour calculation');
DEFINE('_UE_RATEIT_MOD','Copy Data');
DEFINE('_UE_RATEIT_MOD_DESC','Set this option to copy data to the main table to let mod_cbetopvotes read it');
DEFINE('_UE_RATEIT_MOD_TXT1','As default the fields <b>votecount</b> and <b>voteresult</b> are used.');
DEFINE('_UE_RATEIT_MOD_TXT2','These fields can be created the normal way as read-only or you use the tools menu option, which is prefered.');
DEFINE('_UE_RATEIT_ICON_FULL','Full image');
DEFINE('_UE_RATEIT_ICON_FULL_DESC','Set the path to the image representing a full percent point');
DEFINE('_UE_RATEIT_ICON_HALF','Half image');
DEFINE('_UE_RATEIT_ICON_HALF_DESC','Set the path to the image representing a half percent point');
DEFINE('_UE_RATEIT_MC_VALUE_DESC1','Formel: weighted rank (WR) = (v � (v+m)) � R + (m � (v+m)) � C');
DEFINE('_UE_RATEIT_MC_VALUE_DESC2','m = minimum votes required to be listed');
DEFINE('_UE_RATEIT_MC_VALUE_DESC3','C = the mean vote');
DEFINE('_UE_RATEIT_M_VALUE','Set m Value');
DEFINE('_UE_RATEIT_M_VALUE_DESC','Gives m a value, used for calculation of an average rate compareable to others');
DEFINE('_UE_RATEIT_C_VALUE','Set C Value');
DEFINE('_UE_RATEIT_C_VALUE_DESC','Gives C a value, used for calculation of an average rate compareable to others');
DEFINE('_UE_USEWORDWRAP_TXT','Wrap Textfields');
DEFINE('_UE_USEWORDWRAP_TXT_DESC','Adds Whitespace based on Col-Settings in textarea and texteditor fields.');

// LastVisitors
DEFINE('_UE_LASTVISITORS_TAB_ADMIN_LABEL','Last Visitors');
DEFINE('_UE_LASTVISITORS_COUNT','Visitors');
DEFINE('_UE_LASTVISITORS_COUNT_DESC','Choose number of visitors to be counted');
DEFINE('_UE_LASTVISITORS_DATE','Timestamp');
DEFINE('_UE_LASTVISITORS_DATE_DESC','Choose to show time related info of visitor');
DEFINE('_UE_LASTVISITORS_NODATE','No Date');
DEFINE('_UE_LASTVISITORS_SHOWDATE','Show Date');
DEFINE('_UE_LASTVISITORS_SHOWSINCE','Show since');
DEFINE('_UE_LASTVISITORS_GENDER','Gender');
DEFINE('_UE_LASTVISITORS_GENDER_DESC','Show Gender of visitor');
DEFINE('_UE_LASTVISITORS_GENDERSYMBOL','As Symbol');
DEFINE('_UE_LASTVISITORS_GENDERTEXT','As Text');
DEFINE('_UE_LASTVISITORS_NOGENDER','show not');
DEFINE('_UE_LASTVISITORS_SHOWSELF','Profile Owner');
DEFINE('_UE_LASTVISITORS_SHOWSELF_DESC','Set to count Owner views or not');
DEFINE('_UE_LASTVISITORS_OWNERONLY','Owner only');
DEFINE('_UE_LASTVISITORS_OWNERONLY_DESC','Set to only allow profile owner access');
DEFINE('_UE_LASTVISITORS_SHOWONLINE','Visitor state');
DEFINE('_UE_LASTVISITORS_SHOWONLINE_DESC','Set to show online state of visitors');
DEFINE('_UE_LASTVISITORS_SHOWAGE','Visitor age');
DEFINE('_UE_LASTVISITORS_SHOWAGE_DESC','Set to show age of visitor. Needs birthday field');
DEFINE('_UE_LASTVISITORS_BIRTHDAYFIELD','Birthday field');
DEFINE('_UE_LASTVISITORS_BIRTHDAYFIELD_DESC','Enter CBE birthday field');
DEFINE('_UE_LASTVISITORS_GENDERFIELD','Gender field');
DEFINE('_UE_LASTVISITORS_GENDERFIELD_DESC','Enter CBE gender field');
DEFINE('_UE_LASTVISITORS_DATESTRING','Date format');
DEFINE('_UE_LASTVISITORS_DATESTRING_DESC','Enter format of date. For syntax check the <a href="http://de2.php.net/manual/de/function.date.php" target=_new>date()</a> function.');
//
DEFINE('_UE_LASTVISITORS_SHOW_VISITCOUNT','Show VisitCount');
DEFINE('_UE_LASTVISITORS_SHOW_VISITCOUNT_DESC','Shows the individiual Visit counter to the profile owner.');
DEFINE('_UE_LASTVISITORS_SHOW_VISITEDTAB','Show Visited-Tab');
DEFINE('_UE_LASTVISITORS_SHOW_VISITEDTAB_DESC','Shows a tab listing a given number of profiles this user has visited. "No" shows this only to the owner of a profile.');
DEFINE('_UE_LASTVISITORS_SHOW_HEADERS','Show title row');
DEFINE('_UE_LASTVISITORS_SHOW_HEADERS_DESC','Shows a title row above the list of users naming which field is shown.');
DEFINE('_UE_LASTVISITORS_SHOW_USERFIELD','Show extra Field');
DEFINE('_UE_LASTVISITORS_SHOW_USERFIELD_DESC','Shows the value of an extra given field in the list on the tab');
DEFINE('_UE_LASTVISITORS_USERFIELD','Field');
DEFINE('_UE_LASTVISITORS_USERFIELD_DESC','Enter the name of the extra field like it is named in the database. This field must be in the _cbe table.');
//
DEFINE('_UE_LASTVISITORS_GENDERFIELDS_DESC','In the following you can specify your Gender tags and images. Image path must be relativ to lastvisitors directory.');
DEFINE('_UE_LASTVISITORS_FEMALE','Female');
DEFINE('_UE_LASTVISITORS_MALE','Male');
DEFINE('_UE_LASTVISITORS_COUPLE1','Couple 1');
DEFINE('_UE_LASTVISITORS_COUPLE2','Couple 2');
DEFINE('_UE_LASTVISITORS_COUPLE3','Couple 3');
DEFINE('_UE_LASTVISITORS_NEUTRAL','Neutral');
DEFINE('_UE_LASTVISITORS_NEUTRAL_DESC','This is used to attache an image to guets or deleted users');
DEFINE('_UE_LASTVISITORS_IMAGEPATH','Image path');
DEFINE('_UE_LASTVISITORS_ONLINEOFFLINE','Specify the path to the online and offline images.');
DEFINE('_UE_LASTVISITORS_ONLINE','Online');
DEFINE('_UE_LASTVISITORS_OFFLINE','Offline');
DEFINE('_UE_LASTVISITORS_CLEANED','LastVisitors database field clean up done.');

// Username / Password max/min Settings
DEFINE('_UE_REG_USERNAME_MIN','Username min. Chars');
DEFINE('_UE_REG_USERNAME_MIN_DESC','Allows to set the minimal length of the username');
DEFINE('_UE_REG_USERNAME_MAX','Username max. Chars');
DEFINE('_UE_REG_USERNAME_MAX_DESC','Allows to set the maximal length of the username');
DEFINE('_UE_REG_PASSWORD_MIN','Password min. Chars');
DEFINE('_UE_REG_PASSWORD_DESC','Allows to set the minimal length of the password');
DEFINE('_UE_REG_PASSWORD_MAIL','Send Password');
DEFINE('_UE_REG_PASSWORD_MAIL_DESC','Sends password in cleartext with Welcome-Mail.');
DEFINE('_UE_REG_GENPASSWORD','Generate Password');
DEFINE('_UE_REG_GENPASSWORD_DESC','Generates a password which is mailed to the user. It disables the password fields in registration.');
// RegEx Settings sv0.621
DEFINE('_UE_REG_REGEX','Set RegEx');
DEFINE('_UE_REG_REGEX_DESC','Define which Regular Expression to use on Usernames and Passwords on User adding and registration.');
DEFINE('_UE_REG_REGEX_NOTE','CBE-Beta1-1/2 default: ^\_|^\-|[^a-z|A-Z|^0-9|\_|\-]|\_$|\-$ <br> Joomla default: [\<|\>|"|\'|\%|\;|\(|\)|\&|\+|\-|\u0020]');

// Registration Ajax sv0.6232
DEFINE('_UE_REG_USEAJAX','AJAX Check');
DEFINE('_UE_REG_USEAJAX_DESC','Checks vailability of username while typing');
DEFINE('_UE_REG_USEAJAX_BUTTON','Extra Button');
DEFINE('_UE_REG_USEAJAX_BUTTON_DESC','On <b>No</b> check is done in realtime, on <b>Yes</b> a button has to be used.');
DEFINE('_USEAJAX_FAIL_USR','Username is in use.');
DEFINE('_USEAJAX_TRUE_USR','Username is available.');

// Registration DataSecurity Ecceptance sv0.6237/0.7
DEFINE('_UE_REG_DATASEC_MSG','Show DataSec Notes');
DEFINE('_UE_REG_DATASEC_MSG_DESC','Activates Link and Checkbox for DataSec Notes.');
DEFINE('_UE_REG_DATASEC_URL_MSG','Link to DataSec Page');
DEFINE('_UE_REG_DATASEC_URL_MSG_DESC','give complete URL');
DEFINE('_UE_REG_DATASEC_REQUIRED','Please read the datasecurity notes.');
DEFINE('_UE_REG_DATASEC','Notes of Datasecurity');
//DEFINE('','');

// Admin Switch Userlist->search in username?
DEFINE('_UE_USERLIST_SEARCH_USERNAME','Search in RealName also');
DEFINE('_UE_USERLIST_SEARCH_USERNAME_DESC','Allows to search by userlist in realname also.');

// Admin Switch Userlist-> show lists box?
DEFINE('_UE_USERLIST_SHOW_LISTSBOX','Show Lists-Box');
DEFINE('_UE_USERLIST_SHOW_LISTSBOX_DESC','Sets if there should be a pulldown list to select between all published lists.');
DEFINE('_UE_ALLOW_PROFILE_POPUP','Use PopUp on Click');
DEFINE('_UE_ALLOW_PROFILE_POPUP_DESC','Profiles get opened in a pop-up window if set.');
DEFINE('_UE_USERLIST_SHOW_SEARCHBOX','Show Search-field');
DEFINE('_UE_USERLIST_SHOW_SEARCHBOX_DESC','Use to active / deactivate the searchfield for names in userlists.');

// UHP Integration
DEFINE('_UE_UHP_ALLOW','UHP Link');
DEFINE('_UE_UHP_ALLOW_DESC','Shows a link to the UHP of a user in profile');
DEFINE('_UE_UHP','Mini-HP');
DEFINE('_UE_UHP_LINK','Mini-Homepage and images');
DEFINE('_UE_UHP_LINK_NO',' -- ');
//sv0.621 EasyProfileLink
DEFINE('_UE_SHOW_EASYPROFILELINK','Easy Profile-Link');
DEFINE('_UE_SHOW_EASYPROFILELINK_DESC','Shows a bookmarkable (IE) Easy Profile Link.');

// Flatten Tabs
DEFINE('_UE_FLATTEN_TABS','Tabs as Tables');
DEFINE('_UE_FLATTEN_TABS_DESC','Select if you want to have all tabs listed under each other and without the special JavaScript Tab feature.');
DEFINE('_UE_FLATTEN_TABS_NOTE','Note that this is <b>experimental</b> and will generate a javascript error.');

// Zodiacs
DEFINE('_UE_SHOWZODIAC','Show Zodiacs');
DEFINE('_UE_SHOWZODIAC_DESC','Displays the Zodiac in Profile ( Master Switch )');
DEFINE('_UE_SHOWZODIAC_STATIC','Calculate static');
DEFINE('_UE_SHOWZODIAC_STATIC_DESC','Activates a static calulation of Zodiacs.');
DEFINE('_UE_SHOWZODIAC_CH','Show chinese Zodiacs');
DEFINE('_UE_SHOWZODIAC_CH_DESC','Displays the chinese Zodiac in Profile');
DEFINE('_UE_SHOWZODIAC_NOTE','Make sure you habe a birthday field defined on LastVisitors-Admin-Tab. Chaldean Zodiacs are calculated based 
on the 30 degree division of 360 sky degree to get the Zodiac, this is more accurate than just checking dates. Chinese Zodiacs miss the difference
between gergorian year and chinese moon year.');
DEFINE('_UE_SHOWZODIAC_TITLE','Zodiac Sign');
DEFINE('_UE_SHOWZODIAC_TITLE_CHINESE','Chinese Sign');
DEFINE('_UE_ZODIAC_NO','no data');
DEFINE('_UE_A_ARIES','Arias');
DEFINE('_UE_A_TAURUS','Taurus');
DEFINE('_UE_A_GEMINI','Gemini');
DEFINE('_UE_A_CANCER','Cancer');
DEFINE('_UE_A_LEO','Leo');
DEFINE('_UE_A_VIRGO','Virgo');
DEFINE('_UE_A_LIBRA','Libra');
DEFINE('_UE_A_SCORPIO','Scorpio');
DEFINE('_UE_A_SAGITTARIUS','Sagittarius');
DEFINE('_UE_A_CAPRICORN','Capricorn');
DEFINE('_UE_A_AQUARIUS','Aquarius');
DEFINE('_UE_A_PISCES','Pisces');
DEFINE('_UE_AC_MONKEY','Monkey');
DEFINE('_UE_AC_ROOSTER','Rooster');
DEFINE('_UE_AC_DOG','Dog');
DEFINE('_UE_AC_PIG','Pig');
DEFINE('_UE_AC_RAT','Rat');
DEFINE('_UE_AC_OX','Ox');
DEFINE('_UE_AC_TIGER','Tiger');
DEFINE('_UE_AC_RABBIT','Rabbit');
DEFINE('_UE_AC_DRAGON','Dragon');
DEFINE('_UE_AC_SERPENT','Serpent');
DEFINE('_UE_AC_HORSE','Horse');
DEFINE('_UE_AC_GOAT','Goat');

// Messages Tags ( Reg. Aproval / Welcome / Reject )
DEFINE('_UE_MAIL_REG_REJECT_SUB','Your Registration was Rejected');
DEFINE('_UE_MAIL_REG_REJECT_MSG','Greetings [NAME],
we are sorry, but your Registration had to be rejected.
Kind Regards,
Website Administration Team');
DEFINE('_UE_MAIL_REG_PEND_APPR_SUB','Your Registration is Pending Approval');
DEFINE('_UE_MAIL_REG_PEND_APPR_MSG','Greetings [NAME],
Thank you for applying for registration with us. We have
received your request and we will process it as soon as you
confirm your email address by clicking on the following
hyperlink:
[CONFIRM]
Once your email address is confirmed our moderators will be
notified to continue the activation process.
You will be notified by email of the progress of the process.
[DETAILS]
Kind Regards,
Website Administration Team');
DEFINE('_UE_MAIL_REG_WELCOME_SUB','New User Details');
DEFINE('_UE_MAIL_REG_WELCOME_MSG','Welcome [NAME],
Your application has been approved by our administration team.
Your account with the following details:
[DETAILS]
has been activated.
We welcome you to our online community and trust that together
we will grow.
Enjoy the experience!
Kind Regards,
Website Administration Team');
// Integrations
DEFINE('_UE_ACCTEXP','Use com_acctexp');
DEFINE('_UE_ACCTEXP_DESC','Set this if you want to use AccountExp Component. Read the readme for needed changes.');
DEFINE('_UE_ACCTEXP_NOTE','To use these integrated hacks you need <b>Account Expiration Control</b> Version 0.8.x');
DEFINE('_UE_ACCTEXP_INSTALLED','AcctExp installed:');
DEFINE('_UE_SECIMAGES','Use com_securityimages');
DEFINE('_UE_SECIMAGES_DESC','Set this if you want to use Security-Images by Walter Cedric');
DEFINE('_UE_SECIMAGES_LOSTPASS','Use on LostPassword');
DEFINE('_UE_SECIMAGES_LOSTPASS_DESC','Activates com_securityimages on LostPassword-Dialog.');
DEFINE('_UE_SECIMAGES_CBE_LOGIN','Use on Login');
DEFINE('_UE_SECIMAGES_CBE_LOGIN_DESC','Activates integration on Login-Process.<br /><b>Please make sure mod_cbelogin has this also activated!</b>');
DEFINE('_UE_SECIMAGES_ERROR','Entered data does not compare with image data.');
DEFINE('_UE_SECIMAGES_NOTE','To use these integrated hacks you need <b>Security Images</b> Version 3.x.x');
DEFINE('_UE_SECIMAGES_INSTALLED','SecImage installed:');
DEFINE('_UE_SMFBRIDGE','Use SMF-Bridge (com_smf)');
DEFINE('_UE_SMFBRIDGE_DESC','Set this if you want to use SMF-Bridge by www.joomlahacks.com. If selected CBE handles login in a compatible mode.');
DEFINE('_UE_SMFBRIDGE_NOTE','To use these integrated hacks you need <b>Joomla-SMF Forum</b> Version 1.1 or higher.');
DEFINE('_UE_SMFBRIDGE_INSTALLED','SMF-Bridge installed:');
DEFINE('_UE_FQMULTI','Use fq_Multicorreos');
DEFINE('_UE_FQMULTI_DESC','Select if the registration process should show and handle subscriptions to fq_multicorreos Newsletter component.');
DEFINE('_UE_FQMULTI_NOTE','To use this integrated hacks you need <b>FQ Muticorreos</b> Version 1.1 or higher.');
DEFINE('_UE_FQMULTI_INSTALLED','FQ Multicorreos installed:');
DEFINE('_UE_YANC','Use YANC');
DEFINE('_UE_YANC_DESC','Select if the registration process should show and handle subscriptions to YANC Newsletter component.');
DEFINE('_UE_YANC_NOTE','To use this integrated hacks you need <b>YANC</b> Version 1.4 or higher.');
DEFINE('_UE_YANC_INSTALLED','YANC installed:');
//
//
DEFINE('_UE_ALLOW_MAILCHANGE','Allow change of eMail');
DEFINE('_UE_ALLOW_MAILCHANGE_DESC','Change to allow the user to change his eMail.');
DEFINE('_UE_FULL_EDITORFIELD','Show editor fieldname');
DEFINE('_UE_FULL_EDITORFIELD_DESC','Set to No to disable the fieldname and give an editorfield the complete tab width');
//
// sv0.62 Profile Stats Admin
DEFINE('_UE_PROFILE_STATS_TAB_ADMIN_LABEL','Statistics');
DEFINE('_UE_SHOW_PROFILE_HITS','Show Nr. of hits');
DEFINE('_UE_SHOW_PROFILE_HITS_DESC','Shows counter how often a profile was called for viewing by other users');
DEFINE('_UE_SHOW_PROFILE_STATS','Show Account Stats');
DEFINE('_UE_SHOW_PROFILE_STATS_DESC','Shows three values of account related data. (register-date, last-online, last-update)');
DEFINE('_UE_SHOW_CORE_USERTYPE','Show Usergroup');
DEFINE('_UE_SHOW_CORE_USERTYPE_DESC','Shows the users core group');
DEFINE('_UE_CB_CORE_USERTYPE','Usergroup');//
//
// sv0.623 Mail on Profile Update
DEFINE('_UE_SENDMAIL_ON_PROFILE_UPDATE','Notify on Changes');
DEFINE('_UE_SENDMAIL_ON_PROFILE_UPDATE_DESC','Sends a notify email to moderators on user profile changes');
DEFINE('_UE_USER_PROFILE_UPDATE','User-Profil-Update');
DEFINE('_UE_USER_PROFILE_UPDATE_MSG','Hello,

The user with the following data
---
[NAME]
[DETAILS]
---
has saved changes to his profile.

Kind Regards,
Website-Admin-Team');
//
// Mailer X-Header Changer
DEFINE('_UE_SET_MAIL_XHEADER','Mail X-Header');
DEFINE('_UE_SET_MAIL_XHEADER_DESC','Change if you have poblems with some provider setting your mail as spam. This option will allow to cloak a mail as send with outlook. <b>Only active if no mosMailer is found!</b>');
//
// GroupJive Admin 
DEFINE('_UE_PROFILE_GROUPJIVE_TAB_ADMIN_LABEL','GroupJive');
DEFINE('_UE_GROUPJIVE_NOTE','Please make sure GroupJive is installed before you set one of these option activ. Below you get an info if and which version of GroupJive is installed. For download see www.groupjive.com.');
DEFINE('_UE_GROUPJIVE_INSTALLED','GroupJive Version installed');
DEFINE('_UE_GJ_INTEGRATION','Set GroupJive integration');
DEFINE('_UE_GJ_INTEGRATION_DESC','Set to Yes if you want CBE to show GJ related Infos in tabs or Profile');
DEFINE('_UE_GJ_SHOW_OWNDED_GROUPS','Show own Group');
DEFINE('_UE_GJ_SHOW_OWNDED_GROUPS_DESC','Shows GJ Group(s) owned by that user in his profile stats');
DEFINE('_UE_GJ_LINK_OWNED_GROUPS','Link GJ Groups');
DEFINE('_UE_GJ_LINK_OWNED_GROUPS_DESC','Actives a link to gj tab if the user is owner of more than one gj group');
// GJ Frontend
DEFINE('_UE_GROUPJIVE_OWNER','Moderates');
DEFINE('_UE_GROUPJIVE_G','Group');
DEFINE('_UE_GROUPJIVE_GS','Groups');
//
// sv0.6232
DEFINE('_UE_FIELDINFORMATION','helpfull Information');
DEFINE('_UE_AVATARUPLOADONREG','Upload on Registration?');
DEFINE('_UE_AVATARUPLOADONREG_DESC','Allows the user to define an image as avatar during registration.');
DEFINE('_UE_AVATARUPLOADONREGFRONT','Avatar Upload');
DEFINE('_UE_AVATARDELETE_JS','Ask before deletion?');
DEFINE('_UE_AVATARDELETE_JS_DESC','Use a javascript confirm request before deleting the users avatar.');
// sv0.701
DEFINE('_UE_AVATAR_SHOW_RULES','Show rules for images');
DEFINE('_UE_AVATAR_SHOW_RULES_DESC','Activates the link to the rules.');
DEFINE('_UE_AVATAR_SHOW_RULES_URL','Rules URL');
DEFINE('_UE_AVATAR_SHOW_RULES_URL_DESC','URL for the content holding the image rules.');
DEFINE('_UE_AVATAR_RULES_LINKTEXT','Please follow the rules about profile images.');
DEFINE('_UE_AVATAR_RULES_IGNORED','Do not forget to accept the rules.');//
// sv0.6233
DEFINE('_UE_UNAME_PATHWAY','Username in Pathway');
DEFINE('_UE_UNAME_PATHWAY_DESC','If set to yes only the username will be appedned to pathway, if set to no the mame-format is used..');
DEFINE('_UE_SHOW_JEDITOR','Show Editor Selector');
DEFINE('_UE_SHOW_JEDITOR_DESC','Allows to show the user an editor selector in <b>Joomla</b> while in EditMode. In Mombo this has no effect.');
DEFINE('_UE_CBE_DELET_AVATAR_NOTE','Delete this avatar image?');
DEFINE('_UE_USERSLIST_CSS1','uneven rows');
DEFINE('_UE_USERSLIST_CSS1_DESC','Sets the css class for uneven rows in list display. Make sure the name contains the digit 1 at the end.');
DEFINE('_UE_USERSLIST_CSS2','even rows');
DEFINE('_UE_USERSLIST_CSS2_DESC','Sets the css class for even rows in list display. Make sure the name contains the digit 2 at the end.');
DEFINE('_UE_USERSLIST_RNR','Nr per Row');
DEFINE('_UE_USERSLIST_RNR_DESC','Sets the number of profiles per row in usersList. This is used if only one coloumn is active.');
DEFINE('_UE_AVATARGALLERY_ROWS','Columns');
DEFINE('_UE_AVATARGALLERY_ROWS_DESC','Sets the number of columns the images are presented for selection');
DEFINE('_UE_WATERMARKS','Watermark');
DEFINE('_UE_WATERMARKS_NOTE','Usage of watermarking depends on a 24Bit PNG image and following check done.');
DEFINE('_UE_WM_BASICS','Check successful');
DEFINE('_UE_WM_BASICS_DESC','Checks basic image manipulation functions which are needed for stamping and watermarking');
DEFINE('_UE_WM_FORCEPNG','use PNG');
DEFINE('_UE_WM_FORCEPNG_DESC','Forces conversion of every uploaded avatar image to PNG. Necessary for watermarking. On GIF only first frame gets converted.');
DEFINE('_UE_WM_FORCEZOOM','upZoom');
DEFINE('_UE_WM_FORCEZOOM_DESC','Forces every tiny image to be up-zoomed on one dimension min. to the given image dimensions.');
DEFINE('_UE_WM_CANVAS','Use Canvas');
DEFINE('_UE_WM_CANVAS_DESC','Fills up a uploaded image to the maximum dimensions given on the tab before');
DEFINE('_UE_WM_CANVAS_TRANS','Canvas transparent');
DEFINE('_UE_WM_CANVAS_TRANS_DESC','Sets the choosen canvas color as transparent color.');
DEFINE('_UE_WM_CANVAS_COLOR','Canvas Color');
DEFINE('_UE_WM_CANVAS_COLOR_DESC','Color of canvas in six-digit hexCode without #.');
DEFINE('_UE_WM_STAMPIT','Stamp image');
DEFINE('_UE_WM_STAMPIT_DESC','Activats the stamp function. If text is left empty the profiles shortURL will be used only used with watermark');
DEFINE('_UE_WM_STAMPIT_TEXT','Stamp Text');
DEFINE('_UE_WM_STAMPIT_SIZE','Stamp Size');
DEFINE('_UE_WM_STAMPIT_SIZE_DESC','Sets the size of the text stamped into the image');
DEFINE('_UE_WM_STAMPIT_COLOR','Stamp Color');
DEFINE('_UE_WM_STAMPIT_COLOR_DESC','Color of the text in six-digit hexCode without #');
DEFINE('_UE_WM_DOIT','Use Watermark');
DEFINE('_UE_WM_DOIT_DESC','Activates the watermark function');
DEFINE('_UE_WM_FILENAME','Watermark file');
DEFINE('_UE_WM_FILENAME_DESC','Filename of the watermark file under /images/cbe/watermark/');
//
DEFINE('_UE_CBE_ADD','Add');
DEFINE('_UE_CBE_REMOVE','Remove');
DEFINE('_UE_CBE_DELETE','Delete');
DEFINE('_UE_CBE_M_CLICK','(click)');
DEFINE('_UE_CBE_M_ADMIN','(Admin)');
DEFINE('_UE_CBE_M_USER','(User)');
DEFINE('_UE_CBE_M_JOOMLA','(System)');
// List Manager
DEFINE('_UE_CBE_LIST_MANAGER','List Manager');
DEFINE('_UE_CBE_NR_DISPLAY','Display');
DEFINE('_UE_CBE_LM_SEARCH','Search');
DEFINE('_UE_CBE_TITLE','Title');
DEFINE('_UE_CBE_DESCRIPTION','Description');
DEFINE('_UE_CBE_PUBLISHED','Published');
DEFINE('_UE_CBE_DEFAULT','Default');
DEFINE('_UE_CBE_LIST_ID','List-ID');
DEFINE('_UE_CBE_RE_ORDER','Re-Order');
DEFINE('_UE_CBE_LM_EDIT','Edit List');
DEFINE('_UE_CBE_LM_ADD','Add List');
DEFINE('_UE_CBE_GID_INCL','User Groups to Include');
DEFINE('_UE_CBE_GID_ACL','User Groups with Access');
DEFINE('_UE_CBE_GID_ACL_DESC','All groups above the selected one have access.');
DEFINE('_UE_CBE_SORT_BY','Sort By');
DEFINE('_UE_CBE_LM_ASC','ASCending');
DEFINE('_UE_CBE_LM_DESC','DESCending');
DEFINE('_UE_CBE_LM_FILTER','SQL-Filter');
DEFINE('_UE_CBE_LM_FSIMPLE','Simple');
DEFINE('_UE_CBE_LM_FADVANCED','Advanced');
DEFINE('_UE_CBE_LM_SQL_1','Greater Than');
DEFINE('_UE_CBE_LM_SQL_2','Greater Than or Equal To');
DEFINE('_UE_CBE_LM_SQL_3','Less Than');
DEFINE('_UE_CBE_LM_SQL_4','Less Than or Equal To');
DEFINE('_UE_CBE_LM_SQL_5','Equal To');
DEFINE('_UE_CBE_LM_SQL_6','Not Equal To');
DEFINE('_UE_CBE_LM_SQL_7','Is Empty');
DEFINE('_UE_CBE_LM_SQL_8','Is Not Empty');
DEFINE('_UE_CBE_LM_SQL_9','Like');
DEFINE('_UE_CBE_LM_FILTER_ONLINE','Filter only on Online User');
DEFINE('_UE_CBE_LM_FIELD_LIST','Field List');
DEFINE('_UE_CBE_LM_COLUMN_ENABLE','Enable Column');
DEFINE('_UE_CBE_LM_COLUMN_TITLE','Tilte of Column');
DEFINE('_UE_CBE_LM_COLUMN_CAPTIONS','Captions in Column');
// Field Manager
DEFINE('_UE_CBE_FIELD_MANAGER','Field Manager');
DEFINE('_UE_CBE_FM_SEARCH','Search');
DEFINE('_UE_CBE_FM_DBNAME','Name in DB');
DEFINE('_UE_CBE_FM_FIELDNAME','Title');
DEFINE('_UE_CBE_FM_FIELDTYPE','Type');
DEFINE('_UE_CBE_FM_FIELDTAB','Tab');
DEFINE('_UE_CBE_FM_REQUIRED','Required');
DEFINE('_UE_CBE_FM_PROFILE','Profile');
DEFINE('_UE_CBE_FM_SHOW_ON_PROFILE','Show on Profile');
DEFINE('_UE_CBE_FM_REGISTRATION','Registration');
DEFINE('_UE_CBE_FM_REQUIRED_FOR_REGISTRATION','Required on Registration');
DEFINE('_UE_CBE_FM_PUBLISHED','Published');
DEFINE('_UE_CBE_FM_RE_ORDER','Re-Order');
DEFINE('_UE_CBE_FM_EDIT','Edit Field');
DEFINE('_UE_CBE_FM_ADD','Add Field');
DEFINE('_UE_CBE_FM_READ_ONLY','User Read-Only');
DEFINE('_UE_CBE_FM_USE_IN_CBSEARCH','Use in CBE-Search');
DEFINE('_UE_CBE_FM_FIELD_TOOLTIP','Field Information (ToolTip)');
DEFINE('_UE_CBE_FM_FIELD_NO_TP','no info');
DEFINE('_UE_CBE_FM_FIELD_ICON_TP','show as Icon');
DEFINE('_UE_CBE_FM_FIELD_TAGED_TP','show as taged Title');
DEFINE('_UE_CBE_FM_FIELD_BOTH_TP','show Title and Icon');
DEFINE('_UE_CBE_FM_SIZE','Size');
DEFINE('_UE_CBE_FM_MAX_LENGTH','max. Length');
DEFINE('_UE_CBE_FM_COLS','Cols');
DEFINE('_UE_CBE_FM_ROWS','Rows');
DEFINE('_UE_CBE_FM_VALUES_INFO','Use the table below to add new values.');
DEFINE('_UE_CBE_FM_ADD_VALUE','Add a Value');
DEFINE('_UE_CBE_FM_BD_LOWRANGE','min year');
DEFINE('_UE_CBE_FM_BD_HIGHRANGE','max year');
DEFINE('_UE_CBE_FM_BD_STARTDATE','preselection (year)');
// Tab Manager
DEFINE('_UE_CBE_TAB_MANAGER','Tab Management');
DEFINE('_UE_CBE_TM_SEARCH','Search');
DEFINE('_UE_CBE_TM_TITLE','Title');
DEFINE('_UE_CBE_TM_DESCRIPTION','Description');
DEFINE('_UE_CBE_TM_PUBLISHED','Published');
DEFINE('_UE_CBE_TM_RE_ORDER','Re-Order');
DEFINE('_UE_CBE_TM_EDIT','Edit Tab');
DEFINE('_UE_CBE_TM_ADD','Add Tab');
DEFINE('_UE_CBE_TM_ENH_PARAMS','Enhanced Parameters');
DEFINE('_UE_CBE_TM_NESTED','SubTab');
DEFINE('_UE_CBE_TM_ISNEST','Container for Nesting');
DEFINE('_UE_CBE_TM_NESTID','Nest below Tab');
DEFINE('_UE_CBE_TM_ACL_DESC1','<b>strg for multi-selection of groups</b><br>Access is allowed for all on all group or none group selection.');
DEFINE('_UE_CBE_TM_ACL_DESC2','Tabs for Admins and Super-Admins are not viewable by users in profile-edit!');
DEFINE('_UE_CBE_TM_FEXPLAIN','Importend Note');
DEFINE('_UE_CBE_TM_FEXPLAIN_DESC','The following conditions set in which case a tab is shown to the ower or/and viewer. You can also set If
both conditions have to be true or not. Regarding the Expert-Mode the query only returns one value which has to be equal to the owner userid or
the viewers userid. Therefor only $my->id and $user->id can be used as variables, but database tables can be named like #__cbe. Only SELECT queries are allowed.');
DEFINE('_UE_CBE_TM_FSIMPLE','Simple');
DEFINE('_UE_CBE_TM_FADVANCED','Advanced');
DEFINE('_UE_CBE_TM_FINDIVIDUAL','Expert-Mode');
DEFINE('_UE_CBE_TM_FQME','Condition related to profile owner');
DEFINE('_UE_CBE_TM_FQYOU','Condition related to profile viewer');
DEFINE('_UE_CBE_TM_FQBIND','Connect both with');
DEFINE('_UE_CBE_TM_FINVALID','SQL-string invalid');
DEFINE('_UE_CBE_TM_FQYOU_INVERT','Reflects the visitor condition to the profile owner. As a result the visitor is conected to settings the owner does to see the tab.');
DEFINE('_UE_CBE_TM_FHELP','');
// User Manager
DEFINE('_UE_CBE_USER_MANAGER','User Manager');
DEFINE('_UE_CBE_UM_SEARCH','Search');
DEFINE('_UE_CBE_UM_REALNAME','Name');
DEFINE('_UE_CBE_UM_USERNAME','Username');
DEFINE('_UE_CBE_UM_LOGGED_IN','Logged In');
DEFINE('_UE_CBE_UM_USERGROUP','Group');
DEFINE('_UE_CBE_UM_USER_PARAMS','User Parameters');
DEFINE('_UE_CBE_UM_EMAIL','eMail');
DEFINE('_UE_CBE_UM_LAST_VISIT','Last Visit');
DEFINE('_UE_CBE_UM_ENABLED','Enabled');
DEFINE('_UE_CBE_UM_CONFIRMED','Confirmed');
DEFINE('_UE_CBE_UM_APPROVED','Approved');
DEFINE('_UE_CBE_UM_AVATAR_APPROVED','Avatar Approved');
DEFINE('_UE_CBE_UM_EDIT','Edit User');
DEFINE('_UE_CBE_UM_ADD','Add User');
DEFINE('_UE_CBE_UM_BLOCK_USER','Block User');
DEFINE('_UE_CBE_UM_BAN_USER','Ban Profile');
DEFINE('_UE_CBE_UM_USERDATA_APPROVED','Approve User');
DEFINE('_UE_CBE_UM_USER_CONFIRMED','Confirm User');
DEFINE('_UE_CBE_UM_SUBMISSION_MAIL','Receive Submission Emails');
DEFINE('_UE_CBE_UM_REGISTER_DATE','Register Date');
DEFINE('_UE_CBE_UM_USERMAIL_ON_ADMIN_ADD','Hello [NAME],

You have been added as a user to [SITEURL] by an Administrator.
This email contains your username and password to log into the [SITEURL] site:

Username - [USERNAME]
Password - [PASSWORD-CLEAR]

Please change your password after your first login.

Please do not respond to this message as it is automatically generated and is for information purposes only.

Kind Regards,
Website-Admin-Team
(Robot)');
// Search Manager - some tags are used from the field manager
DEFINE('_UE_CBE_SEARCH_MANAGER','Search Manager');
DEFINE('_UE_CBE_SM_SEARCH','Search');
DEFINE('_UE_CBE_SM_RANGE','Allow Range');
DEFINE('_UE_CBE_SM_MODULE','Module');
DEFINE('_UE_CBE_SM_USERLISTID','Output uses');
DEFINE('_UE_CBE_SM_USERLISTID_DESC','Select which usersList template should be used for output.');
DEFINE('_UE_CBE_SM_SEARCH_TIMEOUT','Session Lifetime');
DEFINE('_UE_CBE_SM_SEARCH_TIMEOUT_DESC','Number of minutes after a searchquery expires and gets deleted from DB. Paging in results will not extend lifetime.');
// Blocked Names Management
DEFINE('_UE_CBE_BLOCKED_NAMES_MANAGER','Blocked Names Management');
DEFINE('_UE_CBE_BNM_LIST_OF_PARTS','Bad Names List');
DEFINE('_UE_CBE_BNM_PUBLISHED','Published');
DEFINE('_UE_CBE_BNM_POPERROR','Please fill in a word to filter.');
DEFINE('_UE_CBE_BNM_NAME_PART','Filtered Name Part');
// Language Filter Management
DEFINE('_UE_CBE_LANGUAGE_FILTER_MANAGER','Language Filter Manager');
DEFINE('_UE_CBE_LFM_LIST_OF_WORDS','Filtered Word List');
DEFINE('_UE_CBE_LFM_PUBLISHED','Published');
DEFINE('_UE_CBE_LFM_POPERROR','Please fill in a word to filter.');
DEFINE('_UE_CBE_LFM_WORD','Filtered Word');
//
// 0.6235
DEFINE('_UE_CBEDOLOGIN','CBE Login');
DEFINE('_UE_CBEDOLOGIN_DESC','Let CBE handling authentification of users to joomla. If No data is transmitted to index.php for authentification. <b> Yes recommended if you do not use any bridge.</b>');
// TopMostUser
DEFINE('_UE_TPM_FETITLE','Online time statistics');
DEFINE('_UE_TPM_COUNT','nr of login');
DEFINE('_UE_TPM_TIMESUM','time');
DEFINE('_UE_TPM_AVG','average');
DEFINE('_UE_TPM_NOTACTIVE','TopMostUser Feature not activated.');
DEFINE('_UE_TPMA_ACTIVE','activate TopMost');
DEFINE('_UE_TPMA_ACTIVE_DESC','Sets statistics of TopMostUsers to active');
DEFINE('_UE_TPMA_LIMIT','Top x User');
DEFINE('_UE_TPMA_LIMIT_DESC','Number of Users to show in List');
// JSe
DEFINE('_UE_CBE_EMAIL_ERROR','Verify the email address format.');
DEFINE('_UE_CBE_FLOAT_ERROR','Verify the value format. Only floating point numbers allowed');
DEFINE('_UE_CBE_INTEGER_ERROR','Verify the value format. Only integer numbers allowed.');
DEFINE('_CBE_TEXTAREA_LIMIT_ERROR','maximum number of chars:');
DEFINE('_UE_CBE_FILL_ALL_ERROR','You have to fill all fields, please.');
DEFINE('_UE_CBE_JS_DATE_INVALID','The given Date is false. Please correct it.');
DEFINE('_UE_CBE_JS_DATE_OUTOFRANGE','The given Date is outside the allowed range.');
//
DEFINE('_UE_REG_CONFIRMATION_HASH','Hash-Number');
DEFINE('_UE_REG_CONFIRMATION_HASH_DESC','A number (float) to enhance strength of confirm code against bruteforce activations.');
DEFINE('_UE_ADMINSHOWALLTABS','Show all Tabs at Backend');
DEFINE('_UE_ADMINSHOWALLTABS_DESC','Ignores all profile-owner related Tab-Conditions in Backend.');
DEFINE('_UE_CBE_BE_NEW_ORDER','do ReOrder');
DEFINE('_UE_CBE_BE_NEW_ORDER_SAVED','New order saved!');
DEFINE('_UE_CBE_BANREQUEST_DOBLOCK','Block user login in addition and send mail with above reason?');
DEFINE('_UE_CBE_BANUSER_BLOCK_MSG','Your user profile was banned by an administrator. \r\n Actualy your login is blocked, too. \r\n The administrator added the following reason.\r\n');
//
DEFINE('_UE_CBE_GALLERY','CBE-Gallery');
DEFINE('_UE_CBE_GALLERY_DESC','Only activate if CBE-Gallery above 1.3 is installed.');
DEFINE('_UE_CBE_GALLERY_REQUIREACTION','User-Gallery-Iamge(s)');
//
DEFINE('_UE_CBE_CALCED_AGE','Age');
DEFINE('_UE_PROFILE_GEOCODER_TAB_ADMIN_LABEL','GeoCoder');
DEFINE('_UE_CBE_GEOCODER_GOOGLE_APIKEY','ApiKey');
DEFINE('_UE_CBE_GEOCODER_CODERMETHOD','Api Connect');
DEFINE('_UE_CBE_GEOCODER_CODERMETHOD_DESC','Defines the method to connect to the api to gecode an address. Using HTTP means to use fsockupen() which not alle hosting provider allow, JavaScript should be selected in that case.');
DEFINE('_UE_CBE_GEOCODER_GOOGLE_APIKEY_DESC','Enter your Google-Maps Api Key. If you have com_google_maps installed that key will be used.');
DEFINE('_UE_CBE_GEOCODER_USERAGREE','User Agreement');
DEFINE('_UE_CBE_GEOCODER_USERAGREE_DESC','Set this to active to have a checkbox used by the user to agree to the usage of his GeoCoord in CBE.');
DEFINE('_UE_CBE_GEOCODER_LOCK_ADDR','Lock Addressfield');
DEFINE('_UE_CBE_GEOCODER_LOCK_ADDR_DESC','If geocoding generated data the address field(s) is locked to prevent recoding.');
DEFINE('_UE_CBE_GEOCODER_SHOW_ACC','Show Accuraty');
DEFINE('_UE_CBE_GEOCODER_SHOW_ACC_DESC','If enable geocoding will show the level of accuraty of returned results.');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD','Addr-Field to use');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD_DESC','If enabled the below entered DB-Names of  fields are used to read the address for geocoding.');
DEFINE('_UE_CBE_GEOCODER_SINGLE_ADDRFIELD','single field Address');
DEFINE('_UE_CBE_GEOCODER_SINGLE_ADDRFIELD_DESC','If enabled the user will only see one field for entering his address.');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD_AUTO','auto save');
DEFINE('_UE_CBE_GEOCODER_USE_ADDRFIELD_AUTO_DESC','On Save-Click, address is fetched, translated and save without further user interaction');
DEFINE('_UE_CBE_GEOCODER_ALLOW_DIRECTINPUT','Allow GeoCoord');
DEFINE('_UE_CBE_GEOCODER_ALLOW_DIRECTINPUT_DESC','If enabled a user has no need to geocode his address and can enter geoCoords directly.');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VISUALVERIFY','Visual verify');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VISUALVERIFY_DESC','As geocoding returns values or valid geoCoords are entered a google map is shown to visual verify the result.');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE','Allow reloaction');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE_DESC','(Drag&Drop) On visual verify it allows the drag and drop relocation of the marker updating geoCoords to use.');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE_ONCLICK','Reloaction on Click');
DEFINE('_UE_CBE_GEOCODER_VISUALRELOCATE_ONCLICK_DESC','(Click) On visual verify it allows the drag and drop relocation of the marker updating geoCoords to use.');
DEFINE('_UE_CBE_GEOCODER_FIELD_DBNAME','DB-Name');
DEFINE('_UE_CBE_GEOCODER_STREET_DBNAME','Street/Nr');
DEFINE('_UE_CBE_GEOCODER_POSTCODE_DBNAME','Postcode');
DEFINE('_UE_CBE_GEOCODER_CITY_DBNAME','City');
DEFINE('_UE_CBE_GEOCODER_STATE_DBNAME','State/Region');
DEFINE('_UE_CBE_GEOCODER_COUNTRY_DBNAME','Country');
DEFINE('_UE_CBE_GEOCODER_DO_EXPORT','export GeoCoords');
DEFINE('_UE_CBE_GEOCODER_DO_EXPORT_DESC','Writes GeoCoords also to cb_geolatitude & cb_geolongitude. These fields have to be created by the user!');
// usermap
DEFINE('_UE_PROFILE_GEOCODER_USERMAP_ADMIN_LABEL','GeoUserMap');
DEFINE('_UE_CBE_GEOCODER_SHOW_USERMAP','Show UserMap');
DEFINE('_UE_CBE_GEOCODER_SHOW_USERMAP_DESC','If active it allows the showing of the UserMap behind this CBE Funktion');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VIEWBYGID','Grant access to');
DEFINE('_UE_CBE_GEOCODER_ALLOW_VIEWBYGID_DESC','Set the lowest group to grant access to. All groups above that level will have access.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_HEIGHT','Height');
DEFINE('_UE_CBE_GEOCODER_USERMAP_HEIGHT_DESC','Height of map. Please use absolute values.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_WIDE','Wide');
DEFINE('_UE_CBE_GEOCODER_USERMAP_WIDE_DESC','Wide of map. Please use absolute values.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_XML_UPDATE_INTERVAL','XML Update Interval');
DEFINE('_UE_CBE_GEOCODER_USERMAP_XML_UPDATE_INTERVAL_DESC','Sets the time <b>in minutes</b> between updates of the XML coordination file. Zero means that you have to to the update by using the Tools.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SCANWIDE','Number of Users');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SCANWIDE_DESC','0 means to include all users. Every other number defines the maximum count of users to be included in the usermap.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER','Force Center');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_DESC','Force center of map on start to the given coordinates. If disabled the coordinates of a viewing user are used.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LAT','Latitute');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LAT_DESC','Value of Latitute.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LNG','Longitute');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCECENTER_LNG_DESC','Value of Longitute.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP','Force blur');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DESC','Limit the accuracy of GeoCoordinates to 6 digits behind the point. On manuel adjusted address-marker it blurs their placement.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DIGIT','Nr of digits');
DEFINE('_UE_CBE_GEOCODER_USERMAP_FORCEUNSHARP_DIGIT_DESC','Number of digits behind the point to use if unsharpness is activated.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SHOWSEARCH','Show Search');
DEFINE('_UE_CBE_GEOCODER_USERMAP_SHOWSEARCH_DESC','Adds a search line to the map. This can be used for easy repositioning of the mapcenter.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTZOOM','Zoom');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTZOOM_DESC','Set the level of zoom on map start and repositioning.');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTTYPE','Map-Typ');
DEFINE('_UE_CBE_GEOCODER_USERMAP_STARTTYPE_DESC','Set the typ of map on start.');
//
DEFINE('_UE_GEOCODER_USERMAP_NOT_ACTIVE','CBE UserMap feature is not activated.');
//
DEFINE('_UE_CBE_GEOCODER_Q_WORKING','..searching..');
DEFINE('_UE_CBE_GEOCODER_Q_OVERLOADBLOCK','Please wait 30 sec. between two tasks.');
DEFINE('_UE_CBE_GEOCODER_EDIT_LABEL','GeoCoder');
DEFINE('_UE_CBE_GEOCODER_E_ADDR','Address');
DEFINE('_UE_CBE_GEOCODER_E_BTN','check');
DEFINE('_UE_CBE_GEOCODER_CHANGE_BTN','change');
DEFINE('_UE_CBE_GEOCODER_CLEARALL_BTN','clear');
DEFINE('_UE_CBE_GEOCODER_E_STATUS','Status');
DEFINE('_UE_CBE_GEOCODER_E_ACC','Accuraty');
DEFINE('_UE_CBE_GEOCODER_E_GEOLNG','Longtitude');
DEFINE('_UE_CBE_GEOCODER_E_GEOLAT','Latitude');
DEFINE('_UE_CBE_GEOCODER_E_ALLOWVIEW','Allow visualisation');
DEFINE('_UE_CBE_GEOCODER_E_ALLOWVIEW_CHECKSAVED','.:show saved coordinates:.');
DEFINE('_UE_CBE_GEOCODER_E_QSUCCESS','Success');
DEFINE('_UE_CBE_GEOCODER_E_QFAILURE','Failure');
DEFINE('_UE_CBE_GEOCODER_E_QSTATUSRDB','Profile data');
DEFINE('_UE_CBE_GEOCODER_E_UNCHANCHED','Address unchanged');
DEFINE('_UE_CBE_GEOCODER_E_ASNOTDONE','GeoCoding unfinished');
DEFINE('_UE_CBE_GEOCODER_E_ASNOSUCCESS','GeoCoding: Address failure');
DEFINE('_UE_CBE_GEOCODER_E_ACC_ADDR','based on Address level');
DEFINE('_UE_CBE_GEOCODER_E_ACC_STREET','based on Street level');
DEFINE('_UE_CBE_GEOCODER_E_ACC_ZIPPLZ','based on ZIP level');
DEFINE('_UE_CBE_GEOCODER_E_ACC_CITY','based on City level');
DEFINE('_UE_CBE_GEOCODER_E_ACC_SUBREGION','based on Sub-Region level');
DEFINE('_UE_CBE_GEOCODER_E_ACC_REGION','based on Region level');
DEFINE('_UE_CBE_GEOCODER_E_ACC_COUNTRY','based on Country level');
DEFINE('_UE_CBE_GEOCODER_F_DISTANCE','Distance');
DEFINE('_UE_CBE_GEOCODER_F_m','m');
DEFINE('_UE_CBE_GEOCODER_F_Km','Km');
DEFINE('_UE_CBE_GEOCODER_F_NODATA','n/a');
//
DEFINE('_UE_CBE_JS_SWITCH','JS Inclusion');
DEFINE('_UE_CBE_JS_SWITCH_DESC','Sets if JavaScript should be included by a calling javascript tag or piped directly into the page source.');
//
DEFINE('_UE_CBE_ADMODS_M','AdminModule Management');
DEFINE('_UE_CBE_ADMODS_M_EDIT','Edit AdminModule');
DEFINE('_UE_CBE_ADMODS_M_ADD','Add AdminModule');
DEFINE('_UE_CBE_ADM_POSITION','Position');
DEFINE('_UE_CBE_ADM_PUBLISHED','Activated');
DEFINE('_UE_CBE_ADM_MODULE','Name of Module');
DEFINE('_UE_CBE_ADM_MODULE_DESC','Please give name of the module without the prefix cbe_ and the postfix .php.');
DEFINE('_UE_CBE_ADM_PLUGIN_NAME','Plugin-File');
DEFINE('_UE_CBE_ADM_PLUGIN_NAME_DESC','The file to include has to be given without the postfix .php.');
DEFINE('_UE_CBE_ADM_PLUGIN_FUNC','included Functions');
DEFINE('_UE_CBE_ADM_PLUGIN_FUNC_DESC','Name of functions have to be given without brackets and must be sepperated by comma.');
DEFINE('_UE_CBE_ADM_DOUBLET_ERROR','Parameters already in use!');
//
DEFINE('_UE_CB_ENHANCED','CB Enhanced by');
?>
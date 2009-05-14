<?php
/*************************************************************
* Mambo Community Builder
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//Field Labels
DEFINE('_UE_HITS','Hits');
DEFINE('_UE_USERNAME','Username');
DEFINE('_UE_Address','Address');
DEFINE('_UE_City','City');
DEFINE('_UE_State','State');
DEFINE('_UE_PHONE','Phone #');
DEFINE('_UE_FAX','Fax #');
DEFINE('_UE_ZipCode','Zip Code');
DEFINE('_UE_Country','Country');
DEFINE('_UE_Occupation','Occupation');
DEFINE('_UE_Company','Company');
DEFINE('_UE_Interests','Interests');
DEFINE('_UE_Birthday','Birthday');
DEFINE('_UE_AVATAR','Picture');
DEFINE('_UE_Website','Website');
DEFINE('_UE_Location','Location');
DEFINE('_UE_EDIT_TITLE','Edit Your Details');
DEFINE('_UE_YOUR_NAME','Name');
DEFINE('_UE_EMAIL','Email');
DEFINE('_UE_UNAME','User Name');
DEFINE('_UE_PASS','Password');
DEFINE('_UE_VPASS','Verify Password');
DEFINE('_UE_SUBMIT_SUCCESS','Submission Success!');
DEFINE('_UE_SUBMIT_SUCCESS_DESC','Your item has been successfully submitted to our administrators. It will be reviewed before being published on this site.');
DEFINE('_UE_WELCOME','Welcome!');
DEFINE('_UE_WELCOME_DESC','Welcome to the user section of our site');
DEFINE('_UE_CONF_CHECKED_IN','Checked out items have now been all checked in');
DEFINE('_UE_CHECK_TABLE','Checking table');
DEFINE('_UE_CHECKED_IN','Checked in ');
DEFINE('_UE_CHECKED_IN_ITEMS',' items');
DEFINE('_UE_PASS_MATCH','Passwords do not match');
DEFINE('_UE_USERNAME_DESC','Set to &quot;Yes&quot; to allow the username to be changed. If set to &quot;No&quot; then the username will not be editable after registration.');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR','User Hide Email');
DEFINE('_UE_ALLOW_EMAIL_USERCONTR_DESC','Yes will allow the user to be able to hide their email address from the public. NOTE: This setting will only control the display of email within this component!');
DEFINE('_UE_USERAPPROVAL_SUCCESSFUL','User(s) was succesfully approved!');

//Front End Profile Lables
DEFINE('_UE_MEMBERSINCE','Member Since');
DEFINE('_UE_LASTONLINE','Last Online');
DEFINE('_UE_ONLINESTATUS','Online Status');
DEFINE('_UE_ISONLINE','ONLINE');
DEFINE('_UE_ISOFFLINE','OFFLINE');
DEFINE('_UE_PROFILE_TITLE',' Profile Page');
DEFINE('_UE_UPDATEPROFILE','Update Your Profile');
DEFINE('_UE_UPDATEAVATAR','Update Your Image');
DEFINE('_UE_CONTACT_INFO_HEADER','Contact Info');
DEFINE('_UE_ADDITIONAL_INFO_HEADER','Additional Information');
DEFINE('_UE_REQUIRED_ERROR','This field is required!');
DEFINE('_UE_FIELD_REQUIRED',' Required!');
DEFINE('_UE_DELETE_AVATAR',' Remove Image');

//Administrator Tab Names
DEFINE('_UE_USERPROFILE','User Profile');
DEFINE('_UE_USERLIST','User List');
DEFINE('_UE_AVATARS','Images');
DEFINE('_UE_REGISTRATION','Registration');
DEFINE('_UE_SUBSCRIPTION','Subscriptions');
DEFINE('_UE_INTEGRATION','Integration');

//Administrator Integration Tab
DEFINE('_UE_PMS','myPMS2 Private Messaging');
DEFINE('_UE_PMS_DESC','Set to &quot;No&quot; if you do not have myPMS2 installed for Private Messaging otherwise pick which version you want to integrate with.');


//Administrator Labels
DEFINE('_UE_FIELD_NAME','Field Name');
DEFINE('_UE_EXPLANATION','Explanation');
DEFINE('_UE_FIELD_EXPLAINATION','Decide if you want this field to be required and to show to the user.');
DEFINE('_UE_CONFIG','Configuration');
DEFINE('_UE_CONFIG_DESC','Change the configuration');
DEFINE('_UE_VERSION','Your version is ');
DEFINE('_UE_BY','A Mambo 4.5 Custom Component by');
DEFINE('_UE_CURRENT_SETTINGS','Current Setting');
DEFINE('_UE_A_EXPLANATION','Explanation');
DEFINE('_UE_DISPLAY','Display?');
DEFINE('_UE_REQUIRED','Required?');
DEFINE('_UE_YES','Yes');
DEFINE('_UE_NO','No');

//Admin Avatar Tab Labels
DEFINE('_UE_AVATAR_DESC','Set to &quot;Yes&quot; if you want registered users to have an image (manageable through their profile)');
DEFINE('_UE_AVHEIGHT','Max. Image Height');
DEFINE('_UE_AVWIDTH','Max. Image Width');
DEFINE('_UE_AVSIZE','Max. Image Filesize<br/><em>in Kilobyte</em>');
DEFINE('_UE_AVATARUPLOAD','Allow Image Upload');
DEFINE('_UE_AVATARUPLOAD_DESC','Set to &quot;Yes&quot; if you want registered users to be able to upload an image.');
DEFINE('_UE_AVATARGALLERY','Use Image Gallery');
DEFINE('_UE_AVATARGALLERY_DESC','Set to &quot;Yes&quot; if you want registered users to be able to choose an image from a Gallery.');
DEFINE('_UE_TNWIDTH','Max. Thumbnail Width');
DEFINE('_UE_TNHEIGHT','Max. Thumbnail Height');

//Admin User List Tab Labels
DEFINE('_UE_USERLIST_TITLE','User List Title');
DEFINE('_UE_USERLIST_TITLE_DESC','User List Title');
DEFINE('_UE_LISTVIEW','List');
DEFINE('_UE_PICTLIST','Picture List');
DEFINE('_UE_PICTDETAIL','Picture Detail');
DEFINE('_UE_NUM_PER_PAGE','Users Per Page');
DEFINE('_UE_NUM_PER_PAGE_DESC','Number of Users Per Page');
DEFINE('_UE_VIEW_TYPE','Display Type');
DEFINE('_UE_VIEW_TYPE_DESC','Display Type');
DEFINE('_UE_ALLOW_EMAIL','Email Links');
DEFINE('_UE_ALLOW_EMAIL_DESC','Allow Email Links. NOTE: this setting only applies to custom fields of type email');
DEFINE('_UE_ALLOW_WEBSITE','Website Links');
DEFINE('_UE_ALLOW_WEBSITE_DESC','Allow Website Links');
DEFINE('_UE_ALLOW_IM','Instant Messenging Links');
DEFINE('_UE_ALLOW_IM_DESC','Allow Instant Messenging Links');
DEFINE('_UE_ALLOW_ONLINESTATUS','Online Status');
DEFINE('_UE_ALLOW_ONLINESTATUS_DESC','Show Online Status');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY_DESC','NOTE: This setting only applies to the users primary email address.');

//Admin Moderate Tab labels
DEFINE('_UE_MODERATE','Moderation');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP','Moderator Groups');
DEFINE('_UE_AVATARUPLOADAPPROVALGROUP_DESC','All users in the group selected and above will be moderators.');
DEFINE('_UE_ALLOWUSERREPORTS','Allow User Reports');
DEFINE ('_UE_ALLOWUSERREPORTS_DESC','Allows users to report inappropriate behavior of other users to moderators.');
DEFINE ('_UE_AVATARUPLOADAPPROVAL','Require Upload Image Approval');
DEFINE ('_UE_AVATARUPLOADAPPROVAL_DESC','Require all images uploaded by users to be approved prior to being displayed.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING_DESC','Allows moderators to prevent a users profile from being publicly displayed.');
DEFINE ('_UE_ALLOWUSERPROFILEBANNING','Allow Profile Banning');

//Admin Registration tab labels
DEFINE('_UE_NAME_FORMAT','Name Format');
DEFINE('_UE_DATE_FORMAT','Date Format');
DEFINE('_UE_NAME_FORMAT_DESC','Choose which format you would like the Name/Username fields to be displayed.');
DEFINE('_UE_DATE_FORMAT_DESC','Choose which date format you would like your date fields to be dispayed in.');
DEFINE ('_UE_REG_CONFIRMATION_DESC','Set yes to send an email to users upon registration with a confirmation link.');
DEFINE ('_UE_REG_CONFIRMATION','Require Email Confirmation');
DEFINE ('_UE_REG_ADMIN_APPROVAL','Require Admin Approval');
DEFINE ('_UE_REG_ADMIN_APPROVAL_DESC','Require all user registrations to be approved by an administrator');
DEFINE ('_UE_REG_EMAIL_NAME','Registration Email Name');
DEFINE ('_UE_REG_EMAIL_NAME_DESC','Please enter the name that you want to be displayed when sending email');
DEFINE ('_UE_REG_EMAIL_FROM','Registraton Email Address');
DEFINE ('_UE_REG_EMAIL_FROM_DESC','Email address you want to when emailing registrants');
DEFINE ('_UE_REG_EMAIL_REPLYTO','Registration Reply To Email Address');
DEFINE ('_UE_REG_EMAIL_REPLYTO_DESC','Email address you want be used as the reply-to addressed');
DEFINE ('_UE_REG_PEND_APPR_MSG','Pending Approval Email');
DEFINE ('_UE_REG_WELCOME_MSG','Welcome Email');
DEFINE ('_UE_REG_REJECT_MSG','Rejection Email');
DEFINE ('_UE_REG_PEND_APPR_SUB','Pending Approval Subject');
DEFINE ('_UE_REG_WELCOME_SUB','Welcome Subject');
DEFINE ('_UE_REG_PEND_APPR_SUB_DESC','Pending Approval Subject');
DEFINE ('_UE_REG_WELCOME_SUB_DESC','Welcome Subject');
DEFINE ('_UE_REG_REJECT_SUB_DESC','Rejection Subject');
DEFINE ('_UE_REG_SIGNATURE','Email Signature');
DEFINE ('_UE_REG_ADMIN_PA_SUB','ACTION REQUIRED! New User Registration Pending Approval');
DEFINE ('_UE_REG_ADMIN_PA_MSG','A new user has registered at [SITEURL] and requires approval.\n'
.'This email contains their details\n\n'
.'Name - [NAME]\n'
.'e-mail - [EMAILADDRESS]\n'
.'Username - [USERNAME]\n\n\n'
.'Please do not respond to this message as it is automatically generated and is for information purposes only\n');
DEFINE ('_UE_REG_ADMIN_SUB','New User Registration');
DEFINE ('_UE_REG_ADMIN_MSG','A new user has registered at [SITEURL].\n'
.'This email contains their details\n\n'
.'Name - [NAME]\n'
.'e-mail - [EMAILADDRESS]\n'
.'Username - [USERNAME]\n\n\n'
.'Please do not respond to this message as it is automatically generated and is for information purposes only\n');
DEFINE('_UE_REG_EMAIL_TAGS','[NAME] - Name of the User<br />'
.'[USERNAME] - Username of the User<br />'
.'[DETAILS] - Account Details of the User such as Email Address, Username, and Password<br />'
.'[CONFIRM] - Inserts confirmation link if the confirmation functionality is enabled<br />');

//Registration form
DEFINE('_UE_REG_COMPLETE_NOPASS','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'Your password has been sent to the e-mail address you entered.<br />&nbsp;&nbsp;'
.'When you receive your password you will then be able to login.');
DEFINE('_UE_REG_COMPLETE','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'You may now login.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'Your registration reqiures approval.  Once approved your password will be sent to the e-mail address you entered.<br />&nbsp;&nbsp;'
.'When you receive approval and a password you will then be able to login.');
DEFINE('_UE_REG_COMPLETE_NOAPPR','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'Your registration reqiures approval.  Once approved you will be sent an acceptance notice to the e-mail address you entered.<br />&nbsp;&nbsp;'
.'When you receive approval then you will be able to login.');
DEFINE('_UE_REG_COMPLETE_CONF','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'An email with further instructions on how to complete your registration has been sent to the email address you provided.  Please check your email to complete your registration.<br />&nbsp;&nbsp;');
DEFINE('_UE_REG_COMPLETE_NOPASS_CONF','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'Your password has been sent to the e-mail address you entered.<br />&nbsp;&nbsp;'
.'When you receive your password and follow the confirmation instructions you will then be able to login.');

// User List Labels
DEFINE ('_UE_HAS','has');
DEFINE ('_UE_USERS','registered users');
DEFINE ('_UE_SEARCH_ALERT','Please enter a value to search!');
DEFINE ('_UE_SEARCH','Find User');
DEFINE ('_UE_ENTER_EMAIL','Enter users Email, Name or Username');
DEFINE ('_UE_SEARCH_BUTTON','Search');
DEFINE ('_UE_SHOW_ALL','Show All Users');
DEFINE ('_UE_NAME','Name');
DEFINE ('_UE_UL_USERNAME','User Name');
DEFINE ('_UE_USERTYPE','Usertype');
DEFINE ('_UE_VIEWPROFILE','View Profile');
DEFINE ('_UE_LIST_ALL','List all');
DEFINE ('_UE_PAGE','Page');
DEFINE ('_UE_RESULTS','Results');
DEFINE ('_UE_OF_TOTAL','of total');
DEFINE ('_UE_NO_RESULTS','No results');
DEFINE ('_UE_FIRST_PAGE','Start');
DEFINE ('_UE_PREV_PAGE','Prev');
DEFINE ('_UE_NEXT_PAGE','Next');
DEFINE ('_UE_END_PAGE','End');
DEFINE('_UE_CONTACT','Contact');
DEFINE('_UE_INSTANT_MESSAGE','Instant Message');
DEFINE('_UE_IMAGEAVAILABLE','Photo');
DEFINE('_UE_INFO','Info');
DEFINE('_UE_PROFILE','Profile');
DEFINE('_UE_PRIVATE_MESSAGE','PM');
DEFINE('_UE_ADDITIONAL','Aditional Info');
DEFINE('_UE_NO_DATA','Not Supplied');
DEFINE('_UE_CLICKTOVIEW','Click for');
DEFINE('_UE_UL_USERNAME_NAME','Username(Name)');
DEFINE('_UE_PM','PM');
DEFINE('UE_PM_USER','Send Private Message');

//mod_userextraslogin
DEFINE('_UE_NO_ACCOUNT','No account yet?');
DEFINE('_UE_CREATE_ACCOUNT','Create one');
DEFINE('_LOGIN_NOT_CONFIRMED','Your registration process is not yet complete! Please check your email for further instructions.');
DEFINE('_LOGIN_NOT_APPROVED','Your account has not yet been approved!');
DEFINE('_UE_USER_CONFIRMED','Your account is now active.  You may now login!');
DEFINE('_UE_USER_NOTCONFIRMED','Your account is not yet active.  Please check your email and follow the instructions to complete the registration process.');


//Avatar
DEFINE('_UE_UPLOAD_UPLOAD','Upload');
DEFINE('_UE_UPLOAD_DIMENSIONS','Your image file can be maximum (width x height - size)');
DEFINE('_UE_UPLOAD_SUBMIT','Submit a new Image for Upload');
DEFINE('_UE_UPLOAD_SELECT_FILE','Select file');
DEFINE('_UE_UPLOAD_ERROR_TYPE','Please use only jpeg, jpg or png images');
DEFINE('_UE_UPLOAD_ERROR_EMPTY','Please select a file before uploading');
DEFINE('_UE_UPLOAD_ERROR_NAME','The image file must only contain alphanumeric characters and no spaces please.');
DEFINE('_UE_UPLOAD_ERROR_SIZE','The image file size exceeds the maximum the Administrator has set.');
DEFINE('_UE_UPLOAD_ERROR_WIDTHHEIGHT','The image height or width exceeds the maximum the Administrator has set.');
DEFINE('_UE_UPLOAD_ERROR_WIDTH','The image file width exceeds the maximum the Administrator has set.');
DEFINE('_UE_UPLOAD_ERROR_HEIGHT','The image file height exceeds the maximum the Administrator has set.');
DEFINE('_UE_UPLOAD_ERROR_CHOOSE',"You didn't choose an Image from the gallery..");
DEFINE('_UE_UPLOAD_UPLOADED','Your image has been uploaded.');
DEFINE('_UE_UPLOAD_GALLERY','Choose one from the Image Gallery');
DEFINE('_UE_UPLOAD_CHOOSE','Confirm Choice.');
DEFINE('_UE_UPLOAD_UPDATED','Your image has been set.');
DEFINE('_UE_USER_PROFILE_NOT','Your profile could not be updated.');
DEFINE('_UE_USER_PROFILE_UPDATED','Your profile is updated.');
DEFINE('_UE_USER_RETURN_A','If you are not taken back to your profile in a few moments ');
DEFINE('_UE_USER_RETURN_B','click here');
//DEFINE('_UPDATE','UPDATE');

//Moderator
DEFINE('_UE_USERPROFILEBANNED','This profile has been banned by a moderator.');
DEFINE('_UE_REQUESTUNBANPROFILE','Submit Unban Request');
DEFINE('_UE_REPORTUSER','Report User');
DEFINE('_UE_BANPROFILE','Ban Profile');
DEFINE('_UE_UNBANPROFILE','Unban Profile');
DEFINE('_UE_REPORTUSER_TITLE','Report User');
DEFINE('_UE_USERREASON','Reason for User Report');
DEFINE('_UE_BANREASON','Reason for Ban');
DEFINE('_UE_SUBMITFORM','Submit');
DEFINE('_UE_NOUNBANREQUESTS','No Unban Requests to Process');
DEFINE('_UE_IMAGE_MODERATE','Moderate Images');
DEFINE('_UE_APPROVE_IMAGES','Approve');
DEFINE('_UE_REJECT_IMAGES','REJECT');
DEFINE('_UE_MODERATE_TITLE','Moderator');
DEFINE('_UE_NOIMAGESTOAPPROVE','No Images to Process');
DEFINE('_UE_USERREPORT_MODERATE','Moderate User Reports');
DEFINE('_UE_REPORT','Report');
DEFINE('_UE_REPORTEDONDATE','Report Date');
DEFINE('_UE_REPORTEDUSER','Reported User');
DEFINE('_UE_REPORTEDBY','Reported By');
DEFINE('_UE_PROCESSUSERREPORT','Process');
DEFINE('_UE_NONEWUSERREPORTS','No New User Reports');
DEFINE('_UE_USERUNBAN_SUCCESSFUL','Users profile unbanned successfully.');
DEFINE('_UE_REPORTUSERSACTIVITY','Describe User Activity');
DEFINE('_UE_USERREPORT_SUCCESSFUL','User report submitted successfully.');
DEFINE('_UE_USERBAN_SUCCESSFUL','User Profile Ban Successful.');
DEFINE('_UE_FUNCTIONALITY_DISABLED','This functionality is currently disabled.');
DEFINE('_UE_UPLOAD_PEND_APPROVAL','Your image is now pending moderator approval.');
DEFINE('_UE_UPLOAD_SUCCESSFUL','Your image was successfully uploaded.');
DEFINE('_UE_UNBANREQUEST','Unban Profile Request');
DEFINE('_UE_USERUNBANREQUEST_SUCCESSFUL','Your unban profile request was submitted successfully.');
DEFINE('_UE_USERREPORT','User Report');
DEFINE('_UE_VIEWUSERREPORTS','View User Reports');
DEFINE('_UE_USERREQUESTRESPONSE','View User Reports');
DEFINE('_UE_MODERATORREQUESTRESPONSE','View User Reports');
DEFINE('_UE_REPORTBAN_TITLE','Ban Report');
DEFINE('_UE_REPORTUNBAN_TITLE','Ban Report');

DEFINE('_UE_UNBANREQUIREACTION',' Unban request(s)');
DEFINE('_UE_USERREPORTSREQUIREACTION','User report(s)');
DEFINE('_UE_IMAGESREQUIREACTION','Image(s)');
DEFINE('_UE_NOACTIONREQUIRED','No Pending Actions');

DEFINE('_UE_UNBAN_MODERATE','Unban Profile Requests');
DEFINE('_UE_BANNEDUSER','Banned User');
DEFINE('_UE_BANNEDREASON','Banned Reason');
DEFINE('_UE_BANNEDON','Banned Date');
DEFINE('_UE_BANNEDBY','Banned By');

DEFINE('_UE_MODERATORBANRESPONSE','Moderator Response');
DEFINE('_UE_USERBANRESPONSE','User Response');

DEFINE('_UE_IMAGE_ADMIN_SUB','Image Pending Approval');
DEFINE('_UE_IMAGE_ADMIN_MSG','User [USERNAME] has submitted an image for approval. Please login and take the appropriate action.');
DEFINE('_UE_USERREPORT_SUB','User Report Pending Review');
DEFINE('_UE_USERREPORT_MSG','A user has submitted a report regarding a user that requires your review.  Please login and take the appropriate action.');
DEFINE('_UE_IMAGEAPPROVED_SUB','Image Approved');
DEFINE('_UE_IMAGEAPPROVED_MSG','Your image has been approved by a moderator.');
DEFINE('_UE_IMAGEREJECTED_SUB','Image Rejected');
DEFINE('_UE_IMAGEREJECTED_MSG','Your image has been rejected by a moderator.  Please login and submit a new image.');
DEFINE('_UE_BANUSER_SUB','User Profile Banned.');
DEFINE('_UE_BANUSER_MSG','Your user profile was banned by an administrator.  Please login and review why it was banned.');
DEFINE('_UE_UNBANUSER_SUB','User Profile Unbanned');
DEFINE('_UE_UNBANUSER_MSG','Your user profile was unbanned by an administrator.  Your profile is now visible to all users again.');
DEFINE('_UE_UNBANUSERREQUEST_SUB','Unban Request Pending Review');
DEFINE('_UE_UNBANUSERREQUEST_MSG','A user has submitted a request to unban their profile.  Please login and take the appropriate action.');


//Alpha 3 Build
DEFINE('_UE_IMAGE','Thumbnail');
DEFINE('_UE_FORMATNAME','Formatted Name');

//Alpha 4 Build
DEFINE('_UE_ADMINREQUIREDFIELDS','Required Fields in Admin');
DEFINE('_UE_ADMINREQUIREDFIELDS_DESC','Set to Yes to make the User Management section in the administrator respect the required setting of fields and set to No to ignore the required status in the admin user management.');
DEFINE('_UE_CANCEL','Cancel');
DEFINE('_UE_NA','N/A');
DEFINE('_UE_MODERATOREMAIL','Send Moderators Email');
DEFINE('_UE_MODERATOREMAIL_DESC','If Yes moderators will receive emails when actions happen that require their attention.');

//Beta 1 Build
DEFINE('_UE_UPDATE','Update');

//Beta 2 Build
DEFINE('_UE_FIELDONPROFILE','This Field IS visible on profile');
DEFINE('_UE_FIELDNOPROFILE','This Field IS NOT visible on profile');
DEFINE('_UE_FIELDREQUIRED','This Field is required');
DEFINE('_UE_NOT_AUTHORIZED','You are not authorized to view this page!');
DEFINE('_UE_ALLOW_LISTVIEWBY','Allow Access To:');
DEFINE('_UE_ALLOW_LISTVIEWBY_DESC','Pick the group that you want to be able to view the list.  All users of that level and above will have access.');
DEFINE('_UE_ALLOW_PROFILEVIEWBY','Allow Access To:');
DEFINE('_UE_ALLOW_PROFILEVIEWBY_DESC','Pick the group that you want to be able to view the profiles.  All users of that level and above will have access.');

//Beta 3 Build
DEFINE('_UE_NOLISTFOUND','There are no published user lists!');
DEFINE('_UE_ALLOW_PROFILELINK','Allow Link to Profile');
DEFINE('_UE_ALLOW_PROFILELINK_DESC','Select Yes to allow each row to link to the related users profile and No to prevent profile links on lists.');
DEFINE('_UE_REGISTERFORPROFILE','Please login or Register to view or modify your profile.');
DEFINE('_UE_UPLOAD_ERROR_GDNOTINSTALLED','The GD2 Image Library is either not installed or not compiled with PHP!  Please notify your systems administrator to disable Auto Image Resize.');
DEFINE('_UE_UPLOAD_ERROR_UPLOADFAILED','An error occurred uploading/processing the image!');
DEFINE('_UE_TOC','Accept Terms and Conditions');
DEFINE('_UE_TOC_REQUIRED','You must accept the Terms and Conditions before registering!');
DEFINE('_UE_REG_TOC_MSG','Enable Terms &amp; Conditions');
DEFINE('_UE_REG_TOC_DESC','Set to Yes to require users to accept your terms and conditions before registering!');
DEFINE('_UE_REG_TOC_URL_MSG','URL To Terms &amp; Conditions');
DEFINE('_UE_REG_TOC_URL_DESC','Enter the URL to your terms &amp; conditions.');
DEFINE('_UE_LASTUPDATEDON','Last Updated');

//Beta 4 Build
DEFINE('_UE_EMAILFORMWARNING','IMPORTANT: If you continue your email address will become available to the user who you are emailing.');
DEFINE('_UE_EMAILFORMSUBJECT','Subject:');
DEFINE('_UE_EMAILFORMMESSAGE','Message:');
DEFINE('_UE_EMAILFORMINSTRUCT','Send a message via email to <a href="index.php?option=com_cbe&amp;task=UserDetails&amp;user=%s">%s </a>.');
DEFINE('_UE_GENERAL','General');
DEFINE('_UE_SENDEMAILNOTICE','NOTE:This is a message from %s at %s ( %s ).  This user did not see your email address. If you reply the receipent will have your email address.  %s owners cannot accept any responsibility for the contents of the email.');
DEFINE('_UE_SENDEMAIL','Send Email');
DEFINE('_UE_SENTEMAILSUCCESS','Your email was sent successfully!');
DEFINE('_UE_SENTEMAILFAILED','Your email failed to send!  Please try again.');
DEFINE('_UE_ALLOW_EMAIL_DISPLAY','Email Handling');
DEFINE('_UE_REGISTERDATE','Date Registered');
DEFINE('_UE_ACTION','Action');
DEFINE('_UE_USER','User');
DEFINE('_UE_USERAPPROVAL_MODERATE','User Approval/Rejection');
DEFINE('_UE_USERPENDAPPRACTION',' User(s)');
DEFINE('_UE_APPROVEUSER','Process User(s)');
DEFINE('_UE_REG_REJECT_SUB','Your registration has been rejected!');
DEFINE('_UE_USERREJECT_MSG','Your registration at %s has been rejected for the following reason: \n %s');
DEFINE('_UE_COMMENT','Reject Comment');
DEFINE('_UE_APPROVE','Approve');
DEFINE('_UE_REJECT','Reject');
DEFINE('_UE_USERREJECT_SUCCESSFUL','The user(s) have been successfully rejected!');
DEFINE('_UE_USERAPPROVE_SUCCESSFUL','The user(s) have been successfully approved!');
DEFINE('_LOGIN_REJECTED','Your request for registration was rejected!');
DEFINE('_UE_EMAILFOOTER','NOTE: This email was automatically generated from %s (%s).');
DEFINE('_UE_MODERATORUSERAPPOVAL','Moderator Approve Users');
DEFINE('_UE_MODERATORUSERAPPOVAL_DESC','This configuration allows Moderators to approve users pending approval via the front end of the website.');
DEFINE('_UE_REG_COMPLETE_NOAPPR_CONF','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'Your registration requires approval and email confirmation. Please follow the confirmation steps sent to you in email. Once approved you will be sent an acceptance notice to the e-mail address you entered.<br />&nbsp;&nbsp;'
.'When you receive approval then you will be able to login.');
DEFINE('_UE_REG_COMPLETE_NOPASS_NOAPPR_CONF','<span class="componentheading">Registration Complete!</span><br />&nbsp;&nbsp;'
.'Your registration reqiures approval and email confirmation.  Please follow the confirmation steps sent to you in email. <br />&nbsp;&nbsp;'
.'When you receive approval a password will be emailed to you and you will then be able to login.');
DEFINE('_UE_NAME_STYLE','Name Style');
DEFINE('_UE_NAME_STYLE_DESC','The name style details how you what to capture the name field in mambo.');
DEFINE('_UE_USER_CONFIRMED_NEEDAPPR','Thank you for confirming your Email Address.  Your account requires approval by a moderator.  You will receive an email with the outcome of the review.');
DEFINE('_UE_YOUR_FNAME','First Name');   
DEFINE('_UE_YOUR_MNAME','Middle Name');
DEFINE('_UE_YOUR_LNAME','Last Name');

//RC 1 Build
DEFINE('_UE_NOSELFEMAIL','You are not allowed to send an email to yourself!');
DEFINE('_UE_PROFILETAB','Profile');
DEFINE('_UE_AUTHORTAB','Articles');
DEFINE('_UE_FORUMTAB','Forum');
DEFINE('_UE_BLOGTAB','Blog');
DEFINE('_UE_ARTICLEDATE','Date');
DEFINE('_UE_ARTICLETITLE','Title');
DEFINE('_UE_ARTICLERATING','Rating');
DEFINE('_UE_ARTICLEHITS','Hits');
DEFINE('_UE_FORUMDATE','Date');
DEFINE('_UE_FORUMCATEGORY','Category');
DEFINE('_UE_FORUMSUBJECT','Subject');
DEFINE('_UE_FORUMHITS','Hits');
DEFINE('_UE_FORUM_TOP10','Last 10 Forum Posts');
DEFINE('_UE_FORUM_STATS','Forum Statistics');
DEFINE('_RANK_MODERATOR','Moderator');
DEFINE('_RANK_ADMINISTRATOR','Administrator');
DEFINE('_UE_SBNOTINSTALLED','Simpleboard forum component is not installed.  Please contact your site administrator.');
DEFINE('_UE_NOFORUMPOSTS','This user has no forum posts.');
DEFINE('_UE_NESTTABS','Nest Tabs');
DEFINE('_UE_NESTTABS_DESC','Nest all tabs under a single profile panel.  This is very helpful when there are large amounts of tabs.');
DEFINE('_UE_TEMPLATEDIR','Tab Template');
DEFINE('_UE_TEMPLATEDIR_DESC','Select a template to apply to the tabs used throughout community builder.');
DEFINE('_UE_MAMBLOGNOTINSTALLED','Mamblog blogger component is not installed.  Please contact your site administrator.');
DEFINE('_UE_BLOGDATE','Date');
DEFINE('_UE_BLOGTITLE','Title');
DEFINE('_UE_BLOGHITS','Hits');
DEFINE('_UE_NOBLOGS','This user has no published blog entries.');
DEFINE('_UE_NOARTICLES','This user has no published articles.');
DEFINE('_UE_IMPATH','Path to ImageMagick');
DEFINE('_UE_IMPATH_DESC','Path to ImageMagick');
DEFINE('_UE_NETPBMPATH','Path to NetPBM');
DEFINE('_UE_NETPBMPATH_DESC','Path to NetPBM');
DEFINE('_UE_AUTODET','Auto dectected');
DEFINE('_UE_ERROR_NOTINSTALLED','Not installed');
DEFINE('_UE_CONVERSIONTYPE','Image Software');
DEFINE('_UE_NEWPASS_FAILED','Password Reset Failed!');
DEFINE('_UE_USER_SUBSCRIPTIONS','Your Subscriptions');
DEFINE('_UE_THREAD_UNSUBSCRIBE',':: unsubscribe ::');
DEFINE('_UE_USER_NOSUBSCRIPTIONS','No subscriptions found for you');
DEFINE('_UE_GEN_BY','by');
DEFINE('_UE_USER_UNSUBSCRIBE_ALL','Unsubscribe from all');
DEFINE('_UE_USERREPORTMODERATED_SUCCESSFUL','User Report Successfully Moderated!');
DEFINE('_UE_USERIMAGEMODERATED_SUCCESSFUL','User Image Successfully Moderated!');
DEFINE('_UE_NOREPORTSTOPROCESS','No User Reports to Process');
DEFINE('_UE_NOUSERSPENDING','No Users Pending Approval');
DEFINE('_UE_BLANK','');
DEFINE('_UE_REG_FIRST_VISIT_URL_MSG','URL for first login visit');
DEFINE('_UE_REG_FIRST_VISIT_URL_DESC','Enter the URL to display on the very first
login after registration. This page may contain your welcome message to new members
and/or special instructions, or redirect the user to complete his profile. Leave
blank for normal login also the first time.');
DEFINE('_UE_NOSUCHPROFILE','This profile does not exist or is no longer available');

//SB Integration Support
DEFINE('_UE_SB_TABTITLE','Forum settings');
DEFINE('_UE_SB_TABDESC','These are your forum settings');
DEFINE('_UE_SB_VIEWTYPE_TITLE','Preferred viewtype');
DEFINE('_UE_SB_VIEWTYPE_FLAT','Flat');
DEFINE('_UE_SB_VIEWTYPE_THREADED','Threaded');
DEFINE('_UE_SB_ORDERING_TITLE','Preferred message ordering');
DEFINE('_UE_SB_ORDERING_OLDEST','Oldest post first');
DEFINE('_UE_SB_ORDERING_LATEST','Latest post first');
DEFINE('_UE_SB_SIGNATURE','Signature');
//added for SB 1.5 during 1.0 RC 1
DEFINE('_UE_SB_POSTSPERPAGE','Posts per page'); 
DEFINE('_UE_SB_USERTIMEOFFSET','Local time offset from server');

//Not used within application but are needed to translate default images for profile.
DEFINE('_UE_IMG_NOIMG','No Image');
DEFINE('_UE_IMG_PENDIMG','Pending Approval');

DEFINE('_PROMPT_PASSWORD', 'Recover Password');

// hinzugefuegt von www.joomla-cbe.de
DEFINE('_UE_REG_TITLE', 'Registration');
DEFINE('_UE_REG_UNAME', 'Username:');
DEFINE('_UE_REG_EMAIL', 'E-Mail:');
DEFINE('_UE_REG_PASS', 'Password:');
DEFINE('_UE_REG_VPASS', 'Verify Password:');
DEFINE('_BUTTON_SEND_REG', 'Submit');
DEFINE('_USER_DETAILS_SAVE', "The changes have been saved.");

DEFINE('_SEL_CATEGORY', 'Please select category');
//DEFINE('_PROMPT_PASSWORD', 'Lost password');
DEFINE('_NEW_PASS_DESC', 'Create new password');
DEFINE('_PROMPT_UNAME', 'Username');
DEFINE('_PROMPT_EMAIL', 'Email');
DEFINE('_BUTTON_SEND_PASS', 'Send Password');
DEFINE('_ERROR_PASS', 'Wrong username and/or password');

DEFINE('_LOGIN_INCORRECT', 'Wrong username and/or password');
DEFINE('_VALID_AZ09', 'The format of the username and/or password is wrong.');

?>
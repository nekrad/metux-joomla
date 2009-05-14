<?php

// include for AcctExp RC1

/**
* AcctExp Component
* @package AcctExp
* @copyright 2004-2006 Helder Garcia, David Deutsch
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @version $Revision: 1.2 $
* @author Helder Garcia <helder.garcia@gmail.com>, David Deutsch <skore@skore.de>
**/
//
// Copyright (C) 2004-2006 Helder Garcia, David Deutsch
// All rights reserved.
// This source file is part of the Account Expiration Control Component, a  Joomla
// custom Component By Helder Garcia and David Deutsch - http://www.globalnerd.org
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// Please note that the GPL states that any headers in files and
// Copyright notices as well as credits in headers, source files
// and output (screens, prints, etc.) can not be removed.
// You can extend them with your own credits, though...
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
// ----------- CONTRIBUTIONS ----------
// "Expire Now" feature contributed by:
// Rasmus Dahl-Sorensen (ford)
// Nov, 11 2004
// Thanks!
// ------------------------------------
// "AlloPass" feature contributed by:
// educ (AEC Team member)
// Jul 2006
// Thanks!
// ------------------------------------
//
// Dont allow direct linking
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//require_once( $mainframe->getPath( 'front_html' ) );
//require_once( $mainframe->getPath( 'class' ) );
//$task = trim( mosGetParam( $_REQUEST, 'task', '' ) );
//$expiration = trim( mosGetParam( $_REQUEST, 'expiration', '' ) );
//
//// CB Integration - Block 01 Start
//global $database;
//$tables	= array();
//$tables	= $database->getTableList();
//if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
//	/**
//	* Included files from Joomla Community Builder
//	* @version $Id: cbe.php 326 2006-05-09 01:50:12Z beat $
//	* @package Community Builder
//	* @subpackage cbe.php
//	* @author JoomlaJoe and Beat
//	* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
//	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//	*/
//
//	global $_CB_joomla_adminpath, $_CB_adminpath, $ueConfig;
//	$_CB_joomla_adminpath = $mainframe->getCfg( 'absolute_path' ). "/administrator";
//	$_CB_adminpath = $_CB_joomla_adminpath. "/components/com_cbe";
//	include_once($_CB_adminpath."/ue_config.php" );
//	include_once($_CB_adminpath."/plugin.class.php");
//	include_once($_CB_adminpath."/cbe.class.php");
//	include_once($_CB_adminpath."/imgToolbox.class.php");
//
//	$UElanguagePath=$mainframe->getCfg( 'absolute_path' ).'/components/com_cbe/plugin/language';
//	if (file_exists($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php')) {
//	  include_once($UElanguagePath.'/'.$mosConfig_lang.'/'.$mosConfig_lang.'.php');
//	} else include_once($UElanguagePath.'/default_language/default_language.php');
//
//
//	$form=mosGetParam( $_REQUEST, 'reportform', 1 );
//	$uid=mosGetParam( $_REQUEST, 'uid', 0 );
//	$act=mosGetParam( $_REQUEST, 'act', 1 );
//}
//// CB Integration - Block 01 End
//
//switch ( strtolower( $task ) ) {
//	case 'lostpassword':
//		lostPassForm( $option );
//		break;
//
//	case 'sendnewpass':
//		sendNewPass( $option );
//		break;
//
//	case 'register':
//		selectSubscriptionPlanB($option, 0, '', '');
//		break;
//
//	case 'saveregistration':
//		saveRegistration( $option );
//		break;
//
//	case 'savesubscription':
//		saveSubscription( $option );
//		break;
//
//	case 'backsubscription':
//		backSubscription( $option );
//		break;
//
//	case 'activate':
//		activate( $option );
//		break;
//
//	case 'ipn':
//		processIPN( $option );
//		break;
//
//	case 'vklixnotification':
//		processVKLIXNotification( $option );
//		break;
//
//	case 'authnotification':
//		processAuthorizeNotification( $option );
//		break;
//
//	case 'allopassnotification':
//		processAlloPassNotification( $option );
//		break;
//
//	case '2conotification':
//		process2coNotification( $option );
//		break;
//
//	case '2conotification':
//		process2coNotification( $option );
//		break;
//
//	case 'epsnotification':
//		process2coNotification( $option );
//		break;
//
//	case 'worldpaynotification':
//		processworldpayNotification( $option );
//		break;
//
//	case 'thanks':
//		$renew = trim( mosGetParam( $_REQUEST, 'renew', 0 ) );
//		$free = trim( mosGetParam( $_REQUEST, 'free', 0 ) );
//		thanks( $option, $renew, $free );
//		break;
//
//	case 'transfer':
//		thanksTransfer( $optionipn );
//		break;
//
//	case 'cancel':
//		cancelPayment( $option );
//		break;
//
//	case 'buildform':
//		$planid			= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid			= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username		= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name			= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring		= trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		$processor		= trim( mosGetParam( $_REQUEST, 'processor', '' ) );
//		buildForm( $option, $planid, $userid, $username, $name, $recurring, 3, $processor );
//		break;
//
///*	case 'freeform':
//		$planid		= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name		= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		freeForm( $option, $planid, $userid, $username, $name, 0 );
//		break;
//
//	case 'paypalform':
//		$planid		= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name		= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring	= trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		paypalForm( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'viaklixform':
//		$planid		= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name		= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring	= trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		vklixForm( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'authorizeform':
//		$planid		= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name		= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring	= trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		authorizeForm( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'allopassform':
//		$planid         = trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid         = trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username       = trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name           = trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring      = trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		allopassForm( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'twocheckoutform':
//		$planid         = trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid         = trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username       = trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name           = trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring      = trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		TWOcheckoutform( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'worldpayform':
//		$planid         = trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid         = trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username       = trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name           = trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring      = trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		worldpayform( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'epsnetpayform':
//		$planid         = trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid         = trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username       = trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name           = trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring      = trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		epsnetpayform( $option, $planid, $userid, $username, $name, $recurring );
//		break;
//
//	case 'transferform':
//		$planid		= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name		= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring      = trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		transferForm( $option, $planid, $userid, $username, $name, $recurring );
//		break;*/
//
//	case 'errap':
//		$planid         = trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid         = trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username       = trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name           = trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		$recurring      = trim( mosGetParam( $_REQUEST, 'recurring', 0 ) );
//		errorAP( $option, $planid, $userid, $username, $name, $recurring);
//		break;
//
//	case 'activateft':
//		activateFT( $option );
//		break;
//
//	case 'subscriptiondetails':
//		subscriptionDetails( $option );
//		break;
//
//	// Renew before expired
//	case 'renewsubscriptiona':
//		renewSubscription( $option );
//		break;
//
//	// Renew after expired
//	case 'renewsubscriptionb':
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		renewSubscription( $option, $userid );
//		break;
//
//	case 'expired':
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		expired($option, $userid, $expiration);
//		break;
//
//	case 'pending':
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		pending($option, $userid);
//		break;
//
//	case 'notallowed':
//		notAllowed($option);
//		break;
//
//// CB Integration - Block 02 Start
//	case 'savecbsubscription':
//		$oldignoreuserabort = ignore_user_abort(true);
//		saveCBSubscription( $option );
//		break;
//
//	case 'login':
//		$oldignoreuserabort = ignore_user_abort(true);
//		login( $option );
//		break;
//
//	case 'logout':
//		$oldignoreuserabort = ignore_user_abort(true);
//		logout( $option );
//		break;
//
//	case 'ckavail':
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		checkUsername( $username );
//		break;
//
//// CB Integration - Block 02 End
//
//	default:
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		expired($option, $userid, $expiration);
//		break;
//}

function expired ( $option, $userid, $expiration ) {
	if( $userid > 0 ) {
		HTML_frontEnd::expired($option, $userid, $expiration);
	} else {
		mosRedirect( "index.php" );
	}
}

function pending ( $option, $userid ) {
	global $database;
	if( $userid > 0 ) {
		$objUser = null;
		$query = "SELECT username, name FROM #__users WHERE id='$userid'";
		$database->setQuery( $query );
		$database->loadObject( $objUser );
		HTML_frontEnd::pending($option, $objUser);
	} else {
		mosRedirect( "index.php" );
	}
}

//function checkUsername ( $username ) {
//	global $database;
//	$database->setQuery( "SELECT count(*) FROM #__users"
//	. "\nWHERE username='$username'"
//	);
//	$usercount = $database->loadResult();
//	if($usercount == 0) {
//		$message = "[avail]<span style='color: #0f0'>" . sprintf (_CHK_USERNAME_AVAIL, $username) . "</span>[/avail]";
//	} else {
//		$message = "[avail]<span style='color: #f00'>" . sprintf (_CHK_USERNAME_NOTAVAIL, $username) . "</span>[/avail]";
//	}
//	echo $message;
//}

function notAllowed ( $option ) {
	global $database;
	$cfg = new Config_General( $database );
	$cfg->load(1);
	$gwlist	= str_replace(';', ',', $cfg->gwlist);
	$database->setQuery( "SELECT name FROM #__acctexp_processors"
	. "\n WHERE id IN ($gwlist)" );
	$gwnames = $database->loadObjectList();

	HTML_frontEnd::notAllowed($option, $gwnames);
}

//function lostPassForm ( $option ) {
//	global $mainframe;
//	$mainframe->SetPageTitle(_PROMPT_PASSWORD);
//	HTML_registration::lostPassForm($option);
//}
//
//function sendNewPass ( $option ) {
//	global $database, $Itemid;
//	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_mailfrom, $mosConfig_fromname;
//
//	$_live_site = $mosConfig_live_site;
//	$_sitename = $mosConfig_sitename;
//
//	// ensure no malicous sql gets past
//	$checkusername = trim( mosGetParam( $_POST, 'checkusername', '') );
//	$checkusername = $database->getEscaped( $checkusername );
//	$confirmEmail = trim( mosGetParam( $_POST, 'confirmEmail', '') );
//	$confirmEmail = $database->getEscaped( $confirmEmail );
//
//	$database->setQuery( "SELECT id FROM #__users"
//	. "\nWHERE username='$checkusername' AND email='$confirmEmail'"
//	);
//
//	if (!($user_id = $database->loadResult()) || !$checkusername || !$confirmEmail) {
//		mosRedirect( "index.php?option=$option&task=lostPassword&mosmsg="._ERROR_PASS );
//	}
//
//	$database->setQuery( "SELECT name, email FROM #__users"
//	. "\n WHERE usertype='superadministrator'" );
//	$rows = $database->loadObjectList();
//	foreach ($rows AS $row) {
//		$adminName = $row->name;
//		$adminEmail = $row->email;
//	}
//
//	$newpass = mosMakePassword();
//	$message = _NEWPASS_MSG;
//	eval ("\$message = \"$message\";");
//	$subject = _NEWPASS_SUB;
//	eval ("\$subject = \"$subject\";");
//
//	mosMail($mosConfig_mailfrom, $mosConfig_fromname, $confirmEmail, $subject, $message);
//
//	$newpass = md5( $newpass );
//	$sql = "UPDATE #__users SET password='$newpass' WHERE id='$user_id'";
//	$database->setQuery( $sql );
//	if (!$database->query()) {
//		die("SQL error" . $database->stderr(true));
//	}
//
//	mosRedirect( "index.php?Itemid=$Itemid&mosmsg="._NEWPASS_SENT );
//}
//
//function registerForm ( $option, $useractivation ) {
//	global $mainframe, $database, $my, $acl;
//
//	if (!$mainframe->getCfg( 'allowUserRegistration' )) {
//		mosNotAuth();
//		return;
//	}
//	$mainframe->SetPageTitle(_REGISTER_TITLE);
//	HTML_registration::registerForm($option, $useractivation);
//}

function backSubscription ( $option ) {
	global $mainframe, $database, $my, $acl;

	if (!$mainframe->getCfg( 'allowUserRegistration' )) {
		mosNotAuth();
		return;
	}

	// Rebuild array
	foreach ($_POST as $key => $value) {
		$var[$key]	= $value;
	}

	// Get other values to show in confirmForm
	$userid	= $var['userid'];
	$planid	= $var['planid'];

 	// get the payment plan
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

 	// get the user object
	$objuser = new mosUser( $database );
	$objuser->load( $userid );

	unset( $var['id'] );
	unset( $var['gid'] );
	unset( $var['task'] );
	unset( $var['option'] );
	unset( $var['name'] );
	unset( $var['username'] );
	unset( $var['email'] );
	unset( $var['password'] );
	unset( $var['password2'] );

	$mainframe->SetPageTitle(_REGISTER_TITLE);
	Payment_HTML::subscribeForm( $option, $var, $objplan, null, $objuser );
}

function renewSubscription ( $option, $id=null  ) {
	global $database, $my, $mainframe;

	// If $id is null user is renewing subscription before expiration
	// We should get his id from $my->id
	if(!(isset($id))) {
		$id = $my->id;
	}
	$user = null;
 	// get name and username from user
 	$database->setQuery("SELECT name, username"
 	. "\nFROM #__users"
 	. "\nWHERE id='$id'"
 	);

 	$database->loadObject( $user );
 	if ($database->getErrorNum()) {
 		echo $database->stderr();
 		return false;
 	}

	selectSubscriptionPlanB($option, $id, $user->username, $user->name );

}

function saveSubscription ( $option ) {
	global $database, $my, $acl;
	global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
	global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_dbprefix;
	global $ueConfig;

	$row = new mosUser( $database );

	$userid	= $_POST['id'];
	$gid	= $_POST['gid'];

	if (!$row->bind( $_POST, "usertype" )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	// Test if new
	if(!$userid) {
		$row->id = 0;
		$row->usertype = '';
		$row->gid = $acl->get_group_id('Registered','ARO');
		$row->block = "1"; // Force blocked.
	} else {
	//	$row->load($userid);
	}

	mosMakeHtmlSafe($row);

	$cfg = new Config_General( $database );
	$cfg->load(1);

	$tables	= array();
	$tables	= $database->getTableList();
	
	$pwd = $row->password;
	$row->password = md5( $row->password );

	$row->registerDate = date("Y-m-d H:i:s");

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$name = $row->name;
	$username = $row->username;
	$userid = $row->id;
	$registerDate = $row->registerDate; // For use on expiration date

	// Rebuild array
	foreach ($_POST as $key => $value) {
		$var[$key]	= $value;
	}

	// Update Subscription table
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	// Test if new
	if(!$id) {
		$db->load(0);
	} else {
		$db->load($id);
	}
	$db->userid			= $userid;
	$db->status			= 'Pending';
	$db->signup_date	= date( 'Y-m-d H:i:s' );
	$db->type			= $var['method'];
	$db->plan			= $var['planid'];
	$db->check();
	$db->store();

	// Now send request to payment processor
	// Update userid
	$var['userid']	= $userid;

	// Get other values to show in confirmForm
	$post_url		= $var['posturl'];
	$planid			= $var['planid'];
	$method			= $var['method'];
	$currency_code	= $var['currency_code'];
	$amount			= $var['amount'];
	unset($var['task']);
	switch ( strtolower($method) ) {
		case 'viaklix':
			$var['ssl_customer_code']	= $userid;
			$var['ssl_description']		= $name . '_-_' . $planid . '_-_' . $username;
			break;
		case 'authorize':
			$var['x_cust_id']			= $userid;
			$var['x_description']		= $name . '_-_' . $planid . '_-_' . $username;
			break;
		case 'paypal':
		case 'paypal_subscription':
			$var['item_number']			= $userid;
			$var['item_name']			= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			$var['custom']				= $planid;
			break;
		case 'allopass':
			$var['ssl_customer_code']	= $userid;
			$var['ssl_description']		= $name . '_-_' . $planid . '_-_' . $username;
			break;
		case '2checkout':
			$var['cust_id']				= $userid;
			$var['cart_order_id']		= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			$var['planid']				= $planid;
			$var['username']			= $username;
			$var['name']				= $name;
			break;
		case 'transfer':
			$var['username']			= $username;
			$var['name']				= $name;
			break;
		case 'none':
			// Just in case, we double check
			// if the plan id received really exists
			// as a default entry plan
			$entryPlanId	= 0;
		 	$database->setQuery("SELECT id FROM #__acctexp_plans"
		 	. "\nWHERE active=1 AND entry=1 limit 1"
		 	);
		 	$entryPlanId	= $database->loadResult();

			// OR if this is an existent free plan
			$freePlanId	= 0;
		 	$database->setQuery("SELECT id FROM #__acctexp_plans"
		 	. "\nWHERE active=1 AND amount3='0.00' AND id=$planid"
		 	);
		 	$freePlanId	= $database->loadResult();

		 	if( ($entryPlanId == $planid) || ($freePlanId == $planid) )	{
		 		$invoice = generateInvoiceNumber();
			 	// get the payment plans
				$objplan = new SubscriptionPlan( $database );
				$objplan->load( $planid );
				$tables	= array();
				$tables	= $database->getTableList();
				$messagesToUser	= null;
				
				userGatewayProcess( $userid, $objplan, 0, $invoice );
				if($messagesToUser) {
					// We gonna use CB message instead of default thanks page
					echo $messagesToUser;
				} else {
					mosRedirect( "index.php?option=$option&task=thanks&free=1" );
				}
		 	} else {
		 		// Remove the phucking cracker
			 	$database->setQuery( "DELETE FROM #__acctexp WHERE userid=$userid" );
				$database->query();
				$obj = new mosUser( $database );
				// check for a super admin ... can't delete them
				$groups		= $acl->get_object_groups( 'users', $userid, 'ARO' );
				$this_group	= strtolower( $acl->get_group_name( $groups[0], 'ARO' ) );
				if (( strcmp( $this_group, 'super administrator' ) !== 0) && ( strcmp( $this_group, 'administrator' ) !== 0 )) {
					if(!$obj->delete( $userid )) {
						$msg = $obj->getError();
					}
				}
			 	$database->setQuery( "DELETE FROM #__acctexp_subscr WHERE userid=$userid" );
				$database->query();
				mosRedirect( "index.php?option=$option&task=cancel" );
		 		return;
		 	}
	}
 	// get the payment plan
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	$tables	= array();
	$tables	= $database->getTableList();
	$messagesToUser	= null;
	
	// Send to the confirmation page
	$numberOfSteps		= $var['numberOfSteps'];
	Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
}

function activateFT ( $option ) {
	global $database, $mosConfig_offset_user;

	$planid			= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
	$userid			= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
	$method			= trim( mosGetParam( $_REQUEST, 'method', '' ) );
	$currency_code	= trim( mosGetParam( $_REQUEST, 'currency_code', '' ) );
	$messagesToUser	= trim( mosGetParam( $_REQUEST, 'messagesToUser', '' ) );

	if (GeneralInfoRequester::getProcessorIdByName($method) == 0) {
		$free = true;
	} else {
		$free = false;
	}

	if ($planid > 0) {
		$signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$invoice = generateInvoiceNumber();
	 	// get the paypal payment plans
		$objplan = new SubscriptionPlan( $database );
		$objplan->load( $planid );
		switch(strtolower($method)) {
			case 'paypal':
				userPayPalProcess( $userid, $signup_date, $objplan, $objplan->amount1, $currency_code, '0' );
				$renew	= 0;
				break;
			default:
				$renew	= userGatewayProcess( $userid, $objplan, $method, $invoice );
				break;
		}
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew&free=$free" );
	}
}

function activate ( $option ) {
	global $database;

	$activation = trim( mosGetParam( $_REQUEST, 'activation', '') );

	$database->setQuery( "SELECT id FROM #__users"
	."\n WHERE activation='$activation' AND block='1'" );
	$result = $database->loadResult();

	if ($result) {
		$database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE activation='$activation' AND block='1'" );
		if (!$database->query()) {
			echo "SQL error" . $database->stderr(true);
		}
		echo _REG_ACTIVATE_COMPLETE;
	} else {
		echo _REG_ACTIVATE_NOT_FOUND;
	}
}

function is_email ( $email ){
	$rBool=false;

	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
		$rBool=true;
	}
	return $rBool;
}

function selectSubscriptionPlanB ( $option, $userid, $username, $name ) {
	// No AJAX
	global $database, $mosConfig_live_site, $mainframe;
	global $mosConfig_allowUserRegistration, $my, $_POST;
	global $mosConfig_dbprefix, $mosConfig_emailpass;

	if (!$mainframe->getCfg( 'allowUserRegistration' )) {
		mosNotAuth();
		return;
	}

	// Get information if Manual Transfer payment option is available
	$cfg = new Config_General( $database );
	$cfg->load(1);

	// Building an intro page link
	$introduction_page = 0;
	$override_intro = 0;

	if ($introduction_page && !$override_intro) {
		$mainframe->redirect($cfg->intro_url);
	}

	$hasTransfer		= $cfg->transfer;
	$transferinfo		= $cfg->transferinfo;
	$hasFree			= 1;
	$subscriptionClosed	= 0;	// Initialize

	$where = array();

	if( $userid > 0 ) { // This is a renew subscription
	 	// get the subscription payment plans
		// Get user subscription plan
		$plan_info = null;
		$query = "SELECT a.plan, a.extra01, a.status, b.period1 FROM #__acctexp_subscr as a "
		. "\nINNER JOIN #__acctexp_plans as b ON a.plan=b.id"
		. "\nWHERE a.userid=$userid";
		$database->setQuery( $query );
		$database->loadObject($plan_info);

		$objCurrentUser	= new mosUser($database);
		$objCurrentUser->load($userid);
		if($objCurrentUser->gid) {
			$mygroupid	= $objCurrentUser->gid;
		}
		unset($where);

		// Check if expired so we can send this information
		// cigarrinho e cerveja!!!!!!
		// to the selectSubscriptionPlan function
		// to be used by getRegistrationSteps afterwards
		if( strcmp($plan_info->status, 'Closed') == 0 )  {
			$subscriptionClosed = 1;
		}

		if( $plan_info->period1 > 0 ) {
		 	// If user is using a trial period plan he cannot choose a different plan now
		 	// otherwise he could keep jumping from plan to plan using trial periods.
		 	// Only his original plan will be available for him
			unset($where);
			$where[] = "id=" . $plan_info->plan;
			$where[] = "active=1";
			$where[] = "entry<1";
			$where[] = "mingid<=$mygroupid";
		 	$database->setQuery("SELECT * FROM #__acctexp_plans"
			. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
		 	);
		 	$rows = $database->loadObjectList();
		 	if ($database->getErrorNum()) {
		 		echo $database->stderr();
		 		return false;
		 	}
		 	if(count( $rows ) == 0) { // UNLESS his original plan is now unpublished
		 		// All plans without trial periods will be available for him
				unset($where);
				$where[] = "active=1";
				$where[] = "entry<1";
				$where[] = "(period1<0 OR period1 is NULL)";
				$where[] = "mingid<=$mygroupid";
			 	$database->setQuery("SELECT * FROM #__acctexp_plans"
				. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
				. "\nORDER BY ordering"
			 	);
			 	$rows = $database->loadObjectList();
			 	if ($database->getErrorNum()) {
			 		echo $database->stderr();
			 		return false;
			 	}
			 	if(count( $rows ) == 0) { // If there is no published plan without trial AND original plan is unpublished
			 		// No way man, all plans will be available for him
					unset($where);
					$where[] = "active=1";
					$where[] = "entry<1";
					$where[] = "mingid<=$mygroupid";
				 	$database->setQuery("SELECT * FROM #__acctexp_plans"
					. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
					. "\nORDER BY ordering"
				 	);
				 	$rows = $database->loadObjectList();
				 	if ($database->getErrorNum()) {
				 		echo $database->stderr();
				 		return false;
				 	}

			 	}

		 	}
		} else {
			// Plan that the user is associated to does not have trial periods
			// so he can change his plan if he wants to
			// All plans will be available for him
			unset($where);
			$where[] = "active=1";
			$where[] = "entry<1";
			$where[] = "mingid<=$mygroupid";
		 	$database->setQuery("SELECT * FROM #__acctexp_plans"
			. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			. "\nORDER BY ordering"
		 	);
		 	$rows = $database->loadObjectList();
		 	if ($database->getErrorNum()) {
		 		echo $database->stderr();
		 		return false;
		 	}
		}
	} else { // This is a new subscription
		// Set the minimum gid to see the plan, all plans with lower gids
	 	$database->setQuery("SELECT min(mingid) FROM #__acctexp_plans WHERE mingid >=18" // Ignore 0 (no group) and 1 (ROOT)
	 	);
	 	$mingid	= $database->loadResult();

		// Check if we have a default entry plan
		$hasEntryPlan = 0;
		unset($where);
		$where[] = "active=1";
		$where[] = "entry=1";
	 	$database->setQuery("SELECT count(*) FROM #__acctexp_plans"
		. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	 	);
	 	$hasEntryPlan	= $database->loadResult();
	 	if ($database->getErrorNum()) {
	 		echo $database->stderr();
	 		return false;
	 	}
	 	if($hasEntryPlan > 0) {
	 		// We have a default entry plan for this new user
	 		$var['method']	= 'None';
	 		$objEntryPlan	= null;
			unset($where);
			$where[] = "active=1";
			$where[] = "entry=1";
		 	$database->setQuery("SELECT * FROM #__acctexp_plans"
			. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			. "\nLIMIT 1"
		 	);
		 	$database->loadObject( $objEntryPlan );
		 	if ($database->getErrorNum()) {
		 		echo $database->stderr();
		 		return false;
		 	}
	 		$var['planid']	= $objEntryPlan->id;
			$tables	= array();
			$tables	= $database->getTableList();
			
				Payment_HTML::subscribeForm( $option, $var, null, 2, $cfg->checkusername ); // we gonna have a 2 steps registration
			
	 		return;
	 	} else {
	 		// We don't have a default entry plan
			// All plans will be available for him
			unset($where);
			$where[] = "mingid=$mingid";
			$where[] = "active=1";
			$where[] = "entry<1";
		 	$database->setQuery("SELECT * FROM #__acctexp_plans"
			. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
			. "\nORDER BY ordering"
		 	);
		 	$rows = $database->loadObjectList();
		 	if ($database->getErrorNum()) {
		 		echo $database->stderr();
		 		return false;
		 	}
	 	}
	}

	// Discover Processors available for each plan
	// Put this information in a structure
	// $gw_available[<id of plan>][<index>]->proc_id		= associates plan with processor
	// $gw_available[<id of plan>][<index>]->name			= gives name of processor gateway
	// $gw_available[<id of plan>][<index>]->config_table	= gives which table has specific config option for the processor
	// $gw_available[<id of plan>][<index>]->currency_code	= gives currency code for use with the processor
	// $gw_available[<id of plan>][<index>]->recurring		= gives 0 if processor has not recurring feature and 1 if it has
	$proc_plan = new ProcessorByPlan( $database );
	for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		$row = &$rows[$i];
		// Test if this is a totally free plan
		if( ((strcmp($row->amount1, '0.00') == 0) || (strcmp($row->amount1, '0') == 0) || $row->amount1 == null) && ((strcmp($row->amount3, '0.00') == 0) || (strcmp($row->amount3, '0') == 0)) ) {
			// If yes, it will use the pseudo gateway for free plans
			$gw_available[$row->id] = array();
			$gw = &$gw_available[$row->id][0];
			$gw->name	= 'Free';
			$gw->recurring	= 0;
		} else {
			$gw_available[$row->id] = $proc_plan->GetProcessorsByPlan( $rows[$i]->id );
		 	// get the currency code
			for ($j=0, $o=count( $gw_available[$row->id] ); $j < $o; $j++) {
				$gw = &$gw_available[$row->id][$j];
				$configOptions = null;
			 	$database->setQuery("SELECT currency_code, recurring FROM " . $gw->config_table
		 		. "\nWHERE id='1'"
			 	);
			 	$database->loadObject($configOptions);
				$gw->currency_code = $configOptions->currency_code;
				// If user is renewing AND
				// he is using a plan WITHOUT recurring payments AND
				// his plan offers trial period THEN
				// he should not be able to select a recurring payment with trial periods.
				// OR simply because this is a lifetime subscription plan, there is no sense to have it with recurring system
				if	(
						(
							(	(strcmp($plan_info->status, 'Trial') == 0) ||	// OR
								(strcmp($plan_info->status, 'Active') == 0) ||	// OR
								(strcmp($plan_info->status, 'Closed') == 0)
							) &&							// AND
							($plan_info->extra01 == 0) &&	// AND
							($row->period1 > 0)
						)	||	// OR (higher level)
						(
							($row->lifetime == 1)
						)
					)
					{
					$gw->recurring = 0;
				} else {
					$gw->recurring = $configOptions->recurring;
				}
			}
		}
	}

	$row = &$rows[0];
	if((count( $rows ) == 1) && (count( $gw_available[$row->id] ) == 1) && ( $gw_available[$row->id][0]->recurring == 0 ) && ( $hasTransfer == 0 ) ) {
		// We only have one plan with one processor available
		// so we don't need a selection plan/processor page
		// See that we needed to check recurring too
		// as if you have it, though you have only one processor
		// you gonna have two options for it, recurring and not recurring
		/**
		switch ($gw_available[$row->id][0]->name) {
			// Parameter value 2 means we gonna have a 2 steps registration
			case 'ViaKLIX':
				vklixForm( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, 2 );
				break;
			case 'Authorize':
				authorizeForm( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, 2 );
				break;
			case 'PayPal':
				paypalForm( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, 2 );
				break;
			case 'AlloPass':
				allopassForm( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, 2 );
				break;
			case '2checkout':
				TWOcheckoutForm( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, 2 );
				break;
			case 'Free':
				freeForm( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, 2 );
				break;
		} */
		buildForm ( $option, $rows[0]->id, $userid, $username, $name, $gw_available[$row->id][0]->recurring, $numberOfSteps=3, $gw_available[$row->id][0]->name );

	} else {
		Payment_HTML::selectSubscriptionPlanFormB( $option, $rows, $hasTransfer, $gw_available, $userid, $username, $name, $subscriptionClosed );
	}

}

function subscriptionDetails ( $option ) {
	global $database, $my, $mainframe;

 	// get signup date from user
 	$database->setQuery("SELECT signup_date"
 	. "\nFROM #__acctexp_subscr"
 	. "\nWHERE userid='$my->id'"
 	);
 	$signup_date = $database->loadResult();
 	if ($database->getErrorNum()) {
 		echo $database->stderr();
 		return false;
 	}

 	// get expiration date from user
 	$database->setQuery("SELECT expiration"
 	. "\nFROM #__acctexp"
 	. "\nWHERE userid='$my->id'"
 	);
 	$expiration = $database->loadResult();
 	if ($database->getErrorNum()) {
 		echo $database->stderr();
 		return false;
 	}

	// Check if user is subscribed to a recurring payment plan
	// or a lifetime subscription
	// So he doesnt need to be bothered with Renew buttons
	$objSubscr	= null;
 	$database->setQuery("SELECT extra01, lifetime"
 	. "\nFROM #__acctexp_subscr"
 	. "\nWHERE userid='$my->id'"
 	);
	$database->loadObject($objSubscr);
 	$recurring	= $objSubscr->extra01;
 	$lifetime	= $objSubscr->lifetime;

 	// count number of payments from user
 	$database->setQuery("SELECT count(*) "
 	. "\nFROM #__acctexp_invoices"
 	. "\nWHERE userid='$my->id'"
 	);

 	$rows_total	= $database->loadResult();
	$rows_limit		= 15;	// Returns last 15 payments
	if($rows_total > $rows_limit) {
 		$min_limit	= $rows_total - $rows_limit;
	} else {
		$min_limit	= 0;
	}

 	// get payments from user
 	$database->setQuery("SELECT invoice_number, transaction_date, method as type, amount "
 	. "\nFROM #__acctexp_invoices"
 	. "\nWHERE userid='$my->id' ORDER BY transaction_date LIMIT $min_limit, $rows_limit"
 	);
 	$rows = $database->loadObjectList();
 	if ($database->getErrorNum()) {
 		echo $database->stderr();
 		return false;
 	}

	$alertlevel				= 99;
	$subscription			= new mosSubscription($database);
	$alert		 			= $subscription->GetAlertLevel($my->id);

	HTML_frontEnd::subscriptionDetails( $option, $rows, $signup_date, $expiration, $recurring, $lifetime, $alert );
}

// The all covering generic Form
function buildForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3, $processor ) {
	global $database, $mosConfig_live_site, $mosConfig_offset_user, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// ====== STEP 0 - Prepare Variables ======

	// We need to globalize this variable
	$processor_id = array();
	$processor_id['free']		= 0;
	$processor_id['paypal']		= 1;
	$processor_id['viaklix']	= 2;
	$processor_id['authorize']	= 3;
	$processor_id['allopass']	= 4;
	$processor_id['2checkout']	= 5;
	$processor_id['epsnetpay']	= 6;
	$processor_id['worldpay']	= 7;

	//$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');

	// Generate unique Invoice number
	$invoice = generateInvoiceNumber();

	// There is no mosConfig_emailpass anymore
	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';
	}

	// Load the appropriate config
	switch ( strtolower($processor) ) {
		case 'free':
			$cfg = new Config_General( $database );
			break;
		case 'transfer':
			$cfg = new Config_General( $database );
			break;
		case 'paypal':
			$cfg = new Config_PayPal( $database );
			break;
		case 'paypal_subscription':
			$cfg = new Config_PayPal( $database );
			break;
		case 'viaklix':
			$cfg = new Config_VKlix( $database );
			break;
		case 'authorize':
			$cfg = new Config_Authorize( $database );
			break;
		case 'allopass':
			$cfg = new Config_AlloPass( $database );
			break;
		case '2checkout':
			$cfg = new Config_2checkout( $database );
			break;
		case 'epsnetpay':
			$cfg = new Config_epsnetpay( $database );
			break;
		case 'worldpay':
			$cfg = new Config_worldpay( $database );
			break;
		default:
			break;
	}
	$cfg->load(1);

	// Assign Testmode url
	$var['testmode']	= $cfg->testmode;
	if ($cfg->testmode) {
		switch ( strtolower($processor) ) {
			case 'free':
				// Free pseudo gateway
				break;
			case 'transfer':
				$hasTransfer	= $cfg->transfer;
				$transferinfo	= $cfg->transferinfo;
				break;
			case 'paypal':
				$post_url	= "https://www.sandbox.paypal.com/cgi-bin/webscr";
				break;
			case 'paypal_subscription':
				$post_url	= "https://www.sandbox.paypal.com/cgi-bin/webscr";
				break;
			case 'viaklix':
				$post_url	= "https://www.viaKLIX.com/process.asp";
				$var['ssl_test_mode'] = "true";
				break;
			case 'authorize':
				//$var['x_test_request'] = "TRUE";
				$post_url	= "https://test.authorize.net/gateway/transact.dll";
				break;
			case 'allopass':
				$post_url       = $mosConfig_live_site . '/index.php?option=com_acctexp&task=allopassnotification';
				$var['ssl_test_mode'] = "true";
				break;
			case '2checkout':
				$post_url	= "https://www.2checkout.com/2co/buyer/purchase";
				$var['testmode']	= $cfg->testmode;
				$var['demo'] = "Y";
				break;
			case 'epsnetpay':
				$post_url	= "https://qvendor.netpay.at/webPay/vendorLogin";
				break;
			case 'worldpay':
				$var['testMode'] = "100";
				break;
			default:
				break;
		}
	} else {
		switch ( strtolower($processor) ) {
			case 'free':
				// Free pseudo gateway
				break;
			case 'transfer':
				$hasTransfer	= $cfg->transfer;
				$transferinfo	= $cfg->transferinfo;
				break;
			case 'paypal':
				$post_url	= "https://www.paypal.com/cgi-bin/webscr";
				break;
			case 'paypal_subscription':
				$post_url	= "https://www.paypal.com/cgi-bin/webscr";
				break;
			case 'viaklix':
				$post_url	= "https://www.viaKLIX.com/process.asp";
				$var['ssl_test_mode'] = "false";
				break;
			case 'authorize':
				//$var['x_test_request'] = "FALSE";
				$post_url	= "https://secure.authorize.net/gateway/transact.dll";
				break;
			case 'allopass':
				$post_url       = $mosConfig_live_site . '/index.php?option=com_acctexp&task=allopassnotification';
				$var['ssl_test_mode'] = "false";
				break;
			case '2checkout':
				$post_url	= "https://www.2checkout.com/2co/buyer/purchase";
				$var['testmode']	= $cfg->testmode;
				break;
			case 'epsnetpay':
				$post_url	= "https://vendor.netpay.at/webPay/vendorLogin";
				break;
			case 'worldpay':

				break;
			default:
				break;
		}
	}

	// Get Subscription record
	$newUser = 0;
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

	// ====== STEP 1 - Fetch Payment Plan ======

	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );
	if($recurring) {
		switch ( strtolower($processor) ) {
			case 'paypal_subscription':
				$var['cmd']	= '_xclick-subscriptions';
				$var['src']	= "1";
				$var['sra']	= "1";
				$var['a1']	= $objplan->amount1;
				$var['p1']	= $objplan->period1;
				$var['t1']	= $objplan->perunit1;
				$var['a3']	= $objplan->amount3;
				$var['p3']	= $objplan->period3;
				$var['t3']	= $objplan->perunit3;
				break;
			default:
				break;
		}
		$amount	= $objplan->amount1;
		if ( $objplan->period1 <= 0 ) {
			// Fresh subscr., recurring payments, NO trial period -> amount3 to Confirm Form
			$amount = $objplan->amount3;
		} else {
			// Fresh subscr., recurring payments, trial period -> amount1 to Confirm Form
			$amount = $objplan->amount1;
		}
		$return_url = $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
	} else {
		switch ( strtolower($processor) ) {
			case 'paypal':
				$var['cmd']	= '_xclick';
				$var['bn']	= 'PP-BuyNowBF';
				break;
			default:
				break;
		}
		if( ($objplan->id) && ((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0) || $objplan->amount1 == null) && ((strcmp($objplan->amount3, '0.00') == 0) || (strcmp($objplan->amount3, '0') == 0))) {
			$amount			= '0.00';
			$post_url		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			$var['method']	= $processor;
		} else {
			if((strcmp($db->status, 'Pending') == 0) || $newUser) {
				if ( $objplan->period1 <= 0 ) {
					// Fresh subscr., NO recurring payments, NO trial period -> amount3 to Confirm Form
					$amount = $objplan->amount3;
				} else { // Fresh subscr., NO recurring payments, trial period -> amount1 to Confirm Form
					$amount = $objplan->amount1;
					// Has Free Trial? Then -> activateF(ree)T(rial), nothing to be paid now
					if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
						// Accept the subscription & send to activate free trial
						$var['planid']			= $planid;
						$var['userid']			= $userid;
						$var['method']			= $processor;
						$post_url				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
					}
				}
				$return_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
			} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0)  || (strcmp($db->status, 'Trial') == 0)) {
				// Renew subscr., NO recurring payments, NO trial period -> amount3 to Confirm Form
				$amount = $objplan->amount3;
				$return_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&renew=1';
			}
		}
	}

	// ====== STEP 2 - Assemble Gateway Variables ======

	switch ( strtolower($processor) ) {
		case 'free':
			// Free pseudo gateway
			break;
		case 'transfer':
			// Manually make plan entry to acctexp_subscr cause that ain't happening with transfer
		 	$database->setQuery( "UPDATE #__acctexp_subscr SET plan='$planid' WHERE userid=$userid" );
			if (!$database->query()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			}
			$var['transferinfo']	= $transferinfo;
			break;
		case 'paypal':
			$var['business']		= $cfg->business;
			$var['invoice']			= $invoice;
			$var['cancel']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel';
			$var['notify_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=ipn';
			$var['no_shipping']	= "1";
			$var['no_note']	= "1";
			$var['rm']	= "2";
			$var['amount'] = $amount;
			$var['return'] = $return_url;
			$var['currency_code']	= $cfg->currency_code;
			break;
		case 'paypal_subscription':
			$var['business']		= $cfg->business;
			$var['invoice']			= $invoice;
			$var['cancel']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel';
			$var['notify_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=ipn';
			$var['no_shipping']	= "1";
			$var['no_note']	= "1";
			$var['rm']	= "2";
			// $var['amount'] = $amount;
			$var['return'] = $return_url;
			$var['currency_code']	= $cfg->currency_code;
			break;
		case 'vklix':
			$var['ssl_merchant_id']			= $cfg->accountid;
			$var['ssl_user_id']				= $cfg->userid;
			$var['ssl_pin']					= $cfg->pin;
			$var['ssl_invoice_number']		= $invoice;
			$var['ssl_salestax']			= "0";
			$var['ssl_result_format']		= "HTML";
			$var['ssl_receipt_link_method']	= "POST";
			$var['ssl_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=vklixnotification';
			$var['ssl_receipt_link_text']	= "Continue";
			$var['ssl_amount'] = $amount;
			$var['currency_code']			= $cfg->currency_code;
			break;
		case 'authorize':
			$var['x_login']					= $cfg->login;
			$var['x_invoice_num']			= $invoice;
			$var['x_receipt_link_method']	= "POST";
			//$var['x_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&itemnumber=' . $userid;
			$var['x_receipt_link_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=authnotification';
			$var['x_receipt_link_text']		= "Continue";
			$var['x_show_form']				= "PAYMENT_FORM";
			//$var['x_relay_response']		= "True";
			//$var['x_relay_url']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=authnotification';

			$var['x_amount'] = $amount;
			srand(time());
			$sequence = rand(1, 1000);
			$tstamp = time ();
			// Calculate fingerprint
			$fingerprint = hmac ($cfg->transaction_key, $cfg->login . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . "");
			// Insert the form elements required for SIM
			$var['x_fp_sequence']	= $sequence;
			$var['x_fp_timestamp']	= $tstamp;
			$var['x_fp_hash']		= $fingerprint;
			break;
		case 'allopass':
			$var['CODE0']					= mosGetParam( $_REQUEST, 'CODE0', '' );
			$var['SITE_ID']					= $cfg->siteid;
			$var['DOC_ID']					= $cfg->docid;
			$var['AUTH']					= $cfg->auth;
			$var['RECALL']					= "1" ;

			$var['currency_code']			= $cfg->currency_code;
			$var['ssl_merchant_id']			= $var['SITE_ID'];
			$var['ssl_user_id']				= $var['DOC_ID'];
			$var['ssl_pin']					= $var['AUTH'];
			$var['ssl_invoice_number']		= $invoice;
			$var['ssl_salestax']			= "0";
			$var['ssl_result_format']		= "HTML";
			$var['ssl_receipt_link_method']	= "POST";
			$var['ssl_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=allopassnotification';
			$var['ssl_receipt_link_text']	= "Continue";
			$var['ssl_amount'] = $amount;
			break;
		case '2checkout':
			$var['sid']				= $cfg->sid;
			$var['invoice_number']	= $invoice;
			$var['total'] = $amount;
			break;
		case 'epsnetpay':
			$sapPopStsURL = $mosConfig_live_site . '/index.php?option=com_acctexp&task=epsnotification';
			$var['sapInfoVersion']			= "3"; //Current Version
			$var['language']				= "DE"; // Must be german
			$var['sapPopRequestor']			= $cfg->epsmarchantid; // Marchant ID
			$var['sapPopServer']			= "yes"; // Server-to-Server notification
			$var['sapPopStsUrl']			= $sapPopStsURL;
			$var['sapPopStsParCnt']			= "0"; // Number of custom values
			$var['sapPopOkUrl']				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
			$var['sapPopNOkUrl']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel';
			$sapUgawwhg = $cfg->currency_code; // HAS TO BE EUR !!
			$var['sapUgawwhg']		= $sapUgawwhg;
			$sapUkddaten			= $userid;
			$var['sapUkddaten']		= $sapUkddaten;
			$sapUvwzweck = $row->name . '_-_' . $planid . '_-_' . $row->username;;
			$var['sapUvwzweck']		= $sapUkddaten;
			$sapUzusatz				= '';
			$params					= '';
			$value					= preg_split("/[\.,]/", $amount);

			$sapUgawVK = $value[0]; // $objplan->amount3 (only the stuff before the comma)
			$sapUgawNK = $value[1]; // $objplan->amount3 (only the stuff AFTER the comma)
			$var['sapUgawVK']	= $sapUgawVK;
			$var['sapUgawNK']	= $sapUgawNK;
			$var['sapPopFingerPrint']		= md5( $cfg->epsmerchantpin . $cfg->epsmerchantid . $sapUgawVK . $sapUgawNK . $sapUgawwhg . $sapUvwzweck . $sapUkddaten . $sapUzusatz . $sapPopStsURL . $params); // Fingerprint
			break;
		case 'worldpay':
			$var['instId']		= $cfg->instId;
			$var['amount'] = $amount;
			$var['currency']	= $cfg->currency_code;
			break;
		default:
			break;
	}

	// Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'PayPal', $amount, $cfg->currency_code );
	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= $processor;
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	// ====== STEP 3 - Forward Assembled Data ======

	// Forward user to Confirm- or ConfirmCB Form and test for Renew
	if($userid) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		switch ( strtolower($processor) ) {
		case 'transfer':
			$var['username']		= $row->username;
			$var['name']			= $row->name;
			break;
		case 'paypal':
			$var['item_number']		= $row->id;
			$var['item_name']		= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			$var['custom']			= $planid;
			break;
		case 'paypal_subscription':
			$var['item_number']		= $row->id;
			$var['item_name']		= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			$var['custom']			= $planid;
			break;
		case 'viaklix':
			$var['item_number']		= $row->id;
			$var['item_name']		= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			$var['custom']			= $planid;
			break;
		case 'authorize':
			$var['x_cust_id']			= $row->id;
			$var['x_description']		= $row->name . '_-_' . $planid . '_-_' . $row->username;
			break;
		case 'allopass':
			$var['ssl_customer_code']	= $row->id;
			$var['ssl_description']		= $row->name . '_-_' . $planid . '_-_' . $row->username;
			break;
		case '2checkout':
			$var['cust_id']			= $row->id;
			$var['cart_order_id']	= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			$var['username']		= $row->username;
			$var['name']			= $row->name;
			break;
		case 'epsnetpay':
			// We will have to check whether it is sufficient to use the given customer id variables
			// So far it looks as if it was just another variable being passed on, so I don't think
			// that we need to have any extras here.
			break;
		case 'worldpay':
			$var['desc']	= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
			break;
		default:
			break;
	}
		$numberOfSteps = 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		
			Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
		
	}


}


/*
// Prepare variables to the confirm payment form
function freeForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $mosConfig_offset_user, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('none', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = 'none';

	$PROCESSOR_FREE				= 0;
	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;
	$PROCESSOR_ALLOPASS			= 4;
	$PROCESSOR_2CHECKOUT		= 5;
	$PROCESSOR_EPSNETPAY		= 6;
	$PROCESSOR_WORLDPAY			= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	// Do we need a record for free subscriptions?

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the payment plan
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );
	// Test if the free plan really exists
	if( ($objplan->id) && ((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0) || $objplan->amount1 == null) && ((strcmp($objplan->amount3, '0.00') == 0) || (strcmp($objplan->amount3, '0') == 0))) {
		$var['amount']	= '0.00';	// This is the Free plan
		$amount			= '0.00';
		$post_url		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';

		if((strcmp($db->status, 'Pending') == 0) || $newUser) {
			// This is a fresh subscription of
			// pseudo gateway for free membership plan
			$var['planid']	= $planid;
			$var['userid']	= $userid;
			// $var['method']	= $Processor_ID[$processor];
			$var['return']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
		} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0)  || (strcmp($db->status, 'Trial') == 0)) {
			// This is a renew subscription
			$var['return']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&renew=1';
		}

		//Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'PayPal', $amount, $cfg->currency_code );
		// Used on save Subscription
		$var['posturl']			= $post_url;
		$var['amount']			= $amount;
		$var['method']			= 'None';
		$var['planid']			= $planid;
		$var['userid']			= $userid;
		// Used on save Subscription

		if($userid) {
			// this is a renew
			$row = new mosUser( $database );
			$row->load($userid);
			$numberOfSteps			= 2;
			Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
		} else {
			$configGeneral = new Config_General( $database );
			$configGeneral->load(1);
			$tables	= array();
			$tables	= $database->getTableList();
			if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
				$regErrorMSG	= null;
				$rowFields		= null;
				$rowFieldValues	= null;
				getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
				Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues,$var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
			} else {
				Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
			}
		}
	} else {
		// This free plan does not exist
		HTML_Results::generalError();
	}
}

// Prepare PayPal variables to the confirm payment form
function paypalForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $mosConfig_offset_user, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = 'paypal';

	$PROCESSOR_PAYPAL		= 1;
	$PROCESSOR_VKLIX		= 2;
	$PROCESSOR_AUTHORIZE	= 3;
    $PROCESSOR_ALLOPASS		= 4;
    $PROCESSOR_2CHECKOUT	= 5;
	$PROCESSOR_EPSNETPAY	= 6;
	$PROCESSOR_WORLDPAY		= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	$cfg = new Config_PayPal( $database );
	$cfg->load(1);

	$var['testmode']	= $cfg->testmode;
	if ($cfg->testmode) {
		$post_url	= "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}
	else {
		$post_url	= "https://www.paypal.com/cgi-bin/webscr";
	}

	$invoice = generateInvoiceNumber();
	$var['currency_code']	= $cfg->currency_code;
	$var['business']		= $cfg->business;
	$var['invoice']			= $invoice;
	$var['cancel']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel';
	$var['notify_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=ipn';

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the paypal payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );
	if($recurring) {
		$var['cmd']	= '_xclick-subscriptions';
		$var['src']	= "1";
		$var['sra']	= "1";
		$var['a1']	= $objplan->amount1;
		$var['p1']	= $objplan->period1;
		$var['t1']	= $objplan->perunit1;
		$var['a3']	= $objplan->amount3;
		$var['p3']	= $objplan->period3;
		$var['t3']	= $objplan->perunit3;
		$amount		= $objplan->amount1;
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription with recurring payments
			// and we DO NOT have trial period, so we need to show amount3
			// on Confirm Form
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription with recurring payments
			// and we have trial period, so we need to show amount1
			// on Confirm Form
			$amount = $objplan->amount1;
		}
		$var['return']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
	} else {
		$var['cmd']	= '_xclick';
		$var['bn']	= 'PP-BuyNowBF';

		if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
			if ( $objplan->period1 <= 0 ) {
				// This is a fresh subscription without recurring payments
				// and we DO NOT have trial period, so we need to use amount3
				$var['amount']	= $objplan->amount3;
				$amount = $objplan->amount3;
			} else {
				// This is a fresh subscription without recurring payments
				// and we have trial period, so we need to use amount1
				$var['amount']	= $objplan->amount1;
				$amount = $objplan->amount1;
				// Check to see if the plan has a FREE trial
				// In this case we should not send to PayPal
				// as there is nothing to be paid now
				if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
					// Accept the subscription
					// Send to activate free trial
					$var['planid']			= $planid;
					$var['userid']			= $userid;
					$var['method']			= $Processor_ID[$processor];
					$var['currency_code']	= $cfg->currency_code;
					$post_url				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
				}
			}
			$var['return']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
		} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0)  || (strcmp($db->status, 'Trial') == 0)) {
			// This is a renew subscription without recurring payments
			// so we need to use amount3
			$var['amount']	= $objplan->amount3;
			$amount = $objplan->amount3;
			$var['return']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&renew=1';
		}
	}
	$var['no_shipping']	= "1";
	$var['no_note']	= "1";
	$var['rm']	= "2";


	//Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'PayPal', $amount, $cfg->currency_code );
	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= 'PayPal';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	if($userid) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$var['item_number']		= $row->id;
		$var['item_name']		= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
		$var['custom']			= $planid;
		$numberOfSteps			= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues,$var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
		}
	}

}

// Prepare ViaKLIX variables to the confirm payment form
function vklixForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = 'vklix';

	$PROCESSOR_PAYPAL		= 1;
	$PROCESSOR_VKLIX		= 2;
	$PROCESSOR_AUTHORIZE	= 3;
    $PROCESSOR_ALLOPASS		= 4;
    $PROCESSOR_2CHECKOUT	= 5;
	$PROCESSOR_EPSNETPAY	= 6;
	$PROCESSOR_WORLDPAY		= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	$cfg = new Config_VKlix( $database );
	$cfg->load(1);

	$var['testmode']	= $cfg->testmode;
	if ($cfg->testmode) {
		$var['ssl_test_mode'] = "true";
	}
	else {
		$var['ssl_test_mode'] = "false";
	}

	$post_url	= "https://www.viaKLIX.com/process.asp";

	$invoice = generateInvoiceNumber();

	$var['currency_code']			= $cfg->currency_code;
	$var['ssl_merchant_id']			= $cfg->accountid;
	$var['ssl_user_id']				= $cfg->userid;
	$var['ssl_pin']					= $cfg->pin;
	$var['ssl_invoice_number']		= $invoice;
	$var['ssl_salestax']			= "0";
	$var['ssl_result_format']		= "HTML";
	$var['ssl_receipt_link_method']	= "POST";
	$var['ssl_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=vklixnotification';
	$var['ssl_receipt_link_text']	= "Continue";

	// Get Subscription record
	$newUser = 0;
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the viaklix payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$var['ssl_amount']	= $objplan->amount3;
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$var['ssl_amount']	= $objplan->amount1;
			$amount = $objplan->amount1;
			// Check to see if the plan has a FREE trial
			// In this case we should not send to Gateway
			// as there is nothing to be paid now
			if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
				// Accept the subscription
				// Send to activate free trial
				$post_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			}
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$var['ssl_amount']	= $objplan->amount3;
		$amount = $objplan->amount3;
	}

	// Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'ViaKLIX', $amount, $cfg->currency_code );
	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= 'ViaKLIX';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	if($userid) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$var['ssl_customer_code']	= $row->id;
		$var['ssl_description']		= $row->name . '_-_' . $planid . '_-_' . $row->username;
		$numberOfSteps			= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues,$var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
		}
	}

}

function authorizeForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = 'authorize';

	$PROCESSOR_PAYPAL		= 1;
	$PROCESSOR_VKLIX		= 2;
	$PROCESSOR_AUTHORIZE	= 3;
    $PROCESSOR_ALLOPASS		= 4;
    $PROCESSOR_2CHECKOUT	= 5;
	$PROCESSOR_EPSNETPAY	= 6;
	$PROCESSOR_WORLDPAY		= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	$cfg = new Config_Authorize( $database );
	$cfg->load(1);

	$var['testmode']	= $cfg->testmode;
	if ($cfg->testmode) {
		//$var['x_test_request'] = "TRUE";
		$post_url	= "https://test.authorize.net/gateway/transact.dll";
	}
	else {
		//$var['x_test_request'] = "FALSE";
		$post_url	= "https://secure.authorize.net/gateway/transact.dll";
	}

	$invoice = generateInvoiceNumber();

	//$var['currency_code']		= $cfg->currency_code;

	$var['x_login']					= $cfg->login;
	$var['x_invoice_num']			= $invoice;
	$var['x_receipt_link_method']	= "POST";
	//$var['x_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&itemnumber=' . $userid;
	$var['x_receipt_link_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=authnotification';
	$var['x_receipt_link_text']		= "Continue";
	$var['x_show_form']				= "PAYMENT_FORM";
	//$var['x_relay_response']		= "True";
	//$var['x_relay_url']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=authnotification';

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the authorize payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$var['x_amount']	= $objplan->amount3;
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$var['x_amount']	= $objplan->amount1;
			$amount = $objplan->amount1;
			// Check to see if the plan has a FREE trial
			// In this case we should not send to Gateway
			// as there is nothing to be paid now
			if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
				// Accept the subscription
				// Send to activate free trial
				$var['currency_code']	= $cfg->currency_code;
				$post_url				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			}
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$var['x_amount']	= $objplan->amount3;
		$amount = $objplan->amount3;
	}

	// Seed random number for security and better randomness.

	srand(time());
	$sequence = rand(1, 1000);
	$tstamp = time ();
	// Calculate fingerprint
	$fingerprint = hmac ($cfg->transaction_key, $cfg->login . "^" . $sequence . "^" . $tstamp . "^" . $amount . "^" . "");
	// Insert the form elements required for SIM
	$var['x_fp_sequence']	= $sequence;
	$var['x_fp_timestamp']	= $tstamp;
	$var['x_fp_hash']		= $fingerprint;

	//Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'Authorize', $amount, $cfg->currency_code );
	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= 'Authorize';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	if($userid > 0) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$var['x_cust_id']			= $row->id;
		$var['x_description']		= $row->name . '_-_' . $planid . '_-_' . $row->username;
		$numberOfSteps			= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues, $var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, '', $numberOfSteps, $configGeneral->checkusername );
		}
	}

}

// Prepare AlloPass variables to the confirm payment form
function allopassForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = 'allopass';

	$PROCESSOR_PAYPAL		= 1;
	$PROCESSOR_VKLIX		= 2;
	$PROCESSOR_AUTHORIZE	= 3;
    $PROCESSOR_ALLOPASS		= 4;
    $PROCESSOR_2CHECKOUT	= 5;
	$PROCESSOR_EPSNETPAY	= 6;
	$PROCESSOR_WORLDPAY		= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	$cfg = new Config_AlloPass( $database );
	$cfg->load(1);

	$var['testmode']        = $cfg->testmode;
	if ($cfg->testmode) {
	        $var['ssl_test_mode'] = "true";
	}
	else {
	        $var['ssl_test_mode'] = "false";
	}

	$invoice = generateInvoiceNumber();
	$post_url       = $mosConfig_live_site . '/index.php?option=com_acctexp&task=allopassnotification';
	$var['CODE0']					= mosGetParam( $_REQUEST, 'CODE0', '' );
	$var['SITE_ID']					= $cfg->siteid;
	$var['DOC_ID']					= $cfg->docid;
	$var['AUTH']					= $cfg->auth;
	$var['RECALL']					= "1" ;
	$var['currency_code']			= $cfg->currency_code;
	$var['ssl_merchant_id']			= $var['SITE_ID'];
	$var['ssl_user_id']				= $var['DOC_ID'];
	$var['ssl_pin']					= $var['AUTH'];
	$var['ssl_invoice_number']		= $invoice;
	$var['ssl_salestax']			= "0";
	$var['ssl_result_format']		= "HTML";
	$var['ssl_receipt_link_method']	= "POST";
	$var['ssl_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=allopassnotification';
	$var['ssl_receipt_link_text']	= "Continue";

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the viaklix payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$var['ssl_amount']	= $objplan->amount3;
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$var['ssl_amount']	= $objplan->amount1;
			$amount = $objplan->amount1;
			// Check to see if the plan has a FREE trial
			// In this case we should not send to Gateway
			// as there is nothing to be paid now
			if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
				// Accept the subscription
				// Send to activate free trial
				$var['currency_code']	= $cfg->currency_code;
				$post_url				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			}
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$var['ssl_amount']	= $objplan->amount3;
		$amount = $objplan->amount3;
	}

	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= 'AlloPass';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	if($userid) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$var['ssl_customer_code']	= $row->id;
		$var['ssl_description']		= $row->name . '_-_' . $planid . '_-_' . $row->username;
		$numberOfSteps				= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues,$var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
		}
	}
}

function TWOcheckoutForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = '2checkout';

	$PROCESSOR_PAYPAL		= 1;
	$PROCESSOR_VKLIX		= 2;
	$PROCESSOR_AUTHORIZE	= 3;
    $PROCESSOR_ALLOPASS		= 4;
    $PROCESSOR_2CHECKOUT	= 5;
	$PROCESSOR_EPSNETPAY	= 6;
	$PROCESSOR_WORLDPAY		= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	$cfg = new Config_2checkout( $database );
	$cfg->load(1);

	$var['testmode']	= $cfg->testmode;	// Yes we need testmode beside demo
	if ($cfg->testmode) {
		$var['demo'] = "Y";
	}

	$post_url	= "https://www.2checkout.com/2co/buyer/purchase";

	$invoice = generateInvoiceNumber();

	//$var['currency_code']		= $cfg->currency_code;

	$var['sid']				= $cfg->sid;
	$var['invoice_number']	= $invoice;

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the viaklix payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$var['total']	= $objplan->amount3;
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$var['total']	= $objplan->amount1;
			$amount = $objplan->amount1;
			// Check to see if the plan has a FREE trial
			// In this case we should not send to Gateway
			// as there is nothing to be paid now
			if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
				// Accept the subscription
				// Send to activate free trial
				$post_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			}
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$var['total']	= $objplan->amount3;
		$amount = $objplan->amount3;
	}

	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= '2checkout';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	if($userid > 0) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$var['cust_id']			= $row->id;
		$var['cart_order_id']	= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
		$var['username']		= $row->username;
		$var['name']			= $row->name;
		$numberOfSteps			= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues, $var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
		}
	}

}

function epsnetpayForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $my, $mosConfig_emailpass;
	global $mosConfig_dbprefix;

	// We need to globalize this variable
	$Processor_ID = array('free', 'paypal', 'vklix', 'authorize', 'allopass', '2checkout', 'epsnetpay', 'worldpay');
	$processor = 'epsnetpay';

	$PROCESSOR_PAYPAL		= 1;
	$PROCESSOR_VKLIX		= 2;
	$PROCESSOR_AUTHORIZE	= 3;
    $PROCESSOR_ALLOPASS		= 4;
    $PROCESSOR_2CHECKOUT	= 5;
	$PROCESSOR_EPSNETPAY	= 6;
	$PROCESSOR_WORLDPAY		= 7;

	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// There is no mosConfig_emailpass anymore
	}

	$cfg = new Config_epsnetpay( $database );
	$cfg->load(1);

	$var['testmode']	= $cfg->testmode;
	if ($cfg->testmode) {
		$post_url	= "https://qvendor.netpay.at/webPay/vendorLogin";
	}
	else {
		$post_url	= "https://vendor.netpay.at/webPay/vendorLogin";
	}

	$invoice = generateInvoiceNumber();
	$sapPopStsURL = $mosConfig_live_site . '/index.php?option=com_acctexp&task=epsnotification';

	//$var['currency_code']		= $cfg->currency_code;

	$var['sapInfoVersion']			= "3"; //Current Version
	$var['language']				= "DE"; // Must be german
	$var['sapPopRequestor']			= $cfg->epsmarchantid; // Marchant ID
	$var['sapPopServer']			= "yes"; // Server-to-Server notification
	$var['sapPopStsUrl']			= $sapPopStsURL;
	$var['sapPopStsParCnt']			= "3"; // Number of custom values
	$var['sapPopOkUrl']				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';
	$var['sapPopOkUrl']				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel';

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the authorize payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$value	= preg_split("/[\.,]/", $objplan->amount3);
			$sapUgawVK = $value[0]; // $objplan->amount3 (only the stuff before the comma)
			$sapUgawNK = $value[1]; // $objplan->amount3 (only the stuff AFTER the comma)
			$var['sapUgawVK']	= $sapUgawVK;
			$var['sapUgawNK']	= $sapUgawNK;
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$value	= preg_split("/[\.,]/", $objplan->amount1);
			$sapUgawVK = $value[0]; // $objplan->amount1 (only the stuff before the comma)
			$sapUgawNK = $value[1]; // $objplan->amount1 (only the stuff AFTER the comma)
			$var['sapUgawVK']	= $sapUgawVK;
			$var['sapUgawNK']	= $sapUgawNK;
			$amount = $objplan->amount1;
			// Check to see if the plan has a FREE trial
			// In this case we should not send to Gateway
			// as there is nothing to be paid now
			if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
				// Accept the subscription
				// Send to activate free trial
				$var['currency_code']	= $cfg->currency_code;
				$post_url				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			}
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$value	= preg_split("/[\.,]/", $objplan->amount3);
		$sapUgawVK = $value[0]; // $objplan->amount3 (only the stuff before the comma)
		$sapUgawNK = $value[1]; // $objplan->amount3 (only the stuff AFTER the comma)
		$var['sapUgawVK']	= $sapUgawVK;
		$var['sapUgawNK']	= $sapUgawNK;
		$amount = $objplan->amount3;
	}

	$sapUgawwhg = $cfg->currency_code; // HAS TO BE EUR !!
	$var['sapUgawwhg']		= $sapUgawwhg;
	$sapUkddaten = $userid;
	$var['sapUkddaten']		= $sapUkddaten;
	$sapUvwzweck = $row->name . '_-_' . $planid . '_-_' . $row->username;;
	$var['sapUvwzweck']		= $sapUkddaten;
	$sapUzusatz = '';
	$params = '';

	$var['sapPopFingerPrint']		= md5( $cfg->epsmerchantpin . $cfg->epsmerchantid . $sapUgawVK . $sapUgawNK . $sapUgawwhg . $sapUvwzweck . $sapUkddaten . $sapUzusatz . $sapPopStsURL . $params); // Fingerprint

	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= 'epsnetpay';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	// Used on save Subscription

	if($userid > 0) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$numberOfSteps				= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues, $var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, '', $numberOfSteps, $configGeneral->checkusername );
		}
	}

}

function transferForm ( $option, $planid, $userid, $username, $name, $recurring, $numberOfSteps=3 ) {
	global $database, $mosConfig_live_site, $mosConfig_dbprefix, $mosConfig_emailpass;

	// Get information if Manual Transfer payment option is available
	$cfg = new Config_General( $database );
	$cfg->load(1);

	$hasTransfer	= $cfg->transfer;
	$transferinfo	= $cfg->transferinfo;

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		$newUser = 1;
	}

 	// get the payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if((strcmp($db->status, 'Pending') == 0) || $newUser || ( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) ) {
		$post_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&renew=0';
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$amount = $objplan->amount1;
			// Check to see if the plan has a FREE trial
			// In this case we should not send to Gateway
			// as there is nothing to be paid now
			if((strcmp($objplan->amount1, '0.00') == 0) || (strcmp($objplan->amount1, '0') == 0)){
				// Accept the subscription
				// Send to activate free trial
				$post_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
			}
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$post_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&renew=1';
		$amount = $objplan->amount3;
	}

 	$database->setQuery( "UPDATE #__acctexp_subscr SET plan='$planid' WHERE userid=$userid" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	// Used on save Subscription
	$var['posturl']			= $post_url;
	$var['amount']			= $amount;
	$var['method']			= 'transfer';
	$var['planid']			= $planid;
	$var['userid']			= $userid;
	$var['currency_code']	= $cfg->currency_code;
	$var['transferinfo']	= $transferinfo;
	// Used on save Subscription

	if($userid > 0) {
		// this is a renew
		$row = new mosUser( $database );
		$row->load($userid);
		$var['username']		= $row->username;
		$var['name']			= $row->name;
		$numberOfSteps			= 2;
		Payment_HTML::confirmForm( $option, $var, $objplan, $row, $numberOfSteps );
	} else {
		$configGeneral = new Config_General( $database );
		$configGeneral->load(1);
		$tables	= array();
		$tables	= $database->getTableList();
		if(in_array($mosConfig_dbprefix."cbe", $tables)) { // CB Integration
			$regErrorMSG	= null;
			$rowFields		= null;
			$rowFieldValues	= null;
			getFieldsForCBForm( &$rowFields, &$rowFieldValues, $regErrorMSG );
			Payment_HTML::subscribeCBForm( $option, $mosConfig_emailpass, $rowFields, $rowFieldValues, $var, $regErrorMSG, $numberOfSteps, $cfg->checkusername );
		} else {
			Payment_HTML::subscribeForm( $option, $var, null, $numberOfSteps, $configGeneral->checkusername );
		}
	}
}

*/

function processIPN ( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;
	// read the post from PayPal system and add 'cmd'
	$cfg = new Config_PayPal( $database );
	$cfg->load(1);

	$mybuzz				= $cfg->business;
	$testmode			= $cfg->testmode;
	$req				= 'cmd=_notify-validate';
	$checkBusinessID	= $cfg->checkbusiness; // See if we gonna make a security check against business ID and receiver email

	$response	= '';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
		$response .= "$key=$value\n";
	}

	// post back to PayPal system to validate
	$header  = "";
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	if($testmode) {
		$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
	} else {
		$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
	}

	// assign posted variables to local variables

	$txn_id				= $_POST['txn_id'];
	$parent_txn_id		= $_POST['parent_txn_id'];
	$txn_type			= $_POST['txn_type'];
	$mc_currency		= $_POST['mc_currency'];
	$item_name			= $_POST['item_name'];
	$item_number		= $_POST['item_number'];
	$mc_gross			= $_POST['mc_gross'];
	$business			= $_POST['business'];
	$receiver_email		= $_POST['receiver_email'];
	$receiver_id		= $_POST['receiver_id'];
	$payer_email		= $_POST['payer_email'];
	$amount1			= $_POST['amount1'];
	$period1			= $_POST['period1'];
	$amount2			= $_POST['amount2'];
	$period2			= $_POST['period2'];
	$amount3			= $_POST['amount3'];
	$period3			= $_POST['period3'];
	$payment_status		= $_POST['payment_status'];
	$pending_reason		= $_POST['pending_reason'];
	$reason_code		= $_POST['reason_code'];
	$payment_date		= $_POST['payment_date'];
	$payment_type		= $_POST['payment_type'];
	$first_name			= $_POST['first_name'];
	$last_name			= $_POST['last_name'];
	$verify_sign		= $_POST['verify_sign'];
	$subscr_date		= $_POST['subscr_date'];
	$subscr_effective	= $_POST['subscr_effective'];
	$invoice_number		= $_POST['invoice'];
	$custom				= trim($_POST['custom']);
	if (!$fp) {
		// HTTP ERROR
	} else {
		$plan = new SubscriptionPlan( $database );
		$plan->load($custom);

		$actual_user	= new mosUser($database);
		$actual_user->load($item_number);
		// Create history entry
		$db = new logHistory( $database );
		$db->load(0);
		$db->proc_id			= GeneralInfoRequester::getProcessorIdByName( 'PayPal' );
		$db->proc_name			= 'PayPal';
		$db->user_id			= $item_number;
		$db->user_name			= $actual_user->username;
		$db->plan_id			= $custom;
		$db->plan_name			= $plan->name;
	    $db->transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	    $db->amount				= $mc_gross;
	    $db->invoice_number		= $invoice_number;
	    $db->response			= $response;
/**
		if (!$db->check()) {
			echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
*/
		if (!$db->store()) {
			echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if(strcmp($res, "VERIFIED") == 0) {
				// check the payment_status is Completed
				// check that payment_amount/payment_currency are correct
				// process payment
				// Process IPN after the connection to the Paypal secured server
				// Depending of the status (INVALID or VERIFIED or false)
				// check that receiver_email is your Primary PayPal email
				// Process IPN as soon as it is received from Paypal server
/**				$db = new mosPayPalHistory( $database );
				$db->txn_id				= $txn_id;
				$db->parent_txn_id		= $parent_txn_id;
				$db->txn_type			= $txn_type;
				$db->mc_currency		= $mc_currency;
				$db->mc_gross			= $mc_gross;
				$db->amount1			= $amount1;
				$db->period1			= $period1;
				$db->amount2			= $amount2;
				$db->period2			= $period2;
				$db->amount3			= $amount3;
				$db->period3			= $period3;
				$db->business			= $business;
				$db->payer_email		= $payer_email;
				$db->receiver_email		= $receiver_email;
				$db->receiver_id		= $receiver_id;
				$db->payment_status		= $payment_status;
				$db->pending_reason		= $pending_reason;
				$db->reason_code		= $reason_code;
				$db->payment_date		= $payment_date;
				$db->payment_type		= $payment_type;
				$db->first_name			= $first_name;
				$db->last_name			= $last_name;
				$db->item_number		= $item_number;
				$db->item_name			= $item_name;
				$db->verify_sign		= $verify_sign;
				$db->subscr_date		= $subscr_date;
				$db->subscr_effective	= $subscr_effective;
				$db->custom				= $custom; // This is the plan id
				$db->store();
*/
				if (strcmp($receiver_email, $mybuzz) != 0 && $checkBusinessID) {
					// The receiver has been changed, possibly a fraud attempt
				} else {
					// Process payment
					// Paypal Subscription
					if(strcmp($txn_type, 'subscr_payment') == 0 && strcmp($payment_status, 'Completed') == 0 ) {
						userPayPalProcess( $item_number, $payment_date, $plan, $mc_gross, $mc_currency, '1', $invoice_number );
					// Paypal Buy Now
					} elseif (strcmp($txn_type, 'web_accept') == 0) {
						if(strcmp($payment_type, 'instant') == 0 && strcmp($payment_status, 'Pending') == 0 ) {
							// Something went wrong
						} elseif(strcmp($payment_type, 'instant') == 0 && strcmp($payment_status, 'Completed') == 0 ) {
							userPayPalProcess( $item_number, $payment_date, $plan, $mc_gross, $mc_currency, '0', $invoice_number );
						} elseif(strcmp($payment_type, 'echeck') == 0 && strcmp($payment_status, 'Pending') == 0 ) {
							// Maybe a different statement that the user sees on his page?
						} elseif(strcmp($payment_type, 'echeck') == 0 && strcmp($payment_status, 'Completed') == 0 ) {
							userPayPalProcess( $item_number, $payment_date, $plan, $mc_gross, $mc_currency, '0', $invoice_number );
						}
					// PayPal Subscription Expired
					} elseif (strcmp($txn_type, 'subscr_eot') == 0) {
						userPayPalEndOfTerm( $item_number );
					// Paypal Subscription Signup
					} elseif (strcmp($txn_type, 'subscr_signup') == 0) {
						userPayPalSignUp( $item_number, $subscr_date, $plan, $amount1,  $period1, $mc_currency);
					// PayPal Subscription Cancel
					} elseif (strcmp($txn_type, 'subscr_cancel') == 0) {
						userPayPalCancel( $item_number, $subscr_date );
					}
				}
			} elseif (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
		}
		fclose ($fp);
	}
}


function processVKLIXNotification ( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	// read the post from ViaKLIX
	$cfg = new Config_VKlix( $database );
	$cfg->load(1);

	$response	= '';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$response .= "$key=$value\n";
	}

	$merchant_id	= $cfg->accountid;
	$user_id		= $cfg->userid;
	$mypin			= $cfg->pin;

	// assign posted variables to local variables

	$ssl_result				= $_POST['ssl_result'];
	$ssl_result_message		= $_POST['ssl_result_message'];
	$ssl_txn_id				= $_POST['ssl_txn_id'];
	$ssl_approval_code		= $_POST['ssl_approval_code'];
	$ssl_cvv2_response		= $_POST['ssl_cvv2_response'];
	$ssl_avs_response		= $_POST['ssl_avs_response'];
	$ssl_transaction_type	= $_POST['ssl_transaction_type'];
	$ssl_invoice_number		= $_POST['ssl_invoice_number'];
	$ssl_amount				= $_POST['ssl_amount'];
	$ssl_email				= $_POST['ssl_email'];
	$ssl_description		= $_POST['ssl_description'];
	$userid					= $_POST['ssl_customer_code'];

	$otherinfo					= array();
	$otherinfo					= explode( '_-_', $ssl_description); // Broke description to get elements
	$username					= $otherinfo[0];
	$planid						= $otherinfo[1];
	$name						= $otherinfo[2];

	$plan = new SubscriptionPlan( $database );
	$plan->load($planid);

	// Create history entry
	$db = new logHistory( $database );
	$db->load(0);
	$db->proc_id			= GeneralInfoRequester::getProcessorIdByName( 'ViaKLIX' );
	$db->proc_name			= 'ViaKLIX';
	$db->user_id			= $userid;
	$db->user_name			= $username;
	$db->plan_id			= $planid;
	$db->plan_name			= $plan->name;
    $db->transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
    $db->amount				= $ssl_amount;
    $db->invoice_number		= $ssl_invoice_number;
    $db->response			= $response;

	if (!$db->check()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if ( ( $ssl_result == 0 ) && ( strcmp ( $ssl_result_message, "APPROVED") == 0 )) {
		// check the result of the operation
		// There is no custom field
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		// Process payment
		// ViaKLIX Subscription
		$renew	= userGatewayProcess( $userid, $plan, 'ViaKLIX', $ssl_invoice_number );
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew" );
	} elseif ($ssl_result > 0) {
		// log for manual investigation
	}
}

function processAuthorizeNotification ( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	// read the post from Authorize.net
	$cfg = new Config_Authorize( $database );
	$cfg->load(1);

	$response	= '';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$response .= "$key=$value\n";
	}

	$login				= $cfg->login;
	$transaction_key	= $cfg->transaction_key;

	// Process Payment as soon as it is received from Authorize server
	$x_description			= $_POST['x_description'];
	$x_response_code		= $_POST['x_response_code'];
	$x_response_reason_text	= $_POST['x_response_reason_text'];
	$x_invoice_num			= $_POST['x_invoice_num'];
	$x_amount				= $_POST['x_amount'];
	$userid					= $_POST['x_cust_id'];

	$otherinfo				= explode( '_-_', $x_description); // Broke description to get elements
	$username				= $otherinfo[0];
	$planid					= $otherinfo[1];
	$name					= $otherinfo[2];

	$plan = new SubscriptionPlan( $database );
	$plan->load($planid);

	// Create history entry
	$db = new logHistory( $database );
	$db->load(0);
	$db->proc_id			= GeneralInfoRequester::getProcessorIdByName( 'Authorize' );
	$db->proc_name			= 'Authorize';
	$db->user_id			= $userid;
	$db->user_name			= $username;
	$db->plan_id			= $planid;
	$db->plan_name			= $plan->name;
    $db->transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
    $db->amount				= $x_amount;
    $db->invoice_number		= $x_invoice_num;
    $db->response			= $response;

	if (!$db->check()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if($x_response_code == '1') {  // Transaction approved
		// check the result of the operation
		// There is no custom field
		// Process payment
		// Subscription
		$renew	= userGatewayProcess( $userid, $plan, 'Authorize', $x_invoice_num );
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew" );
	} else {
		// log for manual investigation
	}
}


function processAlloPassNotification ( $option ) {
    global $database, $mosConfig_absolute_path, $mosConfig_offset_user ,$mosConfig_live_site;

    // read the post from AlloPass
    $cfg = new Config_AlloPass( $database );
    $cfg->load(1);

	$response	= '';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$response .= "$key=$value\n";
	}

    $AUTH	= $cfg->auth;
    $RECALL = mosGetParam( $_REQUEST, 'RECALL', '' );
    $CODE0  = mosGetParam( $_REQUEST, 'CODE0', '' );

    // assign posted variables to local variables

    //$ssl_result                           = $_POST['ssl_result'];
    $ssl_result                             = '';
    //$ssl_result_message           = $_POST['ssl_result_message'];
    $ssl_result_message             = '';
    //$ssl_txn_id                           = $_POST['ssl_txn_id'];
    $ssl_txn_id                             = '';
    //$ssl_approval_code            = $_POST['ssl_approval_code'];
    $ssl_approval_code              = '';
    //$ssl_cvv2_response            = $_POST['ssl_cvv2_response'];
    $ssl_cvv2_response              = '';
    //$ssl_avs_response             = $_POST['ssl_avs_response'];
    $ssl_avs_response               = '';
    //$ssl_transaction_type = $_POST['ssl_transaction_type'];
    $ssl_transaction_type   = '';
    //$ssl_invoice_number           = $_POST['ssl_invoice_number'];
    $ssl_invoice_number             = mosGetParam( $_REQUEST, 'ssl_invoice_number', '' ) ;
    $ssl_amount						= mosGetParam( $_REQUEST, 'ssl_amount', '' ) ;
    //$ssl_amount                           = '';
    //$ssl_email                            = $_POST['ssl_email'];
    $ssl_email						 = '';
    //$ssl_description              = $_POST['ssl_description'];
    $ssl_description                =  mosGetParam( $_REQUEST, 'ssl_description', '' ) ;
	$userid							= $_POST['ssl_customer_code'];

    $otherinfo                                      = array();
    $otherinfo                                      = explode( '_-_', $ssl_description); // Broke description to get elements
    $username                                       = $otherinfo[0];
    $planid                                         = $otherinfo[1];
    $name                                           = $otherinfo[2];

	$plan = new SubscriptionPlan( $database );
	$plan->load($planid);

	// Create history entry
	$db = new logHistory( $database );
	$db->load(0);
	$db->proc_id			= GeneralInfoRequester::getProcessorIdByName( 'AlloPass' );
	$db->proc_name			= 'AlloPass';
	$db->user_id			= $userid;
	$db->user_name			= $username;
	$db->plan_id			= $planid;
	$db->plan_name			= $plan->name;
    $db->transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
    $db->amount				= $ssl_amount;
    $db->invoice_number		= $ssl_invoice_number;
    $db->response			= $response;

	if (!$db->check()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (trim($RECALL)=="") {
	    // if not RECALL is empty,
	    //back to error page
	      mosRedirect( "index.php?option=$option&task=cancel" );
	      exit;
	 }

	$r=@file("http://www.allopass.com/check/vf.php4?CODE=$CODE0&AUTH=$AUTH")  ;

	$test_ap = substr($r[0],0,2);
	if ( $test_ap != OK) {
		// log for manual investigation
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		errorAP( $option, $planid, $userid, $username, $name, $cfg->recurring);
	} elseif ($test_ap = OK) {
		// check the result of the operation
		// There is no custom field
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		// Process payment
		// AlloPass Subscription
		$renew	= userGatewayProcess( $userid, $plan, 'AlloPass', $ssl_invoice_number );
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew" );
		return;
	} else {
		// log for manual investigation
		return;
	}
}

function process2coNotification ( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	$cfg = new Config_2checkout( $database );
	$cfg->load(1);

	$response	= '';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$response .= "$key=$value\n";
	}

	$secret_word		= $cfg->secret_word;
	$vendor_num			= $cfg->vendor_num;

	// Process Payment as soon as it is received from 2Checkout server
	$description			= $_POST['cart_order_id'];
	$key					= $_POST['key'];
	$total					= $_POST['total'];
	$userid					= $_POST['cust_id'];
    $invoice_number			= $_POST['invoice_number'];
    $order_number			= $_POST['order_number'];
	$username				= $_POST['username'];
	$name					= $_POST['name'];
	$planid					= $_POST['planid'];
	$name					= $_POST['name'];

	$plan = new SubscriptionPlan( $database );
	$plan->load($planid);

	// Create history entry
	$db = new logHistory( $database );
	$db->load(0);
	$db->proc_id			= GeneralInfoRequester::getProcessorIdByName( '2checkout' );
	$db->proc_name			= '2checkout';
	$db->user_id			= $userid;
	$db->user_name			= $username;
	$db->plan_id			= $planid;
	$db->plan_name			= $plan->name;
    $db->transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
    $db->amount				= $total;
    $db->invoice_number		= $invoice_number;
    $db->response			= $response;

	if (!$db->check()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}


	$string_to_hash	= $secret_word.$vendor_num.$order_number.$total;
	$check_key		= strtoupper(md5($string_to_hash));

	if( (strcmp($check_key, $key) == 0) || ($cfg->testmode == 1) ) {  // Transaction approved
		// check the result of the operation
		// There is no custom field
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		// Process payment
		// Subscription
		$renew	= userGatewayProcess( $userid, $plan, '2checkout', $invoice_number );
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew" );
	} else {
		// log for manual investigation
	}
}

function processepsNotification ( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	$cfg = new Config_epsnetpay( $database );
	$cfg->load(1);

	$response	= '';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$response .= "$key=$value\n";
	}

	// Variables that we should get:
	// sapPopStsReturnStatus		- Statuscode (OK/NOK/VOK)
	// sapPopStsRequestor			- Merchant ID
	// sapPopStsEmpfname			- Receiver Name
	// sapPopStsEmpfnr				- Receiver Bank Account Number
	// sapPopStsEmpfblz				- Receiver Bank Number
	// sapPopStsGawVK				- Received Money Amount BEFORE the comma
	// sapPopStsGawNK				- Received Money Amount AFTER the comma
	// sapPopStsGawWhg				- Received currency
	// sapPopStsVwzweck				- Postback of sapUvwzweck (Usage of payment) - We use this for our description
	// sapPopStsRechnr				- Postback of sapUkddaten (Customer data) - We use this for the userid
	// sapPopStsZusatz				- Postback of sapUzusatz (Additional data) - We use this for the planid
	// sapPopStsDurchfDatum			- Postback of sapUdurchfDatum (Transaction date)
	// sapPopStsReturnFingerPrint	- Fingerprint


	// Netpayownz code:
	/*
	if (isset($_POST['sapPopStsReturnStatus'])) {
		array_push($StsParams, "Bank");
		foreach($StsParams as $ParName) {
			$params.=$ParName.$_REQUEST[$ParName];
		}
	$bank = $banks[$_REQUEST['Bank']];
	*/

	// I think it is for loading those variables from our own db that are posted to us.
	// So when we get a 'HaendlerPIN' with the POST, we search this from our db,
	// to put it into the fingerprint string to approve that one.

	$HaendlerPIN		= ''; // catch value from db
	$sapPopRequestor	= ''; // catch value from db

	// Check Fingerprint
	if (($fingerprint = md5($_POST['sapPopStsReturnStatus'].$HaendlerPIN.$sapPopRequestor.$_POST['sapPopStsEmpfname'].$_POST['sapPopStsEmpfnr'].$_POST['sapPopStsEmpfblz'].$_POST['sapPopStsGawVK'].$_POST['sapPopStsGawNK'].$_POST['sapPopStsGawWhg'].$_POST['sapPopStsVwzweck'].$_POST['sapPopStsRechnr'].$_POST['sapPopStsZusatz'].$_POST['sapPopStsDurchfDatum'].$_POST['sapPopStsURL']/*.$sapPopStsURL.$params*/)) == $_POST['sapPopStsReturnFingerPrint']) {
    // everything is ok
	} else {
	// Fingeprint wrong - fraud
	}

	// Process Payment as soon as it is received from Netpay server
	$description			= $_POST['sapPopStsVwzweck'];
	$userid					= $_POST['sapPopStsRechnr'];

	$otherinfo				= explode( '_-_', $description); // Broke description to get elements
	$username				= $otherinfo[0];
	$planid					= $otherinfo[1];
	$name					= $otherinfo[2];

	$sapUgawVK				= $_POST['sapUgawVK']; // Amount. Value before the comma
	$sapUgawNK				= $_POST['sapUgawNK']; // Amount. Value after the comma
	$sapPopStsReturnStatus	= $_POST['sapPopStsReturnStatus']; // Statuscode (OK/NOK/VOK)

	$plan   = new SubscriptionPlan( $database );
	$plan->load( $planid );

	// Create history entry
	// Yeah, generic log!!!
	$db = new logHistory( $database );
	$db->load(0);
	$db->proc_id			= GeneralInfoRequester::getProcessorIdByName( 'epsnetpay' );
	$db->proc_name			= 'epsnetpay';
	$db->user_id			= $userid;
	$db->user_name			= $username;
	$db->plan_id			= $planid;
	$db->plan_name			= $plan->name;
    $db->transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
    $db->amount				= "$sapUgawVK" . ',' . "$sapUgawNK";
    $db->invoice_number		= $_POST['cart_order_id'];
    $db->response			= $response;

	if (!$db->check()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$db->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if( (strcmp($sapPopStsReturnStatus, 'OK') == 0) ) {  // Transaction approved
		// check the result of the operation
		// There is no custom field
		// Process payment
		// Subscription
		$renew	= userGatewayProcess( $userid, $plan, 'epsnetpay'/*, $cart_order_id*/ );
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew" );
	} else {
		// log for manual investigation
	}
}

/*function processworldpayNotification ( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;
    $PROCESSOR_ALLOPASS			= 4;
    $PROCESSOR_2CHECKOUT		= 5;
	$PROCESSOR_WORLDPAY			= 6;
	$PROCESSOR_EPSNETPAY		= 7;

	$cfg = new Config_worldpay( $database );
	$cfg->load(1);

	$secret_word		= $cfg->secret_word;
	$vendor_num			= $cfg->vendor_num;

	// Create history entry
	$db = new worldpayHistory( $database );
	$db->load(0);
	if (!$db->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
    $db->transaction_date		= gmstrftime ("%Y-%m-%d", time()+$mosConfig_offset_user*3600);
    $db->invoice_number			= $_POST['cart_order_id'];
	if (!$db->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	// Process Payment as soon as it is received from Worldpay server
	$description			= $_POST['description'];
	$key					= $_POST['key'];
	$cart_order_id			= $_POST['cart_order_id'];
	$total					= $_POST['total'];
	$userid					= $_POST['cust_id'];

	$otherinfo				= explode( '_-_', $description); // Broke description to get elements
	$username				= $otherinfo[0];
	$planid					= $otherinfo[1];
	$name					= $otherinfo[2];

	$string_to_hash	= $secret_word.$vendor_num.$cart_order_id.$total;
	$check_key		= strtoupper(md5($string_to_hash));

	if( (strcmp($check_key, $key) == 0) || ($cfg->testmode == 1) ) {  // Transaction approved
		// check the result of the operation
		// There is no custom field
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		// Process payment
		// Subscription
		$renew	= userGatewayProcess( $userid, $plan, 'WorldPay', $cart_order_id );
		mosRedirect( "index.php?option=$option&task=thanks&renew=$renew" );
	} else {
		// log for manual investigation
	}
}*/

function errorAP ( $option, $planid, $userid, $username, $name, $recurring ) {
	HTML_Results::errorAP( $option, $planid, $userid, $username, $name, $recurring );
}

function thanks ( $option, $renew, $free ) {
	global $database, $mosConfig_emailpass, $ueConfig, $mosConfig_dbprefix;
	if(!($mosConfig_emailpass)) {
		$mosConfig_emailpass	= '0';	// Added for AEC - There is no mosConfig_emailpass anymore
	}

	$tables	= array();
	$tables	= $database->getTableList();
	$messagesToUser	= null;
	if( $renew == 0 ) {
		if($free) {
			$msg	= _SUB_COMPLETE_FREE;
		} else {
			$msg	= _SUB_COMPLETE;
		}
	} else {
		if($free) {
			$msg	= _SUB_COMPLETE_RENEW_FREE;
		} else {
			$msg	= _SUB_COMPLETE_RENEW;
		}
	}
	HTML_Results::thanks( $option, $msg );
}

function cancelPayment ( $option ) {
	global $database;
	$userid = trim( mosGetParam( $_REQUEST, 'itemnumber', '' ) );
	// The user cancel the payment operation
	// But user is already created as blocked on database, so we need to delete it
	$obj = new mosUser( $database );
	$obj->load($userid);
	if($obj->id) {
		if(strcmp($obj->type, 'Super Administrator') != 0 && strcmp($obj->type, 'Administrator') != 0 && $obj->block == 1) {
			// If the user is not blocked this can be a false cancel
			// So just delete user if he is blocked and is not an administrator or super admnistrator
			$obj->delete();
		}
	}
	HTML_Results::cancel( $option );
}

function userPayPalProcess ( $item_number, $payment_date, &$plan, $mc_gross, $mc_currency, $recurring, $invoice_number ) {
	global $mainframe, $database, $mosConfig_useractivation, $mosConfig_offset_user, $mosConfig_dbprefix;

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$item_number";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		return;
	}
	if( strcmp($db->status, 'Pending') == 0  ||	// OR
		(	(strcmp($db->type,   'None' ) == 0) &&	// AND
			(strcmp($db->status, 'Trial') == 0) ) ) {
		if ( $plan->period1 <= 0 ) {
			$amount		= $plan->amount3;
			$value		= $plan->period3;
			$perunit	= $plan->perunit3;
			$lifetime	= $plan->lifetime;
		} else {
			$amount		= $plan->amount1;
			$value		= $plan->period1;
			$perunit	= $plan->perunit1;
			$lifetime	= 0; // We entering the trial period. The lifetime will come at the renew.
		}
	} elseif(	(strcmp($db->status, 'Active') == 0) ||	// OR
				(strcmp($db->status, 'Closed') == 0) ||	// OR
				(strcmp($db->status, 'Trial' ) == 0)) {
		$amount		= $plan->amount3;
		$value		= $plan->period3;
		$perunit	= $plan->perunit3;
		$lifetime	= $plan->lifetime;
	} else {
		return;
	}

	// Create Invoice entry
	$objInvoice	= new Invoice($database);
	if(!($objInvoice->hasDuplicate($item_number, $invoice_number))) {
		$transaction_date				= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$objInvoice->load(0);
		$objInvoice->userid				= $item_number;
		$objInvoice->invoice_number		= $invoice_number;
		$objInvoice->transaction_date	= $transaction_date;
		$objInvoice->method				= 'PayPal';
		$objInvoice->amount				= $amount;
		$objInvoice->currency			= $mc_currency;
		$objInvoice->check();
		$objInvoice->store();

		// $database->setQuery( "INSERT INTO #__acctexp_invoices SET userid=$item_number, invoice_number='$invoice_number',"
		//	."\ntransaction_date='$transaction_date', method='PayPal', amount='$mc_gross', currency='$mc_currency'" );
		// $database->query();
	} else {
		// This payment has been processed already
		return;
	}

	if(!$mosConfig_useractivation) {
		// If user activation is disabled unblock the user
		$database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE id='$item_number'" );
		if (!$database->query()) {
			echo "SQL error" . $database->stderr(true);
		}
	}

	//if (!(strcmp($amount, $mc_gross) == 0 && strcmp($plan->currency_code, $mc_currency) == 0)) {
	//	return;
	//}

	if(!$lifetime) {	// NOT lifetime
		$unit = "";
		switch($perunit) {
			case "D":
			$unit = "DAY";
			break;

			case "W":
			// WEEK just work on MySQL 5.x
			$unit = "DAY";
			$value = $value * 7;
			break;

			case "M":
			$unit = "MONTH";
			break;

			case "Y":
			$unit = "YEAR";
			break;

		}
		$startdate = gmstrftime ("%Y-%m-%d", time()+$mosConfig_offset_user*3600);
	}
	if(strcmp($db->status, 'Pending') == 0) {
		// Set NEW expiration based on payment confirmed and payment plan
		// Be aware that payment date logged on paypal log is date at PayPal timezone
		if(!$lifetime) {	// NOT lifetime
			// the date we must use to calculate is local time respecting global configuration
			$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration=DATE_ADD('$startdate', INTERVAL $value $unit)" );
			$database->query();
		} else {
			// Includes a dummy entry just to user does not go to the excluded list, until we finally get rid of acctexp table
			$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration='9999-12-31'" );
			$database->query();
		}
		// Send notification email telling user can login now. Runs only on first payment.
		$tables	= array();
		$tables	= $database->getTableList();
		// If has CB leave with it to deal with emails
		
	} else {
		// Set expiration based on payment confirmed and payment plan
		// Be aware that payment date logged on paypal log is date at PayPal timezone
		// but the date we must use to calculate is local time respecting global configuration
		if((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Trial') == 0)) {
			// This is a renew subscription before actual expiration
			if(!$lifetime) {	// NOT lifetime
				if($db->lifetime == 0) {
					// So start date should be expiration date NOT today
					$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD(expiration, INTERVAL $value $unit) WHERE userid=$item_number" );
				} else {
					// unless he was lifetime before and won't be lifetime anymore
					$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
				}
			} else {
				$database->setQuery( "UPDATE #__acctexp SET expiration='9999-12-31' WHERE userid=$item_number" );
			}
		} else {
			// this should be a renew of a closed subscription
			if(!$lifetime) {	// NOT lifetime
				$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
			} else {
				$database->setQuery( "UPDATE #__acctexp SET expiration='9999-12-31' WHERE userid=$item_number" );
			}
		}
		$database->query();
		sendEmailRegistered( $item_number, 1 );
	}
	$db->lifetime	= $lifetime;
	// Test if it was a pending subscription to set signup_date
	if(strcmp($db->status, 'Pending') == 0) {
		//$db->signup_date	= date( 'Y-m-d H:i:s' );
		// If payment comes after signup, signup_date field will be empty
		// as userPayPalSignUp does not create an entry
		// If payment comes first signup_date will be override at userPayPalSignUp
		// with value provided by IPN
		$db->signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$db->type		= 'PayPal';
		$db->extra01	= $recurring;
		$db->plan		= $plan->id;
		if ( $plan->period1 <= 0 ) {
			// We don't have trial'
			$db->status		= 'Active';
		} else {
			// We have trial
			$db->status		= 'Trial';
		}
	} elseif( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) {
			$db->status		= 'Trial';
			$db->type		= 'PayPal';		// Payment Processor name
			$db->plan		= $plan->id;
	} elseif((strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0) || (strcmp($db->status, 'Active') == 0)) {
		// Renew subscription. DO NOT set signup_date
		$db->type		= 'PayPal';
		$db->plan		= $plan->id;
		$db->status		= 'Active';
	}
	//$db->lastpay_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", strtotime($payment_date)+$mosConfig_offset_user*3600);
	$db->lastpay_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	$db->check();
	$db->store();
	// Set group id
	$query = "SELECT aro_id FROM #__core_acl_aro WHERE value='$item_number'";
	$database->setQuery( $query );
	$aro_id = $database->loadResult();

	$query = "UPDATE #__core_acl_groups_aro_map"
	. "\n SET group_id = '$plan->gid'"
	. "\n WHERE aro_id = '$aro_id'"
	;
	$database->setQuery( $query );
	$database->query() or die( $database->stderr() );
	$query = "UPDATE #__users SET block='0', gid='$plan->gid' WHERE id = '$item_number'";
	$database->setQuery( $query );
	$database->query() or die( $database->stderr() );

	// Detect CB
	/**
	$tables	= array();
	$tables	= $database->getTableList();
	if(in_array($mosConfig_dbprefix."cbe", $tables)) {
		$query = "UPDATE #__cbe SET approved = 1 WHERE id = '$item_number'";
		$database->setQuery($query);
		$database->query();
	}
	**/
} // end function

function userPayPalSignUp ( $item_number, $subscr_date, &$plan, $amount1,  $period1, $mc_currency ) {
	global $mainframe, $database, $mosConfig_offset_user, $mosConfig_useractivation, $mosConfig_dbprefix;
	// Update Subscription table
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$item_number";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	// Test if exists. Sometimes Signup came first, but I cannot create an entry here
	// because both payment and signup can come at same time so two entries are created for user
	if($id) {
		$db->load($id);
		//$db->signup_date	= date('Y-m-d H:i:s');
		//$db->signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", strtotime($subscr_date)+$mosConfig_offset_user*3600);
		$db->signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$db->plan			= $plan->id;
		$db->type			= 'PayPal';
		$db->extra01		= '1'; // Recurring subscription

		// Test if it was a pending subscription and if it there is a trial period
		// $amount1 = amount for trial period took from IPN
		// $plan->amount1 = amount for trial period took from PayPlan configuration
		// $period1 = period for trial period took from IPN (e.g. "1 D")
		// $plan->period1 + $plan->perunit1 = period for trial period took from PayPlan configuration
		// We need to compares this values to avoid hacking
		// Also we only set expiration if this is a FREE trial
		// otherwise we need to wait payment of trial period to activate account
		// That will be done in userPayPalProcess in this case
		if((strcmp($db->status, 'Pending') == 0) && ($plan->period1 > 0) && ((strcmp($plan->amount1, '0.00') == 0) || (strcmp($plan->amount1, '0') == 0)) && (strcmp($period1, $plan->period1.' '.$plan->perunit1) == 0)) {
			$unit = "";
			$value = $plan->period1;
			switch($plan->perunit1) {
				case "D":
				$unit = "DAY";
				break;

				case "W":
				// WEEK just work on MySQL 5.x
				$unit = "DAY";
				$value = $value * 7;
				break;

				case "M":
				$unit = "MONTH";
				break;

				case "Y":
				$unit = "YEAR";
				break;

			}
			// unblock the user
			$database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE id='$item_number'" );
			if (!$database->query()) {
				echo "SQL error" . $database->stderr(true);
			}

			//$startdate = strftime("%Y-%m-%d", strtotime($payment_date));
			$startdate = gmstrftime ("%Y-%m-%d", time()+$mosConfig_offset_user*3600);
			if(strcmp($db->status, 'Pending') == 0) {
				// Set NEW expiration based on payment confirmed and payment plan
				// Be aware that payment date logged on paypal log is date at PayPal timezone
				// but the date we must use to calculate is local time respecting global configuration
				$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration=DATE_ADD('$startdate', INTERVAL $value $unit)" );
				$database->query();
				// Send notification email telling user can login now. Runs only on first payment.
				$tables	= array();
				$tables	= $database->getTableList();
				// If has CB leave with it to deal with emails
				
			} else {
				// Set expiration based on payment confirmed and payment plan
				// Be aware that payment date logged on paypal log is date at PayPal timezone
				// but the date we must use to calculate is local time respecting global configuration
				$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
				$database->query();
			}
			//$db->signup_date	= date( 'Y-m-d H:i:s' );
			// If payment comes after signup, signup_date field will be empty
			// as userPayPalSignUp does not create an entry
			// If payment comes first signup_date will be override at userPayPalSignUp
			// with value provided by IPN
			// Remember, we are here because this is a free trial
			$db->status		= 'Trial';
			$db->lastpay_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
			// Create Invoice entry
			$transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
			$database->setQuery( "INSERT INTO #__acctexp_invoices SET userid=$item_number, invoice_number=$invoice_number,"
					."\ntransaction_date='$transaction_date', method='PayPal', amount='$amount1', currency='$mc_currency'" );
			$database->query();
		}

		$db->check();
		$db->store();
	}
} // end function

function userPayPalCancel ( $item_number, $cancel_date ) {
	global $mainframe, $database, $mosConfig_offset_user;
	// Update Subscription table
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$item_number";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	// Test if new
	if(!$id) {
		$db->load(0);
		$db->userid		= $item_number;
		$db->type		= 'PayPal';
	} else {
		$db->load($id);
	}
	$db->status		= 'Cancelled';
	//$db->cancel_date	= date( 'Y-m-d H:i:s' );
	$db->cancel_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", strtotime($cancel_date)+$mosConfig_offset_user*3600);
	$db->check();
	$db->store();
} // end function


function userPayPalEndOfTerm ( $item_number ) {
	global $mainframe, $database, $mosConfig_offset_user;
	$database->setQuery( "UPDATE #__users SET block='1' WHERE id='$item_number'" );
	if (!$database->query()) {
		echo "SQL error" . $database->stderr(true);
	}
	$query = "SELECT expiration FROM #__acctexp WHERE userid=$item_number";
	$expiration = null;
	$database->setQuery( $query );
	$expiration = $database->loadResult();
	if($expiration) {
		$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_SUB(CURDATE(), INTERVAL 1 DAY) WHERE userid=$item_number" );
		$database->query();
	}
	// Update Subscription table
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$item_number";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	// Test if new
	if(!$id) {
		$db->load(0);
		$db->userid		= $item_number;
		$db->type		= 'PayPal';
	} else {
		$db->load($id);
	}
	$db->status		= 'Closed';
	//$db->eot_date	= date( 'Y-m-d H:i:s' );
	$db->eot_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	$query = "SELECT id, txn_type FROM #__acctexp_log_paypal WHERE item_number=$item_number AND (txn_type='subscr_failed' OR txn_type='subscr_cancel') ORDER BY id DESC LIMIT 1";
	$row = null;
	$database->setQuery( $query );
	if($database->loadObject($row)) {
		if(strcmp($row->txn_type, 'subscr_failed') == 0) {
			$db->eot_cause = _EOT_CAUSE_FAIL;
		} elseif(strcmp($row->txn_type, 'subscr_cancel') == 0) {
			$db->eot_cause = _EOT_CAUSE_BUYER;
		}
	}
	$db->check();
	$db->store();
} // end function

function userGatewayProcess ( $item_number, &$plan, $processor_name, $invoice_number ) {
	global $mainframe, $database, $mosConfig_useractivation, $mosConfig_offset_user, $mosConfig_dbprefix;

	// Initialize renew flag
	$renew	= 0;

	//$processor_id	= GeneralInfoRequester::getProcessorIdByName( $processor_name );
	/**
	if( $processor_id > 0 ) {
		// Get Processor Method
	 	$database->setQuery("SELECT name"
	 	. "\nFROM #__acctexp_processors"
	 	. "\nWHERE id='$processor_id'"
	 	);
	 	$method = $database->loadResult();
	} else {
		// if processor id equals zero this must
		// be a subscription with global entry plan
		// It is free
		$method	= 'None';
	} */
	$method	= $processor_name;

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$item_number";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		return;
	}

	if( (strcmp($db->status, 'Pending') == 0) ||	// OR
		( 	(strcmp($db->type,   'None' ) == 0) &&	// AND
			(strcmp($db->status, 'Trial') == 0) ) ) {
		// If user is using global trial period he still can use the trial period of a plan
		if ( $plan->period1 <= 0 ) {
			$amount		= $plan->amount3;
			$value		= $plan->period3;
			$perunit	= $plan->perunit3;
			$lifetime	= $plan->lifetime;
		} else {
			$amount		= $plan->amount1;
			$value		= $plan->period1;
			$perunit	= $plan->perunit1;
			$lifetime	= 0; // We entering the trial period. The lifetime will come at the renew.
		}
	} elseif(	(strcmp($db->status, 'Active') == 0) ||	// OR
				(strcmp($db->status, 'Closed') == 0) ||	// OR
				(strcmp($db->status, 'Trial' ) == 0)) {
		$amount		= $plan->amount3;
		$value		= $plan->period3;
		$perunit	= $plan->perunit3;
		$lifetime	= $plan->lifetime;
	} else {
		return;
	}

	if( $amount == null ) {
		// this can happen when using default entry plan
		$amount	= '0.00';
	}

	// Create Invoice entry
	$objInvoice	= new Invoice($database);
	if(!($objInvoice->hasDuplicate($item_number, $invoice_number))) {
		$transaction_date				= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$objInvoice->load(0);
		$objInvoice->userid				= $item_number;
		$objInvoice->invoice_number		= $invoice_number;
		$objInvoice->transaction_date	= $transaction_date;
		$objInvoice->method				= $method;
		$objInvoice->amount				= $amount;
		$objInvoice->currency			= 'USD';
		$objInvoice->check();
		$objInvoice->store();

		//$database->setQuery( "INSERT INTO #__acctexp_invoices SET userid=$item_number, invoice_number='$invoice_number',"
		//		."\ntransaction_date='$transaction_date', method='$method', amount='$amount', currency='USD'" );
		//$database->query();
	} else {
		// This payment has been processed already
		return;
	}

	if(!$mosConfig_useractivation) {
		// If user activation is disabled unblock the user
		$database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE id='$item_number'" );
		if (!$database->query()) {
			echo "SQL error" . $database->stderr(true);
		}
	}

	if(!$lifetime) {	// NOT lifetime
		$unit = "";
		switch($perunit) {
			case "D":
			$unit = "DAY";
			break;

			case "W":
			// WEEK just work on MySQL 5.x
			$unit = "DAY";
			$value = $value * 7;
			break;

			case "M":
			$unit = "MONTH";
			break;

			case "Y":
			$unit = "YEAR";
			break;

		}
		$startdate = gmstrftime ("%Y-%m-%d", time()+$mosConfig_offset_user*3600);
	}
	if(strcmp($db->status, 'Pending') == 0) {
		// Set NEW expiration based on payment confirmed and payment plan
		if(!$lifetime) {	// NOT lifetime
			// the date we must use to calculate is local time respecting global configuration
			$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration=DATE_ADD('$startdate', INTERVAL $value $unit)" );
			$database->query();
		} else {
			// Includes a dummy entry just to user does not go to the excluded list, until we finally get rid of acctexp table
			$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration='9999-12-31'" );
			$database->query();
		}
		// Send notification email telling user can login now. Runs only on first payment.
		$tables	= array();
		$tables	= $database->getTableList();
		// If has CB leave with it to deal with emails
		
	} else {
		// Set expiration based on payment confirmed and payment plan
		// the date we must use to calculate is local time respecting global configuration
		if((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Trial') == 0)){
			// This is a renew subscription before actual expiration
			if(!$lifetime) {	// NOT lifetime
				if($db->lifetime == 0) {
					// So start date should be expiration date NOT today
					$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD(expiration, INTERVAL $value $unit) WHERE userid=$item_number" );
				} else {
					// unless he was lifetime before and won't be lifetime anymore
					$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
				}
			} else {
				$database->setQuery( "UPDATE #__acctexp SET expiration='9999-12-31' WHERE userid=$item_number" );
			}
		} else {
			// this should be a renew of a closed subscription
			if(!$lifetime) {	// NOT lifetime
				$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
			} else {
				$database->setQuery( "UPDATE #__acctexp SET expiration='9999-12-31' WHERE userid=$item_number" );
			}
		}
		$database->query();
		sendEmailRegistered( $item_number, 1 );
	}
	$db->lifetime	= $lifetime;

	// Test if it was a pending subscription to set signup_date
	if(strcmp($db->status, 'Pending') == 0) {
		// Set subscription record for a new subscription
		$db->signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$db->type		= $method;		// Payment Processor name
		$db->plan		= $plan->id;
		if ($plan->period1 <= 0) {
			// We don't have trial
			if( ($plan->period3 > 0)  || $lifetime ) {
				$db->status		= 'Active';
			} else {
				// Why you have both periods equal zero without lifetime??
				// I will keep this user Pending
				$db->status		= 'Pending';
			}
		} else {
			// We have trial
			$db->status		= 'Trial';
		}
	} elseif( (strcmp($db->type, 'None') == 0) && (strcmp($db->status, 'Trial') == 0) ) {
			$db->status		= 'Trial';
			$db->type		= $method;		// Payment Processor name
			$db->plan		= $plan->id;
	} elseif((strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// Renew subscription - Do NOT set signup_date
		$db->type		= $method;		// Payment Processor name
		$db->plan		= $plan->id;
		$db->status		= 'Active';
		$renew			= 1;
	}
	$db->lastpay_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	$db->check();
	$db->store();
	// Set group id
	$query = "SELECT aro_id FROM #__core_acl_aro WHERE value='$item_number'";
	$database->setQuery( $query );
	$aro_id = $database->loadResult();

	$query = "UPDATE #__core_acl_groups_aro_map"
	. "\n SET group_id = '$plan->gid'"
	. "\n WHERE aro_id = '$aro_id'"
	;
	$database->setQuery( $query );
	$database->query() or die( $database->stderr() );

	$query = "UPDATE #__users SET block='0', gid = '$plan->gid' WHERE id = '$item_number'";
	$database->setQuery( $query );
	$database->query() or die( $database->stderr() );

	// CB Integration
	/**
	$tables	= array();
	$tables	= $database->getTableList();
	if(in_array($mosConfig_dbprefix."cbe", $tables)) {
		$query = "UPDATE #__cbe SET approved = 1 WHERE id = '$item_number'";
		$database->setQuery($query);
		$database->query();
	}
	**/
	return $renew;
} // end function

function sendEmailRegistered ( $id, $renew=0 ) {
	global $mainframe, $database, $my, $acl;
	global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
	global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mosConfig_fromname;

	$query = "SELECT name, email, username FROM #__users WHERE id='$id'";
	$urow = null;
	$database->setQuery( $query );
	if($database->loadObject($urow)) {
		$name = $urow->name;
		$email = $urow->email;
		$username = $urow->username;

		if( $renew == 0 ) {
			$subject = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
		} else {
			$subject = sprintf (_ACCTEXP_SEND_SUB_RENEW, $name, $mosConfig_sitename);
		}
		$subject = html_entity_decode($subject, ENT_QUOTES);
//		if ($mosConfig_useractivation=="1" && !($hasPayPal || $hasTransfer)){
//			$message = sprintf (_ACCTEXP_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site."/index.php?option=com_acctexp&task=activate&activation=".$row->activation, $mosConfig_live_site, $username);
//		} else {
			if( $renew == 0 ) {
				$message = sprintf (_ACCTEXP_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site);
			} else {
				$message = sprintf (_ACCTEXP_USEND_MSG_RENEW, $name, $mosConfig_sitename, $mosConfig_live_site);
			}
//		}

		$message = html_entity_decode($message, ENT_QUOTES);
		// Send email to user
		if ($mosConfig_mailfrom != "" && $mosConfig_fromname != "") {
			$adminName2 = $mosConfig_fromname;
			$adminEmail2 = $mosConfig_mailfrom;
		} else {
			$database->setQuery( "SELECT name, email FROM #__users"
			."\n WHERE usertype='superadministrator'" );
			$rows = $database->loadObjectList();
			$row2 = $rows[0];
			$adminName2 = $row2->name;
			$adminEmail2 = $row2->email;
		}

		mosMail($adminEmail2, $adminName2, $email, $subject, $message);

		// Send notification to all administrators
		if( $renew == 0 ) {
			$subject2 = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
			$message2 = sprintf (_ASEND_MSG, $adminName2, $mosConfig_sitename, $name, $email, $username);
		} else {
			$subject2 = sprintf (_ACCTEXP_SEND_SUB_RENEW, $name, $mosConfig_sitename);
			$message2 = sprintf (_ACCTEXP_ASEND_MSG_RENEW, $adminName2, $mosConfig_sitename, $name, $email, $username);
		}
		$subject2 = html_entity_decode($subject2, ENT_QUOTES);
		$message2 = html_entity_decode($message2, ENT_QUOTES);

		// get superadministrators id
		$admins = $acl->get_group_objects( 25, 'ARO' );

		foreach ( $admins['users'] AS $id ) {
			$database->setQuery( "SELECT email, sendEmail FROM #__users"
				."\n WHERE id='$id'" );
			$rows = $database->loadObjectList();

			$row = $rows[0];

			if ($row->sendEmail) {
				mosMail($adminEmail2, $adminName2, $row->email, $subject2, $message2);
			}
		}

	}
}

function hmac ($key, $data) {
   // RFC 2104 HMAC implementation for php.
   // Creates an md5 HMAC.
   // Eliminates the need to install mhash to compute a HMAC
   // Hacked by Lance Rushing

   $b = 64; // byte length for md5

   if (strlen($key) > $b) {
       $key = pack("H*",md5($key));
   }
   $key  = str_pad($key, $b, chr(0x00));
   $ipad = str_pad('', $b, chr(0x36));
   $opad = str_pad('', $b, chr(0x5c));
   $k_ipad = $key ^ $ipad ;
   $k_opad = $key ^ $opad;

   return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
}

function generateInvoiceNumber ($maxlength=16) {
	global $database;
	$numberofrows	= 1;
	while ($numberofrows) {
		// seed random number generator
		srand((double)microtime()*10000);
		$inum	=	"I" .substr(base64_encode(md5(rand())), 0, $maxlength);
		// Check if already exists
		$database->setQuery( "SELECT count(*) FROM #__acctexp_invoices"
		."\n WHERE invoice_number='$inum'" );
		$numberofrows = $database->loadResult();
	}
	return $inum;
}

function getFieldsForCBForm ( &$rowFields, &$rowFieldValues, $regErrorMSG=null ) {
	/**
	* Fuction from Joomla Community Builder
	* @version $Id: cbe.php 326 2006-05-09 01:50:12Z beat $
	* @package Community Builder
	* @subpackage cbe.php
	* @author JoomlaJoe and Beat
	* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
	*/
	global $database, $my, $_POST;
	$database->setQuery( "SELECT f.* FROM #__cbe_fields f, #__cbe_tabs t"
	. "\n WHERE t.tabid = f.tabid AND f.published=1 AND f.registration=1 AND t.enabled=1"
	. "\n ORDER BY t.position, t.ordering, f.ordering" );
	$rowFields = $database->loadObjectList();
	$rowFieldValues=array();
	for ($i=0, $n=is_array($rowFields) ? count( $rowFields ) : 0; $i < $n; $i++) {
		$rowFields[$i]->readonly = 0;		// read-only setting must be ignored at registration, as it's for profile only.
		$k="";
		if ($regErrorMSG!==null) {
			if (isset($_POST[$rowFields[$i]->name]) || ($rowFields[$i]->type=='webaddress' && $rowFields[$i]->rows==2 && isset($_POST[$rowFields[$i]->name."Text"]))) {
				if (is_array($_POST[$rowFields[$i]->name])) $k = implode("|*|",$_POST[$rowFields[$i]->name]);
				else $k=$_POST[$rowFields[$i]->name];
				$k=htmlspecialchars(cbGetUnEscaped($k));
			}
		} else {
			$_POST[$rowFields[$i]->name] = ((get_magic_quotes_gpc()==1) ? addslashes($rowFields[$i]->default) : $rowFields[$i]->default);
			$k=htmlspecialchars($rowFields[$i]->default);
		}
		$database->setQuery( "SELECT fieldtitle FROM #__cbe_field_values"
		. "\n WHERE fieldid = ".$rowFields[$i]->fieldid
		. "\n ORDER BY ordering" );
		$Values = $database->loadObjectList();
		if(count($Values) > 0) {
			$multi = ($rowFields[$i]->type=='multiselect') ? 'multiple="multiple"' : '';
			$vardisabled = ($rowFields[$i]->readonly > 0) ? ' disabled="disabled"' : '';
			if($rowFields[$i]->type=='radio') {
				$rowFieldValues['lst_'.$rowFields[$i]->name] = moscbeHTML::radioListTable( $Values, $rowFields[$i]->name,
					'class="inputbox" size="1" '.$vardisabled.'mosReq="'.$rowFields[$i]->required.'" mosLabel="'.getLangDefinition($rowFields[$i]->title).'"',
					'fieldtitle', 'fieldtitle', $k, $rowFields[$i]->cols, $rowFields[$i]->rows, $rowFields[$i]->size, $rowFields[$i]->required);
			} else {
				$ks=explode("|*|",$k);
				$k = array();
				foreach($ks as $kv) {
					$k[]->fieldtitle=$kv;
				}
				if($rowFields[$i]->type=='multicheckbox') {
					$rowFieldValues['lst_'.$rowFields[$i]->name] = moscbeHTML::checkboxListTable( $Values, $rowFields[$i]->name."[]",
						'class="inputbox" size="'.$rowFields[$i]->size.'" '.$multi.$vardisabled.' mosLabel="'.getLangDefinition($rowFields[$i]->title).'"',
						'fieldtitle', 'fieldtitle', $k, $rowFields[$i]->cols, $rowFields[$i]->rows, $rowFields[$i]->size, $rowFields[$i]->required);
				} else {
					$rowFieldValues['lst_'.$rowFields[$i]->name] = moscbeHTML::selectList( $Values, $rowFields[$i]->name."[]",
						'class="inputbox" size="'.$rowFields[$i]->size.'" '.$multi.$vardisabled.' mosReq="'.$rowFields[$i]->required.'" mosLabel="'.getLangDefinition($rowFields[$i]->title).'"',
						'fieldtitle', 'fieldtitle', $k);
				}
			}
		}
	}
	if ($regErrorMSG===null) {
		$regErrorMSG = "";			// So that default values are displayed
		$_POST['firstname'] = "";
		$_POST['middlename'] = "";
		$_POST['lastname'] = "";
		$_POST['name'] = "";
		$_POST['username'] = "";
		$_POST['email'] = "";
	}
}

//function saveCBSubscription ( $option, &$row, $generatedPassword, $pwd ) {
//	/**
//	* Fuction from Joomla Community Builder
//	* @version $Id: cbe.php 326 2006-05-09 01:50:12Z beat $
//	* @package Community Builder
//	* @subpackage cbe.php
//	* @author JoomlaJoe and Beat
//	* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
//	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//	*/
//	global $database, $my, $acl, $ueConfig, $_POST;
//	global $mosConfig_emailpass, $mosConfig_allowUserRegistration, $_PLUGINS;
//
//	if ($mosConfig_allowUserRegistration=="0") {
//		mosNotAuth();
//		return;
//	}
//
//	if(!($mosConfig_emailpass)) {
//		$mosConfig_emailpass	= '0';	// Added for AEC - There is no mosConfig_emailpass anymore
//	}
//	// $database->setQuery("SELECT id FROM #__users WHERE email = '".cbGetEscaped( $_POST['email'] )."' AND username='0'");
//	// $uid = $database->loadResult();
//	// if($uid >0 ) $_POST['id'] = $uid;
//
//	// $row = new mosUser( $database ); // Removed for AEC
//	/**
//	if (!$row->bind( $_POST )) {
//		echo "<script type=\"text/javascript\"> alert('".html_entity_decode($row->getError())."');</script>\n";
//		registerForm( $option, $mosConfig_emailpass,$row->getError() );
//		return;
//	}
//
//
//	switch ( $ueConfig['name_style'] ) {
//		case 2:
//			$row->name = cbGetUnEscaped(((isset($_POST['firstname'])) ? $_POST['firstname'] : "") . ' '
//					   . ((isset($_POST['lastname']))  ? $_POST['lastname']  : ""));
//		break;
//		case 3:
//			$row->name = cbGetUnEscaped(((isset($_POST['firstname'])) ? $_POST['firstname'] : "") . ' '
//					   . ((isset($_POST['middlename']))  ? ($_POST['middlename'] . ' ')  : "")
//					   . ((isset($_POST['lastname']))  ? $_POST['lastname']  : ""));
//		break;
//	}
//	mosMakeHtmlSafe($row);
//	$row->id 		= 0;
//	$row->gid = $acl->get_group_id('Registered','ARO');
//	$row->usertype = 'Registered';
//
//	if (!$row->password) {
//		$row->password = makePass();
//		$generatedPassword = true;
//	} else {
//		$generatedPassword = false;
//	}
//
//	$row->registerDate = date("Y-m-d\TH:i:s");
//
//	if (!$row->check()) {
//		echo "<script type=\"text/javascript\"> alert('".html_entity_decode($row->getError())."');</script>\n";
//		registerForm( $option, $mosConfig_emailpass,$row->getError() );
//		return;
//	}
//
//	**/ // Removed for AEC
//	if ($ueConfig['reg_admin_approval']=="0") {
//		$approved="1";
//	} else {
//		$approved="0";
//		$row->block = '1';
//	}
//	if ($ueConfig['reg_confirmation']=="0") {
//		$confirmed="1";
//	} else {
//		$confirmed="0";
//		$row->block = '1';
//	}
//
//	if(ISSET($_POST['acceptedterms'])) $acceptedterms=cbGetUnEscaped($_POST['acceptedterms']);
//	else $acceptedterms=null;
//
//	$database->setQuery( "SELECT f.* FROM #__cbe_fields f, #__cbe_tabs t"
//	. "\n WHERE f.published=1 and f.tabid = t.tabid and f.registration=1 and t.enabled=1" );
//	$rowFields = $database->loadObjectList();
//
//	$reqErrors = array();
//
//	$cbFields  = new cbFields();
//	$rowExtras = new moscbe($database);
//	for($i=0, $n=is_array($rowFields) ? count( $rowFields ) : 0; $i < $n; $i++) {
//		$field=cbGetEscaped($rowFields[$i]->name);
//		$value=null;
//		if(isset($_POST[$rowFields[$i]->name])) $value=$cbFields->prepareFieldDataSave($rowFields[$i]->type,$rowFields[$i]->name,$_POST[$rowFields[$i]->name]);
//		$rowExtras->$field = $value;
//		if ($value == "" && $rowFields[$i]->required == 1 && !in_array($rowFields[$i]->type, array("delimiter", "hidden"))) {
//			$reqErrors[] = getLangDefinition($rowFields[$i]->title) . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
//		}
//	}
//
//	$rowExtras->id=null;
//	$rowExtras->user_id=null;
//	$rowExtras->firstname=cbGetUnEscaped((isset($_POST['firstname']) ? $_POST['firstname'] : ""));
//	$rowExtras->middlename=cbGetUnEscaped((isset($_POST['middlename']) ? $_POST['middlename'] : ""));
//	$rowExtras->lastname=cbGetUnEscaped((isset($_POST['lastname']) ? $_POST['lastname'] : ""));
//	$rowExtras->acceptedterms=$acceptedterms;
//	$rowExtras->approved=$approved;
//	$rowExtras->confirmed=$confirmed;
//
//	switch( $ueConfig['name_style'] ) {
//		case 2:
//		case 3:
//			if ($rowExtras->firstname == "") {
//				$reqErrors[] = _UE_YOUR_FNAME . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
//			}
//			if ($rowExtras->lastname == "") {
//				$reqErrors[] = _UE_YOUR_LNAME . " : " . unHtmlspecialchars(_UE_REQUIRED_ERROR);
//			}
//		break;
//		default:
//		break;
//	}
//	if (strlen($row->username) < 3) {
//		$reqErrors[] = sprintf( unHtmlspecialchars(_VALID_AZ09), unHtmlspecialchars(_PROMPT_UNAME), 2 );
//	}
//	if ($mosConfig_emailpass != "1") {
//		if ($generatedPassword || strlen($row->password) < 6) {
//			$reqErrors[] = sprintf( unHtmlspecialchars(_VALID_AZ09), unHtmlspecialchars(_REGISTER_PASS), 6 );
//		} elseif (isset($_POST["verifyPass"]) && ($_POST["verifyPass"] != $_POST["password"])) {
//			$reqErrors[] = unHtmlspecialchars(_REGWARN_VPASS2);
//		}
//	}
//	if($ueConfig['reg_enable_toc']) {
//		if ($rowExtras->acceptedterms == "") {
//			$reqErrors[] = _UE_TOC_REQUIRED;
//		}
//	}
//	if (count($reqErrors) > 0) {
//		echo "<script type=\"text/javascript\">alert(\"".implode('\n',$reqErrors)."\"); </script>\n";
//		// registerForm( $option, $mosConfig_emailpass,implode("<br />",$reqErrors)."<br />" );
//		return;
//	}
//
//	$_PLUGINS->loadPluginGroup('user');
//	$row->password	= $pwd;		// Added for AEC integration
//	$_PLUGINS->trigger( 'onBeforeUserRegistration', array(&$row,&$rowExtras));
//	$row->password	= md5( $row->password );
//	if($_PLUGINS->is_errors()) {
//		echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\"); </script>\n";
//		// registerForm( $option, $mosConfig_emailpass,$_PLUGINS->getErrorMSG("<br />") );
//		return;
//	}
//
//	/**
//	$pwd = $row->password;
//	$row->password = md5( $row->password );
//
//	if (!$row->store()) {		// first store to get new user id if id is not set (needed for savePluginTabs)
//		echo "<script type=\"text/javascript\"> alert('store:".html_entity_decode($row->getError())."'); </script>\n";
//		registerForm( $option, $mosConfig_emailpass,$row->getError() );
//		return;
//	}
//	**/ // Removed for AEC
//
//	$database->setQuery("SELECT id FROM #__users WHERE username = '".cbGetEscaped( $_POST['username'] )."'");
//	$uid = $database->loadResult();
//	$row->id=$uid;		// this is only for mambo 4.5.0 backwards compatibility. 4.5.2.3 $row->store() updates id on insert
//
//	$rowExtras->id = $row->id;
//	$rowExtras->user_id = $row->id;
//
//	$row->password = $pwd;
//	$userComplete =& moscbe::dbObjectsMerge($row, $rowExtras);
//	$tabs = new cbTabs( 0, 1);
//	$results_save_tabs = $tabs->saveRegistrationPluginTabs($userComplete, $_POST);
//	$pwd = $row->password;
//	$row->password = md5( $row->password );
//	/**
//	if (!$row->store()) {
//		echo "<script type=\"text/javascript\"> alert('".html_entity_decode($row->getError())."'); </script>\n";
//		registerForm( $option, $mosConfig_emailpass,$row->getError() );
//		return;
//	}
//	**/ // Removed for AEC
//	if(!$database->insertObject( '#__cbe', $rowExtras)) {
//		echo "store error:".html_entity_decode($database->stderr(true))."\n";
//		exit();
//	}
//
//	$row->password = $pwd;
//	$_PLUGINS->trigger( 'onAfterUserRegistration', array($row, $rowExtras, true));
//
//	$query = "SELECT * FROM #__cbe c, #__users u WHERE c.id=u.id AND c.id =" . $uid;
//	$database->setQuery($query);
//	$user = $database->loadObjectList();
//
//	$pwd_md5 = $user[0]->password;
//	$user[0]->password = $pwd;
//
//	$cbNotification = new cbNotification();
//	$modSub=null;
//	$modMSG=null;
//	if($confirmed==0) {
//		$cbNotification->sendFromSystem($user[0],getLangDefinition($ueConfig['reg_pend_appr_sub']),getLangDefinition($ueConfig['reg_pend_appr_msg']));
// 	} elseif($approved==0 && $confirmed==1) {
//		$cbNotification->sendFromSystem($user[0],getLangDefinition($ueConfig['reg_pend_appr_sub']),getLangDefinition($ueConfig['reg_pend_appr_msg']));
//		$modSub=_UE_REG_ADMIN_PA_SUB;
//		$modMSG=_UE_REG_ADMIN_PA_MSG;
// 	} else {
//		// done in activateUser() below: $cbNotification->sendFromSystem($user[0],getLangDefinition($ueConfig['reg_welcome_sub']),getLangDefinition($ueConfig['reg_welcome_msg']));
//		$modSub=_UE_REG_ADMIN_SUB;
//		$modMSG=_UE_REG_ADMIN_MSG;
//		// activateUser($user[0], false); // Disable for AEC
//	}
//	$user[0]->password = $pwd_md5;
//	if($modSub!=null) {
//		if($ueConfig['moderatorEmail']) {
//			$cbNotification->sendToModerators($modSub,$cbNotification->_replaceVariables($modMSG,$user[0]));
//		}
//	}
//
//	if ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="0"){
//		$messagesToUser = _UE_REG_COMPLETE_NOPASS_NOAPPR;
//	} elseif ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="1") {
//		$messagesToUser = _UE_REG_COMPLETE_NOPASS_NOAPPR_CONF;
//	} elseif ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="0" && $ueConfig['reg_confirmation']=="0") {
//		$messagesToUser = _UE_REG_COMPLETE_NOPASS;
//	} elseif ($mosConfig_emailpass == "1" && $ueConfig['reg_admin_approval']=="0" && $ueConfig['reg_confirmation']=="1") {
//		$messagesToUser = _UE_REG_COMPLETE_NOPASS_CONF;
//	} elseif ($mosConfig_emailpass == "0" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="0") {
//		$messagesToUser = _UE_REG_COMPLETE_NOAPPR;
//	} elseif ($mosConfig_emailpass == "0" && $ueConfig['reg_admin_approval']=="1" && $ueConfig['reg_confirmation']=="1") {
//		$messagesToUser = _UE_REG_COMPLETE_NOAPPR_CONF;
//	} elseif ($mosConfig_emailpass == "0" && $ueConfig['reg_admin_approval']=="0" && $ueConfig['reg_confirmation']=="1") {
//		$messagesToUser = _UE_REG_COMPLETE_CONF;
//	} else {
//		$messagesToUser = _UE_REG_COMPLETE;
//	}
//
//	foreach ($results_save_tabs as $res) {
//		if ($res) $messagesToUser .= "<br />".$res;
//	}
//
//	$_PLUGINS->trigger( 'onAfterUserRegistrationMailsSent', array($row, $rowExtras, &$messagesToUser, $ueConfig['reg_confirmation'], $ueConfig['reg_admin_approval'], true));
//	if($_PLUGINS->is_errors()) {
//		echo $_PLUGINS->getErrorMSG();
//		return;
//	}
//	$row->password = md5( $row->password ); // Just in case... Added for AEC
//	// echo $messagesToUser;
//	return $messagesToUser;	// Added for AEC
//}
//
//function login ( $username=null,$passwd=null ) {
//	/**
//	* Fuction from Joomla Community Builder
//	* @version $Id: cbe.php 326 2006-05-09 01:50:12Z beat $
//	* @package Community Builder
//	* @subpackage cbe.php
//	* @author JoomlaJoe and Beat
//	* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
//	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//	*/
//	global $acl,$database,$_COOKIE,$_POST,$mainframe, $ueConfig,$mainframe,$_PLUGINS;
//	global $mosConfig_offset_user, $mosConfig_dbprefix;
//	$resultError = null;
//	// $usercookie = mosGetParam( $_COOKIE, 'usercookie', '' );
//	// $sessioncookie = mosGetParam( $_COOKIE, 'sessioncookie', '' );
//	if (!$username || !$passwd) {
//		$username = trim( mosGetParam( $_POST, 'username', '' ) );
//		$passwd2 = trim( mosGetParam( $_POST, 'passwd', '' ) );
//		$passwd = md5( $passwd2 );
//	}
//	$return = trim( mosGetParam( $_POST, 'return', null ) );
//	$message = trim( mosGetParam( $_POST, 'message', 0 ) );
//	// print "message:".$message;
//	// $remember = trim( mosGetParam( $_POST, 'remember', '' ) );
//	// $lang = trim( mosGetParam( $_POST, 'lang', '' ) );
//
//	if (!$username || !$passwd) {
//		$resultError = _LOGIN_INCOMPLETE;
//	} else {
//		// AEC verification
//		$query = "SELECT id, registerDate FROM #__users WHERE username='$username'";
//		$database->setQuery( $query );
//		$usr = null;
//		$database->loadObject($usr);
//		if ($usr->id) {
//			$query = "SELECT expiration FROM #__acctexp WHERE userid=$usr->id AND expiration<>'9999-12-31'";
//			$expiration = null;
//			$database->setQuery( $query );
//			$expiration = $database->loadResult();
//			if ($expiration) {
//				//changed for instant expiration
//				$expiration = $expiration." 00:00:00";
//				$expstamp = strtotime($expiration);
//		        $query = "SELECT status FROM #__acctexp_subscr WHERE userid=$usr->id";
//		        $expiration = null;
//		        $database->setQuery( $query );
//		        $status = $database->loadResult();
//				if (strcmp($status, 'Pending') == 0) {
//					// Subscription pending.
//					mosRedirect( "index.php?option=com_acctexp&task=pending&userid=" . $usr->id );
//					exit();
//				}
//				if ( (strcmp($status, 'Closed') == 0) || (strcmp($status, 'Cancelled') == 0) || ( ($expstamp > 0) && ( $expstamp-(time()+$mosConfig_offset_user*3600) < 0 ) )) {
//					// mosRedirect( "index.php?option=com_acctexp&user=" . $username . "&expiration=" . strftime(_ACCT_DATE_FORMAT, $expstamp));
//					// Subscription expired. Send user to renew option
//					mosRedirect( "index.php?option=com_acctexp&task=expired&userid=" . $usr->id . "&expiration=" . strftime(_ACCT_DATE_FORMAT, $expstamp));
//					exit();
//				}
//			}
//		}
//
//		$tables	= array();
//		$tables	= $database->getTableList();
//		if(in_array($mosConfig_dbprefix."cbe", $tables)) {	// CB Integration
//			$_PLUGINS->loadPluginGroup('user');
//			$_PLUGINS->trigger( 'onBeforeLogin', array($username, $passwd2));
//			//print_r($results);
//			if($_PLUGINS->is_errors()) {
//				$resultError = $_PLUGINS->getErrorMSG();
//			} else {
//				$database->setQuery( "SELECT * "
//				. "\nFROM #__users u, "
//				. "\n#__cbe ue"
//				. "\nWHERE u.username='".$username."' AND u.password='".$passwd."' AND u.id = ue.id"
//				);
//				$row = null;
//				if ( $database->loadObject( $row ) ) {
//					if ( $row->approved == 2 ) {
//						$resultError = _LOGIN_REJECTED;
//					} else if ( $row->confirmed != 1 ) {
//						$cbNotification = new cbNotification();
//						$cbNotification->sendFromSystem($row->id,getLangDefinition($ueConfig['reg_pend_appr_sub']),getLangDefinition($ueConfig['reg_pend_appr_msg']));
//						$resultError = _LOGIN_NOT_CONFIRMED;
//					} else if ( $row->approved == 0 ) {
//						$resultError = _LOGIN_NOT_APPROVED;
//					} else if ( $row->block == 1 ) {
//						$resultError = _LOGIN_BLOCKED;
//					} else if ($row->lastvisitDate == '0000-00-00 00:00:00') {
//						if (isset($ueConfig['reg_first_visit_url']) and ($ueConfig['reg_first_visit_url'] != "")) {
//							$return = sefRelToAbs($ueConfig['reg_first_visit_url']);
//						}
//					}
//				} else {
//					$resultError = _LOGIN_INCORRECT;
//				}
//			}
//		}
//		if ($resultError) {
//			$alertmessage = $resultError;
//		} else {
//			$tables	= array();
//			$tables	= $database->getTableList();
//			if(in_array($mosConfig_dbprefix."cbe", $tables)) {	// CB Integration
//				if (checkJversion() == 0) {
//					$mainframe->login($username,$passwd);
//				} else {
//					$mainframe->login($username,$passwd2);
//				}
//				$_PLUGINS->trigger( 'onAfterLogin', array($row, true));
//				$alertmessage = $message ? _LOGIN_SUCCESS : null;
//			} else {
//				//JOOMLAHACKS.COM
//				if (file_exists( 'administrator/components/com_smf/config.smf.php' )) {
//					/**
//					require_once( 'includes/frontend.php' );
//					global $context;
//					require_once( 'administrator/components/com_smf/config.smf.php' );
//					require_once( 'administrator/components/com_smf/functions.smf.php' );
//					saveVars($savedVars);
//					require_once($smf_path."/SSI.php");
//					restoreVars($savedVars);
//					**/
//					$_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
//					$_SESSION['_FROM_MOS'] = true;
//					$_SESSION['_RETURN'] = $return;
//					doMamboSMF(true);
//				} else {
//					$mainframe->login($username,$passwd);
//				}
//			}
//		}
//		// JS Popup message
//		if ( $alertmessage ) {
//			?>
//			<script type="text/javascript">
//			<!--//
//			alert( "<?php echo $alertmessage; ?>" );
//			//-->
//			</script>
//			<?php
//			/*
//			**not sure if this is the best case but the
//			**reason why we weren't seeing the login message was
//			**because we are immediately redirecting to another page
//			**so if we flush out the contents to the browser then we get the alert.
//			*/
//			if (!$resultError) {
//				ob_flush();
//			}
//		}
//		if ($resultError) {
//			echo "<div class=\"message\">".$alertmessage."</div>";
//			return;
//		} else {
//			if ( $return ) {
//				mosRedirect( (strncasecmp($return, "http:", 5)||strncasecmp($return, "https:", 6)) ? $return : sefRelToAbs($return));
//			} else {
//				mosRedirect(sefRelToAbs('index.php') );
//			}
//		}
//	}
//}
//
//function logout () {
//	global $mosConfig_live_site;
//	/**
//	* Fuction from Joomla Community Builder
//	* @version $Id: cbe.php 326 2006-05-09 01:50:12Z beat $
//	* @package Community Builder
//	* @subpackage cbe.php
//	* @author JoomlaJoe and Beat
//	* @copyright (C) JoomlaJoe and Beat, www.joomlapolis.com
//	* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
//	*/
//	global $_POST,$mainframe,$my,$database,$_PLUGINS, $mosConfig_dbprefix;
//
//	$return = trim( mosGetParam( $_POST, 'return', null ) );
//	$message = trim( mosGetParam( $_POST, 'message', 0 ) );
//
//	$tables	= array();
//	$tables	= $database->getTableList();
//	if(in_array($mosConfig_dbprefix."cbe", $tables)) {	// CB Integration
//		$database->setQuery( "SELECT * "
//		. "\nFROM #__users u, "
//		. "\n#__cbe ue"
//		. "\nWHERE u.id=".$my->id." AND u.id = ue.id"
//		);
//		$row = null;
//		$database->loadObject( $row );
//		$_PLUGINS->loadPluginGroup('user');
//		$_PLUGINS->trigger( 'onBeforeLogout', array($row));
//		if($_PLUGINS->is_errors()) {
//			echo "<script type=\"text/javascript\">alert(\"".$_PLUGINS->getErrorMSG()."\");</script>\n";
//			echo "<div class=\"message\">".$_PLUGINS->getErrorMSG()."</div>";;
//			return;
//		}
//		$mainframe->logout();
//		$_PLUGINS->trigger( 'onAfterLogout', array($row, true));
//	} else {
//				//JOOMLAHACKS.COM
//				if (file_exists( 'administrator/components/com_smf/config.smf.php' )) {
//					// TODO: We need this session thing to work for a proper logout!
//					require_once( 'includes/frontend.php' );
//					global $context;
//					/**
//					require_once( 'administrator/components/com_smf/config.smf.php' );
//					require_once( 'administrator/components/com_smf/functions.smf.php' );
//					saveVars($savedVars);
//					require_once($smf_path."/SSI.php");
//					restoreVars($savedVars);
//					**/
//					mosRedirect($mosConfig_live_site."/index.php?option=com_smf&Itemid=129&action=logout;sesc=".$context['session_id']);
//				} else {
//					$mainframe->logout();
//				}
//	}
//	// JS Popup message
//	if ( $message ) {
//		?>
//		<script type="text/javascript">
//		<!--//
//		alert( "<?php echo _LOGOUT_SUCCESS; ?>" );
//		//-->
//		</script>
//		<?php
//		/*
//		**not sure if this is the best case but the
//		**reason why we weren't seeing the logout message was
//		**because we are immediately redirecting to another page
//		**so if we flush out the contents to the browser then we get the alert.
//		*/
//		ob_flush();
//	}
//
//	if ($return) {
//		mosRedirect( (strncasecmp($return, "http:", 5)||strncasecmp($return, "https:", 6)) ? $return : sefRelToAbs($return));
//	} else {
//		mosRedirect(sefRelToAbs('index.php'));
//	}
//}
//// CB Integration - Block 03 End
?>
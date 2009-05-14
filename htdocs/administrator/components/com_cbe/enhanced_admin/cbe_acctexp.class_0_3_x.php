<?php
/**
* AcctExp Component
* @package AcctExp
* @copyright 2004 Helder Garcia
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @version $Revision: 1.2 $
* @author Helder Garcia <hlbog@sounerd.com.br>
*/
//
// Copyright (C) 2004 Helder Garcia
// All rights reserved.
// This source file is part of the Account Expiration Control Component, a Joomla
// custom Component By Helder Garcia - http://www.sounerd.com.br
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
//
// Dont allow direct linking
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//require_once( $mainframe->getPath( 'front_html' ) );
//require_once( $mainframe->getPath( 'class' ) );
//$task = trim( mosGetParam( $_REQUEST, 'task', '' ) );
//$expiration = trim( mosGetParam( $_REQUEST, 'expiration', '' ) );
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
//		registerForm( $option, $mosConfig_useractivation );
//		break;
//
//	case 'saveregistration':
//		saveRegistration( $option );
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
//	case 'thanks':
//		thanksPayPal( $option );
//		break;
//
//	case 'transfer':
//		thanksTransfer( $optionipn );
//		break;
//
//	case 'cancel':
//		cancelPayPal( $option );
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
//	case 'transferform':
//		$planid		= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		$username	= trim( mosGetParam( $_REQUEST, 'username', '' ) );
//		$name		= trim( mosGetParam( $_REQUEST, 'name', '' ) );
//		transferForm( $option, $planid, $userid, $username, $name, $recurring );
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
//	default:
//		$userid		= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
//		expired($option, $userid, $expiration);
//		break;
//}

function expired($option, $userid, $expiration) {
	HTML_frontEnd::expired($option, $userid, $expiration);
}

//function lostPassForm( $option ) {
//	global $mainframe;
//	$mainframe->SetPageTitle(_PROMPT_PASSWORD);
//	HTML_registration::lostPassForm($option);
//}

//function sendNewPass( $option ) {
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

//function registerForm( $option, $useractivation ) {
//	global $mainframe, $database, $my, $acl;
//
//	if (!$mainframe->getCfg( 'allowUserRegistration' )) {
//		mosNotAuth();
//		return;
//	}
//	$mainframe->SetPageTitle(_REGISTER_TITLE);
//	HTML_registration::registerForm($option, $useractivation);
//}

function renewSubscription( $option, $id=null  ) {
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

	selectSubscriptionPlan($option, $id, $user->username, $user->name);

}

/** Old function
function saveRegistration( $option ) {
	global $database, $my, $acl;
	global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
	global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mosConfig_fromname;

	if ($mosConfig_allowUserRegistration=="0") {
		mosNotAuth();
		return;
	}

	$row = new mosUser( $database );

	if (!$row->bind( $_POST, "usertype" )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosMakeHtmlSafe($row);

	$row->id = 0;
	$row->usertype = '';
	$row->gid = $acl->get_group_id('Registered','ARO');

	if ($mosConfig_useractivation=="1") {
		$row->activation = md5( mosMakePassword() );
		$row->block = "1";
	}

	$cfg = new myConfig( $database );
	$cfg->load(1);

	if($cfg->paypal || $cfg->transfer) {
		$row->block = "1"; // Force blocked.
	}

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$pwd = $row->password;
	$row->password = md5( $row->password );
	$row->registerDate = date("Y-m-d H:i:s");

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$name = $row->name;
	$username = $row->username;
	$userid = $row->id;
	$registerDate = $row->registerDate; // For use on expiration date

	if(!$cfg->paypal) {
		// Send notification email as usual
		sendEmailRegistered( $row->id, $cfg->paypal, $cfg->transfer );
		// Set default expiration unless PayPal processed
        $database->setQuery( "INSERT INTO #__acctexp SET userid=$userid, expiration=DATE_ADD('$registerDate', INTERVAL $cfg->initialexp DAY)" );
		$database->query();
	} else {
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
		$db->userid		= $userid;
		$db->status		= 'Pending';
		$db->type		= 'PayPal';
		$db->signup_date	= date( 'Y-m-d H:i:s' );
		$db->check();
		$db->store();

		// Add new expiration to db
		$database->setQuery( "INSERT INTO #__acctexp SET userid=$userid, expiration=DATE_ADD('$registerDate', INTERVAL $cfg->initialexp DAY)" );
		$database->query();

		// Unblock user
		$query= "UPDATE #__users SET block='0', activation='' WHERE id='$userid'";
        $database->setQuery( $query );
		$database->query();
	}

	if($cfg->paypal || $cfg->transfer) {
		payForm($option, $userid, $username, $name);
	} else {
		if ( $mosConfig_useractivation == "1" ){
			echo _REG_COMPLETE_ACTIVATE;
		} else {
			echo _REG_COMPLETE;
		}
	}
}
**/

//function saveRegistration( $option ) {
//	global $database, $my, $acl;
//	global $mosConfig_sitename, $mosConfig_live_site, $mosConfig_useractivation, $mosConfig_allowUserRegistration;
//	global $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_mailfrom, $mosConfig_fromname;
//
//	if ($mosConfig_allowUserRegistration=="0") {
//		mosNotAuth();
//		return;
//	}
//
//	$row = new mosUser( $database );
//
//	if (!$row->bind( $_POST, "usertype" )) {
//		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
//		exit();
//	}
//
//	mosMakeHtmlSafe($row);
//
//	$row->id = 0;
//	$row->usertype = '';
//	$row->gid = $acl->get_group_id('Registered','ARO');
//	$row->block = "1"; // Force blocked.
//
//	$cfg = new Config_General( $database );
//	$cfg->load(1);
//
//	if (!$row->check()) {
//		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
//		exit();
//	}
//
//	$pwd = $row->password;
//	$row->password = md5( $row->password );
//	$row->registerDate = date("Y-m-d H:i:s");
//
//	if (!$row->store()) {
//		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
//		exit();
//	}
//	$row->checkin();
//	$name = $row->name;
//	$username = $row->username;
//	$userid = $row->id;
//	$registerDate = $row->registerDate; // For use on expiration date
//
//	// Update Subscription table
//	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
//	$database->setQuery( $query );
//	$id = $database->loadResult();
//	$db = new mosSubscription($database);
//	// Test if new
//	if(!$id) {
//		$db->load(0);
//	} else {
//		$db->load($id);
//	}
//	$db->userid		= $userid;
//	$db->status		= 'Pending';
//	$db->signup_date	= date( 'Y-m-d H:i:s' );
//	$db->check();
//	$db->store();
//
//	// Unblock user
//	//$query= "UPDATE #__users SET block='0', activation='' WHERE id='$userid'";
//    //$database->setQuery( $query );
//	//$database->query();
//
//	selectSubscriptionPlan($option, $userid, $username, $name);
//
//}

function activateFT( $option ) {
	global $database, $mosConfig_offset_user;
	$planid			= trim( mosGetParam( $_REQUEST, 'planid', '' ) );
	$userid			= trim( mosGetParam( $_REQUEST, 'userid', '' ) );
	$method			= trim( mosGetParam( $_REQUEST, 'method', '' ) );
	$currency_code	= trim( mosGetParam( $_REQUEST, 'currency_code', '' ) );
	if ($planid > 0) {
		$PROCESSOR_PAYPAL			= 1;
		$PROCESSOR_VKLIX			= 2;
		$PROCESSOR_AUTHORIZE		= 3;
		$signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	 	// get the paypal payment plans
		$objplan = new SubscriptionPlan( $database );
		$objplan->load( $planid );
		switch($method) {
			case $PROCESSOR_PAYPAL:
				userPayPalProcess( $userid, $signup_date, $objplan, $objplan->amount1, $currency_code, '0' );
				break;
			default:
				userGatewayProcess( $userid, $objplan, $method );
				break;
		}
		HTML_Results::thanks( 'com_acctexp' );
	}
}

function activate( $option ) {
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

function is_email($email){
	$rBool=false;

	if(preg_match("/[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}/", $email)){
		$rBool=true;
	}
	return $rBool;
}

function selectSubscriptionPlan( $option, $userid, $username, $name ) {
	global $database, $mosConfig_live_site;

	// Get information if Manual Transfer payment option is available
	$cfg = new Config_General( $database );
	$cfg->load(1);

	$hasTransfer	= $cfg->transfer;
	$transferinfo	= $cfg->transferinfo;

 	// get the subscription payment plans
	// Get user subscription plan
	$plan_info = null;
	$query = "SELECT a.plan, a.extra01, a.status, b.period1 FROM #__acctexp_subscr as a "
	. "\nINNER JOIN #__acctexp_plans as b ON a.plan=b.id"
	. "\nWHERE a.userid=$userid";
	$database->setQuery( $query );
	$database->loadObject($plan_info);

	if($plan_info->period1 > 0) {
	 	// If user is using a trial period plan he cannot choose a different plan now
	 	// otherwise he could keep jumping from plan to plan using trial periods.
	 	// Only his original plan will be available for him
	 	$database->setQuery("SELECT * FROM #__acctexp_plans"
	 	. "\nWHERE id=" . $plan_info->plan . " AND active=1"
	 	);
	 	$rows = $database->loadObjectList();
	 	if ($database->getErrorNum()) {
	 		echo $database->stderr();
	 		return false;
	 	}
	 	if(count( $rows ) == 0) { // UNLESS his original plan is now unpublished
	 		// All plans without trial periods will be available for him
		 	$database->setQuery("SELECT * FROM #__acctexp_plans"
		 	. "\nWHERE active=1 AND (period1<0 OR period1 is NULL) ORDER BY ordering"
		 	);
		 	$rows = $database->loadObjectList();
		 	if ($database->getErrorNum()) {
		 		echo $database->stderr();
		 		return false;
		 	}
		 	if(count( $rows ) == 0) { // If there is no published plan without trial AND original plan is unpublished
		 		// No way man, all plans will be available for him
			 	$database->setQuery("SELECT * FROM #__acctexp_plans"
			 	. "\nWHERE active=1 ORDER BY ordering"
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
	 	$database->setQuery("SELECT * FROM #__acctexp_plans"
	 	. "\nWHERE active=1 ORDER BY ordering"
	 	);
	 	$rows = $database->loadObjectList();
	 	if ($database->getErrorNum()) {
	 		echo $database->stderr();
	 		return false;
	 	}
	}

	$proc_plan = new ProcessorByPlan( $database );
	for ($i=0, $n=count( $rows ); $i < $n; $i++) {
		$row = &$rows[$i];
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
			if(((strcmp($plan_info->status, 'Trial') == 0) || (strcmp($plan_info->status, 'Active') == 0) || (strcmp($plan_info->status, 'Closed') == 0) ) && ($plan_info->extra01 == 0) && ($row->period1 > 0)) {
				$gw->recurring = 0;
			} else {
				$gw->recurring = $configOptions->recurring;
			}
		}
	}
	Payment_HTML::selectSubscriptionPlanForm( $option, $rows, $hasTransfer, $gw_available, $userid, $username, $name );

}

function subscriptionDetails( $option ) {
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
	// So he doesnt need to be bother with Renew buttons
 	$database->setQuery("SELECT extra01"
 	. "\nFROM #__acctexp_subscr"
 	. "\nWHERE userid='$my->id'"
 	);
 	$recurring = $database->loadResult();

 	// get payments from user
 	$database->setQuery("SELECT transaction_date, method as type, amount "
 	. "\nFROM #__acctexp_invoices"
 	. "\nWHERE userid='$my->id' ORDER BY transaction_date"
 	);
 	$rows = $database->loadObjectList();
 	if ($database->getErrorNum()) {
 		echo $database->stderr();
 		return false;
 	}

	$alertlevel		= 99;
	$subscription	= new mosSubscription($database);
	$alert		 	= $subscription->GetAlertLevel($my->id);

	HTML_frontEnd::subscriptionDetails( $option, $rows, $signup_date, $expiration, $recurring, $alert );
}

// Prepare PayPal variables to the confirm payment form
function paypalForm( $option, $planid, $userid, $username, $name, $recurring ) {
	global $database, $mosConfig_live_site, $mosConfig_offset_user;

	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;

	$cfg = new Config_PayPal( $database );
	$cfg->load(1);

	$var['testmode']	= $cfg->testmode;
	if ($cfg->testmode) {
		$post_url	= "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}
	else {
		$post_url	= "https://www.paypal.com/cgi-bin/webscr";
	}

	$var['currency_code']	= $cfg->currency_code;
	$var['business']		= $cfg->business;
	$var['item_name']		= "Subscription at " . $mosConfig_live_site . " - User: ". $name . " (" . $username . ")";
	$var['item_number']		= $userid;
	$var['return']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&itemnumber=' . $userid;
	$var['cancel']			= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel&itemnumber=' . $userid;
	$var['notify_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=ipn';

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		return;
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
	} else {
		$var['cmd']	= '_xclick';
		$var['bn']	= 'PP-BuyNowBF';

		if(strcmp($db->status, 'Pending') == 0) {
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
					$var['method']			= $PROCESSOR_PAYPAL;
					$var['currency_code']	= $cfg->currency_code;
					$post_url				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=activateFT';
				}
			}
		} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0)  || (strcmp($db->status, 'Trial') == 0)) {
			// This is a renew subscription without recurring payments
			// so we need to use amount3
			$var['amount']	= $objplan->amount3;
			$amount = $objplan->amount3;
		}
	}
	$var['no_shipping']	= "1";
	$var['no_note']	= "1";

	$var['custom']	= $planid;
	$var['rm']	= "2";


	Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'PayPal', $amount, $cfg->currency_code );
}

// Prepare ViaKLIX variables to the confirm payment form
function vklixForm( $option, $planid, $userid, $username, $name, $recurring ) {
	global $database, $mosConfig_live_site;

	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;

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

	$var['currency_code']	= $cfg->currency_code;
	$var['ssl_merchant_id']	= $cfg->accountid;
	$var['ssl_user_id']		= $cfg->userid;
	$var['ssl_pin']			= $cfg->pin;
	$var['ssl_invoice_number']	= $userid;
	$var['ssl_customer_code']	= $userid;
	$var['ssl_salestax']	= "0";
	$var['ssl_description']		= $name . '_-_' . $planid . '_-_' . $username;
	$var['ssl_result_format']	= "HTML";
	$var['ssl_receipt_link_method']	= "POST";
	$var['ssl_receipt_link_url']	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=vklixnotification';
	$var['ssl_receipt_link_text']	= "Continue";

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		return;
	}

 	// get the viaklix payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if(strcmp($db->status, 'Pending') == 0) {
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
				$var['planid']			= $planid;
				$var['userid']			= $userid;
				$var['method']			= $PROCESSOR_VKLIX;
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

	Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'ViaKLIX', $amount, $cfg->currency_code );
}

function authorizeForm( $option, $planid, $userid, $username, $name, $recurring ) {
	global $database, $mosConfig_live_site;

	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;

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


	//$var['currency_code']		= $cfg->currency_code;

	$var['x_login']					= $cfg->login;
	$var['x_invoice_num']			= $userid;
	$var['x_description']			= $name . '_-_' . $planid . '_-_' . $username;
	$var['x_receipt_link_method']	= "POST";
	//$var['x_receipt_link_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&itemnumber=' . $userid;
	$var['x_receipt_link_url']		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=authnotification';
	$var['x_receipt_link_text']		= "Continue";
	$var['x_show_form']				= "PAYMENT_FORM";
	//$var['x_relay_response']		= "True";
	//$var['x_relay_url']				= $mosConfig_live_site . '/index.php?option=com_acctexp&task=authnotification';

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		return;
	}

 	// get the viaklix payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if(strcmp($db->status, 'Pending') == 0) {
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
				$var['planid']			= $planid;
				$var['userid']			= $userid;
				$var['method']			= $PROCESSOR_AUTHORIZE;
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

	Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'Authorize', $amount, $cfg->currency_code );
}

function transferForm( $option, $planid, $userid, $username, $name, $recurring ) {
	global $database, $mosConfig_live_site;

	// Get information if Manual Transfer payment option is available
	$cfg = new Config_General( $database );
	$cfg->load(1);

	$hasTransfer	= $cfg->transfer;
	$transferinfo	= $cfg->transferinfo;

	$post_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks';

	// Get Subscription record
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$userid";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	if($id) {
		$db->load($id);
	} else {
		return;
	}

	$var['nothing']					= 'nothing'; // Just to avoid error on confirmForm HTML

 	// get the payment plans
	$objplan = new SubscriptionPlan( $database );
	$objplan->load( $planid );

	if(strcmp($db->status, 'Pending') == 0) {
		if ( $objplan->period1 <= 0 ) {
			// This is a fresh subscription
			// and we DO NOT have trial period, so we need to use amount3
			$amount = $objplan->amount3;
		} else {
			// This is a fresh subscription
			// and we have trial period, so we need to use amount1
			$amount = $objplan->amount1;
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// This is a renew subscription
		// so we need to use amount3
		$amount = $objplan->amount3;
	}

 	$database->setQuery( "UPDATE #__acctexp_subscr SET plan='$planid' WHERE userid=$userid" );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	Payment_HTML::confirmForm( $option, $userid, $post_url, $var, $objplan, 'transfer', $amount, $cfg->currency_code, $transferinfo );
}

function processIPN( $option ) {
	global $database, $mosConfig_absolute_path;
	// read the post from PayPal system and add 'cmd'
	$cfg = new Config_PayPal( $database );
	$cfg->load(1);

	$mybuzz = $cfg->business;
	$testmode = $cfg->testmode;
	$req = 'cmd=_notify-validate';

	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
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
	$custom				= trim($_POST['custom']);
	if (!$fp) {
		// HTTP ERROR
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				// check the payment_status is Completed
				// check that payment_amount/payment_currency are correct
				// process payment
				// Process IPN after the connection to the Paypal secured server
				// Depending of the status (INVALID or VERIFIED or false)
				// check that receiver_email is your Primary PayPal email
				// Process IPN as soon as it is received from Paypal server
				$db = new mosPayPalHistory( $database );
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

				$plan = new SubscriptionPlan( $database );
				$plan->load($custom);
				if (strcmp($receiver_email, $mybuzz) != 0) {
					// The receiver has been changed, possibly a fraud attempt
				} else {
					// Process payment
					// Paypal Subscription
					if(strcmp($txn_type, 'subscr_payment') == 0 && strcmp($payment_status, 'Completed') == 0 ) {
						userPayPalProcess( $item_number, $payment_date, $plan, $mc_gross, $mc_currency, '1' );
					// Paypal Buy Now
					} elseif (strcmp($txn_type, 'web_accept') == 0) {
						userPayPalProcess( $item_number, $payment_date, $plan, $mc_gross, $mc_currency, '0' );
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
			} else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
		}
		fclose ($fp);
	}
}


function processVKLIXNotification( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;

	// read the post from ViaKLIX
	$cfg = new Config_VKlix( $database );
	$cfg->load(1);

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



	$db = new VklixHistory( $database );
	$db->ssl_txn_id				= $ssl_txn_id;
	$db->ssl_invoice_number		= $ssl_invoice_number;
	$db->ssl_transaction_type	= $ssl_transaction_type;
	$db->transaction_date		= gmstrftime ("%Y-%m-%d", time()+$mosConfig_offset_user*3600);
	$db->ssl_amount				= $ssl_amount;
	$db->ssl_result				= $ssl_result;
	$db->ssl_result_message		= $ssl_result_message;
	$db->ssl_approval_code		= $ssl_approval_code;
	$db->ssl_email				= $ssl_email;
	$db->ssl_cvv2_response		= $ssl_cvv2_response;
	$db->ssl_avs_response		= $ssl_avs_response;
	$db->merchant_id			= $merchant_id;
	$db->user_id				= $user_id;		// This is the user id of ViaKlix configuration, not Joomla/Mambo user registering.

	$otherinfo					= array();
	$otherinfo					= explode( '_-_', $ssl_description); // Broke description to get elements
	$username					= $otherinfo[0];
	$planid						= $otherinfo[1];
	$name						= $otherinfo[2];

	$db->buyerusername			= $username;
	$db->buyername				= $name;
	$db->store();

	if ( ( $ssl_result == 0 ) && ( strcmp ( $ssl_result_message, "APPROVED") == 0 )) {
		// check the result of the operation
		// There is no custom field
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		// Process payment
		// ViaKLIX Subscription
		userGatewayProcess( $ssl_invoice_number, $plan, $PROCESSOR_VKLIX );
		HTML_Results::thanks( 'com_acctexp' );
	} elseif ($ssl_result > 0) {
		// log for manual investigation
	}
}

function processAuthorizeNotification( $option ) {
	global $database, $mosConfig_absolute_path, $mosConfig_offset_user;

	$PROCESSOR_PAYPAL			= 1;
	$PROCESSOR_VKLIX			= 2;
	$PROCESSOR_AUTHORIZE		= 3;

	// read the post from Authorize.net
	$cfg = new Config_Authorize( $database );
	$cfg->load(1);

	$login				= $cfg->login;
	$transaction_key	= $cfg->transaction_key;

	// Create history entry
	$db = new AuthorizeHistory( $database );
	$db->load(0);
	if (!$db->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$db->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	// Process Payment as soon as it is received from Authorize server
	$x_description			= $_POST['x_description'];
	$x_response_code		= $_POST['x_response_code'];
	$x_response_reason_text	= $_POST['x_response_reason_text'];
	$x_invoice_num			= $_POST['x_invoice_num'];
	$x_amount				= $_POST['x_amount'];

	$otherinfo				= explode( '_-_', $x_description); // Broke description to get elements
	$username				= $otherinfo[0];
	$planid					= $otherinfo[1];
	$name					= $otherinfo[2];

	if($x_response_code == '1') {  // Transaction approved
		// check the result of the operation
		// There is no custom field
		$plan = new SubscriptionPlan( $database );
		$plan->load($planid);
		// Process payment
		// Subscription
		userGatewayProcess( $x_invoice_num, $plan, $PROCESSOR_AUTHORIZE );
		HTML_Results::thanks( 'com_acctexp' );
	} else {
		// log for manual investigation
	}
}

function thanksPayPal( $option ) {
	HTML_Results::thanks( $option );
}

function cancelPayPal( $option ) {
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

function userPayPalProcess( $item_number, $payment_date, &$plan, $mc_gross, $mc_currency, $recurring ) {
	global $mainframe, $database, $mosConfig_useractivation, $mosConfig_offset_user;
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
	if(strcmp($db->status, 'Pending') == 0) {
		if ( $plan->period1 <= 0 ) {
			$amount = $plan->amount3;
			$value = $plan->period3;
			$perunit  = $plan->perunit3;
		} else {
			$amount = $plan->amount1;
			$value = $plan->period1;
			$perunit  = $plan->perunit1;
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		$amount = $plan->amount3;
		$value = $plan->period3;
		$perunit  = $plan->perunit3;
	} else {
		return;
	}

	// Create Invoice entry
	$transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	$database->setQuery( "INSERT INTO #__acctexp_invoices SET userid=$item_number, invoice_number=$item_number,"
			."\ntransaction_date='$transaction_date', method='PayPal', amount='$mc_gross', currency='$mc_currency'" );
	$database->query();

	//if (!(strcmp($amount, $mc_gross) == 0 && strcmp($plan->currency_code, $mc_currency) == 0)) {
	//	return;
	//}

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
		sendEmailRegistered( $item_number );
	} else {
		// Set expiration based on payment confirmed and payment plan
		// Be aware that payment date logged on paypal log is date at PayPal timezone
		// but the date we must use to calculate is local time respecting global configuration
		if((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Trial') == 0)) {
			// This is a renew subscription before actual expiration
			// So start date should be expiration date NOT today
			$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD(expiration, INTERVAL $value $unit) WHERE userid=$item_number" );
		} else {
			$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
		}
		$database->query();
	}
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
	$query = "UPDATE #__users SET gid = '$plan->gid' WHERE id = '$item_number'";
	$database->setQuery( $query );
	$database->query() or die( $database->stderr() );

} // end function

function userPayPalSignUp( $item_number, $subscr_date, &$plan, $amount1,  $period1, $mc_currency) {
	global $mainframe, $database, $mosConfig_offset_user, $mosConfig_useractivation;
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
				sendEmailRegistered( $item_number );
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
			$database->setQuery( "INSERT INTO #__acctexp_invoices SET userid=$item_number, invoice_number=$item_number,"
					."\ntransaction_date='$transaction_date', method='PayPal', amount='$amount1', currency='$mc_currency'" );
			$database->query();
		}

		$db->check();
		$db->store();
	}
} // end function

function userPayPalCancel( $item_number, $cancel_date ) {
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


function userPayPalEndOfTerm( $item_number ) {
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

function userGatewayProcess( $item_number, &$plan, $processor_id ) {
	global $mainframe, $database, $mosConfig_useractivation, $mosConfig_offset_user;

	// Get Processor Method
 	$database->setQuery("SELECT name"
 	. "\nFROM #__acctexp_processors"
 	. "\nWHERE id='$processor_id'"
 	);
 	$method = $database->loadResult();


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
	if(strcmp($db->status, 'Pending') == 0) {
		if ( $plan->period1 <= 0 ) {
			$amount = $plan->amount3;
			$value = $plan->period3;
			$perunit  = $plan->perunit3;
		} else {
			$amount = $plan->amount1;
			$value = $plan->period1;
			$perunit  = $plan->perunit1;
		}
	} elseif((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		$amount = $plan->amount3;
		$value = $plan->period3;
		$perunit  = $plan->perunit3;
	} else {
		return;
	}

	// Create Invoice entry
	$transaction_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
	$database->setQuery( "INSERT INTO #__acctexp_invoices SET userid=$item_number, invoice_number=$item_number,"
			."\ntransaction_date='$transaction_date', method='$method', amount='$amount', currency='USD'" );
	$database->query();

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
	if(!$mosConfig_useractivation) {
		// If user activation is disabled unblock the user
		$database->setQuery( "UPDATE #__users SET block='0', activation='' WHERE id='$item_number'" );
		if (!$database->query()) {
			echo "SQL error" . $database->stderr(true);
		}
	}
	//$startdate = strftime("%Y-%m-%d", strtotime($payment_date));

	// Set expiration date
	$startdate = gmstrftime ("%Y-%m-%d", time()+$mosConfig_offset_user*3600);
	if(strcmp($db->status, 'Pending') == 0) {
		// Set NEW expiration based on payment confirmed and payment plan
		// the date we must use to calculate is local time respecting global configuration
		$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration=DATE_ADD('$startdate', INTERVAL $value $unit)" );
		$database->query();
		// Send notification email telling user can login now. Runs only on first payment.
		sendEmailRegistered( $item_number );
	} else {
		// Set expiration based on payment confirmed and payment plan
		// the date we must use to calculate is local time respecting global configuration
		if((strcmp($db->status, 'Active') == 0) || (strcmp($db->status, 'Trial') == 0)){
			// This is a renew subscription before actual expiration
			// So start date should be expiration date NOT today
			$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD(expiration, INTERVAL $value $unit) WHERE userid=$item_number" );
		} else {
			// this should be a renew of a closed subscription
			$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
		}
		$database->query();
	}

	// Test if it was a pending subscription to set signup_date
	if(strcmp($db->status, 'Pending') == 0) {
		// Set subscription record for a new subscription
		$db->signup_date	= gmstrftime ("%Y-%m-%d %H:%M:%S", time()+$mosConfig_offset_user*3600);
		$db->type		= $method;		// Payment Processor name
		$db->plan		= $plan->id;
		if ( $plan->period1 <= 0 ) {
			// We don't have trial'
			$db->status		= 'Active';
		} else {
			// We have trial
			$db->status		= 'Trial';
		}
	} elseif((strcmp($db->status, 'Closed') == 0) || (strcmp($db->status, 'Trial') == 0) || (strcmp($db->status, 'Trial') == 0)) {
		// Renew subscription. DO NOT set signup_date
		$db->type		= $method;		// Payment Processor name
		$db->plan		= $plan->id;
		$db->status		= 'Active';
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
	$query = "UPDATE #__users SET gid = '$plan->gid' WHERE id = '$item_number'";
	$database->setQuery( $query );
	$database->query() or die( $database->stderr() );

} // end function

function sendEmailRegistered( $id ) {
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

		$subject = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
		$subject = html_entity_decode($subject, ENT_QUOTES);
//		if ($mosConfig_useractivation=="1" && !($hasPayPal || $hasTransfer)){
//			$message = sprintf (_ACCTEXP_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site."/index.php?option=com_acctexp&task=activate&activation=".$row->activation, $mosConfig_live_site, $username);
//		} else {
			$message = sprintf (_USEND_MSG, $name, $mosConfig_sitename, $mosConfig_live_site);
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
		$subject2 = sprintf (_SEND_SUB, $name, $mosConfig_sitename);
		$message2 = sprintf (_ASEND_MSG, $adminName2, $mosConfig_sitename, $row->name, $email, $username);
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

function hmac ($key, $data)
{
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

?>
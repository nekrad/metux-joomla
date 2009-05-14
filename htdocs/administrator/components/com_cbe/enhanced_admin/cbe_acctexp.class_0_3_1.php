<?php
/*************************************************************
* Mambo Community Builder L895-> double name warning
* Author MamboJoe
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

// this is a function container file loaded by cbe.php if acctexp integration
// is activated

//added for AccountExp integration lines 4225-4562 of cbe.php
function payForm( $option, $userid, $username, $name ) {
	global $database, $mosConfig_live_site;

	$cfg = new myConfig( $database );
	$cfg->load(1);
	
	$hasPayPal		= $cfg->paypal;
	$hasTransfer	= $cfg->transfer;
	$transferinfo	= $cfg->transferinfo;
	$testmode		= $cfg->testmode;

	$business	= $cfg->business;
	$item_name	= $name . " as " . $username . " - " . $mosConfig_live_site;
	$item_number= $userid;
	$return		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=thanks&itemnumber=' . $item_number;
	$cancel		= $mosConfig_live_site . '/index.php?option=com_acctexp&task=cancel&itemnumber=' . $item_number;
	$notify_url	= $mosConfig_live_site . '/index.php?option=com_acctexp&task=ipn';

 	// get the payment plans
 	$database->setQuery("SELECT * FROM #__acctexp_payplans"
 	. "\nWHERE active=1 ORDER BY ordering"
 	);
 	
 	$rows = $database->loadObjectList();
 	if ($database->getErrorNum()) {
 		echo $database->stderr();
 		return false;
 	}


	Payment_HTML::payForm( $option, $hasPayPal, $rows, $hasTransfer , $transferinfo, $business, $testmode, $item_name, $item_number, $return, $cancel, $notify_url );

}

function processIPN( $option ) {
	global $database, $mosConfig_absolute_path;
	// read the post from PayPal system and add 'cmd'
	$cfg = new myConfig( $database );
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

				$plan = new mosPayPlan( $database );
				$plan->load($custom);
				if (strcmp($receiver_email, $mybuzz) != 0) {
					// The receiver has been changed, possibly a fraud attempt
				} else {
					// Process payment
					if(strcmp($txn_type, 'subscr_payment') == 0 && strcmp($payment_status, 'Completed') == 0 && strcmp($plan->a3, $mc_gross) == 0) {
						userPayPalProcess( $item_number, $payment_date, $plan->p3, $plan->t3, $custom );
					} elseif (strcmp($txn_type, 'subscr_eot') == 0) {
						userPayPalEndOfTerm( $item_number );
					} elseif (strcmp($txn_type, 'subscr_signup') == 0) {
						userPayPalSignUp( $item_number, $custom );
					} elseif (strcmp($txn_type, 'subscr_cancel') == 0) {
						userPayPalCancel( $item_number );
					}
				}
			} else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
		}
		fclose ($fp);
	}
}

function thanksPayPal( $option ) {
	PayPal_HTML::thanks( $option );
}

function thanksTransfer( $option ) {
	global $database;
	$cfg = new myConfig( $database );
	$cfg->load(1);
	
	Transfer_HTML::transferInfo( $option, $cfg->transferinfo );
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
	PayPal_HTML::cancel( $option );
}

function userPayPalProcess( $item_number, $payment_date, $period, $perunit, $planid ) {
	global $mainframe, $database, $mosConfig_useractivation;
	$unit = "";
	$value = $period;
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
		$database->setQuery( "UPDATE #__cbe SET block='0', activation='' WHERE id='$item_number'" );
		if (!$database->query()) {
			echo "SQL error" . $database->stderr(true);
		}
	}
	$startdate = strftime("%Y-%m-%d", strtotime($payment_date));
	$query = "SELECT expiration FROM #__acctexp WHERE userid=$item_number";
	$expiration = null;
	$database->setQuery( $query );
	$expiration = $database->loadResult();
	if(!$expiration) {
		$database->setQuery( "INSERT INTO #__acctexp SET userid=$item_number, expiration=DATE_ADD('$startdate', INTERVAL $value $unit)" );
		$database->query();
	} else {
		$database->setQuery( "UPDATE #__acctexp SET expiration=DATE_ADD('$startdate', INTERVAL $value $unit) WHERE userid=$item_number" );
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
		$db->status		= 'Active';
		$db->plan		= $planid;
		$db->signup_date	= date( 'Y-m-d H:i:s' );
	} else {
		$db->load($id);
	}
	$db->lastpay_date	= date('Y-m-d H:i:s', strtotime($payment_date));
	$db->check();
	$db->store();

} // end function

function userPayPalSignUp( $item_number, $planid ) {
	global $mainframe, $database;
	// Update Subscription table
	$query = "SELECT id FROM #__acctexp_subscr WHERE userid=$item_number";
	$database->setQuery( $query );
	$id = $database->loadResult();
	$db = new mosSubscription($database);
	// Test if exists. Sometimes Signup came first, but I cannot create an entry here
	// because both payment and signup can come at same time so two entries are created for user
	if($id) {
		$db->load($id);
		$db->signup_date	= date( 'Y-m-d H:i:s' );
		$db->plan			= $planid;
		$db->check();
		$db->store();
	}
} // end function

function userPayPalCancel( $item_number ) {
	global $mainframe, $database;
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
	$db->cancel_date	= date( 'Y-m-d H:i:s' );
	$db->check();
	$db->store();
} // end function


function userPayPalEndOfTerm( $item_number ) {
	global $mainframe, $database;
	$database->setQuery( "UPDATE #__cbe SET block='1' WHERE id='$item_number'" );
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
	$db->eot_date	= date( 'Y-m-d H:i:s' );
	$query = "SELECT id, txn_type FROM #__acctexp_paylog WHERE item_number=$item_number AND (txn_type='subscr_failed' OR txn_type='subscr_cancel') ORDER BY id DESC LIMIT 1";
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
//end added for AccountExp integration

?>

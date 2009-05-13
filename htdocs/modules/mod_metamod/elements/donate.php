<?php
/**
* @version		1.5j
* @copyright		Copyright (C) 2007-2009 Stephen Brandon
* @license		GNU/GPL
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementDonate extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Donate';

	function fetchElement($name, $value, &$node, $control_name)
	{
		return '
		<a href="http://www.brandonitconsulting.co.uk/mod_metamod/donate.php" target="_blank"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_SM.gif" border="0" alt="Donate with PayPal" title="Donate with PayPal - support further development of MetaMod!" /></a>
			Make a donation &mdash; support further development of MetaMod!
		
		';

	}
}
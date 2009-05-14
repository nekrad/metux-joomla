<?php
/**
* Based on mod_quickicon.php from Joomla
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!defined( '_CBE_QUICKICON_MODULE' )) {
	/** ensure that functions are declared only once */
	define( '_CBE_QUICKICON_MODULE', 1 );

	// $securitycheck 	= intval( $params->get( 'securitycheck', 1 ) );

	?>
	<div id="cpanel">
		<?php
		$link = 'index2.php?option=com_cbe&task=showusers';
		echo cbe_quickiconButton( $link, 'user.png', 'User Manager' );

		$link = 'index2.php?option=com_cbe&task=showTab';
		echo cbe_quickiconButton( $link, 'categories.png', 'Tab Manager' );

		$link = 'index2.php?option=com_cbe&task=showField';
		echo cbe_quickiconButton( $link, 'addedit.png', 'Field Manager' );

		$link = 'index2.php?option=com_cbe&task=showLists';
		echo cbe_quickiconButton( $link, 'query.png', 'List Manager' );

		$link = 'index2.php?option=com_cbe&task=searchManage';
		echo cbe_quickiconButton( $link, 'searchtext.png', 'Search Manager' );

		$link = 'index2.php?option=com_cbe&task=badUserNames';
		echo cbe_quickiconButton( $link, 'person1_f2.png', 'Blocked Names Manager' );

		$link = 'index2.php?option=com_cbe&task=languageFilter';
		echo cbe_quickiconButton( $link, 'langmanager.png', 'Bad Words Filter' );

		$link = 'index2.php?option=com_cbe&task=showconfig';
		echo cbe_quickiconButton( $link, 'config.png', 'Config.' );

		$link = 'index2.php?option=com_cbe&task=enhancedConfig';
		echo cbe_quickiconButton( $link, 'systeminfo.png', 'Enhanced Config.' );

		$link = 'index2.php?option=com_cbe&task=showAdMods';
		echo cbe_quickiconButton( $link, 'module.png', 'Admin Modules' );

		$link = 'index2.php?option=com_cbe&task=cbeNewExtension';
		echo cbe_quickiconButton( $link, 'install.png', 'Extensions' );

		$link = 'index2.php?option=com_cbe&task=pluginConfig';
		echo cbe_quickiconButton( $link, 'config.png', 'Extensions Configuration' );

		$link = 'index2.php?option=com_cbe&task=tools';
		echo cbe_quickiconButton( $link, 'menu.png', 'Tools' );

		$link = 'index.php?option=com_cbe&task=cbeUpdate&format=raw';
		echo cbe_quickiconButton( $link, 'browser.png', 'Updates', 0,  "{handler: 'iframe', size: {x: 800, y: 500}}");

		?>
	</div>
	<div style="clear:both;"> </div>
	<?php
}
?>
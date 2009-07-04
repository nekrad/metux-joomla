<?php
/**
* @version $Id: fb_version.php 530 2007-12-23 15:35:27Z danialt $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Version information
 * @package Joomla
 */
class fireboardVersion {
	/** @var string Product */
	var $PRODUCT 	= 'FireBoard';
	/** @var int Main Release Level */
	var $RELEASE 	= '1.0';
	/** @var string Development Status */
	var $DEV_STATUS = 'Stable';
	/** @var int Sub Release Level */
	var $DEV_LEVEL 	= '4';
	/** @var int build Number */
	var $BUILD	 	= '$Revision: 530 $';
	/** @var string Codename */
	var $CODENAME 	= 'Teakwood';
	/** @var string Date */
	var $RELDATE 	= '23 December 2007';
	/** @var string Time */
	var $RELTIME 	= '01:00';
	/** @var string Timezone */
	var $RELTZ 		= 'UTC';
	/** @var string Copyright Text */
	var $COPYRIGHT 	= "Copyright (C) 2007-2008 Best of Joomla. All rights reserved.";
	/** @var string URL */
	var $URL 		= '<a href="http://www.bestofjoomla.com"  title="Visit Best of Joomla!" target="_blank">FireBoard Forum</a> is a Free Software released under the GNU/GPL License.';
	/** @var string Whether site is a production = 1 or demo site = 0: 1 is default */
	var $SITE 		= 1;
	/** @var string Whether site has restricted functionality mostly used for demo sites: 0 is default */
	var $RESTRICT	= 0;
	/** @var string Whether site is still in development phase (disables checks for /installation folder) - should be set to 0 for package release: 0 is default */
	var $SVN			= 0;


	/**
	 * @return string Long format version
	 */
	function getLongVersion() {
		return $this->PRODUCT .' '. $this->RELEASE .'.'. $this->DEV_LEVEL .' '
			. $this->DEV_STATUS
			.' [ '.$this->CODENAME .' ] '. $this->RELDATE .' '
			. $this->RELTIME .' '. $this->RELTZ;
	}

	/**
	 * @return string Short version format
	 */
	function getShortVersion() {
		return $this->RELEASE .'.'. $this->DEV_LEVEL;
	}

	/**
	 * @return string Version suffix for help files
	 */
	function getHelpVersion() {
		if ($this->RELEASE > '1.0') {
			return '.' . str_replace( '.', '', $this->RELEASE );
		} else {
			return '';
		}
	}
}
$_FB_VERSION = new fireboardVersion();

//ToDo: function
$fbversion = $_FB_VERSION->PRODUCT .' '. $_FB_VERSION->RELEASE .'.'. $_FB_VERSION->DEV_LEVEL .' '
. $_FB_VERSION->DEV_STATUS
.' [ '.$_FB_VERSION->CODENAME .' ] '. $_FB_VERSION->RELDATE .' '
. $_FB_VERSION->RELTIME .' '. $_FB_VERSION->RELTZ;
?>
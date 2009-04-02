<?php
/**
* @version $Id: playcode.php v.2.1b7 2007-10-31 02:17:46Z GMT-3 $
* @package ArtForms 2.1b7 - Alikon Mod Captcha
* @subpackage ArtForms Component
* @based on version 0.3.0.1 05/09/06 alikonweb capctha bot
* @copyright Copyright (C) 2005-2006 AlikonWeb
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

define( '_JEXEC', 1 );

require_once ('captcha.php');
require '../../../../../../administrator/components/com_artforms/config.artforms.php';

$captcha = new alikoncaptcha() ;
$captcha->codelength = $afcfg_captcha_length;

$mp3 = $captcha->mp3captcha() ;


?>

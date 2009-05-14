<?php
/* 
* @author eShiok.com
* Email : support@eshiok.com
* URL : http://www.eshiok.com
* Description : eShiok - iBook Social Network is: a new mixture of guestbook, comment system for your website & personal blog's article, social bookmarking or online bookmarking system (such as: del.icio.us, Digg, Reddit, Furl and so on) for you to build your own social network on the Internet and to improve popularity of your website, personal blog, CMS and even to integrate back to some of those popular social network through pre-generated HTML code snippet and widget which easily can be installed to your web site, personal blogs (Blogger, Wordpress, Live), social network (Facebook).

Since iBook Social Network's concept is with network building through referral (YOU and your network member), you can expect an exponential growth of N levels to be exptected from your own network or sub-network.
* 
* Generated By : YouCMSAndBlog IDE Joomla Module Plugin (http://vivociti.com)
* (please support YouCMSAndBlog by promoting it, dont remove above line. Thanks.)
* WE LOVE JOOMLA! 
***/

class getMyIBookTab extends cbTabHandler {
	function getMyIBookTab() {
		$this->cbTabHandler();
		}

  function getDisplayTab($tab,$user,$ui) {
	global $database,$mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang;
	
	$params = $this->params; // get parameters (plugin and related tab)
		
	//Use your website default CSS or pre-built in skins
	$skin = $params->get('skin'); 
	//Target, open a new window or default
	$target = $params->get('target'); 
	$iBookId = $params->get('iBookId', 'eshiok'); 
	$iBookTitle = $params->get('iBookTitle', 'My iBook : Build your own truly online network'); 

	
	$userIBookId = $user->cb_myibookid;	
	if (empty($userIBookId)) {
			$userIBookId = $iBookId;
	}
	$return = "<table class=\"contentpaneopen\"> \n";
	$return .= "		<tbody><tr><td class=\"contentheading\" width=\"100%\"> \n";
	$return .= "$iBookTitle</td></tr></tbody></table>	\n";
	$return .= "<script language=\"javascript\" type=\"text/javascript\" src=\"http://www.eshiok.com/components/com_ibook/myiBook.php?id=$userIBookId&target=_blank&width=170&skin=$skin\"> \n";
	$return .= "</script> \n"; 


	return $return;
	}
}

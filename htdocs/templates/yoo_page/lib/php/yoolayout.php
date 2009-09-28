<?php
/**
 * YOOLayout setup
 *
 * @author		yootheme.com
 * @copyright	Copyright (C) 2007 YOOtheme Ltd & Co. KG. All rights reserved.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$yootools = &YOOTools::getInstance();

// set css-class for topbox
$yootools->setStyle('top1 + top2 + top3 + top4 == 1', 'topboxwidth', 'width100');
$yootools->setStyle('top1 + top2 + top3 + top4 == 2', 'topboxwidth', 'width50');
$yootools->setStyle('top1 + top2 + top3 + top4 == 3', 'topboxwidth', 'width33');
$yootools->setStyle('top1 + top2 + top3 + top4 == 4', 'topboxwidth', 'width25');

// set css-class for maintopbox
$yootools->setStyle('user1 + user2 == 1', 'maintopboxwidth', 'width100');
$yootools->setStyle('user1 + user2 == 2', 'maintopboxwidth', 'width50');

// set css-class for contenttopbox
$yootools->setStyle('advert1 + advert2 == 1', 'contenttopboxwidth', 'width100');
$yootools->setStyle('advert1 + advert2 == 2', 'contenttopboxwidth', 'width50');

// set css-class for contentbottombox
$yootools->setStyle('advert3 + advert4 == 1', 'contentbottomboxwidth', 'width100');
$yootools->setStyle('advert3 + advert4 == 2', 'contentbottomboxwidth', 'width50');

// set css-class for mainbottombox
$yootools->setStyle('user3 + user4 == 1', 'mainbottomboxwidth', 'width100');
$yootools->setStyle('user3 + user4 == 2', 'mainbottomboxwidth', 'width50');

// set css-class for bottombox
$yootools->setStyle('bottom1 + bottom2 + bottom3 + bottom4 == 1', 'bottomboxwidth', 'width100');
$yootools->setStyle('bottom1 + bottom2 + bottom3 + bottom4 == 2', 'bottomboxwidth', 'width50');
$yootools->setStyle('bottom1 + bottom2 + bottom3 + bottom4 == 3', 'bottomboxwidth', 'width33');
$yootools->setStyle('bottom1 + bottom2 + bottom3 + bottom4 == 4', 'bottomboxwidth', 'width25');

// set css-class for topbox seperators
$yootools->setStyle('top1 && ( top2 || top3 || top4 )', 'topbox12seperator', 'seperator');
$yootools->setStyle('top2 && ( top3 || top4 )', 'topbox23seperator', 'seperator');
$yootools->setStyle('top3 && top4', 'topbox34seperator', 'seperator');

// set css-class for maintopbox seperators
$yootools->setStyle('user1 && user2', 'maintopbox12seperator', 'seperator');

// set css-class for mainbottombox seperators
$yootools->setStyle('user3 && user4', 'mainbottombox12seperator', 'seperator');

// set css-class for contenttopbox seperators
$yootools->setStyle('advert1 && advert2', 'contenttopbox12seperator', 'seperator');

// set css-class for contentbottombox seperators
$yootools->setStyle('advert3 && advert4', 'contentbottombox12seperator', 'seperator');

// set css-class for bottombox seperators
$yootools->setStyle('bottom1 && ( bottom2 || bottom3 || bottom4 )', 'bottombox12seperator', 'seperator');
$yootools->setStyle('bottom2 && ( bottom3 || bottom4 )', 'bottombox23seperator', 'seperator');
$yootools->setStyle('bottom3 && bottom4', 'bottombox34seperator', 'seperator');

// set css-class for layoutstyle
if ($this->countModules('left')) {
	if ($this->params->get('layout') == 'left') {
		$yootools->setStyle(true, 'leftcolumn', 'left');
	} else {
		$yootools->setStyle(true, 'leftcolumn', 'right');
	}
}

// set css-class for rightbackground
if ($this->countModules('right') && !class_exists('JEditor')) {
	$yootools->setStyle(true, 'rightcolumn', 'showright');
}

// set color
if ($yootools->getCurrentColor() != "default") {
	$yootools->setParam('color', $yootools->getCurrentColor());
}

// set itemcolor (depending on active item)
$itemcolor = "";
if ($itemnum = $yootools->getActiveMenuItemNumber('mainmenu', 0)) {
	$itemcolor = $this->params->get('item' . $itemnum . 'Color');
}

// set template url
$yootools->setParam('tplurl', $this->baseurl . '/templates/' . $this->template);

?>
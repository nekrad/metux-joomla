<?php

class Mamblog_URL
{
    var $component = 'com_mamblog';

    function Mamblog_URL()
    {
    }
    
    function addBlogEntry()
    {
	return sefRelToAbs('index.php?option='.$this->component.'&task=edit');
    }
}

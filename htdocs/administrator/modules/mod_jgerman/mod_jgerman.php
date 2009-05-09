<?php
/**
 * $Id: mod_jgerman.php 466 2009-03-27 21:52:38Z sisko1990 $
 * Author: Jan Erik Zassenhaus (Jan.Zassenhaus@jgerman.de)
 * BugFix: Uwe Walter (admin@joomlakom.de)
*/
defined( '_JEXEC' ) or die( 'Restricted access' );


class Check
{
  var $url;
  var $fsock;
  var $curl;

  function getAvailable()
  {
    $this->url = 'www.jgerman.de';

    // Check if server is available
    if (function_exists('fsockopen')) {
      $this->fsock = @fsockopen($this->url, 80, $errno, $errstr, 3);

      if (!$this->fsock) {
        return 'offline';
      } else {
        $get  = "GET / HTTP/1.1\r\n";
        $get .= "Host: ".$this->url."\r\n";
        $get .= "Connection: Close\r\n\r\n";
        @fwrite($this->fsock, $get);
        stream_set_timeout($this->fsock, 5);

        if (! @fgets($this->fsock, 16)) {
          return 'not responding';
        }	else {
          return 'online';
        }
      }
      @fclose($this->fsock);

    } elseif (function_exists('curl_init')) {
      $this->curl = @curl_init('http://'.$this->url);

      curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 3);
      curl_setopt($this->curl, CURLOPT_TIMEOUT, 5);
      curl_setopt($this->curl, CURLOPT_FAILONERROR, 1);
      curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

      curl_exec($this->curl);

      $errno = curl_errno($this->curl);

      if ($errno == 7) {
        return 'offline';
      } elseif ($errno > 7) {
        return 'not responding';
      } else {
        return 'online';
      }

      @curl_close($this->curl);
    } else {
      return 'impossible';
    }
  }

  function getVersion($section)
  {
    if ($section == 'frontend') {
      $client_nr = '0';
    } else {
      $client_nr = '1';
    }

    $client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', $client_nr, '', 'int'));

    // Load folder filesystem class
    jimport('joomla.filesystem.folder');
    $path = JLanguage::getLanguagePath($client->path);

    if (file_exists($path.DS.'de-DE'.DS.'de-DE.xml')) {
      $data = JApplicationHelper::parseXMLLangMetaFile($path.DS.'de-DE'.DS.'de-DE.xml');
      return $data['version'];
    } else {
      return 'missing';
    }
  }
}

switch(true) {
  case($params->get( 'imagesize' ) == 'big'):
    $imagesize = 'big';
    break;

  case($params->get( 'imagesize' ) == 'middle'):
    $imagesize = 'middle';
    break;

  case($params->get( 'imagesize' ) == 'small'):
    $imagesize = 'small';
    break;
}

require( dirname( __FILE__ ).DS.'tmpl'.DS.'default.php' );
?>
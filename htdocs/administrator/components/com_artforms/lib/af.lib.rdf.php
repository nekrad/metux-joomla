<?php
/**
* @version $Id: af.lib.rdf.php v.2.1b7 2007-11-26 16:44:59Z GMT-3 $
* @package ArtForms 2.1b7
* @subpackage ArtForms Component
* @original name code from RSS headline grabber
* @original author Yelvington and Changes by Bob Zoller (bob@kludgebox.com)
* @copyright Copyright (C) 2007 InterJoomla. All rights reserved.
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2, see LICENSE.txt
* This version may have been modified pursuant to the
* GNU General Public License, and as distributed it includes or is derivative
* of works licensed under the GNU General Public License or other free
* or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
*RSS/XML news feed headline grabber
*/
class afRDF {// A util Class for reading in RDF XML Headline style files...

   function createRDF($rdf, $agelimit = 30, $timeout = 10) {

      unlink(JPATH_SITE.DS.'cache'.DS.basename($rdf));

      $errno = '';
      $errstr = '';
      
      $cachefile = basename($rdf);
      
      // convert agelimit to seconds
      $agelimit *= 60;
      $timestamp = @filectime($cachefile);
      $age = time() - $timestamp;
      if($age > $agelimit) {
         $url = parse_url($rdf);
         $fp = fsockopen($url['host'], "80", $errno, $errstr, $timeout);
         if (!$fp) return;  //just quit on error
         else {
            $local = @fopen(JPATH_SITE.DS.'cache'.DS.$cachefile, 'w');
            if (!$local) return; //just quit on error
            fputs($fp, "GET " . $url['path'] . " HTTP/1.1\r\nHost: " . $url['host'] . "\r\n\r\n");
            //while(!feof($fp))
            fwrite($local, fgets($fp, 128));
            fclose($local);
         }
      }
      
    }

    // This function will read the data in from the passed in URL if it is required.
    function getRDF($url, $timeToLive) {

        $timeToLive *= 60; // convert timeToLive into secs
        $basename = str_replace('?', '&', JPATH_SITE.DS.'cache'.DS.basename($url)) ; // Get the basename of URL for the cached filename. We do this here, cos we need to do it more than once

        $this->createRDF($url);

        $timestamp = @filectime($basename); // Get the timestamp of the file.
        $age = (time() - $timestamp); // Work out how old the file is that we have already..

        // If the file is too old, then we need to refresh it from the URL
        if($age > $timeToLive) {
            $ip = gethostbyname(substr($url,strpos($url,'jartforms'),strpos($url,'.com.ar')-3));
            if (strcasecmp($ip, substr($url,strpos($url,'jartforms'),strpos($url,'.com.ar')-3)) == 0) {
                return false;
            }
            
            $rdfHandle = @fopen($url,"r"); // Open the RDF file for reading
            if(!$rdfHandle)return false;
            
            $rdfData = fread($rdfHandle, 64000) ; // Read in the RDF data. 64K limit on filesize, should be enough.
            fclose($rdfHandle); // Close the Data feed

            // OK there is more recent news, so rewrite the cached news file..
            $localFile = fopen($basename, "w") ; // Open the local file for writing
            fwrite($localFile, $rdfData ) ; // Pump in all the data into the file.
            fclose($localFile) ; // Close the local file after writing to it
        } // end IF
        return true;
    } // end getRDF

    // Removes spurious tags from the link that we don't want
    function formatLink($item) {
        $link = ereg_replace(".*<link>","",$item); // Remove the leading <link> tags
        $link = ereg_replace("</link>.*","",$link); // Remove the closing </link> tags
        $title = ereg_replace(".*<title>","",$item); // Remove the leading <title> tags
        $title = ereg_replace("</title>.*","",$title); // Remove the closing </title> tags

        if ($title) // If we got anything left after all that trimming...
                    // Choose how you want the link formatted here... This has no underline, and opens in a new window...
            echo "<a href=\"$link\" style=\"text-decoration:none\"
                target=\"_blank\">".htmlspecialchars($title, ENT_QUOTES)."</a><br />";
    } // end formatLink

    function displayRDF($rdffile, $randomise = TRUE, $numLinks = 3, $title) {

        $rdf = JPATH_SITE.DS.'cache'.DS.$rdffile;
        $localFile = fopen($rdf, "r");  // OK open up the local rdf file for reading
        clearstatcache() ;              // Clear out the file size cache
        if (filesize($rdf) <= 0) {
            return false;
        }
        $rdfData = fread($localFile, filesize($rdf)); // Read in the data to memory
        fclose($localFile);             // Close down the open file.

        // Get rid of all spurious leading and closing rdf data from the data in memory
        $rdfData = ereg_replace("<\?xml.*/image>","",$rdfData);
        $rdfData = ereg_replace("</rdf.*","",$rdfData);
        $rdfData = ereg_replace("[\r,\n]", "", $rdfData);
        $rdfData = chop($rdfData);  // Strip any whitespace from the end of the string

        $rdfArray = explode("</item>",$rdfData); // Split up the string into an array to make it more manageable
        $max = sizeof($rdfArray);               // See how many items we have got

        // Echo the font formatting... This is just HTML to make it look a little pretty
        if ($max > 1) {
//            echo "<p style=\"font-family: verdana, arial, helvetica;\">" ;

            // We need to do different stuff if we are to randomise the links...
            // The links will be randomised so we want a different message to the user....
            // The max -1 is to compensate for the 0 indexed array structure..
            if ($randomise) {
                echo "Displaying $numLinks (of " . ($max-1) . ") random headlines from $rdf... Updated every 30 minutes.. Refresh for some more!<br />";
                $links = array_rand( $rdfArray, $numLinks ); // OK select the keys of the links at random from the array..
                $upperLimit = $numLinks ; // Set this to the number of links to be displayed
            } else {
                if (!empty($title)) {
                    echo $title;
                }
                $links = array_keys($rdfArray) ; // Give the keys to be displayed all the links we have parsed..
                $upperLimit = $max ; // Set the upper Limit to be all of the headlines
            }

            // Display the links...
            for ($i = 0 ; $i < $upperLimit ; $i++ ) {
                $this->formatLink($rdfArray[$links[$i]]);
            }

            // Close the font formatting like a good html coder ;)

        }
        return true;
    }


    function parseRSS($url)
    {
                @require_once(JPATH_SITE.DS.'includes'.DS.'domit'.DS.'xml_domit_rss.php');
		$rssdoc =& new xml_domit_rss_document($url);

		$numChannels = $rssdoc->getChannelCount();

		for ($i = 0; $i < $numChannels; $i++) {
			$currChannel =& $rssdoc->getChannel($i);

			//iterate through item elements
			$numItems = $currChannel->getItemCount();

			echo '<ul>';
			for ($j = 0; $j < $numItems; $j++) {
				$currItem =& $currChannel->getItem($j);

				//echo item info
				echo "<li><a href=\"" . $currItem->getLink() . "\">".$currItem->getTitle() . "</a></li>\n\n";
			}
			echo '</ul>';
		}
	}


}

?>

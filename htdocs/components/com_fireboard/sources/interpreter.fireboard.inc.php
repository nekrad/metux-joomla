<?PHP
/**
* @version $Id: interpreter.fireboard.inc.php 496 2007-12-16 21:16:32Z fxstein $
* Fireboard Component
* @package Fireboard
* @Copyright (C) 2006 - 2007 Best Of Joomla All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.bestofjoomla.com
**/
############################################################################
# CATEGORY: Parser.TagParser                 DEVELOPMENT DATUM: 13.11.2007 #
# VERSION:  00.08.00                         LAST EDIT   DATUM: 12.12.2007 #
# FILENAME: interpreter.fireboard.inc.php                                  #
# AUTOR:    Miro Dietiker, MD Systems, All rights reserved                 #
# LICENSE:  http://www.gnu.org/copyleft/gpl.html GNU/GPL                   #
# CONTACT: m.dietiker@md-systems.ch        © 2007 Miro Dietiker 13.11.2007 #
############################################################################
# This parser is based on an earlier CMS parser implementation.
# It has been completely rewritten and generalized for FireBoard and
# was also heavily tested.
# However it should be: extensible, fast, ungreedy regarding resources
# stateful, enforcing strict output rules as defined
# Hope it works ;-)
############################################################################

# parser interpreter task -interaction
# check interfaces & description (strip in implementation, extend interface decl)
# test execution
# update all tags to fb standard
## quote
## username
## call missingtag replacement on close (IMG)
# list implement
# errors

# ERROR
# implement self-link parsing (on Encode)
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

include_once("interpreter.bbcode.inc.php");

class FireBoardBBCodeInterpreter extends BBCodeInterpreter {
    # these are samples... we used the parser to refer to files!
    # did here a local caching, but using also database lookups - removed
    function &NewTask() {
        # Builds new Task
        # RET
        # object: the task object
        # TAGPARSER_RET_ERR
        $task = new FireBoardBBCodeParserTask($this);
        return $task;
    }

function hyperlink($text) {
    // match protocol://address/path/file.extension?some=variable&another=asf%
    // allow hit \s also start and end!
    $text = ' '.$text.' ';
    $text = preg_replace("/\s"
     ."("
      ."[a-zA-Z]+:\/\/"
      ."[a-z][a-z0-9\_\.\-]*"
      ."[a-z]{2,6}"
      ."("
       ."\/[a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*"
      .")?"
     .")"
     ."([\s|\.|\,])/i",
     " <a href=\"$1\" target=\"_blank\">$1</a>$3", $text);
    // match www.something.domain/path/file.extension?some=variable&another=asf%
    $text = preg_replace("/\s"
     ."("
      ."www"
      ."\.[a-z][a-z0-9\_\.\-]*"
      ."[a-z]{2,6}"
      ."("
       ."\/[a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*"
      .")?"
     .")"
     ."([\s|\.|\,])/i",
     " <a href=\"http://$1\" target=\"_blank\">$1</a>$3", $text);
    // match name@address
    $text = preg_replace("/\s"
     ."("
      ."[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*"
      ."\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6}"
     .")"
     ."([\s|\.|\,])/i",
     " <a href=\"mailto://$1\">$1</a>$2", $text);
    return substr($text, 1, -1);
}
    function Encode(&$text_new, &$task, $text_old, $context) {
        # Encode strings for output
        # Regard interpreter mode if needed
        # context: 'text'
        # context: 'tagremove'
        # RET:
        # TAGPARSER_RET_NOTHING: No Escaping done
        # TAGPARSER_RET_REPLACED: Escaping done
        // special states are liable for encoding (Extended Tag hit)
        if($task->in_code) {
            // everything inside [code] is getting converted/encoded by tag delegation
            return TAGPARSER_RET_NOTHING;
        }
        if($task->in_noparse) {
            // noparse is also needed to get encoded
            $text_new = htmlspecialchars($text_old, ENT_QUOTES);
            return TAGPARSER_RET_REPLACED;
        }
        // generally
        $text_new = $text_old;
	// pasting " " allows regexp to apply on \s at end

        // HTMLize from plaintext
        $text_new = htmlspecialchars($text_new, ENT_QUOTES);
        if($context=='text'
         && ($task->autolink_disable==0)) {
          // Build links HTML2HTML
          $text_new = FireBoardBBCodeInterpreter::hyperlink($text_new);
          // Calculate smilies HTML2HTML
          $text_new = smile::smileParserCallback($text_new, $task->history, $task->emoticons, $task->iconList);
	  }
        return TAGPARSER_RET_REPLACED;
    }

    function TagStandard(&$tns, &$tne, &$task, $tag) {
        # Function replaces TAGs with corresponding
        if($task->in_code) {
            return TAGPARSER_RET_NOTHING;
        }
        if($task->in_noparse) {
            // hits deactivated by default
            switch(strtolower($tag->name)) {
                case 'noparse':
                    // specify noparse output - this only strips
                    $tns = ""; $tne = '';
                    #reenter regular replacements
                    $task->in_noparse = FALSE;
                    return TAGPARSER_RET_REPLACED;
                    break;
                default:
                    break;
            }
            // tagname code is not processed
            return TAGPARSER_RET_NOTHING;
        }
        switch (strtolower($tag->name)) {
            case 'b':
                $tns = "<b>"; $tne = '</b>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'i':
                $tns = "<i>"; $tne = '</i>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'u':
                $tns = "<u>"; $tne = '</u>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'size':
                if(!isset($tag->options['default'])
                || strlen($tag->options['default'])==0) {
                    return TAGPARSER_RET_NOTHING;
                }
                $tns = "<span style='font-size:".htmlspecialchars($tag->options['default'], ENT_QUOTES)."'>";
		$tne = '</span>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'ol':
                $tns = "<ol>"; $tne = '</ol>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'ul':
                $tns = "<ul>"; $tne = '</ul>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'li':
                $tns = "<li>"; $tne = '</li>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'color':
                if(!isset($tag->options['default'])
                || strlen($tag->options['default'])==0) {
                    return TAGPARSER_RET_NOTHING;
                }
                $tns = "<span style='color: ".htmlspecialchars($tag->options['default'], ENT_QUOTES)."'>"; $tne = '</span>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'highlight':
                $tns = "<span style='font-weight: 700;'>"; $tne = '</span>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'left':
                $tns = "<div style='align: left'>"; $tne = '</div>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'center':
                $tns = "<div style='align: center'>"; $tne = '</div>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'right':
                $tns = "<div style='align: right'>"; $tne = '</div>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'indent':
                $tns = "<blockquote>"; $tne = '</blockquote>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'email':
                $task->autolink_disable--;
                if(isset($tag->options['default'])) {
                    $tempstr = $tag->options['default'];
                    if(substr($tempstr, 0, 7)!=='mailto:') {
                      $tempstr = 'mailto:'.$tempstr;
                    }
                    $tns = "<a href='".htmlspecialchars($tempstr, ENT_QUOTES)."'>"; $tne = '</a>';
                    return TAGPARSER_RET_REPLACED;
                }
                break;
            case 'url':
                $task->autolink_disable--;
                // www. > http://www.
                if(isset($tag->options['default'])) {
                    $tempstr = $tag->options['default'];
                    if(substr($tempstr, 0, 4)=='www.') {
                      $tempstr = 'http://'.$tempstr;
                    }
                    $tns = "<a href='".htmlspecialchars($tempstr, ENT_QUOTES)."'>"; $tne = '</a>';
                    return TAGPARSER_RET_REPLACED;
                }
                break;
            case 'thread':
                $task->autolink_disable--;
                if(isset($tag->options['default'])) {
                    $tns = "<a href='/thebadlink:thread".htmlspecialchars($tag->options['default'], ENT_QUOTES)."'>"; $tne = '</a>';
                    return TAGPARSER_RET_REPLACED;
                }
                break;
            case 'post':
                $task->autolink_disable--;
                if(isset($tag->options['default'])) {
                    $tns = "<a href='/thebadlink:post".htmlspecialchars($tag->options['default'], ENT_QUOTES)."'>"; $tne = '</a>';
                    return TAGPARSER_RET_REPLACED;
                }
                break;
            case 'quote':
                # ERROR: check if ID submitted, provide link?
                $task->autolink_disable--;
                if(isset($tag->options['default'])) {
                    $tns = "<span class=\"fb_quote\">".htmlspecialchars($tag->options['default'], ENT_QUOTES).":<br />"; $tne = '</span>';
                    return TAGPARSER_RET_REPLACED;
                }
                break;
            default:
                break;
        }
        return TAGPARSER_RET_NOTHING;
    }

    function TagExtended(&$tag_new, &$task, $tag, $between) {
        # Function replaces TAGs with corresponding
        # Encode was already been called for between
        if($task->in_code) {
            switch(strtolower($tag->name)) {
                case 'code:1': // fb ancient compatibility
                case 'code':

                    $types = array ("php", "mysql", "html", "js", "javascript");

                    $code_start_html = '<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"><tr><td><b>'._FB_MSG_CODE.'</b></td></tr><tr><td><hr />';
                    if (in_array($tag->options["type"], $types)) {
                        $t_type = $tag->options["type"];
                    }
                    else {
                        $t_type = "php";
                    }

                    $code_start_html .= "<code class=\"{$t_type}\">";
                    $code_end_html = '</code><hr /></td></tr></table>';


                    $tag_new = $code_start_html. htmlspecialchars($between, ENT_QUOTES).$code_end_html;
                    #reenter regular replacements
                    $task->in_code = FALSE;
                    return TAGPARSER_RET_REPLACED;
                    break;

                default:
                    break;
            }
            return TAGPARSER_RET_NOTHING;
        }
        switch(strtolower($tag->name)) {
            # call htmlentities if Encode() did not already!!!
            # in general $between was already Encoded (if not explicitly suppressed!)
            case 'email':
                $tempstr = $between;
                if(substr($tempstr, 0, 7)=='mailto:') {
                  $between = substr($tempstr, 7);
                }
                else {
                  $tempstr = 'mailto:'.$tempstr;
                }
                $tag_new = "<a href='".$tempstr."'>".$between.'</a>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'url':
                $tempstr = $between;
                if(substr($tempstr, 0, 4)=='www.') {
                  $tempstr = 'http://'.$tempstr;
                }
                $tag_new = "<a href='".$tempstr."'>".$between.'</a>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'thread':
                // ERROR LINK
                $tag_new = "<a href='/thebadlink:thread".$between."'>".$between.'</a>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'post':
                // ERROR LINK
                $tag_new = "<a href='/thebadlink:post".$between."'>".$between.'</a>';
                return TAGPARSER_RET_REPLACED;
                break;

            case 'img':
                if($between) {
                    $task->autolink_disable--; # continue autolink conversion
                    $tag_new = "<img src='".$between."' />";
                    return TAGPARSER_RET_REPLACED;
                }
                return TAGPARSER_RET_NOTHING;
                break;
            case 'file':
                if($between) {
                    $task->autolink_disable--; # continue autolink conversion
                    $tag_new = "<div class=\"fb_file_attachment\"><span class=\"contentheading\">"._FB_FILEATTACH."</span><br>"._FB_FILENAME
                    ."<a href='".$between."' target=\"_blank\">".(($tag->options["name"])?htmlspecialchars($tag->options["name"]):$between)."</a><br>"._FB_FILESIZE.htmlspecialchars($tag->options["size"], ENT_QUOTES)."</div>";
                    return TAGPARSER_RET_REPLACED;
                }
                return TAGPARSER_RET_NOTHING;

                break;
            case 'quote':
                // ERROR LINK, USER PROPERTIES
                $tag_new = '<blockquote>QUOTE:<br />'.$between.'</blockquote>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'attach':
                // ERROR LINK
                $tag_new = "<a href='/thebadlink:attachment'>ATTACH: ".$between.'</a>';
                return TAGPARSER_RET_REPLACED;
                break;
            case 'list':
                $tag_new = '<ul>';
                $tag_new .= "\n";
                $linearr = explode('[*]', $between);
                for($i=0; $i<count($linearr); $i++) {
                    $tmp = trim($linearr[$i]);
                    if(strlen($tmp)) {
                        $tag_new .= '<li>'.trim($linearr[$i]).'</li>';
                        $tag_new .= "\n";
                    }
                }
                $tag_new .= '</ul>';
                $tag_new .= "\n";
                return TAGPARSER_RET_REPLACED;
                break;
            default:
                break;
        }
        return TAGPARSER_RET_NOTHING;
    }

    function TagSingle(&$tag_new, &$task, $tag) {

        # Function replaces TAGs with corresponding
        // trace states (for parsing & encoding)
        if($task->in_code) {
            return TAGPARSER_RET_NOTHING;
        }
        if($task->in_noparse) {
            return TAGPARSER_RET_NOTHING;
        }
        switch (strtolower($tag->name)) {
            case 'code:1': // fb ancient compatibility
            case 'code':
                $task->in_code = TRUE;
                return TAGPARSER_RET_NOTHING; # treat it as unprocessed (to push on stack)!
                break;
            case 'noparse':
                $task->in_noparse = TRUE;
                return TAGPARSER_RET_NOTHING; # treat it as unprocessed!
                break;
            case 'email':
            case 'url':
            case 'thread':
            case 'post':
            case 'quote':
            case 'img':
            case 'file':
                $task->autolink_disable++; # stop autolink conversion
                return TAGPARSER_RET_NOTHING;
                break;
            case 'br':
                $tag_new = "<br />";
                return TAGPARSER_RET_REPLACED; // nonrecursive
                // helper meta-replacement to get it rid from stack appearance
                // this is later on replaced again from TagExtended (if in [list])
            case '*':
                $tag_new = "[*]";
                return TAGPARSER_RET_REPLACED; // nonrecursive
                break;
            default:
                break;
        }
        return TAGPARSER_RET_NOTHING;
    }

    function TagSingleLate(&$tag_new, &$task, $tag) {
        # Function replaces TAGs with corresponding
        if($task->in_code) {
            return TAGPARSER_RET_NOTHING;
        }
        if($task->in_noparse) {
            return TAGPARSER_RET_NOTHING;
        }
        switch (strtolower($tag->name)) {
            // Replace unclosed img tag
            case 'img':
                $task->autolink_disable--; # continue autolink conversion
                // htmlspecialchars($tag->options['default'], ENT_QUOTES)
                if(isset($tag->options['default'])) { $tag->options['name'] = $tag->options['default']; }
                $tag_new = "<img class='c_img' BORDER='0' src='".htmlspecialchars($tag->options['default'], ENT_QUOTES)."'";
                if(isset($tag->options['width'])) {
                    $tag->options['width'] = (int)$tag->options['width'];
                    $tag_new .= " width='".$tag->options['width']."'";
                }
                if(isset($tag->options['height'])) {
                    $tag->options['height'] = (int)$tag->options['height'];
                    $tag_new .= " height='".$tag->options['height']."'";
                }
                if(isset($tag->options['left'])) {
                    $tag_new .= " align='left'";
                } else if(isset($tag->options['right'])) {
                    $tag_new .= " align='right'";
                }
                $tag_new .= ">";
                return TAGPARSER_RET_REPLACED;
                break;
            default:
                break;
        }
        return TAGPARSER_RET_NOTHING;
    }
}

class FireBoardBBCodeParserTask extends BBCodeParserTask {
    # stateful task for parser runs
    # inside link used for autolinkdetection outside
    var $autolink_disable = 0;
    // ERROR autolinking don't work after wrong nested elements..
    // reason is internal state is wrong after dropping tags (where start occured stateful)
    // so we should trace this too :-S
    //emoticon things!
    var $history = 0; // 1=grey
    var $emoticons = 1; // true if to be replaced
    var $iconList = array(); // smilies
}

class FireBoardBBCodeInterpreterPlain extends BBCodeInterpreter {
    # This class uses standardinterpreter, but removes all formatting outputs!
    # directly derivated from FireBoardBBCodeInterpreter after extensive testing

    function MyTagInterpreterSearch($references) {
        # Constructor
        MyTagInterpreter::MyTagInterpreter();

        # use params (references) to load your specific data, access to DB
    }

    function Encode(&$text_new, &$task, $text_old, $context) {
        return TAGPARSER_RET_NOTHING;
    }

    function TagStandard(&$tns, &$tne, &$task, $tag) {
        $tns = ''; $tne = '';
        return TAGPARSER_RET_NOTHING;
    }

    function TagExtended(&$tag_new, &$task, $tag, $between) {
        $tag_new = $between;
        return TAGPARSER_RET_NOTHING;
    }

    function TagSingle(&$tag_new, &$task, $tag) {
        $tag_new = '';
        return TAGPARSER_RET_NOTHING;
    }

    function TagSingleLate(&$tag_new, &$task, $tag) {
        $tag_new = '';
        return TAGPARSER_RET_NOTHING;
    }
}
?>

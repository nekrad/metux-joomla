<?php

require_once('mcloud-client.conf.php');
require_once('MC_RemoteClient.class.php');                                                                                

class mod_mcloud_player
{
    var $par;
    var $remoteclient;

    function mod_mcloud_player($p)
    {
	$this->params = $p;
	$this->remoteclient = new MC_RemoteClient(array
	(
	    'namespace' => MEDIACLOUD_SRV_NAMESPACE,
	    'prefix'    => MEDIACLOUD_SRV_PREFIX,
	    'secret'    => MEDIACLOUD_SRV_SECRET
	));
	$medium_id = $p->get('medium_id');

        $medium = $this->remoteclient->Medium_GetByIdForUser($medium_id, $my->username);
	$this->remoteclient->medium_log_view($medium_id, $my->username);
	
	print $this->render_medium($medium);
    }
    
    function render_medium($medium)
    {
	switch ($medium{'media_class'})
	{
	    case 'video':	return $this->render_medium_video($medium);
	    default:		return '<strong> Unhandled media type: '.$medium{'medium_class'}.'</strong>';
	}
    }
    
    function render_medium_video($medium)
    {
	$conv = $medium{'conversions'}{'flash'};
	$url   = $conv{'download_url'};
	$xsize = $conv{'attr_xsize'};
	$ysize = $conv{'attr_ysize'};

	global $mosConfig_live_site, $database, $mainframe, $mcloud_config;

	$mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_mcloud/js/swfobject.js"></script>');

	$flv_path = $medium{'conversions'}{'flash'}{'download_url'};
	$flv_x    = $medium{'conversions'}{'flash'}{'attr_xsize'};
	$flv_y    = $medium{'conversions'}{'flash'}{'attr_ysize'};
	@$flv_a    = $flv_x/$flv_y;

	(($player_width  = $this->params->get('player_height')) || ($player_height = 200));
	(($player_height = $this->params->get('player_width'))  || ($player_width  = 200));
	
	@$player_height = round($flv_y/$flv_x*$player_width);
	@$player_asp    = $player_width/$player_height;

	$player_url   = "http://mcloud.metux.de/flowplayer/current/FlowPlayerDark.swf?".rand();
//	$player_scale = "orig";
	$player_scale = "scale";

	return "
	    <div style=\"text-align: center\">
		<div id=\"flashcontent\"> Bitte Javascript aktivieren </div>
	<script type=\"text/javascript\">
	    var so = new SWFObject(
		'".$player_url."', 
		'video', 
		'".$player_width."', 
		'".$player_height."', 
		'8',
		'#171d25');
	    so.addVariable('width',		'".$player_width."');
	    so.addVariable('height',		'".$player_height."');
	    so.addParam('allowFullScreen',	'true');
	    so.addParam('play', 		'true');
	    so.addParam('quality', 		'high');
	    so.addParam('scale', 		'".$player_scale."');
	    so.addParam('wmode', 		'transparent');
	    so.addVariable('config', 		\"{videoFile: '".$flv_path."'".
		(($this->params->get('player_overstretch') == 1) ? ",initialScale: '".$player_scale."'" : "").",loop:'false'}\");
	    so.write('flashcontent');
	</script>
	</div>
";
    }
}

<?php

class MC_ClientHelper
{
    var $secret;

    function MC_ClientHelper($secret)
    {
	$this->secret = $secret;
    }

    function Upload_Request_Key($param)
    {
	if (!$param{'kickback_ok'})
	    throw new Exception("missing kickback_ok");
	if (!$param{'kickback_err'})
	    throw new Exception("missing kickback_err");
	if (!$param{'media_ns'})
	    throw new Exception("missing media_ns");
	if (!$param{'owner_ns'})
	    throw new Exception("missing owner_ns");
	if (!$param{'owner_name'})
	    throw new Exception("missing owner_name");

	$plaintext = 
	    $this->secret.'||'.
#	    $param{'kickback_ok'}.'||'.
#	    $param{'kickback_err'}.'||'.
	    $param{'media_ns'}.'||'.
	    $param{'owner_ns'}.'||'.
	    $param{'owner_name'};

	return sha1($plaintext);
    }

    function Media_Query_Key($param)
    {
	$plaintext = 
	    $this->secret.'||'.
	    $param{'media_ns'}.'||'.
	    $param{'owner_ns'}.'||'.
	    @$param{'owner_name'}.'||';

	return sha1($plaintext);
    }
    
    function Media_AddComment_Key($param)
    {
	$plaintext = 
	    $this->secret.'||'.
	    $param{'user_ns'}.'||'.
	    $param{'user_name'}.'||'.
	    $param{'content'}.'||'.
	    $param{'master'};    

	return sha1($plaintext);
    }

    function Create_Group_Key($param)
    {
	$plaintext = 
	    $this->secret.'||'.
	    $param{'user_ns'}.'||'.
	    $param{'user_name'}.'||'.
	    $param{'content'}.'||'.
	    $param{'master'};    

	return sha1($plaintext);
    }

    function Media_Remove_Key($param)
    {
	$plaintext = 
	    $this->secret.'||'.
	    $param{'media_ns'}.'||'.
	    $param{'id'}.'||';

	return sha1($plaintext);    
    }

    function Media_Update_Key($param)
    {
	$plaintext = 
	    $this->secret.'||'.
	    $param{'media_ns'}.'||'.
	    $param{'id'}.'||'.
	    $param{'tags'}.'||'.
	    $param{'title'}.'||'.
	    $param{'description'};

	return sha1($plaintext);
    }

    function Media_Download_Url($score)
    {
	return str_replace('{SCORE}', $score, MEDIACLOUD_DOWNLOAD_URL);
    }

    // detect media class on content type
    function detect_media_class($type)
    {
	if (preg_match('~^image/~', 		$type))	return 'image';
	if (preg_match('~^video/~', 		$type))	return 'video';
	if (preg_match('~^application/pdf$~', 	$type))	return 'text';
	if (preg_match('~^audio/~',		$type)) return 'audio';
    }

    var $mimetype_ext = array
    (
	'flv'	=> 'video/x-flv',
#	'mp4'	=> 'video/mp4',
	'mp4'	=> 'video/mpeg',
	'mpg'	=> 'video/mpeg',
	'avi'	=> 'video/avi',
	'mov'   => 'video/quicktime',
	'mp3'	=> 'audio/mp3',
	'ogg'	=> 'audio/ogg',
	'jpg'	=> 'image/jpeg',
	'jpeg'	=> 'image/jpeg',
	'pdf'	=> 'application/pdf',
	'3gp'	=> 'video/3gpp'
    );

    function detect_content_type($filename)
    {
	foreach ($this->mimetype_ext as $w => $c)
	{
	    $regex = '~\.'.$w.'$~';
	    if (preg_match('~\.'.$w.'$~', strtolower($filename)))
		return $c;
	}    
    }
    
    function Category_Query_Key($par)
    {
	$plaintext = 
	    $this->secret.'||'.
	    @$param{'namespace'}.'||Categories';

	return sha1($plaintext);    
    }

    function Group_Query_Key($par)
    {
	$plaintext = 
	    $this->secret.'||'.
	    @$param{'namespace'}.'||Groups';

	return sha1($plaintext);    
    }

    function rpc_token($ns,$secret,$command,$param)
    {
	if (!$ns)
	    throw new Exception("missing ns");
	if (!$secret)
	    throw new Exception("missing secret");
	if (!$command)
	    throw new Exception("missing command");
	if ((!$param)&&(!is_array($param)))
	    throw new Exception("missing param: ".serialize($param));

	$token = md5($ns."||".$secret."||".$command."||".serialize(asort($param)));
	return $token;
    }

    function rpc_call_encode($namespace, $secret, $command, $param)
    {
	$token = $this->rpc_token($namespace, $secret, $command, $param);
	$url = $this->prefix.
	    '/rpc.php?token='.urlencode($token).
	    '&namespace='.urlencode($namespace).
	    '&command='.urlencode($command).
	    '&param='.urlencode(json_encode($param));
	return $url;
    }

    function rpc_call_exec($namespace, $secret, $command, $param)
    {
	$url = $this->rpc_call_encode($namespace, $secret, $command, $param);
	$r = implode('',file($url));
	return json_decode($r,true);
    }
    
    function rpc_call_decode($req, $secret)
    {
	if (!$secret)
	    throw new Exception("missing secret");
	if (!($namespace = $req{'namespace'}))
	    throw new Exception("missing namespace");
	if (!($command = $req{'command'}))
	    throw new Exception("missing command");
	$param = json_decode(stripslashes($req{'param'}),true);
	if ((!$param) && (!is_array($param)))
	    throw new Exception("missing param: ".serialize($param).' --- '.$req{'param'});

	$token = $this->rpc_token($namespace, $secret, $command, $param);

	if ($token != $req{'token'})
	    throw new Exception("RPC call decode: token_error: $token != ".$req{'token'});

	return array
	(
	    'namespace'	=> $namespace,
	    'command'	=> $command,
	    'param'	=> $param
	);
    }
}

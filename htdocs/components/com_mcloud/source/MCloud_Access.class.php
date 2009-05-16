<?php

class MCloud_Access
{
	var $remote;
	var $current_user;

	public function MCloud_Access($r, $u)
	{
		$this->remote = $r;
		$this->current_user = $u;
	}

	/* are you administrator ? */
	public function is_admin()
	{
	    if (!$this->current_user)
		    return false;

	    switch ($this->current_user->usertype)
	    {
		    case 'Administrator':
		    case 'Super Administrator':
			    return true;
		    default:
			    return false;
	    }
	}
	
	public function permit_GroupEdit($group)
	{
		if ($this->is_admin())
			return true;
		
		if (($this->current_user->username == $group{'owner_name'}) &&
	    		($this->remote->namespace        == $group{'owner_ns'}))
			return true;
	    
		return false;
	}
	
	public function permit_MediumCommenting($medium)
	{
		return (isset($this->current_user) && isset($this->current_user->username));
	}

	public function permit_MediumRecommend($medium)
	{
		return (isset($this->current_user) && isset($this->current_user->username));
	}
}

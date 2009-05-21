<?php

class JExtUP_Box_blog extends JExtUP_Box
{
    function render()
    {
	return 
	    '<div class="extuserpage_aboutme">'.
	    $this->context->request_component('com_blog', array
	    (
		'blog_hide_header'      => 1,
		'blog_username'         => $this->userinfo{'user.name'}
	    )).
	    '</div>';
    }
}

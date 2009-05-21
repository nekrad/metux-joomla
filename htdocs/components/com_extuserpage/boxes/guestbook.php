<?php

class JExtUP_Box_guestbook extends JExtUP_Box
{
    function render()
    {
	return 
	    '<div class="extuserpage_guestbook">'.
	    $this->context->userinfo{'cb.cb_aboutme'}.
	    '</div>';
    }
}

<?php

class JExtUP_Box_aboutme extends JExtUP_Box
{
    function render()
    {
	return 
	    '<div class="extuserpage_aboutme">'.
	    $this->context->userinfo{'cb.cb_aboutme'}.
	    '</div>';
    }
}

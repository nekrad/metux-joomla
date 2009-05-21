<?php

class JExtUP_Box_titlepage extends JExtUP_Box
{
    function render()
    {
	return 
	    '<div class="extuserpage_titlepage">'.
	    $this->context->userinfo{'cb.cb_mytitlepage'}.
	    '</div>';
    }
}

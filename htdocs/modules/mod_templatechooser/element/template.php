<?php

class JElementTemplate extends JElement {

  var   $_name = 'Template';

  function fetchElement($name, $value, &$node, $control_name)
  {
    $template_path = "../templates";
    $templatefolder = @dir( $template_path );
    $darray = array();

    if ($templatefolder) {
        while ($templatefile = $templatefolder->read()) {
                if ($templatefile != "." && $templatefile != ".."&& $templatefile != "_system"&& $templatefile != "system" && $templatefile != ".svn" && $templatefile != "css" && is_dir( "$template_path/$templatefile" )  ) {
                     $templatename = $templatefile;
                     $darray[] = $templatename;
                }
        }
        $templatefolder->close();
    }

    sort( $darray );

    $option[0] = JHTML::_('select.option',0, "Hide");
    $option[1] = JHTML::_('select.option',1, "Show");


    $i=0;
    $radiolist= "<div width=\"100%\">";
    while (!empty($darray[$i])) {
      $radiolist .= "<div style=\"width:40%; text-align:right; float:left;\">";
      $radiolist .= $darray[$i];
      $radiolist .= "</div><div style=\"width:59%; text-align:left; float:left;\">";
      if ($this->_parent->get($darray[$i]) != "")
        $newvalue = $this->_parent->get($darray[$i]);
      else
        $newvalue = $value;
      $radiolist .= JHTML::_('select.radiolist',  $option, ''.$control_name.'['.$darray[$i].']', '', 'value', 'text', $newvalue, $control_name.$darray[$i] );
      $radiolist .="</div>";
      $i++;
    }
    $radiolist .= "</div>";
    return $radiolist;
  }
}
?>
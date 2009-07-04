<?php defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if ( $my->id ) { initEditor(); } ?>
<?php include($GLOBALS['mosConfig_absolute_path']."/templates/gmagzz/splitmenu.php"); ?>
<meta http-equiv="Content-Type" content="text/html;><?php echo _ISO; ?>" />
<?php mosShowHead(); ?>
<?php echo "<link rel=\"stylesheet\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/css/template_css.css\" type=\"text/css\"/>" ; ?><?php echo "<link rel=\"shortcut icon\" href=\"$GLOBALS[mosConfig_live_site]/images/favicon.ico\" />" ; ?>
</head>

<body class="all">
  <div align="center">
    <div id="container">
      <div id="wrapper">
	    <div id="wrapin">
        <div id="tophead"><table width="100%" border="0">
  <tr>
    <td align="left"><div id="headleft">
      
    </div></td>
    <td align="right"><div id="headright">
      <?php if (mosCountModules('user4')>0) mosLoadModules('user4',-2); ?>
</div></td>
  </tr>
</table>
</div>

        <div id="header"><img src="templates/gmagzz/images/header.png" align="top" /></div>

        <div id="topnavwrap"><table width="100%" border="0">
  <tr>
    <td><div id="topnav"><?php echo $mycssPSPLITmenu_content; ?>
      
</div></td>
  </tr>
</table>
</div>
<?php if(mosCountModules('newsflash') || mosCountModules('user1')|| mosCountModules('user2') ) { ?>
<div id="topmodule">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <?php if (mosCountModules( "top" )) { ?>
            <td width="" align="left"><div id="modleft">
                <?php if (mosCountModules('top')>0) mosLoadModules('top',-2); ?>
              </div></td>
            <?php } ?>
            <?php if (mosCountModules( "user1" )) { ?>
            <td width="280" align="left"><div id="modcent">
                <?php if (mosCountModules('user1')>0) mosLoadModules('user1',-2); ?>
              </div></td>
            <?php } ?>
            <?php if (mosCountModules( "user2" )) { ?>
            <td width="280" align="left"><div id="modright">
                <?php  mosLoadModules('user2',-2); ?>
              </div></td>
            <?php } ?>
          </tr>
        </table>
        <?php } ?>
      </div>
<div id="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  <?php if (mosCountModules( "left" )) { ?>
            <td width="180" align="left" valign="top"><div id="left">
                <?php  mosLoadModules('left',-2); ?>
              </div></td>
            <?php } ?>
            <td align="left" valign="top"><div id="maincontent">
			<table width="100%" border="0">
  <tr>
    <td><div id="pathway">
      <?php mosPathWay(); ?>
</div></td>
    <td><div id="date">
      <div align="right"><?php echo mosCurrentDate(); ?> </div>
    </div></td>
  </tr>
</table>
			    <div id="modtop"><table width="100%" border="0">
  <tr>
    <td><div id="modtop1">
      <?php if (mosCountModules('user1')>0) mosLoadModules('user1',-2); ?>
</div></td>
    <td><div id="modtop2">
      <?php if (mosCountModules('user2')>0) mosLoadModules('user2',-2); ?>
</div></td>
  </tr>
</table>
</div>
                <?php mosMainBody(); ?>
				<div id="advert1">
				  <?php if (mosCountModules('banner')>0) mosLoadModules('banner',-2); ?>
</div>

                <div id="modbot">
                  <table width="100%" border="0">
  <tr>
    <td><div id="modtop1">
      <?php if (mosCountModules('user5')>0) mosLoadModules('user5',-2); ?>
</div></td>
    <td><div id="modtop2">
      <?php if (mosCountModules('user6')>0) mosLoadModules('user6',-2); ?>
</div></td>
  </tr>
</table>
</div>
            </div></td>
            <?php if (mosCountModules( "right" )) { ?>
            <td width="200" align="left" valign="top"><div id="right">
                <?php if (mosCountModules('right')>0) mosLoadModules('right',-2); ?>
              </div></td>
            <?php } ?>
            
          </tr>
        </table>
      </div>
	 
	  
	  
      <div id="footer">
        <p>powered by <a href="http://www.joomla.org">joomla</a> | <a href="http://www.gizdoo.com">Joomla templates</a> by <a href="http://www.gizdoo.com">Gizdoo</a> </p>
      </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>

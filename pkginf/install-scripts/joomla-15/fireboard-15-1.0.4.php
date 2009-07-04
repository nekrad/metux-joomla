<?php

function joomla_component_install($context)
{
	$context->message("Installing fireboard schema");

        //change fb menu icon
        $context->dbo->setQuery("SELECT id FROM #__components WHERE admin_menu_link = 'option=com_fireboard'");
        if (!($id = $context->dbo->loadResult())
	{
		$context->message("Creating new component menu entry");
		$context->dbo->setQuery("INSERT INTO #__components 
		(name, link, `option`, admin_menu_link, admin_menu_img, admin_menu_alt, enabled) values ( 
		    'FireBoard Forum', 
		    'option=com_fireboard',
		    'com_fireboard',
		    'option=com_fireboard', 
		    '../administrator/components/com_fireboard/images/fbmenu.png',
		    'Fireboard Forum', 
		    1 );");
	}

        //add new admin menu images
        $context->dbo->setQuery("UPDATE #__components " . "SET admin_menu_img  = '../administrator/components/com_fireboard/images/fbmenu.png'" . ",   admin_menu_link = 'option=com_fireboard' " . "WHERE id='$id'");
        $context->dbo->query();

#        //backward compatibility . all the cats are by default moderated
#        $context->dbo->setQuery("UPDATE `#__fb_categories` SET `moderated` = '1';");
#        $context->dbo->query();
#
#        // now lets do some checks and upgrades to 1.0.2 version of attachment table
#        $context->dbo->setQuery("select from #__fb_attachments where filelocation like '%" . JPATH_SITE . "%'");
#
#        //if >0 then it means we are on fb version below 1.0.2
#        $is_101_version = $context->dbo->loadResult();
#	
#        if ($is_101_version) 
#	{
#        	// now do the upgrade
#        	$context->dbo->setQuery("update #__fb_attachments set filelocation = replace(filelocation,'".FIREBOARD_FRONTEND."/uploaded','/images/fbfiles');");
#        	if ($context->dbo->query()) 
#			$context->message("Attachment table successfully upgraded to 1.0.12+ version schema");
#		else
#			$context->warning("Attachment table was not successfully upgraded to 1.0.12+ version schema");
#    
#                $context->dbo->setQuery("update #__fb_messages_text set message = replace(message,'/components/com_fireboard/uploaded','/images/fbfiles');");
#        	if ($context->dbo->query()) 
#			$context->message("Attachments in messages table successfully upgraded to 1.0.12+ version schema");
#		else
#			$context->message("Attachments in messages table were not successfully upgraded to 1.0.12+ version schema");
#        }

	$context->message("Done");
}

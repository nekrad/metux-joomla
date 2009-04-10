<?php

jimport('joomla.factory');
jimport('joomla.base.object');
jimport('joomla.registry.registry');
jimport('joomla.error.error');
jimport('joomla.application.application');
jimport('joomla.filter.filterinput');
jimport('joomla.user.user');

class InstallContext
{
	var $pkg;
	var $dbo;
	var $htroot;
	var $component;

	function setPkg($pkg)
        {
		$this->pkg = $pkg;
	}

	function setComponent($n)
	{
		$this->component = $n;
	}

	function message($msg)
	{
		print "[".$this->pkg."] $msg\n";
	}

	function queryExec($query)
	{
		$this->message("Executing query: $query");
		$this->dbo->setQuery($query);
		$this->dbo->query();
	}

	function queryRecord($query)
	{
		$this->dbo->setQuery($query);
		return $this->dbo->loadResult();	
	}

	function queryObjectList($query)
	{
		$this->dbo->setQuery($query);
		return $this->dbo->loadObjectList();	
	}

	function addComponent($ident, $name, $icon)
	{
    		$this->dbo->setQuery("SELECT id FROM #__components WHERE admin_menu_link = 'option=".$ident."'");
    		if (!($id = $this->dbo->loadResult()))
		{
			$this->message("Creating new component menu entry: $ident / $name");
			$query = 
			"
			    INSERT INTO #__components 
				(name,     link,              `option`,   admin_menu_link,   admin_menu_img, admin_menu_alt, enabled) values (
			        '{$name}', 'option={$ident}', '{$ident}', 'option={$ident}', '{$icon}',      '{$name}',      1 );
			";
			$this->queryExec($query);
		}
		else
		{
    			//add new admin menu images
			$this->message("Updating component menu entry ($id): $ident / $name / $icon");
    			$this->queryExec(
			    "UPDATE #__components SET 
				admin_menu_img  = '{$icon}', 
				admin_menu_link = 'option={$ident}' WHERE id='{$id}'");
		}
	}

	function registerPlugin($element, $folder, $name)
	{
		if (($id = $this->queryRecord("SELECT id FROM #__plugins WHERE element = '{$element}' AND folder = '{$folder}'")))
			$this->message("Plugin $folder/$element already registered ($id)");
		else
		{
			$this->message("Registering plugin $folder/$element");
			$this->queryExec("INSERT INTO #__plugins ( element, folder, name ) values ( '{$element}', '{$folder}', '{$name}' );");
		}
	}
	
	function getFrontendComponentPathname($name)
	{
		return $this->htroot.'/components/'.$this->component.'/'.$name;
	}

	function getBackendComponentPathname($name)
	{
		return $this->htroot.'/components/'.$this->component.'/'.$name;	
	}
}

<?php
if(!defined("CONFIG_INCLUDED"))
	exit();

require_once("object.php");
require_once("sql.php");

class app extends Object
{
	function app()
	{
	}

	function isadmin()
	{
		global $keruser;

		if ($keruser->isadmin()) return true;

		return (getperm($keruser->uno,$this->admin) == 1);
	}

	function isActive()
	{
		return $this->active == 1;
	}
}

function &getAppByName($name = null)
{
	$tmp = new app();
	
	global $kerdb;

	if ($name == null)
	{
		$url = $_SERVER['REQUEST_URI'];	
		$tmpName = explode('/',strstr($url,'app/'));

		$name = $tmpName[1];

		if ($name == null)
			$name = 'system';
	}

	$sql = new sqlCompo(new sql('name',$name));
	$result = $kerdb->getvars('apps',$sql);

	$res = $kerdb->fetch_array($result);
	$tmp->setvars($res);
	$tmp->appdir = ROOT.'/app/'.$tmp->name;
	$tmp->webdir = SITE.'/app/'.$tmp->name;
	$tmp->template_dir = SITE.'/app/templates/'.$tmp->name;

	if ($tmp->name != 'system')
		pushsite($tmp->chi,$tmp->webdir);

	return $tmp;
}

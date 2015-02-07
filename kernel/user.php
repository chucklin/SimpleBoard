<?php
if(!defined("CONFIG_INCLUDED"))
	exit();

require_once("object.php");

class User extends Object
{
	function User()
	{
		$this->uno = 0;
	}

	function islogin()
	{
		return ($this->uno != 0);
	}

	function issuper()
	{
		if ($this->isadmin()) return true;
		return (getperm($this->uno,'_system') == 2);
	}

	function isadmin()
	{
		return (getperm($this->uno,'_system') == 1);
	}
}

function &getUser(&$sql)
{
	global $kerdb;
	
	$user = new User();
	if (is_a($sql,'sqlCompo') || is_a($sql,'array'))
	{
		$result = $kerdb->getvars('user',$sql);
		if ($kerdb->num_rows($result) == 1)
		{
			$res = $kerdb->fetch_array($result);
			$user->setvars($res);
		}
	}

	return $user;
}	

function &getUserByNo($uno = null)
{
	if ($uno == null)
		return new User();
	
	$sql = new sqlCompo(new sql('uno',$uno));
	return getUser($sql);
}

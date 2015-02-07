<?php
if(!defined("CONFIG_INCLUDED"))
	exit();

require_once("object.php");

class config extends Object
{
	function config()
	{
		global $kerdb;

		$vararray = array();

		$result = $kerdb->getvars('config');
		//$result = $kerdb->query("SELECT * FROM `config`");
		while($res = mysql_fetch_array($result)){
			$vararray[$res['key']] = $res['var'];
		}

		$this->setvars($vararray);
	}
}

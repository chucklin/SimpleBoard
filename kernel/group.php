<?php
if(!defined("CONFIG_INCLUDED"))
	exit();

require_once("object.php");

class Group extends Object
{
	function Group()
	{
	}
}

function getperm($uno, $gname)
{
	global $kerdb,$kergroup;

	if ($kergroup->vars[$gname][$uno]) return $kergroup->vars[$gname][$uno];
	
	$sql = new sqlCompo(new sql('g.name',$gname));
	$result = $kerdb->query("SELECT g.*,u.uno as uno, u.perm as perm FROM `group`g LEFT JOIN `gmember`u ON g.gno=u.gno WHERE ".$sql->render());
	while($res = $kerdb->fetch_array($result))
	{
		$kergroup->vars[$gname][$res['uno']] = $res['perm'];
		$kergroup->vars[$gname]['ident'] = $res['ident'];
	}

	return $kergroup->vars[$gname][$uno];
}

function getident($gname)
{
	global $kerdb,$kergroup;

	if ($kergroup->vars[$gname]['ident']) 
		return $kergroup->vars[$gname]['ident'];

	$result = $kerdb->getvars('group',array('name'=>$gname));
	while($res = $kerdb->fetch_array($result))
	{
		$kergroup->vars[$gname]['ident'] = $res['ident'];
	}

	return $kergroup->vars[$gname]['ident'];
}

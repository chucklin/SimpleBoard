<?php
if(!defined("CONFIG_INCLUDED"))
	exit();

class block extends Object
{
	var $tplobj;

	function block()
	{
		$this->tplobj = new template();
	}

	function fetch()
	{
		global $kertpl;
		
		$this->tplobj->settpldir($this->mname);
		$this->tpldir = ROOT."/app/templates/".$this->mname;
		$this->dir = ROOT."/app/".$this->mname;
		
		if (file_exists($this->dir."/block/".$this->php))
			require_once($this->dir."/block/".$this->php);
		if (file_exists($this->dir."/comm.php"))
			require_once($this->dir."/comm.php");
		if (file_exists($this->tpldir."/style.css"))
			$kertpl->addcss($this->tpldir."/style.css");

		$func = $this->func;
		if (function_exists($func)){
			$block = $func($this->dir);
			$block['dirname'] = str_replace(ROOT, SITE, $this->dir);	
			$this->tplobj->assign('block',$block);
			$fetched = $this->tplobj->fetch('block/'.$this->tpl);
			$this->tplobj->clear_assign('block');
		}

		return $fetched;
	}
}

function &getBlockByNo($bno)
{
	global $kerdb;
	$block = new block();

	$sql = new sqlCompo(new sql('bno',$bno));
	$query = "SELECT b.*, a.name AS mname FROM `block`b INNER JOIN `apps`a on b.ano=a.ano WHERE ".$sql->render();
	$result = $kerdb->query($query);
	$res = $kerdb->fetch_array($result);
	$block->setvars($res);

	return $block;
}
?>
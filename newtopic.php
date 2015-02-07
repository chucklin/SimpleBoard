<?php
require_once('./config.php');

if (!$keruser->islogin()) _redirect();

$title = _htmlencode(trim($_POST['title']));
$content = _htmlencode(trim($_POST['content']));

if (!empty($title) && !empty($content))
{
	$sql = new sqlCompo(new sql('title',$title));
	$sql->add(new sql('content',$content));
	$sql->add(new sql('poster',$keruser->uno));
	$sql->add(new sql('time',mktime()));	
	$kerdb->insertvars("topic", $sql);
	_redirect();
}
else
	$kertpl->display('newtopic.htm');
?>
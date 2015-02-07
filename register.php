<?php
require_once("./config.php");

$uid = _htmlencode($_POST["user"]);
$pass = _htmlencode($_POST["pass"]);
$pass2 = _htmlencode($_POST["pass2"]);
if ($pass == $pass2 && !empty($pass) && !empty($uid))
{
	$kerdb->insertvars("user", array("uid"=>$uid, "pwd"=>md5($pass)));
	$_SESSION['uno'] = $kerdb->insert_id();
	_redirect();
}
else
	_redirect();
?>
<?php
if ( !defined('CONFIG_INCLUDED'))
	exit();

$currsite = array(array('title'=>'中大愛月','url'=>SITE));

require_once ROOT.'/include/function.php';
require_once ROOT.'/kernel/group.php';
require_once ROOT.'/kernel/database.php';
require_once ROOT.'/kernel/sql.php';
$kerdb = new database();
$kerdb->connect(DB_HOST,DB_USER,DB_PWD);
$kerdb->select_db(DB_NAME);

require_once ROOT.'/kernel/config.php';
$kercfg = new config();
$kercfg->SITE = SITE;

require_once ROOT.'/kernel/app.php';
$kerApp =& getAppByName();

session_cache_expire($kercfg->session_expire);
session_name($kercfg->session_name);

session_start();

if ($_SESSION["remote_adr"] != $_SERVER["REMOTE_ADDR"])
	$_SESSION["uno"] = "";

$_SESSION["remote_adr"] = $_SERVER["REMOTE_ADDR"];

require_once ROOT.'/kernel/user.php';
$keruser =& getUserByNo($_SESSION['uno']);

require_once ROOT.'/kernel/tpl.php';
$kertpl = new tpl();
$kertpl->settpldir($kerApp->name);

require_once ROOT.'/include/comm.php';
require_once ROOT.'/kernel/block.php';

if ( file_exists($kerApp->appdir.'/comm.php'))
	require_once $kerApp->appdir.'/comm.php';
	
$_SESSION['oldkey'] = $_SESSION['key'];
$_SESSION['key'] = md5($kercfg->session_name.md5(mktime()));
?>

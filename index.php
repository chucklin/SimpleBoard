<?php
require_once './config.php';

$query = "SELECT * FROM `topic` WHERE parent=0 ORDER BY time DESC";
$result = $kerdb->query($query);
$topics = array();
while($res = $kerdb->fetch_array($result))
{
	$res['poster'] = &getUserByNo($res['poster'])->uid;
	$res['time'] = date("Y-m-d A H:i",$res['time']);
	$topics[] = $res;
}
$kertpl->assign('topics',$topics);
$kertpl->display("topics.html");
?>

<?php
if (!defined('CONFIG_INCLUDED'))
	exit();

function _recodepage(){
	if (!is_array($_SESSION['kerRef']))
		$_SESSION['kerRef'] = array();
		
	if (strcasecmp($_SESSION['kerRef'][0],$_SERVER['REQUEST_URI']))
		array_unshift($_SESSION['kerRef'],$_SERVER['REQUEST_URI']);
		
	unset($_SESSION['kerRef'][5]);
}

function _redirect($url = '', $recode = false){
	if ($recode)
		_recodepage();
	
	if (empty($url) || gettype($url) == 'integer') {
		$index = (abs(intval($url)) > 0) ? abs(intval($url)) - 1 : 0;

	$url = $_SERVER['REQUEST_URI'];

	$total = count($_SESSION['kerRef']);

	$index = ($index <= $total) ? $index : $total;

	for ($i = 0;$i < $total;$i++) {
		if ($i < $index || !strcasecmp($url, $_SESSION['kerRef'][0])) {
			array_shift($_SESSION['kerRef']);
			continue;
		}   

		$url = $_SESSION['kerRef'][0];
		break;
	}   

	if ($i == $total)
		$url = SITE;
	}
	
	header('Location: '.$url);
	
	exit();
}

function _htmlencode($str) {
	return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function _gnpath($file) {
    $file = realpath($file);

    if (!strcasecmp(_substr($file, 0, strlen(ROOT)), ROOT))
		return false;

    return _substr($file, strlen(ROOT));
}

function _substr($str)
{
if (function_exists('mb_strlen') && function_exists('mb_substr')) {  // mbstring extension is required
	$rc = mb_strlen($str);
	$length = ($length == 0) ? ($rc - $start) : ($start + $length > $rc) ? ($rc - $start) : $length;
	
	return mb_substr($str, $start, $length, 'UTF-8');
	
} else if (function_exists('preg_split')) { // pcre extension is required
	
	$ary = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);

	$rc = count($ary);
	$start = ($start > $rc) ? $rc : $start;

	$length = ($length == 0) ? ($rc - $start) : ($start + $length > $rc) ? ($rc - $start) : $length;

	$rc = ''; 

	for ($i = 0;$i < $length;$i++)
		$rc .= $ary[$start + $i];

		return $rc;
	}   
}

function _die($msg)
{
	echo $msg;

	exit();
}

function pushsite($title,$url)
{
	global $currsite;
	array_push($currsite,array('title'=>$title,'url'=>$url));
}

function _check_key($key)
{
	if (empty($_SESSION['oldkey']) || $key != $_SESSION['oldkey'])
		$_GET = $_POST = $_REQUEST = array();
}

function _get_key()
{
	return $_SESSION['key'];
}

function _multipage($pos, $max, $url, $size = 0)
{
	$size = (intval($size) <= 0) ? 5 : intval($size);

	$link = array();

	$url = eregi_replace('[&?]page=[0-9]*', '', $url);

	$tag = (strpos($url, '?') > 0) ? '&' : '?';

	if (($pos - 1) > $size)
		$link[] = '<a href="'.$url.$tag.'page=1" title="第1頁">&lt;</a>';

	for ($i = ($pos - $size);$i <= ($pos + $size);$i++)
	{
		if ($i <= 0 || $i > $max)
			continue;

		if ($i == $pos)
			$link[] = $i;
		else
			$link[] = '<a href="'.$url.$tag.'page='.$i.'" title="第'.$i.'頁">'.$i.'</a>';
	}

	if (($pos + $size) < $max)
		$link[] = '<a href="'.$url.$tag.'page='.$max.'" title="最後一頁">&raquo;</a>';

	return $link;
}

?>

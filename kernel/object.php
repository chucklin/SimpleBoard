<?php
if (!defined('CONFIG_INCLUDED'))
	exit();

class Object {
	var $vars = array();

	function setvars($vars) {
		foreach($vars as $k => $v)
			$this->vars[$k] = $v;
	}

	function __set($key, $value) {
		$this->vars[$key] = $value;
	}

	function __get($key) {
		return $this->vars[$key];
	}
}
?>

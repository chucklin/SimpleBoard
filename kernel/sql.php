<?php
if (!defined('CONFIG_INCLUDED'))
	exit();

class SqlCompo {
	var $SqlElement = array();

	function __construct(&$Sql = NULL) {
		//if (is_null($Sql)) _die('SqlCompo error :: $Sql is null');

		if (!is_null($Sql))
			$this->add($Sql);
	}

	function add(&$Sql, $condition = 'AND') {
		$this->SqlElement[] = $Sql;
		$this->SqlCondition[] = $condition;
	}

	function insertsql() {
		$rows = array();
		$values = array();

		foreach ($this->SqlElement as $Sql) {
			$rows[] = $Sql->name;
			$values[] = $Sql->value;
		}
		$ret = '('.implode(', ', $rows).') VALUES('.implode(', ', $values).')';
		return $ret;
	}

	function render() {
		return $this->wheresql();
	}

	function wheresql() {
		$count = count($this->SqlElement);
		$ret = $this->SqlElement[0]->render();
		for ($i = 1; $i < $count; ++$i) {
			$ret .= ' '.$this->SqlCondition[$i].' '.$this->SqlElement[$i];
		}
		return '('.$ret.')';
	}

	function updatesql() {
		$ret = 'SET '. implode(', ', $this->SqlElement);
		return $ret;	
	}
}

class Sql {
	var $name;
	var $value;
	var $oprator;

	function __construct($name = '', $value = '', $oprator = '=') {
		$kerdb = new database();

		$namex = explode('.', $name, 2);
		$name = '`'.implode('`.`', $namex).'`';

		if (is_array($value)) {
			foreach ($value as $k => $v) {
				//$value[$k] = addslashes(stripslashes($v));
				//$value = mysql_real_escape_string($value);
				$value[$k] = $kerdb->escape($v);
			}  
			$value = '(\''.implode('\', \'', $value).'\')';
			$oprator = ' IN ';
		} else {
			//$value = addslashes(stripslashes($value));
			//$value = mysql_real_escape_string($value);
			$value = $kerdb->escape($value);
			$value = '\''.$value.'\'';
		}

		$this->name = $name;
		$this->value = $value;
		$this->oprator = $oprator;
	}

	function render() {
		return $this->name.$this->oprator.$this->value;
	}

	function __tostring() {
		return $this->render();
	}
}
?>

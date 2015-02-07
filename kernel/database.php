<?php
if (!defined('CONFIG_INCLUDED')) 
	exit();


/**
* for datebase
*/
class database
{
	var $querys = array();
	var $link;
	function database()
	{
		
	}
	
	public function connect($host,$user,$pwd)
	{
		$this->link = @mysql_connect($host,$user,$pwd);
		@mysql_query("SET NAMES UTF8");
		return $this->link;
	}
	
	public function query($sql)
	{
		$this->querys[] = $sql;
		return @mysql_query($sql,$this->link);
	}
	
	public function insert_id()
	{
		return @mysql_insert_id($this->link);
	}
	
	public function select_db($db_name)
	{
		return @mysql_select_db($db_name,$this->link);
	}
	
	public function fetch_array($result)
	{
		return @mysql_fetch_array($result);
	}
	
	public function fetch_object($result)
	{
		return @mysql_fetch_object($result,$this->link);
	}
	
	public function num_rows($result)
	{
		return @mysql_num_rows($result);
	}
	
	public function escape($string = '')
	{
		return @mysql_real_escape_string($string);
	}
	
	public function affected_rows($result)
	{
		return @mysql_affected_rows($result,$this->link);
	}
	
	public function close()
	{
		if($this->link)
			return @mysql_close($this->link);
	}
	
	function __destruct() {
		return $this->close();
	}

	public function getvars($table, $sql = null){
		if( $sql == null)
			return $this->query("SELECT * FROM `".$table."`");

		require_once 'sql.php';

		if( !is_a($sql,"sqlCompo"))
		{
			$sqlcom = new sqlCompo();
			foreach( $sql AS $k=>$v){
				$sqlcom->add(new sql($k,$v));
			}
		}else
			$sqlcom = $sql;

		return $this->query("SELECT * FROM `".$table."` WHERE ".$sqlcom->render());
	}

	function insertvars($table, $sql){
		
		require_once 'sql.php';
		
		if( !is_a($sql,"sqlCompo"))
		{
			$sqlcom = new sqlCompo();
			foreach( $sql AS $k=>$v){
				$sqlcom->add(new sql($k,$v));
			}
		}else
			$sqlcom = $sql;

		$this->query("INSERT INTO `".$table."`".$sqlcom->insertsql());
	}

	function deletevars($table, $sql,$deleteall = false){
		if ($deleteall)
			$this->query("DELETE FROM `".$table."`");

		require_once 'sql.php';

		if (!is_a($sql,"sqlCompo"))
		{
		    $sqlcom = new sqlCompo();
	    	foreach( $sql AS $k=>$v){
				$sqlcom->add(new sql($k,$v));
			}
		}else
			$sqlcom = $sql;

		if ( !is_null($sqlcom->render()) )
			$this->query("DELETE FROM `".$table."` WHERE ".$sqlcom->render());
	}
}

?>

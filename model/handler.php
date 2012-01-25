<?php

require_once("config.php");
require_once("db/db.class.php");

abstract class Handler
{
	var $TABLENAME;

	var $sql;

	var $resource;

	var $db;

	function __construct($table, $condition = false)
	{
		$this->TABLENAME = $table;

		$where = $condition ? " WHERE $condition" : "";

		$this->sql = "SELECT * FROM $this->TABLENAME $where"; 

		$this->resource = false;

		$this->db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
	}

	function start()
	{
		if(!$this->resource)
		{
			
			$this->db->dbconnect();

			$this->resource = $this->db->query($this->sql);
		}
	}

	function next()
	{
		if($this->resource)
			return $this->db->into_array($this->resource);
	}

	function done()
	{
		$this->db->dbclose();
		$this->resource = false;
	}

	function clean()
	{
		$this->resource = false;
		$this->sql = false;
	}

	function count($key, $id)
	{
		if(!$this->resource)
		{
			$this->db->dbconnect();
			$sql = "SELECT COUNT($key) as count FROM $this->TABLENAME WHERE $key='$id'";
			$tmp = $this->db->query_into_array($sql);

			return $tmp["count"];
		}
		else
			return false;
	}


}

?>

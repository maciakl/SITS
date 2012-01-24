<?php

require_once("../db/db.class.php");
require_once("../config.php");
/**
 * Abstract class that will be inherited by all models. It provides the basic CRUD logic for
 * interacting with the DB using ADatabase module for running actual queries.
 *
 */
abstract class Model 
{
	/**
	 * The name of the table - supplied by the sublcass via super call 
	 * @var string
	 */
	var $TABLENAME;

	/**
	 * An ASSOC Array of attributes
	 * @var array
	 */
	var $data;

	/**
	 * Boolean flag to indicate the object contains data from db
	 * @var bool
	 */
	var $is_empty;

	/**
	 * Constructor
	 */
	function __construct($table)
	{
		$this->TABLENAME = $table;
		$this->is_empty = true;
	}

	// CRUD operations

	/**
	 * Creates a new row in the table based on $this->data
	 *
	 * @uses MYSQLDatabase database operations
	 */
	function create()
	{
		// check if the model has been populated with data
		if($this->is_empty) die("MODEL ERROR: Can't create on an empty model.");

		// built SQL (concatenation - yeah I know)
		// we're assuming validation and sanitization was done in the sublcass
		$sql = "INSERT INTO $this->TABLENAME (";
		$comma = "";
	
		foreach(array_keys($this->data) as $value)
		{
			$sql .= $comma."$value";
			$comma = ", ";
		}

		$sql .= ") VALUES (";
		$comma = "";

		foreach($this->data as $value)
		{
			if($value == null) 
				$val = 	"NULL";
			elseif($value == "NOW()")
				$val = "NOW()";
			else 
				$val = "'$value'";

			$sql .= $comma.$val;
			$comma = ", ";
		}

		$sql .= ")";

		//echo $sql;

		// run the actual query
		$db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
		$db->dbconnect();
		$db->query($sql);

		$created_record_id  = $db->last_insert_id();
		$db->dbclose();

		return $created_record_id;
	}

	/**
	 * Reads a single row from the database.
	 *
	 * The row is loaded into $this->data. If it's not found, $this->data becomes false instead
	 * 
	 * @param string $key The name of the primary key for this table (supplied by subclass)
	 * @param string $value The actual primary key
	 */
	function read($key, $value)
	{
		// build SQL
		$sql = "SELECT * FROM $this->TABLENAME WHERE $key='$value'"; 

		$db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
		$db->dbconnect();
		
		$result = $db->query_into_array($sql);

		$this->data = $result;
		$this->is_empty = false;

		$db->dbclose();
	}

	/**
	 * Update database with data currently in this model
	 *
	 * @param string $pk The name of primary key row (supplied by subclass)
	 */
	function update($pk)
	{
		// check if the model has been populated with data
		if($this->is_empty) die("MODEL ERROR: Can't update an empty model.");

		// built SQL (concatenation - yeah I know)
		// we're assuming validation and sanitization was done in the sublcass
		$sql = "UPDATE $this->TABLENAME SET ";
		$comma = "";
	
		foreach($this->data as $key => $value)
		{
			if($key != $pk)
			{
				if($value == null) 
					$val = 	"NULL";
				elseif($value == "NOW()")
					$val = "NOW()";
				else 
					$val = "'$value'";

				$sql .= $comma."$key=$val";
				$comma = ", ";
			}
		}

		$sql .= " WHERE $pk='".$this->data[$pk]."'";


		//echo $sql;

		// run the actual query
		$db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
		$db->dbconnect();
		$db->query($sql);
		$db->dbclose();
	}

	/**
	 * Delete this model from the DB
	 *
	 * @param string $pk The name of primary key row (supplied by subclass)
	 */
	function delete($pk)
	{
		// check if the model has been populated with data
		if($this->is_empty) die("MODEL ERROR: Can't delete an empty model.");

		// build SQL
		$sql = "DELETE FROM $this->TABLENAME WHERE $pk='".$this->data[$pk]."'"; 

		$db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
		$db->dbconnect();
		
		$result = $db->query($sql);
		$this->is_empty = true;

		$db->dbclose();
	}
}

?>

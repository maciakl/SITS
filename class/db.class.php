<?php
/**
 * Database Classes Abstraction
 *
 * This class abstracts database operations using the ADatabase interface
 * 
 * dbconnect() 		-> makes a DB connection
 * dbclose()		-> closes a DB connection
 * query($s)		-> runs the query contained in $s
 * into_array($r)	-> returns assoc array from resultset $r
 * query_into_array($s)	-> returns assoc array of query contained in $s
 * 
 * @author Lukasz Grzegorz Maciak (maciak.net)
 * @version 0.1
 *
 */

/**
 * An interface all DB classes should implement. Establishes basic DB operations of connecting and querying.
 */
interface ADatabase
{
	/**
	 * Establish DB connection using internal parameters.
	 * The connectivity parameters should be initialized in the constructor.
	 *
	 * @returns bool True if successful, false otherwise
	 */
	function dbconnect();

	/**
	 * Close the DB connection.
	 *
	 */
	function dbclose();

	/**
	 * Check if the object is connected to DB and ready to send queries.
	 *
	 * @return bool True if connected, false otherwise.
	 */
	function is_connected();

	/**
	 * Runs a query, returns appropriate DB resource.
	 *
	 * @param string $sql An SQL statement
	 * @return mixed Should return a resource appropriate for this DB type
	 */
	function query($sql);

	/**
	 * Takes a resource returned by query() and dumps the result into ASSOC array
	 *
	 * @param mixed $row A DB rowset in appropriate format
	 * @return array An ASSOC array of the result
	 */
	function into_array($row);

	/**
	 * Takes an SQL query and returns an array
	 *
	 * @param string $sql An SQL statement
	 * @return array An ASSOC array of the result
	 */
	function query_into_array($sql);
}


/**
 * DATABASE CLASS FOR MYSQL
 *
 * This is a class for opening and clossing database connections in an easy and straigthforward way
 * Database class creates a database object, to which user can send queries without needing to deal
 * with the mysql connection functions
 * 
 */
class MYSQLDatabase implements ADatabase
{
	/**
	 * The hostname on which the db resides
	 * @var string
	 */
	var $hostname; 
	
	/**
	 * The name of the database
	 * @var string
	 */
	var $db;
	
	/**
	 * The username which should be used for connection
	 * @var string
	 */
	var $user; 	

	/**
	 * The password fror $user
	 * @var string
	 */
	var $password;

	/**
	 * The link to the current database. 
	 * If database connection is not open this var will be null.
	 * @var mixed
	 */
	var $dblink; 		// link to the current database

	/**
	 * error string to be displayed when something goes wrong using a die() statement
	 * @var string
	 */	
	var $errorstring; 	// estring to be displayed on die statements
	
	/**
	 * Constructor - takes in 4 variabless and initializes the object.
	 *
	 * Note that this does not open a connection. To connect use dbconnect()
	 *
	 * To see if the object is connected, check if $dblink is null
	 * 
	 * @param string $host 		The hostname of the DB to be used
	 * @param string $dbase 	The name of the DB to be used
	 * @param string $usr		The username for connection
	 * @param string $passwd	The password for $usr
	 */
	function MYSQLDatabase($host, $dbase, $usr, $passwd)
	{

		// get the user info
		$this->hostname = $host;
		$this->db = $dbase;
		$this->user = $usr;
		$this->password = $passwd;
		
		$this->errorstring ="<h1>Database Error!</h1><h3>Please contact your Database Administrator if this problem persists.</h3> Following Error has occured: ";		
	}


	/**
	 * Establishes a connection to the database.
	 *
	 * @return bool True if connection was established or false if it failed.
	 */
	function dbconnect()
	{
		
		// connect to the mysql server
		$this->dblink = mysql_connect($this->hostname, $this->user, $this->password);

		$selected = false;

		if($this->dblink != false)
		{
			// choose database
			$selected = mysql_select_db($this->db, $this->dblink);
		}
		
		if(($this->dblink == false) or ($selected == false))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function is_connected()
	{
		if(isset($this->dblink) and $this->dblink != false)
			return true;
		else
			return false;
	}
	
	/**
	 * Sends a query to the DB and returns a rowset as a result.
	 * Attempts to sanitize the sql constructed from user input
	 * 
	 * @param string $sql A string containing a valid SQL statement
	 * @return mixed MySQL rowset reference
	 */
	function query($sql)
	{
		// escape and sanitize the string to prevent sql injection attacls
		//$sql = mysql_real_escape_string($sql);
		
		// send the query to the db
		($result = mysql_query($sql)) or die($this->errorstring .  mysql_error());
		
		// return a result in form of a rowset link
		return $result;
	}
	
	/**
	 * Returns an associative array built from the rowset passed as an argument. Rowset is the direct output of the
	 * query function (and hence the mysql_query function.
	 *
	 * @param string $rowset A valid MySQL rowset reference
	 * @return array An ASSOC array containing the data from $rowset
	 */
	function into_array($rowset)
	{
		return mysql_fetch_array($rowset, MYSQL_ASSOC);
	}
	
	/**
	 * Takes in a query, returns an ASSOC array.	
	 * This simplifies the two step process of querying and then fetchig array for results that return only one row.
	 *
	 * @uses MYSQLDatabase::query perform the actual querry
	 * @uses MYSQLDatabase::into_array stuff the results of the query into ASSOC array
	 *
	 * @param string $sql A string containing a valid SQL statement
	 * @return array An ASSOC array containing the result of the query
	 */
	function query_into_array($sql)
	{
		$rowset = $this->query($sql);
		$result = $this->into_array($rowset);
		
		return $result;
	}
	
	/** 
	 * Closes the connection to the database.
	 */
	function dbclose()
	{
		mysql_close($this->dblink);
		$this->dblink = null;
	}

	/**
	 * Get the error.
	 * @return string DB error message.
	 */
	function get_error()
	{
		return $this->errorstring . mysql_error();
	}
}

?>

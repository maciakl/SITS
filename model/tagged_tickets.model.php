<?php

require_once("../config.php");
require_once("../db/db.class.php");
require_once("model.php");


class TaggedTicketsModel extends Model
{
	function __construct()
	{
		parent::__construct("sits_tagged_tickets");

		$this->data = array("tagname" => null, "ticketid" => null );
	}

	function create($tagname, $ticketid)
	{

		$this->data["tagname"] = $tagname;
		$this->data["ticketid"] = $ticketid;


		$this->is_empty = false;

		parent::create();
	}

	function read($tagname, $ticketid)
	{
		// build SQL
		$sql = "SELECT * FROM sits_tagged_tickets WHERE tagname='$tagname' and ticketid='$ticketid'"; 

		$db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
		$db->dbconnect();
		
		$result = $db->query_into_array($sql);

		$this->data = $result;
		$this->is_empty = false;

		$db->dbclose();
	}

	function update()
	{
		die("MODEL ERROR: update not supported");
	}

	function delete()
	{
		if($this->is_empty) die("MODEL ERROR: Can't delete an empty model.");

		// build SQL
		$sql = "DELETE FROM sits_tagged_tickets WHERE tagname='".$this->data["tagname"]."' and ticketid='".$this->data["ticketid"]."'"; 

		$db = new MYSQLDatabase(SITS_DB_HOSTNAME, SITS_DB_NAME, SITS_DB_USER, SITS_DB_PASSWORD);
		$db->dbconnect();
		
		$result = $db->query($sql);
		$this->is_empty = true;

		$db->dbclose();
	}
}

?>

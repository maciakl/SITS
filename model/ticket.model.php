<?php

require_once("model.php");

class TicketModel extends Model
{
	function __construct()
	{
		parent::__construct("sits_ticket");

		$this->data = array(	// ticketid is autoincremented so we skip it
					"submitted_by" 	=> null,
					"assigned_to" 	=> null,
					"submitted_on" 	=> null,
					"subject" 	=> null,
					"resolved" 	=> null,
					"contact" 	=> null,
					"priority" 	=> null, 
					"detail" 	=> null );
	}

	function create($submitted_by, $assigned_to, $subject, $contact, $priority, $detail)
	{

		// TODO: validate priority
		
		// tickedid is auto incremented so we skip it
		$this->data["submitted_by"] 	= $submitted_by;
		$this->data["assigned_to"] 	= $assiged_to;
		$this->data["submitted_on"]	= "NOW()";
		$this->data["subject"]		= $subject;
		$this->data["resolved"]		= false;
		$this->data["contact"]		= $contact;
		$this->data["priority"]		= $priority;
		$this->data["detail"]		= $detail;

		$this->is_empty = false;

		return parent::create();
	}

	function read($id)
	{
		parent::read("ticketid", $id);
	}

	function update()
	{
		parent::update("ticketid");
	}

	function delete()
	{
		parent::delete("ticketid");
	}
}

?>

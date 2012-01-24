<?php

require_once("model.php");

class CommentModel extends Model
{
	function __construct()
	{
		parent::__construct("sits_comment");

		$this->data = array(	// commentid is autoincremented so we skip it
					"ticketid" 	=> null,
					"submitted_by" 	=> null,
					"submitted_on" 	=> null,
					"comment" 	=> null );
	}

	function create($ticketid, $submitted_by, $comment)
	{

		// TODO: validate priority
		
		// commentid is auto incremented so we skip it
		$this->data["ticketid"] 	= $ticketid;
		$this->data["submitted_by"] 	= $submitted_by;
		$this->data["submitted_on"]	= "NOW()";
		$this->data["comment"]		= $comment;

		$this->is_empty = false;

		return parent::create();
	}

	function read($id)
	{
		parent::read("commentid", $id);
	}

	function update()
	{
		parent::update("commentid");
	}

	function delete()
	{
		parent::delete("commentid");
	}
}

?>

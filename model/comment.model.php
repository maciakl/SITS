<?php

require_once("model/model.php");

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

	function populate($ticketid, $submitted_by, $comment)
	{

		// TODO: validate priority
		
		// commentid is auto incremented so we skip it
		$this->data["ticketid"] 	= $ticketid;
		$this->data["submitted_by"] 	= $submitted_by;
		$this->data["submitted_on"]	= "NOW()";
		$this->data["comment"]		= mysql_escape_string($comment);

		$this->is_empty = false;
	}

	function create($submitted_by=null, $ticketid=null, $comment=null)
	{
		$this->is_empty = false;
		
		if(!empty($submitted_by)) 	$this->data["submitted_by"] = $submitted_by;
		if(!empty($ticketid)) 		$this->data["ticketic"] = $ticketid;
		if(!empty($comment))		$this->data["comment"] = $comment;
		
		$this->data["submitted_on"] = "NOW()";
		$this->data["comment"] = mysql_escape_string($this->data["comment"]);
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

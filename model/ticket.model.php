<?php

require_once("model/model.php");
require_once("model/comment.handler.php");
require_once("model/tag.handler.php");

class TicketModel extends Model
{

	var $comments;
	var $tags;

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

		// include comments
		$this->comments = array();
		$com = new CommentHandler($id);
		$com->start();

		while($comment = $com->next())
			$this->comments[] = $comment;

		// include tags
		$this->tags = array();
		$tags = new TagHandler($id);
		$tags->start();

		while($tag = $tags->next())
			$this->tags[] = array("tagname" => $tag["tagname"], "style" => $tag["style"]);
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

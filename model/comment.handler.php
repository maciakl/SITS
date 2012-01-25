<?php

require_once("model/handler.php");

/**
 *
 */
class CommentHandler extends Handler 
{
	function __construct($ticketid = false)
	{
		$condition = $ticketid ? " WHERE ticketid='$ticketid'" : "";

		parent::__construct("sits_comment", $condition);
	}

	function count($ticketid)
	{
		return parent::count("ticketid", $ticketid);
	}
}



?>

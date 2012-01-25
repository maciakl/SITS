<?php

require_once("model/handler.php");

/**
 *
 */
class TagHandler extends Handler 
{
	function __construct($ticketid = false)
	{
		$condition = $ticketid ? " JOIN sits_tagged_tickets on sits_tag.tagname = sits_tagged_tickets.tagname WHERE ticketid='$ticketid'" : "";

		parent::__construct("sits_tag", $condition);
	}
}



?>

<?php

require_once("model/handler.php");
require_once("model/comment.handler.php");

/**
 * Hanldes the complex read only query required to generate a list of tickets, tags and comment numbers.
 *
 * Essentially this class makes a big join of the relevant tables and spits results one ASSOC array at a time.
 *
 * - the next() method gives you the next array or false if there are no more
 *
 */
class TicketHandler extends Handler 
{
	function __construct()
	{
		parent::__construct("sits_ticket");
	}

	function next()
	{
		$result = parent::next();

		// if we have results, count comments for that result
		if($result)
		{
			$com = new CommentHandler("sits_comment");
		
			$count = $com->count($result["ticketid"]);

			$result["comment_count"] = $count;
		}

		return $result;
	}
}



?>

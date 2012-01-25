<?php

require_once("model/handler.php");
require_once("model/comment.handler.php");
require_once("model/tag.handler.php");

/**
 * Hanldes the complex read only query required to generate a list of tickets, tags and comment numbers.
 *
 * Essentially this class makes a big join of the relevant tables and spits results one ASSOC array at a time.
 *
 * - the start() method initiates db connection
 * - the done() method closes the db connection
 * - the next() method gives you the next array or false if there are no more
 *
 */
class TicketHandler extends Handler 
{
	function __construct()
	{
		parent::__construct("sits_ticket");
	}

	/**
	 * Returns ASSOC array of the next available row, with additional coments and tags rows.
	 * 
	 * @return mixed An ASSOC array or false if no records are foune
	 */
	function next()
	{
		$result = parent::next();

		// if we have results, count comments & tags for that result
		if($result)
		{
			// first let's do gomments
			$com = new CommentHandler();
			$count = $com->count($result["ticketid"]);
			$result["comment_count"] = $count;
			$com->done();

			// now tags

			$com = new TagHandler($result["ticketid"]);
			$com->start();
			$tags = array();

			while($t = $com->next())
				$tags[] = array( 'tagname' => $t["tagname"], 'style' => $t["style"] );

			$result["tags"] = $tags;



		}

		return $result;
	}
}



?>

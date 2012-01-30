<?php
require_once("inc/session.php");
require_once("model/ticket.model.php");
require_once("model/comment.model.php");

$s = new Session(SITS_ACCESS_LEVEL_ALL);

include("inc/header.php");

if(!empty($_POST[comment]))
{
	if($s->is_logged_in() and $s->can_access())
	{
		$comment = new CommentModel();

		$comment->data["submitted_by"] = $_SESSION["email"];
		$comment->data["ticketid"] = $_POST["ticketid"];
		$comment->data["comment"] = $_POST["comment"];

		$comment->create();
	}
}



if(!empty($_GET["t"]))
{
	// TODO: sanitize
	$id = $_GET["t"];

	
	$ticket = new TicketModel();
	$ticket->read($id);


	

	$date = date("m/d/y g:m a", strtotime($ticket->data["submitted_on"]));

	$res = $ticket->data["resolved"] ? "YES" : "NO";

	$tags = ""; $comma = "";

	foreach(($ticket->tags) as $t)
	{
		$tags .= "$comma<span class='$t[style] taglink'>$t[tagname]</span>";
		$comma = ", ";
	}

	echo "<h3>Ticket Detail</h3>

		<table class='detail'>

			<tr>
				<th>Subject:</th>
				<td>".	$ticket->data[subject]		."</td>
			
				<th>Ticket id:		</th>	<td>#". $ticket->data["ticketid"]."</td>
				
			</tr>
			
			<tr>
				<th>Submitted On:</th>
				<td>".	$date				."</td>

				<th>Submitted By:</th>
				<td>".	$ticket->data[submitted_by]	."</td>
			</tr>


			<tr>
				<th rowspan='5'>Detail:</th>
				<td rowspan='5'>".	$ticket->data[detail]		."</td>
		
				<th>Assigned To:</th>
				<td>".	$ticket->data[assigned_to]	."</td>
			</tr>
			<tr>
				<th>Contact:</th>
				<td>".	$ticket->data[contact]		."</td>
			</tr>
			
			<tr>
				<th>Priority:</th>
				<td>".	$ticket->data[priority]		."</td>
			</tr>
			
			<tr>
				<th>Resolved:</th>
				<td>".	$res				."</td>
			</tr>

			<tr>
				<th>Tags:</th>
				<td>$tags				</td>

			</tr>	
		</table>

		<h3>Comments:</h3>

		<table class='detail comment'>";

		foreach($ticket->comments as $comment)
		{
			$date = date("m/d/y g:m a", strtotime($comment["submitted_on"]));

			echo "
				<tr>
					<th>
						<small class='ticketid'>#C$comment[commentid]</small><br> 
						<span class='email'>$comment[submitted_by]</span><br>
						<small>$date</small>
					</th>
					<td>". nl2br($comment[comment]) ."</td>

				</tr>";
		}


		echo "</table>";
			
			
		echo "<a name='comment'><h3>Post Comment</h3></a>
			
			
			";

		// TODO session check - hide box if not logged in or if read-only

		if($s->is_logged_in())
		{
			echo "<div id='post-comment'>
				<form method='POST' action='#comment'>
				<small>Logged in as <strong>$_SESSION[email]</strong><br>
					<input type='hidden' name='ticketid' value='".$ticket->data[ticketid]."'>
					<textarea name='comment' id='comment-box' rows='3' cols='100'></textarea><br>
					<input type='submit' value='Post Comment'>
				</form></div>";
		}
		else
		{
			echo "<div id='post-comment'><p>Please <a href='login.php'>log in</a> to post comments.</p>";
		}

}

include("inc/footer.php");


?>

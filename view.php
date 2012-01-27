<?php
require_once("model/ticket.model.php");
require_once("model/comment.model.php");

include("inc/header.php");

if(!empty($_POST[comment]))
{
	$comment = new CommentModel();

	$comment->data["submitted_by"] = "admin"; // TODO -> change to session username
	$comment->data["ticketid"] = $_POST["ticketid"];
	$comment->data["comment"] = $_POST["comment"];

	$comment->create();
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
				<th>Ticket ID:</th>
				<td>".	$ticket->data["ticketid"]	."</td>
			</tr>
			<tr>
				<th>Submitted By:</th>
				<td>".	$ticket->data[submitted_by]	."</td>
			</tr>
			<tr>
				<th>Assigned To:</th>
				<td>".	$ticket->data[assigned_to]	."</td>
			</tr>
			<tr>
				<th>Contact:</th>
				<td>".	$ticket->data[contact]		."</td>
			</tr>
			<tr>
				<th>Submitted On:</th>
				<td>".	$date				."</td>
			</tr>
			<tr>
				<th>Priority:</th>
				<td>".	$ticket->data[priority]		."</td>
			</tr>
			<tr>
				<th>Subject:</th>
				<td>".	$ticket->data[subject]		."</td>
			</tr>
			<tr>
				<th>Detail:</th>
				<td>".	$ticket->data[detail]		."</td>
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
						<small>#$comment[commentid]</small><br> 
						<span class='email'>$comment[submitted_by]</span><br>
						<small>$date</small>
					</th>
					<td>$comment[comment]</td>

				</tr>";
		}


		echo "</table>";
			
			
		echo "<a name='comment'><h3>Post Comment</h3></a>
			
			
			<div id='post-comment'>";

		// TODO session check - hide box if not logged in or if read-only
		
		echo "
			<form method='POST' action='#comment'>
			<small>Logged in as <strong>admin</strong><br>
				<input type='hidden' name='ticketid' value='".$ticket->data[ticketid]."'>
				<textarea name='comment' id='comment-box' rows='3' cols='100'></textarea><br>
				<input type='submit' value='Post Comment'>
			</form>";
		
		echo "	</div>";

}

include("inc/footer.php");


?>

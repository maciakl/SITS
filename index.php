<?php

// TODO: header


require_once("model/ticket.handler.php");

$ticket = new TicketHandler();
$ticket->start();

echo "<table border=1>
	
	<tr>
		<th>Ticket ID</th>
		<th>Submitted By</th>
		<th>Assigned To</th>
		<th>Contact</th>
		<th>Date</th>
		<th>Priority</th>
		<th>Subject</th>
		<th>Resolved</th>
		<th>Comments</th>
		<th>Tags</th>

	</tr>";


while($row = $ticket->next())
{

	echo "
	
	<tr>
		<td>	$row[ticketid]		</td>
		<td>	$row[submitted_by]	</td>
		<td>	$row[assigned_to]	</td>
		<td>	$row[contact]		</td>
		<td>	$row[submitted_on]	</td>
		<td>	$row[priority]		</td>
		<td>	$row[subject]		</td>
		<td>	$row[resolved]		</td>
		<td>	$row[comment_count]	</td>
		<td>	$row[tags]		</td>

	</tr>";
}
	


// TODO: footer

?>

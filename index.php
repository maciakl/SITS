<?php
require_once("inc/session.php");

$s = new Session(SITS_ACCESS_LEVEL_ALL);

include("inc/header.php");

require_once("model/ticket.handler.php");

$ticket = new TicketHandler();
$ticket->start();

echo "<h3>Open Tickets</h3>

    <table border='1' class='mainpage'>
	
	<tr>
		<th>ID</th>
		<th>Subject</th>
		<th>Submitted By</th>
		<th>Assigned To</th>
		<th>Contact</th>
		<th>Date</th>
		<th>Priority</th>
		<th>Resolved</th>
		<th>Comments</th>
		<th>Tags</th>

	</tr>";


while($row = $ticket->next())
{

	// special handling for certain columns
	$date = date("m/d/y g:m a", strtotime($row["submitted_on"]));

	$subj = "<span class='ticketlink'><a href='view.php?t=$row[ticketid]'>$row[subject]</a></span>";

	$res = $row["resolved"] ? "YES" : "NO";

	$tags = ""; $comma = "";

	foreach($row["tags"] as $t)
	{
		$tags .= "$comma<span class='$t[style] taglink'>$t[tagname]</span>";
		$comma = ", ";
	}

	$detail = substr($row["detail"], 0, 100);

	echo "
	
	<tr>
		<td>	#$row[ticketid]		</td>
		<td class='subject'>	$subj<br><small>$detail</small>	</td>
		<td>	$row[submitted_by]	</td>
		<td>	$row[assigned_to]	</td>
		<td>	$row[contact]		</td>
		<td>	$date			</td>
		<td>	$row[priority]		</td>
		<td>	$res			</td>
		<td>	$row[comment_count]	</td>
		<td>	$tags			</td>

	</tr>";
}

echo "</table>";

include("inc/footer.php");

?>

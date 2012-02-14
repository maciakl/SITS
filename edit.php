<?php
require_once("inc/session.php");
require_once("model/ticket.model.php");


$s = new Session(SITS_ACCESS_LEVEL_STANDARD);

include("inc/header.php");

if(!empty($_GET["t"]))
{
	$id = $_GET["t"];

	$ticket = new TicketModel();
	$ticket->read($id);

	$headn = "Update";

	$subject = $ticket->data["subject"];
	$detail = $ticket->data["detail"];
	$assigned_to = $ticket->data["assigned_to"];
	$contact = $ticket->data["contact"];

	$plow = $pmed = $phigh = $pcrit ="";

	switch($data["priority"])
	{
		case "low":
			$plow = "selected=true";
			break;
		case "medium":
			$pmed = "selected=true";
			break;
		case "high":
			$phigh = "selected=true";
			break;
		case "critical":
			$pcrit = "selected=true";
			break;
	}

	$hidden = "<input type='hidden' name='ticketid' value='$id'> <input type='hidden' name='submitted_by' value='".$ticket->data["submitted_by"]."'>";
	$submit_text = "Update Ticket";

	// TODO: TAGS!!
}
else
{
	$headn = "Create a New";

	$subject = "";
	$detail = "";
	$assigned_to = "";
	$contact = "";

	$plow = $phigh = $pcrit = "";
	$pmed = "selected=true";

	$hidden = "";
	$submit_text = "Create Ticket";
}

if(empty($_POST))
{
	echo "<h3>$headn Ticket</h3>

<form method='POST'>
<label for='subject'>Descriptive Subject:<br>
<input type='text' name='subject' class='ticketedit' value='$subject'></label><br>

<label for='detail'>Detailed Description:<br>
<textarea name='detail' class='ticketedit' rows='10'>$detail</textarea></label><br>

<label for='priority'>Priority:<br>
<select name='priority' class='ticketedit'>
	<option $plow >low</option>
	<option $pmed >medium</option>
	<option $phigh >high</option>
	<option $pcrit >critical</option>
</select></label><br>

<label for='assigned_to'>Assigned to:<br>
<input type='text' name='assigned_to' class='user_autocomplete ticketedit' value='$assigned_to'></label><br>

<label for='contact'>Contact Email:<br>
<input type='text' name='contact' class='ticketedit' value='$contact'></label><br>

<label for='tags'>Tags:<br>
<input type='text' name='tags' class='ticketedit'></label><br>

$hidden

<input type='submit' value='$submit_text'>
</form>
	
";
}
else
{
	// TODO: sanitize
	//
	$ticket = new TicketModel();

	if(empty($_POST["ticketid"]))
		$id = $ticket->create($_SESSION["email"], $_POST["assigned_to"], $_POST["subject"], $_POST["contact"], $_POST["priority"], $_POST["detail"]);
	else
	{
		$id = $_POST["ticketid"];

		$ticket->data["ticketid"] 	= $_POST["ticketid"];
		$ticket->data["submitted_by"]	= $_POST["submitted_by"];
		$ticket->data["assigned_to"] 	= $_POST["assigned_to"];
		$ticket->data["subject"] 	= mysql_real_escape_string($_POST["subject"]);
		$ticket->data["contact"] 	= $_POST["contact"];
		$ticket->data["priority"] 	= $_POST["priority"];
		$ticket->data["detail"] 	= mysql_real_escape_string($_POST["detail"]);

		$ticket->is_empty = false;

		$ticket->update();

	}

	echo "<h3>Thank You</h3><p>Redirecting to ticket page. Click <a href='view.php?t=$id'>here</a> if this is taking too long.</p>";
	echo '<meta http-equiv="refresh" content="0;url=view.php?t='.$id.'">';	

}


include("inc/footer.php");
?>

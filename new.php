<?php
require_once("inc/session.php");
require_once("model/ticket.model.php");


$s = new Session(SITS_ACCESS_LEVEL_STANDARD);

include("inc/header.php");

if(empty($_POST))
{
	echo "<h3>Create a New Ticket</h3>

<form method='POST'>
<label for='subject'>Descriptive Subject:<br>
<input type='text' name='subject' class='ticketedit'></label><br>

<label for='detail'>Detailed Description:<br>
<textarea name='detail' class='ticketedit' rows='10'></textarea></label><br>

<label for='priority'>Priority:<br>
<select name='priority' class='ticketedit'>
	<option>low</option>
	<option selected='true'>medium</option>
	<option>high</option>
	<option>critical</option>
</select></label><br>

<label for='assigned_to'>Assigned to:<br>
<input type='text' name='assigned_to' class='user_autocomplete ticketedit'></label><br>

<label for='contact'>Contact Email:<br>
<input type='text' name='contact' class='ticketedit'></label><br>

<label for='tags'>Tags:<br>
<input type='text' name='tags' class='ticketedit'></label><br>

<input type='submit' value='Create Ticket'>
</form>
	
";
}
else
{
	// TODO: sanitize
	//
	$ticket = new TicketModel();
	$id = $ticket->create($_SESSION["email"], $_POST["assigned_to"], $_POST["subject"], $_POST["contact"], $_POST["priority"], $_POST["detail"]);

	echo "<h3>Thank You</h3><p>Redirecting to ticket page. Click <a href='view.php?t=$id'>here</a> if this is taking too long.</p>";
	echo '<meta http-equiv="refresh" content="0;url=view.php?t='.$id.'">';	

}


include("inc/footer.php");
?>

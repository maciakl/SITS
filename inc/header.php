<?php require_once("config.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="AUTHOR" content="Lukasz Grzegorz Maciak">
        <meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1">

	<link rel="stylesheet" href="style.css" type="text/css">

	<?php if(SITS_ENABLE_INDEXING) { ?>
		<meta NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
		<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<meta HTTP-EQUIV="Expires" CONTENT="-1">
	<?php	} // END if(SITS_ENABLE_INDEXING) ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  </head>

  <body>

	<div id="header">
	<h1>SITS: Simple Issue Tracking System</h1>
	<hr>

	</div>

	<div id="main">

		<div id="sidebar">

		<?php
			if(!empty($_SESSION['email']))
			{
				echo "<h3>Logged in</h3>
					<ul>
						<li>$_SESSION[email]</li>
						<li><a href='logout.php'>Log Out</a></li>
					</ul>";
			}
			else
			{
				echo "<h3>Not logged in</h3>
					<ul>
						<li><a href='login.php'>Log in</a></li>
					</ul>";
			}
		?>

			<h3>Navigation</h3>

			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="new.php">New Ticket</a></li>
				<li><a href="tags.php">Manage Tags</a></li>
			</ul>

		</div>

		<div id="content">


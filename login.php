<?php

require_once("inc/session.php");
require_once("model/user.model.php");

include("inc/header.php");

$login_error = "<h3>Login Error</h3><p>Could not log you in using that email and password. Please <a href='login.php'>try again</a>.</p>";

if(empty($_POST["email"]))
{
	if(empty($_SESSION["email"]))
	{
		echo "
			<h3>Log In</h3>
			<form method='POST'>
				<label for='email'>Email:<br>
				<input type='text' name='email'></label>
				<br>
				<label for='password'>Password:<br>
				<input type='password' name='password'></label>
				<br>
				<input type='submit' value='log in'>
			</form>	";
	}
	else
		echo "
			<h3>Log in as another user?</h3>
			<p>You are currently logged in as $_SESSION[email]. To log in as another user,
		       <a href='logout.php'>log out</a> first.</p>";
}
else
{
	$u = new UserModel();
	$u->read($_POST["email"]);

	if($u->data)
	{
		if($u->check_password($_POST["password"]))
		{
			Session::login($u->data["email"], $u->data["type"]);

			echo "<h3>Redirecting</h3><p>Logging you in. Please wait, or click <a href='index.php'>here</a>.</p>";
			echo '<meta http-equiv="refresh" content="0;url=index.php">';
		}
		else 
			echo $login_error;

	}
	else
	{
		echo $login_error;
	}

		
	//var_dump($u);
}
	
include("inc/footer.php");
?>

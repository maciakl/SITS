<?php
require_once("inc/session.php");
Session::logout();

include("inc/header.php");
echo "<h3>Logged out</h3><p>You are now logged out. <a href='login.php'>Log in</a> again.</p>";
include("inc/footer.php");
?>

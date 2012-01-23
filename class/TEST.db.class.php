<?php

include("db.class.php");

$foo = new MYSQLDatabase("localhost", "test", "testuser", "password");
$c = $foo->dbconnect();



?>

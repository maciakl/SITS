<?php

echo "Importing the class.<br>";
include("./db.class.php");

echo "Creating the db object.<br>";
$foo = new MYSQLDatabase("localhost", "sits_test", "testuser", "password");

echo "Establishing connection.<br>";
$c = $foo->dbconnect();

assert('$c==true;');
echo "Connected: $c<br>";

echo "Running a simple query<br>";
$bar = $foo->query_into_array("select * from sits_test");
print_r($bar); echo "<br>";

$id = strtoupper(md5(uniqid(mt_rand(), true))); 

echo "Inserting row with ID: $id and value 'TEST<br>";
$sql = "insert into sits_test values ('$id', 'TEST')";
echo "SQL: $sql<br>"; 
$foo->query($sql);

echo "Running full query:<br>";
$bar = $foo->query("select * from sits_test");

while($row = $foo->into_array($bar))
{
	print_r($row); echo "<br>";
}



?>

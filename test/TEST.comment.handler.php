<?php

require_once("test.php");

echo "Testing import...\n\n";
require_once("model/comment.handler.php");

echo "\nCreating handler with id 1..\n\n";

$h = new CommentHandler(1);

var_dump($h);

echo "\n Starting handler... \n\n";

$h->start();
//var_dump($h);

//$f = $h->next_row();
//$f = mysql_fetch_array($h->resource);
//var_dump($f);

echo "\n Texting the next() function in a loop...\n\n";

while($row = $h->next())
{
	print_r($row);
}

$h->done();

echo "\n Testing counting comments for id 1 \n";

var_dump($h->count(1));
var_dump($h->count(15));



?>

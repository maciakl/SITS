<?php

echo "<pre>";

chdir("..");

echo "Testing import...\n\n";
require_once("model/ticket.handler.php");

echo "\n Creating handler..\n\n";

$h = new TicketHandler();

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


//$h->done();



?>

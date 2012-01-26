<?php

require_once("test.php");
$b = "\n";
echo "Testing import...$b";
require_once("model/ticket.model.php");

echo "Initializing object...$b";
$u = new TicketModel();



echo "Check if empty (should be):$b";
var_dump($u->is_empty);


$rand = strtoupper(md5(uniqid(mt_rand(), true)));

echo "$b Populating with data...$b";
$em = $u->create("admin", null, "TEST" , null, "low", "$rand");

var_dump($em);

echo "Reading last entry...$b";
$u->read($em);

var_dump($u->data);


echo "$b Updating the last entry to type=standard...$b";
$u->data["subject"] = "NOT A TEST";
$u->update();

$u->read($em);
var_dump($u->data);


echo "$b Deleting current...$b";
$u->delete();

$u->read($em);
var_dump($u->data);


echo "Testing random read of record 1:\n";

$u->read(1);
var_dump($u);

?>

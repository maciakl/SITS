<?php
$b = '<br>';

echo "Testing import...$b";
require_once("tagged_tickets.model.php");

echo "Initializing object...$b";
$u = new TaggedTicketsModel();

echo "Check if empty (should be):$b";
var_dump($u->is_empty);

//$em = strtoupper(md5(uniqid(mt_rand(), true)));

echo "$b Populating with data...$b";
$u->create('test', "2");

echo "Reading last entry...$b";
$u->read('test', '2');

var_dump($u->data);

echo "$b Deleting current...$b";
$u->delete();

$u->read("test", '2');
var_dump($u->data);

?>

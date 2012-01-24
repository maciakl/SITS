<?php
$b = '<br>';

echo "Testing import...$b";
require_once("user.model.php");

echo "Initializing object...$b";
$u = new UserModel();

echo "Check if empty (should be):$b";
var_dump($u->is_empty);

$em = strtoupper(md5(uniqid(mt_rand(), true)));

echo "$b Populating with data...$b";
$u->create($em, "password", "user");

echo "Reading last entry...$b";
$u->read($em);

var_dump($u->data);

echo "$b Updating the last entry to type=standard...$b";
$u->data["type"] = "standard";
$u->update();

$u->read($em);
var_dump($u->data);

echo "$b Deleting current...$b";
$u->delete();

$u->read($em);
var_dump($u->data);

?>

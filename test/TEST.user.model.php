<?php

require_once("test.php");
$b = "\n";
echo "Testing import...$b";
require_once("model/user.model.php");

echo "Initializing object...$b";
$u = new UserModel();

echo "Check if empty (should be):$b";
var_dump($u->is_empty);

$em = strtoupper(md5(uniqid(mt_rand(), true)));

echo "$b Populating with random username, password 'password' and type user..$b";
$u->create($em, "password", "user");

echo "Reading last entry...$b";
$u->read($em);

var_dump($u->data);

echo "\nLet's see if we can match passwords - first correct one 'password'\n";
var_dump($u->check_password("password"));

echo "\nNow let's try a wrong password: 'foobar'\n";
var_dump($u->check_password("foobar"));

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

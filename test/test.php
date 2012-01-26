<?php

header('Content-type: text/plain');
chdir("..");

echo "### TEST " . date("D M j G:i:s T Y") . "\n";
echo "Running from: " . getcwd() . "\n\n";

?>

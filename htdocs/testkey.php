<?php

error_reporting (E_ALL);

//include("../include/inc_stuff.php");

$jgmDate = new DateTime();
$testkey = $jgmDate->format("YmdHisu");
printf ("%s - jgm1<br />\n", $testkey);

?>

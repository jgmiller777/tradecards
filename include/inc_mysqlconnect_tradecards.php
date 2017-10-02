<?php
//TODO replace mysqli_error() function call/s with some descriptive string.
//     potential security issue here.
  if ($testmode) { printf ("<p>Establishing mysqli connection...</p>\n"); }
  $mysqli = new mysqli ("localhost", "xxx", "xxx", "tradecards") 
    or die($mysqli->connect_errno() . " - " . $mysqli->connect_error());
  if ($testmode) { printf ("<p>Connection established</p>\n"); }
  if ($testmode) { printf ("<p>Host information: " . $mysqli->host_info . "</p>\n"); }
?>

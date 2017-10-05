<?php
//TODO replace mysqli_error() function call/s with some descriptive string.
//     potential security issue here.
  $htmlxstr = "";
  if ($testmode) { $htmlxstr .= "<p>Establishing mysqli connection...</p>\n"; }
  $mysqli = new mysqli ("localhost", "root", "qwerty7", "tradecards") 
    or die($mysqli->connect_errno() . " - " . $mysqli->connect_error());
  if ($testmode) { $htmlxstr .= "<p>Connection established</p>\n"; }
  if ($testmode) { $htmlxstr .= "<p>Host information: " . $mysqli->host_info . "</p>\n<br />\n"; }
  if (empty($htmlcode)) {
    printf ("%s", $htmlxstr);
  } else {
    $htmlcode .= $htmlxstr;
  }
?>

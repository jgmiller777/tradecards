<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Brand Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_pne = fopen ("../data/playernameext.txt", "rt")
            or die ("<p class='fopen-error'>Cannot open playernameext.txt.</p>\n");
if ($testmode) { printf ("<p>playernameext.txt opened!<br /></p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  playernameext (id
              , extname
              , date_added
              , date_updated
               )"
    . " VALUES ";
while (!feof ($fh_pne) ) {
  $line = fgets ($fh_pne);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $playernameextID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($playernameextID == "''") { $playernameextID = "DEFAULT"; }
    
    // extname
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playernameextExtName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playernameextDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($playernameextDateAdded == "''") { $playernameextDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playernameextDateUpdated = quote_value (trim ($temp));
    if ($playernameextDateUpdated == "''") { $playernameextDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $playernameextID
             , $playernameextExtName
             , $playernameextDateAdded
             , $playernameextDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s]</p>\n"
                            , substr($line, 0, -1)
                            , $playernameextID
                            , $playernameextExtName
                            , $playernameextDateAdded
                            , $playernameextDateUpdated
                            );
    }
  }
}

$sql = substr ($sql, 0, -2); // get rid of last two characters from $sql string

// execute the SQL statement
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

$result = $mysqli->query($sql);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  // echo the result identifier
  printf ("<p>Table - playernameext: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Brand record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying playernameext data</p>\n");
printf ("<p>
         id
       , extname
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM playernameext";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->extname)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Card Condition Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_cardcondition = fopen ("../data/cardcondition.txt", "rt")
                    or die ("<p class='fopen-error'>Cannot open cardcondition.txt.</p>\n");
if ($testmode) { printf ("<p>cardcondition.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . " cardcondition (id
                     , name
                     , date_added
                     , date_updated
                      )"
    . " VALUES ";
while (!feof ($fh_cardcondition) ) {
  $line = fgets ($fh_cardcondition);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $cardconditionID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($cardconditionID == "''") { $cardconditionID = "DEFAULT"; }
    
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardconditionName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardconditionDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardconditionDateAdded == "''") { $cardconditionDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardconditionDateUpdated = quote_value (trim ($temp));
    if ($cardconditionDateUpdated == "''") { $cardconditionDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $cardconditionID
             , $cardconditionName
             , $cardconditionDateAdded
             , $cardconditionDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s]</p>\n"
                            , substr($line, 0, -1)
                            , $cardconditionID
                            , $cardconditionName
                            , $cardconditionDateAdded
                            , $cardconditionDateUpdated
                            );
    }
  }
}

$sql = substr ($sql, 0, -2); // get rid of last two characters from $sql string

// execute the SQL statement
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

$result = $mysqli->query ($sql);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  // echo the result identifier
  printf ("<p>Table - cardcondition: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Card Condition record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying cardcondition data</p>\n");
printf ("<p>
         id
       , name
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM cardcondition";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

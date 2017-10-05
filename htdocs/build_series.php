<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Series Table Load";
$cssfile = "tradecards.css";
$xxx = "";

html_begin ($title, $header, $cssfile, $xxx);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_series = fopen ("../data/series.txt", "rt")
             or die ("<p class='fopen-error'>Cannot open series.txt.</p>\n");
if ($testmode) { printf ("<p>series.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  series (id
               , name
               , date_added
               , date_updated
                )"
    . " VALUES ";
while (!feof ($fh_series) ) {
  $line = fgets ($fh_series);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $seriesID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($seriesID == "''") { $seriesID = "DEFAULT"; }
    
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $seriesName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $seriesDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($seriesDateAdded == "''") { $seriesDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $seriesDateUpdated = quote_value (trim ($temp));
    if ($seriesDateUpdated == "''") { $seriesDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $seriesID
             , $seriesName
             , $seriesDateAdded
             , $seriesDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s]</p>\n"
                            , substr($line, 0, -1)
                            , $seriesID
                            , $seriesName
                            , $seriesDateAdded
                            , $seriesDateUpdated
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
  printf ("<p>Table - series: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Series record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying series data</p>\n");
printf ("<p>
         id
       , name
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM series";
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

html_end ($xxx);

?>

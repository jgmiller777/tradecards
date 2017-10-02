<?php
//
// TODO Drop leading zeroes from player's name
//

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Players Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_player = fopen ("../data/player.txt", "rt")
             or die ("<p class='fopen-error'>Cannot open player.txt.</p>\n");
if ($testmode) { printf ("<p>player.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . " player (id
              , name
              , rookie_yr
              , career
              , date_added
              , date_updated
               )"
  . " VALUES ";
while (!feof ($fh_player) ) {
  $line = fgets ($fh_player);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $playerID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($playerID == "''") { $playerID = "DEFAULT"; }
    
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playerName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    // rookieYR
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playerRookieYR = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($playerRookieYR == "''") { $playerRookieYR = quote_value (NULL); }
    
    // career
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playerCareer = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($playerCareer == "''") { $playerCareer = quote_value (NULL); }

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playerDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($playerDateAdded == "''") { $playerDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $playerDateUpdated = quote_value (trim ($temp));
    if ($playerDateUpdated == "''") { $playerDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $playerID
             , $playerName
             , $playerRookieYR
             , $playerCareer
             , $playerDateAdded
             , $playerDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $playerID
                            , $playerName
                            , $playerRookieYR
                            , $playerCareer
                            , $playerDateAdded
                            , $playerDateUpdated
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
  printf ("<p>Table - player: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Players record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying player data</p>\n");
printf ("<p>
         id
       , name
       , rookie_yr
       , career
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM player";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->rookie_yr)
           , htmlspecialchars ($row->career)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

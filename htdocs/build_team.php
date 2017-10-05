<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Team Table Load";
$cssfile = "tradecards.css";
$xxx = "";

html_begin ($title, $header, $cssfile, $xxx);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_team = fopen ("../data/team.txt", "rt")
           or die ("<p class='fopen-error'>Cannot open team.txt.</p>\n");
if ($testmode) { printf ("<p>team.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . " team (id
            , name
            , established_yr
            , sportID
            , priornameID
            , date_added
            , date_updated
             )"
  . " VALUES ";
while (!feof ($fh_team) ) {
  $line = fgets ($fh_team);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $teamID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($teamID == "''") { $teamID = "DEFAULT"; }
   
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $teamName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    // yearEst
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $teamYearEst = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($teamYearEst == "''") { $teamYearEst = quote_value (NULL); }
    
    // sportID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $teamSportID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($teamSportID == "''") { $teamSportID = quote_value (NULL); }

    // priornameID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $teamOldID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($teamOldID == "''") { $teamOldID = quote_value (NULL); }

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $teamDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($teamDateAdded == "''") { $teamDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $teamDateUpdated = quote_value (trim ($temp));
    if ($teamDateUpdated == "''") { $teamDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $teamID
             , $teamName
             , $teamYearEst
             , $teamSportID
             , $teamOldID
             , $teamDateAdded
             , $teamDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $teamID
                            , $teamName
                            , $teamYearEst
                            , $teamSportID
                            , $teamOldID
                            , $teamOldDateAdded
                            , $teamOldDateUpdated
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
  printf ("<p>Table - team: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Team record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying team data</p>\n");
printf ("<p>
         id
       , name
       , established_yr
       , sportID
       , priornameID
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * from team";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->established_yr)
           , htmlspecialchars ($row->sportID)
           , htmlspecialchars ($row->priornameID)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ($xxx);

?>

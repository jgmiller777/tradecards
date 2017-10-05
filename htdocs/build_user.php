<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB User Table Load";
$cssfile = "tradecards.css";
$xxx = "";

html_begin ($title, $header, $cssfile, $xxx);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");
// ***** open input file and build $sql statement
$fh_user = fopen ("../data/user.txt", "rt") 
           or die ("<p class='fopen-error'>Cannot open user.txt.</p>\n");
if ($testmode) { printf ("<p>user.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . " user (id
            , userID
            , name
            , date_added
            , date_updated
             )"
    . " VALUES ";
while (!feof ($fh_user) ) {
  $line = fgets ($fh_user);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $id = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($id == "''") { $id = "DEFAULT"; }

    // userID
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $userID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // name
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $name = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $userDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($userDateAdded == "''") { $userDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $userDateUpdated = quote_value (trim ($temp));
    if ($userDateUpdated == "''") { $userDateUpdated = quote_value ($tempdate); }

    $sql .= "( 
               $id
             , $userID
             , $name
             , $userDateAdded
             , $userDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $id
                            , $userID
                            , $name
                            , $userDateAdded
                            , $userDateUpdated
                            );
    }
  }
}

$sql = substr ($sql, 0, -2); // get rid of last two characters from $sql string
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  // echo the result identifier
  printf ("<p>Table - user: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying user data</p>\n");
printf ("<p>
         id
       , userID
       , name
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM user";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->userID)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ($xxx);

?>

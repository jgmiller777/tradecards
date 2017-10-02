<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB UserCollection Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_usercollection = fopen ("../data/usercollection.txt", "rt")
             or die ("<p class='fopen-error'>Cannot open usercollection.txt.</p>\n");
if ($testmode) { printf ("<p>usercollection.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  usercollection (ID
                       , userID
                       , collectionID
                       , date_added
                       , date_updated
                        )"
    . " VALUES ";
while (!feof ($fh_usercollection) ) {
  $line = fgets ($fh_usercollection);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $usercollectionID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($usercollectionID == "''") { $usercollectionID = "DEFAULT"; }

    // userID
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $userID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    // collectionID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $collectionID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $collectionDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($collectionDateAdded == "''") { $collectionDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $collectionDateUpdated = quote_value (trim ($temp));
    if ($collectionDateUpdated == "''") { $collectionDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $usercollectionID
             , $userID
             , $collectionID
             , $collectionDateAdded
             , $collectionDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $usercollectionID
                            , $userID
                            , $collectionID
                            , $collectionDateAdded
                            , $collectionDateUpdated
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
  printf ("<p>Table - usercollection: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Collection record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying usercollection data</p>\n");
printf ("<p>
         id
       , userID
       , collectionID
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM usercollection";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->userID)
           , htmlspecialchars ($row->collectionID)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

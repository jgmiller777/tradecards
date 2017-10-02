<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB team Table Convert";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** 
$sql_update = "UPDATE team
               SET established_yr = NULL
               WHERE established_yr = '0'
              ";

// execute the SQL statement
$result = $mysqli->query ($sql_update, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table - team: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s updated: %d</p>\n<br />\n", $mysqli->affected_rows);
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

html_end ();

?>

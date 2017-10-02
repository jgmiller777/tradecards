<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB cardsDB Table Maintenance";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** 
$sql_update = "UPDATE brand
	       SET name = 'SP'
	       WHERE id = '27'
              ";

// execute the SQL statement
$result = $mysqli->query ($sql_update, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table - cardsDB: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s updated: %d</p>\n<br />\n", $mysqli->affected_rows);
}

$result->free_result ();

html_end ();

?>

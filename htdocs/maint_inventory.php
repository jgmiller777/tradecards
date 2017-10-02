<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB inventory Table Convert";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** 
$sql_update = "UPDATE inventory
	       SET serialnbr = NULL
	       WHERE serialnbr = ''
              ";

// execute the SQL statement
$result = $mysqli->query ($sql_update, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table - inventory: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s updated: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the >>> new <<< inventory table
printf ("<p>Displaying new inventory data</p>\n");
printf ("<p>
         id
       , usercollectionID
       , cardsdbID
       , cardconditionID
       , numberown
       , purchasedate
       , purchaseprice
       , serialnbr
       , commentsID
       , date_added
       , date_updated
         </p>\n"
       );
$sql_select = "SELECT * FROM inventory";
$result = $mysqli->query ($sql_select, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->usercollectionID)
           , htmlspecialchars ($row->cardsdbID)
           , htmlspecialchars ($row->cardconditionID)
           , htmlspecialchars ($row->numberown)
           , htmlspecialchars ($row->purchasedate)
           , htmlspecialchars ($row->purchaseprice)
           , htmlspecialchars ($row->serialnbr)
           , htmlspecialchars ($row->commentsID)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

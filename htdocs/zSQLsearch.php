<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB cardsDB Table Search";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** 
$sql_select = "SELECT *
               FROM cardsDB
               WHERE playerID IN (
                                   '2684'
                                 , '2685'
                                 )
              ";
printf ("<p>%s</p>\n", $sql_select);

$result = $mysqli->query ($sql_select, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    printf ("\n");
    exit (1);
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->sportID)
           , htmlspecialchars ($row->year)
           , htmlspecialchars ($row->brandID)
           , htmlspecialchars ($row->seriesID)
           , htmlspecialchars ($row->categoryID)
           , htmlspecialchars ($row->subcategoryID)
           , htmlspecialchars ($row->cardnbr)
           , htmlspecialchars ($row->cardsubnbr)
           , htmlspecialchars ($row->playerID)
           , htmlspecialchars ($row->teamID)
           , htmlspecialchars ($row->serialnbr)
           , htmlspecialchars ($row->autograph)
           , htmlspecialchars ($row->rookiecard)
           , htmlspecialchars ($row->shortprint)
           , htmlspecialchars ($row->commentsID)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

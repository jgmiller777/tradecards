<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB inventory Table Renames";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// rename table ---------------------------------------------------------------------
$sql_renametables = "RENAME TABLE
                       user           TO Zuser
                     , collection     TO Zcollection
                     , usercollection TO Zusercollection
                     , sport          TO Zsport
                     , brand          TO Zbrand
                     , series         TO Zseries
                     , category       TO Zcategory
                     , subcategory    TO Zsubcategory
                     , player         TO Zplayer
                     , playernameext  TO Zplayernameext
                     , team           TO Zteam
                     , cardcondition  TO Zcardcondition
                     , comments       TO Zcomments
                     , cardsDB        TO ZcardsDB
                     , inventory      TO Zinventory
                    ";
// execute the SQL statement
$result = $mysqli->query($sql_renametables);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table renames: %s</br>\n", $result);
}
$result->free_result ();

html_end ();

?>

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

// Create new inventory table as inventory2 (renamed later)
$sql_createtable = "CREATE TABLE inventory2 (
    id                 bigint unsigned not null auto_increment
  , usercollectionID   bigint unsigned not null
  , cardsdbID          bigint unsigned not null
  , cardconditionID    bigint unsigned
  , numberown          int(4)
  , purchasedate       date
  , purchaseprice      float(10,2)
  , serialnbr          varchar(10)
  , commentsID         bigint unsigned
  , date_added         datetime        not null
  , date_updated       datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxInventoryCard (usercollectionID
                               , cardsdbID
                               , cardconditionID
                                )
                  )";

// execute the SQL statement
$result = $mysqli->query($sql_createtable);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table create - inventory2: %s</p>\n", $result);
}

// ***** open current inventory table and build $sql insert stmt for new inventory table
$sql_oldtable = "SELECT * FROM inventory ORDER BY id";
$result = $mysqli->query ($sql_oldtable, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  $sql_newtable = "INSERT INTO"
      . " inventory2 (id
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
                     )"
      . " VALUES ";
  while ($row = $result->fetch_object ()) {
    $sql_newtable .= "( "
                  . quote_value ($row->id)
           . ", " . quote_value ($row->usercollectionID)
           . ", " . quote_value ($row->cardsdbID)
           . ", " . quote_value ($row->cardconditionID)
           . ", " . quote_value ($row->numberown)
           . ", " . quote_value ($row->purchasedate)
           . ", " . quote_value ($row->purchaseprice)
           . ", " . quote_value ('')
           . ", " . quote_value ($row->commentsID)
           . ", " . quote_value ($row->date_added)
           . ", " . quote_value ($row->date_updated)
                  . "), ";
  }
}

// get rid of last two characters from $sql string
$sql_newtable = substr ($sql_newtable, 0, -2);
if ($testmode) { printf ("<p>%s</p>\n", $sql_newtable); }

// execute the SQL statement
$result = $mysqli->query($sql_newtable);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table - inventory2: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// rename old inventory table
// rename new inventory table
$sql_renametables = "RENAME TABLE
                       inventory  TO inventoryold
                     , inventory2 TO inventory
                    ";
// execute the SQL statement
$result = $mysqli->query($sql_renametables);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table renames - inventory: %s</br>\n", $result);
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

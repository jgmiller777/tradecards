<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB cardsDB Table Convert";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// Create new cardsDB table as cardsDB2 (renamed later)
$sql_createtable = "CREATE TABLE cardsDB2 (
    id                 bigint unsigned not null auto_increment
  , sportID            bigint unsigned not null
  , year               year            not null
  , brandID            bigint unsigned not null
  , seriesID           bigint unsigned not null
  , categoryID         bigint unsigned not null
  , subcategoryID      bigint unsigned
  , cardnbr            varchar(20)     not null
  , cardsubnbr         varchar(20)
  , playerID           bigint unsigned
  , playernameextID    bigint unsigned
  , teamID             bigint unsigned
  , serialnbr          int(6)
  , autograph          varchar(1)
  , rookiecard         varchar(1)
  , shortprint         varchar(50)
  , commentsID         bigint unsigned
  , date_added         datetime        not null
  , date_updated       datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxCardsDBcard (
                               sportID
                             , year
                             , brandID
                             , seriesID
                             , categoryID
                             , subcategoryID
                             , cardnbr
                             , cardsubnbr
                             , playerID
                             , teamID
                             , serialnbr 
                             , autograph
                              )
                  )";

// execute the SQL statement
$result = $mysqli->query($sql_createtable);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table create - cardsDB2: %s</p>\n", $result);
}

// ***** open current cardsDB table and build $sql insert stmt for new cardsDB table
$sql_oldtable = "SELECT * FROM cardsDB ORDER BY id";
$result = $mysqli->query ($sql_oldtable, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  $sql_newtable = "INSERT INTO"
      . " cardsDB2 (id
                  , sportID
                  , year
                  , brandID
                  , seriesID
                  , categoryID
                  , subcategoryID
                  , cardnbr
                  , cardsubnbr
                  , playerID
                  , playernameextID
                  , teamID
                  , serialnbr
                  , autograph
                  , rookiecard
                  , shortprint
                  , commentsID
                  , date_added
                  , date_updated
                   )"
      . " VALUES ";
  while ($row = $result->fetch_object ()) {
    $newcardnbr  = "";
    if (($row->subcategoryID == '674') and ($row->seriesID == '162')) {
        $newcardnbr .= "MDM-"
                    .  substr($row->cardnbr, 3);
    } else {
        if (($row->subcategoryID == '674') and ($row->seriesID == '163')) {
            $newcardnbr .= "MLBDM-"
                        .  substr($row->cardnbr, 5);
        } else {
            $newcardnbr .= $row->cardnbr;
        }
    }
    $sql_newtable .= "( "
                  . quote_value ($row->id)
           . ", " . quote_value ($row->sportID)
           . ", " . quote_value ($row->year)
           . ", " . quote_value ($row->brandID)
           . ", " . quote_value ($row->seriesID)
           . ", " . quote_value ($row->categoryID)
           . ", " . quote_value ($row->subcategoryID)
           . ", " . quote_value ($newcardnbr)
           . ", " . quote_value ($row->cardsubnbr)
           . ", " . quote_value ($row->playerID)
           . ", " . quote_value ($row->playernameextID)
           . ", " . quote_value ($row->teamID)
           . ", " . quote_value ($row->serialnbr) 
           . ", " . quote_value ($row->autograph)
           . ", " . quote_value ($row->rookiecard)
           . ", " . quote_value ($row->shortprint)
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
  printf ("<p>Table - cardsDB2: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// rename old cardsDB table
// rename new cardsDB table
$sql_renametables = "RENAME TABLE
                       cardsDB  TO cardsDBold
                     , cardsDB2 TO cardsDB
                    ";
// execute the SQL statement
$result = $mysqli->query($sql_renametables);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table renames - cardsDB: %s</br>\n", $result);
}

// query and display the >>> new <<< cardsDB table
printf ("<p>Displaying new cardsDB data</p>\n");
printf ("<p>
         id
       , sportID
       , year
       , brandID
       , seriesID
       , categoryID
       , subcategoryID
       , cardnbr
       , cardsubnbr
       , playerID
       , playernameextID
       , teamID
       , serialnbr
       , autograph
       , rookiecard
       , shortprint
       , commentsID
       , date_added
       , date_updated
         </p>\n"
       );
$sql_select = "SELECT * FROM cardsDB";
$result = $mysqli->query ($sql_select, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s</p>\n"
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
           , htmlspecialchars ($row->playernameextID)
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

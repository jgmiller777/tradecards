<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB inventory Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_inv = fopen ("../data/inventory.txt", "rt") 
                 or die ("<p class='fopen-error'>Cannot open inventory.txt.</p>\n");
if ($testmode) { printf ("<p>inventory.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  inventory (id
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
while (!feof ($fh_inv) ) {
  $line = fgets ($fh_inv);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $invID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($invID == "''") { $invID = "DEFAULT"; }
    
    // collectionID
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invusercollectionID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // cardsdbID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invcardsdbID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // cardconditionID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invcardconditionID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // numberown
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invnumberown = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($invnumberown == "''") { $invnumberown = quote_value (NULL); }
    
    // purchasedate
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invpurchasedate = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($invpurchasedate == "''") {
        $tempdate = getDateTime("Y/m/d H:i:s.u", "01/01/1970");
        $invpurchasedate = quote_value ($tempdate);
    }
    
    // purchaseprice
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invpurchaseprice = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($invpurchaseprice == "''") {
        $invpurchaseprice = quote_value ("0.00");
    }
    
    // serialnbr
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invserialnbr = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($invserialnbr == "''") { $invserialnbr = quote_value (NULL); }

    // commentsID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invcommentsID = quote_value (trim (substr($temp, 0, $semicolon_loc)));
    if ($invcommentsID == "''") { $invcommentsID = quote_value (NULL); }

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($invDateAdded == "''") { $invDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $invDateUpdated = quote_value (trim ($temp));
    if ($invDateUpdated == "''") { $invDateUpdated = quote_value ($tempdate); }

    $sql .= "( 
               $invID
             , $invusercollectionID
             , $invcardsdbID
             , $invcardconditionID
             , $invnumberown
             , $invpurchasedate
             , $invpurchaseprice
             , $invserialnbr
             , $invcommentsID
             , $invDateAdded
             , $invDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $invID
                            , $invusercollectionID
                            , $invcardsdbID
                            , $invcardconditionID
                            , $invnumberown
                            , $invpurchasedate
                            , $invpurchaseprice
                            , $invserialnbr
                            , $invcommentsID
                            , $invDateAdded
                            , $invDateUpdated
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
  printf ("<p>Table - inventory: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying inventory data</p>\n");
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
$sql = "SELECT * FROM inventory";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s, %s, %s, %s, %s</p>\n"
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

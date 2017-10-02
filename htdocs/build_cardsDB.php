<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB cardsDB Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_cardsDB = fopen ("../data/cardsDB.txt", "rt") 
                 or die ("<p class='fopen-error'>Cannot open cardsDB.txt.</p>\n");
if ($testmode) { printf ("<p>cardsDB.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  cardsDB (id
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
while (!feof ($fh_cardsDB) ) {
  $line = fgets ($fh_cardsDB);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $cardsDBID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($cardsDBID == "''") { $cardsDBID = "DEFAULT"; }
    
    // sportID
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBsportID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // year
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDByear = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDByear == "''") { $cardsDByear = quote_value (NULL); }
    
    // brandID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBbrandID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // seriesID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBseriesID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // categoryID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBcategoryID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // subcategoryID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBsubcategoryID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBsubcategoryID == "''") { $cardsDBsubcategoryID = quote_value (NULL); }
    
    // cardnbr
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBcardnbr = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // cardsubnbr
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBcardsubnbr = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBcardsubnbr == "''") { $cardsDBcardsubnbr = quote_value (NULL); }
    
    // playerID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBplayerID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // playernameextID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBplayernameextID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBplayernameextID == "''") { $cardsDBplayernameextID = quote_value (NULL); }
    
    // teamID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBteamID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBteamID == "''") { $cardsDBteamID = quote_value (NULL); }
    
    // serialnbr
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBserialnbr = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBserialnbr == "''") { $cardsDBserialnbr = quote_value (NULL); }
    
    // autograph
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBautograph = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBautograph == "''") { $cardsDBautograph = quote_value ("N"); }
    
    // rookiecard
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBrookiecard = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBrookiecard == "''") { $cardsDBrookiecard = quote_value (NULL); }
    
    // shortprint
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBshortprint = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBshortprint == "''") { $cardsDBshortprint = quote_value (NULL); }

    // commentsID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBcommentsID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBcommentsID == "''") { $cardsDBcommentsID = quote_value (NULL); }

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($cardsDBDateAdded == "''") { $cardsDBDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $cardsDBDateUpdated = quote_value (trim ($temp));
    if ($cardsDBDateUpdated == "''") { $cardsDBDateUpdated = quote_value ($tempdate); }

    $sql .= "( 
               $cardsDBID
             , $cardsDBsportID
             , $cardsDByear
             , $cardsDBbrandID
             , $cardsDBseriesID
             , $cardsDBcategoryID
             , $cardsDBsubcategoryID
             , $cardsDBcardnbr
             , $cardsDBcardsubnbr
             , $cardsDBplayerID
             , $cardsDBplayernameextID
             , $cardsDBteamID
             , $cardsDBserialnbr
             , $cardsDBautograph
             , $cardsDBrookiecard
             , $cardsDBshortprint
             , $cardsDBcommentsID
             , $cardsDBDateAdded
             , $cardsDBDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $cardsDBID
                            , $cardsDBsportID
                            , $cardsDByear
                            , $cardsDBbrandID
                            , $cardsDBseriesID
                            , $cardsDBcategoryID
                            , $cardsDBsubcategoryID
                            , $cardsDBcardnbr
                            , $cardsDBcardsubnbr
                            , $cardsDBplayerID
                            , $cardsDBplayernameextID
                            , $cardsDBteamID
                            , $cardsDBserialnbr
                            , $cardsDBautograph
                            , $cardsDBrookiecard
                            , $cardsDBshortprint
                            , $cardsDBcommentsID
                            , $cardsDBDateAdded
                            , $cardsDBDateUpdated
                            );
    }
  }
}

$sql = substr ($sql, 0, -2); // get rid of last two characters from $sql string
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table - cardsDB: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying cardsDB data</p>\n");
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
$sql = "SELECT * FROM cardsDB";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
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

<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Collection Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_collection = fopen ("../data/collection.txt", "rt") 
                 or die ("<p class='fopen-error'>Cannot open collection.txt.</p>\n");
if ($testmode) { printf ("<p>collection.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  collection (id
		   , name
                   , createdbyID
                   , private
                   , date_added
                   , date_updated
                    )"
    . " VALUES ";
while (!feof ($fh_collection) ) {
  $line = fgets ($fh_collection);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $collectionID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($collectionID == "''") { $collectionID = "DEFAULT"; }
    
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $collectionName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    
    // createdbyID
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $collectionCreatedByID = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($collectionCreatedByID == "''") { $collectionCreatedByID = quote_value ("1"); }
    
    // private
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $collectionPrivate = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($collectionPrivate == "''") { $collectionPrivate = quote_value ("N"); }

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
               $collectionID
	     , $collectionName
             , $collectionCreatedByID
             , $collectionPrivate
             , $collectionDateAdded
             , $collectionDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $collectionID
                            , $collectionName
                            , $collectionCreatedByID
                            , $collectionPrivate
                            , $collectionDateAdded
                            , $collectionDateUpdated
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
  printf ("<p>Table - collection: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying collection data</p>\n");
printf ("<p>
         id
       , name
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM collection";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->createdbyID)
           , htmlspecialchars ($row->private)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ();

?>

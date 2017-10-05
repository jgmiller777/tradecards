<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Sub-Category Table Load";
$cssfile = "tradecards.css";
$xxx = "";

html_begin ($title, $header, $cssfile, $xxx);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_subcategory = fopen ("../data/subcategory.txt", "rt")
                  or die ("<p class='fopen-error'>Cannot open subcategory.txt.</p>\n");
if ($testmode) { printf ("<p>subcategory.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  subcategory (id
                    , name
                    , date_added
                    , date_updated
                     )"
    . " VALUES ";
while (!feof ($fh_subcategory) ) {
  $line = fgets ($fh_subcategory);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $subcategoryID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($subcategoryID == "''") { $subcategoryID = "DEFAULT"; }
    
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $subcategoryName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $subcategoryDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($subcategoryDateAdded == "''") { $subcategoryDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $subcategoryDateUpdated = quote_value (trim ($temp));
    if ($subcategoryDateUpdated == "''") { $subcategoryDateUpdated = quote_value ($tempdate); }

    $sql .= "( 
               $subcategoryID
             , $subcategoryName
             , $subcategoryDateAdded
             , $subcategoryDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s]</p>\n"
                            , substr($line, 0, -1)
                            , $subcategoryID
                            , $subcategoryName
                            , $subcategoryDateAdded
                            , $subcategoryDateUpdated
                   );
    }
  }
}

$sql = substr ($sql, 0, -2); // get rid of last two characters from $sql string

// execute the SQL statement
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }
$result = $mysqli->query ($sql);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  // echo the result identifier
  printf ("<p>Table - sub-category: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Sub-Category record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying subcategory data</p>\n");
printf ("<p>
         id
       , name
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM subcategory";
$result = $mysqli->query ($sql, MYSQLI_USE_RESULT);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s</p>\n"
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
}
$result->free_result ();

html_end ($xxx);

?>

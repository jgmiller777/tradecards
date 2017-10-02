<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Category Table Load";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// ***** open input file and build $sql statement
$fh_category = fopen ("../data/category.txt", "rt")
               or die ("<p class='fopen-error'>Cannot open category.txt.</p>\n");
if ($testmode) { printf ("<p>category.txt opened!</p>\n<br />\n"); }

$sql = "INSERT INTO"
    . "  category (id
                 , name
                 , date_added
                 , date_updated
                  )"
  . "  VALUES ";
while (!feof ($fh_category) ) {
  $line = fgets ($fh_category);
  if (strlen ($line) > 2) {
    // id
    $semicolon_loc = strpos ($line, ";");
    $categoryID = quote_value (trim (substr ($line, 0, $semicolon_loc)));
    if ($categoryID == "''") { $categoryID = "DEFAULT"; }
    
    // name
    $temp = substr ($line, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $categoryName = quote_value (trim (substr ($temp, 0, $semicolon_loc)));

    $tempdate = getDateTime("Y/m/d H:i:s.u");

    // date_added
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $categoryDateAdded = quote_value (trim (substr ($temp, 0, $semicolon_loc)));
    if ($categoryDateAdded == "''") { $categoryDateAdded = quote_value ($tempdate); }

    // date_updated
    $temp = substr ($temp, $semicolon_loc + 1);
    $semicolon_loc = strpos ($temp, ";");
    $categoryDateUpdated = quote_value (trim ($temp));
    if ($categoryDateUpdated == "''") { $categoryDateUpdated = quote_value ($tempdate); }

    $sql .= "(
               $categoryID
             , $categoryName
             , $categoryDateAdded
             , $categoryDateUpdated
             ), ";

    if ($testmode) { printf ("<p>%s [%s] [%s] [%s] [%s]</p>\n"
                            , substr ($line, 0, -1)
                            , $categoryID
                            , $categoryName
                            , $categoryDateAdded
                            , $categoryDateUpdated
                            );
    }
  }
}

$sql = substr ($sql, 0, -2); // get rid of last two characters from $sql string just built

// execute the SQL statement
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

//$result = mysql_query ($sql, $conn) or die (mysql_errno() . " - " . mysql_error());
$result = $mysqli->query ($sql);
if (!$result) {
  die (showMySQLerror ($mysqli));
} else {
  // echo the result identifier
  printf ("<p>Table - category: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Category record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// query and display the table
printf ("<p>Displaying category data</p>\n");
printf ("<p>
         id
       , name
       , date_added
       , date_updated
         </p>\n"
       );
$sql = "SELECT * FROM category";
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
mysql_free_result ($result);

html_end ();

?>

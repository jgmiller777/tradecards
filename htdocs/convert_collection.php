<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB collection Table Convert";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");

// Create new collection table as collection2 (renamed later)
$sql_createtable = "CREATE TABLE collection2 (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , createdbyID      bigint unsigned not null
  , private          varchar(1)      not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , INDEX idxCollectionName (name)
                  )";

// execute the SQL statement
$result = $mysqli->query($sql_createtable);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table create - collection2: %s</p>\n", $result);
}

// ***** open current collection table and build $sql insert stmt for new collection table
$sql_oldtable = "SELECT * FROM collection ORDER BY id";
$result = $mysqli->query ($sql_oldtable, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  $sql_newtable = "INSERT INTO"
      . " collection2 (id
		  , name
                  , createdbyID
                  , private
                  , date_added
                  , date_updated
                   )"
      . " VALUES ";
  while ($row = $result->fetch_object ()) {
    $sql_newtable .= "( "
                  . quote_value ($row->id)
           . ", " . quote_value ($row->name)
	   . ", " . quote_value ('1')
	   . ", " . quote_value ($row->private)
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
  printf ("<p>Table - collection2: %s</br>\n", $result);
  // echo the number of records added 
  printf ("<p>Table record/s added: %d</p>\n<br />\n", $mysqli->affected_rows);
}

// rename old collection table
// rename new collection table
$sql_renametables = "RENAME TABLE
                       collection  TO collectionold
                     , collection2 TO collection
                    ";
// execute the SQL statement
$result = $mysqli->query($sql_renametables);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  // echo the result identifier
  printf ("<p>Table renames - collection: %s</br>\n", $result);
}

// query and display the >>> new <<< collection table
printf ("<p>Displaying new collection data</p>\n");
printf ("<p>
         id
       , name
       , createdbyID
       , private
       , date_added
       , date_updated
         </p>\n"
       );
$sql_select = "SELECT * FROM collection";
$result = $mysqli->query ($sql_select, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  while ($row = $result->fetch_object ()) {
    printf ("<p>%s, %s, %s, %s, %s, %s</p>\n"
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

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

// ***** open current cardsDB table and build $sql update stmt
$sql_oldtable = "SELECT * FROM cardsDB ORDER BY id";
$result = $mysqli->query ($sql_oldtable, MYSQLI_USE_RESULT);
if (!$result) {
    printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
    exit (1);
} else {
  $sql_replace = "REPLACE INTO cardsDB (id, "
                                     . "sportID, "
                                     . "year, "
                                     . "brandID, "
                                     . "seriesID, "
                                     . "categoryID, "
                                     . "subcategoryID, "
                                     . "cardnbr, "
                                     . "cardsubnbr, "
                                     . "playerID, "
                                     . "playernameextID, "
                                     . "teamID, "
                                     . "serialnbr, "
                                     . "autograph, "
                                     . "rookiecard, "
                                     . "shortprint, "
                                     . "commentsID, "
                                     . "date_added, "
                                     . "date_updated"
                                     . ") VALUES ";
  $tempdate = getDateTime("Y/m/d H:i:s.u");
  // printf ("<h2>Changed</h2>");
  while ($row = $result->fetch_object ()) {
    // $temp = strpos ($row->name, " Cards");
    // if (!$temp) {
    if (!($row->id > 815)) {
      // $notchanged .= "<p>["
      //             . $row->id
      //             . "] - ["
      //             . $row->name
      //             . "]</p>\n"
      //             ;
    } else {
      // $newname = str_replace (" Cards", "", $row->name);
      // printf ("<p>[%s] - [%s] - [%s]</p>\n", $row->id, $row->name, $newname);
      $newid = ($row->id - 514);
      printf ("<p>[%s] - [%s]</p>\n", $row->id, $newid);
      $sql_replace .= ""
                   .  "("
                   .  quote_value($newid)
                   .  ", "
                   .  quote_value($row->sportID)
                   .  ", "
                   .  quote_value($row->year)
                   .  ", "
                   .  quote_value($row->brandID)
                   .  ", "
                   .  quote_value($row->seriesID)
                   .  ", "
                   .  quote_value($row->categoryID)
                   .  ", "
                   .  quote_value($row->subcategoryID)
                   .  ", "
                   .  quote_value($row->cardnbr)
                   .  ", "
                   .  quote_value($row->cardsubnbr)
                   .  ", "
                   .  quote_value($row->playerID)
                   .  ", "
                   .  quote_value($row->playernameextID)
                   .  ", "
                   .  quote_value($row->teamID)
                   .  ", "
                   .  quote_value($row->serialnbr)
                   .  ", "
                   .  quote_value($row->autograph)
                   .  ", "
                   .  quote_value($row->rookiecard)
                   .  ", "
                   .  quote_value($row->shortprint)
                   .  ", "
                   .  quote_value($row->commentsID)
                   .  ", "
                   .  quote_value($row->date_added)
                   .  ", "
                   .  quote_value($tempdate)
                   .  "), "
                   ;
    }
  }

  // get rid of last two characters from $sql string
  $sql_replace = substr ($sql_replace, 0, -2);
  if ($testmode) { printf ("<p>%s</p>\n", $sql_replace); }

  // execute the SQL statement
  $result = $mysqli->query($sql_replace);
  if (!$result) {
      printf ("<p>%s</p>\n", showMySQLerror ($mysqli));
      exit (1);
  } else {
    // echo the result identifier
    printf ("<p>Table - cardsDB: %s</br>\n", $result);
    // echo the number of records replaced 
    printf ("<p>Table record/s replaced (i.e., deleted/inserted): %d</p>\n<br />\n", $mysqli->affected_rows);
  }

  // printf ("<h2>Not changed</h2> %s", $notchanged);
}

$result->free_result ();

html_end ();

?>

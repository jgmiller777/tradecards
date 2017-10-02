<?php

error_reporting (E_ALL);
$testmode = TRUE;

// ***** open the connection and database *****
include("../include/inc_mysqlconnect_tradecards.php");
include("../include/inc_stuff.php");

// @date_default_timezone_set (@date_default_timezone_get());
// @date_default_timezone_set ("America/Chicago");
$date = new DateTime ("now");
$date_fmtd = $date->format("Y/m/d H:i:s T");

$title = "Baseball Cards Database - form testing";
$header = "";
//html_begin ($title, $header);

if ($testmode) { printf ("%s\n", date_default_timezone_get()); }

//

//form_begin ();

printf ("<p>Collection      <input type='text' name='usercollectionID'  size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Sport           <input type='text' name='sportID'           size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Year            <input type='text' name='cardYear'          size='4'  maxlength='4'           /></p>\n"                          );
printf ("<p>Brand           <input type='text' name='brandID'           size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Series          <input type='text' name='seriesID'          size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Category        <input type='text' name='categoryID'        size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Sub Category    <input type='text' name='subcategoryID'     size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Card Number     <input type='text' name='cardnbr'           size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Card Sub Number <input type='text' name='cardsubnbr'        size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Condition       <input type='text' name='conditionID'       size='10' maxlength='10'          /></p>\n"                          );
printf ("<p>Player Name     <input type='text' name='playerID'          size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Team Name       <input type='text' name='teamID'            size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Quantity        <input type='text' name='numberOwn'         size='10' maxlength='15'          /></p>\n"                          );
printf ("<p>Purchase Date   <input type='text' name='purchaseDate'      size='25' maxlength='25' value=%s /></p>\n", quote_value ($date_fmtd));
printf ("<p>Purchase Price  <input type='text' name='purchasePrice'     size='10' maxlength='15'          /></p>\n"                          );
printf ("<p>Comments        <input type='text' name='commentsID'        size='15' maxlength='80'          /></p>\n"                          );
printf ("<p>Date Added      <input type='text' name='dateAdded'         size='25' maxlength='25' value=%s />    \n", quote_value ($date_fmtd));
printf ("   Date Updated    <input type='text' name='dateUpdated'       size='25' maxlength='25' value=%s /></p>\n", quote_value ($date_fmtd));

//form_end ();

//html_end ();

?>

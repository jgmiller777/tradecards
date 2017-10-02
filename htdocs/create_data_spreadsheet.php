<?php

// TODO Review http://php.net/manual/en/function.error-reporting.php
// TODO for possible changes on how to report errors in a test environment
//
// TODO what's the difference between fetch_row vs. fetch_object?
//      Change fetch_row to $result->fetch_object and don't use $a $b ... variables
//      but use $row-> ... column names?
//      This would simplify the while () line.
//
error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards - Spreadsheet Data";
$header = "Create data files for spreadsheet import";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

if ($testmode) { 
  printf ("<p>Starting up...</p>\n");
  // *** for now, timezone is set in php.ini file ***
  if (date_default_timezone_get()) {
    printf ("<p>date_default_timezone_set: "
          . date_default_timezone_get()
          . "</p>\n"
           );
  }
}

// ***** open the connection and database *****--------------------------------------
include("../include/inc_mysqlconnect_tradecards.php");

// query and build the file ---------------------------------------------------- user
$sql = "SELECT * FROM user ORDER BY userID";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "user.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "userID"
        . ";" . "id"
        . ";" . "name"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d, $e) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";" . ""  . ($c)
          . ";"       . ($d)
          . ";"       . ($e)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file ---------------------------------------------- collection
$sql = "SELECT * FROM collection ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "collection.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "createdbyID"
        . ";" . "private"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;
 
  while (list ($a, $b, $c, $d, $e, $f) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . ";"       . ($e)
          . ";"       . ($f)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file ------------------------------------------ usercollection
$sql = "SELECT
         UC.id
        , UC.userID
        , U.userid
        , UC.collectionID
        , C.name
        , UC.date_added
        , UC.date_updated
        FROM usercollection UC
        LEFT JOIN (user U)
          ON UC.userID = U.id
        LEFT JOIN (collection C)
          ON UC.collectionID = C.id
        ORDER BY
          U.userid
        , C.name
       ";

$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "usercollection.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "userID name"
        . ";" . "userID"
        . ";" . "collection name"
        . ";" . "collectionID"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d, $e, $f, $g) = mysqli_fetch_row ($result)) {
    // $c and $b before $a is on purpose in the following
    // $c is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($c)
          . ";"       . ($b)
          . ";" . ""  . ($e)
          . ";"       . ($d)
          . ";"       . ($a)
          . ";"       . ($f)
          . ";"       . ($g)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file --------------------------------------------------- sport
$sql = "SELECT * FROM sport ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "sport.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file --------------------------------------------------- brand
$sql = "SELECT * FROM brand ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "brand.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file -------------------------------------------------- series
$sql = "SELECT * FROM series ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "series.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file -------------------------------------------------- category
$sql = "SELECT * FROM category ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "category.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file --------------------------------------------- subcategory
$sql = "SELECT * FROM subcategory ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "subcategory.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file -------------------------------------------------- player
$sql = "SELECT * FROM player ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "player.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "rookie year"
        . ";" . "career"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d, $e, $f) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . ";"       . ($e)
          . ";"       . ($f)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file ------------------------------------ extended player name
$sql = "SELECT * FROM playernameext ORDER BY extname";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "playernameext.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "extname"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file ---------------------------------------------------- team
$sql = "SELECT
         team.id
        , team.name
        , team.established_yr
        , team.sportID
        , S.name
        , team.priornameID
        , T2.name
        , team.date_added
        , team.date_updated 
        FROM team
        LEFT JOIN (sport S)
          ON team.sportID = S.id
        LEFT JOIN (team T2)
          ON team.priornameid = T2.id
        ORDER BY
          team.name
       ";

// if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "team.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "established yr"
        . ";" . "sportID"
        . ";" . "sport name"
        . ";" . "priornameID"
        . ";" . "prior team name"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d, $e, $f, $g, $h, $i) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . ";"       . ($e)
          . ";"       . ($f)
          . ";"       . ($g)
          . ";"       . ($h)
          . ";"       . ($i)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file ------------------------------------------- cardcondition
$sql = "SELECT * FROM cardcondition";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "cardcondition.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed!</h3>\n", $filename);
  }
}

// query and build the file ------------------------------------------------ comments
$sql = "SELECT * FROM comments";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = "comments.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] file data - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4spreadsheet/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s opened!</h3>\n", $filename);
  }

  $line = ""
              . "name"
        . ";" . "id"
        . ";" . "description"
        . ";" . "date_added"
        . ";" . "date_updated"
        . "\n"
        ;

  while (list ($a, $b, $c, $d) = mysqli_fetch_row ($result)) {
    // $b before $a is on purpose in the following
    // $b is lookup column in spreadsheet's vlookup function
    $line .= "" 
                . ""  . ($b)
          . ";"       . ($a)
          . ";"       . ($c)
          . ";"       . ($d)
          . ";"       . ($e)
          . "\n"
          ;
  }
  $result->free_result ();

  if (!(fwrite ($fh, $line))) {
    printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
    exit (1);
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='spreadsheetlookup'>%s closed! </h3>\n", $filename);
  }
}

// query and build the file ------------------------------------------------- cardsDB
$sql = "SELECT
          cardsDB.id
        , cardsDB.sportID
        , Spo.name
        , cardsDB.year
        , cardsDB.brandID
        , Bra.name
        , cardsDB.seriesID
        , Ser.name
        , cardsDB.categoryID
        , Cat.name
        , cardsDB.subcategoryID
        , SuCat.name
        , cardsDB.cardnbr
        , cardsDB.cardsubnbr
        , cardsDB.playerID
        , Pla.name
        , cardsDB.playernameextID
        , PNE.extname
        , cardsDB.teamID
        , Tea.name
        , cardsDB.serialnbr
        , cardsDB.autograph
        , cardsDB.rookiecard
        , cardsDB.shortprint
        , cardsDB.commentsID
        , Com.description
        , cardsDB.date_added
        , cardsDB.date_updated
        FROM cardsDB
        LEFT JOIN (sport Spo)
          ON (cardsDB.sportID = Spo.id)
        LEFT JOIN (brand Bra)
          ON (cardsDB.brandID = Bra.id)
        LEFT JOIN (series Ser)
          ON (cardsDB.seriesID = Ser.id)
        LEFT JOIN (category Cat)
          ON (cardsDB.categoryID = Cat.id)
        LEFT JOIN (subcategory SuCat)
          ON (cardsDB.subcategoryID = SuCat.id)
        LEFT JOIN (player Pla)
          ON (cardsDB.playerID = Pla.id)
        LEFT JOIN (playernameext PNE)
          ON (cardsDB.playernameextID = PNE.id)
        LEFT JOIN (team Tea)
          ON (cardsDB.teamID = Tea.id)
        LEFT JOIN (comments Com)
          ON (cardsDB.commentsID = Com.id)
       ";

// if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
}
else {
  printf ("\n");
  printf ("<h2>Creating [cardsDB] file data - %d</h2>\n"
         , $mysqli->affected_rows);
  printf ("
           <p class='spreadsheetlookup'>Spreadsheet lookup for this table not needed at this time.</p>
          "
         );

  // while (list ($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v, $w, $x, $y, $z, $aa, $ab) = mysqli_fetch_row ($result)) {
  // }
  $result->free_result ();
}

// query and build the file ----------------------------------------------- inventory
$sql = "SELECT
          inv.id
        , inv.usercollectionID
        , UC.userID
        , USER.userID
        , UC.collectionID
        , COLL.name
        , inv.cardsdbID
        , inv.cardconditionID
        , CC.name
        , inv.numberown
        , inv.purchasedate
        , inv.purchaseprice
        , inv.serialnbr
        , inv.commentsID
        , COMM.description
        , inv.date_added
        , inv.date_updated
        FROM inventory inv
        LEFT JOIN (usercollection UC
                   LEFT JOIN (user USER)
                     ON UC.userID = USER.id
                   LEFT JOIN (collection COLL)
                     ON UC.collectionID = COLL.id)
          ON (inv.usercollectionID = UC.id)
        LEFT JOIN (cardcondition CC)
          ON (inv.cardconditionID = CC.id)
        LEFT JOIN (comments COMM)
          on (inv.commentsID = COMM.id)
       ";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
}
else {
  printf ("\n");
  printf ("<h2>Creating [inventory] file data - %d</h2>\n"
         , $mysqli->affected_rows);
  printf ("
           <p class='spreadsheetlookup'>Spreadsheet lookup for this table not needed at this time.</p>
          "
         );

  while (list ($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q) = mysqli_fetch_row ($result)) {
  }
  $result->free_result ();
}

html_end ();

?>

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

$title = "Trading Cards - Backup Data";
$header = "Create data files for backup";
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

$jgmDate = new DateTime();
$currentYmdDate = $jgmDate->format("Y-m-d");

// ***** open the connection and database *****--------------------------------------
include("../include/inc_mysqlconnect_tradecards.php");

// query and backup the file --------------------------------------------------- user
$sql = "SELECT * FROM user ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "user.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
          $line .= ""
                .        ($row->id)
                .  ";" . ($row->userID)
                .  ";" . ($row->name)
                .  ";" . ($row->date_added)
                .  ";" . ($row->date_updated)
                .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file --------------------------------------------- collection
$sql = "SELECT * FROM collection ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "collection.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
          $line .= ""
                .        ($row->id)
                .  ";" . ($row->name)
                .  ";" . ($row->createdbyID)
                .  ";" . ($row->private)
                .  ";" . ($row->date_added)
                .  ";" . ($row->date_updated)
                .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ----------------------------------------- usercollection
$sql = "SELECT * FROM usercollection ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "usercollection.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->userID)
               .  ";" . ($row->collectionID)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file -------------------------------------------------- sport
$sql = "SELECT * FROM sport ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "sport.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file -------------------------------------------------- brand
$sql = "SELECT * FROM brand ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "brand.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ------------------------------------------------- series
$sql = "SELECT * FROM series ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "series.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ------------------------------------------------- category
$sql = "SELECT * FROM category ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "category.txt";

  printf ("\n");
  printf ("<h2>Creating [%scategory] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file -------------------------------------------- subcategory
$sql = "SELECT * FROM subcategory ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "subcategory.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ------------------------------------------------- player
$sql = "SELECT * FROM player ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "player.txt";
  
  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->rookie_yr)
               .  ";" . ($row->career)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ----------------------------------- extended player name
$sql = "SELECT * FROM playernameext ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "playernameext.txt";
  
  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->extname)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
               ;
  }
  $result->free_result ();

  // todo add the following strlen () check to the other sections
  if (strlen ($line) > 0) {
    if (!(fwrite ($fh, $line))) {
      printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $filename);
      exit (1);
    }
  }
  if (!(fclose ($fh))) {
    printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file --------------------------------------------------- team
$sql = "SELECT * FROM team ORDER BY id";

$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "team.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->established_yr)
               .  ";" . ($row->sportID)
               .  ";" . ($row->priornameID)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ------------------------------------------ cardcondition
$sql = "SELECT * FROM cardcondition ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "cardcondition.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->name)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
  }
}

// query and backup the file ----------------------------------------------- comments
$sql = "SELECT * FROM comments ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $filename = $currentYmdDate . " " . "comments.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->description)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed! </h3>\n", $filename);
  }
}

// query and backup the file ------------------------------------------------ cardsDB
$sql = "SELECT * FROM cardsDB ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
}
else {
  $filename = $currentYmdDate . " " . "cardsDB.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->sportID)
               .  ";" . ($row->year)
               .  ";" . ($row->brandID)
               .  ";" . ($row->seriesID)
               .  ";" . ($row->categoryID)
               .  ";" . ($row->subcategoryID)
               .  ";" . ($row->cardnbr)
               .  ";" . ($row->cardsubnbr)
               .  ";" . ($row->playerID)
               .  ";" . ($row->playernameextID)
               .  ";" . ($row->teamID)
               .  ";" . ($row->serialnbr)
               .  ";" . ($row->autograph)
               .  ";" . ($row->rookiecard)
               .  ";" . ($row->shortprint)
               .  ";" . ($row->commentsID)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed! </h3>\n", $filename);
  }
}

// query and backup the file ---------------------------------------------- inventory
$sql = "SELECT * FROM inventory ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
}
else {
  $filename = $currentYmdDate . " " . "inventory.txt";

  printf ("\n");
  printf ("<h2>Creating [%s] backup file - %d</h2>\n"
         , $filename
         , $mysqli->affected_rows);

  if (!($fh = fopen ("../data4backup/" . $filename, "wt"))) {
    printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $filename);
    exit (1);
  } else {
    printf ("<h3 class='filebackup'>%s opened!</h3>\n", $filename);
  }

  $line = "";
  while ($row = $result->fetch_object ()) {
         $line .= ""
               .        ($row->id)
               .  ";" . ($row->usercollectionID)
               .  ";" . ($row->cardsdbID)
               .  ";" . ($row->cardconditionID)
               .  ";" . ($row->numberown)
               .  ";" . ($row->purchasedate)
               .  ";" . ($row->purchaseprice)
               .  ";" . ($row->serialnbr)
               .  ";" . ($row->commentsID)
               .  ";" . ($row->date_added)
               .  ";" . ($row->date_updated)
               .  "\n"
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
    printf ("<h3 class='filebackup'>%s closed! </h3>\n", $filename);
  }
}

html_end ();

?>

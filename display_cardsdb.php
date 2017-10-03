<?php

// TODO Review http://php.net/manual/en/function.error-reporting.php
// TODO for possible changes on how to report errors in a test environment
//
// TODO consider changing printf statements to "$html .= " statements so
//      that its contents can be written to a file for debugging purposes.
//      Apparently, with the way I built the WHERE clause, when i choose
//      the browser's option to 'view page source' I do not get any of 
//      the WHERE clause coding.
//
error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$starttime = getDateTime("Y/m/d H:i:s");

$title = "Trading Cards Database";
$header = "DB Tables Display";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

if ($testmode) { 
  printf ("<p>jgm3 Starting up...</p>\n");
  // *** for now, timezone is set in php.ini file ***
  if (date_default_timezone_get()) {
    printf ("<p>date_default_timezone_set: "
          . date_default_timezone_get() . "</p>\n");
  }
}

// ***** open the connection and database *****--------------------------------------
include("../include/inc_mysqlconnect_tradecards.php");

// initialize form variables
// TODO ??? use of cookies to store what was entered into the form fields and
//      then restore them the next time the page is opened ???
//
$frmSportText = "";
$frmYearText = "";
$frmBrandText = "";
$frmSeriesText = "";
$frmCategoryText = "";
$frmSubCategoryText = "";
$frmCardNbrText = "";
$frmCardSubNbrText = "";
$frmPlayerText = "";
$frmPNEText = "";
$frmCareerText = "";
$frmTeamText = "";
$frmSerialNbrText = "";
$frmAutoText = "";
$frmRCText = "";
$frmSPText = "";
$nbrWhereConditions = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // TODO need to 'sanitize' data coming from $_POST array before using
  //
  // Short Print
  if (!empty($_POST["frmSPText"])) {
    $frmSPText = ($_POST["frmSPText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[\/a-zA-Z0-9' ]*$/", $frmSPText)) {
      $frmErrMsg = "- Only letters, numbers and slash allowed in Short Print";
    }
  }
  // Rookie Card
  if (!empty($_POST["frmRCText"])) {
    $frmRCText = ($_POST["frmRCText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[ynYN?]*$/", $frmRCText)) {
      $frmErrMsg = "- Only ?ynYN allowed in Rookie Card";
    }
  }
  // Autograph
  if (!empty($_POST["frmAutoText"])) {
    $frmAutoText = ($_POST["frmAutoText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[ynYN]*$/", $frmAutoText)) {
      $frmErrMsg = "- Only ynYN allowed in Autograph";
    }
  }
  // Serial Nbrd
  if (!empty($_POST["frmSerialNbrText"])) {
    $frmSerialNbrText = ($_POST["frmSerialNbrText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9-]*$/", $frmSerialNbrText)) {
      $frmErrMsg = "- Only numbers, letters and dash allowed in Serial Numbered";
    }
  }
  // Team
  if (!empty($_POST["frmTeamText"])) {
    $frmTeamText = ($_POST["frmTeamText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9-]*$/", $frmTeamText)) {
      $frmErrMsg = "- Only numbers, letters and dash allowed in Team";
    }
  }
  // Player Career
  if (!empty($_POST["frmCareerText"])) {
    $frmCareerText = ($_POST["frmCareerText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $frmCareerText)) {
      $frmErrMsg = "- Only numbers and letters allowed in Career";
    }
  }
  // Player Name Ext
  if (!empty($_POST["frmPNEText"])) {
    $frmPNEText = ($_POST["frmPNEText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9-]*$/", $frmPNEText)) {
      $frmErrMsg = "- Only numbers, letters and dash allowed in Player Name Extension";
    }
  }
  // Player
  if (!empty($_POST["frmPlayerText"])) {
    $frmPlayerText = ($_POST["frmPlayerText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9-]*$/", $frmPlayerText)) {
      $frmErrMsg = "- Only numbers, letters and dash allowed in Player";
    }
  }
  // Card Sub Nbr
  if (!empty($_POST["frmCardSubNbrText"])) {
    $frmCardSubNbrText = ($_POST["frmCardSubNbrText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9-]*$/", $frmCardSubNbrText)) {
      $frmErrMsg = "- Only numbers, letters and dash allowed in CardSubNbr";
    }
  }
  // Card Nbr
  if (!empty($_POST["frmCardNbrText"])) {
    $frmCardNbrText = ($_POST["frmCardNbrText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $frmCardNbrText)) {
      $frmErrMsg = "- Only numbers and letters allowed in CardNbr";
    }
  }
  // SubCategory
  if (!empty($_POST["frmSubCategoryText"])) {
    $frmSubCategoryText = ($_POST["frmSubCategoryText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $frmSubCategoryText)) {
      $frmErrMsg = "- Only letters and numbers allowed in SubCategory";
    }
  }
  // Category
  if (!empty($_POST["frmCategoryText"])) {
    $frmCategoryText = ($_POST["frmCategoryText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $frmCategoryText)) {
      $frmErrMsg = "- Only letters and numbers allowed in Category";
    }
  }
  // Series
  if (!empty($_POST["frmSeriesText"])) {
    $frmSeriesText = ($_POST["frmSeriesText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $frmSeriesText)) {
      $frmErrMsg = "- Only letters and numbers allowed in Series";
    }
  }
  // Brand
  if (!empty($_POST["frmBrandText"])) {
    $frmBrandText = ($_POST["frmBrandText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $frmBrandText)) {
      $frmErrMsg = "- Only letters and numbers allowed in Brand";
    }
  }
  // Year
  if (!empty($_POST["frmYearText"])) {
    $frmYearText = ($_POST["frmYearText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[0-9]*$/", $frmYearText)) {
      $frmErrMsg = "- Only numbers allowed in Year";
    }
  }
  // Sport
  if (!empty($_POST["frmSportText"])) {
    $frmSportText = ($_POST["frmSportText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $frmSportText)) {
      $frmErrMsg = "- Only letters and numbers allowed in Sport";
    }
  }
  if ($testmode) {
    printf ("<br /><p>Number of needed WHERE conditions - %s</p>\n", $nbrWhereConditions);
  }
}

// query and display the table ---------------------------------------------- cardsDB
$sql = "SELECT
          cardsDB.id              cardsDBid
        , cardsDB.sportID         cardsDBsportID
        , Spo.name                Sponame
        , cardsDB.year            cardsDByear
        , cardsDB.brandID         cardsDBbrandID
        , Bra.name                Braname
        , cardsDB.seriesID        cardsDBseriesID
        , Ser.name                Sername
        , cardsDB.categoryID      cardsDBcategoryID
        , Cat.name                Catname
        , cardsDB.subcategoryID   cardsDBsubcategoryID
        , SuCat.name              SuCatname
        , cardsDB.cardnbr         cardsDBcardnbr
        , cardsDB.cardsubnbr      cardsDBcardsubnbr
        , cardsDB.playerID        cardsDBplayerID
        , Pla.name                Planame
        , cardsDB.playernameextID cardsDBplayernameextID
        , PNE.extname             PNEextname
        , Pla.career              Placareer
        , cardsDB.teamID          cardsDBteamID
        , Tea.name                Teaname
        , cardsDB.serialnbr       cardsDBserialnbr
        , cardsDB.autograph       cardsDBautograph
        , cardsDB.rookiecard      cardsDBrookiecard
        , cardsDB.shortprint      cardsDBshortprint
        , cardsDB.commentsID      cardsDBcommentsID
        , Com.description         Comdescription
        , cardsDB.date_added      cardsDBdateadded
        , cardsDB.date_updated    cardsDBdateupdated
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
if ($nbrWhereConditions >= 1) {
  $sql .= " WHERE ";
  $and = "";
  if ($nbrWhereConditions > 1) { $and = " AND"; }
  // Sport
  if (!empty($frmSportText)) {
    $sql .= "(cardsDB.sportID = '" . $frmSportText . "')" . $and . " ";
  }
  // Year
  if (!empty($frmYearText)) {
    $sql .= "(cardsDB.year = '" . $frmYearText . "')" . $and . " ";
  }
  // Brand
  if (!empty($frmBrandText)) {
    $sql .= "(cardsDB.brandID = '" . $frmBrandText . "')" . $and . " ";
  }
  // Series
  if (!empty($frmSeriesText)) {
    $sql .= "(cardsDB.seriesID = '" . $frmSeriesText . "')" . $and . " ";
  }
  // Category
  if (!empty($frmCategoryText)) {
    $sql .= "(cardsDB.categoryID = '" . $frmCategoryText . "')" . $and . " ";
  }
  // SubCategory
  if (!empty($frmSubCategoryText)) {
    $sql .= "(cardsDB.subcategoryID = '" . $frmSubCategoryText . "')" . $and . " ";
  }
  // CardNbr
  if (!empty($frmCardNbrText)) {
    $sql .= "(cardsDB.cardnbr = '" . $frmCardNbrText . "')" . $and . " ";
  }
  // CardSubNbr
  if (!empty($frmCardSubNbrText)) {
    $sql .= "(cardsDB.cardsubnbr = '" . $frmCardSubNbrText . "')" . $and . " ";
  }
  // Player
  if (!empty($frmPlayerText)) {
    $sql .= "(cardsDB.playerID = '" . $frmPlayerText . "')" . $and . " ";
  }
  // Player Name Ext
  if (!empty($frmPNEText)) {
    $sql .= "(cardsDB.playernameextID = '" . $frmPNEText . "')" . $and . " ";
  }
  // Player Career
  if (!empty($frmCareerText)) {
    $sql .= "(Pla.career = '" . $frmCareerText . "')" . $and . " ";
  }
  // Team
  if (!empty($frmTeamText)) {
    $sql .= "(cardsDB.teamID = '" . $frmTeamText . "')" . $and . " ";
  }
  // Serial Nbrd
  if (!empty($frmSerialNbrText)) {
    $sql .= "(cardsDB.serialnbr = '" . $frmSerialNbrText . "')" . $and . " ";
  }
  // Autograph
  if (!empty($frmAutoText)) {
    $sql .= "(cardsDB.autograph = '" . $frmAutoText . "')" . $and . " ";
  }
  // Rookie Card
  if (!empty($frmRCText)) {
    $sql .= "(cardsDB.rookiecard = '" . $frmRCText . "')" . $and . " ";
  }
  // Short Print
  if (!empty($frmSPText)) {
    $sql .= "(cardsDB.shortprint = \"" . $frmSPText . "\")" . $and . " ";
  }
  // Get rid of last five characters (i.e., " AND ") in $sql string
  if ($nbrWhereConditions > 1) {
    $sql = substr ($sql, 0, -5);
  }
}
// if $needOrderByClause
$sql .= "
        ORDER BY
          cardsDB.id
        ";
if ($testmode) { printf ("<br />\n<p>%s</p>\n<br />\n", $sql); }

$lbShortPrint = selectDistinct ($mysqli, "cardsDB", "shortprint", "shortprint", "frmSPText", $frmSPText);

// TODO ??? don't perform query if there's a frmErrMsg ???
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<form method='post' action='%s'>\n", htmlspecialchars($_SERVER["PHP_SELF"]));
  printf ("<h2>Displaying [cardsDB] table data - %d 
           <span class='frmError'>%s</span>
           <input type='submit' name='submit' value='Submit'></h2>\n"
         , $mysqli->affected_rows
         , $frmErrMsg
  );
           // <div class='HSB'>
  printf ("
           <div>
           <table>
             <tr>
               <th>id</th>
               <th>sport</th>
               <th>year</th>
               <th>brand</th>
               <th>series</th>
               <th>category</th>
               <th>sub category</th>
               <th>card nbr</th>
               <th>sub nbr</th>
               <th>player</th>
               <th>player name ext (career)</th>
               <th>team</th>
               <th>serial numbered</th>
               <th>autograph</th>
               <th>rookie card</th>
               <th>short print</th>
               <th>comments</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
             <tr>
               <th></th>
               <th>
                   <input class='center' type='text' size='1' maxlength='1' id='%s' name='frmSportText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='4' maxlength='4' id='%s' name='frmYearText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='4' maxlength='4' id='%s' name='frmBrandText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='4' maxlength='4' id='%s' name='frmSeriesText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='4' maxlength='4' id='%s' name='frmCategoryText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='4' maxlength='4' id='%s' name='frmSubCategoryText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='10' maxlength='10' id='%s' name='frmCardNbrText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='5' maxlength='5' id='%s' name='frmCardSubNbrText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='10' maxlength='10' id='%s' name='frmPlayerText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='10' maxlength='10' id='%s' name='frmPNEText' value='%s'>
                   <br />
                   <input class='center' type='text' size='15' maxlength='15' id='%s' name='frmCareerText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='10' maxlength='10' id='%s' name='frmTeamText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='10' maxlength='10' id='%s' name='frmSerialNbrText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='1' maxlength='1' id='%s' name='frmAutoText' value='%s'>
               </th>
               <th>
                   <input class='center' type='text' size='1' maxlength='1' id='%s' name='frmRCText' value='%s'>
               </th>
               <th>
                   %s
               </th>
               <th></th>
               <th></th>
               <th></th>
             </tr>
          "
          , $frmSportText
          , $frmSportText
          , $frmYearText
          , $frmYearText
          , $frmBrandText
          , $frmBrandText
          , $frmSeriesText
          , $frmSeriesText
          , $frmCategoryText
          , $frmCategoryText
          , $frmSubCategoryText
          , $frmSubCategoryText
          , $frmCardNbrText
          , $frmCardNbrText
          , $frmCardSubNbrText
          , $frmCardSubNbrText
          , $frmPlayerText
          , $frmPlayerText
          , $frmPNEText
          , $frmPNEText
          , $frmCareerText
          , $frmCareerText
          , $frmTeamText
          , $frmTeamText
          , $frmSerialNbrText
          , $frmSerialNbrText
          , $frmAutoText
          , $frmAutoText
          , $frmRCText
          , $frmRCText
          , $lbShortPrint
  );
  printf ("</form>\n");  
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>cardsDB</span></div></td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center'>%s</td>
               <td class='center joinedColumn'><div class='tooltip'>%s (%s)<span class='tooltiptext'>brand</span></div></td>
               <td class='center joinedColumn'><div class='tooltip'>%s (%s)<span class='tooltiptext'>series</span></div></td>
               <td class='center joinedColumn'><div class='tooltip'>%s (%s)<span class='tooltiptext'>category</span></div></td>
               <td class='center joinedColumn'><div class='tooltip'>%s (%s)<span class='tooltiptext'>subcategory</span></div></td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center joinedColumn'>[%s] (%s) (%s)</div></td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>serial numbered?</span></div></td>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>autographed?</span></div></td>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>rookie card?</span></div></td>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>short printed?</span></div></td>
               <td class='center joinedColumn'>%s - %s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->cardsDBid)
           , htmlspecialchars ($row->cardsDBsportID)
           , htmlspecialchars ($row->Sponame)
           , htmlspecialchars ($row->cardsDByear)
           , htmlspecialchars ($row->cardsDBbrandID)
           , htmlspecialchars ($row->Braname)
           , htmlspecialchars ($row->cardsDBseriesID)
           , htmlspecialchars ($row->Sername)
           , htmlspecialchars ($row->cardsDBcategoryID)
           , htmlspecialchars ($row->Catname)
           , htmlspecialchars ($row->cardsDBsubcategoryID)
           , htmlspecialchars ($row->SuCatname)
           , htmlspecialchars ($row->cardsDBcardnbr)
           , htmlspecialchars ($row->cardsDBcardsubnbr)
           , htmlspecialchars ($row->cardsDBplayerID)
           , htmlspecialchars ($row->Planame)
           , htmlspecialchars ($row->cardsDBplayernameextID)
           , htmlspecialchars ($row->PNEextname)
           , htmlspecialchars ($row->Placareer)
           , htmlspecialchars ($row->cardsDBteamID)
           , htmlspecialchars ($row->Teaname)
           , htmlspecialchars ($row->cardsDBserialnbr)
           , htmlspecialchars ($row->cardsDBautograph)
           , htmlspecialchars ($row->cardsDBrookiecard)
           , htmlspecialchars ($row->cardsDBshortprint)
           , htmlspecialchars ($row->cardsDBcommentsID)
           , htmlspecialchars ($row->Comdescription)
           , htmlspecialchars ($row->cardsDBdateadded)
           , htmlspecialchars ($row->cardsDBdateupdated)
    );
  }
  printf ("
           </table>
           </div>
          "
  );
  $result->free_result ();
}

$endtime = getDateTime("Y/m/d H:i:s");

printf ("<br /><p>Start: %s --- End: %s</p>\n"
        , $starttime
        , $endtime
       );

html_end ();

?>

<?php

// TODO Review http://php.net/manual/en/function.error-reporting.php
// TODO for possible changes on how to report errors in a test environment
//
error_reporting (E_ALL);
$testmode = TRUE;
$testmode2 = TRUE;

include("../include/inc_stuff.php");

$starttime = getDateTime("Y/m/d H:i:s");

$title = "Trading Cards Database";
$header = "cardsDB Table Display";
$cssfile = "tradecards.css";
$htmlcode = "";
$html_file_name = "../html_output/html_display_cardsDB.txt";
$html_file_action = "X"; // default of don't write

// TODO
$xxx = "delete me later";
$htmlcode .= html_begin ($title, $header, $cssfile, $xxx);

if ($testmode) { 
  $htmlcode .= "<p>jgm6 Starting up...</p>\n";
  // *** for now, timezone is set in php.ini file ***
  if (date_default_timezone_get()) {
    $htmlcode .= "<p>date_default_timezone_set: "
              . date_default_timezone_get()
              . "</p>"
              . "\n"
    ;
  }
}

// ***** open the connection and database *****--------------------------------------
include("../include/inc_mysqlconnect_tradecards.php");

if ($testmode2) {
  $html_file_action = "I";
}
print_html ($htmlcode, $html_file_name, $html_file_action);

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
$frmTeamText = "1";
$frmSerialNbrText = "";
$frmAutoText = "";
$frmRCText = "";
$frmSPText = "";
$nbrWhereConditions = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Clearing previously set default values
  $frmTeamText = "";
  $nbrWhereConditions = 0;

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
  // SerialNbr
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
    if (!preg_match("/^[0-9]*$/", $frmTeamText)) {
      $frmErrMsg = "- Only numbers allowed in Team";
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
    if (!preg_match("/^[0-9]*$/", $frmPNEText)) {
      $frmErrMsg = "- Only numbers allowed in Player Name Extension";
    }
  }
  // Player
  if (!empty($_POST["frmPlayerText"])) {
    $frmPlayerText = ($_POST["frmPlayerText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[0-9]*$/", $frmPlayerText)) {
      $frmErrMsg = "- Only numbers allowed in Player";
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
    if (!preg_match("/^[0-9]*$/", $frmSubCategoryText)) {
      $frmErrMsg = "- Only numbers allowed in SubCategory";
    }
  }
  // Category
  if (!empty($_POST["frmCategoryText"])) {
    $frmCategoryText = ($_POST["frmCategoryText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[0-9]*$/", $frmCategoryText)) {
      $frmErrMsg = "- Only numbers allowed in Category";
    }
  }
  // Series
  if (!empty($_POST["frmSeriesText"])) {
    $frmSeriesText = ($_POST["frmSeriesText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[0-9]*$/", $frmSeriesText)) {
      $frmErrMsg = "- Only numbers allowed in Series";
    }
  }
  // Brand
  if (!empty($_POST["frmBrandText"])) {
    $frmBrandText = ($_POST["frmBrandText"]);
    ++$nbrWhereConditions;
    if (!preg_match("/^[0-9]*$/", $frmBrandText)) {
      $frmErrMsg = "- Only numbers allowed in Brand";
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
    if (!preg_match("/^[0-9]*$/", $frmSportText)) {
      $frmErrMsg = "- Only numbers allowed in Sport";
    }
  }
  if ($testmode) {
    $htmlcode .= "<p>Number of needed WHERE conditions - "
              . $nbrWhereConditions
              . "</p>"
              . "<br />"
              . "\n"
    ;
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
  $and = " ";
  if ($nbrWhereConditions > 1) { $and = " AND "; }
  // Sport
  if (!empty($frmSportText)) {
    $sql .= "(cardsDB.sportID = '{$frmSportText}'){$and}";
  }
  // Year
  if (!empty($frmYearText)) {
    $sql .= "(cardsDB.year = '{$frmYearText}'){$and}";
  }
  // Brand
  if (!empty($frmBrandText)) {
    $sql .= "(cardsDB.brandID = '{$frmBrandText}'){$and}";
  }
  // Series
  if (!empty($frmSeriesText)) {
    $sql .= "(cardsDB.seriesID = '{$frmSeriesText}'){$and}";
  }
  // Category
  if (!empty($frmCategoryText)) {
    $sql .= "(cardsDB.categoryID = '{$frmCategoryText}'){$and}";
  }
  // SubCategory
  if (!empty($frmSubCategoryText)) {
    $sql .= "(cardsDB.subcategoryID = '{$frmSubCategoryText}'){$and}";
  }
  // CardNbr
  if (!empty($frmCardNbrText)) {
    $sql .= "(cardsDB.cardnbr = '{$frmCardNbrText}'){$and}";
  }
  // CardSubNbr
  if (!empty($frmCardSubNbrText)) {
    $sql .= "(cardsDB.cardsubnbr = '{$frmCardSubNbrText}'){$and}";
  }
  // Player
  if (!empty($frmPlayerText)) {
    $sql .= "(cardsDB.playerID = '{$frmPlayerText}'){$and}";
  }
  // Player Name Ext
  if (!empty($frmPNEText)) {
    $sql .= "(cardsDB.playernameextID = '{$frmPNEText}'){$and}";
  }
  // Player Career
  if (!empty($frmCareerText)) {
    $sql .= "(Pla.career = '{$frmCareerText}'){$and}";
  }
  // Team
  if (!empty($frmTeamText)) {
    $sql .= "(cardsDB.teamID = '{$frmTeamText}'){$and}";
  }
  // SerialNbrd
  if (!empty($frmSerialNbrText)) {
    $sql .= "(cardsDB.serialnbr = '{$frmSerialNbrText}'){$and}";
  }
  // Autograph
  if (!empty($frmAutoText)) {
    $sql .= "(cardsDB.autograph = '{$frmAutoText}'){$and}";
  }
  // RookieCard
  if (!empty($frmRCText)) {
    $sql .= "(cardsDB.rookiecard = '{$frmRCText}'){$and}";
  }
  // Short Print
  if (!empty($frmSPText)) {
    $sql .= "(cardsDB.shortprint = \"{$frmSPText}\"){$and}";
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

if ($testmode) {
  $htmlcode .= "<p>"
            . $sql
            . "</p>\n"
            . "<br />\n"
  ;
  if ($testmode2) {
    $html_file_action = "A";
  }
  print_html ($htmlcode, $html_file_name, $html_file_action);
}

//jgm7 $htmlcode .= "<p>\$frmSportText = [{$frmSportText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmBrandText = [{$frmBrandText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmSeriesText = [{$frmSeriesText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmCategoryText = [{$frmCategoryText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmSubCategoryText = [{$frmSubCategoryText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmPlayerText = [{$frmPlayerText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmPNEText = [{$frmPNEText}]</p>\n";
//jgm7 $htmlcode .= "<p>\$frmTeamText = [{$frmTeamText}]</p>\n";

populateListboxText ($mysqli, "sport", "id", "name", $frmSportText);
populateListboxText ($mysqli, "brand", "id", "name", $frmBrandText);
populateListboxText ($mysqli, "series", "id", "name", $frmSeriesText);
populateListboxText ($mysqli, "category", "id", "name", $frmCategoryText);
populateListboxText ($mysqli, "subcategory", "id", "name", $frmSubCategoryText);
populateListboxText ($mysqli, "player", "id", "name", $frmPlayerText);
populateListboxText ($mysqli, "playernameext", "id", "extname", $frmPNEText);
populateListboxText ($mysqli, "team", "id", "name", $frmTeamText);

$lbSport = selectListboxRows ($mysqli, "sport", "id", "name", "cardsDB", "sportid", "colSelSport", "frmSportText", $frmSportText, TRUE);
$lbYear = selectDistinct ($mysqli, "cardsDB", "year", "year", "colSelYear", "frmYearText", $frmYearText, TRUE);
$lbBrand = selectListboxRows ($mysqli, "brand", "id", "name", "cardsDB", "brandid", "colSelBrand", "frmBrandText", $frmBrandText, TRUE);
$lbSeries = selectListboxRows ($mysqli, "series", "id", "name", "cardsDB", "seriesid", "colSelSeries", "frmSeriesText", $frmSeriesText, TRUE);
$lbCategory = selectListboxRows ($mysqli, "category", "id", "name", "cardsDB", "categoryid", "colSelCategory", "frmCategoryText", $frmCategoryText, TRUE);
$lbSubCategory = selectListboxRows ($mysqli, "subcategory", "id", "name", "cardsDB", "subcategoryid", "colSelSubCategory", "frmSubCategoryText", $frmSubCategoryText, TRUE);
$lbCardNbr = selectDistinct ($mysqli, "cardsDB", "cardnbr", "cardnbr", "colSelCardNbr", "frmCardNbrText", $frmCardNbrText, TRUE);
$lbCardSubNbr = selectDistinct ($mysqli, "cardsDB", "cardsubnbr", "cardsubnbr", "colSelCardSubNbr", "frmCardSubNbrText", $frmCardSubNbrText, FALSE);
$lbPlayer = selectListboxRows ($mysqli, "player", "id", "name", "cardsDB", "playerid", "colSelPlayer", "frmPlayerText", $frmPlayerText, TRUE);
$lbPNE = selectListboxRows ($mysqli, "playernameext", "id", "extname", "cardsDB", "playernameextID", "colSelPNE", "frmPNEText", $frmPNEText, TRUE);
$lbCareer = selectDistinct ($mysqli, "player", "career", "career", "colSelCareer", "frmCareerText", $frmCareerText, FALSE);
$lbTeam = selectListboxRows ($mysqli, "team", "id", "name", "cardsDB", "teamid", "colSelTeam", "frmTeamText", $frmTeamText, TRUE);
$lbSerialNbr = selectDistinct ($mysqli, "cardsDB", "serialnbr", "serialnbr", "colSelSerialNbr", "frmSerialNbrText", $frmSerialNbrText, FALSE);
$lbAutograph = selectDistinct ($mysqli, "cardsDB", "autograph", "autograph", "colSelAutograph", "frmAutoText", $frmAutoText, TRUE);
$lbRookieCard = selectDistinct ($mysqli, "cardsDB", "rookiecard", "rookiecard", "colSelRookieCard", "frmRCText", $frmRCText, FALSE);
$lbShortPrint = selectDistinct ($mysqli, "cardsDB", "shortprint", "shortprint", "colSelShortPrint", "frmSPText", $frmSPText, FALSE);

// TODO ??? don't perform query if there's a frmErrMsg ???
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  $htmlcode .= "\n";
  $htmlcode .= "<form method='post' action='"
            . htmlspecialchars ($_SERVER["PHP_SELF"])
            . "'>\n"
  ;
  $htmlcode .= "<h2>Displaying [cardsDB] table data - "
            . $mysqli->affected_rows
            . "<span class='frmError'>"
            . $frmErrMsg
            . "</span>"
            . " "
            . "<input type='submit' name='submit' value='Submit'></h2>\n"
  ;
           // <div class='HSB'>
  $htmlcode .= "
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
               <th>{$lbSport}</th>
               <th>{$lbYear}</th>
               <th>{$lbBrand}</th>
               <th>{$lbSeries}</th>
               <th>{$lbCategory}</th>
               <th>{$lbSubCategory}</th>
               <th>{$lbCardNbr}</th>
               <th>{$lbCardSubNbr}</th>
               <th>{$lbPlayer}</th>
               <th>{$lbPNE}<br />{$lbCareer}</th>
               <th>{$lbTeam}</th>
               <th>{$lbSerialNbr}</th>
               <th>{$lbAutograph}</th>
               <th>{$lbRookieCard}</th>
               <th>{$lbShortPrint}</th>
               <th></th>
               <th></th>
               <th></th>
             </tr>
          "
  ;
  $htmlcode .= "</form>\n";  
  while ($row = $result->fetch_object ()) {
    $htmlcode .= "
             <tr>
               <td class='center'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBid) . "<span class='tooltiptext'>cardsDB</span></div></td>
               <td class='center joinedColumn'>" . htmlspecialchars ($row->cardsDBsportID) . " (" . htmlspecialchars ($row->Sponame) . ")</td>
               <td class='center'>" . htmlspecialchars ($row->cardsDByear) . "</td>
               <td class='center joinedColumn'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBbrandID) . " (" . htmlspecialchars ($row->Braname) . ")<span class='tooltiptext'>brand</span></div></td>
               <td class='center joinedColumn'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBseriesID) . " (" . htmlspecialchars ($row->Sername) . ")<span class='tooltiptext'>series</span></div></td>
               <td class='center joinedColumn'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBcategoryID) . " (" . htmlspecialchars ($row->Catname) . ")<span class='tooltiptext'>category</span></div></td>
               <td class='center joinedColumn'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBsubcategoryID) . " (" . htmlspecialchars ($row->SuCatname) . ")<span class='tooltiptext'>subcategory</span></div></td>
               <td class='center'>" . htmlspecialchars ($row->cardsDBcardnbr) . "</td>
               <td class='center'>" . htmlspecialchars ($row->cardsDBcardsubnbr) . "</td>
               <td class='center joinedColumn'>" . htmlspecialchars ($row->cardsDBplayerID) . " (" . htmlspecialchars ($row->Planame) . ")</td>
               <td class='center joinedColumn'>[" . htmlspecialchars ($row->cardsDBplayernameextID) . "] (" . htmlspecialchars ($row->PNEextname) . ") (" . htmlspecialchars ($row->Placareer) . ")</div></td>
               <td class='center joinedColumn'>" . htmlspecialchars ($row->cardsDBteamID) . " (" . htmlspecialchars ($row->Teaname) . ")</td>
               <td class='center'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBserialnbr) . "<span class='tooltiptext'>serial numbered?</span></div></td>
               <td class='center'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBautograph) . "<span class='tooltiptext'>autographed?</span></div></td>
               <td class='center'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBrookiecard) . "<span class='tooltiptext'>rookie card?</span></div></td>
               <td class='center'><div class='tooltip'>" . htmlspecialchars ($row->cardsDBshortprint) . "<span class='tooltiptext'>short printed?</span></div></td>
               <td class='center joinedColumn'>" . htmlspecialchars ($row->cardsDBcommentsID) . " - " . htmlspecialchars ($row->Comdescription) . "</td>
               <td class='center'>" . htmlspecialchars ($row->cardsDBdateadded) . "</td>
               <td class='center'>" . htmlspecialchars ($row->cardsDBdateupdated) . "</td>
             </tr>
            "
    ;
  }
  $htmlcode .= "
           </table>
           </div>
          "
  ;
  $result->free_result ();
}

$endtime = getDateTime("Y/m/d H:i:s");

if ($testmode) { 
  $htmlcode .= "<br />\n<p>Start: {$starttime} --- End: {$endtime}</p>\n";
}

// TODO
$xxx = "delete me later";
$htmlcode .= html_end ($xxx);

if ($testmode2) {
  $html_file_action = "A";
}
print_html ($htmlcode, $html_file_name, $html_file_action);

?>

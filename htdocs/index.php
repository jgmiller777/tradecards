<?php

// TODO Review http://php.net/manual/en/function.error-reporting.php
// TODO for possible changes on how to report errors in a test environment
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
  printf ("<p>Starting up...</p>\n");
  // *** for now, timezone is set in php.ini file ***
  if (date_default_timezone_get()) {
    printf ("<p>date_default_timezone_set: "
          . date_default_timezone_get() . "</p>\n");
  }
}

// ***** open the connection and database *****--------------------------------------
include("../include/inc_mysqlconnect_tradecards.php");

// query and display the table ------------------------------------------------- user
$sql = "SELECT * FROM user ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [user] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>userID</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>user</span></div></td>
               <td>%s</td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->userID)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ------------------------------------------- collection
$sql = "SELECT
	  C.id            Cid
        , C.name          Cname
	, C.createdbyID   CcreatedbyID
        , U.userID        UuserID
        , C.private       Cprivate
        , C.date_added    Cdate_added
        , C.date_updated  Cdate_updated
        FROM collection C
        LEFT JOIN (user U)
          ON C.createdbyID = U.id
        ORDER BY C.name
       ";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [collection] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>created by</th>
               <th>private?</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>collection</span></div></td>
               <td>%s</td>
               <td>%s (%s)</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->Cid)
           , htmlspecialchars ($row->Cname)
           , htmlspecialchars ($row->CcreatedbyID)
           , htmlspecialchars ($row->UuserID)
           , htmlspecialchars ($row->Cprivate)
           , htmlspecialchars ($row->Cdate_added)
           , htmlspecialchars ($row->Cdate_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table --------------------------------------- usercollection
$sql = "SELECT
          UC.id           UCid
        , UC.userID       UCuserID
        , U.userid        Uuserid
        , UC.collectionID UCcollectionID
        , C.name          Cname
        , C.private       Cprivate
        , UC.date_added   UCdateadded
        , UC.date_updated UCdateupdated
        FROM usercollection UC
        LEFT JOIN (user U)
          ON UC.userID = U.id
        LEFT JOIN (collection C)
          ON UC.collectionID = C.id
        ORDER BY
          UC.userID
        , C.name
       ";

$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [usercollection] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>user</th>
               <th>collection</th>
               <th>private?</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>usercollection</span></div></td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->UCid)
           , htmlspecialchars ($row->UCuserID)
           , htmlspecialchars ($row->Uuserid)
           , htmlspecialchars ($row->UCcollectionID)
           , htmlspecialchars ($row->Cname)
           , htmlspecialchars ($row->Cprivate)
           , htmlspecialchars ($row->UCdateadded)
           , htmlspecialchars ($row->UCdateupdated)
    );
  }
  printf ("
           </table>
         "
  );
  $result->free_result ();
}

// query and display the table ------------------------------------------------ sport
$sql = "SELECT * FROM sport ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [sport] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>sport</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
          , htmlspecialchars ($row->id)
          , htmlspecialchars ($row->name)
          , htmlspecialchars ($row->date_added)
          , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ------------------------------------------------ brand
$sql = "SELECT * FROM brand ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [brand] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>brand</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
          , htmlspecialchars ($row->id)
          , htmlspecialchars ($row->name)
          , htmlspecialchars ($row->date_added)
          , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ----------------------------------------------- series
$sql = "SELECT * FROM series ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [series] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>series</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
          , htmlspecialchars ($row->id)
          , htmlspecialchars ($row->name)
          , htmlspecialchars ($row->date_added)
          , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table --------------------------------------------- category
$sql = "SELECT * FROM category ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [category] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>category</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
          , htmlspecialchars ($row->id)
          , htmlspecialchars ($row->name)
          , htmlspecialchars ($row->date_added)
          , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ------------------------------------------ subcategory
$sql = "SELECT * FROM subcategory ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [subcategory] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>subcategory</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
          , htmlspecialchars ($row->id)
          , htmlspecialchars ($row->name)
          , htmlspecialchars ($row->date_added)
          , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ----------------------------------------------- player
$sql = "SELECT * FROM player ORDER BY name";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [player] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>rookie year</th>
               <th>career</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>player</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->name)
           , htmlspecialchars ($row->rookie_yr)
           , htmlspecialchars ($row->career)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table --------------------------------- extended player name
$sql = "SELECT * FROM playernameext ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [playernameext] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>ext name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>ext name</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->extname)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ------------------------------------------------- team
$sql = "SELECT
          team.id             teamid
        , team.name           teamname
        , team.established_yr teamestablishedyr
        , team.sportID        teamsportID
        , S.name              Sname
        , team.priornameID    teampriornameID
        , T.name              Tname
        , team.date_added     teamdateadded
        , team.date_updated   teamdateupdated
        FROM team
        LEFT JOIN (sport S)
          ON team.sportID = S.id
        LEFT JOIN (team T)
          ON team.priornameid = T.id
        ORDER BY
          team.name
       ";

$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [team] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>established year</th>
               <th>sport</th>
               <th>prior name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>team</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center joinedColumn'>%s (%s)</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->teamid)
           , htmlspecialchars ($row->teamname)
           , htmlspecialchars ($row->teamestablishedyr)
           , htmlspecialchars ($row->teamsportID)
           , htmlspecialchars ($row->Sname)
           , htmlspecialchars ($row->teampriornameID)
           , htmlspecialchars ($row->Tname)
           , htmlspecialchars ($row->teamdateadded)
           , htmlspecialchars ($row->teamdateupdated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ---------------------------------------- cardcondition
$sql = "SELECT * FROM cardcondition ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [cardcondition] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>name</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>card condition</span></div></td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
          , htmlspecialchars ($row->id)
          , htmlspecialchars ($row->name)
          , htmlspecialchars ($row->date_added)
          , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table --------------------------------------------- comments
$sql = "SELECT * FROM comments ORDER BY id";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [comments] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>description</th>
               <th>date added</th>
               <th>date updated</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>comments</span></div></td>
               <td>%s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->id)
           , htmlspecialchars ($row->description)
           , htmlspecialchars ($row->date_added)
           , htmlspecialchars ($row->date_updated)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

// query and display the table ---------------------------------------------- cardsDB
//
// *** see displau_cardsDB.php for code
//

// query and display the table -------------------------------------------- inventory
$sql = "SELECT
          inv.id               invid
        , inv.usercollectionID invusercollectionID
        , UC.userID            UCuserID
        , USER.userID          USERuserID
        , UC.collectionID      UCcollectionID
        , COLL.name            COLLname
        , inv.cardsdbID        invcardsdbID
        , inv.cardconditionID  invcardconditionID
        , CC.name              CCname
        , inv.numberown        invnumberown
        , inv.purchasedate     invpurchasedate
        , inv.purchaseprice    invpurchaseprice
        , inv.serialnbr        invserialnbr
        , inv.commentsID       invcommentsID
        , COMM.description     COMMdescription
        , inv.date_added       invdateadded
        , inv.date_updated     invdateupdated
        , cDB.year             cDByear
        , cdbBR.name           cdbBRname
        , cdbSE.name           cdbSEname
        , cdbCA.name           cdbCAname
        , cdbSU.name           cdbSUname
        , cDB.cardnbr          cDBcardnbr
        , cDB.cardsubnbr       cDBcardsubnbr
        , cdbPL.name           cdbPLname
        , cdbPE.extname        cdbPEextname
        , cdbTE.name           cdbTEname
        , cdbCO.description    cdbCOdescription
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
        LEFT JOIN (cardsDB cDB)
                   LEFT JOIN (sport cdbSP)
                     ON cDB.sportID = cdbSP.id
                   LEFT JOIN (brand cdbBR)
                     ON cDB.brandID = cdbBR.id
                   LEFT JOIN (series cdbSE)
                     ON cDB.seriesID = cdbSE.id
                   LEFT JOIN (category cdbCA)
                     ON cDB.categoryID = cdbCA.id
                   LEFT JOIN (subcategory cdbSU)
                     ON cDB.subcategoryID = cdbSU.id
                   LEFT JOIN (player cdbPL)
                     ON cDB.playerID = cdbPL.id
                   LEFT JOIN (playernameext cdbPE)
                     ON cDB.playernameextID = cdbPE.id
                   LEFT JOIN (team cdbTE)
                     ON cDB.teamID = cdbTE.id
                   LEFT JOIN (comments cdbCO)
                     ON cDB.commentsID = cdbCO.id
          ON (inv.cardsdbID = cDB.id)
        ORDER BY 
          inv.id
       ";
$result = $mysqli->query ($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  printf ("\n");
  printf ("<h2>Displaying [inventory] table data - %d</h2>\n"
        , $mysqli->affected_rows);
  printf ("
           <table>
             <tr>
               <th>id</th>
               <th>usercollection</th>
               <th>cardsDBid</th>
               <th>card condition</th>
               <th>number own</th>
               <th>purchase date</th>
               <th>purchase price</th>
               <th>serial nbr</th>
               <th>comments</th>
               <th>date added</th>
               <th>date updated</th>
               <th>card info</th>
               <th>card comments</th>
             </tr>
          "
  );
  while ($row = $result->fetch_object ()) {
    printf ("
             <tr>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>inventory</span></div></td>
               <td class='center joinedColumn'>%s -> %s&nbsp;(%s) - %s&nbsp;(%s)</td>
               <td class='center'><div class='tooltip'>%s<span class='tooltiptext'>cardsDBid</span></div></td>
               <td class='center joinedColumn'>%s&nbsp;(%s)</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='right'>%s</td>
               <td class='center'>%s</td>
               <td class='center joinedColumn'>%s -> %s</td>
               <td class='center'>%s</td>
               <td class='center'>%s</td>
               <td class='center joinedColumn'>%s-%s-%s-%s-%s-%s%s-%s %s-%s</td>
               <td class='center joinedColumn'>%s</td>
             </tr>
            "
           , htmlspecialchars ($row->invid)
           , htmlspecialchars ($row->invusercollectionID)
           , htmlspecialchars ($row->UCuserID)
           , htmlspecialchars ($row->USERuserID)
           , htmlspecialchars ($row->UCcollectionID)
           , htmlspecialchars ($row->COLLname)
           , htmlspecialchars ($row->invcardsdbID)
           , htmlspecialchars ($row->invcardconditionID)
           , htmlspecialchars ($row->CCname)
           , htmlspecialchars ($row->invnumberown)
           , htmlspecialchars ($row->invpurchasedate)
           , htmlspecialchars ($row->invpurchaseprice)
           , htmlspecialchars ($row->invserialnbr)
           , htmlspecialchars ($row->invcommentsID)
           , htmlspecialchars ($row->COMMdescription)
           , htmlspecialchars ($row->invdateadded)
           , htmlspecialchars ($row->invdateupdated)
           , htmlspecialchars ($row->cDByear)
           , htmlspecialchars ($row->cdbBRname)
           , htmlspecialchars ($row->cdbSEname)
           , htmlspecialchars ($row->cdbCAname)
           , htmlspecialchars ($row->cdbSUname)
           , htmlspecialchars ($row->cDBcardnbr)
           , htmlspecialchars ($row->cDBcardsubnbr)
           , htmlspecialchars ($row->cdbPLname)
           , htmlspecialchars ($row->cdbPEextname)
           , htmlspecialchars ($row->cdbTEname)
           , htmlspecialchars ($row->cdbCOdescription)
    );
  }
  printf ("
           </table>
          "
  );
  $result->free_result ();
}

$endtime = getDateTime("Y/m/d H:i:s");

printf ("</br><p>Start: %s --- End: %s</p>\n"
        , $starttime
        , $endtime
       );

html_end ();

?>

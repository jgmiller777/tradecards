<?php

error_reporting (E_ALL);
$testmode = TRUE;

include("../include/inc_stuff.php");

$title = "Trading Cards Database";
$header = "DB Tables Creation";
$cssfile = "tradecards.css";
html_begin ($title, $header, $cssfile);

// +++++ open the connection and database +++++
include("../include/inc_mysqlconnect_tradecards.php");

if ($testmode) { printf ("<br />\n<p>Starting up...</p>\n<br />\n"); }

// +++++ create table ---------------------------------------------------------- user
//
$sql = "CREATE TABLE user (
    id               bigint unsigned not null auto_increment
  , userID           varchar(75)     not null
  , name             varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY (userID)
  , INDEX idxUserName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - user: %s</p>\n", $result);
}

// +++++ create table ---------------------------------------------------- collection
//
$sql = "CREATE TABLE collection (
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
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - collection: %s</p>\n", $result);
}

// +++++ create table ------------------------------------------------ usercollection
//
// This table links collection/s with a user.
// A user's card inventory will be stored under this key.
// 
$sql = "CREATE TABLE usercollection (
    id               bigint unsigned not null auto_increment
  , userID           bigint unsigned not null
  , collectionID     bigint unsigned not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxUserCollection (userID
                                , collectionID
                                 )
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - usercollection: %s</p>\n", $result);
}

// +++++ create table --------------------------------------------------------- sport
//
$sql = "CREATE TABLE sport (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxSportName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - sport: %s</p>\n", $result);
}

// +++++ create table --------------------------------------------------------- brand
//
$sql = "CREATE TABLE brand (
    id               bigint unsigned not null auto_increment
  , name             varchar(25)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxBrandName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - brand: %s</p>\n", $result);
}

// +++++ create table -------------------------------------------------------- series
//
$sql = "CREATE TABLE series (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxSeriesName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - series: %s</p>\n", $result);
}

// +++++ create table ----------------------------------------------------- category
//
$sql = "CREATE TABLE category (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxCategoryName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - category: %s</p>\n", $result);
}

// +++++ create table --------------------------------------------------- subcategory
//
$sql = "CREATE TABLE subcategory (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxSubcatName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - subcategory: %s</p>\n", $result);
}

// +++++ create table -------------------------------------------------------- player
//
$sql = "CREATE TABLE player (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , rookie_yr        year
  , career           varchar(75)
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxPlayerName (
                              name
                            , career
                             )
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - player: %s</p>\n", $result);
}

// +++++ create table ------------------------------------------ extended player name
//
$sql = "CREATE TABLE playernameext (
    id               bigint unsigned not null auto_increment
  , extname          varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxExtName (extname)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - playernameext: %s</p>\n", $result);
}

// +++++ create table ---------------------------------------------------------- team
//
$sql = "CREATE TABLE team (
    id               bigint unsigned not null auto_increment
  , name             varchar(100)    not null
  , established_yr   int unsigned    default null
  , sportID          bigint unsigned default null
  , priornameID      bigint unsigned default null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxTeamName (name)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - team: %s</p>\n", $result);
}

// +++++ create table ------------------------------------------------- cardcondition
$sql = "CREATE TABLE cardcondition (
    id               bigint unsigned not null auto_increment
  , name             varchar(75)     not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - cardcondition: %s</p>\n", $result);
}

// +++++ create table ------------------------------------------------------ comments
$sql = "CREATE TABLE comments (
    id               bigint unsigned not null auto_increment
  , description      text(500)       not null
  , date_added       datetime        not null
  , date_updated     datetime        not null
  , PRIMARY KEY (id)
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - comments: %s</p>\n", $result);
}

// +++++ create table ------------------------------------------------------- cardsDB
//
// Describes information about each card a user can track.
// This is just information about/describing a card; not used for actual tracking.
//
// TODO column for:
//
$sql = "CREATE TABLE cardsDB (
    id                 bigint unsigned not null auto_increment
  , sportID            bigint unsigned not null
  , year               year            not null
  , brandID            bigint unsigned not null
  , seriesID           bigint unsigned not null
  , categoryID         bigint unsigned not null
  , subcategoryID      bigint unsigned
  , cardnbr            varchar(20)     not null
  , cardsubnbr         varchar(20)
  , playerID           bigint unsigned
  , playernameextID    bigint unsigned
  , teamID             bigint unsigned
  , serialnbr          int(6)
  , autograph          varchar(1)
  , rookiecard         varchar(1)
  , shortprint         varchar(50)
  , commentsID         bigint unsigned
  , date_added         datetime        not null
  , date_updated       datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxCardsDBcard (
                               sportID
                             , year
                             , brandID
                             , seriesID
                             , categoryID
                             , subcategoryID
                             , cardnbr
                             , cardsubnbr
                             , playerID
                             , teamID
                             , serialnbr 
                             , autograph
                              )
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - cardsDB: %s</p>\n", $result);
}

// +++++ create table ----------------------------------------------------- inventory
//
// Stores user's cards they want to track
// Two keys to this table:
//      id                           - unique identifer
//      usercollectionID / cardsdbID / cardcondition
//                                   - per user, organizes cards by user's collection
//
// TODO: need to make field 'numberown' a float type so that partial card values (like
//       .50, .33, .34, .25, etc.) can be entered
// TODO column for:
//      want to sell
//      want to trade out
//      want to buy
//      want to trade in
// 
$sql = "CREATE TABLE inventory (
    id                 bigint unsigned not null auto_increment
  , usercollectionID   bigint unsigned not null
  , cardsdbID          bigint unsigned not null
  , cardconditionID    bigint unsigned
  , numberown          int(4)
  , purchasedate       date
  , purchaseprice      float(10,2)
  , serialnbr          varchar(10)
  , commentsID         bigint unsigned
  , date_added         datetime        not null
  , date_updated       datetime        not null
  , PRIMARY KEY (id)
  , UNIQUE KEY idxInventoryCard (usercollectionID
                               , cardsdbID
                               , cardconditionID
                                )
)";

// execute the SQL statement
$result = $mysqli->query($sql);
if (!$result) {
  showMySQLerror ($mysqli);
} else {
  // echo the result identifier
  printf ("<p>Table - inventory: %s</p>\n", $result);
}

html_end ();

?>

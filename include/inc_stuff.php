<?php

// TODO need this line?  i think i was just testing a concept that I abandoned
// $TABLEBORDERCOLOR = "blue";

// O'Reilly "PHP and MySQL", 2nd ed., pages 183-184
//-----------------------------------------------------------------------------------
/* If we had chosen to name our include files with the .inc extension then a security
   problem is presented.  If the user requests the file, the source of the file is
   shown in the browser.  This may expose the username and password for the server,
   the source code, the database structure, and other details that should be secure.

   If the extensioin .php is used instead of .inc the require file is processed by
   the PHP script engine and produces no output because it contains no main body.
   This is the best approach if you're in a shared hosting environment and can't
   change Apache's configuration.
 */

//-------------------------------------------------------------------------------
function getDateTime ($dtFmt = "Y/m/d H:i:s T", 
                      $dtWhen = "now", 
                      $dtTZ = "America/Chicago") {
  // date_default_timezone_set (date_default_timezone_get());
  // date_default_timezone_set ($dtTZ);
  // if ($testmode) { printf ("<p>%s</p>\n", date_default_timezone_get()); }
  $date = new DateTime ($dtWhen);
  return ($date->format($dtFmt));
}

//-----------------------------------------------------------------------------------
function quote_value ($str) {
  if (!isset ($str))
    return ("NULL");
  if (function_exists ("$mysqli->real_escape_string"))
    return ("'" . $mysqli->real_escape_string ($str) . "'");
  if (function_exists ("$mysqli->escape_string"))
    return ("'" . $mysqli->escape_string ($str) . "'");
  return ("'" . addslashes ($str) . "'");
}

//-----------------------------------------------------------------------------------
function showMySQLerror ($mysqli) {
// O'Reilly "PHP and MySQL", 2nd ed., page 177
  printf ("<p>sql error:  " . $mysqli->errno . " : " . $mysqli->error . "</p>\n");
}

//-------------------------------------------------------------------------------
function selectDistinct ($connection,
                         $tableName,
                         $attributeValue,
                         $attributeName,
                         $className,
                         $pulldownName,
                         $defaultValue) {

  // -------------------------------------------------------------------------------------
  // O'Reilly "PHP and MySQL", 2nd ed., pages 184-188
  // -------------------------------------------------------------------------------------
  // Another possible way to implement this is with HTML 5's 'list/datalist' input type
  // It seems to support 'size=' styling.
  // However, via CSS I might be able to "size" a 'select' element
  // -------------------------------------------------------------------------------------

  // printf ("[%s]   [%s]   [%s]   [%s]   [%s]   [%s]<br />\n", $tableName, $attributeValue, $attributeName, $className, $pulldownName, $defaultValue);

  $HTMLSelect = "";
  
  $defaultWithinResultSet = FALSE;

  // Query to find distinct values of $attributeName in $tableName
  // TODO enhance function to store which entry in $tableName is $defaultValue
  $distinctQuery = 
     "SELECT DISTINCT "
    . $attributeName
    . " FROM "
    . $tableName
    . " ORDER BY "
    . $attributeName
  ;

  // Run the $distinctQuery on the $connection
  $resultId = $connection->query($distinctQuery, MYSQLI_USE_RESULT);
  if (!$resultId) {
    die (showMySQLerror ($connection));
  }

  // Start the select widget
  $HTMLSelect .= 
     "<select class='"
    . $className
    . "' name='"
    . $pulldownName
    . "'>\n"
  ;

  // Retrieve each row from the query
  while ($row = $resultId->fetch_object()) {
    // Get the value/text for the attribute to be displayed
    $resultValue = htmlspecialchars ($row->$attributeValue);
    $resultText  = htmlspecialchars ($row->$attributeName);

    // Check if a $defaultValue is set and, if so, is it the current db value?
    if (isset($defaultValue) && $resultText == $defaultValue) {
      // Yes, show as selected
      $HTMLSelect .=
          "\t<option selected='selected' value='"
        . $resultValue
        . "'>"
        . $resultText
        . "</option>\n"
      ;
    } else {
      // No, just show as an option
      $HTMLSelect .=
          "\t<option value=\""
        . $resultValue
        . "\">"
        . $resultText
        . "</option>\n"
      ;
    }
  }
  $HTMLSelect .= ("</select>\n");
  return ($HTMLSelect);
}
//jgm
//jgm//-------------------------------------------------------------------------------
//jgmfunction shellclean ($array, 
//jgm                     $index, 
//jgm                     $maxlength) {
//jgm  // O'Reilly "PHP and MySQL", 2nd ed., page 200
//jgm  if (isset ($array["{$index}"])) {
//jgm    $input = substr ($array ["{$index}"], 0, $maxlength);
//jgm    $input = EscapeShellArg ($input);
//jgm    return ($input);
//jgm  }
//jgm  return NULL;
//jgm}
//jgm
//jgm//-------------------------------------------------------------------------------
//jgmfunction mysqlclean ($array, 
//jgm                     $index, 
//jgm                     $maxlength) {
//jgm  // O'Reilly "PHP and MySQL", 2nd ed., page 202
//jgm  if (isset ($array["{$index}"])) {
//jgm    $input = substr ($array["{$index}"], 0, $maxlength);
//jgm  if (function_exists ("mysqli_real_escape_string"))
//jgm    return (mysqli_real_escape_string ($input));
//jgm  if (function_exists ("mysqli_escape_string"))
//jgm    return (mysqli_escape_string ($input));
//jgm  }
//jgm  return NULL;
//jgm}

//-----------------------------------------------------------------------------------
function html_output (&$htmlcode
                    ,  $html_file_name
                    ,  $html_file_action) {
//
  printf ("%s", $htmlcode);

  switch ($html_file_action) {
    case "I":
      if (!($fh = fopen ($html_file_name, "wt"))) {
        printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $html_file_name);
        // exit (1);
      } else {
        if (!(fwrite ($fh, $htmlcode))) {
          printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $html_file_name);
          // exit (1);
        } else {
          if (!(fclose ($fh))) {
            printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $html_file_name);
            // exit (1);
          } else {
            // printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
          }
        }
      }
      break;
    case "A":
      if (!($fh = fopen ($html_file_name, "at"))) {
        printf ("<p class='fopen-error'>Cannot open %s.</p>\n", $html_file_name);
        // exit (1);
      } else {
        if (!(fwrite ($fh, $htmlcode))) {
          printf ("<p class='fwrite-error'>Cannot write %s.</p>\n", $html_file_name);
          // exit (1);
        } else {
          if (!(fclose ($fh))) {
            printf ("<p class='fclose-error'>Cannot close %s.</p>\n", $html_file_name);
            // exit (1);
          } else {
            // printf ("<h3 class='filebackup'>%s closed!</h3>\n", $filename);
          }
        }
      }
      break;
    case "X":
      // fall through to default
    default:
      // don't write to fie
  }

  $htmlcode = "";
}

//-----------------------------------------------------------------------------------
function html_begin ( $title
                   ,  $header
                   ,  $cssfile
                   ,  $htmlcode) {
//
// TODO change to strict XML
//
// See https://www.w3schools.com/css/css_icons.asp for more info on the following
//    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
//    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
//    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
// when I actually added these lines after my css link below, the display of my
// tables from index.php changed.  interesting!
//
$htmlstr = "
\n
<!DOCTYPE html>
<html>
  <head>
    <title>" . $title . "</title>
    <link rel='stylesheet' type='text/css' href='" . $cssfile . "'>
  </head>
  <body>
\n
";
if (empty($htmlcode)) {
  printf ("%s", $htmlstr);
} else {
  return ($htmlstr);
}

return NULL;

}

//-----------------------------------------------------------------------------------
function html_end ( $htmlcode) {

$htmlstr = "
  </body>
</html>
\n
";
if (empty($htmlcode)) {
  printf ("%s", $htmlstr);
} else {
  return ($htmlstr);
}

return NULL;
}

//-----------------------------------------------------------------------------------
?>

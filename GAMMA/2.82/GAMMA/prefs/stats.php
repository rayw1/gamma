<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
if($valid != 1)
{
	die( "INVALID SESSION" );
}
if($admin < 1)
{
	die( "ADMIN TOO LOW" );
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `statistics` WHERE `Database` = '$office'";

$result = mysql_query($sql);

if($result == 0)
{
	log_error("Could not select from statistics: $sql", "stats.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not get your preferences");
}

echo( "<h1>Statistics Preferences</h1>" );
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<form method = \"post\" action=\"stats_change.php\">" );
$row = mysql_fetch_array($result);
echo( "<tr><td>Display Name:</td><td><input class=\"blue\" type=\"text\" name = \"display\" value = \"" );
echo( $row["DisplayName"] );
echo( "\"></td></tr>
<tr><td>Color:</td><td><select name = \"color\"><option value = \"" );
echo( $row["Color"] );
echo( "\" selected>" . $row["Color"] . "</option>" );
echo( "<option value = \"black\">Black</option>" );
echo( "<option value = \"blue\">Blue</option>" );
echo( "<option value = \"blue_gray\">Blue Gray</option>" );
echo( "<option value = \"brown\">Brown</option>" );
echo( "<option value = \"dark_blue\">Dark Blue</option>" );
echo( "<option value = \"dark_green\">Dark Green</option>" );
echo( "<option value = \"gray\">Gray</option>" );
echo( "<option value = \"green\">Green</option>" );
echo( "<option value = \"orange\">Orange</option>" );
echo( "<option value = \"pink\">Pink</option>" );
echo( "<option value = \"purple\">Purple</option>" );
echo( "<option value = \"red\">Red</option>" );
echo( "<option value = \"tan\">Tan</option>" );
echo( "<option value = \"yellow\">Yellow</option>" );
echo( "</select></td></tr>" );
$address = $row["Address"];
$bad = array("<br>", "<br />");
$good  = "";

$address = str_replace($bad, $good, $address);

echo( "<tr><td>Address:</td><td><textarea name=\"address\" cols=\"25\" rows=\"5\">");
echo( $address );
echo( "</textarea></td></tr>" );

echo( "<tr><td>Phone:</td><td><input class=\"blue\" name=\"phone\" value=\"" );
echo( $row["Phone"] );
echo( "\" size=\"15\"></td></tr>" );

echo( "<tr><td></td><td><input type=\"Button\" value=\"Submit Changes\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></center></td></tr></table></form>" );
?>

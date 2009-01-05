<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$num = mysql_real_escape_string($_GET["fid"]);

$sql = "SELECT * FROM `farmers` WHERE `Number` = '$num'";

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Farmers List Select Failure: $sql2", "farmerslist_edit.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain record");
}
else
{
	echo( "<h1>Farmers Record Edit</h1>" );
}

while($row = mysql_fetch_array($itemList))
{
	echo( "<form method=\"post\" action=\"farmerslist_update.php\">" );
	echo( "<input type=\"hidden\" name=\"number\" value=\"");
	echo( $num );
	echo( "\">Name: <input class=\"blue\" type=\"text\" name=\"name\" value=\"" );
	echo( $row["Name"] );
	echo( "\"><br>" );
	echo( "Location: <input class=\"blue\" type=\"text\" name=\"location\" value=\"" );
	echo( $row["Location"] );
	echo( "\"><br>" );
	echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
	echo( "</form>" );
}

?>
